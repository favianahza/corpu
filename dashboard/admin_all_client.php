<?php 
require_once '../functions.php';
$records = gAll_client();
$return = "admin_all_client.php";

// var_dump($records); exit();

 ?>
    <!-- Content Header (Page header) -->
    <section class="content-header" data-loaded="available_task.php"> <!-- /.section content-header start -->
      <div class="container-fluid"> <!-- /.container-fluid start -->
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Client Data</h1>
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
                <h3 class="card-title"><span class="badge badge-primary">Client Data</span></h3>
              </div> <!-- /.card-header end -->
              
              <div class="card-body"> <!-- /.card-body start-->
                <table id="data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Nama Client</th>
                      <th>Issued Task</th>
                      <th>Completed Issued Task</th>
                      <th>Lainnya</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i = 1; ?>
                    <?php foreach($records as $record) : ?>
                    <tr class="task_<?= $record["id_task"]; ?>">
                      <th><?= $i++; ?></th>

                      <th><?= $record["fullname"] ?></th>

                      <th><?= $record["issued_task"] ?></th>

                      <th><?= $record["completed_issued_task"] ?></th>

                      <th class="d-flex justify-content-around">
                        <h5>
                        <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('profile_client.php?id=<?= $record["id_client"] ?>&img=<?= $record["img_teknisi"] ?>&return=<?= $return; ?>')">DETAIL</span>
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