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
	
	$("#tgl_mohon").datepicker().datepicker("setDate", new Date());
	$("#lang_bayar").hide();
	
	$("#pola_bayar").on("change", function(){
		var v = $(this).val();
		if(v == "2"){ $("#lang_bayar").show(); }else{$("#lang_bayar").hide(); }
	});
	
	$("#prov_mohon").on("change", function(){
		vz = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_chain_kab_mohon/'+vz;
		removeOptions(document.getElementById("kota_mohon"));
		var kota_mohon = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kota_mohon.push({
					   'id': obj.id_kab,
					   'text': obj.nama
					});
					return kota_mohon;
					
				});
				$("#kota_mohon").select2({
					placeholder: "Pilih",
					data: kota_mohon
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
			}
		});
	});
	
	$("#kota_mohon").on("change", function(){
		var v = $(this).val();
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/get_chain_kec_mohon/'+v;
		removeOptions(document.getElementById("kec_mohon"));
		var kec_mohon = ["--Pilih--"];
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				$.map(datas, function (obj) {
					kec_mohon.push({
					   'id': obj.id_kec,
					   'text': obj.nama
					});
					return kec_mohon;
					
				});
				$("#kec_mohon").select2({
					placeholder: "Pilih",
					data: kec_mohon
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator");
			}
		});
	});
	
});


function cari(){
		var cariy   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_cl/'+cariy;
		$('#btnSave').attr('disabled',false);
		$('#btnCetak').attr('disabled',false);
		document.getElementById("valid").innerHTML = " ";
		var ck = '';
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					ck = obj.ID_LANG;
					var sts = obj.STATUS_LUNAS;
					if(sts == '' || sts == null){
						document.getElementById("valid").innerHTML = "ID LANGGANAN INI BELUM MELUNASI TAGIHAN REKENING ";
						$('#btnSave').attr('disabled',true);
						$('#btnCetak').attr('disabled',true);
						return false;
					}
					
					$("#id_lang").val(obj.ID_LANG);
					$("#id_cust").val(obj.ID_CUST);
					$("#nama_cust").val(obj.NAMA_CUST);
					$("#alamat_cust").val(obj.ALAMAT_CUST);
					$("#kec_cust").val(obj.KECCUST);
					$("#kota_cust").val(obj.KABCUST);
					$("#prov_cust").val(obj.PROVCUST);
					$("#kdpos_cust").val(obj.KDPOS_CUST);
					$("#KD_UJL").val(obj.KD_UJL);
					$("#nama_ujl").val(obj.nama_ujl);
					
					$("#nama_mohon").val(obj.NAMA_MOHON);
					$("#alamat_mohon").val(obj.ALAMAT_MOHON);
					$("#kec_mohon").val(obj.KEC_MOHON);
					$("#kota_mohon").val(obj.KOTA_MOHON);
					$("#prov_mohon").val(obj.PROV_MOHON);
					$("#kdpos_mohon").val(obj.KDPOS_MOHON);
					$("#telp_mohon").val(obj.TELP_MOHON);
					$("#hp_mohon").val(obj.HP_MOHON);
					$("#email_mohon").val(obj.EMAIL_MOHON);
					$("#identitas_mohon").val(obj.IDENTITAS_MOHON).trigger('change');
					$("#no_identitas_mohon").val(obj.NO_IDENTITAS_MOHON);
					$("#asal_mohon").val(obj.ASAL_MOHON).trigger('change');
					
					$("#nama_lang").val(obj.NAMA_LANG);
					$("#alamat_lang").val(obj.ALAMAT_LANG);
					$("#kdpos_lang").val(obj.KDPOS_LANG);
					$("#kd_wilayah").val(obj.KD_WILAYAH).trigger('change');
					$("#kd_area").val(obj.KD_AREA).trigger('change');
					$("#tarif_baru").val(obj.TARIF); 
					$("#daya_baru").val(obj.DAYA); 
					$("#uraian").val(obj.PERUNTUKAN); 
					if(obj.KOGOL == '1' || obj.KOGOL == '2' || obj.KOGOL == '3'){
						$("#kd_bk").val('X');
					}else if(obj.KOGOL){
						$("#kd_bk").val('B');
					}
					$("#kogol").val(obj.KOGOL);
					caril();
					otoagenda();
					
				});
				if(ck==''){
					$('[name="cari"]').parent().parent().parent().parent().addClass('has-error'); 
					$('[name="cari"]').attr('value',''); 
					$('[name="cari"]').attr('placeholder','Data tidak ada');
					return false;
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Hubungi Administrator");
			}
		});
}

