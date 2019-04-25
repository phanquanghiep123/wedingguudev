<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Packages extends Frontend_Controller{
	private $table = '';
	public function __construct(){
        parent::__construct();
         $this->table = $this->table_prefix."package";
    }

	public function index(){
        
        if(@$this->user_id){
            $this->data["packages"] = $this->Common_model->get_result($this->table,["status" => 1,'is_default' => 0]);
        }
        else{
            $this->data["packages"] = $this->Common_model->get_result($this->table,["status" => 1]);
        }
        $packages = [];
        foreach ($this->data["packages"] as $key => $value) {
            $id = $value["id"];
            $sql = "select tbl1.*, tbl2.id as is_connect from {$this->table_prefix}package_options as tbl1 left join {$this->table_prefix}package_selects as tbl2 on tbl2.option_id = tbl1.id and package_id = {$id} order by tbl1.id ASC , tbl2.sort ASC";
            $value["options"] = $this->Common_model->query_raw($sql);
            $packages[] = $value;
        }
        $this->data["packages"] = $packages;   
        $this->load->view($this->asset.'/packages/index',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}

    public function closewindown(){
    	$js_close = '<script type=\'text/javascript\'>window.close();</script>';
        echo $js_close;
        die;
    }
}
