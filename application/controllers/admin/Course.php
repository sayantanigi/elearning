<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Course extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function lists()
	{
		$data = array(
			'title' => 'List of Courses',
			'page' => 'course',
			'subpage' => 'courselist'
		);
		$data['list'] = $this->mymodel->get_by('courses', false, NULL, 'courseId');
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/course_list');
		$this->load->view('admin/footer');
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

	public function add()
	{
		$data = array(
			'title' => 'Add New Course',
			'page' => 'course',
			'subpage' => 'courseadd'
		);
          
      //Fetching Subject
		$data['subjectList'] = $this->mymodel->get_by('subjects', false, "status=1", 'subjectId');
		//Fetching Instructor
 		$data['instList'] = $this->mymodel->get_by('users', false, "userType = 2 AND status=1 AND approve_status=1", 'userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/course_add');
		$this->load->view('admin/footer');
	}

	public function load_new_level_html(){
	    $userId = $this->session->userdata('userId');
        
         $data['currentLvl'] = $this->input->post('currentLvl'); 
	    $data['courseLvl'] = $this->input->post('courseLvl');
	    $data['courseLvlCount'] = $this->input->post('courseLvlCount');
	    $data['list'] = $this->mymodel->get_by('subjects', false, "status=1", 'subjectId');

		$returnArr['html'] = $this->load->view('admin/level_ajax_html',$data,true);
		echo json_encode($returnArr);
	}

	private function set_upload_options($upload_path)
     {   
        //upload an image options
        $config = array();
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = '20480';
	     $config['file_name'] = uniqid();
        
        return $config;
    }

    public function create(){

    	     //print_r($_POST);

		if(!empty($this->input->post('courseName')) && !empty($_FILES['courseImage']['name'])){

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
	    
	    if($this->session->userdata('admin') == 1){
		   $userType = "admin";
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
			   "approve_status"=> "approved",
			   'created'=>date('Y-m-d H:i:s') 
			);

		//Loading upload library
		$this->load->library('upload'); 

		if (!empty($_FILES['courseImage']['name'])){			
			$upload_path = './uploads/courses/';		
			$this->upload->initialize($this->set_upload_options($upload_path));

			if (!$this->upload->do_upload('courseImage'))
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

		  if(!empty($this->input->post('chapterId_beginner')) && !empty($this->input->post('insId_beginner')) && !empty($this->input->post('lvl_dsiply_status_beginner'))){
					
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

		  if(!empty($this->input->post('chapterId_intermediate')) && !empty($this->input->post('insId_intermediate')) && !empty($this->input->post('lvl_dsiply_status_intermediate'))){    

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

		  if(!empty($this->input->post('chapterId_advanced')) && !empty($this->input->post('insId_advanced')) && !empty($this->input->post('lvl_dsiply_status_advanced'))){   

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
	   }
	} 

	public function edit($courseId = false)
	{
		if ($courseId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Course Info',
			'page' => 'course',
			'subpage' => 'courselist'
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
 		$data['instList'] = $this->mymodel->get_by('users', false, "userType = 2 AND status=1 AND approve_status=1", 'userId');

      //Feching Course Level Details 
		$data['levelDetail'] = $this->mymodel->get('course_level_details', false, 'courseId', $courseId);

		//FETCHING COURSE'S CHAPTER DETAIL
		$sql_chapter = "SELECT cc.level,GROUP_CONCAT(cc.chapterId) as chapterId, GROUP_CONCAT(chp.subjectId) as subjectId FROM course_chapters cc LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE cc.courseId='".$courseId."' GROUP BY cc.level";
		$data['courseChapterIds'] = $this->mymodel->fetch($sql_chapter, false);

		//FETCHING COURSE'S INSTRUCTOR DETAILS
		$sql_instructor = "SELECT ci.level,GROUP_CONCAT(ci.instructorId) as insId FROM course_instructors ci WHERE ci.courseId='".$courseId."' GROUP BY ci.level";
		$data['courseInsIds'] = $this->mymodel->fetch($sql_instructor, false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/course_edit');
		$this->load->view('admin/footer');
	}

	public function update(){

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

			if (!empty($_FILES['courseImage']['name'])){			
				$upload_path = './uploads/courses/';		
				$this->upload->initialize($this->set_upload_options($upload_path));

				if (!$this->upload->do_upload('courseImage'))
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
				if (!empty($_FILES['courseImage']['name']) && file_exists('./uploads/courses/'.$courseImg)) {
					 @unlink('./uploads/courses/'.$courseImg);
				}
				echo json_encode(array('check'=>'failure','msg'=>'Some error occured, Please try later.'));
				exit;
			} else {

				if ($oldCourseImage && !empty($_FILES['courseImage']['name'])) {
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
		                
			                $beginnerLvlDesc = $this->input->post('descriptions_beginner');
			                $beginner_intro_video = $this->input->post('beginner_intro_video');
			                $beginnerLvlStatus = $this->input->post('lvl_dsiply_status_beginner');

			                $beginnerLvlData = array(
						                	  'courseId'=>$courseId,
						                	  'level'=>'beginner',
						                	  'descriptions'=>$beginnerLvlDesc,
						                	  'intro_video'=>$beginner_intro_video,
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

			                $interLvlDesc = $this->input->post('descriptions_intermediate');
			                $intermediate_intro_video = $this->input->post('intermediate_intro_video');
			                $interLvlStatus = $this->input->post('lvl_dsiply_status_intermediate');

			                $interLvlData = array(
				                	'courseId'=>$courseId,
				                	'level'=>'intermediate',
				                	'descriptions'=>$interLvlDesc,
				                	'intro_video'=>$intermediate_intro_video,
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

			                $advanceLvlDesc = $this->input->post('descriptions_advanced');
			                $advanced_intro_video = $this->input->post('advanced_intro_video');
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

	public function delete($courseId = false)
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
		redirect(admin_url('course/lists'),'refresh');
	}

	public function view($courseId = false)
	{
		if ($courseId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Course Info',
			'page' => 'course',
			'subpage' => 'courselist'
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
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/course_view');
		$this->load->view('admin/footer');
	}

	public function changeStatus()
	{
		if ($this->input->post('courseId'))
		 {
			$courseId = $this->input->post('courseId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Published successfully!';
			} else {
				$msg = 'Un Published successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'courses', ['courseId'=>$courseId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function changeCourseApproveStatus()
	{
		if ($this->input->post('courseId')) {
			$courseId = $this->input->post('courseId');
			$approve_status = $this->input->post('status');
			if ($approve_status == "approved") {
				$msg = "Course was approved successfully!";
			} else {
				$msg = "Course wasn't approved successfully!";
			}
			if ($this->mymodel->update(['approve_status'=>$approve_status], 'courses', ['courseId'=>$courseId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function cloneCourse()
	{
		$subjectId = $this->input->post('subjectId');
		
		if ($subjectId == false) 
		{
			show_404();
			exit();
		}

		$subjectInfo = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);
		if($subjectInfo)
		{
			$mydata = array(
				'subjectName' => $subjectInfo->subjectName,
				'summary' => $subjectInfo->summary,
				'objectives' => $subjectInfo->objectives,
				'image' => '',
				'status'=> '0',
				'created'=> date('Y-m-d H:i:s'),	
			);

			if (!$this->mymodel->save('subjects', $mydata)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Subject cloned successfully", "success", "#A5DC86"]';
			}
			echo $msg;
			
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
}