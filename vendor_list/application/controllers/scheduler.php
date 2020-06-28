<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Scheduler extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}
	
	public function update_tanggal(){
		date_default_timezone_set('Asia/Jakarta');	
		$hari_ini = $this->db->query("select NOW() as tgl from epi_cargo.ws_epi")->row()->tgl;
		$data_update["TGLSYSTEM"] = $hari_ini;
		$this->db->update("epi_cargo.ws_epi",$data_update,"ID IN (1)");
		echo $hari_ini;
	}

	public function update_rpbk(){
			$TGLJT = $this->db->query("SELECT   @TJ := MAX(TGLJTTEMPO) TGLJTTEMPO FROM epi_cargo.ws_epi WHERE (TGLBAYAR IS NULL OR TGLBAYAR='') AND STATUS_LUNAS='0'
										AND (SELECT MAX(TGLJTTEMPO) FROM epi_cargo.ws_epi) < NOW() ");
		if($TGLJT->num_rows() > 0 ){
			$this->db->query("DROP TABLE IF EXISTS epi_cargo.DATA_PEL");
			$this->db->query("CREATE TEMPORARY TABLE epi_cargo.DATA_PEL (
								  ID INT NOT NULL AUTO_INCREMENT, PRIMARY KEY (`ID`),
								  THBLREK varchar (7),
								  ID_LANG varchar (30),
								  TGLJTTEMPO date,
								  STATUS_BK int,
								  RPBK1 int,
								  RPBK2 int,
								  RPBK3 int,
								  RP_BK int, 
								  STATUS_LUNAS int ) 
							");
			$this->db->query("INSERT INTO epi_cargo.DATA_PEL (THBLREK, ID_LANG, TGLJTTEMPO, STATUS_BK, RPBK1, RPBK2, RPBK3, RP_BK, STATUS_LUNAS)
								SELECT THBLREK, ID_LANG , @TJ TGLJTTEMPO, STATUS_BK, RPBK1,
								RPBK2, RPBK3, RP_BK, STATUS_LUNAS FROM epi_cargo.ws_epi 
								WHERE (TGLBAYAR IS NULL OR TGLBAYAR='') AND STATUS_LUNAS='0' AND KOGOL IN ('0','4') ");
			
			$this->db->query("UPDATE  epi_cargo.ws_epi a
								INNER JOIN 
								(
									SELECT THBLREK, ID_LANG , TGLJTTEMPO, STATUS_BK, RPBK1, RPBK2, RPBK3, RP_BK, STATUS_LUNAS
									FROM epi_cargo.DATA_PEL a
								) b ON a.ID_LANG = b.ID_LANG
								SET a.RP_BK = CASE WHEN a.RP_BK < b.RPBK1  THEN b.RPBK1 
												WHEN a.RP_BK < b.RPBK2  THEN b.RPBK2
												WHEN a.RP_BK < b.RPBK3  THEN b.RPBK3 
												ELSE b.RPBK3 END ,
									a.STATUS_BK = CASE WHEN a.RP_BK < b.RPBK1  THEN '1' 
													WHEN a.RP_BK < b.RPBK2  THEN '2'
													WHEN a.RP_BK < b.RPBK3  THEN '3' 
													ELSE '3' END 
								WHERE CONCAT(a.THBLREK,a.ID_LANG) = CONCAT(b.THBLREK,b.ID_LANG) AND a.KOGOL IN ('0','4') ");
			$this->db->query("UPDATE epi_cargo.ws_epi SET TOTAL_INVOICE = RP_BK+RPTAG where CONCAT(THBLREK,ID_LANG) IN (SELECT CONCAT(THBLREK,ID_LANG) FROM EPI_CARGO.DATA_PEL) ");
			$this->db->query("UPDATE epi_dbx.master_rekening a
								INNER JOIN 
								(
									SELECT THBLREK, ID_LANG, STATUS_BK, RPBK1, RPBK2, RPBK3, RP_BK, (RPTAG+RP_BK) TOTAL_INV
									FROM epi_cargo.ws_epi a
								) b ON CONCAT(a.THBLREK,a.ID_LANG) = CONCAT(b.THBLREK,b.ID_LANG)
								SET a.STATUS_BK = b.STATUS_BK, a.RPBK1 = b.RPBK1, a.RPBK2 = b.RPBK2, a.RPBK3 = b.RPBK3, a.RP_BK = b.RP_BK, a.TOTAL_INVOICE = b.TOTAL_INV
								WHERE CONCAT(a.THBLREK,a.ID_LANG) IN (SELECT CONCAT(a.THBLREK,a.ID_LANG) FROM epi_cargo.DATA_PEL) AND AND a.KOGOL IN ('0','4') ");
								
			echo "semua data sudah terupdate.";
		}else{
			echo "tidak ada update";
		}
	}

	public function update_lunas(){
		$data_epi = $this->db->query("select * from epi_cargo.ws_dpp where STATUS='0'");
		$no=0;
		foreach($data_epi->result() as $row){
			$data_update['TGL_LUNAS'] = $row->TGL_LUNAS;
			$data_update['USER_LUNAS'] = $row->USER_LUNAS;
			$data_update['STATUS_LUNAS'] = '1';
			$data_update['EPIREFNO'] = $row->EPIREFNO;
			$data_update['GSPREFNO'] = $row->GSPREFNO;
			$this->db->update("master_rekening",$data_update,array("ID_LANG"=>$row->ID_LANG,"THBLREK"=>$row->THBLREK));
			$update_status['STATUS'] = "1";
			$this->db->update("epi_cargo.ws_dpp",$update_status,array("ID_LANG"=>$row->ID_LANG,"THBLREK"=>$row->THBLREK));
		}
		echo "<pre>";
		if(!empty($data_epi->result_array())){
			print_r($data_epi->result_array());
		}else{
			echo "semua data sudah terupdate.";
		}
	}

}