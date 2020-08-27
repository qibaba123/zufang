<?php /* Smarty version Smarty-3.1.17, created on 2020-04-20 21:37:56
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/goods-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1768865995e853bdb6312c3-13018443%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2e51a7b63672ca30bc35d2b7ac36f7c512968c2' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/goods/goods-list.tpl',
      1 => 1587389870,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1768865995e853bdb6312c3-13018443',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e853bdba654f7_80460392',
  'variables' => 
  array (
    'sidddd' => 0,
    'appletCfg' => 0,
    'seqregion' => 0,
    'statInfo' => 0,
    'name' => 0,
    'category' => 0,
    'cate' => 0,
    'key' => 0,
    'val' => 0,
    'plateform' => 0,
    'type' => 0,
    'gtype' => 0,
    'enterShop' => 0,
    'esId' => 0,
    'threeSale' => 0,
    'selDeduct' => 0,
    'sortType' => 0,
    'status' => 0,
    'weightSortType' => 0,
    'import' => 0,
    'clothes' => 0,
    'allGoodsJumpPageShow' => 0,
    'pickupTime' => 0,
    'goodsAlert' => 0,
    'shop' => 0,
    'choseLink' => 0,
    'menuType' => 0,
    'openPoint' => 0,
    'list' => 0,
    'levelList' => 0,
    'deduct' => 0,
    'goodsPath' => 0,
    'platform' => 0,
    'addMember' => 0,
    'paginator' => 0,
    'integral' => 0,
    'ikey' => 0,
    'ial' => 0,
    'allGoodsJumpPage' => 0,
    'allGoodsJump' => 0,
    'sendCfg' => 0,
    'dayTime' => 0,
    'curr_shop' => 0,
    'independent' => 0,
    'levelCount' => 0,
    'now' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e853bdba654f7_80460392')) {function content_5e853bdba654f7_80460392($_smarty_tpl) {?><script>
    //console.log('商铺ID：'+<?php echo $_smarty_tpl->tpl_vars['sidddd']->value;?>
);
</script>
<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 商品列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }

    .vip-dialog__viptable td {
        border: 1px solid #e5e5e5;
        border-left: none;
        padding: 5px;
        height: 40px;
    }

    .vip-dialog__viptable .td-discount {
        width: 110px;
        text-align: center;
    }

    .vip-dialog__viptable .mini-input input {
        width: 54px;
        min-width: 0;
        padding: 3px 7px;
    }

    .vip-dialog__viptable .td-discount__unit {
        display: inline-block;
        margin-left: 10px;
    }

    .vip-dialog__viptable_head th{
        text-align: center;
        padding-bottom: 15px;
    }
    .form-container .form-group{
        margin-bottom: 10px;
    }
    .input-group .select2-choice{
        height: 34px;
        line-height: 34px;
        border-radius: 0 4px 4px 0 !important;
    }
    .input-group .select2-container{
        border: none !important;
        padding: 0 !important;
    }

    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
    .set-goodsinfo{
        margin-left:3px;
    }

    .zdy-sort:hover{
        color: #00ff00;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 14.28%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
    .table thead tr th{font-size:12px;}
	.choose-state>a.active{border-bottom-color: #4C8FBD;border-top:0;}
	.tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
	.btn-xs{padding:0 2px!important;}
</style>
<?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8||$_smarty_tpl->tpl_vars['seqregion']->value==1) {?>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu-new.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php }?>
<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>style="margin-left: 120px"    <?php }?>>

<!-- 推广商品弹出框 -->
    <!--
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">商品二维码</span>
                <span>商品链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后直接购买</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="link-box">
                    <div class="link-wrap">
                        <p>商品页链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="pages/goodDetail/goodDetail" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy_input" id="copygoods" type="button" data-clipboard-target="copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    -->
    <div class="ui-popover ui-popover-qrcode left-center">
    <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
        <div class="tab-main">
            <div class="code-box show">
                <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                <div class="code-fenlei">
                    <div style="text-align: center">
                        <div class="text-center show">
                            <input type="hidden" id="qrcode-goods-id"/>
                            <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                            <p>扫码后直接购买</p>
                            <div style="text-align: center">
                                <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="arrow"></div>
</div>


    <!-- 复制链接弹出框 -->
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>


<!-- 汇总信息 -->
<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
    <div class="balance-info">
        <div class="balance-title">商品总数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">出售中<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['sale'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">已售罄<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['soldout'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">已下架<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['nosale'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">总销量<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['soldNum'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">总推送次数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['pushTotal'];?>
</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">总推送人数<span></span></div>
        <div class="balance-content">
            <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['pushMemberSum'];?>
</span>
        </div>
    </div>
</div>
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/goods/index" method="get" class="form-inline" id="search-form-box">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="商品名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类目</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['category']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option <?php if ($_smarty_tpl->tpl_vars['cate']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="plateform" id="plateform" value="<?php echo $_smarty_tpl->tpl_vars['plateform']->value;?>
">
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=32&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36) {?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类别</div>
                                <select id="gtype" name="gtype" style="height:34px;width:100%" class="form-control ">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['type']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <option  <?php if ($_smarty_tpl->tpl_vars['gtype']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['plateform']->value==2) {?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">所属商家</div>
                                <select id="esId" name="esId" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['enterShop']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                <option <?php if ($_smarty_tpl->tpl_vars['esId']->value==$_smarty_tpl->tpl_vars['key']->value) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">单品分销</div>
                                <select name="selDeduct" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <option  <?php if ($_smarty_tpl->tpl_vars['selDeduct']->value==2) {?>selected<?php }?> value="2">开启</option>
                                    <option  <?php if ($_smarty_tpl->tpl_vars['selDeduct']->value==1) {?>selected<?php }?> value="1">非开启</option>
                                </select>
                            </div>
                        </div>
                        <?php }?>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">排序</div>
                                <select name="sortType" style="height:34px;width:100%" class="form-control">
                                    <option value="updateNew" <?php if ($_smarty_tpl->tpl_vars['sortType']->value=='updateNew') {?>selected<?php }?>>最近更新</option>
                                    <option value="createNew" <?php if ($_smarty_tpl->tpl_vars['sortType']->value=='createNew') {?>selected<?php }?>>最近添加</option>
                                    <option value="createOld" <?php if ($_smarty_tpl->tpl_vars['sortType']->value=='createOld') {?>selected<?php }?>>最早添加</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="status" value="<?php echo $_smarty_tpl->tpl_vars['status']->value;?>
">
                        <!--按照权重排序-->
                        <input type="hidden" name="weightSortType" value="<?php echo $_smarty_tpl->tpl_vars['weightSortType']->value;?>
">
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
<div style="margin-bottom: 20px">
    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
    <a href="/wxapp/sequence/goodsEdit" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <?php } else { ?>
    <a href="/wxapp/goods/newAdd" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
    <?php }?>

    <!--<a href="/wxapp/goods/commonGoods" target="_blank" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 从商品库导入</a>-->
    <a href="/wxapp/goods/allCommonGoods" target="_blank" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 从商品库导入</a>
    <?php if ($_smarty_tpl->tpl_vars['import']->value) {?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['import']->value['link'];?>
" class="btn btn-pink btn-xs"><i class="icon-exchange bigger-80"></i> <?php echo $_smarty_tpl->tpl_vars['import']->value['name'];?>
</a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['clothes']->value==1) {?>
    <a href="/wxapp/clothes/clothes?type=model" class="btn btn-blue btn-xs"><i class="icon-plus bigger-80"></i> 模特</a>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['allGoodsJumpPageShow']->value||$_smarty_tpl->tpl_vars['pickupTime']->value||$_smarty_tpl->tpl_vars['goodsAlert']->value) {?>
    <a class="btn btn-green btn-xs goods-setting" href="#" data-toggle="modal" data-target="#settingModal">设置</a>
    <?php }?>

    <div class="input-group-box" style="display: inline-block;width: 185px;margin-left: 10px;">
        <label class="label-name">商品图片添加水印：</label>
        <div class="right-info" style="float: right;position: relative;top: -5px;">
            <span class="tg-list-item">
                <input class="tgl tgl-light" id="watermark-open" type="checkbox" onchange="watermarkOpen()" <?php if ($_smarty_tpl->tpl_vars['shop']->value&&$_smarty_tpl->tpl_vars['shop']->value['s_watermark_open']==1) {?>checked<?php }?>>
                <label class="tgl-btn" for="watermark-open"></label>
            </span>
        </div>
    </div>
</div>
    <div class="choose-state">
        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['choseLink']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
        <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['href'];?>
&plateform=<?php echo $_smarty_tpl->tpl_vars['plateform']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['status']->value==$_smarty_tpl->tpl_vars['val']->value['key']) {?> class="active" <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['label'];?>
</a>
        <?php } ?>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>商品</th>
                                <th>价格</th>
                                <th>商品分类</th>
                                <!--
                                <th>店长推荐</th>
                                -->
                                <?php if ($_smarty_tpl->tpl_vars['plateform']->value==2) {?>  <!--说明是商家商品-->
                                <th>所属商家</th>
                                <?php }?>
                                <th>访问量</th>
                                <th>库存</th>
                                <th>商品销量</th>
                                <th>排序权重<i class="fa zdy-sort <?php if ($_smarty_tpl->tpl_vars['weightSortType']->value=="DESC") {?>fa-angle-down<?php } else { ?>fa-angle-up<?php }?>" data-sort="<?php echo $_smarty_tpl->tpl_vars['weightSortType']->value;?>
"></i></th>
                                <!--
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                -->
                                <th>添加时间</th>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                <th>预估佣金</th>
                                <th>小区限制</th>
                                <?php } else { ?>

                                <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                <th>是否已推送</th>
                                <?php }?>


                                <?php }?>
                                <!--<?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?><th>单品分销</th><?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['openPoint']->value) {?><th>积分</th><?php }?>-->
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="tr-content" <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>style="border-bottom:0"<?php }?>>
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td class="proimg-name" style="min-width: 270px;">
                                    <?php if (isset($_smarty_tpl->tpl_vars['val']->value['g_cover'])) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_cover'];?>
" width="75px" height="75px" alt="封面图" style="border-radius:4px;">
                                    <?php }?>
                                    <div>
                                        <p class="pro-name" style="margin-bottom:6px;">
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                            <a href="/wxapp/sequence/goodsEdit?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >
                                                <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['g_name'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>

                                                <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
<?php }?>
                                            </a>
                                            <?php } else { ?>
                                            <a href="/wxapp/goods/newAdd/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >
                                            <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['g_name'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],0,20);?>

                                            <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['g_name'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
<?php }?>
                                            </a>
                                            <?php }?>
                                        </p>

                                        <!--<p class="pro-price" style="margin-bottom:3px;">
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_discuss']) {?>
                                            面议
                                            <?php } else { ?>
                                            <?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>

                                            <?php }?>
                                        </p>-->
                                        <p>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_top']==1) {?>
                                            <!--<span class="label label-sm label-success">店长推荐</span>-->
                                            <span style="color: #82af6f;border: 1px solid #82af6f;border-radius: 4px;padding: 0px 8px;">店长推荐</span>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['levelList']->value&&$_smarty_tpl->tpl_vars['val']->value['g_join_discount']==1) {?>
                                            <!--<span class="label label-sm label-danger">会员折扣</span>-->
                                            <span style="color: #d15b47;border: 1px solid #d15b47;border-radius: 4px;padding: 0px 8px;">会员折扣</span>
                                            <?php }?>
                                        </p>
                                    </div>

                                </td>
                                <td>
                                	<p class="pro-price" style="color: #E97312;font-weight: bold;">
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_discuss']) {?>
                                           	面议
                                        <?php } else { ?>
                                        <?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>

                                        <?php }?>
                                    </p>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['category']->value[$_smarty_tpl->tpl_vars['val']->value['g_kind2']];?>
</td>
                                <!--
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_top']==1) {?>
                                    <span class="label label-sm label-success">店长推荐</span>
                                    <?php }?></td>
                                    -->
                                <?php if ($_smarty_tpl->tpl_vars['plateform']->value==2) {?>  <!--说明是商家商品-->
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>
</td>
                                <?php }?>

                                <td id="show_num_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">
                                    <span><?php echo $_smarty_tpl->tpl_vars['val']->value['g_show_num'];?>
</span>
                                    <!--<a href="javascript:;" class="set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_show_num'];?>
" data-field="show_num">修改</a>-->
                                	<img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_show_num'];?>
" data-field="show_num" />
                                </td>
                                <td id="stock_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">
                                    <span><?php echo $_smarty_tpl->tpl_vars['val']->value['g_stock'];?>
</span>
                                    <!--<a href="javascript:;" class="set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_stock'];?>
" data-field="stock">修改</a>-->
                                	<img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_stock'];?>
" data-field="stock" />
                                </td>
                                <td id="sold_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">
                                    <span><?php echo $_smarty_tpl->tpl_vars['val']->value['g_sold'];?>
</span>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_sold'];?>
" data-field="sold" />
                                    <!--<a href="javascript:;" class="set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_sold'];?>
" data-field="sold">修改</a>-->
                                </td>
                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_show_num'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_stock'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['g_sold'];?>
</td>
                                -->
                                <td>
                                    <span><?php echo $_smarty_tpl->tpl_vars['val']->value['g_weight'];?>
</span>
                                    <!--<a href="javascript:;" class="set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_weight'];?>
" data-field="weight">修改</a>-->
                                	<img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_weight'];?>
" data-field="weight" />
                                </td>
                                <!--
                                <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['g_update_time']);?>
</td>
                                -->
                                <!--<?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['g_is_deduct']) {?>已开启<?php } else { ?>未开启<?php }?>
                                    <a href="javascript:;"
                                       data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"
                                       data-ratio_0="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_0f_ratio'];?>
<?php }?>"
                                       data-ratio_1="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_1f_ratio'];?>
<?php }?>"
                                       data-ratio_2="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_2f_ratio'];?>
<?php }?>"
                                       data-ratio_3="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_3f_ratio'];?>
<?php }?>"
                                       data-used="<?php if (isset($_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']])) {?><?php echo $_smarty_tpl->tpl_vars['deduct']->value[$_smarty_tpl->tpl_vars['val']->value['g_id']]['gd_is_used'];?>
<?php } else { ?>0<?php }?>"
                                       class="fxGoods"> 设置 </a>
                                </td>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['openPoint']->value) {?>
                                <td>
                                    <a href="javascript:;" class="setPoint"
                                       data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"
                                       data-format="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_has_format'];?>
"
                                       data-point="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_send_point'];?>
"
                                       data-num="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_back_num'];?>
"
                                       data-unit="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_back_unit'];?>
"
                                            >设置积分</a>
                                </td>
                                <?php }?>-->
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['g_create_time']) {?><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['val']->value['g_create_time']);?>
<?php }?></td>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['g_1f_ratio']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['g_1f_ratio'];?>
<?php } else { ?>0<?php }?></td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['g_add_bed']==1) {?>
                                    <span style="color: red">限制小区购买</span>
                                    <a href="#" class="btn btn-xs btn-primary change-limit" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-status="0">解除</a>
                                    <?php } else { ?>
                                    <span style="">无限制</span>
                                    <a href="#" class="btn btn-xs btn-danger change-limit" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-status="1">限制小区</a>
                                    <?php }?>
                                </td>
                                <?php } else { ?>

                                <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['g_push']) {?>已推送<?php } else { ?><span style="color:#333;">未推送</span><?php }?></td>
                                <?php }?>

                                <?php }?>

                                <td style="color:#ccc;">
                                    <p>
                                        <!--
                                        <a href="javascript:;" class="btn-tuiguang" data-link="pages/goodDetail/goodDetail?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-share="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_qrcode'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">商品推广</a>
                                        -->

                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao','qq'))) {?>
                                        <a href="javascript:;" class="btn-qrcode" data-link="<?php echo $_smarty_tpl->tpl_vars['goodsPath']->value;?>
?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" data-share="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_qrcode'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">二维码</a> -
                                        <?php }?>
                                        <a href="javascript:;" id="link_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="btn-link" data-link="<?php echo $_smarty_tpl->tpl_vars['goodsPath']->value;?>
?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">路径</a>
                                        - <a href="javascript:;" onclick="showVipPriceModal(<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
, <?php echo $_smarty_tpl->tpl_vars['val']->value['g_has_format'];?>
, <?php echo $_smarty_tpl->tpl_vars['val']->value['g_price'];?>
)">会员价</a>
                                        <?php if ($_smarty_tpl->tpl_vars['platform']->value=='clothes'||$_smarty_tpl->tpl_vars['clothes']->value==1) {?>
                                        - <a href="/wxapp/clothes/clothes/?gid=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >试衣间</a>
                                        <?php }?>
                                        <!--
                                        <?php if ($_smarty_tpl->tpl_vars['addMember']->value==1) {?>
                                        - <a href="/wxapp/goods/commentGoods?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >评价</a>
                                        <?php }?>-->
                                    </p>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                    <p>

                                        <a href="javascript:;" onclick="pushGoodsGet('<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
')" >到货通知推送</a>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['g_add_bed']==1) {?>
                                        <a href="/wxapp/sequence/goodsCommunityEdit?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >编辑商品小区</a>
                                    <?php }?>

                                    </p>
                                    <?php } else { ?>
                                    <p>
                                    	<?php if ($_smarty_tpl->tpl_vars['addMember']->value==1) {?>
                                        <a href="/wxapp/goods/commentGoods?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >评价</a>
                                        <?php }?>

                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                        - <a href="javascript:;" onclick="pushGoods('<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
')" >推送</a> -
                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('weixin'))) {?>
                                        <a href="javascript:;" onclick="showPreview(<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
)">预览</a> -
                                        <?php }?>
                                        <a href="/wxapp/tplpreview/pushHistory?type=goods&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >记录</a>
                                        <?php }?>

                                    </p>
                                    <?php }?>

                                    <p>
                                        <!--<a href="javascript:;" class="btn-import" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">上传</a> -->
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                        <a href="/wxapp/sequence/goodsEdit/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >编辑</a> -
                                        <?php } else { ?>
                                        <a href="/wxapp/goods/newAdd/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" >编辑</a> -
                                        <?php }?>
                                            <a href="/wxapp/goods/copyformat/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" ><span>复制规格</span></a> -
                                        <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
" class="btn-del" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"><span style="color: red">删除</span></a>

                                        <?php if ($_smarty_tpl->tpl_vars['plateform']->value==2) {?>
                                        -<a href="/wxapp/goods/shopList/?gid=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
&esId=<?php echo $_smarty_tpl->tpl_vars['val']->value['g_es_id'];?>
"  data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
">复制</a>
                                        <?php }?>
                                    </p>

                                </td>
                            </tr>
                            <?php if (($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36)&&($_smarty_tpl->tpl_vars['val']->value['upDate']||$_smarty_tpl->tpl_vars['val']->value['downDate'])) {?>
                            <tr style="border-top:0;background-color:#f9f9f9 ">
                                <td colspan="1" style="border: 0"></td>
                                <td colspan="10" style="border: 0;color:red">
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['upDate']) {?>
                                    <span style="padding-right: 8px">上架时间：<?php echo $_smarty_tpl->tpl_vars['val']->value['upDate'];?>
</span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['downDate']) {?>
                                    <span style="padding-right: 8px">下架时间：<?php echo $_smarty_tpl->tpl_vars['val']->value['downDate'];?>
</span>
                                    <?php }?>
                                </td>
                            </tr>
                            <?php }?>
                            <?php } ?>
                            <tr><td colspan="2">
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='sell'||$_smarty_tpl->tpl_vars['status']->value=='sellout') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="down">下架</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['status']->value=='depot') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <?php } elseif ($_smarty_tpl->tpl_vars['status']->value=='presell') {?>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="down">下架</span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['plateform']->value!=2) {?>
                                    <span class="btn btn-xs btn-name btn-change-cate btn-primary" >

                                        <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改商品分类</a>
                                    </span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['levelList']->value) {?>
                                    <span class="btn btn-xs btn-name btn-change-cate btn-primary" >

                                        <a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#discountModal" >会员折扣</a>
                                    </span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='sell') {?>
                                    <span class="btn btn-xs btn-warning shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="down">
                                    设置自动下架
                                    </span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='depot'||$_smarty_tpl->tpl_vars['status']->value=='sell') {?>
                                    <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell">
                                    设置预售时间
                                    </span>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['status']->value=='presell') {?>
                                    <span class="btn btn-xs btn-success shelf_auto_button" style="color: #fff" data-toggle="modal" data-target="#shelfAutoModal" data-type="presell_change">
                                    修改预售时间
                                    </span>
                                    <?php }?>
                                    <?php }?>
                                </td><td colspan="9" style="text-align:center"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <?php if ($_smarty_tpl->tpl_vars['threeSale']->value) {?>
    <div id="modal-info-form" class="modal fade" tabindex="-1">
        <div class="modal-dialog" style="width:850px;;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="blue bigger" id="modal-title">佣金配置设置</h4>
                </div>

                <div class="modal-body" style="overflow: hidden;">
                    <input type="hidden" class="form-control" id="hid-goods" value="0">
                    <input type="hidden" class="form-control" id="hid-type" value="deduct">
                    <!--分佣比例设置-->
                    <div id="threeSale" class="tab-div">
                        <div class="alert alert-block alert-yellow">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            若未开启，或者未设置，则按 店铺 佣金配置进行分销!
                        </div>
                        <div class="col-sm-12" style="margin-bottom: 20px;">
                            <div id="home"  class="tab-pane in active">
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">购买人返现比例</div>
                                        <input type="text" class="form-control" id="ratio_0" placeholder="返现比例百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">上级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_1" placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['threeSale']->value>1) {?>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">二级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_2"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php }?>
                                <?php if ($_smarty_tpl->tpl_vars['threeSale']->value>2) {?>
                                <div class="space-4"></div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <div class="input-group-addon input-group-addon-title">三级提成比例</div>
                                        <input type="text" class="form-control" id="ratio_3"  placeholder="百分比">
                                        <div class="input-group-addon">%</div>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="input-group col-sm-3">
                                    <div class="input-group-addon"> 是否开启 : &nbsp;</div>
                                    <label class="input-group-addon" id="choose-yesno" style="padding: 4px 10px;margin: 0;border: 1px solid #D5D5D5;">
                                        <input name="used" class="ace ace-switch ace-switch-5" id="used"  type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--积分设置-->
                    <div id="setPoint" class="tab-div">
                        <input type="hidden" class="form-control" id="hid-num" value="1">
                        <input type="hidden" class="form-control" id="hid-format" value="0">
                        <div id="pointContent">

                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">返还期数</div>
                                <input type="text" class="form-control" style="height: 40px;" id="backNum" value="" placeholder="请填写大于0的整数" >
                                <div class="input-group-addon">
                                    <div class="radio-box">
                                        <?php  $_smarty_tpl->tpl_vars['ial'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ial']->_loop = false;
 $_smarty_tpl->tpl_vars['ikey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['integral']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ial']->key => $_smarty_tpl->tpl_vars['ial']->value) {
$_smarty_tpl->tpl_vars['ial']->_loop = true;
 $_smarty_tpl->tpl_vars['ikey']->value = $_smarty_tpl->tpl_vars['ial']->key;
?>
                                        <span data-val="<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
">
                                            <input type="radio" name="backUnit" value="<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
" id="refer<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
" >
                                            <label for="refer<?php echo $_smarty_tpl->tpl_vars['ikey']->value;?>
">按<?php echo $_smarty_tpl->tpl_vars['ial']->value;?>
</label>
                                        </span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-block alert-yellow">
                            期数为“1”，则购买后立即赠送积分。
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary modal-save">保存</button>
                </div>
            </div>
        </div>
    </div>    <!-- MODAL ENDS -->
    <?php }?>
    <div class="modal fade" id="shelfAutoModal" tabindex="-1" role="dialog" aria-labelledby="shelfAutoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="auto_type" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="shelfAutoModalLabel">
                    设置时间
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group" id="up_time_box">
                    <label for="kind2" class="control-label">上架时间：</label>
                    <div class="control-group">
                        <input type="text" class="form-control" name="up_time" value="" placeholder="上架时间" id="up_time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
                    </div>
                </div>
                <div class="form-group" id="down_time_box">
                    <label for="kind2" class="control-label">下架时间：</label>
                    <div class="control-group">
                        <input type="text" class="form-control" name="down_time" value="" placeholder="下架时间" id="down_time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm'})">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="shelf-auto">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <input type="hidden" id="hid_id" >
                <input type="hidden" id="now_expire" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改商品分类
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kind2" class="control-label">商品分类：</label>
                        <div class="control-group" id="customCategory">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="change-cate">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
<div class="modal fade" id="discountModal" tabindex="-1" role="dialog" aria-labelledby="discountModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 350px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="discountModalLabel">
                    是否参与会员价
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="kind2" class="control-label">是否参与会员价：</label>
                    <select name="join-discount" id="join-discount" class="form-control">
                        <option value="0">不参与</option>
                        <option value="1">参与</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-join-discount">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
    <div class="modal fade" id="vipPriceModal" tabindex="-1" role="dialog" aria-labelledby="vipPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="overflow: auto; width: 900px">
            <div class="modal-content">
                <input type="hidden" id="vip-price-type" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        自定义会员价
                    </h4>
                </div>
                <div class="modal-body" style="overflow: auto" >
                    <div id="vip-price-edit">

                    </div>
                    <div class="form-group" style="margin-top: 10px">
                        <label class="control-label">是否显示会员价：</label>
                        <div class="control-group" style="display: inline-block;">
                            <label style="padding: 4px 0;margin: 0;">
                                <input name="g_show_vip" class="ace ace-switch ace-switch-5" id="g_show_vip" type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="save-vip-price">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

    <div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="overflow: auto; width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        推送预览
                    </h4>
                </div>
                <div class="modal-body preview-page" style="overflow: auto">
                    <div class="mobile-page ">
                        <div class="mobile-header"></div>
                        <div class="mobile-con">
                            <div class="title-bar">
                                消息模板预览
                            </div>
                            <!-- 主体内容部分 -->
                            <div class="index-con">
                                <!-- 首页主题内容 -->
                                <div class="index-main" style="height: 380px;">
                                    <div class="message">
                                        <h3 id="tpl-title"></h3>
                                        <p class="date" id="tpl-date"></p>
                                        <div class="item-txt"  id="tpl-content">

                                        </div>
                                        <div class="see-detail">进入小程序查看</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-footer"><span></span></div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>

<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 635px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" <?php if (!$_smarty_tpl->tpl_vars['allGoodsJumpPageShow']->value) {?>style="display: none"<?php }?>>
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">全部商品页面跳转链接：</label>
                    <div class="col-sm-8">
                        <select name="all-goods-jump" id="all-goods-jump" class="form-control">
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['allGoodsJumpPage']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['path'];?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value['path']==$_smarty_tpl->tpl_vars['allGoodsJump']->value) {?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value['name'];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div <?php if (!$_smarty_tpl->tpl_vars['pickupTime']->value) {?>style="display: none"<?php }?>>
                <!--
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">显示发货/提货时间：</label>
                    <div class="col-sm-8">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="timeShow" id="time_yes" value="1" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value['acs_sequence_day_show']==1) {?>checked<?php }?>>
                                        <label for="time_yes">显示</label>
                                    </span>
                            <span>
                                        <input type="radio" name="timeShow" id="time_no" value="0" <?php if ($_smarty_tpl->tpl_vars['sendCfg']->value['acs_sequence_day_show']==0) {?>checked<?php }?>>
                                        <label for="time_no">不显示</label>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">开始发货/提货时间：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['sendCfg']->value['acs_sequence_day'];?>
" id="days" style="">
                        <span>单位天。不填或0表示当天发货/提货</span>
                    </div>
                </div>
                -->

                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">延后时间点：</label>
                    <div class="col-sm-8">
                        <select class="form-control" id="daytime" name="daytime"  style="">
                            <option value="">不设置</option>
                            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['dayTime']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['val']->value==$_smarty_tpl->tpl_vars['sendCfg']->value['acs_sequence_daytime']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
                            <?php } ?>
                        </select>
                        <span>每天此时间后下单，将发货/提货时间延后一天</span>
                    </div>
                </div>
        </div>
                <div <?php if (!$_smarty_tpl->tpl_vars['goodsAlert']->value) {?>style="display: none"<?php }?>>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">补货提醒：</label>
                    <div class="col-sm-8">
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="goodsAlert" id="alert_yes" value="1" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_alert_open']==1) {?>checked<?php }?>>
                                        <label for="alert_yes">开启提醒</label>
                                    </span>
                            <span>
                                        <input type="radio" name="goodsAlert" id="alert_no" value="0" <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_alert_open']==0) {?>checked<?php }?>>
                                        <label for="alert_no">关闭提醒</label>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="form-group row">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: right">提醒值：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_alert_value'];?>
" id="alertValue" style="">
                        <span>当库存达到此数量时将推送提醒</span>
                    </div>
                </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-jump">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

</div>    <!-- PAGE CONTENT ENDS -->



<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    console.log("<?php echo $_smarty_tpl->tpl_vars['clothes']->value;?>
");
    customerGoodsCategory("<?php echo $_smarty_tpl->tpl_vars['independent']->value;?>
");
    function customerGoodsCategory(df){
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/ajaxGoodsCustomCategory',
            'data'  : {independent:df},
            'dataType'  : 'json',
            success : function(ret){
                console.log(ret.data);
                if(ret.ec == 200){
                    customer_category(ret.data,df);
                }
            }
        });
    }
    function customer_category(data,df){
        var html = '<select id="custom_cate" name="custom_cate" class="form-control">';
        for(var i = 0; i < data.length ; i++){
            var son = data[i].secondItem;
            html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
            for(var s = 0 ; s < son.length ; s ++){
                var sel = '';
                if(df == son[s].id){
                    sel = 'selected';
                }
                html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
            }

            html += '';
            html += '</optgroup>';
        }
        html += '</select>';
        console.log(html);
        $('#customCategory').html(html);
    }
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
        optshide();
    } );
    /*复制链接地址弹出框*/
    $("#content-con").on('click', 'table td a.btn-link', function(event) {
        var link = $(this).data('link');
        if(link){
            $('.copy-div input').val(link);
        }
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
     });
    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        console.log('btn-tuiguang');
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //购买链接
        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(id);
            $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
        }
     });

    $("#content-con").on('click', 'table td a.btn-qrcode', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var id  = that.data('id');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //购买链接

        $('#qrcode-goods-id').val(id);
        if(shareImg){
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
        }else{
            reCreateQrcode();
        }
        $('#act-code-img').attr('src',shareImg); //分享二维码图片
        $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-qrcode").css({'left':left-conLeft-520,'top':top-conTop-158-72}).stop().show();
        
    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td .good-admend.set-goodsinfo', function(event) {
        console.log('work');
        var id = $(this).data('id');
        var field = $(this).data('field');
        //var value = $(this).data('value');
        var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
        //console.log(value);
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
    });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var independent = '<?php echo $_smarty_tpl->tpl_vars['independent']->value;?>
