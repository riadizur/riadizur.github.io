			<div class="page-head">
				<div class="page-title">
					<h1>Penilaian <small>Kontrak Pekerjaan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="tabbable-custom nav-justified">
						<ul class="nav nav-tabs nav-justified">
							<li class="active">
								<a href="#tab_1_1" data-toggle="tab">
								Penilaian Pelaksanaan Pekerjaan </a>
							</li>
						</ul>
						<div class="tab-content">

							<div class="tab-pane active" id="tab_1_1">
								<div class="portlet solid red-pink col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Kontrak </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data" id="cari_data_kontrak" class="form-control input-sm" placeholder="Cari..." >
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_penilaian()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
												<input type="hidden" name="cari_id_kontrak" id="cari_id_kontrak"/>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="portlet box red-pink">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Vendor Peserta Pengadaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Kontrak</label>
														<div class="col-md-8">
															<input type="text" name="no_kontrak" id="no_kontrak" class="form-control input-sm" placeholder=" " readonly="true"/>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" name="no_reg_pekerjaan" id="no_reg_pekerjaan" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="nama_pekerjaan" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="lokasi_pekerjaan" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nilai Koontrak (inc. PPN)</label>
														<div class="col-md-8">
															<input type="text" id="nilai_kontrak" class="form-control input-sm" placeholder=" "  readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Divisi </label>
														<div class="col-md-8">
															<input type="text" id="divisi" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
														<div class="col-md-8">
															<input type="text" id="durasi" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="metode_pengadaan" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="jenis_pengadaan" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Tanggal Mulai</label>
														<div class="col-md-8">
															<input type="text" id="tgl_mulai" name="tgl_mulai" class="form-control input-sm " placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Tanggal Akhir</label>
														<div class="col-md-8">
															<input type="text" id="tgl_akhir" name="tgl_akhir" class="form-control input-sm " placeholder=" "  readonly="true" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">id Vendor</label>
														<div class="col-md-8">
															<input type="text" id="id_vd" name="id_vd" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Vendor</label>
														<div class="col-md-8">
															<input type="text" id="nama_pt" name="nama_pt" class="form-control input-sm" placeholder=" "  readonly="true" />
														</div>
													</div>
													<div class="table-scrollable">
														<input type="hidden" id="last_penilaian" class="form-control input-sm" />
														<table class="table table-striped table-bordered table-hover" id="tabel_penilaian" >
															<thead>
																<tr>
																	<th width='50' class="text-center">
																		 No
																	</th>
																	<th class="text-center">
																		 Item Penilaian
																	</th>
																	<th width='100' class="text-center">
																		 Bobot
																	</th>
																	<th colspan='5' class="text-center">
																		 Skor
																	</th>
																</tr>
															</thead>
															<tbody id='isi_penilaian'>
																<tr>
																	<td>

																	</td>
																	<td>

																	</td>
																	<td>

																	</td>
																	<td class="text-center">
																		 1 - STB
																	</td>
																	<td class="text-center">
																		 2 - TB
																	</td>
																	<td class="text-center">
																		 3 - CB
																	</td>
																	<td class="text-center">
																		 4 - B
																	</td>
																	<td class="text-center">
																		 5 - SB
																	</td>
																</tr>
															</tbody>
														</table>
														<input type="hidden" id="nilai_akhir" class="form-control input-sm" />
													</div>
													<div class="alert alert-info">
														<strong>Keterangan :</strong>
														<br/>
														<ol type="1">
													 		<li>Sangat Tidak Baik (STB)</li>
													 		<li>Tidak Baik (TB)</li>
													 		<li>Cukup Baik (CB)</li>
													 		<li>Baik (B)</li>
													 		<li>Sangat Baik (SB)</li>
														</ol>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<a type="button" style="display:none;" id="btn_simpan_penilaian" onclick="simpan_penilaian()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
										</div>
										<div class="clearfix"></div>
										<div class="col-md-12">
											<a type="button" id="btn_export_penilaian" onclick="export_penilaian()" class="col-md-12 btn btn-sm green"><i class="glyphicon glyphicon-table" title="Export"></i> Cetak PDF</a>
										</div>
										<div class="clearfix"></div>
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

$(document).ready(function() {

    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "<?php echo site_url('kontrak/kontrak_list')?>",
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

		$('#cari_data_kontrak').autocomplete({
			delay : 0,
			source : "<?php echo site_url('kontrak/get_kontrak/?');?>",
			select : function(event, ui){
                $('#cari_data_kontrak').val(ui.item.label);
				        $('#cari_id_kontrak').val(ui.item.id);
				        return false;
            },
			focus: function(event, ui) {
			        $("#cari_data_kontrak").val(ui.item.label);
			        return false;
			    }
		});

		$(':radio[id=or_undang_1]').change(function()
		{
   		$("#check_box_undang").show();
		});

		$(':radio[id=or_undang_2]').change(function()
		{
   		$("#check_box_undang").hide();
		});

		$("#mark_decimal").inputmask({
	    'alias': 'decimal',
	    rightAlign: true,
	    'groupSeparator': '.',
	    'autoGroup': true
	  });

});

