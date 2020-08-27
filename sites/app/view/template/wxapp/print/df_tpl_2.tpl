<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
	<title>配货单</title>
	<style>
		*{
			margin:0;
			padding: 0;
		}
		body{
			color: #000;
			font: normal 14px/160% "黑体", "Microsoft Yahei", "微软雅黑", arial, helvetica, "Hiragino Sans GB",  sans-serif;
		}
		.fl{
			float: left;
		}
		.fr{
			float: right;
		}
		/* 清除浮动 */
		.clearfix:before, .clearfix:after {
		    display: block;
		    visibility: hidden;
		    height: 0;
		    content: "";
		    clear: both;
		}
		.clearfix {
		    zoom: 1;
		}
		.text-left{
			text-align: left!important;
		}
		.text-center{
			text-align: center!important;
		}
		.text-right{
			text-align: right!important;
		}
		.packinglist-box{
			width: 95%;
			max-width: 800px;
			margin:0 auto;
			margin-top: 20px;
		}
		.packinglist-box h4{
			font-size: 20px;
			text-align: center;
			line-height: 3;
			font-weight: bold;
			font-family: '黑体';
		}
		.order-info{
			line-height: 1.5;
			font-size: 13px;
		}
		.order-info .fl span{
			display: inline-block;
			vertical-align: top;
			width: 80px;
			text-align: right;
		}
		.order-detail table{
			width: 100%;
			word-break:break-all;
			border-collapse:collapse;
		}
		.width-40{
			width: 40%;
		}
		.width-20{
			width: 20%;
		}
		.order-detail{
			margin-top: 5px;
		}
		.order-detail table th,.order-detail table td{
			text-align: center;
			padding:5px;
			border-color: #666;
		}
		.order-detail table td{
			padding:3px;
		}
		.order-detail table td.total,.order-detail table td.subtotal{
			padding: 15px 10px;
		}
		.order-detail table td.subtotal span{
			margin-left: 70px;
		}
		.order-detail table td.total b{
			font-size: 16px;
		}
		.tips{
			margin-top: 5px;
		}
		.tips p{
			line-height: 1.5;
			font-size: 13px;
		}
		.signature span{
			display: inline-block;
			width: 30%;
			font-size: 16px;
			font-weight: bold;
			line-height: 2.5;
		}
	</style>
</head>
<body>
	<div class="packinglist-box">
		<div class="order-info clearfix">
			<p class="fr text-right">订单日期：2016-09-08</p>
		</div>
		<div class="order-info clearfix">
			<p class="fl"><span>联 系 人：</span>天店通</p>
			<p class="fr text-right">联系电话：186XXXXXX</p>
		</div>
		<div class="order-info clearfix">
			<p class="fl"><span>订 单 号：</span>XXX XXX </p>
			<p class="fr text-right">送货地址：XXXXXX</p>
		</div>
		<div class="order-detail">
			<table cellpadding="0" cellspacing="0" border="1">
				<thead>
					<tr>
						<th>序号</th>
						<th class="width-40">商品名称</th>
						<th>数量</th>
						<th>单价</th>
						<th>小计</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>1</td>
						<td>商品</td>
						<td>1</td>
						<td>0.01</td>
						<td>0.01</td>
					</tr>
					</tbody>
					<tr>
						<td colspan="6" class="text-left subtotal">
							<span>商品小计：<b>￥0.01</b></span>
						</td>
					</tr>
			</table>
		</div>
	</div>
</body>
</html>