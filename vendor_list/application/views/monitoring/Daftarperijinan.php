			<div class="page-head">
				<div class="page-title">
					<h1>Daftar <small>Status Perijinan Vendor</small></h1>
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
								<i class="fa fa-globe"></i>Daftar Status Perijinan Vendor PT Energi Pelabuhan Indonesia
							</div>
						</div>
						<div class="portlet-body">
							<div class="portlet-body form">
								<form action="#" id="form" class="form-horizontal" role="form">
									<input type="hidden" value="" name="id"/>
									<div class="form-body">
										<div class="row">

											<div class="col-md-12">
												<div class="table-scrollable">
													<table class="table table-striped table-bordered table-hover" id="table">
														<thead>
															<tr>
																<th>
																	 No.
																</th>
																<th width='100'>
																	 ID Vendor
																</th>
																<th width='400'>
																	 Perusahaan
																</th>
																<th>
																	 Data Administrasi
																</th>
																<th>
																	 Data Domisili
																</th>
																<th>
																	 Status Domisili
																</th>
																<th>
																	 Data Akta Pendirian
																</th>
																<th>
																	 Data Akta Perubahan
																</th>
																<th>
																	 Data Akta NPWP
																</th>
																<th>
																	 Data PKP
																</th>
																<th>
																	 Data TDP
																</th>
																<th>
																	 Status TDP
																</th>
																<th>
																	 Data SIUP
																</th>
																<th>
																	 Status SIUP
																</th>
																<th>
																	 Data SIUJK
																</th>
																<th>
																	 Status SIUJK
																</th>
																<th>
																	 Data SIU
																</th>
																<th>
																	 Status SIU
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
					</div>
				</div>
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

$(document).ready(function() {

    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "<?php echo site_url('monitoring/daftarperijinan_list')?>",
            "type": "POST"
        },

        "columnDefs": [
        {
            "targets": [ -1 ],
            "orderable": false,
        },
        ],

    });

    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,
    });

});

</script>
</body>
</html>
