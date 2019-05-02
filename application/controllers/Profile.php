<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Profile extends Frontend_Controller {
    private $table = '';
    private $table_package = '';
    private $table_member_package = '';
    public $_fix    = "theme_";
    public $_table  = "themes";
    public $_view   = "frontend/appthemes";
    public $_cname  = "themes/appthemes";
    public $_model  = "Themes_model";
    public $_data   = [];
    public $_user_id = 0;
	public function __construct(){
        $this->data["hiddenHeader"] = TRUE;
        parent::__construct();
        $this->check_login();
        $this->table_member_package = $this->table_prefix.'member_package';
        $this->table_package = $this->table_prefix.'package';
        $this->table = $this->table_prefix.'member';
        $this->data['user'] = $this->session->userdata('user_info');
        $this->user_id = @$this->data['user']['id'] ? @$this->data['user']['id'] : 0;
        $this->data['user_id'] = $this->user_id;
    }

	public function index(){ 
        $user = $this->Common_model->get_record($this->table,array('id' => $this->user_id));
        if($this->input->post()){
            $data['status'] = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('last_name', '[{]FULL_NAME[}]', 'required|trim');
            $this->form_validation->set_rules('gender', '[{]PROFILE_GENDER[}]', 'required|trim');
            $this->form_validation->set_rules('sub_domain', '[{]PROFILE_SUB_DOMAIN[}]','trim|is_unique[member.sub_domain.id.'.$this->user_id.']');
            $this->form_validation->set_rules('domain', '[{]PROFILE_DOMAIN[}]', 'trim|is_unique[member.domain.id.'.$this->user_id.']');
            if ($this->form_validation->run() == FALSE) {
                $data['status']  = 0;
                $data['message'] = $this->form_validation->error_array();
            } else {
            	$date = str_replace('/', '-', $this->input->post('wedding_date'));
                $arr = array(
                    'last_name' => $this->input->post('last_name'),
                    'gender' => $this->input->post('gender'),
                    'phone' => $this->input->post('phone'),
                    'wedding_date' => date('Y-m-d',strtotime($date)),
                    'is_dealer' => $this->input->post('is_dealer') == 1 ? 1 : 0
                );
            	$subdomain = strtolower($this->input->post('subdomain'));
            	if($subdomain != null){
            		if (!ctype_alnum($subdomain)){
		                $data['status'] = 0;
                        $data['message']["subdomain"] = "[{]VALIDATE_DOMAIN[}]";
		            }
		            $record = $this->Common_model->get_record($this->table, array(
		                'sub_domain' => $subdomain
		            ));
		            if (isset($record) && $record != null){
		                $data['status'] = 0;
                        $data['message']["subdomain"] = "[{]VALIDATE_SUBDOMAIN_EXIST[}]";
		            }
		            $arr['sub_domain'] = $subdomain;
            	}
            	if($this->input->post('domain')){
            		$record = $this->Common_model->get_record($this->table, array(
		                'domain' => $this->input->post('domain')
		            ));
		            if (isset($record) && $record != null){
                        $data['status'] = 0;
                        $data['message']["domain"] = "[{]VALIDATE_DOMAIN_EXIST[}]";
		            }
		            $arr['domain'] = $this->input->post('domain');
            	}
                $this->Common_model->update($this->table, $arr,array('id' => $this->user_id));
                $data['status'] = 1;
                $data['message'] = "[{]PROFILE_SUCCESS[}]";
            }
            $code = [
                "code" => $data
            ] ;
            return $this->load->view($this->asset.'/appthemes/code',$code); 
        }
        $this->data['title_page'] = "[{]PROFILE[}]";
        $this->data['user1'] = $user;
        $this->load->view($this->asset.'/block/header',$this->data);
		$this->load->view($this->asset.'/profile/index',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}

    public function wall(){
        $this->data["hiddenHeader"] = TRUE;
        $this->data["hiddenFooter"] = TRUE;
        $theme = $this->Common_model->get_record($this->_fix."themes",["member_id" => $this->user_id,"is_active" => 1,'status' => 1]);
        if($theme == null) redirect(base_url());
        $thumb = $this->Common_model->get_record($this->_fix."medias",["id" => $theme["thumb"]]);
        list($width, $height, $type, $attr) = getimagesize(base_url($thumb["thumb"]));
        $metas = '<meta property="og:image" content="'.base_url($thumb["thumb"]).'"/>';
        $metas = '<meta property="og:image:width" content="'.$width.'"/>';
        $metas = '<meta property="og:image:height" content="'.$height.'"/>';
        $metas .= '<link rel="image_src" type="image/jpeg"  href="'.base_url($thumb["thumb"]).'" />';
        $metas .= '<meta property="og:description" content="'.$theme["description"].'" />';
        $metas .= '<meta property="og:title" content="'.$theme["name"].'"/>';
        $this->data["post"]["is_create"] = 2;
        $this->data["post"]["id"]  = $theme["id"];
        $this->data["action_save"] = $this->_cname."/save_view";
        $this->data["containerClass"] = "full-content";
        $this->data["metas"] = $metas;
        $this->data["post"]["sound_URL"] = @$sound["path"];
        $sound = $this->Common_model->get_record($this->_fix."medias",["id" => $theme["sound_file"]]);
        $this->_data["post"]["sound_URL"] = @$sound["path"];
        $this->load->view($this->_view ."/block/header",$this->data);
        $this->load->view($this->_view . "/wall",$this->data);
    }

	public function change_password(){
        $user = $this->Common_model->get_record($this->table,array('id' => $this->user_id));
        if($this->input->post()){
            $data['status'] = 0;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pwd','[{]PROFILE_PASSWORD[}]','required|trim|min_length[6]');
            $this->form_validation->set_rules('new_password','[{]PROFILE_NEW_PASSWORD[}]','required|trim|min_length[6]|matches[configure_new_password]');
            $this->form_validation->set_rules('configure_new_password','[{]PROFILE_CF_PASSWORD[}]','required|trim|min_length[6]');
            $password   = $this->input->post('pwd');
            $new_password = $this->input->post('new_password');
            $configure_new_password = $this->input->post('configure_new_password');
            if ($this->form_validation->run() == FALSE) {
                $data['status']  = 0;
                $data['message'] = $this->form_validation->error_array();
            }
            else if($user['pwd'] != md5($user['email'] . ':' . $password)){
                $data['status']  = 0;
                $data['message']["pwd"] = '[{]VALIDATE_PASSWORD_NOT_MATCH[}]';
                
            } else {
                $arr   = array(
                    'pwd' => md5($user['email'] .':'.$new_password)
                );
                $data['status']  = 1;
                $this->Common_model->update($this->table, $arr,array('id' => $this->user_id));
                $data['message']="'[{]UPDATE_PASSWORD_SUCCESS[}]";
            }
            $code = [
                "code" => $data
            ] ;
            return $this->load->view($this->asset.'/appthemes/code',$code); 
        }
        $this->load->view($this->asset.'/block/header',$this->data);
		$this->load->view($this->asset.'/profile/password',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}

    public function payment_history(){
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $per_page = $this->per_page;
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $sql = "SELECT mp.*,p.name,m.first_name,m.last_name
                FROM {$this->table_member_package} AS mp 
                INNER JOIN {$this->table} AS m ON mp.member_id = m.id 
                INNER JOIN {$this->table_package} AS p ON mp.package_id = p.id 
                WHERE m.id = '{$this->user_id}'
                ORDER BY mp.id DESC
                LIMIT $offset,$per_page";

        $sql_count = "SELECT count(mp.id) AS count
                FROM {$this->table_member_package} AS mp 
                INNER JOIN {$this->table} AS m ON mp.member_id = m.id 
                INNER JOIN {$this->table_package} AS p ON mp.package_id = p.id 
                WHERE m.id = '{$this->user_id}' ";

        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('/profile/payment_history/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->data["title_page"] = "[{]payment_history[}]";
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["package"] = $this->Common_model->query_raw($sql);
        $this->load->view($this->asset.'/block/header',$this->data);
        $this->load->view($this->asset.'/profile/payment',$this->data);
        $this->load->view($this->asset ."/block/footer",$this->data);
    }

    public function save_media() {
        $data = array('status' => 'error');
        $record = $this->Common_model->get_record($this->table, array('id' => $this->user_id));
        if ($this->input->is_ajax_request() && isset($record['id']) && $record['id'] != null) {
            if (isset($_FILES['fileupload']) && is_uploaded_file($_FILES['fileupload']['tmp_name'])) {
                $output_dir = FCPATH."/uploads/user/";
                $output_url = "/uploads/user/";
                if (!file_exists($output_dir)) {
                    mkdir($output_dir, 0775);
                }
                $filename = $_FILES['fileupload']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION); //type image
                $RandomNum = time();
                $ImageName = str_replace(' ', '-', strtolower($_FILES['fileupload']['name']));
                $ImageType = $_FILES['fileupload']['type']; //"image/png", image/jpeg etc.
                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                $ImageExt = str_replace('.', '', $ImageExt);
                $ImageName = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                if (move_uploaded_file($_FILES["fileupload"]["tmp_name"], $output_dir . $NewImageName)) {
                    $data1 = crop_image($NewImageName, $ext, $output_url);
                    if ($data1["status"] = "success") {
                        if(isset($record['avatar']) && $record['avatar'] != null){
                            @unlink('.'.$record['avatar']);
                        }
                        $arr = array(
                            'avatar' => $output_url . $data1["name"]
                        );
                        $this->Common_model->update($this->table, $arr, array('id' => $this->user_id));
                        $data['name'] = $output_url . $data1["name"];
                        $this->data['user']['avatar'] = $data['name'];
                        $this->session->set_userdata('user_info',$this->data['user']);
                        $data["status"] = "success";
                    }
                }
            }
        }
        die(json_encode($data));
    }

    public function logout(){
        $this->load->helper('cookie');
        $this->session->sess_destroy();
        delete_cookie('email');
        delete_cookie('password');
        redirect(base_url('/'));
    }

}
