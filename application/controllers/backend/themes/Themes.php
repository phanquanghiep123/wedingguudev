<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Themes extends CI_Controller {
	public $_fix   = "theme_";
    public $_table = "themes";
	public $_view  = "backend/themes";
	public $_cname = "themes/themes";
	public $_model = "Themes_model";
	public $_data  = [];
	public function __construct(){
  		parent::__construct();
  		if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
            $this->user_info["is_system"] = 1;
            $this->session->set_userdata('user_info', $this->user_info);
        }
        ini_set('max_execution_time', 0);
		$this->_data["containerClass"] = "full-content";
		$this->session->set_flashdata('post',$this->input->post());
		$this->session->set_flashdata('get',$this->input->get());
	}
	public function check_login(){
        if (!$this->session->userdata('admin_info')) {
            $link = (base_url("backend"));
            redirect($link);
        }
    }
	public function index(){
	    $limit  = 40;
	    $offset = $this->input->post("per_page") ? $this->input->post("per_page") : 0;
	    $this->load->model($this->_model);
	    $this->_data["tables"] = $this->{$this->_model}->get($offset,$limit);
	    $total_rows = $this->Common_model->count_table($this->_fix.$this->_table);
	    $this->load->library('pagination');
	    $config['base_url']   = base_url($this->_cname);
	    $config['total_rows'] = $total_rows;
	    $config['per_page']   = $limit;
	    $config['page_query_string'] = true;
	    $this->_data["action_create"] = base_url($this->_cname."/create");
	    $this->pagination->initialize($config);
	    $this->_data["_cname"] = $this->_cname;
	    $this->load->view($this->_view . "/index",$this->_data);
	}
	public function get_groups_backgrounds_sounds(){
        //get groups
        $this->load->model($this->_model);
        $gb = $this->Common_model->get_result($this->_fix."groups_background_music",["type" => 0,"status" => 1]);
        $gm = $this->Common_model->get_result($this->_fix."groups_background_music",["type" => 1,"status" => 1]);
        $f  = $this->{$this->_model}->effects();
        $data = ["backgrounds" => null ,"sounds" => null,'effects' => null];
        $data["effects"] = $f;
        
        if($gb){
          foreach ($gb as $key => $value) {
            $bs = $this->{$this->_model}->get_backgrounds_by_group($value["id"]);
            $value["backgrounds"] = $bs;
            $data["backgrounds"][]= $value;
          }
        }
        if($gm){
          foreach ($gm as $key => $value) {
            $ms = $this->{$this->_model}->get_backgrounds_by_group($value["id"]);
            $value["sounds"] = $ms;
            $data["sounds"][]= $value;
          } 
        }
        echo (json_encode($data));
    }
    public function reloadwidth($id){
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $data = [
            'status' => 'error',
            'message' => null,
            'response' => null ,
            'record' => null,
            'post' => $this->input->post() 
        ];
        $theme_id = $id;
        $lblocks = $lsections = $metas = $styles = $style = $theme = $lparts = null;
        $block_action_inserts = $action_inserts  = $sbods = $section_action_insert = $style_meta_inserts = $old_ord_inserts =  $inserts = [];
        $this->load->model($this->_model);
        $this->load->model('Sections_model');
        $this->load->model('Blocks_model');
        $is_create = 0;
        $oldallow_width = $allow_width  = $this->input->post_get('allowScreen') ? $this->input->post_get('allowScreen') : 1920;
        $allow_screen = $this->Common_model->get_record($this->_fix."allow_screen",[
            "theme_id" => $theme_id,
            "width"    => $allow_width
        ]);
        if($allow_screen == null){
            $allow_screen = $this->Common_model->get_result($this->_fix."allow_screen",[
                "theme_id" => $theme_id
            ]);
            $w = 0;
            $overw = 0;
            $surplus = 0;
            if($allow_screen != null){
                foreach ($allow_screen as $key => $value) {
                    $w = $value["width"];
                    if($key == 0) {
                        $overw = $w;
                        $surplus = ($allow_width - $w);
                        if($surplus < 0) $surplus = $surplus * -1;
                    }else{
                        $megge = $allow_width - $w;
                        if($megge < 0) $megge = $megge * -1;
                        if($surplus > $megge){
                            $surplus = $megge;
                            $overw = $value["width"];
                        }
                    }
                }  
            }else{
                $overw = 1920;
            }
            $oldallow_width = $overw;
        }
        $data['allow_width'] = $oldallow_width;
        $theme = $this->Common_model->get_record($this->_fix.'themes',['id' => $id ,'is_delete' => 0]);
        if($theme == null){
            //$data['redirect'] = base_url('themes/my');
            die(json_encode($data));
        }
        if($oldallow_width != $allow_width){
            $this->Common_model->add($this->_fix."allow_screen",[
                "theme_id" => $theme_id,
                "width"    => $allow_width
            ]);
        }
        $lsections = $this->{$this->_model}->get_sections($id); 
        //!create new theme;
        //get all section default ;    
        $section = [];
        $html_setting = $this->load->view($this->_view.'/templates/html_section/get_info',null,true);
        $html_setting_block = $this->load->view($this->_view.'/templates/html_block/get_info',null,true);
        $html_setting_part = $this->load->view($this->_view.'/templates/html_part/edit',null,true);
        $html_style = $this->load->view($this->_view.'/templates/html_section/style',null,true);
        foreach ($lsections as $key_s => $value) {
            //clone section;   
            $value['sort']         = $key_s;
            $value['html_setting'] = $html_setting;
            $value['html_style']   = $html_style;       
            $value['theme_id']     = $id;
            $value['ramkey']       = uniqid();
            $value['style']        = null; 
            $value['blocks']       = [];
            $theme_section_id = $value['theme_section_id'];
            $metas  = $this->Common_model->get_result_for_select(
                $this->_fix.'block_part_meta',
                'id,theme_section_id,section_block_id,block_part_id,meta_key,value,media_id,sort,allow_width',
                [
                    'theme_section_id' => $theme_section_id,

                ],
                null, null, [['field' => 'sort','sort' => 'ASC']]
            ); 
            $styles = $this->Common_model->get_result(
                $this->_fix.'style_meta',
                [
                    'reference_id'     => $theme_section_id,
                    'support_key'      => 'section'
                ]);
            if($styles){
                foreach ($styles as $key_st => $value_st) {
                    $value['style'][$value_st['meta_key']] = $value_st['value'];
                    if($value_st['meta_key'] == 'background-image'){
                        if (strpos($value['style'][$value_st['meta_key']], 'http') === false) {
                            $value['style'][$value_st['meta_key']] = str_replace('/uploads',base_url('uploads'),$value_st['value']);
                        }
                    } 
                    $check = $this->Common_model->get_record($this->_fix."style_meta",[
                        "reference_id" => $theme_section_id,
                        'support_key'  => 'section',
                        "meta_key"     => $value_st['meta_key']
                    ]);
                    if($check == null){
                        $value_st['reference_id'] = $value['theme_section_id'];
                        $style_meta_inserts[]     = $value_st;
                    }  
                } 
            }else{
                $value['style'] = (object) array();
            }
            $old_id = $value['theme_section_id'];
            //clone order theme section;

            //!clone order theme section;
            $value['actions'] = null;
            $value['actions'] = $actions = $this->Sections_model->get_action_like('/section/',$old_id,1);
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
            //clone blocks default;
            $lblocks = $this->{$this->_model}->get_blocks(
                $value['id'],
                $theme_section_id,
                $value['default_block'],
                $value['ncolum_show_block'],
                0   
            );     
            foreach ($lblocks as $key_b => $value_b) {
                //get order section block;
                $sort_block = 0;
                $section_block_id = $value_b['section_block_id'];
                $is_default = 0;
                $sbod = $this->Common_model->get_recode_for_select(
                    $this->_fix.'section_block_order','section_block_id,ncolum,class_name,id_name,is_form',
                    [
                        'section_block_id' => $section_block_id ,
                        'is_default'       => $is_default,
                        'theme_section_id' => $theme_section_id
                    ]
                );
                if($sbod){
                    $sbod['theme_section_id'] = $value['theme_section_id'];
                    $sbod['is_default'] = 0;
                    $sbod['sort'] = $key_b;
                    if($is_create == 1){
                        $sbod['allow_width'] = $allow_width ;
                        $sbods[] = $sbod;
                    }
                    //clone part block;
                    $lparts = $this->{$this->_model}->get_parts($value_b['id'],$section_block_id,$theme_section_id);
                    $sort_part = 0;
                    foreach ($lparts as $key_p => $value_p) {
                        $value_p['actions'] = [];
                        $value_p['metas']   = [];
                        $value_p['ramkey']  = uniqid();
                        $inserts[] = [
                            'section_block_id' => $section_block_id,
                            'theme_section_id' => $value['theme_section_id'],
                            'block_part_id'    => $value_p['block_part_id'],
                            'sort'             => $value_p['sort'],
                            'ncolum'           => $value_p['ncolum'],
                            'id_name'          => $value_p['id_name'],
                            'class_name'       => $value_p['class_name']
                        ];
                        $value_p['html_setting'] = $html_setting_part;
                        $value_p['theme_section_id'] = $value['theme_section_id'];
                        //clone action part
                        $value_p["actions"] = $this->{$this->_model}->get_actions_part($value_p["block_part_id"],$section_block_id,$theme_section_id);
                        //!clone action part        
                        //clone meta part
                        $value_p['metas'] = [];
                        foreach ($metas as $key_m => $value_m) {
                            if($value_m['block_part_id'] == $value_p['block_part_id'] && $value_m['section_block_id'] == $section_block_id){
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
                        $value_p['html_setting'] = $html_setting_part;
                        $value_p['sort'] = $sort_part;
                        $sort_part++;
                        $value_b['parts'][] =  $value_p;  
                    }
                    //!clone part block;
                    //clone action block;
                    $actions = null;          
                    //!clone action block;
                }
                $value_b['theme_section_id'] = $value['theme_section_id'];
                $value_b['html_setting']     = $html_setting_block;
                $value_b['sort']             = $sort_block;
                $value_b['ramkey']           = uniqid();
                $blocksetting = $this->Common_model->get_recode_for_select(
                    $this->_fix."section_block_order_setting","section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                    [
                        "section_block_id" => $section_block_id,
                        "theme_section_id" => $theme_section_id,
                        "allow_width"      => $allow_width
                    ]
                ); 
                if($blocksetting != null){
                    $value_b = array_merge($value_b,$blocksetting);
                }else{
                    $blocksetting = $this->Common_model->get_recode_for_select(
                        $this->_fix."section_block_order_setting",
                        "section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                        [
                            "section_block_id" => $section_block_id,
                            "theme_section_id" => $theme_section_id,
                            "allow_width"      => $oldallow_width
                        ]
                    ); 
                    if($blocksetting != null){
                        $value_b = array_merge($value_b,$blocksetting);
                        $cloneSettting = [
                            "section_block_id" => @$value_b["section_block_id"],
                            "theme_section_id" => @$value_b["theme_section_id"],
                            "allow_width"      => @$allow_width,
                            "sort"             => @$value_b['sort'],
                            "ncolum"           => @$value_b['ncolum'],
                            "class_name"       => @$value_b['class_name'],
                            "id_name"          => @$value_b['id_name'],
                            "is_form"          => @$value_b['is_form'],
                            "is_default"       => @$value_b['is_default']
                        ];
                        $this->Common_model->add($this->_fix."section_block_order_setting",$cloneSettting);
                    }         
                }
                //!get order section block; 
                $value['blocks'][] = $value_b;
                $sort_block++;
            } 
            //!clone blocks default;
            $value['ramkey']  = uniqid();
            $section_order_setting = $this->Common_model->get_record(
            $this->_fix."section_order_setting",
            [
                "theme_section_id" => $theme_section_id , 
                "allow_width" => $allow_width
            ]);
            if($section_order_setting != null){
                $value = array_merge($value,$section_order_setting);
            }else{
                $section_order_setting = $this->Common_model->get_record(
                $this->_fix."section_order_setting",
                [
                    "theme_section_id" => $theme_section_id , 
                    "allow_width"      => $oldallow_width
                ]);
                if($section_order_setting != null){
                    $value = array_merge($value,$section_order_setting);
                    if($oldallow_width != $allow_width){
                        $this->Common_model->add($this->_fix."section_order_setting",
                            [
                                "theme_section_id"  => $value["theme_section_id"],
                                "allow_width"       => $allow_width,
                                "is_full"           => $section_order_setting["is_full"],
                                "show_title"        => $section_order_setting["show_title"],
                                "default_block"     => $section_order_setting["default_block"],
                                "ncolum_block"      => $section_order_setting["ncolum_block"],
                                "ncolum_show_block" => $section_order_setting["ncolum_show_block"],
                                "layout_show_block" => $section_order_setting["layout_show_block"],
                                "title_size"        => $section_order_setting["title_size"],
                            ]
                        );
                    }
                }else{
                    $this->Common_model->add($this->_fix."section_order_setting",
                        [
                            "theme_section_id"  => $value["theme_section_id"],
                            "allow_width"       => $allow_width,
                            "is_full"           => $value["is_full"],
                            "show_title"        => $value["show_title"],
                            "default_block"     => $value["default_block"],
                            "ncolum_block"      => $value["ncolum_block"],
                            "ncolum_show_block" => $value["ncolum_show_block"],
                            "layout_show_block" => $value["layout_show_block"],
                            "title_size"        => $value["title_size"]
                        ]
                    );
                }
            }
            $section[] = $value;
            //!clone section;
        }
        //unset($value);
        if($style_meta_inserts)
            $this->Common_model->insert_batch_data($this->_fix.'style_meta',$style_meta_inserts);       
        $data['sections'] = $section;
        $data['status'] = 'success';
        echo (json_encode( $data ));  
        return true; 
    }
	public function get_fonts(){
		$f = $this->Common_model->get_result("font");
		die(json_encode($f));
	}
	public function get_section($id = 0){
	    $this->load->model($this->_model);
	    $this->load->model("Sections_model");
	    $this->load->model("Blocks_model");
        $oldallow_width = $allow_width  = $this->input->post_get('allowScreen') ? $this->input->post_get('allowScreen') : 1920;
	    if($id != 0){
	    	$theme_id = $id;
	    }else{
            $insert = [
                "name" => "new theme",
                "is_system" => 1,
                "public"    => 0,
                "status"    => 1,
                "folder"    => 0,
                "slug"      => uniqid()
            ];
	    	$theme_id = $this->Common_model->add($this->_fix."themes",$insert);
           
	    }
        $allow_screen = $this->Common_model->get_record($this->_fix."allow_screen",[
            "theme_id" => $theme_id,
            "width"    => $allow_width
        ]);
        if($allow_screen == null){
            $allow_screen = $this->Common_model->get_result($this->_fix."allow_screen",[
                "theme_id" => $theme_id
            ]);
            $w = 0;
            $overw = 0;
            $surplus = 0;
            if($allow_screen != null){
                foreach ($allow_screen as $key => $value) {
                    $w = $value["width"];
                    if($key == 0) {
                        $overw = $w;
                        $surplus = ($allow_width - $w);
                        if($surplus < 0) $surplus = $surplus * -1;
                    }else{
                        $megge = $allow_width - $w;
                        if($megge < 0) $megge = $megge * -1;
                        if($surplus > $megge){
                            $surplus = $megge;
                            $overw = $value["width"];
                        }
                    }
                }  
            }else{
                $overw = 1920;
            }
            $oldallow_width = $overw;
        }
        // check allow width
	    //!create new theme;
	    //get all section default ;
	    $lsections = $this->{$this->_model}->get_sections($id);
	    $section = [];
        if($id != 0){
            $html_setting_block = $this->load->view("backend/themes/templates/html_block/get_info",null,true);
            $html_setting_part = $this->load->view("backend/themes/templates/html_part/edit",null,true);
            $html_setting = $this->load->view("backend/themes/templates/html_section/get_info",null,true);
            foreach ($lsections as $key_s => $value) {
                //clone section;   
                $value["sort"] = $key_s;
                $value["html_setting"] = $html_setting;
                $value["theme_id"] = $theme_id;
                $value["ramkey"] = uniqid();
                $value["style"] = null; 
                $theme_section_id = $value["theme_section_id"];
                $styles = $this->Common_model->get_result($this->_fix."style_meta",[
                    "reference_id" => $theme_section_id,
                    "support_key" => "section"
                ]);
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
                    $value["style"] = (object) array();
                }
                
                $old_id = $value["theme_section_id"];
                //get all action default;
                $value["actions"] = $this->Sections_model->get_action_like("/section/",$old_id);
                //!get all action default;
                $lblocks = $this->{$this->_model}->get_blocks(
                    $value["id"],
                    $theme_section_id,
                    $value["default_block"],
                    $value["ncolum_show_block"],
                    0
                );
                $metas  = $this->Common_model->get_result_for_select($this->_fix."block_part_meta","id,section_block_id,block_part_id,meta_key,value,media_id,sort",
                    [
                        "theme_section_id" => $theme_section_id,
                    ]
                );
                $block_new = [];            
                foreach ($lblocks as $key_b => $value_b) {
                    //get order section block;
                    $sort_block = 0;
                    $section_block_id = $value_b["section_block_id"];
                    $is_default = 0;
                    $sbod = $this->Common_model->get_recode_for_select($this->_fix."section_block_order","section_block_id,ncolum,class_name,is_form",["section_block_id" => $section_block_id ,"is_default" => $is_default,"theme_section_id" => $theme_section_id]);
                    if($sbod){
                        $sbod["theme_section_id"] = $value["theme_section_id"];
                        $sbod["is_default"] = 0;
                        $sbod["sort"] = $key_b;
                        //clone part block;
                        $lparts = $this->{$this->_model}->get_parts($value_b["id"],$section_block_id,$theme_section_id);
                        $part_new = [];
                        $sort_part = 0;                        
                        foreach ($lparts as $key_p => $value_p) {
                            $value_p["actions"] = [];
                            $value_p["metas"]   = [];
                            $value_p["ramkey"]  = uniqid();
                            $value_p["html_setting"] = $html_setting_part;
                            $value_p["theme_section_id"] = $value["theme_section_id"];
                            //clone action part
                                $value_p["actions"] = $actions = $this->{$this->_model}->get_actions_part($value_p["block_part_id"],$section_block_id,$theme_section_id);
                                $value_p["actions"] = [];
                                foreach ($actions as $key_a => $value_a) {
                                    $value_a["block_part_id"]    = $value_p["block_part_id"];
                                    $value_a["section_block_id"] = $section_block_id;
                                    $value_a["theme_section_id"] = $value["theme_section_id"];
                                    $value_p["actions"][]        = $value_a;
                                }
                            //!clone action part        
                            //clone meta part
                                $value_p["metas"] = [];
                                foreach ($metas as $key_m => $value_m) {
                                    if($value_m["block_part_id"] == $value_p["block_part_id"] && $value_m['section_block_id'] == $section_block_id){
                                        $value_m["theme_section_id"] = $value["theme_section_id"];
                                        if($value_m["media_id"] != 0){
                                            $media = $this->Common_model->get_record($this->_fix."medias",["id" => $value_m["media_id"]]);
                                            if($media){
                                                $media["path"]   = base_url($media["path"]);
                                                $media["full"]   = base_url($media["full"]);
                                                $media["large"]  = base_url($media["large"]);
                                                $media["medium"] = base_url($media["medium"]);
                                                $media["small"]  = base_url($media["small"]);
                                                $media["thumb"]  = base_url($media["thumb"]);
                                                unset($media["id"]);
                                                $value_m = array_merge($media,$value_m);
                                            }
                                            if($media){
                                                unset($media["id"]);
                                                $value_m = array_merge($media,$value_m);
                                            }
                                        }
                                        $value_m["ramkey"]  = uniqid();
                                        $value_m["section_block_id"]  = $section_block_id;
                                        $value_m["theme_section_id"]  = $theme_section_id;
                                        $value_m["block_part_id"]     = $value_p["block_part_id"];
                                        $value_p["metas"][] = $value_m;
                                        unset($metas[$key_m]);
                                    }         
                                }                                                           
                            //!clone meta part
                            $value_p["html_setting"] = $html_setting_part;
                            $value_p["sort"] = $sort_part;
                            $sort_part++;
                            $part_new[] =  $value_p;
                        }
                        $value_b["parts"] = $part_new;
                        //!clone part block;
                        //clone action block;
                        $value_b["actions"] =  $this->Blocks_model->get_actions($section_block_id,$theme_section_id,null);                  
                        
                        //!clone action block;
                    }
                    $value_b["theme_section_id"] = $value["theme_section_id"];
                    $value_b["html_setting"] = $html_setting_block;
                    $value_b["sort"] = $sort_block;
                    $value_b["ramkey"]  = uniqid();
                    //!get order section block; 
                    $blocksetting = $this->Common_model->get_recode_for_select($this->_fix."section_block_order_setting",
                        "section_block_id,ncolum,class_name,is_form,allow_width",
                        [
                            "section_block_id" => $section_block_id,
                            "theme_section_id" => $theme_section_id,
                            "allow_width"      => $oldallow_width
                        ]);
                    if($blocksetting != null)
                        $value_b = array_merge($value_b,$blocksetting);
                    $block_new[] = $value_b;
                    $sort_block++;
                }
                $value["blocks"] = $block_new;   
                //!clone blocks default;
                $section_order_setting = $this->Common_model->get_record(
                    $this->_fix."section_order_setting",
                    [ 
                        "theme_section_id" => $value["theme_section_id"] , 
                        "allow_width" => $oldallow_width
                    ]
                );
                if($section_order_setting != null){
                    $value = array_merge($value,$section_order_setting);
                }
                $section[] = $value;
                //!clone section;
            }
        }
	    $theme = $this->Common_model->get_record($this->_fix."themes",["id" => $theme_id ]);
	    $theme["ramkey"] = uniqid();
	    $styles = $this->Common_model->get_result($this->_fix."style_meta",["reference_id" => $theme_id,"support_key" => "theme","allow_width" => $allow_width]);
	    $theme["style"] = null;
	    if($styles){
            foreach ($styles as $key => $value) {
                $theme["style"][$value["meta_key"]] = $value["value"];
            }
        }
        else{
            $theme["style"] = (object) array();
        }
        if(!trim($theme["effect_file"])){
            unset($theme["effect_file"]) ;
        }else{
            $theme["effect_file"] = json_decode($theme["effect_file"],true);
        }
	    if(is_numeric($theme ["font_file"])){
	    	$font = $this->Common_model->get_record("font",["id" => $theme["font_file"]]);
	    	$theme["font"] = $font;
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
        }
	    if(is_numeric($theme ["folder"]) && $theme ["folder"] > 0){
	    	$style = $this->Common_model->get_record($this->_fix."medias",["id" => $theme["folder"]]);
	    	$theme["style_url"]  = $style["path"] . 'style.css';
	    	$theme["script_url"] = $style["path"] . 'main.js';
	    }else{
	    	$theme["style_url"]  = null;
	    	$theme["script_url"] = null;
	    }
	    if(is_numeric($theme ["thumb"])){
	    	$thumb = $this->Common_model->get_record($this->_fix."medias",["id" => $theme["thumb"]]);
	    	$theme["thumb_url"] = $thumb["path"];
	    }
	    $data = ["theme" => $theme ,"sections" => $section];
	    $data["sectionsv"] = $this->Common_model->get_result($this->_fix."sections",["status" => 1]);
        $data["status"]  = "success";
        $data["oldallow_width"]  = $oldallow_width; 
        //$this->output->enable_profiler(TRUE);
	    echo (json_encode( $data ));
	}
	function gen_slug($str,$index = 0){
		$a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă",
        "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề"
        , "ế", "ệ", "ể", "ễ",
        "ì", "í", "ị", "ỉ", "ĩ",
        "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ"
        , "ờ", "ớ", "ợ", "ở", "ỡ",
        "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ",
        "ỳ", "ý", "ỵ", "ỷ", "ỹ",
        "đ",
        "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă"
        , "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ",
        "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ",
        "Ì", "Í", "Ị", "Ỉ", "Ĩ",
        "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ"
        , "Ờ", "Ớ", "Ợ", "Ở", "Ỡ",
        "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ",
        "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ",
        "Đ", " ","ö","ü");
		$b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"
        , "a", "a", "a", "a", "a", "a",
        "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e",
        "i", "i", "i", "i", "i",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o "
        , "o", "o", "o", "o", "o",
        "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u",
        "y", "y", "y", "y", "y",
        "d",
        "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A "
        , "A", "A", "A", "A", "A",
        "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E",
        "I", "I", "I", "I", "I",
        "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O "
        , "O", "O", "O", "O", "O",
        "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U",
        "Y", "Y", "Y", "Y", "Y",
        "D", "-","o","u");
		$slug =  strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    	if($index != 0) $slug .= '-'.$index;
    	$check = $this->Common_model->get_record($this->_fix . $this->_table,["slug" => $slug ]);
    	if($check){
    		$index++;
    		$this->gen_slug($str,$index);
    	}else{
    		return  ($index == 0) ? $slug : $slug . '-' .$index;
    	}
    }
  	public function create(){
        $this->check_login();
        $this->_data['slug'] = null;
  	    $this->_data["action_save"] = $this->_cname."/save_create";
	    $this->_data["containerClass"] = "full-content";
	    $this->load->view($this->_view . "/create_and_edit",$this->_data);
  	}
  	public function save_block(){
        $this->check_login();
  		$actions           = $this->input->post("actions");
		$class_name  	   = $this->input->post("class_name");
		$section_block_id  = $this->input->post("section_block_id");
		$theme_section_id  = $this->input->post("theme_section_id");
		$ncolum  		   = $this->input->post("ncolum");
        $sort              = $this->input->post("sort");
        $allow_width       = $this->input->post("allowScreen");
		$check = $this->Common_model->get_record($this->_fix."section_block_order",[
			"section_block_id" => $section_block_id,
			"theme_section_id" => $theme_section_id,
		]);
		if(!$check){
			$i = [
				"section_block_id" => $section_block_id,
				"theme_section_id" => $theme_section_id,
				"sort"             => $sort ,
				"ncolum"           => $ncolum,
				"class_name"       => $class_name,
				"is_default"       => 0,
			];
			$this->Common_model->add($this->_fix."section_block_order",$i);
		}
        $check = $this->Common_model->get_record($this->_fix."section_block_order_setting",[
            "section_block_id" => $section_block_id,
            "theme_section_id" => $theme_section_id,
            "allow_width"      => $allow_width
        ]);
        if($check){ 
            $u = [
                "ncolum"           => $ncolum,
                "class_name"       => $class_name
            ];
            $this->Common_model->update($this->_fix."section_block_order_setting",$u,[
                "section_block_id" => $section_block_id,
                "theme_section_id" => $theme_section_id,
                "allow_width"      => $allow_width
            ]); 
        }else{
            $i = [
                "section_block_id" => $section_block_id,
                "theme_section_id" => $theme_section_id,
                "sort"             => $sort,
                "ncolum"           => $ncolum,
                "class_name"       => $class_name,
                "is_default"       => 0,
                "allow_width"      => $allow_width
            ];
            $this->Common_model->add($this->_fix."section_block_order_setting",$i);
        }
		//update action;
        if($actions){
            foreach ($actions as $key => $value) {
                $value["active"] = ($value["active"] == true || $value["active"] == 1 || $value["active"] == "true") ? 1 : 0;
                $check = $this->Common_model->get_record($this->_fix."block_action",[
                    "section_block_id" => $section_block_id,
                    "theme_section_id" => $theme_section_id,
                    "action_id"        => $value["id"]
                ]);
                if($check){
                    $this->Common_model->update($this->_fix."block_action",["active" => $value["active"]],[
                        "section_block_id" => $section_block_id,
                        "theme_section_id" => $theme_section_id,
                        "action_id"        => $value["id"]
                    ]);
                }else{
                    $i = [
                        "section_block_id" => $section_block_id,
                        "theme_section_id" => $theme_section_id,
                        "action_id"        => $value["id"],
                        "active" => $value["active"]
                    ];
                    $this->Common_model->add($this->_fix."block_action",$i);

                }
            }
        }
		
		//!update action;
		$parts = $this->input->post("parts");
        foreach ($parts as $key => $value) {
            $this->save_list_part($value,$allow_width);
        }
        return true;
  	}
    private function save_list_part($part,$allow_width = 1920){
        $this->check_login();
        $actions           = $part["actions"];
        $class_name        = $part["class_name"];
        $block_part_id     = $part["block_part_id"];
        $section_block_id  = $part["section_block_id"];
        $theme_section_id  = $part["theme_section_id"];
        $metas             = $part["metas"];
        $sort              = $part["sort"];
        $ncolum            = $part["ncolum"];
        $check = $this->Common_model->get_record($this->_fix."section_block_part_order",[
            "block_part_id"    => $block_part_id,
            "section_block_id" => $section_block_id,
            "theme_section_id" => $theme_section_id
        ]);
        if($check){
            $u = [
                "class_name" => $class_name,
                "sort"       => $sort ,
                "ncolum"     => $ncolum
            ]; 
            $this->Common_model->update($this->_fix."section_block_part_order",$u,[
                "block_part_id"    => $block_part_id,
                "section_block_id" => $section_block_id,
                "theme_section_id" => $theme_section_id
            ]);
            //update action;
            if($actions):
                foreach ($actions as $key => $value) {
                    $check = $this->Common_model->get_record($this->_fix."part_action",[
                        "block_part_id"    => $block_part_id,
                        "section_block_id" => $section_block_id,
                        "theme_section_id" => $theme_section_id
                    ]);
                    $value["active"] = ($value["active"] == true || $value["active"] == 1) ? 1 : 0;
                    if($check){
                        $this->Common_model->update($this->_fix."part_action",["active" => $value["active"]],[
                            "block_part_id"    => $block_part_id,
                            "section_block_id" => $section_block_id,
                            "theme_section_id" => $theme_section_id,
                            "action_id"        => $value["id"]
                        ]);
                    }else{
                        $i = [
                            "block_part_id"    => $block_part_id,
                            "section_block_id" => $section_block_id,
                            "theme_section_id" => $theme_section_id,
                            "action_id"        => $value["id"],
                            "active"           => $value["active"]
                        ];
                        $this->Common_model->add($this->_fix."part_action",$i);
                    }
                }
            endif;
            //!update action;
            //update metas;
            $id_in = [];
            if($metas){
                foreach ($metas as $key => $value) {
                    $metaO = $this->Common_model->get_record($this->_fix."block_part_meta",["id" => $value["id"]]);
                    if($metaO){
                        $u = [
                            "value"    => @$value["value"],
                            "media_id" => @$value["media_id"],
                            "sort"     => $key
                        ];
                        $this->Common_model->update($this->_fix."block_part_meta",$u,["id" => $metaO["id"]]);
                    }else {
                        $i = [
                            "block_part_id"     => $block_part_id,
                            "section_block_id"  => $section_block_id,
                            "theme_section_id"  => $theme_section_id,
                            "meta_key"          => @$value["meta_key"],
                            "value"             => @$value["value"],
                            "media_id"          => @$value["media_id"],
                            "sort"              => $key
                        ];
                        $value["id"] = $this->Common_model->add($this->_fix."block_part_meta",$i);
                        $metas [] = $value;
                    }
                    $id_in[] = $value["id"];
                }
                $this->db->where_not_in('id', $id_in);
                $this->db->where([
                    "block_part_id"     => $block_part_id,
                    "section_block_id"  => $section_block_id,
                    "theme_section_id"  => $theme_section_id,
                ]);
                $this->db->delete($this->_fix."block_part_meta"); 
            }
            //!update metas;
        }
    }
  	public function save_part(){
        $this->check_login();
		$actions           = $this->input->post("actions");
		$class_name  	   = $this->input->post("class_name");
		$block_part_id     = $this->input->post("block_part_id");
		$section_block_id  = $this->input->post("section_block_id");
		$theme_section_id  = $this->input->post("theme_section_id");
		$metas  		   = $this->input->post("metas");
		$sort  			   = $this->input->post("sort");
		$ncolum  		   = $this->input->post("ncolum");
        $allow_width       = $this->input->post("allowScreen");
		$check = $this->Common_model->get_record($this->_fix."section_block_part_order",[
			"block_part_id"    => $block_part_id,
			"section_block_id" => $section_block_id,
			"theme_section_id" =>$theme_section_id
		]);
		if($check){
			$u = [
				"class_name" => $class_name,
				"sort"       => $sort ,
				"ncolum"     => $ncolum
			]; 
			$this->Common_model->update($this->_fix."section_block_part_order",$u,[
				"block_part_id"    => $block_part_id,
				"section_block_id" => $section_block_id,
				"theme_section_id" => $theme_section_id
			]);
			//update action;
			foreach ($actions as $key => $value) {
				$check = $this->Common_model->get_record($this->_fix."part_action",[
					"block_part_id"    => $block_part_id,
					"section_block_id" => $section_block_id,
					"theme_section_id" => $theme_section_id
				]);
				$value["active"] = ($value["active"] == true || $value["active"] == 1) ? 1 : 0;
				if($check){
					$this->Common_model->update($this->_fix."part_action",["active" => $value["active"]],[
						"block_part_id"    => $block_part_id,
						"section_block_id" => $section_block_id,
						"theme_section_id" => $theme_section_id,
						"action_id"        => $value["id"]
					]);
				}else{
					$i = [
						"block_part_id"    => $block_part_id,
						"section_block_id" => $section_block_id,
						"theme_section_id" => $theme_section_id,
						"action_id"        => $value["id"],
						"active"           => $value["active"]
					];
					$this->Common_model->add($this->_fix."part_action",$i);

				}
			}
			//!update action;
			//update metas;
			$metasChange = [];
			$id_in = [];
			if($metas){
				foreach ($metas as $key => $value) {
                    $metaO = $this->Common_model->get_record($this->_fix."block_part_meta",["id" => $value["id"]]);
					if($metaO){
						$u = [
							"value"    => @$value["value"],
							"media_id" => @$value["media_id"]
						];
						$this->Common_model->update($this->_fix."block_part_meta",$u,["id" => $metaO["id"]]);
					}else {
						$i = [
							"block_part_id"    	=> $block_part_id,
							"section_block_id" 	=> $section_block_id,
							"theme_section_id" 	=> $theme_section_id,
							"meta_key"			=> @$value["meta_key"],
							"value" 			=> @$value["value"],
							"media_id" 			=> @$value["media_id"],
						];
						$value["id"] = $this->Common_model->add($this->_fix."block_part_meta",$i);
					}
					$metasChange[] = $value;
					$id_in[] = $value["id"];
				}
				$this->db->where_not_in('id', $id_in);
				$this->db->where([
					"block_part_id"    	=> $block_part_id,
					"section_block_id" 	=> $section_block_id,
					"theme_section_id" 	=> $theme_section_id,
				]);
				$this->db->delete($this->_fix."block_part_meta"); 
				$metas = $metasChange;
				$metasChange["sql"] = $this->db->last_query();
			}
			
			//!update metas;
		}
		
  		die(json_encode($metasChange));
  	}
  	public function save_section(){
        $this->check_login();
  		$section     = $this->input->post();
  		$actions     = $this->input->post("actions"); 
  		$style       = $this->input->post("style");
        $allow_width = $this->input->post("allowScreen");
  		$fields  = $this->db->list_fields($this->_fix.'section_order');
  		$iu = [];
		foreach ($section as $key => $value)
		{
			if(in_array($key, $fields)){
				$iu[$key] = $value;
			}
		}
		if($iu){
			$check = $this->Common_model->get_record($this->_fix.'section_order',["theme_section_id" => $section["theme_section_id"]]);
			if(!$check){
				$this->Common_model->add($this->_fix.'section_order',$iu);
			} 
            $fields  = $this->db->list_fields($this->_fix.'section_order_setting');
            $iu = [];
            foreach ($section as $key => $value)
            {
                if(in_array($key, $fields)){
                    $iu[$key] = $value;
                }
            }
            $check = $this->Common_model->get_record($this->_fix.'section_order_setting',["theme_section_id" => $section["theme_section_id"],"allow_width" => $allow_width]);
            if($check){              
                $this->Common_model->update($this->_fix.'section_order_setting',$iu,
                    [
                        "theme_section_id"  => $section["theme_section_id"],
                        "allow_width"       => $allow_width
                    ]
                );
            }else{
                $iu["allow_width"] = $allow_width;
                $iu["theme_section_id"] = $section["theme_section_id"];
                $this->Common_model->add($this->_fix.'section_order_setting',$iu);
            }
        }
		//update action;
        if($actions):
    		foreach ($actions as $key => $value) {
    			$check = $this->Common_model->get_record($this->_fix."section_action",[
    				"theme_section_id" => $section["theme_section_id"]
    			]);
    			$value["active"] = ($value["active"] == true || $value["active"] == 1) ? 1 : 0;
    			if($check){
    				$this->Common_model->update($this->_fix."section_action",["active" => $value["active"]],[
    					"theme_section_id" => $section["theme_section_id"],
    					"action_id"        => $value["id"]
    				]);
    			}else{
    				$i = [
    					"theme_section_id" 	=> $section["theme_section_id"],
    					"action_id"        	=> $value["id"],
    					"active" 			=> $value["active"]
    				];
    				$this->Common_model->add($this->_fix."section_action",$i);
    			}
    		}
        endif;
		//!update action;
		//update style;
        if($style):
    		foreach ($style as $key => $value) {
    			$check = $this->Common_model->get_record($this->_fix."style_meta",[
    				"reference_id" => $section["theme_section_id"],
    				"support_key"  => "section",
    				"meta_key"     => $key,
                    "allow_width"  => $allow_width
    			]);
    			if($check){
    				$this->Common_model->update($this->_fix."style_meta",["value" => $value],[
    					"reference_id" => $section["theme_section_id"],
    					"support_key"  => "section",
    					"meta_key"     => $key,
                        "allow_width"  => $allow_width
    				]);
    			}else{
    				$i = [
    					"reference_id" => $section["theme_section_id"],
    					"support_key"  => "section",
    					"meta_key"     => $key,
    					"value"        => $value,
                        "allow_width"  => $allow_width
    				];
    				$this->Common_model->add($this->_fix."style_meta",$i);
    			}
    		}
        endif;
		//!update style;
		die(json_encode($this->input->post()));
  	}
  	public function save_theme (){
        $this->check_login();
  		$theme = $this->input->post();
  		$u = [
  			"name" 			  => $theme["name"],
  			"description" 	  => $theme["description"],
  			"thumb" 		  => $theme["thumb"],
  			"font_file" 	  => $theme["font_file"],
  			"folder" 	      => $theme["folder"],
  			"sound_file" 	  => $theme["sound_file"],
  			"size_title"      => $theme["size_title"],
  			"color_title"     => $theme["color_title"],
            "effect"          => $theme["effect"],
            "effect_file"     => json_encode($theme["effect_file"]),
            "effect_media_id" => $theme["effect_media_id"],
  			"public"          => $theme["public"],
            "status"          => $theme["status"],
            "sound_example"   => $theme["sound_example"],
            "sound_play"      => $theme["sound_play"]
  		];
  		$this->Common_model->update($this->_fix.$this->_table,$u,["id" => $theme["id"]]);
  		if(@$theme["style"]){
  			foreach ($theme["style"] as $key => $value) {
  				$check = $this->Common_model->get_record($this->_fix."style_meta",[
  					"reference_id" => $theme["id"],
  					"support_key"  => "theme",
  					"meta_key"     => $key
  				]);
  				if($check){
  					$this->Common_model->update($this->_fix."style_meta",["value" => $value],[
  						"reference_id" => $theme["id"],
	  					"support_key"  => "theme",
	  					"meta_key"     => $key
  					]);
  				}else{
  					$this->Common_model->add($this->_fix."style_meta",[
  						"reference_id" => $theme["id"],
	  					"support_key"  => "theme",
	  					"meta_key"     => $key,
	  					"value" 	   => $value
  					]);
  				}
  			}
  		}
  		die(json_encode($theme));
  	}
  	public function addsection(){
        $this->check_login();
  		$svsection    = $this->input->post("svsection");
  		$theme_id     = $this->input->post("theme_id");
  		$sort         = $this->input->post("sort");
        $allow_width  = $this->input->post("allowScreen");
        $oldallow_width = 1920;
  		$html_setting = $this->load->view("backend/themes/templates/html_section/get_info",null,true);
	    $html_setting_block = $this->load->view("backend/themes/templates/html_block/get_info",null,true);
	    $html_setting_part = $this->load->view("backend/themes/templates/html_part/edit",null,true);
	    $html_style   = $this->load->view("backend/themes/templates/html_section/style",null,true);
		$this->load->model($this->_model);
	    $this->load->model("Sections_model");
	    $this->load->model("Blocks_model");
    	//clone section;   
    	$svsection["html_setting"] = $html_setting; 
    	$svsection["html_style"]   = $html_style; 		
    	$svsection["theme_id"] = $theme_id;
		$theme_section_id  = $this->Common_model->add($this->_fix."section",[
			"theme_id"    => $svsection["theme_id"],
			"section_id"  => $svsection["id"],
		]);
		//clone order theme section;
		$sd = $this->Common_model->get_record($this->_fix."section",["section_id" => $svsection["id"],"theme_id" => 0]);
		if($sd != null) {
			$sdo = $this->Common_model->get_record($this->_fix."section_order",
                [
                    "theme_section_id" => $sd["id"]
                ]
            );
		}
		$old_ord = [
			"name"            	=> $svsection["name"],
			"theme_section_id" 	=> $theme_section_id,
			"class_name"       	=> @$sdo["class_name"],
			"is_full"			=> @$sdo["is_full"],
			"show_title"		=> @$sdo["show_title"],
			"default_block"		=> @$sdo["default_block"],
			"ncolum_block"		=> @$sdo["ncolum_block"],
			"ncolum_show_block" => @$sdo["ncolum_show_block"],
			"sort"             	=> $sort,
			"is_default"      	=> 0
		];
        $this->Common_model->add($this->_fix."section_order_setting",
            [
                "theme_section_id"  => $theme_section_id,
                "allow_width"       => $allow_width,
                "is_full"           => @$old_ord["is_full"],
                "show_title"        => @$old_ord["show_title"],
                "is_default"        => @$old_ord["is_default"],
                "default_block"     => @$old_ord["default_block"],
                "ncolum_block"      => @$old_ord["ncolum_block"],
                "ncolum_show_block" => @$old_ord["ncolum_show_block"],
                "layout_show_block" => @$old_ord["layout_show_block"],
                "title_size"        => @$old_ord["title_size"],
                "title_family"      => @$old_ord["title_family"],
                "name"              => @$svsection["name"],
            ]
        );
		$svsection = array_merge($svsection,$old_ord);
        $svsection["ramkey"] = uniqid();
    	$this->Common_model->add($this->_fix."section_order",$old_ord);
		//!clone order theme section;
    		//clone actions;
    			//get all action default;
                    $old_section = $this->Common_model->get_record($this->_fix."section",["section_id" => $svsection["id"],"theme_id" => 0]);
	    			$actions = $this->Sections_model->get_action_like("/section/",@$old_section["id"]);
                    $actions_new = [];
	    			$batch = [];
		    		foreach ($actions as $key => $value_a) {
		    			$value_a["theme_section_id"] = $theme_section_id;
		    			$value_a["is_default"] = 0;
		    			$batch[] = [
		    				"theme_section_id" => $value_a["theme_section_id"],
		    				"action_id"        => $value_a["id"],
		    				"active"           => $value_a["active"],
		    				"is_default"       => 0,
		    			];
		    			$actions_new[] = $value_a;
		    		}
		    		$this->Common_model->insert_batch_data($this->_fix."section_action",$batch);
    				$svsection["actions"] = $actions_new;
    			//!get all action default;
    		//!clone actions ;
		//clone blocks default;
    	    $section_theme_default = $this->Common_model->get_record($this->_fix."section",["section_id" => $svsection["id"],"theme_id" => 0, "is_default" => 1]);
          	$section_theme_default_order = $this->Common_model->get_record($this->_fix."section_order",["theme_section_id" => $section_theme_default["id"], "is_default" => 1 ]);
          	$lblocks = $this->{$this->_model}->get_blocks($svsection["id"],0,$section_theme_default_order["default_block"],$section_theme_default_order["ncolum_show_block"]);
			$block_new = [];
			foreach ($lblocks as $key => $value_b) {
				//get order section block;
				$section_block_id = $value_b["section_block_id"];
				$sbod = $this->Common_model->get_record($this->_fix."section_block_order",["section_block_id" => $section_block_id ,"is_default" => 1,"theme_section_id" => 0 ]);
				if($sbod){
					$sbod["theme_section_id"] = $theme_section_id;
					$sbod["is_default"] = 0;
					unset($sbod["id"]);
					$this->Common_model->add($this->_fix."section_block_order",$sbod);
					//clone part block;
					$lparts = $this->{$this->_model}->get_parts($value_b["id"],$section_block_id,0);
					$part_new = [];
					foreach ($lparts as $key => $value_p) {
						$value_p["actions"] = [];
						$value_p["metas"]   = [];
						$ramkey             = uniqid();
						$insert = [
							'block_part_id'    => $value_p['block_part_id'],
							'section_block_id' => $section_block_id,
							'theme_section_id' => $theme_section_id,
							'sort'             => $value_p["sort"],
							'ncolum'           => $value_p["ncolum"],
							'id_name'          => $value_p["id_name"],
							'class_name'       => $value_p["class_name"],
						];
						$this->Common_model->add($this->_fix."section_block_part_order",$insert);
						$value_p["html_setting"] = $html_setting_part;
						$value_p["ramkey"] = $ramkey;
						$value_p["theme_section_id"] = $theme_section_id;
						//clone action part
							$actions = $this->{$this->_model}->get_actions_part($value_p["block_part_id"],$section_block_id,0);
							foreach ($actions as $key => $value_a) {
								$this->Common_model->add($this->_fix."part_action",[
									"block_part_id"    => $value_p["block_part_id"],
									"section_block_id" => $section_block_id,
									"theme_section_id" => $theme_section_id,
									"action_id"        => $value_a["id"],
									"active"           => $value_a["active"]
								]);
								$value_a["block_part_id"]    = $value_p["block_part_id"];
								$value_a["section_block_id"] = $section_block_id;
								$value_a["theme_section_id"] = $theme_section_id;
								$value_p["actions"][] = $value_a;
							}

						//!clone action part		
						//clone meta part
							$metas  = $this->{$this->_model}->get_metas($value_p["block_part_id"],$section_block_id,0,$oldallow_width);
							foreach ($metas as $key => $value_m) {
								$insert = [
									"block_part_id"    => $value_m["block_part_id"],
									"section_block_id" => $section_block_id,
									"theme_section_id" => $theme_section_id,
									"meta_key"         => $value_m["meta_key"],
									"value"            => $value_m["value"],
									"media_id"         => $value_m["media_id"],
                                    "allow_width"      => $allow_width
								];
								$value_m["id"] = $this->Common_model->add($this->_fix."block_part_meta",$insert);
								$value_m["theme_section_id"] = $theme_section_id;
								$value_m["section_block_id"] = $section_block_id;
								$value_m["ramkey"]  = uniqid();
								$value_p["metas"][] = $value_m;
							}
						//!clone meta part
						$part_new[] =  $value_p;
					}
					$value_b["parts"] = $part_new;
					//!clone part block;
					//clone action block;
					$actions = $this->Blocks_model->get_actions($section_block_id,0);
					$actions_new = [];
					foreach ($actions as $key => $value_a) {
						$i = [
							"section_block_id" => $section_block_id,
							"theme_section_id" => $theme_section_id,
							"action_id"        => $value_a["id"],
							"active"           => $value_a["active"],
						];
						$this->Common_model->add($this->_fix."block_action",$i);
						$value_a["theme_section_id"] = $theme_section_id;
						$value_a["section_block_id"] = $section_block_id;
						$actions_new[] = $value_a;
					}
					$value_b["actions"] = $actions_new;
					//!clone action block;
				}
				$value_b["ramkey"] = uniqid();
				$value_b["html_setting"] = $html_setting_block;
				$value_b["theme_section_id"] = $theme_section_id;

				//!get order section block; 
				$block_new[] = $value_b;
                $this->Common_model->add($this->_fix."section_block_order_setting",
                    [
                        "section_block_id" => $value_b["section_block_id"],
                        "theme_section_id" => $value_b["theme_section_id"],
                        "allow_width"      => $allow_width,
                        "sort"             => $value_b["sort"],
                        "ncolum"           => $value_b["ncolum"],
                        "class_name"       => $value_b["class_name"],
                        "id_name"          => $value_b["id_name"],
                        "is_form"          => $value_b["is_form"],
                        "is_default"       => $value_b["is_default"],
                    ]
                );
			}
			$svsection["blocks"] = $block_new;

		//!clone blocks default;
    	//!clone section;
       
  		die (json_encode($svsection));
  	}
  	public function addblock(){
        $this->check_login();
  		$svblock            = $this->input->post("svblock");
  		$section_id         = $this->input->post("section_id");
  		$theme_section_id   = $this->input->post("theme_section_id");
        $allow_width        = $this->input->post("allowScreen");
  		$sort               = $this->input->post("sort");
		$html_setting_part  = $this->load->view("backend/themes/templates/html_part/edit",null,true);
		$html_setting_block = $this->load->view("backend/themes/templates/html_block/get_info",null,true);
		$this->load->model($this->_model);
	    $this->load->model("Sections_model");
	    $this->load->model("Blocks_model");
	    $order_block = $this->Common_model->get_record($this->_fix."section_block_order",["section_block_id" => 0,'theme_section_id' => $theme_section_id]);
	    
        if($order_block == null){
	    	$order_block["class_name"] = $svblock["class_name"];
	    	$order_block["ncolum"]     = 12;
	    	$order_block["is_form"]    = 0;
	    	$order_block["is_default"] = 0;
	    }
	    $ramkey = uniqid();
		//add block tp section
			$b = [
				"block_id"    => $svblock["id"],
				"section_id"  => $section_id
			];
			$section_block_id = $this->Common_model->add($this->_fix."section_block",$b);
	    //!add block tp section
		//get block order default;
			$in = [
  				"section_block_id" => $section_block_id,
  				"theme_section_id" => $theme_section_id,
  				"class_name"       => $order_block["class_name"],
  				"is_default"       => $order_block["is_default"],
  				"is_form"          => $order_block["is_form"],
  				"ncolum"           => $order_block["ncolum"],
  				"sort"             => $sort			
  			];
  			$this->Common_model->add($this->_fix."section_block_order",$in);
            $this->Common_model->add($this->_fix."section_block_order_setting",
                [
                    "section_block_id" => $in["section_block_id"],
                    "theme_section_id" => $in["theme_section_id"],
                    "sort"             => $in["sort"],
                    "ncolum"           => $in["ncolum"],
                    "class_name"       => $in["class_name"],
                    "is_form"          => $in["is_form"],
                    "is_default"       => $in["is_default"],
                ]
            );
  			$svblock = array_merge($svblock,$in);
			$svblock["actions"]      = $this->Blocks_model->get_actions(0,0);
			$svblock["ramkey"]       = $ramkey;
			$svblock["style"]        = null;
			$svblock["html_setting"] = $html_setting_block;
			//clone part block;
			$lparts = $this->{$this->_model}->get_parts($svblock["id"],0,0);
			$part_new = [];
			foreach ($lparts as $key => $value_p) {
				$value_p["actions"] = [];
				$value_p["metas"]   = [];
				$insert = [
					'block_part_id'    => $value_p['block_part_id'],
					'section_block_id' => $section_block_id,
					'theme_section_id' => $theme_section_id,
					'sort'             => $value_p["sort"],
					'ncolum'           => $value_p["ncolum"],
					'id_name'          => $value_p["id_name"],
					'class_name'       => $value_p["class_name"]
				];
				$this->Common_model->add($this->_fix."section_block_part_order",$insert);
				$value_p["html_setting"] = $html_setting_part;
				$value_p["theme_section_id"] = $theme_section_id;
				//clone action part
					$actions = $this->{$this->_model}->get_actions_part($value_p["block_part_id"],0,0);
					foreach ($actions as $key => $value_a) {
						$this->Common_model->add($this->_fix."part_action",[
							"block_part_id"    => $value_p["block_part_id"],
							"section_block_id" => $section_block_id,
							"theme_section_id" => $theme_section_id,
							"action_id"        => $value_a["id"],
							"active"           => $value_a["active"]
						]);
						$value_a["block_part_id"]    = $value_p["block_part_id"];
						$value_a["section_block_id"] = $section_block_id;
						$value_a["theme_section_id"] = $theme_section_id;
						$value_p["actions"][] = $value_a;
					}

				//!clone action part		
				//clone meta part
					$metas  = $this->{$this->_model}->get_metas($value_p["block_part_id"],0,0);
					foreach ($metas as $key => $value_m) {
						$insert = [
							"block_part_id"    => $value_m["block_part_id"],
							"section_block_id" => $section_block_id,
							"theme_section_id" => $theme_section_id,
							"meta_key"         => $value_m["meta_key"],
							"value"            => $value_m["value"],
							"media_id"         => $value_m["media_id"]
						];
						$value_m["id"] = $this->Common_model->add($this->_fix."block_part_meta",$insert);
						$value_m["theme_section_id"] = $theme_section_id;
						$value_m["section_block_id"] = $section_block_id;
                        $value_m["ramkey"]  = uniqid();
						$value_p["metas"][] = $value_m;
					}
				//!clone meta part
				$part_new[] =  $value_p;
			}
			$svblock["parts"] = $part_new;
			//!clone part block;
            //!get parts by block id;
		//!get block order default;
  		die ( json_encode($svblock)) ;
  	}
  	public function addpart(){
        $this->check_login();
  		$svpart             = $this->input->post("part");
  		$block_id           = $this->input->post("block_id");
  		$sort               = $this->input->post("sort");
  		$section_block_id   = $this->input->post("section_block_id");
  		$theme_section_id   = $this->input->post("theme_section_id");
  		$block      = null;
  		$this->load->model($this->_model);
  		if($svpart){
  			$html_setting_part = $this->load->view("backend/themes/templates/html_part/edit",null,true);
  			$svpart["html_setting"] = $html_setting_part;
  			$ramkey = uniqid();
            //insert part block
            $insert = [
            	"part_id"    => $svpart["id"],
            	"block_id"   => $block_id,
            	"is_default" => 0,
            	"name"       => "",
            ];
            $block_part_id = $this->Common_model->add($this->_fix."section_block_part",$insert);
            //inser part block order;
            $insert = [
            	"block_part_id"    => $block_part_id,
            	"section_block_id" => $section_block_id,
            	"theme_section_id" => $theme_section_id,
            	"sort"             => $sort,
            	"ncolum"           => 12,
            	"id_name"          => "",
            	"class_name"       => "",

            ];
            $this->Common_model->add($this->_fix."section_block_part_order",$insert);
            $svpart = array_merge ($svpart,$insert);
            $svpart["ramkey"] = $ramkey;
            //clone action part
			$actions = $this->{$this->_model}->get_actions_part(0,0,0);
			foreach ($actions as $key => $value_a) {
				$this->Common_model->add($this->_fix."part_action",[
					"block_part_id"    => $block_part_id,
					"section_block_id" => $section_block_id,
					"theme_section_id" => $theme_section_id,
					"action_id"        => $value_a["id"],
					"active"           => $value_a["active"]
				]);
				$value_a["block_part_id"]    = $block_part_id;
				$value_a["section_block_id"] = $section_block_id;
				$value_a["theme_section_id"] = $theme_section_id;
				$value_a["ramkey"]  = uniqid();
				$svpart["actions"][] = $value_a;
			}
			//add default meta;
			$i = [
				"block_part_id"    => $block_part_id,
				"section_block_id" => $section_block_id,
				"theme_section_id" => $theme_section_id,
				"meta_key"         => $svpart["meta_key"],
				"value"            => $svpart["default_value"],
				"media_id"         => $svpart["default_value"]
			];
			$i["id"] = $this->Common_model->add($this->_fix."block_part_meta",$i);
			$i["ramkey"]  = uniqid();
			$svpart["metas"][] = $i;	
			//!add default meta;
  		}
  		die (json_encode($svpart));
  	}
  	public function get_pramater_server(){
        $this->check_login();
  		//get sections .
  		$data["sections"] = $this->Common_model->get_result($this->_fix."sections",["status" => 1]);
  		//get blocks .
  		$data["blocks"] = $this->Common_model->get_result($this->_fix."blocks",["status" => 1]);
  		//get parts .
  		$data["parts"] = $this->Common_model->get_result($this->_fix."parts",["status" => 1]);
  		die(json_encode($data));
  	}
  	public function get_template_by_sidebar(){
        $this->check_login();
	    $folder   = "templates/html_sidebars";
	    $template = $this->input->post("template");
	    $args  = [
	      "page-change",
	      "page-background",
	      "page-font",
	      "page-sound",
	      "page-effect",
	      "page-section",
	      "page-style",
	      "page-info",
          "page-screen"
	    ];
	    if(in_array($template, $args)){
	      $this->load->view($this->_view."/".$folder."/".$template);
	    }
  	}
  	public function get_template_section(){
        $this->check_login();
  		$folder   = "templates/html_section";
	    $template = $this->input->post("template");
	    $this->load->view($this->_view."/".$folder."/".$template);
	    return false;
  	}
	public function edit($id){
        $this->check_login();
		$this->_data["action_save"] = $this->_cname."/save_edit/".$id;
		$this->_data["post"] = $this->Common_model->get_record($this->_fix.$this->_table,["id" => $id]);
		$this->load->view($this->_view . "/create_and_edit",$this->_data);
	}
    public function delete($id){
        $this->check_login();
	    $data = ["status" => "error","message" => null,"response" => null ,"record" => null,"post" => $this->input->post() ];
	    if($this->input->is_ajax_request()){
	      $this->Common_model->delete($this->_fix.$this->_table,["id" => $id]);
	      $data ["status"] = "success";
	    }  
	    die(json_encode($data) );
    }
	public function updatesort ($type = "section"){
        $this->check_login();
		$l = $this->input->post("list");
		if($l){
			if($type == "block"){
				foreach ($l as $key => $value) {
					$this->Common_model->update($this->_fix."section_block_order",["sort" => $key],[
						"section_block_id" => $value["section_block_id"],
						"theme_section_id" => $value["theme_section_id"]
					]);
				}
			}elseif ($type == "part") {
				foreach ($l as $key => $value) {
					$this->Common_model->update($this->_fix."section_block_part_order",["sort" => $key],[
						"block_part_id"    => $value["block_part_id"],
						"theme_section_id" => $value["theme_section_id"],
						"section_block_id" => $value["section_block_id"]
					]);
				}
			}elseif($type == "section"){
				foreach ($l as $key => $value) {
					$this->Common_model->update($this->_fix."section_order",["sort" => $key],[
						"theme_section_id" => $value["theme_section_id"],
					]);
				}
			}
		}
		die(json_encode($l));
	}
    public function uploadziptheme (){
        $this->check_login();
        $config['upload_path']          = '/uploads/Themes/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('userfile'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_form', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('upload_success', $data);
        }
    }
    public function iframe (){
        $this->load->view($this->_view . '/iframe',$this->_data);
    }
    public function deleteitem($type){
        $this->check_login();
        $l = $this->input->post("item");
        if($l){
            if($type == "block"){
                $this->Common_model->delete($this->_fix."section_block_order",[
                    "section_block_id" => @$l["section_block_id"],
                    "theme_section_id" => @$l["theme_section_id"]
                ]);
            }elseif ($type == "part") {
                $this->Common_model->delete($this->_fix."section_block_part_order",[
                    "block_part_id"    => @$l["block_part_id"],
                    "theme_section_id" => @$l["theme_section_id"],
                    "section_block_id" => @$l["section_block_id"]
                ]);
            }elseif($type == "section"){
                $this->Common_model->delete($this->_fix."section_order",["theme_section_id" => &$l["theme_section_id"]]);
            }
        }
        die(json_encode($l));
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
