<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sysmembers extends MY_Controller {
    private $folder_view  = "sysmembers"; 
    private $base_controller ;
    private $table = '';
    private $table_role = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'sys_users';
        $this->table_role = $this->table_prefix.'sys_roles';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }

    public function index(){
        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["User_Name Like"] = "%".$this->input->get("keyword")."%";
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
    	$this->data["table_data"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page);
    	$this->data["role"] = $this->Common_model->get_result($this->table_role);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }

    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('User_Name', 'Name', 'required');
            $this->form_validation->set_rules('User_Email', 'Email', 'required|trim|valid_email|is_unique['.$this->table.'.User_Email]');
            $this->form_validation->set_rules('User_Pwd', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert["User_Pwd"] = md5(trim($data_insert["User_Pwd"])."{:MC:}".trim($data_insert["User_Email"]));
                if (isset($_FILES["User_Avatar"])){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/backend/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $this->user_info["ID"];
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["User_Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_insert["User_Avatar"] = "uploads/backend/member/".$this->user_info["ID"]."/".$upload["reponse"]["file_name"];
                	else
                		$data_insert["User_Avatar"] = "";
                }else{
                	$data_insert["User_Avatar"] = "";
                }
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/' . $id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $this->data["role"] = $this->Common_model->get_result($this->table_role);
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    
    public function edit($id = null){
    	if($id == null){
    		redirect(backend_url("/".$this->folder_view.""));
        }
    	$record = $this->Common_model->get_record($this->table,array("ID" => $id));
    	if($record == null){
    		redirect(backend_url("/".$this->folder_view.""));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('User_Name', 'Name', 'required');
            $this->form_validation->set_rules('User_Pwd', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $data_update["Updatedat"] = date("Y-m-d h:i:sa");
                if($data_update["User_Pwd"] != null && $data_update["User_Pwd"] != "")
                	$data_update["User_Pwd"] = md5(trim($data_update["User_Pwd"])."{:MC:}".trim($record["User_Email"]));
                else unset($data_update["User_Pwd"]);
                if (isset($_FILES["User_Avatar"])){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/backend/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $this->user_info["ID"];
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["User_Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_update["User_Avatar"] = "uploads/backend/member/".$this->user_info["ID"]."/".$upload["reponse"]["file_name"];
                	else
                		$data_update["User_Avatar"] = $record["User_Avatar"];
                }else{
                	$data_update["User_Avatar"] = $record["User_Avatar"];
                }
                $this->Common_model->update($this->table,$data_update,array("ID" =>$record["ID"]));  
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/' . $id));
        }
        $this->data["role"] = $this->Common_model->get_result($this->table_role);
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
