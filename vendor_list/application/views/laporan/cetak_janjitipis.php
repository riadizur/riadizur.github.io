<style type="text/css">
	.font_standar{
		font-size: 12px;
	}
</style>
<pagefooter name="footer" content-left="{PAGENO} / {nb}" content-right="Pihak pertama:_____________ Pihak Kedua:____________" 
footer-style="font-family: serif; font-size: 8pt; 
  font-weight: bold; font-style: italic; color: #000000;" >

</pagefooter>
<setpagefooter value="off"></setpagefooter>
<table width=100% style='margin-top: -10px;' >
	<tr>
		<td align="right" style="font-size: 10px">ID LANGGANAN : <b><?php echo @$data_agenda['ID_LANG'] ?></b></td>
	</tr>
	<tr>
		<td align="center" style="font-size: 14px">
			<b>SURAT PERJANJIAN<br/>
			PENGELOLAAN PELAYANAN INSTALASI LISTRIK <br/> 
			ANTARA PT ENERGI PELABUHAN INDONESIA <br/>
			DENGAN <?php echo strtoupper(@$data_cust['NAMA_CUST']) ?>
			</b>
		</td>
	</tr>	  
</table>
<br>
<table class="font_standar" width=100% >
	<tr>
		<td align="center" width="150px">&nbsp;</td>
		<td align="left" width="150px">NO. PIHAK PERTAMA</td>
		<td align="left" width="10px">:</td>
		<td align="center">&nbsp;</td>
	</tr>	  
	<tr>
		<td align="center">&nbsp;</td>
		<td align="left">NO. PIHAK KEDUA</td>
		<td align="left">:</td>
		<td align="center">&nbsp;</td>
	</tr>
	<tr>
		<td style='border-bottom:1px solid black;' colspan=4></td>
	</tr>	
</table>
<table width=100%>
	<tr>
		<td align="justify" class="font_standar">
			Pada hari ini <i><?php echo @$hari_ini ?> </i> 
			tanggal <i><?php echo @$tanggal_ini ?></i> 
			bulan <i><?php echo @$bulan_ini ?></i> 
			tahun <i><?php echo @$tahun_ini ?></i> 
			bertempat di kota Jakarta Utara, telah diadakan Perjanjian antara :
		</td>
	</tr>	  
</table>
<table width=100% class="justify font_standar">
	<tr>
		<td valign="top">I.</td>
		<td align="justify"><b>PT ENERGI PELABUHAN INDONESIA</b>, yang didirikan berdasarkan - Akta Notaris Nomor 11 tanggal 05 November 2012 sebagaimana telah beberapa kali dirubah dan terakhir dirubah dengan Akta Nomor 02 tanggal 03 Oktober 2017 yang dibuat dihadapan H.BAMBANG HERYANTO, SH, Notaris di Jakarta. Berdomisili di Jl. Yos Sudarso No. 30 Jakarta Utara, dalam hal ini di wakili oleh <b>ILHAM SANTOSO</b> selaku <b>DIREKTUR OPERASI DAN NIAGA</b>, bertindak untuk dan atas nama ”PT ENERGI PELABUHAN INDONESIA” yang selanjutnya dalam Perjanjian ini disebut : <b>PIHAK PERTAMA</b>.</td>
	</tr>
	<tr>
		<td valign="top">II.</td>
		<td align="justify"><b><?php echo @$data_cust['NAMA_CUST'] ?></b>, dalam hal ini diwakili oleh <b><?php echo strtoupper($data_cust['NAMA_PIMPINAN']) ?></b> selaku <b><?php echo strtoupper($data_cust['JAB_PIMPINAN']) ?></b>, bertindak untuk dan atas nama “<?php echo @$data_agenda['NAMA_LANG'] ?>” yang selanjutnya dalam Perjanjian ini disebut : <b>PIHAK KEDUA</b>.</td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">PARA PIHAK sepakat untuk mengadakan Perjanjian Pengelolaan Pelayanan Instalasi Listrik, dengan ketentuan-ketentuan sebagai berikut  :</td>
	</tr>	  
