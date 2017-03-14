<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 获取图片地址
 */
if (!function_exists('service_image')){
	function service_image($icon, $type, $size = ''){
		if($icon != '' && $icon != 'head.png'){
			$CI =& get_instance();
			$service_url = $CI->config->item($type);
			$domain = $CI->config->item('domain');
	    	return $domain . $service_url . $size . $icon;
		}else if($icon == 'head.png'){
			return base_url() . 'images/user/icon/'. $icon;
		}else{
			return base_url() . 'images/user/icon/'. $size .'default.png';
		}
	}
}

/**
 * 获取网站图片地址
 */
if (!function_exists('web_image')){
	function web_image($img, $route=''){
		$CI =& get_instance();
		$domain = $CI->config->item('domain_url');
    	return $domain . $route . $img;
	}
}

if (!function_exists('sex_icon'))
{
	function sex_icon($sex){
		if (MALE == $sex) {
	    	return base_url() . 'images/male.png';
		} else {
			return base_url() . 'images/female.png';
		}
	}
}