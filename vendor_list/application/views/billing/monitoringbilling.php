<script>


function cetakrekap(x){
	if(x==1){
		filter  = document.getElementById("filterhitungbilling").value;
		hreF	= "<?php echo site_url("Laporan/rpt_hitungbillingexcel")?>"+"/"+filter;
		window.open(hreF, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_rekapdlpdexcel")?>";
		window.open(hreF, '_blank');
	}
}

function filterhitungbilling(){
	$('#tablerekaphitung tbody').empty();
	var filterhitungbilling   = document.getElementById("filterhitungbilling").value;
	tablerekaphitung = $('#tablerekaphitung').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('billing/rekaphitung_list')?>",
			"type": "POST",
			data: function(d) {
				d.filterhitungbilling = filterhitungbilling
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
</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Monitoring Billing <small>Billing</small></h1>
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
								<i class="fa fa-gift"></i>Monitoring Billing
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Rekap Hitung Billing </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Rekap DLPD </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
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
											<label class="col-md-4 control-label align-left">TAHUN BULAN REKENING</label>
											<div class="col-md-4 input-group">
												<input id="filterhitungbilling" name="filterhitungbilling" class="form-control" type="text" placeholder="201803"/>
												<span class="input-group-btn">
													<a type="button" onclick="filterhitungbilling()" class="btn blue">Filter </a>
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
									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekaphitung">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 KD AREA
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
									<div class="col-md-2 ">
										<div>
											<div class="portlet-body">
												<div class="form-actions">
													<a type="button" class="btn green" onclick="cetakrekap(1)">Cetak Daftar EXCEL</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
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
	tablerekaphitung = $('#tablerekaphitung').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('billing/rekaphitung_list')?>",
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
});

$(document).ready(function() {
	tabledaftar = $('#tablerekapdlpd').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('billing/rekapdlpd_list')?>",
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
});

</script>
</body>
</html>