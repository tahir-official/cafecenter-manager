<?php
include_once('../include/functions.php');
$commonFunction= new functions();
/*login action start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login'){  
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		//username and password check statement
		if($_POST['username'] == NULL && $_POST['password'] == NULL) {
		
			$output['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Enter Username or Password !!</div>';
			$output['status'] = 0;
		} else{

			$username=$_POST['username'];
			$password=$_POST['password'];
      $url=SSOAPI.'user_login';
      $data=array(
          'api_key' => API_KEY,
          'portal' => 'manager',
          'username' => $username,
          'password' => $password
      );
      $method='POST';
      $response=$commonFunction->curl_call($url,$data,$method);
      $result = json_decode($response);
			
      if($result->status != 0){
				$_SESSION['is_manager_logged_in'] = true;
				$_SESSION['manager_id'] =$manager_id= $result->user_id;
				$_SESSION['manager_type'] = $result->user_type;
				$_SESSION['manager_email'] = $result->user_email;
				$_SESSION['contact_number'] = $result->user_contact_number;
				$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
		    $output['status']=1;
				$manager_portal_detail=$commonFunction->get_manager_portal_detail();
				$portal_detail=$manager_portal_detail->data;
				if(ENV=='prod'){
					$site_url=$portal_detail->MANAGER_PORTAL_URL;
			  }else{
					$site_url='https://localhost/cafecenter-manager/';
			  }
				$output['url']=$site_url.'dashboard.php';
				
				if(!empty($_POST["remember"])) {
					setcookie ("loginId", $username, time()+ (10 * 365 * 24 * 60 * 60));  
					setcookie ("loginPass",	$password,	time()+ (10 * 365 * 24 * 60 * 60));
				} else {
					setcookie ("loginId",""); 
					setcookie ("loginPass","");
				}
				
				
			}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
		    $output['status']=0;
			}

    }

	}else{
		//error message
		$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$output['status']=0;
	}
echo json_encode($output);
}
/*login action end*/
/*signup action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add_user')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		if($_FILES["document"]["error"] == 0) {
			$image_status=1;
			$document = new CurlFile($_FILES['document']['tmp_name'], $_FILES['document']['type'], $_FILES['document']['name']);
			} else {
			$image_status=0;
			$document = '';
			}

			if($_POST['page']=='signup'){
				$added_by='self';
				$added_id=1;
				$otp=rand(100000,999999);
			}

			$url=SSOAPI.'add_user';
			
			$data=array(
				'user_type' => $_POST['user_type'],
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'email' => $_POST['email'],
				'password' => $_POST['password'],
				'contact_number' => $_POST['contact_number'],
				'address' => $_POST['address'],
				'state' => $_POST['state'],
				'district' => $_POST['district'],
				'city' => $_POST['city'],
				'zipcode' => $_POST['zipcode'],
				'gender' => $_POST['gender'],
				'dob' => $_POST['dob'],
				'image_status'=> $image_status,
				'document'=> $document,
				'added_by' => $added_by,
				'added_id' => $added_id,
				'email_verification' => '1',
				'phone_verification' => '0',
				'status' => '1',
				'cdate' => date('Y-m-d H:i:s'),
				'api_key' => API_KEY,
				'otp' => $otp
		  );
			$method='POST';
			$response=$commonFunction->curl_call($url,$data,$method);
      $result = json_decode($response);
			if($result->status != 0){
				
				$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.', Please enter OTP and verify your number !!</div>';
				$manager_portal_detail=$commonFunction->get_manager_portal_detail();
				$portal_detail=$manager_portal_detail->data;
				if(ENV=='prod'){
					$site_url=$portal_detail->MANAGER_PORTAL_URL;
			  }else{
					$site_url='https://localhost/cafecenter-manager/';
			  }
				$output['url']=$site_url.'otpverification.php?number='.$_POST['contact_number'].'&page='.$_POST['page'];
				$output['status']=1;
			}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
		    $output['status']=0;
			}

	}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
			$output['status']=0;
			
	}
	echo json_encode($output);	
}
/*signup action end*/

