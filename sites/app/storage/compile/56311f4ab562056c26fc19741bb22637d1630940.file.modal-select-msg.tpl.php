<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 18:57:36
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/wechat/modal-select-msg.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10817270815e4e662042baa5-74345402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '56311f4ab562056c26fc19741bb22637d1630940' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/wechat/modal-select-msg.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10817270815e4e662042baa5-74345402',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
    'mal' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e662046eb96_90338420',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e662046eb96_90338420')) {function content_5e4e662046eb96_90338420($_smarty_tpl) {?><style type="text/css">
    .message-muban .form-horizontal .control-label{
        font-weight: bold;
        margin-bottom:0;
        line-height: 34px;
        padding-top: 0;
    }
    .message-muban select.form-control{
        height: 34px;
    }
    .message-fenlei{
        background-color: #f6f6f6;
        border:1px solid #e8e8e8;
        border-radius: 4px;
        margin-bottom: 10px;
        padding: 0 10px;
        padding-top: 15px;
    }
    .message-fenlei:last-child{
        margin-bottom: 0;
    }
    .message-fenlei .fenlei-name{
        font-size: 14px;
        line-height: 35px;
        font-weight: bold;
        border-right: 1px dashed #ddd;
        height: 35px;
        color: #02a802;
    }
    .modal-body{
        max-height: 650px;
        overflow: auto;
    }

</style>
<div class="modal fade" id="myMessageMuban" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;padding-top: 5%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myMessageMubanLabel">
                    消息模板
                </h4>
            </div>
            <div class="modal-body">
                <div class="message-muban">
                    <!--<div class="alert alert-block alert-success">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        <p class="text-center">温馨提示</p>
                        <ol>
                            <li><small>模版消息使用微信模版消息，每天限制5000000</small></li>
                            <li><small>图文消息使用微信客服消息，每天限制1000000</small></li>
                        </ol>
                    </div>-->
                    <div class="form-group">
                        <a href="/wxapp/tplmsg/tpl" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 添加模版消息</a>
                        <!--<a href="/manage/wechat/graphicList" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 添加图文消息</a>-->
                    </div>
                    <form class="form-horizontal" id="msg-form" role="form">
                        <input type="hidden" id="hid_id" name="hid_id" value="">
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">支付成功</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="zfcg_msgid" name="zfcg_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">开团成功</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="ktcg_msgid" name="ktcg_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name" >
                                关闭提醒 <i class="icon-lightbulb  light-btn" id="gbtx-desc"  data-type="gbtx"></i>
                            </div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="gbtx_msgid" name="gbtx_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">拼团成功</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="ptcg_msgid" name="ptcg_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">店铺动态<i class="icon-lightbulb light-btn" id="dpdt-desc"  data-type="dpdt"></i></div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="dpdt_msgid" name="dpdt_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">商品动态<i class="icon-lightbulb  light-btn" id="spdt-desc" data-type="spdt"></i></div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="spdt_msgid" name="spdt_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">拼团失败</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="ptsb_msgid" name="ptsb_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="message-fenlei clearfix">
                            <div class="col-xs-2 fenlei-name">活动结束</div>
                            <div class="col-xs-10">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">模板消息</label>
                                    <div class="col-sm-10">
                                        <select id="hdjs_msgid" name="hdjs_msgid" class="form-control">
                                            <option value="0">不发送</option>
                                            <?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['msg']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mal']->value['awt_title'];?>
</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary msg-save-btn">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    $('.info-btn').on('click',function(){
        $('#hid_id').val($(this).data('id'));
        var field = new Array('zfcg','ktcg','spdt','dpdt','gbtx','ptcg','ptsb','hdjs');
        for(var i=0;i<field.length;i++){
            $('#'+field[i]+'_msgid').val($(this).data(field[i]+'-msg'));
            $('#'+field[i]+'_nwid').val($(this).data(field[i]+'-nw'));
        }

        $('#myMessageMuban').modal('show');

    });

    $('.msg-save-btn').on('click',function(){
        var loading = layer.load(1, {
            shade: [0.6,'#fff'], //0.1透明度的白色背景
            time: 4000
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/group/groupMsg',
            'data'  : $('#msg-form').serialize(),
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#myMessageMuban').modal('hide');
                    window.location.reload();
                }
            }
        });
    });

    $('.light-btn').on('click',function(){
        var id   = $(this).attr('id');
        var type = $(this).data('type');
        var html = '';
        switch (type){
            case 'gbtx':
                html = '<ol><li>关闭原因：参与人员不足等情况</li><li>提醒时间：活动结束前<font color="red">12</font>小时，前<font color="red">6</font>小时，两次提醒</li></ol>';
                break;
            case 'dpdt':
                html = '<ol><li>提醒时间：开团成功后<font color="red">45</font>小时</li></ol>';
                break;
            case 'spdt':
                html = '<ol><li>提醒时间：开团成功后<font color="red">36</font>小时</li></ol>';
                break;
        }

        layer.tips(html, '#'+id, {
            tips: [2, '#3595CC'],
            time: 6000
        });
    });

</script><?php }} ?>
