<?php 
class MY_Controller extends CI_Controller{
    public $data      = null;
    public $is_login  = false;
    public $user_info = null;
    public $_menu     = '';
    public $backend_asset = BACKEND;
    public $per_page = 30;
    public $table_prefix = 'ewd_';
    public $message_add_succes = 'Tạo mới thành công';
    public $message_update_succes = 'Cập nhật thành công';
    public $message_delete_succes = 'Xóa thành công';

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
        }
        $this->is_login();
        $this->data["_menu"] = "";
        if (!$this->input->is_ajax_request()) {
            $this->check_module();
            $this->data["_menu"] = $this->_menu;
        }
        $this->data["admin_info"] = $this->user_info;
        $this->data["is_login"]   = $this->is_login;
        $this->data['post'] = $this->input->post();
        $this->data['get'] = $this->input->get();
        $this->data['backend_asset'] = $this->backend_asset;
        if (!$this->input->is_ajax_request()) {
            $this->load->view($this->backend_asset.'/includes/header',$this->data);
        }
    }

    public function __destruct(){
        if (!$this->input->is_ajax_request()) {
            echo($this->load->view($this->backend_asset.'/includes/footer',$this->data,true));
        }
    }


    private function is_login(){
        if (!$this->is_login) redirect(backend_url('/acounts/login'));
    }

    private function check_module(){
        $rol_model[] = array(
            "ID" => 0,
            "Module_Name"       => "Dashboard",
            "Module_Url"        => "/dashboard",
            "Parent_ID"         => 0,
            "Order"             => 0,
            "Module_Class"      => "dashboard",
            "Icon"              => "fa fa-home"
        );
        
        $rol_model = array_merge($rol_model,$this->Common_model->get_use_rol($this->table_prefix.'sys_modules',$this->table_prefix.'sys_rules',$this->user_info['Role_ID']));
        $check_url = false;
        $resurl = $this->uri->rsegment(1);
        $action = $this->uri->rsegment(2);
        $this->data['is_edit'] = 0;
        $this->data['is_add'] = 0;
        $this->data['is_delete'] = 0;
        foreach ($rol_model as $key => $value) {
            $url = str_replace("////","/", $value["Module_Url"]);
            $url = str_replace("///","/", $value["Module_Url"]);
            $url = str_replace("//","/", $value["Module_Url"]);
            $arg = explode("/",$url);
            $arg = array_values(array_diff($arg,array("")));
            if ($arg[0] == $resurl) {
                $this->data["title_page"] = $value["Module_Name"];
                if($action == 'edit' && $value["Edit"] == 1){
                    $this->data['is_edit'] = 1;
                    $check_url = true;
                    $this->data['label'] = 'Chỉnh sửa';
                }
                else if($action == 'delete' && $value["Delete"] == 1){
                    $this->data['is_delete'] = 1;
                    $check_url = true;
                }
                else if($action == 'create' &&$value["Add"] == 1){
                    $this->data['is_add'] = 1;
                    $check_url = true;
                    $this->data['label'] = 'Thêm mới';
                }
                else if($action == 'index'){
                    $check_url = true;
                }
            }
        }
        if($this->user_info["System"] == "1"){
            $this->data['is_edit'] = 1;
            $this->data['is_add'] = 1;
            $this->data['is_delete'] = 1;
        }
        if($action == 'edit'){
            $this->data['label'] = 'Chỉnh sửa';
        }
        else if($action == 'create'){
            $this->data['label'] = 'Thêm mới';
        }
        if($this->user_info["System"] != "1" && !$check_url) redirect(backend_url()); 
        $this->create_menu($rol_model,0);
    }

    private function create_menu($data,$id = 0){
        $termsList = array();
        $new_listdata = array();
        if ($data != null) { 
            foreach ($data AS $key => $item )
            {
                if ($item['Parent_ID'] == $id)
                {
                    $termsList[] = ($item);
                }
                else
                {
                    $new_listdata[] = ($item);
                }
            }
        }
        if ($termsList != null){   
            if($id == 0){
                $this->_menu .= '<ul class="nav side-menu">';
            }else{
                $this->_menu .= '<ul class="nav child_menu">';
            }
            foreach ($termsList AS $key => $item_2 )
            {
                if(@$item_2["Show"] != "no"){
                    $url = ($item_2["Module_Url"] == "#" || $item_2["Module_Url"] == "") ? "" : ' href = "'. backend_url($item_2["Module_Url"]) . '"';
                    $this->_menu .= '<li class="'.$item_2["Module_Class"].'">';
                    if($id != 0){
                        $this->_menu .= '<a'.$url.'>'.$item_2["Module_Name"].'<span class="fa fa-chevron-down"></span></a>';
                    }else{
                        $this->_menu .= '<a'.$url.'><i class="'.$item_2["Icon"].'"></i>'.$item_2["Module_Name"].'<span class="fa fa-chevron-down"></span></a>';
                    }
                    $this->create_menu($new_listdata, $item_2['ID']);
                    $this->_menu .= '</li>';
                }
                
            }
            $this->_menu .= "</ul>";
        }
    }

    public function _editor($path,$height) {
        //Loading Library For Ckeditor
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        //configure base path of ckeditor folder 
        $this->ckeditor->basePath = skin_url('js/ckeditor/');
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'en';
        $this->ckeditor->config['height'] = $height;
        //configure ckfinder with ckeditor config 
        //$path = skin_url('js/ckfinder/');
        $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
    }

    public function message($message = '',$status = ''){
        if($status == 'success'){
            $this->session->set_flashdata('message','<div class="alert alert-success">'.$message.'<a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a></div>');   
        }
        else{
            $this->session->set_flashdata('message','<div class="alert alert-danger">'.$message.'</div>');
        }
    }

    public function get_config_paging($array_init) {
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
}
