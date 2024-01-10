<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instructors extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function lists()
	{
		$data = array(
			'title' => 'List of Instructors',
			'page' => 'instructors',
			'subpage' => 'instructorlist'
		);
		$data['list'] =$this->mymodel->get_by('users', false, "userType=2", null, null, 'userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/instructor_list');
		$this->load->view('admin/footer');
	}

	public function profileUpdationRequestList()
	{
		$data = array(
			'title' => 'List of Profile Updation Request',
			'page' => 'profileupdationrequest',
			'subpage' => null
		);

		$sql_user_list = "SELECT u.*,utt.created as reqest_date FROM users u INNER JOIN users_temp_tbl utt ON u.userId=utt.userId ORDER BY u.userId DESC";
		
		$data['list'] = $this->mymodel->fetch($sql_user_list, false);

		/*print"<pre>";
  		print_r($data['list']);
  		print"</pre>";exit;*/

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/profile_updation_request_list');
		$this->load->view('admin/footer');
	}

	public function profileUpdationRequestDetail($userId)
	{
		$data = array(
			'title' => 'Detail of Profile Updation Request',
			'page' => 'profileupdationrequest',
			'subpage' => null
		);

		$data['userId'] = $userId;

		$sql_user_detail = "SELECT u.* FROM users u WHERE u.userId = '$userId'";
		$data['userDetails'] = $this->mymodel->fetch($sql_user_detail, true);

		$sql_user_updation_detail = "SELECT utt.* FROM users_temp_tbl utt WHERE utt.userId = '$userId'";
		$data['userUpdationDetails'] = $this->mymodel->fetch($sql_user_updation_detail, true);

		/*print"<pre>";
  		print_r($data['userDetails']);
  		print"</pre>";exit;*/

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/profile_updation_request_details');
		$this->load->view('admin/footer');
	}

	public function profileUpdationAction(){
		$userId = $this->input->post('userId');
		$action = $this->input->post('action');

		$sql_user_detail = "SELECT u.* FROM users u WHERE u.userId = '$userId'";
		$userDetails = $this->mymodel->fetch($sql_user_detail, true);

		$sql_user_updation_detail = "SELECT utt.* FROM users_temp_tbl utt WHERE utt.userId = '$userId'";
		$countUpdationRequest = $this->db->query($sql_user_updation_detail)->num_rows();
        
        if($countUpdationRequest){
            
            $userUpdationDetails = $this->mymodel->fetch($sql_user_updation_detail, true);
            $updatedPaymentInfo = unserialize($userUpdationDetails->payment_info);

			//Payement information configaration 
			$paymentInfoArr["bank_name"] = $updatedPaymentInfo['bank_name'];
			$paymentInfoArr["bank_address"] = $updatedPaymentInfo['bank_address'];
			$paymentInfoArr["ins_bank_name"] = $updatedPaymentInfo['ins_bank_name'];
			$paymentInfoArr["bank_acunt_no"] = $updatedPaymentInfo['bank_acunt_no'];
			$paymentInfoArr["routing_no"] = $updatedPaymentInfo['routing_no'];
			$paymentInfoArr["swift_code"] = $updatedPaymentInfo['swift_code'];

			$updatedProfilePic = $userUpdationDetails->profilePic;
			$updatedInsCv = $userUpdationDetails->cv;

			$where_user_clause = array('userId' => $userId);

			if($action == 'approve'){
	            
	            $profileData = array(
	               'firstName'=>$userUpdationDetails->firstName,
	               'lastName'=>$userUpdationDetails->lastName,  
	               'ccName' =>$userUpdationDetails->ccName,
				   'ccCode' =>$userUpdationDetails->ccCode,
				   'timezone' =>$userUpdationDetails->timezone,
				   'origin_country' =>$userUpdationDetails->origin_country,
	               'mobile'=>$userUpdationDetails->mobile,  
	               'profilePic'=>$userUpdationDetails->profilePic,  
	               'intro_video'=>$userUpdationDetails->intro_video,  
	               'cv'=>$userUpdationDetails->cv,   
	               'payment_info' => serialize($paymentInfoArr),
	               'descriptions' =>$userUpdationDetails->descriptions
	            );

	            $oldProfilePic = $userDetails->profilePic;
				$oldInsCv = $userDetails->cv;
	            
	            //Updating requested data from user temporary table to original table
	            if(!$this->mymodel->update($profileData,'users',$where_user_clause)) {
	               echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.')); 
	            }else{
	            	if (!empty($updatedProfilePic) && ($userDetails->profilePic != $userUpdationDetails->profilePic)) {
						if (file_exists('./uploads/users/'.$oldProfilePic)) {
							@unlink('./uploads/users/'.$oldProfilePic);
						}
					}

					if (!empty($updatedInsCv) && ($userDetails->cv != $userUpdationDetails->cv)) {
						if (file_exists('./uploads/cv/'.$oldInsCv)) {
							@unlink('./uploads/cv/'.$oldInsCv);
						}
					}
	                
	                //Deleting temporary data from user temporary table
					$this->mymodel->delete('users_temp_tbl', $where_user_clause);

					echo json_encode(array('check'=>'success','msg'=>'Profile data updation request is successfully approved!'));
	            } 
			}else{
			   if (!empty($updatedProfilePic) && ($userDetails->profilePic != $userUpdationDetails->profilePic)) {
					if (file_exists('./uploads/users/'.$updatedProfilePic)) {
					   @unlink('./uploads/users/'.$updatedProfilePic);
					}
				}

				if (!empty($updatedInsCv) && ($userDetails->cv != $userUpdationDetails->cv)) {
					if (file_exists('./uploads/cv/'.$updatedInsCv)) {
					   @unlink('./uploads/cv/'.$updatedInsCv);
					}
				}
	                
	            //Deleting temporary data from user temporary table
				$this->mymodel->delete('users_temp_tbl', $where_user_clause);

				echo json_encode(array('check'=>'warning','msg'=>'Profile data updation request is successfully rejected!'));	
			}
        }else{
        	echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.')); 
        }

	}

	public function add()
	{
		$data = array(
			'title' => 'Add New Instructor',
			'page' => 'instructors',
			'subpage' => 'instructoradd'
		);

		//Fetch timezone list
		$sql_timezone_list = "SELECT * FROM timezone tz ORDER BY tz.country_code"; 
		//echo $sql_timezone_list;exit;
		$data['timezoneList'] = $this->mymodel->fetch($sql_timezone_list,false);
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/instructor_add');
		$this->load->view('admin/footer');
	}


	public function create()
	{
		if ($this->input->post('email') && $this->input->post('mobile')) {

			$paymentInfoArr = array();

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
			   'userType' => 2,
			   'email' =>$this->testInput($this->input->post('email')),
			   'ccName' =>$this->testInput($this->input->post('ccName')),
			   'ccCode' =>$this->testInput($this->input->post('ccCode')),
			   'timezone' =>$this->testInput($this->input->post('timezone')),
			   'origin_country' =>$this->testInput($this->input->post('origin_country')),
			   'mobile' =>$this->testInput($this->input->post('mobile')),
			   'descriptions' =>$this->testInput($this->input->post('descriptions')),
			   'payment_info' => serialize($paymentInfoArr),
			   'status' => $this->input->post('status'),
			   'created'=> date('Y-m-d H:i:s'),	
			   'verificationStatus' => 1
	 		);
            
            //Uploading instructor related file & collecting their data
	 		if (!empty($_FILES['profilePic']['name'])){		
            
	           //upload an image options
		       $config = array();
		       $config['upload_path'] = './uploads/users/';
		       $config['allowed_types'] = 'gif|jpg|png';
		       $config['max_size'] = '20480';
			   $config['file_name'] = uniqid(); 

				//Loading upload library
				$this->load->library('upload'); 
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('profilePic'))
				{
					$error = strip_tags($this->upload->display_errors());
					echo json_encode(array('check'=>'failure','msg'=>'Profile pic upload error; Please try again.'));
					die;
				} else {
					$data = $this->upload->data();
					$mydata['profilePic'] = $data['file_name'];
				}
			}

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
				}
			}

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
			}

			$this->usermodel->addNewInstructor($mydata);
			
		} else {
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.'));
		}
	}

	public function edit($userId = false)
	{
		if ($userId == false) {
			show_404();
		} elseif ($this->mymodel->count('users', ['userId'=>$userId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit Instructor Profile',
				'page' => 'instructors',
				'subpage' => 'instructoredit'
			);
			
			$where = array(
				'userId' => $userId,
			);
			$data['data'] = $this->mymodel->get_by('users', true, $where);

			//Fetch timezone list
			$sql_timezone_list = "SELECT * FROM timezone tz ORDER BY tz.country_code"; 
			//echo $sql_timezone_list;exit;
			$data['timezoneList'] = $this->mymodel->fetch($sql_timezone_list,false);

			//FETCHING COURSE'S CHAPTER DETAIL
			$sql_course = "SELECT c.courseId,c.courseName,c.image,c.created,GROUP_CONCAT(ci.level) as course_level FROM courses c LEFT JOIN course_instructors ci ON c.courseId=ci.courseId WHERE ci.instructorId='".$userId."' GROUP BY c.courseId DESC";
			$data['courseList'] = $this->mymodel->fetch($sql_course, false);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/instructor_edit');
			$this->load->view('admin/footer');
		}
	}


	public function update()
	{
		if ($this->input->post('email') && $this->input->post('userId')) 
		{
			$userId = $this->input->post('userId');
			$where = array('userId'=>$userId);

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
				'status' => $this->input->post('status'),
	 		);

			if ($this->input->post('password') && $this->input->post('password') != '') 
			{
				$mydata['password'] = $this->enc_password($this->input->post('password'));
			}

			//Uploading instructor related file & collecting their data
			$oldProfilePic = $this->input->post('oldProfilePic');
            
            if (!empty($_FILES['profilePic']['name'])){		
            
	           //upload an image options
		       $config = array();
		       $config['upload_path'] = './uploads/users/';
		       $config['allowed_types'] = 'gif|jpg|png';
		       $config['max_size'] = '20480';
			   $config['file_name'] = uniqid(); 

			   //Loading upload library
			   $this->load->library('upload'); 
			   $this->upload->initialize($config);

			   if ( ! $this->upload->do_upload('profilePic'))
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

			/*print"<pre>";
		    print_r($mydata);
		    print"</pre>";exit;*/

			if (!$this->mymodel->update($mydata, 'users', $where)) {
				echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.'));
			} else {
				echo json_encode(array('check'=>'success','msg'=>'Instructor is successfully updated!'));
			}

		}else{
			echo json_encode(array('check'=>'failure','msg'=>'Something went wrong,Please try again.')); 
		}
	}


	public function changeStatus()
	{
		if ($this->input->post('userId')) {
			$userId = $this->input->post('userId');
			$status = $this->input->post('status');
			if ($status == 1) {
				$msg = 'Instructor account activated successfully!';
			} else {
				$msg = 'Instructor account deactivated successfully!';
			}
			if ($this->mymodel->update(['status'=>$status], 'users', ['userId'=>$userId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function changeApproveStatus()
	{
		if ($this->input->post('userId')) {
			$userId = $this->input->post('userId');
			$approve_status = $this->input->post('status');
			if ($approve_status == 1) {
				$msg = 'Instructor account approved successfully!';
			} else {
				$msg = 'Instructor account disapproved successfully!';
			}
			if ($this->mymodel->update(['approve_status'=>$approve_status], 'users', ['userId'=>$userId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function scheduleClasses($instructorId)
	{
		$data = array(
			'title' => 'Add New Schedule',
			'page' => 'instructors',
			'subpage' => 'instructoradd'
		);
		$data['instructorId'] = $instructorId;

		$this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/schedule/schedule_calendar');
		$this->load->view('admin/footer');
	}

	public function manageSchedule($instructorId)
	{   

		$data['title'] = "Manage Your Schedule";
		$data = array(
			'title' => 'Add New Schedule',
			'page' => 'instructors',
			'subpage' => 'instructoradd'
		);
		//Fetching Schedule Times for Current Instructor
		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";
		
		$data['instructorId'] = $instructorId;
		$data['scheduleTime'] = $this->mymodel->fetch($sql_schedule_time, true);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/schedule/manage_schedule');
		$this->load->view('admin/footer');
	}

	public function saveSchedule()
	{
		//print_r($_POST);exit;

		$instructorId = $this->input->post('instructorId');

		$scheduleTime = $this->input->post('scheduleTime');
		$weekdays = $this->input->post('weekdays');
		$saveErrorOcur = false; 

		//Deleting all schedule time before insert data
		$where_del_st_clause = array('instructorId' => $instructorId);
        $this->mymodel->delete('instructor_schedule_time', $where_del_st_clause);

		foreach($weekdays as $index => $weekday){
		 	 $mydata = array(
						  'instructorId' => $instructorId,
						  'weekday' => $weekday,
						  'fromTime' =>date('H:i',strtotime($scheduleTime['fromTime'])),
						  'toTime' => date('H:i',strtotime($scheduleTime['toTime']))
					   );

			//Insert schedule time data into db
		    if(!$this->mymodel->save('instructor_schedule_time', $mydata)){
	           $saveErrorOcur = true; 
		    }	
		}	

		if($saveErrorOcur){
            echo json_encode(array('check'=>'failure'));
		}else{
			echo json_encode(array('check'=>'success'));
		}
	}

	public function fetchSchedule($instructorId)
	{
        
        $list=array();
        $scheduleBgColorCdArr = array('#44760f','#ff0000','#d816c7','#102ce9','#044f16','#950202','#6e0769','#723c03','#000000');
		
		$day = date('d');
		$month = date('m');
		$year = date('Y');
		
		$sql_schedule_time = "SELECT GROUP_CONCAT(ist.weekday) as weekdays,ist.fromTime,ist.toTime FROM instructor_schedule_time ist WHERE ist.instructorId='".$instructorId."'";
		
		$scheduleTime = $this->mymodel->fetch($sql_schedule_time, true);

		//print_r($scheduleTime);exit;

		$date = date('Y-m-d');

		$allowedDayArr = explode(',', $scheduleTime->weekdays);
		$fromTime = $scheduleTime->fromTime;
		$toTime = $scheduleTime->toTime;
		
		$index = 0;
        
        for($m = $month; $m<=12; $m++){ 

			$currentMonthDays = date("t", strtotime($m));
			
			for($d=$day; $d<=31; $d++){

			    $time=strtotime($year.'-'.$m.'-'.$d);    
			    $current_day = date('l', $time);
			    //Shuffling color code array for random color
			    shuffle($scheduleBgColorCdArr);

			    if (date('m', $time)==$m && in_array($current_day,$allowedDayArr)){      
			        $list[$index]['title'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime)); 
			        $list[$index]['times'] = date('g:i A',strtotime($fromTime)).' - '.date('g:i A',strtotime($toTime));
			        $list[$index]['allDay'] = true;
			        $list[$index]['start']=date('Y-m-d', $time).'T'.$fromTime;
			        $list[$index]['end']=date('Y-m-d', $time).'T'.$toTime;
			        $list[$index]['constraint'] = "Available";
			        //$list[$index]['display'] = "background";
                    $list[$index]['url'] = 'javascript:void(0);';
					$list[$index]['color'] = "#0071dc";//$scheduleBgColorCdArr[0];

					$index++;
					
					if($d == $currentMonthDays){
					   $day = date('d', strtotime('first day of +1 month',$m+1));
					}
			    }    
			}
		}	
        
  		echo json_encode($list);
		
	}

	public function export_csv() 
	{
        $this->load->helper('csv');
        $export_arr = array();
        $studentDetails = $this->mymodel->fetch("SELECT * FROM users WHERE userType=2 ORDER BY userId DESC");
        $title = array("SI. No.", "Name","Account Type", "Email", "Phone","Status", "join Date");
        array_push($export_arr, $title);
        if (!empty($studentDetails))
        {
        	$i=1;
            foreach ($studentDetails as $student) 
            {
            	if($student->userType =='1')
            	{
						$studetType = "Student";
				} else {
					    $studetType = "Instructor";
				} 

				if($student->status ==1){
					$status = "Active";
				}else{
					$status = "Deactivated";
				}
				if(!empty($student->created)){
					$date = strtotime($student->created);
				$joineDate = date('d-M-y h:i:s A',$date);
				} 
                array_push($export_arr, array($i, $student->firstName.' '.$student->lastName,$studetType, $student->email, $student->mobile,$status,$joineDate));
                $i++;
            }
        }
        convert_to_csv($export_arr, 'Instructor-' . date('F d Y') . '.csv', ',');
    }


	public function delete($userId=false)
	{
	     if($userId == false) 
		 {
			show_404();
			exit();
		 }
		   if(!empty($userId))
		   {
		   	  		$profilePic = $this->usermodel->getRow($userId);
		   	  		$cv = $this->usermodel->getCv($userId);
					
					if(!empty($profilePic) && $profilePic != '' && !is_null($profilePic) && file_exists('./uploads/users/'.$profilePic)) {
						@unlink('./uploads/users/'.$profilePic);
				    }

				    if(!empty($cv) && $cv != '' && !is_null($cv) && file_exists('./uploads/cv/'.$cv)) {
						@unlink('./uploads/cv/'.$cv);
				    }
			   		
			   		$action = $this->usermodel->useRdelete($userId);
			   		
			   		if($action == 1)
			   		{
				   		    $success = "Deleted User details successfully !";
				        	$msg = '["'.$success.'", "success", "#A5DC86"]';
							$this->session->set_flashdata('msg', $msg);
				   		    redirect(admin_url('instructors/lists'));
			   		}else{
	                     	$error = "User details is not Deleted!";
				        	$msg = '["'.$error.'", "error", "#DD6B55"]';
							$this->session->set_flashdata('msg', $msg);
	                     	$this->lists();
			   		}
		   }else{
		   		        $error = " User details is successfully not Deleted !";
			        	$msg = '["'.$error.'", "error", "#DD6B55"]';
						$this->session->set_flashdata('msg', $msg);
                     	$this->lists();
		   }
	}

	public function view($userId = false)
	{
		if ($userId == false) {
			show_404();
		} elseif ($this->mymodel->count('users', ['userId'=>$userId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'View Profile',
				'page' => 'instructors',
				'subpage' => 'instructorlist'
			);

			//Fetch timezone list
			$sql_timezone_list = "SELECT * FROM timezone tz ORDER BY tz.country_code"; 
			//echo $sql_timezone_list;exit;
			$data['timezoneList'] = $this->mymodel->fetch($sql_timezone_list,false);
			
			$where = array(
				'userId' => $userId,
			);

			$data['data'] = $this->mymodel->get_by('users', true, $where);
			//FETCHING COURSE'S CHAPTER DETAIL
			$sql_course = "SELECT c.courseId,c.courseName,c.image,c.created,GROUP_CONCAT(ci.level) as course_level FROM courses c LEFT JOIN course_instructors ci ON c.courseId=ci.courseId WHERE ci.instructorId='".$userId."' GROUP BY c.courseId DESC";
			$data['courseList'] = $this->mymodel->fetch($sql_course, false);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/instructor_view');
			$this->load->view('admin/footer');
		}
	}

}