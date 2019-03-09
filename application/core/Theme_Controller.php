<?php 
class Theme_Controller extends CI_Controller{
    public $data      = null;
    public $user_id = 0;
    public $_menu     = '';
    public $asset 	= FRONTEND;
    public $per_page = 20;
    public $table_prefix = TABLE_FIX;

   
    public function __construct() {
        parent::__construct();
        if($this->input->cookie('email', false) && $this->input->cookie('password', false)){
            $email = $this->input->cookie('email', false);
            $pwd = $this->input->cookie('password', false);
            $record = $this->Common_model->get_record($this->table_prefix.'member', array('email' => $email));
            if (@$record != null && $record["pwd"] === $pwd) {
                $this->session->set_userdata('is_login', TRUE);
                $this->session->set_userdata('user_info', array(
                    'email' => $record["email"],
                    'id' => ($record["id"]) ? $record["id"] : $record["ID"],
                    'full_name' => $record["first_name"] . ' ' . $record["last_name"],
                    'avatar' => (@$record["avatar"] != null) ? $record["avatar"] : skin_frontend('images/user_default.png'),
                    'type' => @$record['is_premium']
                ));
            }
        }
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = (@$this->data['user']['id']) ? $this->data['user']['id'] : $this->data['user']['ID'];
        }
        if($this->router->fetch_class() == 'home' && $this->router->fetch_method() == 'index'){
            $this->data['is_home'] = true;
        }
        if(!$this->input->is_ajax_request()){
            $this->get_setting();
            $this->get_title();
        }
        if (!$this->input->is_ajax_request() && @$this->data["hiddenHeader"] != TRUE) {
            $this->load->view($this->asset.'/block/header_theme',$this->data);
        }
        if($this->input->get('code_invite')){
            $user_invite_id = base64_decode($this->input->get('code_invite'));
            $record = $this->Common_model->get_record($this->table_prefix.'member',array('id' => $user_invite_id));
            if(@$record != null){
                setcookie('user_invite_id', $user_invite_id, time() + (86400 * 30), "/");
            }
        }
        $this->data['asset'] = $this->asset;
        $this->load->helper(array('url','form'));
    }
    public function __destruct(){
        if (!$this->input->is_ajax_request()) {
            echo($this->load->view($this->asset.'/block/footer_theme',$this->data,true));
        }
    }

    public function check_login(){
        if (!$this->session->userdata('user_info')) {
            $link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
            redirect(base_url('/account/login/?redirect='.urlencode($link)));
        }
    }

    private function get_setting() {
        $record = $this->Common_model->get_record($this->table_prefix.'web_setting');
        $this->data['setting'] = json_decode(@$record['Body_Json'],true);
        $this->data['menu'] = '';
        if(@$this->data['setting']['menu'] != null){
            $menu_data = $this->Menu_model->get_list_menu_group($this->table_prefix.'menu',@$this->data['setting']['menu']);
            $this->data['menu'] = $this->Menu_model->show_menu(0,$menu_data,0,'navbar-nav mr-auto');
        }
    }
    
    private function get_title() {
    	$query_string = $this->uri->uri_string();
    	$this->data['title_page'] = "";
    	if ($query_string != "" && $query_string != "/") {
    		$query_string = "/" . $query_string;
    		$record = $this->Common_model->get_record($this->table_prefix.'menu',array('Url' => $query_string));
	    	if ($record != null) {
	    		$this->data['title_page'] = $record['Name'];
	    	} else {
	    		switch ($query_string) {
	    			case "/profile":
	    				$this->data['title_page'] = "Thông tin cá nhân";
	    				break;
	    		}
	    	}
        }
    }

    public function _editor($path,$height) {
        //Loading Library For Ckeditor
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        //configure base path of ckeditor folder 
        $this->ckeditor->basePath = base_url().'skins/js/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'en';
        $this->ckeditor->config['height'] = $height;
        //configure ckfinder with ckeditor config 
        $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
    }

    public function message($message = '',$status = ''){
        if($status == 'success'){
            return '<div class="alert alert-success">'.$message.'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>';   
        }
        else{
            return '<div class="alert alert-danger">'.$message.'</div>';
        }
    }
}