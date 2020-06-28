<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Referensim extends CI_Model {

	public function __construct()
	{
		parent::__construct();
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

	public function by_kec()
  {
      $query = $this->db->query("SELECT * FROM tr_kec ORDER BY id_kec ASC");
      $dropdowns = $query->result();
      if(! $dropdowns){
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
      else{
          foreach ($dropdowns as $dropdown){
              $dropdownlist[$dropdown->id_kec] = $dropdown->nama;
          }
          $finaldropdown = $dropdownlist;
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
  }

	public function by_kab()
  {
      $query = $this->db->query("SELECT * FROM tr_kab ORDER BY id_kab ASC");
      $dropdowns = $query->result();
      if(! $dropdowns){
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
      else{
          foreach ($dropdowns as $dropdown){
              $dropdownlist[$dropdown->id_kab] = $dropdown->nama;
          }
          $finaldropdown = $dropdownlist;
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
  }

	public function by_prov()
  {
      $query = $this->db->query("SELECT * FROM tr_prov ORDER BY id_prov ASC");
      $dropdowns = $query->result();
      if(! $dropdowns){
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
      else{
          foreach ($dropdowns as $dropdown){
              $dropdownlist[$dropdown->id_prov] = $dropdown->nama;
          }
          $finaldropdown = $dropdownlist;
          $finaldropdown[''] = " - Pilih - ";
          return $finaldropdown;
      }
  }

	public function get_prov()
	{
		$query = $this->db->query("SELECT * FROM tr_prov ORDER BY id_prov ASC");
		return $query->result();
	}

	public function get_chain_kab($id='')
  {
		$query = $this->db->query("SELECT * FROM tr_kab WHERE id_prov = '$id' ");
		return $kab = $query->result();
  }

	public function get_chain_kec($id='')
  {
		$query = $this->db->query("SELECT * FROM tr_kec WHERE id_kab = '$id' ");
		return $kec = $query->result();
  }

	public function get_kbli_detil()
	{
		$query = $this->db->query("SELECT id, CONCAT(kode,' - ',deskripsi) as isi FROM tl_kbli_detil");
		return $idkbli = $query->result();
	}

	public function get_kbli_detil_list()
  {
    $query = $this->db->query("SELECT kode as id, CONCAT(kode,' - ',deskripsi) as isi FROM tl_kbli_detil order by id asc ");
    $dropdowns = $query->result();
    if(! $dropdowns){
        $finaldropdown[''] = " - Pilih - ";
        return $finaldropdown;
    }
    else{
        foreach ($dropdowns as $dropdown){
            $dropdownlist[$dropdown->id] = $dropdown->isi;
        }
        $finaldropdown = $dropdownlist;
        $finaldropdown[''] = " - Pilih - ";
        return $finaldropdown;
    }
  }

	public function delete_by_siup($id_vd,$kode)
	{
		$this->db->where('id_vd', $id_vd);
		$this->db->where('kode_siup', $kode);
		$this->db->delete('tvd_siup');
	}

	public function delete_by_siujk($id_vd,$kode)
	{
		$this->db->where('id_vd', $id_vd);
		$this->db->where('kode_siujk', $kode);
		$this->db->delete('tvd_siujk');
	}

	public function delete_by_siu($id_vd,$kode)
	{
		$this->db->where('id_vd', $id_vd);
		$this->db->where('id', $kode);
		$this->db->delete('tvd_siu');
	}

	public function cek_kode_siup($id_vd,$kode)
	{
		$query = $this->db->query("SELECT * FROM tvd_siup where id_vd = '$id_vd' and  kode_siup = '$kode' ");
		return $query->num_rows();
	}

	public function cek_kode_siujk($id_vd,$kode)
	{
		$query = $this->db->query("SELECT * FROM tvd_siujk where id_vd = '$id_vd' and  kode_siujk = '$kode' ");
		return $query->num_rows();
	}

	public function cek_kode_siu($id_vd,$isi)
	{
		$query = $this->db->query("SELECT * FROM tvd_siu where id_vd = '$id_vd' and  bidang_siu = '$isi' ");
		return $query->num_rows();
	}

	public function last_kode_siu($id_vd,$isi)
	{
		$query = $this->db->query("SELECT * FROM tvd_siu where id_vd = '$id_vd' and  bidang_siu = '$isi' ");
		return $query->row();
	}

	public function get_kbli_detil_id($id)
	{
		$query = $this->db->query("SELECT id, kode, deskripsi FROM tl_kbli_detil where id = '$id' ");
		return $query->row();
	}

	public function get_kbli_detil_kode($kode)
	{
		$query = $this->db->query("SELECT id, kode, deskripsi FROM tl_kbli_detil where kode = '$kode' ");
		return $query->row();
	}

	public function get_grade()
	{
		$query = $this->db->query("SELECT id, kode, CONCAT(kualifikasi,' dgn modal ',modal_usaha) as isi FROM tl_grade where izin = 'siujk' and bidang = 'konstruksi' ");
		return $idcust = $query->result();
	}

	public function get_grade_list()
	{
		$query = $this->db->query("SELECT id, kode, CONCAT(kualifikasi,' dgn modal ',modal_usaha) as isi FROM tl_grade where izin = 'siujk' and bidang = 'konstruksi' ");
		$dropdowns = $query->result();
    if(! $dropdowns){
        $finaldropdown[''] = " - Grade Kosong - ";
        return $finaldropdown;
    }
    else{
        foreach ($dropdowns as $dropdown){
            $dropdownlist[$dropdown->kode] = $dropdown->isi;
        }
        $finaldropdown = $dropdownlist;
        $finaldropdown[''] = " - Pilih Grade - ";
        return $finaldropdown;
    }
	}

	public function get_siujk_detil()
	{
		$query = $this->db->query("SELECT id, CONCAT(kode_sub,' - ',sub_klasifikasi) as isi FROM tl_siujk_detil");
		return $idsiujk = $query->result();
	}

	public function get_siujk_detil_list()
  {
    $query = $this->db->query("SELECT kode_sub as id, CONCAT(kode_sub,' - ',sub_klasifikasi) as isi FROM tl_siujk_detil order by id asc ");
    $dropdowns = $query->result();
    if(! $dropdowns){
        $finaldropdown[''] = " - Sub Klasifikasi Kosong - ";
        return $finaldropdown;
    }
    else{
        foreach ($dropdowns as $dropdown){
            $dropdownlist[$dropdown->id] = $dropdown->isi;
        }
        $finaldropdown = $dropdownlist;
        $finaldropdown[''] = " - Pilih Sub Klasifikasi - ";
        return $finaldropdown;
    }
  }

	public function get_siujk_detil_id($id)
	{
		$query = $this->db->query("SELECT id, kode_sub, sub_klasifikasi FROM tl_siujk_detil where id = '$id' ");
		return $query->row();
	}

	public function get_siujk_detil_kode($kode)
	{
		$query = $this->db->query("SELECT id, kode_sub as kode, sub_klasifikasi as deskripsi FROM tl_siujk_detil where kode_sub = '$kode' ");
		return $query->row();
	}

	public function get_siujk_klasifikasi()
	{
		$query = $this->db->query("SELECT id, concat(kode_klasifikasi,' - ',klasifikasi) as isi, 'siujk' as jenis FROM tl_siujk_klasifikasi");
		return $idsiujk = $query->result();
	}

	public function get_siujk_klasifikasi_detil($idx)
	{
		$query = $this->db->query("SELECT id, concat(kode_klasifikasi,' - ',klasifikasi) as isi, 'siujk' as jenis FROM tl_siujk_klasifikasi where id='$idx' ");
		return $idsiujk = $query->result();
	}

	public function get_siujk_klasifikasi_detilan($idx)
	{
		$query = $this->db->query("SELECT id, klasifikasi as isi, 'siujk' as jenis FROM tl_siujk_klasifikasi where id='$idx' ");
		return $idsiujk = $query->row();
	}

	public function get_kbli_kategori()
	{
		$query = $this->db->query("SELECT id, concat(kode_kategori,' - ',kategori) as isi, 'siup' as jenis FROM tl_kbli_kategori");
		return $idsiup = $query->result();
	}

	public function get_kbli_kategori_detil($idx)
	{
		$query = $this->db->query("SELECT id, concat(kode_kategori,' - ',kategori) as isi, 'siup' as jenis FROM tl_kbli_kategori where id='$idx' ");
		return $idsiup = $query->result();
	}

	public function get_kbli_kategori_detilan($idx)
	{
		$query = $this->db->query("SELECT id, kategori as isi, 'siup' as jenis FROM tl_kbli_kategori where id='$idx' ");
		return $idsiup = $query->row();
	}

	public function get_user_tim()
	{
		$query = $this->db->query("SELECT id, nama as isi FROM tuser WHERE periode_thn = '2018' AND jabatan_tim = 'anggota' ");
		return $iduser = $query->result();
	}

	public function get_jenis_penyediaan()
	{
		$query = $this->db->query("SELECT id, uraian as isi FROM tl_penyediaan");
		return $idsiujk = $query->result();
	}

	public function get_tvd_all()
	{
		$query = $this->db->query("
		select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
		from information_schema.columns
		where table_schema = 'epi_vdl'
			and table_name = 'tvd_list'
			and COLUMN_NAME NOT IN ('id')
			and ORDINAL_POSITION > 0
		order by ORDINAL_POSITION asc
		");
		return $query->result();
	}

	public function get_tvd_list_siujk()
	{
		$query = $this->db->query("
		select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
		from information_schema.columns
		where table_schema = 'epi_vdl'
			and table_name = 'tvd_list'
			and COLUMN_NAME NOT IN ('id')
			and ORDINAL_POSITION > 45
			and ORDINAL_POSITION < 51
		order by ORDINAL_POSITION asc
		");
		return $query->result();
	}

	public function get_tvd_list_siu()
	{
		$query = $this->db->query("
		select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
		from information_schema.columns
		where table_schema = 'epi_vdl'
			and table_name = 'tvd_list'
			and COLUMN_NAME NOT IN ('id')
			and ORDINAL_POSITION > 51
		order by ORDINAL_POSITION asc
		");
		return $query->result();
	}

	public function get_tvd_list($id_vd)
	{
		$query = $this->db->query("SELECT * FROM tvd_list where id_vd = '$id_vd' GROUP BY id_vd ");
		return $query->row();
	}

	public function get_tvd_list_vendor($id_vd)
	{
		$query = $this->db->query("SELECT * FROM tvd_list where id_vd = '$id_vd' GROUP BY id_vd ");
		return $query->result();
	}

	public function get_list_pengadaan()
	{
		$query = $this->db->query("SELECT id, uraian as isi FROM tl_pengadaan");
		return $query->result();
	}

	public function get_list_user_bos()
	{
		$query = $this->db->query(" SELECT * FROM tuser where ket like '%manager%'  ");
		return $query->result();
	}

	public function get_tblacklist()
	{
		$query = $this->db->query("
		select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
		from information_schema.columns
		where table_schema = 'epi_vdl'
			and table_name = 'tblacklist'
			and COLUMN_NAME NOT IN ('id')
		order by ORDINAL_POSITION asc
		");
		return $query->result();
	}

	public function get_tvd_list_all($id_vd)
	{
		$query = $this->db->query("
									SELECT a.*, b.`nama` kec_nama, c.`nama` kab_nama, d.`nama` prov_nama
									FROM tvd_list as a
									JOIN tr_kec b ON a.`kec_vd` = b.`id_kec`
									JOIN tr_kab c ON a.`kab_vd` = c.`id_kab`
									JOIN tr_prov d ON a.`prov_vd` = d.`id_prov`
									where a.id_vd = '$id_vd' GROUP BY a.id_vd ");
		return $query->row();
	}

	public function get_tvd_list_all_1($id_vd)
	{
		$query = $this->db->query("
									SELECT a.*, a.`kec_vd` kec_nama, a.`kab_vd` kab_nama, a.`prov_vd` prov_nama
									FROM tvd_list as a
									where a.id_vd = '$id_vd' GROUP BY a.id_vd ");
		return $query->row();
	}

	#get_datatables_siup
	function get_datatables_siup($id_vd)
	{
		$this->_get_datatables_siup($id_vd);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_siup($id_vd='')
	{
		$this->db->select("id_vd, kode_siup, bidang_siup");
		$this->db->from("tvd_siup");
		$this->db->where("id_vd","$id_vd");
		$this->db->order_by("kode_siup");

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

	#get_datatables_siujk
	function get_datatables_siujk($id_vd)
	{
		$this->_get_datatables_siujk($id_vd);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_siujk($id_vd='')
	{
		$this->db->select("id_vd, kode_siujk, bidang_siujk, grade_sub_siujk");
		$this->db->from("tvd_siujk");
		$this->db->where("id_vd","$id_vd");
		$this->db->order_by("kode_siujk");

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

	#get_datatables_siu
	function get_datatables_siu($id_vd)
	{
		$this->_get_datatables_siu($id_vd);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_siu($id_vd='')
	{
		$this->db->select("id,id_vd, bidang_siu");
		$this->db->from("tvd_siu");
		$this->db->where("id_vd","$id_vd");
		$this->db->order_by("id");

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

}
