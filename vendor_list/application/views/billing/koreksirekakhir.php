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
	
	$('.input-sm').on('keyup', function(e) {
		var key = e.which ? e.which : event.keyCode;
        if(key == 110 || key == 188){
          e.preventDefault();
          var value = $(this).val(); 
          console.log(value === "");        
          $(this).val(value.replace(",","."));
        }
	});
	document.getElementById("sukses").innerHTML = " ";
	$('#BtnSave').attr('disabled',true);
});


function cari(){
	$('#BtnSave').attr('disabled',true);
	document.getElementById("sukses").innerHTML = " ";
	$("input[type=text], textarea").val("");
	var carix   = document.getElementById("cari").value;
	var baseUrl = '<?php echo base_url(); ?>index.php/billing/carilang/'+carix;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj){
					$("#thblrek").val(obj.THBLREK);
					$("#id_lang").val(obj.ID_LANG);
					$("#nm_lang").val(obj.NAMA_LANG);
					$("#tarif").val(obj.TARIF);
					$("#daya").val(obj.DAYA);
					$("#tgl_baca_awal").val(obj.TGL_BACA_AWAL);
					$("#stand_awal_lwbp").val(obj.STAND_AWAL_LWBP);
					$("#stand_awal_wbp").val(obj.STAND_AWAL_WBP);
					$("#stand_awal_kvarh").val(obj.STAND_AWAL_KVARH);
					$("#tgl_baca_awalbefore").val(obj.TGL_BACA_AWAL);
					$("#stand_awal_lwbpbefore").val(obj.STAND_AWAL_LWBP);
					$("#stand_awal_wbpbefore").val(obj.STAND_AWAL_WBP);
					$("#stand_awal_kvarhbefore").val(obj.STAND_AWAL_KVARH);
					
					$("#tgl_baca_akhir").val(obj.TGL_BACA_AKHIR);
					$("#stand_akhir_lwbp").val(obj.STAND_AKHIR_LWBP);
					$("#stand_akhir_wbp").val(obj.STAND_AKHIR_WBP);
					$("#stand_akhir_kvarh").val(obj.STAND_AKHIR_KVARH);
					$("#tgl_baca_akhirbefore").val(obj.TGL_BACA_AKHIR);
					$("#stand_akhir_lwbpbefore").val(obj.STAND_AKHIR_LWBP);
					$("#stand_akhir_wbpbefore").val(obj.STAND_AKHIR_WBP);
					$("#stand_akhir_kvarhbefore").val(obj.STAND_AKHIR_KVARH);
					
					$("#stand_bkr_lwbp").val(obj.STAND_BKR_LWBP);
					$("#stand_bkr_wbp").val(obj.STAND_BKR_WBP);
					$("#stand_bkr_kvarh").val(obj.STAND_BKR_KVARH);
					$("#stand_bkr_lwbpbefore").val(obj.STAND_BKR_LWBP);
					$("#stand_bkr_wbpbefore").val(obj.STAND_BKR_WBP);
					$("#stand_bkr_kvarhbefore").val(obj.STAND_BKR_KVARH);
					
					$("#stand_psg_lwbp").val(obj.STAND_PSG_LWBP);
					$("#stand_psg_wbp").val(obj.STAND_PSG_WBP);
					$("#stand_psg_kvarh").val(obj.STAND_PSG_KVARH);
					$("#stand_psg_lwbpbefore").val(obj.STAND_PSG_LWBP);
					$("#stand_psg_wbpbefore").val(obj.STAND_PSG_WBP);
					$("#stand_psg_kvarhbefore").val(obj.STAND_PSG_KVARH);
					
					$("#fk_meterlwbp").val(obj.FKMXFRT);
					$("#fk_meterwbp").val(obj.FKMXFRT);
					$("#fk_meterkvarh").val(obj.FKMXFRT);
					
					$("#pemlwbp_billing").val(obj.KWHLWBP);
					$("#pemwbp_billing").val(obj.KWHWBP);
					$("#pemkvarh_billing").val(obj.KLBKVARH);
					
					$("#rplwbp").val(obj.RPLWBP);
					$("#rpwbp").val(obj.RPWBP);
					$("#rpkvarh").val(obj.RPKVARH);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
}

