<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Informasi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('registercustm');
		$this->load->model('permohonanm');
		$this->load->model('surveym');
		$this->load->model('caterm');
		$this->load->model('infom');
		date_default_timezone_set('Asia/Jakarta');
	}

	public function info_mohon(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
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
			$this->load->view('informasi/info_mohon',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function info_cater(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$datax['records'] = $this->caterm->rekapstand_list();
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
			$header = array('THBLREK','KODE AREA','JUMLAH PELANGGAN', 'BELUM ENTRI STAND AKHIR', 'SUDAH ENTRI STAND AKHIR');
			$this->table->set_heading($header);

			$this->load->view('head',$data);
			$this->load->view('informasi/info_cater',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function info_billing(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('informasi/info_billing');
		}else{
			redirect('welcome/index');
		}
	}

	public function info_keu(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('informasi/info_keu');
		}else{
			redirect('welcome/index');
		}
	}

	public function infoarea_list()
	{
		$list = $this->infom->get_datatables_infoarea();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->KD_AREA;
			$row[] = $informasi->JML_CUST;
			$row[] = $informasi->JML_LANG;
			$row[] = $informasi->JML_LEMBAR;
			$row[] = $informasi->JML_RPEPI;
			$row[] = $informasi->JML_RPBJU;
			$row[] = $informasi->JML_RPMAT;
			$row[] = $informasi->JML_RPTAG;
			$row[] = $informasi->JML_RPBK;
			$row[] = $informasi->JML_INVOICE;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_infoarea(),
						"recordsFiltered" => $this->infom->count_filtered_infoarea(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function infocust_list()
	{
		$list = $this->infom->get_datatables_infocust();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->ID_CUST;
			$row[] = $informasi->JML_LEMBAR;
			$row[] = $informasi->JML_RPEPI;
			$row[] = $informasi->JML_RPBPJU;
			$row[] = $informasi->JML_RPMAT;
			$row[] = $informasi->JML_RPTAG;
			$row[] = $informasi->JML_RPBK;
			$row[] = $informasi->JML_INVOICE;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_infocust(),
						"recordsFiltered" => $this->infom->count_filtered_infocust(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function infolang_list()
	{
		$list = $this->infom->get_datatables_infolang();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->ID_CUST;
			$row[] = $informasi->JML_LEMBAR;
			$row[] = $informasi->JML_RPEPI;
			$row[] = $informasi->JML_RPBPJU;
			$row[] = $informasi->JML_RPMAT;
			$row[] = $informasi->JML_RPTAG;
			$row[] = $informasi->JML_RPBK;
			$row[] = $informasi->JML_INVOICE;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_infolang(),
						"recordsFiltered" => $this->infom->count_filtered_infolang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekappdl_list()
	{
		$list = $this->infom->get_datatables_rekappdl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->THBLMUT;
			$row[] = $informasi->KD_AREA;
			$row[] = $informasi->JNS_TRANSAKSI;
			$row[] = $informasi->JML_LANG;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekappdl(),
						"recordsFiltered" => $this->infom->count_filtered_rekappdl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapbpujl_list()
	{
		$list = $this->infom->get_datatables_rekapbpujl();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->NO_AGENDA;
			$row[] = $informasi->THBLLUNAS;
			$row[] = $informasi->ID_CUST;
			$row[] = $informasi->ID_LANG;
			$row[] = $informasi->NAMA_LANG;
			$row[] = number_format($informasi->RP_BP);
			$row[] = number_format($informasi->RP_UJL_TAGIH);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekapbpujl(),
						"recordsFiltered" => $this->infom->count_filtered_rekapbpujl(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapkwh_list()
	{
		$list = $this->infom->get_datatables_rekapkwh();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->THBL_MOHON;
			$row[] = $informasi->ID_CUST;
			$row[] = $informasi->NO_AGENDA;
			$row[] = $informasi->NAMA_LANG;
			$row[] = number_format($informasi->KWH_PS);
			$row[] = number_format($informasi->RPKWH_PS);
			$row[] = number_format($informasi->RPBPJU_PS);
			$row[] = number_format($informasi->RPJML_PS);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekapkwh(),
						"recordsFiltered" => $this->infom->count_filtered_rekapkwh(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekaprek_list()
	{
		$list = $this->infom->get_datatables_rekaprek();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->THBLREK;
			$row[] = $informasi->kd_area;
			$row[] = $informasi->JLH_LANGG;
			$row[] = $informasi->JLH_DAYA;
			$row[] = $informasi->JLH_KWH;
			$row[] = $informasi->JLH_RPPTL;
			$row[] = $informasi->JLH_ANGS;
			$row[] = $informasi->JLH_RPBJU;
			$row[] = $informasi->JLH_RPMAT;
			$row[] = $informasi->JLH_TAGIHAN;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekaprek(),
						"recordsFiltered" => $this->infom->count_filtered_rekaprek(),
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

	public function saldoarea_list()
	{
		$list = $this->infom->get_datatables_saldoarea();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->kd_area;
			$row[] = $informasi->Jlh_Cust;
			$row[] = "<a href='javascript:void(0)' title='Lihat' onclick='cek_jmllang(".$informasi->kd_area.")'>".$informasi->Jlh_Langganan."</a>";
			$row[] = "<a href='javascript:void(0)' title='Lihat' onclick='cek_jmllembar(".$informasi->kd_area.")'>".$informasi->Jlh_Lembar."</a>";
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
						"recordsTotal" => $this->infom->count_all_saldoarea(),
						"recordsFiltered" => $this->infom->count_filtered_saldoarea(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detsaldopiutang_list()
	{
		$KD_AREA = $this->input->post('KD_AREA');
		$list = $this->infom->get_datatables_detsaldopiutang($KD_AREA);
		$data = array();
		foreach ($list as $informasi) {
			$row = array();
			$row[] = $informasi->kd_area;
			$row[] = $informasi->Jlh_Langganan;
			$row[] = $informasi->NAMA_LANG;
			$row[] = $informasi->Jlh_Lembar;
			$row[] = number_format($informasi->Jlh_RpEPI);
			$row[] = number_format($informasi->Jlh_RpBPJU);
			$row[] = number_format($informasi->Jlh_RpMAT);
			$row[] = number_format($informasi->Jlh_RpTag);
			$row[] = number_format($informasi->Jlh_RpBK);
			$row[] = number_format($informasi->Jlh_Invoice);

			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->infom->count_all_detsaldopiutang($KD_AREA),
						"recordsFiltered" => $this->infom->count_filtered_detsaldopiutang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detsaldopiutang2_list()
	{
		$KD_AREA = $this->input->post('KD_AREA');
		$list = $this->infom->get_datatables_detsaldopiutang2($KD_AREA);
		$data = array();
		foreach ($list as $informasi) {
			$row = array();
			$row[] = $informasi->kd_area;
			$row[] = $informasi->THBLREK;
			$row[] = $informasi->Jlh_Langganan;
			$row[] = $informasi->NAMA_LANG;
			$row[] = number_format($informasi->Jlh_RpEPI);
			$row[] = number_format($informasi->Jlh_RpBPJU);
			$row[] = number_format($informasi->Jlh_RpMAT);
			$row[] = number_format($informasi->Jlh_RpTag);
			$row[] = number_format($informasi->Jlh_RpBK);
			$row[] = number_format($informasi->Jlh_Invoice);

			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->infom->count_all_detsaldopiutang2($KD_AREA),
						"recordsFiltered" => $this->infom->count_filtered_detsaldopiutang2(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function saldogol_list()
	{
		$list = $this->infom->get_datatables_saldogol();
		$data = array();
		foreach ($list as $informasi) {
			$row = array();
			$row[] = $informasi->kogol;
			$row[] = $informasi->Jlh_Cust;
			$row[] = $informasi->Jlh_Langganan;
			$row[] = $informasi->Jlh_Lembar;
			$row[] = $informasi->Jlh_RpEPI;
			$row[] = $informasi->Jlh_RpBPJU;
			$row[] = $informasi->Jlh_RpMAT;
			$row[] = $informasi->Jlh_RpTag;
			$row[] = $informasi->Jlh_RpBK;
			$row[] = $informasi->Jlh_Invoice;
			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->infom->count_all_saldogol(),
						"recordsFiltered" => $this->infom->count_filtered_saldogol(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function saldocust_list()
	{
		$list = $this->infom->get_datatables_saldocust();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->id_cust;
			$row[] = $informasi->nama_cust;
			$row[] = $informasi->Jlh_Lembar;
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
						"recordsTotal" => $this->infom->count_all_saldocust(),
						"recordsFiltered" => $this->infom->count_filtered_saldocust(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function saldolang_list()
	{
		$list = $this->infom->get_datatables_saldolang();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->id_cust;
			$row[] = $informasi->id_lang;
			$row[] = $informasi->Jlh_Lembar;
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
						"recordsTotal" => $this->infom->count_all_saldolang(),
						"recordsFiltered" => $this->infom->count_filtered_saldolang(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function saldothblrek_list()
	{
		$list = $this->infom->get_datatables_saldothblrek();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->thblrek;
			$row[] = $informasi->Jlh_Cust;
			$row[] = $informasi->Jlh_Langganan;
			$row[] = $informasi->Jlh_Lembar;
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
						"recordsTotal" => $this->infom->count_all_saldothblrek(),
						"recordsFiltered" => $this->infom->count_filtered_saldothblrek(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekaprekgol_list()
	{
		$list = $this->infom->get_datatables_rekaprekgol();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $informasi) {
			$no++;
			$row = array();
			$row[] = $informasi->THBLREK;
			$row[] = $informasi->GOLONGAN;
			$row[] = $informasi->JLH_LANGG;
			$row[] = $informasi->JLH_DAYA;
			$row[] = $informasi->JLH_KWH;
			$row[] = $informasi->JLH_RPPTL;
			$row[] = $informasi->JLH_ANGS;
			$row[] = $informasi->JLH_RPBJU;
			$row[] = $informasi->JLH_RPMAT;
			$row[] = $informasi->JLH_TAGIHAN;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->infom->count_all_rekaprekgol(),
						"recordsFiltered" => $this->infom->count_filtered_rekaprekgol(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function info_neraca($xtahun = '' ){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();

				$data['get_tahun']=$this->infom->get_tahun();
				$data['get_tahun_last'] = $this->db->query("select max(tahun) as tahun from dbportal.atahun")->row()->tahun;
				$data['grafik_n_p_1']=$this->infom->get_grafik_pendapatan();
				$data['grafik_n_p_0']=$this->infom->get_grafik_n_p();
				$data['grafik_n_b_1']=$this->infom->get_grafik_beban();
				$data['grafik_n_b_0']=$this->infom->get_grafik_n_b();
				$data['grafik_n_lr_1']=$this->infom->get_grafik_lr();
				$data['grafik_n_lr_0']=$this->infom->get_grafik_n_lr();

				$data['grafik_n_bopo_1']=$this->infom->get_grafik_bopo();
				$data['grafik_n_bopo_0']=$this->infom->get_grafik_n_bopo();

				foreach ($this->infom->get_tahun() as $r)
				{
					$thn = $r->tahun;
					$data['get_neraca_p_r'][$thn] = $this->infom->get_neraca_p_r($thn);
					$data['get_neraca_p_t'][$thn] = $this->infom->get_neraca_p_t($thn);
					$data['get_neraca_plu_r'][$thn] = $this->infom->get_neraca_plu_r($thn);
					$data['get_neraca_plu_t'][$thn] = $this->infom->get_neraca_plu_t($thn);
					$data['get_neraca_b_r'][$thn] = $this->infom->get_neraca_b_r($thn);
					$data['get_neraca_b_detil_r'][$thn] = $this->infom->get_neraca_b_detil_r($thn);
					$data['get_neraca_b_t'][$thn] = $this->infom->get_neraca_b_t($thn);
					$data['get_neraca_b_detil_t'][$thn] = $this->infom->get_neraca_b_detil_t($thn);
					$data['get_neraca_blu_r'][$thn] = $this->infom->get_neraca_blu_r($thn);
					$data['get_neraca_blu_t'][$thn] = $this->infom->get_neraca_blu_t($thn);
					$data['get_neraca_lr_u'][$thn] = $this->infom->get_neraca_lr_u($thn);
					$data['get_neraca_lr_lu'][$thn] = $this->infom->get_neraca_lr_lu($thn);
					$data['get_neraca_bopo'][$thn] = $this->infom->get_neraca_bopo($thn);

				}

				$this->load->view('head',$data);
				$this->load->view('informasi/info_neraca');
		}else{
			redirect('welcome/index');
		}
	}




}
