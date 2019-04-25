<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class my404 extends Frontend_Controller {

	public function __construct(){
        parent::__construct();
    }

	public function index($slug = null){
		$this->load->view($this->asset.'/404/index',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}
}
