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
			width: 33%;
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
			margin-bottom: 5px;
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
		.width-10{
			width: 10%;
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

		.shop-title{
			color: #000;
			font-size: 18px;
			text-align: center;
			padding: 10px 0;
		}

		.hand-write div{
			display: inline-block;
			font-size: 16px;
			margin: 7px;
		}
		.hand-write-sign{
			width: 30%;
		}

	</style>
</head>
<body>
	<div class="packinglist-box">
		<div class="shop-title">交货单（高端小区）</div>
		<div class="order-info clearfix">
			<p class="fl">线路名称：line</p>
			<p class="fl">团长姓名：leader</p>
			<p class="fl">团长电话：18866669999</p>
		</div>
		<div class="order-info clearfix">
			<p class="fl">配送员电话：16699999999</p>
			<p class="fl">公司电话：123456-123</p>
			<p class="fl">商品总数：30</p>
		</div>
		<div class="order-info clearfix">
			<p class="fl">配送时间：2019-08-23</p>
			<p class="fl">配送单号：123123123123123132</p>
			<p class="fl">社区名称：高端小区</p>
		</div>
		<div>
			<p class="">社区地址：郑州市郑东新区CBD商务内环11号金城东方国际2402</p>
		</div>
		<div class="order-detail">
			<table cellpadding="0" cellspacing="0" border="1">
				<thead>
					<tr>
						<td>商品分类</td>
						<td>商品名称</td>
						<td>规格</td>
						<td>商品数量</td>
						<td class="width-10">备注</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>XXXXX</td>
						<td>xxxxxxxxxxxxxxxxxxxxxxx</td>
						<td>xxxxxxxxx</td>
						<td>10</td>
						<td></td>
					</tr>
					</tbody>
					<tr>
						<td colspan="5" style="text-align: center">
							高端小区
						</td>
					</tr>
			</table>
			<div class="hand-write">
				<div class="hand-write-sign">
					团长签字
				</div>
				<div class="">
					日期：
				</div>
			</div>
			<div class="hand-write">
				<div class="hand-write-sign">
					配送员签字：
				</div>
				<div class="">
					日期
				</div>
			</div>
		</div>
	</div>
</body>
</html>