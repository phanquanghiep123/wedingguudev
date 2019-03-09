<?php
require_once ("Nganluong/nganluong.class.php");

class Nganluong
{
	private $NGANLUONG_URL;
    private $RECEIVER;
	private $MERCHANT_ID;
	private $MERCHANT_PASS;
	
	function __construct()
    {     
        parent::__construct();
        
        $ci=&get_instance();
    	$ci->load->model('Common_model');
    	$web_setting = $ci->Common_model->get_record("web_setting");
    	if ($web_setting != null) 
    	{
    		$setting = json_decode($web_setting['Body_Json'],true);
    		$this->NGANLUONG_URL 	= $setting["nganluong_url"];
			$this->RECEIVER 		= $setting["nganluong_receiver"];
			$this->MERCHANT_ID    	= $setting["nganluong_merchant_id"];
			$this->MERCHANT_PASS    = $setting["nganluong_merchant_password"];
    	}
    }
	
	public function Nganluong($params)
	{ 
		
	}
	
	public function payment_url($params)
	{
		$receiver = $this->RECEIVER;
		//Mã đơn hàng 
		$order_code = 'eW_'.time();
		// Success URL
		$return_url = base_url("payment/success");
		// Cancel URL
		$cancel_url= base_url("payment/cancel");
		//Giá của cả giỏ hàng 
		$txh_name = $_POST['txh_name'];
		$txt_email = $_POST['txt_email'];
		$txt_phone = $_POST['txt_phone'];
		$price = (int)$_POST['txt_gia'];
		//Thông tin giao dịch
		$transaction_info = "Thong tin giao dich";
		$currency = "vnd";
		$quantity = 1;
		$tax = 0;
		$discount = 0;
		$fee_cal = 0;
		$fee_shipping = 0;
		$order_description = "Thong tin don hang: " . $order_code;
		$buyer_info = $txh_name . "*|*" . $txt_email . "*|*" . $txt_phone;
		$affiliate_code = "";
	    //Khai báo đối tượng của lớp NL_Checkout
		$nl = new NL_Checkout();
		$nl->nganluong_url = NGANLUONG_URL;
		$nl->merchant_site_code = MERCHANT_ID;
		$nl->secure_pass = MERCHANT_PASS;
		//Tạo link thanh toán đến nganluong.vn
		$url = $nl->buildCheckoutUrlExpand($return_url, $receiver, $transaction_info, $order_code, $price, $currency, $quantity, $tax, $discount, $fee_cal, $fee_shipping, $order_description, $buyer_info, $affiliate_code);
		
		return $url;
	}
	
	public function success_url($params)
	{
		
	}
	
	public function _url($params)
	{
		
	}
}