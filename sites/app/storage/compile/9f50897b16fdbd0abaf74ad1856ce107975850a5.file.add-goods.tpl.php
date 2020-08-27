<?php /* Smarty version Smarty-3.1.17, created on 2020-04-20 16:55:58
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/add-goods.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2364630955e9d639ed6ae98-16851923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f50897b16fdbd0abaf74ad1856ce107975850a5' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/add-goods.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2364630955e9d639ed6ae98-16851923',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'category' => 0,
    'val' => 0,
    'type' => 0,
    'key' => 0,
    'format' => 0,
    'formatNum' => 0,
    'formatSort' => 0,
    'tempList' => 0,
    'slide' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e9d639ee57e38_08307103',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e9d639ee57e38_08307103')) {function content_5e9d639ee57e38_08307103($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

</style>
<?php echo $_smarty_tpl->getSubTemplate ("../../manage/common-kind-editor.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/goods/index"> 返回 </a></small> | 新增/编辑商品信息</h4>
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
                                        <!--
                                        <div class="step-pane <?php if (!$_smarty_tpl->tpl_vars['row']->value) {?>active<?php }?>" id="step1" >
                                            <h3 class="lighter block green">所属类目</h3>
                                            <div class="product-leibie">
                                                <ul>
                                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                                    <li <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_c_id']==$_smarty_tpl->tpl_vars['val']->value['c_id']) {?>class="selected"<?php }?> data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['c_id'];?>
">
                                                    <div data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['c_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['c_name'];?>
</div>
                                                    </li>
                                                    <?php } ?>
                                                </ul>
                                                <input type="hidden" id="g_c_id" name="g_c_id" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_c_id'];?>
<?php }?>" placeholder="请选择商品类目">
                                            </div>
                                        </div>
                                        -->
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
                                                        <div class="form-group">
                                                            <label class="control-label">商品原价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_ori_price" name="g_ori_price" placeholder="原价" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_ori_price'];?>
<?php }?>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>商品售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写商品售价"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_price'];?>
<?php }?>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>仅VIP购买：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_vip_buy" class="ace ace-switch ace-switch-5" id="g_vip_buy" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_vip_buy']) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>-->
                                                        <div class="form-group">
                                                            <label class="control-label">单人限购：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_limit" name="g_limit" placeholder="不限购则为填写“0”" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_limit'];?>
<?php }?>"  style="width:160px;">
                                                            </div>
                                                        </div>
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
                                                                    <input name="g_sold_show" class="ace ace-switch ace-switch-5" id="g_sold_show" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_sold_show']) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label  class="col-sm-3 control-label"><font color="red">*</font>商品类型：</label>
                                                            <div class="control-group">
                                                                <select id="g_type" name="g_type" class="form-control">
                                                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                                                        <div class="form-group">
                                                            <label for="kind2" class="control-label">商品分类：</label>
                                                            <div class="control-group" id="customCategory">

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">排序权重：</label>
                                                            <div class="control-group">
                                                                <input type="text" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_weight'];?>
<?php } else { ?>1<?php }?>" name="g_weight" id="g_weight"  class="form-control" oninput="this.value=this.value.replace(/\D/g,'')"  style="width:160px;">
                                                                <p class="tip">数字越大排序越靠前</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>首页推荐商品：</label>
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
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品标签：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_custom_label" name="g_custom_label" placeholder="请填写商品标签,不同标签以空格隔开"  value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_custom_label'];?>
<?php }?>" >
                                                                <p class="tip">不同标签以空格隔开</p>
                                                            </div>
                                                            <!--<div class="control-group">
                                                                <div class="goods-tagbox">
                                                                    <span data-id="0" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_back']==1) {?>class='active'<?php }?> >七天退货</span>
                                                                    <span data-id="1" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_quality']==1) {?>class='active'<?php }?> >正品保障</span>
                                                                    <span data-id="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_is_truth']==1) {?>class='active'<?php }?> >如实描述</span>
                                                                    <input type="hidden" id="good_tag_0" name="good_tag_0" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_is_back'];?>
<?php } else { ?>0<?php }?>">
                                                                    <input type="hidden" id="good_tag_1" name="good_tag_1" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_is_quality'];?>
<?php } else { ?>0<?php }?>">
                                                                    <input type="hidden" id="good_tag_2" name="good_tag_2" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_is_truth'];?>
<?php } else { ?>0<?php }?>">
                                                                </div>
                                                            </div>-->
                                                        </div>
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
                                                            <label class="control-label"><font color="red">*</font>商品库存：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_stock" name="g_stock" placeholder="商品库存数量" required="required" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_stock'];?>
<?php }?>"  style="width:160px;">
                                                                <p class="tip">
                                                                    添加规格以后库存数量不更手动更改
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>库存显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input class="ace ace-switch ace-switch-5" name="g_stock_show" id="g_stock_show" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_stock_show']) {?>checked<?php }?> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">商品规格：</label>
                                                            <div class="control-group">
                                                                <div class="panel-group" id="panel-group">
                                                                    <!--存放商品规格-->
                                                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['format']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                                                    <div class="panel" data-sort="format_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
">
                                                                        <input type="hidden" name="format_id_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gf_id'];?>
">
                                                                        <div class="panel-collapse">
                                                                            <a href="javascript:;" class="close" data-hid-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gf_id'];?>
" onclick="removeGuige(this)">×</a>
                                                                            <div class="panel-body">
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>名称</label>
                                                                                        <input type="text" name="format_name_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="form-control guigeName" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gf_name'];?>
">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>价格</label>
                                                                                        <input type="text" name="format_price_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" data-key="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" onblur="toMathVIp( this )" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gf_price'];?>
">
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xs-4">
                                                                                    <div class="input-group">
                                                                                        <label for=""  class="input-group-addon"><font color="red">*</font>库存</label>
                                                                                        <input type="text" name="format_stock_<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gf_stock'];?>
">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <a href="javascript:;" class="ui-btn" onclick="addGuige()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加规格</a>
                                                                <input type="hidden" name="format-num" id="format-num" value="<?php echo $_smarty_tpl->tpl_vars['formatNum']->value;?>
">
                                                                <input type="hidden" name="format-sort" id="format-sort" value="<?php echo $_smarty_tpl->tpl_vars['formatSort']->value;?>
">
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
                                                            <div class="control-group">
                                                                <div class="radio-box col-xs-2"  style="width:172px;">
                                                                    <span>
                                                                        <input type="radio" name="g_expfee_type" id="g_expfee_type2"  value="2" <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_expfee_type']==2) {?>checked<?php }?>>
                                                                        <label for="g_expfee_type2">运费模板</label>
                                                                    </span>
                                                                </div>
                                                                <div class="col-xs-4">
                                                                    <select name="g_unified_tpid" id="g_unified_tpid" class="form-control">
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-pane" id="step2">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">商品封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover" id="upload-cover"  src="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_45_45.png<?php }?>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_cover']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_cover'];?>
<?php }?>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover">修改</a>
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
                                                                </p>
                                                                <?php } ?>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<?php if ($_smarty_tpl->tpl_vars['slide']->value) {?><?php echo count($_smarty_tpl->tpl_vars['slide']->value);?>
<?php } else { ?>0<?php }?>" placeholder="控制图片张数">
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
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="商品详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <?php if ($_smarty_tpl->tpl_vars['row']->value&&$_smarty_tpl->tpl_vars['row']->value['g_detail']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['g_detail'];?>
<?php }?>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <hr />
                                <div class="row-fluid wizard-actions">
                                    <?php if ($_smarty_tpl->tpl_vars['row']->value) {?>
                                    <button class="btn btn-primary" onclick="saveGoods('save');">
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
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>


<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script type="text/javascript">
    jQuery(function($) {
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
            saveGoods('step');
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
        customerGoodsCategory(kind);

        // 初始化库存是否可输入
        var panelLen = parseInt($("#panel-group").find('.panel').length);
        if(panelLen>0){
            $("#g_stock").attr("readonly",true);
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
        if(!g_cover){
            layer.msg('请上传封面图');
            return false;
        }
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
    function saveGoods(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/goods/save',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200 && type == 'step'){
                    window.location.href='/wxapp/goods/index';
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#g_cover').val(allSrc[0]);
                }
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
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).prepend(img_html);
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

    function formatSort(){
        $("#panel-group").sortable({
            update: function( event, ui ) {
                sortString();
            }
        });
    }
    function sortString(){
        var sortString="";
        $('#panel-group').find(".panel").each(function(){
            var sortid = $(this).data("sort");
            sortString +=sortid+",";
        });
        $("#format-sort").val(sortString);
        console.log(sortString);
    }
</script>

<?php }} ?>
