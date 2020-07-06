<div class="col-md-8 col-sm-8 ">
  <div class="x_panel">
    <div class="x_title">
      <h2>Pengumuman Proyek Terbaru</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="dashboard-widget-content">
        <ul class="list-unstyled timeline widget">
          <div id="kode_project"></div>
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
                <p class="excerpt">lokasi pekerjaan : <?=$pr->lokasi_project.', '.$pr->kec.', '.$pr->kab.', '.$pr->prov?><br><a href="#" data-toggle="modal" data-target="#modal_boq" onclick="load_boq('<?=$pr->kode_project?>');$('#kode_project').val('<?=$pr->kode_project?>');" class="float-right">Read&nbsp;More...</a>
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
        <h4 class="modal-title" id="myModalLabel2">Masukkan Harga Penawaran (*Harga Belum Termasuk PPN 10%)</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="tabel_penawaran" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Barang</th>
              <th>Merk</th>
              <th>Type</th>
              <th>Spesifikasi</th>
              <th>Jumlah</th>
              <th>Detail</th>
              <th>Masukkan Harga Persatuan (Rp.)</th>
              <th>Jumlah Harga</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <br>
        <hr>
        <div class="row">
          <div class="col-md-4" align="left">
            <label>Masukkan Dokumen Penawaran Harga (<span class="red">Wajib diisi</span>) :</label><br>
          </div>
          <div class="col-md-8" align="left">
            <input id="dokumen_pengadaan" type="file" name="sortpic" onchange="upload('dokumen_pengadaan','dokumen_pengadaan')"/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-4" align="left">
            <label>Masukkan  File Brosur Produk :</label><br>
          </div>
          <div class="col-md-8" align="left">
            <input id="brosur" type="file" name="sortpic" onchange="upload('brosur  ','brosur ')"/>
          </div>
        </div>
      </div>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"  onclick="$('#kode_project').val()">Abaikan</button>
        <button type="button" class="btn btn-primary" onclick="ajukan_penawaran($('#kode_project').val());">Ajukan Penawaran</button>
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
        <button type="button" class="btn btn-primary">Ajukan Penawaran</button>
      </div>
    </div>
  </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script>
function upload(kode,jen_file){
  var file_data = $('#'+kode).prop('files')[0];   
  var form_data = new FormData();                  
  form_data.append('file', file_data);            
  $.ajax({
      url: 'http://portal.ecopowerport.co.id:88/vendors/vendor/upload', // point to server-side PHP script 
      dataType: 'text',  // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,                         
      type: 'post',
      success: function(datas){
        // alert(datas);
        var nama_file=''; 
        var kode_file=''; 
        var kode_vendor='<?=$this->session->userdata("kode_vendor")?>';
        var kode_project=$('#kode_project').val();
        var obj = JSON.parse(datas); 
          nama_file=obj.nama_file;
          kode_file=obj.kode_file;
        // alert(datas);
        var data={
          kode_project:kode_project,
          kode_vendor:kode_vendor,
          jenis_file:jen_file,
          nama_file:nama_file,
          kode_file:kode_file
        }
        crude('insert','master_dokumen_penawaran',data,data,'');
        alert('Dokumen berhasil di upload !');
      }
    });
}
function load_boq(kode_project){
  load_tabel('tabel_penawaran','tp_master_boq',{kode_project:kode_project});
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
function add_penawaran(kode,harga,jumlah,kode_project,kode_barang){
  $('#jumlah_'+kode).val(jumlah*harga);
  $('#jumlah_'+kode).html('Rp.'+jumlah*harga);
  var d = new Date();
  var kode_project=kode_project;
  var kode_vendor='<?=$this->session->userdata("kode_vendor")?>';
  var jumlah_harga=jumlah*harga;
  var data={
    kode_project:kode_project,
    kode_vendor:kode_vendor,
    kode_barang:kode_barang,
    id_master_boq:kode,
    harga_satuan:harga,
    jumlah_barang:jumlah,
    jumlah_harga:jumlah_harga,
    sts:'0',
    waktu_entry: d.getFullYear() + '-' +('0' + (d.getMonth()+1)).slice(-2)+ '-' +  ('0' + d.getDate()).slice(-2) + ' '+d.getHours()+ ':'+('0' + (d.getMinutes())).slice(-2)+ ':'+d.getSeconds(),
    user_update:'<?=$this->db2_models->row("master_pic",array("kode_register"=>$this->session->userdata("kode_vendor")),"nama_pic")?>'
  }
  crude2('insert','temp_master_penawaran',{id_master_boq:kode,kode_vendor:kode_vendor},data,'Harga');
}
function ajukan_penawaran(kode_project){
  var kode_vendor='<?=$this->session->userdata("kode_vendor")?>';
  var baseUrl = '<?=base_url()?>vendor/ajukan_penawaran';
  $.ajax({
        url: baseUrl,
        type: 'POST',
        dataType: 'json', 
        data: {
            where:{
              kode_project : kode_project,
              kode_vendor : kode_vendor
            }
        },
        success: function(datas) {
          var data={
              kode_project : kode_project,
              kode_vendor : kode_vendor
          }
          crude2('insert','temp_master_penawaran',data,{sts:'1'},'');
          load_tabel('tabel_penawaran','tp_master_boq',{kode_project:kode_project});
          alert('Penawaran Telah Diajukan !');

        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert('Ups Ada sedikit kesalahan.. Segera Hubungi Administrator ');
        } 
    });
}
function crude2(aksi,tabel,where='',data='',context){
    var baseUrl = '<?=base_url()?>vendor/crude2';
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