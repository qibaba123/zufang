<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:02:49
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/goods-rank.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12067875945e8699490bc1c1-53174004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '52746a354e5f2b6e6368635d9c81e9b7e0e6958f' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/goods-rank.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12067875945e8699490bc1c1-53174004',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'rank_list' => 0,
    'key' => 0,
    'item' => 0,
    'showPage' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e869949133006_18467123',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e869949133006_18467123')) {function content_5e869949133006_18467123($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/goods-rank.css">
<style type="text/css">
	#form .label{
		height: 25px;
		line-height: 1.4;
		padding: 4px 12px;
		cursor: pointer;
		background-color: #abbac3 !important;
	}
	#form .active{
		background-color: #3a87ad !important;
	}
	.font-bold{
        font-size: 14px;
    }
</style>
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<div class='row'>
			<div class='col-xs-9 text-left'>
				<form id='form' class='form-inline'>
					<span name='all' class="search label label-info <?php if ($_GET['start']=='all'||$_GET['start']=='') {?>active<?php }?>">全部</span>
					<span name='today' class="search label label-info  <?php if ($_GET['start']=='today') {?>active<?php }?>">今日</span>
					<span name='yesterday' class="search label label-info <?php if ($_GET['start']=='yesterday') {?>active<?php }?>">昨日</span>	
					<span name='week' class="search label label-info  <?php if ($_GET['start']=='week') {?>active<?php }?>">近7日</span>
					<span name='month' class="search label label-info  <?php if ($_GET['start']=='month') {?>active<?php }?>">近30日</span>&nbsp;&nbsp;
					<div class='form-group'>
						<input name='gname' type="text" id="gname" class='form-control' placeholder="商品名称" value='<?php echo $_GET['gname'];?>
'>
					</div>
					<div class='form-group'>
						<input name='start' type="text" id="start" class='form-control' placeholder="开始时间" value='<?php if (!in_array($_GET['start'],array("today","yesterday","week","month","all"))) {?><?php echo $_GET['start'];?>
<?php }?>' autocomplete='off'>
					</div>
					<div class='form-group'>
						<input name='end' type="text" id="end" class='form-control' placeholder="结束时间" value='<?php echo $_GET['end'];?>
' autocomplete='off'>
					</div>
					<button type='submit' class='btn btn-info btn-sm' id='dateGroup'>查询</button>
				</form>
			</div>
			<div class='col-xs-3'>
				<a href="javascript:;" data-type='total' class="btn btn-sm btn-danger sort"><i class="icon-yen"></i> 按销售额排序</a>
				<a href="javascript:;" data-type='num' class="btn btn-sm btn-warning sort"><i class="icon-bar-chart"></i> 按销售量排序</a>
			</div>
		</div>
	</div>
</div>
<div class='help-block text-right'>
	<!-- <small class="text-warning">*仅统计已完成订单数据*</small> -->
	<a href="javascript:;" data-type='0' class='btn btn-sm btn-warning finish'>
        <?php if ($_GET['finish_only']!=1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>全部
    </a>
    <a href="javascript:;" data-type='1' class='btn btn-sm btn-warning finish'>
        <?php if ($_GET['finish_only']==1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>仅显示已完成订单
    </a>
    <a href="javascript:;" class="btn btn-sm btn-primary excel-modal"  data-toggle="modal" data-target="#excelModal" > 导出数据</a>
</div>
<table class="table table-hover">
	<thead>
		<tr>
			<th>排行</th>
			<th>商品名称</th>
			<th>销售量</th>
			<th>销售额</th>
			<th>利润统计</th>
		</tr>
	</thead>
	<tbody>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['rank_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<tr>
			<td>
				<?php if ($_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1<=5) {?>
				<span class='label label-danger label-padding'><?php echo $_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1;?>
</span>
				<?php } else { ?>
				<span class='label label-default label-padding'><?php echo $_GET['page']*50+$_smarty_tpl->tpl_vars['key']->value+1;?>
</span>
				<?php }?>
			</td>
			<td>
				<div class='flex'>
					<p>
						<img class='goods-img' src="<?php echo $_smarty_tpl->tpl_vars['item']->value['g_cover'];?>
">
					</p>
					<p><?php echo $_smarty_tpl->tpl_vars['item']->value['g_name'];?>
</p>
				</div>
			</td>
			<td>
				<span class='font-bold'>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['num']!='') {?>
				<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>

				<?php } else { ?>
				0
				<?php }?>
				</span>
			</td>
			<td>
				<span class='font-bold'>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['total']!='') {?>
				￥<?php echo $_smarty_tpl->tpl_vars['item']->value['total'];?>

				<?php } else { ?>
				￥0
				<?php }?>
				</span>
			</td>
			<td>
				<p title='成本为新增属性，历史订单可能无法统计到成本信息'>总成本：<b class='text-danger' style='padding-left: 12px;'>￥<?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['item']->value['cost']);?>
