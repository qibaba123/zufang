<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 19:20:07
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/card-use-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20523016625e4e6b6767b481-75316817%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '561b6ef5c1503b4d80338e15cc20e4b72d7959ec' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/giftcard/card-use-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20523016625e4e6b6767b481-75316817',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'name' => 0,
    'shopName' => 0,
    'start' => 0,
    'end' => 0,
    'list' => 0,
    'val' => 0,
    'key' => 0,
    'paginator' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4e6b676ba8f9_93601060',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4e6b676ba8f9_93601060')) {function content_5e4e6b676ba8f9_93601060($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/groupControl/css/style.css">
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
            <form class="form-inline" action="/wxapp/giftcard/cardUseList" method="get">
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
                                <div class="input-group-addon">店铺名称</div>
                                <input type="text" name="shopName" id="shopName" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['shopName']->value;?>
">
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">核销时间起</div>
                                <input class='form-control' id='start' type="text" name="start" autocomplete="off" readonly="true" value='<?php echo $_smarty_tpl->tpl_vars['start']->value;?>
'>
                            </div>
                        </div>
                        <div class='form-group'>
                            <div class="input-group">
                                <div class="input-group-addon">核销时间止</div>
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
                        <th>礼品卡名称</th>
                        <th>核销门店</th>
                        <th>用户头像</th>
                        <th>用户昵称</th>
                        <th>核销金额</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            核销时间
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
                        <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['agcu_id'];?>
" <?php if (($_smarty_tpl->tpl_vars['key']->value%2==1)) {?>class="info"<?php } else { ?><?php }?>>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agcb_name'];?>
</td>
                            <td>
                                <?php if ($_smarty_tpl->tpl_vars['val']->value['agcu_verify_role']==1) {?>
                                    平台
                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['agcu_verify_role']==2) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>

                                <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['agcu_verify_role']==3) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['os_name'];?>

                                <?php }?>
                            </td>
                            <td><img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['agcu_m_avatar'];?>
" alt="" style="width: 50px"></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agcu_m_nickname'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['val']->value['agcu_money'];?>
</td>
                            <td><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['agcu_create_time']);?>
</td>

                        </tr>
                        <?php } ?>
                        <tr><td colspan="6"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
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
        let shopName = $('#shopName').val();
        let start = $('#start').val();
        let end = $('#end').val();

        if(!start || !end){
            layer.msg('请选择完整的核销时间');
            return false;
        }
        window.location.href='/wxapp/giftcard/cardUseExcel?name='+name+'&shopName='+shopName+'&start='+start+'&end='+end;
    });



</script>


<?php }} ?>
