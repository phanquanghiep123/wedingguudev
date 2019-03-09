<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {
	private $folder_view = "dashboard"; 
    private $base_controller;
    private $table = '';
    private $table_menu = '';
    
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'dashboard';
        $this->table_menu = $this->table_prefix.'menu_group';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index() {
    	$this->data["collections"] = $this->Common_model->get_result($this->table);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data,["user_id" => $this->user_info["ID"]]);
    }

}
