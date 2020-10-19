<?php 
require_once '../functions.php';
$records = gtask_user($_SESSION["id_user"]);
$return = 'client_issued_task.php';
 ?>
    <!-- Content Header (Page header) -->
    <section class="content-header" data-loaded="client_issued_task.php"> <!-- /.section content-header start -->
      <div class="container-fluid"> <!-- /.container-fluid start -->
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
      </div><!-- /.container-fluid end -->
    </section> <!-- /.section content-header end -->

    <!-- Main content -->
    <section class="content"> <!-- /.section content start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"> <!-- /.card-header start -->
                <h3 class="card-title"><span class="badge badge-warning">Issued Task</span></h3>
              </div> <!-- /.card-header end -->
              
              <div class="card-body"> <!-- /.card-body start-->
                <table class="table table-hover text-nowrap" id="data">
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
                          <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('detail_task.php?id=<?= $record["id_task"]; ?>&total_image=<?= $record["total_img"]; ?>&jml_teknisi=<?= $record["jml_teknisi"] ?>&return=<?= $return; ?>&teknisi_yang_dibutuhkan=<?= $record['member'] ?>')">DETAIL</span> 

                          <span class="badge badge-danger" style="cursor: pointer;" id="hapusTask-<?= $record["id_task"] ?>" data-task="<?= $record["id_task"] ?>" data-active="<?= $record["active_member"] ?>">HAPUS</span>
                      </h5></th>
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

    $('span[id*=hapusTask-]').on('click', function(){

      var IdTask = $(this).data('task');
      var ActiveMember = $(this).data('active');

      if( ActiveMember > 0 ){
        Swal.fire({
          title:'Tidak bisa dihapus !',
          icon:'error', 
          text:'Sudah ada teknisi yang akan mengerjakan Task ini !'
        })
        return;
      }

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
              id_task: IdTask,
              active_member: ActiveMember      
            }).done(function(data){      
              // return console.log(data); //
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