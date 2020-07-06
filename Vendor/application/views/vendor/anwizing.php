<div class="col-md-3 col-sm-3">
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
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="#" data-toggle="modal" data-target="#modal_rks" onclick="" class="float-right">&nbsp;||&nbsp;Detail</a><a href="#" onclick="load_tabel_pertanyaan('<?=$pr->kode_project?>')" class="float-right">Pertanyaan</a>
                <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bs-example-modal-sm">Small modal</button> -->
                <?php }else{ ?>
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="#" data-toggle="modal" data-target="#modal_boq" onclick="load_boq('<?=$pr->kode_project?>');" class="float-right">&nbsp;||&nbsp;Detail</a><a href="#" onclick="load_tabel_pertanyaan('<?=$pr->kode_project?>');$('#pertanyaan').prop('disabled',false);$('#kode_project').val('<?=$pr->kode_project?>');" class="float-right">Pertanyaan</a>
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
<div class="col-md-6 col-sm-6">
    <div id="kode_project"></div>
    <table id="tabel_pertanyaan" class="table table-striped table-bordered" style="width:100%">
        <h4>Tabel Pertanyaan <div id="nama_project"></div></h4>
        <hr>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="23%">Nama Perusahaan</th>
                <th width="15%">Nama</th>
                <th width="32%">Pertanyaan</th>
                <th width="35%">Jawaban</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="col-md-3 col-sm-3">
    <form class="" action="#" method="post" validate>
    <div class="field item form-group">
        <label class="col-form-label col-md-12 col-sm-12">Kirim Pertanyaan<span class="required">*</span></label>
    </div>
    <div class="field item form-group">
        <textarea required="required" id='pertanyaan' style="width:100%;height:200px" disabled></textarea>
    </div>
    <div class="ln_solid">
        <div class="form-group">
            <div class="col-md-12">
                <br>
                <button class="btn btn-primary pull-right" onclick="add_pertanyaan()">Submit</button>
            </div>
        </div>
    </div>
    </form>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
      </div>
    </div>
  </div>
</div>
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
function add_pertanyaan(){
    var kode_project=$('#kode_project').val();
    var pertanyaan=$('#pertanyaan').val();
    var kode_vendor='<?=$this->session->userdata("kode_vendor")?>';
    var user_pertanyaan='<?=$this->db2_models->row("master_pic",array("kode_register"=>$this->session->userdata("kode_vendor")),"nama_pic")?>';
    var nama_perusahaan='<?=$this->db2_models->row("master_perusahaan",array("kode_register"=>$this->session->userdata("kode_vendor")),"nama_perusahaan")?>';
    var waktu_pertanyaan='';
    var data={
        kode_project:kode_project,
        pertanyaan:pertanyaan,
        kode_vendor:kode_vendor,
        user_pertanyaan:user_pertanyaan,
        nama_perusahaan:nama_perusahaan,
        waktu_pertanyaan:waktu_pertanyaan
    }
    crude('insert','tp_anwizing_chat',data,data,'Pertanyaan');
    load_tabel('tabel_pertanyaan','tp_anwizing_chat',{kode_project:kode_project});
}
function load_tabel_pertanyaan(kode_project){
    load_tabel('tabel_pertanyaan','tp_anwizing_chat',{kode_project:kode_project});
}
function update_pertanyaan(id){

}
function crude(aksi,tabel,where='',data='',context){
    var baseUrl = '<?=base_url()?>vendor/crude';
    $.ajax({
        url: baseUrl,
        type: 'POST',
        dataType: 'json', 
        data: {
            aksi : aksi,
            tabel : tabel,
            where : where,
            data : data
        },
        success: function(datas) {
            if(context!='no' && context!=''){
                if(datas!='' && datas !=null){
                    alert(context+' telah di'+datas+' !');
                }else{
                    alert(context+' gagal di'+aksi+' !');
                }
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert('Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ');
        } 
    });
}
</script>