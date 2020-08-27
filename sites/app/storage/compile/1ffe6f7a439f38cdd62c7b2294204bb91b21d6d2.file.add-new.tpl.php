<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 11:15:13
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/limit/add-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18997899585e4df9c169b631-59667206%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1ffe6f7a439f38cdd62c7b2294204bb91b21d6d2' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/limit/add-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18997899585e4df9c169b631-59667206',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'appletCfg' => 0,
    'row' => 0,
    'banEdit' => 0,
    'customShare' => 0,
    'goodsName' => 0,
    'goods' => 0,
    'val' => 0,
    'value' => 0,
    'paginator' => 0,
    'showExample' => 0,
    'example_list' => 0,
    'example' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df9c17407e0_78146542',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df9c17407e0_78146542')) {function content_5e4df9c17407e0_78146542($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    .add-gift{
        padding-top: 10px;
    }
    .info-title{
        padding:10px 0;
        border-bottom: 1px solid #eee;
    }
    .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .input-table{
        width: 100%;
    }
    .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .input-table label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 130px;
        line-height: 34px;
    }
    .input-table .form-control{
        width: 290px;
        height: 34px;
    }
    .Wdate{
        border-color: #ccc;
    }
    .input-table textarea.form-control{
        width: 100%;
        max-width: 750px;
        height: auto;
    }
    .input-table .form-control.spinner-input{
        width: 55px;
        border-color: #dfdfdf;
    }
    .Wdate{
        background-position: 98% center;
    }
    .full-minus-item,.product-item{
        padding: 10px;
        position: relative;
        border: 1px solid #e8e8e8;
        -webkit-border-radius: 4px;
        -ms-border-radius: 4px;
        border-radius: 4px;
        overflow: hidden;
        max-width: 750px;
        padding-right: 45px;
        margin-bottom: 10px;
        min-width: 650px;
    }
    .delete{
        font-size: 22px;
        font-weight: 700;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: .2;
        filter: alpha(opacity=20);
        position: absolute;
        top: 14px;
        right: 10px;
    }
    .delete:hover{
        opacity: .6;
        filter: alpha(opacity=60);
    }

    .item-wrap{
        font-size: 0;
    }
    .full-minus-item .item-wrap b,.product-item .item-wrap b{
        margin:0 5px;
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span,.product-item .item-wrap span,.product-item .item-wrap div{
        display: inline-block;
        vertical-align: middle;
        font-size: 14px;
    }
    .full-minus-item .item-wrap span input,.product-item .item-wrap span input{
        width: 150px;
        font-size: 14px;
    }
    .product-item .item-wrap .good-name-box{
        text-align: left;
        width: 50%;
    }
    .product-item .item-wrap .good-name-box .good-name{
        margin:0;
        padding: 0 5px;
        font-size: 14px;
        width: 95%;
        margin-left: 5px;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .modal-body .table-responsive{
        width: 100%;
    }

    /*选择全部或指定商品*/
    .choose-goodrange{
        padding-top: 5px;
    }
    .choosegoods{
        padding: 5px 0;
    }
    .choosegoods .tip{
        font-size: 12px;
        color: #999;
        margin:0;
    }
    .choosegoods>div{
        display: none;
    }
    .add-good-box .btn{
        margin-top: 10px;
    }
    .add-good-box .table{
        max-width: 1150px;
        margin: 10px 0 0;
    }
    .add-good-box .table thead tr th{
        border-right: 0;
        padding: 8px 10px;
        vertical-align: middle;
    }
    .add-good-box .table tbody tr td{
        padding: 6px 10px;
        vertical-align: middle;
        white-space: normal;
    }
    .left{
        text-align: left;
    }
    .center{
        text-align: center;
    }
    .right{
        text-align: right;
    }
    td.goods-info p{
        height: 20px;
        line-height: 20px;
        margin:0;
    }
    td.goods-info p span{
        display: inline-block;
        vertical-align: middle;
    }
    td.goods-info p span.good_name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 220px;
        margin-right: 3px;
    }
    td.goods-info p span.good_price{
        color: #FF6600;
    }
    .add-good-box .table span.del-good{
        color: #38f;
        font-weight: bold;
        cursor: pointer;
    }
    .good-item .input-group{
        width: 110px;
        margin:0 auto;
    }
    .good-item .input-group input.form-control{
        width: 45px;
        padding: 6px 3px;
        text-align: center;
    }
    .good-item .input-group input.form-control.red{
        color: #FF6600!important;
    }
    td.goods-info p {
        height: 20px;
        line-height: 20px;
        margin: 0;
        width: 300px;
    }
    td.goods-info p span.good_name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 220px;
        margin-right: 3px;
    }

    .good-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .good-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
    .add-gift{min-width:700px;overflow-x: auto;}
    .goodshow-list .format-item{
        background: #eee;
    }

    td.format-info p{
        height: 20px;
        line-height: 20px;
        margin:0;
    }
    td.format-info p span{
        display: inline-block;
        vertical-align: middle;
    }
    td.format-info p span.good_name{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 270px;
        margin-right: 3px;
    }
    td.format-info p span.good_price{
        color: #FF6600;
    }
    .format-item .input-group{
        width: 110px;
        margin:0 auto;
    }
    .format-item .input-group input.form-control{
        width: 45px;
        padding: 6px 3px;
        text-align: center;
    }
    .format-item .input-group input.form-control.red{
        color: #FF6600!important;
    }
    td.format-info p {
        height: 20px;
        line-height: 20px;
        margin: 0;
        width: 300px;
    }
    td.format-info p span.format_name {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        width: 225px;
        margin-right: 3px;
    }

    .format-item .input-group .input-group-addon:first-child{
        border-top-left-radius: 4px!important;
        border-bottom-left-radius: 4px!important;
    }
    .format-item .input-group .input-group-addon:last-child{
        border-top-right-radius: 4px!important;
        border-bottom-right-radius: 4px!important;
    }
    .example-box{

    }
    .example-box input{
        display: inline-block !important;
        margin-right: 10px;
    }
    .example-item{
        margin: 8px 0;
    }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>




<div class="add-gift" id="div-add" style="margin-left: 150px">
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
    <div class="alert alert-block alert-warning">
        活动开始后，可修改活动标题、标签、虚拟案例，不能修改其他信息。
    </div>
    <?php }?>

