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
  
	$('#jns_pekerjaan').on("change", function(){
		var v = $(this).val();
		if (v == 'pelayanan_pelanggan'){
			get_agenda();
			$("#daftar_agenda").show();
			$("#daftar_kontrak").hide();
			$("#jns_pekerjaan").attr("readonly",true);
			$("#no_kontrak").hide();
			$("#input_kt").hide();
			$("#input_jk").hide();
			$("#input_nomor").html('No. Agenda');
			$("#input_dt").hide();
		}else if(v == 'kontraktor'){
			$("#daftar_agenda").hide();
			$("#jns_pekerjaan").attr("readonly",true);
			$("#input_jk").show();
			$("#input_nomor").html('No. Kontrak Induk');
			$("#input_dt").hide();
		}else{			
			get_divisi();
			$("#input_kt").hide();
			$("#daftar_agenda").hide();
			$("#daftar_kontrak").hide();
			$("#no_kontrak").show();
			$("#jns_pekerjaan").attr("readonly",true);
			$("#input_jk").hide();
			$("#input_dt").show();
			$("#input_nomor").html('Bulan pelaksanaan');
			$("#jns_kontrak").val('').attr('disabled',true);
		}
	});
  
	$('#jenis_kontraktor').on("change", function(){
		var v = $(this).val();
		if (v == 'induk'){
			//$("#daftar_kontrak").hide();
			$('#daftar_kontrak').next(".select2-container").hide();
            $("#input_kt").hide();
			$("#input_nomor").html('No. Kontrak');
			$("#no_kontrak").show();
			$("#no_kontrak_turunan").val('');
		}else if (v == 'turunan'){
			get_kontrak();
			$("#daftar_kontrak").show();
			$("#no_kontrak").show();
			$("#input_nomor").html('No. Kontrak Induk');
			$("#input_kt").show();
			$("#no_kontrak_turunan").val('');
		}
	});
	
	$('#daftar_agenda').on("change", function(){
		var v = $(this).val();
		var url = "<?php echo site_url('kontrak/id_pemeliharaan')?>";
		$.ajax({
			url : url,
			type: "POST",
			dataType: "JSON",
			success: function(datas)
			{
				$("#id_kontrak").val(datas);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Proses penyimpanan gagal');
			}
		});
		
		var link = "<?php echo site_url('kontrak/get_data_agenda')?>";
		$.ajax({
			url : link,
			type: "POST",
			data:{id:v,},
			dataType: 'json',
			success: function(datas){
				let nama = datas.JNS_TRANSAKSI+', '+datas.NAMA_LANG;
				$("#nama_pekerjaan").val(nama);
				
				let lokasi = datas.ALAMAT_LANG;
				$("#lokasi_pekerjaan").val(lokasi);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Proses menampilkan gagal');
			}
		});
		
		$("#no_kontrak").val(v);
	});
	
	$('#daftar_kontrak').on("change", function(){
		var v = $(this).val();
		$("#no_kontrak").val(v);
	});

	$("#kd_area").on("change", function(){
		var nilai = $(this).val();
		let v = nilai.substring(0,2);
		var baseUrl = '<?php echo base_url(); ?>kontrak/get_kab/'+v;
		removeOptions(document.getElementById("kab"));
		var kab = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kab.push({
					   'id': obj.id_kab,
					   'text': obj.nama
					});
					return kab;

				});
				$("#kab").select2({
					placeholder: "Pilih",
					data: kab,
					width: '100%'
				});
				$("#kab2").hide();
				$("#prov").val(v).trigger('change');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});
	});

	$("#kab").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>kontrak/get_kec/'+v;
		removeOptions(document.getElementById("kec"));
		var kec = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kec.push({
					   'id': obj.id_kec,
					   'text': obj.nama
					});
					return kec;

				});
				$("#kec").select2({
					placeholder: "Pilih",
					data: kec,
					width: '100%'
				});
				$("#kec2").hide();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
	});

	$("#pemberi_pekerjaan2").show();
	$("#pemberi_pekerjaan").hide();

	$("#klp_pemberi_kerja").on("change", function(){
		var v = $(this).val();
		$("#pemberi_pekerjaan2").hide();
		$("#pemberi_pekerjaan").show();

		var baseUrl = '<?php echo base_url(); ?>kontrak/get_pt/';
		removeOptions(document.getElementById("pemberi_pekerjaan"));
		var pemberi_pekerjaan = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			type: "POST",
			data:{id:v,},
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					pemberi_pekerjaan.push({
					   'id': obj.id_cust,
					   'text': obj.nama_cust,
					});
					return pemberi_pekerjaan;
				});
				$("#pemberi_pekerjaan").select2({
					placeholder: "Pilih",
					data: pemberi_pekerjaan,
					width: '100%'
				});

			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});

	});
	
	$("#pemberi_pekerjaan").on("change", function(){
		var tampil = $(this).val();
		var panjang_tampil = tampil.length;
		var nilai = document.getElementById("klp_pemberi_kerja").value;
		var panjang = nilai.length;
		
		if(panjang_tampil > 20){
			//$("#no_kontrak").val(tampil);
			//$("#nama_pekerjaan").val(tampil);
			id_pemeliharaan(panjang_tampil);
		}
	});

	$("#durasi_kontrak").on("change", function(){
		var hari = $(this).val();
		var tglawal  = $("#mulai_kontrak").datepicker('getDate');
		var durasi = 1*hari;
		tglawal.setDate(tglawal.getDate() + durasi);
		$('#akhir_kontrak').datepicker('setDate', tglawal);
	});
	
	$("#nilai_kontrak").on("change", function(){
		var ini = $(this).val();
		var nilai = ini.replace(/[^0-9.-]+/g,"");
		var estimasi = nilai*0.85;
		$('#estimasi_biaya').val(estimasi);
	});

	$(".mask_decimal").inputmask({
		'alias': 'decimal',
		rightAlign: true,
		'groupSeparator': '.',
		'autoGroup': true
	});

});

