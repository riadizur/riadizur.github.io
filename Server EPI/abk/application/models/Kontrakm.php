<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kontrakm extends CI_Model {

  public function __construct()
	{
		parent::__construct();
	}

  function kontrak_pemberi()
  {
    $query = $this->db->query("SELECT nama, GROUP_CONCAT(kogol) as kogol FROM `tp_klp` GROUP BY nama");
    $dropdowns = $query->result();
    if(!$dropdowns){
      $finaldropdown[''] = " - Pilih - ";
      return $finaldropdown;
    }
    else{
      foreach ($dropdowns as $dropdown){
          $dropdownlist[$dropdown->kogol] = $dropdown->nama;
      }
      $finaldropdown = $dropdownlist;
      $finaldropdown[''] = " - Pilih - ";
      return $finaldropdown;
    }
  }

  public function get_kd_area()
  {
    $query = $this->db->query("SELECT concat(kd_prov,'-',kd_area) as id, concat(kd_area,'-',nm_area) as isi FROM v_kd_area ORDER BY kd_area ASC");
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

  public function get_prov()
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

  public function get_kab($id='')
  {
  	$query = $this->db->query("SELECT * FROM tr_kab WHERE id_prov = '$id' ");
  	return $kab = $query->result();
  }

	public function get_kec($id='')
	{
		$query = $this->db->query("SELECT * FROM tr_kec WHERE id_kab = '$id' ");
		return $kec = $query->result();
	}

  public function get_pt($id='')
  {
  	$query = $this->db->query("
		SELECT id_cust, nama_cust 
		FROM (
			SELECT ID_CUST AS id_cust, NAMA_CUST as nama_cust, kogol FROM vcustomer
			union all
			SELECT 'PERMOHONAN PELANGGAN' AS id_cust, 'PERMOHONAN PELANGGAN' as nama_cust, '9' as kogol
			union all
			SELECT 'PEMELIHARAAN TEKNIK & OPERASI' AS id_cust, 'PEMELIHARAAN' as nama_cust, '9' as kogol
		) INI
		WHERE kogol in ($id) 
	");
  	return $kec = $query->result();
  }
	
	public function get_agenda()
	{
		$query = $this->db->query("SELECT NO_AGENDA AS id, concat(NO_AGENDA,'-',NAMA_LANG) as ket from epi_dbx.tp_agenda where KD_MUT <> 'N' AND STATUS_MOHON > '4' AND NO_AGENDA <> 'NONAGENDA' ORDER BY ID DESC");
		return $kec = $query->result();
    }
	
	public function get_detil_agenda($no_agenda){
		$query = $this->db->query("SELECT * from epi_dbx.tp_agenda where no_agenda = '$no_agenda' ");
		return $kec = $query->row();
	}
	
	public function get_kontrak()
	{
		$query = $this->db->query("
		SELECT no_kontrak as id, concat(no_kontrak,' - ',nama_pekerjaan) as ket FROM `tkontrak`
		where no_kontrak_turunan is null and jns_pekerjaan not in ('pemeliharaan','pelayanan_pelanggan')
		");
		return $kec = $query->result();
    }
	
	public function get_divisi()
	{
		$query = $this->db->query("SELECT divisi AS id, divisi as ket from tr_divisi ");
		return $kec = $query->result();
    }
    
    public function get_agenda_list()
    {
        $query = $this->db->query("SELECT NO_AGENDA AS id, concat(NO_AGENDA,'-',NAMA_LANG) as ket from epi_dbx.tp_agenda where KD_MUT <> 'N' AND STATUS_MOHON <> '0' AND NO_AGENDA <> 'NONAGENDA' ORDER BY ID DESC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->id] = $dropdown->ket;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

    public function get_agenda_result($no_agenda)
	{        
        $query = $this->db->query("SELECT a.*,upper(b.nama) KEC_LANG,upper(c.nama) KAB_LANG,upper(d.nama) PROV_LANG,
                  DATE_FORMAT(a.TGL_BAYAR, '%Y-%m-%d') AS MULAI_KONTRAK
									FROM epi_dbx.tp_agenda a
									JOIN tr_kec b ON a.KEC_LANG=b.id_kec
									JOIN tr_kab c ON a.KOTA_LANG=c.id_kab
									JOIN tr_prov d ON a.PROV_LANG=d.id_prov
									WHERE no_agenda = '$no_agenda' LIMIT 1");
		return $agenda = $query->result();
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

	public function delete_by_id($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('cust');
	}

  function get_kolom_tkontrak()
	{
    $query = $this->db->query("
    select TABLE_SCHEMA, TABLE_NAME, COLUMN_NAME, ORDINAL_POSITION
    from information_schema.columns
    where table_schema = 'epi_abk'
      and table_name = 'tkontrak'
      and COLUMN_NAME NOT IN ('id')
    order by ORDINAL_POSITION asc
    ");
		return $query->result();
	}

  public function ambil_kab($id)
  {
  	$query = $this->db->query("SELECT * FROM tr_kab WHERE id_kab = '$id' ");
  	return $kab = $query->row();
  }

	public function ambil_kec($id)
  {
  	$query = $this->db->query("SELECT * FROM tr_kec WHERE id_kec = '$id' ");
  	return $kec = $query->row();
  }

  public function ambil_prov($id)
  {
  	$query = $this->db->query("SELECT * FROM tr_prov WHERE id_prov = '$id' ");
  	return $kec = $query->row();
  }

  public function ambil_klp($id)
  {
  	$query = $this->db->query("SELECT * FROM tp_klp WHERE kogol in ($id) ");
  	return $kec = $query->row();
  }

  public function ambil_pt($id)
  {
  	$query = $this->db->query("SELECT NAMA_CUST as nama FROM vcustomer WHERE id_cust = '$id' ");
  	return $kec = $query->row();
  }

  public function get_data_kontrak($id_kontrak)
  {
  	$query = $this->db->query("SELECT * FROM tkontrak WHERE id_kontrak = '$id_kontrak' ");
  	return $kec = $query->result();
  }

  public function rekapperkontrak_tahun()
  {
  	$query = $this->db->query("SELECT tahun_kontrak as tahun FROM tkontrak group by tahun_kontrak order by tahun_kontrak desc ");
  	return $query->result();
  }

    function get_tr_area_row($kd_area){
        $query = $this->db->query("SELECT * from epi_dbx.tr_area where kd_area = '$kd_area' ");
        return $query->row();
    }

    public function get_kode_area_list()
    {
        $query = $this->db->query("SELECT kd_area AS id, concat(kd_area,'-',nm_area) as ket from epi_dbx.tr_area ORDER BY kd_area ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->id] = $dropdown->ket;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

    function get_coa_seg_2_kontrak($kd_area){
        $coa_seg_2 = $this->db->query("SELECT KODE_AKUN from v_coa_seg_2 where KODE_AREA_EPI = '$kd_area' ")->row('KODE_AKUN');
        return $coa_seg_2;
    }

    function get_coa_seg_2_agenda($no_agenda){
        $kd_area = $this->db->query("SELECT KD_AREA from epi_dbx.tp_agenda where no_agenda = '$no_agenda' ")->row('KD_AREA');
        $coa_seg_2 = $this->db->query("SELECT KODE_AKUN from v_coa_seg_2 where KODE_AREA_EPI = '$kd_area' ")->row('KODE_AKUN');
        return $coa_seg_2;
    }

    public function get_coa_seg_3_list()
    {
        $query = $this->db->query("SELECT KODE_AKUN AS id, concat(KETERANGAN,' : ',LOKASI) as ket from v_coa_seg_3 ORDER BY KODE_AKUN ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->id] = $dropdown->ket;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }
    
    function get_coa_seg_6_agenda($no_agenda){
        $id_cust = $this->db->query("SELECT id_cust from epi_dbx.tp_agenda where no_agenda = '$no_agenda' ")->row('id_cust');
        $cek_seg_2 = $this->db->query("SELECT * FROM v_coa_seg_6 where ID_CUST = '$id_cust' LIMIT 1 ");
        if ($cek_seg_2->num_rows() > 0) {
            return $hasil = $cek_seg_2->row('KODE_PERUSAHAAN');
        } else {
            return $hasil = '999';
        }
    }

    function get_coa_seg_8_agenda($no_agenda){
        $get_id_cust = $this->db->query("SELECT id_cust from epi_dbx.tp_agenda where no_agenda = '$no_agenda' ")->row('id_cust');
        $inisial = substr($get_id_cust, 3,3);
        $coa_seg_8 = '33'.$inisial;
        return $coa_seg_8;
    }

    function get_id_cust($no_agenda){
        $id_cust = $this->db->query("SELECT id_cust from epi_dbx.tp_agenda where no_agenda = '$no_agenda' ")->row('id_cust');
        return $id_cust;
    }


}
?>
