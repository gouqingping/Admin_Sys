<div class="modal-ok rel">
    <div class="animate">
        <div class="offno">
            <span class="black">审核</span>
        </div>
    </div>
    <div class="col-md-12">
	    <div class="offno">
	        <span class="black"><?php echo $examine;?><span>
	    </div>
	    <div class="details">
	        <div class="col-md-3">处理方式:</div>
	        <div class="col-lg-9">
	            <select id="examine" name="examine" class="form-control">
	            	<option value="no" selected="true">审核拒绝</option>
	                <option value="yes">审核通过</option>
	            </select>
	        </div>
	        <div class="cle">
	        </div>
	    </div>
	    <br>
	    <div class="offno">
	        <a class="btn btn-primary btn_save" href="javascript:void(0);">保存并关闭</a>
	        <a class="btn btn-default dialog_close" href="javascript:void(0);">关闭</a>
	    </div>
	    <br>
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
	    
		$(".btn_save").click(function(){
			var t_id = get_checkbox();
			//审核保存
			$.post("<?php echo base_url().'interest/profile/interest_examine_save'?>",{t_id:t_id,examine:$('#examine').val()},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE;?>){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
					if($("#paging li").length > 0){
						$("#paging li").each(function(){
							if($(this).hasClass("active")) {
								interest_thml($(this).find("a").attr('href'), from_field, by);
							}
						});
					}else{
						interest_thml("<?php echo base_url().'interest/profile/interest_apply_html'?>", from_field, by);
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