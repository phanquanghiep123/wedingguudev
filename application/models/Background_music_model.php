<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Background_music_model extends CI_Model {
	public $_fix   = "theme_";
    public $_table = "background_music";
    function __construct() {
        parent::__construct();
    }
    public function get($where = null, $offset = null, $limit = null, $order = null,$is_order = false)
    {
    	$this->db->select('tbl1.*,tbl2.name AS group_name');
        $this->db->from($this->_fix.$this->_table ." AS tbl1");
        $this->db->join($this->_fix."groups_background_music AS tbl2","tbl2.id = tbl1.group_id");
        if ($where != null) {
            $this->db->where($where);
        }
        $this->db->where(["tbl2.status" => 1]);
        if ($limit != null) { 
            $this->db->limit($limit, $offset);
        }
        if ($order != null) {
            foreach ($order as $key => $item) {
                if (isset($item["field"])) {
                    $this->db->order_by($item["field"], $item["sort"]);
                }
            }
        }
        if($is_order){
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        return $this->db->get()->result_array();
    }
    
}