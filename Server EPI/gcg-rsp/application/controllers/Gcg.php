<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gcg extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('gcgm');
		date_default_timezone_set('Asia/Jakarta');
	}
	public function cekData_tabel(){
		$tabel = $this->input->post('tabel');
		$where = $this->input->post('where'); 
		$kolom = $this->input->post('kolom');
		echo json_encode($this->gcgm->count($tabel,$where,$kolom));
	}
	public function dokumen() 
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$periode = $this->gcgm->last_gcg_master_periode();
			$datax['pertanyaan'] = $this->internal_pertanyaan($periode);
			$datax['kode_survey'] =  $this->gcgm->list_gcg_master();

			$this->load->view('gcg/dokumen', $datax);
			$this->load->view('footer');
		} else { 
			redirect('welcome/index');
		}
	}
	public function master_penetapan(){
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$datax['periode']=$this->gcgm->last_gcg_master_periode();
			// $kode_divisi = $this->session->userdata('kode_gcg'); 
			// $datax['divisi']=row_tabel('master_org_divisi',array('kode'=>$kode_divisi),'nama_divisi');
			$this->load->view('gcg/master_penetapan', $datax);
			$this->load->view('footer');
		}else{
			redirect('welcome/index');
		}
	}
	public function test(){
		$kode_pic = $this->session->userdata('divisi');
		if($kode_pic!='admin'){
			$user = $this->gcgm->result_kolom('gcg_master_fu','distinct(no_aspek)',array('pic'=>'DUT02'));
			$filter_aspek='';
			$filterx_aspek='';
			$x=0;
			foreach($user as $u){
				if($x==0){
					$filter_aspek = 'no_aspek='.$u->no_aspek.' or no_aspek';
				}else{
					if($x<sizeof($user)-1){
						$filterx_aspek .= $u->no_aspek.' or no_aspek=';
					}else{
						$filterx_aspek .= $u->no_aspek;
					}
				}
				$x++;
			}
			echo json_encode($filter_aspek.'='.$filterx_aspek);
			// echo 'test';
		}else{
		}
	}
	public function internal_pertanyaan($periode)
	{
		$hasil = '';
		#$ref = $this->gcgm->return_gcg_aspek_all();
		$kode_pic = $this->session->userdata('divisi');
		$kod_div ='DKS02';
		// $kod_div =$kode_pic;
		if($kode_pic!='admin'){
			$user = $this->gcgm->result_kolom('gcg_master_fu','distinct(no_aspek)',array('pic'=>$kod_div));
			$filter_aspek='';
			$filterx_aspek='';
			$x=0;
			foreach($user as $u){
				if($x==0){
					$filter_aspek = '(no_aspek';
					$filterx_aspek.= $u->no_aspek.' or no_aspek=';
				}else{
					if($x<sizeof($user)-1){
						$filterx_aspek .= $u->no_aspek.' or no_aspek=';
					}else{
						$filterx_aspek .= $u->no_aspek.')';
					}
				}
				$x++;
			}
			if($filter_aspek!=''){
				$filter_asp=$filter_aspek.'='.$filterx_aspek;
			}else{
				$filter_asp='';
			}
			echo json_encode($filter_asp);
			echo '<br>';
			// echo 'test';
		}else{
			$filter_aspek='';
			$filterx_aspek='';
		}
		$ref = result_tabel('gcg_master_aspek', array('periode' => $periode,$filter_asp));
		// echo json_encode($ref);
		// echo '<br>';
		foreach ($ref as $r) {
			$hasil .= '
				<div class="card shadow">
					<div class="card-header" id="heading_' . $r->no_aspek . '">
						<h5 class="mb-0">
							<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $r->no_aspek . '" aria-expanded="true" aria-controls="collapse_' . $r->no_aspek . '">
								<p align="justify"><i class="fas fa-clipboard-list text-warning"></i> ' . $r->no_aspek . '. ' . $r->aspek_pengujian_indikator . '</p> 
							</button>
						</h5>
					</div>
					<div id="collapse_' . $r->no_aspek . '" class="collapse" aria-labelledby="heading_' . $r->no_aspek . '" data-parent="#accordion">
						<div class="card-body">
					
							<div class="row">
								<div class="col-md-12">


									
			';
			#$ref_1 = $this->gcgm->return_gcg_indikator_no_aspek($r->no_aspek);
			if($kode_pic!='admin'){
				$user = $this->gcgm->result_kolom('gcg_master_fu','distinct(no_indikator) as no_indikator',array('pic'=>$kod_div,'no_aspek' => $r->no_aspek));
				// echo json_encode($user);
				// echo '<br>';
				$filter_indikator='';
				$filterx_indikator='';
				$x=0;
				foreach($user as $u){
					if($x==0){
						if(sizeof($user)>1){
							$filter_indikator = '(no_indikator';
							$filterx_indikator.= $u->no_indikator.' or no_indikator=';
						}else{
							$filter_indikator = 'no_indikator';
							$filterx_indikator =$u->no_indikator;
						}
					}else{
						if($x<sizeof($user)-1){
							$filterx_indikator .= $u->no_indikator.' or no_indikator=';
						}else{
							$filterx_indikator .= $u->no_indikator.')';
						}
					}
					$x++;
				}
				if($filter_indikator!=''){
					$filter_ind=$filter_indikator.'='.$filterx_indikator;
				}else{
					$filter_ind='';
				}
				// echo json_encode($filter_indikator.'='.$filterx_indikator);
				// echo '<br>';
			}else{
				$filter_indikator='';
				$filterx_indikator='';
			}
			if($filter_ind!=''){
				$ref_1 = result_tabel('gcg_master_indikator', array('periode' => $periode, 'no_aspek' => $r->no_aspek,$filter_ind));
			}else{
				$ref_1=array();
			}
			// echo json_encode($ref_1);
			// echo '<br>';
			foreach ($ref_1 as $s) {
				$hasil .= '
									<div class="row">
										<div class="col-md-12">
											<h6 class="card-title">' . $r->no_aspek . '.' . $s->no_indikator . '. ' . $s->aspek_pengujian_atau_indikator . '</h6>
										</div>
									</div>
									<div class="card mb-4">
										<div class="card-body">
				';

				#$ref_2 = $this->gcgm->return_gcg_parameter_no_indikator($s->no_indikator);
				if($kode_pic!='admin'){
					$user = $this->gcgm->result_kolom('gcg_master_fu','distinct(concat(no_aspek,\'.\',no_indikator,\'.\',no_parameter)) as no_parameter',array('pic'=>$kod_div));
					// echo json_encode($user);
					// echo '<br>';
					$filter_parameter='';
					$filterx_parameter='';
					$x=0;
					foreach($user as $u){
						if($x==0){
							$filter_parameter = '(no_parameter';
							$filterx_parameter.= $u->no_parameter.' or no_parameter=';
						}else{
							if($x<sizeof($user)-1){
								$filterx_parameter .= $u->no_parameter.' or no_parameter=';
							}else{
								$filterx_parameter .= $u->no_parameter.')';
							}
						}
						$x++;
					}
					// echo json_encode($filter_indikator.'='.$filterx_aspek);
					// echo 'test';
				}else{
					$filter_parameter='';
					$filterx_parameter='';
				}
				$ref_2 = result_tabel('gcg_master_parameter', array('periode' => $periode, 'no_indikator' => $s->no_indikator,$filter_parameter.'='.$filterx_parameter));
				// echo json_encode($ref_2);
				foreach ($ref_2 as $t) {
					$theading = $t->no_aspek . '_' . $t->no_indikator . '_' . $t->no_parameter;
					$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $theading . '">
									<h5 class="mb-0">
										<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $theading . '" aria-expanded="true" aria-controls="collapse_' . $theading . '">											
											<p align="justify"><i class="fas fa-pen-alt text-warning"></i> ' . $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '. ' . $t->aspek_pengujian_atau_indikator . '</p>
										</button>
									</h5>
								</div>
								<div id="collapse_' . $theading . '" class="collapse" aria-labelledby="heading_' . $theading . '" data-parent="#heading_' . $r->no_aspek . '">
									<div class="card-body">
								
										<div class="row">
											<div class="col-md-12">
					';
					#$ref_3 = $this->gcgm->return_gcg_fu_lv1_id_parameter($t->no_parameter);
					if($kode_pic!='admin'){
						$user = $this->gcgm->result_kolom('gcg_master_fu','distinct(concat(no_aspek,\'.\',no_indikator,\'.\',no_parameter)) as no_parameter',array('pic'=>$kod_div));
						// echo json_encode($user);
						// echo '<br>';
						$filter_lv_1='';
						$filterx_lv_1='';
						$x=0;
						foreach($user as $u){
							if($x==0){
								$filter_lv_1 = '(no_parameter';
								$filterx_lv_1.= $u->no_parameter.' or no_parameter=';
							}else{
								if($x<sizeof($user)-1){
									$filterx_lv_1 .= $u->no_parameter.' or no_parameter=';
								}else{
									$filterx_lv_1 .= $u->no_parameter.')';
								}
							}
							$x++;
						}
						// echo json_encode($filter_indikator.'='.$filterx_aspek);
						// echo 'test';
					}else{
						$filter_lv_1='';
						$filterx_lv_1='';
					}
					$ref_3 = result_tabel('gcg_fu_lv1', array('periode' => $periode, 'id_parameter' => $t->no_parameter));
					foreach ($ref_3 as $u) {
						if ($u->turunan_sfu == '1') {
							# penjelasan
							$get_fu = $u->id_fu;
							$hasil .= ' 
								<div class="card mb-4">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<h6 class="card-title">' . $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '. ' . $u->faktor_uji . '</h6>
											</div>
											<div class="col-md-12">
							';
							#$ref_4 = $this->gcgm->return_gcg_fu_lv2_id_fu($u->id_fu);
							$ref_4 = result_tabel('gcg_fu_lv2', array('periode' => $periode, 'id_fu' => $u->id_fu));
							// echo json_encode($ref_4);
							// echo '<br>';
							foreach ($ref_4 as $w) {
								# pertanyaan
								$get_fu = $r->no_aspek . '.' . $s->no_indikator . '.' . $w->id_sfu . '';
								$catatan = $w->catatan;
								$get_urut = $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '.' . $w->urut_sfu . '. ' . $w->uraian_sfu;

								$hasil .= $this->internal_detil($periode, $get_fu, $get_urut, $catatan);
								#$hasil .= '';
							}
							$hasil .= '
												
											</div>
										</div>
									</div>
								</div> 
							';
						} else {
							# pertanyaan
							$get_fu = $r->no_aspek . '.' . $s->no_indikator . '.' . $u->id_fu . '.0';
							$get_urut = $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '. ' . $u->faktor_uji;

							$hasil .= $this->internal_detil($periode, $get_fu, $get_urut, '');
							#$hasil .= '';
						}
					}

					$hasil .= '
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}
				$hasil .= '
										</div>
									</div>
				';
			}

			$hasil .= '									
								</div>
							</div>
							
						</div>
						
						
					</div>
				</div>
			';
			$hasil .= '';
		}

		return $hasil;
	}

	private function internal_detil($periode, $get_fu, $get_urut, $catatan)
	{
		$hasil = '';
		// $kode_divisi = $this->session->userdata('kode_gcg');
		$master_1 = $this->gcgm->result_gcg_master_periode_kode($periode, $get_fu);
		// var_dump($master_1[0]->pic);
		foreach ($master_1 as $v) {
			$fu_kode = $v->kode_fu;
			$fu_pertanyaan = $v->pertanyaan;
			$fu_kebutuhan = $v->kebutuhan;
			$fu_tipe_doc = $v->tipe_doc;
			$fu_doc_dibutuhkan_1 = $v->doc_dibutuhkan_1;
			$fu_doc_dibutuhkan_2 = $v->doc_dibutuhkan_2;
			$fu_pic = $v->pic;
			$fu_info_pilihan = $v->info_pilihan;
			$fu_perlu_doc = $v->perlu_doc;
			$fu_status_uji = $v->status_uji;
			$fu_catatan = $v->catatan;
		}

		$tahun = substr($periode, 0, 4);
		$nama_divisi = '';
		$list_divisi = $this->gcgm->result_v_gcg_divisi_tahun($tahun);
		foreach ($list_divisi as $a) {
			if ($a->kode == $fu_pic) {
				$nama_divisi .= $a->nama_divisi;
			} else {
				$nama_divisi .= '';
			}
		}

		$kode_modal = $periode . '&' . $fu_kode;

		$perlu = "";
		$form_unggah = "";
		if ($fu_perlu_doc == '1') {
			$perlu .= '
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">Nama Dokumen</label> 
						<div class="col-sm-8">
							<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kode  . '_doc_dibutuhkan_1" name="' . $fu_kode  . '_doc_dibutuhkan_1" rows="1" disabled >' . $fu_doc_dibutuhkan_1 . '</textarea>
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">PIC</label> 
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_pic" name="' . $fu_kode  . '_pic" value="' . $nama_divisi . '" disabled />
						</div>
					</div>
				';
			$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $fu_kode, 'Dokumen');
			$kode_tombol = str_replace('.', '_', $fu_kode);
			if ($jumlah_file > 0) {
				$durasi = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'durasi');
				$kelompok_doc = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'kelompok_doc');
				if ($durasi != '0') {
					$progres = $jumlah_file . ' dari ' . $durasi . ' ' . $kelompok_doc;
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Sudah ada ' . $progres . '" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen_' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				} else {
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Sudah ada" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen_' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				}
			} else { 
				$form_unggah .= '
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Belum ada" readonly />
							</div>
						</div>
					';
				
				$tombol_dokumen = '
					<div class="col-md-4" id="unggah_dokumen_' . $kode_tombol . '">
						<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
							<i class="fas fa-file-alt"></i> Unggah Dokumen
						</button>
					</div>
					<div class="col-md-4" style="display:none;" id="lihat_dokumen_' . $kode_tombol . '">
						<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
							<i class="fas fa-file-alt"></i> Lihat Dokumen
						</button>
					</div>
					<div class="col-md-4" style="display:none;" id="unggah_reviu_' . $kode_tombol . '">
						<button type="button" onclick="cek_reviu(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_reviu_' . $fu_kode . '" >
							<i class="fas fa-file-alt"></i> Unggah Reviu
						</button>
					</div>
				';
			}
		} else {
			$perlu = '
					<div class="form-group row">
						<label class="col-sm-4 col-form-label">PIC</label> 
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_pic" name="' . $fu_kode  . '_pic" value="' . $nama_divisi . '" disabled />
						</div>
					</div>
			';
			$tombol_dokumen = '';
		}

		if ($fu_kebutuhan == 'Dokumen') {
			$tipe_doc = substr($fu_tipe_doc, 0, 1);
			if ($tipe_doc == 'B') {
				$tombol_reviu = "";
			} else {
				$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $fu_kode, 'Dokumen');
				if ($jumlah_file > 0) {
					$tombol_reviu = '
					<div class="col-md-4" id="unggah_reviu_' . $kode_tombol . '">
						<button type="button" onclick="cek_reviu(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_reviu_' . $fu_kode . '" >
							<i class="fas fa-file-alt"></i> Unggah Reviu
						</button>
					</div>
					';
				} else {
					$tombol_reviu = "";
				}
			}
		} else {
			$tombol_reviu = "";
		}

		$ini_catatan = '';
		if (!empty($fu_catatan)) {
			$ini_catatan .= '
			<div class="col-md-12">
				<div class="alert alert-primary" role="alert">
					' . $fu_catatan . '
				</div> 
			</div>
			';
		} else {
			$ini_catatan .= '';
		}


		if (!empty($fu_kebutuhan)) {
			$fu_tipe_doc_detil = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'type_doc');
			if ($fu_kebutuhan == 'Dokumen') {
				$hasil .= '
					<div class="card mb-4">
						<div class="card-body">
							<form action="#" id="form_' . $fu_kode . '" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<h6 class="card-title">' . $get_urut . '</h6>
									</div>
									' . $ini_catatan . '
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Jenis Kebutuhan</label> 
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" value="' . $fu_kebutuhan . '" readonly />
											</div>
										</div>
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Jenis Dokumen</label>
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" value="' . $fu_tipe_doc_detil . '" readonly />
											</div>
										</div>
										' . $perlu . '
									</div>
									<div class="col-md-6">
									' . $form_unggah . '
										<div class="row justify-content-end">
											' . $tombol_dokumen . '
											' . $tombol_reviu . ' 
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				';
			} elseif ($fu_kebutuhan == 'Informasi') {
				$hasil .= '
					<div class="card mb-4">
						<div class="card-body">
							<form action="#" id="form_' . $fu_kode . '" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<h6 class="card-title">' . $get_urut . '</h6>
									</div>
									' . $ini_catatan . '
									<div class="col-md-6">
										<div class="form-group row">
											<label class="col-sm-4 col-form-label">Jenis Kebutuhan </label> 
											<div class="col-sm-8">
												<input type="text" class="form-control form-control-sm" value="' . $fu_kebutuhan . '" readonly />
											</div>
										</div>
										' . $perlu . '
									</div>
									<div class="col-md-6">
										' . $form_unggah . '
										<div class="row justify-content-end">
											' . $tombol_dokumen . '
											' . $tombol_reviu . ' 
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				';
			} elseif ($fu_kebutuhan == 'N/A') {
				$hasil .= '
					<div class="card mb-4">
						<div class="card-body">
							<form action="#" id="form_' . $fu_kode . '" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<h6 class="card-title">' . $get_urut . '</h6>
									</div>
									<div class="col-md-6">
										<div class="alert alert-warning" role="alert">
											Faktor Uji ini tidak diujikan
										</div> 
									</div>
								</div>
							</form>
						</div>
					</div>
				';
			}
		} else {
			$fu_tipe_doc_detil = '';
			$hasil .= '
				<div class="card mb-4">
					<div class="card-body">
						<form action="#" id="form_' . $fu_kode . '" enctype="multipart/form-data">
							<div class="row">
								<div class="col-md-12">
									<h6 class="card-title">' . $get_urut . '</h6>
								</div>
								' . $ini_catatan . '
								<div class="col-md-6">
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Jenis Kebutuhan </label> 
										<div class="col-sm-8">
											<input type="text" class="form-control form-control-sm" value="' . $fu_kebutuhan . '" readonly />
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4 col-form-label">Jenis Dokumen atau Informasi</label>
										<div class="col-sm-8">
											<input type="text" class="form-control form-control-sm" value="' . $fu_tipe_doc_detil . '" readonly />
										</div>
									</div>
									' . $perlu . '
								</div>
								<div class="col-md-6">
								' . $form_unggah . '
									<div class="row justify-content-end">
										<div class="col-md-4">
											' . $tombol_dokumen . '
											' . $tombol_reviu . ' 
										</div> 
									</div>
								</div>
								
									';
			if (!empty($catatan)) {
				$hasil .= '
						<div class="col-md-12">
							<div class="alert alert-warning" role="alert">
								' . $catatan . '
							</div> 
						</div>
						';
			} else {
				$hasil .= '';
			}

			$hasil .= '
								</div>
						</form>
					</div>
				</div>
			';
		}

		return $hasil;
	}

	public function get_detil_gcg()
	{
		$ck = explode("&", $this->input->post('kode'));
		$periode = $ck[0];
		$kode = $ck[1];
		$data = $this->gcgm->result_gcg_master_periode_kode($periode, $kode);
		echo json_encode($data);
	}

	public function tabel_modal_dokumen()
	{
		$data = array();
		$ck = explode("&", $this->input->post('kode'));
		$periode = $ck[0];
		$kode = $ck[1];
		$tipe = 'dokumen';
		$i = 1;
		$hasil = $this->gcgm->result_gcg_master_file_periode_kode($periode, $kode, $tipe);
		foreach ($hasil as $r) {

			$row = array();
			$row[] = $i;
			$row[] = '<a type="button" class="btn btn-outline-info" href="' . base_url() . 'assets/file/gcg/' . $r->doc_file . '" target="_blank" title="Download data ?"><i class="fas fa-file"></i> ' . $r->nama_doc . '</a>';
			$row[] = $r->keterangan_file;
			$row[] = '<a type="button" class="btn yellow" onclick="delete_files(' . "'" . $r->id .  "'" . ')"  title="Delete Files"><i class="fa fa-trash"></i></a>';
			// $row[] = $r->waktu_update;
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function tabel_modal_reviu()
	{
		$data = array();
		$ck = explode("&", $this->input->post('kode'));
		$periode = $ck[0];
		$kode = $ck[1];
		$tipe = 'reviu';
		$i = 1;
		$hasil = $this->gcgm->result_gcg_master_file_periode_kode($periode, $kode, $tipe);
		foreach ($hasil as $r) {

			$row = array();
			$row[] = $i;
			$row[] = '<a type="button" class="btn btn-outline-info" href="' . base_url() . 'assets/file/gcg/' . $r->doc_file . '" target="_blank" title="Download data ?"><i class="fas fa-file"></i> ' . $r->nama_doc . '</a>';
			//$row[] = $r->waktu_update;
			$row[] = $r->keterangan_file;
			$row[] = '<a type="button" class="btn yellow" onclick="delete_files_reviu(' . "'" . $r->id .  "'" . ')"  title="Delete Files"><i class="fa fa-trash"></i></a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function internal_terpilih()
	{
		#$periode
		$cek_periode = $this->input->post('periode');
		if ($cek_periode != '-Pilih-') {
			$periode = $cek_periode;
		} else {
			$periode = $this->gcgm->last_gcg_master_periode();
		}

		$hasil = '';
		$ref = $this->gcgm->return_gcg_aspek_all();

		echo json_encode($hasil);
	}

	public function simpan_modal_dokumen()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$datax = array();

		$ck = explode("&", $this->input->post('dokumen_kode'));
		$periode = $ck[0];
		$kode_fu = $ck[1];

		$cek_tipe = $this->gcgm->row_gcg_master_periode_kode($periode, $kode_fu, 'kebutuhan');
		if ($cek_tipe) {
			# ada
			$data['tipe'] = $cek_tipe;
		} else {
			# tidak ada
			$data['tipe'] = '-';
		}

		$data['periode'] = $periode;
		$data['kode_fu'] = $kode_fu;
		$data['nama_doc'] = $_FILES['dokumen_file']['name'];
		$data['keterangan_file'] = $this->input->post('dokumen_keterangan');
		$data['status_file'] = '1';
		$data['waktu_update'] = $sekarang;
		$data['user_update'] = $this->session->userdata('nama');

		if (!empty($_FILES['dokumen_file']['name'])) {
			$upload = $this->cek_berkas('dokumen_file');
			$data['doc_file'] = $upload;
		}

		$this->menum->save("gcg_master_fu_file", $data);

		$fu_tipe_doc = $this->gcgm->row_gcg_master_periode_kode($periode, $kode_fu, 'tipe_doc');
		$kelompok_doc = $this->gcgm->row_gcg_master_periode_kode($periode, $kode_fu, 'kelompok_doc');
		$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $kode_fu, 'Dokumen');
		$durasi = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'durasi');
		$progres = '';
		if ($durasi != '0') {
			$progres = 'Sudah ada ' . $jumlah_file . ' dari ' . $durasi . ' ' . $kelompok_doc;
		}
		// } else {
		// 	$progres = 'Sudah ada else';
		// }
		$datax['status_gcg'] = $progres;
		echo json_encode($datax);
	}

	public function simpan_modal_reviu()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();

		$ck = explode("&", $this->input->post('reviu_kode'));
		$periode = $ck[0];
		$kode = $ck[1];

		$data['tipe'] = 'reviu';

		$data['periode'] = $periode;
		$data['kode_fu'] = $kode;
		$data['nama_doc'] = $_FILES['reviu_file']['name'];
		$data['keterangan_file'] = $this->input->post('reviu_keterangan');
		$data['status_file'] = '1';
		$data['waktu_update'] = $sekarang;
		$data['user_update'] = $this->session->userdata('nama');

		if (!empty($_FILES['reviu_file']['name'])) {
			$upload = $this->cek_berkas('reviu_file');
			$data['doc_file'] = $upload;
		}

		$this->menum->save("gcg_master_fu_file", $data);

		echo json_encode(true);
	}

	public function gcg_simpan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();

		$kode = $this->input->post('kode');

		$kode_survey = $this->input->post('kode_survey');
		$kode_kondisi = $this->input->post('kondisi');
		$data['tahun'] = substr($kode_survey, 0, 4);
		$data['kode_survey'] = $kode_survey;
		$data['kode_lp'] = $kode;
		$data['kode_pri'] = $this->maturitym->row_maturity_ref_lp_kode_lp($kode)->kode_pri;
		$data['kode_kondisi'] = substr($kode_kondisi, 0, 1);
		$data['score_kondisi'] = substr($kode_kondisi, 2, 1);

		$arr_dok = explode("-", $this->input->post('dok'));
		$kode_dok = $arr_dok[1];

		if ($kode_dok == 'lain2') {
			$data['kode_dok'] = 'lain2';
			$data['status_dok'] = 'Sementara';
			if (!empty($_FILES['file_upload']['name'])) {
				$upload = $this->cek_berkas('file_upload');
				$data['link_dok'] = $upload;
			}
		} else if ($kode_dok != '') {
			$hd = $this->maturitym->row_v_maturity_tab_dok_update_id($kode_dok);
			$data['kode_dok'] = $hd->id;
			$data['status_dok'] = $hd->status_dok;
			$data['link_dok'] = $hd->file_upload;
		}

		$data['informasi'] = $this->input->post('informasi');
		$data['interview'] = $this->input->post('interview');
		$data['user_entri'] = $this->session->userdata('nama');
		$data['waktu_update'] = $sekarang;

		$cek_data = $this->maturitym->num_rows_maturity_tab_survey($kode_survey, $kode);
		if ($cek_data > 0) {
			$this->menum->update("maturity_tab_survey", array("kode_survey" => $kode_survey, "kode_lp" => $kode), $data);
		} else {
			$this->menum->save("maturity_tab_survey", $data);
		}


		echo json_encode(true);
	}

	private function cek_berkas($file_upload)
	{
		$config['upload_path']          = 'assets/file/gcg/';
		$config['allowed_types']        = 'jpeg|jpg|png|pdf|doc|docx|xls|xlsx';
		$config['max_size']             = 100250;
		$config['file_name']            = round(microtime(true) * 1000);

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if (!$this->upload->do_upload($file_upload)) {
			echo 'Gagal Upload: ' . $file_upload . ' dan ' . $this->upload->display_errors('', '');
			exit();
		}
		return $this->upload->data('file_name');
	}

	public function survey($kode_survey = '')
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			#$datax['list_kode_survey'] =  $this->gcgm->list_gcg_transaksi();
			$datax['list_kode_survey'] =  list_dropdown('gcg_surveyor', array('kode_survey', 'kode_survey'), array('status_survey' => 0));
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();
			$datax['selesai'] = $this->gcgm->selesai_survey();


			if (!empty($kode_survey)) {
				$datax['pertanyaan'] = $this->survey_pertanyaan($kode_survey);
				$datax['status_survey'] = '0';
				$datax['terpilih'] = $kode_survey;
			} else {
				$datax['terpilih'] = '';
				$datax['status_survey'] = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'hasil');
				$datax['pertanyaan'] = '
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="card-header">
									<h6>Silahkan register survey terlebih dahulu / pilih kode survey dan klik tombol tampilkan </h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}

			$this->load->view('gcg/survey', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function gcg_register()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);

		$data = array();
		$datas = array();

		$tahun = $this->input->post('tahun');
		$kode_survey = $this->input->post('kode_survey');
		$pecah = explode('_', $kode_survey);
		$jenis_survey = $this->input->post('jenis_survey');

		$data['tahun'] = $tahun;
		$data['urut_survey'] = $pecah[1];
		$data['kode_survey'] = $kode_survey;
		$data['jenis_survey'] = $jenis_survey;
		$data['tgl_pelaksanaan'] = $this->input->post('tgl_pelaksanaan');
		$data['surveyor'] = $this->input->post('surveyor');
		$data['lokasi_survey'] = $this->input->post('lokasi_survey');

		$this->menum->save("gcg_surveyor", $data);

		$proses_insert = $this->gcgm->insert_gcg_transaksi_kode_survey($kode_survey);
		if ($proses_insert === true) {
			$datas['status'] = true;
			$datas['informasi'] = 'Proses insert sukses';
		} else {
			$datas['status'] = false;
			$datas['informasi'] = 'Proses insert ke transaksi gagal!';
		}

		$datas['kode_survey'] = $kode_survey;
		$datas['list_kode_survey'] = $this->gcgm->result_gcg_transaksi_tahun_list();
		echo json_encode($datas);
	}

	public function survey_pertanyaan($kode_survey)
	{
		$hasil = '';
		$ref = result_tabel('temp_gcg_transaksi_fu_aspek', array('kode_survey' => $kode_survey));
		foreach ($ref as $r) {
			if ($r->jlh_fu_terisi == $r->jlh_fu) {
				$info_aspek = '<i class="fas fa-check"></i>';
			} else {
				$info_aspek = $r->jlh_fu_terisi . '/' . $r->jlh_fu;
			}

			$hasil .= '
				<div class="card shadow">
					<div class="card-header" id="heading_' . $r->no_aspek . '">
						<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $r->no_aspek . '" aria-expanded="true" aria-controls="collapse_' . $r->no_aspek . '">
							<p align="justify">
								<i class="fas fa-clipboard-list text-warning"></i>
								<span>' . $r->no_aspek . '. ' . $r->aspek_pengujian_indikator . ' </span> <span class="badge badge-primary" id="info_' . $r->no_aspek . '">' . $info_aspek . '</span>
							</p>
						</button>
					</div>
					<div id="collapse_' . $r->no_aspek . '" class="collapse" aria-labelledby="heading_' . $r->no_aspek . '" data-parent="#accordion">
						<div class="card-body">
					
							<div class="row">
								<div class="col-md-12">
									
			';

			// $ref_1 = $this->gcgm->survey_gcg_indikator_no_aspek($r->no_aspek);
			$ref_1 = result_tabel('temp_gcg_transaksi_fu_indikator', array('no_aspek' => $r->no_aspek, 'kode_survey' => $kode_survey));
			foreach ($ref_1 as $s) {
				if ($s->jlh_fu_terisi == $s->jlh_fu) {
					$info_indikator = '<i class="fas fa-check"></i>';
				} else {
					$info_indikator = $s->jlh_fu_terisi . '/' . $s->jlh_fu;
				}
				$kode_indikator = str_replace('.', '_', $s->no_indikator);
				$hasil .= '
									<div class="row">
										<div class="col-md-12">
											<h6 class="card-title">' . $s->no_indikator . '. ' . $s->aspek_pengujian_atau_indikator . ' <span class="badge badge-primary" id="info_' . $kode_indikator . '">' . $info_indikator . '</span></h6>  
										</div>
									</div>
									<div class="card mb-4">
										<div class="card-body">
				';

				// $ref_2 = $this->gcgm->survey_gcg_parameter_no_indikator($s->no_indikator);
				$ref_2 = result_tabel_order_by('temp_gcg_transaksi_fu_parameter', array('no_indikator' => $s->no_indikator, 'kode_survey' => $kode_survey),array('no_indikator','ASC'));
				foreach ($ref_2 as $t) {
					$theading = str_replace('.', '_', $t->no_parameter);
					#$theading = $t->no_aspek . '_' . $t->no_indikator . '_' . $t->no_parameter;
					if ($t->jlh_fu_terisi == $t->jlh_fu) {
						$info_parameter = '<i class="fas fa-check"></i>';
					} else {
						$info_parameter = $t->jlh_fu_terisi . '/' . $t->jlh_fu;
					}

					$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $theading . '">
									<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $theading . '" aria-expanded="true" aria-controls="collapse_' . $theading . '">
										<p align="justify">
											<i class="fas fa-pen-alt text-warning"></i> 
											<span>' . $t->no_parameter . '. ' . $t->aspek_pengujian_atau_indikator . ' </span> <span class="badge badge-primary" id="info_' . $theading . '">' . $info_parameter . '</span>
										</p>
									</button>
								</div>
								<div id="collapse_' . $theading . '" class="collapse" aria-labelledby="heading_' . $theading . '" data-parent="#heading_' . $r->no_aspek . '">
									<div class="card-body">
								
										<div class="row">
											<div class="col-md-12">
					';

					// $ref_3 = $this->gcgm->survey_gcg_fu_lv1_id_parameter($t->no_parameter);
					$ref_3 = result_tabel('temp_gcg_transaksi_fu_lv1', array('no_parameter' => $t->no_parameter, 'kode_survey' => $kode_survey));
					foreach ($ref_3 as $u) {
						if ($u->turunan_sfu == '1') {
							# penjelasan
							$get_fu = $u->id_fu;
							$hasil .= '
								<div class="card mb-4">
									<div class="card-body">
										<div class="row"> 
											<div class="col-md-12">
												<h6 class="card-title">' . $u->lv1 . '. ' . $u->faktor_uji . '</h6>
											</div>
											<div class="col-md-12">
							';

							// $ref_4 = $this->gcgm->survey_gcg_fu_lv2_id_fu($u->id_fu);
							$ref_4 = result_tabel('temp_gcg_transaksi_fu_lv2', array('lv1' => $u->lv1, 'kode_survey' => $kode_survey));
							foreach ($ref_4 as $w) {
								# pertanyaan
								$get_fu = $w->lv2 . '';
								$catatan = $w->catatan;
								$get_urut = $w->lv2 . '. ' . $w->uraian_sfu;

								$hasil .= $this->survey_detil($kode_survey, $get_fu, $get_urut, $catatan);
							}


							$hasil .= '
												
											</div>
										</div>
									</div>
								</div>
							';
						} else {
							# pertanyaan
							$get_fu = $u->lv1 . '.0';
							$get_urut = $u->lv1 . '. ' . $u->faktor_uji;

							$hasil .= $this->survey_detil($kode_survey, $get_fu, $get_urut, '');
						}
					}



					$hasil .= '
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}



				$hasil .= '
										</div>
									</div>
				';
			}



			$hasil .= '									
								</div>
							</div>
							
						</div>
						
						
					</div>
				</div>
			';
			$hasil .= '';
		}
		$hasil .= '
		<div class="col-md-12 mt-4"> 
			<div class="row justify-content-end">
				<div class="col-md-3">
					<button type="button" onclick="selesai_survey(' . "'" . $kode_survey . "'" . ')" class="btn btn-outline-primary btn-block" id="btn_selesai">
						<i class="fas fa-paper-plane"></i> Survey Selesai
					</button> 
				</div> 
			</div>
		</div>
		';

		return $hasil;
	}

	private function survey_detil($kode_survey, $get_fu, $get_urut, $catatan)
	{
		$hasil = '';

		$master_0 = $this->gcgm->result_temp_gcg_transaksi_fu_kode_survey_kode_master($kode_survey, $get_fu);
		foreach ($master_0 as $u) {
			$periode = $u->periode_master;
			$isi_analisa_kekuatan = $u->analisa_kekuatan;
			$isi_analisa_kelemahan = $u->analisa_kelemahan;
			$isi_identifikasi_hambatan = $u->identifikasi_hambatan;
			$isi_identifikasi_rekomendasi = $u->identifikasi_rekomendasi;
			$isi_hasil_survey = $u->hasil_survey;
			$isi_status_uji = $u->status_uji;
			$isi_kebutuhan = $u->kebutuhan;
			$isi_tipe_doc = $u->tipe_doc;
			$isi_doc_dibutuhkan_1 = $u->doc_dibutuhkan_1;
			$isi_doc_dibutuhkan_2 = $u->doc_dibutuhkan_2;
			$isi_pic = $u->pic;
			$isi_perlu_doc = $u->perlu_doc;
			$fu_kode = $u->kode_fu;
		}
		$kode_tombol = str_replace('.', '_', $fu_kode);
		$tahun = substr($periode, 0, 4);
		$nama_divisi = '';
		$list_divisi = $this->gcgm->result_v_gcg_divisi_tahun($tahun);
		foreach ($list_divisi as $a) {
			if ($a->kode == $isi_pic) {
				$nama_divisi .= $a->nama_divisi;
			} else {
				$nama_divisi .= '';
			}
		}

		$kode_modal = $periode . '&' . $get_fu;
		$fu_kodex = str_replace('.', '-', $get_fu);
		$fu_kodez = str_replace('.', '_', $get_fu);

		$perlu = "";
		$form_unggah = "";
		if ($isi_perlu_doc == '1') {
			$perlu .= '
					- Nama Dokumen : ' . $isi_doc_dibutuhkan_1 . ' <br/>
					- PIC : ' . $nama_divisi . '
				';
			$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $get_fu, 'Dokumen');
			if ($jumlah_file > 0) {
				$durasi = $this->gcgm->row_gcg_tipe_doc_kode_doc($isi_tipe_doc, 'durasi');
				$kelompok_doc = $this->gcgm->row_gcg_tipe_doc_kode_doc($isi_tipe_doc, 'kelompok_doc');
				if ($durasi != '0') {
					$progres = $jumlah_file . ' dari ' . $durasi . ' ' . $kelompok_doc;
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="Sudah ada ' . $progres . '" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				} else {
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" value="Sudah ada" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				}
			} else {
				$form_unggah .= ' 
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" value="Belum ada" readonly />
							</div>
						</div>
					';
				$tombol_dokumen = '';
			}
		} else {
			$perlu .= '- PIC : ' . $nama_divisi . '';
			$tombol_dokumen = '';
		}

		if ($isi_kebutuhan == 'Dokumen') {
			$tipe_doc = substr($isi_tipe_doc, 0, 1);
			if ($tipe_doc == 'B') {
				$tombol_reviu = "";
			} else {
				$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $get_fu, 'Dokumen');
				if ($jumlah_file > 0) {
					$tombol_reviu = '
					<div class="col-md-4" id="lihat_reviu' . $kode_tombol . '">
						<button type="button" onclick="cek_reviu(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" >
							<i class="fas fa-file-alt"></i> Lihat Reviu 
						</button>
					</div>
					';
				} else {
					$tombol_reviu = "";
				}
			}
		} else {
			$tombol_reviu = "";
		}

		$analisa_identifikasi = '';
		if ($isi_status_uji == '0') {
			$analisa_identifikasi .= '
			<hr/>
			<form action="#" id="form_' . $fu_kodex . '" enctype="multipart/form-data">
				<div class="row">
					
					<div class="col-md-6">
						<h6 class="card-title">Analisis Penerapan GCG</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kekuatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kekuatan" name="' . $fu_kodex  . '_analisa_kekuatan" rows="1" disabled> Not Available</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kelemahan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kelemahan" name="' . $fu_kodex  . '_analisa_kelemahan" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="card-title">Identifikasi Hambatan dan Usulan Rekomendasi</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hambatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_hambatan" name="' . $fu_kodex  . '_identifikasi_hambatan" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Rekomendasi</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_rekomendasi" name="' . $fu_kodex  . '_identifikasi_rekomendasi" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hasil Penilaian</label> 
							<div class="col-sm-8">
								<select class="form-control form-control-sm" id="' . $fu_kodex  . '_hasil_survey" name="' . $fu_kodex  . '_hasil_survey" disabled>
									<option value="" >-Pilih-</option>
												';
			$list_hasil = $this->gcgm->result_gcg_transaksi_fu_pilihan_all();
			foreach ($list_hasil as $a) {
				$analisa_identifikasi .= '
							<option value="' . $a->kode . '" ' . (($a->kode == $isi_hasil_survey) ? "selected" : "") . '> ' . $a->uraian . '</option>
						';
			}
			$analisa_identifikasi .= ' 
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="row justify-content-end">
							<div class="col-md-4">
								<button type="button" onclick="simpan_survey(' . "'" . $fu_kodex . "'" . ')" class="btn btn-outline-primary btn-block" id="btn_survey_' . $fu_kodex . '" disabled>
									<i class="fas fa-paper-plane"></i> Simpan
								</button>
							</div> 
						</div>
					</div>

					
				</div>
			</form>
			';
		} else {
			$analisa_identifikasi .= '
			<hr/>
			<form action="#" id="form_' . $fu_kodex . '" enctype="multipart/form-data">
				<div class="row">
					
					<div class="col-md-6">
						<h6 class="card-title">Analisis Penerapan GCG</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kekuatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kekuatan" name="' . $fu_kodex  . '_analisa_kekuatan" rows="1" >' . $isi_analisa_kekuatan . '</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kelemahan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kelemahan" name="' . $fu_kodex  . '_analisa_kelemahan" rows="1" >' . $isi_analisa_kelemahan . '</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="card-title">Identifikasi Hambatan dan Usulan Rekomendasi</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hambatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_hambatan" name="' . $fu_kodex  . '_identifikasi_hambatan" rows="1" >' . $isi_identifikasi_hambatan . '</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Rekomendasi</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_rekomendasi" name="' . $fu_kodex  . '_identifikasi_rekomendasi" rows="1" >' . $isi_identifikasi_rekomendasi . '</textarea>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hasil Penilaian</label> 
							<div class="col-sm-8">
								<select class="form-control form-control-sm" id="' . $fu_kodex  . '_hasil_survey" name="' . $fu_kodex  . '_hasil_survey">
									<option value="" >-Pilih-</option>
												';
			$list_hasil = $this->gcgm->result_gcg_transaksi_fu_pilihan_all();
			foreach ($list_hasil as $a) {
				$analisa_identifikasi .= '
							<option value="' . $a->kode . '" ' . (($a->kode == $isi_hasil_survey) ? "selected" : "") . '> ' . $a->uraian . '</option>
						';
			}
			$analisa_identifikasi .= ' 
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6"> 
						<div class="row justify-content-end">
							<div class="col-md-4">
								<button type="button" onclick="simpan_survey(' . "'" . $fu_kodex . "'" . ')" class="btn btn-outline-primary btn-block" id="btn_survey_' . $fu_kodex . '" >
									<i class="fas fa-paper-plane"></i> Simpan
								</button>
							</div> 
						</div>
					</div>

					
				</div>
			</form>
			';
		}



		if ($isi_status_uji != '0') {
			$fu_tipe_doc_detil = $this->gcgm->row_gcg_tipe_doc_kode_doc($isi_tipe_doc, 'type_doc');
			$hasil .= '
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<h6 class="card-title" id="heading_' . $fu_kodez . '">' . $get_urut . '</h6>
							</div>
							<div class="col-md-6">
								<div class="alert alert-info" role="alert">
									- Jenis kebutuhan : ' . $isi_kebutuhan . ' <br/>
									- Jenis Dokumen : ' . $fu_tipe_doc_detil . ' <br/>
									' . $perlu . '
								</div> 
							</div>
							<div class="col-md-6">
							' . $form_unggah . '
								<div class="row justify-content-end">
									' . $tombol_dokumen . '
									' . $tombol_reviu . ' 
								</div>
							</div>
							';
			if (!empty($catatan)) {
				$hasil .= '
										<div class="col-md-12">
											<div class="alert alert-warning" role="alert">
												' . $catatan . '
											</div> 
										</div>
										';
			} else {
				$hasil .= '';
			}

			$hasil .= '
						</div>
					' . $analisa_identifikasi . '
					</div>
				</div>
			';
		} else {
			$fu_tipe_doc_detil = '';
			$hasil .= '
				<div class="card mb-4">
					<div class="card-body">
						
						<div class="row">
							<div class="col-md-12">
								<h6 class="card-title" id="heading_' . $fu_kodez . '">' . $get_urut . '</h6>
							</div>
							<div class="col-md-6">
								<div class="alert alert-warning" role="alert">
									Faktor Uji ini tidak diujikan
								</div> 
							</div>
						</div>';

			$hasil .= '
					</div>
				</div>
			';
		}

		return $hasil;
	}

	public function simpan_survey()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$data_aoi = array();
		$data_info = array();

		$kode = $this->input->post('kode');
		$kodex = str_replace('-', '.', $kode);
		$kode_survey = $this->input->post('kode_survey');

		$xakn = $kode . '_analisa_kekuatan';
		$data['analisa_kekuatan'] = $this->input->post($xakn);
		$xakl = $kode . '_analisa_kelemahan';
		$data['analisa_kelemahan'] = $this->input->post($xakl);

		$xih = $kode . '_identifikasi_hambatan';
		$data['identifikasi_hambatan'] = $this->input->post($xih);

		$xir = $kode . '_identifikasi_rekomendasi';
		$identifikasi_rekomendasi = $this->input->post($xir);
		$data['identifikasi_rekomendasi'] = $identifikasi_rekomendasi;

		$xhs = $kode . '_hasil_survey';
		$data['hasil_survey'] = $this->input->post($xhs);

		$data['waktu_update'] = $sekarang;

		#$this->menum->update("gcg_transaksi_fu", array("kode_survey" => $kode_survey, "kode_fu" => $kodex), $data);
		$this->gcgm->update_gcg_transaksi_fu($data, $kode_survey, $kodex);

		$cek_ir = $this->gcgm->cek_gcg_transaksi_aoi_kode_survey_kode_master($kode_survey, $kodex);
		$periode = $this->gcgm->row_gcg_transaksi_fu_detil($kode_survey, $kodex, 'periode_master');
		$pic = $this->gcgm->row_gcg_master_periode_kode($periode, $kodex, 'pic');
		if ($cek_ir > 0) {
			if (!empty($identifikasi_rekomendasi)) {
				$data_aoi['rekomendasi'] = $identifikasi_rekomendasi;
				$data_aoi['status_aoi'] = '1';
				$data_aoi['organ_pendukung'] = $pic;
				$this->menum->update("gcg_transaksi_aoi", array("kode_survey" => $kode_survey, "kode_fu" => $kodex), $data_aoi);
			} else {
				$data_aoi['status_aoi'] = '0';
				$data_aoi['organ_pendukung'] = $pic;
				$this->menum->update("gcg_transaksi_aoi", array("kode_survey" => $kode_survey, "kode_fu" => $kodex), $data_aoi);
			}
		} else {
			if (!empty($identifikasi_rekomendasi)) {
				$data_aoi['kode_survey'] = $kode_survey;
				$data_aoi['kode_fu'] = $kodex;
				$data_aoi['rekomendasi'] = $identifikasi_rekomendasi;
				$data_aoi['status_aoi'] = '1';
				$data_aoi['organ_pendukung'] = $pic;
				$this->menum->save("gcg_transaksi_aoi", $data_aoi);
			}
		}

		$kda = substr($kodex, 0, 1);
		$data_info['info_aspek'] = $this->gcgm->result_v_gcg_transaksi_fu_aspek_hasil('temp_gcg_transaksi_fu_aspek', $kode_survey, 'no_aspek', $kda);

		$kdi = substr($kodex, 0, 3);
		$data_info['info_indikator'] = $this->gcgm->result_v_gcg_transaksi_fu_aspek_hasil('temp_gcg_transaksi_fu_indikator', $kode_survey, 'no_indikator', $kdi);

		$kdp = substr($kodex, 0, 5);
		$data_info['info_parameter'] = $this->gcgm->result_v_gcg_transaksi_fu_aspek_hasil('temp_gcg_transaksi_fu_parameter', $kode_survey, 'no_parameter', $kdp);

		echo json_encode($data_info);
	}

	public function cek_survey()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$datax = array();
		$datas = array();

		$kode_survey = $this->input->post('kode');

		#cek pengisian survey 
		$cek = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'hasil');
		if ($cek == 'SELESAI') {
			$datax['informasi'] = 'Semua survey telah terisi';
			$datax['status'] = 'selesai';
			$datax['data_aspek'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_aspek($kode_survey);
			$datax['data_parameter'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_parameter($kode_survey);
			$datax['data_fu'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_fu($kode_survey);
		} else {
			$jumlah = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'jumlah');
			$datax['informasi'] = 'Masih terdapat ' . $jumlah . ' yang belum disurvey';
			$datax['status'] = 'belum';
			$datax['data_aspek'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_aspek($kode_survey);
			$datax['data_parameter'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_parameter($kode_survey);
			$datax['data_fu'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_fu($kode_survey);
		}

		echo json_encode($datax);
	}

	public function selesai_survey()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$datax = array();
		$datas = array();

		$kode_survey = $this->input->post('kode');

		#cek pengisian survey 
		$cek = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'hasil');
		if ($cek == 'SELESAI') {
			$data['status_survey'] = '1';
			$selesai = $this->menum->update("gcg_transaksi_fu", array("kode_survey" => $kode_survey), $data);
			if ($selesai == TRUE) {
				$datax['informasi'] = 'Status finishing berhasil';
				$datas['status_survey'] = '1';
				$this->menum->update("gcg_surveyor", array("kode_survey" => $kode_survey), $datas);
			} else {
				$datax['informasi'] = 'Status finishing gagal';
			}
			$datax['status'] = 'selesai';
		} else {
			$jumlah = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'jumlah');
			$datax['informasi'] = 'Masih terdapat ' . $jumlah . ' yang belum disurvey';
			$datax['status'] = 'belum';
			$datax['data_aspek'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_aspek($kode_survey);
			$datax['data_parameter'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_parameter($kode_survey);
			$datax['data_fu'] = $this->gcgm->result_gcg_transaksi_fu_kode_survey_belum_fu($kode_survey);
		}

		echo json_encode($datax);
	}

	public function hasil_gcg_ini($kode_survey = '')
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			$datax['list_kode_survey'] =  $this->gcgm->list_gcg_transaksi();
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();

			if (!empty($kode_survey)) {
				$datax['pertanyaan'] = $this->hasil_survey_pertanyaan($kode_survey);
				#$datax['pertanyaan'] = '';
				$datax['terpilih'] = $kode_survey;
				$datax['tabel_parameter'] = $this->gcg_tabel_parameter($kode_survey);
				$datax['tabel_indikator'] = $this->gcg_tabel_indikator($kode_survey);
				$datax['tabel_aspek'] = $this->gcg_tabel_aspek($kode_survey);
				$datax['total_bobot_uji']=$this->gcgm->sum('v_gcg_transaksi_fu_aspek','bobot',"kode_survey='$kode_survey'");
				$datax['total_skor']=$this->gcgm->sum('v_gcg_transaksi_fu_parameter','skor',"kode_survey='$kode_survey'");
			} else {
				$datax['terpilih'] = '';
				$datax['pertanyaan'] = '
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="card-header">
									<h6>Silahkan pilih kode survey dan klik tombol tampilkan </h6>
								</div>
							</div>
						</div>

					</div>
				</div>
				';
				$datax['tabel_parameter'] = '';
				$datax['tabel_indikator'] = '';
				$datax['tabel_aspek'] = '';
				$datax['total_bobot_uji'] = '';
				$datax['total_skor'] = '';
			}

			$this->load->view('gcg/hasil_gcg_ini', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function hasil_gcg($kode_survey = '')
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			$datax['list_kode_survey'] =  list_dropdown('gcg_surveyor', array('kode_survey', 'kode_survey'), array('status_survey' => 1));
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();

			if (!empty($kode_survey)) {
				$datax['pertanyaan'] = $this->hasil_survey_pertanyaan($kode_survey);
				#$datax['pertanyaan'] = '';
				$datax['terpilih'] = $kode_survey; 
				$datax['tabel_parameter'] = $this->gcg_tabel_parameter($kode_survey);
				$datax['tabel_indikator'] = $this->gcg_tabel_indikator($kode_survey);
				$datax['tabel_aspek'] = $this->gcg_tabel_aspek($kode_survey);
				$datax['tabel_hasil_tidak_sesuai'] = $this->gcg_tabel_hasil_tidak_sesuai($kode_survey);
				$datax['total_bobot_uji']=$this->gcgm->sum('v_gcg_transaksi_fu_aspek','bobot',"kode_survey='$kode_survey'");
				$datax['total_skor']=$this->gcgm->sum('v_gcg_transaksi_fu_parameter','skor',"kode_survey='$kode_survey'");

			} else { 
				$datax['terpilih'] = '';
				$datax['pertanyaan'] = '
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="card-header">
									<h6>Silahkan pilih kode survey dan klik tombol tampilkan </h6>
								</div>
							</div>
						</div>

					</div>
				</div>
				';
				$datax['tabel_parameter'] = '';
				$datax['tabel_indikator'] = '';
				$datax['tabel_aspek'] = '';
				$datax['total_bobot_uji'] = '';
				$datax['total_skor'] = '';
				$datax['tabel_hasil_tidak_sesuai'] = '';
			}

			$this->load->view('gcg/hasil_gcg', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}
	public function gcg_tabel_hasil_tidak_sesuai($periode=''){
		// $periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result('gcg_transaksi_fu',array('kode_survey'=>$periode,'status_uji'=>'1','status_survey'=>'1','hasil_survey'=>'0'));
		$x=1;
		$data = array();
		foreach ($group as $r) { 
			$row = array();
			$row[] = $x;
			$row[] = $r->kode_fu;
			$row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'pertanyaan');
			// $row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'kebutuhan');
			// $kode_doc = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'tipe_doc');
			// $row[] = $this->gcgm->row_tabel('gcg_tipe_doc',array('kode_doc'=>$kode_doc),'type_doc');
			$row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'doc_dibutuhkan_1');
			$kode_pic = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'pic');
			$row[] = $this->gcgm->row_tabel('master_org_divisi',array('kode'=>$kode_pic),'uraian');
			$sts_doc = $this->gcgm->row_gcg_status_dokumen_kode($periode, $r->kode_fu);
			$row[] = $sts_doc;
			$row[] = $r->analisa_kekuatan ==''?'-':$r->analisa_kekuatan;
			$row[] = $r->analisa_kelemahan ==''?'-':$r->analisa_kelemahan;
			$row[] = $r->identifikasi_hambatan ==''?'-':$r->identifikasi_hambatan;
			$row[] = $r->identifikasi_rekomendasi ==''?'-':$r->identifikasi_rekomendasi;
			$row[] = $r->kode_fu=='1'? 'Sesuai' : 'Tidak Sesuai';
			$data[] = $row; 
			$x++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function gcg_tabel_hasil_tidak_sesuaix($kode_survey=''){
		$hasil = '';
		$isi = $this->gcgm->result('gcg_transaksi_fu',array('kode_survey'=>$kode_survey,'status_survey'=>'1','hasil_survey'=>'0'));
		$x = 1;
		foreach ($isi as $r) {
			$kode_pic=row_tabel('gcg_master_fu',array('periode'=>$kode_survey,'kode_fu'=>$r->kode_fu),'pic');
			$pic=row_tabel('master_org_divisi',array('kode'=>$kode_pic),'uraian');
			$fu=row_tabel('gcg_master_fu',array('periode'=>$kode_survey,'kode_fu'=>$r->kode_fu),'pertanyaan');
			$hasil .= '
			<tr>
				<td>' . $x . '</td>
				<td>' . $r->kode_fu . '</td>
				<td>' . $fu . '</td>
				<td>' . $pic . '</td>
				<td>' . $r->hasil_survey . ' </td>
			</tr>
			';
			$x++;
		}
		return $hasil;
	}
	public function gcg_tabel_parameter($kode_survey)
	{
		$hasil = '';
		$isi = $this->gcgm->result_v_gcg_transaksi_fu_parameter_kode_survey($kode_survey);
		$x = 1;
		foreach ($isi as $r) {
			$hasil .= '
			<tr>
				<td>' . $x . '</td>
				<td>' . $r->no_parameter . '</td>
				<td>' . $r->aspek_pengujian_atau_indikator . '</td>
				<td>' . number_format($r->bobot, 2) . '</td>
				<td>' . $r->pemenuhan . ' %</td>
				<td>' . number_format($r->skor, 2) . '</td>
			</tr>
			';
			$x++;
		}
		return $hasil;
	}

	public function gcg_tabel_indikator($kode_survey)
	{
		$hasil = '';
		$isi = $this->gcgm->result_v_gcg_transaksi_fu_indikator_kode_survey($kode_survey);
		$x = 1;
		foreach ($isi as $r) {
			$hasil .= '
			<tr>
				<td>' . $x . '</td>
				<td>' . $r->no_indikator . '</td>
				<td>' . $r->aspek_pengujian_atau_indikator . '</td>
				<td>' . number_format($r->bobot, 2) . '</td>
				<td>' . $r->pemenuhan . ' %</td>
				<td>' . number_format($r->skor, 2) . '</td>
			</tr>
			';
			$x++;
		}
		return $hasil;
	}

	public function gcg_tabel_aspek($kode_survey)
	{
		$hasil = '';
		$isi = $this->gcgm->result_v_gcg_transaksi_fu_aspek_kode_survey($kode_survey);
		$x = 1;
		foreach ($isi as $r) {
			$hasil .= '
			<tr>
				<td>' . $x . '</td>
				<td>' . $r->no_aspek . '</td>
				<td>' . $r->aspek_pengujian_indikator . '</td>
				<td>' . number_format($r->bobot, 2) . '</td>
				<td>' . $r->pemenuhan . ' %</td>
				<td>' . number_format($r->skor, 2) . '</td>
			</tr>
			';
			$x++;
		}
		return $hasil;
	}

	public function hasil_survey_pertanyaan($kode_survey)
	{
		#$kode_survey = $this->input->post('kode_survey');

		$hasil = '';
		$ref = $this->gcgm->return_gcg_aspek_all();
		foreach ($ref as $r) {
			$hasil .= '
				<div class="card shadow">
					<div class="card-header" id="heading_' . $r->no_aspek . '">
						<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $r->no_aspek . '" aria-expanded="true" aria-controls="collapse_' . $r->no_aspek . '">
							<p align="justify">
								<i class="fas fa-clipboard-list text-warning"></i> ' . $r->no_aspek . '. ' . $r->aspek_pengujian_indikator . '
							</p>
						</button>
					</div>
					<div id="collapse_' . $r->no_aspek . '" class="collapse" aria-labelledby="heading_' . $r->no_aspek . '" data-parent="#accordion">
						<div class="card-body">
					
							<div class="row">
								<div class="col-md-12">


									
			';
			$ref_1 = $this->gcgm->return_gcg_indikator_no_aspek($r->no_aspek);
			foreach ($ref_1 as $s) {
				$hasil .= '
									<div class="row">
										<div class="col-md-12">
											<h6 class="card-title">' . $r->no_aspek . '.' . $s->no_indikator . '. ' . $s->aspek_pengujian_atau_indikator . '</h6>
										</div>
									</div>
									<div class="card mb-4">
										<div class="card-body">
				';

				$ref_2 = $this->gcgm->return_gcg_parameter_no_indikator($s->no_indikator);
				foreach ($ref_2 as $t) {
					$theading = $t->no_aspek . '_' . $t->no_indikator . '_' . $t->no_parameter;
					$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $theading . '">
									<button class="btn btn-link text-dark" data-toggle="collapse" data-target="#collapse_' . $theading . '" aria-expanded="true" aria-controls="collapse_' . $theading . '">
										<p align="justify">
											<i class="fas fa-pen-alt text-warning"></i> ' . $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '. ' . $t->aspek_pengujian_atau_indikator . '
										</p>
									</button>
								</div>
								<div id="collapse_' . $theading . '" class="collapse" aria-labelledby="heading_' . $theading . '" data-parent="#heading_' . $r->no_aspek . '">
									<div class="card-body">
								
										<div class="row">
											<div class="col-md-12">
					';
					$ref_3 = $this->gcgm->return_gcg_fu_lv1_id_parameter($t->no_parameter);
					foreach ($ref_3 as $u) {
						if ($u->turunan_sfu == '1') {
							# penjelasan
							$get_fu = $u->id_fu;
							$hasil .= '
								<div class="card mb-4">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<h6 class="card-title">' . $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '. ' . $u->faktor_uji . '</h6>
											</div>
											<div class="col-md-12">
							';
							$ref_4 = $this->gcgm->return_gcg_fu_lv2_id_fu($u->id_fu);
							foreach ($ref_4 as $w) {
								if ($w->turunan_ssfu == '1') {
									# penjelasan
									$get_fu = $w->id_sfu;
									$hasil .= '
										<div class="card mb-4">
											<div class="card-body">
												<div class="row">
													<div class="col-md-12">
														<h6 class="card-title">' . $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '.' . $w->urut_sfu . '. ' . $w->uraian_sfu . '</h6>
													</div>
													<div class="col-md-12">
									';
									$ref_5 = $this->gcgm->return_gcg_fu_lv3_id_sfu($w->id_sfu);
									foreach ($ref_5 as $x) {
										# pertanyaan
										$get_fu = $r->no_aspek . '.' . $s->no_indikator . '.' . $x->id_ssfu;
										$get_urut = $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '.' . $w->urut_sfu . '.' . $x->urut_ssfu . '. ' . $x->uraian_ssfu;

										$hasil .= $this->hasil_survey_detil($kode_survey, $get_fu, $get_urut, '');
									}
									$hasil .= '
													</div>
												</div>
											</div>
										</div>
									';
								} else {
									# pertanyaan
									$get_fu = $r->no_aspek . '.' . $s->no_indikator . '.' . $w->id_sfu . '';
									$catatan = $w->catatan;
									$get_urut = $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '.' . $w->urut_sfu . '. ' . $w->uraian_sfu;

									$hasil .= $this->hasil_survey_detil($kode_survey, $get_fu, $get_urut, $catatan);
								}
							}
							$hasil .= '
												
											</div>
										</div>
									</div>
								</div>
							';
						} else {
							# pertanyaan
							$get_fu = $r->no_aspek . '.' . $s->no_indikator . '.' . $u->id_fu . '.0';
							$get_urut = $r->no_aspek . '.' . $s->no_indikator . '.' . $t->no_parameter . '.' . $u->urut_fu . '. ' . $u->faktor_uji;

							$hasil .= $this->hasil_survey_detil($kode_survey, $get_fu, $get_urut, '');
						}
					}

					$hasil .= '
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					';
				}
				$hasil .= '
										</div>
									</div>
				';
			}

			$hasil .= '									
								</div>
							</div>
							
						</div>
						
						
					</div>
				</div>
			';
			$hasil .= '';
		}

		return $hasil;
	}

	private function hasil_survey_detil($kode_survey, $get_fu, $get_urut, $catatan)
	{
		$hasil = '';

		$master_0 = $this->gcgm->result_gcg_transaksi_fu_kode_survey_kode_master($kode_survey, $get_fu);
		foreach ($master_0 as $u) {
			$periode = $u->periode_master;
			$isi_analisa_kekuatan = $u->analisa_kekuatan;
			$isi_analisa_kelemahan = $u->analisa_kelemahan;
			$isi_identifikasi_hambatan = $u->identifikasi_hambatan;
			$isi_identifikasi_rekomendasi = $u->identifikasi_rekomendasi;
			$isi_hasil_survey = $u->hasil_survey;
			$isi_status_uji = $u->status_uji;
		}

		$master_1 = $this->gcgm->result_gcg_master_periode_kode($periode, $get_fu);
		foreach ($master_1 as $v) {
			$fu_kode = $v->kode_fu;
			$fu_pertanyaan = $v->pertanyaan;
			$fu_kebutuhan = $v->kebutuhan;
			$fu_tipe_doc = $v->tipe_doc;
			$fu_doc_dibutuhkan_1 = $v->doc_dibutuhkan_1;
			$fu_doc_dibutuhkan_2 = $v->doc_dibutuhkan_2;
			$fu_pic = $v->pic;
			$fu_info_pilihan = $v->info_pilihan;
			$fu_perlu_doc = $v->perlu_doc;
		}

		$tahun = substr($periode, 0, 4);
		$nama_divisi = '';
		$list_divisi = $this->gcgm->result_v_gcg_divisi_tahun($tahun);
		foreach ($list_divisi as $a) {
			if ($a->kode == $fu_pic) {
				$nama_divisi .= $a->uraian;
			} else {
				$nama_divisi .= '';
			}
		}

		$kode_modal = $periode . '&' . $fu_kode;
		$fu_kodex = str_replace('.', '-', $fu_kode);

		$perlu = "";
		$form_unggah = "";
		if ($fu_perlu_doc == '1') {
			$perlu .= '
					- Nama Dokumen : ' . $fu_doc_dibutuhkan_1 . ' <br/>
					- PIC : ' . $nama_divisi . '
				';
			$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $fu_kode, 'Dokumen');
			if ($jumlah_file > 0) {
				$durasi = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'durasi');
				$kelompok_doc = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'kelompok_doc');
				if ($durasi != '0') {
					$progres = $jumlah_file . ' dari ' . $durasi . ' ' . $kelompok_doc;
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Sudah ada ' . $progres . '" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				} else {
					$form_unggah .= '
							<div class="form-group row">
								<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
								<div class="col-sm-8">
									<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Sudah ada" readonly />
								</div>
							</div>
						';
					$tombol_dokumen = '
						<div class="col-md-4" id="lihat_dokumen' . $kode_tombol . '">
							<button type="button" onclick="cek_dokumen(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_cek_' . $fu_kode . '" >
								<i class="fas fa-file-alt"></i> Lihat Dokumen
							</button>
						</div>
					';
				}
			} else {
				$form_unggah .= ' 
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Status Unggah Dokumen</label> 
							<div class="col-sm-8">
								<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_status" value="Belum ada" readonly />
							</div>
						</div>
					';
				$tombol_dokumen = '';
			}
		} else {
			$perlu = '
			<div class="form-group row">
						<label class="col-sm-4 col-form-label">PIC</label> 
						<div class="col-sm-8">
							<input type="text" class="form-control form-control-sm" id="' . $fu_kode  . '_pic" name="' . $fu_kode  . '_pic" value="' . $nama_divisi . '" disabled />
						</div>
					</div>
			';
			$tombol_dokumen = '';
		}

		if ($fu_kebutuhan == 'Dokumen') {
			$tipe_doc = substr($fu_tipe_doc, 0, 1);
			if ($tipe_doc == 'B') {
				$tombol_reviu = "";
			} else {
				$jumlah_file = $this->gcgm->num_rows_gcg_master_file_periode_kode($periode, $fu_kode, 'Dokumen');
				if ($jumlah_file > 0) {
					$tombol_reviu = '
					<div class="col-md-4" id="unggah_reviu_' . $kode_tombol . '">
						<button type="button" onclick="cek_reviu(' . "'" . $kode_modal . "'" . ')" class="btn btn-outline-secondary btn-block" id="btn_reviu_' . $fu_kode . '" >
							<i class="fas fa-file-alt"></i> Unggah Reviu 
						</button>
					</div>
					';
				} else {
					$tombol_reviu = "";
				}
			}
		} else {
			$tombol_reviu = "";
		}

		$analisa_identifikasi = '';
		if ($isi_status_uji == '0') {
			$analisa_identifikasi .= '
			<hr/>
			<form action="#" id="form_' . $fu_kodex . '" enctype="multipart/form-data">
				<div class="row">
					
					<div class="col-md-6">
						<h6 class="card-title">Analisis Penerapan GCG</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kekuatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kekuatan" name="' . $fu_kodex  . '_analisa_kekuatan" rows="1" disabled> Not Available</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kelemahan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kelemahan" name="' . $fu_kodex  . '_analisa_kelemahan" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="card-title">Identifikasi Hambatan dan Usulan Rekomendasi</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hambatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_hambatan" name="' . $fu_kodex  . '_identifikasi_hambatan" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Rekomendasi</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_rekomendasi" name="' . $fu_kodex  . '_identifikasi_rekomendasi" rows="1"  disabled> Not Available</textarea>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hasil Penilaian</label> 
							<div class="col-sm-8">
								<select class="form-control form-control-sm" id="' . $fu_kodex  . '_hasil_survey" name="' . $fu_kodex  . '_hasil_survey" disabled>
									<option value="" >-Pilih-</option>
												';
			$list_hasil = $this->gcgm->result_gcg_transaksi_fu_pilihan_all();
			foreach ($list_hasil as $a) {
				$analisa_identifikasi .= '
							<option value="' . $a->kode . '" ' . (($a->kode == $isi_hasil_survey) ? "selected" : "") . '> ' . $a->uraian . '</option>
						';
			}
			$analisa_identifikasi .= ' 
								</select>
							</div>
						</div>
					</div>

					
				</div>
			</form>
			';
		} else {
			$analisa_identifikasi .= '
			<hr/>
			<form action="#" id="form_' . $fu_kodex . '" enctype="multipart/form-data">
				<div class="row">
					
					<div class="col-md-6">
						<h6 class="card-title">Analisis Penerapan GCG</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kekuatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kekuatan" name="' . $fu_kodex  . '_analisa_kekuatan" rows="1" disabled>' . $isi_analisa_kekuatan . '</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Kelemahan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_analisa_kelemahan" name="' . $fu_kodex  . '_analisa_kelemahan" rows="1" disabled>' . $isi_analisa_kelemahan . '</textarea>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<h6 class="card-title">Identifikasi Hambatan dan Usulan Rekomendasi</h6>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hambatan</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_hambatan" name="' . $fu_kodex  . '_identifikasi_hambatan" rows="1" disabled>' . $isi_identifikasi_hambatan . '</textarea>
							</div>
						</div>
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Rekomendasi</label> 
							<div class="col-sm-8">
								<textarea type="text" class="form-control form-control-sm"  id="' . $fu_kodex  . '_identifikasi_rekomendasi" name="' . $fu_kodex  . '_identifikasi_rekomendasi" rows="1" disabled>' . $isi_identifikasi_rekomendasi . '</textarea>
							</div>
						</div>
					</div>
				</div>
				<hr/>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group row">
							<label class="col-sm-4 col-form-label">Hasil Penilaian</label> 
							<div class="col-sm-8">
								<select class="form-control form-control-sm" id="' . $fu_kodex  . '_hasil_survey" name="' . $fu_kodex  . '_hasil_survey" disabled>
									<option value="" >-Pilih-</option>
												';
			$list_hasil = $this->gcgm->result_gcg_transaksi_fu_pilihan_all();
			foreach ($list_hasil as $a) {
				$analisa_identifikasi .= '
							<option value="' . $a->kode . '" ' . (($a->kode == $isi_hasil_survey) ? "selected" : "") . '> ' . $a->uraian . '</option>
						';
			}
			$analisa_identifikasi .= ' 
								</select>
							</div>
						</div>
					</div>

					
				</div>
			</form>
			';
		}



		if (!empty($fu_kebutuhan)) {
			$fu_tipe_doc_detil = $this->gcgm->row_gcg_tipe_doc_kode_doc($fu_tipe_doc, 'type_doc');
			$hasil .= '
				<div class="card mb-4">
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<h6 class="card-title">' . $get_urut . '</h6>
							</div>
							<div class="col-md-6">
								<div class="alert alert-info" role="alert">
									- Jenis kebutuhan : ' . $fu_kebutuhan . ' <br/>
									- Jenis Dokumen : ' . $fu_tipe_doc_detil . ' <br/>
									' . $perlu . '
								</div> 
							</div>
							<div class="col-md-6">
							' . $form_unggah . '
								<div class="row justify-content-end">
									' . $tombol_dokumen . '
									' . $tombol_reviu . ' 
								</div>
							</div>
							';
			if (!empty($catatan)) {
				$hasil .= '
										<div class="col-md-12">
											<div class="alert alert-warning" role="alert">
												' . $catatan . '
											</div> 
										</div>
										';
			} else {
				$hasil .= '';
			}

			$hasil .= '
						</div>
					' . $analisa_identifikasi . '
					</div>
				</div>
			';
		} else {
			$fu_tipe_doc_detil = '';
			$hasil .= '
				<div class="card mb-4">
					<div class="card-body">
						
						<div class="row">
							<div class="col-md-12">
								<h6 class="card-title">' . $get_urut . '</h6>
							</div>
							<div class="col-md-6">
								<div class="alert alert-info" role="alert">
									- Jenis kebutuhan : ' . $fu_kebutuhan . ' <br/>
									- Jenis Dokumen : ' . $fu_tipe_doc_detil . ' <br/>
									' . $perlu . '
								</div> 
							</div>
							<div class="col-md-6">
							' . $form_unggah . '
								<div class="row justify-content-end">
									<div class="col-md-4">
										' . $tombol_dokumen . '
										' . $tombol_reviu . ' 
									</div> 
								</div>
							</div>
								';
			if (!empty($catatan)) {
				$hasil .= '
						<div class="col-md-12">
							<div class="alert alert-warning" role="alert">
								' . $catatan . '
							</div> 
						</div>
						';
			} else {
				$hasil .= '';
			}

			$hasil .= '
							</div>
						' . $analisa_identifikasi . '
					</div>
				</div>
			';
		}

		return $hasil;
	}

	public function tindak_lanjut()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			$datax['list_kode_survey'] =  list_dropdown('gcg_surveyor', array('kode_survey', 'kode_survey'), array('status_survey' => 1));
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();
			$datax['list_divisi'] =  $this->gcgm->list_v_gcg_divisi();

			$this->load->view('gcg/tindak_lanjut', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function tabel_tindak_lanjut()
	{
		$data = array();
		$kode_survey = $this->input->post('kode');
		$i = 1;
		$hasil = $this->gcgm->result_v_gcg_transaksi_aoi_kode_survey($kode_survey);
		foreach ($hasil as $r) {
			$pic=$this->gcgm->row_tabel('gcg_master_fu', array("kode_fu"=>$r->kode_fu), 'pic');
			$pic=$this->gcgm->row_tabel('master_org_divisi', array("kode"=>$pic), 'uraian');
			$row = array();
			$row[] = $i;
			$row[] = $r->kode_fu;
			$row[] = $r->pertanyaan;
			$row[] = $r->rekomendasi;
			// $row[] = $r->jawaban;
			$row[] = ($r->jawaban == '') ? 'Belum' : $r->jawaban;
			$row[] = $pic;
			$row[] = '<button type="button" class="btn btn-info" onclick="tampil_tindak_lanjut(' . "'" . $r->id .  "'" . ')" title="Aksi"><i class="fas fa-edit"></i></button>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function get_tindak_lanjut()
	{
		$kode = $this->input->post('kode');
		$data['aoi'] = $this->gcgm->result_v_gcg_transaksi_aoi_id($kode);
		$pic=$this->gcgm->row_tabel('gcg_master_fu', array("kode_fu"=>$data['aoi'][0]->kode_fu), 'pic');
		$pic=$this->gcgm->row_tabel('master_org_divisi', array("kode"=>$pic), 'uraian');
		$data['pic'] = $pic;
		echo json_encode($data);
	}

	public function tabel_file_tindak_lanjut()
	{
		$data = array();
		$kode = $this->input->post('kode');
		$i = 1;
		$hasil = $this->gcgm->result_gcg_transaksi_aoi_file_id($kode);
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = '<a type="button" class="btn btn-outline-info" href="' . base_url() . 'assets/file/gcg/' . $r->doc_file . '" target="_blank" title="Download data ?"><i class="fas fa-file"></i> ' . $r->nama_doc . '</a>';
			$row[] = $r->keterangan_file;
			$row[] = $r->waktu_update;
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function simpan_tindak_lanjut()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();

		$id = $this->input->post('kode');
		$kode_survey = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_survey');
		$kode_fu = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_fu');

		$data['jawaban'] = $this->input->post('jawaban');
		$data['status_tindak_lanjut'] = '1';
		$data['user_update'] = $this->session->userdata('nama');
		$data['waktu_update'] = $sekarang;

		$this->menum->update("gcg_transaksi_aoi", array("kode_survey" => $kode_survey, "kode_fu" => $kode_fu), $data);
		$output = array(
			"status" => TRUE,
		);
		echo json_encode($output);
	}

	public function simpan_tindak_lanjut_file()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$datax = array();

		$id = $this->input->post('kode');
		$kode_survey = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_survey');
		$kode_fu = $this->gcgm->row_v_gcg_transaksi_aoi_id($id, 'kode_fu');

		$data['kode_survey'] = $kode_survey;
		$data['kode_fu'] = $kode_fu;
		$data['nama_doc'] = $_FILES['dokumen_file']['name'];
		$data['keterangan_file'] = $this->input->post('keterangan_file');
		$data['status_file'] = '1';
		$data['waktu_update'] = $sekarang;
		$data['user_update'] = $this->session->userdata('nama');

		if (!empty($_FILES['dokumen_file']['name'])) {
			$upload = $this->cek_berkas('dokumen_file');
			$data['doc_file'] = $upload;
		}

		$this->menum->save("gcg_transaksi_aoi_file", $data);
		$output = array(
			"status" => TRUE,
		);
		echo json_encode($output);
	}

	public function hasil_tindak_lanjut()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			// $datax['list_kode_survey'] =  $this->gcgm->list_gcg_transaksi();
			$datax['list_kode_survey'] =  list_dropdown('gcg_surveyor', array('kode_survey', 'kode_survey'), array('status_survey' => 1));
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();
			$datax['list_divisi'] =  $this->gcgm->list_v_gcg_divisi();

			$this->load->view('gcg/hasil_tindak_lanjut', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function status_dokumen()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			$datax['list_kode_survey'] =  $this->gcgm->list_gcg_transaksi();
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();

			$periode = $this->gcgm->last_gcg_master_periode();
			$kode_divisi = $this->session->userdata('kode_gcg');
			$datax['divisi'] = $this->gcgm->get_gcg_uraian_divisi($kode_divisi);
			$datax['periode'] = $periode;
			$datax['list_filter'] = array(
				"semua" => "Semua",
				"Ada" => "Ada Dokumen",
				"Belum-Ada" => "Belum Ada Dokumen"
			);
			$datax['filter'] = 'test';
			$datax['terpilih'] = $periode;
			//$datax['tabel_hasil_status_dokumen'] = $this->gcg_tabel_hasil_status_dokumen($periode);
			$datax['kebutuhan_dokumen'] = $this->gcgm->list_dropdown('gcg_tipe_doc', array('kode_doc', 'type_doc'), 'all', 'Dokumen ');
			$datax['kebutuhan'] = array(
				"doc" => "Dokumen",
				"inf" => "Informasi"
			);
			$this->load->view('gcg/status_dokumen', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function tabel_modal_dokumen_status()
	{
		$data = array();
		$kode=$this->input->post('kode');
		$tipe = 'dokumen';
		$i = 1;
		$periode = $this->gcgm->last_gcg_master_periode();
		$hasil = $this->gcgm->result_gcg_master_file_periode_kode($periode, $kode, $tipe);
					
		foreach ($hasil as $r) {
			$aksi = '<a type="button" id="btndetil" class="btn btn-outline-info" data-toggle="modal" data-target="#modal_dokumen" data-id="<?=$x;?>" onclick="load_view_form_new(' . "'" . $r->id .  "'" . ')"  title="Klik untuk melihat detail dokumen">' . $r->nama_doc . " " . '<i class="fa fa-eye"></i></a>';
			$row = array();
			$row[] = $i;
			// $row[] = '<a type="button" class="btn btn-outline-info" href="' . base_url() . 'assets/file/gcg/' . $r->doc_file . '" target="_blank" title="Download data ?"><i class="fas fa-file"></i> ' . $r->nama_doc . '</a>' . $aksi;
			$row[] = $aksi;
			$row[] = $r->keterangan_file;
			// $row[] = $r->waktu_update;
			$row[] = '<a type="button" class="btn yellow" onclick="delete_files(' . "'" . $r->id .  "'" . ')"  title="Delete Files"><i class="fa fa-trash"></i></a>';
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function load_form_data_new()
	{
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result_gcg_status_dokumen($periode, $kode_divisi);
		$x = 1;
		$id = $this->input->post('id');
		$nama_doc = $this->gcgm->row_tabel('gcg_master_fu_file',array('id'=>$id),'nama_doc');
		$doc_file = $this->gcgm->row_tabel('gcg_master_fu_file',array('id'=>$id),'doc_file');
		$hasil['nama_doc'] = $nama_doc;
		$hasil['file_doc'] = $doc_file;
		//var_dump($hasil);
		echo json_encode([$hasil]);
	}
	public function tabel_hasil_survey_tidak_sesuai(){
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result('gcg_transaksi_fu',array('kode_survey'=>$periode,'status_uji'=>'1','status_survey'=>'1','hasil_survey'=>'0'));
		$x=1;
		$data = array();
		foreach ($group as $r) {
			$row = array();
			$row[] = $x;
			$row[] = $r->kode_fu;
			$row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'pertanyaan');
			// $row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'kebutuhan');
			// $kode_doc = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'tipe_doc');
			// $row[] = $this->gcgm->row_tabel('gcg_tipe_doc',array('kode_doc'=>$kode_doc),'type_doc');
			$row[] = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'doc_dibutuhkan_1');
			$kode_pic = $this->gcgm->row_tabel('gcg_master_fu',array('periode'=>$periode,'kode_fu'=>$r->kode_fu),'pic');
			$row[] = $this->gcgm->row_tabel('master_org_divisi',array('kode'=>$kode_pic),'uraian');
			$sts_doc = $this->gcgm->row_gcg_status_dokumen_kode($periode, $r->kode_fu);
			$row[] = $sts_doc;
			$row[] = $r->analisa_kekuatan ==''?'-':$r->analisa_kekuatan;
			$row[] = $r->analisa_kelemahan ==''?'-':$r->analisa_kelemahan;
			$row[] = $r->identifikasi_hambatan ==''?'-':$r->identifikasi_hambatan;
			$row[] = $r->identifikasi_rekomendasi ==''?'-':$r->identifikasi_rekomendasi;
			$row[] = $r->kode_fu=='1'? 'Sesuai' : 'Tidak Sesuai';
			$data[] = $row;
			$x++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_master_gcg_status_dokumen($filter = '')
	{
		//$filter=$this->input->post('filter');
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		$kode_div='';
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		if ($kode_divisi == 'auditor'){
			$kode_div = 'auditor';
			$kode_divisi = ''; 
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result_gcg_status_dokumen($periode, $kode_divisi);
		$x = 1;
		$y = 1;
		$data = array();
		foreach ($group as $r) {
			$aksi = '';
			$pic = '';
			$status_uji = $this->gcgm->get_status_uji($r->kode_fu);
			if ($status_uji == '0') {
				$danger = 'style="color:red;"';
				$aksi  = 'Tidak diujikan';
			} else {
				if ($r->status_dokumen == 'Ada') {
					// tabel_modal_dokumen(kode)
					$aksi .= '<a type="button" id="btnview" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalView" data-id="<?=$x;?>" onclick="tabel_modal_dokumen_status(' . "'" . $r->kode_fu .  "'" . ')"  title="Lihat Detail"><i class="fa fa-eye"></i></a>';
					/*
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalUpload" data-id="<?=$x;?>" onclick="load_upload_form(' . "'" . $x .  "'" . ')"  title="Upload Dokumen"><i class="fa fa-upload"></i></a>';
					*/
				} else {
					/*
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalUpload" data-id="<?=$x;?>" onclick="load_upload_form(' . "'" . $x .  "'" . ')"  title="Upload Dokumen"><i class="fa fa-upload"></i></a>';
					*/
				}
			}
			if ($kode_divisi == '') {
				if ($status_uji == '1') {
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit" data-id="<?=$x;?>" onclick="load_edit_form(' . "'" . $x .  "'" . ')"  title="Edit"><i class="fa fa-edit"></i></a>';
				}
				$pic_s = $this->gcgm->get_gcg_uraian_divisi($r->pic);
				$pic = $pic_s;
			}
			$row = array();
			if ($kode_div == 'auditor'){
				if($r->status_dokumen == 'Ada'){
					$aksi = '<a type="button" id="btnview" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalView" data-id="<?=$x;?>" onclick="tabel_modal_dokumen_status(' . "'" . $r->kode_fu .  "'" . ')"  title="Lihat Detail"><i class="fa fa-eye"></i></a>';
				}else{
					$aksi = '-';
				}
			}
			if ($r->status_dokumen == 'Belum-Ada') {
				$sd = 'Belum Ada';
			} else {
				$sd = $r->status_dokumen;
			}
			if ($filter == "semua" or $filter == "") {
				$row[] = $x;
				$row[] = $r->kode_fu;
				$row[] = $r->pertanyaan;
				$row[] = $r->kebutuhan_dokumen;
				$row[] = $r->dokumen_yang_dibutuhkan;
				$row[] = $sd;
				if ($kode_divisi == '' or $kode_div=='auditor') {
					$row[] = $pic;
				}
				$row[] = $aksi;
				$data[] = $row;
				$x++;
			} else {
				if ($filter == $r->status_dokumen) {
					$row[] = $y;
					$row[] = $r->kode_fu;
					$row[] = $r->pertanyaan;
					$row[] = $r->kebutuhan_dokumen;
					$row[] = $r->dokumen_yang_dibutuhkan;
					$row[] = $sd;
					if ($kode_divisi == '' or $kode_div=='auditor') {
						$row[] = $pic;
					}
					$row[] = $aksi;
					$data[] = $row;
					$y++;
				}
				$x++;
			}
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function tabel_master_gcg_status_dokumenx($filter = '')
	{
		//$filter=$this->input->post('filter');
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result_gcg_status_dokumen($periode, $kode_divisi);
		$x = 1;
		$y = 1;
		$data = array();
		foreach ($group as $r) {
			$aksi = '';
			$pic = '';
			$status_uji = $this->gcgm->get_status_uji($r->kode);
			if ($status_uji == '0') {
				$danger = 'style="color:red;"';
				$aksi  = 'Tidak diujikan';
			} else {
				if ($r->status_dokumen == 'Ada') {
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalView" data-id="<?=$x;?>" onclick="load_view_form(' . "'" . $x .  "'" . ')"  title="Lihat Detail"><i class="fa fa-eye"></i></a>';
				} else {
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalUpload" data-id="<?=$x;?>" onclick="load_upload_form(' . "'" . $x .  "'" . ')"  title="Upload Dokumen"><i class="fa fa-upload"></i></a>';
				}
			}
			if ($kode_divisi == '') {
				if ($status_uji == '1') {
					$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit" data-id="<?=$x;?>" onclick="load_edit_form(' . "'" . $x .  "'" . ')"  title="Edit"><i class="fa fa-edit"></i></a>';
				}
				$pic_s = $this->gcgm->get_gcg_uraian_divisi($r->pic);
				$pic = $pic_s;
			}
			$row = array();

			if ($r->status_dokumen == 'Belum-Ada') {
				$sd = 'Belum Ada';
			} else {
				$sd = $filter;
			}
			if ($filter == "semua" or $filter == "") {
				$row[] = $x;
				$row[] = $r->kode_fu;
				$row[] = $r->pertanyaan;
				$row[] = $r->kebutuhan_dokumen;
				$row[] = $r->dokumen_yang_dibutuhkan;
				$row[] = $sd;
				$row[] = $pic;
				$row[] = $aksi;
				$data[] = $row;
				$x++;
			} else {
				if ($filter == $r->status_dokumen) {
					$row[] = $y;
					$row[] = $r->kode_fu;
					$row[] = $r->pertanyaan;
					$row[] = $r->kebutuhan_dokumen;
					$row[] = $r->dokumen_yang_dibutuhkan;
					$row[] = $sd;
					$row[] = $pic;
					$row[] = $aksi;
					$data[] = $row;
					$y++;
				}
				$x++;
			}
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function load_form_data()
	{
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result_gcg_status_dokumen($periode, $kode_divisi);
		$x = 1;
		$id = $this->input->post('id');
		foreach ($group as $s) {
			if ($x == $id) {
				$hasil = $s;
			}
			$x++;
		}
		$hasil->nama_doc = $this->gcgm->get_nama_doc($hasil->kode_fu);
		$hasil->file_doc = $this->gcgm->get_doc_file($hasil->kode_fu);
		//var_dump($hasil);
		echo json_encode([$hasil]);
	}

	public function upload()
	{
		if (!empty($_FILES['doc_file']['name'])) {
			$filter = $this->input->post('filter_upload');
			switch ($filter) {
				case "Semua":
					$data_filter = "semua";
					break;
				case "Belum Ada Dokumen":
					$data_filter = "Belum-Ada";
					break;
				case "Ada Dokumen":
					$data_filter = "Ada";
					break;
			}
			date_default_timezone_set('Asia/Jakarta');
			$sekarang = date('Y-m-d H:i:s');
			set_time_limit(0);
			$data = array();
			$datax = array();

			$kode = $this->input->post('kode');
			$periode = $this->input->post('periode');
			$cek_tipe = $this->gcgm->row_gcg_master_periode_kode($periode, $kode, 'kebutuhan');
			if ($cek_tipe) {
				# ada
				$data['tipe'] = $cek_tipe;
			} else {
				# tidak ada
				$data['tipe'] = '-';
			}

			$data['periode'] = $periode;
			$data['kode_fu'] = $kode;
			$data['nama_doc'] = $_FILES['doc_file']['name'];
			$data['keterangan_file'] = $this->input->post('keterangan');
			$data['status_file'] = '1';
			$data['waktu_update'] = $sekarang;
			$data['user_update'] = $this->session->userdata('nama');

			if (!empty($_FILES['doc_file']['name'])) {
				$upload = $this->cek_berkas('doc_file');
				$data['doc_file'] = $upload;
			}
			$this->menum->save("gcg_master_fu_file", $data);
			echo "
			<script type='text/javascript'>
			alert('Upload File Berhasil !');
			</script>";
			header('location:' . base_url() . 'gcg/status_dokumen/' . $data_filter);
		} else {
			echo "
			<script type='text/javascript'>
			alert('Upload File Gagal, pilihan file kosong !');
			history.back(self);
			</script>";
		}
		//alert('Upload File Selesai');
	}

	public function edit()
	{
		$filter = $this->input->post('filter_edit');
		switch ($filter) {
			case "Semua":
				$data_filter = "semua";
				break;
			case "Belum Ada Dokumen":
				$data_filter = "Belum-Ada";
				break;
			case "Ada Dokumen":
				$data_filter = "Ada";
				break;
		}
		date_default_timezone_set('Asia/Jakarta'); 
		$sekarang = date('Y-m-d H:i:s');
		set_time_limit(0);
		$data = array();
		$datax = array();
		$kode = $this->input->post('kode_edit');
		$tipe_doc = $this->input->post('kebutuhan_edit');
		$doc_dibutuhkan_1 = $this->input->post('kebutuhan_doc_edit');
		$status_uji = $this->input->post('status_uji_edit');
		// $pertanyaan = $this->input->post('pertanyaan_edit');
		$pic = $this->input->post('pic_edit');
		$periode = $this->gcgm->last_gcg_master_periode();
		$status_uji_lama = $this->gcgm->row_tabel('gcg_master_fu',array('kode_fu' => $kode,'periode'=>$periode),'status_uji');
		// var_dump($status_uji);
		// if($status_uji != $status_uji_lama){ 
		// 	// var_dump($status_uji_lama);
		// 	// var_dump($periode);
		// 	$this->gcgm->update_status_uji('fu', $kode, $status_uji);
		// }
		$this->menum->update(
			"gcg_master_fu",
			array('kode_fu' => $kode,'periode'=>$periode),
			array(
				"tipe_doc" => $tipe_doc,
				"doc_dibutuhkan_1" => $doc_dibutuhkan_1,
				"pic"=> $pic
				// "status_uji" => $status_uji
			)
		);
		// if (!empty($_FILES['doc_file']['name'])) {
		// 	$periode = $this->input->post('periode');
		// 	$cek_tipe = $this->gcgm->row_gcg_master_periode_kode($periode, $kode, 'kebutuhan');
		// 	if ($cek_tipe) {
		// 		# ada
		// 		$data['tipe'] = $cek_tipe;
		// 	} else {
		// 		# tidak ada
		// 		$data['tipe'] = '-';
		// 	}
		// 	$data['periode'] = $periode;
		// 	$data['kode'] = $kode;
		// 	$data['nama_doc'] = $_FILES['doc_file']['name'];
		// 	$data['keterangan_file'] = $this->input->post('keterangan');
		// 	$data['status_file'] = '1';
		// 	$data['waktu_update'] = $sekarang;
		// 	$data['user_update'] = $this->session->userdata('nama');

		// 	if (!empty($_FILES['doc_file']['name'])) {
		// 		$upload = $this->cek_berkas('doc_file');
		// 		$data['doc_file'] = $upload;
		// 	}
		// 	$this->menum->save("gcg_master_fu_file", $data);
		// }
		header('location:' . base_url() . 'gcg/status_dokumen/');
	}

	public function master_gcg()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);

			$datax['list_kode_survey'] =  $this->gcgm->list_gcg_transaksi();
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();

			$periode = $this->gcgm->last_gcg_master_periode();
			$kode_divisi = $this->session->userdata('kode_gcg');
			$datax['divisi'] = $this->gcgm->get_gcg_uraian_divisi($kode_divisi);
			$datax['periode'] = $periode;

			$datax['terpilih'] = $periode;
			$datax['tabel_aspek'] = $this->gcg_tabel_hasil_master_gcg('aspek');
			$datax['tabel_indikator'] = $this->gcg_tabel_hasil_master_gcg('indikator');
			$datax['tabel_parameter'] = $this->gcg_tabel_hasil_master_gcg('parameter');
			$datax['tabel_fu'] = $this->gcg_tabel_hasil_master_gcg('fu');
			$datax['kebutuhan_dokumen'] = $this->gcgm->list_dropdown('gcg_tipe_doc', array('kode_doc', 'type_doc'), 'all', 'Dokumen ');
			$this->load->view('gcg/master_gcg', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}
	public function gcg_tabel_hasil_master_gcg($filter)
	{
		$group = $this->gcgm->result_gcg_master_gcg($filter);
		$x = 1;
		$y = 1;
		$hasil = '';
		foreach ($group as $s) {
			$val;
			$kode_survey=$this->gcgm->last_gcg_transaksi_kode_survey();
			$v = $this->gcgm->row('gcg_master_fu',array('periode'=>$kode_survey,'kode_fu'=>$s->kode),'status_uji');
			$val[0] = $v=='1' ? 'Diujikan' : 'Tidak Diujikan';
			$val[1] = $v=='0' ? 'Diujikan' : 'Tidak Diujikan';
			
			$dropdown = '
			<select class="form-control" id="' . $filter . '" name="' . $filter . '">
				<option value="' . $val[0] . '">' . $val[0] . '</option>
				<option value="' . $val[1] . '">' . $val[1] . '</option>
			</select>			
			';
			$aksi = '';
			$pic = '';
			$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit" data-id="<?=$x;?>" onclick="load_edit_form(' . "'" . $x .  "'" . ')"  title="Edit"><i class="fa fa-edit"></i></a>';
			$hasil .= '
					<tr>
						<td class="align-middle">' . $s->kode . '</td>
						<td class="align-middle">' . $s->uraian . '</td>
						<td class="align-middle text-center">' . $dropdown . '</td>
					</tr>
					';
			$x++;
		}
		return $hasil;
	}

	public function tabel_master_gcg_aspek()
	{
		$data = array();
		$i = 1;
		$filter = 'aspek';
		$hasil = $this->gcgm->result_gcg_master_gcg($filter);
		$list = $this->gcgm->list_status_uji();
		foreach ($hasil as $r) {
			$status_uji = $r->status_uji;
			$row = array();
			$row[] = $r->kode;
			$row[] = $r->uraian;
			$row[] = form_dropdown("klasifikasi", $list, $status_uji, 'id="klasifikasi" onchange="edit_status_uji(' . "'aspek','" . $r->kode .  "',$(this).val()" . ')" style="width:100%; " class="form-control" ');
			$data[] = $row;
			$i++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function tabel_master_gcg_indikator()
	{
		$data = array();
		$i = 1;
		$filter = 'indikator';
		$hasil = $this->gcgm->result_gcg_master_gcg($filter);
		$list = $this->gcgm->list_status_uji();
		foreach ($hasil as $r) {
			$disabled = '';
			$status_uji_aspek = $this->gcgm->cek_na('aspek', $r->kode);
			if ($status_uji_aspek == '0') {
				$disabled = 'disabled';
			}
			$status_uji = $r->status_uji;
			$row = array();
			$row[] = $r->kode;
			$row[] = $r->uraian;
			$row[] = form_dropdown("klasifikasi", $list, $status_uji, 'id="klasifikasi" onchange="edit_status_uji(' . "'indikator','" . $r->kode .  "',$(this).val()" . ')" style="width:100%; " class="form-control" ' . $disabled . '');
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function tabel_master_gcg_parameter()
	{
		$data = array();
		$i = 1;
		$filter = 'parameter';
		$hasil = $this->gcgm->result_gcg_master_gcg($filter);
		$list = $this->gcgm->list_status_uji();
		foreach ($hasil as $r) {
			$disabled = '';
			$status_uji_aspek = $this->gcgm->cek_na('indikator', $r->kode);
			if ($status_uji_aspek == '0') {
				$disabled = 'disabled';
			}
			$status_uji = $r->status_uji;
			$row = array();
			$row[] = $r->kode;
			$row[] = $r->uraian;
			$row[] = form_dropdown("klasifikasi", $list, $status_uji, 'id="klasifikasi" onchange="edit_status_uji(' . "'parameter','" . $r->kode .  "',$(this).val()" . ')" style="width:100%; " class="form-control" ' . $disabled . '');
			$data[] = $row;
			$i++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function tabel_master_gcg_fu()
	{
		$data = array();
		$i = 1;
		$filter = 'fu';
		$hasil = $this->gcgm->result_gcg_master_gcg($filter);
		$list = $this->gcgm->list_status_uji();
		foreach ($hasil as $r) {
			$disabled = '';
			$status_uji_aspek = $this->gcgm->cek_na('parameter', $r->kode);
			if ($status_uji_aspek == '0') {
				$disabled = 'disabled';
			}
			$status_uji = $r->status_uji;
			$row = array();
			$row[] = $r->kode;
			$row[] = $r->uraian;
			$row[] = form_dropdown("klasifikasi", $list, $status_uji, 'id="klasifikasi" onchange="edit_status_uji(' . "'fu','" . $r->kode .  "',$(this).val()" . ')" style="width:100%; " class="form-control" ' . $disabled . '');
			$data[] = $row;
			$i++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}

	public function edit_status_uji()
	{
		$parameter = $this->input->post('parameter');
		$kode = $this->input->post('kode');
		$nilai = $this->input->post('nilai');
		$this->gcgm->update_status_uji($parameter, $kode, $nilai);
		$data_all['status'] = TRUE;
		echo json_encode($data_all);
	}

	public function get_mac_ip()
	{
		$_IP_ADDRESS = $_SERVER['REMOTE_ADDR'];
		$_PERINTAH = "arp -a $_IP_ADDRESS";
		ob_start();
		system($_PERINTAH);
		$_HASIL = ob_get_contents();
		// ob_clean();
		// $_PECAH = strstr($_HASIL, $_IP_ADDRESS);
		// $_PECAH_STRING = explode($_IP_ADDRESS, str_replace(" ", "", $_PECAH));
		// $_HASIL = substr($_PECAH_STRING[1], 0, 17);
		echo "IP Anda : " . $_IP_ADDRESS . "
		MAC ADDRESS Anda : " . $_HASIL;
	}
	public function penetapan_dokumen($filter = '')
	{
		//$filter=$this->input->post('filter');
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->penetapan($periode, $kode_divisi);
		$x = 1;
		$y = 1; 
		$data = array();
		foreach ($group as $r) {
			$aksi = '';
			$pic = '';
			$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit_Status_uji" data-id="<?=$x;?>" onclick="load_edit_status_uji_form(' . "'" . $r->kode_fu .  "'" . ')"  title="Edit"><i class="fa fa-edit"></i></a>';
			$row = array();
			$row[] = $x;
			$row[] = $r->kode_fu;
			$row[] = $r->pertanyaan;
			$row[] = $r->kebutuhan_dokumen;
			$row[] = $r->tipe_dokumen;
			$row[] = $r->dokumen_yang_dibutuhkan;
			// $row[] = $r->status_uji;
			if ($kode_divisi == '') {
				$row[] = $r->pic;
				$row[] = $aksi;
			}
			$data[] = $row;
			$x++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_master_gcg_status_faktor_uji($filter = '')
	{
		//$filter=$this->input->post('filter');
		$hasil = '';
		$kode_divisi = $this->session->userdata('kode_gcg');
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$group = $this->gcgm->result_gcg_status_faktor_uji($periode, $kode_divisi);
		$x = 1;
		$y = 1;
		$data = array();
		foreach ($group as $r) {
			$aksi = '';
			$pic = '';
			$aksi .= '<a type="button" id="btndetil" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit_Status_uji" data-id="<?=$x;?>" onclick="load_edit_status_uji_form(' . "'" . $r->kode_fu .  "'" . ')"  title="Edit"><i class="fa fa-edit"></i></a>';
			$row = array();
			$row[] = $x;
			$row[] = $r->kode_fu;
			$row[] = $r->pertanyaan;
			$row[] = $r->kebutuhan_dokumen;
			$row[] = $r->tipe_dokumen;
			$row[] = $r->dokumen_yang_dibutuhkan;
			// $row[] = $r->status_uji;
			if ($kode_divisi == '') {
				$row[] = $r->pic;
				$row[] = $aksi;
			}
			$data[] = $row;
			$x++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function load_form_data_status_uji()
	{
		$hasil;
		$kode_divisi = $this->session->userdata('kode_gcg'); 
		if ($kode_divisi == 'admin') {
			$kode_divisi = '';
		}
		$periode = $this->gcgm->last_gcg_master_periode();
		$kode = $this->input->post('id');
		$hasil = $this->gcgm->result_gcg_status_uji($periode, $kode_divisi, $kode);
		// $hasil->nama_doc = $this->gcgm->get_nama_doc($hasil->kode);
		// $hasil->file_doc = $this->gcgm->get_doc_file($hasil->kode);
		// var_dump($hasil);
		echo json_encode($hasil);
	}
	public function list_dropdown()
	{
		$parameter = $this->input->post('param');
		$data = array();
		$data[0]['id'] = "-";
		$data[0]['uraian'] = "--Pilih--";
		if ($parameter == 'kebutuhan_edit_status_uji') {
			$data[1]['id'] = "doc";
			$data[1]['uraian'] = "Dokumen";
			$data[2]['id'] = "inf";
			$data[2]['uraian'] = "Informasi";
		} else if ($parameter == 'status_uji_edit'){
			$data[1]['id'] = "0";
			$data[1]['uraian'] = "Tidak Diujikan (N/A)";
			$data[2]['id'] = "1";
			$data[2]['uraian'] = "Diujikan";
		} else if ($parameter == 'kebutuhan_doc_edit_status_uji' or $parameter == 'kebutuhan_edit') {
			$val = $this->gcgm->list_dropdown_result('gcg_tipe_doc', array('kode_doc', 'type_doc'), 'all', 'Dokumen ');
			for($i = 0; $i < count($val); $i++){
				array_push($data,$val[$i]);
			}
			
		} else if ($parameter == 'info_pilihan_status_uji') {
			$data[1]['id'] = "Ya";
			$data[1]['uraian'] = "Ya";
			$data[2]['id'] = "Tidak";
			$data[2]['uraian'] = "Tidak";
		} else if ($parameter == 'dropdown_jabatan' or $parameter == 'dropdown_jabatan_edit') {
			$val = $this->gcgm->list_dropdown_result('master_org_jabatan', array('kode', 'nama_jabatan'), 'all', '');
			for($i = 0; $i < count($val); $i++){
				array_push($data,$val[$i]);
			}
		} else if ($parameter == 'dropdown_divisi' or $parameter == 'pic_edit' or $parameter == 'pic_edit_status_uji') {
			$val = $this->gcgm->list_dropdown_result('master_org_divisi', array('kode', 'nama_divisi'), 'all', '');
			for($i = 0; $i < count($val); $i++){
				if($val[$i]->id!='ADM'){
					array_push($data,$val[$i]);
				}
			}
		} else if ($parameter == 'dropdown_type_user') {
			// $data[1]['id'] = 1;
			// $data[1]['uraian'] = "Admin";
			$data[2]['id'] = 2;
			$data[2]['uraian'] = "User";
			$data[3]['id'] = 3;
			$data[3]['uraian'] = "Tamu";
		} else if ($parameter == 'dropdown_status_user') {
			$data[1]['id'] = "1";
			$data[1]['uraian'] = "Aktif";
			$data[2]['id'] = "0";
			$data[2]['uraian'] = "Tidak Aktif";
		} else if ($parameter == 'dropdown_direktorat' or $parameter == 'dropdown_direktorat_edit'){
			$val = $this->gcgm->list_dropdown_result('master_org_direktorat', array('kode', 'nama_direktorat'), 'all', '');
			for($i = 0; $i < count($val); $i++){
				array_push($data,$val[$i]);
			}
		} else if ($parameter == 'dropdown_divisi_edit') {
			$val = $this->gcgm->list_dropdown_result('master_org_divisi', array('kode', 'nama_divisi'), 'all', '');
			for($i = 0; $i < count($val); $i++){
				array_push($data,$val[$i]);
			}
		} else if ($parameter == 'dropdown_type_user_edit') {
			$data[1]['id'] = 1;
			$data[1]['uraian'] = "Admin";
			$data[2]['id'] = 2;
			$data[2]['uraian'] = "User";
			$data[3]['id'] = 3;
			$data[3]['uraian'] = "Tamu";
		} else if ($parameter == 'dropdown_status_user_edit') {
			$data[1]['id'] = "1";
			$data[1]['uraian'] = "Aktif";
			$data[2]['id'] = "0";
			$data[2]['uraian'] = "Tidak Aktif";
		}
		echo json_encode($data);
	}
	public function edit_status_uji_baru_penetapan()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		$kode = $this->input->post('kode_edit_status_uji');
		$kebutuhan = $this->input->post('kebutuhan_edit_status_uji');
		$tipe_doc = $this->input->post('kebutuhan_doc_edit_status_uji');
		$doc_dibutuhkan_1 = $this->input->post('nama_doc_edit_status_uji');
		$pic = $this->input->post('pic_edit_status_uji');
		$user_update = $this->session->userdata('nama');
		$perlu_doc = '';
		if ($kebutuhan == 'doc') {
			$kebutuhan = 'Dokumen';
			$perlu_doc = '1';
		} else if ($kebutuhan == 'inf') {
			$kebutuhan = 'Informasi';
			$perlu_doc = '0';
		}
		$this->menum->update(
			"gcg_master_fu",
			array('kode_fu' => $kode),
			array(
				"kebutuhan" => $kebutuhan,
				"perlu_doc" => $perlu_doc,
				"tipe_doc" => $tipe_doc,
				"doc_dibutuhkan_1" => $doc_dibutuhkan_1,
				"pic" => $pic,
				"waktu_update" => $sekarang,
				"user_update" => $user_update
			)
		);
		header('location:' . base_url() . 'gcg/master_penetapan/');
	}
	public function edit_status_uji_baru()
	{
		date_default_timezone_set('Asia/Jakarta');
		$sekarang = date('Y-m-d H:i:s');
		$kode = $this->input->post('kode_edit_status_uji');
		$kebutuhan = $this->input->post('kebutuhan_edit_status_uji');
		$tipe_doc = $this->input->post('kebutuhan_doc_edit_status_uji');
		$doc_dibutuhkan_1 = $this->input->post('nama_doc_edit_status_uji');
		$pic = $this->input->post('pic_edit_status_uji');
		$user_update = $this->session->userdata('nama');
		$perlu_doc = '';
		if ($kebutuhan == 'doc') {
			$kebutuhan = 'Dokumen';
			$perlu_doc = '1';
		} else if ($kebutuhan == 'inf') {
			$kebutuhan = 'Informasi';
			$perlu_doc = '0';
		}
		$this->menum->update(
			"gcg_master_fu",
			array('kode_fu' => $kode),
			array(
				"kebutuhan" => $kebutuhan,
				"perlu_doc" => $perlu_doc,
				"tipe_doc" => $tipe_doc,
				"doc_dibutuhkan_1" => $doc_dibutuhkan_1,
				"pic" => $pic,
				"waktu_update" => $sekarang,
				"user_update" => $user_update
			)
		);
		header('location:' . base_url() . 'gcg/status_dokumen/');
	}

	public function tabel_rekap_status_dokumen()
	{
		$data = array();
		$i = 1;
		$hasil = $this->gcgm->result_v_gcg_master_fu_divisi();
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->nama_pic;
			$row[] = $r->jlh_all;
			$row[] = $r->jlh_info;
			$row[] = $r->jlh_dok;
			$row[] = $r->jlh_dok_ada;
			$row[] = $r->jlh_dok_belum;
			// $row[] = $r->jlh_tdk_uji;
			// $row[] = $r->jlh_kosong;
			$data[] = $row;
			$i++;
		}

		$output = array(
			"data" => $data,
		); 
		echo json_encode($output);
	}

	public function master_direktorat()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$this->load->view('gcg/master_direktorat');
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function master_divisi()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$this->load->view('gcg/master_divisi');
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function master_user()
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$this->load->view('gcg/master_user');
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}

	public function tabel_master_gcg_direktorat()
	{
		$data = array();
		$hasil = $this->gcgm->result_v_gcg_master_direktorat();
		$i = 1;
		$aksi = '';
		foreach ($hasil as $r) {
			$row = array();
			$row[] = $i;
			$row[] = $r->kode;
			$row[] = $r->nama_direktorat;
			$row[] = '
					<div class="row">
					<a type="button" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit_direktorat" data-id="<?=$i;?>" onclick="load_form_edit_direktorat(' . "'" . $r->id .  "'" . ')"  title="Edit Data Direktorat"><i class="fa fa-edit"></i></a>
					<a type="button" class="btn yellow" onclick="delete_direktorat(' . "'" . $r->id .  "'" . ')"  title="Delete Direktorat"><i class="fa fa-trash"></i></a>
					<div>
					';
			$data[] = $row;
			$i++;
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_master_gcg_divisi()
	{
		$parameter = $this->input->post('param');
		$data = array();
		$hasil = $this->gcgm->result_v_gcg_master_divisi();
		$i = 1;
		$aksi = '';
		foreach ($hasil as $r) {
			$row = array();
			if($r->kode!='ADM'){
				$row[] = $i;
				$row[] = $r->kode;
				$row[] = $r->nama_divisi;
				$row[] = '
						<div class="row">
						<a type="button" class="btn yellow tampilModalDetil" data-toggle="modal" data-target="#formModalEdit_divisi" data-id="<?=$i;?>" onclick="load_edit_form_edit_divisi(' . "'" . $r->id .  "'" . ')"  title="Edit Data Divisi"><i class="fa fa-edit"></i></a>
						<a type="button" class="btn yellow" onclick="delete_divisi(' . "'" . $r->id .  "'" . ')"  title="Delete Divisi"><i class="fa fa-trash"></i></a>
						<div>
						';
				$data[] = $row;
				$i++;
			}
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function tabel_master_gcg_user()
	{
		$parameter = $this->input->post('param');
		$data = array();
		$hasil = $this->gcgm->result_tabel('master_user');
		$i = 1;
		foreach ($hasil as $r) {
			if ($r->kode_divisi != 'admin') {
				$jabatan = row_tabel('master_org_jabatan',array('kode' => $r->kode_jabatan), 'nama_jabatan');
				$divisi = row_tabel('master_org_divisi',array('kode' => $r->kode_divisi), 'nama_divisi');
				$job = $jabatan . " " . $divisi;
				$row = array();
				$row[] = $i;
				$row[] = $r->nama;
				$row[] = $jabatan;
				$row[] = $divisi;
				$row[] = $r->user_name;
				$row[] = '
						<div class="row">
						<a type="button" class="btn yellow formModalEdit_user" data-toggle="modal" data-target="#formModalEdit_User" data-id="<?=$i;?>" onclick="load_form_edit_user(' . "'" . $r->id_user .  "'" . ')"  title="Edit Data User"><i class="fa fa-edit"></i></a>
						<a type="button" class="btn yellow" onclick="delete_user(' . "'" . $r->id_user .  "'" . ')"  title="Delete User"><i class="fa fa-trash"></i></a>
						<div>
						';
				$data[] = $row;
				$i++;
			}
		}
		$output = array(
			"data" => $data,
		);
		echo json_encode($output);
	}
	public function create()
	{
		$tabel = $this->input->post('tabel');
		$data = $this->input->post('data');
		$this->gcgm->insert($tabel, $data);
	}
	public function crude()
	{
		$aksi = $this->input->post('aksi');
		$tabel = $this->input->post('tabel');
		$data = $this->input->post('data');
		$where = $this->input->post('where');
		// if($data->password){
		// 	$data->password=md5($data->password);
		// }
		switch ($aksi) {
			case 'update':
				$this->gcgm->update($tabel, $data, $where);
				break;
			case 'delete':
				$this->gcgm->delete($tabel, $where);
				break;
			case 'insert':
				$this->gcgm->insert($tabel, $data);
				break;
			default:
				break;
		}
		echo json_encode(true);
	}
	public function load_data_edit_user()
	{
		$id_user = $this->input->post('id');
		$data = $this->gcgm->result('master_user', array("id_user" => $id_user));
		echo json_encode($data);
	}
	public function load_data()
	{
		$tabel = $this->input->post('tabel');
		$where = $this->input->post('where');
		$data = $this->gcgm->result($tabel, $where);
		echo json_encode($data);
	}
	// public function next_index_test(){
	// 	// $query = $this->db->where($where)->query("select max($code_position($kolom,$index_position)='$master_id')+1 as $kolom from $tabel");
	// 	$next_id= $this->gcgm->next_id_new('master_org_divisi','kode',array('kode'=>'KSD'), 'left', 3, 'KSD');
	// 	echo $next_id;
	// }
	public function next_index(){
		$tabel = $this->input->post('tabel');
		$kolom = $this->input->post('kolom');
		$where = $this->input->post('where');
		// var_dump($where);
		$master_id = $this->input->post('kode');
		$code_position = $this->input->post('code_position');
		$index_position = $this->input->post('index_position');
		$index_length = $this->input->post('index_length');
		$str_start = $this->input->post('str_start');
		$str_end= $this->input->post('str_end');
		$next_id= $this->gcgm->next_id_new($tabel,$kolom,$where, $code_position, $index_position, $master_id);
		// $data='';
		// if($next_id<10){
		// 	$data=$master_id . '0' . $next_id;
		// }else{
		// 	$data=$master_id .  $next_id;
		// }
		// var_dump($data);
		echo json_encode($next_id);				
	}
	public function survey_new($kode_survey = '')
	{
		if ($this->session->userdata('ket') <> '') {
			$data['prev'] = $this->menum->main_menu();
			$this->load->view('header', $data);
			$datax['list_kode_survey'] =  list_dropdown('gcg_surveyor', array('kode_survey', 'kode_survey'), array('status_survey' => 0));
			$datax['tahun'] =  $this->gcgm->tahun_berjalan();
			$datax['kode_survey'] =  $this->gcgm->last_gcg_transaksi_kode_survey();
			$datax['selesai'] = $this->gcgm->selesai_survey();


			if (!empty($kode_survey)) {
				$datax['pertanyaan'] = $this->survey_pertanyaan_new($kode_survey);
				$datax['status_survey'] = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'hasil');
				$datax['terpilih'] = $kode_survey;
			} else {
				$datax['terpilih'] = '';
				$datax['status_survey'] = $this->gcgm->cek_gcg_transaksi_fu_kode_survey($kode_survey, 'hasil');
				$datax['pertanyaan'] = '
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-body">
								<div class="card-header">
									<h6>Silahkan register survey terlebih dahulu / pilih kode survey dan klik tombol tampilkan </h6>
								</div>
							</div>
						</div>
					</div>
				</div>
				';
			}

			$this->load->view('gcg/survey_new', $datax);
			$this->load->view('footer');
		} else {
			redirect('welcome/index');
		}
	}
	public function detil($kode_fu = '')
	{
		// $this->load->model('gcgm');
		$get_fu = str_replace('_', '.', $kode_fu);
		if (substr_count($get_fu, ".") < 4) {
			$get_fu .= '.0';
		}
		$catatan = $this->gcgm->row_tabel('gcg_master_fu', array('kode_fu' => $get_fu), 'catatan');
		$faktor_uji = $this->gcgm->row_tabel('gcg_master_fu', array('kode_fu' => $get_fu), 'pertanyaan');
		$get_urut = $get_fu . '.' . $faktor_uji;
		$kode_survey = '2020_1';
		$hasil = $this->survey_detil($kode_survey, $get_fu, $get_urut, $catatan);
		echo ($hasil);
		return $hasil;
	}
	public function fu_lv2($fu_lv1 = '')
	{
		$kode_fu_lv1  = str_replace('_', '.', $fu_lv1);
		// $kode_fu_lv1  = substr($kode_fu_lv1, 0, -2);
		// echo ($kode_fu_lv1);
		$hasil = '';
		$ref_1 = result_tabel('temp_gcg_transaksi_fu_lv2', array('lv1' => $kode_fu_lv1, 'kode_survey' => '2020_1'));
		foreach ($ref_1 as $t) {
			$kode_fu_lv_2 = str_replace('.', '_', $t->lv2);
			if ($t->status_survey == 1) {
				$info_fu_lv_2 = '<i class="fas fa-check"></i>';
			} else {
				$info_fu_lv_2 = $t->status_survey . '/1';
			}
			// $fu_lv1 = '<div class="row">
			// 				<div class="col-md-12">
			// 					<h6 class="card-title"><span class="badge badge-primary" id="info"></span></h6>  
			// 				</div>
			// 			</div>
			// 			<div class="card mb-4">
			// 				<div class="card-body">
			// 					<div id="parameter' .  $kode_fu_lv_1 . '"><div>
			// 				</div>
			// 			</div>';
			
			$fu_lv2 = '<div id="detil' .  $kode_fu_lv_2 . '"></div>';
			$onclick = 'onclick=load_detil("' . $kode_fu_lv_2 . '")';
			$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $kode_fu_lv_2 . '">
									<button class="btn btn-link text-dark" ' . $onclick . ' data-toggle="collapse" data-target="#collapse_' . $kode_fu_lv_2 . '" aria-expanded="true" aria-controls="collapse_' . $kode_fu_lv_2 . '">
										<p align="justify">
											<i class="fas fa-pen-alt text-warning"></i> 
											<span>' . $t->lv2 . '. ' . $t->uraian_sfu . ' </span> <span class="badge badge-primary" id="info_' . $kode_fu_lv_2 . '">' . $info_fu_lv_2 . '</span>
										</p>
									</button>
								</div>
								<div id="collapse_' . $kode_fu_lv_2 . '" class="collapse" aria-labelledby="heading_' . $kode_fu_lv_2 . '" data-parent="#collapse_' . $fu_lv1 . '">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												' . $fu_lv2 . '
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		}
		echo ($hasil);
		return $hasil;
	}
	public function fu_lv1($parameter = '')
	{
		$kode_parameter = str_replace('_', '.', $parameter);
		$hasil = '';
		$ref_1 = result_tabel('temp_gcg_transaksi_fu_lv1', array('no_parameter' => $kode_parameter, 'kode_survey' => '2020_1'));
		foreach ($ref_1 as $t) {
			$kode_fu_lv_1 = str_replace('.', '_', $t->lv1);
			if ($t->jlh_fu_terisi == $t->jlh_fu) {
				$info_fu_lv_1 = '<i class="fas fa-check"></i>';
			} else {
				$info_fu_lv_1 = $t->jlh_fu_terisi . '/' . $t->jlh_fu;
			}
			// $fu_lv1 = '<div class="row">
			// 				<div class="col-md-12">
			// 					<h6 class="card-title"><span class="badge badge-primary" id="info"></span></h6>  
			// 				</div>
			// 			</div>
			// 			<div class="card mb-4">
			// 				<div class="card-body">
			// 					<div id="parameter' .  $kode_fu_lv_1 . '"><div>
			// 				</div>
			// 			</div>';
			$onclick = '';
			if ($t->turunan_sfu == 1) {
				$fu_lv1 = '<div id="fu_lv2' .  $kode_fu_lv_1 . '"></div>';
				$onclick = 'onclick=load_fu_lv2("' . $kode_fu_lv_1 . '")';
			} else {
				$fu_lv1 = '<div id="detil' .  $kode_fu_lv_1 . '_0"></div>';
				$onclick = 'onclick=load_detil("' . $kode_fu_lv_1 . '_0")';
			}
			$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $kode_fu_lv_1 . '">
									<button class="btn btn-link text-dark" ' . $onclick . ' data-toggle="collapse" data-target="#collapse_' . $kode_fu_lv_1 . '" aria-expanded="true" aria-controls="collapse_' . $kode_fu_lv_1 . '">
										<p align="justify">
											<i class="fas fa-pen-alt text-warning"></i> 
											<span>' . $t->lv1 . '. ' . $t->faktor_uji . ' </span> <span class="badge badge-primary" id="info_' . $kode_fu_lv_1 . '">' . $info_fu_lv_1 . '</span>
										</p>
									</button>
								</div>
								<div id="collapse_' . $kode_fu_lv_1 . '" class="collapse" aria-labelledby="heading_' . $kode_fu_lv_1 . '" data-parent="#collapse_' . $parameter . '">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												' . $fu_lv1 . '
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		} 
		echo ($hasil);
		return $hasil;
	}
	public function parameter($indikator = '')
	{
		$kode_indikator = str_replace('_', '.', $indikator);
		$hasil = '';
		$ref_1 = result_tabel('temp_gcg_transaksi_fu_parameter', array('no_indikator' => $kode_indikator, 'kode_survey' => '2020_1'));
		foreach ($ref_1 as $t) {
			if ($t->jlh_fu_terisi == $t->jlh_fu) {
				$info_parameter = '<i class="fas fa-check"></i>';
			} else {
				$info_parameter = $t->jlh_fu_terisi . '/' . $t->jlh_fu;
			}
			$kode_parameter = str_replace('.', '_', $t->no_parameter);
			// $fu_lv1 = '<div class="row">
			// 				<div class="col-md-12">
			// 					<h6 class="card-title"><span class="badge badge-primary" id="info"></span></h6>  
			// 				</div>
			// 			</div>
			// 			<div class="card mb-4">
			// 				<div class="card-body">
			// 					<div id="parameter' .  $kode_parameter . '"></div>
			// 				</div>
			// 			</div>';
			$hasil .= '
					<div class="row">
						<div class="col-md-12">
							<div class="card ">
								<div class="card-header" id="heading_' . $kode_parameter . '">
									<button class="btn btn-link text-dark" onclick=load_fu_lv1("' . $kode_parameter . '") data-toggle="collapse" data-target="#collapse_' . $kode_parameter . '" aria-expanded="true" aria-controls="collapse_' . $kode_parameter . '">
										<p align="justify">
											<i class="fas fa-pen-alt text-warning"></i> 
											<span>' . $t->no_parameter . '. ' . $t->aspek_pengujian_atau_indikator . ' </span> <span class="badge badge-primary" id="info_' . $kode_parameter . '">' . $info_parameter . '</span>
										</p>
									</button>
								</div>
								<div id="collapse_' . $kode_parameter . '" class="collapse" aria-labelledby="heading_' . $kode_parameter . '" data-parent="#collapse_' . $indikator . '">
									<div class="card-body">
										<div class="row">
											<div class="col-md-12">
												<div id="fu_lv1' .  $kode_parameter . '"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>';
		}
		echo ($hasil);
		return $hasil;
	}
	public function indikator($no_aspek = '')
	{
		$hasil = '';
		$ref_1 = result_tabel('temp_gcg_transaksi_fu_indikator', array('no_aspek' => $no_aspek, 'kode_survey' => '2020_1'));
		foreach ($ref_1 as $s) {
			if ($s->jlh_fu_terisi == $s->jlh_fu) {
				$info_indikator = '<i class="fas fa-check"></i>';
			} else {
				$info_indikator = $s->jlh_fu_terisi . '/' . $s->jlh_fu;
			}
			$kode_indikator = str_replace('.', '_', $s->no_indikator);
			$hasil .= '	<div class="row">
							<div class="col-md-12">
								<div class="card">								
									<div class="card-header" id="indikator_' . $kode_indikator . '">
										<button class="btn btn-link text-dark" onclick=load_parameter("' . $kode_indikator . '") data-toggle="collapse" data-target="#collapse_' . $kode_indikator . '" aria-expanded="true" aria-controls="collapse_' . $kode_indikator . '">
											<p align="justify">
												<i class="fas fa-pen-alt text-warning"></i> 
												<span>' . $s->no_indikator . '. ' . $s->aspek_pengujian_atau_indikator . ' </span> <span class="badge badge-primary" id="info_' . $kode_indikator . '">' . $info_indikator . '</span>
											</p>
										</button>
									</div>
									<div id="collapse_' . $kode_indikator . '" class="collapse" aria-labelledby="indikator_' . $kode_indikator . '" data-parent="#collapse_' . $s->no_aspek . '">
										<div class="card-body">
											<div class="row">
												<div class="col-md-12">
													<div id="parameter' . $kode_indikator . '"></div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>';
		}
		echo ($hasil);
		return $hasil;
	}
	public function survey_pertanyaan_new($kode_survey)
	{
		$hasil = '';
		$ref = result_tabel('temp_gcg_transaksi_fu_aspek', array('kode_survey' => $kode_survey));
		foreach ($ref as $r) {
			if ($r->jlh_fu_terisi == $r->jlh_fu) {
				$info_aspek = '<i class="fas fa-check"></i>';
			} else {
				$info_aspek = $r->jlh_fu_terisi . '/' . $r->jlh_fu;
			}
			$hasil .= '
				<div class="card shadow">
					<div class="card-header" id="heading_' . $r->no_aspek . '">
						<button class="btn btn-link text-dark" onclick=load_indikator("' . $r->no_aspek . '") data-toggle="collapse" data-target="#collapse_' . $r->no_aspek . '" aria-expanded="true" aria-controls="collapse_' . $r->no_aspek . '">
							<p align="justify">
								<i class="fas fa-clipboard-list text-warning"></i>
								<span>' . $r->no_aspek . '. ' . $r->aspek_pengujian_indikator . ' </span> <span class="badge badge-primary" id="info_' . $r->no_aspek . '">' . $info_aspek . '</span>
							</p>
						</button>
					</div>
					<div id="collapse_' . $r->no_aspek . '" class="collapse" aria-labelledby="heading_' . $r->no_aspek . '" data-parent="#accordion">
						<div class="card-body">
							<div class="row">
								<div class="col-md-12">

									<div id="indikator' . $r->no_aspek . '"></div>

								</div>
							</div>	
						</div>		
					</div>
				</div>
			';
			$hasil .= '';
		}
		$hasil .= '
		<div class="col-md-12 mt-4"> 
			<div class="row justify-content-end">
				<div class="col-md-3">
					<button type="button" onclick="selesai_survey(' . "'" . $kode_survey . "'" . ')" class="btn btn-outline-primary btn-block" id="btn_selesai">
						<i class="fas fa-paper-plane"></i> Survey Selesai
					</button> 
				</div> 
			</div>
		</div>
		';
		return $hasil;
	}
}
