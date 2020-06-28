<script>
$(document).ready(function(){
	document.getElementById("suksesemail").innerHTML = " ";
	document.getElementById("suksessms").innerHTML = " ";
});
function kirimemail(){
	$('#BtnEmail').text('Sedang Mengirim...');
	$('#BtnEmail').attr('disabled',true);
	$('#small').modal({backdrop: 'static'});
	var pilih = $("input[name=optionsRadios]:checked").val();
	
	$.ajax({
		url: '<?php echo base_url(); ?>index.php/billing/invoice_send/'+pilih,
		type: "POST",
		dataType:"json",
		success:function(datas){
			setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnEmail').text('Kirim Email Sekarang'); 
			$('#BtnEmail').attr('disabled',false);
			document.getElementById("suksesemail").innerHTML = "Proses Kirim Email Berhasil!!";
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnEmail').text('Kirim Email Sekarang'); 
			$('#BtnEmail').attr('disabled',false);
			document.getElementById("suksesemail").innerHTML = "Proses Kirim Email Gagal!!";
        }
	});
}

function kirimsms(){
	$('#BtnSms').text('Sedang Mengirim...');
	$('#BtnSms').attr('disabled',true);
	$('#smalltwo').modal({backdrop: 'static'});
	
	$.ajax({
		url: '<?php echo base_url(); ?>index.php/billing/invoice_sms/',
		type: "POST",
		dataType:"json",
		success:function(datas){
			setTimeout(function(){$('#smalltwo').modal('hide')},1000);
			$('#BtnSms').text('Kirim Email Sekarang'); 
			$('#BtnSms').attr('disabled',false);
			document.getElementById("suksessms").innerHTML = "Proses Kirim SMS Berhasil!!";
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#smalltwo').modal('hide')},1000);
			$('#BtnSms').text('Kirim Email Sekarang'); 
			$('#BtnSms').attr('disabled',false);
			document.getElementById("suksessms").innerHTML = "Proses Kirim SMS Gagal!!";
        }
	});
}
</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Kirim Email dan Sms <small>Invoice</small></h1>
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
								<i class="fa fa-gift"></i>Kirim Email dan Sms
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Kirim Email Invoice </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Kirim SMS Invoice </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									<div> <p id="suksesemail" style="color: red;"> </p> </div>
									<div class="col-md-6 ">
										<div class="portlet light">
											<div class="portlet-body form">
												<form action="<?php echo base_url();?>index.php/billing/prosesuploadrekening/" enctype="multipart/form-data" method="post">
													<div class="form-body">								
														<div class="form-group">
															<label class="col-md-6 control-label">Tahun Bulan Rekening</label>
															<div class="col-md-6">
																<input type="text" id="thblrek" name="thblrek" class="form-control" placeholder=" " readonly="true" value="<?php echo $thblrek; ?>">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-12 control-label">&nbsp;</label>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Send Via</label>
															<div class="col-md-6">
																<div class="radio-list">
																	<label class="radio-inline">
																	<input type="radio" name="optionsRadios" id="optionsRadios25" value="webmail"> WEBMAIL </label>
																	<label class="radio-inline">
																	<input type="radio" name="optionsRadios" id="optionsRadios26" value="gmail" checked> GMAIL </label>
																</div>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-12 control-label">&nbsp;</label>
														</div>
													</div>
												</form>
											</div>						
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="form-group">
											<center><a type="button" class="btn green" id="BtnEmail" onclick="kirimemail()">Kirim Email Sekarang</a></center>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div> <p id="suksessms" style="color: red;"> </p> </div>
									<div class="col-md-6 ">
										<div class="portlet light">
											<div class="portlet-body form">
												<form action="<?php echo base_url();?>index.php/billing/prosesuploadrekening/" enctype="multipart/form-data" method="post">
													<div class="form-body">								
														<div class="form-group">
															<label class="col-md-6 control-label">Tahun Bulan Rekening</label>
															<div class="col-md-6">
																<input type="text" id="thblrek" name="thblrek" class="form-control" placeholder=" " readonly="true" value="<?php echo $thblrek; ?>">
															</div>
														</div>
													</div>
												</form>
											</div>						
										</div>
									</div>
									<div class="col-md-12 ">
										<div class="form-group">
											<center><a type="button" class="btn green" id="BtnSms" onclick="kirimsms()">Kirim SMS Sekarang</a></center>
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
				#smalltwo{
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
			<div class="modal fade bs-modal-sm" id="smalltwo" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<img src="<?php echo base_url();?>assets/img/loader.gif"/>
						<p id=""> Mohon Tunggu Sebentar</p>
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
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!-- Tambahan -->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script> 
<script>
jQuery(document).ready(function() {
   Metronic.init();
Layout.init();
Demo.init();
});
</script>

</body>
</html>