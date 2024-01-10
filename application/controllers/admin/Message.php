<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Message extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function index()
	{
		$data = array(
			'title' => 'inbox',
			'page' => 'message',
			'subpage' => 'inbox'
		);
		
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/message');
		$this->load->view('admin/footer');
	}


	public function create()
	{
		if ($this->input->post('packageName') && $this->input->post('price')) {

			$mydata = array(
				'packageName' => $this->testInput($this->input->post('packageName')),
				'price' => $this->testInput($this->input->post('price')),
				'packageDescription' => $this->testInput($this->input->post('packageDescription')),
				'type' => $this->testInput($this->input->post('type')),
				'currency' => $this->testInput($this->input->post('currency')),
				'currencySymbol'=>$this->mymodel->get_currency_symbol($this->input->post('currency')),
				'packageStatus' => 1,
			);
			if (!$this->mymodel->save('packages', $mydata)) {
				$msg = 'error';
			} else {
				$msg = '["New package added successfully!", "success", "#A5DC86"]';
			}
			
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('package/lists'),'refresh');
		} else {
			show_404();
		}
	}


	public function lists()
	{
		$data = array(
			'title' => 'List of Packages',
			'page' => 'package',
			'subpage' => 'packagelist'
		);

		$data['list'] =$this->mymodel->get('packages', false, null, null, null, 'packageId');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/package_list');
		$this->load->view('admin/footer');
	}


	public function edit($packageId = false)
	{
		if ($packageId == false) {
			show_404();
		} elseif ($this->mymodel->count('packages', ['packageId'=>$packageId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit Package',
				'page' => 'package',
				'subpage' => 'packagelist'
			);
			
			$where = array(
				'packageId' => $packageId,
			);
			$data['data'] = $this->mymodel->get_by('packages', true, $where);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/package_edit');
			$this->load->view('admin/footer');
		}
	}


	public function update()
	{
		if ($this->input->post('packageName') && $this->input->post('packageId')) {
			$packageId = $this->input->post('packageId');
			$where = array('packageId'=>$packageId);
			$mydata = array(
				'packageName' => $this->testInput($this->input->post('packageName')),
				'price' => $this->testInput($this->input->post('price')),
				'packageDescription' => $this->testInput($this->input->post('packageDescription')),
				'type' => $this->testInput($this->input->post('type')),
				'currency' => $this->testInput($this->input->post('currency')),
				'currencySymbol'=>$this->mymodel->get_currency_symbol($this->input->post('currency')),
				'packageStatus' => $this->input->post('packageStatus')
			);
			
			if (!$this->mymodel->update($mydata, 'packages', $where)) {
				$msg = 'error';
			} else {
				$msg = '["Packages updated successfully!", "success", "#A5DC86"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('package/edit/'.$packageId),'refresh');
		}
		redirect(admin_url('package/lists'),'refresh');
	}


	public function changeStatus()
	{
		if ($this->input->post('packageId')) {
			$packageId = $this->input->post('packageId');
			$status = $this->input->post('status');
			if ($status == 1) {
				$msg = 'Activated successfully!';
			} else {
				$msg = 'Deactivated successfully!';
			}
			if ($this->mymodel->update(['packageStatus'=>$status], 'packages', ['packageId'=>$packageId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function view($packageId = false)
	{
		if ($packageId == false) {
			show_404();
		} elseif ($this->mymodel->count('packages', ['packageId'=>$packageId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'View Package Details',
				'page' => 'package',
				'subpage' => 'packagelist'
			);
			$data['data'] = $this->mymodel->get('packages', true, 'packageId', $packageId);	

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/package_view');
			$this->load->view('admin/footer');
		}
	}
	

}