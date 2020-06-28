<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelayanan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('registercustm');
		$this->load->model('permohonanm');
		$this->load->model('surveym');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function pelangganbaru(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$this->load->view('pelayanan/pelangganbaru',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cust_list()
	{
		$list = $this->registercustm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_CUST;
			$row[] = $pelayanan->ALAMAT_CUST;
			$row[] = $pelayanan->KABCUST;
			$row[] = $pelayanan->PROVCUST;
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_cust('."'".$pelayanan->ID_CUST."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_cust('."'".$pelayanan->ID_CUST."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->registercustm->count_all(),
						"recordsFiltered" => $this->registercustm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function cust_edit($id)
	{
		$data = $this->registercustm->get_by_id_full($id);
		echo json_encode($data);
	}

	public function cust_add()
	{
		$urutcust= substr($this->input->post('id_cust'),2,4);
		$cekcust = $this->db->query("SELECT ID_CUST FROM CUST WHERE SUBSTRING(id_cust,3,4)='$urutcust' ");
		if($cekcust->num_rows()>0){
			$urut = $this->db->query("SELECT LPAD(MAX(SUBSTRING(id_cust,3,4))+1,4,'0000') AS id_cust FROM cust")->row("id_cust");
			$ambilrand = $urutcust= substr($this->input->post('id_cust'),7,1);
			$cust = '88'.$urut.$ambilrand;
		}else{
			$cust = $this->input->post('id_cust');
		}
			$datac = array(
				'ID_CUST' => $cust,
				'NAMA_CUST' => $this->input->post('nama_cust'),
				'ALAMAT_CUST' => $this->input->post('alamat_cust'),
				'KOGOL' => $this->input->post('kogol'),
				'KEC_CUST' => $this->input->post('kec_cust'),
				'KOTA_CUST' => $this->input->post('kota_cust'),
				'PROV_CUST' => $this->input->post('prov_cust'),
				'KDPOS_CUST' => $this->input->post('kdpos_cust'),
				'NPWP_CUST' => $this->input->post('npwp_cust'),
				'NAMA_PIMPINAN' => $this->input->post('nama_pimpinan'),
				'JAB_PIMPINAN' => $this->input->post('jab_pimpinan'),
				'HP1' => $this->input->post('hp1'),
				'HP2' => $this->input->post('hp2'),
				'EMAIL1' => $this->input->post('email1'),
				'EMAIL2' => $this->input->post('email2'),
				'TELP' => $this->input->post('telp'),
				'TGL_UPDATE_CUST' => date('Y-m-d'),
				'USER_ENTRY' => $this->session->userdata('nama'),
				'KD_UJL' => $this->input->post('kd_ujl')
			);
			$insert = $this->registercustm->save('cust',$datac);
			echo json_encode(array("status" => TRUE));
	}

	public function cust_update()
	{
		$datac = array(
			'ID_CUST' => $this->input->post('id_cust'),
			'NAMA_CUST' => $this->input->post('nama_cust'),
			'ALAMAT_CUST' => $this->input->post('alamat_cust'),
			'KOGOL' => $this->input->post('kogol'),
			'KDPOS_CUST' => $this->input->post('kdpos_cust'),
			'NPWP_CUST' => $this->input->post('npwp_cust'),
			'NAMA_PIMPINAN' => $this->input->post('nama_pimpinan'),
			'JAB_PIMPINAN' => $this->input->post('jab_pimpinan'),
			'HP1' => $this->input->post('hp1'),
			'HP2' => $this->input->post('hp2'),
			'EMAIL1' => $this->input->post('email1'),
			'EMAIL2' => $this->input->post('email2'),
			'TELP' => $this->input->post('telp'),
			'TGL_UPDATE_CUST' => date('Y-m-d'),
			'USER_ENTRY' => $this->session->userdata('nama')
		);
		$this->registercustm->update('cust',array('ID_CUST' => $this->input->post('id_cust')), $datac);
		echo json_encode(array("status" => TRUE));
	}

	public function cust_delete($id)
	{
		$this->registercustm->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

	function otoidcust(){
		$otoidcust = $this->registercustm->get_otoidcust();
		echo json_encode($otoidcust);
	}

	public function get_chain_kab_mohon($id){
		$data_id = $this->permohonanm->get_chain_kab_mohon($id);
		echo json_encode($data_id);
	}

	public function get_chain_kec_mohon($id){
		$data_id = $this->permohonanm->get_chain_kec_mohon($id);
		echo json_encode($data_id);
	}

	public function get_chain_kab_lang($id){
		$data_id = $this->permohonanm->get_chain_kab_lang($id);
		echo json_encode($data_id);
	}

	public function get_chain_kec_lang($id){
		$data_id = $this->permohonanm->get_chain_kec_lang($id);
		echo json_encode($data_id);
	}

	public function get_daya($tarif){
		$data_daya = $this->permohonanm->get_daya($tarif);
		echo json_encode($data_daya);
	}

	public function get_rplwbps($tarif){
		$data_rplwbps = $this->permohonanm->get_rplwbps($tarif);
		echo json_encode($data_rplwbps);
	}

	public function get_chain_klmpkteg($id){
		$data_id = $this->permohonanm->get_chain_klmpkteg($id);
		echo json_encode($data_id);
	}

	public function get_chain_tarif($id){
		$data_id = $this->permohonanm->get_chain_tarif($id);
		echo json_encode($data_id);
	}

	public function get_chain_daya($id){
		$data_id = $this->permohonanm->get_chain_daya($id);
		echo json_encode($data_id);
	}

	public function get_chain_dayas($id){
		$data_id = $this->permohonanm->get_chain_dayas($id);
		echo json_encode($data_id);
	}

	public function get_chain_jamnyala($id){
		$data_id = $this->permohonanm->get_chain_jamnyala($id);
		echo json_encode($data_id);
	}

	public function get_tarif($kd_tarif){
		$data_tarif = $this->permohonanm->get_tarif($kd_tarif);
		echo json_encode($data_tarif);
	}

	public function get_datapanel($id){
		$data_id = $this->permohonanm->get_datapanel($id);
		echo json_encode($data_id);
	}

	public function peruntukan($id){
		$data_peruntuakan = $this->permohonanm->get_peruntukan($id);
		echo json_encode($data_peruntuakan);
	}

	public function jamnyala($kd_jamnyala){
		$data_jamnyala = $this->permohonanm->get_jamnyala($kd_jamnyala);
		echo json_encode($data_jamnyala);
	}

	public function cari_cl($idcari=''){
		$data_all = $this->permohonanm->get_cl($idcari);
		echo json_encode($data_all);
	}

	public function cari_cll($idcari=''){
		$data_all = $this->permohonanm->get_cll($idcari);
		echo json_encode($data_all);
	}

	public function carim($idcari=''){
		$data_all = $this->permohonanm->getm($idcari);
		echo json_encode($data_all);
	}

	public function cari_pdl($idcari=''){
		$data_all = $this->permohonanm->get_pdl($idcari);
		echo json_encode($data_all);
	}

	public function cari_angs($noagd='',$idlang=''){
		$data_all = $this->permohonanm->get_angs($noagd='',$idlang='');
		echo json_encode($data_all);
	}

	public function cari_angs_nonmohon($idlang=''){
		$data_all = $this->permohonanm->get_angs_nonmohon($idlang='');
		echo json_encode($data_all);
	}

	public function caricust($idcari=''){
		$data_cust = $this->permohonanm->get_cust($idcari);
		echo json_encode($data_cust);
	}

	public function carimelanjutkan($idcari=''){
		$data_sementara = $this->permohonanm->get_melanjutkan($idcari);
		echo json_encode($data_sementara);
	}

	public function carilang($idcari=''){
		$data_langganan = $this->permohonanm->get_langganan($idcari);
		echo json_encode($data_langganan);
	}

	public function cariagendasurvey($idcari=''){
		$data_agenda = $this->permohonanm->get_agendasurvey($idcari);
		echo json_encode($data_agenda);
	}

	public function carisementara($idcari=''){
		$data_agenda = $this->permohonanm->get_sementara($idcari);
		echo json_encode($data_agenda);
	}

	public function carisementaral($idcari=''){
		$data_agenda = $this->permohonanm->get_sementaral($idcari);
		echo json_encode($data_agenda);
	}

	public function cariagenda($idcari=''){
		$data_agenda = $this->permohonanm->get_agenda($idcari);
		echo json_encode($data_agenda);
	}

	public function cariagendal($idcari=''){
		$data_agenda = $this->permohonanm->get_agendal($idcari);
		echo json_encode($data_agenda);
	}

	public function cariagendaps($idcari=''){
		$data_agenda = $this->permohonanm->get_agendaps($idcari);
		echo json_encode($data_agenda);
	}

	public function cari_dil($idcari=''){
		$data_all = $this->permohonanm->get_dil($idcari);
		echo json_encode($data_all);
	}

	public function cari_janji($idcaria='',$idcarib=''){
		$data_agenda = $this->permohonanm->get_janji($idcaria,$idcarib);
		echo json_encode($data_agenda);
	}

	function otoagenda(){
		$otoagenda = $this->permohonanm->get_otoagenda();
		echo json_encode($otoagenda);
	}

	public function otoppj($trf='',$prv=''){
		$data_ppj = $this->permohonanm->get_ppj($trf,$prv);
		echo json_encode($data_ppj);
	}

	function otopdl(){
		$otopdl = $this->permohonanm->get_otopdl();
		echo json_encode($otopdl);
	}

	function otosipb(){
		$otosipb = $this->permohonanm->get_otosipb();
		echo json_encode($otosipb);
	}

	public function nosip_update()
	{
		$data = array(
			'NO_SIP' => $this->input->post('no_sipb')
		);
		$this->registercustm->update('tp_agenda',array('NO_AGENDA' => $this->input->post('no_agenda')), $data);
	}

	public function pasangbaru(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$datax['tarif_baru']=[];
			$datax['daya_baru']= [];
			$datax['klmpk_teg']=[];
			$datax['peruntukan']=$this->permohonanm->by_peruntukan();
			$datax['jamnyala']=$this->permohonanm->by_jamnyala();
			$datax['kec_lang']=[];
			$datax['kota_lang']=[];
			$datax['prov_lang']=$this->permohonanm->by_prov();
			$datax['kec_mohon']=[];
			$datax['kota_mohon']=[];
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$this->load->view('pelayanan/pasangbaru',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function pasangbaru_add()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang 	= date('Y-m-d H:i:s');
		$thblmohon = date("Ym");
		$noagd = $this->input->post('no_agenda');
		$this->db->query("DELETE FROM TP_AGENDA WHERE NO_AGENDA = '$noagd' ");
		$DY = $this->input->post('daya_baru');
		IF($DY < 6600){
			$TG = 'T';
		}else{
			$TG = 'G';
		}

		$data = array(
				'NO_AGENDA' => $this->input->post('no_agenda'),
				'NO_REG' => $this->input->post('no_reg'),
				'TGL_MOHON' => $sekarang,
				'THBL_MOHON' => $thblmohon,
				'ID_CUST' => $this->input->post('id_cust'),
				'NAMA_MOHON' => $this->input->post('nama_mohon'),
				'ALAMAT_MOHON' => $this->input->post('alamat_mohon'),
				'KEC_MOHON' => $this->input->post('kec_mohon'),
				'KOTA_MOHON' => $this->input->post('kota_mohon'),
				'PROV_MOHON' => $this->input->post('prov_mohon'),
				'KDPOS_MOHON' => $this->input->post('kdpos_mohon'),
				'TELP_MOHON' => $this->input->post('telp_mohon'),
				'HP_MOHON' => $this->input->post('hp_mohon'),
				'EMAIL_MOHON' => $this->input->post('email_mohon'),
				'IDENTITAS_MOHON' => $this->input->post('identitas_mohon'),
				'NO_IDENTITAS_MOHON' => $this->input->post('no_identitas_mohon'),
				'ASAL_MOHON' => $this->input->post('asal_mohon'),
				'PAKET_SAR' => $this->input->post('paket_sar'),

				'NAMA_LANG' => $this->input->post('nama_lang'),
				'ALAMAT_LANG' => $this->input->post('alamat_lang'),
				'KEC_LANG' => $this->input->post('kec_lang'),
				'KOTA_LANG' => $this->input->post('kota_lang'),
				'PROV_LANG' => $this->input->post('prov_lang'),
				'KDPOS_LANG' => $this->input->post('kdpos_lang'),
				'KD_WILAYAH' => $this->input->post('kd_wilayah'),
				'KD_AREA' => $this->input->post('kd_area'),

				'POLA_PEMBAYARAN' => $this->input->post('pola_bayar'),
				'TARIF_BARU' => $this->input->post('tarif_baru'),
				'PERUNTUKAN' => $this->input->post('peruntukan'),
				'DAYA_BARU' => $this->input->post('daya_baru'),
				'KD_JAMNYALA_EMIN' => $this->input->post('jamnyala'),

				'KOGOL' => $this->input->post('kogol'),
				'KD_TG' => $TG,
				'KD_BK' => $this->input->post('kd_bk'),
				'KD_PPJ' => $this->input->post('kd_ppj'),
				'ID_LANG_TUJUAN_BAYAR' => (empty($this->input->post('id_lang_bayar'))) ? 0 : $this->input->post('id_lang_bayar'),
				'STATUS_MOHON' => '1',
				'STATUS_CREATE_ID' => 'YA',
				'JNS_TRANSAKSI' => 'PASANG BARU',
				'KD_BISNIS' => '0',
				'STATUS_PECAHAN' => 'ADA',
				'KD_MUT' => 'A',
				'TGL_UPDATE_MOHON' => $sekarang,
				'LAMA_MOHON' => "1"
			);

		#penetapan RP_UJL_BARU
		$trx 				= $this->input->post('tarif_baru');
		$kogolx 			= $this->input->post('kogol');
		$kd_jamnyala_eminx 	= $this->input->post('jamnyala');
		$kd_bkx 			= $this->input->post('kd_bk');
		$paket_sarx			= $this->input->post('paket_sar');

		$q = $this->db->query("
								SELECT * FROM v_tr_tarif
								WHERE KD_TARIF = '$trx'
							");
		foreach ($q->result() as $r)
		{
			$rplwbpx = round($r->RP_LWBP,1);
		}

		$q = $this->db->query("
								SELECT * FROM tr_jamnyala
								WHERE kd_jamnyala = '$kd_jamnyala_eminx'
							");
		foreach ($q->result() as $r)
		{
			$nilai_jam_eminx = $r->nilai_jamnyala;
		}

		$q = $this->db->query("
								SELECT * FROM tr_bk
								WHERE kd_bk = '$kd_bkx'
							");
		foreach ($q->result() as $r)
		{
			$bsr_bkx = $r->bsr_bk;
		}

		if( $kogolx == '0' or $kogolx == '4')
		{
			#CEK KODE_UJL = PAKET_SAR
			if($paket_sarx == "1" or $paket_sarx == "2" or $paket_sarx == "3" )
			{
				$data['RP_UJL_BARU'] = 0;
				$data['RP_UJL_TAGIH'] = 0;
			}
			else
			{
				#RUMUS UJL
				#A = ( (Daya / 1000) * Jam nyala emin * tarif LWBP )
				#B = A * 3
				#C = B * BK rekening Emin
				#D = B + C;
				$rp_1 	= ($DY/1000) * $nilai_jam_eminx * $rplwbpx;
				$rp_2 	= $rp_1 * 3;
				$rp_3 	= ROUND($rp_2 * $bsr_bkx,0) ;
				$rp_4   = $rp_2 + $rp_3;
				$rp_ujl = round($rp_4 ,0);
				$data['RP_UJL_BARU'] = $rp_ujl;
				$data['RP_UJL_TAGIH'] = $rp_ujl;
				#$data['USER_ENTRI_PDL'] = "Daya=$DY 1000 JAMNYALA=$nilai_jam_eminx RPLWBP=$rplwbpx rp1=$rp_1 rp2=$rp_2 rp3=$rp_3 rp4=$rp_4";
				$data['USER_ENTRI_PDL'] = $this->session->userdata('nama');

			}
		}
		else
		{
			$data['RP_UJL_BARU'] = 0;
			$data['RP_UJL_TAGIH'] = 0;
		}

		$insert = $this->permohonanm->save('tp_agenda',$data);
		echo json_encode(array("status" => TRUE));
	}

	public function perubahandaya(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['tarif_baru']=$this->permohonanm->by_tarif();
			$datax['daya_baru']= [];
			$datax['klmpk_teg']=[];
			$datax['peruntukan']=$this->permohonanm->by_peruntukan();
			$datax['jamnyala']=$this->permohonanm->by_jamnyala();
			$datax['kec_mohon']=[];
			$datax['kota_mohon']=[];
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$this->load->view('pelayanan/perubahandaya',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function perubahan_add()
	{
		$noagd = $this->input->post('no_agenda');
		$this->db->query("DELETE FROM TP_AGENDA WHERE NO_AGENDA = '$noagd' ");
		$THBL_MOHON = date("Ym");
		$sekarang = date("Y-m-d");
		$DY = $this->input->post('daya_baru');
		IF($DY < 6600){
			$TG = 'T';
		}else{
			$TG = 'G';
		}

		$dataa = array(
			'NO_AGENDA' => $this->input->post('no_agenda'),
			'NO_REG' => $this->input->post('no_reg'),
			'TGL_MOHON' => $this->input->post('tgl_mohon'),
			'THBL_MOHON' => $THBL_MOHON,
			'ID_LANG' => $this->input->post('id_lang'),
			'ID_CUST' => $this->input->post('id_cust'),
			'NAMA_MOHON' => $this->input->post('nama_mohon'),
			'ALAMAT_MOHON' => $this->input->post('alamat_mohon'),
			'KEC_MOHON' => $this->input->post('kec_mohon'),
			'KOTA_MOHON' => $this->input->post('kota_mohon'),
			'PROV_MOHON' => $this->input->post('prov_mohon'),
			'KDPOS_MOHON' => $this->input->post('kdpos_mohon'),
			'TELP_MOHON' => $this->input->post('telp_mohon'),
			'HP_MOHON' => $this->input->post('hp_mohon'),
			'EMAIL_MOHON' => $this->input->post('email_mohon'),
			'IDENTITAS_MOHON' => $this->input->post('identitas_mohon'),
			'NO_IDENTITAS_MOHON' => $this->input->post('no_identitas_mohon'),
			'ASAL_MOHON' => $this->input->post('asal_mohon'),
			'PAKET_SAR' => $this->input->post('KD_UJL'),

			'NAMA_LANG' => $this->input->post('nama_lang'),
			'ALAMAT_LANG' => $this->input->post('alamat_lang'),
			'KEC_LANG' => $this->input->post('idkec_lang'),
			'KOTA_LANG' => $this->input->post('idkota_lang'),
			'PROV_LANG' => $this->input->post('idprov_lang'),
			'KDPOS_LANG' => $this->input->post('kdpos_lang'),
			'KD_WILAYAH' => $this->input->post('kd_wilayah'),
			'KD_AREA' => $this->input->post('kd_area'),

			'POLA_PEMBAYARAN' => $this->input->post('pola_bayar'),
			'TARIF_BARU' => $this->input->post('tarif_baru'),
			'PERUNTUKAN' => $this->input->post('peruntukan'),
			'DAYA_BARU' => $this->input->post('daya_baru'),
			'KD_JAMNYALA_EMIN' => $this->input->post('jamnyala'),
			'DAYA_LAMA' => $this->input->post('daya_lama'),
			'TARIF_LAMA' => $this->input->post('tarif_lama'),
			'DAYA_BARU' => $this->input->post('daya_baru'),
			'TARIF_BARU' => $this->input->post('tarif_baru'),

			'KOGOL' => $this->input->post('kogol'),
			'KD_TG' => $TG,
			'KD_BK' => $this->input->post('kd_bk'),
			'KD_PPJ' => $this->input->post('kd_ppj'),
			'ID_LANG_TUJUAN_BAYAR' => (empty($this->input->post('id_lang_bayar'))) ? 0 : $this->input->post('id_lang_bayar'),
			'STATUS_MOHON' => '1',
			'STATUS_CREATE_ID' => 'YA',
			'JNS_TRANSAKSI' => 'PERUBAHAN DAYA',
			'KD_BISNIS' => '0',
			'STATUS_PECAHAN' => 'ADA',
			'KD_MUT' => 'E',
			'TGL_UPDATE_MOHON' => $sekarang,
			'LAMA_MOHON' => "1"
		);
		$this->permohonanm->save('tp_agenda', $dataa);
		echo json_encode(array("status" => TRUE));
	}

	public function perubahannamaalamat(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thbl']=date("Ym");
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['areax']=$this->permohonanm->by_area();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$datax['kec_mohon']=[];
			$datax['kota_mohon']=[];
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$this->load->view('pelayanan/perubahannamaalamat',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function perubahannama_add()
	{
		$noagd = $this->input->post('no_agenda');
		$this->db->query("DELETE FROM TP_AGENDA WHERE NO_AGENDA = '$noagd' ");
		$THBL_MOHON = date("Ym");
		$sekarang = date("Y-m-d");
		$DY = $this->input->post('daya_baru');
		IF($DY < 6600){
			$TG = 'T';
		}else{
			$TG = 'G';
		}
		$dataa = array(
			'NO_AGENDA' => $this->input->post('no_agenda'),
			'NO_REG' => $this->input->post('no_reg'),
			'TGL_MOHON' => $this->input->post('tgl_mohon'),
			'THBL_MOHON' => $THBL_MOHON,
			'ID_LANG' => $this->input->post('id_lang'),
			'ID_CUST' => $this->input->post('id_cust'),
			'NAMA_MOHON' => $this->input->post('nama_mohon'),
			'ALAMAT_MOHON' => $this->input->post('alamat_mohon'),
			'KEC_MOHON' => $this->input->post('kec_mohon'),
			'KOTA_MOHON' => $this->input->post('kota_mohon'),
			'PROV_MOHON' => $this->input->post('prov_mohon'),
			'KDPOS_MOHON' => $this->input->post('kdpos_mohon'),
			'TELP_MOHON' => $this->input->post('telp_mohon'),
			'HP_MOHON' => $this->input->post('hp_mohon'),
			'EMAIL_MOHON' => $this->input->post('email_mohon'),
			'IDENTITAS_MOHON' => $this->input->post('identitas_mohon'),
			'NO_IDENTITAS_MOHON' => $this->input->post('no_identitas_mohon'),
			'ASAL_MOHON' => $this->input->post('asal_mohon'),
			'PAKET_SAR' => $this->input->post('KD_UJL'),

			'NAMA_LANG' => $this->input->post('nama_langx'),
			'ALAMAT_LANG' => $this->input->post('alamat_langx'),

			'KEC_LANG' => $this->input->post('idkec_lang'),
			'KOTA_LANG' => $this->input->post('idkota_lang'),
			'PROV_LANG' => $this->input->post('idprov_lang'),
			'KDPOS_LANG' => $this->input->post('kdpos_lang'),
			'KD_WILAYAH' => $this->input->post('kd_wilayah'),
			'KD_AREA' => $this->input->post('kd_area'),

			'POLA_PEMBAYARAN' => $this->input->post('pola_bayar'),
			'PERUNTUKAN' => '1',
			'KD_JAMNYALA_EMIN' => $this->input->post('jamnyala'),
			'DAYA_BARU' => $this->input->post('daya_baru'),
			'TARIF_BARU' => $this->input->post('tarif_baru'),

			'KOGOL' => $this->input->post('kogol'),
			'KD_TG' => $TG,
			'KD_BK' => $this->input->post('kd_bk'),
			'KD_PPJ' => $this->input->post('kd_ppj'),
			'ID_LANG_TUJUAN_BAYAR' => (empty($this->input->post('id_lang_bayar'))) ? 0 : $this->input->post('id_lang_bayar'),
			'STATUS_MOHON' => '1',
			'STATUS_CREATE_ID' => 'YA',
			'JNS_TRANSAKSI' => 'BALIK NAMA',
			'KD_BISNIS' => '0',
			'STATUS_PECAHAN' => 'TIDAK',
			'KD_MUT' => 'B',
			'TGL_UPDATE_MOHON' => $sekarang,
			'LAMA_MOHON' => "1"
		);
		$C = $this->input->post('id_cust');
		$q = $this->db->query("SELECT a.TARIF, a.DAYA, a.KD_JAMNYALA_EMIN, a.KOGOL, a.KD_BK, a.RP_UJL, b.KD_UJL
							FROM DIL_LISTRIK_REF a
							JOIN CUST b ON a.ID_CUST = b.ID_CUST
							WHERE a.ID_CUST = '$C' LIMIT 1");
			foreach($q->result() as $r){
				$TR = $r->TARIF;
				$DA = $r->DAYA;
				$JAM= $r->KD_JAMNYALA_EMIN;
				$KOG= $r->KOGOL;
				$BK = $r->KD_BK;
				$SAR= $r->KD_UJL;
				$UJL= $r->RP_UJL;
			}

		$q = $this->db->query("
								SELECT * FROM v_tr_tarif
								WHERE KD_TARIF = '$TR'
							");
		foreach ($q->result() as $r)
		{
			$rplwbpx = round($r->RP_LWBP,1);
		}

		$q = $this->db->query("
								SELECT * FROM tr_jamnyala
								WHERE kd_jamnyala = '$JAM'
							");
		foreach ($q->result() as $r)
		{
			$nilai_jam_eminx = $r->nilai_jamnyala;
		}

		$q = $this->db->query("
								SELECT * FROM tr_bk
								WHERE kd_bk = '$BK'
							");
		foreach ($q->result() as $r)
		{
			$bsr_bkx = $r->bsr_bk;
		}

		if( $KOG == '0' or $KOG == '4')
		{
			#CEK KODE_UJL = PAKET_SAR
			if($SAR == "1" or $SAR == "2" or $SAR == "3" )
			{
				$dataa['RP_UJL_BARU'] = 0;
				$dataa['RP_UJL_TAGIH'] = 0;
			}
			else
			{
				#RUMUS UJL
				#A = ( (Daya / 1000) * Jam nyala emin * tarif LWBP )
				#B = A * 3
				#C = B * BK rekening Emin
				#D = B + C;
				$rp_1 	= ($DA/1000) * $JAM * $rplwbpx;
				$rp_2 	= $rp_1 * 3;
				$rp_3 	= ROUND($rp_2 * $bsr_bkx,0) ;
				$rp_4   = $rp_2 + $rp_3;
				$rp_ujl = round($rp_4 ,0);

				$UJL_AKHIR = $UJL - $rp_ujl;
				$dataa['RP_UJL_BARU'] = $UJL_AKHIR;
				$dataa['RP_UJL_TAGIH'] = $UJL_AKHIR;

				#$data['USER_ENTRI_PDL'] = "Daya=$DY 1000 JAMNYALA=$nilai_jam_eminx RPLWBP=$rplwbpx rp1=$rp_1 rp2=$rp_2 rp3=$rp_3 rp4=$rp_4";
			}
		}
		else
		{
			$data['RP_UJL_BARU'] = 0;
			$data['RP_UJL_TAGIH'] = 0;
		}

		$this->permohonanm->save('tp_agenda', $dataa);
		echo json_encode(array("status" => TRUE));
	}

	public function sementara(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thbl']=date("Ym");
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['tarif_baru']=$this->permohonanm->by_tarifs();
			$datax['daya_baru']=$this->permohonanm->by_dayas();
			$datax['kec_mohon']=[];
			$datax['kota_mohon']=[];
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$datax['kec_lang']=[];
			$datax['kota_lang']=[];
			$datax['prov_lang']=$this->permohonanm->by_prov();
			$datax['peruntukan']=$this->permohonanm->by_peruntukan();
			$datax['perpanjangan']=$this->permohonanm->by_perpanjangan();
			$this->load->view('pelayanan/sementara',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function sementara_add()
	{
		$noagd = $this->input->post('no_agenda');
		$this->db->query("DELETE FROM tp_agenda WHERE NO_AGENDA = '$noagd' ");
		$THBL_MOHON = date("Ym");
		$sekarang = date("Y-m-d");
		$DY = $this->input->post('daya_baru');
		IF($DY < 6600){
			$TG = 'T';
		}else{
			$TG = 'G';
		}
		$total = $this->input->post('total_biaya');
		$ppjx = $this->input->post('kd_ppj');

		$rpbpju_ps  = ROUND(($ppjx / 100),4) * $total;
		$rpjml_ps	= $total + $rpbpju_ps;

		$data = array(
				'NO_AGENDA' => $this->input->post('no_agenda'),
				'ID_CUST' => $this->input->post('id_cust'),
				'NO_REG' => $this->input->post('no_reg'),
				'TGL_MOHON' => $this->input->post('tgl_mohon'),
				'THBL_MOHON' => $THBL_MOHON,
				'NAMA_MOHON' => $this->input->post('nama_mohon'),
				'ALAMAT_MOHON' => $this->input->post('alamat_mohon'),
				'KEC_MOHON' => $this->input->post('kec_mohon'),
				'KOTA_MOHON' => $this->input->post('kota_mohon'),
				'PROV_MOHON' => $this->input->post('prov_mohon'),
				'KDPOS_MOHON' => $this->input->post('kdpos_mohon'),
				'TELP_MOHON' => $this->input->post('telp_mohon'),
				'HP_MOHON' => $this->input->post('hp_mohon'),
				'EMAIL_MOHON' => $this->input->post('email_mohon'),
				'IDENTITAS_MOHON' => $this->input->post('identitas_mohon'),
				'NO_IDENTITAS_MOHON' => $this->input->post('no_identitas_mohon'),
				'ASAL_MOHON' => $this->input->post('asal_mohon'),
				'PAKET_SAR' => $this->input->post('paket_sar'),
				'PERUNTUKAN' => $this->input->post('peruntukan'),

				'NAMA_LANG' => $this->input->post('nama_lang'),
				'ALAMAT_LANG' => $this->input->post('alamat_lang'),
				'KEC_LANG' => $this->input->post('kec_lang'),
				'KOTA_LANG' => $this->input->post('kota_lang'),
				'PROV_LANG' => $this->input->post('prov_lang'),
				'KDPOS_LANG' => $this->input->post('kdpos_lang'),

				'TARIF_BARU' => $this->input->post('tarif_baru'),
				'DAYA_BARU' => $this->input->post('daya_baru'),
				'JNS_TRANSAKSI' => 'SEMENTARA',
				'TOTAL_BIAYA' => $this->input->post('total_biaya'),
				'KD_WILAYAH' => $this->input->post('kd_wilayah'),
				'KD_AREA' => $this->input->post('kd_area'),
				'KD_BISNIS' => $this->input->post('kd_bisnis'),
				'TGL_AWAL' => $this->input->post('tgl_awal'),
				'TGL_AKHIR' => $this->input->post('tgl_akhir'),
				'LAMA_WAKTU' => $this->input->post('lama_waktu'),

				'KOGOL' => $this->input->post('kogol'),
				'KD_TG' => $TG,
				'KD_BK' => $this->input->post('kd_bk'),
				'KD_PPJ' => $this->input->post('kd_ppj'),
				'POLA_PEMBAYARAN' => $this->input->post('pola_bayar'),

				'ID_LANG_TUJUAN_BAYAR' => (empty($this->input->post('id_lang_bayar'))) ? 0 : $this->input->post('id_lang_bayar'),
				'STATUS_MOHON' => '1',
				'STATUS_CREATE_ID' => 'YA',
				'JNS_TRANSAKSI' => 'PENERANGAN SEMENTARA',
				'KD_BISNIS' => '0',
				'STATUS_PECAHAN' => 'TIDAK',
				'KD_MUT' => 'I',
				'RPKWH_PS' => $this->input->post('total_biaya'),
				'RPBPJU_PS' => $rpbpju_ps,
				'RPJML_PS' => $rpjml_ps,
				'KWH_PS' => $this->input->post('kwh_ps'),
				'TGL_UPDATE_MOHON' => $sekarang,
				'LAMA_MOHON' => "1"
			);
		$insert = $this->permohonanm->save('tp_agenda',$data);
		echo json_encode(array("status" => TRUE));
	}

	public function bongkar(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$datax['kec_mohon']=[];
			$datax['kota_mohon']=[];
			$datax['prov_mohon']=$this->permohonanm->by_prov();
			$this->load->view('pelayanan/bongkar',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function bongkar_add()
	{
		$noagd = $this->input->post('no_agenda');
		$this->db->query("DELETE FROM TP_AGENDA WHERE NO_AGENDA = '$noagd' ");
		$THBL_MOHON = date("Ym");
		$sekarang = date("Y-m-d");
		$DY = $this->input->post('daya_baru');
		IF($DY < 6600){
			$TG = 'T';
		}else{
			$TG = 'G';
		}

		$data = array(
				'ID_CUST' => $this->input->post('id_cust'),
				'ID_LANG' => $this->input->post('id_lang'),
				'TGL_MOHON' => $this->input->post('tgl_mohon'),
				'NO_AGENDA' => $this->input->post('no_agenda'),
				'NO_REG' => $this->input->post('no_reg'),
				'THBL_MOHON' => $THBL_MOHON,

				'NAMA_MOHON' => $this->input->post('nama_mohon'),
				'ALAMAT_MOHON' => $this->input->post('alamat_mohon'),
				'KEC_MOHON' => $this->input->post('kec_mohon'),
				'KOTA_MOHON' => $this->input->post('kota_mohon'),
				'PROV_MOHON' => $this->input->post('prov_mohon'),
				'KDPOS_MOHON' => $this->input->post('kdpos_mohon'),
				'TELP_MOHON' => $this->input->post('telp_mohon'),
				'HP_MOHON' => $this->input->post('hp_mohon'),
				'EMAIL_MOHON' => $this->input->post('email_mohon'),
				'IDENTITAS_MOHON' => $this->input->post('identitas_mohon'),
				'NO_IDENTITAS_MOHON' => $this->input->post('no_identitas_mohon'),
				'ASAL_MOHON' => $this->input->post('asal_mohon'),
				'PAKET_SAR' => $this->input->post('paket_sar'),
				'PERUNTUKAN' => '1',

				'NAMA_LANG' => $this->input->post('nama_lang'),
				'ALAMAT_LANG' => $this->input->post('alamat_lang'),
				'KEC_LANG' => $this->input->post('idkec_lang'),
				'KOTA_LANG' => $this->input->post('idkab_lang'),
				'PROV_LANG' => $this->input->post('idprov_lang'),
				'KDPOS_LANG' => $this->input->post('kdpos_lang'),
				'KD_WILAYAH' => $this->input->post('kd_wilayah'),
				'KD_AREA' => $this->input->post('kd_area'),

				'POLA_PEMBAYARAN' => '0',
				'TARIF_LAMA' => $this->input->post('tarif_baru'),
				'TARIF_BARU' => $this->input->post('tarif_baru'),
				'DAYA_LAMA' => $this->input->post('daya_baru'),
				'DAYA_BARU' => $this->input->post('daya_baru'),
				'KD_JAMNYALA_EMIN' => $this->input->post('jamnyala'),

				'KOGOL' => $this->input->post('kogol'),
				'KD_TG' => $TG,
				'KD_BK' => $this->input->post('kd_bk'),
				'KD_PPJ' => $this->input->post('kd_ppj'),
				'ID_LANG_TUJUAN_BAYAR' => (empty($this->input->post('id_lang_bayar'))) ? 0 : $this->input->post('id_lang_bayar'),
				'STATUS_MOHON' => '1',
				'STATUS_CREATE_ID' => 'YA',
				'JNS_TRANSAKSI' => 'BERHENTI LANGGANAN',
				'KD_BISNIS' => '0',
				'STATUS_PECAHAN' => 'TIDAK',
				'KD_MUT' => 'N',
				'TGL_UPDATE_MOHON' => $sekarang,
				'LAMA_MOHON' => "1"
			);
		$insert = $this->permohonanm->save('tp_agenda',$data);
		echo json_encode(array("status" => TRUE));
	}

	public function bongkar_update()
	{
		$data = array(
				'jns_transaksi' => 'BONGKAR'
			);
		$this->permohonanm->update('tp_agenda',array('id_cust' => $this->input->post('id_cust')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function survey(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['no_panel']=$this->permohonanm->by_panel();
			$this->load->view('pelayanan/survey',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cetaksurvey(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('pelayanan/cetaksurvey');
		}else{
			redirect('welcome/index');
		}
	}

	public function survey_update()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang 			= date('Y-m-d');
		$no_agenda 			= $this->input->post('no_agenda');
		$IL		 			= $this->input->post('id_lang');
		$TGL_MOHON 			= $this->input->post('tgl_mohon');
		$petugassurvey 		= $this->session->userdata('nama');
		$r 					= empty($this->input->post('rp_bp')) ? '0' : $this->input->post('rp_bpx');
		$rpkwhps 			= empty($this->input->post('rpkwh_ps')) ? '0' : $this->input->post('rpkwh_ps');
		$ujl 				= $this->input->post('ujl_tagihx');
		$RP 				= $r + $ujl + $rpkwhps;
		$data = array();
		if($RP > 1000000)
		{
			$MATERAI = 6000;
		}
		else if($RP > 250000)
		{
			$MATERAI = 3000;
		}
		else
		{
			$MATERAI = 0;
		}

		$RUPIAH = $RP + $MATERAI;
		$jns  = $this->input->post('jns_transaksi');
		$pola = $this->input->post('pola_bayar');
		$ujl  = $this->input->post('ujl_tagih');
		$area = $this->input->post('kd_area');
		$ppj = $this->input->post('ppj');
		$trx = $this->input->post('tarif_baru');

		$AGDKANAN = $this->db->query("SELECT RIGHT(NO_AGENDA,4) AS AGDKANAN  FROM tp_agenda WHERE NO_AGENDA = '$no_agenda' ")->row("AGDKANAN");
		$rand = rand(1, 9);
		$X = substr($no_agenda,5,3);

		$NO_BP = 'BP-'.$area.'-'.$X.'-'.$AGDKANAN;
		$NO_UJL = 'UJL-'.$area.'-'.$X.'-'.$AGDKANAN;
		$NO_SURVEY = 'SURVEY-'.$area.'-'.$X.'-'.$AGDKANAN;
		$LAMA_MOHON = sel_hari($TGL_MOHON,$sekarang)+1;
		$STATUS_MOHON = '3';

		$data = array_merge($data,array(
				'NO_SURVEY' => $NO_SURVEY,
				'SM_KE' => $this->input->post('sm_ke'),
				'TITIK_SM' => $this->input->post('titik_sm'),
				'PJG_SM' => $this->input->post('pjg_sm'),
				'JNS_SM' => $this->input->post('jns_sm'),
				'NO_PANEL' => $this->input->post('no_panel'),
				'KD_TRAFO_DIST' => $this->input->post('kd_trafo_dist'),
				'KD_GARDU' => $this->input->post('kd_gardu'),
				'KD_PENYULANG' => $this->input->post('kd_penyulang'),
				'KD_TRAFO_GI' => $this->input->post('kd_trafo_gi'),
				'KD_GI' => $this->input->post('kd_gi'),
				'MATERAI' => $MATERAI,
				'TOTAL_BIAYA' => $RUPIAH,
				'NO_BP' => $NO_BP,
				'TGL_BP' => $sekarang,
				'NO_UJL' => $NO_UJL,
				'TGL_UJL' => $sekarang,
				'PETUGAS_SURVEY' => $petugassurvey,
				'STATUS_MOHON' => $STATUS_MOHON,
				'LAMA_MOHON' => $LAMA_MOHON,

				'MERK_METER' => $this->input->post('merk_meter'),
				'NO_METER' => $this->input->post('no_meter'),
				'MERK_PEMBATAS' => $this->input->post('merk_pembatas'),
				'UKURAN_PEMBATAS' => $this->input->post('ukuran_pembatas'),
				'SETTING_PEMBATAS' => $this->input->post('setting_pembatas'),

				'TGL_ENTRI_SURVEY' => date('Y-m-d'),
				'TGL_UPDATE_MOHON' => date('Y-m-d H:i:s'),
				'TGL_CTK_SURVEY' => date('Y-m-d')
			));

		if($jns == 'PENERANGAN SEMENTARA')
		{
			$data['RP_BP'] = $r;
			$A =  $rpkwhps + $r;
			$RPBPJU_PS = $A * ROUND(($ppj/100),4);
			$data['RPBPJU_PS'] = $RPBPJU_PS;

			$data['TOTAL_BIAYA'] = $RUPIAH + $RPBPJU_PS;
		}
		else
		{
			$data['RP_BP'] = $r;
		}

		if($jns == 'BERHENTI LANGGANAN')
		{

		$q = $this->db->query("
								SELECT * FROM v_tr_tarif
								WHERE KD_TARIF = '$trx'
							");
		foreach ($q->result() as $r){
			$rplwbpx  = round($r->RP_LWBP,1);
			$rpwbpx   = round($r->RP_WBP,1);
			$rpkvarhx = round($r->RP_KVARH,1);
		}

		$q = $this->db->query("SELECT FK_METER, FRT,KD_PPJ FROM DIL_LISTRIK_NEW WHERE ID_LANG= '$IL' ");
		foreach ($q->result() as $r)
		{
			$FK_METER = $r->FK_METER;
			$FRT 	  = $r->FRT;
			$PPJDIL	  = $r->KD_PPJ;
		}
				$STAND_AKHIR_LWBP = $this->input->post('stand_akhir_lwbp');
				$STAND_AKHIR_WBP = $this->input->post('stand_akhir_wbp');
				$STAND_AKHIR_KVARH = $this->input->post('stand_akhir_kvarh');

				$STAND_BKR_LWBP = $this->input->post('stand_bkr_lwbp');
				$STAND_BKR_WBP = $this->input->post('stand_bkr_wbp');
				$STAND_BKR_KVARH = $this->input->post('stand_bkr_kvarh');

				$SISA_PEMKLWBP = round(($STAND_BKR_LWBP - $STAND_AKHIR_LWBP) * $FK_METER * $FRT,0);
				$SISA_PEMKWBP  = round(($STAND_BKR_WBP - $STAND_AKHIR_WBP) * $FK_METER * $FRT,0);
				$SISA_PEMKKVARH= round(($STAND_BKR_KVARH - $STAND_AKHIR_KVARH) * $FK_METER * $FRT,0);
				$SISA_KLBKVARHX = $SISA_PEMKKVARH - (($SISA_PEMKWBP + $SISA_PEMKLWBP) * 0.62);

				if($SISA_KLBKVARHX < 0)
				{
					$SISA_KLBKVARH = '0';
				}
				else
				{
					$SISA_KLBKVARH = $SISA_KLBKVARHX;
				}

				$SISA_RPLWBP  = Round($SISA_PEMKLWBP * $rplwbpx,0);
				$SISA_RPWBP   = Round($SISA_PEMKWBP * $rpwbpx,0);
				$SISA_RPKVARH = Round($SISA_PEMKKVARH * $rpkvarhx,0);
				$SISA_RPPTL   = $SISA_RPLWBP + $SISA_RPWBP + $SISA_RPKVARH;
				$SISA_RPBPJU  = ROUND($SISA_RPPTL * ROUND(($PPJDIL/100),4) ,0);
				if($SISA_RPPTL > 1000000){$SISA_MATERAI = 6000;}else if($SISA_RPPTL > 250000){$SISA_MATERAI = 3000;}else{$SISA_MATERAI = 0;};
				$SISA_RPTAG   = $SISA_RPPTL + $SISA_RPBPJU + $SISA_MATERAI;
				$SISA_KWHTOTAL= $SISA_PEMKLWBP + $SISA_PEMKWBP;

				#UNTUK PENYIMPANAN
				$data['STAND_BKR_LWBP'] = $STAND_BKR_LWBP;
				$data['STAND_BKR_WBP'] = $STAND_BKR_WBP;
				$data['STAND_BKR_KVARH'] = $STAND_BKR_KVARH;

				$data['SISA_PEMKLWBP'] = $SISA_PEMKLWBP;
				$data['SISA_PEMKWBP'] = $SISA_PEMKWBP;
				$data['SISA_PEMKKVARH'] = $SISA_PEMKKVARH;

				$data['SISA_KWHTOTAL'] = $SISA_KWHTOTAL;
				$data['SISA_KLBKVARH'] = $SISA_KLBKVARH;


				$data['SISA_RPLWBP'] = $SISA_RPLWBP;
				$data['SISA_RPWBP'] = $SISA_RPWBP;
				$data['SISA_RPKVARH'] = $SISA_RPKVARH;

				$data['SISA_RPPTL'] = $SISA_RPPTL;
				$data['SISA_RPBPJU'] = $SISA_RPBPJU;
				$data['SISA_METERAI'] = $SISA_MATERAI;
				$data['SISA_RPTAG'] = $SISA_RPTAG;
		}

		if($jns != 'PENERANGAN SEMENTARA'){
			if($pola == '1')
			{
				$this->permohonanm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
				$this->db->query("DELETE FROM tp_angsuran WHERE no_agenda='$no_agenda' ");
				$this->db->query("INSERT INTO tp_angsuran (NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL,RP_BK,RP_KWH,RP_P2TL,RP_INVESTASI,ID_LANG_TITIPAN,URAIAN,TGL_BUAT,USER_ENTRI_ANGSURAN)
									SELECT NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL_TAGIH,'0','0','0','0',ID_LANG_TUJUAN_BAYAR,'Pola Pembayaran = $pola','$sekarang','$petugassurvey'
									FROM tp_agenda WHERE no_agenda= '$no_agenda' ");
				if($jns == 'PASANG BARU'){
					$this->db->query("UPDATE TP_ANGSURAN SET ID_LANG = '$IL' WHERE no_agenda= '$no_agenda' ");
				}
			}
			elseif($pola == '2')
			{
				$this->permohonanm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
				$q = "SELECT LEFT(MAX(THBL_MOHON),4) TH, RIGHT(MAX(THBL_MOHON),2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
						$hasil = $this->db->query($q);
						foreach ($hasil->result() as $r)
						{
							$TH		= $r->TH;
							$BLN	= $r->BLN;
						}
						$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
				$this->db->query("DELETE FROM tp_angsuran WHERE no_agenda='$no_agenda' ");
				$this->db->query("INSERT INTO tp_angsuran (THBLREK,NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL,RP_BK,RP_KWH,RP_P2TL,RP_INVESTASI,ID_LANG_TITIPAN,URAIAN,TGL_BUAT,USER_ENTRI_ANGSURAN)
									SELECT '$plussatu', NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL_TAGIH,'0','0','0','0',ID_LANG_TUJUAN_BAYAR,'Pola Pembayaran = $pola','$sekarang','$petugassurvey'
									FROM tp_agenda WHERE no_agenda= '$no_agenda' ");
			}else{
				$this->permohonanm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
			}
		}
		else
		{
			if($pola == '2')
			{
				$this->permohonanm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
				$q = "SELECT LEFT(MAX(THBL_MOHON),4) TH, RIGHT(MAX(THBL_MOHON),2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
						$hasil = $this->db->query($q);
						foreach ($hasil->result() as $r)
						{
							$TH		= $r->TH;
							$BLN	= $r->BLN;
						}
						$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
				$this->db->query("DELETE FROM tp_angsuran WHERE no_agenda='$no_agenda' ");
				$this->db->query("INSERT INTO tp_angsuran (THBLREK,NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL,RP_BK,RP_KWH,RP_P2TL,RP_INVESTASI,ID_LANG_TITIPAN,URAIAN,TGL_BUAT,USER_ENTRI_ANGSURAN)
									SELECT '$plussatu', NO_AGENDA,ID_CUST,ID_LANG_TUJUAN_BAYAR,'0','0','0',TOTAL_BIAYA,'0','0',ID_LANG_TUJUAN_BAYAR,'Pola Pembayaran = $pola','$sekarang','$petugassurvey'
									FROM tp_agenda WHERE no_agenda= '$no_agenda' ");
			}else{
				$this->permohonanm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
			}
		}

		echo json_encode(array("status" => TRUE));
	}

	public function pdl(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$datax['tgl_pdl']=date("Y-m-d H:i:s");
			$this->load->view('pelayanan/pdl',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function pdl_update()
	{
		$user = $this->session->userdata('nama');
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
			$hasil = $this->db->query($q);
			foreach ($hasil->result() as $r)
			{
				$TH		= $r->TH;
				$BLN	= $r->BLN;
			}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		$AGD = $this->input->post('no_agenda');
		$JNS = $this->input->post('jns_transaksi');
		$data = array();

		if($JNS != 'PENERANGAN SEMENTARA'){
			$TGL_BKR_STAND = $this->input->post('tgl_mut');
			$TGL_PSG_STAND = $this->input->post('tgl_mut');
		}else{
			$TGL_PSG_STAND = $this->input->post('tgl_psg_ps');
			$TGL_BKR_STAND = $this->input->post('tgl_bkr_ps');
		}

		$data = array_merge($data,array(
				'NO_PDL' => $this->input->post('no_pdl'),
				'TGL_PDL' => $this->input->post('tgl_pdl'),
				'TGL_MUT' => $this->input->post('tgl_mut'),
				'THBLMUT' => $plussatu,

				'ID_LANG' => $this->input->post('id_lang'),
				'NAMA_LANG' => $this->input->post('nama_lang'),
				'ALAMAT_LANG' => $this->input->post('alamat_lang'),
				'KDPOS_LANG' => $this->input->post('kdpos_lang'),
				'KD_WILAYAH' => $this->input->post('kd_wilayah'),
				'KD_AREA' => $this->input->post('kd_area'),

				'TARIF_LAMA' => $this->input->post('tarif_lama'),
				'DAYA_LAMA' => $this->input->post('daya_lama'),
				'TARIF_BARU' => $this->input->post('tarif_baru'),
				'DAYA_BARU' => $this->input->post('daya_baru'),

				'NO_BP' => $this->input->post('no_bp'),
				'TGL_BP' => $this->input->post('tgl_bp'),
				'RP_BP' => $this->input->post('rp_bp'),
				'RP_SEWA_TRAFO' => $this->input->post('rp_sewa_trafo'),

				'NO_UJL' => $this->input->post('no_ujl'),
				'TGL_UJL' => $this->input->post('tgl_ujl'),
				'RP_UJL_LAMA' => $this->input->post('rp_ujl_lama'),
				'RP_UJL_BARU' => $this->input->post('rp_ujl_baru'),
				'RP_UJL_TAGIH' => $this->input->post('rp_ujl_tagih'),

				'TGL_NYALA' => $this->input->post('tgl_nyala'),
				'TGL_PSG_METER' => $this->input->post('tgl_psg_meter'),
				'MERK_METER' => $this->input->post('merk_meter'),
				'TIPE_METER' => $this->input->post('tipe_meter'),
				'NO_METER' => $this->input->post('no_meter'),
				'FASA_METER' => $this->input->post('fasa_meter'),
				'THN_PROD_METER' => $this->input->post('thn_prod_meter'),
				'THN_TERA_METER' => $this->input->post('thn_tera_meter'),

				'TGL_PSG_PEMBATAS' => $this->input->post('tgl_psg_pembatas'),
				'MERK_PEMBATAS' => $this->input->post('merk_pembatas'),
				'TIPE_PEMBATAS' => $this->input->post('tipe_pembatas'),
				'UKURAN_PEMBATAS' => $this->input->post('ukuran_pembatas'),
				'SETTING_PEMBATAS' => $this->input->post('setting_pembatas'),
				'FASA_PEMBATAS' => $this->input->post('fasa_pembatas'),
				'TEG_PEMBATAS' => $this->input->post('teg_pembatas'),

				'TGL_PSG_CT' => $this->input->post('tgl_psg_ct'),
				'TGL_PSG_PT' => $this->input->post('tgl_psg_pt'),
				'I_PRIMER_CT' => $this->input->post('i_primer_ct'),
				'I_SEKUNDER_CT' => $this->input->post('i_sekunder_ct'),
				'V_PRIMER_PT' => $this->input->post('v_primer_pt'),
				'V_SEKUNDER_PT' => $this->input->post('v_sekunder_pt'),

				'TGL_BKR_STAND' => $TGL_BKR_STAND,
				'STAND_BKR_LWBP' => $this->input->post('stand_bkr_lwbp'),
				'STAND_BKR_WBP' => $this->input->post('stand_bkr_wbp'),
				'STAND_BKR_KVARH' => $this->input->post('stand_bkr_kvarh'),
				'TGL_PSG_STAND' => $TGL_PSG_STAND,
				'STAND_PSG_LWBP' => $this->input->post('stand_psg_lwbp'),
				'STAND_PSG_WBP' => $this->input->post('stand_psg_wbp'),
				'STAND_PSG_KVARH' => $this->input->post('stand_psg_kvarh'),

				'FK_METER' => $this->input->post('fk_meter'),
				'FRT' => $this->input->post('frt'),
				'KOORDINATX' => $this->input->post('koordinatx'),
				'KOORDINATY' => $this->input->post('koordinaty'),

				'KD_TRAFO_DIST' => $this->input->post('kd_trafo_dist'),
				'KD_GARDU' => $this->input->post('kd_gardu'),
				'KD_PENYULANG' => $this->input->post('kd_penyulang'),
				'KD_TRAFO_GI' => $this->input->post('kd_trafo_gi'),
				'KD_GI' => $this->input->post('kd_gi'),
				'JNS_SM' => $this->input->post('jns_sm'),
				'PJG_SM' => $this->input->post('pjg_sm'),
				'TEG_SAMBUNG' => $this->input->post('teg_sambung'),

				'USER_ENTRI_PDL' => $user,
				'STATUS_MOHON' => '7'
		));
		$this->permohonanm->update('tp_agenda',array('NO_AGENDA' => $this->input->post('no_agenda')), $data);

		$cekangs = $this->db->query("SELECT NO_AGENDA FROM TP_ANGSURAN WHERE NO_AGENDA= '$AGD' AND URAIAN = 'Pola Pembayaran = 1' ");
		if($cekangs->num_rows() > 0 ){
			$q = "SELECT LEFT(MAX(THBL_MOHON),4) TH, RIGHT(MAX(THBL_MOHON),2) BLN FROM TP_AGENDA LIMIT 1";
						$hasil = $this->db->query($q);
						foreach ($hasil->result() as $r)
						{
							$TH		= $r->TH;
							$BLN	= $r->BLN;
						}
						$plussatuagd = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));

			$this->db->query("UPDATE TP_ANGSURAN SET THBLREK = '$plussatuagd' WHERE NO_AGENDA = '$AGD' AND URAIAN = 'Pola Pembayaran = 1' ");
		}

		echo json_encode(array("status" => TRUE));
	}

	public function pdl_nonmohon(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$datax['jns_transaksi']=$this->permohonanm->by_jns_transaksi_nonmohon();
			$datax['no_panel']=$this->permohonanm->by_panel();
			$this->load->view('pelayanan/pdl_nonmohon',$datax);
		}else{
			redirect('welcome/index');
		}
	}

public function pdl_add()
	{
		$sekarang = date("Y-m-d H:i:s");
		$user = $this->session->userdata('nama');
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
			$hasil = $this->db->query($q);
			foreach ($hasil->result() as $r)
			{
				$TH		= $r->TH;
				$BLN	= $r->BLN;
			}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		$THBL_MOHON = $this->db->query("SELECT DATE_FORMAT(NOW(),'%Y%m') THBL_MOHON ")->row("THBL_MOHON");

		$AGD = $this->input->post('no_agenda');
		$JNS = $this->input->post('jns_transaksi');
		$data = array();

		if($JNS != 'PENERANGAN SEMENTARA'){
			$TGL_BKR_STAND = $this->input->post('tgl_mut');
			$TGL_PSG_STAND = $this->input->post('tgl_mut');
		}else{
			$TGL_PSG_STAND = $this->input->post('tgl_psg_ps');
			$TGL_BKR_STAND = $this->input->post('tgl_bkr_ps');
		}

		if($JNS == 'BONGKAR RAMPUNG'){
			$KD_MUT = 'N';
		}else{
			$KD_MUT = 'J';
		}
		$ILANG = $this->input->post('id_lang');
		$NPDL = $this->input->post('no_pdl');
		$this->db->query("DELETE FROM TP_AGENDA WHERE CONCAT(NO_AGENDA,ID_LANG,NO_PDL) = CONCAT('NONAGENDA','$ILANG','$NPDL') ");
		$data = array_merge($data,array(
				'NO_AGENDA' => 'NONAGENDA',
				'NO_REG' => '0',
				'TGL_MOHON' => $sekarang,
				'THBL_MOHON' => $THBL_MOHON,

				'NO_PDL' => $this->input->post('no_pdl'),
				'TGL_PDL' => $this->input->post('tgl_pdl'),
				'TGL_MUT' => $this->input->post('tgl_mut'),
				'THBLMUT' => $plussatu,
				'JNS_TRANSAKSI' => $JNS,

				'ID_CUST' => $this->input->post('id_cust'),
				'ID_LANG' => $this->input->post('id_lang'),
				'NAMA_LANG' => $this->input->post('nama_lang'),
				'ALAMAT_LANG' => $this->input->post('alamat_lang'),
				'KEC_LANG' => $this->input->post('idkec_lang'),
				'KOTA_LANG' => $this->input->post('idkota_lang'),
				'PROV_LANG' => $this->input->post('idprov_lang'),
				'KDPOS_LANG' => $this->input->post('kdpos_lang'),
				'KD_WILAYAH' => $this->input->post('kd_wilayah'),
				'KD_AREA' => $this->input->post('kd_area'),

				'TARIF_LAMA' => $this->input->post('tarif_lama'),
				'DAYA_LAMA' => $this->input->post('daya_lama'),
				'TARIF_BARU' => $this->input->post('tarif_baru'),
				'DAYA_BARU' => $this->input->post('daya_baru'),

				'NO_BP' => $this->input->post('no_bp'),
				'TGL_BP' => $this->input->post('tgl_bp'),
				'RP_BP' => $this->input->post('rp_bp'),
				'RP_SEWA_TRAFO' => $this->input->post('rp_sewa_trafo'),

				'NO_UJL' => $this->input->post('no_ujl'),
				'TGL_UJL' => $this->input->post('tgl_ujl'),
				'RP_UJL_LAMA' => $this->input->post('rp_ujl_lama'),
				'RP_UJL_BARU' => $this->input->post('rp_ujl_baru'),
				'RP_UJL_TAGIH' => $this->input->post('rp_ujl_tagih'),

				'TGL_NYALA' => $this->input->post('tgl_nyala'),
				'TGL_PSG_METER' => $this->input->post('tgl_psg_meter'),
				'MERK_METER' => $this->input->post('merk_meter'),
				'TIPE_METER' => $this->input->post('tipe_meter'),
				'NO_METER' => $this->input->post('no_meter'),
				'FASA_METER' => $this->input->post('fasa_meter'),
				'THN_PROD_METER' => $this->input->post('thn_prod_meter'),
				'THN_TERA_METER' => $this->input->post('thn_tera_meter'),

				'TGL_PSG_PEMBATAS' => $this->input->post('tgl_psg_pembatas'),
				'MERK_PEMBATAS' => $this->input->post('merk_pembatas'),
				'TIPE_PEMBATAS' => $this->input->post('tipe_pembatas'),
				'UKURAN_PEMBATAS' => $this->input->post('ukuran_pembatas'),
				'SETTING_PEMBATAS' => $this->input->post('setting_pembatas'),
				'FASA_PEMBATAS' => $this->input->post('fasa_pembatas'),
				'TEG_PEMBATAS' => $this->input->post('teg_pembatas'),

				'TGL_PSG_CT' => $this->input->post('tgl_psg_ct'),
				'TGL_PSG_PT' => $this->input->post('tgl_psg_pt'),
				'I_PRIMER_CT' => $this->input->post('i_primer_ct'),
				'I_SEKUNDER_CT' => $this->input->post('i_sekunder_ct'),
				'V_PRIMER_PT' => $this->input->post('v_primer_pt'),
				'V_SEKUNDER_PT' => $this->input->post('v_sekunder_pt'),

				'TGL_BKR_STAND' => $TGL_BKR_STAND,
				'STAND_BKR_LWBP' => $this->input->post('stand_bkr_lwbp'),
				'STAND_BKR_WBP' => $this->input->post('stand_bkr_wbp'),
				'STAND_BKR_KVARH' => $this->input->post('stand_bkr_kvarh'),
				'TGL_PSG_STAND' => $TGL_PSG_STAND,
				'STAND_PSG_LWBP' => $this->input->post('stand_psg_lwbp'),
				'STAND_PSG_WBP' => $this->input->post('stand_psg_wbp'),
				'STAND_PSG_KVARH' => $this->input->post('stand_psg_kvarh'),

				'FK_METER' => $this->input->post('fk_meter'),
				'FRT' => $this->input->post('frt'),
				'KOORDINATX' => $this->input->post('koordinatx'),
				'KOORDINATY' => $this->input->post('koordinaty'),

				'NO_PANEL' => $this->input->post('no_panel'),
				'KD_TRAFO_DIST' => $this->input->post('kd_trafo_dist'),
				'KD_GARDU' => $this->input->post('kd_gardu'),
				'KD_PENYULANG' => $this->input->post('kd_penyulang'),
				'KD_TRAFO_GI' => $this->input->post('kd_trafo_gi'),
				'KD_GI' => $this->input->post('kd_gi'),
				'JNS_SM' => $this->input->post('jns_sm'),
				'PJG_SM' => $this->input->post('pjg_sm'),
				'TEG_SAMBUNG' => $this->input->post('teg_sambung'),
				'FASA_SM' => $this->input->post('fasa_sm'),

				'PERUNTUKAN' => $this->input->post('peruntukan'),
				'KOGOL' => $this->input->post('kogol'),
				'KD_PPJ' => $this->input->post('kd_ppj'),
				'KD_JAMNYALA_EMIN' => $this->input->post('kd_jamnyala_emin'),
				'KD_TG' => $this->input->post('kd_tg'),
				'KD_BK' => $this->input->post('kd_bk'),
				'STATUS_PECAHAN' => $this->input->post('status_pecahan'),
				'SM_KE' => $this->input->post('sm_ke'),
				'TITIK_SM' => $this->input->post('titik_sm'),
				'KD_BISNIS' => '0',
				'PAKET_SAR' => $this->input->post('paket_sar'),
				'KD_MUT' => $KD_MUT,

				'USER_ENTRI_PDL' => $user,
				'STATUS_MOHON' => '7'
		));
		$this->permohonanm->save('tp_agenda',$data);

		$cekangs = $this->db->query("SELECT NO_AGENDA FROM TP_ANGSURAN WHERE NO_AGENDA= '$AGD' AND URAIAN = 'Pola Pembayaran = 1' ");
		if($cekangs->num_rows() > 0 ){
			$q = "SELECT LEFT(MAX(THBL_MOHON),4) TH, RIGHT(MAX(THBL_MOHON),2) BLN FROM TP_AGENDA LIMIT 1";
						$hasil = $this->db->query($q);
						foreach ($hasil->result() as $r)
						{
							$TH		= $r->TH;
							$BLN	= $r->BLN;
						}
						$plussatuagd = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));

			$this->db->query("UPDATE TP_ANGSURAN SET THBLREK = '$plussatuagd' WHERE NO_AGENDA = '$AGD' AND URAIAN = 'Pola Pembayaran = 1' ");
		}

		echo json_encode(array("status" => TRUE));
	}

	public function cetakjanjiteknis(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['prev']=$this->permohonanm->by_noagenda();
			$datax['area']=$this->permohonanm->by_area();
			$datax['bisnis']=$this->permohonanm->by_bisnis();
			$this->load->view('pelayanan/cetakjanjiteknis',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cetakulangpermohonan(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('pelayanan/cetakulangpermohonan');
		}else{
			redirect('welcome/index');
		}
	}

	public function cetaksipb(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('pelayanan/cetaksipb');
		}else{
			redirect('welcome/index');
		}
	}

	public function cetakpkdanba(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['nama_pejabat']= $this->permohonanm->get_nama_pejabat($kondisi='WHERE ID !=6');
			$this->load->view('pelayanan/cetakpkdanba',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cetakberitaacara(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['nama_pejabat']= $this->permohonanm->get_nama_pejabat($kondisi='WHERE ID !=6');
			$this->load->view('pelayanan/cetakberitaacara',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function get_jabatan($id){
		$data_id = $this->permohonanm->get_jabatan($id);
		echo json_encode($data_id);
	}

	function get_thblrek(){
		$sql = "SELECT MAX(THBLREK) THBLREK, LEFT(MAX(THBLREK),4) TH, RIGHT(MAX(THBLREK),2) BLN, '30' TGL FROM dil_listrik_new";
                $hasil = $this->db->query($sql);
                $lcno = 0;
                foreach ($hasil->result() as $r)
                {
                    $THBLREK= $r->THBLREK;
                    $TH		= $r->TH;
                    $BLN	= $r->BLN;
					$TGL	= $r->TGL;
				}
		$T = date("Ym", mktime(0,0,0,$BLN, $TGL, $TH));
		return $T;
	}

	public function uploaddilbaru(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('pelayanan/uploaddilbaru',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cutoffdil(){
		$sekarang = date('Y-m-d');
		$user = $this->session->userdata('nama');
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
					$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		$this->db->query("TRUNCATE DIL_LISTRIK_NEW");
		#MASUKAN DATA DARI DIL REF KE DIL NEW
		$this->db->query("INSERT INTO DIL_LISTRIK_NEW (THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,
							TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,
							MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,
							TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,
							FK_METER,FRT,KOORDINATX,KOORDINATY,USER_PDL,NOPEL,IDPEL_PLN,STATUS_PECAHAN)
						SELECT THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,
							TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,
							MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,
							TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,
							FK_METER,FRT,KOORDINATX,KOORDINATY,USER_PDL,NOPEL,IDPEL_PLN,'TIDAK'
						FROM DIL_LISTRIK_REF ");

		#MASUKAN DATA DARI AGENDA KE DIL NEW
		$this->db->query("ALTER TABLE DIL_LISTRIK_NEW AUTO_INCREMENT = 1");

		#KD MU A
		$this->db->query("INSERT INTO DIL_LISTRIK_NEW (THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,
								KD_MUT,TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,
								TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,
								FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,
								STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_PDL,NOPEL,IDPEL_PLN)
							SELECT THBL_MOHON THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF_BARU TARIF,DAYA_BARU DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,
								TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL_BARU RP_UJL,NO_KWITANSI,NO_PANEL, CONCAT(KD_TRAFO_DIST,KD_GARDU) KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,
								JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,
								UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,
								STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_ENTRI_PDL USER_ENTRI,NOPEL,IDPEL_PLN
							FROM TP_AGENDA WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND KD_MUT = 'A' AND THBLMUT = '$plussatu' ");

		#KD MUT B
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.NAMA_LANG = b.NAMA_LANG, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT , a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'B' AND b.THBLMUT = '$plussatu' ");

		#KD MUT C
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.ALAMAT_LANG = b.ALAMAT_LANG, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'C' AND b.THBLMUT = '$plussatu' ");

		#KD MUT D
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.TARIF = b.TARIF_BARU, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT ='D' AND b.THBLMUT = '$plussatu' ");

		#KD MUT E
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET
								a.DAYA = b.DAYA_BARU, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN,
								a.NO_KWITANSI = b.NO_KWITANSI, a.TGL_PDL = b.TGL_PDL,
								a.TGL_BP = b.TGL_BP, a.RP_BP = b.RP_BP, a.TGL_UJL = b.TGL_UJL, a.RP_UJL = (a.RP_UJL + b.RP_UJL_TAGIH),
								a.NO_PANEL = b.NO_PANEL, a.KD_GT = CONCAT(b.KD_TRAFO_DIST,b.KD_GARDU), a.KD_PENYULANG = b.KD_PENYULANG, a.KD_TRAFO_GI = b.KD_TRAFO_GI,
								a.KD_GI = b.KD_GI, a.JNS_SM = b.JNS_SM, a.PJG_SM = b.PJG_SM, a.SM_KE = b.SM_KE, a.TITIK_SM = b.TITIK_SM,
								a.NO_METER = b.NO_METER, a.TIPE_METER = b.TIPE_METER, a.MERK_METER = b.MERK_METER, a.TGL_PSG_METER = b.TGL_PSG_METER, a.THN_PROD_METER = b.THN_PROD_METER,
								a.THN_TERA_METER = b.THN_TERA_METER, a.FASA_METER=b.FASA_METER,  a.MERK_PEMBATAS=b.MERK_PEMBATAS,
								a.TIPE_PEMBATAS=b.TIPE_PEMBATAS, a.UKURAN_PEMBATAS=b.UKURAN_PEMBATAS, a.SETTING_PEMBATAS=b.SETTING_PEMBATAS, a.FASA_PEMBATAS=b.FASA_PEMBATAS, a.TEG_PEMBATAS=b.TEG_PEMBATAS,
								a.TGL_PSG_CT=b.TGL_PSG_CT, a.TGL_PSG_PT=b.TGL_PSG_PT, a.I_PRIMER_CT=b.I_PRIMER_CT, a.I_SEKUNDER_CT=b.I_SEKUNDER_CT, a.V_PRIMER_PT=b.V_PRIMER_PT, a.V_SEKUNDER_PT=b.V_SEKUNDER_PT,
								a.FK_METER=b.FK_METER, a.FRT=b.FRT,
								a.STAND_BKR_LWBP=b.STAND_BKR_LWBP, a.STAND_BKR_WBP=b.STAND_BKR_WBP, a.STAND_BKR_KVARH=b.STAND_BKR_KVARH,
								a.STAND_PSG_LWBP=b.STAND_PSG_LWBP, a.STAND_PSG_WBP=b.STAND_PSG_WBP, a.STAND_PSG_KVARH=b.STAND_PSG_KVARH
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'E' AND b.THBLMUT = '$plussatu' ");

		#KD MUT F
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.RP_BP = b.RP_BP, a.TGL_BP = b.TGL_BP, a.RP_UJL = b.RP_UJL_BARU, a.TGL_UJL = b.TGL_UJL, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'F' AND b.THBLMUT = '$plussatu' ");
		#KD MUT J
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET
								a.NO_METER = b.NO_METER, a.TIPE_METER = b.TIPE_METER, a.MERK_METER = b.MERK_METER,
								a.TGL_PSG_METER = b.TGL_PSG_METER, a.THN_PROD_METER = b.THN_PROD_METER,
								a.THN_TERA_METER = b.THN_TERA_METER, a.FASA_METER=b.FASA_METER,  a.MERK_PEMBATAS=b.MERK_PEMBATAS,
								a.TIPE_PEMBATAS=b.TIPE_PEMBATAS, a.UKURAN_PEMBATAS=b.UKURAN_PEMBATAS, a.SETTING_PEMBATAS=b.SETTING_PEMBATAS, a.FASA_PEMBATAS=b.FASA_PEMBATAS, a.TEG_PEMBATAS=b.TEG_PEMBATAS,
								a.TGL_PSG_CT=b.TGL_PSG_CT, a.TGL_PSG_PT=b.TGL_PSG_PT, a.I_PRIMER_CT=b.I_PRIMER_CT, a.I_SEKUNDER_CT=b.I_SEKUNDER_CT, a.V_PRIMER_PT=b.V_PRIMER_PT, a.V_SEKUNDER_PT=b.V_SEKUNDER_PT,
								a.FK_METER=b.FK_METER, a.FRT=b.FRT,
								a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN,
								a.STAND_BKR_LWBP=b.STAND_BKR_LWBP, a.STAND_BKR_WBP=b.STAND_BKR_WBP, a.STAND_BKR_KVARH=b.STAND_BKR_KVARH,
								a.STAND_PSG_LWBP=b.STAND_PSG_LWBP, a.STAND_PSG_WBP=b.STAND_PSG_WBP, a.STAND_PSG_KVARH=b.STAND_PSG_KVARH
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'J' AND b.THBLMUT = '$plussatu' ");

		#KD MUT K
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.FK_METER = b.FK_METER, a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'K' AND b.THBLMUT = '$plussatu' ");

		#KD MUT L
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET a.NO_PANEL=b.NO_PANEL, a.KD_GT = CONCAT(b.KD_TRAFO_DIST,KD_GARDU),a.KD_PENYULANG=b.KD_PENYULANG,
								a.KD_TRAFO_GI=b.KD_TRAFO_GI, a.KD_GI=b.KD_GI,a.JNS_SM=b.JNS_SM, a.PJG_SM=b.PJG_SM, a.FASA_SM=b.FASA_SM, a.TEG_SAMBUNG=b.TEG_SAMBUNG,  a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT, a.STATUS_PECAHAN=b.STATUS_PECAHAN
								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'L' AND b.THBLMUT = '$plussatu' ");

		#KD MUT N
		$this->db->query("UPDATE DIL_LISTRIK_NEW a
								LEFT JOIN TP_AGENDA b
								ON a.ID_LANG = b.ID_LANG
								SET
								a.THBLMUT=b.THBLMUT, a.KD_MUT=b.KD_MUT, a.TGL_MUT=b.TGL_MUT ,a.STATUS_PECAHAN=b.STATUS_PECAHAN

								WHERE (NO_PDL != '' OR NO_PDL IS NOT NULL) AND b.KD_MUT = 'N' AND b.THBLMUT = '$plussatu' ");


		$this->db->query("UPDATE DIL_LISTRIK_NEW SET THBLREK = '$plussatu' ");

		$this->session->set_flashdata('msg','Berhasil Melakukan Upload DIL');
	}

	public function dilnew_list()
	{
		$list = $this->permohonanm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBLREK;
			$row[] = $pelayanan->ID_LANG;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->ALAMAT_LANG;
			$row[] = $pelayanan->nama_kab;
			$row[] = $pelayanan->nama_prov;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all(),
						"recordsFiltered" => $this->permohonanm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function pembatalan(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('pelayanan/pembatalan',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function pembatalanpermohonan($no_agenda){
		$nps = $this->db->query("UPDATE tp_agenda SET STATUS_MOHON = '0' WHERE no_agenda='$no_agenda' ");
		echo json_encode(array("status" => TRUE));
	}

	public function monitoringpelayanan(){
		if($this->session->userdata('nama')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();

			$datax['rekapmohon'] = $this->permohonanm->rekapmohon_list();
			$template = array(
					'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

					'thead_open'            => '<thead>',
					'thead_close'           => '</thead>',

					'heading_row_start'     => '<tr>',
					'heading_row_end'       => '</tr>',
					'heading_cell_start'    => '<th>',
					'heading_cell_end'      => '</th>',

					'tbody_open'            => '<tbody>',
					'tbody_close'           => '</tbody>',

					'row_start'             => '<tr>',
					'row_end'               => '</tr>',
					'cell_start'            => '<td>',
					'cell_end'              => '</td>',

					'row_alt_start'         => '<tr>',
					'row_alt_end'           => '</tr>',
					'cell_alt_start'        => '<td>',
					'cell_alt_end'          => '</td>',

					'table_close'           => '</table></div>'
			);
			$this->table->set_template($template);
			$header = array('THBLMOHON', 'JENIS TRANSAKSI', 'JML MOHON', 'SUDAH SURVEY','SUDAH SIP','SUDAH BAYAR','SUDAH PK BA','SUDAH PDL','BATAL');
			$this->table->set_heading($header);

			$this->load->view('pelayanan/monitoringpelayanan',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function detsurvey_list()
	{
		$list = $this->permohonanm->get_datatables_detsurvey();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = '<a href="javascript:void(0)" title="Edit" onclick="cetak_survey('."'".$pelayanan->NO_AGENDA."'".',1)">'.$pelayanan->NO_AGENDA.'</a>';
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_CTK_SURVEY;
			$row[] = $pelayanan->TGL_MOHON;

			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detsurvey(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detsurvey(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detsip_list()
	{
		$list = $this->permohonanm->get_datatables_detsip();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_ENTRI_SURVEY;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detsip(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detsip(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detbayar_list()
	{
		$list = $this->permohonanm->get_datatables_detbayar();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_CETAKSIP;
			$row[] = number_format($pelayanan->TOTAL_BIAYA);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detbayar(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detbayar(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detpk_list()
	{
		$list = $this->permohonanm->get_datatables_detpk();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_BAYAR;
			$row[] = $pelayanan->POLA;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detpk(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detpk(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detpdl_list()
	{
		$list = $this->permohonanm->get_datatables_detpdl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_CTK_PK;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detpdl(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detpdl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detsudahpdl_list()
	{
		$list = $this->permohonanm->get_datatables_detsudahpdl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->THBLMUT;
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->ID_CUST;
			$row[] = $pelayanan->NAMA_MOHON;
			$row[] = $pelayanan->ID_LANG;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->STATUS_MOHON;
			$row[] = $pelayanan->TGL_PDL;
			$row[] = $pelayanan->NO_PDL;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detsudahpdl(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detsudahpdl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapsudahpdl_list()
	{
		$list = $this->permohonanm->get_datatables_rekapsudahpdl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->THBL_MOHON;
			$row[] = $pelayanan->THBLMUT;
			$row[] = $pelayanan->JNS_TRANSAKSI;
			$row[] = $pelayanan->JML;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_rekapsudahpdl(),
						"recordsFiltered" => $this->permohonanm->count_filtered_rekapsudahpdl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detps_list()
	{
		$list = $this->permohonanm->get_datatables_detps();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $pelayanan) {
			$no++;
			$row = array();
			$row[] = $pelayanan->NO_AGENDA;
			$row[] = $pelayanan->NAMA_LANG;
			$row[] = $pelayanan->Tgl_Mohon;
			$row[] = $pelayanan->Tgl_Awal;
			$row[] = $pelayanan->Tgl_Akhir;
			$row[] = $pelayanan->Tgl_Bayar;
			$row[] = $pelayanan->Tgl_Nyala;
			$row[] = $pelayanan->Tgl_Bongkar;
			$row[] = $pelayanan->status_mohon;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->permohonanm->count_all_detps(),
						"recordsFiltered" => $this->permohonanm->count_filtered_detps(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function cari_pdl_mon($idcari=''){
		$data_all = $this->permohonanm->get_pdl_mon($idcari);
		echo json_encode($data_all);
	}

	public function cari_pdl_nonmohon($idcari=''){
		$data_all = $this->permohonanm->get_pdl_nonmohon($idcari);
		echo json_encode($data_all);
	}

	public function cari_nopdl_nonmohon($idcari='',$idcari2=''){
		$data_all = $this->permohonanm->get_nopdl_nonmohon($idcari,$idcari2);
		echo json_encode($data_all);
	}

	function tes_mail($subject='TES EMAIL',$to='ilham.dwika.arditya@gmail.com',$attach='https://www.codeigniter.com/user_guide/_static/ci-icon.ico',$message='TES EMAIL INI YA'){
		$this->load->model("mailm");
		$this->mailm->send_mail($subject,$to,$attach,$message);
	}

}
