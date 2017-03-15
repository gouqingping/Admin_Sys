<!-- tableBody -->
<div class="text-center">
	<h3>灯箱管理</h3><hr>
</div>
<div class="add_body">
	<div class="text-center add_bom">
		<h3>编辑广告</h3>
	</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">广告标题</h4>
		<input id="title" class="form-control col-lg-9" placeholder="标题title" type="text" value="<?php echo $banner[0]['title'];?>">
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">广告类型</h4>
		<select id="type">
			<option value="<?php echo TYPE_BANNER_URL;?>" <?php echo $banner[0]['type']==TYPE_BANNER_URL?'selected':'';?>>页面</option>
			<option value="<?php echo TYPE_BANNER_HTML;?>" <?php echo $banner[0]['type']==TYPE_BANNER_HTML?'selected':'';?>>帖子</option>
		</select>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">Banner图</h4>
		<div class="imgTop">
			<img id="banner_img" src="<?php echo $banner[0]['img']?service_image($banner[0]['img'], 'banner'):base_url().'images/imgTop.png';?>">
			
			<input id="imgsrc" type="hidden" value="">
			<input id="fileupload" name="mypic" type="file" class="banner_img_file">
		</div>
		<span id="sp_imgsrc"></span>
		<div style="clear: both;"></div>
		<p>*&nbsp;&nbsp;img高宽限定，W：720*N X H：200*N</p>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">链接地址</h4>
		<input id="url" class="form-control col-lg-9" type="text" value="<?php echo $banner[0]['url'];?>" placeholder="如:http://www.duangniu.com">
		<span id="ps_url"></span>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">状态</h4>
		<select id="status">
			<option value="1" <?php echo $banner[0]['type']==1?'selected':'';?>>开启</option>
			<option value="0" <?php echo $banner[0]['type']==1?'':'selected';?>>关闭</option>
		</select>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">开始时间</h4>
		<div>
			<input class="laydate-icon" id="begin_at" value="<?php echo $banner[0]['begin_at'];?>" placeholder="如:2015-05-05 05:05:05" class="laydate-icon">
			<span id="ps_begin"></span>
		</div>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">结束时间</h4>
		<div>
			<input class="laydate-icon" id="end_at" value="<?php echo $banner[0]['end_at'];?>" placeholder="如:2015-05-05 05:05:05" class="laydate-icon">
			<span id="ps_end"></span>
		</div>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-12">
		<h4 class="col-lg-2">页面编辑</h4>
		<textarea id="text_html" class="add_text_body col-lg-9"><?php echo $banner[0]['html'];?></textarea>
	</div>
</div>
<div class="add_row">
	<div class="col-lg-11" style="margin: 80px 0 0 10px;">
		<button onclick="save_banner(<?php echo $banner[0]['id'];?>);" type="button" class="btn btn-danger btn-block">保存</button>
	</div>
</div>
<script type="text/javascript">
$(function(){
	$("#fileupload").wrap("<form id='myupload' action='<?php echo base_url();?>plugin/file_icon/action.php' method='post' enctype='multipart/form-data'></form>");
	$("#fileupload").change(function(){
		var name = $(this).val().split('.')[0];
		$("#myupload").attr('action','<?php echo base_url();?>plugin/file_icon/action.php?paths=banner&icon_name='+name);
		var allowImgageType = ['jpg', 'jpeg', 'png', 'gif'];//后缀
		var ico_name = $(this).val();//获取文件名
		var byteSize = getFileSize(this);//获取大小
		if (ico_name.length > 0){
			if(byteSize > 2048){
				alert("上传的附件文件不能超过2M");
				return;
			}
			var pos = ico_name.lastIndexOf(".");//截取点之后的字符串
			var ext = ico_name.substring(pos + 1).toLowerCase();
			if($.inArray(ext, allowImgageType) != -1) {
			}else {
				alert("请选择jpg,jpeg,png,gif类型的图片");
				return;
			}
		}else {
			alert("请选择jpg,jpeg,png,gif类型的图片");
			return;
		}
		$("#myupload").ajaxSubmit({
			dataType:'json',
			beforeSend:function(){
			},
			uploadProgress:function(event, position, total, percentComplete){
				var percentVal = percentComplete + '%';
			},
			success:function(data){
				var src = "<?php echo base_url().'upload/images/banner/temp/';?>"+data.src;
				$("#banner_img").attr('src',src);
				$("#imgsrc").val(data.src);
			},
			error:function(xhr){
			}
		});
	});
});

function getFileSize(fileName){
	var byteSize = 0;
	if($(fileName)[0].files){
		var byteSize  = $(fileName)[0].files[0].size;
	}
	byteSize = Math.ceil(byteSize / 1024) //KB
	return byteSize;//KB
}

function save_banner(id){
	if(banner_validation()){
		var banner_obj = {
			id:id,
			title:$('#title').val(),
			type:$('#type').val(),
			imag:$('#imgsrc').val(),
			url:$('#url').val(),
			is_active:$('#status').val(),
			begin_at:$('#begin_at').val(),
			end_at:$('#end_at').val(),
			text_html:$('#text_html').val()
		};
		$.post("<?php echo base_url().'banner/top/edit_banner'; ?>",banner_obj,
		function(data){
			if(data['code'] == <?php echo SUCCESS_CODE;?>){
				alert(data['data']);
			}
		},
		"json"
		);
	}
}

function banner_validation(){
	var val =  true;
	$('#sp_imgsrc').html("");
	$('#ps_url').html("");
	$('#ps_begin').html("");
	$('#ps_begin').html("");
	<?php if(!$banner[0]['id']){?>
		if($('#imgsrc').val() == ""){
			$('#sp_imgsrc').html("请上传banner图片");
			val = false;
		}
	<?php }?>
	if(CheckUrl($('#url').val())){
		$('#ps_url').html("请输入有效网络地址");
		val = false;
	}
	if($('#begin_at').val() == ""){
		$('#ps_begin').html("请选择开始日期");
		val = false;
	}
	if($('#end_at').val() == ""){
		$('#ps_end').html("请选择结束日期");
		val = false;
	}
	if($('#begin_at').val()>=$('#end_at').val() && $('#end_at').val() != ""){
		$('#ps_begin').html("开始日期大于结束日期");
		val = false;
	}
	return val;
}

function CheckUrl(str) {
    var RegUrl = new RegExp();
    RegUrl.compile("^http://[A-Za-z0-9-_]+\\.[A-Za-z0-9-_%&\?\/.=]+$");
    if (!RegUrl.test(str)) {
        return true;
    }
    return false;
}

//日期范围限制
var start = {
    elem: '#begin_at',
    format: 'YYYY-MM-DD hh:mm:ss',
    min: laydate.now(), //设定最小日期为当前日期
    max: '2099-06-16', //最大日期
    istime: true,
    istoday: false,
    choose: function(datas){
         end.min = datas; //开始日选好后，重置结束日的最小日期
         end.start = datas //将结束日的初始值设定为开始日
    }
};

var end = {
    elem: '#end_at',
    format: 'YYYY-MM-DD hh:mm:ss',
    min: laydate.now(),
    max: '2099-06-16',
    istime: true,
    istoday: false,
    choose: function(datas){
        start.max = datas; //结束日选好后，充值开始日的最大日期
    }
};

laydate(start);
laydate(end);
</script>