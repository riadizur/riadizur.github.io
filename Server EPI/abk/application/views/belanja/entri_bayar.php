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

		get_id();
		$("#tabel_lain2").hide();

		$(':radio[id=kontraktor]').change(function() {
			$(':radio[id=keuangan]').attr('disabled', true);
			input_barang("ya");
		});

		$(':radio[id=keuangan]').change(function() {
			$(':radio[id=kontraktor]').attr('disabled', true);
			input_barang("ya");
		});

		$("#btnaddbarang").show();
		$("#btnsimpan").hide();

		$(".mask_decimal").inputmask({
			'alias': 'decimal',
			rightAlign: true,
			'groupSeparator': '.',
			'autoGroup': true
		});

		$("#ada_ppn").on("change", function() {
			var v = $(this).val();
			if (v == 'ya') {
				$("#beli_41").show();
			} else {
				$("#beli_41").hide();
			}
		});

		input_barang("tidak");

		//------------------------------------------------------------------

		$('#cari_kontrak').autocomplete({
			delay: 0,
			source: "<?php echo site_url('belanja/get_cari_kontrak/'); ?>",
			select: function(event, ui) {
				$('#cari_kontrak').val(ui.item.label);
				$('#id_kontrak').val(ui.item.id);
				return false;
			},
			focus: function(event, ui) {
				$("#cari_kontrak").val(ui.item.label);
				return false;
			}
		});
		$(':radio[name=status_nota]').change(function() {
			var v = $(this).val();
			if (v == '1') {
				$('#unggah_file').show();
			} else {
				$('#unggah_file').hide();
			}
		});

	});

	function input_barang(sts) {
		if (sts == 'ya') {
			$("#nama_kontrak").attr('readonly', false);
			$("#nama_pekerjaan").attr('disabled', false);
			$("#harga_satuan").attr('readonly', false);
			$("#keterangan").attr('readonly', false);

			$("#id_kontrak").attr('disabled', false);
			$("#btnaddlain2").hide();
			$("#btncari").show();
		} else {
			$("#nama_kontrak").attr('readonly', true);
			$("#nama_pekerjaan").attr('disabled', true);
			$("#harga_satuan").attr('readonly', true);
			$("#keterangan").attr('readonly', true);

			$("#id_kontrak").attr('disabled', true);
			$("#btnaddlain2").hide();
			$("#btncari").hide();
		}
	}

	function get_id() {
		$.ajax({
			url: "<?php echo site_url('belanja/get_id') ?>/",
			type: "POST",
			dataType: "JSON",
			success: function(data) {
				if (data.status) {
					$("#id_transaksi").val(data.id_transaksi);
					$("#id_reg_nota").val(data.id_reg_nota);
				} else {
					alert('Hubungi admin untuk menambahkan data ini');
				}

			},
			error: function(jqXHR, textStatus, errorThrown) {
				alert('Hubungi admin untuk menambahkan data ini');
			}
		});
	}

	function add_lain2() {
		var a = $("#harga_satuan").val();
		var b = $("#tgl_pembelian").val();
		var c = $("#tempat_pembelian").val();

		if (a != '' && b != '' && c != '') {
			$.ajax({
				url: "<?php echo site_url('belanja/add_lain2') ?>/",
				type: "POST",
				data: {
					id_kontrak: document.getElementById('id_kontrak_cari').value,
					id_reg_nota: document.getElementById('id_reg_nota').value,
					id_transaksi: document.getElementById('id_transaksi').value,
					ada_ppn: document.getElementById('ada_ppn').value,
					nama_barang: document.getElementById('nama_pekerjaan').value,
					harga_satuan: document.getElementById('harga_satuan').value,
					keterangan: document.getElementById('keterangan').value,
				},
				dataType: "JSON",
				success: function(data) {
					if (data.status) {
						$("#nama_kontrak").attr('readonly', true);
						$("#harga_satuan").val('');
						$("#keterangan").val('');
						show_lain2();
						$("#btnsimpan").show();

						$("#tgl_pembelian").attr('readonly', true);
						$("#tempat_pembelian").attr('readonly', true);
						$("#ada_ppn").attr('readonly', true);
						$("#no_npwp").attr('readonly', true);

					} else {
						alert('Hubungi admin untuk menambahkan data ini');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Hubungi admin untuk menambahkan data ini');
				}
			});
		} else {
			alert("Pastikan semua inputan telah terisi!");
		}
	}

	function show_lain2() {
		$("#tabel_lain2").show();
		$('#tabel_lain2').DataTable({
			destroy: true,
			"paging": false,
			"ordering": false,
			"info": false,
			"searching": false,
			"processing": true,
			"serverSide": false,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('belanja/list_lain2') ?>",
				"type": "POST",
				data: {
					id_transaksi: document.getElementById("id_transaksi").value,
					id_reg_nota: document.getElementById("id_reg_nota").value,
				}
			},
			"columnDefs": [{
				"className": "text-center",
				"targets": [0, 1, 2, 3, 4],
			}],
			"footerCallback": function(row, data, start, end, display) {
				var api = this.api(),
					data;

				// converting to interger to find total
				var intVal = function(i) {
					return typeof i === 'string' ?
						i.replace(/[\$,]/g, '') * 1 :
						typeof i === 'number' ?
						i : 0;
				};

				// computing column Total of the complete result
				var tot_biaya = api
					.column(3)
					.data()
					.reduce(function(a, b) {
						return intVal(a) + intVal(b);
					}, 0);

				// Update footer by showing the total with the reference of the column index
				$(api.column(1).footer()).html('Total Biaya');
				$(api.column(3).footer()).html(tot_biaya.toLocaleString('en-US'));
			},
		});
	}

	function simpan() {
		var a = document.getElementById("tgl_pembelian").value;
		var b = document.getElementById("tempat_pembelian").value;
		var c = document.querySelector('input[name="anggaran"]:checked').value;
		if (a != '' && b != '' && c != '') {
			var formData = new FormData($('#form')[0]);
			var url = "<?php echo site_url('belanja/belanja_simpan_lain2') ?>";
			$.ajax({
				url: url,
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				dataType: "JSON",
				success: function(datas) {
					if (datas.status) {
						alert("sukses");
						location.reload();
					} else {
						alert("Proses penyimpanan gagal ");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Proses penyimpanan gagal');
				}
			});
		} else {
			alert("Isi data terlebih dahulu!");
		}
	}

	function del_barang(id_barang) {
		if (confirm('Yakin anda ingin menghapus ?')) {
			$.ajax({
				url: "<?php echo site_url('belanja/delete_barang_detil') ?>/" + id_barang,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					show_lain2();
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Hubungi admin untuk mengeluarkan data ini');
				}
			});
		}
	}

	function cari_kontrak() {
		var a = document.getElementById('id_kontrak').value;
		var b = $("#tgl_pembelian").val();
		var c = $("#tempat_pembelian").val();

		if (a != '' && b != '' && c != '') {
			$.ajax({
				url: "<?php echo site_url('belanja/get_data_kontrak') ?>/",
				type: "POST",
				data: {
					id_kontrak: document.getElementById('id_kontrak').value,
				},
				dataType: "JSON",
				success: function(data) {
					if (data.status) {
						$("#nama_kontrak").val(data.nama_pekerjaan);
						$("#id_kontrak_cari").val(data.id_kontrak);
						$("#nama_kontrak").attr('readonly', true);
						$("#id_kontrak").attr('disabled', true);
						$("#btncari").hide();
						$("#btnaddlain2").show();
						$("#btnaddlain2").attr('disabled', false);
					} else {
						alert('Hubungi admin untuk menambahkan data ini');
					}

				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Hubungi admin untuk menambahkan data ini');
				}
			});
		} else {
			alert("Isi data dengan lengkap terlebih dahulu!");
		}
	}

	function simpan_pelunasan() {
		var a = document.getElementById("pelunasan_total").value;
		var b = document.getElementById("pelunasan_dp").value;
		var c = document.getElementById("pelunasan_sisa").value;
		var hasil = a - b;
		if (c == hasil) {
			var url = "<?php echo site_url('belanja/pelunasan_simpan') ?>";
			$.ajax({
				url: url,
				type: "POST",
				data: {
					id_transaksi: document.getElementById("id_transaksi").value,
					id_reg_nota: document.getElementById("id_reg_nota").value,
					anggaran: document.querySelector('input[name="anggaran"]:checked').value,
					total_belanja: document.getElementById("pelunasan_sisa").value,
					tgl_pembelian: document.getElementById("pelunasan_tanggal").value,
				},
				dataType: "JSON",
				success: function(datas) {
					if (datas.status) {
						alert("sukses");
						location.reload();
					} else {
						alert("Proses penyimpanan gagal ");
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Proses penyimpanan gagal');
				}
			});
		} else {
			alert("Angka pelunasan masih ada kekurangan / kelebihan!");
		}

	}

	function reload() {
		if (confirm('Yakin anda ingin reset semua isi ? ')) {
			$.ajax({
				url: "<?php echo site_url('belanja/hapus_list') ?>/",
				type: "POST",
				data: {
					id_reg_nota: document.getElementById('id_reg_nota').value
				},
				dataType: "JSON",
				success: function(data) {
					if (data.status) {
						location.reload();
					} else {
						alert('Hubungi admin untuk penghapusan data ini');
					}

				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Hubungi admin untuk masalah penghapusan data ini');
				}
			});
		}
	}

	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))

			return false;
		return true;
	}
</script>
<div class="page-head">
	<div class="page-title">
		<h1>Input Pembayaran<small>Belanja</small></h1>
	</div>
	<div class="page-toolbar">
		<div class="btn-group btn-theme-panel">
		</div>
	</div>
</div>
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
<script type="text/javascript" src="<?php echo base_url(); ?>assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
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