<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:55:06
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goods/goods-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16807516165e4df50a4565a7-01106091%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82f3689e8445ba9bd63a938ef07bd9ecde61f23f' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/goods/goods-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16807516165e4df50a4565a7-01106091',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'isActivity' => 0,
    'backUrl' => 0,
    'row' => 0,
    'appletCfg' => 0,
    'showUnit' => 0,
    'pickupTime' => 0,
    'ac_type' => 0,
    'types' => 0,
    'key' => 0,
    'val' => 0,
    'independent' => 0,
    'tempList' => 0,
    'messageListData' => 0,
    'slide' => 0,
    'goodsList' => 0,
    'goods' => 0,
    'spec' => 0,
    'dataList' => 0,
    'messageList' => 0,
    'vipPriceList' => 0,
    'levelList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df50a598808_30284762',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df50a598808_30284762')) {function content_5e4df50a598808_30284762($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<?php if ($_smarty_tpl->tpl_vars['isActivity']->value==1) {?>
    <?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<style type="text/css">
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

    table {
        width: 100%;
        border: 1px solid #ecedf0;
        border-radius: 2px;
        table-layout: fixed;
        background: #fff;
        text-align: center;
    }

    table th {
        background: #f7f7f7;
        height: 50px;
        line-height: 50px;
        color: #404040;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        position: relative;
        font-weight: 400;
        text-align: center;
    }

    table td.border-right {
        border-right: 1px solid #ecedf0;
        text-align: center;
    }

    table td {
        border-top: 1px solid #ecedf0;
        height: 52px;
        line-height: 22px;
        color: #666;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        word-wrap: break-word;
        border-right: 1px solid #ecedf0;
    }

    table td .form-control {
        max-width: 100%;
    }

    .delete {
        height: 25px;
        line-height: 25px;
        text-align: center;
        width: 25px;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 22px;
        font-weight: 900;
        cursor: pointer;
    }

    .modal-dialog{
        width: 700px;
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
    .goods-selected{
        padding: 5px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }
    .add-related-box{
        text-align: center;
    }
    .related-info{
        margin-bottom: 10px;
        height: 35px;
        line-height: 35px;
    }
    .btn-remove-info{

    }
    .related-info-cate{
        width: 35%;
        float: left;
        margin-right: 10px;
    }
    .related-info-detail{
        width: 49%;
        float: left;
        margin-right: 20px;
    }
</style>

<?php echo $_smarty_tpl->getSubTemplate ("../article-ue-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div  id="mainContent" ng-app="chApp" ng-controller="chCtrl">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="<?php echo $_smarty_tpl->tpl_vars['backUrl']->value;?>
"> 返回 </a></small> | 新增/编辑商品信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
                                    <ul class="wizard-steps">
                                        <!--
                                        <li data-target="#step1"  <?php if ($_smarty_tpl->tpl_vars['row']->value) {?>class="complete" <?php } else { ?>class="active"<?php }?>>
                                        <span class="step">1</span>
                                        <span class="title">商品类目</span>
                                        </li>
                                        -->
                                        <li data-target="#step1" <?php if ($_smarty_tpl->tpl_vars['row']->value) {?>class="complete" <?php } else { ?>class="active"<?php }?>>
                                        <span class="step">1</span>
                                        <span class="title">基本信息</span>
                                        </li>

                                        <li data-target="#step2">
                                            <span class="step">2</span>
                                            <span class="title">商品图片</span>
                                        </li>

                                        <li data-target="#step3">
                                            <span class="step">3</span>
                                            <span class="title">商品详情</span>
                                        </li>
                                    </ul>
                                </div>

                                <hr />
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_id'];?>
<?php } else { ?>0<?php }?>">
                 
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>商品名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写商品名称" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_name'];?>
<?php }?>">
                                                            </div>
                                                        </div>
                                                        <?php if (($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8)||($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6&&$_smarty_tpl->tpl_vars['row']->value['g_es_id']>0)) {?>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>价格是否面议：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" ng-model="isDiscuss" name="g_is_discuss" id="discuss1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_discuss']==1) {?>checked<?php }?>>
                                                                        <label for="discuss1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_is_discuss" ng-model="isDiscuss" id="discuss2" value="0"  <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_discuss']==1)) {?>checked<?php }?>>
                                                                        <label for="discuss2">否</label>
                                                                    </span>
                                                                </div>
                                                                <p class="tip" style="max-width: 520px">请不要将用于拼团,秒杀,砍价等活动中的商品改为价格面议</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ori-price-form" ng-show=" isDiscuss == '1' ">
                                                            <label class="control-label">面议补充提示：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_discuss_info" name="g_discuss_info" placeholder="面议补充提示" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_discuss_info'];?>
<?php }?>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                    
                                                        <?php if ($_smarty_tpl->tpl_vars['showUnit']->value==1) {?>
                                                        <div class="form-group">
                                                            <label class="control-label">商品单位：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_unit_name" name="g_unit_name" placeholder="" maxlength="5" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_unit_name'];?>
<?php }?>"  style="width:160px;">
                                                            </div>
                                                            <span style="margin-left:150px">如"个"、"件"等</span>
                                                        </div>
                                                        <?php }?>
                                                        <div class="form-group">
                                                            <label class="control-label">单人限购：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_limit" name="g_limit" placeholder="不限购则为填写“0”" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_limit'];?>
