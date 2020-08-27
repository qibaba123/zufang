/*图片预览*/	
$(document).ready(function(){
	imgPrew();
})
function imgPrew(){
	var $images = $('.t_fsz');
	var options = {
    	// inline: true,
    	url: 'data-original'
 	};
  	$images.viewer(options);
}
/*折叠效果*/
function fold(obj){
	if($(obj).find(".row-down").attr("src") == "/public/site/img/helpcenter/shang.png"){
		$(obj).find(".row-down").attr("src","/public/site/img/helpcenter/xia.png");
		/*$(this).find(".newPic").attr("src","/public/site/img/helpcenter/icon_huise.png");*/

		$(obj).find(".news").css("color","#333");
		$(obj).siblings(".introduceDetail").slideUp();
	}else{
		$(obj).find(".row-down").attr("src","/public/site/img/helpcenter/shang.png");
		/*$(this).find(".newPic").attr("src","/public/site/img/helpcenter/icon_lanse.png");*/
		$(obj).find(".news").css("color","#0BD8D8");
		$(obj).siblings(".introduceDetail").slideDown();
		$(obj).parents().siblings().children(".introduceDetail").hide();
		$(obj).parents().siblings().find(".row-down").attr("src","/public/site/img/helpcenter/xia.png");
		/*$(this).parents().siblings().find(".newPic").attr("src","/public/site/img/helpcenter/icon_huise.png");*/
		$(obj).parents().siblings().find(".news").css("color","#333");

	}
}
/* 导航栏*/
 $(".courseList ul li").click(function(){
			$(this).addClass("focusClick").siblings().removeClass("focusClick");
			var i = $(this).index();
			//var parentElem = $(this).parents(".content");
            //parentElem.find(".courseContent").removeClass("courseContentBlock");
            $(".courseContent").eq(i).show().siblings().hide();
	});
    $(".introduceDetailList").click(function(){    	    	
    	var index = $(this).parent(".introduceDetail").children(".introduceDetailList").index(this);    //从父元素中查找子元素的位置索引
   	   /* $(".courseDetailBox .courseDetail").eq(index).show().siblings().hide();*/
   	    $(this).addClass("changeColor").siblings().removeClass("changeColor");
    });
