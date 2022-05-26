<?php
   include_once('include/functions.php');
   $commonFunction= new functions();
   $get_manager_portal_detail=$commonFunction->get_manager_portal_detail();
   $portal_detail=$get_manager_portal_detail->data;
   if(ENV=='prod'){
      $site_url=$portal_detail->MANAGER_PORTAL_URL;
   }else{
      $site_url='https://localhost/cafecenter-manager/';
   }
   if(isset($_SESSION['is_manager_logged_in'])){ $commonFunction->redirect('dashboard.php'); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
  if($get_manager_portal_detail->status==1){
    echo '<title>'.$portal_detail->MANAGER_PROJECT.'</title>';
  }else{
    echo '<title>Error</title>';
  }
  ?>
  

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="icon" type="image/x-icon" href="<?=$portal_detail->SITE_ICON?>">
</head>
<body class="hold-transition login-page">
<div class="login-box">
<?php
  if($get_manager_portal_detail->status==1){
    ?>
      <div class="login-logo">
      <a href="<?=$site_url?>"><img style="width: 200px;" src="<?=$portal_detail->LOGO?>" ></a>
     </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
      <div id="alert" ></div>
      <?php
       if (isset($_SESSION['message'])){ echo $_SESSION['message'];  unset($_SESSION['message']);}
      ?>
      <form method="post" id="loginFrom">
        <div class="input-group mb-3">
          <input type="text" name="username" id="username" class="form-control" placeholder="Username (Phone or Email)" value="<?php if(isset($_COOKIE["loginId"])) { echo $_COOKIE["loginId"]; } ?>">
          <div class="input-group-append input-group-text">
             <span class="fas fa-envelope"></span>
           </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" id="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE["loginPass"])) { echo $_COOKIE["loginPass"]; } ?>">
          <div class="input-group-append input-group-text toggle-password">
             <span class="fas fa-lock"></span>
          </div>
           
        </div>
        <div class="row">
          <!-- <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember" name="remember" <?php if(isset($_COOKIE["loginId"])) { ?> checked <?php } ?>>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div> -->
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btnLogin">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <p class="mb-1">
        <a href="forgot-password.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="signup.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
    <?php
  }else{
    ?>
    <div class="login-logo">
     Error
    </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
    <div class="alert alert-danger" role="alert">
                          <?php echo $get_manager_portal_detail->message?>
                        </div>
     </div>
    <!-- /.login-card-body -->
  </div>
    <?php
  }
?>
  
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<script src="dist/js/jquery.validate.min.js"></script>
<script type="text/javascript">
      let baseUrl = '<?=$site_url;?>';
</script>
<script src="dist/js/custom.js"></script>

</body>
</html>
