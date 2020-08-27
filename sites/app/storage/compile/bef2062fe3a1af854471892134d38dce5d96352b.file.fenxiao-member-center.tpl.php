<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 13:00:15
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/fenxiao-member-center.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7198412825e85715fbba194-01539625%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bef2062fe3a1af854471892134d38dce5d96352b' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/member/fenxiao-member-center.tpl',
      1 => 1582198112,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7198412825e85715fbba194-01539625',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'imgurl' => 0,
    'appletCfg' => 0,
    'curr_shop' => 0,
    'knowledgepay_status' => 0,
    'menuType' => 0,
    'tradeNav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e85715fd0f2a1_74017286',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e85715fd0f2a1_74017286')) {function content_5e85715fd0f2a1_74017286($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<style>
    .fenlei-nav{
        background: #fff;
        margin-bottom: 10px;
    }
    .fenlei-nav li{
        width: 24%;
        padding: 8px 10px;
        text-align: center;
        display: inline-block;
        font-size: 12px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .fenlei-nav img{
        width: 35px;
    }

    .fenlei-nav-manage li{
        width: 24%;
        padding: 8px 10px;
        text-align: center;
        display: inline-block;
        font-size: 12px;
    }

    .fenlei-nav-manage img{
        width: 60%;
        margin-bottom: 5px;
    }
    .fenlei-nav-manage .tgl-btn{
        margin: 5px auto;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-bottom: 60px;">
    <!--
    <div class="page-header">
        <div class="input-group">
            <div class="input-group-addon"> 会 &nbsp; 员 &nbsp; 中 &nbsp; 心 : </div>
            <input type="text" class="form-control" id="user_center" value="<?php if ($_smarty_tpl->tpl_vars['row']->value) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['center'];?>
<?php }?>" placeholder="" readonly style="height:35px;">
            <a class="input-group-addon copy_input" data-clipboard-target="user_center">复制</a>
        </div>
    </div>
    -->
    <!-- /.page-header -->
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" ng-bind="centerInfo.headerTitle">
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="mobile-content">  <!--style="background-image:url('')!important;"    style="background-image:url('<?php echo $_smarty_tpl->tpl_vars['imgurl']->value;?>
')!important;"-->
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>
                        <div ng-if="topstyle" class="member-info"  ng-style="{'background-image':'url('+centerInfo.bgSrc+')'}">

                         <?php } else { ?>
                                <div class="member-info" style="background-image:url('')!important;">
                         <?php }?>
                            <div class="base-info">
                                <div class="left-touxiang" style="margin: 0 auto;float: none"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="text-align: center;width: 100%;padding-left: 0;color: black" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <span style="display: block">会员昵称</span>
                                    <span>会员ID：18</span>
                                    <!--<p>会员等级：无</p>-->
                                </div>
                            </div>
                        </div>

                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>
                            <div ng-if="topstyle==0" class="member-info"  style="background-image:url('')!important;">

                                <?php } else { ?>
                                <div class="member-info" style="background-image:url('')!important;">
                                    <?php }?>
                                    <div class="base-info">
                                        <div class="left-touxiang" style="margin: 0 auto;float: none"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                        <div class="user-name" style="text-align: center;width: 100%;padding-left: 0;color: black" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                            <span style="display: block">会员昵称</span>
                                            <span>会员ID：18</span>
                                            <!--<p>会员等级：无</p>-->
                                        </div>
                                    </div>
                                </div>

                        <!-- 分类导航 -->
                        <div class="fenlei-nav" >
                            <ul class="border-t border-b" style="white-space: normal;">
                                <li ng-if="nav.open" ng-repeat="nav in navList">
                                    <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                    <span>{{nav.title}}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="style-type-old" ng-show="centerInfo.styleType == 1">
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon_pt">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.mycj.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.mycj.name}}<span></span></a></li>
                            <?php }?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon_yhq">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.jfshop.isShow==0"><a href="#" class="icon27">{{centerInfo.showlist.jfshop.name}}<span></span></a></li>
                        </ul>
                        <ul class="user-operation">
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.mycj.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.mycj.name}}<span></span></a></li>
                            -->
                            <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon_phone">{{centerInfo.showlist.myphone.name}}<span></span></a></li>

                            <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon_fenxiao">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_deduct']==1) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.mygd.isShow==0"><a href="#" class="icon_gd">{{centerInfo.showlist.mygd.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mygdp.isShow==0"><a href="#" class="icon_gdp">{{centerInfo.showlist.mygdp.name}}<span></span></a></li>
                            <?php }?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myact.isShow==0"><a href="#" class="icon_qb">{{centerInfo.showlist.myact.name}}<span></span></a></li>

                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon_sc">{{centerInfo.showlist.mysc.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mybr.isShow==0"><a href="#" class="icon_zj">{{centerInfo.showlist.mybr.name}}<span></span></a></li>
                            <?php }?>

                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.myjf.isShow==0"><a href="#" class="icon3">{{centerInfo.showlist.myjf.name}}<span></span></a></li>
                            -->

                            <li class="border-b" ng-hide="centerInfo.showlist.mywith.isShow==0"><a href="#" class="icon_tx">{{centerInfo.showlist.mywith.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myreturn.isShow==0"><a href="#" class="icon_return">{{centerInfo.showlist.myreturn.name}}<span></span></a></li>
                            <?php }?>
                        </ul>
                        <ul class="user-operation">
                            <!--
                            <li class="border-b" ng-hide="centerInfo.showlist.myinfo.isShow==0"><a href="#" class="icon8">{{centerInfo.showlist.myinfo.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon12">{{centerInfo.showlist.myphone.name}}<span></span></a></li>
                            -->
                            <li class="border-b" ng-hide="centerInfo.showlist.myaddr.isShow==0"><a href="#" class="icon_addr">{{centerInfo.showlist.myaddr.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mycart.isShow==0"><a href="#" class="icon_cart">{{centerInfo.showlist.mycart.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myread.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.myread.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myappo.isShow==0"><a href="#" class="icon_yy">{{centerInfo.showlist.myappo.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.redbag.isShow==0"><a href="#" class="icon27">{{centerInfo.showlist.redbag.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.helpcenter.isShow==0"><a href="#" class="icon_yy">{{centerInfo.showlist.helpcenter.name}}<span></span></a></li>
                            <?php }?>
                            <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myvault.isShow==0"><a href="#" class="icon_vault">{{centerInfo.showlist.myvault.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.step.isShow==0"><a href="#" class="icon27">{{centerInfo.showlist.step.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.subscribe.isShow==0"><a href="#" class="icon_read">{{centerInfo.showlist.subscribe.name}}<span></span></a></li>
                        </ul>
                        <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.region.isShow==0"><a href="#" class="icon17">{{centerInfo.showlist.region.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.partner.isShow==0"><a href="#" class="icon13">{{centerInfo.showlist.partner.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myvip.isShow==0"><a href="#" class="icon10">{{centerInfo.showlist.myvip.name}}<span></span></a></li>
                        </ul>
                        -->
                                <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.appletad.isShow==0"><a href="#" class="icon_applet_black">{{centerInfo.showlist.appletad.name}}<span></span></a></li>
                        </ul>
                        -->
                        </div>
                        <div class="style-type-new" ng-show="centerInfo.styleType == 2">
                                    <!--
                                    <div class="fenlei-nav" ng-hide="centerInfo.showlist.mydd.isShow==0">
                                        <div class="style-new-title">
                                            <span>{{centerInfo.showlist.mydd.name}}</span>
                                            <span style="font-size:12px;color:#777;float:right">查看全部订单 ></span>
                                        </div>
                                        <ul class="border-t border-b" style="white-space: normal;">

                                            <li ng-repeat="item in tradeNav">
                                                <img ng-src="{{item.imgsrc}}" width="100%" height="100%"  alt="图标">
                                                <span>{{item.title}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    -->
                                    <div class="fenlei-nav">
                                        <div class="style-new-title">
                                            <span>{{centerInfo.serviceTitle}}</span>
                                        </div>
                                        <ul class="border-t border-b service-nav" style="white-space: normal;">
                                            <li ng-hide="centerInfo.showlist.mypt.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_pt.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mypt.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.mycj.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_cj.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mycj.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.myyhq.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_coupon.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myyhq.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.mycart.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_car.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mycart.name}}</span>
                                            </li>
                                             <li ng-hide="centerInfo.showlist.myact.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_qb.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myact.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.jfshop.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_jf.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.jfshop.name}}</span>
                                            </li>
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>
                                            <li ng-hide="centerInfo.showlist.mybr.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/5.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mybr.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.mysc.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/7.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mysc.name}}</span>
                                            </li>
                                                <!--营销商城添加 秒杀、砍价-->
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                                    <li ng-hide="centerInfo.showlist.myms.isShow==0">
                                                        <img ng-src="/public/wxapp/images/center/icon_ms1.png" width="100%" height="100%"  alt="图标">
                                                        <span>{{centerInfo.showlist.myms.name}}</span>
                                                    </li>
                                                    <li ng-hide="centerInfo.showlist.mykj.isShow==0">
                                                        <img ng-src="/public/wxapp/images/center/icon_kj1.png" width="100%" height="100%"  alt="图标">
                                                        <span>{{centerInfo.showlist.mykj.name}}</span>
                                                    </li>
                                                <?php }?>
                                            <?php }?>


                                            <li ng-hide="centerInfo.showlist.myfx.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/icon8.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myfx.name}}</span>
                                            </li>
                                            <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_deduct']==1) {?>
                                            <li ng-hide="centerInfo.showlist.mygd.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/icon9.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mygd.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.mygdp.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/icon10.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mygdp.name}}</span>
                                            </li>
                                            <?php }?>

                                            <li ng-hide="centerInfo.showlist.mywith.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/11.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.mywith.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.myvault.isShow==0">
                                                <img ng-src="/public/mobile/center/images/icon_vault.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myvault.name}}</span>
                                            </li>
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                            <li ng-hide="centerInfo.showlist.myreturn.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/return.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myreturn.name}}</span>
                                            </li>
                                            <?php }?>
                                             <li ng-hide="centerInfo.showlist.myaddr.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_addr.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myaddr.name}}</span>
                                            </li>

                                            <li ng-hide="centerInfo.showlist.myread.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_yd.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myread.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.myphone.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/14.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myphone.name}}</span>
                                            </li>
                                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                            <li ng-hide="centerInfo.showlist.myappo.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/icon_yy1.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.myappo.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.redbag.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_jf.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.redbag.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.helpcenter.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/9.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.helpcenter.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.subscribe.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/9.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.subscribe.name}}</span>
                                            </li>
                                            <?php }?>
                                            <li ng-hide="centerInfo.showlist.lottery.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_cj.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.lottery.name}}</span>
                                            </li>
                                            <li ng-hide="centerInfo.showlist.step.isShow==0">
                                                <img ng-src="/public/wxapp/images/center/new_wxbs.png" width="100%" height="100%"  alt="图标">
                                                <span>{{centerInfo.showlist.step.name}}</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <div class="top-manage">
                    <div class="input-groups">
                        <label for="">页面名称</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="centerInfo.headerTitle">
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>

                    <div class="input-groups">
                        <label for="">页面样式</label>
                        <div class="radio-box">
                                    <span>
                                        <input type="radio" name="indexShow" id="index_yes" value="1" ng-model="centerInfo.styleType" <?php if ($_smarty_tpl->tpl_vars['row']->value['ct_style_type']==1) {?>checked<?php }?>>
                                        <label for="index_yes">旧版小图标</label>
                                    </span>
                            <span>
                                        <input type="radio" name="indexShow" id="index_no" value="2" ng-model="centerInfo.styleType" <?php if ($_smarty_tpl->tpl_vars['row']->value['ct_style_type']==2) {?>checked<?php }?>>
                                        <label for="index_no">新版大图标</label>
                                    </span>
                        </div>
                    </div>
                    <div class="input-groups" >
                        <label for="">背景图是否显示</label>
                        <input class='tgl tgl-light' id='topstyle' type='checkbox' ng-checked='topstyle==1' ng-model="topstyle">
                        <label class='tgl-btn' for='topstyle'></label>
                    </div>
                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">服务标题</label>
                        <input type="text" placeholder="请输入服务标题" maxlength="10" ng-model="centerInfo.serviceTitle">
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">开通会员跳转</label>
                        <select class="form-control" name="" id="" ng-model="centerInfo.membercardJump" style="width: 78%">
                            <option value="0">会员卡列表</option>
                            <option value="1">会员卡</option>
                            <option value="2">计次卡</option>
                            <option value="3">储值卡</option>
                        </select>
                    </div>
                    <?php }?>
                    <?php }?>
                    <!--<div class="input-groups">
                        <label for="">信息文字颜色</label>
                        <input type="text" placeholder="请输入页面标题" id="txtColor">
                    </div>-->
                    <div class="input-groups">
                        <label for="">信息背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="300" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeTopBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*300</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                </div>
                <div class="top-manage">
                    <div class="fenlei-nav-manage" >
                        <ul style="white-space: normal;">
                            <li ng-repeat="nav in navList">
                                <div class="edit-img">
                                    <div style="height:100%;">
                                        <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',nav.index)" data-dom-id="upload-navList{{$index}}" id="upload-navList{{$index}}"  ng-src="{{nav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="navList{{$index}}"  class="avatar-field bg-img" name="navList{{$index}}" ng-value="nav.imgsrc"/>
                                    </div>
                                </div>
                                <input type="text" ng-model="nav.title" class="form-control"/>
                                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='navList{{$index}}_start' type='checkbox' ng-model="nav.open">
                                <label class='tgl-btn' for='navList{{$index}}_start'></label>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="showlist-manage">


                    <div class="check-row">
                        <span>我的拼团</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmypt" data-id="mypt" ng-checked="centerInfo.showlist.mypt.isShow==1" ng-click="checked($event)">
                                <label for="showmypt">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mypt.name"></p>
                        </div>
                    </div>

                    <div class="check-row">
                        <span>我的抽奖团</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmycj" data-id="mycj" ng-checked="centerInfo.showlist.mycj.isShow==1" ng-click="checked($event)">
                                <label for="showmycj">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycj.name"></p>
                        </div>
                    </div>

                    <div class="check-row">
                        <span>我的优惠券</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistcoupon" data-id="myyhq" ng-checked="centerInfo.showlist.myyhq.isShow==1" ng-click="checked($event)">
                                <label for="showlistcoupon">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myyhq.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>手机管理</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistphone" data-id="myphone" ng-checked="centerInfo.showlist.myphone.isShow==1" ng-click="checked($event)">
                                <label for="showlistphone">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myphone.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>积分商城</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showjfshop" data-id="jfshop" ng-checked="centerInfo.showlist.jfshop.isShow==1" ng-click="checked($event)">
                                <label for="showjfshop">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.jfshop.name"></p>
                        </div>
                    </div>

                    <div class="check-row">
                        <span>分销中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist1" data-id="myfx" ng-checked="centerInfo.showlist.myfx.isShow==1" ng-click="checked($event)">
                                <label for="showlist1">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfx.name"></p>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['curr_shop']->value['s_goods_deduct']==1) {?>
                    <div class="check-row">
                        <span>单品分销列表</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmygd" data-id="mygd" ng-checked="centerInfo.showlist.mygd.isShow==1" ng-click="checked($event)">
                                <label for="showmygd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mygd.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>单品分销收益</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmygdp" data-id="mygdp" ng-checked="centerInfo.showlist.mygdp.isShow==1" ng-click="checked($event)">
                                <label for="showmygdp">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mygdp.name"></p>
                        </div>
                    </div>
                    <?php }?>
                    <div class="check-row">
                        <span>我的钱包</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist2" data-id="myact" ng-checked="centerInfo.showlist.myact.isShow==1" ng-click="checked($event)">
                                <label for="showlist2">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myact.name"></p>
                        </div>
                    </div>
                    <!--
                    <div class="check-row">
                        <span>我的积分</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyjf" data-id="myjf" ng-checked="centerInfo.showlist.myjf.isShow==1" ng-click="checked($event)">
                                <label for="showmyjf">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myjf.name"></p>
                        </div>
                    </div>
                    -->

                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==24) {?>
                    <div class="check-row">
                        <span>我的收藏</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmysc" data-id="mysc" ng-checked="centerInfo.showlist.mysc.isShow==1" ng-click="checked($event)">
                                <label for="showmysc">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mysc.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的足迹</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmybr" data-id="mybr" ng-checked="centerInfo.showlist.mybr.isShow==1" ng-click="checked($event)">
                                <label for="showmybr">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mybr.name"></p>
                        </div>
                    </div>
                        <!--营销商城添加 秒杀、砍价-->
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                        <div class="check-row">
                            <span>我的秒杀</span>
                            <div class="check-box">
                                <p>
                                    <input type="checkbox" id="showmyms" data-id="myms" ng-checked="centerInfo.showlist.myms.isShow==1" ng-click="checked($event)">
                                    <label for="showmyms">显示</label>
                                </p>
                                <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myms.name"></p>
                            </div>
                        </div>
                        <div class="check-row">
                            <span>我的砍价</span>
                            <div class="check-box">
                                <p>
                                    <input type="checkbox" id="showmykj" data-id="mykj" ng-checked="centerInfo.showlist.mykj.isShow==1" ng-click="checked($event)">
                                    <label for="showmykj">显示</label>
                                </p>
                                <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mykj.name"></p>
                            </div>
                        </div>
                        <div class="check-row">
                            <span>组队红包</span>
                            <div class="check-box">
                                <p>
                                    <input type="checkbox" id="redbag" data-id="redbag" ng-checked="centerInfo.showlist.redbag.isShow==1" ng-click="checked($event)">
                                    <label for="redbag">显示</label>
                                </p>
                                <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.redbag.name"></p>
                            </div>
                        </div>
                        <div class="check-row">
                            <span>订阅消息</span>
                            <div class="check-box">
                                <p>
                                    <input type="checkbox" id="showsubscribe" data-id="subscribe" ng-checked="centerInfo.showlist.subscribe.isShow==1" ng-click="checked($event)">
                                    <label for="showsubscribe">显示</label>
                                </p>
                                <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.subscribe.name"></p>
                            </div>
                        </div>
                        <?php }?>
                    <?php }?>

                    <div class="check-row">
                        <span>收益提现</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist3" data-id="mywith" ng-checked="centerInfo.showlist.mywith.isShow==1" ng-click="checked($event)">
                                <label for="showlist3">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mywith.name"></p>
                        </div>
                    </div>
                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                    <div class="check-row">
                        <span>订单返现</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyreturn" data-id="myreturn" ng-checked="centerInfo.showlist.myreturn.isShow==1" ng-click="checked($event)">
                                <label for="showmyreturn">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myreturn.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>帮助中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showhelpcenter" data-id="helpcenter" ng-checked="centerInfo.showlist.helpcenter.isShow==1" ng-click="checked($event)">
                                <label for="showhelpcenter">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.helpcenter.name"></p>
                        </div>
                    </div>
                    <?php }?>
                    <!--
                    <div class="check-row">
                        <span>修改资料</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist4" data-id="myinfo" ng-checked="centerInfo.showlist.myinfo.isShow==1" ng-click="checked($event)">
                                <label for="showlist4">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myinfo.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的手机号</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist5" data-id="myphone" ng-checked="centerInfo.showlist.myphone.isShow==1" ng-click="checked($event)">
                                <label for="showlist5">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myphone.name"></p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>地址管理</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist6" data-id="myaddr" ng-checked="centerInfo.showlist.myaddr.isShow==1" ng-click="checked($event)">
                                <label for="showlist6">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myaddr.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的购物车</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="mycart" data-id="mycart" ng-checked="centerInfo.showlist.mycart.isShow==1" ng-click="checked($event)">
                                <label for="mycart">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mycart.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>付费阅读</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showread" data-id="myread" ng-checked="centerInfo.showlist.myread.isShow==1" ng-click="checked($event)">
                                <label for="showread">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myread.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>付费预约</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showappo" data-id="myappo" ng-checked="centerInfo.showlist.myappo.isShow==1" ng-click="checked($event)">
                                <label for="showappo">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myappo.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>抽奖</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="lottery" data-id="lottery" ng-checked="centerInfo.showlist.lottery.isShow==1" ng-click="checked($event)">
                                <label for="lottery">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.lottery.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>小金库</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="myvault" data-id="myvault" ng-checked="centerInfo.showlist.myvault.isShow==1" ng-click="checked($event)">
                                <label for="myvault">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myvault.name"></p>
                        </div>
                    </div>

                    <?php if ($_smarty_tpl->tpl_vars['knowledgepay_status']->value==1) {?>
                    <div class="check-row">
                        <span>我的订单</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydd" data-id="mydd" ng-checked="centerInfo.showlist.mydd.isShow==1" ng-click="checked($event)">
                                <label for="showmydd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydd.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的学习情况</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmystudy" data-id="mystudy" ng-checked="centerInfo.showlist.mystudy.isShow==1" ng-click="checked($event)">
                                <label for="showmystudy">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mystudy.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>我的订阅</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydy" data-id="mydy" ng-checked="centerInfo.showlist.mydy.isShow==1" ng-click="checked($event)">
                                <label for="showmydy">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydy.name"></p>
                        </div>
                    </div>

                    <?php } else { ?>
                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                    <div class="check-row">
                        <span>我的订单</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmydd" data-id="mydd" ng-checked="centerInfo.showlist.mydd.isShow==1" ng-click="checked($event)">
                                <label for="showmydd">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.mydd.name"></p>
                        </div>
                    </div>
                    <?php }?>
                    <?php }?>
                    <div class="check-row">
                        <span>微信步数</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="step" data-id="step" ng-checked="centerInfo.showlist.step.isShow==1" ng-click="checked($event)">
                                <label for="step">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.step.name"></p>
                        </div>
                    </div>
                    <!--
                    <div class="check-row">
                        <span>小程序咨询</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="appletad" data-id="appletad" ng-checked="centerInfo.showlist.appletad.isShow==1" ng-click="checked($event)">
                                <label for="appletad">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.appletad.name"></p>
                        </div>
                    </div>
                    -->
                    <!--
                    <div class="check-row">
                        <span>区域代理商</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="region" data-id="region" ng-checked="centerInfo.showlist.region.isShow==1" ng-click="checked($event)">
                                <label for="region">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.region.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>招募合伙人</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlistpartner" data-id="partner" ng-checked="centerInfo.showlist.partner.isShow==1" ng-click="checked($event)">
                                <label for="showlistpartner">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.partner.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>特级会员</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showlist7" data-id="myvip" ng-checked="centerInfo.showlist.myvip.isShow==1" ng-click="checked($event)">
                                <label for="showlist7">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myvip.name"></p>
                        </div>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert" ><button class="btn btn-primary btn-sm" ng-click="saveCenter();">保存</button></div>
