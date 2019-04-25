<?php 
class Hook_Languages 
{   
	public $cookie_Key = "_Lang";
	public $lang       = "vn";
	public $langData   = [];
	public $LangContent = "";
	function __construct($type = 0)
	{
		$CI =& get_instance();
		$CI->load->helper('cookie');
		if($type == 0){
			$this->get_cookie();
			$this->get_language();
		}
	}
	public function get_cookie(){
		
		$this->lang = get_cookie($this->cookie_Key) ? get_cookie($this->cookie_Key) : "vn";
		return $this->lang;
	}
	public function set_cookie ($data){

		$CI =& get_instance();
		$expire = strtotime('NOW+7DAYS');
        $path  = '/';
        $secure = TRUE;
	    setcookie($this->cookie_Key,$data,$expire,$path);
		$this->lang = $data;
		$this->get_language();
	}
	public function get_language (){
		$CI =& get_instance();
		$r = $CI->Common_model->get_record("languages",["slug" => $this->lang]);
		if($r){
			$media_id = $r["file"];
			$rl = $CI->Common_model->get_record("theme_medias",["id" => $media_id]);
			if($rl){
				$path = FCPATH . $rl['path'];
				$content = file_get_contents($path);
				$this->LangContent = $content;
				$this->langData = json_decode($content,true);
				return true;
			}
			
		}
		return false;
	}
	public function get_lang_by_key ($key){
		return @$this->langData[$key];
	}
	public function get_lang_data (){
		return @$this->langData;
	}
	function getInbetweenStrings($string){
		preg_match_all('/\[{](.+?)\[}]/', $string, $matches);
		return(@$matches[1]);
	}
	public function ReplaceLang(){
		$CI =& get_instance();
	    $buffer = $CI->output->get_output();
	    $arrays = $this->getInbetweenStrings($buffer);
	    $arrayKey   = [];
	    $arrayValue = [];
	    foreach ($arrays as $key => $valueS) {
	    	$args = explode("|", $valueS);
	    	if(count(@$args) > 0)
	    	{
	    		if(@$this->langData[$args[0]]){
	    			$value_string =  @$this->langData[$args[0]];
		    		foreach ($args as $key => $value) {
		    			if($key != 0){
		    				$value_string = str_replace("{".( $key - 1 )."}",$value,$value_string );
		    			}
		    		}
		    		$arrayValue [] = $value_string;
		    		$arrayKey   [] = "[{]".$valueS."[}]"; 
	    		}	
	    	}	 
	    }
	    if($CI->uri->segment(1) != "backend"){
	    	if(@$arrayKey && $arrayValue)
		    	$buffer  = str_ireplace($arrayKey, $arrayValue, $buffer);
		}

	    $CI->output->set_output($buffer);
	    $CI->output->_display();

	}
}