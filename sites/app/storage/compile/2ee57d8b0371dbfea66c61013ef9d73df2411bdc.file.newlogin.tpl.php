<?php /* Smarty version Smarty-3.1.17, created on 2020-04-01 20:23:14
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/manage/newlogin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5162859975e846f57189fc5-84755169%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2ee57d8b0371dbfea66c61013ef9d73df2411bdc' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/manage/newlogin.tpl',
      1 => 1585743791,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5162859975e846f57189fc5-84755169',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e846f571abbf1_70477158',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e846f571abbf1_70477158')) {function content_5e846f571abbf1_70477158($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en" ng-app="MemberLogin">
<head>
        <meta charset="utf-8" />
    <title> 管理系统</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="/public/manage/jixuantian/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/manage/jixuantian/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/public/manage/jixuantian/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="/public/manage/jixuantian/css/ace.min.css" />
    <link rel="stylesheet" href="/public/manage/jixuantian/css/ace-rtl.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/public/manage/jixuantian/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/public/manage/jixuantian/js/html5shiv.js"></script>
    <script src="/public/manage/jixuantian/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/public/manage/jixuantian/css/login.css">
</head>

<body class="login-layout">
<div class="browser-tip">
    <!--
    <div class="container">
        <span>您的浏览器版本过低，推荐使用 360极速浏览器极速模式 访问本系统</span>
        <a href="http://chrome.360.cn/" target="_blank" class="now-download">立即下载</a>
        <a href="javascript:;" class="close-tip" onclick="closeTip(this)">×</a>
    </div>
    -->
</div>
<div class="header-top">
    <div class="container clearfix">
        <div class="top-left">
            <a href="/index/index">
                                    <img src="/public/manage/jixuantian/picture/2919fc30-9310-2135-8c938382ee8e-tbl.png" width="35px" alt="logo" class='web-logo'>
                                <span>欢迎来到极炫天小程序</span>
            </a>
        </div>
        <div class="top-right">
            <!--
            <a href="http://www.fenxiaobao.xin" class="icons i-index">官网首页</a>
            <a href="http://bbs.fenxiaobao.xin" class="icons i-discuss">天店通商家社区</a>
            <a href="http://www.fenxiaobao.xin/index/help" class="icons i-help">帮助中心</a>
	    -->
            <a href="javascript:;" class="icons i-tel">服务热线 18580858050</a>
        </div>
    </div>
</div>


<div class="main-container">
    <div class="main-content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="login-container">
                    <!--
                    <div class="center">
                        <h1>
                            <a href="#" style="display:block;text-align:center;">
                                <img src="picture/fxblog_03.png" alt="logo">
                            </a>
                        </h1>
                    </div>
                    -->
                    <div class="space-6"></div>
                    <div class="position-relative" style="min-height:680px;">
                        <!-- 右侧内容 -->
                        <div class="help-contact">
                            <!-- <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2271654662&site=qq&menu=yes"><img src="picture/icon_contact0.png" class="icon" alt="图标">联系客服，全程协助</a> -->
                            <!--
                            <a class="attention-code" href="javascript:;"><img src="picture/831fd6e5-f0fc-2295-201e30420e2a-tbl.jpeg" class="icon" alt="图标">关注官方微信，了解更多资讯
                                <div class="code-wrap">
                                    <img src="picture/code.jpg" alt="二维码">
                                    <p>关注官方微信<br>了解更多资讯</p>
                                </div>
                            </a>
                            -->
                            <a target="_blank" href="#"><img src="/public/manage/jixuantian/picture/icon_help0.png" class="icon" alt="图标">联系我们</a>
                            <div class="code-box">
                                <img src="/public/manage/jixuantian/picture/831fd6e5-f0fc-2295-201e30420e2a-tbl.jpeg" alt="二维码">
                                <p>扫码加入微信交流群</p>
                            </div>
                        </div>
                        <div id="login-box" class="login-box visible widget-box no-border">
                            <!--<div class="code-switch"></div>-->
                            <div class="widget-body">
                                <div class="widget-main" ng-controller="MemberLoginController">
                                    <h4 class="header blue lighter bigger">
                                        <!-- <i class="icon-coffee green"></i> -->
                                        登录
                                    </h4>
                                    <!--<div class="space-6" ng-show="tip" ng-bind="tip"></div>-->
                                    <form name="member_login_form">
                                        <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="mobile" ng-minlength="11" ng-maxlength="11" type="number" class="form-control" placeholder="手机号" />
                                                    <!-- <input required="required" type="number" class="form-control" placeholder="手机号" /> -->
                                                    <i class="icon-mobile-phone"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="password" ng-minlength="6" ng-maxlength="50" type="password" class="form-control" placeholder="密码" />
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>
                                            <input type="hidden" value="manage" id="from_now">
                                            <div class="clearfix" style="padding-top: 10px;padding-bottom: 10px;">
                                                <label class="inline">
                                                    <input ng-model="remember" ng-true-value="1" ng-false-value="0" type="checkbox" value="1" class="ace" />
                                                    <span class="lbl">记住账号</span>
                                                </label>

                                                <button ng-disabled="!member_login_form.$valid" ng-click="loginAction()" type="submit" class="width-35 pull-right btn btn-sm btn-primary login-btn">
                                                    登录<i class="icon-key"></i>
                                                </button>

                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                    </form>
                                </div><!-- /widget-main -->

                                <div class="toolbar clearfix">
                                    <!--
                                    <div>
                                        <a href="https://www.tiandiantong.com/manage/user/index#forget" class="forgot-password-link">
                                            <i class="icon-arrow-left"></i>
                                            忘记密码?
                                        </a>
                                    </div>
                                    -->
                                    <div>
                                    </div>
                                    <div>
                                        <a href="/index/index#name2" class="user-signup-link">
                                            申请开通
                                            <i class="icon-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /widget-body -->
                        </div><!-- /login-box -->

                        <div id="forgot-box" class="forgot-box widget-box no-border">
                            <div class="widget-body">
                                <div class="widget-main" ng-controller="MemberForgetController">
                                    <h4 class="header red lighter bigger">
                                        <i class="icon-key"></i>
                                        找回密码
                                    </h4>
                                    <!--<div class="space-6" ng-show="tip">{{tip}}</div>-->
                                    <form name="member_forget_form">
                                        <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="mobile" ng-minlength="11" ng-maxlength="11" type="number" class="form-control" placeholder="输入手机号" />
                                                    <i class="icon-envelope"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right get-code">
                                                    <input required="required" ng-model="imgCode" type="number" class="form-control" placeholder="图片验证码" />
                                                    <img alt="验证码" title="点击刷新验证码" class="get-code" onclick="javascript:this.src='picture/ea8e8c4909964c308b9d047f6b6dab12.gif'+Math.random();" src="/manage/user/validate" style="position: absolute;top:4px;right: 4px;z-index: 10;cursor: pointer;border-radius: 3px;" />
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right get-code">
                                                    <input required="required" ng-model="code" type="number" ng-keydown="keyEvent()" class="form-control" placeholder="验证码" />
                                                    <input class="code" type="button" ng-click="fetchCode()" value="获取验证码">
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="password" ng-minlength="6" ng-maxlength="50" type="password" class="form-control" placeholder="设置新密码" />
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="repwd" ng-minlength="6" ng-maxlength="50" type="password" class="form-control" placeholder="确认新密码" />
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>
                                            <div class="clearfix">
                                                <button ng-disabled="!member_forget_form.$valid" ng-click="forgetAction()" type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    重置密码<i class="icon-arrow-right icon-on-right"></i>
                                                </button>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div><!-- /widget-main -->

                                <div class="toolbar center">
                                    <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                        登录
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            </div><!-- /widget-body -->
                        </div><!-- /forgot-box -->

                        <div id="signup-box" class="signup-box widget-box no-border" style="background-color: rgba(0,0,0,0);">
                            <div class="widget-body" style="padding: 5px 5px 0 0;background-color: rgba(0,0,0,0);">
                                <div class="widget-main" ng-controller="MemberRegisterController" style="position: relative;border-radius: 4px 4px 0 0;">
                                    <div class="g-imgtip"><span>企业认证送50币</span></div>
                                    <h4 class="header green lighter bigger" style="border-radius: 4px 4px 0 0;">
                                        <!-- <i class="icon-group blue"></i> -->
                                        企业级·SaaS软件服务商
                                    </h4>
                                    <div class="reg-type">
                                        <div class="reg-type-item" data-type="1">
                                            <div class="reg-type-name">
                                                <img src="/public/manage/jixuantian/picture/icon_wsc.png" alt="微商城图标">
                                                <p>微商城</p>
                                            </div>
                                            <p>企业级 免费微商城<br>众多营销工具，助力企业微营销</p>
                                        </div>
                                        <div class="reg-type-item" data-type="2">
                                            <div class="reg-type-name">
                                                <img src="/public/manage/jixuantian/picture/icon_xcx.png" alt="小程序图标">
                                                <p>小程序</p>
                                            </div>
                                            <p>一键生成 无需开发<br>出色的用户体验 精准的推广传播</p>
                                        </div>
                                    </div>
                                    <form name="member_register_form">
                                        <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="mobile" ng-minlength="11" ng-maxlength="11" type="number" class="form-control" placeholder="手机号" />
                                                    <i class="icon-mobile-phone"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right get-code">
                                                    <input required="required" ng-model="imgCode" type="number" class="form-control" placeholder="图片验证码" />
                                                    <img alt="验证码" title="点击刷新验证码" class="get-code" onclick="javascript:this.src='picture/ea8e8c4909964c308b9d047f6b6dab12.gif'+Math.random();" src="/manage/user/validate" style="position: absolute;top:4px;right: 4px;z-index: 10;cursor: pointer;border-radius: 3px;" />
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right get-code">
                                                    <input required="required" ng-model="code" type="number" ng-keydown="keyEvent()" class="form-control" placeholder="手机验证码" />
                                                    <input class="code" type="button" ng-click="fetchCode()" value="获取验证码">
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="nickname" ng-trim="true" type="text" class="form-control" placeholder="商家名" />
                                                    <i class="icon-user"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input required="required" ng-model="password" ng-minlength="6" ng-maxlength="50" type="password" class="form-control" placeholder="设置密码" />
                                                    <i class="icon-lock"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix" id="city_choose">
                                                <span class="block col-xs-6" style="padding-left:0">
                                                    <select class="form-control prov"  style="height: 38px;padding: 6px 12px;">
                                                    </select>
                                                </span>
                                                <span class="block col-xs-6" style="padding-right:0">
                                                    <select class="form-control city" style="height: 38px;padding: 6px 12px;" disabled="disabled">
                                                    </select>
                                                </span>
                                            </label>
                                            <div>
                                                <button ng-disabled="!member_register_form.$valid" ng-click="registerAction()" type="submit" class="btn btn-md btn-block btn-orange">确认注册</button>
                                                <div style="overflow: hidden;">
                                                    <a href="javascript:;" onclick="show_box('login-box'); return false;" class="back-to-login-link pull-left">已有账户，立即登录</a>
                                                    <span class="pull-right" id="chooseRegType" style="color: #38f;cursor: pointer;">重新选择类型</span>
                                                </div>
                                                
                                            </div>
                                            <input type="hidden" type="number" id="registerType"/>
                                        </fieldset>
                                    </form>
                                </div>

                                <!-- <div class="toolbar center" style="border-radius: 0 0 4px 4px;">
                                    <a href="#" onclick="show_box('login-box'); return false;" class="back-to-login-link">
                                        已有账户，立即登录
                                    </a>
                                </div> -->
                            </div><!-- /widget-body -->
                        </div><!-- /signup-box -->

                        <div class="copyright">
                            <p>2016-2020 &copy; 重庆极炫天互联网信息服务有限公司 · All Rights Reserved | <a href="http://www.miitbeian.gov.cn/" target="_blank"></a></p>
                            <p>友情链接：<a href="http://www.kuaidi100.com" target="_blank">快递100</a></p>
                        </div>
                    </div><!-- /position-relative -->
                    <!-- 页脚版权 -->
                    
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div>
</div><!-- /.main-container -->
<!-- basic scripts -->

<!--[if !IE]> -->

<!-- <![endif]-->

<!--[if IE]>
<script src="/public/manage/jixuantian/js/jquery-1.10.2.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/public/manage/jixuantian/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/public/manage/jixuantian/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<!--<script src="/public/manage/jixuantian/js/jquery.cityselect.js"></script>
<script type="text/javascript" src="/public/manage/jixuantian/js/layer.js"></script>-->

<script type="text/javascript">
    function show_box(id) {
        jQuery('.widget-box.visible').removeClass('visible');
        jQuery('#'+id).addClass('visible');
    }
    var wxjs   = JSON.parse('');
    $(function () {
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
        browser();

        // 选择注册类型
        $(".reg-type").on('click', '.reg-type-item', function(event) {
            event.preventDefault();
            var type = $(this).data('type');
            console.log(type);
            layer.msg('暂不支持自助注册，请联系客服注册');
            return;
//            $('#registerType').val(type);
//            $(this).parents('.reg-type').stop().fadeOut();
        });
        $("#chooseRegType").on('click',function(){
            $('.reg-type').stop().fadeIn();
        })
    });
    function closeTip(elem){
        $(elem).parents('.browser-tip').stop().hide();
    }
    function browser(){
        if (navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE6.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE7.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE8.0" || navigator.appName == "Microsoft Internet Explorer" && navigator.appVersion.split(";")[1].replace(/[ ]/g, "") == "MSIE9.0") {
            console.log("您的浏览器版本过低，请下载IE9以上版本");
            $(".browser-tip").css("display","block");
        }else{
            $(".browser-tip").css("display","none");
        }
    }
</script>
<script language="javascript">
    //防止页面后退
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>
<!--<script src="/public/manage/jixuantian/js/angular.min.js"></script>
<script src="/public/manage/jixuantian/js/angular-root.js"></script>
<script src="/public/manage/jixuantian/js/manage-login.js"></script>-->
<script src="/public/plugin/citySelect/jquery.cityselect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/newlogin.js"></script>
<script src="/public/manage/vendor/angular.min.js"></script>
<script src="/public/manage/vendor/angular-root.js"></script>
<script src="/public/manage/controllers/manage-login.js"></script>
<script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script>
    var from ;
    $(function(){
        from = $("#from_now").val();
    });
    var fields = document.querySelectorAll('input');
    for (var i = 0; i < fields.length; i++) {
      fields[i].autocomplete="on";   
    }
</script>
</body>
</html><?php }} ?>
