<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:07:28
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4240305355dea1a50ca9887-91595109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7aef8855e33a38abeea32e4b470d6414801089dd' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/community/shop-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4240305355dea1a50ca9887-91595109',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shopLevel' => 0,
    'key' => 0,
    'val' => 0,
    'curr_domain' => 0,
    'shopName' => 0,
    'contact' => 0,
    'menuType' => 0,
    'account' => 0,
    'phone' => 0,
    'list' => 0,
    'category' => 0,
    'district' => 0,
    'showFree' => 0,
    'pagination' => 0,
    'categoryData' => 0,
    'val1' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1a50dca906_43573713',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1a50dca906_43573713')) {function content_5dea1a50dca906_43573713($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">

<style>
    /*
     * 设置等级弹出框
     */
    .page-content{
        position: relative;
    }
    .cate-span{
        display: block;
        text-align:left;
        margin-bottom: 1px;
    }
    .my-ui-btn{
        margin: 0 7px;
    }
    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }
    .alert-orange {
        text-align: center;
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
    .tr-content .good-admend{display:inline-block!important;width:13px;height:13px;cursor:pointer;visibility:hidden;}
	.tr-content:hover .good-admend{visibility:visible;}
</style>
<!-- 修改门店等级 -->
<div class="ui-popover ui-popover-select left-center grade-select" style="top:100px;width: 410px">
    <div class="ui-popover-inner">
        <span></span>
        <select id="shop-grade" name="jiaohuo">
            <?php if ($_smarty_tpl->tpl_vars['shopLevel']->value) {?>
                <option value="0">请选择等级</option>
            <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['shopLevel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['val']->value;?>
</option>
            <?php } ?>
            <?php } else { ?>
                <option value="0">尚未添加等级</option>
            <?php }?>
        </select>
        <input type="hidden" id="hid_mid" value="0">
        <a class="ui-btn ui-btn-primary save-grade" href="javascript:;">确定</a>
        <a class="ui-btn ui-btn-warning remove-grade" href="javascript:;">移除等级</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>
<!-- 修改所属会员 -->
<div class="ui-popover ui-popover-select left-center member-select" style="top:100px;">
    <div class="ui-popover-inner">
        <span style="display: inline-block;width: 100%;text-align: center">更改绑定会员</span>
        <?php echo $_smarty_tpl->getSubTemplate ("../layer/ajax-select-input-single.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

        <input type="hidden" id="hid_esId" value="0">
        <div style="text-align: center">
            <a class="ui-btn ui-btn-primary save-member my-ui-btn" href="javascript:;">确定</a>
            <a class="ui-btn js-cancel my-ui-btn" href="javascript:;" onclick="optshide(this)">取消</a>
        </div>
    </div>
    <div class="arrow"></div>
</div>
<!-- 商家二维码 -->
<div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">商家二维码</span>
                <span>商家链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看</div>
                    <div class="code-fenlei">
                        <div style="text-align: center;margin: 0 auto">
                            <div class="text-center show" >
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后进入商家</p>
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
                        <p>店铺链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="pages/goodDetail/goodDetail" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy-button" id="copygoods" type="button" data-clipboard-action="copy" data-clipboard-target="#copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>


<div class="ui-popover ui-popover-douyin-tuiguang left-center">
    <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
        <div class="tab-name" style="text-align: center;font-size: 17px">
        </div>
        <div class="tab-main">
            <div class="code-box show">
                <div class="alert alert-orange" style="text-align: center">商家二维码</div>
                <div class="code-fenlei">
                    <div style="text-align: center;margin: 0 auto">
                        <div class="text-center show" >
                            <input type="hidden" id="douyin-qrcode-shop-id"/>
                            <img src="" id="douyin-act-code-img" alt="二维码" style="width: 150px">
                            <p>扫码后进入商家</p>
                            <div style="text-align: center">
                                <a href="javascript:;" onclick="reCreateDouyinQrcode()" class="new-window">重新生成</a>-
                                <a href="" id="douyin-download-shop-qrcode" class="new-window">下载二维码</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="arrow"></div>
</div>

<div  id="mainContent" >
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
        商家登录管理地址：<a href="http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index"> http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index</a><a href="javascript:;" class="copy-button btn btn-primary btn-sm" data-clipboard-action="copy" data-clipboard-text="http://<?php echo $_smarty_tpl->tpl_vars['curr_domain']->value;?>
/shop/user/index" style="margin-left: 30px;padding: 3px 6px !important;">复制</a>
            <br>
            <span style="color: red;">提示：已入驻商家的账号密码均默认为填写的手机号</span>
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
<div class="page-header">
            <a href="/wxapp/community/addShop" class="btn btn-green btn-sm"><i class="icon-plus bigger-80"></i> 新增</a>
            <a href="javascript:;" class="btn btn-green btn-xs btn-excel" data-toggle="modal" data-target="#excelShop" ><i class="icon-download"></i>导出店铺</a>
</div><!-- /.page-header -->

<div class="page-header search-box">
    <div class="col-sm-12">
        <form class="form-inline" action="/wxapp/community/shopList" method="get">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">店铺名称</div>
                            <input type="text" class="form-control" name="shopName" value="<?php echo $_smarty_tpl->tpl_vars['shopName']->value;?>
"  placeholder="店铺名称">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">负责人</div>
                            <input type="text" class="form-control" name="contact" value="<?php echo $_smarty_tpl->tpl_vars['contact']->value;?>
"  placeholder="店铺负责人">
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">登录账号</div>
                            <input type="text" class="form-control" name="account" value="<?php echo $_smarty_tpl->tpl_vars['account']->value;?>
"  placeholder="店铺电话">
                        </div>
                    </div>
                    <?php } else { ?>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon">电话</div>
                            <input type="text" class="form-control" name="phone" value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
"  placeholder="店铺电话">
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="col-xs-1 pull-right search-btn">
                <button type="submit" class="btn btn-green btn-sm">查询</button>
            </div>
        </form>
    </div>
</div>
<div id="content-con">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>店铺名称</th>
                            <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                            <th>商家编号</th>
                            <th>类型</th>
                            <?php } else { ?>
                            <th>用户编号</th>
                            <?php }?>
                            <th>负责人</th>
                            <th>登录账号</th>
                            <th>分类</th>
                            <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                            <th>所在地区</th>
                            <?php } else { ?>
                            <th>商圈</th>
                            <?php }?>
                            <!--
                            <th>店铺地址</th>
                            -->
                            <th>到期时间</th>
                            <th>等级权限</th>
                            <!--
                            <th>抽佣比例</th>
                            -->
                            <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                            <th>本月交易额</th>
                            <th>商品数量</th>
                            <th>已提现</th>
                            <th>待提现</th>
                            <?php } else { ?>
                            <th>是否已推送</th>
                            <th>是否开启买单</th>
                            <?php }?>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
