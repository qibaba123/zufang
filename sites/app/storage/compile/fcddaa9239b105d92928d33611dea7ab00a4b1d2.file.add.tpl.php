<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:02:19
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/full/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14843487405e4df6bb578956-28252877%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fcddaa9239b105d92928d33611dea7ab00a4b1d2' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/full/add.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14843487405e4df6bb578956-28252877',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'singleType' => 0,
    'type' => 0,
    'val' => 0,
    'rules' => 0,
    'key' => 0,
    'kind' => 0,
    'goods' => 0,
    'isAdd' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df6bb6088d1_52423141',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df6bb6088d1_52423141')) {function content_5e4df6bb6088d1_52423141($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
	.add-gift{
		padding-top: 10px;
		margin-left: 140px;
	}
	.info-title{
		padding:10px 0;
		border-bottom: 1px solid #eee;
	}
	.info-title span{
		line-height: 16px;
		font-size: 15px;
		font-weight: bold;
		display: inline-block;
    	padding-left: 10px;
    	border-left: 3px solid #3d85cc;
	}
	.input-table{
		width: 100%;
	}
	.input-table td{
		padding:8px 10px;
		vertical-align: middle;
	}
	.input-table td.label-td{
		padding-right: 0;
		width: 130px;
		text-align: right;
		vertical-align: top;
	}
	.input-table label{
		text-align: right;
		font-weight: bold;
		font-size: 14px;
		width: 130px;
		line-height: 34px;
	}
	.input-table .form-control{
		width: 290px;
		height: 34px;
	}
    .Wdate{
        border-color: #ccc;
    }
	.input-table textarea.form-control{
		width: 100%;
		max-width: 750px;
		height: auto;
	}
	.input-table .form-control.spinner-input{
		width: 55px;
		border-color: #dfdfdf;
	}
	.Wdate{
		background-position: 98% center;
	}
	.full-minus-item,.product-item{
		padding: 10px;
		position: relative;
		border: 1px solid #e8e8e8;
		-webkit-border-radius: 4px;
		-ms-border-radius: 4px;
		border-radius: 4px;
		overflow: hidden;
		max-width: 750px;
		padding-right: 45px;
		margin-bottom: 10px;
		min-width: 650px;
	}
	.delete{
		font-size: 22px;
	    font-weight: 700;
	    line-height: 1;
	    color: #000;
	    text-shadow: 0 1px 0 #fff;
	    opacity: .2;
	    filter: alpha(opacity=20);
	    position: absolute;
	    top: 14px;
	    right: 10px;
	}
	.delete:hover{
		opacity: .6;
	    filter: alpha(opacity=60);
	}

	 .item-wrap{
	 	font-size: 0;
	 }
	.full-minus-item .item-wrap b,.product-item .item-wrap b{
		margin:0 5px;
		display: inline-block;
		vertical-align: middle;
		font-size: 14px;
	}
	.full-minus-item .item-wrap span,.product-item .item-wrap span,.product-item .item-wrap div{
		display: inline-block;
		vertical-align: middle;
		font-size: 14px;
	}
	.full-minus-item .item-wrap span input,.product-item .item-wrap span input{
		width: 150px;
		font-size: 14px;
	}
	.product-item .item-wrap .good-name-box{
		text-align: left;
    	width: 50%;
	}
	.product-item .item-wrap .good-name-box .good-name{
		margin:0;
		padding: 0 5px;
		font-size: 14px;
		width: 95%;
		margin-left: 5px;
		display: inline-block;
		overflow: hidden;
		white-space: nowrap;
		text-overflow: ellipsis;
	}
	.modal-body .table-responsive{
		width: 100%;
	}

	/*选择全部或指定商品*/
	.choose-goodrange{
		padding-top: 5px;
	}
	.choosegoods{
		padding: 5px 0;
	}
	.choosegoods .tip{
		font-size: 12px;
		color: #999;
		margin:0;
	}
	.choosegoods>div{
		display: none;
	}
	.add-good-box .btn{
		margin-top: 10px;
	}
	.add-good-box .table{
		max-width: 750px;
		margin: 10px 0 0;
	}
	.add-good-box .table thead tr th{
		border-right: 0;
		padding: 12px 10px;
		vertical-align: middle;
	}
	.add-good-box .table tbody tr td{
		padding: 11px 10px;
		vertical-align: middle;
		white-space: normal;
	}
	.left{
		text-align: left;
	}
	.center{
		text-align: center;
	}
	.right{
		text-align: right;
	}
	td.goods-info p{
		display: -webkit-box !important;
		overflow: hidden;
		text-overflow:ellipsis;
		word-break:break-all;
		-webkit-box-orient:vertical;
		-webkit-line-clamp:2;
		max-height: 38px;
	}
	.add-good-box .table span.del-good{
		color: #38f;
		font-weight: bold;
		cursor: pointer;
	}
</style>
<!--
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

-->
<!--类别选择开始-->
<?php if (!$_smarty_tpl->tpl_vars['row']->value&&!($_smarty_tpl->tpl_vars['singleType']->value>0)) {?>
<div class="choose-pintuan" id="div-type" >
	<h3>选择创建一种满优惠活动</h3>
	<p>通过发放活动提高用户消费积极性</p>
	<div class="pintuan-type" >
		<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
		<?php if ($_smarty_tpl->tpl_vars['val']->value['type']==1||$_smarty_tpl->tpl_vars['val']->value['type']==4) {?>
		<div class="type-item" data-type="<?php echo $_smarty_tpl->tpl_vars['val']->value['type'];?>
" data-title="<?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
">
			<a href="#">
				<div class="ticket ticket-<?php echo $_smarty_tpl->tpl_vars['val']->value['color'];?>
">
					<span><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</span>
				</div>
				<div class="right-txt">
					<h4><?php echo $_smarty_tpl->tpl_vars['val']->value['brief'];?>
</h4>
					<p><?php echo $_smarty_tpl->tpl_vars['val']->value['desc'];?>
</p>
				</div>
			</a>
		</div>
		<?php }?>
		<?php } ?>
	</div>
</div>
<?php }?>
<!--类别选择结束-->
<div class="add-gift" id="div-add" <?php if (!$_smarty_tpl->tpl_vars['row']->value) {?>style="display: none;"<?php } else { ?>style="margin-left: 150px"<?php }?> >
	<h4 class="info-title"><span id="show_title"></span></h4>
	<input type="hidden" id="type"  class="form-control" placeholder="请选择活动类型" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['fa_type'];?>
<?php }?>"/>
	<input type="hidden" id="id"  class="form-control" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['fa_id'];?>
