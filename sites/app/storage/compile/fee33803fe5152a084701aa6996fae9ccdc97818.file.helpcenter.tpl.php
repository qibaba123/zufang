<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:34:23
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/layer/helpcenter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16960063405e1be53fb4bf49-26225581%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fee33803fe5152a084701aa6996fae9ccdc97818' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/manage/layer/helpcenter.tpl',
      1 => 1548645837,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16960063405e1be53fb4bf49-26225581',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'help_list' => 0,
    'item' => 0,
    'help' => 0,
    'support' => 0,
    'caselist' => 0,
    'appletCfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be53fb6d5d2_23781337',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be53fb6d5d2_23781337')) {function content_5e1be53fb6d5d2_23781337($_smarty_tpl) {?><style>
.anli-show { overflow: hidden; position: relative; padding: 0 5px; padding-top: 10px; }
.anli-show .anli-item { width: 100%; float: left; margin-bottom: 5px; position: relative; }
.anli-show .anli-item img { display: block; margin: 0 auto; border-radius: 4px; width: 122px; height: 122px; }
.anli-show .anli-item p { line-height: 26px; text-align: center; font-size: 12px; color: #666; padding: 0; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; margin-bottom: 8px; }
.anli-show .erweima { position: absolute; left: 0; width: 100%; background-color: #f9f9f9; display: none; bottom: 20px; top: -5px; height: 131px; }
.anli-show .erweima img { width: 100%; height: 131px; }
.service-one { font-family: "黑体"; border-bottom: 1px solid #EAEAEA; padding-bottom: 10px; margin-bottom: 5px; }
.service-one .title { padding: 10px 0; }
.service-one .title h4 { border-left: 3px solid #3283FA; line-height: 1.1; font-family: "黑体"; font-size: 13px; margin: 0; padding-left: 3px; }
.service-one .code-info img { width: 80%; height: auto; display: block; margin: 0 auto; }
.service-one .code-info div { padding: 7px 0; }
.service-one .code-info p { line-height: 1.1; font-size: 12px; margin: 8px 0; }
.service-one .code-info p.tel { margin: 5px 0; text-align: center; }
.service-one .code-info p.num { margin: 5px 0; text-align: left; }
.app-manage-shop { margin-top: 10px; }
.app-manage-shop img, .anli-show img { width: 100%; display: block; margin: 0 auto; }
.app-manage-shop p { margin: 0; line-height: 1.4; font-size: 12px; color: #666; text-align: center; margin-top: 5px; }
.help-container-body{overflow: auto!important; }
.help-container-body::-webkit-scrollbar { display: none; }
.anli-item a { display: block; }
.browser-recommend .down-tip{display: block;text-align: center;font-size: 13px;color: blue;}
.browser-recommend .down-tip img{display: block;width: 100%;border-radius: 4px;}
/*问题建议相关*/
.help-center-box, .help-container-body { overflow: visible!important; }
.question-suggest .question-suggest{margin-top: 20px;}
.question-suggest .question-item { margin-top: 10px; padding: 5px 0; border-radius: 2px; padding-left: 40px; background: url() no-repeat 8px center; background-size: 24px; background-color: #fff; box-shadow: 1px 1px 5px #ddd;position: relative; }
.question-suggest .question-item.icon_question { background-image: url(/public/wxapp/images/jiaoliuxuexi.png); }
.question-suggest .question-title { font-size: 14px; line-height: 1.4; }
.question-suggest .question-brief { font-size: 12px; color: #999; margin: 0; line-height: 1.4; }
.question-suggest .question-item .code { position: absolute; right: 105%; top: 0; width: 180px; z-index: 10; display: none; padding: 5px 15px; border-radius: 4px; background-color: #fff; border: 1px solid #ededed; }
.question-suggest .question-item .code:before,.question-suggest .question-item .code:after{content: '';position: absolute;right:-9px;top:18px;width: 0;height: 0;border-width: 5px;border-style: dashed dashed dashed solid;border-color: transparent transparent transparent #fff;z-index: 2;}
.question-suggest .question-item .code:after{right: -11px;border-color: transparent transparent transparent #ededed;z-index: 1;}
.question-suggest .question-item:hover .code{display: block;}
.question-suggest .question-item .code img{width: 100%;height: 100%;}
.help-center-box{transition: all 0.3s;transform: translateX(0);}
.help-center-box.yincang{transform: translateX(160px);}
.unfold-btn{position:fixed;right:160px;top:50%;height: 116px;width: 40px;margin-top:-58px;z-index: 5;cursor: pointer;background: url(/public/wxapp/images/hide-btn.png) no-repeat left center;background-size:
37px 116px;transition: all 0.3s;}
.unfold-btn span{position: absolute;top:0;right: 0;width: 6px;background-color: #f9f9f9;height: 100%;}
.unfold-btn.yincang{right:-10px!important;}
.unfold-btn img{display: block;height: 18px;width: 18px;margin-top: 49px;margin-left:12px;transition: all
0.3s;transform: rotate(180deg);}
.unfold-btn.yincang img{transform: rotate(0deg);}
.main-content{padding-right: 0;}
</style>
<div class="unfold-btn js_unfold yincang"><span></span><img src="/public/wxapp/images/icon_open.png" alt="隐藏图标"></div>
<div class="help-center-box yincang">
    <div class="help-con">
        <div class="help-container-head">帮助和服务</div>
        <div class="help-container-body">
            <div class="help-body-title">
                帮助中心
                <a href="<?php echo $_smarty_tpl->getConfigVariable('help_center');?>
" target="_blank" class="enter">进入></a>
            </div>
            <div class="help-body-content" style="padding-bottom: 120px;">
                <div class="contact-kefu" style="padding:15px 0;border-top:1px solid #EAEAEA;border-bottom:1px solid #EAEAEA;margin-bottom:10px;">
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=2271654662&site=qq&menu=yes" style="display:inline-block;background:url(/public/manage/img/icon_kefu.png) no-repeat;background-position:5px center; background-size:25px;padding-left: 35px;color: #FF8D39;font-size: 16px;">
                        联系客服
                    </a>
                </div>
                <div class="browser-recommend">
                    <a href="http://chrome.360.cn/" target="_blank" class="down-tip">
                        <img src="/public/wxapp/images/360_download.png" alt="360下载">
                    </a>
                </div>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['help_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                <div class="help-content">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['ha_link'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['item']->value['ha_title'];?>
</a>
                    <p><?php echo $_smarty_tpl->tpl_vars['item']->value['ha_brief'];?>
</p>
                </div>
                <?php } ?>
                <div class="anli-show">
                    <p style="display:inline-block;background:url(/public/manage/img/icon_help0.png) no-repeat;background-position:4px 3px; background-size:18px;padding-left: 30px;color: #FF8D39;font-size: 16px;">使用教程</p>
                    <div class="anli-item" style="width: 100%">
                        <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=217&extra=" target="_blank">1、小程序注册（无公众号）</a>
                        <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=218&extra=" target="_blank">2、小程序注册（有公众号）</a>
                        <!--<a href="<?php echo $_smarty_tpl->tpl_vars['help']->value['ha_link'];?>
" target="_blank">3、<?php echo $_smarty_tpl->tpl_vars['help']->value['ha_title'];?>
</a>-->
                    </div>
                </div>
                
                <?php if ($_smarty_tpl->tpl_vars['support']->value) {?>
                <div class="service-one">
                    <div class="title">
                        <h4>联系客服经理提供一对一服务</h4>
                    </div>
                    <div class="code-info">
                        <div>
                            <img src="<?php echo $_smarty_tpl->tpl_vars['support']->value['cs_wx_qrcode'];?>
" alt="二维码">
                        </div>
                        <p class="tel"><?php echo $_smarty_tpl->tpl_vars['support']->value['cs_name'];?>
</p>
                        <p class="num">微信号：<?php echo $_smarty_tpl->tpl_vars['support']->value['cs_weixin'];?>
</p>
                        <p class="num">手机号：<?php echo $_smarty_tpl->tpl_vars['support']->value['cs_phone'];?>
</p>
                    </div>
                </div>
                <?php }?>
                <div class="question-suggest">
                    <div class="question-item icon_question">
                        <div class="question-title">小程序推广</div>
                        <div class="question-brief">帮您更好的推广</div>
                        <div class="code">
                            <img src="/public/wxapp/images/jiaoliu.png" alt="小程序二维码">
                        </div>
                    </div>
                </div>
                <div class="anli-show">
                    <p>客户案例</p>
                    <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['caselist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                        <div class="anli-item case">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['cc_logo'];?>
" alt="图标"  onmouseover="showCode(this)">
                            <p><?php echo $_smarty_tpl->tpl_vars['item']->value['cc_name'];?>
</p>
                            <div class="erweima" onmouseout="hideCode(this)"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['cc_qrcode'];?>
" alt="二维码"></div>
                        </div>
                    <?php } ?>
                </div>
                <!-- <div class="app-manage-shop">
                    <img src="/public/manage/img/tiandiantong1.jpg" alt="天店通APP二维码">
                </div> -->
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                <div style="padding:15px 0;margin-bottom:10px;">
                    <a target="_blank" href="/shop"  style="display:inline-block;background-position:5px center; background-size:25px;color: #399fff;font-size: 16px;">
                        入驻商家登录
                    </a>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<script src="/public/plugin/nicescroll/jquery.nicescroll.min.js"></script>
<script>
    $(function(){
        // $(".help-container-body").niceScroll({
        //     cursorborder:"0",
        //     cursorcolor:"#444",
        //     cursorwidth:"4",
        //     cursoropacitymax:"0",
        //     autohidemode:true
        // });
        // 隐藏显示右侧帮助中心
        var scrollbarWidth = $("#main-container")[0].offsetWidth-$("#main-container")[0].scrollWidth;
        if(scrollbarWidth>0){
            var rightX = scrollbarWidth+154;
            $(".js_unfold").css("right",rightX+"px");
        }else{
            $(".js_unfold").css("right","154px");
        }
        $(".js_unfold").click(function() {
            var $this = $(this);
            var paddR = $(".main-content").css("padding-right");
            if(paddR=="0px"){
                $(".main-content").css("padding-right","160px");
                $(".help-center-box").removeClass('yincang');
                $this.removeClass('yincang');
            }else{
                $(".main-content").css("padding-right","0");
                $(".help-center-box").addClass('yincang');
                $this.addClass('yincang');
            }
        })
    })
    /*显示二维码*/
    function showCode(elem){
        $(elem).parents('.anli-item').find('.erweima').stop().fadeIn();
    }
    /*隐藏二维码*/
    function hideCode(elem){
        $(elem).stop().fadeOut();
    }


</script><?php }} ?>
