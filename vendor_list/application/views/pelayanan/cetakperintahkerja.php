			<div class="page-head">
				<div class="page-title">
					<h1>Cetak Perintah Kerja <small>Pelayanan</small></h1>
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
								<i class="fa fa-gift"></i>Cetak Perintah Kerja
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Cetak Perintah Kerja </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Lain Lain </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">
									<div class="col-md-6 ">
										<div>
											<div class="portlet-body">
												<form action="" enctype="multipart/form-data" method="post">
													<div class="form-group">
														<label class="col-md-5 control-label">Cari No. Agenda</label>
														<div class="input-group">
															<input id="cari" name="cari" class="form-control" />
															<span class="input-group-btn">
																<a type="button" class="btn green">Cari </a>
															</span>
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-5 control-label">No. Agenda</label>
														<div class="input-group">
															<input id="no_agenda" name="no_agenda" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Customer</label>
														<div class="input-group">
															<input id="id_cust" name="id_cust" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Langganan</label>
														<div class="input-group">
															<input id="id_lang" name="id_lang" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Nama Langganan</label>
														<div class="input-group">
															<input id="nama_lang" name="nama_lang" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Alamat Langganan</label>
														<div class="input-group">
															<input id="alamat_lang" name="alamat_lang" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Tarif</label>
														<div class="input-group">
															<input id="tarif" name="tarif" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Daya</label>
														<div class="input-group">
															<input id="daya" name="daya" class="form-control" />
														</div>
													</div>
													<div class="form-actions">
														<button type="submit" class="btn blue" onclick="download()">Cetak Sekarang</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="col-md-6 ">
										<div>
											<div class="portlet-body">
												<form action="" enctype="multipart/form-data" method="post">
													<div class="form-group">
														<label class="col-md-5 control-label">Nama Pejabat</label>
														<div class="input-group">
															<input id="no_agenda" name="no_agenda" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Jabatan</label>
														<div class="input-group">
															<input id="id_cust" name="id_cust" class="form-control" />
														</div>
													</div>
													
													<div class="form-actions">
														<button type="submit" class="btn blue" onclick="download()">Simpan</button>
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
					<!-- END EXAMPLE TABLE PORTLET-->
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
<!-- END FOOTER -->
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="../../assets/global/plugins/respond.min.js"></script>
<script src="../../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
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