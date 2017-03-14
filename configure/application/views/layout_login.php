<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="keywords" content="<?php echo $meta['keywords'];?>" />
        <meta name="Description" content="<?php echo $meta['description'];?>" />
        <title><?php echo $meta[ 'title'];?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/bootstrap.css" /> 
        <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/todc-bootstrap.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>css/common.css" />
<?php
foreach($css as $k => $v){
?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url().'css/'.$v;?>"/>
<?php
}
?>
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/base.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/plugins.js"></script>
        <script type="text/javascript" src="<?php echo base_url();?>js/common.js"></script>
<?php
foreach($javascript as $kj => $vj){ 
?>
        <script type="text/javascript" src="<?php echo base_url().'js/'.$vj;?>"></script>
<?php
}
?>
    </head>
    <body>
        <?php echo $content_for_layout;?>
    </body>
</html>