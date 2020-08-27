<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:13:40
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/manager/manager.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3655054945dea1bc4eb4565-69021456%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4bf68e40fb6fbcae7110b0ac63be9a58b009a089' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/manager/manager.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3655054945dea1bc4eb4565-69021456',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'applet' => 0,
    'list' => 0,
    'item' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1bc4f1b856_06684933',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1bc4f1b856_06684933')) {function content_5dea1bc4f1b856_06684933($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_date_format')) include '/mnt/www/default/duodian/tdtinstall/libs/view/smarty/libs/plugins/modifier.date_format.php';
?><link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">
<style>
    .zent-dialog-body .online-pay-content .weixin-btn {
        top: 45px;
        bottom: inherit;
    }
    .zent-dialog-body .online-pay-content .weixin-btn p {
        margin-bottom: 60px;
    }
</style>
<div>
    <div class="page-header">
        <button onclick="showAddModel()" class="btn btn-green" role="button" data-toggle="modal"><i class="icon-plus bigger-80"></i> 添加操作员</button>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <!--
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                -->
                                <th>姓名</th>
                                <th>手机号</th>
                                <th>是否允许登录企商平台</th>
                                <th class="hidden-480">性别</th>
                                <?php if ($_smarty_tpl->tpl_vars['applet']->value['ac_report_open']) {?>
                                <th>微信号</th>
                                <?php }?>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    创建时间
                                </th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                            <tr id="tr_id_<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
">
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  name="ids"  value="<?php echo $_smarty_tpl->tpl_vars['val']->value['m_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td>
                                    <a href="#"><?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
<?php if ($_smarty_tpl->tpl_vars['item']->value['m_fid']==0) {?>（主管理员）<?php }?></a>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['item']->value['m_mobile'];?>
</td>
                                <td><?php if ($_smarty_tpl->tpl_vars['item']->value['m_login_client']==1||$_smarty_tpl->tpl_vars['item']->value['m_fid']==0) {?>允许<?php } else { ?>不允许<?php }?></td>
                                <td class="hidden-480"><?php if ($_smarty_tpl->tpl_vars['item']->value['m_sex']=='M') {?>男<?php } else { ?>女<?php }?></td>
                                <?php if ($_smarty_tpl->tpl_vars['applet']->value['ac_report_open']) {?>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['item']->value['m_weixin_mid']) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['mavatar'];?>
" alt="" style="width: 50px;float: left">
                                    <div style="float: left;margin-left: 8px;">
                                        <div style="margin-top: 3px;text-align: left;"><?php echo $_smarty_tpl->tpl_vars['item']->value['mnickname'];?>
<a href="javascript:;" style="margin-left: 3px;" data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
" onclick="unbindMember(this)">解绑</a></div>
                                        <div style="margin-top: 12px;">消息通知:<?php if ($_smarty_tpl->tpl_vars['item']->value['m_report_open']) {?>已开启<?php } else { ?>已关闭<?php }?><a href="javascript:;" style="margin-left: 3px;"  data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_report_open'];?>
" onclick="changeReportStatus(this)">修改</a></div>
                                    </div>
                                    <?php }?>
                                </td>
                                <?php }?>
                                <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['m_createtime'],"%Y-%m-%d %H:%M:%S");?>
