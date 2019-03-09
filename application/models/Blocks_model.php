<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Blocks_model extends CI_Model {
	public $_fix   = "theme_";
    public $_table = "blocks";
    function __construct() {
        parent::__construct();
    }
    public function get_part_by_id($id,$section_id = -1,$theme_section_id = -1,$where = null)
    {
    	$this->db->select("tbl1.*,tbl4.class_name,tbl4.id_name,tbl4.ncolum,tbl2.id AS block_part_id");
    	$this->db->from($this->_fix."parts AS tbl1");
    	$this->db->join($this->_fix."section_block_part AS tbl2","tbl2.part_id = tbl1.id");
    	$this->db->join($this->_fix.$this->_table." AS tbl3","tbl3.id = tbl2.block_id");
    	$this->db->join($this->_fix."section_block_part_order AS tbl4","tbl4.block_part_id = tbl2.id");
        $w = [
            "tbl2.block_id"           => $id,
            "tbl4.section_block_id"   => $section_id,
            "tbl4.theme_section_id"   => $theme_section_id
        ];
        $this->db->where($w);
        if($where != null) $this->db->where($where);
        $this->db->order_by("tbl4.sort","ASC");
    	return $this->db->get()->result_array();
    }
    public function part_actions($block_part_id = -1,$section_id = -1,$theme_section_id = -1){
        $this->db->select("tbl1.*");
        $this->db->from($this->_fix."ewd_actions AS tbl1");
        $this->db->join($this->_fix."part_action AS tbl2", "tbl2.action_id = tbl1.id");
        $where = [
            "tbl2.block_part_id"    => $block_part_id,
            "tbl2.section_block_id" => $section_id,
            "tbl2.theme_section_id" => $theme_section_id
        ];
        $this->db->where($where);
        $this->db->order_by("tbl2.sort","ASC");
        return $this->db->get()->result_array();
    }
    public function get_actions ($id,$theme_section_id = 0,$active = null){
        $this->db->select("tbl1.*,tbl2.active");
        $this->db->from($this->_fix."actions AS tbl1");
        $this->db->join($this->_fix."block_action AS tbl2","tbl1.id = tbl2.action_id AND tbl2.section_block_id=".$id." AND tbl2.theme_section_id =".$theme_section_id."","LEFT");
        if($active != null){
            $this->db->where("tbl2.active",$active);
        }
        $this->db->like("tbl1.support_key","/block/");
        return $this->db->get()->result_array();
    } 
    public function get_block_add ($theme_section_id,$block_id){
        $this->db->from($this->_fix. "section_block_order as tbl1");
        $this->db->join($this->_fix. "section_block as tbl2","tbl1.section_block_id = tbl2.id");
        $this->db->where([
            'tbl1.theme_section_id' => $theme_section_id,
            'tbl2.block_id'         => $block_id
        ]);
        $this->db->order_by("tbl1.sort","ASC");
        return $this->db->get()->row_array();
    }
   
}