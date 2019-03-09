<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sys_rules_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_data_role($id,$talbe_rules,$table_modules){
    	$this->db->select("tbl1.*,tbl2.Allow,tbl2.Add,tbl2.Edit,tbl2.Delete,tbl2.View");
    	$this->db->from("$table_modules AS tbl1");
    	$this->db->join("$talbe_rules AS tbl2","tbl2.Module_ID = tbl1.ID AND tbl2.Role_ID = ".$id."","LEFT");
        $query = $this->db->get();
        return $query->result_array();
    }

}
