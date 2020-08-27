<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 18:36:04
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/push-history.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6472451655e8c5794c2e205-54792840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb87ad93892637087463b6aac33d3470ac41edc2' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/tplmsg/push-history.tpl',
      1 => 1575621713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6472451655e8c5794c2e205-54792840',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c5794c60523_64687097',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c5794c60523_64687097')) {function content_5e8c5794c60523_64687097($_smarty_tpl) {?><style>
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
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th class="hidden-480">推送时间</th>
                        <th>送达人数</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['aph_id'];?>
">
                            <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['aph_create_time']);?>
</td>
                            <td style="text-align: center;max-width: 80px;">
                                <?php echo $_smarty_tpl->tpl_vars['val']->value['aph_total'];?>

                                <?php if ($_smarty_tpl->tpl_vars['val']->value['aph_total']==0&&strstr($_smarty_tpl->tpl_vars['val']->value['aph_error_msg'],'invalid template_id')) {?>
                                <p style="color: red">请至微信公众平台查看模板消息是否存在或可用</p>
                                <?php }?>
                            </td>
                            <td>
                                <a href="/wxapp/tplpreview/receiveList/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['aph_id'];?>
" class="btn btn-xs btn-info deal-audit">
                                    查看
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


</script>
<?php }} ?>
