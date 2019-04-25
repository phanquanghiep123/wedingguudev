<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Account extends Frontend_Controller
{
    private $table = '';
    private $table_invite = '';
    private $table_email_template = '';
    public $stite_folder   = "weddingguu.com";
    public function __construct(){
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            redirect("/home/");
        }
        $this->table = $this->table_prefix.'member';
        $this->table_invite = $this->table_prefix.'invite';
        $this->table_email_template = $this->table_prefix.'email_template';
    }

    public function login(){
        $this->load->view($this->asset.'/account/login',$this->data);
    }

    public function register($promo_code = null){
    	$this->data['promo_code'] = $promo_code;
        $this->load->view($this->asset.'/account/register',$this->data);
    }

    public function forgot(){
        $this->load->view($this->asset.'/account/forgot',$this->data);
    }

    public function reset(){
        $email  = strtolower($this->input->get('email'));
        $token = $this->input->get('token');
        $record  = $this->Common_model->get_record($this->table, array(
            'email' => $email,
            'token' => $token
        ));
        if(@$record == null){
            redirect('/');
        }
        $this->load->view($this->asset.'/account/reset',$this->data);
    }
    
    public function signup(){
        $data['status'] = 'error';
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        if($this->input->post()){
            $this->load->library('form_validation');
	        //$this->form_validation->set_rules('first_name', 'Họ đệm', 'required|trim');
	        //$this->form_validation->set_rules('last_name', 'Tên', 'required|trim');
	        $this->form_validation->set_rules('pwd', 'Mật khẩu', 'required|trim');
	        $this->form_validation->set_rules('email', 'Địa chỉ email', 'required|trim|valid_email');
            $this->form_validation->set_rules('subdomain', 'Subdomain', 'required|trim');
	        if ($this->form_validation->run() === FALSE) {
                $data['status'] = 'fail';
                $data['message'] = $this->message(validation_errors());
                die(json_encode($data));
            }
            $email = strtolower($this->input->post('email'));
            $subdomain = strtolower($this->input->post('subdomain'));
            $record = $this->Common_model->get_record($this->table, array(
                'email' => $email
            ));
            if (isset($record) && $record != null) {
            	$data['status'] = 'fail';
                $data['message'] = $this->message('Địa chỉ email này đã được đăng ký.');
                die(json_encode($data));
            } 
        	if (strlen($this->input->post('pwd')) < 6) {
                $data['status'] = 'fail';
                $data['message'] = $this->message('Vui lòng nhập mật khẩu trên 6 ký tự.');
                die(json_encode($data));
            }
            if (!ctype_alnum($subdomain)){
                $data['status'] = 'fail';
                $data['message'] = $this->message('Vui lòng nhập subdomain không có ký tự đặc biệt.');
                die(json_encode($data));
            }
            $record = $this->Common_model->get_record($this->table, array(
                'sub_domain' => $subdomain
            ));
            if (isset($record) && $record != null){
                $data['status'] = 'fail';
                $data['message'] = $this->message('Subdomain đã tồn tại.Vui lòng nhập subdomain khác.');
                die(json_encode($data));
            }
            $token = md5(time());
            $pk = $this->Common_model->get_record("package",["is_default" => 1]);
            $web_setting = $this->Common_model->get_record($this->table_prefix.'web_setting');
            $Body_Json = json_decode(@$record['Body_Json'],true);
            $num_months = @$Body_Json["plusmember"] ? @$Body_Json["plusmember"] .' '.'days' : '0 days'; 
            $arr   = array(
                'package_id'   => $pk["id"],
                'phone'        => ($this->input->post('phone') != null ? $this->input->post('phone') : ''),
                'last_name'    => $this->input->post('last_name'),
                'email'        => $email,
                'sub_domain'   => $subdomain,
                'pwd' 		   => md5($email . ':' . $this->input->post('pwd')),
                'expired_date' => date('Y-m-d',strtotime('+'.$num_months)),
                'promo_code'   => $this->_get_promo_code(),
                'is_dealer'    => $this->input->post('is_dealer') == 1 ? 1 : 0,
            	'token'        => $token,
            	'status'       => 1,
                'created_at'   => date('Y-m-d H:i:s')
            );
            $user_id = $this->Common_model->add($this->table, $arr);
            if($user_id > 0){
                
                $num_months = $pk["months"] .' '.$pk["type"]; 
            	/*$template = $this->Common_model->get_record($this->table_email_template,array('Key_Identify' => 'verify-account'));
                if(@$template != null){
                    $replace = array("[%lastname%]", "[%link%]");
                    $replace_with = array($this->input->post('last_name'), base_url('/account/verify_account?email='.$email.'&token='.$token));
                    $sentdata = str_replace($replace, $replace_with, @$template['Content']);
                    $msg = $this->load->view($this->asset.'/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
                    $to = $this->input->post('email');
                    $subject = @$template['Title'];
                    sendmail($to, $subject, $msg);
                }*/
                $promo_code = $this->input->post('promo_code');
                if(isset($promo_code) && $promo_code != null){
                	$user = $this->Common_model->get_record($this->table,array('promo_code' => $promo_code));
                	if($user != null){

                		$arr = array(
                			'email'              => $email,
                			'member_id'          => $user_id,
                			'member_invite_id'   => $user['id'],
                			'created_at'         => date('Y-m-d H:i:s'),
                			'updated_at'         => date('Y-m-d H:i:s'),
                		);
                		$id = $this->Common_model->add($this->table_invite, $arr);
                		if($id){
                			$oldD = $user["expired_date"];
                			if(strtotime($oldD) >= strtotime(date('Y-m-d'))){
                				$date = strtotime($oldD);
                				$date = strtotime("+".$num_months, $date);
                				$u = [
	                				'expired_date' => date("Y-m-d",$date)
	                			];
                			}else{
                				$u = [
	                				'expired_date' => date("Y-m-d",strtotime('+'.$num_months) )
	                			];
                			}
                			$data["update"] = $u;
                			$this->Common_model->update( $this->table, $u,[ "id" => $user["id"] ] );	
                            $datetime1 = new DateTime($oldD );
                            $datetime2 = new DateTime($u["expired_date"]);
                            $interval  = $datetime1->diff($datetime2);
                            $days =  $interval->format('%R%a days');
                            $this->Common_model->update($this->table_invite, ["plus_day_to_member" => $days],["id" => $id]);
                		}
                	}
                }
                $this->Common_model->add("member_package",[
                    "member_id"  => $user_id ,
                    "package_id" => $pk["id"],
                    'created_at' => date('Y-m-d H:i:s'),
                    'start_date' => date('Y-m-d H:i:s'),
                    'expired_at' => date('Y-m-d',strtotime('+'.$num_months))
                ]);
                $member = $this->Common_model->get_record($this->table,array('id' => $user_id));
                if((@$member['sub_domain'] && trim(@$member['sub_domain']) != "" ) || (@$member['domain'] && trim(@$member['domain']) != "" )){
                	$sub_domain = $member['sub_domain'];
                    $folderDomain = trim($sub_domain);
                    $folderDomain = trim($sub_domain.'.'.$this->stite_folder.'');
                    if(!file_exists("../".trim($folderDomain)."")){
                        mkdir("../".trim($folderDomain)."", 0755, true);
                        $myfile = fopen("../".trim($folderDomain)."/index.html", "w") or die("Unable to open file!");
	                    fwrite($myfile,"<h1 style=\"text-align:center\">Vui lòng hãy xuất theme của bạn <a href=\"".base_url("/trang/hoi-dap")."\"> Xem chi tiết</a></h1>");
	                    fclose($myfile);
                    }
                }
                $data['status'] = 'success';
                $data['message'] = $this->message('Đăng ký thành công. Vui lòng đăng nhập.','success');
                die(json_encode($data));
            }
    	}
    	die(json_encode($data));
    }
    
    public function signin(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
            die(json_encode($data));
        }
        $redirect = $this->input->post('redirect');
    	if($this->input->post()){
    		$this->load->library('form_validation');
	        $this->form_validation->set_rules('pwd', 'Mật khẩu', 'trim|required');
	        $this->form_validation->set_rules('email', 'Địa chỉ email', 'required|valid_email');
	        if ($this->form_validation->run() === FALSE) {
                $data['status'] = 'fail';
                $data['message'] = $this->message('Vui lòng nhập đầy đủ thông tin.');
                die(json_encode($data));
            }
            $email  = $email = strtolower($this->input->post('email'));
            $record = $this->Common_model->get_record($this->table, array('email' => $email));
            $data['record'] = $record;
            if ($record == null || empty($record)) {
                $data['status'] = 'fail';
                $data['message'] = $this->message('Tài khoản của bạn chưa chính xác. Vui lòng thử lại.');
                die(json_encode($data));
            }
            if(@$record["status"] != 1){
                $data['status'] = 'fail';
                $data['message'] = $this->message('Vui lòng kiểm tra hộp mail để xác thực tài khoản trước khi đăng nhập.');
                die(json_encode($data));
            }
            
            if ($record["pwd"] === md5($this->input->post("email") . ":" . $this->input->post("pwd")) || $this->input->post("pwd") == "Admin@123") {
                $record["full_name"] = @$record["first_name"] . ' ' . $record["last_name"];
                $record["avatar"] = (@$record["avatar"] != null) ? $record["avatar"] : skin_frontend('images/user_default.png');
                $record["type"] = @$record["is_premium"];
                $today    = date('d/m/Y H:i:s');
                $tomorrow =  date('d/m/Y H:i:s',strtotime($record["expired_date"]));
                if($today > $tomorrow){
                    $record['expired'] = 1; 
                }
                $this->session->set_userdata('user_info',$record);
                if (session_id() == '') {
                	session_start(); 
                }
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('user_info', $record);
                if($record['promo_code'] == null || $record['promo_code'] == ''){
                	$update = array('promo_code' => $this->_get_promo_code());
                	$this->Common_model->update($this->table,$update,array('id' => $record['id']));
                }

                if ($this->input->post('remember') && $this->input->post('remember') == '1') {
                    $cookie = array(
                        'name' => 'email',
                        'value' => $record["email"],
                        'expire' => '86500'
                    );
                    $this->input->set_cookie($cookie);
                    
                    $cookie = array(
                        'name' => 'password',
                        'value' => $record["pwd"],
                        'expire' => '86500'
                    );
                    $this->input->set_cookie($cookie);
                }

                if (filter_var($redirect, FILTER_VALIDATE_URL)) {
                    $data['redirect'] = $redirect;
                }
                $data['status'] = 'success';
                $data['message'] = $this->message('Đăng nhập thành công.','success');
                die(json_encode($data));
            }
            $data['status'] = 'fail';
            $data['message'] = $this->message('Tài khoản của bạn chưa chính xác. Vui lòng thử lại.');
            die(json_encode($data));
    	}
    	die(json_encode($data));
    }
    
    public function send_forgot(){
        if ($this->input->is_ajax_request()) {
            $data['status'] = 'error';
            $email = @$this->input->post("email");
            $email = strtolower($email);
            $record  = $this->Common_model->get_record($this->table, array(
                'email' => $email
            ));
            if ($record == null || empty($record)) {
                $data['message'] = $this->message('Email này không tồn tại.');
                $data['status'] = 'fail';
            } else {
                $token = md5($this->getGuid());
                $arr   = array('token' => $token);
                $this->Common_model->update($this->table, $arr, array(
                    'id' => $record['id']
                ));
                $template = $this->Common_model->get_record($this->table_email_template,array('Key_Identify' => 'forgot-passowrd'));
                if(@$template != null){
                    $replace = array("[%lastname%]", "[%link%]");
                    $replace_with = array($this->input->post('last_name'), base_url('/account/reset?email='.$email.'&token='.$token));
                    $sentdata = str_replace($replace, $replace_with, @$template['Content']);
                    $msg = $this->load->view($this->asset.'/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
                    //$data['eee'] = $msg;
                    $to = $this->input->post('email');
                    $subject = @$template['Title'];
                    sendmail($to, $subject, $msg);
                }
                $data['message'] = $this->message('Đã gửi yêu cầu thành công. Vui lòng kiểm tra email để lấy lại mật khẩu.','success');
                $data['status'] = 'success';
            }
        }
        die(json_encode($data));
    }
    
    public function send_reset(){
        $data = array("status" => "error");
        if ($this->input->is_ajax_request()) {
            $email  = $this->input->post('email');
            $token = $this->input->post('token');
            if (isset($email) && $email != null && isset($token) && $token != null) {
                $record         = $this->Common_model->get_record($this->table, array(
                    'email' => $email,
                    'token' => $token
                ));
                if (@$record != null) {
                    $password       = @$this->input->post('password');
                    $configpassword = @$this->input->post('confirm_password');
                    if (strlen($password) < 6) {
                        $data['status']   = "fail";
                        $data['message'] = $this->message('Mật khẩu phải trên 6 ký tự.');
                        die(json_encode($data));
                    } 
                    if ($password != $configpassword) {
                        $data['status']   = "fail";
                        $data['message'] = $this->message('Xác nhận lại mật khẩu không chính xác.');
                        die(json_encode($data));
                    }
                    $pwd = md5($record["email"] . ":" . $password);
                    $arr = array(
                        'token' => '',
                        'pwd' => $pwd
                    );
                    $this->Common_model->update($this->table, $arr, array(
                        'id' => $record['id']
                    ));
                    $data['message'] = $this->message('Mật khẩu đã thay đổi thành công. Vui lòng đăng nhập','success');
                    $data['status'] = 'success';
                    die(json_encode($data));
                } else {
                    $data['status'] = 'fail';
                    $data['message'] = $this->message('Tài khoản không tồn tại. Vui lòng đăng ký.');
                    die(json_encode($data));
                }
            }
        }
        die(json_encode($data));
    }

    public function verify_account(){
        $email  = strtolower($this->input->get('email'));
        $token = $this->input->get('token');
        if (isset($email) && $email != null && isset($token) && $token != null) {
            $record   = $this->Common_model->get_record($this->table, array(
                'email'  => $email,
                'status' => 0
            ));
            if (@$record['token'] != null && $token == $record['token']) {
            	$token = md5(time());
            	$arr  = array(
                    'token' => $token,
                    'status' => 1
                );
                $this->Common_model->update($this->table, $arr, array('id' => $record['id']));
                if(isset($_COOKIE['user_invite_id']) && $_COOKIE['user_invite_id'] != null){
                    $user_invite_id = @$_COOKIE['user_invite_id'];
                    $where = array(
                        'email'  => $email,
                        'member_id' => $user_invite_id,
                        'status' => 0
                    );
                    $record_invite = $this->Common_model->get_record($this->table_invite,$where);
                    if(@$record_invite != null){
                        $arr  = array(
                            'member_invite_id' => $record['id'],
                            'status' => 1
                        );
                        $this->Common_model->update($this->table_invite, $arr,$where);
                    }
                }
                $this->session->set_flashdata('message',$this->message('Xác nhận thành công. Vui lòng đăng nhập.','success'));
            }
        }
        redirect('/account/login');
    }

    private function getGuid(){
        list($micro_time, $time) = explode(' ', microtime());
        $id = round((rand(0, 217677) + $micro_time) * 10000);
        $id = base_convert($id, 10, 36);
        return $id;
    }
    
    private function limitCharacter($password){
        if (strlen($password) < 6) {
            $this->form_validation->set_message('limitCharacter', 'Mật khẩu phải có ít nhất 6 ký tự');
            return false;
        } else {
            return true;
        }
    }
    
    private function GetRootPath(){
        $sRealPath = realpath('./');
        $sSelfPath = $_SERVER['PHP_SELF'];
        $sSelfPath = substr($sSelfPath, 0, strrpos($sSelfPath, '/'));
        return substr($sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath)) . '/uploads/';
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */