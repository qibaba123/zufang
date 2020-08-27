<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:35:47
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/order/trade-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16766516215e1be5936e78a8-41323720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a89c90e15d1d6e10db661cda7318cbbbcf9c4e59' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/sites/app/view/template/wxapp/order/trade-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16766516215e1be5936e78a8-41323720',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'todayTradeInfo' => 0,
    'searchTradeInfo' => 0,
    'tid' => 0,
    'code' => 0,
    'title' => 0,
    'buyer' => 0,
    'name' => 0,
    'phone' => 0,
    'expressMethod' => 0,
    'key' => 0,
    'postType' => 0,
    'val' => 0,
    'trade_screen' => 0,
    'tradeScreen' => 0,
    'storeSelect' => 0,
    'osId' => 0,
    'appletCfg' => 0,
    'esId' => 0,
    'selectShop' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'link' => 0,
    'list' => 0,
    'tradePay' => 0,
    'trader' => 0,
    'statusNote' => 0,
    'mal' => 0,
    'print' => 0,
    'pkey' => 0,
    'pal' => 0,
    'v' => 0,
    'page_html' => 0,
    'express' => 0,
    'expressNote' => 0,
    'independent' => 0,
    'md_list' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be5938fb518_88942213',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be5938fb518_88942213')) {function content_5e1be5938fb518_88942213($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style>
	.datepicker{
		z-index: 1060 !important;
	}
	.ui-table-order .time-cell{
		width: 120px !important;
	}
	.form-group{
		margin-bottom: 10px !important;
	}
	.search-box{
		margin: 20px auto 20px;
	}
	.input-group .select2-choice{
		height: 34px;
		line-height: 34px;
		border-radius: 0 4px 4px 0 !important;
	}
	.input-group .select2-container{
		border: none !important;
		padding: 0 !important;
	}
	.zdy-md-xz{
		display: none;
	}
</style>
<div class="alert alert-block alert-yellow ">
    <button type="button" class="close" data-dismiss="alert">
    <i class="icon-remove"></i>
    </button>
    结算时间：确认收货后，立即结算。未确认收货，7天自动确认收货结算。
</div>
<!-- 订单汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
	<div class="balance-info">
		<div class="balance-title">今日收益<span></span></div>
		<div class="balance-content">
			<span class="money"><?php if ($_smarty_tpl->tpl_vars['todayTradeInfo']->value['money']||$_smarty_tpl->tpl_vars['todayTradeInfo']->value['coinMoney']) {?><?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value['money']+$_smarty_tpl->tpl_vars['todayTradeInfo']->value['coinMoney'];?>
<?php } else { ?>0<?php }?></span>
			<span class="unit">元</span>
			<!--<a href="/manage/shop/inout" class="pull-right">收支明细</a>-->
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">今日订单数<span></span></div>
		<div class="balance-content">
			<span class="money"><?php if ($_smarty_tpl->tpl_vars['todayTradeInfo']->value) {?><?php echo $_smarty_tpl->tpl_vars['todayTradeInfo']->value['total'];?>
<?php } else { ?>0<?php }?></span>
			<!--<span class="unit">元</span>
            <a href="/manage/shop/settled" class="pull-right">待结算记录</a>-->
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">店铺收益

		</div>
		<div class="balance-content">
			<span class="money money-font"><?php if ($_smarty_tpl->tpl_vars['searchTradeInfo']->value['money']||$_smarty_tpl->tpl_vars['searchTradeInfo']->value['coinMoney']) {?><?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value['money']+$_smarty_tpl->tpl_vars['searchTradeInfo']->value['coinMoney'];?>
<?php } else { ?>0<?php }?></span>
			<span class="unit">元</span>
			<!--<a href="/manage/shop/inout" class="pull-right" style="margin-left: 6px;"> 明细 </a>
            <!--<a href="/manage/withdraw/apply" class="ui-btn ui-btn-primary pull-right btn-margin-right js-goto-btn">提现</a>-->
		</div>
	</div>
	<div class="balance-info">
		<div class="balance-title">店铺订单数</div>
		<div class="balance-content">
			<span class="money money-font"><?php if ($_smarty_tpl->tpl_vars['searchTradeInfo']->value) {?><?php echo $_smarty_tpl->tpl_vars['searchTradeInfo']->value['total'];?>
<?php } else { ?>0<?php }?></span>
			<!--<span class="unit">币</span>
            <!-- 充值按钮 -->
			<!--<a href="/manage/account/balance" class="pull-right" style="margin-left: 6px;"> 明细 </a>
            <a href="#" class="ui-btn ui-btn-primary pull-right js-recharge-money">充值</a>
            <div class="ui-popover ui-popover-input top-center charge-input">
                <div class="ui-popover-inner">
                    <input type="text" class="form-control money-input" id="money-input" autofocus="autofocus" placeholder="请输入充值金额" style="width:160px;display:inline-block;height:30px;vertical-align:top">
                    <a class="ui-btn ui-btn-primary js-save" href="javascript:;" onclick="confirmCharge(this)">确定</a>
                    <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide()">取消</a>
                </div>
                <div class="arrow"></div>
            </div>-->
		</div>
	</div>
</div>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/order/tradeList" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container" style="width: auto !important;">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">订单编号</div>
							<input type="text" class="form-control" name="tid" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
"  placeholder="订单编号">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">核销码</div>
							<input type="text" class="form-control" name="code" value="<?php echo $_smarty_tpl->tpl_vars['code']->value;?>
"  placeholder="核销码">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group ">
							<div class="input-group-addon">商品名称</div>
							<input type="text" class="form-control" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
"  placeholder="商品名称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">买家</div>
							<input type="text" class="form-control" name="buyer" value="<?php echo $_smarty_tpl->tpl_vars['buyer']->value;?>
"  placeholder="购买人微信昵称">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人</div>
							<input type="text" class="form-control" name="harvest" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
"  placeholder="收货人姓名">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">收货人电话</div>
							<input type="text" class="form-control" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
"  placeholder="收货人电话">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">配送方式</div>
							<select name="postType" id="" class="form-control" style="height: 34px;">
								<option value="0">全部</option>
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['expressMethod']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['postType']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">筛选</div>
							<select name="tradeScreen" id="" class="form-control" style="height: 34px;">
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trade_screen']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['tradeScreen']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">自提门店</div>
							<select  class="form-control" name="osId">
								<option value="0">全部</option>
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['storeSelect']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['key']->value==$_smarty_tpl->tpl_vars['osId']->value) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4) {?>style="display:none"<?php }?>>
						<div class="input-group">
							<div class="input-group-addon" style="height:34px;">所属商家</div>
							<select id="esId" name="esId" style="height:34px;width:100%" class="form-control my-select2">
								<option value="0">全部</option>
								<option value="-1" <?php if ($_smarty_tpl->tpl_vars['esId']->value==-1) {?>selected<?php }?>>平台自营</option>
								<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['selectShop']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
							<option <?php if ($_smarty_tpl->tpl_vars['esId']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="form-group" style="width: 400px">
						<div class="input-group">
							<div class="input-group-addon" >下单时间</div>
							<input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
                            <span class="input-group-addon">
                                <i class="icon-calendar bigger-110"></i>
                            </span>
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})" autocomplete="off">
							<span class="input-group-addon">
                            	<i class="icon-calendar bigger-110"></i>
                            </span>
						</div>
					</div>
					<input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 35%;right: 2%;">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>