';

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        console.log(id);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/createQrcode',
            'data'  : {id:id,independent:independent},
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(JSON.stringify(ret));
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }

    function showVipPriceModal(id) {
        // 先判断是否添加了会员等级
        var levelCount = '<?php echo $_smarty_tpl->tpl_vars['levelCount']->value;?>
';
        console.log(levelCount);
        if(levelCount<1){
            layer.msg('请先添加会员等级才能使用此功能');
            return false;
        }

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/getVipPrice',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                $('#vip-price-type').val(ret.type);
                if(ret.showVip == 1){
                    $('#g_show_vip').prop("checked", true);
                }else{
                    $('#g_show_vip').prop("checked", false);
                }

                $html = '';
                $html += '<table><thead class="vip-dialog__viptable_head">';
                $html += '<tr>';
                for(var i in ret.formatName){
                    $html +=  '<th class="sku"><div class="tdwrap1">'+ret.formatName[i]+'</div></th>';
                }
                $html +=  '<th class="sku"><div class="tdwrap1">正常售价</div></th>';
                for(var i in ret.data[0]['vipPrice']){
                    $html += '<th><div class="tdwrap2">'+ret.data[0]['vipPrice'][i]['name']+'</div></th>';
                }
                $html += '</tr></thead>';
                $html += '<tbody class="vip-dialog__viptable">';
                for(var i in ret.data){
                    $html += '<tr>';
                    if(ret.data[i]['name1']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name1']+'</div></td>';
                    }
                    if(ret.data[i]['name2']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name2']+'</div></td>';
                    }
                    if(ret.data[i]['name3']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name3']+'</div></td>';
                    }
                    $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">￥'+ret.data[i]['price']+'</div></td>';
                    for(var n in ret.data[i]['vipPrice']){
                        $html += '<td class=""><div class="td-discount">' +
                            '<div class="zent-number-input-wrapper mini-input" style="display: inline-block">' +
                            '<div class="zent-input-wrapper mini-input">' +
                            '<input type="text" class="form-control vip-price-value" style="display: inline-block" data-id='+ret.data[i]['vipPrice'][n]['id']+' data-lid='+ret.data[i]['vipPrice'][n]['lid']+' value="'+ret.data[i]['vipPrice'][n]['price']+'"></div></div>' +
                            '<span class="td-discount__unit">元</span></div></td>';
                    }
                    $html += '</tr>';
                }
                $html += '</tbody></table>';
                $('#vip-price-edit').html($html);
                $('#vipPriceModal').modal('show');
            }
        });
    }

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/goodsPreview',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    $('#tpl-title').html(ret.data.title);
                    $('#tpl-date').html(ret.data.date);
                    var data = ret.data.tplData;
                    var html = '';
                    for(var i in data){
                        html += '<div>';
                        if(data[i]['emphasis'] != 1){
                            html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                            html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }else{
                            html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                            html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                        }
                        html += '</div>';
                    }
                    $('#tpl-content').html(html);
                    $('#tplPreviewModal').modal('show');
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }

    $('#save-vip-price').click(function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var type = $('#vip-price-type').val();
        var showVip = $('#g_show_vip').is(':checked');
        var data = [];
        $('.vip-price-value').each(function(index, element) {
            data[index] = {
                'id' : $(element).data('id'),
                'identity' : $(element).data('lid'),
                'price' : $(element).val(),
            };
        });
        console.log(showVip);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/saveVipPrice',
            'data'  : {data:data, type: type, showVip: showVip},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#vipPriceModal').modal('hide');
                }
            }
        });
    });

    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', '.code-fenlei .pull-left li', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".code-fenlei .pull-right .text-center").eq(index).addClass('show').siblings().removeClass('show');
    });
    $(".ui-popover-tuiguang").on('click', function(event) {
        event.stopPropagation();
    });
    $(".ui-popover-qrcode").on('click', function(event) {
        event.stopPropagation();
    });
    $(".ui-popover-link").on('click', function(event) {
        event.stopPropagation();
    });
    $(".ui-popover-goodsinfo").on('click', function(event) {
        event.stopPropagation();
    });
     $("body").on('click', function(event) {
        optshide();
     });
     /*隐藏弹出框*/
     function optshide(){
         $('.ui-popover').stop().hide();
     }
    $('.btn-shelf').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){
            var data = {
                'ids' : ids,
                'type' : type
            };
            var url = '/wxapp/goods/shelf';
            plumAjax(url,data,true);
        }

    });
    $('#change-cate').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'custom_cate': $('#custom_cate').val()
            };
            var url = '/wxapp/goods/changeCate';
            plumAjax(url,data,true);
        }
    });

    $('#change-join-discount').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'join': $('#join-discount').val()
            };
            var url = '/wxapp/goods/changeJoinDiscount';
            plumAjax(url,data,true);
        }
    });

    $('#shelf-auto').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'type': $('#auto_type').val(),
                'up_time' : $('#up_time').val(),
                'down_time' : $('#down_time').val()
            };
            console.log(data);
            var url = '/wxapp/goods/autoShelf';
            plumAjax(url,data,true);
        }else{
            layer.msg('请选择商品');
        }
    });
    $('.btn-import').on('click',function(){
        var id = $(this).data('id');
        if(id){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/shop2Common',
                'data'  : {id:id},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    layer.close(index);
                }
            });
        }

    });
    $('.fxGoods').on('click',function(){
        var gid = $(this).data('gid');
        if(gid){
            for(var i=0 ; i<=3 ; i++){
                var temp = $(this).data('ratio_'+i);
                $('#ratio_'+i).val(temp);
            }
            var used = $(this).data('used');
            if(used == 1) {
                $('input[name="used"]').prop("checked","checked");
            }else{
                $('input[name="used"]').prop("checked","");
            }

            show_modal_content('threeSale',gid);
            $('#modal-info-form').modal('show');
        }else{
            layer.msg('未获取到商品信息');
        }
    });
    $('.setPoint').on('click',function(){
        var gid    = $(this).data('gid');
        var format = $(this).data('format');
        var point  = $(this).data('point');
        var unit   = $(this).data('unit');
        $('#backNum').val($(this).data('num'));
        $('input[name="backUnit"][value="'+unit+'"]').attr("checked",true);
        if(format == 0){
            var html = show_point_setting('赠送积分','sendPoint0',point,gid);
            $('#hid-num').val(1);
            $('#pointContent').html(html);
        }else{ //多规格的，分别处理
            var data = {
                'gid' : gid
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/formatToPoint',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        var html = '';
                        for(var i = 0 ; i < ret.data.length ; i ++){
                            var row = ret.data;
                            html += show_point_setting(row[i]['name'],'sendPoint'+i,row[i]['point'],row[i]['id'])
                        }

                        $('#hid-num').val(ret.data.length);
                        $('#pointContent').html(html);
                    }
                }
            });
        }
        $('#hid-format').val(format);
        show_modal_content('setPoint',gid);
        $('#modal-info-form').modal('show');
    });
    function show_point_setting(title,id,val,did){
        var _html = '<div class="form-group">';
        _html += '<div class="input-group">';
        _html += '<div class="input-group-addon input-group-addon-title">'+title+'</div>';
        _html += '<input type="text" class="form-control" id="'+id+'" value="'+val+'" data-id="'+did+'" placeholder="请填写积分">';
        _html += '<div class="input-group-addon">分</div>';
        _html += '</div></div>';
        _html += '<div class="space-4"></div>';
        return _html;
    }
    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '商品积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }
    $('.btn-del').on('click',function(){
        var data = {
            'id' : $(this).data('gid'),
            'type': 'goods'
        };
        //commonDeleteById(data);
        commonDeleteByIdWxapp(data);
    });
    $('.modal-save').on('click',function(){
        var type = $('#hid-type').val();
        switch (type){
            case 'deduct':
                saveRatio();
                break;
            case 'point':
                savePoint();
                break;
        }

    });
    function saveRatio(){
        var gid = $('#hid-goods').val();
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function savePoint(){
        var data = {
            'gid'    : $('#hid-goods').val(),
            'format' : $('#hid-format').val(),
            'unit'   : $('input[name="backUnit"]:checked').val(),
            'num'    : parseInt($('#backNum').val())
        };
        if(data.num <= 0){
            layer.msg('请填写返还期数');
            return false;
        }
        if(data.format == 0){
            data.point = $('#sendPoint0').val();
        }else{
            var num    = $('#hid-num').val();
            var point  = {};
            for(var i = 0 ; i < num ; i ++){
                var temp = {
                    'id' : $('#sendPoint'+i).data('id'),
                    'val': $('#sendPoint'+i).val()
                };
                point['point_'+i] = temp;
            }
            data.point = point;
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/savePoint',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    }

    function pushGoods(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/goodsPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }
    jQuery(function($) {
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<?php echo $_smarty_tpl->tpl_vars['now']->value;?>
';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });


        //排序权重升序或降序
        $('.zdy-sort').on('click',function(){
            var sort = $(this).data('sort');
            var willSort = sort == "DESC" ? "ASC" : 'DESC';
            $('input[name="weightSortType"]').val(willSort);
            $('#search-form-box').submit();
        });

        //给所有的img标签都添加一个属性onerror

    });
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }

    $(".save-goodsinfo").on('click',function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();

        var data = {
          'id'  :id,
          'field' :field,
          'value':value
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/changeGoodsInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);
                    //$("#"+field+"_"+id).find("a").attr('data-value',value);
                    if(field == "weight"){
                        window.location.reload();
                    }
                }else{
                    layer.msg(ret.em);
                }
            }
        });


    });

    function pushGoodsGet(id) {
        layer.confirm('确定要推送吗？', {
            btn: ['确定','取消'], //按钮
            title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/goodsGetPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }

    $('.change-limit').on('click',function () {
        var id = $(this).data('id');
        var status = $(this).data('status');
        var data = {
            id : id,
            status : status
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeGoodsLimit',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

    $('#confirm-jump').on('click',function () {
        var link = $('#all-goods-jump').val();
        // var timeShow = $('input[name=timeShow]:checked').val();
        // var days = $('#days').val();
        var daytime = $('#daytime').val();
        var goodsAlert = $('input[name=goodsAlert]:checked').val();
        var alertValue = $('#alertValue').val();
        var data = {
            link : link,
            // timeShow : timeShow,
            // days : days,
            daytime : daytime,
            goodsAlert : goodsAlert,
            alertValue : alertValue
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/allGoodsJump',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    });

    $('.shelf_auto_button').on('click',function () {
        var type = $(this).data('type');
        if(type == 'down'){
            $('#up_time_box').hide();
        }else{
            $('#up_time_box').show();
        }
        $('#auto_type').val(type);
        $('#down_time').val('');
        $('#up_time').val('');
    });

    function watermarkOpen() {
        var status = $('#watermark-open').is(':checked');
        var data = {
            status : status ? 1 : 0
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/openWatermark',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    if(data.status==1){
                        layer.msg('启用成功');
                    }else{
                        layer.msg('关闭成功');
                    }
                }
            }
        });
    }

</script><?php }} ?>
