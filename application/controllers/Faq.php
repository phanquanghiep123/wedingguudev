<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Faq extends Frontend_Controller {
    private $table = '';
    private $table_category = '';
    private $table_category_blog = '';
	public function __construct()
    {
        parent::__construct();
        $this->table = $this->table_prefix."help";
        $this->table_category = $this->table_prefix."help_category";
        $this->table_category_blog = $this->table_prefix."categories";
    }

	public function index() 
	{
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $per_page = 10;
        $where = "";
        if($this->input->get("keyword")){
            $where = " AND p.title Like %".$this->input->get("keyword")."%" ;
        }
        $sql = "SELECT p.*
                FROM {$this->table_category} AS c 
                INNER JOIN {$this->table} AS p ON p.category_id=c.id
                WHERE c.Name='".CATEGORY_FAQ."' AND c.Status='1' AND p.status='1' $where
                LIMIT $offset,$per_page";

        $sql_count = " SELECT count(c.id) AS count
                FROM (
                    SELECT p.id
                    FROM {$this->table_category} AS c 
                    INNER JOIN {$this->table} AS p ON p.category_id=c.id
                    WHERE c.Name='".CATEGORY_FAQ."' AND c.Status='1' AND p.status='1' $where
                ) AS c";
        
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        
        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('faq/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["data"] = $this->Common_model->query_raw($sql);
		$this->data['title'] = 'Hỏi đáp';
		$this->data["category"] = $this->Common_model->get_result($this->table_category_blog,array('Status' => 1));
		$this->load->view($this->asset.'/faq/index',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}
}
