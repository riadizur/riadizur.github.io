<style type="text/css">
	.font_standar{
		font-size: 12px;
	}
</style>
<table width=100%>
	<tr>
		<td align="center" style="font-size: 24px"><b>P E R J A N J I A N</b></td>
	</tr>	  
</table>
<br><br><br>
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
</table>
<br><br><br>
<table class="font_standar" width=100%>
	<tr>
		<td align="center">TENTANG</td>
	</tr>	  
</table>
<br><br>
<table width=100%>
	<tr>
		<td align="center" style="font-size: 20px">PENGELOLAAN PELAYANAN</td>
	</tr>	  
	<tr>
		<td align="center" style="font-size: 20px">INSTALASI LISTRIK</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" style="font-size: 18px">Tarif / Daya : <b><?php echo $data_agenda['TARIF_BARU'] ?> / <?php echo number_format($data_agenda['DAYA_BARU'],0) ?> VA</b></td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar">Antara</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b>PT ENERGI PELABUHAN INDONESIA</b></td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar">Dengan</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b><?php echo strtoupper($data_cust['NAMA_CUST']) ?></b></td>
	</tr>	  
</table>
<br><br><br><br><br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b>LANGGANAN ATAS NAMA :</b></td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b><?php echo strtoupper($data_agenda['NAMA_LANG']) ?></b></td>
	</tr>	
	<tr>
		<td align="center" style="font-size: 11px"><b><?php echo strtoupper($data_agenda['ALAMAT_LANG']) ?></b></td>
	</tr>	  
</table>
<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center" class="font_standar"><b>NO PELANGGAN :</b></td>
	</tr>	  
	<tr>
		<td align="center" class="font_standar"><b><?php echo $data_agenda['ID_LANG'] ?></b></td>
	</tr>	  
</table>
<br><br><br><br><br>
<table width=100% class="font_standar">
	<tr>
		<td align="center">PT  ENERGI PELABUHAN INDONESIA</td>
	</tr>	
	<tr>
		<td align="center">JL. YOS SUDARSO NO. 30</td>
	</tr>	 
	<tr>
		<td align="center">JAKARTA UTARA</td>
	</tr>	  
</table>

<!-- Halaman 2 -->
<pagebreak> 
<table width=100%>
	<tr>
		<td align="center" style="font-size: 24px"><b>P E R J A N J I A N</b></td>
	</tr>
</table>
<br><br><br>
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
</table>
<br><br><br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar">TENTANG</td>
	</tr>	  
</table>
<br><br>
<table width=100%>
	<tr>
		<td align="center" style="font-size: 20px">PENGELOLAAN PELAYANAN</td>
	</tr>	  
	<tr>
		<td align="center" style="font-size: 20px">INSTALASI LISTRIK</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" style="font-size: 18px">Tarif / Daya : <b><?php echo $data_agenda['TARIF_BARU'] ?> / <?php echo $data_agenda['DAYA_BARU'] ?> VA</b></td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar">Antara</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b>PT ENERGI PELABUHAN INDONESIA</b></td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar">Dengan</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="center" class="font_standar"><b><?php echo strtoupper($data_cust['NAMA_CUST']) ?></b></td>
	</tr>	  
</table>
<hr>
<table width=100%>
	<tr>
		<td align="justify" class="font_standar">
			Pada hari ini <?php echo $hari_ini ?> tanggal <?php echo $tanggal_ini ?> bulan <?php echo $bulan_ini ?> 
			tahun <?php echo $tahun_ini ?> telah diadakan Perjanjian antara :
		</td>
	</tr>	  
</table>
<br>
<table width=100% class="justify font_standar">
	<tr>
		<td valign="top">I.</td>
		<td align="justify"><b>PT ENERGI PELABUHAN INDONESIA (PT EPI)</b>, yang didirikan berdasarkan - Akta Notaris Nomor 11 tanggal 05 November 2012 sebagaimana telah beberapa kali dirubah dan terakhir dirubah dengan Akta Nomor 07 tanggal 10 April 2017 yang dibuat dihadapan H.BAMBANG HERYANTO, SH, Notaris di Jakarta. Berdomisili di Jl. Yos Sudarso No. 30 Jakarta Utara, dalam hal ini di wakili oleh <b>IRWAN FAVORIET</b> selaku <b>DIREKTUR UTAMA</b>, bertindak untuk dan atas nama ”PT ENERGI PELABUHAN INDONESIA (PT.EPI)” yang selanjutnya dalam Perjanjian ini disebut : <b>PIHAK PERTAMA</b>.</td>
	</tr>
	<tr>
		<td valign="top">II.</td>
		<td align="justify"><b><?php echo $data_agenda['NAMA_LANG'] ?></b>, dalam hal ini diwakili oleh <b><?php echo strtoupper($data_cust['NAMA_PIMPINAN']) ?></b> selaku <b>DIREKTUR UTAMA</b>, bertindak untuk dan atas nama “<?php echo $data_agenda['NAMA_LANG'] ?>” yang selanjutnya dalam Perjanjian ini disebut : <b>PIHAK KEDUA</b>.</td>
	</tr>	  