<h4 class="info-title"><span id="show_title">添加限时抢购活动</span></h4>
<input type="hidden" id="id"  class="form-control" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['la_id'];?>
<?php }?>"/>
<input type="hidden" id="ban-edit"  class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['banEdit']->value;?>
"/>

<table class="input-table">
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动名称:</label></td>
        <td><input type="text" id="name"  class="form-control" placeholder="请输入活动名称" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['la_name'];?>
<?php }?>"/></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>开始时间:</label></td>
        <td><input id="start_time" type="text" placeholder="请选择开始时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'%y-%M-%d',maxDate:'#F{$dp.$D(\'end_time\')}'})" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['la_start_time']);?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>结束时间:</label></td>
        <td><input id="end_time" type="text" placeholder="请选择结束时间" class="Wdate form-control" onClick="WdatePicker({startDate:'%y-%M-%d 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'start_time\') || (\'%y-%M-%d\')}'})" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['row']->value['la_end_time']);?>
<?php }?>" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>></td>
    </tr>
    <tr>
        <td class="label-td"><label><span class="red">*</span>活动标签:</label></td>
        <td><input type="text" id="label"  class="form-control" placeholder="请填写活动标签" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['la_label'];?>
<?php }?>"/></td>
    </tr>
    <tr <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36) {?>style="display:none"<?php }?>>
        <td class="label-td"><label>是否参与分佣:</label></td>
        <td>
            <div class="radio-box">
                <span>
                    <input type="radio" name="ignore_deduct" id="ignore_yes" value="0" <?php if ($_smarty_tpl->tpl_vars['row']->value['la_ignore_deduct']!=1) {?>checked<?php }?> <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                    <label for="ignore_yes">参与分佣（团长有佣金）</label>
                </span>
                <span>
                    <input type="radio" name="ignore_deduct" id="ignore_no" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value['la_ignore_deduct']==1) {?>checked<?php }?> <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                    <label for="ignore_no">不参与分佣（团长无佣金）</label>
                </span>
            </div>
        </td>
    </tr>

    <?php if ($_smarty_tpl->tpl_vars['customShare']->value==1) {?>
    <tr>
        <td class="label-td"><label>分享图片:</label></td>
        <td><img onclick="toUpload(this)"
                 data-limit="1"
                 data-width="500"
                 data-height="400"
                 data-dom-id="share_image"
                 id="share_image"
                 placeholder="请上传分享图片"
                 data-need="required"
                 data-dfvalue="/public/manage/img/zhanwei/zw_fxb_45_45.png"
                 src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['la_share_img']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['la_share_img'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>"  style="display:inline-block;width:100px;height: auto;"  class="avatar-field bg-img img-thumbnail" >
            <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="500" data-height="400" data-dom-id="share_image">修改<small>(尺寸：500*400)</small></a></td>
    </tr>
    <tr>
        <td class="label-td"><label>分享标题:</label></td>
        <td><input type="text" id="share_title"  class="form-control" placeholder="分享标题" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['la_share_title'];?>
<?php }?>"/></td>
    </tr>
    <?php }?>
    <tr>
        <td class="label-td"><label><span class="red">*</span>抢购<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
