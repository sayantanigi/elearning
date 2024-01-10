<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CMS extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function pages()
	{
		$data = array(
			'title' => 'List of Pages',
			'page' => 'cms',
			'subpage' => 'cmslist'
		);

		$sql = "SELECT count(pageId) as page_content_count,page_slug FROM `cms` GROUP by page_slug";
		$data['pageList'] = $this->mymodel->fetch($sql);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/cms/page_lists');
		$this->load->view('admin/footer');
	}

	public function lists($page_slug = null)
	{
		$data = array(
			'title' => 'List of CMS',
			'page' => 'cms',
			'subpage' => 'cmslist',
			'page_slug' => $page_slug
		);

		$sql = "SELECT * FROM cms WHERE page_slug = '$page_slug' ORDER BY created DESC";
		$data['list'] = $this->mymodel->fetch($sql);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/cms/cms_lists');
		$this->load->view('admin/footer');
	}

	public function edit($page_slug,$pageId)
	{
		if ($pageId == false) {
			show_404();
		} elseif ($this->mymodel->count('cms', ['pageId'=>$pageId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit CMS',
				'page' => 'cms',
				'subpage' => 'cmslist',
				'page_slug' => $page_slug
			);
			$data['data'] = $this->mymodel->get('cms', true, 'pageId', $pageId);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/cms/cms_edit');
			$this->load->view('admin/footer');
		}
	}


	public function update()
	{
		if ($this->input->post('cmsTitle') && $this->input->post('pageId'))
		{
			$pageId = $this->input->post('pageId');
			$page_slug = $this->input->post('page_slug');
			$oldImage = $this->input->post('hidden_file_name');
			$where = array('pageId' => $this->input->post('pageId'));

			$cmsData = array(
				'sectionTitle' =>$this->input->post('sectionTitle'),
				'cmsTitle' =>$this->input->post('cmsTitle'),
				'content' =>$this->input->post('content'),
				'link' =>$this->input->post('link'),
			);
			
			if (!empty($_FILES['image']['name'])) {
			
				$config['upload_path'] = './uploads/cms/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '10240';
				$config['file_name'] = 'cms_'.rand(999,99999).time();
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('image')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$cmsData['image'] = $data['file_name'];
				}
			}else{
				$cmsData['image'] = $this->input->post('hidden_file_name');
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($cmsData, 'cms', $where)) {
					$msg = 'error';
				} else {

					if ($oldImage && $_FILES['image']['name'] != '') {
						if (file_exists('./uploads/cms/'.$oldImage)) {
							@unlink('./uploads/cms/'.$oldImage);
						}
					}
					$msg = '["CMS updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);

			redirect(admin_url('cms/edit/'.$page_slug.'/'.$pageId),'refresh');
		} else {
			show_404();
		}
	}

}
