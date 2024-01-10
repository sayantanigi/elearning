<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
	}


	public function site_settings()
	{
		$data = array(
			'title' => 'Site Settings',
			'page' => 'settings',
			'subpage' => 'site_settings'
		);

		$userId = $this->session->userdata('userId');
		$data['admin'] = $this->db->select('userId,username,')->get_where('admin',array('userId'=>$userId))->row();
		$data['data'] = $this->mymodel->get('settings', true, 'settingId', 1);
		$this->load->view('admin/header', $data, FALSE);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/site-settings');
		$this->load->view('admin/footer');
	}


	public function save()
	{
		if ($this->input->post('settings')) {

			$mydata = array(
				'company' => $this->testInput($this->input->post('company')),
				'address' => $this->testInput($this->input->post('address')),
				'email' => $this->lc($this->input->post('email')),
				'phone' => $this->testInput($this->input->post('phone')),
				'facebook' => $this->testInput($this->input->post('facebook')),
				'twitter' => $this->testInput($this->input->post('twitter')),
				'linkedin' => $this->testInput($this->input->post('linkedin')),
				'instagram' => $this->testInput($this->input->post('instagram'))
			);
			$where = array('settingId' => '1');
			if (!$this->mymodel->update($mydata, 'settings', $where)) 
			{
				$msg = 'error';
			} else {
				$msg = '["Setting saved successfully!", "success", "#A5DC86"]';
			}
			$this->session->set_flashdata('msg', $msg);
		}
		redirect(admin_url('settings/site_settings'),'refresh');
	}


	

	public function logo()
	{
		$data = array(
			'title' => 'Logo Settings',
			'page' => 'settings',
			'subpage' => 'logo_settings'
		);
		$data['data'] = $this->mymodel->get('settings', true, 'settingId', 1);
		$this->load->view('admin/header', $data, FALSE);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/logo-settings');
		$this->load->view('admin/footer');
	}



	public function companyImage(){
		if (empty($_FILES['fileupload']['name']))
		{
			$this->form_validation->set_rules('logo_image', 'Company Logo', 'required');
			echo "Please select Company logo";
		}else{
			$config['upload_path'] = './uploads/logos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size'] = '10096';
			$this->load->library('upload', $config);
			
			if($this->upload->do_upload("fileupload")){
				$data = array('fileupload' => $this->upload->data());
				$image= $data['fileupload']['file_name']; 
				$mydata = array(
				'logo'=>$image,				
			);
			$this->mymodel->update($mydata, "settings", "settingId=1");
			}			

			$this->session->set_flashdata('success', 'Updated successfully');
			echo "Updated successfully";
			redirect('user','refresh');
		}

	}


	public function removeLogo(){

		        $query =  $this->db->select('logo')->get_where('settings',array('settingId' => 1));
			    if( $query->num_rows() > 0 )
				    {
				        $row = $query->row();
				        $picture = $row->logo;
				        $s =  @unlink('./uploads/logo/'.@$picture);
				        $logo['logo'] = '';
				        $this->db->update('settings',$logo, array('settingId' => 1));
				        $msg = '[" Logo Delete Successfully!", "success", "#A5DC86"]';
				        redirect(admin_url('settings/site_settings'));
				    }

			   $msg = '["Logo Delete Successfully!", "error", "#DD6B55"]';
		       redirect(admin_url('settings/site_settings'));
	}

	public function logosave()
	{
		if ($this->input->post('logo_settings')) {

			$mydata = array();
			$where = array('settingId' => '1');

			if ($_FILES['logo']['name']!='' && $this->input->post('oldLogo')) {

				$config['upload_path'] = './uploads/logos/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '4096';

				$this->load->library('upload');
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('logo')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$logoArray = $this->upload->data();
					$oldLogo = $this->input->post('oldLogo');
					$mydata['logo'] = $logoArray['file_name'];
				}
			}
			if ($_FILES['favicon']['name']!='' && $this->input->post('oldFavicon')) {
				$config['upload_path'] = './uploads/logos/';
				$config['allowed_types'] = 'jpeg|jpg|png';
				$config['max_size']  = '4096';

				$this->load->library('upload');
				$this->upload->initialize($config);

				if ( ! $this->upload->do_upload('favicon')){
					$error = strip_tags($this->upload->display_errors());
				} else {
					$faviconArray = $this->upload->data();
					$oldFavicon = $this->input->post('oldFavicon');
					$mydata['favicon'] = $faviconArray['file_name'];
				}
			}
			$mydata['title'] =  $this->input->post('title');
			if (count($mydata) > 0) {
				if (!$this->mymodel->update($mydata, 'settings', $where)) {
					$msg = 'error';
				} else {
					if (!empty($oldLogo) && $oldLogo != '' && !is_null($oldLogo) && file_exists('./uploads/logos/'.$oldLogo)) {
						@unlink('./uploads/logos/'.$oldLogo);
					}
					if (!empty($oldFavicon) && $oldFavicon != '' && !is_null($oldFavicon) && file_exists('./uploads/logos/'.$oldFavicon)) {
						@unlink('./uploads/logos/'.$oldFavicon);
					}
					if (!empty($oldTitle) && $oldTitle != '' && !is_null($oldTitle) && file_exists('./uploads/logos/'.$oldTitle)) {
						@unlink('./uploads/logos/'.$oldTitle);
					}
					$msg = '["Settings saved successfully!", "success", "#A5DC86"]';
				}
				$this->session->set_flashdata('msg', $msg);
			} elseif (!empty($error)) {
				$msg = '["'.$error.'", "error", "#DD6B55"]';
			}
		}
		redirect(admin_url('settings/logo'),'refresh');
	}


	public function notificationsStatus(){
			$where['settingId'] = 1;

			if($_POST['member'] ==='mem_sub'){
				$mydata['member_subscription'] = $_POST['mem_val'];
				
			}elseif ($_POST['member'] ==='mem_active') {
				$mydata['member_activity'] = $_POST['mem_val'];
			}elseif ($_POST['member'] === 'mem_report') {
				$mydata['weekly_report'] = $_POST['mem_val'];
			}

			$this->mymodel->update($mydata,'settings',$where);
	}

  public function change_password($userId){
  		   $oldpass =  $this->input->post('current_password');
		   $old_pass = $this->db->select('password')->get_where('admin',array('userId' => $userId))->row();
        if (password_verify($oldpass, $old_pass->password) == 0) {
		        $error = "Current Password No Matches!Please enter the same value again.";
	        	$msg = '["'.$error.'", "error", "#DD6B55"]';
				$this->session->set_flashdata('msg', $msg);
	            $this->site_settings();
			}else {
			  		$this->form_validation->set_rules('email', 'Email Id', 'required');
			  		$this->form_validation->set_rules('current_password', 'Current Password', 'required');
					$this->form_validation->set_rules('new_passord', 'Password', 'required');
					$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'required|matches[new_passord]');
					
					if($this->form_validation->run() == true){
						$user_id['userId'] = $userId;
				        $data['password'] =$this->enc_password($this->input->post('confirm_password'));

				        $this->mymodel->update($data,'admin',$user_id);
				        $msg = '["Password Successfully Updated!", "success", "#DD6B55"]';
						$this->session->set_flashdata('msg', $msg);
				        redirect(admin_url('settings/site_settings')); 
		        }else{
			        	$error = "You have entered wrong password.";
			        	$msg = '["'.$error.'", "warning", "#DD6B55"]';
						$this->session->set_flashdata('msg', $msg);
			            $this->site_settings();
		        }
       }
  }

}