<link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/cost-rank.css">
<style type="text/css">
	.font-bold{
        font-size: 14px;
    }
</style>
<div class='panel panel-default'>
	<div class='panel-body text-right'>
		<form class='form-inline' action='/wxapp/seqstatistics/memberCost' method='get'>
			<div class='form-group'>
			    <a href="/wxapp/seqstatistics/memberCost" class='btn btn-sm btn-warning'>
			        <{if $smarty.get.finish_only != 1}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>全部
			    </a>
			    <a href="/wxapp/seqstatistics/memberCost?finish_only=1" class='btn btn-sm btn-warning'>
			        <{if $smarty.get.finish_only == 1}>
			        <i class="icon-ok-sign"></i>
			        <{/if}>仅显示已完成订单
			    </a>
			</div>
			<div class='form-group'>
				<select class='form-control' name='orderby'>
					<!-- <option value='0'>排序</option> -->
					<option value='ordercount' <{if $smarty.get.orderby !='ordermoney'}>selected<{/if}> >订单数</option>
					<option value='ordermoney' <{if $smarty.get.orderby =='ordermoney'}>selected<{/if}>>订单金额</option>
				</select>
			</div>
			<div class='form-group'>
				<input class='form-control' type="text" name="user" placeholder="会员名/手机号" value='<{$smarty.get.user}>'>
			</div>
			<button class='btn btn-sm btn-info' type='submit'>搜索</button>
		</form>
	</div>
</div>
<table class='table table-hover'>
	<thead>
		<tr>
			<td>排行</td>
			<td>会员</td>
			<td>姓名</td>
			<td>手机号</td>
			<td>消费金额</td>
			<td>订单数</td>
		</tr>
	</thead>
	<tbody>
		<{foreach $cost_list as $key=>$item}>
		<tr>
			<td>
				<{if $smarty.get.page*50+$key+1 <= 5}>
				<span class='label label-danger label-padding'><{$smarty.get.page*50+$key+1}></span>
				<{else}>
				<span class='label label-default label-padding'><{$smarty.get.page*50+$key+1}></span>
				<{/if}>
			</td>
			<td>
				<div class='flex'>
					<p>
						<img class='avatar-img' src="<{$item.m_avatar}>">
					</p>
					<p><{if $item.m_nickname !='undefined'}><{$item.m_nickname}><{/if}></p>
				</div>
			</td>
			<td><{$item.m_realname}></td>
			<td><{$item.m_mobile}></td>
			<td>
				<span class='font-bold'>
				<{if $item.total}>
				￥<{$item.total}>
				<{else}>
				￥0
				<{/if}>
				</span>
			</td>
			<td>
				<span class='font-bold'>
				<{if $item.num}>
				<{$item.num}>
				<{else}>
				0
				<{/if}>
				</span>
			</td>
		</tr>
		<{/foreach}>
	</tbody>
</table>
<!--<div class='text-right'>
	
</div>-->
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$paginator}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>