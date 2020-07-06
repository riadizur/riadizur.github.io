<?php
defined('BASEPATH') or exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, x-xsrf-token");

class Vendor extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db2_models');
		$this->load->model('db_models');
		$this->load->model('jquery_models');
		$this->load->model('menum');
		$this->load->model('mailm'); 
	}
	public function index($authentifikasi='') 
	{
		$otp=$this->db_models->row('log_otp',array('status'=>'1','kode_vendor'=>$this->session->userdata('kode_vendor')),'kode_otp');
		$allow=FALSE;
		if($authentifikasi==md5($this->session->userdata('kode_vendor')).md5($otp)){
			$allow=TRUE;
		}
		if($authentifikasi!='' and $allow){ 
			$this->session->userdata['kode_authentifikasi']=$authentifikasi;
			redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/dashboard/'.$authentifikasi,'refresh');
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/dashboard/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function anwizing($authentifikasi='') 
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
			$this->load->view('vendor/anwizing',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/anwizing/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	// public function upload(){
	// 	$filename = $_FILES['file']['name'];
	// 	/* Location */
	// 	$location = "assets/upload_files/".$filename;
	// 	$uploadOk = 1;
	// 	$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

	// 	/* Valid Extensions */
	// 	$valid_extensions = array("jpg","jpeg","png","pdf","doc","xlsx","xls");
	// 	/* Check file extension */
	// 	if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
	// 		$uploadOk = 0;
	// 	}

	// 	if($uploadOk == 0){
	// 		echo 0;
	// 	}else{
	// 	/* Upload file */
	// 		if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	// 			echo $location;
	// 		}else{
	// 			echo 0;
	// 		}
	// 	}
	// }

	// public function upload_2(){
	// 	$uploaddir = 'assets/upload_files/';
	// 	$uploadfile = $uploaddir . basename($_FILES['	']['name']);

	// 	echo '<pre>';
	// 	if (move_uploaded_file($_FILES['file_upload']['tmp_name'], $uploadfile)) {
	// 		echo "File is valid, and was successfully uploaded.\n";
	// 	} else {
	// 		echo "Possible file upload attack!\n";
	// 	}

	// 	echo 'Here is some more debugging info:';
	// 	print_r($_FILES);

	// 	print "</pre>";
	// }
	// public function upload_3(){
	// 	if ( 0 < $_FILES['file']['error'] ) {
	// 		echo "Error: " . $_FILES['file']['error'] . "<br>";
	// 	}
	// 	else {
	// 		move_uploaded_file($_FILES['file']['tmp_name'], 'assets/upload_files/' . $_FILES['file']['name']);
	// 		echo json_ecode(['ok']);
	// 	}
	// }
	public function upload(){
		if (!empty($_FILES['file']['name'])) {
			$status['nama_file'] = $_FILES['file']['name'];
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$upload = $this->cek_berkas('file',$ext);
			$status['kode_file'] = $upload;
			echo json_encode($status);
		}else{
			echo 'File Kosong !';
		}
	}
	private function cek_berkas($file_upload,$ext)
	{
		$config['upload_path']          = 'assets/upload_files/';
		$config['allowed_types']        = 'jpeg|jpg|png|pdf|doc|docx|xls|xlsx';
		$config['max_size']             = 100250;
		$config['file_name']            = round(microtime(true) * 1000);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload($file_upload)) {
			echo 'Gagal Upload: ' . $file_upload . ' dan ' . $this->upload->display_errors('', '');
			exit();
		}
		return $this->upload->data('file_name');
	}
	public function negosiasi($authentifikasi='') 
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
			$this->load->view('vendor/negosiasi',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/negosiasi/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function kontrak($authentifikasi='') 
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
			$this->load->view('vendor/kontrak',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/kontrak/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function pengumuman($authentifikasi='') 
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
			$this->load->view('vendor/pengumuman',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
			// $this->load->view('jquery/pengumuman',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/pengumuman/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function penawaran($authentifikasi='') 
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
			$this->load->view('vendor/penawaran',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/penawaran/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function profil($authentifikasi='') 
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
				'data_perusahaan'=>$this->db2_models->result('master_perusahaan',array('kode_register'=>$this->session->userdata('kode_vendor'))),
				'data_pic'=>$this->db2_models->result('master_pic',array('kode_register'=>$this->session->userdata('kode_vendor'))),
				'data_pengalaman'=>$this->db2_models->result('master_pengalaman',array('kode_register'=>$this->session->userdata('kode_vendor'))),
				'berkas'=>$this->db2_models->result('master_berkas',array('kode_register'=>$this->session->userdata('kode_vendor'))),
				'ijin'=>$this->db2_models->result('master_ijin',array('kode_reg'=>$this->session->userdata('kode_vendor'))),
				'minat'=>$this->db2_models->result('master_minat_pekerjaan',array('kode_register'=>$this->session->userdata('kode_vendor')))
			);
			$this->load->view('vendor/profil',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/profil/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function daftar_project($authentifikasi='') 
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
			$this->load->view('vendor/daftar_project',$data);
			$foot=array(
				'other_js'=>array(),
				'jquery_script'=>array()
			);
			$this->load->view('template/footer',$foot);
		}else{
			if($this->session->userdata('kode_authentifikasi')!=''){
				redirect('http://portal.ecopowerport.co.id:88/vendors/vendor/daftar_project/'.$this->session->userdata('kode_authentifikasi'),'refresh');
			}else{
				redirect('http://portal.ecopowerport.co.id:88/vendors/welcome/login', 'refresh');
			}
		}
	}
	public function load_tabel()
	{
		$nama_tabel = $this->input->post('nama_tabel');
		$where = $this->input->post('where');
		$tabel = $this->input->post('tabel');
		$data = array();
		$hasil = $this->db2_models->result($tabel,$where);
		switch($nama_tabel){
			case 'tabel_boq' : $this->tabel_boq($hasil);break;
			case 'tabel_penawaran' : $this->tabel_penawaran($hasil);break;
			case 'tabel_pertanyaan' : $this->tabel_pertanyaan($hasil);break;
		}
	}
	public function tabel_boq($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nama_barang;
			$row[] = $r->merk_barang;
			$row[] = $r->spesifikasi_barang;
			$row[] = $r->jumlah_barang.' '.$r->satuan_barang;
			$row[] = $r->detail;
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_penawaran($hasil){ 
		$i = 1;
		$data=array();
		$disable='';
		$ket='';
		$berakhir=FALSE;
		$tgl_anwizing=$this->db2_models->row('tp_master_project',array('kode_project'=>$hasil[0]->kode_project),'tgl_rencana_anwizing');
		$tgl_penawaran=$this->db2_models->row('tp_master_project',array('kode_project'=>$hasil[0]->kode_project),'tgl_rencana_penawaran');
		if($this->db2_models->row('tp_master_project',array('kode_project'=>$hasil[0]->kode_project),'sts_anwizing')!='1'){
			$disable='disabled';
			$ket='<label>Penawaran akan dibuka pada '.$tgl_anwizing.' <br>Jika ada pertanyaan silahkan kunjungi link berikut ini
				<a href="http://portal.ecopowerport.co.id:88/vendors/vendor/anwizing"> Klik Disini </a></label>';
		}
		if($this->db2_models->row('tp_master_project',array('kode_project'=>$hasil[0]->kode_project),'sts_penawaran')=='1'){
			$disable='disabled';
			$ket='<label>Penawaran telah berakhir pada '.$tgl_penawaran.'</label>';
			$berakhir=TRUE;
		}
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nama_barang;
			$row[] = $r->merk_barang;
			$row[] = $r->tipe_barang;
			$row[] = $r->spesifikasi_barang;
			$row[] = $r->jumlah_barang.' '.$r->satuan_barang;
			$row[] = $r->detail;
			$value=$this->db_models->row('temp_master_penawaran',array('kode_vendor'=>$this->session->userdata('kode_vendor'),'kode_project'=>$r->kode_project,'id_master_boq'=>$r->id),'harga_satuan');
			$button='<br><button class="btn btn-primary pull-right" onclick="add_penawaran(\''.$r->id.'\',$(\'#_'.$r->id.'\').val(),\''.$r->jumlah_barang.'\',\''.$r->kode_project.'\',\''.$r->kode_barang.'\');">OK</button>';
			$jlh_harga='<div id="jumlah_'.$r->id.'" align="right"></div>';
			if(!$berakhir){
				if($this->db_models->cek('temp_master_penawaran',array('kode_vendor'=>$this->session->userdata('kode_vendor'),'kode_project'=>$r->kode_project,'id_master_boq'=>$r->id,'sts'=>'1'))){
					$jumlah_harga=$this->db_models->row('temp_master_penawaran',array('kode_vendor'=>$this->session->userdata('kode_vendor'),'kode_project'=>$r->kode_project,'id_master_boq'=>$r->id),'jumlah_harga');
					$disable='disabled';
					$ket='<label>Penawaran sudah anda ajukan, Data tidak bisa diubah kembali.</label>';
					$button='';
					$jlh_harga='<div id="jumlah_'.$r->id.'" align="right">Rp.'.$jumlah_harga.'</div>';
				}
			}else{
				$button='';
				if($this->db_models->cek('temp_master_penawaran',array('kode_vendor'=>$this->session->userdata('kode_vendor'),'kode_project'=>$r->kode_project,'id_master_boq'=>$r->id,'sts'=>'1'))){
					$jumlah_harga=$this->db_models->row('temp_master_penawaran',array('kode_vendor'=>$this->session->userdata('kode_vendor'),'kode_project'=>$r->kode_project,'id_master_boq'=>$r->id),'jumlah_harga');
				}else{
					$jumlah_harga='-';
				}
				$jlh_harga='<div id="jumlah_'.$r->id.'" align="right">Rp.'.$jumlah_harga.'</div>';
			}
			$row[] = '<input class="form-control" type="number" class=\'number\' id="_'.$r->id.'"name="number" data-validate-minmax="10,100" value="'.$value.'" required=\'required\''.$disable.'>'
					 .$button.$ket;
			$row[] =$jlh_harga;
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_pertanyaan($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nama_perusahaan;
			$row[] = $r->user_pertanyaan;
			if($this->session->userdata('kode_vendor')==$r->kode_vendor){
				$row[] = '<a onclick="update_pertanyaan('.$r->id.');" href="#" tittle="klik untuk mengedit">'.$r->pertanyaan.'</a>';
			}else{
				$row[] = $r->pertanyaan;
			}
			$row[] = $r->jawaban;
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function crude()
	{
		$aksi = $this->input->post('aksi');
		$tabel = $this->input->post('tabel');
		$data = $this->input->post('data');
		$where = $this->input->post('where');
		$status = '';
		switch ($aksi) {
			case 'update':
				$this->db2_models->update($tabel, $data, $where);
				$status = 'update';
				break;
			case 'delete':
				$this->db2_models->delete($tabel, $where);
				$status = 'delete';
				break;
			case 'insert':
				$ada_data=false;
				if($where!=''){
					$ada_data=$this->db2_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db2_models->insert($tabel, $data);
					$status = 'tambahkan';
				}else{
					$this->db2_models->update($tabel, $data, $where);
					$status = 'update';
				}
				break;
			case 'add':
				$ada_data=false;
				$separator = $data['separator'];
				unset($data['separator']);
				if($where!=''){
					$ada_data=$this->db2_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db2_models->insert($tabel, $data);
					$status = 'tambahkan';
				}else{
					$hasil = $this->db2_models->result($tabel, $where);
					$kolom = array();
					$kolom = $this->db2_models->result_kolom($tabel);
					foreach ($kolom as $k){
						if(array_key_exists($k->COLUMN_NAME,$data)){
							$nama_kolom=$k->COLUMN_NAME;
							$data[$k->COLUMN_NAME] = $hasil[0]->$nama_kolom . $separator . $data[$k->COLUMN_NAME];
						}
					}
					$this->db2_models->update($tabel, $data, $where);
					$status = 'update dan ditambahkan';
				}
				break;
			default:
				break;
		}
		if($status!=''){
			echo json_encode($status);
		}
	}
	
	public function ajukan_penawaran(){
		$where = $this->input->post('where');
		$all=$this->db_models->result('temp_master_penawaran',$where);
		foreach($all as $a){
			$detail=$this->db2_models->result('tp_master_boq',array('id'=>$a->id_master_boq));
			foreach($detail as $d){
				$nama_barang=$d->nama_barang;
				$merk_barang=$d->merk_barang;
				$tipe_barang=$d->tipe_barang;
				$spesifikasi_barang=$d->spesifikasi_barang;
				$satuan_barang=$d->satuan_barang;
				$file_foto=$d->file_foto;
				$detail=$d->detail;
			}
			$data=array(
				'kode_project'=>$a->kode_project,
				'kode_boq'=>$a->kode_boq,
				'kode_vendor'=>$a->kode_vendor,
				'kode_penawaran'=>$a->kode_penawaran,
				'kode_barang'=>$a->kode_barang,
				'nama_barang'=>$nama_barang,
				'merk_barang'=>$merk_barang,
				'tipe_barang'=>$tipe_barang,
				'spesifikasi_barang'=>$spesifikasi_barang,
				'jumlah_barang'=>$a->jumlah_barang,
				'satuan_barang'=>$satuan_barang,
				'file_foto'=>$file_foto,
				'detail'=>$detail,
				'harga_satuan'=>$a->harga_satuan,
				'jumlah_harga'=>$a->jumlah_harga,
				'waktu_entry'=>$a->waktu_entry,
				'user_update'=>$a->user_update
			);
			$where=array(
				'kode_project'=>$a->kode_project,
				'kode_boq'=>$a->kode_boq,
				'kode_vendor'=>$a->kode_vendor,
				'kode_penawaran'=>$a->kode_penawaran,
				'kode_barang'=>$a->kode_barang,
				'nama_barang'=>$nama_barang,
				'merk_barang'=>$merk_barang,
				'tipe_barang'=>$tipe_barang,
				'spesifikasi_barang'=>$spesifikasi_barang,
				'jumlah_barang'=>$a->jumlah_barang,
				'satuan_barang'=>$satuan_barang,
				'file_foto'=>$file_foto,
				'detail'=>$detail
			);
			$this->crude_tabel('insert','tp_master_penawaran',$data,$where);
		}
		echo json_encode(['ok']);
	}
	private function crude_tabel($aksi,$tabel,$data,$where)
	{
		switch ($aksi) {
			case 'update':
				$this->db2_models->update($tabel, $data, $where);
				break;
			case 'delete':
				$this->db2_models->delete($tabel, $where);
				break;
			case 'insert':
				$ada_data=false;
				if($where!=''){
					$ada_data=$this->db2_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db2_models->insert($tabel, $data);
				}else{
					$this->db2_models->update($tabel, $data, $where);
				}
				break;
			default:
				break;
		}
	}
	public function crude2()
	{
		$aksi = $this->input->post('aksi');
		$tabel = $this->input->post('tabel');
		$data = $this->input->post('data');
		$where = $this->input->post('where');
		$status = '';
		switch ($aksi) {
			case 'update':
				$this->db_models->update($tabel, $data, $where);
				$status = 'update';
				break;
			case 'delete':
				$this->db_models->delete($tabel, $where);
				$status = 'delete';
				break;
			case 'insert':
				$ada_data=false;
				if($where!=''){
					$ada_data=$this->db_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db_models->insert($tabel, $data);
					$status = 'tambahkan';
				}else{
					$this->db_models->update($tabel, $data, $where);
					$status = 'update';
				}
				break;
			case 'add':
				$ada_data=false;
				$separator = $data['separator'];
				unset($data['separator']);
				if($where!=''){
					$ada_data=$this->db_models->cek($tabel,$where);
				}
				if(!$ada_data){
					$this->db_models->insert($tabel, $data);
					$status = 'tambahkan';
				}else{
					$hasil = $this->db_models->result($tabel, $where);
					$kolom = array();
					$kolom = $this->db_models->result_kolom($tabel);
					foreach ($kolom as $k){
						if(array_key_exists($k->COLUMN_NAME,$data)){
							$nama_kolom=$k->COLUMN_NAME;
							$data[$k->COLUMN_NAME] = $hasil[0]->$nama_kolom . $separator . $data[$k->COLUMN_NAME];
						}
					}
					$this->db_models->update($tabel, $data, $where);
					$status = 'update dan ditambahkan';
				}
				break;
			default:
				break;
		}
		if($status!=''){
			echo json_encode($status);
		}
	}
}