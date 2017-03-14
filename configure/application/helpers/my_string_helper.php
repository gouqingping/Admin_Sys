<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('set_password'))
{
    function set_password($password)
    {
        return md5(md5($password));
    }
}

if (!function_exists('from_string_format'))
{
    function from_string_format($platform)
    {
        switch ($platform) {
        	case PLANTFORM_IOS:
        		return 'iPhone客户端';
        		break;
        	case PLANTFORM_ANDROID:
        	return 'andriod客户端';
        		break;
        	default:
        		return SITE_NAME;
        }
    }
}

if(!function_exists('cut_str')){
	function cut_str($str, $lenth, $replace='...'){
		$string = replace_all_html($str);
		$_lenth = mb_strlen($string, "utf-8");
		if($_lenth <= $lenth){
	        return $string;
	    }else{
	    	return mb_substr($string, 0, $lenth).$replace;
	    }
	}
}

if(!function_exists('replace_all_html')){
	function replace_all_html($str) {
		return preg_replace('/<[^>]+>/','',$str);
	}
}

if(!function_exists('text_html_str')){
	function text_html_str($s_str,$r_str,$str){
		$ren = preg_replace('/'.$s_str.'/','<span class="violet">'.$r_str.'</span>',$str,1);
		return $ren;
	}
}

if(!function_exists('get_img_src')){
	function get_img_src($data, $only_one = false) {
		if ($only_one) {
			preg_match('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg\|\.png]))[\'|\"].*?[\/]?>/i', $data, $mat);
		} else {
			preg_match_all('/<img.*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/i', $data, $mat);
		}
		return $mat;
	}
}

if(!function_exists('check_url')){
	function check_url($url){
		if(!preg_match('/http:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is',$url)){
        	return false;
		}
    	return true;
	}
}
