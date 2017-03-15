<div class="adm-user">
    <div class="row">
        <div class="col-xs-6 col-sm-3">
            <div class="panel panel-dark panel-colorful">
                <div class="panel-body text-center">
                    <p class="text-uppercase mar-btm text-sm"  title="当天新增用户"><?php echo $user['day_sum'];?></p>
                    <img src="<?php echo base_url();?>images/yh.png">
                    <hr>
                    <p class="h2 text-thin" title="总用户"><?php echo $user['sum'];?></p>
                    <small><span title="当天新增用户/当月平均每天新增用户" class="text-semibold"><?php echo '今日平均增长用户'.$user['per'];?>%</span></small>
                </div>
            </div>
            <div class="main_none">
                <span>历史数据查询</span>
                <a class="top_bold" href="javascript:void(0);">前一月</a>
                <a class="bot_bold" href="javascript:void(0);">后一月</a>
                <a class="this_bold" href="javascript:void(0);">当前月</a>
            </div>
            <div id="user_table" class="this_month panel-dark"></div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="panel panel-danger panel-colorful">
                <div class="panel-body text-center">
                    <p class="text-uppercase mar-btm text-sm" title="当天新增帖子"><?php echo $post['day_sum'];?></p>
                    <img src="<?php echo base_url();?>images/tz.png">
                    <hr>
                    <p class="h2 text-thin" title="总帖子"><?php echo $post['sum'];?></p>
                    <small><span title="当天新增帖子/当月平均每天新增帖子" class="text-semibold"><?php echo '今日平均增长帖子'.$post['per'];?>%</span></small>
                </div>
            </div>
            <div class="main_none"><span>&nbsp;</span></div>
            <div id="post_table" class="this_month panel-danger"></div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="panel panel-primary panel-colorful">
                <div class="panel-body text-center">
                    <p class="text-uppercase mar-btm text-sm" title="当天新增评论"><?php echo $comment['day_sum'];?></p>
                    <img src="<?php echo base_url();?>images/hf.png">
                    <hr>
                    <p class="h2 text-thin" title="总评论"><?php echo $comment['sum'];?></p>
                    <small><span title="当天新增评论/当月平均每天新增评论" class="text-semibold"><?php echo '今日平均增长评论'.$comment['per'];?>%</span></small>
                </div>
            </div>
            <div class="main_none"><span>&nbsp;</span></div>            
            <div id="comment_table" class="this_month panel-primary"></div>
          </div>
        <div class="col-xs-6 col-sm-3">
            <div class="panel panel-orange panel-colorful">
                <div class="panel-body text-center">
                    <p class="text-uppercase mar-btm text-sm" title="当天新增兴趣"><?php echo $interest['day_sum'];?></p>
                    <img src="<?php echo base_url();?>images/xq.png">
                    <hr>
                    <p class="h2 text-thin" title="总兴趣"><?php echo $interest['sum'];?></p>
                    <small><span title="当天新增兴趣/当月平均每天新增兴趣" class="text-semibold"><?php echo '今日平均增长兴趣'.$interest['per'];?>%</span></small>
                </div>
            </div>
            <div class="main_none">
                <span>&nbsp;</span>
                <a class="right" href="javascript:void(0);">收起</a>
            </div>
            <div id="interest_table" class="this_month panel-orange"></div>
        </div>
        <div class="cle"></div>
        <div class="main-box clearfix">
            <span>历史数据查询</span>
            <a class="top_bold" href="javascript:void(0);">前一月</a>
            <a class="bot_bold" href="javascript:void(0);">后一月</a>
            <a class="this_bold" href="javascript:void(0);">当前月</a>
            <a class="right month_close" href="javascript:void(0);">收起</a>
            <hr>
        </div>
    </div>
    <h3>今日热门</h3>
    <hr>
    <div class="row">
        <div class="col-xs-6">
            <div class="table-res table-responsive clearfix">
                <?php echo $post_html;?>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="table-res table-responsive clearfix">
                <?php echo $interest_html;?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	var current_month = 0;
	var month = 0;
	$(function(){
		menu_click($('#menu_panel'));
		index_table_html(current_month);
		$('.this_month').hide();
		$('.main_none').hide();
		$('.bot_bold').hide();
		$('.right').hide();
		
		//收起
		$('.right').click(function(){
			month = current_month;
			$('.this_month').hide(300);
			$('.main_none').hide(300);
			$('.bot_bold').hide(300);
			$('.right').hide(300);
			$('.top_bold').css('font-weight','100');
			$('.bot_bold').css('font-weight','100');
			$('.this_bold').css('font-weight','100');
		});
		
		//当前月
		$('.this_bold').click(function(){
			$('.this_month').show(300);
			$('.main_none').show(300);
			$('.bot_bold').hide(300);
			$('.right').show();
			month = current_month;
			index_table_html(current_month);
			$('.top_bold').css('font-weight','100');
			$('.bot_bold').css('font-weight','100');
			$('.this_bold').css('font-weight','bold');
		});
		
		//后一月
		$('.bot_bold').click(function(){
			month--;
			index_table_html(month);
			if(month == 1){
				$('.bot_bold').hide();
			}
			$('.top_bold').css('font-weight','100');
			$('.bot_bold').css('font-weight','bold');
			$('.this_bold').css('font-weight','100');
		});
		
		//前一月
		$('.top_bold').click(function(){
			month++;
			index_table_html(month);
			$('.this_month').show(300);
			if(month > 1){
				$('.bot_bold').show();
			}
			$('.main_none').show();
			$('.right').show();
			$('.top_bold').css('font-weight','bold');
			$('.bot_bold').css('font-weight','100');
			$('.this_bold').css('font-weight','100');
		});
	});
	
	function index_table_html(date_val){
		$.post("<?php echo base_url().'panel/top/index_table_html'?>",{date_key:date_val},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#user_table").html(data['data']['user_table_html']);
				$("#post_table").html(data['data']['post_table_html']);
				$("#comment_table").html(data['data']['comment_table_html']);
				$("#interest_table").html(data['data']['interest_table_html']);
			}
		},
		"json"
		);
	}
</script>