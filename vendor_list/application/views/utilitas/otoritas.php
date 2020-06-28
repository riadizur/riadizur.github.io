			<div class="page-head">
				<div class="page-title">
					<h1>Otoritas Menu User <small>Utilitas</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Tentukan Otoritas
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									List Otori </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1"> <!-- tab 1 -->
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-12">
												<div class="btn-group">
													<div class="form-group">
														<label class="col-md-3 control-label align-left">Nama User</label>
														<div class="col-md-9">
															<?php
																$atribut_nama = 'id="nama" class="form-control select2me"';
																echo form_dropdown('nama', $nama, '', $atribut_nama);
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- tabel -->
									<table class="table table-striped table-bordered table-hover" id="table">
									<thead>
									<tr>
										<th class="table-checkbox">
											<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>
										</th>
										<th>
											 Menu
										</th>
										<th>
											 Otoritas
										</th>
									</tr>
									</thead>
									<tbody>
									</tbody>
									</table>
								</div>
								<div class="tab-pane fade" id="tab_1_2"> <!-- tab 2 -->
									<div class="table-toolbar">
										<div class="row">
											<div class="col-md-6">
												<div class="btn-group">
													<a class="btn green" onclick="kembali()" data-toggle="modal">Kembali</a>
												</div>
											</div>
										</div>
									</div>
									<div class="portlet-body form">
										<form action="#" id="form" class="form-horizontal" role="form">
											<input type="hidden" value="" name="id"/>
											<div class="form-body">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label class="col-md-6 control-label">ID Customer</label>
															<div class="col-md-6">
																<input type="text" name="id_cust" id="id_cust" class="form-control input-sm" placeholder=" " readonly="true">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Nama Customer</label>
															<div class="col-md-6">
																<input type="text" name="nama_cust" class="form-control input-sm" placeholder=" " required />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Alamat Customer</label>
															<div class="col-md-6">
																<input type="text" name="alamat_cust" class="form-control input-sm" placeholder=" " required />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Provinsi Customer</label>
															<div class="col-md-6">
																<input type="text" name="prov_cust2" class="form-control input-sm" placeholder=" " disabled="disabled">
																<?php echo form_dropdown("prov_cust",$prov_mohon,'','id="prov_cust" style="display:none;"'); ?>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Kota Customer</label>
															<div class="col-md-6">
																<input type="text" name="kota_cust2" class="form-control input-sm" placeholder=" " disabled="disabled">
																<?php echo form_dropdown('kota_cust', array(), '', 'id="kota_cust" style="display:none;"'); ?>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Kecamatan Customer</label>
															<div class="col-md-6">
																<input type="text" name="kec_cust2" class="form-control input-sm" placeholder=" " disabled="disabled">
																<?php echo form_dropdown('kec_cust', array(), '', 'id="kec_cust" style="display:none;"'); ?>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Kodepos Customer</label>
															<div class="col-md-6">
																<input type="number" name="kdpos_cust" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">NPWP Customer</label>
															<div class="col-md-6">
																<input type="number" name="npwp_cust" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Golongan</label>
															<div class="col-md-6">
																<div class="input-group">
																	<span class="input-group-addon">
																	<i class="fa fa-user"></i>
																	</span>
																	<select id="kogol" name="kogol" class="form-control" data-placeholder="Select..." required>
																		<option value=" ">-- Pilih --</option>
																		<option value="0">Umum</option>
																		<option value="1">IPC Pusat</option>
																		<option value="2">IPC Cabang</option>
																		<option value="3">TNI Polri</option>
																		<option value="4">IPC Group</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														
														<div class="form-group">
															<label class="col-md-6 control-label">Nama Pimpinan</label>
															<div class="col-md-6">
																<input type="text" name="nama_pimpinan" class="form-control input-sm" placeholder=" " required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Jabatan Pimpinan</label>
															<div class="col-md-6">
																<input type="text" name="jab_pimpinan" class="form-control input-sm" placeholder=" " required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Telp Customer</label>
															<div class="col-md-6">
																<input type="number" name="telp" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">No Handphone 1</label>
															<div class="col-md-6">
																<input type="number" name="hp1" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">No Handphone 2</label>
															<div class="col-md-6">
																<input type="number" name="hp2" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Email Perusahaan</label>
															<div class="col-md-6">
																<input type="text" name="email1" class="form-control input-sm" placeholder=" " required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Email PIC</label>
															<div class="col-md-6">
																<input type="text" name="email2" class="form-control input-sm" placeholder=" " required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-6 control-label">Kode UJL</label>
															<div class="col-md-6">
																<div class="input-group">
																	<span class="input-group-addon">
																	<i class="fa fa-user"></i>
																	</span>
																	<select id="kd_ujl" name="kd_ujl" class="form-control" data-placeholder="Select..." required>
																		<option value=" ">-- Pilih --</option>
																		<option value="0">Reguler</option>
																		<option value="1">IPC Pusat</option>
																		<option value="2">IPC Cabang</option>
																		<option value="3">Auto Debet</option>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="form-actions right">
												<button type="button" id="btnSave" onclick="validasi()" class="btn blue">Simpan</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- awal -->
									
							<!-- selesai -->
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
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<!-- TAMBAHAN
<script src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="../../assets/jquery/jquery-2.1.4.min.js"></script>
-->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script> 
<script>

