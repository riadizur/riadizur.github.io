<div class="col-md-8 col-sm-8 ">
  <div class="x_panel">
    <div class="x_title">
      <h2>Pengumuman Proyek Terbaru</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="dashboard-widget-content">
        <ul class="list-unstyled timeline widget">
          <?php
          $pengumuman=$this->db2_models->result('tp_transaksi_project',array('kode_vendor'=>$this->session->userdata('kode_vendor')));
          foreach($pengumuman as $p){
            $project=$this->db2_models->result('tp_master_project',array('kode_project'=>$p->kode_project));
            foreach($project as $pr){
          ?>
          <li>
            <div class="block">
              <div class="block_content">
                <h2 class="title"><a><?=$pr->nama_project?></a></h2>
                <div class="byline">
                  <span>Jenis Pengadaan</span> : <a><?=$pr->jenis_pengadaan;?></a>
                </div>
                <?php if($pr->keperluan=='PS'){?>
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="#" data-toggle="modal" data-target="#modal_rks" onclick="" class="float-right">Read&nbsp;More...</a>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button> -->
                <?php }else{ ?>
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="#" data-toggle="modal" data-target="#modal_boq" onclick="load_boq('<?=$pr->kode_project?>');" class="float-right">Read&nbsp;More...</a>
                <?php } ?>
                </p>
              </div>  
            </div>
          </li>
          <?php  
            }
          } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<div class="modal fade bs-example-modal-xl" id="modal_boq" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel2">Detail Pengadaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tabel_boq" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Merk</th>
              <th>Spesifikasi</th>
              <th>Jumlah</th>
              <th>Detail</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abaikan</button>
        <button type="button" class="btn btn-primary" onclick="window.open('<?=base_url()?>vendor/penawaran','_self')">Berminat</button>
      </div>
    </div> 
  </div>
</div>
<div class="modal fade bs-example-modal-xl" id="modal_rks" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel2">Detail Pekerjaan</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
      <embed src="http://portal.ecopowerport.co.id:88/vendor_list/assets/upload_file/registrasi_project/dokumen/1589435358021.png" width="100%" height="100%">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Abaikan</button>
        <button type="button" class="btn btn-primary">Berminat</button>
      </div>
    </div>
  </div>
</div>
<script></script>
<script>
function load_boq(kode_project){
  load_tabel('tabel_boq','tp_master_boq',{kode_project:kode_project});
}
function load_tabel(nama_tabel,tabel,where){
	var baseUrl = '<?=base_url()?>vendor/load_tabel';
	$('#'+nama_tabel).DataTable({
		"destroy": true,
		"paging": true,
		"ordering": true,
		"info": true,
		"searching": true,
		"processing": true,
		"serverSide": false,
		"order": [],
		"ajax": {
			"url": baseUrl,
			"type": 'POST',
			"data" : {
				nama_tabel : nama_tabel,
				tabel : tabel,
				where : where
			}
		},
	});
}
function update_pertanyaan(id){
  
}
</script>
