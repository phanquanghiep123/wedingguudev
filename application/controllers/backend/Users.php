<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    private $folder_view     = "users"; 
    private $base_controller ;
    private $table = '';
    private $table_package = '';
    private $table_payment_history = '';
    private $message_email = 'Địa chỉ email này đã được đăng ký.';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'member';
        $this->table_package = $this->table_prefix.'package';
        $this->table_payment_history = $this->table_prefix.'payment_history';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
        $this->data['package'] = $this->Common_model->get_result($this->table_package,array('status' => 1));
    }

    public function index(){
        $where  ["1"] = "1";
        if($this->input->get("keyword")){
            $where ["CONCAT(First_Name ,' ',Last_Name) Like"] = "%".$this->input->get("keyword")."%" ;
        }
        if($this->input->get("status") && $this->input->get("status") != "0"){
            $where ["Type_Member"]= @$this->input->get("status") ;
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
        $this->data["users"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page,array('id' => 'DESC'),true);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }

    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('last_name', 'Họ và tên', 'required');
            $this->form_validation->set_rules('email', 'Địa chỉ email', 'required');
            $this->form_validation->set_rules('password', 'Mật khẩu', 'trim|min_length[6]');
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('gender', 'Giới tính', 'required');
            if ($this->form_validation->run() == TRUE){
                $email = $this->input->post('email');
                $record = $this->Common_model->get_record($this->table,array('email' => $email));
                if(isset($record) && $record != null){
                    $this->session->set_flashdata('record',$this->input->post());
                    $this->message($this->message_email);
                    redirect(backend_url($this->base_controller.'/create/'));
                    die;
                }
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        if($key == 'wedding_date'){
                            $data_insert[$key] = date('Y-m-d',strtotime($value));
                        }
                        else{
                            $data_insert[$key] = $value;
                        }
                    }              
                }
                $data_insert["pwd"] = md5(trim($data_insert["email"]) .':'.trim($data_insert["password"]));
                $id = $this->Common_model->add($this->table,$data_insert);  
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
                die;
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
                die;
            }
        }
        $this->data['action'] = 'add';
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
            $this->form_validation->set_rules('last_name', 'Họ và tên', 'required');
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('gender', 'Giới tính', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums) && $key != 'email' && $key != 'password'){
                        if($key == 'wedding_date'){
                            $data_update[$key] = date('Y-m-d',strtotime($value));
                        }
                        else{
                            $data_update[$key] = $value;
                        }
                    }              
                }  
                if(trim($this->input->post("password")) != null){
                    $data_update["pwd"] = md5(trim($record["email"]) .':'.trim($this->input->post("password")));
                }
                if(isset($data_post['package']) && $data_post['package'] != null){
                    $package = $this->Common_model->get_record($this->table_package,array('id' => $data_post['package']));
                    if($package != null){
                        $arr = array(
                            'name'        => $data_post['last_name'],
                            'total_price' => $package['price'],
                            'months'      => $package['months'],
                            'start_date'  => date('Y-m-d H:i:s'),
                            'expired_at'  => date('Y-m-d H:i:s',strtotime('+'.$package['months'].' month')),
                            'package_id'  => $package['id'],
                            'member_id'   => $id,
                            'status'      => 1
                        );
                        $payment_id = $this->Common_model->add($this->table_payment_history,$arr);
                        if($payment_id > 0){
                            $expired_date = date('Y-m-d');
                            if($expired_date > date('Y-m-d')){
                                $expired_date = date('Y-m-d',strtotime($record['expired_date']));
                            }
                            $data_update['expired_date'] = date('Y-m-d H:i:s',strtotime('+'.$package['months'].' month',strtotime($expired_date)));
                            $data_update['package_id'] = $package['id'];
                        }
                    }
                }
                $this->Common_model->update($this->table,$data_update,array("id" =>$record["id"]));  
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/' . $id));
        }
        $this->data['action'] = 'edit';
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete($this->table,array("id" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
