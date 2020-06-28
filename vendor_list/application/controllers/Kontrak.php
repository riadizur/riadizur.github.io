<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('referensim');
		$this->load->model('kontrakm');
		$this->load->library(array('PHPExcel', 'PHPExcel/IOFactory'));
		date_default_timezone_set('Asia/Jakarta');
	}

	public function entri()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['prov_list'] = $this->referensim->get_prov();
			$datax['list_jenis'] = $this->referensim->get_jenis_penyediaan();
			$datax['list_pengadaan'] = $this->referensim->get_list_pengadaan();
			$datax['list_user'] = $this->referensim->get_user_tim();

			$this->load->view('kontrak/entri', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function get_chain_kab($id)
	{
		$data_id = $this->referensim->get_chain_kab($id);
		echo json_encode($data_id);
	}

	public function get_chain_kec($id)
	{
		$data_id = $this->referensim->get_chain_kec($id);
		echo json_encode($data_id);
	}

	public function kontrak_add()
	{
		$this->validasi_inputan();

		$datax = array();
		$datax['error_string'] = array();
		$datax['inputerror'] = array();
		$datax['status'] = TRUE;

		$data_list = array();
		$a = $this->kontrakm->get_tvd_all();
		foreach ($a as $r) {
			if ($r->COLUMN_NAME == 'no_reg_pekerjaan') {
				$id_1 = substr($this->input->post($r->COLUMN_NAME), 0, 9);
				$last = $this->kontrakm->count_all();
				$rand = mt_rand(0, 9);
				switch (strlen($last)) {
					case '1':
						$id_2 = '0' . $last . $rand;
						break;
					case '2':
						$id_2 = $last . $rand;
						break;
				}
				$id_vds = $id_1 . $id_2;
				$data_list[$r->COLUMN_NAME] = $id_vds;
			} elseif ($r->COLUMN_NAME == 'nilai_oe') {
				$data_list[$r->COLUMN_NAME] = str_replace(',', '', $this->input->post($r->COLUMN_NAME));
			} else {
				$data_list[$r->COLUMN_NAME] = $this->input->post($r->COLUMN_NAME);
			}
		}
		$data_list['nama_pic'] = $this->input->post('nama_pic');
		//data bidang
		$b = $this->input->post('last_bidang');
		if ($b <> '') {
			for ($i = 1; $i <= $b; $i++) {
				$nama_b = "list_bidang_" . $i;
				if ($this->input->post($nama_b) <> '') {
					//output : siup-1,siup-2
					$arr_bidang[] = $this->input->post($nama_b);
				}
			}
			$data_list['bidang_pekerjaan'] = join(",", $arr_bidang);
		}
		//data sub bidang
		$c = $this->input->post('last_sub_bidang');
		if ($c <> '') {
			for ($i = 1; $i <= $c; $i++) {
				$nama_c = "list_sub_bidang_" . $i;
				if ($this->input->post($nama_c) <> '') {
					//output : BG001,BG002
					$arr_sub_bidang[] = $this->input->post($nama_c);
				}
			}
			$data_list['sub_bidang_pekerjaan'] = join(",", $arr_sub_bidang);
		}

		if ($datax['status'] === FALSE) {
			echo json_encode($datax);
			exit();
		}

		$insert_data = $this->referensim->save('treg_pekerjaan', $data_list);
		echo json_encode(array("status" => TRUE));
	}

	public function kontrak_add_sub_bidang()
	{
		$a = $this->input->post('last_bidang');
		if ($a <> '') {
			for ($i = 1; $i <= $a; ++$i) {
				$nama = 'list_bidang_' . $i;
				if ($this->input->post($nama) <> '') {
					$string = $this->input->post($nama);;
					$arr = explode("-", $string, 2);
					$first = $arr[0];
					$last = $arr[1];
					$data_list[] = $last;
				}
			}
			$dicari = join("','", $data_list);
			switch ($first) {
				case 'siup':
					$hasil = $this->kontrakm->get_kbli_kategori($dicari);
					foreach ($hasil as $r) {
						$ambil[] = $r->kode;
					}
					$ditampil = join("','", $ambil);
					$data_all = $this->kontrakm->get_kbli_detil($ditampil);
					break;
				case 'siujk':
					$hasil = $this->kontrakm->get_siujk_klasifikasi($dicari);
					foreach ($hasil as $r) {
						$ambil[] = $r->kode;
					}
					$ditampil = join("','", $ambil);
					$data_all = $this->kontrakm->get_siujk_detil($ditampil);
					break;
			}
		}
		echo json_encode($data_all);
	}

	private function validasi_inputan()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$tabel = $this->kontrakm->get_tvd_all();
		foreach ($tabel as $k) {
			$cek = substr($k->COLUMN_NAME, 0, 4);
			if ($cek == 'file') {
				if (empty($_FILES[$k->COLUMN_NAME]['name'])) {
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'File tidak boleh kosong';
					$data['status'] = FALSE;
				}
			} else {
				if ($this->input->post($k->COLUMN_NAME) == '') {
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'Tidak boleh kosong';
					$data['status'] = FALSE;
				}
			}
		}

		if ($this->input->post('nama_pic') == '') {
			$data['inputerror'][] = 'nama_pic';
			$data['error_string'][] = 'Harus diisi!';
			$data['status'] = FALSE;
		}

		if ($data['status'] === FALSE) {
			echo json_encode($data);
			exit();
		}
	}

	private function validasi_upload($files, $ids)
	{
		$config['upload_path']          = 'upload/';
		$config['allowed_types']        = 'gif|jpg|png|doc|docx|pdf|xls|xlsx|txt|rar|zip';
		$config['max_size']             = 1000000; //set max size allowed in Kilobyte
		$config['max_width']            = 5000; // set max width image allowed
		$config['max_height']           = 5000; // set max height allowed
		$config['file_name']            = $ids . "-" . round(microtime(true) * 1000);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload($files)) {
			$data['inputerror'][] = $files;
			$data['error_string'][] = 'Gagal Upload: ' . $this->upload->display_errors('', '');
			$data['status'] = FALSE;
			echo json_encode($data);
			exit();
		}
		return $this->upload->data('file_name');
	}

	public function daftar_kontrak()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['prov_list'] = $this->referensim->get_prov();
			$datax['list_klasifikasi'] = $this->referensim->get_jenis_penyediaan();
			$datax['list_pengadaan'] = $this->referensim->get_list_pengadaan();
			$datax['list_user'] = $this->referensim->get_list_user_bos();

			$this->load->view('kontrak/daftar_kontrak', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function kontrak_list()
	{
		$list = $this->kontrakm->get_datatables_kontrak();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->no_reg_pekerjaan;
			$row[] = $pelayanan->nama_pekerjaan;
			$row[] = number_format($pelayanan->nilai_oe, 2);
			$row[] = $pelayanan->divisi;
			$row[] = $pelayanan->metode_pengadaan;
			if (!$pelayanan->no_kontrak) {
				$row[] = '- Belum ada -';
			} else {
				$row[] = $pelayanan->no_kontrak;
			}
			$row[] = $this->status_kontrak($pelayanan->no_reg_pekerjaan);
			$row[] = "-";
			/*
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_cust('."'".$pelayanan->id."'".')"><i class="glyphicon glyphicon-edit"></i></a>
					<a class="btn btn-sm btn-warning" href="javascript:void(0)" title="Update" onclick="edit_cust('."'".$pelayanan->id."'".')"><i class="glyphicon glyphicon-share"></i> </a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_cust('."'".$pelayanan->id."'".')"><i class="glyphicon glyphicon-trash"></i> </a>';
				  */
			$data[] = $row;
		}
		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->kontrakm->count_all(),
			"recordsFiltered" => $this->kontrakm->count_filtered(),
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function status_kontrak($id)
	{
		$cek_sts = $this->kontrakm->get_status_kontrak($id);
		if ($cek_sts->tgl_create_daftar_undang == '') {
			return 'Registrasi Pekerjaan';
		} elseif ($cek_sts->tgl_anwizing == '') {
			return 'Proses Undangan';
		} elseif ($cek_sts->tgl_penawaran == '') {
			return 'Proses Aanwijzing';
		} elseif ($cek_sts->tgl_penetapan == '') {
			return 'Proses Pemasukan Penawaran';
		} else {
			return 'Penetapan Pemenang';
		}
	}

	public function get_undang()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_kontrak($_GET['term'], 'tgl_create_daftar_undang');
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_reg_pekerjaan . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_kontrak($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['nilai_oe'] = $r->nilai_oe;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;

			$pilah_1 = explode(',', $r->bidang_pekerjaan);
			foreach ($pilah_1 as $row) {
				list($izin, $id_urut) = explode('-', $row);
				switch ($izin) {
					case 'siup':
						$data_bidang[] = $this->referensim->get_kbli_kategori_detilan($id_urut)->isi;
						break;
					case 'siujk':
						$data_bidang[] = $this->referensim->get_siujk_klasifikasi_detilan($id_urut)->isi;
						break;
				}
			}
			$data_all['bidang_pekerjaan'] = join("\n", $data_bidang);

			$pilah_2 = explode(',', $r->sub_bidang_pekerjaan);
			$data_all['id_sub_bidang_pekerjaan'] = $r->sub_bidang_pekerjaan;
			foreach ($pilah_2 as $row) {
				switch ($izin) {
					case 'siup':
						$data_sub_bidang[] = $this->referensim->get_kbli_detil_kode($row)->deskripsi;
						break;
					case 'siujk':
						$data_sub_bidang[] = $this->referensim->get_siujk_detil_kode($row)->deskripsi;
						break;
				}
			}
			$data_all['sub_bidang_pekerjaan'] = join("\n", $data_sub_bidang);
		}
		echo json_encode($data_all);
	}

	public function undang_klasifikasi($cari_klasifikasi = '')
	{
		$data_penyediaanx = $this->kontrakm->get_data_penyediaan(str_replace('%20', ' ', $cari_klasifikasi));

		if (strpos($data_penyediaanx->uraian, 'Konstruksi') !== false) {
			$data_all = $this->kontrakm->get_data_grade($data_penyediaanx->klasifikasi, 'konstruksi');
		} elseif (strpos($data_penyediaanx->uraian, 'Konsultansi') !== false) {
			$data_all = $this->kontrakm->get_data_grade($data_penyediaanx->klasifikasi, 'konsultansi');
		} else {
			$data_all = $this->kontrakm->get_data_grade($data_penyediaanx->klasifikasi, 'perdagangan');
		}

		echo json_encode($data_all);
	}

	public function bidang_pekerjaan($cari_klasifikasi = '')
	{
		$data_penyediaanx = $this->kontrakm->get_data_penyediaan(str_replace('%20', ' ', $cari_klasifikasi));
		switch ($data_penyediaanx->klasifikasi) {
			case 'siup':
				$data_all = $this->referensim->get_kbli_kategori();
				break;
			case 'siujk':
				$data_all = $this->referensim->get_siujk_klasifikasi();
				break;
		}

		echo json_encode($data_all);
	}

	function bidang_pekerjaan_detil($cari = '')
	{
		list($first, $last) = explode('-', $cari);
		switch ($first) {
			case 'siup':
				$data_all = $this->referensim->get_kbli_kategori_detil($last);
				break;
			case 'siujk':
				$data_all = $this->referensim->get_siujk_klasifikasi_detil($last);
				break;
		}
		echo json_encode($data_all);
	}

	function filter_undang($izinx = '', $bidangx = '', $pilihx = '', $nilai_oex = '')
	{
		$bidang = str_replace("%20", "','", $bidangx);
		$pilih = str_replace("%20", "','", $pilihx);

		if ($pilih <> 'x') {
			$data_all = $this->kontrakm->get_undang_grade($izinx, $bidang, $pilih);
		} else {
			$data_all = $this->kontrakm->get_undang($izinx, $bidang, $nilai_oex);
		}

		echo json_encode($data_all);
	}

	var $vendor_diundang = array();
	public function add_undang()
	{
		$data_list['no_reg_pekerjaan'] = $this->input->post('cari_id');

		$izinx = $this->input->post('tipe_grade');
		$bidang = str_replace(",", "','", $this->input->post('id_sub_bidang_pekerjaan'));
		$pilihx = $this->input->post('pilih_grade');
		$nilai_oex = $this->input->post('nilai_oex');

		if ($pilihx <> '') {
			$pilih = str_replace(" ", "','", $pilihx);
			$data_all = $this->kontrakm->get_undang_grade($izinx, $bidang, $pilih);
		} else {
			$data_all = $this->kontrakm->get_undang($izinx, $bidang, $nilai_oex);
		}

		foreach ($data_all as $r) {
			$data_list['id_vd'] = $r->id_vd;
			$data_list['undang'] = '1';
			$insert_data_undang = $this->referensim->save('ttransaksi', $data_list);
		}

		$data_update['tgl_create_daftar_undang'] = date("Y-m-d");
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $this->input->post('cari_id')), $data_update);

		echo json_encode(array("status" => TRUE));
	}

	public function excell_undang($nr_job = '', $izinx = '', $bidangx = '', $pilihx = '', $nilai_oex = '')
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');

		$bidang = str_replace("%20", "','", $bidangx);

		if ($pilihx <> 'x') {
			$pilih = str_replace("%20", "','", $pilihx);
			$data_all = $this->kontrakm->get_undang_grade($izinx, $bidang, $pilih);
		} else {
			$data_all = $this->kontrakm->get_undang($izinx, $bidang, $nilai_oex);
		}

		$q = "select no_reg_pekerjaan, nama_pekerjaan, lokasi_pekerjaan from treg_pekerjaan where no_reg_pekerjaan = '$nr_job' ";
		$h = $this->db->query($q)->row();

		$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);

		$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:H1')
			->setCellValue('A1', 'DAFTAR UNDANGAN')
			->mergeCells('A2:H2')
			->setCellValue('A2', strtoupper($h->nama_pekerjaan))
			->setCellValue('A3', 'NILAI OE')
			->mergeCells('B3:H3')
			->setCellValue('B3', ': Rp. ' . number_format($nilai_oex, 2))
			->setCellValue('A4', 'NO. REG')
			->mergeCells('B4:H4')
			->setCellValue('B4', ': ' . $nr_job)
			->setCellValue('A6', 'NO')
			->setCellValue('B6', 'ID VENDOR')
			->setCellValue('C6', 'NAMA PESERTA')
			->setCellValue('D6', 'ALAMAT')
			->setCellValue('E6', 'GRADE')
			->setCellValue('F6', 'PIC')
			->setCellValue('G6', 'EMAIL')
			->setCellValue('H6', 'NO HP');


		$ex = $objPHPExcel->setActiveSheetIndex(0);
		$counter = 7;

		foreach ($data_all as $row) :
			$id_vdx = $row->id_vd;
			$sql = "select id_vd, nama_pt, alamat_pt, nama_pic, email_pic, no_hp_pic from tvd_list where id_vd = '$id_vdx' ";
			$hasil = $this->db->query($sql)->row();

			$ex->setCellValue('A' . $counter, ($counter - 6));
			$ex->setCellValue('B' . $counter, $row->id_vd);
			$ex->setCellValue('C' . $counter, strtoupper($row->nama_pt));
			$ex->setCellValue('D' . $counter, strtoupper($hasil->alamat_pt));
			$ex->setCellValue('E' . $counter, $row->grade);
			$ex->setCellValue('F' . $counter, strtoupper($hasil->nama_pic));
			$ex->setCellValue('G' . $counter, $hasil->email_pic);
			$ex->setCellValue('H' . $counter, $hasil->no_hp_pic);

			$counter = $counter + 1;
		endforeach;

		$center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objPHPExcel->getActiveSheet()->getStyle("A1:H2")->applyFromArray($center);
		$objPHPExcel->getActiveSheet()->getStyle("A1:H6")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A6:H" . $counter)->applyFromArray($borders);

		$objPHPExcel->getProperties()->setCreator("VENDOR_LIST_EPI")
			->setLastModifiedBy("VENDOR_LIST_EPI")
			->setTitle("DAFTAR ")
			->setSubject("DAFTAR_UNDANGAN")
			->setDescription("DAFTAR by APLIKASI VENDOR LIST.")
			->setKeywords("office 2007 openxml php")
			->setCategory("DAFTAR_UNDANGAN");
		$objPHPExcel->getActiveSheet()->setTitle('DAFTAR_UNDANGAN');
		$TitlE 		= "DAFTAR PESERTA";
		$namafile	= str_replace(' ', '_', $TitlE);
		$objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
		header('Chace-Control: no-store, no-cache, must-revalation');
		header('Chace-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $namafile . '.xlsx"');

		$objWriter->save('php://output');
	}

	public function get_anwizing()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_anwizing($_GET['term'], 'tgl_anwizing');
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_reg_pekerjaan . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_anwizing($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['nilai_oe'] = $r->nilai_oe;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;
		}
		echo json_encode($data_all);
	}

	public function daftar_anwizing($cari_id = '')
	{
		$data_all = $this->kontrakm->get_peserta_anwizing($cari_id);
		echo json_encode($data_all);
	}

	public function add_anwizing($id = '', $hasil = '')
	{
		$hasilx = explode("%20", $hasil);
		foreach ($hasilx as $id_vd) {
			$data_transaksi['anwizing'] = '1';
			$update_anwizing = $this->referensim->update('ttransaksi', array('no_reg_pekerjaan' => $id, 'id_vd' => $id_vd), $data_transaksi);
		}

		$data_update['tgl_anwizing'] = date("Y-m-d");
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $id), $data_update);

		echo json_encode(array("status" => TRUE));
	}

	public function excell_anwizing($no_reg = '', $hasil = '')
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');

		$bidang = str_replace("%20", "','", $bidangx);

		if ($pilihx <> 'x') {
			$pilih = str_replace("%20", "','", $pilihx);
			$data_all = $this->kontrakm->get_undang_grade($izinx, $bidang, $pilih);
		} else {
			$data_all = $this->kontrakm->get_undang($izinx, $bidang, $nilai_oex);
		}

		$q = "select no_reg_pekerjaan, nama_pekerjaan, lokasi_pekerjaan from treg_pekerjaan where no_reg_pekerjaan = '$nr_job' ";
		$h = $this->db->query($q)->row();

		$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);

		$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:H1')
			->setCellValue('A1', 'DAFTAR UNDANGAN')
			->mergeCells('A2:H2')
			->setCellValue('A2', strtoupper($h->nama_pekerjaan))
			->setCellValue('A3', 'NILAI OE')
			->mergeCells('B3:H3')
			->setCellValue('B3', ': Rp. ' . number_format($nilai_oex, 2))
			->setCellValue('A4', 'NO. REG')
			->mergeCells('B4:H4')
			->setCellValue('B4', ': ' . $nr_job)
			->setCellValue('A6', 'NO')
			->setCellValue('B6', 'ID VENDOR')
			->setCellValue('C6', 'NAMA PESERTA')
			->setCellValue('D6', 'ALAMAT')
			->setCellValue('E6', 'GRADE')
			->setCellValue('F6', 'PIC')
			->setCellValue('G6', 'EMAIL')
			->setCellValue('H6', 'NO HP');

		$ex = $objPHPExcel->setActiveSheetIndex(0);
		$counter = 7;

		foreach ($data_all as $row) :
			$id_vdx = $row->id_vd;
			$sql = "select id_vd, nama_pt, alamat_pt, nama_pic, email_pic, no_hp_pic from tvd_list where id_vd = '$id_vdx' ";
			$hasil = $this->db->query($sql)->row();

			$ex->setCellValue('A' . $counter, ($counter - 6));
			$ex->setCellValue('B' . $counter, $row->id_vd);
			$ex->setCellValue('C' . $counter, strtoupper($row->nama_pt));
			$ex->setCellValue('D' . $counter, strtoupper($hasil->alamat_pt));
			$ex->setCellValue('E' . $counter, $row->grade);
			$ex->setCellValue('F' . $counter, strtoupper($hasil->nama_pic));
			$ex->setCellValue('G' . $counter, $hasil->email_pic);
			$ex->setCellValue('H' . $counter, $hasil->no_hp_pic);

			$counter = $counter + 1;
		endforeach;

		$center = array(
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
		$borders = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN
				)
			)
		);

		$objPHPExcel->getActiveSheet()->getStyle("A1:H2")->applyFromArray($center);
		$objPHPExcel->getActiveSheet()->getStyle("A1:H6")->getFont()->setBold(true);
		$objPHPExcel->getActiveSheet()->getStyle("A6:H" . $counter)->applyFromArray($borders);

		$objPHPExcel->getProperties()->setCreator("VENDOR_LIST_EPI")
			->setLastModifiedBy("VENDOR_LIST_EPI")
			->setTitle("DAFTAR ")
			->setSubject("DAFTAR_UNDANGAN")
			->setDescription("DAFTAR by APLIKASI VENDOR LIST.")
			->setKeywords("office 2007 openxml php")
			->setCategory("DAFTAR_UNDANGAN");
		$objPHPExcel->getActiveSheet()->setTitle('DAFTAR_UNDANGAN');
		$TitlE 		= "DAFTAR PESERTA";
		$namafile	= str_replace(' ', '_', $TitlE);
		$objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		header('Last-Modified:' . gmdate("D, d M Y H:i:s") . 'GMT');
		header('Chace-Control: no-store, no-cache, must-revalation');
		header('Chace-Control: post-check=0, pre-check=0', FALSE);
		header('Pragma: no-cache');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $namafile . '.xlsx"');

		$objWriter->save('php://output');
	}

	public function get_penawaran()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_penawaran($_GET['term'], 'tgl_penawaran');
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_reg_pekerjaan . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_penawaran($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['nilai_oe'] = $r->nilai_oe;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;
		}
		echo json_encode($data_all);
	}

	public function daftar_penawaran($cari_id = '')
	{
		$data_all = $this->kontrakm->get_peserta_penawaran($cari_id);
		echo json_encode($data_all);
	}

	public function add_penawaran($id = '', $hasil = '')
	{
		$hasilx = explode("%20", $hasil);
		foreach ($hasilx as $id_vd) {
			$data_transaksi['penawaran'] = '1';
			$update_penawaran = $this->referensim->update('ttransaksi', array('no_reg_pekerjaan' => $id, 'id_vd' => $id_vd), $data_transaksi);
		}

		$data_update['tgl_penawaran'] = date("Y-m-d");
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $id), $data_update);

		echo json_encode(array("status" => TRUE));
	}

	public function get_penetapan()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_penetapan($_GET['term'], 'tgl_negosiasi');
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_reg_pekerjaan . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_penetapan($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['nilai_oe'] = $r->nilai_oe;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;
		}
		echo json_encode($data_all);
	}

	public function daftar_penetapan($cari_id = '')
	{
		$data_all = $this->kontrakm->get_peserta_penetapan($cari_id);
		echo json_encode($data_all);
	}

	public function add_penetapan($id = '', $hasil = '', $winner = '', $valuer = '')
	{
		$hasilx = explode("%20", $hasil);
		foreach ($hasilx as $id_vd) {
			$data_transaksi['pemenang'] = '1';
			$data_transaksi['tgl_update'] = date("Y-m-d");
			$update_penawaran = $this->referensim->update('ttransaksi', array('no_reg_pekerjaan' => $id, 'id_vd' => $id_vd), $data_transaksi);
		}

		$data_update['id_vd_pemenang'] = $winner;
		$data_update['nilai_penawaran'] = $valuer;
		$data_update['tgl_negosiasi'] = date("Y-m-d");
		$data_update['tgl_penetapan'] = date("Y-m-d");
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $id), $data_update);

		echo json_encode(array("status" => TRUE));
	}

	public function get_final()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_final($_GET['term'], 'no_kontrak');
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_reg_pekerjaan . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_final($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['nilai_oe'] = $r->nilai_oe;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;
			$data_all['nilai_penawaran'] = $r->nilai_penawaran;
			$data_all['vendor_pemenang'] = $this->referensim->get_tvd_list($r->id_vd_pemenang)->nama_pt;
		}
		echo json_encode($data_all);
	}

	public function add_final()
	{
		$no_reg = $this->input->post('no_reg_pekerjaan_final');

		$data_update['no_kontrak'] = $this->input->post('no_kontrak_final');
		$data_update['nilai_kontrak'] = str_replace(",", "", $this->input->post('nilai_kontrak_final'));
		$data_update['tgl_mulai'] = $this->input->post('tgl_mulai_final');
		$data_update['tgl_akhir'] = $this->input->post('tgl_akhir_final');
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $no_reg), $data_update);

		echo json_encode(array("status" => TRUE));
	}

	public function penilaian()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['prov_list'] = $this->referensim->get_prov();
			$datax['list_jenis'] = $this->referensim->get_jenis_penyediaan();
			$datax['list_pengadaan'] = $this->referensim->get_list_pengadaan();
			$datax['list_user'] = $this->referensim->get_user_tim();

			$this->load->view('kontrak/penilaian', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function get_kontrak()
	{
		if (isset($_GET['term'])) {
			$result = $this->kontrakm->cari_penilaian_kontrak($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->no_kontrak . ", " . $row->nama_pekerjaan;
					$hasil_result['id'] = $row->no_reg_pekerjaan;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
		}
	}

	public function cari_vendor_penilaian($cari_id = '')
	{
		$a = $this->kontrakm->get_data_kontrak($cari_id);
		foreach ($a as $r) {
			$data_all['no_kontrak'] = $r->no_kontrak;
			$data_all['no_reg_pekerjaan'] = $r->no_reg_pekerjaan;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
			$data_all['lokasi'] = $r->lokasi_pekerjaan . ", " . $r->kab_nama . ", " . $r->prov_nama;
			$data_all['nilai_kontrak'] = $r->nilai_kontrak;
			$data_all['divisi'] = $r->divisi;
			$data_all['durasi'] = $r->durasi;
			$data_all['metode_pengadaan'] = $r->metode_pengadaan;
			$data_all['jenis_pengadaan'] = $r->jenis_pengadaan;
			$data_all['tgl_mulai'] = $r->tgl_mulai;
			$data_all['tgl_akhir'] = $r->tgl_akhir;
			$data_all['id_vd'] = $r->id_vd_pemenang;
			$data_all['nama_pt'] = $this->referensim->get_tvd_list($r->id_vd_pemenang)->nama_pt;
		}
		echo json_encode($data_all);
	}

	public function soal_penilaian()
	{
		$data_all = $this->kontrakm->get_data_soal();
		echo json_encode($data_all);
	}

	public function jawaban_penilaian($no_reg = '', $jawabanx = '')
	{
		$jawaban = explode("%20", $jawabanx);
		$total_nilai = 0;
		foreach ($jawaban as $soal) {
			list($no_soal, $nilai) = explode("-", $soal);
			$bobot = $this->kontrakm->get_data_soal_detil($no_soal)->bobot;
			$hitung_1 = ($nilai / 5);
			$hitung_2 = ($nilai / 5) * $bobot;

			$data_nilai['no_reg_pekerjaan'] = $no_reg;
			$data_nilai['no_soal'] = $no_soal;
			$data_nilai['nilai_likert'] = $nilai;
			$data_nilai['nilai_bobot'] = $hitung_2;
			$total_nilai = $total_nilai + $hitung_2;

			$insert_nilai = $this->referensim->save('tl_penilaian', $data_nilai);
		}

		$data_update['nilai_kualitas_pekerjaan'] = $total_nilai;
		$update_treg_pekerjaan = $this->referensim->update('treg_pekerjaan', array('no_reg_pekerjaan' => $no_reg), $data_update);

		echo json_encode(array("status" => TRUE));
	}
}
