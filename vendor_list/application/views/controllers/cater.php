<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cater extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('caterm');
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		date_default_timezone_set('Asia/Jakarta');
	}

	function jml_hari_ini($bulan=0, $tahun=0) {

		$bulan = $bulan > 0 ? $bulan : date("m");
		$tahun = $tahun > 0 ? $tahun : date("Y");

		switch($bulan) {
			case 1:
			case 3:
			case 5:
			case 7:
			case 8:
			case 10:
			case 12:
				return 31;
				break;
			case 4:
			case 6:
			case 9:
			case 11:
				return 30;
				break;
			case 2:
				return $tahun % 4 == 0 ? 29 : 28;
				break;
		}
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

	public function downloadstandawal(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('cater/downloadstandawal',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	function cekdilnew(){
		$cekdil = $this->caterm->cekdilnew();
		echo json_encode($cekdil);
	}

	function downloadexcelstandawal($tbrek=''){
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');

		$this->db->query("TRUNCATE DPM_LISTRIK_REF");
        $this->db->query("INSERT INTO DPM_LISTRIK_REF
							(THBLREK,ID_LANG,ID_CUST,KD_AREA,TARIF,DAYA,FK_METER,NO_METER,FRT,TG,KD_MUT,THBLMUT,TGL_MUT,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH, STATUS_DPM, TGL_STATUSDPM, STATUS_PECAHAN, KD_JAMNYALA_EMIN_BARU)
						SELECT '$tbrek',a.ID_LANG,a.ID_CUST, a.KD_AREA, a.TARIF,a.DAYA,a.FK_METER,a.NO_METER,a.FRT,a.KD_TG, a.KD_MUT, a.THBLMUT,TGL_MUT,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_BKR_LWBP, '0') STAND_BKR_LWBP,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_BKR_WBP, '0') STAND_BKR_WBP,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_BKR_KVARH, '0') STAND_BKR_KVARH,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_PSG_LWBP, '0') STAND_PSG_LWBP,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_PSG_WBP, '0') STAND_PSG_WBP,
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STAND_PSG_KVARH, '0') STAND_PSG_KVARH,'0', '$sekarang',
							IF(a.STATUS_PECAHAN = 'ADA' AND a.THBLMUT = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b),a.STATUS_PECAHAN, 'TIDAK') STATUS_PECAHAN, KD_JAMNYALA_EMIN
						FROM DIL_LISTRIK_NEW a WHERE a.THBLREK = (SELECT MAX(b.THBLREK) FROM DIL_LISTRIK_NEW b ) AND a.KD_MUT NOT IN ('N')" );
		#DELETE DPM_LISTRIK_REF_PECAHAN
		$this->db->query("DELETE FROM DPM_LISTRIK_REF_PECAHAN
							WHERE THBLREK IN (SELECT DISTINCT THBLREK
							FROM  DIL_LISTRIK_NEW
							WHERE STATUS_PECAHAN = 'ADA' AND THBLMUT = (SELECT MAX(THBLREK) FROM DIL_LISTRIK_NEW) AND KD_MUT NOT IN ('N')) ");
		$this->db->query("INSERT INTO DPM_LISTRIK_REF_PECAHAN
						(
							THBLREK, ID_CUST, ID_LANG, TGL_MUT, DAYA_BARU, TARIF_BARU, FK_METER_BARU, FRT_BARU
						)
						SELECT
							THBLREK, ID_CUST, ID_LANG, TGL_MUT, DAYA, TARIF, FK_METER, FRT
						FROM  DIL_LISTRIK_NEW
						WHERE STATUS_PECAHAN = 'ADA' AND THBLMUT = (SELECT MAX(THBLREK) FROM DIL_LISTRIK_NEW) AND KD_MUT NOT IN ('N')");
		$this->db->query("UPDATE DPM_LISTRIK_REF_PECAHAN a
								LEFT JOIN DIL_LISTRIK_REF b
								ON a.ID_LANG = b.ID_LANG
								SET a.DAYA_LAMA = b.DAYA, a.TARIF_LAMA = b.TARIF, a.FK_METER_LAMA = b.FK_METER, a.FRT_LAMA = b.FRT, a.KD_JAMNYALA_EMIN_LAMA = b.KD_JAMNYALA_EMIN ");
		$q = "SELECT a.ID_LANG,a.STAND_AKHIR_LWBP, a.STAND_AKHIR_WBP, a.STAND_AKHIR_KVARH, a.TGL_BACA_AKHIR
				FROM DPM_LISTRIK_LOG a WHERE a.THBLREK=(SELECT MAX(b.THBLREK) FROM DPM_LISTRIK_LOG b ) ";
		$x = $this->db->query($q);
		foreach ($x->result() as $r)
                {
					$id_lang	= $r->ID_LANG;
                    $lwbp		= $r->STAND_AKHIR_LWBP;
                    $wbp		= $r->STAND_AKHIR_WBP;
                    $kvarh		= $r->STAND_AKHIR_KVARH;
                    $bacaakhir	= $r->TGL_BACA_AKHIR;
					$this->db->query("UPDATE DPM_LISTRIK_REF SET STAND_AWAL_LWBP = '$lwbp', STAND_AWAL_WBP = '$wbp', STAND_AWAL_KVARH = '$kvarh', TGL_BACA_AWAL = '$bacaakhir' , STATUS_DPM='0'
										WHERE ID_LANG='$id_lang' ");
				}

		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$objPHPExcel->getActiveSheet()->getStyle('Q')->getNumberFormat()->setFormatCode('#0');
       
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'ID_LANG')
            ->setCellValue('C1', 'NAMA_LANG')
            ->setCellValue('D1', 'ALAMAT_LANG')
            ->setCellValue('E1', 'NO_METER')
            ->setCellValue('F1', 'TARIF')
            ->setCellValue('G1', 'DAYA')
            ->setCellValue('H1', 'TGL_BACA_AWAL')
            ->setCellValue('I1', 'STAND_AWAL_LWBP')
            ->setCellValue('J1', 'STAND_AWAL_WBP')
            ->setCellValue('K1', 'STAND_AWAL_KVARH')
            ->setCellValue('L1', 'TGL_BACA_AKHIR')
            ->setCellValue('M1', 'STAND_AKHIR_LWBP')
            ->setCellValue('N1', 'STAND_AKHIR_WBP')
            ->setCellValue('O1', 'STAND_AKHIR_KVARH')
			 ->setCellValue('P1', 'THBLREK')
			 ->setCellValue('Q1', 'FK_METER');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT a.THBLREK, a.ID,b.ID_LANG,b.NAMA_LANG,b.ALAMAT_LANG,b.NO_METER,b.TARIF,b.DAYA, a.TGL_BACA_AWAL, a.STAND_AWAL_LWBP, a.STAND_AWAL_WBP, a.STAND_AWAL_KVARH, a.FK_METER
						FROM DPM_LISTRIK_REF a
						JOIN DIL_LISTRIK_NEW b ON a.ID_LANG=b.ID_LANG
						ORDER BY b.ID_LANG asc
						";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->ID);
            $ex->setCellValue('B'.$counter, $row->ID_LANG);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->ALAMAT_LANG);
            $ex->setCellValue('E'.$counter, $row->NO_METER);
            $ex->setCellValue('F'.$counter, $row->TARIF);
            $ex->setCellValue('G'.$counter, $row->DAYA);
            $ex->setCellValue('H'.$counter, $row->TGL_BACA_AWAL);
            $ex->setCellValue('I'.$counter, $row->STAND_AWAL_LWBP);
            $ex->setCellValue('J'.$counter, $row->STAND_AWAL_WBP);
            $ex->setCellValue('K'.$counter, $row->STAND_AWAL_KVARH);
            $ex->setCellValue('L'.$counter, '');
            $ex->setCellValue('M'.$counter, '');
            $ex->setCellValue('N'.$counter, '');
            $ex->setCellValue('O'.$counter, '');
			$ex->setCellValue('P'.$counter, $row->THBLREK);
			$ex->setCellValue('Q'.$counter, $row->FK_METER);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("Stand Akhir")
            ->setSubject("Stand Akhir")
            ->setDescription("Stand Akhir by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Stand AKhir");
        $objPHPExcel->getActiveSheet()->setTitle('Stand AKhir');
        $TitlE 		= "Hasil Download Stand Awal $tbrek";
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

	public function uploadstandakhir(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('cater/uploadstandakhir',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	function cekstatusdpm(){
		$cekstatusdpm = $this->caterm->cekstatusdpm();
		echo json_encode($cekstatusdpm);
	}

	public function uploadfilestand(){
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');
		$user = $this->session->userdata('ket');
		set_time_limit(0);
		$this->db->query("update dpm_listrik_ref set status_dpm='0'");
		$th = $this->input->post('thblrek');
		$fileName = $this->input->post('file', TRUE);
		$config['upload_path'] = './upload/';
		$config['file_name'] = $fileName;
		$config['allowed_types'] = 'xls|xlsx|csv|ods|ots';
		$config['max_size'] = 10000;
		$this->load->library('upload', $config);
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('file')) {
			$error = array('error' => $this->upload->display_errors());
			$this->session->set_flashdata('msg','Ada kesalah dalam upload!!');
			redirect('cater/uploadstandakhir');
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
			$this->db->query("TRUNCATE DPM_LISTRIK_REF_TEMP");
			for ($row = 2; $row < ($highestRow+1); $row++){
				$data = array(
						"ID"=> $rowData[$row]["A"],
						"ID_LANG"=> $rowData[$row]["B"],
						"STAND_AKHIR_LWBP"=> (empty($rowData[$row]["M"])) ? '0' : $rowData[$row]["M"],
						"STAND_AKHIR_WBP"=> (empty($rowData[$row]["N"])) ? '0' : $rowData[$row]["N"],
						"STAND_AKHIR_KVARH"=> (empty($rowData[$row]["O"])) ? '0' : $rowData[$row]["O"]
				);
				$t  = $rowData[$row]["L"];
				$t1 = explode("-", $t);
				$t2 = $t1[0]."/".$t1[1]."/".$t1[2];
				$data["TGL_BACA_AKHIR"]= $t2;
				$data["TGL_UPLOAD_STAND"]= $sekarang;
				$thn  = SUBSTR($rowData[$row]["P"],0,4);
				$bln  = SUBSTR($rowData[$row]["P"],4,2);
				$bulan= getBulan($bln);
				$thblrek = $bulan." ".$thn;
				$data["NAMA_THBLREK"]= $thblrek;
				$data["USER_ENTRI"]= $user;
				$this->db->insert("DPM_LISTRIK_REF_TEMP",$data);
			}
			$this->db->query("UPDATE DPM_LISTRIK_REF a
									LEFT JOIN DPM_LISTRIK_REF_TEMP b ON a.`ID_LANG`=b.ID_LANG
									SET a.`TGL_BACA_AKHIR`= b.TGL_BACA_AKHIR, a.`STAND_AKHIR_LWBP`=b.STAND_AKHIR_LWBP, a.`STAND_AKHIR_WBP`=b.STAND_AKHIR_WBP, a.`STAND_AKHIR_KVARH`= b.STAND_AKHIR_KVARH, a.`TGL_UPLOAD_STAND`= b.TGL_UPLOAD_STAND, a.`NAMA_THBLREK`= b.NAMA_THBLREK, a.STATUS_DPM='1', a.USER_ENTRI = '$user'
									WHERE a.ID_LANG = b.ID_LANG AND a.STATUS_DPM='0' ");

			#unlink('upload/'.$media['file_name']);
			$this->session->set_flashdata('msg','Berhasil upload ...!!');
			redirect('cater/uploadstandakhir');
		}
	}

	public function upload_list()
	{
		$list = $this->caterm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->ID_LANG;
			$row[] = $cater->NAMA_LANG;
			$row[] = $cater->TGL_BACA_AKHIR;
			$row[] = number_format($cater->STAND_AKHIR_LWBP,2,',','.');
			$row[] = number_format($cater->STAND_AKHIR_WBP,2,',','.');
			$row[] = number_format($cater->STAND_AKHIR_KVARH,2,',','.');
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->caterm->count_all(),
						"recordsFiltered" => $this->caterm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function entristand(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('cater/entristand',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function caridpmref($idcari=''){
		$data_dpm = $this->caterm->get_dpmref($idcari);
		echo json_encode($data_dpm);
	}

	public function stand_update()
	{
		$sekarang = date('Y-m-d h:i:s');
		$user = $this->session->userdata('ket');
		$data = array(
			'TGL_BACA_AKHIR'   => $this->input->post('tgl_baca_akhir'),
			'STAND_AKHIR_LWBP' => $this->input->post('stand_akhir_lwbp'),
			'STAND_AKHIR_WBP'  => $this->input->post('stand_akhir_wbp'),
			'STAND_AKHIR_KVARH'=> $this->input->post('stand_akhir_kvarh'),
			'TGL_UPLOAD_STAND' => $sekarang,
			'USER_ENTRI' 	   => $user,
			'STATUS_DPM' 	   => '1'
		);
		$this->caterm->update('dpm_listrik_ref',array('ID_LANG' => $this->input->post('id_lang')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function hitungkwh(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('cater/hitungkwh',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	function cekbilling(){
		$cekbilling = $this->caterm->cekbilling();
		echo json_encode($cekbilling);
	}

	public function proseshitungkwh(){
		date_default_timezone_set('Asia/Jakarta');
		set_time_limit(0);

		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DPM_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
					$mintiga = date("Ym", mktime(0,0,0,$BLN-3, '20', $TH));

		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DPM_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
					$minsatu = date("Ym", mktime(0,0,0,$BLN-1, '20', $TH));

		$q = $this->db->query("SELECT * FROM DPM_LISTRIK_REF");
		foreach ($q->result() as $r)
                {
                    $THBLREK		 = $r->THBLREK;
					$ID_LANG		 = $r->ID_LANG;
                    $STS			 = $r->STATUS_PECAHAN;
					$TG				 = $r->TG;
					$DAYA			 = $r->DAYA;
					$TARIF			 = $r->TARIF;
					$KD_MUT			 = $r->KD_MUT;
					$TGL_MUT		 = $r->TGL_MUT;
					$KD_JAMNYALA_EMIN_BARU = $r->KD_JAMNYALA_EMIN_BARU;
					$TGL_BACA_AWAL	 = $r->TGL_BACA_AWAL;
					$TGL_BACA_AKHIR	 = $r->TGL_BACA_AKHIR;
					$STAND_AWAL_LWBP = $r->STAND_AWAL_LWBP;
					$STAND_BKR_LWBP  = $r->STAND_BKR_LWBP;
					$STAND_PSG_LWBP  = $r->STAND_PSG_LWBP;
					$STAND_AKHIR_LWBP= $r->STAND_AKHIR_LWBP;
					$STAND_AWAL_WBP  = $r->STAND_AWAL_WBP;
					$STAND_BKR_WBP   = $r->STAND_BKR_WBP;
					$STAND_PSG_WBP   = $r->STAND_PSG_WBP;
					$STAND_AKHIR_WBP = $r->STAND_AKHIR_WBP;
					$STAND_AWAL_KVARH= $r->STAND_AWAL_KVARH;
					$STAND_BKR_KVARH = $r->STAND_BKR_KVARH;
					$STAND_PSG_KVARH = $r->STAND_PSG_KVARH;
					$STAND_AKHIR_KVARH = $r->STAND_AKHIR_KVARH;
					$FK_METER		 = $r->FK_METER;
					$FRT			 = $r->FRT;
					$KWH_MIN		 = $r->KWH_MIN;
					$KWH_MAX		 = $r->KWH_MAX;
					$KWH_RATA2		 = $r->KWH_RATA2;

					#NILAI_JAMNYALA_EMIN_BARU
					$q= $this->db->query("SELECT nilai_jamnyala FROM TR_JAMNYALA WHERE kd_jamnyala = '$KD_JAMNYALA_EMIN_BARU' ");
					foreach($q->result() as $r){
						$NILAI_JAMNYALA_EMIN_BARU = (empty($r->nilai_jamnyala)) ? '0' : $r->nilai_jamnyala;
					}

					switch ($STS) {
						case "ADA":

							$q = $this->db->query("SELECT TGL_MUT, DAYA_LAMA, TARIF_LAMA, FK_METER_LAMA, FRT_LAMA, DAYA_BARU, TARIF_BARU, FK_METER_BARU, FRT_BARU, KD_JAMNYALA_EMIN_LAMA, MONTH(TGL_MUT) BLN_MUT, YEAR(TGL_MUT) THN_MUT
														FROM DPM_LISTRIK_REF_PECAHAN
													WHERE ID_LANG = '$ID_LANG' AND THBLREK = '$THBLREK'
													");
							foreach($q->result() as $r)
							{
								$TGL_MUT		= $r->TGL_MUT;
								$DAYA_LAMA		= $r->DAYA_LAMA;
								$TARIF_LAMA		= $r->TARIF_LAMA;
								$FK_METER_LAMA	= $r->FK_METER_LAMA;
								$FRT_LAMA		= $r->FRT_LAMA;
								$DAYA_BARU		= $r->DAYA_BARU;
								$TARIF_BARU		= $r->TARIF_BARU;
								$FK_METER_BARU	= $r->FK_METER_BARU;
								$FRT_BARU		= $r->FRT_BARU;
								$KD_JAMNYALA_EMIN_LAMA = $r->KD_JAMNYALA_EMIN_LAMA;
								$BLN_MUT		= $r->BLN_MUT;
								$THN_MUT		= $r->THN_MUT;
							}


							#GANDA - Pelanggan Pasang Baru atau bukan
							if($KD_MUT == "A")
							{
								#selisih LWBP awal dan bongkar
								$SEL_HAR_PA = sel_hari($TGL_MUT,$TGL_BACA_AKHIR);
								#PEMBAGI JAMNYALA EMIN
								$JHMUT = $this->jml_hari_ini($BLN_MUT,$THN_MUT);
								#LWBP
								$SEL_STAND_LWBP = ROUND(($STAND_AKHIR_LWBP - $STAND_PSG_LWBP) * $FK_METER_BARU * $FRT_BARU,2) ;
								$PEMLWBP_CATER  = ROUND($SEL_STAND_LWBP);
								$LWBP_MPA = $PEMLWBP_CATER;
								#WBP
								$SEL_STAND_WBP	= ROUND(($STAND_AKHIR_WBP - $STAND_PSG_WBP) * $FK_METER_BARU * $FRT_BARU,2) ;
								$PEMWBP_CATER   = ROUND($SEL_STAND_WBP);
								$WBP_MPA = $PEMWBP_CATER;
								#KVARH
								$SEL_STAND_KVARH= ROUND(($STAND_AKHIR_KVARH - $STAND_PSG_KVARH) * $FK_METER_BARU * $FRT_BARU,2) ;
								$PEMKVARH_CATER = ROUND($SEL_STAND_KVARH);
								$KVARH_MPA = $PEMKVARH_CATER;
								#PEMKWH
								$PEMKWH_CATER	= $PEMLWBP_CATER + $PEMWBP_CATER;
								$KWH_MPA = $PEMKWH_CATER;
								#JAM NYALA
								$JAM_NYALA_CATER = ROUND(($PEMKWH_CATER / ($DAYA_BARU / 1000) ),2);
								$JAM_NYALA_PA = ROUND($JAM_NYALA_CATER);
								#KWHEMIN_PA
								$KWHEMIN_PAX = ROUND(( ($DAYA_BARU/1000)*(($NILAI_JAMNYALA_EMIN_BARU/$JHMUT)*$SEL_HAR_PA) ),2);
								$KWHEMIN_PA  = ROUND($KWHEMIN_PAX);
								#ANALISA DATA LANGGANAN
								$JUM_REK	= 0;
								$KWH_MIN	= 0;
								$KWH_RATA2	= 0;
								$KWH_MAX	= 0;

								#3. Pelanggan Pasang Baru
								$STATUS_DLPD = "A - Pelanggan Pasang Baru";

								#UPDATE -> DPM_LISTRIK_REF
								$this->db->query("UPDATE DPM_LISTRIK_REF SET
													PEMLWBP_CATER 	= '$PEMLWBP_CATER',
													PEMWBP_CATER 	= '$PEMWBP_CATER',
													PEMKVARH_CATER 	= '$PEMKVARH_CATER',
													PEMKWH_CATER 	= '$PEMKWH_CATER',
													JAM_NYALA_CATER = '$JAM_NYALA_CATER',
													KWH_MIN			= '$KWH_MIN',
													KWH_RATA2		= '$KWH_RATA2',
													KWH_MAX			= '$KWH_MAX',
													STATUS_DLPD		= '$STATUS_DLPD',
													NILAI_JAMNYALA_EMIN_BARU = '$NILAI_JAMNYALA_EMIN_BARU',
													STATUS_DPM 		= '2'
												WHERE ID_LANG='$ID_LANG' ");

								#UPDATE -> DPM_LISTRIK_REF_PECAHAN
								$this->db->query("UPDATE DPM_LISTRIK_REF_PECAHAN SET
													SEL_HAR_PA 		= '$SEL_HAR_PA',
													LWBP_MPA 		= '$LWBP_MPA',
													WBP_MPA 		= '$WBP_MPA',
													KVARH_MPA 		= '$KVARH_MPA',
													KWH_MPA 		= '$KWH_MPA',
													JAM_NYALA_PA 	= '$JAM_NYALA_PA',
													KWHEMIN_PA 		= '$KWHEMIN_PA'
												WHERE ID_LANG='$ID_LANG' AND THBLREK = '$THBLREK' ");

							}
							else
							{
								#GANDA - Bukan Pelanggan Baru

								#NILAI_JAMNYALA_EMIN_LAMA
								$s = $this->db->query("SELECT nilai_jamnyala
														FROM TR_JAMNYALA WHERE kd_jamnyala = '$KD_JAMNYALA_EMIN_LAMA' ");
								foreach($s->result() as $t){
									$NILAI_JAMNYALA_EMIN_LAMA = (empty($t->nilai_jamnyala)) ? '0' : $t->nilai_jamnyala;
								}

								#selisih hari awal dan boongkar
								$SEL_HAR_AB = sel_hari($TGL_BACA_AWAL,$TGL_MUT);
								#Pembagi Jam nyala emin
								IF($DAYA_LAMA == $DAYA_BARU){
										$JH = sel_hari($TGL_BACA_AWAL,$TGL_BACA_AKHIR);
								}else{
										$JH = $this->jml_hari_ini($BLN_MUT,$THN_MUT);
								}
								#LWBP_MAB
								$SEL_LWBP_MAB = ROUND(($STAND_BKR_LWBP - $STAND_AWAL_LWBP) * $FK_METER_LAMA * $FRT_LAMA,2) ;
								$LWBP_MAB  = ROUND($SEL_LWBP_MAB);
								#WBP_MAB
								$SEL_WBP_MAB = ROUND(($STAND_BKR_WBP - $STAND_AWAL_WBP) * $FK_METER_LAMA * $FRT_LAMA,2) ;
								$WBP_MAB  = ROUND($SEL_WBP_MAB);
								#KVARH_MAB
								$SEL_KVARH_MAB = ROUND(($STAND_BKR_KVARH - $STAND_AWAL_KVARH) * $FK_METER_LAMA * $FRT_LAMA,2);
								$KVARH_MAB  = ROUND($SEL_KVARH_MAB);
								#KWH_MAB
								$KWH_MAB	= $LWBP_MAB + $WBP_MAB;
								#JAM NYALA_AB
								$JAM_NYALA_ABX = ROUND(($KWH_MAB / ($DAYA_LAMA / 1000) ),2);
								$JAM_NYALA_AB  = ROUND($JAM_NYALA_ABX);
								#KWHEMIN_AB
								$KWHEMIN_AB = ROUND( (($DAYA_LAMA/1000)*(($NILAI_JAMNYALA_EMIN_LAMA/$JH)*$SEL_HAR_AB)),2 );

								#selisih hari pasang dan akhir
								$SEL_HAR_PA = sel_hari($TGL_MUT,$TGL_BACA_AKHIR);
								#LWBP_MPA
								$SEL_LWBP_MPA = ROUND(($STAND_AKHIR_LWBP - $STAND_PSG_LWBP) * $FK_METER * $FRT,2) ;
								$LWBP_MPA  = ROUND($SEL_LWBP_MPA);
								#WBP_MPA
								$SEL_WBP_MPA = ROUND(($STAND_AKHIR_WBP - $STAND_PSG_WBP) * $FK_METER * $FRT,2) ;
								$WBP_MPA  = ROUND($SEL_WBP_MPA);
								#KVARH_MPA
								$SEL_KVARH_MPA = ROUND(($STAND_AKHIR_KVARH - $STAND_PSG_KVARH) * $FK_METER * $FRT,2) ;
								$KVARH_MPA  = ROUND($SEL_KVARH_MPA);
								#KWH_MPA
								$KWH_MPA	= $LWBP_MPA + $WBP_MPA;
								#JAM NYALA_PA
								$JAM_NYALA_PAX = ROUND(($KWH_MPA / ($DAYA / 1000) ),2);
								$JAM_NYALA_PA  = ROUND($JAM_NYALA_PAX);
								#KWHEMIN_PA
								$KWHEMIN_PAX = ROUND(( ($DAYA/1000)*(($NILAI_JAMNYALA_EMIN_BARU/$JH)*$SEL_HAR_PA) ),0);
								$KWHEMIN_PA  = ROUND($KWHEMIN_PAX);
								#PERHITUNGAN FINAL
								$PEMLWBP_CATER = $LWBP_MAB + $LWBP_MPA;
								$PEMWBP_CATER = $WBP_MAB + $WBP_MPA;
								$PEMKVARH_CATER = $KVARH_MAB + $KVARH_MPA;
								$PEMKWH_CATER = $PEMLWBP_CATER + $PEMWBP_CATER;
								$JAM_NYALA_CATER = $JAM_NYALA_AB + $JAM_NYALA_PA;

								#ANALISA DATA LANGGANAN
								$JUM_REK	= 0;
								$KWH_MIN	= 0;
								$KWH_RATA2	= 0;
								$KWH_MAX	= 0;

								$STATUS_DLPD = "F - Rekening Pecahan";

								#UPDATE -> DPM_LISTRIK_REF
								$this->db->query("UPDATE DPM_LISTRIK_REF SET
													NILAI_JAMNYALA_EMIN_BARU 	= '$NILAI_JAMNYALA_EMIN_BARU',
													PEMLWBP_CATER 				= '$PEMLWBP_CATER',
													PEMWBP_CATER 				= '$PEMWBP_CATER',
													PEMKVARH_CATER 				= '$PEMKVARH_CATER',
													PEMKWH_CATER 				= '$PEMKWH_CATER',
													JAM_NYALA_CATER 			= '$JAM_NYALA_CATER',
													KWH_MIN						= '$KWH_MIN',
													KWH_RATA2					= '$KWH_RATA2',
													KWH_MAX						= '$KWH_MAX',
													STATUS_DLPD					= '$STATUS_DLPD',
													STATUS_DPM			 		= '2'
												WHERE ID_LANG='$ID_LANG' ");

								#UPDATE -> DPM_LISTRIK_REF_PECAHAN
								$this->db->query("UPDATE DPM_LISTRIK_REF_PECAHAN SET
													NILAI_JAMNYALA_EMIN_LAMA 	= '$NILAI_JAMNYALA_EMIN_LAMA',
													SEL_HAR_AB 					= '$SEL_HAR_AB',
													LWBP_MAB 					= '$LWBP_MAB',
													WBP_MAB 					= '$WBP_MAB',
													KVARH_MAB 					= '$KVARH_MAB',
													KWH_MAB 					= '$KWH_MAB',
													JAM_NYALA_AB 				= '$JAM_NYALA_AB',
													KWHEMIN_AB 					= '$KWHEMIN_AB',

													SEL_HAR_PA 					= '$SEL_HAR_PA',
													LWBP_MPA 					= '$LWBP_MPA',
													WBP_MPA 					= '$WBP_MPA',
													KVARH_MPA 					= '$KVARH_MPA',
													KWH_MPA 					= '$KWH_MPA',
													JAM_NYALA_PA 				= '$JAM_NYALA_PA',
													KWHEMIN_PA 					= '$KWHEMIN_PA'
												WHERE ID_LANG='$ID_LANG' AND THBLREK = '$THBLREK' ");

							}

							break;
						case "TIDAK":

							#LWBP
							$SEL_STAND_LWBP = ROUND(($STAND_AKHIR_LWBP - $STAND_AWAL_LWBP)* $FK_METER * $FRT,2);
							$PEMLWBP_CATER  = ROUND($SEL_STAND_LWBP);
							#WBP
							$SEL_STAND_WBP	= ROUND(($STAND_AKHIR_WBP - $STAND_AWAL_WBP)* $FK_METER * $FRT,2) ;
							$PEMWBP_CATER   = ROUND($SEL_STAND_WBP);
							#KVARH
							$SEL_STAND_KVARH= ROUND(($STAND_AKHIR_KVARH - $STAND_AWAL_KVARH) * $FK_METER * $FRT,2) ;
							$PEMKVARH_CATER = ROUND($SEL_STAND_KVARH);
							#PEMKWH
							$PEMKWH_CATER	= $PEMLWBP_CATER + $PEMWBP_CATER;
							#JAM NYALA
							$JAM_NYALA_CATERX = ROUND( ($PEMKWH_CATER / ($DAYA / 1000) ),2);
							$JAM_NYALA_CATER  = ROUND($JAM_NYALA_CATERX);
							#NILAI_JAMNYALA
							$this->db->query("UPDATE DPM_LISTRIK_REF a
												LEFT JOIN TR_JAMNYALA b ON a.KD_JAMNYALA_EMIN_BARU = b.KD_JAMNYALA
												SET a.NILAI_JAMNYALA_EMIN_BARU = b.NILAI_JAMNYALA ");

							#ANALISA DATA LANGGANAN
							$q = $this->db->query("SELECT
														IFNULL(COUNT(ID_LANG),0) JUM_REK, IFNULL(MIN(PEMKWH_CATER),0) KWH_MIN, IFNULL(MAX(PEMKWH_CATER),0) KWH_MAX, IFNULL(ROUND(AVG(PEMKWH_CATER)),0) KWH_RATA2
													FROM DPM_LISTRIK_LOG
													WHERE ID_LANG = '$ID_LANG' AND THBLREK >= '$mintiga' ");
							foreach($q->result() as $r)
							{
								$JUM_REK	= (empty($r->JUM_REK)) ? '0' : $r->JUM_REK ;
								$KWH_MIN	= (empty($r->KWH_MIN)) ? '0' : $r->KWH_MIN;
								$KWH_RATA2	= (empty($r->KWH_RATA2)) ? '0' : $r->KWH_RATA2;
								$KWH_MAX	= (empty($r->KWH_MAX)) ? '0' : $r->KWH_MAX;
							}

							#ANALISA PEMAKAIAN KWH DIATAS RATA2
							$ANALISA_KWH = 0;

							//$STATUS_DLPD = "0";

							if( ($SEL_STAND_LWBP < 0) AND ($SEL_STAND_WBP < 0) AND ($SEL_STAND_KVARH < 0) )
							{
								#1. STAND KWH METER MUNDUR
								$STATUS_DLPD = "G - Stand kWh Meter mundur";
							}

							if( ($SEL_STAND_LWBP == 0) AND ($SEL_STAND_WBP == 0) AND ($SEL_STAND_KVARH == 0) )
							{
								#2. Pemk. kWh 0 - NOL
								$STATUS_DLPD = "H - Pemk. kWh 0 - NOL";
							}
							else
							{
								#10. kWh Normal
								$STATUS_DLPD = "J - kWh Normal";
							}

							$this->db->query("UPDATE DPM_LISTRIK_REF SET
												PEMLWBP_CATER 		= '$PEMLWBP_CATER',
												PEMWBP_CATER 		= '$PEMWBP_CATER',
												PEMKVARH_CATER 		= '$PEMKVARH_CATER',
												PEMKWH_CATER 		= '$PEMKWH_CATER',
												JAM_NYALA_CATER 	= '$JAM_NYALA_CATER',
												KWH_MIN				= '$KWH_MIN',
												KWH_RATA2			= '$KWH_RATA2',
												KWH_MAX				= '$KWH_MAX',
												STATUS_DLPD			= '$STATUS_DLPD',
												STATUS_DPM 			= '2'
											WHERE ID_LANG='$ID_LANG' ");

							break;
						default:
							$this->session->set_flashdata('msg','Ada kesalah dalam proses hitung KWH');
					}
				}
				echo json_encode(array("status" => TRUE));
				$this->session->set_flashdata('msg','Proses Hitung KWH Sukses');
	}

	public function hitung_list()
	{
		$list = $this->caterm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->ID_LANG;
			$row[] = $cater->NAMA_LANG;
			$row[] = number_format($cater->PEMLWBP_CATER,0,',','.');
			$row[] = number_format($cater->PEMWBP_CATER,0,',','.');
			$row[] = number_format($cater->PEMKVARH_CATER,0,',','.');
			$row[] = number_format($cater->PEMKWH_CATER,0,',','.');
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->caterm->count_all(),
						"recordsFiltered" => $this->caterm->count_filtered(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function uploaddpmfinal(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$datax['thblrek']= $this->get_thblrek();
			$this->load->view('cater/uploaddpmfinal',$datax);
		}else{
			redirect('welcome/index');
		}
	}

	public function prosesuploaddpmfinal(){
		#Hapus data di DPM NEW sebelum di INSERT
		$delnew= $this->db->query("DELETE FROM DPM_LISTRIK_NEW");
		$tonew = $this->db->query("INSERT INTO DPM_LISTRIK_NEW SELECT * FROM DPM_LISTRIK_REF WHERE STATUS_DPM = '2' ");
		$ch1   = $this->db->query("UPDATE DPM_LISTRIK_REF SET STATUS_DPM ='3' WHERE ID_LANG IN (SELECT ID_LANG FROM DPM_LISTRIK_NEW) ");
		$ch2   = $this->db->query("UPDATE DPM_LISTRIK_NEW SET STATUS_DPM ='3' ");
		#Jika INSERT KE DPM NEW SUKSES MAKA INSERT KE BILLING REF
		IF($tonew){
			$this->db->query("TRUNCATE BILLING_LISTRIK_REF ");
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
								WHERE STATUS_DPM = '3' ");

			$this->db->query("UPDATE BILLING_LISTRIK_REF a
								INNER JOIN
								(
									SELECT ID_LANG, KOGOL, KD_JAMNYALA_EMIN, KD_PPJ, KD_BK
									FROM DIL_LISTRIK_NEW a
								) b ON a.ID_LANG = b.ID_LANG
								SET a.KOGOL = b.KOGOL, a.KD_JAMNYALA_EMIN = b.KD_JAMNYALA_EMIN, a.KD_PPJ = b.KD_PPJ, a.KD_BK = b.KD_BK ");

			$this->db->query("UPDATE BILLING_LISTRIK_REF SET STATUS_BILLING = '0' ");
			#DELETE BILING LISTRIK REF PECAHAN
			$this->db->query("DELETE FROM BILLING_LISTRIK_REF_PECAHAN
								WHERE THBLREK IN (SELECT MAX(THBLREK) FROM DPM_LISTRIK_REF_PECAHAN)");
			#INSERT INTO BILLING_LISTRIK_REF_PECAHAN
			$this->db->query("INSERT INTO BILLING_LISTRIK_REF_PECAHAN
								(
									THBLREK,ID_CUST,ID_LANG,DAYA_LAMA,TARIF_LAMA,TGL_MUT,FK_METER_LAMA,FRT_LAMA,SEL_HAR_AB,JAM_NYALA_AB,KWHEMIN_AB,LWBP_MAB,WBP_MAB,KVARH_MAB,KWH_MAB,DAYA_BARU,TARIF_BARU,FK_METER_BARU,FRT_BARU,SEL_HAR_PA,JAM_NYALA_PA,KWHEMIN_PA,LWBP_MPA,WBP_MPA,KVARH_MPA,KWH_MPA,KD_JAMNYALA_EMIN_LAMA,NILAI_JAMNYALA_EMIN_LAMA
								)
								SELECT
									THBLREK,ID_CUST,ID_LANG,DAYA_LAMA,TARIF_LAMA,TGL_MUT,FK_METER_LAMA,FRT_LAMA,SEL_HAR_AB,JAM_NYALA_AB,KWHEMIN_AB,LWBP_MAB,WBP_MAB,KVARH_MAB,KWH_MAB,DAYA_BARU,TARIF_BARU,FK_METER_BARU,FRT_BARU,SEL_HAR_PA,JAM_NYALA_PA,KWHEMIN_PA,LWBP_MPA,WBP_MPA,KVARH_MPA,KWH_MPA,KD_JAMNYALA_EMIN_LAMA,NILAI_JAMNYALA_EMIN_LAMA
								FROM DPM_LISTRIK_REF_PECAHAN
								WHERE THBLREK = (SELECT MAX(THBLREK) FROM DPM_LISTRIK_REF_PECAHAN )
							");
			echo json_encode(array("status" => TRUE));
		}else{
			echo json_encode(array("status" => FALSE));
		}
	}

	public function final_list()
	{
		$this->load->model('billingm');
		$list = $this->billingm->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $billing) {
			$no++;
			$row = array();
			$row[] = $billing->THBLREK;
			$row[] = $billing->ID_LANG;
			$row[] = $billing->NAMA_LANG;
			$row[] = number_format($billing->PEMLWBP_CATER,0,',','.');
			$row[] = number_format($billing->PEMWBP_CATER,0,',','.');
			$row[] = number_format($billing->PEMKWH_CATER,0,',','.');
			$row[] = number_format($billing->PEMKVARH_CATER,0,',','.');
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
	
	public function carilang($idcari=''){
		$data_langganan = $this->caterm->get_langganan($idcari);
		echo json_encode($data_langganan);
	}

	public function koreksistandawal(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('cater/koreksistandawal');
		}else{
			redirect('welcome/index');
		}
	}
	
	public function proseshitungkwhperlang($idcari,$stawallwbp,$stawalwbp,$stawalkvarh,$stbkrlwbp,$stbkrwbp,$stbkrkvarh,$stpsglwbp,$stpsgwbp,$stpsgkvarh,$stakhirlwbp,$stakhirwbp,$stakhirkvarh){
		$data_hitung = $this->caterm->proseshitungkwhperlang($idcari,$stawallwbp,$stawalwbp,$stawalkvarh,$stbkrlwbp,$stbkrwbp,$stbkrkvarh,$stpsglwbp,$stpsgwbp,$stpsgkvarh,$stakhirlwbp,$stakhirwbp,$stakhirkvarh);
		echo json_encode($data_hitung);
	}
	
	public function prosessimpankwhperlang($idcari,$stawallwbp,$stawalwbp,$stawalkvarh,$stbkrlwbp,$stbkrwbp,$stbkrkvarh,$stpsglwbp,$stpsgwbp,$stpsgkvarh,$stakhirlwbp,$stakhirwbp,$stakhirkvarh){
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
		$this->db->insert("LOG_KOREKSISTAND",$datalog);
		
		$data_hitung = $this->caterm->prosessimpankwhperlang($idcari,$stawallwbp,$stawalwbp,$stawalkvarh,$stbkrlwbp,$stbkrwbp,$stbkrkvarh,$stpsglwbp,$stpsgwbp,$stpsgkvarh,$stakhirlwbp,$stakhirwbp,$stakhirkvarh);
		echo json_encode(array("status" => TRUE));
	}
	

	public function koreksistandakhir(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);
			$this->load->view('cater/koreksistandakhir');
		}else{
			redirect('welcome/index');
		}
	}

	public function monitoringcater(){
		if($this->session->userdata('ket')<>''){
			$data['prev']=$this->mmenu->main_menu();
			$this->load->view('head',$data);

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

			$this->load->view('cater/monitoringcater',$datax);
		}else{
			redirect('welcome/index');
		}
	}
	
	function downloadexcelstandakhir(){
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d h:i:s');				
		
		$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
		
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'ID_LANG')
            ->setCellValue('C1', 'NAMA_LANG')
            ->setCellValue('D1', 'ALAMAT_LANG')
            ->setCellValue('E1', 'NO_METER')
            ->setCellValue('F1', 'TARIF')
            ->setCellValue('G1', 'DAYA')
            ->setCellValue('H1', 'TGL_BACA_AWAL')
            ->setCellValue('I1', 'STAND_AWAL_LWBP')
            ->setCellValue('J1', 'STAND_AWAL_WBP')
            ->setCellValue('K1', 'STAND_AWAL_KVARH')
            ->setCellValue('L1', 'TGL_BACA_AKHIR')
            ->setCellValue('M1', 'STAND_AKHIR_LWBP')
            ->setCellValue('N1', 'STAND_AKHIR_WBP')
            ->setCellValue('O1', 'STAND_AKHIR_KVARH')
			 ->setCellValue('P1', 'THBLREK');
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT a.THBLREK, a.ID,b.ID_LANG,b.NAMA_LANG,b.ALAMAT_LANG,b.NO_METER,b.TARIF,b.DAYA, a.TGL_BACA_AWAL, a.STAND_AWAL_LWBP, a.STAND_AWAL_WBP, a.STAND_AWAL_KVARH, a.TGL_BACA_AKHIR, a.STAND_AKHIR_LWBP, a.STAND_AKHIR_WBP, a.STAND_AKHIR_KVARH 
						FROM DPM_LISTRIK_REF a
						JOIN DIL_LISTRIK_NEW b ON a.ID_LANG=b.ID_LANG";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->ID);
            $ex->setCellValue('B'.$counter, $row->ID_LANG);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->ALAMAT_LANG);
            $ex->setCellValue('E'.$counter, $row->NO_METER);
            $ex->setCellValue('F'.$counter, $row->TARIF);
            $ex->setCellValue('G'.$counter, $row->DAYA);
            $ex->setCellValue('H'.$counter, $row->TGL_BACA_AWAL);
            $ex->setCellValue('I'.$counter, $row->STAND_AWAL_LWBP);
            $ex->setCellValue('J'.$counter, $row->STAND_AWAL_WBP);
            $ex->setCellValue('K'.$counter, $row->STAND_AWAL_KVARH);
            $ex->setCellValue('L'.$counter, $row->TGL_BACA_AKHIR);
            $ex->setCellValue('M'.$counter, $row->STAND_AKHIR_LWBP);
            $ex->setCellValue('N'.$counter, $row->STAND_AKHIR_WBP);
            $ex->setCellValue('O'.$counter, $row->STAND_AKHIR_KVARH);
			$ex->setCellValue('P'.$counter, $row->THBLREK);
            
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("Stand Akhir")
            ->setSubject("Stand Akhir")
            ->setDescription("Stand Akhir by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Stand AKhir");
        $objPHPExcel->getActiveSheet()->setTitle('Stand AKhir');
        $TitlE 		= "Hasil Download Stand Akhir";
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
	
	public function daftarstand_list()
	{
		$list = $this->caterm->get_datatables_daftarstand();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->ID_LANG;
			$row[] = $cater->TGL_BACA_AKHIR;
			$row[] = number_format($cater->STAND_AKHIR_LWBP);
			$row[] = number_format($cater->STAND_AKHIR_WBP);
			$row[] = number_format($cater->STAND_AKHIR_KVARH);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->caterm->count_all_daftarstand(),
						"recordsFiltered" => $this->caterm->count_filtered_daftarstand(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapkwh_list()
	{
		$list = $this->caterm->get_datatables_rekapkwh();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->KD_AREA;
			$row[] = $cater->JML_LANG;
			$row[] = number_format($cater->JML_DAYA);
			$row[] = number_format($cater->PEMKWH_CATER);
			$row[] = number_format($cater->PEMKVARH_CATER);
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->caterm->count_all_rekapkwh(),
						"recordsFiltered" => $this->caterm->count_filtered_rekapkwh(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function rekapdlpd_list()
	{
		$list = $this->caterm->get_datatables_rekapdlpd();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $cater) {
			$no++;
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->KD_AREA;
			$row[] = $cater->STATUS_DLPD;
			$KDDLPD= substr($cater->STATUS_DLPD,0,1);
			$row[] = "<a href='javascript:void(0)' title='Lihat' onclick='cek_jmllang(".$cater->THBLREK.",".$cater->KD_AREA.",".'"'."$KDDLPD".'"'.")'>".$cater->JML_LANG."</a>";
			$data[] = $row;
		}
		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->caterm->count_all_rekapdlpd(),
						"recordsFiltered" => $this->caterm->count_filtered_rekapdlpd(),
						"data" => $data,
				);
		echo json_encode($output);
	}

	public function detdlpd_list()
	{
		$THBLREK = $this->input->post('THBLREK');
		$KD_AREA = $this->input->post('KD_AREA');
		$STSDLPD = $this->input->post('STSDLPD');
		$list = $this->caterm->get_datatables_detdlpd($THBLREK,$KD_AREA,$STSDLPD);
		$data = array();
		foreach ($list as $cater) {
			$row = array();
			$row[] = $cater->THBLREK;
			$row[] = $cater->KD_AREA;
			$row[] = $cater->STATUS_DLPD;
			$row[] = $cater->ID_LANG;
			$row[] = $cater->NAMA_LANG;

			$data[] = $row;
		}
		$output = array(
						"recordsTotal" => $this->caterm->count_all_detdlpd($THBLREK,$KD_AREA,$STSDLPD),
						"recordsFiltered" => $this->caterm->count_filtered_detdlpd(),
						"data" => $data,
				);
		echo json_encode($output);
	}

}
