<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
class Invite extends Frontend_Controller {
    
    private $yahoo_client_id = '';
    private $yahoo_client_secret = '';

    private $out_key = '';
    private $out_secret = '';

    private $table = '';
    private $table_setting = '';
    private $table_invite = '';
    private $table_email_template = '';
    private $table_payment_history = '';
    private $table_package = '';

    private $google_client_id = '';
    private $google_client_secret = '';
    private $google_callback = '';

    private $facebook_app_id = '';


	public function __construct(){
        parent::__construct();
        $this->check_login();
        //if($this->data['user']['is_dealer'] != 1){
            //redirect('/profile/');
        //}
        $this->table = $this->table_prefix.'member';
        $this->table_invite = $this->table_prefix.'invite';
        $this->table_setting = $this->table_prefix.'web_setting';
        $this->table_email_template  = $this->table_prefix.'email_template';
        $this->table_payment_history = $this->table_prefix.'payment_history';
        $this->table_package         = $this->table_prefix.'package';
        $this->table_member_page         = $this->table_prefix.'member_package';
        
        $setting = @$this->Common_model->get_record($this->table_setting);
        $setting = json_decode(@$setting['Body_Json'],true);
        $this->yahoo_client_id = @$setting['yahoo_client_id'];
        $this->yahoo_client_secret = @$setting['yahoo_client_secret'];
        $this->google_client_id = @$setting['google_client_id'];
        $this->google_client_secret = @$setting['google_secret'];
        $this->google_callback = base_url('/invite/contact_google');
        $this->out_key = @$setting['out_key'];
        $this->out_secret = @$setting['out_secret'];
        $this->facebook_app_id = @$setting['facebook_app_id'];
    }

