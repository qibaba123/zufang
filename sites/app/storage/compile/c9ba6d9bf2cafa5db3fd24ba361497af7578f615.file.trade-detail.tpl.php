<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 15:53:22
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/order/trade-detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10967135555e8c3172aa3163-53566649%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c9ba6d9bf2cafa5db3fd24ba361497af7578f615' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/order/trade-detail.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10967135555e8c3172aa3163-53566649',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'isActivity' => 0,
    'row' => 0,
    'noExpress' => 0,
    'tradeType' => 0,
    'tradePay' => 0,
    'appletCfg' => 0,
    'member' => 0,
    'deduct_row' => 0,
    'val' => 0,
    'vv' => 0,
    'desc' => 0,
    'legworkStatusNote' => 0,
    'statusNote' => 0,
    'needSend' => 0,
    'goodsName' => 0,
    'nowStatus' => 0,
    'list' => 0,
    'coupon' => 0,
    'cal' => 0,
    'full' => 0,
    'fal' => 0,
    'track' => 0,
    'key' => 0,
    'last' => 0,
    'mal' => 0,
    'express' => 0,
    'expressNote' => 0,
    'printlist' => 0,
    'rowJson' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c3172c62572_11758542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c3172c62572_11758542')) {function content_5e8c3172c62572_11758542($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/order/trade-detail.css">
<style>
    .tooltip-inner{
        max-width: 245px;
    }
    .right-price{
        width: 80px;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
    }
    .yh-price{
        font-size: 14px;
    }
    .icon_full{
        display: inline-block;
        vertical-align: middle;
        font-size: 12px;
        color: #fff;
        background-color: #e2010c;
        font-style: normal;
        width: 16px;
        height: 16px;
        line-height: 16px;
        text-align: center;
        border-radius: 4px;
        margin-right: 3px;
        position: relative;
        top: -1px;
    }
    .real-price{
        font-size: 14px;
    }

    .page-trade-order-detail .info-table th {
        text-align: center;
    }

    .page-trade-order-detail .info-table td {
        color: #999;
        padding: 0 0 10px 0;
        vertical-align: top;
        font-size: 12px;
    }
</style>
<object id="LODOP_OB" classid="clsid:2105C259-1E0C-4534-8141-A753534CB4CA" width=0 height=0> </object> 
<embed id="LODOP_EM" type="application/x-print-lodop" width=0 height=0></embed>
</object>
<?php if ($_smarty_tpl->tpl_vars['isActivity']->value==1) {?>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="page-trade-order-detail" style="margin-left: 130px">
<?php } else { ?>
<div class="page-trade-order-detail">
<?php }?>
    <div class="app-init-container">
        <div class="step-region">
            <ul class="ui-step ui-step-4">
                <li class="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_create_time']) {?>ui-step-done<?php }?>" <?php if ($_smarty_tpl->tpl_vars['noExpress']->value==1) {?> style="margin-left: 10%" <?php }?>>
                    <div class="ui-step-title">
                        买家下单
                    </div>
                    <div class="ui-step-number">
                        1
                    </div>
                    <div class="ui-step-meta">
						<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_create_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['t_create_time']);?>
<?php }?>
                    </div>
                </li>
                <li class="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_pay_time']) {?>ui-step-done<?php }?>" >
                    <div class="ui-step-title">
                        付款至微信
                    </div>
                    <div class="ui-step-number">
                        2
                    </div>
                    <div class="ui-step-meta">
						<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_pay_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['t_pay_time']);?>
<?php }?>
                    </div>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['noExpress']->value==0) {?>
                <li class="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_express_time']) {?>ui-step-done<?php }?>">
                    <div class="ui-step-title">
                        商家发货
                    </div>
                    <div class="ui-step-number">
                        3
                    </div>
                    <div class="ui-step-meta">
						<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_express_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['t_express_time']);?>
<?php }?>
					</div>
                </li>
                <?php }?>
                <li class="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_finish_time']) {?>ui-step-done<?php }?>">
                    <div class="ui-step-title">
                        结算货款
                    </div>
                    <div class="ui-step-number">
                        <?php if ($_smarty_tpl->tpl_vars['noExpress']->value==0) {?>4<?php } else { ?>3<?php }?>
                    </div>
                    <div class="ui-step-meta">
						<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_finish_time']) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['t_finish_time']);?>
