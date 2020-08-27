<?php /* Smarty version Smarty-3.1.17, created on 2020-04-07 16:24:04
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/group/group-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1001492295e8c38a4e58a19-13379190%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4cad0f4ff5faa8c89757b1354899b5a50fb4dc5' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/group/group-list.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1001492295e8c38a4e58a19-13379190',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'canShare' => 0,
    'app_status' => 0,
    'statInfo' => 0,
    'appletCfg' => 0,
    'type' => 0,
    'menuType' => 0,
    'list' => 0,
    'val' => 0,
    'groupType' => 0,
    'time' => 0,
    'color' => 0,
    'yesNo' => 0,
    'groupPath' => 0,
    'pageHtml' => 0,
    'groupCfg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e8c38a5009e58_63755388',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e8c38a5009e58_63755388')) {function content_5e8c38a5009e58_63755388($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .table tbody tr td.good-name{
        white-space: normal;
        min-width: 300px;
    }
    .btn-stop{
        color: #D5912B;
    }

    .btn-delete{
        color: #D52B2B;
    }
    #sample-table-1{
        border-right: none;
        border-left: none;
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
        width: 20%;
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
</style>
<?php echo $_smarty_tpl->getSubTemplate ("../common-second-menu.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div id="content-con">
    <!-- 推广商品弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-name">
                <span class="active">活动二维码</span>
                <span>活动链接</span>
            </div>
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-green" style="line-height: 20px;color: #888;">扫一扫，在手机上查看并分享<a class="new-window pull-right" href="#" target="_blank">帮助</a></div>
                    <div class="code-fenlei">
                        <div class="pull-left">
                            <ul>
                                <li class="active">直接参与活动<i class="icon-play"></i></li>
                                <?php if ($_smarty_tpl->tpl_vars['canShare']->value) {?><li>关注后参与活动<i class="icon-play"></i></li><?php }?>
                            </ul>
                        </div>
                        <div class="pull-right">
                            <div class="text-center show">
                                <img src="" id="act-code-img" alt="二维码">
                                <p>扫码后直接参与活动</p>
                                <div class="text-left">
                                    <a href="" id="tuangou" class="new-window" target="_blank">下载二维码</a>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['canShare']->value) {?>
                            <div class="text-center">
                                <img src="" id="share-code-img" alt="二维码">
                                <p>关注后参与活动</p>
                                <div class="text-left">
                                    <a href="" id="guanzhu" class="new-window" target="_blank">下载二维码</a>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
                <div class="link-box">
                    <div class="alert alert-orange">分享才有更多人看到哦</div>
                    <div class="link-wrap">
                        <p>参与活动链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="" readonly>
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
    <div  id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
        <!--
        <div class="alert alert-block alert-green" style="line-height: 20px;color: #888">
            应用有效期：<?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['app_status']->value['open']);?>
(开通)--<?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['app_status']->value['expire']);?>
(到期)
        </div>
        -->

        <!-- 汇总信息 -->
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">全部活动<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['total'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">进行中<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['going'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已结束<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['expire'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">拼团成功<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['success'];?>
</span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">拼团失败<span></span></div>
                <div class="balance-content">
                    <span class="money"><?php echo $_smarty_tpl->tpl_vars['statInfo']->value['fail'];?>
</span>
                </div>
            </div>
        </div>

        <div class="page-header">
            <a href="/wxapp/group/addGroup" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;"><i class="icon-plus bigger-80"></i> 新增</a>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
            <a class="btn btn-green btn-xs goods-setting" href="#" data-toggle="modal" data-target="#settingModal">活动设置</a>
            <?php }?>
        </div><!-- /.page-header -->
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li  class="<?php if ($_smarty_tpl->tpl_vars['type']->value=='all') {?>active<?php }?>">
                    <a href="/wxapp/group/index">
                        全部拼团
                    </a>
                </li>
                <li  class="<?php if ($_smarty_tpl->tpl_vars['type']->value=='ptpt') {?>active<?php }?>">
                    <a href="/wxapp/group/index/type/ptpt">
                        普通拼团
                    </a>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=27) {?>
                <li class="<?php if ($_smarty_tpl->tpl_vars['type']->value=='cjt') {?>active<?php }?>">
                    <a href="/wxapp/group/index/type/cjt">
                        抽奖团
                    </a>
                </li>
                <?php }?>
                <li class="<?php if ($_smarty_tpl->tpl_vars['type']->value=='tzyht') {?>active<?php }?>">
                    <a href="/wxapp/group/index/type/tzyht">
                        团长优惠团
                    </a>
                </li>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=27) {?>
                <li class="<?php if ($_smarty_tpl->tpl_vars['type']->value=='jtpt') {?>active<?php }?>">
                    <a href="/wxapp/group/index/type/jtpt">
                        阶梯拼团
                    </a>
                </li>
                <?php }?>
            </ul>
            <div class="tab-content"  style="z-index:1;">
        <div class="row">
            <div class="col-xs-12">
                <div class="fixed-table-box">
                    <div class="fixed-table-header">
                        <table class="table table-hover table-avatar">
                            <thead>
                                <tr>
                                    <!--
                                    <th class="center">
                                        <label>
                                            <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    -->
                                    <th>活动类型</th>
                                    <th>封面图</th>
                                    <th>
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==27) {?>
                                        课程
                                        <?php } else { ?>
                                        商品
                                        <?php }?>
                                    </th>
                                    <th>团长价格</th>
                                    <th>团购价格</th>
                                    <th>排序权重</th>
                                    <!--
                                    <th>参团人数</th>
                                    <th>活动时间</th>
                                    -->
                                    <th>活动状态</th>
                                    <!--
                                    <th>凑团显示</th>
                                    <th>自动成团</th>
                                    <th>必需关注</th>
                                    <th>参与情况</th>
                                    -->
                                    <!--
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        更新时间
                                    </th>
                                    -->
                                    <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                    <th>是否已推送</th>
                                    <?php }?>
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
                                <tr id="tr_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
">
                                    <!--
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace" name="ids" value="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </td>
                                    -->
                                    <td><?php echo $_smarty_tpl->tpl_vars['groupType']->value[$_smarty_tpl->tpl_vars['val']->value['gb_type']]['title'];?>
</td>
                                    <td style="width: 160px"><img class="img-thumbnail" src="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_cover'];?>
"></td>
                                    <td class="good-name"><?php echo $_smarty_tpl->tpl_vars['val']->value['g_name'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gb_tz_price'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gb_price'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gb_sort'];?>
</td>
                                    <!--
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gb_total'];?>
</td>
                                    <td>
                                        <p>开始时间：<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['gb_start_time']);?>
</p>
                                        <p>结束时间：<?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['gb_end_time']);?>
</p>
                                    </td>
                                    -->
                                    <!--
                                    <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['gb_start_time']);?>
</td>
                                    <td><?php echo date('Y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['gb_end_time']);?>
</td>
                                    -->
                                    <td id="stop_td_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
"><?php if ($_smarty_tpl->tpl_vars['val']->value['gb_end_time']<$_smarty_tpl->tpl_vars['time']->value['now']) {?>
                                        <!--<span class="label label-sm label-default">已结束</span>-->
                                        <span class="font-color-refuse">已结束</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['gb_start_time']>$_smarty_tpl->tpl_vars['time']->value['now']) {?>
                                        <!--<span class="label label-sm label-info">尚未开始</span>-->
                                        <span class="font-color-audit">尚未开始</span>
                                        <?php } elseif ($_smarty_tpl->tpl_vars['val']->value['gb_start_time']<=$_smarty_tpl->tpl_vars['time']->value['now']&&$_smarty_tpl->tpl_vars['val']->value['gb_end_time']>=$_smarty_tpl->tpl_vars['time']->value['now']) {?>
                                        <!--<span class="label label-sm label-success">进行中</span>-->
                                        <span class="font-color-pass">进行中</span>
                                        <?php }?></td>
                                    <!--
                                    <td><?php echo $_smarty_tpl->tpl_vars['val']->value['gb_show_num'];?>
个</td>
                                    <td><span class="label label-sm label-<?php echo $_smarty_tpl->tpl_vars['color']->value[$_smarty_tpl->tpl_vars['val']->value['gb_use_auto']];?>
"><?php echo $_smarty_tpl->tpl_vars['yesNo']->value[$_smarty_tpl->tpl_vars['val']->value['gb_use_auto']];?>
</span></td>
                                    <td><span class="label label-sm label-<?php echo $_smarty_tpl->tpl_vars['color']->value[$_smarty_tpl->tpl_vars['val']->value['gb_sub_limit']];?>
"><?php echo $_smarty_tpl->tpl_vars['yesNo']->value[$_smarty_tpl->tpl_vars['val']->value['gb_sub_limit']];?>
</span></td>
                                    <td><a href="/wxapp/group/partake/pid/<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" > 查看 </a> </td>
                                    -->
                                    <!--
                                    <td><?php echo date('y-m-d H:i:s',$_smarty_tpl->tpl_vars['val']->value['gb_update_time']);?>
</td>
                                    -->
                                    <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                    <td><?php if ($_smarty_tpl->tpl_vars['val']->value['gb_push']) {?>已推送<?php } else { ?><span style="color: red">未推送</span><?php }?></td>
                                    <?php }?>
                                    <td style="color:#ccc;">
                                        <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('aliapp','bdapp','toutiao','qq','qihoo'))) {?>
                                    	<p>
                                            <a href="javascript:;" onclick="pushGroup('<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
')" >推送</a> -
                                            <?php if (!in_array($_smarty_tpl->tpl_vars['menuType']->value,array('weixin'))) {?>
                                            <a href="javascript:;" data-toggle="modal" data-target="#tplPreviewModal" onclick="showPreview('<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
')">预览</a> -
                                            <?php }?>
                                            <a href="/wxapp/tplpreview/pushHistory?type=group&id=<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" >记录</a>
                                       </p>
                                        <?php }?>
                                       <p>
                                            <a href="/wxapp/group/partake/pid/<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" >参与明细</a> -
                                        <!---活动结束24小时，未抽奖的可以抽奖---->
                                        <?php if ($_smarty_tpl->tpl_vars['val']->value['gb_type']==2&&($_smarty_tpl->tpl_vars['val']->value['gb_end_time']<=$_smarty_tpl->tpl_vars['time']->value['nextDay'])) {?>
                                            <!--<a href="javascript:;" id="luck_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" class="btn-luck" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
">开奖</a> -->
                                        <?php }?>
                                        <a href="javascript:;"  class="info-btn" id="msg_a_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
"
                                           data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
"
                                           data-zfcg-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_zfcg_msgid'];?>
"
                                           data-zfcg-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_zfcg_nwid'];?>
"
                                           data-ktcg-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ktcg_msgid'];?>
"
                                           data-ktcg-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ktcg_nwid'];?>
"
                                           data-spdt-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_spdt_msgid'];?>
"
                                           data-spdt-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_spdt_nwid'];?>
"
                                           data-dpdt-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_dpdt_msgid'];?>
"
                                           data-dpdt-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_dpdt_nwid'];?>
"
                                           data-gbtx-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_gbtx_msgid'];?>
"
                                           data-gbtx-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_gbtx_nwid'];?>
"
                                           data-ptcg-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ptcg_msgid'];?>
"
                                           data-ptcg-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ptcg_nwid'];?>
"
                                           data-ptsb-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ptsb_msgid'];?>
"
                                           data-ptsb-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_ptsb_nwid'];?>
"
                                           data-hdjs-msg="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_hdjs_msgid'];?>
"
                                           data-hdjs-nw="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_hdjs_nwid'];?>
"
                                           >模版消息</a>
                                           - <a href="javascript:;" id="link_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" class="btn-link" data-link="<?php echo $_smarty_tpl->tpl_vars['groupPath']->value;?>
<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
">路径</a>
                                        </p>
                                        <p>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['gb_type']==4) {?>
                                            <a href="/wxapp/group/addSectionGroup/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" >编辑</a>
                                            <?php } else { ?>
                                            <a href="/wxapp/group/addGroup/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" >编辑</a>
                                            <?php }?>
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['gb_type']!=4) {?>
                                             - <a href="/wxapp/group/editGroup/id/<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" >复制</a>
                                            <?php }?>
                                            <!---进行中的可以终止，不可以删除---->
                                            <?php if ($_smarty_tpl->tpl_vars['val']->value['gb_start_time']<=$_smarty_tpl->tpl_vars['time']->value['now']&&$_smarty_tpl->tpl_vars['val']->value['gb_end_time']>=$_smarty_tpl->tpl_vars['time']->value['now']) {?>
                                             - <a href="javascript:;" id="stop_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" class="btn-stop" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
">终止</a>
                                            <?php } else { ?>
                                             - <a href="javascript:;" id="del_<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
" class="btn-delete" data-id="<?php echo $_smarty_tpl->tpl_vars['val']->value['gb_id'];?>
">删除</a>
                                            <?php }?>
                                        </p>
                                    </td>
                                </tr>
                                <?php } ?>
                                <?php if ($_smarty_tpl->tpl_vars['pageHtml']->value) {?>
                                <tr><td colspan="16"><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</td></tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
        </div>
        </div>
    </div>
</div>
<script src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<?php echo $_smarty_tpl->getSubTemplate ("../wechat/modal-select-msg.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<div class="modal fade" id="luckModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 650px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">开奖</h4>
            </div>
            <div class="modal-body">
                <div class="open-winner">
                    <div class="setting-winner" id="item-tuan-div">
                        <!---中奖数据-->
                    </div>
                    <div class="all-tk">
                        <span class="label-name">全部退款</span>
                        <div class="remain-right">
                            <input type="checkbox" class="cus-check" id="tuikuan" checked><label for="tuikuan">自动全部退款</label></span>
                        </div>
                    </div>
                    <div class="tuisong-notice">
                        <span class="label-name">中奖结果推送</span>
                        <div class="remain-right">
                            <div class="radio-box" style="margin-bottom: 5px;">
                                <span>
                                    <input type="radio" name="choosenotice" id="choosenotice1" checked>
                                    <label for="choosenotice1">推送给中奖者</label>
                                </span>
                                <span>
                                    <input type="radio" name="choosenotice" id="choosenotice2">
                                    <label for="choosenotice2">推送给全部参与者</label>
                                </span>
                                <span>
                                    <input type="radio" name="choosenotice" id="choosenotice3">
                                    <label for="choosenotice3">推送给成功参与者</label>
                                </span>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <p class="tips">（模板消息）</p>
                                    <select class="form-control">
                                        <option value="1">请选择模板消息</option>
                                    </select>
                                </div>
                                <!--<div class="col-xs-6">
                                    <p class="tips">（图文消息）</p>
                                    <select class="form-control">
                                        <option value="1">请选择图文消息</option>
                                    </select>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">立即开奖</button>
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

<div class="modal fade" id="settingModal" tabindex="-1" role="dialog" aria-labelledby="settingModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 635px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    活动加群设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-top: 10px;margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">是否开启：</label>
                    <div class="col-sm-8">
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='wxgroupshow' type='checkbox' <?php if ($_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_show']) {?>checked<?php }?>>
                            <label class='tgl-btn' for='wxgroupshow'></label>
                        </span>
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px;margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群LOGO：</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-wxgrouplogo" id="upload-wxgrouplogo"  src="<?php if ($_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_logo']) {?><?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_logo'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_200_200.png<?php }?>"  width="200px" height="200px" style="display:inline-block;margin-left:0;width: 30%;height: 30%">
                                <input type="hidden" id="wxgrouplogo"  class="avatar-field bg-img" name="wxgrouplogo" value="<?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_logo'];?>
"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群标题：</label>
                    <div class="col-sm-8">
                        <input id="wxgroup-title" class="form-control" placeholder="请填写加群标题" style="height:auto!important" value="<?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_title'];?>
"/>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">加群描述：</label>
                    <div class="col-sm-8">
                        <input id="wxgroup-desc" class="form-control" placeholder="请填写加群描述" style="height:auto!important" value="<?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_desc'];?>
"/>
                    </div>
                </div>
                <div class="form-group row" style="margin-right: 0;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">群二维码</label>
                    <div class="col-sm-8">
                        <div>
                            <div>
                                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-wxgroupqrcode" id="upload-wxgroupqrcode"  src="<?php if ($_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_qrcode']) {?><?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_qrcode'];?>
<?php } else { ?>/public/manage/img/zhanwei/zw_fxb_200_200.png<?php }?>" height="200px;" width="200px;" style="display:inline-block;margin-left:0;width: 60%;height: 60%">
                                <input type="hidden" id="wxgroupqrcode"  class="avatar-field bg-img" name="wxgroupqrcode" value="<?php echo $_smarty_tpl->tpl_vars['groupCfg']->value['gc_wxgroup_qrcode'];?>
"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-wxgroup">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/group.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>

    $('#confirm-wxgroup').on('click', function () {
        let data = {
            'show': $('#wxgroupshow:checked').val()=='on'?1:0,
            'title': $('#wxgroup-title').val(),
            'desc': $('#wxgroup-desc').val(),
            'logo': $('#wxgrouplogo').val(),
            'qrcode': $('#wxgroupqrcode').val()
        };

        var loading = layer.load(1, {
            shade: [0.6,'#fff'], //0.1透明度的白色背景
            time: 4000
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/group/saveGroupCfg',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#settingModal').modal('hide');
                }
            }
        });

    })

    $(function(){
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    })
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        // console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
        optshide();
    } );
    
    $('.btn-stop').on('click',function(){
        var data = {
            'id' : $(this).data('id')
        };
        if(data.id){
            layer.confirm('终止会结束活动，不可逆，您确定要终止活动吗？', {
                btn: ['确定','再考虑考虑'] //按钮
            }, function(){
                var loading = layer.load(1, {
                    shade: [0.6,'#fff'], //0.1透明度的白色背景
                    time: 4000
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/group/end',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            $('#stop_'+data.id).hide();
                            $('#stop_td_'+data.id).html('<span class="label label-sm label-default">已结束</span>');
                        }
                    }
                });
            }, function(){

            });
        }
    });
    /**
     * 删除
     */
    $('.btn-delete').on('click',function(){
        var data = {
            'id' : $(this).data('id')
        };
        if(data.id){
            layer.confirm('删除活动不可逆，您确定要删除活动吗？', {
                btn: ['确定','再考虑考虑'] //按钮
            }, function(){
                var loading = layer.load(1, {
                    shade: [0.6,'#fff'], //0.1透明度的白色背景
                    time: 4000
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/group/delGroupBuy',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            $('#tr_'+data.id).hide();
                        }
                    }
                });
            });
        }
    });

    function pushGroup(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/groupPush',
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


    $('.btn-luck').on('click',function(){
        var data = {
          'acid' : $(this).data('id')
        } ;
        var loading = layer.load(1, {
            shade: [0.6,'#fff'], //0.1透明度的白色背景
            time: 4000
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/group/lookLuck',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                if(ret.ec == 200){
                    deal_luck_html(ret.data)
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    function deal_luck_html(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<div class="tuan-win-item">';
            html += '<div class="tuan-name"><span>第'+(i+1)+'抽奖团</span></div>';
            html += '<div class="cantuan-user">';
            var mem = data[i].mem;
            for(var j = 0 ; j < mem.length ; j++){
                html += '<span><input type="checkbox" class="cus-check" id="user'+mem[j].id+'"><label for="user'+mem[j].id+'">'+mem[j].nickname+'</label></span>';
            }
            html += '</div></div>';
        }
        $('#item-tuan-div').html(html);
        $('#luckModal').modal('show');
    }

    /*复制链接地址弹出框*/
     $("#content-con").on('click', 'table td a.btn-link', function(event) {
         var link = $(this).data('link');
         if(link){
             // console.log(link);
            $('.copy-div input').val(link);
         }
         event.preventDefault();
         event.stopPropagation();
         var edithat = $(this) ;
         var conLeft = Math.round($("#content-con").offset().left)-160;
         var conTop  = Math.round($("#content-con").offset().top)-104;
         var left    = Math.round(edithat.offset().left);
         var top     = Math.round(edithat.offset().top);
         $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
         // initCopy();
     });
     // 推广商品弹出框
     $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
         var link   = $(this).data('link');
         var share  = $(this).data('share');
         var linkImg        = '/manage/shop/qrcode?url='+link;
         var shareImg       = share ? '/manage/shop/qrcode?url='+share : linkImg;
         var groupDown      = '/manage/plugin/downCode/?name=tuangou&link='+link;
         var shareDown      = share ? '/manage/plugin/downCode/?name=guanzhu&link='+share : groupDown;
         $('#copyLink').val(link); //购买链接
         $('#act-code-img').attr('src',linkImg); //购买二维码图片
         $('#share-code-img').attr('src',shareImg); //分享二维码图片
         $('#tuangou').attr('href',groupDown); //购买二维码下载
         $('#guanzhu').attr('href',shareDown); //分享二维码下载
         event.preventDefault();
         event.stopPropagation();
         var edithat = $(this) ;
         var conLeft = Math.round($("#content-con").offset().left)-160;
         var conTop = Math.round($("#content-con").offset().top)-104;
         var left = Math.round(edithat.offset().left);
         var top = Math.round(edithat.offset().top);
         optshide();
         $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158}).stop().show();
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
      $("body").on('click', function(event) {
         optshide();
      });
      /*隐藏弹出框*/
      function optshide(){
          $('.ui-popover').stop().hide();
      }
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

    function showPreview(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/tplpreview/groupPreview',
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


</script>
<?php }} ?>
