<div class="modal-ok">
    <div class="animate">
        <div class="offno">
            <span class="black">封禁</span>
        </div>
    </div>
    <div class="col-md-12">
<?php
if($is_mu == true){
?>
    <div class="details">
        <div class="col-md-3">封停日期:</div>
        <div class="col-md-9"><?php echo get_now_time('y-m-d');?></div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">封停时长:</div>
        <div class="col-lg-9">
        	<select id="dark_day" name="dark_day" class="form-control">
                <option value="1">1天</option>
                <option value="3">3天</option>
                <option value="5">5天</option>
                <option value="7">7天</option>
                <option value="30">30天</option>
                <option value="100">100天</option>
                <option value="0">永久</option>
                <option value="relieve" selected="true">解封</option>
            </select>
        </div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">解封日期:</div>
        <div id="relieve_time" class="col-md-9">无</div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">封禁人:</div>
        <div class="col-md-9"><?php echo $user;?></div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">原因:</div>
        <div class="col-md-9">
            <textarea class="text-div" id="txt_explain"></textarea>
        </div>
        <div class="cle"></div>
    </div>
    <div class="offno">
        <a class="btn btn-primary btn_save" href="javascript:void(0);">保存并关闭</a>
        <a class="btn btn-default dialog_close" href="javascript:void(0);">关闭</a>
    </div>
<?php
}else{
?>
    <div class="details">
        <div class="col-md-3">封停日期:</div>
        <div class="col-md-9"><?php echo get_now_time('Y-m-d');?></div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">封停时长:</div>
        <div class="col-lg-9">
        	<select id="dark_day" name="dark_day" class="form-control">
                <option value="1">1天</option>
                <option value="3">3天</option>
                <option value="5">5天</option>
                <option value="7">7天</option>
                <option value="30">30天</option>
                <option value="100">100天</option>
                <option value="0">永久</option>
                <option value="relieve" selected="true">解封</option>
            </select>
        </div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">解封日期:</div>
        <div id="relieve_time" class="col-md-9">无</div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">封禁人:</div>
        <div class="col-md-9"><?php echo $user;?></div>
        <div class="cle"></div>
    </div>
    <div class="details">
        <div class="col-md-3">原因:</div>
        <div class="col-md-9">
            <textarea class="text-div" id="txt_explain"></textarea>
        </div>
        <div class="cle"></div>
    </div>
    <br>
    <div class="overflow">
<?php
	foreach($user_dark as $dark => $room){
?>
	<div class="info-details">
        <div class="details">
            <div class="col-md-3 list"><?php echo $room['apply_user'];?></div>
            <div class="col-md-5"><?php echo get_time_from_str($room['dark_begin_time'],'Y-m-d');?>&nbsp;封停<?php echo $room['dark_day']==0?'永久':$room['dark_day'].'天';?></div>
            <div class="col-md-3"><?php echo $room['dark_explain'];?></div>
            <div class="cle"></div>
        </div>
<?php
		if($room['accept_user']!==''){
?>
        <div class="details">
            <div class="col-md-3"><?php echo $room['accept_user'];?></div>
            <div class="col-md-5"><?php echo get_time_from_str($room['relieve_time'],'Y-m-d');?>&nbsp;解封</div>
            <div class="col-md-3"><?php echo $room['relieve_explain'];?></div>
            <div class="cle"></div>
        </div>

<?php
		}
?>
	</div>
<?php
	}
?>
    </div>
    <div class="offno">
        <a class="btn btn-primary btn_save" href="javascript:void(0);">保存并关闭</a>
        <a class="btn btn-default dialog_close" href="javascript:void(0);">关闭</a>
    </div>
<?php
}
?>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		$(".animate").mousedown(function(e){
	        $(this).css("cursor","move");//改变鼠标指针的形状
	        var offset = $(this).offset();//DIV在页面的位置
	        var x = e.pageX - offset.left;//获得鼠标指针离DIV元素左边界的距离
	        var y = e.pageY - offset.top;//获得鼠标指针离DIV元素上边界的距离
	        //绑定鼠标的移动事件，因为光标在DIV元素外面也要有效果，所以要用doucment的事件，而不用DIV元素的事件
	        $(document).bind("mousemove",function(ev){
	            $(".modal-ok").stop();//加上这个之后
	            var _x = ev.pageX - x;//获得X轴方向移动的值
	            var _y = ev.pageY - y;//获得Y轴方向移动的值
	            $(".modal-ok").animate({left:_x+"px",top:_y+"px"},0);
	        });
	    });
	    
	    $(document).mouseup(function(){
	        $(".animate").css("cursor","default");
	        $(this).unbind("mousemove");
	    });
		
		$("#dark_day").change(function(){
			if($(this).val()=='relieve'){
				 $("#relieve_time").html('无');
			}else{
				if($(this).val()==0){
					 $("#relieve_time").html('永久');
				}else{
					$.post("<?php echo base_url().'dark/profile/get_day'?>",{dark_day:$(this).val()},
					function(data){
						if(data['code'] == <?php echo SUCCESS_CODE;?>){
							$("#relieve_time").html(data['data']['day']);
						}
					},
					"json"
					);
				}
			}
		});
		
		$(".btn_save").click(function(){
			$("#check_all").prop("checked", false);
			var t_id = get_checkbox();
			var dark_day = $("#dark_day").val();
			var explain = $("#txt_explain").val();
			var type = <?php echo $type;?>;
			//保存封禁信息
			$.post("<?php echo base_url().'dark/profile/dark_save'?>",{type:type,t_id:t_id, dark_day:dark_day, explain:explain},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE;?>){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
					if($("#paging li").length > 0){
						$("#paging li").each(function(){
							if($(this).hasClass("active")) {
								if(type == <?php echo TYPE_DARK_ROOM_USER;?>){
									user_search_html($(this).find("a").attr('href'), from_field, by);
								}else if(type == <?php echo TYPE_DARK_ROOM_POST;?>){
									capacity_thml($(this).find("a").attr('href'), from_field, by);
								}else if(type == <?php echo TYPE_DARK_ROOM_COMMENT;?>){
									capacity_thml($(this).find("a").attr('href'), from_field, by);
								}else if(type == <?php echo TYPE_DARK_ROOM_INTEREST;?>){
									interest_thml($(this).find("a").attr('href'), from_field, by);
								}
							}
						});
					}else{
						if(type == <?php echo TYPE_DARK_ROOM_USER;?>){
							user_search_html("<?php echo base_url().'user/profile/user_search_html'?>", from_field, by);
						}else if(type == <?php echo TYPE_DARK_ROOM_POST;?>){
							capacity_thml("<?php echo base_url().'post/profile/post_html'?>", from_field, by);
						}else if(type == <?php echo TYPE_DARK_ROOM_COMMENT;?>){
							capacity_thml("<?php echo base_url().'comment/profile/comment_html'?>", from_field, by);
						}else if(type == <?php echo TYPE_DARK_ROOM_INTEREST;?>){
							interest_thml("<?php echo base_url().'interest/profile/interest_html'?>", from_field, by);
						}
					}
					dialog_close();
				}
			},
			"json"
			);
		});
		
		$(".dialog_close").click(function(){
			dialog_close();
		});
	});
</script>