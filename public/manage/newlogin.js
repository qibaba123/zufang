function show_box(id) {
    jQuery('.widget-box.visible').removeClass('visible');
    jQuery('#'+id).addClass('visible');
}
var wxjs   = JSON.parse('<{$wxjs}>');
$(function() {
    var mao = location.hash;
    var id  = '';
    switch (mao) {
        case '#login' :
            id = 'login-box';
            break;
        case '#register' :
            id = 'signup-box';
            break;
        case '#forget' :
            id = 'forgot-box';
            break;
    }
    if (id) {
        $('.widget-box.visible').removeClass('visible');
        $('#'+id).addClass('visible');
    }
    // 二维码登录切换
    $(".code-switch").click(function(event) {
        var obj = new WxLogin(wxjs);
        $(this).toggleClass('pclogin');
    });
    // 省市选择
    $("#city_choose").citySelect({prov:"河南",city:"郑州"});
    // 低版本浏览器下载提示高版本
    // browser();

    // 选择注册类型
    $(".reg-type").on('click', '.reg-type-item', function(event) {
        event.preventDefault();
        var type = $(this).data('type');
        console.log(type);
        layer.msg('暂不支持自助注册，请联系客服注册');
        return;
        $('#registerType').val(type);
        $(this).parents('.reg-type').stop().fadeOut();
    });
    $("#chooseRegType").on('click',function(){
        $('.reg-type').stop().fadeIn();
    })
    console.log('Cookie---------');
    var isBrowserTip = getCookie('browserDowntip');
    console.log(isBrowserTip);
    console.log(isBrowserTip==1);
    console.log(isBrowserTip==0);
    if(isBrowserTip==1){
        console.log("显示浏览器提示");
        $('.browser-tip').css("display","block");
    }else{
        console.log("隐藏浏览器提示");
        $('.browser-tip').css("display","none");
    }
});
// 密码登录扫码登录切换
function toggleLogintype(type){
    $('.login-type-toggle-item').removeClass('show');
    $('.js_login').removeClass('show');
    console.log(type);
    if(type=='pass'){
        $('.js_toggle_code').addClass('show');
        $('.js_pass_login').addClass('show');
    }else if(type=='code'){
        $('.js_toggle_pass').addClass('show');
        $('.js_code_login').addClass('show');
    }
}
// 找回密码注册提醒
function toggleOperainput(type){
    $('.js_login').removeClass('show');
    $('.js_toggle_logintype').stop().hide();
    if(type=='findpass'){
        $('.js_find_pass').addClass('show');
    }else if(type=='login'){
        $('.js_pass_login').addClass('show');
        $('.js_toggle_logintype').stop().show();
    }else if(type=='register'){
        $('.js_register').addClass('show');
    }
}
// 切换找回密码步骤
function finpassStep(type){
    $('.js_step').removeClass('show');
    if(type=='one'){
        $('.js_one_step').addClass('show');
    }else if(type=='two'){
        $('.js_two_step').addClass('show');
    }

}

function browser(){
    if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE9.0") {
        console.log("您的浏览器版本过低，请下载IE9以上版本");
        $(".browser-tip").css("display","block");
    }else{
        $(".browser-tip").css("display","none");
    }
}
function closeTip(elem){
    $(elem).parents('.browser-tip').stop().hide();
    //获取当前时间
    var date = new Date();
    var expiresDays = 365;
    //将date设置为10天以后的时间
    date.setTime(date.getTime()+expiresDays*24*3600*1000);
    //将userId和userName两个cookie设置为365天后过期
    document.cookie = "browserDowntip=0;path=/;expires="+date.toGMTString();
}
function getCookie(name){
    var strCookie=document.cookie;
    var arrCookie=strCookie.split("; ");
    console.log(arrCookie);
    for(var i=0;i<arrCookie.length;i++){
        var arr=arrCookie[i].split("=");
        if(arr[0]==name)return arr[1];
        console.log(arr[1]);
    }
    return 1;
}