<?php 
session_start();
 ?>
    <!-- Content Header (Page header) -->
    <div class="content-header" data-loaded="client_create_task.php">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 text-center offset-3">
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
            <form>
              <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" class="form-control" id="taskName" aria-describedby="text">
                <small id="emailHelp" class="form-text text-muted">Beri judul task yang jelas !</small>
              </div>
              <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi">
              </div>
              <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" id="lokasi">
              </div>              
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
              </div>
              <button type="button" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>

