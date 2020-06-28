			<div class="page-head">
				<div class="page-title">
					<h1>Data <small>Kontrak Pekerjaan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box green-jungle">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Form Kontrak Baru
							</div>
						</div>
						<div class="portlet-body">
							<div class="portlet-body form">
								<form action="#" id="form" class="form-horizontal" role="form" enctype="multipart/form-data">
									<input type="hidden" value="" name="id"/>
									<div class="form-body">
										<div class="row">
											<div class="col-md-6">
												<div class="panel panel-success">
													<div class="panel-body form-horizontal">
														<div class="form-group">
															<label class="col-md-4 control-label align-left">No. Register Kontrak</label>
															<div class="col-md-8">
																<input type="text" name="no_reg_pekerjaan" id="no_reg_pekerjaan" class="form-control input-sm" placeholder=" " readonly="true">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
															<div class="col-md-8">
																<input type="text" name="nama_pekerjaan" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<h4 class="text-success">Lokasi Pekerjaan</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left text-success">Alamat</label>
															<div class="col-md-8">
																<input type="text" name="lokasi_pekerjaan" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left text-success">Provinsi</label>
															<div class="col-md-8">
																<select class="form-control input-sm" style="width:100%;" id="prov" name="prov" data-placeholder="-Pilih-">
																	<option value="">-Pilih-</option>
																	<?php
																	foreach ($prov_list as $r)
																	{
																		echo "<option value =".$r->id_prov.">".$r->nama."</option>";
																	}
																	?>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left text-success">Kota</label>
															<div class="col-md-8">
																<select class="form-control input-sm" style="width:100%;" id="kab" name="kab" data-placeholder="-Pilih-">
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left text-success">Kecamatan</label>
															<div class="col-md-8">
																<select class="form-control input-sm" style="width:100%;" id="kec" name="kec" data-placeholder="-Pilih-">
																</select>
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
															<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
															<div class="col-md-8">
																<input type="text" id = 'mask_decimal' name="nilai_oe" class="form-control input-sm" placeholder=" " required>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Pemilik Pekerjaan</label>
															<div class="col-md-8">
																<select class="form-control input-sm" id="divisi" name="divisi">
																	<option value = "">-Pilih-</option>
																	<option value = "teknik">Divisi Teknik</option>
																	<option value = "operasi">Divisi Operasi</option>
																	<option value = "niaga">Divisi Niaga</option>
																	<option value = "sdm">Divisi SDM</option>
																	<option value = "keuangan">Divisi Keuangan</option>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
															<div class="col-md-8">
																<input type="number" name="durasi" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
															<div class="col-md-8">
																<select class="form-control input-sm" id="metode_pengadaan" name="metode_pengadaan">
																	<option value = "">-Pilih-</option>
																	<?php
																	foreach ($list_pengadaan as $r)
																	{
																		echo "<option value ='".$r->isi."'>".$r->isi."</option>";
																	}
																	?>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
															<div class="col-md-8">
																<select class="form-control input-sm" id="jenis_pengadaan" name="jenis_pengadaan">
																	<option value = "">-Pilih-</option>
																	<?php
																	foreach ($list_jenis as $r)
																	{
																		echo "<option value = '".$r->isi."'>".$r->isi."</option>";
																	}
																	?>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="panel panel-success">
													<div class="panel-body form-horizontal">

														<div class="form-group">
															<label class="col-md-4 control-label align-left">Klasifikasi / Kategori Pekerjaan</label>
															<div class="col-md-8">
																<div class="input-group">
																	<span class="input-group-btn">
																		<a type="button" id="btn_add_bidang" onclick="add_bidang()" class="btn btn-sm purple"><i class="glyphicon glyphicon-plus" title="Tambah Bidang"></i></a>
																	</span>
																	<select class="form-control input-sm" style="width:100%;" id="bidang_pekerjaan" name="bidang_pekerjaan" data-placeholder="-Pilih-">
																	</select>
																</div>
																<span class="help-block"></span>
															</div>
														</div>
														<input type="hidden" id="last_bidang" name="last_bidang" class="form-control input-sm"/>
														<div class="table-scrollable">
															<table class="table table-striped table-hover" id="tabel_bidang">
																<thead>
																	<tr>
																		<th width='50'>
																			 #
																		</th>
																		<th>
																			 Nama Bidang
																		</th>
																		<th width = "70">
																			 <a class="btn btn-sm red" onclick="removeAll_bidang()" title="Hapus semua list"><i class="glyphicon glyphicon-minus"></i> Reset All</a>
																		</th>
																	</tr>
																</thead>
																<tbody id='isi_bidang'>
																</tbody>
															</table>
														</div>

														<div class="form-group">
															<label class="col-md-4 control-label align-left">Sub Klasifikasi / Kategori Pekerjaan</label>
															<div class="col-md-8">
																<div class="input-group">
																	<span class="input-group-btn">
																		<a type="button" id="btn_add_sub_bidang" onclick="add_sub_bidang()" class="btn btn-sm purple"><i class="glyphicon glyphicon-plus" title="Tambah Sub Bidang"></i></a>
																	</span>
																	<select class="form-control input-sm" style="width:100%;" id="sub_bidang_pekerjaan" name="sub_bidang_pekerjaan" data-placeholder="-Pilih-">
																	</select>
																</div>
																<span class="help-block"></span>
															</div>
														</div>
														<input type="hidden" id="last_sub_bidang" name="last_sub_bidang" class="form-control input-sm"/>
														<div class="table-scrollable">
															<table class="table table-striped table-hover" id="tabel_sub_bidang">
																<thead>
																	<tr>
																		<th width='50'>
																			 #
																		</th>
																		<th>
																			 Nama Sub Bidang
																		</th>
																		<th width = "70">
																			 <a class="btn btn-sm red" onclick="removeAll_bidang()" title="Hapus semua list"><i class="glyphicon glyphicon-minus"></i> Reset All</a>
																		</th>
																	</tr>
																</thead>
																<tbody id='isi_sub_bidang'>
																</tbody>
															</table>
														</div>

													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="panel panel-success">
													<div class="panel-body form-horizontal">
														<div class="form-group">
															<label class="col-md-4 control-label align-left">PIC Tim Pengadaan</label>
															<div class="col-md-8">
																<select class="form-control input-sm" id="nama_pic" name="nama_pic">
																	<option value = "">-Pilih-</option>
																	<?php
																	foreach ($list_user as $r)
																	{
																		echo "<option value ='".$r->isi."'>".$r->isi."</option>";
																	}
																	?>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="form-actions right">
										<button type="button" id="btnSave" onclick="save()" class="btn green-jungle">Simpan</button>
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
<script type="text/javascript" src="../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
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
var urut_siup = 0;
var urut_siujk = 0;
var urut_siu = 0;

