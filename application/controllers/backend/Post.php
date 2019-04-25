<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class post extends MY_Controller {
    private $folder_view = "post"; 
    private $base_controller;
    private $table = '';
    private $table_category = '';
    private $table_post_category = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'post';
        $this->table_category = $this->table_prefix.'categories';
        $this->table_post_category = $this->table_prefix.'post_category';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["Name Like"] = "%".$this->input->get("keyword")."%";
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
        $per_page = $this->per_page;
        $count_table = $this->Common_model->count_table($this->table,$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $config['base_url'] = base_url($this->backend_asset.'/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["pages"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page,array('ID' => 'DESC'),true);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('Status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('Name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('Content', 'Nội dung', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_insert['Updated_At'] = date('Y-m-d H:i:s');
                $data_insert['Created_At'] = date('Y-m-d H:i:s');
                $data_insert['Slug'] = $this->helperclass->slug($this->table,"Slug",$this->input->post('Name'));
                $id = $this->Common_model->add($this->table,$data_insert);  
                if($id > 0){
                    $category1 = $this->input->post('category');
                    if(isset($category1) && $category1 != null){
                        foreach ($category1 as $key => $item) {
                            $arr = array(
                                'category_id' => $item,
                                'post_id'     => $id
                            );
                            $this->Common_model->add($this->table_post_category,$arr);
                        }
                    }
                }
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $table_data = $this->Common_model->get_result($this->table_category);
        $this->data['option_category'] = $this->get_html_category($table_data,0,'',null);
        $this->data['langs'] = $this->Common_model->get_result($this->table_prefix.'languages');
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
        $record = $this->Common_model->get_record($this->table,array("ID" => $id));
        if($record == null){
            redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('Status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('Name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('Content', 'Nội dung', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                $data_update['Updated_At'] = date('Y-m-d H:i:s');
                if($this->input->post('Name') != $record['Name']){
                    $data_update['Slug'] = $this->helperclass->slug($this->table,"Slug",$this->input->post('Name'));
                }
                $this->message($this->message_update_succes,'success');
                if($this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]))){
                    $category1 = $this->input->post('category');
                    $this->Common_model->delete($this->table_post_category,array("post_id" =>$record["ID"]));
                    if(isset($category1) && $category1 != null){
                        foreach ($category1 as $key => $item) {
                            $arr = array(
                                'category_id' => $item,
                                'post_id'     => $record["ID"]
                            );
                            $this->Common_model->add($this->table_post_category,$arr);
                        }
                    }
                }
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $post_category = $this->Common_model->get_result($this->table_post_category,array('post_id' => $id));
        $table_data = $this->Common_model->get_result($this->table_category);
        $this->data['option_category'] = $this->get_html_category($table_data,0,'',$post_category);
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
        $this->data['record'] = $record;
        $this->data['langs'] = $this->Common_model->get_result($this->table_prefix.'languages');
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = null){
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }

    private $html_modules = '';
    private function get_html_category($data = null,$root = 0,$level = '', $activer = null){
        $termsList = array();
        $new_listdata = array();
        if ($root != 0){
            $level .= '&mdash; &mdash;';
        }
        if ($data != null) { 
            foreach ($data AS $key => $item ){
                if ($item['Parent_ID'] == $root){
                    $termsList[] = ($item);
                }
                else{
                    $new_listdata[] = ($item);
                }
            }
        }
        if ($termsList != null){
            foreach ($termsList AS $key => $item_2 ){
                $active = '';
                if(@$activer != null){
                    foreach ($activer as $key => $item) {
                        if (@$item['category_id'] == $item_2['ID']){
                            $active = 'selected';
                        }
                    }
                }
                $this->html_modules .= '<option value="' . $item_2['ID'] . '" '. $active . '>' . $level . '  ' . $item_2['Name'] . '</option>';
                $this->get_html_category($new_listdata, $item_2['ID'], $level, $activer);
            }
        }
        return $this->html_modules;
    }
}
