var swiper = new Swiper('#banner .swiper-container', {
    loop: true,
    speed: 1500,
    pagination: '#banner .swiper-pagination',
    paginationClickable: true,
    autoplay:3000
});

$(function(){
	$('#process-time .item').mouseover(function(){
		var index=$(this).index();
		$(this).addClass('active').siblings().removeClass('active');
		$('#process-con .content').eq(index).addClass('active').siblings().removeClass('active');
	});
    //打开加入我们弹层
    $('#join-us').click(function(){
        //console.log(234);
        $('#recruit-wrap').stop().show();
    });
    //关闭加入我们弹层
    $('#recruit-close').click(function(){
        $('#recruit-wrap').stop().hide();
    });
//		加入我们-招聘内容
    $('.position-list ul li').click(function(){
        var index = $(this).index();
//			alert(index);
        var contentIndex=$(this).parents('.position-list').index();
//			alert(contentIndex);
        $(this).addClass('active').siblings().removeClass('active');
        $(this).parents('.position-list').siblings().find('ul li').removeClass('active');
        $('.recruit-right .content').eq(contentIndex).addClass('active').siblings().removeClass('active');
        $('.recruit-right .content').eq(contentIndex).find('.job-main').eq(index).addClass('descShow').siblings().removeClass('descShow');

        //$('.recruit-right .content').addClass('active').siblings().removeClass('active');
        //$('.recruit-right .content').find('.job-main').eq(index).addClass('descShow').siblings().removeClass('descShow');

    })
        $('.job-main *').css({color: '#fff !important', backgroundColor: 'transparent !important', lineHeight: '20px'})
        $('.job-main *').addClass('rich-style')
});



//	证书
var zhengshu = new Swiper('.zhengshu', {
    pagination: '.zhengshu .swiper-pagination',
    slidesPerView: 3,
    paginationClickable: true,
//      spaceBetween: 15,
    autoplay : 3000,
    loop : true,
});

$(".zhengshu").hover(function () {
   zhengshu.stopAutoplay();
},
function () {
	zhengshu.startAutoplay();
});
//	资历证书
var zili = new Swiper('.zili', {
    pagination: '.zili .swiper-pagination',
    slidesPerView: 2,
    paginationClickable: true,
    spaceBetween: 30,
    autoplay : 3000,
    loop : true,
});

$(".zili").hover(function () {
   zili.stopAutoplay();
},
function () {
	zili.startAutoplay();
});