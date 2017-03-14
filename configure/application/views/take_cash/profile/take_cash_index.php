<div class="adm-user">
	<div id="dv_dialog_back" onclick="dialog_close()" class="bg blackroom none"></div>
    <div id="dv_dialog" class="modal-dialog mydiv room ok none"></div>
	<div class="main-box clearfix">
    	<div class="col-lg-1">
	        <select id="from_key" name="from_key" class="form-control">
	            <option value="nc" selected="true">称昵</option>
	            <option value="jb">级别 </option>
	            <option value="nb">牛币 </option>
	            <option value="je">金额</option>
	            <option value="sj">申请时间 </option>
	        </select>
        </div>
		<input id="from_val" name="from_val" type="text" placeholder="搜索" class="form-control adm-search left">
		<a id="take_cash_submit" name="take_cash_submit" href="javascript:void(0);" class="btn btn-default left">搜索</a>
		<div class="cle"></div>
	</div>
	<div class="text-center">
		<h3 id="h_title">申请提现</h3>
		<hr>
	</div>
	<div class="table-res table-responsive clearfix">
		<table id="tb_take_cash_html" class="table table-hover text-left"></table>
	</div>
	<br  />
	<!--<div class="adm-check left">
		<label><input id="check_all" name="check_all" type="checkbox" class="allChecked"><span>全选</span></label>
		<span>选中项：</span>
	</div>
	<label><a onclick="click_active()" href="javascript:void(0);" class="btn btn-primary pull-right"><i class="fa fa-eye fa-lg"></i>无效</a></label>-->
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
		var ajax_url = "<?php echo base_url().'take_cash/top/take_cash_html'?>";
		var from_field = '';
		var by = '';
		take_cash_html(ajax_url, from_field, by);
		$("#take_cash_submit").click(function(){
			take_cash_html(ajax_url, from_field, by);
		});
		$('#from_val').keydown(function(e){
			if(e.keyCode==13){
			   take_cash_html(ajax_url, from_field, by);
			}
		}); 
		$("#check_all").click(function(){
			 if($(this).prop('checked')){
			 	$("#tb_take_cash_html input[type='checkbox']").prop("checked", true);
			 }else{
			 	$("#tb_take_cash_html input[type='checkbox']").prop("checked", false);
			 }
		});
	});
	
	function take_cash_html(post_url, from_field, by){
		$.post(post_url,{from_key:$("#from_key").val(), from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_take_cash_html").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_take_cash_html").append(data['data']['html']);
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
	
	function click_active(){
		var id_s = get_checkbox();
		if(id_s != ''){
			$.post("<?php echo base_url().'take_cash/top/click_active'?>",{id_s:id_s},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE; ?>){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
					if($("#paging li").length > 0){
						$("#paging li").each(function(){
							if($(this).hasClass("active")) {
								take_cash_html($(this).find("a").attr('href'), from_field, by);
							}
						});
					}else{
						take_cash_html("<?php echo base_url().'take_cash/top/take_cash_html'?>", from_field, by);
					}
				}
			},
			"json"
			);
		}
	}
	
	function get_checkbox(){
		var str = [];
		$("#tb_take_cash_html input[type='checkbox']:checked").each(function(){
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