jQuery(document).ready(function() {
Metronic.init(); 
Layout.init();
Demo.init();
});

var save_method; 
var table;

$(document).ready(function() {
	
    table = $('#table').DataTable({ 
	
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "<?php echo site_url('utilitas/otoritas_list')?>",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
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
	
	$("#prov_cust").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_chain_kab_mohon/'+v;
		removeOptions(document.getElementById("kota_cust"));
		var kota_cust = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kota_cust.push({
					   'id': obj.id_kab,
					   'text': obj.nama
					});
					return kota_cust;
					
				});
				$("#kota_cust").select2({
					placeholder: "Pilih",
					data: kota_cust,
					width: '100%'
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});
	});

	$("#kota_cust").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_chain_kec_mohon/'+v;
		removeOptions(document.getElementById("kec_cust"));
		var kec_cust = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kec_cust.push({
					   'id': obj.id_kec,
					   'text': obj.nama
					});
					return kec_cust;
					
				});
				$("#kec_cust").select2({
					placeholder: "Pilih",
					data: kec_cust,
					width: '100%'
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
	});
	
	noidcust();
	
});


function cek(cekbox){
    for(i=0; i < cekbox.length; i++){
        cekbox[i].checked = true;
    }
}
function uncek(cekbox){
    for(i=0; i < cekbox.length; i++){
        cekbox[i].checked = false;
    }
}


function add_cust()
{
    save_method = 'add';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error'); 
    $('.help-block').empty(); 
    $('.nav-tabs a[href="#tab_1_2"]').tab('show');
    $('[name="kec_cust2"]').hide();
    $('[name="kota_cust2"]').hide();
    $('[name="prov_cust2"]').hide();
    $('[name="kec_cust"]').show();
    $('[name="kota_cust"]').show();
    $('[name="prov_cust"]').show();
    $("#prov_cust").select2({ width: '100%' });
	$("#kota_cust").select2({ width: '100%' });
	$("#kec_cust").select2({ width: '100%' });
	noidcust();
}

function edit_cust(id)
{ 
	if ($("#prov_cust").data('select2')){
		$("#kec_cust").select2('destroy'); 
		$("#kota_cust").select2('destroy');
		$("#prov_cust").select2('destroy'); 
    }
    save_method = 'update';
    $('#form')[0].reset(); 
    $('.form-group').removeClass('has-error');
    $('.help-block').empty(); 

    $.ajax({
        url : "<?php echo site_url('pelayanan/cust_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
			$('[name="id_cust"]').val(data.ID_CUST);
            $('[name="nama_cust"]').val(data.NAMA_CUST);
            $('[name="alamat_cust"]').val(data.ALAMAT_CUST);
            $('[name="kec_cust2"]').val(data.KECCUST);
            $('[name="kota_cust2"]').val(data.KABCUST);
            $('[name="prov_cust2"]').val(data.PROVCUST);
            $('[name="kec_cust"]').hide();
            $('[name="kota_cust"]').hide();
            $('[name="prov_cust"]').hide();
    		$('[name="kec_cust2"]').show();
    		$('[name="kota_cust2"]').show();
    		$('[name="prov_cust2"]').show();
            $('[name="kdpos_cust"]').val(data.KDPOS_CUST);
			$('[name="npwp_cust"]').val(data.NPWP_CUST);
            $('[name="kogol"]').val(data.KOGOL);
            $('[name="nama_pimpinan"]').val(data.NAMA_PIMPINAN);
            $('[name="jab_pimpinan"]').val(data.JAB_PIMPINAN);
            $('[name="telp"]').val(data.TELP);
            $('[name="hp1"]').val(data.HP1);
			$('[name="hp2"]').val(data.HP2);
            $('[name="email1"]').val(data.EMAIL1);
            $('[name="email2"]').val(data.EMAIL2);
			$('[name="kd_ujl"]').val(data.KD_UJL);
            //$('[name="dob"]').datepicker('update',data.dob);
            
    		$('.nav-tabs a[href="#tab_1_2"]').tab('show');

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');
        }
    });
}

