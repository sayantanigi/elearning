<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Notfound extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$this->load->view('admin/404');
	}

}

/* End of file Notfound.php */
/* Location: ./application/controllers/Notfound.php */