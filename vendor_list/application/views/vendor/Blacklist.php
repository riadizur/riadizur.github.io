			<div class="page-head">
				<div class="page-title">
					<h1>Data <small>Vendor</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-6">
					<div class="portlet solid grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-search"></i>Cari Vendor
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-group">
								<label class="col-md-5 control-label align-left">Masukkan Nama Vendor </label>
								<div class="col-md-7 input-group">
									<input type="text" name="cari_data" id="cari_data" class="form-control input-sm" placeholder="Cari..." >
									<span class="input-group-btn">
										<a type="button" id="btncari" onclick="cari_vendor()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
									</span>
									<input type="hidden" name="cari_id" id="cari_id"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Form Blacklist Vendor
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
															<label class="col-md-4 control-label align-left">Id Vendor</label>
															<div class="col-md-8">
																<input type="text" name="id_vd" id="id_vd" class="form-control input-sm" placeholder=" " readonly="true">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nama Perusahaan</label>
															<div class="col-md-8">
																<input type="text" name="nama_pt" id="nama_pt" class="form-control input-sm" placeholder=" " readonly="true">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Alamat Perusahaan</label>
															<div class="col-md-8">
																<input type="text" name="alamat_pt" id="alamat_pt" class="form-control input-sm" placeholder=" " readonly="true">
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nama Pimpinan</label>
															<div class="col-md-8">
																<input type="text" name="nama_dirut" id="nama_dirut" class="form-control input-sm" placeholder=" " readonly="true">
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
															<label class="col-md-4 control-label align-left">Tanggal Awal</label>
															<div class="col-md-8">
																<input type="text" name="tgl_awal" class="form-control input-sm datepicker datepicker" placeholder="Tanggal Awal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Akhir</label>
															<div class="col-md-8">
																<input type="text" name="tgl_akhir" class="form-control input-sm datepicker datepicker" placeholder="Tanggal Akhir Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Alasan Blacklist</label>
															<div class="col-md-8">
																<textarea name="keterangan" id="keterangan" class="form-control input-sm"> </textarea>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Pihak yang mem-blacklist</label>
															<div class="col-md-8">
																<input type="text" name="blacklist_oleh" id="blacklist_oleh" class="form-control input-sm" placeholder="Nama pihak ... " required>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="dokumen">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="dokumen" name="dokumen" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
									<div class="form-actions">
										<button type="button" style="display:none;" id="btnSave" onclick="save()" class="btn red-pink col-md-12">Simpan</button>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
			<!-- modal large -->
			<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
							<h4 class="modal-title">Entri Pelanggan Baru</h4>
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
var urut_siup = 0;
var urut_siujk = 0;
var urut_siu = 0;

$(document).ready(function() {

    table = $('#table').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "<?php echo site_url('pelayanan/cust_list')?>",
            "type": "POST"
        },

        "columnDefs": [
        {
            "targets": [ -1 ],
            "orderable": false,
        },
        ],

    });

		$('#cari_data').autocomplete({
			delay : 0,
			source : "<?php echo site_url('vendor/cari_vendor_blacklist/?');?>",
			select : function(event, ui){
                $('#cari_data').val(ui.item.label);
				        $('#cari_id').val(ui.item.id);
				        return false;
            },
			focus: function(event, ui) {
			        $("#cari_data").val(ui.item.label);
			        return false;
			    }
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

function cari_vendor()
{
	//removeAll_undang();
	$("#btnSave").show();

	var carix = document.getElementById('cari_id').value;

	var baseUrl = '<?php echo base_url(); ?>index.php/vendor/data_vendor_blacklist/'+carix;
	$.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas)
		{
			$("#id_vd").val(datas.id_vd);
			$("#nama_pt").val(datas.nama_pt);
			$("#alamat_pt").val(datas.alamat_pt);
			$("#nama_dirut").val(datas.nama_dirut);

		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Administrator");
		}
	});
}

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

		return year + month;
}

function save()
{
	save_method = 'add';

  $('#btnSave').text('Sedang proses simpan...');
  $('#btnSave').attr('disabled',true);
  var url = "<?php echo site_url('vendor/blacklist_add')?>";

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
							case 'notif_siup':
								$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
								$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
								break;
							case 'notif_siujk':
								$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
								$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
								break;
							case 'notif_siu':
								$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
								$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
								break;
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


</script>
</body>
</html>
