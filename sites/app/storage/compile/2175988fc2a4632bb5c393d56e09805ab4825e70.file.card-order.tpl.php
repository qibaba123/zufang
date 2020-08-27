<?php /* Smarty version Smarty-3.1.17, created on 2020-04-05 09:39:36
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/card-order.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11055674875e8936d8698332-35591071%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2175988fc2a4632bb5c393d56e09805ab4825e70' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/memberCard/card-order.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11055674875e8936d8698332-35591071',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'cardtype' => 0,
    'appletCfg' => 0,
    'storeList' => 0,
    'val' => 0,
    'store' => 0,
    'cardList' => 0,
    'card' => 0,
    'nickname' => 0,
    'tid' => 0,
    'list' => 0,
    'storeListOld' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8936d8721447_21262097',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8936d8721447_21262097')) {function content_5e8936d8721447_21262097($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .total-amount{
        margin-right: 25px;
    }
    .balance .balance-info{
        width: 20% !important;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <?php echo $_smarty_tpl->getSubTemplate ("./tabal-link.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

            <div class="tab-content"  style="z-index:1;">
                <!-- 汇总信息 -->
                <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                    <div class="balance-info">
                        <div class="balance-title">销售总次数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['totalCount'];?>
</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">销售总人数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['memberCount'];?>
</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['totalMoney'];?>
</span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">微信支付销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['wxMoney'];?>
</span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">余额支付销售总金额<span></span></div>
                        <div class="balance-content">
                            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['coinMoney'];?>
</span>
                            <span class="unit">元</span>
                        </div>
                    </div>
                </div>
                <div class="page-header search-box">
                    <div class="col-sm-12">
                        <form action="/wxapp/membercard/cardOrder/type/<?php echo $_smarty_tpl->tpl_vars['cardtype']->value;?>
" method="get" class="form-inline">
                            <div class="col-xs-11 form-group-box">
                                <div class="form-container">
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value!=2) {?>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">门店：</div>
                                            <select name="store" id="store" class="form-control">
                                                <option value="0">全部</option>
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['storeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['acs_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['acs_id']==$_smarty_tpl->tpl_vars['store']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['acs_name'];?>
</option>
                                                <?php } ?>
                                                <?php } else { ?>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['storeList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['os_id']==$_smarty_tpl->tpl_vars['store']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>
</option>
                                                <?php } ?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员卡：</div>
                                            <select name="card" id="card" class="form-control">
                                                <option value="0">全部</option>
                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cardList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['oc_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['oc_id']==$_smarty_tpl->tpl_vars['card']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['oc_name'];?>
</option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员昵称：</div>
                                            <input type="text" class="form-control" name="nickname" value="<?php echo $_smarty_tpl->tpl_vars['nickname']->value;?>
" placeholder="会员昵称">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">订单编号：</div>
                                            <input type="text" class="form-control" name="tid" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
" placeholder="会员昵称">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1 pull-right search-btn">
                                <button type="submit" class="btn btn-green btn-sm search-btn">查询</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <!--------------会员卡购买记录列表---------------->
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <th>购买人</th>
                                    <th>会员卡</th>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value!=2) {?>
                                    <th>门店</th>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                                    <th>公司</th>
                                    <?php }?>
                                    <th>金额</th>
                                    <th>状态</th>
                                    <th>付款方式</th>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                    <th>备注</th>
                                    <?php }?>
                                    <th>支付时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_buyer_nick'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_title'];?>
</td>
                                    <?php if ($_smarty_tpl->tpl_vars['cardtype']->value!=2) {?>
                                        <td>
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['acs_name']) {?>
                                            <?php echo $_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['acs_name'];?>

                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['storeListOld']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['os_name']) {?>
                                            <?php echo $_smarty_tpl->tpl_vars['storeListOld']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['os_name'];?>

                                            <?php }?>
                                        <?php } else { ?>
                                            <?php echo $_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['os_name'];?>

                                        <?php }?>
                                        </td>
                                        <!--
                                        <td><?php echo $_smarty_tpl->tpl_vars['storeList']->value[$_smarty_tpl->tpl_vars['val']->value['oo_st_id']]['os_name'];?>
</td>
                                        -->
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['ajc_company_name'];?>
</td>
                                    <?php }?>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['oo_amount'];?>
</td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['oo_status']==2) {?>已付款<?php } else { ?><span style="color: red">未支付</span><?php }?>
                                    </td>
                                    <td>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['oo_status']==2) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['oo_pay_type']==1) {?>微信支付<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['oo_pay_type']==2) {?>余额支付<?php }?>
                                        <?php }?>
                                    </td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                    <td style="max-width: 250px;overflow: hidden;white-space: normal">
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['oo_remark'];?>

                                    </td>
                                    <?php }?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['oo_pay_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['oo_pay_time']);?>
<?php }?></td>
                                </tr>
                                <?php } ?>
                                <tr><td colspan="11"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<?php }} ?>
