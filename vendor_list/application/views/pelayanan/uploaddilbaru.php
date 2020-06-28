<?php
	if($this->session->flashdata('msg')==TRUE):
	echo'<div class="alert alert-success" role="alert">';
	echo $this->session->flashdata('msg');
	echo "</div>";
	endif;
?>
<script>
function cutoffdil(){
	$('#mod').modal('hide');
	$('#BtnUpload').text('Sedang Memproses...'); 
    $('#BtnUpload').attr('disabled',true);
	$('#small').modal({backdrop: 'static'});
	
	$.ajax({
		url: '<?php echo base_url(); ?>/index.php/pelayanan/cutoffdil/',
		type: "POST",
		dataType:"json",
		success:function(datas){
			setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnUpload').text('Proses Upload DIL'); 
			$('#BtnUpload').attr('disabled',false);
			document.getElementById("sukses").innerHTML = "Proses Upload DIL Berhasil!!";
			table.ajax.reload(null,false);
		},
		error: function (jqXHR, textStatus, errorThrown)
        {
            setTimeout(function(){$('#small').modal('hide')},1000);
			$('#BtnUpload').text('Proses Upload DIL'); 
			$('#BtnUpload').attr('disabled',false);
			document.getElementById("sukses").innerHTML = "Proses Upload DIL GAGAL !!";
			table.ajax.reload(null,false);
        }
	});
}
</script>
			<div> <p id="sukses" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Upload DIL Baru <small>Billing</small></h1>
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
								<i class="fa fa-gift"></i> Upload DIL Baru dengan File
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
							<div class="form-body">								
								<div class="form-group">
									<center><button type="button" data-toggle="modal" href="#mod" class="btn default btn-lg blue">Upload Sekarang</button></center>
								</div>
							</div>
						</div>						
					</div>
				</div>
				<div class="col-md-6 ">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Panduan Cara Upload
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
								<div class="form-body">	
									<div class="news-blocks">
										<p> &nbsp; </p>
										<p> Cara Upload: </p>
										<p> 1.	Klik Upload Sekarang </p>
										<p> 2.	Silahkan Tunggu</p>
										<p> 3.	Jika Sukses akan muncul keterangan "Berhasil upload!!" </p>
									</div>
								</div>
						</div>						
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 ">
					<div class="portlet box blue">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Data Hasil Upload DIL Baru
							</div>
							<div class="tools">
								<a href="" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="" class="reload">
								</a>
							</div>
						</div>
						<div class="portlet-body form">
						<div class="form-body">	
							<table class="table table-striped table-bordered table-hover" id="table">
							<thead>
							<tr>
								<th>
									 THBLREK
								</th>
								<th>
									 ID Langganan
								</th>
								<th>
									 Nama Langganan
								</th>
								<th>
									 ALAMAT Langganan
								</th>
								<th>
									 Kota Langganan
								</th>
								<th>
									 Provinis Langganan
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
			<div class="modal fade bs-modal-sm" id="mod" tabindex="-1" role="dialog" aria-hidden="true">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">KONFIRMASI</h4>
						</div>
						<div class="modal-body">
							 APAKAH ANDA YAKIN AKAN MELAKUKAN CUT OFF DIL ??
						</div>
						<div class="modal-footer">
							<a type="button" class="btn default" data-dismiss="modal">BATAL</a>
							<a type="button" id="BtnUpload" name="BtnUpload" onclick="cutoffdil()" class="btn blue">YAKIN</a>
						</div>
					</div>
				</div>
			</div>
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
            "url": "<?php echo site_url('pelayanan/dilnew_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "targets": [ -1 ], //last column
            "orderable": false, //set not orderable
        },
        ],
    });

});
</script>

</body>
</html>