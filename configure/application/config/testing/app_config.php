<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

#slave databases
$config['db_slave_list'] = array('slave');

#redis config
$config['redis']['hostname'] = '127.0.0.1';
$config['redis']['port']     = '6379';


#cookie过期时间
$config['cookie_login_expire_time'] = 60*60*24*30;
//图片服务器认证访,空间名,问有效时间
$config['qiniu_sdk_key'] = array(
									'accessKey' => 'F7xSmP1pp36pvswxn3NvlXHImF_-3eM5-ZZ_UagS',
									'secretKey' => 'GV6ORhMdGxyI7DGw53VXIbwjsu6AnhiNX6vKVKnx',
									'bucket' => 'image',
									'expires' => '600'
								);
#域名
$config['domain'] =	'http://7xj7ce.com1.z0.glb.clouddn.com/';
#存储路径名
$config['user'] = 'user/icon/';
$config['interest'] = 'interest/image/';
$config['post'] = 'post/image/';
$config['banner'] = 'banner/image/'; //广告banner
$config['idy'] = 'idy/image/'; //身份证

$config['domain_url'] = 'http://www.duangniu.com/';