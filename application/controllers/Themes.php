<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH.'application/core/Frontend_Controller.php';

class Themes extends Frontend_Controller{
    public $_version = 3;
    public $_view  = "themes";
    public $base_controller = "themes";
    public $table;
    public $domains_folder = "html";
    public $stite_folder   = "weddingguu.com";
    public function __construct(){
        parent::__construct();
        $this->table = $this->table_prefix."theme_themes";

    } 
    public function index(){
        $this->db->select("tbl1.* , tbl2.thumb AS hero_image");
        $this->db->from($this->table ." AS tbl1");
        $this->db->join($this->table_prefix."theme_medias AS tbl2","tbl2.id = tbl1.thumb","left");
        $this->db->where(["tbl1.is_system" => 1 ,"tbl1.public" => 1 ,"tbl1.status" => 1,'version' => 3]);
        $this->data["result"] = $this->db->get()->result_array();
        $this->load->view("$this->asset/$this->_view/index",$this->data);
    }
    public function my(){
        $this->check_login();
        $this->load->model("Themes_model");
        $member = $this->Common_model->get_record("member",["id" => $this->user_id]);
        $this->data["domain"]     = @$member["domain"];
        $this->data["sub_domain"]  = @$member["sub_domain"];
        $this->data["mytheme"] =  $this->Themes_model->getmytheme($this->user_id);
        $this->load->view("$this->asset/$this->_view/my",$this->data);
    }
    public function delete() {  
        $this->check_login();
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if( $this->input->is_ajax_request() ){
            $id = $this->input->post("id");
            if( is_numeric($id) ){
                $check = $this->Common_model->get_record($this->table,["status" => 1,"id" => $id,"member_id" => $this->user_id,"is_active" => 0]);
                if($check){
                    $this->Common_model->update( $this->table,["status" => 0,"is_delete" => 1] ,["id" => $id ,"member_id" => $this->user_id]);
                    $data["status"] = 'success';
                }
            }
        }
        die(json_encode($data));
    }
    public function active(){
        $this->check_login();
        $data = ["status" => 'error' ,"message" => null , "response" => null,"post" => $this->input->post()];
        if( $this->input->is_ajax_request() ){
            $id = $this->input->post("id");
            if( is_numeric($id) ){
                $check = $this->Common_model->get_record($this->table,["status" => 1,"id" => $id,"member_id" => $this->user_id]);
                if($check){
                    $this->Common_model->update(
                        $this->table,
                        ["is_active" => 0],
                        [
                            "member_id" => $this->user_id,
                            "is_system" => 0
                        ]
                    );
                    $this->Common_model->update(
                        $this->table,["is_active" => 1],
                        [
                            "member_id" => $this->user_id,
                            "id" => $id,
                            "is_system" => 0
                        ]);
                    $data["status"] = 'success';
                }
            }
        }
        die(json_encode($data));
    }
    private function gen_slug_file($str){
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă","ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề" , "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ" , "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă" , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ" , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ","ö","ü"); 
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a" , "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o " , "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A " , "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O " , "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-","o","u");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
    public function export( ){
        $data   = ["status" => 'error' ,"message" => [] , "response" => null,"post" => $this->input->post()];
        $id   = trim($this->input->post("id"));
        $theme  = $this->Common_model->get_record($this->table,["id" => $id,"member_id" => $this->user_id]);
        $member = $this->Common_model->get_record("member",["id" => $this->user_id]);
        if($member && $theme){
            $this->Common_model->update("theme_themes",['is_active' => 0],["member_id" => $this->user_id]);
            $numberDomain = 0;
            if((@$member['sub_domain'] && trim(@$member['sub_domain']) != "" ) || (@$member['domain'] && trim(@$member['domain']) != "" )){
                $index_file = "example/index.php";
                $thumb      = $this->Common_model->get_record($this->table_prefix."theme_medias",["id" => $theme["thumb"]]);
                list($width, $height, $type_img, $attr) = getimagesize(base_url($thumb["medium"]));
                $metas = '<meta property="og:image" content="'.base_url($thumb["medium"]).'"/>';
                $metas .= '<meta property="og:image:width" content="'.$width.'"/>';
                $metas .= '<meta property="og:image:height" content="'.$height.'"/>';
                $metas .= '<link rel="image_src" type="image/jpeg"  href="'.base_url($thumb["medium"]).'" />';
                $metas .= '<meta property="og:description" content="'.$theme["description"].'" />';
                $metas .= '<meta property="og:title" content="'.$theme["name"].'"/>';
                $content_index = file_get_contents($index_file);
                $content_index = str_replace("[[SKIN_URL]]",skin_url(),$content_index);
                $content_index = str_replace("[[BASE_URL]]",base_url(),$content_index);
                $content_index = str_replace("[[META]]",$metas,$content_index);
                $content_index = str_replace("[[THEME_NAME]]",$theme["name"],$content_index);
                $content_index = str_replace("[[THEME_ID]]",$theme["id"],$content_index);
                $content_index = str_replace("[[MEMBER_ID]]",$theme["member_id"],$content_index);
                $sound = $this->Common_model->get_record($this->table_prefix."theme_medias",["id" => $theme["sound_file"]]);
                $content_index = str_replace("[[UNQEID]]",uniqid(),$content_index);
                if($sound){
                    $content_index = str_replace("[[SOUND_URL]]",base_url($sound["path"]),$content_index);
                }else{
                    $content_index = str_replace("[[SOUND_URL]]","",$content_index);
                }
                if(@$member['sub_domain'] && trim(@$member['sub_domain']) != "" ){
                    $sub_domain = $member['sub_domain'];
                    $folderDomain = trim($sub_domain);
                    $folderDomain = trim($sub_domain.'.'.$this->stite_folder.'');
                    if(!file_exists("../".trim($folderDomain)."")){
                        mkdir("../".trim($folderDomain)."", 0755, true);
                    }
                    $content_index = str_replace("[[DOMAIN]]",trim($folderDomain),$content_index);
                    $myfile = fopen("../".trim($folderDomain)."/index.html", "w") or die("Unable to open file!");
                    fwrite($myfile,$content_index);
                    fclose($myfile);
                    $data["message"][] = "Xuất giao diện thành công . Vui lòng truy cập vào:";
                    if($member['sub_domain'] == null || trim($member['sub_domain']) == ""){
                        $this->Common_model->update("member",["sub_domain" => $folderDomain],["id"  => $this->user_id]);           
                        $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                    }else{
                        $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                    } 
                    $numberDomain++;
                }
                if(@$member['domain'] && trim(@$member['domain']) != ""){
                    $domain = $member['domain'];
                    $domain = str_replace('www.', '',$domain);
                    $domain = str_replace('http://','',$domain);
                    $domain = str_replace('https://','',$domain);
                    $folderDomain = trim($domain);
                    if(!file_exists("../".trim($folderDomain)."")){
                        mkdir("../".trim($folderDomain)."", 0755, true);
                    }
                    $content_index = str_replace("[[DOMAIN]]",trim($folderDomain),$content_index);
                    $myfile = fopen("../".trim($folderDomain)."/index.html", "w") or die("Unable to open file!");
                    fwrite($myfile,$content_index);
                    fclose($myfile);
                    if($member['domain'] == null || trim($member['domain']) == ""){
                        $this->Common_model->update("member",["domain" => $folderDomain],["id"  => $this->user_id]);
                        $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                    }else{
                        $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                    } 
                    $numberDomain++;  
                }
            }
            if($numberDomain == 0){
                $data["message"][] = "Vui lòng cập nhật thông tin Tên miền ở trang: <a target=\"_blank\" href=\"".base_url("profile")."\">Thông tin cá nhân</a>"; 
            }
            $this->Common_model->update("theme_themes",['is_active' => 1],["member_id" => $this->user_id,"id" => $id]);
            $data["status"] ="success";
               
        }
        die(json_encode($data));
    }
    public function update_theme_public (){
        $themes = $this->Common_model->get_result($this->table,["is_active" => 1]);
        foreach ($themes as $key => $value) {
            $theme  = $value;
            $member = $this->Common_model->get_record("member",["id" => $theme["member_id"]]);
            if(@$member && @$theme){
                $numberDomain = 0;
                if((@$member['sub_domain'] && trim(@$member['sub_domain']) != "" ) || (@$member['domain'] && trim(@$member['domain']) != "" )){
                    $index_file = "example/index.php";
                    $thumb      = $this->Common_model->get_record($this->table_prefix."theme_medias",["id" => $theme["thumb"]]);
                    list($width, $height, $type_img, $attr) = getimagesize(base_url($thumb["medium"]));
                    $metas = '<meta property="og:image" content="'.base_url($thumb["medium"]).'"/>';
                    $metas .= '<meta property="og:image:width" content="'.$width.'"/>';
                    $metas .= '<meta property="og:image:height" content="'.$height.'"/>';
                    $metas .= '<link rel="image_src" type="image/jpeg"  href="'.base_url($thumb["medium"]).'" />';
                    $metas .= '<meta property="og:description" content="'.$theme["description"].'" />';
                    $metas .= '<meta property="og:title" content="'.$theme["name"].'"/>';
                    $content_index = file_get_contents($index_file);
                    $content_index = str_replace("[[SKIN_URL]]",skin_url(),$content_index);
                    $content_index = str_replace("[[BASE_URL]]",base_url(),$content_index);
                    $content_index = str_replace("[[META]]",$metas,$content_index);
                    $content_index = str_replace("[[THEME_NAME]]",$theme["name"],$content_index);
                    $content_index = str_replace("[[THEME_ID]]",$theme["id"],$content_index);
                    $content_index = str_replace("[[MEMBER_ID]]",$theme["member_id"],$content_index);
                    $sound = $this->Common_model->get_record($this->table_prefix."theme_medias",["id" => $theme["sound_file"]]);
                    $content_index = str_replace("[[UNQEID]]",uniqid(),$content_index);
                    if($sound){
                        $content_index = str_replace("[[SOUND_URL]]",base_url($sound["path"]),$content_index);
                    }else{
                        $content_index = str_replace("[[SOUND_URL]]","",$content_index);
                    }
                    if(@$member['sub_domain'] && trim(@$member['sub_domain']) != "" ){
                        $sub_domain = $member['sub_domain'];
                        $folderDomain = trim($sub_domain);
                        $folderDomain = trim($sub_domain.'.'.$this->stite_folder.'');
                        if(!file_exists("../".trim($folderDomain)."")){
                            mkdir("../".trim($folderDomain)."", 0755, true);
                        }
                        $content_index = str_replace("[[DOMAIN]]",trim($folderDomain),$content_index);
                        $myfile = fopen("../".trim($folderDomain)."/index.html", "w") or die("Unable to open file!");
                        fwrite($myfile,$content_index);
                        fclose($myfile);
                        $data["message"][] = "Xuất giao diện thành công . Vui lòng truy cập vào:";
                        if($member['sub_domain'] == null || trim($member['sub_domain']) == ""){
                            $this->Common_model->update("member",["sub_domain" => $folderDomain],["id"  => $member["id"]]);           
                            $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                        }else{
                            $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                        } 
                        $numberDomain++;
                    }
                    if(@$member['domain'] && trim(@$member['domain']) != ""){
                        $domain = $member['domain'];
                        $domain = str_replace('www.', '',$domain);
                        $domain = str_replace('http://','',$domain);
                        $domain = str_replace('https://','',$domain);
                        $folderDomain = trim($domain);
                        if(!file_exists("../".trim($folderDomain)."")){
                            mkdir("../".trim($folderDomain)."", 0755, true);
                        }
                        $content_index = str_replace("[[DOMAIN]]",trim($folderDomain),$content_index);
                        $myfile = fopen("../".trim($folderDomain)."/index.html", "w") or die("Unable to open file!");
                        fwrite($myfile,$content_index);
                        fclose($myfile);
                        if($member['domain'] == null || trim($member['domain']) == ""){
                            $this->Common_model->update("member",["domain" => $folderDomain],["id"  => $member["id"]]);
                            $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                        }else{
                            $data["message"][] = "<a target=\"_blank\" href=\"http://".$folderDomain."\">http://".$folderDomain."</a>";
                        } 
                        $numberDomain++;  
                    }
                }    
            }
        }
    }
}

 