<div class="page-head">
	<div class="page-title">
		<h1>Data <small>Vendor</small></h1>
	</div>
	<div class="page-toolbar">
		<div class="btn-group btn-theme-panel">
		</div>
	</div>
</div>
<div class="row ">
	<div class="col-md-12">

		<div class="tabbable-custom nav-justified">
			<ul class="nav nav-tabs nav-justified">
				<li class="active">
					<a href="#tab_1_1" data-toggle="tab">
					Daftar List </a>
				</li>
				<li>
					<a href="#tab_1_2" data-toggle="tab">
					Form Data </a>
				</li>
			</ul>
		</div>
		<div class="tab-content">
			<div class="tab-pane active" id="tab_1_1">
				<div class="portlet box blue-steel">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i>Daftar semua vendor PT Energi Pelabuhan Indonesia
						</div>
					</div>
					<div class="portlet-body">
						<div class="portlet-body form">
							<form action="#" id="form_daftar" class="form-horizontal" role="form">
								<div class="form-body">
									<div class="row">

										<div class="col-md-12">
											<a type="button" id="btn_baru" onclick="vendor_baru()" class="col-md-1 btn btn-sm blue-steel"><i class="glyphicon glyphicon-floppy-plus" title="vendor baru"></i> Tambah</a>
											<div class="clearfix"></div>
											<div class="table-scrollable">
												<table class="table table-striped table-bordered table-hover" id="table">
													<thead>
														<tr>
															<th class="text-center">
																 No.
															</th>
															<th width='100' class="text-center">
																 ID Vendor
															</th>
															<th width='400' class="text-center">
																 Perusahaan
															</th>
															<th class="text-center">
																 Grade SIUP
															</th>
															<th class="text-center">
																 Grade SIUJK
															</th>
															<th class="text-center">
																 PIC
															</th>
															<th class="text-center">
																 HP PIC
															</th>
															<th class="text-center">
																 EMAIL PIC
															</th>
															<th width='70' class="text-center">
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
							</form>
						</div>

					</div>
				</div>
			</div>

			<div class="tab-pane" id="tab_1_2">
				<div class="portlet box blue">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-globe"></i>Form Vendor Baru
						</div>
					</div>
					<div class="portlet-body">
						<div class="portlet-body form">
							<form action="#" id="form" class="form-horizontal" role="form" enctype="multipart/form-data">
								<input type="hidden" value="" name="id"/>
								<div class="form-body">
									<div class="row">
										<div class="col-md-6">
											<div class="panel panel-success">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Id Vendor</label>
														<div class="col-md-8">
															<input type="text" name="id_vd" id="id_vd" class="form-control input-sm" placeholder=" " readonly="true">
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Perusahaan</label>
														<div class="col-md-8">
															<input type="text" name="nama_pt" id="nama_pt" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Alamat</label>
														<div class="col-md-8">
															<input type="text" name="alamat_pt" id="alamat_pt" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Provinsi</label>
														<div class="col-md-8">
															<input type="text" name="prov_vdx" id="prov_vdx" class="form-control input-sm" placeholder=" " style="display:none;" />
															<select class="form-control input-sm" style="width:100%;" id="prov_vd" name="prov_vd" data-placeholder="-Pilih-">
																<option value="">-Pilih-</option>
																<?php
																foreach ($prov_list as $r)
																{
																	echo "<option value ='".$r->id_prov."'>".$r->nama."</option>";
																}
																?>
															</select>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Kota</label>
														<div class="col-md-8">
															<input type="text" name="kab_vdx" id="kab_vdx" class="form-control input-sm" placeholder=" " style="display:none;" />
															<select class="form-control input-sm" style="width:100%;" id="kab_vd" name="kab_vd" data-placeholder="-Pilih-">
															</select>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Kecamatan</label>
														<div class="col-md-8">
															<input type="text" name="kec_vdx" id="kec_vdx" class="form-control input-sm" placeholder=" " style="display:none;" />
															<select class="form-control input-sm" style="width:100%;" id="kec_vd" name="kec_vd" data-placeholder="-Pilih-">
															</select>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Kodepos</label>
														<div class="col-md-8">
															<input type="text" name="kodepos" id="kodepos" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nomor Telepon</label>
														<div class="col-md-8">
															<input type="text" name="no_tlp_pt" id="no_tlp_pt" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nomor Faxmile</label>
														<div class="col-md-8">
															<input type="text" name="no_fax_pt" id="no_fax_pt" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															<span class="help-block"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-success">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pimpinan</label>
														<div class="col-md-8">
															<input type="text" name="nama_dirut" id="nama_dirut" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
													<h4 class="text-info" >Nomor Pokok Wajib Pajak (NPWP)</h4>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nomor</label>
														<div class="col-md-8">
															<input type="text" name="no_npwp" id="no_npwp" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Tanggal</label>
														<div class="col-md-8">
															<input type="text" name="tgl_npwp" id="tgl_npwp" class="form-control input-sm datepicker datepicker" placeholder="Tanggal Berlaku " required />
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left" for="file_npwp">Upload Berkas</label>
														<div class="col-md-8">
															<input type="file" id="file_npwp" name="file_npwp" class="form-control input-sm">
															<span class="help-block" ></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-success">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama PIC</label>
														<div class="col-md-8">
															<input type="text" name="nama_pic" id="nama_pic" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Handphone</label>
														<div class="col-md-8">
															<input type="text" name="no_hp_pic" id="no_hp_pic" class="form-control input-sm" placeholder=" " onkeypress="return hanyaAngka(event)" required>
															<span class="help-block"></span>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Email</label>
														<div class="col-md-8">
															<input type="text" name="email_pic" id="email_pic" class="form-control input-sm" placeholder=" " required />
															<span class="help-block"></span>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="clearfix"></div>

										<div class="col-md-12">
											<div class="panel panel-primary">
												<div class="panel-body form-horizontal">

													<div class="col-md-6">
														<h4 class="text-info" >1. Akta Pendirian</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor</label>
															<div class="col-md-8">
																<input type="text" name="no_akta_pendirian" id="no_akta_pendirian" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal</label>
															<div class="col-md-8">
																<input type="text" name="tgl_akta_pendirian" id="tgl_akta_pendirian" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor Pengesahan</label>
															<div class="col-md-8">
																<input type="text" name="no_pengesahan_akta_pendirian" id="no_pengesahan_akta_pendirian" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Pengesahan</label>
															<div class="col-md-8">
																<input type="text" name="tgl_pengesahan_akta_pendirian" id="tgl_pengesahan_akta_pendirian" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="file_akta_pendirian">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="file_akta_pendirian" name="file_akta_pendirian" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
														<hr/>
														<h4 class="text-info" >2. Akta Perubahan Terakhir</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor</label>
															<div class="col-md-8">
																<input type="text" name="no_akta_perubahan" id="no_akta_perubahan" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal</label>
															<div class="col-md-8">
																<input type="text" name="tgl_akta_perubahan" id="tgl_akta_perubahan" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor Pengesahan</label>
															<div class="col-md-8">
																<input type="text" name="no_pengesahan_akta_perubahan" id="no_pengesahan_akta_perubahan" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Pengesahan</label>
															<div class="col-md-8">
																<input type="text" name="tgl_pengesahan_akta_perubahan" id="tgl_pengesahan_akta_perubahan" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="file_akta_perubahan">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="file_akta_perubahan" name="file_akta_perubahan" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
													</div>
													<div class="col-md-6">
														<h4 class="text-info" >3. Domisili</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor</label>
															<div class="col-md-8">
																<input type="text" name="no_domisili" id="no_domisili" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Berlaku</label>
															<div class="col-md-4">
																<input type="text" name="tgl_domisili" id="tgl_domisili" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
															<div class="col-md-4">
																<select class="form-control input-sm" id="masa_domisili" name="masa_domisili">
																	<option value = "">-Pilih-</option>
																	<option value = "1">+ 1</option>
																	<option value = "2">+ 2</option>
																	<option value = "3">+ 3</option>
																	<option value = "4">+ 4</option>
																	<option value = "5">+ 5</option>
																	<option value = "100"> ~ unlimited</option>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Berakhir</label>
															<div class="col-md-4">
																<input type="text" name="tgl_exp_domisili" id="tgl_exp_domisili" class="form-control input-sm datepicker" placeholder="Tanggal Expired " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="file_domisili">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="file_domisili" name="file_domisili" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
														<hr/>
														<h4 class="text-info" >4. Tanda Daftar Perusahaan (TDP)</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor</label>
															<div class="col-md-8">
																<input type="text" name="no_tdp" id="no_tdp" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Berlaku</label>
															<div class="col-md-4">
																<input type="text" name="tgl_tdp" id="tgl_tdp" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
															<div class="col-md-4">
																<select class="form-control input-sm" id="masa_tdp" name="masa_tdp">
																	<option value = "">-Pilih-</option>
																	<option value = "1">+ 1</option>
																	<option value = "2">+ 2</option>
																	<option value = "3">+ 3</option>
																	<option value = "4">+ 4</option>
																	<option value = "5">+ 5</option>
																	<option value = "100"> ~ unlimited</option>
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Berakhir</label>
															<div class="col-md-4">
																<input type="text" name="tgl_exp_tdp" id="tgl_exp_tdp" class="form-control input-sm datepicker" placeholder="Tanggal Expired " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="file_tdp">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="file_tdp" name="file_tdp" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
														<hr/>
														<h4 class="text-info" >5. Pengusaha Kena Pajak (PKP)</h4>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nomor</label>
															<div class="col-md-8">
																<input type="text" name="no_pkp" id="no_pkp" class="form-control input-sm" placeholder=" " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal</label>
															<div class="col-md-8">
																<input type="text" name="tgl_pkp" id="tgl_pkp" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																<span class="help-block"></span>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left" for="file_pkp">Upload Berkas</label>
															<div class="col-md-8">
																<input type="file" id="file_pkp" name="file_pkp" class="form-control input-sm">
																<span class="help-block"></span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="tabbable-custom nav-justified">
												<ul class="nav nav-tabs nav-justified">
													<li class="active">
														<a href="#tab_1_1_1" data-toggle="tab">
														Surat Izin Usaha Perdagangan (SIUP) </a>
													</li>
													<li>
														<a href="#tab_1_1_2" data-toggle="tab">
														Surat Izin Usaha Jasa Kontruksi (SIUJK) </a>
													</li>
													<li>
														<a href="#tab_1_1_3" data-toggle="tab">
														Surat Izin Usaha (SIU) </a>
													</li>
												</ul>
												<div class="tab-content">
													<div class="tab-pane active" id="tab_1_1_1">
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Nomor</label>
																<div class="col-md-8">
																	<input type="text" name="nomor_siup" id="nomor_siup"  class="form-control input-sm" placeholder=" " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berlaku</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_siup" id="tgl_siup" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																	<span class="help-block"></span>
																</div>
																<div class="col-md-4">
																	<select class="form-control input-sm" id="masa_siup" name="masa_siup">
																		<option value = "">-Pilih-</option>
																		<option value = "1">+ 1</option>
																		<option value = "2">+ 2</option>
																		<option value = "3">+ 3</option>
																		<option value = "4">+ 4</option>
																		<option value = "5">+ 5</option>
																		<option value = "100"> ~ unlimited</option>
																	</select>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berakhir</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_exp_siup" id="tgl_exp_siup" class="form-control input-sm datepicker" placeholder="Tanggal Expired " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Modal Usaha (Rp.)</label>
																<div class="col-md-8">
																	<input type="text" name="modal_usaha_siup" id="modal_usaha_siup" class="form-control input-sm mask_decimal" placeholder=" " onkeypress="return hanyaAngka(event)" required>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Grade</label>
																<div class="col-md-8">
																	<select class="form-control input-sm" id="grade_siup" name="grade_siup">
																		<option value = "">-Pilih-</option>
																		<option value = "B">Besar</option>
																		<option value = "M">Menengah</option>
																		<option value = "K">Kecil</option>
																	</select>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left" for="file_siup">Upload Berkas</label>
																<div class="col-md-8">
																	<input type="file" id="file_siup" name="file_siup" class="form-control input-sm">
																	<span class="help-block"></span>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-3 control-label align-left">Pilih Kategori KBLI</label>
																<div class="col-md-9">
																	<div class="input-group">
																		<span class="input-group-btn">
																			<a type="button" id="btnAddsiup" onclick="add_siup()" class="btn btn-sm purple"><i class="glyphicon glyphicon-plus" title="Tambah Kategori"></i></a>
																		</span>
																		<?php echo form_dropdown("list_siup_all",$list_kbli,'','id="list_siup_all" style="display:none; width:100%; " class="form-control select2me"'); ?>
																	</div>
																</div>
															</div>
															<input type="hidden" id="last_siup" name="last_siup"/>
															<div class="table-scrollable">
																<table class="table table-striped table-hover" id="tabel_siup">
																	<thead>
																		<tr>
																			<th width='50'>
																				 #
																			</th>
																			<th>
																				Kode
																			</th>
																			<th>
																				Kategori KBLI
																			</th>
																			<th width = "70">
																				 Aksi
																			</th>
																		</tr>
																	</thead>
																	<tbody id='isi_siup'>
																	</tbody>
																</table>
															</div>
														</div>
														<div class="col-md-12 ">
															<span name="notif_siup"></span>
														</div>
														<div class="clearfix"></div>
													</div>
													<div class="tab-pane" id="tab_1_1_2">
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Nomor</label>
																<div class="col-md-8">
																	<input type="text" name="nomor_siujk" id="nomor_siujk" class="form-control input-sm" placeholder=" " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berlaku</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_siujk" id="tgl_siujk" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																	<span class="help-block"></span>
																</div>
																<div class="col-md-4">
																	<select class="form-control input-sm" id="masa_siujk" name="masa_siujk">
																		<option value = "">-Pilih-</option>
																		<option value = "1">+ 1</option>
																		<option value = "2">+ 2</option>
																		<option value = "3">+ 3</option>
																		<option value = "4">+ 4</option>
																		<option value = "5">+ 5</option>
																		<option value = "100"> ~ unlimited</option>
																	</select>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berakhir</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_exp_siujk" id="tgl_exp_siujk" class="form-control input-sm datepicker" placeholder="Tanggal Expired " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Modal Usaha (Rp.)</label>
																<div class="col-md-8">
																	<input type="text" name="modal_usaha_siujk" id="modal_usaha_siujk" class="form-control input-sm mask_decimal" placeholder=" " onkeypress="return hanyaAngka(event)" required>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left" for="file_siujk">Upload Berkas</label>
																<div class="col-md-8">
																	<input type="file" id="file_siujk" name="file_siujk" class="form-control input-sm">
																	<span class="help-block"></span>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-3 control-label align-left">Pilih Sub Klasifikasi</label>
																<div class="col-md-9">
																	<?php echo form_dropdown("list_siujk_all",$list_siujk,'','id="list_siujk_all" style="display:none; width:100%; " class="form-control select2me"'); ?>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-3 control-label align-left">Pilih Grade</label>
																<div class="col-md-9">
																	<?php echo form_dropdown("grade_siujk",$list_grade,'','id="grade_siujk" style="display:none; width:100%; " class="form-control select2me"'); ?>
																</div>
															</div>
															<a type="button" id="btnAddsiujk" onclick="add_siujk()" class="col-md-12 btn btn-sm purple"><i class="glyphicon glyphicon-plus" title="Tambah Sub Klasifikasi"></i> Tambah</a>
															<br/><br/>
															<input type="hidden" id="last_siujk" name="last_siujk"/>
															<div class="table-scrollable">
																<table class="table table-striped table-hover" id="tabel_siujk">
																	<thead>
																		<tr>
																			<th width='10%'>
																				 #
																			</th>
																			<th width='20%'>
																				 Kode Sub Klasifikasi
																			</th>
																			<th width='50%'>
																				 Sub Klasifikasi
																			</th>
																			<th width='10%'>
																				 Grade Sub Klasifikas
																			</th>
																			<th width='10%'>
																				 Aksi
																			</th>
																		</tr>
																	</thead>
																	<tbody id='isi_siujk'>
																	</tbody>
																</table>
															</div>
														</div>
														<div class="col-md-12 ">
															<span name="notif_siujk"></span>
														</div>
														<div class="clearfix"></div>
													</div>
													<div class="tab-pane" id="tab_1_1_3">
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Nomor</label>
																<div class="col-md-8">
																	<input type="text" name="nomor_siu" id="nomor_siu" class="form-control input-sm" placeholder=" " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Nama Izin Usaha</label>
																<div class="col-md-8">
																	<input type="text" name="nama_siu" id="nama_siu" class="form-control input-sm" placeholder=" " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berlaku</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_siu" id="tgl_siu" class="form-control input-sm datepicker" placeholder="Tanggal Berlaku " required />
																	<span class="help-block"></span>
																</div>
																<div class="col-md-4">
																	<select class="form-control input-sm" id="masa_siu" name="masa_siu">
																		<option value = "">-Pilih-</option>
																		<option value = "1">+ 1</option>
																		<option value = "2">+ 2</option>
																		<option value = "3">+ 3</option>
																		<option value = "4">+ 4</option>
																		<option value = "5">+ 5</option>
																		<option value = "100"> ~ unlimited</option>
																	</select>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Tanggal Berakhir</label>
																<div class="col-md-4">
																	<input type="text" name="tgl_exp_siu" id="tgl_exp_siu" class="form-control input-sm datepicker" placeholder="Tanggal Expired " required />
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Modal Usaha (Rp.)</label>
																<div class="col-md-8">
																	<input type="text" name="modal_usaha_siu" id="modal_usaha_siu" class="form-control input-sm mask_decimal" placeholder=" " onkeypress="return hanyaAngka(event)" required>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left">Grade</label>
																<div class="col-md-8">
																	<select class="form-control input-sm" id="grade_siu" name="grade_siu" >
																		<option value="">-Pilih-</option>
																		<?php
																		foreach ($list_grade as $r)
																		{
																			echo "<option value ='".$r->kode."'>".$r->isi."</option>";
																		}
																		?>
																	</select>
																	<span class="help-block"></span>
																</div>
															</div>
															<div class="form-group">
																<label class="col-md-4 control-label align-left" for="file_siu">Upload Berkas</label>
																<div class="col-md-8">
																	<input type="file" id="file_siu" name="file_siu" class="form-control input-sm">
																	<span class="help-block"></span>
																</div>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label class="col-md-3 control-label align-left">Input Klasifikasi</label>
																<div class="col-md-9">
																	<div class="input-group">
																		<span class="input-group-btn">
																			<a type="button" id="btnAddsiu" onclick="add_siu()" class="btn btn-sm purple"><i class="glyphicon glyphicon-plus" title="Tambah Klasifikasi"></i></a>
																		</span>
																		<input id="siu_input" name="siu_input" class="form-control input-sm" type="text"/>
																	</div>
																</div>
															</div>
															<input type="hidden" id="last_siu" name="last_siu"/>
															<div class="table-scrollable">
																<table class="table table-striped table-hover" id="tabel_siu">
																	<thead>
																		<tr>
																			<th width='50'>
																				 #
																			</th>
																			<th>
																				 Kode
																			</th>
																			<th>
																				 Klasifikasi
																			</th>
																			<th width = "70">
																				 Aksi
																			</th>
																		</tr>
																	</thead>
																	<tbody id='isi_siu'>
																	</tbody>
																</table>
															</div>
														</div>
														<div class="col-md-12 ">
															<span name="notif_siu"></span>
														</div>
														<div class="clearfix"></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions right">
									<button type="button" id="btnSave" onclick="save()" class="btn blue">Simpan</button>
									<button type="button" id="btnUpdate" onclick="update()" class="btn blue" style="display:none;">Update</button>
								</div>
							</form>
						</div>

					</div>
				</div>

			</div>
		</div>


	</div>