<div style="margin-bottom: 20px">
	<a href="/wxapp/print" class="btn btn-green btn-sm"><i class="icon-print"></i>打印模版设置</a>
	<a href="#" class="btn btn-green btn-sm" data-click-upload ><i class="icon-cloud-upload"></i>批量发货</a>
	<a href="javascript:;" class="btn btn-green btn-sm btn-excel" ><i class="icon-download"></i>订单导出</a>
</div>


<div class="choose-state">
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['link']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<a href="/wxapp/order/tradeList?status=<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value&&$_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['key']->value) {?>class="active"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
	<?php } ?>
	<!---
            <button class="pull-right btn btn-danger btn-xs" style="margin-top: 5px;margin-right: 10px;"><i class="icon-remove"></i> 删除所选<span id="choose-num">(12)</span></button>
    -->
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th class="" colspan="2" style="min-width: 212px; max-width: 212px;">商品</th>
				<th class="" style="min-width: 212px; max-width: 212px;">规格</th>
		        <th class="price-cell" style="min-width: 87px; max-width: 87px;">总价/数量</th>
		        <th class="aftermarket-cell" style="min-width: 85px; max-width: 85px;">维权</th>
		        <th class="customer-cell" style="min-width: 110px; max-width: 110px;">买家</th>
		        <th class="time-cell" style="min-width: 80px; max-width: 80px;">
		            <a href="javascript:;" data-orderby="book_time">下单时间<span class="orderby-arrow desc">↓</span></a>
		        </th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">订单状态</th>
		        <th class="pay-price-cell" style="min-width: 120px; max-width: 120px;">实付金额</th>
		    </tr>
		</thead>

		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<tbody class="widget-list-item">
		<tr class="separation-row">
			<td colspan="8"></td>
		</tr>
		<tr class="header-row">
			<td colspan="7">
				<div>
					订单号: <?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>

					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><?php echo $_smarty_tpl->tpl_vars['tradePay']->value[$_smarty_tpl->tpl_vars['val']->value['t_pay_type']];?>
</span>
						<?php if ($_smarty_tpl->tpl_vars['val']->value['t_applet_type']==1) {?>
						<span class="tuan-tag">秒</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_applet_type']==2) {?>
						<span class="tuan-tag">团</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_applet_type']==3) {?>
						<span class="tuan-tag">奖</span>
						<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_applet_type']==5) {?>
						<span class="tuan-tag">砍</span>
						<?php }?>
						<div class="js-notes-cont hide">
							该订单通过您公众号自有的微信支付权限完成交易，货款已进入您微信支付对应的财付通账号
						</div>
						<span style="padding-left: 20px;">
								<?php if ($_smarty_tpl->tpl_vars['val']->value['t_es_id']) {?>
								<?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>

								<?php } else { ?>
								平台自营
								<?php }?>
							</span>
						<span style="padding-left: 20px;">
								<?php if ($_smarty_tpl->tpl_vars['val']->value['legworkNum']) {?>
							配送顺序号：<?php echo $_smarty_tpl->tpl_vars['val']->value['legworkNum'];?>

								<?php }?>
							</span>
						<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==3&&$_smarty_tpl->tpl_vars['val']->value['t_remind_time']>0) {?>
						<span style="color: red;padding-left: 20px;">
							<?php echo date("m-d H:i",$_smarty_tpl->tpl_vars['val']->value['t_remind_time']);?>
提醒发货
						</span>
						<?php }?>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/order/tradeDetail?order_no=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="new-window" >查看详情</a> -
						<?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=4) {?>
						<a href="javascript:;" data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="js-deduct">查看分佣</a>
						<?php }?>
						<a href="#" class="js-remark hide">备注</a>
					</div>
				</div>
			</td>
		</tr>
		<tr class="content-row">
			<td class="image-cell">
				<img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_pic'];?>
">
			</td>
			<td class="title-cell">
				<p class="goods-title">
					<a href="/wxapp/order/tradeList?title=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
