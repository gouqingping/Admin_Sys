<div class="modal-ok">
    <div class="animate">
        <div class="offno">
            <span class="black">处理投诉</span>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">处理方式:</div>
        <div class="col-lg-6">
            <select id="handle" name="handle" class="form-control">
                <option value="no" selected="true">理由不充分驳回诉讼</option>
                <option value="yes">封停投诉内容</option>
            </select>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">解封日期:</div>
        <div class="col-md-9">无</div>
    </div>
    <div class="details">
        <div class="col-md-3">处理原因:</div>
        <div class="col-md-9">
            <textarea class="text-div" id="txt_explain"></textarea>
        </div>
        <div class="cle">
        </div>
    </div>
    <br>
    <br>
    <div class="offno">
        <a class="btn btn-primary btn_save" href="javascript:void(0);">保存并关闭</a>
        <a class="btn btn-default dialog_close" href="javascript:void(0);">关闭</a>
    </div>
    <br>
</div>
<script type="text/javascript">
	$(function(){
		$(".btn_save").click(function(){
			var ids = get_checkbox();
			var handle = $("#handle").val();
			var explain = $("#txt_explain").val();
			//处理信息
			$.post("<?php echo base_url().'impeach/profile/impeach_save'?>",{ids:ids, handle:handle, explain:explain},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE;?>){
					var from_field = $("#from_field").val();
					var by = $("#sort").val();
					if($("#paging li").length > 0){
						$("#paging li").each(function(){
							if($(this).hasClass("active")) {
								capacity_thml($(this).find("a").attr('href'), from_field, by);
							}
						});
					}else{
						capacity_thml("<?php echo base_url().'impeach/profile/impeach_html';?>", from_field, by);
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