<?php }?>
                    </div>
                </li>
            </ul>
        </div>
        <div class="content-region clearfix">
        	<div class="info-region">
        	    <h3 style="margin-top:0"><?php if ($_smarty_tpl->tpl_vars['row']->value['t_type']==1) {?><span class="tuan-tag">团</span><?php } elseif ($_smarty_tpl->tpl_vars['row']->value['t_type']==2) {?><span class="tuan-tag">奖</span><?php }?>订单信息<!--<span class="secured-title">担保交易</span>--></h3>
        	    <table class="info-table">
        	        <tbody>
        	            <tr>
        	                <th>订单编号：</th>
        	                <td><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['t_tid'];?>
<?php }?>
                                <!--<a href="javascript:;" data-toggle="tooltip" data-html="true" data-placement="top" title="外部订单号：22015236446325236655<br>支付流水号：142515658556665566"> 更多</a>-->
                            </td>
        	            </tr>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['legworkNum']) {?>
                            <tr>
                                <th>顺序号：</th>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['legworkNum'];?>

                                </td>
                            </tr>
                        <?php }?>
        	            <tr style="display: table-row;">
        	                <th>订单类型：</th>
        	                <td>
                                <!--
                                <?php if ($_smarty_tpl->tpl_vars['row']->value['t_applet_type']==11) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['asaj_isleader']==1) {?>
                                        发起接龙活动订单
                                    <?php } else { ?>
                                        参与接龙活动订单
                                    <?php }?>
                                <?php } else { ?>
                                <?php }?>
                                -->
                                <?php echo $_smarty_tpl->tpl_vars['tradeType']->value[$_smarty_tpl->tpl_vars['row']->value['t_applet_type']];?>

                            </td>
        	            </tr>
        	            <?php if ($_smarty_tpl->tpl_vars['row']->value['t_applet_type']==11&&($_smarty_tpl->tpl_vars['row']->value['asa_title']||$_smarty_tpl->tpl_vars['row']->value['asg_id'])) {?>
                            <tr>
                                <th>活动名称：</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['asa_title'];?>
</td>
                            </tr>
                            <tr>
                                <th>群组编号：</th>
                                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['asg_id'];?>
</td>
                            </tr>
                        <?php }?>
        	            <tr>
        	                <th class="<?php echo $_smarty_tpl->tpl_vars['row']->value['t_pay_type'];?>
">付款方式：</th>
        	                <td><?php echo $_smarty_tpl->tpl_vars['tradePay']->value[$_smarty_tpl->tpl_vars['row']->value['t_pay_type']];?>
</td>
        	            </tr>
        	            <tr>
        	                <th>买家：</th>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                            <td><a href="/wxapp/sequence/tradeList?buyer=<?php echo $_smarty_tpl->tpl_vars['row']->value['t_buyer_nick'];?>
