<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
    private $folder_view = "category"; 
    private $base_controller;
    private $table = '';
    private $table_category = '';
    private $table_post_category = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'categories';
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
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["category"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page);
        $this->data['html_category'] = $this->get_html_category($this->data["category"]);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('Status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('Name', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_update['Update_At'] = date('Y-m-d H:i:s');
                $data_update['Create_At'] = date('Y-m-d H:i:s');
                $data_insert['Slug'] = $this->helperclass->slug($this->table,"Slug",$this->input->post('Name'));
                $parent = $this->Common_model->get_record($this->table,array("ID" => $this->input->post('Parent_ID')));  
                $data_insert['Path_Parent'] = (@$parent['Path_Parent'] != null ? @$parent['Path_Parent'] : '/').$data_insert['Slug'].'/';
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $table_data = $this->Common_model->get_result($this->table);
        $this->data['option_category'] = $this->get_html_category($table_data,0,'',false,-1);
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
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                $data_update['Update_At'] = date('Y-m-d H:i:s');
                $slug = '';
                if($this->input->post('Name') != $record['Name']){
                    $slug = $this->helperclass->slug($this->table,"Slug",$this->input->post('Name'));
                    $data_update['Slug'] = $slug;
                }
                $parent = $this->Common_model->get_record($this->table,array("ID" => $this->input->post('Parent_ID')));  
                $data_update['Path_Parent'] = (@$parent['Path_Parent'] != null ? @$parent['Path_Parent'] : '/').$record['Slug'].'/';
                $slug_last = $record['Slug'];
                $this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]));
                if($slug != ''){
                    $sql = "UPDATE $this->table
                            SET Path_Parent = REPLACE(Path_Parent, '/$slug_last/', '/$slug/')
                            WHERE Path_Parent LIKE '%/$slug_last/%'";
                    $this->Common_model->query_string($sql);
                }
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $this->data['record'] = $record;
        $table_data = $this->Common_model->get_result($this->table,array("ID !=" => $record["ID"]));
        $this->data['option_category'] = $this->get_html_category($table_data,0,'',false,@$record["Parent_ID"]);
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = null){
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }

    private $html_modules = '';
    private function get_html_category($data = null,$root = 0,$level = '', $table = true , $activer = -1){
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
                if ($activer == $item_2['ID']){
                    $active = 'selected';
                }

                if ($table == false){
                    $this->html_modules .= '<option value="' . $item_2['ID'] . '" '. $active . '>' . $level . '  ' . $item_2['Name'] . '</option>';
                }
                else{
                    $this->html_modules .= '<tr>';
                    $this->html_modules .= '  <td>' . ($key+1) . '</td>';
                    $this->html_modules .= '  <td>' . $level . '  ' . $item_2['Name'] . '</td>';
                    $this->html_modules .= '  <td>' . $item_2['Slug'] . '</td>';
                    $this->html_modules .= '  <td>' . ($item_2["Status"] == "1" ? 'Hoạt động' : 'Ngưng hoạt động') . '</td>';
                    $this->html_modules .= '  <td>' . date("d/m/Y, g:i A",strtotime(@$item_2["Create_At"])) . '</td>';
                    $this->html_modules .= '  <td>'.$this->load->view(@$this->backend_asset.'/includes/edit_delete',array('id' => @$item_2['ID'],'is_edit' => @$this->data['is_edit'],'is_delete' => @$this->data['is_delete'],'base_controller' => @$this->base_controller),true).'</td>';  
                    $this->html_modules .= '</tr>';
                }
                $this->get_html_category($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}
