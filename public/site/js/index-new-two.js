var swiper = new Swiper('.swiper-container', {
    loop: true,
    speed: 1500,
    pagination: '.swiper-pagination',
    paginationClickable: true,
    autoplay:3000
});
$(function(){
//      $('#code-model').stop().show();
//      $('#code-model .close-btn').click(function(){
//          $('#code-model').stop().hide();
//      })
    $('#dy-model').stop().show();
    $('#dy-model .close-btn').click(function(){
        $('#dy-model').stop().hide();
    })
    $('.case #content-right .right-wrap').eq(0).addClass('active').siblings().removeClass('active');
    $('#caseList .item').eq(0).addClass('active').siblings().removeClass('active');
    $('#caseList .item').click(function(){
        var index=$(this).index();
        $(this).addClass('active').siblings().removeClass('active');
        $('.case #bgImages .bg').eq(index).addClass('active').siblings().removeClass('active');
        $('.case #content-right .right-wrap').eq(index).addClass('active').siblings().removeClass('active');
    });
    /*$('#openVideo').click(function(){
        $('#video-wrap').show();
        $('#video-con').show();
    });*/
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
    //免费领取弹窗js开始
    var freeModel = setTimeout(function(){
        $('#freeApply-model').stop().show();
        $('#freeGet-model').stop().show();
    },3000);
    $('#close-freeGet').click(function(){
        $('#freeApply-model').stop().hide();
        $('#freeGet-model').stop().hide();
    })
    //免费领取弹窗js结束
    /*$('#caseList .item').click(function(){
        var html = '';
        html += '';
    });*/


    //点击黑色遮罩，关闭免费申请代理弹出层
    $('#freeApply-model').click(function(){
        /*$('#freeApply-model').hide();
        $('#freeApply-con').hide();*/
        $('#freeApply-model').stop().hide();
        $(".company-now").css('display','none');
        $('#register-model').stop().hide();
        $('#register-con').stop().hide();
        $('#freeGet-model').stop().hide();
    })
    //点击关闭按钮，关闭免费申请代理弹出层
    $('#modelClose-btn').click(function(){
        $(".company-now").css('display','none');
        $('#register-model').hide();
        $('#register-con').hide();
    })


});


// 提交信息
function submitData() {
    var name    = $('#alert_name').val();
    var mobile  = $('#alert_mobile').val();
    var code    = $('#alert_code').val();
    var user_code    = $('#alert_user_code').val();
    if(mobile.length != 11){
        layer.msg('请填写有效的手机号');
        return false;
    }
    var data = {
        'name'    : name,
        'mobile'  : mobile,
        'code'    : code,
        'user_code' : user_code
    };
    var loading = layer.load(1, {shade:[0.4, '#000']});
    $.ajax({
        'type' : 'post',
        'url'  : '/index/saveApply',
        'data' : data,
        'dataType' : 'json',
        success : function(json_ret){
            layer.close(loading);
            if(json_ret.em){
                layer.msg(json_ret.em);
            }
            if(json_ret.ec == 200){
                $('#freeGet-model').stop().hide();
                $('#freeApply-model').stop().hide();
            }
        },
        complete: function () {
            layer.close(loading);
        }
    });
}

/**
 *获取短信验证码
 */
function freeGetCode(){
    var mobile = $('#alert_mobile').val();
    var code   = $('#alert_code').val();
    var type   = 1;
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
                    freeDjs();
                }else{
                    freeChangeCode();
                }
            }
        });
    }else{
        layer.msg('请输入正确的手机号')
    }
}

function freeGetCodeNoVerify(){
    var mobile = $('#alert_mobile').val();
    var type   = 1;
    if (!/^1\d{10}/.test(mobile)) {
        layer.msg('手机号格式不正确');
        return;
    }

    if(mobile){
        $.ajax({
            url: '/register/sendCodeNoVerify',
            type: 'post',
            data: { "mobile":mobile,"repeat":1,'type':type},
            dataType: 'json',
            success:function(json_ret){
                layer.msg(json_ret.em);
                if(json_ret.ec==200){
                    freeDjs();
                }else{
                    freeChangeCode();
                }
            }
        });
    }else{
        layer.msg('请输入正确的手机号')
    }
}

//  验证码倒计时
function freeDjs(){
    var time=60;
    $('.freeGetVer').text(time+'s');
    var timer=setInterval(function(){
        time--;
        if(time<0){
            clearInterval(timer);
            $('.freeGetVer').text('获取验证码');
            $('.freeGetVer').attr('onclick','freeGetCode()');
        }else{
            $('.freeGetVer').text(time+'s');
            $('.freeGetVer').removeAttr('onclick');
        }
    },1000)
}


function freeChangeCode(ele){
    $('.free-get-code-change').attr('src','/register/validate?d='+Math.random());
    //javascript:this.src='/register/validate?d='+Math.random();
}