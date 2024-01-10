<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Adding namespace for phpmailer package
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Student extends MY_Controller
 {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Commonmodel');
		$this->load->model('Authmodel');
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('string');
		$this->load->library("pagination");
		$this->studentLoggedIn();	
		$this->config->load('mail_config');
	}

	public function dashboard()
	{
		$data['title'] = "Dashboard";
		$data['page'] = "dashboard";

		$userId=$this->session->userdata('userId');
		$runningCourseCount = 0;
		$completedCourseCount = 0;

		$sql_enrolled_courses = "SELECT Count(spc.purchaseId) as enrolledCourseCount FROM student_purchased_courses spc WHERE spc.userId = '".$userId."' ORDER BY spc.purchaseId DESC";  

    //echo $sql_enrolled_courses;exit;

    //Feching Enrolled Course List 
	 	$data['courseData'] = $this->mymodel->fetch($sql_enrolled_courses, true);

	 	$sql_purchased_courses = "SELECT spc.courseId,spc.courseLvl FROM student_purchased_courses spc WHERE spc.userId = '".$userId."' ORDER BY spc.purchaseId DESC";  

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

	 	$data['runningCourseData'] = $runningCourseCount;

	 	//Calculate complted course data
	 	$sql_enrolled_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId DESC";  

	    //echo $sql_enrolled_courses;exit;

	    //Feching Enrolled Course List 
	    $data['course_type'] = "active";
	    $courseData = $this->mymodel->fetch($sql_enrolled_courses, false);

	 	foreach ($courseData as $index => $course) {

	 		 $courseId = $course->courseId; 
	 		 $courseLvl = $course->courseLvl; 
	 		 $courseTotalSession = $course->totalHours; 
	 		
	 		 //Calculate student bookes season
		    $sql_student_booked_season = "SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."'ORDER BY sbc.courseId DESC";  

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

	 	$data['completedCourseData'] = $completedCourseCount;


		$this->load->view('student/header', $data);
		$this->load->view('student/dashboard');
		$this->load->view('student/footer');
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
		//$this->send_mail($emailParamArr);
   }

   public function display_mail_template(){
   	$this->load->view('email_template/student_change_instructor');
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

   public function profile()
   {
		$data['title'] = "My Profile";
		$data['page'] = "profilesetting";

		$userId=$this->session->userdata('userId');
		$data['myInfo']= $this->mymodel->get('users', true, 'userId', $userId);
		$this->load->view('student/header', $data);
		$this->load->view('student/profile');
		$this->load->view('student/footer');
	}

	public function enrolled_course_Lists()
	{
		$data['title'] = "My Courses";
		$data['page'] = "courselist";
		$data['subpage'] = "enrolledcourselist";

		$userId = $this->session->userdata('userId'); 

		$sql_fetch_reason = "SELECT * FROM reason r ORDER BY r.reasonId";
		$data['reasonList'] =  $this->mymodel->fetch($sql_fetch_reason,false);

	  $sql_enrolled_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId DESC";  

	  //echo $sql_enrolled_courses;exit;

	  //Feching Enrolled Course List 
	  $data['course_type'] = "enrolled";
	 	$data['courseData'] = $this->mymodel->fetch($sql_enrolled_courses, false);

	 	//echo $data['instructorId'];exit;
	 	
		$this->load->view('student/header', $data);
		$this->load->view('student/courses');
		$this->load->view('student/footer');
	}

	public function running_course_Lists()
	{
		$data['title'] = "My Courses";
		$data['page'] = "courselist";
		$data['subpage'] = "runningcourselist";

		$sql_fetch_reason = "SELECT * FROM reason r ORDER BY r.reasonId";
		$data['reasonList'] =  $this->mymodel->fetch($sql_fetch_reason,false);

		$userId = $this->session->userdata('userId'); 
		$runningCourseData = [];

	 	//Calculate complted course data
	 	$sql_purchased_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId DESC";  

	 	//echo $sql_purchased_courses;exit;

	  //Feching Enrolled Course List 
	 	$purchaseData = $this->mymodel->fetch($sql_purchased_courses, false);

	 	foreach ($purchaseData as $key => $purchased) {

	 		$purchasedCourseId = $purchased->courseId;
	 		$purchasedCourseLvl = $purchased->courseLvl;
	 		 
	 		$sql_running_courses = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId = '".$purchasedCourseId."' AND sbc.courseLvl = '".$purchasedCourseLvl."' ORDER BY sbc.classId";  

		 	//echo $sql_running_courses;exit;

		  //Feching Enrolled Course List 
		 	$bookedClassData = $this->db->query($sql_running_courses)->num_rows();

		 	if($bookedClassData>0){
		 	   $runningCourseData[$key] = $purchased;
		 	}
	 	}

	  //Feching Enrolled Course List 
	  $data['course_type'] = "running";
	 	$data['courseData'] = array_values($runningCourseData);

	 	//echo $data['instructorId'];exit;
	 	
		$this->load->view('student/header', $data);
		$this->load->view('student/courses');
		$this->load->view('student/footer');
	}

	public function completed_course_Lists()
	{
		$data['title'] = "My Courses";
		$data['page'] = "courselist";
		$data['subpage'] = "completedcourselist";

		$userId = $this->session->userdata('userId'); 

	    //Calculate complted course data
	 	$sql_enrolled_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId DESC";  

	    //echo $sql_enrolled_courses;exit;

	    //Feching Enrolled Course List 
	    $courseData = $this->mymodel->fetch($sql_enrolled_courses, false);
	    $completedCourseData = [];

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
		    	$completedCourseData[$index] = $course;
		    }
	 	}

	  //Feching Enrolled Course List         
    $data['course_type'] = "completed";
	 	$data['courseData'] = array_values($completedCourseData);
	 	
		$this->load->view('student/header', $data);
		$this->load->view('student/courses');
		$this->load->view('student/footer');
	}

	public function courseDetails($courseId,$courseLvl)
	{

		$data['title'] = "Course Detail";
		$data['page'] = "courselist";

		$userId = $this->session->userdata('userId'); 

		$data['courseId'] = $courseId;
		$data['courseLvl'] = $courseLvl;

		$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."'";
		//echo $sql_course_details;exit;

		//Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->fetch($sql_course_details, true);

 		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_course_subject = "SELECT cc.level,s.* FROM student_purchased_courses spc LEFT JOIN course_chapters cc ON spc.courseId = cc.courseId  LEFT JOIN subjects s ON cc.subjectId=s.subjectId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND spc.userId='".$userId."' GROUP BY cc.subjectId";

		//echo $sql_course_subject;exit;

		$data['courseSubjectList'] = $this->mymodel->fetch($sql_course_subject, false);

		$this->load->view('student/header', $data);
		$this->load->view('student/course_details');
		$this->load->view('student/footer');
	}

	public function courseListUnderSubject($courseId,$courseLvl,$subjectId){
        
        $sql_fetch_subject_detail = "SELECT * FROM subjects s WHERE s.subjectId='$subjectId'";
        $subjectDetail = $this->mymodel->fetch($sql_fetch_subject_detail,true);

        $data['title'] = "All Chapter List Under ".$subjectDetail->subjectName." Subject";
        $data['subjectName'] = $subjectDetail->subjectName;
		$data['page'] = "courselist";

		$data['courseId'] = $courseId;
		$data['courseLvl'] = $courseLvl;
		$data['subjectId'] = $subjectId;

		$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."'";

		//echo $sql_course_details;exit;

		//Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->fetch($sql_course_details, true);

 		$sql_subject_detail = "SELECT s.* FROM subjects s WHERE s.subjectId='".$subjectId."'";

		//echo $sql_subject_detail;exit;

		//Feching Course Details 
 		$data['subjectDetail'] = $this->mymodel->fetch($sql_subject_detail, true);
 
		$sql_level_chapter = "SELECT c.* FROM course_chapters cc LEFT JOIN chapters c ON cc.chapterId=c.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."' AND cc.subjectId='".$subjectId."'";

		//echo $sql_level_chapter;exit;

		//Feching Course Details 
 		$data['chapterList'] = $this->mymodel->fetch($sql_level_chapter, false);

 		$this->load->view('student/header', $data);
		$this->load->view('student/chapter_list');
		$this->load->view('student/footer');
	}

	public function getSubjectDetails($courseId,$courseLvl,$subjectId){
        
        $data['title'] = "Subject Details Page";
		$data['page'] = "courselist";

        $data['courseId'] =  $courseId;
		$data['courseLvl'] = $courseLvl;
		$data['subjectId'] = $subjectId;

		$sql_course_details = "SELECT c.courseName FROM courses c WHERE c.courseId='".$courseId."'";
		//echo $sql_course_details;exit;

		//Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->fetch($sql_course_details, true);

		$sql_subject_detail = "SELECT s.* FROM subjects s WHERE s.subjectId='".$subjectId."'";
		//echo $sql_subject_detail;exit;

		//Feching Course Details 
 		$data['subjectDetail'] = $this->mymodel->fetch($sql_subject_detail, true);
 		//$subjectSummaryDetail = $this->load->view('student/subject_ajax_detail',$data,true);
 		
 		$this->load->view('student/header', $data);
		$this->load->view('student/subject_details');
		$this->load->view('student/footer');
	}

	public function chapter_curriculum($courseId,$courseLvl,$subjectId,$chapterId){
		$data['title'] = "Chapter Carriculum Media Management";
		$data['page'] = "courselist";
		
		$data['courseId'] =  $courseId;
		$data['courseLvl'] = $courseLvl;
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$sql_course_details = "SELECT c.courseName FROM courses c WHERE c.courseId='".$courseId."'";
		//echo $sql_course_details;exit;

		//Feching Course Details 
 		$data['courseDetail'] = $this->mymodel->fetch($sql_course_details, true);

		$sql_subject_detail = "SELECT s.subjectId,s.subjectName FROM subjects s WHERE s.subjectId='".$subjectId."'";
		//echo $sql_subject_detail;exit;

		//Feching Course Details 
 		$data['subjectDetail'] = $this->mymodel->fetch($sql_subject_detail, true);

 		$sql_chapter_detail = "SELECT chp.* FROM chapters chp WHERE chp.chapterId='".$chapterId."'";
		//echo $sql_chapter_detail;exit;

		//Feching Course Details 
 		$data['chapterDetail'] = $this->mymodel->fetch($sql_chapter_detail, true);
          
        //Fetching all image data for this course carriculum
		$sql_fetch_media = "SELECT * FROM `chapter_carriculum_media` as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.ordering ASC";
		//echo $sql_fetch_media;exit;

		$data['mediaFiles'] = $this->mymodel->fetch($sql_fetch_media,false);

        $this->load->view('student/header',$data);
		$this->load->view('student/chapter_carriculum');
		$this->load->view('student/footer');   
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

	public function instructorLists($courseId,$courseLvl)
	{
		$data['title'] = "Instructor Detail";
		$data['page'] = "courselist";

		$userId = $this->session->userdata('userId'); 

		$data['courseId'] = $courseId;
		$data['courseLvl'] = $courseLvl;

		$sql_fetch_reason = "SELECT * FROM reason r ORDER BY r.reasonId";
		$data['reasonList'] =  $this->mymodel->fetch($sql_fetch_reason,false);

	    $sql_course_subject = "SELECT ins.level,u.*,AVG(cr.rating) as insAvgRating FROM student_purchased_courses spc LEFT JOIN course_instructors ins ON spc.courseId = ins.courseId LEFT JOIN course_review cr ON ins.instructorId = cr.instructorId LEFT JOIN users u ON ins.instructorId=u.userId WHERE ins.courseId='".$courseId."' AND ins.level='".$courseLvl."' AND spc.userId='".$userId."' AND u.userType = '2' AND u.timezone != '' AND u.status=1 AND u.status=1 AND u.approve_status=1 GROUP BY ins.instructorId";

	    //echo $sql_course_subject;exit;

	    //Feching Enrolled Course List 
		$data['instructorList'] = $this->mymodel->fetch($sql_course_subject, false);

	   $sql_booked_course = "SELECT sbc.instructorId,cr.reviewId,cr.rating,cr.feedback,sct.conferenceId,sct.meeting_url,sct.passcode FROM student_booked_classes sbc LEFT JOIN course_review cr ON ( sbc.courseId=cr.courseId  AND sbc.courseLvl = cr.courseLvl AND sbc.studentId = cr.studentId AND sbc.instructorId = cr.instructorId ) LEFT JOIN session_conference_tbl sct ON ( sbc.studentId = sct.studentId AND sbc.instructorId = sct.instructorId AND sbc.courseId = sct.courseId AND sbc.courseLvl = sct.courseLvl ) WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' ORDER BY sbc.classId DESC LIMIT 1";

	    //echo $sql_booked_course;exit;

	    //Feching Enrolled Course List 
		$instructorData = $this->mymodel->fetch($sql_booked_course, true);
	    
	   if(!empty($instructorData)){
	 		$data['instructorData'] = $instructorData;
	 	}else{
	 		$data['instructorData'] = null;
	 	}	
	 	
		$this->load->view('student/header', $data);
		$this->load->view('student/instructor-detail');
		$this->load->view('student/footer');
	}

	public function changeInstructor(){
	  $studentId = $this->session->userdata('userId');
	  $courseId = $this->input->post('courseId');
	  $courseLvl = $this->input->post('courseLvl');
	  $instructorId = $this->input->post('insId');
	  $reasonId = $this->input->post('reasonId');
	  $descriptions = $this->testInput($this->input->post('descriptions'));

	  //Check if user perchased this course
    $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

    //echo $sql_check_purchse_status;exit;

    $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

    //Check if user perchased this course
    /*$sql_check_booked_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId'";

    //echo $sql_check_booked_class;exit;

    $checkBookClass = $this->db->query($sql_check_booked_class)->num_rows();*/

    //Count no of session attended
    $sql_check_attened_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";

    //echo $sql_check_attened_class;exit;

    $attendedClass = $this->db->query($sql_check_attened_class)->num_rows();

    if($purchaseCount>0 && $attendedClass>=2){
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

		if(!$this->mymodel->save('change_instructor', $queryData)){
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));
		}else{

			//Fetch student details
			$sql_fetch_student_detail = "SELECT CONCAT(u.firstName,' ',u.lastName) as studentName FROM users u WHERE u.userId='".$studentId."'";
			$studentDetails = $this->mymodel->fetch($sql_fetch_student_detail, true);

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

			$data['title'] = 'Notify admin about change instructor';

			$swap_var['instructor_name'] = $instructorDetails->instructorName;
	    $swap_var['student_name'] = $studentDetails->studentName;
			$swap_var['course_name'] = $courseDetails->courseName;
			$swap_var['course_level'] = ucfirst($courseLvl);
			$swap_var['admin_url'] = base_url('admin/reports/changeinstructordata');
			$swap_var['business_address'] = $BUSINESS_ADDRESS;
			$swap_var['business_phone'] = $BUSINESS_PHONE;
			$swap_var['business_email'] = $BUSINESS_EMAIL;

			$tepmlateBody = $this->load->view('email_template/student_change_instructor',$data,true);

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
      $emailParamArr['email_subject'] = 'Notify admin about change instructor';
      $emailParamArr['email_template'] = $tepmlateBody;

      //Send mail to admin when student request for changing instructor
      //$this->send_mail($emailParamArr);

			echo json_encode(array('check'=>'success','msg'=>'Your instructor change request has been successfully submitted, We will get back to you in  a jiffy.'));
			
			/*$last_query_id = $this->db->insert_id();
			$where_del_session_data = array(
										'studentId' => $studentId,
			                            'courseId' => $courseId,
			                            'courseLvl' => $courseLvl,
			                            'instructorId' => $instructorId
				                      );

			if($this->mymodel->delete('student_booked_classes', $where_del_session_data)){
                echo json_encode(array('check'=>'success','msg'=>'Instructor is successfully reset.'));
			}else{
				$where_del_last_query = array('queryId'=>$last_query_id);
				$this->mymodel->delete('change_instructor', $where_del_last_query);
                echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));  
			}*/
		} 
	  }else{
		if($attendedClass<2){
           echo json_encode(array('check'=>'failure','msg'=>"You have to attain atleast two session before change the instructor.")); 
		}else{
           echo json_encode(array('check'=>'failure','msg'=>"You aren't elligible to change current instructor!")); 
		}
	  }	
	}

	public function deleteWishList(){
		 $wishId = $this->testInput($this->input->post('wishId'));

		 $where_del_wishlist = array('wishId' => $wishId);

		 if($this->mymodel->delete('student_course_whishlist', $where_del_wishlist)){
         echo json_encode(array('check'=>'success','msg'=>'Course is successfully removed from wishlist.'));
		 }else{
         echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));  
		 }
	}

	public function addCourseReview(){
		//print_r($_POST);exit;
		$studentId = $this->session->userdata('userId');
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$instructorId = $this->input->post('insId');

		$reviewId = $this->input->post('reviewId');

		$rating = $this->input->post('rating');
		$feedback = $this->testInput($this->input->post('feedback'));

		//Check if user perchased this course
      	$sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

      	//echo $sql_check_purchse_status;exit;

     	 $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();

      	//Check if user perchased this course
      	/*$sql_check_booked_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId'";

      	//echo $sql_check_booked_class;exit;

      	$checkBookClass = $this->db->query($sql_check_booked_class)->num_rows();*/

      	//Count no of session attended
	    $sql_check_attened_class = "SELECT sbc.classId  FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$instructorId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";

	    //echo $sql_check_attened_class;exit;

	    $attendedClass = $this->db->query($sql_check_attened_class)->num_rows();
      
      	if($purchaseCount>0 && $attendedClass>=2){
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

			if(!empty($reviewId)){
	           $where_review_clause = array('reviewId' => $reviewId);
	           //Updating review data into db	
	           if(!$this->mymodel->update($reviewData,'course_review',$where_review_clause)){
	              echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));  
	           }else{
	              echo json_encode(array('check'=>'success','msg'=>'Review is successfully updated.'));
	           }
			}else{
			   $reviewData['status'] = '0';
			   //Inserting review data into db	
	           if(!$this->mymodel->save('course_review', $reviewData)){
	              echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));  
	           }else{
	              echo json_encode(array('check'=>'success','msg'=>'Review is successfully added.'));  
	           }
			}
		}else{
			if($attendedClass<2){
	           echo json_encode(array('check'=>'failure','msg'=>"You have to attain atleast two session before provide review.")); 
			}else{
	           echo json_encode(array('check'=>'failure','msg'=>"You aren't elligible to change current instructor!")); 
			}
		}	
	}

	public function scheduleClass($courseId,$courseLvl,$insId)
	{
			$data['title'] ='My Schedule CLasses';
			$data['page'] = "courselist";
    
    	$userId = $this->session->userdata('userId');

			$data['courseId'] = $courseId;
			$data['courseLvl'] = $courseLvl;
			$data['insId'] = $insId;

			$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

			$courseDetails = $this->mymodel->fetch($sql_course_details, true);

			$sql_enrolled_courses = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.userId = '".$userId."'";  

	    //echo $sql_enrolled_courses;exit;

	    //Feching Enrolled Course List 
		 	$enrolledCoruseDetails = $this->mymodel->fetch($sql_enrolled_courses, true);

      if(!empty($enrolledCoruseDetails)){       
			 	
			 	$data['totalHours'] = $courseDetails->totalHours;
		    
		    //Calculate student bookes season
		    //$sql_student_booked_season = "SELECT sbc.instructorId,TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc LEFT JOIN users u ON (sbc.instructorId=u.userId) WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId = '".$userId."' AND sbc.instructorId='".$insId."' ORDER BY sbc.courseId";  

		    $sql_student_booked_season = "SELECT * FROM (SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' UNION ALL SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes_history WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' AND requestType = '1') AS bookedClassTbl";

		    //echo $sql_student_booked_season;exit; 

		    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);

		    $sql_student_all_booked_season = "SELECT sbc.instructorId FROM student_booked_classes sbc WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId = '".$userId."'";  

		    //echo $sql_student_all_booked_season;exit;

		    $bookedInsData = $this->mymodel->fetch($sql_student_all_booked_season, false);

		    $data['totalBookedSeason'] = 0;
		    
		    //Getting instructor name
		    $sql_get_instructor_name = "SELECT u.firstName,u.lastName FROM users u WHERE u.userId = '".$insId."'";   

		    //echo $sql_get_instructor_name;exit;
		    
		    $instructorDetail =  $this->mymodel->fetch($sql_get_instructor_name, true);

		    $data['instructorName'] = $instructorDetail->firstName.' '.$instructorDetail->lastName;

		    foreach ($diffTime as $key => $time) {
		    	 $data['totalBookedSeason'] +=  round($time->timeDiff);
		    }

		    if((!empty($bookedInsData)?($bookedInsData[0]->instructorId == $insId ? true:false) : true)){
					$this->load->view('student/header',$data);
					$this->load->view('student/schedule_class');
					$this->load->view('student/footer');
			  }else{
	        redirect('student/instructor/'.$courseId.'/'.$courseLvl); 
			  }	
		 }else{
		 	  show_404();
		 }	  	
	}

	public function viewBookedSession($courseId,$courseLvl,$insId)
	{
		
		$data['title'] ='My Booked Session';
		$data['page'] = "courselist";
    
	    $userId = $this->session->userdata('userId');

		$data['courseId'] = $courseId;
		$data['courseLvl'] = $courseLvl;
		$data['insId'] = $insId;

		$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

			$courseDetails = $this->mymodel->fetch($sql_course_details, true);

			$sql_enrolled_courses = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.userId = '".$userId."'";  

	    //echo $sql_enrolled_courses;exit;

	    //Feching Enrolled Course List 
		 	$enrolledCoruseDetails = $this->mymodel->fetch($sql_enrolled_courses, true);

	    //Feching Enrolled Course List 
		 	$data['totalHours'] = $courseDetails->totalHours;
	    
	    //Calculate student bookes season
	    //$sql_student_booked_season = "SELECT sbc.instructorId,TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc LEFT JOIN users u ON (sbc.instructorId=u.userId) WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.instructorId='".$insId."' ORDER BY sbc.courseId";  

	    $sql_student_booked_season = "SELECT * FROM (SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' UNION ALL SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes_history WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$userId."' AND requestType = '1') AS bookedClassTbl";

	    //echo $sql_student_booked_season;exit; 

	    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);

	    $sql_student_all_booked_season = "SELECT sbc.instructorId FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."'";  

	    $bookedInsData = $this->mymodel->fetch($sql_student_all_booked_season, false);

	    $data['totalBookedSeason'] = 0;
	    
	    //Getting instructor name
	    $sql_get_instructor_name = "SELECT u.firstName,u.lastName FROM users u WHERE u.userId = '".$insId."'";   

	    //echo $sql_get_instructor_name;exit;
	    
	    $instructorDetail =  $this->mymodel->fetch($sql_get_instructor_name, true);

	    $data['instructorName'] = $instructorDetail->firstName.' '.$instructorDetail->lastName;

	    foreach ($diffTime as $key => $time) {
	    	 $data['totalBookedSeason'] +=  round($time->timeDiff);
	    }

	    if((!empty($bookedInsData)?($bookedInsData[0]->instructorId == $insId ? true:false) : true)){
			$this->load->view('student/header',$data);
			$this->load->view('student/view_booked_session');
			$this->load->view('student/footer');
		}else{
       redirect('student/instructor/'.$courseId.'/'.$courseLvl); 
		}		
	}

	public function getStudentBookedSessionData(){

		$userId = $this->session->userdata('userId'); 
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$instructorId = $this->input->post('insId');

		$sql_enrolled_courses = "SELECT SUM(DISTINCT chp.totalHours) as totalHours FROM courses c LEFT JOIN student_purchased_courses spc ON (c.courseId=spc.courseId) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.courseLvl ORDER BY spc.courseLvl";  

		 //Feching Enrolled Course List 
	 	 $totalHours = $this->mymodel->fetch($sql_enrolled_courses, true)->totalHours;
    
     //Calculate student bookes season
     $sql_student_booked_season = "SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.studentId = '".$userId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.instructorId='".$instructorId."' ORDER BY sbc.courseId";  

	    //echo $sql_student_booked_season;exit; 

	    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);
	    $totalBookedSeason = 0;

	    foreach ($diffTime as $key => $time) {
	    	$totalBookedSeason +=  round($time->timeDiff);
	    }

	    $leftSeason = $totalHours - $totalBookedSeason;

	    echo json_encode(array('check'=>'success','totalHours'=>$totalHours,'totalBookedSeason'=>$totalBookedSeason,'leftSeason'=>$leftSeason));
	}

	public function fetchSchedule($courseId,$courseLvl,$instructorId)
	{
		$fetchType = "current";

		$userId = $this->session->userdata('userId'); 

		$sql_stu_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as studentName,u.timezone FROM users u WHERE u.userId='".$userId."' AND u.userType='1'";

		$studentDetails = $this->mymodel->fetch($sql_stu_details, true);

		$stu_time_zone = $studentDetails->timezone;

		//Check if user perchased this course
    $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$userId'";

    //echo $sql_check_purchse_status;exit;

    $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();
       
    if($purchaseCount>0){

   		$sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."'";

			$courseDetail = $this->mymodel->fetch($sql_course_details, true);

			$sql_ins_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as instructorName,u.timezone FROM users u WHERE u.userId='".$instructorId."' AND u.userType='2'";

			$instructorDetail = $this->mymodel->fetch($sql_ins_details, true);

			$sql_all_student_booked_class = "SELECT * FROM (SELECT sbc.classDate,sbc.fromTime,sbc.toTime,sbc.timezone,sbc.studentId,sbc.courseLvl,c.courseName FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId=c.courseId WHERE sbc.instructorId = '".$instructorId."' UNION ALL SELECT sbc_his.classDate,sbc_his.fromTime,sbc_his.toTime,sbc_his.studentId,sbc_his.courseLvl,sbc_his.timezone,ch.courseName FROM student_booked_classes_history sbc_his LEFT JOIN courses ch ON sbc_his.courseId=ch.courseId WHERE sbc_his.instructorId = '".$instructorId."' AND sbc_his.requestType = '1') AS bookedClassTbl ORDER BY classDate ASC";

			//echo $sql_all_student_booked_class;exit;
			
			$bookedClassDetail = $this->mymodel->fetch($sql_all_student_booked_class, false);

			$bookedClassArr = [];
			$oldBookedClassArr = [];
			$bookedTimeZoneArr = [];

			$compare_date = date('Y-m-d');
	   	$current_date = date('Y-m-d');

			if(!empty($bookedClassDetail)){

				foreach ($bookedClassDetail as $key => $class) {

					 $singleClassDate = $class->classDate;
					 $single_booked_time_zone = $class->timezone;

					 $fromTime = $class->fromTime;
			     $toTime = $class->toTime;

			     $bookedFrmTime = $singleClassDate." ".$fromTime;
			     $bookedToTime = $singleClassDate." ".$toTime;

			     $bookedFrmTime = new DateTime($bookedFrmTime, new DateTimeZone($single_booked_time_zone));

					 $bookedFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
				   $finalbookedFrmTime = $bookedFrmTime->format('Y-m-d H:i:s');

				   $finalBookedDate = $bookedFrmTime->format('Y-m-d');

					 $bookedToTime = new DateTime($bookedToTime, new DateTimeZone($single_booked_time_zone));

					 $bookedToTime->setTimezone(new DateTimeZone($stu_time_zone));
					 $finalbookedToTime = $bookedToTime->format('Y-m-d H:i:s');
           
           //echo $finalbookedFrmTime."<br>".$finalbookedToTime."<br>";exit;

           if($finalBookedDate >= $current_date){
              
              $bookedClassArr[$key] = date('Y-m-d',strtotime($finalbookedFrmTime));
					    $bookedTimeZoneArr[$key] = $stu_time_zone;
					    $bookedCourseArr[$key]['name'] = $class->courseName;
					    $bookedCourseArr[$key]['level'] = $class->courseLvl;
					    $bookedClassTimeArr[$key]['studentId'] = $class->studentId;
					    $bookedClassTimeArr[$key]['fromTime'] = date('H:i', strtotime($finalbookedFrmTime));
					    $bookedClassTimeArr[$key]['toTime'] = date('H:i', strtotime($finalbookedToTime));

           }
				}
			}else{
					$bookedClassDetail = array();
			}	
      
			//print_r($bookedClassArr);exit;

			$sql_current_student_booked_class = "SELECT * FROM (SELECT sbc.classId,sbc.classDate,sbc.studentId,sbc.fromTime,sbc.toTime,sbc.bookingId,sbc.timezone FROM student_booked_classes sbc WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' AND sbc.instructorId = '".$instructorId."' UNION ALL SELECT sbc_his.classId,sbc_his.classDate,sbc_his.studentId,sbc_his.fromTime,sbc_his.toTime,sbc_his.bookingId,sbc_his.timezone FROM student_booked_classes_history sbc_his WHERE sbc_his.courseId='".$courseId."' AND sbc_his.courseLvl='".$courseLvl."' AND sbc_his.studentId='".$userId."' AND sbc_his.instructorId = '".$instructorId."' AND sbc_his.requestType = '1') AS bookedClassTbl ORDER BY classDate ASC";

			//echo $sql_current_student_booked_class;exit;
	        
	    $currentBookedClassDetail = $this->mymodel->fetch($sql_current_student_booked_class, false);
      
      $currentBookedClassTimeZoneArr = [];
			$currentBookedClassArr = [];
			$currentBookingIdArr = [];
			$currentClassIdArr = [];
	        
	    if(!empty($currentBookedClassDetail)){
				foreach ($currentBookedClassDetail as $key => $class) {

					 $singleClassDate = $class->classDate;
					 $single_booked_time_zone = $class->timezone;

					 $fromTime = $class->fromTime;
			     $toTime = $class->toTime;

			     $bookedFrmTime = $singleClassDate." ".$fromTime;
			     $bookedToTime = $singleClassDate." ".$toTime;

			     $bookedFrmTime = new DateTime($bookedFrmTime, new DateTimeZone($single_booked_time_zone));

					 $bookedFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
				   $finalbookedFrmTime = $bookedFrmTime->format('Y-m-d H:i:s');

				   $finalBookedDate = $bookedFrmTime->format('Y-m-d');

					 $bookedToTime = new DateTime($bookedToTime, new DateTimeZone($single_booked_time_zone));

					 $bookedToTime->setTimezone(new DateTimeZone($stu_time_zone));
					 $finalbookedToTime = $bookedToTime->format('Y-m-d H:i:s');
           
           //echo $finalbookedFrmTime."<br>".$finalbookedToTime."<br>";exit;

           if($finalBookedDate >= $current_date){

							$currentBookedClassTimeZoneArr[$key] = $class->timezone;
							$currentBookedClassArr[$key] = $class->classDate;
							$currentBookingIdArr[$key] = $class->bookingId;
							$currentClassIdArr[$key] = $class->classId;
							$currentClassTimeArr[$key]['studentId'] = $class->studentId;
							$currentClassTimeArr[$key]['fromTime'] = $class->fromTime;
						  $currentClassTimeArr[$key]['toTime'] = $class->toTime;

					 }else{

					 	  $oldCrntBookedClassTimeZoneArr[$key] = $class->timezone;
							$oldCrntBookedClassArr[$key] = $class->classDate;
							$oldCrntBookingIdArr[$key] = $class->bookingId;
							$oldCrntClassIdArr[$key] = $class->classId;
							$oldCrntClassTimeArr[$key]['studentId'] = $class->studentId;
							$oldCrntClassTimeArr[$key]['fromTime'] = $class->fromTime;
						  $oldCrntClassTimeArr[$key]['toTime'] = $class->toTime;
					 }	  
				}
			}else{
				$currentBookedClassTimeZoneArr = [];
				$currentBookedClassArr = [];
				$currentBookingIdArr = [];
				$currentClassIdArr = [];
			}	
      
      if(!empty($currentBookedClassArr)){
					//reseting index of the constructed array
					$currentBookedClassTimeZoneArr = array_values($currentBookedClassTimeZoneArr);
					$currentBookedClassArr = array_values($currentBookedClassArr);
					$currentBookingIdArr = array_values($currentBookingIdArr);
					$currentClassIdArr = array_values($currentClassIdArr);
					$currentClassTimeArr = array_values($currentClassTimeArr);
			}
			
			if(!empty($oldCrntBookedClassArr)){		
			
					$oldCrntBookedClassTimeZoneArr = array_values($oldCrntBookedClassTimeZoneArr);
					$oldCrntBookedClassArr = array_values($oldCrntBookedClassArr);
					$oldCrntBookingIdArr = array_values($oldCrntBookingIdArr);
					$oldCrntClassIdArr = array_values($oldCrntClassIdArr);
					$oldCrntClassTimeArr = array_values($oldCrntClassTimeArr);
			}		

			//print_r($currentBookedClassArr);exit;
				
    	$list=array();
    	$scheduleBgColorCdArr = array('#44760f','#ff0000','#d816c7','#102ce9','#044f16','#950202','#6e0769','#723c03','#000000');
			
			if($fetchType == "current"){
				/*$current_date = date('Y-m-d');
				$day = date('d',strtotime('+1 days',strtotime($current_date)));
				$month = date('m');*/

				$sql_stu_last_booking_date = "SELECT * FROM (SELECT classDate FROM student_booked_classes WHERE `studentId`='".$userId."' UNION ALL SELECT classDate FROM student_booked_classes_history WHERE `studentId`='".$userId."' AND requestType = '1') as bkdClassTbl ORDER BY classDate ASC LIMIT 1";

				//echo $sql_stu_last_booking_date;exit;	

	    	$lastBookedClassData = $this->mymodel->fetch($sql_stu_last_booking_date, true);

	    	$start_date = date('Y-m-d',strtotime('+1 days',strtotime($current_date)));

				/*if(!empty($lastBookedClassData) && $lastBookedClassData->classDate <= $compare_date){
					$last_date = $lastBookedClassData->classDate;
					$day = date('d',strtotime($last_date));
					$month = date('m',strtotime($last_date));
					$year = date('Y',strtotime($last_date));
				}else{*/
					$day = date('d',strtotime($start_date));
					$month = date('m',strtotime($start_date));
					$year = date('Y',strtotime($start_date));
				//}	
			}

			else if($fetchType == "next"){
				$nxt_month_date = date('Y-m-d', strtotime('first day of next month'));

				$day = date('d', strtotime($start_date));
				$month = date('m', strtotime($start_date));
				$year = date('Y');

				$start_date = date('Y-m-d',strtotime('+1 days',strtotime($nxt_month_date)));
			}

			else if($fetchType == "previous"){
				$prev_month_date = date('Y-m-d', strtotime('first day of previous month'));

				$day = date('d', strtotime('first day of previous month'));
				$month = date('m', strtotime('first day of previous month'));
				$year = date('Y');

				$start_date = date('Y-m-d',strtotime('+1 days',strtotime($prev_month_date)));
			}

			//echo $day."-".$month."-".$year;exit;
				
			$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";
			
			$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

			//print_r($scheduleTime);exit;

			$date = date('Y-m-d');
      
      $tday = date('d', strtotime($date));
      $tmonth = date('m', strtotime($date));
			$tyear = date('Y', strtotime($date));

			$allowedDayArr = explode(',', $scheduleTime->weekdays);

			$index = 0;
      
    	for($m = $month; $m<=12; $m++){ 

				  $current_day = $day;
				  $current_month = $m;
				  $current_year = $year;

	        $currentMonthDays = cal_days_in_month(CAL_GREGORIAN, $m, $year);

					/*echo "---".$currentMonthDays."<br>";
					echo $current_month."<br>";
					echo $current_day."<br>";
					echo $current_year."<br>";*/

					for($d=$current_day; $d<=$currentMonthDays; $d++){
							
					    $time=strtotime($current_year.'-'.$current_month.'-'.$d);    
					    $current_full_date = date('Y-m-d',$time);

					    $insSetDate = date('Y-m-d', $time);  

				    	//echo $insSetDate."<br>";  

			    	  $list[$index]['id'] = $index;

			    	  $fromInsTime = $scheduleTime->fromTime;
					    $toInsTime = $scheduleTime->toTime;

					    $insSetFrmTime = $insSetDate." ".$fromInsTime;
					    $insSetToTime = $insSetDate." ".$toInsTime;
              
              //Calculating instructor time in their timezone
					    $insDateTime = new DateTime("@".strtotime($insSetFrmTime));

							$insDateTime->setTimezone(new DateTimeZone($instructorDetail->timezone));
							$finalInsDateTime = $insDateTime->format('Y-m-d');

							$index_day = date('l', strtotime($finalInsDateTime));

              if(in_array($index_day,$allowedDayArr)){

							    $insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($instructorDetail->timezone));

									$insSetFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
									$finalInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');

									$insSetToTime = new DateTime($insSetToTime, new DateTimeZone($instructorDetail->timezone));

									$insSetToTime->setTimezone(new DateTimeZone($stu_time_zone));
									$finalInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');

									$list[$index]['date']=$insSetFrmTime->format('Y-m-d');

									$current_converted_date = $list[$index]['date'];
									
									
					        //Customizing extended property
					        $list[$index]['instructor'] = $instructorDetail->instructorName;
					        
					        $list[$index]['allDay'] = true;

							    if (date('m', $time)==$current_month && in_array($index_day,$allowedDayArr) 
							    	  || in_array($current_converted_date,$currentBookedClassArr)){ 

							    	$all_bkd_position = array_search($current_converted_date, $bookedClassArr);  

							   		if(!empty($bookedClassArr) && in_array($current_converted_date,$bookedClassArr)){

							   			//echo $current_converted_date."<br>";

							   			$list[$index]['course'] = $bookedCourseArr[$all_bkd_position]['name'];
						          $list[$index]['courseLvl'] = ucfirst($bookedCourseArr[$all_bkd_position]['level']);

											if(!empty($currentBookedClassArr) && in_array($current_converted_date,$currentBookedClassArr)){
												$position = array_search($current_converted_date, $currentBookedClassArr);
												$booked_time_zone = $currentBookedClassTimeZoneArr[$position]; 
												$bookingId = $currentBookingIdArr[$position];
												$classTimeArr = $currentClassTimeArr[$position];

												$fromTime = $classTimeArr['fromTime'];
												$toTime = $classTimeArr['toTime'];

												$classDate = $currentBookedClassArr[$position];
												$studentId = $classTimeArr['studentId'];

												//echo $booked_time_zone."***".$instructorDetail->timezone;exit;

												/*if($booked_time_zone != $instructorDetail->timezone){

														$insSetFrmTime = $classDate." ".$fromTime;
												    $insSetToTime = $classDate." ".$toTime;

														$insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($instructorDetail->timezone));

														$insSetFrmTime->setTimezone(new DateTimeZone($booked_time_zone));
														$IntInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');

														$insSetToTime = new DateTime($insSetToTime, new DateTimeZone($instructorDetail->timezone));

														$insSetToTime->setTimezone(new DateTimeZone($booked_time_zone));
														$IntInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');

														$list[$index]['classDate']=$insSetFrmTime->format('jS F, Y');
						        	   	  $list[$index]['classRawDate']=$insSetFrmTime->format('Y-m-d');

														$list[$index]['title'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
														$list[$index]['classTime'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
								        		$list[$index]['fromTime']=date('H:i', strtotime($finalInsSetFrmTime));
								        		$list[$index]['toTime']=date('H:i', strtotime($finalInsSetToTime));

								        }

												if($booked_time_zone != $studentDetails->timezone){

														$insSetFrmTime = $classDate." ".$fromTime;
												    $insSetToTime = $classDate." ".$toTime;

														$insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($booked_time_zone));

														$insSetFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
														$finalInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');

														$insSetToTime = new DateTime($insSetToTime, new DateTimeZone($booked_time_zone));

														$insSetToTime->setTimezone(new DateTimeZone($stu_time_zone));
														$finalInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');

														$list[$index]['classDate']=$insSetFrmTime->format('jS F, Y');
						        	   	  $list[$index]['classRawDate']=$insSetFrmTime->format('Y-m-d');

														$list[$index]['title'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
														$list[$index]['classTime'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
								        		$list[$index]['fromTime']=date('H:i', strtotime($finalInsSetFrmTime));
								        		$list[$index]['toTime']=date('H:i', strtotime($finalInsSetToTime));

								        }else{
													  
													 $fromTime = $classTimeArr['fromTime'];
												   $toTime = $classTimeArr['toTime'];

												   $list[$index]['classDate']=date('jS F, Y', strtotime($classDate));
						        	  	 $list[$index]['classRawDate']=date('Y-m-d', strtotime($classDate));
												   
												   $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
												   $list[$index]['classTime'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
							        	   $list[$index]['fromTime']=date('H:i', strtotime($fromTime));
							        	   $list[$index]['toTime']=date('H:i', strtotime($toTime));
												}*/		

												$fromInsTime = $scheduleTime->fromTime;
										    $toInsTime = $scheduleTime->toTime;

										    $insSetFrmTime = $insSetDate." ".$fromInsTime;
										    $insSetToTime = $insSetDate." ".$toInsTime;

										    $insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($instructorDetail->timezone));

												$insSetFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
											  $finalInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');
				 
												$insSetToTime = new DateTime($insSetToTime, new DateTimeZone($instructorDetail->timezone));

												$insSetToTime->setTimezone(new DateTimeZone($stu_time_zone));
												$finalInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');

												$list[$index]['classDate']=$insSetFrmTime->format('jS F, Y');
						        	  $list[$index]['classRawDate']=$insSetFrmTime->format('Y-m-d');

												$list[$index]['title'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
												$list[$index]['classTime'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
								        $list[$index]['fromTime']=date('H:i', strtotime($finalInsSetFrmTime));
								        $list[$index]['toTime']=date('H:i', strtotime($finalInsSetToTime));

												if($current_converted_date>=$start_date){
				                                    
											    $list[$index]['className'] = "show-schedule-info";
											    $list[$index]['checkboxId'] = "class_".$index;
											    //$list[$index]['display'] = "background";
											    $list[$index]['classId'] = $currentClassIdArr[$position];
						            	$list[$index]['url'] = 'javascript:void(0)';
						            	$list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
													$list[$index]['booking_status'] = "booked";
													$list[$index]['modify_permission'] = true;
													$list[$index]['bookingId'] = $bookingId;

													/*if(in_array($index_day,$allowedDayArr)){
				                     $list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
													}else{
				                     $list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
													}*/
												}else{
												   $list[$index]['color'] = "#B6B40F";
										       $list[$index]['booking_status'] = "booked";	
										       $list[$index]['modify_permission'] = false;
												}	
											}else{

											   $position = array_search($current_converted_date, $bookedClassArr); 
											   $booked_time_zone = $bookedTimeZoneArr[$position]; 
											   $classTimeArr = $bookedClassTimeArr[$position];

											   //$list[$index]['classDate']=date('jS F, Y', $time);
						        	   //$list[$index]['classRawDate']=date('Y-m-d', $time);

											   $studentId = $classTimeArr['studentId'];

											   //echo $userId."***".$studentId;exit;

											   //echo $current_converted_date;exit;
											
						        	   $fromTime = $classTimeArr['fromTime'];
										     $toTime = $classTimeArr['toTime'];

												 $list[$index]['classDate']=date('jS F, Y',strtotime($current_converted_date));
						        	   $list[$index]['classRawDate']=date('Y-m-d',strtotime($current_converted_date));

												 $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
												 $list[$index]['classTime'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
								         $list[$index]['fromTime']=date('H:i', strtotime($fromTime));
								         $list[$index]['toTime']=date('H:i', strtotime($toTime));

								         //echo $list[$index]['classDate']."<br>";

						        	   if($userId == $studentId){
						        	   	  if($current_converted_date>=$start_date){
						        	   	  	 $list[$index]['color'] = "#58ce16";
						        	   	  }else{
						        	   	  	$list[$index]['color'] = "#0071dc";
						        	   	  }
						        	   	  
						        	   }else{
				                    $list[$index]['color'] = "#db5382";
						        	   }
													
											   $list[$index]['booking_status'] = "booked";	
											   $list[$index]['modify_permission'] = false;
								      }	
										
								   }else{

								   	 $fromInsTime = $scheduleTime->fromTime;
								     $toInsTime = $scheduleTime->toTime;

								     $insSetFrmTime = $insSetDate." ".$fromInsTime;
								     $insSetToTime = $insSetDate." ".$toInsTime;

								     $insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($instructorDetail->timezone));

										 $insSetFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
									   $finalInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');
		 
										 $insSetToTime = new DateTime($insSetToTime, new DateTimeZone($instructorDetail->timezone));

										 $insSetToTime->setTimezone(new DateTimeZone($stu_time_zone));
										 $finalInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');
							   	 	
									   $list[$index]['classDate']=$insSetFrmTime->format('jS F, Y');
				        	   $list[$index]['classRawDate']=$insSetFrmTime->format('Y-m-d');

								 		 $list[$index]['title'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
								     $list[$index]['classTime']=date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
				        		 $list[$index]['fromTime']=date('H:i', strtotime($finalInsSetFrmTime));
				        		 $list[$index]['toTime']=date('H:i', strtotime($finalInsSetToTime));

								     if($current_converted_date>=$start_date){	
								     	 
								     	 $list[$index]['course'] = $courseDetail->courseName;
						        	 $list[$index]['courseLvl'] = ucfirst($courseLvl);

										   $list[$index]['className'] = "show-schedule-info";
										   $list[$index]['checkboxId'] = "class_".$index;
								       //$list[$index]['display'] = "background";
								       $list[$index]['classId'] = null;
						           $list[$index]['url'] = 'javascript:void(0)';
										   $list[$index]['color'] = "#4bd863";//$scheduleBgColorCdArr[0];
										   $list[$index]['booking_status'] = "available";
										   $list[$index]['modify_permission'] = true;
										 }else{
										   $list[$index]['color'] = "#f71313";
										   $list[$index]['booking_status'] = "booked";	
										   $list[$index]['modify_permission'] = false;
										 }  
								  }	

								  $index++;
							}	  
					  }

					  if($d == $currentMonthDays){
					    $day = date('d', strtotime('first day of next month',strtotime($date)));
					  }    
				  }

		      if( ($m == 12 && $year < $tyear) || ($tmonth < 12 && $tyear == $year) ){
		         $m = date('m', strtotime('first day of next month', strtotime($current_full_date)));
		         $year = date("Y", strtotime('first day of next month', strtotime($current_full_date)));

		         $m = $m-1;
		      }
		    }	

		    $oldBookedData = [];

		    //print_r($oldCrntBookedClassArr);

		    if(!empty($oldCrntBookedClassArr)){

		        //Constructing old booked dates for final merge
				    foreach($oldCrntBookedClassArr as $index => $classDate){

		       	  $booked_time_zone = $oldCrntBookedClassTimeZoneArr[$index]; 
							$classTimeArr = $oldCrntClassTimeArr[$index];

							$fromTime = $classTimeArr['fromTime'];
							$toTime = $classTimeArr['toTime'];
		       	 
					    $insSetFrmTime = $classDate." ".$fromTime;
					    $insSetToTime = $classDate." ".$toTime;

					    $insSetFrmTime = new DateTime($insSetFrmTime, new DateTimeZone($booked_time_zone));

							$insSetFrmTime->setTimezone(new DateTimeZone($stu_time_zone));
						  $finalInsSetFrmTime = $insSetFrmTime->format('Y-m-d H:i:s');

							$insSetToTime = new DateTime($insSetToTime, new DateTimeZone($booked_time_zone));

							$insSetToTime->setTimezone(new DateTimeZone($stu_time_zone));
							$finalInsSetToTime = $insSetToTime->format('Y-m-d H:i:s');

							$oldBookedData[$index]['date']=$insSetFrmTime->format('Y-m-d');
		          
		          $oldBookedData[$index]['instructor'] = $instructorDetail->instructorName;
							$oldBookedData[$index]['course'] = $courseDetail->courseName;
							$oldBookedData[$index]['courseLvl'] = ucfirst($courseLvl);
		       
			        $oldBookedData[$index]['classDate']=$insSetFrmTime->format('jS F, Y');
				  	  $oldBookedData[$index]['classRawDate']=$insSetFrmTime->format('Y-m-d');

						  $oldBookedData[$index]['title'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
						  $oldBookedData[$index]['classTime'] = date('g:i A',strtotime($finalInsSetFrmTime)).' - '.date('g:i A',strtotime($finalInsSetToTime));
				      $oldBookedData[$index]['fromTime']=date('H:i', strtotime($finalInsSetFrmTime));
				      $oldBookedData[$index]['toTime']=date('H:i', strtotime($finalInsSetToTime));
				                          
			    	  $oldBookedData[$index]['color'] = "#B6B40F";//$scheduleBgColorCdArr[0];
						  $oldBookedData[$index]['booking_status'] = "booked";
						  $oldBookedData[$index]['modify_permission'] = false;

						}	 
		        
		        //Merging old and new class data 
						$list = array_merge($oldBookedData,$list);

				}	

				//print_r($list);exit;

	  	  echo json_encode($list);
	  	}else{
         echo json_encode(array('check'=>'failure','msg'=>"You aren't elligible to view this instructor's schedule!"));
	  	}   
		
	}

	public function viewBookedSchedule($courseId,$courseLvl,$instructorId)
	{

		$userId = $this->session->userdata('userId'); 

		$sql_current_student_booked_class = "SELECT * FROM (SELECT sbc.classId,sbc.classDate,sbc.studentId,sbc.fromTime,sbc.toTime,sbc.bookingId FROM student_booked_classes sbc WHERE sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.studentId='".$userId."' AND sbc.instructorId = '".$instructorId."' UNION ALL SELECT sbc_his.classId,sbc_his.classDate,sbc_his.studentId,sbc_his.fromTime,sbc_his.toTime,sbc_his.bookingId FROM student_booked_classes_history sbc_his WHERE sbc_his.courseId='".$courseId."' AND sbc_his.courseLvl='".$courseLvl."' AND sbc_his.studentId='".$userId."' AND sbc_his.instructorId = '".$instructorId."' AND sbc_his.requestType = '1') AS bookedClassTbl ORDER BY classDate ASC";

		//echo $sql_current_student_booked_class;exit;
        
    $bookedClassDetail = $this->mymodel->fetch($sql_current_student_booked_class, false);

		$currentBookedClass = [];
        
    	if(!empty($bookedClassDetail)){
		
			foreach ($bookedClassDetail as $key => $class) {
				$currentBookedClass[$key] = $class->classDate;
			}
		}

    $list=array();

    $sql_stu_last_booking_date = "SELECT * FROM (SELECT classDate FROM student_booked_classes WHERE `studentId`='".$userId."' UNION ALL SELECT classDate FROM student_booked_classes_history WHERE `studentId`='".$userId."' AND requestType = '1') as bkdClassTbl ORDER BY classDate ASC LIMIT 1";

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

			 for($d=$current_day; $d<=$currentMonthDays; $d++){

			    $time=strtotime($current_year.'-'.$current_month.'-'.$d);    
			    $index_day = date('l', $time);
			    $current_full_date = date('Y-m-d',$time);

			    $list[$index]['allDay'] = true;

			    if (date('m', $time)==$current_month && in_array($index_day,$allowedDayArr)){    

			    	//echo $current_full_date."<br>";
			    	
						if(!empty($currentBookedClass) && in_array($current_full_date,$currentBookedClass)){

							 //echo "Booked Class:- ".$current_full_date."<br>";

	             $list[$index]['id'] = $index; 
				       $list[$index]['constraint'] = "Available";
				       $list[$index]['date']=date('Y-m-d', $time);

		           $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
							 $list[$index]['className'] = "show-schedule-info";
			         $list[$index]['url'] = 'javascript:void(0)';

			         if($current_full_date>=$start_date){
								  $list[$index]['color'] = "#fd6a03";//$scheduleBgColorCdArr[0];
							 }else{
							 	  $list[$index]['color'] = "#B6B40F";//$scheduleBgColorCdArr[0];
							 }	 
							 $list[$index]['booking_status'] = "booked";
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

	public function bookClass(){
		//print_r($_POST);exit;
		$studentId = $this->input->post('studentId');
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$insId = $this->input->post('insId');
        
    	//Formatting clas Date  
		$classDate = date('Y-m-d',strtotime($this->input->post('classDate')));
        
        //Formatting clas Time
		$classTime = $this->input->post('classTime');
		$classTimeArr = explode('-', $classTime);

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

		//Insert schedule time data into db
	  if(!$this->mymodel->save('student_booked_classes', $scheduleData)){
	       echo json_encode(array('check'=>'failure'));
	  }else{
	     echo json_encode(array('check'=>'success'));	
	  }	
	}

	public function bookStudentSeason(){
		 //print_r($_POST);exit;
		 $studentId = $this->session->userdata('userId');
		 $courseId = $this->input->post('courseId');
		 $courseLvl = $this->input->post('courseLvl');
		 $insId = $this->input->post('insId');

		 $dbQueryExeError = false;
		 $getTotalSeason = 0;

		 $ADMIN_NAME = $this->config->item('ADMIN_NAME');
     $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
     $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		 $BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		 $BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		 $BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

		 $classData = $this->input->post('classData');

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

	    foreach ($classData as $index => $class) {
	       
	       if($class['classId'] == 'null'){
	       	  				        
					  //Formatting clas Time
						$classTimeArr = explode('-', $class['classTime']);

						$fromTime = strtotime($classTimeArr[0]);
						$toTime = strtotime($classTimeArr[1]);

						$getTotalSeason += abs($toTime - $fromTime) / 3600;
	       }else{
	       	  if($class['classAvail'] == "freed"){
		       	//Formatting clas Time
				$classTimeArr = explode('-', $class['classTime']);

				$fromTime = strtotime($classTimeArr[0]);
				$toTime = strtotime($classTimeArr[1]);

				$getTotalSeason -= abs($toTime - $fromTime) / 3600;
			}	
	       }
	    }

    	if(($totalHours - ($getTotalSeason+$totalBookedSeason))>=-1){

			foreach ($classData as $index => $class) {
		 	   
		 	   if($class['classId'] == 'null'){
		 	     //Formatting clas Date  
				  $classDate = date('Y-m-d',strtotime($class['classDate']));
				        
			     //Formatting clas Time
				  $classTimeArr = explode('-', $class['classTime']);

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

		 	   	  //Check if schedule date is already exist under current instructor
		 	   	  $sql_check_unique_class_count = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.instructorId = '".$insId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.classDate='".$classDate."' AND sbc.fromTime='".$fromTime."' AND sbc.toTime='".$toTime."'";

		 	   	  //echo $sql_check_unique_class_count;exit;

            $countClass = $this->db->query($sql_check_unique_class_count)->num_rows();

            if($countClass == 0){
			 	   	   //Saving sesaon data into db
			 	   	   if(!$this->mymodel->save('student_booked_classes', $scheduleData)){
						      $dbQueryExeError = true;
						   }else{
						   	   	$data['title'] = 'Notify instructor about class booking';

						   	   	$classId = $this->db->insert_id();

						   	   	$sql_class_details = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,c.courseId,c.courseName,u.userId as studentId,i.userId as instructorId,CONCAT(u.firstName,' ',u.lastName) as studentName,CONCAT(i.firstName,' ',i.lastName) as instructorName,i.email FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.classId = '".$classId."'";

										$bookedClassDetails = $this->mymodel->fetch($sql_class_details, true);

										$bookedClassDetailArr = json_decode(json_encode($bookedClassDetails),true);

								    $swap_var['student_name'] = $bookedClassDetailArr['studentName'];
										$swap_var['course_name'] = $bookedClassDetailArr['courseName'];
										$swap_var['class_date'] = date('jS F, Y',strtotime($bookedClassDetailArr['classDate']));
										$swap_var['course_level'] = ucfirst($bookedClassDetailArr['courseLvl']);
										$swap_var['from_time'] = date('H:i A', strtotime($bookedClassDetailArr['fromTime']));
										$swap_var['to_time'] = date('H:i A', strtotime($bookedClassDetailArr['toTime']));
										$swap_var['instructor_url'] = base_url();
										$swap_var['business_address'] = $BUSINESS_ADDRESS;
										$swap_var['business_phone'] = $BUSINESS_PHONE;
										$swap_var['business_email'] = $BUSINESS_EMAIL;

										$tepmlateBody = $this->load->view('email_template/student_class_booking',$data,true);

										//echo $tepmlateBody."<br>";

						        foreach (array_keys($swap_var) as $key){
						          if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
						            $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
						          }
						        }

						        $emailParamArr['sender_name'] = $ADMIN_NAME;
						        $emailParamArr['sender_email'] = $ADMIN_MAIL;
						        $emailParamArr['receiver_name'] = $bookedClassDetailArr['instructorName'];
						        $emailParamArr['receiver_email'] = $bookedClassDetailArr['email'];
						        $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
						        $emailParamArr['email_subject'] = 'Notify instructor about class booking';
						        $emailParamArr['email_template'] = $tepmlateBody;

						        //Sending mail
                    //$this->send_mail($emailParamArr);

						   }
				   }else{
				  	   $uniqueDateErrTxt = date('jS F, Y',strtotime($classDate))." from ".$classTimeArr[0]." to ".$classTimeArr[1]." is booked by someone else!";
				  	   echo json_encode(array('check'=>'failure','msg'=>$uniqueDateErrTxt));
				  	   exit;	
				   }  
		 	   }else{
		 	   	  if($class['classAvail'] == "freed"){
		 	   	  	  $where_del_booked_class = array('classId' => $class['classId']);

		 	   	  	  $sql_class_details = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,c.courseId,c.courseName,u.userId as studentId,i.userId as instructorId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.email,CONCAT(i.firstName,' ',i.lastName) as instructorName FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.classId = '".$classId."'";

								$bookedClassDetails = $this->mymodel->fetch($sql_class_details, true);

								$bookedClassDetailArr = json_decode(json_encode($bookedClassDetails),true);

						  	$data['title'] = 'Notify instructor about class cancellation';

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

								$tepmlateBody = $this->load->view('email_template/intructor_cancel_class_notify',$data,true);

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

					  	  //Delete schedule time data into db
					    	if(!$this->mymodel->delete('student_booked_classes', $where_del_booked_class)){
	                 $dbQueryExeError = true;
						  	}else{
					        //Sending mail to instructor to inform about class cancellation
					        //$this->send_mail($emailParamArr);
						  	}
		 	   	  }
		 	   }
		 }

		 if(!$dbQueryExeError){
       		echo json_encode(array('check'=>'success'));	
		 }else{
		 	echo json_encode(array('check'=>'failure'));	
		 }
		}else{
			echo json_encode(array('check'=>'failure','msg'=>'You have exausted all your sessions,Please remove a session to book another.'));
		}
		 
	}

	public function manageStudentSessionData(){
		 //print_r($_POST);exit;
		 $studentId = $this->session->userdata('userId');
		 $courseId = $this->input->post('courseId');
		 $courseLvl = $this->input->post('courseLvl');
		 $insId = $this->input->post('insId');
		 $bookingStatus = $this->input->post('bookingStatus');
     
     //Fetching students details
		 $sql_stu_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as studentName,u.timezone FROM users u WHERE u.userId='".$studentId."' AND u.userType='1'";

		 $studentDetails = $this->mymodel->fetch($sql_stu_details, true);

		 $stu_time_zone = $studentDetails->timezone;
     
     //Fetching instructor details 
		 $sql_ins_details = "SELECT CONCAT(u.firstName,' ',u.lastName) as insName,u.timezone FROM users u WHERE u.userId='".$insId."' AND u.userType='2'";

		 $instructorDetails = $this->mymodel->fetch($sql_ins_details, true);

		 $ins_time_zone = $instructorDetails->timezone;

		 //Schedule data
		 $id = $this->input->post('id');
		 $classId = $this->input->post('classId');
		 //Formatting class Date  
		 $classDate = date('Y-m-d',strtotime($this->input->post('classRawDate')));

		 $ADMIN_NAME = $this->config->item('ADMIN_NAME');
     $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
     $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

		 $BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
		 $BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
		 $BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

     //Formatting clas Time
		 $classTime = $this->input->post('classTime');

		 $classTimeArr = explode('-', $classTime);

     $fromTimeIns = $classTimeArr[0];
	   $toTimeIns = $classTimeArr[1];

     $classFrmTime = $classDate." ".$fromTimeIns;
     $classToTime = $classDate." ".$toTimeIns;

     $classFrmTime = new DateTime($classFrmTime, new DateTimeZone($stu_time_zone));

		 $classFrmTime->setTimezone(new DateTimeZone($ins_time_zone));
		 $finalClassFrmTime = $classFrmTime->format('Y-m-d H:i:s');

		 $classToTime = new DateTime($classToTime, new DateTimeZone($stu_time_zone));

		 $classToTime->setTimezone(new DateTimeZone($ins_time_zone));
		 $finalClassToTime = $classToTime->format('Y-m-d H:i:s');

     //Check if user perchased this course
     $sql_check_purchse_status = "SELECT spc.purchaseId FROM student_purchased_courses spc WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl' AND spc.userId='$studentId'";

     //echo $sql_check_purchse_status;exit;

     $purchaseCount = $this->db->query($sql_check_purchse_status)->num_rows();
     
     if($purchaseCount>0){

     	$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$insId."'";
		
	    $scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

	    //print_r($scheduleTime);exit;
	    $date = date('Y-m-d');

	    $allowedDayArr = explode(',', $scheduleTime->weekdays);
	    $class_date = date('Y-m-d', strtotime($finalClassFrmTime));
	    $current_day = date('l', strtotime($finalClassFrmTime));
	    $stu_current_day = date('l', strtotime($classDate));

	    $sql_check_existing_booking = "SELECT sbc.* FROM student_booked_classes sbc WHERE sbc.instructorId='".$insId."'";
		
	    $allBookedDates = $this->mymodel->fetch($sql_check_existing_booking, false);

	    $classBooked = false;

      foreach ($allBookedDates as $dayIndex => $date) {
          $class_Date = $date->classDate;
          $from_Time = $date->fromTime;
          $stu_Time_Zone = $date->timezone;

			    $class_Time = $class_Date." ".$from_Time;

			    $class_Time = new DateTime($class_Time, new DateTimeZone($stu_Time_Zone));

					$class_Time->setTimezone(new DateTimeZone($ins_time_zone));
					$final_Class_Time = $class_Time->format('Y-m-d');

					if(strtotime($final_Class_Time) == strtotime($class_date)){
						 $classBooked = true;
					}
      }   

      //var_dump($classBooked);exit; 

		  if(in_array($current_day,$allowedDayArr)){ 
				 
				 $sql_course_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'"; 

				 //Feching Enrolled Course List 
			 	 $totalHours = $this->mymodel->fetch($sql_course_details, true)->totalHours;
		    
			   //Calculate student bookes season
			   //$sql_student_booked_season = "SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.studentId = '".$studentId."' AND sbc.courseId='".$courseId."' AND sbc.courseLvl='".$courseLvl."' AND sbc.instructorId='".$insId."' ORDER BY sbc.courseId";  

			   $sql_student_booked_season = "SELECT * FROM (SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$studentId."' UNION ALL SELECT TIMEDIFF(toTime , fromTime) as timeDiff FROM student_booked_classes_history WHERE courseId='".$courseId."' AND courseLvl='".$courseLvl."' AND studentId='".$studentId."' AND requestType = '1') AS bookedClassTbl";

			    //echo $sql_student_booked_season;exit; 

			    $diffTime = $this->mymodel->fetch($sql_student_booked_season, false);
			    $totalBookedSeason = 0;

			    foreach ($diffTime as $key => $time) {
			       $totalBookedSeason +=  round($time->timeDiff);
			    }

	        $getTotalSeason = abs(strtotime($toTimeIns) - strtotime($fromTimeIns)) / 3600;

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
															 'timezone' => $stu_time_zone,
															 'created'=>date('Y-m-d H:i:s')
														  );
					  
					  	//print_r($scheduleData);exit;

		 	   	 	 	//Check if schedule date is already exist under current instructor
		 	   	  	$sql_check_unique_class_count = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.instructorId = '".$insId."' AND sbc.classDate='".$classDate."' AND sbc.fromTime='".$fromTime."' AND sbc.toTime='".$toTime."'";

		 	   	  	//echo $sql_check_unique_class_count;exit;

		        	$countClass = $this->db->query($sql_check_unique_class_count)->num_rows();

		        	$sql_check_booked_class = "SELECT sbc.classId FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND sbc.instructorId='$insId' AND DATE(`created`) = CURDATE()";

							//echo $sql_check_booked_class;exit;

							$bookedClassCount = $this->db->query($sql_check_booked_class)->num_rows();

		          if($countClass == 0){
				 	   	   //Saving sesaon data into db
				 	   	   if(!$this->mymodel->save('student_booked_classes', $scheduleData)){
				 	   	   	  
					 	   	 		  $sessionData['totalHours'] = (int) $totalHours;
					        	  $sessionData['totalBookedSeason'] = $totalBookedSeason;
					        	  $sessionData['leftSeason'] = $totalBookedSeason;

							      	echo json_encode(array('check'=>'failure','sessionData'=>$sessionData,'msg'=>'Something went wrong, Please try again.','classDate'=>$classDate));	
							   }else{
							   	  
							    	  $sessionData['totalHours'] = (int) $totalHours;
					        	  $sessionData['totalBookedSeason'] = ($getTotalSeason+$totalBookedSeason);
					        	  $sessionData['leftSeason'] = $totalHours - ($getTotalSeason+$totalBookedSeason);

									    if(!$bookedClassCount>0){

							        	  $data['title'] = 'Notify instructor about class booking';

									   	   	$classId = $this->db->insert_id();

									   	    $sql_class_details = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,c.courseId,c.courseName,u.userId as studentId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.email as studentEmail,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as instructorName,i.email as instructorEmail FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.classId = '".$classId."'";

													$bookedClassDetails = $this->mymodel->fetch($sql_class_details, true);

													$bookedClassDetailArr = json_decode(json_encode($bookedClassDetails),true);

											    $swap_var['student_name'] = $bookedClassDetailArr['studentName'];
													$swap_var['course_name'] = $bookedClassDetailArr['courseName'];
													$swap_var['class_date'] = date('jS F, Y',strtotime($bookedClassDetailArr['classDate']));
													$swap_var['course_level'] = ucfirst($bookedClassDetailArr['courseLvl']);
													$swap_var['from_time'] = date('H:i A', strtotime($bookedClassDetailArr['fromTime']));
													$swap_var['to_time'] = date('H:i A', strtotime($bookedClassDetailArr['toTime']));
													$swap_var['instructor_url'] = base_url();
													$swap_var['business_address'] = $BUSINESS_ADDRESS;
													$swap_var['business_phone'] = $BUSINESS_PHONE;
													$swap_var['business_email'] = $BUSINESS_EMAIL;

													$tepmlateBody = $this->load->view('email_template/student_class_booking',$data,true);

									        foreach (array_keys($swap_var) as $key){
									          if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
									            $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
									          }
									        }

									        //echo $tepmlateBody;exit;

									        $emailParamArr['sender_name'] = $ADMIN_NAME;
									        $emailParamArr['sender_email'] = $ADMIN_MAIL;
									        $emailParamArr['receiver_name'] = $bookedClassDetailArr['instructorName'];
									        $emailParamArr['receiver_email'] = $bookedClassDetailArr['instructorEmail'];
									        $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
									        $emailParamArr['email_subject'] = 'Notify instructor about class booking';
									        $emailParamArr['email_template'] = $tepmlateBody;

									        //Sending mail
			                    //$this->send_mail($emailParamArr);
			                }    

							   	 	  echo json_encode(array('check'=>'success','sessionData'=>$sessionData,'msg'=>'Class has been booked successfully!','classDate'=>$classDate));	
							   }
					    }else{
					  	   $sessionData['totalHours'] = (int) $totalHours;
				         $sessionData['totalBookedSeason'] = $totalBookedSeason;
				         $sessionData['leftSeason'] = $totalBookedSeason;

				  		   $uniqueDateErrTxt = date('jS F, Y',strtotime($classDate))." from ".$classTimeArr[0]." to ".$classTimeArr[1]." is booked by someone else!";
				  		   echo json_encode(array('check'=>'failure','msg'=>$uniqueDateErrTxt,'classDate'=>$classDate));
				  		   exit;	
					   } 
				   }else{
				   	   $sessionData['totalHours'] = (int) $totalHours;
				       $sessionData['totalBookedSeason'] = $totalBookedSeason;
				       $sessionData['leftSeason'] = $totalBookedSeason;

					     echo json_encode(array('check'=>'failure','sessionData'=>$sessionData,'msg'=>'You have exausted all your sessions,Please remove a session to book another.','classDate'=>$classDate));
				   }	  
			    
			    }else{
		 	   	 	$where_del_booked_class = array('classId' => $classId);

		 	   	 	$sql_class_details = "SELECT sbc.classId,sbc.courseLvl,sbc.classDate,sbc.fromTime,sbc.toTime,c.courseId,c.courseName,u.userId as studentId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.email as studentEmail,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as instructorName,i.email as instructorEmail FROM student_booked_classes sbc LEFT JOIN courses c ON sbc.courseId = c.courseId LEFT JOIN users u ON sbc.studentId = u.userId LEFT JOIN users i ON sbc.instructorId = i.userId WHERE sbc.classId = '".$classId."'";

			        //echo $sql_class_details;exit;

							$bookedClassDetails = $this->mymodel->fetch($sql_class_details, true);

							$bookedClassDetailArr = json_decode(json_encode($bookedClassDetails),true);

							$ADMIN_NAME = $this->config->item('ADMIN_NAME');
				      $ADMIN_MAIL = $this->config->item('ADMIN_MAIL');
				      $ADMIN_CC_MAIL = $this->config->item('ADMIN_CC_MAIL');

							$BUSINESS_PHONE = $this->config->item('BUSINESS_PHONE');
							$BUSINESS_EMAIL = $this->config->item('BUSINESS_EMAIL');
							$BUSINESS_ADDRESS = $this->config->item('BUSINESS_ADDRESS');

					  	$data['title'] = 'Notify instructor about class cancellation';

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

							$tepmlateBody = $this->load->view('email_template/intructor_cancel_class_notify',$data,true);

			        foreach (array_keys($swap_var) as $key){
			          if (strlen($key) > 2 && trim($swap_var[$key]) != ''){
			            $tepmlateBody = str_replace('{'.$key.'}', $swap_var[$key], $tepmlateBody);
			          }
			        }

			        //echo $tepmlateBody;exit;

			        $emailParamArr['sender_name'] = $ADMIN_NAME;
			        $emailParamArr['sender_email'] = $ADMIN_MAIL;
			        $emailParamArr['receiver_name'] = $bookedClassDetailArr['instructorName'];
			        $emailParamArr['receiver_email'] = $bookedClassDetailArr['instructorEmail'];
			        $emailParamArr['cc_email'] = $ADMIN_CC_MAIL;
			        $emailParamArr['email_subject'] = 'Notify student about class cancellation';
			        $emailParamArr['email_template'] = $tepmlateBody;

					 		//Delete schedule time data into db
					    if(!$this->mymodel->delete('student_booked_classes', $where_del_booked_class)){
					    	
					    		$sessionData['totalHours'] = (int) $totalHours;
					       	$sessionData['totalBookedSeason'] = $totalBookedSeason;
					        $sessionData['leftSeason'] = $totalBookedSeason;

			           	echo json_encode(array('check'=>'failure','sessionData'=>$sessionData,'msg'=>'Something went wrong, Please try again.','classDate'=>$classDate));	
							}else{
									$sessionData['totalHours'] = (int) $totalHours;
					        $sessionData['totalBookedSeason'] = ($totalBookedSeason-$getTotalSeason);
					        $sessionData['leftSeason'] = $totalHours - ($totalBookedSeason-$getTotalSeason);

					        //Sending mail to instructor to inform about class cancellation
					        //$this->send_mail($emailParamArr);

						  		echo json_encode(array('check'=>'warning','sessionData'=>$sessionData,'msg'=>'Class has been removed successfully!','classDate'=>$classDate));	
						  }
		 	    } 
		 	}else{
		 	   $errorMsg = $stu_current_day." isn't available for booking.";	
		 	   echo json_encode(array('check'=>'failure','msg'=>$errorMsg));	
		 	}     	 	   	  
		}else{
         echo json_encode(array('check'=>'failure','msg'=>"You aren't elligible to book schedule!"));
		} 
	}

	public function removeClass(){
		//print_r($_POST);exit;
		$bookingId = $this->input->post('bookingId');

		$where_del_booked_class = array('bookingId' => $bookingId);

		//Delete schedule time data into db
	    if(!$this->mymodel->delete('student_booked_classes', $where_del_booked_class)){
           echo json_encode(array('check'=>'failure'));
	    }else{
	       echo json_encode(array('check'=>'success'));	
	    }	
	}

	public function history()
	{
		$data['title'] = "History";
		$data['page'] = "purchasehistory";

		$userId=$this->session->userdata('userId');

		$sql_purchased_courses = "SELECT spc.purchaseId,c.courseId,spc.courseLvl,spc.created,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.purchaseId ORDER BY spc.purchaseId";  

	    //echo $sql_purchased_courses;exit;

	    //Feching Enrolled Course List 
	 	$data['courseData'] = $this->mymodel->fetch($sql_purchased_courses, false);

		$this->load->view('student/header', $data);
		$this->load->view('student/history');
		$this->load->view('student/footer');

	}

	public function wishlist()
	{
		$data['title'] = "History";
		$data['page'] = "wishlist";

		$userId=$this->session->userdata('userId');

		$sql_whshlisted_course = "SELECT spc.wishId,spc.updated,c.courseId,spc.courseLvl,c.image as course_image,cl.image as level_image,c.courseName,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_course_whishlist spc LEFT JOIN courses c ON (spc.courseId=c.courseId AND spc.userId='".$userId."') LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level AND spc.userId='".$userId."' ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level AND spc.userId='".$userId."' ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE spc.userId = '".$userId."' GROUP BY spc.wishId ORDER BY spc.wishId";  

	  //echo $sql_whshlisted_course;exit;

	  //Feching Enrolled Course List 
	 	$data['wishListData'] = $this->mymodel->fetch($sql_whshlisted_course, false);

		$this->load->view('student/header', $data);
		$this->load->view('student/wishlist');
		$this->load->view('student/footer');

	}

	public function settings()
	{
		$data['title'] = "Settings";
		$userId=$this->session->userdata('userId');

		//Fetch timezone list
		$sql_timezone_list = "SELECT * FROM timezone tz ORDER BY tz.country_code"; 
		//echo $sql_timezone_list;exit;
		$data['timezoneList'] = $this->mymodel->fetch($sql_timezone_list,false);
		
		//Fetching user details
		$data['myInfo']= $this->mymodel->get('users', true, 'userId', $userId);
		$this->load->view('student/header', $data);

		$this->load->view('student/settings');
		$this->load->view('student/footer');
	}

	public function updateInfo()
	{  
		$userId=$this->session->userdata('userId');
		$courseId = $this->input->post('courseId') ;
        
        $mydata = array(
										'firstName' => $this->testInput($this->input->post('firstName')),
										'lastName' => $this->testInput($this->input->post('lastName')),
										'email' =>$this->testInput($this->input->post('email')),
										'ccName' =>$this->testInput($this->input->post('ccName')),
										'ccCode' =>$this->testInput($this->input->post('ccCode')),
										'timezone' =>$this->testInput($this->input->post('timezone')),
										'mobile' =>$this->testInput($this->input->post('mobile')),
										'descriptions' =>$this->testInput($this->input->post('descriptions')),
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
			$this->load->library('upload',$config); 

			if ( ! $this->upload->do_upload('cover_photo'))
			{
				$error = strip_tags($this->upload->display_errors());
				$this->session->set_flashdata('error', 'File upload error; Please try again.');
			} else {
				$data = $this->upload->data();
				$mydata['profilePic'] = $data['file_name'];
			}
		}else{
			$mydata['profilePic'] = $oldProfilePic;
		}

		$where_user_clause = array('userId' => $userId);
			
		if (!$this->mymodel->update($mydata,'users',$where_user_clause)) 
		{
			$this->session->set_flashdata('error', 'Something went wrong! Please try again.');
		}else{
			if ($oldProfilePic && !empty($_FILES['cover_photo']['name'])) {
				if (file_exists('./uploads/users/'.$oldProfilePic)) {
					@unlink('./uploads/users/'.$oldProfilePic);
				}
			}
			$this->session->set_flashdata('success', 'Profile data is successfully updated!');
		}

		
		redirect(base_url('student/settings'),'refresh');	
	}

	public function reset()
	{
		$data['title'] = "Settings";
		$userId=$this->session->userdata('userId');
		$data['myInfo']= $this->mymodel->get('users', true, 'userId', $userId);
		$this->load->view('student/header', $data);
		$this->load->view('student/change_password');
		$this->load->view('student/footer');
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
		redirect(base_url('student/reset'),'refresh');
	}

	public function cancelCourse()
	{
		//print_r($_POST);exit;

    $studentId = $this->session->userdata('userId');
		$courseId = $this->input->post('courseId');
		$courseLvl = $this->input->post('courseLvl');
		$descriptions = $this->testInput($this->input->post('descriptions'));

		//Saving query data into db
		$cnclCrsData = array(
		    'studentId'=>$studentId,
		    'courseId'=>$courseId,
		    'courseLvl'=>$courseLvl,
		    'descriptions'=>$descriptions,
		    'userType' => 1,
		    'userId' => $studentId,
		    'created'=> date('Y-m-d H:i:s')
		);

		if(!$this->mymodel->save('cancel_students', $cnclCrsData)){
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong, Please try again.'));
		}else{

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

			$data['title'] = 'Notify admin about cancel course';

	    $swap_var['student_name'] = $studentDetails->studentName;
			$swap_var['course_name'] = $courseDetails->courseName;
			$swap_var['course_level'] = ucfirst($courseLvl);
			$swap_var['admin_url'] = base_url('admin/reports/cancelstudentdata');
			$swap_var['business_address'] = $BUSINESS_ADDRESS;
			$swap_var['business_phone'] = $BUSINESS_PHONE;
			$swap_var['business_email'] = $BUSINESS_EMAIL;

			$tepmlateBody = $this->load->view('email_template/student_cancel_course',$data,true);

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
      $emailParamArr['email_subject'] = 'Notify admin about cancel course by student';
      $emailParamArr['email_template'] = $tepmlateBody;

      //Send mail to admin when student request for changing instructor
      //$this->send_mail($emailParamArr);

			echo json_encode(array('check'=>'success','msg'=>'Your course cancellation request has been successfully submitted, We will get back to you in  a jiffy.'));
		}
	}
}