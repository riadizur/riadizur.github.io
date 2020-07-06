<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

class Vendor extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_models');
		$this->load->model('jquery_models');
		$this->load->model('menum');
		$this->load->model('mailm');
	}
	public function index()
	{
        $this->load->view('vendor/home');  
	}
	public function blast_email(){
		$all=$this->db_models->result('master_perusahaan',array());
		$x=1;
		foreach($all as $a){
			$email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_register),'email_pic'));
			$this->mailm->send_notification('perbaikan_data',$a->kode_register,$email_pic,'Kelengkapan Data Bidang Usaha','');
			echo 'Done send message to '.$email_pic.'<br>';
			$x++;
		}
	} 
	public function blast_email_publish($kode_project='',$nama_project=''){

		// $all=$this->db_models->result('tp_transaksi_project',array('kode_project'=>$kode_project,'pengumuman'=>'1','anwizing'=>NULL));
		$all=$this->db_models->result('master_bidang_pekerjaan',array('kode_bidang'=>'PBL'));
		// var_dump($all);
		$x=1;
		foreach($all as $a){
			// if($x==1){
			// $email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
			$email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_register),'email_pic'));
			$this->mailm->send_notification('pengadaan',$a->kode_register,$email_pic,'Pemberitahuan Pengaktifan Akun Pengadaan PT. Energi Pelabuhan Indonesia','');
			// $this->mailm->send_notification('pengadaan',$a->kode_register,'adi.zuriadi@gmail.com',$nama_project.' - '.$email_pic,'');
			echo 'Done send message to '.$email_pic.'<br>';
			// }
			$x++;
		}
	} 
	public function blast_email_publish_pengadaan($kode_project=''){
		$all=$this->db_models->result('tp_transaksi_project',array('kode_project'=>$kode_project,'pengumuman'=>'1','anwizing'=>NULL));
		$nama_project=$this->db_models->row('tp_master_project',array('kode_project'=>$kode_project),'nama_project');
		// $all=$this->db_models->result('master_bidang_pekerjaan',array('kode_bidang'=>'PBL'));
		// var_dump($all);
		$x=1;
		foreach($all as $a){
			$email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
			// if($x==1){
				// $email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
				// $this->mailm->send_notification('pengadaan',$a->kode_register,$email_pic,'Pemberitahuan Pengaktifan Akun Pengadaan PT. Energi Pelabuhan Indonesia','');
				// $this->mailm->send_notification('pengadaan_baru',$a->kode_vendor,'adi.zuriadi@gmail.com',$nama_project.' - '.$email_pic,'');
				$this->mailm->send_notification('pengadaan_baru',$a->kode_vendor,$email_pic,$nama_project,'');
			// }
			echo 'Done send message to '.$email_pic.'<br>';
			$x++;
		}
	}  
	public function blast_email_publish_undangan($kode_project=''){
		$all=$this->db_models->result('tp_transaksi_project',array('kode_project'=>$kode_project,'pengumuman'=>'1','anwizing'=>NULL));
		$nama_project=$this->db_models->row('tp_master_project',array('kode_project'=>$kode_project),'nama_project');
		// $all=$this->db_models->result('master_bidang_pekerjaan',array('kode_bidang'=>'PBL'));
		// var_dump($all);
		$x=1;
		foreach($all as $a){
			$email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
			// if($x==1){
				// $email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
				// $this->mailm->send_notification('pengadaan',$a->kode_register,$email_pic,'Pemberitahuan Pengaktifan Akun Pengadaan PT. Energi Pelabuhan Indonesia','');
				// $this->mailm->send_notification('pengadaan_baru',$a->kode_vendor,'adi.zuriadi@gmail.com',$nama_project.' - '.$email_pic,'');
				$this->mailm->send_notification('maintainance_selesai',$a->kode_vendor,$email_pic,'Undangan Penawaran','');
			// }
			echo 'Done send message to '.$email_pic.'<br>';
			$x++;
		}
	}  
	public function blast_email_penawaran_berakhir($kode_project=''){
		$all=$this->db_models->result('tp_transaksi_project',array('kode_project'=>$kode_project,'pengumuman'=>'1','anwizing'=>NULL));
		$nama_project=$this->db_models->row('tp_master_project',array('kode_project'=>$kode_project),'nama_project');
		// $all=$this->db_models->result('master_bidang_pekerjaan',array('kode_bidang'=>'PBL'));
		// var_dump($all);
		$x=1;
		foreach($all as $a){
			$email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
			if($x==1){
				// $email_pic=strtolower($this->db_models->row('master_pic',array('kode_register'=>$a->kode_vendor),'email_pic'));
				// $this->mailm->send_notification('pengadaan',$a->kode_register,$email_pic,'Pemberitahuan Pengaktifan Akun Pengadaan PT. Energi Pelabuhan Indonesia','');
				// $this->mailm->send_notification('pengadaan_baru',$a->kode_vendor,'adi.zuriadi@gmail.com',$nama_project.' - '.$email_pic,'');
				$this->mailm->send_notification('penawaran_mau_berakhir',$a->kode_vendor,'adi.zuriadi@gmail.com','Undangan Penawaran','');
				// $this->mailm->send_notification('penawaran_mau_berakhir',$a->kode_vendor,$email_pic,'Undangan Penawaran','');
			}
			echo 'Done send message to '.$email_pic.'<br>';
			$x++;
		}
	}  
}