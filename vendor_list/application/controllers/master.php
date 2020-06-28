<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master extends CI_Controller {

	public function area(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();			
			$this->load->view('head',$data);
			//$datax['prev']=$this->mbelanja->lap_kelbel();
			//$this->load->view('belanja/kel_bel',$datax);
			$this->load->view('master/area');
		}else{
			redirect('welcome/index');
		}
	}
	
}