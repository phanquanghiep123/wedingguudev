<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class invite extends MY_Controller {
    private $folder_view = "invite"; 
    private $base_controller;
    private $table = '';
    private $table_member = '';
    private $table_payment_history = '';

    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'invite';
        $this->table_member = $this->table_prefix.'member';
        $this->table_payment_history = $this->table_prefix.'payment_history';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index(){
        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["name Like"] = "%".$this->input->get("keyword")."%";
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
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $sql = "SELECT tbl1.*,tbl4.total_price,tbl2.first_name,tbl2.last_name,tbl3.first_name AS invite_first_name,tbl3.last_name AS invite_last_name
                FROM {$this->table} AS tbl1 
                INNER JOIN {$this->table_member} AS tbl2 ON tbl1.member_id = tbl2.id
                INNER JOIN {$this->table_member} AS tbl3 ON tbl1.member_invite_id = tbl2.id
                INNER JOIN {$this->table_payment_history} AS tbl4 ON tbl4.member_id = tbl2.id 
                ORDER BY tbl1.id DESC
                LIMIT $offset,$per_page";

        $sql_count = "SELECT count(tbl1.id) AS count
                FROM {$this->table} AS tbl1 
                INNER JOIN {$this->table_member} AS tbl2 ON tbl1.member_id = tbl2.id
                INNER JOIN {$this->table_member} AS tbl3 ON tbl1.member_invite_id = tbl2.id
                INNER JOIN {$this->table_payment_history} AS tbl4 ON tbl4.member_id = tbl2.id";
        
        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["results"] = $this->Common_model->query_raw($sql);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');
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
        $this->data['category'] = $this->Common_model->get_result($this->table_category);
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
            $this->form_validation->set_rules('title', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('content', 'Nội dung', 'required');
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
                $this->Common_model->update($this->table,$data_update,array("id" =>$record["id"]));
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $this->data['category'] = $this->Common_model->get_result($this->table_category);
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
