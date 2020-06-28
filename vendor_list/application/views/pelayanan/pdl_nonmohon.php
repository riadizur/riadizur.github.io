<script>
$(document).ready(function() {
	sudahcari = "no";
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

	$('#tgl_pdl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

	$("#tgl_pdl").datepicker().datepicker("setDate", new Date());

	$('#tgl_mut').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

	$("#tgl_mut").datepicker().datepicker("setDate", new Date());

	$("#i_primer_ct").val('1');
	$("#i_sekunder_ct").val('1');
	$("#v_primer_pt").val('1');
	$("#v_sekunder_pt").val('1');
	$("#fk_meter").val('1');

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
});


function cari(){
	var cariy   = document.getElementById("cari").value;
	var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_pdl_nonmohon/'+cariy;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj) {
				cek = obj.ID_LANG;
				lunas = obj.TGL_BAYAR;
				if(cek!=''){
					alert("Data Berhasil di Load!");
				}else{
					alert("Data Tidak Ditemukan!");
					$('[name="cari"]').parent().parent().parent().parent().addClass('has-error');
					$('[name="cari"]').attr('value','');
					$('[name="cari"]').attr('placeholder','Data tidak ada');
				}
				if(lunas == '0000-00-00 00:00:00'){
					$('#btnCetak').attr('disabled',true);
					$('#btnSave').attr('disabled',true);
					document.getElementById("lunas").innerHTML = "Permohonan ini belum dilakukan pembayaran !!";
				}

				$("#no_agenda").val(obj.NO_AGENDA);
				$("#no_regis").val(obj.NO_REGIS);

				$("#id_cust").val(obj.ID_CUST);
				$("#id_lang").val(obj.ID_LANG);
				$("#nama_lang").val(obj.NAMA_LANG);
				$("#alamat_lang").val(obj.ALAMAT_LANG);
				$("#kec_lang").val(obj.KECLANG);
				$("#idkec_lang").val(obj.IDKECLANG);
				$("#kd_wilayah").val(obj.KD_WILAYAH).trigger('change');
				$("#kd_area").val(obj.KD_AREA).trigger('change');
				$("#kota_lang").val(obj.KABLANG);
				$("#idkota_lang").val(obj.IDKABLANG);
				$("#prov_lang").val(obj.PROVLANG);
				$("#idprov_lang").val(obj.IDPROVLANG);
				$("#kdpos_lang").val(obj.KDPOS_LANG);

				$("#tarif_lama").val(obj.TARIF);
				$("#daya_lama").val(obj.DAYA);
				$("#tarif_baru").val(obj.TARIF);
				$("#daya_baru").val(obj.DAYA);

				$("#no_bp").val(obj.NO_BP);
				$("#tgl_bp").val(obj.TGL_BP);
				$("#rp_bp").val(obj.RP_BP);
				$("#rp_sewa_trafo").val(obj.RP_SEWA_TRAFO);
				$("#no_ujl").val(obj.NO_UJL);
				$("#tgl_ujl").val(obj.TGL_UJL);
				$("#rp_ujl_lama").val(obj.RP_UJL);
				$("#rp_ujl_baru").val('0');
				$("#rp_ujl_tagih").val('0');

				$("#tgl_nyala").val(obj.TGL_NYALA);
				$("#tgl_psg_meter").val(obj.TGL_PSG_METER);
				$("#merk_meter").val(obj.MERK_METER);
				$("#tipe_meter").val(obj.TIPE_METER);
				$("#no_meter").val(obj.NO_METER);
				$("#fasa_meter").val(obj.FASA_METER);
				$("#thn_prod_meter").val(obj.THN_PROD_METER);
				$("#thn_tera_meter").val(obj.THN_TERA_METER);

				$("#tgl_psg_pembatas").val(obj.TGL_PSG_PEMBATAS);
				$("#merk_pembatas").val(obj.MERK_PEMBATAS);
				$("#tipe_pembatas").val(obj.TIPE_PEMBATAS);
				$("#ukuran_pembatas").val(obj.UKURAN_PEMBATAS);
				$("#fasa_pembatas").val(obj.FASA_PEMBATAS);
				$("#setting_pembatas").val(obj.SETTING_PEMBATAS);
				$("#teg_pembatas").val(obj.TEG_PEMBATAS);

				var ct = parseInt(obj.I_PRIMER_CT) / parseInt(obj.I_SEKUNDER_CT);
				var pt = parseInt(obj.V_PRIMER_PT) / parseInt(obj.V_SEKUNDER_PT);
				var fkctpt = parseInt(ct) * parseInt(pt);

				if(obj.FK_METER != fkctpt){
					$("#tgl_psg_ct").val(obj.TGL_PSG_CT);
					$("#i_primer_ct").val(obj.FK_METER);
					$("#i_sekunder_ct").val('1');
					$("#tgl_psg_pt").val(obj.TGL_PSG_PT);
					$("#v_primer_pt").val('1');
					$("#v_sekunder_pt").val('1');
						$("#fk_meter").val(obj.FK_METER);
				}else{
						$("#tgl_psg_ct").val(obj.TGL_PSG_CT);
					if(obj.I_PRIMER_CT == '' || obj.I_PRIMER_CT == null || obj.I_PRIMER_CT == '0'){$("#i_primer_ct").val('1');}else{$("#i_primer_ct").val(obj.I_PRIMER_CT);};
					if(obj.I_SEKUNDER_CT == '' || obj.I_SEKUNDER_CT == null || obj.I_SEKUNDER_CT == '0'){$("#i_sekunder_ct").val('1');}else{$("#i_sekunder_ct").val(obj.I_SEKUNDER_CT);};
						$("#tgl_psg_pt").val(obj.TGL_PSG_PT);
					if(obj.V_PRIMER_PT == '' || obj.V_PRIMER_PT == null || obj.V_PRIMER_PT == '0'){$("#v_primer_pt").val('1');}else{$("#v_primer_pt").val(obj.V_PRIMER_PT);};
					if(obj.V_SEKUNDER_PT == '' || obj.V_SEKUNDER_PT == null || obj.V_SEKUNDER_PT == '0'){$("#v_sekunder_pt").val('1');}else{$("#v_sekunder_pt").val(obj.V_SEKUNDER_PT);};
						$("#fk_meter").val(obj.FK_METER);
				}

				$("#stand_bkr_lwbp").val(obj.STAND_BKR_LWBP);
				$("#stand_bkr_wbp").val(obj.STAND_BKR_WBP);
				$("#stand_bkr_kvarh").val(obj.STAND_BKR_KVARH);

				$("#stand_psg_lwbp").val(obj.STAND_PSG_LWBP);
				$("#stand_psg_wbp").val(obj.STAND_PSG_WBP);
				$("#stand_psg_kvarh").val(obj.STAND_PSG_KVARH);


				$("#frt").val(obj.FRT);
				$("#koordinatx").val(obj.KOORDINATX);
				$("#koordinaty").val(obj.KOORDINATY);

				$("#kd_trafo_dist").val(obj.KD_TRAFO_DIST);
				$("#kd_gardu").val(obj.KD_GARDU);
				$("#kd_penyulang").val(obj.KD_PENYULANG);
				$("#kd_trafo_gi").val(obj.KD_TRAFO_GI);
				$("#kd_gi").val(obj.KD_GI);
				$("#jns_sm").val(obj.JNS_SM);
				$("#pjg_sm").val(obj.PJG_SM);
				$("#teg_sambung").val(obj.TEG_SAMBUNG);
				$("#idpel_pln").val(obj.IDPEL_PLN);

				$("#peruntukan").val(obj.PERUNTUKAN);
				$("#kogol").val(obj.KOGOL);
				$("#kd_ppj").val(obj.KD_PPJ);
				$("#kd_jamnyala_emin").val(obj.KD_JAMNYALA_EMIN);
				$("#kd_tg").val(obj.KD_TG);
				$("#kd_bk").val(obj.KD_BK);
				$("#status_pecahan").val('ADA');
				$("#sm_ke").val(obj.SM_KE);
				$("#titik_sm").val(obj.TITIK_SM);
				caripdl('NONAGENDA',obj.ID_LANG);
				caricust(obj.ID_CUST);
				cariangs(obj.ID_LANG);
				sudahcari = "yes";
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Selamat Pagi");
		}
	});
}