</div>
<!-- modal large -->
<div class="modal fade bs-modal-lg" id="large" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 class="modal-title">Entri Pelanggan Baru</h4>
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
<script type="text/javascript" src="../../assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js"></script>
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
var urut_siup = 0;
var urut_siujk = 0;
var urut_siu = 0;
var no = 0;

$(document).ready(function() {

table = $('#table').DataTable({

	"processing": true,
	"serverSide": true,
	"order": [],

	"ajax": {
			"url": "<?php echo site_url('vendor/vendor_list_1')?>",
			"type": "POST"
	},

	"columnDefs": [
	{
			"targets": [ -1 ],
			"orderable": false,
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

$(".mask_decimal").inputmask({
'alias': 'decimal',
rightAlign: true,
'groupSeparator': '.',
'autoGroup': true
});

id_vendor_baru();

$("#tgl_domisilix").datepicker().datepicker({
onSelect: function(dateText) {
	var tglawal  = $(this).datepicker('getDate');
	var durasi = 30*12*5;
	tglawal.setDate(tglawal.getDate() + durasi);
	$('#tgl_exp_domisili').datepicker('setDate', tglawal);

}
}).on("change", function() {
var tglawal  = $(this).datepicker('getDate');
var durasi = 30*12*5;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_domisili').datepicker('setDate', tglawal);

});


});

function id_vendor_baru()
{
var dates = new Date();
//var id_vds = "epi" + formatDate(dates) + "xxx";
var id_vds = "epi" + formatDate(dates);
//$('[name="id_vd"]').val(id_vds);

$.ajax({
url : "<?php echo site_url('vendor/vendor_baru')?>/"+id_vds,
type: "POST",
dataType: "JSON",
success: function(data)
{
	if(data.status)
	{
		$('[name="id_vd"]').val(data.id_vd);
	}
	else
	{
		alert("Proses id vendor baru gagal!");
	}

},
error: function (jqXHR, textStatus, errorThrown)
{
		alert('Hubungi admin untuk menambahkan data ini');
}
});

}

function formatDate(d)
{
var month = d.getMonth();
var day = d.getDate().toString();
var year = d.getFullYear();

year = year.toString().substr(-2);
month = (month + 1).toString();
if (month.length === 1)
{
	month = "0" + month;
}

if (day.length === 1)
{
	day = "0" + day;
}

return year + month;
}

function save()
{
save_method = 'add';

$('#btnSave').text('Sedang proses simpan...');
$('#btnSave').attr('disabled',true);
var url;

if(save_method == 'add') {
url = "<?php echo site_url('vendor/vendor_add')?>";
} else {
url = "<?php echo site_url('vendor/vendor_update')?>";
}

var formData = new FormData($('#form')[0]);
$.ajax({
url : url,
type: "POST",
data: formData,
contentType: false,
processData: false,
dataType: "JSON",
success: function(data)
{
	if(data.status)
	{
		alert("sukses");
		location.reload();
	}
	else
	{
		alert("Ups, ada kekurangan dalam inputan!");
		for (var i = 0; i < data.inputerror.length; i++)
		{
			switch (data.inputerror[i])
			{
				case 'notif_siup':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				case 'notif_siujk':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				case 'notif_siu':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				default:
					$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
					$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
					break;
			}
		}
	}
	$('#btnSave').text('Simpan');
	$('#btnSave').attr('disabled',false);
},
error: function (jqXHR, textStatus, errorThrown)
{
	alert('Error adding data, hubungi admin');
	$('#btnSave').text('save');
	$('#btnSave').attr('disabled',false);
}
});
}

$("#prov_vd").on("change", function(){
var v = $(this).val();
var baseUrl = '<?php echo base_url(); ?>index.php/vendor/get_chain_kab/'+v;
removeOptions(document.getElementById("kab_vd"));
var kab_vd = ["-Pilih-"];
$.ajax({
url: baseUrl,
dataType: 'json',
success: function(datas){
$.map(datas, function (obj) {
	kab_vd.push({
		 'id': obj.id_kab,
		 'text': obj.nama
	});
	return kab_vd;

});
$("#kab_vd").select2({
	placeholder: "Pilih",
	data: kab_vd,
	width: '100%'
});

},
error: function (xhr, ajaxOptions, thrownError) {
alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
}
});
});

$("#kab_vd").on("change", function(){
var v = $(this).val();
var baseUrl = '<?php echo base_url(); ?>index.php/vendor/get_chain_kec/'+v;
removeOptions(document.getElementById("kec_vd"));
var kec_vd = ["-Pilih-"];
$.ajax({
url: baseUrl,
dataType: 'json',
success: function(datas){
$.map(datas, function (obj) {
	kec_vd.push({
		 'id': obj.id_kec,
		 'text': obj.nama
	});
	return kec_vd;
});
$("#kec_vd").select2({
	placeholder: "Pilih",
	data: kec_vd,
	width: '100%'
});

},
error: function (xhr, ajaxOptions, thrownError) {
alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
}
});
});

function removeOptions(selectbox){
var i;
for(i = selectbox.options.length - 1 ; i >= 0 ; i--)
{
selectbox.remove(i);
}
}

function hanyaAngka(evt) {
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))

return false;
return true;
}

function show_siup()
{
var id_vd = document.getElementById("id_vd").value;
id_vd = $('#tabel_siup').DataTable({
destroy: true,
"paging":   false,
"ordering": false,
"info":     false,
"searching": false,
"processing": true,
"serverSide": false,
"order": [],
"ajax": {
"url": "<?php echo site_url('vendor/list_siup_show')?>",
"type": "POST",
data: function(d) {
	d.id_vd = id_vd
}
},
"columnDefs": [
{
"className": "text-left",
"targets": [1,2],
},
{
"className": "text-center",
"targets": [3],
},
],
});
}

function add_siup()
{
no = no + 1;
var a = document.getElementById("list_siup_all");
var b = a.options[a.selectedIndex].value;
var bx = b+" - ";
var cx = a.options[a.selectedIndex].text;
var c = cx.replace(bx,'');
var id_vd = $("#id_vd").val();
var kode = $("#list_siup_all").val();

if (id_vd != '' && kode != '') {
$.ajax({
	url : "<?php echo site_url('vendor/list_siup_insert')?>/"+id_vd+"/"+kode,
	type: "POST",
	dataType: "JSON",
	success: function(data)
	{
		if(data.status)
		{
			$('#list_siup_all').val('').trigger('change');
			show_siup();
		}
		else
		{
			$('#list_siup_all').val('').trigger('change');
			alert("Id '"+cx+"' sudah digunakan pada tabel ini!");
		}

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Hubungi admin untuk menambahkan data ini');
	}
});
}
else {
alert("Pilih terlebih dahulu!");
}
}

function del_siup(r) {
var table = document.getElementById('tabel_siup');
var i = r.parentNode.parentNode.rowIndex;
var kode = table.rows[i].cells[1].innerHTML;
var id_vd = $("#id_vd").val();

if(confirm('Yakin anda ingin mengeluarkan '+kode+' ?' ))
{
	$.ajax({
			url : "<?php echo site_url('vendor/list_siup_delete')?>/"+id_vd+"/"+kode,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				//document.getElementById("tabel_siup").deleteRow(i);
				show_siup();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Hubungi admin untuk mengeluarkan data ini');
			}
	});
}

}

function show_siujk()
{
var id_vd = document.getElementById("id_vd").value;
id_vd = $('#tabel_siujk').DataTable({
destroy: true,
"paging":   false,
"ordering": false,
"info":     false,
"searching": false,
"processing": true,
"serverSide": false,
"order": [],
"ajax": {
"url": "<?php echo site_url('vendor/list_siujk_show')?>",
"type": "POST",
data: function(d) {
	d.id_vd = id_vd
}
},
"columnDefs": [
{
"className": "text-left",
"targets": [1,2],
},
{
"className": "text-center",
"targets": [3,4],
},
],
});
}

function add_siujk()
{
no = no + 1;
var a = document.getElementById("list_siujk_all");
var b = a.options[a.selectedIndex].value;
var bx = b+" - ";
var cx = a.options[a.selectedIndex].text;
var c = cx.replace(bx,'');
var id_vd = $("#id_vd").val();
var kode = $("#list_siujk_all").val();
var kode_grade = $("#grade_siujk").val();

if (id_vd != '' && kode != '' && kode_grade != '') {
$.ajax({
	url : "<?php echo site_url('vendor/list_siujk_insert')?>/"+id_vd+"/"+kode+"/"+kode_grade,
	type: "POST",
	dataType: "JSON",
	success: function(data)
	{
		if(data.status)
		{
			$('#list_siujk_all').val('').trigger('change');
			$('#grade_siujk').val('').trigger('change');
			show_siujk();
		}
		else
		{
			$('#list_siujk_all').val('').trigger('change');
			$('#grade_siujk').val('').trigger('change');
			alert("Id '"+cx+"' sudah digunakan pada tabel ini!");
		}

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Hubungi admin untuk menambahkan data ini');
	}
});
}
else {
alert("Pilih terlebih dahulu!");
}
}

function del_siujk(r) {
var table = document.getElementById('tabel_siujk');
var i = r.parentNode.parentNode.rowIndex;
var kode = table.rows[i].cells[1].innerHTML;
var id_vd = $("#id_vd").val();

if(confirm('Yakin anda ingin mengeluarkan '+kode+' ?' ))
{
	$.ajax({
			url : "<?php echo site_url('vendor/list_siujk_delete')?>/"+id_vd+"/"+kode,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				//document.getElementById("tabel_siujk").deleteRow(i);
				show_siujk();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Hubungi admin untuk mengeluarkan data ini');
			}
	});
}

}