function proseshitung(){
		var carix   	= document.getElementById("cari").value;
		var stawallwbp  = document.getElementById("stand_awal_lwbp").value;
		var stawalwbp   = document.getElementById("stand_awal_wbp").value;
		var stawalkvarh = document.getElementById("stand_awal_kvarh").value;
		var stbkrlwbp   = document.getElementById("stand_bkr_lwbp").value;
		var stbkrwbp    = document.getElementById("stand_bkr_wbp").value;
		var stbkrkvarh  = document.getElementById("stand_bkr_kvarh").value;
		var stpsglwbp   = document.getElementById("stand_psg_lwbp").value;
		var stpsgwbp    = document.getElementById("stand_psg_wbp").value;
		var stpsgkvarh  = document.getElementById("stand_psg_kvarh").value;
		var stakhirlwbp = document.getElementById("stand_akhir_lwbp").value;
		var stakhirwbp  = document.getElementById("stand_akhir_wbp").value;
		var stakhirkvarh= document.getElementById("stand_akhir_kvarh").value;
		
		var val = carix+"/"+stawallwbp+"/"+stawalwbp+"/"+stawalkvarh+"/"+stbkrlwbp+"/"+stbkrwbp+"/"+stbkrkvarh+"/"+stpsglwbp+"/"+stpsgwbp+"/"+stpsgkvarh+"/"+stakhirlwbp+"/"+stakhirwbp+"/"+stakhirkvarh ;
		var baseUrl = '<?php echo base_url(); ?>index.php/cater/proseshitungkwhperlang/'+val;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#pemlwbp_cater").val(obj.PEMLWBP_CATERX);
					$("#pemwbp_cater").val(obj.PEMWBP_CATERX);
					$("#pemkvarh_cater").val(obj.PEMKVARH_CATERX);
					proseshitungbilling(obj.PEMLWBP_CATERX,obj.PEMWBP_CATERX,obj.PEMKVARH_CATERX );
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
		$('#BtnSave').attr('disabled',false);
}

function proseshitungbilling(){
		var carix   	= document.getElementById("cari").value;
		var pemlwbpcat  = document.getElementById("pemlwbp_cater").value;
		var pemwbpcat   = document.getElementById("pemwbp_cater").value;
		var pemkvarhcat = document.getElementById("pemkvarh_cater").value;
		var pemkwhcat   = parseInt(pemlwbpcat) + parseInt(pemwbpcat) + parseInt(pemkvarhcat);
		
		var val = carix+"/"+pemlwbpcat+"/"+pemwbpcat+"/"+pemkvarhcat+"/"+pemkwhcat ;
		var baseUrl = '<?php echo base_url(); ?>index.php/billing/proseshitungrekeningperlang/'+val;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#pemlwbp_billing").val(obj.KWHLWBPX);
					$("#pemwbp_billing").val(obj.KWHWBPX);
					$("#pemkvarh_billing").val(obj.KLBKVARHX);
					
					$("#rplwbp").val(obj.RPLWBPX);
					$("#rpwbp").val(obj.RPWBPX);
					$("#rpkvarh").val(obj.RPKVARHX);
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("error");
			}
		});
		$('#BtnSave').attr('disabled',false);
}

function replacekoma(evt) {
	var key = (evt.which) ? evt.which : event.keyCode
	if(key == 44){
		evt.preventDefault();
		$(this).val($(this).val() + '.');
	}
}
</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Koreksi Stand Awal <small>Catat Meter</small></h1>
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
								<i class="fa fa-globe"></i>Entri Koreksi Stand Awal
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="col-md-1">
										<div class="btn-group">
											&nbsp;
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
									
								</div>
							</div>
							<!-- tabel -->
							<form action="#" id="form" class="form-horizontal" role="form"> 
								<div class="form-body">
								
									<div class="row">
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-heading">
													<div class="caption">
														<i class="fa fa-globe"></i>
														<span class="caption-subject font-green-sharp bold">Informasi</span>
													</div>
												</div>
