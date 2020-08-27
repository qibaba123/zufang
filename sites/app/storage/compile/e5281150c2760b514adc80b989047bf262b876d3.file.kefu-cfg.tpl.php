<?php /* Smarty version Smarty-3.1.17, created on 2020-05-18 10:40:48
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/kefu-cfg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5635089925e903d908fb751-92812600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e5281150c2760b514adc80b989047bf262b876d3' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/kefu-cfg.tpl',
      1 => 1589529858,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5635089925e903d908fb751-92812600',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e903d909441e2_93976360',
  'variables' => 
  array (
    'row' => 0,
    'auth_state' => 0,
    'sequenceShowAll' => 0,
    'show' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e903d909441e2_93976360')) {function content_5e903d909441e2_93976360($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/share/css/index.css">
<link rel="stylesheet" href="/public/wxapp/share/css/style.css">
<style>
/*页面样式*/
.flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
.flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
.authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
.authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
.authorize-tip .shop-logo { width: 50px; height: 50px; margin-right: 10px; overflow: hidden; }
.authorize-tip .shop-logo img { height: 100%; width: 100%; }
.authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
.authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
.authorize-tip .state.green { color: #48C23D; }
.authorize-tip .btn { margin-left: 10px; }
.fujia-info { background-color: #fff; box-shadow: 1px 1px 5px #dfdfdf; border-radius: 3px; margin-top: 20px; min-height: 150px; overflow: hidden; padding: 0 10px; box-sizing: border-box; position: relative; }
.fujia-info .fujia-title { font-size: 16px; font-weight: bold; padding: 10px 15px; position: absolute; left: 0; top: 0; }
.fujia-info .left-part { padding: 50px 30px; float: left; width: 180px; box-sizing: border-box; }
.fujia-info .left-part .img-logo { height: 55px; width: 55px; display: block; margin: 0 auto; border-radius: 50% }
.fujia-info .left-part .name { text-align: center; line-height: 2; margin-bottom: 10px; font-size: 16px; }
.fujia-info .left-part .btn { width: 100px; margin: 0 auto; display: block; }
.fujia-info .right-part { margin-left: 180px; padding: 40px 10px; line-height: 1.6; }
.fujia-info .right-part .intro-title { font-size: 14px; line-height: 28px; }
.fujia-info .right-part .intro-txt { margin-bottom: 6px; }
.fujia-info .right-part .intro-txt li { padding-left: 16px; color: #bbb; font-size: 13px; line-height: 28px; position: relative; }
.fujia-info .right-part .intro-txt li:before { content: ''; height: 6px; width: 6px; border-radius: 50%; position: absolute; left: 0; top: 10px; background-color: #ddd; }
.fujia-info .right-part .intro-txt li a { color: #38f; margin-left: 8px; }
.fujia-info .right-part .intro-txt li a:hover { color: blue; }
.code-down { position: absolute; top: 0; right: 0; }
.code-down p { font-size: 14px; color: #999; margin: 0; line-height: 1.8; text-align: center; position: relative; top: 10px; }
.code-down img { display: block; width: 200px; margin: 0 auto; }

input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
</style>
<div class="authorize-tip flex-wrap">
    <div class="shop-logo">
        <img src="/public/wxapp/setup/images/weixin_kefu.png" alt="logo">
    </div>
    <div class="flex-con">
        <h4>小程序客服</h4>
        <p class="state" style="color: #999;">
            <span>开启小程序客服后,首页右侧位置将有客服标志,用户可通过点击客服按钮和您聊天!&nbsp;&nbsp;&nbsp;<!--<a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=284&page=1&extra=#pid9918" target="_blank" style="color: blue">查看教程</a>--></span>
        </p>
    </div>
    <div>
        <?php if ($_smarty_tpl->tpl_vars['row']->value['ac_kefu_open']) {?>
            <a href="javascript:void(0)" onclick="openShare(this,event)" data-open="0" class="btn btn-sm btn-danger">关闭客服</a>
        <?php } else { ?>
            <a href="javascript:void(0)" onclick="openShare(this,event)" data-open="1" class="btn btn-sm btn-green">开启客服</a>
        <?php }?>
    </div>
</div>
<!--<div class="fujia-info">
    <div class="fujia-title">接入方式一：</div>
    <div class="left-part">
        <img src="/public/wxapp/setup/images/qspt.png" class="img-logo" alt="logo">
        <div class="name">企商平台</div>
        <a href="http://url.cn/533d6Du" target="_blank" class="btn btn-sm btn-green">下载使用</a>
    </div>
    <div class="right-part" style="margin-right: 180px;">
        <div class="intro-title">客服消息管理权限</div>
        <div class="intro-txt">
            <ul>
                <?php if ($_smarty_tpl->tpl_vars['auth_state']->value) {?>
                <li>客服消息管理权限: <span style="color: green;">已授权</span></li>
                <!--
                <li style="margin-top: 5px">
                    <span style="">
                        <span class="switch-title">启用手机认证：</span>
                        <label id="choose-onoff" class="choose-onoff">
                            <input class="ace ace-switch ace-switch-5" id="kefuMobile"  data-type="open" onchange="kefuMobileOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['ac_kefu_mobile']==1) {?>checked<?php }?>>
                            <span class="lbl"></span>
                        </label>
                        <span style="color: red">此功能启用时，用户必须绑定手机号后才能使用客服功能</span>
                    </span>
                </li>
                -->
                <?php } else { ?>
                <li>客服消息管理权限: <span style="color: red;">未授权</span></li>
                <li>点击<a href="/wxapp/setup/index" class="btn btn-sm btn-info">重新授权</a></li>
                <?php }?>
            </ul>
        </div>
    </div>
    <div class="code-down">
        <p>扫码下载APP</p>
        <img src="/public/wxapp/setup/images/QRCode.png" alt="二维码">
    </div>
</div>-->
<?php if ($_smarty_tpl->tpl_vars['sequenceShowAll']->value==1) {?>
<div class="fujia-info">
    <div class="fujia-title">接入方式一：</div>
    <div class="left-part">
        <img src="/public/wxapp/setup/images/meiqian.jpg" class="img-logo" alt="logo">
        <div class="name">美洽客服</div>
        <a href="https://meiqia.com/" target="_blank" class="btn btn-sm btn-green">立即使用</a>
    </div>
    <div class="right-part">
        <div class="intro-title">接入美洽</div>
        <div class="intro-txt">
            <ul>
                <li>第一步：获取小程序基本信息。首先你需要获取小程序的「小程序名称」、「原始ID」、「AppID」和「AppSecret」。这些信息可以在小程序后台「设置」-「基本设置」和「开发设置」中查看，如果这些信息你已经知道，请忽略这一步。</li>
                <li>第二步：在美洽中生成配置信息。获取小程序基本信息后你可以在美洽「设置」-「微信小程序」中添加一个小程序，我们会根据你提交的小程序基本信息生成专属的配置信息。</li>
                <li>第三步：小程序中配置并启用消息推送服务。将美洽中生成的配置信息在小程序后台「消息推送」服务中进行配置并启用「消息推送」服务，其中「消息加密方式」应选择「安全模式」，「数据格式」应选择「JSON」。</li>
                <li>完成以上 3 步，你的小程序中已成功接入了美洽，后续所有小程序客服消息均可通过美洽来进行收发。<a target="_blank" href="https://mp.weixin.qq.com/s/1BMcNOtcpylgGWjdjCctQQ">查看详情</a></li>
            </ul>
        </div>
        <div class="intro-title">关于权限和数据统计</div>
        <div class="intro-txt">
            <ul>
                <li>小程序属于微信公众号的一种，美洽产品中拥有「接入设置-允许查看 「微信」 设置」操作权限的用户即可进行小程序的相关修改操作。</li>
                <li>美洽产品中小程序用户产生的对话和留言将会以微信渠道数据进行展示和统计。<a target="_blank" href="https://mp.weixin.qq.com/s/1BMcNOtcpylgGWjdjCctQQ">查看详情</a></li>
            </ul>
        </div>
    </div>
</div>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['show']->value==1) {?>
    <div class="fujia-info">
        <div class="fujia-title">接入方式三：</div>
        <div class="left-part">
            <div class="name">客服回复设置</div>
        </div>
        <div class="right-part">
            <div class="info-group-inner">
                <div class="group-info">
                    <div class="form-group">
                        <label for="name" class="control-label"><font color="red">*</font>关键字：</label>
                        <div class="control-group">
                            <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写关键字" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_name'];?>
<?php }?>">
                        </div>
                    </div>
                    <div class="form-group" style="padding: 0 0 0 94px;">
                        <h3 class="lighter block green">图片(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</h3>
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover" id="upload-g_cover"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>"  width="150" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php }?>"/>
                            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover">修改</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-group">
                            <button class="btn btn-primary btn-save-kfhf">
                                保存
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }?>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

    $(function(){
        //客服回复保存
        $('.btn-save-kfhf').on('click',function(){
            var keyword = $('input[name="g_name"]').val();
            var cover   = $('input[name="g_cover"]').val();
            if(!keyword || !cover){
                layer.msg('请填写完整的回复信息',{ time:2000 });
                return false;
            }
            var index = layer.load(1);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/kfhfSave',
                'data'  : { keyword:keyword,cover:cover },
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    console.log(ret.em);
                }
            });
        });
    });

    function openShare(obj, event) {
        var open = $(obj).data('open');
        var msg = open ? '开启客服' : '关闭客服?';
        layer.msg(msg, {
            time: 0,
            btn: ['确定', '取消'],
            yes: function(index) {
                layer.close(index);
                var loading = layer.load(2, {
                    time: 10 * 1000
                });
                $.ajax({
                    type: 'post',
                    url: '/wxapp/currency/openKefu',
                    data: 'open=' + open,
                    dataType: 'json',
                    success: function(ret) {
                        layer.close(loading);
                        location.reload();
                    }
                });
            }
        });
    }

    function kefuMobileOpen() {
        var open   = $('#kefuMobile:checked').val();
        console.log(open);
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/kefuMobileOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }
</script><?php }} ?>
