<style type="text/css">
	.font-color{
		color: #9a999e;
	}
	.form-inline .form-control{
		width: auto!important;
	}
	.form-inline .fa , .panel .fa{
		font-size: 12px;
		min-width: auto;
		margin-top: -2px;
	}
	.btn-hidden{
		display: none;
	}
</style>
<div class='panel panel-default'>
	<div class='panel-body'>
		<form class='form-inline'>
			<div class='form-group'>
				<label>供应商：</label>
				<select name='supplier' class='form-control'>
					<option value=0>全部</option>
					<{foreach $supplier_list as $item}>
					<option value='<{$item.assi_id}>' <{if $smarty.get.supplier==$item.assi_id}>selected<{/if}> ><{$item.assi_name}></option>
					<{/foreach}>
				</select>
			</div>
			<div class='form-group' style='margin-left:15px;'>
				<label>审核状态：</label>
				<select name='status' class='form-control'>
					<option value=-1>全部</option>
					<option <{if $smarty.get.status === 0}>selected<{/if}> value=0>未审核</option>
					<option <{if $smarty.get.status == 1}>selected<{/if}> value=1>已通过</option>
					<option <{if $smarty.get.status == 2}>selected<{/if}> value=2>已拒绝</option>
				</select>
			</div>
			<div class='form-group' style='margin-left:15px;'>
				<label>时间：</label>
				<input name='start' id='start' class='form-control' type='text' readonly autocomplete="off" placeholder="开始时间" value='<{$smarty.get.start}>'>
				<input name='end' id='end' class='form-control' type='text' readonly autocomplete="off" placeholder="结束时间" value='<{$smarty.get.end}>'>
			</div>
			<button class='btn btn-sm btn-primary'><i class='fa fa-search'></i>搜索</button>
		</form>
	</div>
</div>
<table class='table table-hover'>
	<thead>
		<tr>
			<th>商品图片</th>
			<th>商品名称</th>
			<th>成本价格</th>
			<th>供应商</th>
			<th>申请时间</th>
			<th>状态</th>
			<th>审核备注</th>
			<th>操作</th>
		</tr>
	</thead>
	<tbody>
		<{foreach $goods_list as $item}>
		<tr>
			<td>
				<img src="<{$item.assg_g_cover}>" style='width: 80px;height: 80px;border-radius: 5px;'>
			</td>
			<td class='font-color'><{$item.assg_g_name}></td>
			<td><b>￥<{$item.assg_g_cost}></b></td>
			<td><{$item.assi_name}></td>
			<td  class='font-color'><{date('Y/m/d H:i',$item.assg_create_time)}></td>
			<td>
				<{if $item.assg_status ==1}>
				<span class='text-success'>已通过</span>
				<p><span class='font-color'><{date('Y/m/d H:i',$item.assg_check_time)}></span></p>
				<{elseif $item.assg_status ==2}>
				<span class='text-danger'>已拒绝</span>
				<p><span class='font-color'><{date('Y/m/d H:i',$item.assg_check_time)}></span></p>
				<{else}>
				<span class='text-warning'>未审核</span>
				<{/if}>	
			</td>
			<td  class='font-color'>
				<{if $item.assg_remark}>
				<{$item.assg_remark}>
				<{else}>
				无
				<{/if}>
			</td>
			<td>
				<{if $item.assg_status == 0}>
				<button data-gid='<{$item.assg_id}>'  class='btn btn-primary btn-sm open_check_modal'>审核</button>
				<{else if  $item.assg_status==2}>
				<button data-gid='<{$item.assg_id}>'  class='btn btn-default btn-sm' <{if $item.assg_status !=0}>disabled<{/if}>>已拒绝</button>
				<{elseif $item.assg_status == 1}>
				<a class='btn btn-success btn-sm' target="_blank"  href="/wxapp/sequence/goodsEdit?id=<{$item.assg_plate_g_id}>">编辑商品</a>
				<{/if}>
			</td>
		</tr>
		<{/foreach}>
	</tbody>
</table>
<div class='text-right'>
	<{$paginator}>
</div>
<!-- 审核商品 modal框 -->
<div id='checkModal' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">供应商商品审核</h4>
			</div>
			<div class="modal-body">
				<div class='form-horizontal'>
					<input type="hidden" id="hidden_g_id">
					<div class='form-group'>
						<label class='col-xs-3'>选择状态：</label>
						<div class='col-xs-9'>
							<label class="radio-inline">
								<input class='g_status' type="radio" name="g_status" value="success"> 通过
							</label>
							<label class="radio-inline">
								<input class='g_status' type="radio" name="g_status" value="refuse"> 拒绝
							</label>
						</div>
					</div>
					<div class='form-group'>
						<label class='col-xs-3'>审核备注：</label>
						<div class='col-xs-9'>
							<textarea class='form-control' id='g_remark'></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button data-type=1 type="button" class="btn btn-primary do_check">保存</button>
				<button id='check_edit' data-type=2 type="button" class="btn btn-primary do_check btn-hidden ">保存并编辑商品</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
	laydate.render({
		elem: '#start',
		type:'datetime'
	});
	laydate.render({
		elem: '#end',
		type:'datetime',
	});
	$(function(){
		$('.open_check_modal').click(function(){
			let g_id=$(this).data('gid');
			$('#hidden_g_id').val(g_id);
			$('#checkModal').modal('show');
		});
		$('.g_status').change(function(){
			let val=$('.g_status:checked').val();
			if(val=='success')
				$('#check_edit').show();
			else
				$('#check_edit').hide();
		});

		$('.do_check').click(function(){
			let type=$(this).data('type');
			let g_id=$('#hidden_g_id').val();
			let g_status=$('.g_status:checked').val();
			let g_remark=$('#g_remark').val();
			$.ajax({
				type:'POST',
				url:'/wxapp/sequence/dealSupplierGoods',
				dataType:'json',
				data:{
					'g_id'		:g_id,
					'g_status'	:g_status,
					'g_remark'	:g_remark,
				},
				success:function(res){
					layer.msg(res.em);
					if(res.ec==200){
						if(type==1){
							setTimeout(function(){
								window.location.reload();
							},1000);
						}else if(type==2){
							setTimeout(function(){
								$('#checkModal').modal('hide');
								window.open('/wxapp/sequence/goodsEdit?id='+res.data);
							},1000);
						}
					}
				}
			});
		});
	});
</script>