<form action="#" id="form" class="form-horizontal" role="form">
												<div class="panel-body">
													<div class="form-body form-horizontal">
														<div class="col-md-12">
															<div class="form-group">
																<label class="col-md-3 control-label">THBLREK</label>
																<div class="col-md-6">
																	<input type="text" id="thblrek" name="thblrek" class="form-control input" placeholder=" " readonly="true">
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-3 control-label">ID Langganan</label>
																<div class="col-md-6">
																	<input type="text" id="id_lang" name="id_lang" class="form-control input" placeholder=" " readonly="true">
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-3 control-label">Nama Langganan</label>
																<div class="col-md-6">
																	<input type="text" id="nm_lang" name="nm_lang" class="form-control input-sm" placeholder=" "  readonly="true">
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-3 control-label">Tarif</label>
																<div class="col-md-6">
																	<input type="text" id="tarif" name="tarif" class="form-control input-sm" placeholder=" " readonly>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-3 control-label">Daya</label>
																<div class="col-md-6">
																	<input type="text" id="daya" name="daya" class="form-control input-sm" placeholder=" " readonly>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div> <p id="sukses" style="color: red; font-size:15px;"> </p> </div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-scrollable">
												<table class="table table-bordered table-hover">
													<thead>
														<tr>
															<th style="width: 20%;">
																Uraian
															</th>
															<th>
																Awal
															</th>
															<th>
																Bongkar
															</th>
															<th>
																Pasang
															</th>
															<th>
																Akhir
															</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="active">
																TANGGAL
															</td>
															<td>
																<input type="text" id="tgl_baca_awal" name="tgl_baca_awal" class="form-control datepicker" placeholder=" " readonly>
																<input type="hidden" id="tgl_baca_awalbefore" name="tgl_baca_awalbefore" class="form-control datepicker" placeholder=" " readonly>
															</td>
															<td>
																&nbsp;
															</td>
															<td>
																&nbsp;
															</td>
															<td>
																<input type="text" id="tgl_baca_akhir" name="tgl_baca_akhir" class="form-control datepicker" placeholder=" " >
																<input type="hidden" id="tgl_baca_akhirbefore" name="tgl_baca_akhirbefore" class="form-control datepicker" placeholder=" " readonly>
															</td>
														</tr>
														<tr>
															<td class="active">
																LWBP
															</td>
															<td>
																<input type="text" id="stand_awal_lwbp" name="stand_awal_lwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_awal_lwbpbefore" name="stand_awal_lwbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_bkr_lwbpbefore" name="stand_bkr_lwbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_psg_lwbp" name="stand_psg_lwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_psg_lwbpbefore" name="stand_psg_lwbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_akhir_lwbp" name="stand_akhir_lwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_akhir_lwbpbefore" name="stand_akhir_lwbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
														<tr>
															<td class="active">
																WBP
															</td>
															<td>
																<input type="text" id="stand_awal_wbp" name="stand_awal_wbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_awal_wbpbefore" name="stand_awal_wbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_bkr_wbpbefore" name="stand_bkr_wbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_psg_wbp" name="stand_psg_wbp" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_psg_wbpbefore" name="stand_psg_wbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_akhir_wbp" name="stand_akhir_wbp" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_akhir_wbpbefore" name="stand_akhir_wbpbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
														<tr>
															<td class="active">
																KVARH
															</td>
															<td>
																<input type="text" id="stand_awal_kvarh" name="stand_awal_kvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_awal_kvarhbefore" name="stand_awal_kvarhbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="stand_bkr_kvarhbefore" name="stand_bkr_kvarhbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_psg_kvarh" name="stand_psg_kvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_psg_kvarhbefore" name="stand_psg_kvarhbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="stand_akhir_kvarh" name="stand_akhir_kvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " >
																<input type="hidden" id="stand_akhir_kvarhbefore" name="stand_akhir_kvarhbefore" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-12 ">
											<div class="text-center">
												<div class="btn-group" >
													<a type="button" id="BtnProses" onclick="proseshitung()" class="btn red" >PROSES HITUNG </a>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="table-scrollable">
												<table class="table table-bordered table-hover">
													<thead>
														<tr>
															<th style="width: 20%;">
																Uraian
															</th>
															<th>
																Faktor Kali
															</th>
															<th>
																Pemakaian KWH
															</th>
															<th>
																Biaya RPPTL
															</th>
														</tr>
													</thead>
													<tbody>
														<tr>
															<td class="active">
																LWBP
															</td>
															<td>
																<input type="text" id="fk_meterlwbp" name="fk_meterlwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="pemlwbp_billing" name="pemlwbp_billing" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="pemlwbp_cater" name="pemlwbp_cater" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="rplwbp" name="rplwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
														<tr>
															<td class="active">
																WBP
															</td>
															<td>
																<input type="text" id="fk_meterwbp" name="fk_meterwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="pemwbp_billing" name="pemwbp_billing" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="pemwbp_cater" name="pemwbp_cater" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="rpwbp" name="rpwbp" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
														<tr>
															<td class="active">
																KVARH
															</td>
															<td>
																<input type="text" id="fk_meterkvarh" name="fk_meterkvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="pemkvarh_billing" name="pemkvarh_billing" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
																<input type="hidden" id="pemkvarh_cater" name="pemkvarh_cater" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
															<td>
																<input type="text" id="rpkvarh" name="rpkvarh" class="form-control input-sm" style="text-align:right;" placeholder=" " readonly>
															</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-md-12 ">
											<div class="text-center">
												<div class="btn-group" >
													<a class="btn default green" data-toggle="modal" href="#small" id="BtnSave">SIMPAN STAND</a>
												</div>
											</div>
										</div>
									</div>
								</div>
							<!-- selesai -->
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title">KONFIRMASI</h4>
							</div>
							<div class="modal-body">
								 <label>APAKAH ANDA YAKIN AKAN MELAKUKAN KOREKSI REKENING ?? BERIKAN ALASANMU</label>
								 <textarea class="form-control" rows="3" id="alasan_rubah" name="alasan_rubah"></textarea>
							</div>
							<div class="modal-footer">
								<a type="button" class="btn default" data-dismiss="modal">BATAL</a>
								<a type="button" onclick="save()" class="btn blue">YAKIN</a>
							</div>
					</div>
				</div>
			</div>