<?php }?>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 单人限购表示该商品对单人总限购数，0表示不限购</span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">单人单日限购：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_day_limit" name="g_day_limit" placeholder="不限购则为填写“0”" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_day_limit'];?>
<?php }?>"  style="width:160px;">
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 单人单日限购表示该商品对每人每天的限购数，0表示不限购</span>
                                                        </div>
                                                        <?php if ($_smarty_tpl->tpl_vars['pickupTime']->value==1) {?>
                                                        <div class="form-group price-form">
                                                            <label class="control-label">发货/提货时间：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="sequence_day" name="sequence_day" placeholder=""  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_sequence_day'];?>
<?php }?>"  style="width:160px;display: inline-block">
                                                                <span>天，不填写或0则表示当天</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">显示发货/提货时间：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_sequence_day_show" class="ace ace-switch ace-switch-5" id="g_sequence_day_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_sequence_day_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>商品信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">销量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_sold" name="g_sold" placeholder="请填写销量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_sold'];?>
<?php }?>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">销量显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_sold_show" class="ace ace-switch ace-switch-5" id="g_sold_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_sold_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">访问量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_show_num" name="g_show_num" placeholder="请填写访问量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_show_num'];?>
<?php }?>" style="width: 160px;">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">访问量显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_show_num_show" class="ace ace-switch ace-switch-5" id="g_show_num_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_show_num_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">小程序商品列表显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_applay_goods_show" class="ace ace-switch ace-switch-5" id="g_applay_goods_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_applay_goods_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <?php if ($_smarty_tpl->tpl_vars['ac_type']->value==21) {?>
                                                        <!--营销商城-添加起购数量-->
                                                        <div class="form-group">
                                                            <label class="control-label">起购数量：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_small_num" name="g_small_num" placeholder="请填写起购数量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_small_num'];?>
<?php } else { ?>1<?php }?>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <?php }?>

                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>商品类型：</label>
                                                            <div class="control-group">
                                                                <select id="g_type" name="g_type" class="form-control">
                                                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['types']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                                                    <option <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_type']==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <?php if (!($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8&&$_smarty_tpl->tpl_vars['row']->value['g_es_id']>0)&&!($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6&&$_smarty_tpl->tpl_vars['row']->value['g_es_id']>0)&&!($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==33&&$_smarty_tpl->tpl_vars['row']->value['g_es_id']>0)) {?>
                                                        <div class="form-group">
                                                            <label for="kind2" class="control-label">商品分类：</label>
                                                            <div class="control-group" id="customCategory">

                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_weight'];?>
<?php } else { ?>1<?php }?>" name="g_weight" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font><?php if ($_smarty_tpl->tpl_vars['independent']->value!=1) {?>首页<?php }?>推荐商品：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_is_top" id="recommend1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_top']==1) {?>checked<?php }?>>
                                                                        <label for="recommend1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_is_top" id="recommend2" value="0"  <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_top']==1)) {?>checked<?php }?>>
                                                                        <label for="recommend2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品标签：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_custom_label" name="g_custom_label" placeholder="请填写商品标签,不同标签以空格隔开"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_custom_label'];?>
<?php }?>" >
                                                                <p class="tip">不同标签以空格隔开</p>
                                                            </div>
                                                            <label class="control-label">商品列表标签：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_list_label" name="g_list_label" placeholder="请填写商品列表标签，最多4个字"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_list_label'];?>
<?php }?>" >
                                                                <p class="tip">商品列表标签最多4个字</p>
                                                            </div>
                                                        </div>
                                                        <?php if (!($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6&&$_smarty_tpl->tpl_vars['row']->value['g_es_id']>0)) {?>
                                                        <div class="form-group">
                                                            <label class="control-label">全球购商品：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_is_global" id="global1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_global']==1) {?>checked<?php }?>>
                                                                        <label for="global1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_is_global" id="global2" value="0"  <?php if (!($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_global']==1)) {?>checked<?php }?>>
                                                                        <label for="global2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <span style="color: red;margin-left:150px">注: 设置为全球购商品是需要购买者提供身份证信息</span>
                                                        </div>
                                                        <?php }?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>库存/规格</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>商品规格：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_format_type" id="g_format_type1" value="0" ng-model="hasFormat">
                                                                        <label for="g_format_type1">单规格</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_format_type" id="g_format_type2" value="1" ng-model="hasFormat">
                                                                        <label for="g_format_type2">多规格</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div ng-show="hasFormat==0">
                                                            <div class="form-group ori-price-form" ng-show=" isDiscuss != '1' ">
                                                                <label class="control-label">商品原价：</label>
                                                                <div class="control-group">
                                                                    <input type="text" class="form-control" id="g_ori_price" name="g_ori_price" placeholder="原价" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_ori_price'];?>
<?php }?>" style="width:160px;">
                                                                </div>
                                                            </div>
                                                            <div class="form-group price-form" ng-show=" isDiscuss != '1' ">
                                                                <label class="control-label"><font color="red">*</font>商品售价：</label>
                                                                <div class="control-group">
                                                                    <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写商品售价"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_price'];?>
<?php }?>"  style="width:160px;">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><font color="red">*</font>商品重量：</label>
                                                                <div class="control-group" style="position: relative">
                                                                    <input type="text" class="form-control" id="g_goods_weight" name="g_goods_weight" placeholder="请填写商品重量,选填/Kg"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_goods_weight'];?>
