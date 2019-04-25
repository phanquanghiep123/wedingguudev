<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class page extends Frontend_Controller {

	private $table = '';
	private $table_faq = '';
	private $table_faq_category = '';
	public function __construct()
    {
        parent::__construct();
        $this->table = $this->table_prefix."page";
        $this->table_faq = $this->table_prefix."help";
        $this->table_faq_category = $this->table_prefix."help_category";
    }

	public function index($slug = null)
	{
		$this->data['page'] = $this->Common_model->get_record($this->table,array('Key_Identify' => $slug,"Lang" => $this->langId));
		if(!(isset($this->data['page']) && $this->data['page'] != null)){
			redirect('/');
			die;
		}
		$this->load->view($this->asset.'/page/index',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}

	public function faq($category_id = null)
	{
		$where = array();
		$where['status'] = 1;
		if(@$category_id != null){
			$where['category_id'] = $category_id;
		}
		$where['lang'] = $this->langId;
		$this->data['title'] = '[{]FAQ_STRING_001[}]';
		$this->data['faqs'] = $this->Common_model->get_result($this->table_faq,$where);
		$this->data['category'] = $this->Common_model->get_result($this->table_faq_category,array('status' => 1 ,'lang' => $this->langId));
		$this->load->view($this->asset.'/page/faq',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}


	public function testimonials()
	{
		$this->data['title_page'] = '[{]TESTIMONIAL_STRING_001[}]';
		$this->data["testimonials"] = $this->Common_model->get_result($this->table_prefix."testimonial",["status" => 1 ,'lang' => $this->langId]);
		$this->load->view($this->asset.'/page/testimonials',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}

	public function contact(){
		if($this->input->post()){
			$this->load->library('form_validation');
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
            	$email = $this->input->post('email');
            	$subject = $this->input->post('subject');
            	$message = $this->input->post('message');
            	$full_name = $this->input->post('full_name');
            	$this->load->library('email');
				$this->email->from($email, $full_name);
				$this->email->to('ngovanduc123@gmail.com');
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
            	$this->session->set_flashdata('message', '<div class="alert alert-success">Send mail successfully.</div>');
            }
            redirect('/page/contact-us');
		}
		$this->load->view($this->asset.'/block/header',$this->data);
		$this->load->view($this->asset.'/page/contact',$this->data);
		$this->load->view($this->asset.'/block/footer',$this->data);
	}
}
