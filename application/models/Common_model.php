<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add($table, $data) {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function delete($table, $where) {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($table, $where);
        $this->db->trans_complete();
        return $return;
    }

    function get_raw($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function update($table, $data, $where) {
        $return = false;
        $this->db->trans_start();
        $this->db->where($where);
        $return = $this->db->update($table, $data);
        $this->db->trans_complete();
        return $return;
    }

    function query_raw($sql) {
        return $this->db->query($sql)->result_array();
    }

    function query_raw_row($sql) {
        return $this->db->query($sql)->row_array();
    }

    function query_string($sql) {
        return $this->db->query($sql);
    }

    function get_record($table, $where = "", $order = null) {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($order != null && is_array($order) && !isset($order["field"])) {
            foreach ($order as $item) {
                if (isset($item["field"])) {
                    $this->db->order_by($item["field"], $item["sort"]);
                }
            }
        }
        return $this->db->get()->row_array();
    }


    function get_like($table, $key, $string, $order = null) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->like($key,$string);
        if ($order != null && is_array($order) && !isset($order["field"])) {
            foreach ($order as $item) {
                if (isset($item["field"])) {
                    $this->db->order_by($item["field"], $item["sort"]);
                }
            }
        }
        return $this->db->get()->result_array();
    }


    function get_result($table, $where = null, $offset = null, $limit = null, $order = null,$is_order = false) {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != null) {
            $this->db->where($where);
        }

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

    function get_result_distinct($member_id, $type, $data,$columdate = "createdat_profile") {
        $this->db->distinct();
        $this->db->from("common_view AS cv");
        if($type != "profile"){
            if($type == "blog"){
                $this->db->join("article AS a","a.id = cv.reference_id");
            }
            if($type == "photo"){
                $this->db->join("photos AS a","a.photo_id = cv.reference_id");
            }
        }
        
        $this->db->where(array("cv.member_owner" => $member_id, "cv.type_object" => $type, "cv.".$columdate." >=" => $data, "cv.member_id !=" => $member_id,"cv.member_id !="=> 0 ,"cv.type_share_view" => "view"));
       // $this->db->group_by(array("member_id", "ip"));
        return $this->db->get()->num_rows();
    }



    function get_result_in($table, $column, $in = array(),$where = null) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in($column, $in);
        if($where != null){
            $this->db->where($where);
        }
        return $this->db->get()->result_array();
    }



    function insert_batch_data($table, $data) {
        $this->db->trans_start();
        $this->db->insert_batch($table, $data);
        $insert_id[] = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }



    function count_table($table, $filter = array()) {
        $this->db->select('*');
        $this->db->from($table);
        if (count($filter)) {
            $this->db->where($filter);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_sort($group_id, $pid) {
        $filter = array("group_id" => $group_id, "pid" => $pid);
        $this->db->select('sort_id');
        $this->db->from("menu");
        $this->db->where($filter);
        $this->db->order_by("sort_id", "DESC");
        return $this->db->get()->row_array();
    }



    function get_search_category() {
        $all_category = $this->get_result("categories", array(
            "type" => "system"
        ));
        return $this->recursive_category($all_category, 0);
    }



    function slug($table, $colum, $like) {
        $this->db->select($colum);
        $this->db->from($table);
        $this->db->like($colum, $like);
        return $this->db->get()->result_array();
    }



    public function get_web_setting($key_identify='',$fields='c.*') {
        $sql = "SELECT {$fields} FROM `ewd_web_setting` as p INNER JOIN web_setting c ON c.group_id = p.id AND p.group_id = 0 AND p.selected_item = c.id";
        if (!empty($key_identify)) {
            $sql .= " WHERE p.key_identify = '$key_identify'";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }



    public function get_use_rol($table_modules,$table_rules,$rol_id){
        $this->db->select("r.*,sm.Icon,sm.ID,sm.Module_Name,sm.Module_Url,sm.Module_Class,sm.Module_Key,sm.Parent_ID");
        $this->db->from("{$table_modules} AS sm");
        $this->db->join("{$table_rules} AS r","r.Module_ID = sm.ID AND r.Role_ID = ".$rol_id."","LEFT");
        if($rol_id != 1){
            $this->db->where("r.View","1");
        }
        $this->db->order_by("sm.Order","ASC");
        $query = $this->db->get();
        return $query->result_array();
    }


    
    public function get_recode_for_select($table,$select = null, $where = null, $offset = null, $limit = null, $order = null,$is_order = false) {
        $this->db->select($select == null ? '*' : $select);
        $this->db->from($table);
        if ($where != null) {
            $this->db->where($where);
        }
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
        return $this->db->get()->row_array();
    }



    public function get_result_for_select($table,$select = null, $where = null, $offset = null, $limit = null, $order = null,$is_order = false) {
        $this->db->select($select == null ? '*' : $select);
        $this->db->from($table);
        if ($where != null) {
            $this->db->where($where);
        }
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


    
    public function get_langs(){
        $this->db->select("tbl1.*,tbl2.path as path_icon");
        $this->db->from("languages as tbl1");
        $this->db->join("theme_medias as tbl2" ,"tbl2.id = tbl1.icon");
        return $this->db->get()->result_array();
    }
}
