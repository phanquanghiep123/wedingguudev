<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Filemanager extends CI_Controller {
  public $_fix   = "theme_";
  public $_table = "medias";
  public $_view  = "frontend/filemanager";
  public $_model = "Medias_model";
  public $_data  = [];
  public $_user_id = 0;
  public $_path_upload = "/uploads/";
  public function __construct(){
      parent::__construct();
      ini_set('max_execution_time', 0);
      ini_set('memory_limit', '-1');
      if(!$this->input->is_ajax_request()) $this->load->view($this->_view."/block/header");
      if ($this->session->userdata('user_info') || $this->session->userdata('admin_info')) {
        if($this->session->userdata('admin_info')){
          $this->_data['user'] = $this->session->userdata('admin_info');
        }else{
          $this->_data['user'] = $this->session->userdata('user_info');
        }
        $this->_data["is_login"] = true;
        $this->_user_id = @$this->_data['user']['id'];
      }else{
        die("Vui lòng đăng nhâp!");
      }
      if(@$this->_data['user']["is_system"] == 1){
        $this->_user_id = 0;
      }else{
        $this->_user_id = @$this->_data['user']["id"];
      } 
      error_reporting(E_ERROR | E_PARSE);
      header('Access-Control-Allow-Origin: *');
      header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      header('Access-Control-Allow-Methods: GET, POST, PUT');       
  }
  public function index(){
      $type_file = $ext_filter = $file_size = null;
      if($this->input->get()){
        $type_file  = $this->input->get("type_file");
        $ext_filter = $this->input->get("ext_filter");
        $file_size  = $this->input->get("file_size");
      }
      $check_folder_member = $this->Common_model->get_record($this->_fix.$this->_table,["member_id" => $this->_user_id,"is_root" => 1]); 
      $folder_id = 0;
      if($this->_user_id != 0 && $this->_user_id != null){
        if($check_folder_member == null){
          $i = [
            "name"        => @$this->_data['user']["name"]."_".$this->_user_id,
            "type_id"     => 2,
            "folder_id"   => 0,
            "path_folder" => '/',
            "extension"   =>"folder",
            "member_id"   => $this->_user_id,
            "is_root"     => 1,
            "dir_folder"  => "/uploads/".md5($this->_user_id)."/"
          ];
          mkdir(FCPATH.$i['dir_folder'], 0777, true);
          $id = $this->Common_model->add($this->_fix.$this->_table,$i);
          $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $i["path_folder"].$id."/"],["id" => $id]);
          $folder_id = $id;
        }else{
          $folder_id = $check_folder_member["id"];
        }
      }
      $this->_data["folder_id"]  = $folder_id;
      $this->_data["mediatype"]  = $this->Common_model->get_result($this->_fix."media_type");
      $this->load->model($this->_model);
      $this->_data["list_media"]  =  $this->{$this->_model}->get($folder_id,$this->_user_id,$type_file,$ext_filter,$file_size);
      $list_folder = ["name" => "root" ,"id" => $folder_id,"iconOpen" => skin_url("themes/images/1_open.png"),"iconClose" => skin_url("themes/images/1_close.png"),"icon" => skin_url("themes/images/1_open.png"),"children" => $this->Medias_model->get_list_folder($folder_id,$this->_user_id),"open" => true];
      $this->_data["list_folder"] = $list_folder;
      $this->_data["sizeData"] = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
      $config_file_allow_upload = $this->Common_model->get_record($this->_fix."media_type",["name" => $type_file]);
      $this->_data["allow_uploads"] = json_encode(["*"]);
      if($type_file != null){
        if($config_file_allow_upload){
          $string_allow = $config_file_allow_upload["extension"];
          $arg_allow    = explode("/",$string_allow );
          $set_allow_not_null = array_diff($arg_allow ,[""]);
          $this->_data["allow_uploads"]  = json_encode(array_values($set_allow_not_null));
        }else{
          $this->_data["allow_uploads"]  = json_encode(array_values([$type_file,$ext_filter]));
        }
      }
      $this->load->view($this->_view . "/index",$this->_data);
  }
  public function get (){
      $data = ["status" => "no","message" => null,"thumb" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
      if($this->input->is_ajax_request()){
          $folder_id  = $this->input->post("folder");
          $type       = $this->input->post("type");
          $type_file  = $this->input->post("type_file");
          $ext_filter = $this->input->post("ext_filter");
          $file_size  = $this->input->post("file_size");
          $limit      = 50;
          $html = "";
          if($type == "folder"){
              $this->load->model($this->_model);
              $list_medias = $this->{$this->_model}->get($folder_id,$this->_user_id,$type_file,$ext_filter,$file_size);
              if(@$list_medias != null){
                  $sizeData = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
                  foreach ($list_medias as $key => $value) {
                      $stringicon = "";
                      $sizestring = "";
                      if($value["type_name"] != "folder"){
                        foreach ($sizeData as $key_1 => $value_1) {
                          if( ((int)$value_1["value"]) < $value["size"]){
                            $sizestring = "(" .round(($value["size"] / ((int)$value_1["value"]) ),2) .  $value_1["key_id"] .")";
                          }
                        }
                      }
                      if($value["icon"] == null && $value["icon"] == ""){
                          $stringicon = '<img class="thumb-media" src="'.base_url( $value["thumb"]).'?v='.uniqid().'">';
                      }else{
                          $stringicon = '<i class="thumb-media '.$value["icon"].'" ></i>';
                      }
                      $html .='<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 item-colums item-colums">
                      <div id="contaner-item" data-type="'. $value["type_name"].'" class="'. $value["type_name"].'" data-id="'. $value["id"].'" data-typeid="'. $value["type_id"].'">
                        <div class="action" data-id="'. $value["id"].'" data-type="'. $value["type_id"].'">
                          <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                          <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                          <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                        </div>
                        <div class="bg-info">
                          <p>'.$value["name"].' '. $sizestring.'</p>
                        </div>
                        '.$stringicon.'
                      </div>
                      </div>';
                      if($value["extension"] == "folder"){
                        $value["isParent"] = true;
                        $value["icon"]     = skin_url("themes/images/folder_open.png");
                        $value["iconOpen"] = skin_url("themes/images/folder_open.png");
                        $value["iconClose"]= skin_url("themes/images/folder_close.png");
                        $data["record"][] = $value;
                      }
                  }
              }else{
                  $html = '<div class="empty-folder"><p><i class="fa fa-thermometer-empty" aria-hidden="true"></i></p><p>Folder is emty</p></div>';
              }
          } 
          $data["response"] = $html;
          $data["status"] = "success";
      }
      echo(json_encode($data));
  }
  public function get_by_ids (){
      $data = ["status" => "no","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
      if($this->input->is_ajax_request()){
          $ids        = $this->input->post("ids");
          $type_file  = $this->input->post("type_file");
          $ext_filter = $this->input->post("ext_filter");
          $file_size  = $this->input->post("file_size");
          $limit      = 50;
          $html       = "";
          $this->load->model($this->_model);
          $list_medias      = $this->{$this->_model}->get_by_ids($ids,$this->_user_id,$type_file,$ext_filter,$file_size); 
          $m = [];
          foreach ($list_medias as $key => $value) {
            $value["ramkey"] = uniqid();
            $value["path"]   =  base_url($value["path"].'?v='.uniqid());
            $value["full"]   =  base_url($value["full"].'?v='.uniqid());
            $value["large"]  = base_url($value["large"].'?v='.uniqid());
            $value["medium"] = base_url($value["medium"].'?v='.uniqid());
            $value["small"]  = base_url($value["small"].'?v='.uniqid());
            $value["thumb"]  = base_url($value["thumb"].'?v='.uniqid());
            $m [] = $value;
          }
          $data["response"] = $m;
          $data["status"]   = "success";
      }
      echo(json_encode($data));
  }
  public function get_folder_by_id(){
      $id = ($_REQUEST["id"]);
      $this->load->model($this->_model);
      $list_foldes =  $this->{$this->_model}->get_list_folder($id,$this->_user_id);
      echo(json_encode($list_foldes));
  }
  public function add($type){
      $data = ["status" => "error","message" => null,"thumb" => null ,"post" => $this->input->post(),"record" => null];
      if($this->input->is_ajax_request()){
          $r = $this->Common_model->get_record($this->_fix."media_type",["name" => $type]);
          if($r != null){
              switch ($r["name"]) {
                  case 'folder':
                      $name   = $this->input->post("name") ;
                      $folder = $this->input->post("folder") ? $this->input->post("folder") : 0;
                      $check  = $this->Common_model->get_record($this->_fix.$this->_table,["name" => $name,"folder_id" => $folder,"member_id" => $this->_user_id]) ; 
                      if($check == null){
                          $path_folder = '/';
                          $dir_folder  = "/uploads/";
                          $member_id   = 0;
                          if($folder != null){
                            $f = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $folder]);
                            if( $f != null){
                              $path_folder = $f["path_folder"];
                              $dir_folder  = $f["dir_folder"];
                              $member_id   = $f["member_id"];;
                            }       
                          }else{
                            $folder = 0;
                          }
                          if( $name != null){
                              $R = uniqid();
                              $i = [
                                "name"        => $name,
                                "type_id"     => $r["id"],
                                "folder_id"   => $folder,
                                "path_folder" => $path_folder,
                                "extension"   => "folder",
                                "member_id"   => $member_id,
                                "dir_folder"  => $dir_folder .$R.'/',
                                "path"        => $dir_folder .$R.'/'
                              ];
                              $id = $this->Common_model->add($this->_fix.$this->_table,$i);
                              mkdir(FCPATH.$i['dir_folder'], 0777, true);
                              $record   = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
                              $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $path_folder.$id."/"],["id" => $id]);
                              $record["isParent"]  = true;
                              $record["icon"]      = skin_url("themes/images/folder_open.png");
                              $record["iconOpen"]  = skin_url("themes/images/folder_open.png");
                              $record["iconClose"] = skin_url("themes/images/folder_close.png");
                              $data['record'] = $record ;
                              $show_view    = "";
                              if($r["name"] == "image"){
                                $show_view = '<img class="thumb-media" src="'.base_url($record["thumb"]).'" />';
                              }else{
                                $show_view = '<i class="thumb-media '.$r["icon"].'" ></i>';
                              }
                              $data["response"] = '<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 item-colums item-colums">
                              <div id="contaner-item" data-type="'.$r["name"].'" class="'.$r["name"].'" data-id="'.$record["id"].'" data-typeid="'.$record["type_id"].'">
                                <div class="action" data-id="'.$record["id"].'" data-type="'.$r["id"].'" data-type-name="'.$r["name"].'">
                                  <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                                  <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                                  <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                </div>
                                <div class="bg-info">
                                  <p>'.$record["name"].'</p>
                                </div>
                                '.$show_view.'
                              </div>
                            </div>';
                            $data["status"] = "success";
                          }
                      }else{
                          $data["message"] = "Folder is exits!";
                      }
                      break;
                  default:
                      # code...
                      break;
              }
          }
      }
      echo(json_encode($data));
  }
  public function edit(){
      $data = ["status" => "error","message" => null,"thumb" => null ,"post" => $this->input->post(),"record" => null];
      if($this->input->is_ajax_request()){
          $html = '<div id="content-edit-media">';
          $id = $this->input->post("id");
          if($id){
              $record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id,"member_id" => $this->_user_id]);
              $checkAdmin = @$this->_data['user']["System"] == 1 ? true : false;
              if($checkAdmin){
                $record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
              }
              if($record){
                  $get_type = $this->Common_model->get_record($this->_fix."media_type",["id" => $record["type_id"]]);
                  $sizeData = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
                  $sizestring = "";
                  $sizestringby ="";
                  $stringSizeinput = "";
                  if($get_type["name"] != "folder"){
                      foreach ($sizeData as $key => $value) {
                          if(((int)$value["value"]) < $record["size"]){
                              $sizestring = round(($record["size"] / ((int)$value["value"])),2);
                              $sizestringby = $value["key_id"];
                          }
                      }
                      $stringSizeinput = '<div class="input-group input-group-sm">
                        <label class="input-group-addon" for="dataHeight">Size</label>
                        <input type="text" value="'.$sizestring.'" class="form-control" id="dataSize" placeholder="Size" readonly>
                        <span class="input-group-addon">'.$sizestringby.'</span>
                      </div>';
                  }
                  
                  $data["mediatype"] = $get_type ;
                  if($get_type["name"] == "image"){
                      $size = getimagesize(FCPATH . $record["path"]);
                      $html .='<div class="row">
                        <div class="col-md-9">
                          <div class="img-container">
                            <img id="image" src="'.base_url($record["path"]).'?v='.uniqid().'" alt="Picture">
                          </div>
                        </div>
                        <div class="col-md-3 box-rigth">  
                          <!-- <h3>Data:</h3> -->
                          <div class="docs-data">
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataX">X</label>
                              <input type="text" class="form-control" value="0" id="dataX" placeholder="x" readonly>
                              <span class="input-group-addon">px</span>
                            </div>
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataY">Y</label>
                              <input type="text" class="form-control" value="0" id="dataY" placeholder="y" readonly>
                              <span class="input-group-addon">px</span>
                            </div>
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataWidth">Width</label>
                              <input type="text" value="'.@$size[0].'" class="form-control" id="dataWidth" placeholder="width" readonly>
                              <span class="input-group-addon">px</span>
                            </div>
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataHeight">Height</label>
                              <input type="text" value="'.@$size[1].'" class="form-control" id="dataHeight" placeholder="height" readonly>
                              <span class="input-group-addon">px</span>
                            </div>
                            '.$stringSizeinput.'
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="dataRotate">Rotate</label>
                              <input type="text" class="form-control" id="dataRotate" placeholder="rotate" readonly>
                              <span class="input-group-addon">deg</span>
                            </div>
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="media-created">Path</label>
                              <input type="text" class="form-control" value="'.$record["path"].'" readonly>
                            </div>
                            <div class="input-group input-group-sm">
                              <label class="input-group-addon" for="media-created">Created At</label>
                              <input type="text" class="form-control" id="media-created" value="'.$record["created_at"].'" placeholder="Enter media name" readonly>
                            </div>
                            <div class="input-group input-group-sm">
                                <label class="input-group-addon" for="media-name">Media name</label>
                                <input type="text" class="form-control" id="media-name" value="'.$record["name"].'" placeholder="Enter media name">
                            </div>
                          </div>
                        </div>
                      </div><div class="row">
                          <div class="col-md-9 docs-buttons">
                          <!-- <h3>Toolbar:</h3> -->
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                                <span class="fa fa-arrows"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                                <span class="fa fa-crop"></span>
                              </span>
                            </button>
                          </div>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, 0.1)">
                                <span class="fa fa-search-plus"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;zoom&quot;, -0.1)">
                                <span class="fa fa-search-minus"></span>
                              </span>
                            </button>
                          </div>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, -10, 0)">
                                <span class="fa fa-arrow-left"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 10, 0)">
                                <span class="fa fa-arrow-right"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, -10)">
                                <span class="fa fa-arrow-up"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;move&quot;, 0, 10)">
                                <span class="fa fa-arrow-down"></span>
                              </span>
                            </button>
                          </div>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, -45)">
                                <span class="fa fa-rotate-left"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;rotate&quot;, 45)">
                                <span class="fa fa-rotate-right"></span>
                              </span>
                            </button>
                          </div>

                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleX&quot;, -1)">
                                <span class="fa fa-arrows-h"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;scaleY&quot;, -1)">
                                <span class="fa fa-arrows-v"></span>
                              </span>
                            </button>
                          </div>

                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;crop&quot;)">
                                <span class="fa fa-check"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;clear&quot;)">
                                <span class="fa fa-remove"></span>
                              </span>
                            </button>
                          </div>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;disable&quot;)">
                                <span class="fa fa-lock"></span>
                              </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;enable&quot;)">
                                <span class="fa fa-unlock"></span>
                              </span>
                            </button>
                          </div>
                          <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="$().cropper(&quot;reset&quot;)">
                                <span class="fa fa-refresh"></span>
                              </span>
                            </button>
                            <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                              <input type="file" class="sr-only" id="inputImage" name="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.tiff">
                              <span class="docs-tooltip" data-toggle="tooltip" data-animation="false" title="Import image with Blob URLs">
                                <span class="fa fa-upload"></span>
                              </span>
                            </label>
                          </div>
                          </div>
                          <div class="col-md-3">
                              <input type="hidden" name="is-change" id="is-change" value="0">
                              <input type="hidden" name="id" id="media-id" value="'.$record["id"].'">
                              <input type="hidden" name="type" id="media-type" value="'.$get_type["name"].'">
                              <input type="hidden" name="extension" id="media-extension" value="'.$record["extension"].'">
                              <input type="hidden" name="size" id="media-size" value="'.$record["size"].'">
                          </div>
                        </div>';
                  } 
                  else{
                    $name = "Folder";
                    $view = "";
                    if($get_type["name"] != "folder"){
                      $name = "File";
                    }
                    if($get_type["name"] == "audio"){
                      $view = '<audio width="100%" controls style="width: 100%;">
                                <source src="'.base_url($record["path"]).'" type="audio/ogg">
                                <source src="'.base_url($record["path"]).'" type="audio/mpeg">
                              Your browser does not support the audio element.
                              </audio>';
                    }
                    if($get_type["name"] == "video"){
                      $view = '<video width="100%" controls>
                                <source src="'.base_url($record["path"]).'" type="video/mp4">
                                <source src="'.base_url($record["path"]).'" type="video/ogg"> 
                              </video>';
                    }
                    $editstring = "";
                    if($get_type["name"] == "text" || $get_type["name"] == "file"){
                      if(file_exists( FCPATH . $record["path"] )){
                        $file_content = file_get_contents(FCPATH . $record["path"]);  
                        $editstring = '<textarea name="content-file" id="content-file" placeholder="Enter text ..." style="width: 100%;">'.htmlspecialchars($file_content).'</textarea>';
                      }
                    }
                    if($get_type["name"] == "text"){
                      $html .='<div class="row"><div class="col-md-4">';
                    }
                    $html .= '<div class="docs-data"><div class="input-group input-group-sm">
                      <label class="input-group-addon" for="media-name">'.$name .' name</label>
                      <input type="text" class="form-control" id="media-name" value="'.$record["name"].'" placeholder="Enter media name">
                    </div></div>
                    <div class="docs-data">'.$stringSizeinput.'</div>
                    <div class="docs-data"><div class="input-group input-group-sm">
                      <label class="input-group-addon" for="media-name">Created At</label>
                      <input type="text" class="form-control" id="media-name" value="'.$record["created_at"].'" placeholder="Enter media name" readonly>
                    </div></div>
                    '.$view.'';
                    if($get_type["name"] == "text"){
                      $html .='</div><div class="col-md-8">';
                    }
                    $html .= $editstring.'
                    <input type="hidden" name="is-change" id="is-change" value="0">
                    <input type="hidden" name="id" id="media-id" value="'.$record["id"].'">
                    <input type="hidden" name="type" id="media-type" value="'.$get_type["name"].'">
                    <input type="hidden" name="extension" id="media-extension" value="'.$record["extension"].'">
                    <input type="hidden" name="size" id="media-size" value="'.$record["size"].'"></div>';
                    if($get_type["name"] == "text"){
                      $html .='</div></div>';
                    }
                  }
                  $data["status"] = "success";
                  $data["record"] = $record;   
              }   
          }
          $html .= '</div>';
          $data["response"] = $html;
          
      }
      echo(json_encode($data));
  }
  public function save_edit(){
      $data = ["status" => "no","response" => false,"message" => null,"thumb" => null ,"post" =>  $this->input->post()];
      if($this->input->is_ajax_request()){
          $id = $this->input->post("id");
          $record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id,"member_id" => $this->_user_id]);
          $checkAdmin = @$this->_data['user']["System"] == 1 ? true : false;
          if($checkAdmin){
            $record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
          }
          if($record){
              $allow_save = true;
              $type = $this->input->post("type");
              $name = $this->input->post("name");
              $get_type = $this->Common_model->get_record($this->_fix."media_type",["id" => $record["type_id"]]);
              $sizeData = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
              if($get_type["name"] == "image"){
                  $imgbase64 = $this->input->post("imgbase64");
                  $is_change = $this->input->post("is_change");
                  $size = $this->input->post("size");
                  $extension = $this->input->post("extension") ? $this->input->post("extension") : "jpg";
                  if($is_change == 1 && $imgbase64 != null){
                      $folder = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $record['folder_id']]);
                      $upload_path = FCPATH . $folder['dir_folder'];
                      if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0777, TRUE);
                      }
                      $file           = FCPATH . $record['path'];
                      $front_content  = substr($imgbase64, strpos($imgbase64, ",")+1);
                      $decodedData    = base64_decode($front_content);
                      $fp = fopen( $file, 'wb' );
                      fwrite( $fp, $decodedData);
                      fclose( $fp );
                      $record["size"] = filesize($file);
                      $data_resize = $this->resizeImage($record,$folder['dir_folder']); 
                      if($data_resize["status"] == "success")
                        $record = array_merge($record,$data_resize["response"]);

                  }
              }else if($get_type["name"] == "folder"){
                $check = $this->Common_model->get_record($this->_fix.$this->_table,["id !=" => $record["id"],"name" => $name,"folder_id" => $record["folder_id"]]);
                if($check != null){
                  $allow_save = false;
                  $data["message"] = "Folder has been exist";
                }
              }else if($get_type["name"] == "text" || $get_type["name"] == "file"){
                if(file_exists( FCPATH . $record["path"] )){
                  try{
                    $fname   = FCPATH . $record["path"];
                    $content = $this->input->post("content");
                    $fhandle = fopen($fname,"w");
                    fwrite($fhandle,$content);
                    fclose($fhandle);
                    $record["size"] = filesize($fname);
                  }
                  catch(Exception $e){
                    $data["message"] = $e ;
                  }                 
                }  
              }
              if($allow_save){
                $record["name"] = $name;
                $response = $record;
                $id = $record["id"];
                unset($record["id"]);
                if( $checkAdmin )
                  $this->Common_model->update($this->_fix.$this->_table,$record,["id" => $id]);
                else
                  $this->Common_model->update($this->_fix.$this->_table,$record,["id" => $id,"member_id" => $this->_user_id]);
                $data ["status"] = "success";
                $sizestring = "";
                foreach ($sizeData as $key_1 => $value_1) {
                    if( ((int)$value_1["value"]) < $response["size"]){
                        $sizestring = "(" .round(($response["size"] / ((int)$value_1["value"]) ),2) .  $value_1["key_id"] .")";
                    }
                }
                $stringthumb = '<img class="thumb-media" src="'.base_url($response["thumb"]).'?v='.uniqid().'">';
                if($get_type["icon"] != ""){
                  $stringthumb = '<i class="thumb-media '.$get_type["icon"].'"></i>';
                }
                $html = '<div class="action" data-id="'.$response["id"].'" data-type="'.@$get_type["id"].'" data-type-name="'.@$get_type["name"].'">
                  <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                  <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                  <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                </div>
                <div class="bg-info">
                  <p>'.$response["name"].$sizestring.'</p>
                </div>
                '.$stringthumb.'';
                $data["response"] = $html;
                $response['full'] .='?v='.uniqid();
                $response['large'] .='?v='.uniqid();
                $response['medium'] .='?v='.uniqid();
                $response['path'] .='?v='.uniqid();
                $response['small'] .='?v='.uniqid();
                $response['thumb'] .='?v='.uniqid();
                $data["record"]   = $response;
                $data["get_type"] = $get_type;
              }
          } 
      }
      echo(json_encode($data));
  }
  public function uploadflash (){
    $data = ["status" => "no","response" => false,"message" => null,"thumb" => null ,"post" =>  $this->input->post()];
    if($this->input->is_ajax_request()){
      $config["upload_path"] = $this->_path_upload;
      $root_id = 0;
      if(@$this->_data['user']["is_system"] != 1){
        $root = $this->Common_model->get_record($this->_fix.$this->_table,["member_id" => $this->_user_id ,"is_root" => 1]);
        if($root){
          $config["upload_path"] = $root["dir_folder"];
          $root_id               = $root["id"];
        }else{
          if($this->_user_id != 0 && $this->_user_id != null){
              $i = [
                "name"        => @$this->_data['user']["name"]."_".$this->_user_id,
                "type_id"     => 2,
                "folder_id"   => 0,
                "path_folder" => '/',
                "extension"   =>"folder",
                "member_id"   => $this->_user_id,
                "is_root"     => 1,
                "dir_folder"  => "uploads/".md5($this->_user_id)."/"
              ];
              mkdir(FCPATH.$i['dir_folder'], 0777, true);
              $root_id = $this->Common_model->add($this->_fix.$this->_table,$i);
              $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $i["path_folder"].$root_id."/"],["id" => $root_id]);
              $config["upload_path"] = $i["dir_folder"];
          }
        }        
      }else{
        $config["upload_path"] = $this->_path_upload;
      }
      $dataupload = [];
      $lenght = count($_FILES["files"]["name"]);
      $record = [];
      for ($i=0; $i < $lenght; $i++) { 
        $_FILES["file"]["name"]     = $_FILES["files"]["name"][$i];
        $_FILES["file"]["type"]     = $_FILES["files"]["type"][$i];
        $_FILES["file"]["tmp_name"] = $_FILES["files"]["tmp_name"][$i];
        $_FILES["file"]["error"]    = $_FILES["files"]["error"][$i];
        $_FILES["file"]["size"]     = $_FILES["files"]["size"][$i];
        $dataupload = $this->savefile("file",$config);
        if($dataupload ["status"]){
          $r = $dataupload["response"];
          //get type 
          $this->db->from($this->_fix."media_type");
          $this->db->like('extension', '/'.$r["extension"].'/');
          $exe = $this->db->get()->row_array();
          if($exe == null){
            $r["type_id"] = 3;
            $exe  = $this->Common_model->get_record($this->_fix."media_type",["id" => 3]);
          }else{
            $r["type_id"] = $exe["id"];
          }
          $r["folder_id"]   = $root_id;
          $r["path_folder"] = $config["upload_path"];
          $r["member_id"]   = $this->_user_id;
          $id = $this->Common_model->add($this->_fix.$this->_table,$r);
          $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $root["path_folder"] . $id. "/"],["id" => $id]);
          $item = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
          $item["ramkey"] = uniqid();
          $record[] = $item;
        }
        $data["response"] = $record; 
        $data["status"] = "success"; 
      } 
    }
    $data["config"] = $config;
    echo (json_encode($data));
  }
  public function upload(){
    $data = ["status" => "no","response" => false,"message" => null,"thumb" => null ,"post" =>  $this->input->post()];
    if($this->input->is_ajax_request()){
        $config["upload_path"] = $this->_path_upload;
        $folder = $this->input->post("folder");
        $path_folder = '/';
        $member_id   = 0;
        if($folder != null){
          if(@$this->_data['user']["is_system"] === 0){
            $f = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $folder,"member_id" => $this->_user_id]);
          }else{
            $f = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $folder]);
          }
          if( $f != null){
            $path_folder           = $f["path_folder"];
            $config["upload_path"] = $f["dir_folder"];
            $member_id             = $f["member_id"];
          }
        }else{
          $folder = 0;
        }
        try {
          $dataupload = $this->savefile("file",$config);
          if($dataupload ["status"]){
            $r = $dataupload["response"];
            //get type 
            $this->db->from($this->_fix."media_type");
            $this->db->like('extension', '/'.$r["extension"].'/');
            $exe = $this->db->get()->row_array();
            if($exe == null){
              $r["type_id"] = 3;
              $exe  = $this->Common_model->get_record($this->_fix."media_type",["id" => 3]);
            }else{
              $r["type_id"] = $exe["id"];
            }
            $r["folder_id"]   = $folder;
            $r["path_folder"] = $path_folder;
            $r["member_id"]   = $member_id;
            $id = $this->Common_model->add($this->_fix.$this->_table,$r);
            $r["size"] = filesize( FCPATH . $r["path"] );
            $this->Common_model->update($this->_fix.$this->_table,
              [
                "path_folder" => $r["path_folder"] . $id. "/",
                "size" => $r["size"]
              ],
              [
                "id" => $id
              ]
            );
            $record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
            if($exe["name"] == "image"){
                $record["show_view"] = '<img class="thumb-media" src="'.base_url($record["thumb"]).'" />';
            }else{
                $record["show_view"] = '<i class="thumb-media '.$exe["icon"].'" ></i>';
            }
            $sizeData = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
            $sizestring = "";
            if($exe["name"] != "folder"){
              foreach ($sizeData as $key => $value) {
                if(((int)$value["value"]) < $record["size"]){
                  $sizestring = "(".round(($record["size"] / ((int)$value["value"])),2) .  $value["key_id"] .")";
                }
              }
            }
            $data["status"]  = "ok";
            $data["message"] = "Upload successfully";
            $data["response"] = '<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 item-colums item-colums">
                <div id="contaner-item" data-type="'.$exe["name"].'" class="'.$exe["name"].'" data-id="'.$record["id"].'" data-typeid="'.$record["type_id"].'">
                  <div class="action" data-id="'.$record["id"].'" data-type="'.$record["type_id"].'" data-type-name="'.$exe["name"].'">
                    <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                    <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                    <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                  </div>
                  <div class="bg-info">
                    <p>'.$record["name"].' '.$sizestring.'</p>
                  </div>
                  '.$record["show_view"].'
                </div>
            </div>';
          }else{
            $data["error"] = $dataupload;
            $data["message"] = "Upload file Error!";
          }
        }catch(Exception $e){
          $data["message"] = "Upload file Error!" ;
        }     
    }
    echo (json_encode($data));
  }
  public function delete(){
      $data = ["status" => "error","message" => null,"thumb" => null ,"post" => $this->input->post(),"record" => null];
      $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);
      if($this->input->is_ajax_request()){
          $posts = $this->input->post("data");
          $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);
          foreach ($posts as $key => $value) {
              if(@$this->_data['user']["System"] == 1){
                $get_record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $value]);
              }else {
                $get_record = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $value,"member_id" => $this->_user_id]);
              }
              if( $get_record != null ){
                  if($get_record["extension"] == "folder"){
                    $this->db->like("path_folder",$get_record["path_folder"]); 
                    $this->db->delete($this->_fix.$this->_table) ;
                    if($get_record["path"]){
                      if (strpos($get_record["path"], '/uploads/') !== false){
                        $this->delete_folder(FCPATH . $get_record["path"]);
                      } 
                    }
                  }else{
                    foreach ($config_file AS $key_1 => $value_1){
                      if( @$get_record[ $value_1["key_id"]]){
                        if(file_exists( FCPATH . $get_record[ $value_1["key_id"] ] ) ){
                          try{
                            unlink(FCPATH . $get_record[ $value_1["key_id"] ]); 
                          }catch(Exception $e){ }
                        }
                      }
                    } 
                    unlink(FCPATH . $get_record["path"]); 
                  }
                  $this->Common_model->delete($this->_fix.$this->_table,["id" => $get_record["id"]]);
              }
          }
          $data["status"] = "success";
      }
      echo(json_encode($data));
  }
  public function delete_folder($dir) { 
    if(!is_dir($dir )){
      return false;
    }
    $files = array_diff(scandir($dir), array('.','..')); 
    foreach ($files as $file) { 
      (is_dir("$dir/$file")) ? $this->delete_folder("$dir/$file") : unlink("$dir/$file"); 
    } 
    return rmdir($dir); 
  } 
  public function actions(){
      $data = ["new_node" => null,"status" => "error","message" => null,"thumb" => null ,"post" => $this->input->post(),"record" => null];
      if($this->input->is_ajax_request()){
          $ids    = $this->input->post("data");
          $type   = $this->input->post("type");
          $folder = $this->input->post("folder");
          if($folder == 0 || $folder == null){
              $f = [
                "id"           => 0,
                "folder_id"    => 0,
                "path_folder"  => "/",
                "type"         => "folder",
                "name"         => "root",
                "dir_folder"   => "",
                "member_id"    => 0
              ];
          }else{
              if(@$this->_data['user']["is_system"] == 0){
                $f = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $folder,"member_id" => $this->_user_id]);
              }else{
                $f = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $folder]);
              }
          }
          if($f){
              if(@$this->_data['user']["is_system"] == 0){
                $l = $this->Common_model->get_result_in($this->_fix.$this->_table,"id",$ids,["member_id" => $this->_user_id]);
              }else{
                $l = $this->Common_model->get_result_in($this->_fix.$this->_table,"id",$ids);
              }
              if($l){
                  if($type == 1){
                      $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);
                      $ids = [];
                      foreach ($l as $key => $value) {
                        if($value["id"] == $f["id"]){
                          if($value["extension"] == "folder"){
                            $check_folder_exits = $this->Common_model->get_record($this->_fix.$this->_table,["name" => $value["name"],"folder_id" => $f["id"]]);
                            if($check_folder_exits != null){
                              $value["name"] =  $value["name"] .("(copy".uniqid().")");
                            }
                          }
                          $old_id = $value["id"];
                          $old_path_folder = $value["path_folder"];
                          unset($value["id"]);
                          $value["folder_id"]     = $f["id"];
                          $value["member_id"]     = $f["member_id"];
                          $value["path_folder"]   = $f["path_folder"];
                          $value["dir_folder"]    = $f["dir_folder"];
                          if($value["extension"] != "folder"){
                            if($config_file != null){
                              $url_frist = "";
                              $url_frist_ew = "";
                              foreach ($config_file as $key => $value_1) {
                                if($url_frist != $value[$value_1["key_id"]]){
                                  $name      = uniqid().".".$value["extension"];
                                  $newfile   = $value["dir_folder"]."/".$name;
                                  if (!is_dir(FCPATH . $config['upload_path'] )) {
                                    mkdir(FCPATH . $config['upload_path'] , 0777, TRUE);
                                  }
                                  copy(FCPATH.$file, FCPATH.$newfile);
                                  $url_frist = $file;
                                  $url_frist_ew = $newfile;
                                  $value[$value_1["key_id"]] = $newfile;
                                } else{
                                  $value[$value_1["key_id"]] = $url_frist_ew;
                                }
                              }
                            }
                          }
                          $newid = $this->Common_model->add($this->_fix.$this->_table,$value);
                          $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $value["path_folder"] . $newid . "/"],["id" => $newid]);
                          $value["path_folder"] = $value["path_folder"] . $newid . "/";
                          $ids [] = $newid;
                          if($value["extension"] == "folder"){
                              $folder_new = $value;
                              $folder_new["id"]       = $newid;
                              $folder_new["isParent"] = true;
                              $folder_new["icon"]     = skin_url("themes/images/folder_open.png");
                              $folder_new["iconOpen"] = skin_url("themes/images/folder_open.png");
                              $folder_new["iconClose"]= skin_url("themes/images/folder_close.png");
                              $data["new_node"][] = $folder_new;
                              $this->db->from($this->_fix.$this->_table);
                              $this->db->like("path_folder",$old_path_folder);
                              $this->db->where("id !=",$newid);
                              $list_new = $this->db->get()->result_array();
                              if($list_new != null){
                                  $this->copymedia($list_new,$old_id,$newid,$value["path_folder"],$config_file,$value);
                              }
                          }  
                          unset($l[$key]);
                          break; 
                        }
                      }
                      foreach ($l as $key => $value) {
                        if($value["id"] != $f["id"]){
                          if($value["extension"] == "folder"){
                            $check_folder_exits = $this->Common_model->get_record($this->_fix.$this->_table,["name" => $value["name"],"folder_id" => $f["id"]]);
                            if($check_folder_exits != null){
                              $value["name"] =  $value["name"] .("(copy".uniqid().")");
                            }
                          }
                          $old_id = $value["id"];
                          $old_path_folder = $value["path_folder"];
                          unset($value["id"]);
                          $value["folder_id"]     = $f["id"];
                          $value["member_id"]     = $f["member_id"];
                          $value["path_folder"]   = $f["path_folder"];
                          $value["dir_folder"]    = $f["dir_folder"];
                          if($value["extension"] != "folder"){
                            if($config_file != null){
                              $url_frist = "";
                              $url_frist_ew = "";
                              foreach ($config_file as $key => $value_1) {
                                if($url_frist != $value[$value_1["key_id"]]){
                                  $name      = uniqid().".".$value["extension"];
                                  $file      = $value[$value_1["key_id"]];
                                  $url = explode('/', $file);
                                  array_pop($url);
                                  $url = implode('/', $url);
                                  $oldname   = basename($file).PHP_EOL;
                                  $newfile   = $url."/".$name;
                                  copy(FCPATH.$file, FCPATH.$newfile);
                                  $url_frist = $file;
                                  $url_frist_ew = $newfile;
                                  $value[$value_1["key_id"]] = $newfile;
                                } else{
                                  $value[$value_1["key_id"]] = $url_frist_ew;
                                }
                              }
                            }
                          }
                          $newid = $this->Common_model->add($this->_fix.$this->_table,$value);
                          $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $value["path_folder"] . $newid . "/"],["id" => $newid]);
                          $value["path_folder"] = $value["path_folder"] . $newid . "/";
                          $ids [] = $newid;
                          if($value["extension"] == "folder"){
                              $folder_new = $value;
                              $folder_new["id"]       = $newid;
                              $folder_new["isParent"] = true;
                              $folder_new["icon"]     = skin_url("themes/images/folder_open.png");
                              $folder_new["iconOpen"] = skin_url("themes/images/folder_open.png");
                              $folder_new["iconClose"]= skin_url("themes/images/folder_close.png");
                              $data["new_node"][] = $folder_new;
                              $this->db->from($this->_fix.$this->_table);
                              $this->db->like("path_folder",$old_path_folder);
                              $this->db->where("id !=",$newid);
                              $list_new = $this->db->get()->result_array();
                              if($list_new != null){
                                $this->copymedia($list_new,$old_id,$newid,$value["path_folder"],$config_file,$value);
                              }
                          }   
                        }
                      }
                  }elseif($type == 2){
                      $ids = [];
                      foreach ($l as $key => $value) { 
                          if($value["folder_id"] != $f["id"] && $f["id"] != $value["id"]){
                              $old_id = $value["id"];
                              $ids [] = $old_id;
                              unset($value["id"]);
                              $old_path_folder = $value["path_folder"];
                              $value["folder_id"]   = $f["id"];
                              $value["member_id"]   = $f["member_id"];
                              $value["dir_folder"]  = $f["dir_folder"];
                              $value["path_folder"] = $f["path_folder"] . $old_id . "/";
                              if($value["extension"] == "folder"){
                                $check_folder_exits = $this->Common_model->get_record($this->_fix.$this->_table,["name" => $value["name"],"folder_id" => $f["id"]]);
                                if($check_folder_exits != null){
                                  $value["name"] =  $value["name"] .("(cut".uniqid().")");
                                }
                              }
                              $this->Common_model->update($this->_fix.$this->_table,$value,["id" => $old_id]);
                              if($value["extension"] == "folder"){
                                  $sql = "update ewd_".$this->_fix.$this->_table." set path_folder = REPLACE(path_folder,'".$old_path_folder."','".$value["path_folder"]."'),dir_folder = '".$f["dir_folder"]."',member_id = ".$f["member_id"]." where path_folder like('%".$old_path_folder."%') and id != ".$old_id."";
                                  $query = $this->db->query( $sql );
                                  $data["last_query"] [] = $this->db->last_query();
                                  $folder_new = $value;
                                  $folder_new["id"] = $old_id;
                                  $folder_new["isParent"]  = true;
                                  $folder_new["icon"]      = skin_url("themes/images/folder_open.png");
                                  $folder_new["iconOpen"]  = skin_url("themes/images/folder_open.png");
                                  $folder_new["iconClose"] = skin_url("themes/images/folder_close.png");
                                  $data["new_node"][] = $folder_new;
                              }
                          }      
                      }
                  } 
                  $sizeData = $this->Common_model->get_result($this->_fix."config",["support" => "file_size"]);
                  $html = "";
                  $this->load->model($this->_model);
                  if($ids != null){
                      $l = $this->{$this->_model}->get_in($ids);
                      foreach ($l as $key => $value) {
                          $stringicon = "";
                          $sizestring = "";
                          if($value["extension"] != "folder"){
                              foreach ($sizeData as $key_1 => $value_1) {
                                  if( ((int)$value_1["value"]) < $value["size"]){
                                      $sizestring = "(" .round(($value["size"] / ((int)$value_1["value"]) ),2) .  $value_1["key_id"] .")";
                                  }
                              }
                          }
                          if($value["icon"] == null && $value["icon"] == ""){
                              $stringicon = '<img class="thumb-media" src="'.base_url( $value["thumb"]).'">';
                          }else{
                              $stringicon = '<i class="thumb-media '.$value["icon"].'" ></i>';
                          }
                          $html .='<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2 item-colums item-colums">
                          <div id="contaner-item" data-type="'. $value["type_name"].'" class="'. $value["type_name"].'" data-id="'. $value["id"].'" data-typeid="'. $value["type_id"].'">
                            <div class="action" data-id="'. $value["id"].'" data-type="'. $value["type_id"].'" data-type-name="'. $value["type_name"].'">
                              <a href="javascript:;" id="select-media"><i class="fa fa-square-o" aria-hidden="true"></i></a>
                              <a href="javascript:;" id="delete-media"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                              <a href="javascript:;" id="edit-media"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                            </div>
                            <div class="bg-info">
                              <p>'.$value["name"].' '. $sizestring.'</p>
                            </div>
                            '.$stringicon.'
                          </div>
                          </div>';
                      }
                  }
                  $data["response"] = $html;
                  $data["status"] = "success";    
              }
          }
          
      }
      echo (json_encode($data));
  }
  private function savefile($file, $config = null){
    $data_return            = ["status" => false];
    $data_file              = [];
    $path_parts             = pathinfo($_FILES[$file]["name"]);
    $extension              = $path_parts['extension'];
    $data_file["extension"] = strtolower($extension);
    $data_file["name"]      = $_FILES[$file]["name"];
    $data_file["size"]      = $_FILES[$file]["size"];
    $name = uniqid().".".strtolower($extension);
    if (!is_dir(FCPATH . $config['upload_path'] )) {
      mkdir(FCPATH . $config['upload_path'] , 0777, TRUE);
    }
    $pathsave  = $config["upload_path"];
    $config_file_allow_upload = $this->Common_model->get_record($this->_fix."config",["support" => "file_allow_upload"]);
    if($config_file_allow_upload){
      $string_allow = $config_file_allow_upload["value"];
      $arg_allow    = explode("/",$string_allow );
      $set_allow_not_null = array_diff($arg_allow ,[""]);
      $string_allo_new = implode("|", $set_allow_not_null);
      $config['allowed_types']  = $string_allo_new;
    }
    $folder_allow = '/uploads/Themes/';
    if (strpos(@$config["upload_path"] , $folder_allow) !== false) {
        $config['allowed_types'] = '*';
    }
    if($data_file["extension"] == "json"){
      $config['allowed_types'] = '*';
    }
    $config['file_ext_tolower'] = TRUE;
    $config["file_name"]      = $name;
    $config["upload_path"]    = FCPATH . @$config["upload_path"];
    $this->load->library('upload');
    $this->upload->initialize($config);
    if ( ! $this->upload->do_upload($file))
    {
      $data_return["response"] = $this->upload->display_errors();    
    }
    else
    {
      $data = $this->upload->data();
      $data_file["path"] = $pathsave . $data['file_name'];
      $data_file["path"] = str_replace("//","/",$data_file["path"]);
      $data_return["status"] = true;
      $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);
      if($data["is_image"]){
        $this->load->library('image_lib');
        $full_path = $data["full_path"];
        $w = $data["image_width"];
        $h = $data["image_height"];
        if($config_file != null){
            $wDefault = 1920;
            if($wDefault < $w){
              $ratio_image = $this->ratio_image($w ,$h,( (int) $wDefault ),0);
              $config['width']          = $wDefault;
              $config['height']         = $ratio_image["height"];
              $config['source_image']   = $full_path;
              $config['maintain_ratio'] = FALSE;
              $config['quality']        = 90;
              $this->image_lib->clear();
              $this->image_lib->initialize($config);
              $data_resize = $this->image_lib->resize();
            }
            foreach ($config_file as $key => $value) {
              $new_path = $config['upload_path'] . $value["key_id"] ."/";
              if (!is_dir( $new_path)) {
                mkdir($new_path, 0777, TRUE);
              }
              if(( (int) $value["value"] ) < $w){
                $ratio_image = $this->ratio_image($w ,$h,( (int) $value["value"] ),0);
                $config['width']          = $value["value"];
                $config['height']         = $ratio_image["height"];
                $config['source_image']   = $full_path;
                $config['new_image']      = $new_path . $data['file_name'];
                $config['maintain_ratio'] = FALSE;
                $config['quality']        = 90;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $data_resize = $this->image_lib->resize();
                $data_file[$value["key_id"]] = $pathsave  . $value["key_id"] ."/". $data['file_name'];
                $data_file[$value["key_id"]] = str_replace("//","/",$data_file[$value["key_id"]]);
                $full_path                   = FCPATH . $data_file[$value["key_id"]];
              }else{
                $data_file[$value["key_id"]] = $pathsave  . $data['file_name'];
                $data_file[$value["key_id"]] = str_replace("//","/",$data_file[$value["key_id"]]);
              }
            }
        } 
        $this->image_lib->clear();            
      }else{
        foreach ($config_file as $key => $value) {
          $data_file[$value["key_id"]] = $pathsave . $data['file_name'];
          $data_file[$value["key_id"]] = str_replace("//","/",$data_file[$value["key_id"]]);
        }
      }
      $data_return["response"] = $data_file;         
    }
    $data_return["config"] = $config;
    return $data_return;
  }
  private function resizeImage ($record,$path){
      error_reporting(E_ERROR | E_PARSE);
      list($w, $h) = getimagesize(FCPATH . $record["path"]);
      $data_return = ["status" => "error","response" => null];
      $data_file   = [];
      $this->load->library('image_lib');
      $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);
      if($config_file != null){
          $full_path =  $record["path"];
          foreach ($config_file as $key => $value) {
              $new_path  = FCPATH . $path . "/";
              if (!is_dir( $new_path)) {
                mkdir($new_path, 0777, TRUE);
              }
              $new_path = $new_path . $value["key_id"];
              if (!is_dir( $new_path)) {
                mkdir($new_path, 0777, TRUE);
              }
              if(file_exists(FCPATH . $record[$value["key_id"]])){
                try {
                  if( $record[$value["key_id"]] != $record["path"] )
                    unlink(FCPATH . $record[$value["key_id"]]);
                } catch (Exception $e) {
                  
                } 
              }
              if(( (int) $value["value"] ) < $w){
                $ratio_image = $this->ratio_image($w ,$h,( (int) $value["value"] ),0);
                $config['width']          = $value["value"];
                $config['height']         = $ratio_image["height"];
                $config['source_image']   = FCPATH . $full_path;
                $config['new_image']      = FCPATH . $record[$value["key_id"]];
                $config['maintain_ratio'] = FALSE;
                $config['quality'] = 90;
                $this->image_lib->clear();
                $this->image_lib->initialize($config);
                $data_resize = $this->image_lib->resize();
                $data_file[$value["key_id"]] = $record[$value["key_id"]];
                $full_path = $data_file[$value["key_id"]];
              }else{
                $data_file[$value["key_id"]] = $full_path;
              }
              $data_return["response"] = $data_file;
              $data_return["status"]   = "success";
          }
      } 
      $this->image_lib->clear();
      return $data_return;
  }
  private function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0) {
        $size['width'] = $new_width;
        $size['height'] = $new_heigh;
        if ($new_heigh != 0) {
            $size['width'] = intval(($original_wdith / $original_height) * $new_height);
        }
        if ($new_width != 0) {
            $size['height'] = intval(($original_height / $original_width) * $new_width);
        }
        return $size;
  }
  private function gen_slug_name_file($str){
    $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă","ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề" , "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ" , "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă" , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ" , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ","ö","ü"); 
    $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a" , "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o " , "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A " , "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O " , "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-","o","u");
    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
  }
 
  public $_new_array  = [];
  private function copymedia($data = null ,$root = 0, $new_root = 0,$new_path = null,$config_file = null,$folder = null){
      $new_data = [];
      $old_follder = [];
      if($data != null){
        foreach ($data as $key => $value) {
          if($value["folder_id"] == $root){
            $new_data [] = $value;
            unset($data[$key]);
          }
        }
      }
      if($new_data != null){
        foreach ($new_data as $key => $value) {
          $old_id = $value["id"];
          $old_path_folder = $value ["path_folder"];
          unset($value["id"]);
          $value ["folder_id"]   = $new_root;
          $value ["path_folder"] = $new_path;
          $value ["member_id"]   = $folder["member_id"];
          $value ["dir_folder"]  = $folder["dir_folder"];
          if( $value["extension"] != "folder") {
            if($config_file != null){
              $url_frist = "";
              $url_frist_ew = "";
              foreach ($config_file as $key => $value_1) {
                if($url_frist != $value[$value_1["key_id"]]){
                  $name      = uniqid().".".$value["extension"];
                  $file      = $value[$value_1["key_id"]];
                  $url = explode('/', $file);
                  array_pop($url);
                  $url = implode('/', $url);
                  $oldname   = basename($file).PHP_EOL;
                  $newfile   = $url."/".$name;
                  copy(FCPATH.$file, FCPATH.$newfile);
                  $url_frist = $file;
                  $url_frist_ew = $newfile;
                  $value[$value_1["key_id"]] = $newfile;
                } else{
                  $value[$value_1["key_id"]] = $url_frist_ew;
                }
              }
            }
          }
          $newid = $this->Common_model->add($this->_fix.$this->_table,$value);
          $this->Common_model->update($this->_fix.$this->_table,["path_folder" => $value ["path_folder"] . $newid ."/"],["id" => $newid]);
          $value["path_folder"] =  $value ["path_folder"] . $newid ."/";
          if($value["extension"] == "folder"){
            $this->copymedia($data,$old_id,$newid,$value["path_folder"],$config_file,$value);
          }
        }
      }
  }
  private function cutmedia($data = null ,$root = 0, $new_root = 0,$new_path = null,$config_file = null){
      $new_data = [];
      $old_follder = [];
      if($data != null){
          foreach ($data as $key => $value) {
              if($value["folder_id"] == $root){
                $new_data [] = $value;
                unset($data[$key]);
              }
          }
      }
      if($new_data != null){
          foreach ($new_data as $key => $value) {
            $old_id = $value["id"];
            $old_path_folder = $value ["path_folder"];
            unset($value["id"]);
            $value ["folder_id"]   = $new_root;
            $value ["path_folder"] = $new_path;
            $newid = $this->Common_model->update($this->_fix.$this->_table,$value,["id" => $value["id"]]);
            if($value["extension"] == "folder"){
              $this->cutmedia($data,$old_id,$newid,$value["path_folder"],$config_file);
            }
          }
      }
  }
  public function autoresizephoto(){
    $extension = [
      "png",
      "jpg",
      "jpeg",
      "gif"
    ];
    $m = $this->Common_model->get_result($this->_fix . "medias");
    $config_file = $this->Common_model->get_result($this->_fix."config",["support" => "media_width_upload"]);  
    foreach ($m as $key => $value) {
      if(in_array($value["extension"], $extension) && file_exists(FCPATH . $value['path'])){
        list($w, $h) = getimagesize(FCPATH . $record["path"]);
        $wDefault = 1920;
        if($wDefault < $w){
          $ratio_image = $this->ratio_image($w ,$h,( (int) $wDefault ),0);
          $config['width']          = $wDefault;
          $config['height']         = $ratio_image["height"];
          $config['source_image']   = $full_path;
          $config['maintain_ratio'] = FALSE;
          $config['quality']        = 90;
          $this->image_lib->clear();
          $this->image_lib->initialize($config);
          $data_resize = $this->image_lib->resize();
        }
        foreach ($config_file as $key => $value) {
          $new_path = $config['upload_path'] . $value["key_id"] ."/";
          if (!is_dir( $new_path)) {
            mkdir($new_path, 0777, TRUE);
          }
          if(( (int) $value["value"] ) < $w){
            $ratio_image = $this->ratio_image($w ,$h,( (int) $value["value"] ),0);
            $config['width']          = $value["value"];
            $config['height']         = $ratio_image["height"];
            $config['source_image']   = $full_path;
            $config['new_image']      = $new_path . $data['file_name'];
            $config['maintain_ratio'] = FALSE;
            $config['quality']        = 90;
            $this->image_lib->clear();
            $this->image_lib->initialize($config);
            $data_resize = $this->image_lib->resize();
            $data_file[$value["key_id"]] = $pathsave  . $value["key_id"] ."/". $data['file_name'];
            $data_file[$value["key_id"]] = str_replace("//","/",$data_file[$value["key_id"]]);
            $full_path                   = FCPATH . $data_file[$value["key_id"]];
          }else{
            $data_file[$value["key_id"]] = $pathsave  . $data['file_name'];
            $data_file[$value["key_id"]] = str_replace("//","/",$data_file[$value["key_id"]]);
          }
        }
      }
    }
    
  } 
  public function member_size ($f) {
    $io   = popen ( '/usr/bin/du -sk ' . $f, 'r' );
    $size = fgets ( $io, 4096);
    $size = substr ( $size, 0, strpos ( $size, "\t" ) );
    pclose ( $io );
    return $size;
  }
  public function __destruct(){
    if($this->_data['user'] && $this->_data['user']["is_system"] != 1){
      $folder_member = $this->Common_model->get_record($this->_fix.$this->_table,["member_id" => $this->_user_id,"is_root" => 1]);
      if($folder_member){
        $path = FCPATH . $folder_member["dir_folder"];
        $this->Common_model->update("member",["upload_size" => $this->member_size($path)],["id" => $this->_user_id]);
      }
    }
    if(!$this->input->is_ajax_request()){
      $this->load->view($this->_view."/block/footer");
    }
  }
}
