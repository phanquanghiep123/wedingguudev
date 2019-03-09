<?php  

defined('BASEPATH') OR exit('No direct script access allowed');

class package extends MY_Controller {
    private $folder_view = "package"; 
    private $base_controller;
    private $table = '';
    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'package';
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $where["1"] = "1";
        if($this->input->get("keyword") != null){
            $where["name Like"] = "%".$this->input->get("keyword")."%";
        }	
        if($this->input->get("status") != null){
            $where["status"] = $this->input->get("status");
        }
        $request = "?1=1";
        if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        $per_page = $this->per_page;
        $count_table = $this->Common_model->count_table($this->table,$where);
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = $count_table;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["package"] = $this->Common_model->get_result($this->table,$where,$offset,$per_page);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('price', 'Giá', 'required');
            $this->form_validation->set_rules('months', 'Số tháng', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $id = $this->Common_model->add($this->table,$data_insert);  
                if($this->input->post("options")){
                    $options = $this->input->post("options");
                    $index = 0;
                    foreach ($options as $key => $value) {
                        $this->Common_model->add("package_selects",
                            ["package_id" => $id ,"option_id" => $key,"sort" => $index]
                        );
                        $index++;
                    }
                }
                $this->message($this->message_add_succes,'success');
                redirect(backend_url($this->base_controller.'/edit/'.$id));
            }else{
                $this->session->set_flashdata('record',$this->input->post());
                $this->message(validation_errors());
                redirect(backend_url($this->base_controller.'/create/'));
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    
    public function edit($id = null){
    	if($id == null){
    		redirect(backend_url($this->base_controller));
        }
    	$record = $this->Common_model->get_record($this->table,array("ID" => $id));
    	if($record == null){
    		redirect(backend_url($this->base_controller));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('name', 'Tiêu đề', 'required');
            $this->form_validation->set_rules('price', 'Giá', 'required');
            $this->form_validation->set_rules('months', 'Số tháng', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                if($this->input->post("options")){
                    $options = $this->input->post("options");
                    $index = 0;
                    $not_idS = [];
                    foreach ($options as $key => $value) {
                        $ck = $this->Common_model->get_record("package_selects",["package_id" => $id ,"option_id" => $key]);
                        if($ck){
                            $this->Common_model->update("package_selects",["sort" => $index],["id" => $ck["id"] ]);
                        }else{
                            $ck["id"] = $this->Common_model->add("package_selects",
                                ["package_id" => $id ,"option_id" => $key,"sort" => $index]
                            );
                        }
                        $not_idS[] = $ck["id"];
                        $index++;
                    }
                    $this->db->where_not_in("id",$not_idS);
                    $this->db->delete("package_selects",["package_id" => $id]);
                }
                $this->Common_model->update($this->table,$data_update,array("id" =>$record["id"]));  
                $this->message($this->message_update_succes,'success');
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/edit/'.$id));
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '300px');
    	$this->data['record'] = $record;
        $sql = "select tbl1.*, tbl2.id as is_connect from {$this->table_prefix}package_options as tbl1 left join {$this->table_prefix}package_selects as tbl2 on tbl2.option_id = tbl1.id and package_id = {$id} order by tbl1.id ASC , tbl2.sort ASC";
    	$this->data["options"] = $this->Common_model->query_raw($sql);
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    public function delete($id = null){
        $this->Common_model->delete($this->table,array("id" => $id));
        $this->message($this->message_delete_succes,'success');
        redirect(backend_url($this->base_controller));
    }
}
