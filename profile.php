<?php
   include_once('include/header.php');
  //  if($manager_type!=1){
  //   $commonFunction->redirect('dashboard.php');
  //  }
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
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?=$portal_detail->MANAGER_PORTAL_URL?>">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
              <style>
                  .container {
                    width: 150px;
                    height: 150px;
                    display: block;
                    margin: 0 auto;
                  }

                  .outer {
                    width: 100% !important;
                    height: 100% !important;
                    max-width: 150px !important; /* any size */
                    max-height: 150px !important; /* any size */
                    margin: auto;
                    /* background-color: #6eafd4; */
                    border-radius: 100%;
                    position: relative;
                    /* background-image: url(<?=$manager_data->profile?>); */
                    background-position: center;
                  background-repeat: no-repeat;
                  background-size: cover;
                    }
                    
                  .inner {
                    background-color: #ff1414;
                    width: 50px;
                    height: 50px;
                    border-radius: 100%;
                    position: absolute;
                    bottom: 0;
                    right: 0;
                  }

                  .inner:hover {
                    background-color: #5555ff;
                  }
                  .inputfile {
                      opacity: 0;
                      overflow: hidden;
                      position: absolute;
                      z-index: 1;
                      width: 50px;
                      height: 50px;
                  }
                  .inputfile + label {
                      font-size: 1.25rem;
                      text-overflow: ellipsis;
                      white-space: nowrap;
                      display: inline-block;
                      overflow: hidden;
                      width: 50px;
                      height: 50px;
                      pointer-events: none;
                      cursor: pointer;
                      line-height: 50px;
                      text-align: center;
                  }
                  .inputfile + label svg {
                      fill: #fff;
                  }

                  /*css for subcraption*/
                                  
                .panel
                {
                    text-align: center;
                }
                .panel:hover { box-shadow: 0 1px 5px rgba(0, 0, 0, 0.4), 0 1px 5px rgba(130, 130, 130, 0.35); }
                .panel-body
                {
                    padding: 0px;
                    text-align: center;
                }

                .the-price
                {
                    background-color: rgba(220,220,220,.17);
                    box-shadow: 0 1px 0 #dcdcdc, inset 0 1px 0 #fff;
                    padding: 20px;
                    margin: 0;
                }

                .the-price h1
                {
                    line-height: 1em;
                    padding: 0;
                    margin: 0;
                }

                .subscript
                {
                    font-size: 25px;
                }

                /* CSS-only ribbon styles    */
                .cnrflash
                {
                    /*Position correctly within container*/
                    position: absolute;
                    top: -9px;
                    right: 4px;
                    z-index: 1; /*Set overflow to hidden, to mask inner square*/
                    overflow: hidden; /*Set size and add subtle rounding  		to soften edges*/
                    width: 100px;
                    height: 100px;
                    border-radius: 3px 5px 3px 0;
                }
                .cnrflash-inner
                {
                    /*Set position, make larger then 			container and rotate 45 degrees*/
                    position: absolute;
                    bottom: 0;
                    right: 0;
                    width: 145px;
                    height: 145px;
                    -ms-transform: rotate(45deg); /* IE 9 */
                    -o-transform: rotate(45deg); /* Opera */
                    -moz-transform: rotate(45deg); /* Firefox */
                    -webkit-transform: rotate(45deg); /* Safari and Chrome */
                    -webkit-transform-origin: 100% 100%; /*Purely decorative effects to add texture and stuff*/ /* Safari and Chrome */
                    -ms-transform-origin: 100% 100%;  /* IE 9 */
                    -o-transform-origin: 100% 100%; /* Opera */
                    -moz-transform-origin: 100% 100%; /* Firefox */
                    background-image: linear-gradient(90deg, transparent 50%, rgba(255,255,255,.1) 50%), linear-gradient(0deg, transparent 0%, rgba(1,1,1,.2) 50%);
                    background-size: 4px,auto, auto,auto;
                    background-color: #aa0101;
                    box-shadow: 0 3px 3px 0 rgba(1,1,1,.5), 0 1px 0 0 rgba(1,1,1,.5), inset 0 -1px 8px 0 rgba(255,255,255,.3), inset 0 -1px 0 0 rgba(255,255,255,.2);
                }
                .cnrflash-inner:before, .cnrflash-inner:after
                {
                    /*Use the border triangle trick to make  				it look like the ribbon wraps round it's 				container*/
                    content: " ";
                    display: block;
                    position: absolute;
                    bottom: -16px;
                    width: 0;
                    height: 0;
                    border: 8px solid #800000;
                }
                .cnrflash-inner:before
                {
                    left: 1px;
                    border-bottom-color: transparent;
                    border-right-color: transparent;
                }
                .cnrflash-inner:after
                {
                    right: 0;
                    border-bottom-color: transparent;
                    border-left-color: transparent;
                }
                .cnrflash-label
                {
                    /*Make the label look nice*/
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    display: block;
                    width: 100%;
                    padding-bottom: 5px;
                    color: #fff;
                    text-shadow: 0 1px 1px rgba(1,1,1,.8);
                    font-size: 0.95em;
                    font-weight: bold;
                    text-align: center;
                }

              </style>
                <div class="text-center">
                  <!-- <img class="profile-user-img img-fluid img-circle"
                       src="<?=$manager_data->profile?>"
                       alt="<?=$manager_data->fname.' '.$manager_data->lname?>"> -->
                       <form  name="profile_form" id="profile_form" method="post" enctype="multipart/form-data">
                       <div class="container">
                        <div class="outer" style="background-image: url(<?=$manager_data->profile?>);">
                          <div class="inner">
                          
                          <input class="inputfile" type="file" name="profile_image" id="profile_image" accept="image/*">
                          
                          <label><svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17"><path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path></svg></label>
                          </div>
                        </div>
                      </div>
                      </form>
                      <div class="loader loader--style1" title="0" style="display: none;">
                          <svg version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                          width="40px" height="40px" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
                          <path opacity="0.2" fill="blue" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                            s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                            c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
                          <path fill="red" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                            C22.32,8.481,24.301,9.057,26.013,10.047z">
                            <animateTransform attributeType="xml"
                              attributeName="transform"
                              type="rotate"
                              from="0 20 20"
                              to="360 20 20"
                              dur="0.5s"
                              repeatCount="indefinite"/>
                            </path>
                          </svg>
                      </div>
                </div>
                
                <h3 class="profile-username text-center" id="profile_name"><?=$manager_data->fname.' '.$manager_data->lname?></h3>

                <p class="text-muted text-center"><?=$manager_data->email?></p>
                <?php
                if($manager_data->status==1){
                  echo '<p class="text-center"><button class="btn btn-success" disabled>Active</button></p>';
                }else{
                  echo '<p class="text-center"><button class="btn btn-danger" disabled>Deactive</button></p>';
                }
                if($manager_data->email_verification==1){
                    $email_verification='<label style="color: white;cursor: pointer;" class="badge badge-success">Completed</label>';
                }else{
                    $email_verification='<label style="color: white;cursor: pointer;" class="badge badge-warning">Pending</label>';
                }
                if($manager_data->phone_verification==1){
                    $phone_verification='<label style="color: white;cursor: pointer;" class="badge badge-success">Completed</label>';
                }else{
                    $phone_verification='<label style="color: white;cursor: pointer;" class="badge badge-warning">Pending</label>';
                }
            
                if($manager_data->subscription_status==1){
                    $subscription_status='<label style="color: white;cursor: pointer;" class="badge badge-success">Completed</label>';
                }else{
                    $subscription_status='<label style="color: white;cursor: pointer;" class="badge badge-warning">Pending</label>';
                }
                ?>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Email Verification</b> <a class="float-right"><?=$email_verification;?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Phone verification</b> <a class="float-right"><?=$phone_verification;?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Subscription Status</b> <a class="float-right"><?=$subscription_status;?></a>
                  </li>
                </ul>

                <a href="<?=$manager_data->document?>" class="btn btn-primary btn-block" download target="_blank"><b>ID Proof</b></a>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">About Me</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-wallet mr-1"></i> Wallet</strong>

                <p class="text-muted"><?=$portal_detail->CURRENCY.' '.$manager_data->wallet?></p>

                <hr>

                <strong><i class="fas fa-user mr-1"></i> Added By</strong>

                <p class="text-muted"><?=$manager_data->added_name?></p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Created Date</strong>

                <p class="text-muted"><?=$manager_data->cdate?> </p>

                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profile Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#password_setting" data-toggle="tab">Password Setting</a></li>
                  <li class="nav-item"><a class="nav-link" href="#subscription_plan" data-toggle="tab">Subscription Plan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#bank_detail" data-toggle="tab">Bank Details</a></li>
                  <li class="nav-item"><a class="nav-link" href="#upi_detail" data-toggle="tab">UPI Detail</a></li>
                  
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal" name="edit_form" id="edit_form" method="post" >

                    <div id="alert_edit_user"></div>
                    <input type="hidden" name="page" value="edit_manager">
                      <div class="form-group row">
                        <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name" value="<?=$manager_data->fname?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name" value="<?=$manager_data->lname?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input readonly type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?=$manager_data->email?>">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="contact_number" class="col-sm-2 col-form-label">Mobile No.</label>
                        <div class="col-sm-10">
                          <input readonly type="text" class="form-control" id="contact_number" name="contact_number" placeholder="Mobile No." value="<?=$manager_data->contact_number?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="address" class="col-sm-2 col-form-label">Address</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?=$manager_data->address?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="state" class="col-sm-2 col-form-label">State</label>
                        <div class="col-sm-10">
                        <?php
                        $state_list=$commonFunction->state_list();
                        $state_status=$state_list->status;
                        $state_message=$state_list->message;
                        $state_data=$state_list->data;
                        ?>
                        <select class="form-control" name="state" id="state" <?php if($state_status == 0){ echo 'disabled'; }?> onchange="return loadDistric(this.value)">
                          <?php 
                          if($state_status == 0){
                            echo '<option value="">'.$state_message.'</option>';
                          }else{
                            echo '<option value="">Select State</option>';
                            foreach($state_data as $state){
                              $state_selected='';
                              if($manager_data->state==$state->state_id){
                              $state_selected='selected';    
                              }
                            echo '<option '.$state_selected.' value="'.$state->state_id.'">'.$state->state_title.'</option>';
                            }
                          }
                          ?>
                          
                        </select>
                        </div>
                      </div>
                      

                      <div class="form-group row">
                        <label for="district" class="col-sm-2 col-form-label">District</label>
                        <div class="col-sm-10">
                        
                        
                        <?php
                        $distric_list=$commonFunction->distric_list($manager_data->state);
                        $distric_status=$distric_list->status;
                        $distric_message=$distric_list->message;
                        $distric_data=$distric_list->data;
                        ?>
                        <select class="form-control" name="district" id="district" <?php if($distric_status == 0){ echo 'disabled'; }?>>
                          <?php 
                          if($distric_status == 0){
                            echo '<option value="">'.$distric_message.'</option>';
                          }else{
                            echo '<option value="">Select District</option>';
                            foreach($distric_data as $distric){
                              $district_selected='';
                              if($manager_data->district==$distric->districtid){
                              $district_selected='selected';    
                              }
                            echo '<option '.$district_selected.' value="'.$distric->districtid.'">'.$distric->district_title.'</option>';
                            }
                          }
                          ?>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="city" class="col-sm-2 col-form-label">City</label>
                        <div class="col-sm-10">
                          <input  type="text" class="form-control" id="city" name="city" placeholder="City" value="<?=$manager_data->city?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="zipcode" class="col-sm-2 col-form-label">Zipcode</label>
                        <div class="col-sm-10">
                          <input  type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zipcode" value="<?=$manager_data->zipcode?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <div class="col-sm-10">
                        <select id="gender" name="gender" class="form-control" >
                          <option value="">Select Gender</option>
                          <?php
                          $gender=$manager_data->gender;
                          $male_selected='';
                          $female_selected='';
                          $other_selected='';
                          if($gender=='male'){
                              $male_selected='selected';
                          }
                          if($gender=='female'){
                              $female_selected='selected';
                          }
                          if($gender=='other'){
                              $other_selected='selected';
                          }
                          echo '<option value="male" '.$male_selected.'>Male</option>
                                          <option value="female" '.$female_selected.'>Female</option>
                                          <option value="other" '.$other_selected.'>Other</option>';
                          
                          ?>
                               
                        </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="dob" class="col-sm-2 col-form-label">Dob</label>
                        <div class="col-sm-10">
                          <input  type="date" class="form-control" id="dob" name="dob" placeholder="DOB" max="<?php echo date('Y-m-d');?>" value="<?=$manager_data->dob?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="document" class="col-sm-2 col-form-label">ID Proof</label>
                        <div class="col-sm-10">
                        <input type="file" class="form-control" id="document" name="document" accept=".jpg, .jpeg, .pdf">
                        </div>
                      </div>
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger btnsbt">Submit</button>
                        </div>
                      </div>
                    </form>
                   </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="password_setting">
                   
                    <form class="form-horizontal" name="updatePassword" id="updatePassword" method="post" >
                    <div id="alert_change_pass"></div>
                      <div class="form-group row">
                        <label for="current_password" class="col-sm-2 col-form-label">Current Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Current Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="new_password" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirm_password" class="col-sm-2 col-form-label">Confirm Password</label>
                        <div class="col-sm-10">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" id="updatePassBtn">Change</button>
                          <button class="btn btn-warning" id="cancelPassBtn" onclick="return resetPasswordFrom();">Cancel</button>
                        </div>
                      </div>
                    </form>
                   </div>
                  <!-- /.tab-pane -->

                  <div class="tab-pane" id="subscription_plan">
                    <div class="row">
                          <div class="col-xs-12 col-md-12">
                              <div class="panel panel-success">
                                  <div class="cnrflash">
                                      <div class="cnrflash-inner">
                                          <span class="cnrflash-label">CURRENT
                                              <br>
                                              PLAN</span>
                                      </div>
                                  </div>
                                  
                                  <div class="panel-heading">
                                      <h3 class="panel-title">
                                          <?=$plan_data->plan_title?></h3>
                                  </div>
                                  <div class="panel-body">
                                      <div class="the-price">
                                          <h1><?php echo $portal_detail->CURRENCY.' '.$plan_data->plan_amount?></h1>
                                          <small>For lifetime</small>
                                      </div>
                                      <table class="table">
                                          <tr>
                                              <td>
                                              <?=$plan_data->plan_heading?>
                                              </td>
                                          </tr>
                                          <tr class="active">
                                              <td>
                                              <?=$plan_data->plan_description?>
                                              </td>
                                          </tr>
                                          
                                      </table>
                                  </div>
                                  
                              </div>
                          </div>
                    </div>
                  </div> 

                  
                  <div class="tab-pane" id="bank_detail">
                    <?php
                    if($manager_data->bank_status==0){
                      $bank_detail_form_title='Add';
                      $action_type='add';
                      
                    }else{
                      $bank_detail_form_title='Update';
                      $action_type='update';
                    }
                    ?>
                    <h4 id="bank_detail_form_h4"><?=$bank_detail_form_title?> Bank Details</h4>
                    <form class="form-horizontal" name="bank_detail_form" id="bank_detail_form" method="post" >
                    <input type="hidden" name="action" value="bank_detail_proccess" >
                    <input type="hidden" id="action_type" name="action_type" value="<?=$action_type?>" >
                    <div id="alert_bank_detail"></div>
                      <div class="form-group row">
                        <label for="holder_name" class="col-sm-2 col-form-label">Holder Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="holder_name" name="holder_name" placeholder="Holder Name" value="<?=$manager_data->holder_name?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="ifsc_code" class="col-sm-2 col-form-label">IFSC Code</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="<?=$manager_data->ifsc_code?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="account_number" class="col-sm-2 col-form-label">Account Number</label>
                        <div class="col-sm-10">
                        <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" value="<?=$manager_data->account_number?>">
                        </div>
                      </div>
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" id="addUpdateBankBtn">Submit</button>
                          
                        </div>
                      </div>
                    </form>
                   </div>
                  <!-- /.tab-pane -->

                  
                  <div class="tab-pane" id="upi_detail">
                   
                  <?php
                    if($manager_data->upi_status==0){
                      $upi_detail_form_title='Add';
                      $upi_action_type='add';
                      
                    }else{
                      $upi_detail_form_title='Update';
                      $upi_action_type='update';
                    }
                    ?>
                    <h4 id="upi_detail_form_h4"><?=$upi_detail_form_title?> UPI Details</h4>
                    <form class="form-horizontal" name="upi_detail_form" id="upi_detail_form" method="post" >
                    <input type="hidden" name="action" value="upi_detail_proccess" >
                    <input type="hidden" id="upi_action_type" name="upi_action_type" value="<?=$upi_action_type?>" >
                    <div id="alert_upi_detail"></div>
                      <div class="form-group row">
                        <label for="upi_id" class="col-sm-2 col-form-label">UPI ID</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="upi_id" name="upi_id" placeholder="UPI ID" value="<?=$manager_data->upi_id?>">
                        </div>
                      </div>
                      
                      
                     
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" id="addUpdateUpiBtn">Submit</button>
                          
                        </div>
                      </div>
                    </form>
                   </div>
                  <!-- /.tab-pane -->
                  
                  
                  

                  
                </div>
                
              </div>
            </div>
            
          </div>
          
        </div>
        
      </div>
    </section>
    <!-- /.content -->
  </div>
<?php
   include_once('include/footer.php');
?>