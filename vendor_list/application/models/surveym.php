<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surveym extends CI_Model {

	var $table = 'tp_agenda';
	var $column_order = array('no_agenda','no_regis','nama',null); 
	var $column_search = array('no_agenda','no_regis','nama');
	var $order = array('id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
	}

	public function save($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
	}

	public function update($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->table);
	}
	
	public function get_otosurvey()
    {
		$query = $this->db->query("SELECT LPAD(MAX(SUBSTRING(no_survey,6,6))+1,5,'00000') AS no_survey FROM tp_agenda");
		return $agenda = $query->result();
    }

}
