<script>
$(document).ready(function() {
	$('#btnPrintall').attr('disabled',true);
	$('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	
	$("#idlang_putus").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/get_detnamaputus/'+v;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});
	});
});
function prosesdata(){
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/get_kendaliproses/';
		document.getElementById("valid").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					loaddataa();
					loaddatab();
					loaddatac();
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
}

function loaddataa(){
	tablekendalisatu = $('#tablekendalisatu').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalisatu_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],
	});
	$('#btnPrintall').attr('disabled',false);
}

function loaddatab(){
	tablekendalidua = $('#tablekendalidua').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalidua_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],
	});
	
}

function loaddatac(){
	tablekendalitiga = $('#tablekendalitiga').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalitiga_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],

	});
}

function cetakputussementara(THBLREK,IDLANG,CEK){
	if(CEK=='perlang'){
		hreF	= "<?php echo site_url("Laporan/rpt_kendalikreditperlangsum")?>"+"/"+THBLREK+"/"+IDLANG;
		window.open(hreF, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_kendalikreditall")?>";
		window.open(hreF, '_blank');
	}
}


</script>	
			<div> <p id="valid" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Kendali Kredit <small>Keuangan</small></h1>
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
								<i class="fa fa-gift"></i>Cetakan
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									KENDALI KREDIT </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									INPUT REALISASI PEMUTUSAN </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									<div class="row ">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading">
													<div class="caption">
														<i class="fa fa-globe"></i>
														<span class="caption-subject font-green-sharp bold">PEMROSESAN DATA</span>
													</div>
												</div>
												<div class="panel-body">
													<div class="form-body form-horizontal">
														<div class="col-md-12">
															<div class="form-group">
																<div class="form-actions">
																	<center><a type="button" class="btn default btn-lg green" onclick="prosesdata()" >PROSES DATA</a></center>
																</div>
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
														<i class="fa fa-globe"></i>Data Pemutusan Sementara
														<a type="button" id="btnPrintall" onclick="cetakputussementara()" class="btn yellow "> Cetak Semua</a>
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<div class="table-scrollable">
															<div class="col-md-12">
																<table class="table table-striped table-bordered table-hover" id="tablekendalisatu">
																<thead>
																	<tr >
																		<th>
																			 AKSI
																		</th>
																		<th>
																			 ID LANGGANAN
																		</th>
																		<th>
																			 NAMA LANGGANAN
																		</th>
																		<th>
																			 PERIODE
																		</th>
																		<th>
																			 LEMBAR
																		</th>
																		<th>
																			 RP TAG
																		</th>
																		<th>
																			 RP BK
																		</th>
																		<th>
																			 TANGGAL CETAK
																		</th>
																		<th>
																			 TANGGAL PUTUS
																		</th>
																		<th>
																			 TANGGAL LUNAS
																		</th>
																		<th>
																			 TANGGAL SAMBUNG
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
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet light">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-globe"></i>Data Tagih Tunggakan
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<div class="table-scrollable">
															<div class="col-md-12">
																<table class="table table-striped table-bordered table-hover" id="tablekendalidua">
																<thead>
																	<tr >
																		<th>
																			 ID LANGGANAN
																		</th>
																		<th>
																			 NAMA LANGGANAN
																		</th>
																		<th>
																			 PERIODE
																		</th>
																		<th>
																			 LEMBAR
																		</th>
																		<th>
																			 RP TAG
																		</th>
																		<th>
																			 RP BK
																		</th>
																		<th>
																			 TANGGAL CETAK
																		</th>
																		<th>
																			 TANGGAL PUTUS
																		</th>
																		<th>
																			 TANGGAL LUNAS
																		</th>
																		<th>
																			 TANGGAL SAMBUNG
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
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet light">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-globe"></i>Data Pembongkaran
													</div>
												</div>
												<div class="portlet-body">
													<div class="form-body form-horizontal">
														<div class="row">
															<div class="table-scrollable">
															<div class="col-md-12">
																<table class="table table-striped table-bordered table-hover" id="tablekendalitiga">
																<thead>
																	<tr >
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
																			 LEMBAR
																		</th>
																		<th>
																			 RP TAG
																		</th>
																		<th>
																			 RP BK
																		</th>
																		<th>
																			 PERIODE
																		</th>
																		<th>
																			 TANGGAL PUTUS
																		</th>
																		<th>
																			 TANGGAL LUNAS
																		</th>
																		<th>
																			 TANGGAL SAMBUNG
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
											</div>
										</div>
									</div>	
								</div>
								<div class="tab-pane fade" id="tab_1_2">	
									<div class="col-md-6 ">
										<div>
											<div class="portlet-body">
												<form action="#" id="form" class="form-horizontal" role="form">
													<div class="form-group">
														<label class="col-md-5 control-label">ID LANGGANAN</label>
														<div class="input-group">
															<?php
																$atribut_idlang_putus = 'id="idlang_putus" class="form-control select2me" style="width:200px"';
																echo form_dropdown('idlang_putus', $idlang_putus, '', $atribut_idlang_putus);
															?>
														</div>
													</div>													
													<div class="form-group">
														<label class="col-md-5 control-label">NAMA LANGGANAN</label>
														<div class="input-group">
															<input type="text" id="nama_lang" name="nama_lang" style="width:250px" class="form-control input-sm">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ALAMAT LANGGANAN</label>
														<div class="input-group">
															<input type="text" id="alamat_lang" name="alamat_lang" style="width:250px" class="form-control input-sm">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">TANGGAL PEMUTUSAN</label>
														<div class="input-group">
															<input type="text" id="tgl_putus" name="tgl_putus" placeholder="yyyy-mm-dd" class="form-control datepicker">
														</div>
													</div>
													<div class="form-group">
														<div class="btn-group">
															<a type="button" id="btnPutus" onclick="save()" class="btn green">Simpan</a>
														</div>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix margin-bottom-20">
							</div>
						</div>
					</div>
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

function save(){
	var putus 	 = $("#tgl_putus").datepicker('getDate');
	var save_method = 'update';
    var url = "<?php echo site_url('keuangan/pemutusan_update')?>";
    
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