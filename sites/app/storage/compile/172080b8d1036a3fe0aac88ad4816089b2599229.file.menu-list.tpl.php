<?php /* Smarty version Smarty-3.1.17, created on 2020-04-05 18:01:28
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/sequence/menu-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3602951205e89ac78109488-73299035%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '172080b8d1036a3fe0aac88ad4816089b2599229' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/sequence/menu-list.tpl',
      1 => 1579405884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3602951205e89ac78109488-73299035',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'seqregion' => 0,
    'statInfo' => 0,
    'area_info' => 0,
    'name' => 0,
    'menuCate' => 0,
    'cate' => 0,
    'val' => 0,
    'list' => 0,
    'showPage' => 0,
    'paginator' => 0,
    'menuCategory' => 0,
    'independent' => 0,
    'levelCount' => 0,
    'now' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e89ac7819c863_78014532',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e89ac7819c863_78014532')) {function content_5e89ac7819c863_78014532($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
<style type="text/css">
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        white-space: nowrap;
        min-width: auto;
    }
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
    select.form-control{
		-webkit-appearance: none;
	}
    .tgl-light+ .tgl-btn{
        border-radius:1.5em;

    }
    .tgl+.tgl-btn{
        width: 3em;
        height: 1.5em;
    }
    .main-container{
        overflow-x: hidden;
    }
    .btn-xs{
        padding: 0 5px!important;
    }
    .new-action a{
        transition: 0.5s;
        color: #9a999e!important;
    }
    .new-action a:hover{
        text-decoration: none!important;
        color: #333!important;
    }
    .new-action a i{
        font-size: 14px;
        margin-right: 5px;
    }
    .tooltip {
        white-space:normal!important;
    }
    .area-link{
        margin-right:8px;
    }
    .text-justify{
        text-align:justify;
        text-align-last:justify;
    }
    .text-justify .justify-span{
        display:inline-block;
        width: 60px;
    }
    #sample-table-1 td{
        border-right: 1px solid #efefef;
    }
    #sample-table-1 td:nth-of-type(1),#sample-table-1 td:nth-of-type(2){
        border-right: none;
    }
    #sample-table-1 thead tr{
        background-color: #e0e0e0;
        background-image: linear-gradient(to bottom, #F8F8F8 0, #e0e0e0 100%);
    }
    #sample-table-1 .pro-name a{
        color: #9a999e;
        transition: 0.5s;
    }
    #sample-table-1 .pro-name a:hover{
        color:#428bca;
    }
    .span{
        color: #9a999e;
    }
    .tr-content td{
        transition: 0.5s;
    }
    .tr-content:hover+ .goods-tool td{
        transition: 0.5s;
        background-color: #fff!important;
    }
    .tools{
        border-left: 1px solid #efefef;
        border-right: 1px solid #efefef;
        padding:12px 10px;
    }

</style>
<?php if ($_smarty_tpl->tpl_vars['seqregion']->value==1) {?>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div style="margin-left: 130px">
<?php }?>
<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <input type="hidden" id="hid_table" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<div  id="content-con">
    <div class="ui-popover ui-popover-qrcode left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show" style='padding:20px;'>
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
                    <button class="btn btn-white copy_input" id="copycardid" data-clipboard-target="#copy" style="border-left:0;outline:none;">复制</button>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 汇总信息 -->
    <!--
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
        <?php if ($_smarty_tpl->tpl_vars['area_info']->value=='') {?>
        <div class="balance-info">
            <div class="balance-title">总销量<span></span></div>
            <div class="balance-content">
                <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['soldNum'];?>
</span>
            </div>
        </div>
        <?php }?>
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
    -->
    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/sequence/menuList" method="get" class="form-inline" id="search-form-box">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">菜单名称</div>
                                <input type="text" class="form-control" name="name" value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="商品名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">菜单分类</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control my-select2">
                                    <option value="0">全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuCate']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                    <option <?php if ($_smarty_tpl->tpl_vars['cate']->value==$_smarty_tpl->tpl_vars['val']->value['id']) {?>selected<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>

    <div style="margin-bottom: 20px">
        <a href="/wxapp/sequence/editMenu" class="btn btn-sm btn-green"><i class="icon-plus bigger-80"></i> 新增</a>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead style='border: 1px solid #ddd;'>
                            <tr>
                                <th class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th style="width:40px;">排序</th>
                                <th style='min-width: 270px; width: 350px;'>菜单</th>
                                <th>菜单类型</th>
                                <th>商品数量</th>
                                <th>推广设置</th>
                                <th>添加时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['ams_id'];?>
" class="tr-content" style="border-bottom:0">
                                <!-- 选择框 -->
                                <td class="center" style='width: 50px;min-width: 50px;'>
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['g_id'];?>
"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <!-- 排序 -->
                                <td style="width:40px;">
                                    <span class='span'><?php echo $_smarty_tpl->tpl_vars['val']->value['asm_sort'];?>
</span>
                                    <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_sort'];?>
" data-field="sort" />
                                </td>
                                <!-- 商品 -->
                                <td class="proimg-name" style="min-width: 270px; width: 320px;">
                                    <?php if (isset($_smarty_tpl->tpl_vars['val']->value['asm_cover'])) {?>
                                    <img src="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_cover'];?>
" width="75px" height="75px" alt="封面图" style="border-radius:4px;">
                                    <?php }?>
                                    <div>
                                        <p class="pro-name" style="margin-bottom:6px;">
                                            <a href="/wxapp/sequence/editMenu?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
">
                                                <?php if (mb_strlen($_smarty_tpl->tpl_vars['val']->value['asm_title'])>20) {?><?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['asm_title'],0,20);?>

                                                <?php echo mb_substr($_smarty_tpl->tpl_vars['val']->value['asm_title'],20,40);?>
<?php } else { ?><?php echo $_smarty_tpl->tpl_vars['val']->value['asm_title'];?>
<?php }?>
                                            </a>
                                        </p>
                                        <?php if ($_smarty_tpl->tpl_vars['menuCate']->value[$_smarty_tpl->tpl_vars['val']->value['asm_category']]) {?>
                                        <p style='font-weight: bold;color:#666;'>
                                            分类&nbsp;[<span style='color: #9a999e;'><?php echo $_smarty_tpl->tpl_vars['menuCate']->value[$_smarty_tpl->tpl_vars['val']->value['asm_category']]['title'];?>
</span>]
                                        </p>
                                        <?php }?>
                                    </div>

                                </td>

                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['asm_type']==1) {?>
                                    图文
                                    <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['asm_type']==2) {?>
                                    视频
                                    <?php }?>
                                </td>

                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['asm_goods_num'];?>

                                </td>

                                <td >
                                    <p id="share_num_<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
">
                                        转发数量：<span class='span'><?php echo $_smarty_tpl->tpl_vars['val']->value['asm_share_num'];?>
</span>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_share_num'];?>
" data-field="share_num" />
                                    </p>
                                    <p id="like_num_<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
">
                                       点赞数量： <span class='span'><?php echo $_smarty_tpl->tpl_vars['val']->value['asm_like_num'];?>
</span>
                                        <img src="/public/wxapp/images/icon_edit.png" class="good-admend set-goodsinfo" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" data-value="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_like_num'];?>
" data-field="like_num" />
                                    </p>
                                </td>
                                <td>
                                    <?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['asm_create_time']);?>

                                </td>
                                <!-- 操作 -->
                                <td class='new-action' style="color:#ccc;">
                                    <p>
                                        <!-- 区域管理合伙人隐藏此选项 -->
                                        <a href="/wxapp/sequence/editMenu/?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" title='编辑' >编辑</a>
                                        <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" class="btn-del" data-gid="<?php echo $_smarty_tpl->tpl_vars['val']->value['asm_id'];?>
" title='删除' >删除</a>
                                    </p>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <div style="height: 53px;margin-top: 15px;">
	    <div class="bottom-opera-fixd">
	        <div class="bottom-opera">
	            <div class="bottom-opera-item" style="padding: 13px 0;<?php if ($_smarty_tpl->tpl_vars['showPage']->value==0) {?>text-align: center;<?php }?>">
                    <a href="#" class="btn btn-blue btn-xs js-recharge-btn" data-toggle="modal" data-target="#myModal">修改分类</a>
                    <a href="#" class="btn btn-blueoutline btn-xs btn-multi-delete" data-toggle="modal" data-type="down" >批量删除</a>
	            </div>
	            <div class="bottom-opera-item" style="text-align: right">
	                <div class="page-part-wrap"><?php echo $_smarty_tpl->tpl_vars['paginator']->value;?>
</div>
	            </div>
	        </div>
	    </div>
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
                        修改菜单分类
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kind2" class="control-label">菜单：</label>
                        <div class="control-group" id="customCategory">
                            <select name="menu_cate_select" id="menu_cate_select" class="form-control">
                                <option value="0">请选择</option>
                                <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['menuCategory']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value['title'];?>
</option>
                                <?php } ?>
                            </select>
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
</div>

</div>    <!-- PAGE CONTENT ENDS -->
<?php if ($_smarty_tpl->tpl_vars['seqregion']->value==1) {?>
</div>
<?php }?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clipboard@2/dist/clipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">

    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy_input');
    // 复制内容到剪贴板成功后的操作
    clipboard.on( 'success', function(e) {
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
            $(".ui-popover.ui-popover-qrcode").css({'left':left-conLeft-520,'top':top-conTop-158-72}).stop().show();
        }
    });

    /*修改商品信息*/
    $("#content-con").on('click', 'table td .good-admend.set-goodsinfo', function(event) {
        var id = $(this).data('id');
        var field = $(this).data('field');
        let table=$(this).data('table');
        //var value = $(this).data('value');
        var value = $(this).parent().find(".span").text();//直接取span标签内数值,防止更新后value不变
        $('#hid_gid').val(id);
        $('#hid_field').val(field);
        $('#currValue').val(value);
        $('#hid_table').val(table);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        // 设置位置
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        if(field == 'sort'){
            $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft+3,'top':top-conTop-66}).stop().show();
        }else{
            $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-66}).stop().show();
        }

    });

    //重新生成商品二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var independent = '<?php echo $_smarty_tpl->tpl_vars['independent']->value;?>
