<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends My_Controller
{

	public function __construct()
    {
    	parent::__construct();
    	$this->load->model('Commonmodel');
    	$this->load->helper('form');
		$this->load->helper(array('url','front_helper'));
		$this->load->library("pagination");        
    }
    
	public function index()
	{
		$data['title'] = "Home";

		$data['cmsContent'] = $this->mymodel->get('cms', false, 'page_slug', 'home');

		$sql_count_course = "SELECT Count(cl.crsLvlId) as courseCount FROM course_level_details cl";
		$data['courseData'] = $this->mymodel->fetch($sql_count_course, true);

		/*$sql_count_course = "SELECT Count(u.userId) as insCount FROM users u WHERE u.userType = '2'";
		$data['insData'] = $this->mymodel->fetch($sql_count_course, true);*/

		$sql_fetch_ins = "SELECT u.* FROM users u WHERE u.userType = '2' AND u.approve_status = '1'";
		$data['insData'] = $this->mymodel->fetch($sql_fetch_ins, false);
		
		$sql_course_list = "SELECT c.*,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE c.status = '1' AND c.approve_status = 'approved' AND cl.status = '1' GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC LIMIT 0,10";  
		//echo $sql_course_list;exit;

		$data['courseList'] = $this->mymodel->fetch($sql_course_list, false);	

		$sql_purchased_course_list = "SELECT c.*,cl.level,(SELECT Count(DISTINCT spc.purchaseId) FROM course_level_details cl LEFT JOIN student_purchased_courses spc ON ( cl.courseId=spc.courseId AND cl.level=spc.courseLvl )) as purchaseCount,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) INNER JOIN chapters chp ON cc.chapterId=chp.chapterId WHERE c.status = '1' AND c.approve_status = 'approved' AND cl.status = '1' GROUP BY cl.crsLvlId HAVING purchaseCount>0 ORDER BY purchaseCount DESC LIMIT 0,10";  
		
		//echo $sql_purchased_course_list;exit;

		$data['purchasedCourse'] = $this->mymodel->fetch($sql_purchased_course_list, false);	

		$sql_fetch_review = "SELECT cr.reviewId,cr.courseId,cr.courseLvl,cr.rating,cr.feedback,cr.status,cr.created,s.userId as studentId,CONCAT(s.firstName,' ',s.lastName) as studentName,s.profilePic as student_image,s.email,s.mobile,i.userId as instructorId,CONCAT(i.firstName,' ',i.lastName) as insName,i.mobile as insMobile,i.email as insEmail,c.courseName,c.image FROM course_review cr LEFT JOIN users s ON (cr.studentId=s.userId AND s.userType='1') LEFT JOIN courses c ON (cr.courseId=c.courseId ) LEFT JOIN users i ON ( cr.instructorId=i.userId AND i.userType = '2' ) WHERE cr.status='1' GROUP BY cr.reviewId ORDER BY cr.created DESC";  

        //echo $sql_fetch_review;exit;

	    //Feching Enrolled Course List 
	 	$data['courseReviewData'] = $this->mymodel->fetch($sql_fetch_review, false);

		$this->load->view('header', $data);
		$this->load->view('index');
		$this->load->view('footer');
	}

	public function courselist()
	{
		$data['title'] = "Course List";

		if(!empty($this->input->post('search_text'))){
			$search_text = $this->input->post('search_text');
            $where_clause = "WHERE c.courseName LIKE '%".$search_text."%' AND c.status = '1' AND cl.status = '1'"; 

            $data['search_text'] = $search_text;
		}else{
			$where_clause = "WHERE c.status = '1' AND cl.status = '1'"; 
			$data['search_text'] = null;
		}
		
		$sql_course_list = "SELECT c.*,cl.level,cl.image as level_image,Count(DISTINCT cc.chapterId) as totalChapter,SUM(chp.totalHours) as totalHours, SUM(chp.cost) as lvlCost FROM course_level_details cl LEFT JOIN courses c ON ( cl.courseId=c.courseId ) LEFT JOIN course_chapters cc ON ( cl.courseId = cc.courseId AND cl.level = cc.level ) LEFT JOIN chapters chp ON cc.chapterId=chp.chapterId ".$where_clause." GROUP BY cl.crsLvlId ORDER BY cl.crsLvlId DESC";  
		//echo $sql_course_list;exit;

		$data['courseList'] = $this->mymodel->fetch($sql_course_list, false);	

		$this->load->view('header', $data);
		$this->load->view('courselist');
		$this->load->view('footer');
	}

	public function about()
	{
		$data['title'] = "Home";
		
		$data['cmsContent'] = $this->mymodel->get('cms', false, 'page_slug', 'about-us');

		$sql_count_course = "SELECT Count(cl.crsLvlId) as courseCount FROM course_level_details cl";
		$data['courseData'] = $this->mymodel->fetch($sql_count_course, true);

		$sql_fetch_ins = "SELECT u.* FROM users u WHERE u.userType = '2'";
		$data['insData'] = $this->mymodel->fetch($sql_fetch_ins, false);

		$sql_count_students = "SELECT Count(u.userId) as stuCount FROM users u WHERE u.userType = '1'";
		$data['stuData'] = $this->mymodel->fetch($sql_count_students, true);

		$this->load->view('header', $data);
		$this->load->view('about-us');
		$this->load->view('footer');
	}

	public function bloglist()
	{
		$data['title'] = "Blog Page";

		$sql = "SELECT b.* FROM blogs AS b  ORDER BY b.articleId  DESC";
		$data['list'] = $this->mymodel->fetch($sql);

		$this->load->view('header', $data);
		$this->load->view('blog_list');
		$this->load->view('footer');
	}

	public function blogdetail($articleId)
	{
		$data['title'] = "Blog Page";
		$data['blogDetail'] = $this->mymodel->get('blogs', true, 'articleId', $articleId);
		$this->load->view('header', $data);
		$this->load->view('blog_detail');
		$this->load->view('footer');
	}

	public function becomeInstructor()
	{
		$data['title'] = "Become a Instructor";

		$data['cmsContent'] = $this->mymodel->get('cms', false, 'page_slug', 'become-instructor');
		$this->load->view('header', $data);
		$this->load->view('become_instructor');
		$this->load->view('footer');
	}

	public function faqlist()
	{
		$data['title'] = "FAQ Page";
		$this->load->view('header', $data);
		$this->load->view('term');
		$this->load->view('footer');
	}

	public function terms()
	{
		$data['title'] = "Terms & Conditions";
		$this->load->view('header', $data);
		$this->load->view('term');
		$this->load->view('footer');
	}

	public function policy()
	{
		$data['title'] = "Privacy Policy";
		$this->load->view('header', $data);
		$this->load->view('policy');
		$this->load->view('footer');
	}
	
}
