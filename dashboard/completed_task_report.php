<?php 
require_once '../functions.php';

$return = $_GET["return"];
$id_task = $_GET["id"];
$total_img = $_GET["total_img"];

$record = gtask_response($id_task, $total_img);

?>
 <!-- Content Header (Page header) -->
  <div class="content-header" data-loaded="completed_task_report.php">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col text-center">
        	<div class="col"><h5><span class="badge badge-secondary" onclick="ajax('<?= $return; ?>')" style="cursor: pointer;">Kembali ke halaman sebelumnya</span></h5></div>
          <h2>Laporan Penyelesaian Task</h2>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col col-md-8 offset-md-2">
          <form method="post" enctype="multipart/form-data">

            <div class="form-group">
              <label for="deskripsi" class="text-center">Deskripsi</label>
              <textarea class="form-control" id="deskripsi" rows="6" placeholder="Masukan Deskripsi Disini" disabled value=""><?= $record["description"] ?></textarea>
            </div>

            <h3 class="text-center">Foto</h3>
            <div class="d-flex justify-content-around mb-3 flex-wrap">
              <?php if(isset($record["foto0"])) : ?>
                <img src="taskResponse/<?= $record["foto0"] ?>" alt="Response Image" width="275" class="my-2">
              <?php else: ?>
                <?php for($i = 0; $i < count($record["foto"]); $i++  ) : ?>
                <img src="taskResponse/<?= $record["foto"]["$i"] ?>" alt="Response Image" width="275" class="my-2">
                <?php endfor; ?>
              <?php endif; ?>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>