</div>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<script type="text/javascript" src="/public/manage/centermanage/color-spectrum/spectrum.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        
        layer.msg('复制成功');
    } );

    var imgNowsrc='';
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                
                $('#'+nowId).attr('src',allSrc[0]);
                imgNowsrc = allSrc[0];
            }
        }
    }
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',  ['$scope', '$http', function($scope, $http){
        $scope.navList = <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_nav_list'];?>
;
        $scope.topstyle = <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_topstyle'];?>
;
        $scope.tradeNav = <?php echo $_smarty_tpl->tpl_vars['tradeNav']->value;?>
;
        $scope.centerInfo = {
            headerTitle:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_title'];?>
",
            txtColor:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_color'];?>
",
            membercardJump:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_membercard_jump'];?>
",
            styleType : "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_style_type'];?>
",
            serviceTitle : "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_service_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_service_title'];?>
" : "我的服务",
            bgSrc:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_bg'];?>
",
            adImg:{
                imgSrc:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_img'];?>
",
                link:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_link'];?>
",
                adshow:<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_show'];?>
,

        },


            showlist:{
            mypt :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypt_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mypt_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypt_name'];?>
<?php } else { ?>我的拼团<?php }?>"
            },
            mycj :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycj_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mycj_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycj_name'];?>
