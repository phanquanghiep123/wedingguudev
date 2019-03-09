<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('slugify'))
{
    function slugify($text)
    { 
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
    }
}
if ( ! function_exists('rename_file')){
    function rename_file($src,$folder,$name){
        $filePath     = $src;
        $fileObj      = new SplFileObject($filePath);
        $name_flie    = explode("/",$name);
        $RandomNum    = uniqid();
        $ImageName    = str_replace(' ', '-', strtolower($name_flie[(count($name_flie)-1)]));
        $ImageType    = explode(".",$name_flie[(count($name_flie)-1)]);
        $ImageType    = $ImageType[(count($ImageType)-1)];
        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
        $ImageExt     = str_replace('.', '', $ImageExt);
        $ImageName    = str_replace("." . $ImageExt, "", $ImageName);
        $ImageName    = preg_replace("/.[[.s]{3,4}$/", "", $ImageName);
        $NewImageName = md5($ImageName).'_'.$RandomNum.'.'.$ImageExt;
        rename($filePath,FCPATH.$folder.$NewImageName);
        return $NewImageName;
    }
}
if ( ! function_exists('crop_image')){
    function crop_image($image,$type,$folder){
        $data=array("status"=>"error",'name'=>'');
        //$folder="/images/avatars/";
        if(isset($_POST['x']) && isset($_POST['y'])){
            $x=intval($_POST['x']);
            $y=intval($_POST['y']);
            $w=intval($_POST['w']);
            $h=intval($_POST['h']);
            $image_w=intval($_POST['image_w']);
            $image_h=intval($_POST['image_h']);
            if($w>0 && $h>0 && $image_w>0 && $image_h>0){
                    $src=".".$folder.$image;
                    $size = getimagesize($src);

                    $w_current = $size[0];
                    $h_current = $size[1];

                    $x *= ($w_current/$image_w);
                    $w *= ($w_current/$image_w);

                    $y *= ($h_current/$image_h);
                    $h *= ($h_current/$image_h);

                    $path = $folder. $image;
                    $dstImg = imagecreatetruecolor($w, $h);
                    $dat = file_get_contents($src);
                    $vImg = imagecreatefromstring($dat);
                    if($type=='png'){                        
                        imagealphablending($dstImg, false);
                        imagesavealpha($dstImg, true);
                        $transparent  = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
                        imagefilledrectangle($dstImg, 0, 0, $w, $h, $transparent);
                        //imagecolortransparent($dstImg, $transparent);
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagepng($dstImg, $src);
                    }
                    else{
                        imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $w, $h, $w, $h);
                        imagejpeg($dstImg, $src);
                    }
                    imagedestroy($dstImg);
                    
                    $src=FCPATH .$folder.$image;
                    $name=rename_file($src,$folder,$image);
                    $data['name']=$name;
                    $data["status"]="success";
            }
        }
        return $data;  
    }
}
if (!function_exists('upload_flie')){
    function upload_flie($upload_path,$allowed_types,$file,$resize = null,$creathumb = null,$max_size = "auto",$max_width="auto",$max_height="auto")
    {
        $ci = & get_instance();
        $data["status"] = "error";
        //config;
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = $allowed_types;
        if($max_size !="auto"){$config['max_size'] = $max_size;}
        if($max_width !="auto"){$config['max_width'] = $max_width;}
        if($max_height !="auto"){$config['max_height'] = $max_height;}
        $type = explode(".", $file['name']);
        $name = $type[0]."_".uniqid().".".$type[1];
        $name = gen_slug_st($name);
        $_FILES['file']['name']     = $name ;
        $_FILES['file']['type']     = $file['type'];
        $_FILES['file']['tmp_name'] = $file['tmp_name'];
        $_FILES['file']['error']    = $file['error'];
        $_FILES['file']['size']     = $file['size'];
        $ci->load->library('upload');
        $ci->upload->initialize($config);
        if (!$ci->upload->do_upload('file'))
        {
            $data["message"] = "Upload process an error please check back";
        }
        else
        {   
            $data["status"] ="success";
            $data["reponse"] = $ci->upload->data();
            if($resize != null){
                $config['image_library']  = 'gd2';
                $config['source_image']   = $data["reponse"]["full_path"];
                $config['maintain_ratio'] = TRUE;
                $config['width']          = @$resize["width"];
                $config['height']         = @$resize["height"];
                $ci->load->library('image_lib', $config);
                $ci->image_lib->clear();
                $ci->image_lib->resize();
            }
            if($creathumb != null){
                $config['source_image']   = $data["reponse"]["full_path"];
                $config['new_image']      = $data["reponse"]["file_path"]."thumbs_".$name;
                $config['maintain_ratio'] = FALSE;
                $config['width']          = $creathumb["width"];
                $config['height']         = $creathumb['height'];
                $config['quality']        = 100;
                $ci->load->library('image_lib', $config);
                $ci->image_lib->clear();
                $ci->image_lib->initialize($config);
                $ci->image_lib->resize();
                $data["reponse"]['name_thumb'] = "thumbs_".$name;
            }
            
        }
        return $data;

    }
}
if (!function_exists('gen_slug_st')){
    function gen_slug_st($str){
        $a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß','à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','û','ü','ý','ÿ','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','Ð','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','?','?','J','j','K','k','L','l','L','l','L','l','?','?','L','l','N','n','N','n','N','n','?','O','o','O','o','O','o','Œ','œ','R','r','R','r','R','r','S','s','S','s','S','s','Š','š','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Ÿ','Z','z','Z','z','Ž','ž','?','ƒ','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','?','?','?','?','?','?');
        $b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a','a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A','a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h','H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N','n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U','u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u','U','u','U','u','U','u','U','u','A','a','AE','ae','O','o');
        return strtolower(preg_replace(array('/[^a-zA-Z0-9,. -]/','/[ -]+/','/^-|-$/'),array('','-',''),str_replace($a,$b,$str)));
    }
}
if (!function_exists('ratio_image')){
   function ratio_image($original_width, $original_height, $new_width = 0, $new_heigh = 0) {
        $size['width'] = $new_width;
        $size['height'] = $new_heigh;
        if ($new_heigh != 0) {
            $size['width'] = intval(($original_wdith / $original_height) * $new_height);
        }
        if ($new_width != 0) {
            $size['height'] = intval(($original_height / $original_width) * $new_width);
        }

        return $size;
    }
}

