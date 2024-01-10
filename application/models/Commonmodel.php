<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');



class Commonmodel extends CI_Model 

{



	function __construct() 

	{ 

		parent::__construct(); 

	}



	public function fetch_all($tbl)

	{

		$this->db->select('*');

		$query=$this->db->get($tbl);

		return $query->result();

	}

	public function fetch_all_join($query)

	{

		$query = $this->db->query($query);

		return $query->result(); 

	}

	public function fetch_single_join($query)

	{

		$query = $this->db->query($query);

		return $query->row();        

	}

	public function fetch_row($tbl, $where)

	{

		$this->db->select('*');

		$this->db->where($where);

		$query=$this->db->get($tbl);

		return $query->row();

	} 

	public function fetch_all_rows($tbl, $where)

	{

		$this->db->select('*');

		$this->db->where($where);

		$query=$this->db->get($tbl);

		return $query->result();

	}

	public function fetch_all_rows_limit($tbl, $where, $limit)

	{

		$this->db->select('*');

		$this->db->where($where);

		$this->db->limit($limit); 

		$query=$this->db->get($tbl);

		return $query->result();

	}

	

	public function fetch_by_limit_offset($tbl, $where, $limit=null, $offset=NULL)

	{

		$this->db->select('*');

		$this->db->where($where);

		$query=$this->db->from($tbl);

		$this->db->limit($limit, $offset);

		$query = $this->db->get();

		return $query->result();

	}

	public function delete_single_con($tbl,$where)

	{

		$this->db->where($where);

		$delete = $this->db->delete($tbl); 

		return $delete;

	}

	public function edit_single_row($tbl, $data, $where)

	{

		$this->db->where($where);

		if($this->db->update($tbl, $data)) 

		{

			return true;

		} else {

			return false;

		}

	}



    public function add_details($tbl, $data)

	{

		$this->db->insert($tbl,$data);

		$lastid= $this->db->insert_id();

		return $lastid;		

	}

	public function total_count($tbl, $where) 

	{

		$this->db->select('*');

		$this->db->where($where);

		return $this->db->count_all_results($tbl);

	}  

}