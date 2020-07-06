<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailm extends CI_Model {
	
	public function send_mail($subject,$Emailto,$attach,$message)
    {
		set_time_limit(0);
	
		$config = Array(
            'useragent' => 'ECO-PORT',
            'protocol' => 'SMTP',
			'mailpath'  => "\"C:\xampp\sendmail\sendmail.exe\" -t",
            'smtp_host' => 'ssl://mail.ecopowerport.co.id',
			'smtp_user' => 'no-reply@ecopowerport.co.id', 
            'smtp_pass' => 'EcoPower88201', 
            'smtp_port' => 465,
			'smtp_keepalive' => TRUE,
			'smtp_crypto' => 'SSL',
			'wordwrap'  => TRUE,
			'wrapchars' => 80,
            'mailtype' => 'html',
			'charset'   => 'utf-8',
			'validate'  => TRUE,
		    'crlf'      => "\r\n",
		    'newline'   => "\r\n",
        );
 
        $this->load->library('email', $config);
		$this->email->set_mailtype("html");
        $this->email->from('no-reply@ecopowerport.co.id', 'PT ENERGI PELABUHAN INDONESIA');    
        $this->email->to($Emailto);
        $this->email->cc('no-reply@ecopowerport.co.id');
        $this->email->attach($attach);
        $this->email->subject($subject);
        $this->email->message($message);
 
        if ($this->email->send())
        {
			$this->email->clear(TRUE);
			return true;
        }
        else
        {
            echo 'Error! email tidak dapat dikirim.'.$this->email->print_debugger();
			return false;
        }
		
    } 
	
	public function send_email_resmi($jen_mail,$kode_register,$EMAIL,$subject,$attach)
	{		
		$sekarang = date("Y-m-d");
		$sekaranglog = date("Y-m-d H:i:s");
		$master_perusahaan=$this->db_models->result_array('master_perusahaan',array('kode_register'=>$kode_register));
		// $EMAIL=$this->db_models->row('master_pic',array('kode_register'=>$kode_register),'email_pic');
		$data['nama_pt'] = $master_perusahaan[0]['nama_perusahaan'];
		$data['prov_pt'] = $master_perusahaan[0]['prov'];
		$kode_vendor = $master_perusahaan[0]['kode_register'];
		// $attach='';
		switch($jen_mail){
			case 'registrasi' : $data['isi']='Terima kasih telah melakukan registrasi vendor list PT. Energi Pelabuhan Indonesia dengan nomor registrasi <strong>' . $kode_register . '</strong>.<br></br>
								Selanjutnya berkas yang telah di upload akan diverifikasi oleh Panitia Pengadaan PT. Energi Pelabuhan Indonesia. Apabilas berkas-berkas tersebut telah memenuhi syarat, maka akan diterbitkan ID Vendor. Namun apabila berkas-berkas anda tidak memenuhi syarat, maka akan diminta untuk melengkapi kembali.
								';break;
			case 'disetujui' : $data['isi']='Panitia Pengadaan PT. Energi Pelabuhan Indonesia telah melakukan verifikasi berkas-berkas yang di telah upload kedalam aplikasi vendor list dengan nomor registrasi <strong>' . $kode_register . '</strong>.<br></br>
								Dengan ini Panitia Pengadaan menyatakan bahwa berkas-berkas tersebut telah memenuhi syarat dan ketentuan yang dibutuhkan untuk menjadi Vendor / Mitra PT. Energi Pelabuhan Indonesia, adapun berkas yang telah diupload dan hasil verifikasi sebagaimana terlampir.
								Selanjutnya Panitia Pengadaan menerbitkan ID Vendor dengan Nomor: <div align="center"><font size="5"><strong>' . $kode_vendor . '</strong></font></div>.<br><div align="justify">
								ID Vendor ini digunakan untuk login ke aplikasi pengadaan melalui website PT. Energi Pelabuhan Indonesia dengan alamat <a href=www.ecopowerport.co.id/tata-cara-pengadaan>www.ecopowerport.co.id/tata-cara-pengadaan</a>.<br></br>
								Seluruh informasi terkait kode unik, verifikasi data, undangan akan alamat email PIC yang telah terdaftar, untuk itu segera lakukan perubahan data PIC apabila ada pergantian PIC Perusahaan.</div>
								';
								// $attach=FCPATH.'assets/upload_file/'.$kode_register.'/pdf/disetujui.pdf';
								break;
			case 'ditolak' : $data['isi']='Panitia Pengadaan PT. Energi Pelabuhan Indonesia telah melakukan verifikasi berkas-berkas yang di telah upload kedalam aplikasi vendor list dengan nomor registrasi <strong>' . $kode_register . '</strong>.<br></br>
								Dengan ini Panitia Pengadaan menyatakan bahwa ada berkas-berkas yang <strong>Belum Memenuhi</strong> syarat dan ketentuan yang dibutuhkan untuk menjadi Vendor / Mitra PT. Energi Pelabuhan Indonesia, adapun berkas yang telah diupload dan hasil verifikasi sebagaimana terlampir.<br></br>
								Selanjutya kami berharap agar berkas-berkas yang <strong>Belum Memenuhi</strong> syarat dan ketentuan segera dilengkapi.
								';
								// $attach=FCPATH.'assets/upload_file/'.$kode_register.'/pdf/disetujui.pdf';
								break;
			case 'OTP' : $data['isi']='Kode OTP <div align="center"><font size="5"><strong>' . $kode_vendor . '</strong></font></div>';
								// $attach=FCPATH.'assets/upload_file/'.$kode_register.'/pdf/disetujui.pdf';
								break;
		}
		$template=$this->load->view('email/template_email_resmi',$data,true);
		$mail = $this->send_mail($subject,$EMAIL,$attach,$template);
		// $this->dbx = $this->load->database('dbx', TRUE);
		// if($mail){					
		// 	$this->dbx->query("INSERT INTO log_sentmail (PENERIMA, SUBJECT, EMAIL, TGL_KIRIM, ATTACHMENT, NOTIFIKASI, STATUS) VALUES ('INTERNAL ASEOS','$subject','$EMAIL','$sekaranglog','','PERMOHONAN (INTERNAL ASEOS)', '200 Webmail' )  ");
		// }else{
		// 	$this->dbx->query("INSERT INTO log_sentmail (PENERIMA, SUBJECT, EMAIL, TGL_KIRIM, ATTACHMENT, NOTIFIKASI, STATUS) VALUES ('INTERNAL ASEOS','$subject','$EMAIL','$sekaranglog','','PERMOHONAN (INTERNAL ASEOS)', '500 Webmail' )  ");
		// }
	} 
	public function send_otp($kode_otp,$EMAIL)
	{		
		$sekarang = date("Y-m-d");
		$sekaranglog = date("Y-m-d H:i:s");
		if($kode_otp!='maintainance'){
			$data['isi']='Kode One Time Password (OTP) : <div align="center"><font size="5"><strong>' . $kode_otp . '</strong></font></div>';
			$subject = 'Kode OTP login aplikasi pengadaan PT. Energi Pelabuhan Indonesia';
		}else{
			$data['isi']='System Maintainance, aplikasi saat ini masih belum bisa diakses. Mohon maaf atas ketidaknyaman ini.';
			$subject = 'System Maintainance';
		}
		$template=$this->load->view('email/template_otp',$data,true);
		$mail = $this->send_mail($subject,$EMAIL,'',$template);
		// $this->dbx = $this->load->database('dbx', TRUE);
		// if($mail){					
		// 	$this->dbx->query("INSERT INTO log_sentmail (PENERIMA, SUBJECT, EMAIL, TGL_KIRIM, ATTACHMENT, NOTIFIKASI, STATUS) VALUES ('INTERNAL ASEOS','$subject','$EMAIL','$sekaranglog','','PERMOHONAN (INTERNAL ASEOS)', '200 Webmail' )  ");
		// }else{
		// 	$this->dbx->query("INSERT INTO log_sentmail (PENERIMA, SUBJECT, EMAIL, TGL_KIRIM, ATTACHMENT, NOTIFIKASI, STATUS) VALUES ('INTERNAL ASEOS','$subject','$EMAIL','$sekaranglog','','PERMOHONAN (INTERNAL ASEOS)', '500 Webmail' )  ");
		// }
	}
	
}
?>