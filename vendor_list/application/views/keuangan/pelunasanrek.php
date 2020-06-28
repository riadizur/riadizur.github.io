<script>
$(document).ready(function() {
	$("#satu").show();
	$("#dua").hide();
	$("#tiga").hide();	
	document.getElementById("valid").innerHTML = " ";
	document.getElementById("sukseslang").innerHTML = " ";
	document.getElementById("sukses").innerHTML = " ";
});

//Fungsi By Langganan
function caribylang(){
		var carix   = document.getElementById("caribylang").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caripelunasanrek/'+carix;
		$('#btnSavebylang').attr('disabled',false);
		document.getElementById("valid").innerHTML = " ";
		document.getElementById("sukseslang").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.THBLREK;
					if(ck == '' || ck == null){
						$('[name="caribylang"]').parent().parent().parent().parent().addClass('has-error'); 
						$('[name="caribylang"]').attr('value',''); 
						$('[name="caribylang"]').attr('placeholder','Data tidak ada');
						$("input[type=text], textarea").val("");
					}else{
						$("#id_lang").val(obj.ID_LANG);
						$("#nama_lang").val(obj.NAMA_LANG);
						$("#alamat_lang").val(obj.ALAMAT_LANG);
						$("#daya_baru").val(number_format(obj.DAYA));
						$("#tarif_baru").val(obj.TARIF);
						$("#rincian_bulan").val(obj.THBLREK);
						$("#jml_bulan").val(obj.BRPBULAN);
						$("#total_biaya").val(number_format(obj.TOTAL));						
						
						var cekno = obj.STATUS_LUNAS;
						if(cekno == '0' || cekno == null){
							otokwitansi(obj.KD_AREA);
						}else{
							$("#no_kwitansi").val(obj.NO_KWITANSI);
							$('#btnPrint').attr('disabled',true);
							$('#btnSave').attr('disabled',true);
							document.getElementById("valid").innerHTML = "PELANGGAN SUDAH LUNAS KUITANSI HANYA DAPAT DI CETAK SATU KALI ";
						}
					}
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});		
}

function cetakbylang(id_lang,tgl_lunas){

	if(id_lang == ''){
		alert("ID LANG NOT IDENTIFICATION");
		return false;
	}
	hreF	= "<?php echo site_url("Laporan/rpt_kwitansirek")?>";
	ReQuest	= "/" + '1' + "/" +id_lang+"/"+tgl_lunas+"/KUITANSI_"+id_lang+"_"+tgl_lunas;
	window.open(hreF+ReQuest, '_blank');
}

function otokwitansi(area){
	var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/otokwitansi/';
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					var X 		 = Math.floor((Math.random() * 10) + 1);
					var nk		 = obj.NOKWIT;
					var kwitansi = 'KEU-'+area+'-'+X+'-'+nk;
					$("#no_kwitansi").val(kwitansi);
				});
			}
		});
}

//Fungsi Pilih By Customer
function caribycustselect(){
		var carix   = document.getElementById("caribycustselect").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caripelunasanrekbycust/'+carix;
		$('#btnSavebycustselect').attr('disabled',false);
		document.getElementById("valid").innerHTML = " ";
		document.getElementById("sukses").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_CUST;
					$("#id_custselect").val(obj.ID_CUST);
					$("#nama_custselect").val(obj.NAMA_CUST);
				});
				loaddatabycustselect(ck);
				sumselect(ck);
				if(ck==''){
					$('[name="caribycustselect"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="caribycustselect"]').attr('value','');
					$('[name="caribycustselect"]').attr('placeholder','Data tidak ada');
					$("input[type=text], textarea").val("");
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
}

function loaddatabycustselect(ID_CUST){
	tablebycustselect = $('#tablebycustselect').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/lunasbycustselect_list')?>",
			"type": "POST",
			data: function(d) {
				d.id_cust = ID_CUST
			}
		},
		"columnDefs": [
		{  
			"className": "text-right",
			"targets": [2,3,4],
		},
		],

	});

	$('#tablebycustselect tbody').on('click', 'input[type="checkbox"]', function(e){	
		var check = $('input[name="pilihan[]"]:checked').length;
		var mycheckboxes = new Array();
		$('input[name="pilihan[]"]:checked').each(function(){
			mycheckboxes.push(this.value);
		});
		doted = mycheckboxes;
		return doted;
	});
}

function sumselect(ID_CUST){
	var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/suminvoice/'+ID_CUST;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {					
					$("#totinvoiceselect").val(obj.TOTAL_INVOICE);
					$("#totlembarselect").val(obj.TOTAL_LEMBAR);
				});
			}
		});
}

//Fungsi Cetak Kwitansi By Lang
function caribylangselect(){
		var carix   = document.getElementById("caribylangselect").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/carikwitansibylang/'+carix;
		document.getElementById("valid").innerHTML = " ";
		document.getElementById("sukses").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
					$("#id_langselect").val(obj.ID_LANG);
					$("#nama_langselect").val(obj.NAMA_LANG);
				});
				loaddatabylangselect(ck);
				if(ck==''){
					$('[name="caribylangselect"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="caribylangselect"]').attr('value','');
					$('[name="caribylangselect"]').attr('placeholder','Data tidak ada');
					$("input[type=text], textarea").val("");
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
}

function loaddatabylangselect(ID_LANG){
	tablebylangselect = $('#tablebylangselect').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kwitansibylangselect_list')?>",
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

	$('#tablebylangselect tbody').on('click', 'input[type="checkbox"]', function(e){	
		var check = $('input[name="pilihan[]"]:checked').length;
		var mycheckboxes = new Array();
		$('input[name="pilihan[]"]:checked').each(function(){
			mycheckboxes.push(this.value);
		});
		doted = mycheckboxes;
		return doted;
	});
}


</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Pelunasan Rekening <small>Keuangan</small></h1>
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
								<i class="fa fa-gift"></i>Pelunasan Rekening
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Pelunasan By ID Langganan </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Pelunasan Pilih By ID Customer </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab">
									Cetak Kwitansi </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
								
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
									<div> <p id="valid" style="color: red;"> <p id="sukseslang" style="color: red;"> </p> </div>
	<form action="#" id="form1" class="form-horizontal" role="form1">
									<div class="row ">
										<div class="col-md-12">
											<div class="portlet light">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-globe"></i>
														<span class="caption-subject font-green-sharp bold">Informasi</span>
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">No Kwitansi</label>
																	<div class="col-md-6">
																		<input type="text" id="no_kwitansi" name="no_kwitansi" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">ID Langganan</label>
																	<div class="col-md-6">
																		<input type="text" id="id_lang" name="id_lang" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Nama Langganan</label>
																	<div class="col-md-6">
																		<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Alamat Langganan</label>
																	<div class="col-md-6">
																		<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Tarif</label>
																	<div class="col-md-6">
																		<input type="text" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left">Daya</label>
																	<div class="col-md-6">
																		<input type="text" id="daya_baru" name="daya_baru" class="form-control input-sm" placeholder=" " readonly>
																	</div>
																</div>
															</div>
															<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-6 control-label align-left">Jumlah Bulan</label>
																<div class="col-md-6">
																	<input type="text" id="jml_bulan" name="jml_bulan" class="form-control input-sm" placeholder=" " readonly>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-6 control-label align-left">Keterangan Bulan</label>
																<div class="col-md-6">
																	<input type="text" id="rincian_bulan" name="rincian_bulan" class="form-control input-sm" placeholder=" " readonly>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-6 control-label align-left">Total Biaya</label>
																<div class="col-md-6">
																	<input type="text" id="total_biaya" name="total_biaya" class="form-control input-sm" placeholder=" " readonly>
																</div>
															</div>
															<div class="form-group">
																<div class="col-md-6">
																	&nbsp;
																</div>
															</div>
															<div class="form-group">
																<a type="button" name="btnSavebylang" id="btnSavebylang" onclick="savebylang()" class="btn green "> Proses Pembayaran </a>
															</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
	</form>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="col-md-5 control-label">Cari ID Customer</label>
											<div class="input-group">
												<input id="caribycustselect" name="caribycustselect" class="form-control" />
												<span class="input-group-btn">
													<a type="button" onclick="caribycustselect()" class="btn green">Cari </a>
												</span>
												
											</div>
										</div>
									</div>
									<div> <p id="valid" style="color: red;"> <p id="sukses" style="color: red;"> </p> </div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
	<form action="#" id="form2" class="form-horizontal" role="form2">
													<div class="row">
														<div class="form-body">
															<div class="col-md-12">		
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" style="padding-left:250px;">ID. Customer</label>
																	<div class="col-md-4">
																		<input type="text" id="id_custselect" name="id_custselect" class="form-control input-sm"  placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" style="padding-left:250px;">Nama Customer</label>
																	<div class="col-md-4">
																		<input type="text" id="nama_custselect" name="nama_custselect" class="form-control input-sm"  placeholder=" " readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
												<div class="table-scrollable">
												<table class="table table-striped table-bordered table-hover" id="tablebycustselect">
													<thead>
														<tr>
															<th>
																 Pilih
															</th>
															<th>
																 THBLREK
															</th>
															<th>
																 JUMLAH LEMBAR
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
														</tr>
													</thead>
													<tbody>
													</tbody>
												</table>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-12" hidden>
										<div class="panel panel-success">
											<div class="panel-body">
												<div class="form-body form-horizontal">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label align-left" style="padding-left:50px;">Total Lembar</label>
															<div class="col-md-4">
																<input type="text" id="totlembarselect" name="totlembarselect" class="form-control input-sm"  placeholder=" " readonly>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-3 control-label align-left" style="padding-left:50px;">Total Invoice</label>
															<div class="col-md-4">
																<input type="text" id="totinvoiceselect" name="totinvoiceselect" class="form-control input-sm"  placeholder=" " readonly>
															</div>
														</div>
													</div>
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
															<a type="button" name="btnSavebycustselect" id="btnSavebycustselect" onclick="savebycustselect()" class="btn green">Proses Sekarang </a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
	</form>
								</div>
								<div class="tab-pane fade" id="tab_1_3">
									<div class="col-md-6 ">
										<div class="form-group">
											<label class="col-md-5 control-label">Cari ID Langganan</label>
											<div class="input-group">
												<input id="caribylangselect" name="caribylangselect" class="form-control" />
												<span class="input-group-btn">
													<a type="button" onclick="caribylangselect()" class="btn green">Cari </a>
												</span>
												
											</div>
										</div>
									</div>
									<div> <p id="valid" style="color: red;"> <p id="sukses" style="color: red;"> </p> </div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
	<form action="#" id="form3" class="form-horizontal" role="form3">
													<div class="row">
														<div class="form-body">
															<div class="col-md-12">		
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" style="padding-left:250px;">ID. Langganan</label>
																	<div class="col-md-4">
																		<input type="text" id="id_langselect" name="id_langselect" class="form-control input-sm"  placeholder=" " readonly>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-6 control-label align-left" style="padding-left:250px;">Nama Langganan</label>
																	<div class="col-md-4">
																		<input type="text" id="nama_langselect" name="nama_langselect" class="form-control input-sm"  placeholder=" " readonly>
																	</div>
																</div>
															</div>
														</div>
													</div>
											</div>
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="panel panel-success">
											<div class="panel-body">
												<div class="table-scrollable">
												<table class="table table-striped table-bordered table-hover" id="tablebylangselect">
													<thead>
														<tr>
															<th>
																 Pilih
															</th>
															<th>
																 CUST
															</th>
															<th>
																 LANGGANAN
															</th>
															<th>
																 TANGGAL LUNAS
															</th>
															<th>
																 BERAPA BULAN
															</th>
															<th>
																 TOTAL RUPIAH
															</th>
															<th>
																 THBLREK
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
	</form>
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
	<!-- END CONTENT -->
	<style type="text/css">
		#small{
			position:fixed;
			top:0;
			left:0;
			z-index:9999;
			text-align:center;
			width:100%;
			height:100%;
			padding-top:300px;
			font:bold 20px Calibri,Arial,Sans-Serif;
			color:#000;
			display:none;
		}
			::selection{ background-color: #E13300; color: white; }
			::moz-selection{ background-color: #E13300; color: white; }
			::webkit-selection{ background-color: #E13300; color: white; }
	</style>
	<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<img src="<?php echo base_url();?>assets/img/loader.gif"/>
				<p id=""> Mohon Tunggu Sebentar</p>
			</div>
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


var save_method;

function savebylang(){
	var save_method = 'update';
    var url;
	document.getElementById("sukseslang").innerHTML = " ";
	$('#btnSavebylang').text('Sedang Memproses...'); 
    $('#btnSavebylang').attr('disabled',true);
	$('#small').modal({backdrop: 'static'});
	
    if(save_method == 'add') {
        url = "<?php echo site_url('keuangan/pelunasanrek_add')?>";
    } else {
        url = "<?php echo site_url('keuangan/pelunasanrek_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form1').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			setTimeout(function(){$('#small').modal('hide')},1000);
			$('#btnSavebylang').text('Proses Pelunasan'); 
			$('#btnSavebylang').attr('disabled',false);
			document.getElementById("sukseslang").innerHTML = "Proses Pelunasan Berhasil!!";
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#small').modal('hide')},1000);
			$('#btnSavebylang').text('Proses Pelunasan'); 
			$('#btnSavebylang').attr('disabled',false);
			document.getElementById("sukseslang").innerHTML = "Proses Pelunasan GAGAL !!";
        }
    });
	$("input[type=text], textarea").val("");
}

function savebycustselect(){
	var save_method = 'update';
    var url;
	document.getElementById("sukses").innerHTML = " ";
	$('#btnSavebycustselect').text('Sedang Memproses...'); 
    $('#btnSavebycustselect').attr('disabled',true);
	$('#small').modal({backdrop: 'static'});
	
    if(save_method == 'add') {
        url = "<?php echo site_url('keuangan/pelunasanrekbycust_add')?>";
    } else {
        url = "<?php echo site_url('keuangan/pelunasanrekbycustselect_update')?>";
    }

	for(var i=0;i<doted.length;i++){
		$.ajax({
			url : url+"/"+doted[i],
			type: "POST",
			data: $('#form2').serialize(),
			dataType: "JSON",
			success: function(data)
			{
				setTimeout(function(){$('#small').modal('hide')},1000);
				$('#btnSavebycustselect').text('Proses Pelunasan'); 
				$('#btnSavebycustselect').attr('disabled',false);
				document.getElementById("sukses").innerHTML = "Proses Pelunasan Berhasil!!";
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				setTimeout(function(){$('#small').modal('hide')},1000);
				$('#btnSavebycustselect').text('Proses Pelunasan'); 
				$('#btnSavebycustselect').attr('disabled',false);
				document.getElementById("sukses").innerHTML = "Proses Pelunasan GAGAL !!";
			}
		});
	}
	$("input[type=text], textarea").val("");
	$('#tablebycustselect tbody').empty();
}

</script>
</body>
</html>