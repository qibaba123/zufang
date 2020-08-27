
$(function(){
    var windowScroT = $(window).scrollTop();
    if(windowScroT>300){
        $(".back-top").stop().fadeIn();
    }
    if(windowScroT>430){
        $(".header").addClass('fixed-nav');
    }
    $(window).scroll(function() {
        var hidtop = $(this).scrollTop();
        if(hidtop>300){
            $(".back-top").stop().fadeIn();
        }else{
            $(".back-top").stop().fadeOut();
        }
        if(hidtop>430){
            $(".header").addClass('fixed-nav');
        }else{
            $(".header").removeClass('fixed-nav');
        }
    });
    //操控视频内容
    $('.openVideoNow').click(function(){
        $('#video-wrap').show();
        $('#video-con').show();
        document.getElementById('video-play').play();
    });

    $('#close-video').click(function(){
        document.getElementById('video-play').pause();
        $('#video-wrap').hide();
        $('#video-con').hide();
    });
    $('#video-wrap').click(function(){
        $('#video-wrap').hide();
        $('#video-con').hide();
    });

    $('#close-qrcode').click(function(){
        $('#qrcode-wrap').hide();
        $('#qrcode-con').hide();
    });
    $('#qrcode-wrap').click(function(){
        $('#qrcode-wrap').hide();
        $('#qrcode-con').hide();
    });
    

	// 获取省份信息
    $.ajax({
        type: 'Get',
        url: "/index/getProvince" ,
        data: '' ,
        dataType: 'json',
        success: function(data){
            var option="<option>省份</option>";
            $(data).each(function(k,v){
                option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
            });
            $(".form-field-select-3").html(option);
        }
    });

    $(".form-field-select-3").change(function(){
        $(".form-field-select-4").html('');
        $(".form-field-select-5").html('');
        var p_id = $(this).val();
        $.ajax({
            type: 'Get',
            url: "/index/getCity/id/"+ p_id,
            data: '' ,
            dataType: 'json',

            success: function(data){
                var option="<option>地市</option>";
                $(data).each(function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $(".form-field-select-4").html(option);
            }
        });
    });

    $(".form-field-select-4").change(function(){
        $(".form-field-select-5").html('');
        var p_id = $(this).val();
        $.ajax({
            type: 'Get',
            url: "/index/getArea/id/"+ p_id,
            data: '' ,
            dataType: 'json',

            success: function(data){
                var option="<option>县区</option>";
                $(data).each(function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $(".form-field-select-5").html(option);
            }
        });
    });
    
    // 返回顶部
    $(".back-top").click(function(event) {
        $('html,body').animate({
            scrollTop: 0
        },
        500);
    });
    // 滚动条美化
    /*$("body,html").niceScroll({
        cursorborder:"0",
        cursorcolor:"#444",
        cursorwidth:"6",
        cursoropacitymax:"0.8"
    });*/
    $(".user-opera").hover(function() {
        $(this).find('.drop-menu').stop().fadeIn();
    }, function() {
        $(this).find('.drop-menu').stop().fadeOut();
    });
    //
    /*$('#menu .select-wrap>li').mouseover(function(){
        var index=$(this).index();
        if(!index){
            index = 0;
        }
        $('#menu .select-wrap>li').eq(index).addClass('active').siblings().removeClass('active');
        //$('#menu .select-wrap>li.active>a').eq(index).addClass('active').siblings().removeClass('active');
    });*/


    // 页面平滑过渡
    $('#doquick-nav a[href*=#]').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var $target = $(this.hash);
            $target = $target.length && $target || $('[name=' + this.hash.slice(1) + ']');
            if ($target.length) {
                var targetOffset = $target.offset().top;
                $('html,body').animate({
                            scrollTop: targetOffset-64
                        },
                        800);
                return false;
            }
        }
    });
    // 页面滚动导航跟随切换
    $(window).scroll(function(){
        var athorItems=$(".can-doing>.part-con");
        var win_scrollTop=$(window).scrollTop();
        //到要聚焦的a 链接
        var navsAlinks=$("#doquick-nav>a");
        //遍历监听位置的div 找到那个现在正在显示着
        for(var i=0;i<athorItems.length;i++){
            if(athorItems.eq(i).offset().top-200<=win_scrollTop){
                var currentItemName=athorItems.eq(i).attr("id");
                //聚焦
                $('a[href*=#]').removeClass('active');
                navsAlinks.filter("[href=#"+currentItemName+"]").addClass('active');
            }
        }
    });
})
$(function(){
    //注册弹出层
    $('.register-now').click(function(){
        $('.show-name').html('申请试用名额');
        $(".tem-now").css('display','block');
        $(".area-now").css('display','block');
        $('.show-type').val(1);
        $('#register-model').show();
        $('#register-con').show();
        $("#apply_agent").html('立即申请');
    });
    //点击黑色遮罩，关闭注册弹出层
    $('#register-model').click(function(){
        $('#register-model').hide();
        $(".tem-now").css('display','none');
        $(".company-now").css('display','none');
        $(".area-now").css('display','none');
        $('#register-con').hide();
    });
    //点击关闭按钮，关闭注册弹出层
    $('#modelClose-btn').click(function(){
        $('#register-model').hide();
        $(".tem-now").css('display','none');
        $(".company-now").css('display','none');
        $(".area-now").css('display','none');
        $('#register-con').hide();
    })
    //免费申请代理弹出层
    $('.freeApply-btn').click(function(){
        $('.show-name').html('免费申请小程序代理');
        $(".company-now").css('display','inline-block');
        $(".area-now").css('display','none');
        $('.show-type').val(2);
        $('#register-model').show();
        $('#register-con').show();
        $("#apply_agent").html('立即申请');
    });
    //意见反馈二维码弹出层
    $('.qrcode-btn').click(function(){
        console.log('work');
        $('#qrcode-wrap').show();
        $('#qrcode-con').show();
    });
})
//	验证码倒计时
function djs(){
	var time=60;
	$('.getVer').text(time+'s');
	var timer=setInterval(function(){
		time--;
		if(time<0){
			clearInterval(timer);
			$('.getVer').text('获取验证码');
			$('.getVer').attr('onclick','getCode()');
		}else{
			$('.getVer').text(time+'s');
			$('.getVer').removeAttr('onclick');
		}
	},1000)
}