" class="new-window" ><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['t_buyer_nick'];?>
<?php }?></a></td>
                            <?php } else { ?>
                            <td><a href="/wxapp/order/tradeList?buyer=<?php echo $_smarty_tpl->tpl_vars['row']->value['t_buyer_nick'];?>
" class="new-window" ><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['t_buyer_nick'];?>
<?php }?></a></td>
                            <?php }?>

        	            </tr>
        	        </tbody>
        	    </table>
        	    <div class="dashed-line"></div>
        	    <table class="info-table">
        	        <tbody>

        	            <tr>
        	                <th>配送方式：</th>
                            <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']==2) {?>
                            <td>门店自取</td>
                            <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['t_express_method']==1) {?>
                            <td>商家配送</td>
                            <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['t_express_method']==6) {?>
                            <td>团长配送</td>
                            <?php } else { ?>
                            <td>快递配送</td>
                            <?php }?>
        	            </tr>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']!=2&&$_smarty_tpl->tpl_vars['row']->value['t_addr_id']>0) {?>
        	            <tr>
        	                <th>收货信息：</th>
        	                <td>
        	                    <p><?php echo $_smarty_tpl->tpl_vars['row']->value['ma_province'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_city'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_zone'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_detail'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_name'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_phone'];?>
</p>
        	                    <div><a href="javascript:;" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['row']->value['ma_province'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_city'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_zone'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_detail'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_name'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_phone'];?>
" class="copy_input">[复制]</a>
        	                    </div>
        	                </td>
        	            </tr>
                        <?php if ($_smarty_tpl->tpl_vars['member']->value&&$_smarty_tpl->tpl_vars['member']->value['m_id_num']&&isset($_smarty_tpl->tpl_vars['member']->value['m_id_num'])) {?>
                        <tr>
                            <th>身份证号：</th>
                            <td>
                                <p><?php echo $_smarty_tpl->tpl_vars['member']->value['m_id_num'];?>
</p>
                            </td>
                        </tr>
                        <?php }?>
                        <?php } elseif (($_smarty_tpl->tpl_vars['row']->value['t_express_method']==2||$_smarty_tpl->tpl_vars['row']->value['t_express_method']==6||$_smarty_tpl->tpl_vars['row']->value['t_express_company']||$_smarty_tpl->tpl_vars['row']->value['t_express_code'])) {?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36) {?>
                        <tr>
                            <th>自取门店：</th>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['row']->value['t_es_id']>0) {?>
                                <?php echo $_smarty_tpl->tpl_vars['row']->value['es_name'];?>

                                <?php } else { ?>
                                <?php echo $_smarty_tpl->tpl_vars['row']->value['os_name'];?>

                                <?php }?>

                            </td>
                        </tr>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']==6) {?>
                            <tr>
                                <th>收货人：</th>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_company'];?>
   <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_code'];?>

                                </td>
                            </tr>
                            <tr>
                                <th>地址：</th>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['t_address'];?>

                                </td>
                            </tr>
                        <?php } else { ?>
                        <tr>
                            <th>自取人：</th>
                            <td>
                                <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_company'];?>
   <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_code'];?>

                            </td>
                        </tr>
                        <?php }?>
                        <?php }?>

                        <?php if ($_smarty_tpl->tpl_vars['deduct_row']->value&&$_smarty_tpl->tpl_vars['deduct_row']->value['asd_money']>0) {?>
                            <tr>
                                <th>团长佣金：</th>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['deduct_row']->value['asd_money'];?>

                                </td>
                            </tr>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_note']) {?>
                            <tr>
                                <th>物流备注：</th>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_note'];?>

                                </td>
                            </tr>
                            <?php }?>
        	            <tr>
        	                <th>买家留言：</th>
        	                <td><?php echo $_smarty_tpl->tpl_vars['row']->value['t_note'];?>
</td>
        	            </tr>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['row']->value['t_remark_extra']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr>
                                <th><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
：</th>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['type']=='image') {?>
                                <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
" alt="" style="height: 100px; width: 100px"></td>
                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['type']=='checkbox') {?>
                                <td>
                                <?php  $_smarty_tpl->tpl_vars['vv'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vv']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->key => $_smarty_tpl->tpl_vars['vv']->value) {
$_smarty_tpl->tpl_vars['vv']->_loop = true;
?>
                                <?php echo $_smarty_tpl->tpl_vars['vv']->value;?>
，
                                <?php } ?>
                                </td>
                                <?php } else { ?>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
</td>
                                <?php }?>
                            </tr>
                        <?php } ?>
        	        </tbody>
        	    </table>

                <div class="dashed-line"></div>
                <table style="margin-left: 10px;margin-top: 10px">
                    <tbody>
                    <tr>
                        <td><a class="confirm-handle btn btn-blue btn-xs" data-toggle="modal" data-target="#myPrintModal" style="text-align: center;line-height: 30px;width: 60px;border-radius: 5px;padding: 0;">小票打印</a></td>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_s_id']==5655) {?>
                        <td><a class="confirm-handle btn btn-blue btn-xs" onclick="printLodop()" style="text-align: center;line-height: 30px;width: 60px;border-radius: 5px;padding: 0;">面单打印</a></td>
                        <?php }?>
                    </tr>
                    </tbody>
                </table>
        	</div>

        	<div class="state-region">
        	    <div style="padding: 0px 0px 30px 40px;">
        	        <h3 class="state-title"><span class="icon <?php echo $_smarty_tpl->tpl_vars['desc']->value['class'];?>
