<?php 
require_once '../functions.php';
$records = gAll_AvailableTask($_SESSION["id_teknisi"]);
$return = "available_task.php";

// var_dump($records); exit();

 ?>
    <!-- Content Header (Page header) -->
    <section class="content-header" data-loaded="available_task.php"> <!-- /.section content-header start -->
      <div class="container-fluid"> <!-- /.container-fluid start -->
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
      </div><!-- /.container-fluid end -->
    </section> <!-- /.section content-header end -->

    <!-- Main content -->
    <section class="content"> <!-- /.section content start -->
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header"> <!-- /.card-header start -->
                <h3 class="card-title"><span class="badge badge-primary">Available Task</span></h3>
              </div> <!-- /.card-header end -->
              
              <div class="card-body"> <!-- /.card-body start-->
                <table id="data" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Taskname</th>
                      <th>Pengaju</th>
                      <th>Tipe</th>
                      <th>Anggota yang dibutuhkan</th>
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

                      <th><?= $record["pengaju"] ?></th>

                      <th>
                        <?php if($record["type"] == 'Team'):?>
                          <i class="fas fa-user-friends"></i> <?= $record["type"] ?>
                        <?php else: ?>
                          <i class="fas fa-user-alt"></i> <?= $record["type"] ?>
                        <?php endif; ?>
                      </th>

                      <th><?= $record['technician_needed']; ?></th>

                      <th><?= $record['new_date']; ?></th>

                      <th class="d-flex justify-content-around">
                        <h5>
                        <span class="badge badge-primary" style="cursor: pointer;" onclick="ajax('detail_task.php?id=<?= $record["id_task"]; ?>&total_image=<?= $record["total_img"]; ?>&jml_teknisi=<?= $record["jml_teknisi"] ?>&return=<?= $return; ?>')">DETAIL</span>
                        </h5>

                        <h5>
                        <span class="badge badge-success" style="cursor: pointer;" data-type="<?= $record["type"] ?>" data-member="<?= $record["member"]?>" data-active="<?= $record["active_member"] ?>" id="task" data-id="<?= $record["id_task"] ?>" data-teknisi="<?= $_SESSION["id_teknisi"]; ?>">AMBIL</span>
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
      $('span[id*=task]').on('click', function(){
        var type = $(this).data('type');
        var member = $(this).data('member');
        var active = $(this).data('active');
        var IdTask = $(this).data('id');
        var id_teknisi = $(this).data('teknisi');
        Swal.fire({
          text: 'Ingin mengambil pekerjaan ini ?',
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
                // return console.log(data); // DEBUGGING
                let response = JSON.parse(data);
                if( 'Failed' in response ){
                    // Failed to Delete Task
                    Swal.fire({
                      title:'Gagal !',
                      icon:'error'
                    });
                } else {
                    // Success to Delete Task
                    Swal.fire({
                      title:'Berhasil !',
                      icon:'success'
                    });
                    ajax('current_task.php');
                }
              });

          }

        }); // Then 

      });
    </script>