"class="new-window" title="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>

					</a>
				</p>
				<p>
				</p>
			</td>
			<td class="format-cell">
				<?php echo $_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']]['data'][0]['to_gf_name'];?>

			</td>
			<td class="price-cell">
				<p>
					<?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>

				</p>
				<p>(<?php echo $_smarty_tpl->tpl_vars['val']->value['t_num'];?>
件)</p>
			</td>
			<td class="aftermarket-cell" rowspan="1">
				<?php if (in_array($_smarty_tpl->tpl_vars['val']->value['t_feedback'],array(1,2))) {?>
				<a href="/wxapp/order/tradeRefund?order_no=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="new-window" >处理维权</a>
				<?php }?>
			</td>
			<td class="customer-cell" rowspan="1">
				<p>
					<a href="/wxapp/order/tradeList?buyer=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>
" class="new-window" target="_blank">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>

					</a>
				</p>
				<?php if ($_smarty_tpl->tpl_vars['val']->value['t_express_method']==2) {?>
				<p class="user-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_company'];?>
</p>
				<?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_code'];?>

				<?php } else { ?>
				<p class="user-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['ma_name'];?>
</p>
				<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_phone'];?>

				<?php }?>

			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['t_create_time']);?>

				</div>
				<div class="td-cont">
					<p class="user-name" style="color:green;margin-top: 10px">[<?php echo $_smarty_tpl->tpl_vars['tradePay']->value[$_smarty_tpl->tpl_vars['val']->value['t_pay_type']];?>
]</p>
				</div>
				<div class="td-cont">
					<p class="user-name" style="margin-top: 10px">
						<a href="/wxapp/order/tradeList?postType=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_method'];?>
" class="new-window" target="_blank">
						<?php echo $_smarty_tpl->tpl_vars['expressMethod']->value[$_smarty_tpl->tpl_vars['val']->value['t_express_method']];?>

						</a>
					</p>
				</div>
				<?php if ($_smarty_tpl->tpl_vars['val']->value['t_express_method']==5&&$_smarty_tpl->tpl_vars['val']->value['t_status']==3) {?>
				<!--<p class="user-name">
						<span id="order_finish_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_id'];?>
" class="btn btn-primary btn-xs push_ele_order"
							  data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_id'];?>
"
						>蜂鸟配送推单</span>
				</p>-->
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['val']->value['t_store_id']) {?>
				<div class="td-cont">
					<p class="user-name" style=";margin-top: 10px">
						<?php echo $_smarty_tpl->tpl_vars['storeSelect']->value[$_smarty_tpl->tpl_vars['val']->value['t_store_id']]['os_name'];?>

					</p>
				</div>
				<?php }?>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<p class="js-order-state" id="status_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
">
						<?php if ($_smarty_tpl->tpl_vars['val']->value['t_pay_type']==4&&$_smarty_tpl->tpl_vars['val']->value['t_status']==3&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
						已下单
						<?php } else { ?>
						<?php echo $_smarty_tpl->tpl_vars['statusNote']->value[$_smarty_tpl->tpl_vars['val']->value['t_status']];?>

						<?php }?>

					</p>

					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==8&&$_smarty_tpl->tpl_vars['val']->value['t_fd_result']==1) {?>
					<p><span style="color: red;">［拒绝］</span></p>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_status']==8&&$_smarty_tpl->tpl_vars['val']->value['t_fd_result']==2) {?>
					<p><span style="color: green;">［同意］</span></p>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_refund_time']&&$_smarty_tpl->tpl_vars['val']->value['t_status']==8) {?>
						<p><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['t_refund_time']);?>