</table>
<br>
<table width=100%>
	<tr>
		<td align="left" class="font_standar">Masing – masing pihak berdasarkan :</td>
	</tr>	  
</table>

<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Surat permohonan nomor : UM.284/26/7/1/MTI-2016 tanggal 26 juli 2016 perihal Penambahan Daya Listrik.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Surat PT Energi Pelabuhan Indonesia nomor : 88201/160729/0827 tanggal 02 Agustus 2016 perihal Jawaban Persetujuan Perubahan Tarif dan Daya.</td>
	</tr>	  
</table>
<br>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">PARA PIHAK sepakat untuk mengadakan Perjanjian Pengelolaan Pelayanan Instalasi Listrik pada nama langganan <b><?php echo $data_agenda['NAMA_LANG'] ?></b> dengan daya <b><?php echo $data_agenda['DAYA_BARU'] ?> VA, <?php echo $data_tarif['KLMPK_PHASA'] ?>, <?php echo $data_tarif['KLMPK_TEGANGAN'] ?>, Frekuensi 50 Hz , tarif  <?php echo $data_agenda['TARIF_BARU'] ?></b>, dengan ketentuan-ketentuan sebagaimana diuraikan dalam pasal–pasal berikut  :</td>
	</tr>	  
</table>

<!-- halaman 3 -->
<pagebreak>

