<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function lists()
	{
		$data = array(
			'title' => 'List',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		$data['list'] = $this->mymodel->get_by('subjects', false, NULL, 'subjectId');
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/subject_list');
		$this->load->view('admin/footer');
	}

	public function add()
	{
		$data = array(
			'title' => 'Add New Subject',
			'page' => 'subjects',
			'subpage' => 'subjectadd'
		);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/subject_add');
		$this->load->view('admin/footer');
	}

	public function create()
	{
		if ($this->input->post('subjectName') && $_FILES['image']['name'] != '') 
		{  
			$userId = $this->session->userdata("userId");
			if($this->session->userdata('admin') == 1){
				$userType = "admin";
			}
			
			$config['upload_path'] = './uploads/subject/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			$config['file_name'] = uniqid();
			
			$this->load->library('upload', $config);
			
			if( ! $this->upload->do_upload('image'))
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
					'approve_status' => 'approved',
					'created'=> date('Y-m-d H:i:s'),	
					'created_by'=> $userType,
					'creator_id'=> $userId
				);

				if (!$this->mymodel->save('subjects', $mydata)) 
				{
					$msg = 'error';
				} else {
					$msg = '["Subject added successfully", "success", "#A5DC86"]';
				}
			}

			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/lists'),'refresh');
	}

	public function edit($subjectId = false)
	{
		if ($subjectId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Subject',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);

		$data['data'] = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/subject_edit');
		$this->load->view('admin/footer');
	}

	public function update()
	{
		if ($this->input->post('subjectName') && $this->input->post('subjectId')) 
		{

			$where = array('subjectId' => $this->input->post('subjectId'));

			$userId = $this->session->userdata("userId");
			if($this->session->userdata('admin') == 1){
				$userType = "admin";
			}
			
			$oldImage = $this->input->post('oldImage');
			
			$mydata = array(
				'subjectName' => $this->testInput($this->input->post('subjectName')),
				'summary' => $this->testInput($this->input->post('summary')),
				'objectives' =>$this->testInput($this->input->post('objectives')),
			);

			if ($_FILES['image']['name'] != '') {
			
				$config['upload_path'] = './uploads/subject/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				$config['file_name'] = uniqid();
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('image')){
					
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

					if ($oldImage && $_FILES['image']['name'] != '') {
						if (file_exists('./uploads/subject/'.$oldImage)) {
							@unlink('./uploads/subject/'.$oldImage);
						}
					}
					$msg = '["Subject updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('subject/lists'),'refresh');
	}

	public function delete($subjectId = false)
	{
		if ($subjectId != false) {

			$where = array('subjectId' => $subjectId);
			$data = $this->mymodel->get_by('subjects', true, $where);

			if (!$this->mymodel->delete('subjects', $where)) {
				
				$msg = 'error';

			} else {

				$this->mymodel->update(['subjectId'=>0], 'chapters', ['subjectId'=>$subjectId]);
				$this->mymodel->update(['subjectId'=>0], 'tests', ['subjectId'=>$subjectId]);
				
				if (@$data->image && file_exists('./uploads/subject/'.@$data->image)) {
					@unlink('./uploads/subject/'.@$data->image);
				}
				$msg = '["Subject deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('subject/lists'),'refresh');
	}

	public function view($subjectId = false)
	{
		if ($subjectId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Subject',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		$data['data'] = $this->mymodel->get('subjects', true, 'subjectId', $subjectId);

		$data['chpaterlist'] = $this->mymodel->get('chapters', false, 'subjectId', $subjectId);

		$data['testList'] = $this->mymodel->get('tests', false, 'subjectId', $subjectId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/subject_view');
		$this->load->view('admin/footer');
	}

	public function changeStatus()
	{
		if ($this->input->post('subjectId'))
		 {
			$subjectId = $this->input->post('subjectId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Published successfully!';
			} else {
				$msg = 'Un Published successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'subjects', ['subjectId'=>$subjectId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function changeSubjectApproveStatus()
	{
		if ($this->input->post('subjectId')) {
			$subjectId = $this->input->post('subjectId');
			$approve_status = $this->input->post('status');
			if ($approve_status == "approved") {
				$msg = "Subject was approved successfully!";
			} else {
				$msg = "Subject wasn't approved successfully!";
			}
			if ($this->mymodel->update(['approve_status'=>$approve_status], 'subjects', ['subjectId'=>$subjectId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function cloneSubject()
	{
		$subjectId = $this->input->post('subjectId');
		if ($subjectId == false) {
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

	public function addChapter($subjectId = false)
	{
		$data = array(
			'title' => 'Add New Chapter',
			'page' => 'subjects',
			'subpage' => 'chapteradd'
		);

		$data['subjectId'] = $subjectId;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/chapter_add', $data);
		$this->load->view('admin/footer');
	}

	public function createChapter()
	{
		$subjectId = $this->input->post('subjectId');

		if ($this->input->post('chapterName') && $_FILES['chapterImage']['name'] != '') 
		{
			
			$config['upload_path'] = './uploads/chapter/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			$config['file_name'] = uniqid();
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('chapterImage'))
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
					'approve_status' => 'approved',
					'created'=> date('Y-m-d H:i:s'),	
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
		redirect(admin_url('subject/view/'.$subjectId),'refresh');
	}

	public function editChapter()
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);

		if ($chapterId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'Edit Chapter',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		

		$data['data']= $chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/chapter_edit');
		$this->load->view('admin/footer');

	}

	public function updateChapter()
	{
		$chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $this->input->post('chapterId'));

		if ($this->input->post('chapterName') && $this->input->post('chapterId')) 
		{

			$where = array('chapterId' => $this->input->post('chapterId'));
			
			$oldImage = $this->input->post('oldImage');
			
			$mydata = array(
				'chapterNumber' => $this->testInput($this->input->post('chapterNumber')),
				'chapterName' => $this->testInput($this->input->post('chapterName')),
				'summary' => $this->testInput($this->input->post('summary')),
				'objectives' =>$this->testInput($this->input->post('objectives')),
				'totalHours' => $this->testInput($this->input->post('totalHours')),
				'cost' => $this->testInput($this->input->post('cost')),
			);

			if ($_FILES['chapterImage']['name'] != '') {
			
				$config['upload_path'] = './uploads/chapter/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('chapterImage')){
					
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

					if ($oldImage && $_FILES['chapterImage']['name'] != '') {
						if (file_exists('./uploads/chapter/'.$oldImage)) {
							@unlink('./uploads/chapter/'.$oldImage);
						}
					}
					$msg = '["Chapter updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('subject/view/'.$chapterInfo->subjectId),'refresh');
	}

	public function changeChapterApproveStatus()
	{
		if ($this->input->post('chapterId')) {
			$chapterId = $this->input->post('chapterId');
			$approve_status = $this->input->post('status');
			if ($approve_status == "approved") {
				$msg = "Chapter was approved successfully!";
			} else {
				$msg = "Chapter wasn't approved successfully!";
			}
			if ($this->mymodel->update(['approve_status'=>$approve_status], 'chapters', ['chapterId'=>$chapterId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function chapter_curriculum($subjectId,$chapterId){
		$data = array(
			'title' => 'Chapter Carriculum Media Management',
			'page' => 'chaptercurriculum',
		);
		
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
          
        //Fetching all image data for this course carriculum
		$sql_fetch_media = "SELECT * FROM `chapter_carriculum_media` as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.ordering ASC";

		$data['mediaFiles'] = $this->mymodel->fetch($sql_fetch_media,false);

        $this->load->view('admin/header',$data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/chapter_carriculum');
		$this->load->view('admin/footer');   
	}
    
    public function load_Ajax_Chapter_Curriculum($subjectId,$chapterId){		
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
          
        //Fetching all image data for this course carriculum
		$sql_fetch_media = "SELECT * FROM `chapter_carriculum_media` as ccm WHERE ccm.subjectId='$subjectId' AND ccm.chapterId='$chapterId' ORDER BY ccm.ordering ASC";

		$data['mediaFiles'] = $this->mymodel->fetch($sql_fetch_media,false);

		$curriculum_html = $this->load->view('admin/chapter_carriculum_ajax',$data,true);
		echo json_encode($curriculum_html);
	} 

	public function uploadChapterCurriculum($subjectId,$chapterId){
	     
	     if(!empty($_FILES['chapterCurriculumFile']['name'])){
               
            $allowedExtStr = "gif|jpg|jpeg|png|pdf|doc|docx|csv|xls|ppt|pptx|mp3|wav|ogg|mp4";

            $config['upload_path'] = './uploads/chapter_curriculum/';
			$config['allowed_types'] = $allowedExtStr;
			$config['max_size'] = '41560';
			$config['file_name'] = 'carriculum_'.rand(10,99).time();

			$file_ext = pathinfo($_FILES["chapterCurriculumFile"]["name"], PATHINFO_EXTENSION);
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('chapterCurriculumFile')){
				$error = strip_tags($this->upload->display_errors());
				$mediaUploadError = $error;
				echo json_encode(array("check"=>"failure","msg"=>$mediaUploadError));
			} else {
			
				$data = $this->upload->data();
				$mediaFile = $data['file_name'];

				$mediaOgName = pathinfo($_FILES['chapterCurriculumFile']['name'], PATHINFO_FILENAME);
				$fileSize = $_FILES["chapterCurriculumFile"] ["size"]; 
			
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
				    echo json_encode(array("check"=>"success","msg"=>"Media is successfully uploaded!"));
				    //echo json_encode(array($mediauRL));
				}
		     } 
		}     
	}

	public function saveChapterCurriculumOrder($subjectId,$chapterId){
		$orderData = $this->input->post('curriculum');
		
		$this->db->trans_start();
		foreach ($orderData as $index => $order) {
			$where_clause =  array('subjectId' => $subjectId,'chapterId' => $chapterId,'mediaId' => $order);
			//Saving updated order of media
			$this->mymodel->update(['ordering'=>$index+1], 'chapter_carriculum_media',$where_clause);
		}
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
       	   echo json_encode(array("check"=>"failure","msg"=>"Some error occured, Please try again!"));
		}else{
           echo json_encode(array("check"=>"success","msg"=>"Media ordering saved successfully!"));   
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

	public function viewChapter()
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);
		
		if ($chapterId == false) {
			show_404();
			exit();
		}

		$data = array(
			'title' => 'View Chapter',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
	
		$data['data']=  $this->mymodel->get('chapters', true, 'chapterId', $chapterId);

		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;

		$data['list'] = $this->mymodel->get('lessons', false, 'chapterId', $chapterId);
		$data['lessonList'] = $this->mymodel->get('lessons', false, 'chapterId', $chapterId);
		$data['testList'] = $this->mymodel->get('tests', false, 'chapterId', $chapterId);
		
		$data['quizList'] = $this->mymodel->get('quiz', false, 'chapterId', $chapterId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/chapter_view');
		$this->load->view('admin/footer');
	}

	public function cloneChapter()
	{
		$chapterId = $this->input->post('chapterId');
		
		if ($chapterId == false) {
			show_404();
			exit();
		}

		$chapterInfo = $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
		
		if($chapterInfo)
		{
			$mydata = array(
				'subjectId' =>$chapterInfo->subjectId,
				'chapterNumber' => $chapterInfo->chapterNumber,
				'chapterName' => $chapterInfo->chapterName,
				'objectives' => $chapterInfo->objectives,
				'summary' =>$chapterInfo->summary,
				'chapterImage' => '',
				'status'=> '0',
				'created'=> date('Y-m-d H:i:s'),	
			);

			if (!$this->mymodel->save('chapters', $mydata)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Chapter cloned successfully", "success", "#A5DC86"]';
			}

			echo $msg;
			
		}		
	}

	public function changeChapterStatus()
	{
		if ($this->input->post('chapterId'))
		 {
			$chapterId = $this->input->post('chapterId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Activated successfully!';
			} else {
				$msg = 'Deactivated successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'chapters', ['chapterId'=>$chapterId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function deleteChapter($chapterId = false)
	{
		$chapterInfo= $this->mymodel->get('chapters', true, 'chapterId', $chapterId);
		
		if ($chapterId != false) 
		{

			$where = array('chapterId' => $chapterId);
			$data = $this->mymodel->get_by('chapters', true, $where);

			if (!$this->mymodel->delete('chapters', $where)) {
				
				$msg = 'error';

			} else {
				
				if (@$data->chapterImage && file_exists('./uploads/chapter/'.@$data->chapterImage)) {
					@unlink('./uploads/chapter/'.@$data->chapterImage);
				}
				$msg = '["Chpater deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/view/'.$chapterInfo->subjectId),'refresh');

	}

	public function addLesson()
	{
		$data = array(
			'title' => 'Add New Lesson',
			'page' => 'subjects',
			'subpage' => 'chapteradd'
		);

		$data['subjectId'] = $this->uri->segment(4);
		$data['chapterId'] = $this->uri->segment(5);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/lesson_add', $data);
		$this->load->view('admin/footer');
	}

	public function createLesson()
	{
		$chapterId = $this->input->post('chapterId');
		$subjectId = $this->input->post('subjectId');

		if ($this->input->post('lessonName') && $_FILES['lessonImage']['name'] != '') 
		{
			
			$config['upload_path'] = './uploads/lesson/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			$config['file_name'] = uniqid();
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('lessonImage'))
			{
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
		
			} else {

				$data = $this->upload->data();

				$mydata = array(
					'chapterId' => $this->testInput($this->input->post('chapterId')),
					'lessonNumber' => $this->testInput($this->input->post('lessonNumber')),
					'lessonName' => $this->testInput($this->input->post('lessonName')),
					'objectives' => $this->testInput($this->input->post('objectives')),
					'syllabus' => $this->testInput($this->input->post('syllabus')),
					'duration' => $this->testInput($this->input->post('duration')),
					'lessonImage' => $data['file_name'],
					'created'=> date('Y-m-d H:i:s'),
					'status' =>1,	
				);

				if (!$this->mymodel->save('lessons', $mydata)) 
				{
					$msg = 'error';
				} else {
					$msg = '["Lesson added successfully", "success", "#A5DC86"]';
				}
			}

			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId),'refresh');
	}

	public function editLesson($lessonId = false)
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);
		$lessonId = $this->uri->segment(6);

		if ($lessonId == false) 
		{
			show_404();
			exit();
		}

		$data = array(
			'title' => 'Edit Lesson',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;

		$data['data'] = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/lesson_edit');
		$this->load->view('admin/footer');
	}

	public function updateLesson()
	{
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');

		if ($this->input->post('lessonNumber') && $this->input->post('lessonId')) 
		{

			$where = array('lessonId' => $this->input->post('lessonId'));
			
			$oldImage = $this->input->post('oldImage');
			
			$mydata = array(
					'lessonName' => $this->testInput($this->input->post('lessonName')),
					'lessonNumber' => $this->testInput($this->input->post('lessonNumber')),
					'objectives' => $this->testInput($this->input->post('objectives')),
					'duration' => $this->testInput($this->input->post('duration')),
					'syllabus' => $this->testInput($this->input->post('syllabus')),
			);

			if ($_FILES['lessonImage']['name'] != '') {
			
				$config['upload_path'] = './uploads/lesson/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('lessonImage')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['lessonImage'] = $data['file_name'];
				}
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($mydata, 'lessons', $where)) {
					
					$msg = 'error';

				} else {

					if ($oldImage && $_FILES['lessonImage']['name'] != '') {
						if (file_exists('./uploads/lesson/'.$oldImage)) {
							@unlink('./uploads/lesson/'.$oldImage);
						}
					}
					$msg = '["Lesson updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId),'refresh');
	}

	public function viewLesson()
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);
		$lessonId = $this->uri->segment(6);

		if ($lessonId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Lesson',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
		$data['data'] = $this->mymodel->get('lessons', true, 'lessonId', $lessonId);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;

		$data['testList'] = $this->mymodel->get('tests', false, 'lessonId', $lessonId);
		
		$data['quizList'] = $this->mymodel->get('quiz', false, 'lessonId', $lessonId);


		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/lesson_view');
		$this->load->view('admin/footer');
	}

	public function deleteLesson($lessonId = false)
	{
		if ($lessonId != false) 
		{

			$where = array('lessonId' => $lessonId);
			$data = $this->mymodel->get_by('lessons', true, $where);

			if (!$this->mymodel->delete('lessons', $where)) {
				
				$msg = 'error';

			} else {
				
				if (@$data->lessionImage && file_exists('./uploads/lesson/'.@$data->lessionImage)) {
					@unlink('./uploads/lesson/'.@$data->lessionImage);
				}
				$msg = '["Lesson deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/lists'),'refresh');
	}

	public function addTest()
	{
		$data = array(
			'title' => 'Add New Test',
			'page' => 'subjects',
			'subpage' => 'testadd'
		);

		$data['subjectId'] = $this->uri->segment(4);
		$data['chapterId'] = $this->uri->segment(5);
		$data['lessonId'] = $this->uri->segment(6);
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/test_add', $data);
		$this->load->view('admin/footer');
	}

	public function createTest()
	{
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
		$lessonId = $this->input->post('lessonId');

		if ($this->input->post('testName') && $_FILES['coverImg']['name'] != '') 
		{
			
			$config['upload_path'] = './uploads/test/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '20480';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('coverImg'))
			{
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
		
			} else {

				$data = $this->upload->data();

				$mydata = array(
					'subjectId' => $this->testInput($this->input->post('subjectId')),
					'chapterId' => $chapterId,
					'lessonId' => $lessonId,
					'testNumber' => $this->testInput($this->input->post('testNumber')),
					'testName' => $this->testInput($this->input->post('testName')),
					'instructions' =>$this->testInput($this->input->post('instructions')),
					'duration' => $this->testInput($this->input->post('duration')),
					'coverImg' => $data['file_name'],
					'created'=> date('Y-m-d H:i:s'),	
				);

				if (!$this->mymodel->save('tests', $mydata)) 
				{
					$msg = 'error';
				} else {
					$msg = '["Test added successfully", "success", "#A5DC86"]';
				}
			}

			$this->session->set_flashdata('msg', $msg);
		}
		if(!empty( $subjectId) && !empty($chapterId) && !empty($lessonId)){
			redirect(admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId),'refresh');
		}elseif(!empty( $subjectId) && !empty($chapterId)){
		     redirect(admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId),'refresh');
		}else{
			redirect(admin_url('subject/view/'.$subjectId),'refresh');
		}
		
	}

	public function viewTest()
	{
		$subjectId  ='';
		$chapterId  ='';
		$lessonId  ='';
		$testId  ='';
		$totalSegment = count($this->uri->segment_array());
		if(!empty($totalSegment) && $totalSegment ===5){
			$subjectId = $this->uri->segment(4);
			$testId = $this->uri->segment(5);
		}elseif (!empty($totalSegment) && $totalSegment ===6) {
			$subjectId = $this->uri->segment(4);
			$chapterId = $this->uri->segment(5);
			$testId = $this->uri->segment(6);
		}elseif(!empty($totalSegment) && $totalSegment ===7){
			$subjectId = $this->uri->segment(4);
			$chapterId = $this->uri->segment(5);
			$lessonId = $this->uri->segment(6);
			$testId = $this->uri->segment(7);
		}

		if ($testId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Test',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
		$data['data'] = $this->mymodel->get('tests', true, 'testId', $testId);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;
		$data['testId'] = $testId;

		$data['questionList'] = $this->mymodel->get('questions', false, 'testId', $testId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/test_view');
		$this->load->view('admin/footer');
	}

	public function editTest()
	{
		$subjectId  ='';
		$chapterId  ='';
		$lessonId  ='';
		$testId  ='';
		$totalSegment = count($this->uri->segment_array());
		if(!empty($totalSegment) && $totalSegment ===5){
			$subjectId = $this->uri->segment(4);
			$testId = $this->uri->segment(5);
		}elseif (!empty($totalSegment) && $totalSegment ===6) {
			$subjectId = $this->uri->segment(4);
			$chapterId = $this->uri->segment(5);
			$testId = $this->uri->segment(6);
		}elseif(!empty($totalSegment) && $totalSegment ===7){
			$subjectId = $this->uri->segment(4);
			$chapterId = $this->uri->segment(5);
			$lessonId = $this->uri->segment(6);
			$testId = $this->uri->segment(7);
		}
		if ($testId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'Edit Test',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
		$data['data'] = $this->mymodel->get('tests', true, 'testId', $testId);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;
		$data['testId'] = $testId;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/test_edit');
		$this->load->view('admin/footer');

	}

	public function updateTest()
	{
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
		$lessonId = $this->input->post('lessonId');
		$testId = $this->input->post('testId');

		if ($this->input->post('testName') && $this->input->post('testId')) 
		{

			$where = array('testId' => $this->input->post('testId'));
			
			$oldImage = $this->input->post('oldImage');
			
			$mydata = array(
					'testName' => $this->testInput($this->input->post('testName')),
					'testNumber' => $this->testInput($this->input->post('testNumber')),
					'duration' => $this->testInput($this->input->post('duration')),
					'instructions' => $this->testInput($this->input->post('instructions')),
			);

			if ($_FILES['coverImg']['name'] != '') {
			
				$config['upload_path'] = './uploads/test/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '20480';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('coverImg')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['coverImg'] = $data['file_name'];
				}
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($mydata, 'tests', $where)) {
					
					$msg = 'error';

				} else {

					if ($oldImage && $_FILES['coverImg']['name'] != '') {
						if (file_exists('./uploads/test/'.$oldImage)) {
							@unlink('./uploads/test/'.$oldImage);
						}
					}
					$msg = '["Test updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}

			if(!empty( $subjectId) && !empty($chapterId) && !empty($lessonId)){
				redirect(admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId),'refresh');
			}elseif(!empty( $subjectId) && !empty($chapterId)){
			     redirect(admin_url('subject/viewChapter/'.$subjectId.'/'.$chapterId),'refresh');
			}else{
				redirect(admin_url('subject/view/'.$subjectId),'refresh');
			}
	}

	public function cloneTest()
	{
		$testId = $this->input->post('testId');
		
		if ($testId == false) {
			show_404();
			exit();
		}

		$testInfo = $this->mymodel->get('tests', true, 'testId', $testId);
		
		if($testInfo)
		{
			$mydata = array(
				'subjectId' =>$testInfo->subjectId,
				'chapterId' =>$testInfo->chapterId,
				'lessonId' =>$testInfo->lessonId,
				'testNumber' => $testInfo->testNumber,
				'testName' => $testInfo->testName,
				'instructions' => $testInfo->instructions,
				'duration' =>$testInfo->duration,
				'coverImg' => '',
				'status'=> '0',
				'created'=> date('Y-m-d H:i:s'),	
			);

			if (!$this->mymodel->save('tests', $mydata)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Test cloned successfully", "success", "#A5DC86"]';
			}

			echo $msg;
			
		}		
	}

	public function changeTestStatus()
	{
		if ($this->input->post('testId'))
		 {
			$testId = $this->input->post('testId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Activated successfully!';
			} else {
				$msg = 'Deactivated successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'tests', ['testId'=>$testId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function deleteTest($testId = false)
	{
		$redirectto = $this->input->get('redirectto');
		if ($testId != false) 
		{
			$where = array('testId' => $testId);
			$data = $this->mymodel->get_by('tests', true, $where);
			if (!$this->mymodel->delete('tests', $where)) {
				$msg = 'error';
			} else {
				if (@$data->coverImg && file_exists('./uploads/test/'.@$data->coverImg)) {
					@unlink('./uploads/test/'.@$data->coverImg);
				}
				$msg = '["Test deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect($redirectto,'refresh');
	}

	public function addQuiz()
	{
		$data = array(
			'title' => 'Add New Quiz',
			'page' => 'subjects',
			'subpage' => 'quizadd'
		);

		$data['subjectId'] = $this->uri->segment(4);
		$data['chapterId'] = $this->uri->segment(5);
		$data['lessonId'] = $this->uri->segment(6);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/quiz_add', $data);
		$this->load->view('admin/footer');
	}

	public function createQuiz()
	{
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
		$lessonId = $this->input->post('lessonId');

		if ($this->input->post('quizName') && $this->input->post('quizNumber')) 
		{
			$mydata = array(
				'chapterId' => $chapterId,
				'lessonId' => $lessonId,
				'quizNumber' => $this->testInput($this->input->post('quizNumber')),
				'quizName' => $this->testInput($this->input->post('quizName')),
				'instructions' =>$this->testInput($this->input->post('instructions')),
				'created'=> date('Y-m-d H:i:s'),	
			);

			if (!$this->mymodel->save('quiz', $mydata)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Quiz added successfully", "success", "#A5DC86"]';
			}			

			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId),'refresh');
	}

	public function editQuiz()
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);
		$lessonId = $this->uri->segment(6);
		$quizId = $this->uri->segment(7);

		if ($quizId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'Edit Quiz',
			'page' => 'subjects',
			'subpage' => 'quizedit'
		);
		
		$data['data'] = $this->mymodel->get('quiz', true, 'quizId', $quizId);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;
		$data['quizId'] = $quizId;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/quiz_edit');
		$this->load->view('admin/footer');

	}

	public function updateQuiz()
	{
		$subjectId = $this->input->post('subjectId');
		$chapterId = $this->input->post('chapterId');
		$lessonId = $this->input->post('lessonId');
		$quizId = $this->input->post('quizId');

		if ($this->input->post('quizName') && $this->input->post('quizId')) 
		{
			$where = array('quizId' => $this->input->post('quizId'));
			
			$mydata = array(
				'quizName' => $this->testInput($this->input->post('quizName')),
				'quizNumber' => $this->testInput($this->input->post('quizNumber')),
				'instructions' => $this->testInput($this->input->post('instructions')),
			);

			if (!$this->mymodel->update($mydata, 'quiz', $where)) {

				$msg = 'error';

			} else {
			
				$msg = '["Quiz updated successfully", "success", "#A5DC86"]';
			}

			$this->session->set_flashdata('msg', $msg);
		}

		redirect(admin_url('subject/viewLesson/'.$subjectId.'/'.$chapterId.'/'.$lessonId),'refresh');
	}

	public function cloneQuiz()
	{
		$quizId = $this->input->post('quizId');
		
		if ($quizId == false) {
			show_404();
			exit();
		}

		$quizInfo = $this->mymodel->get('quiz', true, 'quizId', $quizId);
		
		if($quizInfo)
		{
			$mydata = array(
				'chapterId' =>$quizInfo->chapterId,
				'lessonId' =>$quizInfo->lessonId,
				'quizName' => $quizInfo->quizName,
				'quizNumber' => $quizInfo->quizNumber,
				'instructions' => $quizInfo->instructions,
				'status'=> '0',
				'created'=> date('Y-m-d H:i:s'),	
			);

			if (!$this->mymodel->save('quiz', $mydata)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Quiz cloned successfully", "success", "#A5DC86"]';
			}

			echo $msg;
			
		}		
	}

	public function changeQuizStatus()
	{
		if ($this->input->post('quizId'))
		 {
			$quizId = $this->input->post('quizId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Activated successfully!';
			} else {
				$msg = 'Deactivated successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'quiz', ['quizId'=>$quizId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function deleteQuiz($quizId = false)
	{
		$redirectto = $this->input->get('redirectto');
		if ($quizId != false) 
		{
			$where = array('quizId' => $quizId);
			$data = $this->mymodel->get_by('quiz', true, $where);

			if (!$this->mymodel->delete('quiz', $where)) {				
				$msg = 'error';
			} else {				
				
				$msg = '["Quiz deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}

		redirect($redirectto,'refresh');
	}



	public function addQuestion()
	{
		$data = array(
			'title' => 'Add Question',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
		$totalSegment = count($this->uri->segment_array());
		if(!empty($totalSegment) && $totalSegment ===5){
			$data['subjectId'] = $this->uri->segment(4);
			$data['testId'] = $this->uri->segment(5);
		}else{
			$data['subjectId'] = $this->uri->segment(4);
			$data['chapterId'] = $this->uri->segment(5);
			$data['lessonId'] = $this->uri->segment(6);
			$data['testId'] = $this->uri->segment(7);	
		}
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/question_add', $data);
		$this->load->view('admin/footer');

	}

	public function createQuestion()
	{
		 $subjectId=$this->input->post('subjectId');
		 $chapterId=$this->input->post('chapterId'); 
		 $lessonId=$this->input->post('lessonId');  
		 $testId=$this->input->post('testId'); 

		 $mydata = array();

		 if ($_FILES['questionImg']['name'] != '') 
		 {
		 	
		 	$config['upload_path'] = './uploads/questions/';
		 	$config['allowed_types'] = 'gif|jpg|jpeg|png';
		 	$config['max_size'] = '20480';
		 	
		 	$this->load->library('upload', $config);
		 	
		 	if ( ! $this->upload->do_upload('questionImg')){
		 		
		 		$error = strip_tags($this->upload->display_errors());
		 		$msg = '["'.$error.'", "error", "#DD6B55"]';
		 		
		 	} else {

		 		$data = $this->upload->data();
		 		$mydata['image'] = $data['file_name'];
		 	}
		 }
		 
		 $mydata['question'] = $this->testInput($this->input->post('question'));
		 $mydata['testId'] = $this->testInput($this->input->post('testId')); 
		 $mydata['subjectId'] = $this->testInput($this->input->post('subjectId'));
		 $mydata['created'] = date('Y-m-d H:i:s');
		 $mydata['status'] = 1;
		 

		 if ($this->mymodel->insert('questions', $mydata)) 
		 {
		 		$quesId = $this->db->insert_id();				
	  			$answers = array();				
	  			$correctans= $this->input->post('correctans');
	  			$i = 0;				
	  			
	  			foreach ($this->input->post('answer') as $key => $v) 
	  			{

	  				if($v==$correctans)
	  				{
	  					$correct=1;

	  				}else
	  				{
	  					$correct=0;
	  				}

	  				$temp = [
	  					'optionText' => $v,
	  					'quesId' => $quesId,
	  					'correctAns' => $correct,
	  				];
	  				array_push($answers, $temp);
	  				$i++;
	  			}

	  			if (count($answers) > 0) 
	  			{
	  				if ($this->db->insert_batch('questions_options', $answers)) 
	  				{

	  					$msg = '["New question added!", "success", "#A5DC86"]';

	  				} else {

	  					$msg = 'error';
	  				}

	  			}

		 }else{
		 	$msg = 'error';
		 }

		 $this->session->set_flashdata('msg', $msg);

		 redirect(admin_url('subject/viewTest/'.$subjectId.'/'.$chapterId.'/'.$lessonId.'/'.$testId),'refresh');
	}

	public function viewQuestion()
	{
		$subjectId = $this->uri->segment(4);
		$chapterId = $this->uri->segment(5);
		$lessonId = $this->uri->segment(6);
		$testId = $this->uri->segment(7);
		$quesId = $this->uri->segment(8);

		if ($quesId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Question',
			'page' => 'subjects',
			'subpage' => 'subjectlist'
		);
		
		$data['data'] = $this->mymodel->get('questions', true, 'quesId', $quesId);
		$data['ans_option'] = $this->mymodel->get('questions_options', false, 'quesId', $quesId);
		$data['subjectId'] = $subjectId;
		$data['chapterId'] = $chapterId;
		$data['lessonId'] = $lessonId;
		$data['testId'] = $testId;
		$data['quesId'] = $quesId;

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/question_view');
		$this->load->view('admin/footer');

	}


}
