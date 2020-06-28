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
	
	$("#sementara").hide();
	$("#sementarax").hide();
	
	$('#pilih_jns').on("select2:selecting", function(e) {
		var bis = $(this).val();
		if( bis == '1'){
			var x = document.getElementById("tetap");
			var y = document.getElementById("sementara");
			var xx = document.getElementById("tetapx");
			var yy = document.getElementById("sementarax");
			x.style.display = "none";
			y.style.display = "block";
			xx.style.display = "none";
			yy.style.display = "block";
		}else if(bis == '2'){
			var x = document.getElementById("tetap");
			var y = document.getElementById("sementara");
			var xx = document.getElementById("tetapx");
			var yy = document.getElementById("sementarax");
			x.style.display = "block";
			y.style.display = "none";
			xx.style.display = "block";
			yy.style.display = "none";
		}
	});
});

function cariagenda(){
		var carix   = document.getElementById("cariagenda").value;
		var cariy   = document.getElementById("cariidlang").value;
		if(carix == '' & cariy != ''){
			cari = '0/'+cariy;
		}else if(carix != '' & cariy == ''){
			cari = carix+'/0';
		}else if(carix == '' & cariy == ''){
			alert("Isi No agenda atau ID Langganan"); return false;
		}else{
			cari = carix+'/'+cariy;
		}
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_janji/'+cari;
		$("#no_agenda2").val("");
		$("#id_cust").val("");
		$("#nama_cust").val("");
		$("#alamat_cust").val("");
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#id_lang_bayar").val(obj.ID_LANG_TUJUAN_BAYAR);
					$("#no_agenda2").val(obj.NO_AGENDA);
					$("#id_cust").val(obj.ID_CUST);
					$("#nama_cust").val(obj.NAMA_CUST);
					$("#alamat_cust").val(obj.ALAMAT_CUST);
					$("#tarif_baru").val(obj.TARIF_BARU);
					RPT = obj.rpt;
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function cariagendaps(){
		var cariy   = document.getElementById("cariagendaps").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_janji/'+cariy;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#no_agenda").val(obj.NO_AGENDA);
					$("#nama_mohon").val(obj.NAMA_MOHON);
					$("#alamat_mohon").val(obj.ALAMAT_MOHON);

				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}



</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Cetak Perjanjian dan Syarat Teknis<small>Permohonan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-6">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Cetak Perjanjian dan Syarat Teknis
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								
							</div>
							<!-- tabel -->
							<form action="#" id="form" role="form">
								<div class="form-body">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group">
												<label class="control-label">Masukan Jenis</label>
												<div>
													<div class="input-group">
														<span class="input-group-addon">
														<i class="fa fa-user"></i>
														</span>
														<select id="pilih_jns" name="pilih_jns" class="form-control select2me" data-placeholder="Select...">
															<option value="1">PELANGGAN TETAP</option>
															<option value="2">SEMENTARA</option>
														</select>
													</div>
													<!-- /input-group -->
												</div>
											</div>
										</div>
									</div>
									<div class="row" id="sementara" >
										<div class="col-md-12">
											<div class="form-group">
												<label>Cari No Agenda</label>
												<div class="input-group col-md-12">
													<input type="text" name="cariagendaps" id="cariagendaps" class="form-control" placeholder=" ">
													<span class="input-group-btn">
														<a type="button" onclick="cariagendaps()" class="btn green">Cari</a>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>&nbsp;</label>
												<div class="input-group col-md-12">
													
												</div>
											</div>
										</div>
									</div>
									<div class="row" id="tetap" >
										<div class="col-md-12">
											<div class="form-group">
												<label>&nbsp;</label>
												<div class="input-group col-md-12">
													<input type="hidden"  class="form-control" placeholder=" " readonly="true">
													<h2>Isi Salah satu</h2>
												</div>
											</div>
											<div class="form-group">
												<label>Cari No Agenda</label>
												<div class="input-group col-md-12">
													<input type="text" name="cariagenda" id="cariagenda" class="form-control" placeholder=" ">
													<span class="input-group-btn">
														<a type="button" onclick="cariagenda()" class="btn green">Cari</a>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>Cari ID Langganan</label>
												<div class="input-group col-md-12">
													<input type="text" name="cariidlang" id="cariidlang" class="form-control" placeholder=" ">
													<span class="input-group-btn">
														<a type="button" onclick="cariagenda()" class="btn green">Cari</a>
													</span>
												</div>
											</div>
											<div class="form-group">
												<label>&nbsp;</label>
												<div class="input-group col-md-12">
													
												</div>
											</div>
										</div>
									</div>
								</div>				
							</form>
						</div>
					</div>
				</div>
				<div class="row ">
				<div class="col-md-6">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>INFO
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="javascript:;" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								
							</div>
							<!-- tabel -->
							<form action="#" id="form" role="form">
								<div class="form-body">
									<div class="row" id="sementarax" >
										<div class="col-md-12">
											<div class="form-group">
												<label>No Agenda</label>
												<div class="input-group col-md-12">
													<input type="text" name="no_agenda" id="no_agenda" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label>Nama</label>
												<div class="input-group col-md-12">
													<input type="text" name="nama_mohon" id="nama_mohon" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label>Alamat</label>
												<div class="input-group col-md-12">
													<input type="text" name="alamat_mohon" id="alamat_mohon" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="clearfix">
												<button type="button" onclick="cetakps(1)" data-loading-text="Mencetak..." class="demo-loading-btn btn btn-primary">
												Cetak Syarat perjanjian </button>
											</div>
										</div>
									</div>
									<div class="row" id="tetapx" >
										<div class="col-md-12">
											<div class="form-group">
												<label>No Agenda</label>
												<div class="input-group col-md-12">
													<input type="hidden" name="id_lang_bayar" id="id_lang_bayar" class="form-control" placeholder=" " readonly>
													<input type="hidden" name="tarif_baru" id="tarif_baru" class="form-control" placeholder=" " readonly>
													<input type="text" name="no_agenda2" id="no_agenda2" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label>ID Customer</label>
												<div class="input-group col-md-12">
													<input type="text" name="id_cust" id="id_cust" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label>Nama</label>
												<div class="input-group col-md-12">
													<input type="text" name="nama_cust" id="nama_cust" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label>Alamat</label>
												<div class="input-group col-md-12">
													<input type="text" name="alamat_cust" id="alamat_cust" class="form-control" placeholder=" " readonly>
												</div>
											</div>
											<div class="clearfix">
												<button type="button" onclick="cetak(1)" data-loading-text="Mencetak..." class="demo-loading-btn btn btn-primary">
												Cetak Perjanjian </button>
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

function cetak(x){	
	var agd = $("#no_agenda2").val();
	var idl = $("#cariidlang").val();
	if(RPT == 'TIPIS'){		
		hreF	= "<?php echo site_url("Laporan/cetak_janjitipis")?>";
	}else{
		hreF	= "<?php echo site_url("Laporan/cetak_janjitebal")?>";
	}
		if(agd == '' & idl != ''){
			cari = '0/'+idl;
		}else if(agd != '' & idl == ''){
			cari = agd+'/0';
		}else if(agd == '' & idl == ''){
			alert("Isi No agenda atau ID Langganan"); return false;
		}else{
			cari = agd+'/'+idl;
		}
	ReQuest	= "/" + x +"/"+cari;
	window.open(hreF+ReQuest, '_blank');
}

function cetakps(x){
	var cust = $("#no_agenda").val();
	
	hreF	= "<?php echo site_url("Laporan/cetak_ps")?>";
	ReQuest	= "/" + x + "/" +cust;
	window.open(hreF+ReQuest, '_blank');
}

</script>
</body>
</html>