<?php 
include 'functions.php';

( isset($_COOKIE["login[stat]"]) ? header("location:index") : false );

if( isset($_SESSION["logged_in"]) && isset($_SESSION["id_user"]) && isset($_SESSION["type"])){ header("Location: dashboard"); }


if( isset($_POST["signUp"]) ) {
    $con = (register()) ? header("location:login") : false;
} elseif( isset($_POST["signIn"]) ) {
    $con = (login()) ? header("location:login") : false;
} else {
    $con = false;
}

 ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/login.css">
    <title>Bootstrap 4 Login/Register Form</title>
</head>
<body>
        <!-- Loading Screen -->
  <div id="loader-wrapper">
    <div id="loader"></div>
  </div>
  <div class="row h-100">
    <div id="logreg-forms" class="my-auto">

        <!-- SIGNIN FORM-->        
        <form class="form-signin" method="POST">
        <h1 class="h3 mb-4 font-weight-bold" style="text-align: center">Login</h1>
<!--             <h1 class="h3 mb-3 font-weight-bold" style="text-align: center"> Sign in</h1>
            <div class="social-login">
                <button class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign in with Facebook</span> </button>
                <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button>
            </div>
            <p style="text-align:center"> OR  </p> -->
            <input type="text" id="inputEmail" class="form-control" placeholder="Username" required="" autofocus="" autocomplete="off" name="username">
            <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="" autocomplete="off" name="password">
            <div class="row text-center mt-2 mx-auto">
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input d-inline-block" type="checkbox" id="cookie" name="cookie">
                <label class="custom-control-label d-inline-block" for="cookie">Remember Me</label>
              </div>    
            </div>
            <button class="btn btn-success btn-block" type="submit"  name="signIn"><i class="fas fa-sign-in-alt"></i> Login </button>
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
            </form>

<!--        <form action="/reset/password/" class="form-reset">
                <input type="email" id="resetEmail" class="form-control" placeholder="Email address" required="" autofocus="">
                <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
                <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
            </form> -->
            
            <!-- SIGNUP FORM-->
            <form class="form-signup" method="POST">
              <h1 class="h3 mb-4 font-weight-bold" style="text-align: center;">Sign Up</h1>
                <input type="text" id="full-name" name="fullname" class="form-control mb-3" placeholder="Full name" required="" autofocus="" autocomplete="off" required>
                <input type="text" id="user-name" name="username" class="form-control mb-3" placeholder="Username" required autofocus="" autocomplete="off" required>
                <input type="password" id="user-pass" name="pass" class="form-control mb-3" placeholder="Password" required autofocus="" autocomplete="off" required minlength="1">
                <input type="password" id="user-repeatpass" name="cpass" class="form-control" placeholder="Repeat Password" required autofocus="" autocomplete="off" minlength="1">
                <small id="pass" class="form-text text-muted">Minimum Password Length is 7 Character.</small>
                <select class="form-control mt-3" id="utype" name="utype" required>
                  <option disabled selected>Tipe User</option>
                  <option value="1">Client</option>
                  <option value="2">Teknisi</option>
                </select>
                <div class="row text-center mt-2 mx-auto">
                  <div class="custom-control custom-checkbox">
                    <input class="custom-control-input d-inline-block" type="checkbox" id="show" name="show">
                    <label class="custom-control-label d-inline-block" for="show">Show Password</label>
                  </div>    
                </div>
                <button class="btn btn-primary btn-block" type="submit" name="signUp"><i class="fas fa-user-plus"></i> Sign Up</button>
                <button  id="cancel_signup" class="btn btn-info btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign In</button>
                <button class="btn btn-primary btn-block google-btn border-danger" type="button"><span><i class="fab fa-google-plus-g"></i> Sign up with Google+</span> </button>
            </form>
            
    </div>
   </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="assets/js/login.js"></script>
</body>
</html>