$(document).ready(function() {

	$('.datepicker').datepicker({
      autoclose: true,
      format: "yyyy-mm-dd",
      todayHighlight: true,
      orientation: "top auto",
      todayBtn: true,
      todayHighlight: true,
  });

	var dates = new Date();
	var no_reg = "kp-" + formatDate(dates) + "xxx";
	$('[name="no_reg_pekerjaan"]').val(no_reg);

	$("#mask_decimal").inputmask({
    'alias': 'decimal',
    rightAlign: true,
    'groupSeparator': '.',
    'autoGroup': true
  });

});

function formatDate(d)
{
    var month = d.getMonth();
    var day = d.getDate().toString();
    var year = d.getFullYear();

    year = year.toString().substr(-2);
    month = (month + 1).toString();
		if (month.length === 1)
    {
        month = "0" + month;
    }

		if (day.length === 1)
    {
        day = "0" + day;
    }

		return year + month + day;
}

function save()
{
	save_method = 'add';

  $('#btnSave').text('Sedang proses simpan...');
  $('#btnSave').attr('disabled',true);
  var url;

  if(save_method == 'add') {
      url = "<?php echo site_url('kontrak/kontrak_add')?>";
  } else {
      url = "<?php echo site_url('kontrak/kontrak_update')?>";
  }

	var formData = new FormData($('#form')[0]);
  $.ajax({
      url : url,
      type: "POST",
      data: formData,
			contentType: false,
			processData: false,
			dataType: "JSON",
      success: function(data)
      {
        if(data.status)
        {
          alert("sukses");
					location.reload();
        }
				else
				{
					alert("Ups, ada kekurangan dalam inputan!");
					for (var i = 0; i < data.inputerror.length; i++)
					{
						switch (data.inputerror[i])
						{
							default:
								$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
								$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
								break;
						}
					}
				}
        $('#btnSave').text('Simpan');
        $('#btnSave').attr('disabled',false);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding data, hubungi admin');
        $('#btnSave').text('save');
        $('#btnSave').attr('disabled',false);
      }
  });
}

$("#prov").on("change", function(){
	var v = $(this).val();
	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/get_chain_kab/'+v;
	removeOptions(document.getElementById("kab"));
	var kab = ["-Pilih-"];
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

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
});

$("#kab").on("change", function(){
	var v = $(this).val();
	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/get_chain_kec/'+v;
	removeOptions(document.getElementById("kec"));
	var kec = ["-Pilih-"];
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

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
});

