<table class="table table-hover">
    <thead>
        <tr>
            <th>兴趣名</th>
            <th>新帖数量</th>
            <th>关注数量</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach($interest_html as $key => $val){
?>
        <tr>
            <td class="list"><a target="blank" href="<?php echo get_front_url('interest',$val['id']);?>"><?php echo $val['name'];?></a></td>
            <td><?php echo $val['p_sum']==null?0:$val['p_sum'];?></td>
            <td><?php echo $val['f_sum']==null?0:$val['f_sum'];?></td>
        </tr>
<?php
}
?>
    </tbody>
</table>