<?php }?>"  style="width:160px;">
                                                                    <select id="g_goods_weight_type" name="g_goods_weight_type" class="form-control" style="width: 60px;position: absolute;left: 170px;top: 0;">
                                                                        <option value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_goods_weight_type']==1) {?>selected<?php }?>>g</option>
                                                                        <option value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_goods_weight_type']==2) {?>selected<?php }?>>Kg</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label"><font color="red">*</font>商品库存：</label>
                                                                <div class="control-group">
                                                                    <input type="text" class="form-control" id="g_stock" name="g_stock" placeholder="商品库存数量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_stock'];?>
<?php } else { ?>99<?php }?>"  style="width:160px;">
                                                                    <!--
                                                                    <p class="tip">
                                                                        添加规格以后库存数量不更手动更改
                                                                    </p>
                                                                    -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>库存显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input class="ace ace-switch ace-switch-5" name="g_stock_show" id="g_stock_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_stock_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div ng-show="hasFormat==1">
                                                            <div class="form-group">
                                                                <label for="name" class="control-label">商品规格：</label>
                                                                <div class="control-group" style="border: 1px solid #ccc;" ng-if="spec.length>0">
                                                                    <div ng-repeat="s in spec" ng-init="fIndex = $index" style="position:relative;background: #fff;border-bottom: 1px solid #ccc;padding: 10px;">
                                                                        <div class="delete" ng-click="delIndex('spec',$index)">×</div>
                                                                        <div style="margin-bottom: 10px;">
                                                                            <input type="text" ng-model="s.name" class="form-control"  />
                                                                        </div>
                                                                        <div ng-repeat="value in s.value track by $index" style="position:relative;display: inline-block;width=100px;margin-bottom: 10px;">
                                                                            <div class="delete" ng-click="delValueIndex('spec',s.value, $index)"  style="top: 5px; right: 10px">×</div>
                                                                            <input type="text" ng-model="value.name" class="form-control" style="margin-bottom: 10px;" />
                                                                            <div ng-if="fIndex==0">
                                                                                <img onclick="toUpload(this)" onload="changeSrc(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-format_cover{{$index}}" imageonload="doThis('spec',fIndex,$index)" id="upload-format_cover{{$index}}"  src="{{value.img?value.img:'/public/manage/img/zhanwei/zw_fxb_45_45.png'}}"  style="display:inline-block;margin-left:0;width: 143px">
                                                                                <input type="hidden" id="format_cover{{$index}}"  class="avatar-field bg-img" ng-value="value.img"/>
                                                                            </div>
                                                                        </div>
                                                                        <div ng-click = "addSpecValue($index)" style="display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;">添加规格值</div>
                                                                    </div>
                                                                    <div ng-if="spec.length<3&&spec.length>0" ng-click="addSpec()" style="background: #fff;display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;margin: 10px">添加规格</div>
                                                                </div>
                                                                <div ng-if="spec.length<3&&spec.length<1" ng-click="addSpec()" style="background: #fff;display: inline-block;border: 1px solid #ccc;padding: 5px 10px;border-radius: 4px;">添加规格</div>
                                                            </div>
                                                            <div class="form-group" ng-if="spec.length>0">
                                                                <label for="name" class="control-label">规格明细：</label>
                                                                <div class="control-group">
                                                                    <table >
                                                                        <thead>
                                                                            <th ng-repeat="s in spec" ng-if="s.value.length>0">{{s.name}}</th>
                                                                            <?php if (!$_smarty_tpl->tpl_vars['row']->value['g_es_id']) {?>
                                                                            <th>原价</th>
                                                                            <?php }?>
                                                                            <th>价格</th>
                                                                            <th>重量</th>
                                                                            <th>库存</th>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr ng-repeat="data in dataList track by $index" ng-init="trIndex = $index">
                                                                                <td ng-repeat="d in data.spec track by $index" rowspan="{{rowspan[$index]}}" ng-if="trIndex % rowspan[$index]==0">{{d.name}}</td>
                                                                                <?php if (!$_smarty_tpl->tpl_vars['row']->value['g_es_id']) {?>
                                                                                <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.oriPrice" /></td>
                                                                                <?php }?>
                                                                                <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.price" /></td>
                                                                                <td>
                                                                                    <input type="text" class="form-control" placeholder="选填/Kg" style="max-width: 58%;float: left;margin-right: 2%" ng-model="data.weight" />
                                                                                    <select id="g_goods_weight_type" name="g_goods_weight_type" class="form-control" ng-model="data.weightType" style="max-width: 40%">
                                                                                        <option value="1">g</option>
                                                                                        <option value="2">Kg</option>
                                                                                    </select>
                                                                                </td>
                                                                                <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.stock" /></td>
                                                                            </tr>
                                                                        </tbody>
                                                                        <tfoot ng-if="dataList[0].spec.length > 0">
                                                                           <tr>
                                                                               <td colspan="{{dataList[0].spec.length}}"> 批量设置：</td>
                                                                               <td>
                                                                                   <input type="number" class="form-control" id="batch-oriPrice-value" style="display: inline-block;width: 60%">
                                                                                   <a href="javascript:;" ng-click="batchSet('oriPrice')">确定</a></td>
                                                                               <td>
                                                                                   <input type="number" class="form-control" id="batch-price-value" style="display: inline-block;width: 60%">
                                                                                   <a href="javascript:;" ng-click="batchSet('price')">确定</a>
                                                                               </td>
                                                                               <td>
                                                                                   <input type="number" class="form-control" id="batch-weight-value" style="display: inline-block;width: 30%">
                                                                                   <select id="batch-weight-type-value" class="form-control"  style="display: inline-block;width: 30%">
                                                                                       <option value="1">g</option>
                                                                                       <option value="2">Kg</option>
                                                                                   </select>
                                                                                   <a href="javascript:;" ng-click="batchSet('weight')">确定</a>
                                                                               </td>
                                                                               <td>
                                                                                   <input type="number" class="form-control" id="batch-stock-value" style="display: inline-block;width: 60%">
                                                                                   <a href="javascript:;" ng-click="batchSet('stock')">确定</a>
                                                                               </td>
                                                                           </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>物流其它</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">运费方式：</label>
                                                            <div class="control-group" style="height:50px">
                                                                <div class="radio-box col-xs-2"  style="width:172px;">
                                                                    <span>
                                                                        <input type="radio" name="g_expfee_type" id="g_expfee_type1" value="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&($_smarty_tpl->tpl_vars['row']->value['g_expfee_type']==1||$_smarty_tpl->tpl_vars['row']->value['g_expfee_type']==0)) {?>checked<?php }?>>
                                                                        <label for="g_expfee_type1">统一运费</label>
                                                                    </span>
                                                                </div>
                                                                <div class="input-group col-xs-3"  style="width:160px;">
                                                                    <div class="input-group-addon">￥</div>
                                                                    <input type="text" class="form-control" name="g_unified_fee" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_unified_fee'];?>
