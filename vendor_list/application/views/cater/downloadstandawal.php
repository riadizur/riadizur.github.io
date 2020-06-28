<script>
$(document).ready(function() {
	document.getElementById("sukses").innerHTML = "";
});

function unduh(){
		document.getElementById("sukses").innerHTML = "";
		$.ajax({
			url: '<?php echo base_url(); ?>/index.php/cater/cekdilnew/',
			type: "POST",
			dataType:"json",
			success:function(datas){
				$.map(datas, function (obj) {
					step = obj.THBLREK;
					if(step != null){
						document.getElementById("sukses").innerHTML = "";
						var tbrek = document.getElementById("thblrek").value;
						var hreF = '<?php echo base_url(); ?>index.php/cater/downloadexcelstandawal/'+tbrek;
						window.open(hreF, '_blank');
					}else{
						document.getElementById("sukses").innerHTML = "Anda Belum melakukan Cut Off Dil !!";
						return false;
					}
				});
			}
		});
}

</script>	
			<div> <p id="sukses" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Download Stand Awal<small>Catat Meter</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Download Stand Awal
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<form action="" enctype="multipart/form-data" method="post">
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-6 control-label">Tahun Bulan Rekening</label>
										<div class="col-md-6">
											<input type="text" id="thblrek" name="thblrek" class="form-control input" placeholder=" " value="<?php echo $thblrek; ?>" readonly="true">
										</div>
									</div>
								</div>
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-6 control-label">&nbsp;</label>
										
									</div>
								</div>
								<div class="form-actions">
									<a type="button" class="btn blue" onclick="unduh()">Download Sekarang</a>
								</div>
							</form>
						</div>					
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
</div>
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
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
<script>
jQuery(document).ready(function() {   
   // initiate layout and plugins
   Metronic.init(); // init metronic core components
Layout.init(); // init current layout
Demo.init(); // init demo features
});
</script>
<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>