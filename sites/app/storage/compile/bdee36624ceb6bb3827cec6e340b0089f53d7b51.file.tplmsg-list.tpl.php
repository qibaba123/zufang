<?php /* Smarty version Smarty-3.1.17, created on 2020-04-09 09:22:36
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/tplmsg-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20935474115e8e78dcab3b26-14039548%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdee36624ceb6bb3827cec6e340b0089f53d7b51' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/tplmsg-list.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20935474115e8e78dcab3b26-14039548',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tplid' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8e78dcae6aa6_66986673',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8e78dcae6aa6_66986673')) {function content_5e8e78dcae6aa6_66986673($_smarty_tpl) {?><style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
</style>
<div ng-app="Withdraw"  ng-controller="WithdrawList">
    <div class="page-header" style="overflow:hidden">
        <div class="col-sm-12">
            <a class="btn btn-green btn-sm refresh-btn" href="/wxapp/tplmsg/tplmsgManage/?tplId=<?php echo $_smarty_tpl->tpl_vars['tplid']->value;?>
">
                <i class="icon-plus bigger-40"></i>  添加模版信息
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">模版ID</th>
                        <th>标题</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_tplid'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['awt_title'];?>
</td>
                            <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['awt_update_time']);?>
</td>
                            <td class="jg-line-color">
                                <a href="/wxapp/tplmsg/tplmsgManage/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" class="deal-audit">
                                    查看编辑
                                </a>
                                <!--<a href="/wxapp/tplmsg/sendMsg?msgid=<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" class="btn btn-xs btn-info deal-audit">
                                    发送消息
                                </a>-->
                                 - <a href="javascript:;" class="del-btn"
                                   data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['awt_id'];?>
" style="color:#f00;">
                                    删除
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($_smarty_tpl->tpl_vars['paginator']->value) {?>
                        <tr><td colspan="5"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                    <?php }?>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/withdraw-list.js" ></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js" ></script>

<script type="text/javascript" language="javascript">
    $('.del-btn').on('click',function(){
        var data = {
            'type'  : 'appletwxtplmsg',
            'id'    : $(this).data('id')
        };
        commonDeleteByIdWxapp(data);
    });


</script>
<?php }} ?>
