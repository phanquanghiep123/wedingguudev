<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Groups extends MY_Controller {
  public $_fix   = "theme_";
  public $_table = "groups_background_music";
  public $_view  = "backend/themes/group_bg_ms";
  public $_cname = "themes/groups";
  public $_model = "Groups_background_music_model";
  public $_data  = [];
	public function __construct(){
		parent::__construct();
      ini_set('max_execution_time', 0);
      $this->session->set_flashdata('post',$this->input->post());
      $this->session->set_flashdata('get',$this->input->get());
      $this->_data["base_controller"] = ($this->_cname);
	}
	public function index (){
		$limit = 20;
		$offset = $this->input->get("per_page") ? $this->input->get("per_page") : 0;
		$this->_data["tables"] = $this->Common_model->get_result($this->_fix.$this->_table,[],$offset,$limit);
		$total_rows = $this->Common_model->count_table($this->_fix.$this->_table);
		$this->load->library('pagination');
		$config['base_url']   = backend_url($this->_cname);
		$config['total_rows'] = $total_rows;
		$config['per_page']   = $limit;
		$config['page_query_string'] = true;
    $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
    $config['full_tag_close'] = '</ul></nav>';
    $config['num_links'] = 5;
    $config['page_query_string'] = TRUE;
    $config['prev_link'] = '&lt; Prev';
    $config['prev_tag_open'] = '<li class="page-item">';
    $config['prev_tag_close'] = '</li>';
    $config['next_link'] = 'Next &gt;';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="page-item active"><a href="#">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['first_link'] = FALSE;
    $config['last_link'] = FALSE;
		$this->_data["action_create"] = backend_url($this->_cname."/create");
		$this->pagination->initialize($config);
		$this->_data["_cname"] = backend_url($this->_cname);
		$this->load->view($this->_view . "/index",$this->_data);
	}
	public function create (){
		$this->_data["action_save"] = backend_url($this->_cname."/save_create");
		$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
	public function edit($id){
	  $this->_data["action_save"] = backend_url($this->_cname."/save_edit/".$id);
      $item      = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
      $get_media = $this->Common_model->get_record($this->_fix ."medias",["id" =>  $item['thumb']]);
      $item["path_name"]   = $get_media["name"];
      $this->_data["post"] = $item;
      $this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
	public function save_create (){
	  $this->load->library('form_validation');
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('type', 'Danh cho', 'required');
      $this->form_validation->set_rules('status', 'Trạng thái', 'required');
      if ($this->form_validation->run() !== FALSE)
      {
        $columns = $this->db->list_fields($this->_fix.$this->_table);
        $data_post = $this->input->post();
        $data_insert = array();
        foreach ($data_post as $key => $value) {
          if(in_array($key, $columns)){
            $data_insert[$key] = $value;
          }              
        }
        $id = $this->Common_model->add($this->_fix.$this->_table,$data_insert);  
        redirect(backend_url($this->_cname.'/edit/' . $id ."?action=create&status=success"));
      }else
      {
        redirect(backend_url($this->_cname.'/create/'."?action=create&status=error"));
      }
	}
	public function save_edit ($id){
	  $this->load->library('form_validation');
      $this->form_validation->set_rules('name', 'Name', 'required');
      $this->form_validation->set_rules('type', 'Danh cho', 'required');
      $this->form_validation->set_rules('status', 'Trạng thái', 'required');
      if ($this->form_validation->run() !== FALSE)
      {
        $columns = $this->db->list_fields($this->_fix.$this->_table);
        $data_post = $this->input->post();
        $data_insert = array();
        foreach ($data_post as $key => $value) {
          if(in_array($key, $columns)){
            $data_insert[$key] = $value;
          }              
        }
        $id = $this->Common_model->update($this->_fix.$this->_table,$data_insert,["id" => $id]);  
        redirect(backend_url($this->_cname.'/edit/' . $id ."?action=create&status=success"));
      }else
      {
        redirect(backend_url($this->_cname.'/create/'."?action=create&status=error"));
      }
	}
	public function delete($id){
	  $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
      if($this->input->is_ajax_request()){
        $this->Common_model->delete($this->_fix.$this->_table,["id" => $id]);
        $data ["status"] = "success";
      }  
      die( json_encode($data) );
	} 
}