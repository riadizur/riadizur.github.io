<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>PT ENERGI PELABUHAN INDONESIA</title>
<meta name="viewport" content="width=device-width"/>
</head>
<body>
<table style="height: 100%; width: 500px;  color: #222222;
            font-family: Helvetica, Arial, sans-serif; 
            font-weight: normal; 
            padding:0; 
            margin: 0;
            text-align: left; 
            line-height: 1.3;" align="center">
<tr>
	<td style="text-align: center;" align="center" valign="top">
		<!-- BEGIN: Header -->
		<table style="width: 100%; background: #fff;" align="center">
		<tr>
			<td style="text-align: center;" align="center">
				<!-- BEGIN: Header Container -->
				<table style="background: #fff;padding: 15px !important;" align="center">
				<tr>
					<td>
						<table style="padding: 0px; width: 100%; position: relative;" >
						<tr>
							<td style="padding: 10px 20px 0px 0px; position: relative; padding-top: 0; padding-bottom: 0; vertical-align: middle;" >
								<!-- BEGIN: Logo -->
								<table style="width: 25% !important;">
								<tr>
									<td style="padding-top: 0; padding-bottom: 0; vertical-align: middle;">
										<a href="index.html">
										<img src="http://ecopowerport.co.id/cover/epi_1_100.png" style="width:100px;height:40px;" border="0" alt=""/>
										</a>
									</td>
								</tr>
								</table>
								<!-- END: Logo -->
							</td>
							<td style="padding: 10px 20px 0px 0px; position: relative; padding-top: 0; padding-bottom: 0; vertical-align: middle;" >
										<h4>PT ENERGI PELABUHAN INDONESIA</h4>
							</td>
						</tr>
						</table>
					</td>
				</tr>
				</table>
				<!-- END: Header Container -->
			</td>
		</tr>
		</table>
		<!-- END: Header -->
		<!-- BEGIN: Content -->
		<table style="padding: 0px !important;" align="center">
		<tr>
			<td>
				<table style="padding: 0px; width: 100%; position: relative; padding: 10px !important; background: #ECF8FF; border: 0;">
				<tr>
					<td style="padding: 10px 20px 0px 0px; position: relative;" >
						<table style="width: 100%;" style="margin-bottom: 10px">
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"  style="font-size:20px;"><center>Informasi tagihan rekening listrik Bulan <?php echo $data_bulan."	".$data_tahun ?>  <br>ID Customer <?php echo $data_template['ID_CUST'] ?></center></td>
						</tr>
						</table>
						<p>Yth. <?php echo $data_template['Nama_Customer'] ?></p>
						<p>Di</p>
						<p><?php echo $data_template['ALAMAT_CUST'] ?></p>
						<p>&nbsp;</p>
						<p>Dengan hormat,</p>
						<p>Terima kasih kami sampaikan atas kepercayaan Bapak/Ibu untuk terus menggunakan layanan kami. Bersama ini kami sampaikan informasi tagihan bulanan, dengan rincian sebagai berikut : </p>
						<!-- BEGIN: Note Panel -->
						<table style="width: 100%;" style="margin-bottom: 10px">
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;" width="25px">Rekening Bulan</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;" width="25px">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;" width="25px"><?php echo $data_bulan."	".$data_tahun ?> </td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;" width="25px"></td>
						</tr>
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">Jumlah Langganan</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"><?php echo $data_template['JLH_LANGG'] ?></td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"></td>
						</tr>
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">Nama Customer</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"><?php echo $data_template['Nama_Customer'] ?></td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"></td>
						</tr>
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">Alamat Customer</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"><?php echo $data_template['ALAMAT_CUST'] ?></td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"></td>
						</tr> 
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">Total Keseluruhan Daya</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"> <?php echo $data_template['JLH_DAYA'] ?></td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"></td>
						</tr>
						<tr>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">Total Keseluruhan Tagihan</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;">:</td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"><?php echo $data_template['JLH_TAGIHAN'] ?></td>
							<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"></td>
						</tr>
						</table>
						<p>Sebagai referensi bagi Bapak/Ibu, Kami juga menyertakan detail Informasi Tagihan Listrik dalam bentuk lampiran PDF. Informasi tagihan listrik ini   juga dapat diakses melalui <a href="http://www.ecopowerport.co.id" target="_blank">www.ecopowerport.co.id</a>. <br />
							<a href="http://www.ecopowerport.co.id/" target="_blank"> Cek tagihan rekening listrik </a></p>
						<p>Terima kasih telah menggunakan layanan online kami. Atas perhatian Bapak/Ibu kami ucapkan terima kasih.</p>
						<p>Hormat Kami</p>
						<!-- END: Note Panel -->
					</td>
				</tr>
				</table>
				<span style="border-bottom: 1px solid #eee; margin: 15px -15px; display: block;">
				</span>
				<p><b>Customer Service<br>PT Energi Pelabuhan Indonesia </b></p>
				<p>* Email ini bersifat informasi dan tidak dapat di reply. Apabila   Bapak/Ibu membutuhkan informasi lebih lanjut, silahkan mengirimkan email   ke <a href="mailto:cs@ecopowerport.co.id" target="_blank">cs@ecopowerport.co.id</a></p>
				<table style="padding: 0px; width: 100%; position: relative; padding: 10px !important; background: #ECF8FF; border: 0;" >
				<tr>
					<td style="padding: 10px 20px 0px 0px; position: relative;" >
						<table style="width: 100%;">
							<tr>
								<td rowspan="9" colspan="3" style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;"><img src="http://ecopowerport.co.id/cover/epi_depan_kecil.jpg" style=" width: 100% !important; width:200px;height:150px;"></td>
								<td style="background: #f2f2f2; border: 1px solid #d9d9d9; padding: 10px !important;" ><p>Informasi lebih lanjut:<br>
													PT Energi Pelabuhan Indonesia<br>
													Jl. Pasoso No. 2, Tanjung Priok, Jakarta Utara 14321<br>
													No Telp. 0812-9494-6500 (Pelayanan Teknik)<br>
													Pelayanan Administrasi :<br>
													Jl. Yos Sudarso No. 30, Jakarta Utara 14321<br>
													No. Telp. 021-4305047 / Fax. 021-4305052<br>
													<a href="http://www.ecopowerport.co.id" target="_blank">http://www.ecopowerport.co.id</a><br>
													</p></td>
							</tr>
							
						</table>
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<!-- END: Content -->
		<!-- BEGIN: Footer -->
		<table style="width: 100%; background: #2f2f2f;" align="center">
		<tr>
			<td style="text-align: center;" align="center">
				<table style="width: 580px; margin: 0 auto; text-align: inherit;" align="center">
				<tr>
					<td>
						<!-- BEGIN: Unsubscribet -->
						<table style="padding: 0px; width: 100%; position: relative;">
						<tr>
							<td class="wrapper last">
								<span style="font-size:12px;">
								<i>This ia a system generated email and reply is not required.</i>
								</span>
							</td>
						</tr>
						</table>
						<!-- END: Unsubscribe -->
						<!-- BEGIN: Footer Panel -->
						<table style="padding: 0px; width: 100%; position: relative;">
						<tr>
							<td style="padding: 10px 20px 0px 0px; position: relative;">
								<table style="width: 33.333333%;">
								<tr>
									<td style="padding-top: 0; padding-bottom: 0;vertical-align: middle;" >
										 &copy; PT ENERGI PELABUHAN INDONESIA.
									</td>
								</tr>
								</table>
							</td>
							<td style="padding: 10px 20px 0px 0px; position: relative;">
								<table style="width: 66.666666%;">
								<tr>
									<td style="padding-top: 0; padding-bottom: 0;vertical-align: middle; text-align: right;">
										
									</td>
								</tr>
								</table>
							</td>
						</tr>
						</table>
						<!-- END: Footer Panel List -->
					</td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<!-- END: Footer -->
	</td>
</tr>
</table>
</body>
</html>