function cari_penilaian()
{
	//removeAll_undang();
	$('.nav-tabs a[href="#tab_1_1"]').tab('show');
	$("#btn_simpan_penilaian").show();

	var carix = document.getElementById('cari_id_kontrak').value;

	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_vendor_penilaian/'+carix;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$("#no_kontrak").val(datas.no_kontrak);
			$("#no_reg_pekerjaan").val(datas.no_reg_pekerjaan);
			$("#nama_pekerjaan").val(datas.nama_pekerjaan);
			$("#lokasi_pekerjaan").val(datas.lokasi);
			$("#nilai_kontrak").val(format_uang(datas.nilai_kontrak));
			$("#divisi").val(datas.divisi);
			$("#durasi").val(datas.durasi);
			$("#metode_pengadaan").val(datas.metode_pengadaan);
			$("#jenis_pengadaan").val(datas.jenis_pengadaan);
			$("#tgl_mulai").val(datas.tgl_mulai);
			$("#tgl_akhir").val(datas.tgl_akhir);
			$("#id_vd").val(datas.id_vd);
			$("#nama_pt").val(datas.nama_pt);

			tampil_soal();

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

var urut_soal = 0;
function tampil_soal(){
	removeAll_soal();

	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/soal_penilaian/';
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$.map(datas, function (obj)
			{
				urut_soal = urut_soal + 1;
				var tabel = "tabel_penilaian";
				var kolom_1 = "<td>"+urut_soal+"</td>";
				var kolom_2 = "<td>"+obj.isi_soal+"</td>";
				var kolom_3 = "<td>"+obj.bobot+"</td>";
				var kolom_4 = "<td><input type='radio' name='"+obj.soal+"' value='1'></td>"+
				"<td><input type='radio' name='"+obj.soal+"' value='2'></td>"+
				"<td><input type='radio' name='"+obj.soal+"' value='3'></td>"+
				"<td><input type='radio' name='"+obj.soal+"' value='4'></td>"+
				"<td><input type='radio' name='"+obj.soal+"' value='5'></td>";

				addElement(tabel, urut_soal, kolom_1, kolom_2, kolom_3, kolom_4);
			});
			$('#last_penilaian').val(urut_soal);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

function simpan_penilaian()
{
	var hasil = [];
	var nomor = ['no_1','no_2','no_3','no_4','no_5'];
	for (var i = 0; i < nomor.length; i++)
	{
		jawaban = document.querySelector('input[name="'+nomor[i]+'"]:checked').value;
		hasil.push(nomor[i]+"-"+jawaban);
	}
	$("#nilai_akhir").val(hasil);
	var jawaban = document.getElementById('nilai_akhir').value.replace(/\,/g,' ');
	var no_reg = document.getElementById('no_reg_pekerjaan').value;
	var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/jawaban_penilaian/'+no_reg+'/'+jawaban;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			alert('Sukses');
			location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});

}

function export_penilaian()
{
	var nr_job = document.getElementById('no_reg_pekerjaan').value;
	var izinx = document.getElementById('tipe_grade').value;
	var bidangx = document.getElementById('id_sub_bidang_pekerjaan').value.replace(/\,/g,' ');
	var pilihx = document.getElementById('pilih_grade').value;
	if(pilihx == '')
	{
		pilihx = 'x';
	}
	var nilai_oex = document.getElementById('nilai_oex').value;

	var hreF = '<?php echo base_url(); ?>index.php/kontrak/excell_undang/'+nr_job+'/'+izinx+'/'+bidangx+'/'+pilihx+'/'+nilai_oex+'/';
	window.open(hreF, '_blank');
}

function addElement(tabel, urut, kolom_1, kolom_2, kolom_3, kolom_4)
{
	$('#'+tabel+'> tbody:last-child').append('<tr id="'+urut+'">'+kolom_1+kolom_2+kolom_3+kolom_4+'</tr>');
}

function removeElement(tabel,urut) {
	$('table#'+tabel+' tr#'+urut+'').remove();
}

function removeAll_soal() {
	var tabel = "tabel_penilaian";
	var urut = document.getElementById("last_penilaian").value;
	urut_soal = 0;
	for (var i = 1; i <= urut; i++)
	{
		$('table#'+tabel+' tr#'+i+'').remove();
	}
}

function removeOptions(selectbox){
	var i;
	for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
	{
		selectbox.remove(i);
	}
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
