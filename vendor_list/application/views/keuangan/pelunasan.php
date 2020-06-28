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
	
	$("#satu").show();
	$("#dua").hide();
	$("#tiga").hide();
	
	document.getElementById("valid").innerHTML = " ";
});

function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caripelunasan/'+carix;
		$('#btnPrint').attr('disabled',false);
		$('#btnSave').attr('disabled',false);
		document.getElementById("valid").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.NO_AGENDA;
					$("#no_agenda").val(obj.NO_AGENDA);
					$("#id_cust").val(obj.ID_CUST);
					$("#id_lang").val(obj.ID_LANG);
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#daya_baru").val(obj.DAYA_BARU);
					$("#tarif_baru").val(obj.TARIF_BARU);
					$("#jns_transaksi").val(obj.JNS_TRANSAKSI);
					$("#jns_pelunasan").val(obj.JNS_PELUNASAN).trigger('change');
					
					if(obj.JNS_TRANSAKSI == "PASANG BARU" || obj.JNS_TRANSAKSI == "PERUBAHAN DAYA" || obj.JNS_TRANSAKSI == "BALIK NAMA"){ 
						$("#satu").show();
						$("#dua").hide();
						$("#tiga").hide();
						
						$("#rp_bp").val(number_format(obj.RP_BP));
						$("#rp_ujl_tagih").val(number_format(obj.RP_UJL_TAGIH));
						$("#materai1").val(number_format(obj.MATERAI));
						var total = parseInt(obj.RP_BP) + parseInt(obj.RP_UJL_TAGIH) + parseInt(obj.MATERAI);
						
						$("#total_biaya").val(number_format(total));						
					}
					
					if(obj.JNS_TRANSAKSI == "PENERANGAN SEMENTARA"){ 
						$("#dua").show();
						$("#satu").hide();
						$("#tiga").hide(); 
						
						$("#rpkwh_ps").val(number_format(obj.RPKWH_PS));
						$("#rp_material").val(number_format(obj.RP_BP));
						$("#rpbpju_ps").val(number_format(obj.RPBPJU_PS));
						$("#materai2").val(number_format(obj.MATERAI));
						var totsementara = parseInt(obj.RPKWH_PS) + parseInt(obj.RP_BP) + parseInt(obj.RPBPJU_PS) + parseInt(obj.MATERAI);
						$("#total_biaya2").val(number_format(totsementara));
					
					}
					if(obj.JNS_TRANSAKSI == "BERHENTI LANGGANAN"){ 
						$("#tiga").show();
						$("#satu").hide();
						$("#dua").hide(); 
						
						var STAND_BKR_LWBP  = obj.STAND_BKR_LWBP;
						var STAND_BKR_WBP   = obj.STAND_BKR_WBP;
						var STAND_BKR_KVARH = obj.STAND_BKR_KVARH;
						
						var MATERAI = obj.MATERAI;
						var SISA_RPLWBPX  = obj.SISA_RPLWBP;
						var SISA_RPWBPX   = obj.SISA_RPWBP;
						var SISA_RPKVARHX = obj.SISA_RPKVARH;
						var ppj = (parseFloat(obj.KD_PPJ) / 100);
						var tarif = obj.TARIF_BARU;
						
						berhentilang(STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,SISA_RPLWBPX,SISA_RPWBPX,SISA_RPKVARHX,ppj,tarif,MATERAI)
					}
					
					var cekno = obj.NO_KWITANSI;
					var ceksts = obj.STATUS_CTK_KWITANSI;
					
					if(cekno == '' || cekno == null){
						$('#btnPrint').attr('disabled',true);
						otokwitansi(obj.KD_AREA);
							if(ceksts == '0' || ceksts == null){
								$('#btnPrint').attr('disabled',false);
								$('#btnSave').attr('disabled',false);
								document.getElementById("valid").innerHTML = " ";
							}
					}else{
						$("#no_kwitansi").val(obj.NO_KWITANSI);
							if(ceksts == '0' || ceksts == null){
								$('#btnPrint').attr('disabled',false);
								$('#btnSave').attr('disabled',true);
								document.getElementById("valid").innerHTML = " ";
							}else{
								$('#btnPrint').attr('disabled',true);
								$('#btnSave').attr('disabled',true);
								document.getElementById("valid").innerHTML = "PELANGGAN SUDAH LUNAS KUITANSI HANYA DAPAT DI CETAK SATU KALI ";
							}
					}
	
				});
				if(ck==''){
					$('[name="cari"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="cari"]').attr('value',''); 
					$('[name="cari"]').attr('placeholder','Data tidak ada');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});		
}

function berhentilang(STAND_BKR_LWBP,STAND_BKR_WBP,STAND_BKR_KVARH,SISA_RPLWBPX,SISA_RPWBPX,SISA_RPKVARHX,ppj,tarif,MATERAI){
	var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caritarif/'+tarif;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					
					var SISA_RPLWBP  = parseFloat(SISA_RPLWBPX) * parseFloat(obj.RP_LWBP);
					var SISA_RPWBP   = parseFloat(SISA_RPWBPX) * parseFloat(obj.RP_WBP);
					var SISA_RPKVARH = parseFloat(SISA_RPKVARHX) * parseFloat(obj.RP_KVARH);
					
					var TOTAL 		= parseFloat(SISA_RPLWBP) + parseFloat(SISA_RPWBP) + parseFloat(SISA_RPKVARH);
					var PPJZ 		= Math.round(parseFloat(TOTAL) * (parseFloat(ppj)));
					var TOTALKES 	= parseFloat(TOTAL) + parseInt(MATERAI) + parseFloat(PPJZ);

					$("#stand_bkr_lwbp").val(number_format(STAND_BKR_LWBP));
					$("#stand_bkr_wbp").val(number_format(STAND_BKR_WBP));
					$("#stand_bkr_kvarh").val(number_format(STAND_BKR_KVARH));
					$("#kd_ppj").val(number_format(PPJZ));
					$("#materai3").val(number_format(MATERAI));
					$("#total_biaya3").val(number_format(TOTALKES));	
				});
			}
		});
}

