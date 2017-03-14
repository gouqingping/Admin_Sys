<div class="adm-user">
	<div id="dv_dialog_back" onclick="dialog_close()" class="bg blackroom none"></div>
    <div id="dv_dialog" class="modal-dialog mydiv room ok none"></div>
	<div class="main-box clearfix">
    	<div class="col-lg-1">
	        <select id="from_key" name="from_key" class="form-control">
	            <option value="nc" selected="true">称昵</option>
	            <option value="dzbh">订单编号</option>
	            <option value="czbh">充值编号</option>
	        </select>
        </div>
		<input id="from_val" name="from_val" type="text" placeholder="搜索" class="form-control adm-search left">
		<a id="gold_order_submit" name="gold_order_submit" href="javascript:void(0);" class="btn btn-default left">搜索</a>
		<div class="cle"></div>
	</div>
	<div class="text-center">
		<h3 id="h_title">牛币充值订单信息</h3>
		<hr>
	</div>
	<div class="table-res table-responsive clearfix">
		<table id="tb_gold_order_html" class="table table-hover text-left"></table>
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
		menu_click($('#menu_gold_order'));
		var ajax_url = "<?php echo base_url().'order/top/gold_order_html'?>";
		var from_field = '';
		var by = '';
		gold_order_html(ajax_url, from_field, by);
		$("#gold_order_submit").click(function(){
			gold_order_html(ajax_url, from_field, by);
			$("#h_title").text($("#from_val").val()+' 搜索结果');
		});
		$('#from_val').keydown(function(e){
			if(e.keyCode==13){
			    gold_order_html(ajax_url, from_field, by);
				$("#h_title").text($("#from_val").val()+' 搜索结果');
			}
		});
		$("#check_all").click(function(){
			 if($(this).prop('checked')){
			 	$("#tb_gold_order_html input[type='checkbox']").prop("checked", true);
			 }else{
			 	$("#tb_gold_order_html input[type='checkbox']").prop("checked", false);
			 }
		});
	});
	
	function gold_order_html(ajax_url, from_field, by){
		$.post(ajax_url,{from_key:$("#from_key").val(), from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_gold_order_html").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_gold_order_html").append(data['data']['html']);
				$("#paging").append(data['data']['paging']);
				$("#p_page").append('共有'+data['data']['pagcount']+'条记录，每页<?php echo PAGEING_GOLD_ORDER_NUM;?>条');
				$("#paging a").bind("click", function(e){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
                	gold_order_html($(this).attr('href'), from_field, by);
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
			$.post("<?php echo base_url().'order/top/click_active'?>",{id_s:id_s},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE; ?>){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
					if($("#paging li").length > 0){
						$("#paging li").each(function(){
							if($(this).hasClass("active")) {
								gold_order_html($(this).find("a").attr('href'), from_field, by);
							}
						});
					}else{
						gold_order_html("<?php echo base_url().'order/top/gold_order_html'?>", from_field, by);
					}
				}
			},
			"json"
			);
		}
	}
	
	function get_checkbox(){
		var str = [];
		$("#tb_gold_order_html input[type='checkbox']:checked").each(function(){
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