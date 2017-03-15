<thead>
	<tr id="t_sort">
		<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
		<th style="width:80px;">
			<a id="sort_1" <?php echo $from_field=='sort_1'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				编号ID<?php echo get_sort_icon($from_field, 'sort_1', $by);?>
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_2" <?php echo $from_field=='sort_2'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				昵称<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				订单编号<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				第三方支付编号<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th style="width:100px;">
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				充值方式<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<th style="width:80px;">
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				订单状态<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>
		<th style="width:120px;">
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				充值牛币<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th style="width:120px;">
			<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				人民币<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
			</a>
		</th>
		<!--<th style="width:80px;">
			<a id="sort_9" <?php echo $from_field=='sort_9'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_9', $by);?>
			</a>
		</th>-->
		<th style="width:180px;">
			<a id="sort_10" <?php echo $from_field=='sort_10'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				订单生成时间<?php echo get_sort_icon($from_field, 'sort_10', $by);?>
			</a>
		</th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($gold_order as $key => $val){
?>
	<tr>
		<td><!--<input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck">--><?php echo $val['id'];?></td>
		<td><a onclick="show_user_info_html(<?php echo $val['user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
		<td><?php echo $val['order_num'];?></td>
		<td><?php echo $val['trade_num'];?></td>
		<td><?php echo gold_order_type($val['type']);?></td>
		<td class="<?php echo $val['status']==ORDER_STATUS_NOT_PAID?'red':'green'?>"><?php echo order_status($val['status']);?></td>
		<td><?php echo $val['gold'];?></td>
		<td><?php echo $val['money'];?></td>
		<!--<td class="<?php echo $val['is_active']==0?'red':'green'?>"><span><?php echo gold_order_status($val['deleted_at'], $val['is_active']);?></span></td>-->
		<td><?php echo $val['created_at'];?></td>
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
			gold_order_html('<?php echo base_url().'order/top/gold_order_html'?>', from_field, by);
		});
		$("#tr_row tr").click(function(){
			if($(this).find("input[type='checkbox']").prop("checked")){
			 	$(this).find("input[type='checkbox']").prop("checked", false);
			 }else{
			 	$(this).find("input[type='checkbox']").prop("checked", true);
			 }
		});
	})
</script>