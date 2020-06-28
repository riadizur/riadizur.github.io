<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Templateemail extends CI_Controller {
	
	public function index(){
		redirect('welcome/index');
	}
	
    public function pemutusansementara(){
		$this->load->view('laporan/template_pemutusansementara');
	}
	
	public function billing(){
		$this->load->view('laporan/template_billing');
	}
}