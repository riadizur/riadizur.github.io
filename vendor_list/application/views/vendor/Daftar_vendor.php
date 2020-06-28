			<div class="page-head">
				<div class="page-title">
					<h1>Daftar <small>Vendor</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box blue-steel">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Daftar semua vendor PT Energi Pelabuhan Indonesia
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
																<th class="text-center">
																	 No.
																</th>
																<th width='100' class="text-center">
																	 ID Vendor
																</th>
																<th width='400' class="text-center">
																	 Perusahaan
																</th>
																<th class="text-center">
																	 Grade SIUP
																</th>
																<th class="text-center">
																	 Grade SIUJK
																</th>
																<th class="text-center">
																	 PIC
																</th>
																<th width='70' class="text-center">
																	 Aksi
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
			<style>
				#tabel {
				    padding: 0px;
				    width: 100%;
				    height: 200px;
				    overflow: scroll;
				    border: 1px solid #ccc;
				}
			</style>
			<!-- modal large -->
			<div id="detil_vendor" class="modal fade bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-toggle="modal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Informasi Vendor</h4>
						</div>
						<div class="modal-body">
							<div class="row">

								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Id Vendor</label>
												<div class="col-md-8">
													<input type="text" id="id_vd" name="id_vd" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Perusahaan</label>
												<div class="col-md-8">
													<input type="text" id="nama_pt" name="nama_pt" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Alamat </label>
												<div class="col-md-8">
													<input type="text" id="alamat_pt" name="alamat_pt" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Kode Pos </label>
												<div class="col-md-8">
													<input type="text" id="kodepos" name="kodepos" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No Telepon </label>
												<div class="col-md-8">
													<input type="text" id="no_tlp_pt" name="no_tlp_pt" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Nama Pimpinan</label>
												<div class="col-md-8">
													<input type="text" id="nama_dirut" name="nama_dirut" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">PIC</label>
												<div class="col-md-8">
													<input type="text" id="nama_pic" name="nama_pic" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No HP PIC</label>
												<div class="col-md-8">
													<input type="text" id="no_hp_pic" name="no_hp_pic" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Email</label>
												<div class="col-md-8">
													<input type="text" id="email_pic" name="email_pic" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No. Domisili</label>
												<div class="col-md-8">
													<input type="text" id="no_domisili" name="no_domisili" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Domisili</label>
												<div class="col-md-8">
													<input type="text" id="tgl_domisili" name="tgl_domisili" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Exp Domisili</label>
												<div class="col-md-8">
													<input type="text" id="tgl_exp_domisili" name="tgl_exp_domisili" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No Akta Pendirian</label>
												<div class="col-md-8">
													<input type="text" id="no_akta_pendirian" name="no_akta_pendirian" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Akta Pendirian</label>
												<div class="col-md-8">
													<input type="text" id="tgl_akta_pendirian" name="tgl_akta_pendirian" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No Pengesahan Akta Pendirian</label>
												<div class="col-md-8">
													<input type="text" id="no_pengesahan_akta_pendirian" name="no_pengesahan_akta_pendirian" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Pengesahan Akta Pendirian</label>
												<div class="col-md-8">
													<input type="text" id="tgl_pengesahan_akta_pendirian" name="tgl_pengesahan_akta_pendirian" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No Akta Perubahan</label>
												<div class="col-md-8">
													<input type="text" id="no_akta_perubahan" name="no_akta_perubahan" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Akta Perubahan</label>
												<div class="col-md-8">
													<input type="text" id="tgl_akta_perubahan" name="tgl_akta_perubahan" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No Pengesahan Akta Perubahan</label>
												<div class="col-md-8">
													<input type="text" id="no_pengesahan_akta_perubahan" name="no_pengesahan_akta_perubahan" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl Pengesahan Akta Perubahan</label>
												<div class="col-md-8">
													<input type="text" id="tgl_pengesahan_akta_perubahan" name="tgl_pengesahan_akta_perubahan" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No NPWP</label>
												<div class="col-md-8">
													<input type="text" id="no_npwp" name="no_npwp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl NPWP</label>
												<div class="col-md-8">
													<input type="text" id="tgl_npwp" name="tgl_npwp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No PKP</label>
												<div class="col-md-8">
													<input type="text" id="no_pkp" name="no_pkp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl PKP</label>
												<div class="col-md-8">
													<input type="text" id="tgl_pkp" name="tgl_pkp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="form-group">
												<label class="col-md-4 control-label align-left">No TDP</label>
												<div class="col-md-8">
													<input type="text" id="no_tdp" name="no_tdp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl TDP</label>
												<div class="col-md-8">
													<input type="text" id="tgl_tdp" name="tgl_tdp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-4 control-label align-left">Tgl exp TDP</label>
												<div class="col-md-8">
													<input type="text" id="tgl_exp_tdp" name="tgl_exp_tdp" class="form-control input-sm" placeholder=" " readonly="true" />
													<span class="help-block"></span>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Nomor SIUP</label>
													<div class="col-md-8">
														<input type="text" id="nomor_siup" name="nomor_siup" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl SIUP</label>
													<div class="col-md-8">
														<input type="text" id="tgl_siup" name="tgl_siup" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl exp SIUP</label>
													<div class="col-md-8">
														<input type="text" id="tgl_exp_siup" name="tgl_exp_siup" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Modal Usaha SIUP</label>
													<div class="col-md-8">
														<input type="text" id="modal_usaha_siup" name="modal_usaha_siup" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Grade SIUP</label>
													<div class="col-md-8">
														<input type="text" id="grade_siup" name="grade_siup" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="table-scrollable" id="tabel">
													<input type="hidden" id="last_siup" name="last_siup" class="form-control input-sm"/>
													<table class="table table-striped table-hover tabel" id="tabel_siup">
														<thead>
															<tr>
																<th width='50'>
																	No
																</th>
																<th class="text-center">
																	Kode
																</th>
																<th class="text-center">
																	Nama Sub Bidang
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
								<div class="col-md-12">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Nomor SIUJK</label>
													<div class="col-md-8">
														<input type="text" id="nomor_siujk" name="nomor_siujk" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl SIUJK</label>
													<div class="col-md-8">
														<input type="text" id="tgl_siujk" name="tgl_siujk" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl exp SIUJK</label>
													<div class="col-md-8">
														<input type="text" id="tgl_exp_siujk" name="tgl_exp_siujk" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Modal Usaha SIUJK</label>
													<div class="col-md-8">
														<input type="text" id="modal_usaha_siujk" name="modal_usaha_siujk" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Grade SIUJK</label>
													<div class="col-md-8">
														<input type="text" id="grade_siujk" name="grade_siujk" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="table-scrollable" id="tabel">
													<input type="hidden" id="last_siujk" name="last_siujk" class="form-control input-sm"/>
													<table class="table table-striped table-hover tabel" id="tabel_siujk">
														<thead>
															<tr>
																<th width='50'>
																	No
																</th>
																<th class="text-center">
																	Kode
																</th>
																<th class="text-center">
																	Nama Sub Bidang
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
								<div class="col-md-12">
									<div class="panel panel-success">
										<div class="panel-body form-horizontal">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Nomor SIU</label>
													<div class="col-md-8">
														<input type="text" id="nomor_siu" name="nomor_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Nama SIU</label>
													<div class="col-md-8">
														<input type="text" id="nama_siu" name="nama_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl SIU</label>
													<div class="col-md-8">
														<input type="text" id="tgl_siu" name="tgl_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Tgl Exp SIU</label>
													<div class="col-md-8">
														<input type="text" id="tgl_exp_siu" name="tgl_exp_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Modal Usaha SIU</label>
													<div class="col-md-8">
														<input type="text" id="modal_usaha_siu" name="modal_usaha_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
												<div class="form-group">
													<label class="col-md-4 control-label align-left">Grade SIU</label>
													<div class="col-md-8">
														<input type="text" id="grade_siu" name="grade_siu" class="form-control input-sm" placeholder=" " readonly="true" />
														<span class="help-block"></span>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="table-scrollable" id="tabel">
													<input type="hidden" id="last_siu" name="last_siu" class="form-control input-sm"/>
													<table class="table table-striped table-hover tabel" id="tabel_siu">
														<thead>
															<tr>
																<th width='50'>
																	No
																</th>
																<th class="text-center">
																	Kode
																</th>
																<th class="text-center">
																	Nama Sub Bidang
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
							</div>
						</div>
					</div>
				</div>

			</div>
			<!-- END PAGE CONTENT-->
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
            "url": "<?php echo site_url('vendor/vendor_list')?>",
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

