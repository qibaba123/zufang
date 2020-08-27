var swiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 1500,
    pagination: '.swiper-pagination',
    paginationClickable: true,
    autoplay:3000
});
$(function(){
	$('#tab-select .item').mouseover(function(){
		var index=$(this).index();
		$('.con-list .case-con').eq(index).addClass('active').siblings().removeClass('active');
	})
});
$('.btn-need').on('click',function(){
	var name    =  $('.need-user').val();
	var mobile  =  $('.need-phone').val();
	var desc    =  $('.need-desc').val();
	if(!name || !mobile || !desc){
		layer.msg('请完善您的提交数据哦');
		return;
	}
	var data = {
		'name'    : name,
		'mobile'  : mobile,
		'desc'    : desc
	};
	$.ajax({
        'type' : 'post',
		'data' : data,
		'url'  : '/home/addNeed',
		'dataType' : 'json',
		'success'  : function(ret){
			layer.msg(ret.em);
			if(ret.ec==200){
				$('.need-user').val('');
				$('.need-phone').val('');
				$('.need-desc').val('');
			}
		}
	});
});