<?php }?>"  placeholder="统一运费费用">
                                                                </div>
                                                            </div>
                                                            <div class="control-group" >
                                                                <div class="radio-box col-xs-2"  style="width:172px;">
                                                                    <span>
                                                                        <input type="radio" name="g_expfee_type" id="g_expfee_type2"  value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_expfee_type']==2) {?>checked<?php }?>  <?php if (count($_smarty_tpl->tpl_vars['tempList']->value)==0) {?>disabled="disabled"<?php }?>>
                                                                        <label for="g_expfee_type2">运费模板</label>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                    <select name="g_unified_tpid" id="g_unified_tpid" class="form-control">
                                                                        <option value="0">请选择运费模板</option>
                                                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['tempList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                                                        <option <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_unified_tpid']==$_smarty_tpl->tpl_vars['val']->value['sdt_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['sdt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['sdt_name'];?>
</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <div class="help-inline">
                                                                        <a href="/wxapp/delivery/add" target="_blank" class="new-window" style="float: right;position: relative;top: -23px;">新建</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">运费显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_expfee_show" class="ace ace-switch ace-switch-5" id="g_expfee_show" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_expfee_show'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">是否参与会员折扣：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_join_discount" class="ace ace-switch ace-switch-5" id="g_join_discount" <?php if (($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_join_discount'])||!$_smarty_tpl->tpl_vars['row']->value) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--<div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>留言</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group" ui-sortable ng-model="messageList">
                                                                    <div class="panel" ng-repeat="message in messageList track by $index">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" ng-click="delIndex('messageList',$index)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-2">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <input type="text"  maxlength="5" style="width: 100%;max-width: 100%"  class="form-control" ng-model="message.name">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <select class="form-control" ng-model="message.type" style="width: 100%;max-width: 100%"   ng-options="x.type as x.name for x in messageType" ></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3" ng-if="message.type!='image'">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <input type="text"  style="width: 100%;max-width: 100%" placeholder="提示文本" class="form-control" ng-model="message.placeholder">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-3">
                                                                                    <div class="input-group">
                                                                                        <label for=""  style="padding: 6px 3px">
                                                                                            <input type="checkbox" name="require" ng-model="message.require"  ng-checked="message.require"> 必填
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='text'">
                                                                                            <input type="checkbox" name="date" ng-model="message.multi"  ng-checked="message.multi"> 多行
                                                                                        </label>
                                                                                        <label for=""  style="padding: 6px 3px" ng-if="message.type=='time'">
                                                                                            <input type="checkbox" name="date" ng-model="message.date"  ng-checked="message.date"> 日期
                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" ng-click="addMessage()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加字段</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==7) {?>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>下单留言</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">留言模板：</label>
                                                            <div class="control-group">
                                                                <div class="col-xs-4">
                                                                    <select name="g_message_tpid" id="g_message_tpid" class="form-control">
                                                                        <option value="0">请选择留言模板</option>
                                                                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['messageListData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                                                    <option <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_message_tpid']==$_smarty_tpl->tpl_vars['val']->value['amt_id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['amt_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['amt_name'];?>
</option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <div class="help-inline">
                                                                        <a href="/wxapp/goods/addMessageList" target="_blank" class="new-window" style="float: right;position: relative;top: -23px;">新建</a>
                                                                    </div>
                                                                    <p class="tip">若未设置模板可点击右侧新建模板</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>

                                            <!-- 营销商城添加自提商品字段 -->
                                            <!--
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                                <div class='info-group-box'>
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>商品自提</span>
                                                        </div>
                                                        <div class="group-info">
                                                            <div class="form-group">
                                                                <label for="name" class="control-label">可否自提：</label>
                                                                <div class="control-group">
                                                                    <div class="col-xs-4">
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="pick_goods_self"  value="1" 
                                                                            <?php if ($_smarty_tpl->tpl_vars['row']->value['g_pick_self']==1||$_smarty_tpl->tpl_vars['row']->value['g_pick_self']=='') {?>checked<?php }?>
                                                                            > 是
                                                                        </label>
                                                                        <label class="radio-inline">
                                                                            <input type="radio" name="pick_goods_self" value="2"
                                                                             <?php if ($_smarty_tpl->tpl_vars['row']->value['g_pick_self']==2) {?>checked<?php }?>
                                                                            > 否
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php }?>
                                            -->
                                            <!--<div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>会员价</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <div class="panel" ng-repeat="price in vipPriceList track by $index">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" ng-click="delIndex('vipPriceList',$index)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-6">
                                                                                    <div class="input-group " style="width: 100%">
                                                                                        <span class="col-xs-4" style="display: inline-block;margin-top: 5px;">会员身份：</span>
                                                                                        <select class="form-control col-xs-6" ng-model="price.identity" style="width: 60%;max-width: 100%"   ng-options="x.ml_id as x.ml_name for x in levelList" ></select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-6" ng-if="message.type!='image'">
                                                                                    <div class="input-group" style="width: 100%">
                                                                                        <span class="col-xs-4" style="display: inline-block;margin-top: 5px;">会员价：</span>
                                                                                        <input type="text"  style="width: 60%;max-width: 100%" placeholder="提示文本" class="form-control col-xs-6" ng-model="price.price">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" ng-click="addVipPrice()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加会员价</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->

                                        </div>
                                        <div class="step-pane" id="step2">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">商品封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素，商品封面图可选，默认取幻灯第一张图片</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover" id="upload-g_cover"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php }?>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover">修改</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">商品幻灯图(<small>最多五张，尺寸 640 x 640 像素</small>)</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['slide']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<?php echo $_smarty_tpl->tpl_vars['val']->value['gs_path'];?>
