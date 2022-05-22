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
				$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.'</div>';
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
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.'</div>';
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
				'page' => $_POST['page']
		  );
			$method='POST';
			$response=$commonFunction->curl_call($url,$data,$method);
      $result = json_decode($response);
			if($result->status != 0){
				
				$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.', Please enter OTP and verify your number.</div>';
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
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.'</div>';
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
			 if($result->page != 'foget'){

					$_SESSION['is_manager_logged_in'] = true;
					$_SESSION['manager_id'] =$manager_id= $result->user_id;
					$_SESSION['manager_type'] = $result->user_type;
					$_SESSION['manager_email'] = $result->user_email;
					$_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.'</div>';
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

			 }
		}else{
				//error message
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.'</div>';
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

			    $_SESSION['message'] ='<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> '.$result->message.'</div>';
					
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
		    $output['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> '.$result->message.'</div>';
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
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'get_distric')
{ 
   //method check statement
	 if ($_SERVER["REQUEST_METHOD"] == "POST"){
			$url=SSOAPI.'get_distric_list_by_state';
			$data=array(
					'api_key' => API_KEY,
					'state_id' => $_POST['state_id'],
					
			);
			$method='POST';
			$response=$commonFunction->curl_call($url,$data,$method);
			$result = json_decode($response);

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

/*forgetPassword action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'forgetPassword')
{   
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$tableName = '"store"';
		//username and password check statement
		if (filter_var($conn->real_escape_string($_POST['username']), FILTER_VALIDATE_EMAIL)) {
			
			$conditions = "email='".$conn->real_escape_string($_POST['username'])."'";
		}else{
			$conditions = "username='".$conn->real_escape_string($_POST['username'])."'";
			
		}
		//fetch record statement with Procedures
		$conditions = '"'.$conditions.'"';
		$run = $conn->query("call fetchRecord($tableName,$conditions,'')");
		$conn->next_result();
		if($run->num_rows > 0)
		{
			$row = $run->fetch_assoc();
			$password=$commonFunction->encrypt_decrypt($row['password'],'decrypt');
			$store_id=$row['store_id'];
			
			//send mail
			$subject = "Password Notification !!";
			$html = '<p style="margin:0;font-size:20px;padding-bottom:5px;color:#2875d7">Welcome to '.PROJECT.'!</p>';
			$html .= '<p style="margin:0;padding:20px 0px">Hi, '.$row['name'].' !</p>';
			$html .= '<p style="margin:0;padding:20px 0px">We have received your password recover request.</p>';
			$html .= '<p style="margin:0;padding:20px 0px">This is your password :<strong>' .$password .'</strong></p>';
			$commonFunction->send_mail($row['email'],$subject,$html);
			//insert history record statement with Procedures
			$conn->query("CALL insertHistory($store_id,'Password recover','This store recovered password !!')");
			//success message
			$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your password has been successfully recovered. Please check your password in register email !!</div>';
			$response['status']=1;
			
		}
		else
		{
			//error message
			$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Username or Email not exists !!</div>';
			$response['status']=0;
			
		}

	}else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
	 echo json_encode($response);
}
/*forgetPassword action end*/
/*update store action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'updateStore')
{
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$name=$_POST['store_name'];
		$phone=$_POST['phone'];
		$store_id=$_SESSION['store_id'];
		$tableName = '"store"';
		//update record statement with Procedures
		$contents_update= "name = '".$name."',phone = '".$phone."'";
		$contents_update='"'.$contents_update.'"';
		$conditions_update = "store_id='".$store_id."'";
		$conditions_update='"'.$conditions_update.'"';
		$update=$conn->query("CALL updateRecord($tableName,$contents_update,$conditions_update)");
		$response['name']=$name;
		if($update){
		//insert history record statement with Procedures
		$conn->query("CALL insertHistory($store_id,'Update Profile','This store update detail !!')");
		//success message
		$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Profile Update successfully !!</div>';
		$response['status']=1;
		}else{
		//error message
		$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
		$response['status']=0;
		}

	}else{
        //error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
	
	echo json_encode($response);

}
/*update store action end*/
/*update password action start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'changePassword')
{
	
	//method check statement
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$cpassword=$_POST['cpassword'];
		$npassword=$_POST['npassword'];
		$ccpassword=$_POST['ccpassword'];
		$store_id=$_SESSION['store_id'];
		$tableName = '"store"';
		//check new or confirm password
		if($npassword==$ccpassword){
			
			$conditions = "store_id='".$store_id."'";
			$conditions = '"'.$conditions.'"';
		    $run = $conn->query("call fetchRecord($tableName,$conditions,'')");
			$conn->next_result();
			$row = $run->fetch_assoc();
			$password=$commonFunction->encrypt_decrypt($row['password'],'decrypt');
			if($password==$cpassword){
				
				$newpassword=$commonFunction->encrypt_decrypt($npassword,'encrypt');
				//update record statement with Procedures
				$contents_update= "password = '".$newpassword."'";
				$contents_update='"'.$contents_update.'"';
				$conditions_update = "store_id='".$store_id."'";
				$conditions_update='"'.$conditions_update.'"';
				$update=$conn->query("CALL updateRecord($tableName,$contents_update,$conditions_update)");
				if($update){
			    //insert history record statement with Procedures		
				$conn->query("CALL insertHistory($store_id,'Change Password','This store change password !!')");
				//success message
				$response['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong>Your Password Changed successfully !!</div>';
				$response['status']=1;
				}else{
				//error message	
				$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went to wrong !!</div>';
				$response['status']=0;
				}
			}else{
				//error message
				$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Current password is not matched !!</div>';
				$response['status']=0;
			}

		}else{
		//error message
		$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> The Confirm Password does not match the New Password !!</div>';
		$response['status']=0;
		}

	}else{
		//error message
		$response['message'] ='<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something Went Wrong !!</div>';
		$response['status']=0;
	}
	
    
	
	echo json_encode($response);

}
/*update password action end*/
?>