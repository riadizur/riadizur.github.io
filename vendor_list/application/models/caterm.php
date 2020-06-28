<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Caterm extends CI_Model {

	var $table = 'dil_listrik_ref';
	var $column_order = array('dpm_listrik_ref.ID_LANG','NAMA_LANG','dpm_listrik_ref.TGL_BACA_AKHIR','dpm_listrik_ref.STAND_AKHIR_LWBP','dpm_listrik_ref.STAND_AKHIR_WBP','dpm_listrik_ref.STAND_AKHIR_KVARH',null); 
	var $column_search = array('dpm_listrik_ref.ID_LANG','dil_listrik_new.NAMA_LANG');
	var $order = array('dpm_listrik_ref.ID_LANG' => 'ASC'); 
	
	var $column_orderx = array('TGL_BACA_AKHIR','ID_LANG'); 
	var $column_searchx = array('ID_LANG');
	var $orderx = array('KD_AREA' => 'asc'); 

	public function __construct()
	{
		parent::__construct();
	}
	
	private function _get_datatables_query()
	{
		$this->db->from('dpm_listrik_ref');
		$this->db->join('dil_listrik_new','dpm_listrik_ref.ID_LANG=dil_listrik_new.ID_LANG');
		$i = 0;
		foreach ($this->column_search as $item) 
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('dpm_listrik_ref');
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from('cust');
		$this->db->where('id_cust',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($table,$where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	public function get_dpmref($idcari='')
    {
		$query = $this->db->query("SELECT * FROM dpm_listrik_ref WHERE id_lang = '$idcari' LIMIT 1");
		return $agenda = $query->result();
    }
	
	public function cekdilnew()
    {	
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		$cek = $this->db->query("SELECT DISTINCT THBLREK FROM DIL_LISTRIK_NEW WHERE THBLREK = '$plussatu' ");
		if($cek->num_rows() > 0){
			return $cekdilnew = $cek->result();
		}else{
			return $cekdilnew = ['BELUM MELAKUKAN CUT OFF DIL'];
		}
	}
	
	public function cekstatusdpm()
    {
		$cek = $this->db->query("SELECT DISTINCT STATUS_DPM FROM DPM_LISTRIK_REF ");
		if($cek->num_rows() > 0){
			return $cekstatusdpm = $cek->result();
		}else{
			return $cekstatusdpm = ['SUDAH TIDAK BISA'];
		}
	}
	
	public function cekbilling()
    {	
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM BILLING_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));
		$cek = $this->db->query("SELECT DISTINCT THBLREK FROM BILLING_LISTRIK_REF WHERE THBLREK = '$plussatu' ");
		if($cek->num_rows() > 0){
			return $cekbilling = $cek->result();
		}else{
			return $cekbilling = ['SUDAH SAMPAI BILLING'];
		}
	}
	
	#MENU MONITORING
	function get_datatables_daftarstand()
	{
		$this->_get_datatables_daftarstand();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_daftarstand()
	{
		$this->db->select("THBLREK, ID_LANG, TGL_BACA_AKHIR, STAND_AKHIR_LWBP, STAND_AKHIR_WBP, STAND_AKHIR_KVARH");
		$this->db->from("DPM_LISTRIK_REF");
		$i = 0;
		foreach ($this->column_searchx as $item) 
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_searchx) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderx[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderx))
		{
			$order = $this->orderx;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_daftarstand()
	{
		$this->_get_datatables_daftarstand();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_daftarstand()
	{
		$this->db->from('dpm_listrik_ref');
		return $this->db->count_all_results();
	}
	
	#REKAP STAND
	public function rekapstand_list()
    {
        $query = $this->db->query("SELECT THBLREK,KD_AREA,SUM(JML_LANG) JML_LANG,SUM(BELUM_ENTRI) BELUM_ENTRI, SUM(SUDAH_ENTRI) SUDAH_ENTRI FROM (
									SELECT THBLREK, KD_AREA, COUNT(ID_LANG) JML_LANG, '' BELUM_ENTRI, '' SUDAH_ENTRI
									FROM DPM_LISTRIK_REF GROUP BY KD_AREA
									UNION ALL
									SELECT THBLREK, KD_AREA,'0' JML_LANG, 
									IFNULL((SELECT COUNT(TGL_BACA_AKHIR) FROM DPM_LISTRIK_REF
									WHERE TGL_BACA_AKHIR = '0000-00-00' OR ISNULL(TGL_BACA_AKHIR) OR TGL_BACA_AKHIR = ''  GROUP BY KD_AREA),0) BELUM_ENTRI, 
									'0' SUDAH_ENTRI FROM DPM_LISTRIK_REF
									GROUP BY KD_AREA
									UNION ALL
									SELECT THBLREK,KD_AREA, '0' JML_LANG, '0' BELUM_ENTRI,COUNT(TGL_BACA_AKHIR) SUDAH_ENTRI
									FROM DPM_LISTRIK_REF WHERE TGL_BACA_AKHIR != '0000-00-00' OR TGL_BACA_AKHIR IS NOT NULL OR TGL_BACA_AKHIR != ''
									GROUP BY KD_AREA
									) q GROUP BY KD_AREA");

        return $query->result_array(); 
	}
	
	#REKAP KWH
	function get_datatables_rekapkwh()
	{
		$this->_get_datatables_rekapkwh();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_rekapkwh()
	{
		$this->db->select("THBLREK, KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH_CATER) PEMKWH_CATER, SUM(PEMKVARH_CATER) PEMKVARH_CATER");
		$this->db->from("DPM_LISTRIK_REF");
		$this->db->group_by("KD_AREA");
		$i = 0;
		foreach ($this->column_searchx as $item) 
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_searchx) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderx[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderx))
		{
			$order = $this->orderx;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapkwh()
	{
		$this->_get_datatables_rekapkwh();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapkwh()
	{
		$this->db->from('dpm_listrik_ref');
		return $this->db->count_all_results();
	}
	
	#REKAP DLPD
	function get_datatables_rekapdlpd()
	{
		$this->_get_datatables_rekapdlpd();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_rekapdlpd()
	{
		$this->db->select("THBLREK,KD_AREA,STATUS_DLPD,COUNT(ID_LANG) JML_LANG");
		$this->db->from("DPM_LISTRIK_REF");
		$this->db->group_by("KD_AREA,STATUS_DLPD");
		$i = 0;
		foreach ($this->column_searchx as $item) 
		{
			if($_POST['search']['value'])
			{
				
				if($i===0)
				{
					$this->db->group_start(); 
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_searchx) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderx[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderx))
		{
			$order = $this->orderx;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapdlpd()
	{
		$this->_get_datatables_rekapdlpd();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapdlpd()
	{
		$this->db->select("THBLREK,KD_AREA,STATUS_DLPD,COUNT(ID_LANG) JML_LANG");
		$this->db->from("DPM_LISTRIK_REF");
		$this->db->group_by("KD_AREA,STATUS_DLPD");
		return $this->db->count_all_results();
	}
	
	#DETAIL DLPD
	function get_datatables_detdlpd($THBLREK,$KD_AREA,$STSDLPD)
	{
		$this->_get_datatables_detdlpd($THBLREK,$KD_AREA,$STSDLPD);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_detdlpd($THBLREK='',$KD_AREA='',$STSDLPD='')
	{
		$this->db->select("a.THBLREK,a.KD_AREA,a.STATUS_DLPD,a.ID_LANG, b.NAMA_LANG");
		$this->db->from("DPM_LISTRIK_REF a");
		$this->db->join("dil_listrik_new b","b.ID_LANG = a.ID_LANG","LEFT");
		$this->db->where("a.THBLREK","$THBLREK");
		$this->db->where("a.KD_AREA","$KD_AREA");
		$this->db->where("LEFT(a.STATUS_DLPD,1)","$STSDLPD");
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderx[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderx))
		{
			$order = $this->orderx;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detdlpd()
	{
		$this->_get_datatables_detdlpd();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detdlpd($THBLREK,$KD_AREA,$STSDLPD)
	{
		$this->db->select("a.THBLREK,a.KD_AREA,a.STATUS_DLPD,a.ID_LANG, b.NAMA_LANG");
		$this->db->from("DPM_LISTRIK_REF a");
		$this->db->join("dil_listrik_new b","b.ID_LANG = a.ID_LANG","LEFT");
		$this->db->where("a.THBLREK","$THBLREK");
		$this->db->where("a.KD_AREA","$KD_AREA");
		$this->db->where("LEFT(a.STATUS_DLPD,1)","$STSDLPD");
		return $this->db->count_all_results();
	}
	
	public function get_langganan($idcari='')
    {
		$query = $this->db->query("select a.THBLREK, a.ID_LANG, b.NAMA_LANG, a.TARIF, a.DAYA, a.TGL_BACA_AWAL, a.STAND_AWAL_LWBP, a.STAND_AWAL_WBP, a.STAND_AWAL_KVARH,  a.TGL_BACA_AKHIR, a.STAND_AKHIR_LWBP, a.STAND_AKHIR_WBP, a.STAND_AKHIR_KVARH, 
								a.STAND_BKR_LWBP, a.STAND_BKR_WBP, a.STAND_BKR_KVARH, a.STAND_PSG_LWBP, a.STAND_PSG_WBP, a.STAND_PSG_KVARH, (a.FK_METER * a.FRT) FKMXFRT, a.PEMLWBP_CATER, a.PEMWBP_CATER, a.PEMKVARH_CATER
									FROM DPM_LISTRIK_REF a
									JOIN DIL_LISTRIK_NEW b ON a.ID_LANG = b.ID_LANG
									WHERE a.ID_LANG='$idcari' order by THBLREK DESC LIMIT 1 ");
		return $langganan = $query->result();
    }
	
	public function proseshitungkwhperlang($idcari='',$stawallwbp='',$stawalwbp='',$stawalkvarh='',$stbkrlwbp='',$stbkrwbp='',$stbkrkvarh='',$stpsglwbp='',$stpsgwbp='',$stpsgkvarh='',$stakhirlwbp='',$stakhirwbp='',$stakhirkvarh='')
	{
		date_default_timezone_set('Asia/Jakarta');
		set_time_limit(0);
		$q = $this->db->query("SELECT * FROM DPM_LISTRIK_REF WHERE ID_LANG='$idcari' ");
		foreach ($q->result() as $r)
                {
                    $THBLREK		 = $r->THBLREK;
					$ID_LANG		 = $r->ID_LANG;
                    $STS			 = $r->STATUS_PECAHAN;
					$TGL_BACA_AWAL	 = $r->TGL_BACA_AWAL;
					$TGL_BACA_AKHIR	 = $r->TGL_BACA_AKHIR;
					$FK_METER		 = $r->FK_METER;
					$FRT			 = $r->FRT;
					$STAND_AWAL_LWBP = $stawallwbp;
					$STAND_BKR_LWBP  = $stbkrlwbp;
					$STAND_PSG_LWBP  = $stpsglwbp;
					$STAND_AKHIR_LWBP= $stakhirlwbp;
					$STAND_AWAL_WBP  = $stawalwbp;
					$STAND_BKR_WBP   = $stbkrwbp;
					$STAND_PSG_WBP   = $stpsgwbp;
					$STAND_AKHIR_WBP = $stakhirwbp;
					$STAND_AWAL_KVARH= $stawalkvarh;
					$STAND_BKR_KVARH = $stbkrkvarh;
					$STAND_PSG_KVARH = $stpsgkvarh;
					$STAND_AKHIR_KVARH = $stakhirkvarh;
				
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
								
								$arr = array(['PEMLWBP_CATERX' => "".$PEMLWBP_CATER."", 'PEMWBP_CATERX' => "".$PEMWBP_CATER."", 'PEMKVARH_CATERx' => "".$PEMKVARH_CATER.""]);
								return $arr;
							}
							else
							{
								#GANDA - Bukan Pelanggan Baru

								#selisih hari awal dan boongkar
								$SEL_HAR_AB = sel_hari($TGL_BACA_AWAL,$TGL_MUT);

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
								#PERHITUNGAN FINAL
								$PEMLWBP_CATER = $LWBP_MAB + $LWBP_MPA;
								$PEMWBP_CATER = $WBP_MAB + $WBP_MPA;
								$PEMKVARH_CATER = $KVARH_MAB + $KVARH_MPA;

								$arr = array(['PEMLWBP_CATERX' => "".$PEMLWBP_CATER."", 'PEMWBP_CATERX' => "".$PEMWBP_CATER."", 'PEMKVARH_CATERX' => "".$PEMKVARH_CATER.""]);
								return $arr;
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
							
							$arr = array(['PEMLWBP_CATERX' => "".$PEMLWBP_CATER."", 'PEMWBP_CATERX' => "".$PEMWBP_CATER."", 'PEMKVARH_CATERX' => "".$PEMKVARH_CATER.""]);
							return $arr;
								
							break;
						default:
							echo json_encode(array("status" => FALSE));
					}
				}
	}
	
	public function prosessimpankwhperlang($idcari='',$stawallwbp='',$stawalwbp='',$stawalkvarh='',$stbkrlwbp='',$stbkrwbp='',$stbkrkvarh='',$stpsglwbp='',$stpsgwbp='',$stpsgkvarh='',$stakhirlwbp='',$stakhirwbp='',$stakhirkvarh='')
	{
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
		
		$dataupdate = array(
					'STAND_AWAL_LWBP' => $stawallwbp,
					'STAND_BKR_LWBP'  => $stbkrlwbp,
					'STAND_PSG_LWBP'  => $stpsglwbp,
					'STAND_AKHIR_LWBP'=> $stakhirlwbp,
					'STAND_AWAL_WBP'  => $stawalwbp,
					'STAND_BKR_WBP'   => $stbkrwbp,
					'STAND_PSG_WBP'   => $stpsgwbp,
					'STAND_AKHIR_WBP' => $stakhirwbp,
					'STAND_AWAL_KVARH'=> $stawalkvarh,
					'STAND_BKR_KVARH' => $stbkrkvarh,
					'STAND_PSG_KVARH' => $stpsgkvarh,
					'STAND_AKHIR_KVARH' => $stakhirkvarh
					);
		$this->db->where('ID_LANG', $idcari);
		$this->db->update('DPM_LISTRIK_REF', $dataupdate);
				
		$q = $this->db->query("SELECT * FROM DPM_LISTRIK_REF WHERE ID_LANG='$idcari' ");
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
							echo json_encode(array("status" => "MODELSALAH"));
					}
				}
	}

	
}