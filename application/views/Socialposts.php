<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Socialposts extends CI_Controller
{
	private $user_id=null;
	private $user_info = null;
    private $is_login = false;
    private $data;
	private $record_get_children = array();
	public function __construct()
    {
        parent::__construct();
        if($this->session->userdata('user_info')){
        	$this->is_login=true;
        	$this->user_info = $this->session->userdata('user_info');
        	$this->user_id   = $this->user_info["id"];
        }else if(!$this->session->userdata('user_sr_info')){
        	redirect('/');
        }
        $this->data["is_login"] = $this->is_login;
        $this->data['skins']='services';
    }
    public function view($id){
        $this->load->view('block/header',$this->data);
        $this->load->view('socialposts/index',$this->data);
        $this->load->view('block/footer',$this->data);
    }
    
}