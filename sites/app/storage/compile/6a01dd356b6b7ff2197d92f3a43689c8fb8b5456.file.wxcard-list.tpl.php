<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:44:31
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/wxcard-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19103329395dea14ef6c6372-80939933%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a01dd356b6b7ff2197d92f3a43689c8fb8b5456' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/currency/wxcard-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19103329395dea14ef6c6372-80939933',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'wechat' => 0,
    'auth_code' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea14ef72cda8_42443703',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea14ef72cda8_42443703')) {function content_5dea14ef72cda8_42443703($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    /*页面样式*/
    .flex-wrap { display: -webkit-flex; display: -ms-flexbox; display: -webkit-box; display: -ms-box; display: box; display: flex; -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
    .flex-con { -webkit-box-flex: 1; -ms-box-flex: 1; -webkit-flex: 1; -ms-flex: 1; box-flex: 1; flex: 1; }
    .authorize-tip { overflow: hidden; margin-top: 10px; margin-bottom: 20px; }
    .authorize-tip { background-color: #F4F5F9; padding: 15px 20px; }
    .authorize-tip .shop-logo{width: 50px;height: 50px;border-radius: 50%;margin-right: 10px;border-radius: 50%;overflow: hidden;}
    .authorize-tip .shop-logo img{height: 100%;width: 100%;}
    .authorize-tip h4 { font-size: 16px; margin: 0; margin-bottom: 6px; }
    .authorize-tip .state { margin: 0; font-size: 13px; color: #999; }
    .authorize-tip .state.green { color: #48C23D; }
    .authorize-tip .btn { margin-left: 10px; }
</style>
<div id="content-con">
    <div class="authorize-tip flex-wrap">
        <div class="shop-logo">
            <?php if ($_smarty_tpl->tpl_vars['wechat']->value) {?>
            <img src="<?php echo $_smarty_tpl->tpl_vars['wechat']->value['wc_avatar'];?>
" alt="logo">
            <?php } else { ?>
            <img src="/public/wxapp/setup/images/wechat_avatar.png" alt="logo">
            <?php }?>
        </div>
        <div class="flex-con">
            <h4>微信卡券功能</h4>
            <?php if ($_smarty_tpl->tpl_vars['wechat']->value) {?>
            <p class="state" style="color: #999;">
                <span>您已授权公众号:<?php echo $_smarty_tpl->tpl_vars['wechat']->value['wc_name'];?>
,原始ID:<?php echo $_smarty_tpl->tpl_vars['wechat']->value['wc_gh_id'];?>
,APPID:<?php echo $_smarty_tpl->tpl_vars['wechat']->value['wc_app_id'];?>
 </span>
                <span>如果需要了解微信卡券功能,请点击<a href="https://mp.weixin.qq.com/cgi-bin/readtemplate?t=cardticket/faq_tmpl&type=info&token=818598992&lang=zh_CN" target="_blank">了解微信卡券功能</a></span>
            </p>
            <?php } else { ?>
            <p class="state" style="color: orangered;">
                <span>您尚未授权具备卡券功能的公众号到平台 </span>
                <!--
                <span>如果需要用户付费预约,请使用<a href="/wxapp/appointment/template" target="_blank">付费预约功能</a></span>
                -->
            </p>
            <?php }?>
            <p style="margin-top: 3px;margin-bottom: 0">
                <a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=302&extra=" style="color: red;">微信卡券设置教程</a>
                <a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=305&extra=" style="color: red;margin-left: 20px">微信卡券使用教程</a>
            </p>
        </div>
        <div>
            <?php if ($_smarty_tpl->tpl_vars['wechat']->value) {?>
            <a href="javascript:void(0)" onclick="openAuthuri(this,event)" data-authdomain="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authdomain'];?>
" data-authtype="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authtype'];?>
" data-authuri="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authcode'];?>
" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 重新授权公众号</a>
            <a href="#" class="btn btn-sm btn-blue" id="sync_coupon"><i class="icon-plus bigger-80"></i> 同步获取微信卡券</a>
            <a href="/wxapp/currency/cardBackground" class="btn btn-sm btn-blue" id="sync_coupon">领取页面设置</a>
            <a href="#" class="btn btn-sm btn-blue" id="card_activity">开通立减金功能</a>
            <?php } else { ?>
            <a href="javascript:void(0)" onclick="openAuthuri(this,event)" data-authdomain="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authdomain'];?>
" data-authtype="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authtype'];?>
" data-authuri="<?php echo $_smarty_tpl->tpl_vars['auth_code']->value['authcode'];?>
" class="btn btn-sm btn-green"> 新增公众号授权</a>
            <?php }?>
        </div>
    </div>
    <div  id="mainContent" >
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>商户名称</th>
                            <th>卡券名称</th>
                            <th>卡券使用提醒</th>
                            <th>使用限制说明</th>
                            <th>卡券使用开始时间</th>
                            <th>卡券使用截止时间</th>
                            <th>卡券创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['wc_id'];?>
">
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wc_brand_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wc_title'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wc_notice'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['wc_description'];?>
</td>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['wc_data_info']['type']=='DATE_TYPE_FIX_TIME_RANGE') {?>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['wc_data_info']['begin_timestamp']);?>
</td>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['wc_data_info']['end_timestamp']);?>
</td>
                                <?php } else { ?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['wc_data_info']['fixed_begin_term']==0) {?>
                                    <td>领取后立即生效</td>
                                    <?php } else { ?>
                                    <td>领取后<?php echo $_smarty_tpl->tpl_vars['val']->value['wc_data_info']['fixed_begin_term'];?>
天生效</td>
                                    <?php }?>
                                    <td>有效期：领取后<?php echo $_smarty_tpl->tpl_vars['val']->value['wc_data_info']['fixed_term'];?>
天</td>
                                <?php }?>
                                <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['wc_add_time']);?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['wc_is_swipe_card']==1&&$_smarty_tpl->tpl_vars['val']->value['wc_card_type']=='CASH') {?>
                                    <a href="/wxapp/currency/activity/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['wc_id'];?>
" >立减金活动</a>-
                                    <?php }?>
                                    <a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['wc_id'];?>
" class="delete-btn">删除</a>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php if ($_smarty_tpl->tpl_vars['paginator']->value) {?>
                            <tr><td colspan="8"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    预约处理
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="8" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('.confirm-handle').on('click',function () {
        $('#hid_id').val($(this).data('id'));
    });

    $('.delete-btn').on('click',function () {
        var loading = layer.load(2);
        var id = $(this).data('id');
        var data = {
            id : id
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/delCoupon',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var market = $('#market').val();
        var data = {
            id : hid,
            market : market
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/currency/handleAppointment',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

    $('#sync_coupon').on('click',function () {
        console.log(2222222);
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/syncCoupon',
            'data'  : { },
            'dataType' : 'json',
            success : function(ret){
               layer.close(loading);
               layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })

    $('#card_activity').on('click',function () {
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/noRecharge',
            'data'  : { },
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
            }
        });
    });
    function openAuthuri(obj, event) {
        event.preventDefault();
        var type 	= $(obj).data('authtype');
        var authcode= $(obj).data('authuri');
        var domain	= $(obj).data('authdomain');
        if (type == 'domain') {
            window.open(authcode);
        } else {
            window.open(domain+"/manage/user/wxCenter?loginid="+authcode);
        }
    }
</script><?php }} ?>