function show_siu()
{
var id_vd = document.getElementById("id_vd").value;
id_vd = $('#tabel_siu').DataTable({
destroy: true,
"paging":   false,
"ordering": false,
"info":     false,
"searching": false,
"processing": true,
"serverSide": false,
"order": [],
"ajax": {
"url": "<?php echo site_url('vendor/list_siu_show')?>",
"type": "POST",
data: function(d) {
	d.id_vd = id_vd
}
},
"columnDefs": [
{
"className": "text-left",
"targets": [1,2],
},
{
"className": "text-center",
"targets": [3],
},
],
});
}


function add_siu()
{
no = no + 1;
var isi = document.getElementById("siu_input").value;
var id_vd = $("#id_vd").val();

if (id_vd != '') {
$.ajax({
	url : "<?php echo site_url('vendor/list_siu_insert')?>/"+id_vd,
	type: "POST",
	data: {
		isi : isi
	},
	dataType: "JSON",
	success: function(data)
	{
		if(data.status)
		{
			$("#siu_input").val('');
			show_siu();
		}
		else
		{
			$("#siu_input").val('');
			alert("Data sudah digunakan pada daftar ini!");
		}

	},
	error: function (jqXHR, textStatus, errorThrown)
	{
			alert('Hubungi admin untuk menambahkan data ini');
	}
});
}
else {
alert("Pilih terlebih dahulu!");
}
}