<?php } else { ?>我的抽奖团<?php }?>"
            },
            myms :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myms_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myms_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myms_name'];?>
<?php } else { ?>我的秒杀<?php }?>"
            },
            mykj :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mykj_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mykj_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mykj_name'];?>
<?php } else { ?>我的砍价<?php }?>"
            },
            mycj :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycj_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mycj_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycj_name'];?>
<?php } else { ?>我的抽奖团<?php }?>"
            },
            myfx :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfx_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myfx_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfx_name'];?>
<?php } else { ?>分销中心<?php }?>"
            },
            myact : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myact_show'];?>
,
                    name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myact_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myact_name'];?>
<?php } else { ?>我的钱包<?php }?>"
            },
            jfshop : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_jfshop_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_jfshop_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_jfshop_name'];?>
<?php } else { ?>积分商城<?php }?>"
            },
            myjf : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myjf_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myjf_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myjf_name'];?>
<?php } else { ?>我的积分<?php }?>"
            },
            myyhq : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myyhq_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myyhq_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myyhq_name'];?>
<?php } else { ?>我的优惠券<?php }?>"
            },
            mywith : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mywith_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mywith_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mywith_name'];?>
<?php } else { ?>余额提现<?php }?>"
            },
            myinfo : {
                isShow : 0,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myinfo_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myinfo_name'];?>
<?php } else { ?>修改资料<?php }?>"
            },
            myphone : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myphone_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myphone_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myphone_name'];?>
