<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('get_account'))
{
    function login_account($record)
    {
    	$session_id = md5(uniqid());
    	$this->session->set_userdata('session_id', $session_id);
        $this->session->set_userdata('is_login', TRUE);
        $this->session->set_userdata('user_info', array(
            'email' => $record["email"],
            'id' => $record["id"],
            'full_name' => $record["first_name"] . ' ' . $record["last_name"],
            'avatar' => (@$record["avatar"] != null) ? $record["avatar"] : skin_frontend("images/user_default.png")
        ));
        // Save history
        $arr = array(
            'member_id' => $record["id"],
            'ip_address' => $_SERVER['REMOTE_ADDR'],
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            'create_date' => date('Y-m-d H:i:s'),
        	'session_id' => $session_id
        );
        $this->Common_model->add($this->table_login_history, $arr);
        // =====================
    }
    
    function register_account($post)
    {
    	$arr = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'avatar' => $picture_url,
            'pwd' => md5($email . ':' . time()),
            'status' => 1,
            'phone' => '',
            'expired_date' => date('Y-m-d')
        );
        $id = $this->Common_model->add($this->table, $arr);
        $this->session->set_userdata('is_login', TRUE);
        $this->session->set_userdata('user_info', array(
            'email' => $email,
            'id' => $id,
            'full_name' => $first_name . ' ' . $last_name,
            'address' => '',
            'avatar' => (@$picture_url != null) ? $picture_url : skin_frontend("images/user_default.png")
        ));
        // =====================
    }
}