<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 1</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>T U J U A N</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">PIHAK PERTAMA bersedia untuk menyalurkan tenaga listrik kepada PIHAK KEDUA dan PIHAK KEDUA menerima tenaga listrik tersebut yang akan digunakan oleh PIHAK KEDUA pada nama langganan <b><?php echo $data_agenda['NAMA_LANG'] ?></b> untuk keperluan suplai listrik <b>BANGUNAN</b> pada alamat <b>JL SULAWESI NO. 1 TANJUNG PRIOK</b>.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 2</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>KETENTUAN UMUM</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Transaksi pelayanan instalasi listrik adalah ikatan pelayanan penyaluran tenaga listrik antara PIHAK PERTAMA dengan PIHAK KEDUA untuk kebutuhan/kepentingan yang berhubungan dengan tenaga listrik dan memberikan nilai tambah bagi para pihak.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Tarif pelayanan instalasi listrik adalah biaya yang diberlakukan pada transaksi ketenagalistrikan yang ditetapkan oleh PT Pelabuhan Indonesia II (Persero) sebagai Badan Usaha Pelabuhan (BUP).</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Besaran Tarif pelayanan instalasi listrik akan disesuaikan apabila terjadi perubahan tarif baru dari PT Perusahaan Listrik Negara (Persero).</td>
	</tr>	  
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 3</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>KETENTUAN TEKNIS</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">PIHAK PERTAMA menyalurkan tenaga listrik ke instalasi listrik milik PIHAK KEDUA dengan daya <b><?php echo $data_agenda['DAYA_BARU'] ?> VA, <?php echo $data_tarif['KLMPK_PHASA'] ?>, <?php echo $data_tarif['KLMPK_TEGANGAN'] ?></b> dengan <b>kualitas tegangan +5 % dan –10% , Frekuensi 50 Hz</b> dengan kualitas frekuensi  <b>+/- 1% Cos phi 0,85 , tarif  <?php echo $data_agenda['TARIF_BARU'] ?></b>.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Titik transaksi terpasang pada sisi Tegangan Rendah dengan Faktor kWh, kVARh dan Faktor Rugi Trafo (FRT) akan dituangkan dalam Berita Acara Pemasangan yang selanjutnya menjadi lampiran dan merupakan bagian tidak terpisahkan dari perjanjian ini.</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">PIHAK PERTAMA akan menyalurkan tenaga listrik tersebut sebagaimana dimaksud dalam ayat (1) Pasal ini dan dilaksanakan secara terus menerus tidak terputus-putus kecuali dalam hal-hal sebagai berikut  :
		<br>a. Jika terjadi sebab kahar (force majeure).
		<br>b. Segala sesuatu yang dapat menghentikan penyaluran tenaga listrik berdasarkan peraturan perundang-undangan yang berlaku.
		</td>
	</tr>
	<tr>
		<td valign="top">4.</td>
		<td align="justify">Pengertian kahar (force majeure) tersebut dalam poin a ayat (3) Pasal ini adalah semua kejadian yang menyebabkan PIHAK PERTAMA tidak mampu mengatasinya yang termasuk di dalamnya seperti kerusuhan, huru-hara, perang, kebakaran, gempa bumi, tanah longsor, letusan gunung berapi, halilintar, banjir air, musim kemarau yang panjang, gangguan-gangguan pada peralatan listrik PIHAK PERTAMA, dan kejadian lain yang dapat mengakibatkan gangguan pada kontinuitas penyaluran tenaga listrik sebagaimana dimaksud pada ayat (1) Pasal ini.</td>
	</tr>	
	<tr>
		<td valign="top">5.</td>
		<td align="justify">Apabila PIHAK PERTAMA mengalami kekurangan penyediaan tenaga listrik dan untuk menjaga kontinuitas sistem penyaluran tenaga listrik, maka PIHAK KEDUA bersedia dipadamkan atau dikurangi daya listriknya sewaktu-waktu pada saat beban puncak.</td>
	</tr>	
	<tr>
		<td valign="top">6.</td>
		<td align="justify">Untuk meningkatkan keandalan dan memudahkan pelayanan disisi instalasi, PIHAK KEDUA diwajibkan memasang peralatan pengaman disisi Tegangan Rendah yang dikoordinasikan dengan peralatan pengaman milik PIHAK PERTAMA, sehingga setiap terjadi gangguan pada instalasi PIHAK KEDUA peralatan pengaman ini akan bekerja lebih dahulu sebelum peralatan pengaman milik PIHAK PERTAMA bekerja.</td>
	</tr>	
	<tr>
		<td valign="top">7.</td>
		<td align="justify">Apabila PIHAK KEDUA tidak memasang peralatan pengaman sebagaimana dimaksud pada ayat (6) Pasal ini, maka setiap terjadi gangguan pada instalasi PIHAK KEDUA yang menyebabkan peralatan pengaman milik PIHAK PERTAMA jatuh (trip), maka untuk pengoperasian kembali akan dilakukan oleh PIHAK PERTAMA setelah menerima permintaan penormalan dari PIHAK KEDUA. Segala sesuatu yang timbul akibat terputusnya aliran listrik ke PIHAK KEDUA, akan menjadi tanggung jawab PIHAK KEDUA.</td>
	</tr>	
	<tr>
		<td valign="top">8.</td>
		<td align="justify">Setiap instalasi listrik PIHAK KEDUA yang sudah dipasang/dipergunakan lebih dari 10 (sepuluh) tahun perlu diteliti kembali kondisi dan syarat ketahanan serta keamanannya sesuai Peraturan Umum Instalasi Listrik (PUIL) yang berlaku.</td>
	</tr>	
	<tr>
		<td valign="top">9.</td>
		<td align="justify">Apabila syarat ketahanan serta keamanan instalasi PIHAK KEDUA tidak terpenuhi akibat kondisi instalasi yang tidak layak, karena penambahan instalasi, maka PIHAK KEDUA bersedia diputus sementara aliran listriknya. Penyambungan kembali dilaksanakan setelah kondisi instalasi PIHAK KEDUA diperbaiki hingga syarat ketahanan dan keamanannya dipenuhi.</td>
	</tr>	
	<tr>
		<td valign="top">10.</td>
		<td align="justify">Apabila terbukti melakukan pelanggaran yang dibuktikan secara teknis, maka aliran listrik yang tersambung ke instalasi milik PIHAK KEDUA diputus sementara sampai dengan PIHAK KEDUA menyelesaikan pembayaran tagihan susulannya.</td>
	</tr>
</table>

<pagebreak>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 4</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>TAGIHAN REKENING LISTRIK</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Tagihan rekening listrik adalah tagihan pelayanan instalasi listrik yang ditagih berdasarkan pemakaian tenaga listrik oleh PIHAK KEDUA yang dihitung secara efektif sejak tenaga listrik disediakan oleh PIHAK PERTAMA menggunakan kWh meter milik PIHAK PERTAMA.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Pembacaan dan pencatatan pemakaian tenaga listrik dilakukan setiap bulan dengan cara pembacaan langsung atau dengan Automatic Meter Reading (AMR) sesuai ketentuan tanggal pembacaan meter yang ditetapkan oleh PIHAK PERTAMA</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Tagihan Susulan adalah tagihan yang terjadi akibat ditemukan :
			<br>a. Kesalahan pencatatan (stand kWh meter, faktor kali meter).
			<br>b. Kelainan penggunaan tenaga listrik oleh PIHAK KEDUA yang tidak terukur oleh alat pengukur PIHAK PERTAMA.
			<br>c. Adanya pelanggaran / ketentuan lain seperti pada Pasal 9 ayat (3) dalam Perjanjian ini. 
		</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 5</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>BIAYA PENYAMBUNGAN (BP) DAN UANG JAMINAN LANGGANAN (UJL)</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Biaya Penyambungan (BP) untuk daya  <b><?php echo number_format($data_agenda['DAYA_BARU']) ?> VA</b> adalah sebesar <b>Rp. <?php echo number_format($data_agenda['TOTAL_BIAYA'],0) ?>,-</b>.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Uang Jaminan Langganan (UJL) untuk daya <b><?php echo number_format($data_agenda['DAYA_BARU']) ?> VA</b> adalah sebesar <b>Rp. <?php echo number_format($data_agenda['RP_UJL_BARU'],0) ?>,-</b> mengingat metode pembayaran telah menggunakan sistem autodebet.</td>
	</tr>
<?php echo $data_pasal5 ?>