?>
                            <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" class="tr-content">
                                <td>
                                    <p><?php echo $_smarty_tpl->tpl_vars['val']->value['es_name'];?>
</p>
                                    <p>营业状态：<?php if ($_smarty_tpl->tpl_vars['val']->value['es_hand_close']==1) {?><span style="color:red;">已打烊</span><?php } else { ?><span style="color: blue">正常</span><?php }?>
                                    </p>
                                    <p>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['es_is_recommend']==1) {?>
                                        <span class="label label-sm label-success">推荐</span>
                                        <?php }?>
                                    </p>
                                </td>
                                <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['es_shop_number'];?>

                                </td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['es_shop_type']==2) {?>
                                    企业
                                    <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['es_shop_type']==1) {?>
                                    个人
                                    <?php }?>
                                </td>
                                <?php } else { ?>
                                <td>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['m_show_id'];?>
<br>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['m_nickname'];?>

                                </td>
                                <?php }?>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_contact'];?>
</td>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['esm_mobile']) {?><?php echo $_smarty_tpl->tpl_vars['val']->value['esm_mobile'];?>
<?php } else { ?>无账号<?php }?>
                                    	<img src="/public/wxapp/images/icon_edit.png" class="good-admend edit-info" data-esmid="<?php echo $_smarty_tpl->tpl_vars['val']->value['esm_id'];?>
