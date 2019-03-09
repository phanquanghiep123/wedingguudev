<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acounts extends CI_Controller {
    public $data      = null;
    public $is_login  = false;
    public $user_info = null;
    private $table = '';
    public $backend_asset = BACKEND;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
        }
        $this->table = 'ewd_sys_users';
        $this->data["admin_info"] = $this->user_info;
        $this->data["is_login"]   = $this->is_login;
    }
    public function index(){
        if($this->data["is_login"] )
            redirect(backend_url());
        else
            redirect(backend_url("acounts/login"));
    }
    public function login() {
        if($this->data["is_login"] ){
            redirect(backend_url());
        }
        //$this->Common_model->update($this->table,array('User_Pwd' => md5(trim('123456')."{:MC:}".'phanquanghiep123@gmail.com')),array("User_Email" => 'phanquanghiep123@gmail.com'));
        if($this->input->post()){
            $email      = trim($this->input->post("email"));
            $password   = $this->input->post("password");
            $valid      = true;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $this->data["messenger"][] = "Email phải có một địa chỉ email hợp lệ!";
                $valid = false;
            } 
            if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Mật khẩu phải có ít nhất 6 kí tự!";
                $valid = false;
            }
            if($valid){
                $outputpassword = md5(trim($password)."{:MC:}".$email);
                $admin = $this->Common_model->get_record($this->table,array("User_Pwd" => $outputpassword));
                if($admin != null){
                    $admin["is_system"] = 1;
                    $this->session->set_userdata('admin_info',$admin);
                    // Save cookie for ckfinder
                    setcookie('ckfinder', base64_encode($admin["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie('loggedin', md5("VM@123").":".base64_encode($admin["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
                    // Set cookie authorize and member_id ==> base_64
                    redirect(backend_url());
                }else{
                    $this->data["messenger"][] = "Email hoặt mật khẩu không chính xác!";
                }
            }
        }
        $this->load->view($this->backend_asset."/acounts/login",$this->data);
    }
    public function signup(){
        if($this->data["is_login"] )
            redirect(backend_url());
        if($this->input->post()){
            $email       = trim($this->input->post("email"));
            $password    = trim($this->input->post("password"));
            $user_name   = trim($this->input->post("user_name"));
            $valid       = true;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $this->data["messenger"][] = "Email phải có một địa chỉ email hợp lệ!";
                $valid = false;
            }else{
                $check_email = $this->Common_model->get_record($this->table,array("User_Email" => $email));
                if($check_email != null){
                    $this->data["messenger"][] = "Email này đã được sử dụng vui lòng chọn email khác!";
                    $valid = false;
                }
            }
            if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Mật khẩu phải có ít nhất 6 kí tự";
                $valid = false;
            }
            if($user_name == null || $user_name == ""){
                $this->data["messenger"][] = "Tên người dùng không được trống";
                $valid = false;
            }
            if($valid){
                $outputpassword = md5(trim($password)."{:MC:}".$email);
                $data_insert = array(
                   "User_Name"  => $user_name,
                   "User_Email" => $email,
                   "User_Pwd"   => $outputpassword 
                );
                $id = $this->Common_model->add($this->table,$data_insert); 
                if($id){
                    $admin = $this->Common_model->get_record($this->table,array("ID" => $id));
                    if($admin != null){
                        $admin["is_system"] = 1;
                        $this->session->set_userdata('admin_info',$admin);
                    }
                    redirect(backend_url());
                }
            }
        }
        $this->load->view($this->backend_asset."/acounts/login",$this->data);
    }
    public function lost_password(){
        if($this->data["is_login"] )
            redirect(backend_url());
        if($this->data["is_login"])
            redirect(backend_url());
        $email  = trim($this->input->post("email"));
        $valid  = true;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $this->data["messenger"][] = "Email phải có một địa chỉ email hợp lệ";
            $valid = false;
        } 
        if($valid){
            $check_email = $this->Common_model->get_record($this->table,array("User_Email" => $email));
            if($check_email != null){
                sendmail($email,"Forgot your password.",'<a href="'.backend_url('acounts/forgot?token='.$check_email['User_Pwd'].'&email='.$email).'">Click to update your password</a>');
                $this->data["messenger"][] = "Một liên kết thây đổi mật khẩu đã được gửi đến email của bạn.";
            }else{
                $this->data["messenger"][] = "Email không tồn tại! xin vui lòng kiểm tra email";
                $valid = false;
            }
        }
        $this->load->view($this->backend_asset."/acounts/login",$this->data);
    }
    public function logout() {
        if($this->data["is_login"])
            $this->session->unset_userdata('admin_info');
        redirect(backend_url("acounts/login"));
    }
    public function forgot(){
        if(!$this->data["is_login"]){
            if($this->input->get("token") && $this->input->get("email")){
                $check_user = $this->Common_model->get_record($this->table,array("User_Pwd" => trim($this->input->get("token"))));
                if($check_user != null){
                    $this->load->view($this->backend_asset."/acounts/forgot",$this->data);
                }else{
                    redirect(backend_url("acounts/login"));
                }
            }else{
                redirect(backend_url("acounts/login"));
            }
        }else{
            redirect(backend_url());
        }   
    }
    public function reset_password(){
        if($this->input->post("token") && $this->input->post("email")){
            $valid  = true;
            $email  = trim($this->input->post("email"));
            $token  = trim($this->input->post("token"));
            $password = trim($this->input->post("password"));
            $password_confirm = trim($this->input->post("password_confirm"));
            if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Mật khẩu phải có it nhất 6 kí tự";
                $valid = false;
            }
            if($password != $password_confirm){
                $this->data["messenger"][] = "Mật khẩu không phù hợp với Password Confirm";
                $valid = false;
            }
            if($valid){
                $check_user = $this->Common_model->get_record($this->table,array ("User_Pwd" => $token ,"User_Email" => $email) );
                if($check_user != null){
                    $data_update = array(
                        "User_Pwd" =>  md5(trim($password)."{:MC:}".trim($check_user["User_Email"]))
                    );
                    $this->Common_model->update($this->table,$data_update,array("ID" => $check_user["ID"]));
                }
                redirect(backend_url("acounts/login?messenger=reset_success"));
            }
        }else{
            redirect(backend_url("acounts/login"));
        }
        $this->load->view($this->backend_asset."/acounts/forgot",$this->data);
    }
    public function social(){
        $data = $this->input->post("data");
        $name = $data["name"];
        $email = isset($data["email"]) ? $data["email"] : "";
        $data["success"] = "error";
        $data["messenger"] = "";
        $check_email = $this->Common_model->get_record($this->table, array(
            "User_Email" => $email
        ));
        if ($check_email == null) {

            $password = uniqid();
            $outputpassword = md5(trim($password)."{:MC:}".$email);
            $data_insert = array(
               "User_Name"  =>  $name ,
               "User_Email" => $email,
               "User_Pwd"   => $outputpassword 
            );
            $id_insert = $this->Common_model->add($this->table, $data_insert);
            $record = $this->Common_model->get_record($this->table, array("ID" => $id_insert));
            if ($record != null) {
                $this->session->set_userdata('admin_info',$record);
                $data["success"] = "success";
                $data["reload"] = backend_url();
            }
        }
        else {
            $this->session->set_userdata('admin_info',$check_email);
            $data["success"] = "success";
            $data["reload"] = backend_url();
        }
        die(json_encode($data));
    }
}
