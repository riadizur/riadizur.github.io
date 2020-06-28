<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoring extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('referensim');
		$this->load->model('monitoringm');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function daftarblacklist(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('monitoring/daftarblacklist');
		}else{
			redirect('welcome/index');
		}
	}

	public function daftarblacklist_list()
	{
		$list = $this->monitoringm->get_datatables_blacklist();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pelayanan->id_vd;
			$row[] = $pelayanan->nama_pt;
			$row[] = $pelayanan->tgl_awal;
			$row[] = $pelayanan->tgl_akhir;
			$row[] = $pelayanan->keterangan;
			$row[] = $pelayanan->blacklist_oleh;
			$row[] = $this->status_nolsatu($pelayanan->status_blacklist);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->monitoringm->count_all_bl(),
						"recordsFiltered" => $this->monitoringm->count_filtered_bl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function daftarperijinan(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('monitoring/daftarperijinan');
		}else{
			redirect('welcome/index');
		}
	}

	public function daftarperijinan_list()
	{
		$list = $this->monitoringm->get_datatables_vendor();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pelayanan->id_vd;
			$row[] = $pelayanan->nama_pt;
			$row[] = $this->status_vendor($pelayanan->data_administrasi);
			$row[] = $this->status_vendor($pelayanan->data_domisili);
			$row[] = $this->status_vendor($pelayanan->tgl_domisili);
			$row[] = $this->status_vendor($pelayanan->data_akta_pendirian);
			$row[] = $this->status_vendor($pelayanan->data_akta_perubahan);
			$row[] = $this->status_vendor($pelayanan->data_npwp);
			$row[] = $this->status_vendor($pelayanan->data_pkp);
			$row[] = $this->status_vendor($pelayanan->data_tdp);
			$row[] = $this->status_vendor($pelayanan->tgl_tdp);
			$row[] = $this->status_vendor($pelayanan->data_siup);
			$row[] = $this->status_vendor($pelayanan->tgl_siup);
			$row[] = $this->status_vendor($pelayanan->data_siujk);
			$row[] = $this->status_vendor($pelayanan->tgl_siujk);
			$row[] = $this->status_vendor($pelayanan->data_siu);
			$row[] = $this->status_vendor($pelayanan->tgl_siu);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->monitoringm->count_all(),
						"recordsFiltered" => $this->monitoringm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	private function status_nolsatu($datax)
	{
		switch ($datax)
		{
			case '0':
					return '<span class="label label-sm label-info"> Telah Berakhir </span>';
				break;
			case '1':
					return '<span class="label label-sm label-danger"> Blacklist </span>';
				break;
		}
	}

	private function status_vendor($datax)
	{
		switch (substr($datax,0,6))
		{
			case '-none-':
					return '<span class="label label-sm label-danger"> Data Kosong </span>';
				break;
			case '-expr-':
					return '<span class="label label-sm label-danger"> Expired, '.substr($datax,6).' </span>';
				break;
			case '-info-':
					return '<span class="label label-sm label-warning"> Data Tidak Lengkap </span>';
				break;
			case '-okeh-':
					return '<span class="label label-sm label-info"> OK </span>';
				break;
			default:
					return $datax;
				break;
		}
	}

	public function daftaraktifpasif(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('monitoring/daftaraktifpasif');
		}else{
			redirect('welcome/index');
		}
	}

	public function daftaraktif_list()
	{
		$list = $this->monitoringm->get_datatables_aktif();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pelayanan->id_vd;
			$row[] = $pelayanan->nama_pt;
			$row[] = $pelayanan->grade_siup;
			$row[] = $pelayanan->grade_siujk;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->monitoringm->count_all_aktif(),
						"recordsFiltered" => $this->monitoringm->count_filtered_aktif(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function daftarpasif_list()
	{
		$list = $this->monitoringm->get_datatables_pasif();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pelayanan->id_vd;
			$row[] = $pelayanan->nama_pt;
			$row[] = $pelayanan->grade_siup;
			$row[] = $pelayanan->grade_siujk;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->monitoringm->count_all_pasif(),
						"recordsFiltered" => $this->monitoringm->count_filtered_pasif(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function daftarrekapkontrak(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('monitoring/daftarrekapkontrak');
		}else{
			redirect('welcome/index');
		}
	}

	public function daftarrekapkontrak_list()
	{
		$list = $this->monitoringm->get_datatables_rv();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $pelayanan->id_vd;
			$row[] = $pelayanan->nama_pt;
			$row[] = $pelayanan->jum_pekerjaan;
			$row[] = $pelayanan->nilai_pekerjaan;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->monitoringm->count_all_rv(),
						"recordsFiltered" => $this->monitoringm->count_filtered_rv(),
						"data" => $data,
				);
		echo json_encode($output);
	}

}