/*otpverify action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'otp_verify')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$url=SSOAPI.'otp_verify';
		$data=array(
			
			'page' => $_POST['page'],
			'number' => $_POST['number'],
			'otp' => $_POST['otp'],
			'api_key' => API_KEY
			
		);
		$method='POST';
		$response=$commonFunction->curl_call($url,$data,$method);
		$result = json_decode($response);
		if($result->status != 0){
			 if($result->page != 'forget'){

					$_SESSION['is_manager_logged_in'] = true;
					$_SESSION['manager_id'] =$manager_id= $result->user_id;
					$_SESSION['manager_type'] = $result->user_type;
					$_SESSION['manager_email'] = $result->user_email;
					$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
					$output['status']=1;
					$manager_portal_detail=$commonFunction->get_manager_portal_detail();
					$portal_detail=$manager_portal_detail->data;
					if(ENV=='prod'){
						$site_url=$portal_detail->MANAGER_PORTAL_URL;
					}else{
						$site_url='https://localhost/cafecenter-manager/';
					}
					$output['url']=$site_url.'dashboard.php';

			 }else{
					$output['status']=1;
					$manager_portal_detail=$commonFunction->get_manager_portal_detail();
					$portal_detail=$manager_portal_detail->data;
					if(ENV=='prod'){
						$site_url=$portal_detail->MANAGER_PORTAL_URL;
					}else{
						$site_url='https://localhost/cafecenter-manager/';
					}
					$output['url']=$site_url.'reset.php?token='.$result->token;
			 }
		}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
		    $output['status']=0;
		}

	}else{
		//error message
		$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$output['status']=0;
		
}
  echo json_encode($output);
}
/*otpverify action end*/

/*send otp action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'send_otp')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$url=SSOAPI.'send_otp';
		$data=array(
			
			'page' => $_POST['page'],
			'number' => $_POST['cnumber'],
			'api_key' => API_KEY
			
		);
		$method='POST';
		$response=$commonFunction->curl_call($url,$data,$method);
		$result = json_decode($response);
		if($result->status != 0){

			    $_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
					
					$manager_portal_detail=$commonFunction->get_manager_portal_detail();
					$portal_detail=$manager_portal_detail->data;
					if(ENV=='prod'){
						$site_url=$portal_detail->MANAGER_PORTAL_URL;
					}else{
						$site_url='https://localhost/cafecenter-manager/';
					}
					$output['url']=$site_url.'otpverification.php?number='.$_POST['cnumber'].'&page='.$_POST['page'];
				  $output['status']=1;
		}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
		    $output['status']=0;
		}
	}
  else{
		//error message
		$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$output['status']=0;
		
  }
  echo json_encode($output);
}
/*send otp action end*/
/*reset password action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'reset_password')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$url=SSOAPI.'reset_password';
		$data=array(
			
			'token' => $_POST['token'],
			'password' => $_POST['password'],
			'api_key' => API_KEY
			
		);
		$method='POST';
		$response=$commonFunction->curl_call($url,$data,$method);
		$result = json_decode($response);
		if($result->status != 0){
			$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
			$output['status']=1;
			$manager_portal_detail=$commonFunction->get_manager_portal_detail();
			$portal_detail=$manager_portal_detail->data;
			if(ENV=='prod'){
				$site_url=$portal_detail->MANAGER_PORTAL_URL;
			}else{
				$site_url='https://localhost/cafecenter-manager/';
			}
			$output['url']=$site_url.'index.php';

		}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
			$output['status']=0;
	  }
	}
	else{
		//error message
		$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$output['status']=0;
		
	}
  echo json_encode($output);
} 
/*reset password action end*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_distric')
{ 
   //method check statement
	 if ($_SERVER["REQUEST_METHOD"] == "POST"){
			$result=$commonFunction->distric_list($_POST['state_id']);
			if($result->status != 0){
			 $district_data=$result->data;
       $distric_html='<option value="">Select District</option>';
			 foreach($district_data as $district){
				$distric_html .='<option value="'.$district->districtid.'">'.$district->district_title.'</option>';
			 }

			  $output['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
			  $output['status']=1;
			  $output['html']=$distric_html;

			}else{
				$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
			  $output['status']=0;
			  $output['html']='<option value="">Select District</option>';
			}

	 }
	 else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
			$output['status']=0;
			$output['html']='<option value="">Select District</option>';
	}
	echo json_encode($output);
}
/*get distric action end*/
/*edit manager action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_users')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		  $image_status='0';
      $document = '';

			$url=SSOAPI.'edit_user';
			$data=array(
				'row_id' => $_SESSION['manager_id'],
				'user_type' => $_SESSION['manager_type'],
				'fname' => $_POST['fname'],
				'lname' => $_POST['lname'],
				'email' => $_SESSION['manager_email'],
				'contact_number' => $_SESSION['contact_number'],
				'address' => $_POST['address'],
				'state' => $_POST['state'],
				'district' => $_POST['district'],
				'city' => $_POST['city'],
				'zipcode' => $_POST['zipcode'],
				'gender' => $_POST['gender'],
				'dob' => $_POST['dob'],
				'image_status'=> $image_status,
				'document'=> $document,
				'api_key' => API_KEY
			);
			$method='POST';
			$response=$commonFunction->curl_call($url,$data,$method);
      $result = json_decode($response);
			if($result->status != 0){
				if($_POST['page']=='edit_manager'){
					$alert_msg='Your profile updated Successfully';
				}else{
					$alert_msg=$result->message;
				}
				$output['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$alert_msg.' !!</div>';
				$output['status']=1;
				$output['manager_name']=$_POST['fname'].' '.$_POST['lname'];

			}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
		    $output['status']=0;
			}

	}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
			$output['status']=0;
			
	}
	echo json_encode($output);	
}
/*edit manager action end*/

