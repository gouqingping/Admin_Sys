<div class="adm-user">
	<div id="dv_dialog_back" onclick="dialog_close()" class="bg blackroom none"></div>
    <div id="dv_dialog" class="modal-dialog mydiv room ok none"></div>
	<div class="main-box clearfix">
		<input id="from_val" name="from_val" type="text" placeholder="搜索" class="form-control adm-search left">
		<a id="interest_search_submit" name="interest_search_submit" href="javascript:void(0);" class="btn btn-default left">搜索</a>
		<div class="cle"></div>
	</div>
	<div class="text-center">
		<h3 id="h_title">申请中的兴趣</h3>
		<hr>
	</div>
	<div class="table-res table-responsive clearfix">
		<table id="tb_interest_html" class="table table-hover text-left"></table>
	</div>
	<br  />
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
		menu_click($('#menu_interest'));
		var ajax_url = "<?php echo base_url().'interest/profile/interest_apply_html'?>";
		var from_field = '';
		var by = '';
		interest_thml(ajax_url, from_field, by);
		$("#interest_search_submit").click(function(){
			interest_thml("<?php echo base_url().'interest/profile/interest_html'?>", from_field, by);
			$("#h_title").text($("#from_val").val()+' 搜索结果');
		});
		$('#from_val').keydown(function(e){
			if(e.keyCode==13){
			    interest_thml("<?php echo base_url().'interest/profile/interest_html'?>", from_field, by);
				$("#h_title").text($("#from_val").val()+' 搜索结果');
			}
		});
		$("#check_all").click(function(){
			 if($(this).prop('checked')){
			 	$("#tb_interest_html input[type='checkbox']").prop("checked", true);
			 }else{
			 	$("#tb_interest_html input[type='checkbox']").prop("checked", false);
			 }
		});
	});
	
	function interest_thml(post_url, from_field, by){
		$.post(post_url,{from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_interest_html").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_interest_html").append(data['data']['html']);
				$("#paging").append(data['data']['paging']);
				$("#p_page").append('共有'+data['data']['pagcount']+'条记录，每页<?php echo PAGEING_USER_NUM;?>条');
				$("#paging a").bind("click", function(e){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
                	interest_thml($(this).attr('href'), from_field, by);
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
			var post_url = '';
			if(search_type == 'apply'){
				post_url = "<?php echo base_url().'interest/profile/interest_examine'?>";
			}else{
				post_url = "<?php echo base_url().'dark/profile/dark_room_html'?>";
			}
			$.post(post_url,{type:<?php echo TYPE_DARK_ROOM_INTEREST;?>, t_id:t_id},
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
		$("#tb_interest_html input[type='checkbox']:checked").each(function(){
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