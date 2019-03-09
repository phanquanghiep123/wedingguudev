<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medias_model extends CI_Model {
	public $_fix   = "theme_";
	public $_table = "medias";
    function __construct() {
        parent::__construct();
    }
    function get($folder = 0,$member_id = null,$type_file = null,$ext_filter = null,$file_size = null,$keyword = -1 ,$order = -1){
    	$this->db->select("tbl1.*,tbl1.folder_id AS pId , tbl2.icon, tbl2.name AS type_name");
    	$this->db->from($this->_fix.$this->_table . " AS tbl1");
    	$this->db->join($this->_fix."media_type AS tbl2","tbl2.id = tbl1.type_id");
    	$this->db->where("tbl1.folder_id",$folder);
    	if($type_file != null){
            $this->db->where_in("tbl2.name",["folder",$type_file]);
        }
        if($ext_filter != null){
            $list   = explode(",", $ext_filter);
            $list[] = "folder";
            $this->db->where_in("tbl1.extension",$list);
        }
        if($file_size != null){
            $this->db->where("tbl1.size >=",$file_size);
        }
        if($member_id != null && $member_id != 0){
    		$this->db->where("tbl1.member_id",$member_id);
    	}
    	if($keyword != -1){
    		$this->db->like("tbl1.name",$keyword);
    	}
    	//$this->db->limit($limit,$offset);
    	if($order != -1){

    	}else{
    		$this->db->order_by("tbl1.id","DESC");
    	}
    	return $this->db->get()->result_array();
    }
    function get_by_ids($ids,$member_id = null,$type_file = null,$ext_filter = null,$file_size = null,$keyword = -1 ,$order = -1){
        $this->db->select("tbl1.*,tbl1.folder_id AS pId , tbl2.icon, tbl2.name AS type_name");
        $this->db->from($this->_fix.$this->_table . " AS tbl1");
        $this->db->join($this->_fix."media_type AS tbl2","tbl2.id = tbl1.type_id");
        if($type_file != null){
            $this->db->where_in("tbl2.name",[$type_file]);
        }
        if($ext_filter != null){
            $list   = explode(",", $ext_filter);
            $this->db->where_in("tbl1.extension",$list);
        }
        if($file_size != null){
            $this->db->where("tbl1.size >=",$file_size);
        }
        if($member_id != null && $member_id != 0){
            $this->db->where("tbl1.member_id",$member_id);
        }
        if($keyword != -1){
            $this->db->like("tbl1.name",$keyword);
        }
        $this->db->where_in("tbl1.id",$ids);
        return $this->db->get()->result_array();
    }
    function get_list_folder ($folder = 0,$member_id = null,$keyword = -1 ,$order = -1){
        $this->db->select("tbl1.id,tbl1.folder_id AS pId,tbl1.name,'true' AS isParent ,'".skin_url("themes/images/folder_open.png")."' AS iconOpen,'".skin_url("themes/images/folder_close.png")."' AS iconClose,'".skin_url("themes/images/folder_close.png")."' AS icon" );
        $this->db->from($this->_fix.$this->_table . " AS tbl1");
        if($member_id != null && $member_id != 0){
            $this->db->where("tbl1.member_id",$member_id);
        }
        $this->db->where("tbl1.folder_id =",$folder);
        $this->db->where("tbl1.type_id",2);
        if($order != -1){

        }else{
            $this->db->order_by("tbl1.id","DESC");
        }
        return $this->db->get()->result_array();
    }
    function get_in ($in = [] ,$order = -1){
        $this->db->select("tbl1.* , tbl2.icon, tbl2.name AS type_name");
        $this->db->from($this->_fix.$this->_table . " AS tbl1");
        $this->db->join($this->_fix."media_type AS tbl2","tbl2.id = tbl1.type_id");
        $this->db->where_in("tbl1.id",$in);
        if($order != -1){
        }else{
            $this->db->order_by("tbl1.id","DESC");
        }
        return $this->db->get()->result_array();
    }
}
