<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Theme_model extends CI_Model {

	public $table = TABLE_FIX."member_theme";

    public function getmytheme($userID){

        $this->db->select("tbl1.*,tbl2.name AS parent_name,tbl2.hero_image AS parent_hero_image");

        $this->db->from($this->table ." AS tbl1");

        $this->db->join(TABLE_FIX."themes AS tbl2","tbl2.id = tbl1.theme_id");

        $this->db->where(["tbl1.member_id" => $userID,"tbl1.status" => 1]);
        
        $this->db->group_by("tbl2.id");

        $this->db->order_by("tbl2.id");

        $query = $this->db->get();

        return $query->result_array();

    }

}

