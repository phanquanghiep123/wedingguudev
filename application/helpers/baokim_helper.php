<?php

Class Baokim 
{
	/**
	*	
	*		Phiên bản: 0.1   
	*		Tên lớp: BaoKimPayment
	*		Chức năng: Tích hợp thanh toán qua baokim.vn cho các merchant site có đăng ký API
	*						- Xây dựng URL chuyển thông tin tới baokim.vn để xử lý việc thanh toán cho merchant site.
	*						- Xác thực tính chính xác của thông tin đơn hàng được gửi về từ baokim.vn.
	*		
	*/

	// URL checkout của baokim.vn
	//private $baokim_url = 'https://www.baokim.vn/payment/customize_payment/order/';
	private $baokim_url = 'https://www.baokim.vn/payment/order/version11/';

	//Mã MerchantID dang kí trên Bảo Kim
	private $merchant_id = '';//'22592';
	//mat khau di kem ma website dang kí trên B?o Kim
	private $secure_pass = '';//'8356a6cb0896eaa8';

	private $business = '';//'ngovanduc123@gmail.com';

	function __construct($merchant_id,$secure_pass,$business){
		$this->merchant_id = $merchant_id;
		$this->secure_pass = $secure_pass;
		$this->business = $business;
	}
	/**
	 * Hàm xây dựng url chuyển đến BaoKim.vn thực hiện thanh toán, trong đó có tham số mã hóa (còn gọi là public key)
	 * @param $order_id				Mã đơn hàng
	 * @param $business 			Email tài khoản nhận thanh toán đăng ký trên baokim.vn
	 * @param $total_amount			Giá trị đơn hàng
	 * @param $shipping_fee			Phí vận chuyển
	 * @param $tax_fee				Thuế
	 * @param $order_description	Mô tả đơn hàng
	 * @param $url_success			Url trả về khi thanh toán thành công
	 * @param $url_cancel			Url trả về khi hủy thanh toán
	 * @param $url_detail			Url chi tiết đơn hàng
	 * @return url cần tạo
	 */
	public function createRequestUrl($total_amount,$order_id, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail)
	{
		// Mảng các tham số chuyển tới baokim.vn
		$params = array(
			//'api_username' 		=>  $this->api_username,
			//'api_password' 		=>  $this->api_password,
			'merchant_id'		=>	$this->merchant_id,
			'order_id'			=>	$order_id,
			'business'			=>	$this->business,
			'total_amount'		=>	strval($total_amount),
			'shipping_fee'		=>  strval($shipping_fee),
			'tax_fee'			=>  strval($tax_fee),
			'order_description'	=>	strval($order_description),
			'url_success'		=>	strtolower($url_success),
			'url_cancel'		=>	strtolower($url_cancel),
			'url_detail'		=>	strtolower($url_detail),
			//'currency'			=>  $this->currency
		);	
		ksort($params);

		$params['checksum'] = hash_hmac('SHA1',implode('',$params),$this->secure_pass);//https://www.baokim.vn/payment/order/version11
		//$params['checksum'] = strtoupper(md5($this->secure_pass.implode('',$params))); //https://www.baokim.vn/payment/customize_payment/order/
		

		//Kiểm tra  biến $redirect_url xem có '?' không, nếu không có thì bổ sung vào
		$redirect_url = $this->baokim_url;
		if (strpos($redirect_url, '?') === false)
		{
			$redirect_url .= '?';
		}
		else if (substr($redirect_url, strlen($redirect_url)-1, 1) != '?' && strpos($redirect_url, '&') === false)
		{
			// Nếu biến $redirect_url có '?' nhưng không kết thúc bằng '?' và có chứa dấu '&' thì bổ sung vào cuối
			$redirect_url .= '&';			
		}
				
		// Tạo đoạn url chứa tham số
		$url_params = '';
		foreach ($params as $key=>$value)
		{
			if ($url_params == '')
				$url_params .= $key . '=' . urlencode($value);
			else
				$url_params .= '&' . $key . '=' . urlencode($value);
		}
		return $this->baokim_url.'?'.$url_params;
	}
}