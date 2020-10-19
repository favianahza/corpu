<?php 
require_once '../functions.php';
$records = gAll_AvailableTask($_SESSION["id_teknisi"]);
$return = "available_task.php";

 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="available_task.php">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Available Task</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active"><?= date('d/m/Y') ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
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
                <h3 class="card-title"><span class="badge badge-primary">Available Task</span></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="data" class="table table-hover table-striped">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Taskname</th>
                      <th>Lokasi</th>
                      <th>Pengaju</th>
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

                      <th><?= $record["pengaju"] ?></th>

                      <th>
                        <?php if($record["type"] == 'Team'):?>
                          <i class="fas fa-user-friends"></i> <?= $record["type"] ?>
                        <?php else: ?>
                          <i class="fas fa-user-alt"></i> <?= $record["type"] ?>
                        <?php endif; ?>
                      </th>

                      <th><h5>
                        <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('detail_task.php?id=<?= $record["id_task"]; ?>&total_image=<?= $record["total_img"]; ?>&jml_teknisi=<?= $record["jml_teknisi"] ?>&return=<?= $return; ?>')">DETAIL</span>

                        <span class="badge badge-success" style="cursor: pointer;" data-type="<?= $record["type"] ?>" data-member="<?= $record["member"]?>" data-active="<?= $record["active_member"] ?>" id="take" data-id="<?= $record["id_task"] ?>" data-teknisi="<?= $_SESSION["id_teknisi"]; ?>">AMBIL</span>
                      </h5></th>

                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div> <!-- /.card -->            
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <script>
      $("#data").DataTable({
        "responsive": true,
        "autoWidth": false,
      });      
      $('span[id*=take]').on('click', function(){
        var type = $(this).data('type');
        var member = $(this).data('member');
        var active = $(this).data('active');
        var IdTask = $(this).data('id');
        var id_teknisi = $(this).data('teknisi');
        Swal.fire({
          title: 'Yakin ?',
          text: "Ingin mengerjakan tugas ini ?",
          icon: 'question',
          showCancelButton: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Ambil'
        }).then((result) => {

          if (result.value){
              $.post("teknisi_append_task.php", {
                id_task: IdTask,
                type : type,
                member : member,
                active : active,
                id_teknisi: id_teknisi
              }).done(function(data){              
                // return console.log(data);
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
                    ajax('available_task.php');
                }
              });

          }

        }); // Then 

      });
    </script>