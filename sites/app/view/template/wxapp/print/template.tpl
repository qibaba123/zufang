<style>
	.page-content{
		padding:20px;
	}
	.btn-box{
		margin-top: 15px;
		text-align: center;
	}
	.btn-box .btn{
		margin:0 5px;
	}
	.tabbable textarea.form-control{
		resize: vertical;
	}
	.label-box{
		margin-top: 30px;
	}
	.label-box h4{
		font-size: 16px;
		font-weight: bold;
		line-height: 2;
		text-align: center;
	}
	
	.table tbody tr td,.table thead tr th{
		padding: 6px;
		color: #999;
		text-align: center;
	}
	.table thead tr th{
		color: #333;
	}
	.table tbody tr td.title{
		font-weight: bold;
		color: #666;
	}
</style>
<div class="row" style="max-width:1000px;margin:0 auto">
	<div class="col-xs-12">
		<div class="tabbable">
			<ul class="nav nav-tabs" id="myTab">
				<{foreach $print as $key=>$val}>
				<li <{if $key eq 1}>class="active"<{/if}>>
					<a data-toggle="tab" href="#shopping-list_<{$key}>">
						<{$val['label']}>
					</a>
				</li>
				<{/foreach}>
			</ul>

			<div class="tab-content">
				<{foreach $print as $key=>$val}>
				<div id="shopping-list_<{$key}>" class="tab-pane in <{if $key eq 1}>active<{/if}>">
					<div>
						<textarea name="content_<{$key}>" id="content_<{$key}>" rows="15" class="form-control"><{$val['content']}></textarea>
						<div class="btn-box">
							<button class="btn btn-sm btn-green previewCon" data-type="<{$key}>">预览</button>
							<button class="btn btn-sm btn-blue savePrintTpl" data-type="<{$key}>">保存</button>
						</div>
					</div>
				</div>
				<{/foreach}>
			</div>
		</div>

		<div class="label-box">
			<h4>订单标签提示</h4>
			<div class="label-tip">
				<table cellpadding="0" cellspacing="0" border="1" width="100%" class="table">
					<thead>
					<tr>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<{foreach $tag as $key=>$val}>
						<td  class="title"><{$val['label']}></td>
						<td><{$val['field']}></td>
						<{if $key % 4 == 3}></tr><tr><{/if}>
						<{/foreach}>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="label-box">
			<h4>表格标签提示</h4>
			<div class="label-tip">
				<table cellpadding="0" cellspacing="0" border="1" width="100%" class="table">
					<thead>
					<tr>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
						<th class="title">标签名字</th>
						<th>替代符号</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<{foreach $tableTag as $key=>$val}>
						<td  class="title"><{$val['label']}></td>
						<td><{$val['field']}></td>
						<{if $key % 4 == 3}></tr><tr><{/if}>
						<{/foreach}>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/wxapp-order.js?1"></script>

