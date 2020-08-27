<?php /* Smarty version Smarty-3.1.17, created on 2020-04-18 11:51:53
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/information-card-pay-record.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9651589775e9a79596ee476-60027175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57c6df024f6d5849bbc6c503672fb70abd61244e' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/currency/information-card-pay-record.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9651589775e9a79596ee476-60027175',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'statInfo' => 0,
    'list' => 0,
    'val' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e9a7959720966_12628963',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9a7959720966_12628963')) {function content_5e9a7959720966_12628963($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .balance .balance-info{
        width: 50% !important;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd;}
</style>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


    <div class="row" style="margin-left: 150px;margin-top: 20px;">
        <div class="col-sm-9" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a  href="/wxapp/currency/informationCardType">
                            <i class="green icon-money bigger-110"></i>
                            付费会员类型
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/currency/getInformationMemberList">
                            <i class="green icon-th-large bigger-110"></i>
                            付费会员
                        </a>
                    </li>
                    <li>
                        <a href="/wxapp/currency/getInformationPayRecord">
                            <i class="green icon-cog bigger-110"></i>
                            资讯付费记录
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-cog bigger-110"></i>
                            会员购买记录
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <!-- 汇总信息 -->
                    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                        <div class="balance-info">
                            <div class="balance-title">总收入金额<span></span></div>
                            <div class="balance-content">
                                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['money'];?>
</span>
                                <span class="unit">元</span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">购买总次数<span></span></div>
                            <div class="balance-content">
                                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
                            </div>
                        </div>
                    </div>
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>会员标题</th>
                                    <th>用户昵称</th>
                                    <th>支付金额</th>
                                    <th>支付时间</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['aicp_id'];?>
">
                                        <td style="">
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['aicp_card_title'];?>

                                        </td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>
</td>
                                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['aicp_pay_money'];?>
</td>
                                        <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['aicp_create_time']);?>
</td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>

</script><?php }} ?>