</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 6</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>HARGA JUAL TENAGA LISTRIK </b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Apabila pemakaian dibawah atau sama dengan <b><?php echo $data_jam['NILAI_JAMNYALA'] ?>jam</b> nyala dari daya kontrak maka diberlakukan Energi minimum (Emin) : <b>(<?php echo $data_jam['NILAI_JAMNYALA'] ?> Jam x <?php echo number_format($data_agenda['DAYA_BARU']) ?> VA : 1000)</b>.   
Energi minimum pada langganan ini sebesar <b><?php echo number_format(($data_jam['NILAI_JAMNYALA'] * ($data_agenda['DAYA_BARU'] / 1000)))  ?> kWh/Bulan</b>. Selisih kWh Total (penjumlahan kWh LWBP dan kWh WBP) dengan kWh Emin ditambahkan pada kWh LWBP.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Biaya Pemakaian dengan perhitungan sebagai berikut :
			<br>a. Biaya Pemakaian kWh dengan harga jual		= TTL + (TTL x 25%)
			<br>b. Biaya kelebihan kVARh dengan harga jual 	= TTL + (TTL x 25%)
			<br>(Batas kelebihan pemakaian kVARh dihitung berdasarkan: <b>0,62</b> x Pemakaian kWh)
		</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Dikenakan pengganti Pajak Penerangan Jalan (PPJ).</td>
	</tr>	
	<tr>
		<td valign="top">4.</td>
		<td align="justify">Besaran tarif pengelolaan pelayanan instalasi listrik akan disesuaikan apabila terjadi perubahan Tarif Tenaga Listrik (TTL) PT Perusahaan Listrik Negara (Persero) atau adanya perubahan kebijakan tarif layanan baru dari PT Pelabuhan Indonesia II (Persero) selaku Badan Usaha Pelabuhan (BUP). Perubahan tersebut akan diinformasikan sebelumnya oleh PIHAK PERTAMA kepada PIHAK KEDUA.</td>
	</tr>	  
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 7</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>CARA PEMBAYARAN</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Transaksi pelayanan instalasi listrik adalah ikatan pelayanan penyaluran tenaga listrik antara PIHAK PERTAMA dengan PIHAK KEDUA untuk kebutuhan/kepentingan yang berhubungan dengan tenaga listrik dan memberikan nilai tambah bagi para pihak.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Tarif pelayanan instalasi listrik adalah biaya yang diberlakukan pada transaksi ketenagalistrikan yang ditetapkan oleh PT Pelabuhan Indonesia II (Persero) sebagai Badan Usaha Pelabuhan (BUP).</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Besaran Tarif pelayanan instalasi listrik akan disesuaikan apabila terjadi perubahan tarif baru dari PT Perusahaan Listrik Negara (Persero).</td>
	</tr>	  
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 8</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>PERIODE PEMBAYARAN DAN SANKSI KETERLAMBATAN</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">PIHAK PERTAMA akan mengirimkan surat informasi tagihan listrik milik PIHAK KEDUA kepada Bank yang telah ditunjuk oleh PIHAK KEDUA dengan proses pengiriman paling lambat 2 (dua) hari kerja setelah penerbitan rekening pada tanggal 5 disetiap bulannya, untuk diproses pembayaran secara autodebet.</td>
	</tr>
	<?php echo $data_pasal8 ?>  
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 9</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>LARANGAN DAN SANKSI</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">PIHAK KEDUA dengan alasan apapun dilarang menjual / menyalurkan tenaga listrik yang dibeli dari PIHAK PERTAMA kepada penguna di tempat / kavling lain tanpa persetujuan tertulis PIHAK PERTAMA.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Pelanggaran terhadap ketentuan ayat (1) Pasal ini dapat memberikan hak kepada PIHAK PERTAMA untuk memutus sementara penyaluran tenaga listrik kepada PIHAK KEDUA.</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">PIHAK KEDUA dilarang dengan jalan dan dalih apapun  :
			<br>a. Merusak segel (segel timah, plastik, kertas)
			<br>b. Merusak kawat segel
			<br>c. Merusak pembatas arus dan/atau kWh meter
			<br>d. Merusak sambungan masuk
			<br>e. Mempengaruhi kerjanya peralatan pembatas arus dan atau kWh meter
			<br>f. Melakukan tindakan atau perbuatan lainnya yang patut diduga dapat mempengaruhi hasil pengukuran PIHAK PERTAMA.
			<br>g. Memasang sambungan tambahan langsung dari jaringan listrik milik PIHAK PERTAMA tanpa melalui prosedur pasang baru atau penambahan daya yang benar
			<br>h. Menggunakan listrik untuk tujuan lain yang dimaksud dalam Pasal 1 Perjanjian ini
			<br>i. Memakai lebih dari daya yang disediakan atau dengan cara lain yang dapat merugikan PIHAK PERTAMA dan membahayakan keamanan dan kelangsungan penyaluran tenaga listrik baik dilakukan oleh PIHAK KEDUA maupun oleh PIHAK LAIN.
		</td>
	</tr>	
	<tr>
		<td valign="top">4.</td>
		<td align="justify">Untuk mengetahui adanya pelanggaran terhadap larangan tersebut pada ayat (3) Pasal ini, PIHAK KEDUA mengijinkan PIHAK PERTAMA untuk memeriksa Alat Pembatas dan Pengukur (APP) dan Instalasi milik PIHAK PERTAMA maupun PIHAK KEDUA yang ada di persil / bangunan milik PIHAK KEDUA.</td>
	</tr>	
	<tr>
		<td valign="top">5.</td>
		<td align="justify">PIHAK KEDUA mengijinkan PIHAK PERTAMA untuk mengambil/mengangkat APP, jika diperlukan untuk pemeriksaan di laboratorium dan peralatan listrik lainnya.</td>
	</tr>	
	<tr>
		<td valign="top">6.</td>
		<td align="justify">Apabila pelanggaran terhadap ketentuan ayat (3) Pasal ini telah terbukti, maka PIHAK PERTAMA berhak untuk menghentikan perjanjian jual beli tenaga listrik secara sepihak disamping itu PIHAK PERTAMA berhak mendapatkan ganti rugi berupa tagihan susulan dari PIHAK KEDUA yang besarannya ditentukan berdasarkan peraturan yang berlaku.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 10</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>PENYEDIAAN TEMPAT ALAT PEMBATAS DAN PENGUKUR</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Dalam melaksanakan penyaluran tenaga listrik sebagaimana dimaksud pada Pasal 1 Perjanjian ini, PIHAK KEDUA wajib menyediakan tempat untuk penempatan Alat Pengukur dan Pembatas (APP) milik PIHAK PERTAMA dalam jangka waktu selama diperlukan oleh PIHAK PERTAMA yang terletak di dalam lahan/kawasan PIHAK KEDUA.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Hak guna lahan tersebut pada ayat (1) Pasal ini, tetap menjadi hak PIHAK KEDUA. PIHAK KEDUA menjamin dan bertanggungjawab sepenuhnya bahwa PIHAK PERTAMA tetap dapat menggunakan lahan tersebut dalam ayat (1) Pasal ini, walaupun terjadi peralihan hak atas lahan tersebut, kecuali apabila PIHAK KEDUA kehilangan haknya untuk menggunakan lahan tersebut.</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Bilamana penempatan APP memerlukan gedung atau bangunan gardu, pagar beserta perlengkapan pendukungnya disediakan oleh PIHAK KEDUA dengan petunjuk PIHAK PERTAMA dan bangunan tetap menjadi milik PIHAK KEDUA.</td>
	</tr>	
	<tr>
		<td valign="top">4.</td>
		<td align="justify">PIHAK KEDUA tidak diperkenankan memasuki areal bangunan tersebut dalam ayat (3) Pasal ini, dimana di dalamnya terpasang instalasi listrik milik PIHAK PERTAMA.</td>
	</tr>	
	<tr>
		<td valign="top">5.</td>
		<td align="justify">PIHAK KEDUA tidak diperkenankan memindahkan APP beserta peralatan di dalamnya tanpa seijin PIHAK PERTAMA.</td>
	</tr>	
	<tr>
		<td valign="top">6.</td>
		<td align="justify">PIHAK KEDUA mengijinkan PIHAK PERTAMA, atau petugas–petugas PIHAK PERTAMA melalui/memasuki jalan, halaman, daerah-daerah/lahan PIHAK KEDUA setiap saat diperlukan, untuk memasuki lokasi gardu listrik beserta peralatannya milik PIHAK PERTAMA yang terletak di dalam daerah/tanah milik PIHAK KEDUA, guna mengadakan pemeriksaan pemeliharaan gardu, trafo dan APP tersebut.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 11</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>PENGADAAN SAMBUNGAN LAIN</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">PIHAK PERTAMA sebagai perusahaan yang bertugas melayani kelistrikan untuk umum mempunyai hak untuk menyambung tenaga listrik kepada pemakai listrik lainnya dari instalasi listrik PIHAK PERTAMA sebagaimana tersebut dalam Pasal 10 Perjanjian ini, melalui halaman / lahan PIHAK KEDUA dimana pelaksanaannya dengan memperhatikan kemungkinan-kemungkinan teknis serta pemberitahuan secara tertulis PIHAK PERTAMA kepada PIHAK KEDUA dan PIHAK KEDUA setuju dengan ketentuan bahwa sambungan tersebut tidak akan mengurangi keandalan penyaluran tenaga listrik untuk PIHAK KEDUA.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 12</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>CARA PENGUKURAN DAN PEMBATASAN</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">I.</td>
		<td align="justify">PENGUKURAN  :</td>
	</tr>
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Pemakaian tenaga listrik PIHAK KEDUA diukur pada sisi <b>Tegangan Rendah</b> dengan Faktor kWH, kVARh dan Faktor Rugi Trafo (FRT) akan dituangkan dalam Berita Acara Pemasangan yang selanjutnya menjadi lampiran dan merupakan bagian tidak terpisahkan dari perjanjian ini.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Pemakaian tenaga listrik oleh PIHAK KEDUA  diukur dengan menggunakan kWh Meter Electronic (ME) dengan fasilitas yang dapat memonitor secara real time  :
			<br>a. Pemakaian tenaga listrik.
			<br>b. Pemakaian kelebihan kVARh.
			<br>c. Tegangan (Volt).
			<br>d. Arus (Ampere) 
			<br>e. Cos phi.
		</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Pembacaan dan pencatatan angka stand kWh meter sebagaimana dimaksud pada ayat (2) Pasal ini, untuk menghitung pemakaian listrik PIHAK KEDUA yang akan dilaksanakan oleh PIHAK PERTAMA melalui alat pengukuran yang berada di Lokasi PIHAK KEDUA dengan menggunakan fasilitas AMR (Automatic Meter Reading) atau dibaca secara langsung pada tanggal 01 (satu) setiap bulannya.</td>
	</tr>	
	<tr>
		<td valign="top">4.</td>
		<td align="justify">Hasil pembacaan dan pencatatan angka stand meter pemakaian tenaga listrik PIHAK KEDUA selama periode 1 (satu) bulan, selanjutnya oleh PIHAK PERTAMA akan dijadikan dasar perhitungan tagihan rekening listrik.</td>
	</tr>	
	<tr>
		<td valign="top">5.</td>
		<td align="justify">Bilamana terjadi kerusakan Alat Pengukuran, maka perhitungan rekening diperhitungkan <b>rata-rata 3 (tiga) bulan terakhir</b> atau <b>pemakaian rata-rata perhari</b> sebelum terjadi kerusakan yang tertuang dalam Berita Acara (BA) antara petugas PIHAK PERTAMA dan PIHAK KEDUA.</td>
	</tr>	
	<tr>
		<td valign="top">6.</td>
		<td align="justify">Dalam hal  terjadi penggantian peralatan/komponen Alat Pembatas dan Pengukuran (APP) seperti Current Transformer (CT), Voltage Transformer (VT) atau kWh Meter, dituangkan dalam Berita Acara (BA) pergantian yang ditanda-tangani oleh antara petugas PIHAK PERTAMA dan PIHAK KEDUA menjadi bagian tidak terpisah dari Perjanjian ini.</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
