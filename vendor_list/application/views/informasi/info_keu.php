<script>
$(document).ready(function() {
	$("#tablearea").show();
	$("#tablecust").hide();
	$("#tablelang").hide();
	$("#tablethblrek").hide();

$("#filter").on("change", function(){
	var v = $(this).val();
	if(v == "AREA"){
		$("#tablearea").show();
		$("#tablecust").hide();
		$("#tablelang").hide();
		$("#tablethblrek").hide();
	}else if(v == "CUST" ){
		$("#tablearea").hide();
		$("#tablecust").show();
		$("#tablelang").hide();
		$("#tablethblrek").hide();
	}else if(v == "LANG"){
		$("#tablearea").hide();
		$("#tablecust").hide();
		$("#tablelang").show();
		$("#tablethblrek").hide();
	}else if(v == "THBLREK"){
		$("#tablearea").hide();
		$("#tablecust").hide();
		$("#tablelang").hide();
		$("#tablethblrek").show();
	}else{
		$("#tablearea").show();
		$("#tablecust").hide();
		$("#tablelang").hide();
		$("#tablethblrek").hide();
	}
});

});
function cetakdaftar(x){
	alert("On The Way");
	return false
	if(x==1){
		hreF	= "<?php echo site_url("Laporan/rpt_daftarstandakhir")?>";
		ReQuest = "/" + x + "/DAFTAR STAND";
		window.open(hreF+ReQuest, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_daftarstandakhirexcel")?>";
		window.open(hreF, '_blank');
	}
}

function cetakrekap(x){
	alert("On The Way");
	return false
	if(x==1){
		hreF	= "<?php echo site_url("Laporan/rpt_rekapstandakhir")?>";
		ReQuest = "/" + x + "/REKAP STAND";
		window.open(hreF+ReQuest, '_blank');
	}else{
		hreF	= "<?php echo site_url("Laporan/rpt_rekapstandakhirexcel")?>";
		window.open(hreF, '_blank');
	}
}

function loaddataarea(){
	tablekendalisatu = $('#tablekendalisatu').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalisatu_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],
	});
}

function loaddatacust(){
	tablekendalidua = $('#tablekendalidua').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalidua_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],
	});

}

function loaddatalang(){
	tablekendalitiga = $('#tablekendalitiga').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalitiga_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],
	});
}

function loaddatathblrek(){
	tablekendalitiga = $('#tablekendalitiga').DataTable({
		destroy: true,
		"processing": true,
		"serverSide": true,
		"order": [],
		"ajax": {
			"url": "<?php echo site_url('keuangan/kendalitiga_list')?>",
			"type": "POST",
		},
		"columnDefs": [
			{"orderable": false, "targets": [0,1,2,3,4,5,6,7,8],},
			{"className": "text-right", "targets": [3,4,5],},
		],

	});
}

function cetakgolexcel(THBLREK,KOGOL){
	hreF	= "<?php echo site_url("Laporan/rpt_detgolexcel")?>"+"/"+THBLREK+"/"+KOGOL;
	window.open(hreF, '_blank');
}

function cetakareaexcel(THBLREK,KDAREA){
	hreF	= "<?php echo site_url("Laporan/rpt_detareaexcel")?>"+"/"+THBLREK+"/"+KDAREA;
	window.open(hreF, '_blank');
}

