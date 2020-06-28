<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Monitoringm extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	var $table_bl = 'v_tblacklist';
	var $column_order_bl = array('id_vd','nama_pt','tgl_awal','tgl_akhir','keterangan','blacklist_oleh','status_blacklist');
	var $column_search_bl = array('id_vd','nama_pt');
	var $order_bl = array('status_blacklist' => 'asc');

	function get_datatables_blacklist()
	{
		$this->_get_datatables_query_blacklist();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_blacklist()
	{
		$this->db->select('*');
		$this->db->from($this->table_bl);
		$i = 0;
		foreach ($this->column_search_bl as $item)
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

				if(count($this->column_search_bl) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_bl[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_bl))
		{
			$order = $this->order_bl;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_bl()
	{
		$this->_get_datatables_query_blacklist();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_bl()
	{
		$this->db->from($this->table_bl);
		return $this->db->count_all_results();
	}

	var $table = 'v_tvd_list_a';
	var $column_order = array('id_vd','nama_pt','data_administrasi','data_domisili','tgl_domisili','data_akta_pendirian','data_akta_perubahan','data_npwp','data_pkp','data_tdp','tgl_tdp','data_siup','tgl_siup','data_siujk','tgl_siujk','data_siu','tgl_siu',null);
	var $column_search = array('id_vd','nama_pt');
	var $order = array('id' => 'asc');

	function get_datatables_vendor()
	{
		$this->_get_datatables_query_vendor();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_vendor()
	{
		$this->db->select('*');
		$this->db->from('v_tvd_list_a');
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
		$this->_get_datatables_query_vendor();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	var $table_aktif = 'v_vendor_status_a';
	var $column_order_aktif = array('id_vd','nama_pt','grade_siup','grade_siujk');
	var $column_search_aktif = array('id_vd','nama_pt');
	var $order_aktif = array('id_vd' => 'asc');

	function get_datatables_aktif()
	{
		$this->_get_datatables_query_aktif();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_aktif()
	{
		$this->db->select('*');
		$this->db->from($this->table_aktif);
		$i = 0;
		foreach ($this->column_search_aktif as $item)
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

				if(count($this->column_search_aktif) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_aktif[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_aktif))
		{
			$order = $this->order_aktif;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_aktif()
	{
		$this->_get_datatables_query_aktif();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_aktif()
	{
		$this->db->from($this->table_aktif);
		return $this->db->count_all_results();
	}

	var $table_pasif = 'v_vendor_status_b';
	var $column_order_pasif = array('id_vd','nama_pt','grade_siup','grade_siujk');
	var $column_search_pasif = array('id_vd','nama_pt');
	var $order_pasif = array('id_vd' => 'asc');

	function get_datatables_pasif()
	{
		$this->_get_datatables_query_pasif();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_pasif()
	{
		$this->db->select('*');
		$this->db->from($this->table_pasif);
		$i = 0;
		foreach ($this->column_search_pasif as $item)
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

				if(count($this->column_search_pasif) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_pasif[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_pasif))
		{
			$order = $this->order_pasif;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_pasif()
	{
		$this->_get_datatables_query_pasif();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_pasif()
	{
		$this->db->from($this->table_pasif);
		return $this->db->count_all_results();
	}

	var $table_rv = 'v_vendor_list';
	var $column_order_rv = array('id_vd','nama_pt','jum_pekerjaan','nilai_pekerjaan');
	var $column_search_rv = array('id_vd','nama_pt');
	var $order_rv = array('jum_pekerjaan' => 'desc' );

	function get_datatables_rv()
	{
		$this->_get_datatables_query_rv();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_rv()
	{
		$this->db->select('*');
		$this->db->from($this->table_rv);
		$i = 0;
		foreach ($this->column_search_rv as $item)
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

				if(count($this->column_search_rv) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if(isset($_POST['order']))
		{
			$this->db->order_by($this->column_order_rv[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		}
		else if(isset($this->order_rv))
		{
			$order = $this->order_rv;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered_rv()
	{
		$this->_get_datatables_query_rv();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rv()
	{
		$this->db->from($this->table_rv);
		return $this->db->count_all_results();
	}

}
