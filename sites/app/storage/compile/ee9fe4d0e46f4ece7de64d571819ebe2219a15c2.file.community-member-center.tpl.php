<?php /* Smarty version Smarty-3.1.17, created on 2019-12-06 17:06:35
         compiled from "/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/member/community-member-center.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10246255565dea1a1b02b072-01458439%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee9fe4d0e46f4ece7de64d571819ebe2219a15c2' => 
    array (
      0 => '/mnt/www/default/duodian/tdtinstall/sites/app/view/template/wxapp/member/community-member-center.tpl',
      1 => 1575623191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10246255565dea1a1b02b072-01458439',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row' => 0,
    'showFree' => 0,
    'haveHhr' => 0,
    'menuType' => 0,
    'tradeNav' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5dea1a1b0e2f32_98927275',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5dea1a1b0e2f32_98927275')) {function content_5dea1a1b0e2f32_98927275($_smarty_tpl) {?><link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<style>
    .fenlei-nav{
        background: #fff;
        margin-bottom: 10px;
    }
    .fenlei-nav li{
        width: 25%;
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
        width: 25%;
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
                    <div class="mobile-content">

                        <div class="member-info" ng-style="{'background-image':'url('+centerInfo.bgSrc+')'}">
                            <!--
                            <div class="member-info" style="background: #179EEF;">
                            -->
                            <div class="base-info">
                                <div class="left-touxiang" style="margin: 0;float: none;display: inline-block"><img src="/public/manage/centermanage/images/Avatar-sample-30@2x.png" alt="头像"></div>
                                <div class="user-name" style="width: auto;padding-left: 0;display: inline-block;float: none" ><!--ng-style="{'color':centerInfo.txtColor}"-->
                                    <p>会员昵称</p>
                                    <!--<p>会员ID：18</p>-->
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
                            <li class="border-b" ng-hide="centerInfo.showlist.myft.isShow==0"><a href="#" class="icon30">{{centerInfo.showlist.myft.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mydd.isShow==0"><a href="#" class="icon29">{{centerInfo.showlist.mydd.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myhx.isShow==0"><a href="#" class="icon5">{{centerInfo.showlist.myhx.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mypt.isShow==0"><a href="#" class="icon_pt">{{centerInfo.showlist.mypt.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['showFree']->value) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myfree.isShow==0"><a href="#" class="icon50">{{centerInfo.showlist.myfree.name}}<span></span></a></li>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['haveHhr']->value==1) {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.myfx.isShow==0"><a href="#" class="icon_fenxiao">{{centerInfo.showlist.myfx.name}}<span></span></a></li>
                            <?php }?>
                        </ul>

                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.myyhq.isShow==0"><a href="#" class="icon_yhq">{{centerInfo.showlist.myyhq.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.mysc.isShow==0"><a href="#" class="icon31">{{centerInfo.showlist.mysc.name}}<span></span></a></li>

                        </ul>

                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.aboutus.isShow==0"><a href="#" class="icon33">{{centerInfo.showlist.aboutus.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myphone.isShow==0"><a href="#" class="icon_phone">{{centerInfo.showlist.myphone.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.myaddr.isShow==0"><a href="#" class="icon9">{{centerInfo.showlist.myaddr.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.kefu.isShow==0"><a href="#" class="icon_mine_kefu">{{centerInfo.showlist.kefu.name}}<span></span></a></li>
                            <li class="border-b" ng-hide="centerInfo.showlist.lottery.isShow==0"><a href="#" class="icon16">{{centerInfo.showlist.lottery.name}}<span></span></a></li>
                            <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                            <li class="border-b" ng-hide="centerInfo.showlist.shopapply.isShow==0"><a href="#" class="icon33">{{centerInfo.showlist.shopapply.name}}<span></span></a></li>
                            <?php }?>
                        </ul>

                        <!--
                        <ul class="user-operation">
                            <li class="border-b" ng-hide="centerInfo.showlist.appletad.isShow==0"><a href="#" class="icon_applet_black">{{centerInfo.showlist.appletad.name}}<span></span></a></li>
                        </ul>
                        -->
                        </div>
                        <div class="style-type-new" ng-show="centerInfo.styleType == 2">
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
                            <div class="fenlei-nav">
                                <div class="style-new-title">
                                    <span>{{centerInfo.serviceTitle}}</span>
                                </div>
                                <ul class="border-t border-b service-nav" style="white-space: normal;">
                                    <li ng-hide="centerInfo.showlist.myft.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/1.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myft.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mydd.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/2.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mydd.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myfree.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/3.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myfree.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mypt.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_pt.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mypt.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myhx.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/5.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myhx.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myyhq.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_coupon.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myyhq.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.mysc.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/7.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.mysc.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.kefu.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_kf.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.kefu.name}}</span>
                                    </li>
                   
                                    <li ng-hide="centerInfo.showlist.myaddr.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/8.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myaddr.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.aboutus.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_yd.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.aboutus.name}}</span>
                                    </li>
                                    <li ng-hide="centerInfo.showlist.myphone.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/14.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myphone.name}}</span>
                                    </li>
                                    <?php if ($_smarty_tpl->tpl_vars['haveHhr']->value==1&&$_smarty_tpl->tpl_vars['menuType']->value!='toutiao') {?>
                                    <li ng-hide="centerInfo.showlist.myfx.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_fx.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.myfx.name}}</span>
                                    </li>

                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value!='toutiao') {?>
                                    <li ng-hide="centerInfo.showlist.lottery.isShow==0">
    <img ng-src="/public/wxapp/images/center/new_cj.png" width="100%" height="100%"  alt="图标">
    <span>{{centerInfo.showlist.lottery.name}}</span>
                                        <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                                    <li ng-hide="centerInfo.showlist.shopapply.isShow==0">
                                        <img ng-src="/public/wxapp/images/center/new_yd.png" width="100%" height="100%"  alt="图标">
                                        <span>{{centerInfo.showlist.shopapply.name}}</span>
                                    </li>
                                    <?php }?>
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
                    <div class="input-groups">
                        <label for="">背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="300" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*300</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">服务标题</label>
                        <input type="text" placeholder="请输入服务标题" maxlength="10" ng-model="centerInfo.serviceTitle">
                    </div>

                    <div class="input-groups" ng-show="centerInfo.styleType == 2">
                        <label for="">开通会员跳转</label>
                        <select class="form-control" name="" id="" ng-model="centerInfo.membercardJump" style="width: 78%">
                            <option value="0">会员卡列表</option>
                            <option value="1">会员卡</option>
                            <!--
                            <option value="2">会员计次卡</option>
                            -->
                            <option value="3">储值卡</option>
                        </select>
                    </div>

                    <!--<div class="input-groups">
                        <label for="">信息文字颜色</label>
                        <input type="text" placeholder="请输入页面标题" id="txtColor">
                    </div>-->
                    <!--
                    <div class="input-groups">
                        <label for="">信息背景图片</label>
                        <div class="topinfo cropper-box" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="300" data-dom-id="bg-img">
                            <img ng-src="{{centerInfo.bgSrc}}"  imageonload="changeBg()" id="bg-img" width="150px" style="display:inline-block;">
                            <span>修改背景图</span>
                            <p>建议尺寸：750*300</p>
                            <input type="hidden" id="center_bg" class="avatar-field bg-img" name="center_bg" />
                        </div>
                    </div>
                    -->
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
                        <span>我的帖子</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyft" data-id="myft" ng-checked="centerInfo.showlist.myft.isShow==1" ng-click="checked($event)">
                                <label for="showmyft">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myft.name"></p>
                        </div>
                    </div>
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
                        <span>我的核销</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyhx" data-id="myhx" ng-checked="centerInfo.showlist.myhx.isShow==1" ng-click="checked($event)">
                                <label for="showmyhx">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myhx.name"></p>
                        </div>
                    </div>
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
                       <span>我的优惠券</span>
                       <div class="check-box">
                           <p>
                               <input type="checkbox" id="showmyyhq" data-id="myyhq" ng-checked="centerInfo.showlist.myyhq.isShow==1" ng-click="checked($event)">
                               <label for="showmyyhq">显示</label>
                           </p>
                           <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myyhq.name"></p>
                       </div>
                   </div>
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
                        <span>管理地址</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyaddr" data-id="myaddr" ng-checked="centerInfo.showlist.myaddr.isShow==1" ng-click="checked($event)">
                                <label for="showmyaddr">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myaddr.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>关于我们</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showaboutus" data-id="aboutus" ng-checked="centerInfo.showlist.aboutus.isShow==1" ng-click="checked($event)">
                                <label for="showaboutus">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.aboutus.name"></p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>客服</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="kefu" data-id="kefu" ng-checked="centerInfo.showlist.kefu.isShow==1" ng-click="checked($event)">
                                <label for="kefu">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.kefu.name"></p>
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
                    <?php if ($_smarty_tpl->tpl_vars['showFree']->value) {?>
                    <div class="check-row">
                        <span>预约订单</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyfree" data-id="myfree" ng-checked="centerInfo.showlist.myfree.isShow==1" ng-click="checked($event)">
                                <label for="showmyfree">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfree.name"></p>
                        </div>
                    </div>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['haveHhr']->value==1&&$_smarty_tpl->tpl_vars['menuType']->value!='toutiao') {?>
                    <div class="check-row">
                        <span>分销中心</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="showmyfx" data-id="myfx" ng-checked="centerInfo.showlist.myfx.isShow==1" ng-click="checked($event)">
                                <label for="showmyfx">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.myfx.name"></p>
                        </div>
                    </div>
                    <?php }?>
                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value!='toutiao') {?>
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
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='toutiao') {?>
                    <div class="check-row">
                        <span>申请入驻</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="shopapply" data-id="shopapply" ng-checked="centerInfo.showlist.shopapply.isShow==1" ng-click="checked($event)">
                                <label for="shopapply">显示</label>
                            </p>
                            <p class="text"><input type="text" class="form-control" maxlength="10" ng-model="centerInfo.showlist.shopapply.name"></p>
                        </div>
                    </div>
                    <?php }?>

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
        console.log("复制成功的内容是："+args.text);
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
                console.log(nowId);
                $('#'+nowId).attr('src',allSrc[0]);
                imgNowsrc = allSrc[0];
            }
        }
    }
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',  ['$scope', '$http', function($scope, $http){
        $scope.navList = <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_nav_list'];?>
;
        $scope.tradeNav = <?php echo $_smarty_tpl->tpl_vars['tradeNav']->value;?>
;
        $scope.centerInfo = {
            headerTitle:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_title'];?>
",
            membercardJump:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_membercard_jump'];?>
",
            txtColor:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_color'];?>
",
            bgSrc:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_bg'];?>
" ?"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_center_bg'];?>
" : '/public/manage/centermanage/images/shk_02.png',
            styleType : "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_style_type'];?>
",
            serviceTitle : "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_service_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_service_title'];?>
" : "我的服务",
            adImg:{
                imgSrc:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_img'];?>
",
                link:"<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_link'];?>
",
                adshow:<?php echo $_smarty_tpl->tpl_vars['row']->value['ct_advert_show'];?>

        },

        showlist:{
            mypt :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypt_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mypt_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mypt_name'];?>
<?php } else { ?>我的拼团<?php }?>"
            },
            myyhq : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myyhq_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myyhq_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myyhq_name'];?>
<?php } else { ?>我的优惠券<?php }?>"
            },
            myaddr : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myaddr_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myaddr_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myaddr_name'];?>
<?php } else { ?>管理地址<?php }?>"
            },
            mysc : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mysc_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mysc_name'];?>
<?php } else { ?>我的收藏<?php }?>"
            },
            myhx : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myhx_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myhx_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myhx_name'];?>
<?php } else { ?>我的核销<?php }?>"
            },
            myft : {
                isShow :  <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myft_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myft_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myft_name'];?>
<?php } else { ?>我的帖子<?php }?>"
            },
            mydd : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydd_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_mydd_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_mydd_name'];?>
<?php } else { ?>我的订单<?php }?>"
            },
            aboutus : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_aboutus_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_aboutus_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_aboutus_name'];?>
<?php } else { ?>关于我们<?php }?>"
            },
            appletad : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_appletad_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_appletad_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_appletad_name'];?>
<?php } else { ?>我也要做小程序<?php }?>"
            },
            myfree : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfree_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myfree_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfree_name'];?>
<?php } else { ?>预约订单<?php }?>"
            },
            kefu : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_kefu_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_kefu_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_kefu_name'];?>
<?php } else { ?>客服<?php }?>"
            },
            myfx :{
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfx_show'];?>
,
                name: "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myfx_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myfx_name'];?>
<?php } else { ?>分销中心<?php }?>"
            },
            myphone : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myphone_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_myphone_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_myphone_name'];?>
<?php } else { ?>我的手机号<?php }?>"
            },
            lottery : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_lottery_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_lottery_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_lottery_name'];?>
<?php } else { ?>抽奖<?php }?>"
            },
            shopapply : {
                isShow : <?php echo $_smarty_tpl->tpl_vars['row']->value['ct_shopapply_show'];?>
,
                name : "<?php if ($_smarty_tpl->tpl_vars['row']->value['ct_shopapply_name']) {?><?php echo $_smarty_tpl->tpl_vars['row']->value['ct_shopapply_name'];?>
<?php } else { ?>申请入驻<?php }?>"
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
        $scope.changeBg=function(){
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

            var data = {
                'title'         : $scope.centerInfo.headerTitle,
                'serviceTitle'  : $scope.centerInfo.serviceTitle,
                'membercardJump': $scope.centerInfo.membercardJump,
                'styleType'     : $scope.centerInfo.styleType,
                'color'         : $scope.centerInfo.txtColor,
                'bg'            : $scope.centerInfo.bgSrc,
                'ad_link'       : $scope.centerInfo.adImg.link,
                'ad_img'        : $scope.centerInfo.adImg.imgSrc,
                'advert'        : $scope.centerInfo.adImg.adshow,
                'list'          : $scope.centerInfo.showlist,
                'navList'       :$scope.navList
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

</script><?php }} ?>
