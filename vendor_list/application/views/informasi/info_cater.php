			<div class="page-head">
				<div class="page-title">
					<h1>Monitoring Catat Meter <small>Informasi Catat Meter</small></h1>
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
								<i class="fa fa-gift"></i>Monitoring Catat meter
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Rekap DLPD  </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Rekap Entri Stand </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab">
									Rekap Hitung KWH  </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekapdlpd">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 KODE AREA
												</th>
												<th>
													 STATUS DLPD
												</th>
												<th>
													 JUMLAH LANGGANAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>
									
								</div>
								<div class="tab-pane fade" id="tab_1_2">
										<?php echo $this->table->generate($records);?>
									
								</div>
								<div class="tab-pane fade" id="tab_1_3">
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekapkwh">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 KODE AREA
												</th>
												<th>
													 JUMLAH LANGGANAN
												</th>
												<th>
													 JUMLAH DAYA
												</th>
												<th>
													 JUMLAH KWH
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
	tablerekapdlpd = $('#tablerekapdlpd').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('cater/rekapdlpd_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "orderable": false,
			"className": "text-center", 
            "targets": [-1]
        },
        ],
    });

    tablerekapkwh = $('#tablerekapkwh').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('cater/rekapkwh_list')?>",
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