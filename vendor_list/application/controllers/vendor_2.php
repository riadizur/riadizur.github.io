<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendor extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('referensim');
		$this->load->model('vendorm');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function entri(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prov_list']=$this->referensim->get_prov();
			$datax['list_kbli']=$this->referensim->get_kbli_detil_list();
			$datax['list_grade']=$this->referensim->get_grade();
			$datax['list_siujk']=$this->referensim->get_siujk_detil_list();

			$this->load->view('vendor/entri_4',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function get_chain_kab($id){
		$data_id = $this->referensim->get_chain_kab($id);
		echo json_encode($data_id);
	}

	public function get_chain_kec($id){
		$data_id = $this->referensim->get_chain_kec($id);
		echo json_encode($data_id);
	}

	public function vendor_baru($id_1)
	{
		$last = $this->vendorm->count_all();
		$rand = mt_rand(0,9);
		switch (strlen($last))
		{
			case '1':
					$id_2 = '0'.$last.$rand;
				break;
			case '2':
					$id_2 = $last.$rand;
				break;
		}
		$id_vds = $id_1.$id_2;
		$output = array(
						"id_vd" => $id_vds,
						"status" => TRUE,
		);
		echo json_encode($output);
	}

	public function list_siup_show()
	{
		$id_vd = @$this->input->post('id_vd');
		$list = $this->referensim->get_datatables_siup($id_vd);
		$data = array();
		$no = 1;
		foreach ($list as $r) {
			$row = array();
			$row[] = $no++;
			$row[] = $r->kode_siup;
			$row[] = $r->bidang_siup;
			$row[] = '<a class="btn btn-sm red" onclick="del_siup(this)" title="Hapus dari list"><i class="glyphicon glyphicon-minus"></i></a>';
			$data[] = $row;
		}
		$output = array(
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function list_siup_insert($id_vds, $kodex)
	{
		$datax = array();
		$cek = $this->referensim->cek_kode_siup($id_vds, $kodex);
		if($cek > 0){
			$datax['status'] = FALSE;
		}
		else {
			$data = $this->referensim->get_kbli_detil_kode($kodex);
			$data_siup['kode_siup'] = $data->kode;
			$data_siup['bidang_siup'] = $data->deskripsi;
			$data_siup['id_vd'] = $id_vds;

			$this->referensim->save('tvd_siup',$data_siup);
			$datax['status'] = TRUE;
		}

		echo json_encode($datax);
	}

	public function list_siup_delete($id_vd, $kode)
	{
		$this->referensim->delete_by_siup($id_vd,$kode);
		echo json_encode(array("status" => TRUE));
	}

	public function list_siujk_show()
	{
		$id_vd = @$this->input->post('id_vd');
		$list = $this->referensim->get_datatables_siujk($id_vd);
		$data = array();
		$no = 1;
		foreach ($list as $r) {
			$row = array();
			$row[] = $no++;
			$row[] = $r->kode_siujk;
			$row[] = $r->bidang_siujk;
			$row[] = $r->grade_sub_siujk;
			$row[] = '<a class="btn btn-sm red" onclick="del_siujk(this)" title="Hapus dari list"><i class="glyphicon glyphicon-minus"></i></a>';
			$data[] = $row;
		}
		$output = array(
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function list_siujk_insert($id_vds, $kodex)
	{
		$datax = array();
		$cek = $this->referensim->cek_kode_siujk($id_vds, $kodex);
		if($cek > 0){
			$datax['status'] = FALSE;
		}
		else {
			$data = $this->referensim->get_siujk_detil_kode($kodex);
			$data_siujk['kode_siujk'] = $data->kode;
			$data_siujk['bidang_siujk'] = $data->deskripsi;
			$data_siujk['id_vd'] = $id_vds;

			$this->referensim->save('tvd_siujk',$data_siujk);
			$datax['status'] = TRUE;
		}

		echo json_encode($datax);
	}

	public function list_siujk_delete($id_vd, $kode)
	{
		$this->referensim->delete_by_siujk($id_vd,$kode);
		echo json_encode(array("status" => TRUE));
	}

	public function list_siu_show()
	{
		$id_vd = @$this->input->post('id_vd');
		$list = $this->referensim->get_datatables_siu($id_vd);
		$data = array();
		$no = 1;
		foreach ($list as $r) {
			$row = array();
			$row[] = $no++;
			$row[] = "SIU-".$r->id;
			$row[] = $r->bidang_siu;
			$row[] = '<a class="btn btn-sm red" onclick="del_siu(this)" title="Hapus dari list"><i class="glyphicon glyphicon-minus"></i></a>';
			$data[] = $row;
		}
		$output = array(
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function list_siu_insert($id_vds)
	{
		$isi = $this->input->post('isi');
		$datax = array();
		$cek = $this->referensim->cek_kode_siu($id_vds, $isi);
		if($cek > 0){
			$datax['status'] = FALSE;
		}
		else {
			$data_siu['bidang_siu'] = $isi;
			$data_siu['id_vd'] = $id_vds;

			$this->referensim->save('tvd_siu',$data_siu);

			$cek = $this->referensim->last_kode_siu($id_vds, $isi);
			$datax['nomor'] = $cek->id;
			$datax['status'] = TRUE;
		}

		echo json_encode($datax);
	}

	public function list_siu_delete($id_vd, $kode)
	{
		$this->referensim->delete_by_siu($id_vd,$kode);
		echo json_encode(array("status" => TRUE));
	}


	public function vendor_add()
	{
		//$this->validasi_inputan();

		$datax = array();
		$datax['error_string'] = array();
		$datax['inputerror'] = array();
		$datax['status'] = TRUE;

		$data_list = array();
		$a = $this->referensim->get_tvd_all();
		foreach ($a as $r)
		{
			$cek = substr($r->COLUMN_NAME,0,4);
			if ($cek == 'file')
			{
				if(!empty($_FILES[$r->COLUMN_NAME]['name']))
				{
					$files = $this->validasi_upload($r->COLUMN_NAME, $id_vds);
					$data_list[$r->COLUMN_NAME] = $files;
				}
			}
			elseif ($r->COLUMN_NAME == 'modal_usaha_siup' or $r->COLUMN_NAME == 'modal_usaha_siujk' or $r->COLUMN_NAME == 'modal_usaha_siu')
			{
				$angka = str_replace(',','',$this->input->post($r->COLUMN_NAME)) ;
				$data_list[$r->COLUMN_NAME] = $angka;
			}
			else
			{
				$data_list[$r->COLUMN_NAME] = $this->input->post($r->COLUMN_NAME);
			}
		}

		if($datax['status'] === FALSE)
		{
			echo json_encode($datax);
			exit();
		}

		$insert_data_list = $this->referensim->save('tvd_list',$data_list);
		echo json_encode(array("status" => TRUE));
	}

	private function validasi_inputan()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$tabel = $this->referensim->get_tvd_all();
		foreach ($tabel as $k)
		{
			$cek = substr($k->COLUMN_NAME,0,4);
			if ($cek == 'file')
			{
				/*
				if(empty($_FILES[$k->COLUMN_NAME]['name']))
				{
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'File tidak boleh kosong';
					$data['status'] = FALSE;
				}
				*/
			}
			else
			{
				if($this->input->post($k->COLUMN_NAME) == '')
				{
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'Tidak boleh kosong';
					$data['status'] = FALSE;
				}
			}
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}

	}

	private function validasi_upload($files,$ids)
	{
			$config['upload_path']          = 'upload/';
			$config['allowed_types']        = 'gif|jpg|png|doc|docx|pdf|xls|xlsx|txt|rar|zip';
			$config['max_size']             = 1000000; //set max size allowed in Kilobyte
			$config['max_width']            = 5000; // set max width image allowed
			$config['max_height']           = 5000; // set max height allowed
			$config['file_name']            = $ids."-".round(microtime(true) * 1000);

			$this->load->library('upload', $config);

			if(!$this->upload->do_upload($files))
			{
					$data['inputerror'][] = $files;
					$data['error_string'][] = 'Gagal Upload: '.$this->upload->display_errors('','');
					$data['status'] = FALSE;
					echo json_encode($data);
					exit();
			}
			return $this->upload->data('file_name');
	}

	public function daftar_vendor(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prov_mohon']=$this->referensim->by_prov();
			$datax['list_kbli']=$this->referensim->get_kbli_detil();
			$datax['list_grade']=$this->referensim->get_grade();
			$datax['list_siujk']=$this->referensim->get_siujk_detil();
			$this->load->view('vendor/daftar_vendor',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function vendor_list()
	{
		$list = $this->vendorm->get_datatables_vendor();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a title="Detil '.$pelayanan->id_vd.' ?" onclick="detil_vendor('."'".$pelayanan->id_vd."'".')" >'.$pelayanan->id_vd.'</a>';
			$row[] = $pelayanan->nama_pt;
			$row[] = $pelayanan->grade_siup;
			$row[] = $pelayanan->grade_siujk;
			$row[] = $pelayanan->nama_pic;
			$row[] = '';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->vendorm->count_all(),
						"recordsFiltered" => $this->vendorm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function vendor_list_1()
	{
		$list = $this->vendorm->get_datatables_vendor();
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
			$row[] = $pelayanan->nama_pic;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_vendor('."'".$pelayanan->id_vd."'".')"><i class="icon-magic-wand"></i> Edit</a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->vendorm->count_all(),
						"recordsFiltered" => $this->vendorm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function vendor_siup($id_vdx = '')
	{
		$data_all = $this->vendorm->get_vendor_siup($id_vdx);
		echo json_encode($data_all);
	}

	public function vendor_siujk($id_vdx = '')
	{
		$data_all = $this->vendorm->get_vendor_siujk($id_vdx);
		echo json_encode($data_all);
	}

	public function vendor_siu($id_vdx = '')
	{
		$data_all = $this->vendorm->get_vendor_siu($id_vdx);
		echo json_encode($data_all);
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

	public function detil_vendor($id_vdx = '')
	{
		$data_all = $this->referensim->get_tvd_list($id_vdx);
		echo json_encode($data_all);
	}

	public function get_chain_kab_mohon($id){
		$data_id = $this->referensim->get_chain_kab_mohon($id);
		echo json_encode($data_id);
	}

	public function get_chain_kec_mohon($id){
		$data_id = $this->referensim->get_chain_kec_mohon($id);
		echo json_encode($data_id);
	}

	public function pembaharuan($id_vdx = '')
	{
		if($this->session->userdata('nama')<>'')
		{
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prov_mohon']=$this->referensim->by_prov();
			$datax['list_kbli']=$this->referensim->get_kbli_detil();
			$datax['list_grade']=$this->referensim->get_grade();
			$datax['list_siujk']=$this->referensim->get_siujk_detil();
			$datax['id_vdx']=$id_vdx;

			$this->load->view('vendor/pembaharuan',$datax);
		}
		else
		{
			redirect('welcome/index');
		}
	}

	public function get_vendor()
	{
		if (isset($_GET['term'])) {
      $result = $this->vendorm->cari_vendor($_GET['term']);
      if (count($result) > 0)
			{
      	foreach ($result as $row)
				{
        	$hasil_result['label'] = $row->id_vd.", ".$row->nama_pt;
					$hasil_result['id'] = $row->id_vd;
					$arr_result[] = $hasil_result;
				}
        echo json_encode($arr_result);
      }
    }
	}

	public function cari_vendor()
	{
		$data_all = $this->permohonanm->get_cl($idcari);
		echo json_encode($data_all);
	}

	public function blacklist(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prov_list']=$this->referensim->get_prov();
			$datax['list_kbli']=$this->referensim->get_kbli_detil();
			$datax['list_grade']=$this->referensim->get_grade();
			$datax['list_siujk']=$this->referensim->get_siujk_detil();

			$this->load->view('vendor/blacklist',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cari_vendor_blacklist()
	{
		if (isset($_GET['term'])) {
      $result = $this->vendorm->cari_vendor_blacklist($_GET['term']);
      if (count($result) > 0)
			{
      	foreach ($result as $row)
				{
					$hasil_result['label'] = $row->id_vd.", ".$row->nama_pt;
					$hasil_result['id'] = $row->id_vd;
					$arr_result[] = $hasil_result;
				}
      }
			else
			{
				$hasil_result['label'] = "Tidak ada kontrak...";
				$hasil_result['id'] = '';
				$arr_result[] = $hasil_result;
			}
			echo json_encode($arr_result);
    }
	}

	public function data_vendor_blacklist($id_vd = '')
	{
		$data_all = $this->referensim->get_tvd_list($id_vd);
		echo json_encode($data_all);
	}

	public function blacklist_add()
	{
		$this->validasi_blacklist();

		$datax = array();
		$datax['error_string'] = array();
		$datax['inputerror'] = array();
		$datax['status'] = TRUE;

		$data_list = array();
		$id_vds = $this->input->post('id_vd')."_bl";
		$a = $this->referensim->get_tblacklist();
		foreach ($a as $r)
		{
			$cek = $r->COLUMN_NAME;

			if ($cek == 'dokumen')
			{
				if(!empty($_FILES[$r->COLUMN_NAME]['name']))
				{
					$files = $this->validasi_upload($r->COLUMN_NAME, $id_vds);
					$data_list[$r->COLUMN_NAME] = $files;
				}
			}
			else
			{
				$data_list[$r->COLUMN_NAME] = $this->input->post($r->COLUMN_NAME);
			}
		}

		$insert_data_siup = $this->referensim->save('tblacklist',$data_list);

		echo json_encode(array("status" => TRUE));
	}

	private function validasi_blacklist()
	{
		$data = array();
		$data['error_string'] = array();
		$data['inputerror'] = array();
		$data['status'] = TRUE;

		$tabel = $this->referensim->get_tblacklist();
		foreach ($tabel as $k)
		{
			$cek = $k->COLUMN_NAME;
			if ($cek == 'dokumen')
			{
				if(empty($_FILES[$k->COLUMN_NAME]['name']))
				{
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'File tidak boleh kosong';
					$data['status'] = FALSE;
				}
			}
			else
			{
				if($this->input->post($k->COLUMN_NAME) == '')
				{
					$data['inputerror'][] = $k->COLUMN_NAME;
					$data['error_string'][] = 'Tidak boleh kosong';
					$data['status'] = FALSE;
				}
			}
		}

		if($data['status'] === FALSE)
		{
			echo json_encode($data);
			exit();
		}

	}

	public function detil_vendor_all($id_vdx = '')
	{
		$data_all = $this->referensim->get_tvd_list_all($id_vdx);
		echo json_encode($data_all);
	}

	public function vendor_update()
	{
		//$this->validasi_inputan();

		$datax = array();
		$datax['error_string'] = array();
		$datax['inputerror'] = array();
		$datax['status'] = TRUE;

		$data_list = array();
		$a = $this->referensim->get_tvd_all();
		foreach ($a as $r)
		{
			$id_vd = $this->input->post('id_vd');

			$cek = substr($r->COLUMN_NAME,0,4);
			if ($cek == 'file')
			{
				if(!empty($_FILES[$r->COLUMN_NAME]['name']))
				{
					$files = $this->validasi_upload($r->COLUMN_NAME, $id_vd);
					$data_list[$r->COLUMN_NAME] = $files;
				}
			}
			elseif($r->COLUMN_NAME == 'id_vd')
			{
				$abaikan_saja = "BODO AMAT";
			}
			elseif($r->COLUMN_NAME == 'kec_vd' or $r->COLUMN_NAME == 'kab_vd' or $r->COLUMN_NAME == 'prov_vd' )
			{
				$abaikan_saja = "BODO AMAT";
			}
			elseif ($r->COLUMN_NAME == 'modal_usaha_siup' or $r->COLUMN_NAME == 'modal_usaha_siujk' or $r->COLUMN_NAME == 'modal_usaha_siu')
			{
				$angka = str_replace(',','',$this->input->post($r->COLUMN_NAME)) ;
				$data_list[$r->COLUMN_NAME] = $angka;
			}
			else
			{
				$data_list[$r->COLUMN_NAME] = $this->input->post($r->COLUMN_NAME);
			}
		}

		if($datax['status'] === FALSE)
		{
			echo json_encode($datax);
			exit();
		}

		$update_data_list = $this->referensim->update('tvd_list',array('id_vd' => $id_vd),$data_list);
		echo json_encode(array("status" => TRUE));
	}

}
