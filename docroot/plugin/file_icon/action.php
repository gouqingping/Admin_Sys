<?php
$icon_name = $_GET['icon_name'];
$paths = $_GET['paths'];
$picname = $_FILES['mypic']['name'];
$picsize = $_FILES['mypic']['size'];
if($picname != ""){
	if($picsize > 2048000){
		echo '图片大小不能超过2M';
		exit;
	}
	$type = strstr($picname, '.');
	if ($type != ".gif" && $type != ".jpg" && $type != '.png' && $type != ".jpeg") {
		echo '图片格式不对！';
		exit;
	}
	$pic_path = dirname(dirname(dirname(__FILE__)))."/upload/images/".$paths."/temp/".$icon_name;//上传路径
	if(file_exists($pic_path.'.gif')){
		unlink($pic_path.'.gif');
	}
	if(file_exists($pic_path.'.jpg')){
		unlink($pic_path.'.jpg');
	}
	if(file_exists($pic_path.'.png')){
		unlink($pic_path.'.png');
	}
	if(file_exists($pic_path.'.jpeg')){
		unlink($pic_path.'.jpeg');
	}
		if(file_exists($pic_path.'.jpg')){
		unlink($pic_path.'.jpg');
	}
	$pic_path .= $type;
	move_uploaded_file($_FILES['mypic']['tmp_name'], $pic_path);
}
$si = getimagesize($pic_path);
$size = round($picsize/1024,2);
$arr = array(
	'name'=>$icon_name,
	'type'=>$type,
	'src'=>$icon_name.$type,
	'width'=>$si[0],
	'height'=>$si[1]
);
echo json_encode($arr);
?>