var swiper = new Swiper('.swiper-container', {
  slidesPerView: 1,
  spaceBetween:0,
  loop: true,
  speed:1000,
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
// 	控制swiper的自动播放
console.log(swiper.slides.length);
if(swiper.slides.length-2<=1){
		console.log('slide小于2')
		swiper.autoplay.stop()
}
var imgSrc = "<{$category['cc_tem_cover']}>";
console.log(imgSrc);
$(function(){
	if(imgSrc){
		$('.productBrief-wrap').attr('background',imgSrc);
	}
	$('#process-time .item').mouseover(function(){
		var index=$(this).index();
		$(this).addClass('active').siblings().removeClass('active');		
		$('#process-con .content').eq(index).addClass('active').siblings().removeClass('active');
	});
	$('.classify-nav li').click(function(){
		$(this).addClass('active').siblings().removeClass('active');
	})
	$(".preview-btn").click(function() {
	    console.log(789);
        var id  = $(this).data('id');
        if(id){
            $.ajax({
                type: 'post',
                url:  '/home/getImgData',
                data: {id:id},
                dataType: 'json',
                success: function(ret){
                    if(ret.ec==200){
                        console.log(ret);
                        $('.img-box-old').html('');
                        $('.case-nav').html('');
                        var html = '';
                        var img  = '';
                        for(var i=1;i<=5;i++){
                            if(ret.imgData['cc_logo'+i] && ret.imgData['cc_icon'+i]){
                                if(i==1){
                                    img  += '<img src="'+ret.imgData['cc_logo'+i]+'" alt="" class="active" />';
                                    html += '<div class="nav-item case-item1 active">';
                                }else{
                                    img  += '<img src="'+ret.imgData['cc_logo'+i]+'" alt="" />';
                                    html += '<div class="nav-item case-item1 ">';
                                }
                                html += '<img src="'+ret.imgData['cc_icon'+i]+'" alt="" >';
                                html += '<div class="nav-text">'+ret.imgData['cc_navName'+i]+'</div>';
                                html += '</div>';

                            }
                        }
                        if(img==''){
                            img = '<img src="'+ret.imgData['cc_logo']+'" alt="" class="active"/>';
                        }
                        $('.img-box-old').html(img);
                        $('.case-nav').html(html);

                        $('.content-model').show();
                        $('.preview-img').show();
                    };
                    $('.case-nav .nav-item').click(function(){
                        var index=$(this).index();
                        //$('.case-nav .nav-item .nav-text').eq(index).addClass('change-color').siblings().removeClass('change-color');
                        console.log(index);
                        $('.img-box-old img').eq(index).addClass('active').siblings().removeClass('active');
                    })
                }
            });
        }

    });
	$(".preview-img .close").click(function() {
        $('.content-model').hide();
        $('.preview-img').hide();
   });

});