<?php }?>"/>
	<input type="hidden" id="max-item"  class="form-control" value="<?php echo count($_smarty_tpl->tpl_vars['rules']->value[('type_').($_smarty_tpl->tpl_vars['row']->value['fa_type'])]);?>
"/>

	<table class="input-table">
		<tr>
			<td class="label-td"><label><span class="red">*</span>活动名称:</label></td>
			<td><input type="text" id="name"  class="form-control" placeholder="请输入活动名称" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['fa_name'];?>
<?php }?>"/></td>
		</tr>
		<tr>
			<td class="label-td"><label><span class="red">*</span>开始时间:</label></td>
			<td><input id="start_time" type="text" placeholder="请选择开始时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'end_time\')}'})" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['fa_start_time']);?>
<?php }?>"></td>
		</tr>
		<tr>
			<td class="label-td"><label><span class="red">*</span>结束时间:</label></td>
			<td><input id="end_time" type="text" placeholder="请选择结束时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'start_time\') || (\'%y-%M-%d\')}'})" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['fa_end_time']);?>
<?php }?>"></td>
		</tr>
		<tr>
			<td class="label-td"><label><span class="red">*</span>满优惠规则:</label></td>
			<td>
				<div class="full-minus-box rule" id="full-type-1">
					<div style="padding-bottom: 10px;">
						<a href="javascript:;" class="btn btn-xs btn-green" onclick="addCoupon(this,'minus')"><i class="icon-plus"></i>添加</a>
					</div>
					<div id="full-minus">
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rules']->value['type_1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
						<div class="full-minus-item" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
							<div class="item-wrap">
								<b>满</b>
								<span><input type="text" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"  id="limit_1_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['limit'];?>
