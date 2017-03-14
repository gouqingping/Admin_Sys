<thead>
	<tr id="t_sort">
		<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
		<th style="width:60px">
			<a id="sort_1" <?php echo $from_field=='sort_1'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				编号ID<?php echo get_sort_icon($from_field, 'sort_1', $by);?>
			</a>
		</th>
		<th style="width:160px">
			<a id="sort_2" <?php echo $from_field=='sort_2'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				评论人<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th style="width:160px">
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				评论时间<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th style="width:160px">
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				修改时间<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th style="width:160px">
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				删除时间<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<th style="width:60px">
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				平台<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>
		<th style="width:60px">
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th style="width:60px">
			<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				赞助<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
			</a>
		</th>
		<th style="width:160px">
			<a id="sort_9" <?php echo $from_field=='sort_9'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				内容<?php echo get_sort_icon($from_field, 'sort_9', $by);?>
			</a>
		</th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($comment as $key => $val){
?>
	<tr>
		<td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
		<td><a onclick="show_user_info_html(<?php echo $val['user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
		<td><?php echo $val['created_at'];?></td>
		<td><?php echo $val['updated_at'];?></td>
		<td><?php echo $val['deleted_at'];?></td>
		<td><?php echo from_string_format($val['platform']);?></td>
		<td><span class="<?php echo $val['is_active']==1?'green':'red';?>"><?php echo comment_status($val['deleted_at'], $val['is_active']);?></td>
		<td><?php echo $val['gold'];?></td>
		<td><a target="blank" onclick="stop_propagation(event);" href="<?php echo get_front_url('comment',$val['id']);?>"><?php echo revert_img(text_html_str($from_val,'<span class="violet">'.$from_val.'</span>',$val['comment']));?></a></td>
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
			ajax_url = "<?php echo base_url().'comment/profile/comment_html'?>";
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