function caril(){
		var cariy   = document.getElementById("cari").value;
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/cari_cll/'+cariy;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$("#kec_lang").val(obj.KECLANG);
					$("#idkec_lang").val(obj.IDKECLANG);
					$("#kota_lang").val(obj.KABLANG);
					$("#idkota_lang").val(obj.IDKABLANG);
					$("#prov_lang").val(obj.PROVLANG);
					$("#idprov_lang").val(obj.IDPROVLANG);
					vz = obj.IDPROVLANG;
					ppj();
				});
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Hubungi Administrator");
			}
		});
}

function otoagenda(){
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/otoagenda/';
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					var wil   	= document.getElementById("kd_wilayah").value;
					var w		= wil.substr(0,3);
					var area	= document.getElementById("kd_area").value;
					var bis		= "0";
					if(obj.no_agenda == null){ var urut	= "0001"; }else{ var urut	= obj.no_agenda;}
					var now = $("#tgl_mohon").val();
					var pecah = now.split("-");
					var th = pecah[0];
					var bl = pecah[1];
					var tg = pecah[2];
					var thn= th.substr(2,2);
					var noagd   = area+bis+'13'+thn+bl+tg+urut;
					$("#no_agenda").val(noagd);
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Hubungi Adminstrator");
			}
		});
}

function ppj(){
		var vx = document.getElementById('tarif_baru').value;
		var trf  = vx.substring(0,1);
		var baseUrl = '<?php echo base_url(); ?>index.php/pelayanan/otoppj/'+trf+'/'+vz;
		$.ajax({
			url: baseUrl,
			dataType: 'json',
			success: function(datas){
				var agd = $.map(datas, function (obj) {
					$('#kd_ppj').val(obj.NILAI_GANTI_PPJ);
				});
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert("Hubungi Adminstrator");
			}
		});
}

function removeOptions(selectbox){
	var i;
	for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
	{
		selectbox.remove(i);
	}
}

