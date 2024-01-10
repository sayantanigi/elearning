<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Adding namespace for phpmailer package
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Login extends My_Controller
{

	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('Commonmodel');
    	$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library("pagination"); 
		$this->config->load('mail_config');         
    }

    public function display_mail_template(){
   	$this->load->view('email_template/user_reset_password');
    }

    public function send_mail($paramArr){
       //Create an instance; passing `true` enables exceptions
	     $mail = new PHPMailer(true);

		  //Collecting necessary variables to configure send mail
	     $fromName  = $paramArr['sender_name'];
	     $fromEmail = $paramArr['sender_email'];
	     $toEmail   = $paramArr['receiver_email'];
	     $toName    = $paramArr['receiver_name'];
	     $ccEmail   = $paramArr['cc_email'];
	     $email_subject = $paramArr['email_subject'];
	     $body = $paramArr['email_template'];

	     $MAIL_HOST = $this->config->item('MAIL_HOST');
	     $MAIL_PORT = $this->config->item('MAIL_PORT');

	     $MAIL_SMTPSECURE = $this->config->item('MAIL_SMTPSECURE');
	     $MAIL_SMTPAUTH = $this->config->item('MAIL_SMTPAUTH');

	     $MAIL_USERNAME = $this->config->item('MAIL_USERNAME');
	     $MAIL_PASSWORD = $this->config->item('MAIL_PASSWORD');

		  /*$headers = 'MIME-Version: 1.0' . "\r\n"; 
		  $headers .= "Content-Type: text/html;  charset=UTF-8\r\n"; 
		  $headers .= "From: ".$fromName." <".$fromEmail.">"; 
	     
	     //Sending mail
		  mail($toEmail,$email_subject,$body,$headers);
	     
	     //Sending cc mail to admin 
		  mail($ccEmail,$email_subject,$body,$headers);*/
			
		  try {
		     $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
	        //$mail->SMTPDebug = 1;                         //debugging: 1 = errors and messages, 2 = messages only
	        $mail->Host = $MAIL_HOST;                 //Sets the SMTP hosts of your Email hosting, this for Godaddy
	        $mail->Port = $MAIL_PORT;                            //Sets the default SMTP server port

	        $mail->SMTPSecure = $MAIL_SMTPSECURE;                      //Sets connection prefix. Options are "", "ssl" or "tls"                  
	        //Whether to use SMTP authentication
	        $mail->SMTPAuth = $MAIL_SMTPAUTH;
	        //Sets SMTP authentication. Utilizes the Username and Password variables
	        $mail->Username = $MAIL_USERNAME; 	  				  //Sets SMTP username
	        $mail->Password = $MAIL_PASSWORD;           	  //Sets SMTP password //"PVIj3s_3rT(D"
	        $mail->From = $fromEmail;                       //Sets the From email address for the message
	        $mail->FromName = $fromName;                    //Sets the From name of the message
	        $mail->AddAddress($toEmail, $toName);           //Adds a "To" address

	        /*if(!empty($ccEmail)){
	       		 $mail->addCC($ccEmail,'Admin');                 //Add cc
	        }*/

	        $mail->WordWrap = 50;                           //Sets word wrapping on the body of the message to a given number of characters
	        $mail->IsHTML(true);                            //Sets message type to HTML 
	        $mail->Subject = $email_subject;                //Sets the Subject of the message
	        $mail->Body = $body;       

		    $mail->send();
		    //echo 'Message has been sent';
		  } catch (Exception $e) {
			 //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
		  }
    } 

    public function logout()
	{
		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('email');
		$this->session->unset_userdata('userType');
		$this->session->sess_destroy();
		redirect(base_url(),'refresh');
	}
    
	public function dologin()
	{
		
		$this->form_validation->set_rules('email', 'Email','trim|required');
		$this->form_validation->set_rules('password', 'Password','trim|required');

		if ($this->form_validation->run() == false) 
		{			
			echo validation_errors();
		} else {

			$email = $this->input->post('email');
			$password = $this->input->post('password');
			
			$where = "email = '".$email."'";

			if ($this->mymodel->count('users', $where) != 1) 
			{
				echo "Email";
			}else{

				$user = $this->mymodel->get_by('users', true, $where);
				if(password_verify($password, $user->password) == 0) 
				{
					echo "Password";
				}elseif ($user->status=='0') 
				{
					echo "Inactive";
				}else{

					if($user->userType=='1')
					{
						$value = array(
							'userId'=>$user->userId,
							'email'=>$user->email,
							'student' =>$user->userType,
						);

					}else{
						$value = array(
							'userId'=>$user->userId,
							'email'=>$user->email,
							'instructor' =>$user->userType,
						);
					}					

					$this->session->set_userdata($value);
					echo "Yes";
				}

			}	

		}
	}

	function accept() 
	{
		if ($this->input->post('accept'))
		{
			return TRUE;
		}
		else
		{
			$error = 'Please read and accept our terms and conditions.';
			$this->form_validation->set_message('accept', $error);
			return FALSE;
		}
	}

	public function doreg()
	{
		$this->form_validation->set_rules('firstName', 'First Name','trim|required');
		$this->form_validation->set_rules('lastName', 'Last Name','trim|required');
		$this->form_validation->set_rules('regEmail', 'Email','trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('userType', 'User type','trim|required');
		$this->form_validation->set_rules('regPassword', 'Password','trim|required|min_length[6]');
		$this->form_validation->set_rules('regConPassword', 'Re-Enter Password', 'required|min_length[6]|matches[regPassword]');
		$this->form_validation->set_rules('accept','tos','trim|required|callback_accept');
		$this->form_validation->set_message('min_length', '%s: the minimum of characters is %s.');
		$this->form_validation->set_message('is_unique', 'The %s is already taken.');

		if ($this->form_validation->run() == false) 
		{	
		    $msg = '';		 
		    if (form_error('firstName')) {
				$msg .= strip_tags(form_error('firstName'));
			}
			if (form_error('lastName')) {
				$msg .= strip_tags(form_error('lastName'));
			}
			if (form_error('regEmail')) {
				$msg .= strip_tags(form_error('regEmail'));
			}
			if (form_error('userType')) {
				$msg .= strip_tags(form_error('userType'));
			}
			if (form_error('regPassword')) {
				$msg .= strip_tags(form_error('regPassword'));
			}
			if (form_error('regConPassword')) {
				$msg .= strip_tags(form_error('regConPassword'));
			}
			if (form_error('accept')) {
				$msg .= strip_tags(form_error('accept'));
			}
			$formErrorArr = array_filter(explode('.', $msg));
			echo json_encode(array('check'=>'form_error','errors'=>$formErrorArr));
			//echo validation_errors();
		} else {
			$userdata = array(
				'firstName' => $this->input->post('firstName'),
				'lastName' => $this->input->post('lastName'),
				'email' => $this->input->post('regEmail'),
				'password' => $this->enc_password($this->input->post('regPassword')),
				'userType' => $this->input->post('userType'),
				'approve_status' => '0',
				'created' => date("Y-m-d H:i:s"),
			);

			//print_r($userdata);exit;
			
			if($this->mymodel->insert("users", $userdata))
			{
				$insertId = $this->db->insert_id();
				//Setting up required session data for user
				$userSessionArr = array('userId'=>$insertId,'email'=>$this->input->post('regEmail'));

				if($userdata['userType'] == 1){
					$userSessionArr['student'] = $this->input->post('userType');
				}else{
					$userSessionArr['instructor'] = $this->input->post('userType');
				}
							
				$this->session->set_userdata($userSessionArr);

				//Send mail code
				$ADMIN_NAME = $this->config->item('ADMIN_NAME');
			   $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
			   $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		 		$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		 		$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		 		$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

				$data['title'] = 'Notify user about successfull signup';

				$userName = $userdata['firstName']." ".$userdata['lastName'];

				if($userdata['userType'] == '1'){
					$userType = 'student';
				}else{
					$userType = 'instructor';
				}
                
            $swap_var['user_name'] = $userName; 
            $swap_var['user_first_name'] = $userdata['firstName']; 
			   $swap_var['user_email'] = $userdata['email'];
			   $swap_var['userType'] = $userType;
				$swap_var['dashboard_url'] = base_url();
				$swap_var['business_address'] = $BUSINESS_ADDRESS;
				$swap_var['business_phone'] = $BUSINESS_PHONE;
				$swap_var['business_email'] = $BUSINESS_EMAIL;

				$tepmlateBody = $this->load->view('email_template/user_signup_notify',$data,true);

				//echo $tepmlateBody."<br>";

		        foreach (array_keys($swap_var) as $key){
		          if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
		            $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
		          }
		        }

		        $emailParamArr['sender_name'] = $ADMIN_NAME;
		        $emailParamArr['sender_email'] = $ADMIN_MAIL;
		        $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
		        $emailParamArr['receiver_name'] = $userName;
		        $emailParamArr['receiver_email'] = $userdata['email'];
		        $emailParamArr['email_subject'] = 'Notify user about successfully signup';
		        $emailParamArr['email_template'] = $tepmlateBody;

		        //Send mail to admin when student request for changing instructor
		        $this->send_mail($emailParamArr);

				echo json_encode(array('check'=>'success','msg'=>'You are successfully registered','userId'=>$insertId,'userType'=>$userdata['userType']));
			}else{
				echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again'));
			}

		}
	}

	public function forgot()
	{
		$data['title'] = "Find Your Account";
		$this->load->view('header', $data);
		$this->load->view('forgot');
		$this->load->view('footer');		
	}

	public function postForgetPassword(){

		$email = $this->input->post('email');

		$where = "email = '".$email."'";

		if ($this->mymodel->count('users', $where) != 1) 
		{
			echo json_encode(array('check'=>'failure','msg'=>"This email isn't register with us, please provide a valid email"));
			exit;
		}else{
         $user = $this->mymodel->get_by('users', true, $where);

         /*if ($user->status=='0') {
			   echo json_encode(array('check'=>'failure','msg'=>"Your status is inactive, please contact the admin for further help"));
			   exit;
			}*/

         //Update user auth token
         $auth_token = md5("user_forget_password_".$user->userId.time());

         $authData = array('auth_token' => $auth_token); 

         if (!$this->mymodel->update($authData,'users',$where)){
         	echo json_encode(array('check'=>'failure','msg'=>"Something went wrong! Please try again"));
			   exit;
         }else{
         	$user_auth_params = array(
               'email' => $user->email,
               'auth_token' => $auth_token,
               'action' => 'set_forget_password'   
         	);

         	$encrypted_params = urlencode(base64_encode(json_encode($user_auth_params)));

         	$user_auth_url = base_url('user-reset-password/'.$encrypted_params);

         	//Send mail code
				$ADMIN_NAME = $this->config->item('ADMIN_NAME');
			   $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
			   $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		 		$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		 		$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		 		$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

				$data['title'] = 'User reset password email';

				$userName = $user->firstName." ".$user->lastName;

				if($user->userType == '1'){
					$userType = 'student';
				}else{
					$userType = 'instructor';
				}
		          
		      $swap_var['user_name'] = $userName; 
		      $swap_var['user_first_name'] = $user->firstName; 
			   $swap_var['user_email'] = $user->email;
			   $swap_var['userType'] = $userType;
				$swap_var['reset_password_url'] = $user_auth_url;
				$swap_var['business_address'] = $BUSINESS_ADDRESS;
				$swap_var['business_phone'] = $BUSINESS_PHONE;
				$swap_var['business_email'] = $BUSINESS_EMAIL;

				$tepmlateBody = $this->load->view('email_template/user_reset_password',$data,true);

		      foreach (array_keys($swap_var) as $key){
		       if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
		         $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
		       }
		      }

		      //echo $tepmlateBody."<br>";exit;

		      $emailParamArr['sender_name'] = $ADMIN_NAME;
		      $emailParamArr['sender_email'] = $ADMIN_MAIL;
		      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
		      $emailParamArr['receiver_name'] = $userName;
		      $emailParamArr['receiver_email'] = $user->email;
		      $emailParamArr['email_subject'] = 'User reset password email';
		      $emailParamArr['email_template'] = $tepmlateBody;

		      echo json_encode(array('check'=>'success','msg'=>'A reset password link is sent to you email'));

		      //Send mail to admin when student request for changing instructor
		      $this->send_mail($emailParamArr);
         } 
		}
	}

	public function resetUserPassword($encrypted_params){
		$user_auth_params = json_decode(base64_decode(urldecode($encrypted_params)));
      
      /*print"<pre>";
		print_r($user_auth_params);
		print"<pre>";
		exit;*/

		$email = $user_auth_params->email;
		$auth_token = $user_auth_params->auth_token;

		$data['title'] = "User Reset Password";

		$where = "email = '".$email."'";
		$password_reset_link = base_url('forgot-password');

		if ($this->mymodel->count('users', $where) != 1) 
		{

			$data['user_auth_err_msg'] =  '<div class="alert alert-danger" role="alert">
													  This link is invalid! Please get your password reset link <a href="'.$password_reset_link.'" class="alert-link">here</a>.
													</div>'; 
			
		}else{
			$user = $this->mymodel->get_by('users', true, $where);

			if($user->auth_token != $auth_token){
				$data['user_auth_err_msg'] =  '<div class="alert alert-danger" role="alert">
														  This link is expired! Please get your password reset link <a href="'.$password_reset_link.'" class="alert-link">here</a>.
														</div>'; 
			}else{
            
            $data['user_auth_err_msg'] = null;
            $data['user_email'] = $email;
            
			}
		}

		$this->load->view('header', $data);
		$this->load->view('reset_password');
		$this->load->view('footer');		
	}

	public function postResetPassword(){

		$email = $this->input->post('user_email');

		$new_password = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');

		if($new_password != $confirm_password){
			echo json_encode(array('check'=>'failure','msg'=>"Password & confirm password doesn't match"));
		}else{
         $where = "email = '".$email."'";

			if ($this->mymodel->count('users', $where) != 1) 
			{
				echo json_encode(array('check'=>'failure','msg'=>"This email isn't register with us, please provide a valid email"));
			}else{
	         $user = $this->mymodel->get_by('users', true, $where);
	         
	         $passData = array(
								   'password' => $this->enc_password($this->input->post('new_password')),
					 		  	); 

	         if (!$this->mymodel->update($passData,'users',$where)){
	         	echo json_encode(array('check'=>'failure','msg'=>"Something went wrong! Please try again"));
	         }else{

	         	//Update user auth token
		         $auth_token = md5("user_forget_password_".$user->userId.time());

		         $authData = array(
									  'auth_token' => $auth_token
					 		  	   ); 
          
		         $this->mymodel->update($authData,'users',$where);

	            echo json_encode(array('check'=>'success','msg'=>'Your password reset is successfully completed'));
	         }
			}
		}
	}
}
