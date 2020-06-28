<script>
$(document).ready(function() {

	$("#tablearea").show();
	$("#tablegol").hide();
	$("#tablecust").hide();
	$("#tablelang").hide();
	$("#tablethblrek").hide();
	$("#filterthblrek").hide();
	$("#filtergol").hide();
	$("#filterarea").show();
	$("#tablerekterbitthblrek").hide();
	$("#filtersaldo").on("change", function(){
		var v = $(this).val();
		if(v == "AREA"){
			$("#tablearea").show();
			$("#tablegol").hide();
			$("#tablecust").hide();
			$("#tablelang").hide();
			$("#tablethblrek").hide();
		}else if(v == "GOLONGAN" ){
			$("#tablearea").hide();
			$("#tablegol").show();
			$("#tablecust").hide();
			$("#tablelang").hide();
			$("#tablethblrek").hide();
		}else if(v == "CUST" ){
			$("#tablearea").hide();
			$("#tablegol").hide();
			$("#tablecust").show();
			$("#tablelang").hide();
			$("#tablethblrek").hide();
		}else if(v == "LANG"){
			$("#tablearea").hide();
			$("#tablegol").hide();
			$("#tablecust").hide();
			$("#tablelang").show();
			$("#tablethblrek").hide();
		}else if(v == "THBLREK"){
			$("#tablearea").hide();
			$("#tablegol").hide();
			$("#tablecust").hide();
			$("#tablelang").hide();
			$("#tablethblrek").show();
		}else{
			$("#tablearea").show();
			$("#tablegol").hide();
			$("#tablecust").hide();
			$("#tablelang").hide();
			$("#tablethblrek").hide();
		}
	});

	$("#tgl_filter").datepicker({
		autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
	}).on("change", function() {
		$('#tablefilterpiutang tbody').empty();
		$('#tablefilterpiutang').DataTable().clear().draw();
	});


	$("#tablerekterbit").show();
	$("#tablerekterbitgol").hide();
	$("#tablerekterbitcust").hide();

	$("#filter").on("change", function(){
		var v = $(this).val();
		if(v == "AREA"){
			$("#tablerekterbit").show();
			$("#tablerekterbitgol").hide();
			$("#tablerekterbitthblrek").hide();
			$("#filterthblrek").hide();
			$("#filtergol").hide();
			$("#filterarea").show();
		}else if(v == "GOLONGAN"){
			$("#tablerekterbit").hide();
			$("#tablerekterbitgol").show();
			$("#tablerekterbitthblrek").hide();
			$("#filterthblrek").hide();
			$("#filtergol").show();
			$("#filterarea").hide();
		}else{
			$("#tablerekterbit").hide();
			$("#tablerekterbitgol").hide();
			$("#tablerekterbitthblrek").show();
			$("#filterthblrek").show();
			$("#filtergol").hide();
			$("#filterarea").hide();
		}
	});
});

function cetakdaftar(x){
	if(x=='excelon'){
		hreF	= "<?php echo site_url("Laporan/rpt_rekaplunasonlineexcel")?>";
		window.open(hreF, '_blank');
	}else if(x=='excelondet'){
		var thbllunon = $("#filterthbllunason").val();
		hreF	= "<?php echo site_url("Laporan/rpt_rekaplunasonlinedetilexcel")?>"+"/"+thbllunon;
		window.open(hreF, '_blank');
	}else if(x=='exceloffdet'){
		var thbllunoff = $("#filterthbllunasoff").val();
		hreF	= "<?php echo site_url("Laporan/rpt_rekaplunasofflinedetilexcel")?>"+"/"+thbllunoff;;
		window.open(hreF, '_blank');
	}else if(x=='exceloff'){
		hreF	= "<?php echo site_url("Laporan/rpt_rekaplunasofflineexcel")?>";
		window.open(hreF, '_blank');
	}else if(x=='detpelunasanbpujl'){
		hreF	= "<?php echo site_url("Laporan/rpt_detpelunasanbpujlexcel")?>";
		window.open(hreF, '_blank');
	}else if(x=='detpelunasanps'){
		hreF	= "<?php echo site_url("Laporan/rpt_detpelunasanpsexcel")?>";
		window.open(hreF, '_blank');
	}else if(x=='angsuran'){
		hreF	= "<?php echo site_url("Laporan/rpt_angsuranexcel")?>";
		window.open(hreF, '_blank');
	}else if(x=='piutangpertanggal'){
		var filter = document.getElementById("tgl_filter").value;
		hreF	= "<?php echo site_url("Laporan/rpt_piutangpertanggal")?>"+"/"+filter;
		window.open(hreF, '_blank');
	}else{
		return false;
	}
}

