<script>
$(document).ready(function() {
	$("#ps").hide();
	$("#nonps").show();
	$("#stand").hide();
	$("#datateknis").show();
});
function cetakrekap(x){
	if(x==1){
		hreF	= "<?php echo site_url("Laporan/rpt_rekapmohon")?>";
		ReQuest = "/" + x + "/REKAP PERMOHONAN";
		window.open(hreF+ReQuest, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_rekapmohonexcel")?>";
		window.open(hreF, '_blank');
	}
}

function cetakdet(x,y){
	if(y==1){
		hreF	= "<?php echo site_url("Laporan/rpt_detailmohon")?>";
		ReQuest = "/" + y + "/" + x;
		window.open(hreF+ReQuest, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_detailmohonexcel")?>"+x;
		window.open(hreF, '_blank');
	}
}

function cetak_survey(agd,x){
	hreF	= "<?php echo site_url("Laporan/rpt_survey")?>";
	ReQuest	= "/" + x +"/" + agd;
	window.open(hreF+ReQuest, '_blank');
}

function cetaksudahpdl(x){
	hreF	= "<?php echo site_url("Laporan/rpt_sudahpdlexcel")?>";
	window.open(hreF, '_blank');
}

function cetakps(x){
	hreF	= "<?php echo site_url("Laporan/rpt_monitoringps")?>";
	window.open(hreF, '_blank');
}

//TAB INFORMASI AGENDA
function cari(){
		$('#BtnSave').attr('disabled',false);
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagendasurvey/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {

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
						$("#daya_lama").val(obj.TARIF_LAMA);
						$("#tarif_baru").val(obj.TARIF_BARU);
						$("#daya_baru").val(obj.DAYA_BARU);
						$("#ppj").val(obj.KD_PPJ);
						$("#rpkwh_ps").val(number_format(obj.RPKWH_PS));
						$("#rpbpju_ps").val(number_format(obj.RPBPJU_PS));
						$("#materai").val(number_format(obj.MATERAI));
						$("#ujl_tagih").val(number_format(obj.RP_UJL_TAGIH,0,'.',','));
						if(obj.JNS_TRANSAKSI == "PASANG BARU" || obj.JNS_TRANSAKSI == "PERUBAHAN DAYA"){
							var tb = parseInt(obj.RP_BP) + parseInt(obj.RP_UJL_TAGIH) + parseInt(obj.MATERAI);
						}else if (obj.JNS_TRANSAKSI == "PENERANGAN SEMENTARA"){
							var tb = parseInt(obj.RP_BP) + parseInt(obj.RPKWH_PS) + parseInt(obj.RPBPJU_PS) + parseInt(obj.MATERAI);
						}else{
							var tb = obj.TOTAL_BIAYA;
						}
						$("#totbiaya").val(number_format(tb));
						caril();
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Selamat pagi");
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
				alert("Selamat pagi");
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

//TAB INFORMASI LANGGANAN
function caripdl(){
	var cariy   = document.getElementById("caripdl").value;
	var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_pdl_mon/'+cariy;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj) {
				cek = obj.NO_AGENDA;
				JNS = obj.JNS_TRANSAKSI;
				if(cek==''){
					alert("Data Tidak Ditemukan!");
					$('[name="caripdl"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="caripdl"]').attr('value',''); 
					$('[name="caripdl"]').attr('placeholder','Data tidak ada');
				}
				
				if(JNS == 'PENERANGAN SEMENTARA'){
					$("#tgl_psg_ps").show();
					$("#tgl_bkr_ps").show();
				}else{
					$("#tgl_psg_ps").hide();
					$("#tgl_bkr_ps").hide();
				}
				
				//Informasi
				$("#no_pdl").val(obj.NO_PDL);
				$("#tgl_pdl").val(obj.TGL_PDL);
				$("#tgl_mut").val(obj.TGL_MUT);
				$("#jns_transaksiinfo").val(obj.JNS_TRANSAKSI);
				$("#no_agenda").val(obj.NO_AGENDA);
				$("#no_regis").val(obj.NO_REGIS);
				
				//Administratif
				$("#id_langinfo").val(obj.ID_LANG);
				$("#nama_langinfo").val(obj.NAMA_LANG);
				$("#alamat_langinfo").val(obj.ALAMAT_LANG);
				$("#kec_langinfo").val(obj.KECLANG);
				$("#kd_wilayahinfo").val(obj.KD_WILAYAH).trigger('change');
				$("#areainfo").val(obj.NM_AREA);
				$("#kota_langinfo").val(obj.KABLANG);
				$("#prov_langinfo").val(obj.PROVLANG);
				$("#kdpos_langinfo").val(obj.KDPOS_LANG);
				$("#tarif_lama").val(obj.TARIF_LAMA);
				$("#daya_lama").val(obj.DAYA_LAMA);
				$("#tarif_baru").val(obj.TARIF_BARU);
				$("#daya_baru").val(obj.DAYA_BARU);
				
				//Biaya
				$("#no_bp").val(obj.NO_BP);
				$("#tgl_bp").val(obj.TGL_BP);
				$("#rp_sewa_trafo").val(obj.RP_SEWA_TRAFO);
				$("#no_ujl").val(obj.NO_UJL);
				$("#tgl_ujl").val(obj.TGL_UJL);
				$("#rp_ujl_lama").val(obj.RP_UJL_LAMA);
				$("#rp_ujl_baru").val(obj.RP_UJL_BARU);
				$("#rp_ujl_tagih").val(obj.RP_UJL_TAGIH);
				
				//APP
				$("#tgl_nyala").val(obj.TGL_NYALA);
				$("#tgl_psg_meter").val(obj.TGL_PSG_METER);
				$("#merk_meterinfo").val(obj.MERK_METER);
				$("#tipe_meter").val(obj.TIPE_METER);
				$("#no_meterinfo").val(obj.NO_METER);
				$("#fasa_meter").val(obj.FASA_METER);
				$("#thn_prod_meter").val(obj.THN_PROD_METER);
				$("#thn_tera_meter").val(obj.THN_TERA_METER);
				
				$("#tgl_psg_pembatas").val(obj.TGL_PSG_PEMBATAS);
				$("#merk_pembatasinfo").val(obj.MERK_PEMBATAS);
				$("#tipe_pembatas").val(obj.TIPE_PEMBATAS);
				$("#ukuran_pembatas").val(obj.UKURAN_PEMBATAS);
				$("#fasa_pembatas").val(obj.FASA_PEMBATAS);
				$("#setting_pembatasinfo").val(obj.SETTING_PEMBATAS);
				$("#teg_pembatas").val(obj.TEG_PEMBATAS);
				
				$("#tgl_psg_ct").val(obj.TGL_PSG_CT);
			if(obj.I_PRIMER_CT == '' || obj.I_PRIMER_CT == null){$("#i_primer_ct").val('1');}else{$("#i_primer_ct").val(obj.I_PRIMER_CT);};
			if(obj.I_SEKUNDER_CT == '' || obj.I_SEKUNDER_CT == null){$("#i_sekunder_ct").val('1');}else{$("#i_sekunder_ct").val(obj.I_SEKUNDER_CT);};
				$("#tgl_psg_pt").val(obj.TGL_PSG_PT);
			if(obj.V_PRIMER_PT == '' || obj.V_PRIMER_PT == null){$("#v_primer_pt").val('1');}else{$("#v_primer_pt").val(obj.V_PRIMER_PT);};
			if(obj.V_SEKUNDER_PT == '' || obj.V_SEKUNDER_PT == null){$("#v_sekunder_pt").val('1');}else{$("#v_sekunder_pt").val(obj.V_SEKUNDER_PT);};
				
				$("#stand_bkr_lwbpinfo").val(obj.STAND_BKR_LWBP);
				$("#stand_bkr_wbpinfo").val(obj.STAND_BKR_WBP);
				$("#stand_bkr_kvarhinfo").val(obj.STAND_BKR_KVARH);
				
				$("#stand_psg_lwbp").val(obj.STAND_PSG_LWBP);
				$("#stand_psg_wbp").val(obj.STAND_PSG_WBP);
				$("#stand_psg_kvarh").val(obj.STAND_PSG_KVARH);
				
				$("#fk_meter").val(obj.FK_METER);
				$("#frt").val(obj.FRT);
				$("#koordinatx").val(obj.KOORDINATX);
				$("#koordinaty").val(obj.KOORDINATY);
				
				//SUPLAI
				$("#no_panelinfo").val(obj.NO_PANEL);
				$("#kd_trafo_distinfo").val(obj.KD_TRAFO_DIST);
				$("#kd_garduinfo").val(obj.KD_GARDU);
				$("#kd_penyulanginfo").val(obj.KD_PENYULANG);
				$("#kd_trafo_giinfo").val(obj.KD_TRAFO_GI);
				$("#kd_giinfo").val(obj.KD_GI);
				$("#jns_sminfo").val(obj.JNS_SM);
				$("#pjg_sminfo").val(obj.PJG_SM);
				$("#teg_sambunginfo").val(obj.TEG_SAMBUNG);
				
				//LAINLAIN
				$("#idpel_pln").val(obj.IDPEL_PLN);
				
				caricust(obj.ID_CUST);
				cariangs(obj.NO_AGENDA,obj.ID_LANG);
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Selamat Pagi");
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

function cariangs(noagd,idlang){
	var baseUrl = '<?php echo base_url();?>index.php/pelayanan/cari_angs/'+noagd.trim()+'/'+idlang.trim();
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			var agd = $.map(datas, function (obj) {
				$("#rp_bpinfo").val(obj.RP_BP);
				$("#rp_ujlinfo").val(obj.RP_UJL);
				$("#rp_bkinfo").val(obj.RP_BK);
				$("#rpkwh_taginfo").val(obj.RPKWH_TAG);
				$("#p2tlinfo").val(obj.P2TL);
				$("#investasiinfo").val(obj.INVESTASI);
			});
		}
	});
}


</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Monitoring Pelayanan <small>Pelayanan</small></h1>
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
								<i class="fa fa-gift"></i>Monitoring Pelayanan
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Rekap Permohonan </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Detail Belum Survey </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab">
									Detail Belum SIP </a>
								</li>
								<li>
									<a href="#tab_1_4" data-toggle="tab">
									Detail Belum Bayar </a>
								</li>
								<li>
									<a href="#tab_1_5" data-toggle="tab">
									Detail Belum PK</a>
								</li>
								<li>
									<a href="#tab_1_6" data-toggle="tab">
									Detail Belum PDL</a>
								</li>
								<li>
									<a href="#tab_1_7" data-toggle="tab">
									Detail Sudah PDL</a>
								</li>
								<li>
									<a href="#tab_1_11" data-toggle="tab">
									Rekap Sudah PDL</a>
								</li>
								<li>
									<a href="#tab_1_8" data-toggle="tab">
									Monitoring Penerangan Sementara</a>
								</li>
								<li>
									<a href="#tab_1_9" data-toggle="tab">
									Informasi Agenda</a>
								</li>
								<li>
									<a href="#tab_1_10" data-toggle="tab">
									Informasi Langganan</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									<?php echo $this->table->generate($rekapmohon);?>	
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn blue" onclick="cetakrekap(1)">Cetak Rekap PDF</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakrekap(2)">Cetak Rekap EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetsurvey">
										<thead>
											<tr >
												<th>
													 THBLMOHON
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUST
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 CETAK SURVEY
												</th>
												<th>
													 TANGGAL MOHON
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn blue" onclick="cetakdet('survey',1)">Cetak Detail PDF</a>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakdet('survey',2)">Cetak Detail EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_3">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetsip">
										<thead>
											<tr>
												<th>
													 THBLMOHON
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 CETAK SURVEY
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn blue" onclick="cetakdet('sip',1)">Cetak Detail PDF</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn green" onclick="cetakdet('sip',2)">Cetak Detail EXCEL</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_4">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetbayar">
										<thead>
											<tr>
												<th>
													 THBLMOHON
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 CETAK SIP
												</th>
												<th>
													 TOTAL RUPIAH
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn blue" onclick="cetakdet('bayar',1)">Cetak Detail PDF</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn green" onclick="cetakdet('bayar',2)">Cetak Detail EXCEL</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_5">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetpk">
										<thead>
											<tr>
												<th>
													 THBLMOHON
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 TGL BAYAR
												</th>
												<th>
													 POLA BAYAR
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn blue" onclick="cetakdet('pk',1)">Cetak Detail PDF</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn green" onclick="cetakdet('pk',2)">Cetak Detail EXCEL</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_6">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetpdl">
										<thead>
											<tr >
												<th>
													 THBLMOHON
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 CETAK PK
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn blue" onclick="cetakdet('pdl',1)">Cetak Detail PDF</button>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<button type="submit" class="btn green" onclick="cetakdet('pdl',2)">Cetak Detail EXCEL</button>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_7">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetsudahpdl">
										<thead>
											<tr >
												<th>
													 THBLMOHON
												</th>
												<th>
													 THBLMUTASI
												</th>
												<th>
													 NO AGENDA
												</th>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA MOHON
												</th>
												<th>
													 ID LANGGANAN
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TRANSAKSI
												</th>
												<th>
													 STATUS
												</th>
												<th>
													 CETAK
												</th>
												<th>
													 NO PDL
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="input-group">
										<a type="button" onclick="cetaksudahpdl()" class="btn green">Export to Excel </a>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_11">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekapsudahpdl">
										<thead>
											<tr >
												<th>
													 THBLMOHON
												</th>
												<th>
													 THBLMUTASI
												</th>
												<th>
													 JENIS TRANSAKSI
												</th>
												<th>
													 JUMLAH
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									
								</div>
								<div class="tab-pane fade" id="tab_1_8">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetps">
										<thead>
											<tr >
												<th>
													 NO AGENDA
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 TANGGAL MOHON
												</th>
												<th>
													 TANGGAL AWAL
												</th>
												<th>
													 TANGGAL AKHIR
												</th>
												<th>
													 TANGGAL BAYAR
												</th>
												<th>
													 TANGGAL NYALA
												</th>
												<th>
													 TANGGAL BONGKAR
												</th>
												<th>
													 STATUS MOHON
												</th>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									<div class="input-group">
										<a type="button" onclick="cetakps()" class="btn green">Export to Excel </a>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_9">	
									<div class="row ">
										<div class="col-md-12">
											<div class="panel panel-success">
												<div class="panel-body form-horizontal">
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
														<i class="fa fa-globe"></i>Data Administrasi Langganan dan Biaya
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
																		<input type="text" id="rp_bp" name="rp_bp" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Uang Jaminan Langganan</label>
																	<div class="col-md-6">
																		<input type="text" id="ujl_tagih" name="ujl_tagih" class="form-control input-sm" placeholder=" " readonly>
																		<input type="hidden" id="pola_bayar" name="pola_bayar" class="form-control input-sm" placeholder=" " readonly>
																		<input type="hidden" id="ppj" name="ppj" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Rupiah KWH</label>
																	<div class="col-md-6">
																		<input type="text" id="rpkwh_ps" name="rpkwh_ps" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Rupiah BPJU</label>
																	<div class="col-md-6">
																		<input type="text" id="rpbpju_ps" name="rpbpju_ps" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Materai</label>
																	<div class="col-md-6">
																		<input type="text" id="materai" name="materai" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Total Biaya</label>
																	<div class="col-md-6">
																		<input type="text" id="totbiaya" name="totbiaya" class="form-control input-sm" placeholder=" " readonly>
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
														<i class="fa fa-globe"></i>Data Teknis
													</div>
												</div>		
												<div class="portlet-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Saluran Masuk ke</label>
																	<div class="col-md-6">
																		<input type="text" id="sm_ke" name="sm_ke" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Titik Sambung</label>
																	<div class="col-md-6">
																		<input type="text" id="titik_sm" name="titik_sm" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Panjang Saluran Masuk</label>
																	<div class="col-md-6">
																		<input type="text" id="pjg_sm" name="pjg_sm" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Jenis Saluran Masuk</label>
																	<div class="col-md-6">
																		<input type="text" id="jns_sm" name="jns_sm" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Merk Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="merk_meter" name="merk_meter" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">No Meter</label>
																	<div class="col-md-6">
																		<input type="text" id="no_meter" name="no_meter" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Merk Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="merk_pembatas" name="merk_pembatas" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Ukuran Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="ukuran_pembatas" name="ukuran_pembatas" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Setting Pembatas</label>
																	<div class="col-md-6">
																		<input type="text" id="setting_pembatas" name="setting_pembatas" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">No Panel Distribusi</label>
																	<div class="col-md-6">
																		<input type="text" id="no_panel" name="no_panel" class="form-control input-sm" placeholder=" " readonly>
																	</div>																
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Kode Trafo Dist</label>
																	<div class="col-md-6">
																		<input type="text" id="kd_trafo_dist" name="kd_trafo_dist" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Kode Gardu</label>
																	<div class="col-md-6">
																		<input type="text" id="kd_gardu" name="kd_gardu" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Kode Penyulang</label>
																	<div class="col-md-6">
																		<input type="text" id="kd_penyulang" name="kd_penyulang" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Kode Trafo GI</label>
																	<div class="col-md-6">
																		<input type="text" id="kd_trafo_gi" name="kd_trafo_gi" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Kode GI</label>
																	<div class="col-md-6">
																		<input type="text" id="kd_gi" name="kd_gi" class="form-control input-sm" placeholder=" " readonly>
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
														<i class="fa fa-globe"></i>Data Stand
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
																		<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">WBP</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">KVARH</label>
																	<div class="col-md-6">
																		<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
															</div>			
														</div>
													</div>
												</div>
											</div>
										</div>			
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_10">
									<div class="row ">
										<div class="col-md-12">
											<div class="panel panel-success">
												<div class="panel-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<label class="col-md-3 control-label align-left">Cari No. Langganan</label>
															<div class="col-md-9">
																<div class="input-group">
																	<input id="caripdl" name="caripdl" class="form-control" />
																	<span class="input-group-btn">
																		<a type="button" onclick="caripdl()" class="btn green">Cari </a>
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
																<a href="#tabinfo_1_1" data-toggle="tab">
																Informasi </a>
															</li>
															<li>
																<a href="#tabinfo_1_2" data-toggle="tab">
																Administratif </a>
															</li>
															<li>
																<a href="#tabinfo_1_3" data-toggle="tab">
																Biaya</a>
															</li>
															<li>
																<a href="#tabinfo_1_4" data-toggle="tab">
																APP</a>
															</li>
															<li>
																<a href="#tabinfo_1_5" data-toggle="tab">
																Suplai</a>
															</li>
															<li>
																<a href="#tabinfo_1_6" data-toggle="tab">
																Lain-lain</a>
															</li>
														</ul>
														<div class="tab-content">
															<div class="tab-pane fade active in" id="tabinfo_1_1">
																<div class="panel panel-default">
																	<div class="panel-heading">
																		<div class="caption">
																			<i class="fa fa-globe"></i>
																			<span class="caption-subject font-green-sharp bold">Detil Mutasi</span>
																		</div>
																	</div>
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
																						<input type="text" id="tgl_mut" name="tgl_mut" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Jenis Transaksi</label>
																					<div class="col-md-6">
																						<input type="text" id="jns_transaksiinfo" name="jns_transaksiinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="tabinfo_1_2">
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
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kota</label>
																					<div class="col-md-6">
																						<input type="text" id="kota_cust" name="kota_cust" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
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
																						<input type="text" id="id_langinfo" name="id_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Nama Langganan</label>
																					<div class="col-md-6">
																						<input type="text" id="nama_langinfo" name="nama_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Alamat Langganan</label>
																					<div class="col-md-6">
																						<input type="text" id="alamat_langinfo" name="alamat_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kecamatan</label>
																					<div class="col-md-6">
																						<input type="text" id="kec_langinfo" name="kec_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="control-label col-md-6 align-left" >Wilayah</label>
																					<div class="col-md-6">
																						<div class="input-group">
																							<span class="input-group-addon">
																							<i class="fa fa-user"></i>
																							</span>
																							<select id="kd_wilayah" name="kd_wilayah" class="form-control select2me" data-placeholder="Select..." readonly>
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
																						<input type="text" id="areainfo" name="areainfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kota</label>
																					<div class="col-md-6">
																						<input type="text" id="kota_langinfo" name="kota_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Provinsi</label>
																					<div class="col-md-6">
																						<input type="text" id="prov_langinfo" name="prov_langinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode POS</label>
																					<div class="col-md-6">
																						<input type="text" id="kdpos_langinfo" name="kdpos_langinfo" class="form-control input-sm" placeholder=" " readonly>
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
																						<input type="text" id="tarif_lama" name="tarif_lama" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Daya Lama</label>
																					<div class="col-md-6">
																						<input type="text" id="daya_lama" name="daya_lama" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Tarif Baru</label>
																					<div class="col-md-6">
																						<input type="text" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Daya Baru</label>
																					<div class="col-md-6">
																						<input type="text" id="daya_baru" name="daya_baru" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="tabinfo_1_3">
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
																						<input type="text" id="no_bp" name="no_bp" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Tanggal BP</label>
																					<div class="col-md-6">
																						<input type="text" id="tgl_bp" name="tgl_bp" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left" >RP Sewa Trafo</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_sewa_trafo" name="rp_sewa_trafo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Nomor UJL</label>
																					<div class="col-md-6">
																						<input type="text" id="no_ujl" name="no_ujl" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
																				
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Tanggal UJL</label>
																					<div class="col-md-6">
																						<input type="text" id="tgl_ujl" name="tgl_ujl" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Biaya UJL Lama</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_ujl_lama" name="rp_ujl_lama" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Biaya UJL Baru</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_ujl_baru" name="rp_ujl_baru" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Biaya UJL Tagih</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_ujl_tagih" name="rp_ujl_tagih" class="form-control input-sm" placeholder=" " readonly>
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
																						<input type="text" id="rp_bpinfo" name="rp_bpinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Uang Jaminan Langganan</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_ujlinfo" name="rp_ujlinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Biaya Keterlambatan</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_bkinfo" name="rp_bkinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Tagihan KWH</label>
																					<div class="col-md-6">
																						<input type="text" id="rp_kwhtaginfo" name="rp_kwhtaginfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">P2TL</label>
																					<div class="col-md-6">
																						<input type="text" id="p2tlinfo" name="p2tlinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Investasi</label>
																					<div class="col-md-6">
																						<input type="text" id="investasiinfo" name="investasiinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="tabinfo_1_4">
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
																								<input id="tgl_nyala" name="tgl_nyala" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Tanggal Pasang Meter</label>
																							<div class="col-md-6">
																								<input type="text" id="tgl_psg_meter" name="tgl_psg_meter" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Merk Meter</label>
																							<div class="col-md-6">
																								<input type="text" id="merk_meterinfo" name="merk_meterinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Type Meter</label>
																							<div class="col-md-6">
																								<input type="text" id="tipe_meter" name="tipe_meter" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>																
																					</div>
																					<div class="col-md-6">
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">No Meter</label>
																							<div class="col-md-6">
																								<input type="text" id="no_meterinfo" name="no_meterinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Fasa Meter</label>
																							<div class="col-md-6">
																								<input type="text" id="fasa_meter" name="fasa_meter" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>																
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Tahun Produksi Meter</label>
																							<div class="col-md-6">
																								<div class="input-group input-medium date date-picker" data-date-format="yyyymm" data-date-viewmode="years" data-date-minviewmode="months">
																									<span class="input-group-btn">
																									<button class="btn default" type="button"><i class="fa fa-calendar"></i></button>
																									</span>
																									<input type="text" id="thn_prod_meter" name="thn_prod_meter" class="form-control" readonly>
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
																									<input type="text" id="thn_tera_meter" name="thn_tera_meter" class="form-control" readonly>
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
																								<input type="text" id="tgl_psg_pembatas" name="tgl_psg_pembatas" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Merk Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="merk_pembatasinfo" name="merk_pembatasinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Tipe Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="tipe_pembatas" name="tipe_pembatas" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Ukuran Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="ukuran_pembatas" name="ukuran_pembatas" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6">
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Fasa Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="fasa_pembatas" name="fasa_pembatas" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Setting Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="setting_pembatasinfo" name="setting_pembatasinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Tegangan Pembatas</label>
																							<div class="col-md-6">
																								<input type="text" id="teg_pembatas" name="teg_pembatas" class="form-control input-sm" placeholder=" " readonly>
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
																								<input id="tgl_psg_ct" name="tgl_psg_ct" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly>
																							</div>
																						</div>
																						
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >I Primer CT</label>
																							<div class="col-md-6">
																								<input type="text" id="i_primer_ct" name="i_primer_ct" onkeyup="hitung()" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">I Sekunder CT</label>
																							<div class="col-md-6">
																								<input type="text" id="i_sekunder_ct" name="i_sekunder_ct" onkeyup="hitung()" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6">
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Tanggal Pasang PT</label>
																							<div class="col-md-6">
																								<input id="tgl_psg_pt" name="tgl_psg_pt" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >V Primer PT</label>
																							<div class="col-md-6">
																								<input type="text" id="v_primer_pt" name="v_primer_pt" onkeyup="hitung()" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >V Sekunder PT</label>
																							<div class="col-md-6">
																								<input type="text" id="v_sekunder_pt" name="v_sekunder_pt" onkeyup="hitung()" class="form-control input-sm" placeholder=" " readonly>
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
																								<input type="text" id="tgl_psg_ps" name="tgl_psg_ps" placeholder="yyyy-mm-dd" class="form-control datepicker" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Stand Pasang LWBP</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_psg_lwbp" name="stand_psg_lwbp" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Stand Pasang WBP</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_psg_wbp" name="stand_psg_wbp" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Stand Pasang KVARH</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_psg_kvarh" name="stand_psg_kvarh" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																					</div>
																					<div class="col-md-6">
																						<div class="form-group" id="tgl_bkr_ps" >
																							<label class="col-md-6 control-label align-left" >Tanggal Bongkar Stand</label>
																							<div class="col-md-6">
																								<input type="text" id="tgl_bkr_ps" name="tgl_bkr_ps" placeholder="yyyy-mm-dd" class="form-control datepicker" readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Stand Bongkar LWBP</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_bkr_lwbpinfo" name="stand_bkr_lwbpinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left" >Stand Bongkar WBP</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_bkr_wbpinfo" name="stand_bkr_wbpinfo" class="form-control input-sm" placeholder=" " readonly>
																							</div>
																						</div>
																						<div class="form-group">
																							<label class="col-md-6 control-label align-left">Stand Bongkar KVARH</label>
																							<div class="col-md-6">
																								<input type="text" id="stand_bkr_kvarhinfo" name="stand_bkr_kvarhinfo" class="form-control input-sm" placeholder=" " readonly>
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
																									<input type="text" id="frt" name="frt" class="form-control input-sm" placeholder=" " readonly>
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
																									<input type="text" id="koordinatx" name="koordinatx" class="form-control input-sm" placeholder=" " readonly>
																								</div>
																							</div>
																							<div class="form-group">
																								<label class="col-md-6 control-label align-left" >koordinat Y</label>
																								<div class="col-md-6">
																									<input type="text" id="koordinaty" name="koordinaty" class="form-control input-sm" placeholder=" " readonly>
																								</div>
																							</div>
																						</div>
																					</div>	
																				</div>
																			</div>
																		</div>
																	</div>
															</div>
															<div class="tab-pane fade" id="tabinfo_1_5">
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
																						<input type="text" id="no_panelinfo" name="no_panelinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode Trafo Dist</label>
																					<div class="col-md-6">
																						<input type="text" id="kd_trafo_distinfo" name="kd_trafo_distinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode Gardu</label>
																					<div class="col-md-6">
																						<input type="text" id="kd_garduinfo" name="kd_garduinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode Penyulang</label>
																					<div class="col-md-6">
																						<input type="text" id="kd_penyulanginfo" name="kd_penyulanginfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode Trafo GI</label>
																					<div class="col-md-6">
																						<input type="text" id="kd_trafo_giinfo" name="kd_trafo_giinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Kode GI</label>
																					<div class="col-md-6">
																						<input type="text" id="kd_giinfo" name="kd_giinfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Jenis Sambungan</label>
																					<div class="col-md-6">
																						<input type="text" id="jns_sminfo" name="jns_sminfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Panjang Sambungan</label>
																					<div class="col-md-6">
																						<input type="text" id="pjg_sminfo" name="pjg_sminfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																				<div class="form-group">
																					<label class="col-md-6 control-label align-left">Tegangan Sambungan</label>
																					<div class="col-md-6">
																						<input type="text" id="teg_sambunginfo" name="teg_sambunginfo" class="form-control input-sm" placeholder=" " readonly>
																					</div>
																				</div>
																			</div>
																		</div>	
																	</div>
																</div>
															</div>
															<div class="tab-pane fade" id="tabinfo_1_6">
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
																						<input type="text" id="idpel_pln" name="idpel_pln" class="form-control input-sm" placeholder=" " readonly>
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
									</div>
								</div>
								
							</div>
							<div class="clearfix margin-bottom-20">
							</div>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
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
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!-- TAMBHAN -->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script> 
<script>
jQuery(document).ready(function() {   
Metronic.init();
Layout.init();
Demo.init();
});


$(document).ready(function() {
	tabledetsurvey = $('#tabledetsurvey').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detsurvey_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
        ],
    });
	
	tabledetsip = $('#tabledetsip').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detsip_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
        ],
    });
	
	tabledetbayar = $('#tabledetbayar').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detbayar_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
		{ "className": "text-right", "targets": [-1] },
        ],
    });
	
	tabledetpk = $('#tabledetpk').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detpk_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
        ],
    });
	
	tabledetpdl = $('#tabledetpdl').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detpdl_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
        ],
    });
	
	tabledetsudahpdl = $('#tabledetsudahpdl').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detsudahpdl_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
			width: 30, targets: 4,
			width: 10, targets: 6,
        },
        ],
    });
	
	tablerekapsudahpdl = $('#tablerekapsudahpdl').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/rekapsudahpdl_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
			width: 10, targets: 0,
			width: 30, targets: 3,
        },
        ],
    });
	
	tabledetps = $('#tabledetps').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('pelayanan/detps_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ],
            "orderable": false,
        },
        ],
    });
	
});

</script>
</body>
</html>