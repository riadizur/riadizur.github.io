			<?php
				if($this->session->flashdata('msg')==TRUE):
				echo'<div class="alert alert-success" role="alert">';
				echo $this->session->flashdata('msg');
				echo "</div>";
				endif;
			?>
			
			<div class="page-head">
				<div class="page-title">
					<h1>Upload Rekening <small>Billing</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Upload Rekening Listrik
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
							<form action="<?php echo base_url();?>index.php/billing/prosesuploadrekening/" enctype="multipart/form-data" method="post">
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-6 control-label">Tahun Bulan Rekening</label>
										<div class="col-md-6">
											<input type="text" id="thblrek" name="thblrek" class="form-control" placeholder=" " readonly="true" value="<?php echo $thblrek; ?>">
										</div>
									</div>
									<div class="form-group ">
										<button type="submit" class="btn red">Upload Sekarang</button>
									</div>
								</div>
								
							</form>
						</div>						
					</div>
				</div>
				<div class="col-md-6 ">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Perhatian
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
								<div class="form-body">	
									<div class="news-blocks">
										<p> Catatan : </p>
										<p> 1.	Data akan masuk ke dalam rekening </p>
										<p> 2.	Data tidak dapat dilakukan perubahan</p>
									</div>
								</div>
						</div>						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Daftar Rekening
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
						<div class="portlet-body">
							<div class="table-responsive">	
								<table class="table table-striped table-bordered table-hover" id="table">
								<thead>
								<tr>
									<th>
										 ID
									</th>
									<th>
										 THBL TARIF
									</th>
									<th>
										 ID LANG
									</th>
									<th>
										 RP PTL
									</th>
									<th>
										 RP BPJU
									</th>
									<th>
										 RP ANGSURAN
									</th>
									<th>
										 RP TAGIHAN
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

<script>
var table;

$(document).ready(function() {
    table = $('#table').DataTable({ 
        "processing": true,
        "serverSide": true,
        "order": [],
		"Columns": [{}],

        "ajax": {
            "url": "<?php echo site_url('billing/rekening_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "orderable": false,
            "className": "text-right", 
            "targets": [3,4,5,6]
        },
        ],
    });

});
</script>

</body>
</html>