"><?php echo $_smarty_tpl->tpl_vars['desc']->value['icon'];?>
</span>订单状态：<?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']==7) {?><?php echo $_smarty_tpl->tpl_vars['legworkStatusNote']->value[$_smarty_tpl->tpl_vars['row']->value['t_status']];?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['statusNote']->value[$_smarty_tpl->tpl_vars['row']->value['t_status']];?>
<?php }?></h3>
        	        <div class="state-desc">
                        <?php echo $_smarty_tpl->tpl_vars['desc']->value['desc'];?>

                        <?php if ($_smarty_tpl->tpl_vars['row']->value['t_refund_time']&&$_smarty_tpl->tpl_vars['row']->value['t_status']==8) {?>
                        &nbsp;<?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['row']->value['t_refund_time']);?>

                        <?php }?>
        	        </div>
                    <?php if ($_smarty_tpl->tpl_vars['needSend']->value&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36) {?>
                    <div class="state-btn">
                        <div class="btn btn-xs btn-blue" data-toggle="modal" data-target="#refund-form">发货</div>
                        <div class="btn btn-xs btn-link js-remark hide">备注</div>
                    </div>
                    <?php }?>
        	    </div>
        	    <div class="state-remind-region">
        	        <div class="dashed-line"></div>
        	        <div class="state-remind">
        	            <h4>交易提醒：</h4>
        	            <ul>
        	                <li>交易已成功，如果买家提出售后要求，请积极与买家协商，做好售后服务。</li>
        	            </ul>
        	        </div>
        	    </div>
        	</div>
        </div>
        <table class="ui-table ui-table-simple goods-table">
            <thead>
                <tr>
                    <th></th>
					<th class="cell-30"><?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?>名称</th>
					<th>购买规格</th>
                    <th>单价(元)</th>
                    <th>数量</th>
                    <th class="cell-13">小计(元)</th>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                    <th>自提/配送时间</th>
                    <?php }?>
                    <th>状态</th>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                    <th>操作</th>
                    <?php }?>
                </tr>
            </thead>
            <tbody>
                <tr class="tr-express">
                    <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']!=2&&$_smarty_tpl->tpl_vars['row']->value['t_express_method']!=6) {?>
                    <td><strong>包裹 - 1</strong></td>
                    <td><span class="express-meta"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_express_company']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_company'];?>
<?php }?></span><span class="express-meta"><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_express_code']) {?>运单号：<?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_code'];?>
<?php }?></span></td>
                    <td colspan="7"><span class="express-meta express-latest-news"><?php echo $_smarty_tpl->tpl_vars['nowStatus']->value;?>
</span>
                        <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['t_express_code']) {?>
                        <a href="javascript:;" data-toggle="modal" data-target="#logistics">更多</a>
                    &nbsp;&nbsp;&nbsp;<a href="javascript:;" id="location_reload">更新</a>
                        <?php }?>
                    </td>
                    <?php }?>
                </tr>
				<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
					<tr class="test-item">
						<td class="td-goods-image" rowspan="1">
							<div class="ui-centered-image" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['to_pic'];?>
" width="48" height="48" style="width: 48px; height: 48px;">
								<img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_cover'];?>
" style="max-width: 48px; max-height: 48px;"></div>
						</td>
						<td>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                            <a href="/wxapp/sequence/goodsEdit/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['to_g_id'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_title'];?>