function cetak(x){
	var no_agenda = document.getElementById('no_agenda').value;
	
	hreF	= "<?php echo site_url("Laporan/rpt_perubahannama")?>";
	ReQuest	= "/" + x + "/" +no_agenda;
	window.open(hreF+ReQuest, '_blank');
	
	$("input[type=text], textarea").val("");
	$('select').val('').trigger('change');
	$("#tgl_mohon").datepicker().datepicker("setDate", new Date());
}
</script>


			<div class="page-head">
				<div class="page-title">
					<h1>Perubahan Nama Alamat <small>Permohonan</small></h1>
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
									<label class="col-md-3 control-label align-left">Masukan Nama / ID Langganan</label>
									<div class="col-md-4">
										<div class="input-group">
											<input id="cari" name="cari" class="form-control" />
											<span class="input-group-btn">
												<a type="button" onclick="cari()" class="btn green">Cari </a>
											</span>
										</div>
									</div>
									<div class="col-md-4">
										<div class="input-group">
											<span id="valid" class="help-block" style="color: red;"></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-6">
					<div class="panel panel-success">
						<div class="panel-body form-horizontal">
	<form action="#" id="form" class="form-horizontal" role="form"> 
							<input type="hidden" class="form-control" id="id_cust" name="id_cust"  placeholder=" " readonly="true">
							<input type="hidden" class="form-control" id="id_lang" name="id_lang"  placeholder=" " readonly="true">
							<div class="form-group">
								<label class="col-md-6 control-label align-left">Tanggal Mohon</label>
								<div class="col-md-6">
									<input id="tgl_mohon" name="tgl_mohon" placeholder="yyyy-mm-dd" class="form-control datepicker" type="text">
								</div> 
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label align-left">No Agenda</label>
								<div class="col-md-6">
									<input type="text" id="no_agenda" name="no_agenda" class="form-control" readonly="true"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-md-6 control-label align-left">No Register</label>
								<div class="col-md-6">
									<input type="text" id="no_reg" name="no_reg" class="form-control"  readonly="true"/>
								</div>
							</div>
							
							<div class="note note-success">
								<h1 class="block center"><center>LISTRIK</center></h1>
							</div>
							<br/>
						</div>
					</div>
				</div>
				
				<div class="col-md-6">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>
								<span class="caption-subject font-green-sharp bold">Data Customer</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="">
									<label class="col-md-6 control-label align-left">Nama</label>
									<div class="col-md-6">
										<input type="text" id="nama_cust" name="nama_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Alamat</label>
									<div class="col-md-6">
										<input type="text" id="alamat_cust" name="alamat_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kecamatan</label>
									<div class="col-md-6">
										<input type="text" id="kec_cust" name="kec_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kota</label>
									<div class="col-md-6">
										<input type="text" id="kota_cust" name="kota_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Provinsi</label>
									<div class="col-md-6">
										<input type="text" id="prov_cust" name="prov_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Kodepos</label>
									<div class="col-md-6">
										<input type="text" id="kdpos_cust" name="kdpos_cust" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="">
									<label class="col-md-6 control-label align-left">Paket SAR</label>
									<div class="col-md-6">
										<input type="text" id="nama_ujl" name="nama_ujl" class="form-control input-sm" placeholder=" " readonly>
									</div>
								</div>
								<div class="form-group">
									<input type="hidden" id="KD_UJL" name="KD_UJL" class="form-control input-sm" placeholder=" ">
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>
								<span class="caption-subject font-green-sharp bold">Data Pemohon</span>
							</div>
						</div>
						<div class="portlet-body">
							<div class="form-body form-horizontal">
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Nama</label>
											<div class="col-md-6">
												<input type="text" id="nama_mohon" name="nama_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Alamat</label>
											<div class="col-md-6">
												<input type="text" id="alamat_mohon" name="alamat_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Provinsi</label>
											<div class="col-md-6">
												<?php
													$atribut_prov_mohon = 'id="prov_mohon" class="form-control select2me"';
													echo form_dropdown('prov_mohon', $prov_mohon, '', $atribut_prov_mohon);
												?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kota</label>
											<div class="col-md-6">
												<?php
													$atribut_kota_mohon = 'id="kota_mohon" class="form-control select2me"';
													echo form_dropdown('kota_mohon', $kota_mohon, '', $atribut_kota_mohon);
												?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kecamatan</label>
											<div class="col-md-6">
												<?php
													$atribut_kec_mohon = 'id="kec_mohon" class="form-control select2me"';
													echo form_dropdown('kec_mohon', $kec_mohon, '', $atribut_kec_mohon);
												?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Kode POS</label>
											<div class="col-md-6">
												<input type="text" id="kdpos_mohon" name="kdpos_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Telepon</label>
											<div class="col-md-6">
												<input type="text" id="telp_mohon" name="telp_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Handphone</label>
											<div class="col-md-6">
												<input type="text" id="hp_mohon" name="hp_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">Email</label>
											<div class="col-md-6">
												<input type="text" id="email_mohon" name="email_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label align-left col-md-6">Identitas</label>
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
													<i class="fa fa-user"></i>
													</span>
													<select id="identitas_mohon" name="identitas_mohon" class="form-control select2me" data-placeholder="Select...">
														<option value=" ">-- Pilih --</option>
														<option value="KTP">KTP</option>
														<option value="SIM">SIM</option>
														<option value="PASSPORT">PASSPORT</option>
														<option value="No Surat">No Surat</option>
													</select>
												</div>
												<!-- /input-group -->
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-6 control-label align-left">No Identitas</label>
											<div class="col-md-6">
												<input type="text" id="no_identitas_mohon" name="no_identitas_mohon" class="form-control input-sm" placeholder=" ">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label align-left col-md-6">Lokasi</label>
											<div class="col-md-6">
												<div class="input-group">
													<span class="input-group-addon">
													<i class="fa fa-user"></i>
													</span>
													<select id="asal_mohon" name="asal_mohon" class="form-control select2me" data-placeholder="Select...">
														<option value=" ">-- Pilih --</option>
														<option value="LOKET">LOKET</option>
														<option value="WEBSITE">WEBSITE</option>
														<option value="TELEPON">EMAIL</option>
													</select>
												</div>
												<!-- /input-group -->
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>	
				
				<div class="col-md-12">
					<div class="portlet light">
						<div class="portlet-title">
							<div class="caption">
								<i class="fa fa-globe"></i>
								<span class="caption-subject font-green-sharp bold">Data Permohonan</span>
							</div>
						</div>
						<div class="portlet-body">
							
								<div class="form-body form-horizontal">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="control-label align-left col-md-6">Wilayah</label>
												<div class="col-md-6">
													<select id="kd_wilayah" name="kd_wilayah" class="form-control select2me" data-placeholder="Select...">
														<option value="">--Pilih--</option>
														<option value="88100">PELINDO 1</option>
														<option value="88200" selected>PELINDO 2</option>
														<option value="88300">PELINDO 3</option>
														<option value="88400">PELINDO 4</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Area Pelabuhan</label>
												<div class="col-md-6">
												<?php
													$atribut_area = 'id="kd_area" class="form-control select2me"';
													echo form_dropdown('kd_area', $area, '', $atribut_area);
												?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Nama</label>
												<div class="col-md-6">
													<input type="text" id="nama_lang" name="nama_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Alamat</label>
												<div class="col-md-6">
													<input type="text" id="alamat_lang" name="alamat_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kecamatan</label>
												<div class="col-md-6">
													<input type="text" id="kec_lang" name="kec_lang" class="form-control input-sm" placeholder=" " readonly>
													<input type="hidden" id="idkec_lang" name="idkec_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kota</label>
												<div class="col-md-6">
													<input type="text" id="kota_lang" name="kota_lang" class="form-control input-sm" placeholder=" " readonly>
													<input type="hidden" id="idkota_lang" name="idkota_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Provinsi</label>
												<div class="col-md-6">
													<input type="text" id="prov_lang" name="prov_lang" class="form-control input-sm" placeholder=" " readonly>
													<input type="hidden" id="idprov_lang" name="idprov_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Kodepos</label>
												<div class="col-md-6">
													<input type="text" id="kdpos_lang" name="kdpos_lang" class="form-control input-sm" placeholder=" " readonly>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Pola Pembayaran</label>
												<div class="col-md-6">
													<select id="pola_bayar" name="pola_bayar" class="form-control select2me" data-placeholder="Select...">
														<option value=" ">-- Pilih --</option>
														<option value="0" selected>NORMAL</option>
														<option value="1">REK PERTAMA</option>
														<option value="2">LANGGANAN LAIN</option>
													</select>													
												</div>
											</div>
											<div class="form-group" id="lang_bayar">
												<label class="col-md-6 control-label align-left">ID Langganan</label>
												<div class="col-md-6">
													<input type="text" id="id_lang_bayar" name="id_lang_bayar" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label align-left col-md-6">Wilayah</label>
												<div class="col-md-6">
													<select id="kd_wilayahx" name="kd_wilayahx" class="form-control select2me" data-placeholder="Select...">
														<option value="">--Pilih--</option>
														<option value="88100">PELINDO 1</option>
														<option value="88200" selected>PELINDO 2</option>
														<option value="88300">PELINDO 3</option>
														<option value="88400">PELINDO 4</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Area Pelabuhan</label>
												<div class="col-md-6">
												<?php
													$atribut_areax = 'id="kd_areax" class="form-control select2me"';
													echo form_dropdown('kd_areax', $areax, '', $atribut_areax);
												?>
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Nama Baru</label>
												<div class="col-md-6">
													<input type="text" id="nama_langx" name="nama_langx" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
											<div class="form-group">
												<label class="col-md-6 control-label align-left">Alamat Baru</label>
												<div class="col-md-6">
													<input type="text" id="alamat_langx" name="alamat_langx" class="form-control input-sm" placeholder=" ">
												</div>
											</div>
										</div>
									</div>
									<input type="hidden" id="tarif_baru" name="tarif_baru" class="form-control input-sm" placeholder=" " readonly>
									<input type="hidden" id="daya_baru" name="daya_baru" class="form-control input-sm" placeholder=" " readonly>
									<input type="hidden" id="uraian" name="uraian" class="form-control input-sm" placeholder=" " readonly>
									<input type="hidden" id="kd_bk" name="kd_bk" class="form-control input-sm">
									<input type="hidden" id="kogol" name="kogol" class="form-control input-sm">
									<input type="hidden" id="kd_ppj" name="kd_ppj" class="form-control input-sm">
									<div class="row">
										<div class="col-md-6">
										</div>
										<div class="col-md-6">
											<a type="button" id="btnSave" onclick="save()" class="btn green "> Simpan </a>
											<a type="button" id="btnSave" onclick="cetak(1)" class="btn blue"> Cetak Form</a>
										</div>
									</div>
								</div>
	</form>
							<!-- selesai -->
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

var save_method; 
var table;

function save()
{
	var save_method = 'add';
    var url;

    if(save_method == 'add') {
        url = "<?php echo site_url('pelayanan/perubahannama_add/')?>";
    } else {
        url = "<?php echo site_url('pelayanan/perubahannama_update')?>";
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