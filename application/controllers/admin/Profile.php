<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Profile extends MY_Controller {


	public function __construct()

	{

		parent::__construct();

		$this->loggedIn();

	}

	public function index()

	{

		$data = array(

			'title' => 'Profile',
            'page' => 'profile',
			'subpage' => 'editprofile'
		);

		$data['userId'] = $userId = $this->session->userdata('userId');

		$data['data'] = $this->mymodel->get('admin', true, 'userId', $userId);


		$this->load->view('admin/header', $data);

		$this->load->view('admin/sidebar');

		$this->load->view('admin/profile');

		$this->load->view('admin/footer');

	}


	public function save()

	{

		$userId = $this->session->userdata('userId');



		if ($this->input->post('name')) {



			$mydata = array(

				'name' => $this->testInput($this->input->post('name')),

				'email' => $this->testInput($this->input->post('email'))

			);



			if (!$this->mymodel->update($mydata, 'admin', ['userId'=>$userId])) {

				$msg = 'error';

			} else {

				$msg = '["Profile updated successfully.", "success", "#A5DC86"]';

			}

			$this->session->set_flashdata('msg', $msg);

		}

		redirect(admin_url('profile'),'refresh');

	}





	public function check_store_name()

	{

		if ($this->input->post('storeName')) {

			$storeName = $this->testInput($this->input->post('storeName'));

			if ($this->mymodel->count('users', ['store_name'=>$storeName]) > 0) {

				echo 'This Store Name is already taken!';

			} else {

				echo '';

			}

		}

	}



}



/* End of file Profile.php */

/* Location: ./application/controllers/Profile.php */