<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class sysroles extends MY_Controller {
    private $folder_view = "sysroles"; 
    private $base_controller ;
    private $table = '';
    private $table_sys_user = '';
    private $table_sys_rule = '';
    private $table_modules = '';

    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'sys_roles';
        $this->table_sys_user = $this->table_prefix.'sys_users';
        $this->table_sys_rule = $this->table_prefix.'sys_rules';
        $this->table_modules = $this->table_prefix.'sys_modules';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }

    public function index(){
    	$this->data["table_data"] = $this->Common_model->get_result($this->table);
        $this->data["role"] = $this->Common_model->get_result($this->table_sys_user);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }

    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Role_Title', 'Role Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert["System"] = $this->user_info["ID"];
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/' . $id));
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
            $this->form_validation->set_rules('Role_Title', 'Role Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]));  
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$record["ID"]));
        }
        $this->data['record'] = $record;
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function details($id = null){
        $record = $this->Common_model->get_record($this->table,array("ID" => $id));
        if($record == null){
            redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            
            $modules = $this->input->post("module");
            $view = $this->input->post("view");
            $add = $this->input->post("add");
            $edit = $this->input->post("edit");
            $delete = $this->input->post("delete");
            $all = $this->input->post("all");
            foreach ($modules as $key => $value) {
                $data_cm = array("Module_ID" => $value, "Role_ID" => $id );
                $check_record = $this->Common_model->get_record($this->table_sys_rule,$data_cm);
                $data_cm["Allow"]  = @$all[$key] == 1 ? 1 : 0;
                $data_cm["Add"]    = @$add[$key] == 1 ? 1 : 0;
                $data_cm["Edit"]   = @$edit[$key] == 1 ? 1 : 0;
                $data_cm["View"]   = @$view[$key] == 1 ? 1 : 0;
                $data_cm["Delete"] = @$delete[$key] == 1 ? 1 : 0;
                $data_cm["Updatedat"] = date("Y-m-d h:i:sa");
                if($check_record == null){
                    $this->Common_model->add($this->table_sys_rule,$data_cm); 
                }else{
                    $this->Common_model->update($this->table_sys_rule,$data_cm,array("ID" =>$check_record["ID"])); 
                }
            }
            $this->message('Cập nhật thành công','success');
            redirect(backend_url($this->base_controller.'/details/' . $id));
        }
        $this->load->model("Sys_rules_model");
        $record_md = $this->Sys_rules_model->get_data_role($id,$this->table_sys_rule,$this->table_modules);
        $this->data["html_modules"] = $this->get_html_modules($record_md);
        $this->load->view($this->backend_asset."/".$this->folder_view."/details",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url("/".$this->folder_view));
    }

    private $index = 1;
    private $html_modules = "";
    private function get_html_modules($data = null,$root = 0,$level = '', $table = true , $activer = -1){
        $termsList = array();
        $new_listdata = array();
        if ($root != 0) {
            $level .= '&mdash; &mdash;';
        }
        if ($data != null) { 
            foreach ($data AS $key => $item ) {
                if ($item['Parent_ID'] == $root){
                    $termsList[] = ($item);
                }
                else {
                    $new_listdata[] = ($item);
                }
            }
        }
        if ($termsList != null) {
            foreach ($termsList AS $key => $item_2 ) {
                $this->html_modules .= '
                <tr>
                    <td>'.($this->index++).'</td>
                    <td>'.$level .' '.$item_2['Module_Name'].'</td>
                    <td>'.$item_2['Module_Url'].'</td>
                    <td class="text-center"><input '.(@$item_2['View'] == 1 ? 'checked' : '').' class="view" name="view['.$item_2['ID'].']" type="checkbox" value = "1" /></td>
                    <td class="text-center"><input '.(@$item_2['Add'] == 1 ? 'checked' : '').' class="add" name="add['.$item_2['ID'].']" type="checkbox" value = "1" /></td>
                    <td class="text-center"><input '.(@$item_2['Edit'] == 1 ? 'checked' : '').' class="edit" name="edit['.$item_2['ID'].']" type="checkbox" value = "1" /></td>
                    <td class="text-center"><input '.(@$item_2['Delete'] == 1 ? 'checked' : '').' class="delete" name="delete['.$item_2['ID'].']" type="checkbox" value = "1" /></td>
                    <td class="text-center">
                        <input '.(@$item_2['Allow'] == 1 ? 'checked' : '').' class="all" name="all['.$item_2['ID'].']" type="checkbox" value ="1" />
                        <input name="module['.$item_2['ID'].']" type="hidden" value ="'.$item_2['ID'].'" />
                    </td>
                </tr>';
                $this->get_html_modules($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}