function caripdl(nonagd,nonidl){
	var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_nopdl_nonmohon/'+nonagd+'/'+nonidl;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			$.map(datas, function (obj) {
				if(obj.NO_PDL != null || obj.NO_PDL != ''){$("#no_pdl").val(obj.NO_PDL);}else{otopdl(obj.KD_AREA);}
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Selamat Pagi");
		}
	});
}

function otopdl(area)
{
	var baseUrl = '<?php echo base_url();?>index.php/pelayanan/otopdl/';
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj)
      {
				var agd= '041'; //khusus Non PDL saja --> 041
				var PDL = 'PDL-'+area+'-'+agd+'-'+obj.NO_PDL;
				$("#no_pdl").val(PDL);
			});
		}
	});
}

function caricust(idcust){
	var baseUrl = '<?php echo base_url();?>index.php/pelayanan/caricust/'+idcust;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj) {
				$("#nama_cust").val(obj.NAMA_CUST);
				$("#alamat_cust").val(obj.ALAMAT_CUST);
				$("#kec_cust").val(obj.KECCUST);
				$("#kota_cust").val(obj.KABCUST);
				$("#prov_cust").val(obj.PROVCUST);
				$("#kdpos_cust").val(obj.KDPOS_CUST);
				$("#nama_ujl").val(obj.nama_ujl);
				$("#paket_sar").val(obj.KD_UJL);
			});
		}
	});
}

