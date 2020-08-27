<div class='panel panel-default'>
	<div class='panel-heading'>
		区域管理提现申请
	</div>
	<div class='panel-body'>
		<table class='table table-hover' style='border:none;'>
			<thead>
				<tr>
					<th>提现人</th>
					<th>提现金额</th>
					<th>提现方式</th>
					<th>提现状态</th>
					<th>申请时间</th>
					<th>审批时间</th>
					<th>审批备注</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<{foreach $list as $item}>
				<tr>
					<td>
						<p><b>姓名：</b><{$item.m_nickname}></p>
						<p><b>手机：</b><{$item.m_mobile}></p>
						<p><b>区域：</b><{$item.region_name}></p>
					</td>
					<td><span class='text-success'><{sprintf('%.2f',$item.arwr_money/100)}>￥</span></td>
					<td><{if $item.arwr_type==0}>微信<{else if $item.arwr_type==1}>人工转账<{else}>其他<{/if}></td>
					<td>
						<{if $item.arwr_status==0}>
						<span class='text-warning'>审核中</span>
						<{elseif $item.arwr_status==1}>
						<span class='text-success'>已通过</span>
						<{elseif $item.arwr_status==3}>
						<span >等待会计审核</span>
						<{elseif $item.arwr_status==2}>
						<span class='text-danger'>已拒绝</span>
						<{/if}>
							
					</td>
					<td><{date('Y/m/d H:i:s',$item.arwr_create_at)}></td>
					<td>
						<{if $item.arwr_update_at}>
						<{date('Y/m/d H:i:s',$item.arwr_create_at)}>
						<{else}>
						审核中
						<{/if}>
					</td>
					<td>
						<{if $item.arwr_remark}>
						<{$item.arwr_remark}>
						<{else}>
						无
						<{/if}>
					</td>
					<td>
						<{if $item.arwr_status!=0}>
						<button disabled class='btn btn-sm btn-success'>已审核</button>
						<{else}>
						<button data-uid='<{$item.arwr_id}>' class='btn btn-sm btn-info deal-withdraw'>审核</button>
						<{/if}>
					</td>
				</tr>
				<{/foreach}>
			</tbody>
		</table>
		<div class='text-right'>
			<{$paginator}>
		</div>
	</div>
</div>
<div id="withdraw-form"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">提现处理</h4>
            </div>
            <div class="modal-body" style="padding: 10px 20px">
                <form>
                    <input type="hidden" id="hid_id" value="0">
                    <div class="form-group">
                        <div class="checkbox" style="padding-left: 0">
                            <label class='label-control'><b>转账方式</b></label>
                            <div class="radio-box">
                                <span>
                                    <input type="radio" name="type" value="0" id="type1" checked>
                                    <label for="type1">微信</label>
                                </span>
                                <span>
                                    <input type="radio" name="type" value="1" id="type2">
                                    <label for="type2">人工转账</label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox" style="padding-left: 0">
                            <label  class='label-control'><b>审核状态</b></label>
                            <div class="radio-box">
                                <span>
                                    <input type="radio" name="status" value="1" id="status1" checked>
                                    <label for="status1">通过</label>
                                </span>
                                <span>
                                    <input type="radio" name="status" value="2" id="status2">
                                    <label for="status2">拒绝</label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class='label-control'><b>审核备注</b></label>
                        <textarea type="text" class="form-control" id="note" name="note" rows="3" cols="80" placeholder="请输入审核备注"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-save" class="btn btn-primary" >保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
	$(function(){
		$('.deal-withdraw').click(function(){
			let uid=$(this).data('uid');
			$('#hid_id').val(uid);
			$('#withdraw-form').modal('show');
		});
		$('#modal-save').click(function(){
			let status = $('input[name="status"]:checked').val();
			let type = $('input[name="type"]:checked').val();
            let id   = $('#hid_id').val();
            let note = $('#note').val();
            $.ajax({
            	type:'POST',
            	url:'/wxapp/seqregion/dealWithdraw',
            	dataType:'json',
            	data:{
            		'id'     : id,
                    'status' : status,
                    'type'	 : type,
                    'note'   : note,
            	},
            	success:function(res){
					layer.msg(res.em,{time:1600},function () {
						if(res.ec == 200){
							window.location.reload();
						}
					});
            	}
            });
		});
	});
</script>