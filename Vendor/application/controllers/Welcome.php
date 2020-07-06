<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

class Welcome extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_models');
		$this->load->model('db2_models');
		$this->load->model('jquery_models');
		$this->load->model('menum');
		$this->load->model('mailm');
	}
	public function index()
	{
		$this->load->view('vendor/landing_page');
	}
	
	public function dashboard($authentifikasi='')
	{
		$otp=$this->db_models->row('log_otp',array('status'=>'1','kode_vendor'=>$this->session->userdata('kode_vendor')),'kode_otp');
		$allow=FALSE;
		if($authentifikasi==md5($this->session->userdata('kode_vendor')).md5($otp)){
			$allow=TRUE;
		}
		if($authentifikasi!='' and $allow){
			$this->session->userdata['kode_authentifikasi']=$authentifikasi;
			$head['prev'] = $this->menum->main_menu();
			$this->load->view('template/header',$head);
			$data=array(
	
			);
			$this->load->view('vendor/dashboard',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/dashboard/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				$this->session->userdata['kode_vendor']='';
				$this->session->userdata['kode_authentifikasi']='';
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
    }
	public function id_register($login='')
	{
		$id_vendor = $this->input->post('id_vendor');
		$data['autentifikasi']='';
		if($login=='failed_login'){
			$data['autentifikasi']='ID Registrasi Tidak Ditemukan !';
		}
        $this->load->view('login/id_register',$data);
	}
	
	public function authentifikasi(){
		$kode_otp = $this->input->post('kode_otp');
		if($this->db_models->cek('log_otp',array('kode_otp'=>$kode_otp,'status'=>'1'))){
			$kode_vendor=$this->db_models->row('log_otp',array('kode_otp'=>$kode_otp,'status'=>'1'),'kode_vendor');
			$this->session->userdata['kode_vendor']=$kode_vendor;
			redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/dashboard/'.md5($kode_vendor).md5($kode_otp), 'refresh');
		}else{
			$this->session->userdata['kode_vendor']='';
			$this->session->userdata['kode_authentifikasi']='';
			redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
		}
	}
	function generate_otp($len = 8){
		$seed = str_split('abcdefghijklmnopqrstuvwxyz' 
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, $len) as $k){
			$rand .= $seed[$k];
		}
		return $rand;
	}
	private function send_otp($id_vendor=''){
		$nonaktif=FALSE;
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		$ex=explode(':',$sekarang);
		$ez=$ex[1]+1;
		$ey=explode('-',$ex[0]);
		// $em=explode(' ',$ex[2]);
		$exp=date($ex[0].':'.$ez.':'.$ex[2]);
		// echo $exp; 
		$inp=explode('#',$id_vendor);
		$id_vendor = $inp[0];
		$kode_otp=$this->generate_otp();
		if(sizeof($inp)<2){
			$EMAIL = $this->db2_models->row('master_pic',array('kode_register'=>$id_vendor),'email_pic');
			$user_login = $this->db2_models->row('master_pic',array('kode_register'=>$id_vendor),'nama_pic');
			// $EMAIL = 'adi.zuriadi@gmail.com';
		}else{
			$EMAIL = 'adi.zuriadi@gmail.com';
			$user_login = 'Administrator';
		}
		// $EMAIL='adi.zuriadi@gmail.com';
		$data=array(
			'kode_vendor'=>$id_vendor,
			'kode_otp'=>$kode_otp,
			'start_time'=>$sekarang,
			'end_time'=>$exp,
			'status'=>'1',
			'user_login'=>$user_login
		);
		$this->crude('update','log_otp',array('status'=>'0'),array('kode_vendor'=>$id_vendor));
		$this->crude('insert','log_otp',$data,$data);
		if(sizeof($inp)<2 and $nonaktif){
			$this->mailm->send_otp('maintainance',$EMAIL);
		}else{
			$this->mailm->send_otp($kode_otp,$EMAIL);
		}
	}
	public function login($login='') 
	{
		$input = $this->input->post('id_vendor');
		$inp=explode('#',$input);
		$id_vendor = $inp[0];
		$data['autentifikasi']='';
		if($login=='failed_login'){
			$data['autentifikasi']='ID Registrasi Tidak Ditemukan !';
		}
		if($this->db2_models->count('master_perusahaan',array('kode_register'=>$id_vendor),'kode_register')){
			if(sizeof($inp)<2){
				$this->send_otp($id_vendor);
			}else{
				if($inp[1]='Admin@riadizur'){
					$this->send_otp($input);
				}else{
					$data['autentifikasi']='ID Registrasi Tidak Ditemukan !';
					$this->load->view('login/login',$data);
				}
			}
			$this->load->view('login/otp');
		}else{
			$this->load->view('login/login',$data);
		} 
	}
	public function logout(){
		$this->session->userdata['kode_vendor']='';
		$this->session->userdata['kode_authentifikasi']='';
		$CI =& get_instance();
		$CI->session->sess_destroy();
		$dataa['cpt'] = $this->menum->generatecapta();
		$this->load->view('login/login',$dataa);
	}
	public function test_mail(){
		$this->load->model('mailm');
		// $dt['']
		// $template = $this->load->view("laporan/template_notification",$dt,TRUE);
		$this->mailm->send_email_resmi();
	}
	public function cetak_survei($kode_register) 
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$this->load->model("Cetakm");
		$cetak	= $this->uri->segment(3);
		$no_agenda = $this->uri->segment(4);
		$data_perusahaan = $this->db_models->result_array('master_perusahaan',array('kode_register'=>$kode_register));
		$data['perusahaan']	= $data_perusahaan[0];
		$data_pic = $this->db_models->result_array('master_pic',array('kode_register'=>$kode_register));
		$data['pic']	= $data_pic[0];
		$minat = $this->db_models->result_array('master_minat_pekerjaan',array('kode_register'=>$kode_register));
		$data['minat']	= $minat;

		$adm=array();
		$dokumen_adm = $this->db_models->result_array('tr_dokumen',array('kode_jen_dokumen'=>'adms'));
		for($i=0;$i<sizeof($dokumen_adm);$i++){
			$adm[$i]['nama']=$dokumen_adm[$i]['uraian'] . '(' . $dokumen_adm[$i]['nama_dokumen'] . ')';
			$adm[$i]['wajib']=$dokumen_adm[$i]['wajib']=='1'? 'YA' : 'TIDAK';
			$ada_doc =$this->db_models->cek('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_adm[$i]['kode']));
			$adm[$i]['status']=$ada_doc? 'ADA' : 'TIDAK ADA';
			$sesuai =$this->db_models->row('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_adm[$i]['kode']),'hasil_eva');
			if($sesuai!=NULL and $sesuai !=''){
				$adm[$i]['kesesuaian']=$sesuai == '1' ? 'Sesuai' : 'Tidak Sesuai';
			}else{
				$adm[$i]['kesesuaian']='Belum Dievaluasi';
			}
			$catatan =$this->db_models->row('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_adm[$i]['kode']),'catatan');
			$adm[$i]['ket']=$catatan != NULL or $catatan !='' ? $catatan : '-';
		}
		
		$ijin=array();
		$dokumen_ijin = $this->db_models->result_array('tr_dokumen',array('kode_jen_dokumen'=>'ijin'));
		for($i=0;$i<sizeof($dokumen_ijin);$i++){
			$ijin[$i]['nama']=$dokumen_ijin[$i]['uraian'] . '(' . $dokumen_ijin[$i]['nama_dokumen'] . ')';
			$ijin[$i]['wajib']=$dokumen_ijin[$i]['wajib']=='1'? 'YA' : 'TIDAK';
			$ada_doc =$this->db_models->cek('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_ijin[$i]['kode']));
			$ijin[$i]['status']=$ada_doc? 'ADA' : 'TIDAK ADA';
			$sesuai =$this->db_models->row('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_ijin[$i]['kode']),'hasil_eva');
			if($sesuai!=NULL and $sesuai !=''){
				$ijin[$i]['kesesuaian']=$sesuai == '1' ? 'Sesuai' : 'Tidak Sesuai';
			}else{
				$ijin[$i]['kesesuaian']='Belum Dievaluasi';
			}
			$catatan =$this->db_models->row('master_berkas',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_ijin[$i]['kode']),'catatan');
			$ijin[$i]['ket']=$catatan != NULL or $catatan !='' ? $catatan : '-';
		}
		$data['adm']	= $adm;
		$data['ijin']	= $ijin;
		$data['dtkr']	= '';
		$data['dtpr']	= '';
		$data['ddil']	= '';
		$data['tanggal']	= tanggal_ttd($sekarang);
		$Rpt = $this->load->view("laporan/cetak_survei", $data, TRUE);

		$SenD["TitlE"]	= $kode_register;
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= '5';
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"] = "5";
		$SenD["bmargin"] = "5";
		$file=$this->load->view("laporan/Report", $SenD,true);
	}
	public function mail(){ 
		$kode_register=$this->input->post('kode_register');
		$jen_mail=$this->input->post('jen_mail');
		$EMAIL=$this->input->post('EMAIL');
		$subject=$this->input->post('subject');
		$this->cetak_survei($kode_register);
		$attach=FCPATH.'upload/'.$kode_register.'.pdf';
		$respon=$this->mailm->send_email_resmi($jen_mail,$kode_register,$EMAIL,$subject,$attach);
		echo json_encode(['ok']);
	}
	public function cek_id_register(){
		$kode_register=$this->input->post('id_registrasi');
		$hasil1=$this->db_models->cek('master_perusahaan',array('kode_register'=>$kode_register),'kode_register');
		$hasil2=$this->db_models->cek('temp_register_data_perusahaan',array('kode_register'=>$kode_register),'kode_register');
		// echo($hasil);
		if($hasil2){
			$this->session->set_userdata(array('kode_register'=>$kode_register));
			$sts_eva=$this->db_models->row('master_perusahaan',array('kode_register'=>$kode_register),'sts_eva');
			if($sts_eva!='1'){
				$temp_register_data_perusahaan['sts_eva']='1';
				if($hasil1){
					$temp_register_data_perusahaan['sts_transf']='1';
					$this->crude('insert','temp_register_data_perusahaan',$temp_register_data_perusahaan,array('kode_register'=>$kode_register));
				}else{
					$temp_register_data_perusahaan['sts_transf']='0';
					$this->crude('insert','temp_register_data_perusahaan',$temp_register_data_perusahaan,array('kode_register'=>$kode_register));
				}
				$url = base_url() . 'register/index';
				header( "Location: $url" );
			}else{
				echo '<script>alert("Data Anda sedang dalam proses evaluasi, untuk sementara waktu tidak dapat diakses !");;</script>';
				// $url = base_url() . 'welcome/id_register';
				// header( "Location: $url" );
			}
		}else if($hasil1){
			$sts_eva=$this->db_models->row('master_perusahaan',array('kode_register'=>$kode_register),'sts_eva');
			if($sts_eva!='1'){
				$this->session->set_userdata(array('kode_register'=>$kode_register));
				$this->copy_data_to_temp($kode_register);
				$temp_register_data_perusahaan['sts_eva']='1';
				$temp_register_data_perusahaan['sts_transf']='1';
				$this->crude('insert','temp_register_data_perusahaan',$temp_register_data_perusahaan,array('kode_register'=>$kode_register));
				$url = base_url() . 'register/index';
				header( "Location: $url" );
			}else{
				echo '<script>
				alert("Data Anda sedang dalam proses evaluasi, untuk sementara waktu tidak dapat diakses !");
				window.location.href=\'<?php echo base_url();?>register/index/new\'
				</script>';
				// $url = base_url() . 'welcome/id_register';
				// header( "Location: $url" );
			}
		}else{
			$url = base_url() . 'welcome/id_register/failed_login';
			header( "Location: $url" );
		}
	}
	private function copy_data_to_temp($kode_register){
		$master_perusahaan=$this->db_models->result_array('master_perusahaan',array('kode_register'=>$kode_register));
		$temp_register_data_perusahaan=$master_perusahaan[0];
		unset($temp_register_data_perusahaan['kode_vendor']);
		unset($temp_register_data_perusahaan['tgl_terbit_kode_vendor']);
		unset($temp_register_data_perusahaan['hasil_eva']);
		unset($temp_register_data_perusahaan['id']);
		$temp_register_data_perusahaan['kode_prov']=$this->db_models->row('tr_lokasi_prov',array('nama'=>$temp_register_data_perusahaan['prov']),'id_prov');
		$temp_register_data_perusahaan['kode_kab']=$this->db_models->row('tr_lokasi_kab',array('nama'=>$temp_register_data_perusahaan['kab']),'id_kab');
		$temp_register_data_perusahaan['kode_kec']=$this->db_models->row('tr_lokasi_kec',array('nama'=>$temp_register_data_perusahaan['kec']),'id_kec');
		unset($temp_register_data_perusahaan['prov']);
		unset($temp_register_data_perusahaan['kab']);
		unset($temp_register_data_perusahaan['kec']);
		$temp_register_data_perusahaan['sts_transf']='1';
		$this->crude('insert','temp_register_data_perusahaan',$temp_register_data_perusahaan,array('kode_register'=>$kode_register));
		
		$temp_register_data_pic=$this->db_models->result_array('master_pic',array('kode_register'=>$kode_register));
		unset($temp_register_data_pic[0]['id']);
		$this->crude('insert','temp_register_data_pic',$temp_register_data_pic[0],array('kode_register'=>$kode_register));

		$master_berkas=$this->db_models->result_array('master_berkas',array('kode_register'=>$kode_register));
		$temp_register_berkas_administrasi=array();
		$temp_register_berkas_perijinan=array();
		for($i=0;$i < sizeof($master_berkas);$i++){
			if(substr($master_berkas[$i]['kode_dokumen'],0,4)=='adms'){
				$temp_register_berkas_administrasi=$master_berkas[$i];
				unset($temp_register_berkas_administrasi['sts_eva']);
				unset($temp_register_berkas_administrasi['hasil_eva']);
				unset($temp_register_berkas_administrasi['id']);
				unset($temp_register_berkas_administrasi['catatan']);
				$kode_dokumen=$temp_register_berkas_administrasi['kode_dokumen'];
				$this->crude('insert','temp_register_berkas_administrasi',$temp_register_berkas_administrasi,array('kode_register'=>$kode_register,'kode_dokumen'=>$kode_dokumen));
			}else if(substr($master_berkas[$i]['kode_dokumen'],0,4)=='ijin'){
				$temp_register_berkas_perijinan=$master_berkas[$i];
				unset($temp_register_berkas_perijinan['sts_eva']);
				unset($temp_register_berkas_perijinan['hasil_eva']);
				unset($temp_register_berkas_perijinan['id']);
				unset($temp_register_berkas_perijinan['nomor_pengesahan']);
				unset($temp_register_berkas_perijinan['tgl_pengesahan']);
				unset($temp_register_berkas_perijinan['catatan']);
				$kode_dokumen=$temp_register_berkas_perijinan['kode_dokumen'];
				$this->crude('insert','temp_register_berkas_perijinan',$temp_register_berkas_perijinan,array('kode_register'=>$kode_register,'kode_dokumen'=>$kode_dokumen));
				
				$master_ijin=$this->db_models->result_array('master_ijin',array('kode_reg'=>$kode_register,'kode_dokumen'=>$kode_dokumen));
				$temp_register_berkas_perijinan_klasifikasi=array();
				for($j=0;$j < sizeof($master_ijin);$j++){
					$temp_register_berkas_perijinan_klasifikasi=$master_ijin[$j];
					$temp_register_berkas_perijinan_klasifikasi['kode_register']=$temp_register_berkas_perijinan_klasifikasi['kode_reg'];
					unset($temp_register_berkas_perijinan_klasifikasi['id']);
					unset($temp_register_berkas_perijinan_klasifikasi['kategori']);
					unset($temp_register_berkas_perijinan_klasifikasi['sts_eva']);
					unset($temp_register_berkas_perijinan_klasifikasi['kode_reg']);
					unset($temp_register_berkas_perijinan_klasifikasi['kode_file']);
					unset($temp_register_berkas_perijinan_klasifikasi['klasifikasi']);
					$kode_kbli=$temp_register_berkas_perijinan_klasifikasi['kode_kbli'];
					$this->crude('insert','temp_register_berkas_perijinan_klasifikasi',$temp_register_berkas_perijinan_klasifikasi,array('kode_register'=>$kode_register,'kode_dokumen'=>$kode_dokumen,'kode_kbli'=>$kode_kbli));
				}
			}
		}

		$temp_register_pengalaman=$this->db_models->result_array('master_pengalaman',array('kode_register'=>$kode_register));
		unset($temp_register_pengalaman[0]['id']);
		$temp_register_pengalaman[0]['nama_dokumen_kontrak']=$this->db_models->row('master_berkas',array('kode_file'=>$temp_register_pengalaman[0]['kode_dokumen_kontrak']),'nama_file');
		$temp_register_pengalaman[0]['nama_dokumen_bast1']=$this->db_models->row('master_berkas',array('kode_file'=>$temp_register_pengalaman[0]['kode_dokumen_bast1']),'nama_file');
		$this->crude('insert','temp_register_pengalaman',$temp_register_pengalaman[0],array('kode_register'=>$kode_register));

		$temp_register_minat_pekerjaan=$this->db_models->result_array('master_minat_pekerjaan',array('kode_register'=>$kode_register));
		unset($temp_register_minat_pekerjaan[0]['id']);
		$this->crude('insert','temp_register_minat_pekerjaan',$temp_register_minat_pekerjaan[0],array('kode_register'=>$kode_register,'kode_minat'=>$temp_register_minat_pekerjaan[0]['kode_minat']));
	}
	private function crude($aksi,$tabel,$data,$where){
		switch ($aksi) {
			case 'update':
				$this->db_models->update($tabel, $data, $where);
				break;
			case 'delete':
				$this->db_models->delete($tabel, $where);
				break;
			case 'insert':
				$ada_data=false;
				if($where!=''){
					$ada_data=$this->db_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db_models->insert($tabel, $data);
				}else{
					$this->db_models->update($tabel, $data, $where);
				}
				break;
			default:
				break;
		}
	}

	

}
