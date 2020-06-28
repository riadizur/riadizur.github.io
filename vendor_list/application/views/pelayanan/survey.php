<script>
$(document).ready(function() {
	$("#ps").hide();
	$("#nonps").show();
	$("#stand").hide();
	$("#datateknis").show();

	$("#stand_akhir_lwbp").val('0');
	$("#stand_akhir_wbp").val('0');
	$("#stand_akhir_kvarh").val('0');
	document.getElementById("lunas").innerHTML = " ";

	$("#no_panel").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_datapanel/'+v;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					$("#kd_trafo_dist").val(obj.kd_trafo_dist);
					$("#kd_gardu").val(obj.kd_gardu);
					$("#kd_penyulang").val(obj.kd_penyulang);
					$("#kd_trafo_gi").val(obj.kd_trafo_gi);
					$("#kd_gi").val(obj.kd_gi);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});
	});
	$('#BtnSave').attr('disabled',false);
});

function cari(){
		$('#BtnSave').text('Simpan');
		$('#BtnSave').attr('disabled',false);
		document.getElementById("lunas").innerHTML = " ";
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagendasurvey/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					lunas = obj.TGL_BAYAR;

					if(lunas == null || lunas == '0000-00-00 00:00:00'){

						$("#no_agenda").val(obj.NO_AGENDA);
						$("#jns_transaksi").val(obj.JNS_TRANSAKSI);
						if(obj.JNS_TRANSAKSI == "PENERANGAN SEMENTARA"){ $("#ps").show(); $("#nonps").hide(); }else{ $("#ps").hide(); $("#nonps").show(); }
						if(obj.JNS_TRANSAKSI == "BERHENTI LANGGANAN"){ $("#stand").show();$("#datateknis").hide(); }else{ $("#stand").hide();$("#datateknis").show(); }

						$("#id_cust").val(obj.ID_CUST);
						$("#id_lang").val(obj.ID_LANG);
						$("#tgl_mohon").val(obj.TGL_MOHON);
						$("#nama_mohon").val(obj.NAMA_LANG);
						$("#alamat_mohon").val(obj.ALAMAT_LANG);
						$("#kec_mohon").val(obj.KECMOHON);
						$("#kota_mohon").val(obj.KOTAMOHON);
						$("#prov_mohon").val(obj.PROVMOHON);
						$("#kdpos_mohon").val(obj.KDPOS_MOHON);

						$("#nama_lang").val(obj.NAMA_LANG);
						$("#alamat_lang").val(obj.ALAMAT_LANG);
						$("#kdpos_lang").val(obj.KDPOS_LANG);
						$("#pola_bayar").val(obj.POLA_PEMBAYARAN);
						$("#kd_area").val(obj.KD_AREA);

						$("#rp_bp").val(number_format(obj.RP_BP));
						$("#rp_bpx").val(obj.RP_BP);
						$("#titik_sm").val(obj.TITIK_SM);
						$("#sm_ke").val(obj.SM_KE);
						$("#pjg_sm").val(obj.PJG_SM);
						$("#no_panel").val(obj.NO_PANEL).trigger('change');;
						$("#kd_trafo_dist").val(obj.KD_TRAFO_DIST);
						$("#kd_gardu").val(obj.KD_GARDU);
						$("#kd_penyulang").val(obj.KD_PENYULANG);
						$("#kd_trafo_gi").val(obj.KD_TRAFO_GI);
						$("#kd_gi").val(obj.KD_GI);

						$("#merk_meter").val(obj.MERK_METER);
						$("#no_meter").val(obj.NO_METER);
						$("#merk_pembatas").val(obj.MERK_PEMBATAS);
						$("#ukuran_pembatas").val(obj.UKURAN_PEMBATAS);
						$("#setting_pembatas").val(obj.SETTING_PEMBATAS);

						$("#stand_bkr_lwbp").val(obj.STAND_BKR_LWBP);
						$("#stand_bkr_wbp").val(obj.STAND_BKR_WBP);
						$("#stand_bkr_kvarh").val(obj.STAND_BKR_KVARH);
						$("#fk_meter").val(obj.FK_METER);
						$("#frt").val(obj.frt);

						$("#tarif_lama").val(obj.TARIF_LAMA);
						$("#daya_lama").val(obj.DAYA_LAMA);
						$("#tarif_baru").val(obj.TARIF_BARU);
						$("#daya_baru").val(obj.DAYA_BARU);
						$("#ppj").val(obj.KD_PPJ);
						$("#rpkwh_ps").val(obj.RPKWH_PS);

						$("#ujl_tagih").val(number_format(obj.RP_UJL_TAGIH,0,'.',','));
						$("#ujl_tagihx").val(obj.RP_UJL_TAGIH);

						var rplwbp 	 = obj.RP_LWBP;
						var daya   	 = obj.DAYA_BARU;
						var jamnyala = obj.KD_JAMNYALA_EMIN;
						var nilaibk	 = obj.NILAI_BK;

						FRT = obj.FRT;
						FKM = obj.FK_METER;
						JT  = obj.JNS_TRANSAKSI;

						caril();

					}else{
						$('#BtnSave').text('Sudah Lunas');
						$('#BtnSave').attr('disabled',true);
						document.getElementById("lunas").innerHTML = "Langganan ini sudah melakukan pelunasan, Data tidak dapat di rubah lagi !!";
					}
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function caril(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagendal/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#kec_lang").val(obj.KECLANG);
					$("#kota_lang").val(obj.KOTALANG);
					$("#prov_lang").val(obj.PROVLANG);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});

		carim()
}

