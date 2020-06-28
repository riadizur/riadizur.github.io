<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrakm extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	var $table = 'treg_pekerjaan';
	var $column_order = array('no_reg_pekerjaan', 'nama_pekerjaan', 'nilai_oe', 'divisi', 'metode_pengadaan', 'no_kontrak', null);
	var $column_search = array('no_reg_pekerjaan', 'nama_pekerjaan', 'divisi', 'no_kontrak');
	var $order = array('id' => 'desc');

	function get_datatables_kontrak()
	{
		$this->_get_datatables_query_kontrak();
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query_kontrak()
	{
		$this->db->select('treg_pekerjaan.id, treg_pekerjaan.no_reg_pekerjaan, treg_pekerjaan.nilai_oe, treg_pekerjaan.divisi, treg_pekerjaan.metode_pengadaan, treg_pekerjaan.no_kontrak, treg_pekerjaan.nama_pekerjaan, treg_pekerjaan.lokasi_pekerjaan, tr_kec.nama kec, tr_kab.nama kab, tr_prov.nama prov');
		$this->db->from('treg_pekerjaan');
		$this->db->join('tr_kec', 'treg_pekerjaan.kec = tr_kec.id_kec');
		$this->db->join('tr_kab', 'treg_pekerjaan.kab = tr_kab.id_kab');
		$this->db->join('tr_prov', 'treg_pekerjaan.prov = tr_prov.id_prov');
		$i = 0;
		foreach ($this->column_search as $item) {
			if ($_POST['search']['value']) {

				if ($i === 0) {
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	function count_filtered()
	{
		$this->_get_datatables_query_kontrak();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_tvd_all()
	{
		$query = $this->db->query("
		select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
		from information_schema.columns
		where table_schema = 'epi_vdl'
			and table_name = 'treg_pekerjaan'
			and COLUMN_NAME NOT IN ('id')
			and ORDINAL_POSITION < 13
		order by ORDINAL_POSITION asc
		");
		return $query->result();
	}

	public function get_status_kontrak($id)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where no_reg_pekerjaan = '$id'");
		return $query->row();
	}

	public function get_kbli_kategori($dicari)
	{
		$query = $this->db->query("SELECT kode_kategori as kode FROM tl_kbli_kategori where id in (' $dicari ') ");
		return $query->result();
	}

	public function get_kbli_detil($dicari)
	{
		$sintax = "select kode, deskripsi from tl_kbli_detil where kode_kategori in ('$dicari') and kode_level in ('SUB GOLONGAN','KELOMPOK')";
		$query = $this->db->query($sintax);
		return $query->result();
	}

	public function get_siujk_klasifikasi($dicari)
	{
		$query = $this->db->query("SELECT kode_klasifikasi as kode FROM tl_siujk_klasifikasi where id in (' $dicari ') ");
		return $idsiup = $query->result();
	}

	public function get_siujk_detil($dicari)
	{
		$sintax = "select kode_sub as kode, sub_klasifikasi as deskripsi from tl_siujk_detil where kode_klasifikasi in ('$dicari') ";
		$query = $this->db->query($sintax);
		return $idsiup = $query->result();
	}

	function cari_kontrak($kunci, $penanda)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where $penanda is null and no_reg_pekerjaan like '%$kunci%' order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	public function get_data_kontrak($cari_id = '')
	{
		$query = $this->db->query("SELECT a.*, b.`nama` kec_nama, c.`nama` kab_nama, d.`nama` prov_nama
									FROM treg_pekerjaan a
									JOIN tr_kec b ON a.`kec` = b.`id_kec`
									JOIN tr_kab c ON a.`kab` = c.`id_kab`
									JOIN tr_prov d ON a.`prov` = d.`id_prov`
									WHERE a.`no_reg_pekerjaan` = '$cari_id' ");
		return $all = $query->result();
	}

	public function get_list_vendor()
	{
		$query = $this->db->query("SELECT id, CONCAT(kode,' - ',deskripsi) as isi FROM tl_kbli_detil");
		return $idkbli = $query->result();
	}

	public function get_data_penyediaan($cari_klasifikasi)
	{
		$query = $this->db->query("SELECT * FROM tl_penyediaan where uraian = '$cari_klasifikasi'");
		return $query->row();
	}

	public function get_data_grade($izinx = '', $bidangx = '')
	{
		$query = $this->db->query("SELECT * FROM tl_grade WHERE `izin` = '$izinx' and `bidang` = '$bidangx' ORDER BY `id` ");
		return $all = $query->result();
	}

	public function get_undang_bidang($izinx, $bidangx)
	{
		switch ($izinx) {
			case 'siup':
				$query = $this->db->query("SELECT kode_kategori as kode_group, kategori as uraian FROM tl_kbli_kategori where kategori = '$bidangx' ");
				break;
			case 'siujk':
				$query = $this->db->query("SELECT kode_klasifikasi as kode_group, klasifikasi as uraian FROM tl_siujk_klasifikasi where klasifikasi = '$bidangx' ");
				break;
		}
		return $query->row();
	}

	public function get_undang($izinx, $kode_group, $nilai_oex)
	{
		switch ($izinx) {
			case 'siup':
				$sintax = "select * from v_vendor_status_siup where kode in ('$kode_group') and max_kontrak >= '$nilai_oex' group by id_vd";
				$query = $this->db->query($sintax);
				break;
			case 'siujk':
				$sintax = "select * from v_vendor_status_siujk where kode in ('$kode_group') and max_kontrak >= '$nilai_oex' group by id_vd";
				$query = $this->db->query($sintax);
				break;
		}
		return $idkbli = $query->result();
	}

	public function get_undang_grade($izinx, $kode_group, $pilihx)
	{
		switch ($izinx) {
			case 'siup':
				$sintax = "select * from v_vendor_status_siup where kode in ('$kode_group') and grade in ('$pilihx') group by id_vd";
				$query = $this->db->query($sintax);
				break;
			case 'siujk':
				$sintax = "select * from v_vendor_status_siujk where kode in ('$kode_group') and grade in ('$pilihx') group by id_vd";
				$query = $this->db->query($sintax);
				break;
		}
		return $idvendor = $query->result();
	}

	function cari_anwizing($kunci, $penanda)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where $penanda is null and no_reg_pekerjaan like '%$kunci%' and tgl_create_daftar_undang is not null order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	function get_peserta_anwizing($cari_id)
	{
		$query = $this->db->query("SELECT * FROM v_ttransaksi_vendor where no_reg_pekerjaan = '$cari_id' ");
		return $query->result();
	}

	function cari_penawaran($kunci, $penanda)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where $penanda is null and no_reg_pekerjaan like '%$kunci%' and tgl_create_daftar_undang is not null and tgl_anwizing is not null order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	function get_peserta_penawaran($cari_id)
	{
		$query = $this->db->query("SELECT * FROM v_ttransaksi_vendor where no_reg_pekerjaan = '$cari_id' ");
		return $query->result();
	}

	function cari_penetapan($kunci, $penanda)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where $penanda is null and no_reg_pekerjaan like '%$kunci%' and tgl_create_daftar_undang is not null and tgl_anwizing is not null and tgl_penawaran is not null order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	function get_peserta_penetapan($cari_id)
	{
		$query = $this->db->query("SELECT * FROM v_ttransaksi_vendor where no_reg_pekerjaan = '$cari_id' and penawaran is not null ");
		return $query->result();
	}

	function cari_final($kunci, $penanda)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where $penanda is null and no_reg_pekerjaan like '%$kunci%' and tgl_create_daftar_undang is not null and tgl_anwizing is not null and tgl_penawaran is not null and tgl_penetapan is not null order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	function cari_penilaian_kontrak($kunci)
	{
		$query = $this->db->query("SELECT * FROM treg_pekerjaan where no_kontrak is not null and no_kontrak like '%$kunci%' and nilai_kualitas_pekerjaan is null order by no_reg_pekerjaan asc limit 10 ");
		return $query->result();
	}

	function get_data_soal()
	{
		$query = $this->db->query("SELECT * FROM tr_soal_penilaian where tahun = '2018' ");
		return $query->result();
	}

	function get_data_soal_detil($no_soal)
	{
		$query = $this->db->query("SELECT * FROM tr_soal_penilaian where soal = '$no_soal' ");
		return $query->row();
	}
}
