<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Home extends Frontend_Controller{
	private $table = '';
	private $table_advertisement = '';

	public function __construct(){
        parent::__construct();
        $this->table = $this->table_prefix."package";
        $this->table_advertisement = $this->table_prefix."advertisement";
    }

	public function index(){
        if(isset($_GET['oauth_verifier']) && $_GET['oauth_verifier'] != null && isset($_GET['oauth_token']) && $_GET['oauth_token'] != null ){
            $this->session->set_userdata('oauth_verifier', $_GET['oauth_verifier']);
            $this->session->set_userdata('oauth_token', $_GET['oauth_token']);
            $this->session->set_userdata('type', 'yahoo');
            redirect('/invite/');
        }
        if(@$this->user_id){
            $this->data["packages"] = $this->Common_model->get_result($this->table,["status" => 1,'is_default' => 0]);
        }
        else{
            $this->data["packages"] = $this->Common_model->get_result($this->table,["status" => 1]);
        }
        $packages = [];
        foreach ($this->data["packages"] as $key => $value) {
            $id = $value["id"];
            $sql = "select tbl1.*, tbl2.id as is_connect from {$this->table_prefix}package_options as tbl1 left join {$this->table_prefix}package_selects as tbl2 on tbl2.option_id = tbl1.id and package_id = {$id} order by tbl1.id ASC , tbl2.sort ASC";
            $value["options"] = $this->Common_model->query_raw($sql);
            $packages[] = $value;
        }
        $this->data["packages"] = $packages;
        $this->data["testimonials"] = $this->Common_model->get_result($this->table_prefix."testimonial",["status" => 1,'lang' => $this->langId]);
        $this->data["num_day"] = @$this->data['setting']['num_day'];
		

        $this->db->select("tbl1.* , tbl2.full AS hero_image");
        $this->db->from($this->table_prefix."theme_themes AS tbl1");
        $this->db->join($this->table_prefix."theme_medias AS tbl2","tbl2.id = tbl1.thumb","left");
        $this->db->where(["tbl1.is_system" => 1 ,"tbl1.public" => 1 ,"tbl1.status" => 1,'version' => 3]);
        $this->db->limit(5);
        $this->data["themes"] = $this->db->get()->result_array();


        $this->db->select("tbl1.* , tbl2.full AS hero_image, tbl3.sub_domain");
        $this->db->from($this->table_prefix."theme_themes AS tbl1");
        $this->db->join($this->table_prefix."theme_medias AS tbl2","tbl2.id = tbl1.thumb","left");
        $this->db->join($this->table_prefix."member AS tbl3","tbl3.id = tbl1.member_id");
        $this->db->where(["tbl1.is_active" => 1 ,"tbl1.status" => 1, "tbl3.sub_domain!=" => ""]);
        $this->db->group_by('tbl1.id'); 
        $this->db->order_by('tbl1.id','DESC');
        $this->db->limit(0,10);
        $this->data["themes_user"] = $this->db->get()->result_array();


        $this->data["advertisement"] = $this->Common_model->get_record($this->table_advertisement,array("status" => 1,'is_home' => 1),null,null,array('id' => 'RANDOM'));

        $this->load->view($this->asset.'/home/index',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}

    public function closewindown(){
    	$js_close = '<script type=\'text/javascript\'>window.close();</script>';
        echo $js_close;
        die;
    }
    public function setlang(){
        require_once FCPATH.'application/hooks/Hook_Languages.php';
        $slug = $this->input->post("slug");
        $l    = new Hook_Languages(1);
        $l->set_cookie($slug); 
        die(json_encode(["status" => 1]));
    }
    public function collaborators(){
        $per_page = $this->per_page;
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ; 
        $this->db->select("tbl1.*, count(tbl2.id) AS number_inver"); 
        $this->db->from($this->table_prefix."member as tbl1");
        $this->db->join($this->table_prefix.'invite as tbl2',"tbl1.id = tbl2.member_id");
        $this->db->group_by("tbl2.member_id");
        $this->db->where("tbl1.status",1);
        $this->db->limit($per_page,$offset);
        $this->data["results"] = $this->db->get()->result_array();  
        $count = $this->Common_model->count_table($this->table_prefix."member",["is_dealer" => 1,"status" => 1]);
        $config['base_url'] = base_url('cong-tac-vien');
        $config['total_rows'] = $count;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->load->view($this->asset.'/home/collaborators',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
    }
}