"  data-mobile="<?php echo $_smarty_tpl->tpl_vars['val']->value['esm_mobile'];?>
" onclick="" data-toggle="modal" data-target="#infoModal" />
                                    <!--<p style="margin:0;">
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" data-esmid="<?php echo $_smarty_tpl->tpl_vars['val']->value['esm_id'];?>
"  data-mobile="<?php echo $_smarty_tpl->tpl_vars['val']->value['esm_mobile'];?>
" onclick="" data-toggle="modal" data-target="#infoModal">修改账户信息</a>
                                    </p>-->
                                </td>
                                <td><span class="cate-span"><?php echo $_smarty_tpl->tpl_vars['category']->value[$_smarty_tpl->tpl_vars['val']->value['es_cate1']];?>
</span><span class="cate-span"><?php echo $_smarty_tpl->tpl_vars['category']->value[$_smarty_tpl->tpl_vars['val']->value['es_cate2']];?>
</span></td>

                                <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                                <td>
                                    <?php if ($_smarty_tpl->tpl_vars['val']->value['prov_name']&&$_smarty_tpl->tpl_vars['val']->value['city_name']&&$_smarty_tpl->tpl_vars['val']->value['zone_name']) {?>
                                    <?php echo $_smarty_tpl->tpl_vars['val']->value['prov_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['val']->value['city_name'];?>
/<?php echo $_smarty_tpl->tpl_vars['val']->value['zone_name'];?>

                                    <?php }?>
                                </td>
                                <?php } else { ?>
                                <td><span class="cate-span"><?php echo $_smarty_tpl->tpl_vars['district']->value[$_smarty_tpl->tpl_vars['val']->value['es_district2']]['area_name'];?>
</span><span class="cate-span"><?php echo $_smarty_tpl->tpl_vars['district']->value[$_smarty_tpl->tpl_vars['val']->value['es_district2']]['name'];?>
</span></td>
                                <?php }?>

                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_addr'];?>
</td>
                                -->
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_expire_time']>0) {?><?php echo date('Y-m-d H:i',$_smarty_tpl->tpl_vars['val']->value['es_expire_time']);?>
<?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_level']) {?><?php echo $_smarty_tpl->tpl_vars['shopLevel']->value[$_smarty_tpl->tpl_vars['val']->value['es_level']];?>
<?php } else { ?><?php }?></td>
                                <!--
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_maid_proportion'];?>
</td>
                                -->

                                <?php if (in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['tradePayment'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['goodsCount'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['withdraw'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['val']->value['es_balance'];?>
</td>
                                <?php } else { ?>

                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_push']) {?>已推送<?php } else { ?><span style="color:#333">未推送</span><?php }?></td>
                                <td><?php if ($_smarty_tpl->tpl_vars['val']->value['es_isbuy']) {?><span style="color: green;">已开启</span><?php } else { ?><span style="color: red;">已关闭</span><?php }?>
                                    <p style="margin:0;">
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['es_isbuy']) {?>
                                        <a href="javascript:;" class="btn btn-warning btn-xs edit-info" onclick="openShop(this)" data-buy="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_isbuy'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['es_isbuy']) {?>关闭<?php } else { ?>开启<?php }?>
                                        </a>
                                        <?php } else { ?>
                                        <a href="javascript:;" class="btn btn-success btn-xs edit-info" onclick="openShop(this)" data-buy="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_isbuy'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">
                                            开启
                                        </a>
                                        <?php }?>
                                    </p>
                                </td>

                                <?php }?>


                                <td class="jg-line-color">
                                    <p>
                                        <a href="/wxapp/community/shopOrder/esId/<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">商家订单</a>
                                        <?php if ($_smarty_tpl->tpl_vars['showFree']->value) {?>
                                         - <a href="/wxapp/free/freeTradeList?esId=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" class="" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" >预约订单</a>
                                        <?php }?>
                                         - <a class="change-expire" href="#" data-toggle="modal" data-target="#myModal"  data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-expire="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_expire_time'];?>
">延长时间</a>
                                         - <a href="#" class="set-shopgrade" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-level="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_level'];?>
">等级设置</a>-                                       
                                    </p>
                                    <p>

                                         <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                                        <a href="javascript:;" class="btn-douyin-tuiguang" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-share="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_douyin_qrcode'];?>
">二维码</a> -
                                         <?php } else { ?>
                                        <a href="javascript:;" id="link_<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" class="btn-link" data-link="pages/shopDetail/shopDetail?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">店铺路径</a> -
                                        <a href="javascript:;" class="btn-tuiguang" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-share="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_qrcode'];?>
" data-link="pages/shopDetail/shopDetail?id=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">二维码</a> -
                                         <?php }?>

                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                                          <a href="/wxapp/community/claimList/esId/<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">店铺认领</a> -
                                        <?php }?>
                                         <a href="#" class="set-shop-member" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" >绑定会员</a>

                                         <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                                         - <a href="<?php echo $_smarty_tpl->tpl_vars['val']->value['sysurl'];?>
