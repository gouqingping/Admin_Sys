<div class="adm-user">
    <div id="dv_dialog_back" onclick="dialog_close()" class="bg blackroom none"></div>
    <div id="dv_dialog" class="modal-dialog operation none"></div>
    <div class="main-box clearfix">
    	<div class="col-lg-1">
	        <select id="from_key" name="from_key" class="form-control">
	            <option value="nc" selected="true">称昵</option>
	            <option value="yx">邮箱</option>
	            <option value="jj">简介</option>
	            <option value="ip">注册IP</option>
	            <option value="sj">注册日期</option>
	            <option value="fj">状态</option>
	        </select>
        </div>
        <input id="from_val" name="from_val" type="text" placeholder="搜索" class="form-control adm-search left">
        <a id="user_search_submit" name="user_search_submit" href="javascript:void(0);" class="btn btn-default left">搜索</a>
        <div class="cle"></div>
    </div>
    <div class="text-center">
        <h3>用户中心</h3>
        <hr>
    </div>    
    <div class="table-res table-responsive clearfix">
        <table id="tb_user_html" class="table table-hover"></table>
    </div>
    <br />
    <div class="adm-check left">
        <label><input id="check_all" name="check_all" type="checkbox" class="allChecked"><span>全选</span></label>
        <span>选中项：</span>
    </div>
    <label><a onclick="show_dark_room_thml();" href="javascript:void(0);" class="btn btn-primary pull-right"><i class="fa fa-eye fa-lg"></i>小黑屋</a></label>
    <div class="cle"></div>
    <div class="right">
    	<p id="p_page" class="right"></p>
    	<br />
    	<ul id="paging" name="paging" class="pagination right"></ul>
    </div>
    <div class="cle"></div>
</div>
<script type="text/javascript">
	$(function(){
		menu_click($('#menu_user'));
		var ajax_url = "<?php echo base_url().'user/profile/user_search_html'?>";
		var from_field = '';
		var by = '';
		user_search_html(ajax_url, from_field, by);
		$("#user_search_submit").click(function(){
			user_search_html(ajax_url, from_field, by);
		});
		$('#from_val').keydown(function(e){
			if(e.keyCode==13){
			   user_search_html(ajax_url, from_field, by);
			}
		}); 
		$("#check_all").click(function(){
			 if($(this).prop('checked')){
			 	$("#tb_user_html input[type='checkbox']").prop("checked", true);
			 }else{
			 	$("#tb_user_html input[type='checkbox']").prop("checked", false);
			 }
		});
		$("#from_key").change(function(){
			var placeholder = $(this).val();
			if(placeholder=='nc'){
				placeholder = '输入昵称搜索';
			}else if(placeholder == 'yx'){
				placeholder = '输入邮箱搜索';
			}else if(placeholder == 'jj'){
				placeholder = '输入简介搜索';
			}else if(placeholder == 'ip'){
				placeholder = '格式如：127.0.0.1';
			}else if(placeholder == 'sj'){
				placeholder = '格式如：2015-01-01';
			}else if(placeholder == 'fj'){
				placeholder = '未激活,封禁,正常';
			}
			$("#from_val").attr('placeholder', placeholder);
		});
	});
	
	function user_search_html(post_url, from_field, by){
		$.post(post_url,{from_key:$("#from_key").val(), from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_user_html").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_user_html").append(data['data']['html']);
				$("#paging").append(data['data']['paging']);
				$("#p_page").append('共有'+data['data']['pagcount']+'条记录，每页<?php echo PAGEING_USER_NUM;?>条');
				$("#paging a").bind("click", function(e){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
                	user_search_html($(this).attr('href'), from_field, by);
               		e.preventDefault();
        		});
			}
		},
		"json"
		);
	}
	
	function show_user_info_html(user_id, e){
		e.stopPropagation();
		$.post("<?php echo base_url().'user/profile/user_info_html'?>",{user_id:user_id},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#dv_dialog").html("");
				$("#dv_dialog").append(data['data']['html']);
				$("#dv_dialog_back").show();
				$("#dv_dialog").show();
			}
		},
		"json"
		);
	}
	
	function show_dark_room_thml(){
		var t_id = get_checkbox();
		if(t_id != ''){
			$.post("<?php echo base_url().'dark/profile/dark_room_html'?>",{type:<?php echo TYPE_DARK_ROOM_USER;?>, t_id:t_id},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE; ?>){
					$("#dv_dialog").html("");
					$("#dv_dialog").append(data['data']['html']);
					$("#dv_dialog_back").show();
					$("#dv_dialog").show();
				}
			},
			"json"
			);
		}
	}
	
	function get_checkbox(){
		var str = [];
		$("#tb_user_html input[type='checkbox']:checked").each(function(){
			str.push($(this).val());
		});
		return str;
	}
	
	function dialog_close(){
		$("#dv_dialog").html("");
		$("#dv_dialog_back").hide();
		$("#dv_dialog").hide();
	}
</script>