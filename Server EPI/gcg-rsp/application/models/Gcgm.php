<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Gcgm extends CI_Model
{
	private $temp = array();
	function __construct()
	{
		parent::__construct();
	}

	public function waktu_sekarang()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		return $sekarang;
	}



	#--------------------------------------------

	public function tahun_berjalan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		$thn_sekarang = date('Y');
		return $thn_sekarang;
	}

	public function last_gcg_master_periode()
	{
		$query = $this->db->query("SELECT max(periode) periode from gcg_master_fu ");
		return $query->row('periode');
	}

	public function last_gcg_transaksi_fu()
	{
		$query = $this->db->query("SELECT max(kode_survey) kode from gcg_transaksi_fu ");
		return $query->row('kode');
	}

	public function last_gcg_surveyor_kode_survey()
	{
		$query = $this->db->query("SELECT max(kode_survey) kode_survey from gcg_surveyor ");
		return $query->row('kode_survey');
	}

	public function return_gcg_aspek_all()
	{
		$query = $this->db->get_where('gcg_master_aspek');
		return $query->result();
	}

	public function return_gcg_indikator_no_aspek($no_aspek)
	{
		$query = $this->db->get_where('gcg_master_indikator', array('no_aspek' => $no_aspek));
		return $query->result();
	}

	public function return_gcg_parameter_no_indikator($no_indikator)
	{
		$query = $this->db->get_where('gcg_master_parameter', array('no_indikator' => $no_indikator));
		return $query->result();
	}

	public function return_gcg_fu_lv1_id_parameter($id_parameter)
	{
		$query = $this->db->get_where('gcg_fu_lv1', array('id_parameter' => $id_parameter));
		return $query->result();
	}

	public function return_gcg_fu_lv2_id_fu($id_fu)
	{
		$query = $this->db->get_where('gcg_fu_lv2', array('id_fu' => $id_fu));
		return $query->result();
	}

	public function return_gcg_fu_lv3_id_sfu($id_sfu)
	{
		$query = $this->db->get_where('gcg_fu_lv3', array('id_sfu' => $id_sfu));
		return $query->result();
	}

	public function survey_gcg_aspek_all()
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu_aspek');
		return $query->result();
	}

	public function survey_gcg_indikator_no_aspek($no_aspek)
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu_indikator', array('no_aspek' => $no_aspek));
		return $query->result();
	}

	public function survey_gcg_parameter_no_indikator($no_indikator)
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu_parameter', array('no_indikator' => $no_indikator));
		return $query->result();
	}

	public function survey_gcg_fu_lv1_id_parameter($no_parameter)
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu_lv1', array('no_parameter' => $no_parameter));
		return $query->result();
	}

	public function survey_gcg_fu_lv2_id_fu($id_fu)
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu_lv2', array('id_fu' => $id_fu));
		return $query->result();
	}

	public function result_temp_gcg_transaksi_fu_kode_survey_kode_master($kode_survey, $kode_fu)
	{
		$query = $this->db->get_where('temp_gcg_transaksi_fu', array('kode_survey' => $kode_survey, 'kode_fu' => $kode_fu));
		return $query->result();
	}

	public function result_gcg_master_periode_kode($periode, $kode_fu)
	{
		$query = $this->db->get_where('gcg_master_fu', array('periode' => $periode, 'kode_fu' => $kode_fu));
		return $query->result();
	}

	public function row_gcg_tipe_doc_kode_doc($kode_doc, $perlu)
	{
		$query = $this->db->get_where('gcg_tipe_doc', array('kode_doc' => $kode_doc));
		return $query->row($perlu);
	}

	public function result_v_gcg_divisi_tahun($tahun)
	{
		$query = $this->db->get_where('v_gcg_divisi', array('tahun' => $tahun));
		return $query->result();
	}

	public function list_v_gcg_divisi()
	{
		$query = $this->db->query("SELECT kode as id, nama_divisi as isi FROM v_gcg_divisi order by id asc");
		$dropdowns = $query->result();
		if (!$dropdowns) {
			$finaldropdown[''] = " - Data tidak ada - ";
			return $finaldropdown;
		} else {
			foreach ($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id] = $dropdown->isi;
			}
			$finaldropdown = $dropdownlist;
			$finaldropdown[''] = " - Pilih - ";
			return $finaldropdown;
		}
	}

	public function list_gcg_master()
	{
		$query = $this->db->query("SELECT periode as id, periode as isi FROM gcg_master_fu group by periode order by periode desc");
		$dropdowns = $query->result();
		if (!$dropdowns) {
			$finaldropdown[''] = " - Data tidak ada - ";
			return $finaldropdown;
		} else {
			foreach ($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id] = $dropdown->isi;
			}
			$finaldropdown = $dropdownlist;
			$finaldropdown[''] = " - Pilih - ";
			return $finaldropdown;
		}
	}

	public function result_gcg_master_file_periode_kode($periode, $kode_fu, $tipe)
	{
		$query = $this->db->get_where('gcg_master_fu_file', array('periode' => $periode, 'kode_fu' => $kode_fu, 'tipe' => $tipe, 'status_file' => '1'));
		return $query->result();
	}

	public function num_rows_gcg_master_file_periode_kode($periode, $kode_fu, $tipe)
	{
		$query = $this->db->get_where('gcg_master_fu_file', array('periode' => $periode, 'kode_fu' => $kode_fu, 'tipe' => $tipe, 'status_file' => '1'));
		return $query->num_rows();
	}

	public function row_gcg_master_periode_kode($periode, $kode_fu, $perlu)
	{
		$query = $this->db->get_where('gcg_master_fu', array('periode' => $periode, 'kode_fu' => $kode_fu));
		return $query->row($perlu);
	}

	public function last_gcg_transaksi_kode_survey()
	{
		$query = $this->db->query("SELECT max(kode_survey) kode_survey from gcg_surveyor ");
		if (!empty($query->row('kode_survey'))) {
			# jika ada
			$kode_survey = $query->row('kode_survey');
			$kd_last = explode("_", $kode_survey);
			$kd_last[0] = (int) $kd_last[0];
			$urut = ($kd_last[1] * 1)+1;
			$kode_baru = $kd_last[0] . '_' . $urut;
		} else {
			# jika tidak ada
			$kode_baru = $this->tahun_berjalan() . '_1';
		}
		return $kode_baru;
	}
	public function selesai_survey(){
		$query = $this->db->query("SELECT count(kode_survey) kode_survey from gcg_surveyor where status_survey='0'");
		if($query->row('kode_survey')>0){
			return false;
		}else{
			return true;
		}
	}
	public function list_gcg_transaksi()
	{
		$query = $this->db->query("SELECT kode_survey as id, kode_survey as isi FROM gcg_surveyor group by kode_survey order by kode_survey desc");
		$dropdowns = $query->result();
		if (!$dropdowns) {
			$finaldropdown[''] = " - Data tidak ada - ";
			return $finaldropdown;
		} else {
			foreach ($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id] = $dropdown->isi;
			}
			$finaldropdown = $dropdownlist;
			$finaldropdown[''] = " - Pilih - ";
			return $finaldropdown;
		}
	}

	public function result_gcg_transaksi_tahun_list()
	{
		$query = $this->db->query("SELECT kode_survey as id, kode_survey as isi FROM gcg_surveyor group by kode_survey order by kode_survey desc ");
		return $query->result();
	}

	public function insert_gcg_transaksi_kode_survey($kode_survey)
	{
		$cs = explode('_', $kode_survey);
		$tahun = $cs[0];
		$q2 = $this->db->query("
				INSERT INTO gcg_transaksi_fu(tahun, kode_survey, periode_master, kode_fu, tingkatan_master, status_uji, hasil_survey)
				SELECT '$tahun', '$kode_survey', periode, kode_fu, tingkatan, status_uji, if(status_uji = 0,1,null)
				FROM gcg_master_fu 
				WHERE periode = (SELECT MAX(PERIODE) FROM gcg_master_fu WHERE LEFT(periode,4) = '$tahun')
				order by id asc;
		");

		$this->update_isi_temp($kode_survey);

		if ($q2 === true) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	public function result_gcg_transaksi_fu_kode_survey_kode_master($kode_survey, $kode_fu)
	{
		$query = $this->db->get_where('gcg_transaksi_fu', array('kode_survey' => $kode_survey, 'kode_fu' => $kode_fu));
		return $query->result();
	}

	public function result_gcg_transaksi_fu_pilihan_all()
	{
		$query = $this->db->get_where('gcg_transaksi_fu_pilihan');
		return $query->result();
	}

	public function result_gcg_transaksi_fu_kode_survey_belum_fu($kode_survey)
	{
		$query = $this->db->query("SELECT kode_fu kode, REPLACE(kode_fu,'.','-') kodex, REPLACE(kode_fu,'.','_') kodez ,REPLACE(SUBSTRING_INDEX(kode_fu,'.',3),'.','_')  heading FROM gcg_transaksi_fu where kode_survey = '$kode_survey' and hasil_survey is null ");
		return $query->result();
	}

	public function cek_gcg_transaksi_fu_kode_survey($kode_survey, $kolom)
	{
		$query = $this->db->query("SELECT 
			if( count(kode_survey) = sum( if(hasil_survey is null,0,1) ), 'SELESAI','BELUM' ) hasil,
			( count(kode_survey) - sum( if(hasil_survey is null,0,1) ) )  jumlah
			FROM `gcg_transaksi_fu` 
			where kode_survey = '$kode_survey' group by kode_survey
		");
		return $query->row($kolom);
	}

	public function result_v_gcg_transaksi_fu_parameter_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_parameter', array('kode_survey' => $kode_survey));
		return $query->result();
	}

	public function result_v_gcg_transaksi_fu_parameter_hasil_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_parameter_hasil', array('kode_survey' => $kode_survey));
		return $query->result();
	}

	public function result_v_gcg_transaksi_fu_indikator_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_indikator', array('kode_survey' => $kode_survey));
		return $query->result();
	}
	public function grafik_v_rekap_gcg_per_divisi()
	{
		$periode = $this->gcgm->last_gcg_master_periode();
		#$tahun = '2019';
		$hasil=array();
		$query = $this->db->query("SELECT 
			pic as labels,  
			jlh_dok as datat,
			jlh_dok_ada as datar
			FROM v_gcg_master_fu_divisi
			WHERE pic!='N/A' and pic!='ADM'
			");
		foreach ($query->result() as $data) {
			$hasil[] = $data;
		}
		return $hasil;
	}
	public function result_v_gcg_transaksi_fu_indikator_hasil_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_indikator_hasil', array('kode_survey' => $kode_survey));
		return $query->result();
	}

	public function result_v_gcg_transaksi_fu_aspek_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_aspek', array('kode_survey' => $kode_survey));
		return $query->result();
	}

	public function result_v_gcg_transaksi_fu_aspek_hasil_kode_survey($kode_survey)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_aspek_hasil', array('kode_survey' => $kode_survey));
		return $query->result();
	}

	public function cek_gcg_transaksi_aoi_kode_survey_kode_master($kode_survey, $kode_fu)
	{
		$query = $this->db->query("SELECT count(kode_fu) jumlah from gcg_transaksi_aoi where kode_survey = '$kode_survey' and kode_fu = '$kode_fu'");
		return $query->row('jumlah');
	}

	public function result_v_gcg_transaksi_fu_indikator_kode_survey_no_aspek($kode_survey, $no_aspek)
	{
		$query = $this->db->get_where('v_gcg_transaksi_fu_indikator', array('kode_survey' => $kode_survey, 'no_aspek' => $no_aspek));
		return $query->result();
	}
	public function result_gcg_status_dokumen($periode, $kode_divisi = '')
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT ('$periode') as periode, kode_fu,pertanyaan,
			CONCAT(kebutuhan,' ',(SELECT type_doc from gcg_tipe_doc where kode_doc=tipe_doc)) as kebutuhan_dokumen,
			doc_dibutuhkan_1 as dokumen_yang_dibutuhkan,
			(Select if(count(doc_file)=0,'Belum-Ada','Ada') from `gcg_master_fu_file` where periode='$periode' and tipe='Dokumen' and status_file='1' and kode_fu=gcg_master_fu.kode_fu) as status_dokumen,
			pic, status_uji,tipe_doc,catatan,kebutuhan,doc_dibutuhkan_2,warning
			FROM `gcg_master_fu`
			WHERE pic like '%$kode_divisi' and periode='$periode'
			and kebutuhan='Dokumen'
			"
		);
		return $query->result();
	}
	public function result_gcg_status_dokumen_kode($periode,$kode)
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT periode, kode_fu,pertanyaan,
			CONCAT(kebutuhan,' ',(SELECT type_doc from gcg_tipe_doc where kode_doc=tipe_doc)) as kebutuhan_dokumen,
			doc_dibutuhkan_1 as dokumen_yang_dibutuhkan,
			(Select if(count(doc_file)=0,'Belum-Ada','Ada') from `gcg_master_fu_file` where periode='$periode' and tipe='Dokumen' and status_file='1' and kode_fu=gcg_master_fu.kode_fu) as status_dokumen,
			pic, status_uji,tipe_doc,catatan,kebutuhan,doc_dibutuhkan_2,warning
			FROM `gcg_master_fu`
			WHERE kode_fu='$kode' and periode='$periode'
			and kebutuhan='Dokumen'
			"
		);
		return $query->result();
	}
	public function row_gcg_status_dokumen_kode($periode,$kode)
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT periode, kode_fu,pertanyaan,
			CONCAT(kebutuhan,' ',(SELECT type_doc from gcg_tipe_doc where kode_doc=tipe_doc)) as kebutuhan_dokumen,
			doc_dibutuhkan_1 as dokumen_yang_dibutuhkan,
			(Select if(count(doc_file)=0,'Belum-Ada','Ada') from `gcg_master_fu_file` where periode='$periode' and tipe='Dokumen' and status_file='1' and kode_fu=gcg_master_fu.kode_fu) as status_dokumen,
			pic, status_uji,tipe_doc,catatan,kebutuhan,doc_dibutuhkan_2,warning
			FROM `gcg_master_fu`
			WHERE kode_fu='$kode' and periode='$periode'
			and kebutuhan='Dokumen'
			"
		);
		return $query->row('status_dokumen');
	}
	public function result_gcg_status_uji($periode, $kode_divisi = '', $kode_fu = '')
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT ('$periode') as periode, kode_fu,pertanyaan,kebutuhan,
			CONCAT(kebutuhan,' ',(SELECT type_doc from gcg_tipe_doc where kode_doc=tipe_doc)) as kebutuhan_dokumen,
			doc_dibutuhkan_1 as dokumen_yang_dibutuhkan,
			if(status_uji='1','Diujikan','Tidak Diujikan') as status_dokumen,
			pic
			FROM `gcg_master_fu`
			WHERE kode_fu = '$kode_fu'
			"
		);
		return $query->result();
	}
	public function get_gcg_uraian_divisi($kode_divisi)
	{
		$query = $this->db->query(
			"
			SELECT nama_divisi
			FROM `master_org_divisi`
			WHERE kode = '$kode_divisi'
			"
		);
		return $query->row('nama_divisi');
	}
	public function get_doc_file($kode)
	{
		$query = $this->db->query(
			"
			SELECT doc_file
			FROM `gcg_master_fu_file`
			WHERE kode_fu = '$kode'
			"
		);
		return $query->row('doc_file');
	}
	public function get_nama_doc($kode)
	{
		$query = $this->db->query(
			"
			SELECT nama_doc
			FROM `gcg_master_fu_file`
			WHERE kode_fu = '$kode'
			"
		);
		return $query->row('nama_doc');
	}
	public function list_dropdown($nama_tabel, $data = [], $param, $adder = '')
	{
		if ($param == 'all') {
			$query = $this->db->query("SELECT $data[0] as id, $data[1] as uraian FROM $nama_tabel group by $data[0] order by $data[0] desc");
		} else {
			$query = $this->db->query("SELECT $data[0] as id, $data[1] as uraian FROM $nama_tabel where $param[0]=$param[1] group by $data[0] order by $data[0] desc");
		}
		$dropdowns = $query->result();
		if (!$dropdowns) {
			return $finaldropdown;
		} else {
			foreach ($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id] = $adder . $dropdown->uraian;
			}
			$finaldropdown = $dropdownlist;
			return $finaldropdown;
		}
	}

	public function list_dropdown_result($nama_tabel, $data = [], $param, $adder = '')
	{
		if ($param == 'all') {
			$query = $this->db->query("SELECT $data[0] as id, $data[1] as uraian FROM $nama_tabel group by $data[0] order by $data[0] desc");
		} else {
			$query = $this->db->query("SELECT $data[0] as id, $data[1] as uraian FROM $nama_tabel where $param[0]=$param[1] group by $data[0] order by $data[0] desc");
		}
		$dropdowns = $query->result();
		return $dropdowns;
	}

	public function list_status_uji()
	{
		$query = $this->db->query("SELECT kode as id, uraian FROM gcg_master_status_uji");
		$dropdowns = $query->result();
		if (!$dropdowns) {
			return $finaldropdown;
		} else {
			foreach ($dropdowns as $dropdown) {
				$dropdownlist[$dropdown->id] = $dropdown->uraian;
			}
			$finaldropdown = $dropdownlist;
			return $finaldropdown;
		}
	}

	public function result_gcg_master_gcg($filter)
	{
		$periode = $this->last_gcg_master_periode();
		switch ($filter) {
			case 'aspek':
				$query = $this->db->query(
					"SELECT
					no_aspek as kode,
					aspek_pengujian_indikator as uraian,
					status_uji 
					FROM gcg_master_aspek
					where periode = '$periode'
					"
				);
				break;
			case 'indikator':
				$query = $this->db->query(
					"SELECT 
					concat(no_aspek,'.',no_indikator) as kode,
					aspek_pengujian_atau_indikator as uraian,
					status_uji
					FROM gcg_master_indikator
					where periode = '$periode' "
				);
				break;
			case 'parameter':
				$query = $this->db->query(
					"SELECT 
					concat(no_aspek,'.',no_indikator,'.',no_parameter) as kode,
					aspek_pengujian_atau_indikator as uraian,
					status_uji
					FROM gcg_master_parameter
					where periode = '$periode'"
				);
				break;
			case 'fu':
				$query = $this->db->query(
					"SELECT 
					kode_fu as kode,
					pertanyaan as uraian,
					status_uji
					FROM gcg_master_fu
					where periode = '$periode'"
				);
				break;
		}
		return $query->result();
	}

	public function update_status_uji($parameter, $kode, $nilai)
	{
		$periode = $this->last_gcg_master_periode();
		if ($nilai == '1') {
			$not_nilai = ", hasil_survey = NULL ";
		} else {
			$not_nilai = ", hasil_survey = '1' ";
		}

		switch ($parameter) {
			case 'aspek':
				$data_fu = array();
				$data_fu_file = array();
				$data_transaksi = array();

				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$query = $this->db->query(
					"UPDATE gcg_master_aspek 
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek'
					"
				);
				$query = $this->db->query(
					"UPDATE gcg_master_indikator
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek'
					"
				);
				$query = $this->db->query(
					"UPDATE gcg_master_parameter
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek'
					"
				);

				/*
				$query = $this->db->query(
					"UPDATE gcg_master_fu
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek'
					"
				);
				$query = $this->db->query(
					"UPDATE gcg_transaksi_fu
					SET status_uji = '$nilai' $not_nilai
					where periode_master = '$periode' and kode_fu like '$kode%' and status_survey='0'
					"
				);
				*/

				if ($nilai == '0') {
					#tidak diujikan = 0
					$data_fu['kebutuhan'] = 'N/A';
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = 0;
					$data_fu['doc_dibutuhkan_1'] = 'N/A';
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = 'N/A';
					$data_fu['status_uji'] = 0;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_fu_file['status_file'] = 0;
					$data_fu_file['waktu_update'] = $this->waktu_sekarang();
					$this->db->update('gcg_master_fu_file', $data_fu_file, "periode = '$periode' and kode_fu like '$kode%' ");

					$data_transaksi['status_uji'] = 0;
					$data_transaksi['hasil_survey'] = 1;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				} else {
					#diujikan = 1
					$data_fu['kebutuhan'] = null;
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = null;
					$data_fu['doc_dibutuhkan_1'] = null;
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = null;
					$data_fu['status_uji'] = 1;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_transaksi['status_uji'] = 1;
					$data_transaksi['hasil_survey'] = 0;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				}
				$this->db->update('gcg_master_fu', $data_fu, "periode = '$periode' and kode_fu like '$kode%' ");
				$this->db->update('gcg_transaksi_fu', $data_transaksi, "periode_master = '$periode' and kode_fu like '$kode%' and status_survey='0'");

				break;
			case 'indikator':
				$data_fu = array();
				$data_fu_file = array();
				$data_transaksi = array();

				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$no_indikator = $row_data[1];
				$query = $this->db->query(
					"UPDATE gcg_master_indikator
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator'
					"
				);
				$query = $this->db->query(
					"UPDATE gcg_master_parameter
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator'
					"
				);
				/*
				$query = $this->db->query(
					"UPDATE gcg_master_fu
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator'
					"
				);
				$query = $this->db->query(
					"UPDATE gcg_transaksi_fu
					SET status_uji = '$nilai' $not_nilai
					where periode_master = '$periode' and kode_fu like '$kode%' and status_survey='0'
					"
				);
				*/


				if ($nilai == '0') {
					#tidak diujikan = 0
					$data_fu['kebutuhan'] = 'N/A';
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = 0;
					$data_fu['doc_dibutuhkan_1'] = 'N/A';
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = 'N/A';
					$data_fu['status_uji'] = 0;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_fu_file['status_file'] = 0;
					$data_fu_file['waktu_update'] = $this->waktu_sekarang();
					$this->db->update('gcg_master_fu_file', $data_fu_file, "periode = '$periode' and kode_fu like '$kode%' ");

					$data_transaksi['status_uji'] = 0;
					$data_transaksi['hasil_survey'] = 1;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				} else {
					#diujikan = 1
					$data_fu['kebutuhan'] = null;
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = null;
					$data_fu['doc_dibutuhkan_1'] = null;
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = null;
					$data_fu['status_uji'] = 1;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_transaksi['status_uji'] = 1;
					$data_transaksi['hasil_survey'] = 0;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				}
				$this->db->update('gcg_master_fu', $data_fu, "periode = '$periode' and kode_fu like '$kode%' ");
				$this->db->update('gcg_transaksi_fu', $data_transaksi, "periode_master = '$periode' and kode_fu like '$kode%' and status_survey='0'");

				break;
			case 'parameter':
				$data_fu = array();
				$data_fu_file = array();
				$data_transaksi = array();

				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$no_indikator = $row_data[1];
				$no_parameter = $row_data[2];

				$query = $this->db->query(
					"UPDATE gcg_master_parameter
					SET status_uji = '$nilai'
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator' and no_parameter = '$no_parameter'
					"
				);

				if ($nilai == '0') {
					#tidak diujikan = 0
					$data_fu['kebutuhan'] = 'N/A';
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = 0;
					$data_fu['doc_dibutuhkan_1'] = 'N/A';
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = 'N/A';
					$data_fu['status_uji'] = 0;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_fu_file['status_file'] = 0;
					$data_fu_file['waktu_update'] = $this->waktu_sekarang();
					$this->db->update('gcg_master_fu_file', $data_fu_file, "periode = '$periode' and kode_fu like '$kode%' ");

					$data_transaksi['status_uji'] = 0;
					$data_transaksi['hasil_survey'] = 1;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				} else {
					#diujikan = 1
					$data_fu['kebutuhan'] = null;
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = null;
					$data_fu['doc_dibutuhkan_1'] = null;
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = null;
					$data_fu['status_uji'] = 1;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_transaksi['status_uji'] = 1;
					$data_transaksi['hasil_survey'] = 0;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				}
				$this->db->update('gcg_master_fu', $data_fu, "periode = '$periode' and kode_fu like '$kode%' ");
				$this->db->update('gcg_transaksi_fu', $data_transaksi, "periode_master = '$periode' and kode_fu like '$kode%' and status_survey='0'");

				break;
			case 'fu':
				$data_fu = array();
				$data_fu_file = array();
				$data_transaksi = array();
				$where = array('periode' => $periode, 'kode_fu' => $kode);
				if ($nilai == '0') {
					#tidak diujikan = 0
					$data_fu['kebutuhan'] = 'N/A';
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = 0;
					$data_fu['doc_dibutuhkan_1'] = 'N/A';
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = 'N/A';
					$data_fu['status_uji'] = 0;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_fu_file['status_file'] = 0;
					$data_fu_file['waktu_update'] = $this->waktu_sekarang();
					$this->db->update('gcg_master_fu_file', $data_fu_file, $where);

					$data_transaksi['status_uji'] = 0;
					$data_transaksi['hasil_survey'] = 1;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				} else {
					#diujikan = 1
					$data_fu['kebutuhan'] = null;
					$data_fu['tipe_doc'] = null;
					$data_fu['perlu_doc'] = null;
					$data_fu['doc_dibutuhkan_1'] = null;
					$data_fu['doc_dibutuhkan_2'] = null;
					$data_fu['pic'] = null;
					$data_fu['status_uji'] = 1;
					$data_fu['waktu_update'] = $this->waktu_sekarang();

					$data_transaksi['status_uji'] = 1;
					$data_transaksi['hasil_survey'] = 0;
					$data_transaksi['waktu_update'] = $this->waktu_sekarang();
				}
				$this->db->update('gcg_master_fu', $data_fu, $where);
				$this->db->update('gcg_transaksi_fu', $data_transaksi, array('periode_master' => $periode, 'kode_fu' => $kode, 'status_survey' => '0'));
				#return $this->db->affected_rows();
				break;
		}
	}

	public function cek_na($parameter, $kode)
	{
		$periode = $this->last_gcg_master_periode();
		switch ($parameter) {
			case 'aspek':
				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$query = $this->db->query(
					"SELECT
					status_uji
					FROM gcg_master_aspek
					where periode = '$periode' and no_aspek = '$no_aspek'
					"
				);
				break;
			case 'indikator':
				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$no_indikator = $row_data[1];
				$query = $this->db->query(
					"SELECT 
					 status_uji
					FROM gcg_master_indikator
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator'
					"
				);
				break;
			case 'parameter':
				$row_data = explode('.', $kode);
				$no_aspek = $row_data[0];
				$no_indikator = $row_data[1];
				$no_parameter = $row_data[2];
				$query = $this->db->query(
					"SELECT 
					status_uji
					FROM gcg_master_parameter
					where periode = '$periode' and no_aspek = '$no_aspek' and no_indikator = '$no_indikator' and no_parameter = '$no_parameter'
					"
				);
				break;
		}
		return $query->row('status_uji');
	}

	public function result_gcg_transaksi_fu_kode_survey_belum_aspek($kode_survey)
	{
		$query = $this->db->query("SELECT 
			b.id kode_fu ,SUBSTRING_INDEX(a.kode_fu,'.',1) kode_fu, 
			( count(a.kode_fu) - sum( if(a.hasil_survey is null,0,1) ) ) jlh_fu
			from gcg_transaksi_fu as a 
			left join gcg_master_aspek as b on (a.periode_master = b.periode and SUBSTRING_INDEX(a.kode_fu,'.',1) = b.no_aspek)
			where a.kode_survey = '$kode_survey'
			group by SUBSTRING_INDEX(a.kode_fu,'.',1)
		");
		return $query->result();
	}

	public function result_gcg_transaksi_fu_kode_survey_belum_parameter($kode_survey)
	{
		$query = $this->db->query("SELECT 
			concat(b.no_aspek,'_',b.no_indikator,'_',b.no_parameter) kode_fu ,SUBSTRING_INDEX(a.kode_fu,'.',3) kode_fu,
			( count(a.kode_fu) - sum( if(a.hasil_survey is null,0,1) ) ) jlh_fu
			from gcg_transaksi_fu as a 
			left join gcg_master_parameter as b on (a.periode_master = b.periode and SUBSTRING_INDEX(a.kode_fu,'.',3) = concat(b.no_aspek,'.',b.no_indikator,'.',b.no_parameter))
			where a.kode_survey = '$kode_survey' 
			group by SUBSTRING_INDEX(a.kode_fu,'.',3)
		");
		return $query->result();
	}

	public function get_status_uji($kode_fu)
	{
		$periode = $this->last_gcg_master_periode();
		$query = $this->db->query("SELECT 
			status_uji
			from gcg_master_fu
			where periode='$periode' and kode_fu = '$kode_fu'
		");
		return $query->row('status_uji');
	}

	public function result_v_gcg_transaksi_aoi_kode_survey($kode_survey)
	{
		$query = $this->db->query("SELECT * from v_gcg_transaksi_aoi 
			where kode_survey = '$kode_survey' and status_aoi = '1' 
			order by id asc 
		");
		return $query->result();
	}

	public function result_v_gcg_transaksi_aoi_id($id)
	{
		$query = $this->db->query("SELECT * from v_gcg_transaksi_aoi 
			where id = '$id'
		");
		return $query->result();
	}

	public function row_v_gcg_transaksi_aoi_id($id, $perlu)
	{
		$query = $this->db->query("SELECT * from v_gcg_transaksi_aoi 
			where id = '$id'
		");
		return $query->row($perlu);
	}

	public function row_gcg_transaksi_fu_detil($kode_survey, $kode_fu, $perlu)
	{
		$query = $this->db->get_where('gcg_transaksi_fu', array('kode_survey' => $kode_survey, 'kode_fu' => $kode_fu));
		return $query->row($perlu);
	}

	public function result_gcg_transaksi_aoi_file_id($id)
	{
		$kode_survey = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_survey');
		$kode_fu = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_fu');
		$query = $this->db->query("SELECT * from gcg_transaksi_aoi_file 
			where kode_survey = '$kode_survey' and kode_fu = '$kode_fu' and status_file = '1'
		");
		return $query->result();
	}
	public function penetapan($periode, $kode_divisi = '')
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT ('$periode') as periode, kode_fu,pertanyaan,
			if(kebutuhan='' or kebutuhan is null,'kosong',kebutuhan) as kebutuhan_dokumen,
			if((tipe_doc='' or tipe_doc is null) and (kebutuhan='' or kebutuhan is null),'kosong','-') as tipe_dokumen,
			if((doc_dibutuhkan_1='' or doc_dibutuhkan_1 is null) and (kebutuhan='' or kebutuhan is null),'kosong','-') as dokumen_yang_dibutuhkan,
			if(status_uji='0','Tidak Di Ujikan','Diujikan') as status_uji,
			if((pic='' or pic is null) and (kebutuhan='' or kebutuhan is null),'kosong','-') as pic
			FROM `gcg_master_fu`
			WHERE status_uji='1' and (kebutuhan='' or kebutuhan is null or PIC='' or PIC is null or ((tipe_doc='' or tipe_doc is null or doc_dibutuhkan_1='' or doc_dibutuhkan_1 is null) and kebutuhan='dokumen'))
			"
		);
		return $query->result();
	}
	public function result_gcg_status_faktor_uji($periode, $kode_divisi = '')
	{
		//$query = $this->db->get_where('v_gcg_status_dokumen', array('pic' => $kode_divisi));
		$query = $this->db->query(
			"
			SELECT ('$periode') as periode, kode_fu,pertanyaan,
			if(kebutuhan='' or kebutuhan is null,'kosong','') as kebutuhan_dokumen,
			if(tipe_doc='' or tipe_doc is null,'kosong','') as tipe_dokumen,
			if(doc_dibutuhkan_1='' or doc_dibutuhkan_1 is null,'kosong','') as dokumen_yang_dibutuhkan,
			if(status_uji='0','Tidak Di Ujikan','Diujikan') as status_uji,
			if(pic='' or pic is null,'kosong','') as pic
			FROM `gcg_master_fu`
			WHERE status_uji='1' and (kebutuhan='' or kebutuhan is null)
			"
		);
		return $query->result();
	}

	public function result_v_gcg_master_fu_divisi()
	{
		$query = $this->db->query("SELECT * from v_gcg_master_fu_divisi ");
		return $query->result();
	}

	public function row_tabel($tabel, $where, $tampil)
	{
		$query = $this->db->get_where($tabel, $where);
		return $query->row($tampil);
	}
	public function result_tabel($tabel, $where=array())
	{
		$query = $this->db->get_where($tabel, $where);
		return $query->result();
	}

	public function result_v_gcg_transaksi_fu_aspek_hasil($tabel, $kode_survey, $kolom, $dicari)
	{
		$query = $this->db->query("SELECT replace('$dicari','.','_') kode, if(jlh_fu_terisi = jlh_fu,'ok',concat(jlh_fu_terisi,'/',jlh_fu)) hasil from $tabel where kode_survey = '$kode_survey' and $kolom = '$dicari' ");
		return $query->result();
	}

	public function update_gcg_transaksi_fu($data, $kode_survey, $kode_fu)
	{
		$this->db->update('gcg_transaksi_fu', $data, array("kode_survey" => $kode_survey, "kode_fu" => $kode_fu));
		$this->update_isi_temp($kode_survey);
		return true;
	}

	private function update_isi_temp($kode_survey)
	{
		$cas = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu_aspek where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cas > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu_aspek WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu_aspek select * from v_gcg_transaksi_fu_aspek where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu_aspek select * from v_gcg_transaksi_fu_aspek where kode_survey = '$kode_survey' ");
		}

		$cin = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu_indikator where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cin > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu_indikator WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu_indikator select * from v_gcg_transaksi_fu_indikator where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu_indikator select * from v_gcg_transaksi_fu_indikator where kode_survey = '$kode_survey' ");
		}

		$cpa = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu_parameter where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cpa > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu_parameter WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu_parameter select * from v_gcg_transaksi_fu_parameter where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu_parameter select * from v_gcg_transaksi_fu_parameter where kode_survey = '$kode_survey' ");
		}

		$cfu = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cfu > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu select * from v_gcg_transaksi_fu where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu select * from v_gcg_transaksi_fu where kode_survey = '$kode_survey' ");
		}

		$cf1 = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu_lv1 where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cf1 > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu_lv1 WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu_lv1 select * from v_gcg_transaksi_fu_lv1 where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu_lv1 select * from v_gcg_transaksi_fu_lv1 where kode_survey = '$kode_survey' ");
		}

		$cf2 = $this->db->query("SELECT count(kode_survey) jlh from temp_gcg_transaksi_fu_lv2 where kode_survey = '$kode_survey' ")->row('jlh');
		if ($cf2 > 0) {
			# hapus
			$this->db->query("DELETE FROM temp_gcg_transaksi_fu_lv2 WHERE kode_survey = '$kode_survey' ");
			$this->db->query("INSERT into temp_gcg_transaksi_fu_lv2 select * from v_gcg_transaksi_fu_lv2 where kode_survey = '$kode_survey' ");
		} else {
			# isi
			$this->db->query("INSERT into temp_gcg_transaksi_fu_lv2 select * from v_gcg_transaksi_fu_lv2 where kode_survey = '$kode_survey' ");
		}

		return true;
	}
	public function result_v_gcg_master_direktorat()
	{
		$query = $this->db->query("SELECT * from master_org_direktorat");
		return $query->result();
	}
	public function result_v_gcg_master_divisi()
	{
		$query = $this->db->query("SELECT * from master_org_divisi");
		return $query->result();
	}
	public function result_v_gcg_master_user()
	{
		$query = $this->db->query("SELECT 
		*, concat(job,' ', jabatan) as jabatan
		 from master_user");
		return $query->result();
	}

	public function insert($tabel, $data)
	{
		$this->db->insert($tabel, $data);
	}
	public function update($tabel, $data, $where)
	{
		$this->db->update($tabel, $data, $where);
	}
	public function delete($tabel, $where)
	{
		$this->db->delete($tabel, $where);
	}
	public function result($nama_tabel, $where)
	{
		$query = $this->db->get_where($nama_tabel, $where);
		return $query->result();
	}
	public function result_kolom($nama_tabel,$kolom, $where)
	{
		$query = $this->db->select($kolom)->from($nama_tabel)->where($where)->get();
		return $query->result();
	}
	public function row($nama_tabel, $where, $tampil)
	{
		$query = $this->db->get_where($nama_tabel, $where);
		return $query->row($tampil);
	}
	public function count($tabel,$where,$kolom){
		$query = $this->db->get_where($tabel,$where);
		return $query->num_rows();
	}
	public function sum($tabel,$kolom,$where){
		$query = $this->db->query("SELECT sum($kolom) as data from $tabel WHERE $where");
		return $query->row('data');
	}
	public function max($tabel,$kolom,$where){
		$query = $this->db->query("SELECT max($kolom) as max from $tabel WHERE $where");
		return $query->row('max');
	}
	public function next_id_new($tabel,$kolom, $where, $code_position, $index_position, $master_id){
		$query = $this->db->query("select if(max(if(left($kolom,$index_position)='$master_id',right($kolom,2),''))+1<10,
		concat('$master_id','0',max(if(left($kolom,3)='$master_id',right($kolom,2),''))+1),
		concat('$master_id',max(if(left($kolom,3)='$master_id',right($kolom,2),''))+1)) as $kolom
		from $tabel");
		return $query->row($kolom);
	}
	public function next_index($tabel,$kolom, $where, $code_position, $index_position, $master_id){
		$query = $this->db->where($where)->query("select max($code_position($kolom,$index_position)='$master_id')+1 as $kolom from $tabel");
		return $query->row($kolom);
	}
}