function changeCode(ele){
    $('.get-code-change').attr('src','/register/validate?d='+Math.random());
    //javascript:this.src='/register/validate?d='+Math.random();
}
/**
 *获取短信验证码
 */
function getCode(){
    var mobile = $('#user_mobile').val();
    var code   = $('#code').val();
    var type   = $('.show-type').val();
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
$(".register-btn").click(function() {
    var name     = $("#user_name").val();
    var mobile   = $('#user_mobile').val();
    var pro      = $('#form-field-select-3').val();
    var city     = $('#form-field-select-4').val();
    var area     = $('#form-field-select-5').val();
    var address  = $('#form-field-select-3').find("option:selected").text()+$('#form-field-select-4').find("option:selected").text()+$('#form-field-select-5').find("option:selected").text();
    var company  = $("#user_company").val();
    var code       = $("#code").val();
    var user_code  = $("#user_code").val();
    var tem_id     = $("#tem").val();
    var tem_name   = $("#tem").find("option:selected").text();
    var type       = $('.show-type').val();
    var url        = '';
    var from_type = $('#hid_from_type').val();
    console.log(tem_id);
    console.log(tem_name);
    if (!/^1\d{10}/.test(mobile)) {
        layer.msg('手机号格式不正确');
        return;
    }
    if(type==1){
       url = "/register/addRegister";
       if(!tem_id){
           layer.msg('请选择模板');
           return;
       }
    }else{
        url = "/register/addRegisterAgent";
    }
    if(mobile && name && user_code  && code ) {
        var data = { "name":name,"mobile":mobile,"user_code":user_code,"code":code,"pro":pro,"city":city,"area":area,"tem_id":tem_id,'tem_name':tem_name,'company':company,'address':address,'from_type':from_type};
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        console.log(data);
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

function showattention(obj) {
    document.getElementById(obj).style.display = 'block'
}
function closeattention(obj) {
    document.getElementById(obj).style.display = 'none'
}
function changeOnline(num) {
    if (isNaN(num) && num == "") return;
    for (var i = 1; i <= 6; i++) {
        if (i == num) {
            $('#onlineSort' + i).attr('class', 'online_bar expand');
            $('#onlineType' + i).show()
        } else {
            $('#onlineSort' + i).attr('class', 'online_bar collapse');
            $('#onlineType' + i).hide()
        }
    }
}
$(document).ready(function() {
    $("#floatShow").bind("click",
            function() {
                $('#onlineService').animate({
                            width: 'show',
                            opacity: 'show'
                        },
                        'normal',
                        function() {
                            $('#onlineService').show()
                        });
                $('#floatShow').attr('style', 'display:none');
                $('#floatHide').attr('style', 'display:block');
                return false
            });
    $("#floatHide").bind("click",
            function() {
                $('#onlineService').animate({
                            width: 'hide',
                            opacity: 'hide'
                        },
                        'normal',
                        function() {
                            $('#onlineService').hide()
                        });
                $('#floatShow').attr('style', 'display:block');
                $('#floatHide').attr('style', 'display:none')
            });
    $(document).bind("click",
            function(event) {
                if ($(event.target).isChildOf("#online_qq_layer") == false) {
                    $('#onlineService').animate({
                                width: 'hide',
                                opacity: 'hide'
                            },
                            'normal',
                            function() {
                                $('#onlineService').hide()
                            });
                    $('#floatShow').attr('style', 'display:block');
                    $('#floatHide').attr('style', 'display:none')
                }
            });
    jQuery.fn.isChildAndSelfOf = function(b) {
        return (this.closest(b).length > 0)
    };
    jQuery.fn.isChildOf = function(b) {
        return (this.parents(b).length > 0)
    }
});

$(document).ready(function() {
    $("#floatShow").click();
});

(function(m, ei, q, i, a, j, s) {
    m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
    j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
    j.async = true;
    j.charset = 'UTF-8';
    j.src = '//static.meiqia.com/dist/meiqia.js';
    s.parentNode.insertBefore(j, s);
})(window, document, 'script', '_MEIQIA');
_MEIQIA('entId', 33815);

// 百度统计1、验证网站真实性；2、统计网站的流量，网站的访问，网站的跳出率等

var _hmt = _hmt || [];
(function() {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?8db5aecb9725f8b02dc3f0c7153b80df";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();


var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cspan id='cnzz_stat_icon_1259838606'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1259838606%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));