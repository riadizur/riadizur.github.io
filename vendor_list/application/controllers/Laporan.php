<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model("Cetakm");
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));
		$this->Bord	= "border:1px black solid;";
		$this->L	= "border-left:1px black solid;";
		$this->T	= "border-top:1px black solid;";
		$this->R	= "border-right:1px black solid;";
		$this->B	= "border-bottom:1px black solid;";
		$this->xL	= "border-left:none;";
		$this->xT	= "border-top:none;";
		$this->xR	= "border-right:none;";
		$this->xB	= "border-bottom:none;";
		date_default_timezone_set('Asia/Jakarta');
	}

public function rpt_pasangbaru(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$ID_LANG_TUJUAN_BAYAR = $r->ID_LANG_TUJUAN_BAYAR;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}
	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	$q = $this->db->query("SELECT NAMA_LANG ATASNAMA FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->ATASNAMA;
		}
	}else{
			$ATASNAMA = '';
	}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	if($POLA == '0'){
		$teks = "Jawaban atas permohonan ini agar disampaikan melalui alamat email atau alamat surat sesuai data pemohon diatas.";
	}elseif($POLA == '1'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui tagihan rekening listrik dengan nomor ID Langganan: $ID_LANG_TUJUAN_BAYAR, atas nama: $ATASNAMA .";
	}else{
		$teks = "";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			   <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR PERMOHONAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=5> Yang bertanda tangan dibawah ini : </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=54% colspan=2>".ucwords(strtolower($NAMA_MOHON))."</td>
				<td width=30%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_MOHON)) .",	".ucwords(strtolower($KECMOHON)).",	".ucwords(strtolower($KABMOHON))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Telp / HP</td>
				<td>:</td>
				<td colspan=2>$TELP / $HP</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>$IDENTITAS_MOHON</td>
				<td>:</td>
				<td colspan=2>$NO_IDENTITAS_MOHON</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Email</td>
				<td>:</td>
				<td colspan=2>$EMAIL</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Mengajukan permohonan $JNS_TRANSAKSI sebagai berikut :</td>
			  </tr>
			  <tr>
				<td>Id Customer</td>
				<td>:</td>
				<td colspan=2>$ID_CUST</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama</td>
				<td>:</td>
				<td colspan=2>".$NAMA_LANG."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_LANG))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Tarif</td>
				<td>:</td>
				<td width=20%>$TARIF_BARU</td>
				<td width=20%>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Daya</td>
				<td>:</td>
				<td>$DAYA_BARU VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Peruntukan</td>
				<td>:</td>
				<td>$PERUNTUKAN</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5 align=justify>".$teks."</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian dapat disampaikan, terima kasih.</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Jakarta, $TGL_TTD</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Pemohon</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>".ucwords(strtolower($NAMA_MOHON))."</center></td>
			  </tr>
			</table>";

		$SenD["TitlE"]	= "Cetak Permohonan Pasang Baru $NO_AGENDA";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_perubahandaya(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= $r->DAYA_BARU;
		$DAYA_LAMA		= $r->DAYA_LAMA;
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$ID_LANG_TUJUAN_BAYAR = $r->ID_LANG_TUJUAN_BAYAR;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');
	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}
	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	if($POLA == '0'){
		$teks = "Jawaban atas permohonan ini agar disampaikan melalui alamat email dan surat sesuai data pemohon.";
	}elseif($POLA == '1'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik dengan nomor ID Langganan: $ID_LANG_TUJUAN_BAYAR, atas nama: $ATASNAMA.";
	}else{
		$teks = "";
	}


	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR PERMOHONAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=5> Yang bertanda tangan dibawah ini : </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=54% colspan=2>".ucwords(strtolower($NAMA_MOHON))."</td>
				<td width=30%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_MOHON)) .",	".ucwords(strtolower($KECMOHON)).",	".ucwords(strtolower($KABMOHON))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Telp / HP</td>
				<td>:</td>
				<td colspan=2>$TELP / $HP</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>$IDENTITAS_MOHON</td>
				<td>:</td>
				<td colspan=2>$NO_IDENTITAS_MOHON</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Email</td>
				<td>:</td>
				<td colspan=2>$EMAIL</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Mengajukan permohonan $JNS_TRANSAKSI sebagai berikut :</td>
			  </tr>
			  <tr>
				<td>Id Customer</td>
				<td>:</td>
				<td colspan=2>$ID_CUST</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama</td>
				<td>:</td>
				<td colspan=2>".$NAMA_LANG."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_LANG))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Tarif Lama</td>
				<td>:</td>
				<td width=20%>$TARIF_LAMA</td>
				<td width=20%>Tarif Baru</td>
				<td>$TARIF_BARU</td>
			  </tr>
			  <tr>
				<td>Daya Lama</td>
				<td>:</td>
				<td>$DAYA_LAMA VA</td>
				<td>Daya Baru</td>
				<td>$DAYA_BARU VA</td>
			  </tr>
			  <tr>
				<td>Peruntukan</td>
				<td>:</td>
				<td>$PERUNTUKAN</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>".$teks."</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian dapat disampaikan, terima kasih.</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Jakarta, $TGL_TTD</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Pemohon</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>".ucwords(strtolower($NAMA_MOHON))."</center></td>
			  </tr>
			  <tr>
				<td colspan=4></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";

		$SenD["TitlE"]	= "Cetak Permohonan Perubahan Daya $NO_AGENDA";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_perubahannama(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= $r->DAYA_BARU;
		$DAYA_LAMA		= $r->DAYA_LAMA;
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$ID_LANG_TUJUAN_BAYAR	= $r->ID_LANG_TUJUAN_BAYAR;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Jawaban atas permohonan ini agar disampaikan melalui alamat email dan surat sesuai data pemohon.";
	}elseif($POLA == '1'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik dengan nomor ID Langganan: $ID_LANG_TUJUAN_BAYAR, atas nama: $ATASNAMA .";
	}else{
		$teks = "";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR PERMOHONAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=5> Yang bertanda tangan dibawah ini : </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=54% colspan=2>".ucwords(strtolower($NAMA_MOHON))."</td>
				<td width=30%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_MOHON)) . "</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Telp / HP</td>
				<td>:</td>
				<td colspan=2>$TELP / $HP</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>$IDENTITAS_MOHON</td>
				<td>:</td>
				<td colspan=2>$NO_IDENTITAS_MOHON</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Email</td>
				<td>:</td>
				<td colspan=2>$EMAIL</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Mengajukan permohonan $JNS_TRANSAKSI sebagai berikut :</td>
			  </tr>
			  <tr>
				<td>Id Customer</td>
				<td>:</td>
				<td colspan=2>$ID_CUST</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama Baru</td>
				<td>:</td>
				<td colspan=2>".$NAMA_LANG."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Baru</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_LANG))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Peruntukan</td>
				<td>:</td>
				<td>$PERUNTUKAN</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>$teks</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian dapat disampaikan, terima kasih.</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Jakarta, $TGL_TTD</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Pemohon</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>".ucwords(strtolower($NAMA_MOHON))."</center></td>
			  </tr>
			  <tr>
				<td colspan=4></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";

		$SenD["TitlE"]	= "Cetak Permohonan Balik Nama $NO_AGENDA";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_sementara(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM tp_agenda a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$LAMA_WAKTU		= $r->LAMA_WAKTU;
		$TGL_AWAL		= $r->TGL_AWAL;
		$TGL_AKHIR		= $r->TGL_AKHIR;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= $r->DAYA_LAMA;
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$ID_LANG_TUJUAN_BAYAR = $r->ID_LANG_TUJUAN_BAYAR;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$TGL_TTD = (empty($TGL_MOHON2)) ? '' : tanggal_ttd($TGL_MOHON2);
	$AWAL 	 = (empty($TGL_AWAL)) ? '' : tanggal_ttd($TGL_AWAL);
	$AKHIR 	 = (empty($TGL_AKHIR)) ? '' : tanggal_ttd($TGL_AKHIR);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Jawaban atas permohonan ini agar disampaikan melalui alamat email dan surat sesuai data pemohon.";
	}elseif($POLA == '1'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Segala biaya yang muncul dalam proses permohonan ini agar ditagihkan melalui rekening listrik dengan nomor ID Langganan: $ID_LANG_TUJUAN_BAYAR, atas nama: $ATASNAMA .";
	}else{
		$teks = "";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR PERMOHONAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=5> Yang bertanda tangan dibawah ini : </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=54% colspan=2>".ucwords(strtolower($NAMA_MOHON))."</td>
				<td width=30%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_MOHON)) ."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Telp / HP</td>
				<td>:</td>
				<td colspan=2>$TELP / $HP</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>$IDENTITAS_MOHON</td>
				<td>:</td>
				<td colspan=2>$NO_IDENTITAS_MOHON</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Email</td>
				<td>:</td>
				<td colspan=2>$EMAIL</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Mengajukan permohonan $JNS_TRANSAKSI sebagai berikut :</td>
			  </tr>
			  <tr>
				<td>Id Customer</td>
				<td>:</td>
				<td colspan=2>$ID_CUST</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama</td>
				<td>:</td>
				<td colspan=2>".$NAMA_LANG."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_LANG))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Lama Waktu</td>
				<td>:</td>
				<td colspan=2>$LAMA_WAKTU Hari</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Mulai</td>
				<td>:</td>
				<td colspan=2>$AWAL</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Akhir</td>
				<td>:</td>
				<td colspan=2>$AKHIR</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Daya Baru</td>
				<td>:</td>
				<td colspan=2>$DAYA_BARU VA</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Peruntukan</td>
				<td>:</td>
				<td>$PERUNTUKAN</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>$teks</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian dapat disampaikan, terima kasih.</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Jakarta, $TGL_TTD</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Pemohon</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center><b>".ucwords(strtolower($NAMA_MOHON))."</b></center></td>
			  </tr>
			  <tr>
				<td colspan=4></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";

		$SenD["TitlE"]	= "Cetak Permohonan $JNS_TRANSAKSI $NO_AGENDA";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_bongkar(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$ID_LANG		= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= $r->DAYA_BARU;
		$DAYA_LAMA		= number_format($r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
		$teks = "Biaya tersebut diatas agar ditagihkan melalui tagihan rekening listrik bulan pertama";
	}elseif($POLA == '2'){
		$teks = "Biaya tersebut diatas agar ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR PERMOHONAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=5> Yang bertanda tangan dibawah ini : </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=54% colspan=2>".ucwords(strtolower($NAMA_MOHON))."</td>
				<td width=30%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_MOHON)) ."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Telp / HP</td>
				<td>:</td>
				<td colspan=2>$TELP / $HP</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>$IDENTITAS_MOHON</td>
				<td>:</td>
				<td colspan=2>$NO_IDENTITAS_MOHON</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat Email</td>
				<td>:</td>
				<td colspan=2>$EMAIL</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Mengajukan permohonan $JNS_TRANSAKSI sebagai berikut :</td>
			  </tr>
			  <tr>
				<td>Id Customer</td>
				<td>:</td>
				<td colspan=2>$ID_CUST</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Id Langganan</td>
				<td>:</td>
				<td colspan=2>$ID_LANG</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama</td>
				<td>:</td>
				<td colspan=2>".$NAMA_LANG."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td colspan=2>".ucwords(strtolower($ALAMAT_LANG))."</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Tarif</td>
				<td>:</td>
				<td width=20%>$TARIF_LAMA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Daya</td>
				<td>:</td>
				<td>$DAYA_LAMA VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Peruntukan</td>
				<td>:</td>
				<td>$PERUNTUKAN</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Jawaban atas permohonan ini agar disampaikan melalui alamat email dan surat sesuai data pemohon.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian dapat disampaikan, terima kasih.</td>
			  </tr>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Jakarta, $TGL_TTD</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>Pemohon</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
				<td><center>".ucwords(strtolower($NAMA_MOHON))."</center></td>
			  </tr>
			  <tr>
				<td colspan=4></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";

		$SenD["TitlE"]	= "Cetak Permohonan Berhenti Berlangganan $NO_AGENDA";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_survey(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$ID_LANG		= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;

		$NAMA_MOHON		= $r->NAMA_MOHON;
		$ALAMAT_MOHON	= $r->ALAMAT_MOHON;
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON	= $r->STATUS_MOHON;


		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA) ;
		$PERUNTUKAN		= $r->PERUNTUKAN;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	#AMBIL DATA MASTER REK
	$q = $this->db->query("SELECT STAND_AKHIR_LWBP,STAND_AKHIR_WBP,STAND_AKHIR_KVARH FROM MASTER_REKENING WHERE ID_LANG = '$ID_LANG' ");
	foreach($q->result() as $r)
	{
		$MSTAND_AKHIR_LWBP	= $r->STAND_AKHIR_LWBP;
		$MSTAND_AKHIR_WBP	= $r->STAND_AKHIR_WBP;
		$MSTAND_AKHIR_KVARH	= $r->STAND_AKHIR_KVARH;
	}

	#AMBIL DATA DIL
	$q = $this->db->query("SELECT * FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG' ");
	foreach($q->result() as $r)
	{
		$NO_PANEL	= $r->NO_PANEL;
		$SM_KE		= $r->SM_KE;
		$TITIK_KE	= $r->TITIK_KE;
		$NO_METER	= $r->NO_METER;
	}


	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>FORMULIR SURVEI $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. Agenda : $NO_AGENDA</center></td>
			  </tr>
			</table>

			<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=6 >&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 width=50%><u>DATA LANGGANAN</u></td>
				<td colspan=3 width=50%><u>DATA PEMOHON</u></td>
			  </tr>
			  <tr>
				<td width=18%>NAMA</td>
				<td width=1%>:</td>
				<td width=31%>$NAMA_LANG</td>
				<td width=27%>NAMA </td>
				<td width=1%>:</td>
				<td width=22%>$NAMA_MOHON</td>
			  </tr>
			  <tr>
				<td>ALAMAT</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
				<td>ALAMAT </td>
				<td>:</td>
				<td>$ALAMAT_MOHON</td>
			  </tr>";
	if($JNS_TRANSAKSI == 'BERHENTI LANGGANAN'){
	$Rpt .="<tr>
				<td>DAYA</td>
				<td>:</td>
				<td>$DAYA_BARU VA</td>
				<td>TELP / HP </td>
				<td>:</td>
				<td>$TELP / $HP</td>
			  </tr>
			  <tr>
				<td>TARIF</td>
				<td>:</td>
				<td>$TARIF_BARU</td>
				<td>EMAIL </td>
				<td>:</td>
				<td>$EMAIL</td>
			  </tr>";
	}else{
	$Rpt .="<tr>
				<td>DAYA LAMA</td>
				<td>:</td>
				<td>$DAYA_LAMA VA</td>
				<td>TELP / HP </td>
				<td>:</td>
				<td>$TELP / $HP</td>
			  </tr>
			  <tr>
				<td>DAYA BARU</td>
				<td>:</td>
				<td>$DAYA_BARU VA</td>
				<td>EMAIL </td>
				<td>:</td>
				<td>$EMAIL</td>
			  </tr>";
	}
	$Rpt .="<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			</table>

			<table width=100% border=1 style='font-size:10px; border-collapse:collapse;'>
			  <tr>
				<td colspan=3><center>DENAH LOKASI</center></td>
				<td colspan=3><center>DETAIL LAYOUT</center></td>
			  </tr>
			  <tr>
				<td colspan=3><p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				  <p>&nbsp;</p>
				<p>&nbsp;</p></td>
				<td colspan=3>&nbsp;</td>
			  </tr>";
	if($JNS_TRANSAKSI == 'BERHENTI LANGGANAN'){
	$Rpt .="<tr>
				<td style='border-bottom:1px solid white; border-right:1px solid white;' colspan=2>Stand Rekening</td>
				<td style='border-bottom:1px solid white; '></td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>Data Sumber</td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; '>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand LWBP :&nbsp;".number_format($MSTAND_AKHIR_LWBP,2)."</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>No Panel</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;$NO_PANEL</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand WBP :&nbsp;".number_format($MSTAND_AKHIR_WBP,2)."</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>SM ke</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;$SM_KE</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid black; border-top:1px solid white;' colspan=3>Stand KVARH :&nbsp;".number_format($MSTAND_AKHIR_KVARH,2)."</td>
				<td style='border-bottom:1px solid black; border-top:1px solid white; border-right:1px solid white;'>Titik Sambungan</td>
				<td style='border-bottom:1px solid black; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid black; border-top:1px solid white;'>&nbsp;$TITIK_KE</td>
			</tr>";
	$Rpt .="<tr>
				<td style='border-bottom:1px solid white; border-right:1px solid white;' colspan=2>Kondisi Stand Terakhir</td>
				<td style='border-bottom:1px solid white; ' ></td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>No Meter </td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; '>&nbsp;$NO_METER</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand LWBP :</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand WBP :</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid black; border-top:1px solid white;' colspan=3>Stand KVARH :</td>
				<td style='border-bottom:1px solid black; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid black; border-top:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid black; border-top:1px solid white;'>&nbsp;</td>
			</tr>";
	$Rpt .="<tr>
				<td colspan=6> Catatan</td><br><br><br><br><br><br><br><br>
			</tr>";
	}elseif($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
	$Rpt .="<tr>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>Catatan</td>
				<td style='border-bottom:1px solid white; ' colspan=2></td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>Data Sumber</td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; '>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand LWBP :</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>No Panel</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand WBP :</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>SM ke</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3>Stand KVARH :</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Titik Sambungan</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Merk / No Meter</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;/</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Merk Pembatas</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Ukuran Pembatas</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Setting Pembatas</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>";
	$Rpt .="<tr>
				<td style='border-top:1px solid white;' colspan=3></td>
				<td style='border-right:1px solid white;'></td>
				<td style='border-right:1px solid white;'></td>
				<td>&nbsp;</td>
			</tr>
			  <tr>
				<td width=6%><center>NO.</center></td>
				<td colspan=3><center>MATERIAL</center></td>
				<td width=20%><center>SATUAN</center></td>
				<td width=20%><center>JUMLAH</center></td>
			  </tr>
			  <tr>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td colspan=3>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
			  </tr>";
	}else{
	$Rpt .="<tr>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>Catatan</td>
				<td style='border-bottom:1px solid white; ' colspan=2></td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'>Data Sumber</td>
				<td style='border-bottom:1px solid white; border-right:1px solid white;'></td>
				<td style='border-bottom:1px solid white; '>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>No Panel</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>SM ke</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>
			<tr>
				<td style='border-bottom:1px solid white; border-top:1px solid white;' colspan=3></td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>Titik Sambungan</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white; border-right:1px solid white;'>:</td>
				<td style='border-bottom:1px solid white; border-top:1px solid white;'>&nbsp;</td>
			</tr>";
	$Rpt .="<tr>
				<td style='border-top:1px solid white;' colspan=3></td>
				<td style='border-right:1px solid white;'></td>
				<td style='border-right:1px solid white;'></td>
				<td>&nbsp;</td>
			</tr>
			  <tr>
				<td width=6%><center>NO.</center></td>
				<td colspan=3><center>MATERIAL</center></td>
				<td width=20%><center>SATUAN</center></td>
				<td width=20%><center>JUMLAH</center></td>
			  </tr>
			  <tr>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td colspan=3>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
				<td>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
					<hr/>
				</td>
			  </tr>";
	}

	$Rpt .="<tr>
				<td>&nbsp;</td>
				<td colspan=2><center>DISETUJUI</center></td>
				<td colspan=2><center>DIPERIKSA</center></td>
				<td width=16%><center>SURVEYOR</center></td>
			  </tr>
			  <tr>
				<td>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
					<p>&nbsp;</p>
				</td>
				<td width=21%>&nbsp;</td>
				<td width=21%>&nbsp;</td>
				<td width=21%>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td><center></center>
				<td><center>MULYONO</center>
				<td><center>SETIO BUDIONO</center></td>
				<td><center>YONGKI M RUSTONO</center></td>
				<td><center>SONI YUHENSKI</center></td>
				<td><center>WIWIT SETIYADI</center></td>
			  </tr>
			  <tr>
				<td colspan=6>Tanggal : </td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan Form Survey $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	if($STATUS_MOHON <= '3'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_CTK_SURVEY ='$sekarang', TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='2' WHERE NO_AGENDA='$no_agenda' ");
	}

}