if (!function_exists('sendmail')) {
    function sendmail($to, $subject, $content, $other = null) {
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['mailtype'] = 'html';
        $config['charset'] = 'utf-8';
        $config['wordwrap'] = TRUE;
        $config['newline'] = "\r\n";
        $ci = & get_instance();
        $ci->load->library('email');
        $ci->email->set_mailtype("html");
        $ci->email->from('noreply@weddingguu.com', 'weddingguu.com');
        $ci->email->to($to);
        if ($other != null && $other != '') {
            $ci->email->bcc($other);
        } 
        $ci->email->subject($subject);
        $ci->email->message($content);
        @$ci->email->send();
    }
}
if (!function_exists('getonlineusers')) {
    function getonlineusers(){ 
        $MAX_IDLE_TIME = 1;
        $table = 'ewd_user_online';
        $count = 0; 
        $total = 0;
        $ci = & get_instance();
        if ($directory_handle = opendir(SYSDIR.'/cache')) { 
            while ( false !== ( $file = @readdir( $directory_handle ) ) ) { 
                if($file != '.' && $file != '..'){ 
                    $time = @fileatime(SYSDIR . '/cache/' . $file);
                    if(time()- $time < $MAX_IDLE_TIME * 60) { 
                        $record = $ci->Common_model->get_record($table,array('session_id' => $file));
                        if(@$record == null){
                            $arr = array(
                                'session_id' => $file,
                                'created_at' => date('Y-m-d H:i:s')
                            );
                            $ci->Common_model->add($table,$arr);
                        }
                        $count++; 
                    }
                }
            } 
            @closedir($directory_handle);
        }
        $total = $ci->Common_model->count_table($table);
        $arr = array(
            'count' => $count,
            'total' => $total
        );
        return $arr; 
    }
}

if (!function_exists('create_select')) {
    function create_select ($arg,$key="ID",$value="Name",$active = false){
        $html = '<option value="">-- Vui lòng chọn --</option>';
        foreach ($arg as $key_arg => $value_arg) {
            if($active == $value_arg[$key])
                $html .='<option value="'.$value_arg[$key].'" selected>'.$value_arg[$value].'</option>';
            else
                $html .='<option value="'.$value_arg[$key].'">'.$value_arg[$value].'</option>';
            
        }
        return $html;
    }
}
function get_lat_long($address)
{
    $url = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&sensor=false';
    $ch  = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    $data = curl_exec($ch);
    curl_close($ch);
    $locations = array('lat' => 0, 'lng' => 0);
    $geo = json_decode($data, true);
    if ($geo['status'] == 'OK') {
        $locations['lat'] = $geo['results'][0]['geometry']['location']['lat'];
        $locations['lng'] = $geo['results'][0]['geometry']['location']['lng'];
    }
    return $locations;
}

function _get_paging($array_init) {
    $config                = array();
    $config["base_url"]    = $array_init["base_url"];
    $config["total_rows"]  = $array_init["total_rows"];
    $config["per_page"]    = $array_init["per_page"];
    $config["uri_segment"] = $array_init["segment"];
    if(isset($array_init['page_query_string']) && $array_init['page_query_string']){
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'offset';
    }
    $config['full_tag_open'] = '<ul class="pagination">';
    $config['full_tag_close'] = '</ul><!--pagination-->';
    $config['first_link'] = 'Prev «';
    $config['first_tag_open'] = '<li class="prev page">';
    $config['first_tag_close'] = '</li>';
    $config['last_link'] = 'Next »';
    $config['last_tag_open'] = '<li class="next page">';
    $config['last_tag_close'] = '</li>';
    $config['next_link'] = '<span aria-hidden="true">»</span>';
    $config['next_tag_open'] = '<li class="next page">';
    $config['next_tag_close'] = '</li>';
    $config['prev_link'] = '<span aria-hidden="true">«</span>';
    $config['prev_tag_open'] = '<li class="prev page">';
    $config['prev_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li class="active"><a href="">';
    $config['cur_tag_close'] = '</a></li>';
    $config['num_tag_open'] = '<li class="page">';
    $config['num_tag_close'] = '</li>';
    return $config;
}