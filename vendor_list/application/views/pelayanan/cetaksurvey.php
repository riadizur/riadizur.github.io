<script>
function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagendasurvey/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#no_agenda").val(obj.NO_AGENDA);
					$("#id_cust").val(obj.ID_CUST);
					$("#id_langganan").val(obj.ID_LANGGANAN);
					
					$("#jns_transaksi").val(obj.JNS_TRANSAKSI);
					$("#nama_mohon").val(obj.NAMA_MOHON);
					$("#alamat_mohon").val(obj.ALAMAT_MOHON);
					$("#kec_mohon").val(obj.KECMOHON);
					$("#kota_mohon").val(obj.KOTAMOHON);
					$("#prov_mohon").val(obj.PROVMOHON);
					$("#kdpos_mohon").val(obj.KDPOS_MOHON);
					
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#kdpos_lang").val(obj.KDPOS_LANG);
					
					$("#rp_bp").val(obj.RP_BP);
					$("#rp_ujl_tagih").val(number_format(obj.RP_UJL_TAGIH,0,'.',','));
					$("#materai").val(obj.MATERAI);
					var bp   	= document.getElementById("rp_bp").value;
					var tagih   = document.getElementById("rp_ujl_tagih").value;
					var materai = document.getElementById("materai").value;
					var totbiaya= eval(bp) + eval(tagih) + eval(materai);
					if (!isNaN(totbiaya)) {
						$("#total_biaya").val(totbiaya);
					}
					caril();
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function caril(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagendal/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#kec_lang").val(obj.KECLANG);
					$("#kota_lang").val(obj.KOTALANG);
					$("#prov_lang").val(obj.PROVLANG);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function cetak(x){
	var noagd = document.getElementById("no_agenda").value;
	hreF	= "<?php echo site_url("Laporan/rpt_survey")?>";
	ReQuest	= "/" + x +"/" + noagd;
	window.open(hreF+ReQuest, '_blank');
}

function sum(){
	var nilaibp= document.getElementById('rp_bp').value;
	var nilai1 = document.getElementById('rp_ujl_baru').value;
	var nilai2 = document.getElementById('rp_ujl_lama').value;
	var nilai3 = document.getElementById('rp_ujl_tagih').value;
	var nilai4 = document.getElementById('materai').value;
	
	if(nilai1 > nilai2){
		var ujl = parseInt(nilai1) - parseInt(nilai2);
	}else if(nilai2 > nilai1){
		var ujl = parseInt(nilai2) - parseInt(nilai1);
	}
	
	if (!isNaN(ujl)) {
		document.getElementById('rp_ujl_tagih').value = ujl;
	}	
	
	var hasil  = parseInt(nilaibp) + parseInt(ujl) + parseInt(nilai4);
	if (!isNaN(hasil)) {
		document.getElementById('total_biaya').value = hasil;
	}
}

</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Cetak Form Survey <small>Pelayanan</small></h1>
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
								<i class="fa fa-globe"></i>Pencarian
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<label class="col-md-3 control-label align-left">Masukan No. Agenda</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-body form-horizontal">
							<div class="form-group">
								<label class="col-md-6 control-label align-left">No Agenda</label>
								<div class="col-md-6">
									<input type="text" id="no_agenda" name="no_agenda" class="form-control" readonly="true"/>
								</div>
							</div>
							<br/><br/>
							<div class="note note-success">
								<h1 class="block center"><center> LISTRIK</center></h1>
							</div>
							<br/><br/><br/><br/>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Data Permohonan
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="">
									<label class="col-md-6 control-label align-left">Jenis</label>
									<div class="col-md-6">
										<input type="text" id="jns_transaksi" name="jns_transaksi" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Nama</label>
									<div class="col-md-6">
										<input type="text" id="nama_mohon" name="nama_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Alamat</label>
									<div class="col-md-6">
										<input type="text" id="alamat_mohon" name="alamat_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kecamatan</label>
									<div class="col-md-6">
										<input type="text" id="kec_mohon" name="kec_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kota</label>
									<div class="col-md-6">
										<input type="text" id="kota_mohon" name="kota_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Provinsi</label>
									<div class="col-md-6">
										<input type="text" id="prov_mohon" name="prov_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kodepos</label>
									<div class="col-md-6">
										<input type="text" id="kdpos_mohon" name="kdpos_mohon" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-6 control-label align-left"></label>
									<div class="col-md-6">
										<input type="hidden" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Data Administrasi Langganan dan Biaya
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Nama</label>
											<div class="col-md-6">
												<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Alamat</label>
											<div class="col-md-6">
												<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kecamatan</label>
											<div class="col-md-6">
												<input type="text" id="kec_lang" name="kec_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kota</label>
											<div class="col-md-6">
												<input type="text" id="kota_lang" name="kota_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Provinsi</label>
											<div class="col-md-6">
												<input type="text" id="prov_lang" name="prov_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode POS</label>
											<div class="col-md-6">
												<input type="text" id="kdpos_lang" name="kdpos_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">BP</label>
											<div class="col-md-6">
												<input type="text" id="rp_bp" name="rp_bp" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">UJL</label>
											<div class="col-md-6">
												<input type="text" id="rp_ujl_tagih" name="rp_ujl_tagih" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Materai</label>
											<div class="col-md-6">
												<input type="text" id="materai" name="materai" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Jumlah</label>
											<div class="col-md-6">
												<input type="text" id="total_biaya" name="total_biaya" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">&nbsp;</label>
											<div class="col-md-6">
												<input type="hidden" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-3">
												<a class="btn dropdown-toggle blue" onclick="cetak(1)" data-toggle="dropdown">Cetak Form</a>
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
    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });

});

function save()
{
	var save_method = 'update';
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/survey_add')?>";
    } else {
        url = "<?php echo site_url('pelayanan/survey_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			alert('Berhasil disimpan');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Terjadi kesalahan saat simpan / merubah data');
        }
    });
}

</script>
</body>
</html>