function del_siu(r) {
var table = document.getElementById('tabel_siu');
var i = r.parentNode.parentNode.rowIndex;
var cx = table.rows[i].cells[1].innerHTML;
var kode = cx.replace('SIU-','');
var id_vd = $("#id_vd").val();

if(confirm('Yakin anda ingin mengeluarkan '+kode+' ?' ))
{
	$.ajax({
			url : "<?php echo site_url('vendor/list_siu_delete')?>/"+id_vd+"/"+kode,
			type: "POST",
			dataType: "JSON",
			success: function(data)
			{
				//document.getElementById("tabel_siu").deleteRow(i);
				show_siu();
			},
			error: function (jqXHR, textStatus, errorThrown)
			{
					alert('Hubungi admin untuk mengeluarkan data ini');
			}
	});
}

}

function addElement(tabel, urut, kolom_1, kolom_2, kolom_3, kolom_4)
{
$('#'+tabel+'> tbody:last-child').append('<tr id="'+urut+'">'+kolom_1+kolom_2+kolom_3+kolom_4+'</tr>');
}

function removeElement(tabel,urut) {
$('table#'+tabel+' tr#'+urut+'').remove();
}

function edit_vendor(id_cari)
{
$("#form")[0].reset();
$('[class="help-block"]').text('');
$("#btnSave").hide();$("#btnUpdate").show();


var baseUrl = '<?php echo base_url(); ?>index.php/vendor/detil_vendor_all/'+id_cari;
$.ajax({
url: baseUrl,
dataType: 'json',
success: function(datas)
{
$("#id_vd").val(datas.id_vd);
$("#nama_pt").val(datas.nama_pt);
$("#alamat_pt").val(datas.alamat_pt);
$("#kodepos").val(datas.kodepos);
$("#no_tlp_pt").val(datas.no_tlp_pt);
$("#no_fax_pt").val(datas.no_fax_pt);
$("#nama_dirut").val(datas.nama_dirut);
$("#nama_pic").val(datas.nama_pic);
$("#no_hp_pic").val(datas.no_hp_pic);
$("#email_pic").val(datas.email_pic);
$("#no_domisili").val(datas.no_domisili);
if(datas.tgl_domisili == '0000-00-00')
{
	$("#tgl_domisili").val('0000-00-00');
}
else
{
	$("#tgl_domisili").datepicker('setDate', datas.tgl_domisili);
}
$("#tgl_exp_domisili").val(datas.tgl_exp_domisili);
$("#file_domisili").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_domisili+'">'+datas.file_domisili+'</a>'));

$("#no_akta_pendirian").val(datas.no_akta_pendirian);
$("#tgl_akta_pendirian").val(datas.tgl_akta_pendirian);
$("#file_akta_pendirian").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_akta_pendirian+'">'+datas.file_akta_pendirian+'</a>'));

