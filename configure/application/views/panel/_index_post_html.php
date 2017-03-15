<table class="table table-hover">
    <thead>
        <tr>
            <th>帖子</th>
            <th>评论数量</th>
            <th>所属兴趣</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($post_html as $key => $val){
?>
        <tr>
            <td class="list"><a target="blank" href="<?php echo get_front_url('post',$val['id']);?>"><?php echo $val['p_name']==null?'无标题':$val['p_name'];?></a></td>
            <td><?php echo $val['c_num'];?></td>
            <td><a <?php echo $val['i_name']==null?'target="blank"':'';?> href="<?php echo $val['i_name']==null?'javascript:void(0);':get_front_url('interest',$val['i_id']);?>"><?php echo $val['i_name']==null?'无兴趣':$val['i_name'];?></a></td>
        </tr>
<?php
}
?>
    </tbody>
</table>