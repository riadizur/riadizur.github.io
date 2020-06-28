<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Register extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('db_models');
		$this->load->model('jquery_models');
	}
	public function copy_data_to_temp(){

	}
	public function index($new='')
	{   
		$data['new'] = false;
		$data['temp'] = false;
		$data['master'] = false;
		$teregister = false;
		if($new=='new'){
			if($this->session->userdata('kode_register')==''){
				$this->session->set_userdata(array('kode_register'=>'EPI-' . round(microtime(true) * 1000)));
				$data['new'] = true;
			}
		}else{
			if($this->session->userdata('kode_register')==''){
				$this->session->set_userdata(array('kode_register'=>'EPI-' . round(microtime(true) * 1000)));
				$data['new'] = true;
			}
		}
		$kode_register=$this->session->userdata('kode_register');
		$data['kode_register']=$kode_register;
		// if($this->check('master_perusahaan',array('kode_register'=>$kode_register),'kode_register')!=''){
		// 	$data['master']=true;
		// 	$this->copy_data_to_temp();$this->db_models->cek($tabel,$where);
			if($this->db_models->cek('temp_register_data_perusahaan',array('kode_register'=>$kode_register))){
				$data['temp']=true;
				$teregister=true;
			}
		// }else if($this->check('temp_register_data_perusahaan',array('kode_register'=>$kode_register),'kode_register')!=''){
		// 	$data['temp']=true;
		// }else{
		// 	$data['new']=true;
		// }
		//tab data perusahaan
		$data['kode_register']=$this->session->userdata('kode_register');
		$list_provinsi=$this->db_models->list_dropdown('tr_lokasi_prov',array('id_prov','nama'),'all','','','Select');
		if(!$teregister){
			$load_kabupaten='list_dropdown(' . "'dropdown_kabupaten',['dropdown_kecamatan'],'tr_lokasi_kab',['id_kab','nama'],'where id_prov='+$(this).val(),'','','Select'" . ')';
			$load_kecamatan='list_dropdown(' . "'dropdown_kecamatan',[],'tr_lokasi_kec',['id_kec','nama'],'where id_kab='+$(this).val(),'','','Select'" . ')';
			$data['dropdown_provinsi']=form_dropdown("dropdown_provinsi", $list_provinsi, [], 'id="dropdown_provinsi" onchange="' . $load_kabupaten . '" style="width:100%; " class="form-control select2me"');
			$data['dropdown_kabupaten']=form_dropdown("dropdown_kabupaten", [], [], 'id="dropdown_kabupaten" onchange="' . $load_kecamatan . '" style="width:100%; " class="form-control select2me"');
			$data['dropdown_kecamatan']=form_dropdown("dropdown_kecamatan", [], [], 'id="dropdown_kecamatan" style="width:100%; " class="form-control select2me"');
		}else{
			$data_perusahaan = $this->db_models->result_array('temp_register_data_perusahaan',array('kode_register'=>$kode_register));
			$list_kabupaten=$this->db_models->list_dropdown('tr_lokasi_kab',array('id_kab','nama'),'where id_prov='. $data_perusahaan[0]['kode_prov'],'','','Select');
			$list_kecamatan=$this->db_models->list_dropdown('tr_lokasi_kec',array('id_kec','nama'),'where id_kab='. $data_perusahaan[0]['kode_kab'],'','','Select');
			$data['dropdown_provinsi']=form_dropdown("dropdown_provinsi", $list_provinsi, [], 'id="dropdown_provinsi" style="width:100%; " class="form-control select2me"');
			$data['dropdown_kabupaten']=form_dropdown("dropdown_kabupaten", $list_kabupaten, [], 'id="dropdown_kabupaten" style="width:100%; " class="form-control select2me"');
			$data['dropdown_kecamatan']=form_dropdown("dropdown_kecamatan", $list_kecamatan, [], 'id="dropdown_kecamatan" style="width:100%; " class="form-control select2me"');
		}
		$data['nama_dropdown_provinsi'] = 'dropdown_provinsi';
		$data['nama_dropdown_kabupaten'] = 'dropdown_kabupaten';
		$data['nama_dropdown_kecamatan'] = 'dropdown_kecamatan';

		$kode_area=$this->db_models->list_dropdown('tr_kode_area_telp',array('kode_area',array('nama_area','kode_area'),' (',')'),'all','','','Pilih Area');
		$data['dropdown_kode_area_telp_perusahaan'] = form_dropdown("dropdown_kode_area_telp_perusahaan", $kode_area, [], 'id="dropdown_kode_area_telp_perusahaan"  style="width:100%; " class="form-control select2me"');
		$data['dropdown_kode_area_telp_pic'] = form_dropdown("dropdown_kode_area_telp_pic", $kode_area, [], 'id="dropdown_kode_area_telp_pic"  style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_kode_area_telp_perusahaan'] = 'dropdown_kode_area_telp_perusahaan';
		$data['nama_dropdown_kode_area_telp_pic'] = 'dropdown_kode_area_telp_pic';
		//tab berkas adm
		$list_berkas_administrasi=$this->db_models->list_dropdown('tr_dokumen',array('kode',array('uraian','nama_dokumen'),' (',')' ),'where kode_jen_dokumen="adms"','','','Select');
		$data['dropdown_berkas_administrasi']=form_dropdown("dropdown_berkas_administrasi", $list_berkas_administrasi, [], 'id="dropdown_berkas_administrasi" onchange="load_form_administrasi($(this).val());cek_pengesahan_adm($(this).val());" style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_berkas_administrasi'] = 'dropdown_berkas_administrasi';

		// berkas perijinan
		$show_sil = "check_sil($(this).val())";
		$load_check="check(['tr_dokumen',['kbli','grade'],$(this).val()],['form_klasifikasi','form_kbli','form_grade'])";
		$load_grade='list_dropdownx(' . "'dropdown_grade',[],'tr_klasifikasi_grade',['kode',['kualifikasi','modal_usaha'],' dengan modal usaha '],['kode_dokumen',$(this).val()],'','','--Pilih Grade--'" . ')';
		$list_berkas_perijinan=$this->db_models->list_dropdown('tr_dokumen',array('kode',array('uraian','nama_dokumen'),' (',')' ),'where kode_jen_dokumen="ijin"','','','Select');
		$data['dropdown_berkas_perijinan']=form_dropdown("dropdown_berkas_perijinan", $list_berkas_perijinan, [], 'id="dropdown_berkas_perijinan" onchange="' . $load_check . ';' . $load_grade . ';' . $show_sil . ';load_form_perijinan($(this).val())" style="width:100%; " class="form-control select2me"');
		$data['form_kbli']='form_kbli';
		$data['form_grade']='form_grade';
		$data['form_klasifikasi']='form_klasifikasi';
		$data['nama_dropdown_berkas_perijinan'] = 'dropdown_berkas_perijinan';
		$data['nama_dropdown_grade'] = 'dropdown_grade';
		$data['nama_dropdown_klasifikasi'] = 'dropdown_klasifikasi';
		$list_jen_pekerjaan=$this->db_models->list_dropdown('tr_kbli_detil',array('kode',array('kode','deskripsi'),' - '),'where kode_level="kelompok"','','','--Pilih Klasifikasi Pekerjaan--');
		$data['dropdown_klasifikasi']=form_dropdown("dropdown_klasifikasi", $list_jen_pekerjaan, [], 'id="dropdown_klasifikasi" style="width:100%; " class="form-control select2me"');
		$data['dropdown_grade']=form_dropdown("dropdown_grade", [], [], 'id="dropdown_grade" style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_jen_pekerjaan'] = 'dropdown_jen_pekerjaan';
		
		//tab pengalaman
		$data['dropdown_jen_pekerjaan']=form_dropdown("dropdown_jen_pekerjaan", $list_jen_pekerjaan, [], 'id="dropdown_jen_pekerjaan" onchange="load_form_pengalaman($(this).val());"style="width:100%; " class="form-control select2me"');
		
		//tab minat
		$list_minat_pekerjaan=$this->db_models->list_dropdown('tr_minat_pekerjaan',array('kode','nama'),'all','','','Select');
		$data['dropdown_minat_pekerjaan']=form_dropdown("dropdown_minat_pekerjaan", $list_minat_pekerjaan, [], 'id="dropdown_minat_pekerjaan" style="width:100%; " class="form-control select2me"');
		
		$data['register_jquery'] = $this->jquery_models->register();
		$data['crude_jquery'] = $this->jquery_models->crude();
		$data['load_tabel_jquery'] = $this->jquery_models->load_tabel();
		$data['ready_jquery'] = $this->jquery_models->ready();
		$data['list_checkbox'] = $this->db_models->result('tr_minat_pekerjaan','all');
		$this->load->view('register/register',$data);
	} 
	public function quixlab(){
		$this->load->view('others/quixlab');
	}
	public function coba($new='')
	{   
		$data['new'] = false;
		$data['temp'] = false;
		$data['master'] = false;
		if($new=='new'){
			$this->session->set_userdata(array('kode_register'=>'EPI-' . round(microtime(true) * 1000)));
		}else{
			if($this->session->userdata('kode_register')==''){
				$this->session->set_userdata(array('kode_register'=>'EPI-' . round(microtime(true) * 1000)));
			}
		}
		$kode_register=$this->session->userdata('kode_register');
		$data['kode_register']=$kode_register;
		if($this->check('master_perusahaan',array('kode_register'=>$kode_register),'kode_register')!=''){
			$data['master']=true;
		}else if($this->check('temp_register_data_perusahaan',array('kode_register'=>$kode_register),'kode_register')!=''){
			$data['temp']=true;
		}else{
			$data['new']=true;
		}
		$list_provinsi=$this->db_models->list_dropdown('tr_lokasi_prov',array('id_prov','nama'),'all','','','Select');
		$load_kabupaten='list_dropdown(' . "'dropdown_kabupaten',['dropdown_kecamatan'],'tr_lokasi_kab',['id_kab','nama'],'where id_prov='+$(this).val(),'','','Select'" . ')';
		$load_kecamatan='list_dropdown(' . "'dropdown_kecamatan',[],'tr_lokasi_kec',['id_kec','nama'],'where id_kab='+$(this).val(),'','','Select'" . ')';
		$data['dropdown_provinsi']=form_dropdown("dropdown_provinsi", $list_provinsi, [], 'id="dropdown_provinsi" onchange="' . $load_kabupaten . '" style="width:100%; " class="form-control select2me"');
		$data['dropdown_kabupaten']=form_dropdown("dropdown_kabupaten", [], [], 'id="dropdown_kabupaten" onchange="' . $load_kecamatan . '" style="width:100%; " class="form-control select2me"');
		$data['dropdown_kecamatan']=form_dropdown("dropdown_kecamatan", [], [], 'id="dropdown_kecamatan" style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_provinsi'] = 'dropdown_provinsi';
		$data['nama_dropdown_kabupaten'] = 'dropdown_kabupaten';
		$data['nama_dropdown_kecamatan'] = 'dropdown_kecamatan';

		$list_berkas_administrasi=$this->db_models->list_dropdown('tr_dokumen',array('kode',array('uraian','nama_dokumen'),' (',')' ),'where kode_jen_berkas="adms"','','','Select');
		$data['dropdown_berkas_administrasi']=form_dropdown("dropdown_berkas_administrasi", $list_berkas_administrasi, [], 'id="dropdown_berkas_administrasi" style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_berkas_administrasi'] = 'dropdown_berkas_administrasi';

		$show_sil = "check_sil($(this).val())";
		$load_check="check(['tr_dokumen',['kbli','grade'],$(this).val()],['form_klasifikasi','form_kbli','form_grade'])";
		$load_grade='list_dropdownx(' . "'dropdown_grade',[],'tr_klasifikasi_grade',['kode',['kualifikasi','modal_usaha'],' dengan modal usaha '],['kode_dokumen',$(this).val()],'','','--Pilih Grade--'" . ')';
		$list_berkas_perijinan=$this->db_models->list_dropdown('tr_dokumen',array('kode',array('uraian','nama_dokumen'),' (',')' ),'where kode_jen_berkas="ijin"','','','Select');
		$data['dropdown_berkas_perijinan']=form_dropdown("dropdown_berkas_perijinan", $list_berkas_perijinan, [], 'id="dropdown_berkas_perijinan" onchange="' . $load_check . ';' . $load_grade . ';' . $show_sil . '" style="width:100%; " class="form-control select2me"');
		$data['form_kbli']='form_kbli';
		$data['form_grade']='form_grade';
		$data['form_klasifikasi']='form_klasifikasi';
		$data['nama_dropdown_berkas_perijinan'] = 'dropdown_berkas_perijinan';
		$data['nama_dropdown_grade'] = 'dropdown_grade';
		$data['nama_dropdown_klasifikasi'] = 'dropdown_klasifikasi';
		
		$list_jen_pekerjaan=$this->db_models->list_dropdown('tr_kbli_detil',array('kode',array('kode','deskripsi'),' - '),'where kode_level="kelompok"','','','--Pilih Klasifikasi Pekerjaan--');
		$data['dropdown_jen_pekerjaan']=form_dropdown("dropdown_jen_pekerjaan", $list_jen_pekerjaan, [], 'id="dropdown_jen_pekerjaan" style="width:100%; " class="form-control select2me"');
		$data['dropdown_klasifikasi']=form_dropdown("dropdown_klasifikasi", $list_jen_pekerjaan, [], 'id="dropdown_klasifikasi" style="width:100%; " class="form-control select2me"');
		$data['dropdown_grade']=form_dropdown("dropdown_grade", [], [], 'id="dropdown_grade" style="width:100%; " class="form-control select2me"');
		$data['nama_dropdown_jen_pekerjaan'] = 'dropdown_jen_pekerjaan';

		$list_minat_pekerjaan=$this->db_models->list_dropdown('tr_minat_pekerjaan',array('kode','nama'),'all','','','Select');
		$data['dropdown_minat_pekerjaan']=form_dropdown("dropdown_minat_pekerjaan", $list_minat_pekerjaan, [], 'id="dropdown_minat_pekerjaan" style="width:100%; " class="form-control select2me"');
		
		$data['register_jquery'] = $this->jquery_models->register();
		$data['crude_jquery'] = $this->jquery_models->crude();
		$data['load_tabel_jquery'] = $this->jquery_models->load_tabel();
		$data['ready_jquery'] = $this->jquery_models->ready();
		$data['list_checkbox'] = $this->db_models->result('tr_minat_pekerjaan','all');
		$this->load->view('register/register_new',$data);
	} 
	public function save_tab()
	{
		$id_tab=$this->input->post('id_tab');
		$formData=$this->input->post('formData');
		$is_upload=$this->input->post('is_upload');
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
        $data = array();
        $kolom = $this->db_models->result_kolom($nama_tabel);
		foreach ($kolom as $col) {
			$data[$col->COLUMN_NAME] = $this->formData[$col->COLUMN_NAME];
		}
		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}
	
	public function cek_session(){
		$tabel=$this->input->post('tabel');
		$where=$this->input->post('where');
		$kolom=$this->input->post('kolom');
		$kode_register=$this->input->post('session');
		$hasil=$this->db_models->cek($tabel,$where);
		if($hasil!=''){
			$this->session->set_userdata(array('kode_register'=>$kode_register));
			$url = base_url() . 'register/register';
			header( "Location: $url" );
		}else{
			$this->session->set_userdata(array('kode_register'=>'epi-' . round(microtime(true) * 1000)));
			$url = base_url() . 'register/register';
			header( "Location: $url" );
		}
	}
	public function cek(){
		$tabel=$this->input->post('tabel');
		$where=$this->input->post('where');
		$hasil=$this->db_models->cek($tabel,$where);
		echo json_encode($hasil);
	}
	public function check(){
		$db=$this->input->post('db');
		$check=$this->db_models->get_data($db[0],$db[1],$db[2]);
		echo json_encode($check);
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
			default:
				break;
		}
		echo json_encode($status);
	}
	public function load_tabel()
	{
		$nama_tabel = $this->input->post('nama_tabel');
		$where = $this->input->post('where');
		$tabel = $this->input->post('tabel');
		$data = array();
		$hasil = $this->db_models->result($tabel,$where);
		switch($nama_tabel){
			case 'tabel_daftar_bidang_usaha' : $this->tabel_daftar_bidang_usaha($hasil);break;
			case 'tabel_daftar_berkas_adm' : $this->tabel_daftar_berkas_adm($hasil);break;
			case 'tabel_daftar_pengalaman' : $this->tabel_daftar_pengalaman($hasil);break;
			case 'tabel_daftar_minat' : $this->tabel_daftar_minat($hasil);break;
			case 'tabel_daftar_berkas_ijin' : $this->tabel_daftar_berkas_ijin($hasil);break;
		}
	}
	public function load_data(){
		$data_tabel=array();
		$kode_register = $this->input->post('kode_register');
		$data = $this->input->post('data');
		switch($data){
			case 'perusahaan' : $data_tabel=$this->db_models->result('temp_register_data_perusahaan',array('kode_register'=>$kode_register)); break;
			case 'pic' : $data_tabel=$this->db_models->result('temp_register_data_pic',array('kode_register'=>$kode_register)); break;
			case 'ijin' : $data_tabel=$this->db_models->result('temp_register_berkas_perijinan',array('kode_register'=>$kode_register,'kode_dokumen'=>$this->input->post('kode_dokumen'))); break;
			case 'minat': $data_tabel=$this->db_models->result('temp_register_minat_pekerjaan',array('kode_register'=>$kode_register)); break;
			case 'adms' : $data_tabel=$this->db_models->result('temp_register_berkas_administrasi',array('kode_register'=>$kode_register,'kode_dokumen'=>$this->input->post('kode_dokumen'))); break;
			case 'kbli' : $data_tabel=$this->db_models->result('temp_register_pengalaman',array('kode_register'=>$kode_register,'kode_kbli'=>$this->input->post('kode_kbli'))); break;
			case 'cek_sah' : $data_tabel=$this->db_models->row('tr_dokumen',array('kode'=>$this->input->post('kode')),'perlu_pengesahan'); break;
		}
		// $data_tabel=$this->db_models->result('temp_register_berkas_perijinan',array('kode_dokumen'=>$this->input->post('kode_dokumen')));
		echo json_encode($data_tabel);
	}
	public function tabel_daftar_berkas_ijin($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nomor_dokumen;
			$row[] = $this->db_models->row('tr_dokumen',array('kode'=>$r->kode_dokumen),'uraian');
			if($r->tgl_berakhir!=''){
				$row[] = $r->tgl_berlaku . ' sd ' . $r->tgl_berakhir;
			}else{
				$row[] = $r->tgl_berakhir;
			}
			$row[] = '
					<div class="row">
					<a type="button" class="btn red" onclick="delete_klasifikasi(' . "'" . $r->id .  "'" . ')"  title="Delete Klasifikasi"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_daftar_minat($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $this->db_models->row('tr_minat_pekerjaan',array('kode'=>$r->kode_minat),'nama');
			$row[] = '
					<div class="row">
					<a type="button" class="btn red" onclick="delete_klasifikasi(' . "'" . $r->id .  "'" . ')"  title="Delete Klasifikasi"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_daftar_pengalaman($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->kode_kbli;
			$row[] = $r->nama_pekerjaan;
			$row[] = 'Rp.' . $r->nilai;
			$row[] = $r->tahun;
			$row[] = $r->pemberi_pekerjaan;
			$row[] = '';
			$row[] = '';
			$row[] = '
					<div class="row">
					<a type="button" class="btn red" onclick="delete_klasifikasi(' . "'" . $r->id .  "'" . ')"  title="Delete Klasifikasi"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data, 
		);
		echo json_encode($output);
	}
	public function tabel_daftar_berkas_adm($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nomor_dokumen;
			$row[] = $this->db_models->row('tr_dokumen',array('kode'=>$r->kode_dokumen),'uraian');
			if($r->tgl_berakhir!=''){
				$row[] = $r->tgl_berlaku . ' sd ' . $r->tgl_berakhir;
			}else{
				$row[] = $r->tgl_berakhir;
			}
			$row[] = '
					<div class="row">
					<a type="button" class="btn red" onclick="delete_klasifikasi(' . "'" . $r->id .  "'" . ')"  title="Delete Klasifikasi"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_daftar_bidang_usaha($hasil){
		$i = 1;
		$data=array();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->kode_kbli;
			$row[] = $this->db_models->row('tr_kbli_detil',array('kode'=>$r->kode_kbli),'deskripsi');
			$perlu_grade = $this->db_models->row('tr_dokumen',array('kode'=>$r->kode_dokumen),'grade');
			if($perlu_grade=='1'){
				$row[] = $this->db_models->row('tr_klasifikasi_grade',array('kode'=>$r->kode_grade),'kualifikasi');
				$row[] = $r->modal_usaha;
			} 
			$row[] = '
					<div class="row">
					<a type="button" class="btn red" onclick="delete_klasifikasi(' . "'" . $r->id .  "'" . ')"  title="Delete Klasifikasi"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
			}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
    public function list_dropdown()
	{
		$uraian=array();
        $tabel = $this->input->post('tabel');
		$dt = $this->input->post('data');
        $adder = $this->input->post('adder');
		$where = $this->input->post('where');
		$lainnya = $this->input->post('lainnya');
		$placeholder = $this->input->post('placeholder');
		$data = array();
		$data[0]['id'] = "-";
		$data[0]['uraian'] = $placeholder;
		$val = $this->db_models->list_dropdown_result($tabel,$dt,$where,$adder,$lainnya);
		for($i = 0; $i < count($val); $i++){
			array_push($data,$val[$i]);
		}
		echo json_encode($data);
	}
	public function upload($kel_file=''){
		$name_file='';
		if($kel_file==''){
			$kel_file='umum';

		}else{
			$data = explode("-", $kel_file);
			$kel_file=$data[0];
			if(array_key_exists(1, $data)){
				$name_file=$data[1];
			}
		}
		if (!empty($_FILES['myfile']['name'])) {
			$status['nama_file'] = $_FILES['myfile']['name'];
			$ext = pathinfo($_FILES['myfile']['name'], PATHINFO_EXTENSION);
			$upload = $this->cek_berkas('myfile',$kel_file,$name_file,$ext);
			$status['kode_file'] = $upload;
			echo json_encode($status);
		}else{
			echo 'File Kosong !';
		}
	}
	private function cek_berkas($file_upload,$kel_file,$name_file,$ext)
	{
		$kode_register=$this->session->userdata('kode_register');
		if(!(file_exists('assets/upload_file/' . $kode_register))){
			$result = mkdir ('assets/upload_file/' . $kode_register, '0777');
			if(!(file_exists('assets/upload_file/' . $kode_register .'/' . $kel_file))){
				$result = mkdir ('assets/upload_file/' . $kode_register .'/' . $kel_file, '0777');
			}
		}else{
			if(!(file_exists('assets/upload_file/' . $kode_register .'/' . $kel_file))){
				$result = mkdir ('assets/upload_file/' . $kode_register .'/' . $kel_file, '0777');
			}else{
				if(file_exists('assets/upload_file/' . $kode_register .'/' . $kel_file . '/' . $name_file .'.'.$ext)){
					rename( 'assets/upload_file/' . $kode_register .'/' . $kel_file . '/' . $name_file .'.'.$ext, 'assets/upload_file/' . $kode_register .'/' . $kel_file . '/old_foto.'.$ext) ;
				}
			}
		}
		$config['upload_path']          = 'assets/upload_file/' . $kode_register .'/' . $kel_file;
		$config['allowed_types']        = 'jpeg|jpg|png|pdf|doc|docx|xls|xlsx';
		$config['max_size']             = 100250;
		if($name_file==''){
			$config['file_name']            = round(microtime(true) * 1000);
		}else{
			$config['file_name']            = $name_file;
		}

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload($file_upload)) {
			echo 'Gagal Upload: ' . $file_upload . ' dan ' . $this->upload->display_errors('', '');
			exit();
		}
		return $this->upload->data('file_name');
	}
	public function selesai(){
		$kode_register = $this->input->post('kode_register');
		$data_lengkap = false;
		$dokumen_wajib_lengkap = false;
		$alert = '';

		//data perusahaan
		$data_perusahaan = $this->db_models->result_array('temp_register_data_perusahaan',array('kode_register'=>$kode_register));
		$data_pic = $this->db_models->result_array('temp_register_data_pic',array('kode_register'=>$kode_register));
		$data_pengalaman = $this->db_models->result_array('temp_register_pengalaman',array('kode_register'=>$kode_register));
		$data_minat = $this->db_models->result_array('temp_register_minat_pekerjaan',array('kode_register'=>$kode_register));
		$data_berkas_adm = $this->db_models->result_array('temp_register_berkas_administrasi',array('kode_register'=>$kode_register));
		$data_berkas_ijin = $this->db_models->result_array('temp_register_berkas_perijinan',array('kode_register'=>$kode_register));
		$data_berkas_ijin_klasifikasi = $this->db_models->result_array('temp_register_berkas_perijinan_klasifikasi',array('kode_register'=>$kode_register));
		$dokumen_wajib = $this->db_models->result_array('tr_dokumen',array('wajib'=>'1'));

		$dokumen_tidak_lengkap = array();
		$x=0;
		$y=0;
		for($i=0;$i<sizeof($dokumen_wajib);$i++){
			$cek_berkas_ijin = $this->db_models->cek('temp_register_berkas_perijinan',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_wajib[$i]['kode']));
			$cek_berkas_adm = $this->db_models->cek('temp_register_berkas_administrasi',array('kode_register'=>$kode_register,'kode_dokumen'=>$dokumen_wajib[$i]['kode']));
			if($cek_berkas_ijin!='' || $cek_berkas_adm!=''){
				$x++;
			}else{
				$dokumen_tidak_lengkap[$y]=$this->db_models->row('tr_dokumen',array('kode'=>$dokumen_wajib[$i]['kode']),'uraian');
				$y++;
			}
		}
		if($x==sizeof($dokumen_wajib)){
			$dokumen_wajib_lengkap = true;
		}

		// if(sizeof($data_perusahaan)>0 && sizeof($data_pic)>0 && sizeof($data_pengalaman)>0 && sizeof($data_minat)>0 && sizeof($data_berkas_adm)>0 && sizeof($data_berkas_ijin)>0 && $dokumen_wajib_lengkap){
		if(sizeof($data_perusahaan)>0 && sizeof($data_pic)>0){
			$data_lengkap = true;
		}else{
			// if(sizeof($data_perusahaan)>0){
			// 	$alert
			// }
		}
		if($data_lengkap){
			if($dokumen_wajib_lengkap){
				$master_perusahaan['kode_register']=$data_perusahaan[0]['kode_register'];
				$master_perusahaan['nama_perusahaan']=$data_perusahaan[0]['nama_perusahaan'];
				$master_perusahaan['alamat']=$data_perusahaan[0]['alamat'];
				$master_perusahaan['prov']=$this->db_models->row('tr_lokasi_prov',array('id_prov'=>$data_perusahaan[0]['kode_prov']),'nama');
				$master_perusahaan['kab']=$this->db_models->row('tr_lokasi_kab',array('id_kab'=>$data_perusahaan[0]['kode_kab']),'nama');
				$master_perusahaan['kec']=$this->db_models->row('tr_lokasi_kec',array('id_kec'=>$data_perusahaan[0]['kode_kec']),'nama');
				$master_perusahaan['kode_pos']=$data_perusahaan[0]['kode_pos'];
				$master_perusahaan['jab_tertinggi']=$data_perusahaan[0]['jab_tertinggi'];
				$master_perusahaan['email_perusahaan']=$data_perusahaan[0]['email_perusahaan'];
				$master_perusahaan['nama_jab_tertinggi']=$data_perusahaan[0]['nama_jab_tertinggi'];
				$master_perusahaan['no_telp_perusahaan']=$data_perusahaan[0]['no_telp_perusahaan'];
				$master_perusahaan['email_perusahaan']=$data_perusahaan[0]['email_perusahaan'];
				$master_perusahaan['website_perusahaan']=$data_perusahaan[0]['website_perusahaan'];
				$old=$this->db_models->row('master_perusahaan',array('kode_register'=>$data_perusahaan[0]['kode_register']),'kode_register');
				if($old == ''){
					$this->db_models->insert('master_perusahaan',$master_perusahaan);
				}else{
					$this->db_models->update('master_perusahaan',$master_perusahaan,array('kode_register'=>$data_perusahaan[0]['kode_register']));
				}
				$this->db_models->delete('temp_register_data_perusahaan',array('kode_register'=>$data_perusahaan[0]['kode_register']));
				
				//data pic
				$master_pic['kode_register']=$data_pic[0]['kode_register'];
				$master_pic['nama_pic']=$data_pic[0]['nama_pic'];
				$master_pic['no_hp_pic']=$data_pic[0]['no_hp_pic'];
				$master_pic['email_pic']=$data_pic[0]['email_pic'];
				$master_pic['nik_pic']=$data_pic[0]['nik_pic'];
				$master_pic['kode_file_ktp']=$data_pic[0]['kode_file_ktp'];
				$master_pic['file_foto']=$data_pic[0]['file_foto'];

				$master_berkas=array();
				$master_berkas['kode_register']=$data_pic[0]['kode_register'];
				$master_berkas['kode_file']=$data_pic[0]['kode_file_ktp'];
				$master_berkas['nama_file']=$data_pic[0]['nama_file_ktp'];
				$master_berkas['kode_dokumen']='adms_11';
				$master_berkas['nomor_dokumen']=$data_pic[0]['nik_pic'];
				$master_berkas['sts_eva']='0';

				$old=$this->db_models->row('master_pic',array('kode_register'=>$data_pic[0]['kode_register']),'kode_register');
				if($old == ''){
					$this->db_models->insert('master_pic',$master_pic);
					$this->db_models->insert('master_berkas',$master_berkas);
				}else{
					$this->db_models->update('master_pic',$master_pic,array('kode_register'=>$data_pic[0]['kode_register']));
					$this->db_models->update('master_berkas',$master_berkas,array('kode_register'=>$data_pic[0]['kode_register']));
				}
				$this->db_models->delete('temp_register_data_pic',array('kode_register'=>$data_pic[0]['kode_register']));
				
				//data pengalaman
				if(sizeof($data_pengalaman)>0){
					for($i=0;$i < sizeof($data_pengalaman);$i++){
						$master_pengalaman['kode_register']=$data_pengalaman[$i]['kode_register'];
						$master_pengalaman['kode_kbli']=$data_pengalaman[$i]['kode_kbli'];
						$master_pengalaman['nama_pekerjaan']=$data_pengalaman[$i]['nama_pekerjaan'];
						$master_pengalaman['nilai']=$data_pengalaman[$i]['nilai'];
						$master_pengalaman['tahun']=$data_pengalaman[$i]['tahun'];
						$master_pengalaman['pemberi_pekerjaan']=$data_pengalaman[$i]['pemberi_pekerjaan'];
						$master_pengalaman['kode_dokumen_kontrak']=$data_pengalaman[$i]['kode_dokumen_kontrak'];
						$master_pengalaman['kode_dokumen_bast1']=$data_pengalaman[$i]['kode_dokumen_bast1'];
						$this->db_models->insert('master_pengalaman',$master_pengalaman);
						
						$master_berkas=array();
						$master_berkas['kode_register']=$data_pengalaman[0]['kode_register'];
						$master_berkas['kode_file']=$data_pengalaman[0]['kode_dokumen_kontrak'];
						$master_berkas['nama_file']=$data_pengalaman[0]['nama_dokumen_kontrak'];
						$master_berkas['kode_dokumen']='klpn_01';
						$master_berkas['sts_eva']='0';
						$this->db_models->insert('master_berkas',$master_berkas);

						$master_berkas=array();
						$master_berkas['kode_register']=$data_pengalaman[0]['kode_register'];
						$master_berkas['kode_file']=$data_pengalaman[0]['kode_dokumen_bast1'];
						$master_berkas['nama_file']=$data_pengalaman[0]['nama_dokumen_bast1'];
						$master_berkas['kode_dokumen']='klpn_02';
						$master_berkas['sts_eva']='0';
						$this->db_models->insert('master_berkas',$master_berkas);
					}
					$this->db_models->delete('temp_register_pengalaman',array('kode_register'=>$data_pengalaman[0]['kode_register']));
				}
				//data minat pekerjaan
				if(sizeof($data_minat)>0){
					for($i=0;$i < sizeof($data_minat);$i++){
						$master_minat['kode_register']=$data_minat[$i]['kode_register'];
						$master_minat['kode_minat']=$data_minat[$i]['kode_minat'];
						$this->db_models->insert('master_minat_pekerjaan',$master_minat);
					}
					$this->db_models->delete('temp_register_minat_pekerjaan',array('kode_register'=>$data_minat[0]['kode_register']));
				}

				//data berkas_adm
				if(sizeof($data_berkas_adm)>0){
					for($i=0;$i < sizeof($data_berkas_adm);$i++){
						$master_berkas['kode_register']=$data_berkas_adm[$i]['kode_register'];
						$master_berkas['kode_file']=$data_berkas_adm[$i]['kode_file'];
						$master_berkas['nama_file']=$data_berkas_adm[$i]['nama_file'];
						$master_berkas['kode_dokumen']=$data_berkas_adm[$i]['kode_dokumen'];
						$master_berkas['nomor_dokumen']=$data_berkas_adm[$i]['nomor_dokumen'];
						$master_berkas['nomor_pengesahan']=$data_berkas_adm[$i]['nomor_pengesahan'];
						$master_berkas['tgl_pengesahan']=$data_berkas_adm[$i]['tgl_pengesahan'];
						$master_berkas['tgl_berlaku']=$data_berkas_adm[$i]['tgl_berlaku'];
						$master_berkas['tgl_berakhir']=$data_berkas_adm[$i]['tgl_berakhir'];
						$master_berkas['tgl_upload']=$data_berkas_adm[$i]['tgl_upload'];
						$master_berkas['sts_eva']='0';
						$this->db_models->insert('master_berkas',$master_berkas);
					}
					$this->db_models->delete('temp_register_berkas_administrasi',array('kode_register'=>$data_berkas_adm[0]['kode_register']));
				}
				//data berkas_perijinan
				if(sizeof($data_berkas_ijin)>0){
					for($i=0;$i < sizeof($data_berkas_ijin);$i++){
						$master_berkas['kode_register']=$data_berkas_ijin[$i]['kode_register'];
						$master_berkas['kode_file']=$data_berkas_ijin[$i]['kode_file'];
						$master_berkas['nama_file']=$data_berkas_ijin[$i]['nama_file'];
						$master_berkas['kode_dokumen']=$data_berkas_ijin[$i]['kode_dokumen'];
						$master_berkas['nomor_dokumen']=$data_berkas_ijin[$i]['nomor_dokumen'];
						$master_berkas['nomor_pengesahan']='';
						$master_berkas['tgl_pengesahan']='';
						$master_berkas['tgl_berlaku']=$data_berkas_ijin[$i]['tgl_berlaku'];
						$master_berkas['tgl_berakhir']=$data_berkas_ijin[$i]['tgl_berakhir'];
						$master_berkas['tgl_upload']=$data_berkas_ijin[$i]['tgl_upload'];
						$master_berkas['sts_eva']='0';
						$this->db_models->insert('master_berkas',$master_berkas);
					}
					$this->db_models->delete('temp_register_berkas_perijinan',array('kode_register'=>$data_berkas_ijin[0]['kode_register']));
				}
				//data master ijin / kbli
				if(sizeof($data_berkas_ijin)>0){
					for($i=0;$i < sizeof($data_berkas_ijin_klasifikasi);$i++){
						$master_ijin['kode_reg']=$data_berkas_ijin_klasifikasi[$i]['kode_register'];
						$master_ijin['kode_file']=$this->db_models->row('master_berkas',array('kode_register'=>$data_berkas_ijin_klasifikasi[$i]['kode_register'],'kode_dokumen'=>$data_berkas_ijin_klasifikasi[$i]['kode_dokumen']),'kode_file');
						$master_ijin['kategori']=$this->db_models->row('tr_dokumen',array('kode'=>$data_berkas_ijin_klasifikasi[$i]['kode_dokumen']),'kode_jen_dokumen');
						$master_ijin['jenis']=$this->db_models->row('tr_dokumen',array('kode'=>$data_berkas_ijin_klasifikasi[$i]['kode_dokumen']),'nama_dokumen');
						$master_ijin['kode_kbli']=$data_berkas_ijin_klasifikasi[$i]['kode_kbli'];
						$master_ijin['klasifikasi']=$data_berkas_ijin_klasifikasi[$i]['kode_grade'];
						$master_ijin['modal_usaha']=$data_berkas_ijin_klasifikasi[$i]['modal_usaha'];
						$master_ijin['sts_eva']='0';
						$this->db_models->insert('master_ijin',$master_ijin);
					}
					$this->db_models->delete('temp_register_berkas_perijinan_klasifikasi',array('kode_register'=>$data_berkas_ijin_klasifikasi[0]['kode_register']));
				}
				echo json_encode(['ok']);
			}else{
				echo json_encode($dokumen_tidak_lengkap);
			}
		}else{
			echo json_encode(['no']);
		}
	}
	public function list_dropdownx()
	{
		$uraian=array();
        $tabel = $this->input->post('tabel');
		$dt = $this->input->post('data');
        $adder = $this->input->post('adder');
		$where = $this->input->post('where');
		$lainnya = $this->input->post('lainnya');
		$placeholder = $this->input->post('placeholder');
		$data = array();
		$data[0]['id'] = "-";
		$data[0]['uraian'] = $placeholder;
		$val = $this->db_models->list_dropdown_resultx($tabel,$dt,$where,$adder,$lainnya);
		for($i = 0; $i < count($val); $i++){
			array_push($data,$val[$i]);
		}
		echo json_encode($data);
	}
}