</p>
					<?php }?>

					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==6) {?>
					<!-- 订单完成 -->
					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_finish_type']==0&&$_smarty_tpl->tpl_vars['val']->value['t_manager_name']) {?>
					<p>
						<span>由<span style="color: blue"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_manager_name'];?>
</span>操作</span>
					</p>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_finish_type']==1&&$_smarty_tpl->tpl_vars['val']->value['t_manager_name']) {?>
					<p>
						<span>由店铺<span style="color: blue"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_manager_name'];?>
</span>操作</span>
					</p>
					<?php } elseif ($_smarty_tpl->tpl_vars['val']->value['t_finish_type']==2) {?>
					<p>
						<span>自动完成</span>
					</p>
					<?php }?>

					<?php } else { ?>
					<!-- 非订单完成 -->
					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_manager_name']) {?>
					<p>
						<span>由<span style="color: blue"><?php echo $_smarty_tpl->tpl_vars['val']->value['t_manager_name'];?>
</span>操作</span>
					</p>
					<?php }?>

					<?php }?>


					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==4&&$_smarty_tpl->tpl_vars['val']->value['t_express_time']&&$_smarty_tpl->tpl_vars['val']->value['t_express_time']<(time()-608400)) {?>
					<span class="btn btn-success btn-xs express-synchron" data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_id'];?>
">信息同步</span>
					<?php }?>
					<!--
					<?php if ($_smarty_tpl->tpl_vars['val']->value['go_status']==0&&$_smarty_tpl->tpl_vars['val']->value['go_create_time']<(time()-86400)&&$_smarty_tpl->tpl_vars['val']->value['go_id']>0&&$_smarty_tpl->tpl_vars['val']->value['t_type']>0) {?>
					<span class="btn btn-info btn-xs group-synchron" data-goid="<?php echo $_smarty_tpl->tpl_vars['val']->value['go_id'];?>
">拼团信息同步</span>
					<?php }?>
					-->
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>

						<br>

						<p class="user-name">
							<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==3&&($_smarty_tpl->tpl_vars['val']->value['t_express_method']==1||$_smarty_tpl->tpl_vars['val']->value['t_express_method']==3)) {?>
							<span id="express_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="btn btn-primary btn-xs express-btn"
								  data-receivename="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_company'];?>
"
								  data-receivephone="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_code'];?>
"
								  data-expressmethod="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_express_method'];?>
"
								  data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"
								  data-feedback="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_feedback'];?>
"
								  data-province="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_province'];?>
"
								  data-city="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_city'];?>
"
								  data-area="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_zone'];?>
"
								  data-address="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_detail'];?>
"
								  data-phone="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_phone'];?>
"
								  data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_name'];?>
"
								  data-tra-num="<?php if (isset($_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']])) {?><?php echo $_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']]['count'];?>
<?php } else { ?>0<?php }?>"
							<?php if (isset($_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']])) {?>
							<?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']]['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mal']->key;
?>
							data-title_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_title'];?>
"
							data-price_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_price'];?>
"
							data-num_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_num'];?>
"
							data-total_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_total'];?>
"
							<?php } ?>
							<?php }?>>发货</span>
							<?php }?>

							<?php if (($_smarty_tpl->tpl_vars['val']->value['t_status']==2||$_smarty_tpl->tpl_vars['val']->value['t_status']==3||$_smarty_tpl->tpl_vars['val']->value['t_status']==4)&&$_smarty_tpl->tpl_vars['val']->value['t_fd_status']!=3) {?>
						<span id="refund_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="btn btn-primary btn-xs refund-btn-modal" data-toggle="modal" data-target="#refundNewModal"
							  data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"
							  data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_type'];?>
"
							  data-payment="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_payment'];?>
"
							  data-coin-payment="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_coin_payment'];?>
"
							  data-applet-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_applet_type'];?>
"
							  data-feedback="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_feedback'];?>
"
							  data-province="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_province'];?>
"
							  data-city="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_city'];?>
"
							  data-area="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_zone'];?>
"
							  data-address="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_detail'];?>
"
							  data-phone="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_phone'];?>
"
							  data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['ma_name'];?>
"
							  data-status="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_status'];?>
"
							  data-tra-num="<?php if (isset($_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']])) {?><?php echo $_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']]['count'];?>
<?php } else { ?>0<?php }?>"
							<?php if (isset($_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']])) {?>
							<?php  $_smarty_tpl->tpl_vars['mal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['mal']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['trader']->value[$_smarty_tpl->tpl_vars['val']->value['t_id']]['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['mal']->key => $_smarty_tpl->tpl_vars['mal']->value) {
$_smarty_tpl->tpl_vars['mal']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['mal']->key;
?>
							data-title_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_title'];?>
"
							data-price_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_price'];?>
"
							data-num_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_num'];?>
"
							data-total_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['mal']->value['to_total'];?>
"
							<?php } ?>
							<?php }?>>退款</span>
							<?php }?>

							<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==1) {?>
							<span class="btn btn-primary btn-xs edit-price-btn"
								  data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
">修改订单价格</span>
							<?php }?>

						</p>
						<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==3||$_smarty_tpl->tpl_vars['val']->value['t_status']==4||($_smarty_tpl->tpl_vars['val']->value['t_status']==5&&$_smarty_tpl->tpl_vars['val']->value['t_legwork_extra'])) {?>
						<p class="user-name">
						<span id="order_finish_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="btn btn-primary btn-xs order_finish"
							  data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"
						>订单完成</span>
						</p>
						<?php }?>

					</div>
					<?php  $_smarty_tpl->tpl_vars['pal'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pal']->_loop = false;
 $_smarty_tpl->tpl_vars['pkey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['print']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pal']->key => $_smarty_tpl->tpl_vars['pal']->value) {
$_smarty_tpl->tpl_vars['pal']->_loop = true;
 $_smarty_tpl->tpl_vars['pkey']->value = $_smarty_tpl->tpl_vars['pal']->key;
?>
					<p class="user-name">
					<a href="javascript:;" class="btn btn-info btn-xs previewCon" data-type="<?php echo $_smarty_tpl->tpl_vars['pkey']->value;?>
" data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"><i class="icon-print"></i><?php echo $_smarty_tpl->tpl_vars['pal']->value['label'];?>
</a>
					</p>
					<?php } ?>
				</div>
			</td>
		</tr>
		<?php if ($_smarty_tpl->tpl_vars['val']->value['t_note']) {?>
		<tr class="remark-row buyer-msg">
			<td colspan="8">买家备注： <?php echo $_smarty_tpl->tpl_vars['val']->value['t_note'];?>
</td>
			<td colspan="1" style="text-align:center;">
				<a href="javascript:;" data-note='<?php echo $_smarty_tpl->tpl_vars['val']->value['t_note'];?>
' data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="edit-trade-note">编辑</a>
			</td>
		</tr>
		<?php }?>

		<?php if ($_smarty_tpl->tpl_vars['val']->value['t_remark_extra']) {?>
		<tr class="remark-row buyer-msg"
		<?php if (count($_smarty_tpl->tpl_vars['val']->value['t_remark_extra'])==1&&$_smarty_tpl->tpl_vars['val']->value['t_remark_extra'][0]['name']=='备注'&&!$_smarty_tpl->tpl_vars['val']->value['t_remark_extra'][0]['value']) {?>
		style="display:none"
		<?php }?>
		>
			<td colspan="8">
			<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['t_remark_extra']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value) {
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
			<?php if ($_smarty_tpl->tpl_vars['v']->value['value']) {?>
			<?php if ($_smarty_tpl->tpl_vars['v']->value['type']=='checkbox') {?>
				<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
:
				<?php echo implode(",",$_smarty_tpl->tpl_vars['v']->value['value']);?>
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } elseif ($_smarty_tpl->tpl_vars['v']->value['type']!='image') {?>
				<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
：<?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
&nbsp;&nbsp;&nbsp;&nbsp;
			<?php } else { ?>
			<?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
：<img src="<?php echo $_smarty_tpl->tpl_vars['v']->value['value'];?>
" alt="" width="50px">&nbsp;&nbsp;&nbsp;&nbsp;
			<?php }?>
			<?php }?>
			<?php } ?>
			</td>
		    <td style="text-align: center">
				<a href="javascript:;" data-remark='<?php echo json_encode($_smarty_tpl->tpl_vars['val']->value['t_remark_extra']);?>
