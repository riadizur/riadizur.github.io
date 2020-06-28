<script>
function caribylang(){
		var carix   = document.getElementById("caribylang").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caripelunasaninfo/'+carix;
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
				});
				loaddatabylang(ck);
				if(ck==''){
					$('[name="caribylang"]').parent().parent().parent().parent().addClass('has-error');
					$('[name="caribylang"]').attr('value','');
					$('[name="caribylang"]').attr('placeholder','Data tidak ada');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert("Selamat Pagi");
			}
		});
}

function loaddatabylang(ID_LANG){
	tablebylang = $('#tablebylang').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/lunasbylang_list')?>",
			"type": "POST",
			data: function(d) {
				d.id_lang = ID_LANG
			}
		},
		"columnDefs": [
		{
			"className": "text-right",
			"targets": [2,3,4],
		},
		],

	});
}

function cetakbylang(ID,THBLREK){
	hreF	= "<?php echo site_url("billing/invoice_thblrek")?>";
	ReQuest	= "/1/" +ID+"/"+THBLREK;
	window.open(hreF+ReQuest, '_blank');
}
</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Informasi Tagihan <small>invoice</small></h1>
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
									<label class="col-md-3 control-label align-left">Cari ID Langganan</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="caribylang" name="caribylang" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="caribylang()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 ">
					<div class="panel panel-success">
						<div class="panel-body">
						<div class="table-scrollable">
							<table class="table table-striped table-bordered table-hover" id="tablebylang">
								<thead>
									<tr>
										<th>
											 AKSI
										</th>
										<th>
											 THBLREK
										</th>
										<th>
											 ID LANGGANAN
										</th>
										<th>
											 NAMA LANGGANAN
										</th>
										<th>
											 RP TAGIH
										</th>
										<th>
											 RP BK
										</th>
										<th>
											 TOTAL INVOICE
										</th>
										<th>
											 TANGGAL LUNAS
										</th>
										<th>
											 STATUS
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
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

</script>
</body>
</html>