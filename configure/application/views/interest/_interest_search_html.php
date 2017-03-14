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
				兴趣名<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th style="width:80px;">
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th style="width:80px;">
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				关注数<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th style="width:50px;">
			<a href="javascript:void(0);">
				图标
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				建立时间<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<!--<th style="width:180px;">
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				更新时间<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>-->
		<th style="width:180px;">
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				申请人<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				审核人<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
			</a>
		</th>
		<th style="width:180px;">
			<a id="sort_9" <?php echo $from_field=='sort_9'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				兴趣描述<?php echo get_sort_icon($from_field, 'sort_9', $by);?>
			</a>
		</th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($interest as $key => $val){
?>
	<tr>
		<td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
		<td>
<?php 
	if($type=='apply'){
		echo $val['name'];
	}else{
?>
        	<a target="blank" onclick="stop_propagation(event);" href="<?php echo get_front_url('interest',$val['id']);?>">$<?php echo $val['name'];?>$</a>
<?php		
	}
?>	
		</td>
		<td class="<?php echo $val['is_active']==0?'red':'green'?>"><span><?php echo interest_status($val['is_active']);?></span></td>
		<td><?php echo $val['f_num'];?></td>
		<td><img src="<?php echo service_image($val['icon'], 'interest', 's'); ?>"></td>
		<td><?php echo $val['created_at'];?></td>
		<!--<td><?php //echo $val['updated_at'];?></td>-->
		<td><a onclick="show_user_info_html(<?php echo $val['apply_user_id'];?>, event);" href="javascript:void(0);"><?php echo $val['apply_name'];?></a></td>
		<td><?php echo $val['accept_name'];?></td>
		<td><?php echo $val['content'];?></td>
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
			var ajax_url = '';
			if(search_type == 'apply'){
				ajax_url = "<?php echo base_url().'interest/profile/interest_apply_html'?>";
			}else{
				ajax_url = "<?php echo base_url().'interest/profile/interest_html'?>";
			}
			interest_thml(ajax_url, from_field, by);
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