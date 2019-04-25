<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_history extends MY_Controller {
    private $folder_view = "payment_history"; 
    private $base_controller;
    private $table = '';
    private $table_member = '';
    private $table_package = '';

    public function __construct() {
        parent::__construct();
        $this->table = $this->table_prefix.'payment_history';
        $this->table_member = $this->table_prefix.'member';
        $this->table_package = $this->table_prefix.'package';
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
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $sql = "SELECT mp.*,p.label,m.first_name,m.last_name,mp.name as nameContact, mp.phone
                FROM {$this->table} AS mp 
                INNER JOIN {$this->table_member} AS m ON mp.member_id = m.id 
                INNER JOIN {$this->table_package} AS p ON mp.package_id = p.id 
                ORDER BY mp.id DESC
                LIMIT $offset,$per_page";

        $sql_count = "SELECT count(mp.id) AS count
                FROM {$this->table} AS mp 
                INNER JOIN {$this->table_member} AS m ON mp.member_id = m.id 
                INNER JOIN {$this->table_package} AS p ON mp.package_id = p.id ";
        $count = $this->Common_model->query_raw_row($sql_count);
        $config['base_url'] = base_url('/backend/'.$this->folder_view.'/'.$request);
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["package"] = $this->Common_model->query_raw($sql);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    
    public function view($id = null){
    	if($id == null){
    		redirect(backend_url($this->base_controller));
        }
    	$sql = "SELECT mp.*,p.label,m.first_name,m.last_name,mp.name as nameContact, mp.phone
                FROM {$this->table} AS mp 
                INNER JOIN {$this->table_member} AS m ON mp.member_id = m.id 
                INNER JOIN {$this->table_package} AS p ON mp.package_id = p.id 
                WHERE mp.id = '{$id}'";
        $record = $this->Common_model->query_raw_row($sql);
    	if(@$record == null){
            $this->message('Lịch sử thanh toán này không tồn tại.');
            redirect(backend_url($this->base_controller));
        }
        if ($this->input->post() && $record["status"] != 1) {
            $this->form_validation->set_rules('status', 'Trạng thái', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields($this->table);
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }
                $this->message($this->message_update_succes,'success');
                $this->Common_model->update($this->table,$data_update,array("id" =>$record["id"]));
                if($data_update["status"] == 1){
                    $pk = $this->Common_model->get_record("package",["id" => $record["package_id"]]);
                    $num_months = $pk["months"] .' '.$pk["type"] ;
                    if($pk){
                        $this->Common_model->add("member_package",[
                            "member_id"        => $record["member_id"],
                            "member_inver"     => $record["member_inver"],
                            "commission"       => $record["commission"],
                            "commission_money" => $record["commission_money"],
                            "package_id"       => $record["package_id"],
                            'created_at'       => date('Y-m-d H:i:s'),
                            'start_date'       => date('Y-m-d H:i:s'),
                            "total_price"      => $pk["price"],
                            "months"           => $pk["months"],
                            "status"           => 1,
                            'expired_at'       => date('Y-m-d',strtotime('+'.$num_months)),
                        ]);
                        $this->Common_model->update('member',[
                            "package_id"   => $record["package_id"],
                            'expired_date' => date('Y-m-d',strtotime('+'.$pk['months'].' months')),
                        ],["id" => $record["member_id"]]);
                    } 
                }
            }else{
                $this->message(validation_errors());
            }
            redirect(backend_url($this->base_controller.'/view/'.@$id));
        }
        $this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/view",$this->data);
    }

}
