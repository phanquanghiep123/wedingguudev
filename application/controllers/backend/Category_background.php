<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_background extends MY_Controller {
    private $folder_view = "category_background"; 
    private $base_controller;
    private $table = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'background_category';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }

    public function index(){
        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["background_name Like"] = "%".$this->input->get("keyword")."%";
        }   
        if($this->input->get("status") != null){
            $where["status"] = $this->input->get("status");
        }
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $per_page = $this->per_page;
        $count_table = $this->Common_model->count_table($this->table,$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["category"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('background_name', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    
    public function edit($id = null){
        if($id == null){
            redirect(backend_url($this->base_controller));
        }
        $record = $this->Common_model->get_record($this->table,array("ID" => $id));
        if($record == null){
            redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('background_name', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                $this->message($this->message_update_succes,'success');
                $this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]));
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $this->data['record'] = $record;
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = null){
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
