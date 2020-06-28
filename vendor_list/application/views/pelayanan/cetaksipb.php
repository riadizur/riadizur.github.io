<script>
function cetak(x){
	var noagd = document.getElementById("no_agenda").value;
	var jns = document.getElementById("jns_transaksi").value;
	if(jns == 'PASANG BARU'){
		hreF	= "<?php echo site_url("Laporan/rpt_sip")?>";
	}else if(jns == 'PERUBAHAN DAYA' ){
		hreF	= "<?php echo site_url("Laporan/rpt_sip_pd")?>";
	}else if(jns == 'BALIK NAMA'){
		hreF	= "<?php echo site_url("Laporan/rpt_sip_pn")?>";
	}else if(jns == 'PENERANGAN SEMENTARA'){
		hreF	= "<?php echo site_url("Laporan/rpt_sip_ps")?>";
	}else if(jns == 'BERHENTI LANGGANAN'){
		hreF	= "<?php echo site_url("Laporan/rpt_sip_bongkar")?>";
	}
	
	ReQuest	= "/" + x +"/" + noagd;
	window.open(hreF+ReQuest, '_blank');
	location.href = "<?php echo base_url(); ?>index.php/pelayanan/cetaksipb/";
}

function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cariagenda/'+carix;
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck   = obj.NO_AGENDA;
					cek  = obj.NO_SIP;
					cek2 = obj.TGL_ENTRI_SURVEY;
					if(cek2=='0000-00-00 00:00:00'){ 
						alert("Anda Belum melakukan Survey"); 
					}else{
						$("#no_agenda").val(obj.NO_AGENDA);
						$("#id_cust").val(obj.ID_CUST);
						$("#id_lang").val(obj.ID_LANG);
						$("#nama_lang").val(obj.NAMA_LANG);
						$("#alamat_lang").val(obj.ALAMAT_LANG);
						$("#daya_baru").val(obj.DAYA_BARU);
						$("#tarif_baru").val(obj.TARIF_BARU);
						$("#rp_bp").val(obj.RP_BP);
						$("#rp_ujl_tagih").val(obj.RP_UJL_TAGIH);
						$("#materai").val(obj.MATERAI);
						$("#total_biaya").val(obj.TOTAL_BIAYA);
						$("#jns_transaksi").val(obj.JNS_TRANSAKSI);
						if(cek==''){otosipb();}else{$("#no_sipb").val(obj.NO_SIP);}
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

function otosipb(){
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/otosipb/';
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#no_sipb").val(obj.urut);
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Hubungi Adminstrator");
			}
		});
}

</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Cetak Surat Informasi Persetujuan Biaya<small>Pelayanan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 ">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Cetak SIPB
							</div>
						</div>
						<div class="portlet-body form">
							<form action="#" enctype="multipart/form-data" method="post">
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-5 control-label">Cari No. Agenda</label>
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">No. SIPB</label>
										<div class="input-group">
											<input id="no_sipb" name="no_sipb" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">No. Agenda</label>
										<div class="input-group">
											<input id="no_agenda" name="no_agenda" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">ID. Customer</label>
										<div class="input-group">
											<input id="id_cust" name="id_cust" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">ID. Langganan</label>
										<div class="input-group">
											<input id="id_lang" name="id_lang" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">Jenis Transaksi</label>
										<div class="input-group">
											<input id="jns_transaksi" name="jns_transaksi" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">Nama Langganan</label>
										<div class="input-group">
											<input id="nama_lang" name="nama_lang" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">Alamat Langganan</label>
										<div class="input-group">
											<input id="alamat_lang" name="alamat_lang" class="form-control" readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">Tarif</label>
										<div class="input-group">
											<input id="tarif_baru" name="tarif_baru" class="form-control"  readonly />
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-5 control-label">Daya</label>
										<div class="input-group">
											<input id="daya_baru" name="daya_baru" class="form-control" readonly />
										</div>
									</div>
								</div>
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-6 control-label">&nbsp;</label>
										
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" class="btn blue" onclick="cetak(1)">Cetak Sekarang</button>
								</div>
							</form>
						</div>					
					</div>
				</div>
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
<script>
jQuery(document).ready(function() {  
Metronic.init();
Layout.init();
Demo.init();
});
</script>
</body>
</html>