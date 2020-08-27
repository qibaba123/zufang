<?php /* Smarty version Smarty-3.1.17, created on 2020-01-13 11:25:43
         compiled from "/mnt/www/default/ddfyce/yingxiaosc/error/500.html" */ ?>
<?php /*%%SmartyHeaderCode:18045354585e1be337b1d4e4-57830319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7367d7dc9938064ada86c588b3d8149b56240558' => 
    array (
      0 => '/mnt/www/default/ddfyce/yingxiaosc/error/500.html',
      1 => 1560823962,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18045354585e1be337b1d4e4-57830319',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e1be337b21026_98643288',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e1be337b21026_98643288')) {function content_5e1be337b21026_98643288($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>天店通-系统提示</title>
	<style>
		*{
			margin:0;
			padding:0;
		}
		body{
			background-color: #f6f7f8;
		}
		.error{
			width: 484px;
			height: 450px;
			position: absolute;
			top:50%;
			left:50%;
			margin-top: -225px;
			margin-left: -242px;
			background: url(/error/image/500.png) no-repeat;
			background-size: 100%;
			background-position: top center;
			font-family: 'Microsoft Yahei';
		}
		.tips{
			padding-top: 290px;
    		padding-left: 30px;
		}
		.tips h4{
			font-size: 40px;
			text-align: center;
			font-weight: normal;
		}
		.tips p{
			color: #999;
			font-size: 18px;
			text-align: center;
			margin:10px auto;
		}
		.tips .back-btn{
			display: block;
			height: 40px;
			line-height: 40px;
			width: 110px;
			margin:0 auto;
			text-align: center;
			color: #fff;
			text-decoration: none;
			background-color: #FF7A08;
			-webkit-border-radius: 20px;
			-moz-border-radius: 20px;
			-ms-border-radius: 20px;
			-o-border-radius: 20px;
			border-radius: 20px;
			margin-top: 30px;
		}
	</style>
</head>
<body>
	<div class="error">
		<div class="tips">
			<h4>遇到错误啦~</h4>
			<p>服务器内部错误，正在抢修中...</p>
			<a href="/manage/index/index" class="back-btn">返回首页</a>
		</div>
	</div>
</body>
</html><?php }} ?>
