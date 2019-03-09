<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Email_template extends MY_Controller {
    private $folder_view = "email_template"; 
    private $base_controller ;
    private $message_slug = 'Slug này đã tồn tại.';
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $where  ["1"] = "1";
        if($this->input->get("keyword")){
            $where ["Title Like"] = "%".$this->input->get("keyword")."%" ;
        }
        if($this->input->get("status") != null){
            $where["Status"] = $this->input->get("status");
        }
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $count_table =  $this->Common_model->count_table("ewd_email_template",$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $per_page = $this->per_page;
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["templates"] = $this->Common_model->get_result("ewd_email_template",$where,$offset,$per_page);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('Key_Identify', 'Slug', 'required');
            $this->form_validation->set_rules('Title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('Status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('Content', 'Nội dung', 'required');
            if ($this->form_validation->run() == TRUE) {
                $check = $this->Common_model->get_record("ewd_email_template",array("Key_Identify" => $this->input->post('Key_Identify')));
                if(isset($check['ID']) && $check['ID'] != null){
                    $this->session->set_flashdata('record',$this->input->post());
                    $this->message($this->message_slug);
                }
                else{
                    $colums = $this->db->list_fields('ewd_email_template');
                    $data_post = $this->input->post();
                    $data_insert = array();
                    foreach ($data_post as $key => $value) {
                        if(in_array($key, $colums)){
                            $data_insert[$key] = $value;
                        }
                    }
                    $id = $this->Common_model->add("ewd_email_template",$data_insert);  
                    $this->message($this->message_add_succes,'success');
                    redirect(backend_url($this->base_controller.'/edit/'.$id ));
                }
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/create/'));
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function edit($id = null){
    	$record = $this->Common_model->get_record("ewd_email_template",array("ID" => $id));
    	if($record == null){
    		redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('Key_Identify', 'Slug', 'required');
            $this->form_validation->set_rules('Title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('Status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('Content', 'Nội dung', 'required');
            if ($this->form_validation->run() == TRUE) {
                $is_save = true;
                if($record['Key_Identify'] != $this->input->post('Key_Identify')){
                    $check = $this->Common_model->get_record("ewd_email_template",array("Key_Identify" => $this->input->post('Key_Identify')));
                    if(isset($check['ID']) && $check['ID'] != null){
                        $is_save = false;
                        $this->message($this->message_slug);
                    }
                }

                if($is_save){
                    $colums = $this->db->list_fields('ewd_email_template');
                    $data_post = $this->input->post();
                    $data_insert = array();
                    foreach ($data_post as $key => $value) {
                        if(in_array($key, $colums)){
                            $data_insert[$key] = $value;
                        }
                    }
                    $this->message($this->message_update_succes,'success');
                    $this->Common_model->update("ewd_email_template",$data_insert,array("ID" => $id));  
                }
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/' . $id));
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete("ewd_email_template",array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
