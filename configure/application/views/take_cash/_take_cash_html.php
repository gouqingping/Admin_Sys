<thead>
	<tr id="t_sort">
		<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
		<th>
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
				级别<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				牛币<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				金额<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				申请时间<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				交易状态<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($take_cash as $key => $val){
?>
	<tr>
		<td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
		<td><a onclick="show_user_info_html(<?php echo $val['user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
		<td><?php echo $val['rank'];?></td>
		<td><?php echo $val['gold'];?></td>
		<td><?php echo $val['money'];?></td>
		<td class="<?php echo $val['is_active']==0?'red':'green'?>"><span><?php echo gold_order_status($val['deleted_at'], $val['is_active']);?></span></td>
		<td><?php echo $val['created_at'];?></td>
		<td id="<?php echo 'td_a_id_'.$val['id'];?>">
		<?php
			if($val['status'] == CASH_ORDER_STATUS_IN_PRESS){?>
				<a onclick="payment_message(<?php echo $val['id'];?>, event)" href="javascript:void(0);" class="btn btn-default left">申请中</a>
			<?php }elseif($val['status'] == CASH_ORDER_STATUS_SUCCESS){?>
				<img src="<?php echo base_url();?>images/img_icon_yes.png"/>
			<?php }elseif($val['status'] == CASH_ORDER_STATUS_FAIL){?>
				<img src="<?php echo base_url();?>images/img_icon_no.png"/>
			<?php }
		?>
		</td>
	</tr>
<?php
}
?>
</tbody>
<script type="text/javascript">
	$(function(){
		menu_click($('#menu_take_cash'));
		$("._select_check").click(function(e){
			e.stopPropagation();
		});
		$("#t_sort a").click(function(){
			var from_field = $(this).attr('id');
			var by = $(this).attr('_sort');
			take_cash_html('<?php echo base_url().'take_cash/top/take_cash_html'?>', from_field, by);
		});
		$("#tr_row tr").click(function(){
			if($(this).find("input[type='checkbox']").prop("checked")){
			 	$(this).find("input[type='checkbox']").prop("checked", false);
			 }else{
			 	$(this).find("input[type='checkbox']").prop("checked", true);
			 }
		});
	});
	
	function payment_message(key, e){
		e.stopPropagation();
		$.post("<?php echo base_url().'take_cash/top/payment_message_html';?>",{key:key},
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE;?>){
				$("#dv_dialog").html("");
				$("#dv_dialog").append(data['data']['html']);
				$("#dv_dialog_back").show();
				$("#dv_dialog").show();
			}
		},
		"json"
		);
	}
</script>