public function rpt_sip(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);
	$sekarang   = date('Y-m-d H:i:s');
	$thn = date('y');
	$bln = date('n');
	$tgl = date('j');

	$query = $this->db->query("select no_sip from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_sip")=='' OR $query->row("no_sip")== null){
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null OR $query->row("urut")== ''){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
			$otosip = $query->row("urut");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
			$otosip = $query->row("urut");
		}
		$this->db->query("UPDATE TP_AGENDA SET NO_SIP = '$otosip', TGL_CETAKSIP='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_SIP			= $r->NO_SIP;
		$THBL_MOHON		= $r->THBL_MOHON;
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$IL				= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= ucwords(strtolower($r->ALAMAT_LANG));
		$KEC_LANG		= ucwords(strtolower($r->KEC));
		$KOTA_LANG		= ucwords(strtolower($r->KAB));
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;

		$NAMA_MOHON		= ucwords(strtolower($r->NAMA_MOHON));
		$ALAMAT_MOHON	= ucwords(strtolower($r->ALAMAT_MOHON));
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;
		$STATUS_MOHON	= $r->STATUS_MOHON;

		$RP_BP			= number_format($r->RP_BP);
		$RP_UJL_TAGIH	= number_format($r->RP_UJL_TAGIH);
		$RP_UJL_LAMA	= number_format($r->RP_UJL_LAMA);
		$RP_UJL_BARU	= number_format($r->RP_UJL_BARU);
		$MATERAI		= number_format($r->MATERAI);
		$TOTAL_BIAYA	= number_format($r->TOTAL_BIAYA);
		$TOTAL_BIAYAX	= $r->TOTAL_BIAYA;

		$ID_LANG_TUJUAN_BAYAR	= $r->ID_LANG_TUJUAN_BAYAR;

	}

	$TOTALB = $r->RP_BP + $r->RP_UJL_TAGIH + $r->MATERAI;
	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$JNS_TRANSAKSIx = strtolower($JNS_TRANSAKSI);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA.";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	if($STATUS_MOHON < '4'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='4' WHERE NO_AGENDA='$NO_AGENDA' ");

				$querylang = $this->db->query("SELECT LPAD(MAX(SUBSTRING(ID_LANG,7,5))+1,5,'00000') AS ID_LANG FROM
									(SELECT id_lang FROM tp_agenda
									UNION ALL
									SELECT id_lang FROM dil_listrik_ref) a")->row("ID_LANG");

		$AGDKANAN = $this->db->query("SELECT RIGHT(NO_AGENDA,4) AS AGDKANAN  FROM tp_agenda WHERE NO_AGENDA = '$NO_AGENDA' ")->row("AGDKANAN");
		$rand = rand(1, 9);
		$X = substr($NO_AGENDA,5,3);

		$user = $this->session->userdata('nama');
		#KONDISI BERDASARKAN JENIS TRANSAKSI, POLA
		if($JNS_TRANSAKSI == 'PASANG BARU')
		{
			if($POLA == '1' OR $POLA == '2'){
				$STATUS_MOHON = '5';
				$TGL_BAYAR = $sekarang;
				$JNS_PELUNASAN = 'TRANSFER';
				$STATUS_CREATE_ID = 'YA';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
				$NO_PK = '';
				$IDLANG = $KD_AREA.'0'.$querylang.$rand;
				if($IL == '0' OR $IL == '' OR $IL == NULL){
					$data['ID_LANG'] = $IDLANG;
				}
				$LOKET_BAYAR = 'EPI';
				$PETUGAS_LUNAS = $user;
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'YA';
				$IDLANG = '0';
				$data['ID_LANG'] = $IDLANG;
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		elseif($JNS_TRANSAKSI == 'BALIK NAMA')
		{
			if($r == '0' OR $ujl == '' OR $ujl == '0'){
				if($POLA == '1' OR $POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';

				}
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'TIDAK';
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		else if($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA')
		{
			if($POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = '';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';
				}
		}else{
			$STATUS_MOHON = '4';
			$TGL_BAYAR = '';
			$JNS_PELUNASAN = '';
			$TGL_UPDATE_MOHON = $sekarang;
			$NO_KWITANSI = '';
			$NO_PK = '';
			$STATUS_CREATE_ID = 'TIDAK';
			$LOKET_BAYAR = '';
			$PETUGAS_LUNAS = '';
		}

		$this->db->query("UPDATE TP_AGENDA SET STATUS_MOHON = '$STATUS_MOHON', TGL_BAYAR = '$TGL_BAYAR',
							JNS_PELUNASAN='$JNS_PELUNASAN',TGL_UPDATE_MOHON = '$TGL_UPDATE_MOHON', NO_KWITANSI='$NO_KWITANSI',
							NO_PK = '$NO_PK', STATUS_CREATE_ID = '$STATUS_CREATE_ID', ID_LANG = $IDLANG,
							LOKET_BAYAR = '$LOKET_BAYAR', PETUGAS_LUNAS='$PETUGAS_LUNAS' WHERE NO_AGENDA='$NO_AGENDA' ");


		$this->db->query("DELETE FROM EPI_CARGO.WS_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
		$this->db->query("INSERT INTO EPI_CARGO.WS_AGENDA (NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH)
						SELECT NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH
						FROM EPI_DBX.TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom>&nbsp;</td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='150' height='75' /></td>
			  </tr>
			  <tr>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
				<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td colspan=3>$NO_SIP</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Jakarta, ".tanggal_ttd(date('Y-m-d'))."</td>
				</tr>
				<tr>
					<td>Klasifikasi</td>
					<td>:</td>
					<td colspan=3>Penting</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Lampiran</td>
					<td>:</td>
					<td colspan=3>-</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Kepada,</td>
				</tr>
				<tr>
					<td>Perihal</td>
					<td>:</td>
					<td colspan=3>Persetujuan Permohonan</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Yth.</td>
					<td>Bpk/Ibu $NAMA_MOHON</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=3>$JNS_TRANSAKSI</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>$ALAMAT_MOHON, $KECMOHON</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><u>$KABMOHON</u></td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>1.</td>
					<td colspan=7 style='text-align:justify;'>
						Sehubungan dengan permohonan $JNS_TRANSAKSIx yang telah Bapak/Ibu ajukan pada tanggal ".tanggal_ttd($TGL_MOHON2)." dengan No Agenda $NO_AGENDA, pada prinsipnya dapat kami setujui.
					</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>2.</td>
					<td colspan=7 style='text-align:justify;'>
						Menunjuk butir 1 (satu) diatas, dapat kami sampaikan data dan biaya sebagai berikut:
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>a.</td>
					<td colspan=6 style='text-align:justify;'>
						Data langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nama</td>
					<td>:</td>
					<td colspan=3>
						$NAMA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Alamat</td>
					<td>:</td>
					<td colspan=3>
						$ALAMAT_LANG, $KEC_LANG - $KOTA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Baru</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_BARU / $DAYA_BARU VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td></td>
					<td></td>
					<td colspan=3>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>b.</td>
					<td colspan=6 style='text-align:justify;'>
						Biaya Penyambungan dan Uang jaminan langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Penyambungan</td>
					<td>:</td>
					<td align=right>
						$RP_BP
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Uang Jaminan Langganan</td>
					<td>:</td>
					<td align=right>
						$RP_UJL_TAGIH
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>

				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Meterai</td>
					<td>:</td>
					<td align=right>
						$MATERAI
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Biaya (Rp.)</b></td>
					<td>:</td>
					<td style='border-top:1px solid;' align=right>
						<b>".number_format($TOTALB)."</b>
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=5>(".ucfirst($this->terbilang($TOTALB)).")</td>
				</tr>";
	if($POLA == '0')
	{
		$Rpt .="<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td colspan=6 style='text-align:justify;'>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Rekening Bank</td>
					<td>:</td>
					<td colspan=3>
						Bank Bukopin
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nomor Rekening</td>
					<td>:</td>
					<td colspan=3>
						1000406488
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Atas Nama</td>
					<td>:</td>
					<td colspan=3>
						PT ENERGI PELABUHAN INDONESIA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>
				";
	}
	else
	{
		$Rpt .=	"<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td colspan=6 style='text-align:justify;'>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>";
	}
		$Rpt .=	"<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>3.</td>
					<td colspan=7 style='text-align:justify;'>
						Demikian disampaikan, atas perhatian diucapkan terima kasih.
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>PT ENERGI PELABUHAN INDONESIA</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>MANAGER NIAGA</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp; <br/><br/><br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center><b><u>MULYONO</u></b></td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
			</table>
			<br/><br/><br/><br/>
			";

	$Rpt .="<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
				<tr>
					<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
				</tr>
				<tr>
					<td width=6%> Telepon</td>
					<td width=0.5%>:</td>
					<td width=94%>(021) 4305047</td>
				</tr>
				<tr>
				  <td>Fax</td>
				  <td>:</td>
				  <td>(021) 4305052</td>
				</tr>
				<tr>
				  <td>Website</td>
				  <td>:</td>
				  <td>www.ecopowerport.co.id</td>
				</tr>
				<tr>
				  <td>Email</td>
				  <td>:</td>
				  <td>cs@ecopowerport.co.id</td>
				</tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan SIP $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_sip_pd(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);
	$sekarang   = date('Y-m-d H:i:s');
	$thn = date('y');
	$bln = date('n');
	$tgl = date('j');

	$query = $this->db->query("select no_sip from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_sip")=='' OR $query->row("no_sip")== null){
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null OR $query->row("urut")== ''){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
			$otosip = $query->row("urut");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
			$otosip = $query->row("urut");
		}
		$this->db->query("UPDATE TP_AGENDA SET NO_SIP = '$otosip', TGL_CETAKSIP='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_SIP			= $r->NO_SIP;
		$THBL_MOHON		= $r->THBL_MOHON;
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA;
		$IL				= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= ucwords(strtolower($r->ALAMAT_LANG));
		$KEC_LANG		= ucwords(strtolower($r->KEC));
		$KOTA_LANG		= ucwords(strtolower($r->KAB));
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;

		$NAMA_MOHON		= ucwords(strtolower($r->NAMA_MOHON));
		$ALAMAT_MOHON	= ucwords(strtolower($r->ALAMAT_MOHON));
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON	= $r->STATUS_MOHON;
		$ID_LANG_TUJUAN_BAYAR	= $r->ID_LANG_TUJUAN_BAYAR;

		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$RP_BP			= number_format($r->RP_BP);
		$RP_UJL_TAGIH	= number_format($r->RP_UJL_TAGIH);
		$RP_UJL_LAMA	= number_format($r->RP_UJL_LAMA);
		$RP_UJL_BARU	= number_format($r->RP_UJL_BARU);
		$MATERAI		= number_format($r->MATERAI);
		$TOTAL_BIAYA	= number_format($r->TOTAL_BIAYA);
		$TOTAL_BIAYAX	= $r->TOTAL_BIAYA;

	}
	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$JNS_TRANSAKSIx = strtolower($JNS_TRANSAKSI);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA.";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	if($STATUS_MOHON < '4'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='4' WHERE NO_AGENDA='$NO_AGENDA' ");

				$querylang = $this->db->query("SELECT LPAD(MAX(SUBSTRING(ID_LANG,7,5))+1,5,'00000') AS ID_LANG FROM
									(SELECT id_lang FROM tp_agenda
									UNION ALL
									SELECT id_lang FROM dil_listrik_ref) a")->row("ID_LANG");

		$AGDKANAN = $this->db->query("SELECT RIGHT(NO_AGENDA,4) AS AGDKANAN  FROM tp_agenda WHERE NO_AGENDA = '$NO_AGENDA' ")->row("AGDKANAN");
		$rand = rand(1, 9);
		$X = substr($NO_AGENDA,5,3);

		$user = $this->session->userdata('nama');
		#KONDISI BERDASARKAN JENIS TRANSAKSI, POLA
		if($JNS_TRANSAKSI == 'PASANG BARU')
		{
			if($POLA == '1' OR $POLA == '2'){
				$STATUS_MOHON = '5';
				$TGL_BAYAR = $sekarang;
				$JNS_PELUNASAN = 'TRANSFER';
				$STATUS_CREATE_ID = 'YA';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
				$NO_PK = '';
				$IDLANG = $KD_AREA.'0'.$querylang.$rand;
				if($IL == '0' OR $IL == '' OR $IL == NULL){
					$data['ID_LANG'] = $IDLANG;
				}
				$LOKET_BAYAR = 'EPI';
				$PETUGAS_LUNAS = $user;
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'YA';
				$IDLANG = '0';
				$data['ID_LANG'] = $IDLANG;
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		elseif($JNS_TRANSAKSI == 'BALIK NAMA')
		{
			if($r == '0' OR $ujl == '' OR $ujl == '0'){
				if($POLA == '1' OR $POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';

				}
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'TIDAK';
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		else if($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA')
		{
			if($POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = '';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';
				}
		}
		else if($JNS_TRANSAKSI == 'PERUBAHAN DAYA')
		{
			if($POLA == '1' OR $POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = '';
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';
				}
		}else{
			$STATUS_MOHON = '4';
			$TGL_BAYAR = '';
			$JNS_PELUNASAN = '';
			$TGL_UPDATE_MOHON = $sekarang;
			$NO_KWITANSI = '';
			$NO_PK = '';
			$STATUS_CREATE_ID = 'TIDAK';
			$LOKET_BAYAR = '';
			$PETUGAS_LUNAS = '';
		}

		if($JNS_TRANSAKSI == 'PERUBAHAN DAYA'){
			$this->db->query("UPDATE TP_AGENDA SET STATUS_MOHON = '$STATUS_MOHON', TGL_BAYAR = '$TGL_BAYAR',
							JNS_PELUNASAN='$JNS_PELUNASAN',TGL_UPDATE_MOHON = '$TGL_UPDATE_MOHON', NO_KWITANSI='$NO_KWITANSI',
							NO_PK = '$NO_PK', STATUS_CREATE_ID = '$STATUS_CREATE_ID',
							LOKET_BAYAR = '$LOKET_BAYAR', PETUGAS_LUNAS='$PETUGAS_LUNAS' WHERE NO_AGENDA='$NO_AGENDA' ");
		}else{
			$this->db->query("UPDATE TP_AGENDA SET STATUS_MOHON = '$STATUS_MOHON', TGL_BAYAR = '$TGL_BAYAR',
							JNS_PELUNASAN='$JNS_PELUNASAN',TGL_UPDATE_MOHON = '$TGL_UPDATE_MOHON', NO_KWITANSI='$NO_KWITANSI',
							NO_PK = '$NO_PK', STATUS_CREATE_ID = '$STATUS_CREATE_ID', ID_LANG = $IDLANG,
							LOKET_BAYAR = '$LOKET_BAYAR', PETUGAS_LUNAS='$PETUGAS_LUNAS' WHERE NO_AGENDA='$NO_AGENDA' ");
		}

		$this->db->query("DELETE FROM EPI_CARGO.WS_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
		$this->db->query("INSERT INTO EPI_CARGO.WS_AGENDA (NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH)
						SELECT NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH
						FROM EPI_DBX.TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom>&nbsp;</td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='150' height='75' /></td>
			  </tr>
			  <tr>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
				<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td colspan=3>$NO_SIP </td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Jakarta, ".tanggal_ttd(date('Y-m-d'))."</td>
				</tr>
				<tr>
					<td>Klasifikasi</td>
					<td>:</td>
					<td colspan=3>Penting</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Lampiran</td>
					<td>:</td>
					<td colspan=3>-</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Kepada,</td>
				</tr>
				<tr>
					<td>Perihal</td>
					<td>:</td>
					<td colspan=3>Persetujuan Permohonan</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Yth.</td>
					<td>Bpk/Ibu $NAMA_MOHON</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=3>$JNS_TRANSAKSI</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>$ALAMAT_MOHON, $KECMOHON</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><u>$KABMOHON</u></td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>1.</td>
					<td colspan=7 style='text-align:justify;'>
						Sehubungan dengan permohonan $JNS_TRANSAKSIx yang telah Bapak/Ibu ajukan pada tanggal ".tanggal_ttd($TGL_MOHON2)." dengan No Agenda $NO_AGENDA, pada prinsipnya dapat kami setujui.
					</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>2.</td>
					<td colspan=7 style='text-align:justify;'>
						Menunjuk butir 1 (satu) diatas, dapat kami sampaikan data dan biaya sebagai berikut:
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>a.</td>
					<td colspan=6 style='text-align:justify;'>
						Data langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nama</td>
					<td>:</td>
					<td colspan=3>
						$NAMA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Alamat</td>
					<td>:</td>
					<td colspan=3>
						$ALAMAT_LANG, $KEC_LANG - $KOTA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Lama</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_LAMA / $DAYA_LAMA VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Baru</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_BARU / $DAYA_BARU VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td></td>
					<td></td>
					<td colspan=3>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>b.</td>
					<td colspan=6 style='text-align:justify;'>
						Biaya Penyambungan dan Uang jaminan langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Penyambungan</td>
					<td>:</td>
					<td align=right>
						$RP_BP
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Uang Jaminan Langganan (UJL)</td>
					<td></td>
					<td colspan=3 align=left>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Lama</td>
					<td>:</td>
					<td colspan=3 align=left>
						$RP_UJL_LAMA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Baru</td>
					<td>:</td>
					<td colspan=3>
						$RP_UJL_BARU
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Ditagihkan</td>
					<td>:</td>
					<td align=right>
						$RP_UJL_TAGIH
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Meterai</td>
					<td>:</td>
					<td align=right>
						$MATERAI
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Biaya (Rp.)</b></td>
					<td>:</td>
					<td style='border-top:1px solid;' align=right>
						<b>$TOTAL_BIAYA</b>
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=5>(".ucfirst($this->terbilang($TOTAL_BIAYAX)).")</td>
				</tr>";
	if($POLA == '0'){
		$Rpt .="<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Rekening Bank</td>
					<td>:</td>
					<td colspan=3>
						Bank Bukopin
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nomor Rekening</td>
					<td>:</td>
					<td colspan=3>
						1000406488
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Atas Nama</td>
					<td>:</td>
					<td colspan=3>
						PT ENERGI PELABUHAN INDONESIA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>

				";
	}else{
		$Rpt .=	"<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>";
	}
		$Rpt .=	"<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>3.</td>
					<td colspan=7 style='text-align:justify;'>
						Demikian disampaikan, atas perhatian diucapkan terima kasih.
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>PT ENERGI PELABUHAN INDONESIA</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>MANAGER NIAGA</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp; <br/><br/><br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center><b><u>MULYONO</u></b></td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
			</table>";
	$Rpt .="<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
				<tr>
					<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
				</tr>
				<tr>
					<td width=6%> Telepon</td>
					<td width=0.5%>:</td>
					<td width=94%>(021) 4305047</td>
				</tr>
				<tr>
				  <td>Fax</td>
				  <td>:</td>
				  <td>(021) 4305052</td>
				</tr>
				<tr>
				  <td>Website</td>
				  <td>:</td>
				  <td>www.ecopowerport.co.id</td>
				</tr>
				<tr>
				  <td>Email</td>
				  <td>:</td>
				  <td>cs@ecopowerport.co.id</td>
				</tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan SIP $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_sip_pn(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);
	$sekarang   = date('Y-m-d H:i:s');
	$thn = date('y');
	$bln = date('n');
	$tgl = date('j');

	$query = $this->db->query("select no_sip from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_sip")=='' OR $query->row("no_sip")== null){
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null OR $query->row("urut")== ''){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
			$otosip = $query->row("urut");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
			$otosip = $query->row("urut");
		}
		$this->db->query("UPDATE TP_AGENDA SET NO_SIP = '$otosip', TGL_CETAKSIP='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_SIP			= $r->NO_SIP;
		$THBL_MOHON		= $r->THBL_MOHON;
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ID_LANG		= $r->ID_LANG;
		$ALAMAT_LANG	= ucwords(strtolower($r->ALAMAT_LANG));
		$KEC_LANG		= ucwords(strtolower($r->KEC));
		$KOTA_LANG		= ucwords(strtolower($r->KAB));
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;

		$NAMA_MOHON		= ucwords(strtolower($r->NAMA_MOHON));
		$ALAMAT_MOHON	= ucwords(strtolower($r->ALAMAT_MOHON));
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON   = $r->STATUS_MOHON;

		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;

		$RP_BP			= number_format($r->RP_BP);
		$RP_UJL_TAGIH	= number_format($r->RP_UJL_TAGIH);
		$RP_UJL_LAMA	= number_format($r->RP_UJL_LAMA);
		$RP_UJL_BARU	= number_format($r->RP_UJL_BARU);
		$MATERAI		= number_format($r->MATERAI);
		$TOTAL_BIAYA	= number_format($r->TOTAL_BIAYA);
		$TOTAL_BIAYAX	= $r->TOTAL_BIAYA;

		$ID_LANG_TUJUAN_BAYAR	= $r->ID_LANG_TUJUAN_BAYAR;

	}
	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$JNS_TRANSAKSIx = strtolower($JNS_TRANSAKSI);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
	}elseif($POLA == '2'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA.";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	if($STATUS_MOHON < '4'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='4' WHERE NO_AGENDA='$NO_AGENDA' ");

				$querylang = $this->db->query("SELECT LPAD(MAX(SUBSTRING(ID_LANG,7,5))+1,5,'00000') AS ID_LANG FROM
									(SELECT id_lang FROM tp_agenda
									UNION ALL
									SELECT id_lang FROM dil_listrik_ref) a")->row("ID_LANG");

		$AGDKANAN = $this->db->query("SELECT RIGHT(NO_AGENDA,4) AS AGDKANAN  FROM tp_agenda WHERE NO_AGENDA = '$NO_AGENDA' ")->row("AGDKANAN");
		$rand = rand(1, 9);
		$X = substr($NO_AGENDA,5,3);

		$user = $this->session->userdata('nama');
		#KONDISI BERDASARKAN JENIS TRANSAKSI, POLA
		if($JNS_TRANSAKSI == 'PASANG BARU')
		{
			if($POLA == '1' OR $POLA == '2'){
				$STATUS_MOHON = '5';
				$TGL_BAYAR = $sekarang;
				$JNS_PELUNASAN = 'TRANSFER';
				$STATUS_CREATE_ID = 'YA';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
				$NO_PK = '';
				$IDLANG = $KD_AREA.'0'.$querylang.$rand;
				if($IL == '0' OR $IL == '' OR $IL == NULL){
					$data['ID_LANG'] = $IDLANG;
				}
				$LOKET_BAYAR = 'EPI';
				$PETUGAS_LUNAS = $user;
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'YA';
				$IDLANG = '0';
				$data['ID_LANG'] = $IDLANG;
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		elseif($JNS_TRANSAKSI == 'BALIK NAMA')
		{
			if($r == '0' OR $ujl == '' OR $ujl == '0'){
				if($POLA == '1' OR $POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';

				}
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'TIDAK';
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		else if($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA')
		{
			if($POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = '';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';
				}
		}else{
			$STATUS_MOHON = '4';
			$TGL_BAYAR = '';
			$JNS_PELUNASAN = '';
			$TGL_UPDATE_MOHON = $sekarang;
			$NO_KWITANSI = '';
			$NO_PK = '';
			$STATUS_CREATE_ID = 'TIDAK';
			$LOKET_BAYAR = '';
			$PETUGAS_LUNAS = '';
		}

		$this->db->query("UPDATE TP_AGENDA SET STATUS_MOHON = '$STATUS_MOHON', TGL_BAYAR = '$TGL_BAYAR',
							JNS_PELUNASAN='$JNS_PELUNASAN',TGL_UPDATE_MOHON = '$TGL_UPDATE_MOHON', NO_KWITANSI='$NO_KWITANSI',
							NO_PK = '$NO_PK', STATUS_CREATE_ID = '$STATUS_CREATE_ID', ID_LANG = $IDLANG,
							LOKET_BAYAR = '$LOKET_BAYAR', PETUGAS_LUNAS='$PETUGAS_LUNAS' WHERE NO_AGENDA='$NO_AGENDA' ");

		$this->db->query("DELETE FROM EPI_CARGO.WS_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
		$this->db->query("INSERT INTO EPI_CARGO.WS_AGENDA (NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH)
						SELECT NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH
						FROM EPI_DBX.TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom>&nbsp;</td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='150' height='75' /></td>
			  </tr>
			  <tr>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
				<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td colspan=3>$NO_SIP</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Jakarta, ".tanggal_ttd(date('Y-m-d'))."</td>
				</tr>
				<tr>
					<td>Klasifikasi</td>
					<td>:</td>
					<td colspan=3>Penting</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Lampiran</td>
					<td>:</td>
					<td colspan=3>-</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Kepada,</td>
				</tr>
				<tr>
					<td>Perihal</td>
					<td>:</td>
					<td colspan=3>Persetujuan Permohonan</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Yth.</td>
					<td>Bpk/Ibu $NAMA_MOHON</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=3>$JNS_TRANSAKSI</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>$ALAMAT_MOHON, $KECMOHON</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><u>$KABMOHON</u></td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>1.</td>
					<td colspan=7 style='text-align:justify;'>
						Sehubungan dengan permohonan $JNS_TRANSAKSIx yang telah Bapak/Ibu ajukan pada tanggal ".tanggal_ttd($TGL_MOHON2)." dengan No Agenda $NO_AGENDA, pada prinsipnya dapat kami setujui.
					</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>2.</td>
					<td colspan=7 style='text-align:justify;'>
						Menunjuk butir 1 (satu) diatas, dapat kami sampaikan data dan biaya sebagai berikut:
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>a.</td>
					<td colspan=6 style='text-align:justify;'>
						Data langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nama</td>
					<td>:</td>
					<td colspan=3>
						$NAMA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Alamat</td>
					<td>:</td>
					<td colspan=3>
						$ALAMAT_LANG, $KEC_LANG - $KOTA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Lama</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_LAMA / $DAYA_LAMA VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Baru</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_BARU / $DAYA_BARU VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td></td>
					<td></td>
					<td colspan=3>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>b.</td>
					<td colspan=6 style='text-align:justify;'>
						Biaya Penyambungan dan Uang jaminan langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Penyambungan</td>
					<td>:</td>
					<td align=right>
						$RP_BP
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Uang Jaminan Langganan (UJL)</td>
					<td></td>
					<td colspan=3 align=left>

					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Lama</td>
					<td>:</td>
					<td colspan=3 align=left>
						$RP_UJL_LAMA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Baru</td>
					<td>:</td>
					<td colspan=3>
						$RP_UJL_BARU
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top></td>
					<td>* Ditagihkan</td>
					<td>:</td>
					<td align=right>
						$RP_UJL_TAGIH
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Meterai</td>
					<td>:</td>
					<td align=right>
						$MATERAI
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Biaya (Rp.)</b></td>
					<td>:</td>
					<td style='border-top:1px solid;' align=right>
						<b>$TOTAL_BIAYA</b>
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=5>(".ucfirst($this->terbilang($TOTAL_BIAYAX)).")</td>

				</tr>";
	if($POLA == '0'){
	$Rpt .="	<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Rekening Bank</td>
					<td>:</td>
					<td colspan=3>
						Bank Bukopin
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nomor Rekening</td>
					<td>:</td>
					<td colspan=3>
						1000406488
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Atas Nama</td>
					<td>:</td>
					<td colspan=3>
						PT ENERGI PELABUHAN INDONESIA
					</td>
				</tr>";
	}else{
	$Rpt .=		"<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>";
	}
	$Rpt .=		"<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>3.</td>
					<td colspan=7 style='text-align:justify;'>
						Demikian disampaikan, atas perhatian diucapkan terima kasih.
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>PT ENERGI PELABUHAN INDONESIA</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>MANAGER NIAGA</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp; <br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center><b><u>MULYONO</u></b></td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
			</table>";
	$Rpt .="<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
				<tr>
					<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
				</tr>
				<tr>
					<td width=6%> Telepon</td>
					<td width=0.5%>:</td>
					<td width=94%>(021) 4305047</td>
				</tr>
				<tr>
				  <td>Fax</td>
				  <td>:</td>
				  <td>(021) 4305052</td>
				</tr>
				<tr>
				  <td>Website</td>
				  <td>:</td>
				  <td>www.ecopowerport.co.id</td>
				</tr>
				<tr>
				  <td>Email</td>
				  <td>:</td>
				  <td>cs@ecopowerport.co.id</td>
				</tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan SIP $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_sip_ps(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);
	$sekarang   = date('Y-m-d H:i:s');
	$thn = date('y');
	$bln = date('n');
	$tgl = date('j');

	$query = $this->db->query("select no_sip from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_sip")=='' OR $query->row("no_sip")== null){
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null OR $query->row("urut")== ''){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
			$otosip = $query->row("urut");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
			$otosip = $query->row("urut");
		}
		$this->db->query("UPDATE TP_AGENDA SET NO_SIP = '$otosip', TGL_CETAKSIP='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_SIP			= $r->NO_SIP;
		$THBL_MOHON		= $r->THBL_MOHON;
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA;
		$IL				= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= ucwords(strtolower($r->ALAMAT_LANG));
		$KEC_LANG		= ucwords(strtolower($r->KEC));
		$KOTA_LANG		= ucwords(strtolower($r->KAB));
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;

		$NAMA_MOHON		= ucwords(strtolower($r->NAMA_MOHON));
		$ALAMAT_MOHON	= ucwords(strtolower($r->ALAMAT_MOHON));
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON	= $r->STATUS_MOHON;

		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;
		$POLA			= $r->POLA_PEMBAYARAN;
		$ID_LANG_TUJUAN_BAYAR = $r->ID_LANG_TUJUAN_BAYAR;
		$RP_BP			= number_format($r->RP_BP);
		$RP_UJL_TAGIH	= number_format($r->RP_UJL_TAGIH);
		$RP_UJL_LAMA	= number_format($r->RP_UJL_LAMA);
		$RP_UJL_BARU	= number_format($r->RP_UJL_BARU);
		$MATERAI		= number_format($r->MATERAI);

		$TGL_AWAL		= $r->TGL_AWAL;
		$TGL_AKHIR		= $r->TGL_AKHIR;
		$LAMA_WAKTU		= $r->LAMA_WAKTU;
		$RPKWH_PS		= number_format($r->RPKWH_PS);
		$RPBPJU_PS		= number_format($r->RPBPJU_PS);
		$RP_BP	= number_format($r->RP_BP);

		$TOTAL_BIAYA	= $r->RPKWH_PS + $r->RP_BP + $r->RPBPJU_PS + $r->MATERAI;
		$TOTAL_BIAYAX	= number_format($TOTAL_BIAYA);

		$TGL_CETAKSIP = $r->TGL_CETAKSIP;

	}
	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);
	$TGL_TTD_SIP = tanggal_ttd(date_format(date_create($TGL_CETAKSIP), 'Y-m-d'));

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$JNS_TRANSAKSIx = strtolower($JNS_TRANSAKSI);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA.";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	if($STATUS_MOHON < '4'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='4' WHERE NO_AGENDA='$NO_AGENDA' ");

				$querylang = $this->db->query("SELECT LPAD(MAX(SUBSTRING(ID_LANG,7,5))+1,5,'00000') AS ID_LANG FROM
									(SELECT id_lang FROM tp_agenda
									UNION ALL
									SELECT id_lang FROM dil_listrik_ref) a")->row("ID_LANG");

		$AGDKANAN = $this->db->query("SELECT RIGHT(NO_AGENDA,4) AS AGDKANAN  FROM tp_agenda WHERE NO_AGENDA = '$NO_AGENDA' ")->row("AGDKANAN");
		$rand = rand(1, 9);
		$X = substr($NO_AGENDA,5,3);

		$user = $this->session->userdata('nama');
		#KONDISI BERDASARKAN JENIS TRANSAKSI, POLA
		if($JNS_TRANSAKSI == 'PASANG BARU')
		{
			if($POLA == '1' OR $POLA == '2'){
				$STATUS_MOHON = '5';
				$TGL_BAYAR = $sekarang;
				$JNS_PELUNASAN = 'TRANSFER';
				$STATUS_CREATE_ID = 'YA';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
				$NO_PK = '';
				$IDLANG = $KD_AREA.'0'.$querylang.$rand;
				if($IL == '0' OR $IL == '' OR $IL == NULL){
					$data['ID_LANG'] = $IDLANG;
				}
				$LOKET_BAYAR = 'EPI';
				$PETUGAS_LUNAS = $user;
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'YA';
				$IDLANG = '0';
				$data['ID_LANG'] = $IDLANG;
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		elseif($JNS_TRANSAKSI == 'BALIK NAMA')
		{
			if($r == '0' OR $ujl == '' OR $ujl == '0'){
				if($POLA == '1' OR $POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';

				}
			}else{
				$STATUS_MOHON = '4';
				$TGL_BAYAR = '';
				$JNS_PELUNASAN = '';
				$TGL_UPDATE_MOHON = $sekarang;
				$NO_KWITANSI = '';
				$NO_PK = '';
				$STATUS_CREATE_ID = 'TIDAK';
				$LOKET_BAYAR = '';
				$PETUGAS_LUNAS = '';
			}
		}
		else if($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA')
		{
			if($POLA == '2'){
					$STATUS_MOHON = '5';
					$TGL_BAYAR = $sekarang;
					$JNS_PELUNASAN = 'TRANSFER';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = 'KEU-'.$KD_AREA.'-'.$X.'-'.$AGDKANAN;
					$NO_PK = '';
					$STATUS_CREATE_ID = 'TIDAK';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = 'EPI';
					$PETUGAS_LUNAS = $user;
				}else{
					$STATUS_MOHON = '4';
					$TGL_BAYAR = '';
					$JNS_PELUNASAN = '';
					$TGL_UPDATE_MOHON = $sekarang;
					$NO_KWITANSI = '';
					$NO_PK = '';
					$STATUS_CREATE_ID = '';
					$IDLANG = '0';
					$data['ID_LANG'] = $IDLANG;
					$LOKET_BAYAR = '';
					$PETUGAS_LUNAS = '';
				}
		}else{
			$STATUS_MOHON = '4';
			$TGL_BAYAR = '';
			$JNS_PELUNASAN = '';
			$TGL_UPDATE_MOHON = $sekarang;
			$NO_KWITANSI = '';
			$NO_PK = '';
			$STATUS_CREATE_ID = 'TIDAK';
			$LOKET_BAYAR = '';
			$PETUGAS_LUNAS = '';
		}

		$this->db->query("UPDATE TP_AGENDA SET STATUS_MOHON = '$STATUS_MOHON', TGL_BAYAR = '$TGL_BAYAR',
							JNS_PELUNASAN='$JNS_PELUNASAN',TGL_UPDATE_MOHON = '$TGL_UPDATE_MOHON', NO_KWITANSI='$NO_KWITANSI',
							NO_PK = '$NO_PK', STATUS_CREATE_ID = '$STATUS_CREATE_ID', ID_LANG = $IDLANG,
							LOKET_BAYAR = '$LOKET_BAYAR', PETUGAS_LUNAS='$PETUGAS_LUNAS' WHERE NO_AGENDA='$NO_AGENDA' ");

		$this->db->query("DELETE FROM EPI_CARGO.WS_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
		$this->db->query("INSERT INTO EPI_CARGO.WS_AGENDA (NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH)
						SELECT NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH
						FROM EPI_DBX.TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom>&nbsp;</td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='150' height='75' /></td>
			  </tr>
			  <tr>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
				<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td colspan=3>$NO_SIP</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Jakarta, ".$TGL_TTD_SIP."</td>
				</tr>
				<tr>
					<td>$TGL_BAYAR Klasifikasi</td>
					<td>:</td>
					<td colspan=3>Penting</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Lampiran</td>
					<td>:</td>
					<td colspan=3>-</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Kepada,</td>
				</tr>
				<tr>
					<td>Perihal</td>
					<td>:</td>
					<td colspan=3>Persetujuan Permohonan</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Yth.</td>
					<td>Bpk/Ibu $NAMA_MOHON</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=3>$JNS_TRANSAKSI</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>$ALAMAT_MOHON, $KECMOHON</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><u>$KABMOHON</u></td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>1.</td>
					<td colspan=7 style='text-align:justify;'>
						Sehubungan dengan permohonan $JNS_TRANSAKSIx yang telah Bapak/Ibu ajukan pada tanggal ".tanggal_ttd($TGL_MOHON2)." dengan No Agenda $NO_AGENDA, pada prinsipnya dapat kami setujui.
					</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>2.</td>
					<td colspan=7 style='text-align:justify;'>
						Menunjuk butir 1 (satu) diatas, dapat kami sampaikan data dan biaya sebagai berikut:
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>a.</td>
					<td colspan=6 style='text-align:justify;'>
						Data langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nama</td>
					<td>:</td>
					<td colspan=3>
						$NAMA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Alamat</td>
					<td>:</td>
					<td colspan=3>
						$ALAMAT_LANG, $KEC_LANG - $KOTA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Baru</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_BARU / $DAYA_BARU VA
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:5px;'>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>b.</td>
					<td colspan=6 style='text-align:justify;'>
						Biaya Penyambungan dan Uang jaminan langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td >Lama Waktu</td>
					<td >:</td>
					<td align=left>
						$LAMA_WAKTU Hari
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td >Tanggal Awal</td>
					<td >:</td>
					<td align=left>
						$TGL_AWAL
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td >Tanggal Akhir</td>
					<td >:</td>
					<td align=left>
						$TGL_AKHIR
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:3px;'>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya KWH</td>
					<td>:</td>
					<td align=right>
						$RPKWH_PS
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Material</td>
					<td>:</td>
					<td align=right>
						$RP_BP
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya BPJU</td>
					<td>:</td>
					<td align=right>
						$RPBPJU_PS
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Biaya Meterai</td>
					<td>:</td>
					<td align=right>
						$MATERAI
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Biaya (Rp.)</b></td>
					<td>:</td>
					<td style='border-top:1px solid;' align=right>
						<b>$TOTAL_BIAYAX</b>
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=5>(".ucfirst($this->terbilang($TOTAL_BIAYA)).")</td>

				</tr>
				<tr>
					<td colspan=9 style='font-size:5px;'>&nbsp;</td>
				</tr>";
		if($POLA == '0'){
	$Rpt .="	<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Rekening Bank</td>
					<td>:</td>
					<td colspan=3>
						Bank Bukopin
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nomor Rekening</td>
					<td>:</td>
					<td colspan=3>
						1000406488
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Atas Nama</td>
					<td>:</td>
					<td colspan=3>
						PT ENERGI PELABUHAN INDONESIA
					</td>
				</tr>";
	}else{
	$Rpt .=		"<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>";
	}
	$Rpt .=		"<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>3.</td>
					<td colspan=7 style='text-align:justify;'>
						Demikian disampaikan, atas perhatian diucapkan terima kasih.
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>PT ENERGI PELABUHAN INDONESIA</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>MANAGER NIAGA</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp; <br/><br/><br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center><b><u>MULYONO</u></b></td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
			</table>";


	$Rpt .="<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
				<tr>
					<td colspan=6 style='font-size:12px;'>&nbsp; <br/><br/><br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
				</tr>
				<tr>
					<td width=6%> Telepon</td>
					<td width=0.5%>:</td>
					<td width=94%>(021) 4305047</td>
				</tr>
				<tr>
				  <td>Fax</td>
				  <td>:</td>
				  <td>(021) 4305052</td>
				</tr>
				<tr>
				  <td>Website</td>
				  <td>:</td>
				  <td>www.ecopowerport.co.id</td>
				</tr>
				<tr>
				  <td>Email</td>
				  <td>:</td>
				  <td>cs@ecopowerport.co.id</td>
				</tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan SIP $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_sip_bongkar(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);
	$sekarang   = date('Y-m-d H:i:s');
	$thn = date('y');
	$bln = date('n');
	$tgl = date('j');

	$query = $this->db->query("select no_sip from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_sip")=='' OR $query->row("no_sip")== null){
		$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
									FROM TP_AGENDA
									WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
		if($query->row("urut")==null OR $query->row("urut")== ''){
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA");
			$otosip = $query->row("urut");
		}else{
			$query = $this->db->query("SELECT CONCAT('FK.108/','$tgl','/','$bln','/',MAX(EXPLODE(NO_SIP,'/',4))+1,'/EPI-','$thn') AS urut
										FROM TP_AGENDA
										WHERE EXPLODE(NO_SIP,'/',2)=$tgl AND EXPLODE(NO_SIP,'/',3)=$bln AND RIGHT(no_sip,2)=$thn ");
			$otosip = $query->row("urut");
		}
		$this->db->query("UPDATE TP_AGENDA SET NO_SIP = '$otosip', TGL_CETAKSIP='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_SIP			= $r->NO_SIP;
		$THBL_MOHON		= $r->THBL_MOHON;
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$ID_LANG		= $r->ID_LANG;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= ucwords(strtolower($r->ALAMAT_LANG));
		$KEC_LANG		= ucwords(strtolower($r->KEC));
		$KOTA_LANG		= ucwords(strtolower($r->KAB));
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;
		$POLA			= $r->POLA_PEMBAYARAN;

		$NAMA_MOHON		= ucwords(strtolower($r->NAMA_MOHON));
		$ALAMAT_MOHON	= ucwords(strtolower($r->ALAMAT_MOHON));
		$KEC_MOHON		= $r->KEC_MOHON;
		$KOTA_MOHON		= $r->KOTA_MOHON;
		$PROV_MOHON		= $r->PROV_MOHON;
		$TELP_MOHON		= $r->TELP_MOHON;
		$HP_MOHON		= $r->HP_MOHON;
		$TGL_MOHON2		= $r->TGL_MOHON2;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON	= $r->STATUS_MOHON;

		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= number_format($r->DAYA_BARU);
		$DAYA_LAMA		= number_format((empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA);
		$PERUNTUKAN		= $r->PERUNTUKAN;

		$PPJ			= number_format(($r->KD_PPJ/100),4);
		$STAND_BKR_LWBP	= number_format($r->STAND_BKR_LWBP,2);
		$STAND_BKR_WBP	= number_format($r->STAND_BKR_WBP,2);
		$STAND_BKR_KVARH= number_format($r->STAND_BKR_KVARH,2);
		$FKMETER        = $r->FK_METER;
		$FRT	        = $r->FRT;

		$RP_BP			= number_format($r->RP_BP);
		$RP_UJL_TAGIH	= number_format($r->RP_UJL_TAGIH);
		$RP_UJL_LAMA	= number_format($r->RP_UJL_LAMA);
		$RP_UJL_BARU	= number_format($r->RP_UJL_BARU);
		$MATERAI		= number_format($r->MATERAI);
		$TOTAL_BIAYA	= number_format($r->TOTAL_BIAYA);
		$TOTAL_BIAYAX	= $r->TOTAL_BIAYA;

		$SISA_RPLWBPX	= $r->SISA_RPLWBP;
		$SISA_RPWBPX	= $r->SISA_RPWBP;
		$SISA_RPKVARHX	= $r->SISA_RPKVARH;

		$ID_LANG_TUJUAN_BAYAR = $r->ID_LANG_TUJUAN_BAYAR;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;
	}

	$q = $this->db->query("SELECT RP_LWBP,RP_WBP,RP_KVARH FROM v_tr_tarif WHERE KD_TARIF = '$TARIF_BARU' ");
		foreach($q->result() as $r)
		{
			$TARIFLWBP = $r->RP_LWBP;
			$TARIFWBP  = $r->RP_WBP;
			$TARIFKVARH= $r->RP_KVARH;
		}

	$KECMOHON = $this->db->get_where('tr_kec', array('id_kec' => $KEC_MOHON))->row('nama');
	$KABMOHON = $this->db->get_where('tr_kab', array('id_kab' => $KOTA_MOHON))->row('nama');
	$PROVMOHON= $this->db->get_where('tr_prov', array('id_prov' => $PROV_MOHON))->row('nama');

	#$SISA_RPLWBP  = $SISA_RPLWBPX * $TARIFLWBP;
	#$SISA_RPWBP   = $SISA_RPWBPX * $TARIFWBP;
	#$SISA_RPKVARH = $SISA_RPKVARHX * $TARIFKVARH;
	$SISA_RPLWBP  = $SISA_RPLWBPX;
	$SISA_RPWBP   = $SISA_RPWBPX;
	$SISA_RPKVARH = $SISA_RPKVARHX;

	$TGL_TTD = tanggal_ttd($TGL_MOHON2);
	$TOTAL = ROUND($SISA_RPLWBP + $SISA_RPWBP + $SISA_RPKVARH);
	$PPJZ = ROUND($TOTAL * $PPJ);
	$TOTALKES = $TOTAL + $r->MATERAI + $PPJZ;

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$JNS_TRANSAKSIx = strtolower($JNS_TRANSAKSI);

	$q = $this->db->query("SELECT NAMA_LANG FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_TUJUAN_BAYAR' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->NAMA_LANG;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}elseif($POLA == '1'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}elseif($POLA == '2'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_TUJUAN_BAYAR. atas nama: $ATASNAMA.";
	}else{
		$teks = "Biaya tersebut diatas dapat dibayar melalui";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom>&nbsp;</td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='150' height='75' /></td>
			  </tr>
			  <tr>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
				<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>Nomor</td>
					<td>:</td>
					<td colspan=3>$NO_SIP</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Jakarta, ".tanggal_ttd(date('Y-m-d'))."</td>
				</tr>
				<tr>
					<td>Klasifikasi</td>
					<td>:</td>
					<td colspan=3>Penting</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Lampiran</td>
					<td>:</td>
					<td colspan=3>-</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Kepada,</td>
				</tr>
				<tr>
					<td>Perihal</td>
					<td>:</td>
					<td colspan=3>Persetujuan Permohonan</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>Yth.</td>
					<td>Bpk/Ibu $NAMA_MOHON</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=3>$JNS_TRANSAKSI</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>$ALAMAT_MOHON, $KECMOHON</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>di</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><u>$KABMOHON</u></td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>1.</td>
					<td colspan=7 style='text-align:justify;'>
						Sehubungan dengan permohonan $JNS_TRANSAKSIx yang telah Bapak/Ibu ajukan pada tanggal ".tanggal_ttd($TGL_MOHON2)." dengan No Agenda $NO_AGENDA, pada prinsipnya dapat kami setujui.
					</td>
				</tr>
				<tr>
					<td colspan=9>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>2.</td>
					<td colspan=7 style='text-align:justify;'>
						Menunjuk butir 1 (satu) diatas, dapat kami sampaikan data dan biaya sebagai berikut:
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>a.</td>
					<td colspan=6 style='text-align:justify;'>
						Data langganan :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nama</td>
					<td>:</td>
					<td colspan=3>
						$NAMA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Alamat</td>
					<td>:</td>
					<td colspan=3>
						$ALAMAT_LANG, $KEC_LANG - $KOTA_LANG
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Tarif / Daya Lama</td>
					<td>:</td>
					<td colspan=3>
						$TARIF_LAMA / $DAYA_LAMA VA
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>b.</td>
					<td colspan=6 style='text-align:justify;'>
						Tagihan sisa pemakaian tenaga listrik :
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>LWBP</td>
					<td>:</td>
					<td align=right>
						".number_format($SISA_RPLWBP)."
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>WBP</td>
					<td>:</td>
					<td align=right>
						".number_format($SISA_RPWBP)."
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Kelebihan KVARH</td>
					<td>:</td>
					<td align=right>
						".number_format($SISA_RPKVARH)."
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Jumlah</td>
					<td>:</td>
					<td  style='border-top:1px solid;' align=right>
						".number_format($TOTAL)."
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>PPJ</td>
					<td>:</td>
					<td align=right>
						".number_format($PPJZ)."
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Meterai</td>
					<td>:</td>
					<td align=right>
						$MATERAI
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><b>Total Biaya (Rp.)</b></td>
					<td>:</td>
					<td style='border-top:1px solid;' align=right>
						<b>".number_format($TOTALKES)."</b>
					</td>
					<td colspan=2>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td colspan=5>(".ucfirst($this->terbilang($TOTALKES)).")</td>
				</tr>";
	if($POLA == '0'){
	$Rpt .="	<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Rekening Bank</td>
					<td>:</td>
					<td colspan=3>
						Bank Bukopin
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Nomor Rekening</td>
					<td>:</td>
					<td colspan=3>
						1000406488
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>-</td>
					<td>Atas Nama</td>
					<td>:</td>
					<td colspan=3>
						PT ENERGI PELABUHAN INDONESIA
					</td>
				</tr>";
	}else{
	$Rpt .=		"<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>c.</td>
					<td colspan=6 style='text-align:justify;'>
						$teks
					</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td valign=top>d.</td>
					<td colspan=6 style='text-align:justify;'>
						Permohonan ini hanya berlaku maksimal 1 bulan, dihitung setelah permohonan ini terbit.
					</td>
				</tr>";
	}
	$Rpt .=		"<tr>
					<td width=10%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=25%>&nbsp;</td>
					<td width=1%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=2%>&nbsp;</td>
					<td width=30%>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td valign=top>3.</td>
					<td colspan=7 style='text-align:justify;'>
						Demikian disampaikan, atas perhatian diucapkan terima kasih.
					</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>PT ENERGI PELABUHAN INDONESIA</td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center>MANAGER NIAGA</td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp; <br/><br/><br/></td>
				</tr>
				<tr>
					<td colspan=7>&nbsp;</td>
					<td colspan=2 align=center><b><u>MULYONO</u></b></td>
				</tr>
				<tr>
					<td colspan=9 style='font-size:12px;'>&nbsp;</td>
				</tr>
			</table>";
	$Rpt .="<table width=100% border=0 style=font-size:9px; cellpadding=0px; cellspacing=0px>
				<tr>
					<td colspan=6 style='font-size:9px;'>PT ENERGI PELABUHAN INDONESIA<br>Jl.Yos Sudarso No. 30, Tanjung Priok, Jakarta Utara 14320</td>
				</tr>
				<tr>
					<td width=6%> Telepon</td>
					<td width=0.5%>:</td>
					<td width=94%>(021) 4305047</td>
				</tr>
				<tr>
				  <td>Fax</td>
				  <td>:</td>
				  <td>(021) 4305052</td>
				</tr>
				<tr>
				  <td>Website</td>
				  <td>:</td>
				  <td>www.ecopowerport.co.id</td>
				</tr>
				<tr>
				  <td>Email</td>
				  <td>:</td>
				  <td>cs@ecopowerport.co.id</td>
				</tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan SIP $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	if($STATUS_MOHON < '4'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='4' WHERE NO_AGENDA='$NO_AGENDA' ");
	}

	#JIKA TIDAK ADA BIAYA YANG HARUS DIBAYAR MAKA STATUS MOHON SAMPAI LUNAS
	if($TOTALKES == '0' ){
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='5', TGL_BAYAR='$sekarang' WHERE NO_AGENDA='$NO_AGENDA' ");
	}

	$this->db->query("DELETE FROM EPI_CARGO.WS_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
	$this->db->query("INSERT INTO EPI_CARGO.WS_AGENDA (NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH)
						SELECT NO_AGENDA,NO_REG,TGL_MOHON,THBL_MOHON,ID_CUST,NAMA_MOHON,ALAMAT_MOHON,KEC_MOHON,KOTA_MOHON,PROV_MOHON,KDPOS_MOHON,TELP_MOHON,HP_MOHON,EMAIL_MOHON,IDENTITAS_MOHON,NO_IDENTITAS_MOHON,ID_LANG,NAMA_LANG,ALAMAT_LANG,KEC_LANG,KOTA_LANG,PROV_LANG,KDPOS_LANG,ASAL_MOHON,PAKET_SAR,PERUNTUKAN,TARIF_LAMA,DAYA_LAMA,TARIF_BARU,DAYA_BARU,JNS_TRANSAKSI,NO_BP,TGL_BP,RP_BP,NO_UJL,TGL_UJL,RP_UJL_LAMA,RP_UJL_BARU,RP_UJL_TAGIH,MATERAI,TOTAL_BIAYA,POLA_PEMBAYARAN,ID_LANG_TUJUAN_BAYAR,KOGOL,KD_PPJ,KD_JAMNYALA_EMIN,KD_TG,KD_BK,KD_BISNIS,KD_WILAYAH,KD_AREA,STATUS_PECAHAN,TGL_CTK_SURVEY,NO_SURVEY,NO_PANEL,KD_TRAFO_DIST,KD_GARDU,KD_PENYULANG,KD_TRAFO_GI,KD_GI,JNS_SM,FASA_SM,PJG_SM,SM_KE,TITIK_SM,PETUGAS_SURVEY,TGL_ENTRI_SURVEY,NO_SIP,TGL_CETAKSIP,TGL_BAYAR,JNS_PELUNASAN,LOKET_BAYAR,PETUGAS_LUNAS,NOREF,NO_KWITANSI,STATUS_CTK_KWITANSI,STATUS_CREATE_ID,TGL_CTK_PK,NO_PK,USER_CTK_PK,TGL_CTK_BA,NO_BA,USER_CTK_BA,TGL_NYALA,TEG_SAMBUNG,MERK_METER,TIPE_METER,NO_METER,FASA_METER,TGL_PSG_METER,THN_PROD_METER,THN_TERA_METER,TGL_PSG_PEMBATAS,MERK_PEMBATAS,TIPE_PEMBATAS,UKURAN_PEMBATAS,SETTING_PEMBATAS,FASA_PEMBATAS,TEG_PEMBATAS,TGL_PSG_CT,TGL_PSG_PT,I_PRIMER_CT,I_SEKUNDER_CT,V_PRIMER_PT,V_SEKUNDER_PT,TGL_BKR_STAND,STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,TGL_PSG_STAND,STAND_PSG_LWBP,STAND_PSG_WBP,STAND_PSG_KVARH,FK_METER,FRT,KOORDINATX,KOORDINATY,NOPEL,IDPEL_PLN,RP_SEWA_TRAFO,USER_ENTRI_PDL,TGL_UPDATE_MOHON,LAMA_MOHON,STATUS_MOHON,NO_PDL,TGL_PDL,KD_MUT,TGL_MUT,THBLMUT,TGL_AWAL,TGL_AKHIR,LAMA_WAKTU,KWH_PS,RPKWH_PS,RPBPJU_PS,RPJML_PS,SISA_RPLWBP,SISA_RPWBP,SISA_RPKVARH
						FROM EPI_DBX.TP_AGENDA WHERE NO_AGENDA='$NO_AGENDA' AND THBL_MOHON = '$THBL_MOHON' ");
}

public function rpt_pdl(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$ID_CUST		= $r->ID_CUST;
		$ID_LANG		= $r->ID_LANG;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...

		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$STATUS_MOHON   = $r->STATUS_MOHON;

		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$TARIF_BARU		= $r->TARIF_BARU;
		$DAYA_BARU		= $r->DAYA_BARU;
		$TARIF_LAMA		= $r->DAYA_LAMA;
		$DAYA_LAMA		= $r->DAYA_LAMA;
		$TGL_AWAL		= substr($r->TGL_AWAL,0,10);
		$TGL_AKHIR		= substr($r->TGL_AKHIR,0,10);
		$LAMA_WAKTU		= $r->LAMA_WAKTU;
		$POLA			= $r->POLA_PEMBAYARAN;

		$TGL_PDL		= substr($r->TGL_PDL,0,10);
		$NO_PDL			= $r->NO_PDL;
		$TGL_NYALA		= substr($r->TGL_NYALA,0,10);
		$KD_MUT			= $r->KD_MUT;

		$NO_BP			= $r->NO_BP;
		$NO_UJL			= $r->NO_UJL;
		$TGL_BP			= substr($r->TGL_BP,0,10);
		$TGL_UJL		= substr($r->TGL_UJL,0,10);

		$TGL_PSG_METER  = substr($r->TGL_PSG_METER,0,10);
		$MERK_METER		= $r->MERK_METER;
		$TIPE_METER		= $r->TIPE_METER;
		$NO_METER		= $r->NO_METER;
		$FASA_METER		= $r->FASA_METER;
		$THN_PROD_METER = $r->THN_PROD_METER;
		$THN_TERA_METER = $r->THN_TERA_METER;

		$TGL_PSG_PEMBATAS = substr($r->TGL_PSG_PEMBATAS,0,10);
		$MERK_PEMBATAS  = $r->MERK_PEMBATAS;
		$TIPE_PEMBATAS  = $r->TIPE_PEMBATAS;
		$UKURAN_PEMBATAS= $r->UKURAN_PEMBATAS;
		$FASA_PEMBATAS  = $r->FASA_PEMBATAS;
		$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
		$TEG_PEMBATAS	= $r->TEG_PEMBATAS;

		$TGL_PSG_CT		= substr($r->TGL_PSG_CT,0,10);
		$TGL_PSG_PT		= substr($r->TGL_PSG_PT,0,10);
		$I_PRIMER_CT	= $r->I_PRIMER_CT;
		$I_SEKUNDER_CT	= $r->I_SEKUNDER_CT;
		$V_PRIMER_PT	= $r->V_PRIMER_PT;
		$V_SEKUNDER_PT	= $r->V_SEKUNDER_PT;

		$STAND_BKR_LWBP = $r->STAND_BKR_LWBP;
		$STAND_BKR_WBP	= $r->STAND_BKR_WBP;
		$STAND_BKR_KVARH= $r->STAND_BKR_KVARH;
		$STAND_PSG_LWBP = $r->STAND_PSG_LWBP;
		$STAND_PSG_WBP	= $r->STAND_PSG_WBP;
		$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;

		$FK_METER		= $r->FK_METER;
		$FRT			= $r->FRT;
		$KOORDINATX		= $r->KOORDINATX;
		$KOORDINATY		= $r->KOORDINATY;

		$NO_PANEL		= $r->NO_PANEL;
		$SM_KE			= $r->SM_KE;
		$TITIK_SM		= $r->TITIK_SM;
		$KD_TRAFO_DIST	= $r->KD_TRAFO_DIST;
		$KD_GARDU		= $r->KD_GARDU;
		$KD_PENYULANG	= $r->KD_PENYULANG;
		$KD_TRAFO_GI	= $r->KD_TRAFO_GI;
		$KD_GI			= $r->KD_GI;
		$JNS_SM			= $r->JNS_SM;
		$PJG_SM			= $r->PJG_SM;

	}

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC
						FROM CUST a
						JOIN tr_prov b ON a.PROV_CUST = b.`id_prov`
						JOIN tr_kab c ON a.`KOTA_CUST` = c.`id_kab`
						JOIN tr_kec d ON a.`KEC_CUST` = d.`id_kec`
						WHERE ID_CUST = '$ID_CUST' ");
	foreach($q->result() as $r)
	{
		$NAMA_CUST		= $r->NAMA_CUST;
		$ALAMAT_CUST	= $r->ALAMAT_CUST;
		$KEC_CUST		= $r->KEC;
		$KOTA_CUST		= $r->KAB;
		$PROV_CUST		= $r->PROV;
	}

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC
						FROM DIL_LISTRIK_REF a
						JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
						JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
						JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
						WHERE ID_LANG = '$ID_LANG' ");
	foreach($q->result() as $r)
	{
		$NAMA_LAMA		= $r->NAMA_LANG;
		$ALAMAT_LAMA	= $r->ALAMAT_LANG;
		$KEC_LAMA		= $r->KEC;
		$KOTA_LAMA		= $r->KAB;
		$PROV_LAMA		= $r->PROV;
	}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$q = $this->db->query("SELECT NAMA,JABATAN FROM TR_JABATAN WHERE ID = '5' ");
	foreach($q->result() as $r)
	{
		$NAMATTD		= $r->NAMA;
		$JABATANTTD		= $r->JABATAN;
	}

	$SEWA_TRAFO    = '0';

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>PERUBAHAN DATA PELANGGAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center></center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=1 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td width=20%><center>Tanggal PDL</center></td>
				<td width=20%><center>No PDL</center></td>
				<td width=20%><center>Tanggal Nyala</center></td>
				<td width=20%><center>ID Langganan</center></td>
				<td width=20%><center>Kode Mutasi</center></td>
			  </tr>
			  <tr>
				<td><center>$TGL_PDL</center></td>
				<td><center>$NO_PDL</center></td>
				<td><center>$TGL_NYALA</center></td>
				<td><center>$ID_LANG</center></td>
				<td><center>$KD_MUT</center></td>
			  </tr>
			 </table><br>";
	if($JNS_TRANSAKSI == 'PASANG BARU'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'PERUBAHAN DAYA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td>Provinsi</td>
				<td>:</td>
				<td>&nbsp;$PROV_CUST</td>
				<td>&nbsp;Tarif Lama</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TARIF_LAMA</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Daya Lama</td>
				<td>:</td>
				<td>&nbsp;$DAYA_LAMA</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tarif Baru</td>
				<td>:</td>
				<td>&nbsp;$TARIF_BARU</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;Daya Baru</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$DAYA_BARU</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'BALIK NAMA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td >&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td>Provinsi</td>
				<td>:</td>
				<td>&nbsp;$PROV_CUST</td>
				<td>&nbsp;Lama Waktu</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$LAMA_WAKTU</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tanggal Awal</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TGL_AWAL</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tanggal Akhir</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TGL_AKHIR</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}else{
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}

	if($POLA == '0'){
		$q = $this->db->query("SELECT RP_BP,RP_UJL_TAGIH FROM TP_AGENDA WHERE ID_LANG = '$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r)
			{
				$RP_BP			= $r->RP_BP;
				$RP_BK			= '0';
				$RP_UJL			= $r->RP_UJL_TAGIH;
				$RP_KWH			= '0';
				$RP_P2TL		= '0';
				$RP_INVESTASI	= '0';
			}
		}else{
				$RP_BP			= '0';
				$RP_UJL			= '0';
				$RP_KWH			= '0';
				$RP_P2TL		= '0';
				$RP_INVESTASI	= '0';
		}
	}else{
		$q = $this->db->query("SELECT RP_BP,RP_UJL,RP_KWH,RP_P2TL,RP_INVESTASI FROM TP_ANGSURAN WHERE ID_LANG = '$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r)
			{
				$RP_BP			= $r->RP_BP;
				$RP_BK			= $r->RP_BK;
				$RP_UJL			= $r->RP_UJL;
				$RP_KWH			= $r->RP_KWH;
				$RP_P2TL		= $r->RP_P2TL;
				$RP_INVESTASI	= $r->RP_INVESTASI;
			}
		}else{
				$RP_BP			= '0';
				$RP_UJL			= '0';
				$RP_KWH			= '0';
				$RP_P2TL		= '0';
				$RP_INVESTASI	= '0';
		}
	}

	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Biaya</b></td>
			  </tr>
			  <tr>
				<td>No BP</td>
				<td>:</td>
				<td>&nbsp;$NO_BP</td>
				<td>No UJL</td>
				<td>:</td>
				<td>&nbsp;$NO_UJL</td>
			  </tr>
			  <tr>
				<td>Tanggal BP</td>
				<td>:</td>
				<td>&nbsp;$TGL_BP</td>
				<td>Tanggal UJL</td>
				<td>:</td>
				<td>&nbsp;$TGL_UJL</td>
			  </tr>

			  <tr>
				<td width=23%>Biaya Penyambungan</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;".number_format($RP_BP)."</td>
				<td width=15%>P2TL</td>
				<td width=1%>:</td>
				<td width=34%>&nbsp;".number_format($RP_P2TL)."</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Uang Jaminan Langganan</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($RP_UJL)."</td>
				<td style='border-bottom:1px solid;'>Sewa Trafo</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data KWH</b></td>
			  </tr>
			  <tr>
				<td width=23%>Tanggal Pasang Meter</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;$TGL_PSG_METER</td>
				<td width=23%>Fasa Meter</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;$FASA_METER</td>
			  </tr>
			  <tr>
				<td>Merk Meter</td>
				<td>:</td>
				<td>&nbsp;$MERK_METER</td>
				<td>Tahun Produksi Meter</td>
				<td>:</td>
				<td>&nbsp;$THN_PROD_METER</td>
			  </tr>
			  <tr>
				<td>Tipe Meter</td>
				<td>:</td>
				<td>&nbsp;$TIPE_METER</td>
				<td>Tahun tera Meter</td>
				<td>:</td>
				<td>&nbsp;$THN_TERA_METER</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>No Meter</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$NO_METER</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data Pembatas</b></td>
			  </tr>
			  <tr>
				<td>Tanggal Pasang Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_PEMBATAS</td>
				<td>Fasa Pembatas</td>
				<td>:</td>
				<td>&nbsp;$FASA_PEMBATAS</td>
			  </tr>
			  <tr>
				<td>Merk Pembatas</td>
				<td>:</td>
				<td>&nbsp;$MERK_PEMBATAS</td>
				<td>Setting Pembatas</td>
				<td>:</td>
				<td>&nbsp;$SETTING_PEMBATAS</td>
			  </tr>
			  <tr>
				<td>Tipe Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TIPE_PEMBATAS</td>
				<td>Tegangan Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TEG_PEMBATAS</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Ukuran Pembatas</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$UKURAN_PEMBATAS</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>CT dan PT</b></td>
			  </tr>
			  <tr>
				<td>Tanggal Pasang CT</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_CT</td>
				<td>Tanggal Pasang PT</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_PT</td>
			  </tr>
			  <tr>
				<td>I Primer CT</td>
				<td>:</td>
				<td>&nbsp;$I_PRIMER_CT</td>
				<td>V Primer PT</td>
				<td>:</td>
				<td>&nbsp;$V_PRIMER_PT</td>
			  </tr>
			  <tr>
				<td>I Sekunder CT</td>
				<td>:</td>
				<td>&nbsp;$I_SEKUNDER_CT</td>
				<td>V Sekunder PT</td>
				<td>:</td>
				<td>&nbsp;$V_SEKUNDER_PT</td>
			  </tr>
			  <tr>
				<td colspan=3><b>Stand Bongkar</b></td>
				<td colspan=3><b>Stand Pasang</b></td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td>Stand Bongkar LWBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_BKR_LWBP)."</td>
				<td>Stand Pasang LWBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_PSG_LWBP)."</td>
			  </tr>
			  <tr>
				<td>Stand Bongkar WBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_BKR_WBP)."</td>
				<td>Stand Pasang WBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_PSG_WBP)."</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Stand Bongkar KVARH</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($STAND_BKR_KVARH)."</td>
				<td style='border-bottom:1px solid;'>Stand Pasang KVARH</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($STAND_PSG_KVARH)."</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=3><b>FRT dan FK Meter</b></td>
				<td  colspan=3><b>Koordinat</b></td>
			  </tr>
			  <tr>
				<td>FK Meter</td>
				<td>:</td>
				<td>&nbsp;$FK_METER</td>
				<td>Koordinat X</td>
				<td>:</td>
				<td>&nbsp;$KOORDINATX</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>FRT</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$FRT</td>
				<td style='border-bottom:1px solid;'>Koordinat Y</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$KOORDINATY</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data Suplai</b></td>
			  </tr>
			  <tr>
				<td>No Panel</td>
				<td>:</td>
				<td>&nbsp;$NO_PANEL</td>
				<td>Sambungan Ke</td>
				<td>:</td>
				<td>&nbsp;$SM_KE</td>
			  </tr>
			  <tr>
				<td>Kode Trafo Dist</td>
				<td>:</td>
				<td>&nbsp;$KD_TRAFO_DIST</td>
				<td>Titik Sambungan</td>
				<td>:</td>
				<td>&nbsp;$TITIK_SM</td>
			  </tr>
			  <tr>
				<td>Kode Gardu</td>
				<td>:</td>
				<td>&nbsp;$KD_GARDU</td>
				<td>Jenis Sambungan</td>
				<td>:</td>
				<td>&nbsp;$JNS_SM</td>
			  </tr>
			  <tr>
				<td>Kode Penyulang</td>
				<td>:</td>
				<td>&nbsp;$KD_PENYULANG</td>
				<td>Panjang Sambungan</td>
				<td>:</td>
				<td>&nbsp;$PJG_SM</td>
			  </tr>
			  <tr>
				<td>Kode Trafo GI</td>
				<td>:</td>
				<td>&nbsp;$KD_TRAFO_GI</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Kode GI</td>
				<td>:</td>
				<td>&nbsp;$KD_GI</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td width=14%>&nbsp;</td>
				<td width=17%>&nbsp;</td>
				<td width=19%>&nbsp;</td>
				<td width=16%>&nbsp;</td>
				<td width=19%>&nbsp;</td>
				<td width=15%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3><center>$JABATANTTD</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3><center>$NAMATTD</center></td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan PDL $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	if($STATUS_MOHON < '8'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='8' WHERE NO_AGENDA='$NO_AGENDA' ");
	}

}


public function rpt_pdl_nonmohon(){
	$cetak		= $this->uri->segment(3);
	$id_lang 	= $this->uri->segment(4);
	$pdl 		= $this->uri->segment(5);

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							WHERE id_lang = '$id_lang' AND no_pdl = '$pdl' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$ID_CUST		= $r->ID_CUST;
		$ID_LANG		= $r->ID_LANG;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...

		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$STATUS_MOHON   = $r->STATUS_MOHON;

		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$TARIF_BARU		= $r->TARIF_BARU;
		$DAYA_BARU		= $r->DAYA_BARU;
		$TARIF_LAMA		= $r->DAYA_LAMA;
		$DAYA_LAMA		= $r->DAYA_LAMA;
		$TGL_AWAL		= substr($r->TGL_AWAL,0,10);
		$TGL_AKHIR		= substr($r->TGL_AKHIR,0,10);
		$LAMA_WAKTU		= $r->LAMA_WAKTU;
		$POLA			= $r->POLA_PEMBAYARAN;

		$TGL_PDL		= substr($r->TGL_PDL,0,10);
		$NO_PDL			= $r->NO_PDL;
		$TGL_NYALA		= substr($r->TGL_NYALA,0,10);
		$KD_MUT			= $r->KD_MUT;

		$NO_BP			= $r->NO_BP;
		$NO_UJL			= $r->NO_UJL;
		$TGL_BP			= substr($r->TGL_BP,0,10);
		$TGL_UJL		= substr($r->TGL_UJL,0,10);

		$TGL_PSG_METER  = substr($r->TGL_PSG_METER,0,10);
		$MERK_METER		= $r->MERK_METER;
		$TIPE_METER		= $r->TIPE_METER;
		$NO_METER		= $r->NO_METER;
		$FASA_METER		= $r->FASA_METER;
		$THN_PROD_METER = $r->THN_PROD_METER;
		$THN_TERA_METER = $r->THN_TERA_METER;

		$TGL_PSG_PEMBATAS = substr($r->TGL_PSG_PEMBATAS,0,10);
		$MERK_PEMBATAS  = $r->MERK_PEMBATAS;
		$TIPE_PEMBATAS  = $r->TIPE_PEMBATAS;
		$UKURAN_PEMBATAS= $r->UKURAN_PEMBATAS;
		$FASA_PEMBATAS  = $r->FASA_PEMBATAS;
		$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
		$TEG_PEMBATAS	= $r->TEG_PEMBATAS;

		$TGL_PSG_CT		= substr($r->TGL_PSG_CT,0,10);
		$TGL_PSG_PT		= substr($r->TGL_PSG_PT,0,10);
		$I_PRIMER_CT	= $r->I_PRIMER_CT;
		$I_SEKUNDER_CT	= $r->I_SEKUNDER_CT;
		$V_PRIMER_PT	= $r->V_PRIMER_PT;
		$V_SEKUNDER_PT	= $r->V_SEKUNDER_PT;

		$STAND_BKR_LWBP = $r->STAND_BKR_LWBP;
		$STAND_BKR_WBP	= $r->STAND_BKR_WBP;
		$STAND_BKR_KVARH= $r->STAND_BKR_KVARH;
		$STAND_PSG_LWBP = $r->STAND_PSG_LWBP;
		$STAND_PSG_WBP	= $r->STAND_PSG_WBP;
		$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;

		$FK_METER		= $r->FK_METER;
		$FRT			= $r->FRT;
		$KOORDINATX		= $r->KOORDINATX;
		$KOORDINATY		= $r->KOORDINATY;

		$NO_PANEL		= $r->NO_PANEL;
		$SM_KE			= $r->SM_KE;
		$TITIK_SM		= $r->TITIK_SM;
		$KD_TRAFO_DIST	= $r->KD_TRAFO_DIST;
		$KD_GARDU		= $r->KD_GARDU;
		$KD_PENYULANG	= $r->KD_PENYULANG;
		$KD_TRAFO_GI	= $r->KD_TRAFO_GI;
		$KD_GI			= $r->KD_GI;
		$JNS_SM			= $r->JNS_SM;
		$PJG_SM			= $r->PJG_SM;

	}

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC
						FROM CUST a
						JOIN tr_prov b ON a.PROV_CUST = b.`id_prov`
						JOIN tr_kab c ON a.`KOTA_CUST` = c.`id_kab`
						JOIN tr_kec d ON a.`KEC_CUST` = d.`id_kec`
						WHERE ID_CUST = '$ID_CUST' ");
	foreach($q->result() as $r)
	{
		$NAMA_CUST		= $r->NAMA_CUST;
		$ALAMAT_CUST	= $r->ALAMAT_CUST;
		$KEC_CUST		= $r->KEC;
		$KOTA_CUST		= $r->KAB;
		$PROV_CUST		= $r->PROV;
	}

	$q = $this->db->query("SELECT a.*,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC
						FROM DIL_LISTRIK_REF a
						JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
						JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
						JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
						WHERE ID_LANG = '$ID_LANG' ");
	foreach($q->result() as $r)
	{
		$NAMA_LAMA		= $r->NAMA_LANG;
		$ALAMAT_LAMA	= $r->ALAMAT_LANG;
		$KEC_LAMA		= $r->KEC;
		$KOTA_LAMA		= $r->KAB;
		$PROV_LAMA		= $r->PROV;
	}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$q = $this->db->query("SELECT NAMA,JABATAN FROM TR_JABATAN WHERE ID = '5' ");
	foreach($q->result() as $r)
	{
		$NAMATTD		= $r->NAMA;
		$JABATANTTD		= $r->JABATAN;
	}

	$SEWA_TRAFO    = '0';

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>PERUBAHAN DATA PELANGGAN $JNS_TRANSAKSI</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center></center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=1 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td width=20%><center>Tanggal PDL</center></td>
				<td width=20%><center>No PDL</center></td>
				<td width=20%><center>Tanggal Nyala</center></td>
				<td width=20%><center>ID Langganan</center></td>
				<td width=20%><center>Kode Mutasi</center></td>
			  </tr>
			  <tr>
				<td><center>$TGL_PDL</center></td>
				<td><center>$NO_PDL</center></td>
				<td><center>$TGL_NYALA</center></td>
				<td><center>$ID_LANG</center></td>
				<td><center>$KD_MUT</center></td>
			  </tr>
			 </table><br>";
	if($JNS_TRANSAKSI == 'PASANG BARU'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'PERUBAHAN DAYA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td>Provinsi</td>
				<td>:</td>
				<td>&nbsp;$PROV_CUST</td>
				<td>&nbsp;Tarif Lama</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TARIF_LAMA</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Daya Lama</td>
				<td>:</td>
				<td>&nbsp;$DAYA_LAMA</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tarif Baru</td>
				<td>:</td>
				<td>&nbsp;$TARIF_BARU</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;Daya Baru</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$DAYA_BARU</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'BALIK NAMA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td >&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td>Provinsi</td>
				<td>:</td>
				<td>&nbsp;$PROV_CUST</td>
				<td>&nbsp;Lama Waktu</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$LAMA_WAKTU</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tanggal Awal</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TGL_AWAL</td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;Tanggal Akhir</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$TGL_AKHIR</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'></td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}else{
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6><b>Data Administratif</b></td>
			  </tr>
			  <tr>
				<td width=16%><b>Customer</b></td>
				<td width=1%>&nbsp;</td>
				<td width=33%>&nbsp;</td>
				<td width=15%>&nbsp;<b>Langganan</b></td>
				<td width=1%>&nbsp;</td>
				<td width=34%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Customer</td>
				<td>:</td>
				<td>&nbsp;$ID_CUST</td>
				<td valign=top>&nbsp;Nama</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Nama</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$NAMA_CUST</td>
				<td valign=top>&nbsp;Alamat</td>
				<td valign=top>&nbsp;:</td>
				<td valign=top>&nbsp;$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td valign=top>Alamat</td>
				<td valign=top>:</td>
				<td valign=top>&nbsp;$ALAMAT_CUST</td>
				<td>&nbsp;Kecamatan</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KEC_LANG</td>
			  </tr>
			  <tr>
				<td>Kecamatan</td>
				<td>:</td>
				<td>&nbsp;$KEC_CUST</td>
				<td>&nbsp;Kota</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$KOTA_LANG</td>
			  </tr>
			  <tr>
				<td>Kota</td>
				<td>:</td>
				<td>&nbsp;$KOTA_CUST</td>
				<td>&nbsp;Provinsi</td>
				<td>&nbsp;:</td>
				<td>&nbsp;$PROV_LANG</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Provinsi</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$PROV_CUST</td>
				<td style='border-bottom:1px solid;'>&nbsp;Tarif / Daya</td>
				<td style='border-bottom:1px solid;'>&nbsp;:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$TARIF_BARU / $DAYA_BARU</td>
			  </tr>
			</table>";
	}

		$q = $this->db->query("SELECT RP_BP,RP_UJL_TAGIH FROM TP_AGENDA WHERE ID_LANG = '$ID_LANG' AND NO_PDL = '$pdl' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r)
			{
				$RP_BP			= $r->RP_BP;
				$RP_BK			= '0';
				$RP_UJL			= $r->RP_UJL_TAGIH;
				$RP_KWH			= '0';
				$RP_P2TL		= '0';
				$RP_INVESTASI	= '0';
			}
		}else{
				$RP_BP			= '0';
				$RP_UJL			= '0';
				$RP_KWH			= '0';
				$RP_P2TL		= '0';
				$RP_INVESTASI	= '0';
		}


	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Biaya</b></td>
			  </tr>
			  <tr>
				<td>No BP</td>
				<td>:</td>
				<td>&nbsp;$NO_BP</td>
				<td>No UJL</td>
				<td>:</td>
				<td>&nbsp;$NO_UJL</td>
			  </tr>
			  <tr>
				<td>Tanggal BP</td>
				<td>:</td>
				<td>&nbsp;$TGL_BP</td>
				<td>Tanggal UJL</td>
				<td>:</td>
				<td>&nbsp;$TGL_UJL</td>
			  </tr>

			  <tr>
				<td width=23%>Biaya Penyambungan</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;".number_format($RP_BP)."</td>
				<td width=15%>P2TL</td>
				<td width=1%>:</td>
				<td width=34%>&nbsp;".number_format($RP_P2TL)."</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Uang Jaminan Langganan</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($RP_UJL)."</td>
				<td style='border-bottom:1px solid;'>Sewa Trafo</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data KWH</b></td>
			  </tr>
			  <tr>
				<td width=23%>Tanggal Pasang Meter</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;$TGL_PSG_METER</td>
				<td width=23%>Fasa Meter</td>
				<td width=1%>:</td>
				<td width=26%>&nbsp;$FASA_METER</td>
			  </tr>
			  <tr>
				<td>Merk Meter</td>
				<td>:</td>
				<td>&nbsp;$MERK_METER</td>
				<td>Tahun Produksi Meter</td>
				<td>:</td>
				<td>&nbsp;$THN_PROD_METER</td>
			  </tr>
			  <tr>
				<td>Tipe Meter</td>
				<td>:</td>
				<td>&nbsp;$TIPE_METER</td>
				<td>Tahun tera Meter</td>
				<td>:</td>
				<td>&nbsp;$THN_TERA_METER</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>No Meter</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$NO_METER</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data Pembatas</b></td>
			  </tr>
			  <tr>
				<td>Tanggal Pasang Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_PEMBATAS</td>
				<td>Fasa Pembatas</td>
				<td>:</td>
				<td>&nbsp;$FASA_PEMBATAS</td>
			  </tr>
			  <tr>
				<td>Merk Pembatas</td>
				<td>:</td>
				<td>&nbsp;$MERK_PEMBATAS</td>
				<td>Setting Pembatas</td>
				<td>:</td>
				<td>&nbsp;$SETTING_PEMBATAS</td>
			  </tr>
			  <tr>
				<td>Tipe Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TIPE_PEMBATAS</td>
				<td>Tegangan Pembatas</td>
				<td>:</td>
				<td>&nbsp;$TEG_PEMBATAS</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Ukuran Pembatas</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$UKURAN_PEMBATAS</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
				<td style='border-bottom:1px solid;'>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>CT dan PT</b></td>
			  </tr>
			  <tr>
				<td>Tanggal Pasang CT</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_CT</td>
				<td>Tanggal Pasang PT</td>
				<td>:</td>
				<td>&nbsp;$TGL_PSG_PT</td>
			  </tr>
			  <tr>
				<td>I Primer CT</td>
				<td>:</td>
				<td>&nbsp;$I_PRIMER_CT</td>
				<td>V Primer PT</td>
				<td>:</td>
				<td>&nbsp;$V_PRIMER_PT</td>
			  </tr>
			  <tr>
				<td>I Sekunder CT</td>
				<td>:</td>
				<td>&nbsp;$I_SEKUNDER_CT</td>
				<td>V Sekunder PT</td>
				<td>:</td>
				<td>&nbsp;$V_SEKUNDER_PT</td>
			  </tr>
			  <tr>
				<td colspan=3><b>Stand Bongkar</b></td>
				<td colspan=3><b>Stand Pasang</b></td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td>Stand Bongkar LWBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_BKR_LWBP)."</td>
				<td>Stand Pasang LWBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_PSG_LWBP)."</td>
			  </tr>
			  <tr>
				<td>Stand Bongkar WBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_BKR_WBP)."</td>
				<td>Stand Pasang WBP</td>
				<td>:</td>
				<td>&nbsp;".number_format($STAND_PSG_WBP)."</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>Stand Bongkar KVARH</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($STAND_BKR_KVARH)."</td>
				<td style='border-bottom:1px solid;'>Stand Pasang KVARH</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;".number_format($STAND_PSG_KVARH)."</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=3><b>FRT dan FK Meter</b></td>
				<td  colspan=3><b>Koordinat</b></td>
			  </tr>
			  <tr>
				<td>FK Meter</td>
				<td>:</td>
				<td>&nbsp;$FK_METER</td>
				<td>Koordinat X</td>
				<td>:</td>
				<td>&nbsp;$KOORDINATX</td>
			  </tr>
			  <tr>
				<td style='border-bottom:1px solid;'>FRT</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$FRT</td>
				<td style='border-bottom:1px solid;'>Koordinat Y</td>
				<td style='border-bottom:1px solid;'>:</td>
				<td style='border-bottom:1px solid;'>&nbsp;$KOORDINATY</td>
			  </tr>
			  <tr>
				<td colspan=6 height=5px></td>
			  </tr>
			  <tr>
				<td colspan=6><b>Data Suplai</b></td>
			  </tr>
			  <tr>
				<td>No Panel</td>
				<td>:</td>
				<td>&nbsp;$NO_PANEL</td>
				<td>Sambungan Ke</td>
				<td>:</td>
				<td>&nbsp;$SM_KE</td>
			  </tr>
			  <tr>
				<td>Kode Trafo Dist</td>
				<td>:</td>
				<td>&nbsp;$KD_TRAFO_DIST</td>
				<td>Titik Sambungan</td>
				<td>:</td>
				<td>&nbsp;$TITIK_SM</td>
			  </tr>
			  <tr>
				<td>Kode Gardu</td>
				<td>:</td>
				<td>&nbsp;$KD_GARDU</td>
				<td>Jenis Sambungan</td>
				<td>:</td>
				<td>&nbsp;$JNS_SM</td>
			  </tr>
			  <tr>
				<td>Kode Penyulang</td>
				<td>:</td>
				<td>&nbsp;$KD_PENYULANG</td>
				<td>Panjang Sambungan</td>
				<td>:</td>
				<td>&nbsp;$PJG_SM</td>
			  </tr>
			  <tr>
				<td>Kode Trafo GI</td>
				<td>:</td>
				<td>&nbsp;$KD_TRAFO_GI</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Kode GI</td>
				<td>:</td>
				<td>&nbsp;$KD_GI</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 cellspacing=0 cellpadding=0 style='font-size:11px;'>
			  <tr>
				<td width=14%>&nbsp;</td>
				<td width=17%>&nbsp;</td>
				<td width=19%>&nbsp;</td>
				<td width=16%>&nbsp;</td>
				<td width=19%>&nbsp;</td>
				<td width=15%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3><center>$JABATANTTD</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3><center>$NAMATTD</center></td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan PDL $NO_AGENDA $ID_LANG";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	if($STATUS_MOHON < '8'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='8' WHERE NO_AGENDA='$NO_AGENDA' ");
	}

}


public function rpt_kwitansipt(){
	$cetak		= $this->uri->segment(3);
	$no_agenda 	= $this->uri->segment(4);

	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='8' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}

	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,DATE(TGL_BAYAR) TGL_BAYAR2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA = '$no_agenda' ");
	foreach($q->result() as $r)
	{
		$NO_AGENDA		= $r->NO_AGENDA;
		$KD_AREA		= $r->KD_AREA; //88201 --> HPL PELABUHAN ...Tanjung Priok...
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$KEC_LANG		= $r->KEC;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$TELP			= $r->TELP_MOHON;
		$HP				= $r->HP_MOHON;
		$EMAIL			= $r->EMAIL_MOHON;
		$KOGOL			= $r->KOGOL;
		$POLA			= $r->POLA_PEMBAYARAN;
		$ID_LANG_LAIN	= $r->ID_LANG_TUJUAN_BAYAR;

		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$STATUS_MOHON	= $r->STATUS_MOHON;
		$ID_CUST		= $r->ID_CUST;
		$TARIF_BARU		= $r->TARIF_BARU;
		$TARIF_LAMA		= $r->TARIF_LAMA;
		$DAYA_BARU		= $r->DAYA_BARU;
		$DAYA_LAMA		= (empty($r->DAYA_LAMA)) ? '0' : $r->DAYA_LAMA ;
		$PERUNTUKAN		= $r->PERUNTUKAN;

		$NO_KWITANSI	= $r->NO_KWITANSI;

		$IDENTITAS_MOHON	= $r->IDENTITAS_MOHON;
		$NO_IDENTITAS_MOHON	= $r->NO_IDENTITAS_MOHON;

		$TGL_BAYAR2		= $r->TGL_BAYAR2;

		$RP_BP			= $r->RP_BP;
		$RP_UJL_TAGIH   = $r->RP_UJL_TAGIH;
		$MATERAI		= $r->MATERAI;

		$RPKWH_PS		= $r->RPKWH_PS;
		$RPBPJU_PS		= $r->RPBPJU_PS;
		$RPJML_PS		= $r->RPJML_PS;

		$STAND_BKR_LWBP  = $r->STAND_BKR_LWBP;
		$STAND_BKR_WBP   = $r->STAND_BKR_WBP;
		$STAND_BKR_KVARH = $r->STAND_BKR_KVARH;

		$PPJ			= ($r->KD_PPJ/100);
		$SISA_RPLWBPX	= $r->SISA_RPLWBP;
		$SISA_RPWBPX	= $r->SISA_RPWBP;
		$SISA_RPKVARHX	= $r->SISA_RPKVARH;
		$PPJ_BONGKAR	= $r->SISA_RPBPJU;
		$MATERAI_BONGKAR= $r->SISA_METERAI;
		$TOTAL_BONGKAR  = $r->SISA_RPTAG;
	}

		$TOTALSATU = $RP_BP + $RP_UJL_TAGIH + $MATERAI;
		$TOTALDUA  = $RPKWH_PS + $RP_BP + $RPBPJU_PS + $MATERAI;


	$TGL_TTD = tanggal_ttd($TGL_BAYAR2);

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	#AMBIL GOLONGAN
	$q = $this->db->query("
							SELECT * FROM TR_GOLONGAN WHERE kd_gol = '".$KOGOL."'
							");
	foreach($q->result() as $r)
	{
		$URAIAN		= $r->uraian;
	}

	$q = $this->db->query("SELECT NAMA_LANG ATASNAMA FROM DIL_LISTRIK_REF WHERE ID_LANG = '$ID_LANG_LAIN' ");
	if($q->num_rows() > 0){
		foreach($q->result() as $r){
			$ATASNAMA = $r->ATASNAMA;
		}
	}else{
			$ATASNAMA = '';
	}

	if($POLA == '0'){
		$teks = "";
	}elseif($POLA == '1'){
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik bulan pertama.";
	}else{
		$teks = "Sesuai permintaan Pemohon, biaya tersebut diatas akan ditagihkan melalui tagihan rekening listrik ID Langganan: $ID_LANG_LAIN. atas nama: $ATASNAMA.";
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:6px;' >&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>K U I T A N S I</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. $NO_KWITANSI</center></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td height=5px width=20%></td>
				<td width=1%></td>
				<td width=30%></td>
				<td width=4%></td>
				<td width=20%></td>
				<td width=5%></td>
				<td width=20%></td>
			  </tr>
			  <tr>
				<td >Diterima dari</td>
				<td >:</td>
				<td colspan=2>$NAMA_LANG</td>
				<td ></td>
				<td ></td>
				<td >&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td valign=top>:</td>
				<td colspan=5 valign=top>$ALAMAT_LANG</td>
			  </tr>";

	if($JNS_TRANSAKSI == 'PASANG BARU' OR $JNS_TRANSAKSI == 'PERUBAHAN DAYA' OR $JNS_TRANSAKSI == 'BALIK NAMA' ){
	$Rpt .= "<tr>
				<td >Uang Sejumlah</td>
				<td >:</td>
				<td colspan=2 bgcolor=#CCCCCC>Rp &nbsp;".number_format($TOTALSATU).".-</td>
				<td></td>
				<td></td>
				<td></td>
			  </tr>
			  <tr>
				<td>Terbilang</td>
				<td>:</td>
				<td colspan=5 bgcolor=#CCCCCC>".ucfirst($this->terbilang($TOTALSATU))."<br /></td>
			  </tr>
			  <tr>
				<td height=5px></td>
				<td></td>
				<td colspan=5></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=7>Untuk Pembayaran $JNS_TRANSAKSI No Agenda: $NO_AGENDA, dengan rincian sebagai berikut: </td>
			  </tr>
			  <tr>
				<td height=5px width=30%></td>
				<td width=2%></td>
				<td width=10%></td>
				<td width=3%></td>
				<td width=5%></td>
				<td width=23%></td>
				<td width=27%></td>
			  </tr>
			  <tr>
				<td>Biaya Penyambungan</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($RP_BP)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>UJL</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($RP_UJL_TAGIH)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya Materai</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($MATERAI)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Total</td>
				<td>:Rp.</td>
				<td colspan=2 style='border-top:1px solid;' align=right>".number_format($TOTALSATU)."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Jakarta, ".$TGL_TTD."</td>
			  </tr>
			  </table>";
	}elseif($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
	$Rpt .= "<tr>
				<td>Uang Sejumlah</td>
				<td>:</td>
				<td colspan=2 bgcolor=#CCCCCC>Rp &nbsp;".number_format($TOTALDUA).".-</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Terbilang</td>
				<td>:</td>
				<td colspan=5 bgcolor=#CCCCCC>".ucfirst($this->terbilang($TOTALDUA))."<br /></td>
			  </tr>
			  <tr>
				<td height=5px></td>
				<td></td>
				<td colspan=5></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=7>Untuk Pembayaran $JNS_TRANSAKSI No Agenda: $NO_AGENDA, dengan rincian sebagai berikut: </td>
			  </tr>
			  <tr>
				<td height=5px width=30%></td>
				<td width=2%></td>
				<td width=10%></td>
				<td width=3%></td>
				<td width=5%></td>
				<td width=23%></td>
				<td width=27%></td>
			  </tr>
			  <tr>
				<td>Biaya KWH</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($RPKWH_PS)."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya Material</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($RP_BP)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya BPJU</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($RPBPJU_PS)."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya Materai</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($MATERAI)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Total</td>
				<td>:Rp</td>
				<td colspan=2 style='border-top:1px solid;' align=right>".number_format($TOTALDUA)."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Jakarta, ".$TGL_TTD."</td>
			  </tr>
			  </table>";
	}else{
	$Rpt .= "<tr>
				<td>Uang Sejumlah</td>
				<td>:</td>
				<td colspan=2 bgcolor=#CCCCCC>Rp &nbsp;".number_format($TOTAL_BONGKAR).".-</td>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Terbilang</td>
				<td>:</td>
				<td colspan=5 bgcolor=#CCCCCC>".ucfirst($this->terbilang($TOTAL_BONGKAR))."<br /></td>
			  </tr>
			  <tr>
				<td height=5px></td>
				<td></td>
				<td colspan=5></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=7>Untuk Pembayaran $JNS_TRANSAKSI No Agenda: $NO_AGENDA, dengan rincian sebagai berikut: </td>
			  </tr>
			  <tr >
				<td height=5px width=30%></td>
				<td width=2%></td>
				<td width=10%></td>
				<td width=3%></td>
				<td width=5%></td>
				<td width=23%></td>
				<td width=27%></td>
			  </tr>
			  <tr>
				<td>Biaya LWBP</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($SISA_RPLWBPX)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya WBP</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($SISA_RPWBPX)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya KVARH</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($SISA_RPKVARHX)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Biaya PPJ</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($PPJ_BONGKAR)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>

			  <tr>
				<td>Biaya Materai</td>
				<td>:Rp</td>
				<td colspan=2 align=right>".number_format($MATERAI_BONGKAR)."</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Total</td>
				<td>:Rp</td>
				<td colspan=2 style='border-top:1px solid;' align=right>".number_format($TOTAL_BONGKAR)."</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>Jakarta, ".$TGL_TTD."</td>
			  </tr>
			  </table>";
	}
	$Rpt .= "<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=3>&nbsp;$teks</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
			  </tr>
			  <tr>
				<td colspan=5></td>
				<td>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5 style='font-size:9px;'></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5> </td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
			  </tr>
			  <tr>
				<td colspan=5 style='font-size:9px;'>*Bea Materai sesuai Kep Dirjen pajak no Kep-122d/PJ/2000 tanggal 1 Mei 2010</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
				<td>&nbsp;</td>
				<td></td>
			  </tr>
			</table>";
	$arsip = "<pagebreak><br>Arsip PT EPI";
	$SenD["TitlE"]	= "Cetakan Kuitansi PT $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt.$arsip.$Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	$this->db->query("UPDATE TP_AGENDA SET STATUS_CTK_KWITANSI='1' WHERE NO_AGENDA='$NO_AGENDA' ");
}

public function rpt_kwitansirek(){
	$cetak		= $this->uri->segment(3);
	$ID_LANG 	= $this->uri->segment(4);
	$TGL_LUNAS 	= $this->uri->segment(5);

	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='8' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}

	#$q = $this->db->query("SELECT GROUP_CONCAT(a.THBLREK) THBLREK,a.ID_LANG,b.KD_AREA,c.`nama` PROV, d.`nama` KAB,b.NAMA_LANG,b.ALAMAT_LANG, (SUM(RPTAG) + SUM(RP_BK)) TOTAL, CONCAT(COUNT(a.THBLREK),' Bulan') BRPBULAN, TGL_LUNAS, date(TGL_LUNAS) TGL_LUNAS2
	#						FROM master_rekening a
	#						JOIN dil_listrik_ref b ON CONCAT(b.ID_LANG,b.ID_CUST) = CONCAT(a.ID_LANG,a.ID_CUST)
	#						JOIN tr_prov c ON b.PROV_LANG = c.`id_prov`
	#						JOIN tr_kab d ON b.`KOTA_LANG` = d.`id_kab`
	#						WHERE a.id_lang='$ID_LANG' AND  STATUS_LUNAS = '0' ");

	$q = $this->db->query("SELECT GROUP_CONCAT(a.THBLREK) THBLREK,a.ID_LANG,b.KD_AREA,c.`nama` PROV, d.`nama` KAB,b.NAMA_LANG,b.ALAMAT_LANG, (SUM(RPTAG) + SUM(RP_BK)) TOTAL, CONCAT(COUNT(a.THBLREK),' Bulan') BRPBULAN, TGL_LUNAS, date(TGL_LUNAS) TGL_LUNAS2, STATUS_CTK_KWITANSI
							FROM master_rekening a
							JOIN dil_listrik_ref b ON CONCAT(b.ID_LANG,b.ID_CUST) = CONCAT(a.ID_LANG,a.ID_CUST)
							JOIN tr_prov c ON b.PROV_LANG = c.`id_prov`
							JOIN tr_kab d ON b.`KOTA_LANG` = d.`id_kab`
							WHERE a.ID_LANG='$ID_LANG' AND a.TGL_LUNAS='$TGL_LUNAS' ");

	foreach($q->result() as $r)
	{
		$THBLREK		= $r->THBLREK;
		$KD_AREA		= $r->KD_AREA;
		$KOTA_LANG		= $r->KAB;
		$PROV_LANG		= $r->PROV;
		$NAMA_LANG		= $r->NAMA_LANG;
		$ALAMAT_LANG	= $r->ALAMAT_LANG;
		$TOTAL			= $r->TOTAL;
		$BRPBULAN		= $r->BRPBULAN;
		$TGL_LUNAS		= $r->TGL_LUNAS;
		$TGL_LUNAS2		= $r->TGL_LUNAS2;
		$STATUS_CTK		= $r->STATUS_CTK_KWITANSI;
	}

	$CETAKKE = $STATUS_CTK + 1;

	$TGL_TTD = tanggal_ttd($TGL_LUNAS2);
	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:6px;' >&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>K U I T A N S I</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center></center></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td height=5px width=20%></td>
				<td width=1%></td>
				<td width=30%></td>
				<td width=4%></td>
				<td width=20%></td>
				<td width=5%></td>
				<td width=20%></td>
			  </tr>
			  <tr>
				<td >Diterima dari</td>
				<td >:</td>
				<td colspan=2>$NAMA_LANG</td>
				<td ></td>
				<td ></td>
				<td >&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td valign=top>:</td>
				<td colspan=5 valign=top>$ALAMAT_LANG</td>
			  </tr>";
	$Rpt .= "<tr>
				<td >Uang Sejumlah</td>
				<td >:</td>
				<td colspan=2 bgcolor=#CCCCCC>Rp &nbsp;".number_format($TOTAL).".-</td>
				<td></td>
				<td></td>
				<td></td>
			  </tr>
			  <tr>
				<td>Terbilang</td>
				<td>:</td>
				<td colspan=5 bgcolor=#CCCCCC>".ucfirst($this->terbilang($TOTAL))."<br /></td>
			  </tr>
			  <tr>
				<td height=5px></td>
				<td></td>
				<td colspan=5></td>
			  </tr>
			</table>
			<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td colspan=7>Untuk Pelunasan Rekening $BRPBULAN ID Langganan: $ID_LANG, pada tahun bulan rekening $THBLREK </td>
			  </tr>
			  </table><br><br><br><br>";

	$Rpt .= "<table width=100% border=0 style='font-size:12px;'>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>Jakarta, ".$TGL_TTD."</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
			  </tr>
			  <tr>
				<td colspan=5></td>
				<td>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td rowspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5 style='font-size:9px;'></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5> </td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
			  </tr>
			  <tr>
				<td colspan=5 style='font-size:9px;'>*Bea Materai sesuai Kep Dirjen pajak no Kep-122d/PJ/2000 tanggal 1 Mei 2010</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Cetakan Ke - $CETAKKE </td>
				<td></td>
				<td></td>
			  </tr>
			</table>";
	$arsip = "<pagebreak><br>Arsip PT EPI";
	$SenD["TitlE"]	= "Cetakan Kuitansi Rekening $NO_AGENDA";
	$SenD["OutpuT"]	= $Rpt.$arsip.$Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

	$this->db->query("UPDATE master_rekening SET STATUS_CTK_KWITANSI = '1' WHERE ID_LANG='$ID_LANG' AND TGL_LUNAS='$TGL_LUNAS' ");

}

public function rpt_pkdanba(){
	$sekarang = date('Y-m-d H:i:s');
	$cetak	= $this->uri->segment(3);
	$TTD 	= $this->uri->segment(4);
	$no_agenda = $this->uri->segment(5);

	$query = $this->db->query("select no_pk from tp_agenda where no_agenda='$no_agenda' ");
	if($query->row("no_pk")=='' OR $query->row("no_pk")== null){
		$query = $this->db->query("SELECT CONCAT('PK-',KD_AREA,'-',SUBSTRING(no_agenda,6,3),'-',RIGHT(no_agenda,4) ) AS urut
									FROM TP_AGENDA
									WHERE no_agenda ='$no_agenda' ");
		$otopk = $query->row("urut");
		$this->db->query("UPDATE TP_AGENDA SET NO_PK = '$otopk', TGL_CTK_PK='$sekarang', TGL_CTK_BA='$sekarang' WHERE NO_AGENDA='$no_agenda' ");
	}

	#PROSES CETAK LAPORAN PK
	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='$TTD' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}
	$q = $this->db->query("SELECT a.*,DATE(TGL_MOHON) TGL_MOHON2,DATE(TGL_BAYAR) TGL_BAYAR2,b.`nama` PROV, c.`nama` KAB, d.`nama` KEC, e.`URAIAN` PERUNTUKAN
							FROM TP_AGENDA a
							JOIN tr_prov b ON a.PROV_LANG = b.`id_prov`
							JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
							JOIN tr_kec d ON a.`KEC_LANG` = d.`id_kec`
							JOIN tr_peruntukan e ON a.`PERUNTUKAN` = e.`ID`
							WHERE NO_AGENDA='$no_agenda' ");
		foreach($q->result() as $r){
			$KD_AREA	= $r->KD_AREA;
			$KEC_LANG	= $r->KEC;
			$KOTA_LANG	= $r->KAB;
			$PROV_LANG	= $r->PROV;
			$RP_BP 		= $r->RP_BP;
			$RP_UJL_TAGIH = $r->RP_UJL_TAGIH;
			$MATERAI 	= $r->MATERAI;
			$KOORDINATX = $r->KOORDINATX;
			$KOORDINATY = $r->KOORDINATY;
			$NAMA_LANG	= $r->NAMA_LANG;
			$ID_LANG	= $r->ID_LANG;
			$ALAMAT_LANG= $r->ALAMAT_LANG;
			$TGL_MOHON2 = $r->TGL_MOHON2;
			$JNS_TRANSAKSI = $r->JNS_TRANSAKSI;
			$STATUS_MOHON = $r->STATUS_MOHON;
			$TGL_BAYAR2 = $r->TGL_BAYAR2;
			$NO_PK		= $r->NO_PK;
			$LAMA_WAKTU		= $r->LAMA_WAKTU;
			$TGL_AWAL		= $r->TGL_AWAL;
			$TGL_AKHIR		= $r->TGL_AKHIR;
			$TGL_CTK_PK		= $r->TGL_CTK_PK;

			$NO_BP		= $r->NO_BP;
			$TARIF_LAMA = $r->TARIF_LAMA;
			$TARIF_BARU = $r->TARIF_BARU;
			$DAYA_LAMA  = $r->DAYA_LAMA;
			$DAYA_BARU  = $r->DAYA_BARU;
			$TIPE_PEMBATAS = $r->TIPE_PEMBATAS;
			$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
			$MERK_METER = $r->MERK_METER;
			$TIPE_METER = $r->TIPE_METER;
			$NO_METER   = $r->NO_METER;
			$FK_METER   = $r->FK_METER;
			$KD_GARDU   = $r->KD_GARDU;
			$NO_PANEL   = $r->NO_PANEL;
			$I_PRIMER_CT= $r->I_PRIMER_CT;
			$I_SEKUNDER_CT = $r->I_SEKUNDER_CT;
			$V_PRIMER_PT   = $r->V_PRIMER_PT;
			$V_SEKUNDER_PT = $r->V_SEKUNDER_PT;
			$STAND_PSG_LWBP= $r->STAND_PSG_LWBP;
			$STAND_PSG_WBP = $r->STAND_PSG_WBP;
			$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;
		}

	$q = $this->db->query("SELECT TIPE_PEMBATAS, SETTING_PEMBATAS, MERK_METER, TIPE_METER, NO_METER, FK_METER, KD_GT, NO_PANEL, I_PRIMER_CT,I_SEKUNDER_CT, V_PRIMER_PT, V_SEKUNDER_PT, STAND_PSG_LWBP, STAND_PSG_WBP, STAND_PSG_KVARH
							FROM dil_listrik_ref WHERE ID_LANG ='$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r){
				$TIPE_PEMBATASX		= empty($r->TIPE_PEMBATAS) ? '0' : $r->TIPE_PEMBATAS;
				$SETTING_PEMBATASX 	= empty($r->SETTING_PEMBATAS) ? '0' : $r->SETTING_PEMBATAS;
				$MERK_METERX 		= empty($r->MERK_METER) ? '0' : $r->MERK_METER;
				$TIPE_METERX 		= empty($r->TIPE_METER) ? '0' : $r->TIPE_METER;
				$NO_METERX   		= empty($r->NO_METER) ? '0' : $r->NO_METER;
				$FK_METERX   		= empty($r->FK_METER) ? '0' : $r->FK_METER;
				$KD_GTX   			= empty($r->KD_GT) ? '0' : $r->KD_GT;
				$NO_PANELX   		= empty($r->NO_PANEL) ? '0' : $r->NO_PANEL;
				$I_PRIMER_CTX		= empty($r->I_PRIMER_CT) ? '0' : $r->I_PRIMER_CT;
				$I_SEKUNDER_CTX		= empty($r->I_SEKUNDER_CT) ? '0' : $r->I_SEKUNDER_CT;
				$V_PRIMER_PTX  		= empty($r->V_PRIMER_PT) ? '0' : $r->V_PRIMER_PT;
				$V_SEKUNDER_PTX		= empty($r->V_SEKUNDER_PT) ? '0' : $r->V_SEKUNDER_PT;
				$STAND_PSG_LWBPX	= empty($r->STAND_PSG_LWBP) ? '0' : $r->STAND_PSG_LWBP;
				$STAND_PSG_WBPX		= empty($r->STAND_PSG_WBP) ? '0' : $r->STAND_PSG_WBP;
				$STAND_PSG_KVARHX	= empty($r->STAND_PSG_KVARH) ? '0' : $r->STAND_PSG_KVARH;
			}
		}else{
			$TIPE_PEMBATASX		= '0';
			$SETTING_PEMBATASX 	= '0';
			$MERK_METERX 		= '0';
			$TIPE_METERX 		= '0';
			$NO_METERX   		= '0';
			$FK_METERX   		= '0';
			$KD_GTX   			= '0';
			$NO_PANELX   		= '0';
			$I_PRIMER_CTX		= '0';
			$I_SEKUNDER_CTX		= '0';
			$V_PRIMER_PTX  		= '0';
			$V_SEKUNDER_PTX		= '0';
			$STAND_PSG_LWBPX	= '0';
			$STAND_PSG_WBPX		= '0';
			$STAND_PSG_KVARHX	= '0';
		}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	if($STATUS_MOHON < '6'){
		$sekarang   = date('Y-m-d H:i:s');
		$lamamohon  = sel_hari($TGL_MOHON2,$sekarang)+1;
		$this->db->query("UPDATE TP_AGENDA SET TGL_CTK_PK ='$sekarang', TGL_CTK_BA ='$sekarang',TGL_UPDATE_MOHON = '$sekarang', LAMA_MOHON = '$lamamohon', STATUS_MOHON='6' WHERE NO_AGENDA='$no_agenda' ");
	}

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=2 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:14px;'><center><u>PERINTAH KERJA</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;' ><center>No. : $NO_PK</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0	style='font-size:12px;' cellpadding=0px cellspacing=0px>
			  <tr>
				<td colspan=3></td>
				<td width=2%></td>
				<td width=15%></td>
				<td width=4%>&nbsp;</td>
				<td width=8%>&nbsp;</td>
				<td width=3%>&nbsp;</td>
				<td width=5%>&nbsp;</td>
				<td width=12%>&nbsp;</td>
				<td width=27%>&nbsp;</td>
				<td width=3%>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Diperintahkan</td>
				<td >:</td>
				<td colspan=8>1. Supervisor Alat Ukur dan Penyambungan</td>
			  </tr>
			  <tr>
				<td colspan=3>Kepada</td>
				<td>&nbsp;</td>
				<td colspan=8>2. Pelaksana Administrasi Junior Alat Ukur dan Penyambungan</td>
			  </tr>
			  <tr>
				<td width=2%>&nbsp;</td>
				<td width=5%>&nbsp;</td>
				<td width=14%>&nbsp;</td>
				<td>&nbsp;</td>
				<td></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			   <tr>
				<td colspan=12>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=12>Untuk melaksanakan $JNS_TRANSAKSI pada langganan dengan data sebagai berikut:</td>
			  </tr>
			  <tr>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				</tr>";

	if($JNS_TRANSAKSI == 'PASANG BARU'){
	$Rpt .=  "<tr>
				<td colspan=3>ID Langganan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ID_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Nama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$NAMA_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Alamat</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ALAMAT_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kecamatan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KEC_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kota</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KOTA_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Provinsi</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$PROV_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tarif / Daya (baru)</td>
				<td>:</td>
				<td style='font-size:12px;'>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
		$Rpt .= "<tr>
				<td colspan=12 align=justify >Pelanggan tersebut telah melakukan pembayaran pada ".tanggal_ttd($TGL_BAYAR2).", pelaksanaan penyambungan agar dituangkan dalam berita acara.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian terimakasih.</td>
			  </tr>
			</table>
			<br>";
	}elseif($JNS_TRANSAKSI == 'PERUBAHAN DAYA'){
		$Rpt .=  "<tr>
				<td colspan=3>ID Langganan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ID_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Nama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$NAMA_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Alamat</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ALAMAT_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kecamatan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KEC_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kota</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KOTA_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Provinsi</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$PROV_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tarif / Daya (baru)</td>
				<td>:</td>
				<td style='font-size:12px;'>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3>Tarif / Daya (lama)</td>
				<td style='font-size:12px;'>:&nbsp;$TARIF_LAMA / ".number_format($DAYA_LAMA)." VA</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
		$Rpt .= "<tr>
				<td colspan=12 align=justify >Pelanggan tersebut telah melakukan pembayaran pada ".tanggal_ttd($TGL_BAYAR2).", pelaksanaan penyambungan agar dituangkan dalam berita acara.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian terimakasih.</td>
			  </tr>
			</table>
			<br>";
	}elseif($JNS_TRANSAKSI == 'BALIK NAMA'){
		$Rpt .=  "<tr>
				<td colspan=3>ID Langganan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ID_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Nama Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$NAMA_LANG</td>
				<td colspan=3>Nama Baru</td>
				<td style='font-size:12px;'>:&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Alamat Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ALAMAT_LANG</td>
				<td colspan=3>Alamat Baru</td>
				<td>:&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kecamatan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KEC_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kota</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KOTA_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Provinsi</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$PROV_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
		$Rpt .= "<tr>
				<td colspan=12 align=justify >Pelanggan tersebut telah melakukan pembayaran pada ".tanggal_ttd($TGL_BAYAR2).", pelaksanaan penyambungan agar dituangkan dalam berita acara.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian terimakasih.</td>
			  </tr>
			</table>
			<br>";
	}elseif($JNS_TRANSAKSI == 'PENERANGAN SEMENTARA'){
		$Rpt .=  "<tr>
				<td colspan=3>ID Langganan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ID_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Nama Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$NAMA_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Alamat Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ALAMAT_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kecamatan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KEC_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kota</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KOTA_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Provinsi</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$PROV_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Lama Waktu</td>
				<td>:</td>
				<td>&nbsp;$LAMA_WAKTU</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tanggal Awal</td>
				<td>:</td>
				<td>&nbsp;$TGL_AWAL</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tanggal Akhir</td>
				<td>:</td>
				<td>&nbsp;$TGL_AKHIR</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tarif / Daya (baru)</td>
				<td>:</td>
				<td style='font-size:12px;'>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
		$Rpt .= "<tr>
				<td colspan=12 align=justify >Pelanggan tersebut telah melakukan pembayaran pada ".tanggal_ttd($TGL_BAYAR2).", pelaksanaan penyambungan agar dituangkan dalam berita acara.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian terimakasih.</td>
			  </tr>
			</table>
			<br>";
	}elseif($JNS_TRANSAKSI == 'BERHENTI LANGGANAN'){
		$Rpt .=  "<tr>
				<td colspan=3>ID Langganan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ID_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Nama Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$NAMA_LANG</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td colspan=3>Alamat Lama</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$ALAMAT_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kecamatan</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KEC_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Kota</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$KOTA_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Provinsi</td>
				<td>:</td>
				<td colspan=3 style='font-size:12px;'>$PROV_LANG</td>
				<td colspan=3></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3>Tarif / Daya (baru)</td>
				<td>:</td>
				<td style='font-size:12px;'>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=3></td>
				<td style='font-size:12px;'>&nbsp;</td>
				<td></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
		$Rpt .= "<tr>
				<td colspan=12 align=justify >Pelanggan tersebut telah melakukan pembayaran pada ".tanggal_ttd($TGL_BAYAR2).", pelaksanaan pembongkaran agar dituangkan dalam berita acara.</td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian terimakasih.</td>
			  </tr>
			</table>
			<br>";
	}

	$Rpt .= "<table width=100% style='font-size:12px;' border=0 cellspacing=1 cellpadding=1>
			  <tr>
				<td width=20%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
				<td width=40%>&nbsp;</td>
			  </tr>
			   <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2><center>Jakarta, ".tanggal_ttd(date_format(date_create($TGL_CTK_PK), 'Y-m-d'))."</center></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2><center>$JABATANTTD</center></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2></td>
			  </tr>
			  <tr>
				<td></td>
				<td></td>
				<td>&nbsp;</td>
				<td colspan=2><center>$NAMATTD</center></td>
			  </tr>
			</table><pagebreak>";

	if($JNS_TRANSAKSI == 'PERUBAHAN DAYA'){
	$Rpt .="<table width=100% style='font-size:12px;' border=0>
		  <tr>
			<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
		  </tr>
		  <tr>
			<td colspan=4><center>No. ..........................</center></td>
		  </tr>
		  <tr>
			<td colspan=4><center>&nbsp;</center></td>
		  </tr>
		  <tr>
			<td colspan=4><center>TENTANG</center></td>
		  </tr>
		  <tr>
			<td colspan=4><center>PENYAMBUNGAN PELANGGAN LISTRIK</center></td>
		  </tr>
		  <tr>
			<td colspan=4><center>PT ENERGI PELABUHAN INDONESIA</center></td>
		  </tr>
		  <tr>
			<td colspan=4>&nbsp;</td>
		  </tr>
		</table>
		<table width=100% border=0 style='text-align:justify; font-size:12px;'>
		  <tr>
			<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah dilaksanakan pemasangan Alat Pengukur dan Pembatas (APP) pelanggan PT Energi Pelabuhan Indonesia dengan data sebagai berikut :</td>
		  </tr>
		  <tr>
			<td colspan=4></td>
		  </tr>
		  <tr>
			<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
		  </tr>
		  <tr>
			<td width=1%>&nbsp;</td>
			<td width=20%>Nama</td>
			<td width=0%>:</td>
			<td width=79%>$NAMA_LANG</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>Alamat</td>
			<td>:</td>
			<td>$ALAMAT_LANG</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>ID Pelanggan</td>
			<td>:</td>
			<td>$ID_LANG</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>Tarif / Daya</td>
			<td>:</td>
			<td>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td colspan=4><b><u>DATA APP</b></u></td>
		  </tr>
		</table>";
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP Lama</center></td>
				<td width=28%><center>Data APP Baru</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATASX</center></td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATASX</center></td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METERX</center></td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METERX</center></td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METERX</center></td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CTX / $I_SEKUNDER_CTX</center></td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PTX / $V_SEKUNDER_PTX</center></td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METERX</center></td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBPX</center></td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBPX</center></td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARHX</center></td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah terpasang dengan baik.</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia. Selanjutnya, data langganan tersebut diatas akan dijadikan dasar oleh PT. Energi Pelabuhan Indonesia untuk dilakukan Perubahan Data Langganan (PDL).</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>";
	}elseif($JNS_TRANSAKSI == 'PASANG BARU'){
		$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PEMASANGAN PELANGGAN LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah dilaksanakan pemasangan Alat Pengukur dan Pembatas (APP) pelanggan PT Energi Pelabuhan Indonesia dengan data sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah terpasang dengan baik.</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia. Selanjutnya, data langganan tersebut diatas akan dijadikan dasar oleh PT. Energi Pelabuhan Indonesia untuk dilakukan Perubahan Data Langganan (PDL).</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>";
	}elseif($JNS_TRANSAKSI == 'BERHENTI LANGGANAN'){
		$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PEMBONGKARAN ALAT PENGUKUR DAN PEMBATAS PELANGGAN LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah dilaksanakan pembongkaran Alat Pengukur dan Pembatas (APP) pelanggan PT Energi Pelabuhan Indonesia dengan data sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah dibongkar.</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>";
	}else{
		$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PEMASANGAN ALAT PENGUKUR DAN PEMBATAS PELANGGAN LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah dilaksanakan pemasangan Alat Pengukur dan Pembatas (APP) pelanggan PT Energi Pelabuhan Indonesia dengan data sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF_BARU / ".number_format($DAYA_BARU)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
		$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah terpasang dengan baik.</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia. Selanjutnya, data langganan tersebut diatas akan dijadikan dasar oleh PT. Energi Pelabuhan Indonesia untuk dilakukan Perubahan Data Langganan (PDL).</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>";
	}
	$Rpt .=" <tr>
				<td width=2%>&nbsp;</td>
				<td width=23%>&nbsp;</td>
				<td width=44%>&nbsp;</td>
				<td width=11%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>PETUGAS</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>PELANGGAN</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>..................................................</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>..................................................</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan Perintah Kerja dan Berita Acara $no_agenda";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);
}


public function rpt_beritaacara(){
	$cetak	= $this->uri->segment(3);
	$TTD 	= $this->uri->segment(4);
	$id_lang = $this->uri->segment(5);
	$sekarang = date('Y-m-d');

	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='$TTD' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}
	$q = $this->db->query("SELECT a.*, b.nama KEC, c.nama KAB, d.`nama` PROV
									FROM dil_listrik_ref a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE id_lang='$id_lang' ");
		foreach($q->result() as $r){
			$KD_AREA	= $r->KD_AREA;
			$KEC_LANG	= $r->KEC;
			$KOTA_LANG	= $r->KAB;
			$PROV_LANG	= $r->PROV;
			$RP_BP 		= $r->RP_BP;
			$KOORDINATX = $r->KOORDINATX;
			$KOORDINATY = $r->KOORDINATY;
			$NAMA_LANG	= $r->NAMA_LANG;
			$ID_LANG	= $r->ID_LANG;
			$ALAMAT_LANG= $r->ALAMAT_LANG;
			$TGL_MOHON2 = $sekarang;
			$JNS_TRANSAKSI = $r->KD_MUT;
			$STATUS_MOHON = $r->STATUS_MOHON;
			$TGL_BAYAR2 = $sekarang;

			$TARIF 		= $r->TARIF;
			$DAYA		= $r->DAYA;
			$TIPE_PEMBATAS = $r->TIPE_PEMBATAS;
			$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
			$MERK_METER = $r->MERK_METER;
			$TIPE_METER = $r->TIPE_METER;
			$NO_METER   = $r->NO_METER;
			$FK_METER   = $r->FK_METER;
			$KD_GT	    = $r->KD_GT;
			$NO_PANEL   = $r->NO_PANEL;
			$I_PRIMER_CT= $r->I_PRIMER_CT;
			$I_SEKUNDER_CT = $r->I_SEKUNDER_CT;
			$V_PRIMER_PT   = $r->V_PRIMER_PT;
			$V_SEKUNDER_PT = $r->V_SEKUNDER_PT;
			$STAND_PSG_LWBP= $r->STAND_PSG_LWBP;
			$STAND_PSG_WBP = $r->STAND_PSG_WBP;
			$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;
		}

	$q = $this->db->query("SELECT TIPE_PEMBATAS, SETTING_PEMBATAS, MERK_METER, TIPE_METER, NO_METER, FK_METER, KD_GARDU, NO_PANEL, I_PRIMER_CT,I_SEKUNDER_CT, V_PRIMER_PT, V_SEKUNDER_PT, STAND_PSG_LWBP, STAND_PSG_WBP, STAND_PSG_KVARH
							FROM tp_agenda WHERE ID_LANG ='$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r){
				$TIPE_PEMBATASX		= empty($r->TIPE_PEMBATAS) ? '' : $r->TIPE_PEMBATAS;
				$SETTING_PEMBATASX 	= empty($r->SETTING_PEMBATAS) ? '' : $r->SETTING_PEMBATAS;
				$MERK_METERX 		= empty($r->MERK_METER) ? '' : $r->MERK_METER;
				$TIPE_METERX 		= empty($r->TIPE_METER) ? '' : $r->TIPE_METER;
				$NO_METERX   		= empty($r->NO_METER) ? '' : $r->NO_METER;
				$FK_METERX   		= empty($r->FK_METER) ? '' : $r->FK_METER;
				$KD_GARDUX   		= empty($r->KD_GARDU) ? '' : $r->KD_GARDU;
				$NO_PANELX   		= empty($r->NO_PANEL) ? '' : $r->NO_PANEL;
				$I_PRIMER_CTX		= empty($r->I_PRIMER_CT) ? '' : $r->I_PRIMER_CT;
				$I_SEKUNDER_CTX		= empty($r->I_SEKUNDER_CT) ? '' : $r->I_SEKUNDER_CT;
				$V_PRIMER_PTX  		= empty($r->V_PRIMER_PT) ? '' : $r->V_PRIMER_PT;
				$V_SEKUNDER_PTX		= empty($r->V_SEKUNDER_PT) ? '' : $r->V_SEKUNDER_PT;
				$STAND_PSG_LWBPX	= empty($r->STAND_PSG_LWBP) ? '' : $r->STAND_PSG_LWBP;
				$STAND_PSG_WBPX		= empty($r->STAND_PSG_WBP) ? '' : $r->STAND_PSG_WBP;
				$STAND_PSG_KVARHX	= empty($r->STAND_PSG_KVARH) ? '' : $r->STAND_PSG_KVARH;
			}
		}else{
			$TIPE_PEMBATASX		= '';
			$SETTING_PEMBATASX 	= '';
			$MERK_METERX 		= '';
			$TIPE_METERX 		= '';
			$NO_METERX   		= '';
			$FK_METERX   		= '';
			$KD_GARDUX   		= '';
			$NO_PANELX   		= '';
			$I_PRIMER_CTX		= '';
			$I_SEKUNDER_CTX		= '';
			$V_PRIMER_PTX  		= '';
			$V_SEKUNDER_PTX		= '';
			$STAND_PSG_LWBPX	= '';
			$STAND_PSG_WBPX		= '';
			$STAND_PSG_KVARHX	= '';
		}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$Rpt = "";
	$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PENYAMBUNGAN PELANGGAN LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah dilaksanakan pemasangan Alat Pengukur dan Pembatas (APP) pelanggan PT Energi Pelabuhan Indonesia dengan data sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF / ".number_format($DAYA)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
	if($JNS_TRANSAKSI == 'E'){ #KODE MUTASI PERUBAHAN DAYA
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP Lama</center></td>
				<td width=28%><center>Data APP Baru</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATASX</center></td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATASX</center></td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METERX</center></td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METERX</center></td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METERX</center></td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CTX / $I_SEKUNDER_CTX</center></td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PTX / $V_SEKUNDER_PTX</center></td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METERX</center></td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBPX</center></td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBPX</center></td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARHX</center></td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'A'){ #KODE MUTASI PASANG BARU
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}else{
		$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}
	$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah terpasang dengan baik.</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia. Selanjutnya, data langganan tersebut diatas akan dijadikan dasar oleh PT. Energi Pelabuhan Indonesia untuk dilakukan Perubahan Data Langganan (PDL).</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>
			  <tr>
				<td width=2%>&nbsp;</td>
				<td width=23%>&nbsp;</td>
				<td width=44%>&nbsp;</td>
				<td width=11%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>PETUGAS</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>PELANGGAN</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>..................................................</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>..................................................</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan Berita Acara $id_lang";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_beritaacarasetting(){
	$cetak	= $this->uri->segment(3);
	$TTD 	= $this->uri->segment(4);
	$id_lang = $this->uri->segment(5);
	$sekarang = date('Y-m-d');

	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='$TTD' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}
	$q = $this->db->query("SELECT a.*, b.nama KEC, c.nama KAB, d.`nama` PROV
									FROM dil_listrik_ref a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE id_lang='$id_lang' ");
		foreach($q->result() as $r){
			$KD_AREA	= $r->KD_AREA;
			$KEC_LANG	= $r->KEC;
			$KOTA_LANG	= $r->KAB;
			$PROV_LANG	= $r->PROV;
			$RP_BP 		= $r->RP_BP;
			$KOORDINATX = $r->KOORDINATX;
			$KOORDINATY = $r->KOORDINATY;
			$NAMA_LANG	= $r->NAMA_LANG;
			$ID_LANG	= $r->ID_LANG;
			$ALAMAT_LANG= $r->ALAMAT_LANG;
			$TGL_MOHON2 = $sekarang;
			$JNS_TRANSAKSI = $r->KD_MUT;
			$STATUS_MOHON = $r->STATUS_MOHON;
			$TGL_BAYAR2 = $sekarang;

			$TARIF 		= $r->TARIF;
			$DAYA		= $r->DAYA;
			$TIPE_PEMBATAS = $r->TIPE_PEMBATAS;
			$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
			$MERK_METER = $r->MERK_METER;
			$TIPE_METER = $r->TIPE_METER;
			$NO_METER   = $r->NO_METER;
			$FK_METER   = $r->FK_METER;
			$KD_GT	    = $r->KD_GT;
			$NO_PANEL   = $r->NO_PANEL;
			$I_PRIMER_CT= $r->I_PRIMER_CT;
			$I_SEKUNDER_CT = $r->I_SEKUNDER_CT;
			$V_PRIMER_PT   = $r->V_PRIMER_PT;
			$V_SEKUNDER_PT = $r->V_SEKUNDER_PT;
			$STAND_PSG_LWBP= $r->STAND_PSG_LWBP;
			$STAND_PSG_WBP = $r->STAND_PSG_WBP;
			$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;
		}

	$q = $this->db->query("SELECT TIPE_PEMBATAS, SETTING_PEMBATAS, MERK_METER, TIPE_METER, NO_METER, FK_METER, KD_GARDU, NO_PANEL, I_PRIMER_CT,I_SEKUNDER_CT, V_PRIMER_PT, V_SEKUNDER_PT, STAND_PSG_LWBP, STAND_PSG_WBP, STAND_PSG_KVARH
							FROM tp_agenda WHERE ID_LANG ='$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r){
				$TIPE_PEMBATASX		= empty($r->TIPE_PEMBATAS) ? '' : $r->TIPE_PEMBATAS;
				$SETTING_PEMBATASX 	= empty($r->SETTING_PEMBATAS) ? '' : $r->SETTING_PEMBATAS;
				$MERK_METERX 		= empty($r->MERK_METER) ? '' : $r->MERK_METER;
				$TIPE_METERX 		= empty($r->TIPE_METER) ? '' : $r->TIPE_METER;
				$NO_METERX   		= empty($r->NO_METER) ? '' : $r->NO_METER;
				$FK_METERX   		= empty($r->FK_METER) ? '' : $r->FK_METER;
				$KD_GARDUX   		= empty($r->KD_GARDU) ? '' : $r->KD_GARDU;
				$NO_PANELX   		= empty($r->NO_PANEL) ? '' : $r->NO_PANEL;
				$I_PRIMER_CTX		= empty($r->I_PRIMER_CT) ? '' : $r->I_PRIMER_CT;
				$I_SEKUNDER_CTX		= empty($r->I_SEKUNDER_CT) ? '' : $r->I_SEKUNDER_CT;
				$V_PRIMER_PTX  		= empty($r->V_PRIMER_PT) ? '' : $r->V_PRIMER_PT;
				$V_SEKUNDER_PTX		= empty($r->V_SEKUNDER_PT) ? '' : $r->V_SEKUNDER_PT;
				$STAND_PSG_LWBPX	= empty($r->STAND_PSG_LWBP) ? '' : $r->STAND_PSG_LWBP;
				$STAND_PSG_WBPX		= empty($r->STAND_PSG_WBP) ? '' : $r->STAND_PSG_WBP;
				$STAND_PSG_KVARHX	= empty($r->STAND_PSG_KVARH) ? '' : $r->STAND_PSG_KVARH;
			}
		}else{
			$TIPE_PEMBATASX		= '';
			$SETTING_PEMBATASX 	= '';
			$MERK_METERX 		= '';
			$TIPE_METERX 		= '';
			$NO_METERX   		= '';
			$FK_METERX   		= '';
			$KD_GARDUX   		= '';
			$NO_PANELX   		= '';
			$I_PRIMER_CTX		= '';
			$I_SEKUNDER_CTX		= '';
			$V_PRIMER_PTX  		= '';
			$V_SEKUNDER_PTX		= '';
			$STAND_PSG_LWBPX	= '';
			$STAND_PSG_WBPX		= '';
			$STAND_PSG_KVARHX	= '';
		}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$Rpt = "";
	$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PENYETTINGAN DAN KONFIGURASI</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>ALAT PEMBATAS DAN PENGUKUR (APP) PADA INSTALASI LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PELANGGAN PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini .................. tanggal ...... bulan .............................tahun .........., telah melaksanakan penyettingan dan Konfigurasi Alat Pembatas dan Pengukur (APP) pelanggan dengan uraian sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF / ".number_format($DAYA)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
	if($JNS_TRANSAKSI == 'E'){ #KODE MUTASI PERUBAHAN DAYA
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP Lama</center></td>
				<td width=28%><center>Data APP Baru</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATASX</center></td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATASX</center></td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METERX</center></td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METERX</center></td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METERX</center></td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CTX / $I_SEKUNDER_CTX</center></td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PTX / $V_SEKUNDER_PTX</center></td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METERX</center></td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBPX</center></td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBPX</center></td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARHX</center></td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'A'){ #KODE MUTASI PASANG BARU
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}else{
		$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}
	$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah di reset dan stand meter terhitung dari angka 0 (Nol).</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia.</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>
			  <tr>
				<td width=2%>&nbsp;</td>
				<td width=23%>&nbsp;</td>
				<td width=44%>&nbsp;</td>
				<td width=11%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>PETUGAS</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>PELANGGAN</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>..................................................</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>..................................................</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan Berita Acara $id_lang";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_beritaacaraganti(){
	$cetak	= $this->uri->segment(3);
	$TTD 	= $this->uri->segment(4);
	$id_lang = $this->uri->segment(5);
	$sekarang = date('Y-m-d');

	$q = $this->db->query("SELECT * FROM tr_jabatan WHERE ID ='$TTD' ");
		foreach($q->result() as $r){
			$NAMATTD    = $r->NAMA;
			$JABATANTTD = $r->JABATAN;
		}
	$q = $this->db->query("SELECT a.*, b.nama KEC, c.nama KAB, d.`nama` PROV
									FROM dil_listrik_ref a
									JOIN tr_kec b ON a.`KEC_LANG` = b.`id_kec`
									JOIN tr_kab c ON a.`KOTA_LANG` = c.`id_kab`
									JOIN tr_prov d ON a.`PROV_LANG` = d.`id_prov`
									WHERE id_lang='$id_lang' ");
		foreach($q->result() as $r){
			$KD_AREA	= $r->KD_AREA;
			$KEC_LANG	= $r->KEC;
			$KOTA_LANG	= $r->KAB;
			$PROV_LANG	= $r->PROV;
			$RP_BP 		= $r->RP_BP;
			$KOORDINATX = $r->KOORDINATX;
			$KOORDINATY = $r->KOORDINATY;
			$NAMA_LANG	= $r->NAMA_LANG;
			$ID_LANG	= $r->ID_LANG;
			$ALAMAT_LANG= $r->ALAMAT_LANG;
			$TGL_MOHON2 = $sekarang;
			$JNS_TRANSAKSI = $r->KD_MUT;
			$STATUS_MOHON = $r->STATUS_MOHON;
			$TGL_BAYAR2 = $sekarang;

			$TARIF 		= $r->TARIF;
			$DAYA		= $r->DAYA;
			$TIPE_PEMBATAS = $r->TIPE_PEMBATAS;
			$SETTING_PEMBATAS = $r->SETTING_PEMBATAS;
			$MERK_METER = $r->MERK_METER;
			$TIPE_METER = $r->TIPE_METER;
			$NO_METER   = $r->NO_METER;
			$FK_METER   = $r->FK_METER;
			$KD_GT	    = $r->KD_GT;
			$NO_PANEL   = $r->NO_PANEL;
			$I_PRIMER_CT= $r->I_PRIMER_CT;
			$I_SEKUNDER_CT = $r->I_SEKUNDER_CT;
			$V_PRIMER_PT   = $r->V_PRIMER_PT;
			$V_SEKUNDER_PT = $r->V_SEKUNDER_PT;
			$STAND_PSG_LWBP= $r->STAND_PSG_LWBP;
			$STAND_PSG_WBP = $r->STAND_PSG_WBP;
			$STAND_PSG_KVARH= $r->STAND_PSG_KVARH;
		}

	$q = $this->db->query("SELECT TIPE_PEMBATAS, SETTING_PEMBATAS, MERK_METER, TIPE_METER, NO_METER, FK_METER, KD_GARDU, NO_PANEL, I_PRIMER_CT,I_SEKUNDER_CT, V_PRIMER_PT, V_SEKUNDER_PT, STAND_PSG_LWBP, STAND_PSG_WBP, STAND_PSG_KVARH
							FROM tp_agenda WHERE ID_LANG ='$ID_LANG' ");
		if($q->num_rows() > 0 ){
			foreach($q->result() as $r){
				$TIPE_PEMBATASX		= empty($r->TIPE_PEMBATAS) ? '' : $r->TIPE_PEMBATAS;
				$SETTING_PEMBATASX 	= empty($r->SETTING_PEMBATAS) ? '' : $r->SETTING_PEMBATAS;
				$MERK_METERX 		= empty($r->MERK_METER) ? '' : $r->MERK_METER;
				$TIPE_METERX 		= empty($r->TIPE_METER) ? '' : $r->TIPE_METER;
				$NO_METERX   		= empty($r->NO_METER) ? '' : $r->NO_METER;
				$FK_METERX   		= empty($r->FK_METER) ? '' : $r->FK_METER;
				$KD_GARDUX   		= empty($r->KD_GARDU) ? '' : $r->KD_GARDU;
				$NO_PANELX   		= empty($r->NO_PANEL) ? '' : $r->NO_PANEL;
				$I_PRIMER_CTX		= empty($r->I_PRIMER_CT) ? '' : $r->I_PRIMER_CT;
				$I_SEKUNDER_CTX		= empty($r->I_SEKUNDER_CT) ? '' : $r->I_SEKUNDER_CT;
				$V_PRIMER_PTX  		= empty($r->V_PRIMER_PT) ? '' : $r->V_PRIMER_PT;
				$V_SEKUNDER_PTX		= empty($r->V_SEKUNDER_PT) ? '' : $r->V_SEKUNDER_PT;
				$STAND_PSG_LWBPX	= empty($r->STAND_PSG_LWBP) ? '' : $r->STAND_PSG_LWBP;
				$STAND_PSG_WBPX		= empty($r->STAND_PSG_WBP) ? '' : $r->STAND_PSG_WBP;
				$STAND_PSG_KVARHX	= empty($r->STAND_PSG_KVARH) ? '' : $r->STAND_PSG_KVARH;
			}
		}else{
			$TIPE_PEMBATASX		= '';
			$SETTING_PEMBATASX 	= '';
			$MERK_METERX 		= '';
			$TIPE_METERX 		= '';
			$NO_METERX   		= '';
			$FK_METERX   		= '';
			$KD_GARDUX   		= '';
			$NO_PANELX   		= '';
			$I_PRIMER_CTX		= '';
			$I_SEKUNDER_CTX		= '';
			$V_PRIMER_PTX  		= '';
			$V_SEKUNDER_PTX		= '';
			$STAND_PSG_LWBPX	= '';
			$STAND_PSG_WBPX		= '';
			$STAND_PSG_KVARHX	= '';
		}

	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$Rpt = "";
	$Rpt .="<table width=100% style='font-size:12px;' border=0>
			  <tr>
				<td colspan=4><center><b><u>BERITA ACARA</u></b></center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>No. ..........................</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>&nbsp;</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>TENTANG</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PENGGANTIAN ALAT PEMBATAS DAN PENGUKUR (APP) PADA INSTALASI LISTRIK</center></td>
			  </tr>
			  <tr>
				<td colspan=4><center>PELANGGAN PT ENERGI PELABUHAN INDONESIA</center></td>
			  </tr>
			  <tr>
				<td colspan=4>&nbsp;</td>
			  </tr>
			</table>
			<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=4>Pada hari ini, ….………. tanggal ……………... bulan ………..… tahun ………………………………., telah melaksanakan penggantian Alat Pembatas dan Pengukur (APP) pelanggan dengan uraian sebagai berikut :</td>
			  </tr>
			  <tr>
				<td colspan=4></td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA PELANGGAN</b></u></td>
			  </tr>
			  <tr>
				<td width=1%>&nbsp;</td>
				<td width=20%>Nama</td>
				<td width=0%>:</td>
				<td width=79%>$NAMA_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Alamat</td>
				<td>:</td>
				<td>$ALAMAT_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>ID Pelanggan</td>
				<td>:</td>
				<td>$ID_LANG</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td>$TARIF / ".number_format($DAYA)." VA</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=4><b><u>DATA APP</b></u></td>
			  </tr>
			</table>";
	if($JNS_TRANSAKSI == 'E'){ #KODE MUTASI PERUBAHAN DAYA
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP Lama</center></td>
				<td width=28%><center>Data APP Baru</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATASX</center></td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATASX</center></td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METERX</center></td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METERX</center></td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METERX</center></td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CTX / $I_SEKUNDER_CTX</center></td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PTX / $V_SEKUNDER_PTX</center></td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METERX</center></td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBPX</center></td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBPX</center></td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARHX</center></td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}elseif($JNS_TRANSAKSI == 'A'){ #KODE MUTASI PASANG BARU
	$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center> / </center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}else{
		$Rpt .="<table width=100% style='font-size:12px;' border=1 cellpadding=0px; cellspacing=0px;>
			  <tr>
				<td width=4%><center>No</center></td>
				<td width=33%><center>KWH METER</center></td>
				<td width=28%><center>Data APP</center></td>
				<td width=35%><center>KETERANGAN</center></td>
			  </tr>
			  <tr>
				<td><center>1</center></td>
				<td>Jenis Pembatas</td>
				<td><center>$TIPE_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>2</center></td>
				<td>Kapasitas / Setting Pembatas</td>
				<td><center>$SETTING_PEMBATAS</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>3</center></td>
				<td>Merk Meter</td>
				<td><center>$MERK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>4</center></td>
				<td>Tipe KWH Meter</td>
				<td><center>$TIPE_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>5</center></td>
				<td>No. Seri KWH Meter</td>
				<td><center>$NO_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>7</center></td>
				<td>CT Primer / Sekunder</td>
				<td><center>$I_PRIMER_CT / $I_SEKUNDER_CT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>8</center></td>
				<td>PT Primer / Sekunder</td>
				<td><center>$V_PRIMER_PT / $V_SEKUNDER_PT</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>6</center></td>
				<td>Faktor Kali Meter</td>
				<td><center>$FK_METER</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>9</center></td>
				<td>Stand LWBP</td>
				<td><center>$STAND_PSG_LWBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>10</center></td>
				<td>Stand WBP</td>
				<td><center>$STAND_PSG_WBP</center></td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td><center>11</center></td>
				<td>Stand KVARH</td>
				<td><center>$STAND_PSG_KVARH</center></td>
				<td>&nbsp;</td>
			  </tr>
			</table>";
	}
	$Rpt .="<table width=100% border=0 style='text-align:justify; font-size:12px;'>
			  <tr>
				<td colspan=5>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan menyatakan bahwa APP telah terpasang dengan baik.</td>
			  </tr>
			  <tr>
				<td colspan=5>Pelanggan berkewajiban menjaga dan melindungi atas Alat Pembatas dan Pengukur (APP) milik PT. Energi Pelabuhan Indonesia.</td>
			  </tr>
			  <tr>
				<td colspan=5></td>
			  </tr>
			  <tr>
				<td colspan=5>Demikian Berita Acara ini dibuat untuk dapat dipergunakan seperlunya.</td>
			  </tr>
			  <tr>
				<td width=2%>&nbsp;</td>
				<td width=23%>&nbsp;</td>
				<td width=44%>&nbsp;</td>
				<td width=11%>&nbsp;</td>
				<td width=20%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>PETUGAS</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>PELANGGAN</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td><center>..................................................</center></td>
				<td>&nbsp;</td>
				<td colspan=2><center>..................................................</center></td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$JABATANTTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			  <tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><center>$NAMATTD</center></td>
				<td colspan=2>&nbsp;</td>
			  </tr>
			</table>";

	$SenD["TitlE"]	= "Cetakan Berita Acara $id_lang";
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

function cetak_janjitebal(){
	$cetak	= $this->uri->segment(3);
	$no_agenda  = $this->uri->segment(4);
	$idl  	= $this->uri->segment(5);

	if($no_agenda != '0' AND $idl == '0'){
		$query_agenda = $this->db->query("
		select
			*,TARIF_BARU TARIF, DAYA_BARU DAYA, RP_UJL_BARU RP_UJL
		from tp_agenda
		where NO_AGENDA='".$no_agenda."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".$query_agenda['TARIF_BARU']."' ")->result_array()[0];

		$query_dilref = $this->db->query("
		select
			NAMA_LANG
		from dil_listrik_ref
		where ID_LANG='".$query_agenda['ID_LANG_TUJUAN_BAYAR']."' ")->result_array()[0];
	}elseif($no_agenda == '0' AND $idl != '0'){
		$query_agenda = $this->db->query("
		select
			*, (RP_BP+RP_UJL) TOTAL_BIAYA
		from dil_listrik_ref
		where ID_LANG='".$idl."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".$query_agenda['TARIF']."' ")->result_array()[0];

	}else{
		$query_agenda = $this->db->query("
		select
			*
		from tp_agenda
		where NO_AGENDA='".$no_agenda."' OR ID_LANG='".$idl."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".$query_agenda['TARIF_BARU']."' ")->result_array()[0];
	}

	$query_cust = $this->db->query("
		select
			*
		from cust
		where ID_CUST='".$query_agenda['ID_CUST']."' ")->result_array()[0];

	$query_jam = $this->db->query("
		select
			NILAI_JAMNYALA
		from tr_jamnyala
		where KD_JAMNYALA = '".$query_agenda['KD_JAMNYALA_EMIN']."' ")->result_array()[0];

if($query_agenda['POLA_PEMBAYARAN'] == '0' ){
	$PASAL5= "<tr>
				<td valign='top'>3.</td>
				<td align='justify'>PIHAK KEDUA wajib membayar biaya tersebut diatas melalui Bank Bukopin dengan nomor rekening : 1000406488 atas nama PT Energi Pelabuhan Indonesia dan menyampaikan bukti transfer kepada PIHAK PERTAMA.</td>
			</tr>";
}elseif($query_agenda['POLA_PEMBAYARAN'] == '1'){
	$PASAL5="<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Biaya tersebut diatas telah dimasukan sebagai tagihan pada bulan rekening pertama.</td>
	</tr>";
}else{
	$PASAL5="<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Biaya tersebut diatas telah dimasukan sebagai tagihan pada ID Langganan	". $query_agenda['ID_LANG_TUJUAN_BAYAR'] .", atas nama ".  $query_dilref['NAMA_LANG'].".</td>
	</tr>";
}

if($query_agenda['KD_BK'] == 'X' ){
	$PASAL8= "<tr>
		<td valign='top'>2.</td>
		<td align='justify'>Apabila Bank dari PIHAK KEDUA belum melakukan pembayaran rekening listrik sampai hari kedua atau H + 2 setelah menerima  surat informasi tagihan, maka PIHAK PERTAMA akan mengirimkan pemberitahuan ke-1 (satu) dan dapat melakukan pemutusan aliran listrik secara manual atau otomatis ke instalasi PIHAK KEDUA. Pemberitahuan pemutusan sementara akan disampaikan melalui : surat / sms / email.</td>
	</tr>
	<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Jika PIHAK KEDUA belum melakukan pembayaran sampai dengan <b>tanggal 20 (Dua Puluh)</b>, maka PIHAK KEDUA dikenakan <b>biaya keterlambatan untuk setiap bulan keterlambatan *) sebesar 6 % ( Enam Per Seratus)</b> dari nilai Rupiah Penggunaan Tenaga Listrik (RpPTL) pada tagihan rekening listrik sebagaimana dimaksud ayat (2).</td>
	</tr>
	<tr>
		<td valign='top'>4.</td>
		<td align='justify'>Jika PIHAK KEDUA tidak melakukan pembayaran tagihan rekening listrik bulanannya sampai dengan periode kedua setelah pemutusan sementara sebagaimana dimaksud pada ayat (3) Pasal ini, maka PIHAK PERTAMA akan mengirimkan surat pemberitahuan ke-2 (dua) dan PIHAK KEDUA dikenakan biaya keterlambatan 2 (dua) kali untuk tagihan bulan pertama dan satu kali biaya keterlambatan untuk tagihan bulan kedua.</td>
	</tr>
	<tr>
		<td valign='top'>5.</td>
		<td align='justify'>Jika PIHAK KEDUA tidak dapat memenuhi jadwal pembayaran tagihan rekening listrik bulanannya dan biaya keterlambatan tersebut dalam ayat (3) dan ayat (4) Pasal ini, terhitung 60 (enam puluh) hari setelah periode keterlambatan pertama, maka PIHAK PERTAMA akan memberikan Pemberitahuan ke 3 (tiga) atau terakhir sekaligus pelaksanaan bongkar rampung seluruh instalasi milik  PIHAK PERTAMA yang terpasang pada gedung milik PIHAK KEDUA dan PIHAK KEDUA diberhentikan secara sepihak sebagai Pelanggan oleh PIHAK PERTAMA.</td>
	</tr>
	<tr>
		<td valign='top'>6.</td>
		<td align='justify'>Penyambungan kembali aliran listrik yang telah diputus sementara sebagaimana dimaksud pada ayat (3) Pasal ini, akan dilakukan oleh PIHAK PERTAMA setelah tagihan rekening listrik yang terhutang berikut biaya keterlambatan telah dibayar lunas oleh PIHAK KEDUA.</td>
	</tr>
	<tr>
		<td valign='top'>7.</td>
		<td align='justify'>Penyambungan kembali setelah pelaksanaan bongkar rampung sebagaimana dimaksud pada ayat (5) Pasal ini, akan diperlakukan sebagai sambungan baru (dikenakan  BP Baru dan Suplesi UJL sesuai ketentuan yang berlaku) serta tetap diwajibkan membayar rekening-rekening bulanan dan biaya keterlambatan (biaya keterlambatan 3 kali untuk tagihan bulan pertama, dua kali biaya keterlambatan untuk tagihan bulan kedua dan satu kali biaya keterlambatan untuk tagihan bulan ketiga) serta tagihan lainnya yang belum dilunasi.</td>
	</tr>	";
}

	$data['data_pasal5']	= $PASAL5;
	$data['data_pasal8']	= $PASAL8;
	$data['data_agenda']	= $query_agenda;
	$data['data_cust']		= $query_cust;
	$data['data_tarif']		= $query_tarif;
	$data['data_dil']		= $query_dilref;
	$data['data_jam']		= $query_jam;
	$data['tahun_ini'] 		= date('Y');
	$data['bulan_ini'] 		= getBulan(date('m'));
	$data['tanggal_ini'] 	= date('j');
	$data['hari_ini'] 		= getHari(date('w'));
	$Rpt = $this->load->view("laporan/cetak_janjitebal",$data,TRUE);

	$SenD["TitlE"]	= "Cetakan Perjanjian dan Syarat Teknis ".$no_agenda;
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

function cetak_janjitipis(){
	$cetak	= $this->uri->segment(3);
	$no_agenda  = $this->uri->segment(4);
	$idl  = $this->uri->segment(5);

	if($no_agenda != '0' AND $idl == '0'){
		$query_agenda = $this->db->query("
		select
			*,TARIF_BARU TARIF, DAYA_BARU DAYA, RP_UJL_BARU RP_UJL
		from tp_agenda
		where NO_AGENDA='".@$no_agenda."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".@$query_agenda['TARIF_BARU']."' ")->result_array()[0];

		$query_dilref = $this->db->query("
		select
			NAMA_LANG
		from dil_listrik_ref
		where ID_LANG='".@$query_agenda['ID_LANG_TUJUAN_BAYAR']."' ")->result_array()[0];

	    $query_peruntukan = $this->db->query("
		select
			*
		from tr_peruntukan
		where ID = '".@$query_agenda['PERUNTUKAN']."' ")->result_array()[0];
	}elseif($no_agenda == '0' AND $idl != '0'){
		$query_agenda = $this->db->query("
		select
			*,'0' POLA_PEMBAYARAN,'0' PAKET_SAR,'0' RP_UJL_LAMA, (RP_BP+RP_UJL) TOTAL_BIAYA
		from dil_listrik_ref
		where ID_LANG='".@$idl."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".@$query_agenda['TARIF']."' ")->result_array()[0];
	}else{
		$query_agenda = $this->db->query("
		select
			*
		from tp_agenda
		where NO_AGENDA='".@$no_agenda."' OR ID_LANG='".@$idl."' ")->result_array()[0];

		$query_tarif = $this->db->query("
		select
			*
		from tr_tarif
		where KD_TARIF='".@$query_agenda['TARIF_BARU']."' ")->result_array()[0];
	}

	$query_cust = $this->db->query("
		select
			*
		from cust
		where ID_CUST='".@$query_agenda['ID_CUST']."' ")->result_array()[0];

	$query_jam = $this->db->query("
		select
			NILAI_JAMNYALA
		from tr_jamnyala
		where KD_JAMNYALA = '".@$query_agenda['KD_JAMNYALA_EMIN']."' ")->result_array()[0];

	$query_kec = $this->db->query("
		select
			*
		from tr_kec
		where id_kec = '".@$query_agenda['KEC_LANG']."' ")->result_array()[0];

if($query_agenda['POLA_PEMBAYARAN'] == '0' ){
	$PASAL5= "<tr>
				<td valign='top'>3.</td>
				<td align='justify'>PIHAK KEDUA wajib membayar biaya tersebut diatas melalui Bank Bukopin dengan nomor rekening : 1000406488 atas nama PT Energi Pelabuhan Indonesia dan menyampaikan bukti transfer kepada PIHAK PERTAMA.</td>
			</tr>";
}elseif($query_agenda['POLA_PEMBAYARAN'] == '1'){
	$PASAL5="<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Biaya tersebut diatas telah dimasukan sebagai tagihan pada bulan rekening pertama.</td>
	</tr>";
}else{
	$PASAL5="<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Biaya tersebut diatas telah dimasukan sebagai tagihan pada ID Langganan	". $query_agenda['ID_LANG_TUJUAN_BAYAR'] .", atas nama ".  $query_dilref['NAMA_LANG'].".</td>
	</tr>";
}

if($query_agenda['KD_BK'] == 'X' ){
	$PASAL8= "<tr>
		<td valign='top'>2.</td>
		<td align='justify'>Apabila Bank dari PIHAK KEDUA belum melakukan pembayaran rekening listrik sampai hari kedua atau H + 2 setelah menerima  surat informasi tagihan, maka PIHAK PERTAMA akan mengirimkan pemberitahuan ke-1 (satu) dan dapat melakukan pemutusan aliran listrik secara manual atau otomatis ke instalasi PIHAK KEDUA. Pemberitahuan pemutusan sementara akan disampaikan melalui : surat / sms / email.</td>
	</tr>
	<tr>
		<td valign='top'>3.</td>
		<td align='justify'>Jika PIHAK KEDUA belum melakukan pembayaran sampai dengan <b>tanggal 20 (Dua Puluh)</b>, maka PIHAK KEDUA dikenakan <b>biaya keterlambatan untuk setiap bulan keterlambatan *) sebesar 6 % ( Enam Per Seratus)</b> dari nilai Rupiah Penggunaan Tenaga Listrik (RpPTL) pada tagihan rekening listrik sebagaimana dimaksud ayat (2).</td>
	</tr>
	<tr>
		<td valign='top'>4.</td>
		<td align='justify'>Jika PIHAK KEDUA tidak melakukan pembayaran tagihan rekening listrik bulanannya sampai dengan periode kedua setelah pemutusan sementara sebagaimana dimaksud pada ayat (3) Pasal ini, maka PIHAK PERTAMA akan mengirimkan surat pemberitahuan ke-2 (dua) dan PIHAK KEDUA dikenakan biaya keterlambatan 2 (dua) kali untuk tagihan bulan pertama dan satu kali biaya keterlambatan untuk tagihan bulan kedua.</td>
	</tr>
	<tr>
		<td valign='top'>5.</td>
		<td align='justify'>Jika PIHAK KEDUA tidak dapat memenuhi jadwal pembayaran tagihan rekening listrik bulanannya dan biaya keterlambatan tersebut dalam ayat (3) dan ayat (4) Pasal ini, terhitung 60 (enam puluh) hari setelah periode keterlambatan pertama, maka PIHAK PERTAMA akan memberikan Pemberitahuan ke 3 (tiga) atau terakhir sekaligus pelaksanaan bongkar rampung seluruh instalasi milik  PIHAK PERTAMA yang terpasang pada gedung milik PIHAK KEDUA dan PIHAK KEDUA diberhentikan secara sepihak sebagai Pelanggan oleh PIHAK PERTAMA.</td>
	</tr>
	<tr>
		<td valign='top'>6.</td>
		<td align='justify'>Penyambungan kembali aliran listrik yang telah diputus sementara sebagaimana dimaksud pada ayat (3) Pasal ini, akan dilakukan oleh PIHAK PERTAMA setelah tagihan rekening listrik yang terhutang berikut biaya keterlambatan telah dibayar lunas oleh PIHAK KEDUA.</td>
	</tr>
	<tr>
		<td valign='top'>7.</td>
		<td align='justify'>Penyambungan kembali setelah pelaksanaan bongkar rampung sebagaimana dimaksud pada ayat (5) Pasal ini, akan diperlakukan sebagai sambungan baru (dikenakan  BP Baru dan Suplesi UJL sesuai ketentuan yang berlaku) serta tetap diwajibkan membayar rekening-rekening bulanan dan biaya keterlambatan (biaya keterlambatan 3 kali untuk tagihan bulan pertama, dua kali biaya keterlambatan untuk tagihan bulan kedua dan satu kali biaya keterlambatan untuk tagihan bulan ketiga) serta tagihan lainnya yang belum dilunasi.</td>
	</tr>	";
}

if($query_agenda['PAKET_SAR'] == '0' ) //penjabaran kalimat UJL
{
	$PASAL3= "
	<tr>
		<td >&nbsp;</td>
		<td align='left' valign='top' >b.</td>
		<td colspan=4 align='justify'>
			Uang Jaminan Langganan (UJL) :
		</td>
	</tr>
	<tr>
		<td colspan=2 >&nbsp;</td>
		<td align='justify'>
			- UJL sebelumnya
		</td>
		<td align='center'>:</td>
		<td >Rp.".number_format(@$query_agenda['RP_UJL_LAMA'])."</td>
		<td >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2 >&nbsp;</td>
		<td align='justify'>
			- UJL baru daya ".number_format(@$query_agenda['DAYA'])." VA
		</td>
		<td align='center'>:</td>
		<td >Rp. ".number_format(@$query_agenda['RP_UJL'])."</td>
		<td >&nbsp;</td>
	</tr>
	<tr>
		<td colspan=2 >&nbsp;</td>
		<td align='justify'>
			- UJL yang ditagihkan
		</td>
		<td align='center'>:</td>
		<td >Rp. ".number_format(@$query_agenda['RP_UJL'])."</td>
		<td >&nbsp;</td>
	</tr>

	";
}
else
{
	$PASAL3= "
	<tr>
		<td >&nbsp;</td>
		<td align='left' valign='top' >b.</td>
		<td colspan=4 align='justify'>
			Uang Jaminan Langganan (UJL) untuk daya ".number_format(@$query_agenda['DAYA'])." VA sebesar Rp. 0,- mengingat metode pembayaran telah menggunakan sistem autodebet.
		</td>
	</tr>
	";
}

	$data['data_pasal3']	= $PASAL3;

	$data['data_agenda']	= $query_agenda;
	$data['data_cust']		= $query_cust;
	$data['data_tarif']		= $query_tarif;
	$data['data_dil']		= $query_dilref;
	$data['data_jam']		= $query_jam;
	$data['data_peruntukan']= $query_peruntukan;
	$data['data_kec']		= $query_kec;

	$data['hari_ini'] 		= getHari(date_format(date_create($query_agenda['TGL_CETAKSIP']), 'w'));
	$data['tanggal_ini'] 	= ucwords($this->terbilang_angka(date_format(date_create($query_agenda['TGL_CETAKSIP']), 'j')));
	$data['bulan_ini'] 		= getBulan(date_format(date_create($query_agenda['TGL_CETAKSIP']), 'm'));
	$data['tahun_ini'] 		= ucwords($this->terbilang_angka(date_format(date_create($query_agenda['TGL_CETAKSIP']), 'Y')));

	$Rpt = $this->load->view("laporan/cetak_janjitipis",$data,TRUE);

	$SenD["TitlE"]	= "Cetakan Perjanjian dan Syarat Teknis ".$no_agenda;
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "15";
	$this->load->view("laporan/Report",$SenD);

}


function cetak_ps(){
	$cetak	= $this->uri->segment(3);
	$no_agenda = $this->uri->segment(4);
	$query = $this->db->query("
		select
			a.TARIF_BARU,
			a.DAYA_BARU,
			b.NAMA_CUST,
			a.NAMA_MOHON,
			a.TELP_MOHON,
			a.HP_MOHON,
			a.EMAIL_MOHON,
			a.ID_LANG,
			a.NAMA_LANG,
			a.ALAMAT_LANG,
			a.TOTAL_BIAYA,
			a.RP_UJL_BARU
		from tp_agenda a
		left join cust b on a.ID_CUST = b. ID_CUST
		where a.NO_AGENDA='".$no_agenda."'
	")->result_array()[0];
	$data['data']			= $query;
	$data['tahun_ini'] 		= date('Y');
	$data['bulan_ini'] 		= getBulan(date('m'));
	$data['tanggal_ini'] 	= date('j');
	$data['hari_ini'] 		= getHari(date('w'));
	$Rpt = $this->load->view("laporan/cetak_ps",$data,TRUE);

	$SenD["TitlE"]	= "Surat Pernyataan Langganan Sementara ".$no_agenda;
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-P";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);

}

public function rpt_rekapmohon(){
	$cetak		= $this->uri->segment(3);

	$Rpt = "";
	$Rpt .= "<table width=100% border=0>
			  <tr>
				<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
			  </tr>
			  <tr>
				<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
			  </tr>
			  <tr>
				<td colspan=8 style='font-size:6px;' >&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=8 style='font-size:14px;'><center><u>REKAP PERMOHONAN</center></u></td>
			  </tr>
			  <tr>
				<td colspan=8 style='font-size:12px;' ><center></center></td>
			  </tr>
			</table><br><br><br>";
	$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1'>
			  <tr>
				<td><center>THBL MOHON</center></td>
				<td><center>JENIS TRANSAKSI</center></td>
				<td><center>JUMLAH PERMOHONAN</center></td>
				<td><center>SUDAH SURVEY</center></td>
				<td><center>SUDAH SIP</center></td>
				<td><center>SUDAH BAYAR</center></td>
				<td><center>SUDAH PK BA</center></td>
				<td><center>SUDAH PDL</center></td>
			  </tr>";
	$q = $this->db->query("SELECT  THBL_MOHON,JNS_TRANSAKSI, COUNT(NO_AGENDA) JML_MOHON,COUNT(TGL_ENTRI_SURVEY) SUDAH_SURVEY, COUNT(TGL_CETAKSIP) SUDAH_SIP,
							COUNT(TGL_BAYAR) SUDAH_BAYAR, COUNT(TGL_CTK_PK) SUDAH_PK, COUNT(TGL_PDL) SUDAH_PDL
							FROM TP_AGENDA
							WHERE NO_AGENDA != '0' OR
							(TGL_ENTRI_SURVEY IS NOT NULL OR TGL_ENTRI_SURVEY != '0000-00-00 00:00:00') OR
							(TGL_CETAKSIP IS NOT NULL OR TGL_CETAKSIP != '0000-00-00 00:00:00') OR
							(TGL_BAYAR IS NOT NULL OR TGL_BAYAR != '0000-00-00 00:00:00') OR
							(TGL_CTK_PK IS NOT NULL OR TGL_CTK_PK != '0000-00-00 00:00:00') OR
							(TGL_PDL IS NOT NULL OR TGL_PDL != '0000-00-00 00:00:00')
							GROUP BY THBL_MOHON,JNS_TRANSAKSI ");
	foreach($q->result() as $r)
	{
		$THBL_MOHON		= $r->THBL_MOHON;
		$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
		$JML_MOHON		= $r->JML_MOHON;
		$SUDAH_SURVEY	= $r->SUDAH_SURVEY;
		$SUDAH_SIP		= $r->SUDAH_SIP;
		$SUDAH_BAYAR	= $r->SUDAH_BAYAR;
		$SUDAH_PK		= $r->SUDAH_PK;
		$SUDAH_PDL		= $r->SUDAH_PDL;

	$Rpt .="<tr>
				<td><center>$THBL_MOHON</center></td>
				<td>$JNS_TRANSAKSI</td>
				<td><center>$JML_MOHON</center></td>
				<td><center>$SUDAH_SURVEY</center></td>
				<td><center>$SUDAH_SIP</center></td>
				<td><center>$SUDAH_BAYAR</center></td>
				<td><center>$SUDAH_PK</center></td>
				<td><center>$SUDAH_PDL</center></td>
			  </tr>";

	}
$Rpt .="</table>";
	$SenD["TitlE"]	= "Cetakan Rekap Permohonan ".date('Y-m-d H:i:s');
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-L";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "2";
	$this->load->view("laporan/Report",$SenD);
}

public function rpt_rekapmohonexcel(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'JENIS TRANSAKSI')
            ->setCellValue('C1', 'JUMLAH PERMOHONAN')
            ->setCellValue('D1', 'SUDAH SURVEY')
            ->setCellValue('E1', 'SUDAH SIP')
            ->setCellValue('F1', 'SUDAH BAYAR')
            ->setCellValue('G1', 'SUDAH PK BA')
            ->setCellValue('H1', 'SUDAH PDL');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT  THBL_MOHON,JNS_TRANSAKSI, COUNT(NO_AGENDA) JML_MOHON,COUNT(TGL_ENTRI_SURVEY) SUDAH_SURVEY, COUNT(TGL_CETAKSIP) SUDAH_SIP,
							COUNT(TGL_BAYAR) SUDAH_BAYAR, COUNT(TGL_CTK_PK) SUDAH_PK, COUNT(TGL_PDL) SUDAH_PDL
							FROM TP_AGENDA
							WHERE NO_AGENDA != '0' OR
							(TGL_ENTRI_SURVEY IS NOT NULL OR TGL_ENTRI_SURVEY != '0000-00-00 00:00:00') OR
							(TGL_CETAKSIP IS NOT NULL OR TGL_CETAKSIP != '0000-00-00 00:00:00') OR
							(TGL_BAYAR IS NOT NULL OR TGL_BAYAR != '0000-00-00 00:00:00') OR
							(TGL_CTK_PK IS NOT NULL OR TGL_CTK_PK != '0000-00-00 00:00:00') OR
							(TGL_PDL IS NOT NULL OR TGL_PDL != '0000-00-00 00:00:00')
							GROUP BY THBL_MOHON,JNS_TRANSAKSI";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('C'.$counter, $row->JML_MOHON);
            $ex->setCellValue('D'.$counter, $row->SUDAH_SURVEY);
            $ex->setCellValue('E'.$counter, $row->SUDAH_SIP);
            $ex->setCellValue('F'.$counter, $row->SUDAH_BAYAR);
            $ex->setCellValue('G'.$counter, $row->SUDAH_PK);
            $ex->setCellValue('H'.$counter, $row->SUDAH_PDL);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("REKAP PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL REKAP PERMOHONAN";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detailmohon(){
	$cetak		= $this->uri->segment(3);
	$sub		= $this->uri->segment(4);
	if($sub == 'survey'){
		$Rpt = "";
		$Rpt .= "<table width=100% border=0>
				  <tr>
					<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
					<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				  </tr>
				  <tr>
					<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:6px;' >&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:14px;'><center><u>DETAIL YANG BELUM SURVEY</center></u></td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:12px;' ><center></center></td>
				  </tr>
				</table><br>";
		$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1' style='font-size:12px;'>
				  <tr>
					<td><center>THBL MOHON</center></td>
					<td><center>NO AGENDA</center></td>
					<td><center>ID CUSTOMER</center></td>
					<td><center>NAMA MOHON</center></td>
					<td><center>JENIS TRANSAKSI</center></td>
					<td><center>STATUS MOHON</center></td>
					<td><center>TANGGAL CETAK</center></td>
					<td><center>TANGGAL ENTRI</center></td>
					<td><center>NO SURVEY</center></td>
				  </tr>";
		$q = $this->db->query("SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CTK_SURVEY) TGL_CTK_SURVEY, date(TGL_ENTRI_SURVEY) TGL_ENTRI_SURVEY, NO_SURVEY
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CTK_SURVEY) OR TGL_CTK_SURVEY = '0000:00:00 00:00:00' ");
		foreach($q->result() as $r)
		{
			$THBL_MOHON		= $r->THBL_MOHON;
			$NO_AGENDA		= $r->NO_AGENDA;
			$ID_CUST		= $r->ID_CUST;
			$NAMA_MOHON		= $r->NAMA_MOHON;
			$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
			$STATUS_MOHON	= $r->STATUS_MOHON;
			$TGL_CTK_SURVEY	= $r->TGL_CTK_SURVEY;
			$TGL_ENTRI_SURVEY	= $r->TGL_ENTRI_SURVEY;
			$NO_SURVEY		= $r->NO_SURVEY;

		$Rpt .="<tr>
					<td><center>$THBL_MOHON</center></td>
					<td>$NO_AGENDA</td>
					<td><center>$ID_CUST</center></td>
					<td>$NAMA_MOHON</td>
					<td>$JNS_TRANSAKSI</td>
					<td>$STATUS_MOHON</td>
					<td><center>$TGL_CTK_SURVEY</center></td>
					<td><center>$TGL_ENTRI_SURVEY</center></td>
					<td><center>$NO_SURVEY</center></td>
				  </tr>";

		}
		$Rpt .="</table>";
	}elseif($sub == 'sip'){
		$Rpt = "";
		$Rpt .= "<table width=100% border=0>
				  <tr>
					<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
					<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				  </tr>
				  <tr>
					<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:6px;' >&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:14px;'><center><u>DETAIL YANG BELUM SIP</center></u></td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:12px;' ><center></center></td>
				  </tr>
				</table><br>";
		$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1' style='font-size:12px;'>
				  <tr>
					<td><center>THBL MOHON</center></td>
					<td><center>NO AGENDA</center></td>
					<td><center>ID CUSTOMER</center></td>
					<td><center>NAMA MOHON</center></td>
					<td><center>JENIS TRANSAKSI</center></td>
					<td><center>STATUS MOHON</center></td>
					<td><center>TANGGAL SIP</center></td>
					<td><center>NO SIP</center></td>
				  </tr>";
		$q = $this->db->query("SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CETAKSIP) TGL_CETAKSIP, NO_SIP
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CETAKSIP) OR TGL_CETAKSIP = '0000:00:00 00:00:00' ");
		foreach($q->result() as $r)
		{
			$THBL_MOHON		= $r->THBL_MOHON;
			$NO_AGENDA		= $r->NO_AGENDA;
			$ID_CUST		= $r->ID_CUST;
			$NAMA_MOHON		= $r->NAMA_MOHON;
			$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
			$STATUS_MOHON	= $r->STATUS_MOHON;
			$TGL_CETAKSIP	= $r->TGL_CETAKSIP;
			$NO_SIP			= $r->NO_SIP;

		$Rpt .="<tr>
					<td><center>$THBL_MOHON</center></td>
					<td>$NO_AGENDA</td>
					<td><center>$ID_CUST</center></td>
					<td>$NAMA_MOHON</td>
					<td>$JNS_TRANSAKSI</td>
					<td>$STATUS_MOHON</td>
					<td><center>$TGL_CETAKSIP</center></td>
					<td><center>$NO_SIP</center></td>
				  </tr>";

		}
		$Rpt .="</table>";
	}elseif($sub == 'bayar'){
		$Rpt = "";
		$Rpt .= "<table width=100% border=0>
				  <tr>
					<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
					<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				  </tr>
				  <tr>
					<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:6px;' >&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:14px;'><center><u>DETAIL YANG BELUM BAYAR</center></u></td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:12px;' ><center></center></td>
				  </tr>
				</table><br>";
		$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1' style='font-size:12px;'>
				  <tr>
					<td><center>THBL MOHON</center></td>
					<td><center>NO AGENDA</center></td>
					<td><center>ID CUSTOMER</center></td>
					<td><center>NAMA MOHON</center></td>
					<td><center>JENIS TRANSAKSI</center></td>
					<td><center>STATUS MOHON</center></td>
					<td><center>TANGGAL BAYAR</center></td>
					<td><center>NO KWITANSI</center></td>
				  </tr>";
		$q = $this->db->query("SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_BAYAR) TGL_BAYAR, NO_KWITANSI
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_BAYAR) OR TGL_BAYAR = '0000:00:00 00:00:00' ");
		foreach($q->result() as $r)
		{
			$THBL_MOHON		= $r->THBL_MOHON;
			$NO_AGENDA		= $r->NO_AGENDA;
			$ID_CUST		= $r->ID_CUST;
			$NAMA_MOHON		= $r->NAMA_MOHON;
			$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
			$STATUS_MOHON	= $r->STATUS_MOHON;
			$TGL_BAYAR		= $r->TGL_BAYAR;
			$NO_KWITANSI	= $r->NO_KWITANSI;

		$Rpt .="<tr>
					<td><center>$THBL_MOHON</center></td>
					<td>$NO_AGENDA</td>
					<td><center>$ID_CUST</center></td>
					<td>$NAMA_MOHON</td>
					<td>$JNS_TRANSAKSI</td>
					<td>$STATUS_MOHON</td>
					<td><center>$TGL_BAYAR</center></td>
					<td><center>$NO_KWITANSI</center></td>
				  </tr>";

		}
		$Rpt .="</table>";
	}elseif($sub == 'pk'){
		$Rpt = "";
		$Rpt .= "<table width=100% border=0>
				  <tr>
					<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
					<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				  </tr>
				  <tr>
					<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:6px;' >&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:14px;'><center><u>DETAIL YANG BELUM PK</center></u></td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:12px;' ><center></center></td>
				  </tr>
				</table><br>";
		$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1' style='font-size:12px;'>
				  <tr>
					<td><center>THBL MOHON</center></td>
					<td><center>NO AGENDA</center></td>
					<td><center>ID CUSTOMER</center></td>
					<td><center>NAMA MOHON</center></td>
					<td><center>JENIS TRANSAKSI</center></td>
					<td><center>STATUS MOHON</center></td>
					<td><center>TANGGAL PK</center></td>
					<td><center>NO PK</center></td>
				  </tr>";
		$q = $this->db->query("SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CTK_PK) TGL_CTK_PK, NO_PK
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CTK_PK) OR TGL_CTK_PK = '0000:00:00 00:00:00' ");
		foreach($q->result() as $r)
		{
			$THBL_MOHON		= $r->THBL_MOHON;
			$NO_AGENDA		= $r->NO_AGENDA;
			$ID_CUST		= $r->ID_CUST;
			$NAMA_MOHON		= $r->NAMA_MOHON;
			$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
			$STATUS_MOHON	= $r->STATUS_MOHON;
			$TGL_CTK_PK		= $r->TGL_CTK_PK;
			$NO_PK			= $r->NO_PK;

		$Rpt .="<tr>
					<td><center>$THBL_MOHON</center></td>
					<td>$NO_AGENDA</td>
					<td><center>$ID_CUST</center></td>
					<td>$NAMA_MOHON</td>
					<td>$JNS_TRANSAKSI</td>
					<td>$STATUS_MOHON</td>
					<td><center>$TGL_CTK_PK</center></td>
					<td><center>$NO_PK</center></td>
				  </tr>";

		}
		$Rpt .="</table>";
	}elseif($sub == 'pdl'){
		$Rpt = "";
		$Rpt .= "<table width=100% border=0>
				  <tr>
					<td width=60% colspan=6 style='font-size:14px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
					<td width=20% colspan=2 rowspan=2><img src=".FCPATH."assets/admin/layout4/img/epi_rpt.png alt='logo' width='135' height='70' /></td>
				  </tr>
				  <tr>
					<td colspan=6 style='font-size:12px;' valign=top>Area Pelabuhan Tanjung Priok<br />Jakarta Utara,DKI JAKARTA</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:6px;' >&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:14px;'><center><u>DETAIL YANG BELUM PDL</center></u></td>
				  </tr>
				  <tr>
					<td colspan=8 style='font-size:12px;' ><center></center></td>
				  </tr>
				</table><br>";
		$Rpt .="<table width='100%' border='1' cellspacing='1' cellpadding='1' style='font-size:12px;'>
				  <tr>
					<td><center>THBL MOHON</center></td>
					<td><center>NO AGENDA</center></td>
					<td><center>ID CUSTOMER</center></td>
					<td><center>NAMA MOHON</center></td>
					<td><center>JENIS TRANSAKSI</center></td>
					<td><center>STATUS MOHON</center></td>
					<td><center>TANGGAL PDL</center></td>
					<td><center>NO PDL</center></td>
				  </tr>";
		$q = $this->db->query("SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_PDL) TGL_PDL, NO_PDL
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_PDL) OR TGL_PDL = '0000:00:00 00:00:00' ");
		foreach($q->result() as $r)
		{
			$THBL_MOHON		= $r->THBL_MOHON;
			$NO_AGENDA		= $r->NO_AGENDA;
			$ID_CUST		= $r->ID_CUST;
			$NAMA_MOHON		= $r->NAMA_MOHON;
			$JNS_TRANSAKSI	= $r->JNS_TRANSAKSI;
			$STATUS_MOHON	= $r->STATUS_MOHON;
			$TGL_PDL		= $r->TGL_PDL;
			$NO_PDL			= $r->NO_PDL;

		$Rpt .="<tr>
					<td><center>$THBL_MOHON</center></td>
					<td>$NO_AGENDA</td>
					<td><center>$ID_CUST</center></td>
					<td>$NAMA_MOHON</td>
					<td>$JNS_TRANSAKSI</td>
					<td>$STATUS_MOHON</td>
					<td><center>$TGL_PDL</center></td>
					<td><center>$NO_PDL</center></td>
				  </tr>";

		}
		$Rpt .="</table>";
	}


	$SenD["TitlE"]	= "Cetakan Detail ".$sub." ".date('Y-m-d H:i:s');
	$SenD["OutpuT"]	= $Rpt;
	$SenD["CetaK"]	= $cetak;
	$SenD["Kertas"]	= "A4-L";
	$SenD["tmargin"]= "15";
	$SenD["bmargin"]= "15";
	$this->load->view("laporan/Report",$SenD);
}

public function rpt_detailmohonexcelsurvey(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'NO AGENDA')
            ->setCellValue('C1', 'ID CUSTOMER')
            ->setCellValue('D1', 'NAMA MOHON')
            ->setCellValue('E1', 'JENIS TRANSAKSI')
            ->setCellValue('F1', 'STATUS MOHON')
            ->setCellValue('G1', 'TANGGAL CETAK')
            ->setCellValue('H1', 'TANGGAL ENTRI')
            ->setCellValue('I1', 'NO SURVEY');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CTK_SURVEY) TGL_CTK_SURVEY,date(TGL_ENTRI_SURVEY) TGL_ENTRI_SURVEY, NO_SURVEY
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CTK_SURVEY) OR TGL_CTK_SURVEY = '0000:00:00 00:00:00'";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('C'.$counter, $row->ID_CUST);
            $ex->setCellValue('D'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('E'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('F'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('G'.$counter, $row->TGL_CTK_SURVEY);
            $ex->setCellValue('H'.$counter, $row->TGL_ENTRI_SURVEY);
            $ex->setCellValue('I'.$counter, $row->NO_SURVEY);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("DETAIL PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL DETAIL BELUM SURVEY";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detailmohonexcelsip(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'NO AGENDA')
            ->setCellValue('C1', 'ID CUSTOMER')
            ->setCellValue('D1', 'NAMA MOHON')
            ->setCellValue('E1', 'JENIS TRANSAKSI')
            ->setCellValue('F1', 'STATUS MOHON')
            ->setCellValue('G1', 'TANGGAL CETAK')
            ->setCellValue('H1', 'NO SIP');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CETAKSIP) TGL_CETAKSIP, NO_SURVEY
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CETAKSIP) OR TGL_CETAKSIP = '0000:00:00 00:00:00'";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('C'.$counter, $row->ID_CUST);
            $ex->setCellValue('D'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('E'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('F'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('G'.$counter, $row->TGL_CETAKSIP);
            $ex->setCellValue('H'.$counter, $row->NO_SURVEY);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("DETAIL PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL DETAIL BELUM SIP";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detailmohonexcelbayar(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'NO AGENDA')
            ->setCellValue('C1', 'ID CUSTOMER')
            ->setCellValue('D1', 'NAMA MOHON')
            ->setCellValue('E1', 'JENIS TRANSAKSI')
            ->setCellValue('F1', 'STATUS MOHON')
            ->setCellValue('G1', 'TANGGAL BAYAR')
            ->setCellValue('H1', 'NO KWITANSI');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_BAYAR) TGL_BAYAR, NO_KWITANSI
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_BAYAR) OR TGL_BAYAR = '0000:00:00 00:00:00'";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('C'.$counter, $row->ID_CUST);
            $ex->setCellValue('D'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('E'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('F'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('G'.$counter, $row->TGL_BAYAR);
            $ex->setCellValue('H'.$counter, $row->NO_KWITANSI);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("DETAIL PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL DETAIL BELUM BAYAR";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detailmohonexcelpk(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'NO AGENDA')
            ->setCellValue('C1', 'ID CUSTOMER')
            ->setCellValue('D1', 'NAMA MOHON')
            ->setCellValue('E1', 'JENIS TRANSAKSI')
            ->setCellValue('F1', 'STATUS MOHON')
            ->setCellValue('G1', 'TANGGAL PK')
            ->setCellValue('H1', 'NO PK');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_CTK_PK) TGL_CTK_PK, NO_PK
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_CTK_PK) OR TGL_CTK_PK = '0000:00:00 00:00:00'";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('C'.$counter, $row->ID_CUST);
            $ex->setCellValue('D'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('E'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('F'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('G'.$counter, $row->TGL_CTK_PK);
            $ex->setCellValue('H'.$counter, $row->NO_PK);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("DETAIL PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL DETAIL BELUM PK";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detailmohonexcelpdl(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'NO AGENDA')
            ->setCellValue('C1', 'ID CUSTOMER')
            ->setCellValue('D1', 'NAMA MOHON')
            ->setCellValue('E1', 'JENIS TRANSAKSI')
            ->setCellValue('F1', 'STATUS MOHON')
            ->setCellValue('G1', 'TANGGAL PDL')
            ->setCellValue('H1', 'NO PDL');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBL_MOHON,NO_AGENDA,ID_CUST,NAMA_MOHON,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_PDL) TGL_PDL, NO_PDL
									FROM TP_AGENDA a
									JOIN TR_STATUSMOHON b ON a.STATUS_MOHON=b.ID
									WHERE ISNULL(TGL_PDL) OR TGL_PDL = '0000:00:00 00:00:00'";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('C'.$counter, $row->ID_CUST);
            $ex->setCellValue('D'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('E'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('F'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('G'.$counter, $row->TGL_PDL);
            $ex->setCellValue('H'.$counter, $row->NO_PDL);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PERMOHONAN")
            ->setSubject("REKAP PERMOHONAN")
            ->setDescription("DETAIL PERMOHONAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PERMOHONAN');
        $TitlE 		= "HASIL DETAIL BELUM PDL";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}


public function rpt_rekaplunasonlineexcel(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#0');


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL LUNAS')
            ->setCellValue('B1', 'TANGGAL LUNAS')
            ->setCellValue('C1', 'JUMLAH PELANGGAN')
            ->setCellValue('D1', 'JUMLAH LANGGANAN')
            ->setCellValue('E1', 'JUMLAH LEMBAR')
            ->setCellValue('F1', 'JUMLAH PTL')
            ->setCellValue('G1', 'JUMLAH ANGSURAN')
            ->setCellValue('H1', 'JUMLAH RP EPI')
            ->setCellValue('I1', 'JUMLAH BPJU')
            ->setCellValue('J1', 'JUMLAH MATERAI')
            ->setCellValue('K1', 'JUMLAH TAGIHAN')
            ->setCellValue('L1', 'JUMLAH BK')
            ->setCellValue('M1', 'JUMLAH INVOICE');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_saldopiutang_rekaplunas_harian WHERE user_lunas = 'BUKOPIN' ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->Thbl_lunas);
            $ex->setCellValue('B'.$counter, $row->Tgl_Lunas);
            $ex->setCellValue('C'.$counter, $row->Jlh_cust);
            $ex->setCellValue('D'.$counter, $row->Jlh_lang);
            $ex->setCellValue('E'.$counter, $row->Jlh_lembar);
            $ex->setCellValue('F'.$counter, $row->Jlh_RPPTL);
            $ex->setCellValue('G'.$counter, $row->Jlh_RPAngsuran);
            $ex->setCellValue('H'.$counter, $row->Jlh_RpEPI);
            $ex->setCellValue('I'.$counter, $row->Jlh_RpBPJU);
            $ex->setCellValue('J'.$counter, $row->Jlh_RpMAT);
            $ex->setCellValue('K'.$counter, $row->Jlh_RpTag);
            $ex->setCellValue('L'.$counter, $row->Jlh_RpBK);
            $ex->setCellValue('M'.$counter, $row->Jlh_Invoice);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("PELUNASAN REKENING ONLINE")
            ->setSubject("PELUNASAN REKENING ONLINE")
            ->setDescription("PELUNASAN REKENING ONLINE by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('PELUNASAN REKENING ONLINE');
        $TitlE 		= "PELUNASAN REKENING ONLINE";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_rekaplunasonlinedetilexcel($thbllunon=''){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#0');


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL LUNAS')
						->setCellValue('B1', 'TANGGAL LUNAS')
						->setCellValue('C1', 'USER LUNAS')
						->setCellValue('D1', 'ID CUST')
						->setCellValue('E1', 'NAMA CUST')
						->setCellValue('F1', 'KOGOL')
						->setCellValue('G1', 'ID LANG')
						->setCellValue('H1', 'NAMA LANG')
						->setCellValue('I1', 'LEMBAR')
            ->setCellValue('J1', 'BIAYA PTL')
            ->setCellValue('K1', 'BIAYA BPJU')
            ->setCellValue('L1', 'BIAYA MATERAI')
            ->setCellValue('M1', 'BIAYA ANGSURAN')
            ->setCellValue('N1', 'BIAYA TAGIHAN')
            ->setCellValue('O1', 'BIAYA BK')
            ->setCellValue('P1', 'BIAYA INVOICE');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_saldopiutang_detillunas_harian WHERE USER_LUNAS = 'ONLINE' AND Thbl_lunas = '$thbllunon' ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_LUNAS);
            $ex->setCellValue('B'.$counter, $row->TGL_LUNAS);
            $ex->setCellValue('C'.$counter, $row->USER_LUNAS);
            $ex->setCellValue('D'.$counter, $row->ID_CUST);
            $ex->setCellValue('E'.$counter, $row->NAMA_CUST);
            $ex->setCellValue('F'.$counter, $row->KOGOL);
            $ex->setCellValue('G'.$counter, $row->ID_LANG);
            $ex->setCellValue('H'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('I'.$counter, $row->LEMBAR);
            $ex->setCellValue('J'.$counter, $row->RPPTL);
            $ex->setCellValue('K'.$counter, $row->RPBPJU);
            $ex->setCellValue('L'.$counter, $row->RPMAT);
            $ex->setCellValue('M'.$counter, $row->RPANGSURAN);
            $ex->setCellValue('N'.$counter, $row->RPTAG);
            $ex->setCellValue('O'.$counter, $row->RP_BK);
            $ex->setCellValue('P'.$counter, $row->TOTAL_INVOICE);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("PELUNASAN REKENING ALL")
            ->setSubject("PELUNASAN REKENING ALL")
            ->setDescription("PELUNASAN REKENING ALL by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('PELUNASAN REKENING ALL');
        $TitlE 		= "PELUNASAN REKENING ONLINE";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_rekaplunasofflinedetilexcel($thbllunoff=''){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('N')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('O')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('P')->getNumberFormat()->setFormatCode('#0');


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL LUNAS')
						->setCellValue('B1', 'TANGGAL LUNAS')
						->setCellValue('C1', 'USER LUNAS')
						->setCellValue('D1', 'ID CUST')
						->setCellValue('E1', 'NAMA CUST')
						->setCellValue('F1', 'KOGOL')
						->setCellValue('G1', 'ID LANG')
						->setCellValue('H1', 'NAMA LANG')
						->setCellValue('I1', 'LEMBAR')
            ->setCellValue('J1', 'BIAYA PTL')
            ->setCellValue('K1', 'BIAYA BPJU')
            ->setCellValue('L1', 'BIAYA MATERAI')
            ->setCellValue('M1', 'BIAYA ANGSURAN')
            ->setCellValue('N1', 'BIAYA TAGIHAN')
            ->setCellValue('O1', 'BIAYA BK')
            ->setCellValue('P1', 'BIAYA INVOICE');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_saldopiutang_detillunas_harian WHERE USER_LUNAS = 'OFFLINE' AND Thbl_lunas = '$thbllunoff' ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_LUNAS);
            $ex->setCellValue('B'.$counter, $row->TGL_LUNAS);
            $ex->setCellValue('C'.$counter, $row->USER_LUNAS);
            $ex->setCellValue('D'.$counter, $row->ID_CUST);
            $ex->setCellValue('E'.$counter, $row->NAMA_CUST);
            $ex->setCellValue('F'.$counter, $row->KOGOL);
            $ex->setCellValue('G'.$counter, $row->ID_LANG);
            $ex->setCellValue('H'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('I'.$counter, $row->LEMBAR);
            $ex->setCellValue('J'.$counter, $row->RPPTL);
            $ex->setCellValue('K'.$counter, $row->RPBPJU);
            $ex->setCellValue('L'.$counter, $row->RPMAT);
            $ex->setCellValue('M'.$counter, $row->RPANGSURAN);
            $ex->setCellValue('N'.$counter, $row->RPTAG);
            $ex->setCellValue('O'.$counter, $row->RP_BK);
            $ex->setCellValue('P'.$counter, $row->TOTAL_INVOICE);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("PELUNASAN REKENING ALL")
            ->setSubject("PELUNASAN REKENING ALL")
            ->setDescription("PELUNASAN REKENING ALL by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('PELUNASAN REKENING ALL');
        $TitlE 		= "PELUNASAN REKENING OFFLINE";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}


public function rpt_rekaplunasofflineexcel(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#0');


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL LUNAS')
            ->setCellValue('B1', 'TANGGAL LUNAS')
            ->setCellValue('C1', 'JUMLAH PELANGGAN')
            ->setCellValue('D1', 'JUMLAH LANGGANAN')
            ->setCellValue('E1', 'JUMLAH LEMBAR')
            ->setCellValue('F1', 'JUMLAH PTL')
            ->setCellValue('G1', 'JUMLAH ANGSURAN')
            ->setCellValue('H1', 'JUMLAH RP EPI')
            ->setCellValue('I1', 'JUMLAH BPJU')
            ->setCellValue('J1', 'JUMLAH MATERAI')
            ->setCellValue('K1', 'JUMLAH TAGIHAN')
            ->setCellValue('L1', 'JUMLAH BK')
            ->setCellValue('M1', 'JUMLAH INVOICE');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_saldopiutang_rekaplunas_harian WHERE user_lunas like '%EPI%' ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->Thbl_lunas);
            $ex->setCellValue('B'.$counter, $row->Tgl_Lunas);
            $ex->setCellValue('C'.$counter, $row->Jlh_cust);
            $ex->setCellValue('D'.$counter, $row->Jlh_lang);
            $ex->setCellValue('E'.$counter, $row->Jlh_lembar);
            $ex->setCellValue('F'.$counter, $row->Jlh_RPPTL);
            $ex->setCellValue('G'.$counter, $row->Jlh_RPAngsuran);
            $ex->setCellValue('H'.$counter, $row->Jlh_RpEPI);
            $ex->setCellValue('I'.$counter, $row->Jlh_RpBPJU);
            $ex->setCellValue('J'.$counter, $row->Jlh_RpMAT);
            $ex->setCellValue('K'.$counter, $row->Jlh_RpTag);
            $ex->setCellValue('L'.$counter, $row->Jlh_RpBK);
            $ex->setCellValue('M'.$counter, $row->Jlh_Invoice);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("PELUNASAN REKENING OFFLINE")
            ->setSubject("PELUNASAN REKENING OFFLINE")
            ->setDescription("PELUNASAN REKENING OFFLINE by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('PELUNASAN REKENING OFFLINE');
        $TitlE 		= "PELUNASAN REKENING OFFLINE";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detgolexcel($THBLREK='',$KOGOL='' ){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBLREK')
            ->setCellValue('B1', 'ID CUST')
            ->setCellValue('C1', 'NAMA CUST')
            ->setCellValue('D1', 'ID LANG')
            ->setCellValue('E1', 'NAMA LANG')
            ->setCellValue('F1', 'GOLONGAN')
            ->setCellValue('G1', 'DAYA')
            ->setCellValue('H1', 'RP KWH')
            ->setCellValue('I1', 'RP RPPTL')
            ->setCellValue('J1', 'RP ANGSURAN')
            ->setCellValue('K1', 'RP RBPJU')
            ->setCellValue('L1', 'RP MATERAI')
            ->setCellValue('M1', 'RP TAGIHAN');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT
				  `master_rekening`.`THBLREK` AS `THBLREK`,
				  `master_rekening`.`ID_CUST` AS `ID_CUST`,
				  `cust`.`NAMA_CUST` AS `NAMA_CUST`,
				  `master_rekening`.`ID_LANG` AS `ID_LANG`,
				  `dil_listrik_log`.`NAMA_LANG` AS `NAMA_LANG`,
				  `tr_golongan`.`uraian` AS `GOLONGAN`,
				  `master_rekening`.`DAYA` AS `JML_DAYA`,
				  `master_rekening`.`PEMKWH` AS `JML_KWH`,
				  `master_rekening`.`RPPTL` AS `JML_RPPTL`,
				  `master_rekening`.`RPANGSURAN` AS `JML_ANGS`,
				  `master_rekening`.`RPBPJU` AS `JML_RPBJU`,
				  `master_rekening`.`RPMAT` AS `JML_RPMAT`,
				  `master_rekening`.`RPTAG` AS `JML_TAGIHAN`
				FROM (`master_rekening`
				   LEFT JOIN `cust`
					 ON ((`master_rekening`.`ID_CUST` = `cust`.`ID_CUST`))
				   LEFT JOIN tr_golongan
					 ON master_rekening.`KOGOL` = tr_golongan.`kd_gol`
					 )
				   LEFT JOIN dil_listrik_log
					 ON master_rekening.`ID_LANG` = dil_listrik_log.`ID_LANG`
				WHERE master_rekening.THBLREK = '$THBLREK' AND master_rekening.KOGOL='$KOGOL'
				GROUP BY `master_rekening`.`ID_LANG`";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->ID_CUST);
            $ex->setCellValue('C'.$counter, $row->NAMA_CUST);
            $ex->setCellValue('D'.$counter, $row->ID_LANG);
            $ex->setCellValue('E'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('F'.$counter, $row->GOLONGAN);
            $ex->setCellValue('G'.$counter, $row->JML_DAYA);
            $ex->setCellValue('H'.$counter, $row->JML_KWH);
            $ex->setCellValue('I'.$counter, $row->JML_RPPTL);
            $ex->setCellValue('J'.$counter, $row->JML_ANGS);
            $ex->setCellValue('K'.$counter, $row->JML_RPBJU);
            $ex->setCellValue('L'.$counter, $row->JML_RPMAT);
            $ex->setCellValue('M'.$counter, $row->JML_TAGIHAN);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("DETAIL PER GOLONGAN")
            ->setSubject("DETAIL PER GOLONGAN")
            ->setDescription("DETAIL PER GOLONGAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("INFORMASI");
        $objPHPExcel->getActiveSheet()->setTitle('DETAIL PER GOLONGAN');
        $TitlE 		= "DETAIL PER GOLONGAN $KOGOL $THBLREK";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}


public function rpt_detareaexcel($THBLREK='',$KDAREA='' ){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');;

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBLREK')
            ->setCellValue('B1', 'ID CUST')
            ->setCellValue('C1', 'NAMA CUST')
            ->setCellValue('D1', 'ID LANG')
            ->setCellValue('E1', 'KODE AREA')
            ->setCellValue('F1', 'JUMLAH DAYA')
            ->setCellValue('G1', 'JUMLAH KWH')
            ->setCellValue('H1', 'JUMLAH RPPTL')
            ->setCellValue('I1', 'JUMLAH ANGSURAN')
            ->setCellValue('J1', 'JUMLAH RBPJU')
            ->setCellValue('K1', 'JUMLAH MATERAI')
            ->setCellValue('L1', 'JUMLAH TAGIHAN');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "select
					`master_rekening`.`THBLREK` AS `THBLREK`,
					`master_rekening`.`ID_CUST` AS `ID_CUST`,
					`cust`.`NAMA_CUST` AS `NAMA_CUST`,
					`master_rekening`.`ID_LANG` AS `LANGG`,
					`master_rekening`.`KD_AREA` AS `kd_area`,
					`master_rekening`.`DAYA` AS `JLH_DAYA`,
					`master_rekening`.`PEMKWH` AS `JLH_KWH`,
					`master_rekening`.`RPPTL` AS `JLH_RPPTL`,
					`master_rekening`.`RPANGSURAN` AS `JLH_ANGS`,
					`master_rekening`.`RPBPJU` AS `JLH_RPBJU`,
					`master_rekening`.`RPMAT` AS `JLH_RPMAT`,
					`master_rekening`.`RPTAG` AS `JLH_TAGIHAN`
				from (`master_rekening`
				left join `cust`
				on ((`master_rekening`.`ID_CUST` = `cust`.`ID_CUST`)))
				where `master_rekening`.`THBLREK`= '$THBLREK' AND `master_rekening`.`KD_AREA`='$KDAREA' ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->ID_CUST);
            $ex->setCellValue('C'.$counter, $row->NAMA_CUST);
            $ex->setCellValue('D'.$counter, $row->LANGG);
            $ex->setCellValue('E'.$counter, $row->kd_area);
            $ex->setCellValue('F'.$counter, $row->JLH_DAYA);
            $ex->setCellValue('G'.$counter, $row->JLH_KWH);
            $ex->setCellValue('H'.$counter, $row->JLH_RPPTL);
            $ex->setCellValue('I'.$counter, $row->JLH_ANGS);
            $ex->setCellValue('J'.$counter, $row->JLH_RPBJU);
            $ex->setCellValue('K'.$counter, $row->JLH_RPMAT);
            $ex->setCellValue('L'.$counter, $row->JLH_TAGIHAN);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("DETAIL PER GOLONGAN")
            ->setSubject("DETAIL PER GOLONGAN")
            ->setDescription("DETAIL PER GOLONGAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("INFORMASI");
        $objPHPExcel->getActiveSheet()->setTitle('DETAIL PER GOLONGAN');
        $TitlE 		= "DETAIL PER AREA $KDAREA $THBLREK";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}


public function rpt_angsuranexcel(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
		$objPHPExcel->getActiveSheet()->getStyle('M')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBLREK')
			->setCellValue('B1', 'ID LANGGANAN')
			->setCellValue('C1', 'NAMA LANGGANAN')
			->setCellValue('D1', 'ID CUST')
			->setCellValue('E1', 'NAMA CUSTOMER')
			->setCellValue('F1', 'RP BP')
			->setCellValue('G1', 'RP UJL')
			->setCellValue('H1', 'RP BK')
			->setCellValue('I1', 'RP KWHTAG')
			->setCellValue('J1', 'RP P2TL')
            ->setCellValue('K1', 'RP INVESTASI')
            ->setCellValue('L1', 'RP MATERAI')
            ->setCellValue('M1', 'TANGGAL');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT a.THBLREK, a.ID_LANG, b.NAMA_LANG,b.ID_CUST,c.NAMA_CUST, a.RP_BP, a.RP_UJL, a.RP_BK, a.RP_KWH, a.RP_P2TL, a.RP_INVESTASI, a.RP_METERAI, a.TGL_BUAT
					FROM TP_ANGSURAN a
					LEFT OUTER JOIN DIL_LISTRIK_LOG b ON CONCAT(b.THBLREK,b.ID_LANG) = CONCAT(a.THBLREK,a.ID_LANG)
					LEFT JOIN CUST c ON b.ID_CUST=c.ID_CUST
					ORDER BY a.THBLREK DESC";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->ID_LANG);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->ID_CUST);
            $ex->setCellValue('E'.$counter, $row->NAMA_CUST);
            $ex->setCellValue('F'.$counter, $row->RP_BP);
            $ex->setCellValue('G'.$counter, $row->RP_UJL);
            $ex->setCellValue('H'.$counter, $row->RP_BK);
            $ex->setCellValue('I'.$counter, $row->RP_KWH);
            $ex->setCellValue('J'.$counter, $row->RP_P2TL);
            $ex->setCellValue('K'.$counter, $row->RP_INVESTASI);
            $ex->setCellValue('L'.$counter, $row->RP_METERAI);
            $ex->setCellValue('M'.$counter, $row->TGL_BUAT);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("DETAIL ANGSURAN")
            ->setSubject("DETAIL ANGSURAN")
            ->setDescription("DETAIL ANGSURAN by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('DETAIL ANGSURAN');
        $TitlE 		= "DETAIL ANGSURAN";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_kendalikreditperlangsum(){
	$cetak		= '1';
	$user 		= $this->session->userdata('nama');
	$thblrek 	= $this->uri->segment(3);
	$id_lang 	= $this->uri->segment(4);
	$Rpt = "";
	$q = $this->db->query("select GROUP_CONCAT(case right(a.thblrek,2) when 01 then CONCAT('Januari ',LEFT(a.thblrek,4)) when 02 then CONCAT('Februari ',LEFT(a.thblrek,4)) when 03 then CONCAT('Maret ',LEFT(a.thblrek,4)) when 04 then CONCAT('April ',LEFT(a.thblrek,4)) when 05 then CONCAT('Mei ',LEFT(a.thblrek,4)) when 06 then CONCAT('Juni ',LEFT(a.thblrek,4)) when 07 then CONCAT('Juli ',LEFT(a.thblrek,4)) when 08 then CONCAT('Agustus ',LEFT(a.thblrek,4)) when 09 then CONCAT('September ',LEFT(a.thblrek,4)) when 10 then CONCAT('Oktober ',LEFT(a.thblrek,4)) when 11 then CONCAT('November ',LEFT(a.thblrek,4)) else CONCAT('Desember ',LEFT(a.thblrek,4)) end) group_thblrek,(SELECT MAX(thblrek) FROM master_rekening where id_lang='$id_lang' and status_pmt='1' ) thn, b.kd_area,b.nama_lang, a.id_lang, b.alamat_lang, count(a.thblrek) lembar, b.no_meter, b.kd_gt, b.tarif, b.daya, sum(a.rptag) rptag, sum(a.rp_bk) rp_bk, c.`nama` PROV, d.`nama` KAB, e.`nama` KEC, f.EMAIL1, f.EMAIL2 from master_rekening a left join dil_listrik_ref b on a.ID_LANG = b.ID_LANG JOIN tr_prov c ON b.PROV_LANG = c.`id_prov` JOIN tr_kab d ON b.`KOTA_LANG` = d.`id_kab` JOIN tr_kec e ON b.`KEC_LANG` = e.`id_kec` left join cust f ON b.ID_CUST = f.ID_CUST where a.id_lang='$id_lang' and STATUS_PMT='1' group by id_lang  ");

	$emails = array();
	foreach($q->result() as $r)
	{
		$BLNTHN 	= $r->group_thblrek;
		$THNAKHIR 	= $r->thn;
		$KD_AREA 	= $r->kd_area;
		$NAMA_LANG 	= $r->nama_lang;
		$ALAMAT_LANG= $r->alamat_lang;
		$LEMBAR		= $r->lembar;
		$KEC_LANG	= $r->KEC;
		$KOTA_LANG	= $r->KAB;
		$PROV_LANG	= $r->PROV;
		$NO_METER 	= $r->no_meter;
		$KD_GT 		= $r->kd_gt;
		$TARIF 		= $r->tarif;
		$DAYA 		= $r->daya;
		$RP_TAG		= $r->rptag;
		$RP_BK 		= $r->rp_bk;
		$EMAIL2		= $r->EMAIL2;
		$EMAIL1		= $r->EMAIL1;

	$ceklog = $this->db->query("select cetak_kendali_a from master_rekening
									where cetak_kendali_a = '0000-00-00 00:00:00' and id_lang = '$id_lang' and thblrek = '$thblrek' ");
	if($ceklog->num_rows() > 0){
		$this->db->query("UPDATE MASTER_REKENING SET CETAK_KENDALI_A = now() WHERE ID_LANG = '$id_lang' AND THBLREK = '$thblrek' ");
	}else{
		$this->db->query("INSERT INTO LOG_PEMUTUSAN (periode, id_lang, lembar, tgl_cetak, user, keterangan)
							SELECT periode, id_lang, count(thblrek) lembar, now() tgl_cetak, '$user', 'CETAK PEMUTUSAN SEMENTARA (Tahap 1)' keterangan
							FROM MASTER_REKENING WHERE id_lang='$id_lang' and thblrek in ('$thblrek')
							GROUP BY thblrek");
	}

	$NAMATTD  = $this->db->get_where('tr_jabatan', array('ID' => '5'))->row('NAMA');
	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$TGL_TTD  = tanggal_ttd(date("Y-m-d"));
	$BAKHIR   = getBulan(substr($THNAKHIR,4,2));
	$TAKHIR   = substr($THNAKHIR,0,4);
	$TOTAL    = $RP_TAG + $RP_BK;
	if($EMAIL1 == null){
		$EMAIL = $EMAIL2;
	}elseif($EMAIL2 == null){
		$EMAIL = $EMAIL1;
	}else{
		$EMAIL = $EMAIL1.", ".$EMAIL2;
	}


	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td width=60% colspan=2 style='font-size:12px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;'><center><u>PEMBERITAHUAN PELAKSANAAN PEMUTUSAN SEMENTARA SAMBUNGAN TENAGA LISTRIK</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:10px;' ><center>$NO_TUS</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=6> Kepada Yth. </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=40%>$NAMA_LANG</td>
				<td width=15%></td>
				<td width=1%></td>
				<td width=10%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Langganan</td>
				<td>:</td>
				<td >$id_lang</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td >$ALAMAT_LANG</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nomor Meter</td>
				<td>:</td>
				<td >$NO_METER</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama Gardu</td>
				<td>:</td>
				<td >$KD_GT</td>
				<td>Rp. Tagihan</td>
				<td>:</td>
				<td  align=right>".number_format($RP_TAG)."</td>
			  </tr>
			  <tr>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td >$TARIF  /  $DAYA VA</td>
				<td>Rp. BK</td>
				<td>:</td>
				<td  align=right>".number_format($RP_BK)."</td>
			  </tr>
			  <tr>
				<td valign='top'>Rekening</td>
				<td valign='top'>:</td>
				<td valign='top'>$BLNTHN ($LEMBAR LEMBAR)</td>
				<td valign='top'>Rp. Total</td>
				<td valign='top'>:</td>
				<td valign='top' align=right>".number_format($TOTAL)."</td>
			  </tr>
			  <tr>
				<td colspan=3>Jumlah Biaya Keterlambatan s.d bulan : $BAKHIR $TAKHIR</td>
				<td colspan=3>Jumlah tunggakan (Belum termasuk biaya Administrasi)</td>

			  </tr></table>";

	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=5><p>&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini diberitahukan dengan hormat bahwa pada hari ini aliran listrik di rumah/alamat seperti tersebut diatas
							terpaksa diputus untuk sementara karena rekening listrik belum dilunasi pada waktu yang telah ditetapkan.
							Penyambungan kembali akan dilakukan pada setiap hari jam kerja apabila rekening serta biaya keterlambatan dilunasi
							di tempat penerimaan pembayaran rekening listrik, atau bank yang ditunjuk oleh PT. EPI.</p>
							<p>&nbsp;&nbsp;&nbsp;&nbsp;Apabila dalam jangka waktu 60 hari terhitung sejak tanggal jatuh tempo tunggakan belum dilunasi, maka instalasi
							milik PT EPI akan di bongkar, dan permintaan penyambungan kembali diberlakukan sebagai permohonan penyambungan baru,
							pemohon diwajibkan membayar Biaya Penyambungan (BP), Uang Jaminan Langganan (UJL), serta seluruh tagihan rekening
							yang belum dilunasi.</p>

				</td>
				<tr>
				<td colspan=5>UNTUK MENGHINDARI RESIKO, MOHON TIDAK TITIP PEMBAYARAN REKENING KEPADA PETUGAS
				</td>
				  </tr>
				  <tr>
					<td width=20%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=40%>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4><center>PADA WAKTU MELAKUKAN PEMBAYARAN DIMOHON</center></td>
					<td><center>Jakarta, $TGL_TTD</center></td>
				  </tr>
				  <tr>
					<td colspan=4><center>MENUNJUKAN SURAT PEMBERITAHUAN INI</center></td>
					<td><center>MANAGER OPERASI</center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>PETUGAS PEMUTUS ...............................................</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>Abaikan pemberitahuan ini jika sudah membayar tagihan</td>
					<td><center><b>$NAMATTD</b></center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
			</table>";
	}
		$SenD["TitlE"]	= "Cetak Pemutusan $thblrek $id_lang";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$SenD["Emailto"]= $EMAIL;
		$SenD["Subject"]= "Pemberitahuan Pemutusan Sementara";
		$SenD["Message"]= "Berikut kami lampirkan surat Pemberitahuan Pemutusan Sementara. Abaikan pemberitahuan ini jika sudah membayar tagihan";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_kendalikreditperlang(){
	$cetak		= '1';
	$user 		= $this->session->userdata('nama');
	$thblrek 	= $this->uri->segment(3);
	$id_lang 	= $this->uri->segment(4);
	$Rpt = "";

	$q = $this->db->query("select a.thblrek,b.kd_area,b.nama_lang, a.id_lang, b.alamat_lang, '1' lembar, b.no_meter, b.kd_gt, b.tarif, b.daya, a.rptag, a.rp_bk, c.`nama` PROV, d.`nama` KAB, e.`nama` KEC, f.EMAIL1, f.EMAIL2
							from master_rekening a
							left join dil_listrik_ref b on a.ID_LANG = b.ID_LANG
							JOIN tr_prov c ON b.PROV_LANG = c.`id_prov`
							JOIN tr_kab d ON b.`KOTA_LANG` = d.`id_kab`
							JOIN tr_kec e ON b.`KEC_LANG` = e.`id_kec`
							left join cust f ON b.ID_CUST = f.ID_CUST
							where a.id_lang='$id_lang' and STATUS_PMT='1' ");

	$emails = array();
	foreach($q->result() as $r)
	{
		$THBLREK 	= $r->thblrek;
		$KD_AREA 	= $r->kd_area;
		$NAMA_LANG 	= $r->nama_lang;
		$ALAMAT_LANG= $r->alamat_lang;
		$LEMBAR		= $r->lembar;
		$KEC_LANG	= $r->KEC;
		$KOTA_LANG	= $r->KAB;
		$PROV_LANG	= $r->PROV;
		$NO_METER 	= $r->no_meter;
		$KD_GT 		= $r->kd_gt;
		$TARIF 		= $r->tarif;
		$DAYA 		= $r->daya;
		$RP_TAG		= $r->rptag;
		$RP_BK 		= $r->rp_bk;
		$EMAIL2		= $r->EMAIL2;
		$EMAIL1		= $r->EMAIL1;

	$ceklog = $this->db->query("select cetak_kendali_a from master_rekening
									where cetak_kendali_a = '0000-00-00 00:00:00' and id_lang = '$id_lang' and thblrek = '$thblrek' ");
	if($ceklog->num_rows() > 0){
		$this->db->query("UPDATE MASTER_REKENING SET CETAK_KENDALI_A = now() WHERE ID_LANG = '$id_lang' AND THBLREK = '$thblrek' ");
	}else{
		$this->db->query("INSERT INTO LOG_PEMUTUSAN (periode, id_lang, lembar, tgl_cetak, user, keterangan)
							SELECT periode, id_lang, count(thblrek) lembar, now() tgl_cetak, '$user', 'CETAK PEMUTUSAN SEMENTARA (Tahap 1)' keterangan
							FROM MASTER_REKENING WHERE id_lang='$id_lang' and thblrek in ('$thblrek')
							GROUP BY thblrek");
	}

	$NAMATTD  = $this->db->get_where('tr_jabatan', array('ID' => '5'))->row('NAMA');
	#AMBIL NAMA HPL PELABUHAN ...
	$q = $this->db->query("
							SELECT * FROM TR_AREA WHERE kd_area = '".$KD_AREA."'
							");
	foreach($q->result() as $r)
	{
		$KD_AREAx		= $r->kd_area;
		$NM_AREA		= $r->nm_area;
	}

	$TGL_TTD = tanggal_ttd(date("Y-m-d"));
	$BLN = getBulan(substr($THBLREK,4,2));
	$THN = substr($THBLREK,0,4);
	$TOTAL = $RP_TAG + $RP_BK;
	if($EMAIL1 == null){
		$EMAIL = $EMAIL2;
	}elseif($EMAIL2 == null){
		$EMAIL = $EMAIL1;
	}else{
		$EMAIL = $EMAIL1.", ".$EMAIL2;
	}


	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td width=60% colspan=2 style='font-size:12px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;'><center><u>PEMBERITAHUAN PELAKSANAAN PEMUTUSAN SEMENTARA SAMBUNGAN TENAGA LISTRIK</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:10px;' ><center>$NO_TUS</center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=6> Kepada Yth. </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=40%>$NAMA_LANG</td>
				<td width=15%></td>
				<td width=1%></td>
				<td width=10%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Langganan</td>
				<td>:</td>
				<td >$id_lang</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td >$ALAMAT_LANG</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nomor Meter</td>
				<td>:</td>
				<td >$NO_METER</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama Gardu</td>
				<td>:</td>
				<td >$KD_GT</td>
				<td>Rp. Tagihan</td>
				<td>:</td>
				<td  align=right>".number_format($RP_TAG)."</td>
			  </tr>
			  <tr>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td >$TARIF  /  $DAYA VA</td>
				<td>Rp. BK</td>
				<td>:</td>
				<td  align=right>".number_format($RP_BK)."</td>
			  </tr>
			  <tr>
				<td>Rekening</td>
				<td>:</td>
				<td>$BLN $THN	($LEMBAR LEMBAR)</td>
				<td>Rp. Total</td>
				<td>:</td>
				<td align=right>".number_format($TOTAL)."</td>
			  </tr>
			  <tr>
				<td colspan=3>Jumlah Biaya Keterlambatan s.d bulan : $BLN $THN</td>
				<td colspan=3>Jumlah tunggakan (Belum termasuk biaya Administrasi)</td>

			  </tr></table>";

	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=5><p>&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini diberitahukan dengan hormat bahwa pada hari ini aliran listrik di rumah/alamat seperti tersebut diatas
							terpaksa diputus untuk sementara karena rekening listrik belum dilunasi pada waktu yang telah ditetapkan.
							Penyambungan kembali akan dilakukan pada setiap hari jam kerja apabila rekening serta biaya keterlambatan dilunasi
							di tempat penerimaan pembayaran rekening listrik, atau bank yang ditunjuk oleh PT. EPI.</p>
							<p>&nbsp;&nbsp;&nbsp;&nbsp;Apabila dalam jangka waktu 60 hari terhitung sejak tanggal jatuh tempo tunggakan belum dilunasi, maka instalasi
							milik PT EPI akan di bongkar, dan permintaan penyambungan kembali diberlakukan sebagai permohonan penyambungan baru,
							pemohon diwajibkan membayar Biaya Penyambungan (BP), Uang Jaminan Langganan (UJL), serta seluruh tagihan rekening
							yang belum dilunasi.</p>

				</td>
				<tr>
				<td colspan=5>UNTUK MENGHINDARI RESIKO, MOHON TIDAK TITIP PEMBAYARAN REKENING KEPADA PETUGAS
				</td>
				  </tr>
				  <tr>
					<td width=20%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=40%>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4><center>PADA WAKTU MELAKUKAN PEMBAYARAN DIMOHON</center></td>
					<td><center>Jakarta, $TGL_TTD</center></td>
				  </tr>
				  <tr>
					<td colspan=4><center>MENUNJUKAN SURAT PEMBERITAHUAN INI</center></td>
					<td><center>MANAGER OPERASI</center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>PETUGAS PEMUTUS ...............................................</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>Abaikan pemberitahuan ini jika sudah membayar tagihan</td>
					<td><center><b>$NAMATTD</b></center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
			</table><pagebreak>";
	}
		$SenD["TitlE"]	= "Cetak Pemutusan $thblrek $id_lang";
		$SenD["OutpuT"]	= $Rpt;
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$SenD["Emailto"]= $EMAIL;
		$SenD["Subject"]= "Pemberitahuan Pemutusan Sementara";
		$SenD["Message"]= "Berikut kami lampirkan surat Pemberitahuan Pemutusan Sementara. Abaikan pemberitahuan ini jika sudah membayar tagihan";
		$this->load->view("laporan/Report",$SenD);

}

public function rpt_kendalikreditall(){
	set_time_limit('0');
	$user = $this->session->userdata('nama');
	$cetak		= '1';
		$q = $this->db->query("select a.thblrek,b.kd_area,b.nama_lang, a.id_lang, b.alamat_lang, b.id_cust, count(a.thblrek) lembar, b.no_meter, b.kd_gt, b.tarif, b.daya, sum(a.rptag) rptag, sum(a.rp_bk) rp_bk, b.kec_lang, b.kota_lang, b.prov_lang
								from master_rekening a
								left join dil_listrik_new b on a.ID_LANG = b.ID_LANG
								where STATUS_PMT='1' and STATUS_LUNAS='0' and b.KD_MUT NOT IN ('N','') and a.KOGOL = '0'
								group by a.id_lang ");
		$Rpt ="";
		foreach($q->result() as $r)
		{
			$THBLREK 	= $r->thblrek;
			$ID_LANG 	= $r->id_lang;
			$KD_AREA 	= $r->kd_area;
			$NAMA_LANG 	= $r->nama_lang;
			$ALAMAT_LANG= $r->alamat_lang;
			$ID_CUST	= $r->id_cust;
			$LEMBAR		= $r->lembar;
			$KEC_LANGX	= $r->kec_lang;
			$KOTA_LANGX	= $r->kota_lang;
			$PROV_LANGX	= $r->prov_lang;
			$NO_METER 	= $r->no_meter;
			$KD_GT 		= $r->kd_gt;
			$TARIF 		= $r->tarif;
			$DAYA 		= $r->daya;
			$RP_TAG		= $r->rptag;
			$RP_BK 		= $r->rp_bk;

			$KEC_LANG = $this->db->get_where('tr_kec', array('id_kec' => $KEC_LANGX))->row('nama');
			$KOTA_LANG= $this->db->get_where('tr_kab', array('id_kab' => $KOTA_LANGX))->row('nama');
			$PROV_LANG= $this->db->get_where('tr_prov', array('id_prov' => $PROV_LANGX))->row('nama');
			$NM_AREA  = $this->db->get_where('tr_area', array('kd_area' => $KD_AREA))->row('nm_area');
			$EMAIL1   = $this->db->get_where('cust', array('id_cust' => $ID_CUST))->row('EMAIL1');
			$EMAIL2   = $this->db->get_where('cust', array('id_cust' => $ID_CUST))->row('EMAIL2');

			$TGL_TTD = tanggal_ttd(date("Y-m-d"));
			$BLN = getBulan(substr($THBLREK,4,2));
			$THN = substr($THBLREK,0,4);
			$TOTAL = $RP_TAG + $RP_BK;
			if($EMAIL1 == null){
				$EMAIL = $EMAIL2;
			}elseif($EMAIL2 == null){
				$EMAIL = $EMAIL1;
			}else{
				$EMAIL = $EMAIL1.", ".$EMAIL2;
			}

	$ceklog = $this->db->query("select cetak_kendali_a from master_rekening
									where cetak_kendali_a = '0000-00-00 00:00:00' and id_lang = '$ID_LANG' and thblrek = '$THBLREK' ");
	if($ceklog->num_rows() > 0){
		$this->db->query("UPDATE MASTER_REKENING SET CETAK_KENDALI_A = now() WHERE ID_LANG = '$ID_LANG' AND THBLREK = '$THBLREK' ");
	}else{
		$this->db->query("INSERT INTO LOG_PEMUTUSAN (periode, id_lang, lembar, tgl_cetak, user, keterangan)
							SELECT periode, id_lang, count(thblrek) lembar, now() tgl_cetak, '$user', 'CETAK PEMUTUSAN SEMENTARA (Tahap 1)' keterangan
							FROM MASTER_REKENING WHERE id_lang='$ID_LANG' and thblrek='$THBLREK'
							GROUP BY thblrek");
	}

	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td width=60% colspan=2 style='font-size:12px;' valign=bottom> PT ENERGI PELABUHAN INDONESIA </td>
				<td width=20% rowspan=2></td>
			  </tr>
			  <tr>
				<td colspan=2 style='font-size:12px;' valign=top>Area Pelabuhan $NM_AREA<br />".ucwords(strtolower($KOTA_LANG)).",	".$PROV_LANG."</td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:12px;'><center><u>PEMBERITAHUAN PELAKSANAAN PEMUTUSAN SEMENTARA SAMBUNGAN TENAGA LISTRIK</center></u></td>
			  </tr>
			  <tr>
				<td colspan=3 style='font-size:10px;' ><center></center></td>
			  </tr>
			  <tr>
				<td colspan=3>&nbsp;</td>
			  </tr>
			</table>";
	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=6> Kepada Yth. </td>
			  </tr>
			  <tr>
				<td width=15%>Nama</td>
				<td width=1%>:</td>
				<td width=40%>$NAMA_LANG</td>
				<td width=15%></td>
				<td width=1%></td>
				<td width=10%>&nbsp;</td>
			  </tr>
			  <tr>
				<td>ID Langganan</td>
				<td>:</td>
				<td >$ID_LANG</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Alamat</td>
				<td>:</td>
				<td >$ALAMAT_LANG</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nomor Meter</td>
				<td>:</td>
				<td >$NO_METER</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>
			  <tr>
				<td>Nama Gardu</td>
				<td>:</td>
				<td >$KD_GT</td>
				<td>Rp. Tagihan</td>
				<td>:</td>
				<td  align=right>".number_format($RP_TAG)."</td>
			  </tr>
			  <tr>
				<td>Tarif / Daya</td>
				<td>:</td>
				<td >$TARIF  /  $DAYA VA</td>
				<td>Rp. BK</td>
				<td>:</td>
				<td  align=right>".number_format($RP_BK)."</td>
			  </tr>
			  <tr>
				<td>Rekening</td>
				<td>:</td>
				<td>$BLN $THN	($LEMBAR LEMBAR)</td>
				<td>Rp. Total</td>
				<td>:</td>
				<td align=right>".number_format($TOTAL)."</td>
			  </tr>
			  <tr>
				<td colspan=3>Jumlah Biaya Keterlambatan s.d bulan : $BLN $THN</td>
				<td colspan=3>Jumlah tunggakan (Belum termasuk biaya Administrasi)</td>

			  </tr></table>";

	$Rpt .= "<table width=100% border=0 style='font-size:10px;'>
			  <tr>
				<td colspan=5><p>&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini diberitahukan dengan hormat bahwa pada hari ini aliran listrik di rumah/alamat seperti tersebut diatas
							terpaksa diputus untuk sementara karena rekening listrik belum dilunasi pada waktu yang telah ditetapkan.
							Penyambungan kembali akan dilakukan pada setiap hari jam kerja apabila rekening serta biaya keterlambatan dilunasi
							di tempat penerimaan pembayaran rekening listrik, atau bank yang ditunjuk oleh PT. EPI.</p>
							<p>&nbsp;&nbsp;&nbsp;&nbsp;Apabila dalam jangka waktu 60 hari terhitung sejak tanggal jatuh tempo tunggakan belum dilunasi, maka instalasi
							milik PT EPI akan di bongkar, dan permintaan penyambungan kembali diberlakukan sebagai permohonan penyambungan baru,
							pemohon diwajibkan membayar Biaya Penyambungan (BP), Uang Jaminan Langganan (UJL), serta seluruh tagihan rekening
							yang belum dilunasi.</p>

				</td>
				<tr>
				<td colspan=5>UNTUK MENGHINDARI RESIKO, MOHON TIDAK TITIP PEMBAYARAN REKENING KEPADA PETUGAS
				</td>
				  </tr>
				  <tr>
					<td width=20%>&nbsp;</td>
					<td width=20%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=10%>&nbsp;</td>
					<td width=40%>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4><center>PADA WAKTU MELAKUKAN PEMBAYARAN DIMOHON</center></td>
					<td><center>Jakarta, $TGL_TTD</center></td>
				  </tr>
				  <tr>
					<td colspan=4><center>MENUNJUKAN SURAT PEMBERITAHUAN INI</center></td>
					<td><center>MANAGER OPERASI</center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>PETUGAS PEMUTUS ...............................................</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td colspan=4>Abaikan pemberitahuan ini jika sudah membayar tagihan</td>
					<td><center><b>SETIO BUDIONO</b></center></td>
				  </tr>
				  <tr>
					<td >&nbsp;</td>
					<td >&nbsp;</td>
					<td colspan=2>&nbsp;</td>
					<td>&nbsp;</td>
				  </tr>
			</table><pagebreak>";
		}

		$dt = array();
		$template = $this->load->view("laporan/template_pemutusansementara",$dt,TRUE);
		$SenD["OutpuT"]	= $Rpt;
		$SenD["TitlE"]	= "Cetak Pemutusan";
		$SenD["CetaK"]	= $cetak;
		$SenD["Kertas"]	= "A4-P";
		$SenD["tmargin"]= "15";
		$SenD["bmargin"]= "2";
		$SenD["Emailto"]= $EMAIL;
		$SenD["Subject"]= "Pemberitahuan Pemutusan Sementara";
		$SenD["Message"]= $template;
		$SenD["Attach"] = "EMPTY";
		$this->load->view("laporan/Report",$SenD);
}


public function rpt_rekapentristandexcel(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL REKENING')
            ->setCellValue('B1', 'KODE AREA')
            ->setCellValue('C1', 'JUMLAH PELANGGAN')
            ->setCellValue('D1', 'BELUM ENTRI STAND')
            ->setCellValue('E1', 'SUDAH ENTRI STAND');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBLREK,KD_AREA,SUM(JML_LANG) JML_LANG,SUM(BELUM_ENTRI) BELUM_ENTRI, SUM(SUDAH_ENTRI) SUDAH_ENTRI FROM (
									SELECT THBLREK, KD_AREA, COUNT(ID_LANG) JML_LANG, '' BELUM_ENTRI, '' SUDAH_ENTRI
									FROM DPM_LISTRIK_REF GROUP BY KD_AREA
									UNION ALL
									SELECT THBLREK, KD_AREA,'0' JML_LANG,
									IFNULL((SELECT COUNT(TGL_BACA_AKHIR) FROM DPM_LISTRIK_REF
									WHERE TGL_BACA_AKHIR = '0000-00-00' OR ISNULL(TGL_BACA_AKHIR) OR TGL_BACA_AKHIR = ''  GROUP BY KD_AREA),0) BELUM_ENTRI,
									'0' SUDAH_ENTRI FROM DPM_LISTRIK_REF
									GROUP BY KD_AREA
									UNION ALL
									SELECT THBLREK,KD_AREA, '0' JML_LANG, '0' BELUM_ENTRI,COUNT(TGL_BACA_AKHIR) SUDAH_ENTRI
									FROM DPM_LISTRIK_REF WHERE TGL_BACA_AKHIR != '0000-00-00' OR TGL_BACA_AKHIR IS NOT NULL OR TGL_BACA_AKHIR != ''
									GROUP BY KD_AREA
									) q GROUP BY KD_AREA";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->KD_AREA);
            $ex->setCellValue('C'.$counter, $row->JML_LANG);
            $ex->setCellValue('D'.$counter, $row->BELUM_ENTRI);
            $ex->setCellValue('E'.$counter, $row->SUDAH_ENTRI);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP ENTRI STAND")
            ->setSubject("REKAP ENTRI STAND")
            ->setDescription("REKAP ENTRI STAND by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP ENTRI STAND');
        $TitlE 		= "HASIL REKAP ENTRI STAND";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_rekaphitungkwhexcel(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL REKENING')
            ->setCellValue('B1', 'KODE AREA')
            ->setCellValue('C1', 'JUMLAH PELANGGAN')
            ->setCellValue('D1', 'JUMLAH DAYA')
            ->setCellValue('E1', 'JUMLAH KWH')
            ->setCellValue('F1', 'PEMAKAIAN KVARH');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBLREK, KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH_CATER) PEMKWH_CATER, SUM(PEMKVARH_CATER) PEMKVARH_CATER
									FROM DPM_LISTRIK_REF
									GROUP BY KD_AREA ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->KD_AREA);
            $ex->setCellValue('C'.$counter, $row->JML_LANG);
            $ex->setCellValue('D'.$counter, $row->JML_DAYA);
            $ex->setCellValue('E'.$counter, $row->PEMKWH_CATER);
            $ex->setCellValue('F'.$counter, $row->PEMKVARH_CATER);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP HITUNG KWH")
            ->setSubject("REKAP HITUNG KWH")
            ->setDescription("REKAP HITUNG KWH by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP ENTRI STAND');
        $TitlE 		= "HASIL REKAP HITUNG KWH";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_rekapdlpdexcel(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL REKENING')
            ->setCellValue('B1', 'KODE AREA')
            ->setCellValue('C1', 'STATUS DLPD')
            ->setCellValue('D1', 'JUMLAH LANGGANAN');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT THBLREK,KD_AREA,STATUS_DLPD,COUNT(ID_LANG) JML_LANG
									FROM DPM_LISTRIK_REF
									GROUP BY KD_AREA,STATUS_DLPD ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->KD_AREA);
            $ex->setCellValue('C'.$counter, $row->STATUS_DLPD);
            $ex->setCellValue('D'.$counter, $row->JML_LANG);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP STATUS DLPD")
            ->setSubject("REKAP STATUS DLPD")
            ->setDescription("REKAP STATUS DLPD by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP ENTRI STAND');
        $TitlE 		= "HASIL REKAP STATUS DLPD";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}


public function rpt_hitungbillingexcel($idcari=''){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode('#0');

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL REKENING')
            ->setCellValue('B1', 'KODE AREA')
            ->setCellValue('C1', 'JML LANGGANAN')
            ->setCellValue('D1', 'DAYA')
            ->setCellValue('E1', 'KWH')
            ->setCellValue('F1', 'KLB KVARH')
            ->setCellValue('G1', 'PTL')
            ->setCellValue('H1', 'BPJU')
            ->setCellValue('I1', 'ANGSURAN')
            ->setCellValue('J1', 'MATERAI')
            ->setCellValue('K1', 'TAGIHAN');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;

		if($idcari == '' OR $idcari == null){
			$sql = "SELECT THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG
						FROM BILLING_LISTRIK_REF a
						JOIN TR_AREA b ON a.KD_AREA=b.kd_area
						GROUP BY a.KD_AREA";
		}else{
			$sql = "SELECT THBLREK, b.nm_area NM_AREA, a.KD_AREA, COUNT(ID_LANG) JML_LANG, SUM(DAYA) JML_DAYA, SUM(PEMKWH) JML_KWH,
							SUM(KLBKVARH) KLBKVARH, SUM(RPPTL) RPPTL, SUM(RPBPJU) RPBPJU, SUM(RPANGSURAN) RPANGSURAN, SUM(RPMAT) MATERAI, SUM(RPTAG) RPTAG
						FROM MASTER_REKENING a
						JOIN TR_AREA b ON a.KD_AREA=b.kd_area
						WHERE THBLREK = '$idcari'
						GROUP BY a.KD_AREA";
		}

		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->NM_AREA);
            $ex->setCellValue('C'.$counter, $row->JML_LANG);
            $ex->setCellValue('D'.$counter, $row->JML_DAYA);
            $ex->setCellValue('E'.$counter, $row->JML_KWH);
            $ex->setCellValue('F'.$counter, $row->KLBKVARH);
            $ex->setCellValue('G'.$counter, $row->RPPTL);
            $ex->setCellValue('H'.$counter, $row->RPBPJU);
            $ex->setCellValue('I'.$counter, $row->RPANGSURAN);
            $ex->setCellValue('J'.$counter, $row->MATERAI);
            $ex->setCellValue('K'.$counter, $row->RPTAG);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP HITUNG BILLING")
            ->setSubject("REKAP HITUNG BILLING")
            ->setDescription("REKAP HITUNG BILLING by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP ENTRI STAND');
        $TitlE 		= "HASIL REKAP HITUNG BILLING";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detpelunasanbpujlexcel(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO AGENDA')
            ->setCellValue('B1', 'JENIS TRANSAKSI')
            ->setCellValue('C1', 'NAMA LANGGANAN')
            ->setCellValue('D1', 'RP BP')
            ->setCellValue('E1', 'RP UJL')
            ->setCellValue('F1', 'RP MATERAI')
            ->setCellValue('G1', 'TOTAL BIAYA')
            ->setCellValue('H1', 'TANGGAL BAYAR')
            ->setCellValue('I1', 'POLA BAYAR');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_pelunasan_nontaglis_detail ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->NO_AGENDA);
            $ex->setCellValue('B'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->RP_BP);
            $ex->setCellValue('E'.$counter, $row->RP_UJL_TAGIH);
            $ex->setCellValue('F'.$counter, $row->MATERAI);
            $ex->setCellValue('G'.$counter, $row->TOTAL_BIAYA);
            $ex->setCellValue('H'.$counter, $row->TGL_BAYAR);
            $ex->setCellValue('I'.$counter, $row->Pola_bayar);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("DETAIL BP UJL")
            ->setSubject("DETAIL BP UJL")
            ->setDescription("DETAIL BP UJL by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('DETAIL BP UJL');
        $TitlE 		= "DETAIL BP UJL";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_detpelunasanpsexcel(){
	$objPHPExcel    = new PHPExcel();
		$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('###000');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);


        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO AGENDA')
            ->setCellValue('B1', 'JENIS TRANSAKSI')
            ->setCellValue('C1', 'NAMA LANGGANAN')
            ->setCellValue('D1', 'BIAYA KWH')
            ->setCellValue('E1', 'BIAYA MATERIAL')
            ->setCellValue('F1', 'BIAYA BPJU')
            ->setCellValue('G1', 'MATERAI')
            ->setCellValue('H1', 'TOTAL')
            ->setCellValue('I1', 'POLA BAYAR')
            ->setCellValue('J1', 'TGL LUNAS');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT * FROM v_pelunasan_nontaglis_detail_ps ";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->NO_AGENDA);
            $ex->setCellValue('B'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->RP_KWH);
            $ex->setCellValue('E'.$counter, $row->RP_BP);
            $ex->setCellValue('F'.$counter, $row->RP_BPJU);
            $ex->setCellValue('G'.$counter, $row->MATERAI);
            $ex->setCellValue('H'.$counter, $row->TOTAL_BIAYA);
            $ex->setCellValue('I'.$counter, $row->Pola_bayar);
            $ex->setCellValue('J'.$counter, $row->TGL_BAYAR);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("DETAIL PS")
            ->setSubject("DETAIL PS")
            ->setDescription("DETAIL PS by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('DETAIL PS');
        $TitlE 		= "DETAIL PS";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_sudahpdlexcel(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('##00');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBL MOHON')
            ->setCellValue('B1', 'THBL MUTASI')
            ->setCellValue('C1', 'NO AGENDA')
            ->setCellValue('D1', 'ID CUSTOMER')
            ->setCellValue('E1', 'NAMA MOHON')
            ->setCellValue('F1', 'ID LANGGANAN')
            ->setCellValue('G1', 'NAMA LANGGANAN')
            ->setCellValue('H1', 'TRANSAKSI')
            ->setCellValue('I1', 'STATUS')
            ->setCellValue('J1', 'CETAK')
            ->setCellValue('K1', 'NO PDL');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "select THBL_MOHON,THBLMUT,NO_AGENDA,ID_CUST,NAMA_MOHON,ID_LANG,NAMA_LANG,JNS_TRANSAKSI,b.STATUS_MOHON , DATE(TGL_PDL) TGL_PDL, NO_PDL
		from TP_AGENDA a
		join TR_STATUSMOHON b on a.STATUS_MOHON=b.ID
		where  TGL_PDL != '0000-00-00 00:00:00' AND a.STATUS_MOHON!='0' AND a.STATUS_MOHON='8'";

		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBL_MOHON);
            $ex->setCellValue('B'.$counter, $row->THBLMUT);
            $ex->setCellValue('C'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('D'.$counter, $row->ID_CUST);
            $ex->setCellValue('E'.$counter, $row->NAMA_MOHON);
            $ex->setCellValue('F'.$counter, $row->ID_LANG);
            $ex->setCellValue('G'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('H'.$counter, $row->JNS_TRANSAKSI);
            $ex->setCellValue('I'.$counter, $row->STATUS_MOHON);
            $ex->setCellValue('J'.$counter, $row->TGL_PDL);
            $ex->setCellValue('K'.$counter, $row->NO_PDL);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP SUDAH PDL")
            ->setSubject("REKAP SUDAH PDL")
            ->setDescription("REKAP SUDAH PDL by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP SUDAH PDL');
        $TitlE 		= "HASIL REKAP SUDAH PDL";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_monitoringps(){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'NO AGENDA')
            ->setCellValue('B1', 'NAMA LANGGANAN')
            ->setCellValue('C1', 'TANGGAL MOHON')
            ->setCellValue('D1', 'TANGGAL AWAL')
            ->setCellValue('E1', 'TANGGAL AKHIR')
            ->setCellValue('F1', 'TANGGAL BAYAR')
            ->setCellValue('G1', 'TANGGAL NYALA')
            ->setCellValue('H1', 'TANGGAL BONGKAR')
            ->setCellValue('I1', 'STATUS MOHON');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "select * from v_mon_ps where status_mohon <> 'BATAL'";

		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, "'".$row->NO_AGENDA);
            $ex->setCellValue('B'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('C'.$counter, "'".$row->Tgl_Mohon);
            $ex->setCellValue('D'.$counter, $row->Tgl_Awal);
            $ex->setCellValue('E'.$counter, $row->Tgl_Akhir);
            $ex->setCellValue('F'.$counter, $row->Tgl_Bayar);
            $ex->setCellValue('G'.$counter, $row->Tgl_Nyala);
            $ex->setCellValue('H'.$counter, $row->Tgl_Bongkar);
            $ex->setCellValue('I'.$counter, $row->status_mohon);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("REKAP PS")
            ->setSubject("REKAP PS")
            ->setDescription("REKAP PS by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('REKAP PS');
        $TitlE 		= "HASIL REKAP PS";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function rpt_piutangpertanggal($idcari){
	$objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode('#0');
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(35);
		$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode('#0');
		$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(15);
		$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(25);
		$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(25);

        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'THBLREK')
            ->setCellValue('B1', 'ID LANGGANAN')
            ->setCellValue('C1', 'NAMA LANGGANAN')
            ->setCellValue('D1', 'ALAMAT LANGGANAN')
            ->setCellValue('E1', 'RP TAG')
            ->setCellValue('F1', 'RP BK')
            ->setCellValue('G1', 'TOTAL INVOICE')
            ->setCellValue('H1', 'STATUS LUNAS')
            ->setCellValue('I1', 'KOGOL')
            ->setCellValue('J1', 'ID CUSTOMER')
            ->setCellValue('K1', 'KODE AREA');

        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $counter = 2;
		$sql = "SELECT a.THBLREK, a.ID_LANG, b.NAMA_LANG, b.ALAMAT_LANG, a.RPTAG, a.RP_BK, a.TOTAL_INVOICE, if(a.tgl_lunas > '$idcari', a.status_lunas='BELUM', if(a.status_lunas='1','LUNAS','BELUM') ) STATUS_LUNASFILTER, c.URAIAN, a.ID_CUST, d.NM_AREA
				FROM `master_rekening` a
				join dil_listrik_new b on a.id_lang=b.id_lang
				join tr_golongan c on a.kogol=c.kd_gol
				join tr_area d on a.kd_area=d.kd_area
				WHERE if(day('$idcari') < '5', a.thblrek < DATE_FORMAT('$idcari','%Y%m'), a.thblrek <= DATE_FORMAT
				('$idcari','%Y%m'))
				ORDER BY a.`THBLREK` DESC";
		$hasil = $this->db->query($sql)->result();
        foreach ($hasil as $row):
            $ex->setCellValue('A'.$counter, $row->THBLREK);
            $ex->setCellValue('B'.$counter, $row->ID_LANG);
            $ex->setCellValue('C'.$counter, $row->NAMA_LANG);
            $ex->setCellValue('D'.$counter, $row->ALAMAT_LANG);
            $ex->setCellValue('E'.$counter, $row->RPTAG);
            $ex->setCellValue('F'.$counter, $row->RP_BK);
            $ex->setCellValue('G'.$counter, $row->TOTAL_INVOICE);
            $ex->setCellValue('H'.$counter, $row->STATUS_LUNASFILTER);
            $ex->setCellValue('I'.$counter, $row->URAIAN);
            $ex->setCellValue('J'.$counter, $row->ID_CUST);
            $ex->setCellValue('K'.$counter, $row->NM_AREA);

            $counter = $counter+1;
        endforeach;

        $objPHPExcel->getProperties()->setCreator("AP2EPI")
            ->setLastModifiedBy("AP2EPI")
            ->setTitle("PIUTANG PER TANGGAL")
            ->setSubject("PIUTANG PER TANGGAL")
            ->setDescription("PIUTANG PER TANGGAL by AP2EPI.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("MONITORING");
        $objPHPExcel->getActiveSheet()->setTitle('PIUTANG TANGGAL');
        $TitlE 		= "PIUTANG PERTANGGAL $idcari";
		$namafile	= str_replace(' ','_',$TitlE);
        $objWriter  = IOFactory::createWriter($objPHPExcel, 'Excel2007');
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$namafile.'.xlsx"');

        $objWriter->save('php://output');
}

public function terbilang_get_valid($str,$from,$to,$min=1,$max=9){
	$val=false;
	$from=($from<0)?0:$from;
	for ($i=$from;$i<$to;$i++){
		if (((int) $str{$i}>=$min)&&((int) $str{$i}<=$max)) $val=true;
	}
	return $val;
}

public function terbilang_get_str($i,$str,$len){
	$numA=array("","satu","dua","tiga","empat","lima","enam","tujuh","delapan","sembilan");
	$numB=array("","se","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
	$numC=array("","satu ","dua ","tiga ","empat ","lima ","enam ","tujuh ","delapan ","sembilan ");
	$numD=array(0=>"puluh",1=>"belas",2=>"ratus",4=>"ribu", 7=>"juta", 10=>"milyar", 13=>"triliun");
	$buf="";
	$pos=$len-$i;
	switch($pos){
		case 1:
				if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
					$buf=$numA[(int) $str{$i}];
			break;
		case 2:	case 5: case 8: case 11: case 14:
				if ((int) $str{$i}==1){
					if ((int) $str{$i+1}==0)
						$buf=($numB[(int) $str{$i}]).($numD[0]);
					else
						$buf=($numB[(int) $str{$i+1}]).($numD[1]);
				}
				else if ((int) $str{$i}>1){
						$buf=($numB[(int) $str{$i}]).($numD[0]);
				}
			break;
		case 3: case 6: case 9: case 12: case 15:
				if ((int) $str{$i}>0){
						$buf=($numB[(int) $str{$i}]).($numD[2]);
				}
			break;
		case 4: case 7: case 10: case 13:
				if ($this->terbilang_get_valid($str,$i-2,$i)){
					if (!$this->terbilang_get_valid($str,$i-1,$i,1,1))
						$buf=$numC[(int) $str{$i}].($numD[$pos]);
					else
						$buf=$numD[$pos];
				}
				else if((int) $str{$i}>0){
					if ($pos==4)
						$buf=($numB[(int) $str{$i}]).($numD[$pos]);
					else
						$buf=($numC[(int) $str{$i}]).($numD[$pos]);
				}
			break;
	}
	return $buf;
}

public function terbilang($nominal){
	$buf="";
	$str=$nominal."";
	$len=strlen($str);
	for ($i=0;$i<$len;$i++){
		$buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
	}
	return trim($buf." rupiah");
}

public function terbilang_angka($nominal){
	$buf="";
	$str=$nominal."";
	$len=strlen($str);
	for ($i=0;$i<$len;$i++){
		$buf=trim($buf)." ".$this->terbilang_get_str($i,$str,$len);
	}
	return trim($buf);
}


}
