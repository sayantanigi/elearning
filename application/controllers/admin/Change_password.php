<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Change_password extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function index()
	{
		$data = array(
			'title' => 'Change Password'
		);
		$data['userId'] = $userId = $this->session->userdata('userId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/change_password');
		$this->load->view('admin/footer');
	}


	public function update()
	{
		$userId = $this->session->userdata('userId');

		if ($this->input->post('c_password')) {

			$this->form_validation->set_rules('c_password', 'Current Password', 'trim|required');
			$this->form_validation->set_rules('n_password_confirmation', 'New Password', 'trim|required');
			$this->form_validation->set_rules('n_password', 'Repeat Password', 'trim|required|matches[n_password_confirmation]');
			$msg = '';

			if ($this->form_validation->run() == false) {
				if (form_error('c_password')) {
					$msg .= strip_tags(form_error('c_password'));
				}
				if (form_error('n_password_confirmation')) {
					$msg .= strip_tags(form_error('n_password_confirmation'));
				}
				if (form_error('n_password')) {
					$msg .= strip_tags(form_error('n_password'));
				}
			} else {
				$c_password = $this->input->post('c_password');
				$n_password = $this->input->post('n_password');
				$user = $this->mymodel->get('admin', true, 'userId', $userId);

				if (! password_verify($c_password, $user->password)) {
					$msg = '["You have entered wrong password.", "warning", "#F29F06"]';
				} else {

					$mydata['password'] = $this->enc_password($n_password);

					if (!$this->mymodel->update($mydata, 'admin', ['userId'=>$userId])) {
						$msg = 'error';
					} else {
						$msg = '["Password changed successfully.", "success", "#A5DC86"]';
					}
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('change_password'),'refresh');
	}

}