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
        <a href="#main" class="nav-link" onclick="ajax('main.php')">Change Password</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Change Profile Pict</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Loading Screen -->
  <div id="loader-wrapper">
    <div id="loader"></div>
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
          <img src="../assets/img/profile/<?= (isset($_SESSION["id_user"]) ? $_SESSION["profile_pict"] : '000-user.png'); ?>" class="img-circle elevation-2" alt="User Image">
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
    <div id="content-loader"></div>
  </div>

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
</body>
</html>
