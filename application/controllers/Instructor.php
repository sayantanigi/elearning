<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Adding namespace for twillo package
use Twilio\Rest\Client;
//Adding namespace for phpmailer package
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Instructor extends MY_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model('Commonmodel');
		$this->load->model('Authmodel');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library("pagination");
		$this->instructorLoggedIn();	
		$this->checkProfileProgress();
		$this->config->load('mail_config');
	}

	public function testtwiloSms() {
		$testText = 'Hello Neel, your one time otp is: '.rand(999,9999);
		$data = ['phone' => '+918617304367', 'text' => $testText];
		
		/*print"<pre>";
		print_r($this->sendSMS($data));
		print"</pre>";*/
	}

	public function sendSMS($data) {
       // Your Account SID and Auth Token from twilio.com/console
		$sid = 'AC9b13e6f8a8ef1e5b23f8252c27be4407';
		$token = 'f9e2fdfa367c97fb5b138dfeebd5e745';
		$client = new Client($sid, $token);
			
		// Use the client to do fun stuff like send text messages!
		return $client->messages->create(
			// the number you'd like to send the message to
			$data['phone'],
			array(
				// A Twilio phone number you purchased at twilio.com/console
				"from" => "+13343784847",
				// the body of the text message you'd like to send
				'body' => $data['text']
			)
		);
   }

   public function notify_user_via_mail(){
   	$userId=$this->session->userdata('userId');
      
      $data['title'] = 'User Welcome Mail';
   	//FETCHING COURSE'S CHAPTER DETAIL
		$sql_fetch_user_detail = "SELECT u.* FROM users u WHERE u.userId='".$userId."'";
		$userDetails = $this->mymodel->fetch($sql_fetch_user_detail, true);

		$swap_var['name'] = $userDetails->firstName." ".$userDetails->lastName;
		$swap_var['user_name'] = $userDetails->email;
		$swap_var['action_url'] = base_url('instructor/settings');
		$swap_var['login_url'] = base_url('instructor');
		$swap_var['help_url'] = base_url('become-a-instructor');
		$swap_var['support_email'] = 'support@elearning.com';

		$tepmlateBody = $this->load->view('email_template/user_welcome_mail',$data,true);

		//echo $tepmlateBody."<br>";

      foreach (array_keys($swap_var) as $key){
         if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
           $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
         }
      }

      $emailParamArr['sender_name'] = 'E-Learning';
      $emailParamArr['sender_email'] = 'theaimgcsm.dev@gmail.com';
      $emailParamArr['receiver_name'] = $swap_var['name'];
      $emailParamArr['receiver_email'] = 'igi223@goigi.in';
      $emailParamArr['cc_email'] = 'banerjeeneel.live@gmail.com';
      $emailParamArr['email_subject'] = 'User Welcome Mail';
      $emailParamArr['email_template'] = $tepmlateBody;

		//Sending mail using pre-defined method 
		$this->send_mail($emailParamArr);

   }

   public function display_mail_template(){
   	$this->load->view('email_template/student_fees_receipt');
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
	        //$mail->addCC($ccEmail,'Admin');                 //Add cc
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

   public function subject_list()
	{
		$data = array(
			'title' => 'Subject List',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);

		$userId = $this->session->userdata("userId");
		if($this->session->userdata('instructor') == 2){
			$userType = "instructor";
		}

		$where_fetch_clause = array('created_by'=>$userType,'creator_id'=>$userId);
		$data['list'] = $this->mymodel->get_by('subjects', false,$where_fetch_clause, 'subjectId');
		
		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/subject_list');
		$this->load->view('instructor/footer');
	}

	public function addSubjectView()
	{
		$data = array(
			'title' => 'Add New Subject',
			'page' => 'subjectlist',
			'subpage' => 'subjectadd'
		);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/subject_add');
		$this->load->view('instructor/footer');
	}

	public function createSubject()
	{
		if ($this->input->post('subjectName') && $_FILES['cover_photo']['name'] != '') 
		{
			$userId = $this->session->userdata("userId");
			if($this->session->userdata('instructor') == 2){
				$userType = "instructor";
			}

			$config['upload_path'] = './uploads/subject/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			$config['file_name'] = uniqid();
			
			$this->load->library('upload', $config);
			
			if( ! $this->upload->do_upload('cover_photo'))
			{
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
		
			} else {

				$data = $this->upload->data();

				$mydata = array(
					'subjectName' => $this->testInput($this->input->post('subjectName')),
					'summary' => $this->testInput($this->input->post('summary')),
					'objectives' =>$this->testInput($this->input->post('objectives')),
					'image' => $data['file_name'],
					'created'=> date('Y-m-d H:i:s'),	
					'created_by'=> $userType,
					'creator_id'=> $userId,
					'approve_status' => "forbidden"
				);

				if (!$this->mymodel->save('subjects', $mydata)) 
				{
					$msg = '["Some error occured, Please try again.", "error", "#DD6B55"]';
				} else {
					$msg = '["Subject added successfully", "success", "#A5DC86"]';
				}
			}

			$this->session->set_flashdata('msg', $msg);
		}

		redirect(base_url('instructor/subjects'),'refresh');
	}

	public function editSubject($subjectId = false)
	{
		if ($subjectId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Subject',
			'page' => 'subjectlist',
			'subpage' => 'editsubject',
			'subjectId' => $subjectId
		);

		$data['data'] = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/subject_edit');
		$this->load->view('instructor/footer');
	}

	public function updateSubject()
	{
		if ($this->input->post('subjectName') && $this->input->post('subjectId')) 
		{

			$where = array('subjectId' => $this->input->post('subjectId'));

			$userId = $this->session->userdata("userId");
			if($this->session->userdata('admin') == 1){
				$userType = "admin";
			}
			
			$oldSubjectPic = $this->input->post('oldSubjectPic');
			
			$mydata = array(
				'subjectName' => $this->testInput($this->input->post('subjectName')),
				'summary' => $this->testInput($this->input->post('summary')),
				'objectives' =>$this->testInput($this->input->post('objectives')),
			);

			if (!empty($_FILES['cover_photo']['name'])) {
			
				$config['upload_path'] = './uploads/subject/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				$config['file_name'] = uniqid();
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('cover_photo')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['image'] = $data['file_name'];
				}
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($mydata, 'subjects', $where)) {
					
					$msg = 'error';

				} else {

					if ($oldSubjectPic && !empty($_FILES['cover_photo']['name'])) {
						if (file_exists('./uploads/subject/'.$oldSubjectPic)) {
							@unlink('./uploads/subject/'.$oldSubjectPic);
						}
					}
					$msg = '["Subject updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('instructor/subjects'),'refresh');
	}

	public function viewSubject($subjectId){
		if ($subjectId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'View Subject',
			'page' => 'subjectlist',
			'subpage' => 'viewsubject',
			'subjectId' => $subjectId
		);

		$data['data'] = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/subject_view');
		$this->load->view('instructor/footer');
	}

	public function deleteSubject($subjectId = false)
	{
		if ($subjectId != false) {

			$where_delete_subject = array('subjectId' => $subjectId);
			$data = $this->mymodel->get_by('subjects', true, $where_delete_subject);

			if (!$this->mymodel->delete('subjects', $where_delete_subject)) {
				
				$msg = 'error';

			} else {

				//$this->mymodel->update(['subjectId'=>0], 'chapters', ['subjectId'=>$subjectId]);
				//$this->mymodel->update(['subjectId'=>0], 'tests', ['subjectId'=>$subjectId]);
            //Deleting all chapters under this subject
				$chapterList = $this->mymodel->get_by("chapters",false,$where_delete_subject,"chapterId",null);

				foreach ($chapterList as $key => $chapter) {
					$where_delete_chapter = array('chapterId' => $chapter->chapterId);

					if (@$chapter->chapterImage && file_exists('./uploads/chapter/'.@$chapter->chapterImage)) {
						@unlink('./uploads/chapter/'.@$chapter->chapterImage);
					}

					//Deleting all chapters under this subject
					$chapterCurriculumData = $this->mymodel->get_by("chapter_carriculum_media",false,$where_delete_chapter,"chapterId",null);

					foreach ($chapterCurriculumData as $key => $media) {
						$where_delete_curriculum = array('mediaId' => $media->mediaId);

                  if (@$media->mediaFile && file_exists('./uploads/chapter_curriculum/'.@$media->mediaFile)) {
							@unlink('./uploads/chapter_curriculum/'.@$media->mediaFile);
						}

						$this->mymodel->delete('chapter_carriculum_media', $where_delete_curriculum);
					}

					$this->mymodel->delete('chapters', $where_delete_chapter);
				}

				if (@$data->image && file_exists('./uploads/subject/'.@$data->image)) {
					@unlink('./uploads/subject/'.@$data->image);
				}

				$msg = '["Subject deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('instructor/subjects'),'refresh');
	}

	public function chapter_list($subjectId)
	{
		$data = array(
			'title' => 'Chapter List',
			'page' => 'subjectlist',
			'subpage' => 'chapterlist',
			'subjectId' => $subjectId
		);

		$userId = $this->session->userdata("userId");
		if($this->session->userdata('instructor') == 2){
			$userType = "instructor";
		}

		$where_fetch_clause = array('subjectId'=>$subjectId,'created_by'=>$userType,'creator_id'=>$userId);
		$data['list'] = $this->mymodel->get_by('chapters', false,$where_fetch_clause, 'chapterId');
		
		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/chapter_list');
		$this->load->view('instructor/footer');
	}

	public function addChapterView($subjectId)
	{
		$data = array(
			'title' => 'Add New Chapter',
			'page' => 'subjectlist',
			'subpage' => 'chapteradd',
			'subjectId' => $subjectId
		);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/chapter_add');
		$this->load->view('instructor/footer');
	}

	public function createChapter()
	{
		$subjectId = $this->input->post('subjectId');
		$userId = $this->session->userdata("userId");
		if($this->session->userdata('instructor') == 2){
			$userType = "instructor";
		}

		if ($this->input->post('chapterName') && $_FILES['cover_photo']['name'] != '') 
		{
			
			$config['upload_path'] = './uploads/chapter/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			$config['file_name'] = uniqid();
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('cover_photo'))
			{
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
		
			} else {

				$data = $this->upload->data();

				$mydata = array(
					'subjectId' => $this->testInput($this->input->post('subjectId')),
					'chapterNumber' => $this->testInput($this->input->post('chapterNumber')),
					'summary' => $this->testInput($this->input->post('summary')),
					'objectives' => $this->testInput($this->input->post('objectives')),
					'chapterName' => $this->testInput($this->input->post('chapterName')),
					'totalHours' => $this->testInput($this->input->post('totalHours')),
					'cost' => $this->testInput($this->input->post('cost')),
					'chapterImage' => $data['file_name'],
					'created'=> date('Y-m-d H:i:s'),	
					'created_by'=> $userType,
					'creator_id'=> $userId,
					'approve_status' => "forbidden"
				);

				if (!$this->mymodel->save('chapters', $mydata)) 
				{
					$msg = 'error';
				} else {
					$msg = '["Chapter added successfully", "success", "#A5DC86"]';
				}
			}

			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('instructor/chapters/'.$subjectId),'refresh');
	}

	public function editChapter($subjectId,$chapterId)
	{
		if ($chapterId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'Edit Chapter',
			'page' => 'subjectlist',
			'subpage' => 'editchapter'
		);
		
		$data['data']= $chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/chapter_edit');
		$this->load->view('instructor/footer');

	}

	public function updateChapter()
	{
		$chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $this->input->post('chapterId'));

		if ($this->input->post('chapterName') && $this->input->post('chapterId')) 
		{

			$where = array('chapterId' => $this->input->post('chapterId'));
			$subjectId = $this->input->post('subjectId');
			
			$oldChapterPic = $this->input->post('oldChapterPic');
			
			$mydata = array(
				'chapterNumber' => $this->testInput($this->input->post('chapterNumber')),
				'chapterName' => $this->testInput($this->input->post('chapterName')),
				'summary' => $this->testInput($this->input->post('summary')),
				'objectives' =>$this->testInput($this->input->post('objectives')),
				'totalHours' => $this->testInput($this->input->post('totalHours')),
				'cost' => $this->testInput($this->input->post('cost')),
			);

			if (!empty($_FILES['cover_photo']['name'])) {
			
				$config['upload_path'] = './uploads/chapter/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('cover_photo')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['chapterImage'] = $data['file_name'];
				}
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($mydata, 'chapters', $where)) {
					
					$msg = 'error';

				} else {

					if ($oldChapterPic && !empty($_FILES['cover_photo']['name'])) {
						if (file_exists('./uploads/chapter/'.$oldChapterPic)) {
							@unlink('./uploads/chapter/'.$oldChapterPic);
						}
					}
					$msg = '["Chapter updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('instructor/chapters/'.$subjectId),'refresh');
	}

	public function viewChapter($subjectId,$chapterId)
	{
		if ($chapterId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Chapter',
			'page' => 'subjectlist',
			'subpage' => 'viewchapter'
		);
		
		$data['data']= $chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/chapter_view');
		$this->load->view('instructor/footer');

	}

	public function deleteChapter($subjectId = false,$chapterId = false)
	{
		if ($subjectId != false && $chapterId != false) {

			$where_delete_chapter = array('chapterId' => $chapterId); 
			$data = $this->mymodel->get_by('chapters', true, $where_delete_chapter);

			if (!$this->mymodel->delete('chapters', $where_delete_chapter)) {
				
				$msg = 'error';

			} else {

            //Deleting all curriculum media under this chapter
				$chapterCurriculumData = $this->mymodel->get_by("chapter_carriculum_media",false,$where_delete_chapter,"chapterId",null);

				foreach ($chapterCurriculumData as $key => $media) {
					$where_delete_curriculum = array('mediaId' => $media->mediaId);

               if (@$media->mediaFile && file_exists('./uploads/chapter_curriculum/'.@$media->mediaFile)) {
						@unlink('./uploads/chapter_curriculum/'.@$media->mediaFile);
					}

					$this->mymodel->delete('chapter_carriculum_media', $where_delete_curriculum);
				}	
				

				if (@$data->chapterImage && file_exists('./uploads/chapter/'.@$data->chapterImage)) {
					@unlink('./uploads/chapter/'.@$data->chapterImage);
				}

				$msg = '["Chapter deleted successfully.", "success", "#A5DC86"]';
			
				$this->session->set_flashdata('msg', $msg);
		   }		
		}
		redirect(base_url('instructor/chapters/'.$subjectId),'refresh');
	}

	public function view_Chapter_Curriculum($subjectId,$chapterId){
		$data['title'] = "Chapter Carriculum Media Management";
		$data['page'] = "subjectlist";
		$data['subpage'] = "chaptercurriculum";
		
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$sql_subject_detail = "SELECT s.subjectId,s.subjectName FROM subjects s WHERE s.subjectId='".$subjectId."'";
		//echo $sql_subject_detail;exit;

		//Feching Course Details 
 		$data['subjectDetail'] = $this->mymodel->fetch($sql_subject_detail, true);

 		$sql_chapter_detail = "SELECT chp.* FROM chapters chp WHERE chp.chapterId='".$chapterId."'";
		//echo $sql_chapter_detail;exit;

		//Feching Course Details 
 		$data['chapterDetail'] = $this->mymodel->fetch($sql_chapter_detail, true);
          
      //Fetching all image data for this course carriculum
		/*$sql_fetch_media = "SELECT * FROM `chapter_carriculum_media` as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.ordering ASC";
		//echo $sql_fetch_media;exit;

		$data['mediaFiles'] = $this->mymodel->fetch($sql_fetch_media,false);*/

      $this->load->view('instructor/header',$data);
		$this->load->view('instructor/chapter_carriculum');
		$this->load->view('instructor/footer');   
	}

	public function loadAjaxChapterCurriculum($subjectId,$chapterId,$fetchType){		
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
          
      //Fetching all image data for this course carriculum
		$sql_fetch_media = "SELECT * FROM `chapter_carriculum_media` as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.ordering ASC";
      
      if($fetchType == "html"){
      	$data['mediaFiles'] = $this->mymodel->fetch($sql_fetch_media,false);
			$returnData = $this->load->view('instructor/chapter_carriculum_ajax',$data,true);
      }else{
      	$mediaFiles = $this->mymodel->fetch($sql_fetch_media,false);
			$returnData = json_decode(json_encode($mediaFiles),true);
      }
		
		echo json_encode($returnData);
	} 

	public function uploadChapterCurriculum(){

		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
	     
	   if(!empty($_FILES['file']['name']) && !empty($subjectId) && !empty($chapterId)){
               
         $allowedExtStr = "gif|jpg|jpeg|png|pdf|doc|docx|csv|xls|ppt|pptx|mp3|wav|ogg|mp4";

         $config['upload_path'] = './uploads/chapter_curriculum/';
			$config['allowed_types'] = $allowedExtStr;
			$config['max_size'] = '41560';
			$config['file_name'] = 'carriculum_'.rand(10,99).time();

			$file_ext = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('file')){
				$error = strip_tags($this->upload->display_errors());
				$mediaUploadError = $error;
				echo json_encode(array("check"=>"failure","msg"=>$mediaUploadError));
			} else {
			
				$data = $this->upload->data();
				$mediaFile = $data['file_name'];

				$mediaOgName = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
				$fileSize = $_FILES["file"] ["size"]; 
			
				$userId = $this->session->userdata('userId');
				$userType = "admin";

				switch ($file_ext) {
					case 'jpg':
					case 'jpeg':
					case 'png':
					   $mediaType = "image";
					   break;

					case 'mp4':
					   $mediaType = "video";
					   break;  

					case 'mp3':
					   $mediaType = "audio";
					   break;          

					case 'pdf':
					case 'doc':
					case 'docx':
					case 'csv':
					case 'xls':
					case 'ppt':
					case 'pptx':
					   $mediaType = "document";
					   break;   
					
					default:
					   $mediaType = "image";
					   break;
				}

				//Fetch last item ordering
				$sql_last_item_oreder = "SELECT ccm.ordering FROM chapter_carriculum_media as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.mediaId DESC LIMIT 1";
				$mediaData = $this->mymodel->fetch($sql_last_item_oreder,true);

				if(!empty($mediaData)){
					$ordering = $mediaData->ordering+1;
				}else{
					$ordering = 1;
				}

				$carriculumData = array(
					'subjectId' =>  $subjectId,
					'chapterId' =>  $chapterId,
					'ordering' => $ordering,
					'mediaType' => $mediaType,
					'mediaFile' => $mediaFile,
					'mediaOgName' => $mediaOgName,
					'fileSize' => $fileSize,
					'userType' => $userType,
					'userId' => $userId,
					'created'=>date('Y-m-d H:i:s'),
	         );

				if(!$this->mymodel->save('chapter_carriculum_media', $carriculumData)) {
				    echo json_encode(array("check"=>"failure","msg"=>"Media wasn't successfully uploaded"));
				}else {
				    $mediauRL = base_url('uploads/chapter_carriculum/'.$mediaFile);	
				    $media_id = $this->db->insert_id(); 
				    echo json_encode(array("check"=>"success","msg"=>"Media is successfully uploaded!","media_id"=>$media_id));
				    //echo json_encode(array($mediauRL));
				}
		     } 
		}     
	}

	public function deleteCurriculumContent(){
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
		$mediaId = $this->input->post('mediaId');

		//Delete curriculum content
		$where = array('subjectId' => $subjectId,'chapterId' => $chapterId,'mediaId' => $mediaId);

		$data = $this->mymodel->get_by('chapter_carriculum_media', true, $where);

		if (!$this->mymodel->delete('chapter_carriculum_media', $where)) {
			echo json_encode(array("check"=>"failure","msg"=>"Media wasn't deleted!"));
		} else {
			
			if (@$data->mediaFile && file_exists('./uploads/chapter_curriculum/'.@$data->mediaFile)) {
				@unlink('./uploads/chapter_curriculum/'.@$data->mediaFile);
			}
			echo json_encode(array("check"=>"success","msg"=>"Media is successfully deleted!"));
		}
	}

	public function saveChapterCurriculumOrder($subjectId,$chapterId){
		$orderData = $this->input->post('curriculum');
		
		$this->db->trans_begin();
		foreach ($orderData as $index => $order) {
			$where_clause =  array('subjectId' => $subjectId,'chapterId' => $chapterId,'mediaId' => $order);
			//Saving updated order of media
			$this->mymodel->update(['ordering'=>$index+1], 'chapter_carriculum_media',$where_clause);
		}
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
       	   echo json_encode(array("check"=>"failure","msg"=>"Some error occured, Please try again!"));
		}else{
           echo json_encode(array("check"=>"success","msg"=>"Media ordering saved successfully!"));   
		}
	}

	public function checkProfileProgress(){

		$userId=$this->session->userdata('userId');
		$profileInfo = $this->mymodel->get('users', true, 'userId', $userId);
      		
		$incompleteFields = array();

		$allowedMethodWthtAprv = array('settings','logout');

		$currenntMethod = $this->uri->segment(2);

		if($profileInfo->approve_status == 0 && !in_array($currenntMethod, $allowedMethodWthtAprv)){
			show_404();
		}else{
         $paymentInfoArr = unserialize($profileInfo->payment_info);    
			//Calculate profile completion percentage
			$profileProgress = 0;
			
			if(!empty($profileInfo->mobile)){
	          $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Mobile No is required."); 	
			}

			if(!empty($profileInfo->cv)){
	          $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "CV is required."); 		
			}

			if(!empty($profileInfo->descriptions)){
	          $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Bio is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['bank_name'])){
	          $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Bank Name is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['bank_address'])){
	         $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Bank Address is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['ins_bank_name'])){
	         $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Your name in your bank account is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['bank_acunt_no'])){
	         $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Bank acount no. is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['routing_no'])){
	         $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Routing no is required.");	
			}

			if(!empty($paymentInfoArr) && !empty($paymentInfoArr['swift_code'])){
	         $profileProgress = $profileProgress+11.11;
			}else{
			  array_push($incompleteFields, "Swift code is required.");	
			}

			$profileProgress = round($profileProgress);

			$this->session->set_flashdata('incompleteFields',$incompleteFields);

			//echo $profileProgress;exit;

			if($currenntMethod != "settings" && $currenntMethod != "updateInfo" && $profileProgress !=100){
				redirect(base_url('instructor/settings'),'refresh');
			}else{
				if($currenntMethod != "settings" && $currenntMethod != "updateInfo" && $profileProgress !=100){
					redirect(base_url('instructor/settings'),'refresh');
				}else{
					return $profileProgress; 
				}
	            
			} 
		}
      
	}

	public function dashboard()
	{   

		$userId = $this->session->userdata('userId');

		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_course = "SELECT c.courseId,c.courseName,c.image,c.created,GROUP_CONCAT(ci.level) as course_level FROM courses c LEFT JOIN course_instructors ci ON c.courseId=ci.courseId WHERE ci.instructorId='".$userId."' GROUP BY c.courseId DESC";
		
		$data['courseList'] = $this->mymodel->fetch($sql_course, false);
      $data['userId'] = $userId;
 
	 	$sql_running_courses = "SELECT sbc.courseId,sbc.courseLvl FROM student_purchased_courses spc INNER JOIN student_booked_classes sbc ON (sbc.instructorId = '".$userId."' AND spc.courseId = sbc.courseId AND spc.courseLvl = spc.courseLvl) WHERE sbc.instructorId = '".$userId."' GROUP BY sbc.courseLvl ORDER BY spc.purchaseId";  

	 	//echo $sql_running_courses;exit;

	    //Feching Enrolled Course List 
	 	$data['runningCourseData'] = $this->mymodel->fetch($sql_running_courses, false);

	 	$sql_enrolled_students = "SELECT Count(DISTINCT sbc.studentId) as studentCount FROM student_purchased_courses spc LEFT JOIN student_booked_classes sbc ON (sbc.instructorId = '".$userId."' AND spc.courseId = sbc.courseId AND spc.courseLvl = spc.courseLvl) WHERE sbc.instructorId = '".$userId."' GROUP BY sbc.courseLvl ORDER BY spc.purchaseId";  

	 	//echo $sql_enrolled_students;exit;

	    //Feching Enrolled Course List 
	 	$data['totalStudentData'] = $this->mymodel->fetch($sql_enrolled_students, true);

		$data['title'] = "Dashboard";
		$data['page'] = "dashboard";
		$data['subpage'] = null;

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/dashboard');
		$this->load->view('instructor/footer');
	}

	public function assignedCourseList()
	{
		$data['title'] = "Assigned Course List";
		$data['page'] = "courselist";
		$data['subpage'] = "assignedcourselist";

		$userId = $this->session->userdata('userId');
		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_course = "SELECT c.courseId,c.courseName,c.image,c.approve_status,c.created,GROUP_CONCAT(ci.level) as course_level FROM courses c LEFT JOIN course_instructors ci ON c.courseId=ci.courseId WHERE ci.instructorId='".$userId."' GROUP BY c.courseId DESC";
		
		$data['courseList'] = $this->mymodel->fetch($sql_course, false);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/assigned_course_list');
		$this->load->view('instructor/footer');
	}

	public function myCreatedCourselist(){
		$data['title'] = "My Created Course List";
		$data['page'] = "courselist";
		$data['subpage'] = "createdcourselist";

		$userId = $this->session->userdata('userId');
		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_course = "SELECT c.courseId,c.courseName,c.image,c.approve_status,c.created,GROUP_CONCAT(ci.level) as course_level FROM courses c LEFT JOIN course_instructors ci ON c.courseId=ci.courseId WHERE c.created_by='instructor' AND c.creator_id='".$userId."' AND ci.instructorId='".$userId."' GROUP BY c.courseId DESC";
		
		$data['courseList'] = $this->mymodel->fetch($sql_course, false);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/created_course_list');
		$this->load->view('instructor/footer');
	}

	public function addCourseView()
	{
		$data = array(
			'title' => 'Add New Course',
			'page' => 'courselist',
			'subpage' => 'courseadd'
		);

		//Fetching Subject
		$data['subjectList'] = $this->mymodel->get_by('subjects', false, "status=1", 'subjectId');
		//Fetching Instructor
 		$data['instList'] = $this->mymodel->get_by('users', false, "userType = 2 AND status=1", 'userId');

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/course_add');
		$this->load->view('instructor/footer');
	}

	private function set_upload_options($upload_path)
   {   
        //upload an image options
        $config = array();
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048';
	     $config['file_name'] = uniqid();
        
        return $config;
   }

	public function createCourse(){
      
 		//print_r($_POST);exit;

		if(!empty($this->input->post('courseName')) && !empty($_FILES['cover_photo']['name'])){

		   //Form validation
	      if($this->input->post('lvl_dsiply_status_beginner') == 1){
	      	if(empty($this->input->post('chapterId_beginner')) || empty($this->input->post('insId_beginner')) || empty($this->input->post('lvl_dsiply_status_beginner'))){

	      	   echo json_encode(array('check'=>'failure','level'=>'beginner','msg'=>'Beginner level data is incomplete!'));
	            exit;
	      	}
	      } 

	      if($this->input->post('lvl_dsiply_status_intermediate') == 1){
	      	if(empty($this->input->post('chapterId_intermediate')) || empty($this->input->post('insId_intermediate')) || empty($this->input->post('lvl_dsiply_status_intermediate'))){

	      	  echo json_encode(array('check'=>'failure','level'=>'intermediate','msg'=>'Intermediate level data is incomplete!'));
	           exit;
	      	}
	      } 

	      if($this->input->post('lvl_dsiply_status_advanced') == 1){
	      	if(empty($this->input->post('chapterId_advanced')) || empty($this->input->post('insId_advanced')) || empty($this->input->post('lvl_dsiply_status_advanced'))){

	      	  echo json_encode(array('check'=>'failure','level'=>'advanced','msg'=>'Advanced level data is incomplete!'));
	           exit;
	      	}
	      } 

	      if($this->input->post('lvl_dsiply_status_beginner') == 0 && $this->input->post('lvl_dsiply_status_intermediate') == 0 && $this->input->post('lvl_dsiply_status_advanced') == 0){
               	
         	 echo json_encode(array('check'=>'failure','msg'=>'You have to choose at leset one level to update the course!'));
             exit;
         }
	         
	      //Running transaction
	      $this->db->trans_begin();

	      $userId = $this->session->userdata("userId");
		    
	    	if($this->session->userdata('instructor') == 2){
		   	$userType = "instructor";
	    	}

	      $mydata = array(
			   'courseName' => $this->testInput($this->input->post('courseName')),
			   'descriptions' =>$this->testInput($this->input->post('descriptions')),
			   'userId' => $userId,
			   'status' => 1,
			   'approve_status' => "forbidden",
			   'created'=> date('Y-m-d H:i:s'),	
			   'created_by'=> $userType,
			   'creator_id'=> $userId,
			);

			//Loading upload library
			$this->load->library('upload'); 

			if (!empty($_FILES['cover_photo']['name'])){			
				$upload_path = './uploads/courses/';		
				$this->upload->initialize($this->set_upload_options($upload_path));

				if (!$this->upload->do_upload('cover_photo'))
				{
					$error = strip_tags($this->upload->display_errors());
					echo json_encode(array('check'=>'failure','msg'=>$error));
					exit;
				} else {
					$data = $this->upload->data();
					$mydata['image'] = $data['file_name'];
				}
		   }

	      if (!$this->mymodel->save('courses', $mydata)) {
	   	   //Removing course image from server
				$courseImg = $mydata['image'];
				if (file_exists('./uploads/courses/'.$courseImg)) {
					 @unlink('./uploads/courses/'.$courseImg);
				}
				echo json_encode(array('check'=>'failure','msg'=>"Some error occured, Please try again."));
		   } else {
	            
	           $courseId = $this->db->insert_id();

				  if(!empty($this->input->post('chapterId_beginner')) && !empty($this->input->post('insId_beginner')) && !empty($this->input->post('lvl_dsiply_status_beginner')))
				  {

							
					     $beginnerChapterId = $this->input->post('chapterId_beginner');
				                
			           if(!empty($beginnerChapterId) && count($beginnerChapterId)>0){ 
			                  
			                foreach($beginnerChapterId as $index=>$chapterId){

			                	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
			                     $beginnerLvlArr = array(
				                	 'courseId'=>$courseId,
				                	 'level'=>'beginner',
				                	 'chapterId'=>$chapterId,
				                	 'subjectId'=>$chapterDetail->subjectId,
				                	 'created'=>date('Y-m-d H:i:s') 
				                 ); 
			                     //Insert data into db
				                $this->mymodel->save('course_chapters', $beginnerLvlArr);
			                }
			           }    

		              //Instering instructor data for current course for beginner level
		              $beginnerInsId = $this->input->post('insId_beginner');

		              if(!empty($beginnerInsId) && count($beginnerInsId)>0){
		                
			               foreach($beginnerInsId as $index=>$instructorId){
			                     $beginnerInsArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'beginner',
					                	'instructorId'=>$instructorId,
					                	'created'=>date('Y-m-d H:i:s') 
				                  ); 
			                   //Insert data into db
				                $this->mymodel->save('course_instructors', $beginnerInsArr);
			               }
				        }    
					     
					     $beginner_intro_video = $this->input->post('beginner_intro_video');           
		              $beginnerLvlDesc = $this->input->post('descriptions_beginner');
		              $beginnerLvlStatus = $this->input->post('lvl_dsiply_status_beginner');

		              $beginnerLvlData = array(
							                	  'courseId'=>$courseId,
							                	  'level'=>'beginner',
							                	  'intro_video'=>$beginner_intro_video,
							                	  'descriptions'=>$beginnerLvlDesc,
							                	  'status'=>$beginnerLvlStatus,
							                	  'created'=>date('Y-m-d H:i:s') 
							                  ); 

				        if($_FILES['courseImage_beginner']['name'] != ''){	
		        		      $upload_path = './uploads/level/';		
					   		$this->upload->initialize($this->set_upload_options($upload_path));

					   		if (!$this->upload->do_upload('courseImage_beginner')){
								  $error = strip_tags($this->upload->display_errors());
								 
								  $this->db->trans_rollback();	
								 
								  //Removing course image from server
								  $courseImg = $mydata['image'];
								  if (file_exists('./uploads/courses/'.$courseImg)) {
									   @unlink('./uploads/courses/'.$courseImg);
								  }

							  	  echo json_encode(array('check'=>'failure','msg'=>$error));
							  	  exit;
							   } else {
								   $data = $this->upload->data();
								   $beginnerLvlData['image'] = $data['file_name'];
							   }
					     }

				        //Insert data into db
				        $this->mymodel->save('course_level_details', $beginnerLvlData);
			     }

				  if(!empty($this->input->post('chapterId_intermediate')) && !empty($this->input->post('insId_intermediate')) && !empty($this->input->post('lvl_dsiply_status_intermediate')))
				  {


		            $interChapterId = $this->input->post('chapterId_intermediate');

		            if(!empty($interChapterId) && count($interChapterId)>0){ 

		                foreach($interChapterId as $index=>$chapterId){

		                	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

		                     $intermediateLvlArr = array(
							                	'courseId'=>$courseId,
							                	'level'=>'intermediate',
							                	'chapterId'=>$chapterId,
							                	'subjectId'=>$chapterDetail->subjectId,
							                	'created'=>date('Y-m-d H:i:s') 
							                  ); 
			                $this->mymodel->save('course_chapters', $intermediateLvlArr);
		                }	
		            }     

	               //Instering instructor data for current course for beginner level
	               $intermediateInsId = $this->input->post('insId_intermediate');
	                     
	               if(!empty($intermediateInsId) && count($intermediateInsId)>0){
		                foreach($intermediateInsId as $index=>$instructorId){
		                     $interInsArr = array(
						                 'courseId'=>$courseId,
						                 'level'=>'intermediate',
						                 'instructorId'=>$instructorId,
						                 'created'=>date('Y-m-d H:i:s') 
						                ); 
		                     //Insert data into db
			                $this->mymodel->save('course_instructors', $interInsArr);
		                }
		            }  
                  
                  $intermediate_intro_video = $this->input->post('intermediate_intro_video'); 
	               $interLvlDesc = $this->input->post('descriptions_intermediate');
	               $interLvlStatus = $this->input->post('lvl_dsiply_status_intermediate');

	               $interLvlData = array(
					                	  'courseId'=>$courseId,
					                	  'level'=>'intermediate',
					                	  'intro_video'=>$intermediate_intro_video,
					                	  'descriptions'=>$interLvlDesc,
					                	  'status'=>$interLvlStatus,
					                	  'created'=>date('Y-m-d H:i:s') 
		                           ); 

		            if ($_FILES['courseImage_intermediate']['name'] != ''){
					
							$upload_path = './uploads/level/';		
							$this->upload->initialize($this->set_upload_options($upload_path));
					
							if (!$this->upload->do_upload('courseImage_intermediate')) {
								$error = strip_tags($this->upload->display_errors());
								
								$this->db->trans_rollback();	
						 
							   //Removing course image from server
							   $courseImg = $mydata['image'];
							   if (file_exists('./uploads/courses/'.$courseImg)) {
								   @unlink('./uploads/courses/'.$courseImg);
							   }
							 
							   //Removing course beginner level image from server
							   $beginnerLvlImg = $beginnerLvlData['image'];
							   if (file_exists('./uploads/level/'.$beginnerLvlImg)) {
								   @unlink('./uploads/level/'.$beginnerLvlImg);
							   }

			               echo json_encode(array('check'=>'failure','msg'=>$error));
							   exit;

						   } else {
							   $data = $this->upload->data();
							   $interLvlData['image'] = $data['file_name'];
							}
	 	   		   }

				 	  //Insert data into db
			        $this->mymodel->save('course_level_details', $interLvlData);
		        } 

			     if(!empty($this->input->post('chapterId_advanced')) && !empty($this->input->post('insId_advanced')) && !empty($this->input->post('lvl_dsiply_status_advanced')))
			     { 


		           	 $advanceChapterId = $this->input->post('chapterId_advanced');

		             if(!empty($advanceChapterId) && count($advanceChapterId)>0){
	                
		                foreach($advanceChapterId as $index=>$chapterId){
		                	 
		                	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
		                     $advanceLvlArr = array(
						                	 'courseId'=>$courseId,
						                	 'level'=>'advanced',
						                	 'chapterId'=>$chapterId,
						                	 'subjectId'=>$chapterDetail->subjectId,
						                	 'created'=>date('Y-m-d H:i:s') 
						                  ); 
		                     $this->mymodel->save('course_chapters', $advanceLvlArr); 
		                }
		             }     

	                //Instering instructor data for current course for beginner level
	                $advancedInsId = $this->input->post('insId_advanced');
		                    
	                if(!empty($advancedInsId) && count($advancedInsId)>0){
		                foreach($advancedInsId as $index=>$instructorId){
		                     $advancedInsArr = array(
							                 'courseId'=>$courseId,
							                 'level'=>'advanced',
							                 'instructorId'=>$instructorId,
							                 'created'=>date('Y-m-d H:i:s') 
							               ); 
		                     //Insert data into db
			                $this->mymodel->save('course_instructors', $advancedInsArr);
		                }
			      	 }    
                   
                   $advanced_intro_video = $this->input->post('advanced_intro_video');
	                $advanceLvlDesc = $this->input->post('descriptions_advanced');
	                $advanceLvlStatus = $this->input->post('lvl_dsiply_status_advanced');

		             $advanceLvlData = array(
					                 'courseId'=>$courseId,
					                 'level'=>'advanced',
					                 'intro_video'=>$advanced_intro_video,
					                 'descriptions'=>$advanceLvlDesc,
					                 'status'=>$advanceLvlStatus,
					                 'created'=>date('Y-m-d H:i:s') 
	            				     ); 

		            if ($_FILES['courseImage_advanced']['name'] != ''){
					      $upload_path = './uploads/level/';		
					      $this->upload->initialize($this->set_upload_options($upload_path));

					      if (!$this->upload->do_upload('courseImage_advanced')) {
							   $error = strip_tags($this->upload->display_errors());
							   
							   $this->db->trans_rollback();	
					 
							   //Removing course image from server
							   $courseImg = $mydata['image'];
							   if (file_exists('./uploads/courses/'.$courseImg)) {
								   @unlink('./uploads/courses/'.$courseImg);
							   }
							 
							   //Removing course beginner level image from server
							   $beginnerLvlImg = $beginnerLvlData['image'];
							   if (file_exists('./uploads/level/'.$beginnerLvlImg)) {
								   @unlink('./uploads/level/'.$beginnerLvlImg);
							   }

							   //Removing course intermediate level image from server
							   $interLvlImg = $interLvlData['image'];
							   if (file_exists('./uploads/level/'.$interLvlImg)) {
								   @unlink('./uploads/level/'.$interLvlImg);
							   }

			               echo json_encode(array('check'=>'failure','msg'=>$error));
							   exit;	
					      } else {
							   $data = $this->upload->data();
						 	   $advanceLvlData['image'] = $data['file_name'];
					      }
			 	  		}

					  	//Insert data into db
					 	$this->mymodel->save('course_level_details', $advanceLvlData);
			     }
	                        
		        if ($this->db->trans_status() === FALSE)
		        {

				      $this->db->trans_rollback();	
									 
						//Removing course image from server
						$courseImg = $mydata['image'];
						if (file_exists('./uploads/courses/'.$courseImg)) {
							@unlink('./uploads/courses/'.$courseImg);
						}
						 
						//Removing course beginner level image from server
						$beginnerLvlImg = $beginnerLvlData['image'];
						if (file_exists('./uploads/level/'.$beginnerLvlImg)) {
							@unlink('./uploads/level/'.$beginnerLvlImg);
						}
						//Removing course intermediate level image from server
						$interLvlImg = $interLvlData['image'];
						if (file_exists('./uploads/level/'.$interLvlImg)) {
							@unlink('./uploads/level/'.$interLvlImg);
						}

						//Removing course advanced level image from server
						$advancedLvlImg = $advanceLvlData['image'];
						if (file_exists('./uploads/level/'.$advancedLvlImg)) {
							@unlink('./uploads/level/'.$advancedLvlImg);
						}

	            	echo json_encode(array('check'=>'success','msg'=>'Some error occured, Please try again!')); 
		        }else
		        {

		         	$this->db->trans_commit();
		         	echo json_encode(array('check'=>'success','msg'=>'Course has been successfully added!','courseId'=>$courseId)); 
		        }
		   }
	   }else
	   {
	   	echo json_encode(array('check'=>'failure','level'=>'beginner','msg'=>'Course data is incomplete!'));
	   }
	}

	public function getChapters()
	{		
		$subjectId = $this->input->post('subjectId');
		$subjectTypeof = $this->input->post('subjectTypeof');
        
		if($subjectTypeof == 'string'){
           $sql = "SELECT sub.subjectName,ch.chapterId,ch.chapterName FROM chapters ch LEFT JOIN subjects sub ON ch.subjectId = sub.subjectId WHERE ch.subjectId='$subjectId' ORDER BY ch.chapterId DESC";
		}else{
		   $subjectIdStr = implode(',',$subjectId);	
		   $sql = "SELECT sub.subjectName,ch.chapterId,ch.chapterName FROM chapters ch LEFT JOIN subjects sub ON ch.subjectId = sub.subjectId WHERE ch.subjectId IN ($subjectIdStr) ORDER BY ch.chapterId DESC";
		}
		//Fetching chapter data
		$chapterList = $this->db->query($sql)->result();
		
        if(is_array($chapterList) && count($chapterList)>0){
			/*echo '<select class="form-control chapterId" name="chapterId[]" multiple required>';
			foreach ($chapterList as $key => $v){
				echo '<option value="'.$v->chapterId .'" data-badge="">'.$v->chapterName.'</option>';
			}
			echo'</select>';*/
			echo json_encode(array('check'=>'success','chapterList'=>$chapterList));
		}else{
			echo json_encode(array('check'=>'failure','chapterList'=>null));
		}	
	}

	public function fetchCourseLvlDetail()
	{    
		
		$returnArr = array();
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');

		$data = array(
			'title' => 'Edit Course Info',
			'page' => 'course',
			'subpage' => 'courselist'
		);
          
          //FETCHING LEVEL'S INSTRUCTOR DETAILS
		$sql_sub_crs = "SELECT cc.level,c.totalHours,c.cost,s.subjectName,GROUP_CONCAT(DISTINCT c.chapterName) as chapterName FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId = c.chapterId LEFT JOIN subjects s ON c.subjectId = s.subjectId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' GROUP BY cc.courseDetailId"; 

		//echo $sql_sub_crs;exit;
          
          $lvlSubCrsList = $this->mymodel->fetch($sql_sub_crs, false);

          $sql_lvl_cst_dur = "SELECT SUM(c.cost) AS totalcost, SUM(c.totalHours) as totalhours FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId = c.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'"; 

		//echo $sql_lvl_cst_dur;exit;

		$lvlCstDurData = $this->mymodel->fetch($sql_lvl_cst_dur, true);
                    
 		//FETCHING LEVEL'S INSTRUCTOR DETAILS
		$sql_instructor = "SELECT ci.level,GROUP_CONCAT(CONCAT(u.firstName,' ',u.lastName)) as lvlIns FROM course_instructors ci LEFT JOIN users u ON ci.instructorId = u.userId WHERE ci.courseId='".$courseId."' AND ci.level='".$courseLvl."' GROUP BY ci.level";
		
          //echo $sql_instructor;exit;

		$lvlInsList = $this->mymodel->fetch($sql_instructor, true);

		//print_r($lvlSubCrsList);exit;

		$returnArr['lvlCost'] = $lvlCstDurData->totalcost;
		$returnArr['totalhours'] = $lvlCstDurData->totalhours;
		$returnArr['instructor'] = $lvlInsList->lvlIns;

		$returnArr['subjectCrsData'] = $lvlSubCrsList;

		echo json_encode($returnArr);
	}

	public function editCourse($courseId = false)
	{
		if ($courseId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Course Info',
			'page' => 'courselist',
			'subpage' => 'editcourse'
		);
          
      //Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->get('courses', true, 'courseId', $courseId);

 		//Fetching Subjects
 		$data['subjectList'] = $this->mymodel->get_by('subjects', false, "status=1", 'subjectId');
          
      //FETCHING COURSE'S CHAPTER DETAIL
		$sql_course_subject_chapter = "SELECT cc.level,GROUP_CONCAT(DISTINCT s.subjectName) as subjectName,GROUP_CONCAT(DISTINCT CONCAT(c.chapterId,'-',c.chapterName, ' (', s.subjectName, ')') SEPARATOR '&%*$!') as chapterData FROM course_chapters cc LEFT JOIN chapters c ON cc.subjectId=c.subjectId LEFT JOIN subjects s ON c.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' GROUP BY cc.level";

		//echo $sql_course_subject_chapter;exit;
		
		$data['chapterList'] = $this->mymodel->fetch($sql_course_subject_chapter, false);

 		//Fetching Instructor
 		$data['instList'] = $this->mymodel->get_by('users', false, "userType = 2 AND status=1", 'userId');

          //Feching Course Level Details 
		$data['levelDetail'] = $this->mymodel->get('course_level_details', false, 'courseId', $courseId);

		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_chapter = "SELECT cc.level,GROUP_CONCAT(cc.chapterId) as chapterId, GROUP_CONCAT(chp.subjectId) as subjectId FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' GROUP BY cc.level";
		$data['courseChapterIds'] = $this->mymodel->fetch($sql_chapter, false);

		//FETCHING COURSE'S INSTRUCTOR DETAILS
		$sql_instructor = "SELECT ci.level,GROUP_CONCAT(ci.instructorId) as insId FROM course_instructors ci WHERE ci.courseId='".$courseId."' GROUP BY ci.level";
		$data['courseInsIds'] = $this->mymodel->fetch($sql_instructor, false);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/course_edit');
		$this->load->view('instructor/footer');
	}

	public function viewCourse($courseId = false)
	{
		if ($courseId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Course Info',
			'page' => 'courselist',
			'subpage' => 'courseview'
		);
          
          //Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->get('courses', true, 'courseId', $courseId);

 		//Fetching Subjects
 		$data['subjectList'] = $this->mymodel->get_by('subjects', false, "status=1", 'subjectId');
          
          //FETCHING COURSE'S CHAPTER DETAIL
		$sql_course_subject_chapter = "SELECT cc.level,GROUP_CONCAT(DISTINCT s.subjectName) as subjectName,GROUP_CONCAT(DISTINCT CONCAT(c.chapterId,'-',c.chapterName, ' (', s.subjectName, ')') SEPARATOR '&%*$!') as chapterData FROM course_chapters cc LEFT JOIN chapters c ON cc.subjectId=c.subjectId LEFT JOIN subjects s ON c.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' GROUP BY cc.level";

		//echo $sql_course_subject_chapter;exit;
		
		$data['chapterList'] = $this->mymodel->fetch($sql_course_subject_chapter, false);

 		//Fetching Instructor
 		$data['instList'] = $this->mymodel->get_by('users', false, "userType = 2 AND status=1", 'userId');

          //Feching Course Level Details 
		$data['levelDetail'] = $this->mymodel->get('course_level_details', false, 'courseId', $courseId);

		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_chapter = "SELECT cc.level,GROUP_CONCAT(cc.chapterId) as chapterId, GROUP_CONCAT(chp.subjectId) as subjectId FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' GROUP BY cc.level";
		$data['courseChapterIds'] = $this->mymodel->fetch($sql_chapter, false);

		//FETCHING COURSE'S INSTRUCTOR DETAILS
		$sql_instructor = "SELECT ci.level,GROUP_CONCAT(ci.instructorId) as insId FROM course_instructors ci WHERE ci.courseId='".$courseId."' GROUP BY ci.level";
		$data['courseInsIds'] = $this->mymodel->fetch($sql_instructor, false);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/course_view');
		$this->load->view('instructor/footer');
	}

	public function updateCourse(){

		//print_r($_POST);exit;
		if($this->input->post('courseName') && $this->input->post('courseId') ){

			//Form validation
               if($this->input->post('lvl_dsiply_status_beginner') == 1){
               	if(empty($this->input->post('chapterId_beginner')) || empty($this->input->post('insId_beginner')) || empty($this->input->post('lvl_dsiply_status_beginner'))){

               		echo json_encode(array('check'=>'failure','level'=>'beginner','msg'=>'Beginner level data is incomplete!'));
                         exit;
               	}
               } 

               if($this->input->post('lvl_dsiply_status_intermediate') == 1){
               	if(empty($this->input->post('chapterId_intermediate')) || empty($this->input->post('insId_intermediate')) || empty($this->input->post('lvl_dsiply_status_intermediate'))){

               		echo json_encode(array('check'=>'failure','level'=>'intermediate','msg'=>'Intermediate level data is incomplete!'));
                         exit;
               	}
               } 

               if($this->input->post('lvl_dsiply_status_advanced') == 1){
               	if(empty($this->input->post('chapterId_advanced')) || empty($this->input->post('insId_advanced')) || empty($this->input->post('lvl_dsiply_status_advanced'))){

               		echo json_encode(array('check'=>'failure','level'=>'advanced','msg'=>'Advanced level data is incomplete!'));
                         exit;
               	}
               }

                if($this->input->post('lvl_dsiply_status_beginner') == 0 && $this->input->post('lvl_dsiply_status_intermediate') == 0 && $this->input->post('lvl_dsiply_status_advanced') == 0){
               	
               		echo json_encode(array('check'=>'failure','msg'=>'You have to choose at leset one level to update the course!'));
                         exit;
               }

               //Running transaction
         		$this->db->trans_begin();
	        
	          $courseId = $this->input->post('courseId');
	        
	          $mydata = array(
					   'courseName' => $this->testInput($this->input->post('courseName')),
					   'descriptions' =>$this->testInput($this->input->post('descriptions')),
					   'userId' => 0,
					   'status' => 1,
					   'updated'=> date('Y-m-d H:i:s'),	
					);

	          $oldCourseImage = $this->input->post('oldCourseImage');

			//Loading upload library
			$this->load->library('upload'); 

			if (!empty($_FILES['cover_photo']['name'])){			
				$upload_path = './uploads/courses/';		
				$this->upload->initialize($this->set_upload_options($upload_path));

				if (!$this->upload->do_upload('cover_photo'))
				{
					$error = strip_tags($this->upload->display_errors());
					echo json_encode(array('check'=>'failure','msg'=>$error));
					exit;		
				} else {
					$data = $this->upload->data();
					$mydata['image'] = $data['file_name'];
				}
			}else{
			   $mydata['image'] = $oldCourseImage;	
			}

			$where_crs_clause = array('courseId' => $courseId);
				
			if (!$this->mymodel->update($mydata,'courses',$where_crs_clause)) 
			{
				//Removing course image from server
				$courseImg = $mydata['image'];
				if (!empty($_FILES['cover_photo']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
					 @unlink('./uploads/courses/'.$courseImg);
				}
				echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
				exit;
			} else {

				if ($oldCourseImage && !empty($_FILES['cover_photo']['name'])) {
					if (file_exists('./uploads/courses/'.$oldCourseImage)) {
						@unlink('./uploads/courses/'.$oldCourseImage);
					}
				}
                    
            //Constructing all delete clause 
				$where_del_course_detail_beginner = array('courseId' => $courseId,'level'=>'beginner');
				$where_del_course_detail_intermediate = array('courseId' => $courseId,'level'=>'intermediate');
				$where_del_course_detail_advanced = array('courseId' => $courseId,'level'=>'advanced');
				
				if(!empty($this->input->post('chapterId_beginner')) && !empty($this->input->post('insId_beginner')) && strlen($this->input->post('lvl_dsiply_status_beginner'))>0){

					//Deleting all course detail data before re-inserting 
					$deleteBeginnerChapterData = $this->mymodel->delete('course_chapters', $where_del_course_detail_beginner);
					$deleteBeginnerLvlData = $this->mymodel->delete('course_level_details', $where_del_course_detail_beginner);
					$deleteBeginnerInsData = $this->mymodel->delete('course_instructors', $where_del_course_detail_beginner);

					if ($deleteBeginnerChapterData && $deleteBeginnerLvlData && $deleteBeginnerInsData){
                    
	                         //Instering chapter data for current course for beginner level
						$beginnerChapterId = $this->input->post('chapterId_beginner');

						if(!empty($beginnerChapterId) && count($beginnerChapterId)>0){
		                   
				               foreach($beginnerChapterId as $index=>$chapterId){

				               	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

				                     $beginnerLvlArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'beginner',
					                	'chapterId'=>$chapterId,
					                	'subjectId'=>$chapterDetail->subjectId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
				                     //Insert data into db
					                $this->mymodel->save('course_chapters', $beginnerLvlArr);
				               }
				          }     
	                         
	                     //Instering instructor data for current course for beginner level
			               $beginnerInsId = $this->input->post('insId_beginner');

			               if(!empty($beginnerInsId) && count($beginnerInsId)>0){
		                   
				               foreach($beginnerInsId as $index=>$instructorId){
				                     $beginnerInsArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'beginner',
					                	'instructorId'=>$instructorId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
				                     //Insert data into db
					                $this->mymodel->save('course_instructors', $beginnerInsArr);
				                }
				           }      
		                   
		                   $beginner_intro_video = $this->input->post('beginner_intro_video');
			                $beginnerLvlDesc = $this->input->post('descriptions_beginner');
			                $beginnerLvlStatus = $this->input->post('lvl_dsiply_status_beginner');

			                $beginnerLvlData = array(
						                	  'courseId'=>$courseId,
						                	  'level'=>'beginner',
						                	  'intro_video'=>$beginner_intro_video,
						                	  'descriptions'=>$beginnerLvlDesc,
						                	  'status'=>$beginnerLvlStatus,
						                	  'created'=>date('Y-m-d H:i:s') 
							               ); 

			                $oldbigLvlImage = $this->input->post('oldbigLvlImage');

			                if ($_FILES['courseImage_beginner']['name'] != ''){	
			                    $upload_path = './uploads/level/';		
							$this->upload->initialize($this->set_upload_options($upload_path));

							if (!$this->upload->do_upload('courseImage_beginner'))
							{
								$error = strip_tags($this->upload->display_errors());
								$this->db->trans_rollback();	
						 
								//Removing course image from server
								$courseImg = $mydata['image'];
								if (!empty($_FILES['courseImage']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
									@unlink('./uploads/courses/'.$courseImg);
								}
								echo json_encode(array('check'=>'failure','msg'=>$error));
							   	exit;
		
							} else {
								$data = $this->upload->data();
								$beginnerLvlData['image'] = $data['file_name'];
							}
						 }else{
						 	$beginnerLvlData['image'] = $oldbigLvlImage;
						 }

						 if ($oldbigLvlImage && $_FILES['courseImage_beginner']['name'] != ''){
							if (file_exists('./uploads/level/'.$oldbigLvlImage)) {
								@unlink('./uploads/level/'.$oldbigLvlImage);
							}
						 }

						 //Insert data into db
				           $this->mymodel->save('course_level_details', $beginnerLvlData);
				     }else{
				         echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
					    exit;	 	
				     }
				}else{
				    if($this->input->post('lvl_dsiply_status_beginner') == "1"){
				    	  echo json_encode(array('check'=>'failure','msg'=>'Some fields are incomplete on beginner level.'));
				    	  exit;	
				    }	
				    
				}     
				    
				
				if(!empty($this->input->post('chapterId_intermediate')) && !empty($this->input->post('insId_intermediate')) && strlen($this->input->post('lvl_dsiply_status_intermediate'))>0){     

					 //Deleting all course detail data before re-inserting 
					 $deleteInterChapterData = $this->mymodel->delete('course_chapters', $where_del_course_detail_intermediate);
					 $deleteInterLvlData = $this->mymodel->delete('course_level_details', $where_del_course_detail_intermediate);
					 $deleteInterInsData = $this->mymodel->delete('course_instructors', $where_del_course_detail_intermediate);

					 if ($deleteInterChapterData && $deleteInterLvlData && $deleteInterInsData){

		                     //Instering chapter data for current course for intermediate level
				           $interChapterId = $this->input->post('chapterId_intermediate');
		                     
		                     if(!empty($interChapterId) && count($interChapterId)>0){

				                foreach($interChapterId as $index=>$chapterId){

				                	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

				                     $intermediateLvlArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'intermediate',
					                	'chapterId'=>$chapterId,
					                	'subjectId'=>$chapterDetail->subjectId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
					                 $this->mymodel->save('course_chapters', $intermediateLvlArr);
				                }
				           }     


			                //Instering instructor data for current course for beginner level
			                $intermediateInsId = $this->input->post('insId_intermediate');
		                     
		                     if(!empty($intermediateInsId) && count($intermediateInsId)>0){
				                foreach($intermediateInsId as $index=>$instructorId){
				                     $interInsArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'intermediate',
					                	'instructorId'=>$instructorId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
				                     //Insert data into db
					                $this->mymodel->save('course_instructors', $interInsArr);
				                }
				           }     
                         
                         $intermediate_intro_video = $this->input->post('intermediate_intro_video');
			                $interLvlDesc = $this->input->post('descriptions_intermediate');
			                $interLvlStatus = $this->input->post('lvl_dsiply_status_intermediate');

			                $interLvlData = array(
				                	'courseId'=>$courseId,
				                	'level'=>'intermediate',
				                	'intro_video'=>$intermediate_intro_video,
				                	'descriptions'=>$interLvlDesc,
				                	'status'=>$interLvlStatus,
				                	'created'=>date('Y-m-d H:i:s') 
				                 ); 

			                $oldIntLvlImage = $this->input->post('oldIntLvlImage');

			                if ($_FILES['courseImage_intermediate']['name'] != ''){			
							$upload_path = './uploads/level/';		
							$this->upload->initialize($this->set_upload_options($upload_path));
							
							if ( ! $this->upload->do_upload('courseImage_intermediate'))
							{
								$error = strip_tags($this->upload->display_errors());
								$this->db->trans_rollback();	
							 
								//Removing course image from server
								$courseImg = $mydata['image'];
								if (!empty($_FILES['courseImage']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
									@unlink('./uploads/courses/'.$courseImg);
								}
								 
								//Removing course beginner level image from server
								$beginnerLvlImg = $beginnerLvlData['image'];
								if (!empty($_FILES['courseImage_beginner']['name']) && 
								   file_exists('./uploads/level/'.$beginnerLvlImg)) {
									@unlink('./uploads/level/'.$beginnerLvlImg);
								}	

								echo json_encode(array('check'=>'failure','msg'=>$error));
								exit; 	
							} else {
								$data = $this->upload->data();
								$interLvlData['image'] = $data['file_name'];
							}
						 }else{
						 	$interLvlData['image'] = $oldIntLvlImage;
						 }

						 if ($oldIntLvlImage && $_FILES['courseImage_intermediate']['name'] != '') {
							if (file_exists('./uploads/level/'.$oldIntLvlImage)) {
								@unlink('./uploads/level/'.$oldIntLvlImage);
							}
						 }

						 //Insert data into db
				           $this->mymodel->save('course_level_details', $interLvlData);
				      }else{
				         echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
					    exit;	 	
				     }      
		          }else{
				    if($this->input->post('lvl_dsiply_status_intermediate') == "1"){
				    	  echo json_encode(array('check'=>'failure','msg'=>'Some fields are incomplete on intermediate level.'));
				    	  exit;	
				    }	
				}  

				
				if(!empty($this->input->post('chapterId_advanced')) && !empty($this->input->post('insId_advanced')) && strlen($this->input->post('lvl_dsiply_status_advanced'))>0){      

					//Deleting all course detail data before re-inserting 
					$deleteAdvancedChapterData = $this->mymodel->delete('course_chapters', $where_del_course_detail_advanced);
					$deleteAdvancedLvlData = $this->mymodel->delete('course_level_details', $where_del_course_detail_advanced);
					$deleteAdvancedInsData = $this->mymodel->delete('course_instructors', $where_del_course_detail_advanced);

					if ($deleteAdvancedChapterData && $deleteAdvancedLvlData && $deleteAdvancedInsData){
                
	                         //Instering chapter data for current course for advanced level
				          $advanceChapterId = $this->input->post('chapterId_advanced');
	                         
	                         if(!empty($advanceChapterId) && count($advanceChapterId)>0){
				               foreach($advanceChapterId as $index=>$chapterId){

				               	 $chapterDetail = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

				                     $advanceLvlArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'advanced',
					                	'chapterId'=>$chapterId,
					                	'subjectId'=>$chapterDetail->subjectId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
				                    $this->mymodel->save('course_chapters', $advanceLvlArr); 
				               }
				          }     

			               //Instering instructor data for current course for beginner level
			               $advancedInsId = $this->input->post('insId_advanced');
		                    
		                    if(!empty($advancedInsId) && count($advancedInsId)>0){
				              
				               foreach($advancedInsId as $index=>$instructorId){
				                     $advancedInsArr = array(
					                	'courseId'=>$courseId,
					                	'level'=>'advanced',
					                	'instructorId'=>$instructorId,
					                	'created'=>date('Y-m-d H:i:s') 
					                 ); 
				                     //Insert data into db
					                $this->mymodel->save('course_instructors', $advancedInsArr);
				               }
				           }     
                         
                         $advanced_intro_video = $this->input->post('advanced_intro_video');
			                $advanceLvlDesc = $this->input->post('descriptions_advanced');
			                $advanceLvlStatus = $this->input->post('lvl_dsiply_status_advanced');

			                $advanceLvlData = array(
				                	'courseId'=>$courseId,
				                	'level'=>'advanced',
				                	'intro_video'=> $advanced_intro_video,
				                	'descriptions'=>$advanceLvlDesc,
				                	'status'=>$advanceLvlStatus,
				                	'created'=>date('Y-m-d H:i:s') 
				                 ); 

			                $oldAdvLvlImage = $this->input->post('oldAdvLvlImage');

			                if ($_FILES['courseImage_advanced']['name'] != ''){			
							$upload_path = './uploads/level/';		
							$this->upload->initialize($this->set_upload_options($upload_path));

							if ( ! $this->upload->do_upload('courseImage_advanced'))
							{
								$error = strip_tags($this->upload->display_errors());
								$this->db->trans_rollback();	
						 
								//Removing course image from server
								$courseImg = $mydata['image'];
								if (!empty($_FILES['courseImage']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
									@unlink('./uploads/courses/'.$courseImg);
								}
								 
								//Removing course beginner level image from server
								$beginnerLvlImg = $beginnerLvlData['image'];
								if (!empty($_FILES['courseImage_beginner']['name']) && 
								   file_exists('./uploads/level/'.$beginnerLvlImg)) {
									@unlink('./uploads/level/'.$beginnerLvlImg);
								}	

								//Removing course intermediate level image from server
								$intermediateLvlImg = $interLvlData['image'];
								if (!empty($_FILES['courseImage_intermediate']['name']) && 
								   file_exists('./uploads/level/'.$intermediateLvlImg)) {
									@unlink('./uploads/level/'.$intermediateLvlImg);
								}	

								echo json_encode(array('check'=>'failure','msg'=>$error));
								exit; 

							} else {
								$data = $this->upload->data();
								$advanceLvlData['image'] = $data['file_name'];
							}
						 }else{
						 	$advanceLvlData['image'] = $oldAdvLvlImage;
						 }

						 if ($oldAdvLvlImage && $_FILES['courseImage_advanced']['name'] != '') {
							if (file_exists('./uploads/level/'.$oldAdvLvlImage)) {
								@unlink('./uploads/level/'.$oldAdvLvlImage);
							}
						 }

					 	//Insert data into db
	          	       	$this->mymodel->save('course_level_details', $advanceLvlData);  
	          	     }else{
				        echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
					   exit;	 	
				     }      	
          	     }else{
			        if($this->input->post('lvl_dsiply_status_advanced') == "1"){
				    	  echo json_encode(array('check'=>'failure','msg'=>'Some fields are incomplete on advanced level.'));
				    	  exit;	
				   }	
			     }    
				

				if ($this->db->trans_status() === FALSE)
		          {
		            	
		            	$this->db->trans_rollback();	
							 
					//Removing course image from server
					$courseImg = $mydata['image'];
					if (!empty($_FILES['courseImage']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
						@unlink('./uploads/courses/'.$courseImg);
					}
					 
					//Removing course beginner level image from server
					$beginnerLvlImg = $beginnerLvlData['image'];
					if (!empty($_FILES['courseImage_beginner']['name']) && 
					   file_exists('./uploads/level/'.$beginnerLvlImg)) {
						@unlink('./uploads/level/'.$beginnerLvlImg);
					}	

					//Removing course intermediate level image from server
					$intermediateLvlImg = $interLvlData['image'];
					if (!empty($_FILES['courseImage_intermediate']['name']) && 
					   file_exists('./uploads/level/'.$intermediateLvlImg)) {
						@unlink('./uploads/level/'.$intermediateLvlImg);
					}	

					//Removing course advanced level image from server
					$advancedLvlImg = $interLvlData['image'];
					if (!empty($_FILES['courseImage_advanced']['name']) && 
					   file_exists('./uploads/level/'.$advancedLvlImg)) {
						@unlink('./uploads/level/'.$advancedLvlImg);
					}	

		            	echo json_encode(array('check'=>'success','msg'=>'Some error occured, Please try again!')); 
		            }else
		            {
		            	$this->db->trans_commit();
		            	echo json_encode(array('check'=>'success','msg'=>'Course has been successfully updated!','courseId'=>$courseId)); 
		            }
			
	          }
	     }     	
	}

	public function deleteCourse($courseId = false)
	{
		if ($courseId != false) {

			$where = array('courseId' => $courseId);
			$data = $this->mymodel->get_by('courses', true, $where);

			if (!$this->mymodel->delete('courses', $where)) 
			{
				$msg = 'error';

			} else {

				$this->mymodel->delete('course_chapters', ['courseId'=>$courseId]);
				
				if (@$data->image && file_exists('./uploads/courses/'.@$data->image)) {
					@unlink('./uploads/courses/'.@$data->image);
				}

				$sql_cld= "SELECT cld.* FROM `course_level_details` cld WHERE cld.courseId='".$courseId."'";
				//echo $sql_cld;exit;
				$courseLvlList=  $this->mymodel->fetch($sql_cld, false); 

				foreach ($courseLvlList as $key => $lvl) {
					if (@$lvl->image && file_exists('./uploads/level/'.@$lvl->image)) {
						@unlink('./uploads/level/'.@$lvl->image);
					}
				}

				$this->mymodel->delete('course_level_details', ['courseId'=>$courseId]);

				$this->mymodel->delete('course_instructors', ['courseId'=>$courseId]);

				$msg = '["Course is deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(base_url('instructor/my-created-course'),'refresh');
	}

	public function studentlist()
	{
		$data['title'] = "Student List";
		$data['page'] = "studentlist";
		$data['subpage'] = null;

		$userId = $this->session->userdata('userId');
		
		$sql_enrolled_students = "SELECT c.courseId,c.courseName,sbc.courseLvl,u.userId,u.firstName,u.lastName,u.email,u.profilePic as profile_pic,u.created,sct.conferenceId,sct.meeting_url,sct.passcode FROM student_booked_classes sbc LEFT JOIN users u ON ( sbc.studentId = u.userId AND u.userType = '1' ) LEFT JOIN courses c ON (sbc.courseId = c.courseId) LEFT JOIN session_conference_tbl sct ON ( sbc.studentId = sct.studentId AND sbc.instructorId = sct.instructorId AND sbc.courseId = sct.courseId AND sbc.courseLvl = sct.courseLvl ) WHERE sbc.instructorId = '".$userId."' GROUP BY sbc.studentId,sbc.courseLvl ORDER BY sbc.classId";  

	 	//echo $sql_enrolled_students;exit;

	    //Feching Enrolled Course List 
	 	$data['studentData'] = $this->mymodel->fetch($sql_enrolled_students, false);

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/student_list');
		$this->load->view('instructor/footer');
	}

	public function createSchedule()
	{  
		$userId = $this->session->userdata('userId');

		$data['title'] = "Manage Your Schedule";
		$data['page'] = "calendar";
		$data['subpage'] = "manageschedule";
		//Fetching Schedule Times for Current Instructor
		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$userId."'";
		
		$data['scheduleTime'] = $this->mymodel->fetch($sql_schedule_time, true);
		//$data['scheduleTime'] = array();

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/manage_schedule');
		$this->load->view('instructor/footer');
	}

	public function saveSchedule()
	{
		//print_r($_POST);exit;

		$this->db->trans_begin();

		$instructorId = $this->session->userdata('userId');

		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";

		$currentScheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

		//print_r($scheduleTime);exit;

		$allowedDayArr = explode(',', $currentScheduleTime->weekdays);
		$fromTime = $currentScheduleTime->fromTime;
		$toTime = $currentScheduleTime->toTime;

		$scheduleTime = $this->input->post('scheduleTime');
		$weekdays = $this->input->post('weekdays');

		$lastFromTime = $this->input->post('lastFromTime');
		$lastToTime = $this->input->post('lastToTime');

		$existededDates = array();
		$removedDates = array();
		$newDates = array();

		$colidedDates = array();
		
		foreach ($allowedDayArr as $index => $allowedDay) {
			 if(in_array($allowedDay,$weekdays)){
			 	 $existededDates[$index] = $allowedDay;
			 }

			 elseif(!in_array($allowedDay,$weekdays)){
			 	 $removedDates[$index] = $allowedDay;
			 }
		}

		//print_r($existededDates);

		$combinedDates = array_merge($weekdays,$removedDates);
		$newDates = array_diff($combinedDates, $allowedDayArr);

		$newScheduleDates = array_merge($existededDates,$newDates);

		//print_r($combinedDates);
		//print_r($newScheduleDates);exit;
      
		$sql_all_student_booked_class = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,sbc.timezone,c.courseId,c.courseName,u.userId as studentId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.email,CONCAT(i.firstName,' ',i.lastName) as instructorName FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.instructorId = '".$instructorId."'";

		//echo $sql_all_student_booked_class;exit;
			
		$bookedClassDetail = $this->mymodel->fetch($sql_all_student_booked_class, false);

		//print_r($bookedClassDetail);exit;

		$colidedDays = array();

      foreach ($bookedClassDetail as $key => $class) {
      	
      	$classDate = $class->classDate;

      	$day = date('l',strtotime($classDate));
      	$booked_timezone = $class->timezone;
      	
      	if(in_array($day, $removedDates) && strtotime($class->classDate)>time()){
      		$colidedDates[$key]['courseId'] = $class->courseId;
            $colidedDates[$key]['instructorName'] = $class->instructorName;
            $colidedDates[$key]['studentId'] = $class->studentId; 
            $colidedDates[$key]['studentName'] = $class->studentName; 
            $colidedDates[$key]['studentEmail'] = $class->email; 
            $colidedDates[$key]['studentName'] = $class->studentName; 
            $colidedDates[$key]['courseName'] = $class->courseName; 
            $colidedDates[$key]['courseLvl'] = ucfirst($class->courseLvl); 
            $colidedDates[$key]['day'] = $day;
            $colidedDates[$key]['timezone'] = $booked_timezone;
            $colidedDates[$key]['classId'] = $class->classId;
            $colidedDates[$key]['date'] = $class->classDate;
            $colidedDates[$key]['fromTime'] = $class->fromTime; 
            $colidedDates[$key]['toTime'] = $class->toTime; 
            $colidedDays[$key] = $day;
      	}
      }

      //Ordering the index of the date array
      $colidedDates = array_values($colidedDates);
      $colidedDayStr = implode(',',array_unique($colidedDays));

      //print_r($colidedDates);exit;

      if(!empty($colidedDates)){
	      $data['colidedDateArr'] = $colidedDates;
	      $colidedDateTable = $this->load->view('instructor/collided_dates_ajax',$data,true);
         //Saving collided day data into array into session
         $this->session->set_userdata('colidedDays',$colidedDayStr);
         $this->session->set_userdata('colidedDates',$colidedDates);
      }else{
         foreach($removedDates as $index => $removeDay){
	      	//Deleting class day from schedule calendar
				$where_delete_schedule = array('instructorId' => $instructorId,'weekday'=>$removeDay);
				$this->mymodel->delete('instructor_schedule_time', $where_delete_schedule);
			}	
      }

      //print_r($newDates);exit;
      
      //Inserting new dates into calendar
		foreach($newDates as $index => $newday){
		 	 $mydata = array(
							 'instructorId' => $instructorId,
							 'weekday' => $newday,
							 'fromTime' =>date('H:i',strtotime($scheduleTime['fromTime'])),
							 'toTime' => date('H:i',strtotime($scheduleTime['toTime'])),
							 'updated'=>date('Y-m-d H:i:s')
						  );

			//Insert schedule time data into db
		   $this->mymodel->save('instructor_schedule_time', $mydata);
		}

		//Checking new timing for existing dates
      $newFromTime = $scheduleTime['fromTime'];
      $newToTime = $scheduleTime['toTime'];

      if(strtotime($fromTime) != strtotime($newFromTime) || strtotime($toTime) != strtotime($newToTime)){

      	 if(!empty($bookedClassDetail)){
	      	 //Informing students about updated time into calendar
				 foreach ($bookedClassDetail as $key => $class) {
		      	$day = date('l',strtotime($class->classDate));

		      	$ADMIN_NAME = $this->config->item('ADMIN_NAME');
			      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
			      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

					$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
					$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
					$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

		      	$data['title'] = 'Student Course Timing Notify Email';
		      	
		      	if(in_array($day, $existededDates)){
		            $swap_var['instructor_name'] = $class->instructorName;
		            $swap_var['student_name'] = $class->studentName;
						$swap_var['course_name'] = $class->courseName;
						$swap_var['class_date'] = date('jS F, Y',strtotime($class->classDate));
						$swap_var['course_level'] = ucfirst($class->courseLvl);
						$swap_var['new_from_time'] = date('g:i A', strtotime($scheduleTime['fromTime']));
						$swap_var['new_to_time'] = date('g:i A', strtotime($scheduleTime['toTime']));
						$swap_var['current_from_time'] = date('g:i A', strtotime($lastFromTime));
						$swap_var['current_end_time'] = date('g:i A', strtotime($lastToTime));
						$swap_var['business_address'] = $BUSINESS_ADDRESS;
						$swap_var['business_phone'] = $BUSINESS_PHONE;
						$swap_var['business_email'] = $BUSINESS_EMAIL;

						$tepmlateBody = $this->load->view('email_template/course_timing_notify',$data,true);

						//echo $tepmlateBody."<br>";

				      foreach (array_keys($swap_var) as $key){
				         if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
				           $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
				         }
				      }

				      $emailParamArr['sender_name'] = $ADMIN_NAME;
				      $emailParamArr['sender_email'] = $ADMIN_MAIL;
				      $emailParamArr['receiver_name'] = $class->studentName;
				      $emailParamArr['receiver_email'] = $class->email;
				      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
				      $emailParamArr['email_subject'] = 'Student Course Timing Notify Email';
				      $emailParamArr['email_template'] = $tepmlateBody;

						//Sending mail using pre-defined method 
						$this->send_mail($emailParamArr);
	               
	               foreach ($newScheduleDates as $key => $day) {
				    	 	 //Updating existing dates schedule time 
						 	 $where_update_schedule = array('instructorId' => $instructorId,'weekday'=>$day);

							 $scheduleData = array(
													 'fromTime' =>date('H:i',strtotime($scheduleTime['fromTime'])),
													 'toTime' => date('H:i',strtotime($scheduleTime['toTime'])),
													 'updated'=>date('Y-m-d H:i:s')
												  );
		               
		                //Running query to update class time
							 $this->mymodel->update($scheduleData,'instructor_schedule_time',$where_update_schedule);
				    	}
		      	}
		       }
		    }else{
		    	 foreach ($newScheduleDates as $key => $day) {
		    	 	 //Updating existing dates schedule time 
				 	 $where_update_schedule = array('instructorId' => $instructorId,'weekday'=>$day);

					 $scheduleData = array(
											 'fromTime' =>date('H:i',strtotime($scheduleTime['fromTime'])),
											 'toTime' => date('H:i',strtotime($scheduleTime['toTime'])),
											 'updated'=>date('Y-m-d H:i:s')
										  );
               
                //Running query to update class time
					 $this->mymodel->update($scheduleData,'instructor_schedule_time',$where_update_schedule);
		    	 }
		    }   
      }

      if ($this->db->trans_status() === FALSE)
		{
		   $this->db->trans_rollback();
		   echo json_encode(array('check'=>'failure'));    
		}
		else
		{
		   $this->db->trans_commit();

		   if(!empty($colidedDateTable)){
				echo json_encode(array('check'=>'success','tableHtml'=>$colidedDateTable));
			}else{
				echo json_encode(array('check'=>'success'));
			}
		}

	}

	public function cancelBulkClasses(){
		$colidedDates = $this->session->userdata('colidedDates');

		$instructorId = $this->session->userdata('userId');

		$data['title'] = 'Notify student about class cancellation';

		//print_r($colidedDates);exit;
      
      $this->db->trans_begin();

      $ADMIN_NAME = $this->config->item('ADMIN_NAME');
      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

      foreach ($colidedDates as $key => $class) {

      	$where_delete_class = array('classId' => $class['classId']);
         
         //Deleting student class
      	$this->mymodel->delete('student_booked_classes', $where_delete_class);

			$swap_var['instructor_name'] = $class['instructorName'];
	      $swap_var['student_name'] = $class['studentName'];
			$swap_var['course_name'] = $class['courseName'];
			$swap_var['class_date'] = date('jS F, Y',strtotime($class['date']));
			$swap_var['course_level'] = ucfirst($class['courseLvl']);
			$swap_var['from_time'] = date('H:i A', strtotime($class['fromTime']));
			$swap_var['to_time'] = date('H:i A', strtotime($class['toTime']));
			$swap_var['business_address'] = $BUSINESS_ADDRESS;
			$swap_var['business_phone'] = $BUSINESS_PHONE;
			$swap_var['business_email'] = $BUSINESS_EMAIL;

			$tepmlateBody = $this->load->view('email_template/student_cancel_class_notify',$data,true);

			//echo $tepmlateBody."<br>";

	      foreach (array_keys($swap_var) as $key){
	         if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
	           $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
	         }
	      }

	      $emailParamArr['sender_name'] = $ADMIN_NAME;
	      $emailParamArr['sender_email'] = $ADMIN_MAIL;
	      $emailParamArr['receiver_name'] = $class['studentName'];
	      $emailParamArr['receiver_email'] = $class['studentEmail'];
	      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
	      $emailParamArr['email_subject'] = 'Notify student class cancellation';
	      $emailParamArr['email_template'] = $tepmlateBody;

			//Deleting class day from schedule calendar
			$where_delete_schedule = array('instructorId' => $instructorId,'weekday'=>$class['day']);

			if($this->mymodel->delete('instructor_schedule_time', $where_delete_schedule)){
				//Sending mail using pre-defined method 
				$this->send_mail($emailParamArr);
			}
		}	

		if ($this->db->trans_status() === FALSE)
		{
		   $this->db->trans_rollback();

		   echo json_encode(array('check'=>'failure'));
		}
		else
		{
		   $this->db->trans_commit();

		   //Reseting calendar modification data from session
			$this->session->unset_userdata('colidedDays');
			$this->session->unset_userdata('colidedDates');

			echo json_encode(array('check'=>'success'));
		}
	}

	public function resetCalendarData(){
		//Reseting calendar modification data from session
		$this->session->unset_userdata('colidedDays');
		$this->session->unset_userdata('colidedDates');
      
      echo json_encode(array('check'=>'success')); 
	}

	public function addScheduleDate()
	{
		$data['title'] = "Add Schedule";
		$data['page'] = "calendar";
		$data['subpage'] = "addschedule";

		$data['sch']=$this->mymodel->GetData('instructor_schedule');
		// echo "<pre>";print_r($data);die;
		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/add_schedule_date');
		$this->load->view('instructor/footer');
	}

	public function add_sch_date(){
		echo "<pre>";print_r($_POST);die;
	}

	public function profile()
	{
		$data['title'] = "My Profile";	
		$data['page'] = "profilesetting";
		$data['subpage'] = null;

		$userId=$this->session->userdata('userId');
		$data['myInfo']= $this->mymodel->get('users', true, 'userId', $userId);
		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/profile');
		$this->load->view('instructor/footer');
	}

	public function updateConferenceLink(){
		//print_r($_POST);exit;
		$instructorId = $this->session->userdata('userId');
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$studentId = $this->input->post('studentId');
		$meeting_url = $this->input->post('meeting_url');
		$passcode = $this->input->post('passcode');

		$conferenceId = $this->input->post('conferenceId');

		//Saving query data into db
		$conferenceData = array(
            'studentId'=>$studentId,
            'courseId'=>$courseId,
            'courseLvl'=>$courseLvl,
            'instructorId'=>$instructorId,
            'meeting_url'=>$meeting_url,
            'passcode'=>$passcode,
            'created'=> date('Y-m-d H:i:s')
		);

		if(!empty($conferenceId)){
            $where_conference_clause = array('conferenceId' => $conferenceId);
           //Updating conference data into db	
           if(!$this->mymodel->update($conferenceData,'session_conference_tbl',$where_conference_clause)){
              echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));  
           }else{
              echo json_encode(array('check'=>'success','msg'=>'Conference Link is successfully updated.'));
           }
		}else{
           if(!$this->mymodel->save('session_conference_tbl', $conferenceData)){
			   echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));
		   }else{
		      $last_query_id = $this->db->insert_id();
			  echo json_encode(array('check'=>'success','msg'=>'Conference Link is successfully created.'));
		   } 
		}
	}

	
	public function fetchSchedule($fetchType)
	{
		$instructorId = $this->session->userdata('userId');
		//$fetchType = $this->input->post('fetchType');

		$sql_ins_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName,u.timezone FROM users u WHERE u.userId='".$instructorId."' AND u.userType='2'";

		$instructorDetail = $this->mymodel->fetch($sql_ins_details, true);

		$ins_time_zone = $instructorDetail->timezone;

		$fetchType = "current";

		$sql_all_booked_class = "SELECT sbc.classId,sbc.classDate,sbc.timezone,c.courseName,sbc.courseLvl,u.firstName,u.lastName FROM student_booked_classes sbc LEFT JOIN courses c ON ( sbc.courseId = c.courseId ) LEFT JOIN users u ON ( sbc.studentId = u.userId ) WHERE sbc.instructorId = '".$instructorId."'";

		//echo $sql_all_booked_class;exit;
        
    	$bookedClassData = $this->mymodel->fetch($sql_all_booked_class, false);

		$bookedClassArr = [];
        
    	if(!empty($bookedClassData)){
		
			foreach ($bookedClassData as $key => $class) {
				$bookedClassArr[$key] = $class->classDate;
			}
		}
        
      $list=array();

      //$scheduleBgColorCdArr = array('#44760f','#ff0000','#d816c7','#102ce9','#044f16','#950202','#6e0769','#723c03','#000000');

      $sql_stu_last_booking_date = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE `instructorId`='".$instructorId."' ORDER BY classDate ASC LIMIT 1";

    	$lastBookedClassData = $this->mymodel->fetch($sql_stu_last_booking_date, true);

      $current_date = date('Y-m-d');
      $compare_date = date('Y-m-d');
		
		if($fetchType == "current"){

			if(!empty($lastBookedClassData) && $lastBookedClassData->classDate <= $compare_date){
				$last_date = $lastBookedClassData->classDate;
				$day = date('d',strtotime($last_date));
				$month = date('m',strtotime($last_date));
				$year = date('Y',strtotime($last_date));
			}else{
				$day = date('d',strtotime('+1 days',strtotime($current_date)));
				$month = date('m',strtotime('+1 days',strtotime($current_date)));
				$year = date('Y',strtotime('+1 days',strtotime($current_date)));
			}	
         $start_date = date('Y-m-d',strtotime('+1 days',strtotime($current_date)));
		}

		else if($fetchType == "next"){
			$nxt_month_date = date('Y-m-d', strtotime('first day of next month'));
			$day = date('d', strtotime('first day of next month'));
			$month = date('m', strtotime('first day of next month'));
			$year = date('Y',strtotime('first day of next month'));

			$start_date = date('Y-m-d',strtotime('+1 days',strtotime($nxt_month_date)));
		}

		else if($fetchType == "previous"){
			$prev_month_date = date('Y-m-d', strtotime('first day of previous month'));
			$day = date('d', strtotime('first day of previous month'));
			$month = date('m', strtotime('first day of previous month'));

			$start_date = date('Y-m-d',strtotime('+1 days',strtotime($prev_month_date)));
		}
		
		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";
		
		$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

		//print_r($scheduleTime);exit;

		$date = date('Y-m-d');

		$tday = date('d', strtotime($date));
      $tmonth = date('m', strtotime($date));
		$tyear = date('Y', strtotime($date));

		$allowedDayArr = explode(',', $scheduleTime->weekdays);
		$fromTime = $scheduleTime->fromTime;
		$toTime = $scheduleTime->toTime;
		
		$index = 0;
        
      for($m = $month; $m<=12; $m++){ 

        	$current_day = $day;
		   $current_month = $m;
		   $current_year = $year; 

			$currentMonthDays = cal_days_in_month(CAL_GREGORIAN, $m, $year);
			
			for($d=$day; $d<=$currentMonthDays; $d++){

			    $time=strtotime($year.'-'.$m.'-'.$d);    
			    $current_day = date('l', $time);
			    $current_full_date = date('Y-m-d',$time);
			    //Shuffling color code array for random color
			    //shuffle($scheduleBgColorCdArr);

			    if (date('m', $time)==$m && in_array($current_day,$allowedDayArr)){    

			        $position = array_search($current_full_date, $bookedClassArr);   
			        
			        $list[$index]['id'] = $index; 
			        $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
			        $list[$index]['date']=date('Y-m-d', $time); 
			        $list[$index]['times'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
			        $list[$index]['allDay'] = true;
			        $list[$index]['start']=date('Y-m-d', $time).'T'.$fromTime;
			        $list[$index]['end']=date('Y-m-d', $time).'T'.$toTime;
		           $list[$index]['constraint'] = "Available";

                 if(!empty($bookedClassArr) && in_array($current_full_date,$bookedClassArr)){

                 	  $list[$index]['courseName'] = $bookedClassData[$position]->courseName;
				        $list[$index]['courseLvl'] = ucfirst($bookedClassData[$position]->courseLvl);
				        $list[$index]['student'] = $bookedClassData[$position]->firstName." ".$bookedClassData[$position]->lastName;

	                 $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
						  $list[$index]['className'] = "show-schedule-info";
						  $list[$index]['checkboxId'] = "class_".$index;
		              $list[$index]['url'] = 'javascript:void(0)';


					  	  if($current_full_date>=$start_date){
							  $list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
							  $list[$index]['booking_status'] = "booked";
							  $list[$index]['expiry_status'] = false;
							  $list[$index]['modify_permission'] = false;
							  $list[$index]['classId'] = $bookedClassData[$position]->classId;
							  $list[$index]['classDate'] = $bookedClassData[$position]->classDate;
						  }else{
							  $list[$index]['color'] = "#B6B40F";
					        $list[$index]['booking_status'] = "booked";
					        $list[$index]['expiry_status'] = true;
					        $list[$index]['modify_permission'] = false;
							  $list[$index]['classId'] = $bookedClassData[$position]->classId;
							  $list[$index]['classDate'] = $bookedClassData[$position]->classDate;
						  }	 	
					  }else{
					  	  if($current_full_date>=$start_date){
						  	  $list[$index]['color'] = "#0071dc";
						  	  $list[$index]['booking_status'] = "available";
						  	  $list[$index]['expiry_status'] = false;
				           $list[$index]['modify_permission'] = false;
                    }else{
                    	  $list[$index]['color'] = "#ea2f2f";
						  	  $list[$index]['booking_status'] = "expired";
						  	  $list[$index]['expiry_status'] = true;
				           $list[$index]['modify_permission'] = false;
                    }
					  }	  

					  $index++;
			    }   

			    if($d == $currentMonthDays){
				   $day = date('d', strtotime('first day of next month',strtotime($current_full_date)));
				 } 
			}

			if( ($m == 12 && $year < $tyear) || ($tmonth < 12 && $tyear == $year) ){
			    $m = date('m', strtotime('first day of next month', strtotime($current_full_date)));
			    $year = date("Y", strtotime('first day of next month', strtotime($current_full_date)));

			    $m = $m-1;
			} 
		}	
        
  		echo json_encode($list);
		
	}

	public function viewClasses(){
      $data['title'] = "View Booked CLasses";	
		$data['page'] = "viewclasses";
		$data['subpage'] = null;

		$userId=$this->session->userdata('userId');

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/view_classes');
		$this->load->view('instructor/footer');
	}

	public function viewBookedClasses_bak()
	{
		
		$data['title'] ='My Booked CLasses';
		$data['page'] = "viewclasses";
    
	    $userId = $this->session->userdata('userId');

	    $sql_all_booked_class = "SELECT c.courseName,sbc.courseLvl,u.firstName,u.lastName FROM users u LEFT JOIN courses ON ( sbc.courseId = c.courseId ) LEFT JOIN users u ON ( sbc.studentId = u.userId ) WHERE sbc.userId = '".$userId."'";

	    $bookedClassData = $this->mymodel->fetch($sql_studensql_all_booked_classt_all_booked_season, false);

	    if((!empty($bookedInsData)?($bookedInsData[0]->instructorId == $insId ? true:false) : true)){
			$this->load->view('student/header',$data);
			$this->load->view('student/view_booked_session');
			$this->load->view('student/footer');
		}else{
        	redirect('student/instructor/'.$courseId.'/'.$courseLvl); 
		}		
	}

	public function viewBookedClasses()
	{

		$userId = $this->session->userdata('userId'); 

		$sql_all_booked_class = "SELECT sbc.classId,sbc.classDate,c.courseName,sbc.courseLvl,u.firstName,u.lastName FROM student_booked_classes sbc LEFT JOIN courses c ON ( sbc.courseId = c.courseId ) LEFT JOIN users u ON ( sbc.studentId = u.userId ) WHERE sbc.instructorId = '".$userId."'";

		//echo $sql_all_booked_class;exit;
        
    	$bookedClassData = $this->mymodel->fetch($sql_all_booked_class, false);

		$bookedClassArr = [];
        
    	if(!empty($bookedClassData)){
		
			foreach ($bookedClassData as $key => $class) {
				$bookedClassArr[$key] = $class->classDate;
			}
		}

    	$list=array();
				
		$sql_stu_last_booking_date = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE `instructorId`='".$userId."' ORDER BY classDate ASC LIMIT 1";

    	$lastBookedClassData = $this->mymodel->fetch($sql_stu_last_booking_date, true);

    	$compare_date = date('Y-m-d');
    	$current_date = date('Y-m-d');

		if(!empty($lastBookedClassData) && $lastBookedClassData->classDate <= $compare_date){
			$last_date = $lastBookedClassData->classDate;
			$day = date('d',strtotime($last_date));
			$month = date('m',strtotime($last_date));
			$year = date('Y',strtotime($last_date));
		}else{
			$day = date('d',strtotime('+1 days',strtotime($current_date)));
			$month = date('m');
			$year = date('Y');
		}	

		$start_date = date('Y-m-d',strtotime('+1 days',strtotime($current_date)));

		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$userId."'";
		
		$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

		//print_r($scheduleTime);exit;

		$date = date('Y-m-d');

		$tday = date('d', strtotime($date));
      $tmonth = date('m', strtotime($date));
		$tyear = date('Y', strtotime($date));

		$allowedDayArr = explode(',', $scheduleTime->weekdays);
		$fromTime = $scheduleTime->fromTime;
		$toTime = $scheduleTime->toTime;
		
		$index = 0;
        
    	for($m = $month; $m<=12; $m++){ 

			$current_day = $day;
			$current_month = $m;
			$current_year = $year;

	  		$currentMonthDays = cal_days_in_month(CAL_GREGORIAN, $m, $year);
			
			for($d=$current_day; $d<=$currentMonthDays; $d++){

			    $time=strtotime($current_year.'-'.$current_month.'-'.$d);   
			    $index_day = date('l', $time);
			    $current_full_date = date('Y-m-d',$time);

			    $list[$index]['allDay'] = true;

			    if (date('m', $time)==$current_month && in_array($index_day,$allowedDayArr)){     

					if(!empty($bookedClassArr) && in_array($current_full_date,$bookedClassArr)){
						 $position = array_search($current_full_date, $bookedClassArr); 

	               	$list[$index]['id'] = $index; 
				         $list[$index]['constraint'] = "Available";
				         $list[$index]['date']=date('Y-m-d', $time);

				         //Extended property for event data
				         $list[$index]['courseName'] = $bookedClassData[$position]->courseName;
				         $list[$index]['courseLvl'] = ucfirst($bookedClassData[$position]->courseLvl);
				         $list[$index]['student'] = $bookedClassData[$position]->firstName." ".$bookedClassData[$position]->lastName;

	                  $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
						 	$list[$index]['className'] = "show-schedule-info";
						 	$list[$index]['checkboxId'] = "class_".$index;
		             	$list[$index]['url'] = 'javascript:void(0)';
						 	
						 	if($current_full_date>=$start_date){
							 	$list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
							 	$list[$index]['booking_status'] = "booked";
							 	$list[$index]['expiry_status'] = false;
							 	$list[$index]['modify_permission'] = true;
							 	$list[$index]['classId'] = $bookedClassData[$position]->classId;
							 	$list[$index]['classDate'] = $bookedClassData[$position]->classDate;
							}else{
							   $list[$index]['color'] = "#B6B40F";
					         $list[$index]['booking_status'] = "booked";
					         $list[$index]['expiry_status'] = true;
					         $list[$index]['modify_permission'] = false;
							 	$list[$index]['classId'] = $bookedClassData[$position]->classId;
							 	$list[$index]['classDate'] = $bookedClassData[$position]->classDate;
							}	 	
					}
					  
					$index++;
				}   

				if($d == $currentMonthDays){
				   $day = date('d', strtotime('first day of next month',strtotime($current_full_date)));
				} 
			}

			if( ($m == 12 && $year < $tyear) || ($tmonth < 12 && $tyear == $year) ){
			    $m = date('m', strtotime('first day of next month', strtotime($current_full_date)));
			    $year = date("Y", strtotime('first day of next month', strtotime($current_full_date)));

			    $m = $m-1;
			}
	  }	
        
  	  echo json_encode($list);
		
	}

    public function showStudentSchedule($courseId,$courseLvl,$studentId){
        $data['title'] = "View Student Booked CLasses";	
		$data['page'] = "viewclasses";
		$data['subpage'] = null;

		$data['studentId']=$studentId;
		$data['courseId']=$courseId;
		$data['courseLvl']=$courseLvl;

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/view_student_classes');
		$this->load->view('instructor/footer');
	}

	public function viewStudentBookedClasses($courseId,$courseLvl,$studentId)
	{

		$userId = $this->session->userdata('userId'); 

		$sql_all_booked_class = "SELECT sbc.classId,sbc.classDate,c.courseName,sbc.courseLvl,u.firstName,u.lastName FROM student_booked_classes sbc LEFT JOIN courses c ON ( sbc.courseId = c.courseId ) LEFT JOIN users u ON ( sbc.studentId = u.userId ) WHERE sbc.studentId = '".$studentId."' AND sbc.courseId = '".$courseId."' AND sbc.courseLvl = '".$courseLvl."' AND sbc.instructorId = '".$userId."'";

		//echo $sql_all_booked_class;exit;
        
    	$bookedClassData = $this->mymodel->fetch($sql_all_booked_class, false);

		$bookedClassArr = [];
        
    	if(!empty($bookedClassData)){
		
			foreach ($bookedClassData as $key => $class) {
				$bookedClassArr[$key] = $class->classDate;
			}
		}

    	$list=array();
		
		$sql_stu_last_booking_date = "SELECT sbc.classDate FROM student_booked_classes sbc WHERE `instructorId`='".$userId."' ORDER BY classDate ASC LIMIT 1";

    	$lastBookedClassData = $this->mymodel->fetch($sql_stu_last_booking_date, true);

    	$compare_date = date('Y-m-d');
    	$current_date = date('Y-m-d');

		if(!empty($lastBookedClassData) && $lastBookedClassData->classDate <= $compare_date){
			$last_date = $lastBookedClassData->classDate;
			$day = date('d',strtotime($last_date));
			$month = date('m',strtotime($last_date));
			$year = date('Y',strtotime($last_date));
		}else{
			$day = date('d',strtotime('+1 days',strtotime($current_date)));
			$month = date('m');
			$year = date('Y');
		}	

		$start_date = date('Y-m-d',strtotime('+1 days',strtotime($current_date)));
		
		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$userId."'";
		
		$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

		//print_r($scheduleTime);exit;

		$date = date('Y-m-d');

		$tday = date('d', strtotime($date));
		$tmonth = date('m', strtotime($date));
		$tyear = date('Y', strtotime($date));

		$allowedDayArr = explode(',', $scheduleTime->weekdays);
		$fromTime = $scheduleTime->fromTime;
		$toTime = $scheduleTime->toTime;
		
		$index = 0;
        
    	for($m = $month; $m<=12; $m++){ 

		   $current_day = $day;
		   $current_month = $m;
		   $current_year = $year;

 		   $currentMonthDays = cal_days_in_month(CAL_GREGORIAN, $m, $year);

			for($d=$current_day; $d<=$currentMonthDays; $d++){

			    $time=strtotime($current_year.'-'.$current_month.'-'.$d);  
			    $index_day = date('l', $time);
			    $current_full_date = date('Y-m-d',$time);

			    $list[$index]['allDay'] = true;

			    if (date('m', $time)==$current_month && in_array($index_day,$allowedDayArr)){     

					if(!empty($bookedClassArr) && in_array($current_full_date,$bookedClassArr)){
					 	$position = array_search($current_full_date, $bookedClassArr); 

               	$list[$index]['id'] = $index; 
			         $list[$index]['constraint'] = "Available";
			         $list[$index]['date']=date('Y-m-d', $time);

			         //Extended property for event data
			         $list[$index]['courseName'] = $bookedClassData[$position]->courseName;
			         $list[$index]['courseLvl'] = ucfirst($bookedClassData[$position]->courseLvl);
			         $list[$index]['student'] = $bookedClassData[$position]->firstName." ".$bookedClassData[$position]->lastName;

                  $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
					 	$list[$index]['className'] = "show-schedule-info";
					 	$list[$index]['checkboxId'] = "class_".$index;
	             	$list[$index]['url'] = 'javascript:void(0)';

	             	if($current_full_date>=$start_date){
						 	$list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
						 	$list[$index]['booking_status'] = "booked";
						 	$list[$index]['expiry_status'] = false;
						 	$list[$index]['modify_permission'] = true;
						 	$list[$index]['classId'] = $bookedClassData[$position]->classId;
						 	$list[$index]['classDate'] = $bookedClassData[$position]->classDate;
						}else{
						   $list[$index]['color'] = "#B6B40F";
				         $list[$index]['booking_status'] = "booked";
				         $list[$index]['expiry_status'] = true;
				         $list[$index]['modify_permission'] = false;
						 	$list[$index]['classId'] = $bookedClassData[$position]->classId;
						 	$list[$index]['classDate'] = $bookedClassData[$position]->classDate;
						}	 	
					}
					  
					$index++;
				}    

				if($d == $currentMonthDays){
				   $day = date('d', strtotime('first day of next month',strtotime($current_full_date)));
				}
			}

			if( ($m == 12 && $year < $tyear) || ($tmonth < 12 && $tyear == $year) ){
			    $m = date('m', strtotime('first day of next month', strtotime($current_full_date)));
			    $year = date("Y", strtotime('first day of next month', strtotime($current_full_date)));

			    $m = $m-1;
			}
	  }	
        
  	  echo json_encode($list);
	}

	public function cancelStudentClass(){
		$classId = $this->input->post('classId');
		$where_del_booked_class = array('classId' => $classId);

		$sql_class_details = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,c.courseId,c.courseName,u.userId as studentId,i.userId as instructorId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.email,CONCAT(i.firstName,' ',i.lastName) as instructorName FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.classId = '".$classId."'";

		$bookedClassDetails = $this->mymodel->fetch($sql_class_details, true);

		$bookedClassDetailArr = json_decode(json_encode($bookedClassDetails),true);

		$ADMIN_NAME = $this->config->item('ADMIN_NAME');
      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

		$data['title'] = 'Notify student about class cancellation';

		$swap_var['instructor_name'] = $bookedClassDetailArr['instructorName'];
      $swap_var['student_name'] = $bookedClassDetailArr['studentName'];
		$swap_var['course_name'] = $bookedClassDetailArr['courseName'];
		$swap_var['class_date'] = date('jS F, Y',strtotime($bookedClassDetailArr['classDate']));
		$swap_var['course_level'] = ucfirst($bookedClassDetailArr['courseLvl']);
		$swap_var['from_time'] = date('H:i A', strtotime($bookedClassDetailArr['fromTime']));
		$swap_var['to_time'] = date('H:i A', strtotime($bookedClassDetailArr['toTime']));
		$swap_var['business_address'] = $BUSINESS_ADDRESS;
		$swap_var['business_phone'] = $BUSINESS_PHONE;
		$swap_var['business_email'] = $BUSINESS_EMAIL;

		$tepmlateBody = $this->load->view('email_template/student_cancel_class_notify',$data,true);

		//echo $tepmlateBody."<br>";

      foreach (array_keys($swap_var) as $key){
         if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
           $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
         }
      }

      $emailParamArr['sender_name'] = $ADMIN_NAME;
      $emailParamArr['sender_email'] = $ADMIN_MAIL;
      $emailParamArr['receiver_name'] = $bookedClassDetailArr['studentName'];
      $emailParamArr['receiver_email'] = $bookedClassDetailArr['email'];
      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
      $emailParamArr['email_subject'] = 'Notify student about class cancellation';
      $emailParamArr['email_template'] = $tepmlateBody;

  	   //Delete schedule time data from db
      if($this->mymodel->delete('student_booked_classes', $where_del_booked_class)){
      	//Sending mail
      	$this->send_mail($emailParamArr);
       	echo json_encode(array('check'=>'success','msg'=>'Class was successfully cancelled.'));
	   }else{
	   	echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
	   }
	}

	public function scheduleclasses()
	{
		$data['title'] ='My Schedule CLasses';
		$data['page'] = "calendar";
		$data['subpage'] = "viewschedule";

		$this->load->view('instructor/header',$data);
		$this->load->view('instructor/schedule_calendar');
		$this->load->view('instructor/footer');
	}

	public function settings()
	{
		$data['title'] = "Settings";
		$data['page'] = "profilesetting";
		$data['subpage'] = null;

		//Fetch timezone list
		$sql_timezone_list = "SELECT * FROM timezone tz ORDER BY tz.country_code"; 
		//echo $sql_timezone_list;exit;
		$data['timezoneList'] = $this->mymodel->fetch($sql_timezone_list,false);

		$userId=$this->session->userdata('userId');
		$data['myInfo']= $this->mymodel->get('users', true, 'userId', $userId);

      $data['profileProgress'] = $this->checkProfileProgress($data['myInfo']);
		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/settings');
		$this->load->view('instructor/footer');
	}

	public function updateInfo()
	{  
		$paymentInfoArr = array();
		$userId=$this->session->userdata('userId');
		$userType=$this->input->post('userType');

		$courseId = $this->input->post('courseId');
		$profileProgress = (int) $this->input->post('profileProgress');

		if($profileProgress == 100){
			$updateStatus = 1;
		}else{
			$updateStatus = 0;
		}
      
      //Payement information configaration 
		$paymentInfoArr["bank_name"] = $this->input->post('bank_name');
		$paymentInfoArr["bank_address"] = $this->input->post('bank_address');
		$paymentInfoArr["ins_bank_name"] = $this->input->post('ins_bank_name');
		$paymentInfoArr["bank_acunt_no"] = $this->input->post('bank_acunt_no');
		$paymentInfoArr["routing_no"] = $this->input->post('routing_no');
		$paymentInfoArr["swift_code"] = $this->input->post('swift_code');

      $mydata = array(
						'firstName' => $this->testInput($this->input->post('firstName')),
						'lastName' => $this->testInput($this->input->post('lastName')),
						'email' =>$this->testInput($this->input->post('email')),
						'ccName' =>$this->testInput($this->input->post('ccName')),
						'ccCode' =>$this->testInput($this->input->post('ccCode')),
						'timezone' =>$this->testInput($this->input->post('timezone')),
						'origin_country' =>$this->testInput($this->input->post('origin_country')),
						'mobile' =>$this->testInput($this->input->post('mobile')),
						'descriptions' =>$this->testInput($this->input->post('descriptions')),
						'payment_info' => serialize($paymentInfoArr),
						'status' => 1,
						'created'=> date('Y-m-d H:i:s'),	
			 		 );

		$oldProfilePic = $this->input->post('oldProfilePic');

		if (!empty($_FILES['cover_photo']['name'])){		
            
          //upload an image options
	       $config = array();
	       $config['upload_path'] = './uploads/users/';
	       $config['allowed_types'] = 'gif|jpg|png';
	       $config['max_size'] = '20480';
		    $config['file_name'] = uniqid(); 

			//Loading upload library
			$this->load->library('upload'); 
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('cover_photo'))
			{
				$error = strip_tags($this->upload->display_errors());
				echo json_encode(array('check'=>'failure','msg'=>'Profile pic upload error; Please try again.'));
				die;
			} else {
				$data = $this->upload->data();
				$mydata['profilePic'] = $data['file_name'];
			}
		}else{
			$mydata['profilePic'] = $oldProfilePic;
		}

		$oldIntroVideo = $this->input->post('oldIntroVideo');
      
		if (!empty($_FILES['intro_video_file']['name']) && $this->input->post('upload_type') == 'local'){		
            
          //upload an image options
	       $config = array();
	       $config['upload_path'] = './uploads/users/';
	       $config['allowed_types'] = 'mp4|WMV|AVI|MKV';
	       $config['max_size'] = '204800';
		    $config['file_name'] = uniqid(); 

			//Loading upload library
			$this->load->library('upload'); 
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('intro_video_file'))
			{
				$error = strip_tags($this->upload->display_errors());
				echo json_encode(array('check'=>'failure','msg'=>'Introduction video upload error; Please try again.'));
				die;
			} else {
				$data = $this->upload->data();
				$mydata['intro_video'] = $data['file_name'];
			}
		}else{
			if(!empty($this->input->post('intro_video_yt'))){
				$mydata['intro_video'] = $this->input->post('intro_video_yt');
			}else{
				$mydata['intro_video'] = $oldIntroVideo;
			}
		}

		$oldInsCv = $this->input->post('oldInsCv');

		if (!empty($_FILES['cv']['name'])){		
            
          //upload an image options
	       $config = array();
	       $config['upload_path'] = './uploads/cv/';
	       $config['allowed_types'] = 'doc|docx';
	       $config['max_size'] = '20000';
		    $config['file_name'] = uniqid(); 

			//Loading upload library
			$this->load->library('upload'); 
			$this->upload->initialize($config);

			if ( ! $this->upload->do_upload('cv'))
			{
				$error = strip_tags($this->upload->display_errors());
				echo json_encode(array('check'=>'failure','msg'=>'CV upload error; Please try again.'));
				die;
			} else {
				$data = $this->upload->data();
				$mydata['cv'] = $data['file_name'];
			}
		}else{
			$mydata['cv'] = $oldInsCv;
		}

		$where_user_clause = array('userId' => $userId);

		if($profileProgress == 100){
			$sql_find_user = "SELECT * FROM users_temp_tbl utt WHERE utt.userId = '$userId'"; 
			//echo $sql_find_user;exit;
			$updateAttempt = $this->mymodel->fetch($sql_find_user,false);

			$mydata['userId'] = $userId;
			$mydata['userType'] = $userType;

			if(count($updateAttempt) >0){
				$oldUpdatedInfo = $updateAttempt[0];
				$updatedProfilePic = $oldUpdatedInfo->profilePic;
				$updatedInsCv = $oldUpdatedInfo->cv;

				if (empty($_FILES['cover_photo']['name'])){
					$mydata['profilePic'] = $updatedProfilePic;
				}

				if (empty($_FILES['cv']['name'])){
					$mydata['cv'] = $updatedInsCv;
				}

            if (!$this->mymodel->update($mydata,'users_temp_tbl',$where_user_clause)) {
               echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.'));
            }else{
            	if (!empty($updatedProfilePic) && ($oldProfilePic != $updatedProfilePic) && !empty($_FILES['cover_photo']['name'])) {
						if (file_exists('./uploads/users/'.$updatedProfilePic)) {
							@unlink('./uploads/users/'.$updatedProfilePic);
						}
					}

					if (!empty($updatedInsCv) && ($oldInsCv != $updatedInsCv) && !empty($_FILES['cv']['name'])) {
						if (file_exists('./uploads/cv/'.$updatedInsCv)) {
							@unlink('./uploads/cv/'.$updatedInsCv);
						}
					}

            	echo json_encode(array('check'=>'success','msg'=>'Profile data updation request is successfully submitted!'));
            }
			}else{
				if (!$this->mymodel->save('users_temp_tbl',$mydata)) {
               echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.'));
            }else{
            	echo json_encode(array('check'=>'success','msg'=>'Profile data updation request is successfully submitted!'));
            }
			}
		}else{
			if (!$this->mymodel->update($mydata,'users',$where_user_clause)) {
				echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.'));
			}else{
				echo json_encode(array('check'=>'success','msg'=>'Your registration is successfully completed!'));
			}
		}
	}

	public function cancelStudent()
	{
		//print_r($_POST);exit;
      
      $userId = $this->session->userdata('userId'); 
      $studentId = $this->input->post('studentId');
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$descriptions = $this->testInput($this->input->post('descriptions'));

		//Saving query data into db
		$cnclStudentData = array(
		    'studentId'=>$studentId,
		    'courseId'=>$courseId,
		    'courseLvl'=>$courseLvl,
		    'descriptions'=>$descriptions,
		    'userType' => 2,
		    'userId' => $userId,
		    'created'=> date('Y-m-d H:i:s')
		);

		if(!$this->mymodel->save('cancel_students', $cnclStudentData)){
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));
		}else{

			//Fetch instrctor details
			$sql_fetch_ins_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName FROM users u WHERE u.userId='".$userId."'";
			$instructorDetails = $this->mymodel->fetch($sql_fetch_ins_detail, true);

			//Fetch student details
			$sql_fetch_student_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as studentName FROM users u WHERE u.userId='".$studentId."'";
			$studentDetails = $this->mymodel->fetch($sql_fetch_student_detail, true);

			//Fetch course details
			$sql_fetch_course_detail = "SELECT c.courseName FROM courses c WHERE c.courseId='".$courseId."'";
			$courseDetails = $this->mymodel->fetch($sql_fetch_course_detail, true);

			$ADMIN_NAME = $this->config->item('ADMIN_NAME');
	      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
	      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

			$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
			$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
			$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

			$data['title'] = 'Notify admin about cancel student';
         
         $swap_var['instructor_name'] = $instructorDetails->instructorName;
	    	$swap_var['student_name'] = $studentDetails->studentName;
			$swap_var['course_name'] = $courseDetails->courseName;
			$swap_var['course_level'] = ucfirst($courseLvl);
			$swap_var['admin_url'] = base_url('admin/reports/cancelstudentdata');
			$swap_var['business_address'] = $BUSINESS_ADDRESS;
			$swap_var['business_phone'] = $BUSINESS_PHONE;
			$swap_var['business_email'] = $BUSINESS_EMAIL;

			$tepmlateBody = $this->load->view('email_template/instructor_cancel_student',$data,true);

			//echo $tepmlateBody."<br>";

	      foreach (array_keys($swap_var) as $key){
	        if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
	          $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
	        }
	      }

	      $emailParamArr['sender_name'] = $ADMIN_NAME;
	      $emailParamArr['sender_email'] = $ADMIN_MAIL;
	      $emailParamArr['receiver_name'] = $ADMIN_NAME;
	      $emailParamArr['receiver_email'] = $ADMIN_MAIL;
	      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
	      $emailParamArr['email_subject'] = 'Notify admin about cancel course by instructor';
	      $emailParamArr['email_template'] = $tepmlateBody;

	      //Send mail to admin when student request for changing instructor
	      $this->send_mail($emailParamArr);

			echo json_encode(array('check'=>'success','msg'=>'Your course cancellation request has been successfully submitted, We will get back to you in  a jiffy.'));
		}
	}

	public function cancelCourse($courseId){
		if ($courseId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Cancel Course',
			'page' => 'cancelcourse',
			'subpage' => '',
			'courseId' => $courseId
		);

		$instructorId = $this->session->userdata('userId');

		//Fetch course details
		$sql_fetch_course_details = "SELECT c.courseId,c.courseName FROM courses c WHERE c.courseId='".$courseId."'";
		$data['courseDetails'] = $this->mymodel->fetch($sql_fetch_course_details, true);

		//FETCHING COURSE'S LEVEL
		$sql_cld= "SELECT GROUP_CONCAT(cld.level) as course_level FROM `course_level_details` cld WHERE cld.courseId='".$courseId."' AND cld.status = '1'";
		//echo $sql_cld;exit;
		$courseLvlDetail=  $this->mymodel->fetch($sql_cld, true); 
		$data['courseLvlArr'] = explode(',', $courseLvlDetail->course_level);

		$studentBeginnerRefundData = array();
		$studentInterRefundData = array();
		$studentAdvancedRefundData = array();

		//Check if the current course is cancelled by user ot not
      $sql_cancel_crs_record = "SELECT GROUP_CONCAT(cc.courseLvl) as courseLvlStr FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.instructorId = '$instructorId' GROUP BY cc.courseId";

      //echo $sql_cancel_crs_record;exit;

      $cancelLvlDetails = $this->mymodel->fetch($sql_cancel_crs_record,true);
      
      if(!empty($cancelLvlDetails)){
          $data['cancelLevelArr'] = explode(',',$cancelLvlDetails->courseLvlStr);
      }else{
      	 $data['cancelLevelArr'] = array();
      }

		foreach($data['courseLvlArr'] as $index1=>$level){

			$courseLvl = $level;
         
			$studentRefundData = array();

			//Fetching student list who have purchased this courses
			$sql_fetch_student = "SELECT u.userId,CONCAT(u.firstName,' ',u.lastName) as studentName FROM student_purchased_courses spc LEFT JOIN users u ON ( spc.userId=u.userId AND u.userType=1 ) WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl'";
			//echo $sql_fetch_student;exit;
			$studentlist = $this->mymodel->fetch($sql_fetch_student); 

			foreach($studentlist as $index2 => $student){

				$studentId = $student->userId;

				$sql_fetch_booked_class = "SELECT TIMEDIFF(sbc.toTime , sbc.fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";
		           
		      //echo $sql_fetch_booked_class;exit;

		      $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
		                 
		      $totalBookedSeason = 0;

		      foreach ($bookedClassData as $key => $time) {
                $totalBookedSeason +=  round($time->timeDiff);
            }

            //if(!empty($bookedClassData)){
             
				   //Fetching course total cost
				   $sql_course_level_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

					//echo $sql_course_level_details;exit;

					//Feching Course Details 
			 		$courseLevelDetails = $this->mymodel->fetch($sql_course_level_details, true);

			 		$deductionAmount = ($courseLevelDetails->courseCost * $totalBookedSeason)/$courseLevelDetails->totalHours;
	            
	            $studentRefundData[$index2]['courseName'] = $data['courseDetails']->courseName;
	            $studentRefundData[$index2]['level'] = ucfirst($courseLvl); 
			 		$studentRefundData[$index2]['studentId'] = $student->userId;
			 		$studentRefundData[$index2]['studentName'] = $student->studentName;
			 		$studentRefundData[$index2]['courseSession'] = $courseLevelDetails->totalHours;
			 		$studentRefundData[$index2]['bookedSession'] = $totalBookedSeason;
			 		$studentRefundData[$index2]['courseCost'] = sprintf("%.2f",$courseLevelDetails->courseCost);
			 		$studentRefundData[$index2]['deductionAmount'] = sprintf("%.2f",$deductionAmount);
			 		$studentRefundData[$index2]['refundAmount'] = sprintf("%.2f",($courseLevelDetails->courseCost - $deductionAmount));
			 	/*}else{
			 		$studentRefundData = array();
			 	}*/	
		 	}	
         
         if($courseLvl == "beginner"){
				$data['studentBeginnerRefundData'] =$studentRefundData;
			}	 

			if($courseLvl == "intermediate"){
				$data['studentInterRefundData'] =$studentRefundData;
			}	 
		 	
		 	if($courseLvl == "advanced"){
				$data['studentAdvancedRefundData'] =$studentRefundData;
			}	 

	 	}	

      /*print"<pre>";
		print_r($studentAdvancedRefundData);
		print"<pre>";exit;*/

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/cancel_course');
		$this->load->view('instructor/footer');
	}

	public function submitCancelCourse()
	{
		//print_r($_POST);exit;

      //Running transaction
	   $this->db->trans_begin();

      $instructorId = $this->session->userdata('userId'); 
		$courseId = $this->input->post('courseId');
		
		$cancel_status_beginner = $this->input->post('cancel_status_beginner');
		$beginner_cancel_reason = $this->input->post('beginner_cancel_reason');

		//Checking if there is any pending cancel request for beginner level
		$sql_big_cancel_count = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = 'beginner'";

      $bigCancelCount = $this->db->query($sql_big_cancel_count)->num_rows();

		$cancel_status_inter = $this->input->post('cancel_status_inter');
		$inter_cancel_reason = $this->input->post('inter_cancel_reason');

		//Checking if there is any pending cancel request for beginner level
		$sql_inter_cancel_count = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = 'intermediate'";

      $interCancelCount = $this->db->query($sql_inter_cancel_count)->num_rows();

		$cancel_status_advanced = $this->input->post('cancel_status_advanced');
		$advanced_cancel_reason = $this->input->post('advanced_cancel_reason');

		//Checking if there is any pending cancel request for beginner level
		$sql_advncd_cancel_count = "SELECT cc.requestId FROM cancel_courses cc WHERE cc.courseId = '$courseId' AND cc.courseLvl = 'advanced'";

      $advncdCancelCount = $this->db->query($sql_advncd_cancel_count)->num_rows();

		$courseLvlStr = '';

		if( (!empty($cancel_status_beginner) && !empty($cancel_status_inter) && !empty($cancel_status_advanced)) || ($cancel_status_beginner == 0 && $cancel_status_inter == 0 && $cancel_status_advanced == 0) ){
          echo json_encode(array('check'=>'failure','msg'=>'You have to select at-least one level to cancel.'));
          exit;
		} 

		if(!empty($cancel_status_beginner) && $cancel_status_beginner == 1 && !empty($beginner_cancel_reason)){

			  if($bigCancelCount == 0){
			  	  
			  	   //Saving query data into db
				   $beginnerCnclCrsData = array(
					  'courseId'=>$courseId,
					  'courseLvl'=>"beginner",
					  'descriptions'=>$beginner_cancel_reason,
					  'instructorId' => $instructorId,
					  'created'=> date('Y-m-d H:i:s')
				   );

				   $courseLvlStr .= 'Beginner';

				   //Inserting cancel course level request in table
				   $this->mymodel->save('cancel_courses', $beginnerCnclCrsData);

			  }else{
			  	  echo json_encode(array('check'=>'failure','msg'=>'Beginner level has already been cancelled!'));
          	  exit;
			  }
		}

		if(!empty($cancel_status_inter) && $cancel_status_inter == 1 && !empty($inter_cancel_reason)){
           
           if($interCancelCount == 0){
	          
	           //Saving query data into db
				  $interCnclCrsData = array(
					  'courseId'=>$courseId,
					  'courseLvl'=>"intermediate",
					  'descriptions'=>$inter_cancel_reason,
					  'instructorId' => $instructorId,
					  'created'=> date('Y-m-d H:i:s')
				  );

				  $courseLvlStr .= ',Intermediate';

				  //Inserting cancel course level request in table
				  $this->mymodel->save('cancel_courses', $interCnclCrsData);

			  }else{
			  	  echo json_encode(array('check'=>'failure','msg'=>'Intermediate level has already been cancelled!'));
          	  exit;
			  }	  
		}

		if(!empty($cancel_status_advanced) && $cancel_status_advanced == 1 && !empty($advanced_cancel_reason)){
           
           if($interCancelCount == 0){
	          
	           //Saving query data into db
				  $advancedCnclCrsData = array(
					  'courseId'=>$courseId,
					  'courseLvl'=>"advanced",
					  'descriptions'=>$beginner_cancel_reason,
					  'instructorId' => $instructorId,
					  'created'=> date('Y-m-d H:i:s')
				  );

				  $courseLvlStr .= ',Advanced';

				  //Inserting cancel course level request in table
				  $this->mymodel->save('cancel_courses', $advancedCnclCrsData);
			 }else{
			 	 echo json_encode(array('check'=>'failure','msg'=>'Advanced level has already been cancelled!'));
          	 exit;
			 }	  
		}

		$courseLvlStr = trim($courseLvlStr,",");

		if($this->db->trans_status() === FALSE){
			
			//Rolling back all transaction
			$this->db->trans_rollback();
			
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));
		}else{
			
			//Comitting transaction
         $this->db->trans_commit();
			
			//Fetch instrctor details
			$sql_fetch_ins_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName FROM users u WHERE u.userId='".$instructorId."'";
			$instructorDetails = $this->mymodel->fetch($sql_fetch_ins_detail, true);

			//Fetch course details
			$sql_fetch_course_detail = "SELECT c.courseName FROM courses c WHERE c.courseId='".$courseId."'";
			$courseDetails = $this->mymodel->fetch($sql_fetch_course_detail, true);

			$ADMIN_NAME = $this->config->item('ADMIN_NAME');
	      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
	      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

			$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
			$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
			$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

			$data['title'] = 'Notify admin about cancel student';
         
         $swap_var['instructor_name'] = $instructorDetails->instructorName;
			$swap_var['course_name'] = $courseDetails->courseName;
			$swap_var['course_level'] = $courseLvlStr;
			$swap_var['admin_url'] = base_url('admin/reports/cancelcoursedata');
			$swap_var['business_address'] = $BUSINESS_ADDRESS;
			$swap_var['business_phone'] = $BUSINESS_PHONE;
			$swap_var['business_email'] = $BUSINESS_EMAIL;

			$tepmlateBody = $this->load->view('email_template/instructor_cancel_course',$data,true);

			//echo $tepmlateBody."<br>";

	      foreach (array_keys($swap_var) as $key){
	        if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
	          $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
	        }
	      }

	      $emailParamArr['sender_name'] = $ADMIN_NAME;
	      $emailParamArr['sender_email'] = $ADMIN_MAIL;
	      $emailParamArr['receiver_name'] = $ADMIN_NAME;
	      $emailParamArr['receiver_email'] = $ADMIN_MAIL;
	      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
	      $emailParamArr['email_subject'] = 'Notify admin about cancel course by instructor';
	      $emailParamArr['email_template'] = $tepmlateBody;

	      //Send mail to admin when student request for changing instructor
	      $this->send_mail($emailParamArr);

			echo json_encode(array('check'=>'success','msg'=>'Your course cancellation request has been successfully submitted, We will get back to you in  a jiffy.'));
		}
	}

	public function reset()
	{
		$data['title'] = "Settings";
		$data['page'] = "settings";
		$data['subpage'] = null;

		$this->load->view('instructor/header', $data);
		$this->load->view('instructor/change_password');
		$this->load->view('instructor/footer');
	}

	public function change_password()
	{
		$userId = $this->session->userdata('userId');

		$this->form_validation->set_rules('c_password', 'Current Password', 'trim|required');
		$this->form_validation->set_rules('n_password_confirmation', 'New Password', 'trim|required');
		$this->form_validation->set_rules('n_password', 'Repeat Password', 'trim|required|matches[n_password_confirmation]|differs[c_password]');

		$msg = '';

		if ($this->form_validation->run() == false) {
			if (form_error('c_password')) {
				$msg .= strip_tags(form_error('c_password'));
			}
			if (form_error('n_password_confirmation')) {
				$msg .= strip_tags(form_error('n_password_confirmation'));
			}
			if (form_error('n_password')) {
				$msg .= strip_tags(form_error('n_password'));
			}
			$formErrorArr = array_filter(explode('.', $msg));
			$this->session->set_flashdata('form_error',$formErrorArr);
		} else {
			$c_password = $this->input->post('c_password');
			$n_password = $this->input->post('n_password');
			$user = $this->mymodel->get('users', true, 'userId', $userId);

			if (! password_verify($c_password, $user->password)) {
				$this->session->set_flashdata('error', 'You have entered wrong password.');
			} else {

				$mydata['password'] = $this->enc_password($n_password);

				if (!$this->mymodel->update($mydata, 'users', ['userId'=>$userId])) {
					$this->session->set_flashdata('error', 'Something went wrong; Please try again.');
				} else {
					$this->session->set_flashdata('success', 'Password changed successfully.');
				}
			}
		}

		redirect(base_url('instructor/reset'),'refresh');
	}
}