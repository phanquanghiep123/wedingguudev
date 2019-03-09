<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Blocks extends MY_Controller {
	public $_fix   = "theme_";
	public $_table = "blocks";
	public $_view  = "backend/themes/blocks";
  public $_cname = "themes/blocks";
  public $_model = "Blocks_model";
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
    $this->_data["tables"] = $this->Common_model->get_result($this->_fix.$this->_table,null,$offset,$limit);
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
    $this->_data["post"]["parts"]  = $this->Common_model->get_result($this->_fix."parts",["status" => 1]);
    $this->_data["action_save"] = backend_url($this->_cname."/save_create");
    $this->_data["post"]["actions"]  = $this->Common_model->get_like($this->_fix."actions","support_key","/part/");
    $this->load->view($this->_view . "/create_and_edit",$this->_data);
  }
  public function edit($id){
    $item = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
    $this->_data["post"] = $item;
    $this->_data["post"]["parts"]  = $this->Common_model->get_result($this->_fix."parts");
    $this->_data["post"]["actions"]  = $this->Common_model->get_like($this->_fix."actions","support_key","/part/");
    $this->_data["action_save"] = backend_url($this->_cname."/save_edit/".$id);
    $this->load->model("Blocks_model");
    $this->_data["my_parts"]  = $this->Blocks_model->get_part_by_id($id,0,0,["tbl2.is_default" => 1]);
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
      $name       = $this->input->post("name");
      $class_name = $this->input->post("class_name");
      $id_name    = $this->input->post("id_name");
      $status     = $this->input->post("status");
      $ids        = $this->input->post("ids");
      $theme_section_id   = $this->input->post("theme_section_id") ? $this->input->post("theme_section_id") : 0;
      $section_block_id = $this->input->post("section_block_id") ?  $this->input->post("section_block_id") : 0;
      $ramkey     = null;
      $id = $this->Common_model->add($this->_fix.$this->_table,[
        "name"        => $name,
        "status"      => $status,
        "class_name"  => $class_name,
        "id_name"     => $id_name
      ]);
      if($id && $ids){
        $ramkeyn = uniqid();
        foreach ($ids as $key => $value) {
          $update = [
            "block_id" => $id,
            "ramkey"   => $ramkeyn
          ];
          $this->Common_model->update($this->_fix."section_block_part",$update,["id" => $value]);
          $where = [
            "block_part_id"    => $value,
            "section_block_id" => $section_block_id,
            "theme_section_id" => $theme_section_id
          ];
          $this->Common_model->update($this->_fix."section_block_part_order",["sort" => $key],$where);
        }
        $this->db->delete($this->_fix."section_block_part",["ramkey" => $ramkey]);
      }
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
    $block = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id ]);
    if($block == null) redirect(backend_url($this->_cname));
    if ($this->form_validation->run() !== FALSE)
    {
      $name       = $this->input->post("name");
      $status     = $this->input->post("status");
      $ids        = $this->input->post("ids");
      $class_name = $this->input->post("class_name");
      $id_name    = $this->input->post("id_name");
      $theme_section_id   = $this->input->post("theme_section_id") ? $this->input->post("theme_section_id") : 0;
      $section_block_id = $this->input->post("section_block_id") ?  $this->input->post("section_block_id") : 0;
      $ramkey = null;
      $this->Common_model->update($this->_fix.$this->_table,[
        "name"       => $name,
        "status"     => $status,
        "class_name" => $class_name,
        "id_name"    => $id_name
      ],["id" => $id]);
      if($ids){
        $ramkeyn = uniqid();
        foreach ($ids as $key => $value) {
          if($key == 0){
            $v = $this->Common_model->get_record($this->_fix."section_block_part",["id" => $value]);
            if($v != null) $ramkey = $v["ramkey"];
          }
          $update = [
            "block_id" => $id,
            "ramkey"   => $ramkeyn
          ];
          $this->Common_model->update($this->_fix."section_block_part",$update,["id" => $value]);
          $where = [
            "block_part_id"       => $value,
            "section_block_id"    => $section_block_id,
            "theme_section_id"    => $theme_section_id
          ];
          $this->Common_model->update($this->_fix."section_block_part_order",["sort" => $key],$where);
        }
        $this->db->delete($this->_fix."section_block_part",["ramkey" => $ramkey]);
      }
      redirect(backend_url($this->_cname.'/edit/' . $id ."?action=create&status=success"));
    }else
    {
      redirect(backend_url($this->_cname.'/edit/'."?action=create&status=error"));
    }
  }
  public function update_part_block(){
    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
    if($this->input->is_ajax_request()){
      //block_part_id
      $id = $this->input->post("id");
      $section_block_id = $this->input->post("section_block_id") ? $this->input->post("section_block_id") : 0 ;
      $theme_section_id   = $this->input->post("theme_section_id") ? $this->input->post("theme_section_id") : 0 ;
      $block_part = $this->Common_model->get_record($this->_fix."section_block_part",["id" => $id]);
      $ramkey     = $this->input->post("ramkey") ? $this->input->post("ramkey") : 0 ;
      if($block_part){
        $where = [
          "block_part_id"    => $id,
          "section_block_id" => $section_block_id,
          "theme_section_id"         => $theme_section_id
        ];
        $info_part = $this->Common_model->get_record($this->_fix."section_block_part_order",$where );
        $part = $this->Common_model->get_record($this->_fix."parts",["id" => $block_part["part_id"]]);
        $html_show = "";
        if($part){
          $metas = $this->Common_model->get_result($this->_fix."block_part_meta",$where);
          $html_show = $part["list_show"];  
          $media_ids = [];
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
          
          $a = $this->Common_model->get_result($this->_fix."part_action",$where);
          $editstring = "<h3 class='title-block'>".$part["name"]."</h3>";
          $editstring = '<div class="block-part">
          <div class="row"><div class="col-md-12"><div class="box-slider box-full">
          <div class="row"><div class="col-md-2"><p class="lable">Rows:</p></div>
          <div class="col-md-10">
          <select class="none" name="minbeds" id="minbeds">';
          $colum = $info_part["ncolum"];
          $cs = 13;
          for ($i=0; $i < $cs; $i++) { 
            if($i == $colum){
              $editstring .='<option value="'.$i.'" selected>'.$i.'</option>';
            }else{
              $editstring .='<option value="'.$i.'">'.$i.'</option>';
            }   
          }
          $editstring .= '</select></div></div></div></div>';
          $actions = $this->Common_model->get_like($this->_fix."actions","support_key","/part/");
          if($actions){
            $editstring .= '<div class="col-md-12"><div class="box-action box-full"><p class="lable">Actions: ';
            foreach ($actions as $key => $value) {
              $atv = "";
              foreach ($a as $key_1 => $value_1) {
                if($value_1["action_id"] == $value["id"] && $value_1["active"] == 1){
                  $atv = "checked";
                }
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
                <input type="text"  name="class_name" class="form-control" id="class-name" value="'.$info_part["class_name"].'" placeholder="Enter class name">
              </div>
            </div>
            <div class ="form-group">
              <div class="input-group input-group-sm">
                <label class="input-group-addon" for="id-name">Id name</label>
                <input type="text" name="id_name" class="form-control" id="id-name" value="'.$info_part["id_name"].'" placeholder="Enter Id name">
              </div>
            </div>
          </div>
          <div id="box-info-part">
            <input type="hidden" name="id" value="'.$id.'">
            <input type="hidden" id="is_part" name="is_part" value="' .$part["name"]. '">
            <input type="hidden" id="valuestring" name="valuestring" value="' .htmlspecialchars($html_show). '">
          </div>';
          $data["status"] = "success";
          $data["response"] = $editstring;
        }
      }
    }  
    die( json_encode($data) );
  }
  public function value_part (){
    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
    if($this->input->is_ajax_request()){
      $id = $this->input->post("id");
      $pb = $this->Common_model->get_record($this->_fix."section_block_part",["id" => $id]);
      if( $pb ){
        $p = $this->Common_model->get_record($this->_fix."parts",["id" => $pb["part_id"]]);
        $data["status"] = "success";
        $data["response"] = $p["list_show"];
      }
    }
    die( json_encode($data) );
  }
  public function save_block_part(){
    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
    if($this->input->is_ajax_request()){
      $ramkey     = $this->input->post("ramkey") ? $this->input->post("ramkey") : 0 ;
      $id = $this->input->post("id");
      $actions    = $this->input->post("actions");
      $list_media = $this->input->post("medias");
      $map_point  = $this->input->post("map_point");
      $ncolum     = $this->input->post("minbeds");
      $cln        = $this->input->post("class_name");
      $idn        = $this->input->post("id_name");
      $value_text = $this->input->post("value_text");
      $theme_section_id   = $this->input->post("theme_section_id") ? $this->input->post("theme_section_id") : 0;
      $section_block_id = $this->input->post("section_block_id") ?  $this->input->post("section_block_id") : 0;
      $bp = $this->Common_model->get_record($this->_fix."section_block_part",["id" => $id]);
      if($bp){
        $data_update = [
          "ncolum"     => $ncolum,
          "id_name"    => $idn,     
          "class_name" => $cln
        ];
        $where = [
          "block_part_id"    => $id,
          "section_block_id" => $section_block_id,
          "theme_section_id"         => $theme_section_id
        ];
        $this->Common_model->update($this->_fix."section_block_part_order",$data_update,$where);
        $this->Common_model->update($this->_fix."part_action",["active" => 0],$where);
        if($actions != null){
          foreach ($actions as $key => $value) {
            $wa = $where;
            $wa["action_id"] = $value;
            $r = $this->Common_model->get_record($this->_fix."part_action",$wa);
            if($r != null){
              $this->Common_model->update($this->_fix."part_action",["active" => 1],$wa);
            }else{
              $wa["active"] = 1;
              $this->Common_model->add($this->_fix."part_action",$wa);
            }
          }
        }
        $c = $this->Common_model->delete($this->_fix."block_part_meta",$where);
        if($value_text != null){
          $this->Common_model->add($this->_fix."block_part_meta",[
            "block_part_id"    => $id, 
            "meta_key"         => "value_text",
            "theme_section_id"         => $theme_section_id ,
            "section_block_id" => $section_block_id,
            "value"            => $value_text,
          ]);
        }
        if($map_point != null){
          foreach ($map_point as $key => $value) {
            $this->Common_model->add($this->_fix."block_part_meta",[
              "block_part_id"    => $id, 
              "meta_key"         => "map_point",
              "theme_section_id"         => $theme_section_id ,
              "section_block_id" => $section_block_id,
              "value"            => $value,
            ]);
          }
        }
        if($list_media != null){
          foreach ($list_media as $key => $value) {
            $i = [
              "block_part_id"    => $id, 
              "meta_key"         => "value_media",
              "theme_section_id"         => $theme_section_id ,
              "section_block_id" => $section_block_id,
              "media_id"         => $value,
            ];
            $this->Common_model->add($this->_fix."block_part_meta",$i);
          }
        }
        $data["status"] = "success";
      }
    }
    die( json_encode($data) );
  }
  public function sort(){
    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
    if($this->input->is_ajax_request()){
      $sb = $this->input->post("sb");
      $items = $this->input->post("items");
      if($sb && is_array($items)){
        foreach ($items as $key => $value) {
          $this->Common_model->update($this->_fix."section_block_part_order",["sort" => $key],["block_part_id" => $value,"section_block_id" => $sb]);
        }
      }
      $data["status"] = "success";
    }
    die(json_encode($data));
  }
  public function updatedata (){
    $this->db->select("tbl2.*");
    $this->db->from('ewd_theme_sections AS tbl1');
    $this->db->join("ewd_theme_section_block AS tbl2","tbl2.section_id = tbl1.id");
    //$this->db->join("ewd_theme_blocks AS tbl4","tbl4.id = tbl2.block_id");
    //$this->db->join("ewd_theme_section_block_part AS tbl5",'tbl5.block_id = tbl4.id');
   // $this->db->join("ewd_theme_block_part_meta AS tbl6","tbl6.block_part_id = tbl5.id");
    $this->db->group_by("tbl2.block_id,tbl2.section_id");
    $v = $this->db->get()->result_array();
    //$a = [];
    /*
    foreach ($v as $key => $value) {
      $i = [
        'value'         => $value["value"],
        'media_id'      => $value["media_id"],
        'meta_key'      => $value["meta_key"],
        'block_part_id' => $value["block_part_id"],
        'section_block_id' => $value["id"],
        'theme_section_id' => 0
      ];
      $a [] = $i;
    }*/
    echo "<pre>";
    print_r($v);
    echo "</pre>";
  }
}
