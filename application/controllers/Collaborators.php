<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Collaborators extends Frontend_Controller {
	public function index()
	{
		$this->load->view('welcome_message');
	}
}