</table>
<pagebreak>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">II.</td>
		<td align="justify">PEMBATASAN  DAYA TERSAMBUNG  :</td>
	</tr>
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Pembatasan daya tersambung, dilakukan dengan pemasangan pembatas arus dengan perhitungan sebagai berikut:
			<img src="<?php echo FCPATH."assets/admin/layout4/img/rumus.png" ?>" alt='logo' width='135' height='60' />
			<br><b><i>Keterangan :</i></b>
			<br>In = Arus untuk menentukan peneraan relay dengan satuan Ampere (A).
			<br>Q = Daya kontrak dengan satuan Volt Ampere (VA).
			<br>E = Tegangan dengan satuan Volt (V) , 
			<br>(untuk 3 fasa E = E p-p  x 3 dan untuk 1 fasa E = E p-n) 
		</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Jika pemakaian PIHAK KEDUA melebihi ketentuan daya tersebut di atas hingga pembatas daya PIHAK PERTAMA sering kali jatuh (trip) dalam kurun waktu satu bulan yang disebabkan pemakaian terlalu tinggi, maka PIHAK KEDUA diharuskan atau dapat mengajukan penambahan daya kepada PIHAK PERTAMA.
		</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Jika keadaan tersebut masih tetap berlangsung, maka PIHAK PERTAMA akan memberikan peringatan sebanyak 3 (tiga) kali secara tertulis dan PIHAK PERTAMA berhak melakukan pemutusan untuk  sementara. </td>
	</tr>	
	<tr>
		<td valign="top">4.</td>
		<td align="justify">Untuk pekerjaan-pekerjaan tersebut diatas sesuai ayat (2) pada Pasal ini, menjadi beban dan tanggung jawab PIHAK KEDUA.</td>
	</tr>	
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 13</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>KORESPONDENSI</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Pengiriman informasi dari PIHAK PERTAMA kepada PIHAK KEDUA dapat melalui surat/email/sms yang ditujukan kepada alamat korespodensi yang diberikan oleh PIHAK KEDUA kepada PIHAK PERTAMA, sebagai berikut :
			<table width="100%">
				<tr>
					<td align="left">Alamat</td>
					<td align="left">:</td>
					<td align="left"><?php echo $data_cust['ALAMAT_CUST'] ?></td>
				</tr>
				<tr>
					<td align="left">Nomor Telepon</td>
					<td align="left">:</td>
					<td align="left"><?php echo $data_cust['TELP'] ?></td>
				</tr>
				<tr>
					<td align="left">Nomor Handphone</td>
					<td align="left">:</td>
					<td align="left"><?php echo $data_cust['HP1'] ?></td>
				</tr>
				<tr>
					<td align="left">Email</td>
					<td align="left">:</td>
					<td align="left"><?php echo $data_cust['EMAIL1'] ?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Pengiriman informasi dari PIHAK KEDUA kepada PIHAK PERTAMA dapat melalui surat/email yang ditujukan kepada alamat korespodensi yang diberikan oleh PIHAK PERTAMA kepada PIHAK KEDUA, sebagai berikut :
			<table width="100%">
				<tr>
					<td align="left">Alamat</td>
					<td align="left">:</td>
					<td align="left">Jl. Yos Sudarso No.30, Jakarta Utara</td>
				</tr>
				<tr>
					<td align="left">Nomor Telepon</td>
					<td align="left">:</td>
					<td align="left">021-4305047</td>
				</tr> 
				<tr>
					<td align="left">Email</td>
					<td align="left">:</td>
					<td align="left">cs@ecopowerport.co.id </td>
				</tr>
			</table>
		</td>
	</tr>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">Apabila terdapat perubahan data korespondensi, PARA PIHAK wajib menyampaikan perubahan. Apabila perubahan tersebut tidak disampaikan kepada masing-masing PIHAK maka segala bentuk risiko atas tidak diterimanya informasi menjadi tanggung jawab PIHAK penerima.
		</td>
	</tr>	
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 14</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>HAK PREFERENSI (ISTIMEWA) </b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Apabila terjadi pergantian kepemilikkan perusahaan PIHAK KEDUA, maka seluruh perjanjian dan hutang secara otomatis menjadi tanggungjawab pemilik baru perusahaan PIHAK KEDUA.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Apabila dikemudian hari PIHAK KEDUA dinyatakan pailit berdasarkan Putusan Pengadilan, maka PIHAK PERTAMA mempunyai hak preferens (Hak Istimewa) atas tunggakan tagihan rekening listrik dan atau tagihan lainnya yang belum dilunasi oleh PIHAK KEDUA sesuai ketentuan yang berlaku.</td>
	</tr>
	<tr>
		<td valign="top">3.</td>
		<td align="justify">PIHAK KEDUA menempatkan kedudukan PIHAK PERTAMA sebagai Kreditur Preferens sehingga tunggakan rekening listrik dan atau tagihan lainnya harus didahulukan untuk dibayar oleh PIHAK KEDUA yang pailit.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 15</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>PENGAKHIRAN PERJANJIAN</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">Apabila PIHAK KEDUA akan mengakhiri Perjanjian ini, maka PIHAK KEDUA akan memberikan informasi secara tertulis kepada PIHAK PERTAMA, sekurang-kurangnya 15 (lima belas) hari sebelum tanggal berakhirnya perjanjian ini.</td>
	</tr>
