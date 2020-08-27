<?php /* Smarty version Smarty-3.1.17, created on 2020-02-22 11:14:07
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/goods-trans.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5053304655e509c7f78c655-15795739%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aa8d267c4add826b4b7fe3c2e93e94e5740a68ec' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/seqstatistics/goods-trans.tpl',
      1 => 1575020196,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5053304655e509c7f78c655-15795739',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'search_box' => 0,
    'trans_list' => 0,
    'item' => 0,
    'showPage' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e509c7f7ebf81_95502027',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e509c7f7ebf81_95502027')) {function content_5e509c7f7ebf81_95502027($_smarty_tpl) {?><link rel="stylesheet" type="text/css" href="/public/wxapp/seqstatistics/css/goods-trans.css">
<style type="text/css">
    #form .label{
        height: 25px;
        line-height: 1.4;
        padding: 4px 12px;
        cursor: pointer;
        background-color: #abbac3 !important;
    }
    #form .active{
        background-color: #3a87ad !important;
    }
    .font-bold{
        font-size: 14px;
    }
</style>
<?php if ($_smarty_tpl->tpl_vars['search_box']->value==1) {?>
<!-- 是否开启了商品访问的细粒度设置项 -->
<div class='panel panel-default'>
    <div class='panel-body text-right'>
        <div class='row'>
            <div class='col-xs-8 text-left'>
                <form id='form' class='form-inline'>
                    <span name='all' class="search label label-info <?php if ($_GET['start']=='all'||$_GET['start']=='') {?>active<?php }?>">全部</span>
                    <span name='today' class="search label label-info  <?php if ($_GET['start']=='today') {?>active<?php }?>">今日</span>
                    <span name='yesterday' class="search label label-info <?php if ($_GET['start']=='yesterday') {?>active<?php }?>">昨日</span> 
                    <span name='week' class="search label label-info  <?php if ($_GET['start']=='week') {?>active<?php }?>">近7日</span>
                    <span name='month' class="search label label-info  <?php if ($_GET['start']=='month') {?>active<?php }?>">近30日</span>&nbsp;&nbsp;
                    <div class='form-group'>
                        <input name='start' type="text" id="start" class='form-control' placeholder="开始时间" value='<?php if (!in_array($_GET['start'],array("today","yesterday","week","month","all"))) {?><?php echo $_GET['start'];?>
<?php }?>' autocomplete='off'>
                    </div>
                    <div class='form-group'>
                        <input name='end' type="text" id="end" class='form-control' placeholder="结束时间" value='<?php echo $_GET['end'];?>
' autocomplete='off'>
                    </div>
                    <button type='submit' class='btn btn-info btn-sm' id='dateGroup'>查询</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php }?>
<div class='help-block text-right'>
    <!-- <small class='text-warning'>*仅统计已完成订单数据*</small> -->
    <a href="/wxapp/seqstatistics/goodsTrans" class='btn btn-sm btn-warning'>
        <?php if ($_GET['finish_only']!=1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>全部
    </a>
    <a href="/wxapp/seqstatistics/goodsTrans?finish_only=1" class='btn btn-sm btn-warning'>
        <?php if ($_GET['finish_only']==1) {?>
        <i class="icon-ok-sign"></i>
        <?php }?>仅显示已完成订单
    </a>
</div>
<table class='table table-hover'>
    <thead>
        <tr>
            <th>商品名称</th>
            <th>访问次数</th>
            <th>购买件数</th>
            <th style='width:300px;'>转换率</th>
        </tr>
    </thead>
    <tbody>
        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['trans_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
            <tr>
                <td>
                    <div class='flex'>
                        <p>
                            <img class='goods-img' src="<?php echo $_smarty_tpl->tpl_vars['item']->value['g_cover'];?>
">
                        </p>
                        <p>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['g_name'];?>

                        </p>
                    </div>
                </td>
                <td>
                    <span class='font-bold'><?php echo $_smarty_tpl->tpl_vars['item']->value['g_show_real_num'];?>
</span>
                </td>
                <td>
                   <span class='font-bold'> <?php if ($_smarty_tpl->tpl_vars['item']->value['num']) {?> <?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
<?php } else { ?>0<?php }?></span>
                </td>
                <td>
                    <p class='font-bold'>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['g_show_real_num']==0&&$_smarty_tpl->tpl_vars['item']->value['num']!=0) {?>
                            100%
                        <?php } else { ?>
                            <?php echo sprintf("%.2f",($_smarty_tpl->tpl_vars['item']->value['num']/$_smarty_tpl->tpl_vars['item']->value['g_show_real_num']*100));?>
%
                        <?php }?>
                    </p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['g_show_real_num']==0&&$_smarty_tpl->tpl_vars['item']->value['num']!=0) {?>
                        100%;
                        <?php } else { ?>
                        <?php echo sprintf("%.2f",($_smarty_tpl->tpl_vars['item']->value['num']/$_smarty_tpl->tpl_vars['item']->value['g_show_real_num']*100));?>

                        <?php }?>
                        "
                        aria-valuemin="0" aria-valuemax="100" style="width:
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['g_show_real_num']==0&&$_smarty_tpl->tpl_vars['item']->value['num']!=0) {?>
                        100%;
                        <?php } else { ?>
                        <?php echo sprintf("%.2f",($_smarty_tpl->tpl_vars['item']->value['num']/$_smarty_tpl->tpl_vars['item']->value['g_show_real_num']*100));?>
%
                        <?php }?>"></div>
                    </div>
                </td>
            </tr>
            <?php } ?>
    </tbody>
</table>
<!--<div class='text-right'>
   
</div>-->
<?php if ($_smarty_tpl->tpl_vars['showPage']->value!=0) {?>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</div>
            </div>
        </div>
    </div>
</div>
<?php }?>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
    $(function(){
        laydate.render({
          elem: '#start' 
        });
        laydate.render({
          elem: '#end' 
        });
        $('.search').click(function(){
            let search_type=$(this).attr('name');
            if(search_type=='all')
                 location.href='/wxapp/seqstatistics/goodsTrans';
            else
                location.href='/wxapp/seqstatistics/goodsTrans?start='+search_type;
        });
    })
</script>
<?php }} ?>
