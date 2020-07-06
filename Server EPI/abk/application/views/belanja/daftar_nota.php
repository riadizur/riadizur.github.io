<script>
	$(document).ready(function() {

		$('.datepicker').datepicker({
			autoclose: true,
			format: "yyyy-mm-dd",
			todayHighlight: true,
			orientation: "top auto",
			todayBtn: true,
			todayHighlight: true,
		});

		tabel_daftar_nota();

	});

	function tabel_daftar_nota() {
		$('#tabel_daftar_nota').DataTable({
			destroy: true,
			"processing": true,
			"serverSide": false,
			"bInfo": false,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('belanja/tabel_daftar_nota/') ?>",
				"type": "POST",
				data: {
					tahun: $("#tahun").val(),
				}
			},
			"columnDefs": [{
				"className": "text-center",
				"targets": [0, 1, 2, 3, 4, 5],
				"className": "text-right",
				"targets": [6],
			}],
		});
	}
	function show_nota(kode_file){
		window.open('http://portal.ecopowerport.co.id:88/abk/upload/'+kode_file,'_blank');
	}
</script>
<div class="page-head">
	<div class="page-title">
		<h1>Daftar Nota<small>Belanja</small></h1>
	</div>
	<div class="page-toolbar">
		<div class="btn-group btn-theme-panel">
		</div>
	</div>
</div>
<div class="row">
	<form action="#" id="form" role="form">
	</form>
	<div class="col-md-6">
		<div class="portlet light bordered">
			<div class="portlet-body form-horizontal">
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-4 control-label align-left">Pilih Tahun</label>
						<div class="col-md-8">
							<?php
							echo form_dropdown('tahun', $list_tahun, $tahun, 'id="tahun" class="form-control select2me" style="width:100%;" ');
							?>
						</div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="col-md-12 ">
		<div class="portlet light bordered">
			<div class="portlet-body form-horizontal">
				<div class="form-body">
					<div class="table-scrollable">
						<table class="table table-striped table-hover" id="tabel_daftar_nota">
							<thead>
								<tr>
									<th width='50'>
										No.
									</th>
									<th>
										Id Nota
									</th>
									<th>
										Tempat Belanja
									</th>
									<th>
										Anggaran
									</th>
									<th>
										Total Belanja (Rp.)
									</th>
									<th>
										Status
									</th>
									<th>
										Aksi
									</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>