</form>
<style type="text/css">
		#loading{
			position:fixed;
			top:0;
			left:0;
			z-index:9999;
			text-align:center;
			width:100%;
			height:100%;
			padding-top:300px;
			font:bold 20px Calibri,Arial,Sans-Serif;
			color:#000;
			display:none;
		}
			::selection{ background-color: #E13300; color: white; }
			::moz-selection{ background-color: #E13300; color: white; }
			::webkit-selection{ background-color: #E13300; color: white; }
	</style>
	<div class="modal fade bs-modal-sm" id="loading" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<img src="<?php echo base_url();?>assets/img/loader.gif"/>
				<p id=""> Mohon Tunggu Sebentar</p>
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
	var save_method = 'update' ;
    var url;
	var cekinputsm = $(".input-sm").val();
	var cektgl 	   = $(".datepicker").val();
	var alasan     = $("#alasan_rubah").val();
	if(alasan == ''){
		alert("MOHON ISI ALASAN KOREKSI"); 
		return false
	}
	if(cektgl == ''){
		alert("TANGGAL TIDAK BOLEH KOSONG"); 
		return false
	}
	if(cekinputsm == ''){
		alert("NILAI TIDAK BOLEH KOSONG MINIMAL HARUS DI ISI 0"); 
		return false
	}
	$('#small').modal().hide();
	$('#loading').modal({backdrop: 'static'});
	var carix   	= document.getElementById("cari").value;
	var stawallwbp  = document.getElementById("stand_awal_lwbp").value;
	var stawalwbp   = document.getElementById("stand_awal_wbp").value;
	var stawalkvarh = document.getElementById("stand_awal_kvarh").value;
	var stbkrlwbp   = document.getElementById("stand_bkr_lwbp").value;
	var stbkrwbp    = document.getElementById("stand_bkr_wbp").value;
	var stbkrkvarh  = document.getElementById("stand_bkr_kvarh").value;
	var stpsglwbp   = document.getElementById("stand_psg_lwbp").value;
	var stpsgwbp    = document.getElementById("stand_psg_wbp").value;
	var stpsgkvarh  = document.getElementById("stand_psg_kvarh").value;
	var stakhirlwbp = document.getElementById("stand_akhir_lwbp").value;
	var stakhirwbp  = document.getElementById("stand_akhir_wbp").value;
	var stakhirkvarh= document.getElementById("stand_akhir_kvarh").value;
	var val = "/"+carix+"/"+stawallwbp+"/"+stawalwbp+"/"+stawalkvarh+"/"+stbkrlwbp+"/"+stbkrwbp+"/"+stbkrkvarh+"/"+stpsglwbp+"/"+stpsgwbp+"/"+stpsgkvarh+"/"+stakhirlwbp+"/"+stakhirwbp+"/"+stakhirkvarh ;
	
    url = "<?php echo site_url('cater/prosessimpankwhperlang')?>"+val;
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			uploaddpm();
		},
        error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#loading').modal('hide')},1000);
			document.getElementById("sukses").innerHTML = "Proses Koreksi Stand Gagal!!";
        }
    });
	$('#BtnSave').attr('disabled',true);
}

