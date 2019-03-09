<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Websetting extends MY_Controller {
    private $folder_view = "websetting"; 
    private $base_controller;
    private $table = '';
    private $table_menu = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'web_setting';
        $this->table_menu = $this->table_prefix.'menu_group';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index(){
    	$record = $this->Common_model->get_record($this->table);
        if ($this->input->post()) {
            $this->input->input_stream('key', FALSE); // No XSS filter
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('favicon', 'Favicon', 'required');
            $this->form_validation->set_rules('logo', 'Logo', 'required');
            if ($this->form_validation->run() == TRUE) {
                $home_list = array();
                if($this->input->post('section_content')){
                    $section_content = $this->input->post('section_content');
                    $section_title = $this->input->post('section_title');
                    foreach ($section_content as $key => $item) {
                        if(@$section_title[$key] != null || @$section_content[$key] != null){
                            $home_list[] = array(
                                'section_title' => @$section_title[$key],
                                'section_content' => @$section_content[$key],
                            );
                        }
                    }
                }
                $data = $this->input->post();
                unset($data['section_title']);
                unset($data['section_content']);
                $data['home_list'] = $home_list;
                $data_update = array('Body_Json' => json_encode($data));
                $this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]));  
                $this->message($this->message_update_succes,'success');
            } else {
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller));
        }
        $this->load->library('ckeditor');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '200px');
        $this->data['menu'] = $this->Common_model->get_result($this->table_menu);
    	$this->data['record'] = json_decode(@$record['Body_Json'],true);
    	$this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
}
