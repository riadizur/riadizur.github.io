<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Sendemail extends CI_Controller {

    public function index()
    {
        $this->load->view('');
    }
 
    public function sending($subject,$to,$attach,$message)
    {

		$config = Array(
            'useragent' => 'ECO-PORT',
            'protocol' => 'smtp',
			'mailpath'  => "\"C:\xampp\sendmail\sendmail.exe\" -t",
            #'smtp_host' => 'ssl://mail.ecopowerport.co.id',
            'smtp_host' => 'mail.ecopowerport.co.id',
            'smtp_port' => 465,
            'smtp_user' => 'no-reply@ecopowerport.co.id', 
            'smtp_pass' => 'EcoPower88201', 
            'mailtype' => 'html',
            #'charset' => 'iso-8859-1',
			'charset'   => 'utf-8',
			'smtp_keepalive' => TRUE,
			'smtp_crypto' => 'SSL',
			'wordwrap'  => TRUE,
			'wrapchars' => 80,
			'validate'  => TRUE,
		   'crlf'      => "\r\n",
		   'newline'   => "\r\n",
        );
		
        /*$config = [
               'useragent' => 'CodeIgniter',
               'protocol'  => 'smtp',
               'mailpath'  => "\"D:\xampp\sendmail\sendmail.exe\" -t",
               #'smtp_host' => 'ssl://smtp.gmail.com',
               'smtp_host' => 'smtp.gmail.com',
               'smtp_user' => 'arditya.ilham@gmail.com',
               'smtp_pass' => '@Trojanhorse777',
               'smtp_port' => 465,
               'smtp_keepalive' => TRUE,
               'smtp_crypto' => 'SSL',
               'wordwrap'  => TRUE,
               'wrapchars' => 80,
               'mailtype'  => 'html',
               'charset'   => 'utf-8',
               'validate'  => TRUE,
               'crlf'      => "\r\n",
               'newline'   => "\r\n",
           ];
		*/
 
        $this->load->library('email', $config);
        $this->email->from('no-reply@ecopowerport.co.id', 'PT ENERGI PELABUHAN INDONESIA');    
        $this->email->to($to);
        $this->email->attach($attach);
        $this->email->subject($subject);
        $this->email->message($message);
 
        if ($this->email->send())
        {
            echo 'Sukses! email berhasil dikirim.'.$this->email->print_debugger();
        }
        else
        {
            echo 'Error! email tidak dapat dikirim.'.$this->email->print_debugger();
        }
    }
}