function cariangs(idlang){
	var baseUrl = '<?php echo base_url();?>index.php/pelayanan/cari_angs_nonmohon/'+idlang;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj) {
				$("#rp_bp").val(obj.RP_BP);
				$("#rp_ujl").val(obj.RP_UJL);
				$("#rp_bk").val(obj.RP_BK);
				$("#rpkwh_tag").val(obj.RPKWH_TAG);
				$("#p2tl").val(obj.P2TL);
				$("#investasi").val(obj.INVESTASI);
			});
		}
	});
}

function hitung(){
	var iprimerct   = document.getElementById('i_primer_ct').value;
	var isekunderct = document.getElementById('i_sekunder_ct').value;
	var vprimerpt   = document.getElementById('v_primer_pt').value;
	var vsekunderpt = document.getElementById('v_sekunder_pt').value;

	var hasil  = (parseInt(iprimerct) / parseInt(isekunderct)) * (parseInt(vprimerpt) / parseInt(vsekunderpt));
	if (!isNaN(hasil)) {
		document.getElementById('fk_meter').value = hasil;
	}
}

function cetak(x){
	var idl = document.getElementById("id_lang").value;
	var pdl = document.getElementById("no_pdl").value;
	//alert("waiting");return false
	hreF	= "<?php echo site_url("Laporan/rpt_pdl_nonmohon")?>";
	ReQuest	= "/" + x +"/" + idl +"/" + pdl;
	window.open(hreF+ReQuest, '_blank');
}

