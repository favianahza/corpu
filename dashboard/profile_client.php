<?php 
require_once '../functions.php';

$id_client = $_GET["id"];
$img = $_GET["img"];
$return = $_GET["return"];
$query = "SELECT fullname, issued_task, completed_issued_task FROM t_client WHERE id_client = $id_client";
$result = mysqli_query($connect, $query) or die(mysqli_error($connect));
$client = mysqli_fetch_assoc($result);

 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="profile_client.php?id=<?=$id_client; ?>">
      <div class="container px-5">
        <div class="row">
          <div class="col text-center">
            <h5><span class="badge badge-secondary" onclick="ajax('<?= $return; ?>')" style="cursor: pointer;">Kembali ke halaman sebelumnya</span></h5>
            <h1 class="m-0 text-dark">Profile Client</h1>
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
                  <input class="form-control" id="fullname" disabled value="<?= $client["fullname"] ?>">
                </div>
                <div class="form-group">
                  <label for="">Account Type</label>
                  <input class="form-control" id="" disabled value="Client">
                </div>
                  <div class="row">
                    <!-- /.col -->
                    <?php if(isset($id_client)):?>

                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-envelope-open-text"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Issued Task</span>
                          <span class="info-box-number"><?= $client["issued_task"] ?></span>
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
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check-circle"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Completed Issued Task</span>
                          <span class="info-box-number"><?= $client["completed_issued_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>                 
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