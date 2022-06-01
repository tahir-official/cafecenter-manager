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
                  <!-- <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> -->
                  
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

                  <!-- <div class="tab-pane" id="activity">
                    
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user1-128x128.jpg" alt="user image">
                        <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Shared publicly - 7:30 PM today</span>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    

                    
                    <div class="post clearfix">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user7-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Sent you a message - 3 days ago</span>
                      </div>
                      
                      <p>
                        Lorem ipsum represents a long-held tradition for designers,
                        typographers and the like. Some people hate it and argue for
                        its demise, but others ignore the hate as they create awesome
                        tools to help create filler text for everyone from bacon lovers
                        to Charlie Sheen fans.
                      </p>

                      <form class="form-horizontal">
                        <div class="input-group input-group-sm mb-0">
                          <input class="form-control form-control-sm" placeholder="Response">
                          <div class="input-group-append">
                            <button type="submit" class="btn btn-danger">Send</button>
                          </div>
                        </div>
                      </form>
                    </div>
                    
                    <div class="post">
                      <div class="user-block">
                        <img class="img-circle img-bordered-sm" src="dist/img/user6-128x128.jpg" alt="User Image">
                        <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                        <span class="description">Posted 5 photos - 5 days ago</span>
                      </div>
                      
                      <div class="row mb-3">
                        <div class="col-sm-6">
                          <img class="img-fluid" src="dist/img/photo1.png" alt="Photo">
                        </div>
                        
                        <div class="col-sm-6">
                          <div class="row">
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="dist/img/photo2.png" alt="Photo">
                              <img class="img-fluid" src="dist/img/photo3.jpg" alt="Photo">
                            </div>
                            
                            <div class="col-sm-6">
                              <img class="img-fluid mb-3" src="dist/img/photo4.jpg" alt="Photo">
                              <img class="img-fluid" src="dist/img/photo1.png" alt="Photo">
                            </div>
                            
                          </div>
                          
                        </div>
                       
                      </div>
                      

                      <p>
                        <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i> Share</a>
                        <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i> Like</a>
                        <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                      </p>

                      <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                    </div>
                    
                  </div> -->
                  
                  <!-- <div class="tab-pane" id="timeline">
                    
                    <div class="timeline timeline-inverse">
                     
                      <div class="time-label">
                        <span class="bg-danger">
                          10 Feb. 2014
                        </span>
                      </div>
                      
                      <div>
                        <i class="fas fa-envelope bg-primary"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 12:05</span>

                          <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                          <div class="timeline-body">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                            quora plaxo ideeli hulu weebly balihoo...
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-primary btn-sm">Read more</a>
                            <a href="#" class="btn btn-danger btn-sm">Delete</a>
                          </div>
                        </div>
                      </div>
                      
                      <div>
                        <i class="fas fa-user bg-info"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 5 mins ago</span>

                          <h3 class="timeline-header border-0"><a href="#">Sarah Young</a> accepted your friend request
                          </h3>
                        </div>
                      </div>
                      
                      <div>
                        <i class="fas fa-comments bg-warning"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 27 mins ago</span>

                          <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                          <div class="timeline-body">
                            Take me to your leader!
                            Switzerland is small and neutral!
                            We are more like Germany, ambitious and misunderstood!
                          </div>
                          <div class="timeline-footer">
                            <a href="#" class="btn btn-warning btn-flat btn-sm">View comment</a>
                          </div>
                        </div>
                      </div>
                      
                      <div class="time-label">
                        <span class="bg-success">
                          3 Jan. 2014
                        </span>
                      </div>
                      
                      <div>
                        <i class="fas fa-camera bg-purple"></i>

                        <div class="timeline-item">
                          <span class="time"><i class="far fa-clock"></i> 2 days ago</span>

                          <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                          <div class="timeline-body">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                            <img src="https://placehold.it/150x100" alt="...">
                          </div>
                        </div>
                      </div>
                      
                      <div>
                        <i class="far fa-clock bg-gray"></i>
                      </div>
                    </div>
                  </div> -->
                  

                  
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