$("#no_pengesahan_akta_pendirian").val(datas.no_pengesahan_akta_pendirian);
$("#tgl_pengesahan_akta_pendirian").val(datas.tgl_pengesahan_akta_pendirian);
$("#no_akta_perubahan").val(datas.no_akta_perubahan);
$("#tgl_akta_perubahan").val(datas.tgl_akta_perubahan);
$("#no_pengesahan_akta_perubahan").val(datas.no_pengesahan_akta_perubahan);
$("#tgl_pengesahan_akta_perubahan").val(datas.tgl_pengesahan_akta_perubahan);
$("#file_akta_perubahan").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_akta_perubahan+'">'+datas.file_akta_perubahan+'</a>'));

$("#no_npwp").val(datas.no_npwp);
$("#tgl_npwp").val(datas.tgl_npwp);
$("#file_npwp").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_npwp+'">'+datas.file_npwp+'</a>'));

$("#no_pkp").val(datas.no_pkp);
$("#tgl_pkp").val(datas.tgl_pkp);
$("#file_pkp").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_pkp+'">'+datas.file_pkp+'</a>'));

$("#no_tdp").val(datas.no_tdp);
if(datas.tgl_tdp == '0000-00-00')
{
	$("#tgl_tdp").val('0000-00-00');
}
else
{
	$("#tgl_tdp").datepicker('setDate', datas.tgl_tdp);
}
$("#tgl_exp_tdp").val(datas.tgl_exp_tdp);
$("#file_tdp").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_tdp+'">'+datas.file_tdp+'</a>'));

