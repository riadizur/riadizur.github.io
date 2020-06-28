			<div class="page-head">
				<div class="page-title">
					<h1>Daftar <small>Kontrak Pekerjaan</small></h1>
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
									Daftar Kontrak </a>
							</li>
							<li>
								<a href="#tab_1_2" data-toggle="tab">
									Undangan </a>
							</li>
							<li>
								<a href="#tab_1_3" data-toggle="tab">
									Aanwijzing </a>
							</li>
							<li>
								<a href="#tab_1_4" data-toggle="tab">
									Penawaran </a>
							</li>
							<li>
								<a href="#tab_1_5" data-toggle="tab">
									Penetapan Pemenang</a>
							</li>
							<li>
								<a href="#tab_1_6" data-toggle="tab">
									Input Data Kontrak</a>
							</li>
						</ul>
						<div class="tab-content">

							<div class="tab-pane active" id="tab_1_1">
								<div class="portlet box green-haze">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Daftar Kontrak Pekerjaan PT Energi Pelabuhan Indonesia
										</div>
									</div>
									<div class="portlet-body">
										<div class="portlet-body form">
											<form action="#" id="form" class="form-horizontal" role="form">
												<input type="hidden" value="" name="id" />
												<div class="form-body">
													<div class="row">
														<div class="col-md-12">
															<div class="table-scrollable">
																<table class="table table-striped table-bordered table-hover" id="table">
																	<thead>
																		<tr>
																			<th width='100'>
																				ID Pekerjaan
																			</th>
																			<th>
																				Nama Pekerjaan
																			</th>
																			<th>
																				Nilai Pekerjaan
																			</th>
																			<th width='80'>
																				Divisi
																			</th>
																			<th width='170'>
																				Metode Pengadaan
																			</th>
																			<th width='200'>
																				Nomor Kontrak
																			</th>
																			<th width='170'>
																				Status
																			</th>
																			<th width='210'>
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
								<div class="clearfix"></div>
							</div>

							<div class="tab-pane" id="tab_1_2">
								<div class="portlet solid red-pink col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Register </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data" id="cari_data" class="form-control input-sm" placeholder="Cari...">
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_undang()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="portlet box red-pink">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Undangan Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" name="no_reg_pekerjaan" id="no_reg_pekerjaan" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="nama_pekerjaan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="lokasi_pekerjaan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
														<div class="col-md-8">
															<input type="text" id="nilai_oe" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Divisi </label>
														<div class="col-md-8">
															<input type="text" id="divisi" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
														<div class="col-md-8">
															<input type="text" id="durasi" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="metode_pengadaan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="jenis_pengadaan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Klasifikasi / Kategori Pekerjaan</label>
														<div class="col-md-8">
															<textarea class="form-control input-sm" id="bidang_pekerjaan" rows="3" readonly="true"></textarea>
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Sub Klasifikasi / Kategori Pekerjaan</label>
														<div class="col-md-8">
															<textarea class="form-control input-sm" id="sub_bidang_pekerjaan" rows="3" readonly="true"></textarea>
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="panel panel-default">
												<form action="#" id="form_undang" class="form-horizontal" role="form">
													<div class="panel-body form-horizontal">
														<h4 class="text-danger">Daftar Peserta</h4>
														<div class="col-md-6">
															<div class="form-group">
																<div class="radio-list" id="cekin">
																	<label>
																		<input type="radio" name="or_undang" id="or_undang_1" value="or_undang_1"> Berdasarkan grade
																	</label>
																	<label>
																		<input type="radio" name="or_undang" id="or_undang_2" value="or_undang_2"> Nilai batas maksimum kontrak
																	</label>
																</div>
															</div>
														</div>
														<input type="hidden" name="cari_id" id="cari_id" />
														<div class="col-md-6">
															<div class="form-group" id="check_box_undang" style="display:none;">
																<p>Pilih grade :</p>
																<select class="form-control input-sm" style="width:100%;" id="list_grade" name="list_grade" data-placeholder="-Pilih-" multiple="multiple">
																</select>
																<span class="help-block"></span>
															</div>
														</div>
														<div class="col-md-12 form-group">
															<a type="button" id="btn_undang_filter" onclick="filter_undang()" class="btn btn-sm red-pink"><i class="glyphicon glyphicon-search" title="Filter Pencarian"></i> Filter Pencarian</a>
														</div>
														<hr />
														<input type="hidden" id="last_undang" name="last_undang" />
														<div class="table-scrollable">
															<table class="table table-striped table-bordered table-hover" id="tabel_undang">
																<thead>
																	<tr>
																		<th width='50'>
																			#
																		</th>
																		<th>
																			Id Vendor
																		</th>
																		<th>
																			Nama Vendor
																		</th>
																		<th>
																			Grade
																		</th>
																	</tr>
																</thead>
																<tbody id='isi_undang'>
																</tbody>
															</table>
														</div>
														<input type="hidden" name="tipe_grade" id="tipe_grade" />
														<input type="hidden" name="id_sub_bidang_pekerjaan" id="id_sub_bidang_pekerjaan" />
														<input type="hidden" name="pilih_grade" id="pilih_grade" />
														<input type="hidden" name="nilai_oex" id="nilai_oex" />
													</div>
												</form>
											</div>
										</div>
										<div class="col-md-12">
											<a type="button" style="display:none;" id="btn_simpan_undang" onclick="simpan_undang()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>

							<div class="tab-pane" id="tab_1_3">
								<div class="portlet solid green-meadow col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Register </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data_anwizing" id="cari_data_anwizing" class="form-control input-sm" placeholder="Cari...">
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_anwizing()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
												<input type="hidden" name="cari_id_anwizing" id="cari_id_anwizing" />
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="portlet box green-meadow">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Proses Anwizing
										</div>
									</div>
									<div class="portlet-body">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" name="no_reg_pekerjaan_anwizing" id="no_reg_pekerjaan_anwizing" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="nama_pekerjaan_anwizing" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="lokasi_pekerjaan_anwizing" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
														<div class="col-md-8">
															<input type="text" id="nilai_oe_anwizing" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Divisi </label>
														<div class="col-md-8">
															<input type="text" id="divisi_anwizing" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
														<div class="col-md-8">
															<input type="text" id="durasi_anwizing" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="metode_pengadaan_anwizing" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="jenis_pengadaan_anwizing" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet box green-meadow">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-group"></i> Daftar Peserta
													</div>
												</div>
												<div class="portlet-body">
													<div class="panel panel-default">
														<form action="#" id="form_anwizing" class="form-horizontal" role="form">
															<div class="panel-body form-horizontal">
																<div class="table-scrollable">
																	<input type="hidden" id="last_anwizing" class="form-control input-sm" />
																	<table class="table table-striped table-bordered table-hover" id="tabel_anwizing">
																		<thead>
																			<tr>
																				<th width='50'>
																					#
																				</th>
																				<th>
																					Id Vendor
																				</th>
																				<th>
																					Nama Vendor
																				</th>
																				<th width='100'>
																					Kehadiran
																				</th>
																			</tr>
																		</thead>
																		<tbody id='isi_anwizing'>
																		</tbody>
																	</table>
																	<input type="hidden" id="anwizing_checkbox" class="form-control input-sm" />
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<a type="button" style="display:none;" id="btn_simpan_anwizing" onclick="simpan_anwizing()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

							<div class="tab-pane" id="tab_1_4">
								<div class="portlet solid purple-medium col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Register </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data_penawaran" id="cari_data_penawaran" class="form-control input-sm" placeholder="Cari...">
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_penawaran()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
												<input type="hidden" name="cari_id_penawaran" id="cari_id_penawaran" />
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="portlet box purple-medium">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Proses Penawaran
										</div>
									</div>
									<div class="portlet-body">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" name="no_reg_pekerjaan_penawaran" id="no_reg_pekerjaan_penawaran" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="nama_pekerjaan_penawaran" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="lokasi_pekerjaan_penawaran" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
														<div class="col-md-8">
															<input type="text" id="nilai_oe_penawaran" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Divisi </label>
														<div class="col-md-8">
															<input type="text" id="divisi_penawaran" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
														<div class="col-md-8">
															<input type="text" id="durasi_penawaran" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="metode_pengadaan_penawaran" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="jenis_pengadaan_penawaran" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet box purple-medium">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-group"></i> Daftar Peserta
													</div>
												</div>
												<div class="portlet-body">
													<div class="panel panel-default">
														<form action="#" id="form_penawaran" class="form-horizontal" role="form">
															<div class="panel-body form-horizontal">
																<div class="table-scrollable">
																	<input type="hidden" id="last_penawaran" class="form-control input-sm" />
																	<table class="table table-striped table-bordered table-hover" id="tabel_penawaran">
																		<thead>
																			<tr>
																				<th width='50'>
																					#
																				</th>
																				<th>
																					Id Vendor
																				</th>
																				<th>
																					Nama Vendor
																				</th>
																				<th width='100'>
																					Kehadiran
																				</th>
																			</tr>
																		</thead>
																		<tbody id='isi_penawaran'>
																		</tbody>
																	</table>
																	<input type="hidden" id="penawaran_checkbox" class="form-control input-sm" />
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<a type="button" style="display:none;" id="btn_simpan_penawaran" onclick="simpan_penawaran()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

							<div class="tab-pane" id="tab_1_5">
								<div class="portlet solid grey-cascade col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Register </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data_penetapan" id="cari_data_penetapan" class="form-control input-sm" placeholder="Cari...">
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_penetapan()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
												<input type="hidden" name="cari_id_penetapan" id="cari_id_penetapan" />
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="portlet box grey-cascade">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-globe"></i>Proses Pengumuman Pemenang
										</div>
									</div>
									<div class="portlet-body">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" name="no_reg_pekerjaan_penetapan" id="no_reg_pekerjaan_penetapan" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="nama_pekerjaan_penetapan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
														<div class="col-md-8">
															<input type="text" id="lokasi_pekerjaan_penetapan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
														<div class="col-md-8">
															<input type="text" id="nilai_oe_penetapan" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body form-horizontal">
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Divisi </label>
														<div class="col-md-8">
															<input type="text" id="divisi_penetapan" class="form-control input-sm" placeholder=" " readonly="true">
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
														<div class="col-md-8">
															<input type="text" id="durasi_penetapan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="metode_pengadaan_penetapan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
													<div class="form-group">
														<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
														<div class="col-md-8">
															<input type="text" id="jenis_pengadaan_penetapan" class="form-control input-sm" placeholder=" " readonly="true" />
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet box grey-cascade">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-group"></i> Daftar Peserta
													</div>
												</div>
												<div class="portlet-body">
													<div class="panel panel-default">
														<form action="#" id="form_penetapan" class="form-horizontal" role="form">
															<div class="panel-body form-horizontal">
																<div class="table-scrollable">
																	<input type="hidden" id="last_penetapan" class="form-control input-sm" />
																	<table class="table table-striped table-bordered table-hover" id="tabel_penetapan">
																		<thead>
																			<tr>
																				<th width='50'>
																					#
																				</th>
																				<th>
																					Id Vendor
																				</th>
																				<th>
																					Nama Vendor
																				</th>
																				<th width='100'>
																					Kehadiran
																				</th>
																			</tr>
																		</thead>
																		<tbody id='isi_penetapan'>
																		</tbody>
																	</table>
																	<input type="hidden" id="penetapan_checkbox" class="form-control input-sm" />
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="portlet box grey-cascade">
												<div class="portlet-title">
													<div class="caption">
														<i class="fa fa-group"></i> Pemenang
													</div>
												</div>
												<div class="portlet-body">
													<div class="panel panel-default">
														<form action="#" id="form_pemenang" class="form-horizontal" role="form">
															<div class="panel-body form-horizontal">
																<div class="form-group">
																	<label class="col-md-4 control-label align-left">Vendor Pemenang</label>
																	<div class="col-md-8">
																		<select class="form-control input-sm" style="width:100%;" id="vendor_pemenang" name="vendor_pemenang" data-placeholder="-Pilih-">
																		</select>
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-4 control-label align-left">Nilai Penawaran (Rp.)</label>
																	<div class="col-md-8">
																		<input type="text" id="nilai_penawaran" name="nilai_penawaran" class="form-control input-sm mark_decimal" placeholder=" " required />
																	</div>
																</div>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<a type="button" style="display:none;" id="btn_simpan_penetapan" onclick="simpan_penetapan()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
										</div>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>

							<div class="tab-pane" id="tab_1_6">
								<div class="portlet solid blue-steel col-md-6">
									<div class="portlet-title">
										<div class="caption">
											<i class="fa fa-search"></i>Cari Data Kontrak Pekerjaan
										</div>
									</div>
									<div class="portlet-body">
										<div class="form-group">
											<label class="col-md-5 control-label align-left">Masukkan No. Register </label>
											<div class="col-md-7 input-group">
												<input type="text" name="cari_data_final" id="cari_data_final" class="form-control input-sm" placeholder="Cari...">
												<span class="input-group-btn">
													<a type="button" id="btncari" onclick="cari_final()" class="btn btn-sm yellow"><i class="glyphicon glyphicon-search" title="Cari data"></i> Cari</a>
												</span>
												<input type="hidden" name="cari_id_final" id="cari_id_final" />
											</div>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<form action="#" id="form_final" class="form-horizontal" role="form">
									<div class="portlet box blue-steel">
										<div class="portlet-title">
											<div class="caption">
												<i class="fa fa-globe"></i>Finalisasi data
											</div>
										</div>
										<div class="portlet-body">
											<div class="col-md-6">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">

														<div class="form-group">
															<label class="col-md-4 control-label align-left">No. Reg. Pekerjaan</label>
															<div class="col-md-8">
																<input type="text" name="no_reg_pekerjaan_final" id="no_reg_pekerjaan_final" class="form-control input-sm" placeholder=" " readonly="true">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nama Pekerjaan</label>
															<div class="col-md-8">
																<input type="text" id="nama_pekerjaan_final" class="form-control input-sm" placeholder=" " readonly="true" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Lokasi Pekerjaan</label>
															<div class="col-md-8">
																<input type="text" id="lokasi_pekerjaan_final" class="form-control input-sm" placeholder=" " readonly="true" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nilai OE (inc. PPN)</label>
															<div class="col-md-8">
																<input type="text" id="nilai_oe_final" class="form-control input-sm" placeholder=" " readonly="true">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Divisi </label>
															<div class="col-md-8">
																<input type="text" id="divisi_final" class="form-control input-sm" placeholder=" " readonly="true">
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Durasi (Hari)</label>
															<div class="col-md-8">
																<input type="text" id="durasi_final" class="form-control input-sm" placeholder=" " readonly="true" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Metode Pengadaan</label>
															<div class="col-md-8">
																<input type="text" id="metode_pengadaan_final" class="form-control input-sm" placeholder=" " readonly="true" />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Jenis Pengadaan</label>
															<div class="col-md-8">
																<input type="text" id="jenis_pengadaan_final" class="form-control input-sm" placeholder=" " readonly="true" />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="panel panel-default">
													<div class="panel-body form-horizontal">
														<div class="form-group">
															<label class="col-md-4 control-label align-left">No. Kontrak</label>
															<div class="col-md-8">
																<input type="text" name="no_kontrak_final" id="no_kontrak_final" class="form-control input-sm" placeholder="Masukkan nomor kontrak " required />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Nilai Kontrak (inc. PPN) (Rp.)</label>
															<div class="col-md-8">
																<input type="text" id="mark_decimal" name="nilai_kontrak_final" class="form-control input-sm" placeholder="Masukkan Nilai kontrak " required>
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Mulai</label>
															<div class="col-md-8">
																<input type="text" id="tgl_mulai_final" name="tgl_mulai_final" class="form-control input-sm datepicker" placeholder="Tanggal mulai kontrak " required />
															</div>
														</div>
														<div class="form-group">
															<label class="col-md-4 control-label align-left">Tanggal Akhir</label>
															<div class="col-md-8">
																<input type="text" id="tgl_akhir_final" name="tgl_akhir_final" class="form-control input-sm datepicker" placeholder="Tanggal akhir kontrak " required />
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<div class="portlet box blue-steel">
													<div class="portlet-title">
														<div class="caption">
															<i class="fa fa-group"></i> Pemenang
														</div>
													</div>
													<div class="portlet-body">
														<div class="panel panel-default">
															<div class="panel-body form-horizontal">
																<div class="form-group">
																	<label class="col-md-4 control-label align-left">Vendor Pemenang</label>
																	<div class="col-md-8">
																		<input type="text" id="vendor_pemenang_final" name="vendor_pemenang_final" class="form-control input-sm" placeholder=" " readonly="true" />
																	</div>
																</div>
																<div class="form-group">
																	<label class="col-md-4 control-label align-left">Nilai Penawaran (Rp.)</label>
																	<div class="col-md-8">
																		<input type="text" id="nilai_penawaran_final" name="nilai_penawaran_final" class="form-control input-sm" placeholder=" " readonly="true" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-12">
												<a type="button" style="display:none;" id="btn_simpan_final" onclick="simpan_final()" class="col-md-12 btn btn-sm red-pink"><i class="glyphicon glyphicon-floppy-disk" title="Simpan"></i> Simpan</a>
											</div>
											<div class="clearfix"></div>
										</div>
									</div>
								</form>
								<div class="clearfix"></div>
							</div>

						</div>
					</div>
				</div>
			</div>
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

				$(document).ready(function() {

					table = $('#table').DataTable({

						"processing": true,
						"serverSide": true,
						"order": [],

						"ajax": {
							"url": "<?php echo site_url('kontrak/kontrak_list') ?>",
							"type": "POST"
						},

						"columnDefs": [{
							"targets": [-1],
							"orderable": false,
						}, ],

					});

					$('.datepicker').datepicker({
						autoclose: true,
						format: "yyyy-mm-dd",
						todayHighlight: true,
						orientation: "top auto",
						todayBtn: true,
						todayHighlight: true,
					});

					$('#cari_data').autocomplete({
						delay: 0,
						source: "<?php echo site_url('kontrak/get_undang/?'); ?>",
						select: function(event, ui) {
							$('#cari_data').val(ui.item.label);
							$('#cari_id').val(ui.item.id);
							return false;
						},
						focus: function(event, ui) {
							$("#cari_data").val(ui.item.label);
							return false;
						}
					});

					$('#cari_data_anwizing').autocomplete({
						delay: 0,
						source: "<?php echo site_url('kontrak/get_anwizing/?'); ?>",
						select: function(event, ui) {
							$('#cari_data_anwizing').val(ui.item.label);
							$('#cari_id_anwizing').val(ui.item.id);
							return false;
						},
						focus: function(event, ui) {
							$("#cari_data_anwizing").val(ui.item.label);
							return false;
						}
					});

					$('#cari_data_penawaran').autocomplete({
						delay: 0,
						source: "<?php echo site_url('kontrak/get_penawaran/?'); ?>",
						select: function(event, ui) {
							$('#cari_data_penawaran').val(ui.item.label);
							$('#cari_id_penawaran').val(ui.item.id);
							return false;
						},
						focus: function(event, ui) {
							$("#cari_data_penawaran").val(ui.item.label);
							return false;
						}
					});

					$('#cari_data_penetapan').autocomplete({
						delay: 0,
						source: "<?php echo site_url('kontrak/get_penetapan/?'); ?>",
						select: function(event, ui) {
							$('#cari_data_penetapan').val(ui.item.label);
							$('#cari_id_penetapan').val(ui.item.id);
							return false;
						},
						focus: function(event, ui) {
							$("#cari_data_penetapan").val(ui.item.label);
							return false;
						}
					});

					$('#cari_data_final').autocomplete({
						delay: 0,
						source: "<?php echo site_url('kontrak/get_final/?'); ?>",
						select: function(event, ui) {
							$('#cari_data_final').val(ui.item.label);
							$('#cari_id_final').val(ui.item.id);
							return false;
						},
						focus: function(event, ui) {
							$("#cari_data_final").val(ui.item.label);
							return false;
						}
					});

					$(':radio[id=or_undang_1]').change(function() {
						$("#check_box_undang").show();
					});

					$(':radio[id=or_undang_2]').change(function() {
						$("#check_box_undang").hide();
					});

					$("#mark_decimal").inputmask({
						'alias': 'decimal',
						rightAlign: true,
						'groupSeparator': '.',
						'autoGroup': true
					});

					$('.mark_decimal').inputmask({
						'alias': 'decimal',
						rightAlign: true,
						'groupSeparator': '.',
						'autoGroup': true
					});

					$("#tgl_mulai_final").datepicker().datepicker({
						onSelect: function(dateText) {
							var tglawal = $(this).datepicker('getDate');
							var durasi = parseInt(document.getElementById("durasi_final").value);

							tglawal.setDate(tglawal.getDate() + durasi);
							$('#tgl_akhir_final').datepicker('setDate', tglawal);

						}
					}).on("change", function() {
						var tglawal = $(this).datepicker('getDate');
						var durasi = parseInt(document.getElementById("durasi_final").value);

						tglawal.setDate(tglawal.getDate() + durasi);
						$('#tgl_akhir_final').datepicker('setDate', tglawal);

					});

				});

				function cari_undang(id_cari) {
					removeAll_undang();
					$('.nav-tabs a[href="#tab_1_2"]').tab('show');
					$("#btn_simpan_undang").hide();

					if (id_cari == null) {
						var carix = document.getElementById('cari_id').value;
					} else {
						$("#cari_data").val('');
						$("#cari_id").val(id_cari);
						var carix = id_cari;
					}

					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_kontrak/' + carix;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$("#no_reg_pekerjaan").val(datas.no_reg_pekerjaan);
							$("#nama_pekerjaan").val(datas.nama_pekerjaan);
							$("#lokasi_pekerjaan").val(datas.lokasi);
							$("#jenis_pengadaan").val(datas.jenis_pengadaan);
							$("#nilai_oe").val(format_uang(datas.nilai_oe));
							$("#nilai_oex").val(datas.nilai_oe);
							$("#divisi").val(datas.divisi);
							$("#durasi").val(datas.durasi);
							$("#metode_pengadaan").val(datas.metode_pengadaan);
							$("#bidang_pekerjaan").val(datas.bidang_pekerjaan);
							$("#sub_bidang_pekerjaan").val(datas.sub_bidang_pekerjaan);
							$("#id_sub_bidang_pekerjaan").val(datas.id_sub_bidang_pekerjaan);

							grade_klasifikasi(datas.jenis_pengadaan);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function detil_bidang_pekerjaan(carix) {
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/bidang_pekerjaan_detil/' + carix;

					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								$("#bidang_pekerjaan").val(obj.isi);
							});
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ");
						}
					});
				}

				function grade_klasifikasi(klasifikasix) {
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/undang_klasifikasi/' + klasifikasix;
					removeOptions(document.getElementById("list_grade"));
					var list_grade = ["-Pilih-"];
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								list_grade.push({
									'id': obj.kode,
									'text': obj.kode + ' - ' + obj.kualifikasi,
								});
								$("#tipe_grade").val(obj.izin);

								return list_grade;
							});
							$("#list_grade").select2({
								allowClear: true,
								placeholder: "Pilih",
								data: list_grade,
								width: '100%'
							});
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function filter_undang() {
					removeAll_undang();
					$("#btn_simpan_undang").show();

					var radiox = document.querySelector('input[name="or_undang"]:checked').value;
					var izinx = document.getElementById('tipe_grade').value;
					var sub_bidangx = document.getElementById('id_sub_bidang_pekerjaan').value.replace(/\,/g, ' ');

					var nilai_oex = document.getElementById('nilai_oex').value;

					if (radiox == 'or_undang_1') {
						var multi_pilihx = $("#list_grade").select2("val") + '';
						var pilihx = multi_pilihx.replace(/,/g, ' ');
						$("#pilih_grade").val(pilihx);
						var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/filter_undang/' + izinx + '/' + sub_bidangx + '/' + pilihx + '/';
					} else {
						var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/filter_undang/' + izinx + '/' + sub_bidangx + '/x/' + nilai_oex + '/';
						//$("#list_grade").select2("val", "");
						$("#list_grade").val(null).trigger("change");
						$("#pilih_grade").val('');
					}

					var daftar_vendor = ["-Pilih-"];
					var urut_undang = 0;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								urut_undang = urut_undang + 1;
								var tabel = "tabel_undang";
								var kolom_1 = "<td>" + urut_undang + "</td>";
								var kolom_2 = "<td>" + obj.id_vd + "</td>";
								var kolom_3 = "<td>" + obj.nama_pt + "</td>";
								var kolom_4 = "<td>" + obj.grade + "</td>";
								addElement(tabel, urut_undang, kolom_1, kolom_2, kolom_3, kolom_4);
							});
							$('#last_undang').val(urut_undang);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				var urut_undang = 0;

				function add_undang() {
					var a = document.getElementById("daftar_vendor");
					var b = a.options[a.selectedIndex].value;
					var c = a.options[a.selectedIndex].text;

					if (b == '') {
						alert('Pilih Vendor terlebih dahulu');
					} else {

					}
				}

				function addElement(tabel, urut, kolom_1, kolom_2, kolom_3, kolom_4) {
					$('#' + tabel + '> tbody:last-child').append('<tr id="' + urut + '">' + kolom_1 + kolom_2 + kolom_3 + kolom_4 + '</tr>');
				}

				function removeElement(tabel, urut) {
					$('table#' + tabel + ' tr#' + urut + '').remove();
				}

				function removeAll_undang() {
					var tabel = "tabel_undang";
					var urut = document.getElementById("last_undang").value;
					urut_undang = 0;
					for (var i = 1; i <= urut; i++) {
						$('table#' + tabel + ' tr#' + i + '').remove();
					}
				}

				function simpan_undang() {
					$('#btn_simpan_undang').text('Sedang proses simpan...');
					$('#btn_simpan_undang').attr('disabled', true);

					var urut = document.getElementById("last_undang").value;
					if (urut == '' || urut == 0 || urut == null) {
						alert('harus pilih vendor yang diundang');
						$('#btn_simpan_undang').text('Simpan');
						$('#btn_simpan_undang').attr('disabled', false);
					} else {
						var url = "<?php echo site_url('kontrak/add_undang') ?>";
						var formData = new FormData($('#form_undang')[0]);
						$.ajax({
							url: url,
							type: "POST",
							data: formData,
							contentType: false,
							processData: false,
							dataType: "JSON",
							success: function(data) {
								if (data.status) {
									excell_undang();

									alert("sukses");
									location.reload();

									$('#btn_simpan_undang').text('Simpan');
									$('#btn_simpan_undang').attr('disabled', true);
								} else {
									alert("Ups, ada kekurangan dalam inputan!");
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert('Error adding data, hubungi admin');
								$('#btn_simpan_undang').text('Simpan');
								$('#btn_simpan_undang').attr('disabled', false);
							}
						});
					}

				}

				function excell_undang() {
					var nr_job = document.getElementById('no_reg_pekerjaan').value;
					var izinx = document.getElementById('tipe_grade').value;
					var bidangx = document.getElementById('id_sub_bidang_pekerjaan').value.replace(/\,/g, ' ');
					var pilihx = document.getElementById('pilih_grade').value;
					if (pilihx == '') {
						pilihx = 'x';
					}
					var nilai_oex = document.getElementById('nilai_oex').value;

					var hreF = '<?php echo base_url(); ?>index.php/kontrak/excell_undang/' + nr_job + '/' + izinx + '/' + bidangx + '/' + pilihx + '/' + nilai_oex + '/';
					window.open(hreF, '_blank');
				}

				function removeOptions(selectbox) {
					var i;
					for (i = selectbox.options.length - 1; i >= 0; i--) {
						selectbox.remove(i);
					}
				}

				function format_uang(uang) {
					if (uang == null) {
						var pitih = '';
					} else {
						var pitih = 'Rp. ' + parseFloat(uang).toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
					}
					return pitih;
				}

				function cari_anwizing(id_cari) {
					//removeAll_undang();
					$('.nav-tabs a[href="#tab_1_3"]').tab('show');
					$("#btn_simpan_anwizing").hide();

					if (id_cari == null) {
						var carix = document.getElementById('cari_id_anwizing').value;
					} else {
						$("#cari_data_anwizing").val(id_cari);
						var carix = id_cari;
					}
					removeAll_anwizing();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_anwizing/' + carix;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$("#no_reg_pekerjaan_anwizing").val(datas.no_reg_pekerjaan);
							$("#nama_pekerjaan_anwizing").val(datas.nama_pekerjaan);
							$("#lokasi_pekerjaan_anwizing").val(datas.lokasi);
							$("#jenis_pengadaan_anwizing").val(datas.jenis_pengadaan);
							$("#nilai_oe_anwizing").val(format_uang(datas.nilai_oe));
							$("#divisi_anwizing").val(datas.divisi);
							$("#durasi_anwizing").val(datas.durasi);
							$("#metode_pengadaan_anwizing").val(datas.metode_pengadaan);

							daftar_anwizing(datas.no_reg_pekerjaan);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function daftar_anwizing(carix) {
					//removeAll_undang();
					$("#btn_simpan_anwizing").show();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/daftar_anwizing/' + carix;
					var urut_anwizing = 0;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								urut_anwizing = urut_anwizing + 1;
								var tabel = "tabel_anwizing";
								var kolom_1 = "<td>" + urut_anwizing + "</td>";
								var kolom_2 = "<td>" + obj.id_vd + "</td>";
								var kolom_3 = "<td>" + obj.nama_pt + "</td>";
								var kolom_4 = "<td> <input type='checkbox' class='anwizing_chk' value = '" + obj.id_vd + "' id = 'anwizing_chk_" + urut_anwizing + "'/> Hadir</td>";
								addElement(tabel, urut_anwizing, kolom_1, kolom_2, kolom_3, kolom_4);
							});
							$('#last_anwizing').val(urut_anwizing);


						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function removeAll_anwizing() {
					var tabel = "tabel_anwizing";
					var urut = document.getElementById("last_anwizing").value;
					urut_anwizing = 0;
					for (var i = 1; i <= urut; i++) {
						$('table#' + tabel + ' tr#' + i + '').remove();
					}
				}

				function simpan_anwizing() {
					$('#btn_simpan_anwizing').text('Proses simpan');
					$('#btn_simpan_anwizing').attr('disabled', true);
					var i = 0;
					var hasil = [];
					$('.anwizing_chk:checked').each(function(i) {
						hasil[i] = $(this).val();
						i++;
					});
					$("#anwizing_checkbox").val(hasil);

					var urut = document.getElementById("anwizing_checkbox").value;
					if (urut == '' || urut == 0 || urut == null) {
						alert('harus dicentang / diberikan nilai vendor');
						$('#btn_simpan_anwizing').text('Simpan');
						$('#btn_simpan_anwizing').attr('disabled', false);
					} else {
						var id_noreg = document.getElementById('no_reg_pekerjaan_anwizing').value;
						var hasil_anwizing = document.getElementById('anwizing_checkbox').value.replace(/\,/g, ' ');

						var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/add_anwizing/' + id_noreg + '/' + hasil_anwizing;
						$.ajax({
							url: baseUrl,
							dataType: 'json',
							success: function(datas) {
								//excell_anwizing(id_noreg,hasil_anwizing);
								alert('Sukses');
								location.reload();
								$('#btn_simpan_anwizing').text('Simpan');
								$('#btn_simpan_anwizing').attr('disabled', false);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert("Hubungi Administrator");
								$('#btn_simpan_anwizing').text('Simpan');
								$('#btn_simpan_anwizing').attr('disabled', false);
							}
						});
					}

				}

				function excell_anwizing(id_noreg, hasil_anwizing) {
					var hreF = '<?php echo base_url(); ?>index.php/kontrak/excell_anwizing/' + id_noreg + '/' + hasil_anwizing;
					window.open(hreF, '_blank');
				}

				function cari_penawaran(id_cari) {
					//removeAll_undang();
					$('.nav-tabs a[href="#tab_1_4"]').tab('show');
					$("#btn_simpan_penawaran").hide();

					if (id_cari == null) {
						var carix = document.getElementById('cari_id_penawaran').value;
					} else {
						$("#cari_data_penawaran").val(id_cari);
						var carix = id_cari;
					}
					removeAll_penawaran();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_penawaran/' + carix;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$("#no_reg_pekerjaan_penawaran").val(datas.no_reg_pekerjaan);
							$("#nama_pekerjaan_penawaran").val(datas.nama_pekerjaan);
							$("#lokasi_pekerjaan_penawaran").val(datas.lokasi);
							$("#jenis_pengadaan_penawaran").val(datas.jenis_pengadaan);
							$("#nilai_oe_penawaran").val(format_uang(datas.nilai_oe));
							$("#divisi_penawaran").val(datas.divisi);
							$("#durasi_penawaran").val(datas.durasi);
							$("#metode_pengadaan_penawaran").val(datas.metode_pengadaan);

							daftar_penawaran(datas.no_reg_pekerjaan);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function daftar_penawaran(carix) {
					//removeAll_undang();
					$("#btn_simpan_penawaran").show();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/daftar_penawaran/' + carix;
					var urut_penawaran = 0;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								urut_penawaran = urut_penawaran + 1;
								var tabel = "tabel_penawaran";
								var kolom_1 = "<td>" + urut_penawaran + "</td>";
								var kolom_2 = "<td>" + obj.id_vd + "</td>";
								var kolom_3 = "<td>" + obj.nama_pt + "</td>";
								var kolom_4 = "<td> <input type='checkbox' class='penawaran_chk' value = '" + obj.id_vd + "' id = 'penawaran_chk_" + urut_penawaran + "'/> Hadir</td>";
								addElement(tabel, urut_penawaran, kolom_1, kolom_2, kolom_3, kolom_4);
							});
							$('#last_penawaran').val(urut_penawaran);

						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function removeAll_penawaran() {
					var tabel = "tabel_penawaran";
					var urut = document.getElementById("last_penawaran").value;
					urut_penawaran = 0;
					for (var i = 1; i <= urut; i++) {
						$('table#' + tabel + ' tr#' + i + '').remove();
					}
				}

				function simpan_penawaran() {
					$('#btn_simpan_penawaran').text('Proses simpan');
					$('#btn_simpan_penawaran').attr('disabled', true);
					var i = 0;
					var hasil = [];
					$('.penawaran_chk:checked').each(function(i) {
						hasil[i] = $(this).val();
						i++;
					});
					$("#penawaran_checkbox").val(hasil);

					var urut = document.getElementById("penawaran_checkbox").value;
					if (urut == '' || urut == 0 || urut == null) {
						alert('harus dicentang / diberikan nilai vendor');
						$('#btn_simpan_penawaran').text('Simpan');
						$('#btn_simpan_penawaran').attr('disabled', false);
					} else {
						var id_noreg = document.getElementById('no_reg_pekerjaan_penawaran').value;
						var hasil_penawaran = document.getElementById('penawaran_checkbox').value.replace(/\,/g, ' ');

						var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/add_penawaran/' + id_noreg + '/' + hasil_penawaran;
						$.ajax({
							url: baseUrl,
							dataType: 'json',
							success: function(datas) {
								//excell_penawaran(id_noreg,hasil_penawaran);
								alert('Sukses');
								location.reload();
								$('#btn_simpan_penawaran').text('Simpan');
								$('#btn_simpan_penawaran').attr('disabled', false);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert("Hubungi Administrator");
								$('#btn_simpan_penawaran').text('Simpan');
								$('#btn_simpan_penawaran').attr('disabled', false);
							}
						});
					}

				}

				function excell_penawaran(id_noreg, hasil_penawaran) {
					var hreF = '<?php echo base_url(); ?>index.php/kontrak/excell_penawaran/' + id_noreg + '/' + hasil_penawaran;
					window.open(hreF, '_blank');
				}

				function cari_penetapan(id_cari) {
					//removeAll_undang();
					$('.nav-tabs a[href="#tab_1_5"]').tab('show');
					$("#btn_simpan_penetapan").hide();

					if (id_cari == null) {
						var carix = document.getElementById('cari_id_penetapan').value;
					} else {
						$("#cari_data_penetapan").val(id_cari);
						var carix = id_cari;
					}
					removeAll_penetapan();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_penetapan/' + carix;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$("#no_reg_pekerjaan_penetapan").val(datas.no_reg_pekerjaan);
							$("#nama_pekerjaan_penetapan").val(datas.nama_pekerjaan);
							$("#lokasi_pekerjaan_penetapan").val(datas.lokasi);
							$("#jenis_pengadaan_penetapan").val(datas.jenis_pengadaan);
							$("#nilai_oe_penetapan").val(format_uang(datas.nilai_oe));
							$("#divisi_penetapan").val(datas.divisi);
							$("#durasi_penetapan").val(datas.durasi);
							$("#metode_pengadaan_penetapan").val(datas.metode_pengadaan);

							daftar_penetapan(datas.no_reg_pekerjaan);
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function daftar_penetapan(carix) {
					//removeAll_undang();
					$("#btn_simpan_penetapan").show();
					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/daftar_penetapan/' + carix;
					var urut_penetapan = 0;
					removeOptions(document.getElementById("vendor_pemenang"));
					var vendor_pemenang = ["-Pilih-"];
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$.map(datas, function(obj) {
								urut_penetapan = urut_penetapan + 1;
								var tabel = "tabel_penetapan";
								var kolom_1 = "<td>" + urut_penetapan + "</td>";
								var kolom_2 = "<td>" + obj.id_vd + "</td>";
								var kolom_3 = "<td>" + obj.nama_pt + "</td>";
								var kolom_4 = "<td> <input type='checkbox' class='penetapan_chk' value = '" + obj.id_vd + "' id = 'penetapan_chk_" + urut_penetapan + "'/> Hadir</td>";
								addElement(tabel, urut_penetapan, kolom_1, kolom_2, kolom_3, kolom_4);

								vendor_pemenang.push({
									'id': obj.id_vd,
									'text': obj.nama_pt,
								});

								return vendor_pemenang;
							});
							$('#last_penetapan').val(urut_penetapan);
							$("#vendor_pemenang").select2({
								allowClear: true,
								placeholder: "Pilih",
								data: vendor_pemenang,
								width: '100%'
							});

						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function removeAll_penetapan() {
					var tabel = "tabel_penetapan";
					var urut = document.getElementById("last_penetapan").value;
					urut_penetapan = 0;
					for (var i = 1; i <= urut; i++) {
						$('table#' + tabel + ' tr#' + i + '').remove();
					}
				}

				function simpan_penetapan() {
					$('#btn_simpan_penetapan').text('Proses simpan');
					$('#btn_simpan_penetapan').attr('disabled', true);
					var i = 0;
					var hasil = [];
					$('.penetapan_chk:checked').each(function(i) {
						hasil[i] = $(this).val();
						i++;
					});
					$("#penetapan_checkbox").val(hasil);

					var urut = document.getElementById("penetapan_checkbox").value;
					if (urut == '' || urut == 0 || urut == null) {
						alert('harus dicentang / diberikan nilai vendor');
						$('#btn_simpan_penetapan').text('Simpan');
						$('#btn_simpan_penetapan').attr('disabled', false);
					} else {
						var id_noreg = document.getElementById('no_reg_pekerjaan_penetapan').value;
						var hasil_penetapan = document.getElementById('penetapan_checkbox').value.replace(/\,/g, ' ');
						var winner = document.getElementById('vendor_pemenang').value;
						var valuer = document.getElementById('nilai_penawaran').value.replace(/\,/g, '');;

						var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/add_penetapan/' + id_noreg + '/' + hasil_penetapan + '/' + winner + '/' + valuer;
						$.ajax({
							url: baseUrl,
							dataType: 'json',
							success: function(datas) {
								//excell_penetapan(id_noreg,hasil_penetapan);
								alert('Sukses');
								location.reload();
								$('#btn_simpan_penetapan').text('Simpan');
								$('#btn_simpan_penetapan').attr('disabled', false);
							},
							error: function(xhr, ajaxOptions, thrownError) {
								alert("Hubungi Administrator");
								$('#btn_simpan_penetapan').text('Simpan');
								$('#btn_simpan_penetapan').attr('disabled', false);
							}
						});
					}

				}

				function excell_penetapan(id_noreg, hasil_penetapan) {
					var hreF = '<?php echo base_url(); ?>index.php/kontrak/excell_penetapan/' + id_noreg + '/' + hasil_penetapan;
					window.open(hreF, '_blank');
				}

				function cari_final(id_cari) {
					//removeAll_undang();
					$('.nav-tabs a[href="#tab_1_6"]').tab('show');
					$("#btn_simpan_final").show();

					if (id_cari == null) {
						var carix = document.getElementById('cari_id_final').value;
					} else {
						$("#cari_data_final").val(id_cari);
						var carix = id_cari;
					}

					var baseUrl = '<?php echo base_url(); ?>index.php/kontrak/cari_final/' + carix;
					$.ajax({
						url: baseUrl,
						dataType: 'json',
						success: function(datas) {
							$("#no_reg_pekerjaan_final").val(datas.no_reg_pekerjaan);
							$("#nama_pekerjaan_final").val(datas.nama_pekerjaan);
							$("#lokasi_pekerjaan_final").val(datas.lokasi);
							$("#jenis_pengadaan_final").val(datas.jenis_pengadaan);
							$("#nilai_oe_final").val(format_uang(datas.nilai_oe));
							$("#divisi_final").val(datas.divisi);
							$("#durasi_final").val(datas.durasi);
							$("#metode_pengadaan_final").val(datas.metode_pengadaan);
							$("#vendor_pemenang_final").val(datas.vendor_pemenang);
							$("#nilai_penawaran_final").val(format_uang(datas.nilai_penawaran));

						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert("Hubungi Administrator");
						}
					});
				}

				function simpan_final() {
					$('#btn_simpan_final').text('Sedang proses simpan...');
					$('#btn_simpan_final').attr('disabled', true);

					var urut = document.getElementById("no_kontrak_final").value;
					if (urut == '' || urut == 0 || urut == null) {
						alert('harus isi data');
						$('#btn_simpan_final').text('Simpan');
						$('#btn_simpan_final').attr('disabled', false);
					} else {
						var url = "<?php echo site_url('kontrak/add_final') ?>";
						var formData = new FormData($('#form_final')[0]);
						$.ajax({
							url: url,
							type: "POST",
							data: formData,
							contentType: false,
							processData: false,
							dataType: "JSON",
							success: function(data) {
								if (data.status) {
									alert("sukses");
									location.reload();

									$('#btn_simpan_final').text('Simpan');
									$('#btn_simpan_final').attr('disabled', false);
								} else {
									alert("Ups, ada kekurangan dalam inputan!");
								}
							},
							error: function(jqXHR, textStatus, errorThrown) {
								alert('Error adding data, hubungi admin');
								$('#btn_simpan_final').text('Simpan');
								$('#btn_simpan_final').attr('disabled', false);
							}
						});
					}
				}
			</script>
			</body>

			</html>