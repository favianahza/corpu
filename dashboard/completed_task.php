<?php 
require_once '../functions.php';
$records = gAll_CompletedTask($_SESSION["id_teknisi"]);
$return = "completed_task.php";

// var_dump($records); exit(); // DEBUGGING

 ?>
    <!-- Content Header (Page header) -->
    <section class="content-header" data-loaded="completed_task.php"> <!-- /.section content-header start -->
      <div class="container-fluid"> <!-- /.container-fluid start -->
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Completed Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= date('d/m/Y') ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid end -->
    </section> <!-- /.section content-header end -->

    <!-- Main content -->
    <section class="content"> <!-- /.section content start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"> <!-- /.card-header start -->
                <h3 class="card-title"><span class="badge badge-success">Completed Task</span></h3>
              </div> <!-- /.card-header end -->
              
              <div class="card-body"> <!-- /.card-body start-->
                <table id="data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Taskname</th>
                      <th>Lokasi</th>
                      <th>Pengaju</th>
                      <th>Tipe</th>
                      <th>Anggota</th>
                      <th>Tanggal</th>
                      <th>Lainnya</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($records as $record) : ?>
                    <tr class="task_<?= $record["id_task"]; ?>">
                      <th><?= $i++; ?></th>

                      <th><?= $record["taskname"] ?></th>

                      <th><?= $record["location"] ?></th>

                      <th><?= $record["pengaju"] ?></th>

                      <th>
                        <?php if($record["type"] == 'Team'):?>
                          <i class="fas fa-user-friends"></i> <?= $record["type"] ?>
                        <?php else: ?>
                          <i class="fas fa-user-alt"></i> <?= $record["type"] ?>
                        <?php endif; ?>
                      </th>

                      <th><?= $record['member']; ?></th>

                      <th><?= $record['new_date']; ?></th>

                      <th class="d-flex justify-content-between">
                        <h5>
                        <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('detail_task.php?id=<?= $record["id_task"]; ?>&total_image=<?= $record["total_img"]; ?>&jml_teknisi=<?= $record["jml_teknisi"] ?>&return=<?= $return; ?>&teknisi_yang_dibutuhkan=<?= $record['member'] ?>')">DETAIL</span>
                        </h5>
                        <h5>
                        <span class="badge badge-success" style="cursor: pointer;" onclick="ajax('completed_task_report.php?return=<?= $return ?>&id=<?= $record["id_task"] ?>&total_img=<?= $record["total_img"]; ?>')">LAPORAN</span>
                        </h5>
                    </th>

                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div> <!-- /.card-body end-->
              
            </div>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section> <!-- /.section content-header end -->
    <!-- /.content -->
    <script>
      $("#data").DataTable({
        "responsive": true,
        "autoWidth": false,
      });

    </script>