<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billingm extends CI_Model {

	var $table = 'billing_listrik_ref';
	var $column_order = array('billing_listrik_ref.ID_LANG','dil_listrik_new.NAMA_LANG',null); 
	var $column_search = array('billing_listrik_ref.ID_LANG','dil_listrik_new.NAMA_LANG');
	var $order = array('billing_listrik_ref.ID_LANG' => 'ASC'); 
	
	var $tablex = 'v_tr_tarif';
	var $column_orderx = array('KD_TARIF','BTS_DAYA',null); 
	var $column_searchx = array('KD_TARIF','BTS_DAYA');
	var $orderx = array('id' => 'DESC'); 
	
	var $tabley = 'dpm_listrik_new';
	var $column_ordery = array('ID_LANG','THBLREK',null); 
	var $column_searchy = array('ID_LANG','TGL_UPLOAD_STAND');
	var $ordery = array('id' => 'DESC'); 
	
	var $tablez = 'billing_listrik_new';
	var $column_orderz = array('THBLREK','ID_LANG',null); 
	var $column_searchz = array('ID_LANG','DAYA');
	var $orderz = array('id' => 'ASC'); 
	
	var $column_orderq = array('THBLREK','KD_AREA'); 
	var $column_searchq = array('KD_AREA');
	var $orderq = array('KD_AREA' => 'asc'); 
	
	var $column_orderemmon = array('THBLREK','ID_CUST'); 
	var $column_searchemmon = array('ID_CUST');
	var $orderemmon = array('THBLREK' => 'desc'); 
	
	public function __construct()
	{
		parent::__construct();
	}
	
	#BILLING
	private function _get_datatables_query()
	{
		$this->db->from('billing_listrik_ref');
		$this->db->join('dil_listrik_new','dil_listrik_new.ID_LANG=billing_listrik_ref.ID_LANG');
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
		$this->db->from('billing_listrik_ref');
		return $this->db->count_all_results();
	}
	#SELESAI BILLING
	
	#TARIF DASAR
	private function _get_datatables_queryx()
	{
		$this->db->from("v_tr_tarif");
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

	function get_datatablesx()
	{
		$this->_get_datatables_queryx();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filteredx()
	{
		$this->_get_datatables_queryx();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_allx()
	{
		$this->db->from('v_tr_tarif');
		return $this->db->count_all_results();
	}
	#selesai

	#VALIDASI DPM
	private function _get_datatables_queryy()
	{
		$this->db->from("dpm_listrik_new");
		$i = 0;
		foreach ($this->column_searchy as $item) 
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

				if(count($this->column_searchy) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordery[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->ordery))
		{
			$order = $this->ordery;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function get_datatablesy()
	{
		$this->_get_datatables_queryy();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filteredy()
	{
		$this->_get_datatables_queryy();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_ally()
	{
		$this->db->from('dpm_listrik_new');
		return $this->db->count_all_results();
	}
	
	#selesai
	
	#VALIDASI DPM
	function get_datatablesz()
	{
		$this->_get_datatables_queryz();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_queryz()
	{
		$this->db->from('billing_listrik_new');
		$i = 0;
		foreach ($this->column_searchz as $item) 
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

				if(count($this->column_searchz) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderz[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderz))
		{
			$order = $this->orderz;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filteredz()
	{
		$this->_get_datatables_queryz();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_allz()
	{
		$this->db->from('billing_listrik_new');
		return $this->db->count_all_results();
	}
	
	#HITUNG BILING
	function get_datatables_rekaphitung($idcari)
	{
		$this->_get_datatables_query_rekaphitung($idcari);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_query_rekaphitung($idcari='')
	{
		if($idcari == '' OR $idcari == null){
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("BILLING_LISTRIK_REF a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->group_by("a.KD_AREA");
		}else{
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->where("THBLREK","$idcari");
			$this->db->group_by("a.KD_AREA");
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderq[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderq))
		{
			$order = $this->orderq;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekaphitung()
	{
		$this->_get_datatables_query_rekaphitung();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekaphitung($idcari='')
	{
		if($idcari == '' OR $idcari == null){
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("BILLING_LISTRIK_REF a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->group_by("a.KD_AREA");
		}else{
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->where("THBLREK","$idcari");
			$this->db->group_by("a.KD_AREA");
		}
		
		return $this->db->count_all_results();
	}
	
	#HITUNG DLPD
	function get_datatables_rekapdlpd()
	{
		$this->_get_datatables_query_rekapdlpd();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_query_rekapdlpd()
	{
		$this->db->select("THBLREK,KD_AREA,STATUS_DLPD,COUNT(ID_LANG) JML_LANG");
		$this->db->from("DPM_LISTRIK_REF");
		$this->db->group_by("KD_AREA,STATUS_DLPD");
		$i = 0;
		foreach ($this->column_searchq as $item) 
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

				if(count($this->column_searchq) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderq[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderq))
		{
			$order = $this->orderq;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapdlpd()
	{
		$this->_get_datatables_query_rekapdlpd();
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
	
	#MON INVOICE EMAIL
	function get_datatables_monemailinvoice()
	{
		$this->_get_datatables_query_monemailinvoice();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_query_monemailinvoice()
	{
		$this->db->from("LOG_SENTMAIL");
		$i = 0;
		foreach ($this->column_searchemmon as $item) 
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

				if(count($this->column_searchemmon) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderemmon[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orderemmon))
		{
			$order = $this->orderemmon;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_monemailinvoice()
	{
		$this->_get_datatables_query_monemailinvoice();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_monemailinvoice()
	{
		$this->db->from("LOG_SENTMAIL");
		return $this->db->count_all_results();
	}
	
	public function get_langganan($idcari='')
    {
		$query = $this->db->query("select a.THBLREK, a.ID_LANG, b.NAMA_LANG, a.TARIF, a.DAYA, a.TGL_BACA_AWAL, a.STAND_AWAL_LWBP, a.STAND_AWAL_WBP, a.STAND_AWAL_KVARH,  a.TGL_BACA_AKHIR, a.STAND_AKHIR_LWBP, a.STAND_AKHIR_WBP, a.STAND_AKHIR_KVARH, 
								a.STAND_BKR_LWBP, a.STAND_BKR_WBP, a.STAND_BKR_KVARH, a.STAND_PSG_LWBP, a.STAND_PSG_WBP, a.STAND_PSG_KVARH, (b.FK_METER * b.FRT) FKMXFRT, a.KWHLWBP, a.KWHWBP, a.KLBKVARH, a.RPLWBP, a.RPWBP, a.RPKVARH
									from BILLING_LISTRIK_REF a
									JOIN DIL_LISTRIK_NEW b ON a.ID_LANG = b.ID_LANG
									WHERE a.ID_LANG='$idcari' order by THBLREK DESC LIMIT 1 ");
		return $langganan = $query->result();
    }
	
	public function proseshitungrekeningperlang($idcari,$pemlwbpcat,$pemwbpcat,$pemkvarhcat,$pemkwhcat){
		set_time_limit(0);

		$q = $this->db->query("SELECT * FROM BILLING_LISTRIK_REF WHERE ID_LANG = '$idcari' ");
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

			$PEMLWBP_CATER		= $pemlwbpcat;
			$PEMWBP_CATER		= $pemwbpcat;
			$PEMKVARH_CATER		= $pemkvarhcat;
			$PEMKWH_CATER		= $pemkwhcat;
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
						
						$arr = array(['RPLWBPX' => "".$RPLWBP."", 'RPWBPX' => "".$RPWBP."", 'RPKVARHX' => "".$RPKVARH."", 'KWHLWBPX' => "".$KWHLWBP."", 'KWHWBPX' => "".$KWHWBP."", 'KLBKVARHX' => "".$KLBKVARH.""]);
						return $arr;

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
						
						$arr = array(['RPLWBPX' => "".$RPLWBP."", 'RPWBPX' => "".$RPWBP."", 'RPKVARHX' => "".$RPKVARH."", 'KWHLWBPX' => "".$KWHLWBP."", 'KWHWBPX' => "".$KWHWBP."", 'KLBKVARHX' => "".$KLBKVARH.""]);
						return $arr;
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
						$arr = array(['RPLWBPX' => "".$RPLWBP."", 'RPWBPX' => "".$RPWBP."", 'RPKVARHX' => "".$RPKVARH."", 'KWHLWBPX' => "".$KWHLWBP."", 'KWHWBPX' => "".$KWHWBP."", 'KLBKVARHX' => "".$KLBKVARH.""]);
						return $arr;

					break;
				default:
					echo json_encode(array("status" => FALSE));
			}
		}
	}

	public function prosessimpanrekeningperlang($idcari){
		set_time_limit(0);
		
		$q = $this->db->query("SELECT * FROM BILLING_LISTRIK_REF WHERE ID_LANG='$idcari' ");
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

}