:</label></td>
        <td class="text-left">
            <div class="choose-goodrange">
                <div class="assigngood-tip" data-type="assign" style="display: block;">
                <div class="add-good-box">
                    <div class="goodshow-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left" style="width: 40%;">
                                    <?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
名称
                                </th>
                                <th class="center">限购</th>
                                <th class="center">优惠</th>
                                <th class="center">数量</th>
                                <th class="center">虚拟销量</th>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                <th class="center">浏览量</th>
                                <?php }?>
                                <th class="right">操作</th>
                            </tr>
                            </thead>
                            <tbody id="can-limit-goods">
                                <?php if ($_smarty_tpl->tpl_vars['goods']->value) {?>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goods']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <tr class="good-item">
                                    <td class="goods-info goods-name" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['gid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
"><p><span class="good_name"><?php echo $_smarty_tpl->tpl_vars['val']->value['gname'];?>
</span><span class="good_price">￥<?php echo $_smarty_tpl->tpl_vars['val']->value['gprice'];?>
</span></p></td>
                                    <td>
                                       <div class="input-group">
                                            <span class="input-group-addon">限　购（0表示不限购）</span>
                                            <input type="text" class="form-control goods-limit" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['limit'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">件</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">减价后</span>
                                            <input type="text" class="form-control red goods-price" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['price'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">元</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">共</span>
                                            <input type="text" class="form-control red goods-stock" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['stock'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">件 <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12) {?>（0表示取<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
库存）<?php }?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">已售</span>
                                            <input type="text" class="form-control red goods-sold" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['sold'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">件</span>
                                        </div>
                                    </td>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control red goods-view-num" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['viewNum'];?>
">
                                            <span class="input-group-addon">
                                                <label style="margin: 0;width: 40px;height: 20px;">
                                                    <input name="viewNumShow" class="ace ace-switch ace-switch-5 goods-view-num-show" <?php if (($_smarty_tpl->tpl_vars['val']->value&&$_smarty_tpl->tpl_vars['val']->value['viewNumShow'])||!$_smarty_tpl->tpl_vars['val']->value) {?>checked<?php }?> type="checkbox" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                                    <span class="lbl" style="position: relative;top: -7px;left: -10px;"></span>
                                                </label>
                                            </span>
                                        </div>
                                    </td>
                                    <?php }?>
                                    <td class="right">
                                        <?php if ($_smarty_tpl->tpl_vars['banEdit']->value!=1) {?>
                                        <span class="del-good" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['gid'];?>
">删除</span>
                                        <?php }?>
                                    </td>
                                </tr>
                                <?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['val']->value['format']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value) {
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
                                <tr class="format-item format<?php echo $_smarty_tpl->tpl_vars['val']->value['gid'];?>
">
                                    <td class="format-info format-name" data-id="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" data-gfid="<?php echo $_smarty_tpl->tpl_vars['value']->value['gfid'];?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
"><p><span class="format_name"><?php echo $_smarty_tpl->tpl_vars['value']->value['name'];?>
</span><span class="good_price">￥<?php echo $_smarty_tpl->tpl_vars['value']->value['gfprice'];?>
</span></p></td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">减价后</span>
                                            <input type="text" class="form-control red format-price" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['price'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">元</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-addon">共</span>
                                            <input type="text" class="form-control red format-stock" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['stock'];?>
" <?php if ($_smarty_tpl->tpl_vars['banEdit']->value==1) {?> disabled="disabled" <?php }?>>
                                            <span class="input-group-addon">件 <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=12) {?>（0表示取<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
库存）<?php }?></span>
                                        </div>
                                    </td>
                                    <td>
                                    </td>
                                    <td>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php } ?>
                                <?php }?>
                            </tbody>
                        </table>
                         <?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>

                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['banEdit']->value!=1) {?>

                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==12) {?>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitCourse()">+添加<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
</div>
                    <?php } else { ?>
                    <div class="btn btn-xs btn-primary" data-toggle="modal" data-target="#goodsList" onclick="addLimitGoodNew()">+添加<?php echo $_smarty_tpl->tpl_vars['goodsName']->value;?>
</div>
                    <?php }?>

                    <?php }?>
                </div>
            </div>
            </div>
            </div>
        </td>
    </tr>


    <tr <?php if ($_smarty_tpl->tpl_vars['showExample']->value!=1) {?> style="display:none"<?php }?> >
        <td class="label-td"><label>虚拟案例:</label></td>
        <td>
            <button class="btn btn-xs btn-warning example-add" onclick="addExample()" style="margin-top: 5px">+添加案例</button>
            <div class="example-box">
                <?php  $_smarty_tpl->tpl_vars['example'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['example']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['example_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['example']->key => $_smarty_tpl->tpl_vars['example']->value) {
$_smarty_tpl->tpl_vars['example']->_loop = true;
?>
                <div class="example-item">
                    <input type='hidden' value='<?php echo $_smarty_tpl->tpl_vars['example']->value['lfe_id'];?>
' class='example-id'>
                    标题：<input type='text' class='form-control example-title' value='<?php echo $_smarty_tpl->tpl_vars['example']->value['lfe_title'];?>
' placeholder='请填写案例标题'>售出数量：<input type='number' class='form-control example-num' value='<?php echo $_smarty_tpl->tpl_vars['example']->value['lfe_num'];?>
' placeholder='请填写售出数量'>时间：<input type='text' placeholder='请选择时间' class='form-control example-time' onClick='WdatePicker({dateFmt:"yyyy-MM-dd"})' value='<?php echo $_smarty_tpl->tpl_vars['example']->value['lfe_time'];?>
'><button class='btn btn-xs btn-danger example-delete' onclick="removeExample(this)">删除</button>
                </div>
                <?php } ?>
            </div>
        </td>
    </tr>

    <tr>
        <td class="label-td"><label><span class="red">&nbsp;</td>
        <td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 活 动 </a></td>
    </tr>

</table>
</div>
<!--添加礼物结束-->
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script src="/public/manage/assets/js/fuelux/fuelux.spinner.min.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("../modal-gift-select.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript">
    var acType = "<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_type'];?>
";
    var currSid = "<?php echo $_smarty_tpl->tpl_vars['appletCfg']->value['ac_s_id'];?>
";
    $(function(){
        // 删除选择的商品
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
            var gid = $(this).data('gid');
            $('.format'+gid).remove();
            // if(length<=1){
            // 	goodListElem.stop().hide();
            // }
        });
    });

    $('.btn-save').on('click',function(){
        var customShare = '<?php echo $_smarty_tpl->tpl_vars['customShare']->value;?>
';
        if(customShare == '1'){
            var field = new Array('name','start_time','end_time','label','share_title');
        }else{
            var field = new Array('name','start_time','end_time','label');
        }

        var data  = {};
        for(var i=0; i < field.length; i++){
            var temp = $('#'+field[i]).val();
            if(temp){
                data[field[i]] = temp
            }else{
                var msg = $('#'+field[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        data.id   	= $('#id').val();
        if(customShare == '1'){
            var imgField   =  new Array('share_image');
            for(var j=0; j<imgField.length; j++){
                var imgTemp = $('#'+imgField[j]).attr('src');
                var df      = $('#'+imgField[j]).data('dfvalue');
                if(imgTemp && df != imgTemp){
                    data[imgField[j]] = imgTemp
                }else{

                }
            }
        }


        var goods = {},g=0;
        $('#can-limit-goods').find('.good-item').each(function(){
            var _this = $(this);
            var gid = _this.find('.goods-info').data('gid');
            var limit = _this.find('.goods-limit').val();
            var price = _this.find('.goods-price').val();
            var stock = _this.find('.goods-stock').val();
            var sold = _this.find('.goods-sold').val();
            var viewNum = _this.find('.goods-view-num').val();
            var viewNumShow = _this.find('.goods-view-num-show:checked').val();

            var format = [];
            $('.format'+gid).each(function () {
               format.push({
                   'id' : $(this).find('.format-info').data('gfid'),
                   'price' : $(this).find('.format-price').val(),
                   'stock' : $(this).find('.format-stock').val(),
               });
            });
            if(gid){
                goods['go_'+g] = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    'name'	: $(this).find('.goods-info').data('gname'),
                    'limit' : limit,
                    'price' : price,
                    'stock' : stock,
                    'sold' : sold,
                    'viewNum' : viewNum,
                    'viewNumShow' : viewNumShow=='on'?1:0,
                    'format': format
                };
                g++;
            }
        });

        console.log(goods);
        //培训版 餐饮版 预约版 必须设置秒杀数量
        for(var i in goods){
            if(acType == '12' || acType == '4' || acType == '7' || acType == '18'){
                if(goods[i].stock <=0 ){
                    layer.msg('请填写商品数量');
                    return false;
                }
            }
        }
        data.goods = goods;

        var exampleArr = [];
        var exampleRow = '';
        $('.example-item').each(function(){
            exampleRow = {
                'id': $(this).find('.example-id').val(),
                'title': $(this).find('.example-title').val(),
                'num': $(this).find('.example-num').val(),
                'time': $(this).find('.example-time').val(),
            };
            exampleArr.push(exampleRow);
        });
        if(exampleArr.length > 0){
            for (let i=0;i<exampleArr.length;i++){
                if(!exampleArr[i].title){
                    layer.msg('请填写案例标题');
                    return;
                }
                if(exampleArr[i].num <= 0){
                    layer.msg('请填写案例售出数量');
                    return;
                }
                if(!exampleArr[i].time){
                    layer.msg('请填写案例时间');
                    return;
                }
            }
        }

        data.exampleList = exampleArr;
        console.log(exampleArr);

        //社区团购是否分佣
        var ignore_deduct = $('input[name="ignore_deduct"]:checked').val();
        var banEdit = $('#ban-edit').val();
        data.ignoreDeduct = ignore_deduct;
        data.banEdit = banEdit;
        //保存信息
        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var loading = layer.load(10, {
	            shade: [0.6,'#666']
	        });
	        $.ajax({
	            'type'  : 'post',
	            'url'   : '/wxapp/limit/saveLimit',
	            'data'  : data,
	            'dataType' : 'json',
	            'success'   : function(ret){
	                layer.close(loading);
	                layer.msg(ret.em);
	                if(ret.ec == 200){
	                    window.location.href='/wxapp/limit/index'
	                }
	            }
	        });
        },function () {
            console.log(data);
        });

    });
    
    function removeExample(e) {
        $(e).parent().remove();
    }
    
    function addExample() {
        var example_html = getExampleHtml();
        $('.example-box').append(example_html);
    }
    
    function getExampleHtml() {
       var example_html = "<div class='example-item'><input type='hidden' value='0' class='example-id'>标题：<input type='text' class='form-control example-title' value='' placeholder='请填写案例标题'>售出数量：<input type='number' class='form-control example-num' value='' placeholder='请填写售出数量'>时间：<input type='text' placeholder='请选择时间' class='form-control example-time' onClick=\"WdatePicker({dateFmt:'yyyy-MM-dd'})\" value=''><button class='btn btn-xs btn-danger example-delete' onclick='removeExample(this)'>删除</button></div>";
       return example_html;
    }
    
</script><?php }} ?>
