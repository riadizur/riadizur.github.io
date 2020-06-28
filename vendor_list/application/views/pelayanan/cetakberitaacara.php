<script>
$(document).ready(function() { 
    $("#nama_pejabat").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_jabatan/'+v;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					$("#jabatan").val(obj.jabatan);
				});
				
			}
		});
	});
});

function cetak(x){
	var id_lang = document.getElementById("id_lang").value;
	var id      = document.getElementById("nama_pejabat").value;
	var jenis   = document.getElementById("jns_ba").value;
	if(jenis == 'NOSELECT'){
		alert("PILIH JENIS BERITA ACARA"); return false
	}
	
	if(id == '' || id == '5'){
		var id = '5'
	}else{
		var id    = document.getElementById("nama_pejabat").value;
	}
	
	if(jenis == '0'){
		hreF   = "<?php echo site_url("Laporan/rpt_beritaacara")?>";
	}else if(jenis == '1'){
		hreF   = "<?php echo site_url("Laporan/rpt_beritaacarasetting")?>";
	}else{
		hreF   = "<?php echo site_url("Laporan/rpt_beritaacaraganti")?>";
	}
	
	ReQuest= "/" + x +"/" + id+"/" +id_lang;
	window.open(hreF+ReQuest, '_blank');
}

function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_cl/'+carix;
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
					lunas = obj.TGL_BAYAR;
					//di LOS CONTROL CEK LUNAS request by Mas Fauzi 11:00 15 Feb 2018
					//if(lunas != null || lunas != '0000-00-00 00:00:00' || lunas != ''){
					//	$('#BtnCetak').attr('disabled',true);
					//	document.getElementById("lunas").innerHTML = "Permohonan ini belum dilakukan pembayaran !!";
					//}
					$("#id_lang").val(obj.ID_LANG);
					$("#id_cust").val(obj.ID_CUST);
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#daya_baru").val(obj.DAYA);
					$("#tarif_baru").val(obj.TARIF);
				});
				if(ck==''){
					$('[name="cari"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="cari"]').attr('value',''); 
					$('[name="cari"]').attr('placeholder','Data tidak ada');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
}


</script>		
			<div> <p id="lunas" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Cetak Berita Acara <small>Pelayanan</small></h1>
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
									Informasi Cetakan </a>
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
														<label class="col-md-5 control-label">Cari ID Langganan</label>
														<div class="input-group">
															<input id="cari" name="cari" class="form-control" />
															<span class="input-group-btn">
																<a type="button" onclick="cari()" class="btn green">Cari </a>
															</span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label ">Jenis Berita Acara</label>
														<div class="input-group">
															<select id="jns_ba" name="jns_ba" class="form-control select2me" data-placeholder="Select...">
																<option value="NOSELECT" selected>-- Pilih --</option>
																<option value="0">PENYAMBUNGAN</option>
																<option value="1">PENYETINGAN</option>
																<option value="2">PENGGANTIAN</option>
															</select>													
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Customer</label>
														<div class="input-group">
															<input id="id_cust" name="id_cust" class="form-control" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Langganan</label>
														<div class="input-group">
															<input id="id_lang" name="id_lang" class="form-control" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Nama Langganan</label>
														<div class="input-group">
															<input id="nama_lang" name="nama_lang" class="form-control" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Alamat Langganan</label>
														<div class="input-group">
															<input id="alamat_lang" name="alamat_lang" class="form-control" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Tarif</label>
														<div class="input-group">
															<input id="tarif_baru" name="tarif_baru" class="form-control" readonly />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Daya</label>
														<div class="input-group">
															<input id="daya_baru" name="daya_baru" class="form-control" readonly />
														</div>
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
															<?php
																$atribut_nama_pejabat = 'id="nama_pejabat" class="form-control select2me" style="width:200px"';
																echo form_dropdown('nama_pejabat', $nama_pejabat, '', $atribut_nama_pejabat);
															?>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Jabatan</label>
														<div class="input-group">
															<input id="jabatan" name="jabatan" class="form-control" />
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
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="portlet-body">
						<div class="form-group">
							<div class="form-actions">
								<button type="button" id="BtnCetak" name="BtnCetak" class="btn blue" onclick="cetak(1)">Cetak Sekarang</button>
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
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
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