" target="_blank">一键登录</a>
                                         - <a href="/wxapp/goods/index?&plateform=2&esId=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
">商家商品</a>
                                        <?php }?>
                                    </p>
                                    <p>
                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('toutiao'))) {?>
                                        <a href="javascript:;" onclick="pushShop('<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
')" >推送</a>
                                         - <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
')">预览</a>
                                         - <a href="/wxapp/tplpreview/pushHistory?type=cshop&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" >记录</a>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['es_status']==0) {?>
                                         - <a class="confirm-handle" href="#" style="color: red" onclick="changeStatus('<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['val']->value['es_status'];?>
')">封禁</a>
                                        <?php } else { ?>
                                         - <a class="confirm-handle" href="#"  onclick="changeStatus('<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['val']->value['es_status'];?>
')">解封</a>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['es_hand_close']) {?>
                                        - <a href="#" class="hand-close-shop" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-type="0" style="color: blue">开启店铺</a>
                                        <?php } else { ?>
                                        - <a href="#" class="hand-close-shop" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-type="1" style="color: red">打烊店铺</a>
                                        <?php }?>
                                    </p>
                                    <p>
                                        <a href="/wxapp/community/addShop/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" >编辑</a>
                                         - <a href="#" class="delete-shop" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" style="color:#f00;">删除</a>
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['es_list_show']==1) {?>
                                        - <a href="javascript:;" class="change-shop-show" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-status="0" style="color:red;">隐藏店铺</a>
                                        <?php } else { ?>
                                        - <a href="javascript:;" class="change-shop-show" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" data-status="1" style="color:green;">显示店铺</a>
                                        <?php }?>

                                    </p>                                    
                                    <!---<a href="#" class="set-shop" onclick="openShop(this)" data-buy="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_isbuy'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['es_id'];?>
" ><?php if ($_smarty_tpl->tpl_vars['val']->value['es_isbuy']) {?>关闭买单<?php } else { ?>开启买单<?php }?></a>-->


                                </td>
                            </tr>
                            <?php } ?>
                        <tr><td colspan="14"><?php echo $_smarty_tpl->tpl_vars['pagination']->value;?>
