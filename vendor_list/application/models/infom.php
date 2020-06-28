<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Infom extends CI_Model {

	var $column_orderw = array('THBLREK','GOLONGAN','JLH_LANG');
	var $column_searchw = array('THBLREK','GOLONGAN');
	var $orderw = array('THBLREK' => 'DESC');

	var $column_orderx = array('THBL_MOHON','ID_LANG');
	var $column_searchx = array('ID_LANG','ID_CUST','NAMA_LANG');
	var $orderx = array('THBL_MOHON' => 'DESC');

	var $column_ordermut = array('THBLMUT','ID_LANG');
	var $column_searchmut = array('ID_LANG','ID_CUST','NAMA_LANG');
	var $ordermut = array('THBLMUT' => 'DESC');

	var $column_ordery = array('THBLREK','KD_AREA','JLH_LANG');
	var $column_searchy = array('THBLREK','KD_AREA');
	var $ordery = array('THBLREK' => 'desc');

	var $column_orderz = array('Bulan_Lunas');
	var $column_searchz = array('Bulan_Lunas');
	var $orderz = array('Bulan_Lunas' => 'desc');

	var $column_orderarea = array('kd_area');
	var $column_searcharea = array('kd_area');
	var $orderarea = array('kd_area' => 'desc');

	var $column_ordercust = array('id_cust');
	var $column_searchcust = array('id_cust');
	var $ordercust = array('id_cust' => 'desc');

	var $column_orderlang = array('id_cust','id_lang');
	var $column_searchlang = array('id_cust','id_lang');
	var $orderlang = array('id_cust' => 'desc');

	var $column_orderthblrek = array('thblrek');
	var $column_searchthblrek = array('thblrek');
	var $orderthblrek = array('thblrek' => 'desc');

	var $column_orderbpujl = array('LEFT(tp_agenda.TGL_BAYAR, 7)','ID_LANG');
	var $column_searchbpujl = array('ID_LANG','ID_CUST','NAMA_LANG');
	var $orderbpujl = array('TGL_BAYAR' => 'DESC');

	var $column_ordersp = array('master_rekening.ID_LANG');
	var $ordersp = array('master_rekening.ID_LANG' => 'DESC');

	var $column_order_p_r = array('uraian');
	var $column_search_p_r = array('uraian');
	var $order_p_r = array('uraian' => 'DESC');

    function __construct()
    {
        parent::__construct();
    }

	#REAKP PDL
	function get_datatables_rekappdl()
	{
		$this->_get_datatables_rekappdl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekappdl()
	{
		$this->db->select("THBLMUT, KD_AREA, JNS_TRANSAKSI, COUNT(ID_LANG) JML_LANG");
		$this->db->from("TP_AGENDA");
		$this->db->where("STATUS_MOHON", "8");
		$this->db->group_by("THBLMUT,KD_AREA,JNS_TRANSAKSI");
		$i = 0;
		foreach ($this->column_searchmut as $item)
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

				if(count($this->column_searchmut) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordermut[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->ordermut))
		{
			$order = $this->ordermut;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekappdl()
	{
		$this->_get_datatables_rekappdl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekappdl()
	{
		$this->db->select("THBL_MOHON, KD_AREA, JNS_TRANSAKSI, COUNT(ID_LANG) JML_LANG");
		$this->db->from("TP_AGENDA");
		$this->db->where("STATUS_MOHON", "8");
		$this->db->group_by("THBL_MOHON,KD_AREA,JNS_TRANSAKSI");
		return $this->db->count_all_results();
	}

	#REAKP BPUJL
	function get_datatables_rekapbpujl()
	{
		$this->_get_datatables_rekapbpujl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekapbpujl()
	{
		$this->db->select("NO_AGENDA,LEFT(`tp_agenda`.`TGL_BAYAR`,7) THBLLUNAS,ID_CUST,ID_LANG,NAMA_LANG,RP_BP,RP_UJL_TAGIH",FALSE);
		$this->db->from("TP_AGENDA");
		$this->db->where("jns_transaksi != 'PENERANGAN SEMENTARA' AND ( RP_BP != '0' OR RP_UJL_TAGIH != '0') AND  LEFT(tp_agenda.TGL_BAYAR,7) != '0000-00' ");

		$i = 0;
		foreach ($this->column_searchbpujl as $item)
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

				if(count($this->column_searchbpujl) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderbpujl[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderbpujl))
		{
			$order = $this->orderbpujl;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapbpujl()
	{
		$this->_get_datatables_rekapbpujl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapbpujl()
	{
		$this->db->select("NO_AGENDA,left(`tp_agenda`.`TGL_BAYAR`,7) THBLLUNAS,ID_CUST,ID_LANG,NAMA_LANG,RP_BP,RP_UJL_TAGIH",FALSE);
		$this->db->from("TP_AGENDA");
		$this->db->where("jns_transaksi != 'PENERANGAN SEMENTARA' AND ( RP_BP != '0' OR RP_UJL_TAGIH != '0') ");
		return $this->db->count_all_results();
	}

	#REAKP RPKWH
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
		$this->db->select("THBL_MOHON,ID_CUST,NO_AGENDA,NAMA_LANG,KWH_PS, RPKWH_PS, RPBPJU_PS, RPJML_PS");
		$this->db->from("TP_AGENDA");
		$this->db->where("jns_transaksi = 'PENERANGAN SEMENTARA' ");
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
		$this->db->select("THBL_MOHON,ID_CUST,ID_LANG,NAMA_LANG,RPKWH_PS,RPJML_PS");
		$this->db->from("TP_AGENDA");
		$this->db->where("jns_transaksi = 'PENERANGAN SEMENTARA' ");
		return $this->db->count_all_results();
	}

	#REAKP REK KEU
	function get_datatables_rekaprek()
	{
		$this->_get_datatables_rekaprek();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekaprek()
	{
		$this->db->from("v_rekap_rek_area");
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

	function count_filtered_rekaprek()
	{
		$this->_get_datatables_rekaprek();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekaprek()
	{
		$this->db->from("v_rekap_rek_area");
		return $this->db->count_all_results();
	}

	#REAKP REK KEU GOLONGAN
	function get_datatables_rekaprekgol()
	{
		$this->_get_datatables_rekaprekgol();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekaprekgol()
	{
		$this->db->from("v_rekap_rek_gol");
		$this->db->order_by("THBLREK","DESC");
		$this->db->order_by("KOGOL","ASC");
		$i = 0;
		foreach ($this->column_searchw as $item)
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

				if(count($this->column_searchw) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderw[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderw))
		{
			$order = $this->orderw;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekaprekgol()
	{
		$this->_get_datatables_rekaprekgol();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekaprekgol()
	{
		$this->db->from("v_rekap_rek_gol");
		return $this->db->count_all_results();
	}

	#REAKP pelunasan
	function get_datatables_rekaplunas()
	{
		$this->_get_datatables_rekaplunas();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekaplunas()
	{
		$this->db->from("v_saldopiutang_rekaplunas_bulanan");
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

	function count_filtered_rekaplunas()
	{
		$this->_get_datatables_rekaplunas();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekaplunas()
	{
		$this->db->from("v_saldopiutang_rekaplunas_bulanan");
		return $this->db->count_all_results();
	}

	#REAKP Saldo area
	function get_datatables_saldoarea()
	{
		$this->_get_datatables_saldoarea();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_saldoarea()
	{
		$this->db->from("v_saldopiutang_perarea");
		$i = 0;
		foreach ($this->column_searcharea as $item)
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

				if(count($this->column_searcharea) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderarea[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderarea))
		{
			$order = $this->orderarea;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_saldoarea()
	{
		$this->_get_datatables_saldoarea();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_saldoarea()
	{
		$this->db->from("v_saldopiutang_perarea");
		return $this->db->count_all_results();
	}

	#DETAIL SALDO PIUTANG AREA
	function get_datatables_detsaldopiutang($KD_AREA)
	{
		$this->_get_datatables_detsaldopiutang($KD_AREA);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detsaldopiutang($KD_AREA='')
	{
		$this->db->select("master_rekening.KD_AREA AS kd_area,
							  master_rekening.ID_LANG AS Jlh_Langganan,
							  dil_listrik_new.NAMA_LANG,
							  count(master_rekening.ID_LANG) AS Jlh_Lembar,
							  sum(master_rekening.RPEPI) AS Jlh_RpEPI,
							  sum(master_rekening.RPBPJU) AS Jlh_RpBPJU,
							  sum(master_rekening.RPMAT) AS Jlh_RpMAT,
							  sum(master_rekening.RPTAG) AS Jlh_RpTag,
							  sum(master_rekening.RP_BK) AS Jlh_RpBK,
							  sum(master_rekening.TOTAL_INVOICE) AS Jlh_Invoice");
		$this->db->from("master_rekening");
		$this->db->join("dil_listrik_new","master_rekening.id_lang=dil_listrik_new.id_lang");
		$this->db->where("master_rekening.STATUS_LUNAS","0");
		$this->db->where("master_rekening.KD_AREA", "$KD_AREA");
		$this->db->group_by("master_rekening.ID_LANG");

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordersp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->ordersp))
		{
			$order = $this->ordersp;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detsaldopiutang()
	{
		$this->_get_datatables_detsaldopiutang();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detsaldopiutang($KD_AREA)
	{
		$this->db->select("master_rekening.KD_AREA AS kd_area,
							  master_rekening.ID_LANG AS Jlh_Langganan,
							  dil_listrik_new.NAMA_LANG,
							  count(master_rekening.ID_LANG) AS Jlh_Lembar,
							  sum(master_rekening.RPEPI) AS Jlh_RpEPI,
							  sum(master_rekening.RPBPJU) AS Jlh_RpBPJU,
							  sum(master_rekening.RPMAT) AS Jlh_RpMAT,
							  sum(master_rekening.RPTAG) AS Jlh_RpTag,
							  sum(master_rekening.RP_BK) AS Jlh_RpBK,
							  sum(master_rekening.TOTAL_INVOICE) AS Jlh_Invoice");
		$this->db->from("master_rekening");
		$this->db->join("dil_listrik_new","master_rekening.id_lang=dil_listrik_new.id_lang");
		$this->db->where("master_rekening.STATUS_LUNAS","0");
		$this->db->where("master_rekening.KD_AREA", "$KD_AREA");
		$this->db->group_by("master_rekening.ID_LANG");
		return $this->db->count_all_results();
	}

	#DETAIL SALDO PIUTANG AREA LEMBAR
	function get_datatables_detsaldopiutang2($KD_AREA)
	{
		$this->_get_datatables_detsaldopiutang2($KD_AREA);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detsaldopiutang2($KD_AREA='')
	{
		$this->db->select("master_rekening.KD_AREA AS kd_area,
							  master_rekening.THBLREK,
							  master_rekening.ID_LANG AS Jlh_Langganan,
							  dil_listrik_new.NAMA_LANG,
							  master_rekening.RPEPI AS Jlh_RpEPI,
							  master_rekening.RPBPJU AS Jlh_RpBPJU,
							  master_rekening.RPMAT AS Jlh_RpMAT,
							  master_rekening.RPTAG AS Jlh_RpTag,
							  master_rekening.RP_BK AS Jlh_RpBK,
							  master_rekening.TOTAL_INVOICE AS Jlh_Invoice");
		$this->db->from("master_rekening");
		$this->db->join("dil_listrik_new","master_rekening.id_lang=dil_listrik_new.id_lang");
		$this->db->where("master_rekening.STATUS_LUNAS","0");
		$this->db->where("master_rekening.KD_AREA", "$KD_AREA");

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordersp[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->ordersp))
		{
			$order = $this->ordersp;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detsaldopiutang2()
	{
		$this->_get_datatables_detsaldopiutang2();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detsaldopiutang2($KD_AREA)
	{
		$this->db->select("master_rekening.KD_AREA AS kd_area,
							  master_rekening.THBLREK,
							  master_rekening.ID_LANG AS Jlh_Langganan,
							  dil_listrik_new.NAMA_LANG,
							  master_rekening.RPEPI AS Jlh_RpEPI,
							  master_rekening.RPBPJU AS Jlh_RpBPJU,
							  master_rekening.RPMAT AS Jlh_RpMAT,
							  master_rekening.RPTAG AS Jlh_RpTag,
							  master_rekening.RP_BK AS Jlh_RpBK,
							  master_rekening.TOTAL_INVOICE AS Jlh_Invoice");
		$this->db->from("master_rekening");
		$this->db->join("dil_listrik_new","master_rekening.id_lang=dil_listrik_new.id_lang");
		$this->db->where("master_rekening.STATUS_LUNAS","0");
		$this->db->where("master_rekening.KD_AREA", "$KD_AREA");
		return $this->db->count_all_results();
	}

	#REAKP Saldo Gol
	function get_datatables_saldogol()
	{
		$this->_get_datatables_saldogol();
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_saldogol()
	{
		$this->db->from("v_saldopiutang_pergol");

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordergol[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->ordergol))
		{
			$order = $this->ordergol;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_saldogol()
	{
		$this->_get_datatables_saldogol();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_saldogol()
	{
		$this->db->from("v_saldopiutang_pergol");
		return $this->db->count_all_results();
	}

	#REAKP Saldo cust
	function get_datatables_saldocust()
	{
		$this->_get_datatables_saldocust();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_saldocust()
	{
		$this->db->select("a.*,b.nama_cust");
		$this->db->from("v_saldopiutang_percust a");
		$this->db->join("cust b","a.id_cust=b.id_cust");
		$i = 0;
		foreach ($this->column_searchcust as $item)
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

				if(count($this->column_searchcust) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_ordercust[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->ordercust))
		{
			$order = $this->ordercust;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_saldocust()
	{
		$this->_get_datatables_saldocust();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_saldocust()
	{
		$this->db->from("v_saldopiutang_percust");
		return $this->db->count_all_results();
	}

	#REAKP Saldo langganan
	function get_datatables_saldolang()
	{
		$this->_get_datatables_saldolang();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_saldolang()
	{
		$this->db->from("v_saldopiutang_perlang");
		$i = 0;
		foreach ($this->column_searchlang as $item)
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

				if(count($this->column_searchlang) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderlang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderlang))
		{
			$order = $this->orderlang;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_saldolang()
	{
		$this->_get_datatables_saldolang();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_saldolang()
	{
		$this->db->from("v_saldopiutang_perlang");
		return $this->db->count_all_results();
	}

	#REAKP Saldo thblrek
	function get_datatables_saldothblrek()
	{
		$this->_get_datatables_saldothblrek();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_saldothblrek()
	{
		$this->db->from("v_saldopiutang_perthblrek");
		$i = 0;
		foreach ($this->column_searchthblrek as $item)
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

				if(count($this->column_searchthblrek) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderthblrek[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderthblrek))
		{
			$order = $this->orderthblrek;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_saldothblrek()
	{
		$this->_get_datatables_saldothblrek();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_saldothblrek()
	{
		$this->db->from("v_saldopiutang_perthblrek");
		return $this->db->count_all_results();
	}

#------------------------------

	function get_tahun(){
		$query = $this->db->query("select * from dbportal.atahun order by tahun asc ");
		return $all = $query->result();
	}

	function get_grafik_pendapatan()
	{
			$this->db->select('*');
			$this->db->from('dbportal.agrafik_pendapatan');
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_n_p()
	{
			$this->db->select("*, thn as tahun");
			$this->db->from("dbportal.agrafik_pendapatan");
			$this->db->group_by("thn");
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_beban()
	{
			$this->db->select('*');
			$this->db->from('dbportal.agrafik_beban');
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_n_b()
	{
			$this->db->select("*, thn as tahun");
			$this->db->from("dbportal.agrafik_beban");
			$this->db->group_by("thn");
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_lr()
	{
			$this->db->select('*');
			$this->db->from('dbportal.agrafik_lr');
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_n_lr()
	{
			$this->db->select("*, thn as tahun");
			$this->db->from("dbportal.agrafik_lr");
			$this->db->group_by("thn");
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_bopo()
	{
			$this->db->select('*');
			$this->db->from('dbportal.agrafik_bopo');
			$query = $this->db->get();
			return $query->result();
	}

	function get_grafik_n_bopo()
	{
			$this->db->select("*, thn as tahun");
			$this->db->from("dbportal.agrafik_bopo");
			$this->db->group_by("thn");
			$query = $this->db->get();
			return $query->result();
	}

	#pendapatan--------------------------
	public function get_neraca_p_r($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, bulanan as biaya from dbportal.`aq_target_pendapatan_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, bulanan as biaya from dbportal.`aq_realisasi_pendapatan_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	public function get_neraca_p_t($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, komulatif as biaya from dbportal.`aq_target_pendapatan_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, komulatif as biaya from dbportal.`aq_realisasi_pendapatan_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	public function get_neraca_plu_r($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, bulanan as biaya from dbportal.`aq_target_pendapatan_diluar_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, bulanan as biaya from dbportal.`aq_realisasi_pendapatan_diluar_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	public function get_neraca_plu_t($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, komulatif as biaya from dbportal.`aq_target_pendapatan_diluar_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, komulatif as biaya from dbportal.`aq_realisasi_pendapatan_diluar_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	#beban--------------------------
	public function get_neraca_b_r($tahun)
  {
    $query = $this->db->query("
		select
			thn, uraian,
			format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
			format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
			format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
			format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
			format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
			format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
			format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
			format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
			format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
			format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
			format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
			format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
		from (
			select thn, bln, 'Bulanan' uraian, bulanan as biaya   from dbportal.`aq_realisasi_beban_usaha_k`
			union all
			select thn, bln, 'Komulatif' uraian, komulatif as biaya from dbportal.`aq_realisasi_beban_usaha_k`
		) src
		where thn = '$tahun'
		GROUP BY thn, uraian
		");

    return $query->result_array();
	}

	public function get_neraca_b_detil_r($tahun)
  {
    $query = $this->db->query("
			select
				thn, uraian,
				format(sum(case when bln = 'JAN' then biaya else 0 end)/1000000000,2) as jan,
				format(sum(case when bln = 'FEB' then biaya else 0 end)/1000000000,2) as feb,
				format(sum(case when bln = 'MAR' then biaya else 0 end)/1000000000,2) as mar,
				format(sum(case when bln = 'APR' then biaya else 0 end)/1000000000,2) as apr,
				format(sum(case when bln = 'MEI' then biaya else 0 end)/1000000000,2) as mei,
				format(sum(case when bln = 'JUN' then biaya else 0 end)/1000000000,2) as jun,
				format(sum(case when bln = 'JUL' then biaya else 0 end)/1000000000,2) as jul,
				format(sum(case when bln = 'AGS' then biaya else 0 end)/1000000000,2) as ags,
				format(sum(case when bln = 'SEP' then biaya else 0 end)/1000000000,2) as sep,
				format(sum(case when bln = 'OKT' then biaya else 0 end)/1000000000,2) as okt,
				format(sum(case when bln = 'NOV' then biaya else 0 end)/1000000000,2) as nov,
				format(sum(case when bln = 'DES' then biaya else 0 end)/1000000000,2) as des
			from (
				select thn, bln, '1. Beban Pegawai, Direksi dan Komisaris' uraian, rp_beban_1 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '2. Beban Bahan' uraian, rp_beban_2 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '3. Beban Pemeliharaan' uraian, rp_beban_3 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '4. Beban Penyusutan dan Amortisasi' uraian, rp_beban_4 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '5. Beban Asuransi' uraian, rp_beban_5 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '6. Beban KSMU' uraian, rp_beban_6 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '7. Beban Administrasi Kantor' uraian, rp_beban_7 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, '8. Beban Umum' uraian, rp_beban_8 as biaya from dbportal.`agrafik_beban_detail`
				union all
				select thn, bln, 'Realisasi Beban' uraian, rp_beban_real as biaya from dbportal.`agrafik_beban_detail`
			) src
			where thn = '$tahun'
			GROUP BY thn, uraian
		");

    return $query->result_array();
	}

	public function get_neraca_b_t($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Bulanan' uraian, bulanan as biaya   from dbportal.`aq_target_beban_usaha_k`
					union all
					select thn, bln, 'Komulatif' uraian, komulatif as biaya from dbportal.`aq_target_beban_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				");

        return $query->result_array();
	}

	public function get_neraca_b_detil_t($tahun)
  {
    $query = $this->db->query("
			select
				thn, uraian,
				format(sum(case when bln = 'JAN' then biaya else 0 end)/1000000000,2) as jan,
				format(sum(case when bln = 'FEB' then biaya else 0 end)/1000000000,2) as feb,
				format(sum(case when bln = 'MAR' then biaya else 0 end)/1000000000,2) as mar,
				format(sum(case when bln = 'APR' then biaya else 0 end)/1000000000,2) as apr,
				format(sum(case when bln = 'MEI' then biaya else 0 end)/1000000000,2) as mei,
				format(sum(case when bln = 'JUN' then biaya else 0 end)/1000000000,2) as jun,
				format(sum(case when bln = 'JUL' then biaya else 0 end)/1000000000,2) as jul,
				format(sum(case when bln = 'AGS' then biaya else 0 end)/1000000000,2) as ags,
				format(sum(case when bln = 'SEP' then biaya else 0 end)/1000000000,2) as sep,
				format(sum(case when bln = 'OKT' then biaya else 0 end)/1000000000,2) as okt,
				format(sum(case when bln = 'NOV' then biaya else 0 end)/1000000000,2) as nov,
				format(sum(case when bln = 'DES' then biaya else 0 end)/1000000000,2) as des
			from (
				select thn, bln, '1. Beban Pegawai, Direksi dan Komisaris' uraian, rp_beban_1 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '2. Beban Bahan' uraian, rp_beban_2 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '3. Beban Pemeliharaan' uraian, rp_beban_3 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '4. Beban Penyusutan dan Amortisasi' uraian, rp_beban_4 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '5. Beban Asuransi' uraian, rp_beban_5 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '6. Beban KSMU' uraian, rp_beban_6 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '7. Beban Administrasi Kantor' uraian, rp_beban_7 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, '8. Beban Umum' uraian, rp_beban_8 as biaya from dbportal.`agrafik_beban_detail_t`
				union all
				select thn, bln, 'Target Beban' uraian, rp_beban_target as biaya from dbportal.`agrafik_beban_detail_t`
			) src
			where thn = '$tahun'
			GROUP BY thn, uraian
		");

    return $query->result_array();
	}

	public function get_neraca_blu_r($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, bulanan as biaya from dbportal.`aq_target_beban_diluar_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, bulanan as biaya   from dbportal.`aq_realisasi_beban_diluar_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	public function get_neraca_blu_t($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = '01' then biaya else 0 end)/1000000000,2) as jan,
					format(sum(case when bln = '02' then biaya else 0 end)/1000000000,2) as feb,
					format(sum(case when bln = '03' then biaya else 0 end)/1000000000,2) as mar,
					format(sum(case when bln = '04' then biaya else 0 end)/1000000000,2) as apr,
					format(sum(case when bln = '05' then biaya else 0 end)/1000000000,2) as mei,
					format(sum(case when bln = '06' then biaya else 0 end)/1000000000,2) as jun,
					format(sum(case when bln = '07' then biaya else 0 end)/1000000000,2) as jul,
					format(sum(case when bln = '08' then biaya else 0 end)/1000000000,2) as ags,
					format(sum(case when bln = '09' then biaya else 0 end)/1000000000,2) as sep,
					format(sum(case when bln = '10' then biaya else 0 end)/1000000000,2) as okt,
					format(sum(case when bln = '11' then biaya else 0 end)/1000000000,2) as nov,
					format(sum(case when bln = '12' then biaya else 0 end)/1000000000,2) as des
				from (
					select thn, bln, 'Target' uraian, komulatif as biaya from dbportal.`aq_target_beban_diluar_usaha_k`
					union all
					select thn, bln, 'Realisasi' uraian, komulatif as biaya   from dbportal.`aq_realisasi_beban_diluar_usaha_k`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				ORDER BY uraian desc
				");

        return $query->result_array();
	}

	#laba rugi--------------------------
	public function get_neraca_lr_u($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = 'JAN' then biaya else 0 end)/1,2) as jan,
					format(sum(case when bln = 'FEB' then biaya else 0 end)/1,2) as feb,
					format(sum(case when bln = 'MAR' then biaya else 0 end)/1,2) as mar,
					format(sum(case when bln = 'APR' then biaya else 0 end)/1,2) as apr,
					format(sum(case when bln = 'MEI' then biaya else 0 end)/1,2) as mei,
					format(sum(case when bln = 'JUN' then biaya else 0 end)/1,2) as jun,
					format(sum(case when bln = 'JUL' then biaya else 0 end)/1,2) as jul,
					format(sum(case when bln = 'AGS' then biaya else 0 end)/1,2) as ags,
					format(sum(case when bln = 'SEP' then biaya else 0 end)/1,2) as sep,
					format(sum(case when bln = 'OKT' then biaya else 0 end)/1,2) as okt,
					format(sum(case when bln = 'NOV' then biaya else 0 end)/1,2) as nov,
					format(sum(case when bln = 'DES' then biaya else 0 end)/1,2) as des
				from (
					select thn, bln, '1. Real LR Usaha' uraian, real_lr_usaha_b as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '2. Real LR Luar Usaha' uraian, real_lr_luar_usaha_b as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '3. Tot. Real Laba Rugi' uraian, real_lr_b as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '4. Target Laba Rugi' uraian, target_lr_b as biaya from dbportal.`agrafik_lr`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				");

        return $query->result_array();
	}

	public function get_neraca_lr_lu($tahun)
    {
        $query = $this->db->query("
				select
					thn, uraian,
					format(sum(case when bln = 'JAN' then biaya else 0 end)/1,2) as jan,
					format(sum(case when bln = 'FEB' then biaya else 0 end)/1,2) as feb,
					format(sum(case when bln = 'MAR' then biaya else 0 end)/1,2) as mar,
					format(sum(case when bln = 'APR' then biaya else 0 end)/1,2) as apr,
					format(sum(case when bln = 'MEI' then biaya else 0 end)/1,2) as mei,
					format(sum(case when bln = 'JUN' then biaya else 0 end)/1,2) as jun,
					format(sum(case when bln = 'JUL' then biaya else 0 end)/1,2) as jul,
					format(sum(case when bln = 'AGS' then biaya else 0 end)/1,2) as ags,
					format(sum(case when bln = 'SEP' then biaya else 0 end)/1,2) as sep,
					format(sum(case when bln = 'OKT' then biaya else 0 end)/1,2) as okt,
					format(sum(case when bln = 'NOV' then biaya else 0 end)/1,2) as nov,
					format(sum(case when bln = 'DES' then biaya else 0 end)/1,2) as des
				from (
					select thn, bln, '1. Real LR Usaha' uraian, real_lr_usaha_k as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '2. Real LR Luar Usaha' uraian, real_lr_luar_usaha_k as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '3. Tot. Real Laba Rugi' uraian, real_lr_k as biaya from dbportal.`agrafik_lr`
					union all
					select thn, bln, '4. Target Laba Rugi' uraian, target_lr_k as biaya from dbportal.`agrafik_lr`
				) src
				where thn = '$tahun'
				GROUP BY thn, uraian
				");

        return $query->result_array();
	}

	#bopo
	public function get_neraca_bopo($tahun)
  {
      $query = $this->db->query("
			select
				thn, uraian,
				format(sum(case when bln = 'JAN' then biaya else 0 end)/1,2) as jan,
				format(sum(case when bln = 'FEB' then biaya else 0 end)/1,2) as feb,
				format(sum(case when bln = 'MAR' then biaya else 0 end)/1,2) as mar,
				format(sum(case when bln = 'APR' then biaya else 0 end)/1,2) as apr,
				format(sum(case when bln = 'MEI' then biaya else 0 end)/1,2) as mei,
				format(sum(case when bln = 'JUN' then biaya else 0 end)/1,2) as jun,
				format(sum(case when bln = 'JUL' then biaya else 0 end)/1,2) as jul,
				format(sum(case when bln = 'AGS' then biaya else 0 end)/1,2) as ags,
				format(sum(case when bln = 'SEP' then biaya else 0 end)/1,2) as sep,
				format(sum(case when bln = 'OKT' then biaya else 0 end)/1,2) as okt,
				format(sum(case when bln = 'NOV' then biaya else 0 end)/1,2) as nov,
				format(sum(case when bln = 'DES' then biaya else 0 end)/1,2) as des
			from (
				select thn, bln, 'Realisasi' uraian, real_bopo_b as biaya from dbportal.`agrafik_bopo`
				union all
				select thn, bln, 'Target' uraian, target_bopo_b as biaya from dbportal.`agrafik_bopo`
			) src
			where thn = '$tahun'
			GROUP BY thn, uraian
			ORDER BY uraian desc
			");

      return $query->result_array();
	}

}
