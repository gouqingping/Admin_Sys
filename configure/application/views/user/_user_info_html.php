<div class="modal-ok">
    <div class="animate">
        <div class="neme">
            <div class="photo-img left">
                <img src="<?php echo service_image($user['icon'], 'user', 's');?>">
            </div>
            <h5 class="left">
                <?php echo $user['nickname'];?>
            </h5>
            <div class="cle">
            </div>
        </div>
    </div>
	    <div class="col-md-12">
	    <div class="details">
	        <div class="col-md-3">ID:</div>
	        <div class="col-md-9">
	            <?php echo $user['id'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">邮箱:</div>
	        <div class="col-md-9">
	            <?php echo $user['email'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">平台:</div>
	        <div class="col-md-9">
	            <?php echo from_string_format($user['platform']);?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">性别:</div>
	        <div class="col-md-9">
	            <?php echo user_sex($user['sex']);?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">注册IP:</div>
	        <div class="col-md-9">
	            <?php echo $user['regist_ip'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">地址:</div>
	        <div class="col-md-9">
	            <?php echo $user['address'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">个性网址:</div>
	        <div class="col-md-9">
	            http://niuniu.com/<?php echo $user['weburl'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">注册时间:</div>
	        <div class="col-md-9">
	            <?php echo $user['created_at'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">最后登陆:</div>
	        <div class="col-md-9">
	            <?php echo $user['last_login_at'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">牛币:</div>
	        <div class="col-md-9">
	            <?php echo $user['gold'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">发帖数:</div>
	        <div class="col-md-9">
	            <?php echo $user['p_num'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">状态:</div>
	        <div class="col-md-9 <?php echo $user['is_active']==0?'red':'green'?>">
	            <?php echo user_status($user['is_active'], $user['is_activate']);?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="details">
	        <div class="col-md-3">介绍:</div>
	        <div class="col-md-9">
	           <?php echo $user['profile'];?>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <div class="neme">
	        <a class="btn btn-default dialog_close" onclick="dialog_close();" href="javascript:void(0);">关闭</a>
	    </div>
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
	    
		$(".dialog_close").click(function(){
			dialog_close();
		});
	});
</script>