
<?php
   include_once('include/header.php');
   if($manager_type!=1){
    $commonFunction->redirect('dashboard.php');
   }
?>

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <section class="content-header">
      <div class="container-fluid">
        <?php
        if (isset($_SESSION['message'])){ echo $_SESSION['message'];  unset($_SESSION['message']);}
        ?>
        <div id="alert"></div>
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Distributors Management</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=$portal_detail->MANAGER_PORTAL_URL?>">Home</a></li>
              <li class="breadcrumb-item active">Distributors Management</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    
    <section class="content">
      <div class="container-fluid">
        
      <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Distributors List</h3>
                <button style="float: right;" type="button" class="btn btn-primary" onClick="load_users_popup(0,2)"><i class="fa fa-plus"></i></button>
    
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table id="mytable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>S.N.</th>
                        <th>Profile</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Wallet</th>
                        <th>Created Date</th>
                        <th>Subscription Status</th>
                        <th>Status</th>
                        <th>Action</th>
                      
                    </tr>
                  </thead>
              
                  
              </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        
      </div>
      
    </section>
    
   
  </div>
<?php
   include_once('include/footer.php');
?>

  
<script>
    $(document).ready(function(){
        tableLoad("<?=SSOAPI?>get_user_table_list",2,'manager',<?php echo $_SESSION['manager_id']?>);
    });
</script>
