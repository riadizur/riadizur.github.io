<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilitas extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('utilitasm');
	}

	public function otoritas(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();			
			$this->load->view('head',$data);
			$datax['nama']=$this->utilitasm->get_nama();
			$this->load->view('utilitas/otoritas',$datax);
		}else{
			redirect('welcome/index');
		}
	}
	
	public function otoritas_list() 
	{
		$list = $this->utilitasm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $utilitas) {
			$no++;
			$row = array();
			$row[] = [];
			$row[] = $utilitas->menu;
			$row[] = $utilitas->otori;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->utilitasm->count_all(),
						"recordsFiltered" => $this->utilitasm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function otoritas_edit($id)
	{
		$data = $this->utilitasm->get_by_id_full($id);
		echo json_encode($data);
	}

	public function otoritas_add()
	{
			$datac = array(
				'ID_CUST' => $this->input->post('id_cust'),
			);
			$insert = $this->utilitasm->save('cust',$datac);
			echo json_encode(array("status" => TRUE));
	}

	public function otoritas_update()
	{
		$datac = array(
			'ID_CUST' => $this->input->post('id_cust'),
			'NAMA_CUST' => $this->input->post('nama_cust'),
			'ALAMAT_CUST' => $this->input->post('alamat_cust'),
			'KOGOL' => $this->input->post('kogol'),
			'KDPOS_CUST' => $this->input->post('kdpos_cust'),
			'NPWP_CUST' => $this->input->post('npwp_cust'),
			'NAMA_PIMPINAN' => $this->input->post('nama_pimpinan'),
			'JAB_PIMPINAN' => $this->input->post('jab_pimpinan'),
			'HP1' => $this->input->post('hp1'),
			'HP2' => $this->input->post('hp2'),
			'EMAIL1' => $this->input->post('email1'),
			'EMAIL2' => $this->input->post('email2'),
			'TELP' => $this->input->post('telp'),
			'TGL_UPDATE_CUST' => date('Y-m-d'),
			'USER_ENTRY' => $this->session->userdata('ket')
		);
		$this->utilitasm->update('cust',array('ID_CUST' => $this->input->post('id_cust')), $datac);		
		echo json_encode(array("status" => TRUE));
	}

	public function otoritas_delete($id)
	{
		$this->utilitasm->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
}