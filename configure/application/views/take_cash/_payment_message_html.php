<div class="modal-ok">
    <div class="animate">
        <div class="offno">
            <span class="black">申请提现</span>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">处理方式:</div>
        <div class="col-lg-6">
            <select id="handle" name="handle" class="form-control">
                <option value="no" selected="true">申请失败</option>
                <option value="yes">申请成功</option>
            </select>
        </div>
    </div>
    <div class="details">
        <div class="col-md-3">处理原因:</div>
        <div class="col-md-9">
            <textarea class="text-div" id="txt_explain">申请提现:<?php echo $user['nickname'];?>，很遗憾，您的打款申请没能通过审核，请核实信息后重新提交申请。</textarea>
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
				text = '申请提现:<?php echo $user['nickname'];?>，很遗憾，您的打款申请没能通过审核，请核实信息后重新提交申请。';
			}else if(s_val == 'yes'){
				text = '申请提现:<?php echo $user['nickname'];?>，恭喜您，您的打款申请已经通过审核，预计到账时间为1-3个工作日。';
			}
			$("#txt_explain").val(text);
		});
		
		$(".btn_save").click(function(){
			var handle = $("#handle").val();
			var explain = $("#txt_explain").val();
			//处理信息
			$.post("<?php echo base_url().'take_cash/top/payment'?>",{key:<?php echo $take_cash['id'];?>, handle:handle, explain:explain},
			function(data){
				if(data['code'] == <?php echo SUCCESS_CODE;?>){
					if(data['data']['is_update']){
						if(data['data']['status']){
							$("#td_a_id_" + <?php echo $take_cash['id'];?>).html('<img src="<?php echo base_url();?>images/img_icon_yes.png"/>');
						}else{
							$("#td_a_id_" + <?php echo $take_cash['id'];?>).html('<img src="<?php echo base_url();?>images/img_icon_no.png"/>');
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