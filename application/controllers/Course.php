<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Adding namespace for phpmailer package
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Course extends My_Controller
{

	public function __construct()
  {
  	parent::__construct();    
  	$this->config->load('mail_config');  
  }

  public function display_mail_template(){
   		$this->load->view('email_template/user_signup_notify');
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

	        if(!empty($ccEmail)){
	       		 //$mail->addCC($ccEmail,'Admin');                 //Add cc
	        }

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
    
	public function details($courseId,$courseLvl)
	{
		$data['title'] = "Course Deatails";
		
		$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

		//echo $sql_course_details;exit;

		//Feching Course Details 
		$data['courseLvl'] = $courseLvl;
 		$data['courseDetail'] = $this->mymodel->fetch($sql_course_details, true);

 		$sql_fetch_ins = "SELECT u.* FROM users u WHERE u.userType = '2' AND u.approve_status = '1'";
		$data['insData'] = $this->mymodel->fetch($sql_fetch_ins, false);

 		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_course_subject = "SELECT cc.level,cld.descriptions,cld.intro_video,GROUP_CONCAT(DISTINCT CONCAT(s.subjectId,'-',s.subjectName,'-',s.image) SEPARATOR '&%*$!') as subjectData FROM course_chapters cc LEFT JOIN course_level_details cld ON ( cc.courseId=cld.courseId AND cc.level=cld.level ) LEFT JOIN chapters c ON cc.subjectId=c.subjectId LEFT JOIN subjects s ON c.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' AND cld.status='1' GROUP BY cc.level";

		//echo $sql_course_subject;exit;

		$data['courseSubjectData'] = $this->mymodel->fetch($sql_course_subject, false);

		$this->load->view('header', $data);
		$this->load->view('course_details');
		$this->load->view('footer');
	}

	public function getLevelDetails(){
		$courseId  = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');

		$userId = $this->session->userdata('userId'); 

		if(!empty($userId)){
				$sql_level_details = "SELECT c.image as course_image,Count(DISTINCT spc.purchaseId) as purchaseCount,cl.*,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM courses c LEFT JOIN student_purchased_courses spc ON (c.courseId=spc.courseId AND spc.courseId = '$courseId' AND spc.courseLvl = '$courseLvl' AND spc.userId = '$userId')  LEFT JOIN course_level_details cl ON c.courseId=cl.courseId LEFT JOIN course_chapters cc ON ( cl.courseId=cc.courseId AND cl.level='".$courseLvl."') LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

		}else{
        $sql_level_details = "SELECT c.image as course_image,Count(DISTINCT spc.purchaseId) as purchaseCount,cl.*,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM courses c LEFT JOIN student_purchased_courses spc ON (c.courseId=spc.courseId AND spc.courseId = '$courseId' AND spc.courseLvl = '$courseLvl')  LEFT JOIN course_level_details cl ON c.courseId=cl.courseId LEFT JOIN course_chapters cc ON ( cl.courseId=cc.courseId AND cl.level='".$courseLvl."') LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'"; 
		}			

		//echo $sql_level_details;exit;

		//Feching Course Details 
 		$lvlDetail = json_decode(json_encode($this->mymodel->fetch($sql_level_details, true)),true);

 		//Checking if the student has already added this course into their wishlist
 		$where_check_whishlist = array('courseId'=>$courseId,'courseLvl'=>$courseLvl,'userId'=>$userId);

 		if($this->mymodel->count('student_course_whishlist',$where_check_whishlist)>0){
 			 $lvlDetailArr['wishlisted'] = "yes";
 		}else{
 			 $lvlDetailArr['wishlisted'] = "no";
 		}

		//Fetch purchase count of this course
		$sql_purchase_count = "SELECT Count(DISTINCT spc.purchaseId) as purchaseCount FROM student_purchased_courses spc WHERE spc.courseId='".$courseId."' AND spc.courseLvl='".$courseLvl."'"; 

		//echo $sql_purchase_count;exit;

		//Feching Course Details 
 		$purchaseCount = $this->mymodel->fetch($sql_level_details, true)->purchaseCount;

 		$lvlDetailArr['crsLvlId'] = $lvlDetail['crsLvlId'];
 		$lvlDetailArr['courseLvl'] = ucfirst($lvlDetail['level']);
 		$lvlDetailArr['totalChapter'] = $lvlDetail['totalChapter'];
 		$lvlDetailArr['totalHours'] = $lvlDetail['totalHours'];
 		$lvlDetailArr['lvlCost'] = $lvlDetail['lvlCost'];
 		$lvlDetailArr['description'] = $lvlDetail['descriptions'];
 		$lvlDetailArr['purchaseCount'] = $lvlDetail['purchaseCount'];

 		if (@$lvlDetail['image'] && file_exists('./uploads/level/'.@$lvlDetail['image'])) {
 			$lvlDetailArr['imageSrc'] = "level"; 
 			$lvlDetailArr['image'] = $lvlDetail['image']; 
 		}else{
 			$lvlDetailArr['imageSrc'] = "courses"; 
 			$lvlDetailArr['image'] = $lvlDetail['course_image']; 
 		}
        
 		echo json_encode(array('check'=>'success','lvlDetail'=>$lvlDetailArr,'purchaseCount'=>$purchaseCount));
	}	

	public function getLevelChapters(){
		$courseId  = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$subjectId = $this->input->post('subjectId');

		$sql_level_chapter = "SELECT c.* FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId=c.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND cc.subjectId='".$subjectId."'";

		//echo $sql_level_chapter;exit;

		//Feching Course Details 
 		$data['lvlChapterList'] = $this->mymodel->fetch($sql_level_chapter, false);
        
 		$lvlChapterHtml = $this->load->view('chapter_ajax_list',$data,true);
        
 		echo json_encode(array('check'=>'success','lvlChapterHtml'=>$lvlChapterHtml));
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

	public function purchaseCourse(){
        
     $userId = $this->session->userdata('userId'); 

 	   $ADMIN_NAME = $this->config->item('ADMIN_NAME');
     $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
     $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		 $BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		 $BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		 $BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

     if(!empty($userId)){

				$courseId  = $this->input->post('courseId');
				$courseLvl = $this->input->post('courseLvl');

				$sql_level_details = "SELECT SUM(DISTINCT chp.cost) as lvlCost FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

				//echo $sql_level_details;exit;

				//Feching Course Details 
		 		$levelDetail = $this->mymodel->fetch($sql_level_details, true);

		 		//Checking if the student has already purchased this course
		 		$where_check_purchase = array('courseId'=>$courseId,'courseLvl'=>$courseLvl,'userId'=>$userId);

		 		if($this->mymodel->count('student_purchased_courses',$where_check_purchase)>0){
		 			echo json_encode(array('check'=>'failure','status'=>'purchased','msg'=>'You have already purchased this course!'));
		 		}else{

			 		$lvlCost = $levelDetail->lvlCost;

			 		$transactionData = serialize(array('payment_method'=>'unknown','amount'=>$lvlCost));
			 		$uniquePurchaseId = $this->create_Course_Purchase_Id();

				    $coursePurchaseData = array(
				    	'userId'=>$userId,
				    	'uniquePurchaseId'=>$uniquePurchaseId,
				    	'courseId'=>$courseId,
				    	'courseLvl'=>$courseLvl,
				    	'lvlCost'=>$lvlCost,
				    	'payment_method'=>'Unknown',
				    	'payment_status' => 'pending',
				    	'transaction_data'=>$transactionData,
				    	'created'=>date('Y-m-d H:i:s') 
				    ); 
						
				    //Insert data into db
				    if($this->mymodel->save('student_purchased_courses', $coursePurchaseData)){ 

				    	  $userEmailReturnArr['studentId'] = $userId;
				    	  $userEmailReturnArr['courseId'] = $courseId;
				    	  $userEmailReturnArr['courseLvl'] = $courseLvl;

				    	  echo json_encode(array('check'=>'success','msg'=>'Course has been purchased successfully!','mailParams' => $userEmailReturnArr));

                //Fetch student details
								$sql_fetch_student_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as studentName,u.email,u.mobile FROM users u WHERE u.userId='".$userId."'";
								$studentDetails = $this->mymodel->fetch($sql_fetch_student_detail, true);

								//Fetch course details
								$sql_fetch_course_detail = "SELECT c.courseName,c.created_by ,c.creator_id FROM courses c WHERE c.courseId='".$courseId."'";
								$courseDetails = $this->mymodel->fetch($sql_fetch_course_detail, true);
	              
	              if($courseDetails->created_by == "instructor"){

              	 $instructorId = $courseDetails->creator_id;
              	 
              	 //Fetch instrctor details
									$sql_fetch_ins_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName,u.email FROM users u WHERE u.userId='".$instructorId."'";
									$instructorDetails = $this->mymodel->fetch($sql_fetch_ins_detail, true);

									$RECEIVER_NAME = $instructorDetails->instructorName;
									$RECEIVER_MAIL = $instructorDetails->email;
	              }else{
	              	 $RECEIVER_NAME = $ADMIN_NAME;
									 $RECEIVER_MAIL = $ADMIN_MAIL; 
	              }
      
				    	  $data['title'] = 'Notify instructor about course purchase';

						    $swap_var1['creator_name'] = $RECEIVER_NAME;
						    $swap_var1['student_name'] = $studentDetails->studentName;
						    $swap_var1['student_email'] = $studentDetails->email;
						    $swap_var1['student_phone'] = $studentDetails->mobile;
								$swap_var1['course_name'] = $courseDetails->courseName;
								$swap_var1['course_level'] = ucfirst($courseLvl);
								$swap_var1['purchase_date'] = date('jS F, Y');
								$swap_var1['txn_id'] = $uniquePurchaseId;
								$swap_var1['amount_paid'] = "$".$lvlCost;
								$swap_var1['dashboard_url'] = base_url('instructor/studentlist');
								$swap_var1['business_address'] = $BUSINESS_ADDRESS;
								$swap_var1['business_phone'] = $BUSINESS_PHONE;
								$swap_var1['business_email'] = $BUSINESS_EMAIL;

								$creatorTepmlateBody = $this->load->view('email_template/creator_course_purchase_notify',$data,true);

								//echo $tepmlateBody."<br>";

					      foreach (array_keys($swap_var1) as $key){
					        if (strlen($key) > 2 && trim($swap_var1[$key]) != ''){
					          $creatorTepmlateBody = str_replace('{'.$key.'}', $swap_var1[$key], $creatorTepmlateBody);
					        }
					      }

					      $emailParamArr['sender_name'] = $ADMIN_NAME;
					      $emailParamArr['sender_email'] = $ADMIN_MAIL;
					      $emailParamArr['receiver_name'] = $RECEIVER_NAME;
					      $emailParamArr['receiver_email'] = $RECEIVER_MAIL;
					      $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
					      $emailParamArr['email_subject'] = 'Notify instructor about course purchase';
					      $emailParamArr['email_template'] = $creatorTepmlateBody;

					      //Send mail to admin & instructor when student purchase a course successfully
					      $this->send_mail($emailParamArr);
                
                //Sending mail to student 
					      $data['title'] = 'Notify student about course purchase';
                
						    $swap_var2['student_name'] = $studentDetails->studentName;
						    $swap_var2['student_email'] = $studentDetails->email;
						    $swap_var2['student_phone'] = $studentDetails->mobile;
								$swap_var2['course_name'] = $courseDetails->courseName;
								$swap_var2['course_level'] = ucfirst($courseLvl);
								$swap_var2['purchase_date'] = date('jS F, Y');
								$swap_var2['txn_id'] = $uniquePurchaseId;
								$swap_var2['amount_paid'] = "$".$lvlCost;
								$swap_var2['dashboard_url'] = base_url('student/enrolledcourselist');
								$swap_var2['business_address'] = $BUSINESS_ADDRESS;
								$swap_var2['business_phone'] = $BUSINESS_PHONE;
								$swap_var2['business_email'] = $BUSINESS_EMAIL;

								$studentTepmlateBody = $this->load->view('email_template/student_course_purchase_notify',$data,true);

								//echo $tepmlateBody."<br>";

					      foreach (array_keys($swap_var2) as $key){
					        if (strlen($key) > 2 && trim($swap_var2[$key]) != ''){
					          $studentTepmlateBody = str_replace('{'.$key.'}', $swap_var2[$key], $studentTepmlateBody);
					        }
					      }

					      $emailParamArr['sender_name'] = $ADMIN_NAME;
					      $emailParamArr['sender_email'] = $ADMIN_MAIL;
					      $emailParamArr['receiver_name'] = $studentDetails->studentName;
					      $emailParamArr['receiver_email'] = $studentDetails->email;
					      $emailParamArr['email_subject'] = 'Notify student about successfully course purchase';
					      $emailParamArr['email_template'] = $studentTepmlateBody;

					      //Send mail to admin when student request for changing instructor
					      $this->send_mail($emailParamArr);

		 		    }else{
		 		    		echo json_encode(array('check'=>'failure','status'=>'unknown','msg'=>'Something went wrong; Please try again.'));
		 		    }
		 		}    
 		}else{
 			echo json_encode(array('check'=>'failure','status'=>'login','msg'=>'Please login to make this purchase!'));
 		}    
	}	

	public function addCourseWishlist(){
        
     $userId = $this->session->userdata('userId'); 

     if(!empty($userId)){

				$courseId  = $this->input->post('courseId');
				$courseLvl = $this->input->post('courseLvl');

		 		//Checking if the student has already added this course into their wishlist
		 		$where_check_whishlist = array('courseId'=>$courseId,'courseLvl'=>$courseLvl,'userId'=>$userId);

		 		if($this->mymodel->count('student_course_whishlist',$where_check_whishlist)>0){
		 			echo json_encode(array('check'=>'failure','status'=>'purchased','msg'=>'You have already added this course into wishlist!'));
		 		}else{

				    $wishListData = array(
				    	'userId'=>$userId,
				    	'courseId'=>$courseId,
				    	'courseLvl'=>$courseLvl,
				    ); 
						
				    //Insert data into db
				    if($this->mymodel->save('student_course_whishlist', $wishListData)){ 
				    	echo json_encode(array('check'=>'success','msg'=>'Course is successfully added into wishlist!'));
		 		    }else{
		 		    	echo json_encode(array('check'=>'failure','status'=>'unknown','msg'=>'Something went wrong; Please try again.'));
		 		    }
		 		}    
 		}else{
 			echo json_encode(array('check'=>'failure','status'=>'login','msg'=>'Please login to make this purchase!'));
 		}    
	}	
	
}
