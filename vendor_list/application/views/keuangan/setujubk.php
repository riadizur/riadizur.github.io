			<div class="page-head">
				<div class="page-title">
					<h1>Persetujuan <small>Keuangan</small></h1>
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
								<i class="fa fa-globe"></i>
							</div>
							<div class="tools">
								<a href="javascript:;" class="collapse">
								</a>
								<a href="#portlet-config" data-toggle="modal" class="config">
								</a>
								<a href="javascript:;" class="reload">
								</a>
								<a href="javascript:;" class="remove">
								</a>
							</div>
						</div>
						<div class="portlet-body">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#tab_1_1" data-toggle="tab">
									List Approval </a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade active in" id="tab_1_1"> <!-- tab 1 -->
									<div class="table-toolbar">

									</div>
									<!-- tabel -->
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
											 RP BK
										</th>
										<th>
											 TANGGAL DI AJUKAN
										</th>
										<th>
											 PERMINTAAN
										</th>
										<th>
											 Aksi
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
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<script type="text/javascript" src="../../assets/global/plugins/select2/select2.min.js"></script>
<!-- TAMBAHAN
<script src="../../assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script> 
<script src="../../assets/jquery/jquery-2.1.4.min.js"></script>
-->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script> 
<script>

jQuery(document).ready(function() {
Metronic.init(); 
Layout.init();
Demo.init();
});

var save_method; 
var table;

$(document).ready(function() {
	
    table = $('#table').DataTable({ 
	
        "processing": true,
        "serverSide": true,
        "order": [],

        "ajax": {
            "url": "<?php echo site_url('keuangan/setujubk_list')?>",
            "type": "POST"
        },

        "columnDefs": [
        { 
            "orderable": false, 
			"className": "text-right", 
            "targets": [3,4]
        },
        ],

    });

    $('.datepicker').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "top auto",
        todayBtn: true,
        todayHighlight: true,  
    });
	
});

function reload_table()
{
    table.ajax.reload(null,false); 
}

function edit_setujubk(id_lang,thblrek,sts,minta)
{
    var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/setujubk_update/'+id_lang+'/'+thblrek+'/'+sts+'/'+minta;
    $.ajax({
		url: baseUrl,
		dataType: 'json',
		success: function(datas){
			table.ajax.reload(null,false);
			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Hubungi Adminstrator");
		}
	});
}



</script>
</body>
</html>