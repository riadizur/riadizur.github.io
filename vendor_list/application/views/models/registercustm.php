<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registercustm extends CI_Model {

	var $table = 'cust';
	var $column_order = array('ID_CUST','NAMA_CUST','ALAMAT_CUST','KOTA_CUST','PROV_CUST',null);
	var $column_search = array('ID_CUST','NAMA_CUST','ALAMAT_CUST');
	var $order = array('id' => 'asc');

	public function __construct()
	{
		parent::__construct();
	}

	private function _get_datatables_query()
	{
		$this->db->select('cust.*, tr_kec.nama KECCUST, tr_kab.nama KABCUST, tr_prov.nama PROVCUST');
		$this->db->from('cust');
		$this->db->join('tr_kec', 'cust.kec_cust = tr_kec.id_kec');
		$this->db->join('tr_kab', 'cust.kota_cust = tr_kab.id_kab');
		$this->db->join('tr_prov', 'cust.prov_cust = tr_prov.id_prov');
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
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_by_id($id)
	{
		$this->db->from('cust');
		$this->db->where('id_cust',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function get_by_id_full($id)
	{
		$this->db->select('cust.*, tr_kec.nama KECCUST, tr_kab.nama KABCUST, tr_prov.nama PROVCUST');
		$this->db->from('cust');
		$this->db->join('tr_kec', 'cust.kec_cust = tr_kec.id_kec');
		$this->db->join('tr_kab', 'cust.kota_cust = tr_kab.id_kab');
		$this->db->join('tr_prov', 'cust.prov_cust = tr_prov.id_prov');
		$this->db->where('id_cust',$id);
		$query = $this->db->get();

		return $query->row();
	}

	public function save($tabel,$data)
	{
		$this->db->insert($tabel, $data);
		return $this->db->insert_id();
	}

	public function update($table, $where, $data)
	{
		$this->db->update($table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id_cust', $id);
		$this->db->delete($this->table);

		$this->db->where('id_cust', $id);
		$this->db->delete('tp_agenda');
	}

	public function get_otoidcust()
    {
        $query = $this->db->query("SELECT LPAD(MAX(SUBSTRING(id_cust,3,4))+1,4,'0000') AS id_cust FROM cust");
        return $idcust = $query->result();
    }

}