function uploaddpm(){
	var carix   	= document.getElementById("cari").value;
	var url = '<?php echo base_url(); ?>index.php/billing/prosesuploaddpmkoreksi/'+carix;
	$.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			hitungrekening();
		},
        error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#loading').modal('hide')},1000);
			document.getElementById("sukses").innerHTML = "Proses Koreksi Stand Gagal!!";
        }
    });
	$('#BtnSave').attr('disabled',false);
}

function hitungrekening(){
	var carix   	= document.getElementById("cari").value;
	var stawallwbp  = document.getElementById("stand_awal_lwbp").value;
	var stawalwbp   = document.getElementById("stand_awal_wbp").value;
	var stawalkvarh = document.getElementById("stand_awal_kvarh").value;
	var stbkrlwbp   = document.getElementById("stand_bkr_lwbp").value;
	var stbkrwbp    = document.getElementById("stand_bkr_wbp").value;
	var stbkrkvarh  = document.getElementById("stand_bkr_kvarh").value;
	var stpsglwbp   = document.getElementById("stand_psg_lwbp").value;
	var stpsgwbp    = document.getElementById("stand_psg_wbp").value;
	var stpsgkvarh  = document.getElementById("stand_psg_kvarh").value;
	var stakhirlwbp = document.getElementById("stand_akhir_lwbp").value;
	var stakhirwbp  = document.getElementById("stand_akhir_wbp").value;
	var stakhirkvarh= document.getElementById("stand_akhir_kvarh").value;
	var val = "/"+carix+"/"+stawallwbp+"/"+stawalwbp+"/"+stawalkvarh+"/"+stbkrlwbp+"/"+stbkrwbp+"/"+stbkrkvarh+"/"+stpsglwbp+"/"+stpsgwbp+"/"+stpsgkvarh+"/"+stakhirlwbp+"/"+stakhirwbp+"/"+stakhirkvarh ;
	
	var url = '<?php echo base_url(); ?>index.php/billing/prosessimpanrekeningperlang/'+val;
	$.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			setTimeout(function(){$('#loading').modal('hide')},1000);
			document.getElementById("sukses").innerHTML = "Proses Koreksi Stand Berhasil!!";
		},
        error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#loading').modal('hide')},1000);
			document.getElementById("sukses").innerHTML = "Proses Koreksi Stand Gagal!!";
        }
    });
	$('#BtnSave').attr('disabled',false);
}

</script>
</body>
</html>