function caribylang(){
		var carix   = document.getElementById("caribylang").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caripelunasaninfo/'+carix;
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
				});
				loaddatabylang(ck);
				if(ck==''){
					$('[name="caribylang"]').parent().parent().parent().parent().addClass('has-error');
					$('[name="caribylang"]').attr('value','');
					$('[name="caribylang"]').attr('placeholder','Data tidak ada');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Selamat Pagi");
			}
		});
}

function loaddatabylang(ID_LANG){
	tablebylang = $('#tablebylang').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/lunasbylang_list')?>",
			"type": "POST",
			data: function(d) {
				d.id_lang = ID_LANG
			}
		},
		"columnDefs": [
		{
			"className": "text-right",
			"targets": [2,3,4],
		},
		],

	});
}

function cetakbylang(ID,THBLREK){
	hreF	= "<?php echo site_url("billing/invoice_thblrek")?>";
	ReQuest	= "/1/" +ID+"/"+THBLREK;
	window.open(hreF+ReQuest, '_blank');
}

//Rekap Piutang Filter
function filterpiutang(){
	$('#tablefilterpiutang tbody').empty();
	var tgl_filter   = document.getElementById("tgl_filter").value;
	tablefilterpiutang = $('#tablefilterpiutang').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/caripiutang')?>",
			"type": "POST",
			data: function(d) {
				d.tgl_filter = tgl_filter
			}
		},
		"columnDefs": [
		{
			"className": "text-left",
			"targets": [3,4],
		},
		{
			"className": "text-center",
			"targets": [-1],
		},
		],
	});
}

function cetakgolexcel(THBLREK,KOGOL){
	hreF	= "<?php echo site_url("Laporan/rpt_detgolexcel")?>"+"/"+THBLREK+"/"+KOGOL;
	window.open(hreF, '_blank');
}

function cetakareaexcel(THBLREK,KDAREA){
	hreF	= "<?php echo site_url("Laporan/rpt_detareaexcel")?>"+"/"+THBLREK+"/"+KDAREA;
	window.open(hreF, '_blank');
}

function filterterbitthblrek(){
	$('#tablerekaphitung tbody').empty();
	var tablerekterbitthblrek   = document.getElementById("filterterbitthblrek").value;
	tablerekterbitthblrek = $('#tablerekterbitthblrek').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/rekterbitthblrekfilter_list')?>",
			"type": "POST",
			data: function(d) {
				d.tablerekterbitthblrek = tablerekterbitthblrek
			}
		},
		"columnDefs": [
		{
			"className": "text-right",
			"targets": [2,3,4],
		},
		{
			"className": "text-center",
			"targets": [-1],
		},
		],
	});
}

function filterterbitarea(){
	$('#tablerekterbit tbody').empty();
	var tablerekterbit   = document.getElementById("filterterbitarea").value;
	tablerekterbit = $('#tablerekterbit').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/rekaphitung_list')?>",
			"type": "POST",
			data: function(d) {
				d.tablerekterbit = tablerekterbit
			}
		},
		"columnDefs": [
		{
			"className": "text-right",
			"targets": [2,3,4],
		},
		{
			"className": "text-center",
			"targets": [-1],
		},
		],
	});
}

function filterterbitgol(){
	$('#tablerekterbitgol tbody').empty();
	var tablerekterbitgol   = document.getElementById("filterterbitgol").value;
	tablerekterbitgol = $('#tablerekterbitgol').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/rekterbitgol_list')?>",
			"type": "POST",
			data: function(d) {
				d.tablerekterbitgol = tablerekterbitgol
			}
		},
		"columnDefs": [
		{
			"className": "text-right",
			"targets": [2,3,4],
		},
		{
			"className": "text-center",
			"targets": [-1],
		},
		],
	});
}

