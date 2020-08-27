$(function(){
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        speed: 1500,
        // pagination: '.swiper-pagination',
        // paginationClickable: true,
        autoplay:3000
    });
});
// 显示弹框
function showApplymodal(){
    $('.fudong-tips').stop().fadeIn();
}
// 关闭弹框
function hideApplymodal(){
    $(".fudong-tips").stop().fadeOut();
}
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
/**
 *获取短信验证码
 */
function getCode(){
    var mobile = $('#mobile').val();
    var captcha_code   = $('#code').val();
    if (!/^1\d{10}/.test(mobile)) {
        layer.msg('手机号格式不正确');
        return;
    }
    if(!captcha_code){
        layer.msg('请输入图片验证码');
        return;
    }
    if(mobile){
        $.ajax({
            url: '/register/sendCode',
            type: 'post',
            data: { "mobile":mobile,"repeat":1,"code":captcha_code},
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
function changeCode(ele){
    $('.get-code-change').attr('src','/register/validate?d='+Math.random());
}

// 提交信息
function submitData() {
    var name = $('#name').val();
    var mobile = $('#mobile').val();
    var _from = $('#from').val();
//        var code = $('#code').val();
//        var user_code = $('#user_code').val();
    var loading = layer.load(1, {shade:[0.4, '#000']});
    var data = {
        name:name,
        mobile:mobile,
//            code:code,
//            user_code:user_code,
        tem_id:0,
        noNeedCode:1,
        tem_name: '社区团购',
        from : _from
    };
    $.ajax({
        'type' : 'post',
        'url'  : '/register/addAppletRegisterNoVerify',
        'data' : data,
        'dataType' : 'json',
        success : function(json_ret){
            layer.close(loading);
            if(json_ret.em){
                layer.msg(json_ret.em);
            }
            if(json_ret.ec == 200){
                $('#name').val('');
                $('#mobile').val('');
//                    $('#code').val('');
//                    $('#user_code').val('');
//                    $(".fudong-tips").stop().fadeOut();

            }
        },
        complete: function () {
            layer.close(loading);
        }
    });
}

function submitDataBottom() {
    var name = $('#name_bottom').val();
    var mobile = $('#mobile_bottom').val();
    var _from = $('#from').val();
//        var code = $('#code').val();
//        var user_code = $('#user_code').val();
    var loading = layer.load(1, {shade:[0.4, '#000']});
    var data = {
        name:name,
        mobile:mobile,
//            code:code,
//            user_code:user_code,
        tem_id:0,
        noNeedCode:1,
        tem_name: '二手车小程序',
       from : _from
    };
    $.ajax({
        'type' : 'post',
        'url'  : '/register/addAppletRegisterNoVerify',
        'data' : data,
        'dataType' : 'json',
        success : function(json_ret){
            layer.close(loading);
            if(json_ret.em){
                layer.msg(json_ret.em);
            }
            if(json_ret.ec == 200){
                $('#name_bottom').val('');
                $('#mobile_bottom').val('');
//                    $('#code').val('');
//                    $('#user_code').val('');
//                    $(".fudong-tips").stop().fadeOut();

            }
        },
        complete: function () {
            layer.close(loading);
        }
    });
}

(function() {var _53code = document.createElement("script");_53code.src = "https://tb.53kf.com/code/code/6809a889dd33578aa1673d67aa49da8e/3";var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(_53code, s);})();