</td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
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
                    延长到期时间
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-3 inline-div" style="text-align: right;padding-top: 6px">延长</div>
                        <div class="col-sm-6">
                            <input type="number" name="expire" id="expire" placeholder="请填写整数" class="form-control" >
                        </div>
                        <div class="col-sm-3 inline-div" style="text-align: left;padding-top: 6px">个月</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-expire">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="esmid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    信息修改
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">账号：</label>
                    <div class="col-sm-8">
                        <input id="mobile" class="form-control" placeholder="请填写联系电话" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码：</label>
                    <div class="col-sm-8">
                        <input id="password" autocomplete="off" type="password" class="form-control" placeholder="请填写登录密码" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="excelShop" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 500px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出店铺
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/excel/communityShopExportExcel" method="post">
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">店铺类型</label>
                            <div class="col-sm-6">
                                <select id="category" name="category" style="height:34px;width:100%" class="form-control">
                                    <option value="0" selected>全部</option>
                                    <?php  $_smarty_tpl->tpl_vars['val'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['categoryData']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val']->key => $_smarty_tpl->tpl_vars['val']->value) {
$_smarty_tpl->tpl_vars['val']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['val']->key;
?>
                                    <optgroup label="<?php echo $_smarty_tpl->tpl_vars['val']->value['firstName'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['id'];?>
">
                                        <?php  $_smarty_tpl->tpl_vars['val1'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['val1']->_loop = false;
 $_smarty_tpl->tpl_vars['key1'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['val']->value['secondItem']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['val1']->key => $_smarty_tpl->tpl_vars['val1']->value) {
$_smarty_tpl->tpl_vars['val1']->_loop = true;
 $_smarty_tpl->tpl_vars['key1']->value = $_smarty_tpl->tpl_vars['val1']->key;
?>
                                        <option value="<?php echo $_smarty_tpl->tpl_vars['val1']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['val1']->value['secondName'];?>
</option>
                                        <?php } ?>
                                    </optgroup>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group lookup-condition">
                            <label class="col-sm-2 control-label" style="text-align: right;width: 150px">入驻到期时间</label>
                            <div class="col-sm-6">
                                <input  class="form-control" name="startDate" type="text" class="Wdate" onClick="WdatePicker()" />
                            </div>
                        </div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script>
    // 定义一个新的复制对象
    var clipboard = new ClipboardJS('.copy-button');
    console.log(clipboard);
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
        console.log(e);
        console.log('复制失败');
    });

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
        $(".ui-popover.ui-popover-link").css({'left':left-conLeft-505,'top':top-conTop + 145}).stop().show();
    });

    $('.edit-info').on('click',function () {
        $('#esmid').val($(this).data('esmid'));
        $('#mobile').val($(this).data('mobile'));
    });

    $('#confirm-info').on('click',function(){
        var id      = $('#esmid').val();
        var mobile   = $('#mobile').val();
        var password = $('#password').val();
        var data = {
            id     : id,
            mobile   : mobile,
            password : password
        };
        if(id && mobile && password){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeInfo',
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
        }else{
            layer.msg('请完善账户信息');
        }
    });

    $(function () {
        /*多选列表*/
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1
        });

        $('.save-member').on('click',function(){
            var esId = $('#hid_esId').val();
            var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
            if(!mid){
                layer.msg('请选择会员');
                return;
            }

            console.log(esId);
            console.log(mid);
            var data = {
                'id' : esId,
                'mid': mid
            };
            console.log(data);
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeBelong',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        optshide();
                        window.location.reload();
                    }
                }
            });

        });
    });
    function changeStatus(id, status){
        var data = {
            id: id,
            status: status
        };

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/changeStatus',
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

    }
    $('.delete-shop').on('click',function () {
        var id = $(this).data('id');
       layer.confirm('您确定要删除吗？删除后商家管理员将无法登陆。', {
          btn: ['确定','取消'] //按钮
        }, function(){
           deleteEnterShop(id);
        }, function(){

        });
    });

    $('.hand-close-shop').on('click',function () {
        var id = $(this).data('id');
        var type = $(this).data('type');
        var msg = '';
        if(type == 1){
            msg = '确定要打烊店铺吗？'
        }else{
            msg = '确定要开启店铺吗？'
        }

        layer.confirm(msg, {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                id: id,
                type:type
            };
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/handCloseShop',
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
        }, function(){

        });
    });


    function deleteEnterShop(id) {
        var data = {
            id: id
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/deleteEnterShop',
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

    }

    $('.change-expire').on('click',function () {
        $('#hid_id').val($(this).data('id'));
        $('#now_expire').val($(this).data('expire'));
        $('#expire').val('');
    });

    function pushShop(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/shopPush',
                'data'  : { id:id, type: 'community'},
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
     /*开启或者关闭店铺买单
     */
    function openShop(obj) {
        var id = $(obj).data('id');
        var isbuy = $(obj).data('buy');
        var msg = '';
        if(isbuy){
            msg = '你确定关闭该店铺的买单功能吗？';
        }else{
            msg = '你确定要为该店铺开启买单功能吗?';
        }
        layer.confirm(msg, {
            btn: ['确定','取消'], //按钮
            title : '买单设置'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/openBuy',
                'data'  : { id:id, isbuy:isbuy},
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


    $('#change-expire').on('click',function(){
        var hid = $('#hid_id').val();
        var expire = $('#expire').val();
        var now_expire = $('#now_expire').val();
        console.log(hid);

        if(!expire){
            layer.msg('请填写延长时间');
            return false;
        }

        var data = {
            id : hid,
            expire : expire,
            now_expire : now_expire
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeExpire',
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
        }
    });

    /*设置会员等级*/
    $('#shop-grade').searchableSelect();
    $("#content-con").on('click', 'table td a.set-shopgrade', function(event) {
        var id = $(this).data('id');
        var level = $(this).data('level');
        if(level){
            console.log(level);
           $('#shop-grade').val(level);
        }
        $('#hid_mid').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $(".ui-popover.grade-select").css({'left':left-conLeft-557,'top':top-conTop+48}).stop().show();
    });
    // $(".ui-popover").on('click', function(event) {
    //     event.stopPropagation();
    // });
    /*隐藏设置等级弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
        //清空已选择
        $("#multi-choose").find(".choose-txt").each(function () {
           $(this).remove();
        });
    }
    $("#mainContent").on('click', function(event) {
        optshide();
    });

    $("#content-con").on('click', 'table td a.set-shop-member', function(event) {
        var id = $(this).data('id');
        $('#hid_esId').val(id);
        optshide();
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-106;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        console.log(conTop+"/"+top);
        $("#m_nickname").css('display','inline-block');
        $(".ui-popover.member-select").css({'left':left-conLeft-485,'top':top-conTop+16}).stop().show();
    });

    $(".ui-popover .save-grade").on('click', function(event) {
        var level = $(".ui-popover #shop-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择商家等级');
        }

    });

    $(".ui-popover .remove-grade").on('click', function(event) {
        var id    = $('#hid_mid').val();
        if(id>0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : 0
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择商家等级');
        }

    });

    //重新生成店铺二维码图片
    function reCreateQrcode(){
        var esId = $('#qrcode-goods-id').val();
        console.log(esId);
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/createShopQrcode',
            'data'  : {esId:esId},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                    console.log(ret.url);
                    $(".btn-tuiguang[data-id|='"+esId+"']").attr('data-share',ret.url);
               }
            }
        });
    }

    //重新生成店铺二维码图片
    function reCreateDouyinQrcode(){
        var esId = $('#douyin-qrcode-shop-id').val();
        console.log(esId);
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/createDouyinShopQrcode',
            'data'  : {esId:esId},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#douyin-act-code-img').attr('src',ret.url); //分享二维码图片
                    console.log(ret.url);
                    $(".btn-douyin-tuiguang[data-id|='"+esId+"']").attr('data-share',ret.url);
                }
            }
        });
    }

    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        var link   = $(this).data('link');
        $('#copyLink').val(link); //详情链接
        console.log(shareImg);
        var esId  = that.data('id');
            $('#act-code-img').attr('src',shareImg); //分享二维码图片
            $('#qrcode-goods-id').val(esId);
            $('#download-goods-qrcode').attr('href', '/wxapp/community/downloadShopQrcode?esId='+esId);
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-507,'top':top-conTop+90}).stop().show();

    });

    // 推广商品弹出框
    $("#content-con").on('click', 'table td a.btn-douyin-tuiguang', function(event) {
        var that = $(this);
        var shareImg  = that.data('share');
        console.log(shareImg);
        var esId  = that.data('id');
        $('#douyin-act-code-img').attr('src',shareImg); //分享二维码图片
        $('#douyin-qrcode-shop-id').val(esId);
        $('#douyin-download-shop-qrcode').attr('href', '/wxapp/community/downloadDouyinShopQrcode?esId='+esId);
        event.preventDefault();
        event.stopPropagation();
        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-douyin-tuiguang").css({'left':left-conLeft-507,'top':top-conTop+90}).stop().show();

    });

    $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
        event.preventDefault();
        var $this = $(this);
        var index = $this.index();
        $this.addClass('active').siblings().removeClass('active');
        $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
    });

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/shopPreview',
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
                }else{
                    layer.msg(ret.em);
                }

            }
        });
    }


    $('.change-shop-show').click(function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        var msg = '';
        if(status == 1){
            msg = '显示';
        }else{
            msg = '隐藏';
        }

        var data = {
            id:id,
            status:status
        };

        layer.confirm('是否要'+msg+'当前店铺？', {
            title:'提示',
            btn: ['确定','取消'] //按钮
        },function(){
            var loading = layer.load(2);
            // 会员编号
            $.ajax({
                type:'POST',
                url:'/wxapp/community/changeShopShow',
                dataType:'json',
                data:data,
                success:function(res){
                    layer.close(loading);
                    layer.msg(res.em);
                    if(res.ec == 200){
                        window.location.reload();
                    }
                }
            });
        });

    });

</script><?php }} ?>
