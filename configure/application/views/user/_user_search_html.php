<thead>
    <tr id="t_sort">
    	<input id="from_field" name="from_field" type="hidden" value="<?php echo $from_field;?>" />
    	<input id="sort" name="sort" type="hidden" value="<?php echo $by;?>" />
        <th style="width:80px">
        	<a id="sort_1" <?php echo $from_field=='sort_1'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        		ID<?php echo get_sort_icon($from_field, 'sort_1', $by);?>
            </a>
        </th>
        <th style="width:150px">
        	<a id="sort_2" <?php echo $from_field=='sort_2'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        		称昵<?php echo get_sort_icon($from_field, 'sort_2', $by);?>
        	</a>
        </th>
        <th>
        	<a id="sort_3" <?php echo $from_field=='sort_3'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	简介<?php echo get_sort_icon($from_field, 'sort_3', $by);?>
        	</a>
        </th>
        <th style="width:200px">
        	<a id="sort_4" <?php echo $from_field=='sort_4'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	邮箱<?php echo get_sort_icon($from_field, 'sort_4', $by);?>
        	</a>
        </th>
        <th style="width:80px">
        	<a id="sort_5" <?php echo $from_field=='sort_5'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	性别<?php echo get_sort_icon($from_field, 'sort_5', $by);?>
        	</a>
        </th>
        <th style="width:80px">
        	<a id="sort_6" <?php echo $from_field=='sort_6'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	牛币<?php echo get_sort_icon($from_field, 'sort_6', $by);?>
        	</a>
        </th>
        <th style="width:80px">
        	<a id="sort_7" <?php echo $from_field=='sort_7'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	发帖<?php echo get_sort_icon($from_field, 'sort_7', $by);?>
        	</a>
        </th>
        <th style="width:100px">
        	<a id="sort_8" <?php echo $from_field=='sort_8'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	注册IP<?php echo get_sort_icon($from_field, 'sort_8', $by);?>
        	</a>
        </th>
        <th style="width:150px">
        	<a id="sort_9" <?php echo $from_field=='sort_9'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	注册日期<?php echo get_sort_icon($from_field, 'sort_9', $by);?>
        	</a>
        </th>
        <th style="width:150px">
        	<a id="sort_10" <?php echo $from_field=='sort_10'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	最后登录</a><?php echo get_sort_icon($from_field, 'sort_10', $by);?>
        </th>
        <th style="width:80px">
        	<a id="sort_0" <?php echo $from_field=='sort_0'?$by=='a'?'_sort="d"':'_sort="a"':'_sort="a"';?> href="javascript:void(0);">
        	状态<?php echo get_sort_icon($from_field, 'sort_0', $by);?>
        	</a>
        </th>
    </tr>
</thead>
<tbody id="tr_row">
<?php
foreach($users as $key => $val){
?>
    <tr>
        <td><input class="_select_check" id="dr_id_<?php echo $val['id'];?>" type="checkbox" value="<?php echo $val['id'];?>" name="preDelCheck"><?php echo $val['id'];?></td>
        <td><a onclick="show_user_info_html(<?php echo $val['id'];?>, event);" href="javascript:void(0);"><?php echo $val['nickname'];?></a></td>
        <td><?php echo $val['profile'];?></td>
        <td><?php echo $val['email'];?></td>
        <td><?php echo user_sex($val['sex']);?></td>
        <td><?php echo $val['gold'];?></td>
        <td><?php echo $val['p_num'];?></td>
        <td><?php echo $val['regist_ip'];?></td>
        <td><?php echo $val['created_at'];?></td>
        <td><?php echo $val['last_login_at'];?></td>
        <td><span class="<?php echo $val['is_active']==0?'red':'green'?>"><?php echo user_status($val['is_active'], $val['is_activate']);?></td>
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
			var ajax_url = "<?php echo base_url().'user/profile/user_search_html'?>";
			user_search_html(ajax_url, from_field, by);
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