function carim(){
		var carix   = document.getElementById("id_lang").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/carim/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					SALWBP  = obj.STAND_AKHIR_LWBP;
					SAWBP 	= obj.STAND_AKHIR_WBP;
					SAKVARH = obj.STAND_AKHIR_KVARH;
					$("#stand_akhir_lwbp").val(SALWBP);
					$("#stand_akhir_wbp").val(SAWBP);
					$("#stand_akhir_kvarh").val(SAKVARH);
				});
			}
		});
}

function set_rupiah(){
	var bp = document.getElementById('rp_bp').value;
	$("#rp_bpx").val(angka(bp));
}

function hitung(){
	var bp = document.getElementById('rp_bp').value;
	if(bp == ''){alert("Biaya Tidak boleh kosong, Jika tidak ada biaya, isikan 0 "); return false}

	if(JT == 'BERHENTI LANGGANAN'){

		var bkrl = document.getElementById('stand_bkr_lwbp').value;
		var bkrw =	document.getElementById('stand_bkr_wbp').value;
		var bkrk =	document.getElementById('stand_bkr_kvarh').value;
		var tarif=	document.getElementById('tarif_baru').value;

		var SISA_RPLWBP  = Math.round((parseInt(bkrl) - parseInt(SALWBP) ) * parseInt(FKM) * parseInt(FRT),2);
		var SISA_RPWBP   = Math.round((parseInt(bkrw) - parseInt(SAWBP) ) * parseInt(FKM) * parseInt(FRT),2);
		var SISA_RPKVARH = Math.round((parseInt(bkrk) - parseInt(SAKVARH) ) * parseInt(FKM) * parseInt(FRT),2);

		$("#sisa_rplwbp").val(SISA_RPLWBP);
		$("#sisa_rpwbp").val(SISA_RPWBP);
		$("#sisa_rpkvarh").val(SISA_RPKVARH);

		save();
	}
	else if(JT == 'PENERANGAN SEMENTARA')
	{

		var materialhide = $("#rp_bpx").val();
		if(materialhide == '0'){alert("Anda baru saja menentukan biaya Material nya 0 rupiah. ");}

		save();
	}
	else
	{
		save();
	}
}
</script>
			<div> <p id="lunas" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Survey <small>Pelayanan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Pencarian
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<label class="col-md-3 control-label align-left">Masukan No. Agenda</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
	<form action="#" id="form" class="form-horizontal" role="form">
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-body form-horizontal">
							<div class="form-group">
								<label class="col-md-6 control-label align-left">No Agenda</label>
								<div class="col-md-6">
									<input type="text" id="no_agenda" name="no_agenda" class="form-control" readonly="true"/>
									<input type="hidden" id="id_cust" name="id_cust" class="form-control" readonly="true"/>
									<input type="hidden" id="id_lang" name="id_lang" class="form-control" readonly="true"/>
								</div>
							</div>
							<br/><br/>
							<div class="note note-success">
								<h1 class="block center"><center>LISTRIK</center></h1>
							</div>
							<br/><br/><br/><br/>
						</div>
					</div>
				</div>

				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Data Permohonan
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="">
									<label class="col-md-6 control-label align-left">Jenis</label>
									<div class="col-md-6">
										<input type="text" id="jns_transaksi" name="jns_transaksi" class="form-control input-sm" placeholder=" " readonly>
										<input type="hidden" id="tgl_mohon" name="tgl_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Nama</label>
									<div class="col-md-6">
										<input type="text" id="nama_mohon" name="nama_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Alamat</label>
									<div class="col-md-6">
										<input type="text" id="alamat_mohon" name="alamat_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kecamatan</label>
									<div class="col-md-6">
										<input type="text" id="kec_mohon" name="kec_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kota</label>
									<div class="col-md-6">
										<input type="text" id="kota_mohon" name="kota_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Provinsi</label>
									<div class="col-md-6">
										<input type="text" id="prov_mohon" name="prov_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kodepos</label>
									<div class="col-md-6">
										<input type="text" id="kdpos_mohon" name="kdpos_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="form-group" >
									<label class="col-md-6 control-label align-left"></label>
									<div class="col-md-6">
										<input type="hidden" id="paket_sar" name="paket_sar" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Entry Data Administrasi Langganan dan Biaya
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Nama</label>
											<div class="col-md-6">
												<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Alamat</label>
											<div class="col-md-6">
												<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kecamatan</label>
											<div class="col-md-6">
												<input type="text" id="kec_lang" name="kec_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kota</label>
											<div class="col-md-6">
												<input type="text" id="kota_lang" name="kota_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Provinsi</label>
											<div class="col-md-6">
												<input type="text" id="prov_lang" name="prov_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode POS</label>
											<div class="col-md-6">
												<input type="text" id="kdpos_lang" name="kdpos_lang" class="form-control input-sm" placeholder=" " readonly>
												<input type="hidden" id="kd_area" name="kd_area" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label id="nonps" class="col-md-6 control-label align-left">Biaya Penyambungan</label>
											<label id="ps" class="col-md-6 control-label align-left">Biaya Material</label>
											<div class="col-md-6">
												<input type="text" id="rp_bp" name="rp_bp" onkeyup="ard_rp(this);set_rupiah(this.value)" class="form-control input-sm" placeholder=" ">
												<input type="hidden" id="rp_bpx" name="rp_bpx" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Uang Jaminan Langganan</label>
											<div class="col-md-6">
												<input type="text" id="ujl_tagih" name="ujl_tagih" class="form-control input-sm" placeholder=" " readonly>
												<input type="hidden" id="ujl_tagihx" name="ujl_tagihx" class="form-control input-sm" placeholder=" " readonly>
												<input type="hidden" id="pola_bayar" name="pola_bayar" class="form-control input-sm" placeholder=" " readonly>
												<input type="hidden" id="ppj" name="ppj" class="form-control input-sm" placeholder=" " readonly>
												<input type="hidden" id="rpkwh_ps" name="rpkwh_ps" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12" id="datateknis">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Entry Data Teknis
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Saluran Masuk ke</label>
											<div class="col-md-6">
												<input type="text" id="sm_ke" name="sm_ke" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Titik Sambung</label>
											<div class="col-md-6">
												<input type="text" id="titik_sm" name="titik_sm" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Panjang Saluran Masuk</label>
											<div class="col-md-6">
												<input type="text" id="pjg_sm" name="pjg_sm" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Jenis Saluran Masuk</label>
											<div class="col-md-6">
												<select id="jns_sm" name="jns_sm" class="form-control select2me" data-placeholder="Select...">
													<option value="">--Pilih--</option>
													<option value="SKTR" selected>SKTR</option>
													<option value="SUTR">SUTR</option>
													<option value="SKTM">SKTM</option>
													<option value="SUTM">SUTM</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Merk Meter</label>
											<div class="col-md-6">
												<input type="text" id="merk_meter" name="merk_meter" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">No Meter</label>
											<div class="col-md-6">
												<input type="text" id="no_meter" name="no_meter" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Merk Pembatas</label>
											<div class="col-md-6">
												<input type="text" id="merk_pembatas" name="merk_pembatas" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Ukuran Pembatas</label>
											<div class="col-md-6">
												<input type="text" id="ukuran_pembatas" name="ukuran_pembatas" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Setting Pembatas</label>
											<div class="col-md-6">
												<input type="text" id="setting_pembatas" name="setting_pembatas" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">No Panel Distribusi</label>
											<div class="col-md-6">
												<?php
													$atribut_no_panel = 'id="no_panel" class="form-control select2me"';
													echo form_dropdown('no_panel', $no_panel, '', $atribut_no_panel);
												?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode Trafo Dist</label>
											<div class="col-md-6">
												<input type="text" id="kd_trafo_dist" name="kd_trafo_dist" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode Gardu</label>
											<div class="col-md-6">
												<input type="text" id="kd_gardu" name="kd_gardu" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode Penyulang</label>
											<div class="col-md-6">
												<input type="text" id="kd_penyulang" name="kd_penyulang" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode Trafo GI</label>
											<div class="col-md-6">
												<input type="text" id="kd_trafo_gi" name="kd_trafo_gi" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode GI</label>
											<div class="col-md-6">
												<input type="text" id="kd_gi" name="kd_gi" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">&nbsp;</label>
											<div class="col-md-6">
												<input type="hidden" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12" id="stand">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Entry Stand
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left"><u><b>Stand Akhir Rekening :</b></u></label>
											<div class="col-md-6">
												<input type="hidden" id="" name="" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">LWBP</label>
											<div class="col-md-6">
												<input type="text" id="stand_akhir_lwbp" name="stand_akhir_lwbp" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">WBP</label>
											<div class="col-md-6">
												<input type="text" id="stand_akhir_wbp" name="stand_akhir_wbp" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">KVARH</label>
											<div class="col-md-6">
												<input type="text" id="stand_akhir_kvarh" name="stand_akhir_kvarh" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left"><u><b>Stand Bongkar :</b></u></label>
											<div class="col-md-6">
												<input type="hidden" id="" name="" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">LWBP</label>
											<div class="col-md-6">
												<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">WBP</label>
											<div class="col-md-6">
												<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">KVARH</label>
											<div class="col-md-6">
												<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>

								</div>
							</div>
						</div>
					</div>
				</div>
				<input type="hidden" id="sisa_rplwbp" name="sisa_rplwbp" class="form-control input-sm" placeholder=" ">
				<input type="hidden" id="sisa_rpwbp" name="sisa_rpwbp" class="form-control input-sm" placeholder=" ">
				<input type="hidden" id="sisa_kvarh" name="sisa_kvarh" class="form-control input-sm" placeholder=" ">
				<input type="hidden" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" ">
				<div class="col-md-12">
					<div class="portlet light">
						<div class="form-group">
							<div class="btn-group">
								<a class="btn green" onclick="hitung()" id="BtnSave" name="BtnSave"  >Simpan </a>
							</div>
						</div>
					</div>
				</div>


			</div>
	</form>


			<!-- END PAGE CONTENT-->
		</div>
	</div>
</div>
<div class="page-footer">
	<div class="page-footer-inner">
		 2018 &copy; EPI Eco System.
	</div>
	<div class="scroll-to-top">
		<i class="icon-arrow-up"></i>
	</div>
</div>
<script src="../../assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="../../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="../../assets/global/plugins/jquery.mockjax.js"></script>
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="../../assets/admin/pages/scripts/components-pickers.js"></script>
<script src="../../assets/admin/pages/scripts/components-dropdowns.js"></script>

<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script>

<script>

jQuery(document).ready(function() {
Metronic.init();
Layout.init();
Demo.init();
ComponentsPickers.init();
ComponentsDropdowns.init();
});

var save_method;
var table;

$(document).ready(function() {
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

});

function save()
{
	var save_method = 'update';
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/survey_add')?>";
    } else {
        url = "<?php echo site_url('pelayanan/survey_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			alert('Berhasil disimpan');
			$("input[type=text], textarea").val("");
			$('select').val('').trigger('change');
			$("#stand_akhir_lwbp").val('0');
			$("#stand_akhir_wbp").val('0');
			$("#stand_akhir_kvarh").val('0');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Terjadi kesalahan saat simpan / merubah data');
        }
    });
}

</script>
</body>
</html>
