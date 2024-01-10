<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newsletter extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function lists()
	{
		$data = array(
			'title' => 'List of Newsletter ',
			'page' => 'newsletter',
			'subpage' => ''
		);
		$data['list'] = $this->mymodel->get('newsletter');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/newsletter_list');
		$this->load->view('admin/footer');
	}


	public function view()
	{
		if ($this->input->post('enquiryId')) {
			$enquiryId = $this->input->post('enquiryId');
			$where = array('enquiryId' => $enquiryId);
			if ($this->mymodel->count('enquiries', $where) > 0) {
				$data['data'] = $this->mymodel->get('enquiries', true, 'enquiryId', $enquiryId);
				$this->load->view('admin/enquiry_view', $data, FALSE);
			} else {
				echo 'noEnquiry';
			}

		} else {
			echo '';
		}
	}


	public function changeStatus()
	{
		if ($this->input->post('enquiryId')) {
			$enquiryId = $this->input->post('enquiryId');
			$status = $this->input->post('status');
			if ($status == 1) {
				$msg = 'Enquiry marked as Replied!';
			} else {
				$msg = 'Enquiry marked as Pending!';
			}
			if ($this->mymodel->update(['status'=>$status], 'enquiries', ['enquiryId'=>$enquiryId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		} else {
			echo '';
		}
	}
	public function delete($id = false)
	{
		if ($id != false) {

			$where = array('newsletterId' => $id);
			$data = $this->mymodel->get_by('newsletter', true, $where);

			if (!$this->mymodel->delete('newsletter', $where)) {
				
				$msg = 'error';

			} else {
				
				$msg = '["Subscribed User deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('newsletter/lists'),'refresh');
	}


}

	/* End of file Newsletter.php */
/* Location: ./application/controllers/Newsletter.php */