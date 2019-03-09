<?php

class Medias extends CI_Controller
{
    private $is_login = false;
    private $data = array();
    private $table = 'Members';

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(array('url','form'));
    }

    public function uploads(){
        print_r($_POST);
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */