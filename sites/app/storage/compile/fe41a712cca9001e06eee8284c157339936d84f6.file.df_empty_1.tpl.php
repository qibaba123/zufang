<?php /* Smarty version Smarty-3.1.17, created on 2020-02-21 14:27:10
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/print/df_empty_1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16950923675e4f783e9f9337-64160668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fe41a712cca9001e06eee8284c157339936d84f6' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/print/df_empty_1.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16950923675e4f783e9f9337-64160668',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'content' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4f783ea147f7_29052726',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4f783ea147f7_29052726')) {function content_5e4f783ea147f7_29052726($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
	<title>购物单</title>
</head>
<body>
<div id="print-content">
	<style>
		*{
			margin:0;
			padding: 0;
		}
		body{
			color: #000;
			font: normal 14px/160% "黑体", "Microsoft Yahei", "微软雅黑", arial, helvetica, "Hiragino Sans GB",  sans-serif;
			margin:0;
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
<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

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
</html><?php }} ?>
