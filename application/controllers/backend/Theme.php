<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class theme extends MY_Controller {
    public $_fix   = "theme_";
    public $_table = "themes";
    public $_view  = "backend/themes";
    public $_cname = "theme";
    public $_model = "Themes_model";
    public $_data  = [];
    public function __construct(){
        parent::__construct();
        if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
            $this->user_info["is_system"] = 1;
            $this->session->set_userdata('user_info', $this->user_info);
        }else{
            $this->check_login();
        }
        ini_set('max_execution_time', 0);
        $this->_data["containerClass"] = "full-content";
        $this->session->set_flashdata('post',$this->input->post());
        $this->session->set_flashdata('get',$this->input->get());
    }
    public function index(){
        $limit  = 20;
        $offset = $this->input->post("per_page") ? $this->input->post("per_page") : 0;
        $this->load->model($this->_model);
        $this->_data["tables"] = $this->{$this->_model}->get($offset,$limit,["is_system" => 1]);
        $total_rows = $this->Common_model->count_table($this->_fix.$this->_table,["is_system" => 1]);
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
        $this->_data["action_create"] = backend_url('themes/'.$this->_cname."s/create");
        $this->pagination->initialize($config);
        $this->_data["_cname"] = $this->_cname;
        $this->load->view($this->_view . "/index",$this->_data);
    }
     public function member(){
        $limit  = 40;
        $offset = $this->input->post("per_page") ? $this->input->post("per_page") : 0;
        $this->load->model($this->_model);
        $this->_data["tables"] = $this->{$this->_model}->get($offset,$limit,["is_system" => 0]);
        $total_rows = $this->Common_model->count_table($this->_fix.$this->_table,["is_system" => 0]);
        $this->load->library('pagination');
        $config['base_url']   = backend_url($this->_cname.'/member');
        $config['total_rows'] = $total_rows;
        $config['per_page']   = $limit;
        $config['page_query_string'] = true;
        $config['full_tag_open'] = '<nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_links'] = 3;
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
        $this->_data["action_create"] = backend_url('themes/'.$this->_cname."s/create");
        $this->pagination->initialize($config);
        $this->_data["_cname"] = $this->_cname;
        $this->load->view($this->_view . "/member",$this->_data);
    }
    public function delete($id = null){
	    $this->load->model($this->_model);
	    $this->load->model("Sections_model");
	    $this->load->model("Blocks_model");
	    //!create new theme;
	    //get all section default ;

	    $theme = $this->Common_model->get_record($this->_fix."themes",["id" => $id ]);
	    if(!$theme) {
	    	$this->message('Theme không tồn tại','success');
        	redirect(backend_url($this->base_controller));
	    }
	    if($id != 0){
        	$lsections = $this->{$this->_model}->get_sections($id);
	    	$section = [];
            foreach ($lsections as $key_s => $value) {  
                $theme_section_id = $value["theme_section_id"];
                //delete styles section.
                $this->Common_model->delete($this->_fix."style_meta",["reference_id" => $theme_section_id,"support_key" => "section"]);
                //!delete styles section. 

                //delete action section.
                $this->Common_model->delete($this->_fix."section_action",["theme_section_id" => $theme_section_id]);
                //!delete action section.

                $lblocks = $this->{$this->_model}->get_blocks($value["id"],$theme_section_id,$value["default_block"],$value["ncolum_show_block"],0);           
                foreach ($lblocks as $key_b => $value_b) {
                    //get order section block;
                    $section_block_id = $value_b["section_block_id"];
                    $this->Common_model->delete($this->_fix."block_part_meta",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id,
			            "section_block_id !=" => 0,
			            "theme_section_id !=" => 0
                    ]);
                    $this->Common_model->delete($this->_fix."part_action",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id
                    ]);
                    $this->Common_model->delete($this->_fix."block_action",[
                    	"section_block_id" => $section_block_id,
                    	"theme_section_id" => $theme_section_id
                    ]);  
                    $block_part_orders = $this->Common_model->get_result($this->_fix."section_block_part_order",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id,
                    ]);
                    foreach ($block_part_orders as $key => $value) {
                    	$this->Common_model->delete($this->_fix."section_block_part",["id" => $value["block_part_id"]]);
                    }
                    $this->Common_model->delete($this->_fix."section_block_part_order",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id,
                    ]);
					$section_block_orders = $this->Common_model->get_result($this->_fix."section_block_order",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id,
                    ]);
                    foreach ($section_block_orders as $key => $value) {
                    	$this->Common_model->delete($this->_fix."section_block",["id" => $value["section_block_id"]]);
                    }
                    $this->Common_model->delete($this->_fix."section_block_part_order",[
			            "section_block_id" => $section_block_id,
			            "theme_section_id" => $theme_section_id,
                    ]);

                }
                $this->Common_model->delete($this->_fix."section_order",[
		            "theme_section_id" => $theme_section_id,
	            ]);
	            $this->Common_model->delete($this->_fix."section",[
		            "id" => $theme_section_id,
	            ]);
            }
        }
	    $styles = $this->Common_model->delete($this->_fix."style_meta",["reference_id" => $id,"support_key" => "theme"]);
        $this->Common_model->delete($this->table,array("ID" => $id));
        $this->message('Xóa thành công','success');
        redirect(backend_url($this->base_controller));
    }
    public function export(){
        $theme_id = $this->input->post('id');
        $html = $this->input->post('html');
        $theme = $this->Common_model->get_record($this->_fix."themes",["id" => $theme_id ]);
        if($theme){
            $folder = $this->Common_model->get_record($this->_fix."medias",["id" => $theme["folder"] ]);
            $content = str_replace(base_url($folder["path"]),"",$html);
            $content = str_replace($folder["path"],"",$content);
            $index_file = "example/index1.php";
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
            $content_index = str_replace("[[BASE_STYLE]]","style.css",$content_index);
            $content_index = str_replace("[[BASE_MAIN]]","main.js",$content_index);
            $sound = $this->Common_model->get_record($this->table_prefix."theme_medias",["id" => $theme["sound_file"]]);
            $content_index = str_replace("[[UNQEID]]",uniqid(),$content_index);
            if($sound){
                $content_index = str_replace("[[SOUND_URL]]",base_url($sound["path"]),$content_index);
            }else{
                $content_index = str_replace("[[SOUND_URL]]","",$content_index);
            }    
            $fp = fopen(FCPATH . "/" .$folder["path"]. "/index.html","wb");
            fwrite($fp,$content_index);
            fclose($fp);
            $fp = fopen(FCPATH . "/" .$folder["path"]. "/config.json","wb");
            fwrite($fp,json_encode($theme));
            fclose($fp);
            // Get real path for our folder
            $rootPath = realpath(FCPATH . "/" .$folder["path"]);

            // Initialize archive object
            $zip = new ZipArchive();
            $zip->open($theme["slug"].'.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

            // Create recursive directory iterator
            /** @var SplFileInfo[] $files */
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($rootPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file)
            {
                // Skip directories (they would be added automatically)
                if (!$file->isDir())
                {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $relativePath);
                }
            }

            // Zip archive will be created only after closing object
            $zip->close();
            $data = [
                "url" => base_url("/appthemes/dowloadtheme/".$theme_id),
                "name" => $theme["slug"].'.zip'
            ];
            die(json_encode($data));
        }
    }
    public function import (){
        $config['upload_path'] = "/uploads/Themes/";
        $data_file["size"]      = $_FILES["theme"]["size"];
        $config['allowed_types'] = '*';
        if (!is_dir(FCPATH . $config['upload_path'] )) {
          mkdir(FCPATH . $config['upload_path'] , 0777, TRUE);
        }
        $config['file_ext_tolower'] = TRUE;
        $config["upload_path"]      = FCPATH . @$config["upload_path"];
        $this->load->library('upload');
        $this->upload->initialize($config);
        $inqueIn = uniqid();
        if ( ! $this->upload->do_upload("theme"))
        {
           $data = $this->upload->display_errors();    
        }else{
            $data = $this->upload->data();
            $full_path = $data["full_path"];
            $folder = $config['upload_path']."/".$inqueIn;
            $zip = new ZipArchive;
            if ($zip->open($full_path) === TRUE) {
                $zip->extractTo($folder);
                $zip->close();
                unlink($full_path);
                if(file_exists($folder .'/config.json')){
                    $content = file_get_contents($folder .'/config.json');
                    $configFile =  json_decode($content,true);
                    if(@$configFile["id"]){
                        $theme = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $configFile["id"]]);
                        if($theme){
                            $data = $this->get_section($theme["id"]);
                            $filesfolder = scandir($folder,1);
                            $path_folder = "/11/";
                            $dir_folder = "/uploads/Themes/". $inqueIn ."/";
                            $path       = $dir_folder;
                            $extension  = "folder";
                            $i = [
                                "name" => $inqueIn,
                                "dir_folder" => $dir_folder,
                                "path"  => $path,
                                "extension" => $extension,
                                "folder_id" => 11,
                                "path_folder" => $path_folder,
                                "type_id"     => 2

                            ];
                            $newID = $this->Common_model->add($this->_fix."medias",$i);
                            $path_folder = $path_folder.$newID."/";
                            $theme_id = $data["id"];
                            $this->Common_model->update($this->_fix."medias",["path_folder" => $path_folder],["id" => $newID]);
                            $this->Common_model->update($this->_fix."themes",["folder" => $newID],["id" => $theme_id]);
                            $this->insertsMedia($path,$dir_folder,$path_folder,$newID);
                        }
                    }
                }
                
            } else {
                echo 'failed';
            }
        }

    }
    private function insertsMedia($url,$path_folder,$dir_folder,$id){
        $filesfolder = scandir(FCPATH ."/". $url,1);
        foreach ($filesfolder as $key => $file) {
            if(trim($file) != "." && trim($file) != ".." &&file_exists(FCPATH . $url . "/" .$file)){
                if( is_dir (FCPATH . $url . "/" .$file)) {
                    $ext = "folder";
                    $type_id = 2;
                }
                else{
                    $ext = pathinfo($dir_folder . "/" .$file, PATHINFO_EXTENSION);
                    $this->db->from($this->_fix."media_type");
                    $this->db->like('extension', '/'.$ext.'/');
                    $exe = $this->db->get()->row_array();
                    if($exe == null){
                      $type_id = 3;
                      $exe  = $this->Common_model->get_record($this->_fix."media_type",["id" => 3]);
                    }else{
                      $type_id = $exe["id"];
                    }
                }
                $newpath = str_replace("//", "/",($url . "/" .$file)); 
                $dir_folder = str_replace("//", "/",($dir_folder ."/")); 
                $path_folder = str_replace("//", "/",$path_folder); 
                $i = [
                    "name"         => $file,
                    "dir_folder"   => $dir_folder,
                    "path"         => $newpath,
                    "extension"    => $ext,
                    "folder_id"    => $id,
                    "path_folder"  => $path_folder,
                    'type_id'      => $type_id
                ];
                $newID = $this->Common_model->add($this->_fix."medias",$i);
                $u = [];
                if(is_dir (FCPATH . $i["path"]) ){
                    $url1 = str_replace("//", "/",$url ."/". $file);
                    $dir_folder1 = $dir_folder ."/". $file;
                    $path_folder1 = $path_folder ."/". $newID;
                    $id1 = $newID;
                    $this->insertsMedia($url1,$path_folder1,$dir_folder1,$id1);
                }else{
                    $thumb = str_replace("//", "/",$url ."/thumb/". $file);
                    $small = str_replace("//", "/",$url ."/small/". $file);
                    $medium = str_replace("//", "/",$url ."/medium/". $file);
                    $large = str_replace("//", "/",$url ."/large/". $file);
                    $full = str_replace("//", "/",$url ."/full/". $file);
                    if(file_exists(FCPATH . "/" .$thumb)){
                        $u['thumb'] = $thumb;
                    }else{
                        $u['thumb'] = $i['path'];
                    }
                    if(file_exists(FCPATH . "/" .$small)){
                        $u['small'] = $small;
                    }else{
                        $u['small'] = $i['path'];
                    }
                    if(file_exists(FCPATH . "/" .$medium)){
                        $u['medium'] = $medium;
                    }else{
                        $u['medium'] = $i['path'];
                    }
                    if(file_exists(FCPATH . "/" .$large)){
                        $u['large'] = $large;
                    }else{
                        $u['large'] = $i['path'];
                    }
                    if(file_exists(FCPATH . "/" .$full)){
                        $u['full'] = $full;
                    }else{
                        $u['full'] = $i['path'];
                    }
                }
                $u["path_folder"] = $path_folder . $newID;
                $this->Common_model->update($this->_fix."medias",$u,["id" => $newID]);
            }         
        }
    }
    private function get_section($id){
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $data = [
            'status' => 'error',
            'message' => null,
            'response' => null ,
            'record' => null,
            'post' => $this->input->post() 
        ];
        $lblocks = $lsections = $metas = $styles = $style= $theme = $lparts = null;
        $block_action_inserts = $action_inserts = $sbods =  $section_action_insert = $style_meta_inserts = $old_ord_inserts =  $inserts = [];
        $this->load->model($this->_model);
        $this->load->model('Sections_model');
        $this->load->model('Blocks_model');
        $is_create = 1;
        $theme_id = 0;
        if($is_create == 1){
            $clone_theme = $this->Common_model->get_recode_for_select($this->_fix.'themes','id,clone_id,effect,effect_file,effect_media_id,name,description,user_fonts,thumb,font_file,style_file,sound_file,size_title,color_title,is_system,folder,sound_play,sound_example',['id' => $id]);
            $clone_theme['clone_id']  = $clone_theme['id'];
            $clone_theme['is_system'] = 1;
            $clone_theme['public']    = 1;
            $clone_theme['status']    = 1;
            $clone_theme['member_id'] = 0;
            $clone_theme['slug']      = uniqid();
            unset($clone_theme['id']);
            $theme_id  = $this->Common_model->add($this->_fix.'themes',$clone_theme);
        }
        $theme = $this->Common_model->get_record($this->_fix.'themes',['id' => $is_create == 1 ? $theme_id : $id ,'is_delete' => 0]);
        if($theme == null){
            //$data['redirect'] = base_url('themes/my');
            die(json_encode($data));
        }
        $lsections = $this->{$this->_model}->get_sections($id); 
        //!create new theme;
        //get all section default ;    
        $section = [];
        foreach ($lsections as $key_s => $value) {
            //clone section;   
            $value['sort']         = $key_s;      
            $value['theme_id']     = $is_create == 1 ? @$theme_id : $id;
            $value['ramkey']       = uniqid();
            $value['style']        = null; 
            $value['blocks']       = [];
            $theme_section_id = $value['theme_section_id'];
            $metas  = $this->Common_model->get_result_for_select($this->_fix.'block_part_meta','id,theme_section_id,section_block_id,block_part_id,meta_key,value,media_id,sort',
                [
                    'theme_section_id' => $theme_section_id,
                ],
                null, null, [['field' => 'sort','sort' => 'ASC']]
            ); 
            $styles = $this->Common_model->get_result($this->_fix.'style_meta',['reference_id' => $theme_section_id,'support_key' => 'section']);
            if($styles){
                foreach ($styles as $key_st => $value_st) {
                    $value['style'][$value_st['meta_key']] = $value_st['value'];
                    if($value_st['meta_key'] == 'background-image'){
                        if (strpos($value['style'][$value_st['meta_key']], 'http') === false) {
                            $value['style'][$value_st['meta_key']] = str_replace('/uploads',base_url('uploads'),$value_st['value']);
                        }
                    }   
                } 
            }else{
                $value['style'] = (object) array();
            }
            $old_id = $value['theme_section_id'];
            //clone order theme section;
            if($is_create == 1 ){
                $value['theme_section_id']  = $this->Common_model->add($this->_fix.'section',[
                    'theme_id'   => $theme_id,
                    'section_id' => $value['id'],
                    'is_default' => 0,
                    'clone_id'   => $theme_section_id
                ]);
                $old_ord = $this->Common_model->get_recode_for_select($this->_fix.'section_order','layout_show_block,name,class_name,is_full,show_title,ncolum_block,ncolum_show_block,default_block',['theme_section_id' => $old_id]);
                $old_ord['name'] = $value['name'];
                $old_ord['theme_section_id'] = $value['theme_section_id'];
                $old_ord['sort'] = $key_s;
                $old_ord_inserts[] = $old_ord;
                if($styles){
                    $b = [];
                    foreach ($styles as $key_st => $value_st) {
                        $value_st['reference_id'] = $value['theme_section_id'];
                        $style_meta_inserts[] = $value_st;
                    } 
                }
            }   
            //!clone order theme section;
            $value['actions'] = null;
            if($is_create != 2){
                $value['actions'] = $actions = $this->Sections_model->get_action_like('/section/',$old_id,1);
                if($is_create == 1){
                    foreach ($actions as $key => $value_a) {
                        $value_a['theme_section_id'] = $value['theme_section_id'];
                        $value_a['is_default'] = 0;
                        $section_action_insert[] = [
                            'theme_section_id' => $value_a['theme_section_id'],
                            'action_id'        => $value_a['id'],
                            'active'           => $value_a['active'],
                            'is_default'       => 0
                        ];
                        $value['actions'][] = $value_a;
                    }
                }
            }
            //clone blocks default;
            $lblocks = $this->{$this->_model}->get_blocks($value['id'],$theme_section_id,$value['default_block'],$value['ncolum_show_block'],0);     
            foreach ($lblocks as $key_b => $value_b) {
                //get order section block;
                $sort_block = 0;
                $section_block_id = $value_b['section_block_id'];
                $is_default = 0;
                $sbod = $this->Common_model->get_recode_for_select($this->_fix.'section_block_order','section_block_id,ncolum,class_name,is_form',['section_block_id' => $section_block_id ,'is_default' => $is_default,'theme_section_id' => $theme_section_id]);
                if($sbod){
                    $sbod['theme_section_id'] = $value['theme_section_id'];
                    $sbod['is_default'] = 0;
                    $sbod['sort'] = $key_b;
                    if($is_create == 1){
                        $sbods[] =  $sbod;
                    }
                    //clone part block;
                    $lparts = $this->{$this->_model}->get_parts($value_b['id'],$section_block_id,$theme_section_id);
                    $sort_part = 0;
                   
                    foreach ($lparts as $key_p => $value_p) {
                        $value_p['actions'] = [];
                        $value_p['metas']   = [];
                        $value_p['ramkey']  = uniqid();
                        if($is_create == 1){
                            $inserts[] = [
                                'section_block_id' => $section_block_id,
                                'theme_section_id' => $value['theme_section_id'],
                                'block_part_id'    => $value_p['block_part_id'],
                                'sort'             => $value_p['sort'],
                                'ncolum'           => $value_p['ncolum'],
                                'id_name'          => $value_p['id_name'],
                                'class_name'       => $value_p['class_name'],
                            ];
                        }
                        $value_p['theme_section_id'] = $value['theme_section_id'];
                        //clone action part
                            $value_p['actions'] = null;
                            $actions = null;
                            if($is_create != 2){
                                $actions = $this->{$this->_model}->get_actions_part($value_p['block_part_id'],$section_block_id,$theme_section_id);
                            }
                            if($is_create == 1 && @$actions){
                                $value_p['actions'] = [];
                                foreach ($actions as $key_a => $value_a) {
                                    $action_inserts [] = [
                                        'block_part_id'    => $value_p['block_part_id'],
                                        'section_block_id' => $section_block_id,
                                        'theme_section_id' => $value['theme_section_id'],
                                        'action_id'        => $value_a['id'],
                                        'active'           => $value_a['active']
                                    ];
                                    $value_a['block_part_id']    = $value_p['block_part_id'];
                                    $value_a['section_block_id'] = $section_block_id;
                                    $value_a['theme_section_id'] = $value['theme_section_id'];
                                    $value_p['actions'][]        = $value_a;
                                }
                            }
                        //!clone action part        
                        //clone meta part
                        $value_p['metas'] = [];
                        foreach ($metas as $key_m => $value_m) {
                            if($value_m['block_part_id'] == $value_p['block_part_id'] && $value_m['section_block_id'] == $section_block_id){
                                if($is_create == 1){
                                    $value_m['id'] = $this->Common_model->add($this->_fix.'block_part_meta', [
                                        'block_part_id'    => $value_p['block_part_id'],
                                        'section_block_id' => $section_block_id,
                                        'theme_section_id' => $value['theme_section_id'],
                                        'meta_key'         => $value_m['meta_key'],
                                        'value'            => $value_m['value'],
                                        'media_id'         => $value_m['media_id'],
                                    ]);
                                }
                                $value_m['theme_section_id'] = $value['theme_section_id'];
                                if($value_m['media_id'] != 0){
                                    $media = $this->Common_model->get_record($this->_fix.'medias',['id' => $value_m['media_id']]);
                                    if($media){
                                        unset($media['id']);
                                        $value_m = array_merge($media,$value_m);
                                    }
                                }
                                $value_m['ramkey']  = uniqid();
                                $value_m['section_block_id']  = $section_block_id;
                                $value_m['theme_section_id']  = $theme_section_id;
                                $value_m['block_part_id']     = $value_p['block_part_id'];
                                $value_p['metas'][] = $value_m;
                                unset($metas[$key_m]);
                            }   
                        }                                                               
                        //!clone meta part
                        $value_p['sort'] = $sort_part;
                        $sort_part++;
                        $value_b['parts'][] =  $value_p;  
                    }
                    //!clone part block;
                    //clone action block;
                    $actions = null;
                    if($is_create != 2){
                        $value_b['actions'] = $actions = $this->Blocks_model->get_actions($section_block_id,$theme_section_id,1);
                    }
                    if($is_create == 1 && @$actions){
                        $value_b['actions'] = [];
                        foreach ($actions as $key => $value_a) {
                            $block_action_inserts[] = [
                                'section_block_id' => $section_block_id,
                                'theme_section_id' => $value['theme_section_id'],
                                'action_id'        => $value_a['id'],
                                'active'           => $value_a['active'],
                            ];
                            $value_a['theme_section_id'] = $value['theme_section_id'];
                            $value_b['actions'][] = $value_a;
                        }
                    }                   
                    //!clone action block;
                }
                $value_b['theme_section_id'] = $value['theme_section_id'];
                $value_b['sort'] = $sort_block;
                $value_b['ramkey']  = uniqid();
                //!get order section block; 
                $value['blocks'][] = $value_b;
                $sort_block++;
            } 
            //!clone blocks default;
            $section[] = $value;
            //!clone section;
        }
        //unset($value);
        if($is_create == 1){
            if($block_action_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'block_action',$block_action_inserts);
            if($action_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'part_action',$action_inserts);
            if($sbods)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order',$sbods);
            if($section_action_insert)
                $this->Common_model->insert_batch_data($this->_fix.'section_action',$section_action_insert);
            if($style_meta_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'style_meta',$style_meta_inserts); 
            if($old_ord_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_order',$old_ord_inserts);
            if($inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_part_order',$inserts);       
        }       
        if($is_create != 2){
            if($is_create == 1){
                $data['sectionsv'] = $lsections;
            }else{
                $data['sectionsv']  = $this->{$this->_model}->get_sections($theme['clone_id']); 
            }
        } 
        $styles = $this->Common_model->get_result($this->_fix.'style_meta',['reference_id' => $is_create == 1 ? $theme_id : $id,'support_key' => 'theme']);
        $theme['style'] = null;
        if($styles){
            foreach ($styles as $key => $value) {
                $theme['style'][$value['meta_key']] = $value['value'];
                if($value['meta_key'] =='background-image'){
                    if (strpos( $value['value'],'http') === false) {
                        $theme['style'][$value['meta_key']]  = str_replace('/uploads',base_url('uploads'),$value['value']);
                    }
                }
            }
        }
        else{
            $theme['style'] = (object) array();
        }
        if(!trim($theme['effect_file'])){
            unset($theme['effect_file']) ;
        }else{
            $theme['effect_file'] = json_decode($theme['effect_file'],true);
        }
        if(is_numeric($theme ['font_file'])){
            $font = $this->Common_model->get_record('font',['id' => $theme['font_file']]);
            $theme['font'] = $font;
        }else{
            $theme['font'] = null;
        }
        if(is_numeric($theme ['sound_file'])){
            if($theme['sound_example'] == 0){
                $sound = $this->Common_model->get_record($this->_fix.'background_music',['id' => $theme['sound_file']]);
                if($sound)
                $m = $this->Common_model->get_record($this->_fix.'medias',['id' => $sound['media_id']]);
                if($sound && $m){
                    $sound = array_merge($m,$sound);
                } 
            }else{
                $sound = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['sound_file']]);
            }
            $theme['sound'] = $sound;
        }else{
            $theme['sound'] = null;
        }
        if(is_numeric($theme ['folder'])){
            $style = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['folder']]);
            $theme['style_url']  = $style['path'] . 'style.css';
            $theme['script_url'] = $style['path'] . 'main.js';
        }
        if(is_numeric($theme ['thumb'])){
            $thumb = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['thumb']]);
            $theme['thumb_url'] = $thumb['path'];
        }
        $data = $theme ;
        return ( $data );  
    }
    public function get_theme_v2(){
        $ts  = $this->Common_model->get_result($this->_fix."themes");
        $tID = $sID = $bID = $pID = $mID = $mdID = [];
        $theme_section_id = $section_block_id = $block_part_id = 0;
        foreach ($ts as $key => $value) {
            $tID [] = $value["id"];
            $ss = $this->Common_model->get_result($this->_fix."section",["theme_id" => $value["id"]]);
            foreach ($ss as $key_1 => $value_1) {
                $theme_section_id = $value_1["id"];
                $sID[] = $theme_section_id;
                $bs = $this->Common_model->get_result($this->_fix."section_block_order",["theme_section_id" => $theme_section_id]);
                foreach ($bs as $key_2 => $value_2) {
                    $section_block_id = $value_2["section_block_id"];
                    $bID[] = $section_block_id;
                    $ps = $this->Common_model->get_result($this->_fix."section_block_part_order",["theme_section_id" => $theme_section_id,"section_block_id" => $section_block_id]);
                    foreach ($ps as $key_3 => $value_3) {
                        $block_part_id = $value_3["block_part_id"];
                        $pID[] = $block_part_id;
                        $ms =  $this->Common_model->get_result($this->_fix."block_part_meta",["block_part_id" => $block_part_id,"theme_section_id" => $theme_section_id,"section_block_id" => $section_block_id]);
                        foreach ($ms as $key_4 => $value_4) {
                            $mID[] = $value_4["id"];
                        }
                    }
                }
            }
        }

        $this->db->where_not_in("id",$tID);
        $this->db->delete($this->_fix."medias");
        $this->db->reset_query();

        $this->db->where_not_in("theme_id",$tID);
        $this->db->delete($this->_fix."allow_screen");
        $this->db->reset_query();


        $this->db->where_not_in("reference_id",$tID);
        $this->db->where("support_key","theme");
        $this->db->delete($this->_fix."style_meta");
        $this->db->reset_query();

        echo "<pre>";
        print_r($sID);
        echo "</pre>";
        $this->db->where_not_in("id",$sID);
        $this->db->delete($this->_fix."section");
        $this->db->reset_query();
        $this->db->where_not_in("theme_section_id",$sID);
        $this->db->delete($this->_fix."section_order");
        $this->db->reset_query();

        $this->db->where_not_in("theme_section_id",$sID);
        $this->db->delete($this->_fix."section_action");
        $this->db->reset_query();

        $this->db->where_not_in("reference_id",$sID);
        $this->db->where("support_key","section");
        $this->db->delete($this->_fix."style_meta");
        $this->db->reset_query();

        echo "_____________________________________________________________";
        echo "<pre>";
        print_r($bID);
        echo "</pre>";
        $this->db->where_not_in("id",$bID);
        $this->db->delete($this->_fix."section_block");
        $this->db->reset_query();
        $this->db->where_not_in("section_block_id",$bID);
        $this->db->delete($this->_fix."section_block_order");
        $this->db->reset_query();

        $this->db->where_not_in("section_block_id",$bID);
        $this->db->delete($this->_fix."block_action");
        $this->db->reset_query();
        echo "_____________________________________________________________";
        echo "<pre>";
        print_r($pID);
        echo "</pre>";
        $this->db->where_not_in("id",$pID);
        $this->db->delete($this->_fix."section_block_part");
        $this->db->reset_query();
        $this->db->where_not_in("block_part_id",$pID);
        $this->db->delete($this->_fix."section_block_part_order");
        $this->db->reset_query();
        $this->db->where_not_in("block_part_id",$pID);
        $this->db->delete($this->_fix."part_action");
        $this->db->reset_query();
        echo "_____________________________________________________________";
        echo "<pre>";
        print_r($mID);
        echo "</pre>";
        $this->db->where_not_in("id",$mID);
        $this->db->delete($this->_fix."block_part_meta");
        $this->db->reset_query();
        $this->output->enable_profiler(TRUE);
    }
    public function update_slug(){
        $this->db->select("tbl1.*");
        $this->db->from($this->_fix . "themes AS tbl1");
        $this->db->where(["tbl1.is_system" => 1 ,"tbl1.public" => 1 ,"tbl1.status" => 1,'version' => 3]);
        $t = $this->db->get()->result_array();
        foreach ($t as $key => $value) {
            $clone_id = $value["clone_id"];
            $tt = $this->Common_model->get_record($this->_fix . "themes",["id" => $clone_id]);
            if($tt){
                $this->Common_model->update(
                    $this->_fix . "themes",
                    ["slug" => $tt["slug"]],
                    ["id" => $value["id"]]
                );
                $this->Common_model->update(
                    $this->_fix . "themes",
                    ["slug" => uniqid()],
                    ["id" => $value["clone_id"]]
                );
            }
        }
    }
    public function updateParent (){
        $this->load->model($this->_model);
        $this->load->model('Sections_model');
        $this->load->model('Blocks_model');
        $themes = $this->Common_model->get_result($this->_fix. "themes",["version" => 3]);
        foreach ($themes as $key => $value) {
            $parent_theme = $this->Common_model->get_record($this->_fix. "themes",["id" => $value["clone_id"]]);
            $parent_theme_sections = $this->{$this->_model}->get_sections($parent_theme["id"]);
            $theme_sections = $this->{$this->_model}->get_sections($value["id"]);
            $allow_widths = $this->Common_model->get_result($this->_fix. "allow_screen",["theme_id" => $value["id"]]);
            foreach ($allow_widths as $keys => $values) {
                $values["theme_id"] = $value["clone_id"];
                $values["version"] = 1;
                unset($values["id"]);
                $this->Common_model->add($this->_fix. "allow_screen",$values);
            }
            foreach ($theme_sections as $key_1 => $value_1) {
                $theme_section_id = $value_1["theme_section_id"];
                $clone_id = $value_1["clone_id"];
                $value_1["theme_section_id"] = $clone_id;
                $metastyles = $this->Common_model->get_result($this->_fix. "style_meta",["reference_id" => $theme_section_id ,"support_key" => "section"]);
                foreach ($metastyles as $keyss => $valuess) {
                    $valuess["reference_id"] = $clone_id;
                    $valuess["version"] = 1;
                    $this->Common_model->add($this->_fix. "style_meta",$valuess);
                }
                $soss = $this->Common_model->get_result($this->_fix. "section_order_setting",["theme_section_id" => $theme_section_id]);
                foreach ($soss as $key_4 => $value_4) {
                    $value_4["theme_section_id"] = $clone_id;
                    $this->Common_model->add($this->_fix. "section_order_setting",$value_4);
                }
                $Plblocks = $this->{$this->_model}->get_blocks(
                    $value_1["id"],
                    $clone_id
                );
                $Clblocks = $this->{$this->_model}->get_blocks(
                    $value_1["id"],
                    $theme_section_id
                );
                foreach ($Clblocks as $key_2 => $value_2) {
                    $section_id = $value_2['section_id'];
                    $block_id   = $value_2['block_id'];
                    $sort       = $value_2['sort'];
                    if(@$Plblocks[$sort] && $Plblocks[$sort]["section_id"] == $section_id && $Plblocks[$sort]["block_id"] == $block_id){
                        $section_block_id = $Clblocks[$sort]["section_block_id"];
                        $sbss = $this->Common_model->get_result($this->_fix . "section_block_order_setting",["section_block_id" => $section_block_id]);
                        foreach ($sbss as $key_3 => $value_3) {
                            $value_3["section_block_id"] = $Plblocks[$sort]["section_block_id"];
                            $value_3["theme_section_id"] = $Plblocks[$sort]["theme_section_id"];
                            $value_3["version"]          = 1;
                            $check = $this->Common_model->get_record($this->_fix . "section_block_order_setting",[
                                "section_block_id" => $Plblocks[$sort]["section_block_id"],
                                "theme_section_id" => $Plblocks[$sort]["theme_section_id"],
                                "allow_width"      => $value_3["allow_width"],
                                "version"          =>  1
                            ]);
                            if($check == null)
                                $this->Common_model->add($this->_fix . "section_block_order_setting",$value_3);
                        }
                    }
                }
                
            }
            
        }
    }
    public function updateCloneid (){
        $this->load->model($this->_model);
        $this->load->model('Sections_model');
        $this->load->model('Blocks_model');
        $themes = $this->Common_model->get_result($this->_fix. "themes",[
            "version"   => 1,
            'is_system' => 1,
            "status"    => 1
        ]);
        $section_block_order_settings = $style_metas = $section_order_settings = $allow_screens = [];
        foreach ($themes as $key => $value) {
            $theme_id = $value["id"];
            $cThemes = $this->Common_model->get_result($this->_fix . "themes",
                [
                    "clone_id"  => $theme_id,
                    'is_system' => 0
                ]
            );
            $allow_widths = $this->Common_model->get_result($this->_fix. "allow_screen",["theme_id" =>  $theme_id]);
            foreach ($cThemes as $key_1 => $value_1) {
                if($allow_widths){
                    foreach ($allow_widths as $key_allow_width => $value_allow_width) {           
                        $ff = $this->Common_model->get_record($this->_fix . "allow_screen",[
                            "theme_id"     => $value_1["id"],
                            "version"      => 1,
                        ]);
                        if($ff == null);{
                            unset($value_allow_width["id"]);
                            $value_allow_width["theme_id"] = $value_1["id"];
                            $value_allow_width["version"] = 1;
                            $this->Common_model->add($this->_fix. "allow_screen",$value_allow_width);
                        }
                    }
                }    
                $child_sections = $this->{$this->_model}->get_sections($value_1["id"]);
                foreach ($child_sections as $key_2 => $value_2) {
                    $theme_section_id = $value_2["theme_section_id"];
                    $clone_id = $value_2["clone_id"];
                    $metastyles = $this->Common_model->get_result($this->_fix. "style_meta",["reference_id" => $clone_id ,"support_key" => "section"]);
                    if($metastyles ){
                    	foreach ($metastyles as $key_3 => $value_3) {
                    		if( $value_3 ){
                    			$value_3["reference_id"] = $theme_section_id;
		                        $value_3["version"] = 1;
		                        $check = $this->Common_model->get_record($this->_fix . "style_meta",[
		                            "reference_id" => $theme_section_id,
		                            "allow_width"  => $value_3["allow_width"],
		                            "version"      =>  1,
		                            "support_key"  => "section"
		                        ]);
		                        if($check == null)
		                            $style_metas [] = $value_3;
                    		}
	                        
	                    }
                    }
                    
                    $settingblock = $this->Common_model->get_result($this->_fix. "section_block_order_setting",["theme_section_id" => $clone_id]);
                    foreach ($settingblock as $key_4 => $value_4) {
                        $value_4["theme_section_id"] = $theme_section_id;
                        $value_4["version"] = 1;
                        $check = $this->Common_model->get_record($this->_fix . "section_block_order_setting",[
                            "section_block_id" => $value_4["section_block_id"],
                            "theme_section_id" => $theme_section_id,
                            "allow_width"      => $value_4["allow_width"],
                            "version"          =>  1
                        ]);
                        if($check == null)
                            $section_block_order_settings [] = $value_4;
                    }
                    $settingsection = $this->Common_model->get_result($this->_fix. "section_order_setting",["theme_section_id" => $clone_id]);
                    foreach ($settingsection as $key_5 => $value_5) {
                        $value_5["theme_section_id"] = $theme_section_id;
                        $value_5["version"] = 1;
                        $check = $this->Common_model->get_record($this->_fix . "section_order_setting",[
                            "theme_section_id" => $theme_section_id,
                            "allow_width"      => $value_5["allow_width"],
                            "version"          =>  1
                        ]);
                        if($check == null)
                            $section_order_settings [] = $value_5;
                    }
                } 
            }
        }
           
        if($style_metas)
            $this->Common_model->insert_batch_data($this->_fix. "style_meta",$style_metas);
        if($section_block_order_settings)
            $this->Common_model->insert_batch_data($this->_fix. "section_block_order_setting",$section_block_order_settings);
        if($section_order_settings)
            $this->Common_model->insert_batch_data($this->_fix. "section_order_setting",$section_order_settings);
    }
}