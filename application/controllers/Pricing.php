<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class pricing extends Frontend_Controller {

	private $table = '';
	public function __construct(){
        parent::__construct();
        $this->table = $this->table_prefix."package";
    }

	public function index($slug = null){
		$this->data['title'] = 'Danh sách gói dịch vụ';
		$this->data["data"] = $this->Common_model->get_result($this->table,["status" => 1]);
		$this->load->view($this->asset.'/pricing/index',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}
	
}
