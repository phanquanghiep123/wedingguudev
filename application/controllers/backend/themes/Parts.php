<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Parts extends MY_Controller {
	public $_fix   = "theme_";
	public $_table = "parts";
	public $_view  = "backend/themes/parts";
	public $_cname = "themes/parts";
	public $_model = "Parts_model";
	public $_data  = [];
	public function __construct(){
		parent::__construct();
		ini_set('max_execution_time', 0);
		$this->session->set_flashdata('post',$this->input->post());
		$this->session->set_flashdata('get',$this->input->get());
		$this->_data["base_controller"] = ($this->_cname);
	}
	public function index(){
	    $limit = 40;
	    $offset = $this->input->post("per_page") ? $this->input->post("per_page") : 0;
	    $this->load->model($this->_model);
	    $this->_data["tables"] = $this->{$this->_model}->get($offset,$limit);
	    $total_rows = $this->Common_model->count_table($this->_fix.$this->_table);
	    $this->load->library('pagination');
	    $config['base_url']   = backend_url($this->_cname);
	    $config['total_rows'] = $total_rows;
	    $config['per_page']   = $limit;
	    $config['page_query_string'] = true;
	    $this->_data["action_create"] = backend_url($this->_cname."/create");
	    $this->pagination->initialize($config);
	    $this->_data["_cname"] = backend_url($this->_cname);
	    $this->load->view($this->_view . "/index",$this->_data);
	}
	public function create(){
		$this->_data["post"] = $this->session->flashdata('post');
		$this->_data["action_save"] = backend_url($this->_cname."/save_create");
		$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
  	public function edit($id){
    	$this->_data["action_save"] = backend_url($this->_cname."/save_edit/".$id);
    	$this->_data["post"] = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
    	$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
	public function delete($id){
	    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
	    if($this->input->is_ajax_request()){
	      $this->Common_model->delete($this->_fix.$this->_table,["id" => $id]);
	      $data ["status"] = "success";
	    }  
	    die( json_encode($data) );
	}
	public function save_create(){
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name', 'Name', 'required');
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
	public function save_edit($id){ 
	    $this->load->library('form_validation');
	    $this->form_validation->set_rules('name', 'Name', 'required');
	    $this->form_validation->set_rules('status', 'Trạng thái', 'required');
	    if ($this->form_validation->run() !== FALSE)
	    {
	      $columns = $this->db->list_fields($this->_fix.$this->_table);
	      $data_post = $this->input->post(null,FALSE);
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
	public function get (){
	    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
	    if($this->input->is_ajax_request()){
	      $id = $this->input->post("id");
	      $column     = $this->input->post("column");
	      $actions    = $this->input->post("actions");
	      $ramkey     = $this->input->post("ramkey");
	      $sort       = $this->input->post("sort");
	      $block_id   = $this->input->post("block_id") ? $this->input->post("block_id") : 0;
	      $theme_section_id   = $this->input->post("theme_section_id") ? $this->input->post("theme_section_id") : 0;
	      $section_block_id = $this->input->post("section_block_id") ?  $this->input->post("section_block_id") : 0;
	      if($id){
	        $this->load->model("Parts_model");
	        $p = $this->Common_model->get_record($this->_fix."parts",["id" => $id]);
	        if($p){ 
	          $default = ($theme_section_id  == 0 && $section_block_id == 0) ? 1 : 0;
	          $data_insert = [
	            "part_id"    => $p["id"],
	            "block_id"   => $block_id,
	            "ramkey"     => $ramkey,
	            "is_default" => $default
	          ];

	          $part_id = $this->Common_model->add($this->_fix."section_block_part",$data_insert);  
	          $meta_id = $this->Common_model->add($this->_fix."block_part_meta",[
	          	"block_part_id"     => $part_id,
	          	"section_block_id"  => $section_block_id,
	          	"theme_section_id"  => $theme_section_id,
	          	"meta_key"          => $p["meta_key"],
	          	"value"             => $p["default_value"],
	          	"media_id"          => $p["default_value"],
	          	"ramkey"            => uniqid()
	          ]);         
	          if($part_id){
	            $insert_data = [
	              "block_part_id"     => $part_id,
	              "section_block_id"  => $section_block_id,
	              "theme_section_id"  => $theme_section_id,
	              "ncolum"            => $column,
	              "sort"              => $sort
	            ];
	            $this->Common_model->add($this->_fix."section_block_part_order",$insert_data);
	            if($actions != null){
	              foreach ($actions as $key => $value) {
	                $insert_data = [
	                  "block_part_id"     => $part_id,
	                  "section_block_id"  => 0,
	                  "theme_section_id"          => 0,
	                  "action_id"         => $value
	                ];
	                $this->Common_model->add($this->_fix."part_action",$insert_data);
	              }
	              $actions = implode(',',$actions) ;
	            }
	            else
	            {
	              $actions = "";
	            }
	          }        
	          $editstring = "<h3 class='title-block'>".$p["name"]."</h3>";
	          $editstring = '<div data-colum = "'.$column.'" data-id="'.$part_id.'" class="item-part-block col-md-'.$column.'"><div class="block-part">'
	          . $editstring.
	          '<div id="box-info-part"><input name="id" value="'.$part_id.'" type="hidden">
	            <input name="ids[]" value="'.$part_id.'" type="hidden">
	          </div>
	            <div class="menu-action" id="support_part">
                <ul class="menu-block"> 
                  <li><a href="javascript:;" id="edit-part"><i class="fa fa-pencil" aria-hidden="true"></i></a></li>
                  <li><a href="javascript:;" id="delete-part"><i class="fa fa-trash" aria-hidden="true"></i></a></li>
                </ul>
              </div>
	          </div>
	          </div>';
	          $data["status"] = "success";
	          $data["response"] = $editstring;
	          $editstring = "";
	          $id = $part_id;
	          $block_part = $this->Common_model->get_record($this->_fix."section_block_part",["id" => $id]);
	          if($block_part){
	            $part  = $this->Common_model->get_record($this->_fix."parts",["id" => $block_part["part_id"]]);
	            if($part){
	              $metas = $this->Common_model->get_result($this->_fix."block_part_meta",["block_part_id" => $block_part["id"]]);
	              $html_show = $part["list_show"]; 
	              $file_content = $part["html_edit"];
	              if($file_content){
		            $htmls = $html = "";
		            if($part["meta_key"] == "value_text"){
		               $htmls = str_replace("{{value}}",@$metas[0]["value"], $file_content );
		            }else{
		              foreach ($metas as $key => $value) {
		                if($value["media_id"] != null && $value["media_id"] > 0){
		                  $media_ids[] = $value["media_id"] ;
		                  $media = $this->Common_model->get_record($this->_fix."medias",["id" => $value["media_id"]]);
		                  if($media){
		                    $html = '<div data-id="'.$value["media_id"].'" class="info-item">'.str_replace("{{value}}",base_url($media["thumb"]), $html_show ).'</div>';
		                    $html = str_replace("{{media_id}}",$media["id"],$html);
		                  }
		                }else{
		                  $html = str_replace("{{value}}",$value["value"], $html_show );
		                }
		                $htmls .= $html;
		              }
		              $htmls = str_replace("{{value}}",$htmls, $file_content );
		            }
		            
		          } 
	              $a = $this->Common_model->get_result($this->_fix."part_action",["block_part_id" => $id]);
	              $editstring = "<h3 class='title-block'>".$part["name"]."</h3>";
	              $editstring = '<div class="block-part">
	              <div class="row"><div class="col-md-12"><div class="box-slider box-full">
	              <div class="row"><div class="col-md-2"><p class="lable">Rows:</p></div>
	              <div class="col-md-10">
	              <select class="none" name="minbeds" id="minbeds">';
	              $cs = 13;
	              for ($i=0; $i < $cs; $i++) { 
	                if($i == $column){
	                  $editstring .='<option value="'.$i.'" selected>'.$i.'</option>';
	                }else{
	                  $editstring .='<option value="'.$i.'">'.$i.'</option>';
	                }   
	              }
	              $editstring .= '</select></div></div></div></div>';
	              $actions = $this->Parts_model->get_action_like($id, $section_block_id ,$theme_section_id);
	              if($actions){
	                $editstring .= '<div class="col-md-12"><div class="box-action box-full"><p class="lable">Actions: ';
	                foreach ($actions as $key => $value) {
	                  $atv = "";
	                  if($value["active"] == 1){
	                    $atv = "checked";
	                  }
	                  $editstring .= '<label><input id="action-item" name="actions[]" type="checkbox" value="'.$value["id"].'" '.$atv.'>'.$value["name"].'</label>';
	                  
	                }
	                $editstring .= '</p></div></div>';
	              }
	              $editstring .= '</div>';
	              $editstring .= '<div class="box-part box-full">'.$htmls.'
	                <div class ="form-group">
	                  <div class="input-group input-group-sm">
	                    <label class="input-group-addon" for="class-name">Class name</label>
	                    <input type="text"  name="class_name" class="form-control" id="class-name" value="" placeholder="Enter class name">
	                  </div>
	                </div>
	                <div class ="form-group">
	                  <div class="input-group input-group-sm">
	                    <label class="input-group-addon" for="id-name">Id name</label>
	                    <input type="text" name="id_name" class="form-control" id="id-name" value="" placeholder="Enter Id name">
	                  </div>
	                </div>
	              </div>
	              </div>
	              <div id="box-info-part">
	                <input name="id" value="'.$id.'" type="hidden">
	              </div>';
	              $data["status"] = "success";
	              $data["modal"] = $editstring;
	            }
	          }
	        }
	      }
	    }  
	    die( json_encode($data) );
	}
}
