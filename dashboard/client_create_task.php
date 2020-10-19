<?php 
session_start();
 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="client_create_task.php">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col text-center">
            <h2>Create Task</h2>
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
                <label for="taskName">Judul Tugas / Komplain</label>
                <input type="text" class="form-control" id="taskName"  placeholder="Masukan Judul Tugas / Komplain Disini">
              </div>

              <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi" placeholder="Masukan Lokasi Disini">
                <small class="form-text text-muted">Tulis lokasi dengan jelas!</small>
              </div>

              <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" rows="3" placeholder="Masukan Deskripsi Disini"></textarea>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="tipe">Tipe Pekerjaan</label>
                    <select class="form-control" id="tipe" name="tipe">
                      <option value="Individu">Individu</option>
                      <option value="Team">Team</option>
                    </select>
                    <small class="form-text text-muted">Pilih tipe yang sesuai untuk menentukan apakah tugas perlu diselesaikan oleh Team atau Individu.</small>
                  </div>
                </div>
                <div class="col d-none" id="NumUser">
                  <div class="form-group">
                    <label for="member">Jumlah Anggota</label>
                    <input class="form-control" type="number" name="member" id="member">
                  </div>                  
                </div>
              </div>

              <div class="row">
                <div class="col">
                  <div class="form-group">
                    <label for="taskImg">Upload Foto</label>
                      <input type="file" class="form-control" id="taskImg" name="taskImg[]" multiple accept="image/*">
                    <small class="form-text text-muted">Upload Foto yang menggambarkan kondisi saat ini, sebelum Teknisi datang memperbaiki / menyelesaikan komplain.</small>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-around flex-wrap" id="imgPreview">

              </div>

              <div class="row">
                <div class="col text-center">
                  <button type="button" class="btn btn-primary my-4" id="createTask">Submit</button>
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
    $('#createTask').on('click', function(){
        var form = new FormData(); // Form Data for Passing Input through Javascript

        // Get Form Values
        var taskName = $('#taskName').val();
        var lokasi = $('#lokasi').val();
        var deskripsi = $('#deskripsi').val();
        var tipe = $('#tipe').val();
        var files = [];
        for( var i=0; i< $("input[type=file]").get(0).files.length; ++i ){
          files[i] = $("input[type=file]").get(0).files[i];
          form.append('file'+i,files[i]);          
        }
        form.append('taskName', taskName);
        form.append('lokasi', lokasi);
        form.append('deskripsi', deskripsi);
        form.append('tipe', tipe);
        if(tipe == "Team"){
          form.append('member',$('#member').val());
        } else {
          form.append('member',1);
        }
        form.append('submit', 'submit');
        form.append('id_client', <?= $_SESSION['id_client']; ?>);
        // Send FormData to Backend
        $.ajax({
            url: 'create_task_ajax.php',
            type: 'post',
            data: form,
            contentType: false,
            processData: false,
            success: function(response){
              // return console.log(response); // FOR DEBUGGING
              let result = JSON.parse(response);
              if( 'Success' in result ){
                // Success create Task
                Swal.fire(
                  'Berhasil !',
                  result.Success,
                  'success'
                );
                ajax('client_issued_task.php')
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

