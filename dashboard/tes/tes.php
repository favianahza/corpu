
<script src="dist/assets/jquery-file-upload/js/vendor/jquery.ui.widget.js"></script>
<script src="dist/assets/jquery-file-upload/js/jquery.iframe-transport.js"></script>
<script src="dist/assets/jquery-file-upload/js/jquery.fileupload.js"></script>
<script src="dist/assets/jquery-file-upload/js/p.js"></script>

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

<div class="container">
    <div class="row bg-light">
        <div class="col-12">
        <h2>Ajax Multiple Image Uploader</h2>
        <hr>
            <div class="container1">
                <div>
                    <form method="post" action="server/form_process.php">

                        <!-- This area will show the uploaded files -->
                        <div class="row">
                            <div id="uploaded_images" class="col bg-secondary py-1">
                            </div>
                        </div>

                        <br>

                        <div id="select_file">
                            <div class="form-group">
                                <label>Upload Image</label>
                            </div>
                            <div class="form-group">
                                <!-- The fileinput-button span is used to style the file input field as button -->
                                <span class="btn btn-success fileinput-button">
                                    <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files" accept="image/x-png, image/gif, image/jpeg" >
                            </span>
                                <br>
                                <br>
                                <!-- The global progress bar -->
                                <div id="progress" class="progress">
                                    <div class="progress-bar progress-bar-success"></div>
                                </div>
                                <!-- The container for the uploaded files -->
                                <div id="files" class="files"></div>
                                <input type="text" name="uploaded_file_name" id="uploaded_file_name" hidden>
                                <br>
                            </div>
                        </div>

                        <button type="button" class="btn btn-primary" name="submit" id="Submit">Submit</button>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>