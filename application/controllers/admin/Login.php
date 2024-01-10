<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {

	public function __construct()
    {

		parent::__construct();

		$this->load->model('mymodel');

	}

	public function index()

	{

		if ($this->session->has_userdata('userId') && $this->session->has_userdata('admin')):

			redirect(admin_url('dashboard'),'refresh');

		endif;

		$data = array('page' => 'login');

		if ($this->input->post('username')) {

			$this->form_validation->set_rules('username', 'Email', 'trim|required');

			$this->form_validation->set_rules('password', 'Password', 'trim|required');

			if ($this->form_validation->run() == false) {

				$msg = '';

				if (form_error('username')) {

					$msg .= strip_tags(form_error('username'));

				}

				if (form_error('password')) {

					$msg .= strip_tags(form_error('password'));

				}

				$data['msg'] = '<div class="alert alert-danger alert-dismissable">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					<strong>

						<i class="fa fa-check-circle-o"></i>

					</strong>

					'.$msg.'

				</div>';

			} else {

				$username = $this->input->post('username');

				$password = $this->input->post('password');

				$data['msg'] = '<div class="alert alert-danger alert-dismissable">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					<strong>

						<i class="fa fa-check-circle-o"></i>

					</strong>

					'.$this->usermodel->login($username, $password).'

				</div>';

				if ($this->session->has_userdata('userId') && $this->session->has_userdata('admin')) {

					if ($this->input->get('redirectto')) {

						redirect(urldecode($this->input->get('redirectto')),'refresh');

					} else {

						redirect(admin_url('dashboard'),'refresh');

					}

				}				

			}

		}

		if ($this->session->flashdata('msg')) {

			$data['msg'] = $this->session->flashdata('msg');
		}

		$data['settings'] = $this->mymodel->get('settings', true, 'settingId', '1');

		$this->load->view('admin/login', $data);

	}

	public function logout()

	{

		$this->session->unset_userdata('userId');

		$this->session->unset_userdata('admin');

		$msg = '<div class="alert alert-success alert-dismissable">

					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>

					<strong>

						<i class="fa fa-check-circle-o"></i>

					</strong>

					You have successfully logout!

				</div>';

		$this->session->set_flashdata('msg', $msg);

		redirect(admin_url('login'),'refresh');

	}

}