$("#nomor_siup").val(datas.nomor_siup);
if(datas.tgl_siup == '0000-00-00')
{
	$("#tgl_siup").val('0000-00-00');
}
else
{
	$("#tgl_siup").datepicker('setDate', datas.tgl_siup);
}
$("#tgl_exp_siup").val(datas.tgl_exp_siup);
$("#modal_usaha_siup").val((datas.modal_usaha_siup));
$("#grade_siup").val(datas.grade_siup);
$("#file_siup").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_siup+'">'+datas.file_siup+'</a>'));

$("#nomor_siujk").val(datas.nomor_siujk);
if(datas.tgl_siujk == '0000-00-00')
{
	$("#tgl_siujk").val('0000-00-00');
}
else
{
	$("#tgl_siujk").datepicker('setDate', datas.tgl_siujk);
}
$("#tgl_exp_siujk").val(datas.tgl_exp_siujk);
$("#modal_usaha_siujk").val((datas.modal_usaha_siujk));
$("#grade_siujk").val(datas.grade_siujk);
$("#file_siujk").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_siujk+'">'+datas.file_siujk+'</a>'));

$("#nomor_siu").val(datas.nomor_siu);
$("#nama_siu").val(datas.nama_siu);
if(datas.tgl_siu == '0000-00-00')
{
	$("#tgl_siu").val('0000-00-00');
}
else
{
	$("#tgl_siu").datepicker('setDate', datas.tgl_siu);
}
$("#tgl_exp_siu").val(datas.tgl_exp_siu);
$("#modal_usaha_siu").val((datas.modal_usaha_siu));
$("#grade_siu").val(datas.grade_siu);
$("#file_siu").next().append($('<a target="_blank" href="<?php echo base_url(); ?>upload/'+datas.file_siu+'">'+datas.file_siu+'</a>'));

