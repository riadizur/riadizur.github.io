<script>
$(document).ready(function(){
	document.getElementById("sukses").innerHTML = " ";
});

function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagenda/'+carix;
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.NO_AGENDA;
					$("#no_agenda").val(obj.NO_AGENDA);
					$("#id_cust").val(obj.ID_CUST);
					$("#id_lang").val(obj.ID_LANG);
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#daya_baru").val(obj.DAYA_BARU);
					$("#tarif_baru").val(obj.TARIF_BARU);
					$("#rp_bp").val(obj.RP_BP);
					$("#rp_ujl_tagih").val(obj.RP_UJL_TAGIH);
					$("#materai").val(obj.MATERAI);
					$("#total_biaya").val(obj.TOTAL_BIAYA);
					$("#jns_transaksi").val(obj.JNS_TRANSAKSI);

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

function proses(){
		var carix   = document.getElementById("no_agenda").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/pembatalanpermohonan/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
					alert("Berhasil di batalkan");
					document.getElementById("sukses").innerHTML = "Berhasil Dibatalkan!!";
			},
			error: function (xhr, ajaxOptions, thrownError) {
					document.getElementById("sukses").innerHTML = "Gagal Dibatalkan!!";
			}
		});
}

</script>
			<div> <p id="sukses" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Pembatalan <small>Pelayanan</small></h1>
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
								<i class="fa fa-gift"></i>Pembatalan
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Pembatalan Permohonan </a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Restitusi BP / UJL </a>
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
																<a type="button" onclick="cari()" class="btn green">Cari </a>
															</span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">No Agenda</label>
														<div class="input-group">
															<input id="no_agenda" name="no_agenda" class="form-control" readonly />
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
														<label class="col-md-5 control-label">Jenis Permohonan</label>
														<div class="input-group">
															<input id="jns_transaksi" name="jns_transaksi" class="form-control" readonly />
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

											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">&nbsp;</label>
											<div class="input-group">
												<input type="hidden" class="form-control" />
											</div>
										</div>
										<div class="form-group">&nbsp;</label>
											<div class="input-group">
												<input type="hidden" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Tanggal Persetujuan</label>
											<div class="input-group">
												<input id="tgl_setuju" name="tgl_setuju" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">BP</label>
											<div class="input-group">
												<input id="rp_bp" name="rp_bp" class="form-control" readonly />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">UJL</label>
											<div class="input-group">
												<input id="rp_ujl_tagih" name="rp_ujl_tagih" class="form-control" readonly />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Materai</label>
											<div class="input-group">
												<input id="materai" name="materai" class="form-control" readonly />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Total Biaya</label>
											<div class="input-group">
												<input id="total_biaya" name="total_biaya" class="form-control" readonly />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Alasan Pembatalan</label>
											<div class="input-group">
												<textarea id="alasan_batal" name="alasan_batal" class="form-control" rows="3"></textarea>
											</div>
										</div>
										<div class="form-actions">
											<a type="button" class="btn blue" onclick="proses()">Simpan</a>
										</div>
									</div>
											</form>
								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="col-md-6 ">
										<div>
											<div class="portlet-body">
												<form action="" enctype="multipart/form-data" method="post">
													<div class="form-group">
														<label class="col-md-5 control-label">Cari No. Agenda</label>
														<div class="input-group">
															<input id="cari2" name="cari2" class="form-control" />
															<span class="input-group-btn">
																<a type="button" class="btn green">Cari </a>
															</span>
														</div>
													</div>

													<div class="form-group">
														<label class="col-md-5 control-label">ID Customer</label>
														<div class="input-group">
															<input id="no_agenda2" name="no_agenda2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Langganan</label>
														<div class="input-group">
															<input id="id_cust2" name="id_cust2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">ID. Langganan</label>
														<div class="input-group">
															<input id="id_lang2" name="id_lang2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Jenis Permohonan</label>
														<div class="input-group">
															<input id="nama_lang2" name="nama_lang2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Nama Langganan</label>
														<div class="input-group">
															<input id="nama_lang2" name="nama_lang2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Alamat Langganan</label>
														<div class="input-group">
															<input id="alamat_lang2" name="alamat_lang2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Tarif</label>
														<div class="input-group">
															<input id="tarif2" name="tarif2" class="form-control" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-5 control-label">Daya</label>
														<div class="input-group">
															<input id="daya2" name="daya2" class="form-control" />
														</div>
													</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">&nbsp;</label>
											<div class="input-group">
												<input type="hidden" class="form-control" />
											</div>
										</div>
										<div class="form-group">&nbsp;</label>
											<div class="input-group">
												<input type="hidden" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Tanggal Persetujuan</label>
											<div class="input-group">
												<input id="tgl_setuju2" name="tgl_setuju2" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">BP</label>
											<div class="input-group">
												<input id="rp_bp2" name="rp_bp2" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">UJL</label>
											<div class="input-group">
												<input id="rp_ujl_tagih2" name="rp_ujl_tagih2" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Materai</label>
											<div class="input-group">
												<input id="materai2" name="materai2" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Total Biaya</label>
											<div class="input-group">
												<input id="total_biaya2" name="total_biaya2" class="form-control" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-5 control-label">Alasan Berhenti Berlangganan</label>
											<div class="input-group">
												<textarea class="form-control" rows="3"></textarea>
											</div>
										</div>
										<div class="form-actions">
											<button type="submit" class="btn blue" onclick="proses()">Simpan</button>
										</div>
									</div>
									</form>
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
<script>
jQuery(document).ready(function() {
Metronic.init();
Layout.init();
Demo.init();
});
</script>
</body>
</html>
