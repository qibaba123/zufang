var swiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 1500,
    pagination: '.swiper-pagination',
    paginationClickable: true,
    autoplay:5000,
    nextButton: '.swiper-button-next',
    prevButton: '.swiper-button-prev'
});
$(function(){
	$('#process-time .item').mouseover(function(){
		var index=$(this).index();
		$(this).addClass('active').siblings().removeClass('active');		
		$('#process-con .content').eq(index).addClass('active').siblings().removeClass('active');
	});
	$('.classify-nav li').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	})
	$(".preview-btn").click(function() {
        $('.content-model').show();
        $('.preview-img').show();
    })
	$(".preview-img .close").click(function() {
        $('.content-model').hide();
        $('.preview-img').hide();
   });
   $('.case-nav .nav-item').click(function(){
   	var index=$(this).index();
   	$('.img-box-old img').eq(index).addClass('active').siblings().removeClass('active');
   })
});
function getCodes(){
	var mobile = $('.user-mobile-now').val();
	var code   = $('.img-code-now').val();
	var type   = 2;
	if (!/^1\d{10}/.test(mobile)) {
		layer.msg('手机号格式不正确');
		return;
	}
	if(!code){
		layer.msg('请输入图片验证码');
		return;
	}
	if(mobile){
		$.ajax({
			url: '/register/sendCode',
			type: 'post',
			data: { "mobile":mobile,"repeat":1,"code":code,'type':type},
			dataType: 'json',
			success:function(json_ret){
				layer.msg(json_ret.em);
				if(json_ret.ec==200){
					djs();
				}else{
					changeCode();
				}
			}
		});
	}else{
		layer.msg('请输入正确的手机号')
	}
}
$(".apply_agent_now").on('click',function() {
	var name       = $(".user-name-now").val();
	var mobile     = $('.user-mobile-now').val();
	var user_code  = $(".user-code-now").val();
	var url        = '/register/addRegisterAgent';
	if (!/^1\d{10}/.test(mobile)) {
		layer.msg('手机号格式不正确');
		return;
	};
    console.log(456);
	if(mobile && name   && user_code ) {
		var data = { "name":name,"mobile":mobile,"user_code":user_code};
		var index = layer.load(1, {
			shade: [0.1,'#fff'] //0.1透明度的白色背景
		});
		$.ajax({
			type: 'post',
			url:  url,
			data: data,
			dataType: 'json',
			success: function(json_ret){
				layer.close(index);
				layer.msg(json_ret.em,{
					time:2000
				},function(){
					if(json_ret.ec==200){
						location.reload();
					}
				});

			}
		});
	} else{
		layer.msg('请完善信息');
	}
});