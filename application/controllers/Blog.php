<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Blog extends Frontend_Controller{
    private $table = '';
    private $table_category = '';
    private $table_post_category = '';
    private $table_advertisement = '';

	public function __construct(){
        parent::__construct();
        $this->table = $this->table_prefix."post";
        $this->table_category = $this->table_prefix."categories";
        $this->table_post_category = $this->table_prefix."post_category";
        $this->table_advertisement = $this->table_prefix."advertisement";
    }

	public function index(){
    	$where["Status"] = "1";
        if($this->input->get("keyword")){
            $where["Name Like"] = "%".$this->input->get("keyword")."%" ;
        }
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $count_table =  $this->Common_model->count_table($this->table,$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $per_page = 10;
        $config['base_url'] = base_url('/bai-viet/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["data"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page,array('ID' => 'DESC'),true);
        if(isset($this->data["data"]) && $this->data["data"] != null){
            foreach ($this->data["data"] as $key => $item) {
                $sql = "SELECT c.*
                        FROM {$this->table_category} AS c 
                        INNER JOIN {$this->table_post_category} AS pc ON pc.category_id = c.ID
                        WHERE pc.post_id = '{$item['ID']}' AND c.Status = '1' 
                        ";//GROUP BY c.ID 
                $this->data["data"][$key]['category'] = $this->Common_model->query_raw($sql);
            }
        }
        $this->data["category"] = $this->Common_model->get_result($this->table_category,array('Status' => 1));
        $this->data["last_post"] = $this->Common_model->get_result($this->table,array('Status' => 1),0,10,array('ID' => 'DESC'),true);
		$this->data['title'] = 'Bài viết';
        $this->load->view($this->asset.'/blog/index',$this->data);
	}

	public function category($slug = null){
		$category = $this->Common_model->get_record($this->table_category,array("Slug" => $slug,'Status' => 1));
    	if(!(isset($category) && $category != null)){
        	redirect('/bai-viet/');
        }

        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $per_page = 10;
        $where = "";
        if($this->input->get("keyword")){
            $where = " AND p.Name Like %".$this->input->get("keyword")."%" ;
        }
        $sql = "SELECT p.*
                FROM {$this->table_category} AS c 
                INNER JOIN {$this->table_post_category} AS pc ON pc.category_id = c.ID
                INNER JOIN {$this->table} AS p ON p.ID = pc.post_id
                WHERE c.ID = '{$category['ID']}' AND p.Status = '1' $where
                
                LIMIT $offset,$per_page";//GROUP BY p.ID

        $sql_count = " SELECT count(c.ID) AS count
                FROM (
                    SELECT p.ID
                    FROM {$this->table_category} AS c 
                    INNER JOIN {$this->table_post_category} AS pc ON pc.category_id = c.ID
                    INNER JOIN {$this->table} AS p ON p.ID = pc.post_id
                    WHERE c.ID = '{$category['ID']}' AND p.Status = '1' $where
                    
                ) AS c";//GROUP BY p.ID
        
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        
        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('chuyen-muc/'.$slug.'/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["data"] = $this->Common_model->query_raw($sql);
        if(isset($this->data["data"]) && $this->data["data"] != null){
            foreach ($this->data["data"] as $key => $item) {
                $sql = "SELECT c.*
                        FROM {$this->table_category} AS c 
                        INNER JOIN {$this->table_post_category} AS pc ON pc.category_id = c.ID
                        WHERE pc.post_id = '{$item['ID']}' AND c.Status = '1' 
                        ";//GROUP BY c.ID
                $this->data["data"][$key]['category'] = $this->Common_model->query_raw($sql);
            }
        }

        $this->data["category"] = $this->Common_model->get_result($this->table_category,array('Status' => 1));
        $this->data["last_post"] = $this->Common_model->get_result($this->table,array('Status' => 1),0,10,array('ID' => 'DESC'),true);
		$this->data['title'] = $category['Name'];
		$this->load->view($this->asset.'/blog/index',$this->data);
	}

    public function detail($slug = null){
    	$post = $this->Common_model->get_record($this->table,array("Slug" => $slug));
        if(!(isset($post) && $post != null)){
        	redirect('/bai-viet/');
        }
        $view = @$post['View'];
        $view += 1;

        $this->Common_model->update($this->table,array('View' => $view),array("Slug" => $slug));
        $sql = "SELECT c.*
                FROM {$this->table_category} AS c 
                INNER JOIN {$this->table_post_category} AS pc ON pc.category_id = c.ID
                WHERE pc.post_id = '{$post['ID']}' AND c.Status = '1' 
                ";//GROUP BY c.ID
        $this->data['post_category'] = $this->Common_model->query_raw($sql);

        $category_id = @$this->data['post_category'][0]['ID'];
        $sql = "SELECT p.*
                FROM {$this->table} AS p
                INNER JOIN {$this->table_post_category} AS pc ON p.ID = pc.post_id
                INNER JOIN {$this->table_category} AS c ON pc.category_id = c.ID
                WHERE c.ID != '{$post['ID']}' AND c.Status = '1'  AND pc.category_id = '{$category_id}'
                LIMIT 0,5";//GROUP BY c.ID
        $this->data['post_relationship'] = $this->Common_model->query_raw($sql);
        $this->data["category"] = $this->Common_model->get_result($this->table_category,array('Status' => 1));
        $this->data["last_post"] = $this->Common_model->get_result($this->table,array('Status' => 1,'ID !=' => $post['ID']),0,10,array('ID' => 'DESC'),true);
        $this->data["advertisement"] = $this->Common_model->get_record($this->table_advertisement,array("status" => 1),null,null,array('id' => 'RANDOM'));
        $this->data['title'] = $post['Name'];
        $this->data['post'] = $post;
        $this->load->view($this->asset.'/blog/detail',$this->data);
    }
}
