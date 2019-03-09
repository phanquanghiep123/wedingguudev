<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Verify extends CI_Controller
{
    private $is_login = false;
    private $data = array();
    private $table = 'Members';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
    }

    public function verify_bussiness()
    {
    	$email  = $this->input->get('email');
        $token = $this->input->get('token');
        if (isset($email) && $email != null && isset($token) && $token != null) {
            $record         = $this->Common_model->get_record($this->table, array(
                'Email_Business' => $email,
                'Status' => 1
            ));
            if (@$record['Token'] != null && $token == $record['Token']) {
            	$arr  = array(
                    'Token' => '',
                    'Type_Member' => 1
                );
                $this->Common_model->update($this->table, $arr, array(
                    'ID' => $record['ID']
                ));
                if(!$this->session->userdata('is_login')){
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["Email"],
                        'id' => $record["ID"],
                        'type_member' => 1,
                        'full_name' => $record["First_Name"] . ' ' . $record["Last_Name"],
                        'address' => $record["Address"],
                        'avatar' => (@$record["Avatar"] != null) ? $record["Avatar"] : skin_frontend("images/user_default.png")
                    ));
                }
                $this->session->set_userdata('verify_bussiness', TRUE);
            }
        }
        redirect('/');
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */