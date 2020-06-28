<script>
$(document).ready(function() {
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	
document.getElementById("valid").innerHTML = " ";
});


function cari(){
	document.getElementById("valid").innerHTML = " ";
	$('#stand_akhir_lwbp').attr('readonly', false);
	$('#stand_akhir_wbp').attr('readonly', false);
	$('#stand_akhir_kvarh').attr('readonly', false);
	$('#btnSave').attr('disabled',false);
	
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/cater/caridpmref/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#kd_area").val(obj.KEC_LANG);
					$("#thblrek").val(obj.THBLREK);
					$("#id_lang").val(obj.ID_LANG);
					$("#stand_awal_lwbp").val(obj.STAND_AWAL_LWBP);
					$("#stand_awal_wbp").val(obj.STAND_AWAL_WBP);
					$("#stand_awal_kvarh").val(obj.STAND_AWAL_KVARH);
					$("#stand_bkr_lwbp").val(obj.STAND_BKR_LWBP);
					$("#stand_bkr_wbp").val(obj.STAND_BKR_WBP);
					$("#stand_bkr_kvarh").val(obj.STAND_BKR_KVARH);
					$("#stand_psg_lwbp").val(obj.STAND_PSG_LWBP);
					$("#stand_psg_wbp").val(obj.STAND_PSG_WBP);
					$("#stand_psg_kvarh").val(obj.STAND_PSG_KVARH);
					
					$("#tgl_baca_akhir").val(obj.TGL_BACA_AKHIR);
					$("#stand_akhir_lwbp").val(obj.STAND_AKHIR_LWBP);
					$("#stand_akhir_wbp").val(obj.STAND_AKHIR_WBP);
					$("#stand_akhir_kvarh").val(obj.STAND_AKHIR_KVARH);
					var sts = obj.STATUS_DPM;
					if(sts !== ''){
						document.getElementById("valid").innerHTML = "ID LANGGANAN INI TIDAK BISA LAGI DI ENTRY MANUAL ";
						$('#stand_akhir_lwbp').attr('readonly', true);
						$('#stand_akhir_wbp').attr('readonly', true);
						$('#stand_akhir_kvarh').attr('readonly', true);
						$('#btnSave').attr('disabled',true);
					}
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

</script>


			<div class="page-head">
				<div class="page-title">
					<h1>Entry Stand Manual <small>Permohonan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Entry Stand Manual
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<label class="col-md-3 control-label">Masukan Nama / ID Langganan</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
										<!-- /input-group -->
									</div>
								</div>
							</div>
							<!-- tabel -->
							<form action="#" id="form" class="form-horizontal" role="form"> 
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="col-md-3 control-label"></label>
												<div class="col-md-4">
													<input type="hidden" id="id_lang" name="id_lang" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">&nbsp;</label>
												<div class="col-md-4">
													<p id="valid" style="color: red;"> </p>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Tahun Bulan Rekening</label>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
														<i class="fa fa-user"></i>
														</span>
														<input id="thblrek" name="thblrek" placeholder=" " class="form-control" type="text" readonly="true" value="<?php echo $thblrek; ?>">
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-3 control-label">Tanggal Catat Meter</label>
												<div class="col-md-4">
													<div class="input-group">
														<span class="input-group-addon">
														<i class="fa fa-user"></i>
														</span>
														<input id="tgl_baca_akhir" name="tgl_baca_akhir" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="table-scrollable">
												<table class="table table-bordered table-hover">
													<thead>
														<tr>
															<th style="width: 20%;">
																Uraian
															</th>
															<th>
																Awal
															</th>
															<th>
																Bongkar
															</th>
															<th>
																Pasang
															</th>
															<th>
																Akhir
															</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="active">
																LWBP
															</td>
															<td>
																<input type="text" id="stand_awal_lwbp" name="stand_awal_lwbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_psg_lwbp" name="stand_psg_lwbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_akhir_lwbp" name="stand_akhir_lwbp" class="form-control input-sm" placeholder=" ">
															</td>
														</tr>
														<tr>
															<td class="active">
																WBP
															</td>
															<td>
																<input type="text" id="stand_awal_wbp" name="stand_awal_wbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_psg_wbp" name="stand_psg_wbp" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_akhir_wbp" name="stand_akhir_wbp" class="form-control input-sm" placeholder=" ">
															</td>
														</tr>
														<tr>
															<td class="active">
																KVARH
															</td>
															<td>
																<input type="text" id="stand_awal_kvarh" name="stand_awal_kvarh" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_psg_kvarh" name="stand_psg_kvarh" class="form-control input-sm" placeholder=" " readonly="true">
															</td>
															<td>
																<input type="text" id="stand_akhir_kvarh" name="stand_akhir_kvarh" class="form-control input-sm" placeholder=" ">
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>	
										<div class="col-md-4">
											<div class="clearfix">
											</div>
										</div>
										<div class="col-md-4">
											<div class="clearfix">
												<a type="button" id="btnSave" onclick="save()" class="btn green btn-block">Simpan </a>
											</div>
										</div>
										<div class="col-md-4">
											<div class="clearfix">
											</div>
										</div>
									</div>						
								</div>
							</form>
							<!-- selesai -->
						</div>
					</div>
				</div>
			</div>
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

var save_method; 
var table;

function save(){
	var save_method = 'update';
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('cater/stand_add')?>";
    } else {
        url = "<?php echo site_url('cater/stand_update')?>";
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