</b></p>
				<p>订单收入：<b class='text-info'>￥<?php echo sprintf('%.2f',$_smarty_tpl->tpl_vars['item']->value['total']);?>
</b></p>
				<p>总利润：<b class='text-success' style='padding-left: 12px;'>￥<?php echo sprintf('%.2f',($_smarty_tpl->tpl_vars['item']->value['total']-$_smarty_tpl->tpl_vars['item']->value['cost']));?>
</b></p>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<!--<div class='text-right'>
	
</div>-->
<?php if ($_smarty_tpl->tpl_vars['showPage']->value!=0) {?>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</div>
            </div>
        </div>
    </div>
</div>
<?php }?>

<div class="modal fade" id="excelModal" tabindex="-1" role="dialog" aria-labelledby="excelModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 535px;">
		<div class="modal-content" style="border: none;border-radius: 0;">
			<input type="hidden" id="hid_id" >
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="excelModalLabel">
					导出
				</h4>
			</div>
			<div class="modal-body" >
				<div class="form-group row">
					<label class="col-sm-2 control-label no-padding-right" for="qq-num">导出方式：</label>
					<div class="col-sm-10">
						<select name="excel_type" id="excel_type" class="form-control" onchange="changeExcelType()">
							<option value="1">普通导出</option>
							<option value="2">指定范围导出</option>
						</select>
					</div>
				</div>

				<div class="form-group row excel_type_row excel_type_row_1">
					<label class="col-sm-2 control-label no-padding-right" for="qq-num">导出数量：</label>
					<div class="col-sm-10">
						<input id="total_num" type="number" class="form-control" placeholder="请填写0-100之间的整数" style="height:auto!important"/>
						<div style="padding-left: 3px;color: #666">
							将会导出当前条件下前n条数据，最多100条。
						</div>
					</div>
				</div>

				<div class="form-group row excel_type_row excel_type_row_2">
					<label class="col-sm-2 control-label no-padding-right" for="qq-num">指定范围：</label>
					<div class="col-sm-10">
						导出排名
						<input id="num_start" type="number" class="form-control" placeholder="请填写整数" style="height:auto!important;width:38%;display: inline-block;margin-right: 5px;margin-left: 5px"/>至
						<input id="num_end" type="number" class="form-control" placeholder="请填写整数" style="height:auto!important;width:38%;display: inline-block;margin-left: 5px"/>
						<div style="padding-left: 3px;color: #666">
							将会导出当前条件下指定排名之间（包含首尾）的n条数据，最多100条。
						</div>
					</div>
				</div>

			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">取消
			</button>
			<button type="button" class="btn btn-primary excel">
				确认
			</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal -->
</div>

<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
	$(function(){
		laydate.render({
		  elem: '#start' 
		});
		laydate.render({
		  elem: '#end' 
		});
		$('.search').click(function(){
			let field=$('#form').serialize();
			location.href='/wxapp/seqstatistics/goodsRank?'+field+'&start='+$(this).attr('name');
		});

		// 判断页面参数中是否有排序字段 有的话替换 没有的话增加
		$('.sort').click(function(){
			let type=$(this).data('type');
			let params=getQueryVariable();
			params['sort']=type;
			location.href='/wxapp/seqstatistics/goodsRank?'+decodeURIComponent($.param(params));
		});
		// 筛选订单类型
		$('.finish').click(function(){
			let type=$(this).data('type');
			let params=getQueryVariable();
			params['finish_only']=type;
			location.href='/wxapp/seqstatistics/goodsRank?'+decodeURIComponent($.param(params));
		});

		// 导出数据
		$('.excel').click(function(){
			let total_num = $('#total_num').val();
			let excel_type = $('#excel_type').val();
			let num_start = $('#num_start').val();
			let num_end = $('#num_end').val();

			if(excel_type == 2){
				let total = num_end - num_start;
				if(total > 100 || total < 0){
					layer.msg('请填写正确的导出范围');
				}
			}else{
				if(total_num <= 0 || total_num > 100){
					layer.msg('请填写正确的导出数量');
				}
			}
			let params=getQueryVariable();
			params['total_num']=total_num;
			params['num_start']=num_start;
			params['num_end']=num_end;
			params['excel_type']=excel_type;
			
			location.href='/wxapp/seqstatistics/goodsRankExcel?'+decodeURIComponent($.param(params));
		});

		// 获取url参数
		function getQueryVariable(){
	       let query = window.location.search.substring(1);
	       let vars = query.split("&");
	       let params={};
	       for (let i=0;i<vars.length;i++) {
               let pair = vars[i].split("=");
               params[pair[0]]=pair[1];
	       }
	       return params;
		}

	});

	$('.excel-modal').click(function () {
		changeExcelType();
	});


	function changeExcelType() {
		let excel_type = $('#excel_type').val();
		$('.excel_type_row').hide();
		$('.excel_type_row_'+excel_type).show();
	}

</script><?php }} ?>
