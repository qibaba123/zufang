<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:05:53
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/trade-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8230888345e4e68111b6745-92809150%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ddeddaee020a8962a8b01b8aadad852f62a27663' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/auction/trade-list.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8230888345e4e68111b6745-92809150',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tid' => 0,
    'title' => 0,
    'buyer' => 0,
    'start' => 0,
    'end' => 0,
    'status' => 0,
    'orderLink' => 0,
    'val' => 0,
    'list' => 0,
    'tradePay' => 0,
    'statusNote' => 0,
    'trader' => 0,
    'key' => 0,
    'mal' => 0,
    'print' => 0,
    'pkey' => 0,
    'pal' => 0,
    'v' => 0,
    'page_html' => 0,
    'express' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6811249565_90074488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6811249565_90074488')) {function content_5e4e6811249565_90074488($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/order/trade-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style>
	.page-content{
		margin-left: 140px;
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
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
 <!--#4c8fbd;-->
<div>
	<a href="/wxapp/print" class="btn btn-green btn-sm"><i class="icon-print"></i>打印模版设置</a>
	<a href="#" class="btn btn-green btn-sm" data-click-upload ><i class="icon-cloud-upload"></i>批量发货</a>
</div>
<div class="page-header search-box">
	<div class="col-sm-12">
		<form class="form-inline" action="/wxapp/auction/orderList" method="get">
			<div class="col-xs-11 form-group-box">
				<div class="form-container">
					<div class="form-group">
						<div class="input-group">
							<div class="input-group-addon">订单编号</div>
							<input type="text" class="form-control" name="tid" value="<?php echo $_smarty_tpl->tpl_vars['tid']->value;?>
"  placeholder="订单编号">
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
					<div class="form-group" style="width: 400px">
						<div class="input-group">
							<div class="input-group-addon" >参与时间</div>
							<input type="text" class="form-control" name="start" value="<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
							<span class="input-group-addon" style="border: none !important;background-color:  inherit !important;">到</span>
							<input type="text" class="form-control" name="end" value="<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
							<span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
						</div>
					</div>
					<input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
				</div>
			</div>
			<div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 20%;right: 2%;">
				<button type="submit" class="btn btn-green btn-sm">查询</button>
			</div>
		</form>
	</div>
</div>

<div class="choose-state">
	<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['orderLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
	<a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value&&$_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?>class="active"<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
	<?php } ?>
</div>
<div class="trade-list">
	<table class="ui-table-order" style="padding: 0px;">
		<thead class="js-list-header-region tableFloatingHeaderOriginal" style="position: static; top: 0px; margin-top: 0px; left: 225px; z-index: 1; width: 794px;">
		    <tr class="widget-list-header">
		        <th class="" colspan="2" style="min-width: 212px; max-width: 212px;">商品</th>
		        <th class="price-cell" style="min-width: 87px; max-width: 87px;">起拍价</th>
				<th class="price-cell" style="min-width: 87px; max-width: 87px;">当前价格</th>
		        <th class="customer-cell" style="min-width: 110px; max-width: 110px;">买家</th>
		        <th class="time-cell" style="min-width: 80px; max-width: 80px;">
		            <a href="javascript:;" data-orderby="book_time">参与时间<span class="orderby-arrow desc">↓</span></a>
		        </th>
		        <th class="state-cell" style="min-width: 100px; max-width: 100px;">订单状态</th>
		        <th class="pay-price-cell" style="min-width: 150px; max-width: 150px;">实付金额</th>
		    </tr>
		</thead>

		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<tbody class="widget-list-item">
		<tr class="separation-row">
			<td colspan="7"></td>
		</tr>
		<tr class="header-row">
			<td colspan="7">
				<div>
					订单号: <?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>

					<div class="help" style="display: inline-block;">
						<span class="js-help-notes c-gray" data-class="bottom" style="cursor: help;"><?php echo $_smarty_tpl->tpl_vars['tradePay']->value[$_smarty_tpl->tpl_vars['val']->value['t_pay_type']];?>
</span>
					</div>
				</div>
				<div class="clearfix">
				</div>
			</td>
			<td colspan="2" class="text-right">
				<div class="order-opts-container">
					<div class="js-opts" style="display: block;">
						<a href="/wxapp/auction/tradeDetail?order_no=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="new-window" >查看详情</a>
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
					<a href="/wxapp/auction/orderList?title=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
"class="new-window" title="<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>
">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_title'];?>

					</a>
				</p>
			</td>
			<td class="price-cell">
				<p>
					<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_start_price'];?>

				</p>
			</td>
			<td class="price-cell">
				<p>
					<?php echo $_smarty_tpl->tpl_vars['val']->value['aal_curr_price'];?>

				</p>
			</td>
			<td class="customer-cell" rowspan="1">
				<p>
					<a href="/wxapp/auction/orderList?buyer=<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>
" class="new-window" target="_blank">
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_buyer_nick'];?>

					</a>
				</p>
			</td>
			<td class="time-cell" rowspan="1">
				<div class="td-cont">
					<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['t_create_time']);?>

				</div>
			</td>
			<td class="state-cell" rowspan="1">
				<div class="td-cont">
					<p class="js-order-state" id="status_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
"><?php echo $_smarty_tpl->tpl_vars['statusNote']->value[$_smarty_tpl->tpl_vars['val']->value['t_status']];?>
</p>
				</div>
			</td>
			<td class="pay-price-cell" rowspan="1">
				<div class="td-cont text-center">
					<div>
						<?php echo $_smarty_tpl->tpl_vars['val']->value['t_total_fee'];?>

						<br>
					</div>
					<p class="user-name">
					<?php if ($_smarty_tpl->tpl_vars['val']->value['t_status']==3) {?>
				<span id="express_<?php echo $_smarty_tpl->tpl_vars['val']->value['t_tid'];?>
" class="btn btn-primary btn-xs express-btn"
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
					</p>
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
			<td colspan="7">买家备注： <?php echo $_smarty_tpl->tpl_vars['val']->value['t_note'];?>
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
				<?php if ($_smarty_tpl->tpl_vars['v']->value['type']!='image') {?>
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
			</tr>
			<?php }?>
		</tbody>
		<?php } ?>

		<tbody class="widget-list-item">
		    <tr class="separation-row">
		        <td colspan="7"><?php echo $_smarty_tpl->tpl_vars['page_html']->value;?>
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
			<p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传csv类型的文件</p>
			<div style="font-size: 14px;margin-top: 10px;" >注意　<span id="show-notice">最大支持 1 MB CSV的文件。</span></div>
			<div style="font-size: 14px;margin-top: 10px;" ><a href="/public/common/批量发货样本.csv" id="show-notice">下载批量发货模板</a></div>
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
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/wxapp-order.js"></script>
<script type="text/javascript">
	$(function(){
		// 下拉搜索框
		$(".chosen-select").chosen({
			no_results_text: "没有找到",
			search_contains: true
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

		$('.refund-btn').on('click',function(){
			if(confirm("确定退款吗？")){
				var index = layer.load(10, {
					shade: [0.6,'#666']
				});
				var tid  = $(this).data('tid');
				var data = {
					'tid'	: tid,
					'status': 2,
				};
				$.ajax({
					'type'  : 'post',
					'url'   : '/wxapp/order/refundTrade',
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
			}
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
                $('#modal-address').html(province + ' '+city+ ' '+area+ ' '+address+ '，'+name+ ' '+phone);
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
						window.location.reload();
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

</script><?php }} ?>
