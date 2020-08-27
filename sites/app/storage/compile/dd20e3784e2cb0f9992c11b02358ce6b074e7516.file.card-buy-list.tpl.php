<?php /* Smarty version Smarty-3.1.17, created on 2020-04-08 01:01:41
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/giftcard/card-buy-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13917696705e8cb1f554c247-86654438%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dd20e3784e2cb0f9992c11b02358ce6b074e7516' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/giftcard/card-buy-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13917696705e8cb1f554c247-86654438',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'number' => 0,
    'start' => 0,
    'end' => 0,
    'list' => 0,
    'val' => 0,
    'key' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8cb1f558cca3_23516649',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8cb1f558cca3_23516649')) {function content_5e8cb1f558cca3_23516649($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">

<style>
    .table.table-button tbody>tr>td{
        line-height: 33px;
    }
    .modal-dialog{
        width: 400px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    #sample-table-1{
        border: none;
    }

    .search-btn button{
        display: inline-block;
        margin-left: 5px;
    }


</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div style="margin-left: 130px">
    <div class="page-header search-box" style="margin-bottom: 20px;margin-top: 0;">
        <div class="col-sm-12">
            <form class="form-inline" action="/wxapp/giftcard/cardBuyList" method="get">
                <div class="col-xs-10 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">礼品卡名称</div>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">卡号</div>
                                <input type="text" name="number" id="number" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['number']->value;?>
">
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">购买时间起</div>
                                <input class='form-control' id='start' type="text" name="start" autocomplete="off" readonly="true" value='<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">购买时间止</div>
                                <input class='form-control' id='end' type="text" name="end"  autocomplete="off" readonly="true" value='<?php echo $_smarty_tpl->tpl_vars['end']->value;?>
'>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-2 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                    <button type="button" class="btn btn-primary btn-sm btx-excel">导出</button>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive" id="content-con">
                <table id="sample-table-1" class="table table-hover table-button">
                    <thead>
                    <tr>
                        <th>卡号</th>
                        <th>礼品卡名称</th>
                        <th>购买人</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            购买时间
                        </th>
                        <th>
                            状态
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['agcb_id'];?>
" <?php if (($_smarty_tpl->tpl_vars['key']->value%2==1)) {?>class="info"<?php } else { ?><?php }?>>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agcb_number'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agcb_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agct_m_nickname'];?>
</td>
                            <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['agcb_create_time']);?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['agcb_status']==1) {?>
                                <span class="font-color-audit">未激活</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['agcb_status']==2) {?>
                                <span class="font-color-pass">已激活</span>
                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['agcb_status']==3) {?>
                                <span class="font-color-refuse">已用完</span>
                                <?php }?>
                            </td>
                        </tr>
                        <?php } ?>
                        <tr><td colspan="5"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src='/public/plugin/laydate/laydate.js'></script>
<script type="text/javascript">
    laydate.render({
        elem: '#start'
    });
    laydate.render({
        elem: '#end'
    });

    $('.btx-excel').click(function () {
        let name = $('#name').val();
        let number = $('#number').val();
        let start = $('#start').val();
        let end = $('#end').val();

        if(!start || !end){
            layer.msg('请选择完整的购买时间');
            return false;
        }
        window.location.href='/wxapp/giftcard/cardBuyExcel?name='+name+'&number='+number+'&start='+start+'&end='+end;
    });



</script>


<?php }} ?>
