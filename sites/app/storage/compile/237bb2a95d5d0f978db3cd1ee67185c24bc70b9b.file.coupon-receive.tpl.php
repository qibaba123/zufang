<?php /* Smarty version Smarty-3.1.17, created on 2020-04-22 16:23:53
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/coupon/coupon-receive.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4991708195e9fff19b381e9-34612035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '237bb2a95d5d0f978db3cd1ee67185c24bc70b9b' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/coupon/coupon-receive.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4991708195e9fff19b381e9-34612035',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'couponCenter' => 0,
    'curr_shop' => 0,
    'esId' => 0,
    'nickname' => 0,
    'name' => 0,
    'cid' => 0,
    'list' => 0,
    'val' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e9fff19b82d47_13857944',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9fff19b82d47_13857944')) {function content_5e9fff19b82d47_13857944($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<?php if ($_smarty_tpl->tpl_vars['couponCenter']->value==1&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==5741) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

    <?php }?>
<div  id="content-con" <?php if ($_smarty_tpl->tpl_vars['couponCenter']->value==1&&$_smarty_tpl->tpl_vars['curr_shop']->value['s_id']==5741) {?>style="margin-left:130px"<?php }?>>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/coupon/receive" method="get" class="form-inline">
                <input type="hidden" name="esid" value="<?php echo $_smarty_tpl->tpl_vars['esId']->value;?>
">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">领取会员昵称</div>
                                <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
" placeholder="领取会员昵称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">优惠券名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="优惠券名称">
                            </div>
                        </div>
                        <input type="hidden" name="cid" value="<?php echo $_smarty_tpl->tpl_vars['cid']->value;?>
">
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
                <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th>优惠券</th>
                        <th>领取人</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            领取时间
                        </th>
                        <th>是否使用</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            使用时间
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <tr>
                            <td class="proimg-name">
                                <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['cl_name'])>20) {?>
                                    <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['cl_name'],0,20);?>

                                <?php } else { ?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['cl_name'];?>

                                <?php }?>
                            </td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                            <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['cr_receive_time']);?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['val']->value['cr_is_used']==1) {?>已使用<?php } else { ?>未使用<?php }?></td>
                            <td><?php if ($_smarty_tpl->tpl_vars['val']->value['cr_used_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['cr_used_time']);?>
<?php }?></td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="10" style="text-align:right"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                    </tbody>
                </table>

            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>    <!-- PAGE CONTENT ENDS -->

<?php }} ?>
