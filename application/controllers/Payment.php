<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Payment extends Frontend_Controller {
	private $table = '';
	private $table_package = '';
	private $table_history = '';
    private $table_member_package = '';
    private $table_email_template = '';
	private $arr_method = array(
		'nganluong' => 1,
		'baokim' => 2,
		'bank' => 3
	);
	public function __construct(){
        parent::__construct();
        $this->table = $this->table_prefix.'payment_method';
    	$this->table_package = $this->table_prefix."package";
    	$this->table_history = $this->table_prefix."payment_history";
        $this->table_member_package = $this->table_prefix."member_package";
        $this->table_email_template = $this->table_prefix.'email_template';
    	$this->check_login();
    	$this->data['method'] = $this->arr_method;
    }

	public function index($package_id = null){
		$record = $this->Common_model->get_record($this->table_package,["status" => 1,'id' => $package_id]);
		if(@$record == null || @$record['price'] == 0){
			redirect('/pricing/');
		}
		if ($this->input->post()){
			$method = $this->input->post('method');
			$payment_method = $this->Common_model->get_record($this->table,["status" => 1,'id' => $method]);
			if($method!= null && @$payment_method == null){
            	$this->session->set_flashdata('message',$this->message('Phương thức thanh toán này không tồn tại.'));
            	$this->session->set_flashdata('record',$this->input->post());
                redirect('/payment/index/'.$package_id);
            }

			$this->load->library('form_validation');
            $this->form_validation->set_rules('method', 'Họ đệm', 'required|trim');
            $this->form_validation->set_rules('name', 'Họ và tên', 'required|trim');
            $this->form_validation->set_rules('email', 'Địa chỉ email', 'required|trim');
            $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|trim');
            if($method == $this->arr_method['bank']){
            	//$this->form_validation->set_rules('name_cart', 'Chủ Tài Khoản', 'required|trim');
            	//$this->form_validation->set_rules('name_bank', 'Tên ngân hàng', 'required|trim');
            	//$this->form_validation->set_rules('trading_code', 'Số Tài Khoản', 'required|trim');
            }

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message',$this->message('Vui lòng nhập đầy đủ thông tin.'));
                $this->session->set_flashdata('record',$this->input->post());
            } else {
            	$input = $this->input->post();
            	$arr = array(
            		'name'	=> $this->input->post('name'),
            		'email'	=> $this->input->post('email'),
            		'phone'	=> $this->input->post('phone'),
            		'comment'	=> $this->input->post('comment'),
            		'status' => 0,
            		'member_id'	=> $this->user_id,
            		'months'	=> $record['months'],
            		'total_price' => $record['price'],
            		'start_date'  => date("Y-m-d H:i:s"),
            		'expired_at'  => date("Y-m-d H:i:s", strtotime("+".$record['months']." month")),
            		'package_id'  => $record['id']
            	);
            	$order_id = $this->Common_model->add($this->table_history,$arr);
            	if($order_id > 0){
            		$this->session->set_userdata('order_id', $order_id);
	            	$api = json_decode($payment_method['json_api'],true);
					$price = @$record['price'];

                    $template = $this->Common_model->get_record($this->table_email_template,array('Key_Identify' => 'payment-user'));
                    if(@$template != null){
                        $replace = array("[%name%]");
                        $replace_with = array($this->input->post('name'));
                        $sentdata = str_replace($replace, $replace_with, @$template['Content']);
                        $msg = $this->load->view($this->asset.'/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
                        $to = $this->input->post('email');
                        $subject = @$template['Title'];
                        sendmail($to, $subject, $msg);
                    }


					if($method == $this->arr_method['nganluong']){
						$arr = array('method' => 'nganluong');
                        $this->Common_model->update($this->table_history,$arr,array('id' => $order_id));
                        
                        $this->session->set_userdata('payment_method', $this->arr_method['nganluong']);
						$this->load->helper('nganluong');
						$order_id = md5(time());
		                $merchant_id = @$api['merchant_id'];
		                $merchant_password = @$api['merchant_password'];
		                $receiver_email = @$api['receiver_email'];
		                $NL = new nganluong($merchant_id,$merchant_password,$receiver_email);
		                
		                $order_code = time();
		                $total_amount = $price;
		                $payment_type = '';
		                $order_description = 'Thanh toán.';
		                $tax_amount = 0;
		                $fee_shipping = 0;
		                $discount_amount = 0;
		                $cancel_url = base_url('/payment/cancel');
		                $return_url = base_url('/payment/nganluong');
		                
		                $buyer_fullname = @$input["name"];
		                $buyer_email = @$input["email"];
		                $buyer_mobile = @$input["phone"];
		                $buyer_address = '';

		                $array_items = array();
		                $array_items[0] = array(
		                    'item_name1' => 'Thánh toán đơn hàng',
		                    'item_quantity1' => 1,
		                    'item_amount1' => $total_amount,
		                    'item_url1' => base_url()
		                );

		                $nl_result = $NL->NLCheckout($order_code,$total_amount,$payment_type,$order_description,$tax_amount,
		                                            $fee_shipping,$discount_amount,$return_url,urlencode($cancel_url),$buyer_fullname,$buyer_email,$buyer_mobile, 
		                                            $buyer_address,$array_items);
		                redirect((string)$nl_result->checkout_url);
					}
					else if($method == $this->arr_method['baokim']){
						$arr = array('method' => 'baokim');
                        $this->Common_model->update($this->table_history,$arr,array('id' => $order_id));

                        $this->session->set_userdata('payment_method', $this->arr_method['baokim']);
						$this->load->helper('baokim');
						$merchant_id = @$api['merchant_id'];
		                $secure_pass = @$api['secure_pass'];
		                $business = @$api['business_email'];
		                
		                $BK = new baokim($merchant_id,$secure_pass,$business);
		                $total_amount = $price;
		                $shipping_fee = 0;
		                $tax_fee = 0;
		                $order_description = 'Thanh toán đơn hàng.';
		                $url_success = base_url('/payment/baokim');
		                $url_cancel  = base_url('/payment/cancel');
		                $url_detail  = '';
		                $order_id = md5(time());
		                $url = $BK->createRequestUrl($total_amount,$order_id, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail);
		                redirect((string)$url);
					}
					else if($method == $this->arr_method['bank']){
                        /*$arr = array(
                            'method' => 'bank',
                            'name_cart' => $this->input->post('name_cart'),
                            'name_bank' => $this->input->post('name_bank'),
                            'trading_code' => $this->input->post('trading_code'),
                            'trading_comment' => $this->input->post('trading_comment')
                        ); 
                        $this->Common_model->update($this->table_history,$arr,array('id' => $order_id));*/

                        $template = $this->Common_model->get_record($this->table_email_template,array('Key_Identify' => 'payment-admin'));
                        if(@$template != null){
                            $replace = array("[%name%]","[%link%]");
                            $replace_with = array($this->input->post('name'),'');
                            $sentdata = str_replace($replace, $replace_with, @$template['Content']);
                            $msg = $this->load->view($this->asset.'/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
                            $to = @$this->data['setting']['email_admin'];
                            $subject = @$template['Title'];
                            if($to != null){
                                sendmail($to, $subject, $msg);
                            }
                        }

                        redirect('/payment/success');
					}
				}
			}
            redirect('/payment/index/'.$package_id);
		}
		$this->data['title'] = 'Thanh toán';
        $this->data['package'] = $record;
		$this->data['payment_method'] = $this->Common_model->get_result($this->table,array('status' => 1));
		$this->load->view('frontend/payment/payment',$this->data);
	}

	public function baokim(){
        $input = $this->input->get();
        $order_id = $this->session->userdata('order_id');
        $order = $this->Common_model->get_record($this->table_history,array('id' => $order_id));
        $payment_method = $this->Common_model->get_record($this->table,["status" => 1,'id' => $this->session->userdata('payment_method')]);
        if(@$order != null && $payment_method != null){
            $transaction_id  = $input['transaction_id'];
            $created_on  = $input['created_on'];
            $payment_type  = $input['payment_type'];
            $transaction_status  = $input['transaction_status'];
            $total_amount  = $input['total_amount'];
            $net_amount  = $input['net_amount'];
            $fee_amount  = $input['fee_amount'];
            $merchant_id  = $input['merchant_id'];
            $client_fullname  = $input['customer_name'];
            $client_email  = $input['customer_email'];
            $client_phone  = $input['customer_phone'];
            $client_address  = $input['customer_address'];
            $Checksum  = $input['Checksum'];
            if(isset($transaction_status) && ($transaction_status == 4 || $transaction_status == 13)){
                //payment success
                $arr['status'] = 1;
                $this->Common_model->update($this->table_history,$arr,array('id' => $order_id));
                redirect('/payment/success');
            }
        }
        redirect('/payment/cancel');
    }

    public function nangluong(){
        $input = $this->input->get();
        $order_id = $this->session->userdata('order_id');
        $order = $this->Common_model->get_record($this->table_history,array('id' => $order_id));
        $payment_method = $this->Common_model->get_record($this->table,["status" => 1,'id' => $this->session->userdata('payment_method')]);
        if(@$order != null && $payment_method != null){
            $this->load->helper('nganluong');
            $api = json_decode(@$payment_method['json_api'],true);
            $merchant_id = @$api['merchant_id'];
            $merchant_password = @$api['merchant_password'];
            $receiver_email = @$api['receiver_email'];
            $NL = new nganluong($merchant_id,$merchant_password,$receiver_email);
            $token = $input['token'];
            $nl_result = $NL->GetTransactionDetail($token);
            if($nl_result){
                $nl_errorcode           = (string)$nl_result->error_code;
                $nl_transaction_status  = (string)$nl_result->transaction_status;
                $message = $NL->GetErrorMessage($nl_errorcode);
                if($nl_errorcode == '00' && $nl_transaction_status) {
                    //payment success
                    $arr['status'] = 1;
                    $this->Common_model->update($this->table_history,$arr,array('id' => $order_id));
                    redirect('/payment/success');
                }  
                else {
                    $this->session->set_flashdata('message',$message);
                }
            }
        }
        redirect('/payment/cancel');
    }

    public function success(){
    	$this->session->unset_userdata('order_id');
        $this->session->unset_userdata('payment_method');
        $this->data['title'] = 'Thanh toán thành công.';
        $this->load->view('frontend/payment/success',$this->data);
    }

    public function cancel(){
    	$this->session->unset_userdata('order_id');
        $this->session->unset_userdata('payment_method');
        $this->data['title'] = 'Thanh toán thất bại.';
        $this->load->view('frontend/payment/cancel',$this->data);
    }
}