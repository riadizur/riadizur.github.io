<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mailm_gmail extends CI_Model {
	
	public function send_mail($subject,$Emailto,$attach,$message)
    {		
	set_time_limit(0);
        $config = [
               'useragent' => 'ECO-PORT',
               'protocol'  => 'SMTP',
               'mailpath'  => "\"C:\xampp\sendmail\sendmail.exe\" -t",
               #'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_host' => 'smtp.gmail.com',
               'smtp_user' => 'info.ecopowerport@gmail.com',
               'smtp_pass' => 'EcoPower88',
               'smtp_port' => 465,
               #'smtp_port' => 587,
               'smtp_keepalive' => FALSE,
               'smtp_crypto' => 'SSL',
               'wordwrap'  => TRUE,
               'wrapchars' => 80,
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'validate'  => TRUE,
               'crlf'      => "\r\n",
               'newline'   => "\r\n",
           ];
 
        $this->load->library('email', $config);
		$this->email->set_mailtype("html"); 
        $this->email->from('info.ecopowerport@gmail.com', 'PT ENERGI PELABUHAN INDONESIA');    
        $this->email->to($Emailto);
		$this->email->cc('no-reply@ecopowerport.co.id');
        $this->email->attach($attach);
        $this->email->subject($subject);
        $this->email->message($message);
 
        if ($this->email->send())
        {
			$this->email->clear(TRUE);
        }
        else
        {
            echo 'Error! email tidak dapat dikirim.'.$this->email->print_debugger();
			return false;
        }
		
		
    }
}
?>