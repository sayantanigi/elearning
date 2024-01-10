<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function index()
	{
		$data = array(
			'title' => 'Dashboard',
			'page' => 'dashboard',
			'subpage' => ''
		);

		$data['users']=$this->mymodel->count('users', "userType=0");
		$data['guds']=$this->mymodel->count('users', "userType=1");
		// $data['clients']=$this->mymodel->count('category');
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/dashboard');
		$this->load->view('admin/footer');
	}

}