<?php
include_once "lgassets/includes/connect.php";


header("Location: admin/index.php");
exit();

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="lgassets/fonts/icomoon/style.css">

  <link rel="stylesheet" href="lgassets/css/owl.carousel.min.css">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="lgassets/css/bootstrap.min.css">

  <!-- Style -->
  <link rel="stylesheet" href="lgassets/css/style.css">

  <title>Login #6</title>
</head>

<body>


  <div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('lgassets/images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">

      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <div class="mb-4">
              <h3>Sign In</h3>
              <p class="mb-4">This portal is work in progress and is only available to some students for testing.</p>
            </div>
            <form action="lgassets/includes/login.inc.php" method="post">
              <div class="form-group first">
                <label for="username">SCC-ID</label>
                <input type="text" class="form-control" name="user" id="username" required>

              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="pass" id="password" required>

              </div>

              <!-- <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
              </div> -->

              <input type="submit" name="login" value="Log In" class="btn btn-block btn-primary">

              <!-- <span class="d-block text-center my-4 text-muted">&mdash; or &mdash;</span>
              
              <div class="social-login">
                <a href="#" class="facebook btn d-flex justify-content-center align-items-center">
                  <span class="icon-facebook mr-3"></span> Login with Facebook
                </a>
                <a href="#" class="twitter btn d-flex justify-content-center align-items-center">
                  <span class="icon-twitter mr-3"></span> Login with  Twitter
                </a>
                <a href="#" class="google btn d-flex justify-content-center align-items-center">
                  <span class="icon-google mr-3"></span> Login with  Google
                </a>
              </div> -->
            </form>
          </div>
        </div>
      </div>
    </div>


  </div>



  <script src="lgassets/js/jquery-3.3.1.min.js"></script>
  <script src="lgassets/js/popper.min.js"></script>
  <script src="lgassets/js/bootstrap.min.js"></script>
  <script src="lgassets/js/main.js"></script>
</body>

</html>