</a>
                            <?php } else { ?>
                            <a href="/wxapp/goods/newAdd/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['to_g_id'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_title'];?>
</a>
                            <?php }?>
							<p class="c-gray"></p>
						</td>
						<td><?php echo $_smarty_tpl->tpl_vars['val']->value['to_gf_name'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['val']->value['to_price'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['val']->value['to_num'];?>
</td>
						<td>
							<p><?php echo $_smarty_tpl->tpl_vars['val']->value['to_total'];?>
</p>
							<div></div>
						</td>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                        <td><?php echo $_smarty_tpl->tpl_vars['val']->value['sendDate'];?>
</td>
                        <?php }?>
						<td class="td-postage" >
                            <?php if ($_smarty_tpl->tpl_vars['val']->value['to_se_verify']==1) {?>
                            已完成
                            <?php } else { ?>
                                 <?php if ($_smarty_tpl->tpl_vars['val']->value['to_fd_result']!=2) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['statusNote']->value[$_smarty_tpl->tpl_vars['row']->value['t_status']];?>

                                 <?php } else { ?>
                                    <span style="color: red">已退款</span>
                                 <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32)) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['to_fd_status']==4) {?>
                                        <p style='color: #9a999e;padding-top: 5px;'>等待「会计审核」处理中</p>
                                    <?php } else { ?>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['to_feedback']==0) {?>
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32) {?>
                                                <p style="margin-top: 5px"><a href="javasript:;" data-toid="<?php echo $_smarty_tpl->tpl_vars['val']->value['to_id'];?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['row']->value['t_status'];?>
" class="refund-btn-seq">主动退款</a></p>
                                            <?php } else { ?>
                                                <p style="margin-top: 5px"><a href="javasript:;" data-toid="<?php echo $_smarty_tpl->tpl_vars['val']->value['to_id'];?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['row']->value['t_status'];?>
" class="refund-btn">主动退款</a></p>
                                            <?php }?>
                                        <?php } else { ?>
                                            <p style="margin-top: 5px">
                                                <?php if ($_smarty_tpl->tpl_vars['val']->value['to_fd_result']==1) {?>
                                                拒绝退款
                                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['to_fd_result']==3) {?>
                                                撤销退款
                                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['to_fd_result']==0) {?>
                                                申请退款
                                                <?php } else { ?>
                                                同意退款
                                                <?php }?>
                                            </p>
                                        <?php }?>
                                    <?php }?>
                                <?php }?>
                            <?php }?>
                        </td>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                        <td class="td-postage">
                            <?php if ($_smarty_tpl->tpl_vars['val']->value['to_se_verify']==0&&in_array($_smarty_tpl->tpl_vars['val']->value['t_status'],array(3,4,5))) {?>
                            <span id="order_finish_<?php echo $_smarty_tpl->tpl_vars['val']->value['to_id'];?>
" class="btn btn-primary btn-xs " data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['to_id'];?>
" onclick="verifyTradeOrder(this)">核销商品</span>
                            <?php }?>
                        </td>
                        <?php }?>
					</tr>
				<?php } ?>

            </tbody>
            <tfoot>
            <tr>
                <td colspan="9" class="text-right">
                    <?php if ($_smarty_tpl->tpl_vars['coupon']->value) {?>
                    <?php  $_smarty_tpl->tpl_vars['cal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['coupon']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cal']->key => $_smarty_tpl->tpl_vars['cal']->value) {
$_smarty_tpl->tpl_vars['cal']->_loop = true;
?>
                    <p class="text-right">
                        <i class="icon_full">减</i><a href="javascript:;" ><?php echo $_smarty_tpl->tpl_vars['cal']->value['tc_c_name'];?>
：</a><span class="yh-price right-price"> &nbsp; - <?php echo $_smarty_tpl->tpl_vars['cal']->value['tc_discount_fee'];?>
</span>
                </p>
                <?php } ?>
                <?php }?>

                <?php if ($_smarty_tpl->tpl_vars['full']->value) {?>
                <?php  $_smarty_tpl->tpl_vars['fal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['fal']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['full']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['fal']->key => $_smarty_tpl->tpl_vars['fal']->value) {
$_smarty_tpl->tpl_vars['fal']->_loop = true;
?>
                <p class="text-right">
                    <i class="icon_full">减</i><a href="javascript:;"><?php echo $_smarty_tpl->tpl_vars['fal']->value['tf_name'];?>
：</a><span class="yh-price right-price"> &nbsp; - <?php echo $_smarty_tpl->tpl_vars['fal']->value['tf_discount_fee'];?>
</span>
                </p>
                <?php } ?>
                <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['row']->value['t_total_weight']>0) {?>
                    <p class="text-right">
                        <span>总重量：</span><span class="yh-price right-price"> &nbsp; <?php echo $_smarty_tpl->tpl_vars['row']->value['t_total_weight'];?>
</span>
                    </p>
                    <?php }?>
                    <p class="text-right">
                        <span>运费：</span><span class="yh-price right-price"> &nbsp; <?php echo $_smarty_tpl->tpl_vars['row']->value['t_post_fee'];?>
</span>
                    </p>
                    <p class="real-price"><span class="c-gray">实收总价：</span><span class="real-pay ui-money-income right-price">￥ <?php echo $_smarty_tpl->tpl_vars['row']->value['t_total_fee'];?>