"  layer-pid="" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['gs_path'];?>
" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="slide_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gs_path'];?>
">
                                                                    <input type="hidden" id="slide_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" name="slide_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gs_id'];?>
">
                                                                    <input type="hidden" id="slide_sort_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="slide-sort" name="slide_sort_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gs_sort'];?>
">
                                                                </p>
                                                                <?php } ?>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<?php if ($_smarty_tpl->tpl_vars['slide']->value) {?><?php echo count($_smarty_tpl->tpl_vars['slide']->value);?>
<?php } else { ?>0<?php }?>" placeholder="控制图片张数">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="info-group-box">
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>视频地址</span>
                                                        </div>
                                                        <div class="group-info">
                                                            <div class="form-group">
                                                                <div class="control-group" style="margin-left: 0px">
                                                                    <input type="text" class="form-control" id="g_video" name="g_video" placeholder="请填写视频地址" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_video_url'];?>
<?php }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>VR全景</span>
                                                        </div>
                                                        <div class="group-info">
                                                            <div class="form-group">
                                                                <div class="control-group" style="margin-left: 0px">
                                                                    <input type="text" class="form-control" id="g_vr" name="g_vr" placeholder="请填写VR全景连接" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_vr_url'];?>
<?php }?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="info-group-box">
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>商品参数</span>
                                                        </div>
                                                        <div class="group-info">
                                                            <div class="form-group">
                                                            <div class="control-group" style="margin-left: 0px">
                                                                <!--<textarea class="form-control" style="width:850px;height:400px;visibility:hidden;" id = "g_parameter" name="g_parameter" placeholder="商品参数"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_parameter']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_parameter'];?>
<?php }?>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_parameter" />-->
                                                                <textarea style="width:100%;height:350px;" id="g_parameter" name="g_parameter" placeholder="商品参数"  rows="20" style=" text-align: left; resize:vertical;" ><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_parameter']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_parameter'];?>
<?php }?></textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_parameter" />
                                                            </div>
                                                </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="step-pane" id="step3">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>简介详情</span>
                                                    </div>
                                                    <div class="group-info">

                                                        <div class="form-group">
                                                            <label class="control-label">商品简介：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" name="g_brief" placeholder="商品简介" style="max-width: 850px;"><?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_brief'];?>
<?php }?></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="control-label">商品详情：</label>
                                                            <div class="control-group">
                                                                <!--<textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="商品详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_detail']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_detail'];?>
<?php }?>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" />-->
                                                                <textarea style="width:100%;height:350px;" id="g_detail" name="g_detail" placeholder="商品详情"  rows="20" style=" text-align: left; resize:vertical;" ><?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_detail']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_detail'];?>
