<?php 
require_once '../functions.php';
$id = $_GET["id"];
$issuer_id = $_GET["issuer_id"];
$record = gtask_by_id($id);

if($record == NULL){ echo "No record found"; die(); }


 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="teknisi_complete_task.php">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col text-center">
          	<div class="col"><h5><span class="badge badge-secondary" onclick="ajax('current_task.php')" style="cursor: pointer;">Kembali ke halaman sebelumnya</span></h5></div>
            <h2>Laporkan Penyelesaian Task</h2>
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
            <input type="hidden" value="<?= $record["taskname"] ?>" id="taskName">
            <input type="hidden" value="<?= $record["id_task"] ?>" id="id_task">
            <input type="hidden" value="<?= $record["issuer_id"] ?>" id="issuer_id">

              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" rows="6" placeholder="Masukan Deskripsi Disini"></textarea>
                <small class="form-text text-muted">Masukan deskripsi yang menjelaskan bahwa tugas telah selesai.</small>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="taskImg">Upload Foto</label>
                      <input type="file" class="form-control" id="taskImg" name="taskImg[]" multiple accept="image/*" required>
                    <small class="form-text text-muted">Upload Foto yang membuktikan bahwa tugas telah selesai.</small>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-around flex-wrap" id="imgPreview">

              </div>

              <div class="row">
                <div class="col text-center">
                  <button type="button" class="btn btn-primary my-4" id="reportTask">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
    <script>  
    // Image Preview before Upload
    $("#taskImg").on('change',function(){
        $("#imgPreview").empty();

        for(let i=0;i<this.files.length;++i){
            let filereader = new FileReader();
            let $img= $.parseHTML("<img src='' width='125' height='125' class='thumb'>");
            filereader.onload = function(){
                $img[0].src=this.result;
            };
            filereader.readAsDataURL(this.files[i]);
            $("#imgPreview").append($img);
        }


    });

    // Submit Task
    $('#reportTask').on('click', function(){
        var form = new FormData(); // Form Data for Passing Input through Javascript

        if(  $('#deskripsi').val() == "" ){
          return Swal.fire('Gagal !', 'Isi form dengan lengkap !', 'error');
        }

        var files = [];
        for( var i=0; i< $("input[type=file]").get(0).files.length; ++i ){
          files[i] = $("input[type=file]").get(0).files[i];
          form.append('file'+i,files[i]);          
        }
        form.append('taskName', $('#taskName').val());
        form.append('deskripsi', $('#deskripsi').val());
        form.append('id_task', $('#id_task').val());
        form.append('issuer_id', $('#issuer_id').val());
        form.append('submit', 'submit');
        // Send FormData to Backend
        $.ajax({
            url: 'report_completion_ajax.php',
            type: 'post',
            data: form,
            contentType: false,
            processData: false,
            success: function(response){
              return console.log(response); // FOR DEBUGGING
              let result = JSON.parse(response);
              if( 'Success' in result ){
                // Success create Task
                Swal.fire(
                  'Berhasil !',
                  result.Success,
                  'success'
                );
                ajax('completed_task.php');
              } else if('Alert' in result ){
                Swal.fire(
                  'Gagal !',
                  result.Alert,
                  'error'
                );
              }

            } 
        }); // ajax

    });


    // Type form toggler
    $(function(){
        $('#tipe').on('change', function(){
          if( $('#tipe').val == 'Team' ){
            $('#NumUser').toggleClass('d-none');
          } else {
            $('#NumUser').toggleClass('d-none');
          }
        });
    })    
    </script>