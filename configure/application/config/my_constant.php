<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['my_constant'] = array();

//网站名
define('SITE_NAME', '牛人网');

//view路径
define('VIEW_PATH', CNGROOT_PATH.'/configure/application/views/');

//平台
define('PLANTFORM_WEB', 1);
define('PLANTFORM_IOS', 2);
define('PLANTFORM_ANDROID', 3);

//返回类型
define('SUCCESS_CODE', 200);
define('NO_DATA', 199);

//性别
define('SECRET',0);
define('MALE', 1);
define('FEMALE', 2);

//app首页banner
define('TYPE_BANNER_URL', 1);//访问html页面
define('TYPE_BANNER_HTML', 2);//访问帖子

//分页显示数量设置
define('PAGEING_USER_NUM', 30);  //用户分页显示数量
define('PAGEING_POST_NUM', 30);  //帖子分页显示数量
define('PAGEING_COMMENT_NUM', 30);  //评论分页显示数量
define('PAGEING_INTEREST_NUM', 30);  //兴趣分页显示数量
define('PAGEING_BANNER_NUM', 30);  //灯箱分页显示数量
define('PAGEING_IMPEACH_NUM', 30);  //投诉分页显示数量
define('PAGEING_GOLD_ORDER_NUM', 30);  //订单分页显示数量
define('PAGEING_WRITER_INFO_NUM', 30);  //认证撰稿人分页数量
define('PAGEING_TAKE_CASH_NUM','30');  //提款分页显示数量

//封禁类型与投诉类型相互关联设置时需保持一致
//封禁类型
define('TYPE_DARK_ROOM_USER', 4);  //封禁用户
define('TYPE_DARK_ROOM_POST', 1);  //封禁帖子
define('TYPE_DARK_ROOM_COMMENT', 2);  //封禁评论
define('TYPE_DARK_ROOM_INTEREST', 3);  //封禁兴趣
//投诉
define('TYPE_IMPEACH_USER', 4);  //投诉用户
define('TYPE_IMPEACH_POST', 1);  //投诉帖子
define('TYPE_IMPEACH_COMMENT', 2);  //投诉评论

//封禁状态
define('DARK_ROOM_STATE_YES', 1);  //正常
define('DARK_ROOM_STATE_NO', 2);  //封禁

//热帖
define('HOT_POST_USER', 1.8);  //重力因子，即将帖子排名往下拉的力量，默认值为1.8，根据需要调整这个值可以控制帖子上升、下降速度
define('HOT_POST_DEN', 2);	//加上2是为了防止最新的帖子导致分母过小
define('HOT_POST_LIMIT', 100);  //获取前多少条热帖

//用户牛币排行
define('RANK_USER', 116); //用户牛币总数排行人数

//推荐兴趣
define('INTEREST_TIME', 0);	//时间间隔(天,0不计算)
define('INTEREST_POST_LIMIT', 200);		//发帖次数最近多的兴趣获取前多少条
define('INTEREST_FAVORITE_LIMIT', 200);	//关注次数最近多的兴趣获取前多少条
define('INTEREST_COMMENT_LIMIT', 200);	//评论次数最近多的兴趣获取前多少条
define('INTEREST_GOLD_LIMIT', 200);		//赞助次数最近多的兴趣获取前多少条

//订单充值类型
define('PAY_TYPE_ALIPAY', 1); //支付宝

//充值订单状态
define('ORDER_STATUS_NOT_PAID', 1); //未付款
define('ORDER_STATUS_PAID', 2); //已付款
//提款订单状态
define('CASH_ORDER_STATUS_FAIL', 1); //失败
define('CASH_ORDER_STATUS_IN_PRESS', 2); //申请中
define('CASH_ORDER_STATUS_SUCCESS', 3); //成功
//牛币收支类别
define('GOLD_TYPE_REFUND',7);//提现退款 注：与前台一致

//申请成为撰稿人步骤设定(2进制存储)
define('WRITER_STEP_1', 1);//协议
define('WRITER_STEP_2', 2);//实名认证审核成功
define('WRITER_STEP_3', 4);//信息绑定
define('WRITER_STEP_4', 8);//实名认证审核失败