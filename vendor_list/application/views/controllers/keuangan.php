<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keuangan extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('keuanganm');
		$this->load->model('infom');
		date_default_timezone_set('Asia/Jakarta');
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

	public function pelunasan(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('keuangan/pelunasan',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function pelunasan_update()
	{
		$sekarang = date('Y-m-d H:i:s');
		$user = $this->session->userdata('ket');
		$NO_AGENDA = $this->input->post("no_agenda");
		$JNS_TRANSAKSI = $this->input->post("jns_transaksi");
		$JNS_PELUNASAN = $this->input->post("jns_pelunasan");
		$IL = $this->input->post("id_lang");
		$data = array(
			'TGL_BAYAR' => $sekarang,
			'JNS_PELUNASAN' => $JNS_PELUNASAN,
			'LOKET_BAYAR' => 'EPI',
			'PETUGAS_LUNAS' => $user,
			'NO_KWITANSI' => $this->input->post("no_kwitansi"),
			'STATUS_MOHON' => '5'
		);
		$area = $this->db->query("SELECT kd_area FROM TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' ")->row("kd_area");

		$query = $this->db->query("SELECT LPAD(MAX(SUBSTRING(ID_LANG,7,5))+1,5,'00000') AS ID_LANG FROM
									(SELECT id_lang FROM tp_agenda
									UNION ALL
									SELECT id_lang FROM dil_listrik_ref) a")->row("ID_LANG");

		$rand = rand(1, 9);
		$IDLANG = $area.'0'.$query.$rand;

		if($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
			$data['ID_LANG'] = '0';
		}else{
			if($IL == '0' OR $IL == '' OR $IL == NULL){
				$data['ID_LANG'] = $IDLANG;
			}
		}

		$this->keuanganm->update('tp_agenda',array('no_agenda' => $this->input->post('no_agenda')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function pelunasanrek(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('keuangan/pelunasanrek',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function pelunasanrek_update()
	{
		$sekarang = date('Y-m-d H:i:s');
		$user = $this->session->userdata('ket');
		$ID_LANG = $this->input->post("id_lang");

		$this->db->query("INSERT INTO WS_DPP (ID_LANG,THBLREK,TGL_LUNAS,USER_LUNAS,LOKET,STATUS,EPIREFNO)
							SELECT ID_LANG,THBLREK,'$sekarang','$user','EPI','1',EPIREFNO
							FROM MASTER_REKENING WHERE ID_LANG='$ID_LANG' AND STATUS_LUNAS='0' ");

		$data = array(
			'STATUS_LUNAS' => '1',
			'TGL_LUNAS' => $sekarang,
			'USER_LUNAS' => $user
		);
		$this->keuanganm->update('master_rekening',array('id_lang' => $this->input->post('id_lang'),'status_lunas' => '0'), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function pelunasanrekbycust_update()
	{
		$sekarang = date('Y-m-d H:i:s');
		$user = $this->session->userdata('ket');
		$ID_CUST = $this->input->post("id_cust");

		$this->db->query("INSERT INTO WS_DPP (ID_LANG,THBLREK,TGL_LUNAS,USER_LUNAS,LOKET,STATUS,EPIREFNO)
							SELECT ID_LANG,THBLREK,'$sekarang','$user','EPI','1',EPIREFNO
							FROM MASTER_REKENING WHERE ID_CUST='$ID_CUST' AND STATUS_LUNAS='0' ");

		$data = array(
			'STATUS_LUNAS' => '1',
			'TGL_LUNAS' => $sekarang,
			'USER_LUNAS' => $user
		);
		$this->keuanganm->update('master_rekening',array('id_cust' => $this->input->post('id_cust'),'status_lunas' => '0'), $data);

		echo json_encode(array("status" => TRUE));
	}

	public function pelunasanrekbycustselect_update($pilihan='')
	{
		$sekarang = date('Y-m-d H:i:s');
		$user = $this->session->userdata('ket');
		$ID_CUST = $this->input->post("id_custselect");

		$this->db->query("INSERT INTO WS_DPP (ID_LANG,THBLREK,TGL_LUNAS,USER_LUNAS,LOKET,STATUS,EPIREFNO)
							SELECT ID_LANG,THBLREK,'$sekarang','$user','EPI','1',EPIREFNO
							FROM MASTER_REKENING WHERE CONCAT(THBLREK,ID_CUST) = '$pilihan' ");

		$data = array(
			'STATUS_LUNAS' => '1',
			'TGL_LUNAS' => $sekarang,
			'USER_LUNAS' => $user
		);
		$this->keuanganm->update('master_rekening',array('CONCAT(THBLREK,ID_CUST)' => $pilihan,'status_lunas' => '0'), $data);


		echo json_encode(array("status" => TRUE));
	}

	public function caripelunasan($idcari=''){
		$data_lunas = $this->keuanganm->get_pelunasan($idcari);
		echo json_encode($data_lunas);
	}

	public function caritarif($idcari=''){
		$data_lunas = $this->keuanganm->get_caritarif($idcari);
		echo json_encode($data_lunas);
	}

	function otokwitansi(){
		$otokwitansi = $this->keuanganm->get_otokwitansi();
		echo json_encode($otokwitansi);
	}

	public function caripelunasanrek($idcari=''){
		$data_lunas = $this->keuanganm->get_pelunasanrek($idcari);
		echo json_encode($data_lunas);
	}

	public function caripelunasanrekbycust($idcari=''){
		$data_lunas = $this->keuanganm->get_pelunasanrekbycust($idcari);
		echo json_encode($data_lunas);
	}

	public function caripelunasaninfo($idcari=''){
		$data_lunas = $this->keuanganm->get_pelunasaninfo($idcari);
		echo json_encode($data_lunas);
	}

	public function caripiutang($idcari=''){
		$idcari = $this->input->post('tgl_filter');
		$list = $this->keuanganm->get_datatablesfilter($idcari);
		$data = array();
		foreach ($list as $keuangan) {
			if($keuangan->STATUS_LUNASFILTER == '0')
			{
				$row = array();
				$row[] = $keuangan->THBLREK;
				$row[] = $keuangan->ID_LANG;
				$row[] = $keuangan->NAMA_LANG;
				$row[] = $keuangan->ALAMAT_LANG;
				$row[] = number_format($keuangan->RPTAG);
				$row[] = number_format($keuangan->RP_BK);
				$row[] = number_format($keuangan->TOTAL_INVOICE);
				if($keuangan->STATUS_LUNASFILTER == '1'){ $STATUS = 'LUNAS';}else{$STATUS = 'BELUM';};
				$row[] = $STATUS;
				$data[] = $row;
			}
		}

		$output = array(
						"recordsTotal" => $this->keuanganm->count_allfilter($idcari),
						"recordsFiltered" => $this->keuanganm->count_filteredfilter(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function batalbk(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('keuangan/batalbk',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function batalbk_list()
	{
		$idcari = $this->input->post('id_lang');
		$list = $this->keuanganm->get_datatables($idcari);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->RPTAG;
			$row[] = $keuangan->RP_BK;

			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all(),
						"recordsFiltered" => $this->keuanganm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function batalbk_update()
	{
		$sekarang  = date('Y-m-d H:i:s');
		$user 	   = $this->session->userdata('ket');
		$ID_LANG   = $this->input->post("id_lang");
		$NAMA_LANG = $this->input->post("nama_lang");
		$STATUS_BK = $this->input->post("status_bk");
		$THBLREK   = $this->input->post("thblrek");
		$LANG_BAYAR= $this->input->post("id_lang_bayar");

		$q = "SELECT LEFT(MAX(THBLREK),4) TH, RIGHT(MAX(THBLREK),2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
		$hasil = $this->db->query($q);
		foreach ($hasil->result() as $r)
		{
			$TH		= $r->TH;
			$BLN	= $r->BLN;
		}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		if($STATUS_BK == '0'){
			$URAIAN = 'DI ALIHKAN MELALUI MENU BATAL BK';
		}else{
			$URAIAN = 'DI BATALKAN MELALUI MENU BATAL BK';
		}

			$this->db->query("DELETE FROM TP_APPROVEBK WHERE ID_LANG='$ID_LANG' AND THBLREK='$plussatu' ");
			$this->db->query("INSERT INTO TP_APPROVEBK (THBLREK,NO_AGENDA,ID_CUST,ID_LANG,NAMA_LANG,RP_BK,RP_KWH,ID_LANG_TITIPAN,URAIAN,TGL_BUAT,USER_APPROVE,STATUS_BK,ACTION)
								SELECT '$plussatu','0',ID_CUST,'$ID_LANG','$NAMA_LANG',SUM(RP_BK),SUM(RPTAG),'$LANG_BAYAR','$URAIAN','$sekarang','$user','$STATUS_BK','0'
								FROM MASTER_REKENING
								WHERE STATUS_LUNAS = '0' AND ID_LANG ='$ID_LANG' ");

		$this->db->query("INSERT INTO history (USER,ACTION,TIME,ID) VALUES ('$user','STATUS BK $STATUS_BK DIPINDAHKAN KE TP_APPROVEBK', '$sekarang', '$ID_LANG') ");

		echo json_encode(array("status" => TRUE));
	}

	public function caribk($idcari=''){
		$data_bk = $this->keuanganm->get_bk($idcari);
		echo json_encode($data_bk);
	}

	public function setujubk(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('keuangan/setujubk',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function setujubk_list()
	{
		$list = $this->keuanganm->get_datatables_approve();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = number_format($keuangan->RP_BK);
			$row[] = $keuangan->TGL_BUAT;
			if($keuangan->STATUS_BK == '0'){
						$row[] = 'DI ALIHKAN PADA BULAN REK PERTAMA';
					}else{
						$row[] = 'DI BATALKAN';
					};
			if($keuangan->ACTION == '0'){
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Setujui" onclick="edit_setujubk('."'".$keuangan->ID_LANG."'".','."'".$keuangan->THBLREK."'".','."'".'setuju'."'".','."'".$keuangan->STATUS_BK."'".')"><i class="glyphicon glyphicon-pencil"></i> SETUJUI</a>
					  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Tidak disetujui" onclick="edit_setujubk('."'".$keuangan->ID_LANG."'".','."'".$keuangan->THBLREK."'".','."'".'tidak'."'".','."'".$keuangan->STATUS_BK."'".')"><i class="glyphicon glyphicon-trash"></i> TOLAK</a>';
			}else if($keuangan->ACTION == '1'){
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Setujui" disabled>TELAH DI SETUJUI</a>';
			}else{
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Tidak Disetujui" disabled>TIDAK DI SETUJUI</a>';
			}
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_approve(),
						"recordsFiltered" => $this->keuanganm->count_filtered_approve(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function setujubk_update($idlang,$thblrek,$sts,$minta)
	{
		$sekarang = date('Y-m-d H:i:s');
		$user = $this->session->userdata('ket');
		if($sts == 'setuju'){
			$ACTION = '1';
		}else{
			$ACTION = '2';
		}

		$data = array(
			'ACTION' => $ACTION,
			'TGL_ACTION' => $sekarang
		);

		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));

		if($sts == 'setuju'){
			if($minta == '0'){
				$this->db->query("UPDATE MASTER_REKENING SET STATUS_BK='0', RP_BK='0', TOTAL_INVOICE=RPTAG WHERE ID_LANG='$idlang' AND STATUS_LUNAS='0' ");
				$this->db->query("ALTER TABLE TP_ANGSURAN AUTO_INCREMENT = 1");
				$this->db->query("INSERT INTO TP_ANGSURAN (THBLREK,NO_AGENDA,ID_CUST,ID_LANG,RP_BP,RP_UJL,RP_BK,RP_KWH,RP_P2TL,RP_INVESTASI,RP_METERAI,ID_LANG_TITIPAN,URAIAN,TGL_BUAT,USER_ENTRI_ANGSURAN)
									SELECT THBLREK,NO_AGENDA,ID_CUST,ID_LANG,'0','0',RP_BK,'0','0','0','0','','TELAH DISETUJUI ATASAN',TGL_ACTION,USER_APPROVE
									FROM TP_APPROVEBK WHERE ID_LANG='$idlang' AND THBLREK='$thblrek' ");
				$this->db->query("UPDATE EPI_CARGO.WS_EPI SET STATUS_BK='0', RP_BK='0', TOTAL_INVOICE=RPTAG WHERE ID_LANG='$idlang' AND THBLREK='$thblrek' AND STATUS_LUNAS='0'");
			}else{
				$this->db->query("UPDATE MASTER_REKENING SET STATUS_BK='0', RP_BK='0', TOTAL_INVOICE=RPTAG WHERE ID_LANG='$idlang' AND THBLREK='$thblrek' AND STATUS_LUNAS='0' ");
			}

		}else{
			$this->db->query("UPDATE TP_APPROVEBK SET ACTION='2', TGL_ACTION='$sekarang' WHERE ID_LANG='$idlang' AND THBLREK='$thblrek' ");
		}

		$this->keuanganm->update('tp_approvebk',array('THBLREK' => $thblrek,'ID_LANG' => $idlang), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function monitoringkeuangan(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['filterthbllunas']=$this->keuanganm->by_thbllunas();
			$this->load->view('keuangan/monitoringkeuangan',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function tableonline_list()
	{
		$list = $this->keuanganm->get_datatables_online();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->Thbl_lunas;
			$row[] = $keuangan->Tgl_Lunas;
			$row[] = number_format($keuangan->Jlh_cust,0,',','.');
			$row[] = number_format($keuangan->Jlh_lang,0,',','.');
			$row[] = number_format($keuangan->Jlh_lembar,0,',','.');
			$row[] = number_format($keuangan->Jlh_RPPTL,0,',','.');
			$row[] = number_format($keuangan->Jlh_RPAngsuran,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpEPI,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBPJU,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpMAT,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpTag,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBK,0,',','.');
			$row[] = number_format($keuangan->Jlh_Invoice,0,',','.');
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_online(),
						"recordsFiltered" => $this->keuanganm->count_filtered_online(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tableoffline_list()
	{
		$list = $this->keuanganm->get_datatables_offline();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->Thbl_lunas;
			$row[] = $keuangan->Tgl_Lunas;
			$row[] = number_format($keuangan->Jlh_cust,0,',','.');
			$row[] = number_format($keuangan->Jlh_lang,0,',','.');
			$row[] = number_format($keuangan->Jlh_lembar,0,',','.');
			$row[] = number_format($keuangan->Jlh_RPPTL,0,',','.');
			$row[] = number_format($keuangan->Jlh_RPAngsuran,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpEPI,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBPJU,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpMAT,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpTag,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBK,0,',','.');
			$row[] = number_format($keuangan->Jlh_Invoice,0,',','.');
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_offline(),
						"recordsFiltered" => $this->keuanganm->count_filtered_offline(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tablepiutang_list()
	{
		$list = $this->keuanganm->get_datatables_piutang();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->thblrek;
			$row[] = number_format($keuangan->Jlh_Cust,0,',','.');
			$row[] = number_format($keuangan->Jlh_Langganan,0,',','.');
			$row[] = number_format($keuangan->Jlh_Lembar,0,',','.');
			$row[] = $keuangan->Jlh_RpEPI;
			$row[] = $keuangan->Jlh_RpBPJU;
			$row[] = $keuangan->Jlh_RpMAT;
			$row[] = $keuangan->Jlh_RpTag;
			$row[] = $keuangan->Jlh_RpBK;
			$row[] = $keuangan->Jlh_Invoice;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_piutang(),
						"recordsFiltered" => $this->keuanganm->count_filtered_piutang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tabledetbpujl_list()
	{
		$list = $this->keuanganm->get_datatables_detbpujl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->NO_AGENDA;
			$row[] = $keuangan->JNS_TRANSAKSI;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = number_format($keuangan->RP_BP,0,',','.');
			$row[] = number_format($keuangan->RP_UJL_TAGIH,0,',','.');
			$row[] = number_format($keuangan->MATERAI,0,',','.');
			$row[] = $keuangan->TOTAL_BIAYA;
			$row[] = $keuangan->TGL_BAYAR;
			$row[] = $keuangan->Pola_bayar;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_detbpujl(),
						"recordsFiltered" => $this->keuanganm->count_filtered_detbpujl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tablerekapnontaglis_list()
	{
		$list = $this->keuanganm->get_datatables_rekapnontaglis();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->Thbl_lunas;
			$row[] = $keuangan->Jns_Transaksi;
			$row[] = number_format($keuangan->Jlh_Permohonan,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBP,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpUJL_TAGIH,0,',','.');
			$row[] = number_format($keuangan->Jlh_Materai,0,',','.');
			$row[] = number_format($keuangan->Jlh_TOTAL_BIAYA,0,',','.');
			$row[] = $keuangan->Pola_bayar;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_rekapnontaglis(),
						"recordsFiltered" => $this->keuanganm->count_filtered_rekapnontaglis(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tabledetnontaglis_list()
	{
		$list = $this->keuanganm->get_datatables_detnontaglis();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->NO_AGENDA;
			$row[] = $keuangan->JNS_TRANSAKSI;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = number_format($keuangan->RP_BP,0,',','.');
			$row[] = number_format($keuangan->RP_UJL_TAGIH,0,',','.');
			$row[] = number_format($keuangan->MATERAI,0,',','.');
			$row[] = number_format($keuangan->TOTAL_BIAYA,0,',','.');
			$row[] = $keuangan->Pola_bayar;
			$row[] = $keuangan->TGL_BAYAR;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_detnontaglis(),
						"recordsFiltered" => $this->keuanganm->count_filtered_detnontaglis(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tablerekapnontaglisps_list()
	{
		$list = $this->keuanganm->get_datatables_rekapnontaglisps();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->Thbl_lunas;
			$row[] = $keuangan->Jns_Transaksi;
			$row[] = number_format($keuangan->Jlh_Permohonan,0,',','.');
			$row[] = number_format($keuangan->Jlh_KWH_PS,0,',','.');
			$row[] = number_format($keuangan->Jlh_RpBP,0,',','.');
			$row[] = number_format($keuangan->Jlh_BPJU_PS,0,',','.');
			$row[] = number_format($keuangan->Jlh_Materai,0,',','.');
			$row[] = number_format($keuangan->Jlh_TOTAL_BIAYA,0,',','.');
			$row[] = $keuangan->Pola_bayar;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_rekapnontaglisps(),
						"recordsFiltered" => $this->keuanganm->count_filtered_rekapnontaglisps(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tabledetnontaglisps_list()
	{
		$list = $this->keuanganm->get_datatables_detnontaglisps();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->NO_AGENDA;
			$row[] = $keuangan->JNS_TRANSAKSI;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = number_format($keuangan->RP_KWH,0,',','.');
			$row[] = number_format($keuangan->RP_BP,0,',','.');
			$row[] = number_format($keuangan->RP_BPJU,0,',','.');
			$row[] = number_format($keuangan->MATERAI,0,',','.');
			$row[] = number_format($keuangan->TOTAL_BIAYA,0,',','.');
			$row[] = $keuangan->Pola_bayar;
			$row[] = $keuangan->TGL_BAYAR;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_detnontaglisps(),
						"recordsFiltered" => $this->keuanganm->count_filtered_detnontaglisps(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function kendalikredit(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['idlang_putus']= $this->keuanganm->get_idlang_putus($kondisi="WHERE a.STATUS_LUNAS = 0 AND a.STATUS_PMT !=0 AND b.KD_MUT NOT IN ('N','') AND a.KOGOL = '0' ");
			$this->load->view('keuangan/kendalikredit',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function get_kendaliproses(){
		$data_kendaliproses = $this->keuanganm->get_kendaliproses();
		echo json_encode($data_kendaliproses);
	}

	public function get_detnamaputus($idcari=''){
		$data_lunas = $this->keuanganm->get_detnamaputus($idcari);
		echo json_encode($data_lunas);
	}

	public function pemutusan_update()
	{
		$ID_LANG	= $this->input->post("idlang_putus");
		$TGL_PUTUS	= $this->input->post("tgl_putus");
		$jam        = date("H:i:s");
		$TGLPUTUS   = $TGL_PUTUS." ".$jam;

		$this->db->query("UPDATE MASTER_REKENING SET TGL_PUTUS = '$TGLPUTUS', PERIODE = DATE_FORMAT('$TGLPUTUS', '%Y%m') WHERE ID_LANG = '$ID_LANG' AND STATUS_PMT != 0 ");
		echo json_encode(array("status" => TRUE));
	}

	public function kendalisatu_list()
	{
		$list = $this->keuanganm->get_datatables_kendalisatu();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Cetak" onclick="cetakputussementara('."'".$keuangan->THBLREK."'".","."'".$keuangan->ID_LANG."'".","."'".'perlang'."'".')">CETAK</a>';
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = $keuangan->PERIODE;
			$row[] = $keuangan->LEMBAR;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = $keuangan->CETAK_KENDALI_A;
			$row[] = $keuangan->TGL_PUTUS;
			$row[] = $keuangan->TGL_LUNAS;
			$row[] = $keuangan->TGL_SAMBUNG;

			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_kendalisatu(),
						"recordsFiltered" => $this->keuanganm->count_filtered_kendalisatu(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function kendalidua_list()
	{
		$list = $this->keuanganm->get_datatables_kendalidua();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = $keuangan->PERIODE;
			$row[] = $keuangan->LEMBAR;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = $keuangan->CETAK_KENDALI_B;
			$row[] = $keuangan->TGL_PUTUS;
			$row[] = $keuangan->TGL_LUNAS;
			$row[] = $keuangan->TGL_SAMBUNG;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_kendalidua(),
						"recordsFiltered" => $this->keuanganm->count_filtered_kendalidua(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function kendalitiga_list()
	{
		$list = $this->keuanganm->get_datatables_kendalitiga();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->PERIODE;
			$row[] = $keuangan->LEMBAR;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = $keuangan->CETAK_KENDALI_C;
			$row[] = $keuangan->TGL_PUTUS;
			$row[] = $keuangan->TGL_LUNAS;
			$row[] = $keuangan->TGL_SAMBUNG;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_kendalitiga(),
						"recordsFiltered" => $this->keuanganm->count_filtered_kendalitiga(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function lunasbycust_list()
	{
		$idcari = $this->input->post('id_cust');
		$list = $this->keuanganm->get_datatableslunasbycust($idcari);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->ID_LANG;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = number_format($keuangan->TOTAL_INVOICE);
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_alllunasbycust($idcari),
						"recordsFiltered" => $this->keuanganm->count_filteredlunasbycust(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function lunasbycustselect_list()
	{
		$idcari = $this->input->post('id_cust');
		$list = $this->keuanganm->get_datatableslunasbycust($idcari);
		$data = array();
		foreach ($list as $keuangan) {
			$row = array();
			$row[] = ' <input type="checkbox" name="pilihan[]" value='.$keuangan->THBLREK.$keuangan->ID_CUST.' >';
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->JML_LEMBAR;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = number_format($keuangan->TOTAL_INVOICE);
			$data[] = $row;
		}

		$output = array(
						"recordsTotal" => $this->keuanganm->count_alllunasbycust($idcari),
						"recordsFiltered" => $this->keuanganm->count_filteredlunasbycust(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	function suminvoice($id_cust){
		$suminvoice = $this->keuanganm->get_suminvoice($id_cust);
		echo json_encode($suminvoice);
	}

	public function lunasbylang_list()
	{
		$idcari = $this->input->post('id_lang');
		$list = $this->keuanganm->get_datatableslunasbylang($idcari);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="cetakbylang('."'".$keuangan->ID."'".","."'".$keuangan->THBLREK."'".')"></i> Cetak Invoice</a>';
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->NAMA_LANG;
			$row[] = number_format($keuangan->RPTAG);
			$row[] = number_format($keuangan->RP_BK);
			$row[] = number_format($keuangan->TOTAL_INVOICE);
			$row[] = $keuangan->TGL_LUNAS;
			$row[] = $keuangan->STATUS_LUNAS;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_alllunasbylang($idcari),
						"recordsFiltered" => $this->keuanganm->count_filteredlunasbylang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function carikwitansibylang($idcari=''){
		$data_lunas = $this->keuanganm->get_kwitansibylang($idcari);
		echo json_encode($data_lunas);
	}

	public function kwitansibylangselect_list()
	{
		$otori  = $this->session->userdata('ket');
		$idcari = $this->input->post('id_lang');
		$list   = $this->keuanganm->get_datatableskwitansibylang($idcari);
		$data   = array();
		$no     = $_POST['start'];

		if($otori == 'Supervisor Keuangan' OR $otori == 'Manager Keuangan' OR $otori == 'Administrator'){
			foreach ($list as $keuangan) {
				$no++;
				$row = array();
				if($keuangan->STATUS_LUNAS == 0 ){
					$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cetak" onclick="cetakbylang('."'".$keuangan->ID_LANG."'".","."'".$keuangan->TGL_LUNAS."'".')" disabled></i> Cetak Kwitansi</a>';
				}else{
					$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cetak" onclick="cetakbylang('."'".$keuangan->ID_LANG."'".","."'".$keuangan->TGL_LUNAS."'".')"></i> Cetak Kwitansi</a>';
				}

				$row[] = $keuangan->ID_CUST;
				$row[] = $keuangan->ID_LANG;
				$row[] = $keuangan->TGL_LUNAS;
				$row[] = $keuangan->BRPBULAN;
				$row[] = number_format($keuangan->TOTAL);
				$row[] = $keuangan->THBLREK;
				$data[] = $row;
			}
		}else{
			foreach ($list as $keuangan) {
				$no++;
				$row = array();
				if($keuangan->STATUS_LUNAS == 0 ){
					$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cetak" onclick="cetakbylang('."'".$keuangan->ID_LANG."'".","."'".$keuangan->TGL_LUNAS."'".')" disabled></i> Cetak Kwitansi</a>';
				}elseif($keuangan->STATUS_CTK_KWITANSI == 1){
					$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cetak" onclick="cetakbylang('."'".$keuangan->ID_LANG."'".","."'".$keuangan->TGL_LUNAS."'".')" disabled></i> Cetak Kwitansi</a>';
				}else{
					$row[] = '<a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Cetak" onclick="cetakbylang('."'".$keuangan->ID_LANG."'".","."'".$keuangan->TGL_LUNAS."'".')"></i> Cetak Kwitansi</a>';
				}
				$row[] = $keuangan->ID_CUST;
				$row[] = $keuangan->ID_LANG;
				$row[] = $keuangan->TGL_LUNAS;
				$row[] = $keuangan->BRPBULAN;
				$row[] = number_format($keuangan->TOTAL);
				$row[] = $keuangan->THBLREK;
				$data[] = $row;
			}
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_allkwitansibylang($idcari),
						"recordsFiltered" => $this->keuanganm->count_filteredkwitansibylang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekterbitgol_list()
	{
		$idcari = @$this->input->post('tablerekterbitgol');
		$list = $this->keuanganm->get_datatables_rekterbitgol($idcari);
		$data = array();
		foreach ($list as $keuangan) {
			$row = array();
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="cetakgolexcel('."'".$keuangan->THBLREK."'".','."'".$keuangan->KOGOL."'".')"></i>Export Detail</a>';
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->GOL;
			$row[] = $keuangan->JML_LANG;
			$row[] = number_format($keuangan->JML_DAYA);
			$row[] = number_format($keuangan->JML_KWH);
			$row[] = number_format($keuangan->KLBKVARH);
			$row[] = number_format($keuangan->RPPTL);
			$row[] = number_format($keuangan->RPBPJU);
			$row[] = number_format($keuangan->RPANGSURAN);
			$row[] = number_format($keuangan->MATERAI);
			$row[] = number_format($keuangan->RPTAG);
			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->keuanganm->count_all_rekterbitgol($idcari),
						"recordsFiltered" => $this->keuanganm->count_filtered_rekterbitgol(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekterbitthblrek_list()
	{
		$idcari = $this->input->post('tablerekterbitthblrek');
		$list = $this->keuanganm->get_datatables_rekaphitung($idcari);
		$data = array();
		foreach ($list as $cater) {
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->NM_AREA;
			$row[] = $cater->JML_LANG;
			$row[] = number_format($cater->JML_DAYA);
			$row[] = number_format($cater->JML_KWH);
			$row[] = number_format($cater->KLBKVARH);
			$row[] = number_format($cater->RPPTL);
			$row[] = number_format($cater->RPBPJU);
			$row[] = number_format($cater->RPANGSURAN);
			$row[] = number_format($cater->MATERAI);
			$row[] = number_format($cater->RPTAG);
			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->keuanganm->count_all_rekaphitung($idcari),
						"recordsFiltered" => $this->keuanganm->count_filtered_rekaphitung(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekterbitthblrekfilter_list()
	{
		$idcari = $this->input->post('tablerekterbitthblrek');
		$list = $this->keuanganm->get_datatables_rekaphitungthblrek($idcari);
		$data = array();
		foreach ($list as $cater) {
			$row = array();
			$row[] = $cater->thblrek;
			$row[] = $cater->Jlh_Cust;
			$row[] = $cater->Jlh_Langganan;
			$row[] = number_format($cater->JML_DAYA);
			$row[] = number_format($cater->JML_KWH);
			$row[] = number_format($cater->KLBKVARH);
			$row[] = number_format($cater->RPPTL);
			$row[] = number_format($cater->RPBPJU);
			$row[] = number_format($cater->RPANGSURAN);
			$row[] = number_format($cater->RPMAT);
			$row[] = number_format($cater->RPTAG);
			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->keuanganm->count_all_rekaphitungthblrek($idcari),
						"recordsFiltered" => $this->keuanganm->count_filtered_rekaphitungthblrek(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function tableangsuran_list()
	{
		$list = $this->keuanganm->get_datatables_angsuran();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $keuangan) {
			$no++;
			$row = array();
			$row[] = $keuangan->THBLREK;
			$row[] = $keuangan->ID_CUST;
			$row[] = $keuangan->ID_LANG;
			$row[] = $keuangan->JML_MOHON;
			$row[] = number_format($keuangan->RP_BP,0,',','.');
			$row[] = number_format($keuangan->RP_UJL,0,',','.');
			$row[] = number_format($keuangan->RP_BK,0,',','.');
			$row[] = number_format($keuangan->RP_KWH,0,',','.');
			$row[] = number_format($keuangan->RP_P2TL,0,',','.');
			$row[] = number_format($keuangan->RP_INVESTASI,0,',','.');
			$row[] = number_format($keuangan->RP_METERAI,0,',','.');
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->keuanganm->count_all_angsuran(),
						"recordsFiltered" => $this->keuanganm->count_filtered_angsuran(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekaphitung_list()
	{
		$idcari = @$this->input->post('tablerekterbit');
		$this->load->model('billingm');
		$list = $this->billingm->get_datatables_rekaphitung($idcari);
		$data = array();
		foreach ($list as $cater) {
			$row = array();
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Detail" onclick="cetakareaexcel('."'".$cater->THBLREK."'".','."'".$cater->KD_AREA."'".')"></i>Export Detail</a>';
			$row[] = $cater->THBLREK;
			$row[] = $cater->NM_AREA;
			$row[] = $cater->JML_LANG;
			$row[] = number_format($cater->JML_DAYA);
			$row[] = number_format($cater->JML_KWH);
			$row[] = number_format($cater->KLBKVARH);
			$row[] = number_format($cater->RPPTL);
			$row[] = number_format($cater->RPBPJU);
			$row[] = number_format($cater->RPANGSURAN);
			$row[] = number_format($cater->MATERAI);
			$row[] = number_format($cater->RPTAG);
			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->billingm->count_all_rekaphitung($idcari),
						"recordsFiltered" => $this->billingm->count_filtered_rekaphitung(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekaplunas_list()
	{
		$list = $this->infom->get_datatables_rekaplunas();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->Bulan_Lunas;
			$row[] = $informasi->Jlh_cust;
			$row[] = $informasi->Jlh_lang;
			$row[] = $informasi->Jlh_lembar;
			$row[] = $informasi->Jlh_RpEPI;
			$row[] = $informasi->Jlh_RpBPJU;
			$row[] = $informasi->Jlh_RpMAT;
			$row[] = $informasi->Jlh_RpTag;
			$row[] = $informasi->Jlh_RpBK;
			$row[] = $informasi->Jlh_Invoice;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekaplunas(),
						"recordsFiltered" => $this->infom->count_filtered_rekaplunas(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function excelmandiri()
	{
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BA')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(10);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID LANGGANAN')
            ->setCellValue('B1', 'Bill key 2')
            ->setCellValue('C1', 'Bill key 2')
            ->setCellValue('D1', 'Currency')
            ->setCellValue('E1', 'NAMA LANGGANAN')
            ->setCellValue('F1', 'BULAN TAG')
            ->setCellValue('G1', 'LEMBAR TAG')
            ->setCellValue('H1', 'Bill Info 04')
            ->setCellValue('I1', 'Bill Info 05')
            ->setCellValue('J1', 'Bill Info 06')
            ->setCellValue('K1', 'Bill Info 07')
            ->setCellValue('L1', 'Bill Info 08')
            ->setCellValue('M1', 'Bill Info 09')
            ->setCellValue('N1', 'Bill Info 10')
            ->setCellValue('O1', 'Bill Info 11')
						->setCellValue('P1', 'Bill Info 12')
						->setCellValue('Q1', 'Bill Info 13')
						->setCellValue('R1', 'Bill Info 14')
						->setCellValue('S1', 'Bill Info 15')
						->setCellValue('T1', 'Bill Info 16')
						->setCellValue('U1', 'Bill Info 17')
						->setCellValue('V1', 'Bill Info 18')
						->setCellValue('W1', 'Bill Info 19')
						->setCellValue('X1', 'Bill Info 20')
						->setCellValue('Y1', 'Bill Info 21')
						->setCellValue('Z1', 'Bill Info 22')
						->setCellValue('AA1', 'Bill Info 23')
						->setCellValue('AB1', 'Bill Info 24')
						->setCellValue('AC1', 'Bill Info 25')
						->setCellValue('AD1', 'Periode Open')
						->setCellValue('AE1', 'Periode Close')
						->setCellValue('AF1', 'SubBill 01')
						->setCellValue('AG1', 'SubBill 02')
						->setCellValue('AH1', 'SubBill 03')
						->setCellValue('AI1', 'SubBill 04')
						->setCellValue('AJ1', 'SubBill 05')
						->setCellValue('AK1', 'SubBill 06')
						->setCellValue('AL1', 'SubBill 07')
						->setCellValue('AM1', 'SubBill 08')
						->setCellValue('AN1', 'SubBill 09')
						->setCellValue('AO1', 'SubBill 10')
						->setCellValue('AP1', 'SubBill 11')
						->setCellValue('AQ1', 'SubBill 12')
						->setCellValue('AR1', 'SubBill 13')
						->setCellValue('AS1', 'SubBill 14')
						->setCellValue('AT1', 'SubBill 15')
						->setCellValue('AU1', 'SubBill 16')
						->setCellValue('AV1', 'SubBill 17')
						->setCellValue('AW1', 'SubBill 18')
						->setCellValue('AX1', 'SubBill 19')
						->setCellValue('AY1', 'SubBill 20')
						->setCellValue('AZ1', 'SubBill 21')
						->setCellValue('BA1', 'SubBill 22')
						->setCellValue('BB1', 'SubBill 23')
						->setCellValue('BC1', 'SubBill 24')
						->setCellValue('BD1', 'SubBill 25')
						->setCellValue('BE1', 'end record');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;

		$sql = "SELECT * FROM v_saldopiutang_perlang_bank ";

		$hasil = $this->db->query($sql)->result();
				foreach ($hasil as $row) {

					//bln tagihan
					if ($row->THBLMIN == $row->THBLMAX) {
						# code...
					} else {
						# code...
					}



					$thnmin  = SUBSTR( $row->THBLMIN,0,4);
					$blnmin  = SUBSTR( $row->THBLMIN,4,2);
					$bulanmin=  strtoupper(SUBSTR(getBulan($blnmin),0,3));
					$thblmin = $bulanmin." ".$thnmin;

					$thnmax  = SUBSTR( $row->THBLMAX,0,4);
					$blnmax  = SUBSTR( $row->THBLMAX,4,2);
					$bulanmax=  strtoupper(SUBSTR(getBulan($blnmax),0,3));
					$thblmax = $bulanmax." ".$thnmax;

					$blntag = $thblmin." - ".$thblmax;
					$periode_open = '20180405';
					$periode_close = '20180420';

					$ax = "\ ";
					$bx = substr($ax,-2,1)."".$row->JLH_INVOICE;
					$total = "01\TOTAL\TOTAL".$bx;

            $ex->setCellValue('A'.$counter, $row->ID_LANG);
            $ex->setCellValue('B'.$counter, '');
            $ex->setCellValue('C'.$counter, '');
            $ex->setCellValue('D'.$counter, 'IDR');
            $ex->setCellValue('E'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('F'.$counter, $blntag);
            $ex->setCellValue('G'.$counter, $row->JLH_LEMBAR);
            $ex->setCellValue('H'.$counter, '');
            $ex->setCellValue('I'.$counter, '');
            $ex->setCellValue('J'.$counter, '');
            $ex->setCellValue('K'.$counter, '');
            $ex->setCellValue('L'.$counter, '');
            $ex->setCellValue('M'.$counter, '');
            $ex->setCellValue('N'.$counter, '');
            $ex->setCellValue('O'.$counter, '');
						$ex->setCellValue('P'.$counter, '');
						$ex->setCellValue('Q'.$counter, '');
						$ex->setCellValue('R'.$counter, '');
						$ex->setCellValue('S'.$counter, '');
						$ex->setCellValue('T'.$counter, '');
						$ex->setCellValue('U'.$counter, '');
						$ex->setCellValue('V'.$counter, '');
						$ex->setCellValue('W'.$counter, '');
						$ex->setCellValue('X'.$counter, '');
						$ex->setCellValue('Y'.$counter, '');
						$ex->setCellValue('Z'.$counter, '');
						$ex->setCellValue('AA'.$counter, '');
						$ex->setCellValue('AB'.$counter, '');
						$ex->setCellValue('AC'.$counter, '');
						$ex->setCellValue('AD'.$counter, $periode_open);
						$ex->setCellValue('AE'.$counter, $periode_close);
						$ex->setCellValue('AF'.$counter, $total);
						$ex->setCellValue('AG'.$counter, '');
						$ex->setCellValue('AH'.$counter, '');
						$ex->setCellValue('AI'.$counter, '');
						$ex->setCellValue('AJ'.$counter, '');
						$ex->setCellValue('AK'.$counter, '');
						$ex->setCellValue('AL'.$counter, '');
						$ex->setCellValue('AM'.$counter, '');
						$ex->setCellValue('AN'.$counter, '');
						$ex->setCellValue('AO'.$counter, '');
						$ex->setCellValue('AP'.$counter, '');
						$ex->setCellValue('AQ'.$counter, '');
						$ex->setCellValue('AR'.$counter, '');
						$ex->setCellValue('AS'.$counter, '');
						$ex->setCellValue('AT'.$counter, '');
						$ex->setCellValue('AU'.$counter, '');
						$ex->setCellValue('AV'.$counter, '');
						$ex->setCellValue('AW'.$counter, '');
						$ex->setCellValue('AX'.$counter, '');
						$ex->setCellValue('AY'.$counter, '');
						$ex->setCellValue('AZ'.$counter, '');
						$ex->setCellValue('BA'.$counter, '');
						$ex->setCellValue('BB'.$counter, '');
						$ex->setCellValue('BC'.$counter, '');
						$ex->setCellValue('BD'.$counter, '');
						$ex->setCellValue('BE'.$counter, '');

            $counter = $counter+1;
        }

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("Mandiri Excel")
            ->setSubject("Mandiri Excel")
            ->setDescription("Mandiri Excel by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Mandiri Excel");
        $objPHPExcel->getActiveSheet()->setTitle('Stand AKhir');
        $TitlE 		= "Hasil Download Mandiri Excel";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');

	}

	public function info_tagihan(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('keuangan/info_tagihan');
		}else{
			redirect('welcome/index');
		}
	}

}
