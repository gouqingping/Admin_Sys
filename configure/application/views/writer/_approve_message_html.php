<div class="modal-ok">
    <div class="animate">
        <div class="offno">
            <span class="black">实名认证</span>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">处理方式:</div>
        <div class="col-lg-6">
            <select id="handle" name="handle" class="form-control">
                <option value="no" selected="true">认证失败</option>
                <option value="yes">认证通过</option>
            </select>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">处理原因:</div>
        <div class="col-md-9">
            <textarea class="text-div" id="txt_explain">实名审核:<?php echo $user['nickname'];?>，很遗憾，您的身份认证没有通过。请核实你的信息后重新提交认证。</textarea>
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
		$("#handle").change(function(){
			var s_val = $(this).val();
			var text = '';
			if(s_val=='no'){
				text = '实名审核:<?php echo $user['nickname'];?>，很遗憾，您的身份认证没有通过。请核实你的信息后重新提交认证。';
			}else if(s_val == 'yes'){
				text = '实名审核:<?php echo $user['nickname'];?>，恭喜您，您的身份认证已经通过。';
			}
			$("#txt_explain").val(text);
		});
		
		$(".btn_save").click(function(){
			var handle = $("#handle").val();
			var explain = $("#txt_explain").val();
			//处理信息
			$.post("<?php echo base_url().'writer/top/authentication'?>",{key:<?php echo $writer['id'];?>, handle:handle, explain:explain},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE;?>){
					if(data['data']['is_update']){
						$("#step_" + <?php echo $writer['id'];?>).text(data['data']['title']);
						if(data['data']['status']){
							$("#td_a_id_" + <?php echo $writer['id'];?>).html('<img src="<?php echo base_url();?>images/img_icon_yes.png"/>');
						}else{
							$("#td_a_id_" + <?php echo $writer['id'];?>).html('<img src="<?php echo base_url();?>images/img_icon_no.png"/>');
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