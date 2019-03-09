<?php
class Menu extends MY_Controller
{
    private $folder_view = "menu"; 
    private $base_controller;
    private $table = '';
    private $table_group = '';
    private $table_post = '';
    private $table_page = '';
    private $table_category = '';

    function __construct(){
        parent::__construct();
        $this->load->model('Menu_model');
        $this->table = $this->table_prefix.'menu';
        $this->table_group = $this->table_prefix.'menu_group';
        $this->table_post = $this->table_prefix.'post';
        $this->table_page = $this->table_prefix.'page';
        $this->table_category = $this->table_prefix.'categories';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }

    public function index($group_id = null) {
        if(isset($group_id) && $group_id != null){
        	$record = $this->Common_model->get_record($this->table_group,array('Group_ID' => $group_id));
        	if( !(isset($record) && $record!=null) ){
        		redirect('backend/menu');
        	}
        	$this->data['menu'] = $record;
        }

        if($this->input->post()){
        	$this->form_validation->set_rules('name','Tiêu đề','trim|required');
            if($this->form_validation->run() != FALSE) {
        		$data = array(
                   'Name' => $this->input->post('name')
                );
                if(isset($group_id) && $group_id != null && is_numeric($group_id) && $group_id > 0){
                	$check = $this->Common_model->update($this->table_group, $data,array('Group_ID' => $group_id));
                    $this->message($this->message_update_succes,'success');
                }
                else{
                    $data['Create_at'] = date('Y-m-d H:i:s');
                	$insert_id = $this->Common_model->add($this->table_group, $data);
                	$this->message($this->message_add_succes,'success');
                }
        	}
        	else{
        		$this->message('Vui lòng nhập tiêu đề menu.');
        	}
            redirect('backend/menu');
        }

        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["Name Like"] = "%".$this->input->get("keyword")."%";
        } 

        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $this->data['title'] = $this->data['label'] = 'Menu';
        $this->data['link'] = base_url('/backend/'.$this->folder_view);
        $per_page = $this->per_page;
        $count_table = $this->Common_model->count_table($this->table_group,$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $config['base_url'] = base_url('/backend/menu/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config)); 
        $this->data['menus'] = $this->Common_model->get_result($this->table_group,$where,$offset,$per_page);    
        $this->load->view('backend/menu/group', $this->data);
    }

    public function delete($group_id = null){
    	$record = $this->Common_model->get_record($this->table_group,array('Group_ID' => $group_id));
    	if( !(isset($record) && $record!=null) ){
    		$this->message('Menu này không tồn tại.');
    		redirect('backend/menu');
    	}
    	
    	$check = $this->Common_model->delete($this->table_group,array('Group_ID' => $group_id));
    	if($check) {
            $this->Common_model->delete($this->table,array('Group_ID' => $group_id));
            $this->message($this->message_delete_succes,'success');
    	}
        redirect('backend/menu');
    }

    public function group_menu($group_id = null) {
        $record = $this->Common_model->get_record($this->table_group,array('Group_ID' => $group_id));
    	if( !(isset($record) && $record!=null) ){
    		$this->message('Menu này không tồn tại.');
            redirect('/backend/menu');
    	}
    	$where = '';
    	$offset = 0;
    	$per_page = $this->per_page;
        $this->data['title'] = $this->data['label'] = 'Menu';
        $this->data['id'] = $group_id;
        $this->data['current'] = "menu";
        $list_menu = $this->Menu_model->get_list_menu_group($this->table,$group_id);
        $this->data['menu'] = $this->Menu_model->build_menu_admin(0, $list_menu, "easymm");
        $this->data['record'] = $record;
        $this->data['page'] = $this->Common_model->get_result($this->table_page,$where,$offset,$per_page,array('ID' => 'DESC'));
        $this->data['post'] = $this->Common_model->get_result($this->table_post,$where,$offset,$per_page,array('ID' => 'DESC'));
        $this->data['category'] = $this->Common_model->get_result($this->table_category,$where,$offset,$per_page,array('ID' => 'DESC'));
        $this->load->view('backend/menu/menu', $this->data);
    }

    private $data_menu = array();
    public function update_menu() {
        if ($this->input->post('easymm') != null) {
            $this->data_menu = $this->input->post('easymm');
            $this->_position($this->input->post('easymm'), 0);
            die('true');
        }
        die('false');
    }

    public function delete_menu_item($id = null) {
        if (isset($id) && $id != null) {
            $record = $this->Common_model->get_record($this->table,array('ID' => $id));
            if( !(isset($record) && $record != null) ){
                die('false');
            }
            $path = $record['Path'];
            $this->Common_model->delete($this->table,"Path LIKE '%".$path."%' AND  Group_ID ='".$record['Group_ID']."'");
            die('true');
        }
        die('false');
    }

    public function update_item_menu($id = null) {
        if (isset($id) && $id != null) {
        	$result = $this->Common_model->get_record($this->table,array('ID' => $id));
            if($this->input->post() && @$result != null){
        		$this->form_validation->set_rules('title','Tên menu','trim|required');
        		if($this->form_validation->run() !== FALSE) {
        			$this->load->library('Helperclass');
                    $slug = $this->helperclass->slug($this->table, "Slug", $this->input->post('title'));
                    $data = array(
		                'Name' => $this->input->post('title'),
		                'Slug' => $slug,
		                'Url' => $this->input->post('url'),
		                'Class' => $this->input->post('class'),
		                'Type' => $this->input->post('type')
		            );
		            if($this->Common_model->update($this->table,$data,array('ID' => $id))){
                        $slug_last = $result['Slug'];
                        $sql = "UPDATE $this->table
                                SET Path = REPLACE(Path, '/$slug_last/', '/$slug/')
                                WHERE Path LIKE '%/$slug_last/%'";
                        $this->Common_model->query_string($sql);
                        die('true');
                    }
        			
        		}
        	}
        }
        die('false');
    }

    public function add_item_menu() {
        if($this->input->post()){
    		$this->form_validation->set_rules('title','Tên menu','trim|required');
    		if($this->form_validation->run() !== FALSE) {
    			$this->load->library('Helperclass');
                $slug = $this->helperclass->slug($this->table, "Slug", $this->input->post('title'));
                $data = array(
		            'Name' => $this->input->post('title'),
		            'Slug' => $slug ,
                    'Path' => '/'.$slug.'/',
		            'Url'  => $this->input->post('url'),
		            'Class' => $this->input->post('class'),
		            'Type' => $this->input->post('type'),
		            'Group_ID' => $this->input->post('group_id'),
		            'Order' => 1000
		        );
		        $id = $this->Common_model->add($this->table,$data);
		        if (isset($id) && $id != null && $id > 0) {
		            die("" . $id);
		        }
    		}
    	}
        die('0');
    }

    public function get_item_menu($id = null){
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Common_model->get_record($this->table,array('ID' => $id));
        }
        die(json_encode($result));
    }