' data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="edit-trade-remark">编辑</a>
			</td>
		</tr>
		<?php }?>
		<?php if (!$_smarty_tpl->tpl_vars['val']->value['t_note']&&(count($_smarty_tpl->tpl_vars['val']->value['t_remark_extra'])==1&&$_smarty_tpl->tpl_vars['val']->value['t_remark_extra'][0]['name']=='备注'&&!$_smarty_tpl->tpl_vars['val']->value['t_remark_extra'][0]['value'])) {?>
			<tr class="remark-row" colspan="9">
				<td colspan="9" style="text-align:right;padding-right: 50px;!important">
					<a href="javascript:;" data-note='<?php echo $_smarty_tpl->tpl_vars['val']->value['t_note'];?>
' data-tid="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="edit-trade-note">编辑</a>
				</td>
			</tr>
		<?php }?>
		</tbody>
		<?php } ?>

		<tbody class="widget-list-item">
		    <tr class="separation-row">
		        <td colspan="8"><?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>
 </td>
		    </tr>
		</tbody>

	</table>
	<div id="refund-form"  class="modal fade">
		<div class="modal-dialog" style="width:760px;">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="modelTitle">退款处理</h4>
				</div>
				<div class="modal-body">
					<div class="row hid-row" id="show-deduct">
						<table class="ui-table" style="margin-bottom:20px;">
							<thead>
							<tr>
								<th></th>
								<th>总价</th>
								<th>购买人</th>
								<th>购买人返现</th>
								<th>上级</th>
								<th>上级返现</th>
								<th>上二级</th>
								<th>上二级返现</th>
								<th>上三级</th>
								<th>上三级返现</th>
								<th>返现状态</th>
							</tr>
							</thead>
							<tbody id="deduct-tr">

							</tbody>
						</table>
					</div>
					<form class="form-inline form-horizontal">
						<input type="hidden" id="hid_id" value="0">
						<input type="hidden" id="modal-type" value="refund">
						<input type="hidden" id="cate" value="list">
						<div class="row hid-row" id="show-refund">
							<div class="checkbox col-sm-12 mod-div">
								<label>审核状态 ： &nbsp;&nbsp;</label>
								<label>
									<input type="radio" name="status" checked value="2"> &nbsp; 通 &nbsp; 过 &nbsp;
								</label>
								<label>
									<input type="radio" name="status" value="1">  &nbsp; 拒 &nbsp; 绝 &nbsp;
								</label>
							</div>
						</div>
						<div class="row hid-row" id="show-express" style="margin:0">
							<!--发货HTML-->
							<table class="ui-table" style="margin-bottom:20px;">
							    <thead>
							        <tr>
							            <th class="cell-35">商品</th>
										<th class="cell-5">数量</th>
										<th class="cell-5">单价</th>
										<th class="cell-5">总价</th>
							        </tr>
							    </thead>
							    <tbody id="buy-goods-modal">

							    </tbody>
							</table>
							<div class="control-group">
							    <label class="control-label">收货信息：</label>
							    <div class="controls">
							        <div class="control-action" id="modal-address">

							        </div>
							    </div>
							</div>
							<div class="control-group">
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
					<button type="button" class="btn btn-primary modal-save" onclick="saveModal()" >保存</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--维权结果处理-->
	<div class="modal fade" id="agreeTK" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close"
							data-dismiss="modal" aria-hidden="true">
						&times;
					</button>
					<h4 class="modal-title" id="agreeTKLabel">
						维权处理
					</h4>
				</div>
				<div class="modal-body">
					<div class="alert">
						订单中的部分商品，买家已提交了退款申请。你需要先跟买家协商，买家撤销退款申请后，才能进行发货操作。
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="ui-btn ui-btn-primary btn-refund" data-dismiss="modal">
						我知道了
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- 批量发货导入文件弹框 -->
<div id="bulk_shipment" style="display: none;padding:5px 20px;">
	<div class="upload-tips">
		<form action="/wxapp/order/deliver" enctype="multipart/form-data" method="post">
			<label style="height:35px;line-height: 35px;">本地上传</label>
			<span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="order_deliver" type="file"></span>
			<!-- <p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传csv类型的文件</p> -->
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传xls类型的文件</p>

			<div style="font-size: 14px;margin-top: 10px;" >注意　<span id="show-notice">最大支持 1 MB xls的文件。</span></div>
			<div style="font-size: 14px;margin-top: 10px;" ><a href="/public/common/批量发货样本.xls" id="show-notice">下载批量发货模板</a></div>
		</form>
	</div>
</div>
<style>
	.layui-layer-btn{
		border-top: 1px solid #eee;
	}
	.upload-tips{
		/* overflow: hidden; */
	}
	.upload-tips label{
		display: inline-block;
		width: 70px;
	}
	.upload-tips p{
		display: inline-block;
		font-size: 13px;
		margin:0;
		color: #666;
		margin-left: 10px;
	}
	.upload-tips .upload-input{
		display: inline-block;
		text-align: center;
		height: 35px;
		line-height: 35px;
		background-color: #1276D8;
		color: #fff;
		width: 90px;
		position: relative;
		cursor: pointer;
	}
	.upload-tips .upload-input>input{
		display: block;
		height: 35px;
		width: 90px;
		opacity: 0;
		margin: 0;
		position: absolute;
		top: 0;
		left: 0;
		z-index: 2;
		cursor: pointer;
	}
</style>
<!-- 订单导出操作 -->
<style>
	/*大图弹框*/
	.modal{
		position: fixed;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background-color: rgba(0,0,0,.5);
		display: none;
	}
	.modal-img{
		position:absolute;
		max-width:90%;
		max-height:90%;
		left:5%;
		top:50%;
		z-index:3;
		transform:translateY(-50%);
		-webkit-transform:translateY(-50%);
	}
	.modal-img .image{
		width:100%;
		height:100%;
	}
	.modal-img img{
		width:100%;
		max-height:100%;
	}
	.space{
		margin: 12px 0;
		width: 100%;
	}