<?php } else { ?>我的手机号<?php }?>"
            },
            myaddr : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myaddr_show'];?>
,
                    name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myaddr_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myaddr_name'];?>
<?php } else { ?>收货地址<?php }?>"
            },
            mycart : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycart_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mycart_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mycart_name'];?>
<?php } else { ?>购物车<?php }?>"
            },
            region:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_region_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_region_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_region_name'];?>
<?php } else { ?>区域代理商<?php }?>"
            },
            partner:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_partner_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_partner_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_partner_name'];?>
<?php } else { ?>招募合伙人<?php }?>"
            },
            myvip : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myvip_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myvip_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myvip_name'];?>
<?php } else { ?>特级会员<?php }?>"
            },
            mysc : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mysc_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_name'];?>
<?php } else { ?>我的收藏<?php }?>"
            },
            myft : {
                isShow :  <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myft_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myft_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myft_name'];?>
<?php } else { ?>我的发帖<?php }?>"
            },
            mypl : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypl_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mypl_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypl_name'];?>
<?php } else { ?>我的评论<?php }?>"
            },
            mydd : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydd_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mydd_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydd_name'];?>
<?php } else { ?>我的订单<?php }?>"
            },
            myread : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myread_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myread_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myread_name'];?>
<?php } else { ?>付费阅读<?php }?>"
            },
            mysc : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mysc_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_name'];?>
