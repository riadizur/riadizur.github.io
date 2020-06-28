<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kirimdong extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Mailm_gmail');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
	}
	
	public function invoice_kirim()
	{
		$this->load->model("Cetakm");
		
		$cetak = $this->uri->segment(3);;
		$id_lang = $this->uri->segment(4);
		$Rpt = "";

		#$q = $this->db->query("select ID,THBLREK,ID_CUST,EMAIL1 from v_invoice_last WHERE EMAIL1 <> '' limit 1");
		$q = $this->db->query("select ID,THBLREK,ID_CUST,EMAIL1 from temp_v_invoice_last limit 1");
		foreach ($q->result() as $data)
		{
			$EMAIL1 = $data->EMAIL1;
			$idini  = $data->ID;
			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln); 
			$thblrekx = $bulan."_".$thn;
			
			$subject	  = "Cetakan_Invoice_rekening_".$idini."_".$thblrekx;
			#$Emailto  = $EMAIL1;
			$Emailto  = "ilham.dwika.arditya@gmail.com";
			$attach = FCPATH.'upload/'.$subject.'.pdf';
			echo $subject;
			echo $Emailto;
			echo $attach;
		}
		
			$this->Mailm_gmail->send_mail($subject,$Emailto,$attach,$message='<h1> Berikut kita lampirkan </h1>');
	}
	
}