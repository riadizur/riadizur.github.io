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
	
	document.getElementById("valid").innerHTML = " ";
	$("#lang_bayar").hide();
	
	$("#status_bk").on("change", function(){
		var v = $(this).val();
		if(v == "0"){ $("#lang_bayar").show(); }else{$("#lang_bayar").hide(); }
	});
});

function cari(){
		var carix   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/keuangan/caribk/'+carix;
		$('#btnPrint').attr('disabled',false);
		$('#btnSave').attr('disabled',false);
		document.getElementById("valid").innerHTML = " ";
		ck = [];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
					$("#id_cust").val(obj.ID_CUST);
					$("#thblrek").val(obj.THBLREK);
					$("#id_lang").val(obj.ID_LANG);
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#daya").val(obj.DAYA);
					$("#tarif").val(obj.TARIF);
				});
				loaddata(ck);
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

function cetak(x){
	var id_lang = document.getElementById('id_lang').value;
	if(id_lang == ''){
		alert("ID Langganan Kosong");
		return false;
	}
	hreF	= "<?php echo site_url("Laporan/rpt_kwitansipt")?>";
	ReQuest	= "/" + x + "/" +id_lang;
	window.open(hreF+ReQuest, '_blank');
}

</script>
			<div> <p id="valid" style="color: red;"> </p> </div>
			<div class="page-head">
				<div class="page-title">
					<h1>Pembatalan BK<small>Keuangan</small></h1>
				</div>
				<div class="page-toolbar">
					<div class="btn-group btn-theme-panel">
					</div>
				</div>
			</div>
			<div class="row">
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
									<div class="col-md-9">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-md-12 ">
					<div class="portlet box green">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-gift"></i> Pembatalan BK
							</div>
						</div>
						<div class="portlet-body form">
	<form action="#" id="form" class="form-horizontal" role="form">
								<div class="row">
									<div class="form-body">
										<div class="col-md-12">		
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">ID. Customer</label>
												<div class="col-md-4">
													<input type="text" id="id_cust" name="id_cust" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">ID. Langganan</label>
												<div class="col-md-4">
													<input type="text" id="id_lang" name="id_lang" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">Nama Langganan</label>
												<div class="col-md-4">
													<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">Alamat Langganan</label>
												<div class="col-md-4">
													<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">Tarif</label>
												<div class="col-md-4">
													<input type="text" id="tarif" name="tarif" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">Daya</label>
												<div class="col-md-4">
													<input type="text" id="daya" name="daya" class="form-control input-sm"  placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">Tujuan Pembatalan</label>
												<div class="col-md-4">
													<select id="status_bk" style="width:180px;" name="status_bk" class="form-control" data-placeholder="Select..." required>
														<option value="x">-- Pilih --</option>
														<option value="0">DIALIHKAN</option>
														<option value="1">DIHAPUSKAN</option>
													</select>
												</div>
											</div>
											<div class="form-group" id="lang_bayar">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">ID LANGGANAN LAIN</label>
												<div class="col-md-4">
													<input type="text" id="id_lang_bayar" name="id_lang_bayar" class="form-control input-sm"  placeholder=" ">
												</div>
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
											 RP TAGIH
										</th>
										<th>
											 RP BK
										</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<div class="col-md-12 ">
					<div class="panel panel-success">
						<div class="panel-body">
							<div class="row">
								<div class="form-body">
									<div class="col-md-12">		
										<div class="form-group">
											<div class="col-md-4">
												<a type="button" id="btnSave" onclick="save()" class="btn green">Proses Sekarang </a>
											</div>
										</div>
										<div> <p id="tes" style="color: red;"> </p> </div>
										<div class="form-group">
											<div class="col-md-4">
												<label class="col-md-6 control-label align-left" style="padding-left:250px;">&nbsp;</label>
												<div class="col-md-4">
													<input type="hidden"  class="form-control input-sm"  placeholder=" ">
												</div>
											</div>
										</div>
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
<!-- END CORE PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!-- TAMBAHAN -->
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
	function loaddata(ID_LANG){
		table = $('#table').DataTable({
			destroy: true,
			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('keuangan/batalbk_list')?>",
				"type": "POST",
				data: function(d) {
					d.id_lang = ID_LANG
				}
			},
			"columnDefs": [
			{  
				"className": "text-right",
				"targets": [-1],
				"orderable": false,
			},
			],

		});
		
		/*$('#table tbody').on('click', 'input[type="checkbox"]', function(e){	
			var check = $('input[name="pilihan[]"]:checked').length;
			var mycheckboxes = new Array();
			$('input[name="pilihan[]"]:checked').each(function(){
				mycheckboxes.push(this.value);
			});
			tess = mycheckboxes;
			return tess;
		});*/
	}
	
function save(){
	var save_method = 'update';
    var url;
	var status = $("#status_bk").val();
	
	if(status=='x'){
		alert("PILIH STATUS BK");
		return false
	}else if(status=='0'){
		var lang_bayar = $("#id_lang_bayar").val();
		if(lang_bayar == ''){
				alert("Masukan ID Langganan Lain");
				return false
		}
	}
	
    if(save_method == 'add') {
        url = "<?php echo site_url('keuangan/batalbk_add')?>";
    } else {
        url = "<?php echo site_url('keuangan/batalbk_update')?>";
    }

    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
			alert('Berhasil di Proses');
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