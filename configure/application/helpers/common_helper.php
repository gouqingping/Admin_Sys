<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('user_sex')) {
	function user_sex($sex)
	{
		switch($sex) {
			case MALE:
				return '男';
				break;
			case FEMALE:
				return '女';
				break;
			default:
				return '保密';
		}
	}
}

if (!function_exists('user_status')) {
	function user_status($is_active, $activate)
	{
		switch($is_active) {
			case 0:
				if($activate != ''){
					return '封禁';
				}else{
					return '未激活';
				}
				break;
			default:
				return '正常';
		}
	}
}

if (!function_exists('interest_status')) {
	function interest_status($is_active)
	{
		switch($is_active) {
			case 0:
				return '封禁';
				break;
			case 1:
				return '正常';
				break;
			default:
				return '申请中';
		}
	}
}

if (!function_exists('impeach_status')) {
	function impeach_status($is_active)
	{
		switch($is_active) {
			case 0:
				return '已处理';
				break;
			default:
				return '未处理';
		}
	}
}

if (!function_exists('comment_status')) {
	function comment_status($deleted_at, $is_active)
	{
		switch($is_active) {
			case 0:
				if($deleted_at && $deleted_at != ''){
					return '删除';
				}else{
					return '封禁';
				}
				break;
			default:
				return '正常';
		}
	}
}

if (!function_exists('post_status')) {
	function post_status($deleted_at, $is_active)
	{
		switch($is_active) {
			case 0:
				if($deleted_at && $deleted_at != ''){
					return '删除';
				}else{
					return '封禁';
				}
				break;
			default:
				return '正常';
		}
	}
}

if (!function_exists('gold_order_type')) {
	function gold_order_type($type)
	{
		switch($type) {
			case PAY_TYPE_ALIPAY:
				return '支付宝';
				break;
			default:
				return '无效';
		}
	}
}

if (!function_exists('order_status')) {
	function order_status($status)
	{
		switch($status) {
			case ORDER_STATUS_NOT_PAID:
				return '未付款';
				break;
			case ORDER_STATUS_PAID:
				return '已付款';
		}
	}
}

if (!function_exists('gold_order_status')) {
	function gold_order_status($deleted_at, $is_active)
	{
		switch($is_active) {
			case 0:
				if($deleted_at && $deleted_at != ''){
					return '删除';
				}else{
					return '无效';
				}
				break;
			case 1:
				return '正常';
		}
	}
}

if (!function_exists('impeach_type')) {
	function impeach_type($type)
	{
		$CI =& get_instance();
		$val = $CI->config->item('impeach');
		return $val[$type];
	}
}

if (!function_exists('banner_type')) {
	function banner_type($type)
	{
		switch($type){
			case TYPE_BANNER_HTML:
				return '页面';
			break;
			default:
				return '帖子';
			break;
		}
	}
}

if (!function_exists('banner_status')) {
	function banner_status($is_active)
	{
		switch($is_active){
			case 1:
				return '开启';
			break;
			default:
				return '关闭';
			break;
		}
	}
}

if (!function_exists('error_msg')) {
	function error_msg($errors)
	{
		$string = '';
		foreach ($errors as $error) {
			$string .= '<div class="alert alert-danger error password-news" role="alert">'.
						'<span class="glyphicon glyphicon-info-sign" aria-hidden="true">'. $error .
						'</span></div>';
		}
	    return '<div class="error">' . $string . '</div>';
	}
}

if (!function_exists('get_sort_icon')) {
	function get_sort_icon($from_field, $field_name, $by)
	{
		if($from_field == $field_name){
			if($by == 'a'){
				echo '<img src="'.base_url().'images/sort_asc_icon.png">';
			}elseif($by == 'd'){
				echo '<img src="'.base_url().'images/sort_desc_icon.png">';
			}
		}
	}
}

if (!function_exists('get_pagination_config')) {
	function get_pagination_config()
	{
		$config['next_link'] = '下一页';
		$config['prev_link'] = '上一页';
		$config['first_link'] = '第一页';
		$config['last_link'] = '最后一页';
		$config['cur_tag_open'] = '<li class="active">';
		$config['cur_tag_close'] = '<li>';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';
		
		return $config;
	}
}

if (!function_exists('get_front_url')) {
	function get_front_url($url_key, $key){
		$CI =& get_instance();
	    $url = $CI->config->item('domain_url');
		$key = encrypt_id($key);
		switch($url_key){
			case 'user':
				return $url.'user/profile/site/'.$key;
			break;
			case 'post':
				return $url.'post/profile/index/'.$key;
			break;
			case 'comment':
				return $url.'comment/profile/index/'.$key;
			break;
			case 'interest':
				return $url.'interest/profile/index/'.$key;
			break;
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
			case TYPE_IMPEACH_USER:
				return $url.'user/profile/site/'.$key;
			break;
			case TYPE_IMPEACH_POST:
				return $url.'post/profile/index/'.$key;
			break;
			case TYPE_IMPEACH_COMMENT:
				return $url.'comment/profile/index/'.$key;
			break;
			default:
				return 'javascript:void(0);';
			break;
		}
	}
}

if (!function_exists('get_type_impeach')) {
	function get_type_impeach($type){
		switch($type){
			case TYPE_IMPEACH_USER:
				return '查看用户';
			break;
			case TYPE_IMPEACH_POST:
				return '查看帖子';
			break;
			case TYPE_IMPEACH_COMMENT:
				return '查看评论';
			break;
		}
	}
}

if (!function_exists('encrypt_id')) {
	function encrypt_id($encrypt_id)
	{
		$CI =& get_instance();
		$CI->load->library('xdeode_service');
		return $CI->xdeode_service->encode($encrypt_id);
	}
}
if (!function_exists('decrypt_id')) {
	function decrypt_id($decrypt_id)
	{
		$CI =& get_instance();
		$CI->load->library('xdeode_service');
		return $CI->xdeode_service->decode($decrypt_id);
	}
}

/**
 * 还原img标签
 */
if (!function_exists('revert_img')) {
    function revert_img($str)
    {
        $str = str_replace('&lt;img', '<img', $str);
        $str = str_replace('&gt;', '>', $str);
        $img = get_img_src($str);
        foreach($img[0] as $v) {
            if(strpos($v, 'emotion')===false) {
                $str = str_replace($v, html_encode($v), $str);
            }
        }
        return $str;
    }
}

//是否已经通过撰稿人资格审核
if (!function_exists('is_writer')) {
    function is_writer($step)
    {
        return $step==WRITER_STEP_1+WRITER_STEP_2+WRITER_STEP_3?true:false;
    }
}


//判断申请撰稿人进度(判断是否通过了某个进度)
if (!function_exists('to_be_writer_step')) {
    function to_be_writer_step($step, $step_type)
    {
    	return $step&$step_type;
    }
}
