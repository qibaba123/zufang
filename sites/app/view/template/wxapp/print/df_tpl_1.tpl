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
		.shopping-box{
			width: 95%;
			max-width: 800px;
			margin:0 auto;
			margin-top: 20px;
		}
		.shopping-box h4{
			font-size: 16px;
			line-height: 3;
			font-weight: normal;
			font-family: '黑体';
		}
		.shopping-box h4 span{
			font-size: 14px;
			color: red;
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
		.order-detail table{
			border-top: 1px solid #666;
		}
		.order-detail table tr.order-date td{
			border-bottom: 1px solid #666;
			padding:5px;
		}
		.order-detail table tr.detail td{
			padding:3px 15px;
		}
		.order-detail table tr.sub-total td{
			border-bottom: 1px solid #666;
			border-top: 1px solid #666;
			padding:10px 5px;
			font-size: 13px;
		}
		.order-detail table tr.total td{
			border-bottom: 1px solid #666;
			padding:6px 5px;
		}
		.tips{
			margin-top: 15px;
			padding-bottom: 10px;
			border-bottom: 1px solid #aaa;
		}
		.tips p{
			line-height: 1.5;
			font-size: 13px;
		}
		.shop-title{
			color: red;
			font-size: 15px;
			text-align: center;
			padding: 10px 0;
		}
	</style>
</head>
<body>
	<div class="shopping-box">
		<div class="order-detail">
			<table cellpadding="0" cellspacing="0" border="0">
				<tr class="order-date">
					<td colspan="2">订单编号：201905060125632233</td>
					<td colspan="2" class="text-right">客户下单日期：2016-09-06</td>
				</tr>
				<tr class="detail">
					<td>订购商品名称</td>
					<td>单价</td>
					<td>数量</td>
					<td>小计</td>
				</tr>
				<tbody>
				<tr class="detail">
					<td>收费</td>
					<td>1</td>
					<td>0.01</td>
					<td>0.01</td>
				</tr>
				</tbody>
				<tr class="sub-total">
					<td colspan="4"  class="text-right">
						<p>商品小计：<b>￥0.01</b></p>
						<p>打印优惠：<b>￥0.00元</b></p>
					</td>
				</tr>
				<tr class="total">
					<td colspan="4" class="text-right">
						<b>应付款：￥0.01</b>
					</td>
				</tr>
			</table>
		</div>
	</div>
</body>
</html>