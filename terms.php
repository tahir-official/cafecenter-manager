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

   $get_page_detail_by_id=$commonFunction->get_page_detail_by_id(182);
   $page_detail=$get_page_detail_by_id->data;
   
   
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
    <div class="card-body register-card-body" style="max-width: 1200px;">
      
     <?php echo $page_detail;?>
      
   
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