<?php }?></textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>推荐商品</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="part" style="overflow: hidden;padding-bottom: 10px">
                                                                <div style="width: 78%;float: left;">
                                                                    <label for="">推荐商品</label>
                                                                </div>
                                                                <div style="width: 18%;float: right;">
                                                                    <label for=""><span>
                                                                        <button class="btn btn-sm btn-primary goods-button btn-goods">添加</button>
                                                                        <button class="btn btn-sm btn-danger goods-button btn-remove-all">清空</button>
                                                                    </span></label>
                                                                </div>
                                                            </div>
                                                            <div class="topic goods-selected-list">
                                                                <?php if ($_smarty_tpl->tpl_vars['goodsList']->value) {?>
                                                                <?php  $_smarty_tpl->tpl_vars['goods'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['goods']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['goodsList']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['goods']->key => $_smarty_tpl->tpl_vars['goods']->value) {
$_smarty_tpl->tpl_vars['goods']->_loop = true;
?>
                                                                <div class='goods-name goods-selected' gid='<?php echo $_smarty_tpl->tpl_vars['goods']->value['g_id'];?>
' ><div class='goods-selected-name'><?php echo $_smarty_tpl->tpl_vars['goods']->value['g_name'];?>
</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>
                                                                <?php } ?>
                                                                <?php } else { ?>
                                                                <span class="goods-name goods-none" style="font-weight: bold;color: #38f">
                                                                    无推荐商品
                                                                </span>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php }?>
                                        </div>

                                    </form>
                                </div>

                                <hr />
                                <div class="row-fluid wizard-actions">
                                    <button class="btn btn-primary" onclick="javascript:window.history.back();">
                                        返回列表页
                                    </button>
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_verify_apply_time']==0) {?>
                                    <button class="btn btn-primary" ng-click="saveData()">
                                        保存
                                    </button>
                                    <?php }?>
                                    <button class="btn btn-prev">
                                        <i class="icon-arrow-left"></i>
                                        上一步
                                    </button>

                                    <button class="btn btn-success btn-next" data-last="完成">
                                        下一步
                                        <i class="icon-arrow-right icon-on-right"></i>
                                    </button>
                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<div id="goods-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">推荐商品</h4>
            </div>
            <div class="modal-body">
                <div class="good-search" style="margin-top: 20px">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control" placeholder="搜索商品">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr>
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <thead>
                    <tr>
                        <th>商品图片</th>
                        <th style="text-align:left">商品名称</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="goods-tr">
                    <!--商品列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript">
    var addImageWater = 1;
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.spec = <?php echo $_smarty_tpl->tpl_vars['spec']->value;?>
;
        $scope.isDiscuss = '<?php echo $_smarty_tpl->tpl_vars['row']->value['g_is_discuss'];?>
';
        console.log($scope.spec);
        $scope.dataList=<?php echo $_smarty_tpl->tpl_vars['dataList']->value;?>
;
        console.log($scope.dataList);
        $scope.rowspan = [];
        $scope.messageList = <?php echo $_smarty_tpl->tpl_vars['messageList']->value;?>
;
        //$scope.vipPriceList = <?php echo $_smarty_tpl->tpl_vars['vipPriceList']->value;?>
;
        $scope.levelList = <?php echo $_smarty_tpl->tpl_vars['levelList']->value;?>
;
        $scope.hasFormat ='<?php echo $_smarty_tpl->tpl_vars['row']->value['g_has_format'];?>
