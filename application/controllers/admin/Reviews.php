<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviews extends MY_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function list()
	{
		$data = array(
			'title' => 'Reviews Data',
			'page' => 'reviewlist',
			'subpage' => null
        );

        $sql_fetch_review = "SELECT cr.reviewId,cr.courseId,cr.courseLvl,cr.rating,cr.feedback,cr.status,cr.created,s.userId as studentId,CONCAT(s.firstName,' ',s.lastName) as studentName,s.email,s.mobile,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as insName,i.mobile as insMobile,i.email as insEmail,c.courseName,c.image FROM course_review cr LEFT JOIN users s ON (cr.studentId=s.userId AND s.userType='1') LEFT JOIN courses c ON (cr.courseId=c.courseId ) LEFT JOIN users i ON ( cr.instructorId=i.userId AND i.userType = '2' ) GROUP BY cr.reviewId ORDER BY cr.created DESC";  

        //echo $sql_fetch_review;exit;

	    //Feching Enrolled Course List 
	 	$data['courseReviewData'] = $this->mymodel->fetch($sql_fetch_review, false);
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reviews/review_list');
		$this->load->view('admin/footer');
	}

	public function changeStatus()
	{
		if ($this->input->post('reviewId'))
		 {
			$reviewId = $this->input->post('reviewId');
			$status = $this->input->post('status');
			
			if ($status == 1) 
			{
				$msg = 'Published successfully!';
			} else {
				$msg = 'Un Published successfully!';
			}

			if ($this->mymodel->update(['status'=>$status], 'course_review', ['reviewId'=>$reviewId])) 
			{
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function delete($reviewId = false)
	{
		if ($reviewId != false) {

			$where = array('reviewId' => $reviewId);

			if (!$this->mymodel->delete('course_review', $where)) {
				
				$msg = 'error';

			} else {
				
				$msg = '["Review deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('reviews/list'),'refresh');
	}
}