    public function add_list_item_menu() {
    	$data = array('status' => 'error');
    	if($this->input->post()){
    		$this->form_validation->set_rules('group_id','Group menu','trim|required');
    		if($this->form_validation->run() !== FALSE) {
	    		$this->load->library('Helperclass');
	    		$list_item = $this->input->post('item');
	    		$responsive = array();
	    		if(isset($list_item) && $list_item!=null ){
	    			foreach ($list_item as $key => $item) {
	    				$explode = explode('|||', $item);
	    				if(isset($explode) && $explode!=null && count($explode) == 2){
	    					$title = @$explode[1];
	    					$url = @$explode[0];
		    				$slug = $this->helperclass->slug($this->table, "Slug", $title );
				            $data = array(
					            'Name' => $title,
					            'Slug' => $slug ,
				                'Path' => '/'.$slug.'/',
					            'Url'  => $url,
					            'Class' => '',
					            'Group_ID' => $this->input->post('group_id'),
					            'Order' => 1000
					        );
					        $id = $this->Common_model->add($this->table,$data);
					        if (isset($id) && $id != null && $id > 0) {
					            $responsive[] = array(
					            	'menu_id' => $id,
					            	'title'   => $title,
					            	'url'	  => $url
					            );
					        }
	    				}
	    			}
	    			$data['status'] = 'success';
	    			$data['responsive'] = $responsive;
	    		}
	    	}
    	}
    	die(json_encode($data));
    }