	public function index(){
        $result_email = array();
        if($this->session->userdata('type') == 'google'){
            $this->session->unset_userdata('type');
            include_once("Social/Google/Google_Client.php");
            include_once("Social/Google/contrib/Google_Oauth2Service.php");
            $gClient = new Google_Client();
            $gClient->setApplicationName('Login to codexworld.com');
            $gClient->setClientId($this->google_client_id);
            $gClient->setClientSecret($this->google_client_secret);
            $gClient->setRedirectUri($this->google_callback);
            $gClient->setAccessType('online');
            $gClient->setScopes('https://www.google.com/m8/feeds');
            $google_oauthV2 = new Google_Oauth2Service($gClient);
            if ($this->session->userdata('token')) {
                $gClient->setAccessToken($this->session->userdata('token'));
                $this->session->unset_userdata('token');
            }
            if ($gClient->getAccessToken()) {
                $result = json_decode($gClient->getAccessToken(),true);
                $max_results = 500;
                $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results='.$max_results.'&alt=json&v=3.0&oauth_token='.$result['access_token'];
                $xmlresponse = $this->curl($url);
                $contacts = json_decode($xmlresponse,true);
                if (!empty($contacts['feed']['entry'])) {
                    foreach($contacts['feed']['entry'] as $contact) {
                        if (filter_var(@$contact['gd$email'][0]['address'], FILTER_VALIDATE_EMAIL)) {
                            $result_email[] = array (
                                'name'=> $contact['title']['$t'],
                                'email' => @$contact['gd$email'][0]['address'],
                            );
                        }
                    }               
                }
            }
            $this->data['result'] = $result_email;
        }
        else if($this->session->userdata('type') == 'yahoo'){
            $this->session->unset_userdata('type');
            include_once("Social/Yahoo/Yahoo.php");
            $yahoo = new yahoo();
            $request_token   =  $this->session->userdata('request_token');
            $request_token_secret  = $this->session->userdata('request_token_secret');
            $oauth_verifier    =   $this->session->userdata('oauth_verifier');
            $retarr = $yahoo->get_access_token_yahoo($this->yahoo_client_id,$this->yahoo_client_secret, $request_token, $request_token_secret, $oauth_verifier, false, true, true); 
            if (! empty($retarr)) { 
                list($info, $headers, $body, $body_parsed) = $retarr;
                if ($info['http_code'] == 200 && !empty($body)) { 
                    $guid    =  $body_parsed['xoauth_yahoo_guid'];
                    $access_token  = $yahoo->rfc3986_decode($body_parsed['oauth_token']) ;
                    $access_token_secret  = $body_parsed['oauth_token_secret']; 
                    $result_email = $yahoo->callcontact_yahoo($this->yahoo_client_id,$this->yahoo_client_secret, $guid, $access_token, $access_token_secret, false, true);
                }
            }
            $this->session->unset_userdata('request_token');
            $this->session->unset_userdata('request_token_secret');
            $this->session->unset_userdata('oauth_verifier');
            $this->session->unset_userdata('oauth_token');
            $this->data['result'] = $result_email;
        }
        else if ($this->session->userdata('type') == 'outlook'){
            $this->session->unset_userdata('type');
            include_once("social/Outlook/oauth.php");
            include_once("social/Outlook/outlook.php");
            $contacts = OutlookService::getContacts(Session::get('access_token'), Session::get('user_email'));
            if(isset($contacts['value']) && $contacts['value'] != null){
                foreach($contacts['value'] as $contact){
                    if (filter_var(@$contact['EmailAddresses'][0]['Address'], FILTER_VALIDATE_EMAIL)) {
                        $result_email[] = array (
                            'name'=> $contact['GivenName'].' '.$contact['Surname'],
                            'email' => @$contact['EmailAddresses'][0]['Address']
                        );
                    }
                }
            }
            $this->session->unset_userdata('access_token');
            $this->session->unset_userdata('user_email');
            $this->session->unset_userdata('refresh_token');
        }
        
		$per_page = $this->per_page;
        $offset = ($this->input->get("offset") != "") ? $this->input->get("offset") : 0 ;    
        $sql = "SELECT tbl1.*,tbl2.first_name,tbl2.last_name,tbl2.email,tbl4.name AS package_name , sum(tbl1.plus_day_to_member) as plus_day ,tbl5.sum_money,tbl5.numberpay
                FROM {$this->table_invite} AS tbl1 
                INNER JOIN {$this->table} AS tbl2 ON tbl1.member_id = tbl2.id
                LEFT JOIN {$this->table_payment_history} AS tbl3 ON tbl3.member_id = tbl2.id AND tbl3.status = '1'
                LEFT JOIN {$this->table_package} AS tbl4 ON tbl4.id = tbl3.package_id 
                LEFT JOIN (SELECT count(tbll1.id) as numberpay, tbll1.member_id ,sum(tbll1.commission_money) as sum_money FROM {$this->table_payment_history} as tbll1  WHERE tbll1.status = 1 GROUP BY tbll1.member_id  )AS tbl5 ON tbl5.member_id = tbl2.id
                WHERE tbl1.member_invite_id = '{$this->user_id}'
                GROUP BY tbl1.member_id
                ORDER BY tbl1.id DESC
                LIMIT $offset,$per_page";

        $sql_count = "SELECT count(tbl1.id) AS count
                FROM {$this->table_invite} AS tbl1 
                INNER JOIN {$this->table} AS tbl2 ON tbl1.member_id = tbl2.id
                WHERE tbl1.member_invite_id = '{$this->user_id}' ";
        $count = $this->Common_model->query_raw_row($sql_count); 
        $config['base_url'] = base_url('/invite/');
        $config['total_rows'] = @$count['count'] != null ? $count['count'] : 0;
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize(_get_paging($config));
        $this->data["results"] = $this->Common_model->query_raw($sql);
        $sql =" 
        SELECT count(tbl1.id) as numberMember,sum(tbl2.sum_money) as sum_money , tbl2.numberpay
        FROM {$this->table_invite} as tbl1
        LEFT JOIN (SELECT member_id, count(id) AS numberpay, sum(commission_money) as sum_money FROM {$this->table_payment_history} WHERE status = 1 GROUP BY member_id)
        as tbl2 on tbl1.member_id = tbl2.member_id
        WHERE  tbl1.member_invite_id = {$this->user_id}";
        $query = $this->db->query($sql);
        $this->data["dataPlus"] = $query->row_array();
        $this->data['facebook_app_id'] = $this->facebook_app_id;
        $this->data['record'] = $this->Common_model->get_record($this->table,array('id' => $this->user_id));
        $this->load->view('frontend/invite/index',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
	}

    public function send_invite(){
        $data = array('status' => 'error');
        if (!$this->input->is_ajax_request()) {
           die(json_encode($data));
        }
        $email  = $this->input->post('email');
        $list = explode(",", $email);
        if(isset($list) && count($list) > 0){
            $to = $list[0];
            foreach ($list as $key => $item) {
            	if ($item != null && filter_var(strtolower($item), FILTER_VALIDATE_EMAIL)) {
            		$check = $this->Common_model->get_record($this->table_invite,array('email' => strtolower($item),'member_id' => $this->user_id));
            		if(!(isset($check) && $check != null)){
            			$arr = array(
            				'member_id' => $this->user_id,
            				'email' => strtolower($item)
            			);
            			$this->Common_model->add($this->table_invite,$arr);
            		}
            	}
            }
            $template = $this->Common_model->get_record($this->table_email_template,array('Key_Identify' => 'invite'));
            if(isset($template) && $template != null){
                $replace = array("[%first_name%]", "[%link%]");
                $replace_with = array(@$this->data['user']['full_name'], base_url('account/register/'.@$this->data['user']['promo_code']));
                $sentdata = str_replace($replace, $replace_with, @$template['Content']);
                $msg = $this->load->view($this->asset.'/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
                $subject = @$template['Title'];
                sendmail($to, $subject, $msg,@$list);
            }
        }
        $data['status'] = 'success';
        die(json_encode($data));
    }

    public function contact_google(){
        include_once("Social/Google/Google_Client.php");
        include_once("Social/Google/contrib/Google_Oauth2Service.php");
        $gClient = new Google_Client();
        $gClient->setApplicationName('Get Contact');
        $gClient->setClientId($this->google_client_id);
        $gClient->setClientSecret($this->google_client_secret);
        $gClient->setRedirectUri($this->google_callback);
        $gClient->setAccessType('online');
        $gClient->setScopes('https://www.google.com/m8/feeds');
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        if(@$_REQUEST['code'] != null){
            $gClient->authenticate();
            $token = $gClient->getAccessToken();
            $this->session->set_userdata('token', $token);
            $this->session->set_userdata('type', 'google');
            redirect('/invite/');
            die;
        }
        else{
            $authUrl = $gClient->createAuthUrl();
            redirect($authUrl);
            die;
        }
    }

    public function contact_yahoo(){
        include_once("Social/Yahoo/Yahoo.php");
        $yahoo = new yahoo();
        $retarr = $yahoo->get_request_token($this->yahoo_client_id,$this->yahoo_client_secret, base_url(), false, true, true);
        if (! empty($retarr)){ 
            list($info, $headers, $body, $body_parsed) = $retarr; 
            if ($info['http_code'] == 200 && !empty($body)) {  
                $this->session->set_userdata('request_token', $body_parsed['oauth_token']);
                $this->session->set_userdata('request_token_secret', $body_parsed['oauth_token_secret']);
                $this->session->set_userdata('oauth_verifier', $body_parsed['oauth_token']);
                redirect(urldecode($body_parsed['xoauth_request_auth_url']));
            } 
        }
        redirect('/');
    }

    public function contact_outlook(){
        include_once("Social/Outlook/oauth.php");
        include_once("Social/Outlook/outlook.php");
        $redirectUri = base_url().'contact_outlook';
        $oAuthService = new oAuthService();
        $oAuthService->setData($this->out_key,$this->out_secret);
        if (isset($_GET['code']) && $_GET['code'] != null) {
            $tokens = $oAuthService->getTokenFromAuthCode($auth_code, $redirectUri);
            if ($tokens['access_token']) {
                $user = OutlookService::getUser($tokens['access_token']);
                $this->session->set_userdata('access_token', $tokens['access_token']);
                $this->session->set_userdata('refresh_token', $tokens['refresh_token']);
                $user = OutlookService::getUser($tokens['access_token']);
                $this->session->set_userdata('user_email', $user['EmailAddress']);
                $this->session->set_userdata('type', 'outlook');
            }
            redirect('/invite/');
        }
        else{
            $authUrl = $oAuthService->getLoginUrl($redirectUri);
            redirect($authUrl);
        }
    }

    private function curl($url, $post = ""){
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
        curl_setopt($curl, CURLOPT_URL, $url);
        //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
        //The number of seconds to wait while trying to connect.
        if ($post != "") {
            curl_setopt($curl, CURLOPT_POST, 5);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);
        //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        //To stop cURL from verifying the peer's certificate.
        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }
    public function detail ($id){
        $invite   = $this->Common_model->get_record($this->table_invite, ["id" => $id]);
        $member   = $this->Common_model->get_record($this->table, ['id' => $invite["member_id"]]);
        $payments = $this->Common_model->get_result($this->table_payment_history,['id' => $member["id"] ,"status" => 1]);
        $this->db->select("*");
        $this->db->from($this->table_payment_history . " as tbl1");
        $this->db->join($this->table_package . " as tbl2" ,"tbl1.package_id = tbl2.id");
        $this->db->where("tbl1.member_id", $member["id"]);
        $this->data["payments"] = $this->db->get()->result_array();
        $sql = "SELECT count(tbll1.id) as numberpay, tbll1.member_id ,sum(tbll1.commission_money) as sum_money FROM {$this->table_payment_history} as tbll1  WHERE tbll1.member_id = {$member["id"]} AND tbll1.status = 1 GROUP BY tbll1.member_id  ";
        $query = $this->db->query($sql);
        $this->data["dataPlus"] = $query->row_array();
        $this->data["member"]   = $member;
        $this->load->view('frontend/invite/detail',$this->data);
        $this->load->view($this->asset.'/block/footer',$this->data);
    }
}