$("#prov_vd").hide();$("#prov_vdx").show();$('#prov_vdx').attr('disabled',true);
$("#prov_vdx").val(datas.prov_nama);
$("#kab_vd").hide();$("#kab_vdx").show();$('#kab_vdx').attr('disabled',true);
$("#kab_vdx").val(datas.kab_nama);
$("#kec_vd").hide();$("#kec_vdx").show();$('#kec_vdx').attr('disabled',true);
$("#kec_vdx").val(datas.kec_nama);
//vendor_siup(datas.id_vd);
//vendor_siujk(datas.id_vd);
$('.nav-tabs a[href="#tab_1_2"]').tab('show');
show_siup();
show_siujk();
show_siu();
},
error: function (xhr, ajaxOptions, thrownError) {
alert("Hubungi Administrator");
}
});
}

function format_uang(uang)
{
if (uang == null)
{
var pitih = '';
}
else
{
var pitih = 'Rp. ' + parseFloat(uang).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
}
return pitih;
}

function vendor_baru()
{
$('.nav-tabs a[href="#tab_1_2"]').tab('show');
$("#form")[0].reset();
$('[class="help-block"]').text('');

$("#prov_vd").show();$("#prov_vdx").hide();$('#prov_vdx').attr('disabled',false);
$("#kab_vd").show();$("#kab_vdx").hide();$('#kab_vdx').attr('disabled',false);
$("#kec_vd").show();$("#kec_vdx").hide();$('#kec_vdx').attr('disabled',false);

$("#btnSave").show();$("#btnUpdate").hide();
id_vendor_baru();
}

