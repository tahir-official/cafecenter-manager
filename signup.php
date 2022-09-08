<?php
   include_once('include/functions.php');
   $commonFunction= new functions();
   $get_manager_portal_detail=$commonFunction->get_manager_portal_detail();
   $portal_detail=$get_manager_portal_detail->data;
   if(ENV=='prod'){
      $site_url=$portal_detail->MANAGER_PORTAL_URL;
   }else{
      $site_url=LOCAL_URL;
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
<body class="hold-transition register-page">
<div class="register-box" style="width: auto;">
<?php
  if($get_manager_portal_detail->status==1){
  ?>
  <div class="register-logo">
  <a href="<?=$portal_detail->MANAGER_PORTAL_URL?>"><img style="width: 200px;" src="<?=$portal_detail->LOGO?>" ></a>
  </div>

  <div class="card">
    <div class="card-body register-card-body">
      <p class="login-box-msg">Register a new manager</p>
      <div id="alert" ></div>
      <form method="post" id="signupFrom">
        <input type="hidden" name="page" value="signup">
        <input type="hidden" name="action" value="add_user">
        <div class="form-group">
          <select class="form-control" name="user_type" id="user_type">
              <option value="">Manager Type</option>
              <option value="1">District Manager</option>
              <option value="2">Distributor</option>
            </select>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="First Name" name="fname" id="fname">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email Address" name="email" id="email">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Mobile No." name="contact_number" id="contact_number">
            </div>
          </div>
        </div>
        <div class="form-group">
              <input type="text" class="form-control" placeholder="Address" name="address" id="address">
        </div>
        <?php
        $state_list=$commonFunction->state_list();
        $state_status=$state_list->status;
        $state_message=$state_list->message;
        $state_data=$state_list->data;
        ?>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
            <select class="form-control" name="state" id="state" <?php if($state_status == 0){ echo 'disabled'; }?> onchange="return loadDistric(this.value)">
              <?php 
              if($state_status == 0){
                echo '<option value="">'.$state_message.'</option>';
              }else{
                echo '<option value="">Select State</option>';
                foreach($state_data as $state){
                  echo '<option value="'.$state->state_id.'">'.$state->state_title.'</option>';
              }
              }
              ?>
              
            </select>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
            <select class="form-control" name="district" id="district">
              <option value="">Select District</option>
              
            </select>
            </div>
          </div>
        </div>


        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="City" name="city" id="city">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Zipcode" name="zipcode" id="zipcode">
            </div>
          </div>
        </div>

        <div class="row">
            <div class="form-group col-md-6">
                 <select id="gender" name="gender" class="form-control" >
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="Other">other</option>
                  </select>
            </div>

            <div class="form-group col-md-4">
            <input type="text" class="form-control" id="dob" name="dob" max="<?php echo date('Y-m-d')?>" value="" placeholder="Dob" onfocus="(this.type='date')"
        onblur="(this.type='text')"> 
            </div>

          <div class="form-group col-md-2">
            <input type="file" class="form-control" id="document" name="document" accept=".jpg, .jpeg, .pdf" placeholder="ID Proof" title="ID Proof">
          </div>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Password" name="password" id="password">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Confirm Password " name="c_password" id="c_password">
            </div>
          </div>
        </div>
        
        
        
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree">
              <label for="agreeTerms">
               I agree to the <a href="terms.php" target="_blank" >terms</a>
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block btnsbt" id="sdbtn" disabled>Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
   <a href="index.php" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
  <?php
  }
  else{
  ?>
  <div class="register-logo">
  Error
  </div>

  <div class="card">
    <div class="card-body register-card-body">
    <div class="alert alert-danger" role="alert">
      <?php echo $get_manager_portal_detail->message?>
    </div>
    </div>
    <!-- /.form-box -->
  </div><!-- /.card -->
  <?php

  }
?>  
  
</div>
<!-- /.register-box -->

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
