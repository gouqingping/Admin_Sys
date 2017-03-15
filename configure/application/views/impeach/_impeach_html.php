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
				投诉人<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				投诉类型<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				投诉状态<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				投诉时间<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th class="col-lg-5">
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				问题描述<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<th>
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				查看问题<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($impeach as $key => $val){
?>
	<tr>
		<td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
		<td><a onclick="show_user_info_html(<?php echo $val['user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
		<td><?php echo impeach_type($val['content_type']);?></td>
		<td><?php echo impeach_status($val['is_active']);?></td>
		<td><?php echo $val['created_at'];?></td>
		<td><?php echo text_html_str($from_val,'<span class="violet">'.$from_val.'</span>',$val['content']);?></td>
		<td><a target="blank" onclick="stop_propagation(event);" href="<?php echo get_front_url($val['type'],$val['t_id']);?>"><?php echo get_type_impeach($val['type']);?></a></td>
	</tr>
<?php
}
?>
</tbody>
<script type="text/javascript">
	var search_type = '<?php echo $type;?>';
	$(function(){
		$("._select_check").click(function(e){
			e.stopPropagation();
		});
		
		$("#t_sort a").click(function(){
			var from_field = $(this).attr('id');
			var by = $(this).attr('_sort');
			ajax_url = "<?php echo base_url().'impeach/profile/impeach_html'?>";
			capacity_thml(ajax_url, from_field, by);
		});
		
		$("#tr_row tr").click(function(){
			if($(this).find("input[type='checkbox']").prop("checked")){
			 	$(this).find("input[type='checkbox']").prop("checked", false);
			 }else{
			 	$(this).find("input[type='checkbox']").prop("checked", true);
			 }
		});
	});
</script>