function update()
{
save_method = 'update';

$('#btnSave').text('Sedang proses simpan...');
$('#btnSave').attr('disabled',true);
var url;

if(save_method == 'add') {
url = "<?php echo site_url('vendor/vendor_add')?>";
} else {
url = "<?php echo site_url('vendor/vendor_update')?>";
}

var formData = new FormData($('#form')[0]);
$.ajax({
url : url,
type: "POST",
data: formData,
contentType: false,
processData: false,
dataType: "JSON",
success: function(data)
{
	if(data.status)
	{
		alert("sukses");
		location.reload();
	}
	else
	{
		alert("Ups, ada kekurangan dalam inputan!");
		for (var i = 0; i < data.inputerror.length; i++)
		{
			switch (data.inputerror[i])
			{
				case 'notif_siup':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				case 'notif_siujk':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				case 'notif_siu':
					$('[name="'+data.inputerror[i]+'"]').parent().addClass('alert bg-red');
					$('[name="'+data.inputerror[i]+'"]').text(data.error_string[i]);
					break;
				default:
					$('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
					$('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
					break;
			}
		}
	}
	$('#btnSave').text('Simpan');
	$('#btnSave').attr('disabled',false);
},
error: function (jqXHR, textStatus, errorThrown)
{
	alert('Error adding data, hubungi admin');
	$('#btnSave').text('save');
	$('#btnSave').attr('disabled',false);
}
});
}

$("#masa_tdp").on("change", function(){
var tahun = $(this).val();
var tglawal  = $("#tgl_tdp").datepicker('getDate');
var durasi = 365*tahun;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_tdp').datepicker('setDate', tglawal);
});

$("#masa_domisili").on("change", function(){
var tahun = $(this).val();
var tglawal  = $("#tgl_domisili").datepicker('getDate');
var durasi = 365*tahun;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_domisili').datepicker('setDate', tglawal);
});

$("#masa_siup").on("change", function(){
var tahun = $(this).val();
var tglawal  = $("#tgl_siup").datepicker('getDate');
var durasi = 365*tahun;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_siup').datepicker('setDate', tglawal);
});

$("#masa_siujk").on("change", function(){
var tahun = $(this).val();
var tglawal  = $("#tgl_siujk").datepicker('getDate');
var durasi = 365*tahun;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_siujk').datepicker('setDate', tglawal);
});

$("#masa_siu").on("change", function(){
var tahun = $(this).val();
var tglawal  = $("#tgl_siu").datepicker('getDate');
var durasi = 365*tahun;
tglawal.setDate(tglawal.getDate() + durasi);
$('#tgl_exp_siu').datepicker('setDate', tglawal);
});

</script>
</body>
</html>
