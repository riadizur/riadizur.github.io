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
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="<?=base_url()?>vendor/pengumuman" class="float-right">Read&nbsp;More...</a>
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