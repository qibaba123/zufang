<?php /* Smarty version Smarty-3.1.17, created on 2020-04-03 10:02:54
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/member-incre.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3272558855e86994e4ecca5-10011194%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c528cb593f361e47beb5016542865c5e99ec6ccc' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/member-incre.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3272558855e86994e4ecca5-10011194',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'member_incre' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e86994e53e0f0_60206141',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e86994e53e0f0_60206141')) {function content_5e86994e53e0f0_60206141($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/seqstatistics/css/member-incre.css">
<div class='panel panel-default'>
    <div class='panel-body'>
        <form class='form-inline text-right' action='/wxapp/seqstatistics/memberIncrease' method='get'>
            <!-- 按天计算 -->
            <div class='form-group'>
                <select id='day' class="form-control" name="day">
                    <option <?php if ($_GET['day']==7) {?>selected<?php }?> value="7">7天</option>
                    <option <?php if ($_GET['day']==14) {?>selected<?php }?> value="14">14天</option>
                    <option <?php if ($_GET['day']==30) {?>selected<?php }?> value="30">30天</option>
                    <option  <?php if ($_GET['day']=='') {?>selected<?php }?> value=''>按日期</option>
                </select>
            </div>
            <!-- 年份计算 -->
            <div class='form-group'>
                <input type="hidden" id='year_hidden' value='<?php echo $_GET['year'];?>
'>
                <select id='year' name="year">
                    <option value="">年份</option>
                </select>
            </div>
            <!-- 月份计算 -->
            <div class='form-group'>
                <select id='month' class="form-control" name="month">
                    <option value="">月份</option>
                    <option <?php if ($_GET['month']==1) {?>selected<?php }?> value="1">1月</option>
                    <option <?php if ($_GET['month']==2) {?>selected<?php }?> value="2">2月</option>
                    <option <?php if ($_GET['month']==3) {?>selected<?php }?> value="3">3月</option>
                    <option <?php if ($_GET['month']==4) {?>selected<?php }?> value="4">4月</option>
                    <option <?php if ($_GET['month']==5) {?>selected<?php }?> value="5">5月</option>
                    <option <?php if ($_GET['month']==6) {?>selected<?php }?> value="6">6月</option>
                    <option <?php if ($_GET['month']==7) {?>selected<?php }?> value="7">7月</option>
                    <option <?php if ($_GET['month']==8) {?>selected<?php }?> value="8">8月</option>
                    <option <?php if ($_GET['month']==9) {?>selected<?php }?> value="9">9月</option>
                    <option <?php if ($_GET['month']==10) {?>selected<?php }?> value="10">10月</option>
                    <option <?php if ($_GET['month']==11) {?>selected<?php }?> value="11">11月</option>
                    <option <?php if ($_GET['month']==12) {?>selected<?php }?> value="12">12月</option>
                </select>
            </div>
            <button type='submit' class='btn btn-sm btn-info'>搜索</button>
        </form>
    </div>
</div>
<div class='panel panel-default'>
    <div class='panel-heading'>趋势图</div>
    <div class='panel-body'>
        <div id='echart'></div>
    </div>
</div>
<input type="hidden" id='echart-x' value='<?php echo $_smarty_tpl->tpl_vars['member_incre']->value['xaxis'];?>
'>
<input type="hidden" id='echart-y' value='<?php echo $_smarty_tpl->tpl_vars['member_incre']->value['yaxis'];?>
'>
<script src="https://cdn.bootcss.com/echarts/4.2.1-rc1/echarts.min.js"></script>
<script src="/public/wxapp/seqstatistics/js/seqstatistics.js"></script>
<?php }} ?>
