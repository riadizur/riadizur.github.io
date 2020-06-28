			<?php
				if($this->session->flashdata('msg')==TRUE):
				echo'<div class="alert alert-success" role="alert">';
				echo $this->session->flashdata('msg');
				echo "</div>";
				endif;
			?>
			
			<div class="page-head">
				<div class="page-title">
					<h1>Validasi DPM <small>Billing</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4 ">
					<div class="portlet box red">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Periksa Ulang DPM
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<form>
								<div class="form-body">								
									<div class="form-group">
										<p> Perhatian
										<p> 1. Proses ini akan me-rollback data DPM </p>
										<p> 2. DPM akan kembali Sebelum proses hitung </p>
									</div>
								</div>
								<div class="form-actions">
									<center><a class="btn default btn-lg red" data-toggle="modal" href="#small">ROLBACK DPM</a></center>
								</div>
							</form>
						</div>						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Data Hasil Upload Tarif Dasar
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
						<div class="form-body">	
							<table class="table table-striped table-bordered table-hover" id="table">
							<thead>
							<tr>
								<th>
									 ID
								</th>
								<th>
									 THBLREK
								</th>
								<th>
									 ID LANGGANAN
								</th>
								<th>
									 PEMAKAIAN LWBP
								</th>
								<th>
									 PEMAKAIAN WBP
								</th>
								<th>
									 PEMAKAIAN KVARH
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
			<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<form action="<?php echo base_url();?>index.php/billing/prosesrollback/" enctype="multipart/form-data" method="post">
							<div class="modal-header">
								<h4 class="modal-title">KONFIRMASI</h4>
							</div>
							<div class="modal-body">
								 APAKAH ANDA YAKIN AKAN MELAKUKAN ROLL-BACK DPM ??
							</div>
							<div class="modal-footer">
								<button type="button" class="btn default" data-dismiss="modal">BATAL</button>
								<button type="submit" class="btn blue">YAKIN</button>
							</div>
						</form>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
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

        "ajax": {
            "url": "<?php echo site_url('billing/validasidpm_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "orderable": false,
            "className": "text-right", 
            "targets": [3,4,5]
        },
        ],
    });

});
</script>

</body>
</html>