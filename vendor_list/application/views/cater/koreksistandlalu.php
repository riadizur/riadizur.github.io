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
	
	
	$('#kd_bisnis').on("select2:selecting", function(e) { 
		var bis = $(this).val();
			$.ajax({
				url: '<?php echo base_url(); ?>/index.php/pelayanan/otoagenda/',
				type: "POST",
				dataType:"json",
				success:function(datas){
					var agd = $.map(datas, function (obj) {			
						var pt   	= document.getElementById("kd_pt").value;
						var wil		= document.getElementById("kd_area").value;
						var bis		= document.getElementById("kd_bisnis").value;
						var urut	= obj.no_agenda;
						var rand    = Math.floor((Math.random() * 10) + 1);
						var noagd   = '88'+pt+wil+bis+urut+rand;
						$("#no_agenda").val(noagd);
					});
				}                                     
			});
	});

	
});


function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagenda/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#kd_pt").val(obj.kd_pt).trigger('change');
					$("#kd_area").val(obj.kd_area).trigger('change');
					$("#kd_bisnis").val(obj.kd_bisnis).trigger('change');
					$("#no_agenda").val(obj.no_agenda);
					$("#no_regis").val(obj.no_regis);
					$("#tgl_mohon").val(obj.tgl_mohon);
					$("#thbl_mohon").val(obj.thbl_mohon);
					$("#nm_mohon").val(obj.nm_mohon);
					$("#alamat_mohon").val(obj.alamat_mohon);
					$("#kab_mohon").val(obj.kab_mohon);
					$("#prov_mohon").val(obj.prov_mohon);
					$("#kdpos_mohon").val(obj.kdpos_mohon);
					$("#telp_mohon").val(obj.telp_mohon);
					$("#hp_mohon").val(obj.hp_mohon);
					$("#email_mohon").val(obj.email_mohon);
					$("#identitas_mohon").val(obj.identitas_mohon).trigger('change');
					$("#noidentitas_mohon").val(obj.noidentitas_mohon);
					$("#nm_cust").val(obj.nm_cust);
					$("#alamat_cust").val(obj.alamat_cust);
					$("#kab_cust").val(obj.kab_cust);
					$("#prov_cust").val(obj.prov_cust);
					$("#kdpos_cust").val(obj.kdpos_cust);
					$("#asal_mohon").val(obj.asal_mohon).trigger('change');
					$("#paket_sar").val(obj.paket_sar);
					$("#tarif_lama").val(obj.tarif_lama);
					$("#daya_lama").val(obj.daya_lama);
					$("#bp").val(obj.bp);
					$("#ujl_lama").val(obj.ujl_lama);
					$("#ujl_baru").val(obj.ujl_baru);
					$("#ujl_tagih").val(obj.ujl_tagih);
					$("#materai").val(obj.materai);
					var bp   	= document.getElementById("bp").value;
					var tagih   = document.getElementById("ujl_tagih").value;
					var materai = document.getElementById("materai").value;
					var totbiaya= eval(bp) + eval(tagih) + eval(materai);
					if (!isNaN(totbiaya)) {
						$("#tot_biaya").val(totbiaya);
					}
					
					
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function sum(){
	var nilaibp= document.getElementById('bp').value;
	var nilai1 = document.getElementById('ujl_tagih').value;
	var nilai2 = document.getElementById('materai').value;
	var hasil = parseInt(nilaibp) + parseInt(nilai1) + parseInt(nilai2);
	if (!isNaN(hasil)) {
		document.getElementById('tot_biaya').value = hasil;
	}
}
</script>


			<div class="page-head">
				<div class="page-title">
					<h1>Pasang Baru <small>Permohonan</small></h1>
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
								<i class="fa fa-globe"></i>Entry Pasang Baru
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
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-1">
										<div class="btn-group">
											<a type="button" id="btnSave" onclick="save()" class="btn green">Simpan </a>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
										<!-- /input-group -->
									</div>
									<div class="col-md-1">
											<button class="btn dropdown-toggle" data-toggle="dropdown">Cetak <i class="fa fa-angle-down"></i>
											</button>
											<ul class="dropdown-menu pull-right">
												<li>
													<a href="#">
													Print </a>
												</li>
												<li>
													<a href="#">
													Save as PDF </a>
												</li>
												<li>
													<a href="#">
													Export to Excel </a>
												</li>
											</ul>
									</div>
								</div>
							</div>
							<!-- tabel -->
							<form action="#" id="form" class="form-horizontal" role="form"> 
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-6 control-label"></label>
												<div class="col-md-6">
													<input type="hidden"  class="form-control input" placeholder=" " >
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-md-6 control-label">ID Langganan</label>
												<div class="col-md-6">
													<input type="text" id="no_agenda" name="no_agenda" class="form-control input" placeholder=" " readonly="true">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Nama Langganan</label>
												<div class="col-md-6">
													<input type="text" id="no_regis" name="no_regis" class="form-control input-sm" placeholder=" "  readonly="true">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Tarif</label>
												<div class="col-md-6">
													<input type="text" id="tarif_lama" name="tarif_lama" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Daya</label>
												<div class="col-md-6">
													<input type="text" id="daya_lama" name="daya_lama" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Tanggal Baca Stand Lalu</label>
												<div class="col-md-6">
													<input id="tgl_mohon" name="tgl_mohon" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
												</div>
											</div>										
											<div class="form-group">
												<label class="col-md-6 control-label">Stand LWBP Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="nm_mohon" name="nm_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Stand WBP Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="alamat_mohon" name="alamat_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Stand KVARH Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="kab_mohon" name="kab_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Tanggal Baca Stand Akhir</label>
												<div class="col-md-6">
													<input id="tgl_mohon" name="tgl_mohon" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
												</div>
											</div>	
											<div class="form-group">
												<label class="col-md-6 control-label">Stand LWBP Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="nm_mohon" name="nm_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Stand WBP Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="alamat_mohon" name="alamat_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label">Stand KVARH Bulan Lalu</label>
												<div class="col-md-6">
													<input type="text" id="kab_mohon" name="kab_mohon" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
										</div>

									</div>
								</div>
							</form>
							<!-- selesai -->
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

function save()
{
	var save_method = 'add' ;
    //$('#btnSave').text('saving...');
    //$('#btnSave').attr('disabled',true);
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/pasangbaru_add')?>";
    } else {
        url = "<?php echo site_url('pelayanan/pasangbaru_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			alert('Berhasil disimpan');
            //$('#btnSave').text('save'); 
            //$('#btnSave').attr('disabled',false);
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Terjadi kesalahan saat simpan / merubah data');
            //$('#btnSave').text('save'); 
            //$('#btnSave').attr('disabled',false); 
        }
    });
}

</script>
</body>
</html>