<style>
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
	input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
	input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
	input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
	input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
	input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
	input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
	input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
	input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }


</style>
<{if $seqregion == 1}>
<{include file="../common-second-menu.tpl"}>
<{/if}>
<div id='mainContent'>
	<div class='panel panel-default'>
		<div class='panel-body'>
			<div>
				区域合伙人登录地址:<a target="_blank" href="http://<{$host}>/manage/user/index">http://<{$host}></a>&nbsp;&nbsp;
				<button id='copy' data-clipboard-action='copy' data-clipboard-text='http://<{$host}>' class='btn btn-xs btn-default' style='padding:1px 5px;'>复制</button>
			</div>
			<div style='display: flex;padding:6px 0;'>
				<a class='btn btn-sm btn-green' href='/wxapp/Seqregion/editSeqAreaManager'>
					<i clas='icon icon-plus'></i>
					添加区域合伙人
				</a>
				<a class='btn btn-sm btn-green' style='margin:0 10px;'  href="/wxapp/Seqregion/withdrawList">佣金提现申请记录</a>
				<div class='text-right' style='flex: 1;'>
					<form class='form-inline' action='' method="GET">
						<div class='form-group'>
							<input class='form-control' type="text" name="mobile" value='<{$smarty.get.mobile}>' placeholder="区域合伙人手机号码">
						</div>
						<div class='form-group'>
							<button class='btn btn-sm btn-green' type='submit'>查找</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class='panel panel-default'>
		<div class='panel-body'>
			<span style="">
	                合伙人添加商品审核：
	                <label id="choose-onoff" class="choose-onoff">
	                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="goodsVerify" data-type="open" onchange="changeOpen('goods')" type="checkbox" <{if $seq_cfg && $seq_cfg['asc_region_goods_verify']}> checked<{/if}>>
	                <span class="lbl"></span>
	                </label>
	        </span>
			<span style="margin-left: 10px">
	                合伙人添加小区审核：
	                <label id="choose-onoff" class="choose-onoff">
	                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="communityVerify" data-type="open" onchange="changeOpen('community')" type="checkbox" <{if $seq_cfg && $seq_cfg['asc_region_community_verify']}> checked<{/if}>>
	                <span class="lbl"></span>
	                </label>
	        </span>
			<span style="margin-left: 10px">
	                合伙人团长管理：
	                <label id="choose-onoff" class="choose-onoff">
	                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="leaderOpen" data-type="open" onchange="changeOpen('leader_open')" type="checkbox" <{if $seq_cfg && $seq_cfg['asc_region_leader_open']}> checked<{/if}>>
	                <span class="lbl"></span>
	                </label>
	        </span>
		</div>
	</div>

	<table class='table table-hover'>
		<thead>
			<tr>
				<td>姓名</td>
				<td>手机号码</td>
				<td>所属区域</td>
				<td>状态</td>
				<td>平台商品佣金比例</td>
				<td>自定义商品抽成比例</td>
				<td>创建时间</td>
				<td>操作</td>
			</tr>
		</thead>
		<tbody>
			<{foreach $manager_list as $item}>
			<tr>
				<td><{$item.m_nickname}></td>
				<td><{$item.m_mobile}></td>
				<td><{$item.city}>-<{$item.zone}></td>
				<td>
					<{if $item.m_status==0}>
					<span class='text-success'>正常</span>
					<{else if  $item.m_status==1}>
					<span class='text-warning'>审核</span>
					<{else if  $item.m_status==2}>
					<span class='text-danger'>禁用</span>
					<{/if}>
				</td>
				<td><{$item.m_area_brokerage}>%</td>
				<td><{if $item.m_area_region_goods_brokerage}><{$item.m_area_region_goods_brokerage}><{else}>0<{/if}>%</td>
				<td><{date('Y/m/d H:i:s',$item.m_createtime)}></td>
				<td>
					<a class='btn btn-sm btn-info ' href="/wxapp/Seqregion/editSeqAreaManager?mid=<{$item.m_id}>">编辑</a>
					<button class='btn btn-sm btn-danger manager_delete' 
					data-mid='<{$item.m_id}>'
					data-status='<{if $item.m_status==0}>disable<{else if $item.m_status==2}>enable<{/if}>'>
						<{if $item.m_status==0}>禁用<{else if $item.m_status==2}>启用<{/if}>
					</button>
					<a class="btn btn-sm btn-info" href="/wxapp/sequence/leaderList?region_mobile=<{$item.m_mobile}>">团长管理</a>
					<a class="btn btn-sm btn-info" href="/wxapp/Seqregion/regionBrokerage?region_manager_id=<{$item.m_id}>">佣金详情</a>
					<{if $seqregion == 1}>
					<a class="btn btn-sm btn-info" href="/wxapp/seqregion/goodsVerify?region_id=<{$item.m_id}>">查看商品</a>
					<{/if}>
					<a class="btn btn-sm btn-info" target="_blank" href="/wxapp/sequence/tradeList?area_id=<{$item.m_area_id}>&area_manager=<{$item.m_id}> ">订单详情</a>
				</td>
			</tr>
			<{/foreach}>
		</tbody>
	</table>
	<div class='text-right'>
		<{$paginator}>
	</div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script type="text/javascript">
	var clipboard = new ClipboardJS('#copy');
	clipboard.on('success', function(e) {
	  	layer.msg('复制成功');
	});
	$(function(){
		
		$('.manager_delete').click(function(){
			let mid=$(this).data('mid');
			let status=$(this).data('status');
			if(!mid){
				layer.msg('请选择要设置的管理员');
				return;
			}
			layer.confirm('是否要'+(status=='enable'?'启用':'禁用')+'当前管理员？',{
				btn:['确定','取消'],
				title:'设置管理员状态',
			},function(){
				$.ajax({
					type:'POST',
					url:'/wxapp/Seqregion/managerDisaled',
					dataType:'json',
					data:{
						'mid'	:mid,
						'status':status
					},
					success:function(res){
						layer.msg(res.em);
						if(res.ec==200)
							location.reload();
					}
				});
			});
		});
	});

	function changeOpen(type) {
		if(type == 'leader_open'){
			var open   = $('#leaderOpen:checked').val();
		}else{
			var open   = $('#'+type+'Verify:checked').val();
		}

		var data = {
			value:open,
			type : type
		};
		$.ajax({
			'type'  : 'post',
			'url'   : '/wxapp/seqregion/changeVerifyCfg',
			'data'  : data,
			'dataType'  : 'json',
			'success'   : function(ret){
				console.log(ret.em);
			}
		});
	}

</script>