'!=0?1:0;
        $scope.messageType = [
            {
                'type': 'text',
                'name': '文本格式'
            },
            {
                'type': 'number',
                'name': '数字格式'
            },
            {
                'type': 'email',
                'name': '邮箱'
            },
            {
                'type': 'date',
                'name': '日期'
            },
            {
                'type': 'time',
                'name': '时间'
            },
            {
                'type': 'idcard',
                'name': '身份证号'
            },
            {
                'type': 'image',
                'name': '图片'
            },
            {
                'type': 'mobile',
                'name': '手机号'
            }
        ];
        $scope.addSpec = function(){
            var data = {
                'name': '颜色',
                'value': []
            };
            $scope.spec.push(data);
        };
        $scope.addMessage = function () {
            var data = {
                'name': '留言',
                'type': 'text',
                'multi': false,
                'require': false,
                'date' : false
            };
            $scope.messageList.push(data);
            console.log($scope.messageList);
        };
        $scope.addVipPrice = function () {
            var data = {
                'identity': 0,
                'price': 0,
            };
            $scope.vipPriceList.push(data);
        };
        $scope.addSpecValue = function(index){
            var data = {
                'name':'规格值',
                'img' : '/public/manage/img/zhanwei/zw_fxb_45_45.png'
            };
            if(index>0 &&$scope.spec[(index - 1)].value.length==0){
                layer.msg('请先添加上级规格值')
            }else{
                $scope.spec[index].value.push(data);
            }
        };

        //监听sb变量的变化，并在变化时更新DOM
        $scope.$watch('spec',function(n,o){
            var n = 0;
            if($scope.spec.length==0){
                $scope.dataList = [];
                $scope.rowspan = [];
            }

            if(($scope.spec.length==1)||($scope.spec.length==2&&$scope.spec[1].value.length==0) || ($scope.spec.length==3&&$scope.spec[2].value.length==0&&$scope.spec[1].value.length==0)){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    $scope.dataList[n] = {
                        'spec': [$scope.spec[0].value[i]],
                        'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                        'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                        'stock': $scope.dataList[n]?$scope.dataList[n].stock:99,
                        'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                        'weightType': $scope.dataList[n]?$scope.dataList[n].weightType:'1',
                    }
                    n++;
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [1];
            }
            if(($scope.spec.length==2 && $scope.spec[1].value.length>0)||($scope.spec.length==3&&$scope.spec[2].value.length==0)){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        $scope.dataList[n] = {
                            'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j]],
                            'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                            'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                            'stock': $scope.dataList[n]?$scope.dataList[n].stock:99,
                            'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                            'weightType': $scope.dataList[n]?$scope.dataList[n].weightType:'1',
                        }
                        n++
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length>0?$scope.spec[1].value.length:1, 1];
            }
            if($scope.spec.length==3 && $scope.spec[2].value.length>0){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        for(var k=0;k<$scope.spec[2].value.length;k++){
                            $scope.dataList[n] = {
                                'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j],$scope.spec[2].value[k]],
                                'oriPrice': $scope.dataList[n]?$scope.dataList[n].oriPrice:0,
                                'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                                'stock': $scope.dataList[n]?$scope.dataList[n].stock:99,
                                'weight': $scope.dataList[n]?$scope.dataList[n].weight:0,
                                'weightType': $scope.dataList[n]?$scope.dataList[n].weightType:'1',
                            }
                            n++;
                        }
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length*($scope.spec[2].value.length>0?$scope.spec[2].value.length:1), $scope.spec[2].value.length>0?$scope.spec[2].value.length:1, 1];
            }
            console.log($scope.dataList);
            console.log($scope.rowspan);
        },true);

        $scope.doThis=function(type,findex,index){
            $scope[type][findex].value[index].img = imgNowsrc;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
            console.log(index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(index,1);
                });
                layer.msg('删除成功');
            })
        }

        /*删除规格值元素*/
        $scope.delValueIndex=function(type,value,sindex){
            var index=0
            for(var i=0; i<$scope[type].length; i++){
                if($scope[type][i].value == value){
                    index = i;
                }
            }
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type][index].value.splice(sindex,1);
                    if($scope[type][index].value.length<1){
                        $scope[type].splice(index,1);
                    }
                });
                layer.msg('删除成功');
            })
        }

        //批量设置
        $scope.batchSet = function(type){

            var value = $('#batch-'+type+'-value').val();
            if(type=='weight'){
                var weightType = $('#batch-weight-type-value').val();
            }

            for (var i=0; i< $scope.dataList.length; i++){
                $scope.dataList[i][type] = value;
                if(weightType){
                    $scope.dataList[i]['weightType'] = weightType;
                }
            }
        }


        // 保存数据
        $scope.saveData = function(){
            console.log($('#goods-form').serialize());
            var g_applay_goods_show = $('input[name="g_applay_goods_show"]:checked').length > 0 ? '' : '&g_applay_goods_show=off';
            console.log(g_applay_goods_show);
            //console.log(JSON.stringify($scope.spec));
            //console.log(JSON.stringify($scope.dataList));
            var gids     = [];
            if($scope.hasFormat == 0){
                $scope.dataList = [];
                $scope.spec = [];
            }
            //保存推荐商品
            $('.goods-selected').each(function () {
                var gid = $(this).attr('gid');
                gids.push(gid)
            });
            var load_index = layer.load(
                    2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/goods/newSave',
                'data'  : $('#goods-form').serialize()+'&formatType='+JSON.stringify($scope.spec)+'&formatList='+JSON.stringify($scope.dataList)+'&gids='+JSON.stringify(gids)+g_applay_goods_show,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 && ret.id > 0){
                        $('#hid_id').val(ret.id);
                    }
                    //window.location.reload();
                }
            });
        };

        jQuery(function($) {
            $('#slide-img').sortable().bind('sortupdate', function () {
                changeSortable();
            });
            $('.edui-for-insertimage').on('click',function(event) {
                $('.webuploader-pick').text('点击选择图片'+ '<span style="font-size: 12px;">（建议尺寸750*550）</span>');
                console.log('点击选择图片'+ '<span style="font-size: 12px;">（建议尺寸750*550）</span>');
            });


            $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
                console.log(info.step);
                /*  去掉商品类目不再做验证*/
                /*
                 if(info.step == 1 && info.direction == 'next') {
                 if(!checkCategory()) return false;
                 }else
                 */
                if(info.step == 1 && info.direction == 'next'){
                    if(!checkBasic()) return false;
                }else if(info.step == 2 && info.direction == 'next'){
                    if(!checkImg()) return false;
                }
            }).on('finished', function(e) {
                //saveGoods('step');
                $scope.saveData();
            });

            $('.product-leibie').on('click', 'li', function(event) {
                $(this).addClass('selected').siblings('li').removeClass('selected');
                var id = $(this).data('id');
                $('#g_c_id').val(id);
            });
            formatSort();
            //获取自定义商品分类
            var kind = 0 ;
            <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_kind2']) {?>
            kind = <?php echo $_smarty_tpl->tpl_vars['row']->value['g_kind2'];?>
