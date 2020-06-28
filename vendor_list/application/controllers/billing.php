<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Billing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('billingm');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		date_default_timezone_set('Asia/Jakarta');
	}

	function get_thblrek(){
		$sql = "SELECT MAX(THBLREK) THBLREK, LEFT(MAX(THBLREK),4) TH, RIGHT(MAX(THBLREK),2) BLN, '20' TGL FROM dil_listrik_new";
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

	function get_thblrekplus(){
		$sql = "SELECT MAX(THBLREK) THBLREK, LEFT(MAX(THBLREK),4) TH, RIGHT(MAX(THBLREK),2) BLN, '20' TGL FROM dil_listrik_new";
                $hasil = $this->db->query($sql);
                $lcno = 0;
                foreach ($hasil->result() as $r)
                {
                    $THBLREK= $r->THBLREK;
                    $TH		= $r->TH;
                    $BLN	= $r->BLN;
					$TGL	= $r->TGL;
				}
		$T = date("Ym", mktime(0,0,0,$BLN+1, $TGL, $TH));
		return $T;
	}

	function get_thblrektarifplus(){
		$sql = "SELECT MAX(THBLREK) THBLREK, LEFT(MAX(THBLREK),4) TH, RIGHT(MAX(THBLREK),2) BLN, '20' TGL FROM tr_tarif";
                $hasil = $this->db->query($sql);
                $lcno = 0;
                foreach ($hasil->result() as $r)
                {
                    $THBLREK= $r->THBLREK;
                    $TH		= $r->TH;
                    $BLN	= $r->BLN;
					$TGL	= $r->TGL;
				}
		$T = date("Ym", mktime(0,0,0,$BLN+1, $TGL, $TH));
		return $T;
	}

	public function uploadtarifdasar(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrektarifplus();
			$this->load->view('billing/uploadtarifdasar',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function uploadfiletarif(){
		set_time_limit(0);
		$fileName = $this->input->post('file', TRUE);

		$config['upload_path'] = './upload/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
		$config['max_size'] = 10000;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','Ada kesalah dalam upload');
		} else {
				$media = $this->upload->data();
				$inputFileName = 'upload/'.$media['file_name'];

			try {
				$inputFileType = IOFactory::identify($inputFileName);
				$objReader = IOFactory::createReader($inputFileType);
				$objPHPExcel = $objReader->load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}

			$rowData = $objPHPExcel->getActiveSheet()->toArray(NULL,TRUE,TRUE,TRUE);
			$highestRow = count($rowData);
			$highestColumn = $highestRow-1;
			for ($row = 2; $row < ($highestRow+1); $row++){
				$data = array(
						"THBLTARIF"=> (empty($rowData[$row]["A"])) ? '0' : $rowData[$row]["A"],
						"THBLREK"=> (empty($rowData[$row]["B"])) ? '0' : $rowData[$row]["B"],
						"KD_TARIF"=> $rowData[$row]["C"],
						"KLMPK_TEGANGAN"=> (empty($rowData[$row]["D"])) ? '0' : $rowData[$row]["D"],
						"KLMPK_PHASA"=> (empty($rowData[$row]["E"])) ? '0' : $rowData[$row]["E"],
						"URAIAN"=> (empty($rowData[$row]["F"])) ? '0' : $rowData[$row]["F"],
						"BTS_DAYA"=> (empty($rowData[$row]["G"])) ? '0' : $rowData[$row]["G"],
						"RP_LWBP"=> (empty($rowData[$row]["H"])) ? '0' : $rowData[$row]["H"],
						"RP_WBP"=> (empty($rowData[$row]["I"])) ? '0' : $rowData[$row]["I"],
						"RP_KVARH"=> (empty($rowData[$row]["J"])) ? '0' : $rowData[$row]["J"]
				);
				$this->db->insert("TR_TARIF",$data);
			}
			$this->session->set_flashdata('msg','Berhasil upload ...!!');
			redirect('billing/uploadtarifdasar');
		}
	}

	function downloadformatexceltarifdasar($tbrek=''){
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBLTARIF')
            ->setCellValue('B1', 'THBLREK')
            ->setCellValue('C1', 'KD_TARIF')
            ->setCellValue('D1', 'KLMPK_TEGANGAN')
            ->setCellValue('E1', 'KLMPK_PHASA')
            ->setCellValue('F1', 'URAIAN')
            ->setCellValue('G1', 'BTS_DAYA')
            ->setCellValue('H1', 'RP_LWBP')
            ->setCellValue('I1', 'RP_WBP')
            ->setCellValue('J1', 'RP_KVARH');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "select THBLTARIF, THBLREK, KD_TARIF, KLMPK_TEGANGAN, KLMPK_PHASA, URAIAN, BTS_DAYA, RP_LWBP, RP_WBP, RP_KVARH from v_tr_tarif";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $this->get_thblrek());
            $ex->setCellValue('B'.$counter, $this->get_thblrekplus());
            $ex->setCellValue('C'.$counter, $row->KD_TARIF);
            $ex->setCellValue('D'.$counter, $row->KLMPK_TEGANGAN);
            $ex->setCellValue('E'.$counter, $row->KLMPK_PHASA);
            $ex->setCellValue('F'.$counter, $row->URAIAN);
            $ex->setCellValue('G'.$counter, $row->BTS_DAYA);
            $ex->setCellValue('H'.$counter, '');
            $ex->setCellValue('I'.$counter, '');
            $ex->setCellValue('J'.$counter, '');

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("Tarif Dasar")
            ->setSubject("Tarif Dasar")
            ->setDescription("Tarif Dasar by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Tarif Dasar");
        $objPHPExcel->getActiveSheet()->setTitle('Stand AKhir');
        $TitlE 		= "Format Excel Untuk Upload Tarif Dasar $tbrek";
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

	public function tarif_list()
	{
		$list = $this->billingm->get_datatablesx();
		$data = array();
		$no = $_POST['start'];
		$n = 1;
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $n++;
			$row[] = $billing->KD_TARIF;
			$row[] = $billing->BTS_DAYA;
			$row[] = number_format($billing->RP_LWBP,2,',','.');
			$row[] = number_format($billing->RP_WBP,2,',','.');
			$row[] = number_format($billing->RP_KVARH,2,',','.');
			$row[] = $billing->THBLTARIF;
			$row[] = $billing->THBLREK;
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_allx(),
						"recordsFiltered" => $this->billingm->count_filteredx(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function validasidpm(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/validasidpm',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function prosesrollback(){
		$this->db->query("TRUNCATE DPM_LISTRIK_NEW");
		$x = $this->db->query("UPDATE DPM_LISTRIK_REF SET STATUS_DPM='2' ");
		if($x){
			$this->db->query("DELETE FROM BILLING_LISTRIK_REF_PECAHAN WHERE THBLREK IN (SELECT MAX(THBLREK) FROM DPM_LISTRIK_REF) ");
			$this->session->set_flashdata('msg','Berhasil Melakukan ROLLBACK DPM');
			redirect('billing/validasidpm');
		}else{
			$this->session->set_flashdata('msg','Ada kesalahan dalam proses');
			redirect('billing/validasidpm');
		}
	}

	public function validasidpm_list()
	{
		$list = $this->billingm->get_datatablesy();
		$data = array();
		$no = $_POST['start'];
		$n = 1;
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $n++;
			$row[] = $billing->THBLREK;
			$row[] = $billing->ID_LANG;
			$row[] = number_format($billing->PEMLWBP_CATER,2,',','.');
			$row[] = number_format($billing->PEMWBP_CATER,2,',','.');
			$row[] = number_format($billing->PEMKVARH_CATER,2,',','.');
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_ally(),
						"recordsFiltered" => $this->billingm->count_filteredy(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function hitungrekening(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/hitungrekening',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function proseshitungrekening(){
		set_time_limit(0);

		$q = $this->db->query("SELECT * FROM BILLING_LISTRIK_REF");
		foreach ($q->result() as $r)
		{
			#DEKLARASI DATA
			$THBLREK			= $r->THBLREK;
			$ID_LANG			= $r->ID_LANG;
			$TARIF				= $r->TARIF;
			$DAYA				= $r->DAYA;
			$KD_JAMNYALA_EMIN	= $r->KD_JAMNYALA_EMIN;
			$KD_PPJ				= $r->KD_PPJ;
			$KD_BK				= $r->KD_BK;
			$STATUS_PECAHAN		= $r->STATUS_PECAHAN;

			$PEMLWBP_CATER		= $r->PEMLWBP_CATER;
			$PEMWBP_CATER		= $r->PEMWBP_CATER;
			$PEMKVARH_CATER		= $r->PEMKVARH_CATER;
			$PEMKWH_CATER		= $r->PEMKWH_CATER;
			$JAM_NYALA_CATER	= $r->JAM_NYALA_CATER;

			#AMBIL KODE Tunggal Ganda
			$q = $this->db->query("SELECT KD_TG FROM DIL_LISTRIK_NEW WHERE ID_LANG='$ID_LANG' ");
			foreach($q->result() as $r){
					$TG = $r->KD_TG;
			}
			#NILAI MASING2 TARIF
			$q2 = $this->db->query("SELECT THBLREK, RP_LWBP, RP_WBP, RP_KVARH
									FROM TR_TARIF
									WHERE KD_TARIF = '$TARIF' AND THBLREK = (SELECT MAX(THBLREK) FROM BILLING_LISTRIK_REF ) ");
			foreach($q2->result() as $r){
				$TARIF_LWBP 	= (empty($r->RP_LWBP)) ? '0' : $r->RP_LWBP;
				$TARIF_WBP 		= (empty($r->RP_WBP)) ? '0' : $r->RP_WBP;
				$TARIF_KVARH 	= (empty($r->RP_KVARH)) ? '0' : $r->RP_KVARH;
			}

			#NILAI_JAMNYALA_EMIN
			$q3 = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$KD_JAMNYALA_EMIN' ");
			foreach($q3->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			#NILAI_PPJ
			$NILAI_PPJX = ROUND($KD_PPJ,2)/100;
			$NILAI_PPJ  = ROUND($NILAI_PPJX,4);
			#NILAI_BK
			$q4 = $this->db->query("SELECT bsr_bk
									FROM TR_BK
									WHERE kd_bk = '$KD_BK' ");
			foreach($q4->result() as $r){
				$NILAI_BK = (empty($r->bsr_bk)) ? '0' : $r->bsr_bk;
			}

			#BIAYA ANGSURAN ATAU TITIPAN
			$q6 = $this->db->query("SELECT
										sum(RP_BP) as RP_BP,
										sum(RP_UJL) as RP_UJL,
										sum(RP_BK) as RP_BK,
										sum(RP_KWH) as RP_KWH,
										sum(RP_P2TL) as RP_P2TL,
										sum(RP_INVESTASI) as RP_INVESTASI,
										sum(RP_METERAI) as RP_METERAI
									FROM TP_ANGSURAN
									WHERE THBLREK = '$THBLREK' AND ID_LANG= '$ID_LANG'
									GROUP BY ID_LANG ");

			if($q6->num_rows() > 0 ){
				foreach($q6->result() as $r){
					$RP_BP	= (empty($r->RP_BP)) ? '0' : $r->RP_BP;
					$RP_UJL	= (empty($r->RP_UJL)) ? '0' : $r->RP_UJL;
					$RP_BK	= (empty($r->RP_BK)) ? '0' : $r->RP_BK;
					$RP_KWH	= (empty($r->RP_KWH)) ? '0' : $r->RP_KWH;
					$RP_P2TL 		= (empty($r->RP_P2TL)) ? '0' : $r->RP_P2TL;
					$RP_INVESTASI	= (empty($r->RP_INVESTASI)) ? '0' : $r->RP_INVESTASI;
					$RP_METERAI	= (empty($r->RP_METERAI)) ? '0' : $r->RP_METERAI;

					$RPANGSURAN = $RP_BP + $RP_UJL + $RP_BK + $RP_KWH + $RP_P2TL + $RP_INVESTASI + $RP_METERAI;
				}
			}else{

				$RPANGSURAN = 0;
			}

			#PENETAPAN TANGGAL JATUH TEMPO, KEPADA PELANGGAN KOGOL 0 DAN 4
			$q = $this->db->query("SELECT *
									FROM TR_AKHIR_PERIODEBAYAR
									WHERE THBLREK = '$THBLREK' ");
			foreach($q->result() as $r){
				$TGLJTTEMPO = (empty($r->TGL_AKHIR)) ? '0' : $r->TGL_AKHIR;
			}

			#PROSES HITUNG REKENING LISTRIK
			switch ($STATUS_PECAHAN) {
				case "ADA":
					$q = $this->db->query("SELECT KD_MUT FROM DIL_LISTRIK_REF
											WHERE ID_LANG = '$ID_LANG' ")->result();
					#JIKA PASANG BARU KD_MUT DARI TP_AGENDA
					if(empty($q)){
						$q = $this->db->query("SELECT KD_MUT FROM TP_AGENDA
											WHERE ID_LANG = '$ID_LANG' ");
							foreach($q->result() as $r){
								$KD_MUT	= $r->KD_MUT;
							}
					}else{
						$q = $this->db->query("SELECT KD_MUT FROM DIL_LISTRIK_REF
											WHERE ID_LANG = '$ID_LANG' ");
							foreach($q->result() as $r){
								$KD_MUT	= $r->KD_MUT;
							}
					}

					#PENGAMBILAN DATA PECAHAN
					$q5 = $this->db->query("SELECT * FROM BILLING_LISTRIK_REF_PECAHAN
											WHERE ID_LANG = '$ID_LANG' AND THBLREK = '$THBLREK' ");
					foreach($q5->result() as $r){
						$DAYA_LAMA			= $r->DAYA_LAMA;
						$TARIF_LAMA			= $r->TARIF_LAMA;
						$KWHEMIN_AB			= $r->KWHEMIN_AB;
						$LWBP_MAB			= $r->LWBP_MAB;
						$WBP_MAB			= $r->WBP_MAB;
						$KVARH_MAB			= $r->KVARH_MAB;
						$KWH_MAB			= $r->KWH_MAB;
						$NILAI_JAMNYALA_EMIN_LAMA = $r->NILAI_JAMNYALA_EMIN_LAMA;

						$KWHEMIN_PA			= $r->KWHEMIN_PA;
						$LWBP_MPA			= $r->LWBP_MPA;
						$WBP_MPA			= $r->WBP_MPA;
						$KVARH_MPA			= $r->KVARH_MPA;
						$KWH_MPA			= $r->KWH_MPA;
					}

					if($KD_MUT == 'A')
					{
					#PELANGGAN PASANG BARU
						#KWH EMIN
						$KWH_EMIN = $KWHEMIN_PA;

						#KWH TAGIH LWBP DAN WBP
						if($KWH_EMIN > $PEMKWH_CATER)
						{
							$KWHLWBP 	= ($KWH_EMIN - $PEMKWH_CATER) + $PEMLWBP_CATER;
							$KWHWBP 	= $PEMWBP_CATER;
							$PEMKWH 	= $KWHLWBP + $KWHWBP;
						}
						else
						{
							$KWHLWBP 	= $PEMLWBP_CATER;
							$KWHWBP 	= $PEMWBP_CATER;
							$PEMKWH 	= $KWHLWBP + $KWHWBP;
						}

						#KLBKVARH
						$PEMKWH_CATERX = ROUND(($PEMKWH_CATER * 0.62),2);
						$RMSPEMKWH_CATER = ROUND($PEMKWH_CATERX);
						$HITUNG_KVARH 	= $PEMKVARH_CATER - $RMSPEMKWH_CATER;
						if($HITUNG_KVARH > 0)
						{
							$KLBKVARH = $HITUNG_KVARH;
						}
						else
						{
							$KLBKVARH = 0;
						}

						#PERHITUNGAN RUPIAH
						$RPLWBPX 	= ROUND(($KWHLWBP * ROUND($TARIF_LWBP,1)),2);
						$RPLWBP		= ROUND($RPLWBPX);
						$RPWBPX 	= ROUND(($KWHWBP * ROUND($TARIF_WBP,1)),2);
						$RPWBP		= ROUND($RPWBPX);
						$RPKVARHX	= ROUND(($KLBKVARH * ROUND($TARIF_KVARH,1)),2);
						$RPKVARH	= ROUND($RPKVARHX);
						$RPBEBAN	= 0; //BELUM TAU
						$RPPTL		= $RPLWBP + $RPWBP + $RPKVARH;
						$RPPPNX		= ROUND(( $RPPTL * (10/100)),2); //RPPTL x 10%
						$RPPPN		= ROUND($RPPPNX);
						$RPBPJUX	= ROUND(($RPPTL * $NILAI_PPJ),2);
						$RPBPJU		= ROUND($RPBPJUX);
						$RPTRAFO	= 0; //BELUM TAU


						#BIAYA EPI DAN BIAYA LAIN LAIN
						$RP_EPI		= $RPPTL + $RPANGSURAN;
						$RPDISCOUNT	= 0; //BELUM TAU

						#BIAYA METERAI
						if($RP_EPI > 1000000)
						{
							$RPMAT = 6000;
						}
						else if($RP_EPI > 250000)
						{
							$RPMAT = 3000;
						}
						else
						{
							$RPMAT = 0;
						}

						#HASIL AKHIR
						$RPTAG = $RP_EPI + $RPBPJU + $RPMAT;

						#BIAYA KETERLAMBATAN / DENDA
						if($KD_BK == 'X')
						{
							$RPBK1 = 0;
							$RPBK2 = 2*$RPBK1;
							$RPBK3 = 3*$RPBK1;
						}
						else
						{
							$RPBK1X = ROUND( ($RPPTL * $NILAI_BK),2);
							$RPBK1 = ROUND($RPBK1X);
							$RPBK2 = 2*$RPBK1;
							$RPBK3 = 3*$RPBK1;
						}

						#UPDATE -> BILLING_LISTRIK_REF
						$this->db->query("UPDATE BILLING_LISTRIK_REF SET
											TARIF_LWBP			= '$TARIF_LWBP',
											TARIF_WBP			= '$TARIF_WBP',
											TARIF_KVARH			= '$TARIF_KVARH',
											KWH_EMIN			= '$KWH_EMIN',
											KWHLWBP				= '$KWHLWBP',
											KWHWBP				= '$KWHWBP',
											PEMKWH				= '$PEMKWH',
											KLBKVARH			= '$KLBKVARH',
											RPLWBP				= '$RPLWBP',
											RPWBP				= '$RPWBP',
											RPKVARH				= '$RPKVARH',
											RPBEBAN				= '$RPBEBAN',
											RPPTL				= '$RPPTL',
											RPPPN				= '$RPPPN',
											RPBPJU				= '$RPBPJU',
											RPTRAFO				= '$RPTRAFO',
											RPANGSURAN			= '$RPANGSURAN',
											RPMAT				= '$RPMAT',
											RP_EPI				= '$RP_EPI',
											RPDISCOUNT			= '$RPDISCOUNT',
											RPTAG				= '$RPTAG',
											TGLJTTEMPO			= '$TGLJTTEMPO',
											RPBK1				= '$RPBK1',
											RPBK2				= '$RPBK2',
											RPBK3				= '$RPBK3',
											STATUS_BILLING 		= '1',
											TGL_STATUSBILLING	= NOW()
										WHERE ID_LANG='$ID_LANG' ");

						#UPDATE -> BILLING_LISTRIK_REF_PECAHAN
						$this->db->query("UPDATE BILLING_LISTRIK_REF_PECAHAN SET
											TR_LWBP_BARU		= '$TARIF_LWBP',
											TR_WBP_BARU			= '$TARIF_WBP',
											TR_KVARH_BARU		= '$TARIF_KVARH',
											LWBP_TPA			= '$KWHLWBP',
											WBP_TPA				= '$KWHWBP',
											KWH_TPA				= '$PEMKWH',
											KLBKVARH_TPA		= '$KLBKVARH',
											RPLWBP_TPA			= '$RPLWBP',
											RPWBP_TPA			= '$RPWBP',
											RPKVARH_TPA			= '$RPKVARH',
											RPPTL_TPA			= '$RPPTL'
										WHERE ID_LANG = '$ID_LANG' AND THBLREK = '$THBLREK' ");

					}
					else
					{
					#PELANGGAN BUKAN PASANG BARU

					#AWAL - BONGKAR
						#KWH TAGIH LWBP DAN WBP -> AB
						if($KWHEMIN_AB > $KWH_MAB)
						{
							$LWBP_TAB 	= ($KWHEMIN_AB - $KWH_MAB) + $LWBP_MAB;
							$WBP_TAB 	= $WBP_MAB;
							$KWH_TAB 	= $LWBP_TAB + $WBP_TAB;
						}
						else
						{
							$LWBP_TAB 	= $LWBP_MAB;
							$WBP_TAB 	= $WBP_MAB;
							$KWH_TAB 	= $LWBP_TAB + $WBP_TAB;
						}

						#KLBKVARH -> AB
						$KWH_MABX = ROUND(($KWH_MAB * 0.62),2);
						$RMSKWH_MAB = ROUND($KWH_MABX);
						$HITUNG_KVARH_AB 	= $KVARH_MAB - $RMSKWH_MAB;
						if($HITUNG_KVARH_AB > 0)
						{
							$KLBKVARH_TAB = $HITUNG_KVARH_AB;
						}
						else
						{
							$KLBKVARH_TAB = 0;
						}

					#AMBIL TARIF LAMA (BULAN SEBELUMNYA)
						$q6 = $this->db->query("SELECT THBLREK, RP_LWBP, RP_WBP, RP_KVARH
												FROM TR_TARIF
												WHERE KD_TARIF = '$TARIF_LAMA' AND THBLREK = (SELECT MAX(THBLREK) FROM DIL_LISTRIK_REF ) ");

						foreach($q6->result() as $r){
							$TR_LWBP_LAMA 	= (empty($r->RP_LWBP)) ? '0' : $r->RP_LWBP;
							$TR_WBP_LAMA	= (empty($r->RP_WBP)) ? '0' : $r->RP_WBP;
							$TR_KVARH_LAMA 	= (empty($r->RP_KVARH)) ? '0' : $r->RP_KVARH;
						}

					#PERHITUNGAN RUPIAH -> AB
						$RPLWBP_TABX	= ROUND(($LWBP_TAB * $TR_LWBP_LAMA),2);
						$RPLWBP_TAB		= ROUND($RPLWBP_TABX);
						$RPWBP_TABX		= ROUND(($WBP_TAB * $TR_WBP_LAMA),2);
						$RPWBP_TAB		= ROUND($RPWBP_TABX);
						$RPKVARH_TABX	= ROUND(($KLBKVARH_TAB * $TR_KVARH_LAMA),2);
						$RPKVARH_TAB	= ROUND($RPKVARH_TABX);
						$RPPTL_TAB		= $RPLWBP_TAB + $RPWBP_TAB + $RPKVARH_TAB;

					#PASANG - AKHIR
						#KWH TAGIH LWBP DAN WBP -> PA
						if($KWHEMIN_PA > $KWH_MPA)
						{
							$LWBP_TPA 	= ($KWHEMIN_PA - $KWH_MPA) + $LWBP_MPA;
							$WBP_TPA 	= $WBP_MPA;
							$KWH_TPA 	= $LWBP_TPA + $WBP_TPA;
						}
						else
						{
							$LWBP_TPA 	= $LWBP_MPA;
							$WBP_TPA 	= $WBP_MPA;
							$KWH_TPA 	= $LWBP_TPA + $WBP_TPA;
						}

						#KLBKVARH -> PA
						$KWH_MPAX = ROUND(($KWH_MPA * 0.62),2);
						$RMSKWH_MPA = ROUND($KWH_MPAX);
						$HITUNG_KVARH_PA 	= $KVARH_MPA - $RMSKWH_MPA;
						if($HITUNG_KVARH_PA > 0)
						{
							$KLBKVARH_TPA = $HITUNG_KVARH_PA;
						}
						else
						{
							$KLBKVARH_TPA = 0;
						}

						#AMBIL TARIF BARU (BULAN REK INI)
						$TR_LWBP_BARU 	= $TARIF_LWBP;
						$TR_WBP_BARU	= $TARIF_WBP;
						$TR_KVARH_BARU 	= $TARIF_KVARH;

						#PERHITUNGAN RUPIAH -> PA
						$RPLWBP_TPAX	= ROUND(($LWBP_TPA * $TR_LWBP_BARU),2);
						$RPLWBP_TPA		= ROUND($RPLWBP_TPAX);
						$RPWBP_TPAX		= ROUND(($WBP_TPA * $TR_WBP_BARU),2);
						$RPWBP_TPA		= ROUND($RPWBP_TPAX);
						$RPKVARH_TPAX	= ROUND(($KLBKVARH_TPA * $TR_KVARH_BARU),2);
						$RPKVARH_TPA	= ROUND($RPKVARH_TPAX);
						$RPPTL_TPA		= $RPLWBP_TPA + $RPWBP_TPA + $RPKVARH_TPA;

					#PERHITUNGAN RUPIAH
						#GABUNGAN KWH TAGIH
						$KWH_EMIN = $KWHEMIN_AB + $KWHEMIN_PA;
						if($TG == 'T')
						{
							$KWHLWBP = $LWBP_TAB + $LWBP_TPA + $WBP_TAB ;
							$KWHWBP = 0;
							$KLBKVARH = 0;
						}
						else
						{
							$KWHLWBP = $LWBP_TAB + $LWBP_TPA;
							$KWHWBP = $WBP_TAB + $WBP_TPA;
							$KLBKVARH = $KLBKVARH_TAB + $KLBKVARH_TPA;
						}
						$PEMKWH		= $KWH_TAB + $KWH_TPA;

						#GABUNGAN PERHITUNGAN RUPIAH
						if($TG == 'T')
						{
							$RPLWBP = $RPLWBP_TAB + $RPLWBP_TPA + $RPWBP_TAB ;
							$RPWBP = 0;
							$RPKVARH = 0;
						}
						else
						{
							$RPLWBP 	= $RPLWBP_TAB + $RPLWBP_TPA;
							$RPWBP 		= $RPWBP_TAB + $RPWBP_TPA;
							$RPKVARH 	= $RPKVARH_TAB + $RPKVARH_TPA;
						}
						#$RPPTL		= $RPPTL_TAB + $RPPTL_TPA;
						$RPPTL		= $RPLWBP + $RPWBP + $RPKVARH;

						$RPBEBAN	= 0; //BELUM TAU
						$RPPPNX		= ROUND( ($RPPTL * (10/100)),2); //RPPTL x 10%
						$RPPPN		= ROUND($RPPPN);
						$RPBPJUX	= ROUND(($RPPTL * $NILAI_PPJ),2);
						$RPBPJU		= ROUND($RPBPJUX);
						$RPTRAFO	= 0; //BELUM TAU


						#BIAYA EPI DAN BIAYA LAIN LAIN
						$RP_EPI		= $RPPTL + $RPANGSURAN;
						$RPDISCOUNT	= 0; //BELUM TAU

						#BIAYA METERAI
						if($RP_EPI > 1000000)
						{
							$RPMAT = 6000;
						}
						else if($RP_EPI > 250000)
						{
							$RPMAT = 3000;
						}
						else
						{
							$RPMAT = 0;
						}

						#HASIL AKHIR
						$RPTAG = $RP_EPI + $RPBPJU + $RPMAT;

						#BIAYA KETERLAMBATAN / DENDA
						if($KD_BK == 'X')
						{
							$RPBK1 = 0;
							$RPBK2 = 2*$RPBK1;
							$RPBK3 = 3*$RPBK1;
						}
						else
						{
							$RPBK1X = ROUND( ($RPPTL * $NILAI_BK),2);
							$RPBK1	= ROUND($RPBK1X);
							$RPBK2 = 2*$RPBK1;
							$RPBK3 = 3*$RPBK1;
						}

						#UPDATE -> BILLING_LISTRIK_REF
						$this->db->query("UPDATE BILLING_LISTRIK_REF SET
											TARIF_LWBP			= '$TARIF_LWBP',
											TARIF_WBP			= '$TARIF_WBP',
											TARIF_KVARH			= '$TARIF_KVARH',
											KWH_EMIN			= '$KWH_EMIN',
											KWHLWBP				= '$KWHLWBP',
											KWHWBP				= '$KWHWBP',
											PEMKWH				= '$PEMKWH',
											KLBKVARH			= '$KLBKVARH',
											RPLWBP				= '$RPLWBP',
											RPWBP				= '$RPWBP',
											RPKVARH				= '$RPKVARH',
											RPBEBAN				= '$RPBEBAN',
											RPPTL				= '$RPPTL',
											RPPPN				= '$RPPPN',
											RPBPJU				= '$RPBPJU',
											RPTRAFO				= '$RPTRAFO',
											RPANGSURAN			= '$RPANGSURAN',
											RPMAT				= '$RPMAT',
											RP_EPI				= '$RP_EPI',
											RPDISCOUNT			= '$RPDISCOUNT',
											RPTAG				= '$RPTAG',
											TGLJTTEMPO			= '$TGLJTTEMPO',
											RPBK1				= '$RPBK1',
											RPBK2				= '$RPBK2',
											RPBK3				= '$RPBK3',
											STATUS_BILLING 		= '1',
											TGL_STATUSBILLING	= NOW()
										WHERE ID_LANG='$ID_LANG' ");

						#UPDATE -> BILLING_LISTRIK_REF_PECAHAN
						$this->db->query("UPDATE BILLING_LISTRIK_REF_PECAHAN SET
											TR_LWBP_LAMA		= '$TR_LWBP_LAMA',
											TR_WBP_LAMA			= '$TR_WBP_LAMA',
											TR_KVARH_LAMA		= '$TR_KVARH_LAMA',
											LWBP_TAB			= '$LWBP_TAB',
											WBP_TAB				= '$WBP_TAB',
											KWH_TAB				= '$KWH_TAB',
											KLBKVARH_TAB		= '$KLBKVARH_TAB',
											RPLWBP_TAB			= '$RPLWBP_TAB',
											RPWBP_TAB			= '$RPWBP_TAB',
											RPKVARH_TAB			= '$RPKVARH_TAB',
											RPPTL_TAB			= '$RPPTL_TAB',

											TR_LWBP_BARU		= '$TR_LWBP_BARU',
											TR_WBP_BARU			= '$TR_WBP_BARU',
											TR_KVARH_BARU		= '$TR_KVARH_BARU',
											LWBP_TPA			= '$LWBP_TPA',
											WBP_TPA				= '$WBP_TPA',
											KWH_TPA				= '$KWH_TPA',
											KLBKVARH_TPA		= '$KLBKVARH_TPA',
											RPLWBP_TPA			= '$RPLWBP_TPA',
											RPWBP_TPA			= '$RPWBP_TPA',
											RPKVARH_TPA			= '$RPKVARH_TPA',
											RPPTL_TPA			= '$RPPTL_TPA'
										WHERE ID_LANG = '$ID_LANG' AND THBLREK = '$THBLREK' ");

					}

					break;
				case "TIDAK":
					#KWH EMIN
					$KWH_EMINX = ROUND((($DAYA / 1000)*$NILAI_JAMNYALA_EMIN),2);
					$KWH_EMIN  = ROUND($KWH_EMINX);

					#KWH TAGIH LWBP DAN WBP
					if($KWH_EMIN > $PEMKWH_CATER) //259800 > 189660
					{
						$KWHLWBP 	= ($KWH_EMIN - $PEMKWH_CATER) + $PEMLWBP_CATER;
						$KWHWBP 	= $PEMWBP_CATER;
						$PEMKWH 	= $KWHLWBP + $KWHWBP;
					}
					else
					{
						$KWHLWBP 	= $PEMLWBP_CATER;
						$KWHWBP 	= $PEMWBP_CATER;
						$PEMKWH 	= $KWHLWBP + $KWHWBP;
					}

					#KLBKVARH
					$PEMKWH_CATERX  = ROUND(($PEMKWH_CATER * 0.62),2);
					$RMSPEMKWH_CATER=ROUND($PEMKWH_CATERX);
					$HITUNG_KVARH 	= $PEMKVARH_CATER - $RMSPEMKWH_CATER;
					if($HITUNG_KVARH > 0)
					{
						$KLBKVARH = $HITUNG_KVARH;
					}
					else
					{
						$KLBKVARH = 0;
					}

					#PERHITUNGAN RUPIAH
					$RPLWBPX 	= ROUND(($KWHLWBP * $TARIF_LWBP),2);
					$RPLWBP		= ROUND($RPLWBPX);
					$RPWBPX		= ROUND(($KWHWBP * $TARIF_WBP),2);
					$RPWBP		= ROUND($RPWBPX);
					$RPKVARHX	= ROUND(($KLBKVARH * $TARIF_KVARH),2);
					$RPKVARH	= ROUND($RPKVARHX);
					$RPBEBAN	= 0; //BELUM TAU
					$RPPTL		= $RPLWBP + $RPWBP + $RPKVARH;
					$RPPPNX		= ROUND(($RPPTL * (10/100)),2); //RPPTL x 10%
					$RPPPN		= ROUND($RPPPNX);
					$RPBPJUX	= ROUND(($RPPTL * $NILAI_PPJ),2);
					$RPBPJU		= ROUND($RPBPJUX);
					$RPTRAFO	= 0; //BELUM TAU


					#BIAYA EPI DAN BIAYA LAIN LAIN
					$RP_EPI		= $RPPTL + $RPANGSURAN;
					$RPDISCOUNT	= 0;

					#BIAYA METERAI
					if($RP_EPI > 1000000)
					{
						$RPMAT = 6000;
					}
					else if($RP_EPI > 250000)
					{
						$RPMAT = 3000;
					}
					else
					{
						$RPMAT = 0;
					}

					#HASIL AKHIR
					$RPTAG = $RP_EPI + $RPBPJU + $RPMAT;

					#BIAYA KETERLAMBATAN / DENDA
					if($KD_BK == 'X')
					{
						$RPBK1 = 0;
						$RPBK2 = 2*$RPBK1;
						$RPBK3 = 3*$RPBK1;
					}
					else
					{
						$RPBK1X = ROUND(($RPPTL * $NILAI_BK),2);
						$RPBK1  = ROUND($RPBK1X);
						$RPBK2 = 2*$RPBK1;
						$RPBK3 = 3*$RPBK1;
					}

					$this->db->query("UPDATE BILLING_LISTRIK_REF SET
										TARIF_LWBP			= '$TARIF_LWBP',
										TARIF_WBP			= '$TARIF_WBP',
										TARIF_KVARH			= '$TARIF_KVARH',
										KWH_EMIN			= '$KWH_EMIN',
										KWHLWBP				= '$KWHLWBP',
										KWHWBP				= '$KWHWBP',
										PEMKWH				= '$PEMKWH',
										KLBKVARH			= '$KLBKVARH',
										RPLWBP				= '$RPLWBP',
										RPWBP				= '$RPWBP',
										RPKVARH				= '$RPKVARH',
										RPBEBAN				= '$RPBEBAN',
										RPPTL				= '$RPPTL',
										RPPPN				= '$RPPPN',
										RPBPJU				= '$RPBPJU',
										RPTRAFO				= '$RPTRAFO',
										RPANGSURAN			= '$RPANGSURAN',
										RPMAT				= '$RPMAT',
										RP_EPI				= '$RP_EPI',
										RPDISCOUNT			= '$RPDISCOUNT',
										RPTAG				= '$RPTAG',
										TGLJTTEMPO			= '$TGLJTTEMPO',
										RPBK1				= '$RPBK1',
										RPBK2				= '$RPBK2',
										RPBK3				= '$RPBK3',
										STATUS_BILLING 		= '1',
										TGL_STATUSBILLING	= NOW()
									WHERE ID_LANG='$ID_LANG' ");

					break;
				default:
					$this->session->set_flashdata('msg','Ada kesalah dalam proses hitung Rekening');
			}
		}
	}

	public function hitung_list()
	{
		$list = $this->billingm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $billing->THBLREK;
			$row[] = $billing->ID_LANG;
			$row[] = $billing->NAMA_LANG;
			$row[] = number_format($billing->RPLWBP,0,',','.');
			$row[] = number_format($billing->RPWBP,0,',','.');
			$row[] = number_format($billing->RPKVARH,0,',','.');
			$row[] = number_format($billing->RPPTL,0,',','.');
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_all(),
						"recordsFiltered" => $this->billingm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function koreksirekawal(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/koreksirekawal',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function carilang($idcari=''){
		$data_langganan = $this->billingm->get_langganan($idcari);
		echo json_encode($data_langganan);
	}

	public function proseshitungrekeningperlang($idcari,$pemlwbpcat,$pemwbpcat,$pemkvarhcat,$pemkwhcat){
		$data_hitung = $this->billingm->proseshitungrekeningperlang($idcari,$pemlwbpcat,$pemwbpcat,$pemkvarhcat,$pemkwhcat);
		echo json_encode($data_hitung);
	}
	
	public function prosessimpanrekeningperlang($idcari,$stawallwbp,$stawalwbp,$stawalkvarh,$stbkrlwbp,$stbkrwbp,$stbkrkvarh,$stpsglwbp,$stpsgwbp,$stpsgkvarh,$stakhirlwbp,$stakhirwbp,$stakhirkvarh){
		$sekarang = date("Y-m-d H:i:s");
		$namauser = $this->session->userdata('nama');
		$datalog = array(
			'THBLREK' => $this->input->post('thblrek'),
			'ID_LANG' => $this->input->post('id_lang'),
			'TGL_BACA_AWAL_BEFORE' => $this->input->post('tgl_baca_awalbefore'),
			'STAND_AWAL_LWBP_BEFORE' => $this->input->post('stand_awal_lwbpbefore'),
			'STAND_AWAL_WBP_BEFORE' => $this->input->post('stand_awal_wbpbefore'),
			'STAND_AWAL_KVARH_BEFORE' => $this->input->post('stand_awal_kvarhbefore'),
			'TGL_BACA_AWAL_AFTER' => $this->input->post('tgl_baca_awal'),
			'STAND_AWAL_LWBP_AFTER' => $this->input->post('stand_awal_lwbp'),
			'STAND_AWAL_WBP_AFTER' => $this->input->post('stand_awal_wbp'),
			'STAND_AWAL_KVARH_AFTER' => $this->input->post('stand_awal_kvarh'),
			
			'STAND_BKR_LWBP_BEFORE' => $this->input->post('stand_bkr_lwbpbefore'),
			'STAND_BKR_WBP_BEFORE' => $this->input->post('stand_bkr_wbpbefore'),
			'STAND_BKR_KVARH_BEFORE' => $this->input->post('stand_bkr_kvarhbefore'),
			'STAND_BKR_LWBP_AFTER' => $this->input->post('stand_bkr_lwbp'),
			'STAND_BKR_WBP_AFTER' => $this->input->post('stand_bkr_wbp'),
			'STAND_BKR_KVARH_AFTER' => $this->input->post('stand_bkr_kvarh'),
			
			'STAND_PSG_LWBP_BEFORE' => $this->input->post('stand_psg_lwbpbefore'),
			'STAND_PSG_WBP_BEFORE' => $this->input->post('stand_psg_wbpbefore'),
			'STAND_PSG_KVARH_BEFORE' => $this->input->post('stand_psg_kvarhbefore'),
			'STAND_PSG_LWBP_AFTER' => $this->input->post('stand_psg_lwbp'),
			'STAND_PSG_WBP_AFTER' => $this->input->post('stand_psg_wbp'),
			'STAND_PSG_KVARH_AFTER' => $this->input->post('stand_psg_kvarh'),
			
			'TGL_BACA_AKHIR_BEFORE' => $this->input->post('tgl_baca_akhirbefore'),
			'STAND_AKHIR_LWBP_BEFORE' => $this->input->post('stand_akhir_lwbpbefore'),
			'STAND_AKHIR_WBP_BEFORE' => $this->input->post('stand_akhir_wbpbefore'),
			'STAND_AKHIR_KVARH_BEFORE' => $this->input->post('stand_akhir_kvarhbefore'),
			'TGL_BACA_AKHIR_AFTER' => $this->input->post('tgl_baca_akhir'),
			'STAND_AKHIR_LWBP_AFTER' => $this->input->post('stand_akhir_lwbp'),
			'STAND_AKHIR_WBP_AFTER' => $this->input->post('stand_akhir_wbp'),
			'STAND_AKHIR_KVARH_AFTER' => $this->input->post('stand_akhir_kvarh'),
			
			'ALASAN_RUBAH' => $this->input->post('alasan_rubah'),
			'USER_RUBAH' => $namauser,
			'TGL_RUBAH' => $sekarang

		);
		$this->db->insert("LOG_KOREKSIREKENING",$datalog);
		
		$data_hitung = $this->billingm->prosessimpanrekeningperlang($idcari);
		echo json_encode(array("status" => TRUE));
	}
	
	public function prosesuploaddpmkoreksi($idcari){
		#Hapus data di DPM NEW sebelum di INSERT
		$delnew= $this->db->query("DELETE FROM DPM_LISTRIK_NEW WHERE ID_LANG='$idcari' ");
		$tonew = $this->db->query("INSERT INTO DPM_LISTRIK_NEW SELECT * FROM DPM_LISTRIK_REF WHERE STATUS_DPM = '2' AND ID_LANG='$idcari' ");
		$ch1   = $this->db->query("UPDATE DPM_LISTRIK_REF SET STATUS_DPM ='3' WHERE ID_LANG = '$idcari' ");
		$ch2   = $this->db->query("UPDATE DPM_LISTRIK_NEW SET STATUS_DPM ='3' WHERE ID_LANG = '$idcari' ");
		#Jika INSERT KE DPM NEW SUKSES MAKA INSERT KE BILLING REF
		IF($tonew){
			$this->db->query("DELETE FROM BILLING_LISTRIK_REF WHERE ID_LANG='$idcari' ");
			$this->db->query("INSERT INTO BILLING_LISTRIK_REF (THBLREK,KD_AREA,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,
									STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,
									STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,
									STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,
									PEMKWH_CATER,JAM_NYALA_CATER, STATUS_PECAHAN)
								SELECT THBLREK,KD_AREA,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,
									STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,
									STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,
									STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,
									PEMKWH_CATER,JAM_NYALA_CATER, STATUS_PECAHAN
								FROM DPM_LISTRIK_NEW
								WHERE STATUS_DPM = '3' AND ID_LANG='$idcari' ");

			$this->db->query("UPDATE BILLING_LISTRIK_REF a
								INNER JOIN
								(
									SELECT ID_LANG, KOGOL, KD_JAMNYALA_EMIN, KD_PPJ, KD_BK
									FROM DIL_LISTRIK_NEW a
								) b ON a.ID_LANG = b.ID_LANG
								SET a.KOGOL = b.KOGOL, a.KD_JAMNYALA_EMIN = b.KD_JAMNYALA_EMIN, a.KD_PPJ = b.KD_PPJ, a.KD_BK = b.KD_BK 
								WHERE a.ID_LANG='$idcari'");

			$this->db->query("UPDATE BILLING_LISTRIK_REF SET STATUS_BILLING = '0' WHERE ID_LANG='$idcari' ");
			#DELETE BILING LISTRIK REF PECAHAN
			$this->db->query("DELETE FROM BILLING_LISTRIK_REF_PECAHAN
								WHERE THBLREK IN (SELECT MAX(THBLREK) FROM DPM_LISTRIK_REF_PECAHAN) AND ID_LANG='$idcari'");
			#INSERT INTO BILLING_LISTRIK_REF_PECAHAN
			$this->db->query("INSERT INTO BILLING_LISTRIK_REF_PECAHAN
								(
									THBLREK,ID_CUST,ID_LANG,DAYA_LAMA,TARIF_LAMA,TGL_MUT,FK_METER_LAMA,FRT_LAMA,SEL_HAR_AB,JAM_NYALA_AB,KWHEMIN_AB,LWBP_MAB,WBP_MAB,KVARH_MAB,KWH_MAB,DAYA_BARU,TARIF_BARU,FK_METER_BARU,FRT_BARU,SEL_HAR_PA,JAM_NYALA_PA,KWHEMIN_PA,LWBP_MPA,WBP_MPA,KVARH_MPA,KWH_MPA,KD_JAMNYALA_EMIN_LAMA,NILAI_JAMNYALA_EMIN_LAMA
								)
								SELECT
									THBLREK,ID_CUST,ID_LANG,DAYA_LAMA,TARIF_LAMA,TGL_MUT,FK_METER_LAMA,FRT_LAMA,SEL_HAR_AB,JAM_NYALA_AB,KWHEMIN_AB,LWBP_MAB,WBP_MAB,KVARH_MAB,KWH_MAB,DAYA_BARU,TARIF_BARU,FK_METER_BARU,FRT_BARU,SEL_HAR_PA,JAM_NYALA_PA,KWHEMIN_PA,LWBP_MPA,WBP_MPA,KVARH_MPA,KWH_MPA,KD_JAMNYALA_EMIN_LAMA,NILAI_JAMNYALA_EMIN_LAMA
								FROM DPM_LISTRIK_REF_PECAHAN
								WHERE THBLREK = (SELECT MAX(THBLREK) FROM DPM_LISTRIK_REF_PECAHAN ) AND ID_LANG='$idcari'
							");
			echo json_encode(array("status" => TRUE));
		}else{
			echo json_encode(array("status" => FALSE));
		}
	}

	public function koreksirekakhir(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/koreksirekakhir',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function monitoringbilling(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/monitoringbilling',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function uploadrekening(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/uploadrekening',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function rekening_list()
	{
		$list = $this->billingm->get_datatablesz();
		$data = array();
		$no = $_POST['start'];
		$n = 1;
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $n++;
			$row[] = $billing->THBLREK;
			$row[] = $billing->ID_LANG;
			$row[] = number_format($billing->RPPTL,2,',','.');
			$row[] = number_format($billing->RPBPJU,2,',','.');
			$rpangsuran = $billing->RPANGSURAN;
			$row[] = number_format($rpangsuran,2,',','.');
			$row[] = number_format($billing->RPTAG,2,',','.');
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_allz(),
						"recordsFiltered" => $this->billingm->count_filteredz(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function prosesuploadrekening(){
		$this->db->query("TRUNCATE BILLING_LISTRIK_NEW");
		#MASUKAN DATA DARI BILLING REF KE BILLING NEW
		$this->db->query("INSERT INTO BILLING_LISTRIK_NEW (
								THBLREK,KD_AREA,KOGOL,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KD_JAMNYALA_EMIN,KD_PPJ,KD_BK,STATUS_PECAHAN,TARIF_LWBP,TARIF_WBP,TARIF_KVARH,KWH_EMIN,KWHLWBP,KWHWBP,PEMKWH,KLBKVARH,RPLWBP,RPWBP,RPKVARH,RPBEBAN,RPPTL,RPPPN,RPBPJU,RPTRAFO,RPANGSURAN,RPMAT,RP_EPI,RPDISCOUNT,RPTAG,TGLJTTEMPO,RPBK1,RPBK2,RPBK3,STATUS_BILLING,TGL_STATUSBILLING)
						SELECT THBLREK,KD_AREA,KOGOL,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KD_JAMNYALA_EMIN,KD_PPJ,KD_BK,STATUS_PECAHAN,TARIF_LWBP,TARIF_WBP,TARIF_KVARH,KWH_EMIN,KWHLWBP,KWHWBP,PEMKWH,KLBKVARH,RPLWBP,RPWBP,RPKVARH,RPBEBAN,RPPTL,RPPPN,RPBPJU,RPTRAFO,RPANGSURAN,RPMAT,RP_EPI,RPDISCOUNT,RPTAG,TGLJTTEMPO,RPBK1,RPBK2,RPBK3,STATUS_BILLING,TGL_STATUSBILLING
							FROM BILLING_LISTRIK_REF WHERE STATUS_BILLING ='1' ");
		$this->db->query("UPDATE BILLING_LISTRIK_NEW SET STATUS_BILLING = '2' ");
		#MASUKAN DATA BILLING NEW KE MASTER REKENING
		$this->db->query("DELETE FROM MASTER_REKENING WHERE THBLREK IN (SELECT DISTINCT THBLREK FROM BILLING_LISTRIK_NEW) ");
		$this->db->query("ALTER TABLE MASTER_REKENING AUTO_INCREMENT = 1");
		$this->db->query("INSERT INTO MASTER_REKENING (THBLREK,KD_AREA,KOGOL,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KD_JAMNYALA_EMIN,KD_PPJ,KD_BK,STATUS_PECAHAN,TARIF_LWBP,TARIF_WBP,TARIF_KVARH,KWH_EMIN,KWHLWBP,KWHWBP,PEMKWH,KLBKVARH,RPLWBP,RPWBP,RPKVARH,RPBEBAN,RPPTL,RPPPN,RPBPJU,RPTRAFO,RPANGSURAN,RPMAT,RPEPI,RPDISCOUNT,RPTAG,TGLJTTEMPO,RPBK1,RPBK2,RPBK3,STATUS_BK,RP_BK,TOTAL_INVOICE,STATUS_REK,TGL_STATUSREK,STATUS_LUNAS)
							SELECT THBLREK,KD_AREA,KOGOL,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KD_JAMNYALA_EMIN,KD_PPJ,KD_BK,STATUS_PECAHAN,TARIF_LWBP,TARIF_WBP,TARIF_KVARH,KWH_EMIN,KWHLWBP,KWHWBP,PEMKWH,KLBKVARH,RPLWBP,RPWBP,RPKVARH,RPBEBAN,RPPTL,RPPPN,RPBPJU,RPTRAFO,RPANGSURAN,RPMAT,RP_EPI,RPDISCOUNT,RPTAG,TGLJTTEMPO,RPBK1,RPBK2,RPBK3,'0' STATUS_BK,'0' RP_BK, RPTAG TOTAL_INVOICE,'L' STATUS_REK,NOW() TGL_STATUSREK,'0' STATUS_LUNAS
							FROM BILLING_LISTRIK_NEW ");
		#PINDAH DATA DIL_NEW KE DIL_REF
		$this->db->query("DELETE FROM DIL_LISTRIK_REF");
		$this->db->query("ALTER TABLE DIL_LISTRIK_REF AUTO_INCREMENT = 1");
		$this->db->query("INSERT INTO DIL_LISTRIK_REF (THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_PDL,NOPEL,IDPEL_PLN,PERUNTUKAN)
							SELECT THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_PDL,NOPEL,IDPEL_PLN,PERUNTUKAN
							FROM DIL_LISTRIK_NEW");
		#PINDAH DATA DIL_NEW KE DIL_LOG
		$this->db->query("DELETE FROM DIL_LISTRIK_LOG WHERE THBLREK IN (SELECT DISTINCT THBLREK FROM DIL_LISTRIK_NEW) ");
		$this->db->query("ALTER TABLE DIL_LISTRIK_LOG AUTO_INCREMENT = 1");
		$this->db->query("INSERT INTO DIL_LISTRIK_LOG (THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_PDL,NOPEL,IDPEL_PLN,PERUNTUKAN)
							SELECT THBLREK,KD_WILAYAH,KD_AREA,ID_CUST,KOGOL,ID_LANG,NAMA_LANG,ALAMAT_LANG,TARIF,DAYA,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,THBLMUT,TGL_MUT,KD_MUT,TGL_NYALA,TGL_PDL,KD_TG,KD_BK,KD_JAMNYALA_EMIN,KD_PPJ,TGL_BP,RP_BP,TGL_UJL,RP_UJL,NO_KWITANSI,NO_PANEL,KD_GT,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,PJG_SM,FASA_SM,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,STATUS_PECAHAN,USER_PDL,NOPEL,IDPEL_PLN,PERUNTUKAN
							FROM DIL_LISTRIK_NEW");
		#PINDAH DATA DPM_NEW KE DPM_LOG
		$this->db->query("DELETE FROM DPM_LISTRIK_LOG WHERE THBLREK IN (SELECT DISTINCT THBLREK FROM DPM_LISTRIK_NEW) ");
		$this->db->query("ALTER TABLE DPM_LISTRIK_LOG AUTO_INCREMENT = 1");
		$this->db->query("INSERT INTO DPM_LISTRIK_LOG
							(THBLREK,ID_CUST,ID_LANG,KD_AREA,TARIF,DAYA,TG,FK_METER,NO_METER,FRT,KD_MUT,THBLMUT,TGL_MUT,TGL_UPLOAD_STAND,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KWH_MIN,KWH_RATA2,KWH_MAX,STATUS_DLPD,USER_ENTRI,NAMA_THBLREK,STATUS_KOREKSI,TGL_KOREKSI,STATUS_DPM,TGL_STATUSDPM,STATUS_PECAHAN,KD_JAMNYALA_EMIN_BARU,NILAI_JAMNYALA_EMIN_BARU )
							SELECT THBLREK,ID_CUST,ID_LANG,KD_AREA,TARIF,DAYA,TG,FK_METER,NO_METER,FRT,KD_MUT,THBLMUT,TGL_MUT,TGL_UPLOAD_STAND,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KWH_MIN,KWH_RATA2,KWH_MAX,STATUS_DLPD,USER_ENTRI,NAMA_THBLREK,STATUS_KOREKSI,TGL_KOREKSI,STATUS_DPM,TGL_STATUSDPM,STATUS_PECAHAN,KD_JAMNYALA_EMIN_BARU,NILAI_JAMNYALA_EMIN_BARU
							FROM DPM_LISTRIK_NEW");
		#PINDAH DATA BILLING NEW KE WS EPI
		$this->db->query("DELETE FROM epi_cargo.ws_epi WHERE THBLREK = (SELECT MAX(THBLREK) FROM epi_dbx.MASTER_REKENING) ");
		$this->db->query("ALTER TABLE epi_cargo.ws_epi AUTO_INCREMENT = 1");
		$this->db->query("INSERT INTO epi_cargo.ws_epi (THBLREK,KD_AREA,KOGOL,ID_CUST,ID_LANG,TARIF,DAYA,TGL_BACA_AWAL,TGL_BACA_AKHIR,STAND_AWAL_LWBP,STAND_BKR_LWBP,STAND_PSG_LWBP,STAND_AKHIR_LWBP,PEMLWBP_CATER,STAND_AWAL_WBP,STAND_BKR_WBP,STAND_PSG_WBP,STAND_AKHIR_WBP,PEMWBP_CATER,STAND_AWAL_KVARH,STAND_BKR_KVARH,STAND_PSG_KVARH,STAND_AKHIR_KVARH,PEMKVARH_CATER,PEMKWH_CATER,JAM_NYALA_CATER,KD_JAMNYALA_EMIN,KD_PPJ,KD_BK,STATUS_PECAHAN,TARIF_LWBP,TARIF_WBP,TARIF_KVARH,KWH_EMIN,KWHLWBP,KWHWBP,PEMKWH,KLBKVARH,RPLWBP,RPWBP,RPKVARH,RPPTL,RPBEBAN,RPTRAFO,RPANGSURAN,RPEPI,RPPPN,RPBPJU,RPMAT,RPDISCOUNT,RPTAG,TGLJTTEMPO,RPBK1,RPBK2,RPBK3,STATUS_BK,RP_BK,TOTAL_INVOICE,STATUS_REK,TGL_STATUSREK,STATUS_LUNAS,TGL_LUNAS,REF_LUNAS,USER_LUNAS,EPIREFNO,NAMA)
							SELECT a.THBLREK,a.KD_AREA,a.KOGOL,a.ID_CUST,a.ID_LANG,a.TARIF,a.DAYA,a.TGL_BACA_AWAL,a.TGL_BACA_AKHIR,a.STAND_AWAL_LWBP,a.STAND_BKR_LWBP,a.STAND_PSG_LWBP,a.STAND_AKHIR_LWBP,a.PEMLWBP_CATER,a.STAND_AWAL_WBP,a.STAND_BKR_WBP,a.STAND_PSG_WBP,a.STAND_AKHIR_WBP,a.PEMWBP_CATER,a.STAND_AWAL_KVARH,a.STAND_BKR_KVARH,a.STAND_PSG_KVARH,a.STAND_AKHIR_KVARH,a.PEMKVARH_CATER,a.PEMKWH_CATER,a.JAM_NYALA_CATER,a.KD_JAMNYALA_EMIN,a.KD_PPJ,a.KD_BK,a.STATUS_PECAHAN,a.TARIF_LWBP,a.TARIF_WBP,a.TARIF_KVARH,a.KWH_EMIN,a.KWHLWBP,a.KWHWBP,a.PEMKWH,a.KLBKVARH,a.RPLWBP,a.RPWBP,a.RPKVARH,a.RPPTL,a.RPBEBAN,a.RPTRAFO,a.RPANGSURAN,a.RPEPI,a.RPPPN,a.RPBPJU,a.RPMAT,a.RPDISCOUNT,a.RPTAG,a.TGLJTTEMPO,a.RPBK1,a.RPBK2,a.RPBK3,'0','0',(RP_BK + RPTAG) TOTAL_INVOICE,'L' STATUS_REK,NOW() TGL_STATUSREK,'0' STATUS_LUNAS,a.TGL_LUNAS,a.REF_LUNAS,a.USER_LUNAS,a.EPIREFNO,b.NAMA_LANG
							FROM epi_dbx.master_rekening a
							JOIN epi_dbx.DIL_LISTRIK_REF b ON a.ID_LANG=b.ID_LANG
						  WHERE a.THBLREK = (SELECT MAX(THBLREK) FROM epi_dbx.MASTER_REKENING)");

		$this->session->set_flashdata('msg','Berhasil Melakukan Upload Rekening');
		redirect('billing/uploadrekening');
	}

	public function rekaphitung_list()
	{
		$idcari = $this->input->post('filterhitungbilling');
		$list = $this->billingm->get_datatables_rekaphitung($idcari);
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
						"recordsTotal" => $this->billingm->count_all_rekaphitung($idcari),
						"recordsFiltered" => $this->billingm->count_filtered_rekaphitung(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapdlpd_list()
	{
		$list = $this->billingm->get_datatables_rekapdlpd();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->KD_AREA;
			$row[] = $cater->STATUS_DLPD;
			$row[] = $cater->JML_LANG;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_all_rekapdlpd(),
						"recordsFiltered" => $this->billingm->count_filtered_rekapdlpd(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function invoice_all()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice_last
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK
						</div>
						<b>PT ENERGI PELABUHAN INDONESIA</b>
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=2><u><b>Data Customer</b></u></td>
					<td colspan=2><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=40% >: ".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=32% >: ".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td >Nama Cust.</td>
					<td >: ".$data->NAMA_CUST."</td>
					<td >Nama Langganan </td>
					<td >: ".$data->NAMA_LANG."</td>
				</tr>
				<tr>
					<td >Alamat</td>
					<td >: ".SUBSTR($data->ALAMAT_CUST,0,40)."</td>
					<td >Lokasi</td>
					<td >: ".SUBSTR($data->ALAMAT_LANG,0,40)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >: ".$data->NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >: ".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >: ".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >: ".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1' height='10'></td>
			</tr>
			<tr>
				<td colspan='1' align='center'></td>
			</tr>
			<tr>
				<td colspan='1' align='center'></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'></td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}
	
	public function invoice_all_ttd()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice_last order by ID_LANG ASC
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK
						</div>
						<b>PT ENERGI PELABUHAN INDONESIA</b>
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=2><u><b>Data Customer</b></u></td>
					<td colspan=2><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=40% >: ".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=32% >: ".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td >Nama Cust.</td>
					<td >: ".$data->NAMA_CUST."</td>
					<td >Nama Langganan </td>
					<td >: ".$data->NAMA_LANG."</td>
				</tr>
				<tr>
					<td >Alamat</td>
					<td >: ".SUBSTR($data->ALAMAT_CUST,0,40)."</td>
					<td >Lokasi</td>
					<td >: ".SUBSTR($data->ALAMAT_LANG,0,40)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >: ".$data->NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >: ".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >: ".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >: ".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1' height='10'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>PT ENERGI PELABUHAN INDONESIA</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>MANAGER NIAGA</td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>MULYONO</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'></td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}
		
	public function invoice_all_dinas()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice_last where KOGOL in ('1','2')
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK
						</div>
						<b>PT ENERGI PELABUHAN INDONESIA</b>
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=2><u><b>Data Customer</b></u></td>
					<td colspan=2><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=40% >: ".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=32% >: ".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td >Nama Cust.</td>
					<td >: ".$data->NAMA_CUST."</td>
					<td >Nama Langganan </td>
					<td >: ".$data->NAMA_LANG."</td>
				</tr>
				<tr>
					<td >Alamat</td>
					<td >: ".SUBSTR($data->ALAMAT_CUST,0,40)."</td>
					<td >Lokasi</td>
					<td >: ".SUBSTR($data->ALAMAT_LANG,0,40)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >: ".$data->NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >: ".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >: ".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >: ".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1' height='10'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>PT ENERGI PELABUHAN INDONESIA</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>MANAGER NIAGA</td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>MULYONO</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'></td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}

	public function invoice_all_ptp()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice_last where ID_CUST = '8801540'
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK
						</div>
						<b>PT ENERGI PELABUHAN INDONESIA</b>
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=2><u><b>Data Customer</b></u></td>
					<td colspan=2><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=40% >: ".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=32% >: ".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td >Nama Cust.</td>
					<td >: ".$data->NAMA_CUST."</td>
					<td >Nama Langganan </td>
					<td >: ".$data->NAMA_LANG."</td>
				</tr>
				<tr>
					<td >Alamat</td>
					<td >: ".SUBSTR($data->ALAMAT_CUST,0,40)."</td>
					<td >Lokasi</td>
					<td >: ".SUBSTR($data->ALAMAT_LANG,0,40)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >: ".$data->NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >: ".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >: ".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >: ".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1' height='10'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>PT ENERGI PELABUHAN INDONESIA</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>MANAGER NIAGA</td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>MULYONO</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'></td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}
	
	public function invoice_detil()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);;
		$id_lang = $this->uri->segment(4);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice_last
			where id_lang = '$id_lang'
			order by ID desc
			Limit 2
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;
			$EMAIL1 = $data->EMAIL1;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			if(!$data->NPWP_CUST)
			{
				$NPWP_CUST = "-";
			}
			else
			{
				$NPWP_CUST = $data->NPWP_CUST;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							<b>INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK</b>
						</div>
						PT ENERGI PELABUHAN INDONESIA
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=3><u><b>Data Customer</b></u></td>
					<td colspan=3><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=1% >:</td>
					<td width=40% >".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=1% >:</td>
					<td width=32% >".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td valign=top>Nama Cust.</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_CUST,0,70)."</td>
					<td valign=top>Nama Langganan </td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_LANG,0,30)."</td>
				</tr>
				<tr>
					<td valign=top>Alamat</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_CUST,0,70)."</td>
					<td valign=top>Lokasi</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_LANG,0,60)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >:</td>
					<td >".$NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >:</td>
					<td >".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >:</td>
					<td >".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >:</td>
					<td >".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>&nbsp;</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'>Invoice ini dicetak oleh sistem</td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>";
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek." - ".$data->ID_LANG;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			#$SenD["Emailto"]= $EMAIL1;
			$this->load->view("laporan/Report",$SenD);

		}
	}

	public function invoice_customer()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$id_custx = $this->uri->segment(4);

		$Rpt = "";

		if(!$this->uri->segment(5))
		{
			$thblrekx = $this->get_thblrek();
		}
		else
		{
			$thblrekx = $this->uri->segment(5);
		}

		/*
		$q = $this->db->query("
			select * from v_invoice
			where id_cust = '$id_custx' and THBLREK = '$thblrekx' and STATUS_LUNAS <> '1'
		");
		*/

		$q = $this->db->query("
			select * from v_invoice_last
			where id_cust = '$id_custx'
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			if(!$data->NPWP_CUST)
			{
				$NPWP_CUST = "-";
			}
			else
			{
				$NPWP_CUST = $data->NPWP_CUST;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							<b>INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK</b>
						</div>
						PT ENERGI PELABUHAN INDONESIA
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=3><u><b>Data Customer</b></u></td>
					<td colspan=3><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=1% >:</td>
					<td width=40% >".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=1% >:</td>
					<td width=32% >".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td valign=top>Nama Cust.</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_CUST,0,70)."</td>
					<td valign=top>Nama Langganan </td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_LANG,0,30)."</td>
				</tr>
				<tr>
					<td valign=top>Alamat</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_CUST,0,70)."</td>
					<td valign=top>Lokasi</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_LANG,0,60)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >:</td>
					<td >".$NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >:</td>
					<td >".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >:</td>
					<td >".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >:</td>
					<td >".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>&nbsp;</td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>&nbsp;</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'>Invoice ini dicetak oleh sistem</td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}

	public function invoice_thblrek()
	{
		$this->load->model("Cetakm");

		$cetak = $this->uri->segment(3);
		$uriid = $this->uri->segment(4);
		$urithblrek = $this->uri->segment(5);
		$Rpt = "";

		$q = $this->db->query("SELECT * FROM v_invoice WHERE ID = '$uriid' AND THBLREK = '$urithblrek' ");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;
			$EMAIL1 = $data->EMAIL1;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			if(!$data->NPWP_CUST)
			{
				$NPWP_CUST = "-";
			}
			else
			{
				$NPWP_CUST = $data->NPWP_CUST;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							<b>INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK</b>
						</div>
						PT ENERGI PELABUHAN INDONESIA
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=3><u><b>Data Customer</b></u></td>
					<td colspan=3><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=1% >:</td>
					<td width=40% >".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=1% >:</td>
					<td width=32% >".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td valign=top>Nama Cust.</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_CUST,0,70)."</td>
					<td valign=top>Nama Langganan </td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->NAMA_LANG,0,30)."</td>
				</tr>
				<tr>
					<td valign=top>Alamat</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_CUST,0,70)."</td>
					<td valign=top>Lokasi</td>
					<td valign=top>:</td>
					<td valign=top>".SUBSTR($data->ALAMAT_LANG,0,60)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >:</td>
					<td >".$NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >:</td>
					<td >".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >:</td>
					<td >".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >:</td>
					<td >".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1'>&nbsp;
				</td>
			</tr>";
	if($data->STATUS_LUNAS == 1){
	$Rpt .="<tr>
				<td colspan='1' align='center' ><p style='color:red;'><b>Tagihan ini sudah lunas</b></p></td>
			</tr>
			<tr>
				<td colspan='1' align='center'><img src=".FCPATH."assets/img/lunas_small.jpg alt='logo' width='100' height='50' /></td>
			</tr>";
	}else{
	$Rpt .="<tr>
				<td colspan='1' align='center' >&nbsp;</td>
			</tr>
			<tr>
				<td colspan='1' align='center'>&nbsp;</td>
			</tr>";
	}
	$Rpt .="<tr>
				<td colspan='1'>
					<br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center'><b>&nbsp;</b></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'>Invoice ini dicetak oleh sistem</td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>";
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek." - ".$data->ID_LANG;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			#$SenD["Emailto"]= $EMAIL1;
			$this->load->view("laporan/Report",$SenD);

		}
	}

	public function invoice_send($pilih='')
	{
		set_time_limit(0);
		$this->load->model("Cetakm");
		$cetak = "5";
		$Rpt = "";

		$qg = $this->db->query("SELECT * FROM v_rekap_rek_customer WHERE thblrek = (SELECT MAX(thblrek) FROM master_rekening) AND email1 <> '' ");
			foreach($qg->result() as $r){
				$IDC = $r->ID_CUST;
					$qc = $this->db->query("select * from v_invoice_last where id_cust = '$IDC' and email1 <> '' ");
					foreach($qc->result() as $data)
					{
					#NILAI_JAMNYALA_EMIN
						$q = $this->db->query("SELECT nilai_jamnyala
												FROM TR_JAMNYALA
												WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
						foreach($q->result() as $r){
							$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
						}

						$thn  = SUBSTR( $data->THBLREK,0,4);
						$bln  = SUBSTR( $data->THBLREK,4,2);
						$bulan= getBulan($bln);
						$thblrek = $bulan." ".$thn;
						$EMAIL1 = $data->EMAIL1;
						$EMAIL2 = $data->EMAIL2;
						if($EMAIL1 == null){
							$EMAIL = $data->EMAIL2;
						}elseif($EMAIL2 == null){
							$EMAIL = $data->EMAIL1;
						}else{
							$EMAIL = $data->EMAIL1.", ".$data->EMAIL2;
						}

						if(!$data->KET_EMIN)
						{
							$KET_EMIN = "&nbsp;";
						}
						else
						{
							$KET_EMIN = $data->KET_EMIN;
						}

						if(!$data->NPWP_CUST)
						{
							$NPWP_CUST = "-";
						}
						else
						{
							$NPWP_CUST = $data->NPWP_CUST;
						}
						$Rpt .= "
						<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
							<tr>
								<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
									<div style='font-size:16px;'>
										<b>INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK</b>
									</div>
									PT ENERGI PELABUHAN INDONESIA
									<div style='font-size:14px;'>
										Rekening Bulan : ".$thblrek."
									</div>

								</td>
								<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
							</tr>
						</table>
						<br/>
						<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
							<tr>
								<td colspan=3><u><b>Data Customer</b></u></td>
								<td colspan=3><u><b>Data Langganan</b></u></td>
							</tr>
							<tr>
								<td width=10% >Id Cust.</td>
								<td width=1% >:</td>
								<td width=40% >".$data->ID_CUST."</td>
								<td width=18% >Id Langganan </td>
								<td width=1% >:</td>
								<td width=32% >".$data->ID_LANG."</td>
							</tr>
							<tr>
								<td valign=top>Nama Cust.</td>
								<td valign=top>:</td>
								<td valign=top>".SUBSTR($data->NAMA_CUST,0,70)."</td>
								<td valign=top>Nama Langganan </td>
								<td valign=top>:</td>
								<td valign=top>".SUBSTR($data->NAMA_LANG,0,30)."</td>
							</tr>
							<tr>
								<td valign=top>Alamat</td>
								<td valign=top>:</td>
								<td valign=top>".SUBSTR($data->ALAMAT_CUST,0,70)."</td>
								<td valign=top>Lokasi</td>
								<td valign=top>:</td>
								<td valign=top>".SUBSTR($data->ALAMAT_LANG,0,60)."</td>
							</tr>
							<tr>
								<td >No. NPWP</td>
								<td >:</td>
								<td >".$NPWP_CUST."</td>
								<td >Tarif /  Daya </td>
								<td >:</td>
								<td >".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
							</tr>
							<tr>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >Jam Nyala EMIN </td>
								<td >:</td>
								<td >".$NILAI_JAMNYALA_EMIN." Jam</td>
							</tr>
							<tr>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >&nbsp;</td>
								<td >Jam Nyala Realisasi </td>
								<td >:</td>
								<td >".$data->JAM_NYALA_CATER." Jam</td>
							</tr>
							<tr>
								<td colspan=4><b><u>Data pemakaian :</u></b></td>
							</tr>
						</table>
						<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
						<tr>
							<td width=20% align=center><b>Uraian</b></td>
							<td width=20% align=center><b>Tanggal Baca</b></td>
							<td width=15% align=center><b>LWBP</b></td>
							<td width=15% align=center><b>WBP</b></td>
							<td width=15% align=center><b>KVARH</b></td>
							<td style='text-align:center;' rowspan=4>
								TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
							</td>
						</tr>
						<tr>
							<td >Stand Awal</td>
							<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

						</tr>
						<tr>
							<td >Stand Cabut</td>
							<td style='text-align:center;'>-</td>
							<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
						</tr>
						<tr>
							<td >Stand Pasang</td>
							<td style='text-align:center;'>-</td>
							<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

						</tr>
						<tr>
							<td >Stand Akhir</td>
							<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
							<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
							<td style='text-align:center;' rowspan=3>
								TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
							</td>
						</tr>
						<tr>
							<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
							<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
							<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
							<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
							<td style='text-align:center;'></td>
						</tr>
						<tr>
							<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
							<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
							<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
							<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
							<td style='text-align:center;'></td>
						</tr>
						<tr>
							<td colspan='6'>".$KET_EMIN."</td>
						</tr>
						<tr>
							<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
						</tr>
						<tr>
							<td colspan='2'>Biaya Pemakaian kWh WBP</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
						</tr>
						<tr>
							<td colspan='2'>Biaya kelebihan kVArh</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
						</tr>
						<tr>
							<td colspan='4'><b>Jumlah</b></td>
							<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
						</tr>
						<tr>
							<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
							<td colspan='2' style='text-align:right;'>0</td>
						</tr>
						<tr>
							<td colspan='4'>Pengganti PPJ</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
						</tr>
						<tr>
							<td colspan='4'>Meterai</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
						</tr>
						<tr>
							<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
						</tr>
						<tr>
							<td colspan='4'><b>Tagihan bulan ini</b></td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
						</tr>
						<tr>
							<td colspan='4'>Biaya Keterlambatan / Denda</td>
							<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
						</tr>
						<tr style='font-size:12px;'>
							<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
							<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
						</tr>
						<tr>
							<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
						</tr>
					</table>
					<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
						<tr>
							<td colspan='1'>&nbsp;</td>
						</tr>
						<tr style='font-size:12px;'>
							<td colspan='1'><b>Informasi :</b></td>
						</tr>
						<tr>
							<td colspan='1' >
								<table width=100%>
									<tr>
										<td valign=top>1.</td>
										<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
									</tr>
									<tr>
										<td valign=top>2.</td>
										<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
									</tr>
									<tr>
										<td valign=top>3.</td>
										<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
									</tr>
									<tr>
										<td valign=top>4.</td>
										<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
									</tr>
									<tr>
										<td valign=top>5.</td>
										<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
									</tr>
									<tr>
										<td></td>
										<td valign=top>a.</td>
										<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
									</tr>
									<tr>
										<td></td>
										<td valign=top>b.</td>
										<td>Bank BRI Kantor Kas Pelindo II (Persero) Cab. Palembang, beralamat di Jl. Belinyu No. 01, Boom Baru, Palembang</td>
									</tr>
									<tr>
										<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
									</tr>
								</table>
							</td>
						</tr>

						<tr>
							<td colspan='1'>
								<br/><br/>
							</td>
						</tr>
						<tr>
							<td colspan='1' align='center'>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='1' align='center'>&nbsp;</td>
						</tr>
						<tr>
							<td colspan='1'>
								<br/><br/><br/><br/><br/>
							</td>
						</tr>
						<tr>
							<td colspan='1' align='center'><b>&nbsp;</b></td>
						</tr>
						<tr>
							<td colspan='1'>
								<br/>
							</td>
						</tr>
						<tr>
							<td colspan='1' align='center' style='color:grey;'>Invoice ini dicetak oleh sistem</td>
						</tr>
						<tr>
							<td colspan='1' style='border-bottom:0.5px solid black;'></td>
						</tr>
					</table>
					<table style='font-size:9px;'>
						<tr>
							<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
							Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
							atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
							</td>
						</tr>
					</table>";
					}
				$qtemplate = $this->db->query("SELECT * FROM v_rekap_rek_customer WHERE thblrek = (SELECT MAX(thblrek) FROM master_rekening) AND id_cust = '$IDC' AND email1 <> ''  ");
				$dttemplate = $qtemplate->result_array()[0];
				$dt['data_template'] = $dttemplate;
				$dt['data_bulan']    = getBulan(SUBSTR($dttemplate['THBLREK'],4,2));
				$dt['data_tahun']    = SUBSTR($dttemplate['THBLREK'],0,4);
				$template = $this->load->view("laporan/template_billing",$dt,TRUE);
				
				$SenD["TitlE"]	= "Invoice-".$data->ID_CUST;
				$SenD["OutpuT"]	= $Rpt;
				$SenD["CetaK"]	= $cetak;
				$SenD["Kertas"]	= "A4-P";
				$SenD["tmargin"]= "10";
				$SenD["bmargin"]= "10";
				$SenD["Emailto"]= $EMAIL;
				$SenD["Subject"]= "Invoice-".$data->ID_CUST;
				#$SenD["Message"]= "Berikut kami lampirkan invoice dengan ID Customer :".$data->ID_CUST;
				$SenD["Message"]= $template;
				$SenD["Attach"] = "ADA";
				$SenD["Via"] 	= $pilih;
				unset($Rpt);
				$this->load->view("laporan/Report",$SenD);
			}
		echo json_encode(array("status" => TRUE));
	}

	public function invoice_sms()
	{
		$this->load->model("smsm");
		$MENU = "invoice";
					$qc = $this->db->query("select THBLREK,ID_LANG,ALAMAT_LANG,HP1,FORMAT(RPTAG,0) RPTAG from v_invoice_last WHERE HP1 <> '' ");
					foreach($qc->result() as $data)
					{
						$ID_LANG 	 = $data->ID_LANG;
						$ALAMAT_LANG = $data->ALAMAT_LANG;
						$NO_TUJUAN	 = $data->HP1;
						$RPTAG	 	 = $data->RPTAG;

						$BULAN = getBulan(substr($data->THBLREK,4,2));
						$TAHUN = substr($data->THBLREK,0,4);

						$this->smsm->sendsms($MENU,$BULAN,$TAHUN,$ID_LANG,$ALAMAT_LANG,$NO_TUJUAN,$RPTAG);
					}
		echo json_encode(array("status" => TRUE));
	}

	public function monitoringinvoice(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/monitoringinvoice',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function monemailinvoice()
	{
		$list = $this->billingm->get_datatables_monemailinvoice();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $billing->THBLREK;
			$row[] = $billing->ID_CUST;
			$row[] = $billing->SUBJECT;
			$row[] = $billing->EMAIL;
			$row[] = $billing->TGL_KIRIM;
			$row[] = $billing->STATUS;
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->billingm->count_all_monemailinvoice(),
						"recordsFiltered" => $this->billingm->count_filtered_monemailinvoice(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function kirimemaildansms(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('billing/kirimemaildansms',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function cetak_surat()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$thblrek = $this->uri->segment(4);
		$Rpt = "";

		$q = $this->db->query("
		SELECT * FROM `v_rekap_rek_customer`
		where KIRIM_SURAT = '1' and THBLREK = '$thblrek'
		");

		$Rpt .= "";
		foreach ($q->result() as $r)
		{
			$thn  = SUBSTR( $r->THBLREK,0,4);
			$bln  = SUBSTR( $r->THBLREK,4,2);
			$tgl 	= '20';
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			$thnx = date("Y", mktime(0,0,0,$bln-1, $tgl, $thn));
			$blnx = date("m", mktime(0,0,0,$bln-1, $tgl, $thn));
			$bulanx= getBulan($blnx);
			$thblrek1 = $bulanx." ".$thnx;

			if ( substr($r->Nama_Customer,-2) == 'PT' or substr($r->Nama_Customer,-2) == 'CV'  )
			{
				$ptx = substr($r->Nama_Customer,-2);
				$namax = substr($r->Nama_Customer,0,-4);
				$nama_customer = $ptx." ".$namax;
			}
			else
			{
				$nama_customer = $r->Nama_Customer;
			}

			$nama_kota = $this->db->query("select nama from tr_kab where id_kab = '$r->KOTA_CUST' ")->row()->nama;

			if (!$r->BANK_NAMA)
			{
				$tembusan = "
				<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:10px;border-collapse: collapse;'>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<br/><br/>
				</table>
				";
			}
			else
			{
				$tembusan = "
				<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:10px;border-collapse: collapse;'>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' colspan='2'><u>Tembusan Yth</u></td>
						<td width=3% align='left' valign='top' >:</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' >-</td>
						<td width=11% align='left' valign='top' colspan='4'>".$r->BANK_NAMA.", ".ucwords(strtolower($r->BANK_CABANG))."</td>
					</tr>
					<tr>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=11% align='left' valign='top' > &nbsp;</td>
						<td width=3% align='left' valign='top' > &nbsp;</td>
						<td width=83% align='left' valign='top' > &nbsp;</td>
					</tr>
					<br/><br/>
				</table>
				";
			}
			
			if (!$r->CQ)
			{
				$cqx = " ";
			}
			else
			{
				$cqx = "
				<br/> c.q. ".$r->CQ."
				";
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:12px;border-collapse: collapse;'>
				<tr>
					<td width=14% align='left' valign='top' > &nbsp; <br/><br/><br/></td>
					<td width=3% align='left' valign='top' > &nbsp;</td>
					<td width=3% align='left' valign='top' > &nbsp;</td>
					<td width=35% align='left' valign='top' > &nbsp;</td>
					<td width=5% align='left' valign='top' > &nbsp;</td>
					<td width=40% align='left' valign='top' > &nbsp;</td>
				</tr>
				<tr>
					<td align='left' valign='top' >Nomor</td>
					<td align='left' valign='top' >:</td>
					<td align='left' valign='top' colspan='2'> &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > Jakarta, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$thblrek."</td>
				</tr>
				<tr>
					<td align='left' valign='top' >Klasifikasi</td>
					<td align='left' valign='top' >:</td>
					<td align='left' valign='top' colspan='2'>Penting</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
				</tr>
				<tr>
					<td align='left' valign='top' >Lampiran</td>
					<td align='left' valign='top' >:</td>
					<td align='left' valign='top' colspan='2'>1 (Satu) berkas</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >Kepada,</td>
				</tr>
				<tr>
					<td align='left' valign='top' >Perihal</td>
					<td align='left' valign='top' >:</td>
					<td align='left' valign='top' colspan='2' rowspan='2'>Tagihan Listrik Bulan ".$thblrek." untuk Pemakaian Bulan ".$thblrek1."</td>
					<td align='right' valign='top' > Yth.</td>
					<td align='left' valign='top' > 
						".$r->JAB_PIMPINAN." <br/> ".$nama_customer." 
						".$cqx."
					</td>
				</tr>
				<tr>
					<td align='left' valign='top' >&nbsp;</td>
					<td align='left' valign='top' >&nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >".ucwords(strtolower($r->ALAMAT_CUST))." <br/><br/> di <br/><br/> <b><u>".$nama_kota."</u></b> </td>
				</tr>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
				</tr>
				<br/><br/>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >1.</td>
					<td align='justify' valign='top' colspan='4'>Sehubungan telah terbitnya tagihan listrik Bulan ".$thblrek." untuk pemakaian Bulan ".$thblrek1.".</td>
				</tr>
				<br/><br/>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >2.</td>
					<td align='justify' valign='top' colspan='4'>Terkait butir 1 (Satu) diatas, dapat kami sampaikan :</td>
				</tr>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >a.</td>
					<td align='justify' valign='top' colspan='3'>Tagihan listrik rekening Bulan ".$thblrek." untuk pemakaian Bulan ".$thblrek1."
						adalah Rp. ".number_format($r->JLH_TAGIHAN).",-
						(".lcfirst($this->terbilang($r->JLH_TAGIHAN))."), dengan rincian sebagai berikut : (Nota tagihan terlampir)
					</td>
				</tr>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='justify' valign='top' colspan='3'>

						<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:12px;border-collapse: collapse;'>
							<tr>
								<td width=10% align='center' valign='top' > <b>No.</b></td>
								<td width=20% align='center' valign='top' > <b>Bulan Rekening</b></td>
								<td width=20% align='center' valign='top' > <b>Jlh. Langganan</b></td>
								<td width=25% align='center' valign='top' > <b>Jlh. Daya (VA)</b></td>
								<td width=25% align='center' valign='top' > <b>Jlh. Tagihan (Rp.)</b></td>
							</tr>
							<tr>
								<td width=10% align='center' valign='top' >1.</td>
								<td width=20% align='left' valign='top' > ".$thblrek."</td>
								<td width=20% align='center' valign='top' >".$r->JLH_LANGG."</td>
								<td width=25% align='right' valign='top' >".number_format($r->JLH_DAYA)."</td>
								<td width=25% align='right' valign='top' >".number_format($r->JLH_TAGIHAN)."</td>
							</tr>
						</table>

					</td>
				</tr>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >b.</td>
					<td align='justify' valign='top' colspan='3'>Pembayaran tagihan rekening tersebut dapat melalui Bank Bukopin a/n PT Energi Pelabuhan Indonesia Nomor Rekening 1000406488.</td>
				</tr>
				<br/><br/>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' >3.</td>
					<td align='justify' valign='top' colspan='4'>Demikian disampaikan. atas perhatian dan kerjasamanya diucapkan terima kasih.</td>
				</tr>
				<br/><br/><br/>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='center' valign='top' colspan='2'>
						DIREKSI PT ENERGI PELABUHAN INDONESIA <br/>
						DIREKTUR KEUANGAN DAN SDM <br/>
						<br/><br/><br/><br/><br/>
						<b><u>SUMARNO</u></b>
					</td>
				</tr>
				<tr>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
					<td align='left' valign='top' > &nbsp;</td>
				</tr>
				<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
			</table>
			".$tembusan."
			<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
						<tr>
							<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
						</tr>
						<tr>
							<td width=6%> Telepon</td>
							<td width=0.5%>:</td>
							<td width=94%>(021) 4305047</td>
						</tr>
						<tr>
						  <td>Fax</td>
						  <td>:</td>
						  <td>(021) 4305052</td>
						</tr>
						<tr>
						  <td>Website</td>
						  <td>:</td>
						  <td>www.ecopowerport.co.id</td>
						</tr>
						<tr>
						  <td>Email</td>
						  <td>:</td>
						  <td>cs@ecopowerport.co.id</td>
						</tr>
					</table>
					<pagebreak>
			";
		}
		$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "10";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);


	}
	
	public function invoice_88202()
	{
		$this->load->model("Cetakm");
		$cetak = $this->uri->segment(3);
		$Rpt = "";

		$q = $this->db->query("
			select * from v_invoice where STATUS_LUNAS <> '1' and KD_AREA = '88202' AND KOGOL IN ('0','4')
		");
		foreach ($q->result() as $data)
		{
			#NILAI_JAMNYALA_EMIN
			$q = $this->db->query("SELECT nilai_jamnyala
									FROM TR_JAMNYALA
									WHERE kd_jamnyala = '$data->KD_JAMNYALA_EMIN' ");
			foreach($q->result() as $r){
				$NILAI_JAMNYALA_EMIN = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
			}

			$thn  = SUBSTR( $data->THBLREK,0,4);
			$bln  = SUBSTR( $data->THBLREK,4,2);
			$bulan= getBulan($bln);
			$thblrek = $bulan." ".$thn;

			if(!$data->KET_EMIN)
			{
				$KET_EMIN = "&nbsp;";
			}
			else
			{
				$KET_EMIN = $data->KET_EMIN;
			}

			$Rpt .= "
			<table width=100% cellspacing='0' cellpadding='2' border=0 style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td width=85% valign=bottom style='text-align:left;font-size:16px;'>
						<div style='font-size:16px;'>
							INFORMASI TAGIHAN PEMAKAIAN TENAGA LISTRIK
						</div>
						<b>PT ENERGI PELABUHAN INDONESIA</b>
						<div style='font-size:14px;'>
							Rekening Bulan : ".$thblrek."
						</div>

					</td>
					<td width=15%><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				</tr>
			</table>
			<br/>
			<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;border-collapse: collapse;'>
				<tr>
					<td colspan=2><u><b>Data Customer</b></u></td>
					<td colspan=2><u><b>Data Langganan</b></u></td>
				</tr>
				<tr>
					<td width=10% >Id Cust.</td>
					<td width=40% >: ".$data->ID_CUST."</td>
					<td width=18% >Id Langganan </td>
					<td width=32% >: ".$data->ID_LANG."</td>
				</tr>
				<tr>
					<td >Nama Cust.</td>
					<td >: ".$data->NAMA_CUST."</td>
					<td >Nama Langganan </td>
					<td >: ".$data->NAMA_LANG."</td>
				</tr>
				<tr>
					<td >Alamat</td>
					<td >: ".SUBSTR($data->ALAMAT_CUST,0,40)."</td>
					<td >Lokasi</td>
					<td >: ".SUBSTR($data->ALAMAT_LANG,0,40)."</td>
				</tr>
				<tr>
					<td >No. NPWP</td>
					<td >: ".$data->NPWP_CUST."</td>
					<td >Tarif /  Daya </td>
					<td >: ".$data->TARIF." / ". number_format($data->DAYA)." VA</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala EMIN </td>
					<td >: ".$NILAI_JAMNYALA_EMIN." Jam</td>
				</tr>
				<tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td >Jam Nyala Realisasi </td>
					<td >: ".$data->JAM_NYALA_CATER." Jam</td>
				</tr>
				<tr>
					<td colspan=4><b><u>Data pemakaian :</u></b></td>
				</tr>
			</table>
			<table width=100% cellspacing='0' cellpadding='2' border='1' style='font-size:11px;border-collapse: collapse;'>
			<tr>
				<td width=20% align=center><b>Uraian</b></td>
				<td width=20% align=center><b>Tanggal Baca</b></td>
				<td width=15% align=center><b>LWBP</b></td>
				<td width=15% align=center><b>WBP</b></td>
				<td width=15% align=center><b>KVARH</b></td>
				<td style='text-align:center;' rowspan=4>
					TOTAL KWH (LWBP+WBP) : <br> <b>".number_format($data->PEMKWH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td >Stand Awal</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AWAL."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AWAL_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Cabut</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_BKR_KVARH,2)."</td>
			</tr>
			<tr>
				<td >Stand Pasang</td>
				<td style='text-align:center;'>-</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_PSG_KVARH,2)."</td>

			</tr>
			<tr>
				<td >Stand Akhir</td>
				<td style='text-align:center;'>".$data->TGL_BACA_AKHIR."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_LWBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_WBP,2)."</td>
				<td style='text-align:center;'>".number_format($data->STAND_AKHIR_KVARH,2)."</td>
				<td style='text-align:center;' rowspan=3>
					TOTAL KVARH : <br> <b>".number_format($data->PEMKVARH_CATER)."</b>
				</td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'>Faktor Kali Meter dan Faktor Rugi Trafo</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'>".number_format($data->FK_METER)." x ".number_format($data->FRT)."</td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td style='text-align:left;' colspan='2'><b>Pemakaian Energi</b> (kWh) : Selisih Stand x Faktor</td>
				<td style='text-align:center;'><b>".number_format($data->PEMLWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMWBP_CATER)."</b></td>
				<td style='text-align:center;'><b>".number_format($data->PEMKVARH_CATER)."</b></td>
				<td style='text-align:center;'></td>
			</tr>
			<tr>
				<td colspan='6'>".$KET_EMIN."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh LWBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHLWBP)." x Rp. ".number_format($data->TARIF_LWBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPLWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya Pemakaian kWh WBP</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KWHWBP)." x Rp. ".number_format($data->TARIF_WBP,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPWBP)."</td>
			</tr>
			<tr>
				<td colspan='2'>Biaya kelebihan kVArh</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->KLBKVARH)." x Rp. ".number_format($data->TARIF_KVARH,2)."</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPKVARH)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Jumlah</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->RPPTL)."</b></td>
			</tr>
			<tr>
				<td colspan='4'>PPN 10% (dibebaskan sesuai Peraturan Pemerintah RI No. 81 Tahun 2015)</td>
				<td colspan='2' style='text-align:right;'>0</td>
			</tr>
			<tr>
				<td colspan='4'>Pengganti PPJ</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPBPJU)."</td>
			</tr>
			<tr>
				<td colspan='4'>Meterai</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPMAT)."</td>
			</tr>
			<tr>
				<td colspan='4'>Lain-lain (Kekurangan Pembayaran / Angsuran)</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPANGSURAN)."</td>
			</tr>
			<tr>
				<td colspan='4'><b>Tagihan bulan ini</b></td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RPTAG)."</td>
			</tr>
			<tr>
				<td colspan='4'>Biaya Keterlambatan / Denda</td>
				<td colspan='2' style='text-align:right;'>".number_format($data->RP_BK)."</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='4'><b>Total tagihan : (Rp.)*</b></td>
				<td colspan='2' style='text-align:right;'><b>".number_format($data->TOTAL_INVOICE)."</b></td>
			</tr>
			<tr>
				<td colspan='6'>* Total tagihan diatas belum termasuk biaya Admin Bank</td>
			</tr>
		</table>
		<table width=100% cellspacing='0' cellpadding='2' border='0' style='font-size:11px;'>
			<tr>
				<td colspan='1'>&nbsp;</td>
			</tr>
			<tr style='font-size:12px;'>
				<td colspan='1'><b>Informasi :</b></td>
			</tr>
			<tr>
				<td colspan='1' >
					<table width=100%>
						<tr>
							<td valign=top>1.</td>
							<td colspan=2>Rekening bulan ini merupakan tagihan atas pemakaian bulan lalu (sebelumnya).</td>
						</tr>
						<tr>
							<td valign=top>2.</td>
							<td colspan=2>Periode pembayaran mulai tanggal 5 s/d 20 setiap bulannya, kecuali Pelanggan autodebet sampai dengan H+1 sejak invoice diterima oleh Bank yang ditunjuk Pelanggan.</td>
						</tr>
						<tr>
							<td valign=top>3.</td>
							<td colspan=2>Biaya keterlambatan akan dikenakan H+1 setelah batas akhir periode pembayaran rekening.</td>
						</tr>
						<tr>
							<td valign=top>4.</td>
							<td colspan=2>Bagi Pelanggan non autodebet, apabila Tanggal 20 bertepatan dengan hari Sabtu, Minggu atau Hari Libur Nasional, maka akhir jatuh tempo diundur sampai dengan Hari kerja pertama setelah hari libur tersebut.</td>
						</tr>
						<tr>
							<td valign=top>5.</td>
							<td colspan=2>PT Energi Pelabuhan Indonesia telah menyediakan sistem pembayaran di loket :</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>a.</td>
							<td>Bank Bukopin CAPEM Tanjung Priok, beralamat di Ruko Enggano Megah No. 15 B-C Jl. Enggano Raya, Tanjung Priok.</td>
						</tr>
						<tr>
							<td></td>
							<td valign=top>b.</td>
							<td>Transfer ke Bank BRI Cabang Tanjung Priok, dengan nomor rekening 01.860.1001.184304 atas nama \"PT ENERGI PELABUHAN INDONESIA\".</td>
						</tr>
						<tr>
							<td valign=top colspan=3>Demikian kami sampaikan, terima kasih atas kerjasamanya.</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr>
				<td colspan='1' height='10'></td>
			</tr>
			<tr>
				<td colspan='1' align='center'></td>
			</tr>
			<tr>
				<td colspan='1' align='center'></td>
			</tr>
			<tr>
				<td colspan='1'>
					<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
				</td>
			</tr>
			<tr>
				<td colspan='1' align='center' style='color:grey;'></td>
			</tr>
			<tr>
				<td colspan='1' style='border-bottom:0.5px solid black;'></td>
			</tr>
		</table>
		<table style='font-size:9px;'>
			<tr>
				<td colspan='1' align='justify'><b>Apabila anda ada keluhan atau mengalami gangguan listrik dapat menghubungi layanan teknik kami :</b>
				Pelabuhan Tanjung Priok (081294946500), Pelabuhan Palembang (082176506854), Pelabuhan Panjang (082176506854)
				atau melalui www.ecopowerport.co.id dan email cs@ecopowerport.co.id
				</td>
			</tr>
		</table>
			";

		}
			$SenD["TitlE"]	= "Cetakan Invoice rekening ".$thblrek;
			$SenD["OutpuT"]	= $Rpt;
			$SenD["CetaK"]	= $cetak;
			$SenD["Kertas"]	= "A4-P";
			$SenD["tmargin"]= "10";
			$SenD["bmargin"]= "10";
			$this->load->view("laporan/Report",$SenD);


	}

	public function terbilang_get_valid($str,$from,$to,$min=1,$max=9){
		$val=false;
		$from=($from<0)?0:$from;
		for ($i=$from;$i<$to;$i++){
			if (((int) $str{$i}>=$min)&&((int) $str{$i}<=$max)) $val=true;
		}
		return $val;
	}

	public function terbilang_get_str($i,$str,$len){
		$numA=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");
		$numB=array("","se","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numC=array("","satu ","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
		$numD=array(0=>"puluh",1=>"belas",2=>"ratus",4=>"ribu", 7=>"juta", 10=>"milyar", 13=>"triliun");
		$buf="";
		$pos=$len-$i;
		switch($pos){
			case 1:
					if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
						$buf=$numA[(int) $str{$i}];
				break;
			case 2:	case 5: case 8: case 11: case 14:
					if ((int) $str{$i}==1){
						if ((int) $str{$i+1}==0)
							$buf=($numB[(int) $str{$i}]).($numD[0]);
						else
							$buf=($numB[(int) $str{$i+1}]).($numD[1]);
					}
					else if ((int) $str{$i}>1){
							$buf=($numB[(int) $str{$i}]).($numD[0]);
					}
				break;
			case 3: case 6: case 9: case 12: case 15:
					if ((int) $str{$i}>0){
							$buf=($numB[(int) $str{$i}]).($numD[2]);
					}
				break;
			case 4: case 7: case 10: case 13:
					if ($this->terbilang_get_valid($str,$i-2,$i)){
						if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
							$buf=$numC[(int) $str{$i}].($numD[$pos]);
						else
							$buf=$numD[$pos];
					}
					else if((int) $str{$i}>0){
						if ($pos==4)
							$buf=($numB[(int) $str{$i}]).($numD[$pos]);
						else
							$buf=($numC[(int) $str{$i}]).($numD[$pos]);
					}
				break;
		}
		return $buf;
	}

	public function terbilang($nominal){
		$buf="";
		$str=$nominal."";
		$len=strlen($str);
		for ($i=0;$i<$len;$i++){
			$buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
		}
		return trim($buf." rupiah");
	}

	public function terbilang_angka($nominal){
		$buf="";
		$str=$nominal."";
		$len=strlen($str);
		for ($i=0;$i<$len;$i++){
			$buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
		}
		return trim($buf);
	}

}