function detil_vendor(id_vdx)
{
	$("#detil_vendor").modal("show");
	$('#detil_vendor').modal({backdrop: 'static'});

	removeAll_siup();
	removeAll_siujk();

	var baseUrl = '<?php echo base_url(); ?>index.php/vendor/detil_vendor/'+id_vdx;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$("#id_vd").val(datas.id_vd);
			$("#nama_pt").val(datas.nama_pt);
			$("#alamat_pt").val(datas.alamat_pt);
			$("#kodepos").val(datas.kodepos);
			$("#no_tlp_pt").val(datas.no_tlp_pt);
			$("#nama_dirut").val(datas.nama_dirut);
			$("#nama_pic").val(datas.nama_pic);
			$("#no_hp_pic").val(datas.no_hp_pic);
			$("#email_pic").val(datas.email_pic);
			$("#no_domisili").val(datas.no_domisili);
			$("#tgl_domisili").val(datas.tgl_domisili);
			$("#tgl_exp_domisili").val(datas.tgl_exp_domisili);
			$("#no_akta_pendirian").val(datas.no_akta_pendirian);
			$("#tgl_akta_pendirian").val(datas.tgl_akta_pendirian);
			$("#no_pengesahan_akta_pendirian").val(datas.no_pengesahan_akta_pendirian);
			$("#tgl_pengesahan_akta_pendirian").val(datas.tgl_pengesahan_akta_pendirian);
			$("#no_akta_perubahan").val(datas.no_akta_perubahan);
			$("#tgl_akta_perubahan").val(datas.tgl_akta_perubahan);
			$("#no_pengesahan_akta_perubahan").val(datas.no_pengesahan_akta_perubahan);
			$("#tgl_pengesahan_akta_perubahan").val(datas.tgl_pengesahan_akta_perubahan);
			$("#no_npwp").val(datas.no_npwp);
			$("#tgl_npwp").val(datas.tgl_npwp);
			$("#no_pkp").val(datas.no_pkp);
			$("#tgl_pkp").val(datas.tgl_pkp);
			$("#no_tdp").val(datas.no_tdp);
			$("#tgl_tdp").val(datas.tgl_tdp);
			$("#tgl_exp_tdp").val(datas.tgl_exp_tdp);
			$("#nomor_siup").val(datas.nomor_siup);
			$("#tgl_siup").val(datas.tgl_siup);
			$("#tgl_exp_siup").val(datas.tgl_exp_siup);
			$("#modal_usaha_siup").val(format_uang(datas.modal_usaha_siup));
			$("#grade_siup").val(datas.grade_siup);
			$("#nomor_siujk").val(datas.nomor_siujk);
			$("#tgl_siujk").val(datas.tgl_siujk);
			$("#tgl_exp_siujk").val(datas.tgl_exp_siujk);
			$("#modal_usaha_siujk").val(format_uang(datas.modal_usaha_siujk));
			$("#grade_siujk").val(datas.grade_siujk);
			$("#nomor_siu").val(datas.nomor_siu);
			$("#nama_siu").val(datas.nama_siu);
			$("#tgl_siu").val(datas.tgl_siu);
			$("#tgl_exp_siu").val(datas.tgl_exp_siu);
			$("#modal_usaha_siu").val(format_uang(datas.modal_usaha_siu));
			$("#grade_siu").val(datas.grade_siu);
			vendor_siup(datas.id_vd);
			vendor_siujk(datas.id_vd);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

function vendor_siup(id_vdx)
{
	var baseUrl = '<?php echo base_url(); ?>index.php/vendor/vendor_siup/'+id_vdx;
	var urut_siup = 0;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$.map(datas, function (obj)
			{
				urut_siup = urut_siup + 1;
				var tabel = "tabel_siup";
				var kolom_1 = "<td>"+urut_siup+"</td>";
				var kolom_2 = "<td>"+obj.kode_siup+"</td>";
				var kolom_3 = "<td>"+obj.bidang_siup+"</td>";
				addElement(tabel, urut_siup, kolom_1, kolom_2, kolom_3);
			});
			$('#last_siup').val(urut_siup);


		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

function removeAll_siup() {
	var tabel = "tabel_siup";
	var urut = document.getElementById("last_siup").value;
	urut_anwizing = 0;
	for (var i = 1; i <= urut; i++)
	{
		$('table#'+tabel+' tr#'+i+'').remove();
	}
}

function vendor_siujk(id_vdx)
{
	var baseUrl = '<?php echo base_url(); ?>index.php/vendor/vendor_siujk/'+id_vdx;
	var urut_siujk = 0;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$.map(datas, function (obj)
			{
				urut_siujk = urut_siujk + 1;
				var tabel = "tabel_siujk";
				var kolom_1 = "<td>"+urut_siujk+"</td>";
				var kolom_2 = "<td>"+obj.kode_siujk+"</td>";
				var kolom_3 = "<td>"+obj.bidang_siujk+"</td>";
				addElement(tabel, urut_siujk, kolom_1, kolom_2, kolom_3);
			});
			$('#last_siujk').val(urut_siujk);


		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

function removeAll_siujk() {
	var tabel = "tabel_siujk";
	var urut = document.getElementById("last_siujk").value;
	for (var i = 1; i <= urut; i++)
	{
		$('table#'+tabel+' tr#'+i+'').remove();
	}
}

function vendor_siu(id_vdx)
{
	var baseUrl = '<?php echo base_url(); ?>index.php/vendor/vendor_siu/'+id_vdx;
	var urut_siu = 0;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$.map(datas, function (obj)
			{
				urut_siu = urut_siu + 1;
				var tabel = "tabel_siu";
				var kolom_1 = "<td>"+urut_siu+"</td>";
				var kolom_2 = "<td>"+obj.bidang_siu+"</td>";
				var kolom_3 = "";
				addElement(tabel, urut_siu, kolom_1, kolom_2, kolom_3);
			});
			$('#last_siu').val(urut_siu);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

function removeAll_siu() {
	var tabel = "tabel_siu";
	var urut = document.getElementById("last_siu").value;
	for (var i = 1; i <= urut; i++)
	{
		$('table#'+tabel+' tr#'+i+'').remove();
	}
}

function addElement(tabel, urut, kolom_1, kolom_2, kolom_3)
{
	$('#'+tabel+'> tbody:last-child').append('<tr id="'+urut+'">'+kolom_1+kolom_2+kolom_3+'</tr>');
}



function format_uang(uang)
{
	if (uang == null)
	{
		var pitih = '';
	}
	else
	{
		var pitih = 'Rp. ' + parseFloat(uang).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	}
	return pitih;
}

</script>
</body>
</html>
