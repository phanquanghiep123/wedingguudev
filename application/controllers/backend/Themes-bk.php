<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Themes extends MY_Controller {
    private $folder_view = "themes"; 
    private $base_controller = "themes";
    private $table = '';
    private $table_category = '';
    private $table_post_category = '';
    
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'themes';
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index(){
        $this->data["records"] = $this->Common_model->get_result($this->table);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_insert["style"] = json_encode($data_insert["style"]);
                $id = $this->Common_model->add($this->table,$data_insert);
                $this->message('Thêm mới thành công','success');
                if($this->input->post("save-type") == "1"){
                   redirect(backend_url($this->base_controller.'/layout/'.$id));
                }
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
               $this->session->set_flashdata('record',$this->input->post());
               $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $this->data["fonts"] = $this->Common_model->get_result($this->table_prefix."font");
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    } 
    public function layout($id){
        $this->data["id"] = $id;
        $check = $this->Common_model->get_record($this->table,["id" => $id]);
        if($check == null) redirect(backend_url($this->base_controller));
        $this->data["theme_name"] = $check["name"];
        $this->data["sections"] = $this->Common_model->get_result($this->table_prefix."section",["theme_id" => $id],null,null ,[["field" => "sort_number","sort" => "ASC"]]);
        $bgtemplate = scandir(FCPATH . "uploads/source/bgtemplate",1);
        $this->data["id"]          = $id;
        $this->data["bgtemplate"]  = $bgtemplate;
        $musictemplate = scandir(FCPATH . "uploads/source/music",1);
        $this->data["theme"]  = $check;
        $imgeffec = scandir(FCPATH . "uploads/source/imgeffect",1);
        $imgeffectemplate = [];
        foreach ($imgeffec as $key => $value) {
            if(trim($value) != "" && $value != null && trim($value) !=".." && trim($value) !="."){
                $imgeffectemplate [] = ["thumbs" => "/uploads/thumbs/imgeffect/".$value,"source" => "/uploads/source/imgeffect/".$value];
            }
        }
        $this->data["imgeffecttemplate"]  = $imgeffectemplate;
        $this->data["musictemplate"]  = $musictemplate;
        $this->load->view($this->backend_asset."/".$this->folder_view."/layout",$this->data);
    }
    public function savelayout(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post("id");
            $layout = $this->input->post("page");
            $check  = $this->Common_model->delete($this->table_prefix."section",["theme_id" => $id]);
            foreach ($layout as $key => $value) {
                $data_insert = [
                    "theme_id"    => $id,
                    "sort_number" => $key,
                    "fullcontent" => $value["fullcontent"],
                    "html"        => $value["html"],
                    "items"       => json_encode($value["items"]),
                    "html_id"     => $value["id"],
                    "style"        => $value["style"],
                ];     
                $this->Common_model->add($this->table_prefix."section", $data_insert);    
            }
        }
    }
    public function edit($id = null){
        if($id == null){
            redirect(backend_url($this->base_controller));
        }
        $record = $this->Common_model->get_record($this->table,array("id" => $id));
        if($record == null){
            redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_insert["style"] = json_encode($data_insert["style"]);
                $this->Common_model->update($this->table,$data_insert,["id" => $id]);
                $this->message('Thêm mới thành công','success');
                if($this->input->post("save-type") == "1"){
                    redirect(backend_url($this->base_controller.'/layout/'.$id));
                }
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }
            
        }  
        $this->data['label'] = 'Chỉnh sửa';
        $this->data['post'] = $record;
        $this->data['post']["style"] = json_decode($record["style"],true);
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    public function template(){
        if($this->input->is_ajax_request()){
            $file = $this->input->post("id");
            $post = $this->input->post();
            $data = [];
            foreach (@$post as $key => $value) {
                $key         = str_replace("{{","", $key);
                $key         = str_replace("}}","", $key);
                $data[$key]  = $value;
            }
            $this->load->view($this->backend_asset."/".$this->folder_view."/template/".$file,$data);
        }
    }
    public function getmodal(){
        if($this->input->is_ajax_request()){
            $file = $this->input->post("id");
            $this->load->view($this->backend_asset."/".$this->folder_view."/modal/".$file);
        }
    }
    public function delete($id = null){
        $this->Common_model->delete($this->table,array("id" => $id));
        $this->message('Xóa thành công','success');
        redirect(backend_url($this->base_controller));
    }
    public function copy($id){
        $record = $this->Common_model->get_record($this->table,["id" => $id]);
        if($record == null) redirect(backend_url($this->base_controller));
        unset($record["id"]);
        unset($record["created_at"]);
        $record["name"] = $record["name"] . " - copy(".date("Y-m-d H:i:s").")";
        $resultSection = $this->Common_model->get_result($this->table_prefix."section",["theme_id" => $id]);
        $new_id = $this->Common_model->add($this->table,$record);
        if($resultSection != null){
            $bacth_insert = [];
            foreach ($resultSection as $key => $value) {
                unset($value["id"]);
                unset($value["created_at"]);
                $value["theme_id"] = $new_id; 
                $bacth_insert[]    = $value;
            }
            if($bacth_insert != null)
                $this->Common_model->insert_batch_data($this->table_prefix."section",$bacth_insert);
        }
        redirect(backend_url($this->base_controller.'/edit/'.$new_id));
    }
    public function getstyle(){
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if($this->input->is_ajax_request()){
            $file           = $this->input->post("file");
            $action         = "add";
            $id             = $this->input->post("id");
            $table          = $this->table;
            $table_sction   = $this->table_prefix."section";
            $theme = $this->Common_model->get_record($table,["id" => $id]);
            if($theme != null){
                $style        = "";
                $themestyle   = [];
                $themestyleBg = [];
                $setup = "";
                $sections = $this->Common_model->get_result($table_sction,["theme_id" => $id]);  
                $arrg_themestyle =  json_decode($theme["style"],true);  
                if($arrg_themestyle != null){
                    foreach ($arrg_themestyle as $key => $value) {
                        if($value != null && trim($value) != "")
                            if (strpos($key, 'background-') !== false)
                                $themestyleBg [$key]= $value;
                            else
                                $themestyle[$key] = $value;
                    }
                } 
                $style_map = "";
                $style_map = $theme["style_map"];
                $data["response"]["ThemeID"] = $theme["id"];
                $data["response"]["themeInfo"]["name"] = @$theme["name"]; 
                $data["response"]["themeInfo"]["hero_image"] = @$theme["hero_image"]; 
                $data["response"]["themeInfo"]["music"] =  @$theme["music"]; 
                $data["response"]["themeInfo"]["description"] = @$theme["description"]; 
                if($style_map != "" && $file != "sc.css"){$setup = file_get_contents(FCPATH.$style_map);}    
                $ct = file_get_contents(skin_url( "plugin-sc/css/".$file ));
                $style .=  $ct . $setup; 
                $data["response"]["themestyle"] = $themestyle;
                $data["response"]["themestyleBg"] = $themestyleBg;
                $data["response"]["style"] = $style;
                $data["status"] = "success";
            }   
        }
        die(json_encode($data));
    }
    public function getbgtemplate(){
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if($this->input->is_ajax_request()){
            $file  = $this->input->post("folder");
            $bgtemplate = scandir(FCPATH . "uploads/source/bgtemplate/".$file."/thumbs",1);
            $value_url = [];
            if($bgtemplate != null){
                foreach ($bgtemplate as $key => $value) {
                    if(trim($value) != "" && $value != null && trim($value) !=".." && trim($value) !="."){
                        $value_url [] = ["thumbs" => base_url("uploads/source/bgtemplate/".$file."/thumbs/".$value),"source" => base_url("uploads/source/bgtemplate/".$file."/source/".$value)];
                    }
                }
            }
            $data = ["status" => 'success' ,"message" => null , "response" => $value_url, "post" => $this->input->post()];
        }
        die(json_encode($data));
    }
    public function save($id){
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if($this->input->is_ajax_request()){
            $layout     = $this->input->post("page");
            $themestyle = $this->input->post("themsstyle");
            $themeInfo  = $this->input->post("themeInfo");
            $themeInfo["style"] = json_encode(@$themeInfo["style"]);
            $theme      = $this->Common_model->get_record($this->table_prefix."themes",["id" => $id]);
            $data_id    = [];
            if($theme){
                foreach ($layout as $key => $value) {
                    $check = $this->Common_model->get_record($this->table_prefix."section",["theme_id" => $theme["id"],"html_id" => $value["id"]]);
                    if($check != null){
                        $data_insert = [
                            "sort_number" => $key,
                            "fullcontent" => @$value["fullcontent"] == null ? 0 : @$value["fullcontent"],
                            "html"        => $value["html"],
                            "items"       => json_encode($value["items"]),
                            "html_id"     => $value["id"],
                            "style"       => @$value["style"],   
                        ];     
                        $this->Common_model->update($this->table_prefix."section", $data_insert,["id" => $check["id"]]);  
                    }else{
                        $data_insert = [
                            "theme_id"    => $theme["id"],
                            "sort_number" => $key,
                            "fullcontent" => @$value["fullcontent"] == null ? 0 : @$value["fullcontent"],
                            "html"        => $value["html"],
                            "items"       => json_encode($value["items"]),
                            "html_id"     => $value["id"],
                            "style"       => @$value["style"] ,
                        ];     
                        $this->Common_model->add($this->table_prefix."section", $data_insert);    
                    }
                    $data_id[] = $value["id"];
                }
                $this->db->where_not_in("html_id",$data_id);
                $this->db->delete($this->table_prefix."section",["theme_id" => $theme["id"]]);
                if($themeInfo != null)
                    $this->Common_model->update($this->table_prefix."themes",$themeInfo,["id" => $theme["id"]]);
                $data = ["status" => "success","id" => $id ,"reload" => false];
            }
            die(json_encode($data)) ;          
        }
    }
    public function getmusic(){
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if($this->input->is_ajax_request()){
            $folder  = $this->input->post("folder");
            $files = scandir(FCPATH . "uploads/source/music/".$folder,1);
            $value_url = [];
            if($files != null){
                foreach ($files as $key => $value) {
                    if(trim($value) != "" && $value != null && trim($value) !=".." && trim($value) !="."){
                        $name = ucfirst(str_replace("_"," ", $value));
                        $name = str_replace(".mp3","", $name);
                        $value_url [] = ["name" => $name,"source" => base_url("uploads/source/music/".$folder."/".$value)];
                    }
                }
            }
            $data = ["status" => 'success' ,"message" => null , "response" => $value_url, "post" => $this->input->post()];
        }
        die(json_encode($data));
    }
}