</span></p>
                </td>
            </tr>
            </tfoot>
        </table>
    </div>
	<!-- 物流详情弹出层 -->
    <div class="modal fade" id="logistics" tabindex="-1" role="dialog" 
       aria-labelledby="myModalLabel" aria-hidden="true">
       	<div class="modal-dialog" style="width:650px;">
          	<div class="modal-content">
             	<div class="modal-header">
                	<button type="button" class="close" 
                   data-dismiss="modal" aria-hidden="true">
                      &times;
                	</button>
                	<h4 class="modal-title" id="logisticsLabel">
                   		物流详情
                	</h4>
             	</div>
             	<div class="modal-body">
    				<table class="ui-table ui-table-simple">
    				    <thead>
    				        <tr>
    				            <th class="cell-25">时间</th>
    				            <th class="cell-60">内容</th>
    				        </tr>
    				    </thead>
    				    <tbody>
							<?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['track']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mal']->key;
?>
    				        <tr <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['last']->value) {?>style="color: #390" <?php }?>>
    				            <td><?php echo $_smarty_tpl->tpl_vars['mal']->value['AcceptTime'];?>
</td>
    				            <td><?php echo $_smarty_tpl->tpl_vars['mal']->value['AcceptStation'];?>
</td>
    				        </tr>
							<?php } ?>
    				    </tbody>
    				</table>
             	</div>
          	</div><!-- /.modal-content -->
    	</div><!-- /.modal -->
    </div>
</div>

<div id="refund-form"  class="modal fade">
    <div class="modal-dialog" style="width:760px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="modelTitle">发货处理</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline form-horizontal">
                    <input type="hidden" id="hid_id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['t_tid'];?>
">
                    <input type="hidden" id="modal-type" value="express">
                    <input type="hidden" id="cate" value="detail">
                    <div class="row hid-row" id="show-express" style="margin:0">
                        <!--发货HTML-->
                        <table class="ui-table" style="margin-bottom:20px;">
                            <thead>
                                <tr>
                                    <th class="cell-35"><?php if ($_smarty_tpl->tpl_vars['goodsName']->value) {?><?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
<?php } else { ?>商品<?php }?></th>
                                    <th class="cell-5">数量</th>
                                    <th class="cell-5">单价</th>
                                    <th class="cell-5">总价</th>
                                </tr>
                            </thead>
                            <tbody id="buy-goods-modal">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr>
                                    <td class="cell-35"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_title'];?>
</td>
                                    <td class="cell-5"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_num'];?>
</td>
                                    <td class="cell-5"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_price'];?>
</td>
                                    <td class="cell-5"><?php echo $_smarty_tpl->tpl_vars['val']->value['to_total'];?>
</td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="control-group clearfix">
                            <label class="control-label">收货信息：</label>
                            <div class="controls">
                                <div class="control-action" id="modal-address">
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value['t_express_method']!=2&&$_smarty_tpl->tpl_vars['row']->value['t_addr_id']>0) {?>
                                    <span><?php echo $_smarty_tpl->tpl_vars['row']->value['ma_province'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_city'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_zone'];?>
 <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_detail'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_name'];?>
