<?php 
include '../functions.php';


if (isset($_SESSION["logged_in"])) {
  if(isset($_COOKIE["login"]["stat"]) && isset($_COOKIE["login"]["id_user"])){
    $record = gdata_user(base64_decode(base64_decode($_COOKIE["login"]["id_user"])), base64_decode(base64_decode($_COOKIE["login"]["type"]        )));
    $_SESSION["logged_in"] = true;
    $_SESSION["id_user"] = base64_decode(base64_decode($_COOKIE["login"]["id_user"]));
  } else {
    false;
  }
  session_exp();

} else {
  header("location:../index");
}


 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Web Corpu</title>
  <link rel="stylesheet" href="../assets/bs4/css/bootstrap.css">
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../assets/css/dashboard.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <!-- REQUIRED SCRIPTS -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- Custom Script -->
  <script src="../assets/js/dashboard.js" async></script>  
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#ChangePassword" class="nav-link" data-toggle="modal" data-target="#changeAP">Change Password</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link" data-toggle="modal" data-target="#changePP">Change Profile Pict</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Loading Screen -->
  <div id="loader-wrapper">
    <div class="loadingio-spinner-pulse-xb8bvblk92e"><div class="ldio-bujfm3460jd">
    <div></div><div></div><div></div>
    </div></div>
  </div>

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center">
      <span class="brand-text font-weight-light">TACACS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../assets/img/profile/<?= (isset($_SESSION["id_user"]) ? $_SESSION["profile_pict"] : '000-user.png'); ?>" class="img-circle elevation-2" alt="User Image" style="border-radius: 50%;">
        </div>
        <div class="info">

          <?php if (isset($_SESSION["id_user"]) && isset($_SESSION["logged_in"])) : ?>
          <a href="#" class="d-block"><?= $_SESSION["fullname"] ?></a>
          <?php else: ?>
          <a href="#" class="d-block">Welcome !</a>
          <?php endif; ?>

        </div>
      </div>

      <!-- Sidebar Menu --> 
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if( $_SESSION["type"] == 2 ) : ?>
          <!-- Sidebar Technician  -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Task
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#AvailableTask" class="nav-link" onclick="ajax('available_task.php');">
                  <i class="fas fa-plus-circle nav-icon"></i>
                  <p>Available Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#CurrentTask" class="nav-link" onclick="ajax('current_task.php');">
                  <i class="fas fas fa-info-circle nav-icon"></i>
                  <p>Current Task</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="#CompletedTask" class="nav-link"  onclick="ajax('completed_task.php');">
                  <i class="fas fa-check-circle nav-icon"></i>
                  <p>Completed Task</p>
                </a>
              </li>
            </ul>
          </li>

          <?php elseif($_SESSION["type"] == 1): ?>
          <!-- Sidebar Client  -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tasks"></i>
              <p>
                Task
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#CreateTask" class="nav-link" onclick="ajax('client_create_task.php');">
                  <i class="fas fa-edit nav-icon"></i>
                  <p>Create Task</p>
                </a>
              </li>              
              <li class="nav-item">
                <a href="#IssuedTask" class="nav-link" onclick="ajax('client_issued_task.php');">
                  <i class="fas fa-envelope-open-text nav-icon"></i>
                  <p>Issued Task</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#CompletedTask" class="nav-link"  onclick="ajax('client_completed_task.php');">
                  <i class="fas fa-check-circle nav-icon"></i>
                  <p>Completed Task</p>
                </a>
              </li>
            </ul>
          </li>

          <?php endif; ?>
          <li class="nav-item">
            <a href="#Profile" class="nav-link" onclick="ajax('profile.php');">
              <i class="nav-icon fas fa-user-circle"></i>
              <p>
                Profile
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Simple Link
              </p>
            </a>
          </li>

          <?php if(isset($_SESSION["logged_in"]) && isset($_SESSION["id_user"]) ) : ?>
          <li class="nav-item">
            <a href="../logout" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Log Out
              </p>
            </a>
          </li>
          <?php endif; ?>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- CONTENT -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="CONTENT">
  <div id="content-loader-wrapper">

  </div>

    <div class="content-header" data-loaded="profile.php">
      <div class="container px-5">
        <div class="row">
          <div class="col text-center">
            <h1 class="m-0 text-dark">Your Profile</h1>
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
                <center><img src="../assets/img/profile/<?= $_SESSION["profile_pict"] ?>" class="shadow" style=" border-radius: 50%; width: 175px; height: 175px;"></center>
                <div class="form-group">
                  <label for="fullname">Fullname</label>
                  <input class="form-control" id="fullname" disabled value="<?= $_SESSION["fullname"] ?>">
                </div>
                <div class="form-group">
                  <label for="">Account Type</label>
                  <input class="form-control" id="" disabled value="<?= $_SESSION["acc_type"] ?>">
                </div>
                <!-- <div class="row">
                  <div class="form-group col-md-4">
                    <label for="">Current Task</label>
                    <input class="form-control" id="" disabled value="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Completed Task</label>
                    <input class="form-control" id="" disabled value="">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="">Total Task</label>
                    <input class="form-control" id="" disabled value="">
                  </div> -->

                  <div class="row">
                    <!-- /.col -->
                    <?php if($_SESSION["type"] == 2):?>

                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Current Task</span>
                          <span class="info-box-number"><?= $_SESSION["current_task"] ?></span>
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
                          <span class="info-box-number"><?= $_SESSION["completed_task"] ?></span>
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
                          <span class="info-box-number"><?= $_SESSION["total_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <?php elseif($_SESSION["type"] == 1): ?>

                    <div class="col-12">
                      <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                        <div class="info-box-content">
                          <span class="info-box-text">Issued Task</span>
                          <span class="info-box-number"><?= $_SESSION["issued_task"] ?></span>
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
                          <span class="info-box-number"><?= $_SESSION["completed_issued_task"] ?></span>
                        </div>
                        <!-- /.info-box-content -->
                      </div>
                      <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <?php endif; ?>
                  </div>

                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

  

  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    </div>
    <!-- Default to the left -->
    <strong>This Dashboard provided by <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
</div>
<!-- ./wrapper -->

<!-- MODAL BOSS -->
<!-- MODAL CHANGE PASSWORD -->
<div class="modal fade" id="changeAP" tabindex="-1" role="dialog" aria-labelledby="changePassword" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changePassword">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="POST">

        <div class="form-group">
            <label for="Password" class="col-form-label">Enter your New Password</label>
            <input class="form-control" type="password" id="new_password_ep" name="password" required placeholder="Masukan Password Baru" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="KPassword" class="col-form-label">Confirm your New Password</label>
            <input class="form-control" type="password" id="c_password_ep" name="kpassword" required placeholder="Masukan Konfirmasi Password Baru" autocomplete="off">
        </div>

        <div class="form-group">
            <label for="KPassword" class="col-form-label">Insert your Old Password</label>
            <input class="form-control" type="password" id="o_password_ep" name="opassword" required placeholder="Masukan Password Lama" autocomplete="off">
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="show" name="show">
            <label class="custom-control-label" for="show" style="cursor: pointer;">Tampilkan Password</label>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-primary" id="edit_pass">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- MODAL CHANGE PROFILE PICT -->
<div class="modal fade" id="changePP" tabindex="-1" role="dialog" aria-labelledby="changeProfilePict" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="changeProfilePict">Change Profile Pict</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <form method="POST" enctype="multipart/form-data">

        <div class="row">
          <div class="col">
            <div class="form-group text-center font-weight-bolder">
              <img src="../assets/img/profile/<?=  $_SESSION['profile_pict'] ?>" id="preview-img" onclick="triggerClick();" class="cursor-pointer rounded-circle shadow" width="150" height="150" style="cursor: pointer;"><br><br>
              <label for="foto" class="cursor-pointer">Foto</label>
              <input type="file" name="foto" id="foto" class="form-control" style="display: none;" onchange="preview(this);" required>
            </div>
          </div>
        </div>    

        <div class="form-group">
            <label for="Password" class="col-form-label">Enter your Password</label>
            <input class="form-control" type="password" id="password_pp" name="password_pp" required placeholder="Masukan Password Anda" autocomplete="off" required>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="show_pp" name="show_pp">
            <label class="custom-control-label" for="show_pp" style="cursor: pointer;">Tampilkan Password</label>
        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-primary" id="edit_pp">Edit</button>
        </form>
      </div>
    </div>
  </div>
</div>

</body>
</html>
