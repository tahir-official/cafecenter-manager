<?php
   include_once('include/functions.php');
   $commonFunction= new functions();
   $get_manager_portal_detail=$commonFunction->get_manager_portal_detail();
   $portal_detail=$get_manager_portal_detail->data;
   if(!isset($_SESSION['is_manager_logged_in'])){ $commonFunction->redirect('index.php'); }
   
   $manager_detail=$commonFunction->manager_detail($_SESSION['manager_id']);
   $manager_data=$manager_detail->data;
   $manager_type=$manager_data->user_type;
   if(ENV=='prod'){
    $site_url=$portal_detail->MANAGER_PORTAL_URL;
   }else{
    $site_url=LOCAL_URL;
   }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
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
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
  <link rel="icon" type="image/x-icon" href="<?=$portal_detail->SITE_ICON?>">
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <script>
   <?php
   $load_paywall=false;
   if($get_manager_portal_detail->status==0){
    $portal_error_html='<img src="'.$portal_detail->ERROR_500.'" />'; 
    ?>
     $(document).ready(function() {
        $(".wrapper").html('<?=$portal_error_html?>'); 
        $(".wrapper").css('text-align','center');
     });
   <?php
   }else if($manager_detail->status==0){
    $manager_error_html='<img src="'.$portal_detail->ERROR_403.'" />'; 
    ?>
     $(document).ready(function() {
        $(".wrapper").html('<?=$manager_error_html?>'); 
        $(".wrapper").css('text-align','center');
     });
   <?php
   }else if($manager_data->subscription_status==0){
    
    ?>
    $(document).ready(function() {
    load_paywall('<?=$_SESSION["manager_id"]?>');
    });
    <?php
    $load_paywall=true;
   }
   

   ?>
  </script>
  <style>
  #loader{
  height: 400px;
  background: url("<?=$portal_detail->LOADER_IMG?>") no-repeat center;
               
  }
  
  </style>
  
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<?php
require('razorpay-php/Razorpay.php');
// Create the Razorpay Order
use Razorpay\Api\Api;

$api = new Api($portal_detail->keyId, $portal_detail->keySecret);

$url=SSOAPI.'get_plan_by_user_type';
$data=array(
    'user_type' => $_SESSION['manager_type'],
    'api_key' => API_KEY
);
$method='POST';
$response=$commonFunction->curl_call($url,$data,$method);
$result = json_decode($response);
$plan_data=$result->data;

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$fourRandomDigit = rand(1000,9999);

$orderData = [
    'receipt'         => 'rcptid_'.$fourRandomDigit,
    'amount'          => $plan_data->plan_amount * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($portal_detail->displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$portal_detail->displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$portal_detail->displayCurrency] * $amount / 100;
}
$merchant_order_id= $razorpayOrderId.'_'.rand(100000,999999);
$data = [
    "key"               => $portal_detail->keyId,
    "amount"            => $amount,
    "name"              => $portal_detail->MANAGER_PROJECT,
    "description"       => $plan_data->plan_heading,
    "image"             => $portal_detail->LOGO,
    "prefill"           => [
    "name"              => $manager_data->fname.' '.$manager_data->lname,
    "email"             => $manager_data->email,
    "contact"           => $manager_data->contact_number,
    ],
    "notes"             => [
    "address"           => $manager_data->address,
    "merchant_order_id" => $merchant_order_id,
    ],
    "theme"             => [
    "color"             => "#343a40"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($portal_detail->displayCurrency !== 'INR')
{
    $data['display_currency']  = $portal_detail->displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

if($load_paywall==true){
  ?>
  <button id="rzp-button1" class="btn btn-info btn-lg second" style="display:none" >Pay with Razorpay</button>
  <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  <form name='razorpayform' action="include/process.php" method="POST">
      <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id" >
      <input type="hidden" name="razorpay_signature"  id="razorpay_signature" >
      <input type="hidden" name="action"  value="verify_payment" >
      
  </form>
  <script>
  // Checkout details as a json
  var options = <?php echo $json?>;

  /**
   * The entire list of Checkout fields is available at
   * https://docs.razorpay.com/docs/checkout-form#checkout-fields
   */
  options.handler = function (response){
      document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
      document.getElementById('razorpay_signature').value = response.razorpay_signature;
      document.razorpayform.submit();
  };

  // Boolean whether to show image inside a white frame. (default: true)
  options.theme.image_padding = false;

  options.modal = {
      ondismiss: function() {
          console.log("This code runs when the popup is closed");
      },
      // Boolean indicating whether pressing escape key 
      // should close the checkout form. (default: true)
      escape: true,
      // Boolean indicating whether clicking translucent blank
      // space outside checkout form should close the form. (default: false)
      backdropclose: false
  };

  var rzp = new Razorpay(options);

  document.getElementById('rzp-button1').onclick = function(e){
      rzp.open();
      e.preventDefault();
  }
  </script>
  <?php
}
?> 



<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=$site_url?>" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="<?=$site_url?>profile.php" class="nav-link">Profile</a>
      </li>
      
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
      
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="<?=$site_url?>logout.php" >
          <i class="fas fa-power-off"></i>
        </a>
      </li>
      
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=$site_url?>" class="brand-link">
      <img src="<?=$portal_detail->LOGO?>" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8;margin-left: 3.8rem;float: none;">
      <!-- <span class="brand-text font-weight-light">AdminLTE 3</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          
          <img id="header_profile_image" src="<?=$manager_data->profile?>" class="img-circle elevation-2" alt="<?=$manager_data->fname.' '.$manager_data->lname?>">
        </div>
        <div class="info">
          <a href="<?=$site_url?>profile.php" class="d-block" id="manager_name"><?=$manager_data->fname.' '.$manager_data->lname?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          
          <li class="nav-item">
            <a href="<?=$site_url?>dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
              Dashboard
              </p>
            </a>
          </li>
          <?php
          if($manager_type==1){
          ?>
          <li class="nav-item">
            <a href="all_distributors.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              
              <p>
              Distributors Management
              </p>
            </a>
          </li>
          <?php
          }else{
            ?>
            
          <li class="nav-item">
            <a href="all_retailers.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              
              <p>
              Retailers Management
              </p>
            </a>
          </li>
            <?php
          }
          ?>
          
          <li class="nav-item">
            <a href="wallet.php" class="nav-link">
              <i class="nav-icon fas fa-wallet"></i>
              
              <p>
              Wallet Management
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="commission_transaction_history.php" class="nav-link">
              <i class="nav-icon fas fa-exchange-alt"></i>
              
              <p>
              Commission History
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=$site_url?>logout.php" class="nav-link">
              <i class="nav-icon fas fa-power-off"></i>
              
              <p>
              Logout
              </p>
            </a>
          </li>

          
           
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>