, <?php echo $_smarty_tpl->tpl_vars['row']->value['ma_phone'];?>
</span>
                                    <?php } elseif (($_smarty_tpl->tpl_vars['row']->value['t_express_method']==2||$_smarty_tpl->tpl_vars['row']->value['t_express_company']||$_smarty_tpl->tpl_vars['row']->value['t_express_code'])) {?>
                                    <span>
                                        <?php if ($_smarty_tpl->tpl_vars['row']->value['t_es_id']>0) {?>
                                            <?php echo $_smarty_tpl->tpl_vars['row']->value['es_name'];?>

                                            <?php } else { ?>
                                            <?php echo $_smarty_tpl->tpl_vars['row']->value['os_name'];?>

                                        <?php }?>
                                    </span>
                                    <span style="padding-left: 5px">
                                        <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_company'];?>
   <?php echo $_smarty_tpl->tpl_vars['row']->value['t_express_code'];?>

                                    </span>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group clearfix">
                            <label class="control-label">发货方式：</label>
                            <div class="controls">
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" checked="" value="1" data-id="1" name="no_express"><span style="padding: 1px 5px;">需要物流</span>
                                </label>
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" value="0" data-id="0" name="no_express"><span style="padding: 1px 5px;">无需物流</span>
                                </label>
                                <label class="radio inline">
                                    <input type="radio" data-validate="no" value="2" data-id="2" name="no_express"><span style="padding: 1px 5px;">商家配送</span>
                                </label>
                            </div>
                        </div>
                        <div class="control-group row" id="wuliu-info">
                            <div class="col-xs-6">
                                <label class="control-label">物流公司：</label>
                                <div class="controls">
                                    <select id="express_id" name="express_id" class="form-control chosen-select" data-placeholder="请选择一个物流公司">
                                        <option value="0"></option>
                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['express']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                        <?php } ?>
                                    </select>
                                    <p class="tip hide">*发货后，10分钟内可修改一次物流信息</p>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">快递单号：</label>
                                <div class="controls">
                                    <input type="text" id="express_code" name="express_code" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['expressNote']->value==1) {?>
                        <div class="control-group row" id="shop-express-note" style="display: none;">
                            <div class="col-xs-10">
                                <label class="control-label">备注：</label>
                                <div class="controls">
                                    <textarea id="express_note" name="express_note" cols="30" rows="5" class="form-control" ></textarea>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <div class="control-group row" id="shop-sned-info" style="display: none;">
                            <div class="col-xs-6">
                                <label class="control-label">配送员名称：</label>
                                <div class="controls">
                                    <input type="text" id="delivery_name" name="delivery_name" class="form-control" />
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <label class="control-label">配送员电话：</label>
                                <div class="controls">
                                    <input type="text" id="delivery_mobile" name="delivery_mobile" class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                <button type="button" class="btn btn-primary modal-save" onclick="expressTrade()" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myPrintModal" tabindex="-1" role="dialog" aria-labelledby="myPrintLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myPrintLabel">
                    选择打印机
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">选择打印机</label>
                    <div class="col-sm-7">
                        <select id="printSn" name="printSn" class="form-control" data-placeholder="请选择一个打印机">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['printlist']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['afl_sn'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['afl_name'];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-print">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../bs-alert-tips.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script type="text/javascript" src="/public/plugin/lodop/LodopFuncs.js"></script>
<script>
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_s_id']==5655) {?>
        function printLodop(){
            var LODOP=getLodop(document.getElementById('LODOP_OB'),document.getElementById('LODOP_EM'));
            LODOP.PRINT_INIT("打印任务名");               //首先一个初始化语句
            LODOP.ADD_PRINT_TEXT(0,0,100,20,"文本内容一");//然后多个ADD语句及SET语句
            LODOP.PREVIEW();                         //最后一个打印(或预览、维护、设计)语句
        }
    <?php }?>

    var rowJson = '<?php echo $_smarty_tpl->tpl_vars['rowJson']->value;?>
';
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        showTips('复制成功');
    } );

    $(function () {
        /*提示消息*/
        $("[data-toggle='tooltip']").tooltip(); 

        // 下拉搜索框
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true
        });

        /*添加备注信息*/
        $(".state-region").on('click', '.js-remark', function(event) {
            event.preventDefault();
            layer.prompt({
              title: '添加备注信息',
              formType: 2 //prompt风格，支持0-2
            }, function(text){
               layer.msg('备注信息：'+ text);
            });
        });

        // 更新物流信息
        $('#location_reload').on('click',function () {
            window.location.reload();
        })

        $('#confirm-print').on('click',function(){
            var tid   = '<?php echo $_smarty_tpl->tpl_vars['row']->value['t_tid'];?>
';
            var sn   = $('#printSn').val();
            var data = {
                tid  : tid,
                sn   : sn
            };
            if(data){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/printOrder',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        if(ret.ec == 200){
                            layer.msg('订单发送成功，如果打印不成功请查看打印机是否在线');
                            $('#myPrintModal').modal('hide')
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }
        });

        //单个订单退款
        $('.refund-btn').on('click',function(){
            var toid  = $(this).data('toid');
            var status = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
                msg = '该订单已发货确定要退款吗？'
            }
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'toid'  : toid,
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/orderRefund',
                    'data'  : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        });

        // 社区团购的单品退款
        $('.refund-btn-seq').on('click',function(){
            var toid  = $(this).data('toid');
            var status = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
                msg = '该订单已发货确定要退款吗？'
            }
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'toid'  : toid,
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/tradeOrderRefund',
                    'data'  : data,
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }, function() {

            });
        });
    });
    function verifyTradeOrder(ele) {
        layer.confirm('确定核销此商品？', {
            btn: ['确定','取消'], //按钮
            title : '核销'
        }, function(){

            var id = $(ele).data('id');
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/finishSequenceTradeOrder',
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
</script><?php }} ?>
