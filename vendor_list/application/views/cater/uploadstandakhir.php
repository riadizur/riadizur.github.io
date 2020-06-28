<?php
	if($this->session->flashdata('msg')==TRUE):
	echo'<div class="alert alert-success" role="alert">';
	echo $this->session->flashdata('msg');
	echo "</div>";
	endif;
?>

<script>
$(document).ready(function() {
	var file = document.getElementById("file");
	var baseUrl = '<?php echo base_url(); ?>index.php/cater/cekstatusdpm/';
		step = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					step = obj.STATUS_DPM;
					if(step == '0'){
						$('#BtnUpload').attr('disabled',false);
						file.disabled = false;
						document.getElementById("sukses").innerHTML = "";
					}else if(step== '1'){
						$('#BtnUpload').attr('disabled',true);
						file.disabled = "disabled";
						document.getElementById("sukses").innerHTML = "Anda Sudah Melakukan Upload Stand !!";
					}else if(step== '2'){
						$('#BtnUpload').attr('disabled',true);
						file.disabled = "disabled";
						document.getElementById("sukses").innerHTML = "Anda Sudah Melakukan Hitung KWH !!";
					}else if(step== '3'){
						$('#BtnUpload').attr('disabled',true);
						file.disabled = "disabled";
						document.getElementById("sukses").innerHTML = "Anda Sudah Melakukan Upload DPM Final !!";
					}else{
						$('#BtnUpload').attr('disabled',true);
						file.disabled = "disabled";
						document.getElementById("sukses").innerHTML = "Anda Belum Melakukan Download Stand Akhir !!";
					}
				});
			}
		});

});
</script>
			<div> <p id="sukses" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Upload Stand <small>Catat Meter</small></h1>
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
								<i class="fa fa-gift"></i> Upload Stand dengan File
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
							<form action="<?php echo base_url();?>index.php/cater/uploadfilestand/" enctype="multipart/form-data" method="post">
								<div class="form-body">								
									<div class="form-group">
										<label class="col-md-6 control-label">Tahun Bulan Rekening</label>
										<div class="col-md-6">
											<input type="text" id="thblrek" name="thblrek" class="form-control input" placeholder=" " readonly="true" value="<?php echo $thblrek; ?>">
										</div>
									</div>
									<div class="form-group">
										<label for="file">Pilih File</label>
										<input type="file" name="file" id="file">
										<p class="help-block">
											 File Berbentuk Excel.
										</p>
									</div>
								</div>
								<div class="form-actions">
									<button type="submit" id="BtnUpload" name="BtnUpload" class="btn blue">Upload Sekarang</button>
								</div>
							</form>
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
										<p> 1.	Klik Browse pada form disamping kiri </p>
										<p> 2.	Pilih File format .XLXS (ex: Hasil_Download_Stand_Awal_201711.xlxs )</p>
										<p> 3.	Klik Oke </p>
										<p> 4.	Lalu Klik Tombol Upload </p>
										<p> 5.	Jika Sukses akan muncul keterangan "Berhasil upload!!" </p>
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
								<i class="fa fa-gift"></i> Data Hasil Upload Stand Akhir
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
									 Tanggal Baca Akhir
								</th>
								<th>
									 Stand Akhir LWBP
								</th>
								<th>
									 Stand Akhir WBP
								</th>
								<th>
									 Stand Akhir KVARH
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
            "url": "<?php echo site_url('cater/upload_list')?>",
            "type": "POST"
        },
        "columnDefs": [
        { 
            "orderable": false, //set not orderable
            "className": "text-right", 
            "targets": [4,5,6]
        },
        ],
    });

});
</script>

</body>
</html>