</style>
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 700px;">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="excelOrderLabel">
					导出订单
				</h4>
			</div>
			<div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
				<div class="modal-plan p_num clearfix shouhuo">
					<form id='trade-export-form' enctype="multipart/form-data" action="/wxapp/order/excelOrderNew" method="post" onsubmit="return false">
						<input type="hidden" name="independent" value="<?php echo $_smarty_tpl->tpl_vars['independent']->value;?>
">
						<div class="form-group">
							<label class="col-sm-2 control-label">订单类型</label>
							<div class="col-sm-4">
								<select id="orderStatus" name="orderStatus" class="form-control">
									<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['link']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="addressOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="address-order" style="position: relative;top: 2px">根据地址排序</label>
							</div>

						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">配送方式</label>
							<div class="col-sm-4">
								<select id="postType" name="postType" class="form-control" >
									<option value="0">全部</option>
									<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['expressMethod']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="mergeOrder" checked style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">同订单合并</label>
							</div>
							<div class="col-sm-3" style="text-align: left">
								<input type="checkbox" name="goodsOrder" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="goods-order" style="position: relative;top: 2px">根据商品排序</label>
							</div>
						</div>
						<div class="space zdy-md-xz"></div>
						<div class="form-group  zdy-md-xz">
							<label class="col-sm-2 control-label">所属门店</label>
							<div class="col-sm-4">
								<select id="ssMd" name="ssMd" class="form-control">
									<option value="0">全部</option>
									<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['md_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['os_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>
</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-sm-4">
								<input type="checkbox" name="storeOrder" style="display: inline-block;width: 25px;position: relative;top: 3px;font-size: 20px;">
								<label for="store-order" style="position: relative;top: 2px">根据门店排序</label>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">商品名称</label>
							<div class="col-sm-10">
								<input class="form-control" type="text" id="goodstitle" name="goodstitle" placeholder="请输入商品名称,不填默认全部商品"/>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">开始日期</label>
							<div class="col-sm-4">
								<input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期" autocomplete="off" />
							</div>
							<label class="col-sm-2 control-label">开始时间</label>
							<div class="col-sm-4 bootstrap-timepicker">
								<input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
							</div>
						</div>
						<div class="space"></div>
						<div class="form-group">
							<label class="col-sm-2 control-label">结束日期</label>
							<div class="col-sm-4">
								<input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期" autocomplete="off" />
							</div>
							<label class="col-sm-2 control-label">结束时间</label>
							<div class="col-sm-4 bootstrap-timepicker">
								<input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
							</div>
						</div>
						<div class="space" style="margin-bottom: 70px;"></div>
						<button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
						<button id='trade-export' type="submit" class="btn btn-primary" role="button">导出</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="refundNewModal" tabindex="-1" role="dialog" aria-labelledby="refundNewModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="overflow: auto; width: 500px">
		<div class="modal-content">
			<input type="hidden" id="hid_refund_tid">
			<input type="hidden" id="hid_refund_status">
			<input type="hidden" id="hid_refund_type">
			<input type="hidden" id="hid_refund_applettype">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					退款
				</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">退款金额：</label>
					<div class="col-sm-8">
						<input id="curr_refund" class="form-control" placeholder="请填写退款金额" style="height:auto!important"/>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消
				</button>
				<button type="button" class="btn btn-primary" id="refund-btn-new">
					确认
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

<div class="modal fade" id="editRemarkModal" tabindex="-1" role="dialog" aria-labelledby="editRemarkModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="overflow: auto; width: 500px">
		<div class="modal-content">
			<input type="hidden" id="hid_refund_applettype">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="editRemarkModalLabel">
					编辑备注
				</h4>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消
				</button>
				<button type="button" class="btn btn-primary" id="edit-remark-confirm">
					确认
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

<div class="modal fade" id="editNoteModal" tabindex="-1" role="dialog" aria-labelledby="editNoteModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="overflow: auto; width: 500px">
		<div class="modal-content">
			<input type="hidden" id="hid_note_tid">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					编辑备注
				</h4>
			</div>
			<div class="modal-body">
				<div class="form-group row">
					<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注信息：</label>
					<div class="col-sm-8">
						<textarea id="order-note" class="form-control" placeholder="请填写备注信息" style="height: 120px;"></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">取消
				</button>
				<button type="button" class="btn btn-primary" id="edit-note-confirm">
					确认
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/order.js"></script>
<script src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
	$(function(){
		// 订单导出
		// zhangzc
		// 2019-11-11
	    $('#trade-export').click(function(){
	    	var index = layer.load(10, {
                shade: [0.6,'#666']
            });
	    	$.ajax({
	    		type:'POST',
	    		url:'/wxapp/order/excelOrderNew',
	    		dataType:'json',
	    		data:$('#trade-export-form').serialize(),
	    		success:function(res){
	    			if(res.ec==200){
	    				// window.open('http://'+location.hostname+res.data.url);
	    				window.location.href=res.data.url;
	    			}else{
	    				layer.msg(res.em);
	    			}
	    			layer.close(index);
	    		},
	    		error:function(){
					layer.msg('数据导出失败，请稍后再试或减少单次的导出量！');
	    		},
	    		complete:function(){
	    			layer.close(index);
	    		}
	    	})
	    });


		/*初始化日期选择器*/
		$('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});

		$("input[id^='timepicker']").timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});


		//门店自取显示门店列表下拉框
		var postType = $('#postType').val();
		if(postType == 2){
			$('.zdy-md-xz').show();
		}else{
			$('#ssMd').val(0);
			$('.zdy-md-xz').hide();
		}
		$('#postType').on('change',function(){
			var postType = $(this).val();
			if(postType == 2){
				$('.zdy-md-xz').show();
			}else{
				$('#ssMd').val(0);
				$('.zdy-md-xz').hide();
			}
		});

		// 下拉搜索框
		$(".chosen-select").chosen({
			no_results_text: "没有找到",
			search_contains: true
		});
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });

		/*添加备注信息*/
		$(".ui-table-order").on('click', '.js-opts .js-remark', function(event) {
			event.preventDefault();
			layer.prompt({
			  title: '添加备注信息',
			  formType: 2 //prompt风格，支持0-2
			}, function(text){
			   layer.msg('备注信息：'+ text);
			});
		});
		$('.js-deduct').on('click',function(){
			var tid = $(this).data('tid');
			if(tid){

				var data = {
					'tid' : tid
				};
				showDeduct(data);
			}
		});

        //单个订单退款
        $('.refund-btn').on('click',function(){
            var status  = $(this).data('status');
            var msg = '你确定要给该订单退款吗？';
            if(status==4){
				msg = '该订单已发货确定要退款吗？'
			}
            var tid  = $(this).data('tid');
            var type = $(this).data('type');
            var appletType = $(this).data('applet-type');
            layer.confirm(msg, {
                title: '提示',
                btn: ['确定','取消']    //按钮
            }, function(){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                var data = {
                    'tid'	: tid,
                    'status': 2,
                    'group' : type == 1 || (type== 5 && appletType == 2) ? 1 : 0
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/activeRefund',
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

        $('.refund-btn-modal').on('click',function () {
        	//先清空
			$('#hid_refund_status').val('');
			$('#hid_refund_tid').val('');
			$('#hid_refund_type').val('');
			$('#hid_refund_applettype').val('');
			$('#curr_refund').val('');

			$('#hid_refund_status').val($(this).data('status'));
			$('#hid_refund_tid').val($(this).data('tid'));
			$('#hid_refund_type').val($(this).data('type'));
			$('#hid_refund_applettype').val($(this).data('applet-type'));
			var coin_payment = $(this).data('coin-payment');
			var payment = $(this).data('payment');
			var total = parseFloat(payment) + parseFloat(coin_payment);
			$('#curr_refund').val(total);
		});

		//单个订单退款
		$('#refund-btn-new').on('click',function(){
			var status  = $('#hid_refund_status').val();
			var curr_refund = $('#curr_refund').val();
			var msg = '你确定要给该订单退款吗？';
			if(status==4){
				msg = '该订单已发货确定要退款吗？'
			}
			var tid  = $('#hid_refund_tid').val();
			var type = $('#hid_refund_type').val();
			var appletType = $('#hid_refund_applettype').val();
			layer.confirm(msg, {
				title: '提示',
				btn: ['确定','取消']    //按钮
			}, function(){
				var index = layer.load(10, {
					shade: [0.6,'#666']
				});
				var data = {
					'tid'	: tid,
					'status': 2,
					'custom': 1,
					'curr_refund' : curr_refund,
					'group' : type == 1 || (type== 5 && appletType == 2) ? 1 : 0
				};
				$.ajax({
					'type'  : 'post',
					'url'   : '/wxapp/order/activeRefund',
					'data'  : data,
					'dataType'  : 'json',
					'success'   : function(ret){
						console.log(ret);
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

		$('.edit-price-btn').on('click',function(){
			var tid = $(this).data('tid');
			layer.prompt({title: '输入订单价格，并确认', formType: 0}, function(price, index){
				var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
				if (!reg.test(price)){
					layer.msg('请输入正确订单金额');
					return false;
				}
				var index = layer.load(10, {
					shade: [0.6,'#666']
				});
				var data = {
					'tid'	: tid,
					'price': price
				};
				$.ajax({
					'type'  : 'post',
					'url'   : '/wxapp/order/editPrice',
					'data'  : data,
					'dataType'  : 'json',
					'success'   : function(ret){
						layer.close(index);
						if(ret.ec == 200){
							window.location.reload();
						}else{
							layer.msg(ret.em);
						}
					}
				});
			});
		});

		$('.express-btn').on('click',function(){
			var feedback = $(this).data('feedback');
			if(feedback == 1){ //有维权不可发货，除非会员取消维权状态为3
				$('#agreeTK').modal('show');
			}else{
				var tid = $(this).data('tid');
				var province = $(this).data('province');
				var city 	= $(this).data('city');
				var area 	= $(this).data('area');
				var address = $(this).data('address');
				var phone 	= $(this).data('phone');
				var name 	= $(this).data('name');
				var num     = $(this).data('tra-num');
				var receiveName = $(this).data('receivename');
				var receivePhone = $(this).data('receivephone');
				var expressMethod = $(this).data('expressmethod');

				if(expressMethod == 2){
				    phone = receivePhone;
				    name = receiveName;
                }

				if(num > 0){
					var _html = '';
					for(var i=0; i< num ; i++){
						_html += '<tr>';
						_html += '<td><div>'+$(this).data('title_'+i)+'</div></td>';
						_html += '<td>'+$(this).data('num_'+i)+'</td>';
						_html += '<td>'+$(this).data('price_'+i)+'</td>';
						_html += '<td>'+$(this).data('total_'+i)+'</td>';
						_html += '</tr>';
					}
					$('#buy-goods-modal').html(_html);
				}
				if(expressMethod == 2){
                    $('#modal-address').html(name+ ' '+phone);
                }else{
                    $('#modal-address').html(province + ' '+city+ ' '+area+ ' '+address+ '，'+name+ ' '+phone);
                }

				$('#hid_id').val(tid);
				$('#modal-type').val('express');
				$('#modelTitle').text('发货处理');
				hideFormShowById('express');
				$('#refund-form').modal('show');
			}

		});
		// 搜索框滚动
		//var formGroupNum = $(".form-group-box").find('.form-group').length;
		//$(".form-container").width(270*formGroupNum);
	});

	function selectedFile(obj){
		var path = $(obj).val();
		$(obj).parents('form').find('p').text(path);
	}

	$('[data-click-upload]').on('click', function(){
		var htmlTxt=$("#bulk_shipment");
		var that    = this;
		//页面层
		var layIndex = layer.open({
			type: 1,
			title: '文件路径',
			shadeClose: true, //点击遮罩关闭
			shade: 0.6, //遮罩透明度
			skin: 'layui-anim',
			area: ['500px', '200px'], //宽高
			btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
			content: htmlTxt,
			yes : function() {
				var loading = layer.load(2);
				var $form = htmlTxt.find('form');
				var url = $form.attr("action"),
						data = new FormData($form[0]);
				$.ajax(url, {
					type: "post",
					data: data,
					processData: false,
					contentType: false,
					dataType: 'json',
					success: function (data) {
						if (data.ec == 200) {
							layer.msg('批量发货成功');
						}else {
							layer.msg(data.em);
						}
						setTimeout(function(){
							window.location.reload();
						},500);
					},
					complete: function () {
						layer.close(loading);
						layer.close(layIndex);
					}
				});
			}
		});
	});

	/**
	 * 拼团失败手动同步信息
	 */
	$('.group-synchron').on('click',function(){
		var goid = $(this).data('goid');
		var index = layer.load(10, {
			shade: [0.6,'#666']
		});
		var data = {
			'goid'	: goid
		};
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/order/groupSynchron',
			'data'  : data,
			'dataType'  : 'json',
			'success'   : function(ret){
				layer.close(index);
				if(ret.ec == 200){
					window.location.reload();
				}else{
					layer.msg(ret.em);
				}
			}
		});
	});


    /**
     * 自动确认收货失败手动同步信息
     */
    $('.express-synchron').on('click',function(){
        var tid = $(this).data('tid');
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: tid
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/order/expressSynchron',
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
    });

	//订单导出按钮
	$('.btn-excel').on('click',function(){
		$('#excelOrder').modal('show');
	});

	//完成订单
    $('.order_finish').on('click',function(){
        var tid = $(this).data('tid');
        if(confirm('确认已完成订单？')){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/finishOrder',
                'data'  : {tid: tid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });

    $('.push_ele_order').on('click',function(){
        var tid = $(this).data('tid');
        if(confirm('确认推单到蜂鸟配送？')){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/pushEleOrder',
                'data'  : {tid: tid},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });

    $('.edit-trade-remark').on('click', function () {
        let remarkExtra = $(this).data('remark');
        let tid = $(this).data('tid');

        let _html = '';
        _html += '<input class="form-control" id="remark-extra-value" type="hidden" value=\''+JSON.stringify(remarkExtra)+'\'/>';
        _html += '<input class="form-control" id="remark-extra-tid" type="hidden" value="'+tid+'"/>';
        for(let index in remarkExtra){
            if(remarkExtra[index]['name']){
                if(remarkExtra[index]['type'] != 'checkbox' && remarkExtra[index]['type'] != 'image'){
                    _html += '<div class="form-group row">';
                    _html += '<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">'+remarkExtra[index]['name']+'：</label>';
                    _html += '<div class="col-sm-8"><input class="form-control edit-input" type="text" data-checkbox="0" value="'+remarkExtra[index]['value']+'" data-index="'+index+'"/>';
                    _html += '</div></div>';
                }
                if(remarkExtra[index]['type'] == 'checkbox' ){
                    _html += '<div class="form-group row">';
                    _html += '<label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">'+remarkExtra[index]['name']+'：</label>';
                    _html += '<div class="col-sm-8"><input class="form-control edit-input" type="text" data-checkbox="1" value="'+remarkExtra[index]['value'].join(",")+'" data-index="'+index+'"/>';
                    _html += '</div></div>';
                }
            }
        }
        $('#editRemarkModal .modal-body').html(_html);
        $('#editRemarkModal').modal('show');
    });

	$('#edit-remark-confirm').on('click', function () {
	    let remarkExtraValue = JSON.parse($("#remark-extra-value").val());
	    let tid = $("#remark-extra-tid").val();

	    let inputArr = $('#editRemarkModal .edit-input');
	    for(let index=0; index<inputArr.length; index++){
	        if(inputArr[index].dataset.checkbox == 1){
                remarkExtraValue[inputArr[index].dataset.index]['value'] = inputArr[index].value.split(',');
            }else{
                remarkExtraValue[inputArr[index].dataset.index]['value'] = inputArr[index].value;
            }
        }
        layer.confirm('确认要修改备注信息吗？', {
            title: '提示',
            btn: ['确定','取消']    //按钮
        }, function(index){
            var load_index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/order/editOrderRemark',
                'data'  : {tid, remark: JSON.stringify(remarkExtraValue),type:0},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        $('#editRemarkModal').modal('hide');
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
            layer.close(index);
        },function() {

        });
    });
    $('.edit-trade-note').on('click',function () {
        //先清空
        $('#hid_note_tid').val($(this).data('tid'));
        $('#order-note').val($(this).data('note'));
        $('#editNoteModal').modal('show');
    });

    $('#edit-note-confirm').on('click', function () {
        var tid = $('#hid_note_tid').val();
        var note = $('#order-note').val();
        layer.confirm('确认要修改备注信息吗？', {
            title: '提示',
            btn: ['确定','取消']    //按钮
        }, function(index){
            if(tid && note){
                var load_index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/order/editOrderRemark',
                    'data'  : { tid:tid,remark:note,type:1},
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.close(load_index);
                        if(ret.ec == 200){
                            $('#editNoteModal').modal('hide');
                            window.location.reload();
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }else {
                layer.msg('请将信息填写完整');
            }
            layer.close(index);
		},function() {

        });
    });




</script><?php }} ?>