function hanyaAngka(evt) {
  var charCode = (evt.which) ? evt.which : event.keyCode
   if (charCode > 31 && (charCode < 48 || charCode > 57))

	return false;
  return true;
}

function reload_table()
{
    table.ajax.reload(null,false); 
}

function cek(a) {
	valid = /^[A-Za-z -&.,]{1,}$/;
	return valid.test(a);
}

function validasi(){
	var nama	= document.forms["form"]["nama_cust"].value;
	var alamat	= document.forms["form"]["alamat_cust"].value;
	if(save_method == 'add') {
        var kec		= document.forms["form"]["kec_cust"].value;
		var kota	= document.forms["form"]["kota_cust"].value;
		var prov	= document.forms["form"]["prov_cust"].value;
    }
	
	var kdpos	= document.forms["form"]["kdpos_cust"].value;
	var npwp	= document.forms["form"]["npwp_cust"].value;
	var kogol	= document.forms["form"]["kogol"].value;
	var pim		= document.forms["form"]["nama_pimpinan"].value;
	var jab		= document.forms["form"]["jab_pimpinan"].value;
	var telp	= document.forms["form"]["telp"].value;
	var hp1		= document.forms["form"]["hp1"].value;
	var hp2		= document.forms["form"]["hp2"].value;
	var email1	= document.forms["form"]["email1"].value;
	var email2	= document.forms["form"]["email2"].value;
	var ujl		= document.forms["form"]["kd_ujl"].value;
	
	/*if (!cek(nama) || !cek(alamat) || !cek(kec) || !cek(kota) || !cek(prov) || !cek(pim) || !cek(jab) ) {
		alert("Inputan Masih kurang benar");
		return false;
	}*/

	if(kogol == "" || ujl == ""){
		alert("Pilih Golongan dan UJL");
		return false;
	}

	if(nama == "" || alamat == "" || kec == "" || kota == "" || prov == "" || kdpos == "" || npwp == "" || pim == "" || jab == "" || telp == "" || hp1 == "" || hp2 == "" || email1 == "" || email2 == ""){
		alert("Tidak boleh ada yang kosong");
		return false;
	}

	save();
}

function save()
{
    $('#btnSave').text('saving...');
    $('#btnSave').attr('disabled',true);
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/cust_add')?>";
    } else {
        url = "<?php echo site_url('pelayanan/cust_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {

            if(data.status) 
            {
                $('.nav-tabs a[href="#tab_1_1"]').tab('show');
                reload_table();
            }

            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false); 


        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error adding / update data');
            $('#btnSave').text('save'); 
            $('#btnSave').attr('disabled',false); 

        }
    });
}

function delete_cust(id)
{
    if(confirm('Yakin anda ingin menghapus?'))
    {
        $.ajax({
            url : "<?php echo site_url('pelayanan/cust_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                $('#large').modal('hide');
                reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
        });
    }
}

function noidcust(){
	$.ajax({
		url: '<?php echo base_url(); ?>/index.php/pelayanan/otoidcust',
		type: "POST",
		dataType:"json",
		success:function(datas){
			var agd = $.map(datas, function (obj) {
				var X 		 = Math.floor((Math.random() * 10) + 1);
				var urut	= obj.id_cust;
				var idcust  = '88'+urut+X;
				$("#id_cust").val(idcust);
			});
		}                                     
	});    
}

function kembali(){
    $('.nav-tabs a[href="#tab_1_1"]').tab('show');
}

function removeOptions(selectbox){
	var i;
	for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
	{
		selectbox.remove(i);
	}
}

</script>
</body>
</html>