/*update password action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changePassword')
{ 
	 //method check statement
	 if($_SERVER["REQUEST_METHOD"] == "POST"){
		$url=SSOAPI.'change_password';
		$data=array(
			'api_key' => API_KEY,
			'current_password' => $_POST['current_password'],
			'new_password' => $_POST['new_password'],
			'row_id' => $_SESSION['manager_id'],
			'user_type' => $_SESSION['manager_type'],
			
		);
		$method='POST';
		$response=$commonFunction->curl_call($url,$data,$method);
		$result = json_decode($response);
		if($result->status != 0){
    	$output['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
			$output['status']=1;
		}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
			$output['status']=0;
	  }

	}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
			$output['status']=0;
			
	}
	echo json_encode($output);
}
/*update password action end*/

/*edit profile action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit_profile_image')
{ 
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST"){

	  	if($_FILES["profile_image"]["error"] == 0) {
			
			    $profile = new CurlFile($_FILES['profile_image']['tmp_name'], $_FILES['profile_image']['type'], $_FILES['profile_image']['name']);
				  $url=SSOAPI.'edit_profile_image';
					$data=array(
						'row_id' => $_SESSION['manager_id'],
						'user_type' => $_SESSION['manager_type'],
						'profile'=> $profile,
						'api_key' => API_KEY
					);
					$method='POST';
					$response=$commonFunction->curl_call($url,$data,$method);
					$result = json_decode($response);
					if($result->status != 0){
						
						$output['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.' !!</div>';
						$output['status']=1;
						$output['profile_url']=$result->profile_url;

					}else{
						//error message
						$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.' !!</div>';
						$output['status']=0;
					}
			} else {
				$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
				$output['status']=0;
			}
		  
	}else{
			//error message
			$output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
			$output['status']=0;
			
	}
	echo json_encode($output);	
}
/*edit profile action end*/
?>