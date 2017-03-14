function menu_click(obj){
	$('#ul_menu li').removeClass('active act');
	$(obj).addClass('active act');
}

function stop_propagation(e){
	e.stopPropagation();
}
function menu_click(obj){
	$('#ul_menu li').removeClass('active act');
	$(obj).addClass('active act');
}

$(function(){
	$(".navbar-inverse").click(function (event){
		$('#bs-example-navbar-collapse-1').show();//显示
		$(document).click(function(){
			$('#bs-example-navbar-collapse-1').hide();//影藏
			});
		event.stopPropagation();//阻止事件向上冒泡
	});
	$('#bs-example-navbar-collapse-1').click(function (event){
		event.stopPropagation();//阻止事件向上冒泡
	});
});