';

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/createQrcode',
            'data'  : {id:id,independent:independent},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                layer.close(index);
                if(ret.ec == 200){
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }

    function showVipPriceModal(id) {
        // 先判断是否添加了会员等级
        var levelCount = '<?php echo $_smarty_tpl->tpl_vars['levelCount']->value;?>
';
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
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/saveVipPrice',
            'data'  : {data:data, type: type, showVip: showVip},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                layer.close(index);
                if(ret.ec == 200){
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
        // event.stopPropagation();
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
        let msg='下架';
        if(type=='up')
            msg='上架';
        var ids  = get_select_all_ids_by_name('ids');
        if(ids && type){

            layer.confirm('确定要'+msg+'商品？', {
                btn: ['确定','取消'], //按钮
                title : '商品上/下架管理'
            }, function(){
                var data = {
                    'ids' : ids,
                    'type' : type
                };
                var url = '/wxapp/goods/shelf';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择菜单');
        }
    });
    $('#change-cate').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            var data = {
                'ids' : ids,
                'cate': $('#menu_cate_select').val()
            };
            var url = '/wxapp/sequence/changeMenuCate';
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
        };
        layer.confirm('您确定要删除吗？', {
            btn: ['删除','暂不删除'] //按钮
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/deleteMenu',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        });
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
        // if(lists){
        //     tableFixedInit();//表格初始化
        //     $(window).resize(function(event) {
        //         tableFixedInit();
        //     });
        // }
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

        $("[data-tooltip='tooltip']").tooltip();

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
        let table =$('#hid_table').val();

        var data = {
          'id'  :id,
          'field' :field,
          'value':value
        };
        if(table)
            data['table']=table;

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeMenuInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.msg(ret.em);
                layer.close(index);
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find(".span").text(value);                   
                    if(field == "sort"){
                        window.location.reload();
                    }
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
        // var status = $(this).data('status');
        var status = $(this).is(':checked');
        let _this=$(this);
        var data = {
            id : id,
            status : status?1:0
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
                    if(status==1){
                        _this.parent().parent().find('.area-link').show();
                    }else{
                        _this.parent().parent().find('.area-link').hide();
                    }
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

    $('#confirm-jump').on('click',function () {
        var goodsAlert = $('input[name=goodsAlert]:checked').val();
        var alertValue = $('#alertValue').val();
        var data = {
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

    $('.btn-multi-delete').on('click',function(){
        var ids  = get_select_all_ids_by_name('ids');
        if(ids){
            layer.confirm('确定要删除所选菜单？', {
                btn: ['确定','取消'], //按钮
                title : '删除'
            }, function(){
                var data = {
                    'ids' : ids
                };
                var url = '/wxapp/sequence/multiDeleteMenu';
                plumAjax(url,data,true);
            });
        }else{
            layer.msg('未选择菜单');
        }
    });


    $('.confirm-handle').on('click',function () {
        $('#hid_handle_id').val($(this).data('id'));
    });

    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_handle_id').val();
        var remark = $('#handle_remark').val();
        var status = $('#handle_status').val();
        var data = {
            id : hid,
            remark : remark,
            status: status
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/seqregion/handleGoodsVerify',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    $('.btn-yesterday-sale').click(function(){
        let gid=$(this).data('id');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/checkGoodsSaleData',
            'data'  : {
                'gid':gid
            },
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec==200){
                    layer.msg('昨日销量:'+ret.data.data);
                }else{
                    layer.msg('暂无数据');
                }
            }
        });
    });
     $('.btn-yesterday-sale').mouseenter(function(){
        let _this=$(this);
        let gid=$(this).data('id');
        let reload=_this.data('reload');
        if(!reload){
            _this.tooltip();
            return;
        }
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/checkGoodsSaleData',
            'data'  : {
                'gid':gid,
                'show_today':1
            },
            'dataType' : 'json',
            success : function(ret){
                _this.data('reload',0);
                _this.attr('title',ret.data.data).tooltip('fixTitle').tooltip('show');;
            }
        });
     });

</script>
<?php }} ?>
