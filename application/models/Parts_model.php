<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Parts_model extends CI_Model {
	public $_fix   = "theme_";
	public $_table = "parts";
    function __construct() {
        parent::__construct();
    }
    public function get ($offset,$limit){
    	$this->db->from($this->_fix.$this->_table . " AS tbl1");
    	$this->db->select("tbl1.*");
    	$this->db->limit($limit,$offset);
    	return $this->db->get()->result_array();
    }

    function get_action_like($block_part_id,$section_block_id,$theme_section_id) {
        $this->db->select('tbl1.*,tbl2.active');
        $this->db->from($this->_fix."actions AS tbl1");
        $this->db->join($this->_fix."part_action AS tbl2","tbl1.id = tbl2.action_id AND tbl2.block_part_id = ".$block_part_id." AND tbl2.section_block_id = ".$section_block_id." AND tbl2.theme_section_id = ".$theme_section_id."", "LEFT");
        $this->db->like("tbl1.support_key","/part/");
        return $this->db->get()->result_array();
    }
}