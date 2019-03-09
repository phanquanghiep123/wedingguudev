<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Gallery extends MY_Controller {
    private $folder_view = "gallery"; 
    private $base_controller;
    private $table = '';
    private $table_category = '';
    private $table_member = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'gallery';
        $this->table_member = $this->table_prefix.'member';
        $this->table_category = $this->table_prefix.'gallery_category';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $where = ' 1 = 1';
        if($this->input->get("keyword") != null){
            $where .= " AND name Like %".$this->input->get("keyword")."%";
        }   
        if($this->input->get("status") != null){
            $where .= " AND status = '".$this->input->get("status")."'";
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
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        
        $sql = "SELECT g.*,c.name AS category
                FROM {$this->table} AS g 
                INNER JOIN {$this->table_category} AS c ON c.id = g.category_id 
                WHERE $where
                ORDER BY g.id DESC
                LIMIT $offset,$per_page";

        $sql_count = "SELECT count(g.id) AS count
                FROM {$this->table} AS g 
                INNER JOIN {$this->table_category} AS c ON c.id = g.category_id  
                WHERE $where";
        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["gallery"] = $this->Common_model->query_raw($sql);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('category_id', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('type', 'Loại', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_insert['image'] = json_encode($this->input->post('gallery_item'));
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $this->data['category'] = $this->Common_model->get_result($this->table_category);
        $this->data['member'] = $this->Common_model->get_result($this->table_member);
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    
    public function edit($id = null){
        if($id == null){
            redirect(backend_url($this->base_controller));
        }
        $record = $this->Common_model->get_record($this->table,array("id" => $id));
        if($record == null){
            redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('category_id', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('type', 'Loại', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                $data_update['image'] = json_encode($this->input->post('gallery_item'));
                $this->Common_model->update($this->table,$data_update,array("id" =>$record["id"]));
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $this->data['category'] = $this->Common_model->get_result($this->table_category);
        $this->data['member'] = $this->Common_model->get_result($this->table_member);
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
        $this->data['record'] = $record;
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = null){
        $this->Common_model->delete($this->table,array("id" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