<?php } else { ?>我的收藏<?php }?>"
            },
            mybr:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mybr_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mybr_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mybr_name'];?>
<?php } else { ?>我的足迹<?php }?>"
            },
            mygd:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mygd_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mygd_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mygd_name'];?>
<?php } else { ?>单品分销<?php }?>"
            },
            mygdp:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mygdp_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mygdp_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mygdp_name'];?>
<?php } else { ?>分享收益<?php }?>"
            },
            myreturn:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myreturn_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myreturn_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myreturn_name'];?>
<?php } else { ?>订单返现<?php }?>"
            },
            myappo:{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myappo_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myappo_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myappo_name'];?>
<?php } else { ?>付费预约<?php }?>"
            },
            appletad : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_appletad_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_appletad_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_appletad_name'];?>
<?php } else { ?>我也要做小程序<?php }?>"
            },
            helpcenter : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_helpcenter_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_helpcenter_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_helpcenter_name'];?>
<?php } else { ?>帮助中心<?php }?>"
            },
            redbag : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_redbag_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_redbag_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_redbag_name'];?>
<?php } else { ?>组队红包<?php }?>"
            },
            lottery : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_lottery_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_lottery_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_lottery_name'];?>
<?php } else { ?>抽奖<?php }?>"
            },
            myvault : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myvault_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myvault_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myvault_name'];?>