function cek_jmllang(KD_AREA){
	$("#popupsaldopiutang").modal("show");
	$('#popupsaldopiutang').modal({backdrop: 'static'}); 
	tabledetsaldopiutang = $('#tabledetsaldopiutang').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"bInfo" : false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('informasi/detsaldopiutang_list/')?>",
			"type": "POST",
			data: function(d) {
				d.KD_AREA = KD_AREA
			}
		},
		"columnDefs": [
		{  
			"className": "text-right",
			"targets": [-1],
			"orderable": false,
		},
		],

	});
}

function cek_jmllembar(KD_AREA){
	$("#popupsaldopiutang2").modal("show");
	$('#popupsaldopiutang2').modal({backdrop: 'static'}); 
	tabledetsaldopiutang2 = $('#tabledetsaldopiutang2').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"bInfo" : false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('informasi/detsaldopiutang2_list/')?>",
			"type": "POST",
			data: function(d) {
				d.KD_AREA = KD_AREA
			}
		},
		"columnDefs": [
		{  
			"className": "text-right",
			"targets": [-1],
			"orderable": false,
		},
		],

	});
}
</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Monitoring Keuangan <small>Keuangan</small></h1>
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
								<i class="fa fa-gift"></i>Monitoring Keuangan
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_3" data-toggle="tab">
									Rekap Rekening Terbit </a>
								</li>
								<li >
									<a href="#tab_1_1" data-toggle="tab">
									Rekap Pelunasan Rekening Online </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Rekap Pelunasan Rekening Offline </a>
								</li>
								<li>
									<a href="#tab_1_12" data-toggle="tab">
									Rekap Pelunasan Rekening</a>
								</li>
								<li>
									<a href="#tab_1_4" data-toggle="tab">
									Rekap Pelunasan BP & UJL </a>
								</li>
								<li>
									<a href="#tab_1_5" data-toggle="tab">
									Detail Pelunasan BP & UJL </a>
								</li>
								<li>
									<a href="#tab_1_6" data-toggle="tab">
									Rekap Saldo Piutang </a>
								</li>
								<li>
									<a href="#tab_1_7" data-toggle="tab">
									Rekap Pelunasan PS</a>
								</li>
								<li>
									<a href="#tab_1_8" data-toggle="tab">
									Detail Pelunasan PS</a>
								</li>
								<li>
									<a href="#tab_1_9" data-toggle="tab">
									Rekap Angsuran Tagihan</a>
								</li>
								<li>
									<a href="#tab_1_10" data-toggle="tab">
									Informasi Tagihan</a>
								</li>
								<li>
									<a href="#tab_1_11" data-toggle="tab">
									Saldo Piutang Per Tanggal</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade" id="tab_1_1">
									<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tableonline">
											<thead>
												<tr>
													<th>
														 THBL LUNAS
													</th>
													<th>
														 TANGGAL LUNAS
													</th>
													<th>
														 JML PELANGGAN
													</th>
													<th>
														 JML LANGGANAN
													</th>
													<th>
														 JML LEMBAR
													</th>
													<th>
														 JML PTL
													</th>
													<th>
														 JML ANGSURAN
													</th>
													<th>
														 JML RP EPI
													</th>
													<th>
														 JML BPJU
													</th>
													<th>
														 JML MAT
													</th>
													<th>
														 JML TAG
													</th>
													<th>
														 JML BK
													</th>
													<th>
														 TOTAL INVOICE
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
													<a type="button" class="btn green" onclick="cetakdaftar('excelon')">Cetak Daftar EXCEL</a>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										&nbsp;
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										Filter Cetakan Detail :
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										<?php
											$atribut_filterthbllunas = 'id="filterthbllunason" class="form-control select2me"';
											echo form_dropdown('filterthbllunas', $filterthbllunas, '', $atribut_filterthbllunas);
										?>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakdaftar('excelondet')">Cetak Detil EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="table-scrollable">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tableoffline">
											<thead>
												<tr>
													<th>
														 THBL LUNAS
													</th>
													<th>
														 TANGGAL LUNAS
													</th>
													<th>
														 JML PELANGGAN
													</th>
													<th>
														 JML LANGGANAN
													</th>
													<th>
														 JML LEMBAR
													</th>
													<th>
														 JML PTL
													</th>
													<th>
														 JML ANGSURAN
													</th>
													<th>
														 JML RP EPI
													</th>
													<th>
														 JML BPJU
													</th>
													<th>
														 JML MAT
													</th>
													<th>
														 JML TAG
													</th>
													<th>
														 JML BK
													</th>
													<th>
														 TOTAL INVOICE
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
										</table>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakdaftar('exceloff')">Cetak Rekap EXCEL</a>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										&nbsp;
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										Filter Cetakan Detail :
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-2">
										<?php
											$atribut_filterthbllunas = 'id="filterthbllunasoff" class="form-control select2me"';
											echo form_dropdown('filterthbllunas', $filterthbllunas, '', $atribut_filterthbllunas);
										?>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakdaftar('exceloffdet')">Cetak Detil EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade active in" id="tab_1_3">
									<div class="form-group">
										<div class="col-md-2">
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label align-right col-md-3">Pilih Filter</label>
												<select id="filter" name="filter" class="form-control select2me" data-placeholder="Select..." style="width:50%; align-right;">
													<option value=" ">-- Pilih --</option>
													<option value="AREA" selected>AREA</option>
													<option value="GOLONGAN">GOLONGAN</option>
													<option value="THBLREK">THBLREK</option>
												</select>
											</div>
										</div>
										<div class="col-md-4 " id="filterarea">
											<div class="form-group">
												<div class="col-md-6 input-group">
													<input id="filterterbitarea" name="filterterbitarea" class="form-control" type="text" placeholder="201803" style="align-left"/>
													<span class="input-group-btn">
														<a type="button" onclick="filterterbitarea()" class="btn blue">Filter </a>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 " id="filtergol">
											<div class="form-group">
												<div class="col-md-6 input-group">
													<input id="filterterbitgol" name="filterterbitgol" class="form-control" type="text" placeholder="201803" style="align-left"/>
													<span class="input-group-btn">
														<a type="button" onclick="filterterbitgol()" class="btn blue">Filter </a>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-4 " id="filterthblrek">
											<div class="form-group">
												<div class="col-md-6 input-group">
													<input id="filterterbitthblrek" name="filterterbitthblrek" class="form-control" type="text" placeholder="2018" style="align-left"/>
													<span class="input-group-btn">
														<a type="button" onclick="filterterbitthblrek()" class="btn blue">Filter </a>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-2">
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">&nbsp;</label>
											<div class="col-md-6">
												<input type="hidden" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
									<div class="table-scrollable">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tablerekterbit">
										<thead>
											<tr>
												<th>
													 AKSI
												</th>
												<th>
													 THBLREK
												</th>
												<th>
													 AREA
												</th>
												<th>
													 LANGGANAN
												</th>
												<th>
													 DAYA
												</th>
												<th>
													 KWH
												</th>
												<th>
													 KLB KVARH
												</th>
												<th>
													 PTL
												</th>
												<th>
													 BPJU
												</th>
												<th>
													 ANGSURAN
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablerekterbitgol">
										<thead>
											<tr>
												<th>
													 AKSI
												</th>
												<th>
													 THBLREK
												</th>
												<th>
													 GOLONGAN
												</th>
												<th>
													 LANGGANAN
												</th>
												<th>
													 DAYA
												</th>
												<th>
													 KWH
												</th>
												<th>
													 KLB KVARH
												</th>
												<th>
													 PTL
												</th>
												<th>
													 BPJU
												</th>
												<th>
													 ANGSURAN
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablerekterbitthblrek">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 CUSTOMER
												</th>
												<th>
													 LANGGANAN
												</th>
												<th>
													 DAYA
												</th>
												<th>
													 KWH
												</th>
												<th>
													 KLB KVARH
												</th>
												<th>
													 PTL
												</th>
												<th>
													 BPJU
												</th>
												<th>
													 ANGSURAN
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablerekterbitcust">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 GOLONGAN
												</th>
												<th>
													 LANGGANAN
												</th>
												<th>
													 DAYA
												</th>
												<th>
													 KWH
												</th>
												<th>
													 KLB KVARH
												</th>
												<th>
													 PTL
												</th>
												<th>
													 BPJU
												</th>
												<th>
													 ANGSURAN
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_4">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekapnontaglis">
										<thead>
											<tr>
												<th>
													 THBL LUNAS
												</th>
												<th>
													 JENIS TRANSAKSI
												</th>
												<th>
													 JML PERMOHONAN
												</th>
												<th>
													 BP
												</th>
												<th>
													 UJL
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TOTAL
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
								</div>
								<div class="tab-pane fade" id="tab_1_5">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetbpujl">
										<thead>
											<tr>
												<th>
													 NO AGENDA
												</th>
												<th>
													 JENIS TRANSAKSI
												</th>
												<th>
													 NAMA LANGGANAN
												</th>
												<th>
													 RP BP
												</th>
												<th>
													 RP UJL
												</th>
												<th>
													 RP MATERAI
												</th>
												<th>
													 TOTAL BIAYA
												</th>
												<th>
													 TANGGAL BAYAR
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
													<a type="button" class="btn green" onclick="cetakdaftar('detpelunasanbpujl')">Cetak Detail EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_6">
									<div class="form-group">
										<label class="control-label align-right col-md-3">Pilih Filter</label>
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
												<i class="fa fa-user"></i>
												</span>
												<select id="filtersaldo" name="filtersaldo" class="form-control select2me" data-placeholder="Select..." style="width:100%;">
													<option value=" ">-- Pilih --</option>
													<option value="AREA" selected>AREA</option>
													<option value="GOLONGAN">GOLONGAN</option>
													<option value="CUST">CUSTOMER</option>
													<option value="LANG">LANGGANAN</option>
													<option value="THBLREK">THBLREK</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">&nbsp;</label>
											<div class="col-md-6">
												<input type="hidden" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
									<div class="table-scrollable">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tablearea">
										<thead>
											<tr>
												<th>
													 AREA
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablegol">
										<thead>
											<tr>
												<th>
													 GOLONGAN
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablecust">
										<thead>
											<tr>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 NAMA CUSTOMER
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablethblrek">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablelang">
										<thead>
											<tr>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 ID LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="tab_1_7">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekapnontaglisps">
										<thead>
											<tr>
												<th>
													 THBL LUNAS
												</th>
												<th>
													 JENIS TRANSAKSI
												</th>
												<th>
													 JML PERMOHONAN
												</th>
												<th>
													 BIAYA KWH
												</th>
												<th>
													 BIAYA MATERIAL
												</th>
												<th>
													 BPJU
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TOTAL
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
								</div>
								<div class="tab-pane fade" id="tab_1_8">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tabledetnontaglisps">
										<thead>
											<tr>
												<th>
													 NO AGENDA
												</th>
												<th>
													 JNS TRANSAKSI
												</th>
												<th>
													 NAMA
												</th>
												<th>
													 BIAYA KWH
												</th>
												<th>
													 BIAYA MATERIAL
												</th>
												<th>
													 BIAYA BPJU
												</th>
												<th>
													 MATERAI
												</th>
												<th>
													 TOTAL
												</th>
												<th>
													 POLA BAYAR
												</th>
												<th>
													 TGL LUNAS
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
													<a type="button" class="btn green" onclick="cetakdaftar('detpelunasanps')">Cetak Detail EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_9">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tableangsuran">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 ID CUST
												</th>
												<th>
													 ID LANGGANAN
												</th>
												<th>
													 JUMLAH MOHON
												</th>
												<th>
													 RP BP
												</th>
												<th>
													 RP UJL
												</th>
												<th>
													 RP BK
												</th>
												<th>
													 RP KWH
												</th>
												<th>
													 RP P2TL
												</th>
												<th>
													 RP INVESTASI
												</th>
												<th>
													 RP MATERAI
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
													<a type="button" class="btn green" onclick="cetakdaftar('angsuran')">Cetak Detail EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_10">
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="col-md-5 control-label">Cari ID Langganan</label>
											<div class="input-group">
												<input id="caribylang" name="caribylang" class="form-control" />
												<span class="input-group-btn">
													<a type="button" onclick="caribylang()" class="btn green">Cari </a>
												</span>

											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
											<div class="table-scrollable">
												<table class="table table-striped table-bordered table-hover" id="tablebylang">
													<thead>
														<tr>
															<th>
																 AKSI
															</th>
															<th>
																 THBLREK
															</th>
															<th>
																 ID LANGGANAN
															</th>
															<th>
																 NAMA LANGGANAN
															</th>
															<th>
																 RP TAGIH
															</th>
															<th>
																 RP BK
															</th>
															<th>
																 TOTAL INVOICE
															</th>
															<th>
																 TANGGAL LUNAS
															</th>
															<th>
																 STATUS
															</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>

								</div>
								<div class="tab-pane fade" id="tab_1_11">
									<div class="col-md-12 ">
										<div class="form-group">
											<label class="col-md-2 control-label align-right">&nbsp;</label>
											<div class="col-md-6">
												<input placeholder="yyyy-mm-dd" class="form-control datepicker" type="hidden">
											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="form-group">
											<label class="col-md-4 control-label align-left">Tanggal (Jam 00.00 WIB)</label>
											<div class="col-md-4 input-group">
												<input id="tgl_filter" name="tgl_filter" class="form-control datepicker" type="text" />
												<span class="input-group-btn">
													<a type="button" onclick="filterpiutang()" class="btn blue">Filter </a>
												</span>
											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="form-group">
											<label class="col-md-2 control-label align-right">&nbsp;</label>
											<div class="col-md-6">
												<input placeholder="yyyy-mm-dd" class="form-control datepicker" type="hidden">
											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
											<div class="table-scrollable">
												<table class="table table-striped table-bordered table-hover" id="tablefilterpiutang">
													<thead>
														<tr>
															<th>
																 THBLREK
															</th>
															<th>
																 ID LANGGANAN
															</th>
															<th>
																 NAMA LANGGANAN
															</th>
															<th>
																 ALAMAT LANGGANAN
															</th>
															<th>
																 RP TAG
															</th>
															<th>
																 RP BK
															</th>
															<th>
																 TOTAL INVOICE
															</th>
															<th>
																 STATUS LUNAS
															</th>
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
											</div>
											</div>
										</div>
									</div>
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn blue" onclick="cetakdaftar('piutangpertanggal')">Export to Excel</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_12">
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekaplunas">
										<thead>
											<tr>
												<th>
													 THBL LUNAS
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 RP EPI
												</th>
												<th>
													 RP BPJU
												</th>
												<th>
													 RP MATERAI
												</th>
												<th>
													 RP TAGIHAN
												</th>
												<th>
													 RP BK
												</th>
												<th>
													 RP INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
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
			
			<div id="popupsaldopiutang" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true" data-toggle="modal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">List Daftar Langganan</h4>
						</div>
						<div class="modal-body">
							<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
								<div class="row">
									<div class="col-md-12">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tabledetsaldopiutang">
										<thead>
											<tr >
												<th class="text-center">
													 KODE AREA
												</th>
												<th class="text-center">
													 ID LANGGANAN
												</th>
												<th class="text-center">
													 NAMA LANGGANAN
												</th>
												<th class="text-center">
													 JUMLAH LEMBAR
												</th>
												<th class="text-center">
													 RUPIAH EPI
												</th>
												<th class="text-center">
													RUPIAH BPJU
												</th>
												<th class="text-center">
													RUPIAH MATERAI
												</th>
												<th class="text-center">
													RUPIAH TAGIHAN
												</th>
												<th class="text-center">
													RUPIAH BK
												</th>
												<th class="text-center">
													TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" data-dismiss="modal" class="btn default">Close</button>
						</div>
					</div>
				</div>
			</div>
			<div id="popupsaldopiutang2" class="modal fade bs-modal-lg" tabindex="-1" aria-hidden="true" data-toggle="modal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">List Daftar Langganan</h4>
						</div>
						<div class="modal-body">
							<div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
								<div class="row">
									<div class="col-md-12">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tabledetsaldopiutang2">
										<thead>
											<tr >
												<th class="text-center">
													 KODE AREA
												</th>
												<th class="text-center">
													 THBLREK
												</th>
												<th class="text-center">
													 ID LANGGANAN
												</th>
												<th class="text-center">
													 NAMA LANGGANAN
												</th>
												<th class="text-center">
													 RUPIAH EPI
												</th>
												<th class="text-center">
													RUPIAH BPJU
												</th>
												<th class="text-center">
													RUPIAH MATERAI
												</th>
												<th class="text-center">
													RUPIAH TAGIHAN
												</th>
												<th class="text-center">
													RUPIAH BK
												</th>
												<th class="text-center">
													TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" data-dismiss="modal" class="btn default">Close</button>
						</div>
					</div>
				</div>
			</div>
			
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
<script src="../../assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
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

	tablerekterbit = $('#tablerekterbit').DataTable({
		destroy: true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/rekaphitung_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8,9,10]
        },
        ],
    });

	tablerekterbitgol = $('#tablerekterbitgol').DataTable({
		destroy: true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/rekterbitgol_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8,9,10]
        },
        ],
    });
	
	tablerekterbitthblrek = $('#tablerekterbitthblrek').DataTable({
		destroy: true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/rekterbitthblrekfilter_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8,9,10]
        },
        ],
    });


	tableonline = $('#tableonline').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tableonline_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [2,3,4,5,6,7,8,9,10,11,12]
        },
        ],
    });

    tableoffline = $('#tableoffline').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tableoffline_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [2,3,4,5,6,7,8,9,10,11,12]
        },
        ],
    });

    /*Itablepiutang = $('#tablepiutang').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tablepiutang_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [1,2,3,4,5,6,7,8,9]
        },
        ],
    });*/

	tabledetbpujl = $('#tabledetbpujl').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tabledetbpujl_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6]
        },
		{ 	"width": "10px", "targets": 0 },
        ],
    });

    tablerekapnontaglis = $('#tablerekapnontaglis').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tablerekapnontaglis_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [2,3,4,5,6]
        },
        ],
    });

    tablerekapnontaglisps = $('#tablerekapnontaglisps').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tablerekapnontaglisps_list')?>",
            "type": "POST"
        },
        "columnDefs": [
			{ "className": "text-right","targets": [2,3,4,5,6] },
			{ "orderable": false, "targets": [1,2,3,4,5,6,7,8] }
        ],
    });

    tabledetnontaglisps = $('#tabledetnontaglisps').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tabledetnontaglisps_list')?>",
            "type": "POST"
        },
        "columnDefs": [
			{ "className": "text-right", "targets": [3,4,5,6] },
			{ "orderable": false, "targets": [1,2,3,4,5,6,7,8,9] }
        ],
    });

	tableangsuran = $('#tableangsuran').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('keuangan/tableangsuran_list')?>",
            "type": "POST"
        },
        "columnDefs": [
			{   "className": "text-right","targets": [4,5,6,7,8,9,10] },
			{   "className": "text-center","targets": [3] },
			{ 	"width": "10px", "targets": 2 },
			{   "orderable": false, "targets" : [2,3,4,5,6,7,8,9,10] }
        ],
    });

	tablearea = $('#tablearea').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldoarea_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false, "className": "text-right", "targets": [4,5,6,7,8,9],
            "orderable": false, "className": "text-center", "targets": [0,1,2,3],
        },
        ],
    });
	
	tablegol = $('#tablegol').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldogol_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });

	tablecust = $('#tablecust').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldocust_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [2,3,4,5,6,7]
        },
        ],
    });

	tablelang = $('#tablelang').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldolang_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8]
        },
        ],
    });

	tablethblrek = $('#tablethblrek').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldothblrek_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });

		tablerekaplunas = $('#tablerekaplunas').DataTable({
			destroy: true,
	        "processing": true,
	        "serverSide": true,
	        "order": [],
	        "ajax": {
	            "url": "<?php echo site_url('keuangan/rekaplunas_list')?>",
	            "type": "POST"
	        },
	        "columnDefs": [
	        {
	            "orderable": false,
				"className": "text-right",
	            "targets": [4,5,6,7,8,9]
	        },
	        ],
	    });

});



</script>
</body>
</html>
