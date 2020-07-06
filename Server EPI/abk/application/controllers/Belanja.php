<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Belanja extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('belanjam');
		date_default_timezone_set('Asia/Jakarta');
	}

	private function id_transaksi()
	{
		$tot = $this->db->query("SELECT id_transaksi from tnota group by id_transaksi")->num_rows();
		$last = $tot + 1;
		$id_baru = "T-" . $last . mt_rand(10, 99);
		return $id_baru;
		/*
		switch (strlen($last)) {
			case '1': 
				$id_baru = "TI-"."0000".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '2':
				$id_baru = "TI-"."000".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '3':
				$id_baru = "TI-"."00".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '4':
				$id_baru = "TI-"."0".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '5':
				$id_baru = "TI-".$last.mt_rand(0,8);
				return $id_baru;
				break;
		}
		*/
	}

	private function id_reg_nota()
	{
		$tot = $this->db->query("SELECT id_reg_nota from tnota group by id_reg_nota")->num_rows();
		$last = $tot + 1;
		$id_baru = "N-" . $last . mt_rand(10, 99);
		return $id_baru;
		/*
		switch (strlen($last)) {
			case '1':
				$id_baru = "N-"."00".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '2':
				$id_baru = "N-"."0".$last.mt_rand(0,8);
				return $id_baru;
				break;
				
			case '3':
				$id_baru = "N-".$last.mt_rand(0,8);
				return $id_baru;
				break;
		}
		*/
	}

	public function entri()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['satuan'] = $this->belanjam->get_satuan();
			$datax['info_jasa'] = $this->belanjam->get_info_jasa();
			$datax['list_transaksi'] = $this->belanjam->get_list_transaksi();
			$datax['list_kontrak'] = $this->belanjam->get_list_kontrak();
			$this->load->view('belanja/entri', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function entri_bayar()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['satuan'] = $this->belanjam->get_satuan();
			$datax['info_jasa'] = $this->belanjam->get_info_jasa();
			$datax['list_kontrak'] = $this->belanjam->get_list_kontrak();
			$this->load->view('belanja/entri_bayar', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	function get_id()
	{
		$data_all['id_transaksi'] = $this->id_transaksi();
		$data_all['id_reg_nota'] = $this->id_reg_nota();
		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	function get_idx()
	{
		$id_transaksi = $this->id_transaksi();
		$cek_it = $this->db->query("Select id_transaksi from ttransaksi_id where id_transaksi = '$id_transaksi' group by id_transaksi");
		if ($cek_it->num_rows() > 0) {
			$last = $this->db->query("Select max(id_transaksi) as id_transaksi from ttransaksi_id ")->row("id_transaksi");
			$id_transaksi = $last + 1;
			$this->db->query("Insert into ttransaksi_id (id_transaksi) values ('$id_transaksi')");
			$data_all['id_transaksi'] = $id_transaksi;
		} else {
			$this->db->query("Insert into ttransaksi_id (id_transaksi) values ('$id_transaksi')");
			$data_all['id_transaksi'] = $id_transaksi;
		}

		$id_reg_nota = $this->id_reg_nota();
		$cek_irn = $this->db->query("Select id_reg_nota from ttransaksi_id where id_transaksi = '$id_transaksi' and id_reg_nota = '$id_reg_nota' ");
		if ($cek_irn->num_rows() > 0) {
			$lasts = $this->db->query("Select max(id_reg_nota) as id_reg_nota from ttransaksi_id ")->row("id_reg_nota");
			$id_reg_nota = $lasts + 1;
			$this->db->query("Update ttransaksi_id SET id_reg_nota = '$id_reg_nota' where id_transaksi = '$id_transaksi' ");
			$data_all['id_reg_nota'] = $id_reg_nota;
		} else {
			$this->db->query("Update ttransaksi_id SET id_reg_nota = '$id_reg_nota' where id_transaksi = '$id_transaksi' ");
			$data_all['id_reg_nota'] = $id_reg_nota;
		}

		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	function hapus_list()
	{
		$id_reg_nota = $this->input->post('id_reg_nota');
		$hapus_transaksi_temp = $this->belanjam->delete_transaksi_temp($id_reg_nota);
		echo json_encode(array("status" => true));
	}

	function add_barang()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();

		$tabel = $this->belanjam->get_kolom_transaksi();
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {
				case 'id_transaksi':
					$cek_id = $this->input->post("id_transaksi");
					$data[$kolom->COLUMN_NAME] = strtoupper($cek_id);
					break;
				case 'id_reg_nota':
					$cek_it = $this->input->post("id_transaksi");
					$cek_id = $this->input->post("id_reg_nota");
					$data[$kolom->COLUMN_NAME] = strtoupper($cek_id);
					break;
				case 'lokasi_gudang':
					$data[$kolom->COLUMN_NAME] = 'EPI';
					break;
				case 'tahun_kontrak':
					$data[$kolom->COLUMN_NAME] = date('Y');
					break;
				case 'id_ref':
					if ($this->input->post('pembayaran') == 'dp') {
						$data[$kolom->COLUMN_NAME] = '002';
					} else if ($this->input->post('pembayaran') == 'tunai') {
						$data[$kolom->COLUMN_NAME] = '001';
					}
					break;
				case 'tgl_transaksi':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'id_barang':
					$data[$kolom->COLUMN_NAME] = "D-" . round(microtime(true) * 1000);
					break;
				case 'jumlah_barang':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post('jumlah_barang'));
					break;
				case 'jumlah_harga':
					$jumlah_barang = str_replace(',', '', $this->input->post('jumlah_barang'));

					$ada_ppn = $this->input->post('ada_ppn');
					if ($ada_ppn == 'ya') {
						$nilai = str_replace(',', '', $this->input->post('harga_satuan'));
						$nilai_ppn = round((float) $nilai * 0.1, 2);
						$harga_satuan = round(($nilai + $nilai_ppn), 2);
					} else {
						$harga_satuan = str_replace(',', '', $this->input->post('harga_satuan'));
					}
					$jumlah_harga = (float) $jumlah_barang * (float) $harga_satuan;
					$data[$kolom->COLUMN_NAME] = $jumlah_harga;
					break;
				case 'harga_satuan':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post('harga_satuan'));
					break;
				case 'nilai_ppn':
					$ada_ppn = $this->input->post('ada_ppn');
					if ($ada_ppn == 'ya') {
						$nilai_ppn = str_replace(',', '', $this->input->post('harga_satuan'));
						$data[$kolom->COLUMN_NAME] = round((float) $nilai_ppn * 0.1, 2);
					} else {
						$data[$kolom->COLUMN_NAME] = 0;
					}
					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'user_entri':
					$data[$kolom->COLUMN_NAME] = $this->session->userdata('nama');
					break;
				default:
					$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					break;
			}
		}
		$this->belanjam->save('ttransaksi_temp', $data);
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	function add_lain2()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();

		$tabel = $this->belanjam->get_kolom_transaksi();
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {
				case 'lokasi_gudang':
					$data[$kolom->COLUMN_NAME] = 'EPI';
					break;
				case 'tahun_kontrak':
					$data[$kolom->COLUMN_NAME] = date('Y');
					break;
				case 'id_ref':
					$data[$kolom->COLUMN_NAME] = '102';
					break;
				case 'id_kontrak':
					$data[$kolom->COLUMN_NAME] = $this->input->post('id_kontrak');
					break;
				case 'tgl_transaksi':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'id_barang':
					$data[$kolom->COLUMN_NAME] = "D-" . round(microtime(true) * 1000);
					break;
				case 'jumlah_barang':
					$data[$kolom->COLUMN_NAME] = '1';
					break;
				case 'satuan_barang':
					$data[$kolom->COLUMN_NAME] = 'LOT';
					break;
				case 'harga_satuan':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post('harga_satuan'));
					break;
				case 'jumlah_harga':
					$harga_satuan = str_replace(',', '', $this->input->post('harga_satuan'));
					if ($this->input->post('ada_ppn') == 'ya') {
						$nilai_ppn = round((float) $harga_satuan * 0.1, 2);
					} else {
						$nilai_ppn = round((float) $harga_satuan * 0, 2);
					}
					$jumlah_harga = round(($harga_satuan + $nilai_ppn), 2);
					$data['nilai_ppn'] = $nilai_ppn;
					$data['jumlah_harga'] = $jumlah_harga;

					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'user_entri':
					$data[$kolom->COLUMN_NAME] = $this->session->userdata('nama');
					break;
				default:
					$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					break;
			}
		}
		#$this->belanjam->save('ttransaksi',$data);
		$this->belanjam->save('ttransaksi_temp', $data);
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	public function list_barang()
	{
		$data = array();

		$id_transaksi = $this->input->post('id_transaksi');
		$id_reg_nota = $this->input->post('id_reg_nota');
		$i = 1;
		$q = "SELECT * FROM ttransaksi_temp WHERE id_transaksi = '$id_transaksi' and id_reg_nota = '$id_reg_nota' ORDER BY id desc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->nama_barang;
			$row[] = $r->merk_barang;
			$row[] = number_format($r->jumlah_barang) . " " . $r->satuan_barang;
			$row[] = number_format($r->harga_satuan);
			$row[] = number_format($r->jumlah_harga);
			$row[] = '<a class="btn btn-sm red" onclick="del_barang(' . "'" . $r->id_barang . "'" . ')" title="Hapus dari list"><i class="glyphicon glyphicon-minus"></i></a>';
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function list_lain2()
	{
		$data = array();

		$id_transaksi = $this->input->post('id_transaksi');
		$id_reg_nota = $this->input->post('id_reg_nota');
		$i = 1;
		$q = "SELECT * FROM ttransaksi_temp WHERE id_transaksi = '$id_transaksi' and id_reg_nota = '$id_reg_nota' ORDER BY id desc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_kontrak;
			$row[] = $r->nama_barang;
			$row[] = number_format($r->jumlah_harga);
			$row[] = '<a class="btn btn-sm red" onclick="del_barang(' . "'" . $r->id_barang . "'" . ')" title="Hapus dari list"><i class="glyphicon glyphicon-minus"></i></a>';
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function delete_barang_detil($id)
	{
		$this->belanjam->delete_barang_detil_temp($id);
		echo json_encode(array("status" => TRUE));
	}

	function belanja_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$id_reg_nota = $this->input->post('id_reg_nota');

		$a = $this->input->post('id_reg_nota');
		$b = $this->input->post('id_transaksi');

		$tabel = $this->belanjam->get_kolom_tbelanja();
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {

				case 'file_nota':
					if (!empty($_FILES[$kolom->COLUMN_NAME]['name'])) {
						$files = $this->validasi_upload($kolom->COLUMN_NAME, $id_reg_nota);
						$data[$kolom->COLUMN_NAME] = $files;
					} else {
						$data[$kolom->COLUMN_NAME] = 'file blank';
					}
					break;
				case 'kontrak_rujukan':
					$data[$kolom->COLUMN_NAME] = $this->input->post('id_kontrak');
					break;
				case 'tahun':
					$data[$kolom->COLUMN_NAME] = date('Y');
					break;
				case 'jenis_transaksi':
					$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post('metode_bayar_nilai'));
					#$data[$kolom->COLUMN_NAME] = 'xxx';
					/*
					if ($this->input->post('metode_bayar') == 'dp') {
						$data[$kolom->COLUMN_NAME] = 'DP';
					}
					else if ($this->input->post('metode_bayar') == 'tunai'){
						$data['jenis_transaksi'] = 'TUNAI';
					}
					*/
					break;
				case 'total_belanja':
					$diskon = str_replace(',', '', $this->input->post('diskon'));

					if ($this->input->post('metode_bayar_nilai') == 'dp') {
						$jumlah_belanjax = str_replace(',', '', $this->input->post('dp_belanja'));
						$nilai_ppnx = str_replace(',', '', $this->input->post('dp_ppn_belanja'));
						$total_belanjax = ($jumlah_belanjax + $nilai_ppnx) - $diskon;

						$data['jumlah_belanja'] = $jumlah_belanjax;
						$data['nilai_ppn'] = $nilai_ppnx;
						$data['total_belanja'] = $total_belanjax;
					} else if ($this->input->post('metode_bayar_nilai') == 'tunai') {

						if ($this->belanjam->num_rows_tnota($a, $b) > 0) {
							$total_belanja = $this->belanjam->total_barang_detil($id_reg_nota)->total_belanja;
							$jumlah_belanja = $this->belanjam->total_barang_detil($id_reg_nota)->jumlah_belanja;
							$nilai_ppn = $this->belanjam->total_barang_detil($id_reg_nota)->total_ppn;
						} else {
							$total_belanja = $this->belanjam->total_barang_detil_temp($id_reg_nota)->total_belanja;
							$jumlah_belanja = $this->belanjam->total_barang_detil_temp($id_reg_nota)->jumlah_belanja;
							$nilai_ppn = $this->belanjam->total_barang_detil_temp($id_reg_nota)->total_ppn;
						}

						$data['jumlah_belanja'] = $jumlah_belanja;
						$data['nilai_ppn'] = $nilai_ppn;
						$total_belanja_akhir = $total_belanja - $diskon;
						$data['total_belanja'] = $total_belanja_akhir;
					} else if ($this->input->post('metode_bayar_nilai') == 'lain2') {
						if ($this->belanjam->num_rows_tnota($a, $b) > 0) {
							$data[$kolom->COLUMN_NAME] = $this->belanjam->total_barang_detil($id_reg_nota)->total_belanja;
						} else {
							$data[$kolom->COLUMN_NAME] = $this->belanjam->total_barang_detil_temp($id_reg_nota)->total_belanja;
						}
					}
					break;
				case 'status_bayar':
					if ($this->input->post('metode_bayar_nilai') == 'dp') {
						$data[$kolom->COLUMN_NAME] = '0';
					} else if ($this->input->post('metode_bayar_nilai') == 'tunai') {
						$data[$kolom->COLUMN_NAME] = '1';
					}
					break;
				case 'diskon':
					$data['diskon'] = str_replace(',', '', $this->input->post('diskon'));
					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'user_entri':
					$data[$kolom->COLUMN_NAME] = $this->session->userdata('nama');
					break;
				case 'status_nota':
					$data[$kolom->COLUMN_NAME] = (empty($this->input->post('status_nota'))) ? '0' : $this->input->post('status_nota'); #untuk sementara 1
					break;
				default:
					$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					break;
			}
		}
		#cek data sebelumnya
		$cek_data = $this->db->query("SELECT * from tnota where id_transaksi = '$b' and id_reg_nota = '$a' ");
		if ($cek_data->num_rows() > 0) {
			$this->belanjam->update('tnota', array('id_transaksi' => $b, 'id_reg_nota' => $a), $data);
		} else {
			$this->belanjam->save('tnota', $data);
			#lakukan insert ke "ttransaksi" dari "ttransaksi_temp"
			$this->update_ttransaksi($b, $a);
			//$diskonx = str_replace(',','',$this->input->post('diskon'));
			//$this->insert_diskon_transaksi($b,$a,$diskonx);

			#lakukan pengosongan data temporary
			$this->delete_ttransaksi_temp($b, $a);
		}

		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	private function update_ttransaksi($id_transaksi, $id_reg_nota)
	{
		$query = $this->db->query("
			Insert into ttransaksi (
				id_barang,id_reg_nota,id_transaksi,tgl_transaksi,id_ref,tahun_kontrak,id_kontrak,nama_barang,merk_barang,jumlah_barang,satuan_barang,harga_satuan,nilai_ppn,jumlah_harga,lokasi_gudang,keterangan,tgl_create,user_entri
			)
			select 
				id_barang,id_reg_nota,id_transaksi,tgl_transaksi,id_ref,tahun_kontrak,id_kontrak,nama_barang,merk_barang,jumlah_barang,satuan_barang,harga_satuan,nilai_ppn,jumlah_harga,lokasi_gudang,keterangan,tgl_create,user_entri
			from ttransaksi_temp
			where id_transaksi = '" . $id_transaksi . "' and id_reg_nota = '" . $id_reg_nota . "'
		");
		return $query;
	}

	/*
	private function insert_diskon_transaksi($id_transaksi, $id_reg_nota, $diskon){
		$data = array();
		$hasil = $this->belanjam->detil_barang($id_reg_nota);
		foreach($hasil as $r){
			#$data['']
			
			
		}
		return TRUE;
	}
	*/

	private function delete_ttransaksi_temp($id_transaksi, $id_reg_nota)
	{
		$query = $this->db->query("
			delete from ttransaksi_temp
			where id_transaksi = '" . $id_transaksi . "' and id_reg_nota = '" . $id_reg_nota . "'
		");
		return $query;
	}

	function belanja_simpan_lain2()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$id_reg_nota = $this->input->post('id_reg_nota');

		$a = $this->input->post('id_reg_nota');
		$b = $this->input->post('id_transaksi');

		$tabel = $this->belanjam->get_kolom_tbelanja();
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {
				case 'file_nota':
					if (!empty($_FILES[$kolom->COLUMN_NAME]['name'])) {
						$files = $this->validasi_upload($kolom->COLUMN_NAME, $id_reg_nota);
						$data[$kolom->COLUMN_NAME] = $files;
					} else {
						$data[$kolom->COLUMN_NAME] = 'file blank';
					}
					break;
				case 'tahun':
					$data[$kolom->COLUMN_NAME] = date('Y');
					break;
				case 'kontrak_rujukan':
					$data[$kolom->COLUMN_NAME] = $this->input->post('id_kontrak_cari');
					break;
				case 'jenis_transaksi':
					$data[$kolom->COLUMN_NAME] = 'LAIN2';
					break;
				case 'total_belanja':
					if ($this->belanjam->num_rows_tnota($a, $b) > 0) {
						$total_belanja = $this->belanjam->total_barang_detil($id_reg_nota)->total_belanja;
						$jumlah_belanja = $this->belanjam->total_barang_detil($id_reg_nota)->jumlah_belanja;
						$nilai_ppn = $this->belanjam->total_barang_detil($id_reg_nota)->total_ppn;
					} else {
						$total_belanja = $this->belanjam->total_barang_detil_temp($id_reg_nota)->total_belanja;
						$jumlah_belanja = $this->belanjam->total_barang_detil_temp($id_reg_nota)->jumlah_belanja;
						$nilai_ppn = $this->belanjam->total_barang_detil_temp($id_reg_nota)->total_ppn;
					}

					$data['jumlah_belanja'] = $jumlah_belanja;
					$data['nilai_ppn'] = $nilai_ppn;
					$data['total_belanja'] = $total_belanja;
					break;
				case 'status_bayar':
					$data[$kolom->COLUMN_NAME] = '1';
					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'user_entri':
					$data[$kolom->COLUMN_NAME] = $this->session->userdata('nama');
					break;
				case 'status_nota':
					$data[$kolom->COLUMN_NAME] = '1'; #untuk sementara 1
					break;
				default:
					$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					break;
			}
		}

		#cek data sebelumnya

		$cek_data = $this->db->query("SELECT * from tnota where id_transaksi = '$b' and id_reg_nota = '$a' ");
		if ($cek_data->num_rows() > 0) {
			$this->belanjam->update('tnota', array('id_transaksi' => $b, 'id_reg_nota' => $a), $data);
		} else {
			$this->belanjam->save('tnota', $data);
			#lakukan insert ke "ttransaksi" dari "ttransaksi_temp"
			$this->update_ttransaksi($b, $a);

			#lakukan pengosongan data temporary
			$this->delete_ttransaksi_temp($b, $a);
		}

		//


		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	private function validasi_upload($files, $ids)
	{
		$config['upload_path']          = 'upload/';
		$config['allowed_types']        = 'gif|jpg|jpeg|png|doc|docx|pdf|xls|xlsx|txt|rar|zip';
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

	function add_transaksi($id_reg_nota)
	{
		date_default_timezone_set("Asia/Jakarta");
		$sekarang = date('Y-m-d H:i:s');
		$data['id_transaksi'] = "TI-" . mt_rand(100000, 999999);
		$data['dasar_transaksi'] = "Nota Pembelian";
		$data['no_dasar_transaksi'] = $id_reg_nota;
		$data['tgl_transaksi'] = $sekarang;
		$data['id_ref'] = "001";
		$data['lokasi_gudang'] = "EPI";
		$data['tgl_create'] = $sekarang;
		$data['user_entri'] = $this->session->userdata('nama');

		$hasil = $this->belanjam->get_barang_detil($id_reg_nota);
		foreach ($hasil as $r) {
			$data['id_barang'] = $r->id_barang;
			$data['nama_barang'] = $r->nama_barang;
			$data['merk_barang'] = $r->merk_barang;
			$data['jumlah_barang'] = $r->jumlah_barang;
			$data['satuan_barang'] = $r->satuan_barang;
			$data['harga_satuan'] = $r->harga_satuan;

			$this->belanjam->save('ttransaksi', $data);
		}
	}

	public function daftar()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$this->load->view('belanja/daftar');
		} else {
			redirect('welcome/index');
		}
	}

	public function get_cari_belanja()
	{
		if (isset($_GET['term'])) {
			$result = $this->belanjam->cari_belanja($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->ket;
					$hasil_result['id'] = $row->id_transaksi;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Data tidak ditemukan...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
		}
		echo json_encode($arr_result);
	}

	public function list_belanja_peritem()
	{
		$data = array();

		$i = 1;
		$q = "SELECT * from vdaftar_barang";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_barang;
			$row[] = $r->tempat_pembelian;
			$row[] = $r->nama_barang;
			$row[] = $r->merk_barang;
			$row[] = $r->jumlah_barang . " " . $r->satuan_barang;
			$row[] = number_format($r->harga_satuan);
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function rekap()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$this->load->view('belanja/rekap');
		} else {
			redirect('welcome/index');
		}
	}

	public function list_belanja()
	{
		$data = array();

		$i = 1;
		$q = "SELECT id_transaksi, tempat_pembelian, max(tgl_pembelian) tgl_pembelian, sum(total_belanja) total_belanja
      FROM tnota group by id_transaksi ORDER BY id desc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_transaksi;
			$row[] = $r->tempat_pembelian;
			$row[] = $r->tgl_pembelian;
			$row[] = number_format($r->total_belanja);
			$row[] = '<a class="btn btn-sm blue" onclick="show_barang(' . "'" . $r->id_transaksi . "'" . ')" title="Tampil Detil"><i class="glyphicon glyphicon-list"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function list_belanja_detil()
	{
		$data = array();
		$id_transaksi = $this->input->post('id_transaksi');

		$i = 1;
		$q = "SELECT * FROM ttransaksi where id_transaksi = '$id_transaksi' ORDER BY id asc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_transaksi;
			$row[] = $r->nama_barang;
			$row[] = $r->merk_barang;
			$row[] = number_format($r->jumlah_barang) . " " . $r->satuan_barang;
			$row[] = number_format($r->harga_satuan);
			$row[] = number_format($r->jumlah_harga);
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_cari_kontrak()
	{
		if (isset($_GET['term'])) {
			$result = $this->belanjam->cari_kontrak($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->ket;
					$hasil_result['id'] = $row->id_kontrak;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Data tidak ditemukan...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
		}
		echo json_encode($arr_result);
	}

	function get_data_kontrak()
	{
		$data_all = array();

		$id_kontrak = $this->input->post('id_kontrak');
		$hasil = $this->belanjam->get_data_kontrak($id_kontrak);

		foreach ($hasil as $r) {
			$data_all['id_reg_nota'] = "N-" . mt_rand(1000, 9999);
			$data_all['id_kontrak'] = $r->id_kontrak;
			$data_all['nama_pekerjaan'] = $r->nama_pekerjaan;
		}
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	public function get_cari_transaksi()
	{
		if (isset($_GET['term'])) {
			$result = $this->belanjam->cari_transaksi($_GET['term']);
			if (count($result) > 0) {
				foreach ($result as $row) {
					$hasil_result['label'] = $row->ket;
					$hasil_result['id'] = $row->id_transaksi;
					$arr_result[] = $hasil_result;
				}
			} else {
				$hasil_result['label'] = "Data tidak ditemukan...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
		}
		echo json_encode($arr_result);
	}

	function get_data_transaksi()
	{
		$data_all = array();

		$id_transaksi = $this->input->post('id_transaksi');

		$hasil = $this->belanjam->get_data_transaksi_termin($id_transaksi);
		//$hasil = $this->belanjam->get_data_transaksi($id_transaksi);

		foreach ($hasil as $r) {
			$data_all['id_transaksi'] = $r->id_transaksi;
			$data_all['id_kontrak'] = $r->kontrak_rujukan;
			$data_all['id_reg_nota'] = $this->id_reg_nota();
			$data_all['pelunasan_tempat_pembelian'] = $r->tempat_pembelian;
			$data_all['pelunasan_dp'] = $r->jumlah_belanja;
			$data_all['pelunasan_dp_ppn'] = $r->nilai_ppn;
			$data_all['pelunasan_dp_tot'] = $r->total_belanja;
			$data_all['diskon_dp'] = $r->diskon;
			if ($r->ada_ppn == 'YA') {
				$total = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$data_all['pelunasan_jumlah'] = $this->belanjam->total_transaksi_detil($id_transaksi)->jumlah_belanja;
				$data_all['pelunasan_ppn'] = $this->belanjam->total_transaksi_detil($id_transaksi)->total_ppn;
				$data_all['pelunasan_total'] = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$data_all['pelunasan_sisa'] = ($total - $r->total_belanja) - $r->diskon;
			} else {
				$total = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$data_all['pelunasan_jumlah'] = $this->belanjam->total_transaksi_detil($id_transaksi)->jumlah_belanja;
				$data_all['pelunasan_ppn'] = $this->belanjam->total_transaksi_detil($id_transaksi)->total_ppn;
				$data_all['pelunasan_total'] = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$data_all['pelunasan_sisa'] = ($total - $r->total_belanja) - $r->diskon;
			}
		}
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	function get_data_transaksixxxxxxxxxxx()
	{
		$data_all = array();

		$id_transaksi = $this->input->post('id_transaksi');

		$hasil = $this->belanjam->get_data_transaksi_termin($id_transaksi);
		//$hasil = $this->belanjam->get_data_transaksi($id_transaksi);

		foreach ($hasil as $r) {
			$data_all['id_transaksi'] = $r->id_transaksi;
			$data_all['id_kontrak'] = $r->kontrak_rujukan;
			$data_all['id_reg_nota'] = $this->id_reg_nota();
			$data_all['pelunasan_tempat_pembelian'] = $r->tempat_pembelian;
			$data_all['pelunasan_dp'] = $r->jumlah_belanja;
			$data_all['pelunasan_dp_ppn'] = $r->nilai_ppn;
			$data_all['pelunasan_dp_tot'] = $r->total_belanja;
			if ($r->ada_ppn == 'YA') {
				$tot = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$nilai_ppn = round($tot * 0.1);
				$total = $tot;
				$data_all['pelunasan_jumlah'] = $tot;
				$data_all['pelunasan_ppn'] = $nilai_ppn;
				$data_all['pelunasan_total'] = $total;
				$data_all['pelunasan_sisa'] = $total - $r->total_belanja;
			} else {
				$tot = $this->belanjam->total_transaksi_detil($id_transaksi)->total_belanja;
				$nilai_ppn = round($tot * 0);
				$total = $tot;
				$data_all['pelunasan_jumlah'] = $tot;
				$data_all['pelunasan_ppn'] = $nilai_ppn;
				$data_all['pelunasan_total'] = $total;
				$data_all['pelunasan_sisa'] = $total - $r->total_belanja;
			}
		}
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	function pelunasan_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$id_transaksi = $this->input->post('id_transaksi');
		$id_reg_nota = $this->input->post('id_reg_nota');
		$duplikat = $this->belanjam->duplikat_transaksi($id_transaksi, $id_reg_nota);
		if ($duplikat) {
			$datax['tgl_pembelian'] = $this->input->post('pelunasan_tanggal');

			$pjum = str_replace(',', '', $this->input->post('pelunasan_jumlah'));
			$pdp = str_replace(',', '', $this->input->post('pelunasan_dp'));
			$sel_pjum = (float) $pjum - (float) $pdp;
			$datax['jumlah_belanja'] = $sel_pjum;

			$ppn_lunas = str_replace(',', '', $this->input->post('pelunasan_ppn'));
			$ppn_dp = str_replace(',', '', $this->input->post('pelunasan_dp_ppn'));
			$sel_ppn = (float) $ppn_lunas - (float) $ppn_dp;
			$datax['nilai_ppn'] = $sel_ppn;

			$tot_belanja = $sel_pjum + $sel_ppn;
			$datax['total_belanja'] = $tot_belanja;
			$datax['anggaran'] = strtoupper($this->input->post('anggaran'));
			$file_post = $this->input->post('file_nota');
			if (!empty($_FILES['file_nota']['name'])) {
				$files = $this->validasi_upload('file_nota', $id_reg_nota);
				$datax['file_nota'] = $files;
			} else {
				$datax['file_nota'] = 'file blank';
			}
			$this->belanjam->update('tnota', array('id_transaksi' => $id_transaksi, 'id_reg_nota' => $id_reg_nota), $datax);
		}

		$dataz['status_bayar'] = '1';
		$this->belanjam->update('tnota', array('id_transaksi' => $id_transaksi), $dataz);

		$datay['id_reg_nota'] = $id_reg_nota;
		$datay['id_ref'] = '003';
		$this->belanjam->update('ttransaksi', array('id_transaksi' => $id_transaksi), $datay);

		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	function termin_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$id_transaksi = $this->input->post('id_transaksi');
		$id_reg_nota = $this->input->post('id_reg_nota');
		$duplikat = $this->belanjam->duplikat_transaksi_termin($id_transaksi, $id_reg_nota);
		if ($duplikat) {
			$datax['tgl_pembelian'] = $this->input->post('pelunasan_tanggal');

			$jumlah_belanja = str_replace(',', '', $this->input->post('rp_termin'));
			$nilai_ppn = str_replace(',', '', $this->input->post('rp_termin_ppn'));
			$diskon = str_replace(',', '', $this->input->post('diskon'));
			$datax['jumlah_belanja'] = $jumlah_belanja;
			$datax['nilai_ppn'] = $nilai_ppn;
			$datax['diskon'] = $diskon;
			$datax['total_belanja'] = ((float) $jumlah_belanja + (float) $nilai_ppn) - $diskon;
			$datax['anggaran'] = strtoupper($this->input->post('anggaran'));
			$file_post = $this->input->post('file_nota');
			if (!empty($_FILES['file_nota']['name'])) {
				$files = $this->validasi_upload('file_nota', $id_reg_nota);
				$datax['file_nota'] = $files;
			} else {
				$datax['file_nota'] = 'file blank';
			}
			$this->belanjam->update('tnota', array('id_transaksi' => $id_transaksi, 'id_reg_nota' => $id_reg_nota), $datax);
		}

		$dataz['status_bayar'] = '0';
		$this->belanjam->update('tnota', array('id_transaksi' => $id_transaksi), $dataz);

		$datay['id_reg_nota'] = $id_reg_nota;
		$datay['id_ref'] = '002';
		$this->belanjam->update('ttransaksi', array('id_transaksi' => $id_transaksi), $datay);

		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	public function rekappernota()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$data['tahun'] = $this->belanjam->rekappernota_tahun();
			$this->load->view('belanja/rekappernota', $data);
		} else {
			redirect('welcome/index');
		}
	}

	public function list_rekappernota()
	{
		$data = array();
		$thn = $this->input->post('tahun');
		if ($thn) {
			$tahun = $thn;
		} else {
			$tahun = '2018';
		}

		$i = 1;
		$q = "SELECT * FROM vrekap_pernota where tahun = '$tahun' ";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			if ($r->status_bayar == '1') {
				$status_bayar = 'Lunas';
			} else {
				$status_bayar = 'Belum Lunas';
			}

			$row = array();
			$row[] = $i++;
			$row[] = $r->id_reg_nota;
			$row[] = $r->id_kontrak;
			$row[] = tanggal_ttd($r->tgl_pembelian); //tanggal_ttd($r->tgl_pembelian) //$r->tgl_pembelian
			$row[] = $r->tempat_pembelian;
			$row[] = $status_bayar;
			$row[] = ucwords(strtolower($r->anggaran));
			$row[] = number_format($r->total_belanja);
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function rekappertransaksi()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$data['tahun'] = $this->belanjam->rekappernota_tahun();
			$this->load->view('belanja/rekappertransaksi', $data);
		} else {
			redirect('welcome/index');
		}
	}

	public function list_rekappertransaksi()
	{
		$data = array();
		$thn = $this->input->post('tahun');
		if ($thn) {
			$tahun = $thn;
		} else {
			$tahun = '2018';
		}

		$i = 1;
		$q = "SELECT * FROM vrekap_pertransaksi where tahun = '$tahun' order by tgl_last_transaksi desc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_transaksi;
			$row[] = tanggal_ttd($r->tgl_last_transaksi);
			$row[] = $r->tempat_pembelian;
			$row[] = $r->jlh_nota;
			$row[] = number_format($r->jlh_transaksi);
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function daftar_nota()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['list_tahun'] = $this->belanjam->list_tahun();
			$datax['tahun'] = $this->belanjam->last_tahun();
			$this->load->view('belanja/daftar_nota', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function tabel_daftar_nota()
	{
		$data = array();

		$tahun = $this->input->post('tahun');
		$i = 1;
		$hasil = $this->belanjam->result_tnota_tahun($tahun);
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_reg_nota;
			$row[] = $r->tempat_pembelian;
			$row[] = $r->anggaran;
			$row[] = number_format($r->total_belanja);
			$row[] = ($r->file_nota == 'file blank') ? 'Belum' : 'Selesai';
			$row[] = '
			<div class="row">
			<a class="btn btn-sm blue" onclick="show_nota(' . "'" . $r->file_nota . "'" . ')" title="Tampilkan Nota"><i class="fa fa-file"></i></a>
			<a class="btn btn-sm blue" title="Edit"><i class="fa fa-edit" data-toggle="modal" data-target="#formModal"></i></a>
			</div>
			';
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
}
