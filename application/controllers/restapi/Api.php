<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Api extends REST_Controller
{
	public function __construct() 
	{ 
		parent::__construct();
		$this->load->model('Apimodel');
		$this->load->helper('url'); 
		$this->load->library('email');
		$this->load->library('form_validation');
		require 'vendor/autoload.php'; 
		error_reporting(0);
	}

	public function send_mail($email,$subject,$message){
		//Sent Email to user for otp verification
        /*$subject = 'New One Time Password From E-Learning';
        $loginPath = base_url();
        $imagePath = base_url() . 'images/app_logo_small.png';
        $imagebackPath = base_url() . 'images/texture-bg.jpg';
        $message = "<!Doctype html>
            <html>
            <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1'>
            <title>Sign UP</title>
            <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap' rel='stylesheet'>
            <body>
                <div style='max-width:600px;
                    margin:auto;
                    border:1px solid #eee;
                    box-shadow:0 0 10px rgba(0, 0, 0, .15);
                    line-height:17px;
                    font-size:13px;
                    box-sizing:border-box; -webkit-print-color-adjust: exact;font-family: Poppins, sans-serif; background:url(".$imagebackPath.")'>
                    <div style='padding:20px; box-sizing: border-box;text-align: center; background: #fff;'>
                        <a href='#'><img src='".$imagePath."' style='max-width: 100%;width: 100px;'></a>
                    </div>
                    <div style='width: 400px; margin:50px auto;background: #ffffffd1;padding: 50px;text-align: center;'>
                        <h1 style=' font-size: 30px; line-height: 32px; color: #0B0B0B; margin: 30px 0;'>Dear User</h1>
                        <p style='font-size: 15px;color: #262626;line-height: 24px;margin: 20px 0;'>Thank You for Opting in and Welcome to E-Learning!</p>
                        <p>
                            <table>
                                <tbody>
                                    <tr style='line-height: 37px;'>
                                        <td width='120px' style='padding-bottom: 0; text-align:right;'><strong>Email: </strong></td>
                                        <td>&nbsp;</td>
                                        <td style='padding-bottom: 0;text-align: left;'>".$email."</td>
                                    </tr>
                                    <tr style='line-height: 20px;'>
                                        <td width='200px' style='padding-bottom: 0;text-align:right;'><strong>One Time Password:</strong></td>
                                        <td>&nbsp;</td>
                                        <td style='padding-bottom: 0;text-align: left;'>".$random_number." </td>
                                    </tr>
                                </tbody>
                            </table>
                        </p>
                    </div>
                    <div style='background: #000;
                            text-align: left;
                            box-sizing: border-box;
                            width: 100%;
                            padding: 20px 50px;
                            color: #fff;'>
                        <p style='margin: 5px 0;font-size: 12px;'>Sincerely,</p>
                        <p style='margin: 5px 0;font-size: 12px;'>E-Learning</p>
                        <p style='margin: 5px 0;font-size: 12px;'><strong>Email:</strong> <a href='#' style='color: #78DAFF;'>info@elearning.com</a></p>
                        <br/>
                        <p style='margin: 5px 0;font-size: 11px;'>This is an automated response, please do not reply.</p>
                    </div>
                </div>
            </body>
            </html>";*/

            //SENDING TEST EMAIL
		    $this->email->set_newline("\r\n");
		    $this->email->from('support@mentorpark.com','E-Learning');
		    $this->email->to($email);
		    $this->email->subject($subject);
		    $this->email->message($message);
		    $this->email->set_mailtype("html");
		    $this->email->send();
	}

	public function removeNull($array)
	{
		array_walk_recursive($array, function (&$array, $key){
			$array = (null === $array)? '' : $array;
		});
		return $array;
	}

	public function signup_post() 
	{
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);

		if(is_array($obj)) 
		{
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['email'] = $this->post('email');
			$userData['password'] = $this->post('password');
			$userData['term'] = $this->post('term');
		}

		$this->form_validation->set_rules('email', 'email', 'trim|required|is_unique[users.email]');		
		$this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('term','T&C and Privacy Policy','trim|required');
		$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s');
		$this->form_validation->set_message('is_unique', 'The %s is already taken');
		
		if ($this->form_validation->run() === false) 
		{				
			if(form_error('email')) 
			{
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('email'))
				], 400);
			}
			
			if(form_error('password')) 
			{
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('password'))
				], 400);
			}

			if(form_error('term')) 
			{
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('term'))
				], 400);
			}			

		} else {
			
			$mydata=array(
				'email'=>$userData['email'],
				'password'=>$this->enc_password($userData['password']),
				'userType'=>1,
				'created'=>date('Y-m-d H:i:s'),				
				'status'=> 1
			);	

			$result=$this->Apimodel->add_details("users", $mydata);			

			if($result)
			{			

				$fetchdetails=$this->Apimodel->get_cond('users', "userId='$result'");
				
				$array = [
					'status' => "1",
					'message'=>'You have registered successfully!',
					'email' => $userData['email'],
					'userId' => strval($fetchdetails->userId)
				];

				$array = $this->arrcheck($array);

				$this->response($array, 200);
			} else {
				$this->response([
					'status' =>"0",
					'error' => "Some problems occurred, please try again.!"
				], 400);				

			}

		}
	}

	/* 
    * Checking unique mobile no during update info
    */ 

	 public function unique_mobileNo(){
	 	$mobile = $this->input->post('mobile');
	 	$ccCode = $this->input->post('ccCode');
   		$userId = $this->input->post('userId');

   		$mobile_no = $ccCode." ".$mobile;

        $sql_check_mobile = "SELECT CONCAT(COALESCE(ccCode,''), ' ', COALESCE(mobile,'')) AS mobile_no FROM users u WHERE u.userId != '$userId' AND u.userType = '1' HAVING mobile_no = '$mobile_no'";
        //echo $sql_check_mobile;exit;

        $count_user_results = $this->db->query($sql_check_mobile)->num_rows();
        
        if($count_user_results > 0){
        	//$this->form_validation->set_message('is_unique_mobile','This mobile no is taken, Please try another.');
            return false;
        }else{
            return true;
        }
    }

	public function updateProfile_post() 
	{
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) 
		{
			$_POST = (array) $obj;
			$userData = $_POST;
		} else {
			$userData['userId'] = $this->post('userId');
			$userData['firstName'] = $this->post('firstName');
			$userData['lastName'] = $this->post('lastName');
			$userData['dob'] = $this->post('dob');
			$userData['ccName'] = $this->post('ccName');
			$userData['ccCode'] = $this->post('ccCode');
			$userData['mobile'] = $this->post('mobile');
			$userData['address'] = $this->post('address');
			$userData['latitude'] = $this->post('latitude');
			$userData['longitude'] = $this->post('longitude');
			$userData['qualification'] = $this->post('qualification');
			$userData['occupation'] = $this->post('occupation');
			$userData['bio'] = $this->post('bio');
			$userData['profilePic'] = $this->post('profilePic');
		}

		$this->form_validation->set_rules('userId', 'userId', 'trim|required');
		$this->form_validation->set_rules('firstName', 'firstName', 'trim|required');
		$this->form_validation->set_rules('lastName', 'lastName', 'trim|required');
		//$this->form_validation->set_rules('address', 'address', 'trim|required');
		//$this->form_validation->set_rules('latitude', 'latitude', 'trim|required');
		//$this->form_validation->set_rules('longitude', 'longitude', 'trim|required');		
		$this->form_validation->set_rules('mobile', 'mobile', 'trim|required|min_length[10]|callback_unique_mobileNo');
		

		if($this->form_validation->run() === false) 
		{
			if(form_error('userId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userId'))
				], 400);
			}

			if(form_error('firstName')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('firstName'))
				], 400);
			}	
			if(form_error('lastName')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('lastName'))
				], 400);
			}

			if(form_error('mobile')) {
				$this->response([
					'status' => "0",
					'error' => 'This mobile no is taken, Please try another.'
				], 400);
			}			

			/*if(form_error('address')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('address'))
				], 400);
			}
			if(form_error('latitude')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('latitude'))
				], 400);
			}
			if(form_error('longitude')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('longitude'))
				], 400);
			}*/
			

		} else {

			$userId = $userData['userId'];			
			
			$dataraw = $this->Apimodel->get_cond('users', "userId=$userId");

			if(!empty($dataraw))
			{
				$config['upload_path'] = './uploads/users/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = 204800;
				$config['file_name'] = uniqid();
				$this->load->library('upload', $config);

				if(!$this->upload->do_upload('profilePic'))
				{
					$error = array('error' => $this->upload->display_errors());
					@$image = $dataraw->profilePic;

				} else {
					$file_data = $this->upload->data();
					$image = $file_data['file_name'];

				} 

				$mydata = array(
					'firstName' =>$userData['firstName'],
					'lastName' =>$userData['lastName'],
					'address' =>$userData['address'],
					'latitude' =>$userData['latitude'],
					'longitude' =>$userData['longitude'],
					'dob' =>$userData['dob'],
					'ccName' =>$userData['ccName'],
					'ccCode' =>$userData['ccCode'],
					'mobile' =>$userData['mobile'],
					'qualification' =>$userData['qualification'],
					'occupation' =>$userData['occupation'],
					'descriptions' =>$userData['bio'],
					'profilePic'=>$image,
				); 

				$where="userId=$userId";
				$update=$this->Apimodel->update_cond('users', $where, $mydata);

				$user = $this->Apimodel->get_cond('users', "userId=$userId");

				if($user->profilePic!=""){
					$pic = base_url().'uploads/users/'.$user->profilePic;
				}else {
				    $pic = base_url().'uploads/noimg.png';
				}

				$arr= array(
					'userId' => $user->userId,
					'firstName'=>$user->firstName,
					'lastName'=>$user->lastName,
					'userType' =>$user->userType,
					'email'=>$user->email,
					'ccName' => $user->ccName,	
					'ccCode' => $user->ccCode,	
					'mobile'=>$user->mobile,
					'bio' => $user->descriptions,	
					'address' => $user->address,
					'latitude' => $user->latitude,
					'longitude' => $user->longitude,
					'profilePic' => $pic,					

				);
				$arr = $this->arrcheck($arr);

				if($update)
				{
					$this->response([
						'status'=>"1",
						'message' => 'Profile updated successfully.',
						'personalInfo'=>$arr
					], 200);
				} else {
					$this->response([
						'status' => "0",
						'error' => "Some problems occurred, please try again."
					], 400);
				}

			} else {
				$this->response([
					'status' => "0",
					'error' => 'No user found.'
				], 400);

			}

		}
	}	

	public function login_post()
	{
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;
		} else {
			$userData['email'] = $this->post('email');
			$userData['password'] = $this->post('password');
		}
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('email')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('email'))
				], 400);
			}
			if(form_error('password')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('password'))
				], 400);
			}
			
		} else {

			$where = "email = '".$userData['email']."'";
			if ($this->mymodel->count('users', $where) != 1) 
			{				
				$this->response([
					'status' =>"0",
					'error' => "Invalid Email"
				], 400);			
			}else{
				$user = $this->mymodel->get_by('users', true, $where);
				
				if(password_verify($userData['password'], $user->password) == 0) 
				{
					$this->response([
						'status' =>"0",
						'error' => "Password does not matched!"
					], 400);	
				}elseif ($user->status=='0') 
				{
					$this->response([
						'status' =>"0",
						'error' => "Your account has not verified. Please verify."
					], 400);	
								
				}
				else{

					if($user->profilePic!="")
					{
						$pic = base_url().'uploads/users/'.$user->profilePic;
					} else {
						$pic = base_url().'uploads/noimg.png';
					}					

					$array = [
						'status' =>"1",
						'personalInfo' => [
						'userId' => $user->userId,
						'userType' =>$user->userType,
						'firstName' => $user->firstName,
						'lastName' => $user->lastName,
						'email' => $user->email,
						'ccName' => $user->ccName,
						'ccCode' => $user->ccCode,
						'mobile' => $user->mobile,
						'bio' => $user->descriptions,	
						'address' => $user->address,
						'latitude' => $user->latitude,
						'longitude' => $user->longitude,
						'profilePic' => $pic
					]
				];

				$array = $this->arrcheck($array);

				$this->response($array, 200);

				}
			}
		}
	}	

	public function changePassword_post()
	{
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userId'] = $this->post('userId');
			$userData['oldPassword'] = $this->post('oldPassword');
			$userData['newPassword'] = $this->post('newPassword');
		}

		$this->form_validation->set_rules('userId', 'userId', 'trim|required');
		$this->form_validation->set_rules('oldPassword', 'oldPassword', 'trim|required');
		$this->form_validation->set_rules('newPassword', 'newPassword', 'trim|required|min_length[6]');		

		if ($this->form_validation->run() === false) {
			if(form_error('userId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userId'))
				], 400);
			}

			if(form_error('oldPassword')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('oldPassword'))
				], 400);
			}

			if(form_error('newPassword')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('newPassword'))
				], 400);
			}

		} else {	

			$encrptpass = $this->enc_password($userData['oldPassword']);			
			
			$userId = $userData['userId'];		
			$where = "userId = '$userId'";
			
			$details = $this->Apimodel->get_cond('users', $where);

			if($details) 
			{
				if (password_verify($userData['oldPassword'], $details->password) == 0) 
				{
					$this->response([
						'status' => "0",
						'error' => 'Old password is not matched!'
					], 400);

				}

				$data = array(
					'password' => $this->enc_password($userData['newPassword'])
				); 		

				$where="userId = $userId";
				
				$update=$this->Apimodel->update_cond('users', $where, $data);	
				if($update)
				{

					$this->response([
						'status' => "1",
						'userId' => $userId,
						'message' => 'Password updated successfully.'
					], 200);

				} else {
					$this->response(
						[
							'status' => "0",
							'error' => "Some problems occurred, please try again."
						],400);
				}
			} else {

				$this->response([
					'status' => "0",
					'error' => 'User not found!'
				], 400);

			}

		}
	}

	public function profilePic_post() 
	{
		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) 
		{
			$_POST = (array) $obj;
			$userData = $_POST;
		} else {
			$userData['userId'] = $this->post('userId');
			$userData['profilePic'] = $this->post('profilePic');
		}		
		
		$this->form_validation->set_rules('userId', 'userId', 'trim|required');
		
		if ($this->form_validation->run() === false) 
		{
			if(form_error('userId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userId'))
				], 400);

			}

		} else {
			$userId = $userData['userId']; 

			if(empty($_FILES['profilePic']['name']))
			{
				$this->response([
					'status' => "0",
					'error' => "Please insert profilePic"
				], 400);

			} else {

				$query = $this->db->query("SELECT * FROM `users` WHERE `userId`= '".$userId."'");
				$num_rows = $query->num_rows();
				$dataraw = $query->result();

				if($num_rows>0) {

					$config['upload_path'] = './uploads/users/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size'] = 204800;
					
					$config['file_name'] = uniqid();
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload('profilePic')) 
					{
						$error = array('error' => $this->upload->display_errors());
						$image = @$dataraw->profilePic;

					} else {
						$file_data = $this->upload->data();
						$image = $file_data['file_name'];

					} 

					$data = array(
						'profilePic'=>$image
					); 

					$where = array('userId' => $userId);
					$update = $this->Apimodel->update_cond('users',$where, $data);

					$path = base_url()."uploads/users/".$image;

					if($update){
						$this->response([
							'status' => "1",
							'profilePic' => $path,
							'message' => 'Profile pic updated successfully.'
						], 200);

					} else {
						$this->response([
							'status' => "0",
							'error' => "Some problems occurred, please try again."
							 ], 400);
					}

				} else {
					$this->response([
						'status' => "0",
						'error' => 'userId is invalid.'

					], REST_Controller::HTTP_NOT_FOUND);
				}
			}
		}
	}


	public function generate_numbers($start, $count, $digits)
	{
		$result = array();
		for ($n = $start; $n < $start + $count; $n++) {
			$result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
		}
		return $result;
	}

	public function forgetpassword_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['email'] = $this->post('email');
		}

		$this->form_validation->set_rules('email', 'email', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('email')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('email'))
				], 400);
			}
		}else {
		   $where = "email = '".$userData['email']."'";
		   
		   if ($this->mymodel->count('users', $where) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid Email"
			   ], 400);			
		   }else{

		   	  	//Sent Email to user for otp verification
		        $subject = 'New One Time Password From E-Learning';
		        $loginPath = base_url();
		        $imagePath = base_url() . 'images/app_logo_small.png';
		        $imagebackPath = base_url() . 'images/texture-bg.jpg';
		        $random_number = rand(999,99999);

		        $message = "<!Doctype html>
		            <html>
		            <head>
		            <meta charset='utf-8'>
		            <meta name='viewport' content='width=device-width, initial-scale=1'>
		            <title>Sign UP</title>
		            <link href='https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700&display=swap' rel='stylesheet'>
		            <body>
		                <div style='max-width:600px;
		                    margin:auto;
		                    border:1px solid #eee;
		                    box-shadow:0 0 10px rgba(0, 0, 0, .15);
		                    line-height:17px;
		                    font-size:13px;
		                    box-sizing:border-box; -webkit-print-color-adjust: exact;font-family: Poppins, sans-serif; background:url(".$imagebackPath.")'>
		                    <div style='padding:20px; box-sizing: border-box;text-align: center; background: #fff;'>
		                        <a href='#'><img src='".$imagePath."' style='max-width: 100%;width: 100px;'></a>
		                    </div>
		                    <div style='width: 400px; margin:50px auto;background: #ffffffd1;padding: 50px;text-align: center;'>
		                        <h1 style=' font-size: 30px; line-height: 32px; color: #0B0B0B; margin: 30px 0;'>Dear User</h1>
		                        <p style='font-size: 15px;color: #262626;line-height: 24px;margin: 20px 0;'>Thank You for Opting in and Welcome to E-Learning!</p>
		                        <p>
		                            <table>
		                                <tbody>
		                                    <tr style='line-height: 37px;'>
		                                        <td width='120px' style='padding-bottom: 0; text-align:right;'><strong>Email: </strong></td>
		                                        <td>&nbsp;</td>
		                                        <td style='padding-bottom: 0;text-align: left;'>".$userData['email']."</td>
		                                    </tr>
		                                    <tr style='line-height: 20px;'>
		                                        <td width='200px' style='padding-bottom: 0;text-align:right;'><strong>One Time Password:</strong></td>
		                                        <td>&nbsp;</td>
		                                        <td style='padding-bottom: 0;text-align: left;'>".$random_number." </td>
		                                    </tr>
		                                </tbody>
		                            </table>
		                        </p>
		                    </div>
		                    <div style='background: #000;
		                            text-align: left;
		                            box-sizing: border-box;
		                            width: 100%;
		                            padding: 20px 50px;
		                            color: #fff;'>
		                        <p style='margin: 5px 0;font-size: 12px;'>Sincerely,</p>
		                        <p style='margin: 5px 0;font-size: 12px;'>E-Learning</p>
		                        <p style='margin: 5px 0;font-size: 12px;'><strong>Email:</strong> <a href='#' style='color: #78DAFF;'>info@elearning.com</a></p>
		                        <br/>
		                        <p style='margin: 5px 0;font-size: 11px;'>This is an automated response, please do not reply.</p>
		                    </div>
		                </div>
		            </body>
		            </html>"; 
			  //SENT MAIL SCRIPT	
		   	  $this->send_mail($userData['email'],$subject,$message);

              $array = array('status'=>'1','message'=>'Reset link is sent to your email!'); 	
           	  $this->response($array, 200);  
		   } 	
		}
	}

	public function fetchSubjects_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   //$count_user_sql = "SELECT * FROM users u WHERE u.userId = '".$userData['userid']."'";
		   //$count_user = $this->db->query($count_user_sql)->num_rows();

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{

		   	  if($userData['fetch_type'] == "top_list"){
                 $limit_clause = "LIMIT 0,10";
		   	  }else{
                 $limit_clause = "";
		   	  }

			  //Fetching dashboard category data
		   	  $fetch_subject_list = "SELECT s.subjectId,s.subjectName,s.image,Count(DISTINCT chp.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM subjects s LEFT JOIN chapters chp ON s.subjectId=chp.subjectId WHERE s.status='1' GROUP BY s.subjectId ORDER BY s.created DESC ".$limit_clause;
		   	  
		   	  $responseArr = $this->mymodel->fetch($fetch_subject_list);

              foreach($responseArr as $index => $subject){
			  	 $responseArr[$index]->subjectName = html_entity_decode($subject->subjectName);

			  	 if(!empty($subject->image)){
					$responseArr[$index]->image = base_url('uploads/subject/'.$subject->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }
			  }

		   	  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Subject list is fetched successfully!','subjectList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Subject Found!"
			     ], 400);
		   	  }

             // $array = array('status'=>'1','message'=>'Subject list is fetched successfully!','subjectList'=>$responseArr); 	
           	 // $this->response($array, 200);  
		   } 	
		}
	}

	public function fetchCourses_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{

		   	   if($userData['fetch_type'] == "top_list"){
                 $limit_clause = "LIMIT 0,10";
		   	   }else{
                 $limit_clause = "";
 		   	   }

			   $sql_course_list = "SELECT c.*,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE c.status = '1' AND cl.status = '1' GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC ".$limit_clause;  
			  
			   //echo $sql_course_list;exit;

			   $responseArr = $this->mymodel->fetch($sql_course_list, false);

			   foreach($responseArr as $index => $course){
			  	 $responseArr[$index]->courseName = html_entity_decode($course->courseName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($course->descriptions);

			  	 if(!empty($course->image)){
					$responseArr[$index]->image = base_url('uploads/courses/'.$course->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($course->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$course->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			   }		

               if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Course list is fetched successfully!','courseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	   }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Course Found!"
			     ], 400);
		   	   } 
		    } 	
		}
	}

	public function fetchTrendingCourse_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  if($userData['fetch_type'] == "top_list"){
                 $limit_clause = "LIMIT 0,10";
		   	  }else{
                 $limit_clause = "";
		   	  }

			  $sql_trending_course_list = "SELECT c.*,cl.level,(SELECT Count(DISTINCT spc.purchaseId) FROM course_level_details cl LEFT JOIN student_purchased_courses spc ON ( cl.courseId=spc.courseId AND cl.level=spc.courseLvl ) )as purchaseCount,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) INNER JOIN chapters chp ON ( cc.chapterId=chp.chapterId AND cl.courseId = cc.courseId AND cl.level = cc.level )WHERE c.status = '1' AND cl.status = '1' GROUP BY cl.crsLvlId HAVING purchaseCount>0 ORDER BY purchaseCount DESC ".$limit_clause;  
		
			  //echo $sql_trending_course_list;exit;

			  $responseArr = $this->mymodel->fetch($sql_trending_course_list, false);

			  foreach($responseArr as $index => $course){
			  	 $responseArr[$index]->courseName = html_entity_decode($course->courseName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($course->descriptions);

			  	 if(!empty($course->image)){
					$responseArr[$index]->image = base_url('uploads/courses/'.$course->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($course->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$course->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			  }	

			  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Trending courses are fetched successfully!','trendingCourseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Trending Courses Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Trending courses are fetched successfully!','trendingCourseList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchTrendingSubject_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  if($userData['fetch_type'] == "top_list"){
                 $limit_clause = "LIMIT 0,10";
		   	  }else{
                 $limit_clause = "";
		   	  }

			  $sql_trending_subject_list = "SELECT s.subjectId,s.subjectName,s.image as subject_image,Count(cc.subjectId) as subjectCount FROM course_chapters cc LEFT JOIN student_purchased_courses spc ON ( cc.courseId=spc.courseId AND cc.level=spc.courseLvl ) LEFT JOIN subjects s ON ( cc.subjectId = s.subjectId ) WHERE s.status = '1' GROUP BY cc.subjectId HAVING subjectCount>0 ORDER BY subjectCount DESC ".$limit_clause;  
		
			  //echo $sql_trending_subject_list;exit;

			  $responseArr = $this->mymodel->fetch($sql_trending_subject_list, false);	
			  
			  foreach($responseArr as $index => $subject){
			  	 $responseArr[$index]->subjectName = html_entity_decode($subject->subjectName);

			  	 if(!empty($subject->subject_image)){
					$responseArr[$index]->subject_image = base_url('uploads/subject/'.$subject->subject_image);
				 }else {
				    $responseArr[$index]->subject_image = base_url().'uploads/noimg.png';
				 }
			  }
              
			  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Trending subjects are fetched successfully!','trendingSubjectList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Trending Subjects Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Trending subjects are fetched successfully!','trendingSubjectList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchRecentCourses_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  if($userData['fetch_type'] == "top_list"){
		   	  	 /*$where_clause_pointer = "WHERE MONTH(c.created) = MONTH(CURRENT_DATE())AND YEAR(c.created) = YEAR(CURRENT_DATE()) AND c.status='1' AND cl.status = '1'";*/
		   	  	 $where_clause_pointer = "WHERE c.created between (CURDATE() - INTERVAL 2 MONTH ) and CURDATE() AND c.status='1' AND cl.status = '1'";
		   	  	 $limit_clause = "LIMIT 0,10";
		   	  }else{
                 $where_clause_pointer = "WHERE ( c.created >= now()-interval 2 month ) AND c.status = '1' AND cl.status = '1'";
                 $limit_clause = "";
		   	  }
		   	  
			  $sql_course_list = "SELECT c.*,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId ".$where_clause_pointer." GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC ".$limit_clause;  
			  
			  //echo $sql_course_list;exit;

			  $responseArr = $this->mymodel->fetch($sql_course_list, false);

			  foreach($responseArr as $index => $course){
			  	 $responseArr[$index]->courseName = html_entity_decode($course->courseName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($course->descriptions);

			  	 if(!empty($course->image)){
					$responseArr[$index]->image = base_url('uploads/courses/'.$course->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($course->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$course->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			  }		

			  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Recently added courses are fetched successfully!','recentCourseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Recent Courses Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Recently added courses are fetched successfully!','recentCourseList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchCourseSubjectWise_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['subjectId'] = $this->post('subjectId');
			$userData['fetch_type'] = $this->post('fetchType');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('subjectId', 'subjectId', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('subjectId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('subjectId'))
				], 400);
			}
		}else {
		   
		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  if($userData['fetch_type'] == "top_list"){
                 $limit_clause = "LIMIT 0,10";
		   	  }else{
                 $limit_clause = "";
		   	  }

		   	  $subjectId = $userData['subjectId'];

			  $sql_course_list = "SELECT c.*,s.subjectName,s.image as subject_image,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId LEFT JOIN subjects s ON cc.subjectId=s.subjectId WHERE cc.subjectId='$subjectId' AND c.status = '1' AND cl.status = '1' GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC ".$limit_clause;  
		
			  //echo $sql_course_list;exit;

			  $responseArr = $this->mymodel->fetch($sql_course_list, false);	

			  foreach($responseArr as $index => $subject){
			  	 $responseArr[$index]->subjectName = html_entity_decode($subject->subjectName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($subject->descriptions);
			  	 $responseArr[$index]->image = base_url('uploads/courses/'.$subject->image);

			  	 if(!empty($subject->subject_image)){
					$responseArr[$index]->subject_image = base_url('uploads/subject/'.$subject->subject_image);
				 }else {
				    $responseArr[$index]->subject_image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($subject->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$subject->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			  }		

			  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'All Courses are fetched successfully!','courseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Course Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Trending courses are fetched successfully!','courseList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchCourseDetails_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  $userId = $userData['userid'];
		   	  $courseId = $userData['courseId'];
		   	  $courseLvl = $userData['courseLvl'];

		   	  $sql_course_details = "SELECT c.courseId,c.courseName,c.descriptions as courseDesc,c.image as courseImg,c.status as course_status,GROUP_CONCAT(DISTINCT cl.level SEPARATOR ',') as level,Count(DISTINCT cc.courseDetailId) as courseChapters,( SELECT SUM(chp.totalHours) FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId = '$courseId' ) as totalHours, ( SELECT SUM(chp.cost) FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId = '$courseId' ) as courseTotalCost FROM courses c LEFT JOIN course_level_details cl ON c.courseId=cl.courseId LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE c.status='1' AND cl.status='1' AND cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

			  //echo $sql_course_details;exit;

			  //Feching Course Details 
	 		  $responseArr = $this->mymodel->fetch($sql_course_details, true);

	 		  if($responseArr->course_status == 1){

				  $sql_course_purchase_status = "SELECT spc.purchaseId,spc.created FROM student_purchased_courses spc WHERE spc.userId='".$userId."' AND spc.courseId='".$courseId."' AND spc.courseLvl='".$courseLvl."' ORDER BY spc.purchaseId";

				   //echo $sql_course_purchase_status;exit;

				   $purchaseData = $this->mymodel->fetch($sql_course_purchase_status, true);

				   if(count($purchaseData)>0){
				  	 $purchaseStatus = 1;
				   }else{
				  	 $purchaseStatus = 0;
				   }

		 		   $sql_course_level_details = "SELECT cl.crsLvlId,cl.level,cl.image as levelImg,cl.descriptions as selectedLevelDesc,Count(DISTINCT cc.courseDetailId) as selectedLevelChapters,( SELECT SUM(chp.totalHours) FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId = '$courseId' AND cc.level = '$courseLvl' ) as lvlHours, ( SELECT SUM(chp.cost) FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId = '$courseId' AND cc.level = '$courseLvl' ) as lvlCost FROM courses c LEFT JOIN course_level_details cl ON ( c.courseId=cl.courseId AND cl.level='".$courseLvl."' )LEFT JOIN course_chapters cc ON ( c.courseId=cc.courseId AND cc.level='$courseLvl') LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cl.status='1' AND cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

				  //echo $sql_course_level_details;exit;

				  //Feching Course Details 
		 		  $courseLvlDetail = $this->mymodel->fetch($sql_course_level_details, true);

			  	  $responseArr->courseName = html_entity_decode($responseArr->courseName);
			  	  $responseArr->courseDesc = html_entity_decode($responseArr->courseDesc);

			  	  if(!empty($responseArr->courseImg)){
					$responseArr->courseImg = base_url('uploads/courses/'.$responseArr->courseImg);
				  }else {
				    $responseArr->courseImg = base_url().'uploads/noimg.png';
				  }

			  	  //Including course level details
			  	  if(!empty($courseLvlDetail->levelImg)){
					$responseArr->levelImg = base_url('uploads/level/'.$courseLvlDetail->levelImg);
				  }else {
				    $responseArr->levelImg = base_url().'uploads/noimg.png';
				  }

			  	  $responseArr->selectedLevelDesc = html_entity_decode($courseLvlDetail->selectedLevelDesc);
			  	  
			  	  if(!empty($courseLvl)){
	                 $responseArr->selectedLevel = $courseLvl;
			  	  }else{
	                 $responseArr->selectedLevel = null;
			  	  }
			  	  
			  	  $responseArr->selectedLevelChapters = $courseLvlDetail->selectedLevelChapters;
			  	  $responseArr->selectedLevelHours = $courseLvlDetail->lvlHours;
			  	  $responseArr->selectedLevelCost = $courseLvlDetail->lvlCost;
			  	  $responseArr->purchaseStatus = $purchaseStatus;

			  	  if(count($purchaseData)>0){
			  	  	$responseArr->purchaseDateTime = $purchaseData->created;
			  	  }else{
			  	  	$responseArr->purchaseDateTime = '';
			  	  } 	

			  	  $courseLevel = explode(',', $responseArr->level);

			  	  foreach($courseLevel as $index => $level){
			  	  	 $levelArr[$index]['name']  = $level;

			  	  	 if($level == $courseLvl){
			  	  	 	$levelArr[$index]['level_status']  = '1';
			  	  	 }else{
			  	  	 	$levelArr[$index]['level_status']  = '0';
			  	  	 }
			  	  }

			  	  $responseArr->level = $levelArr;

		 		  if($responseArr->courseId != null){
			   	     $array = array('status'=>'1','message'=>'Course details is fetched successfully!','courseDetail'=>$responseArr); 	
	           	     $this->response($array, 200);  			
			   	  }else{
			   	  	 $this->response([
						'status' =>"0",
						'error' => "No Course Detail Found!"
				     ], 400);
			   	  }

	              //$array = array('status'=>'1','message'=>'Course details is fetched successfully!','courseDetail'=>$responseArr); 	
	           	  //$this->response($array, 200);  
	          }else{
	          	  $this->response([
					'status' =>"0",
					'error' => "This course isn't active at this moment."
			      ], 400);	
	          } 	  
		   } 	
		}
	}

	public function fetchCourseLevelSubjects_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}
		}else {
		   
		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  $userId = $userData['userid'];
		   	  $courseId = $userData['courseId'];
		   	  $courseLvl = $userData['courseLvl'];

		   	  //CHECKING COURSE'S PURCHASE STATUS
			  $sql_course_purchase_status = "SELECT spc.purchaseId,spc.created FROM student_purchased_courses spc WHERE spc.userId='".$userId."' AND spc.courseId='".$courseId."' AND spc.courseLvl='".$courseLvl."' ORDER BY spc.purchaseId";

			  //echo $sql_course_purchase_status;exit;

			  $purchaseCount = $this->db->query($sql_course_purchase_status)->num_rows();

			  $purchaseData = $this->mymodel->fetch($sql_course_purchase_status, true);

			  if(count($purchaseData)>0){
			  	 $purchaseStatus = 1;
			  }else{
			  	 $purchaseStatus = 0;
			  }

	 		  //FETCHING COURSE'S CHAPTER DETAIL
			  $sql_course_subject = "SELECT cc.level,s.subjectId,s.subjectName,s.image,s.status as subject_status FROM course_chapters cc LEFT JOIN chapters c ON cc.subjectId=c.subjectId LEFT JOIN subjects s ON c.subjectId=s.subjectId WHERE s.status='1' AND cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' GROUP BY cc.subjectId";

			  //echo $sql_course_subject;exit;

			  $responseArr = $this->mymodel->fetch($sql_course_subject, false);	

			  foreach($responseArr as $index => $subject){
			  	 $responseArr[$index]->subjectName = html_entity_decode($subject->subjectName);

			  	 if(!empty($subject->image)){
					$responseArr[$index]->image = base_url('uploads/subject/'.$subject->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }
			  }		

			  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Course subject list is fetched successfully!','courseSubjectList'=>$responseArr,'purchaseStatus'=>$purchaseStatus); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Subject Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Course details is fetched successfully!','courseList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchCourseChapterData_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['subjectId'] = $this->post('subjectId');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('subjectId', 'subjectId', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('subjectId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('subjectId'))
				], 400);
			}
		}else {
		   

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  $courseId = $userData['courseId'];
		   	  $courseLvl = $userData['courseLvl'];
		   	  $subjectId = $userData['subjectId'];

		   	  $sql_level_details = "SELECT c.courseName,c.image as course_image,cl.image as level_image,s.subjectName,s.image as subject_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(DISTINCT chp.cost) as lvlCost,SUM(chp.totalHours) as courseDuration FROM courses c LEFT JOIN course_level_details cl ON (cl.courseId='$courseId' AND cl.level = '$courseLvl') LEFT JOIN course_chapters cc ON c.courseID = cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId LEFT JOIN subjects s ON cc.subjectId=s.subjectId WHERE s.subjectId='".$subjectId."' AND cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

		   	  //Feching Course Details 
		 	  $courseLevelDetail = $this->mymodel->fetch($sql_level_details, true);

		 	  $courseLevelDetail->subjectName = html_entity_decode($courseLevelDetail->subjectName);

		 	  if(!empty($courseLevelDetail->course_image)){
				  $courseLevelDetail->course_image = base_url('uploads/courses/'.$courseLevelDetail->course_image);
			  }else {
			      $courseLevelDetail->course_image = base_url().'uploads/noimg.png';
			  }

			  if(!empty($courseLevelDetail->level_image)){
				  $courseLevelDetail->level_image = base_url('uploads/level/'.$courseLevelDetail->level_image);
			  }else {
			      $courseLevelDetail->level_image = base_url().'uploads/noimg.png';
			  }

			  if(!empty($courseLevelDetail->subject_image)){
				  $courseLevelDetail->subject_image = base_url('uploads/subject/'.$courseLevelDetail->subject_image);
			  }else {
			      $courseLevelDetail->subject_image = base_url().'uploads/noimg.png';
			  }

	 		  $sql_level_chapter = "SELECT cc.subjectId,s.subjectName,c.chapterId,c.chapterId,c.chapterName,c.summary,c.chapterImage,c.cost,c.totalHours as chapterDuration,c.status as chapter_status FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId=c.chapterId LEFT JOIN subjects s ON cc.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND cc.subjectId='".$subjectId."'";

			  //echo $sql_level_chapter;exit;

			  //Feching Course Details 
		 	  $responseArr = $this->mymodel->fetch($sql_level_chapter, false);

		 	  foreach($responseArr as $index => $chapter){
		 	  	 $responseArr[$index]->subjectName = html_entity_decode($chapter->subjectName);
			  	 $responseArr[$index]->chapterName = html_entity_decode($chapter->chapterName);
			  	 $responseArr[$index]->summary = html_entity_decode($chapter->summary);

			  	 if(!empty($chapter->chapterImage)){
					$responseArr[$index]->chapterImage = base_url('uploads/chapter/'.$chapter->chapterImage);
				 }else {
				    $responseArr[$index]->chapterImage = base_url().'uploads/noimg.png';
				 }
			  }		

		 	  if(count($responseArr)>0){
		   	     $array = array(
		   	     	  'status'=>'1','message'=>'Course chapters are fetched successfully!',
		   	     	  'courseName'=>$courseLevelDetail->courseName,
		   	     	  'courseImg'=>$courseLevelDetail->course_image,
		   	     	  'courseId'=>$courseId,
		   	     	  'courseLvl'=>$courseLvl,
		   	     	  'courseLvlImg'=>$courseLevelDetail->level_image,
		   	     	  'courseCost'=>$courseLevelDetail->lvlCost,
		   	     	  'courseDuration'=>$courseLevelDetail->courseDuration,
		   	     	  'subjectId'=>$subjectId,
		   	     	  'subjectName'=>$courseLevelDetail->subjectName,
		   	     	  'subjectImg'=>$courseLevelDetail->subject_image,
		   	     	  'totalChapter'=>$courseLevelDetail->totalChapter,
		   	     	  'subjectChapterList'=>$responseArr
		   	     ); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Chapter Found!"
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Course chapters are fetched successfully!','subjectChapterList'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function fetchChapterDetails_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['subjectId'] = $this->post('subjectId');
			$userData['chapterId'] = $this->post('chapterId');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('subjectId', 'subjectId', 'trim|required');
		$this->form_validation->set_rules('chapterId', 'chapterId', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('subjectId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('subjectId'))
				], 400);
			}

			if(form_error('chapterId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('chapterId'))
				], 400);
			}
		}else {
		   

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
		   	  $courseId = $userData['courseId'];
		   	  $courseLvl = $userData['courseLvl'];
		   	  $subjectId = $userData['subjectId'];
		   	  $chapterId = $userData['chapterId'];

	 		  $sql_chapter_details = "SELECT c.chapterId,c.chapterId,c.chapterName,c.objectives,c.summary,c.chapterImage,c.cost,c.totalHours,c.status as chapter_status FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId=c.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND cc.subjectId='".$subjectId."' AND c.chapterId='".$chapterId."' AND c.status='1'";

			  //echo $sql_chapter_details;exit;

			  //Feching Course Details 
		 	  $responseArr = $this->mymodel->fetch($sql_chapter_details, true);

		 	  if($responseArr->chapter_status == 1){
                  
                  $responseArr->subjectId = $subjectId;
			  	  $responseArr->chapterName = html_entity_decode($responseArr->chapterName);
			  	  $responseArr->objectives = html_entity_decode($responseArr->objectives);
			  	  $responseArr->summary = html_entity_decode($responseArr->summary);

			  	  if(!empty($responseArr->chapterImage)){
					 $responseArr->chapterImage = base_url('uploads/chapter/'.$responseArr->chapterImage);
				  }else {
				     $responseArr->chapterImage = base_url().'uploads/noimg.png';
				  }

			 	  if(!empty($responseArr)){
			   	     $array = array('status'=>'1','message'=>'Chapter details is fetched successfully!','chapterDetails'=>$responseArr); 	
	           	     $this->response($array, 200);  			
			   	  }else{
			   	  	 $this->response([
						'status' =>"0",
						'error' => "No Chapter Detail Found!"
				     ], 400);
			   	  }
			  }else{
			  	$this->response([
					'status' =>"0",
					'error' => "This chapter isn't active at this moment."
			    ], 400);
			  } 	  

              //$array = array('status'=>'1','message'=>'Chapter details is fetched successfully!','chapterDetails'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}

	public function create_Course_Purchase_Id(){

		$sql_last_purchase_id = "SELECT * FROM student_purchased_courses ORDER BY purchaseId DESC LIMIT 1";

		//echo $sql_last_purchase_id;exit;

		$lastPurchaseDetail = $this->mymodel->fetch($sql_last_purchase_id, true);

        if($lastPurchaseDetail != null){
          $last_uP_id = base64_decode($lastPurchaseDetail->uniquePurchaseId);
          	
          $last_uP_id_2 = substr($last_uP_id,7);
          $last_uP_id_2++;
        }else{
          $last_uP_id_2 = 1; 
        }
        
        return base64_encode("ELCPUId".$last_uP_id_2);
	}

	public function purchaseCourse_post(){
        
        $json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

		}else {

		   $where_check_user = "userId = '".$userData['userid']."'";
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		    }else{
		       if(!empty($userData['userid'])){	
		       	 $userId = $userData['userid'];
		   	     $courseId = $userData['courseId'];
		   	     $courseLvl = $userData['courseLvl'];

		 		 $sql_level_details = "SELECT c.courseName, SUM(DISTINCT chp.cost) as lvlCost FROM courses c LEFT JOIN course_chapters cc ON c.courseID = cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

				 //echo $sql_level_details;exit;

				 //Feching Course Details 
		 		 $levelDetail = $this->mymodel->fetch($sql_level_details, true);

		 		 //Checking if the student has already purchased this course
		 		 $where_check_purchase = array('courseId'=>$courseId,'courseLvl'=>$courseLvl,'userId'=>$userId);

		 		 if($this->mymodel->count('student_purchased_courses',$where_check_purchase)>0){
		 			$responseArr = array('check'=>'failure','msg'=>'You have already purchased this course!');
		 		 }else{

			 		$lvlCost = $levelDetail->lvlCost;
			 		$courseName = $levelDetail->courseName;

			 		$transactionData = serialize(array('payment_method'=>'unknown','amount'=>$lvlCost));
			 		$uniquePurchaseId = $this->create_Course_Purchase_Id();

				    $coursePurchaseData = array(
				    	'userId'=>$userId,
				    	'uniquePurchaseId'=>$uniquePurchaseId,
				    	'courseId'=>$courseId,
				    	'courseLvl'=>$courseLvl,
				    	'lvlCost'=>$lvlCost,
				    	'payment_method'=>'Unknown',
				    	'transaction_data'=>$transactionData,
				    	'created'=>date('Y-m-d H:i:s') 
				    ); 
				   
				    //Insert data into db
				    if($this->mymodel->save('student_purchased_courses', $coursePurchaseData)){ 
				    	$coursePurchaseData['courseName'] = $courseName; 
		 				$responseArr = array('check'=>'success','msg'=>'Course has been purchased successfully!');
		 		    }else{
		 		    	$responseArr = array('check'=>'failure','msg'=>'Something went wrong; Please try again.');
		 		    }
		 		 }    
	 		  }else{
	 			 $responseArr = array('check'=>'failure','msg'=>'Please login to make this purchase!');
	 		  }    

	 		  //print_r($responseArr);exit

		 	  if($responseArr['check'] == 'success'){
		   	     $array = array('status'=>'1','message'=>$responseArr['msg'],'purchaseData'=>$coursePurchaseData); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => $responseArr['msg']
			     ], 400);
		   	  }

              //$array = array('status'=>'1','message'=>'Chapter details is fetched successfully!','chapterDetails'=>$responseArr); 	
           	  //$this->response($array, 200);  
		   } 	
		}
	}	

	public function fetchEnrolledCourses_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
               $userId = $userData['userid'];

			   $sql_enrolled_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId";			  
			   //echo $sql_enrolled_courses;exit;

			   $responseArr = $this->mymodel->fetch($sql_enrolled_courses, false);

			   foreach($responseArr as $index => $course){
			  	 $responseArr[$index]->courseName = html_entity_decode($course->courseName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($course->descriptions);
			  	 if(!empty($course->image)){
					$responseArr[$index]->image = base_url('uploads/courses/'.$course->image);
				 }else {
				    $responseArr[$index]->image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($course->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$course->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			   }		

               if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Course list is fetched successfully!','enrolledCourseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	   }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Course Found!"
			     ], 400);
		   	   } 
		    } 	
		}
	}

	public function fetchEnrolledCourseDetail_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
               $userId = $userData['userid'];
               $courseId = $userData['courseId'];
               $courseLvl = $userData['courseLvl'];

			   $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."'";

			   //echo $sql_course_details;exit;

			   //Feching Course Details 
		 	   $courseDetail = $this->mymodel->fetch($sql_course_details, true);

		 	   $courseDetail->descriptions = html_entity_decode($courseDetail->descriptions);
			   $courseDetail->image = base_url('uploads/courses/'.$courseDetail->image);

			   $sql_course_purchase_status = "SELECT spc.purchaseId,spc.created FROM student_purchased_courses spc WHERE spc.userId='".$userId."' AND spc.courseId='".$courseId."' AND spc.courseLvl='".$courseLvl."' ORDER BY spc.purchaseId";

			   //echo $sql_course_purchase_status;exit;

			   $purchaseData = $this->mymodel->fetch($sql_course_purchase_status, true);

			   if(count($purchaseData)>0){
			  	 $purchaseStatus = 1;
			   }else{
			  	 $purchaseStatus = 0;
			   }

			   $courseDetail->purchaseStatus = $purchaseStatus;
			   
			   if(count($purchaseData)>0){
		  	      $responseArr->purchaseDateTime = $purchaseData->created;
		  	   }else{
		  	   	  $responseArr->purchaseDateTime = '';
		  	   } 	

		 	   //FETCHING COURSE'S CHAPTER DETAIL
			   $sql_course_subject = "SELECT cc.level,s.* FROM student_purchased_courses spc LEFT JOIN course_chapters cc ON spc.courseId = cc.courseId  LEFT JOIN subjects s ON cc.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND spc.userId='".$userId."' GROUP BY cc.subjectId";

			   //echo $sql_course_subject;exit;

			   $courseSubjects = $this->mymodel->fetch($sql_course_subject, false);

			   foreach($courseSubjects as $index => $subject){
			  	 $courseSubjects[$index]->subjectName = html_entity_decode($subject->subjectName);
			  	 $courseSubjects[$index]->summary = html_entity_decode($subject->summary);
			  	 $courseSubjects[$index]->objectives = html_entity_decode($subject->objectives);
			  	 if(!empty($subject->image)){
					$courseSubjects[$index]->image = base_url('uploads/subject/'.$subject->image);
				 }else {
				    $courseSubjects[$index]->image = base_url().'uploads/noimg.png';
				 }
			   }

               if(!empty($courseDetail)>0){
		   	     $array = array('status'=>'1','message'=>'Course list is fetched successfully!','courseDetail'=>$courseDetail,'courseSubjects'=>$courseSubjects); 	
           	     $this->response($array, 200);  			
		   	   }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Course Found!"
			     ], 400);
		   	   } 
		    } 	
		}
	}

	public function fetchInstructorList_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
               $userId = $userData['userid'];
               $courseId = $userData['courseId'];
               $courseLvl = $userData['courseLvl'];

               //Check if user perchased this course
               $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$userId'";

               //echo $sql_check_purchse_status;exit;

               $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

               //Check if user perchased this course
               /*$sql_check_ins_crs_exists = "SELECT spc.purchaseId FROM course_instructors ci WHERE ci.courseId='$courseId' AND ci.level='$courseLvl' AND spc.instructorId='$instructorId'";

               //echo $sql_check_ins_crs_exists;exit;

               $checkInstructorExists = $this->db->query($sql_check_ins_crs_exists)->num_rows();*/

               if($purchaseCount>0){

               	   $sql_booked_instructor_data = "SELECT COALESCE(sbc.instructorId,'') as bookedInstructorId,COALESCE(cr.reviewId,'') as reviewId,COALESCE(cr.rating,'') as rating,COALESCE(cr.feedback,'') as feedback,COALESCE(sct.conferenceId,'') as conferenceId,COALESCE(sct.meeting_url,'') as meeting_url,COALESCE(sct.passcode,'') as passcode FROM student_booked_classes sbc LEFT JOIN course_review cr ON ( sbc.courseId=cr.courseId  AND sbc.courseLvl = cr.courseLvl AND sbc.studentId = cr.studentId AND sbc.instructorId = cr.instructorId ) LEFT JOIN session_conference_tbl sct ON ( sbc.studentId = sct.studentId AND sbc.instructorId = sct.instructorId AND sbc.courseId = sct.courseId AND sbc.courseLvl = sct.courseLvl ) WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' ORDER BY sbc.classId DESC LIMIT 1";

				   //echo $sql_booked_instructor_data;exit; 

				   //Feching Enrolled Course List 
				   $instructorData = $this->mymodel->fetch($sql_booked_instructor_data, true);

				   if(!empty($instructorData)){
				 	  $instructorData = $instructorData;
				   }else{
				 	  $instructorData = array(
				 	  	 'bookedInstructorId' => '',
				 	  	 'reviewId' => '',
				 	  	 'rating' => '',
				 	  	 'feedback' => '',
				 	  	 'conferenceId' => '',
				 	  	 'meeting_url' => '',
				 	  	 'passcode' => ''
				 	  );
				   }	

				   $sql_course_subject = "SELECT ins.level,u.userId as instructorId,u.firstName,u.lastName,u.email,COALESCE(u.ccName,'') as ccName,COALESCE(u.ccCode,'') as ccCode,u.descriptions,u.profilePic,u.status as user_active_status,COALESCE(AVG(cr.rating),'') as insAvgRating FROM student_purchased_courses spc LEFT JOIN course_instructors ins ON spc.courseId = ins.courseId LEFT JOIN course_review cr ON ins.instructorId = cr.instructorId LEFT JOIN users u ON ins.instructorId=u.userId WHERE ins.courseId='".$courseId."' AND ins.level='".$courseLvl."' AND spc.userId='".$userId."' AND u.userType = '2' AND u.status = '1' GROUP BY ins.instructorId";

				   //echo $sql_course_subject;exit;

				   //Feching Enrolled Course List 
				   $instructorList = $this->mymodel->fetch($sql_course_subject, false);

				   foreach($instructorList as $index => $instructor){
				  	 $instructorList[$index]->descriptions = html_entity_decode($instructor->descriptions);

				  	 if(!empty($instructor->profilePic)){
						$pic = base_url('uploads/users/'.$instructor->profilePic);
					 }else {
					    $pic = base_url().'uploads/noimg.png';
					 }
				  	 $instructorList[$index]->profilePic = $pic;
				  	 $instructorList[$index]->booked_instructor_data = $instructorData;
				   }

	               if(count($instructorList)>0){
			   	     $array = array('status'=>'1','message'=>'Instructor list is fetched successfully!','instructorlist'=>$instructorList); 	
	           	     $this->response($array, 200);  			
			   	   }else{
			   	  	 $this->response([
						'status' =>"0",
						'error' => "No Instructor Found!"
				     ], 400);
			   	   } 
			   }else{
			   	   $this->response([
						'status' =>"0",
						'error' => "You aren't elligible to view the instructor list!"
				   ], 400);	
			   }   
		    } 	
		}
	}

	public function fetchInstructorDetails_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['insId'] = $this->post('insId');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('insId', 'insId', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('insId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('insId'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
               $userId = $userData['userid'];
               $courseId = $userData['courseId'];
               $courseLvl = $userData['courseLvl'];
               $insId = $userData['insId'];

               //Check if user perchased this course
               $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$userId'";

               //echo $sql_check_purchse_status;exit;

               $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

               //Check if user perchased this course
               $sql_check_ins_crs_exists = "SELECT ci.courseInsId FROM course_instructors ci WHERE ci.courseId='$courseId' AND ci.level='$courseLvl' AND ci.instructorId='$insId'";

               //echo $sql_check_ins_crs_exists;exit;

               $checkInstructorExists = $this->db->query($sql_check_ins_crs_exists)->num_rows();

               if($purchaseCount>0 && $checkInstructorExists>0){

				   $sql_ins_details = "SELECT ins.level,u.userId as instructorId,u.firstName,u.lastName,u.email,COALESCE(u.ccName,'') as ccName,COALESCE(u.ccCode,'') as ccCode,u.descriptions,u.profilePic,u.status as user_active_status,COALESCE(AVG(cr.rating),'') as insAvgRating FROM student_purchased_courses spc LEFT JOIN course_instructors ins ON spc.courseId = ins.courseId LEFT JOIN course_review cr ON ins.instructorId = cr.instructorId LEFT JOIN users u ON ins.instructorId=u.userId WHERE ins.courseId='".$courseId."' AND ins.level='".$courseLvl."' AND spc.userId='".$userId."' AND u.userType = '2' AND u.status = '1' AND u.userId='$insId'";

				   //echo $sql_ins_details;exit;

				   //Feching Enrolled Course List 
				   $instructorDetails = $this->mymodel->fetch($sql_ins_details, true);

				   $instructorDetails->descriptions = html_entity_decode($instructorDetails->descriptions);

				   if(!empty($instructorDetails->profilePic)){
					  $instructorDetails->profilePic = base_url('uploads/users/'.$instructorDetails->profilePic);
				   }else {
					  $instructorDetails->profilePic = base_url().'uploads/noimg.png';
				   }

	               if(!empty($instructorDetails)){
			   	     $array = array('status'=>'1','message'=>'Instructor details is fetched successfully!','instructorDetails'=>$instructorDetails); 	
	           	     $this->response($array, 200);  			
			   	   }else{
			   	  	 $this->response([
						'status' =>"0",
						'error' => "No Instructor Found!"
				     ], 400);
			   	   } 
			   	}else{
			   	   $this->response([
						'status' =>"0",
						'error' => "You aren't elligible to view the instructor list!"
				    ], 400);	
			   	}   
		    } 	
		}
	}

	public function fetchDashboardData_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   //$count_user_sql = "SELECT * FROM users u WHERE u.userId = '".$userData['userid']."'";
		   //$count_user = $this->db->query($count_user_sql)->num_rows();
		   $where_check_user = "userId = '".$userData['userid']."'";	
		   
		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
			  $userId = $userData['userid'];
			  $runningCourseCount = 0;
			  $completedCourseCount = 0;

			  $sql_enrolled_courses = "SELECT Count(spc.purchaseId) as enrolledCourseCount FROM student_purchased_courses spc WHERE spc.userId = '".$userId."' ORDER BY spc.purchaseId DESC";  

			  //echo $sql_enrolled_courses;exit;

			  //Feching Enrolled Course List 
			  $enrolledCourseData = $this->mymodel->fetch($sql_enrolled_courses, true);

			  $responseArr['courseData'] = $enrolledCourseData->enrolledCourseCount;

			  $sql_purchased_courses = "SELECT spc.courseId,spc.courseLvl FROM student_purchased_courses spc WHERE spc.userId = '".$userId."' ORDER BY spc.purchaseId";  

			  //echo $sql_purchased_courses;exit;

			  //Feching Enrolled Course List 
			  $purchaseData = $this->mymodel->fetch($sql_purchased_courses, false);

			  foreach ($purchaseData as $key => $purchased) {

		 		 $purchasedCourseId = $purchased->courseId;
		 		 $purchasedCourseLvl = $purchased->courseLvl;
		 		 
		 		 $sql_running_courses = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId = '".$purchasedCourseId."' AND sbc.courseLvl = '".$purchasedCourseLvl."' ORDER BY sbc.classId DESC";  

			 	//echo $sql_running_courses;exit;

			    //Feching Enrolled Course List 
			 	$bookedClassData = $this->db->query($sql_running_courses)->num_rows();

			 	if($bookedClassData>0){
			 		$runningCourseCount++;
			 	}
			  }

			  $responseArr['runningCourseData'] = $runningCourseCount;

			  //Calculate complted course data
			 	$sql_enrolled_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId";  

			   //echo $sql_enrolled_courses;exit;

			   //Feching Enrolled Course List 
			   $data['course_type'] = "active";
			   $courseData = $this->mymodel->fetch($sql_enrolled_courses, false);

			   foreach ($courseData as $index => $course) {

		 		 $courseId = $course->courseId; 
		 		 $courseLvl = $course->courseLvl; 
		 		 $courseTotalSession = $course->totalHours; 
		 		
		 		 //Calculate student bookes season
			    $sql_student_booked_season = "SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."'ORDER BY sbc.courseId";  

			    //echo $sql_student_booked_season;exit; 

			    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);
			    $totalBookedSeason = 0;

			    foreach ($diffTime as $key => $time) {
			    	$totalBookedSeason +=  round($time->timeDiff);
			    }

			    //Fetching last class date for current course
			    $sql_student_last_booked_season = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."'ORDER BY sbc.classDate DESC LIMIT 1";  

			    //echo $sql_student_last_booked_season;exit; 

			    $lastSessionDetail = $this->mymodel->fetch($sql_student_last_booked_season, true);

			    $today = date('Y-m-d');

			    if($totalBookedSeason >= $courseTotalSession && $today>$lastSessionDetail->classDate){
			    	$completedCourseCount++;
			    }
			  }
	
              //Feching Completed Course List 
			  $responseArr['completedCourseData'] = $completedCourseCount;

		   	  if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Dashboard data is fetched successfully!','dashboardData'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Data Found!"
			     ], 400);
		   	  }

              $array = array('status'=>'1','message'=>'Dashboard data is fetched successfully!','dashboardData'=>$responseArr); 	
           	  $this->response($array, 200);  
		   } 	
		}
	}

	public function create_Class_Booking_Id(){

		$sql_last_booking_id = "SELECT * FROM student_booked_classes ORDER BY classId DESC LIMIT 1";

		//echo $sql_last_booking_id;exit;

		$lastBookingDetail = $this->mymodel->fetch($sql_last_booking_id, true);

        if($lastBookingDetail != null){
          $last_booking_id = base64_decode($lastBookingDetail->bookingId);
          	
          $last_booking_id_2 = substr($last_booking_id,6);
          $last_booking_id_2++;
        }else{
          $last_booking_id_2 = 1; 
        }
        
        return base64_encode("ELCBId".$last_booking_id_2);
	}

	public function manageStudentSchedule_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		}else{
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['insId'] = $this->post('insId');

			$userData['bookingStatus'] = $this->post('bookingStatus');
			$userData['classId'] = $this->post('classId');
			$userData['classDate'] = $this->post('classDate');
			$userData['classTime'] = $this->post('classTime');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('insId', 'insId', 'trim|required');
		$this->form_validation->set_rules('bookingStatus', 'bookingStatus', 'trim|required');
		$this->form_validation->set_rules('classId', 'classId', 'trim|required');
		$this->form_validation->set_rules('classDate', 'classDate', 'trim|required');
		$this->form_validation->set_rules('classTime', 'classTime', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('insId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('insId'))
				], 400);
			}

			if(form_error('bookingStatus')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('bookingStatus'))
				], 400);
			}

			if(form_error('classId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('classId'))
				], 400);
			}

			if(form_error('classDate')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('classDate'))
				], 400);
			}

			if(form_error('classTime')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('classTime'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
                 $studentId = $userData['userid'];
                 $courseId = $userData['courseId'];
                 $courseLvl = $userData['courseLvl'];
                 $insId = $userData['insId'];

                 $bookingStatus = $userData['bookingStatus'] == 'true'?1:0;
                 $classId = $userData['classId'] == 'null'?null:$userData['classId'];
                 $classDate = date('Y-m-d',strtotime($userData['classDate']));
                 $classTime = $userData['classTime'];

                 //Check if user perchased this course
                 $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

                 //echo $sql_check_purchse_status;exit;

                 $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

                 if($purchaseCount>0){
 
	              	 $classTimeArr = explode('-', $classTime);

	              	 $sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$insId."'";
			
					 $scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

					 //print_r($scheduleTime);exit;
					 $date = date('Y-m-d');

					 $allowedDayArr = explode(',', $scheduleTime->weekdays);
					 $current_day = date('l', strtotime($classDate));

					 if(in_array($current_day,$allowedDayArr)){

						 $sql_enrolled_courses = "SELECT SUM(DISTINCT chp.totalHours) as totalHours FROM courses c LEFT JOIN student_purchased_courses spc ON (c.courseId=spc.courseId) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$studentId."' GROUP BY spc.courseLvl ORDER BY spc.courseLvl";  

						 //Feching Enrolled Course List 
					 	 $totalHours = $this->mymodel->fetch($sql_enrolled_courses, true)->totalHours;
				    
					     //Calculate student bookes season
					     $sql_student_booked_season = "SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.studentId = '".$studentId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.instructorId='".$insId."' ORDER BY sbc.courseId";  

					    //echo $sql_student_booked_season;exit; 

					    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);
					    $totalBookedSeason = 0;

					    foreach ($diffTime as $key => $time) {
					    	$totalBookedSeason +=  round($time->timeDiff);
					    }
				        
				        //Count total session for current selected instructor
				        $fromTimeIns = strtotime($classTimeArr[0]);
						$toTimeIns = strtotime($classTimeArr[1]);

				        $getTotalSeason = abs($toTimeIns - $fromTimeIns) / 3600;

				        if($bookingStatus && $classId == null){

				    	   if(($totalHours - ($getTotalSeason+$totalBookedSeason))>=-1){

				    		  $fromTime = date('H:i',strtotime($classTimeArr[0]));
							  $toTime = date('H:i',strtotime($classTimeArr[1]));

							  $bookingId = $this->create_Class_Booking_Id();

							  $scheduleData = array(
										     	 'bookingId'=> $bookingId,
												 'studentId' => $studentId,
												 'courseId' => $courseId,
												 'courseLvl' => $courseLvl,
												 'instructorId' => $insId,
												 'classDate' => $classDate,
												 'fromTime' =>$fromTime,
												 'toTime' => $toTime,
												 'created'=>date('Y-m-d H:i:s')
											  );
							  
							  //print_r($scheduleData);exit;

					 	   	  //Check if schedule date is already exist under current instructor
					 	   	  $sql_check_unique_class_count = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.instructorId = '".$insId."' AND sbc.classDate='".$classDate."' AND sbc.fromTime='".$fromTime."' AND sbc.toTime='".$toTime."'";

					 	   	  //echo $sql_check_unique_class_count;exit;

				        	  $countClass = $this->db->query($sql_check_unique_class_count)->num_rows();

				          	  if($countClass == 0){
					 	   	     //Saving sesaon data into db
					 	   	     if(!$this->mymodel->save('student_booked_classes', $scheduleData)){
					 	   	  	   $sessionData['totalHours'] = (int) $totalHours;
					        	   $sessionData['totalBookedSeason'] = $totalBookedSeason;
					        	   $sessionData['leftSeason'] = $totalBookedSeason;

							       $this->response([
										'status' =>"0",
										'sessionData'=>$sessionData,
										'classDate'=>$classDate,
										'classTime'=>$classTime,
										'error' => "Something went wrong, Please try again."
								   ], 400);	
								 }else{
							       $sessionData['totalHours'] = (int) $totalHours;
					        	   $sessionData['totalBookedSeason'] = ($getTotalSeason+$totalBookedSeason);
					        	   $sessionData['leftSeason'] = $totalHours - ($getTotalSeason+$totalBookedSeason);

					        	   $bookedClassId = $this->db->insert_id();

							   	   $array = array('status'=>'1','sessionData'=>$sessionData,'classId'=>$bookedClassId,'classDate'=>$classDate,'classTime'=>$classTime,'message'=>'Class has been booked successfully!'); 	
		   	  					   $this->response($array, 200);  
								 }
							  }else{
							  	 $sessionData['totalHours'] = (int) $totalHours;
						         $sessionData['totalBookedSeason'] = $totalBookedSeason;
						         $sessionData['leftSeason'] = $totalBookedSeason;

							  		$uniqueDateErrTxt = date('jS F, Y',strtotime($classDate))." from ".$classTimeArr[0]." to ".$classTimeArr[1]." is booked by someone else!";

							  		$this->response([
										'status' =>"0",
										'classDate'=>$classDate,
										'classTime'=>$classTime,
										'error' => $uniqueDateErrTxt
								    ], 400);
							  		exit;	
							  } 
						   }else{
						   	  $sessionData['totalHours'] = (int) $totalHours;
						      $sessionData['totalBookedSeason'] = $totalBookedSeason;
						      $sessionData['leftSeason'] = $totalBookedSeason;

							  $this->response([
								'status' =>"0",
								'sessionData'=>$sessionData,
								'classDate'=>$classDate,
								'classTime'=>$classTime,
								'error' => "You have exausted all your sessions,Please remove a session to book another."
							  ], 400);	
						   }	  
					    
					    }else{
				 	   	    $where_del_booked_class = array('classId' => $classId);

							//Delete schedule time data into db
						    if(!$this->mymodel->delete('student_booked_classes', $where_del_booked_class)){
						    	
						    	$sessionData['totalHours'] = (int) $totalHours;
						       	$sessionData['totalBookedSeason'] = $totalBookedSeason;
						        $sessionData['leftSeason'] = $totalBookedSeason;

				           		$this->response([
									'status' =>"0",
									'sessionData'=>$sessionData,
									'classDate'=>$classDate,
									'classTime'=>$classTime,
									'error' => "Something went wrong, Please try again."
								], 400);	

							}else{
								$sessionData['totalHours'] = (int) $totalHours;
						        $sessionData['totalBookedSeason'] = ($totalBookedSeason-$getTotalSeason);
						        $sessionData['leftSeason'] = $totalHours - ($totalBookedSeason-$getTotalSeason);

							  	$array = array('status'=>'1','sessionData'=>$sessionData,'classDate'=>$classDate,'classTime'=>$classTime,'message'=>'Class has been removed successfully!!'); 	
		           	  			
		           	  			$this->response($array, 200);  
							}
				 	    }  
				 	}else{
				 		$this->response([
							'status' =>"0",
							'error' => $current_day." isn't available for booking."
					    ], 400);	
				 	}   
                }else{
			   	   $this->response([
						'status' =>"0",
						'error' => "You aren't elligible to book schedule!"
				   ], 400);	
			    } 
		    } 	
	    }
	}

	public function fetchInstructorSchedule_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['insId'] = $this->post('insId');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('insId', 'insId', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('insId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('insId'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
                $userId = $userData['userid'];
                
                $courseId = $userData['courseId'];
                $courseLvl = $userData['courseLvl'];
                $instructorId = $userData['insId'];
               
                $fetchType = "current";

                //Check if user perchased this course
                $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$userId'";

                //echo $sql_check_purchse_status;exit;

                $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();
                 
                if($purchaseCount>0){

	                $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."'";

					$courseDetail = $this->mymodel->fetch($sql_course_details, true);

					$sql_ins_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName FROM users u WHERE u.userId='".$instructorId."' AND u.userType='2'";

					$instructorDetail = $this->mymodel->fetch($sql_ins_details, true);

					$sql_all_student_booked_class = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE sbc.instructorId = '".$instructorId."'";

					//echo $sql_all_student_booked_class;exit;
					
					$bookedClassDetail = $this->mymodel->fetch($sql_all_student_booked_class, false);

					if(!empty($bookedClassDetail)){

						foreach ($bookedClassDetail as $key => $class) {
						   $bookedClassArr[$key] = $class->classDate;
						}
					}else{
					   $bookedClassDetail = array();
					}	

					$sql_current_student_booked_class = "SELECT sbc.classId,sbc.classDate,sbc.bookingId FROM student_booked_classes sbc WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' AND sbc.instructorId = '".$instructorId."'";

					//echo $sql_current_student_booked_class;exit;
				     
				 	$currentBookedClassDetail = $this->mymodel->fetch($sql_current_student_booked_class, false);

					$currentBookedClassArr = [];
					$currentBookingIdArr = [];
					$currentClassIdArr = [];
				     
				 	if(!empty($currentBookedClassDetail)){
						foreach ($currentBookedClassDetail as $key => $class) {
							$currentBookedClassArr[$key] = $class->classDate;
							$currentBookingIdArr[$key] = $class->bookingId;
							$currentClassIdArr[$key] = $class->classId;
						}
					}else{
						$currentBookedClassArr = [];
						$currentBookingIdArr = [];
						$currentClassIdArr = [];
					}	
					
				 	$list=array();
				 	$scheduleBgColorCdArr = array('#44760f','#ff0000','#d816c7','#102ce9','#044f16','#950202','#6e0769','#723c03','#000000');
					
					if($fetchType == "current"){
						/*$current_date = date('Y-m-d');
						$day = date('d',strtotime('+1 days',strtotime($current_date)));
						$month = date('m');*/

						$sql_stu_last_booking_date = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE `studentId`='".$userId."' ORDER BY classDate ASC LIMIT 1";

				    	$lastBookedClassData = $this->mymodel->fetch($sql_stu_last_booking_date, true);

				    	$compare_date = date('Y-m-d');

						if(!empty($lastBookedClassData) && $lastBookedClassData->classDate < $compare_date){
							$last_date = $lastBookedClassData->classDate;
							$day = date('d',strtotime($last_date));
							$month = date('m',strtotime($last_date));
							$year = date('Y',strtotime($last_date));
						}else{
							$current_date = date('Y-m-d');
							$day = date('d',strtotime('+1 days',strtotime($current_date)));
							$month = date('m');
							$year = date('Y');
						}	

						$current_date = date('Y-m-d');
						$start_date = date('Y-m-d',strtotime('+1 days',strtotime($current_date)));
					}

					else if($fetchType == "next"){
						$day = date('d', strtotime('first day of +1 month'));
						$month = date('m', strtotime('first day of +1 month'));
						$year = date('Y');
					}

					else if($fetchType == "previous"){
						$day = date('d', strtotime('first day of -1 month'));
						$month = date('m', strtotime('first day of -1 month'));
						$year = date('Y');
					}
					
					$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";
					
					$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

					//print_r($scheduleTime);exit;

					$date = date('Y-m-d');

					$allowedDayArr = explode(',', $scheduleTime->weekdays);
					$fromTime = $scheduleTime->fromTime;
					$toTime = $scheduleTime->toTime;
					
					$index = 0;
				     
				 	for($m = $month; $m<=12; $m++){ 
				         
						$currentMonthDays = cal_days_in_month(CAL_GREGORIAN, $m, $year);

						/*echo "---".$currentMonthDays."<br>";
						echo $m."<br>";
						echo $day."<br>";*/

						for($d=$day; $d<=$currentMonthDays; $d++){

						    $time=strtotime($year.'-'.$m.'-'.$d);    
						    $current_day = date('l', $time);
						    $current_full_date = date('Y-m-d',$time);
						    //Shuffling color code array for random color
						    //shuffle($scheduleBgColorCdArr);

						    if (date('m', $time)==$m && in_array($current_day,$allowedDayArr)){      
						    	$list[$index]['id'] = $index;
						        $list[$index]['date']=date('Y-m-d', $time);
						        
						        //Customizing extended property
						        $list[$index]['course'] = $courseDetail->courseName;
						        $list[$index]['courseLvl'] = ucfirst($courseLvl);
						        $list[$index]['instructor'] = $instructorDetail->instructorName;
						        $list[$index]['classDate']=date('jS F, Y', $time);
						        $list[$index]['classTime'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
						        $list[$index]['fromTime']=date('H:i', strtotime($fromTime));
						        $list[$index]['toTime']=date('H:i', strtotime($toTime));
						     
						        if(!empty($bookedClassArr) && in_array($current_full_date,$bookedClassArr)){

									if(!empty($currentBookedClassArr) && in_array($current_full_date,$currentBookedClassArr)){
										$position = array_search($current_full_date, $currentBookedClassArr); 
										$bookingId = $currentBookingIdArr[$position];

										if($current_full_date>=$start_date){
										   $list[$index]['classId'] = $currentClassIdArr[$position];
										   $list[$index]['booking_status'] = 1;
										   $list[$index]['modify_permission'] = true;
										   $list[$index]['bookingId'] = $bookingId;
										}else{
										   $list[$index]['classId'] = null;	
									       $list[$index]['booking_status'] = 1;	
									       $list[$index]['modify_permission'] = false;
										}	
									}else{
									   $list[$index]['classId'] = null;	
									   $list[$index]['booking_status'] = 1;	
									   $list[$index]['modify_permission'] = false;
									}	
									
							   }else{
							     if($current_full_date>=$start_date){	
								      $list[$index]['classId'] = null;
									  $list[$index]['booking_status'] = 0;
									  $list[$index]['modify_permission'] = true;
									}else{
									  $list[$index]['classId'] = null;	
									  $list[$index]['booking_status'] = 1;	
									  $list[$index]['modify_permission'] = false;
									}  
							  }	

							  $index++;
						 }

						 if($d == $currentMonthDays){
						    $day = date('d', strtotime('first day of +1 month',$m+1));
						 }    
					  }
				    }	
	                
	                $array = array('status'=>'1','message'=>'Instructor schedule is fetched successfully!','scheduleData'=>$list); 	
	           	    $this->response($array, 200);   
	           	}else{
			   	   $this->response([
						'status' =>"0",
						'error' => "You aren't elligible to view this instructor's schedule!"
				   ], 400);	
			    }   
		    } 	
		}
	}

	public function changeCourseInstructor_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['insId'] = $this->post('insId');
			$userData['reasonId'] = $this->post('reasonId');
			$userData['descriptions'] = $this->post('descriptions');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('insId', 'insId', 'trim|required');
		$this->form_validation->set_rules('reasonId', 'Reason ID', 'trim|required');
		$this->form_validation->set_rules('descriptions', 'Descriptions', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('insId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('insId'))
				], 400);
			}

			if(form_error('reasonId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('reasonId'))
				], 400);
			}

			if(form_error('descriptions')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('descriptions'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
                $studentId = $userData['userid'];
                $courseId = $userData['courseId'];
                $courseLvl = $userData['courseLvl'];
                $instructorId = $userData['insId'];
                $reasonId = $userData['reasonId'];
                $descriptions = $userData['descriptions'];

                //Check if user perchased this course
                $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

                //echo $sql_check_purchse_status;exit;

                $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

                //Check if user perchased this course
                $sql_check_booked_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId'";

                //echo $sql_check_booked_class;exit;

                $checkBookClass = $this->db->query($sql_check_booked_class)->num_rows();

                if($purchaseCount>0 && $checkBookClass>0){

	                //Saving query data into db
					$queryData = array(
			            'studentId'=>$studentId,
			            'courseId'=>$courseId,
			            'courseLvl'=>$courseLvl,
			            'instructorId'=>$instructorId,
			            'reasonId'=>$reasonId,
			            'descriptions'=>$descriptions,
			            'created'=> date('Y-m-d H:i:s')
					);

					if (!$this->mymodel->save('change_instructor', $queryData)){
						 $this->response([
							'status' =>"0",
							'error' => "Something went wrong, Please try again."
					     ], 400);	
					}else{
						$last_query_id = $this->db->insert_id();

						$where_del_session_data = array(
													'studentId' => $studentId,
						                            'courseId' => $courseId,
						                            'courseId' => $courseId,
						                            'instructorId' => $instructorId
							                      );

						if($this->mymodel->delete('student_booked_classes', $where_del_session_data)){
			                $array = array('status'=>'1','message'=>'Instructor is successfully reset.'); 	
	           	     		$this->response($array, 200);  	
						}else{
							$where_del_last_query = array('queryId'=>$last_query_id);
							$this->mymodel->delete('change_instructor', $where_del_last_query);
			                $this->response([
							 'status' =>"0",
							 'error' => "Something went wrong, Please try again."
					     ], 400);	
						}
					} 
				}else{
					$this->response([
						'status' =>"0",
						'error' => "You aren't elligible to change current instructor!"
				    ], 400);
				}	
		    } 	
		}
	}

	public function manageInstructorReview_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseId'] = $this->post('courseId');
			$userData['courseLvl'] = $this->post('courseLvl');
			$userData['insId'] = $this->post('insId');
			$userData['reviewId'] = $this->post('reviewId');
			$userData['rating'] = $this->post('rating');
			$userData['feedback'] = $this->post('feedback');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseId', 'courseId', 'trim|required');
		$this->form_validation->set_rules('courseLvl', 'courseLvl', 'trim|required');
		$this->form_validation->set_rules('insId', 'insId', 'trim|required');
		$this->form_validation->set_rules('rating', 'Rating', 'trim|required');
		$this->form_validation->set_rules('feedback', 'Feedback', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseId'))
				], 400);
			}

			if(form_error('courseLvl')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseLvl'))
				], 400);
			}

			if(form_error('insId')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('insId'))
				], 400);
			}

			if(form_error('rating')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('rating'))
				], 400);
			}

			if(form_error('feedback')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('feedback'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
                $studentId = $userData['userid'];
                $courseId = $userData['courseId'];
                $courseLvl = $userData['courseLvl'];
                $instructorId = $userData['insId'];
               
                $reviewId = (int) $userData['reviewId'];
                $rating = $userData['rating'];
                $feedback = $userData['feedback'];

                //Check if user perchased this course
                $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

                //echo $sql_check_purchse_status;exit;

                $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

                //Check if user perchased this course
                $sql_check_booked_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId'";

                //echo $sql_check_booked_class;exit;

                $checkBookClass = $this->db->query($sql_check_booked_class)->num_rows();

                if($purchaseCount>0 && $checkBookClass>0){

	                //Saving query data into db
					$reviewData = array(
			            'studentId'=>$studentId,
			            'courseId'=>$courseId,
			            'courseLvl'=>$courseLvl,
			            'instructorId'=>$instructorId,
			            'rating'=>$rating,
			            'feedback'=>$feedback,
			            'created'=> date('Y-m-d H:i:s')
					);

					$reviewId = !empty($reviewId)?$reviewId:null;

					if(!empty($reviewId)){
			           $where_review_clause = array('reviewId' => $reviewId);
			           //Updating review data into db	
			           if(!$this->mymodel->update($reviewData,'course_review',$where_review_clause)){
			              $this->response([
								'status' =>"0",
								'error' => "Something went wrong, Please try again."
						  ], 400); 
			           }else{
			           	  $array = array('status'=>'1','message'=>'Review is successfully updated.'); 	
	           	     	  $this->response($array, 200);  	
			           }
					}else{
					   $reviewData['status'] = '0';
					   //Inserting review data into db	
			           if(!$this->mymodel->save('course_review', $reviewData)){
			               $this->response([
								'status' =>"0",
								'error' => "Something went wrong, Please try again."
						   ], 400);   
			           }else{
			               $array = array('status'=>'1','message'=>'Review is successfully created.'); 	
	           	     	   $this->response($array, 200);  	
			           }
					}
				}else{
					$this->response([
						'status' =>"0",
						'error' => "You aren't elligible to add review to this current course!"
				    ], 400);
				}	
		    } 	
		}
	}

	public function fetchPurchaseHistory_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
               
               $userId = $userData['userid'];

			   $sql_purchased_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,spc.created,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId";  			  
			   //echo $sql_purchased_courses;exit;

			   $responseArr = $this->mymodel->fetch($sql_purchased_courses, false);

			   foreach($responseArr as $index => $course){
			  	 $responseArr[$index]->courseName = html_entity_decode($course->courseName);
			  	 $responseArr[$index]->descriptions = html_entity_decode($course->descriptions);
			  	 if(!empty($course->course_image)){
					$responseArr[$index]->course_image = base_url('uploads/courses/'.$course->course_image);
				 }else {
				    $responseArr[$index]->course_image = base_url().'uploads/noimg.png';
				 }

				 if(!empty($course->level_image)){
					$responseArr[$index]->level_image = base_url('uploads/level/'.$course->level_image);
				 }else {
				    $responseArr[$index]->level_image = base_url().'uploads/noimg.png';
				 }
			   }		

               if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Purchase history is fetched successfully!','purchaseHistory'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	   }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Course Found!"
			     ], 400);
		   	   } 
		    } 	
		}
	}

	public function fetchChangeInstructorReason_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}
		}else {
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
			   $sql_reason_list = "SELECT r.* FROM reason r WHERE r.status = '1' ORDER BY r.reasonId ASC";  
			  
			   //echo $sql_reason_list;exit;

			   $responseArr = $this->mymodel->fetch($sql_reason_list, false);

               if(count($responseArr)>0){
		   	     $array = array('status'=>'1','message'=>'Reason list is fetched successfully!','reasonlist'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	   }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Reason Data Found!"
			     ], 400);
		   	   } 
		    } 	
		}
	}

	public function suggestion_post(){

        $json = file_get_contents('php://input');
        $obj = json_decode($json,true);
        if(is_array($obj)) {
            $_POST = (array) $obj;
            $userData = $_POST;

        } else {
            $userData['userid'] = $this->post('userid');
            $userData['keyword'] = $this->post('keyword');
        }

        $this->form_validation->set_rules('userid', 'userid', 'trim|required');
        $this->form_validation->set_rules('keyword', 'keyword', 'trim|required');

        if ($this->form_validation->run() === false) {

            if(form_error('userid')) {
                $this->response([
                    'status' => "0",
                    'error' => strip_tags(form_error('userid'))
                ], 400);
            }

            if(form_error('keyword')) {
                $this->response([
                    'status' => "0",
                    'error' => strip_tags(form_error('keyword'))
                ], 400);
            }
        }else {
           $where_check_user = "userId = '".$userData['userid']."'";
           
           if ($this->mymodel->count('users', $where_check_user) != 1) {                
               $this->response([
                    'status' =>"0",
                    'error' => "Invalid User ID"
               ], 400);         
           }else{

              $keyword = $userData['keyword'];

              //Fetching dashboard category data
              $fetch_subject_list = "SELECT s.subjectId,s.subjectName,s.image,Count(DISTINCT chp.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM subjects s LEFT JOIN chapters chp ON s.subjectId=chp.subjectId WHERE s.status='1' AND s.subjectName LIKE '$keyword%' GROUP BY s.subjectId ORDER BY s.created DESC";

              //echo $fetch_subject_list;exit;
              
              $subjectList = $this->mymodel->fetch($fetch_subject_list);
              
              if(count($subjectList)>0){
                 foreach($subjectList as $index => $subject){
                     $subjectList[$index]->subjectName = html_entity_decode($subject->subjectName);

                     if(!empty($subject->image)){
                        $subjectList[$index]->image = base_url('uploads/subject/'.$subject->image);
                     }else {
                        $subjectList[$index]->image = base_url().'uploads/noimg.png';
                     }
                  }
              }else{
              	 $subjectList = [];  
              }

              $sql_course_list = "SELECT c.*,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE c.status = '1' AND cl.status = '1' AND c.courseName LIKE '$keyword%' GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC";  
              
              //echo $sql_course_list;exit;

              $courseList = $this->mymodel->fetch($sql_course_list, false);
              
              if(count($courseList)>0){
                  foreach($courseList as $index => $course){
                     $courseList[$index]->courseName = html_entity_decode($course->courseName);
                     $courseList[$index]->descriptions = html_entity_decode($course->descriptions);

                     if(!empty($course->image)){
                        $courseList[$index]->image = base_url('uploads/courses/'.$course->image);
                     }else {
                        $courseList[$index]->image = base_url().'uploads/noimg.png';
                     }

                     if(!empty($course->level_image)){
                        $courseList[$index]->level_image = base_url('uploads/level/'.$course->level_image);
                     }else {
                        $courseList[$index]->level_image = base_url().'uploads/noimg.png';
                     }
                  }   
              }else{
              	 $courseList = [];
              } 

              $sql_fetch_instructor = "SELECT u.userId as instructorId,CONCAT(u.firstName,' ',u.lastName) as instructorName,u.email,COALESCE(u.ccName,'') as ccName,COALESCE(u.ccCode,'') as ccCode,u.descriptions,u.profilePic,u.status as user_active_status,COALESCE(AVG(cr.rating),'') as insAvgRating FROM student_purchased_courses spc LEFT JOIN course_instructors ins ON spc.courseId = ins.courseId LEFT JOIN course_review cr ON ins.instructorId = cr.instructorId LEFT JOIN users u ON ins.instructorId=u.userId WHERE u.firstName LIKE '$keyword%' OR u.lastName LIKE '$keyword%' AND u.userType = '2' AND u.status = '1' GROUP BY u.userId";

               //echo $sql_fetch_instructor;exit;

              //Feching Enrolled Course List 
              $instructorList = $this->mymodel->fetch($sql_fetch_instructor, false);
              
              if(count($instructorList)>0){
                  foreach($instructorList as $index => $instructor){
                     $instructorList[$index]->descriptions = html_entity_decode($instructor->descriptions);

                     if(!empty($instructor->profilePic)){
                        $pic = base_url('uploads/users/'.$instructor->profilePic);
                     }else {
                        $pic = base_url().'uploads/noimg.png';
                     }
                     $instructorList[$index]->profilePic = $pic;
                     $instructorList[$index]->booked_instructor_data = $instructorData;
                  }
              }else{
              	 $instructorList = [];  
              }

              if (!empty($subjectList) || !empty($courseList) || !empty($instructorList)) {
                $subjectList = $this->removeNull($subjectList);
                $courseList = $this->removeNull($courseList);
                $instructorList = $this->removeNull($instructorList);
                $this->response([
                    'status' => "1",
                    'subjectList' => $subjectList,
                    'courseList' => $courseList,
                    'instructorList' => $instructorList,
                ], 200);
              } else {
                $this->response(array(
                    'status' => "0",
                    'error' => 'No suggestion were found.'
                ), 400);
              }
           }    
        }
    }

	/*public function fetchcoursedetails_post(){

		$json = file_get_contents('php://input');
		$obj = json_decode($json,true);
		if(is_array($obj)) {
			$_POST = (array) $obj;
			$userData = $_POST;

		} else {
			$userData['userid'] = $this->post('userid');
			$userData['courseid'] = $this->post('courseid');
		}

		$this->form_validation->set_rules('userid', 'userid', 'trim|required');
		$this->form_validation->set_rules('courseid', 'courseid', 'trim|required');

		if ($this->form_validation->run() === false) {

			if(form_error('userid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('userid'))
				], 400);
			}

			if(form_error('courseid')) {
				$this->response([
					'status' => "0",
					'error' => strip_tags(form_error('courseid'))
				], 400);
			}
		}else {
		   //$count_user_sql = "SELECT * FROM users u WHERE u.userId = '".$userData['userid']."'";
		   //$count_user = $this->db->query($count_user_sql)->num_rows();
		   
		   $where_check_user = "userId = '".$userData['userid']."'";	

		   if ($this->mymodel->count('users', $where_check_user) != 1) {				
			   $this->response([
					'status' =>"0",
					'error' => "Invalid User ID"
			   ], 400);			
		   }else{
			  //Fetching courses data as per category
		   	  $fetch_crs_detail_query = "SELECT c.courseId,c.courseName,c.level,c.image,c.updated,s.subjectName FROM courses c LEFT JOIN subjects s ON c.subjectId = s.subjectId WHERE c.subjectId='".$userData['categoryid']."' ORDER BY c.courseId DESC";

		   	  echo $fetch_crs_per_cat_query;exit;

		   	  $responseArr['courseDetails'] = $this->mymodel->fetch($fetch_crs_detail_query);

		   	  if(count($responseArr['courseList'])>0){
		   	     $array = array('status'=>'1','message'=>'course detail is fetched successfully!','courseList'=>$responseArr); 	
           	     $this->response($array, 200);  			
		   	  }else{
		   	  	 $this->response([
					'status' =>"0",
					'error' => "No Data Found!"
			     ], 200);
		   	  }
		   } 	
		}
	}*/

	public function generate_otp($length)
	{
		$characters = '123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) 
		{
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function arrcheck($array)
	{
		array_walk_recursive($array, function (&$array, $key){
			$array = (null === $array)? '' : $array;
		}); 
		return $array;
	}

	public function hash($string) 
	{
		return hash('sha512', $string . config_item('encryption_key'));
	}

	public function enc_password($password)
	{
		$encrypted_password = password_hash($password, PASSWORD_DEFAULT);
		return $encrypted_password;
	}

}
