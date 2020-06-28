<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Keuanganm extends CI_Model {

	var $column_orderq = array('THBLREK','GOL');
	var $column_searchq = array('GOL');
	var $orderq = array('GOL' => 'desc');
	var $column_orderang = array('THBLREK','TGL_BUAT');
	var $column_searchang = array('THBLREK','ID_LANG');
	var $orderang = array('THBLREK' => 'desc');
	var $column_order = array('THBLREK','ID_LANG');
	var $column_search = array('THBLREK','ID_LANG','NAMA_LANG');
	var $order = array('THBLREK' => 'desc');
	var $column_order_approve = array('ID_LANG');
	var $column_search_approve = array('ID_LANG','NAMA_LANG');
	var $order_approve = array('TGL_BUAT' => 'desc');
	var $column_order_onof = array('THBLREK');
	var $column_search_onof = array('THBLREK');
	var $order_onof = array('THBLREK' => 'desc');
	var $column_order_kendali = array('THBLREK');
	var $column_search_kendali = array('THBLREK','ID_LANG');
	var $order_kendali = array('THBLREK' => 'desc');
	var $column_order_mohon = array('THBL_MOHON','ID_LANG');
	var $column_search_mohon = array('THBL_MOHON','ID_LANG','NAMA_LANG');
	var $order_mohon = array('THBL_MOHON' => 'desc');
	var $column_order_onof_mohon = array('THBL_MOHON');
	var $column_search_onof_mohon = array('THBL_MOHON');
	var $order_onof_mohon = array('THBL_MOHON' => 'desc');
	var $order_onof_v = array('tgl_lunas' => 'desc');
	var $order_onof_v_piutang = array('thblrek' => 'desc');
	var $order_onof_v_nontaglis = array('Thbl_lunas' => 'desc');
	var $order_onof_v_detail = array('NO_AGENDA' => 'desc');
	var $column_orderpf = array('a.THBLREK','a.ID_LANG');
	var $column_searchpf = array('a.THBLREK','a.ID_LANG');
	var $orderpf = array('a.THBLREK' => 'desc');
	var $column_order_detbpujl = array('NO_AGENDA');
	var $column_search_detbpujl = array('NO_AGENDA','NAMA_LANG');
	var $order_detbpujl = array('TGL_BAYAR' => 'desc');
	var $column_orders = array('THBLREK');
	var $column_searchs = array('THBLREK');
	var $orders = array('THBLREK' => 'desc');
	
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
	}

	public function get_pelunasan($idcari='')
    {
		$query = $this->db->query("SELECT *
									FROM tp_agenda
									WHERE no_agenda = '$idcari' LIMIT 1");
		return $getlunas = $query->result();
    }

	public function get_caritarif($idcari='')
    {
		$query = $this->db->query("SELECT RP_LWBP,RP_WBP,RP_KVARH FROM v_tr_tarif WHERE KD_TARIF = '$idcari' ");
		return $gettarif = $query->result();
    }

	public function get_pelunasanrek($idcari='')
    {
		$query = $this->db->query("SELECT GROUP_CONCAT(a.THBLREK) THBLREK,a.KD_AREA,a.ID_CUST,a.ID_LANG,b.NAMA_LANG,b.ALAMAT_LANG,a.TARIF,a.DAYA,a.TGL_LUNAS, CONCAT(COUNT(a.THBLREK),' Bulan') BRPBULAN, (SUM(RPTAG) + SUM(RP_BK)) TOTAL, a.STATUS_LUNAS, a.STATUS_CTK_KWITANSI
									FROM master_rekening a
									JOIN dil_listrik_log b ON CONCAT(b.ID_LANG,b.ID_CUST) = CONCAT(a.ID_LANG,a.ID_CUST) AND b.THBLREK=a.THBLREK
									WHERE a.id_lang='$idcari' AND STATUS_LUNAS = '0' ");
		return $getlunas = $query->result();
    }

	public function get_pelunasanrekbycust($idcari='')
    {
		$query = $this->db->query("SELECT a.ID_CUST,b.NAMA_CUST
									FROM master_rekening a
									JOIN cust b ON b.ID_CUST = a.ID_CUST
									WHERE a.id_cust='$idcari' AND STATUS_LUNAS = '0' ");
		return $getlunas = $query->result();
    }

	public function get_pelunasaninfo($idcari='')
    {
		$query = $this->db->query("SELECT DISTINCT ID_LANG
									FROM master_rekening
									WHERE id_lang='$idcari' ");
		return $getlunas = $query->result();
    }

	public function save($table,$data)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function get_otokwitansi()
    {
		$query = $this->db->query("SELECT LPAD(MAX(RIGHT(NO_KWITANSI,4))+1,4,'0000') AS NOKWIT
									FROM tp_agenda ");
		return $getotokwitansi = $query->result();
    }

	public function get_bk($idcari='')
    {
		$query = $this->db->query("SELECT a.THBLREK, a.ID_CUST,a.ID_LANG,b.NAMA_LANG,b.ALAMAT_LANG,a.TARIF,a.DAYA
									FROM master_rekening a
									JOIN dil_listrik_ref b ON CONCAT(a.ID_CUST,a.ID_LANG) = CONCAT(b.ID_CUST,b.ID_LANG)
									WHERE a.ID_LANG = '$idcari' LIMIT 1");
		return $getbk = $query->result();
    }

	#PEMBATALAN PENGALIHAN BK
	function get_datatables($idcari)
	{
		$this->_get_datatables_query($idcari);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query($idcari='')
	{
		$this->db->select("ID,THBLREK,ID_LANG,RPTAG,RP_BK");
		$this->db->from("master_rekening");
		$this->db->where("ID_LANG = '$idcari' AND STATUS_LUNAS = '0' ");

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

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from('dil_listrik_new');
		return $this->db->count_all_results();
	}

	#PERSETUJUAN BK
	function get_datatables_approve()
	{
		$this->_get_datatables_query_approve();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_approve()
	{
		$this->db->select('THBLREK,ID_LANG,NAMA_LANG,RP_KWH,RP_BK,TGL_BUAT,STATUS_BK,ACTION');
		$this->db->from('tp_approvebk');
		$i = 0;
		foreach ($this->column_search_approve as $item)
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

				if(count($this->column_search_approve) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_approve[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_approve))
		{
			$order = $this->order_approve;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_approve()
	{
		$this->_get_datatables_query_approve();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_approve()
	{
		$this->db->from('tp_approvebk');
		return $this->db->count_all_results();
	}

	#MONITORING KEUANGAN
	function get_datatables_online()
	{
		$this->_get_datatables_query_online();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_online()
	{
		$this->db->select("*");
		$this->db->from("v_saldopiutang_rekaplunas_harian");
		$this->db->where("user_lunas LIKE '%PPOB%' OR user_lunas LIKE '%BUKOPIN%' ");
		$i = 0;
		foreach (array('Thbl_lunas') as $item)
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

				if(count(array('Thbl_lunas')) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array('tgl_lunas')[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v))
		{
			$order = array('tgl_lunas' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_online()
	{
		$this->_get_datatables_query_online();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_online()
	{
		$this->db->select("*");
		$this->db->from("v_saldopiutang_rekaplunas_harian");
		$this->db->where("user_lunas LIKE '%PPOB%' OR user_lunas LIKE '%BUKOPIN%' ");
		return $this->db->count_all_results();
	}

	#OFFLINE
	function get_datatables_offline()
	{
		$this->_get_datatables_query_offline();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_offline()
	{
		$this->db->select("*");
		$this->db->from("v_saldopiutang_rekaplunas_harian");
		$this->db->where("user_lunas NOT LIKE '%PPOB%' AND user_lunas NOT LIKE '%BUKOPIN%' ");
		$i = 0;
		foreach (array('Thbl_lunas') as $item)
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

				if(count(array('Thbl_lunas')) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array('tgl_lunas')[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v))
		{
			$order = array('tgl_lunas' => 'desc');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_offline()
	{
		$this->_get_datatables_query_offline();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_offline()
	{
		$this->db->select("*");
		$this->db->from("v_saldopiutang_rekaplunas_harian");
		$this->db->where("user_lunas like '%EPI%'");
		return $this->db->count_all_results();
	}

	function get_datatables_piutang()
	{
		$this->_get_datatables_query_piutang();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_piutang()
	{
		$this->db->select("*");
		$this->db->from("v_saldopiutang_perthblrek");
		$i = 0;
		foreach (array("thblrek") as $item)
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

				if(count(array("thblrek")) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array("thblrek")[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v_piutang))
		{
			$order = array("thblrek");
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_piutang()
	{
		$this->_get_datatables_query_piutang();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_piutang()
	{
		$this->_get_datatables_query_piutang();
		return $this->db->count_all_results();
	}

	#DET BP UJL
	function get_datatables_detbpujl()
	{
		$this->_get_datatables_query_detbpujl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_detbpujl()
	{
		$this->db->from('v_pelunasan_nontaglis_detail');
		$i = 0;
		foreach ($this->column_search_detbpujl as $item)
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

				if(count($this->column_search_detbpujl) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_detbpujl[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_detbpujl))
		{
			$order = $this->order_detbpujl;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detbpujl()
	{
		$this->_get_datatables_query_detbpujl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detbpujl()
	{
		$this->db->from('v_pelunasan_nontaglis_detail');
		return $this->db->count_all_results();
	}

	#REKAP NON TAGLIS
	function get_datatables_rekapnontaglis()
	{
		$this->_get_datatables_query_rekapnontaglis();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_rekapnontaglis()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis");
		$i = 0;
		foreach (array('Thbl_lunas') as $item)
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

				if(count(array('Thbl_lunas')) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array('Thbl_lunas')[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v_nontaglis))
		{
			$order = array('Thbl_lunas');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapnontaglis()
	{
		$this->_get_datatables_query_rekapnontaglis();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapnontaglis()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis");
		return $this->db->count_all_results();
	}

	function get_datatables_detnontaglis()
	{
		$this->_get_datatables_query_detnontaglis();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_detnontaglis()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_detail");
		$i = 0;
		foreach (array("NO_AGENDA") as $item)
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

				if(count(array("NO_AGENDA")) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array("NO_AGENDA")[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v_detail))
		{
			$order = array("NO_AGENDA");
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detnontaglis()
	{
		$this->_get_datatables_query_detnontaglis();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detnontaglis()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_detail");
		return $this->db->count_all_results();
	}

	function get_datatables_rekapnontaglisps()
	{
		$this->_get_datatables_query_rekapnontaglisps();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_rekapnontaglisps()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_ps");
		$i = 0;
		foreach (array('Thbl_lunas') as $item)
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

				if(count(array('Thbl_lunas')) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array('Thbl_lunas')[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v_nontaglis))
		{
			$order = array('Thbl_lunas');
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekapnontaglisps()
	{
		$this->_get_datatables_query_rekapnontaglisps();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapnontaglisps()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_ps");
		return $this->db->count_all_results();
	}

	function get_datatables_detnontaglisps()
	{
		$this->_get_datatables_query_detnontaglisps();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_detnontaglisps()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_detail_ps");
		$i = 0;
		foreach (array("NO_AGENDA") as $item)
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

				if(count(array("NO_AGENDA")) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by(array("NO_AGENDA")[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_onof_v_detail))
		{
			$order = array("NO_AGENDA");
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_detnontaglisps()
	{
		$this->_get_datatables_query_detnontaglisps();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detnontaglisps()
	{
		$this->db->select("*");
		$this->db->from("v_pelunasan_nontaglis_detail_ps");
		return $this->db->count_all_results();
	}

	public function get_kendaliproses(){
		$sekarang   = date("Y-m-d H:i:s");
		$thblreknow = date("Ym", mktime(0,0,0,date("m"), date("d"), date("Y")));
		$thblrekminsatu = date("Ym", mktime(0,0,0,date("m")-1, date("d"), date("Y")));
		$thblrekmindua = date("Ym", mktime(0,0,0,date("m")-2, date("d"), date("Y")));

		#TAHAP PERTAMA
		$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '1'
									WHERE RP_BK > 0 AND STATUS_BK= '1' AND STATUS_LUNAS = '0' AND KOGOL = '0' AND TGL_PUTUS = '0000-00-00 00:00:00'
									and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') )   ");
											
		#TAHAP KEDUA
		$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '2' 
									WHERE RP_BK > 0 AND STATUS_BK= '2' AND STATUS_LUNAS = '0' AND KOGOL = '0' AND TGL_PUTUS != '0000-00-00 00:00:00' 
									and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') ) ");

		#TAHAP KETIGA
		$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '3'
									WHERE RP_BK > 0 AND STATUS_BK= '3' AND STATUS_LUNAS = '0' AND KOGOL = '0' AND TGL_PUTUS != '0000-00-00 00:00:00' 
									and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') ) ");
		
		#KEMUNGKINAN
			#TAHAP SATU
			$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '1'
										WHERE RP_BK > 0 AND STATUS_LUNAS = '0' AND KOGOL = '0' AND THBLREK < $thblreknow 
										and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') ) ");

			#TAHAP KEDUA
			$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '2'
										WHERE RP_BK > 0 AND STATUS_LUNAS = '0' AND KOGOL = '0' AND TGL_PUTUS != '0000-00-00 00:00:00' AND DATE_FORMAT(TGL_PUTUS, '%Y%m') = $thblrekminsatu 
										and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') ) ");

			#TAHAP KETIGA
			$query = $this->db->query("UPDATE MASTER_REKENING SET STATUS_PMT = '3'
										WHERE RP_BK > 0 AND STATUS_LUNAS = '0' AND KOGOL = '0' AND TGL_PUTUS != '0000-00-00 00:00:00' AND DATE_FORMAT(TGL_PUTUS, '%Y%m') = $thblrekmindua 
										and id_lang in (select id_lang from dil_listrik_new where kd_mut not in ('N','') ) ");

		if($query){
			$tes = $this->db->query("SELECT 'SUKSES'");
			return $tes->result();
		}else{
			$tes = $this->db->query("SELECT 'GAGAL'");
			return $tes->result();
		}
    }
	
	public function get_idlang_putus($kondisi)
    {
        $query = $this->db->query("SELECT a.ID_LANG 
									FROM master_rekening a 
									LEFT JOIN dil_listrik_new b ON a.ID_LANG=b.ID_LANG
									$kondisi GROUP BY a.ID_LANG ORDER BY a.ID ASC");	
		$dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->ID_LANG] = $dropdown->ID_LANG;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }
	
	public function get_detnamaputus($idcari='')
    {
		$query = $this->db->query("SELECT NAMA_LANG, ALAMAT_LANG FROM DIL_LISTRIK_NEW WHERE ID_LANG = '$idcari' ");
		return $getdet = $query->result();
    }

	#KENDALI SATU
	function get_datatables_kendalisatu()
	{
		$this->_get_datatables_query_kendalisatu();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_kendalisatu()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_A,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("a.STATUS_PMT = 1");
		$this->db->where("a.STATUS_LUNAS = 0");
		$this->db->where("b.KD_MUT NOT IN ('N','') ");
		$this->db->where("a.KOGOL = '0' ");
		$this->db->group_by("a.ID_LANG");

		$i = 0;
		foreach ($this->column_search_kendali as $item)
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

				if(count($this->column_search_kendali) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_kendali[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_kendali))
		{
			$order = $this->order_kendali;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_kendalisatu()
	{
		$this->_get_datatables_query_kendalisatu();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_kendalisatu()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_A,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("a.STATUS_PMT = 1");
		$this->db->where("a.STATUS_LUNAS = 0");
		$this->db->where("a.TGL_PUTUS = '0000-00-00 00:00:00' ");		
		$this->db->group_by("a.ID_LANG");
		return $this->db->count_all_results();
	}

	#KENDALI DUA
	function get_datatables_kendalidua()
	{
		$this->_get_datatables_query_kendalidua();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_kendalidua()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_B,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("STATUS_PMT = 2");
		$this->db->where("b.KD_MUT NOT IN ('N','') ");
		$this->db->where("a.KOGOL = '0' ");
		$this->db->where("a.TGL_PUTUS != '0000-00-00 00:00:00' ");
		$this->db->where("STATUS_LUNAS = 0");
		$this->db->group_by("a.ID_LANG");

		$i = 0;
		foreach ($this->column_search_kendali as $item)
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
			$this->db->order_by($this->column_order_kendali[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_kendali))
		{
			$order = $this->order_kendali;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_kendalidua()
	{
		$this->_get_datatables_query_kendalidua();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_kendalidua()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_B,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("STATUS_PMT = 2");
		$this->db->where("b.KD_MUT NOT IN ('N','') ");
		$this->db->where("a.KOGOL = '0' ");
		$this->db->where("a.TGL_PUTUS != '0000-00-00 00:00:00' ");
		$this->db->where("STATUS_LUNAS = 0");
		$this->db->group_by("a.ID_LANG");

		return $this->db->count_all_results();
	}

	#KENDALI TIGA
	function get_datatables_kendalitiga()
	{
		$this->_get_datatables_query_kendalitiga();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_kendalitiga()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_B,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("STATUS_PMT = 3");
		$this->db->where("STATUS_LUNAS = 0");
		$this->db->where("b.KD_MUT NOT IN ('N','') ");
		$this->db->where("a.KOGOL = '0' ");
		$this->db->where("a.TGL_PUTUS != '0000-00-00 00:00:00' ");
		$this->db->group_by("a.ID_LANG");

		$i = 0;
		foreach ($this->column_search_kendali as $item)
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

				if(count($this->column_search_kendali) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_kendali[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_kendali))
		{
			$order = $this->order_kendali;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_kendalitiga()
	{
		$this->_get_datatables_query_kendalitiga();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_kendalitiga()
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG,a.PERIODE,COUNT(a.THBLREK) LEMBAR,SUM(a.RPTAG) RPTAG,SUM(a.RP_BK) RP_BK,a.CETAK_KENDALI_B,a.TGL_PUTUS,a.TGL_LUNAS,a.TGL_SAMBUNG");
		$this->db->from("MASTER_REKENING a");
		$this->db->join("DIL_LISTRIK_NEW b","a.ID_LANG=b.ID_LANG");
		$this->db->where("STATUS_PMT = 3");
		$this->db->where("STATUS_LUNAS = 0");
		$this->db->where("b.KD_MUT NOT IN ('N','') ");
		$this->db->where("a.KOGOL = '0' ");
		$this->db->where("a.TGL_PUTUS != '0000-00-00 00:00:00' ");
		$this->db->group_by("a.ID_LANG");

		return $this->db->count_all_results();
	}

	#PELUNASAN REK BY CUST
	function get_datatableslunasbycust($idcari)
	{
		$this->_get_datatables_querylunasbycust($idcari);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_querylunasbycust($idcari='')
	{
		$this->db->select("ID,ID_LANG,THBLREK,ID_CUST,COUNT(THBLREK) JML_LEMBAR,SUM(RPTAG) RPTAG, SUM(RP_BK) RP_BK, SUM(TOTAL_INVOICE) TOTAL_INVOICE");
		$this->db->from("master_rekening");
		$this->db->where("ID_CUST", $idcari);
		$this->db->where("STATUS_LUNAS", "0");
		$this->db->group_by("THBLREK");
		$i = 0;

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

	function count_filteredlunasbycust()
	{
		$this->_get_datatables_querylunasbycust();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_alllunasbycust($idcari='')
	{
		$this->db->select("ID,THBLREK,ID_CUST,COUNT(THBLREK) JML_LEMBAR,SUM(RPTAG) RPTAG, SUM(RP_BK) RP_BK, SUM(TOTAL_INVOICE) TOTAL_INVOICE");
		$this->db->from("master_rekening");
		$this->db->where("ID_CUST", $idcari);
		$this->db->where("STATUS_LUNAS", "0");
		$this->db->group_by("THBLREK");
		return $this->db->count_all_results();
	}

	public function get_suminvoice($id_cust)
    {
		$query = $this->db->query("select count(THBLREK) TOTAL_LEMBAR,FORMAT(sum(TOTAL_INVOICE),0) TOTAL_INVOICE
									from master_rekening
									where ID_CUST = '$id_cust' AND STATUS_LUNAS = '0' group by id_cust ");
		return $get_suminvoice = $query->result();
    }

	#PELUNASAN REK BY LANG
	function get_datatableslunasbylang($idcari)
	{
		$this->_get_datatables_querylunasbylang($idcari);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_querylunasbylang($idcari='')
	{
		$this->db->select("a.ID,a.THBLREK,a.ID_LANG,b.NAMA_LANG, a.RPTAG, a.RP_BK, (a.RPTAG + a.RP_BK) TOTAL_INVOICE, date(a.tgl_lunas) TGL_LUNAS, IF(a.STATUS_LUNAS=0,'BELUM LUNAS','LUNAS') STATUS_LUNAS ");
		$this->db->from("master_rekening a");
		$this->db->join("dil_listrik_log b","CONCAT(b.ID_LANG,b.ID_CUST) = CONCAT(a.ID_LANG,a.ID_CUST) AND b.THBLREK=a.THBLREK");
		#$this->db->where("a.id_lang='$idcari' AND a.TGL_STATUSREK > DATE_SUB(now(), INTERVAL 12 MONTH) ");
		$this->db->where("a.id_lang='$idcari'  ");
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

	function count_filteredlunasbylang()
	{
		$this->_get_datatables_querylunasbylang();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_alllunasbylang($idcari='')
	{
		$this->db->select("a.THBLREK,a.ID_LANG,b.NAMA_LANG, a.RPTAG, a.RP_BK, (a.RPTAG + a.RP_BK) TOTAL_INVOICE, IF(a.STATUS_LUNAS=0,'BELUM LUNAS','LUNAS') STATUS_LUNAS ");
		$this->db->from("master_rekening a");
		$this->db->join("dil_listrik_log b","CONCAT(b.ID_LANG,b.ID_CUST) = CONCAT(a.ID_LANG,a.ID_CUST) AND b.THBLREK=a.THBLREK");
		#$this->db->where("a.id_lang='$idcari' AND a.TGL_STATUSREK > DATE_SUB(now(), INTERVAL 6 MONTH) ");
		$this->db->where("a.id_lang='$idcari'  ");
		return $this->db->count_all_results();
	}

	#REKAP REK TERBIT
	function get_datatables_rekterbitgol($idcari)
	{
		$this->_get_datatables_query_rekterbitgol($idcari);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_rekterbitgol($idcari='')
	{
		if($idcari == '' OR $idcari == null){
			$this->db->select("THBLREK, b.uraian GOL, a.KOGOL, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
								SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("BILLING_LISTRIK_REF a");
			$this->db->join("TR_GOLONGAN b","a.KOGOL = b.kd_gol");
			$this->db->group_by("a.KOGOL");
		}else{
			$this->db->select("THBLREK, b.uraian GOL, a.KOGOL, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
								SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_GOLONGAN b","a.KOGOL = b.kd_gol");
			$this->db->where("a.THBLREK","$idcari");
			$this->db->group_by("a.KOGOL");
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

	function count_filtered_rekterbitgol()
	{
		$this->_get_datatables_query_rekterbitgol();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekterbitgol($idcari)
	{
		if($idcari == '' OR $idcari == null){
			$this->db->select("THBLREK, b.uraian GOL, a.KOGOL, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
								SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("BILLING_LISTRIK_REF a");
			$this->db->join("TR_GOLONGAN b","a.KOGOL = b.kd_gol");
			$this->db->group_by("a.KOGOL");
		}else{
			$this->db->select("THBLREK, b.uraian GOL, a.KOGOL, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
								SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_GOLONGAN b","a.KOGOL = b.kd_gol");
			$this->db->where("a.THBLREK","$idcari");
			$this->db->group_by("a.KOGOL");
		}
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
			$this->db->order_by($this->column_orders[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orders))
		{
			$order = $this->orders;
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
			$this->db->group_by("a.THBLREK");
		}else{
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->where("THBLREK","$idcari");
			$this->db->group_by("a.THBLREK");
		}
		
		return $this->db->count_all_results();
	}
	
	#FILTER THBLREK TERBIT
	function get_datatables_rekaphitungthblrek($idcari)
	{
		$this->_get_datatables_query_rekaphitungthblrek($idcari);
		$query = $this->db->get();
		return $query->result();
	}
	
	private function _get_datatables_query_rekaphitungthblrek($idcari='')
	{
		if($idcari == '' OR $idcari == null){
			$this->db->from("v_rekap_rekening_terbitthblrek");
			$this->db->where("LEFT(THBLREK,4) = YEAR(NOW())");
		}else{
			$this->db->from("v_rekap_rekening_terbitthblrek");
			$this->db->where("LEFT(THBLREK,4)","$idcari");
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orders[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->orders))
		{
			$order = $this->orders;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rekaphitungthblrek()
	{
		$this->_get_datatables_query_rekaphitungthblrek();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekaphitungthblrek($idcari='')
	{
		if($idcari == '' OR $idcari == null){
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("BILLING_LISTRIK_REF a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->group_by("a.THBLREK");
		}else{
			$this->db->select("THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG");
			$this->db->from("MASTER_REKENING a");
			$this->db->join("TR_AREA b","a.KD_AREA=b.kd_area");
			$this->db->where("THBLREK","$idcari");
			$this->db->group_by("a.THBLREK");
		}
		
		return $this->db->count_all_results();
	}

	#REKAP ANGSURAN
	function get_datatables_angsuran()
	{
		$this->_get_datatables_query_angsuran();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_angsuran()
	{
		$this->db->select("a.THBLREK, a.ID_CUST, a.ID_LANG, COUNT(a.ID_LANG) JML_MOHON, SUM(a.RP_BP) RP_BP, SUM(a.RP_UJL) RP_UJL, SUM(a.RP_BK) RP_BK, SUM(a.RP_KWH) RP_KWH, SUM(a.RP_P2TL) RP_P2TL, SUM(a.RP_INVESTASI) RP_INVESTASI, SUM(a.RP_METERAI) RP_METERAI, a.TGL_BUAT");
		$this->db->from("TP_ANGSURAN a");
		$this->db->group_by("a.ID_LANG,a.THBLREK");
		$i = 0;
		foreach ($this->column_searchang as $item)
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

				if(count($this->column_searchang) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderang[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderang))
		{
			$order = $this->orderang;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_angsuran()
	{
		$this->_get_datatables_query_angsuran();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_angsuran()
	{
		$this->db->select("THBLREK, KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, '0' MATERAI, SUM(RPTAG) RPTAG");
		$this->db->from("BILLING_LISTRIK_REF");
		$this->db->group_by("KD_AREA");
		return $this->db->count_all_results();
	}


	#PELUNASAN PIUTANG FILTERING
	function get_datatablesfilter($idcari)
	{
		$this->_get_datatables_queryfilter($idcari);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_queryfilter($idcari='')
	{
		$this->db->select("a.THBLREK,a.ID_LANG,b.NAMA_LANG,b.ALAMAT_LANG,a.RPTAG,a.RP_BK,a.TOTAL_INVOICE ,if(a.tgl_lunas > '$idcari', a.status_lunas='0', a.status_lunas ) STATUS_LUNASFILTER",FALSE);
		$this->db->from("master_rekening a");
		$this->db->join("dil_listrik_new b","a.ID_LANG=b.ID_LANG");
		$this->db->where("if(day('$idcari') < '5', a.thblrek < DATE_FORMAT('$idcari','%Y%m'), a.thblrek <= DATE_FORMAT('$idcari','%Y%m')  )");

		$i = 0;
		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_orderpf[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->orderpf))
		{
			$order = $this->orderpf;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filteredfilter()
	{
		$this->_get_datatables_queryfilter();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_allfilter($idcari='')
	{
		$this->db->from("master_rekening");
		$this->db->where("status_lunas = '1' AND DATE(TGL_LUNAS) <= '$idcari' AND YEAR(TGL_LUNAS)=YEAR('$idcari') ");
		$this->db->order_by("THBLREK","DESC");
		return $this->db->count_all_results();
	}

	public function by_thbllunas()
    {
        $query = $this->db->query("SELECT Thbl_lunas FROM v_saldopiutang_rekaplunas_harian GROUP BY Thbl_lunas ORDER BY Thbl_lunas DESC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Filter Cetakan Detail - ";
            return $finaldropdown;
        }else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->Thbl_lunas] = $dropdown->Thbl_lunas;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Filter Cetakan Detail - ";
            return $finaldropdown;
        }
    }

	public function get_kwitansibylang($idcari='')
    {
		$query = $this->db->query("SELECT DISTINCT a.ID_LANG,b.NAMA_LANG
									FROM master_rekening a
									JOIN dil_listrik_log b ON b.ID_LANG = a.ID_LANG
									WHERE a.id_lang='$idcari'  ");
		return $getlunas = $query->result();
    }

	#KWITANSI REK BY LANG
	function get_datatableskwitansibylang($idcari)
	{
		$this->_get_datatables_querykwitansibylang($idcari);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_querykwitansibylang($idcari='')
	{

		$this->db->select("GROUP_CONCAT(THBLREK) THBLREK,ID_CUST,ID_LANG,date(TGL_LUNAS) TGL_LUNAS, CONCAT(COUNT(THBLREK),' Bulan') BRPBULAN, (SUM(RPTAG) + SUM(RP_BK)) TOTAL, STATUS_LUNAS, STATUS_CTK_KWITANSI");
		$this->db->from("master_rekening");
		$this->db->where("ID_LANG", $idcari);
		$this->db->group_by("date(TGL_LUNAS)");
		$this->db->order_by("date(TGL_LUNAS)");
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

	function count_filteredkwitansibylang()
	{
		$this->_get_datatables_querykwitansibylang();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_allkwitansibylang($idcari='')
	{
		$this->db->select("GROUP_CONCAT(THBLREK) THBLREK,KD_AREA,ID_CUST,ID_LANG,TARIF,DAYA,TGL_LUNAS, CONCAT(COUNT(THBLREK),' Bulan') BRPBULAN, (SUM(RPTAG) + SUM(RP_BK)) TOTAL, STATUS_LUNAS, STATUS_CTK_KWITANSI");
		$this->db->from("master_rekening");
		$this->db->where("ID_LANG", $idcari);
		$this->db->group_by("date(TGL_LUNAS)");
		return $this->db->count_all_results();
	}

}