</div> 

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="row">
			<form action="#" id="form" role="form" enctype="multipart/form-data">
				<div class="col-md-12 ">
					<div class="portlet box green-meadow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Edit Pembayaran
							</div>
						</div>
						<div class="portlet-body">

							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">

											<div class="form-group">
												<label class="col-md-6 control-label align-left">No. Register Nota</label>
												<div class="col-md-6">
													<input type="text" id="id_reg_nota" name="id_reg_nota" value="" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">No. Transaksi</label>
												<div class="col-md-6">
													<input type="text" id="id_transaksi" name="id_transaksi" value="" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>

											<div id="beli_11" class="form-group">
												<label id="beli_1" class="col-md-6 control-label align-left">Tanggal Pembayaran</label>
												<div class="col-md-6">
													<input type="text" id="tgl_pembelian" name="tgl_pembelian" class="form-control input-sm datepicker" placeholder="tahun-bulan-hari" required>
												</div>
											</div>
											<div id="beli_21" class="form-group">
												<label id="beli_2" class="col-md-6 control-label align-left">Pembayaran kepada</label>
												<div class="col-md-6">
													<input type="text" id="tempat_pembelian" name="tempat_pembelian" class="form-control input-sm" placeholder="Nama Penyedia" required>
												</div>
											</div>
											<div id="beli_31" class="form-group">
												<label id="beli_3" class="col-md-6 control-label align-left">Pengenaan PPN</label>
												<div class="col-md-6">
													<select id="ada_ppn" name="ada_ppn" class="form-control input-sm">
														<option value="tidak">TIDAK</option>
														<option value="ya">YA</option>
													</select>
												</div>
											</div>
											<div id="beli_41" class="form-group" style="display:none;">
												<label id="beli_4" class="col-md-6 control-label align-left">Nomor NPWP</label>
												<div class="col-md-6">
													<input type="text" id="no_npwp" name="no_npwp" class="form-control input-sm" placeholder=" " required>
												</div>
											</div>
											<a type="button" id="btnreload" onclick="reload()" class="btn red"><i class="fa fa-refresh"></i> Reset</a>
										</div>
									</div>
								</div>
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-6 control-label align-left">Dibayar dari </label>
													<div class="radio-list">
														<label class="radio-inline">
															<input type="radio" name="anggaran" id="kontraktor" value="kas kecil"> Kas Kecil
														</label>
														<label class="radio-inline">
															<input type="radio" name="anggaran" id="keuangan" value="keuangan"> Keuangan
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div id="item_0" class="caption">
											Input Lain-lain
										</div>
									</div>
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-group">
												<label id="item_1" class="col-md-6 control-label align-left">Cari data kontrak</label>
												<div class="col-md-6">
													<?php echo form_dropdown("id_kontrak", $list_kontrak, '', 'id="id_kontrak" style="width:100%; " class="form-control select2me" disabled="disabled"'); ?>
												</div>
											</div>
											<a type="button" id="btncari" onclick="cari_kontrak()" class="btn green-meadow" style="display:none;"><i class="fa fa-search"></i> Cari</a>
											<hr />
											<div class="form-group">
												<label id="item_5" class="col-md-6 control-label align-left">Id Kontrak</label>
												<div class="col-md-6">
													<input type="text" id="id_kontrak_cari" name="id_kontrak_cari" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div id="item_2" class="form-group">
												<label class="col-md-6 control-label align-left">Nama Pekerjaan</label>
												<div class="col-md-6">
													<textarea id="nama_kontrak" name="nama_kontrak" class="form-control input-sm" rows="3" readonly></textarea>

												</div>
											</div>
											<div id="item_2" class="form-group">
												<label class="col-md-6 control-label align-left">Pembayaran untuk</label>
												<div class="col-md-6">
													<select id="nama_pekerjaan" name="nama_pekerjaan" class="form-control input-sm" disabled>
														<?php
														foreach ($info_jasa as $kolom) {
															echo "<option value='" . $kolom->uraian . "'>" . $kolom->uraian . "</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label id="item_5" class="col-md-6 control-label align-left">Jumlah Pembayaran (Rp.)</label>
												<div class="col-md-6">
													<input type="text" id="harga_satuan" name="harga_satuan" class="form-control input-sm mask_decimal" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Keterangan</label>
												<div class="col-md-6">
													<input type="text" id="keterangan" name="keterangan" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<a type="button" id="btnaddlain2" onclick="add_lain2()" class="btn yellow btn-block" style="display:none;">Tambahkan</a>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="row">
								<div class="col-md-6">
									<div class="portlet light bordered">
										<div class="portlet-body form-horizontal">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-6 control-label align-left">Apakah notanya tersedia ?</label>
													<div class="col-md-6">
														<div class="btn-group btn-group-justified" data-toggle="buttons">
															<label class="btn btn-default">
																<input type="radio" name="status_nota" id="nota_ada" value="1" class="toggle"> Ada </label>
															<label class="btn btn-default">
																<input type="radio" name="status_nota" id="nota_tidak" value="0" class="toggle"> Tidak Ada </label>
														</div>
													</div>
												</div>
												<div class="form-group" id="unggah_file" style="display:none;">
													<label class="col-md-6 control-label align-left">Unggah berkas nota</label>
													<div class="col-md-6">
														<input type="file" id="file_nota" name="file_nota" class="form-control">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12 ">
					<div class="portlet box green-meadow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Daftar Pembayaran
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								<div class="table-scrollable">
									<table class="table table-striped table-hover" id="tabel_lain2">
										<thead>
											<tr>
												<th width='50'>
													No.
												</th>
												<th>
													Id Kontrak
												</th>
												<th>
													Item Pembayaran
												</th>
												<th>
													Biaya Dibayarkan (Rp.)
												</th>
												<th>
													Aksi
												</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th></th>
												<th align='right' colspan="2"></th>
												<th></th>
												<th></th>
											</tr>
										</tfoot>
										<tbody id='isi_lain2'>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<a type="button" id="btnsimpan" onclick="simpan()" class="btn green-meadow btn-block" style="display:none;">Simpan</a>
				</div>
			</form>
		</div>
	  </div>
    </div>
  </div>
</div>
<!-- <div class="modal fade" id="test" tabindex="-1" role="dialog" aria-labelledby="modal_edit" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="judulModal">Edit Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="row">
			<form action="#" id="form" role="form" enctype="multipart/form-data">
				<div class="col-md-12 ">
					<div class="portlet box green-meadow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Entri Pembayaran
							</div>
						</div>
						<div class="portlet-body">

							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">

											<div class="form-group">
												<label class="col-md-6 control-label align-left">No. Register Nota</label>
												<div class="col-md-6">
													<input type="text" id="id_reg_nota" name="id_reg_nota" value="" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">No. Transaksi</label>
												<div class="col-md-6">
													<input type="text" id="id_transaksi" name="id_transaksi" value="" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>

											<div id="beli_11" class="form-group">
												<label id="beli_1" class="col-md-6 control-label align-left">Tanggal Pembayaran</label>
												<div class="col-md-6">
													<input type="text" id="tgl_pembelian" name="tgl_pembelian" class="form-control input-sm datepicker" placeholder="tahun-bulan-hari" required>
												</div>
											</div>
											<div id="beli_21" class="form-group">
												<label id="beli_2" class="col-md-6 control-label align-left">Pembayaran kepada</label>
												<div class="col-md-6">
													<input type="text" id="tempat_pembelian" name="tempat_pembelian" class="form-control input-sm" placeholder="Nama Penyedia" required>
												</div>
											</div>
											<div id="beli_31" class="form-group">
												<label id="beli_3" class="col-md-6 control-label align-left">Pengenaan PPN</label>
												<div class="col-md-6">
													<select id="ada_ppn" name="ada_ppn" class="form-control input-sm">
														<option value="tidak">TIDAK</option>
														<option value="ya">YA</option>
													</select>
												</div>
											</div>
											<div id="beli_41" class="form-group" style="display:none;">
												<label id="beli_4" class="col-md-6 control-label align-left">Nomor NPWP</label>
												<div class="col-md-6">
													<input type="text" id="no_npwp" name="no_npwp" class="form-control input-sm" placeholder=" " required>
												</div>
											</div>
											<a type="button" id="btnreload" onclick="reload()" class="btn red"><i class="fa fa-refresh"></i> Reset</a>
										</div>
									</div>
								</div>
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-6 control-label align-left">Dibayar dari </label>
													<div class="radio-list">
														<label class="radio-inline">
															<input type="radio" name="anggaran" id="kontraktor" value="kas kecil"> Kas Kecil
														</label>
														<label class="radio-inline">
															<input type="radio" name="anggaran" id="keuangan" value="keuangan"> Keuangan
														</label>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-title">
										<div id="item_0" class="caption">
											Input Lain-lain
										</div>
									</div>
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-group">
												<label id="item_1" class="col-md-6 control-label align-left">Cari data kontrak</label>
												<div class="col-md-6">
													<?php echo form_dropdown("id_kontrak", $list_kontrak, '', 'id="id_kontrak" style="width:100%; " class="form-control select2me" disabled="disabled"'); ?>
												</div>
											</div>
											<a type="button" id="btncari" onclick="cari_kontrak()" class="btn green-meadow" style="display:none;"><i class="fa fa-search"></i> Cari</a>
											<hr />
											<div class="form-group">
												<label id="item_5" class="col-md-6 control-label align-left">Id Kontrak</label>
												<div class="col-md-6">
													<input type="text" id="id_kontrak_cari" name="id_kontrak_cari" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div id="item_2" class="form-group">
												<label class="col-md-6 control-label align-left">Nama Pekerjaan</label>
												<div class="col-md-6">
													<textarea id="nama_kontrak" name="nama_kontrak" class="form-control input-sm" rows="3" readonly></textarea>

												</div>
											</div>
											<div id="item_2" class="form-group">
												<label class="col-md-6 control-label align-left">Pembayaran untuk</label>
												<div class="col-md-6">
													<select id="nama_pekerjaan" name="nama_pekerjaan" class="form-control input-sm" disabled>
														<?php
														foreach ($info_jasa as $kolom) {
															echo "<option value='" . $kolom->uraian . "'>" . $kolom->uraian . "</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label id="item_5" class="col-md-6 control-label align-left">Jumlah Pembayaran (Rp.)</label>
												<div class="col-md-6">
													<input type="text" id="harga_satuan" name="harga_satuan" class="form-control input-sm mask_decimal" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Keterangan</label>
												<div class="col-md-6">
													<input type="text" id="keterangan" name="keterangan" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<a type="button" id="btnaddlain2" onclick="add_lain2()" class="btn yellow btn-block" style="display:none;">Tambahkan</a>
										</div>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>

							<div class="row">
								<div class="col-md-6">
									<div class="portlet light bordered">
										<div class="portlet-body form-horizontal">
											<div class="form-body">
												<div class="form-group">
													<label class="col-md-6 control-label align-left">Apakah notanya tersedia ?</label>
													<div class="col-md-6">
														<div class="btn-group btn-group-justified" data-toggle="buttons">
															<label class="btn btn-default">
																<input type="radio" name="status_nota" id="nota_ada" value="1" class="toggle"> Ada </label>
															<label class="btn btn-default">
																<input type="radio" name="status_nota" id="nota_tidak" value="0" class="toggle"> Tidak Ada </label>
														</div>
													</div>
												</div>
												<div class="form-group" id="unggah_file" style="display:none;">
													<label class="col-md-6 control-label align-left">Unggah berkas nota</label>
													<div class="col-md-6">
														<input type="file" id="file_nota" name="file_nota" class="form-control">
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
				<div class="col-md-12 ">
					<div class="portlet box green-meadow">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Daftar Pembayaran
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body">
								<div class="table-scrollable">
									<table class="table table-striped table-hover" id="tabel_lain2">
										<thead>
											<tr>
												<th width='50'>
													No.
												</th>
												<th>
													Id Kontrak
												</th>
												<th>
													Item Pembayaran
												</th>
												<th>
													Biaya Dibayarkan (Rp.)
												</th>
												<th>
													Aksi
												</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th></th>
												<th align='right' colspan="2"></th>
												<th></th>
												<th></th>
											</tr>
										</tfoot>
										<tbody id='isi_lain2'>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<a type="button" id="btnsimpan" onclick="simpan()" class="btn green-meadow btn-block" style="display:none;">Simpan</a>
				</div>
			</form>
		</div>
    </div>
  </div>
</div> -->


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
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-migrate.min.js" type="text/javascript"></script>
<!-- IMPORTANT! Load jquery-ui.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/select2/select2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery.mockjax.js"></script>
<!-- END CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-pickers.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/components-dropdowns.js"></script>

<script src="<?php echo base_url(); ?>assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/datatables/js/dataTables.bootstrap.js"></script>
<script>
	jQuery(document).ready(function() {
		Metronic.init();
		Layout.init();
		Demo.init();
	});
</script>

</body>

</html>