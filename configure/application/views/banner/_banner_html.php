<thead>
	<tr id="t_sort">
		<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
		<th class="center">
			<a id="sort_1" <?php echo $from_field=='sort_1'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				编号ID<?php echo get_sort_icon($from_field, 'sort_1', $by);?>
			</a>
		</th>
		<th class="center">
			<a href="javascript:void(0);">广告图</a>
		</th>
		<th class="center">
			<a id="sort_2" <?php echo $from_field=='sort_2'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				广告名<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
			</a>
		</th>
		<th class="center">
			<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				类型<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
			</a>
		</th>
		<th class="center">
			<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				状态<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
			</a>
		</th>
		<th class="center">
			<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				建立时间<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
			</a>
		</th>
		<th class="adm-son center">
			<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				开启时间<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
			</a>
		</th>
		<th class="center">
			<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
				结束时间<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
			</a>
		</th>
		<th class="center"><a href="javascript:void(0);">链接地址</a></th>
		<th class="center"><a href="javascript:void(0);">更多操作</a></th>
	</tr>
</thead>
<tbody id="tr_row">
<?php
foreach($banner as $key => $val){
?>
	<tr>
		<td class="center"><?php echo $val['id'];?></td>
		<td><img width="30" height="30" src="<?php echo service_image($val['img'], 'banner');?>"></td>
		<td class="center"><span><?php echo $val['title'];?></span></td>
		<td class="center"><span><?php echo banner_type($val['type']);?></span></td>
		<td class="center"><span class="<?php echo $val['is_active']?'green':'red'?>"><?php echo banner_status($val['is_active']);?></span></td>
		<td class="center"><span><?php echo $val['created_at'];?></span></td>
		<td class="center"><span><?php echo $val['begin_at'];?></span></td>
		<td class="center"><span><?php echo $val['end_at'];?></span></td>
		<td class="center"><a href="<?php echo $val['url'];?>" target="_Blank"><?php echo $val['url'];?></a></td>
		<td class="center"><a href="<?php echo base_url().'banner/profile/set/'.encrypt_id($val['id']);?>">修改</a></td>
	</tr>
<?php }?>
<tbody>
<script type="text/javascript">
	$(function(){
		$("#t_sort a").click(function(){
			var from_field = $(this).attr('id');
			var by = $(this).attr('_sort');
			var ajax_url = "<?php echo base_url().'banner/top/banner_html'?>";
			banner_html(ajax_url, from_field, by);
		});
	});
</script>