</script>	<div> <p id="lunas" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Perubahan Data Langganan Non Permohonan<small>Pelayanan</small></h1>
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
									<label class="col-md-3 control-label align-left">Cari ID Langganan</label>
									<div class="col-md-9">
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
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-body">
							<div class="nav-justified">
								<ul class="nav nav-tabs nav-justified">
									<li class="active">
										<a href="#tab_1_1" data-toggle="tab">
										Informasi </a>
									</li>
									<li>
										<a href="#tab_1_2" data-toggle="tab">
										Administratif </a>
									</li>
									<li>
										<a href="#tab_1_3" data-toggle="tab">
										Biaya</a>
									</li>
									<li>
										<a href="#tab_1_4" data-toggle="tab">
										APP</a>
									</li>
									<li>
										<a href="#tab_1_5" data-toggle="tab">
										Suplai</a>
									</li>
									<li>
										<a href="#tab_1_6" data-toggle="tab">
										Lain-lain</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="tab_1_1">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Detil Mutasi</span>
												</div>
											</div>
	<form action="#" id="form" class="form-horizontal" role="form">
	<input type="hidden" id="no_agenda" name="no_agenda" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="kogol" name="kogol" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="kd_ppj" name="kd_ppj" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="kd_jamnyala_emin" name="kd_jamnyala_emin" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="kd_tg" name="kd_tg" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="kd_bk" name="kd_bk" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="status_pecahan" name="status_pecahan" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="sm_ke" name="sm_ke" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="titik_sm" name="titik_sm" class="form-control input-sm" placeholder=" " readonly>
	<input type="hidden" id="peruntukan" name="peruntukan" class="form-control input-sm" placeholder=" " readonly>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-12">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Nomor PDL</label>
															<div class="col-md-6">
																<input type="text" id="no_pdl" name="no_pdl" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tanggal PDL</label>
															<div class="col-md-6">
																<input type="text" id="tgl_pdl" name="tgl_pdl" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tanggal Perubahan</label>
															<div class="col-md-6">
																<input type="text" id="tgl_mut" name="tgl_mut" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tentukan Jenis Transaksi</label>
															<div class="col-md-6">
																<?php
																	$atribut_jns_transaksi = 'id="jns_transaksi" class="form-control select2me"';
																	echo form_dropdown('jns_transaksi', $jns_transaksi, '', $atribut_jns_transaksi);
																?>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_1_2">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Data Customer</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">ID Cust</label>
															<div class="col-md-6">
																<input type="text" id="id_cust" name="id_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Nama</label>
															<div class="col-md-6">
																<input type="text" id="nama_cust" name="nama_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Alamat</label>
															<div class="col-md-6">
																<input type="text" id="alamat_cust" name="alamat_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kecamatan</label>
															<div class="col-md-6">
																<input type="text" id="kec_cust" name="kec_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kota</label>
															<div class="col-md-6">
																<input type="text" id="kota_cust" name="kota_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Provinsi</label>
															<div class="col-md-6">
																<input type="text" id="prov_cust" name="prov_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kodepos</label>
															<div class="col-md-6">
																<input type="text" id="kdpos_cust" name="kdpos_cust" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Paket SAR</label>
															<div class="col-md-6">
																<input type="text" id="nama_ujl" name="nama_ujl" class="form-control input-sm" placeholder=" " readonly>
																<input type="hidden" id="paket_sar" name="paket_sar" class="form-control input-sm" placeholder=" " readonly>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Data Langganan</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Id Langganan</label>
															<div class="col-md-6">
																<input type="text" id="id_lang" name="id_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Nama Langganan</label>
															<div class="col-md-6">
																<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Alamat Langganan</label>
															<div class="col-md-6">
																<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kecamatan</label>
															<div class="col-md-6">
																<input type="text" id="kec_lang" name="kec_lang" class="form-control input-sm" placeholder=" ">
																<input type="hidden" id="idkec_lang" name="idkec_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="control-label col-md-6 align-left" >Wilayah</label>
															<div class="col-md-6">
																<div class="input-group">
																	<span class="input-group-addon">
																	<i class="fa fa-user"></i>
																	</span>
																	<select id="kd_wilayah" name="kd_wilayah" class="form-control select2me" data-placeholder="Select...">
																		<option value="">--Pilih--</option>
																		<option value="88100">PELINDO 1</option>
																		<option value="88200" selected>PELINDO 2</option>
																		<option value="88300">PELINDO 3</option>
																		<option value="88400">PELINDO 4</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">AREA</label>
															<div class="col-md-6">
															<?php
																$atribut_area = 'id="kd_area" class="form-control select2me" style="width:280 px"';
																echo form_dropdown('kd_area', $area, '', $atribut_area);
															?>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kota</label>
															<div class="col-md-6">
																<input type="text" id="kota_lang" name="kota_lang" class="form-control input-sm" placeholder=" ">
																<input type="hidden" id="idkota_lang" name="idkota_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Provinsi</label>
															<div class="col-md-6">
																<input type="text" id="prov_lang" name="prov_lang" class="form-control input-sm" placeholder=" ">
																<input type="hidden" id="idprov_lang" name="idprov_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode POS</label>
															<div class="col-md-6">
																<input type="text" id="kdpos_lang" name="kdpos_lang" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Data Tarif</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tarif Lama</label>
															<div class="col-md-6">
																<input type="text" id="tarif_lama" name="tarif_lama" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Daya Lama</label>
															<div class="col-md-6">
																<input type="text" id="daya_lama" name="daya_lama" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tarif Baru</label>
															<div class="col-md-6">
																<input type="text" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Daya Baru</label>
															<div class="col-md-6">
																<input type="text" id="daya_baru" name="daya_baru" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_1_3">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Data BP dan UJL</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Nomor BP</label>
															<div class="col-md-6">
																<input type="text" id="no_bp" name="no_bp" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tanggal BP</label>
															<div class="col-md-6">
																<input type="text" id="tgl_bp" name="tgl_bp" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left" >RP Sewa Trafo</label>
															<div class="col-md-6">
																<input type="text" id="rp_sewa_trafo" name="rp_sewa_trafo" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Nomor UJL</label>
															<div class="col-md-6">
																<input type="text" id="no_ujl" name="no_ujl" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
													</div>
													<div class="col-md-6">

														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tanggal UJL</label>
															<div class="col-md-6">
																<input type="text" id="tgl_ujl" name="tgl_ujl" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Biaya UJL Lama</label>
															<div class="col-md-6">
																<input type="text" id="rp_ujl_lama" name="rp_ujl_lama" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Biaya UJL Baru</label>
															<div class="col-md-6">
																<input type="text" id="rp_ujl_baru" name="rp_ujl_baru" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Biaya UJL Tagih</label>
															<div class="col-md-6">
																<input type="text" id="rp_ujl_tagih" name="rp_ujl_tagih" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Detail Biaya</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Biaya Penyambungan</label>
															<div class="col-md-6">
																<input type="text" id="rp_bp" name="rp_bp" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Uang Jaminan Langganan</label>
															<div class="col-md-6">
																<input type="text" id="rp_ujl" name="rp_ujl" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Biaya Keterlambatan</label>
															<div class="col-md-6">
																<input type="text" id="rp_bk" name="rp_bk" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tagihan KWH</label>
															<div class="col-md-6">
																<input type="text" id="rp_kwhtag" name="rp_kwhtag" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">P2TL</label>
															<div class="col-md-6">
																<input type="text" id="p2tl" name="p2tl" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Investasi</label>
															<div class="col-md-6">
																<input type="text" id="investasi" name="investasi" class="form-control input-sm" placeholder=" " >
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_1_4">
											<div class="col-md-12">
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="caption">
															<i class="fa fa-globe"></i>
															<span class="caption-subject font-green-sharp bold">Data KWH</span>
														</div>
													</div>
													<div class="panel-body">
														<div class="form-body form-horizontal">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Tanggal Nyala</label>
																	<div class="col-md-6">
																		<input id="tgl_nyala" name="tgl_nyala" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tanggal Pasang Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="tgl_psg_meter" name="tgl_psg_meter" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Merk Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="merk_meter" name="merk_meter" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Type Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="tipe_meter" name="tipe_meter" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">No Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="no_meter" name="no_meter" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Fasa Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="fasa_meter" name="fasa_meter" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tahun Produksi Meter</label>
																	<div class="col-md-6">
																		<div class="input-group input-medium date date-picker" data-date-format="yyyymm" data-date-viewmode="years" data-date-minviewmode="months">
																			<span class="input-group-btn">
																			<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
																			</span>
																			<input type="text" id="thn_prod_meter" name="thn_prod_meter" class="form-control" >
																		</div>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Tahun Tera Meter</label>
																	<div class="col-md-6">
																		<div class="input-group input-medium date date-picker" data-date-format="yyyymm" data-date-viewmode="years" data-date-minviewmode="months">
																			<span class="input-group-btn">
																			<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
																			</span>
																			<input type="text" id="thn_tera_meter" name="thn_tera_meter" class="form-control" >
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="caption">
															<i class="fa fa-globe"></i>
															<span class="caption-subject font-green-sharp bold">Data Pembatas</span>
														</div>
													</div>
													<div class="panel-body">
														<div class="form-body form-horizontal">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tanggal Pasang Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="tgl_psg_pembatas" name="tgl_psg_pembatas" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Merk Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="merk_pembatas" name="merk_pembatas" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tipe Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="tipe_pembatas" name="tipe_pembatas" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Ukuran Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="ukuran_pembatas" name="ukuran_pembatas" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Fasa Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="fasa_pembatas" name="fasa_pembatas" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Setting Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="setting_pembatas" name="setting_pembatas" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tegangan Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="teg_pembatas" name="teg_pembatas" class="form-control input-sm" placeholder=" " >
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="caption">
															<i class="fa fa-globe"></i>
															<span class="caption-subject font-green-sharp bold">CT dan PT</span>
														</div>
													</div>
													<div class="panel-body">
														<div class="form-body form-horizontal">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tanggal Pasang CT</label>
																	<div class="col-md-6">
																		<input id="tgl_psg_ct" name="tgl_psg_ct" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
																	</div>
																</div>

																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >I Primer CT</label>
																	<div class="col-md-6">
																		<input type="text" id="i_primer_ct" name="i_primer_ct" onkeyup="hitung()" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">I Sekunder CT</label>
																	<div class="col-md-6">
																		<input type="text" id="i_sekunder_ct" name="i_sekunder_ct" onkeyup="hitung()" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Tanggal Pasang PT</label>
																	<div class="col-md-6">
																		<input id="tgl_psg_pt" name="tgl_psg_pt" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >V Primer PT</label>
																	<div class="col-md-6">
																		<input type="text" id="v_primer_pt" name="v_primer_pt" onkeyup="hitung()" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >V Sekunder PT</label>
																	<div class="col-md-6">
																		<input type="text" id="v_sekunder_pt" name="v_sekunder_pt" onkeyup="hitung()" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="panel panel-default">
													<div class="panel-heading">
														<div class="caption">
															<i class="fa fa-globe"></i>
															<span class="caption-subject font-green-sharp bold">Stand Bongkar Pasang</span>
														</div>
													</div>
													<div class="panel-body">
														<div class="form-body form-horizontal">
															<div class="col-md-6">
																<div class="form-group" id="tgl_psg_ps" >
																	<label class="col-md-6 control-label align-left" >Tanggal Pasang Stand</label>
																	<div class="col-md-6">
																		<input type="text" id="tgl_psg_ps" name="tgl_psg_ps" placeholder="yyyy-mm-dd" class="form-control datepicker">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Stand Pasang LWBP</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_psg_lwbp" name="stand_psg_lwbp" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Stand Pasang WBP</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_psg_wbp" name="stand_psg_wbp" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Stand Pasang KVARH</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_psg_kvarh" name="stand_psg_kvarh" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group" id="tgl_bkr_ps" >
																	<label class="col-md-6 control-label align-left" >Tanggal Bongkar Stand</label>
																	<div class="col-md-6">
																		<input type="text" id="tgl_bkr_ps" name="tgl_bkr_ps" placeholder="yyyy-mm-dd" class="form-control datepicker">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Stand Bongkar LWBP</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" >Stand Bongkar WBP</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Stand Bongkar KVARH</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" placeholder=" ">
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="caption">
																<i class="fa fa-globe"></i>
																<span class="caption-subject font-green-sharp bold">FRT dan FK Meter</span>
															</div>
														</div>
														<div class="panel-body">
															<div class="form-body form-horizontal">
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="col-md-6 control-label align-left" >FK Meter</label>
																		<div class="col-md-6">
																			<input type="text" id="fk_meter" name="fk_meter" class="form-control input-sm" placeholder=" " readonly>
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-6 control-label align-left" >FRT</label>
																		<div class="col-md-6">
																			<input type="text" id="frt" name="frt" class="form-control input-sm" placeholder=" ">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<div class="panel panel-default">
														<div class="panel-heading">
															<div class="caption">
																<i class="fa fa-globe"></i>
																<span class="caption-subject font-green-sharp bold">Koordinat</span>
															</div>
														</div>
														<div class="panel-body">
															<div class="form-body form-horizontal">
																<div class="col-md-12">
																	<div class="form-group">
																		<label class="col-md-6 control-label align-left" >koordinat X</label>
																		<div class="col-md-6">
																			<input type="text" id="koordinatx" name="koordinatx" class="form-control input-sm" placeholder=" ">
																		</div>
																	</div>
																	<div class="form-group">
																		<label class="col-md-6 control-label align-left" >koordinat Y</label>
																		<div class="col-md-6">
																			<input type="text" id="koordinaty" name="koordinaty" class="form-control input-sm" placeholder=" ">
																		</div>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
									</div>
									<div class="tab-pane fade" id="tab_1_5">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Data Suplai</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">No Panel</label>
															<div class="col-md-6">
																<?php
																	$atribut_no_panel = 'id="no_panel" class="form-control select2me" style="width: 200px;"';
																	echo form_dropdown('no_panel', $no_panel, '', $atribut_no_panel);
																?>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode Trafo Dist</label>
															<div class="col-md-6">
																<input type="text" id="kd_trafo_dist" name="kd_trafo_dist" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode Gardu</label>
															<div class="col-md-6">
																<input type="text" id="kd_gardu" name="kd_gardu" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode Penyulang</label>
															<div class="col-md-6">
																<input type="text" id="kd_penyulang" name="kd_penyulang" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode Trafo GI</label>
															<div class="col-md-6">
																<input type="text" id="kd_trafo_gi" name="kd_trafo_gi" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Kode GI</label>
															<div class="col-md-6">
																<input type="text" id="kd_gi" name="kd_gi" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Jenis Sambungan</label>
															<div class="col-md-6">
																<input type="text" id="jns_sm" name="jns_sm" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Panjang Sambungan</label>
															<div class="col-md-6">
																<input type="text" id="pjg_sm" name="pjg_sm" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Tegangan Sambungan</label>
															<div class="col-md-6">
																<input type="text" id="teg_sambung" name="teg_sambung" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label align-left">Fasa Sambungan</label>
															<div class="col-md-6">
																<input type="text" id="fasa_sm" name="fasa_sm" class="form-control input-sm" placeholder=" "  >
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_1_6">
										<div class="panel panel-default">
											<div class="panel-heading">
												<div class="caption">
													<i class="fa fa-globe"></i>
													<span class="caption-subject font-green-sharp bold">Lain-lain</span>
												</div>
											</div>
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label align-left" >ID PEL PLN</label>
															<div class="col-md-6">
																<input type="text" id="idpel_pln" name="idpel_pln" class="form-control input-sm" placeholder=" ">
															</div>
														</div>
													</div>
													<div class="col-md-6">

													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix margin-bottom-20">
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="form-body form-horizontal">
								<div class="col-md-1">
									<div class="btn-group">
										<a type="button" id="btnSave" onclick="save()" class="btn green">Simpan </a>
									</div>
								</div>
								<div class="col-md-1">
										<a type="button" id="btnCetak" onclick="cetak(1)" class="btn blue">Cetak</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</form>
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
<script src="../../assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="../../assets/admin/pages/scripts/components-pickers.js"></script>
<script>
jQuery(document).ready(function() {
Metronic.init();
Layout.init();
Demo.init();
ComponentsPickers.init();
});

var save_method;
var table;

function save(){
	if(sudahcari == 'no'){alert("Lakukan pencarian berdasarkan ID Langganan dulu"); return false}

	var psg_ps   = $("#tgl_psg_ps").datepicker('getDate');
	var bkr_ps   = $("#tgl_bkr_ps").datepicker('getDate');
	var JNS = $("#jns_transaksi").val();
	if(JNS == '- Pilih -' || JNS == ''){
		alert("Tentukan Jenis Transaksi di TAB INFORMASI"); return false
	}

	if($("#id_cust").val() == ''){alert("ID Customer kosong"); return false}
	if($("#id_lang").val() == ''){alert("ID Langganan kosong"); return false}


	var save_method = 'add';
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/pdl_add')?>";
    } else {
        url = "<?php echo site_url('pelayanan/pdl_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			alert('Berhasil disimpan');
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
