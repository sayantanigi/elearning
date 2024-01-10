<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Enquiry extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function lists()
	{
		$data = array(
			'title' => 'Send Notification',
			'page' => 'enquiry',
			'subpage' => ''
		);
		$data['list'] = $this->mymodel->get('inbox');
		$data['installerlist'] =$this->mymodel->get_by('users', false, "userType=2", null, null, 'userId');
		$data['customerlist'] =$this->mymodel->get_by('users', false, "userType=1", null, null, 'userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/enquiry_list');
		$this->load->view('admin/footer');
	}

	public function sendEmail()
	{
		print_r($_POST);



	}

}