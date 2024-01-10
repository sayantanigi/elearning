<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function add()
	{
		$data = array(
			'title' => 'Add New User',
			'page' => 'users',
			'subpage' => 'useradd'
		);
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/user_add');
		$this->load->view('admin/footer');
	}


	public function create()
	{
		if ($this->input->post('email') && $this->input->post('mobile')) {

			$mydata = array(
				'firstName' => $this->testInput($this->input->post('firstName')),
				'lastName' => $this->testInput($this->input->post('lastName')),
				'email' => $this->testInput($this->input->post('email')),
				'mobile' => $this->testInput($this->input->post('mobile')),
				'password' => $this->enc_password($this->input->post('password')),
				'userType' => $this->testInput($this->input->post('userType')),
				'status' => 1,
				'created'=>date('Y-m-d H:i:s'),		
				'verificationStatus' => 1,
			);
			$msg = $this->usermodel->addNewUser($mydata);
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('users/lists'),'refresh');
		} else {
			show_404();
		}
	}


	public function lists()
	{
		$data = array(
			'title' => 'List of Users',
			'page' => 'users',
			'subpage' => 'userlist'
		);
		$data['list'] =$this->mymodel->get('users', false, null, null, null, 'userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/user_list');
		$this->load->view('admin/footer');
	}


	public function edit($userId = false)
	{
		if ($userId == false) {
			show_404();
		} elseif ($this->mymodel->count('users', ['userId'=>$userId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit User Profile',
				'page' => 'users',
				'subpage' => 'userlist'
			);
			
			$where = array(
				'userId' => $userId,
			);
			$data['data'] = $this->mymodel->get_by('users', true, $where);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/user_edit');
			$this->load->view('admin/footer');
		}
	}


	public function update()
	{
		if ($this->input->post('email') && $this->input->post('userId')) {
			$userId = $this->input->post('userId');
			$where = array('userId'=>$userId);
			$mydata = array(
				'firstName' => $this->testInput($this->input->post('firstName')),
				'lastName' => $this->testInput($this->input->post('lastName')),
				'email' => $this->testInput($this->input->post('email')),
				'mobile' => $this->testInput($this->input->post('mobile')),
				'userType' => $this->testInput($this->input->post('userType')),
				'status' => $this->input->post('status')
			);
			if ($this->input->post('password') && $this->input->post('password') != '') {
				$mydata['password'] = $this->enc_password($this->input->post('password'));
			}
			if (!$this->mymodel->update($mydata, 'users', $where)) {
				$msg = 'error';
			} else {
				$msg = '["User profile updated successfully!", "success", "#A5DC86"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('users/edit/'.$userId),'refresh');
		}
		redirect(admin_url('users/lists'),'refresh');
	}


	public function changeStatus()
	{
		if ($this->input->post('userId')) {
			$userId = $this->input->post('userId');
			$status = $this->input->post('status');
			if ($status == 1) {
				$msg = 'User account activated successfully!';
			} else {
				$msg = 'User account deactivated successfully!';
			}
			if ($this->mymodel->update(['status'=>$status], 'users', ['userId'=>$userId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}


	public function export_csv() {
        $this->load->helper('csv');
        $export_arr = array();
        $studentDetails = $this->usermodel->exporTuserData();
        $title = array("SI. No.", "Name","Account Type", "Email", "Phone","Status", "join Date");
        array_push($export_arr, $title);
        if (!empty($studentDetails)){
            foreach ($studentDetails as $student) {
            	if($student->userType =='1'){
						$studetType = "Student";
				} else {
					    $studetType = "Guardian";
				} 

				if($student->status ==1){
					$status = "Active";
				}else{
					$status = "deactivat";
				}
				if(!empty($student->created)){
					$date = strtotime($student->created);
				$joineDate = date('d-M-y h:i:s A',$date);
				} 
                array_push($export_arr, array($student->userId, $student->firstName.' '.$student->lastName,$studetType, $student->email, $student->mobile,$status,$joineDate));
            }
        }
        convert_to_csv($export_arr, 'student-' . date('F d Y') . '.csv', ',');
    }


	public function delete($userId=false){
	     if($userId == false) 
		 {
			show_404();
			exit();
		 }
		   if(!empty($userId)){
		   	  		$profilePic = $this->usermodel->getRow($userId);
					if(!empty($profilePic) && $profilePic != '' && !is_null($profilePic) && file_exists('./uploads/logos/'.$profilePic)) {
						@unlink('./uploads/users/'.$profilePic);
				    }
			   		$action = $this->usermodel->useRdelete($userId);
			   		if($action == 1){
				   		    $success = "Delete User details successfully !";
				        	$msg = '["'.$success.'", "success", "#A5DC86"]';
							$this->session->set_flashdata('msg', $msg);
				   		    redirect(admin_url('users/lists'));
			   		}else{
	                     	$error = "User details Not Delete !";
				        	$msg = '["'.$error.'", "error", "#DD6B55"]';
							$this->session->set_flashdata('msg', $msg);
	                     	$this->lists();
			   		}
		   }else{
		   		        $error = " User details successfully Not Delete !";
			        	$msg = '["'.$error.'", "error", "#DD6B55"]';
						$this->session->set_flashdata('msg', $msg);
                     	$this->lists();
		   }
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/Users.php */