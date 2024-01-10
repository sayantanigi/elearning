<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Faq_model extends My_Model {
	public $tableName = "faq";
	function __construct(){ 
	  parent::__construct(); 

	}

	 public function saveANDupdate($data){
			if(!empty($data['id'])){
			   $faqData = $this->db->update($this->tableName,$data,array('id'=>$data['id']));
			}else{
			   $faqData	= $this->db->insert($this->tableName,$data);
			}
			return $faqData;
	}

	public function getAll(){
	  $data = $this->db->get($this->tableName)->result();
	  return $data;
	}

	public function getRow($faqId){
		return $this->db->get_where($this->tableName,array('id'=>$faqId))->row();
	}

	public function statusUpdate($data){
		return $this->db->update($this->tableName,$data,array('id'=>$data['id']));
	}

	public function fqa_delete($faqId){
		return $this->db->delete($this->tableName,array('id'=>$faqId));
	}


	public function csVImpoart($mydata){
		$data = $this->db->get_where($this->tableName,array('question'=>$mydata['question'],'answer'=>$mydata['answer']))->num_rows();
		if($data == 1){

		}else{
			$faqdata = array_splice($mydata,1);
			$this->saveANDupdate($faqdata);
		}
		return $data;
	}
}