</script>
			<div class="page-head">
				<div class="page-title">
					<h1>Monitoring Keuangan <small>Informasi Keuangan</small></h1>
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
								<i class="fa fa-gift"></i>Monitoring Keuangan
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									Rekap Rekening Terbit per Area</a>
								</li>
								<li>
									<a href="#tab_1_4" data-toggle="tab">
									Rekap Rekening Terbit per Golongan</a>
								</li>
								<li>
									<a href="#tab_1_2" data-toggle="tab">
									Rekap Saldo </a>
								</li>
								<li>
									<a href="#tab_1_3" data-toggle="tab">
									Rekap Pelunasan </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1">


									<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekaprek">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 KODE AREA
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML DAYA
												</th>
												<th>
													 JML KWH
												</th>
												<th>
													 JML RPPTL
												</th>
												<th>
													 JML ANGSURAN
												</th>
												<th>
													 JML RPBPJU
												</th>
												<th>
													 JML RP MATERAI
												</th>
												<th>
													 JML TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>

								</div>
								<div class="tab-pane fade" id="tab_1_2">
									<div class="form-group">
										<label class="control-label align-right col-md-3">Pilih Filter</label>
										<div class="col-md-6">
											<div class="input-group">
												<span class="input-group-addon">
												<i class="fa fa-user"></i>
												</span>
												<select id="filter" name="filter" class="form-control select2me" data-placeholder="Select..." style="width:100%;">
													<option value=" ">-- Pilih --</option>
													<option value="AREA" selected>AREA</option>
													<option value="CUST">CUSTOMER</option>
													<option value="LANG">LANGGANAN</option>
													<option value="THBLREK">THBLREK</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">&nbsp;</label>
											<div class="col-md-6">
												<input type="hidden" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
									<div class="table-scrollable">
										<div class="table-scrollable">
										<table class="table table-striped table-bordered table-hover" id="tablearea">
										<thead>
											<tr>
												<th>
													 AREA
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablecust">
										<thead>
											<tr>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablethblrek">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										<table class="table table-striped table-bordered table-hover" id="tablelang">
										<thead>
											<tr>
												<th>
													 ID CUSTOMER
												</th>
												<th>
													 ID LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 TOTAL RP EPI
												</th>
												<th>
													 TOTAL BPJU
												</th>
												<th>
													 TOTAL MATERAI
												</th>
												<th>
													 TOTAL TAGIHAN
												</th>
												<th>
													 TOTAL BK
												</th>
												<th>
													 TOTAL INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
										</table>
										</div>
									</div>

								</div>
								<div class="tab-pane fade" id="tab_1_3">
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekaplunas">
										<thead>
											<tr>
												<th>
													 THBL LUNAS
												</th>
												<th>
													 JML CUSTOMER
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML LEMBAR
												</th>
												<th>
													 RP EPI
												</th>
												<th>
													 RP BPJU
												</th>
												<th>
													 RP MATERAI
												</th>
												<th>
													 RP TAGIHAN
												</th>
												<th>
													 RP BK
												</th>
												<th>
													 RP INVOICE
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>

								</div>
								<div class="tab-pane fade" id="tab_1_4">
								<div class="table-scrollable">
									<table class="table table-striped table-bordered table-hover" id="tablerekaprekgol">
										<thead>
											<tr>
												<th>
													 THBLREK
												</th>
												<th>
													 GOLONGAN
												</th>
												<th>
													 JML LANGGANAN
												</th>
												<th>
													 JML DAYA
												</th>
												<th>
													 JML KWH
												</th>
												<th>
													 JML RPPTL
												</th>
												<th>
													 JML ANGSURAN
												</th>
												<th>
													 JML RPBPJU
												</th>
												<th>
													 JML RP MATERAI
												</th>
												<th>
													 JML TAGIHAN
												</th>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									</div>

								</div>
							</div>
							<div class="clearfix margin-bottom-20">
							</div>
						</div>
					</div>
					<!-- END EXAMPLE TABLE PORTLET-->
				</div>
			</div>
			<!-- END PAGE CONTENT-->
		</div>
	</div>
	<!-- END CONTENT -->
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
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!-- TAMBHAN -->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script>
<script>
jQuery(document).ready(function() {
Metronic.init();
Layout.init();
Demo.init();
});

$(document).ready(function() {

	tablerekaprek = $('#tablerekaprek').DataTable({
		destroy: true,
		"pageLength": 4,
		"oLanguage": { "sSearch": "CARI THBLREK: " },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/rekaprek_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8,9]
        },
        ],
    });

	tablerekaplunas = $('#tablerekaplunas').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/rekaplunas_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });

	tablearea = $('#tablearea').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldoarea_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });

	tablecust = $('#tablecust').DataTable({
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
		destroy: true,
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldocust_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [2,3,4,5,6,7]
        },
        ],
    });

	tablelang = $('#tablelang').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldolang_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [3,4,5,6,7,8]
        },
        ],
    });

	tablethblrek = $('#tablethblrek').DataTable({
		destroy: true,
        "processing": true,
        "serverSide": true,
		"paging":   false,
        "ordering": false,
        "info":     false,
		"searching": false,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/saldothblrek_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });

	tablerekaprekgol = $('#tablerekaprekgol').DataTable({
		destroy: true,
		"pageLength": 5,
		"oLanguage": { "sSearch": "CARI THBLREK: " },
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('informasi/rekaprekgol_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        {
            "orderable": false,
			"className": "text-right",
            "targets": [4,5,6,7,8,9]
        },
        ],
    });


});

</script>
</body>
</html>
