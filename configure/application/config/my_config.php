<?php
#cookie过期时间
$config['cookie_login_expire_time'] = 60*60*24*30;

#添加帖子时,缩略图
$config['post_thum_img']= array(
	array(
		'w'=>100, 'h'=>100
	),
	array(
		'w'=>200, 'h'=>200
	)
);

#上传兴趣时,缩略图
$config['interest_thum_img']= array(
    array(
        'w'=>32, 'h'=>32, 'Prefix'=>'s'
    ),
    array(
        'w'=>64, 'h'=>64, 'Prefix'=>''
    ),
    array(
        'w'=>128, 'h'=>128, 'Prefix'=>'l'
    )
);


#举报类型
$config['impeach']= array('1'=>'垃圾广告', '2'=>'侮辱谩骂', '3'=>'色情淫秽', '4'=>'反动政治', '5'=>'暴力暴恐', '6'=>'其它原因');