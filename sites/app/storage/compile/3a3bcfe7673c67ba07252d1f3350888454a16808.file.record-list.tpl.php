<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:18:19
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/customer/record-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12201976925e4dfa7b8e8a01-66616982%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3a3bcfe7673c67ba07252d1f3350888454a16808' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/customer/record-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12201976925e4dfa7b8e8a01-66616982',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'appletCfg' => 0,
    'type' => 0,
    'start' => 0,
    'end' => 0,
    'list' => 0,
    'val' => 0,
    'page_html' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4dfa7b919331_79859500',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4dfa7b919331_79859500')) {function content_5e4dfa7b919331_79859500($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .table tbody tr td {
        white-space: normal;
    }
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }

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
<div id="content-con">
    <div style="margin-bottom: 10px">
        <span style="">
        <span class="switch-title">启用客服通知：</span>
        <label id="choose-onoff" class="choose-onoff">
            <input class="ace ace-switch ace-switch-5" id="kefuMobile"  data-type="open" onchange="kefuMobileOpen()" type="checkbox" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_kefu_mobile']==1) {?>checked<?php }?>>
            <span class="lbl"></span>
        </label>
        <span style="color: red">此功能启用时，用户最后一次使用客服的时间将被记录，用户必须绑定手机号后才能使用客服功能</span>
    </span>
    </div>

    <div  id="mainContent" >


        <div class="page-header search-box">
            <div class="col-sm-12">
                <form action="/wxapp/customer/index" method="get" class="form-inline">
                    <input type="hidden" name="type" value="<?php echo $_smarty_tpl->tpl_vars['type']->value;?>
">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <div class="form-group" style="width:580px;">
                                <div class="input-group" style="width:100%;">
                                    <div class="start-endtime">
                                        <em style="width:70px;text-align:center">咨询时间：</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                        <em style="padding:0 3px;">到</em>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                            <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>

                            <th>头像</th>
                            <th>昵称</th>
                            <th>手机</th>
                            <th>最近咨询</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <td>
                                    <img style="width: 50px;" src="<?php if ($_smarty_tpl->tpl_vars['val']->value['m_avatar']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['m_avatar'];?>
<?php } else { ?>/public/wxapp/images/applet-avatar.png<?php }?>" alt="">
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['kur_mobile'];?>
</td>
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['kur_update_time']);?>
</td>
                                <td>
                                    <a href="/wxapp/customer/chatList?openid=<?php echo $_smarty_tpl->tpl_vars['val']->value['m_openid'];?>
">聊天记录</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
            <?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>

        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    function kefuMobileOpen() {
        var open   = $('#kefuMobile:checked').val();
        console.log(open);
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/customer/kefuMobileOpen',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }
</script><?php }} ?>