</td>
                                <td>
                                    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['m_fid']>0) {?>
                                        <button class="btn btn-xs btn-info" onclick="showModel(this)"
                                                data-id="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
"
                                                data-nickname="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
"
                                                data-mobile="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_mobile'];?>
"
                                                data-login="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_login_client'];?>
"
                                                data-sex="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_sex'];?>
" >
                                            编辑
                                        </button>
                                        <a class="btn btn-xs btn-yellow" style="margin-left: 15px" href="/wxapp/manager/settingRole/id/<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
">
                                            设置权限
                                        </a>
                                        <button class="btn btn-xs btn-danger" style="margin-left: 15px"
                                                onclick="deleteManager('<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
')" data-mid="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_id'];?>
">
                                            删除
                                        </button>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['item']->value['m_report_qrcode']&&$_smarty_tpl->tpl_vars['applet']->value['ac_report_open']) {?>
                                        <a class="btn btn-xs btn-green" data-qrcode="<?php echo $_smarty_tpl->tpl_vars['item']->value['m_report_qrcode'];?>
" onclick="bindMember(this)" <?php if ($_smarty_tpl->tpl_vars['item']->value['m_fid']>0) {?>style="margin-left: 15px"<?php }?> href="javascript:;" >
                                            微信消息通知
                                        </a>
                                        <?php }?>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">操作员管理</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hid_id" value="0">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none">手机号 : </div>
                                    <input type="text" class="form-control" id="mobile" placeholder="请输入管理员电话" style="border-radius:4px;">
                                </div>
                            </div>

                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 姓&emsp;&emsp;&emsp;名 : </div>
                                    <input type="text" class="form-control" id="nickname" placeholder="管理员姓名" style="border-radius:4px;">
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon" style="background-color:#fff;border:none"> 密&emsp;&emsp;&emsp;码 : </div>
                                    <input type="password" class="form-control" id="password" placeholder="修改管理员信息时，不填写视为不修改" style="border-radius:4px;">
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="manager-sex" class="input-group-addon" style="background-color:#fff;border:none">是否允许登录企商平台：</label>
                                    <div style="width:100%;">
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-login" id="islogin" value="1"> 允许
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-login" id="nologin" value="0"> 不允许
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <div class="input-group">
                                    <label for="manager-sex" class="input-group-addon" style="background-color:#fff;border:none">性&emsp;&emsp;&emsp;别：</label>
                                    <div style="width:100%;">
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-sex" id="sex_m" value="M"> 男
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio"  name="manager-sex" id="sex_f" value="F"> 女
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary" onclick="saveWxappManager()">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="qrcodeModalLabel">
                    微信消息通知
                </h4>
            </div>
            <div class="modal-body">
                <div class="zent-dialog-body clearfix">
                    <div class="online-pay-content" style="display: block;">
                        <div class="pay-qrcode image-code">
                            <img src="" alt="公众号二维码" id="weixin-qrcode">
                        </div>
                        <div class="weixin-btn">
                            <p>微信扫码关注公众号</p>
                            <input class="zent-btn zent-btn-primary js-qrcode-success" onclick="hadScan(this, event)" type="submit" value="我已关注">
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    function showAddModel() {
        $("#hid_id").val(0);
        $("#mobile").val('');
        $("#nickname").val('');
        $("#password").val('');
        $('#islogin').attr("checked","checked");
        $('#modal-info-form').modal('show');
    }

    function showModel(ele) {
        $("#hid_id").val($(ele).data('id'));
        $("#mobile").val($(ele).data('mobile'));
        $("#nickname").val($(ele).data('nickname'));
        $("#password").val('');
        if($(ele).data('login')==1){
            $('#islogin').attr("checked","checked");
        }else{
            $('#nologin').attr("checked","checked");
        }
        if($(ele).data('sex')=='M'){
            $('#sex_m').attr("checked","checked");
        }else{
            $('#sex_f').attr("checked","checked");
        }
        $('#modal-info-form').modal('show');
    }
    function saveWxappManager() {
        var hid_id   = $("#hid_id").val();
        var mobile   = $("#mobile").val();
        var nickname = $("#nickname").val();
        var password = $("#password").val();
        var sex      = $('input[name="manager-sex"]:checked').val();
        var login      = $('input[name="manager-login"]:checked').val();
        var pattern = /^1[23456789]\d{9}$/;
        if (!pattern.test(mobile)) {
            layer.msg('请输入有效的手机号');
            return false;
        }
        var data = {
            'id'        : hid_id,
            'mobile'    : mobile,
            'nickname'  : nickname,
            'password'  : password,
            'login'     : login,
            'sex'       : sex
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/manager/saveManager',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200 ){
                    window.location.reload();
                }
            }
        });
    };

    function deleteManager(mid) {
        if(mid){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/manager/deleteManager',
                'data'  : { mid:mid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        window.location.reload();
                    }
                }
            });
        }
    }

    function bindMember(ele) {
        let qrcode = $(ele).data('qrcode');
        $('#weixin-qrcode').attr('src', qrcode);
        $('#qrcodeModal').modal('show');
    }

    function hadScan(obj, event) {
        event.preventDefault();
        location.reload();
    }

    function unbindMember(ele) {
        let id = $(ele).data('id');
        layer.confirm('解除绑定后，将无法接收消息通知？', {
            btn: ['确定','取消'], //按钮
            title : '解绑'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/manager/unbindMember',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    function changeReportStatus(ele) {
        let id = $(ele).data('id');
        let status = $(ele).data('status');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/manager/changeReportStatus',
            'data'  : { id:id, status: status},
            'dataType' : 'json',
            success : function(ret){
                layer.msg(ret.em,{
                    time: 2000, //2s后自动关闭
                },function(){
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                });
            }
        });
    }

</script>
<?php }} ?>
