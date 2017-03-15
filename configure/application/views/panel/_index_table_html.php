<table class="table table-hover text-right">
    <tbody>
<?php
if($data){
	$j = 0;
	for($i = 1;$i <= $sum; $i++){
		$k = $i>9?$i:'0'.$i;
		if(count($data) > $j){
		    if(get_time_from_str($data[$j]['c_day'], 'd') == $k){
?>
        <tr>
            <td>
                <div class="left"><?php echo $data[$j]['c_day'];?></div>
                <span><?php echo $data[$j]['d_num'];?></span>
            </td>
        </tr>
<?php
			    $j++;
		    }else{
?>
        <tr>
            <td>
                <div class="left"><?php echo $date.'-'.$k;?></div>
                <span>0</span>
            </td>
        </tr>
<?php
		    }
		}else{
?>
        <tr>
            <td>
                <div class="left"><?php echo $date.'-'.$k;?></div>
                <span>0</span>
            </td>
        </tr>
<?php
	    }
	}
}else{
	for($i = 1;$i <= $sum; $i++){
?>
        <tr>
            <td>
                <div class="left"><?php echo $date.'-'.($i>9?$i:'0'.$i);?></div>
                <span>0</span>
            </td>
        </tr>
<?php
	}
}
?>
    </tbody>
</table>