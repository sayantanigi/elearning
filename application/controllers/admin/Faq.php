<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Faq extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->loggedIn();
		$this->load->model('faq_model');
	}

	public function lists()
	{
		$data = array(
			'title' => 'List of Faqs',
			'page' => 'faq',
			'subpage' => 'faq_list'
		);
		$data['faqList'] =  $this->faq_model->getAll();
		$this->load->view('admin/header', $data);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/faq_list');
		$this->load->view('admin/footer');
	}

	public function view($faqId =  false){
		$data = array(
			'title' => 'View of Faq',
			'page' => 'faq',
			'subpage' => 'faq_list'
		);
		if($faqId == false) 
		{
			show_404();
			exit();
		}
		if(!empty($faqId)){
			$data['faq'] = $this->faq_model->getRow($faqId);
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/faq_view');
			$this->load->view('admin/footer');

		}else{
		   redirect(admin_url('faq/lists'),'refresh');
		}

	}

	public function add(){
			$data = array(
				'title' => 'Add New Faq',
				'page' => 'faq',
				'subpage' => 'add_new_faq'
			);
			
			$this->load->view('admin/header', $data);
			$this->load->view('admin/sidebar');
			$this->load->view('admin/faq_add');
			$this->load->view('admin/footer');
	}

	public function create(){
			$data = array(
				'title' => 'Add New Faq',
				'page' => 'faq',
				'subpage' => 'add_new_faq'
			);
			$this->form_validation->set_rules('question', 'Username', 'required');
			$this->form_validation->set_rules('answer', 'Answer', 'required');
			$this->form_validation->set_rules('status', 'Status', 'required');
			if($this->form_validation->run() == FALSE){
							$msg = 'error';
						 $this->session->set_flashdata('msg', $msg);
						 $this->load->view('admin/header', $data);
						 $this->load->view('admin/sidebar');
						 $this->load->view('admin/faq_add');
						 $this->load->view('admin/footer');
			}else{
					if(!empty($this->input->post())){
					$mydata = array(
						'question' => $this->input->post('question'),
						'answer'   => $this->input->post('answer'),
						'status'   => $this->input->post('status'),
						'created'  => date('Y-m-d H:i:s A'),
					);
					 $this->faq_model->saveANDupdate($mydata);
					 $msg = '["New Faq added successfully!", "success", "#A5DC86"]';
					 $this->session->set_flashdata('msg', $msg);
					redirect(admin_url('faq/lists'),'refresh');
					}else{
						 $msg = '["New Faq added Not successfully!", "error", "#A5DC86"]';
					     $this->session->set_flashdata('msg', $msg);
						 $this->load->view('admin/header', $data);
						 $this->load->view('admin/sidebar');
						 $this->load->view('admin/faq_add');
						 $this->load->view('admin/footer');
					}
			}
	}


	public function edit($faqId=false){
			if($faqId == false) 
			{
				show_404();
				exit();
			}
		    $data = array(
				'title' => 'Edit Faq',
				'page' => 'faq',
				'subpage' => 'add_new_faq'
			);
			$data['faq'] = $this->faq_model->getRow($faqId);
			if(!empty($data['faq'])){
			    $this->load->view('admin/header', $data);
				$this->load->view('admin/sidebar');
				$this->load->view('admin/faq_edit');
				$this->load->view('admin/footer');
			}else{
				show_404();
			    exit();
		    }
	}

	public function update($faqId=false){
			if($faqId == false) 
			{
				show_404();
				exit();
			}

			if(!empty($this->input->post())){
					$mydata = array(
						'id'	=> $faqId,
						'question' => $this->input->post('question'),
						'answer'   => $this->input->post('answer'),
						'status'   => $this->input->post('status'),
						'updated'  => date('Y-m-d H:i:s A'),
					);
					 $this->faq_model->saveANDupdate($mydata);
					 $msg = '["Faq Update successfully!", "success", "#A5DC86"]';
					 $this->session->set_flashdata('msg', $msg);
					 redirect(admin_url('faq/edit/'.$faqId),'refresh');
			}else{
					 $msg = '["Faq Update Not successfully!", "error", "#A5DC86"]';
					 $this->session->set_flashdata('msg', $msg);
				     redirect(admin_url('faq/edit/'.$faqId),'refresh');
            }
	}

	public function publish($faqId){
        if(!empty($faqId)){
            $faqdata['id'] = $faqId;
            $faqdata['status'] = 1;
            $status = $this->faq_model->statusUpdate($faqdata);
            if($status ==1){
            $msg = '["Faq Published Successfully !", "success", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
            }else{
                $msg = '["Faq Publish Not Successfully !", "error", "#A5DC86"]';
			    $this->session->set_flashdata('msg', $msg);
                redirect(admin_url('faq/lists'),'refresh');
            }
        }else{
            $msg = '["Faq Publish Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
        }

    }

    public function unpblish($faqId){
        if(!empty($faqId)){
            $faqdata['id'] = $faqId   ;
            $faqdata['status'] = 0;
            $status = $this->faq_model->statusUpdate($faqdata);
            if($status ==1){
            $msg = '["Fqa Unpublish Successfully !", "success", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
            }else{
                $msg = '["Fqa Unpublish Not Successfully !", "error", "#A5DC86"]';
			    $this->session->set_flashdata('msg', $msg);
                set_message($type, $message);
                redirect(admin_url('faq/lists'),'refresh');
            }
        }else{
            $msg = '["Fqa Unpublish Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
        }

    }

    public function delete($faqId = false){
    	if($faqId == false) 
			{
				show_404();
				exit();
			}

		  if(!empty($faqId)){
		  	$data =  $this->faq_model->fqa_delete($faqId);
		  	if($data ==1){
			$msg = '["Fqa Delete Successfully !", "success", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
		  	}else{
		  	$msg = '["Fqa Delete Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
		  	}
		  }else{
		  	$msg = '["Fqa Delete Not Successfully !", "error", "#A5DC86"]';
			$this->session->set_flashdata('msg', $msg);
            redirect(admin_url('faq/lists'),'refresh');
		  }
    }

    public function import(){
       $datas = array(
			'title' => 'Import of Faq',
			'page' => 'faq',
			'subpage' => 'faq_import'
		);
       $mydata[]= '';
       $this->load->helper('form');
       $config['upload_path'] = './uploads/faq/';
       $config['allowed_types'] = 'gif|csv';
       $this->load->library('upload', $config);
       $this->upload->initialize($config);
       $this->upload->set_allowed_types('*');
      
        if($this->input->post('importSubmit')){
           
            $target_dir='./uploads/faq/';
            $target_file = $target_dir.basename($_FILES['file']['name']);
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); 
            if($imageFileType == 'csv'){
                
             if( ! $this->upload->do_upload('file')){
				
				$error = strip_tags($this->upload->display_errors());
				$msg = '["'.$error.'", "error", "#DD6B55"]';
			}else{
				$data = $this->upload->data();

				$fileexists = 0;
					if(file_exists($target_file)){
						$fileexists = 1;
					}
					if($fileexists == 1)
					{
						//reading the file
						$file = fopen($target_file,'r');
						$index = 0;

						$importData_arr = array();

						while(($data = fgetcsv($file,1000,',')) != False)
						{
							$num = count($data);

							for($i = 0; $i<$num; $i++){
								$importData_arr[$index][] = $data[$i];
							}
							$index++;
						}
						fclose($file);

						$skip =0;
						$exist_data = 0;
						$inserted_data = 0;
						$total_data = 0;
						foreach($importData_arr as $data) {
							//skip the first index
							if($skip != 0)
							{

								$mydata['question'] = $data[0];
								$mydata['answer'] = $data[1];
								$mydata['created'] = date('Y-m-d H:i:s A');
								$mydata['status'] = 1;

								if(count($mydata) == 5){
									$qmsg = $this->faq_model->csVImpoart($mydata);
									if($qmsg ==1){
										$successMsg = '["Invalid file, Invalid data .", "error", "#A5DC86"]';
			   						    $this->session->set_flashdata('msg',  $successMsg);
									}
								}else{
									$successMsg = '["Invalid file, Invalid data .", "error", "#A5DC86"]';
			   						$this->session->set_flashdata('msg',  $successMsg);
								}
								$total_data++;
							}
						$skip++;
						}
					}
				$successMsg = '[" File Import successfully.", "success", "#A5DC86"]';
			    $this->session->set_flashdata('msg',  $successMsg);
				redirect(admin_url('faq/import'));
				
			}

			$this->session->set_flashdata('msg', $msg);
            }else{
            	$successMsg = '["Invalid file, please select only CSV file.", "error", "#A5DC86"]';
			    $this->session->set_flashdata('msg',  $successMsg);
            }
        }
        //redirect(admin_url('faq/import'));
        $this->load->view('admin/header', $datas);
		$this->load->view('admin/sidebar');
		$this->load->view('admin/faq_import');
		$this->load->view('admin/footer');
       
    }

	
}