<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:22:49
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/newlogin.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10236197085e1be289a94f51-91794790%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0b4ad026eefdee494d56add2d60b83a6d89eeeb5' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/newlogin.tpl',
      1 => 1561426294,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10236197085e1be289a94f51-91794790',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'isnet' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be289ad99b1_51007090',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be289ad99b1_51007090')) {function content_5e1be289ad99b1_51007090($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en" ng-app="MemberLogin">
<head>
    <?php  $_config = new Smarty_Internal_Config("default.conf", $_smarty_tpl->smarty, $_smarty_tpl);$_config->loadConfigVars(null, 'local'); ?>
    <meta charset="UTF-8">
    <title><?php echo $_smarty_tpl->getConfigVariable('app_name');?>
</title>
    <link rel="stylesheet" href="/public/manage/assets/css/bootstrap.min.css">
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- basic styles -->

    <link href="/public/manage/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/manage/assets/css/font-awesome.min.css" />

    <!--[if IE 7]>
    <link rel="stylesheet" href="/public/manage/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->

    <!-- fonts -->

    <!-- ace styles -->

    <link rel="stylesheet" href="/public/manage/assets/css/ace.min.css" />
    <link rel="stylesheet" href="/public/manage/assets/css/ace-rtl.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/public/manage/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="/public/manage/assets/js/html5shiv.js"></script>
    <script src="/public/manage/assets/js/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/public/wxapp/newlogin/css/login.css?29">
