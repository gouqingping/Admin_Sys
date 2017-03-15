<div class="adm-user">
    <div id="dv_dialog_back" onclick="dialog_close()" class="bg blackroom none"></div>
    <div id="dv_dialog" class="modal-dialog mydiv room ok none"></div>
    <div class="main-box clearfix">
    	<div class="col-lg-1">
	        <select id="from_key" name="from_key" class="form-control">
	            <option value="impeach" selected="true">投诉</option>
	            <option value="comment">评论</option>
	            <option value="post">帖子</option>
	        </select>
       </div>
        <input id="from_val" name="from_val" type="text" placeholder="搜索" class="form-control adm-search left">
        <a id="capacity_search_submit" name="capacity_search_submit" href="javascript:void(0);" class="btn btn-default left">搜索</a>
        <div class="cle"></div>
    </div>
    <div class="text-center">
        <h3 id="h_title">投诉中心</h3>
        <hr>
    </div>
    <div class="table-res table-responsive clearfix">
        <table id="tb_capacity_html" class="table table-hover text-left"></table>
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
		var ajax_url = "<?php echo base_url().'impeach/profile/impeach_html';?>";
		var from_field = '';
		var by = '';
		menu_click($('#menu_capacity'));
		capacity_thml(ajax_url, from_field, by);
		$("#capacity_search_submit").click(function(){
			switch($('#from_key').val()){
				case 'comment':
					$('#h_title').html('评论管理');
					ajax_url = "<?php echo base_url().'comment/profile/comment_html';?>";
				break;
				case 'post':
					$('#h_title').html('帖子管理');
					ajax_url = "<?php echo base_url().'post/profile/post_html';?>";
				break;
				default:
					$('#h_title').html('投诉中心');
					ajax_url = "<?php echo base_url().'impeach/profile/impeach_html';?>";
				break;
			}
			capacity_thml(ajax_url, from_field, by);
		});
		$('#from_val').keydown(function(e){
			if(e.keyCode==13){
				switch($('#from_key').val()){
				case 'comment':
					$('#h_title').html('评论管理');
					ajax_url = "<?php echo base_url().'comment/profile/comment_html';?>";
				break;
				case 'post':
					$('#h_title').html('帖子管理');
					ajax_url = "<?php echo base_url().'post/profile/post_html';?>";
				break;
				default:
					$('#h_title').html('投诉中心');
					ajax_url = "<?php echo base_url().'impeach/profile/impeach_html';?>";
				break;
				}
				capacity_thml(ajax_url, from_field, by);
			}
		});
		$("#check_all").click(function(){
			 if($(this).prop('checked')){
			 	$("#tb_capacity_html input[type='checkbox']").prop("checked", true);
			 }else{
			 	$("#tb_capacity_html input[type='checkbox']").prop("checked", false);
			 }
		});
	});
	
	function capacity_thml(ajax_url, from_field, by){
		$.post(ajax_url,{from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_capacity_html").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_capacity_html").append(data['data']['html']);
				$("#paging").append(data['data']['paging']);
				$("#p_page").append('共有'+data['data']['pagcount']+'条记录，每页<?php echo PAGEING_USER_NUM;?>条');
				$("#paging a").bind("click", function(e){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
                	capacity_thml($(this).attr('href'), from_field, by);
               		e.preventDefault();
        		});
			}
		},
		"json"
		);
	}

	function show_dark_room_thml(){
		var t_id = get_checkbox();
		if(t_id != ''){
			var post_url = '';
			var type = 0;
			switch(search_type){
				case 'comment':
					post_url = "<?php echo base_url().'dark/profile/dark_room_html'?>";
					type = <?php echo TYPE_DARK_ROOM_COMMENT;?>;
				break;
				case 'post':
					post_url = "<?php echo base_url().'dark/profile/dark_room_html'?>";
					type = <?php echo TYPE_DARK_ROOM_POST;?>;
				break;
				default:
					post_url = "<?php echo base_url().'impeach/profile/impeach_processing_html'?>";
					type = 0;
				break;
			}
			$.post(post_url,{type:type, t_id:t_id},
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
		
	function get_checkbox(){
		var str = [];
		$("#tb_capacity_html input[type='checkbox']:checked").each(function(){
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