</table>
<table width=100% class="font_standar" border=0>
	<tr>
		<td width="3%"></td>
		<td width="3%"></td>
		<td width="40%"></td>
		<td width="3%"></td>
		<td width="15%"></td>
		<td width="35%"></td>
	</tr>
	<tr>
		<td align="left" valign="top" >1.</td>
		<td colspan=5 align="justify">
			PIHAK PERTAMA bersedia untuk menyalurkan tenaga listrik kepada PIHAK KEDUA dan PIHAK KEDUA menerima tenaga listrik tersebut yang akan digunakan 
			pada nama langganan <b><?php echo @$data_agenda['NAMA_LANG'] ?></b>
			untuk keperluan suplai listrik <b><?php echo @$data_peruntukan['URAIAN'] ?></b>
			pada alamat <b><?php echo ucwords(strtolower(@$data_agenda['ALAMAT_LANG'])) ?></b>, <b><?php echo @$data_kec['nama'] ?></b> 
			dengan daya <b><?php echo number_format(@$data_agenda['DAYA']) ?></b> VA, <?php echo @$data_tarif['KLMPK_PHASA'] ?>, <?php echo @$data_tarif['KLMPK_TEGANGAN'] ?> dengan kualitas tegangan +5 % dan –10% , Frekuensi 50 Hz dengan kualitas frekuensi  +/- 1% Cos phi 0,85, 
			tarif  <?php echo @$data_agenda['TARIF'] ?> pemakaian nyala minimum <?php echo @$data_jam['NILAI_JAMNYALA'] ?> Jam 
			dengan energi minimum pada langganan ini sebesar <b><?php echo number_format((@$data_jam['NILAI_JAMNYALA'] * (@$data_agenda['DAYA'] / 1000)))  ?></b> kWh/Bulan.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >2.</td>
		<td colspan=5 align="justify">
			Titik transaksi terpasang pada sisi Tegangan Rendah dengan Faktor kWh, kVARh dan Faktor Rugi Trafo (FRT) akan dituangkan dalam Berita Acara Pemasangan yang selanjutnya menjadi lampiran dan merupakan bagian tidak terpisahkan dari perjanjian ini.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >3.</td>
		<td colspan=5 align="justify">
			Untuk keperluan penyambungan tenaga listrik dimaksud pada angka 1 (satu) di atas, PIHAK KEDUA dikenakan biaya dengan rincian sebagai berikut :
		</td>
	</tr>
	<tr>
		<td >&nbsp;</td>
		<td align="left" valign="top" >a.</td>
		<td align="justify">
			Biaya Penyambungan (BP)
		</td>
		<td align="center">:</td>
		<td align="left">Rp. <?php echo number_format(@$data_agenda['RP_BP']) ?></td>
		<td >&nbsp;</td>
	</tr>
	<?php echo @$data_pasal3 ?>
	<tr>
		<td align="left" valign="top" >4.</td>
		<td colspan=5 align="justify">
			Pembayaran tagihan sebagaimana dimaksud pada angka 3 (tiga) diatas, dapat dilakukan pada Bank atau loket-loket yang ditunjuk oleh PIHAK PERTAMA, sebagaimana surat jawaban persetujuan yang pelanggan terima.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >5.</td>
		<td colspan=5 align="justify">
			Perhitungan tarif biaya pemakaian tenaga listrik per kWh adalah Tarif Tenaga Listrik (TTL) + ( TTL x 25% ) dan dikenakan pengganti Pajak Penerangan Jalan (PPJ).
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >6.</td>
		<td colspan=5 align="justify">
			Besaran tarif pengelolaan pelayanan instalasi listrik akan disesuaikan dengan perubahan Tarif Tenaga Listrik (TTL) PT PLN (Persero) atau adanya perubahan kebijakan tarif layanan baru dari PT Pelabuhan Indonesia II (Persero) selaku Badan Usaha Pelabuhan (BUP).
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >7.</td>
		<td colspan=5 align="justify">
			Tagihan rekening listrik bulanan dibayar setiap bulan pada tanggal yang ditetapkan oleh PIHAK PERTAMA dan pembayaran dapat dilakukan pada Bank atau loket-loket yang ditunjuk oleh PIHAK PERTAMA, sebagaimana tertuang pada informasi tagihan / invoice rekening listrik.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >8.</td>
		<td colspan=5 align="justify">
			Periode pembayaran tagihan rekening listrik untuk setiap bulannya mulai tanggal 5 (lima) sampai dengan tanggal 20 (Dua Puluh). Apabila PIHAK KEDUA melakukan pembayaran rekening listrik melebihi batas periode pembayaran, maka dikenakan biaya keterlambatan untuk setiap bulan sebesar 6 % ( Enam Per Seratus) dari nilai Rupiah Penggunaan Tenaga Listrik (RpPTL) pada tagihan rekening listrik tersebut angka 7 (Tujuh) Perjanjian ini. PIHAK PERTAMA juga dapat melakukan pemutusan aliran listrik secara manual atau otomatis ke instalasi PIHAK KEDUA. Pemberitahuan pemutusan sementara akan disampaikan melalui : surat / sms / email.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >9.</td>
		<td colspan=5 align="justify">
			Penyambungan kembali aliran listrik yang telah diputus sementara sebagaimana dimaksud dalam angka 8 (Delapan) Perjanjian ini, akan dilakukan oleh PIHAK PERTAMA setelah tagihan rekening listrik yang terhutang sekaligus biaya keterlambatan dibayar lunas oleh PIHAK KEDUA.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >10.</td>
		<td colspan=5 align="justify">
			Jika PIHAK KEDUA tidak melakukan pembayaran tagihan rekening listrik terhitung 60 (Enam Puluh) hari setelah periode keterlambatan pertama, maka PIHAK PERTAMA akan memberikan pemberitahuan terakhir kepada PIHAK KEDUA sekaligus pelaksanaan bongkar rampung seluruh instalasi milik PIHAK PERTAMA yang terpasang dan diberhentikan secara sepihak sebagai pelanggan. 
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >11.</td>
		<td colspan=5 align="justify">
			Penyambungan kembali setelah pelaksanaan bongkar rampung sebagaimana dimaksud pada angka 10 (Sepuluh) Perjanjian ini, akan diperlakukan sebagai sambungan baru (dikenakan BP Baru dan Suplesi UJL sesuai ketentuan yang berlaku) dan diwajibkan membayar rekening-rekening bulanan sekaligus biaya keterlambatan serta tagihan lainnya yang belum dilunasi.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >12.</td>
		<td colspan=5 align="justify">
			Dalam melaksanakan penyaluran tenaga listrik PIHAK KEDUA wajib menyediakan tempat untuk penempatan Alat Pengukur dan Pembatas (APP) milik PIHAK PERTAMA dalam jangka waktu selama diperlukan oleh PIHAK PERTAMA yang terletak di dalam lahan / kawasan PIHAK KEDUA.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >13.</td>
		<td colspan=5 align="justify">
			Selama aktif sebagai pelanggan, PIHAK KEDUA dilarang menjual / menyalurkan tenaga listrik yang dibeli dari PIHAK PERTAMA kepada penguna di tempat / kavling lain dan PIHAK KEDUA dilarang dengan dalih apapun memindahkan APP serta merusak segel APP yang dapat mempengaruhi hasil pengukuran PIHAK PERTAMA.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >14.</td>
		<td colspan=5 align="justify">
			Pengiriman informasi Pemutusan dan Pemadaman aliran listrik serta informasi lainnya dari PIHAK PERTAMA kepada PIHAK KEDUA dapat melalui surat/email/sms yang ditujukan kepada alamat korespodensi yang diberikan oleh PIHAK KEDUA kepada PIHAK PERTAMA, dengan alamat sebagai berikut :
		</td>
	</tr>
	<tr>
		<td >&nbsp;</td>
		<td align="left" valign="top" >a.</td>
		<td align="justify">
			Alamat kantor
		</td>
		<td align="center" >:</td>
		<td colspan="2" align="left" ><?php echo @$data_cust['ALAMAT_CUST'] ?></td>
	</tr>
	<tr>
		<td >&nbsp;</td>
		<td align="left" valign="top" >b.</td>
		<td align="justify">
			Nomor Telepon / Handphone
		</td>
		<td align="center" >:</td>
		<td colspan="2" align="left" >+62<?php echo @$data_cust['TELP'] ?> / +62<?php echo @$data_cust['HP1'] ?></td>
	</tr>
	<tr>
		<td >&nbsp;</td>
		<td align="left" valign="top" >c.</td>
		<td align="justify">
			Email
		</td>
		<td align="center" >:</td>
		<td colspan="2" align="left" ><?php echo @$data_cust['EMAIL1'] ?></td>
	</tr>
	<tr>
		<td align="left" valign="top" >15.</td>
		<td colspan=5 align="justify">
			Apabila PIHAK KEDUA akan mengakhiri perjanjian ini, maka PIHAK KEDUA akan memberikan informasi secara tertulis kepada PIHAK PERTAMA, sekurang-kurangnya 30 (tiga puluh) hari sebelum tanggal berakhirnya perjanjian ini.
		</td>
	</tr>
	<tr>
		<td align="left" valign="top" >16.</td>
		<td colspan=5 align="justify">
			Surat Perjanjian ini dibuat dalam rangkap 2 (dua), masing-masing mempunyai kekuatan hukum yang sama, 1 (satu) rangkap untuk PIHAK PERTAMA dan 1 (satu) rangkap untuk PIHAK KEDUA dan setelah dibubuhi meterai secukupnya kemudian ditandatangani oleh kedua belah pihak di Jakarta Utara.
		</td>
	</tr>
</table>
<table width=100% class="font_standar" border=0>
	<tr>
		<td colspan=2 align="center">
			&nbsp;
		</td>
	</tr>
	<tr>
		<td align="center" width=50% >PIHAK PERTAMA,</td>
		<td align="center" width=50% >PIHAK KEDUA,</td>
	</tr>
	<tr>
		<td align="center">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
		</td>
        <td align="center">
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
			<br/>
		</td>
	</tr>
	<tr>
		<td align="center"><b><u>ILHAM SANTOSO</u></b><br/><b>DIREKTUR OPERASI & NIAGA</b></td>
		<td align="center"><b><u><?php echo strtoupper(@$data_cust['NAMA_PIMPINAN']) ?></u></b><br/><b><?php echo strtoupper(@$data_cust['JAB_PIMPINAN']) ?></b></td>
	</tr>
</table>
