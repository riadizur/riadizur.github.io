<div class="page-head">
	<div class="page-title">
		<h1>Monitoring <small>Informasi Neraca</small></h1>
	</div>
	<div class="page-toolbar">
		<div class="btn-group btn-theme-panel">
		</div>
	</div>
</div>
<div class="col-md-12">
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="form-group">
				<label class="col-md-3 control-label">Pilih Tahun</label>
				<div class="col-md-9">
					<select class="form-control" id='xtahun' name='xtahun'>
					<?php
						foreach ($get_tahun as $r )
						{
							echo "<option value='".$r->tahun."'>".$r->tahun."</option>";
						}
					?>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row ">
	<div class="col-md-12">
		<div class="portlet box green">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-gift"></i>Monitoring
				</div>
			</div>
			<div class="portlet-body">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_1_1" data-toggle="tab">
						Pendapatan</a>
					</li>
					<li>
						<a href="#tab_1_2" data-toggle="tab">
						Beban Biaya</a>
					</li>
					<li>
						<a href="#tab_1_3" data-toggle="tab">
						Laba Rugi</a>
					</li>
					<li>
						<a href="#tab_1_4" data-toggle="tab">
						BOPO</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade active in" id="tab_1_1">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik Pendapatan Usaha</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_p" class="chart">
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Pendapatan Usaha (Bulanan) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."pr' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_p_r[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Pendapatan Usaha (Komulatif) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."pt' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_p_t[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik Pendapatan Luar Usaha</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_plu" class="chart">
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Pendapatan Luar Usaha (Bulanan) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."plur' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_plu_r[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Pendapatan Luar Usaha (Komulatif) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."plut' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_plu_t[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab_1_2">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik Beban Usaha</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_b" class="chart">
								</div>
							</div>
						</div>

						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Realisasi Beban Usaha (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_2_1" data-toggle="tab">
										Rekap beban Usaha</a>
									</li>
									<li>
										<a href="#tab_2_2" data-toggle="tab">
										Detil beban Usaha</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="tab_2_1">
										<div class="panel panel-default">
											<div class="panel-body">
												<?php
												foreach ($get_tahun as $r )
												{
													$thn = $r->tahun;
													echo "<div id='".$thn."br' name='get_neraca' style='display: none;' >";

													$template = array(
															'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

															'thead_open'            => '<thead>',
															'thead_close'           => '</thead>',

															'heading_row_start'     => '<tr>',
															'heading_row_end'       => '</tr>',
															'heading_cell_start'    => '<th>',
															'heading_cell_end'      => '</th>',

															'tbody_open'            => '<tbody>',
															'tbody_close'           => '</tbody>',

															'row_start'             => '<tr>',
															'row_end'               => '</tr>',
															'cell_start'            => '<td>',
															'cell_end'              => '</td>',

															'row_alt_start'         => '<tr>',
															'row_alt_end'           => '</tr>',
															'cell_alt_start'        => '<td>',
															'cell_alt_end'          => '</td>',

															'table_close'           => '</table></div>'
													);
													$this->table->set_template($template);
													$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
													$this->table->set_heading($header);
													echo $this->table->generate($get_neraca_b_r[$thn]);
													$this->table->clear();

													echo "</div>";
												}
												?>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_2_2">
										<div class="panel panel-default">
											<div class="panel-body">
												<?php
												foreach ($get_tahun as $r )
												{
													$thn = $r->tahun;
													echo "<div id='".$thn."brd' name='get_neraca' style='display: none;' >";

													$template = array(
															'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

															'thead_open'            => '<thead>',
															'thead_close'           => '</thead>',

															'heading_row_start'     => '<tr>',
															'heading_row_end'       => '</tr>',
															'heading_cell_start'    => '<th>',
															'heading_cell_end'      => '</th>',

															'tbody_open'            => '<tbody>',
															'tbody_close'           => '</tbody>',

															'row_start'             => '<tr>',
															'row_end'               => '</tr>',
															'cell_start'            => '<td>',
															'cell_end'              => '</td>',

															'row_alt_start'         => '<tr>',
															'row_alt_end'           => '</tr>',
															'cell_alt_start'        => '<td>',
															'cell_alt_end'          => '</td>',

															'table_close'           => '</table></div>'
													);
													$this->table->set_template($template);
													$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
													$this->table->set_heading($header);
													echo $this->table->generate($get_neraca_b_detil_r[$thn]);
													$this->table->clear();

													echo "</div>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Target Beban Usaha (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<ul class="nav nav-tabs">
									<li class="active">
										<a href="#tab_2_3" data-toggle="tab">
										Rekap beban Usaha</a>
									</li>
									<li>
										<a href="#tab_2_4" data-toggle="tab">
										Detil beban Usaha</a>
									</li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="tab_2_3">
										<div class="panel panel-default">
											<div class="panel-body">
												<?php
												foreach ($get_tahun as $r )
												{
													$thn = $r->tahun;
													echo "<div id='".$thn."bt' name='get_neraca' style='display: none;' >";

													$template = array(
															'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

															'thead_open'            => '<thead>',
															'thead_close'           => '</thead>',

															'heading_row_start'     => '<tr>',
															'heading_row_end'       => '</tr>',
															'heading_cell_start'    => '<th>',
															'heading_cell_end'      => '</th>',

															'tbody_open'            => '<tbody>',
															'tbody_close'           => '</tbody>',

															'row_start'             => '<tr>',
															'row_end'               => '</tr>',
															'cell_start'            => '<td>',
															'cell_end'              => '</td>',

															'row_alt_start'         => '<tr>',
															'row_alt_end'           => '</tr>',
															'cell_alt_start'        => '<td>',
															'cell_alt_end'          => '</td>',

															'table_close'           => '</table></div>'
													);
													$this->table->set_template($template);
													$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
													$this->table->set_heading($header);
													echo $this->table->generate($get_neraca_b_t[$thn]);
													$this->table->clear();

													echo "</div>";
												}
												?>
											</div>
										</div>
									</div>
									<div class="tab-pane fade" id="tab_2_4">
										<div class="panel panel-default">
											<div class="panel-body">
												<?php
												foreach ($get_tahun as $r )
												{
													$thn = $r->tahun;
													echo "<div id='".$thn."btd' name='get_neraca' style='display: none;' >";

													$template = array(
															'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

															'thead_open'            => '<thead>',
															'thead_close'           => '</thead>',

															'heading_row_start'     => '<tr>',
															'heading_row_end'       => '</tr>',
															'heading_cell_start'    => '<th>',
															'heading_cell_end'      => '</th>',

															'tbody_open'            => '<tbody>',
															'tbody_close'           => '</tbody>',

															'row_start'             => '<tr>',
															'row_end'               => '</tr>',
															'cell_start'            => '<td>',
															'cell_end'              => '</td>',

															'row_alt_start'         => '<tr>',
															'row_alt_end'           => '</tr>',
															'cell_alt_start'        => '<td>',
															'cell_alt_end'          => '</td>',

															'table_close'           => '</table></div>'
													);
													$this->table->set_template($template);
													$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
													$this->table->set_heading($header);
													echo $this->table->generate($get_neraca_b_detil_t[$thn]);
													$this->table->clear();

													echo "</div>";
												}
												?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik Beban Luar Usaha</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_blu" class="chart">
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Beban Luar Usaha (Bulanan) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."blur' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_blu_r[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Beban Luar Usaha (komulatif) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."blut' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_blu_t[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab_1_3">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik Laba Rugi</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_lr" class="chart">
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Laba Rugi (Bulanan) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."lru' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_lr_u[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel Laba Rugi (Komulatif) (Miliar)</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."lrlu' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_lr_lu[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
						</div>
					</div>

					<div class="tab-pane fade" id="tab_1_4">
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Grafik BOPO</span>
								</div>
							</div>
							<div class="panel-body">
								<div id="chart_bopo" class="chart">
								</div>
							</div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">
								<div class="caption">
									<i class="fa fa-globe"></i>
									<span class="caption-subject font-green-sharp bold">Tabel BOPO</span>
								</div>
							</div>
							<div class="panel-body">
								<?php
								foreach ($get_tahun as $r )
								{
									$thn = $r->tahun;
									echo "<div id='".$thn."bopo' name='get_neraca' style='display: none;' >";

									$template = array(
											'table_open'            => '<div style="overflow-x:auto;"><table border="1" cellpadding="4" cellspacing="0" class="table table-striped table-bordered table-hover" >',

											'thead_open'            => '<thead>',
											'thead_close'           => '</thead>',

											'heading_row_start'     => '<tr>',
											'heading_row_end'       => '</tr>',
											'heading_cell_start'    => '<th>',
											'heading_cell_end'      => '</th>',

											'tbody_open'            => '<tbody>',
											'tbody_close'           => '</tbody>',

											'row_start'             => '<tr>',
											'row_end'               => '</tr>',
											'cell_start'            => '<td>',
											'cell_end'              => '</td>',

											'row_alt_start'         => '<tr>',
											'row_alt_end'           => '</tr>',
											'cell_alt_start'        => '<td>',
											'cell_alt_end'          => '</td>',

											'table_close'           => '</table></div>'
									);
									$this->table->set_template($template);
									$header = array('TAHUN', 'URAIAN', 'JAN', 'FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES');
									$this->table->set_heading($header);
									echo $this->table->generate($get_neraca_bopo[$thn]);
									$this->table->clear();

									echo "</div>";
								}
								?>
							</div>
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

<script src="../../assets/global/plugins/flot/jquery.flot.min.js"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.resize.min.js"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.stack.min.js"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.crosshair.min.js"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.time.js" type="text/javascript"></script>
<script src="../../assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="../../assets/global/scripts/metronic.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/layout.js" type="text/javascript"></script>
<script src="../../assets/admin/layout4/scripts/demo.js" type="text/javascript"></script>
<!-- TAMBHAN -->
<script src="../../assets/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../assets/datatables/js/dataTables.bootstrap.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/pages/scripts/charts-flotcharts.js"></script>
<script type="text/javascript">
jQuery(document).ready(function() {
Metronic.init();
Layout.init();
Demo.init();
});

$(document).ready(function() {
	var previousPoint = 0;
	var thn = <?php echo '"'.$get_tahun_last.'"'; ?>;
	var jns = '';
	var targetp = [];
	var realisasip = [];
	var komulatiftargetp = [];
	var komulatifrealp = [];

	$("#xtahun").val(thn);
	neraca_p(thn);
	neraca_plu(thn);
	neraca_b(thn);
	neraca_blu(thn);
	neraca_lr(thn);
	neraca_bopo(thn);

	$('#xtahun').on("change",function()
	{
		thn = $(this).val();
		$('[name="get_neraca"]').hide();

		neraca_p(thn);
		neraca_plu(thn);
		neraca_b(thn);
		neraca_blu(thn);
		neraca_lr(thn);
		neraca_bopo(thn);
	});

	function hasil_neraca(jns,thn)
	{
	//return targetp = [["01",7454094412],["02",7454094412],["03",7454094412],["04",7454094412],["05",7454094412],["06",7454094412],["07",9654167435],["08",9654167435],["09",9654167435],["10",9654167435],["11",11678567435],["12",11678567435],];
		switch (jns)
		{
			//pendapatan usaha
			case "tpb":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->target_p_usaha_b.'],';
									}
								}
							echo '];
								break;
								';
						}
					?>
				}
				break;
			case "rpb":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->real_p_usaha_b.'],';
									}
								}
							echo '];
								break;
								';
								}
							?>
						}
						break;
			case "tpk":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->target_p_usaha_k.'],';
									}
								}
							echo '];
								break;
								';
						}
					?>
				}
				break;
			case "rpk":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->real_p_usaha_k.'],';
									}
								}
							echo '];
								break;
								';
						}
					?>
				}
				break;
			//pendapatan luar usaha
			case "tplub":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->target_p_luar_usaha_b.'],';
									}
								}
							echo '];
								break;
								';
						}
					?>
				}
				break;
			case "rplub":
				switch(thn) {
					<?php
						foreach ($grafik_n_p_0 as $r)
						{
							echo 'case "'.$r->tahun.'":
									return datax = [';
								foreach ($grafik_n_p_1 as $r1)
								{
									if($r->tahun == $r1->thn )
									{
										echo '["'.$r1->bln.'",'.$r1->real_p_luar_usaha_b.'],';
									}
								}
							echo '];
								break;
								';
						}
					?>
				}
				break;
				case "tpluk":
					switch(thn) {
						<?php
							foreach ($grafik_n_p_0 as $r)
							{
								echo 'case "'.$r->tahun.'":
										return datax = [';
									foreach ($grafik_n_p_1 as $r1)
									{
										if($r->tahun == $r1->thn )
										{
											echo '["'.$r1->bln.'",'.$r1->target_p_luar_usaha_k.'],';
										}
									}
								echo '];
									break;
									';
							}
						?>
					}
					break;
				case "rpluk":
					switch(thn) {
						<?php
							foreach ($grafik_n_p_0 as $r)
							{
								echo 'case "'.$r->tahun.'":
										return datax = [';
									foreach ($grafik_n_p_1 as $r1)
									{
										if($r->tahun == $r1->thn )
										{
											echo '["'.$r1->bln.'",'.$r1->real_p_luar_usaha_k.'],';
										}
									}
								echo '];
									break;
									';
							}
						?>
					}
					break;
					//beban usaha
					case "tbb":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->target_b_usaha_b.'],';
											}
										}
									echo '];
										break;
										';
								}
							?>
						}
						break;
					case "rbb":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->real_b_usaha_b.'],';
											}
										}
									echo '];
										break;
										';
										}
									?>
								}
								break;
					case "tbk":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->target_b_usaha_k.'],';
											}
										}
									echo '];
										break;
										';
								}
							?>
						}
						break;
					case "rbk":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->real_b_usaha_k.'],';
											}
										}
									echo '];
										break;
										';
								}
							?>
						}
						break;
					//beban luar usaha
					case "tblub":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->target_b_luar_usaha_b.'],';
											}
										}
									echo '];
										break;
										';
								}
							?>
						}
						break;
					case "rblub":
						switch(thn) {
							<?php
								foreach ($grafik_n_b_0 as $r)
								{
									echo 'case "'.$r->tahun.'":
											return datax = [';
										foreach ($grafik_n_b_1 as $r1)
										{
											if($r->tahun == $r1->thn )
											{
												echo '["'.$r1->bln.'",'.$r1->real_b_luar_usaha_b.'],';
											}
										}
									echo '];
										break;
										';
								}
							?>
						}
						break;
						case "tbluk":
							switch(thn) {
								<?php
									foreach ($grafik_n_b_0 as $r)
									{
										echo 'case "'.$r->tahun.'":
												return datax = [';
											foreach ($grafik_n_b_1 as $r1)
											{
												if($r->tahun == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->target_b_luar_usaha_k.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						case "rbluk":
							switch(thn) {
								<?php
									foreach ($grafik_n_b_0 as $r)
									{
										echo 'case "'.$r->tahun.'":
												return datax = [';
											foreach ($grafik_n_b_1 as $r1)
											{
												if($r->tahun == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->real_b_luar_usaha_k.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						//laba rugi
						case "tlrb":
							switch(thn) {
								<?php
									foreach ($grafik_n_lr_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_lr_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->target_lr_b.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						case "rlrb":
							switch(thn) {
								<?php
									foreach ($grafik_n_lr_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_lr_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->real_lr_b.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						case "tlrk":
							switch(thn) {
								<?php
									foreach ($grafik_n_lr_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_lr_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->target_lr_k.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						case "rlrk":
							switch(thn) {
								<?php
									foreach ($grafik_n_lr_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_lr_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->real_lr_k.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						//bopo
						case "tbopo":
							switch(thn) {
								<?php
									foreach ($grafik_n_bopo_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_bopo_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->target_bopo_b.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
						case "rbopo":
							switch(thn) {
								<?php
									foreach ($grafik_n_bopo_0 as $r)
									{
										echo 'case "'.$r->thn.'":
												return datax = [';
											foreach ($grafik_n_bopo_1 as $r1)
											{
												if($r->thn == $r1->thn )
												{
													echo '["'.$r1->bln.'",'.$r1->real_bopo_b.'],';
												}
											}
										echo '];
											break;
											';
									}
								?>
							}
							break;
		}
	}

	function neraca_p(thn)
	{
		$("#"+thn+"pr").show();
		$("#"+thn+"pt").show();
		$("#"+thn+"plur").show();
		$("#"+thn+"plut").show();

		if ($('#chart_p').size() != 1) {
		return;
		}

	var dataset_p = [
		{

		data: hasil_neraca('tpb',thn),
		label: "Target Pendapatan Usaha Bulanan",
		lines: { lineWidth: 1, },
		shadowSize: 0
		},
		{
		data: hasil_neraca('rpb',thn),
		label: "Realisasi Pendapatan Usaha Bulanan",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('tpk',thn),
		label: "Target Pendapatan Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('rpk',thn),
		label: "Realisasi Pendapatan Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		}
	];

	var option_p = {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true,
				radius: 3,
				lineWidth: 1
			},
			shadowSize: 2
		},
		grid: {
			hoverable: true,
			clickable: true,
			tickColor: "#eee",
			borderColor: "#eee",
			borderWidth: 1
		},
		colors: ["#d12610", "#37b7f3", "#52e136"],
		xaxis: {
			mode: "categories",
			tickLength: 0,
		},
		yaxis: {
			ticks: 11,
			tickDecimals: 0,
			tickColor: "#eee",
		}
	};

	plotp = $.plot($("#chart_p"), dataset_p, option_p);

	function showTooltipp(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 15,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
		}

		$("#chart_p").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				showTooltipp(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y + " Miliar");
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
		});

	}

	function neraca_plu(thn)
	{
		if ($('#chart_plu').size() != 1) {
		return;
		}

		var dataset_p = [
		{
			data: hasil_neraca('tplub',thn),
			label: "Target Pendapatan Luar Usaha Bulanan",
			lines: { lineWidth: 1, },
			shadowSize: 0
			},
			{
			data: hasil_neraca('rplub',thn),
			label: "Realisasi Pendapatan Luar Usaha Bulanan",
			lines: {
				lineWidth: 1,
			},
			shadowSize: 0
			},
			{
			data: hasil_neraca('tpluk',thn),
			label: "Target Pendapatan Luar Usaha Komulatif",
			lines: {
				lineWidth: 1,
			},
			shadowSize: 0
			},
			{
			data: hasil_neraca('rpluk',thn),
			label: "Realisasi Pendapatan Luar Usaha Komulatif",
			lines: {
				lineWidth: 1,
			},
			shadowSize: 0
			}
		];

		var option_p = {
			series: {
				lines: {
					show: true,
					lineWidth: 2,
					fill: true,
					fillColor: {
						colors: [{
							opacity: 0.05
						}, {
							opacity: 0.01
						}]
					}
				},
				points: {
					show: true,
					radius: 3,
					lineWidth: 1
				},
				shadowSize: 2
			},
			grid: {
				hoverable: true,
				clickable: true,
				tickColor: "#eee",
				borderColor: "#eee",
				borderWidth: 1
			},
			colors: ["#d12610", "#37b7f3", "#52e136"],
			xaxis: {
				mode: "categories",
				tickLength: 0,
			},
			yaxis: {
				ticks: 11,
				tickDecimals: 0,
				tickColor: "#eee",
			}
		};

		plotp = $.plot($("#chart_plu"), dataset_p, option_p);

		function showTooltipplu(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
		  position: 'absolute',
		  display: 'none',
		  top: y + 5,
		  left: x + 15,
		  border: '1px solid #333',
		  padding: '4px',
		  color: '#fff',
		  'border-radius': '3px',
		  'background-color': '#333',
		  opacity: 0.80
		}).appendTo("body").fadeIn(200);
		}

		$("#chart_plu").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
		  if (previousPoint != item.dataIndex) {
		    previousPoint = item.dataIndex;

		    $("#tooltip").remove();
		    var x = item.datapoint[0].toFixed(2),
		      y = item.datapoint[1].toFixed(2);

		    showTooltipplu(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y + " Miliar");
		  }
		} else {
		  $("#tooltip").remove();
		  previousPoint = null;
		}
		});
	}

	function neraca_b(thn)
	{
		$("#"+thn+"br").show();
		$("#"+thn+"brd").show();
		$("#"+thn+"bt").show();
		$("#"+thn+"btd").show();
		$("#"+thn+"blur").show();
		$("#"+thn+"blut").show();

		if ($('#chart_b').size() != 1) {
		return;
		}

	var dataset = [
		{

		data: hasil_neraca('tbb',thn),
		label: "Target Beban Usaha Bulanan",
		lines: { lineWidth: 1, },
		shadowSize: 0
		},
		{
		data: hasil_neraca('rbb',thn),
		label: "Realisasi Beban Usaha Bulanan",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('tbk',thn),
		label: "Target Beban Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('rbk',thn),
		label: "Realisasi Beban Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		}
	];

	var option = {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true,
				radius: 3,
				lineWidth: 1
			},
			shadowSize: 2
		},
		grid: {
			hoverable: true,
			clickable: true,
			tickColor: "#eee",
			borderColor: "#eee",
			borderWidth: 1
		},
		colors: ["#d12610", "#37b7f3", "#52e136"],
		xaxis: {
			mode: "categories",
			tickLength: 0,
		},
		yaxis: {
			ticks: 11,
			tickDecimals: 0,
			tickColor: "#eee",
		}
	};

	$.plot($("#chart_b"), dataset, option);

	function showTooltipb(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 15,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
		}

		$("#chart_b").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				showTooltipb(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y + " Miliar");
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
		});

	}

	function neraca_blu(thn)
	{
		if ($('#chart_blu').size() != 1) {
		return;
		}

	var dataset = [
		{

		data: hasil_neraca('tblub',thn),
		label: "Target Beban Luar Usaha Bulanan",
		lines: { lineWidth: 1, },
		shadowSize: 0
		},
		{
		data: hasil_neraca('rblub',thn),
		label: "Realisasi Beban Luar Usaha Bulanan",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('tbluk',thn),
		label: "Target Beban Luar Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('rbluk',thn),
		label: "Realisasi Beban Luar Usaha Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		}
	];

	var option = {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true,
				radius: 3,
				lineWidth: 1
			},
			shadowSize: 2
		},
		grid: {
			hoverable: true,
			clickable: true,
			tickColor: "#eee",
			borderColor: "#eee",
			borderWidth: 1
		},
		colors: ["#d12610", "#37b7f3", "#52e136"],
		xaxis: {
			mode: "categories",
			tickLength: 0,
		},
		yaxis: {
			ticks: 11,
			tickDecimals: 0,
			tickColor: "#eee",
		}
	};

	$.plot($("#chart_blu"), dataset, option);

	function showTooltipblu(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 15,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
		}

		$("#chart_blu").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				showTooltipblu(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y + " Miliar");
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
		});

	}

	function neraca_lr(thn)
	{
		$("#"+thn+"lru").show();
		$("#"+thn+"lrlu").show();

		if ($('#chart_lr').size() != 1) {
		return;
		}

	var dataset = [
		{

		data: hasil_neraca('tlrb',thn),
		label: "Target Laba Rugi Bulanan",
		lines: { lineWidth: 1, },
		shadowSize: 0
		},
		{
		data: hasil_neraca('rlrb',thn),
		label: "Realisasi Laba Rugi Bulanan",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('tlrk',thn),
		label: "Target Laba Rugi Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		},
		{
		data: hasil_neraca('rlrk',thn),
		label: "Realisasi Laba Rugi Komulatif",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		}
	];

	var option = {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true,
				radius: 3,
				lineWidth: 1
			},
			shadowSize: 2
		},
		grid: {
			hoverable: true,
			clickable: true,
			tickColor: "#eee",
			borderColor: "#eee",
			borderWidth: 1
		},
		colors: ["#d12610", "#37b7f3", "#52e136"],
		xaxis: {
			mode: "categories",
			tickLength: 0,
		},
		yaxis: {
			ticks: 11,
			tickDecimals: 0,
			tickColor: "#eee",
		}
	};

	$.plot($("#chart_lr"), dataset, option);

	function showTooltiplr(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 15,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
		}

		$("#chart_lr").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				showTooltiplr(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y + " Miliar" );
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
		});

	}

	function neraca_bopo(thn)
	{
		$("#"+thn+"bopo").show();

		if ($('#chart_bopo').size() != 1) {
		return;
		}

	var dataset = [
		{
		data: hasil_neraca('tbopo',thn),
		label: "Target BOPO Bulanan",
		lines: { lineWidth: 1, },
		shadowSize: 0
		},
		{
		data: hasil_neraca('rbopo',thn),
		label: "Realisasi BOPO Bulanan",
		lines: {
			lineWidth: 1,
		},
		shadowSize: 0
		}
	];

	var option = {
		series: {
			lines: {
				show: true,
				lineWidth: 2,
				fill: true,
				fillColor: {
					colors: [{
						opacity: 0.05
					}, {
						opacity: 0.01
					}]
				}
			},
			points: {
				show: true,
				radius: 3,
				lineWidth: 1
			},
			shadowSize: 2
		},
		grid: {
			hoverable: true,
			clickable: true,
			tickColor: "#eee",
			borderColor: "#eee",
			borderWidth: 1
		},
		colors: ["#d12610", "#37b7f3", "#52e136"],
		xaxis: {
			mode: "categories",
			tickLength: 0,
		},
		yaxis: {
			ticks: 11,
			tickDecimals: 0,
			tickColor: "#eee",
		}
	};

	$.plot($("#chart_bopo"), dataset, option);

	function showTooltipbp(x, y, contents) {
		$('<div id="tooltip">' + contents + '</div>').css({
			position: 'absolute',
			display: 'none',
			top: y + 5,
			left: x + 15,
			border: '1px solid #333',
			padding: '4px',
			color: '#fff',
			'border-radius': '3px',
			'background-color': '#333',
			opacity: 0.80
		}).appendTo("body").fadeIn(200);
	}

		$("#chart_bopo").bind("plothover", function(event, pos, item) {
		$("#x").text(pos.x.toFixed(2));
		$("#y").text(pos.y.toFixed(2));

		if (item) {
			if (previousPoint != item.dataIndex) {
				previousPoint = item.dataIndex;

				$("#tooltip").remove();
				var x = item.datapoint[0].toFixed(2),
					y = item.datapoint[1].toFixed(2);

				showTooltipbp(item.pageX, item.pageY, item.series.label + " of " + x + " = " + y );
			}
		} else {
			$("#tooltip").remove();
			previousPoint = null;
		}
		});

	}


});

</script>