;
            <?php }?>
            customerGoodsCategory(kind,'<?php echo $_smarty_tpl->tpl_vars['independent']->value;?>
');

            // 初始化库存是否可输入
            var panelLen = parseInt($("#panel-group").find('.panel').length);
            if(panelLen>0){
                //$("#g_stock").attr("readonly",true);
            }
            // 统计商品规格所有库存
            $("#panel-group").on('input propertychange', 'input[name^="format_stock"]', function(event) {
                event.preventDefault();
                var that = $(this);
                var parElem = that.parents('#panel-group');
                var sumStock = 0;
                parElem.find('input[name^="format_stock"]').each(function(index, el) {
                    sumStock += parseInt($(this).val());
                });
                $("#g_stock").val(sumStock);
            });
            // 商品标签选择
            $(".goods-tagbox").on('click', 'span', function(event) {
                event.preventDefault();
                var _this = $(this);
                $(this).toggleClass('active');
                $(this).parents('.goods-tagbox').find('span').each(function(index, el) {
                    var id = $(this).data('id');
                    if($(this).hasClass('active')){
                        $("#good_tag_"+id).val(1);
                    }else{
                        $("#good_tag_"+id).val(0);
                    }
                });
            });
        });
    }]);

    //管理商品
    $('.btn-goods').on('click',function(){
        //初始化
        var num = $('.goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');

        $('.th-weight').hide();

        $('#goods-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage);
    });

    function fetchGoodsPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/giftGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealGoods( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }

    //选择关联商品
    function dealGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
            $('.goods-selected-list').html(default_html);
        }
    }

    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
    });

    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    /**
     * 第一步检查商品类目
     * */
    function checkCategory(){
        var temp = $('#g_c_id').val();
        if(!temp){
            var msg = $('#g_c_id').attr('placeholder');
            layer.msg(msg);
            return false;
        }
        return true;
    }

    /**
     * 第二步检查基本信息
     * */
    function checkBasic(){
        var format = $('#format-num').val();
        var check   = new Array('g_name','g_price','g_stock');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp && format == 0){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        var discount = $('#g_vip_discount').val();
        if(discount > 100 || discount < 1){
            layer.msg('VIP折扣1－100之间整数');
            return false
        }
        return true;
    }

    /**
     * 第三步，检查图片
     * @returns {boolean}
     */
    function checkImg(){
        var g_cover = $('#g_cover').val();
        /*if(!g_cover){
            layer.msg('请上传封面图');
            return false;
        }*/
        var slide = 0;
        for(var i=0;i<=4;i++){
            var temp = $('#slide_'+i).val();
            if(temp) {
                slide = parseInt(slide) + 1;
                console.log(slide);
            }
        }
        if(slide == 0){
            layer.msg('请上传幻灯');
            return false;
        }
        return true;
    }

    /**
     * 保存商品信息
     */
//    /*function saveGoods(type){
//        var load_index = layer.load(
//                2,
//                {
//                    shade: [0.1,'#333'],
//                    time: 10*1000
//                }
//        );
//        $.ajax({
//            'type'   : 'post',
//            'url'   : '/wxapp/goods/save',
//            'data'  : $('#goods-form').serialize(),
//            'dataType'  : 'json',
//            'success'   : function(ret){
//                layer.close(load_index);
//                if(ret.ec == 200 && type == 'step'){
//                    window.location.href='/wxapp/goods/index';
//                }else{
//                    layer.msg(ret.em);
//                }
//            }
//        });
//    }*/
    /**
     * 图片结果处理
     * @param allSrc
     */
   function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '<input type="hidden" id="slide_sort_'+key+'" class="slide-sort" name="slide_sort_'+key+'" value="'+key+'">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).append(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
    /**
     * 图片删除功能
     * 以图片容器为准，容器中的图片img标签结果<div><p><img>
     */
//    $(".pic-box").on('click', '.delimg-btn', function(event) {
//        var id = $(this).parent().parent().attr('id');
//        event.preventDefault();
//        event.stopPropagation();
//        var delElem = $(this).parent();
//        layer.confirm('确定要删除吗？', {
//            title:false,
//            closeBtn:0,
//            btn: ['确定','取消'] //按钮
//        }, function(){
//            delElem.remove();
//            var num = parseInt($('#'+id+'-num').val());
//            console.log(num);
//            console.log(id);
//            if(num > 0){
//                $('#'+id+'-num').val(parseInt(num) - 1);
//            }
//            layer.msg('删除成功');
//        });
//    });

    $('.math-vip').blur(function(){
        var discount = $(this).val();
    });


    /*移除规格*/
    function removeGuige(elem){
        var panelBox = $(elem).parents(".panel");
        panelBox.remove();
        var panelNum = $('#format-num').val();
        var is_old   = $(elem).data('hid-id');
        if(is_old == 0){ //删除数据库存在的，则不递减
            panelNum -- ; //递减
        }
        var panel = $("#panel-group .panel").length;
        if(panel == 0){
            $("#g_price").attr("readonly",false);
            $("#g_stock").attr("readonly",false);
        }else{
            $("#g_price").attr("readonly",true);
            $("#g_stock").attr("readonly",true);
        }
        $('#format-num').val(panelNum);
    }
    /*添加规格*/
    function addGuige(){
        //var id = $("#panel-group .panel").length+1;
        // $("#panel-template .guige").text("规格#"+id);
        //$("#panel-template input.guigeName").attr("value","规格#"+id);
        var key  = parseInt($('#format-num').val());
        key ++;
        var html = get_format_html(key);//$("#panel-template").html();
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly",true);
        $("#g_stock").attr("readonly",true);
        formatSort();
        sortString();
    }

    function get_format_html(key){
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="removeGuige(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>名称</label>';
        _html       += '<input type="text" class="form-control guigeName" name="format_name_'+key+'"  value="规格#'+key+'">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>价格</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_price_'+key+'" value="">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>库存</label>';
        _html       += '<input type="text" class="form-control"  name="format_stock_'+key+'"  value="">';
        _html       += '</div></div>';

        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }



    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

    function formatSort(){
        /*$("#panel-group").sortable({
            update: function( event, ui ) {
                sortString();
            }
        });*/
    }
    
    function changeSortable() {
        let index = 0;
        $("#slide-img p").each(function () {
            $(this).find('.slide-sort').val(index);
            index++;
        });
    }
    
    function sortString(){
        var sortString="";
        $('#panel-group').find(".panel").each(function(){
            var sortid = $(this).data("sort");
            sortString +=sortid+",";
        });
        $("#format-sort").val(sortString);
    }
</script>

<?php }} ?>