" class="form-control"></span>
								<b>减</b>
								<span><input type="text" id="value_1_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
" class="form-control"></span>
							</div>
							<a href="javascript:;" class="delete" onclick="removeItem(this)">×</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="full-present-box rule" id="full-type-2">
					<div style="padding-bottom: 10px;">
						<a href="javascript:;" class="btn btn-xs btn-green" onclick="addCoupon(this,'present')"><i class="icon-plus"></i>添加</a>
					</div>
					<div id="full-present">
						<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rules']->value['type_2']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
						<div class="full-present-item product-item" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
							<div class="item-wrap">
								<b>满</b>
								<span><input type="text" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" id="limit_2_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['limit'];?>
" class="form-control"></span>
								<b>赠</b>
								<div>
									<span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#goodsList" onclick="addGood(this)">+添加赠品</span>
								</div>
								<div class="good-name-box">
									<span class="good-name" id="goods_2_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</span>
									<input class="goods-id" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
" type="hidden" id="value_2_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"  value="<?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
" />
								</div>
							</div>
							<a href="javascript:;" class="delete" onclick="removeItem(this)">×</a>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="full-discount-box rule" id="full-type-3">
					<div style="padding-bottom: 10px;">
						<a href="javascript:;" class="btn btn-xs btn-green" onclick="addCoupon(this,'discount')"><i class="icon-plus"></i>添加</a>
					</div>
					<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rules']->value['type_3']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
					<div id="full-minus">
						<div class="full-minus-item" data-id="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
							<div class="item-wrap">
								<b>满</b>
								<span><input type="text" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"  id="limit_3_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['limit'];?>
" class="form-control"></span>
								<b>折</b>
								<span><input type="text" id="value_3_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['value'];?>
" class="form-control"></span>
							</div>
							<a href="javascript:;" class="delete" onclick="removeItem(this)">×</a>
						</div>
					</div>
					<?php } ?>
				</div>
				<div class="full-present-box rule" id="full-type-4">
					<div id="full-express" data-id="0">
						<div class="product-item">
							<div class="item-wrap">
								<b>满</b>
								<span><input type="text" data-id="<?php echo $_smarty_tpl->tpl_vars['rules']->value['type_4'][0]['id'];?>