    public function search_item(){
    	$data = array('status' => 'error');
    	if($this->input->post()){
    		$type = $this->input->post('type');
    		$data['status'] = 'success';
    		$responsive = '';
    		$offset = 0;
    		$per_page = 30;
    		if($type == 'page'){
    			$where = "Title LIKE '%".$this->input->post('keyword')."%' ";
                $page = $this->Common_model->get_result($this->table_page,$where,$offset,$per_page,array('ID' => 'DESC'));
    			$responsive = '<ul>';
    			$data['sql'] = $this->db->last_query();
    			if(isset($page) && $page):
                    foreach ($page as $key => $item):
                        $responsive .= '
                   			<li>
	                            <input type="checkbox" id="checkbox-page-'.$item['ID'].'" name="item[]" value="/trang/'. $item['Key_Identify'].'/|||'. $item['Title'].'">
	                            <label for="checkbox-page-'.$item['ID'].'">'.$item['Title'].'</label>
	                        </li>';
                    endforeach;
                endif;
                $responsive .= '</ul>';
    		}
    		else if($type == 'post'){
    			$where = "Name LIKE '%".$this->input->post('keyword')."%' ";
                $post = $this->Common_model->get_result($this->table_post,$where,$offset,$per_page,array('ID' => 'DESC'));
    			$responsive = '<ul>';
    			if(isset($post) && $post):
                    foreach ($post as $key => $item):
                        $responsive .= '
                   			<li>
	                            <input type="checkbox" id="checkbox-post-'.$item['ID'].'" name="item[]" value="/bai-viet/'. $item['Slug'].'/|||'. $item['Name'].'">
	                            <label for="checkbox-post-'.$item['ID'].'">'.$item['Name'].'</label>
	                        </li>';
                    endforeach;
                endif;
                $responsive .= '</ul>';
    		}
    		else if($type == 'category'){
    			$where = "Name LIKE '%".$this->input->post('keyword')."%' ";                
                $category = $this->Common_model->get_result($this->table_category,$where,$offset,$per_page,array('ID' => 'DESC'));
                $responsive = '<ul>';
                if(isset($category) && $category):
                    foreach ($category as $key => $item):
                        $responsive .= '
                            <li>
                                <input type="checkbox" id="checkbox-category-'.$item['ID'].'" name="item[]" value="/chuyen-muc/'. $item['Slug'].'/|||'. $item['Name'].'">
                                <label for="checkbox-category-'.$item['ID'].'">'.$item['Name'].'</label>
                            </li>';
                    endforeach;
                endif;
                $responsive .= '</ul>';
    		}
    		else{
    			$data['status'] = 'error';
    		}

    		if($data['status'] != 'error'){
				$data['responsive'] = $responsive;
    		}
    	}
    	die(json_encode($data));
    }

    private function _position($data, $parent) {
        foreach ($data as $item => $value) {
            $parents_id = $this->get_parents_key($this->data_menu, $value['id']);
            if (!is_numeric($parents_id)) {
                $parents_id = 0;
            }
            $menu_parent = $this->Common_model->get_record($this->table,array("ID" => $parent));
            $menu_current = $this->Common_model->get_record($this->table,array("ID" => $value['id']));
            // update position menu item
            $this->Common_model->update($this->table,array(
                "Parent_ID" => $parent,
                "Order" => $item,
                "Path" => (@$menu_parent['Path'] != null ? @$menu_parent['Path']  : '/').$menu_current['Slug']."/",
            ),array('ID' => $value['id']));
            if (isset($value['children']) && $value['children'] != null) {
                $this->_position($value['children'], $value['id']);
            }
        }
    }

    private function get_parents_key($array, $current_id) {
        if (isset($array) && count($array) > 0) {
            for ($i = 0; $i < count($array); $i++) {
                if ($array[$i]['id'] == $current_id) {
                    return true;
                }
                if (isset($array[$i]['children']) && $this->get_parents_key($array[$i]['children'], $current_id)) {
                    return $array[$i]['id'];
                }
            }
        } else {
            return false;
        }
    }

    private function _create_slug($string){
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }
} //end controller
