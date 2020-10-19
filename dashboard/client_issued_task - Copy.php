<?php 
require_once '../functions.php';
$records = gtask_user($_SESSION["id_user"]);
$return = 'client_issued_task.php';
 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="client_issued_task.php">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Issued Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= date('d/m/Y') ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
        

        <div class="row mb-1">

          <!-- Filter by Day -->
          <div class="col-12 col-md ">
          <sup>Filter by Day</sup>
            <select name="day" id="day" class="form-control">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>

          <!-- Filter by Month -->          
          <div class="col-12 col-md ">
          <sup>Filter by Month</sup>
            <select name="month" id="month" class="form-control">
              <option value="1">January</option>
              <option value="2">February</option>
              <option value="3">March</option>
              <option value="4">April</option>
              <option value="5">May</option>
              <option value="6">June</option>
              <option value="7">July</option>
              <option value="8">August</option>
              <option value="9">September</option>
              <option value="10">October</option>
              <option value="11">November</option>
              <option value="12">December</option>
            </select>
          </div>

          <!-- Filter by Year -->
          <div class="col-12 col-md ">
          <sup>Filter by Year</sup>
            <select name="year" id="year" class="form-control">
              <option value="2020">2020</option>
            </select>
          </div>

          <div class="col-12 col-md ">
          <sup>Filter by Type</sup>
            <select name="type" id="type" class="form-control">
              <option value="Individu">Individu</option>
              <option value="Team">Team</option>
            </select>
          </div>          

        </div>



      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><span class="badge badge-warning">Issued Task</span></h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Taskname</th>
                      <th>Lokasi</th>
                      <th>Status</th>
                      <th>Tipe</th>
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

                      <th><h5>
                        <span class="badge <?php if($record['status']=='NOT COMPLETED'){ echo 'badge-danger'; } else if($record['status']=='IN PROGRESS'){ echo 'badge-warning'; } else { echo 'badge-success'; }?>"><?= $record["status"] ?></span>
                      </h5></th>

                      <th>
                        <?php if($record["type"] == 'Team'):?>
                          <i class="fas fa-user-friends"></i> <?= $record["type"] ?>
                        <?php else: ?>
                          <i class="fas fa-user-alt"></i> <?= $record["type"] ?>
                        <?php endif; ?>                        
                      </th>

                      <th><h5>
                          <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('detail_task.php?id=<?= $record["id_task"]; ?>&total_image=<?= $record["total_img"]; ?>&jml_teknisi=<?= $record["jml_teknisi"] ?>&return=<?= $return; ?>')">DETAIL</span> 

                          <span class="badge badge-danger" style="cursor: pointer;" id="hapusTask-<?= $record["id_task"] ?>" data-task="<?= $record["id_task"] ?>">HAPUS</span>
                      </h5></th>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
                <div class="card-footer clearfix">
                  <ul class="pagination pagination-sm m-0 float-right">
                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script>
    $('span[id*=hapusTask-]').on('click', function(){

      var IdTask = $(this).attr('data-task');
      Swal.fire({
        title: 'Yakin Dihapus ?',
        text: "Data tidak bisa dikembalikan lagi setelah dihapus !"+IdTask,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus'
      }).then((result) => {

        if (result.value){
            $.post("client_delete_task.php", {
              id_task: IdTask            
            }).done(function(data){              
              let response = JSON.parse(data);
              if( 'Failed' in response ){
                  // Failed to Delete Task
                  Swal.fire(
                    'Gagal !',
                    result.Failed,
                    'error'
                  );
              } else {
                  // Success to Delete Task
                  Swal.fire(
                    'Berhasil !',
                    result.Success,
                    'success'
                  );
                  ajax('client_issued_task.php');
              }
            });

        }

      }); // Then 

    }); // on('click')

      

    </script>