<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function lists()
	{
		$data = array(
			'title' => 'List of CMS',
			'page' => 'cms',
			'subpage' => 'list'
		);
		$data['list'] = $this->mymodel->select('pageId, pageTitle, modified', 'cms');

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/cms_list');
		$this->load->view('admin/footer');
	}


	public function edit($pageId = false)
	{
		if ($pageId == false) {
			show_404();
		} elseif ($this->mymodel->count('cms', ['pageId'=>$pageId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit CMS',
				'page' => 'cms',
				'subpage' => 'list'
			);
			$data['data'] = $this->mymodel->get('cms', true, 'pageId', $pageId);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/cms_edit');
			$this->load->view('admin/footer');
		}
	}


	public function update()
	{
		if ($this->input->post('pageTitle') && $this->input->post('pageId') && $this->input->post('pageText')) 
		{
			$pageId = $this->input->post('pageId');
			$where = array('pageId'=>$pageId);
			$mydata = array(
				'pageTitle' => $this->testInput($this->input->post('pageTitle')),
				'pageText' => $this->testInput($this->input->post('pageText')),
				'content' => $this->testInput($this->input->post('content'))
			);
			if (!$this->mymodel->update($mydata, 'cms', $where)) {
				$msg = 'error';
			} else {
				$msg = '["Data saved successfully!", "success", "#A5DC86"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('cms/edit/'.$pageId),'refresh');
		} else {
			show_404();
		}
	}

	public function homeList()
	{
		$data = array(
			'title' => 'List of How it works',
			'page' => 'cms',
			'subpage' => 'homelist'
		);
		$data['list'] = $this->mymodel->get('home_how_it_works',false);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/how_it_works_list');
		$this->load->view('admin/footer');
	}

	public function editHome($id = false)
	{
		if ($id == false) {
			show_404();
		} elseif ($this->mymodel->count('home_how_it_works', ['id'=>$id]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit How it works',
				'page' => 'cms',
				'subpage' => 'homelist'
			);
			$data['data'] = $this->mymodel->get('home_how_it_works', true, 'id', $id);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/home_cms_edit');
			$this->load->view('admin/footer');
		}
	}

	public function updateHome()
	{
		if ($this->input->post('title') && $this->input->post('id')) 
		{
			$id = $this->input->post('id');
			$oldImage = $this->input->post('oldBannerImage');
			
			$where = array('id'=>$id);
			
			$mydata = array(
				'title' => $this->testInput($this->input->post('title')),
				'shortDesc' => $this->input->post('shortDesc')
			);

			if ($_FILES['bannerImage']['name'] != '') 
			{
			
				$config['upload_path'] = './uploads/home/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '2024';
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('bannerImage')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['icon'] = $data['file_name'];
				}
			}
			
			if (!$this->mymodel->update($mydata, 'home_how_it_works', $where)) {
				$msg = 'error';
			} else {

				if($oldImage && $_FILES['bannerImage']['name'] != '') 
				{
						if (file_exists('./uploads/home/'.$oldImage)) 
						{
							@unlink('./uploads/home/'.$oldImage);
						}
					}
				$msg = '["Updated successfully!", "success", "#A5DC86"]';
			}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('cms/homeList'),'refresh');
		} else {
			show_404();
		}
	}

}