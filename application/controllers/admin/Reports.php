<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends MY_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function purchase_history()
	{
		$data = array(
			'title' => 'Purchase History',
			'page' => 'reports',
			'subpage' => 'purchasehistory'
        );

        $sql_purchased_courses = "SELECT c.courseName, c.created_by,i.userId as instructorId, CONCAT(i.firstName,' ',i.lastName) as instructorName, spc.purchaseId,u.userId,CONCAT(u.firstName,' ',u.lastName) as studentName,u.mobile,u.email,c.courseId,spc.courseLvl,spc.created,c.image as course_image,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM student_purchased_courses spc LEFT JOIN users u ON (spc.userId=u.userId ) LEFT JOIN courses c ON (spc.courseId=c.courseId ) LEFT JOIN users i ON (c.creator_id = i.userId) LEFT JOIN course_level_details cl ON ( spc.courseId=cl.courseId AND spc.courseLvl = cl.level ) LEFT JOIN course_chapters cc ON ( spc.courseId=cc.courseId  AND spc.courseLvl = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId GROUP BY spc.purchaseId ORDER BY spc.purchaseId";  

	    //echo $sql_purchased_courses;exit;

	    //Feching Enrolled Course List 
	 	$data['purchasedCourses'] = $this->mymodel->fetch($sql_purchased_courses, false);
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/purchase_history');
		$this->load->view('admin/footer');
	}

	public function change_instructor_data()
	{
		$data = array(
			'title' => 'Change Instructor Data',
			'page' => 'reports',
			'subpage' => 'changeinstructordata'
        );

        $sql_changed_instructor = "SELECT ci.queryId,ci.courseId,ci.courseLvl,r.reason,ci.descriptions,ci.created,s.userId as studentId,CONCAT(s.firstName,' ',s.lastName) as studentName,s.email,s.mobile,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as insName,i.mobile as insMobile,i.email as insEmail,c.courseName,c.image FROM change_instructor ci LEFT JOIN users s ON (ci.studentId=s.userId AND s.userType='1') LEFT JOIN courses c ON (ci.courseId=c.courseId ) LEFT JOIN users i ON ( ci.instructorId=i.userId AND i.userType = '2' ) LEFT JOIN reason r ON (ci.reasonId=r.reasonId ) GROUP BY ci.queryId ORDER BY ci.created DESC";  

        //echo $sql_changed_instructor;exit;

	    //Feching Enrolled Course List 
	 	$data['changeInstructorData'] = $this->mymodel->fetch($sql_changed_instructor, false);
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/change_instructor_data');
		$this->load->view('admin/footer');
	}

	public function changeInsHistory($status='active'){
		$data = array(
			'title' => 'Change Instructor History Page',
			'page' => 'reports',
			'subpage' => 'changeinshsitory'
        );

        $record_status = ($status =='active'? 1 : 0);

        $sql_changed_instructor = "SELECT cih.queryId,cih.courseId,cih.courseLvl,r.reason,cih.descriptions,cih.created,s.userId as studentId,CONCAT(s.firstName,' ',s.lastName) as studentName,s.email,s.mobile,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as insName,i.mobile as insMobile,i.email as insEmail,c.courseName,c.image FROM change_instructor_history cih LEFT JOIN users s ON (cih.studentId=s.userId AND s.userType='1') LEFT JOIN courses c ON (cih.courseId=c.courseId ) LEFT JOIN users i ON ( cih.instructorId=i.userId AND i.userType = '2' ) LEFT JOIN reason r ON (cih.reasonId=r.reasonId ) WHERE cih.status='$record_status' GROUP BY cih.queryId ORDER BY cih.created DESC";  

        //echo $sql_changed_instructor;exit;

        $data['status'] = $record_status;

	    //Feching Enrolled Course List 
	 	$data['changeInstructorData'] = $this->mymodel->fetch($sql_changed_instructor, false);
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/change_instructor_calculation');
		$this->load->view('admin/footer');
	}

	public function deleteQuery($queryId = false)
	{
		if ($queryId != false) {

		   //Feching change instructor details 
		   $sql_changed_instructor = "SELECT ci.* FROM change_instructor ci WHERE ci.queryId='$queryId'";  

           //echo $sql_changed_instructor;exit;

	 	   $changeInstructorData = $this->mymodel->fetch($sql_changed_instructor, true);

	 	   $studentId = $changeInstructorData->studentId;
	 	   $courseId = $changeInstructorData->courseId;
	 	   $courseLvl = $changeInstructorData->courseLvl;
	 	   $instructorId = $changeInstructorData->instructorId;
           
           //Saving query data into db
		   $queryData = array(
			              'studentId'=>$studentId,
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'instructorId'=>$instructorId,
			              'reasonId'=>$changeInstructorData->reasonId,
			              'descriptions'=>$changeInstructorData->descriptions,
			              'status' => '0',
			              'created'=> $changeInstructorData->created,
			              'updated'=> $changeInstructorData->updated
						);

		    //Saving query data into archive table
		    if($this->mymodel->save('change_instructor_history', $queryData)){
                
                $where = array('queryId' => $queryId);

				if (!$this->mymodel->delete('change_instructor', $where)) {
					$msg = 'error';
				} else {
					$msg = '["Query denyed successfully.", "success", "#A5DC86"]';
				}
		    }else{
		    	$msg = 'error';
		    }
		    $this->session->set_flashdata('msg', $msg);
		    redirect(admin_url('reports/changeinstructordata'),'refresh');
		}else{
			show_404();
		}
		
	}

	public function approveQuery($queryId = false)
	{
		if ($queryId != false) {
           
           $this->db->trans_begin();

           //Feching change instructor details 
		   $sql_changed_instructor = "SELECT ci.* FROM change_instructor ci WHERE ci.queryId='$queryId'";  

           //echo $sql_changed_instructor;exit;

	 	   $changeInstructorData = $this->mymodel->fetch($sql_changed_instructor, true);

	 	   $studentId = $changeInstructorData->studentId;
	 	   $courseId = $changeInstructorData->courseId;
	 	   $courseLvl = $changeInstructorData->courseLvl;
	 	   $instructorId = $changeInstructorData->instructorId;
           
           //Saving query data into db
		   $queryData = array(
			              'studentId'=>$studentId,
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'instructorId'=>$instructorId,
			              'reasonId'=>$changeInstructorData->reasonId,
			              'descriptions'=>$changeInstructorData->descriptions,
			              'status' => '1',
			              'created'=> $changeInstructorData->created,
			              'updated'=> $changeInstructorData->updated
						);

		    $where_delete_clause = array('studentId' => $studentId,'courseId' => $courseId,
		    							'courseLvl' => $courseLvl,'instructorId' => $instructorId);

		    //Saving query data into archive table
		    $this->mymodel->save('change_instructor_history', $queryData);

		    $requestType = 1;
		    $requestId = $this->db->insert_id();

		   //Feching change instructor details 
		   //$sql_fetch_booked_class = "SELECT sbc.* FROM student_booked_classes sbc WHERE sbc.studentId='$studentId' AND sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.instructorId='$instructorId' AND sbc.classDate < CURDATE()";  

		   $sql_fetch_booked_class = "SELECT sbc.* FROM student_booked_classes sbc WHERE sbc.studentId='$studentId' AND sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.instructorId='$instructorId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()"; 

           //echo $sql_fetch_booked_class;exit; 

	 	   $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);

	 	   //Saving booked class data into archive table
	 	   foreach ($bookedClassData as $key => $class) {
	 	   	  
	 	   	  $scheduleData = array(
	 	   	  	     'requestType' => $requestType,
	 	   	  	     'requestId' => $requestId,
			     	 'bookingId'=> $class->bookingId,
					 'studentId' => $studentId,
					 'courseId' => $courseId,
					 'courseLvl' => $courseLvl,
					 'instructorId' => $instructorId,
					 'classDate' => $class->classDate,
					 'fromTime' =>$class->fromTime,
					 'toTime' => $class->toTime,
					 'timezone' => $class->timezone,
					 'created'=>$class->created,
					 'updated'=>$class->updated
				  );

	 	   	  //Inserting class schedule data into booked class archive table
	 	   	  $this->mymodel->save('student_booked_classes_history', $scheduleData);
	 	   }

	 	   if ($this->db->trans_status() === FALSE){
			   
			   $this->db->trans_rollback();
			   $msg = 'error';
			}
			else{
				$this->db->trans_commit();
				//Deleting records from change instructor table
				$this->mymodel->delete('change_instructor', $where_delete_clause);
				//Deleting records from student booked class table
				$this->mymodel->delete('student_booked_classes', $where_delete_clause);
                
                $msg = '["Query approved successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);

		}
		redirect(admin_url('reports/changeinstructordata'),'refresh');
	}

	public function deleteQueryHistory($queryId = false)
	{
		if ($queryId != false) {

			$this->db->trans_begin();

			$where_delete_query = array('queryId' => $queryId);

			if ($this->mymodel->delete('change_instructor_history', $where_delete_query)) {
				
				//Deleting all booked classes from history table
				$where_delete_class = array('requestType' => 1,'requestId'=>$queryId);
				
				//executing delete query
				$this->mymodel->delete('student_booked_classes_history', $where_delete_class);
			}

			if($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
			   $msg = 'error';
			}else{
			   $this->db->trans_commit();
			   $msg = '["Record was deleted successfully from history.", "success", "#A5DC86"]';
			}	

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('reports/changeInsHistory'),'refresh');
		}else{
			show_404();
		}

	}

	public function cancel_student_data()
	{
		$data = array(
			'title' => 'Cancel Student Data',
			'page' => 'reports',
			'subpage' => 'cancelstudentdata'
        );

        $sql_cancel_course = "SELECT cc.stuCourseId,cc.studentId,cc.courseId,cc.courseLvl,cc.descriptions,cc.userType,cc.created,cc.userId,CONCAT(u.firstName,' ',u.lastName) as userName,u.email as userEmail,u.mobile as userMobile,CONCAT(s.firstName,' ',s.lastName) as studentName,s.email as stuEmail,s.mobile as stuMobile,c.courseName,c.image FROM cancel_students cc LEFT JOIN users u ON (cc.userId=u.userId AND cc.userType = u.userType) LEFT JOIN courses c ON (cc.courseId=c.courseId ) LEFT JOIN users s ON (cc.studentId=s.userId AND s.userType='1') GROUP BY cc.stuCourseId ORDER BY cc.created DESC";  

        //echo $sql_cancel_course;exit;

	    //Feching Enrolled Course List 
	 	$data['cancelStudentData'] = $this->mymodel->fetch($sql_cancel_course, false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_student_data');
		$this->load->view('admin/footer');
	}

	public function cancelStudentHistory($status='active')
	{
		$data = array(
			'title' => 'Cancel Student Calculation Record',
			'page' => 'reports',
			'subpage' => 'cancelstudenthistory'
        );

        $record_status = ($status =='active'? 1 : 0);

        $sql_cancel_course = "SELECT cch.stuCourseId,cch.studentId,cch.courseId,cch.courseLvl,cch.descriptions,cch.userType,cch.created,cch.userId,CONCAT(u.firstName,' ',u.lastName) as userName,u.email as userEmail,u.mobile as userMobile,CONCAT(s.firstName,' ',s.lastName) as studentName,s.email as stuEmail,s.mobile as stuMobile,c.courseName,c.image FROM cancel_students_history cch LEFT JOIN users u ON (cch.userId=u.userId AND cch.userType = u.userType) LEFT JOIN courses c ON (cch.courseId=c.courseId ) LEFT JOIN users s ON (cch.studentId=s.userId AND s.userType='1') WHERE cch.status='$record_status' GROUP BY cch.stuCourseId ORDER BY cch.created DESC";  

        //echo $sql_cancel_course;exit;

	    //Feching Enrolled Course List 
	 	$data['cancelStudentData'] = $this->mymodel->fetch($sql_cancel_course, false);

	 	$data['status'] = $record_status;
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_student_history_data');
		$this->load->view('admin/footer');
	}

	public function deleteStudentCancellation($stuCourseId = false)
	{
		if ($stuCourseId != false) {

			//Feching change instructor details 
		   $sql_cancel_course = "SELECT cc.* FROM cancel_students cc WHERE cc.stuCourseId='$stuCourseId'";  

           //echo $sql_cancel_course;exit;

	 	   $cancelStudentdata = $this->mymodel->fetch($sql_cancel_course, true);

	 	   $studentId = $cancelStudentdata->studentId;
	 	   $courseId = $cancelStudentdata->courseId;
	 	   $courseLvl = $cancelStudentdata->courseLvl;
	 	   $userType = $cancelStudentdata->userType;
	 	   $userId = $cancelStudentdata->userId;
           
           //Saving query data into db
		   $cancelData = array(
			              'studentId'=>$studentId,
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'userType'=>$userType,
			              'userId'=>$userId,
			              'descriptions'=>$cancelStudentdata->descriptions,
			              'status' => '0',
			              'created'=> $cancelStudentdata->created,
			              'updated'=> $cancelStudentdata->updated
						);

		    //Saving query data into archive table
		    if($this->mymodel->save('cancel_students_history', $cancelData)){
                
                $where = array('stuCourseId' => $stuCourseId);

				if (!$this->mymodel->delete('cancel_students', $where)) {
					
					$msg = 'error';

				} else {
					
					$msg = '["Cancellation was denyed successfully.", "success", "#A5DC86"]';
				}

		    }else{
               $msg = 'error';
		    }
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('reports/cancelstudentdata'),'refresh');
		}else{
			show_404();
		}
		
	}

	public function approveStudentCancellation($stuCourseId = false)
	{
		if ($stuCourseId != false) {
           
           $this->db->trans_begin();

           //Feching change instructor details 
		   $sql_cancel_course = "SELECT cc.* FROM cancel_students cc WHERE cc.stuCourseId='$stuCourseId'";  

           //echo $sql_cancel_course;exit;

	 	   $cancelStudentdata = $this->mymodel->fetch($sql_cancel_course, true);

	 	   $studentId = $cancelStudentdata->studentId;
	 	   $courseId = $cancelStudentdata->courseId;
	 	   $courseLvl = $cancelStudentdata->courseLvl;
	 	   $userType = $cancelStudentdata->userType;
	 	   $userId = $cancelStudentdata->userId;
           
           //Saving query data into db
		   $cancelData = array(
			              'studentId'=>$studentId,
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'userType'=>$userType,
			              'userId'=>$userId,
			              'descriptions'=>$cancelStudentdata->descriptions,
			              'status' => '1',
			              'created'=> $cancelStudentdata->created,
			              'updated'=> $cancelStudentdata->updated
						);

		    $where_delete_clause = array('studentId' => $studentId,'courseId' => $courseId,
		    							'courseLvl' => $courseLvl,'userId' => $userId);

		    //Saving query data into archive table
		    $this->mymodel->save('cancel_students_history', $cancelData);

		    $requestType = 2;
		    $requestId = $this->db->insert_id();

		   //Feching change instructor details 
		   $sql_fetch_booked_class = "SELECT sbc.* FROM student_booked_classes sbc WHERE sbc.studentId='$studentId' AND sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl'";  

           //echo $sql_fetch_booked_class;exit;

	 	   $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);

	 	   //Saving booked class data into archive table
	 	   foreach ($bookedClassData as $key => $class) {
	 	   	  
	 	   	  $scheduleData = array(
	 	   	  	     'requestType' => $requestType,
	 	   	  	     'requestId' => $requestId,  
			     	 'bookingId'=> $class->bookingId,
					 'studentId' => $studentId,
					 'courseId' => $courseId,
					 'courseLvl' => $courseLvl,
					 'instructorId' => $class->instructorId,
					 'classDate' => $class->classDate,
					 'fromTime' =>$class->fromTime,
					 'toTime' => $class->toTime,
					 'timezone' => $class->timezone,
					 'created'=>$class->created,
					 'updated'=>$class->updated
				  );

	 	   	  //Inserting class schedule data into booked class archive table
	 	   	  $this->mymodel->save('student_booked_classes_history', $scheduleData);
	 	   }

	 	   //Feching purchase course details 
		   $sql_purchased_course = "SELECT spc.* FROM student_purchased_courses spc WHERE spc.userId ='$studentId' AND spc.courseId ='$courseId' AND spc.courseLvl ='$courseLvl'";  

           //echo $sql_purchased_course;exit;

	 	   $purchaseCrsData = $this->mymodel->fetch($sql_purchased_course, true);

	 	   $requestType = 2;

	 	   //Saving purchase couese data into cancel course table
		   $cancelData = array(
		   	              'requestType' => $requestType,
		 	   	  	      'requestId' => $requestId,  
		   	              'uniquePurchaseId' => $purchaseCrsData->uniquePurchaseId,
			              'userId'=>$studentId,
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'lvlCost'=>$purchaseCrsData->lvlCost,
			              'payment_method'=>$purchaseCrsData->payment_method,
			              'transaction_data'=>$purchaseCrsData->transaction_data,
			              'created'=> $purchaseCrsData->created,
			              'updated'=> $purchaseCrsData->updated
						);

		    //Saving query data into archive table
		    $this->mymodel->save('student_cancelled_courses', $cancelData);

		    //Deleting records from change instructor table
			$where_delete_cancel_clause = array('studentId'=>$studentId,'courseId' => $courseId,'courseLvl' => $courseLvl,'userId' => $userId);

			$this->mymodel->delete('cancel_students', $where_delete_cancel_clause);
			
			//Deleting records from student booked class table
			$where_delete_class_clause = array('studentId'=>$studentId,'courseId' => $courseId,'courseLvl' => $courseLvl);
			
			$this->mymodel->delete('student_booked_classes', $where_delete_class_clause);

			//Deleting records from student booked class table
			$where_delete_purchase_clause = array('userId'=>$studentId,'courseId' => $courseId,'courseLvl' => $courseLvl);
			
			$this->mymodel->delete('student_purchased_courses', $where_delete_purchase_clause);

	 	    if ($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
			   $msg = 'error';
			}
			else{
				$this->db->trans_commit();
                $msg = '["Cancellation approved successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);

		}
		redirect(admin_url('reports/cancelstudentdata'),'refresh');
	}

	public function deleteStudentPurchaseHistory($stuCourseId = false)
	{
		if ($stuCourseId != false) {

			$this->db->trans_begin();

			$where_delete_query = array('stuCourseId' => $stuCourseId);

			if ($this->mymodel->delete('cancel_students_history', $where_delete_query)) {
				
				//Deleting all booked classes from history table
				$where_delete_class = array('requestType' => 2,'requestId'=>$stuCourseId);
				
				//executing delete query
				$this->mymodel->delete('student_booked_classes_history', $where_delete_class);
			}

			if ($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
			   $msg = 'error';
			}else{
			   $this->db->trans_commit();
			   $msg = '["Purchase record was deleted successfully from history.", "success", "#A5DC86"]';
			}	

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('reports/cancelStudentHistory'),'refresh');
		}else{
			show_404();
		}
	}

	public function cancel_course_data()
	{
		$data = array(
		   'title' => 'Cancel Course Data',
		   'page' => 'reports',
		   'subpage' => 'cancelcoursedata'
        );
        
        //Fetching course details
        $sql_cancel_course = "SELECT cc.requestId,cc.courseId,cc.courseLvl,c.courseName,c.image,cc.descriptions,cc.created,cc.instructorId,CONCAT(u.firstName,' ',u.lastName) as insName,u.email as insEmail,u.mobile as insMobile FROM cancel_courses cc LEFT JOIN users u ON (cc.instructorId=u.userId) LEFT JOIN courses c ON (cc.courseId=c.courseId ) GROUP BY cc.requestId ORDER BY cc.created DESC";  

        //echo $sql_cancel_course;exit;

	    //Feching Enrolled Course List 
	 	$data['cancelCourseData'] = $this->mymodel->fetch($sql_cancel_course, false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_course_data');
		$this->load->view('admin/footer');
	}

	public function cancelCourseDetails($requestId)
	{
		$data = array(
		   'title' => 'Cancel Course Details Page',
		   'page' => 'reports',
		   'subpage' => 'cancelcoursedetails'
        );
      
        //Fetching course details  
        $sql_fetch_request = "SELECT cc.requestId,cc.courseId,cc.courseLvl,cc.descriptions,cc.created,cc.instructorId,CONCAT(u.firstName,' ',u.lastName) as insName,u.email as insEmail,u.mobile as insMobile,c.courseName,c.image FROM cancel_courses cc LEFT JOIN users u ON (cc.instructorId=u.userId) LEFT JOIN courses c ON (cc.courseId=c.courseId ) WHERE cc.requestId = '$requestId' GROUP BY cc.requestId ORDER BY cc.created DESC";  

        //echo $sql_fetch_request;exit;

	    //Feching Enrolled Course List 
	 	$requestDetails = $this->mymodel->fetch($sql_fetch_request, true);

	 	if(empty($requestDetails)){
           show_404();
           exit;
	 	}

	 	$data['cancelCourseDetails'] = $requestDetails;

	 	$courseId = $requestDetails->courseId;
	 	$courseLvl = $requestDetails->courseLvl;

	 	//Fetching student list who have purchased this courses
		$sql_fetch_student = "SELECT u.userId,CONCAT(u.firstName,' ',u.lastName) as studentName FROM student_purchased_courses spc LEFT JOIN users u ON ( spc.userId=u.userId AND u.userType=1 ) WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl'";
		//echo $sql_fetch_student;exit;
		$studentlist = $this->mymodel->fetch($sql_fetch_student); 

		$studentRefundData = array();

		foreach($studentlist as $index2 => $student){

		   $studentId = $student->userId;

		   $sql_fetch_booked_class = "SELECT TIMEDIFF(sbc.toTime , sbc.fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";
	           
	       //echo $sql_fetch_booked_class;exit;

	       $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
	                 
	       $totalBookedSeason = 0;

		   foreach ($bookedClassData as $index3 => $time) {
		      $totalBookedSeason +=  round($time->timeDiff);
		   }

		   //Fetching course total cost
		   $sql_course_level_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

		   //echo $sql_course_level_details;exit;

		   //Feching Course Details 
	 	   $courseLevelDetails = $this->mymodel->fetch($sql_course_level_details, true);

	 	   $deductionAmount = ($courseLevelDetails->courseCost * $totalBookedSeason)/$courseLevelDetails->totalHours;
        
	       $studentRefundData[$index2]['courseName'] = $requestDetails->courseName;
	       $studentRefundData[$index2]['level'] = ucfirst($courseLvl); 
	 	   $studentRefundData[$index2]['studentId'] = $student->userId;
	 	   $studentRefundData[$index2]['studentName'] = $student->studentName;
	 	   $studentRefundData[$index2]['courseSession'] = $courseLevelDetails->totalHours;
	 	   $studentRefundData[$index2]['bookedSession'] = $totalBookedSeason;
	 	   $studentRefundData[$index2]['courseCost'] = sprintf("%.2f",$courseLevelDetails->courseCost);
	 	   $studentRefundData[$index2]['deductionAmount'] = sprintf("%.2f",$deductionAmount);
	 	   $studentRefundData[$index2]['refundAmount'] = sprintf("%.2f",($courseLevelDetails->courseCost - $deductionAmount));
	 	}	

	 	$data['studentRefundData'] = $studentRefundData;

	 	/*print"<pre>";
		print_r($studentRefundData);
		print"<pre>";exit;*/

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_course_details');
		$this->load->view('admin/footer');
	}

	public function cancel_course_history($status = 'active')
	{
		$data = array(
		   'title' => 'Cancel Course History',
		   'page' => 'reports',
		   'subpage' => 'cancelcoursehistory'
        );

        $record_status = ($status =='active'? 1 : 0);

        $data['status'] = $record_status;
        
        //Fetching course details
        $sql_cancel_course = "SELECT cch.requestId,cch.courseId,cch.courseLvl,c.courseName,c.image,cch.descriptions,cch.created,cch.instructorId,CONCAT(u.firstName,' ',u.lastName) as insName,u.email as insEmail,u.mobile as insMobile FROM cancel_courses_history cch LEFT JOIN users u ON (cch.instructorId=u.userId) LEFT JOIN courses c ON (cch.courseId=c.courseId ) WHERE cch.status = '$record_status' GROUP BY cch.requestId ORDER BY cch.created DESC";  

        //echo $sql_cancel_course;exit;

	    //Feching Enrolled Course List 
	 	$data['cancelCourseData'] = $this->mymodel->fetch($sql_cancel_course, false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_course_history');
		$this->load->view('admin/footer');
	}

	public function cancelCourseHistoryDetails($requestId)
	{
		$data = array(
		   'title' => 'Cancel Course History Details Page',
		   'page' => 'reports',
		   'subpage' => 'cancelcoursehistorydetails'
        );
      
        //Fetching course details  
        $sql_fetch_request = "SELECT cch.requestId,cch.courseId,cch.courseLvl,cch.descriptions,cch.status,cch.created,cch.instructorId,CONCAT(u.firstName,' ',u.lastName) as insName,u.email as insEmail,u.mobile as insMobile,c.courseName,c.image FROM cancel_courses_history cch LEFT JOIN users u ON (cch.instructorId=u.userId) LEFT JOIN courses c ON (cch.courseId=c.courseId ) WHERE cch.requestId = '$requestId' GROUP BY cch.requestId ORDER BY cch.created DESC";  

        //echo $sql_fetch_request;exit;

	    //Feching Enrolled Course List 
	 	$requestDetails = $this->mymodel->fetch($sql_fetch_request, true);

	 	if(empty($requestDetails)){
           show_404();
           exit;
	 	}

	 	$data['cancelCourseDetails'] = $requestDetails;

	 	$courseId = $requestDetails->courseId;
	 	$courseLvl = $requestDetails->courseLvl;

	 	//Fetching student list who have purchased this courses
		$sql_fetch_student = "SELECT u.userId,CONCAT(u.firstName,' ',u.lastName) as studentName FROM student_purchased_courses spc LEFT JOIN users u ON ( spc.userId=u.userId AND u.userType=1 ) WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl'";
		//echo $sql_fetch_student;exit;
		$studentlist = $this->mymodel->fetch($sql_fetch_student); 

		$studentRefundData = array();

		foreach($studentlist as $index2 => $student){

		   $studentId = $student->userId;

		   $sql_fetch_booked_class = "SELECT TIMEDIFF(sbc.toTime , sbc.fromTime) as timeDiff FROM student_booked_classes sbc WHERE sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.studentId='$studentId' AND cast(concat(sbc.classDate, ' ', sbc.toTime) as datetime) < CURRENT_TIMESTAMP()";
	           
	       //echo $sql_fetch_booked_class;exit;

	       $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);
	                 
	       $totalBookedSeason = 0;

		   foreach ($bookedClassData as $index3 => $time) {
		      $totalBookedSeason +=  round($time->timeDiff);
		   }

		   //Fetching course total cost
		   $sql_course_level_details = "SELECT c.*, SUM(chp.totalHours) as totalHours, SUM(chp.cost) as courseCost FROM courses c LEFT JOIN course_chapters cc ON c.courseId=cc.courseId LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' AND cc.level='".$courseLvl."'";

		   //echo $sql_course_level_details;exit;

		   //Feching Course Details 
	 	   $courseLevelDetails = $this->mymodel->fetch($sql_course_level_details, true);

	 	   $deductionAmount = ($courseLevelDetails->courseCost * $totalBookedSeason)/$courseLevelDetails->totalHours;
        
	       $studentRefundData[$index2]['courseName'] = $requestDetails->courseName;
	       $studentRefundData[$index2]['level'] = ucfirst($courseLvl); 
	 	   $studentRefundData[$index2]['studentId'] = $student->userId;
	 	   $studentRefundData[$index2]['studentName'] = $student->studentName;
	 	   $studentRefundData[$index2]['courseSession'] = $courseLevelDetails->totalHours;
	 	   $studentRefundData[$index2]['bookedSession'] = $totalBookedSeason;
	 	   $studentRefundData[$index2]['courseCost'] = sprintf("%.2f",$courseLevelDetails->courseCost);
	 	   $studentRefundData[$index2]['deductionAmount'] = sprintf("%.2f",$deductionAmount);
	 	   $studentRefundData[$index2]['refundAmount'] = sprintf("%.2f",($courseLevelDetails->courseCost - $deductionAmount));
	 	}	

	 	$data['studentRefundData'] = $studentRefundData;

	 	/*print"<pre>";
		print_r($studentRefundData);
		print"<pre>";exit;*/

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reports/cancel_course_history_details');
		$this->load->view('admin/footer');
	}

	public function approveCourseCancellation($requestId = false)
	{
		if ($requestId != false) {
           
           $this->db->trans_begin();

           $initialRequestId = $requestId;

           //Feching change instructor details 
		   $sql_cancel_course = "SELECT cc.* FROM cancel_courses cc WHERE cc.requestId='$requestId'";  

           //echo $sql_cancel_course;exit;

	 	   $cancelCoursedata = $this->mymodel->fetch($sql_cancel_course, true);

	 	   $courseId = $cancelCoursedata->courseId;
	 	   $courseLvl = $cancelCoursedata->courseLvl;
	 	   $instructorId = $cancelCoursedata->instructorId;

	 	   //Fetching student list who have purchased this courses
		   $sql_fetch_student = "SELECT u.userId as studentId,CONCAT(u.firstName,' ',u.lastName) as studentName FROM student_purchased_courses spc LEFT JOIN users u ON ( spc.userId=u.userId AND u.userType=1 ) WHERE spc.courseId='$courseId' AND spc.courseLvl='$courseLvl'";
		   //echo $sql_fetch_student;exit;
		   $studentlist = $this->mymodel->fetch($sql_fetch_student); 

		    /*print"<pre>";
			print_r($studentlist);
			print"<pre>";exit;*/
           
           //Saving query data into db
		   $cancelData = array(
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'instructorId'=>$instructorId,
			              'descriptions'=>$cancelCoursedata->descriptions,
			              'status' => '1',
			              'created'=> $cancelCoursedata->created,
			              'updated'=> $cancelCoursedata->updated
						);

		    //Saving query data into archive table
		    $this->mymodel->save('cancel_courses_history', $cancelData);

		    $requestType = 3;
		    $requestId = $this->db->insert_id();

            foreach($studentlist as $index2 => $student){

               $studentId = $student->studentId;
		   
			   //Feching change instructor details 
			   $sql_fetch_booked_class = "SELECT sbc.* FROM student_booked_classes sbc WHERE sbc.studentId='$studentId' AND sbc.courseId='$courseId' AND sbc.courseLvl='$courseLvl' AND sbc.instructorId='$instructorId'";  

	           //echo $sql_fetch_booked_class;exit;

		 	   $bookedClassData = $this->mymodel->fetch($sql_fetch_booked_class, false);

		 	   //Saving booked class data into archive table
		 	   foreach ($bookedClassData as $key => $class) {
		 	   	  
		 	   	  $scheduleData = array(
		 	   	  	     'requestType' => $requestType,
		 	   	  	     'requestId' => $requestId,  
				     	 'bookingId'=> $class->bookingId,
						 'studentId' => $studentId,
						 'courseId' => $courseId,
						 'courseLvl' => $courseLvl,
						 'instructorId' => $class->instructorId,
						 'classDate' => $class->classDate,
						 'fromTime' =>$class->fromTime,
						 'toTime' => $class->toTime,
						 'timezone' => $class->timezone,
						 'created'=>$class->created,
						 'updated'=>$class->updated
					  );

		 	   	  //Inserting class schedule data into booked class archive table
		 	   	  $this->mymodel->save('student_booked_classes_history', $scheduleData);
		 	   }

		 	   //Feching purchase course details 
			   $sql_purchased_course = "SELECT spc.* FROM student_purchased_courses spc WHERE spc.userId ='$studentId' AND spc.courseId ='$courseId' AND spc.courseLvl ='$courseLvl'";  

	           //echo $sql_purchased_course;exit;

		 	   $purchaseCrsData = $this->mymodel->fetch($sql_purchased_course, true);

		 	   $cancelRequestType = 2;

		 	   //Saving purchase couese data into cancel course table
			   $cancelData = array(
			   	              'requestType' => $cancelRequestType,
		 	   	  	    	  'requestId' => $requestId, 
		 	   	  	    	  'uniquePurchaseId' => $purchaseCrsData->uniquePurchaseId, 	
				              'userId'=>$studentId,
				              'courseId'=>$courseId,
				              'courseLvl'=>$courseLvl,
				              'lvlCost'=>$purchaseCrsData->lvlCost,
				              'payment_method'=>$purchaseCrsData->payment_method,
				              'transaction_data'=>$purchaseCrsData->transaction_data,
				              'created'=> $purchaseCrsData->created,
				              'updated'=> $purchaseCrsData->updated
							);

			    //Saving query data into archive table
			    $this->mymodel->save('student_cancelled_courses', $cancelData);

			    //Fetch course details
				$sql_fetch_course_detail = "SELECT c.created_by FROM courses c WHERE c.courseId='".$courseId."'";
				$courseDetails = $this->mymodel->fetch($sql_fetch_course_detail, true);

				if($courseDetails->created_by == 'instructor'){
                
	                //Updating course level status
				    $courseData = array('status'=>'0');

				    $where_update_course_clause = array('courseId'=>$courseId,'level'=>$courseLvl);

				    $this->mymodel->update($courseData, 'course_level_details', $where_update_course_clause);
				}    

			    //Deleting records from change instructor table
				$where_delete_cancel_clause = array('courseId' => $courseId, 'courseLvl' => $courseLvl, 'instructorId' => $instructorId);

				$this->mymodel->delete('cancel_courses', $where_delete_cancel_clause);
				
				//Deleting records from student booked class table
				$where_delete_class_clause = array('studentId'=>$studentId,'courseId' => $courseId,'courseLvl' => $courseLvl,'instructorId'=>$instructorId);
				
				$this->mymodel->delete('student_booked_classes', $where_delete_class_clause);

				//Deleting records from student purchased course table
				$where_delete_purchase_clause = array('userId'=>$studentId,'courseId' => $courseId,'courseLvl' => $courseLvl);
				
				$this->mymodel->delete('student_purchased_courses', $where_delete_purchase_clause);
		   }	

	 	   if ($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
			   $msg = 'error';
			}
			else{
				$this->db->trans_commit();
                
                $msg = '["Cancellation approved successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);

		}
		redirect(admin_url('reports/cancelcoursedata'),'refresh');
	}

	public function denyCourseCancellation($requestId = false)
	{
		if ($requestId != false) {

			//Feching canclel course request details 
		   $sql_cancel_course = "SELECT cc.* FROM cancel_courses cc WHERE cc.requestId='$requestId'";  

           //echo $sql_cancel_course;exit;

	 	   $cancelCoursedata = $this->mymodel->fetch($sql_cancel_course, true);

	 	   $courseId = $cancelCoursedata->courseId;
	 	   $courseLvl = $cancelCoursedata->courseLvl;
	 	   $instructorId = $cancelCoursedata->instructorId;
	 	   $descriptions = $cancelCoursedata->descriptions;
           
           //Saving query data into db
		   $cancelData = array(
			              'courseId'=>$courseId,
			              'courseLvl'=>$courseLvl,
			              'instructorId'=>$instructorId,
			              'descriptions'=>$cancelCoursedata->descriptions,
			              'status' => '0',
			              'created'=> $cancelCoursedata->created,
			              'updated'=> $cancelCoursedata->updated
						);

		    //Saving query data into archive table
		    if($this->mymodel->save('cancel_courses_history', $cancelData)){
                
                $where = array('requestId' => $requestId);

				if (!$this->mymodel->delete('cancel_courses', $where)) {
					
					$msg = 'error';

				} else {
					
					$msg = '["Course cancel request was denyed successfully.", "success", "#A5DC86"]';
				}

		    }else{
               $msg = 'error';
		    }
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('reports/cancelcoursedata'),'refresh');
		}else{
			show_404();
		}
		
	}

	public function deleteCancelCourseHistory($requestId = false)
	{
		if ($requestId != false) {

			$this->db->trans_begin();

			$where_delete_query = array('requestId' => $requestId);

			if ($this->mymodel->delete('cancel_courses_history', $where_delete_query)) {
				
				//Deleting all booked classes from history table
				$where_delete_class = array('requestType' => 3,'requestId'=>$requestId);
				
				//executing delete query
				$this->mymodel->delete('student_booked_classes_history', $where_delete_class);
			}

			if ($this->db->trans_status() === FALSE){
			   $this->db->trans_rollback();
			   $msg = 'error';
			}else{
			   $this->db->trans_commit();
			   $msg = '["Purchase record was deleted successfully from history.", "success", "#A5DC86"]';
			}	

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('reports/cancelcoursedata'),'refresh');
		}else{
			show_404();
		}
	}


}