" id="limit_4_0" value="<?php echo $_smarty_tpl->tpl_vars['rules']->value['type_4'][0]['limit'];?>
" class="form-control"></span>
								<b>包邮</b>
								<span><input type="hidden" id="value_4_0" value="0" class="form-control"></span>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr id="rule-kind-tr">
			<td class="label-td"><label><span class="red">*</span>优惠方式:</label></td>
			<td >
				<div class="radio-box">
						<span data-id="1">
							<input type="radio" name="kind" id="ruleMoney" value="1" <?php if ($_smarty_tpl->tpl_vars['kind']->value==1) {?>checked<?php }?>>
							<label for="ruleMoney">满金额</label>
						</span>
						<span data-id="2">
							<input type="radio" name="kind" id="ruleNum" value="2" <?php if ($_smarty_tpl->tpl_vars['kind']->value==2) {?>checked<?php }?>>
							<label for="ruleNum">满件数</label>
						</span>
				</div>
			</td>
		</tr>
		<tr>
			<td class="label-td"><label><span class="red">*</span>可使用商品:</label></td>
			<td class="text-left">
				<div class="choose-goodrange">
					<div class="radio-box">
						<span data-type="all">
							<input type="radio" name="use_type" id="allGood" value="1" <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['fa_use_type']==2)) {?>checked<?php }?>>
							<label for="allGood">全店通用</label>
						</span>
						<span data-type="assign">
							<input type="radio" name="use_type" id="assignGood" value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['fa_use_type']==2) {?>checked<?php }?>>
							<label for="assignGood">指定商品</label>
						</span>
					</div>
					<div class="choosegoods">
						<div class="allgood-tip" data-type="all" <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['fa_use_type']==2)) {?>style="display: block;"<?php }?>>
							<p class="tip">保存后，不能更改成指定商品</p>
						</div>
						<div class="assigngood-tip" data-type="assign" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['fa_use_type']==2) {?>style="display: block;"<?php }?>>
							<p class="tip">指定商品可用时，订单金额不包含运费</p>
							<div class="add-good-box">
								<div class="goodshow-list">
									<table class="table">
										<thead>
											<tr>
												<th class="left">商品名称</th>
												<th class="right">操作</th>
											</tr>
										</thead>
										<tbody id="can-used_goods">
											<?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
											<tr class="good-item">
												<td class="goods-info" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['gid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
"><p><?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
</p></td>
												<td class="right"><span class="del-good">删除</span></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="confirmAddgood()">+添加商品</div>
							</div>
						</div>
					</div>
				</div>
			</td>
		</tr>
		<tr>
			<td class="label-td"><label>活动描述:</label></td>
			<td><textarea class="form-control" id="desc" rows="3" placeholder="请输入活动描述"><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['fa_desc'];?>
<?php }?></textarea></td>
		</tr>
		<tr>
			<td class="label-td"><label><span class="red">&nbsp;</td>
			<td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 活 动 </a></td>
		</tr>
	</table>
