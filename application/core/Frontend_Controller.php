<?php 
class Frontend_Controller extends CI_Controller{
    public $data      = null;
    public $user_id = 0;
    public $_menu     = '';
    public $asset 	= FRONTEND;
    public $per_page = 20;
    public $table_prefix = TABLE_FIX;
    public $js_ajax = false;
    public $load_c;

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
            $this->load->view($this->asset.'/block/header',$this->data);
        }
        if($this->input->get('code_invite')){
            $user_invite_id = base64_decode($this->input->get('code_invite'));
            $record = $this->Common_model->get_record($this->table_prefix.'member',array('id' => $user_invite_id));
            if(@$record != null){
                setcookie('user_invite_id', $user_invite_id, time() + (86400 * 30), "/");
            }
        }
        $this->js_ajax = $this->input->is_ajax_request();
        $this->load_c = $this->load;
        $this->data['asset'] = $this->asset;
        $this->load->helper(array('url','form'));
    }

    public function __destruct(){
        if (!$this->input->is_ajax_request() && @$this->data["hiddenFooter"] != TRUE) {
            echo $this->load->view($this->asset.'/block/footer',$this->data,true);
        }
    }

    public function get_config_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        if(isset($array_init['page_query_string']) && $array_init['page_query_string']){
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'offset';
        }
        return $config;
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

    public function _get_promo_code(){
        for ($i = 0; $i < 1000; $i++) { 
            $promo_code = $this->creatPromoCode(10); 
            $user = $this->Common_model->get_record($this->table_prefix.'member',array('promo_code' => $promo_code));
            if(!(isset($user) && $user != null)){
                return $promo_code;
            }
        }
        return '';
    }

    private function creatPromoCode($length = 10){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < $length; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $res;
    }
}