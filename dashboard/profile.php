<?php 
session_start();
 ?>
    <!-- Content Header (Page header) -->
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