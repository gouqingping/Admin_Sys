<thead>
	<tr id="t_sort">
		<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
		<th style="width: 55px;>
			<a id="sort_1" <?php echo $from_field=='sort_1'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				编号ID<?php echo get_sort_icon($from_field, 'sort_1', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_2" <?php echo $from_field=='sort_2'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				昵称<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				支付宝账号<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				QQ号码<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				联系地址<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<!--<th>
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				撰稿人审核<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>-->
		<th style="width: 160px;">
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				支付宝账号可修改时间<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th style="width: 70px;">
			<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				姓名<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
			</a>
		</th>
		<th style="width: 50px;">
			<a id="sort_9" <?php echo $from_field=='sort_9'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_9', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_10" <?php echo $from_field=='sort_10'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				身份证<?php echo get_sort_icon($from_field, 'sort_10', $by);?>
			</a>
		</th>
		<th>
			<a href="javascript:void(0);">
				照片
			</a>
		</th>
		<th>
			<a id="sort_11" <?php echo $from_field=='sort_11'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				申请时间<?php echo get_sort_icon($from_field, 'sort_11', $by);?>
			</a>
		</th>
		<th  style="width: 85px;">
			<a href="javascript:void(0);">
				撰稿人协议 
			</a>
		</th>
		<th style="width: 70px;">
			<a href="javascript:void(0);">
				 信息绑定
			</a>
		</th>
		<th style="width: 70px;">
			<a href="javascript:void(0);">
				 实名认证
			</a>
		</th>	
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($writer_info as $key => $val){
?>
	<tr>
		<td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
		<td><a onclick="show_user_info_html(<?php echo $val['user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
		<td><?php echo $val['pay_account'];?></td>
		<td><?php echo $val['qq'];?></td>
		<td><?php echo $val['contact_address'];?></td>
		<!--<td id="step_<?php echo $val['id'];?>"><?php echo is_writer($val['step'])?'已通过':'未通过';?></td>-->
		<td><?php echo $val['pay_account_updated_at'];?></td>
		<td><?php echo $val['name'];?></td>
		<td class="<?php echo $val['is_active']==0?'red':'green'?>"><span><?php echo gold_order_status($val['deleted_at'], $val['is_active']);?></span></td>
		<td><?php echo $val['identity_card'];?></td>
		<td>
		<?php if($val['identity_card_img']){?>
			<img src="<?php echo service_image($val['identity_card_img'], 'idy');?>" onclick="show_image('<?php echo service_image($val['identity_card_img'], 'idy');?>')" style="height: 40px; width: 40px;">
		<?php }?>
		</td>
		<td><?php echo $val['created_at'];?></td>
		<td><?php echo to_be_writer_step($val['step'], WRITER_STEP_1)?'<img src="'.base_url().'images/img_icon_yes.png"/>':'<img src="'.base_url().'images/img_icon_no.png"/>';?></td>
		<td><?php echo to_be_writer_step($val['step'], WRITER_STEP_3)?'<img src="'.base_url().'images/img_icon_yes.png"/>':'<img src="'.base_url().'images/img_icon_no.png"/>';?></td>
		<td id="<?php echo 'td_a_id_'.$val['id'];?>">
			<?php
				if(to_be_writer_step($val['step'], WRITER_STEP_2)){
					echo '<img src="'.base_url().'images/img_icon_yes.png"/>';
				}elseif(to_be_writer_step($val['step'], WRITER_STEP_4)){
					echo '<img src="'.base_url().'images/img_icon_no.png"/>';
				}else{
			?>
				<a onclick="approve_message(<?php echo $val['id'];?>, event)" href="javascript:void(0);" class="btn btn-default left">认证</a>
			<?php
				}
			?>
		</td>
	</tr>
<?php
}
?>
</tbody>
<script type="text/javascript">
	$(function(){
		$("._select_check").click(function(e){
			e.stopPropagation();
		});
		$("#t_sort a").click(function(){
			var from_field = $(this).attr('id');
			var by = $(this).attr('_sort');
			writer_info_html("<?php echo base_url().'writer/top/writer_info_html'?>", from_field, by);
		});
		$("#tr_row tr").click(function(){
			if($(this).find("input[type='checkbox']").prop("checked")){
			 	$(this).find("input[type='checkbox']").prop("checked", false);
			 }else{
			 	$(this).find("input[type='checkbox']").prop("checked", true);
			 }
		});
	});
	
	function approve_message(key, e){
		e.stopPropagation();
		$.post("<?php echo base_url().'writer/top/approve_message_html';?>",{key:key},
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
	
	function show_image(src){
		$("#dv_dialog").html("");
		var html =
		'<div class="modal_img_l">'+
			
				'<img src="'+src+'" />'+
			
		'</div>'
		$("#dv_dialog").append(html);
		$("#dv_dialog_back").show();
		$("#dv_dialog").show();
	}
</script>