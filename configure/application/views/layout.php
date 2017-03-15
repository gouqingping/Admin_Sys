<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="<?php echo $meta['keywords'];?>" />
        <meta name="Description" content="<?php echo $meta['description'];?>" />
        <title><?php echo $meta[ 'title'];?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/todc-bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>css/common.css" />
<?php
foreach($css as $k => $v){
?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/'.$v;?>"/>
<?php
}
?>
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/bootstrap-tab.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/responsive-nav.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/base.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/common.js"></script>
<?php
foreach($javascript as $kj => $vj){ 
?>
        <script type="text/javascript" src="<?php echo base_url().'js/'.$vj;?>"></script>
<?php
}
?>
		<script type="text/javascript">
			$(function(){
				$("#sign_out").click(function(){
					alert();
				});
			});
		</script>
    </head>
    <body>
        <div class="navbar navbar-inverse left">
            <div class="navbar-header">
                <!-- 自适应隐藏导航展开按钮 -->
                <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
                <ul id="ul_menu" class="nav sidebar adm">
                    <h3>后台管理</h3>
                    <br>
                    <li id="menu_panel"><a href="<?php echo base_url().'panel/top/panel_index';?>">面板</a></li>
                    <li id="menu_user"><a href="<?php echo base_url().'user/profile/user_index';?>">用户</a></li>
                    <li id="menu_capacity"><a href="<?php echo base_url().'capacity/top/capacity_index';?>">内容</a></li>
                    <li id="menu_interest"><a href="<?php echo base_url().'interest/profile/interest_index';?>">兴趣</a></li>
                    <li id="menu_banner"><a href="<?php echo base_url().'banner/profile/banner_index';?>">灯箱</a></li>
                    <li id="menu_gold_order"><a href="<?php echo base_url().'order/profile/gold_order_index';?>">牛币</a></li>
                    <li id="menu_writer"><a href="<?php echo base_url().'writer/profile/writer_info_index';?>">认证</a></li>
                    <li id="menu_take_cash"><a href="<?php echo base_url().'take_cash/profile/take_cash_index';?>">打款</a></li>
                    <div class="admin"><span><?php echo $user['nickname'];?></span><br/><a href="<?php echo base_url().'user/account/sign_out';?>">退出</a></div>
                	<div style=" position: relative; bottom:10px; left:10px; top:300px;"><span>版本号:V0.1</span><br/><span>2015-05-25</span></div>
                </ul>
            </div>
        </div>
        <?php echo $content_for_layout;?>
    </body>
</html>