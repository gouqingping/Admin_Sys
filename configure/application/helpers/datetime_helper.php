<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('get_now_time'))
{
    function get_now_time($format = 'Y-m-d H:i:s')
    {
        return date($format);
    }
}

if (!function_exists('get_time_day'))
{
    function get_time_day($day, $format = null)
    {
    	if ($format) {
    		return date($format, strtotime("$day day"));
    	} else {
        	return date('Y-m-d H:i:s', strtotime("$day day"));
    	}
    }
}

if (!function_exists('get_time_month'))
{
    function get_time_month($month, $format = null)
    {
    	if ($format) {
    		return date($format, strtotime("$month month"));
    	} else {
        	return date('Y-m-d H:i:s', strtotime("$month month"));
    	}
    }
}

if (!function_exists('get_time'))
{
    function get_time($second, $format = null)
    {
    	if ($format) {
    		return date($format, strtotime("$second seconds"));
    	} else {
        	return date('Y-m-d H:i:s', strtotime("$second seconds"));
    	}
    }
}

//if (!function_exists('datetime_format'))
//{
//	function datetime_format($time)
//	{
//  	$now_time = get_now_time('Y-m-d');
//  	if (strstr($time, $now_time)) {
//  		return "今天 " .date('H:i:s', strtotime($time)) ;
//  	} else {
//  		return $time;
//  	}
//	}
//}

if (!function_exists('get_time_from_str'))
{
	function get_time_from_str($str, $format)
	{
    	return date($format,strtotime($str));
	}
}

///**
// * 签到日历
// */
//if (!function_exists('calendar'))
//{
//	function calendar($sign_info){
//		$year = get_now_time('Y');   //获得年份, 例如： 2006  
//		$month = get_now_time('n');  //获得月份, 例如： 04  
//		$day = get_now_time('j');    //获得日期, 例如： 3  
//		$first_day = date("w", mktime(0, 0, 0, $month, 1, $year));  //获得当月第一天 
//		$days_in_month = date("t", mktime(0, 0, 0, $month, 1, $year));  //获得当月的总天数
//		$temp_days = $first_day + $days_in_month;   //计算数组中的日历表格数 
//		$weeks_in_month = ceil($temp_days/7);   //算出该月一共有几周(即表格的行数)
//		//创建一个二维数组  
//		$counter=0;
//		for($j = 0; $j < $weeks_in_month; $j ++){  
//		    for($i = 0; $i < 7; $i ++){  
//		        $counter ++;
//		        $week[$j][$i]['val'] = $counter;
//		        $week[$j][$i]['val'] -= $first_day;
//				$week[$j][$i]['is'] = is_sign($sign_info, $week[$j][$i]['val']);
//				if($week[$j][$i]['val'] > $days_in_month || $week[$j][$i]['val'] < 1){
//		    		$week[$j][$i]['val'] = '';
//					$week[$j][$i]['is'] = 'no';
//		        }
//		        if($week[$j][$i]['val'] > $day){
//		        	$week[$j][$i]['is'] = 'no';
//		        }
//		    }  
//		}
//		return $week;
//	}
//}
//
//if(!function_exists('is_sign')){
//	function is_sign($sign_info, $day){
//		foreach($sign_info as $key => $sign){
//			if(get_time_from_str($sign['sign_date'], 'd')==$day){
//				return 'yes';
//			}
//		}
//		return 'no';
//	}
//}
