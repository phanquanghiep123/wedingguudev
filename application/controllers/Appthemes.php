<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Appthemes extends CI_Controller {
    public $_fix    = 'theme_';
    public $_table  = 'themes';
    public $_view   = 'frontend/appthemes';
    public $_cname  = 'themes/appthemes';
    public $_model  = 'Themes_model';
    public $_data   = [];
    public $_user_id = 0;
    public function __construct(){
        parent::__construct();
        ini_set('max_execution_time', 0);
        $this->_data['containerClass'] = 'full-content';
        $this->session->set_flashdata('post',$this->input->post());
        $this->session->set_flashdata('get',$this->input->get());
        if ($this->session->userdata('user_info')) {
            $this->_data['is_login'] = true;
            $this->_data['user'] = $this->session->userdata('user_info');
            $this->_user_id = @$this->_data['user']['id'] ? @$this->_data['user']['id'] : 0;
            $this->_data['user_id'] = $this->_user_id;
        }
        
    }
    public function check_login(){
        if (!$this->session->userdata('user_info')) {
            $link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]';
            redirect(base_url('/account/login/?redirect='.urlencode($link)));
        }
    }
    public function get_groups_backgrounds_sounds(){
        //get groups
        $this->load->model($this->_model);
        $gb = $this->Common_model->get_result($this->_fix.'groups_background_music',['type' => 0,'status' => 1]);
        $gm = $this->Common_model->get_result($this->_fix.'groups_background_music',['type' => 1,'status' => 1]);
        $f  = $this->{$this->_model}->effects();
        $data = ['backgrounds' => null ,'sounds' => null,'effects' => null];
        $data['effects'] = $f;
        
        if($gb){
          foreach ($gb as $key => $value) {
            $bs = $this->{$this->_model}->get_backgrounds_by_group($value['id']);
            $value['backgrounds'] = $bs;
            $data['backgrounds'][]= $value;
          }
        }
        if($gm){
          foreach ($gm as $key => $value) {
            $ms = $this->{$this->_model}->get_backgrounds_by_group($value['id']);
            $value['sounds'] = $ms;
            $data['sounds'][]= $value;
          } 
        }
        echo (json_encode($data));
    }
    public function get_fonts(){
        $f = $this->Common_model->get_result('font');
        die(json_encode($f));
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
        $section_setting_insert = $block_setting_inserts = $sbods = $style_meta_inserts = $old_ord_inserts =  $inserts = [];
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
                'id,theme_section_id,section_block_id,block_part_id,meta_key,value,media_id,sort',
                [
                    'theme_section_id' => $theme_section_id
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
                } 
            }else{
                $value['style'] = (object) array();
            }
            $old_id = $value['theme_section_id'];
            //clone order theme section;

            //!clone order theme section;
            $value['actions'] = null;
            if(@$is_create != 2){
                $value['actions'] = $actions = $this->Sections_model->get_action_like('/section/',$value["clone_id"],1);
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
                        $value_p['html_setting'] = $html_setting_part;
                        $value_p['theme_section_id'] = $value['theme_section_id'];
                        $value_p['actions'] = null;
                        $value_p['metas'] = [];
                        foreach ($metas as $key_m => $value_m) {
                            if($value_m['block_part_id'] == $value_p['block_part_id'] && $value_m['section_block_id'] == $section_block_id){
                                $value_m['theme_section_id'] = $value['theme_section_id'];
                                if($value_m['media_id'] != 0){
                                    $media = $this->Common_model->get_record($this->_fix.'medias',['id' => $value_m['media_id']]);
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
                    $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
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
                        $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                        [
                            "section_block_id" => $section_block_id,
                            "theme_section_id" => $theme_section_id,
                            "allow_width"      => $oldallow_width
                        ]
                    ); 
                    if($blocksetting != null){
                        $value_b = array_merge($value_b,$blocksetting);
                        if($oldallow_width != $allow_width){
                            $cloneSettting = [
                                "section_block_id" => @$blocksetting["section_block_id"],
                                "theme_section_id" => $value['theme_section_id'],
                                "allow_width"      => @$allow_width,
                                "sort"             => @$blocksetting['sort'],
                                "ncolum"           => @$blocksetting['ncolum'],
                                "class_name"       => @$blocksetting['class_name'],
                                "id_name"          => @$blocksetting['id_name'],
                                "is_form"          => @$blocksetting['is_form'],
                                "is_default"       => @$blocksetting['is_default']
                            ];
                            $this->Common_model->add($this->_fix."section_block_order_setting",$cloneSettting);
                        }  
                    }
                    else{
                        $cloneSettting = [
                            "section_block_id" => @$value_b["section_block_id"],
                            "theme_section_id" => $value['theme_section_id'],
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
                $value_b["actions"] = $this->Blocks_model->get_actions($value_b["section_block_id"],$value["clone_id"],1);  
                $value['blocks'][]  = $value_b;
                $sort_block++;
            } 
            //!clone blocks default;
            $value['ramkey']  = uniqid();
            $section_order_setting = $this->Common_model->get_record(
                $this->_fix."section_order_setting",
                [
                    "theme_section_id" => $theme_section_id , 
                    "allow_width"      => $allow_width
                ]
            );
            if($section_order_setting != null){
                $value = array_merge($value,$section_order_setting);
            }else{
                $section_order_setting = $this->Common_model->get_record(
                    $this->_fix."section_order_setting",
                    [
                        "theme_section_id" => $theme_section_id , 
                        "allow_width"     => $oldallow_width
                    ]
                );
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
                    if($oldallow_width != $allow_width){
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
                                "title_size"        => $value["title_size"],
                            ]
                        );
                    }
                }                 
            }
            $section[] = $value;
            //!clone section;
        }
        //unset($value);            
        $data['sections'] = $section;
        $data['status'] = 'success';
        echo (json_encode( $data ));  
        return true; 
    }
    public function get_allow_screen($id = 0){
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
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
            foreach ($lsections as $key_s => $value) {
                //clone section;   
                $value["sort"] = $key_s;
                $value["theme_id"] = $theme_id;
                $value["ramkey"] = uniqid();
                $value["style"] = null; 
                $theme_section_id = $value["theme_section_id"];
                $styles = $this->Common_model->get_result($this->_fix."style_meta",[
                    "reference_id" => $theme_section_id,
                    "support_key" => "section",
                ]);
                if($styles){
                    foreach ($styles as $key_st => $value_st) {
                        if (strpos($value_st["value"],'/uploads/') !== false && strpos($value_st["value"],'com/uploads/') === false)  {
                            $value_st["value"] = str_replace("/uploads/",base_url("/uploads"). "/",$value_st["value"]);
                        }
                        $value["style"][$value_st["meta_key"]] = $value_st["value"];
                    }
                }else{
                    $value["style"] = (object) array();
                }
                $old_id = $value["theme_section_id"];
                //get all action default;
                $value["actions"] = $this->Sections_model->get_action_like("/section/",$value["clone_id"]);
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
                            $value_p["theme_section_id"] = $value["theme_section_id"];     
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
                            $value_p["sort"] = $sort_part;
                            $sort_part++;
                            $part_new[] =  $value_p;
                        }
                        $value_b["parts"] = $part_new;
                        //!clone part block;
                        //clone action block;
                        $value_b["actions"] = $this->Blocks_model->get_actions($value_b["section_block_id"],$value["clone_id"],1);                        //!clone action block;
                    }
                    $value_b["theme_section_id"] = $value["theme_section_id"];
                    $value_b["sort"] = $sort_block;
                    $value_b["ramkey"]  = uniqid();
                    //!get order section block; 
                    $blocksetting = $this->Common_model->get_recode_for_select(
                        $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
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
                            $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                            [
                                "section_block_id" => $section_block_id,
                                "theme_section_id" => $theme_section_id,
                                "allow_width"      => $oldallow_width
                            ]
                        ); 
                        if($blocksetting != null){
                            $value_b = array_merge($value_b,$blocksetting);
                            if($oldallow_width != $allow_width){
                                $cloneSettting = [
                                    "section_block_id" => @$blocksetting["section_block_id"],
                                    "theme_section_id" => $value['theme_section_id'],
                                    "allow_width"      => @$allow_width,
                                    "sort"             => @$blocksetting['sort'],
                                    "ncolum"           => @$blocksetting['ncolum'],
                                    "class_name"       => @$blocksetting['class_name'],
                                    "id_name"          => @$blocksetting['id_name'],
                                    "is_form"          => @$blocksetting['is_form'],
                                    "is_default"       => @$blocksetting['is_default']
                                ];
                                $this->Common_model->add($this->_fix."section_block_order_setting",$cloneSettting);
                            }  
                        }
                        else{
                            $cloneSettting = [
                                "section_block_id" => @$value_b["section_block_id"],
                                "theme_section_id" => $value['theme_section_id'],
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
                    $block_new[] = $value_b;
                    $sort_block++;
                }
                $value["blocks"] = $block_new;   
                //!clone blocks default;
                $section_order_setting = $this->Common_model->get_record(
                    $this->_fix."section_order_setting",
                    [
                        "theme_section_id" => $theme_section_id , 
                        "allow_width"      => $allow_width
                    ]
                );
                if($section_order_setting != null){
                    $value = array_merge($value,$section_order_setting);
                }else{
                    $section_order_setting = $this->Common_model->get_record(
                        $this->_fix."section_order_setting",
                        [
                            "theme_section_id" => $theme_section_id , 
                            "allow_width"     => $oldallow_width
                        ]
                    );
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
                        if($oldallow_width != $allow_width){
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
                                    "title_size"        => $value["title_size"],
                                ]
                            );
                        }
                    }                 
                }
                $section[] = $value;
                //!clone section;
            }
        }
        $data = ["sections" => $section];
        $data["status"]  = "success"; 
        echo (json_encode( $data ));
    }
    public function get_section($id = 0){
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $this->load->model($this->_model);
        $this->load->model("Sections_model");
        $this->load->model("Blocks_model");
        $oldallow_width = $allow_width  = $this->input->post_get('allowScreen') ? $this->input->post_get('allowScreen') : 1920;
        $theme_id = $id;
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
            $html_setting_block = $html_setting_part = $html_setting = "";
            if($this->input->post("is_create") != 2){
                $html_setting_block = $this->load->view($this->_view."/templates/html_block/get_info",null,true);
                $html_setting_part = $this->load->view($this->_view."/templates/html_part/edit",null,true);
                $html_setting = $this->load->view($this->_view."/templates/html_section/get_info",null,true);
            }
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
                        if (strpos($value_st["value"],'/uploads/') !== false && strpos($value_st["value"],'com/uploads/') === false)  {
                            $value_st["value"] = str_replace("/uploads/",base_url("/uploads"). "/",$value_st["value"]);
                        }
                        $value["style"][$value_st["meta_key"]] = $value_st["value"];
                    }
                }else{
                    $value["style"] = (object) array();
                }
                
                $old_id = $value["theme_section_id"];
                //get all action default;
                $value["actions"] = $this->Sections_model->get_action_like("/section/",$value["clone_id"]);
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
                        $value_b["actions"] = $this->Blocks_model->get_actions($value_b["section_block_id"],$value["clone_id"],1);                        
                        //!clone action block;
                    }
                    $value_b["theme_section_id"] = $value["theme_section_id"];
                    $value_b["html_setting"] = $html_setting_block;
                    $value_b["sort"] = $sort_block;
                    $value_b["ramkey"]  = uniqid();
                    //!get order section block; 
                    $blocksetting = $this->Common_model->get_recode_for_select(
                        $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
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
                            $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                            [
                                "section_block_id" => $section_block_id,
                                "theme_section_id" => $theme_section_id,
                                "allow_width"      => $oldallow_width
                            ]
                        ); 
                        if($blocksetting != null){
                            $value_b = array_merge($value_b,$blocksetting);
                            if($oldallow_width != $allow_width){
                                $cloneSettting = [
                                    "section_block_id" => @$blocksetting["section_block_id"],
                                    "theme_section_id" => $value['theme_section_id'],
                                    "allow_width"      => @$allow_width,
                                    "sort"             => @$blocksetting['sort'],
                                    "ncolum"           => @$blocksetting['ncolum'],
                                    "class_name"       => @$blocksetting['class_name'],
                                    "id_name"          => @$blocksetting['id_name'],
                                    "is_form"          => @$blocksetting['is_form'],
                                    "is_default"       => @$blocksetting['is_default']
                                ];
                                $this->Common_model->add($this->_fix."section_block_order_setting",$cloneSettting);
                            }  
                        }
                        else{
                            $cloneSettting = [
                                "section_block_id" => @$value_b["section_block_id"],
                                "theme_section_id" => $value['theme_section_id'],
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
                    $block_new[] = $value_b;
                    $sort_block++;
                }
                $value["blocks"] = $block_new;   
                //!clone blocks default;
                $section_order_setting = $this->Common_model->get_record(
                    $this->_fix."section_order_setting",
                    [
                        "theme_section_id" => $theme_section_id , 
                        "allow_width"      => $allow_width
                    ]
                );
                if($section_order_setting != null){
                    $value = array_merge($value,$section_order_setting);
                }else{
                    $section_order_setting = $this->Common_model->get_record(
                        $this->_fix."section_order_setting",
                        [
                            "theme_section_id" => $theme_section_id , 
                            "allow_width"     => $oldallow_width
                        ]
                    );
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
                        if($oldallow_width != $allow_width){
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
                                    "title_size"        => $value["title_size"],
                                ]
                            );
                        }
                    }                 
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
                if (strpos($value["value"],'/uploads/') !== false && strpos($value["value"],'com/uploads/') === false)  {
                    $value["value"] = str_replace("/uploads/",base_url("/uploads"). "/",$value["value"]);
                }
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
            $args = [];
            foreach ($theme["effect_file"] as $key => $value) {
                if (strpos($value,'/uploads/') !== false && strpos($value,'com/uploads/') === false)  {
                   $value = str_replace("/uploads/",base_url("/uploads"). "/",$value);
                }
                $args[$key] = $value; 
            }
            $theme["effect_file"] = $args;

        }
        if(is_numeric($theme ["font_file"])){
            $font = $this->Common_model->get_record("font",["id" => $theme["font_file"]]);
            if (strpos($value,'/uploads/') !== false && strpos($value,'com/uploads/') === false)  {
               $font = str_replace("/uploads/",base_url("/uploads"). "/",$font);
            }
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
            $theme["thumb_url"] = base_url($thumb["path"]);
        }
        $data = ["theme" => $theme ,"sections" => $section];
        $data["sectionsv"] = $this->Common_model->get_result($this->_fix."sections",["status" => 1]);
        $data["status"]  = "success"; 
        $data["oldallow_width"]  = $oldallow_width;
        echo (json_encode( $data ));
        return true;

    }
    public function get_data($id = 0){
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
        $theme = $this->Common_model->get_record("theme_themes",["id" => $id]);
        $watermaker = 0;
         if( $theme ){
            $user = $this->Common_model->get_record("member",["id" => $theme["member_id"]] );
            if($user){
                $today    = strtotime(date('d-m-Y H:i:s'));
                $tomorrow =  strtotime(date('d-m-Y H:i:s',strtotime($user["expired_date"])));
                if($today > $tomorrow){
                    $data["redirect"] = 1; 
                    $data["redirect_URL"] = base_url('packages?alert=1');
                    die(json_encode($data));
                } 
                $maker = $this->Common_model->get_record("package_options",["group" => 'watermaker']);  
                if($maker){
                    $select_option = $this->Common_model->get_record("package_selects",[
                        "package_id" => $user["package_id"],
                        "option_id"  => $maker["id"]
                    ]);
                    if(!$select_option){
                        $watermaker = 1;
                    } 
                }     
            } 

        }
        $this->load->model($this->_model);
        $this->load->model("Sections_model");
        $this->load->model("Blocks_model");
        $oldallow_width = $allow_width  = $this->input->post_get('allowScreen') ? $this->input->post_get('allowScreen') : 1920;
        $theme_id = $id;
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
            $html_setting_block = $html_setting_part = $html_setting = "";
            if($this->input->post("is_create") != 2){
                $html_setting_block = $this->load->view($this->_view."/templates/html_block/get_info",null,true);
                $html_setting_part = $this->load->view($this->_view."/templates/html_part/edit",null,true);
                $html_setting = $this->load->view($this->_view."/templates/html_section/get_info",null,true);
            }
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
                        if (strpos($value_st["value"],'/uploads/') !== false && strpos($value_st["value"],'com/uploads/') === false)  {
                            $value_st["value"] = str_replace("/uploads/",base_url("/uploads"). "/",$value_st["value"]);
                        }
                        $value["style"][$value_st["meta_key"]] = $value_st["value"];
                    }
                }else{
                    $value["style"] = (object) array();
                }
                
                $old_id = $value["theme_section_id"];
                //get all action default;
                $value["actions"] = $this->Sections_model->get_action_like("/section/",$value["clone_id"]);
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
                        $value_b["actions"] = $this->Blocks_model->get_actions($value_b["section_block_id"],$value["clone_id"],1);                        
                        //!clone action block;
                    }
                    $value_b["theme_section_id"] = $value["theme_section_id"];
                    $value_b["html_setting"] = $html_setting_block;
                    $value_b["sort"] = $sort_block;
                    $value_b["ramkey"]  = uniqid();
                    //!get order section block; 
                    $blocksetting = $this->Common_model->get_recode_for_select(
                        $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
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
                            $this->_fix."section_block_order_setting","sort,is_default,section_block_id,ncolum,class_name,id_name,is_form,allow_width",
                            [
                                "section_block_id" => $section_block_id,
                                "theme_section_id" => $theme_section_id,
                                "allow_width"      => $oldallow_width
                            ]
                        ); 
                        if($blocksetting != null){
                            $value_b = array_merge($value_b,$blocksetting);
                            if($oldallow_width != $allow_width){
                                $cloneSettting = [
                                    "section_block_id" => @$blocksetting["section_block_id"],
                                    "theme_section_id" => $value['theme_section_id'],
                                    "allow_width"      => @$allow_width,
                                    "sort"             => @$blocksetting['sort'],
                                    "ncolum"           => @$blocksetting['ncolum'],
                                    "class_name"       => @$blocksetting['class_name'],
                                    "id_name"          => @$blocksetting['id_name'],
                                    "is_form"          => @$blocksetting['is_form'],
                                    "is_default"       => @$blocksetting['is_default']
                                ];
                                $this->Common_model->add($this->_fix."section_block_order_setting",$cloneSettting);
                            }  
                        }
                        else{
                            $cloneSettting = [
                                "section_block_id" => @$value_b["section_block_id"],
                                "theme_section_id" => $value['theme_section_id'],
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
                    $block_new[] = $value_b;
                    $sort_block++;
                }
                $value["blocks"] = $block_new;   
                //!clone blocks default;
                $section_order_setting = $this->Common_model->get_record(
                    $this->_fix."section_order_setting",
                    [
                        "theme_section_id" => $theme_section_id , 
                        "allow_width"      => $allow_width
                    ]
                );
                if($section_order_setting != null){
                    $value = array_merge($value,$section_order_setting);
                }else{
                    $section_order_setting = $this->Common_model->get_record(
                        $this->_fix."section_order_setting",
                        [
                            "theme_section_id" => $theme_section_id , 
                            "allow_width"     => $oldallow_width
                        ]
                    );
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
                        if($oldallow_width != $allow_width){
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
                                    "title_size"        => $value["title_size"],
                                ]
                            );
                        }
                    }                 
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
                if (strpos($value["value"],'/uploads/') !== false && strpos($value["value"],'com/uploads/') === false)  {
                    $value["value"] = str_replace("/uploads/",base_url("/uploads"). "/",$value["value"]);
                }
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
            $args = [];
            foreach ($theme["effect_file"] as $key => $value) {
                if (strpos($value,'/uploads/') !== false && strpos($value,'com/uploads/') === false)  {
                   $value = str_replace("/uploads/",base_url("/uploads"). "/",$value);
                }
                $args[$key] = $value; 
            }
            $theme["effect_file"] = $args;

        }
        if(is_numeric($theme ["font_file"])){
            $font = $this->Common_model->get_record("font",["id" => $theme["font_file"]]);
            if (strpos($value,'/uploads/') !== false && strpos($value,'com/uploads/') === false)  {
               $font = str_replace("/uploads/",base_url("/uploads"). "/",$font);
            }
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
            $theme["thumb_url"] = base_url($thumb["path"]);
        }
        $data = ["theme" => $theme ,"sections" => $section ,"watermaker" => $watermaker];
        $data["sectionsv"] = $this->Common_model->get_result($this->_fix."sections",["status" => 1]);
        $data["status"]  = "success"; 
        $data["oldallow_width"]  = $oldallow_width;
        echo (json_encode( $data ));
        return true;

    }
    public function create($slug){
        $this->check_login();
        $theme = $this->Common_model->get_record($this->_fix.'themes',['slug' => @$slug ,'is_system' => 1 ,'public' => 1 ,'status' => 1]);
        if($theme == null) redirect(base_url('themes'));
        $this->_data['post']['is_create'] = 1;
        $this->_data['slug'] = $slug;
        $this->_data['post']['id'] = $theme['id'];
        $this->_data['action_save'] = $this->_cname.'/save_create';
        $this->_data['containerClass'] = 'full-content';
        $this->load->view($this->_view . '/create_and_edit',$this->_data);
    }
    public function save_block (){
        if($this->input->is_ajax_request()){
            $parts = $this->input->post('parts');
            $allow_width = $this->input->post("allowScreen") ?  $this->input->post("allowScreen") : 1920;
            foreach ($parts as $key => $part) {
                $data [] = $this->save_part($part,$allow_width);
            }
        }
        return true;
    }
    private function save_part($part,$allow_width){
        $metas = [];
        $block_part_id     = $part['block_part_id'];
        $section_block_id  = $part['section_block_id'];
        $theme_section_id  = $part['theme_section_id'];
        $metas             = $part['metas'];
        $check = $this->Common_model->get_record($this->_fix.'section_block_part_order',[
            'block_part_id'    => $block_part_id,
            'section_block_id' => $section_block_id,
            'theme_section_id' => $theme_section_id
        ]);
        if($check){
            $id_in = [];
            if($metas){
                foreach ($metas as $key => $value) {
                    if($value['id'] != 0 && is_numeric($value['id'])){
                        $u = [
                            'value'    => @$value['value'],
                            'media_id' => @$value['media_id'],
                            'sort'     => $key
                        ];
                        $this->Common_model->update($this->_fix.'block_part_meta',$u,['id' => $value['id']]);
                    }else {
                        $i = [
                            'block_part_id'     => $block_part_id,
                            'section_block_id'  => $section_block_id,
                            'theme_section_id'  => $theme_section_id,
                            'meta_key'          => @$value['meta_key'],
                            'value'             => @$value['value'],
                            'media_id'          => @$value['media_id'],
                            'sort'              => $key,
                        ];
                        $value['id'] = $this->Common_model->add($this->_fix.'block_part_meta',$i);
                        $metas [] = $value;
                    }
                    $id_in[] = $value['id'];
                }
                $this->db->where_not_in('id', $id_in);
                $this->db->where([
                    'block_part_id'     => $block_part_id,
                    'section_block_id'  => $section_block_id,
                    'theme_section_id'  => $theme_section_id
                ]);  
                $this->db->delete($this->_fix.'block_part_meta'); 
            }
            
            //!update metas;
        }
        return true;
    }
    public function save_section(){
        if($this->input->is_ajax_request()){
            $section     = $this->input->post();
            $style       = $this->input->post('style');
            $allow_width = $this->input->post("allowScreen");
            $check = $this->Common_model->get_record($this->_fix.'section_order',["theme_section_id" => $section["theme_section_id"]]);
            if(!$check){
                $this->Common_model->add($this->_fix.'section_order',$iu);
            }else{
            	$this->Common_model->update(
            		$this->_fix.'section_order',
            		[
            			"name"      => $section["name"],
                        "is_effect" => $section["is_effect"],
                        "everyday_effect" => $section["everyday_effect"],
                        "from_day_effect" => $section["from_day_effect"],
            		],
                    [
            			"theme_section_id"  => $section["theme_section_id"]
            		]
            	);
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
        //update style;
        foreach ($style as $key => $value) {
            $check = $this->Common_model->get_record($this->_fix.'style_meta',[
                'reference_id' => $section['theme_section_id'],
                'support_key'  => 'section',
                'meta_key'     => $key
            ]);
            if($check){
                $this->Common_model->update($this->_fix.'style_meta',['value' => $value],[
                    'reference_id' => $section['theme_section_id'],
                    'support_key'  => 'section',
                    'meta_key'     => $key
                ]);
            }else{
                $i = [
                    'reference_id' => $section['theme_section_id'],
                    'support_key'  => 'section',
                    'meta_key'     => $key,
                    'value'        => $value
                ];
                $this->Common_model->add($this->_fix.'style_meta',$i);
            }
        }
        //!update style;
        die(json_encode($this->input->post()));
    }
    public function save_theme (){
        if($this->input->is_ajax_request()){
            $theme = $this->input->post();
            $check = $this->Common_model->get_record($this->_fix.'themes',['id' => $theme['id'] ,'is_system' => 0 , 'member_id' => $this->_user_id]);
            if($check == null) die(['status' => 'error' ,'message' => 'Có lỗi xãy ra!']);
            $u = [
                'name'              => $theme['name'],
                'description'       => $theme['description'],
                'thumb'             => $theme['thumb'],
                'font_file'         => $theme['font_file'],
                'sound_file'        => $theme['sound_file'],
                'size_title'        => $theme['size_title'],
                'color_title'       => $theme['color_title'],
                'effect'            => $theme['effect'],
                'effect_file'       => json_encode($theme['effect_file']),
                'effect_media_id'   => $theme['effect_media_id'],
                'is_system'         => 0,
                'sound_play'        => $theme['sound_play'],
                'public'            => $theme['public'],
                'is_active'         => $theme['is_active'],
                'sound_example'     => @$theme['sound_example'] ? @$theme['sound_example'] : 0,
                'status'            => 1
            ];
            if($theme['is_active'] == 1){
                $this->Common_model->update(
                    $this->_fix.$this->_table,
                    ['is_active' => 0],
                    [
                        'member_id' => $this->user_id,
                        'is_system' => 0
                    ]
                );
            }
            $this->Common_model->update($this->_fix.$this->_table,$u,['id' => $theme['id']]);
            if(@$theme['style']){
                foreach ($theme['style'] as $key => $value) {
                    $check = $this->Common_model->get_record($this->_fix.'style_meta',[
                        'reference_id' => $theme['id'],
                        'support_key'  => 'theme',
                        'meta_key'     => $key
                    ]);
                    if($check){
                        $this->Common_model->update($this->_fix.'style_meta',['value' => $value],[
                            'reference_id' => $theme['id'],
                            'support_key'  => 'theme',
                            'meta_key'     => $key
                        ]);
                    }else{
                        $this->Common_model->add($this->_fix.'style_meta',[
                            'reference_id' => $theme['id'],
                            'support_key'  => 'theme',
                            'meta_key'     => $key,
                            'value'        => $value
                        ]);
                    }
                }
            }
            die(json_encode($theme));
        }  
    }
    public function addsection(){
        if($this->input->is_ajax_request()){
            $svsection    = $this->input->post('svsection');
            $theme_id     = $this->input->post('theme_id');
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
            $section_setting_insert = $block_setting_inserts = $sbods = $style_meta_inserts = $old_ord_inserts =  $inserts = [];
            $parent_id    = $this->input->post('parent_id');
            $html_setting = $this->load->view($this->_view.'/templates/html_section/get_info',null,true);
            $html_setting_block = $this->load->view($this->_view.'/templates/html_block/get_info',null,true);
            $html_setting_part = $this->load->view($this->_view.'/templates/html_part/edit',null,true);
            $html_style   = $this->load->view($this->_view.'/templates/html_section/style',null,true);
            $this->load->model($this->_model);
            $this->load->model('Sections_model');
            $this->load->model('Blocks_model');
            //clone section;   
            $get_sortmax = $this->{$this->_model}->get_sortmax($theme_id);
            if($get_sortmax == null) 
                $sort  = 0;
            else 
                $sort  = $get_sortmax["sort"] + 1;
            $value = $this->{$this->_model}->get_section($svsection["id"],$parent_id);
            //clone section;   
            $value['sort']         = $sort;      
            $value['theme_id']     = $theme_id;
            $value['ramkey']       = uniqid();
            $value['style']        = null; 
            $value['blocks']       = [];
            $theme_section_id      = $value['theme_section_id'];
            $metas  = $this->Common_model->get_result_for_select($this->_fix.'block_part_meta','id,theme_section_id,section_block_id,block_part_id,meta_key,value,media_id,sort',
                [
                    'theme_section_id' => $theme_section_id
                ],
                null, null, [['field' => 'sort','sort' => 'ASC']]
            ); 
            $styles = $this->Common_model->get_result($this->_fix.'style_meta',['reference_id' => $theme_section_id,'support_key' => 'section']);
            $old_id = $value['theme_section_id'];
            //clone order theme section;
            $value['theme_section_id']  = $this->Common_model->add($this->_fix.'section',[
                'theme_id'    => $theme_id,
                'section_id'  => $value['id'],
                'is_default'  => 0,
                'clone_id'    => $old_id,
            ]);
            $old_ord = $this->Common_model->get_recode_for_select($this->_fix.'section_order','layout_show_block,name,class_name,is_full,show_title,ncolum_block,ncolum_show_block,default_block',['theme_section_id' => $old_id]);
            $old_ord['name'] = $value['name'];
            $old_ord['theme_section_id'] = $value['theme_section_id'];
            $old_ord['sort']   = $sort;
            $old_ord_inserts[] = $old_ord;
            if($styles){
                foreach ($styles as $key_st => $value_st) {
                    $value_st['reference_id'] = $value['theme_section_id'];
                    $style_meta_inserts[] = $value_st;
                } 
            }   
            //clone blocks default;
            $lblocks = $this->{$this->_model}->get_blocks($value['id'],$theme_section_id,$value['default_block'],$value['ncolum_show_block'],0);     
            $allScreenSecsion = $this->Common_model->get_result($this->_fix."section_order_setting",[
                "theme_section_id" => $theme_section_id 
            ]);
            if($allScreenSecsion){
                foreach ($allScreenSecsion as $key_allScreenSecsion => $value_allScreenSecsion) {
                   $value_allScreenSecsion["theme_section_id"] = $value['theme_section_id'];
                   $section_setting_insert [] = $value_allScreenSecsion;
                }
            }
            $section_block_order_settings = $this->Common_model->get_result($this->_fix."section_block_order_setting",[
                "theme_section_id" => $theme_section_id
            ]);
            if($section_block_order_settings){
                foreach ($section_block_order_settings as $key_section_block_order_settings => $value_section_block_order_settings) {
                    $value_section_block_order_settings["theme_section_id"] = $value["theme_section_id"];
                    $block_setting_inserts [] = $value_section_block_order_settings;
                }
            }
            foreach ($lblocks as $key_b => $value_b) {
                //get order section block;
                $sort_block       = 0;
                $section_block_id = $value_b['section_block_id'];
                $is_default = 0;
                $sbod = $this->Common_model->get_recode_for_select($this->_fix.'section_block_order','section_block_id,ncolum,class_name,is_form',['section_block_id' => $section_block_id ,'is_default' => $is_default,'theme_section_id' => $theme_section_id]);
                if($sbod){
                    $sbod['theme_section_id'] = $value['theme_section_id'];
                    $sbod['is_default']       = 0;
                    $sbod['sort']             = $key_b;
                    $sbods[]                  = $sbod;
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
                            'class_name'       => $value_p['class_name'],
                        ];     
                        //clone meta part
                        foreach ($metas as $key_m => $value_m) {
                            if($value_m['block_part_id'] == $value_p['block_part_id'] && $value_m['section_block_id'] == $section_block_id){
                                $this->Common_model->add($this->_fix.'block_part_meta', [
                                    'block_part_id'    => $value_p['block_part_id'],
                                    'section_block_id' => $section_block_id,
                                    'theme_section_id' => $value['theme_section_id'],
                                    'meta_key'         => $value_m['meta_key'],
                                    'value'            => $value_m['value'],
                                    'media_id'         => $value_m['media_id']
                                ]);
                            }   
                        }                                                               
                    }
                    //!clone part block;       
                }
                $sort_block++;
            } 
            //!clone blocks default;
            //!clone section;
            if($sbods)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order',$sbods);
            if($block_setting_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order_setting',$block_setting_inserts);
            if($style_meta_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'style_meta',$style_meta_inserts); 
            if($old_ord_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_order',$old_ord_inserts);
            if($section_setting_insert)
                $this->Common_model->insert_batch_data($this->_fix.'section_order_setting',$section_setting_insert);
            if($inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_part_order',$inserts); 
            
            $value = $this->{$this->_model}->get_section($svsection["id"],$theme_id);
            //clone section;   
            $value["sort"] = $sort;
            $value["html_setting"] = $html_setting;
            $value["theme_id"] = $theme_id;
            $value["ramkey"] = uniqid();
            $value["style"] = null; 
            $theme_section_id = $value["theme_section_id"];
            $styles = $this->Common_model->get_result($this->_fix."style_meta",[
                "reference_id" => $theme_section_id,
                "support_key"  => "section",
                "allow_width"  => $oldallow_width
            ]);
            if($styles){
                foreach ($styles as $key_st => $value_st) {
                    $value["style"][$value_st["meta_key"]] = $value_st["value"];
                }
            }else{
                $value["style"] = (object) array();
            }
            
            $old_id = $value["theme_section_id"];
            //get all action default;
            $value["actions"] = $this->Sections_model->get_action_like("/section/",$value["clone_id"]);
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
                    $value_b["actions"] = $this->Blocks_model->get_actions($value_b["section_block_id"],$value["clone_id"],1);                        //!clone action block;
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
                    ]
                );
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
            die ( json_encode($value)) ;    
            return true;
        }
    }
    public function addnewblock(){
        if($this->input->is_ajax_request()){
            $block_id           = $this->input->post('block_id');
            $theme_id           = $this->input->post('theme_id');
            $allow_width        = $this->input->post('allowScreen');
            $theme              = $this->Common_model->get_record($this->_fix.'themes',['id' => $theme_id]);
            if($theme == null ) die(json_encode(['sql' => $sql,'p' => $this->input->post(),'status' => 'error','message' => 'Has been an error ! Please try later']));
            $parent_id          = $this->input->post('parent_id') == 0 ?  $theme_id : $this->input->post('parent_id');
            $section_id         = $this->input->post('section_id');
            $theme_section_id   = $this->input->post('theme_section_id');
            $sort               = $this->input->post('sort');
            $this->load->model($this->_model);
            $this->load->model('Sections_model');
            $this->load->model('Blocks_model');
            $block_setting_inserts = $sbods = $inserts = [];
            $theme_section                  = $this->Common_model->get_record($this->_fix."section",["id" => $theme_section_id]);
            $old_theme_section_id           = $theme_section["clone_id"];
            $value_b                        = $this->{$this->_model}->get_first_block_by_section($section_id,$block_id,$old_theme_section_id);
            $block_name                     = $value_b["name"];
            $is_default                     = 0;           
            $old_theme_section_block_id     = $value_b["id"];
            unset($value_b["id"]);
            unset($value_b["name"]);
            $value_b["is_default"] = 0;
            $section_block_id = $this->Common_model->add($this->_fix."section_block",$value_b);
            $section_block_order_settings   = $this->Common_model->get_result($this->_fix."section_block_order_setting",[
                "theme_section_id" => $theme_section_id,
                "section_block_id" => $old_theme_section_block_id
            ]);
            if($section_block_order_settings){
                foreach ($section_block_order_settings as $key_section_block_order_settings => $value_section_block_order_settings) {
                    $value_section_block_order_settings["theme_section_id"] = $theme_section_id;
                    $value_section_block_order_settings["section_block_id"] = $section_block_id;
                    $block_setting_inserts [] = $value_section_block_order_settings;
                }
            }
            
            //get order section block;
            $sort_block = 0;
            $is_default = 0;
            $sbod = $this->Common_model->get_recode_for_select(
                $this->_fix.'section_block_order',',section_block_id,ncolum,class_name,is_form',
                [
                    'section_block_id' => $old_theme_section_block_id ,
                    'is_default'       => $is_default,
                    'theme_section_id' => $old_theme_section_id
                ]
            );
            if($sbod){
                $sbod['theme_section_id']   = $theme_section_id;
                $sbod['section_block_id']   = $section_block_id;
                $sbod['is_default']         = 0;
                $sbod['sort']               = $sort;
                $sbods[]                    = $sbod;
                //clone part block;
                $lparts = $this->{$this->_model}->get_parts($block_id,$old_theme_section_block_id,$old_theme_section_id);
                $sort_part = 0;
                $metas  = $this->Common_model->get_result_for_select($this->_fix."block_part_meta","id,section_block_id,block_part_id,meta_key,value,media_id,sort",
                    [
                        "theme_section_id" => $old_theme_section_id,
                        "section_block_id" => $old_theme_section_block_id,
                    ]
                );
                foreach ($lparts as $key_p => $value_p) {
                    $value_p['actions'] = [];
                    $value_p['metas']   = [];
                    $value_p['ramkey']  = uniqid();
                    $inserts[] = [
                        'section_block_id' => $section_block_id,
                        'theme_section_id' => $theme_section_id,
                        'block_part_id'    => $value_p['block_part_id'],
                        'sort'             => $value_p['sort'],
                        'ncolum'           => $value_p['ncolum'],
                        'id_name'          => $value_p['id_name'],
                        'class_name'       => $value_p['class_name'],
                    ];     
                    //clone meta part
                    foreach ($metas as $key_m => $value_m) {
                        if($value_m['block_part_id'] == $value_p['block_part_id']){
                            $this->Common_model->add($this->_fix.'block_part_meta', [
                                'block_part_id'    => $value_p['block_part_id'],
                                'section_block_id' => $section_block_id,
                                'theme_section_id' => $theme_section_id,
                                'meta_key'         => $value_m['meta_key'],
                                'value'            => $value_m['value'],
                                'media_id'         => $value_m['media_id']
                            ]);
                        }   
                    }                                                               
                }
                //!clone part block;       
            }
            if($sbods)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order',$sbods);
            if($block_setting_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order_setting',$block_setting_inserts);
            if($inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_part_order',$inserts);
            //get order section block;

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
            $value_b = $this->Common_model->get_record($this->_fix."section_block",["id" => $section_block_id]);
            $is_default = 0;
            $sbod = $this->Common_model->get_recode_for_select($this->_fix."section_block_order","section_block_id,ncolum,class_name,is_form",["section_block_id" => $section_block_id ,"is_default" => $is_default,"theme_section_id" => $theme_section_id]);
            $html_setting_block = $this->load->view($this->_view.'/templates/html_block/get_info',null,true);
            $html_setting_part = $this->load->view($this->_view.'/templates/html_part/edit',null,true);
            if($sbod){
                $sbod["theme_section_id"] = $theme_section_id;
                $sbod["is_default"] = 0;
                $sbod["sort"] = $sort;
                
                //clone part block;
                $lparts = $this->{$this->_model}->get_parts($block_id,$section_block_id,$theme_section_id);
                $part_new = [];
                $sort_part = 0;
                $metas  = $this->Common_model->get_result_for_select($this->_fix."block_part_meta","id,section_block_id,block_part_id,meta_key,value,media_id,sort",
                    [
                        "theme_section_id" => $theme_section_id,
                        "section_block_id" => $section_block_id,
                    ]
                );
                foreach ($lparts as $key_p => $value_p) {
                    $value_p["actions"] = [];
                    $value_p["metas"]   = [];
                    $value_p["ramkey"]  = uniqid();
                    $value_p["html_setting"] = $html_setting_part;
                    $value_p["theme_section_id"] = $theme_section_id;     
                    //clone meta part
                        $value_p["metas"] = [];
                        foreach ($metas as $key_m => $value_m) {
                            if($value_m["block_part_id"] == $value_p["block_part_id"]){
                                $value_m["theme_section_id"] = $theme_section_id;
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
                    $value_p["sort"]         = $sort_part;
                    $sort_part++;
                    $part_new[] =  $value_p;
                }
                $value_b["parts"] = $part_new;
                //!clone part block;
                //clone action block;
                $value_b["actions"] = $this->Blocks_model->get_actions($old_theme_section_block_id,$old_theme_section_id,1);                        //!clone action block;
            }

            $value_b["theme_section_id"] = $theme_section_id;
            $value_b["html_setting"]     = $html_setting_block;
            $value_b["sort"]             = $sort_block;
            $value_b["ramkey"]           = uniqid();
            //!get order section block; 
            $blocksetting = $this->Common_model->get_recode_for_select($this->_fix."section_block_order_setting",
                "section_block_id,ncolum,class_name,is_form,allow_width",
                [
                    "section_block_id" => $section_block_id,
                    "theme_section_id" => $theme_section_id,
                    "allow_width"      => $oldallow_width
                ]
            );

            if($blocksetting != null)
                $value_b = array_merge($value_b,$blocksetting);
            $value_b["id"]   = $block_id;
            $value_b['name'] = $block_name;
            die(json_encode($value_b));
        }
    }
    public function preview ($slug ){
        $theme = $this->Common_model->get_record($this->_fix.'themes',['slug' => $slug,'status' => 1,'version' => 3]);
        if($theme == null) redirect(base_url());
        $thumb = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['thumb']]);
        list($width, $height, $type, $attr) = getimagesize(base_url($thumb['thumb']));
        $metas = '<meta property="og:image" content="'.base_url($thumb['thumb']).'"/>';
        $metas .= '<meta property="og:image:width" content="'.$width.'"/>';
        $metas .= '<meta property="og:image:height" content="'.$height.'"/>';
        $metas .= '<link rel="image_src" type="image/jpeg"  href="'.base_url($thumb['thumb']).'" />';
        $metas .= '<meta property="og:description" content="'.$theme['description'].'"/>';
        $metas .= '<meta property="og:title" content="'.$theme['name'].'"/>';
        $this->_data['post']['is_create'] = 2;
        $this->_data['post']['id']  = $theme['id'];
        $this->_data['action_save'] = $this->_cname.'/save_view';
        $this->_data['containerClass'] = 'full-content';
        $this->_data['metas'] = $metas;
        $sound = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['sound_file']]);
        $this->_data['post']['sound_URL'] = @$sound['path'];
        $this->load->view('/frontend/appthemes/block/header',$this->_data);
        $this->load->view($this->_view . '/preview',$this->_data);
        $this->load->view('/frontend/appthemes/block/footer',$this->_data);
    }
    public function view ($slug){
        $theme = $this->Common_model->get_record($this->_fix.'themes',['slug' => $slug]);
        if($theme == null) redirect(base_url());
        $thumb = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['thumb']]);
        list($width, $height, $type, $attr) = getimagesize(base_url($thumb['thumb']));
        $metas = '<meta property="og:image" content="'.base_url($thumb['thumb']).'"/>';
        $metas .= '<meta property="og:image:width" content="'.$width.'"/>';
        $metas .= '<meta property="og:image:height" content="'.$height.'"/>';
        $metas .= '<link rel="image_src" type="image/jpeg"  href="'.base_url($thumb['thumb']).'" />';
        $metas .= '<meta property="og:description" content="'.$theme['description'].'"/>';
        $metas .= '<meta property="og:title" content="'.$theme['name'].'"/>';
        $this->_data['post']['is_create'] = 2;
        $this->_data['post']['id'] = $theme['id'];
        $this->_data['action_save'] = $this->_cname.'/save_view';
        $this->_data['containerClass'] = 'full-content';
        $this->_data['metas'] = $metas;
        $sound = $this->Common_model->get_record($this->_fix.'medias',['id' => $theme['sound_file']]);
        $this->_data['post']['sound_URL'] = @$sound['path'];
        $this->load->view('/frontend/appthemes/block/header',$this->_data);
        $this->load->view($this->_view . '/view',$this->_data);
        $this->load->view('/frontend/appthemes/block/footer',$this->_data);
    }
    public function guestbook (){
        if($this->input->is_ajax_request()){
            $block_id   = $this->input->post('block_id');
            $theme_id   = $this->input->post('theme_id');
            $name       = $this->input->post('name');
            $content    = $this->input->post('content');
            $theme      = $this->Common_model->get_record($this->_fix.'themes',['id' => $theme_id]);
            if($theme == null ) die(json_encode(['sql' => $sql,'p' => $this->input->post(),'status' => 'error','message' => 'Has been an error ! Please try later']));
            $svblock = $this->Common_model->get_record($this->_fix.'blocks',['id' => $block_id]);
            if($svblock == null ) die(json_encode(['sql' => $sql,'p' => $this->input->post(),'status' => 'error','message' => 'Has been an error ! Please try later']));
            $parent_id          = $this->input->post('parent_id');
            $section_id         = $this->input->post('section_id');
            $theme_section_id   = $this->input->post('theme_section_id');
            $sort               = $this->input->post('sort');
            $this->load->model($this->_model);
            $this->load->model('Sections_model');
            $this->load->model('Blocks_model');
            //get defaut theme section id
            $theme_section_old = $this->Common_model->get_record($this->_fix.'section',['section_id' => $section_id ,'theme_id' => $parent_id]);
            if($theme_section_old  == null ) die(['status' => 'error','message' => 'Has been an error ! Please try later']);
            //!get defaut theme section id

            //get frist default block.
            $section_block_old = $this->{$this->_model}->get_default_section_block($theme_section_old['id'] ,$section_id,$block_id);
            if($section_block_old  == null ) die(['status' => 'error','message' => 'Has been an error ! Please try later']);
            //!get frist default section block.
            $html_setting_part  = $this->load->view($this->_view.'/templates/html_part/edit',null,true);
            $html_setting_block = $this->load->view($this->_view.'/templates/html_block/get_info',null,true);
            $order_block = $this->Common_model->get_record($this->_fix.'section_block_order',['section_block_id' => $section_block_old['id'],'theme_section_id' => $theme_section_old['id']]);
            if($order_block  == null ) die(['status' => 'error','message' => 'Has been an error ! Please try later']);
            $ramkey = uniqid();
            //add block tp section
            $b = [
                'block_id'    => $svblock['id'],
                'section_id'  => $section_id
            ];
            $section_block_id = $this->Common_model->add($this->_fix.'section_block',$b);
            //!add block tp section
            //get block order default;
                $in = [
                    'section_block_id' => $section_block_id,
                    'theme_section_id' => $theme_section_id,
                    'class_name'       => $order_block['class_name'],
                    'is_default'       => $order_block['is_default'],
                    'is_form'          => $order_block['is_form'],
                    'ncolum'           => $order_block['ncolum'],
                    'sort'             => $sort ,
                    'member_id'        => $this->_user_id        
                ];
                $this->Common_model->add($this->_fix.'section_block_order',$in); 
                $svblock = array_merge($svblock,$in);
                $svblock['actions']      = $this->Blocks_model->get_actions($section_block_old['id'],$theme_section_old['id']);
                $svblock['ramkey']       = $ramkey;
                $svblock['style']        = null;
                $svblock['html_setting'] = $html_setting_block;
                //clone part block;
                $lparts = $this->{$this->_model}->get_parts($svblock['id'],$section_block_old['id'], $theme_section_old['id']);
                $part_new = [];
                foreach ($lparts as $key_p => $value_p) {
                    $value_p['actions'] = [];
                    $value_p['metas']   = [];
                    $insert = [
                        'block_part_id'    => $value_p['block_part_id'],
                        'section_block_id' => $section_block_id,
                        'theme_section_id' => $theme_section_id,
                        'sort'             => $value_p['sort'],
                        'ncolum'           => $value_p['ncolum'],
                        'id_name'          => $value_p['id_name'],
                        'class_name'       => $value_p['class_name']
                    ];
                    $this->Common_model->add($this->_fix.'section_block_part_order',$insert); 
                    $value_p['html_setting'] = $html_setting_part;
                    $value_p['theme_section_id'] = $theme_section_id;
                    //clone action part
                        $actions = $this->{$this->_model}->get_actions_part($value_p['block_part_id'],$section_block_old['id'],$theme_section_old['id']);
                        foreach ($actions as $key => $value_a) {
                            $this->Common_model->add($this->_fix.'part_action',[
                                'block_part_id'    => $value_p['block_part_id'],
                                'section_block_id' => $section_block_id,
                                'theme_section_id' => $theme_section_id,
                                'action_id'        => $value_a['id'],
                                'active'           => $value_a['active']
                            ]);
                            $value_a['block_part_id']    = $value_p['block_part_id'];
                            $value_a['section_block_id'] = $section_block_id;
                            $value_a['theme_section_id'] = $theme_section_id;
                            $value_p['actions'][] = $value_a;
                        }

                    //!clone action part        
                    //clone meta part
                        $metas  = $this->Common_model->get_result($this->_fix.'block_part_meta',
                                [
                                    'block_part_id'    => $value_p['block_part_id'], 
                                    'section_block_id' => $section_block_old['id'],
                                    'theme_section_id' => $theme_section_old['id']
                                ]
                            ); 
                        foreach ($metas as $key => $value_m) {
                            if($key_p == 0){
                            	$insert = [
                                    'block_part_id'    => $value_m['block_part_id'],
                                    'section_block_id' => $section_block_id,
                                    'theme_section_id' => $theme_section_id,
                                    'meta_key'         => $value_m['meta_key'],
                                    'value'            => $name,
                                    'media_id'         => 0
                                ];
                                $value_m['value'] = $name;
                                $this->Common_model->add($this->_fix.'block_part_meta',$insert);
    	                        $value_m['theme_section_id'] = $theme_section_id;
    	                        $value_m['section_block_id'] = $section_block_id;
    	                        $value_m['ramkey']  = uniqid(); 
    	                        $value_p['metas'][] = $value_m;
                            }   
                            else if($key_p == 1){
                            	$insert = [
                                    'block_part_id'    => $value_m['block_part_id'],
                                    'section_block_id' => $section_block_id,
                                    'theme_section_id' => $theme_section_id,
                                    'meta_key'         => $value_m['meta_key'],
                                    'value'            => $content,
                                    'media_id'         => 0
                                ];
                                $value_m['value'] = $content;
                                $this->Common_model->add($this->_fix.'block_part_meta',$insert);
    	                        $value_m['theme_section_id'] = $theme_section_id;
    	                        $value_m['section_block_id'] = $section_block_id;
    	                        $value_m['ramkey']  = uniqid(); 
    	                        $value_p['metas'][] = $value_m;
                            }  
                            else break; 
                        }
                    //!clone meta part
                    $part_new[] =  $value_p;
                }
                $svblock['parts'] = $part_new;
                //!clone part block;
                //!get parts by block id;
            //!get block order default;
            die ( json_encode($svblock)) ;
        }
    }
    public function get_template_by_sidebar(){
        if($this->input->is_ajax_request()){
            $folder   = 'templates/html_sidebars';
            $template = $this->input->post('template');
            $args  = [
              'page-change',
              'page-background',
              'page-font',
              'page-sound',
              'page-effect',
              'page-section',
              'page-style',
              'page-info',
              'page-screen'
            ];
            if(in_array($template, $args)){
              $this->load->view($this->_view.'/'.$folder.'/'.$template);
            }
        }
    }
    public function get_template_section(){
        if($this->input->is_ajax_request()){
            $folder   = 'templates/html_section';
            $template = $this->input->post('template');
            $this->load->view($this->_view.'/'.$folder.'/'.$template);  
        }
        return false;
    }
    public function iframe (){
        $this->load->view($this->_view . '/iframe',$this->_data);
    }
    public function edit($slug){
        $this->check_login();
        if(@$this->_data['user']['is_system'] == 1 )
            $theme = $this->Common_model->get_record($this->_fix.'themes',['slug' => $slug]);
        else
            $theme = $this->Common_model->get_record($this->_fix.'themes',['slug' => $slug ,'is_system' => 0 , 'member_id' => $this->_user_id]);
        if($theme == null) redirect(base_url('themes'));
        $this->_data['post']['is_create'] = 2;
        $this->_data['action_save'] = $this->_cname.'/save_edit/'.$theme['id'];
        $this->_data['post'] = $theme;
        $this->_data['slug'] = $slug;
        $this->load->view($this->_view . '/create_and_edit',$this->_data);
    }
    public function delete($slug){
        $this->check_login();
        if($this->input->is_ajax_request()){
            $data = ['status' => 'error','message' => null,'response' => null ,'record' => null,'post' => $this->input->post() ];
            $this->Common_model->delete($this->_fix.$this->_table,['slug' => $slug,'member_id' => $this->_user_id]);
            $data ['status'] = 'success';
        } 
        die(json_encode($data) );
    }
    public function updatesort ($type = 'section'){
        if($this->input->is_ajax_request()){
            $l = $this->input->post('list');
            if($l){
                if($type == 'block'){
                    foreach ($l as $key => $value) {
                        $this->Common_model->update($this->_fix.'section_block_order',['sort' => $key],[
                            'section_block_id' => $value['section_block_id'],
                            'theme_section_id' => $value['theme_section_id']
                        ]);
                    }
                }elseif ($type == 'part') {
                    foreach ($l as $key => $value) {
                        $this->Common_model->update($this->_fix.'section_block_part_order',['sort' => $key],[
                            'block_part_id'    => $value['block_part_id'],
                            'theme_section_id' => $value['theme_section_id'],
                            'section_block_id' => $value['section_block_id']
                        ]);
                    }
                }elseif($type == 'section'){
                    foreach ($l as $key => $value) {
                        $this->Common_model->update($this->_fix.'section_order',['sort' => $key],[
                            'theme_section_id' => $value['theme_section_id'],
                        ]);
                    }
                }elseif($type == 'meta'){
                    foreach ($l as $key => $value) {
                        $this->Common_model->update($this->_fix.'block_part_meta',['sort' => $key],[
                            'id'  => $value['meta_id'] 
                        ]);  
                    }
                }
            }
            die(json_encode($l));
        }
    }
    public function deleteitem($type){
        if($this->input->is_ajax_request()){
            $l = $this->input->post('item');
            if($l){
                if($type == 'block'){
                    $this->Common_model->delete($this->_fix.'section_block_order',[
                        'section_block_id' => @$l['section_block_id'],
                        'theme_section_id' => @$l['theme_section_id']
                    ]);
                }elseif ($type == 'part') {
                    $this->Common_model->delete($this->_fix.'section_block_part_order',[
                        'block_part_id'    => @$l['block_part_id'],
                        'theme_section_id' => @$l['theme_section_id'],
                        'section_block_id' => @$l['section_block_id']
                    ]);
                }elseif($type == 'section'){
                    $this->Common_model->delete($this->_fix.'block_part_meta',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section_block_part_order',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section_block_order',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section_block_order_setting',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section_order',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section_order_setting',['theme_section_id' => @$l['theme_section_id']]);
                    $this->Common_model->delete($this->_fix.'section',['id' => @$l['theme_section_id']]);    
                }
            }
            die(json_encode($l));
        }
    }
    public function deletetheme(){
        $id   = $this->input->post('id');
        $data = ['status' => 'error','message' => null,'response' => null ,'record' => null,'post' => $this->input->post() ];
        if( is_numeric($id) ){
            $check = $this->Common_model->get_record($this->_fix.$this->_table, ['status' => 1,'id' => $id,'member_id' => $this->_user_id]);
            if($check){
                $this->Common_model->update($this->_fix.$this->_table ,['status' => 0,'is_delete' => 1] ,['id' => $id ,'member_id' => $this->_user_id]);
                $data['status']   = 'success';
                $data['redirect'] = base_url('themes/my');
            }else{
                $data['status']   = 'success';
                $data['message'] = 'Theme này không tồn tại';
            }
        }
        die(json_encode($data));
    }
    public  function dowloadtheme ($id){
        $theme = $this->Common_model->get_record($this->_fix."themes",["id" => $id ]);
        if(file_exists(FCPATH .$theme["slug"].".zip")){
            header('Content-Type: application/zip');
            header("Content-Disposition: attachment; filename='".$theme["slug"].'.zip'."'");
            header('Content-Length: ' . filesize(FCPATH . "/".$theme["slug"].'.zip'));
            echo file_get_contents(FCPATH .$theme["slug"].".zip");
        }
        unlink($theme["slug"].".zip");
        return true;
    }
    public function clone ($slug){
        $this->check_login();
        if($this->_data['user']["expired"] == 1){
            redirect(base_url('packages?alert=1'));
        }
        $record = $this->Common_model->get_record($this->_fix."themes",["slug" => $slug]);
        if($record == null){
            redirect(backend_url('/themes'));
        } 
        $id = $record["id"];

        $data = [
            'status' => 'error',
            'message' => null,
            'response' => null ,
            'record' => null,
            'post' => $this->input->post() 
        ];
        $allow_width = 1920;
        $lblocks = $lsections = $metas = $styles = $style= $theme = $lparts = null;
        $section_setting_insert = $block_setting_inserts = $sbods = $style_meta_inserts = $old_ord_inserts =  $inserts = [];
        if(true){
            $this->load->model($this->_model);
            $this->load->model('Sections_model');
            $this->load->model('Blocks_model');
            $is_create = 1;
            $theme_id = 0;
            if($is_create == 1){
                $clone_theme = $this->Common_model->get_record(
                    $this->_fix.'themes',
                    ['id' => $id]
                );
                $clone_theme['clone_id']  = $clone_theme['id'];
                $clone_theme['is_system'] = 0;
                $clone_theme['public']    = 0;
                $clone_theme['status']    = 0;
                $clone_theme['member_id'] = $this->_user_id;
                $clone_theme['slug']      = uniqid();
                unset($clone_theme['id']);
                $theme_id  = $this->Common_model->add($this->_fix.'themes',$clone_theme);
                $allScreen = $this->Common_model->get_result($this->_fix."allow_screen",["theme_id" => $id]);
                if($allScreen){
                    foreach ($allScreen as $key => $value) {
                       $value["theme_id"] = $theme_id;
                       unset($value['id']);
                       $this->Common_model->add($this->_fix."allow_screen",$value);
                    }
                }else{
                    $this->Common_model->add($this->_fix."allow_screen",[
                        "theme_id" => $theme_id,
                        "width"    => 1920
                    ]);
                }               
            }
            $theme = $this->Common_model->get_record($this->_fix.'themes',['id' => $is_create == 1 ? $theme_id : $id ]);
            if($theme == null){
                redirect(backend_url('theme'));
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
                        'theme_section_id' => $theme_section_id
                    ],
                    null, null, [['field' => 'sort','sort' => 'ASC']]
                ); 
                $styles = $this->Common_model->get_result($this->_fix.'style_meta',['reference_id' => $theme_section_id,'support_key' => 'section']);
                $old_id = $value['theme_section_id'];
                //clone order theme section;
                $value['theme_section_id']  = $this->Common_model->add($this->_fix.'section',[
                    'theme_id'    => $theme_id,
                    'section_id'  => $value['id'],
                    'is_default'  => 0,
                    'clone_id'    => $old_id,
                ]);
                
                $old_ord = $this->Common_model->get_recode_for_select($this->_fix.'section_order','layout_show_block,name,class_name,is_full,show_title,ncolum_block,ncolum_show_block,default_block',['theme_section_id' => $old_id]);
                $old_ord['name'] = $value['name'];
                $old_ord['theme_section_id'] = $value['theme_section_id'];
                $old_ord['sort'] = $key_s;
                $old_ord_inserts[] = $old_ord;
                if($styles){
                    foreach ($styles as $key_st => $value_st) {
                        $value_st['reference_id'] = $value['theme_section_id'];
                        $style_meta_inserts[] = $value_st;
                    } 
                }   
                //clone blocks default;
                $lblocks = $this->{$this->_model}->get_blocks($value['id'],$theme_section_id,$value['default_block'],$value['ncolum_show_block'],0);     
                $allScreenSecsion = $this->Common_model->get_result($this->_fix."section_order_setting",[
                    "theme_section_id" => $theme_section_id 
                ]);
                if($allScreenSecsion){
                    foreach ($allScreenSecsion as $key_allScreenSecsion => $value_allScreenSecsion) {
                       $value_allScreenSecsion["theme_section_id"] = $value['theme_section_id'];
                       $section_setting_insert [] = $value_allScreenSecsion;
                    }
                }
                $section_block_order_settings = $this->Common_model->get_result($this->_fix."section_block_order_setting",[
                    "theme_section_id" => $theme_section_id
                ]);
                if($section_block_order_settings){
                    foreach ($section_block_order_settings as $key_section_block_order_settings => $value_section_block_order_settings) {
                        $value_section_block_order_settings["theme_section_id"] = $value["theme_section_id"];
                        $block_setting_inserts [] = $value_section_block_order_settings;
                    }
                }
                foreach ($lblocks as $key_b => $value_b) {
                    //get order section block;
                    $sort_block = 0;
                    $section_block_id = $value_b['section_block_id'];
                    $is_default = 0;
                    $sbod = $this->Common_model->get_recode_for_select($this->_fix.'section_block_order','section_block_id,ncolum,class_name,is_form',['section_block_id' => $section_block_id ,'is_default' => $is_default,'theme_section_id' => $theme_section_id]);
                    if($sbod){
                        $sbod['theme_section_id'] = $value['theme_section_id'];
                        $sbod['is_default']       = 0;
                        $sbod['sort']             = $key_b;
                        if($is_create == 1){
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
                                'class_name'       => $value_p['class_name'],
                            ];     
                            //clone meta part
                            foreach ($metas as $key_m => $value_m) {
                                if($value_m['block_part_id'] == $value_p['block_part_id'] && $value_m['section_block_id'] == $section_block_id){
                                    $this->Common_model->add($this->_fix.'block_part_meta', [
                                        'block_part_id'    => $value_p['block_part_id'],
                                        'section_block_id' => $section_block_id,
                                        'theme_section_id' => $value['theme_section_id'],
                                        'meta_key'         => $value_m['meta_key'],
                                        'value'            => $value_m['value'],
                                        'media_id'         => $value_m['media_id'],
                                    ]);
                                }   
                            }                                                               
                        }
                        //!clone part block;       
                    }
                    $sort_block++;
                } 
                //!clone blocks default;
                //!clone section;
            }
            //unset($value);
            if($sbods)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order',$sbods);
            if($block_setting_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_order_setting',$block_setting_inserts);
            if($style_meta_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'style_meta',$style_meta_inserts); 
            if($old_ord_inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_order',$old_ord_inserts);
            if($section_setting_insert)
                $this->Common_model->insert_batch_data($this->_fix.'section_order_setting',$section_setting_insert);
            if($inserts)
                $this->Common_model->insert_batch_data($this->_fix.'section_block_part_order',$inserts);           
            redirect(base_url('/appthemes/edit/'.$clone_theme['slug']));
        }
        return true; 
    }
}