</div>
<!--添加礼物结束-->

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("../modal-gift-select.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript">
	$(function(){
		if('<?php echo $_smarty_tpl->tpl_vars['isAdd']->value;?>
' == 'edit'){
			changeType('<?php echo $_smarty_tpl->tpl_vars['row']->value['fa_type'];?>
','<?php echo $_smarty_tpl->tpl_vars['type']->value[$_smarty_tpl->tpl_vars['row']->value['fa_type']]['title'];?>
')
		}


		// 选择全店或部分商品相关js
		$(".choose-goodrange").on('click', '.radio-box>span', function(event) {
			var type = $(this).data('type');
			$(this).parents('.choose-goodrange').find(".choosegoods>div").stop().hide();
			$(this).parents('.choose-goodrange').find(".choosegoods>div[data-type="+type+"]").stop().show();
		});
		// 删除选择的商品
		$(".add-good-box").on('click', '.del-good', function(event) {
			var trElem = $(this).parents('tr.good-item');
			var goodListElem = $(this).parents('.goodshow-list');
			var length = parseInt($(this).parents('.table').find('tbody tr').length);
			trElem.remove();
			// if(length<=1){
			// 	goodListElem.stop().hide();
			// }
		});

		var singleType = '<?php echo $_smarty_tpl->tpl_vars['singleType']->value;?>
';
		if(singleType == '1'){
			changeType(1,'满减活动');
		}

	});
	$('.type-item').on('click',function(){
		var type  = $(this).data('type');
		var title = $(this).data('title');
		changeType(type,title);
	});

	function changeType(type,title){
		$('#show_title').text('添加'+title);
		$('#type').val(type);
		$('#div-type').hide();
		$('.rule').hide();
		$('#full-type-'+type).show();
		$('#div-add').show();
		if(type == 1){
			$('#rule-kind-tr').hide();
		}else{
			$('#rule-kind-tr').show();
		}
	}
	
	/*获得添加的html结构*/
	function get_html(type,maxDataId){
		var insertHtml 	= '';
		var name		= '';
		var key 		= parseInt(maxDataId)+1;
		var valueId     = 'value_'+type+'_'+key;
		var limitId     = 'limit_'+type+'_'+key;
		var idId        = 'id_'+type+'_'+key;
		if(type==1){
			name = 'minus';
			insertHtml = '<b>减</b><span><input type="text" id="'+valueId+'" class="form-control"></span>';
		}else if(type==2){
			name = 'present';
			insertHtml = '<b>赠</b><div><span class="btn btn-primary btn-sm" data-toggle="modal" data-target="#goodsList" onclick="addGood(this)">+添加赠品</span></div><div class="good-name-box"><span class="good-name" id="goods_'+type+'_'+key+'"></span><input type="hidden" class="goods-id"  id="'+valueId+'"></div>';
		}else if(type==3){
			name = 'minus';
			insertHtml = '<b>折</b><span><input type="text" id="'+valueId+'" class="form-control"></span>';
		}
		var html = '<div class="full-' + name + '-item product-item" data-id="'+key+'">';
			html += '<div class="item-wrap">';
			html += '<b>满</b>';			
			html += '<span><input type="text" data-id="0" id="'+limitId+'" class="form-control"></span>';
			html += insertHtml;
			html += '</div>';
			html += '<a href="javascript:;" class="delete" onclick="removeItem(this)">×</a>';
			html += '</div>';
		return html;
	}
	/*添加*/
	function addCoupon(elem,type){
		var html   ='';
		var length = 0;
		var addParentElem = $(elem).parent().next();
		var maxDataId = 0;
		addParentElem.find('.full-'+type+'-item').each(function(){
			var temp = $(this).data('id');
			if(maxDataId < temp) maxDataId = temp;
		});

		$('#max-item').val(maxDataId+1);

		if(type == 'minus'){
			html = get_html(1,maxDataId);
			length = addParentElem.find('.full-minus-item').length;
		}else if(type=='present'){
			html = get_html(2,maxDataId);
			length = addParentElem.find('.product-item').length;
		}else if(type=='discount'){
			html = get_html(3,maxDataId);
			length = addParentElem.find('.full-minus-item').length;
		}


		if(length<10){
			addParentElem.append(html);
		}else{
			layer.msg("最多只能有10个哦");
		}
	}
	/*移除*/
	function removeItem(elem,type){
		var delItem = $(elem).parent();
		delItem.remove();
	}

	$('.btn-save').on('click',function(){
		var field = new Array('type','name','start_time','end_time');
		var data  = {};
		for(var i=0; i < field.length; i++){
			var temp = $('#'+field[i]).val();
			if(temp){
				data[field[i]] = temp
			}else{
				var msg = $('#'+field[i]).attr('placeholder');
				layer.msg(msg);
				return false;
			}
		}
		data.id   	= $('#id').val();
		data.desc   = $('#desc').val();
		data.item 	= $('#max-item').val();
		data.use_type = $('input[name="use_type"]:checked').val();
		data.kind	  = $('input[name="kind"]:checked').val();

		var rules = {};
		for(var j=0 ; j <= data.item ; j++){
			var limit = $('#limit_'+data.type+"_"+j).val();
			if(limit){
				rules['rule_'+j] = {
					'id'    : $('#limit_'+data.type+"_"+j).attr('data-id'), //$('#id_'+data.type+"_"+j).val()
					'limit' : limit,
					'value' : $('#value_'+data.type+"_"+j).val()
				}
			}
		}
		if(!rules){
			layer.msg('满优惠规则!');
			return false;
		}
		data.rules = rules;
		
		var goods = {},g=0;
		$('#can-used_goods').find('.good-item').each(function(){
			var gid = $(this).find('.goods-info').data('gid');
			if(gid){
				goods['go_'+g] = {
					'id' 	: $(this).find('.goods-info').data('id'),
					'gid'	: gid,
					'name'	: $(this).find('.goods-info').data('gname')
				};
				g++;
			}
		});
		data.goods = goods;
		//保存信息
		layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var loading = layer.load(10, {
				shade: [0.6,'#666']
			});
			$.ajax({
				'type'  : 'post',
				'url'   : '/wxapp/full/saveFull',
				'data'  : data,
				'dataType' : 'json',
				'success'   : function(ret){
					layer.close(loading);
					layer.msg(ret.em);
					if(ret.ec == 200){
						window.location.href='/wxapp/full/index'
					}
				}
			});
        });

	});
</script><?php }} ?>