function get_agenda(){
	var baseUrl = '<?php echo base_url(); ?>kontrak/get_agenda/';
	removeOptions(document.getElementById("daftar_agenda"));
	var daftar_agenda = ["--Pilih--"];
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			$.map(datas, function (obj) {
				daftar_agenda.push({
				   'id': obj.id,
				   'text': obj.ket
				});
				return daftar_agenda;

			});
			$("#daftar_agenda").select2({
				placeholder: "Pilih",
				data: daftar_agenda,
				width: '100%'
			});
			$("#no_kontrak").hide();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
}

function get_kontrak(){
	var baseUrl = '<?php echo base_url(); ?>kontrak/get_kontrak/';
	removeOptions(document.getElementById("daftar_kontrak"));
	var daftar_kontrak = ["--Pilih--"];
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			$.map(datas, function (obj) {
				daftar_kontrak.push({
				   'id': obj.id,
				   'text': obj.ket
				});
				return daftar_kontrak;

			});
			$("#daftar_kontrak").select2({
				placeholder: "Pilih",
				data: daftar_kontrak,
				width: '100%'
			});
			$("#no_kontrak").hide();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
}

function get_divisi(){
	var baseUrl = '<?php echo base_url(); ?>kontrak/get_divisi/';
	removeOptions(document.getElementById("daftar_divisi"));
	var daftar_divisi = ["--Pilih--"];
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			$.map(datas, function (obj) {
				daftar_divisi.push({
				   'id': obj.id,
				   'text': obj.ket
				});
				return daftar_divisi;

			});
			$("#daftar_divisi").select2({
				placeholder: "Pilih",
				data: daftar_divisi,
				width: '100%'
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
}

function id_pemeliharaan(panjang){
	if(panjang > 22){
		var url = "<?php echo site_url('kontrak/id_pemeliharaan')?>";
		$.ajax({
			url : url,
			type: "POST",
			dataType: "JSON",
			success: function(datas)
			{
				$("#id_kontrak").val(datas);
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
				alert('Proses penyimpanan gagal');
			}
		});
	}
}

function removeOptions(selectbox){
	var i;
	for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
	{
		selectbox.remove(i);
	}
}

function simpan()
{
	var a = document.getElementById("nama_pekerjaan").value;
	var b = document.getElementById("nilai_kontrak").value;
	if (a != '' && b != '') {
		var url = "<?php echo site_url('kontrak/kontrak_simpan')?>";
	  $.ajax({
	      url : url,
	      type: "POST",
	      data: $('#form').serialize(),
				dataType: "JSON",
	      success: function(datas)
	      {
	        if(datas.status)
	        {
				alert("sukses");
				location.reload();
	        }
			else
			{
				alert("Proses penyimpanan gagal ");
			}
	      },
	      error: function (jqXHR, textStatus, errorThrown)
	      {
	        alert('Proses penyimpanan gagal');
	      }
	  });
	} else {
		alert("Isi data terlebih dahulu!");
	}

}

function hanyaAngka(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode
	if (charCode > 31 && (charCode < 48 || charCode > 57))

	return false;
	return true;
}

</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Input Kontrak Pekerjaan<small>Kontrak</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
				<form action="#" id="form" class="form-horizontal" role="form">
				<div class="col-md-12 ">
					<div class="portlet box red-pink">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Form Entri
							</div>
						</div>
						<div class="portlet-body">

							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Id Kontrak</label>
												<div class="col-md-6">
													<input type="text" id="id_kontrak" name="id_kontrak" class="form-control input-sm" value="<?php echo $id_kontrak;?>" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Jenis Pekerjaan</label>
												<div class="col-md-6">
													<select class="form-control input-sm" name="jns_pekerjaan" id="jns_pekerjaan" >
														<option value="">-Pilih-</option>
														<option value="kontraktor">Kontraktor</option>
														<option value="pemeliharaan">Pemeliharaan</option>
														<option value="pelayanan_pelanggan">Permohonan pelanggan</option>
													</select>
												</div>
											</div>
											<div class="form-group" id="input_jk" style="display:none;">
												<label class="col-md-6 control-label align-left">Jenis Kontraktor</label>
												<div class="col-md-6">
													<select class="form-control input-sm" name="jenis_kontraktor" id="jenis_kontraktor" >
														<option value="">-Pilih-</option>
														<option value="induk">Kontrak Induk</option>
														<option value="turunan">Kontrak Turunan</option>
													</select>
												</div>
											</div>
											<div class="form-group" id="input_dt" style="display:none;">
												<label class="col-md-6 control-label align-left">Divisi Terkait</label>
												<div class="col-md-6">
													<?php echo form_dropdown('daftar_divisi', array(), '', 'id="daftar_divisi" '); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" id="input_nomor">No. Kontrak</label>
												<div class="col-md-6">
													<input type="text" id="no_kontrak" name="no_kontrak" class="form-control input-sm" placeholder=" " required>
													<?php echo form_dropdown('daftar_agenda', array(), '', 'id="daftar_agenda" style="display:none;"'); ?>
													<?php echo form_dropdown('daftar_kontrak', array(), '', 'id="daftar_kontrak" style="display:none;"'); ?>
												</div>
											</div>
											
											<div class="form-group" id="input_kt" style="display:none;">
												<label class="col-md-6 control-label align-left" >No. Kontrak Turunan</label>
												<div class="col-md-6">
													<input type="text" id="no_kontrak_turunan" name="no_kontrak_turunan" class="form-control input-sm" placeholder=" " required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Jenis Kontrak Pekerjaan</label>
												<div class="col-md-6">
													<select class="form-control input-sm" name="jns_kontrak" id="jns_kontrak" >
														<option value="">-Pilih-</option>
														<option value="khs">KHS</option>
														<option value="proyek">Proyek</option>
														<option value="yantek">Yantek</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Nama Pekerjaan</label>
												<div class="col-md-6">
													<textarea id="nama_pekerjaan" name="nama_pekerjaan" class="form-control input-sm" placeholder=" " required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Lokasi Pekerjaan</label>
												<div class="col-md-6">
													<textarea id="lokasi_pekerjaan" name="lokasi_pekerjaan" class="form-control input-sm" placeholder=" " required></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kode Area</label>
												<div class="col-md-6">
													<?php
														$atribut_kd_area = 'id="kd_area" class="form-control select2me"';
														echo form_dropdown('kd_area', $kd_area, '', $atribut_kd_area);
													?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Provinsi</label>
												<div class="col-md-6">
													<?php
														$atribut_prov = 'id="prov" class="form-control select2me"';
														echo form_dropdown('prov', $prov, '', $atribut_prov);
													?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kota</label>
												<div class="col-md-6">
													<input type="text" name="kab2" id="kab2" class="form-control input-sm" placeholder=" " >
													<?php echo form_dropdown('kab', array(), '', 'id="kab" style="display:none;"'); ?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kecamatan</label>
												<div class="col-md-6">
													<input type="text" name="kec2" id="kec2" class="form-control input-sm" placeholder=" " >
													<?php echo form_dropdown('kec', array(), '', 'id="kec" style="display:none;"'); ?>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="portlet light bordered">
									<div class="portlet-body form-horizontal">
										<div class="form-body">
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Nilai Kontrak (Rp.) (Inc. PPN)</label>
												<div class="col-md-6">
													<input type="text" id="nilai_kontrak" name="nilai_kontrak"  class="form-control input-sm mask_decimal" placeholder=" " required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Estimasi Biaya (Rp.)</label>
												<div class="col-md-6">
													<input type="text" id="estimasi_biaya" name="estimasi_biaya"  class="form-control input-sm mask_decimal" placeholder=" " required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Tanggal Mulai</label>
												<div class="col-md-6">
													<input type="text" id="mulai_kontrak" name="mulai_kontrak" class="form-control input-sm datepicker" placeholder=" " required>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Durasi Kontrak (Hari)</label>
												<div class="col-md-6">
													<select id="durasi_kontrak" name="durasi_kontrak" class="form-control select2me">
														<option value=""></option>
														<?php
														for ($i=0; $i < 1000; $i++) {
															echo "<option value='".$i."'>".$i." Hari</option>";
														}
														?>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Tanggal Akhir</label>
												<div class="col-md-6">
													<input type="text" id="akhir_kontrak" name="akhir_kontrak" class="form-control input-sm datepicker" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kelompok Pemberi Pekerjaan</label>
												<div class="col-md-6">
													<?php
														$atribut_pemberi_kerja = 'id="klp_pemberi_kerja" class="form-control select2me"';
														echo form_dropdown('klp_pemberi_kerja', $tp_klp, '', $atribut_pemberi_kerja);
													?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Pemberi Kontrak</label>
												<div class="col-md-6">
													<input type="text" name="pemberi_pekerjaan2" id="pemberi_pekerjaan2" class="form-control input-sm" placeholder=" " readonly>
													<?php echo form_dropdown('pemberi_pekerjaan', array(), '', 'id="pemberi_pekerjaan"'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

                            

							<div class="clearfix"></div>
							<a type="button" id="btnsimpan" onclick="simpan()" class="btn red-pink btn-block">Simpan</a>
						</div>
					</div>
				</div>

				<div class="clearfix"></div>
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