</table>

<pagebreak>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 16</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>PERSELISIHAN PENDAPAT</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td valign="top">1.</td>
		<td align="justify">Perselisihan pendapat antara kedua belah pihak dalam rangka pelaksanaan perjanjian ini akan diselesaikan secara musyawarah.</td>
	</tr>
	<tr>
		<td valign="top">2.</td>
		<td align="justify">Bila penyelesaian perselisihan sesuai ayat (1) Pasal ini tidak tercapai, maka kedua belah pihak sepakat untuk menyerahkan kepada Pengadilan Negeri Jakarta Utara.</td>
	</tr>
</table>

<br>
<table width=100% class="font_standar">
	<tr>
		<td align="center"><b>PASAL 17</b></td>
	</tr>	  
	<tr>
		<td align="center"><b>P E N U T U P</b></td>
	</tr>	  
</table>
<table width=100% class="font_standar">
	<tr>
		<td align="justify">Perjanjian ini dibuat dalam rangkap 2 (dua), masing-masing mempunyai kekuatan hukum yang sama, 1 (satu) rangkap untuk PIHAK PERTAMA dan 1 (satu) rangkap untuk PIHAK KEDUA dan setelah dibubuhi meterai secukupnya kemudian ditandatangani oleh kedua belah pihak di Jakarta Utara.</td>
	</tr>
</table>

<br><br><br><br><br>
<table width="100%" class="font_standar">
	<tr>
		<td width="50%">
			<table width="300px">
				<tr>
					<td style="width: 100%" width="100%" align="center"><b>PIHAK PERTAMA,</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center"><b><u>IRWAN FAVORIET</u></b></td>
				</tr>
				<tr>
					<td align="center"><b>DIREKTUR UTAMA</b></td>
				</tr>
			</table>
		</td>
		<td width="50%">
			<table width="300px">
				<tr>
					<td align="center"><b>PIHAK KEDUA,</b></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="center"><b><u><?php echo strtoupper($data_cust['NAMA_PIMPINAN']) ?></u></b></td>
				</tr>
				<tr>
					<td align="center"><b><?php echo strtoupper($data_cust['JAB_PIMPINAN']) ?></b></td>
				</tr>
			</table>
		</td>
	</tr>
</table>