</head>
<body>
<div class="login-part-wrap">
    <!-- 提示最佳浏览器 -->
    <div class="browser-tip">
        <a href="http://chrome.360.cn/" target="_blank" class="browser-tip-con">
            <div class="left-img"><img src="/public/wxapp/newlogin/images/360-logo.png" alt="360logo"></div>
            <div class="down-btn">立即下载</div>
        </a>
        <div class="close-btn" onclick="closeTip(this)"><img src="/public/wxapp/newlogin/images/icon_close.png" alt="关闭"></div>
    </div>
    <?php if (!$_smarty_tpl->tpl_vars['isnet']->value) {?>
    <section class="top-opera-box main-width">
        <a href="<?php echo $_smarty_tpl->getConfigVariable('main_host');?>
" target="_blank" class="link">返回首页</a>
        <a href="http://bbs.fenxiaobao.xin" target="_blank" class="link">天店通商家社区</a>
        <a href="<?php echo $_smarty_tpl->getConfigVariable('main_host');?>
/index/help" target="_blank" class="link">帮助中心</a>
        <a href="javascript:;" class="link">服务热线 <?php echo $_smarty_tpl->getConfigVariable('service_phone');?>
</a>
    </section>
    <?php }?>
    <section class="login-part">
        <div class="main-width">
            <div class="left-intro">：
                <img src="/public/wxapp/newlogin/images/logo.png" class="logo" alt="logo">
                <ul class="intro-list">
                    <li>全国90%城市覆盖率</li>
                    <li>100+行业模板直接套用</li>
                    <li>为全国2000+商户提供优质服务</li>
                    <li>微信、百度、支付宝、抖音今日头条小程序五端合一</li>
                </ul>
                <img src="/public/wxapp/newlogin/images/img_smallapp.png" class="applet-icon" alt="小程序图标">
            </div>
            <div class="right-login">
                <div class="left-login-con">
                    <!-- 密码扫码登录切换 -->
                    <div class="login-type-toggle js_toggle_logintype">
                        <div class="login-type-toggle-item show js_toggle_code code-switch">
                            <span class="login-tip">扫码登录</span>
                            <img src="/public/wxapp/newlogin/images/icon_qrcode.png" class="login-tip-icon" alt="扫码登录" onclick="toggleLogintype('code')">
                        </div>
                        <div class="login-type-toggle-item js_toggle_pass">
                            <span class="login-tip">密码登录</span>
                            <img src="/public/wxapp/newlogin/images/icon_computer.png" class="login-tip-icon" alt="密码登录" onclick="toggleLogintype('pass')">
                        </div>
                    </div>
                    <!-- 密码登录 -->
                    <div class="login-part-box js_login js_pass_login show" ng-controller="MemberLoginController">
                        <form name="member_login_form" >
                            <div class="label-name">密码登录</div>
                            <div class="login-input-wrap">
                                <div class="input-box">
                                    <input required="required" ng-model="mobile" type="text" ng-minlength="11" ng-maxlength="11" class="login-input" placeholder="注册时填写的手机号" />
                                </div>
                                <div class="input-box">
                                    <input required="required" ng-model="password" ng-minlength="6" ng-maxlength="50" type="password" class="login-input" placeholder="请输入密码" />
                                </div>
                                <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                            </div>
                            <button ng-disabled="!member_login_form.$valid" ng-click="loginAction()" type="submit" class="login-btn">登录</button>
                            <div class="login-fjopera">
                                <div class="remember-pass">
                                    <input id="remember" ng-model="remember" ng-true-value="1" ng-false-value="0" type="checkbox" value="1">
                                    <label for="remember">记住密码</label>
                                </div>
                                <div class="pass-open">
                                    <span class="pass-open-link" onclick="toggleOperainput('findpass')">忘记密码</span>
                                    <span class="pass-open-link" onclick="toggleOperainput('register')">申请开通</span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- 扫码登录 -->
                    <div class="login-part-box js_login js_code_login">
                        <!--<div class="label-name">扫码登录</div>
                        <div class="code-login-img"><img src="/public/wxapp/newlogin/images/erwm.png" alt="二维码"></div>
                        <div class="code-login-tip">请使用微信扫描二维码登录</div>-->
                        <div class="code-login">
                            <div class="code-img" id="wx-login-box">
                                <img src="/public/manage/img/code.jpg" alt="二维码登录">
                            </div>
                        </div>
                    </div>
                    <!-- 找回密码 -->
                    <div class="login-part-box js_login js_find_pass" ng-controller="MemberForgetController">
                        <div class="label-name">找回密码</div>
                        <div class="step-item show js_step js_one_step">
                            <form name="member_forget_form_tab">
                                <div class="login-input-wrap">
                                    <div class="input-box">
                                        <input required="required" readonly onfocus="this.removeAttribute('readonly');" ng-model="mobile" ng-minlength="11" ng-maxlength="11" type="text" class="login-input" placeholder="输入手机号" />
                                    </div>
                                    <div class="input-box imgcode-input-box">
                                        <input required="required" readonly onfocus="this.removeAttribute('readonly');" ng-model="imgCode" type="text" class="login-input" placeholder="图片验证码" />
                                        <img src="/manage/user/validate" class="img-code" alt="图片验证码" title="点击刷新验证码" onclick="javascript:this.src='/manage/user/validate?d='+Math.random();">
                                    </div>
                                    <div class="input-box telcode-input-box">
                                        <input required="required" readonly onfocus="this.removeAttribute('readonly');" ng-model="code" type="text" ng-keydown="keyEvent()" class="login-input" placeholder="手机验证码" />
                                        <input class="get-code code" type="button" ng-click="fetchCode()" value="获取验证码">
                                    </div>
                                    <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                                </div>
                            </form>
                            <button ng-disabled="!member_forget_form_tab.$valid" class="login-btn" onclick="finpassStep('two')">下一步</button>
                            <div class="login-fjopera">
                                <div class="remember-pass">
                                </div>
                                <div class="pass-open">
                                    <span class="pass-open-link" onclick="toggleOperainput('login')">去登录</span>
                                </div>
                            </div>
                        </div>
                        <div class="step-item js_step js_two_step" style="margin-top: 14px;">
                            <form name="member_forget_form">
                                <div class="login-input-wrap">
                                    <div class="input-box">
                                        <input required="required" ng-model="password" ng-minlength="6" ng-maxlength="50" type="password" class="login-input" placeholder="设置新密码" />
                                    </div>
                                    <div class="input-box">
                                        <input required="required" ng-model="repwd" ng-minlength="6" ng-maxlength="50" type="password" class="login-input" placeholder="确认新密码" />
                                    </div>
                                    <div class="error-tip" ng-show="tip" ng-bind="tip"></div>
                                </div>
                            </form>
                            <button ng-disabled="!member_forget_form.$valid" ng-click="forgetAction()" type="submit" class="login-btn">确认修改</button>
                            <div class="login-fjopera">
                                <div class="remember-pass">
                                    <span class="pass-open-link" onclick="finpassStep('one')">上一步</span>
                                </div>
                                <div class="pass-open">
                                    <span class="pass-open-link" onclick="toggleOperainput('login')">去登录</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 申请开通 -->
                    <div class="login-part-box js_login js_register reg-type" ng-controller="MemberRegisterController">
                        <div class="label-name">企业级·SaaS软件服务商</div>
                        <div class="reg-type-item" data-type="2">
                            <div class="reg-type-name">
                                <img src="http://www.tiandiantong.com/public/manage/images/icon_xcx.png" alt="小程序图标">
                                <p>小程序</p>
                            </div>
                            <p>一键生成 无需开发<br>出色的用户体验 精准的推广传播</p>
                        </div>
                        <div class="register-tip">暂不支持自助注册，请联系客服注册</div>
                        <div class="login-fjopera register-fjopera">
                            <span class="pass-open-link" onclick="toggleOperainput('login')">已有账户，立即登录</span>
                        </div>
                    </div>
                </div>
                <div class="right-code-show">
                    <div class="help-contact">
                        <a target="_blank" href="http://www.fenxiaobao.xin/index/help" class="help-link"><img src="/public/wxapp/newlogin/images/icon_help.png" class="icon" alt="图标">帮助中心</a>
                        <a class="attention-code help-link" href="javascript:;" style="border-bottom: 0;"><img src="/public/wxapp/newlogin/images/icon_scan.png" class="icon" alt="图标">关注官方微信，了解更多资讯
                            <div class="code-wrap">
                                <img src="/public/manage/img/code.jpg" alt="二维码">
                                <p>关注官方微信<br>了解更多资讯</p>
                            </div>
                        </a>
                        <div class="code-box">
                            <img src="/public/site/images/tiandiantong_sjb_qrcode.png" alt="二维码">
                            <p>下载天店通商家版APP<br>在手机上也可以打理店铺</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="copy-rights">2019 © 郑州天点科技有限公司 · All Rights Reserved <?php echo $_smarty_tpl->getConfigVariable('domain_icp');?>
</div>
</div>
<!--[if !IE]> -->

<!-- <![endif]-->

<!--[if IE]>
<script src="/public/manage/assets/js/jquery-1.10.2.min.js"></script>
<![endif]-->

<!--[if !IE]> -->

<script type="text/javascript">
    window.jQuery || document.write("<script src='/public/manage/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/public/manage/assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

<script type="text/javascript">
    if("ontouchend" in document) document.write("<script src='/public/manage/assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>

<!-- inline scripts related to this page -->
<script src="/public/plugin/citySelect/jquery.cityselect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/newlogin.js"></script>
<script src="/public/manage/vendor/angular.min.js"></script>
<script src="/public/manage/vendor/angular-root.js"></script>
<script src="/public/manage/controllers/manage-login.js"></script>
<script src="https://res.wx.qq.com/connect/zh_CN/htmledition/js/wxLogin.js"></script>
<script>
    var fields = document.querySelectorAll('input');
    for (var i = 0; i < fields.length; i++) {
        fields[i].autocomplete="on";
    }
</script>
<script src="/public/plugin/3dCanvas/three.min.js"></script>
<script src="/public/plugin/3dCanvas/cus-bottom-three.js?1"></script>
</body>
</html>

<?php }} ?>
