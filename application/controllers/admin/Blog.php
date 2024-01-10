<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends MY_Controller 
{

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}

	public function add()
	{
		$data = array(
			'title' => 'Add New Blog',
			'page' => 'bloglist',
			'subpage' => 'blogadd'
        );
        
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/blog/blog_add');
		$this->load->view('admin/footer');
	}


	public function create()
	{
		if ($this->input->post('title') && $_FILES['thumbnail']['name'] != '') {

			$config['upload_path'] = './uploads/blogs/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '10240';
			$config['file_name'] = 'blog_'.rand(10,99).time();
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('thumbnail')){
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
		
			} else {
			
			$data = $this->upload->data();
			
			$mydata = array(
				'title' =>  $this->testInput($this->input->post('title')),
				'descriptions' => $this->testInput($this->input->post('descriptions')),
				'thumbnail' => $data['file_name'],
				'status' => 1,
				'created'=>date('Y-m-d H:i:s'),
            );
			if (!$this->mymodel->save('blogs', $mydata)) {
				$msg = 'error';
			} else {
				$msg = '["Blog added successfully!", "success", "#A5DC86"]';
			}
		}

			$this->session->set_flashdata('msg', $msg);
			redirect(admin_url('blog/lists'),'refresh');
		} else {
			show_404();
		}
	}


	public function lists()
	{
		$data = array(
			'title' => 'List of Blogs',
			'page' => 'blogs',
			'subpage' => 'bloglist'
        );
        $sql = "SELECT b.* FROM blogs AS b  ORDER BY b.articleId  DESC";
		$data['list'] = $this->mymodel->fetch($sql);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/blog/blog_list');
		$this->load->view('admin/footer');
	}


	public function edit($articleId = false)
	{
		if ($articleId == false) {
			show_404();
		} elseif ($this->mymodel->count('blogs', ['articleId'=>$articleId]) != 1) {
			show_404();
		} else {
			$data = array(
				'title' => 'Edit Blog',
				'page' => 'blog',
				'subpage' => 'bloglist'
            );
			$data['data'] = $this->mymodel->get('blogs', true, 'articleId', $articleId);

			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/blog/blog_edit');
			$this->load->view('admin/footer');
		}
	}


    public function update()
    {
        if ($this->input->post('title') && $this->input->post('articleId')) {

			$where = array('articleId' => $this->input->post('articleId'));
			$oldThumbnail = $this->input->post('oldThumbnail');
			
			$mydata = array(
				'title' =>  $this->testInput($this->input->post('title')),
				'descriptions' => $this->testInput($this->input->post('descriptions')),
			);

			if ($_FILES['thumbnail']['name'] != '') {
			
				$config['upload_path'] = './uploads/blogs/';
				$config['allowed_types'] = 'gif|jpg|jpeg|png';
				$config['max_size'] = '10240';
				$config['file_name'] = 'blog_'.rand(10,99).time();
				
				$this->load->library('upload', $config);
				
				if ( ! $this->upload->do_upload('thumbnail')){
					
					$error = strip_tags($this->upload->display_errors());
					$msg = '["'.$error.'", "error", "#DD6B55"]';
			
				} else {

					$data = $this->upload->data();
					$mydata['thumbnail'] = $data['file_name'];
				}
			}

			if (empty($error)) {
				
				if (!$this->mymodel->update($mydata, 'blogs', $where)) {
					
					$msg = 'error';

				} else {

					if ($oldThumbnail && $_FILES['thumbnail']['name'] != '') {
						if (file_exists('./uploads/blogs/'.$oldThumbnail)) {
							@unlink('./uploads/blogs/'.$oldThumbnail);
						}
					}
					$msg = '["Article updated successfully", "success", "#A5DC86"]';
				}
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('blog/lists'),'refresh');
    }


	public function changeStatus()
	{
		if ($this->input->post('articleId')) 
		{
			$articleId = $this->input->post('articleId');
			$status = $this->input->post('status');
			if ($status == 1)
			{
				$msg = 'Blog activated successfully!';
			} else {
				$msg = 'Blog deactivated successfully!';
			}
			if ($this->mymodel->update(['status'=>$status], 'blogs', ['articleId'=>$articleId])) {
				echo '["'.$msg.'", "success", "#A5DC86"]';
			} else {
				echo '["Some error occured, Please try again!", "error", "#DD6B55"]';
			}
		}
	}

	public function view($articleId = false)
	{
		if ($articleId == false) {
			show_404();
			exit();
		}
		$data = array(
			'title' => 'View Blogs',
			'page' => 'blog',
			'subpage' => 'bloglist'
		);
		
		$data['data'] = $this->mymodel->get('blogs', true, 'articleId', $articleId);

		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/blog/blog_view');
		$this->load->view('admin/footer');
	}

	public function delete($articleId = false)
	{
		if ($articleId != false) {

			$where = array('articleId' => $articleId);
			$data = $this->mymodel->get_by('blogs', true, $where);

			if (!$this->mymodel->delete('blogs', $where)) {
				
				$msg = 'error';

			} else {
				
				if (@$data->thumbnail && file_exists('./uploads/blogs/'.@$data->thumbnail)) {
					@unlink('./uploads/blogs/'.@$data->thumbnail);
				}
				$msg = '["Blogs deleted successfully.", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('blog/lists'),'refresh');
	}

	
}