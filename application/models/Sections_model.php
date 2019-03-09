<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sections_model extends CI_Model {
	public $_fix   = "theme_";
	public $_table = "actions";
    function __construct() {
        parent::__construct();
    }
    function get_action_like($string,$theme_section_id,$active = null) {
        $this->db->select('tbl1.*,tbl2.active');
        $this->db->from($this->_fix."actions AS tbl1");
        $this->db->join($this->_fix."section_action AS tbl2","tbl1.id = tbl2.action_id  AND tbl2.theme_section_id = ".$theme_section_id."","LEFT");
        if($active != null){
            $this->db->where("tbl2.active",$active);
        }
        $this->db->like("support_key",$string);
        return $this->db->get()->result_array();
    }
    function get_blocks ($section_id = -1, $theme_section_id = 0){
        $this->db->select("tbl1.*,tbl3.*");
        $this->db->from($this->_fix."blocks AS tbl1");
        $this->db->join($this->_fix."section_block AS tbl2","tbl1.id = tbl2.block_id");
        $this->db->join($this->_fix."section_block_order AS tbl3","tbl2.id = tbl3.section_block_id");
        $this->db->where(["tbl2.section_id" => $section_id,"tbl3.theme_section_id" => $theme_section_id,"tbl1.status" => 1]);
        $this->db->order_by("tbl3.sort","ASC");
        return $this->db->get()->result_array();
    }

    function get_style ($string,$theme_section_id){
        $this->db->select('tbl1.*,tbl2.active');
        $this->db->from($this->_fix."styles AS tbl1");
        $this->db->join($this->_fix."section_style AS tbl2",
            "tbl1.id = tbl2.style_id 
            AND tbl2.theme_section_id = ".$theme_section_id."",
            "LEFT"
        );
        $this->db->like("support_key",$string);
        return $this->db->get()->result_array();
    }
}