<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>天店通小程序自动部署平台</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/public/install/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body, p, input, h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form, div { margin: 0; padding: 0; list-style: none; vertical-align: middle; font-weight: normal; }
        img { border: 0; margin: 0; padding: 0; display: block; }
        body { color: #000; -webkit-user-select: none; -webkit-text-size-adjust: none; font: normal 14px/200% Muli, Helvetica Neue, Hiragino Sans GB, WenQuanYi Micro Hei, Microsoft Yahei, sans-serif !important; text-align: left; }
        a { text-decoration: none; color: #333; }
        .clearfix:after { display: block; visibility: hidden; height: 0; content: ""; clear: both; }
        .clearfix { zoom: 1; }
        *{box-sizing: border-box;}
        html, body { width: 100%; height: 100%; }
        body { width: 100%; margin: 0 auto; background-color: #fff; min-width: 1200px; background: url(/public/install/images/bg.png) no-repeat center; background-size: cover; }
        input:-internal-autofill-previewed, input:-internal-autofill-selected, textarea:-internal-autofill-previewed, textarea:-internal-autofill-selected, select:-internal-autofill-previewed, select:-internal-autofill-selected { background-color: #fff !important;    box-shadow: inset 0 0 0 1000px #fff;
        -moz-box-shadow: inset 0 0 0 1000px #fff;-webkit-box-shadow: inset 0 0 0 1000px #fff; }
        input::-webkit-outer-spin-button, input::-webkit-inner-spin-button { -webkit-appearance: none; }
        input[type="number"] { -moz-appearance: textfield; }
        button{outline: none;}
        .header-shadow{height: 46px;position: absolute;width: 100%;background: #333;opacity: 0.1;}
        .browser-tip{background-color: rgba(0,0,0,.3);width: 100%;position: relative;display: none;}
        .browser-tip .close-btn{position: absolute;top:0;right: 0;width: 50px;height: 50px;padding: 20px;}
        .browser-tip .close-btn img{display: block;width: 100%;height: 100%;}
        .browser-tip-con{width: 80%;min-width: 1100px; max-width: 1300px;margin: 0 auto;padding: 0;display: block;overflow: hidden;}
        .browser-tip-con .left-img{height: 50px;float: left;}
        .browser-tip-con .left-img img{display: block;height: 100%;}
        .browser-tip-con .down-btn{float:right;margin-top:10px;height: 30px;line-height: 30px;text-align: center;color: #fff;font-size: 13px;border:1px solid #fff;border-radius: 3px;padding:0 10px;}

        .canvas-three-box{position: absolute;width: 100%;left: 0;bottom: 0;height: 70%;overflow: hidden;opacity: 0.95;}

        .login-part-wrap{width: 100%; height: 100%;  position: relative;z-index: 3; }
        .main-width { min-width: 1100px; max-width: 1300px;width: 80%; margin: 0 auto;  }
        .top-opera-box { font-size: 0; text-align: right; padding: 9px 0; }
        .top-opera-box .link { margin-left: 10px; padding: 10px 6px; font-size: 13px; color: #fff; }
        .top-opera-box .icon { display: inline-block;margin-right: 5px;width: 20px;height: 20px;position: relative;top: -2px; }
        .top-opera-box .header-title { float: left;padding-left: 50px;font-size: 14px; line-height: 11px;}
        .login-part { width: 100%; position: absolute; left: 0; top: 45%; transform: translateY(-50%); }
        .login-part .left-intro { float: left; margin-top: 50px; }
        .login-part .left-intro .logo { display: block; width: 205px; margin-bottom: 15px; }
        .login-part .intro-list { list-style: none; margin-left: 20px; }
        .login-part .intro-list li { list-style: disc; font-size: 15px; padding: 4px 0; line-height: 26px; color: #f4f4f5; white-space: nowrap; }
        .login-part .left-intro .applet-icon { display: block; width: 240px; margin-top: 15px; }
        .login-part .right-login { background-color: #fff;font-size: 0;width: 400px;margin: auto; }
        .login-part .right-login .left-login-con { font-size: 14px; width: 400px; display: inline-block; vertical-align: middle; padding: 15px 20px; box-sizing: border-box; position: relative; }
        .right-login .left-login-con .login-type-toggle { position: absolute; right: 20px; top: 20px; }
        .right-login .login-type-toggle .login-type-toggle-item { display: none; }
        .right-login .login-type-toggle .login-type-toggle-item.show { display: block; }
        .right-login .login-type-toggle .login-tip { display: inline-block; vertical-align: middle; background: url(../images/img_msg.png) no-repeat center; background-size: 100% 100%; width: 79px; height: 31px; text-align: center; line-height: 31px; color: #2993ff; font-size: 13px; padding-right: 5px; box-sizing: border-box; }
        .right-login .login-type-toggle .login-tip-icon { display: inline-block; vertical-align: middle; width: 44px; height: 44px; cursor: pointer; }
        .right-login .left-login-con .login-part-box { display: none; }
        .right-login .left-login-con .login-part-box.show { display: block; }
        .right-login .left-login-con .label-name { font-size: 20px; line-height: 2;text-align: center;}
        .right-login .left-login-con .label-name.center{text-align: center;}
        .right-login .login-input-wrap { margin-top: 20px;position: relative; }
        .right-login .login-input-wrap .input-box { margin-bottom: 10px;position: relative; }
        .right-login .imgcode-input-box .img-code{position: absolute;right: 0;top:8px;width: 90px;height: 32px;background-color: #f0f0f0;}
        .right-login .telcode-input-box .get-code{position: absolute;right: 0;top:8px;width: 90px;height: 35px;line-height: 32px;color: #2993ff;margin:0;padding:0;-webkit-appearance: none;border:none;outline: none;background-color: rgba(0,0,0,0);}
        .right-login .telcode-input-box .get-code.gray{color: #ccc;}
        .right-login .login-input-wrap .login-input {padding: 10px;height: 40px;width: 100%;outline: none;background-color: #fff !important;font-size: 14px;box-sizing: border-box;border: 1px solid #e6e6e6; border-radius: 2px;}
        .right-login .login-input-wrap .login-input:-internal-autofill-selected { background-color: #fff !important; }
        .right-login .login-btn { display: block;width: 100%;border-radius: 2px;height: 40px;line-height: 40px;border: none;background-color: #0094fa;text-align: center;color: #fff;font-size: 16px;margin-top: 25px;margin-bottom: 25px;}
        .right-login .login-btn:hover { opacity: 0.9; text-decoration: none; }
        .right-login .login-btn[disabled] { opacity: 0.6; }
        .right-login .login-fjopera { overflow: hidden; margin-top: 10px; }
        .right-login .remember-pass { float: left; }
        .right-login .remember-pass input[type='checkbox'] { display: none; }
        .right-login .remember-pass input[type='checkbox']+label { color: #999; margin: 0; background: url(../images/icon_unselect.png) no-repeat left center; background-size: 15px; padding-left: 20px; line-height: 30px; cursor: pointer; }
        .right-login .remember-pass input[type='checkbox']:checked+label { background-image: url(../images/icon_select.png); }
        .right-login .pass-open { float: right; text-align: right; line-height: 30px; color: #999; }
        .right-login .pass-open-link { margin-left: 5px; padding: 0 4px; cursor: pointer; }
        .right-login .pass-open-link:hover { color: #2993ff; text-decoration: none; }
        .right-login .code-login-img { width: 200px; height: 200px; margin: 0 auto; margin-top: 18px; }
        .right-login .code-login-img img { display: block; width: 100%; height: 100%; }
        .right-login .code-login-tip { font-size: 14px; color: #999; text-align: center; margin-top: 4px; }
        .code-img iframe {width: 282px;height: 307px;}
        .error-tip {min-height: 16px;font-size: 13px;line-height: 16px;color: red;margin: 0;margin-top: 8px;}
        .right-login .login-input-wrap .error-tip {position:absolute;left:0;bottom:-24px;min-height: 16px;font-size: 13px;line-height: 16px;color: red;width:100%;}


        /*右侧帮助模块*/
        .login-part .right-login .right-code-show {display: inline-block;vertical-align: middle;height: 420px;background-color: #f6f6f6; }
        .right-code-show .help-contact { width: 300px; padding: 15px 20px; }
        .right-code-show .help-contact .help-link { position: relative; color: #666; text-align: left; padding: 10px 0; line-height: 20px; padding-left: 25px; display: block; border-bottom: 1px solid #eee; font-size: 14px; text-decoration: none; }
        .right-code-show .help-contact .help-link:hover { color: #333; }
        .right-code-show .help-contact .icon { width: 20px; position: absolute; left: 0; top: 11px; }
        .right-code-show .help-contact .attention-code { position: relative; }
        .right-code-show .help-contact .attention-code .code-wrap { background-color: #fff; border: 1px solid #eee; border-radius: 5px; color: #666; display: none; font-size: 13px; left: 210px; opacity: 0; padding: 12px; position: absolute; top: 0; transition: all 0.3s ease 0s; z-index: 2; }
        .right-code-show .help-contact .code-wrap img { width: 105px; height: 105px; display: block; margin: 0 auto;margin-bottom: 8px; }
        .right-code-show .help-contact .code-wrap p { margin: 0; line-height: 1.3; text-align: center;font-size: 12px; }
        .right-code-show .help-contact .attention-code:hover .code-wrap { display: block; opacity: 1; }
        .right-code-show .help-contact .code-box { margin: 5px 0 10px; }
        .right-code-show .help-contact .code-box img { width: 80%; display: block; margin: 0 auto; margin-bottom: 10px; }
        .right-code-show .help-contact .code-box p { margin: 0; line-height: 1.5; color: #666; font-size: 13px; text-align: center; margin-top: 5px; }
        .login-part-wrap .copy-rights { position: absolute; width: 100%; bottom: 10px; left: 0; text-align: center; font-size: 13px; color: #fff; }
        .progress-title{ font-size: 18px; line-height: 2}
    </style>
</head>
<body>
<div class="login-part-wrap">
    <div class="header-shadow"></div>
    <div class="header-nav">
      <section class="top-opera-box main-width">
          <span class='link header-title'>欢迎来到天店通小程序自动部署系统</span>
          <span class='link'><img src="/public/install/images/icon_w1.png" class="icon" alt="图标">资质认证</span>
          <span class='link'><img src="/public/install/images/icon_w2.png" class="icon" alt="图标">支付安全</span>
          <span class='link'><img src="/public/install/images/icon_w3.png" class="icon" alt="图标">专人服务</span>
          <span class='link'><img src="/public/install/images/icon_w4.png" class="icon" alt="图标">售后无忧</span>
      </section>
    </div>  
    <section class="login-part">
        <div class="main-width">
            <div class="right-login">
                <div class="left-login-con">
                    <!-- 密码登录 -->
                    <div class="login-part-box js_login js_pass_login show">
                        <div name="member_login_form" >
                            <div class="label-name">店铺信息设置</div>
                            <div class="login-input-wrap">
                                <div class="input-box">
                                    <input required="required" id="company" type="text" class="login-input" placeholder="店铺名称" />
                                </div>
                                <div class="input-box">
                                    <input required="required" id="mobile" type="text" class="login-input" placeholder="登录手机号" />
                                </div>
                                <div class="input-box">
                                    <input required="required" id="password" type="text" class="login-input" placeholder="登录密码" />
                                </div>
                                <div class="input-box">
                                    <input required="required" id="appid" type="text" class="login-input" placeholder="小程序APPID" />
                                </div>
                                <div class="input-box">
                                    <input required="required" id="appsecret" type="text" class="login-input" placeholder="小程序APPSECRET" />
                                </div>
                            </div>
                            <button class="login-btn setting-btn">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="copy-rights">2019 © 郑州天点科技有限公司 · All Rights Reserved</div>
</div>

<script type="text/javascript" src="/public/install/js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="/public/install/js/layer.js"></script>
<script>
       $(".setting-btn").click(function(){
          var appletType = '<{$appletType}>';
          var company    = $('#company').val();
          var mobile     = $('#mobile').val();
          var password   = $('#password').val();
          var appid      = $('#appid').val();
          var appsecret  = $('#appsecret').val();
          if(appletType && company && mobile && password && appid && appsecret){
          	$.ajax({
                'type'  : 'post',
                'data'  : {appletType, company, mobile, password, appid, appsecret},
                'url'   : '/install/saveSetting',
                'dataType' : 'json',
                success : function(data){
                    if(data.ec == 200){
                        window.location.replace(window.location.protocol+"//"+window.location.host);
                    }else{
                      alert(data.em);
                    }
                }
            });
          }else{
         	layer.msg("请完善店铺信息"); 
          }
         
       })
</script>
</body>
</html>

