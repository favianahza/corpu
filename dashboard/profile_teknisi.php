<?php 
require_once '../functions.php';

$id_teknisi = $_GET["id"];
$img = $_GET["img"];
$return = $_GET["return"];
$query = "SELECT fullname, current_task, completed_task, total_task FROM t_teknisi WHERE id_teknisi = $id_teknisi";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
$teknisi = mysqli_fetch_assoc($result);

 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="profile_teknisi.php?id=<?=$id_teknisi; ?>">
      <div class="container px-5">
        <div class="row">
          <div class="col text-center">
            <h5><span class="badge badge-secondary" onclick="ajax('<?= $return; ?>')" style="cursor: pointer;">Kembali ke halaman sebelumnya</span></h5>
            <h1 class="m-0 text-dark">Profile Teknisi</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container">
        <div class="row">
          <div class="col col-md-8 offset-md-2">
              <form>
                <center><img src="../assets/img/profile/<?= $img ?>" class="shadow" style=" border-radius: 50%; width: 175px; height: 175px;" id="YourProfile"></center>
                <div class="form-group">
                  <label for="fullname">Fullname</label>
                  <input class="form-control" id="fullname" disabled value="<?= $teknisi["fullname"] ?>">
                </div>
                <div class="form-group">
                  <label for="">Account Type</label>
                  <input class="form-control" id="" disabled value="Teknisi">
                </div>
                  <div class="row">
                    <!-- /.col -->
                    <?php if(isset($id_teknisi)):?>

                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Current Task</span>
                          <span class="info-box-number"><?= $teknisi["current_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->

                    <!-- fix for small devices only -->
                    <div class="clearfix hidden-md-up"></div>

                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Completed Task</span>
                          <span class="info-box-number"><?= $teknisi["completed_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Total Task</span>
                          <span class="info-box-number"><?= $teknisi["total_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->                    
                    <?php endif; ?>

                  </div> <!-- /.row -->
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->