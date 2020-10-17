<?php 
require_once '../functions.php';

$id = $_GET["id"];
$total_img = $_GET["total_image"];
$jml_teknisi = $_GET["jml_teknisi"];
$result = gtask_detail($id,$total_img,$jml_teknisi);
// $result = gtask_detail();

 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="detail_task.php?id=<?= $id ?>">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark font-weight-bold">Detail Task</h1>
            <h5><span class="badge badge-secondary" onclick="ajax('client_issued_task.php')" style="cursor: pointer;">Kembali ke halaman sebelumnya</span></h5>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= date('d/m/Y') ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        <hr>
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row py-2">
          <div class="col">
             <div class="form-row mb-3 text-center">
                <div class="col-12 col-sm mb-4 mb-sm-0">
                  <h3>Judul Task</h3>
                  <h5><?= $result['taskname']; ?></h5>
                </div>
                <div class="col-12 col-sm  mb-4 mb-sm-0">
                  <h3>Lokasi</h3>
                  <h5><?= $result['location'];  ?></h5>
                </div>
                <div class="col-12 col-sm mb-4 mb-sm-0">
                  <h3>Status</h3>
                  <h5><span class="badge <?php if($result['status']=='NOT COMPLETED'){ echo 'badge-danger'; } else if($result['status']=='IN PROGRESS'){ echo 'badge-warning'; } else { echo 'badge-success'; }?>"><?= $result['status'] ?></span></h5>                  
                </div>                
            </div>

            <div class="col">
             <div class="form-row mb-3 text-center">
                <div class="col-12 col-sm mb-4 mb-sm-0">
                  <h3>Tipe Pekerjaan</h3>
                  <h5><?= $result['type'] ?></h5>
                </div>
                <?php if($result['type'] == 'Team'): ?>
                <div class="col-12 col-sm mb-4 mb-sm-0">
                  <h3>Anggota yang diperlukan</h3>
                  <h5><?= $result['member'] ?></h5>
                </div>
                <?php endif; ?>
                  <?php if($result['nama_teknisi'] != NULL): ?>
                  <div class="col-12 col-sm mb-4 mb-sm-0">
                    <h3>Teknisi yang mengerjakan</h3>
                    <h5><span class="badge badge-info" data-toggle="modal" data-target="#modalTeknisi" style="cursor: pointer;">LIHAT</span></h5>
                  </div>                  
                  <?php else: ?>
                <?php endif; ?>
            </div>

            <div class="form-group">
              <h4>Deskripsi</h4>
              <textarea rows="3" class="form-control" disabled value=""><?= $result['description']; ?></textarea>
            </div>

            <h3 class="text-center">Foto</h3>
            <div class="d-flex justify-content-around mb-3 flex-wrap">
              <?php if($total_img == 1):  ?>
              <img src="taskImg/<?= $result['foto0']; ?>" width="350" class="my-2">
              <?php else: ?>
                <?php for($i=0; $i < $total_img; $i++ ): ?>
                  <img src="taskImg/<?= $result['foto'][$i]; ?>" width="350" class="my-2">
                <?php endfor; ?>
              <?php endif; ?>
            </div>

          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- Modal -->
    <div class="modal fade" id="modalTeknisi" tabindex="-1" aria-labelledby="modalTeknisi" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTeknisi">Teknisi yang mengerjakan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">

            <?php if($jml_teknisi == 1): ?>

            <img src="../assets/img/profile/<?= $result['img_teknisi']; ?>" alt="Gambar Teknisi" class="d-block mx-auto shadow mb-2" style="height: 125px; width: 125px; cursor: pointer; " onclick="$('.modal-backdrop').remove();ajax('profile.php')">
            <h5><?= $result['nama_teknisi'] ?></h5>

            <?php else: ?> 

            <?php for($i = 0; $i < $jml_teknisi; $i++): ?>
            <img src="../assets/img/profile/<?= $result['img_teknisi'][$i]; ?>" alt="Gambar Teknisi" class="d-block mx-auto shadow mb-2" style="height: 125px; width: 125px; cursor: pointer;" onclick=" $('.modal-backdrop').remove();ajax('profile_teknisi.php?id=<?= $result["id_teknisi"]["$i"]; ?>')">
            <h5 class="mb-3"><?= $result['nama_teknisi'][$i]; ?></h5>
            <?php endfor; ?>

            <?php endif; ?>

            <small  class="text-left"><span><i class="fas fa-info-circle font-weight-bold"></i> Klik gambar teknisi untuk mengetahui lebih lanjut tentang Teknisinya.</span></small>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>