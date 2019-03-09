<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Backgrounds extends MY_Controller {
	public $_fix   = "theme_";
	public $_table = "background_music";
	public $_view  = "backend/themes/background_music";
	public $_cname = "themes/backgrounds";
	public $_model = "Background_music_model";
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
		$this->load->model($this->_model);		
		$this->_data["tables"] = $this->{$this->_model}->get(["tbl1.type" => 0],$offset,$limit,[["field"=>"id","sort"=>"DESC"]]);
		$total_rows = $this->Common_model->count_table($this->_fix.$this->_table);
		$this->load->library('pagination');
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
		$this->_data["_cname"] = backend_url($this->_cname);
		$this->pagination->initialize($config);
		$this->load->view($this->_view . "/index",$this->_data);
	}
	public function create (){
		$groups = $this->Common_model->get_result($this->_fix."groups_background_music");
		$this->_data["groups"] = $groups;
		$this->_data["action_save"] = backend_url($this->_cname."/save_create");
		$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
	public function edit($id){
		$this->_data["action_save"] = backend_url($this->_cname."/save_edit/".$id);
		$groups = $this->Common_model->get_result($this->_fix."groups_background_music");
		$this->_data["groups"] = $groups;
    	$b = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
    	$m = $this->Common_model->get_record($this->_fix."medias",[ "id" => $b["media_id"] ]);
    	if($m&&$b){
    		$this->_data["post"] = array_merge($m,$b);
    		$this->_data["post"]["media_name"] = $m["name"];
    		
    	}
    	$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
	public function save_create (){
		$this->load->library('form_validation');
		 $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('status', 'Trạng thái', 'required');
	    $this->form_validation->set_rules('media_name', 'Trạng thái', 'required');
	    $this->form_validation->set_rules('group_id', 'Trạng thái', 'required');
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
	    $this->form_validation->set_rules('status', 'Trạng thái', 'required');
	    $this->form_validation->set_rules('media_name', 'Trạng thái', 'required');
	    $this->form_validation->set_rules('group_id', 'Trạng thái', 'required');
	    if ($this->form_validation->run() !== FALSE)
	    {
	      $columns = $this->db->list_fields($this->_fix.$this->_table);
	      $data_post = $this->input->post();
	      $data_update = array();
	      foreach ($data_post as $key => $value) {
	        if(in_array($key, $columns)){
	          $data_update[$key] = $value;
	        }              
	      }
	      $this->Common_model->update($this->_fix.$this->_table,$data_update,["id" => $id]);  
	      redirect(backend_url($this->_cname.'/edit/' . $id ."?action=update&status=success"));
	    }else
	    {
	      redirect(backend_url($this->_cname.'/edit/'. $id ."?action=update&status=error"));
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