<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendorm extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	var $table = 'v_tvd_list_b';
	var $column_order = array('id_vd','nama_pt','grade_siup','grade_siujk','nama_pic',null);
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
		$this->db->from($this->table);
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

	public function get_data_tvd_list()
	{
		$query = $this->db->query("SELECT id, uraian as isi FROM tl_pengadaan");
		return $query->result();
	}

	function cari_vendor($kunci)
	{
		$this->db->where("CONCAT(id_vd,' ',nama_pt) like '%".$kunci."%' ");
		$this->db->group_by('id_vd');
    $this->db->order_by('nama_pt', 'ASC');
    $this->db->limit(10);
    return $this->db->get('tvd_list')->result();
  }

	function cari_vendor_blacklist($kunci)
	{
		$query = $this->db->query("SELECT * FROM tvd_list where nama_pt like '%$kunci%' group by id_vd order by nama_pt asc limit 10 ");
		return $query->result();
	}

	function get_vendor_siup($kunci)
	{
		$query = $this->db->query("SELECT * FROM tvd_siup where id_vd = '$kunci'");
		return $query->result();
	}

	function get_vendor_siujk($kunci)
	{
		$query = $this->db->query("SELECT * FROM tvd_siujk where id_vd = '$kunci'");
		return $query->result();
	}

	function get_vendor_siu($kunci)
	{
		$query = $this->db->query("SELECT * FROM tvd_siu where id_vd = '$kunci'");
		return $query->result();
	}

}
