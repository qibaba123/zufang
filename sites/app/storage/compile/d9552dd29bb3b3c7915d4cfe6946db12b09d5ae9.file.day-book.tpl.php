<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 16:20:37
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/day-book.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3508907935e8c37d5af4af1-24891530%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd9552dd29bb3b3c7915d4cfe6946db12b09d5ae9' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/day-book.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3508907935e8c37d5af4af1-24891530',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'showSecond' => 0,
    'member' => 0,
    'choseLink' => 0,
    'val' => 0,
    'type' => 0,
    'list' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c37d5b3f274_64183492',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c37d5b3f274_64183492')) {function content_5e8c37d5b3f274_64183492($_smarty_tpl) {?><style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .infobox{
        width: 95%;
        height: 85px;
        margin:0 auto;
        text-align: center;
        padding-top: 5%;
    }
    .info-tongji .infobox-orange{
        background-color: #f9c13a;
    }
    .info-tongji .infobox-green{
        background-color: #9ccb59;
    }
    .info-tongji .infobox-green2{
        background-color: #02a7a9;
    }
    .info-tongji .infobox-blue2{
        background-color: #0181ca;
    }

    .infobox>span{
        font-size: 25px;
        margin-top: 5px;
        display: block;
    }
    .infobox>p{
        margin:0;
    }
    .info-tongji{
        overflow: hidden;
        margin-bottom:25px;
    }
    .info-tongji>div{
        text-align: center;
    }
</style>
<?php if ($_smarty_tpl->tpl_vars['showSecond']->value==1) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<div id="mainContent">
    <div class="user-moneyinfo">
        <h4 style="padding: 0 20px;font-weight: bold;font-size: 14px;"><?php echo $_smarty_tpl->tpl_vars['member']->value['m_nickname'];?>
</h4>
        <div class="row info-tongji" >
            <div class="col-sm-3">
                <div class="infobox infobox-orange infobox-dark">
                    <span><?php echo $_smarty_tpl->tpl_vars['member']->value['m_deduct_amount'];?>
</span>
                    <p><i class="icon-comment"></i> 返佣总额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-green infobox-dark">
                    <span><?php echo $_smarty_tpl->tpl_vars['member']->value['m_deduct_ktx'];?>
</span>
                    <p><i class="icon-user"></i> 可提现金额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-green2 infobox-dark">
                    <span><?php echo $_smarty_tpl->tpl_vars['member']->value['m_deduct_ytx'];?>
</span>
                    <p><i class="icon-certificate"></i> 已提现金额 </p>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="infobox infobox-blue2 infobox-dark">
                    <span><?php echo $_smarty_tpl->tpl_vars['member']->value['m_deduct_dsh'];?>
</span>
                    <p><i class="icon-book"></i> 待审核提现金额 </p>
                </div>
            </div>
        </div>
    </div>
    <div class="choose-state">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
" <?php if ($_smarty_tpl->tpl_vars['type']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?> class="active" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
        <?php } ?>
    </div>
    <div class="row">
        <!-- <div class="space-4"></div> -->
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-hover table-button">
                            <thead>
                            <tr>
                                <th class="hidden-480">订单编号</th>
                                <th>级别</th>
                                <th>流水金额</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    流水时间
                                </th>
                                <th>备注</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['dd_tid'];?>
</td>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['dd_level']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['dd_level'];?>
级<?php } else { ?>返现<?php }?></td>
                                    <td class="hidden-480">
                                        <?php if (in_array($_smarty_tpl->tpl_vars['val']->value['dd_record_type'],array(1,2))) {?>
                                        <span class="label label-sm label-success"> + <?php echo $_smarty_tpl->tpl_vars['val']->value['dd_amount'];?>
 </span>
                                        <?php } else { ?>
                                        <span class="label label-sm label-danger"> - <?php echo $_smarty_tpl->tpl_vars['val']->value['dd_amount'];?>
 </span>
                                        <?php }?>
                                    </td>
                                    <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['dd_record_time']);?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['dd_record_remark'];?>
</td>
                                </tr>
                                <?php } ?>
                                <tr><td colspan="5"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                            </tbody>
                        </table>
                        <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->
        </div>
    </div>
</div>



<?php }} ?>
