<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
	<title>配货单</title>
</head>
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

	.shop-title{
		color: #000;
		font-size: 18px;
		text-align: center;
		padding: 10px 0;
	}

	.print-btn{
		background-color: #0077DD;
		color: #fff;
		border: padding;
		padding: 9px 20px;
		border: 0;
		margin-top: 60px;
		margin-bottom: 30px;
		border-radius: 3px;
		cursor: pointer;
		font-family: '微软雅黑';
	}

</style>
<body>
	<div id="print-content">
		<{$content}>
	</div>
	<div class="shop-title text-center" id="print-btn">
		<input type="button" class="print-btn" value="打印本页" onclick="printpage()" />
	</div>
	<script src="/public/common/js/jquery-1.11.1.min.js"></script>
	<script src="/public/common/js/jQuery.print.js"></script>
	<script type="text/javascript">
		function printpage(){
			// window.print();
			// var headstr = "<html><head><title></title></head><body>";
			// var footstr = "</body>";
			// var newstr  = document.getElementById('print-content').innerHTML;
			$("#print-content").print()
			// layer.closeAll();
			// var oldstr  = document.body.innerHTML;
			// console.log(oldstr);
			// document.body.innerHTML=headstr+newstr+footstr;
			// w=window.open("","_blank","k");
			// w.document.write(headstr+newstr+footstr);
			// if (navigator.appName == 'Microsoft Internet Explorer') {
			// 	window.print();
			// }else{
			// 	w.print();
			// }
			// w.close();
			// document.body.innerHTML = oldstr;
			// return false;
		}
	</script>
</body>
</html>