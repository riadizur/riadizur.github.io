<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$username = $this->input->post('username');
		$password =  $this->input->post('password');
		$hasil= $this->mmenu->validate($username,$password);
		if($hasil==true){
			$this->dashboard();
		}else{
            $this->load->view('login');
		}
	}

	public function dashboard(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);

			#$this->load->view('content',$datax);
			$this->load->view('content');
		}else{
			$this->load->view('login');
		}
	}



	public function logout(){
		$this->session->userdata['username']='';
		$this->session->userdata['usermenu']='';
		$this->session->userdata['usermenu2']='';
		$this->session->userdata['ket']='';

		$CI =& get_instance();
		$CI->session->sess_destroy();
		$this->load->view('login');
	}

}
