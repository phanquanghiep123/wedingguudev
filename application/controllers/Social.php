<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');
require_once FCPATH.'application/core/Frontend_Controller.php';
require_once 'Social/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
class Social extends Frontend_Controller
{
    private $table = '';
    private $table_setting = '';
    private $table_invite = '';

	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            redirect("/");
        }
        $this->table = $this->table_prefix.'member';
        $this->table_invite = $this->table_prefix.'invite';
        $this->table_setting = $this->table_prefix.'web_setting';
        //parse_str(substr(strrchr($_SERVER['REQUEST_URI'], "?"), 1), $_GET);
    }

    public function facebook(){
        $setting = @$this->Common_model->get_record($this->table_setting);
        $setting = json_decode(@$setting['Body_Json'],true);
        FacebookSession::setDefaultApplication(@$setting['facebook_app_id'],@$setting['facebook_secret']);
        $return_url = base_url('/social/facebook');
        $helper = new FacebookRedirectLoginHelper($return_url);
        
        try {
            $session = $helper->getSessionFromRedirect();
        } catch( FacebookRequestException $ex ) {
            // When Facebook returns an error
        } catch( Exception $ex ) {
            // When validation fails or other local issues
        }

        if (isset($session)){
            $request = new FacebookRequest($session, 'GET', '/me?fields=name,email,picture.type(large),gender' );
            $response = $request->execute();
            $graphObject = $response->getGraphObject();
            /*echo '<pre>';
            print_r($graphObject);
            echo '</pre>';
            die();*/
            $fbid = $graphObject->getProperty('id');
            $fullname = $graphObject->getProperty('name');
            $email = $graphObject->getProperty('email');
            $picture_url = null;
            foreach ((array)@$graphObject->getProperty('picture') as $key => $item) {
                $picture_url = $item['url'];
            }
            if(isset($email) && $email!=null){
                $record = $this->Common_model->get_record($this->table, array('email' => $email));
                if(!(isset($record) && $record != null)){
                    $picture_url = '';
                    $pk = $this->Common_model->get_record("package",["is_default" => 1]);
                    $num_months = $pk["months"];
                    $arr   = array(
                        'package_id' => $pk["id"],
                        'last_name' => $fullname,
                        'email' => $email,
                        'avatar' => $picture_url,
                        'pwd' => md5($email . ':' . time()),
                        'status' => 1,
                        'phone' => '',
                        'expired_date' => date('Y-m-d',strtotime('+'.$num_months.' months'))
                    );
                    $id = $this->Common_model->add($this->table, $arr);
                    if($id > 0){
                         $this->Common_model->add("member_package",[
                            "member_id"  => $id ,
                            "package_id" => $pk["id"] ,
                            'created_at' => date('Y-m-d H:i:s'),
                            'start_date' => date('Y-m-d H:i:s'),
                            'expired_at' => date('Y-m-d',strtotime('+'.$num_months.' days'))
                        ]);
                        if(isset($_COOKIE['user_invite_id']) && $_COOKIE['user_invite_id'] != null){
                            $user_invite_id = @$_COOKIE['user_invite_id'];
                            $where = array(
                                'email'  => $email,
                                'member_id' => $user_invite_id,
                                'status' => 0
                            );
                            $record_invite = $this->Common_model->get_record($this->table_invite,$where);
                            if(@$record_invite != null){
                                $arr  = array(
                                    'member_invite_id' => $id,
                                    'status' => 1
                                );
                                $this->Common_model->update($this->table_invite, $arr,$where);
                            }
                        }
                    }
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $email,
                        'id' => $id,
                        'full_name' => $fullname,
                        'address' => '',
                        'avatar' => (@$picture_url != null) ? $picture_url : '/skins/frontend/images/user_default.png',
                        'type' => 0
                    ));
                }
                else{
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["email"],
                        'id' => $record["id"],
                        'full_name' => $record["last_name"],
                        'first_name' => $record["first_name"],
                        'last_name' => $record["last_name"],
                        'avatar' => (@$record["avatar"] != null) ? $record["avatar"] : '/skins/frontend/images/user_default.png',
                        'type' => @$record['is_premium']
                    ));
                    $this->Common_model->update($this->table,array('status' => 1),array('id' => $record["id"]));
                }
            }
            redirect('/');
        } else {
            $scope = array('public_profile,email');
            $loginUrl = $helper->getLoginUrl($scope);
            redirect($loginUrl);
        }
    }

    public function facebook_bk(){
        include_once('Social/FaceBook/autoload.php');
        // Create our Application instance (replace this with your appId and secret).
        $setting = @$this->Common_model->get_record($this->table_setting);
        $setting = json_decode(@$setting['Body_Json'],true);            
        $facebook = new Facebook\facebook(array(
           'app_id'  => @$setting['facebook_app_id'],
           'app_secret' => @$setting['facebook_secret'],
           'default_graph_version' => 'v2.2'
        ));
        $return_url = base_url('/social/facebook');
        $params = array('public_profile');
        $helper = $facebook->getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($return_url, $params);

        $accessToken = null;
        try {
          $accessToken = $helper->getAccessToken();
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
            echo $e->getMessage();
            die();
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
            echo $e->getMessage();
            die();
        }
        if($accessToken == null){
            die($loginUrl);
            redirect($loginUrl);
        }
        $oAuth2Client = $facebook->getOAuth2Client();
        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $facebook->setDefaultAccessToken($accessToken);
        $response = $facebook->get('/me?fields=first_name,last_name,email,picture.type(large)');
        $users = (array)$response->getGraphUser();
        $user = null;
        foreach ($users as $key => $item) {
            $user = $item;
        }
        if(@$user != null){
            echo '<pre>';
            print_r($user);
            echo '</pre>';
            die();
            $email = strtolower($user['email']);
            $first_name = $user['first_name'];
            $last_name = $user['last_name'];
            $picture_url = null;
            foreach ((array)@$user['picture'] as $key => $item) {
                $picture_url = $item['url'];
            }
            if(isset($email) && $email!=null){
                $record = $this->Common_model->get_record($this->table, array('email' => $email));
                if(!(isset($record) && $record != null)){
                    $pk = $this->Common_model->get_record("package",["is_default" => 1]);
                    $num_months = $pk["months"];
                    $arr   = array(
                        'package_id' => $pk["id"],
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'avatar' => $picture_url,
                        'pwd' => md5($email . ':' . time()),
                        'status' => 1,
                        'phone' => '',
                        'expired_date' => date('Y-m-d',strtotime('+'.$num_months.' months'))
                    );
                    $id = $this->Common_model->add($this->table, $arr);
                    if($id > 0){
                        if(isset($_COOKIE['user_invite_id']) && $_COOKIE['user_invite_id'] != null){
                            $user_invite_id = @$_COOKIE['user_invite_id'];
                            $where = array(
                                'email'  => $email,
                                'member_id' => $user_invite_id,
                                'status' => 0
                            );
                            $record_invite = $this->Common_model->get_record($this->table_invite,$where);
                            if(@$record_invite != null){
                                $arr  = array(
                                    'member_invite_id' => $id,
                                    'status' => 1
                                );
                                $this->Common_model->update($this->table_invite, $arr,$where);
                            }
                        }
                        $this->Common_model->add("member_package",[
                            "member_id"  => $id ,
                            "package_id" => $pk["id"] ,
                            'created_at' => date('Y-m-d H:i:s'),
                            'start_date' => date('Y-m-d H:i:s'),
                            'expired_at' => date('Y-m-d',strtotime('+'.$num_months.' days'))
                        ]);
                    }
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $email,
                        'id' => $id,
                        'full_name' => $first_name . ' ' . $last_name,
                        'address' => '',
                        'avatar' => (@$picture_url != null) ? $picture_url : '/skins/frontend/images/user_default.png',
                        'type' => 0
                    ));
                }
                else{
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["email"],
                        'id' => $record["id"],
                        'full_name' => $record["first_name"] . ' ' . $record["last_name"],
                        'first_name' => $record["first_name"],
                        'last_name' => $record["last_name"],
                        'avatar' => (@$record["avatar"] != null) ? $record["avatar"] : '/skins/frontend/images/user_default.png',
                        'type' => @$record['is_premium']
                    ));
                    $this->Common_model->update($this->table,array('status' => 1),array('id' => $record["id"]));
                }
            }
        }
        redirect('/');
    }

    public function google(){
        include_once("Social/Google/Google_Client.php");
        include_once("Social/Google/contrib/Google_Oauth2Service.php");
        $setting = @$this->Common_model->get_record($this->table_setting);
        $setting = json_decode(@$setting['Body_Json'],true);

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to codexworld.com');
        $gClient->setClientId($setting['google_client_id']);
        $gClient->setClientSecret($setting['google_secret']);
        $gClient->setRedirectUri(base_url('social/google'));

        $google_oauthV2 = new Google_Oauth2Service($gClient);
        if(isset($_REQUEST['code'])){
            $gClient->authenticate();
            $token = $gClient->getAccessToken();
            $this->session->set_userdata('token', $token);
        }
        if ($this->session->userdata('token')) {
            $gClient->setAccessToken($this->session->userdata('token'));
            $this->session->unset_userdata('token');
        }
        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            $email = strtolower($userProfile['email']);
            $first_name = $userProfile['given_name'];
            $last_name = $userProfile['family_name'];
            if(@$email != null){
                $record = $this->Common_model->get_record($this->table, array('email' => $email));
                if(!(isset($record) && $record != null)){
                    $pk = $this->Common_model->get_record("package",["is_default" => 1]);
                    $num_months = $pk["months"];
                    $arr   = array(
                        'package_id' => $pk["id"],
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'avatar' => '',
                        'pwd' => md5($email . ':' . time()),
                        'status' => 1,
                        'phone' => '',
                        'expired_date' => date('Y-m-d',strtotime('+'.$num_months.' months'))
                    );
                    $id = $this->Common_model->add($this->table, $arr);
                    if($id > 0){
                        if(isset($_COOKIE['user_invite_id']) && $_COOKIE['user_invite_id'] != null){
                            $user_invite_id = @$_COOKIE['user_invite_id'];
                            $where = array(
                                'email'  => $email,
                                'member_id' => $user_invite_id,
                                'status' => 0
                            );
                            $record_invite = $this->Common_model->get_record($this->table_invite,$where);
                            if(@$record_invite != null){
                                $arr  = array(
                                    'member_invite_id' => $id,
                                    'status' => 1
                                );
                                $this->Common_model->update($this->table_invite, $arr,$where);
                            }
                        }
                        $this->Common_model->add("member_package",[
                            "member_id"  => $id ,
                            "package_id" => $pk["id"] ,
                            'created_at' => date('Y-m-d H:i:s'),
                            'start_date' => date('Y-m-d H:i:s'),
                            'expired_at' => date('Y-m-d',strtotime('+'.$num_months.' days'))
                        ]);
                    }
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $email,
                        'id' => $id,
                        'full_name' => $first_name . ' ' . $last_name,
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'avatar' => (@$picture_url != null) ? $picture_url : '/skins/frontend/images/user_default.png',
                        'type' => 0
                    ));
                }
                else{
                    $this->session->set_userdata('is_login', TRUE);
                    $this->session->set_userdata('user_info', array(
                        'email' => $record["email"],
                        'id' => $record["id"],
                        'full_name' => $record["first_name"] . ' ' . $record["last_name"],
                        'first_name' => $record["first_name"],
                        'last_name' => $record["last_name"],
                        'avatar' => (@$record["avatar"] != null) ? $record["avatar"] : '/skins/frontend/images/user_default.png',
                        'type' => @$record['is_premium']
                    ));

                    $this->Common_model->update($this->table,array('status' => 1),array('id' => $record["id"]));
                }
            }
            redirect("/");
        } else {
            $authUrl = $gClient->createAuthUrl();
            redirect($authUrl);
        }
    }

    function curl($url, $post = "") {
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
}