$("#jenis_pengadaan").on("change", function(){
	removeAll_bidang();
	removeAll_sub_bidang();
	var v = $(this).val();
	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/bidang_pekerjaan/'+v;
	removeOptions(document.getElementById("bidang_pekerjaan"));
	var bidang_pekerjaan = ["-Pilih-"];
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			$.map(datas, function (obj) {
				bidang_pekerjaan.push({
					 'id': obj.jenis+'-'+obj.id,
					 'text': obj.isi
				});
				return bidang_pekerjaan;
			});
			$("#bidang_pekerjaan").select2({
				placeholder: "Pilih",
				data: bidang_pekerjaan,
				width: '100%'
			});

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
		}
	});
});

var urut_bidang = 0;
function add_bidang()
{
	var a = document.getElementById("bidang_pekerjaan");
	var b = a.options[a.selectedIndex].value;
	var c = a.options[a.selectedIndex].text;

	if (b == '' || b == '-Pilih-') {
		alert('Pilih bidang terlebih dahulu');
	} else {
		urut_bidang = urut_bidang + 1;
		var tabel = "tabel_bidang";
		var kolom_1 = "<td>"+urut_bidang+"</td>";
		var kolom_2 = "<td>"+c+"</td>";
		var kolom_3 = "<td></td>";
		var kolom_4 = '<input type="hidden" value="'+b+'" name="list_bidang_'+urut_bidang+'" />';
		addElement(tabel, urut_bidang, kolom_1, kolom_2, kolom_3, kolom_4);
		$('#last_bidang').val(urut_bidang);

		tampil_sub_bidang();
	}
}

function tampil_sub_bidang()
{
	url = "<?php echo site_url('kontrak/kontrak_add_sub_bidang')?>";
	removeOptions(document.getElementById("sub_bidang_pekerjaan"));
	var sub_bidang_pekerjaan = ["-Pilih-"];
	var formData = new FormData($('#form')[0]);
  $.ajax({
      url : url,
      type: "POST",
      data: formData,
			contentType: false,
			processData: false,
			dataType: "JSON",
      success: function(datas)
      {
				$.map(datas, function (obj) {
					sub_bidang_pekerjaan.push({
						 'id': obj.kode,
						 'text': obj.kode+" - "+obj.deskripsi
					});
					return sub_bidang_pekerjaan;
				});
				$("#sub_bidang_pekerjaan").select2({
					placeholder: "Pilih",
					data: sub_bidang_pekerjaan,
					width: '100%'
				});
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        alert('Error adding data, hubungi admin');
        $('#btnSave').text('save');
        $('#btnSave').attr('disabled',false);
      }
  });
}

var urut_sub_bidang = 0;
function add_sub_bidang()
{
	var a = document.getElementById("sub_bidang_pekerjaan");
	var b = a.options[a.selectedIndex].value;
	var c = a.options[a.selectedIndex].text;

	if (b == '' || b == '-Pilih-') {
		alert('Pilih sub bidang terlebih dahulu');
	} else {
		urut_sub_bidang = urut_sub_bidang + 1;
		var tabel = "tabel_sub_bidang";
		var kolom_1 = "<td>"+urut_sub_bidang+"</td>";
		var kolom_2 = "<td>"+c+"</td>";
		var kolom_3 = "<td></td>";
		var kolom_4 = '<input type="hidden" value="'+b+'" name="list_sub_bidang_'+urut_sub_bidang+'" />';
		addElement(tabel, urut_sub_bidang, kolom_1, kolom_2, kolom_3, kolom_4);
		$('#last_sub_bidang').val(urut_sub_bidang);
	}
}

function addElement(tabel, urut, kolom_1, kolom_2, kolom_3, kolom_4)
{
	$('#'+tabel+'> tbody:last-child').append('<tr id="'+urut+'">'+kolom_1+kolom_2+kolom_3+kolom_4+'</tr>');
}

function removeAll_bidang() {
	var tabel = "tabel_bidang";
	var urut = document.getElementById("last_bidang").value;
	removeOptions(document.getElementById("bidang_pekerjaan"));
	urut_bidang = 0;
	for (var i = 1; i <= urut; i++)
	{
		$('table#'+tabel+' tr#'+i+'').remove();
	}
	removeAll_sub_bidang();
	removeOptions(document.getElementById("sub_bidang_pekerjaan"));
	//$("#jenis_pengadaan").val(0);
}

function removeAll_sub_bidang() {
	var tabel = "tabel_sub_bidang";
	var urut = document.getElementById("last_sub_bidang").value;
	//removeOptions(document.getElementById("sub_bidang_pekerjaan"));
	urut_sub_bidang = 0;
	for (var j = 1; j <= urut; j++)
	{
		$('table#'+tabel+' tr#'+j+'').remove();
	}
}

function removeOptions(selectbox){
	var i;
	for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
	{
		selectbox.remove(i);
	}
}

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))

	return false;
  return true;
}


</script>
</body>
</html>
