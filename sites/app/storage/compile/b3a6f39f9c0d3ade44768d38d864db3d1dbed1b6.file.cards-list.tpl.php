<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:23:22
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/cardpwd/cards-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14303881475e4e6c2a981834-28321966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b3a6f39f9c0d3ade44768d38d864db3d1dbed1b6' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/cardpwd/cards-list.tpl',
      1 => 1575110410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14303881475e4e6c2a981834-28321966',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'cards_list' => 0,
    'key' => 0,
    'item' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6c2a9c85f6_08466759',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6c2a9c85f6_08466759')) {function content_5e4e6c2a9c85f6_08466759($_smarty_tpl) {?><style type="text/css">
	.label{
		line-height: 20px;
	}
	.panel-body *{
		margin-right: 8px;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body' style='display: flex;'>
		<button class='btn btn-primary btn-sm' id='createBatch'>批量生成</button>
		<button class='btn btn-primary btn-sm' id='export'>未使用数据导出</button>
		<button class='btn btn-primary btn-sm' id='exportUse'>已使用数据导出</button>
		<form class='form form-inline'  method='get'>
			<div class="form-group">
				<input class='form-control' type="text" placeholder="请输入卡号进行查询" name="search" value='<?php echo $_GET['search'];?>
'>
				<input type="hidden"  name="status" value='<?php echo $_GET['status'];?>
'>
			</div>
			<div class='form-group'>
				<button class='btn btn-primary btn-sm' type='submit'>搜索</button>
			</div>
		</form>
	</div>
</div>
<div class="choose-state">
    <a href="/wxapp/Cardpwd/index" class="<?php if ($_GET['status']==0||$_GET['status']==='') {?>active<?php }?>">未使用</a>
    <a href="/wxapp/Cardpwd/index?status=1" class="<?php if ($_GET['status']==1) {?>active<?php }?>">已使用</a>
</div>
<table class='table table-striped table-hover'>
	<thead>
		<tr>
			<th>编码</th>
			<th>卡号</th>
			<th>密码</th>
			<th>面额</th>
			<th>状态</th>
			<?php if ($_GET['status']==1) {?>
			<th>会员编号/昵称</th>
			<?php }?>
			<th>过期时间</th>
			<th>添加时间</th>
			<th>备注</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['cards_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
		<tr>
			<td>
				<span class='label label-default label-padding'><?php echo $_GET['page']*15+$_smarty_tpl->tpl_vars['key']->value+1;?>
</span>
			</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['acr_code'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['acr_pwd'];?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['acr_value'];?>
</td>
			<td>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['acr_status']==1) {?>
				<p><span class='text-success'>已使用</span></p>
				<p><span><?php echo date('Y/m/d H:i',$_smarty_tpl->tpl_vars['item']->value['acr_use_time']);?>
</span></p>
				<?php } else { ?>
				<span>未使用</span>
				<?php }?>
			</td>
			<?php if ($_GET['status']==1) {?>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['m_show_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['item']->value['m_nickname'];?>
</td>
			<?php }?>
			<td><?php echo date('Y/m/d H:i',$_smarty_tpl->tpl_vars['item']->value['acr_expire_time']);?>
</td>
			<td><?php echo date('Y/m/d H:i',$_smarty_tpl->tpl_vars['item']->value['acr_create_time']);?>
</td>
			<td><?php echo $_smarty_tpl->tpl_vars['item']->value['acr_remark'];?>
</td>
			<td>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['acr_status']==0) {?>
				<button class='btn btn-danger btn-sm delete_card' data-uid="<?php echo $_smarty_tpl->tpl_vars['item']->value['acr_id'];?>
">删除</button>
				<?php } else { ?>
				<button class='btn btn-default btn-sm' disabled="true">已使用</button>
				<?php }?>
			</td>
		</tr>
		<?php } ?>
	</tbody>
</table>
<div class='text-right'>
	<?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

</div>
<!-- create cards modal -->
<div id='createModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">批量生成</h4>
			</div>
			<div class="modal-body">
				<div class='form'>
					<div class='form-group'>
						<label>生成数量：</label>
						<input id='num' class='form-control' type="number" name="">
					</div>
					<div class='form-group'>
						<label>面额：</label>
						<input id='value' class='form-control' type="number" name="">
					</div>
					<div class='form-group'>
						<label>过期时间：</label>
						<input id='expire' class='form-control' type="text" name="" autocomplete="off">
					</div>
					<div class='form-group'>
						<label>备注信息：</label>
						<textarea id='remark' class='form-control'></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='saveCardsPwd' type="button" class="btn btn-primary">保存</button>
			</div>
		</div>
	</div>
</div>
<!-- export cards data -->
<div id='exportModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">批量导出</h4>
			</div>
			<div class="modal-body">
				<div class='form'>
					<div class='form-group'>
						<label>开始编号：</label>
						<input id='start_num' class='form-control' type="number" name="">
					</div>
					<div class='form-group'>
						<label>结束编号：</label>
						<input id='end_num' class='form-control' type="number" name="" >
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='exportCardsPwd' type="button" class="btn btn-primary">导出</button>
			</div>
		</div>
	</div>
</div>

<!-- export use cards data -->
<div id='exportUseModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">批量导出</h4>
			</div>
			<div class="modal-body">
				<div class='form'>
					<div class='form-group'>
						<label>使用时间开始：</label>
						<input id='start_date' class='form-control' type="text" autocomplete="off" readonly>
					</div>
					<div class='form-group'>
						<label>使用时间结束：</label>
						<input id='end_date' class='form-control' type="text" autocomplete="off" readonly>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id='exportCardsPwdUse' type="button" class="btn btn-primary">导出</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
	laydate.render({
	  	elem: '#expire' ,
	  	type:'datetime',
	});

	laydate.render({
		elem: '#start_date' ,
		type:'datetime'
	});
	laydate.render({
		elem: '#end_date' ,
		type:'datetime'
	});

	$(function(){
		$('#createBatch').click(function(){
			$('#createModal').modal('show');
		});
		$('#export').click(function(){
			$('#exportModal').modal('show');
		});

		$('#exportUse').click(function(){
			$('#exportUseModal').modal('show');
		});

		$('#saveCardsPwd').click(function(){
			let num=$('#num').val();
			let value=$('#value').val();
			let expire=$('#expire').val();
			let remark=$('#remark').val();
			$.ajax({
				type:'POST',
				url:'/wxapp/Cardpwd/createCards',
				dataType:'json',
				data:{
					'num'	:num,
					'value'	:value,
					'expire':expire,
					'remark':remark,
				},
				success:function(res){
					layer.msg(res.em);
					if(res.ec==200){
						setTimeout(function(){
							window.location.reload();
						},500);
					}
				}
			});
		});
		$('#exportCardsPwd').click(function(){
			let start=$('#start_num').val();
			let end=$('#end_num').val();
		
			//window.location.href='/wxapp/Cardpwd/exportCard?start='+start+'&end='+end;
			window.location.href='/wxapp/Cardpwd/excelNoUse?start='+start+'&end='+end;
		});

		$('#exportCardsPwdUse').click(function(){
			let start=$('#start_date').val();
			let end=$('#end_date').val();

			//window.location.href='/wxapp/Cardpwd/exportCard?start='+start+'&end='+end;
			window.location.href='/wxapp/Cardpwd/excelUse?start_date='+start+'&end_date='+end;
		});

		$('.delete_card').click(function(){
			let _this=$(this);
			let uid=$(this).data('uid');
			layer.confirm('您确定要删除吗？', {
               	title:'删除提示',
               	btn: ['确定','取消']
            }, function(){
               	$.ajax({
               		type:'post',
               		url:'/wxapp/Cardpwd/deleteCard',
               		dataType:'json',
               		data:{
               			'card_id':uid
               		},
               		success:function(res){
               			layer.msg(res.em);
               			if(res.ec==200){
               				_this.parent().parent().remove();
               			}
               		}
               	}); 
               
            })
		});
	});
</script><?php }} ?>
