<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Kontrak extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('kontrakm');
		date_default_timezone_set('Asia/Jakarta');
	}

	private function id_kontrak()
	{
		$tot = $this->db->query("SELECT count(id_kontrak) as tot from tkontrak")->row("tot");
		$last = $tot + 1;
		$id_baru = "K-" . $last . mt_rand(10, 99);
		return $id_baru;
	}

	public function id_pemeliharaan()
	{
		$tot = $this->db->query("SELECT count(id_kontrak) as tot from tkontrak")->row("tot");
		$last = $tot + 1;
		$id_baru = "H-" . $last . mt_rand(10, 99);
		echo json_encode($id_baru);
	}

	public function id_pemeliharaan_new()
	{
		$tot = $this->db->query("SELECT count(id_kontrak) as tot from tkontrak")->row("tot");
		$last = $tot + 1;
		$id_baru = "H-" . $last . mt_rand(10, 99);
		return $id_baru;
	}

	public function entri()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['id_kontrak'] = $this->id_kontrak();
			$datax['tp_klp'] = $this->kontrakm->kontrak_pemberi();
			$datax['kd_area'] = $this->kontrakm->get_kd_area();
			$datax['prov'] = $this->kontrakm->get_prov();
			$this->load->view('kontrak/entri', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function get_kab($id)
	{
		$data_id = $this->kontrakm->get_kab($id);
		echo json_encode($data_id);
	}

	public function get_kec($id)
	{
		$data_id = $this->kontrakm->get_kec($id);
		echo json_encode($data_id);
	}

	public function get_pt()
	{
		$id = $this->input->post('id');
		$data_id = $this->kontrakm->get_pt($id);
		echo json_encode($data_id);
	}

	public function get_agenda()
	{
		$data_id = $this->kontrakm->get_agenda();
		echo json_encode($data_id);
	}

	public function get_data_agenda()
	{
		$no_agenda = $this->input->post('id');
		$data_id = $this->kontrakm->get_detil_agenda($no_agenda);
		echo json_encode($data_id);
	}

	public function get_kontrak()
	{
		$data_id = $this->kontrakm->get_kontrak();
		echo json_encode($data_id);
	}

	public function get_divisi()
	{
		$data_id = $this->kontrakm->get_divisi();
		echo json_encode($data_id);
	}

	function kontrak_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$tabel = $this->kontrakm->get_kolom_tkontrak();
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {
				case 'id_kontrak':
					$cek_id = $this->input->post("id_kontrak");
					$cek = $this->db->query("Select * from tkontrak where id_kontrak = '$cek_id' ");
					if ($cek->num_rows() > 0) {
						$id_baru = $this->id_kontrak();
						$data[$kolom->COLUMN_NAME] = strtoupper($id_baru);
						$ini_id_kontrak = $id_baru;
					} else {
						$data[$kolom->COLUMN_NAME] = strtoupper($cek_id);
						$ini_id_kontrak = $cek_id;
					}

					break;
				case 'kec':
					$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_kec($this->input->post($kolom->COLUMN_NAME))->nama);
					break;
				case 'kab':
					$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_kab($this->input->post($kolom->COLUMN_NAME))->nama);
					break;
				case 'prov':
					$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_prov($this->input->post($kolom->COLUMN_NAME))->nama);
					break;
				case 'klp_pemberi_kerja':
					$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_klp($this->input->post($kolom->COLUMN_NAME))->nama);
					break;
				case 'id_cust':
					$cek_id_cust = $this->input->post('pemberi_pekerjaan');
					if (strlen($cek_id_cust) == '7') {
						$data[$kolom->COLUMN_NAME] = $cek_id_cust;
					} else {
						if ($cek_id_cust == 'PERMOHONAN PELANGGAN') {
							$no_agenda = $this->input->post('daftar_agenda');
							$data[$kolom->COLUMN_NAME] = $this->kontrakm->get_detil_agenda($no_agenda)->ID_CUST;
						} else {
							$data[$kolom->COLUMN_NAME] = "999";
						}
					}
					break;
				case 'pemberi_pekerjaan':
					$cek_pemberi_pekerjaan = $this->input->post('pemberi_pekerjaan');
					if (strlen($cek_pemberi_pekerjaan) == '7') {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_pt($cek_pemberi_pekerjaan)->nama);
					} else {
						if ($cek_pemberi_pekerjaan == 'PERMOHONAN PELANGGAN') {
							$data[$kolom->COLUMN_NAME] = $cek_pemberi_pekerjaan;
						} else {
							$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post('daftar_divisi'));
						}
					}
					break;
				case 'nilai_kontrak':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post($kolom->COLUMN_NAME));
					break;
				case 'estimasi_biaya':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post($kolom->COLUMN_NAME));
					break;
				case 'tahun_kontrak':
					$data[$kolom->COLUMN_NAME] = substr($this->input->post('mulai_kontrak'), 0, 4);
					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'no_kontrak':
					$cek_no_kontrak = $this->input->post('no_kontrak');
					if ($cek_no_kontrak == '' or $cek_no_kontrak == '-') {
						$ambil_no_kontrak = $ini_id_kontrak . ' - No. Kontrak Kosong';
					} else {
						$ambil_no_kontrak = $cek_no_kontrak;
					}
					$data[$kolom->COLUMN_NAME] = $ambil_no_kontrak;
					break;
				case 'kd_area':
					$cek_kd_area = substr($this->input->post('kd_area'), 3, 5);
					$data[$kolom->COLUMN_NAME] = $cek_kd_area;
					break;
				case 'kategori_pekerjaan':
					$cek_jp = $this->input->post('jns_pekerjaan');
					if ($cek_jp == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = 'pemeliharaan';
					} else {
						$data[$kolom->COLUMN_NAME] = 'kontraktor';
					}
					break;
				case 'jns_pekerjaan':
					$data[$kolom->COLUMN_NAME] = $this->input->post('jns_pekerjaan');
					break;
				default:
					if ($this->input->post($kolom->COLUMN_NAME)) {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					} else {
						$data[$kolom->COLUMN_NAME] = '';
					}
					break;
			}
		}
		$this->kontrakm->save('tkontrak', $data);
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}

	public function rekap()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$this->load->view('kontrak/rekap');
		} else {
			redirect('welcome/index');
		}
	}

	public function list_kontrak()
	{
		$data = array();

		$i = 1;
		$q = "SELECT * FROM tkontrak ORDER BY id desc";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->id_kontrak;
			$row[] = $r->no_kontrak;
			$row[] = $r->pemberi_pekerjaan;
			$row[] = $r->nama_pekerjaan;
			$row[] = number_format($r->nilai_kontrak);
			$row[] = number_format($r->estimasi_biaya);
			$row[] = '<a class="btn btn-sm blue" onclick="show_kontrak(' . "'" . $r->id_kontrak . "'" . ')" title="Tampil Detil"><i class="glyphicon glyphicon-list"></i></a>';

			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_data_kontrak()
	{
		$id_kontrak = $this->input->post('id_kontrak');

		$hasil = $this->kontrakm->get_data_kontrak($id_kontrak);
		foreach ($hasil as $kolom) {
			$data['id_kontrak'] = $kolom->id_kontrak;
			$data['no_kontrak'] = $kolom->no_kontrak;
			$data['nama_pekerjaan'] = $kolom->nama_pekerjaan;
			$data['lokasi_pekerjaan'] = $kolom->lokasi_pekerjaan;
			$data['nilai_kontrak'] = number_format($kolom->nilai_kontrak);
			$data['estimasi_biaya'] = number_format($kolom->estimasi_biaya);
			$data['tanggal'] = tanggal_ttd($kolom->mulai_kontrak) . " s/d " . tanggal_ttd($kolom->akhir_kontrak);
			$data['durasi_kontrak'] = $kolom->durasi_kontrak . " hari";
			$data['pemberi_pekerjaan'] = $kolom->pemberi_pekerjaan;
			$data['klp_pemberi_kerja'] = $kolom->klp_pemberi_kerja;
			$data['keterangan'] = $kolom->keterangan;
		}

		$data['status'] = TRUE;
		echo json_encode($data);
	}

	public function daftar()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$this->load->view('kontrak/daftar');
		} else {
			redirect('welcome/index');
		}
	}

	public function kontrak_update()
	{
		$id_kontrak = $this->input->post('id_kontrak');

		$data['no_kontrak'] = $this->input->post('no_kontrak');
		$data['nama_pekerjaan'] = $this->input->post('nama_pekerjaan');
		$data['keterangan'] = $this->input->post('keterangan');
		$data['nilai_kontrak'] = str_replace(',', '', $this->input->post('nilai_kontrak'));
		$data['estimasi_biaya'] = str_replace(',', '', $this->input->post('estimasi_biaya'));

		$this->kontrakm->update('tkontrak', array('id_kontrak' => $id_kontrak), $data);
		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	public function rekapperkontrak()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$data['tahun'] = $this->kontrakm->rekapperkontrak_tahun();
			$this->load->view('kontrak/rekapperkontrak', $data);
		} else {
			redirect('welcome/index');
		}
	}

	public function list_rekapperkontrak()
	{
		$data = array();
		$thn = $this->input->post('tahun');
		if ($thn) {
			$q = "SELECT * FROM vrekap_perkontrak where tahun_kontrak = '$thn' ";
		} else {
			$q = "SELECT * FROM vrekap_perkontrak where tahun_kontrak = (select max(tahun_kontrak) as thn from vrekap_perkontrak limit 1 ) ";
		}

		$i = 1;
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r) {
			$row = array();
			$row[] = $i++;
			$row[] = $r->no_kontrak;
			$row[] = $r->nama_pekerjaan;
			$row[] = $r->pemberi_pekerjaan;
			$row[] = number_format($r->pengeluaran);
			$data[] = $row;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function swakelola()
	{
		if ($this->session->userdata('nama') <> '') {
			$data['prev'] = $this->mmenu->main_menu();
			$this->load->view('head', $data);
			$datax['agenda_list'] = $this->kontrakm->get_agenda_list();
			$datax['prov'] = $this->kontrakm->get_prov();
			$datax['id_kontrak'] = $this->id_pemeliharaan_new();
			$datax['tp_klp'] = $this->kontrakm->kontrak_pemberi();
			$datax['kd_area'] = $this->kontrakm->get_kode_area_list();
			$datax['coa_seg_3'] = $this->kontrakm->get_coa_seg_3_list();
			$this->load->view('kontrak/swakelola', $datax);
		} else {
			redirect('welcome/index');
		}
	}

	public function get_agenda_data($no_agenda = '')
	{
		$data =  $this->kontrakm->get_agenda_result($no_agenda);
		echo json_encode($data);
	}

	function swakelola_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');

		$data = array();
		$tabel = $this->kontrakm->get_kolom_tkontrak();
		$no_agenda = $this->input->post('no_agenda');
		$jenis_pekerjaan = $this->input->post('jenis_pekerjaan');
		foreach ($tabel as $kolom) {
			switch ($kolom->COLUMN_NAME) {
				case 'id_kontrak':
					$cek_id = $this->input->post("id_kontrak");
					$cek = $this->db->query("Select * from tkontrak where id_kontrak = '$cek_id' ");
					if ($cek->num_rows() > 0) {
						$id_baru = $this->id_kontrak();
						$data[$kolom->COLUMN_NAME] = strtoupper($id_baru);
					} else {
						$data[$kolom->COLUMN_NAME] = strtoupper($cek_id);
					}
					break;
				case 'no_kontrak':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post('no_kontrak'));
					} else {
						$data[$kolom->COLUMN_NAME] = $this->input->post('no_agenda');
					}
					break;
				case 'kec':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_kec($this->input->post($kolom->COLUMN_NAME))->nama);
					} else {
						$data[$kolom->COLUMN_NAME] = $this->input->post('kec2');
					}

					break;
				case 'kab':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_kab($this->input->post($kolom->COLUMN_NAME))->nama);
					} else {
						$data[$kolom->COLUMN_NAME] = $this->input->post('kab2');
					}
					break;
				case 'prov':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->kontrakm->ambil_prov($this->input->post($kolom->COLUMN_NAME))->nama);
					} else {
						$data[$kolom->COLUMN_NAME] = $this->input->post('prov2');
					}
					break;
				case 'id_cust':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = "999";
					} else {
						$data[$kolom->COLUMN_NAME] = $this->kontrakm->get_id_cust($no_agenda);
					}
					break;
				case 'nilai_kontrak':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post($kolom->COLUMN_NAME));
					break;
				case 'estimasi_biaya':
					$data[$kolom->COLUMN_NAME] = str_replace(',', '', $this->input->post($kolom->COLUMN_NAME));
					break;
				case 'tahun_kontrak':
					$data[$kolom->COLUMN_NAME] = substr($this->input->post('mulai_kontrak'), 0, 4);
					break;
				case 'tgl_create':
					$data[$kolom->COLUMN_NAME] = $sekarang;
					break;
				case 'COA_SEG1':
					$data[$kolom->COLUMN_NAME] = '13';
					break;
				case 'COA_SEG2':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$kd_areax = $this->input->post('kd_area');
						$data[$kolom->COLUMN_NAME] = $this->kontrakm->get_coa_seg_2_kontrak($kd_areax);
					} else {
						$data[$kolom->COLUMN_NAME] = $this->kontrakm->get_coa_seg_2_agenda($no_agenda);
					}
					break;
				case 'COA_SEG3':
					$data[$kolom->COLUMN_NAME] = $this->input->post('coa_seg_3');
					break;
				case 'COA_SEG4':
					$data[$kolom->COLUMN_NAME] = '1621';
					break;
				case 'COA_SEG5':
					$data[$kolom->COLUMN_NAME] = '70601101';
					break;
				case 'COA_SEG6':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = "999";
					} else {
						$data[$kolom->COLUMN_NAME] =  $this->kontrakm->get_coa_seg_6_agenda($no_agenda);
					}
					break;
				case 'COA_SEG7':
					$data[$kolom->COLUMN_NAME] = '999999';
					break;
				case 'COA_SEG8':
					if ($jenis_pekerjaan == 'pemeliharaan') {
						$data[$kolom->COLUMN_NAME] = "99999";
					} else {
						$data[$kolom->COLUMN_NAME] =  $this->kontrakm->get_coa_seg_8_agenda($no_agenda);
					}
					break;
				case 'COA_SEG9':
					$data[$kolom->COLUMN_NAME] = '99999';
					break;
				default:
					if ($this->input->post($kolom->COLUMN_NAME)) {
						$data[$kolom->COLUMN_NAME] = strtoupper($this->input->post($kolom->COLUMN_NAME));
					} else {
						$data[$kolom->COLUMN_NAME] = '';
					}
					break;
			}
		}
		$this->kontrakm->save('tkontrak', $data);
		$data_all['status'] = TRUE;
		//print_r($data_all);
		echo json_encode($data_all);
	}
}
