<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reason extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function lists()
	{
		$data = array(
			'title' => 'List of Reasons',
			'page' => 'reason',
			'subpage' => 'reasonlist'
		);

		$sql_fetch_reason = "SELECT * FROM reason r ORDER BY r.reasonId";
		$data['reasonList'] =  $this->mymodel->fetch($sql_fetch_reason,false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/reason/reason_list');
		$this->load->view('admin/footer');
	}

	public function add(){
			$data = array(
				'title' => 'Add New Reason',
				'page' => 'reason',
				'subpage' => 'reasonlist'
			);
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/reason/reason_add');
			$this->load->view('admin/footer');
	}

	public function create(){
		
		if ($this->input->post('reason')) {
			
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE){
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
			}else{
				$mydata = array(
					'reason' => $this->input->post('reason'),
					'status'   => $this->input->post('status'),
					'created'  => date('Y-m-d H:i:s A'),
				);
				if(!$this->mymodel->save('reason',$mydata)){
	               $msg = '["New Reason added Not successfully!", "error", "#A5DC86"]';
				}else{
				   $msg = '["New Reason added successfully!", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('instructors/instructor-change-reason'),'refresh');
		}else{
			show_404();
		}	
	}


	public function edit($reasonId=false){
			if($reasonId == false) 
			{
				show_404();
				exit();
			}
		    $data = array(
				'title' => 'Edit Reason',
				'page' => 'reason',
				'subpage' => 'reasonlist'
			);
			$data['reasonDetail'] = $this->mymodel->get('reason', true, 'reasonId', $reasonId);

			if(!empty($data['reasonDetail'])){
			    $this->load->view('admin/header', $data);
				$this->load->view('admin/sidebar');
				$this->load->view('admin/reason/reason_edit');
				$this->load->view('admin/footer');
			}else{
				show_404();
			    exit();
		    }
	}

	public function update($reasonId=false){
		if ($this->input->post('reason') && $this->input->post('reasonId')) {
			
			$this->form_validation->set_rules('reasonId', 'Reason ID', 'required');
			$this->form_validation->set_rules('reason', 'Reason', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			
			if($this->form_validation->run() == FALSE){
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
			}else{
				$where = array('reasonId' => $this->input->post('reasonId'));

				$mydata = array(
					'reason' => $this->input->post('reason'),
					'status'   => $this->input->post('status'),
				);
				if(!$this->mymodel->update($mydata, 'reason', $where)){
	               $msg = '["New Reason updated Not successfully!", "error", "#A5DC86"]';
				}else{
				   $msg = '["New Reason updated successfully!", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('instructors/instructor-change-reason'),'refresh');
		}else{
			show_404();
		}	
	}

	public function publish($reasonId){
        if (!empty('reasonId')) 
		{
			$status = 1;
			$msg = 'Reason published successfully!';
			
			if ($this->mymodel->update(['status'=>$status], 'reason', ['reasonId'=>$reasonId])) {
				$msg = '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				$msg = '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('instructors/instructor-change-reason'),'refresh');
		}else{
			show_404();
		}
    }

    public function unpublish($reasonId){
        if (!empty('reasonId')) 
		{
			$status = 0;
			$msg = 'Reason unpublished successfully!';
			
			if ($this->mymodel->update(['status'=>$status], 'reason', ['reasonId'=>$reasonId])) {
				$msg = '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				$msg = '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('instructors/instructor-change-reason'),'refresh');
		}else{
			show_404();
		}
    }

    public function delete($reasonId = false){
    	if($reasonId == false) 
			{
				show_404();
				exit();
			}

		  if(!empty($reasonId)){
		  	$data =  $this->mymodel->fqa_delete($reasonId);
		  	if($data ==1){
			$msg = '["Fqa Delete Successfully !", "success", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('reason/lists'),'refresh');
		  	}else{
		  	$msg = '["Fqa Delete Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('reason/lists'),'refresh');
		  	}
		  }else{
		  	$msg = '["Fqa Delete Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('reason/lists'),'refresh');
		  }
    }
	
}