/*右侧数据获取*/
function sonList(obj){
	var index = $(obj).parent(".introduceDetail").children(".introduceDetailList").index(obj);    //从父元素中查找子元素的位置索引
	/*$(".courseDetailBox .courseDetail").eq(index).show().siblings().hide();*/
	$(obj).addClass("changeColor").siblings().removeClass("changeColor");
	var link  = $(obj).data('link');
	var title = $(obj).data('title');
	var id    = $(obj).data('id');
	var data={
		'link':link,
	};
	if(link) {
		$.ajax({
			'type': 'post',
			'url': '/index/content',
			'data': data,
			'dataType': 'json',
			'success': function (ret) {
				if (ret.ec == 200) {
					var html = '';
					html += "<div class='sonTitle'>" + title + "</div>";
					html += ret.data;
					html += "</div></div>";
					$('.courseDetail').html(html);
					$('.yes').attr('data-id',id);
					$('.no').attr('data-id',id);
					$('.feedback').css("display","block");
					$(".solve").css("display","block");
					$(".solve").prev().css("display","none");
					imgPrew();
					/*console.log(ret.data);*/
				} else {
					alert(ret.em);
				}
			}
		})
	}
}
$(".courseList ul li").click(function(){
	$(this).children("span").css("color","#0BD8D8");
	$(this).siblings().children("span").css("color","#fff");
});
/*分类数据*/
function centerType(obj){
	var type = $(obj).data('type');
	var data={
		'type':type,
	};
	$.ajax({
		'type': 'post',
		'url': '/index/centerType',
		'data': data,
		'dataType': 'json',
		'success': function (ret) {
			if (ret.ec == 200) {
				var list = ret.data;
				var html = '';
				for (var i = 0; i < list.length; i++) {
				html += "<div class='introduceList'>";
				html += "<div class='introduceTittle' onclick='fold(this)'>";
				html +=	"<img src='" + list[i].logo + "' class='newPic'/>";
				html +=	"<span class='news'>" + list[i].name + "</span>";
				html +=	"<img src='/public/site/img/helpcenter/xia.png' class='row-down'/>";
				html +=	"<div class='clear'></div></div>";
				html +=	"<div class='line'></div>";
				html += "<div class='introduceDetail' data-id='1'>";
				var sonlist=list[i].list;
					for (var a = 0; a < sonlist.length; a++) {
						if(a==0){
							html += "<div class='introduceDetailList changeColor' onclick='sonList(this)' data-id='" + sonlist[a].ha_id + "' data-title='" + sonlist[a].ha_title + "' data-link='" + sonlist[a].ha_link + "'>";
							html += "<p class='introduceDetailFirst'>" + sonlist[a].ha_title + "</p>";
							html += "<p class='introduceDetailSecond'>" + sonlist[a].ha_brief + "</p>";
							html += "</div><div class='line'></div>";
						}else{
							html += "<div class='introduceDetailList' onclick='sonList(this)' data-id='" + sonlist[a].ha_id + "' data-title='" + sonlist[a].ha_title + "' data-link='" + sonlist[a].ha_link + "'>";
							html += "<p class='introduceDetailFirst'>" + sonlist[a].ha_title + "</p>";
							html += "<p class='introduceDetailSecond'>" + sonlist[a].ha_brief + "</p>";
							html += "</div><div class='line'></div>";
						}
					}
				html +=	"</div></div>";
				}
				$('.productIntroduce').html(html);
				var file = '';
				file +="<div class='sonTitle'>"+ret.title+"</div>";
				file +="<div>"+ret.file+"</div>";
				file +="</div></div>";
				$('.courseDetail').html(file);
				$('.yes').attr('data-id',ret.id);
				$('.no').attr('data-id',ret.id);
				$('.feedback').css("display","block");
				$(".solve").css("display","block");
				$(".solve").prev().css("display","none");
			} else {
				layer.msg(ret.em);
			}
		}
	})
}
/*搜索*/
function search(obj){
	var title = $(obj).prev().val();
	var data={
		'title':title,
	};
	if(title) {
		$.ajax({
			'type': 'post',
			'url': '/index/search',
			'data': data,
			'dataType': 'json',
			'success': function (ret) {
				if (ret.ec == 200) {
					var list = ret.data;
					var html = '';
					for (var i = 0; i < list.length; i++) {
						if (i == 0) {
							//html += "<div class='introduceDetailList changeColor' onclick='sonList(this)'>";
							html += "<a class='navlist' target='_blank' href='" + list[i].link + "'>" + list[i].title + "</a>";
						//	html += "</div><div class='line'></div>";
						} else {
							//html += "<div class='introduceDetailList' onclick='sonList(this)'>";
							html += "<a class='navlist' target='_blank' href='" + list[i].link + "'>" + list[i].title + "</a>";
							//html += "</div><div class='line'></div>";
						}
					}
				/*	$('.productIntroduce').html(html);
					var file = '';
					file +="<div class='sonTitle'>"+ret.title+"</div>";
					file +=ret.file;*/
					$('.courseDetail').html(html);
					$('.feedback').css("display","none");
				} else {
					layer.msg(ret.em);
				}
			}
		})
	}
}
/*回车监听*/
$(document).keyup(function(event){
	if(event.keyCode ==13){
		var title = $('.search').val();
		var data={
			'title':title,
		};
		if(title) {
			$.ajax({
				'type': 'post',
				'url': '/index/search',
				'data': data,
				'dataType': 'json',
				'success': function (ret) {
					if (ret.ec == 200) {
						var list = ret.data;
						var html = '';
						for (var i = 0; i < list.length; i++) {
							if (i == 0) {
								//html += "<div class='introduceDetailList changeColor' onclick='sonList(this)'>";
								html += "<a class='navlist' target='_blank' href='" + list[i].link + "'>" + list[i].title + "</a>";
								//	html += "</div><div class='line'></div>";
							} else {
								//html += "<div class='introduceDetailList' onclick='sonList(this)'>";
								html += "<a class='navlist' target='_blank' href='" + list[i].link + "'>" + list[i].title + "</a>";
								//html += "</div><div class='line'></div>";
							}
						}
						/*	$('.productIntroduce').html(html);
						 var file = '';
						 file +="<div class='sonTitle'>"+ret.title+"</div>";
						 file +=ret.file;*/
						$('.courseDetail').html(html);
						$('.feedback').css("display","none");
					} else {
						layer.msg(ret.em);
					}
				}
			})
		}
	}
});
function feedback(obj){
	$(".solve").css("display","none");
	$(".solve").prev().css("display","block");
	var id   = $(obj).data('id');
	var type = $(obj).data('type');
	var data= {
		'id': id,
		'type': type,
	};
	$.ajax({
		'type': 'post',
		'url': '/index/solve',
		'data': data,
		'dataType': 'json',
		'success': function (ret) {
		}
	})
}