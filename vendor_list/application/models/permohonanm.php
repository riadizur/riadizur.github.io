<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permohonanm extends CI_Model {

	var $column_order = array('ID_CUST','NAMA_CUST','ALAMAT_CUST','KOTA_CUST','PROV_CUST',null);
	var $column_search = array('ID_CUST','NAMA_CUST','ALAMAT_CUST');
	var $order = array('id' => 'desc');
	var $column_ordery = array('THBL_MOHON','JNS_TRANSAKSI','JML_MOHON','SUDAH_SURVEY','SUDAH_SIP','SUDAH_BAYAR','SUDAH_PK','SUDAH_PDL');
	var $column_searchy = array('JNS_TRANSAKSI','THBL_MOHON');
	var $ordery = array('ID' => 'desc');
	var $column_orderx = array('THBL_MOHON','NO_AGENDA','ID_CUST','NAMA_MOHON','NAMA_LANG','JNS_TRANSAKSI','STATUS_MOHON',null,null,null);
	var $column_searchx = array('NO_AGENDA','NAMA_MOHON','ID_CUST','NO_AGENDA','THBL_MOHON','a.STATUS_MOHON','JNS_TRANSAKSI');
	var $orderx = array('a.ID' => 'desc');
	var $column_orderz = array('NO_AGENDA','Tgl_Awal','Tgl_Bayar','Tgl_Mohon','Tgl_Bayar','Tgl_Nyala','Tgl_Bongkar');
	var $column_searchz = array('NO_AGENDA','NAMA_LANG');
	var $orderz = array('Tgl_Mohon' => 'desc');

	public function __construct()
	{
		parent::__construct();
	}

	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query()
	{
		$this->db->select('a.*,b.nama as nama_prov,c.nama as nama_kab');
		$this->db->from('dil_listrik_new a');
		$this->db->join('tr_prov b',"a.PROV_LANG = b.id_prov");
		$this->db->join('tr_kab c',"a.KOTA_LANG = c.id_kab");
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

	public function get_by_id($id)
	{
		$this->db->from('cust');
		$this->db->where('id_cust',$id);
		$query = $this->db->get();

		return $query->row();
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

	public function by_panel()
    {
        $query = $this->db->query("SELECT no_panel FROM tr_panel ORDER BY ID ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->no_panel] = $dropdown->no_panel;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_noagenda()
    {
        $query = $this->db->query("SELECT no_agenda FROM tp_agenda ORDER BY no_agenda ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->no_agenda] = $dropdown->no_agenda;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function get_chain_kab_mohon($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_kab WHERE id_prov = '$id' ");
		return $kab = $query->result();
    }

	public function get_chain_kec_mohon($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_kec WHERE id_kab = '$id' ");
		return $kec = $query->result();
    }

	public function get_chain_kab_lang($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_kab WHERE id_prov = '$id' ");
		return $kab = $query->result();
    }

	public function get_chain_kec_lang($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_kec WHERE id_kab = '$id' ");
		return $kec = $query->result();
    }

	public function get_chain_klmpkteg($id='')
    {
		$query = $this->db->query("SELECT CONCAT(LEFT(GROUP_TEG,2),URAIAN) INF, CONCAT(KD_TARIF,JENIS_TEG) IDX, KD_TARIF, GROUP_TEG, URAIAN,NILAI_DAYA, JENIS_TEG FROM tr_daya WHERE KD_TARIF='$id' GROUP BY GROUP_TEG,JENIS_TEG ORDER BY ID ");
		return $tarif = $query->result();
    }

	public function get_chain_tarif($id='')
    {
		$q  = $this->db->query("SELECT KLMPK_TARIF FROM tr_peruntukan where ID = '$id' ");
		foreach($q->result() as $r){
			$ret = $r->KLMPK_TARIF;
		}

		$query = $this->db->query("SELECT a.*,b.uraian URAI FROM tr_daya a
									CROSS JOIN tr_peruntukan b
									WHERE LEFT(a.KD_TARIF,1) = '$ret' GROUP BY a.KD_TARIF");
		return $tarif = $query->result();
    }

	public function get_chain_daya($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_daya WHERE  CONCAT(KD_TARIF,JENIS_TEG)= '$id' ");
		return $tarif = $query->result();
    }

	public function get_chain_dayas($id='')
    {
		$query = $this->db->query("SELECT * FROM tr_daya WHERE LEFT(KD_TARIF,1)='L' ");
		return $tarif = $query->result();
    }

	public function get_chain_jamnyala($id='')
    {
		$q  = $this->db->query("SELECT kd_jamnyala FROM tr_area where kd_area = '$id' ");
		foreach($q->result() as $r){
			$ret = $r->kd_jamnyala;
		}
		$query = $this->db->query("SELECT * FROM tr_jamnyala WHERE kd_jamnyala = '$ret' ");
		return $jamnyala = $query->result();
    }

	public function get_tarif($kd_tarif='')
    {
		$query = $this->db->query("SELECT * FROM tr_tarif WHERE kd_tarif = '$kd_tarif'");
		return $tarif = $query->result();
    }

	public function get_daya($kd_tarif='')
    {
		$query = $this->db->query("SELECT KD_TARIF,NILAI_DAYA FROM tr_daya WHERE kd_tarif = '$kd_tarif'");
		return $daya = $query->result();
    }

	public function get_rplwbps($kd_tarif='')
    {
		$query = $this->db->query("SELECT RP_LWBP FROM tr_tarif WHERE LEFT(kd_tarif,1) = 'L' AND THBLREK = (SELECT MAX(THBLREK) FROM tr_tarif )");
		return $rplwbps = $query->result();
    }

	public function get_peruntukan($id='')
    {
		$query = $this->db->query("SELECT KLMPK_TARIF FROM tr_peruntukan WHERE ID = '$id'");
		return $peruntukan = $query->result();
    }

	public function get_jamnyala($kd_jamnyala='')
    {
		$query = $this->db->query("SELECT nilai_jamnyala FROM tr_jamnyala WHERE kd_jamnyala = '$kd_jamnyala'");
		return $jamnyala = $query->result();
    }

	public function get_cust($idcari='')
    {
		$query = $this->db->query("SELECT a.*,b.nama_ujl,c.nama KECCUST,d.nama KABCUST,e.nama PROVCUST
									FROM cust a
									JOIN tr_ujl b ON a.KD_UJL=b.kd_ujl
									JOIN tr_kec c ON a.`KEC_CUST`=c.`id_kec`
									JOIN tr_kab d ON a.`KOTA_CUST`=d.`id_kab`
									JOIN tr_prov e ON a.`PROV_CUST`=e.`id_prov`
									WHERE nama_cust = '$idcari' OR id_cust = '$idcari' LIMIT 1");
		return $agenda = $query->result();
    }
	
	public function get_melanjutkan($idcari='')
    {
		$query = $this->db->query("SELECT a.*,y.*,b.nama_ujl,c.nama KECCUST,d.nama KABCUST,e.nama PROVCUST
									FROM tp_agenda a
									JOIN cust y ON a.ID_CUST=y.ID_CUST 
									JOIN tr_ujl b ON y.KD_UJL=b.kd_ujl
									JOIN tr_kec c ON y.KEC_CUST=c.id_kec
									JOIN tr_kab d ON y.KOTA_CUST=d.id_kab
									JOIN tr_prov e ON y.PROV_CUST=e.id_prov
									WHERE no_agenda = '$idcari' LIMIT 1");
		return $agenda = $query->result();
    }

	public function get_cl($idcari='')
    {
		$query = $this->db->query("SELECT a.*,b.*,d.*,e.*, i.nama KECCUST, j.`nama` KABCUST, k.`nama` PROVCUST
									FROM dil_listrik_ref a
									JOIN cust b ON a.id_cust=b.id_cust
									JOIN tr_ujl d ON b.KD_UJL=d.kd_ujl
									JOIN master_rekening e ON a.`ID_LANG`=e.`ID_LANG`
									JOIN tr_kec i ON b.`KEC_CUST` = i.`id_kec`
									JOIN tr_kab j ON b.`KOTA_CUST` = j.`id_kab`
									JOIN tr_prov k ON b.`PROV_CUST` = k.`id_prov`
									WHERE a.id_lang='$idcari' AND e.THBLREK = (SELECT MAX(THBLREK) FROM master_rekening) ");
		return $all = $query->result();
    }

	public function get_cll($idcari='')
    {
		$query = $this->db->query("SELECT i.id_kec IDKECLANG, i.nama KECLANG, j.id_kab IDKABLANG, j.`nama` KABLANG, k.id_prov IDPROVLANG, k.`nama` PROVLANG
									FROM dil_listrik_ref a
									JOIN tr_kec i ON a.`KEC_LANG` = i.`id_kec`
									JOIN tr_kab j ON a.`KOTA_LANG` = j.`id_kab`
									JOIN tr_prov k ON a.`PROV_LANG` = k.`id_prov`
									WHERE a.id_lang='$idcari' ");
		return $all = $query->result();
    }

	public function getm($idcari='')
    {
		$query = $this->db->query("SELECT STAND_AKHIR_LWBP, STAND_AKHIR_WBP, STAND_AKHIR_KVARH FROM MASTER_REKENING WHERE ID_LANG = '$idcari' ");
		return $all = $query->result();
    }

	public function get_pdl($idcari='')
    {
		$query = $this->db->query("SELECT a.*, b.nama KECLANG, c.nama KABLANG, d.nama PROVLANG
									FROM tp_agenda a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE no_agenda = '$idcari'  ");
		return $all = $query->result();
    }

	public function get_pdl_nonmohon($idcari='')
    {
		$query = $this->db->query("SELECT a.*,b.id_kec IDKECLANG, b.nama KECLANG,c.id_kab IDKABLANG, c.nama KABLANG, d.id_prov IDPROVLANG, d.nama PROVLANG
									FROM dil_listrik_ref a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE id_lang = '$idcari'  ");
		return $all = $query->result();
    }
	
	public function get_nopdl_nonmohon($idcari='',$idcari2='')
    {
		$query = $this->db->query("SELECT NO_PDL
									FROM tp_agenda 
									WHERE no_agenda ='$idcari' and id_lang = '$idcari2' ");
		return $all = $query->result();
    }

	public function by_jns_transaksi()
    {
        $query = $this->db->query("SELECT jns_transaksi FROM tr_jns_transaksi");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->jns_transaksi] = $dropdown->jns_transaksi;
            }
            $finaldropdown = $dropdownlist;
						$finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }
	
	public function by_jns_transaksi_nonmohon()
    {
        $query = $this->db->query("SELECT jns_transaksi FROM tr_jns_transaksi where id not in ('1','2','3','4','5')");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->jns_transaksi] = $dropdown->jns_transaksi;
            }
            $finaldropdown = $dropdownlist;
						$finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function get_angs($noagd='',$idlang='')
    {
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));

		$query = $this->db->query("SELECT * FROM tp_angsuran WHERE (no_agenda ='$noagd' OR ID_LANG = '$idlang') AND THBLREK = '$plussatu'  ");
		return $all = $query->result();
    }

	public function get_angs_nonmohon($idlang='')
    {
		$q = "SELECT LEFT(THBLREK,4) TH, RIGHT(THBLREK,2) BLN FROM DIL_LISTRIK_REF LIMIT 1";
					$hasil = $this->db->query($q);
					foreach ($hasil->result() as $r)
					{
						$TH		= $r->TH;
						$BLN	= $r->BLN;
					}
		$plussatu = date("Ym", mktime(0,0,0,$BLN+1, '20', $TH));

		$query = $this->db->query("SELECT * FROM tp_angsuran WHERE (no_agenda ='$noagd' OR ID_LANG = '$idlang') AND THBLREK = '$plussatu'  ");
		return $all = $query->result();
    }

	public function get_langganan($idcari='')
    {
		$query = $this->db->query("SELECT c.id_cust ID_CUST, c.no_agenda NO_AGENDA,c.no_reg NO_REG,a.kd_wilayah KD_WILAYAH,a.kd_area KD_AREA,c.kd_bisnis KD_BISNIS,c.nama_lang NAMA_LANG,
									c.alamat_lang ALAMAT_LANG,c.kec_lang KEC_LANG,c.kota_lang KOTA_LANG,c.prov_lang PROV_LANG,c.kdpos_lang KDPOS_LANG,
									b.nama_cust NAMA_CUST,b.alamat_cust ALAMAT_CUST,b.kec_cust KEC_CUST,b.kota_cust KOTA_CUST,b.prov_cust PROV_CUST,b.kdpos_cust KDPOS_CUST
									FROM dil_listrik_ref a
									JOIN cust b ON a.id_cust=b.id_cust
									JOIN tp_agenda c ON a.id_cust=b.id_cust and a.id_lang=c.id_lang
									WHERE a.id_lang='$idcari' OR c.no_agenda='$idcari' ");
		return $langganan = $query->result();
    }

	public function get_agenda($idcari='')
    {
		$query = $this->db->query("SELECT a.*, b.nama KECMOHON, c.nama KABMOHON, d.`nama` PROVMOHON
									FROM tp_agenda a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE no_agenda='$idcari' ");
		return $agenda = $query->result();
    }

	public function get_agendal($idcari='')
    {
		$query = $this->db->query("SELECT b.`nama` KECLANG, c.`nama` KOTALANG, d.`nama` PROVLANG
									FROM tp_agenda a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE a.no_agenda='$idcari' ");
		return $agenda = $query->result();
    }

	public function get_agendasurvey($idcari='')
    {
		$query = $this->db->query("SELECT a.*, b.`RP_LWBP`,MAX(b.`THBLREK`) THBLREK,c.bsr_bk NILAI_BK, d.`nama` KECMOHON, e.`nama` KOTAMOHON, f.`nama` PROVMOHON
								FROM tp_agenda a
								JOIN tr_tarif b ON a.`TARIF_BARU`= b.KD_TARIF
								JOIN tr_bk c ON a.KD_BK = c.kd_bk
								JOIN tr_kec d ON a.`KEC_MOHON` = d.`id_kec`
								JOIN tr_kab e ON a.`KOTA_MOHON` = e.`id_kab`
								JOIN tr_prov f ON a.`PROV_MOHON` = f.`id_prov`
								WHERE a.no_agenda='$idcari' ");
		return $agenda = $query->result();
    }

	public function get_agendaps($idcari='')
    {
		$query = $this->db->query("SELECT * FROM tp_agenda WHERE no_agenda='$idcari' ");
		return $agenda = $query->result();
    }

	public function get_sementara($idcari='')
    {
		$query = $this->db->query("SELECT a.*,c.nama KECCUST,d.nama KOTACUST,e.nama PROVCUST, f.*
									FROM tp_agenda a
									JOIN cust f ON a.ID_CUST = f.ID_CUST
									JOIN tr_kec c ON f.`KEC_CUST`=c.`id_kec`
									JOIN tr_kab d ON f.`KOTA_CUST`=d.`id_kab`
									JOIN tr_prov e ON f.`PROV_CUST`=e.`id_prov`
									WHERE a.nama_mohon = '$idcari' OR a.id_cust = '$idcari' LIMIT 1");
		return $agenda = $query->result();
    }

	public function get_sementaral($idcari='')
    {
		$query = $this->db->query("SELECT c.nama KECLANG,d.nama KOTALANG,e.nama PROVLANG
									FROM tp_agenda a
									JOIN tr_kec c ON a.`KEC_LANG`=c.`id_kec`
									JOIN tr_kab d ON a.`KOTA_LANG`=d.`id_kab`
									JOIN tr_prov e ON a.`PROV_LANG`=e.`id_prov`
									WHERE a.nama_mohon = '$idcari' OR a.id_cust = '$idcari' LIMIT 1");
		return $agenda = $query->result();
    }
	
	public function by_perpanjangan()
    {
        $query = $this->db->query("SELECT * FROM tp_agenda WHERE JNS_TRANSAKSI = 'PENERANGAN SEMENTARA' ORDER BY ID DESC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->NO_AGENDA] = $dropdown->NO_AGENDA ."	||	". $dropdown->NAMA_MOHON;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function get_janji($idcaria='',$idcarib='')
    {
		if($idcaria != '0' AND $idcarib == '0'){
			$query = $this->db->query("SELECT a.*,c.nama KECCUST,d.nama KOTACUST,e.nama PROVCUST, f.*, IF(DAYA_BARU < 200000,'TIPIS','TEBAL') rpt
									FROM tp_agenda a
									JOIN cust f ON a.ID_CUST = f.ID_CUST
									JOIN tr_kec c ON f.`KEC_CUST`=c.`id_kec`
									JOIN tr_kab d ON f.`KOTA_CUST`=d.`id_kab`
									JOIN tr_prov e ON f.`PROV_CUST`=e.`id_prov`
									WHERE a.no_agenda = '$idcaria' LIMIT 1");
		}elseif($idcaria == '0' AND $idcarib != '0'){
			$query = $this->db->query("SELECT a.*,c.nama KECCUST,d.nama KOTACUST,e.nama PROVCUST, f.*, IF(DAYA < 200000,'TIPIS','TEBAL') rpt
									FROM dil_listrik_ref a
									JOIN cust f ON a.ID_CUST = f.ID_CUST
									JOIN tr_kec c ON f.`KEC_CUST`=c.`id_kec`
									JOIN tr_kab d ON f.`KOTA_CUST`=d.`id_kab`
									JOIN tr_prov e ON f.`PROV_CUST`=e.`id_prov`
									WHERE a.id_lang = '$idcarib' LIMIT 1");
		}else{
			$query = $this->db->query("SELECT a.*,c.nama KECCUST,d.nama KOTACUST,e.nama PROVCUST, f.*, IF(DAYA_BARU < 200000,'TIPIS','TEBAL') rpt
									FROM tp_agenda a
									JOIN cust f ON a.ID_CUST = f.ID_CUST
									JOIN tr_kec c ON f.`KEC_CUST`=c.`id_kec`
									JOIN tr_kab d ON f.`KOTA_CUST`=d.`id_kab`
									JOIN tr_prov e ON f.`PROV_CUST`=e.`id_prov`
									WHERE a.no_agenda = '$idcaria' OR a.id_lang = '$idcarib' LIMIT 1");
		}
		
		return $agenda = $query->result();
    }

	public function get_dil($idcari='')
    {
		$query = $this->db->query("SELECT a.*, b.nama KECMOHON, c.nama KABMOHON, d.`nama` PROVMOHON
									FROM dil_listrik_ref a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE id_lang='$idcari' ");
		return $agenda = $query->result();
    }

	public function get_otoagenda()
    {
		$q = $this->db->query("SELECT MAX(SUBSTRING(no_agenda,9,2)) TAHUN FROM tp_agenda WHERE no_agenda <> 'NONAGENDA'");
		foreach($q->result() as $r){
			$tahun = $r->TAHUN;
		}

		$query = $this->db->query("SELECT LPAD(MAX(SUBSTRING(no_agenda,15,4))+1,4,'0000') AS no_agenda FROM
									(SELECT no_agenda FROM tp_agenda
									UNION ALL
									SELECT no_agenda FROM tp_agenda) a
									WHERE SUBSTRING(no_agenda,9,2) = '$tahun'
									ORDER BY RIGHT(no_agenda,4)");
		return $agenda = $query->result();
    }

	public function get_otopdl()
  {
		$query = $this->db->query("SELECT LPAD(MAX(RIGHT(NO_PDL,4))+1,4,'0000') AS NO_PDL
									FROM TP_AGENDA" );
		return $agenda = $query->result();
  }

	public function get_otosipb()
    {
		$thn = date('y');
		$bln = date('n');
		$tgl = date('j');
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		}

		return $agenda = $query->result();
    }

	public function get_ppj($trf='',$prv='')
    {
		$query = $this->db->query("SELECT * FROM tr_ppj WHERE KD_TARIF like '%$trf%' AND PROV = '$prv' ");
		return $ppj = $query->result();
    }

	public function get_jabatan($id='')
    {
		$query = $this->db->query("SELECT nama,jabatan FROM tr_jabatan WHERE ID = '$id' ");
		return $kab = $query->result();
    }

	public function get_datapanel($panel='')
    {
		$query = $this->db->query("SELECT * FROM tr_panel WHERE no_panel = '$panel'");
		return $panel = $query->result();
    }

	public function get_nama_pejabat($kondisi)
    {
        $query = $this->db->query("SELECT * FROM tr_jabatan $kondisi ORDER BY ID ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->ID] = $dropdown->NAMA;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_area()
    {
        $query = $this->db->query("SELECT * FROM tr_area ORDER BY kd_area ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->kd_area] = $dropdown->nm_area;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_bisnis()
    {
        $query = $this->db->query("SELECT * FROM tr_bisnis ORDER BY kd_bisnis ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->kd_bisnis] = $dropdown->wilayah;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_tarif()
    {
        $query = $this->db->query("SELECT * FROM tr_tarif ORDER BY kd_tarif ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->KD_TARIF] = $dropdown->KD_TARIF." # ".$dropdown->BTS_DAYA;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_tarifs()
    {
        $query = $this->db->query("SELECT * FROM tr_tarif WHERE LEFT(kd_tarif,1) = 'L' AND THBLREK = (SELECT MAX(THBLREK) FROM tr_tarif ) ");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->KD_TARIF] = $dropdown->KD_TARIF." # ".$dropdown->BTS_DAYA;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_dayas()
    {
        $query = $this->db->query("SELECT * FROM tr_daya WHERE KD_TARIF = 'L' and NILAI_DAYA > 2200 ");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->NILAI_DAYA] = $dropdown->NILAI_DAYA;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_peruntukan()
    {
        $query = $this->db->query("SELECT * FROM tr_peruntukan ORDER BY ID ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->ID] = $dropdown->URAIAN;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
    }

	public function by_jamnyala()
    {
        $query = $this->db->query("SELECT * FROM tr_jamnyala ORDER BY kd_jamnyala ASC");
        $dropdowns = $query->result();
        if(! $dropdowns){
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
        else{
            foreach ($dropdowns as $dropdown){
                $dropdownlist[$dropdown->kd_jamnyala] = $dropdown->uraian;
            }
            $finaldropdown = $dropdownlist;
            $finaldropdown[''] = " - Pilih - ";
            return $finaldropdown;
        }
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

	#MENU MONITORING
	public function rekapmohon_list()
    {
        $query = $this->db->query("SELECT a.THBL_MOHON,IF(a.JNS_TRANSAKSI='PEMBERHENTIAN','BONGKAR RAMPUNG',a.JNS_TRANSAKSI) JNS_TRANSAKSI, SUM(a.JML_MOHON) JML_MOHON, SUM(a.SUDAH_SURVEY) SUDAH_SURVEY, SUM(a.SUDAH_SIP) SUDAH_SIP,  SUM(a.SUDAH_BAYAR) SUDAH_BAYAR,  SUM(a.SUDAH_PK) SUDAH_PK,  SUM(a.SUDAH_PDL) SUDAH_PDL, SUM(a.BATAL) BATAL
									FROM(
									SELECT THBL_MOHON ,JNS_TRANSAKSI, COUNT(NO_AGENDA) JML_MOHON,'0' SUDAH_SURVEY, '0' SUDAH_SIP, '0' SUDAH_BAYAR, '0' SUDAH_PK, '0' SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE NO_AGENDA != '0' 
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON, JNS_TRANSAKSI, '0' JML_MOHON,COUNT(TGL_ENTRI_SURVEY) SUDAH_SURVEY, '0' SUDAH_SIP, '0' SUDAH_BAYAR, '0' SUDAH_PK, '0' SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE TGL_ENTRI_SURVEY != '0000-00-00 00:00:00' AND STATUS_MOHON != '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON ,JNS_TRANSAKSI, '0' JML_MOHON,'0' SUDAH_SURVEY, COUNT(TGL_CETAKSIP) SUDAH_SIP, '0' SUDAH_BAYAR, '0' SUDAH_PK, '0' SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE TGL_CETAKSIP != '0000-00-00 00:00:00' AND STATUS_MOHON != '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON ,JNS_TRANSAKSI, '0' JML_MOHON,'0' SUDAH_SURVEY, '0' SUDAH_SIP, COUNT(TGL_BAYAR) SUDAH_BAYAR, '0' SUDAH_PK, '0' SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE TGL_BAYAR != '0000-00-00 00:00:00' AND STATUS_MOHON != '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON ,JNS_TRANSAKSI, '0' JML_MOHON,'0' SUDAH_SURVEY, '0' SUDAH_SIP, '0' SUDAH_BAYAR, COUNT(TGL_CTK_PK) SUDAH_PK, '0' SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE TGL_CTK_PK != '0000-00-00 00:00:00' AND STATUS_MOHON != '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON ,JNS_TRANSAKSI, '0' JML_MOHON,'0' SUDAH_SURVEY, '0' SUDAH_SIP, '0' SUDAH_BAYAR, '0' SUDAH_PK, COUNT(TGL_PDL) SUDAH_PDL, '0' BATAL
									FROM TP_AGENDA
									WHERE TGL_PDL != '0000-00-00 00:00:00' AND STATUS_MOHON != '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									UNION ALL
									SELECT THBL_MOHON ,JNS_TRANSAKSI, '0' JML_MOHON,'0' SUDAH_SURVEY, '0' SUDAH_SIP, '0' SUDAH_BAYAR, '0' SUDAH_PK, '0' SUDAH_PDL, COUNT(STATUS_MOHON) BATAL
									FROM TP_AGENDA
									WHERE STATUS_MOHON = '0'
									GROUP BY THBL_MOHON, JNS_TRANSAKSI
									) a
									GROUP BY a.THBL_MOHON,a.JNS_TRANSAKSI
									ORDER BY THBL_MOHON DESC");

        return $query->result_array();
	}

	#SURVEY
	function get_datatables_detsurvey()
	{
		$this->_get_datatables_detsurvey();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detsurvey()
	{
		$this->db->select("THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , date(TGL_CTK_SURVEY) TGL_CTK_SURVEY, date(TGL_MOHON) TGL_MOHON");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where("a.NO_AGENDA <> 'NONAGENDA' AND a.STATUS_MOHON < '3' AND  a.STATUS_MOHON <> '0' ");
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

	function count_filtered_detsurvey()
	{
		$this->_get_datatables_detsurvey();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detsurvey()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}

	#SIP
	function get_datatables_detsip()
	{
		$this->_get_datatables_detsip();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detsip()
	{
		$this->db->select("THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , date(TGL_ENTRI_SURVEY) TGL_ENTRI_SURVEY");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where("a.STATUS_MOHON = '3' AND TGL_CETAKSIP = '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0'");
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

	function count_filtered_detsip()
	{
		$this->_get_datatables_detsip();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detsip()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}

	#BAYAR
	function get_datatables_detbayar()
	{
		$this->_get_datatables_detbayar();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detbayar()
	{
		$this->db->select("THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CETAKSIP) TGL_CETAKSIP, TOTAL_BIAYA");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where("a.STATUS_MOHON = '4' AND TGL_BAYAR = '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0'");
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

	function count_filtered_detbayar()
	{
		$this->_get_datatables_detbayar();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detbayar()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}

	#PK
	function get_datatables_detpk()
	{
		$this->_get_datatables_detpk();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detpk()
	{
		$this->db->select("THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_BAYAR) TGL_BAYAR,
								CASE
								   WHEN POLA_PEMBAYARAN='0' THEN 'NORMAL' WHEN POLA_PEMBAYARAN='1' THEN 'REK PERTAMA' WHEN POLA_PEMBAYARAN='2' THEN 'LANGGANAN LAIN' END POLA ");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where("a.STATUS_MOHON = '5' AND TGL_CTK_PK = '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0'");
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

	function count_filtered_detpk()
	{
		$this->_get_datatables_detpk();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detpk()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}

	#PDL
	function get_datatables_detpdl()
	{
		$this->_get_datatables_detpdl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detpdl()
	{
		$this->db->select("THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CTK_PK) TGL_CTK_PK");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where("a.STATUS_MOHON = '6' AND TGL_PDL = '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0'");
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

	function count_filtered_detpdl()
	{
		$this->_get_datatables_detpdl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detpdl()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}


	#PDL SUDAH
	function get_datatables_detsudahpdl()
	{
		$this->_get_datatables_detsudahpdl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detsudahpdl()
	{
		$this->db->select("THBL_MOHON,THBLMUT,NO_AGENDA,ID_CUST,NAMA_MOHON,ID_LANG,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_PDL) TGL_PDL, NO_PDL");
		$this->db->from("TP_AGENDA a");
		$this->db->join("TR_STATUSMOHON b","a.STATUS_MOHON=b.ID");
		$this->db->where(" TGL_PDL != '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0' AND a.STATUS_MOHON='8' ");
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

	function count_filtered_detsudahpdl()
	{
		$this->_get_datatables_detsudahpdl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detsudahpdl()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}
	
	#REKAP PDL SUDAH
	function get_datatables_rekapsudahpdl()
	{
		$this->_get_datatables_rekapsudahpdl();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_rekapsudahpdl()
	{
		$this->db->select("a.THBL_MOHON,a.THBLMUT,a.JNS_TRANSAKSI,COUNT(a.NO_AGENDA) JML ");
		$this->db->from("TP_AGENDA a");
		$this->db->where(" a.TGL_PDL != '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0' AND a.STATUS_MOHON='8' ");
		$this->db->group_by("a.THBL_MOHON,a.THBLMUT,a.JNS_TRANSAKSI");
		$this->db->order_by("a.THBL_MOHON DESC");
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

	function count_filtered_rekapsudahpdl()
	{
		$this->_get_datatables_rekapsudahpdl();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_rekapsudahpdl()
	{
		$this->db->select("a.THBL_MOHON,a.THBLMUT,a.JNS_TRANSAKSI,COUNT(a.NO_AGENDA) JML ");
		$this->db->from("TP_AGENDA a");
		$this->db->where(" a.TGL_PDL != '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0' AND a.STATUS_MOHON='8' ");
		$this->db->group_by("a.THBL_MOHON,a.THBLMUT,a.JNS_TRANSAKSI");
		$this->db->order_by("a.THBL_MOHON DESC");
		return $this->db->count_all_results();
	}

	function format_uang($val=0,$digit=0,$koma=".",$pemisah=","){
		if($val<0){
			$val	= $val*-1;
			return	"(".number_format($val,$digit,$koma,$pemisah).")";
		}else{
			return number_format($val,$digit,$koma,$pemisah);
		}
	}

	#DET PS
	function get_datatables_detps()
	{
		$this->_get_datatables_detps();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_detps()
	{
		$this->db->from("v_mon_ps");
		$this->db->where("status_mohon <> 'BATAL' ");
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

	function count_filtered_detps()
	{
		$this->_get_datatables_detps();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all_detps()
	{
		$this->db->from('tp_agenda');
		return $this->db->count_all_results();
	}

	#INFORMASI LANGGANAN
	public function get_pdl_mon($idcari='')
    {
		$query = $this->db->query("SELECT a.*, b.nama KECLANG, c.nama KABLANG, d.nama PROVLANG, e.nm_area NM_AREA
									FROM tp_agenda a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									JOIN tr_area e ON a.KD_AREA = e.KD_AREA
									WHERE id_lang = '$idcari'  ");
		return $all = $query->result();
    }

}
