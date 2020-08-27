<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 16:37:38
         compiled from "/mnt/www/default/duodian/tdtinstall/error/500.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4714674705dea13523fc869-26726221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '72e4260efadd08b795be18db54df0b9ec4653384' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/error/500.tpl',
      1 => 1560823962,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4714674705dea13523fc869-26726221',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'app_name' => 0,
    'err' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea135244a045_72268035',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea135244a045_72268035')) {function content_5dea135244a045_72268035($_smarty_tpl) {?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0"/>
    <title><?php echo $_smarty_tpl->tpl_vars['app_name']->value;?>
</title>
    <style>
        body, p, input, h1, h2, h3, h4, h5, h6, ul, li, dl, dt, dd, form { margin: 0; padding: 0; list-style: none; vertical-align: middle; font-weight:normal; }
        img { border:0; margin: 0; padding: 0;  }
        body { color: #333; -webkit-user-select: none; -webkit-text-size-adjust: none; font:normal 16px/200% "微软雅黑", helvetica, arial; text-align:left;   }
        header, section, footer { display: block; margin: 0; padding: 0 }
        a{text-decoration:none;color:#333;}

        html{
            width: 100%;
        }
        body{
            width:100%;
            margin:0 auto;
            background-color: #F4F4F4;
            font-size: 14px;
        }
        table,td,th{
            border-collapse:collapse;
        }
        .container{
            width: 90%;
            margin:0 auto;
            background-color: #fff;
        }
        .report{
            margin-top: 6%;
        }
        .report h3{
            color: #fff;
            background-color: #0099CB;
            padding:5px 20px;
            font-size: 16px;
            overflow: hidden;
            height: 30px;
        }
        .report-content{
            padding:5px 20px;
        }
        .report-content .username{
            font-size: 20px;
            letter-spacing: 1px;
            font-weight: bold;
            padding:3px 0;
        }
        .report-content .username span{
            font-size:16px;
            color: #497BA1;
            font-weight: bold;
        }
        .report-content .tip-txt{
            font-size: 14px;
            color: #666;
            line-height: 1.5;
            letter-spacing: 0.5px;
            margin:3px 0;
        }
        .report-content .error-data p{
            font-weight: bold;
            letter-spacing: 1px;
            font-size: 15px;
        }
        .report-content .error-data table{
            border:1px solid #E3E3E3;
            width: 100%;
            table-layout:fixed;
            word-break:break-all;
        }
        .report-content .error-data table td{
            font-size: 14px;
            border-bottom: 1px solid #e3e3e3;
            padding:7px 0;
            padding-left: 20px;
            line-height: 1.5;
        }
        .report-content .error-data table td.title{
            text-align: center;
            color: #fff;
            background-color: #0099CB;
            border-bottom:1px solid #fff;
            width: 100px;
            padding-left: 0;
        }
        .report-content .error-data .from-tdot{
            line-height: 70px;
            font-weight: bold;
            font-size: 16px;
            color: #3F3F3F;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="report">
        <h3><?php echo $_smarty_tpl->tpl_vars['app_name']->value;?>
错误分析报告</h3>
        <div class="report-content">
            <p class="username">您好：</span></p>
            <p class="tip-txt">您的应用<?php echo $_smarty_tpl->tpl_vars['app_name']->value;?>
在<?php echo $_smarty_tpl->tpl_vars['err']->value['errortime'];?>
产生错误信息，下面是错误详细报告</p>
            <div class="error-data">
                <p>错误数据分析</p>
                <table border="1" cellpadding="0" cellspacing="0" >
                    <tr>
                        <td class="title">错误号</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errornum'];?>
</td>
                    </tr>
                    <tr>
                        <td class="title">错误类型</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errortype'];?>
</td>
                    </tr>
                    <tr>
                        <td class="title">错误信息</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errormsg'];?>
</td>
                    </tr>
                    <tr>
                        <td class="title">文件名</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errorfile'];?>
</td>
                    </tr>
                    <tr>
                        <td class="title">文件行数</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errorline'];?>
</td>
                    </tr>
                    <tr>
                        <td class="title">错误发送时间</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['err']->value['errortime'];?>
</td>
                    </tr>
                </table>
                <p class="from-tdot">来自郑州天点科技有限公司</p>
            </div>
        </div>
    </div>
</div>
</body>
</html><?php }} ?>
