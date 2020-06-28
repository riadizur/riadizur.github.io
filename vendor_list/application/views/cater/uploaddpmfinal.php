<script>
$(document).ready(function(){
	document.getElementById("sukses").innerHTML = " ";
});
function hitungkwh(){
	$('#BtnHitung').text('Sedang Memproses...'); 
    $('#BtnHitung').attr('disabled',true);
	$('#small').modal({backdrop: 'static'});
	
	$.ajax({
		url: '<?php echo base_url(); ?>/index.php/cater/prosesuploaddpmfinal/',
		type: "POST",
		dataType:"json",
		success:function(datas){
			setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnHitung').text('Proses Hitung DPM'); 
			$('#BtnHitung').attr('disabled',false);
			document.getElementById("sukses").innerHTML = "Proses Upload DPM Final Berhasil!!";
			table.ajax.reload(null,false);
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnHitung').text('Proses Hitung DPM'); 
			$('#BtnHitung').attr('disabled',false);
			document.getElementById("sukses").innerHTML = "Proses Upload DPM Final GAGAL !!";
			table.ajax.reload(null,false);
        }
	});
}
</script>
			<div> <p id="sukses" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Upload DPM Final <small>Upload DPM Final</small></h1>
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
								<i class="fa fa-globe"></i>Upload DPM Final
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<div class="row">
									<div class="form-group">
										<label class="control-label col-md-2">Tahun Bulan Rekening</label>
										<div class="col-md-2">
											<input type="text" name="thblrek" id="thblrek" class="form-control" size="16" placeholder="Tahun Bulan Akhir" readonly="true" value="<?php echo $thblrek; ?>">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="btn-group">
											<a class="btn green" data-toggle="modal" onclick="hitungkwh()" id="BtnHitung" >Proses Upload DPM Final</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row ">
				<div class="col-md-12">
					<div class="portlet box grey-cascade">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>Hasil Upload DPM Final
							</div>
						</div>
						<div class="portlet-body">
							<div class="table-toolbar">
								<table class="table table-striped table-bordered table-hover" id="table">
									<thead>
									<tr>
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
											 PEMAKAIAN LWBP
										</th>
										<th>
											 PEMAKAIAN WBP
										</th>
										<th>
											 PEMAKAIAN KWH
										</th>
										<th>
											 PEMAKAIAN KVARH
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
			<!-- END PAGE CONTENT-->
			<style type="text/css">
				#small{
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
			<div class="modal fade bs-modal-sm" id="small" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<img src="<?php echo base_url();?>assets/img/loader.gif"/>
						<p id=""> Mohon Tunggu Sebentar</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END CONTENT -->
</div>
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
<!-- Tambahan -->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script> 
<script>
jQuery(document).ready(function() {
   Metronic.init();
Layout.init();
Demo.init();
});
</script>

<script>
var table;

$(document).ready(function() {
    table = $('#table').DataTable({ 
	
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('cater/final_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "orderable": false, //set not orderable
            "className": "text-right", 
            "targets": [3,4,5,6]
        },
        ],
    });

});
</script>

</body>
</html>