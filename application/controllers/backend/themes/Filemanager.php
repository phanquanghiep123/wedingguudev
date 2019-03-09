<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Filemanager extends CI_Controller {
    public $_fix   = "ewd_";
    public $_table = "filemanager";
    public $_view  = "filemanager";
    public $_data  = [];
    public function __construct(){
        parent::__construct();
            ini_set('max_execution_time', 0);
        if(!$this->input->is_ajax_request())
          $this->load->view("block/header");
    }
    public function index(){
      $this->load->view($this->_view . "/index",$this->_data);
    }
    public function __destruct(){
      if(!$this->input->is_ajax_request())
        $this->load->view("block/footer");
    }
    
}