<?php } else { ?>小金库<?php }?>"
            },

            mystudy : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mystudy_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mystudy_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mystudy_name'];?>
<?php } else { ?>我的学习情况<?php }?>"
            },
            mydy : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydy_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mydy_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydy_name'];?>
<?php } else { ?>我的订阅<?php }?>"
            },
            step : {
                isShow :  <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_step_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_step_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_step_name'];?>
<?php } else { ?>微信步数<?php }?>"
            },
            subscribe : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_subscribe_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_subscribe_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_subscribe_name'];?>
<?php } else { ?>订阅消息<?php }?>"
            },
        }
    };
        
        
        $scope.adshowChecked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.centerInfo.adImg[dataId] = 1;
            }else{
                $scope.centerInfo.adImg[dataId] = 0;
            }
        };
        $scope.checked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.centerInfo.showlist[dataId].isShow = 1;
            }else{
                $scope.centerInfo.showlist[dataId].isShow = 0;
            }

        };
        $scope.changeTopBg=function(){

            
            
            if(imgNowsrc){
                $scope.centerInfo.bgSrc = imgNowsrc;
            }
        };
        $scope.changeAdImg=function(){
            if(imgNowsrc){
                $scope.centerInfo.adImg.imgSrc = imgNowsrc;
            }
        };

        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        }



        $scope.doThis=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
                $scope[parentType][type][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
                $scope[type][realIndex].imgsrc = imgNowsrc;
            }

        };

        $scope.saveCenter = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var topstyle        = $('#topstyle:checked').val();

            var data = {
                'title'         : $scope.centerInfo.headerTitle,
                'serviceTitle'  : $scope.centerInfo.serviceTitle,
                'styleType'     : $scope.centerInfo.styleType,
                'membercardJump': $scope.centerInfo.membercardJump,
                'color'         : $scope.centerInfo.txtColor,
                'bg'            : $scope.centerInfo.bgSrc,
                'ad_link'       : $scope.centerInfo.adImg.link,
                'ad_img'        : $scope.centerInfo.adImg.imgSrc,
                'advert'        : $scope.centerInfo.adImg.adshow,
                'list'          : $scope.centerInfo.showlist,
                'navList'       : $scope.navList,
                'topstyle'      : topstyle == 'on' ? 1 : 0,
            };
            



            $http({
                method: 'POST',
                url:    '/wxapp/member/saveCenter',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $("#txtColor").spectrum({
                color: "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_color'];?>
",
                showButtons: false,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    $scope.centerInfo.txtColor = realColor;
                    changeTxtcolor(realColor);
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        });
    }]);
    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });
    /*改变文字颜色*/
    function changeTxtcolor(color){
        $(".base-info .user-name").css("color",color);
    }


    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

</script>
<?php }} ?>
