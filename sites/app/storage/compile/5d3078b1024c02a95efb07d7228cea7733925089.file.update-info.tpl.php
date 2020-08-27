<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 09:10:53
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/update-info.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13577144735e4f2e1d90eae9-60810315%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d3078b1024c02a95efb07d7228cea7733925089' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/update-info.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13577144735e4f2e1d90eae9-60810315',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'infos' => 0,
    'manager' => 0,
    'showTime' => 0,
    'isTestAccount' => 0,
    'appletCfg' => 0,
    'verifyPasswd' => 0,
    'showNotice' => 0,
    'notice' => 0,
    'cropper' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f2e1d965aa7_82409585',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f2e1d965aa7_82409585')) {function content_5e4f2e1d965aa7_82409585($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
.table.table-avatar tbody>tr>td { line-height: 48px; }
body { min-width: 1200px; }
.main-container-inner, .page-content { background-color: #f8f8f8; }
.page-content { padding-top: 15px; }
.form-group input { width: 80%; }
.panel { width: 393px; margin-bottom: 15px; display: inline-block; vertical-align: top; margin-right: 10px; }
.panel form { padding-top: 20px; }
.pass-wrap { background-color: #fff; margin-bottom: 20px; box-shadow: 1px 1px 5px #ddd; }
.name-logo { overflow: hidden; padding: 15px 20px; border-bottom: 1px solid #e8e8e8; font-size: 16px; }
.name-logo .logo { height: 60px; width: 60px; border-radius: 50%; overflow: hidden; float: left; }
.name-logo .logo img { height: 100%; width: 100%; }
.name-logo .name-info { padding: 10px 0; margin-left: 75px; color: #333; font-size: 15px; }
.name-logo .name-info p { margin: 0; line-height: 20px; }
.name-logo .name-info p span { margin-left: 20px; cursor: pointer; color: #1766B1; font-size: 13px; }
.name-logo .name-info p span:hover { opacity: 0.9; }
.login-condition>div { padding: 20px; }
.login-condition .cur-login { border-right: 1px solid #e8e8e8; width: 400px; font-size: 14px; float: left; }
.login-condition .prev-login { margin-left: 400px; }
.login-condition p { margin: 0; padding-left: 10px; position: relative; margin-bottom: 8px; }
.login-condition p:before { content: ''; position: absolute; left: 0; height: 14px; width: 2px; top: 50%; margin-top: -7px; background-color: #1766B1; }
.login-condition .ip-address { font-size: 0; }
.login-condition .ip-address span { width: 160px; font-size: 14px; display: inline-block; }
.shop-logo{width: 90px;height: 90px;margin:0 auto;border-radius: 50%;overflow: hidden;margin-bottom: 18px;}
.shop-logo img{width: 100%;height: 100%;}

.business-time{
    width: 29% !important;
    display: inline-block !important;
    margin-left: 10px;
    margin-right: 10px;
    border-radius: 4px !important;
}
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../manage/article-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div>
    <div class="row">
        <div class="col-sm-12">
            <div class="pass-wrap">
                <div class="name-logo">
                    <div class="logo">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['infos']->value['logo'];?>
" onerror="this.src='/public/manage/img/zhanwei/zw_fxb_45_45.png'" alt="logo">
                    </div>
                    <div class="name-info">
                        <p><?php echo $_smarty_tpl->tpl_vars['infos']->value['name'];?>
</p>
                        <p><?php echo $_smarty_tpl->tpl_vars['infos']->value['mobile'];?>
<span><a href="javascript:;" id="logout-button">退出</a></span></p>
                    </div>
                </div>
                <!--
                <div class="login-condition">
                    <div class="cur-login">
                        <p>当前登录情况</p>
                        <div class="ip-address">
                            <span>IP：115.60.148.171</span>
                            <span>地区：中国河南郑州联通</span>
                        </div>
                    </div>
                    <div class="prev-login">
                        <p>上次登录情况</p>
                        <div class="ip-address">
                            <span>IP：115.60.146.233</span>
                            <span style="width:200px;">时间：2017-08-23 11:42:58</span>
                            <span>地区：中国河南郑州联通</span>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <div class="panel-box">
                <div class="panel panel-default" <?php if ($_smarty_tpl->tpl_vars['manager']->value['m_fid']>0) {?>style="display:none;"<?php }?>>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            修改logo和店铺名称
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" style="padding-top: 10px">
                            <div class="shop-logo">
                                <div class="cropper-box" data-width="200" data-height="200" >
                                    <img <?php if ($_smarty_tpl->tpl_vars['infos']->value['logo']) {?>src=<?php echo $_smarty_tpl->tpl_vars['infos']->value['logo'];?>
<?php } else { ?>src="/public/manage/img/zhanwei/zw_fxb_45_45.png"<?php }?> >
                                    <input type="hidden" id="shop-logo"  class="avatar-field bg-img" name="shop-logo" value="<?php if ($_smarty_tpl->tpl_vars['infos']->value['logo']) {?><?php echo $_smarty_tpl->tpl_vars['infos']->value['logo'];?>
<?php }?>"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="shop-name"> 店铺名称：</label>
                                <div class="col-sm-9">
                                    <input type="text" id="shop-name" class="form-control col-sm-8" value="<?php echo $_smarty_tpl->tpl_vars['infos']->value['name'];?>
">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="shop-name"> 联系人：</label>
                                <div class="col-sm-9">
                                    <input type="text" id="shop-contact" class="form-control col-sm-8" value="<?php echo $_smarty_tpl->tpl_vars['infos']->value['contact'];?>
">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="shop-phone"> 联系电话：</label>
                                <div class="col-sm-9">
                                    <input type="text" id="shop-phone" class="form-control col-sm-8" value="<?php echo $_smarty_tpl->tpl_vars['infos']->value['phone'];?>
">
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['showTime']->value&&$_smarty_tpl->tpl_vars['showTime']->value==1) {?>
                            <div class="form-group">
                                <div class="input-group">
                                    <label class="col-sm-3 control-label no-padding-right" for="shop-name"> 营业时间：</label>
                                    <input type="text" class="form-control business-time time" id="shop_start_time"  placeholder="营业开始时间" value="<?php echo $_smarty_tpl->tpl_vars['infos']->value['start_time'];?>
">
                                    至
                                    <input type="text" class="form-control business-time time" id="shop_end_time"  placeholder="营业结束时间" value="<?php echo $_smarty_tpl->tpl_vars['infos']->value['end_time'];?>
">
                                </div>
                            </div>
                            <?php }?>
                            <div class="black form-group" id="city_choose">
                                <label class="col-sm-3 control-label no-padding-right" for="qq-num"> 所属省市： </label>
                                <span class="block col-xs-3" style="width: 30%">
                                <select class="form-control prov"  style="height: 38px;padding: 6px 12px;">
                                </select>
                                </span>
                                <span class="block col-xs-3" style="width: 30%">
                                <select class="form-control city" style="height: 38px;padding: 6px 12px;margin-left: 8px" disabled="disabled">
                                </select>
                                </span>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary" id="update_shopinfo" type="button">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-default" <?php if ($_smarty_tpl->tpl_vars['isTestAccount']->value) {?>style="display:none;"<?php }?>>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            修改密码
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="yuan-pass"> 原始密码：</label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" id="yuan-pass" class="form-control col-sm-8">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="new-pass"> 新密码： </label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" class="form-control col-sm-8" id="new-pass" placeholder="由6-20位字母和数字组成">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="confirm-pass"> 确认密码： </label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" class="form-control col-sm-8" id="confirm-pass" onblur="confirmPassword()">
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary" id="update_password" type="button">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>

                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_appid']&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_appsecret']&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_auth_status']==0) {?>
                <div class="panel panel-default" >
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            修改小程序信息
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="shop-name"> APPID：</label>
                                <div class="col-sm-9">
                                    <input type="text" id="ac-appid" class="form-control col-sm-8" value="<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_appid'];?>
">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="shop-name"> APPSECRET：</label>
                                <div class="col-sm-9">
                                    <input type="text" id="ac-appsecret" class="form-control col-sm-8" value="<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_appsecret'];?>
">
                                </div>
                            </div>

                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary" id="update_applet" type="button">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['verifyPasswd']->value) {?>
                <div class="panel panel-default" <?php if ($_smarty_tpl->tpl_vars['manager']->value['m_fid']>0) {?>style="display:none;"<?php }?>>
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            修改核销密码
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="yuan-pass"> 原始密码：</label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" id="yuan-verify-pass" class="form-control col-sm-8">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="new-pass"> 新密码： </label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" class="form-control col-sm-8" id="new-verify-pass" placeholder="由6-20位字母和数字组成">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label no-padding-right" for="confirm-pass"> 确认密码： </label>
                                <div class="col-sm-9">
                                    <input type="password" autocomplete="off" class="form-control col-sm-8" id="confirm-verify-pass" onblur="confirmVerifyPassword()">
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary" id="update_verify_password" type="button">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['showNotice']->value==1) {?>
                <div class="panel panel-default" style="width: 550px;<?php if ($_smarty_tpl->tpl_vars['manager']->value['m_fid']>0) {?>display:none;<?php }?>" >
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            店铺公告
                        </h3>
                    </div>
                    <div class="panel-body">
                        <span style="font-size: 14px;color: red;">该店铺公告是在店铺首页启用通用版时显示，其他模板则不显示</span>
                        <form class="form-horizontal" role="form">
                            <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<?php if ($_smarty_tpl->tpl_vars['notice']->value&&$_smarty_tpl->tpl_vars['notice']->value['sn_id']) {?><?php echo $_smarty_tpl->tpl_vars['notice']->value['sn_id'];?>
<?php }?>"/>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="yuan-pass"> 通知标题：</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control col-sm-8" id="ss_title" value="<?php if ($_smarty_tpl->tpl_vars['notice']->value&&$_smarty_tpl->tpl_vars['notice']->value['sn_title']) {?><?php echo $_smarty_tpl->tpl_vars['notice']->value['sn_title'];?>
<?php }?>" placeholder="请输入通知标题">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label no-padding-right" for="new-pass"> 通知内容： </label>
                                <div class="col-sm-10">
                                    <div class="form-textarea">
                                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-detail" name="article-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><?php if ($_smarty_tpl->tpl_vars['notice']->value&&$_smarty_tpl->tpl_vars['notice']->value['sn_content']) {?><?php echo $_smarty_tpl->tpl_vars['notice']->value['sn_content'];?>
<?php }?></textarea>
                                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                        <input type="hidden" name="ke_textarea_name" value="article-detail" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group" style="text-align: center;">
                                <button class="btn btn-sm btn-primary btn-save-notice" type="button">确认修改</button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php }?>
            </div>
        </div>
    </div>
</div>
<?php echo $_smarty_tpl->tpl_vars['cropper']->value['modal'];?>

<script src="/public/plugin/citySelect/jquery.cityselect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>

    // 省市选择
    $("#city_choose").citySelect({prov:"<?php echo $_smarty_tpl->tpl_vars['infos']->value['province'];?>
",city:"<?php echo $_smarty_tpl->tpl_vars['infos']->value['city'];?>
"});

    function confirmPassword(){
        var new_pass = $('#new-pass').val();
        var confirm_pass = $('#confirm-pass').val();
        if(new_pass != confirm_pass){
            layer.msg('两次填写密码不一样');
            return false;
        }
    }

    function confirmVerifyPassword(){
        var new_pass = $('#new-verify-pass').val();
        var confirm_pass = $('#confirm-verify-pass').val();
        if(new_pass != confirm_pass){
            layer.msg('两次填写密码不一样');
            return false;
        }
    }
    
    $('#update_password').on('click',function () {
        var data = {
            'old_pass'  : $('#yuan-pass').val(),
            'confirm_pass'  : $('#confirm-pass').val(),
            'new_pass'  : $('#new-pass').val()
        };
        if (data.old_pass.length < 6 || data.old_pass.length > 50) {
            layer.msg('原密码格式不正确');
            return;
        }
        if (data.new_pass.length < 6 || data.new_pass.length > 50) {
            layer.msg('新密码格式不正确');
            return;
        }
        if (data.old_pass == data.new_pass) {
            layer.msg('和原密码一致，请重新输入新密码');
            return;
        }
        if(data.new_pass != data.confirm_pass){
            layer.msg('两次输入密码不一样');
            return false;
        }
        //提交数据库保存
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            type: 'post',
            url: "/wxapp/user/changePassword" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                $('.form-control').val('')
                window.location.reload();
            }
        });
    });

    $('#update_verify_password').on('click',function () {
        var data = {
            'old_pass'  : $('#yuan-verify-pass').val(),
            'confirm_pass'  : $('#confirm-verify-pass').val(),
            'new_pass'  : $('#new-verify-pass').val()
        };
        if (data.old_pass && (data.old_pass.length < 6 || data.old_pass.length > 50)) {
            layer.msg('原密码格式不正确');
            return;
        }
        if (data.new_pass.length < 6 || data.new_pass.length > 50) {
            layer.msg('新密码格式不正确');
            return;
        }
        if (data.old_pass == data.new_pass) {
            layer.msg('和原密码一致，请重新输入新密码');
            return;
        }
        if(data.new_pass != data.confirm_pass){
            layer.msg('两次输入密码不一样');
            return false;
        }
        //提交数据库保存
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            type: 'post',
            url: "/wxapp/user/changeVerifyPassword" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                $('.form-control').val('');
                window.location.reload();
            }
        });
    });

    $('#update_shopinfo').on('click',function () {
        var data = {
            'logo'   :  $('#shop-logo').val(),
            'name'   :  $('#shop-name').val(),
            'phone'  :  $('#shop-phone').val(),
            'prov'   :  $('.prov').val(),
            'city'   :  $('.city').val(),
            'contact' : $('#shop-contact').val(),
            'start_time'   : $('#shop_start_time').val(),
            'end_time'   : $('#shop_end_time').val(),
        };
        if (!data.logo) {
            layer.msg('请上传店铺logo');
            return;
        }
        if (!data.name) {
            layer.msg('请填写店铺名称');
            return;
        }
        if (!data.phone) {
            layer.msg('请填写联系电话');
            return;
        }
        //提交数据库保存
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            type: 'post',
            url: "/wxapp/user/saveShopInfo" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret['ec'] == 200){
                    window.location.reload();
                }

            }
        });
    })

    $('#update_applet').on('click',function () {
        var data = {
            'appid'   :  $('#ac-appid').val(),
            'appsecret'   :  $('#ac-appsecret').val(),
        };
        //提交数据库保存
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            type: 'post',
            url: "/wxapp/user/saveAppletCfg" ,
            data: data,
            dataType: 'json',
            success: function(json_ret){
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret['ec'] == 200){
                    window.location.reload();
                }

            }
        });
    })


    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    });

    $('#logout-button').on('click',function () {
        layer.confirm('您确定要退出登录？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            window.location.href="/manage/user/logout"
        }, function(){

        });
    });

    $('.btn-save-notice').on('click',function(){
        var content = $('#article-detail').val();
        var title = $('#ss_title').val();
        var id      = $('#hid_id').val();
        var data = {
            'id'      : id,
            'title'   : title,
            'content' : content
        };

        if(title && content){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/mall/saveShopNotice',
                'data'	: data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        }else{
            layer.msg('请填写完整数据');
        }
    });
</script>
<?php }} ?>
