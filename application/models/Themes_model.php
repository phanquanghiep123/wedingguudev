<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Themes_model extends CI_Model {
    public $_fix   = "theme_";
    public $_table = "themes";
    function __construct() {
        parent::__construct();
    }
    public function get($offset = 0, $limit = 30,$where = null){
        $this->db->from($this->_fix.$this->_table);
        $this->db->select($this->_fix.$this->_table.".*,".$this->_fix."medias.thumb AS thumbpath");
        $this->db->join($this->_fix."medias","".$this->_fix."medias.id = ".$this->_fix.$this->_table.".thumb","left");
        if($where != null){
            $this->db->where($where);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by($this->_fix.$this->_table.".id","DESC");
        return $this->db->get()->result_array();
    }
    public function getsys($offset = 0, $limit = 30,$where = null){
        $this->db->from($this->_fix.$this->_table);
        $this->db->select($this->_fix.$this->_table.".*,".$this->_fix."medias.thumb AS thumbpath");
        $this->db->join($this->_fix."medias","".$this->_fix."medias.id = ".$this->_fix.$this->_table.".thumb","left");
        if($where != null){
            $this->db->where($where);
        }
        $this->db->limit($limit,$offset);
        $this->db->order_by($this->_fix.$this->_table.".id","DESC");
        return $this->db->get()->result_array();
    }
    public function get_sections ($theme_id = 0){
        if($theme_id != 0 ){
            $this->db->select("tbl1.*,tbl3.*,tbl2.clone_id,tbl2.section_id");
        }else{
            $this->db->select("tbl3.*,tbl1.*,tbl2.clone_id,tbl2.section_id");
        }
        $this->db->from($this->_fix."sections AS tbl1");
        $this->db->join($this->_fix."section AS tbl2","tbl2.section_id = tbl1.id");
        $this->db->join($this->_fix."section_order AS tbl3","tbl2.id = tbl3.theme_section_id");
        $this->db->where([
            "tbl2.theme_id"    => $theme_id,
            "tbl1.status"      => 1,
        ]);
        if($theme_id == 0){
            $this->db->where([
                "tbl3.is_default" => 1
            ]);
        }
        $this->db->order_by("tbl3.sort","ASC");
        return $this->db->get()->result_array();
    }
    public function get_section ($id,$theme_id = 0){
        $this->db->select("tbl1.*,tbl3.*,tbl2.clone_id");
        $this->db->from($this->_fix."sections AS tbl1");
        $this->db->join($this->_fix."section AS tbl2","tbl2.section_id = tbl1.id");
        $this->db->join($this->_fix."section_order AS tbl3","tbl2.id = tbl3.theme_section_id");
        $this->db->where([
            "tbl1.id"       => $id,
            "tbl1.status"   => 1,
            "tbl2.theme_id" => $theme_id
        ]);
        return $this->db->get()->row_array();
    }
    public function get_blocks ($section_id,$theme_section_id,$not_block = 0,$offset = 0, $limit = -1,$theme_id = 0){
        $_nowblock = $this->get_all_block($section_id,$theme_section_id,$not_block);
        if($not_block != -1 && $not_block != 0){
            $get_defaul_block = $this->get_defaul_block($section_id,$theme_section_id,$not_block,$offset,$limit);        
            $_nowblock = array_merge ($_nowblock,$get_defaul_block);
        }
        usort($_nowblock,function($a, $b) {
            return $a['sort'] - $b['sort'];
        });
        return $_nowblock;
    }
    public function get_all_block ($section_id,$theme_section_id,$not_block = 0){
        $this->db->flush_cache();
        $this->db->select("tbl2.*,tbl3.*,tbl1.block_id,tbl1.section_id");
        $this->db->from($this->_fix."section_block AS tbl1");
        $this->db->join($this->_fix."blocks as tbl2","tbl2.id = tbl1.block_id");
        $this->db->join($this->_fix."section_block_order AS tbl3","tbl3.section_block_id = tbl1.id");
        $this->db->where([
            "tbl1.section_id"           => $section_id,
            "tbl3.theme_section_id"     => $theme_section_id,
            "tbl2.status"               => 1,
        ]);
        if($not_block != 0){
            $this->db->where("tbl2.id !=",$not_block);            
        }
        if($theme_section_id == 0){
            $this->db->where([
                "tbl3.is_default" => 1
            ]);
        }
        $this->db->order_by("tbl3.sort","ASC");
        $_nowblock = $this->db->get()->result_array();      
        return $_nowblock ;
    }

    private function get_defaul_block ($section_id,$theme_section_id,$block_id,$offset = 0, $limit = 0){
        $this->db->flush_cache();
        $this->db->select("tbl2.*,tbl3.*,tbl1.block_id,tbl1.section_id");
        $this->db->from($this->_fix."section_block AS tbl1");
        $this->db->join($this->_fix."blocks as tbl2","tbl2.id = tbl1.block_id");
        $this->db->join($this->_fix."section_block_order AS tbl3","tbl3.section_block_id = tbl1.id");
        $this->db->where([
            "tbl1.section_id"       => $section_id,
            "tbl3.theme_section_id" => $theme_section_id,
            "tbl2.status"           => 1,
            "tbl2.id"               => $block_id,
        ]);
        $this->db->order_by("tbl3.sort","ASC");
        $a =  $this->db->get()->result_array();
        return $a;
    }
    public function get_block ($section_block_id,$theme_section_id){
        $this->db->select("tbl2.*,tbl3.*");
        $this->db->from($this->_fix."section_block AS tbl1");
        $this->db->join($this->_fix."blocks as tbl2","tbl2.id = tbl1.block_id");
        $this->db->join($this->_fix."section_block_order AS tbl3","tbl3.section_block_id = tbl1.id");
        $this->db->where([
            "tbl3.section_block_id" => $section_block_id,
            "tbl3.theme_section_id" => $theme_section_id,
            "tbl2.status" => 1
        ]);
        return $this->db->get()->row_array();
    }
    
    function get_parts($block_id,$section_block_id,$theme_section_id) {
        $this->db->select("tbl2.*,tbl3.*,tbl1.part_id");
        $this->db->from($this->_fix."section_block_part AS tbl1");
        $this->db->join($this->_fix."parts as tbl2","tbl2.id = tbl1.part_id");
        $this->db->join($this->_fix."section_block_part_order AS tbl3","tbl3.block_part_id = tbl1.id");
        $this->db->where([
            "tbl1.block_id"         => $block_id ,
            "tbl3.section_block_id" => $section_block_id,
            "tbl3.theme_section_id" => $theme_section_id,
            "tbl2.status"           => 1,
        ]);
        $this->db->order_by("tbl3.sort","ASC");
        return $this->db->get()->result_array();
    }
    function get_metas ($block_part_id,$section_block_id,$theme_section_id,$allow_width = 1920){
        $this->db->select("tbl1.*,tbl2.id AS media_id,tbl2.path,tbl2.full,tbl2.large,tbl2.medium,tbl2.small,tbl2.thumb");
        $this->db->from($this->_fix."block_part_meta AS tbl1");
        $this->db->join($this->_fix."medias AS tbl2","tbl2.id = tbl1.media_id","LEFT");
        $this->db->where([
            "tbl1.block_part_id"      => $block_part_id,
            "tbl1.section_block_id"   => $section_block_id,
            "tbl1.theme_section_id"   => $theme_section_id,
            'tbl1.allow_width'        => $allow_width,
        ]);
        return $this->db->get()->result_array();
    }
    function get_backgrounds_by_group ($group_id){
        $this->db->select("tbl1.* ,tbl2.thumb,tbl2.path");
        $this->db->from($this->_fix."background_music AS tbl1");
        $this->db->join($this->_fix."medias as tbl2","tbl2.id = tbl1.media_id");
        $this->db->join($this->_fix."groups_background_music as tbl3","tbl3.id = tbl1.group_id");
        $this->db->where(["tbl1.group_id" => $group_id,"tbl3.status" => 1,"tbl1.status" => 1]);
        return $this->db->get()->result_array();
    }
    function get_default_part_block($block_id = 0,$section_block_id = 0 ,$theme_section_id = 0){
        $this->db->select("tbl2.*,tbl4.*,tbl3.value,tbl3.media_id");
        $this->db->from($this->_fix."section_block_part AS tbl1");
        $this->db->join($this->_fix."section_block_part_order AS tbl2",'tbl1.id = tbl2.block_part_id');
        $this->db->join($this->_fix."block_part_meta AS tbl3","tbl3.block_part_id = tbl1.id");
        $this->db->join($this->_fix."blocks AS tbl4","tbl4.id = tbl1.block_id");
        $this->db->where([
            "tbl1.is_default"       => 1,
            "tbl1.block_id"         => $block_id,
            "tbl2.section_block_id" => $section_block_id,
            "tbl2.theme_section_id" => $theme_section_id,
            "tbl3.section_block_id" => $section_block_id,
            "tbl3.theme_section_id" => $theme_section_id
        ]);
        return $this->db->get()->row_array();
    }
    function get_actions_part($block_part_id,$section_block_id = 0,$theme_section_id=0,$allow_width = 1920){
        $this->db->select('tbl1.*,tbl2.active');
        $this->db->from($this->_fix."actions AS tbl1");
        $this->db->join($this->_fix."part_action AS tbl2",
            "tbl1.id = tbl2.action_id 
            AND tbl2.block_part_id = ".$block_part_id." 
            AND tbl2.section_block_id = ".$section_block_id."
            AND tbl2.theme_section_id = ".$theme_section_id."",
            "LEFT"
        );
        $this->db->like("support_key","part");
        return $this->db->get()->result_array();
    }
    function get_first_block_by_section ($section_id,$block_id,$theme_section_id){
        $this->db->select('tbl1.*,tbl3.name');
        $this->db->from($this->_fix."section_block AS tbl1");
        $this->db->join($this->_fix."section_block_order AS tbl2","tbl2.section_block_id = tbl1.id");
        $this->db->join($this->_fix."blocks as tbl3","tbl3.id = tbl1.block_id");
        $this->db->where([
            "tbl1.section_id"       => $section_id,
            "tbl1.block_id"         => $block_id,
            "tbl2.theme_section_id" => $theme_section_id
        ]);
        $this->db->order_by("tbl1.id","ASC");
        return $this->db->get()->row_array();
    }
    public function get_default_section_block ($theme_section_id,$section_id,$block_id){
        $this->db->select("tbl1.*");
        $this->db->from($this->_fix."section_block AS tbl1");
        $this->db->join($this->_fix."section_block_order AS tbl2","tbl2.section_block_id = tbl1.id");
        $this->db->where(
            [
                "tbl2.theme_section_id" => $theme_section_id,
                "tbl1.block_id"    => $block_id
            ]
        );
        return $this->db->get()->row_array();
    }
    public function getmytheme($userID){
        $this->db->select("tbl1.* ,tbl3.id AS domains_id, tbl2.thumb AS hero_image");
        $this->db->from($this->table ." AS tbl1");
        $this->db->join($this->table_prefix."theme_medias AS tbl2","tbl2.id = tbl1.thumb","left");
        $this->db->join($this->table_prefix."theme_domains as tbl3","tbl3.theme_id = tbl1.id","left");
        $this->db->group_by(["tbl1.id","tbl1.clone_id"]);
        $this->db->where([
            "tbl1.status"    => 1,
            "tbl1.member_id" => $userID,
            "tbl1.is_delete" => 0
        ]);
        $this->db->order_by('tbl1.id', 'desc'); 
        $query = $this->db->get();
        return $query->result_array();

    }
    function effects (){
        $this->db->select('tbl1.*,tbl2.path,tbl2.full,tbl2.large,tbl2.medium,tbl2.small,tbl2.thumb,0 AS active');
        $this->db->from($this->_fix."background_music AS tbl1");
        $this->db->join($this->_fix."medias AS tbl2","tbl2.id = tbl1.media_id");
        $this->db->where(["tbl1.status" => 1,'tbl1.type' => 2]);
        return $this->db->get()->result_array();
    }
    function get_sortmax ($theme_id){
        $this->db->select('tbl2.sort');
        $this->db->from($this->_fix."section AS tbl1");
        $this->db->join($this->_fix."section_order AS tbl2","tbl2.theme_section_id = tbl1.id");
        $this->db->where(["tbl1.theme_id" => $theme_id]);
        $this->db->order_by("tbl2.sort","DESC");
        return $this->db->get()->row_array();
    }
}