function cetak(x){
	var no_agenda = document.getElementById('no_agenda').value;
	if(no_agenda == ''){
		alert("Nomor Agenda Kosong");
		return false;
	}
	hreF	= "<?php echo site_url("Laporan/rpt_kwitansipt")?>";
	ReQuest	= "/" + x + "/" +no_agenda;
	window.open(hreF+ReQuest, '_blank');
}

function otokwitansi(area){
	var no_kwitansi = document.getElementById('no_kwitansi').value;
	var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/otokwitansi/';
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					var noagd = document.getElementById('no_agenda').value;
					var X 		 = noagd.substr(5,3);
					var nk		 = obj.NOKWIT;
					var kwitansi = 'KEU-'+area+'-'+X+'-'+nk;
					$("#no_kwitansi").val(kwitansi);
				});
			}
		});
}

</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Pelunasan PB, PD, PS, dan Bongkar <small>Keuangan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Pencarian
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<label class="col-md-3 control-label align-left">Masukan No Agenda</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn blue">Cari </a>
											</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<p id="valid" style="color: red;"></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
<form action="#" id="form" class="form-horizontal" role="form">				
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>
								<span class="caption-subject font-green-sharp bold">Informasi</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">No Kwitansi</label>
											<div class="col-md-6">
												<input type="text" id="no_kwitansi" name="no_kwitansi" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">No Agenda</label>
											<div class="col-md-6">
												<input type="text" id="no_agenda" name="no_agenda" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-md-6 control-label align-left">ID Customer</label>
											<div class="col-md-6">
												<input type="text" id="id_cust" name="id_cust" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">ID Langganan</label>
											<div class="col-md-6">
												<input type="text" id="id_lang" name="id_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Nama Langganan</label>
											<div class="col-md-6">
												<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Alamat Langganan</label>
											<div class="col-md-6">
												<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Tarif</label>
											<div class="col-md-6">
												<input type="text" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Daya</label>
											<div class="col-md-6">
												<input type="text" id="daya_baru" name="daya_baru" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Jenis Transaksi</label>
											<div class="col-md-6">
												<input type="text" id="jns_transaksi" name="jns_transaksi" class="form-control input-sm" placeholder=" " readonly>
											</div>
										</div>
										<div id="satu">
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
													<input type="text" id="materai1" name="materai1" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Total Biaya</label>
												<div class="col-md-6">
													<input type="text" id="total_biaya" name="total_biaya" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
										</div>
										<div id="dua">
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Biaya KWH</label>
												<div class="col-md-6">
													<input type="text" id="rpkwh_ps" name="rpkwh_ps" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Biaya Material</label>
												<div class="col-md-6">
													<input type="text" id="rp_material" name="rp_material" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Biaya BPJU</label>
												<div class="col-md-6">
													<input type="text" id="rpbpju_ps" name="rpbpju_ps" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Biaya Materai</label>
												<div class="col-md-6">
													<input type="text" id="materai2" name="materai2" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Total Biaya</label>
												<div class="col-md-6">
													<input type="text" id="total_biaya2" name="total_biaya2" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
										</div>
										<div id="tiga">
											<div class="form-group">
												<label class="col-md-6 control-label align-left">LWBP</label>
												<div class="col-md-6">
													<input type="text" id="stand_bkr_lwbp" name="stand_bkr_lwbp" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">WBP</label>
												<div class="col-md-6">
													<input type="text" id="stand_bkr_wbp" name="stand_bkr_wbp" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">KVARH</label>
												<div class="col-md-6">
													<input type="text" id="stand_bkr_kvarh" name="stand_bkr_kvarh" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">PPJ</label>
												<div class="col-md-6">
													<input type="text" id="kd_ppj" name="kd_ppj" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Materai</label>
												<div class="col-md-6">
													<input type="text" id="materai3" name="materai3" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Total Biaya</label>
												<div class="col-md-6">
													<input type="text" id="total_biaya3" name="total_biaya3" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label class="control-label align-left col-md-6">Pembayaran Melalui</label>
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
													<i class="fa fa-user"></i>
													</span>
													<select id="jns_pelunasan" name="jns_pelunasan" class="form-control select2me" data-placeholder="Select...">
														<option value="NOSELECT">-- Pembayaran melalui ? --</option>
														<option value="OFFLINE">OFFLINE</option>
														<option value="ONLINE">ONLINE</option>
														<option value="DI ALIHKAN">DI ALIHKAN</option>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="col-md-6">
												&nbsp;
											</div>
										</div>
										<div class="form-group">
											<a type="button" id="btnSave" onclick="save()" class="btn blue "> Proses Pembayaran </a>
											<a type="button" id="btnPrint" onclick="cetak(1)" class="btn yellow "> Cetak Kwitansi</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
</form>
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

function save(){
	var cek = document.getElementById("jns_pelunasan").value;
	if(cek == 'NOSELECT'){alert("Pilih Jenis Pembayaran dulu"); return false}
	var save_method = 'update';
    var url;
    if(save_method == 'add') {
        url = "<?php echo site_url('keuangan/pelunasan_add')?>";
    } else {
        url = "<?php echo site_url('keuangan/pelunasan_update')?>";
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