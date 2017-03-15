<div class="adm-user">
	<div class="text-center">
		<h3>灯箱管理</h3><hr>
	</div>
    <div class="table-responsive table-res clearfix">
        <table id="tb_banner_thml" class="table table-hover text-left"></table>
    </div>
    <hr>
    <!-- END -->
    <label>
        <a href="<?php echo base_url().'banner/profile/set'?>" class="btn btn-primary pull-right"><i class="fa fa-eye fa-lg"></i>新增广告</a>
    </label>
    <div class="cle"></div>
    <div class="right">
    	<p id="p_page" class="right"></p>
    	<br />
    	<ul id="paging" name="paging" class="pagination right"></ul>
    </div>
</div>
<script type="text/javascript">
	$(function(){
		menu_click($('#menu_banner'));
		var ajax_url = "<?php echo base_url().'banner/top/banner_html'?>";
		var from_field = '';
		var by = '';
		banner_html(ajax_url, from_field, by);
	});

	function banner_html(ajax_url, from_field, by){
		$.post(ajax_url,{from_key:$("#from_key").val(), from_val:$("#from_val").val(), from_field:from_field, by:by},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE; ?>){
				$("#tb_banner_thml").html("");
				$("#p_page").html("");
				$("#paging").html("");
				$("#tb_banner_thml").append(data['data']['html']);
				$("#paging").append(data['data']['paging']);
				$("#p_page").append('共有'+data['data']['pagcount']+'条记录，每页<?php echo PAGEING_BANNER_NUM;?>条');
				$("#paging a").bind("click", function(e){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
                	banner_html($(this).attr('href'), from_field, by);
               		e.preventDefault();
        		});
			}
		},
		"json"
		);
	}
	
	function dialog_close(){
		$("#dv_dialog").html("");
		$("#dv_dialog_back").hide();
		$("#dv_dialog").hide();
	}
</script>