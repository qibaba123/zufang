<?php /* Smarty version Smarty-3.1.17, created on 2020-02-20 10:47:02
         compiled from "/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/customtpl/setting-new.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17029068915e4df32610aa84-11736175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '357c2b1a637df1b7362dc24252b1ab20e7a84ae0' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/sites/app/view/template/wxapp/customtpl/setting-new.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17029068915e4df32610aa84-11736175',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'appletCfg' => 0,
    'templateSave' => 0,
    'menuType' => 0,
    'page_list' => 0,
    'headerTitle' => 0,
    'showpostlist' => 0,
    'showpostbtn' => 0,
    'pagebgColor' => 0,
    'linkType' => 0,
    'linkTypeNew' => 0,
    'linkList' => 0,
    'information' => 0,
    'kindSelect' => 0,
    'firstKindSelect' => 0,
    'oneKindSelect' => 0,
    'goodsList' => 0,
    'goodsGroup' => 0,
    'expertCategory' => 0,
    'reservationCategory' => 0,
    'expertList' => 0,
    'shopGoodsGroup' => 0,
    'serviceArticle' => 0,
    'categoryList' => 0,
    'groupList' => 0,
    'limitList' => 0,
    'bargainList' => 0,
    'allKindSelect' => 0,
    'informationCategory' => 0,
    'recommendTypeList' => 0,
    'mealActivityList' => 0,
    'independence_kindSelect' => 0,
    'independence_firstKindSelect' => 0,
    'goodsActivityList' => 0,
    'ac_type_aaa' => 0,
    'goodSourceType' => 0,
    'shoplist' => 0,
    'storelist' => 0,
    'shopKindSelect' => 0,
    'community' => 0,
    'jumpList' => 0,
    'gameCategory' => 0,
    'gameList' => 0,
    'templateList' => 0,
    'tabList' => 0,
    'carList' => 0,
    'carShopKindList' => 0,
    'tpl' => 0,
    'carCfg' => 0,
    'quotaList' => 0,
    'mealType' => 0,
    'shopInfo' => 0,
    'appointmentGoodsList' => 0,
    'jobTpl' => 0,
    'jobInfo' => 0,
    'hotelInfo' => 0,
    'positionList' => 0,
    'companySelect' => 0,
    'courseList' => 0,
    'formlist' => 0,
    'articleCoverType' => 0,
    'audioCoverType' => 0,
    'videoCoverType' => 0,
    'lessonType' => 0,
    'limitGoodsGroup' => 0,
    'menuList' => 0,
    'baseComponent' => 0,
    'cityCategory' => 0,
    'marketComponent' => 0,
    'template' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e4df3262922a2_48640304',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e4df3262922a2_48640304')) {function content_5e4df3262922a2_48640304($_smarty_tpl) {?><!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <title>自定义模板</title>
    <link rel="stylesheet" href="/public/wxapp/customtpl/css/base.css">
    <link href="/public/manage/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/public/wxapp/customtpl/plugin/iconfont/iconfont.css">
    <link rel="stylesheet" href="/public/wxapp/customtpl/css/jquery-ui.min.css">
    <link rel="stylesheet" href="/public/wxapp/customtpl/plugin/color-spectrum/spectrum.css">
    <link rel="stylesheet" href="/public/manage/overload.css" />
    <link rel="stylesheet" href="/public/wxapp/customtpl/css/index.css?31">
</head>
<body ng-app="custempApp" ng-controller="custempCtrl">
<section class="custom-tempwrap">
    <section class="top-part">
        <ul class="nav navbar-nav back-opera">
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==33) {?>
            <li><a href="javascript:;" class="cus-btn" onclick="window.history.back()"><i class="icon iconfont icon-fanhui"></i>返回</a></li>
            <?php } else { ?>
            <li><a href="javascript:;" class="cus-btn" ng-click="goBack()"><i class="icon iconfont icon-fanhui"></i>返回</a></li>
            <?php }?>
        </ul>
        <ul class="nav navbar-nav clearfix save-opera ">
            <!-- <li><a href="javascript:;" class="cus-btn"><i class="icon iconfont icon-shezhi"></i>页面设置</a></li> -->
            <li><a href="javascript:;" class="cus-btn" ng-click="saveData()"><i class="icon iconfont icon-baocun"></i>保存</a></li>

            <li><a href="javascript:;" class="cus-btn" ng-click="saveDataAndPreview()"><i class="icon iconfont icon-baocun"></i>保存并预览</a></li>

            <li><a href="javascript:;" class="cus-btn" ng-click="apply()"><i class="icon iconfont icon-fabu1"></i>发布</a></li>
            <?php if ($_smarty_tpl->tpl_vars['templateSave']->value) {?>
            <li><a href="#" class="cus-btn" data-toggle="modal" data-target="#myModal"><i class="icon iconfont icon-baocun"></i>存储为模板</a></li>
            <?php }?>
        </ul>
        <!--             <div class="page-setting">
            <div calss="bgcolor-set"><i class="icon iconfont icon-yanse"></i>页面背景色</div>
        </div> -->
    </section>
    <section class="bottom-part">
        <div class="left-component">
            <div class="component-area-title">
                <div class="component-title">
                    <i class="icon iconfont icon-zujian"></i>组件库
                </div>
            </div>
            <div class="widgets-container">
                <div class="widget-wrap clearfix" id="widgets">
                    <div class="widget-con connect-drag-component" ui-sortable="draggableOptions" ng-repeat="componentData in draggables track by $index" ng-model="componentData">
                        <div class="widget" ng-repeat="compon in componentData track by $index" data-type="{{compon.type}}" data-icon="{{compon.icon}}" data-text="{{compon.typeText}}" data-compondata="{{compon}}" data-draggables="{{draggables}}" ng-click="addComponent($event)">
                            <span class="icon-container"><i class="icon iconfont icon-{{compon.icon}}"></i></span>
                            <label>{{compon.typeText}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=3&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=30&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=36) {?>
            <div class="component-area-title">
                <div class="component-title">
                    <i class="icon iconfont icon-zujian"></i>营销组件
                </div>
            </div>
            <div class="widgets-container">
                <div class="widget-wrap clearfix" id="widgets">
                    <div class="widget-con connect-drag-component" ui-sortable="draggableOptions" ng-repeat="componentData in marketDraggables track by $index" ng-model="componentData">
                        <div class="widget" ng-repeat="compon in componentData track by $index" data-type="{{compon.type}}" data-icon="{{compon.icon}}" data-text="{{compon.typeText}}" data-compondata="{{compon}}" data-draggables="{{draggables}}" ng-click="addComponent($event)">
                            <span class="icon-container"><i class="icon iconfont icon-{{compon.icon}}"></i></span>
                            <label>{{compon.typeText}}</label>
                        </div>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
        <div class="middle-page">
            <div class="page-show" id="canvas-image">
                <div class="title-bar"><span></span></div>
                <div class="title-name curedit" data-left-preview data-id="-1" setclick>
                    <img src="/public/wxapp/customtpl/images/title-bar.jpg" alt="图片背景">
                    <p ng-bind="headerTitle"></p>
                </div>
                <div class="page-content" id="pageBox" style="background-color: {{pagebgColor}};">
                    <div class="connect-receive-component" ui-sortable="sortableOptions" ng-model="showComponentData">
                        <div class="ui-widgets-item" data-left-preview ng-repeat="component in showComponentData track by $index" setclick data-type="{{component.type}}" data-id="{{$index}}">
                            <!-- 社区团购  选择小区 -->

                            <div class="select-community-component sequence-select-community" ng-if="component.type=='chooseCommunity' && component.componentStyle != 2">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)" style="display:none">×</div>
                                <div class="select-community-info">
                                    <div class="select-community-info-box">
                                        <img src="/public/wxapp/images/applet-avatar.png" alt="头像" class="select-community-img">
                                    </div>
                                    <div class="select-community-info-box">
                                        <span class="select-community-title">XXXXXXX小区</span>
                                        <span class="select-community-title">团长</span>
                                    </div>
                                    <div class="select-community-info-box">
                                        <span class="select-community-title select-community-connect">联系团长</span>
                                    </div>
                                </div>
                                <hr style="color:#ccc;margin:1px auto;width:90%">
                                <div class="select-community-address">取货地址：XXX市XXX街XX号</div>
                            </div>

                            <div class="select-community-component-new" ng-if="component.type=='chooseCommunity' && component.componentStyle == 2">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)" style="display:none">×</div>
                                <div style="height: 60px;padding: 5px;line-height:50px;position: relative;background-color: {{component.style.backgroundColor}}">
                                    <div class="select-community-compinent-new-text" style="display: inline-block;color: {{component.style.color}};">
                                        小区名称
                                    </div>
                                    <div class="search-wrap select-community-compinent-new-search" style="border-radius: 30px;top: 16%;display: inline-block;line-height: 36px;width: 60%;position: absolute;right: 2%;background-color: {{component.searchArea.backgroundColor}};border:1px solid {{component.searchAreaBorderColor}}">
                                        <div class="search-input" style="padding-left:10px""><span style="color:{{component.searchArea.color}};">请输入搜内容</span><i class="icon iconfont icon-sousuo" style="color:{{component.searchiconColor=='white'?'#fff':'#333'}};position:absolute;right:5%"></i></div>
                                    </div>
                                </div>
                            </div>

                            <!-- 轮播组件 -->
                            <div class="lb-component" ng-if="component.type=='slide'" stylesheet style="{{component.style}}">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="lb-component-con" style="border-radius:{{component.borderRadius}}px;">
                                    <img src="/public/wxapp/customtpl/images/bannerzw_750_400.jpg" ng-if="component.slideimgs.length<=0" class="slide-img" alt="轮播占位">
                                    <img ng-src="{{component.slideimgs[0].img}}" ng-if="component.slideimgs.length>0" class="slide-img" alt="轮播占位">
                                    <div class="dots-wrap">
                                        <span ng-repeat="slide in component.slideimgs track by $index" class="{{$first?'active':''}}" style="background-color: {{$first?component.indicatorActiveColor:component.indicatorColor}}"></span>
                                    </div>
                                </div>
                                <!-- <div class="video-box" ng-if="component.isShowvideo">
                                    <div class="play-btn"><i class="icon iconfont icon-iconfontbofang"></i></div>
                                    13"
                                </div> -->
                            </div>
                            <!-- 视频组件 -->
                            <div class="sp-component" ng-if="component.type=='video'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="video-box" stylesheet style="{{component.style}}">
                                    <div class="video-con"></div>
                                    <span class="icon-box"><i class="icon iconfont icon-iconfontbofang"></i></span>
                                </div>
                            </div>
                            <!-- 分类组件 -->
                            <div class="fl-component styletype-{{component.styleType}} {{component.flitems.length>component.navNumber?'beyond':''}}" ng-if="component.type=='fenlei'" stylesheet style="{{component.style}}">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="empty-tip" ng-if="component.flitems.length<=0">点击此处管理导航~</div>
                                <div class="fl-item stylenum-{{component.navNumber}}" ng-repeat="flnav in component.flitems track by $index" ng-show="{{$index<component.navNumber*2}}" ng-if="component.styleType!=3">
                                    <img ng-src="{{flnav.icon}}" alt="分类图标" style="border-radius: {{component.iconRadius}}px;">
                                    <p>{{flnav.name}}</p>
                                </div>
                                <div class="fl-short-item" ng-if="component.styleType==3" ng-repeat="flnav in component.flitems track by $index">
                                    <img ng-src="{{flnav.icon}}" alt="分类图标" style="border-radius: {{component.iconRadius}}px;">
                                    <div class="right-intro" >
                                        <p class="name">{{flnav.name}}</p>
                                        <p class="brief" style="color: {{component.briefColor}};">{{flnav.brief}}</p>
                                    </div>
                                </div>
                                <div class="dots-wrap" ng-if="component.styleType==2&&component.navpages.length>1">
                                    <span ng-repeat="page in component.navpages" class="{{$first?'active':''}}" style="background-color: {{$first?component.indicatorActiveColor:component.indicatorColor}}"></span>
                                </div>
                            </div>
                            <!-- 搜索组件 -->
                            <div class="ss-component" ng-if="component.type=='search'" >
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="search-wrap" stylesheet style="{{component.searchArea}}">
                                    <div class="search-input" stylesheet style="{{component.style}}"><span style="line-height: {{component.style.height}}px;">{{component.placeHolder}}</span><i class="icon iconfont icon-sousuo" style="color:{{component.searchiconColor=='white'?'#fff':'#333'}};line-height: {{component.style.height}}px;"></i></div>
                                </div>
                            </div>
                            <!-- 地址组件 -->
                            <div class="dz-component" ng-if="component.type=='address'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="address-show" style="margin-top: {{component.style.marginTop}}px;margin-bottom: {{component.style.marginBottom}}px;">
                                    <div class="address-style1 flex-wrap" ng-if="component.addressStyle==1">
                                        <img src="/public/wxapp/customtpl/images/addressIcon/icon_position.png" class="icon_addr" alt="图标">
                                        <div class="flex-con"><div class="address"  style="color:{{component.style.color}};font-size: {{component.style.fontSize}}px;">{{component.address.addr}}</div></div>
                                        <img src="/public/wxapp/customtpl/images/addressIcon/icon_addr_jt.png" class="icon_jt" alt="图标">
                                    </div>
                                    <div class="address-style2" ng-if="component.addressStyle==2">
                                        <div class="addr-item flex-wrap">
                                            <img src="/public/wxapp/customtpl/images/addressIcon/icon_time.png" class="icon_left" alt="图标">
                                            <div class="flex-con"><div class="address"  style="color:{{component.style.color}};font-size: {{component.style.fontSize}}px;">{{component.businessTime}}</div></div>
                                        </div>
                                        <div class="addr-item flex-wrap">
                                            <img src="/public/wxapp/customtpl/images/addressIcon/icon_tel1.png" class="icon_left" alt="图标">
                                            <div class="flex-con"><div class="address"  style="color:{{component.style.color}};font-size: {{component.style.fontSize}}px;">{{component.mobile}}</div></div>
                                            <img src="/public/wxapp/customtpl/images/addressIcon/icon_addr_jt.png" class="icon_jt" alt="图标">
                                        </div>
                                        <div class="addr-item flex-wrap">
                                            <img src="/public/wxapp/customtpl/images/addressIcon/icon_position1.png" class="icon_left" alt="图标">
                                            <div class="flex-con"><div class="address"  style="color:{{component.style.color}};font-size: {{component.style.fontSize}}px;">{{component.address.addr}}</div></div>
                                            <img src="/public/wxapp/customtpl/images/addressIcon/icon_addr_jt.png" class="icon_jt" alt="图标">
                                        </div>
                                    </div>
                                    <div class="address-style3" ng-if="component.addressStyle==3">
                                        <div class="company-intro flex-wrap">
                                            <img ng-src="{{component.companyLogo}}" class="logo" alt="公司logo">
                                            <div class="right-name flex-con">
                                                <div class="flex-wrap">
                                                    <div class="flex-con"><p class="name">{{component.companyName}}</p></div>
                                                    <img src="/public/wxapp/customtpl/images/addressIcon/icon_daohang.png" class="icon_tel" alt="导航">
                                                    <img src="/public/wxapp/customtpl/images/addressIcon/icon_tel.png" class="icon_tel" alt="电话">
                                                    <img src="/public/wxapp/customtpl/images/addressIcon/icon_wechat.png" class="icon_tel" alt="客服">
                                                </div>
                                                <div class="flex-wrap">
                                                    <img src="/public/wxapp/customtpl/images/addressIcon/icon_position.png" class="icon_addr" alt="图标">
                                                    <div class="flex-con"><p class="addr">{{component.address.addr}}</p></div>
                                                    <img src="/public/wxapp/customtpl/images/addressIcon/icon_addr_jt.png" class="icon_jt" alt="客服">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="company-brief">
                                            {{component.companyBrief}}
                                            <span>查看全部</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 通知公告 -->
                            <div class="tzgg-component" ng-if="component.type=='notice'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="notice-show flex-wrap" stylesheet style="{{component.style}}">
                                    <div class="left-title {{component.isBold?'bold':''}}" style="color:{{component.titleColor}};">{{component.titleTxt}}</div>
                                    <div class="flex-con">
                                        <div class="notice-txt">
                                            <p ng-repeat="notice in component.noticeTxt track by $index" ng-if="$index<2">{{notice.text}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 标题组件 -->
                            <div class="bt-component style-{{component.titleStyle}}" ng-if="component.type=='title'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <img ng-src="{{component.titleBg}}" ng-if="component.titleStyle==5" class="title-bg" alt="标题背景">
                                <div class="title-wrap style{{component.titleStyle}}" stylesheet style="{{component.style}}"><div class="title" style="font-weight:{{component.isBold?'bold':''}};"><span class="line" ng-if="component.titleStyle!=5" style="background-color:{{component.lineColor}};"></span>{{component.titleTxt}}</div></div>
                            </div>
                            <!-- 图片组件 -->
                            <div class="img-component" ng-if="component.type=='image'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="image-wrap" stylesheet style="{{component.style}}">
                                    <img class="img-place {{component.imageLocation}}" ng-src="{{component.imageUrl}}" stylesheet style="{{component.imageStyle}}" alt="图片占位">
                                </div>
                            </div>
                            <!-- 橱窗组件 -->
                            <div class="window-component" ng-if="component.type=='window'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="window-wrap style{{component.windowStyle}}" stylesheet style="{{component.style}}">
                                    <div class="window-img-left-wrap">
                                        <img class="img-place {{component.imageLocation}}" ng-src="{{component.link1.imageUrl}}" stylesheet style="{{component.imageStyle}}" alt="图片占位">
                                        <img class="img-place {{component.imageLocation}}" ng-if="component.windowStyle==3" ng-src="{{component.link3.imageUrl}}" stylesheet style="{{component.imageStyle}}" alt="图片占位">
                                    </div>
                                    <div class="window-img-right-wrap">
                                        <img class="img-place {{component.imageLocation}}" ng-src="{{component.link2.imageUrl}}" stylesheet style="{{component.imageStyle}}" alt="图片占位">
                                        <img class="img-place {{component.imageLocation}}" ng-if="component.windowStyle==2" ng-src="{{component.link3.imageUrl}}" stylesheet style="{{component.imageStyle}}" alt="图片占位">
                                    </div>

                                </div>
                            </div>
                            <!-- 按钮组件 -->
                            <div class="btn-component" ng-if="component.type=='button'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="btn-box" stylesheet style="{{component.style}}">
                                    <span class="cus-btn" stylesheet style="{{component.buttonStyle}}">{{component.btntxt}}</span>
                                </div>
                            </div>
                            <!-- 分割线组件 -->
                            <div class="fgx-component" ng-if="component.type=='space'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="space-wrap" stylesheet style="{{component.style}}">
                                    <span class="space {{component.spaceLocation}}" stylesheet style="{{component.spaceStyle}}"></span>
                                </div>
                            </div>
                            <!-- 商品列表组件 -->
                            <div class="goods-component" ng-if="component.type=='goodlist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="goods-list style{{component.goodStyle}}" stylesheet style="{{component.style}}">
                                    <div class="good-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="good-item-con">
                                            <div class="good-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="good-intro">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="good-brief" ng-if="component.goodStyle==2">{{good.brief}}</div>
                                                <div class="good-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> <span class="sold-num" ng-if="component.isShowsold">销量：{{good.sold}}</span></p>
                                                </div>
                                                <!--<div class="add-cart" ng-if="component.isShowcart" ng-style="{'background-color':component.cartBgcolor}">
                                                    <img src="/public/wxapp/customtpl/images/icon_add_cart.png" alt="加购物车">
                                                </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部商品</div>
                            </div>
                            <!-- 酒店房间列表组件 -->
                            <div class="goods-component rooms-component" ng-if="component.type=='roomlist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="goods-list style{{component.goodStyle}}" stylesheet style="{{component.style}}">
                                    <div class="good-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="good-item-con">
                                            <div class="good-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="good-intro">
                                                <div class="good-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> <span class="sold-num" ng-if="component.isShowsold">销量：{{good.sold}}</span></p>
                                                </div>
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="good-brief">{{good.brief}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 知识付费课程列表组件 -->
                            <div class="course-component" ng-if="component.type=='courselist'"  style="background: #fff;">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="course-list style{{component.goodStyle}}" stylesheet style="{{component.style}}">
                                    <div class="course-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="course-item-con">
                                            <div class="course-img" ng-if="component.goodStyle!=5">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="course-intro">
                                                <div class="course-title" stylesheet style="{{component.titleStyle}}">
                                                    <img src="/public/wxapp/customtpl/images/audio-icon.png" alt="" style="display: inline-block;width: 45px;" ng-if="component.goodStyle==5">{{good.title}}
                                                </div>
                                                <div class="course-brief" ng-if="component.goodStyle==2">{{good.brief}}</div>
                                                <div class="course-lable" ng-if="component.goodStyle==2" stylesheet style="{{component.labelStyle}}">课程标签</div>
                                                <div class="course-price {{component.priceBold?'pricebold':''}}" ng-if="component.goodStyle!=5">
                                                    <span class="course-had" ng-if="component.goodStyle==2 || component.goodStyle==3" >已更新2/10期</span>
                                                    <span class="sold-num" ng-if="component.isShowsold">{{good.sold}}人订阅</span>
                                                    <span class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部课程</div>
                            </div>
                            <!-- 培训版课程列表组件 -->
                            <div class="lesson-component" ng-if="component.type=='lessonlist'"  style="background: #fff;">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="lesson-list style{{component.goodStyle}}" stylesheet style="{{component.style}}">
                                    <div class="lesson-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="lesson-item-con">
                                            <div class="lesson-img" ng-if="component.goodStyle!=5">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="lesson-intro">
                                                <div class="lesson-title" stylesheet style="{{component.titleStyle}}">
                                                    <img src="/public/wxapp/customtpl/images/audio-icon.png" alt="" style="display: inline-block;width: 45px;" ng-if="component.goodStyle==5">{{good.title}}
                                                </div>

                                                <div class="lesson-info">
                                                    <span class="lesson-had" >12课时</span>
                                                    <span class="lesson-time" >01.01~01.12</span>
                                                </div>
                                                <div class="lesson-price {{component.priceBold?'pricebold':''}}">
                                                   <span class="sold-num" ng-if="component.isShowsold">{{good.sold}}人在学</span>
                                                    <span class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部课程</div>
                            </div>
                            <!-- 经典语录列表组件 -->
                            <div class="quotation-component" ng-if="component.type=='quotationList'"  style="background: #fff;">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="quotation-list" stylesheet style="{{component.style}}">
                                    <div class="quotation-item border-b" ng-repeat="quotation in component.quotationData track by $index" ng-if="$index<component.quotationNum">
                                        <div class="quotation-item-con">
                                            <div class="quotation-img" ng-if="component.goodStyle!=5">
                                                <img ng-src="{{quotation.cover}}" alt="商品图片">
                                            </div>
                                            <div class="quotation-intro">
                                                <div class="quotation-brief" stylesheet style="{{component.fontStyle}}">{{quotation.brief}}</div>
                                                <div style="text-align: right;margin-top: 15px;"><span style="color: #aaa;margin-right: 5px;"><img src="/public/wxapp/customtpl/images/icon_dianzan.png" alt="" style="width:15px;display: inline-block;margin-right: 5px;position: relative;top: -2px;">666</span><span style="color: #aaa;"><img src="/public/wxapp/customtpl/images/icon_comment.png" alt="" style="width:15px;display: inline-block;margin-right: 5px;position: relative;top: -2px;">666</span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">更多经典语录</div>
                            </div>
                            <!-- 图文列表组件 -->
                            <div class="pictxt-component" ng-if="component.type=='pictxt'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="pic-list style{{component.picStyle}} imgnum{{component.singleImgNum}}"  stylesheet style="{{component.style}}">
                                    <div class="pic-item border-b" ng-repeat="pic in component.picData track by $index">
                                        <div class="pic-item-con">
                                            <div class="img-box">
                                                <img ng-src="{{pic.cover}}" alt="商品图片" stylesheet style="{{component.imageStyle}}">
                                            </div>
                                            <div class="pic-intro style{{component.titleStyle}}" ng-if="component.titleStyle!=3">
                                                <div class="pic-title" stylesheet style="{{component.titleCss}}">{{pic.title}}</div>
                                                <div class="pic-brief" style="color:{{component.briefFontcolor}};" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">{{pic.brief}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 推荐列表组件 -->
                            <div class="pictxt-component" ng-if="component.type=='recommendList'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="pic-list style{{component.picStyle}} imgnum{{component.singleImgNum}}"  stylesheet style="{{component.style}}">
                                    <div class="pic-item border-b" ng-repeat="pic in component.picData | limitTo: component.recommendNum">
                                        <div class="pic-item-con">
                                            <div class="img-box">
                                                <img ng-src="{{pic.cover}}" alt="商品图片" stylesheet style="{{component.imageStyle}}">
                                            </div>
                                            <div class="pic-intro style{{component.titleStyle}}" ng-if="component.titleStyle!=3">
                                                <div class="pic-title" stylesheet style="{{component.titleCss}}">{{pic.title}}</div>
                                                <div class="pic-brief" style="color:{{component.briefFontcolor}};" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">{{pic.brief}}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more" ng-if="component.picStyle!=1&&component.isShowmore">查看更多</div>
                            </div>
                            <!-- 游戏列表组件 -->
                            <div class="games-component" ng-if="component.type=='gamelist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="games-list style{{component.goodStyle}}" stylesheet style="{{component.style}}">
                                    <div class="game-item" ng-repeat="game in component.gamesData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="game-item-con">
                                            <div class="game-img">
                                                <img ng-src="{{game.cover}}" alt="商品图片">
                                            </div>
                                            <div class="game-intro">
                                                <div class="game-title" stylesheet style="{{component.titleStyle}}">{{game.title}} <span class="game-category" ng-if="component.goodStyle==2" stylesheet style="{{component.cateStyle}}">游戏分类</span></div>
                                                <div class="play-num" ng-if="component.goodStyle==3 || component.goodStyle==4"><span>1.5万</span>人在玩</div>
                                                <div class="game-price {{component.priceBold?'pricebold':''}}" ng-if="component.goodStyle==1 || component.goodStyle==2">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}"><span class="sold-num">{{game.brief}}</span> <span >{{game.score}}分</span> </p>
                                                </div>
                                            </div>
                                            <div class="game-play" ng-style="{'background-color':component.openBgcolor}" ng-if="component.goodStyle==2">
                                                <div class="play-bnt">开始</div>
                                                <div class="play-num">5万人在玩</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部游戏</div>
                            </div>
                            <!-- 广告位组件 -->
                            <div class="img-component" ng-if="component.type=='advertisement'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="ad-wrap" stylesheet style="{{component.style}}">
                                    广告位，具体指引查看小程序流量主功能
                                </div>
                            </div>
                            <!-- 餐饮店铺活动列表 -->
                            <div class="mealactivity-component" ng-if="component.type=='mealactivity'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="meal-activity-box" stylesheet style="{{component.style}}">
                                    <div ng-repeat="activity in mealActivityList">
                                        <img src="/public/wxapp/meal/images/new.png" ng-if="$index==0" class="activityicon" alt="图标">
                                        <img src="/public/wxapp/meal/images/discount.png" ng-if="$index==1" class="activityicon" alt="图标">
                                        <img src="/public/wxapp/meal/images/notice.png" ng-if="$index==2" class="activityicon" alt="图标">
                                        <div class="activity-txt">
                                            <p>{{activity.amf_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 店铺列表组件 -->
                            <div class="shop-component" ng-if="component.type=='shoplist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="shop-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType!=3">
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_s_id']==4546) {?>
                                    <div class="notice-box classify-preiview-page" ng-if="component.shopStyle!=3">
                                        <div class="classify-name" style="border-bottom: 1px solid #eee">
                                            <span style="width: 123px;color: dodgerblue;font-weight: bolder;border-bottom: 2px solid dodgerblue;">离我最近</span>
                                            <span style="width: 123px;">人气优先</span>
                                            <span style="width: 123px;">最新入驻</span>
                                        </div>
                                    </div>
                                    <?php }?>
                                    <div class="shop-item border-b" ng-repeat="shop in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.shopNum track by $index">
                                        <div class="shop-item-con">
                                            <div class="shop-img img-place">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片" >
                                            </div>
                                            <div class="shop-intro">
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==33) {?>
                                                <div class="shop-title" stylesheet style="{{component.titleStyle}}">店铺名称</div>

                                                <div class="shop-label" ng-if="component.isShowLabel && component.shopStyle!=3" stylesheet style="{{component.labelStyle}}">店铺标签</div>
                                                <div class="shop-distance" ng-if="component.isShowDistance && component.shopStyle!=3">666m</div>

                                                <?php } else { ?>
                                                <div class="shop-title" stylesheet style="{{component.titleStyle}}">店铺名称</div>
                                                <div class="shop-cate" ng-if="component.isShowCate">分类</div>
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>
                                                <div class="shop-label" ng-if="component.isShowLabel && component.shopStyle!=3" stylesheet style="{{component.labelStyle}}">店铺标签</div>
                                                <?php }?>
                                                <div class="shop-distance" ng-if="component.isShowDistance && component.shopStyle!=3">666m</div>
                                                <div class="shop-show-num" ng-if="component.isShowShowNum">36人浏览</div>
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                                <div class="" style="margin-top:15px" ng-if="component.shopStyle==1">08:00-22:00</div>
                                                <div class="" ng-if="component.shopStyle==1">店铺地址</div>
                                                <?php }?>
                                                <?php }?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="shop-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.shopData.length<=0">添加店铺~</div>
                                    <div class="shop-item border-b" ng-repeat="shop in component.shopData track by $index" ng-if="component.shopData.length>0">
                                        <div class="shop-item-con">
                                            <div class="shop-img img-place">
                                                <img ng-src="{{shop.cover}}" alt="商品图片" >
                                            </div>
                                            <div class="shop-intro">
                                                <div class="shop-title" stylesheet style="{{component.titleStyle}}">{{shop.title}}</div>
                                                <div class="shop-cate" ng-if="component.isShowCate">{{shop.category}}</div>
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>
                                                <div class="shop-label" ng-if="component.isShowLabel && shop.label && component.shopStyle!=3" stylesheet style="{{component.labelStyle}}">{{shop.label}}</div>
                                                <?php }?>
                                                <div class="shop-distance" ng-if="component.isShowDistance && component.shopStyle!=3">666m</div>
                                                <div class="shop-show-num" ng-if="component.isShowShowNum">{{shop.showNum}}人浏览</div>
                                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                                <div class="" style="margin-top:15px" ng-if="component.shopStyle==1">08:00-22:00</div>
                                                <div class="" ng-if="component.shopStyle==1">店铺地址</div>
                                                <?php }?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                <div class="see-more {{component.carStyle==1?'morestyle1':''}}" ng-if="component.carStyle!=4&&component.isShowmore">查看更多店铺</div>
                                <?php } else { ?>
                                <div class="see-more {{component.carStyle==1?'morestyle1':''}}" ng-if="component.carStyle!=4&&component.isShowmore">查看全部店铺</div>
                                <?php }?>
                            </div>
                            <!-- 车源列表组件 -->

                            <div class="goods-component" ng-if="component.type=='carlist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>

                                <div class="goods-list style{{component.carStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">

                                    <div class="good-item border-b" ng-repeat="car in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.carNum track by $index">

                                        <div class="good-item-con">
                                            <div class="good-img">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                            </div>

                                            <div class="good-intro">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">车源名称</div>

                                                <div class="good-brief" ng-if="component.goodStyle==2">地址</div>

                                                <div class="good-price">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}"><span stylesheet style="{{component.priceStyle}}">12.8万</span> <span class="sold-num" ng-if="component.isShowMile">1.3万公里</span></p>
                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="goods-list style{{component.carStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.shopData.length<=0">添加车源~</div>
                                    <div class="good-item border-b" ng-repeat="shop in component.carData track by $index" ng-if="component.carData.length>0">
                                        <div class="good-item-con">
                                            <div class="good-img">
                                                <img ng-src="{{shop.cover}}" alt="商品图片">
                                            </div>
                                            <div class="good-intro">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{shop.name}}</div>
                                                <div class="good-brief" ng-if="component.goodStyle==2">地址</div>
                                                <div class="good-price">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}"><span stylesheet style="{{component.priceStyle}}">{{shop.price}}</span> <span class="sold-num" ng-if="component.isShowMile">{{shop.mile}}</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.carStyle==1?'morestyle1':''}}" ng-if="component.carStyle!=4&&component.isShowmore">查看全部</div>
                            </div>

                            <!-- 商品列表组件 -->

                            <!-- 门店列表组件 -->
                            <div class="store-component" ng-if="component.type=='storelist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="store-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="store-item border-b" ng-repeat="shop in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.shopNum track by $index">
                                        <div class="store-item-con">
                                            <div class="store-img img-place">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片" >
                                            </div>
                                            <div class="store-intro">
                                                <div class="store-title" stylesheet style="{{component.titleStyle}}">店铺名称</div>
                                                <div class="store-distance" ng-if="component.shopStyle!=3">距您1.2公里</div>
                                                <div class="store-address" >地址</div>
                                                <div class="store-status">营业中</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="store-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.shopData.length<=0">添加店铺~</div>
                                    <div class="store-item border-b" ng-repeat="shop in component.shopData track by $index" ng-if="component.shopData.length>0">
                                        <div class="store-item-con">
                                            <div class="store-img img-place">
                                                <img ng-src="{{shop.cover}}" alt="商品图片" >
                                            </div>
                                            <div class="store-intro">
                                                <div class="store-title" stylesheet style="{{component.titleStyle}}">{{shop.title}}</div>
                                                <div class="store-distance" ng-if="component.shopStyle!=3">距您1.2公里</div>
                                                <div class="store-address" >地址</div>
                                                <div class="store-status" >营业中</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部店铺</div>
                            </div>

                            <!-- 酒店门店列表组件 -->
                            <div class="store-component hotel-store-component" ng-if="component.type=='hotelstorelist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="store-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="store-item border-b" ng-repeat="shop in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.shopNum track by $index">
                                        <div class="store-item-con">
                                            <div class="store-img img-place">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片" >
                                            </div>
                                            <div class="store-intro">
                                                <div class="store-title" stylesheet style="{{component.titleStyle}}">店铺名称</div>
                                                <div class="store-desc"><span>5.0分 满意</span> 2条评论</div>
                                                <div class="store-distance">距您1.2公里</div>
                                                <div class="store-address">地址</div>
                                                <div class="area-price">
                                                    <span class="left-area">所在区</span>
                                                    <div class="right-price">￥100.00起</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="store-list style{{component.shopStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.storeData.length<=0">添加店铺~</div>
                                    <div class="store-item border-b" ng-repeat="shop in component.storeData track by $index" ng-if="component.storeData.length>0">
                                        <div class="store-item-con">
                                            <div class="store-img img-place">
                                                <img ng-src="{{shop.cover}}" alt="商品图片" >
                                            </div>
                                            <div class="store-intro">
                                                <div class="store-title" stylesheet style="{{component.titleStyle}}">{{shop.title}}</div>
                                                <div class="store-desc"><span>5.0分 满意</span> 2条评论</div>
                                                <div class="store-distance">距您1.2公里</div>
                                                <div class="store-address">地址</div>
                                                <div class="area-price">
                                                    <span class="left-area">所在区</span>
                                                    <div class="right-price">￥100.00起</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部店铺</div>
                            </div>
                            <!-- 统计组件 -->
                            <div class="statistics-component" ng-if="component.type=='statistics'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="statistics-wrap" stylesheet style="{{component.style}}">
                                    <!--<img src="/public/wxapp/customtpl/images/icon_tj.png" alt="" class="statistic-icon">-->
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                                    <img src="{{$parent.$parent.statIcon}}" alt="" class="statistic-icon">
                                    <span class="statistics" ng-if="component.browseShow">浏览：666</span>
                                    <span class="statistics" ng-if="component.issueShow">发布：666</span>
                                    <span class="statistics" ng-if="component.memberShow">会员：666</span>
                                    <span class="statistics" ng-if="component.shopShow">商家：666</span>
                                    <?php } else { ?>
                                    <img src="{{jobInfo.statIcon}}" alt="" class="statistic-icon">
                                    <span class="statistics" ng-if="component.companyShow">入驻企业：666</span>
                                    <span class="statistics" ng-if="component.positionShow">职位：666</span>
                                    <span class="statistics" ng-if="component.resumeShow">简历：666</span>
                                    <span class="statistics" ng-if="component.browseShow">访问：666</span>
                                    <?php }?>
                                </div>
                            </div>
                            <!-- 分类商品 -->
                            <div class="goods-component" ng-if="component.type=='cateGoods'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="goods-list style2" stylesheet style="{{component.style}}">
                                    <div class="goods-cate-list" ng-show="component.styleType != 3">
                                        <span class="goods-cate" ng-style="{'border-color':component.cateStyle.selectedColor, 'color': $index==0?component.cateStyle.selectedColor:'#000'}" ng-repeat="kind in ((component.cateType==2||!component.cateType)?kindSelect:firstKindSelect) track by $index">{{kind.name}}</span>
                                    </div>
                                    <div class="good-item border-b" ng-repeat="good in ((component.cateType==2||!component.cateType)?kindSelect[0].goodsList:firstKindSelect[0].goodsList) | limitTo : component.goodsNum>0?component.goodsNum:100 track by $index " ng-show="component.styleType != 2 && component.styleType != 3 && component.styleType != 4 && component.styleType != 5">
                                        <div class="good-item-con">
                                            <div class="good-img" style="width:126px;height:126px;position:relative">
                                                <div style="background-color:#2ABF8C;color:#fff;position:absolute;left:10px;padding:2px 3px;font-size:10px" ng-show="component.isShowNum">666</div>
                                                <img ng-src="{{good.g_cover}}" alt="商品图片">
                                            </div>
                                            <div class="good-intro" style="width:236px">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.g_name}}</div>
                                                <div style="margin-top: 3px;"><span style="border: 1px solid red;padding: 3px 8px;border-radius: 10px 0px 0px 10px;color: red;font-size: 12px;">已售{{good.g_sold}}</span><span style="border: 1px solid red;padding: 3px 8px;border-radius: 0 10px 10px 0;background: red;color: #fff;font-size: 12px;">剩余{{good.g_stock}}</span></div>
                                                <div style="margin-top:5px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <div style="color:#ccc;font-size:8px;float:left;height:26px;line-height:25px;margin-left:5px">66人已买</div>
                                                </div>
                                                <div class="good-price {{component.priceBold?'pricebold':''}}" style="position:static">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.g_price}}</span> </p>
                                                    <p class="ori-price" style="color:#ccc;"><del>门店价{{good.g_ori_price}}</del> <span style="color: #333;float: right;"><span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">+</span><span style="display: inline-block;padding: 0px 8px;">1</span> <span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">-</span></span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="good-item border-b" ng-repeat="good in ((component.cateType==2||!component.cateType)?kindSelect[0].goodsList:firstKindSelect[0].goodsList)  | limitTo : component.goodsNum>0?component.goodsNum:100 track by $index " ng-show="component.styleType == 2">
                                        <div class="good-item-con" style="position: relative;">
                                            <div class="good-img" style="float:none;width:100%;height:200px;background:url({{good.g_cover}}) no-repeat center;background-size:cover">

                                            </div>
                                            <div class="good-intro" style="width:98%">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.g_name}}</div>
                                                <div>
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <div style="color:#ccc;font-size:8px;float:left;height:26px;line-height:25px;margin-left:5px">66人已买</div>
                                                </div>
                                                <div style="margin-top: 3px;position:absolute;top:-180px;right:-10px;"><span style="border: 1px solid red;padding: 3px 8px;border-radius: 10px 0px 0px 10px;color: #fff;font-size: 12px;background-color: red">剩余{{good.g_stock}}</span></div>
                                                <div class="good-price {{component.priceBold?'pricebold':''}}">
                                                    <span class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.g_price}}</span> </span>
                                                    <span class="ori-price" style="color:#ccc;display:inline-block;width:80%"><del>门店价{{good.g_ori_price}}</del> <span style="color: #333;float: right;"><span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">+</span><span style="display: inline-block;padding: 0px 8px;">1</span> <span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">-</span></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 滚动 -->
                                    <div class="cateGoods3" ng-show="component.styleType == 3">
	                                    <div class="goods-cate-list style3">
	                                        <span class="goods-cate" ng-repeat="kind in ((component.cateType==2||!component.cateType)?kindSelect:firstKindSelect) track by $index">{{kind.name}}</span>
	                                    </div>
	                                    <div class="good-list3">
	                                    	<div class="scroll-wrap">
			                                    <div class="good-item style3 border-b" ng-repeat="good in ((component.cateType==2||!component.cateType)?kindSelect[0].goodsList:firstKindSelect[0].goodsList) | limitTo : component.goodsNum>0?component.goodsNum:100 track by $index ">
			                                        <div class="good-item-con">
			                                            <div class="good-img">
			                                                <img ng-src="{{good.g_cover}}" alt="商品图片">
			                                            </div>
			                                            <div class="good-intro">
			                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.g_name}}</div>
			                                                <div class="good-price {{component.priceBold?'pricebold':''}}" style="position:static">
			                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.g_price}}</span> </p>
			                                                </div>
			                                            </div>
			                                        </div>
			                                    </div>
		                                    </div>
	                                    </div>
                                    </div>
                                    <!-- 一行两个 -->
                                    <div class="good-item border-b style4" ng-repeat="good in ((component.cateType==2||!component.cateType)?kindSelect[0].goodsList:firstKindSelect[0].goodsList) | limitTo : component.goodsNum>0?component.goodsNum:100 track by $index " ng-show="component.styleType == 4">
                                        <div class="good-item-con">
                                            <div class="good-img">
                                                <img ng-src="{{good.g_cover}}" alt="商品图片">
                                            </div>
                                            <div class="good-intro">
                                                <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.g_name}}</div>
                                                <div class="good-price {{component.priceBold?'pricebold':''}} flex-wrap" style="position:static">
                                                    <p class="now-price flex-con" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.g_price}}</span> </p>
                                                	<p class="sold">销量:22</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- 详细列表 -->
                                    <div class="good-item border-b" ng-repeat="good in ((component.cateType==2||!component.cateType)?kindSelect[0].goodsList:firstKindSelect[0].goodsList)  | limitTo : component.goodsNum>0?component.goodsNum:100 track by $index " ng-show="component.styleType == 5">
                                        <div class="good-item-con" style="position: relative;">
                                            <div class="good-title" stylesheet style="{{component.titleStyle}}">{{good.g_name}}</div>
                                            <div class="cate-goods-label-box" style="margin-top: 3px">
                                                <div class="cate-goods-label-item" style="color: red;border: 1px solid red;display: inline-block;padding: 1px 3px;border-radius: 20px;margin: 0 4px" ng-repeat="label in good.labels track by $index">
                                                    {{label}}
                                                </div>
                                            </div>
                                            <div style="margin-top: 5px">
                                                <div class="cate-goods-slide" ng-repeat="slide in good.slides track by $index" style="display:inline-block;width: 30%;margin: 0 5px">
                                                    <img class="cate-goods-slide-img" src="{{slide}}" alt="" style="width: 100%">
                                                </div>
                                            
                                            </div>
                                            <div class="good-intro" style="width:98%;height:70px">
                                                <div class="good-price {{component.priceBold?'pricebold':''}}" style="bottom:auto !important;margin-top: 3px">
                                                    <span class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.g_price}}</span> </span>
                                                    <span class="ori-price" style="color:#ccc;display:inline-block;width: 70%;position: absolute;right: 0;"> <span style="color: #333;float: right;"><span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">+</span><span style="display: inline-block;padding: 0px 8px;">1</span> <span style="display: inline-block;padding: 0px 8px;background: #eee;color: #aaa;">-</span></span></span>
                                                </div>
                                                <div style="position: absolute;bottom: 0;">
                                                    <div style="margin-top: 3px;position:absolute;"><span style="padding: 3px 8px;font-size: 12px;">剩余{{good.g_stock}}</span></div>
                                                    <div style="display: inline-block;margin-left: 180px">
                                                        <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                        <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                        <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                        <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                        <div style="color:#ccc;font-size:8px;float:left;height:26px;line-height:25px;margin-left:5px">66人已买</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部商品</div>
                            </div>
                            <!-- 分类列表 -->
                            <div class="goods-component catelist-component" ng-if="component.type=='catelist'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="goods-list style2" stylesheet style="{{component.style}}">
                                    <div class="goods-cate-list" >
                                        <span class="goods-cate" ng-style="{'color': component.style.fontColor}" ng-repeat="kind in ((component.cateType==2||!component.cateType)?kindSelect:firstKindSelect) track by $index">{{kind.name}}</span>
                                        <div ng-if="((component.cateType==2||!component.cateType)?kindSelect.length:firstKindSelect.length)<=0" style="width: 375px;text-align: center;padding: 8px;color: #999;">请添加商品分类</div>
                                    </div>
                                </div>
                            </div>
                            <!-- 社区团购活动列表 -->
                            <div class="goods-component" ng-if="component.type=='activityList'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="goods-list style2" stylesheet style="{{component.style}}">
                                    <div class="good-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="$index<component.goodsNum">
                                        <div class="activity-item-con">
                                            <div style="height: 30px;line-height: 30px;">
                                                <div stylesheet style="{{component.titleStyle}}">
                                                活动标题

                                                </div>
                                                <div style="width:20%;display:inline-block;color:#666;fontSize:10px">66人浏览</div>
                                            </div>
                                            <div style="color:#666">
                                                活动简介内容
                                            </div>
                                            <div style="height:80px;width:100%">
                                                <img src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="" style="display:inline-block;width:31%">
                                                <img src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="" style="display:inline-block;width:31%">
                                                <img src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="" style="display:inline-block;width:31%">
                                            </div>
                                            <div style="margin-top:40px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="margin:1px;float:left;height:25px">
                                                    <div style="color:#ccc;font-size:13px;float:left;height:26px;line-height:25px;margin-right:25px;float:right">共<span>66</span>人参与</div>
                                            </div>
                                            <div style="line-height:30px">
                                                <div style="display:inline-block;width:75%;">
                                                    <img src="/public/wxapp/images/applet-avatar.png" alt="" style="display:inline-block;width:25px">
                                                    <span style="fontSize:10px">
                                                    XXX公司
                                                    </span>

                                                </div>
                                                <div style="display:inline-block;width:20%;color:#666;fontSize:10px">
                                                    12月12日
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部商品</div>
                            </div>
                            <!-- 优惠券组件 -->
                            <div class="coupon-component" ng-if="component.type=='coupon'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="coupon-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="coupon-item border-b" ng-repeat="coupon in [1,2,3,4] track by $index">
                                        <img src="/public/wxapp/customtpl/images/coupon_bg.png" alt="" class="coupon-bg">
                                        <div class="coupon-info flex-wrap">
                                            <div class="left-info flex-con">
                                                <div class="money" stylesheet style="{{component.valueStyle}}">
                                                    ￥<span>10</span>
                                                </div>
                                                <div class="use" stylesheet style="{{component.limitStyle}}">
                                                    <span>满100可用</span>
                                                </div>
                                            </div>
                                            <div class="get-tip" stylesheet style="{{component.receiveStyle}}">立即领取</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="coupon-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.couponData.length<=0">添加优惠券~</div>
                                    <div class="coupon-item border-b" ng-repeat="coupon in component.couponData track by $index" ng-if="component.couponData.length>0">
                                        <img src="/public/wxapp/customtpl/images/coupon_bg.png" alt="" class="coupon-bg">
                                        <div class="coupon-info flex-wrap">
                                            <div class="left-info flex-con">
                                                <div class="money" stylesheet style="{{component.valueStyle}}">
                                                    ￥<span>{{coupon.value}}</span>
                                                </div>
                                                <div class="use" stylesheet style="{{component.limitStyle}}">
                                                    <span>满{{coupon.limit}}可用</span>
                                                </div>
                                            </div>
                                            <div class="get-tip" stylesheet style="{{component.receiveStyle}}">立即领取</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- 拼团组件 -->
                            <div class="group-component" ng-if="component.type=='group'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="group-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="group-item border-b" ng-repeat="good in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.goodsNum track by $index">
                                        <div class="group-item-con">
                                            <div class="group-img">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                            </div>
                                            <div class="group-intro">
                                                <div class="group-title" stylesheet style="{{component.titleStyle}}">商品标题</div>
                                                <div class="group-brief" ng-if="component.goodStyle==2">商品简介</div>
                                                <div class="group-sold" ng-if="component.goodStyle==2">66人已团</div>
                                                <div class="group-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">10</span><del class="ori-price" ng-if="component.isShowsold">￥100</del></p>
                                                </div>
                                                <div class="open-group" ng-style="{'background-color':component.openBgcolor}">
                                                    <span>去开团</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="group-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.goodsData.length<=0">添加拼团商品~</div>
                                    <div class="group-item border-b" ng-repeat="good in component.goodsData track by $index"  ng-if="component.goodsData.length>0">
                                        <div class="group-item-con">
                                            <div class="group-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="group-intro">
                                                <div class="group-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="group-brief" ng-if="component.goodStyle==2">{{good.brief}}</div>
                                                <div class="group-sold" ng-if="component.goodStyle==2">{{good.sold}}人已团</div>
                                                <div class="group-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span><del class="ori-price" ng-if="component.isShowsold">￥{{good.oriPrice}}</del></p>
                                                </div>
                                                <div class="open-group" ng-style="{'background-color':component.openBgcolor}">
                                                    <span>去开团</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部活动</div>
                            </div>
                            <!-- 秒杀组件 -->
                            <div class="seckill-component {{component.goodStyle==5?'skill5':''}}" ng-if="component.type=='seckill'" ng-style="{'border-color':component.goodStyle==5?component.activeBgcolor:'none'}">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="skill-title-wrap flex-wrap" ng-if="component.goodStyle==5">
						          <div class="title-icon">
						            <img src="/public/wxapp/customtpl/images/miaosha.png" alt="" />
						          </div>
						          <div class="skill-tab flex-con">
						              <div class="tabItem active" ng-style="{'background-color':component.activeBgcolor}">
						                <div class="title">12:30</div>
						                <div class="desc">正在开抢</div>
						              </div>
						              <div class="tabItem">
						                <div class="title">18:30</div>
						                <div class="desc">即将开始</div>
						              </div>
						          </div>
						          <div class="more-btn">
						            <span>更多</span>
						            <img src="/public/wxapp/customtpl/images/icon_right_gray.png" alt="" />
						          </div>
						        </div>
                                <div class="seckill-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="seckill-item border-b" ng-repeat="good in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.goodsNum track by $index">
                                        <div class="seckill-item-con">
                                            <div class="seckill-img">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                            </div>
                                            <div class="seckill-intro">
                                                <div class="seckill-title" stylesheet style="{{component.titleStyle}}">商品标题1</div>
                                                <div class="seckill-brief" ng-if="component.goodStyle==2">商品简介</div>
                                                <div class="percent-wrap">
                                                    <div class="sold-percent flex-wrap">
                                                        <div class="flex-con">
                                                            <div class="percent-show">
                                                                <span class="percent-progress" style="width: 60%"></span>
                                                                <span class="percent-number">60%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="seckill-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">10</span><del class="ori-price" ng-if="component.isShowsold">￥100</del></p>
                                                </div>
                                                <div class="open-seckill" ng-style="{'background-color':component.openBgcolor}" ng-if="component.goodStyle!=5">
                                                    <span>马上抢</span>
                                                </div>
                                                <div class="ori-price" ng-if="component.goodStyle==5">
                                                    <span>88.88元</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="seckill-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.goodsData.length<=0">添加秒杀商品~</div>
                                    <div class="seckill-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="component.goodsData.length>0">
                                        <div class="seckill-item-con">
                                            <div class="seckill-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="seckill-intro">
                                                <div class="seckill-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="seckill-brief" ng-if="component.goodStyle==2">商品简介</div>
                                                <div class="percent-wrap">
                                                    <div class="sold-percent flex-wrap">
                                                        <div class="flex-con">
                                                            <div class="percent-show">
                                                                <span class="percent-progress" style="width: 60%"></span>
                                                                <span class="percent-number">60%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="seckill-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span><del class="ori-price" ng-if="component.isShowsold">￥{{good.oriPrice}}</del></p>
                                                </div>
                                                <div class="open-seckill" ng-style="{'background-color':component.openBgcolor}">
                                                    <span>马上抢</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部活动</div>
                            </div>
                            <!-- 砍价组件 -->
                            <div class="bargain-component" ng-if="component.type=='bargain'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="bargain-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="bargain-item border-b" ng-repeat="good in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.goodsNum track by $index">
                                        <div class="bargain-item-con">
                                            <div class="bargain-img">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                            </div>
                                            <div class="bargain-intro">
                                                <div class="bargain-title" stylesheet style="{{component.titleStyle}}">商品标题</div>
                                                <div class="bargain-brief" ng-if="component.goodStyle==2">商品简介</div>
                                                <div class="bargain-sold" ng-if="component.goodStyle==2">66人已砍</div>
                                                <div class="bargain-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">10</span> <span class="sold-num" ng-if="component.isShowsold">原价：￥100</span></p>
                                                </div>
                                                <div class="open-bargain" ng-style="{'background-color':component.openBgcolor}">
                                                    <span>去砍价</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bargain-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.goodsData.length<=0">添加砍价商品~</div>
                                    <div class="bargain-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="component.goodsData.length>0">
                                        <div class="bargain-item-con">
                                            <div class="bargain-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="bargain-intro">
                                                <div class="bargain-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="bargain-brief" ng-if="component.goodStyle==2">{{good.brief}}</div>
                                                <div class="bargain-sold" ng-if="component.goodStyle==2">{{good.sold}}人已砍</div>
                                                <div class="bargain-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> <span class="sold-num" ng-if="component.isShowsold">原价：￥{{good.oriPrice}}</span></p>
                                                </div>
                                                <div class="open-bargain" ng-style="{'background-color':component.openBgcolor}">
                                                    <span>去砍价</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部活动</div>
                            </div>
                            <!-- 积分商品组件 -->
                            <div class="points-component" ng-if="component.type=='points'">
                                <div class="drag-handle"></div>
                                <div class="del-btn" ng-init="curindex=$index" ng-click="delComponent(curindex)">×</div>
                                <div class="points-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==1">
                                    <div class="points-item border-b" ng-repeat="good in [1,2,3,4,5,6,7,8,9,10] | limitTo : component.goodsNum track by $index">
                                        <div class="points-item-con">
                                            <div class="points-img">
                                                <img ng-src="/public/wxapp/customtpl/images/goodsView4.jpg" alt="商品图片">
                                            </div>
                                            <div class="points-intro">
                                                <div class="points-title" stylesheet style="{{component.titleStyle}}">商品标题</div>
                                                <div class="points-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">10</span>  + <span class="points">10</span> <span class="start-exchange" ng-if="component.goodStyle==2">兑换</span></p>

                                                </div>
                                                <div class="points-extra">
                                                    <span class="ori-price">门市价:￥999</span>
                                                    <span class="sold">已兑换999份</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="points-list style{{component.goodStyle}}" stylesheet style="{{component.style}}" ng-if="component.getType==2">
                                    <div class="no-data-tip" ng-if="component.goodsData.length<=0">添加积分商品~</div>
                                    <div class="points-item border-b" ng-repeat="good in component.goodsData track by $index" ng-if="component.goodsData.length>0">
                                        <div class="points-item-con">
                                            <div class="points-img">
                                                <img ng-src="{{good.cover}}" alt="商品图片">
                                            </div>
                                            <div class="points-intro">
                                                <div class="points-title" stylesheet style="{{component.titleStyle}}">{{good.title}}</div>
                                                <div class="points-price {{component.priceBold?'pricebold':''}}">
                                                    <p class="now-price" ng-style="{'color':component.priceStyle.color}">￥<span  stylesheet style="{{component.priceStyle}}">{{good.price}}</span> + <span class="points">{{good.points}}</span> <span class="start-exchange" ng-if="component.goodStyle==2">兑换</span></p>
                                                </div>
                                                <div class="points-extra">
                                                    <span class="ori-price">门市价:￥{{good.oriPrice}}</span>
                                                    <span class="sold">已兑换{{good.sold}}份</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="see-more {{component.goodStyle==1?'morestyle1':''}}" ng-if="component.goodStyle!=4&&component.isShowmore">查看全部积分商品</div>
                            </div>
                        </div>
                    </div>


                </div>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==3) {?>
                <div class="notice-box classify-preiview-page" ng-if="showpostlist" >
                    <div class="classify-name">
                        <span style="width:125px">热门</span>
                        <span style="width:125px">精选</span>
                        <span style="width:125px">最新</span>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                <div class="notice-box classify-preiview-page" ng-if="showpostlist" data-left-preview data-id="10086" setclick>
                    <div class="classify-name">
                        <span ng-repeat="type in postType">{{type.name}}</span>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                <div class="notice-box classify-preiview-page" ng-if="showpostlist" data-left-preview data-id="10087" setclick>
                    <div class="classify-name">
                        <span ng-repeat="type in positionType">{{type.name}}</span>
                    </div>
                </div>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==33) {?>
                <div class="notice-box classify-preiview-page" ng-if="showpostlist" data-left-preview data-id="10010" setclick>
                    <div class="classify-name">
                        <span ng-repeat="type in carCfg" style="width: 196px;">{{type.name}}</span>
                    </div>
                </div>
                <?php }?>
                <div class="foot-bar"><span></span></div>
            </div>
        </div>
        <div class="right-opera">
            <div class="tab-title-wrap">
                <div class="tab-title-item active" settypeclick data-type="set1">组件配置</div>
                <div class="tab-title-item" settypeclick data-type="set2">组件样式</div>
                <div class="tab-title-item" settypeclick data-type="set3">模板<i class="icon iconfont icon-hot"></i></div>
            </div>
            <div class="tab-con-wrap">
                <div class="tab-con-item" data-type="set1" style="display: block;">
                    <div data-right-edit data-id="-1" style="display: block;">
                        <div class="input-group-box">
                            <label class="label-name">页面标题：</label>
                            <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="15" ng-model="headerTitle">
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==3) {?>
                        <div class="input-group-box">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 170px">首页是否显示帖子列表:</label>
                                    <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='showpostlist' type='checkbox' ng-model="showpostlist">
                                        <label class='tgl-btn' for='showpostlist' style="width: 56px;"></label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                        <div class="input-group-box">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 170px">首页是否开启发布按钮:</label>
                                    <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='showpostbtn' type='checkbox' ng-model="showpostbtn">
                                        <label class='tgl-btn' for='showpostbtn' style="width: 56px;"></label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                        <div class="input-group-box">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 170px">首页是否显示职位列表:</label>
                                    <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='showpostlist' type='checkbox' ng-model="showpostlist">
                                        <label class='tgl-btn' for='showpostlist' style="width: 56px;"></label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 150px;margin-bottom: 10px;">单份推荐奖最小金额：</label>
                            <input type="text" class="cus-input" ng-model="jobInfo.recommendMin" style="width: 80%">
                            <span style="font-weight: 700;margin-left: 10px">元</span>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 230px;margin-bottom: 10px;">单份入职奖最小金额（推荐人）：</label>
                            <input type="text" class="cus-input" ng-model="jobInfo.entryMin" style="width: 80%">
                            <span style="font-weight: 700;margin-left: 10px">元</span>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 230px;margin-bottom: 10px;">单份入职奖最小金额（被推荐人）：</label>
                            <input type="text" class="cus-input" ng-model="jobInfo.recommendedMin" style="width: 80%">
                            <span style="font-weight: 700;margin-left: 10px">元</span>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 130px;margin-bottom: 10px;">自动确认入职时间：</label>
                            <input type="text" class="cus-input" ng-model="jobInfo.confirmTime" style="width: 80%">
                            <span style="font-weight: 700;margin-left: 10px">天</span>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 190px;margin-bottom: 10px;">非会员每天可邀请面试次数：</label>
                            <input type="text" class="cus-input" ng-model="jobInfo.inviteNum" style="width: 80%">
                            <span style="font-weight: 700;margin-left: 10px">次</span>
                        </div>
                        <div class="edit-txt">
                            <div class="input-groups">
                                <label for="" style="margin-bottom: 10px;">奖金说明：</label>
                                <textarea name="award-intro" class="cus-input" id="award-intro" rows="10" ng-model="jobInfo.awardIntro"></textarea>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==33) {?>
                        <div class="input-group-box">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 170px">首页是否显示列表:</label>
                                    <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='showpostlist' type='checkbox' ng-model="showpostlist">
                                        <label class='tgl-btn' for='showpostlist' style="width: 56px;"></label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==7) {?>
                        <div class="input-group-box">
                            <label class="label-name">付费取消提示：</label>
                            <textarea type="text" class="cus-input" placeholder="请输入提示内容" maxlength="120" ng-model="hotelInfo.cancelPrompt" style="height: 100px"></textarea>
                        </div>
                        <div class="input-group-box">
                            <label class="label-name">订单温馨提示：</label>
                            <textarea type="text" class="cus-input" placeholder="请输入提示内容" maxlength="120" ng-model="hotelInfo.tradeRemind" style="height: 100px"></textarea>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==27) {?>
                        <div class="input-group-box" style="margin-bottom: 15px;">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 150px">图文课程封面图样式:</label>
                                    <div class="right-info">
                                        <div class="controls" style="display: block;padding: 6px 0;">
                                            <input id='article-cover-type-{{$index}}-1' type="radio" name='article-cover-type' value="1" ng-model="articleCoverType"/>
                                            <label for="article-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                            <input id='article-cover-type-{{$index}}-2' type="radio" name='article-cover-type' value="2" ng-model="articleCoverType"/>
                                            <label for="article-cover-type-{{$index}}-2">640 * 360</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 15px;">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 150px">音频课程封面图样式:</label>
                                    <div class="right-info">
                                        <div class="controls" style="display: block;padding: 6px 0;">
                                            <input id='audio-cover-type-{{$index}}-1' type="radio" name='audio-cover-type' value="1" ng-model="audioCoverType"/>
                                            <label for="audio-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                            <input id='audio-cover-type-{{$index}}-2' type="radio" name='audio-cover-type' value="2" ng-model="audioCoverType"/>
                                            <label for="audio-cover-type-{{$index}}-2">640 * 360</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="input-group-box" style="margin-bottom: 15px;">
                            <div class="right-info">
                                <div style="height: 35px">
                                    <label class="label-name" style="width: 150px">视频课程封面图样式:</label>
                                    <div class="right-info">
                                        <div class="controls" style="display: block;padding: 6px 0;">
                                            <input id='video-cover-type-{{$index}}-1' type="radio" name='video-cover-type' value="1" ng-model="videoCoverType"/>
                                            <label for="video-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                            <input id='video-cover-type-{{$index}}-2' type="radio" name='video-cover-type' value="2" ng-model="videoCoverType"/>
                                            <label for="video-cover-type-{{$index}}-2">640 * 360</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4) {?>
                        <div class="input-group-box">
                            <div class="controls" style="display: block;padding: 6px 0;">
                                <input id='meal-type-{{$index}}-1' type="radio" name='meal-type' value="1" ng-model="mealType"/>
                                <label for="meal-type-{{$index}}-1">多店</label>
                                <input id='meal-type-{{$index}}-2' type="radio" name='meal-type' value="2" ng-model="mealType"/>
                                <label for="meal-type-{{$index}}-2">单店</label>
                            </div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="">外卖页顶部图片：(建议尺寸750*250)</label>
                            <div class="headImg-manage"  style="height:100%;width: 100%">
                                <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav1()" data-dom-id="upload-nav1HeadImg" id="upload-nav1HeadImg"  ng-src="{{shopInfo.nav1HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav1HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="nav1HeadImg"  class="avatar-field bg-img" name="nav1HeadImg" ng-value="shopInfo.nav1HeadImg"/>
                            </div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="">堂食页顶部图片：(建议尺寸750*250)</label>
                            <div class="headImg-manage"   style="height:100%;width: 100%">
                                <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav2()" data-dom-id="upload-nav2HeadImg" id="upload-nav2HeadImg"  ng-src="{{shopInfo.nav2HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav2HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="nav2HeadImg"  class="avatar-field bg-img" name="nav2HeadImg" ng-value="shopInfo.nav2HeadImg"/>
                            </div>
                        </div>
                        <div style="margin-bottom: 10px;">
                            <label for="">预约页顶部图片：(建议尺寸750*250)</label>
                            <div class="headImg-manage">
                                <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav3()" data-dom-id="upload-nav3HeadImg" id="upload-nav3HeadImg"  ng-src="{{shopInfo.nav3HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav3HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="nav3HeadImg"  class="avatar-field bg-img" name="nav3HeadImg" ng-value="shopInfo.nav3HeadImg"/>
                            </div>
                        </div>
                        <div class="input-group-box">
                            <label class="label-name">现金支付预支付金额：</label>
                            <input type="text" class="cus-input" ng-model="shopInfo.paymentMoney" placeholder="请输入预付金额">
                            <span style="display: inline-block;margin-top: 6px;">（为防止恶意下单现金支付的订单需预支一部分费用）</span>
                        </div>
                        <div ng-show="mealType == 2">
                            <div class="input-group-box">
                                <label class="label-name">营业时间：</label>
                                <input type="text" class="cus-input time" ng-model="shopInfo.openStartTime" style="width: 50%" onchange="" >
                                <input type="text" class="cus-input time" ng-model="shopInfo.openEndTime" style="width: 50%" onchange="" >
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">人均消费：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.spend" placeholder="人均消费">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">最低起送金额：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.limit" placeholder="满多少元起送">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">配送费：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.postFee" placeholder="配送费">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">配送范围：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.postRange" placeholder="多少公里内配送">
                                <span style="position: relative;left: -90px;">(公里)</span>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">平均送达时间：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.avgSendTime" placeholder="平均送达时间">
                                <span style="position: relative;left: -90px;">(分钟)</span>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">餐具费：</label>
                                <input type="text" class="cus-input" ng-model="shopInfo.tablewareFee" placeholder="请输入餐具费用">
                                <span style="display: inline-block;margin-top: 6px;">(单位：每人，0表示免费)</span>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" style="display: -webkit-inline-box;">商家地址:</label>
                                <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                    <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="shopInfo.longitude">
                                    <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="shopInfo.latitude">
                                    <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                                </div>
                                <textarea rows="3" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="shopInfo.address"></textarea>
                                <div id="container" style="width: 100%;height: 300px"></div>

                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <div ng-repeat="component in showComponentData track by $index" ng-init="componentindex = $index" data-right-edit data-id="{{$index}}">
                        <!-- 幻灯配置 -->
                        <div class="slide-set" ng-if="component.type=='slide'">
                            <div class="manage-title">幻灯图片管理</div>
                            <div class="slideimg-manage" ui-sortable ng-model="component.slideimgs">
                                <div class="slideimg-item" ng-repeat="slide in component.slideimgs track by $index" ng-init="slideindex = $index">
                                    <div class="del-btn" ng-click="delItem($event,slideindex,'slideimgs')">×</div>
                                    <!--<img ng-src="{{slide.img}}" ng-style="{'height':component.style.height*0.74}" class="slide-img" alt="幻灯图片">-->
                                    <div ng-style="{'padding-left':component.style.paddingLeft*0.74, 'padding-right':component.style.paddingRight*0.74}">
                                        <img onclick="toUpload(this)" data-type="slide" ng-style="{'height':component.style.height*0.74}" class="slide-img" alt="幻灯图片" data-ratio="0.74" data-limit="8" onload="changeSrc(this)" imageonload="doThis(component.slideimgs,$index)" data-dom-id="upload-slide{{componentindex}}s{{slideindex}}" id="upload-slide{{componentindex}}s{{slideindex}}"  ng-src="{{slide.img}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="slide{{componentindex}}s{{slideindex}}"  class="avatar-field bg-img" name="slide{{componentindex}}s{{slideindex}}" ng-value="slide.img"/>
                                    </div>
                                    <div class="input-group-box">
                                        <!--<label class="label-name">链接地址：</label>
                                        <select class="cus-input" ng-model="slide.link" ng-options="x.link as x.name for x in pageLink"></select>-->
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="slide.type"  ng-options="x.id as x.name for x in linkTypes"  ng-change="clearGoodsValue(slide,'linkName', 'link')"></select>
                                        </div>
                                        <?php } else { ?>
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="slide.type"  ng-options="x.id as x.name for x in linkTypes"  ng-change="clearGoodsValue(slide,'linkName', 'link')"></select>
                                        </div>
                                        <?php }?>
                                        <div class="input-group-box clearfix" ng-show="slide.type==1">
                                            <label for="" class="label-name">资讯详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择资讯'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="slide.link"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==2">
                                            <label for="" class="label-name">列　　表：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.path as x.name for x in linkList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==24">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in lessonType" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==3">
                                            <label for="" class="label-name">链　　接：</label>
                                            <input type="text" class="cus-input form-control" ng-value="slide.link" ng-model="slide.link" />
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==4">
                                            <label for="" class="label-name">分组详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==6">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==37">
                                            <label for="" class="label-name">专家详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in expertList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==38">
                                            <label for="" class="label-name">专家分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in expertCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==39">
                                            <label for="" class="label-name">游戏分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in gameCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==9">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==10">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==18">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in categoryList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==61">
                                            <label for="" class="label-name">菜单详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.title for x in menuList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==19">
                                            <label for="" class="label-name">服务详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==44">
                                            <label for="" class="label-name">车源详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in carList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==45">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==46">
                                            <label for="" class="label-name">付费预约：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==62">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==35">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==36">
                                            <label for="" class="label-name">职位详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in positionList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==50">
                                            <label for="" class="label-name">公司分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==48">
                                            <label for="" class="label-name">公司详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in companySelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==5 || slide.type==201">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择商品'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="slide.link"/>
                                            </div>
                                        </div>


                                        <!-- 独立商城的商品分类及商品详情 -->
                                        <!-- 一级分类 -->
                                        <div class="input-group-box clearfix" ng-show="slide.type==500">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                        </div>
                                        <!-- 二级分类 -->
                                         <div class="input-group-box clearfix" ng-show="slide.type==501">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                        </div>

                                        <!-- 独立商城商品 -->
                                        <div class="input-group-box clearfix" ng-show="slide.type==502">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择商品'" value="点击选择商品">
                                                <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="slide.link" value="">
                                            </div>
                                        </div>
                                        <!-- 独立商城的商品分类 -->


                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="slide.type==23">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==29">
                                            <label for="" class="label-name">秒杀商品：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in limitList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==30">
                                            <label for="" class="label-name">拼团商品：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in groupList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==31">
                                            <label for="" class="label-name">砍价商品：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==32">
                                            <label for="" class="label-name">资讯分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==104">
                                            <label for="" class="label-name">菜　　单：</label>
                                            <select class="cus-input form-control" ng-model="slide.link" ng-options="x.path as x.name for x in pages"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==16">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==34">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==17">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==20">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==26">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                        </div>
                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="slide.type==26">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==41">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==42">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==43">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==54">
                                            <label for="" class="label-name">门店详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in storelist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==55">
                                            <label for="" class="label-name">自定义表单：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in formlist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==56">
                                            <label for="" class="label-name">自定义模板：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in templateList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==57">
                                            <label for="" class="label-name">课程详情：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in courseList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==106">
                                            <label for="" class="label-name">小 程 序：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="slide.type==107">
                                            <label for="" class="label-name">小 游 戏：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in gameList" ></select>
                                        </div>

                                        <div class="input-group-box clearfix" ng-show="slide.type==503">
                                            <label for="" class="label-name">商品活动列表：</label>
                                            <select class="cus-input form-control" ng-model="slide.link"  ng-options="x.id as x.name for x in goodsActivityList" ></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="add-slide" ng-click="addSlide($event)">＋<span>添加幻灯</span></div>
                            </div>
                        </div>
                        <!-- 分类导航配置 -->
                        <div class="slide-set flnav-set" ng-if="component.type=='fenlei'">
                            <div class="manage-title">分类导航管理</div>
                            <div class="slideimg-manage" ui-sortable ng-model="component.flitems">
                                <div class="slideimg-item" ng-repeat="nav in component.flitems track by $index" ng-init="flindex = $index">
                                    <div class="del-btn" ng-click="delItem($event,flindex,'flitems')">×</div>
                                    <!--<img ng-src="{{nav.icon}}" class="slide-img" alt="分类图标" style="border-radius: {{component.iconRadius}}px;">-->
                                    <div>
                                        <img onclick="toUpload(this)" style="border-radius: {{component.iconRadius}}px;" class="slide-img" alt="幻灯图片" data-height="200" data-width="200"  data-limit="8" onload="changeSrc(this)" imageonload="doNavThis(component.flitems,$index)" data-dom-id="upload-nav{{componentindex}}f{{flindex}}" id="upload-nav{{componentindex}}f{{flindex}}"  ng-src="{{nav.icon}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="nav{{componentindex}}f{{flindex}}"  class="avatar-field bg-img" name="nav{{componentindex}}f{{flindex}}" ng-value="nav.icon"/>
                                    </div>
                                    <div class="input-group-box">
                                        <label class="label-name">标题名称：</label>
                                        <input type="text" class="cus-input" ng-model="nav.name" maxlength="6">
                                    </div>
                                    <div class="input-group-box" ng-if="component.styleType==3">
                                        <label class="label-name">内容简介：</label>
                                        <input type="text" class="cus-input" ng-model="nav.brief">
                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>
                                    <div class="input-group-box">
                                        <!--<label class="label-name">链接地址：</label>
                                        <select class="cus-input" ng-model="nav.link" ng-options="x.link as x.name for x in pageLink"></select>-->
                                        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(nav.link,'linkName', 'url')"></select>
                                        </div>
                                        <?php } else { ?>
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(nav.link,'linkName', 'url')"></select>
                                        </div>
                                        <?php }?>

                                        <div class="input-group-box clearfix" ng-show="nav.link.type==1">
                                            <label for="" class="label-name">资讯详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(nav.link,'linkName')" ng-value="nav.link.linkName?nav.link.linkName:'点击选择资讯'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(nav.link,'url')" ng-value="nav.link.url"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==2">
                                            <label for="" class="label-name">列　　表：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==24">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==3">
                                            <label for="" class="label-name">外　　链：</label>
                                            <input type="text" class="cus-input form-control" ng-value="nav.link.url" ng-model="nav.link.url" />
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==4">
                                            <label for="" class="label-name">分组详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==9">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==10">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==18">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==61">
                                            <label for="" class="label-name">菜单详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.title for x in menuList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==19">
                                            <label for="" class="label-name">服务详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==44">
                                            <label for="" class="label-name">车源详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in carList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==45">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==46">
                                            <label for="" class="label-name">付费预约：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==5 || nav.link.type==201">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(nav.link,'linkName')" ng-value="nav.link.linkName?nav.link.linkName:'点击选择商品'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(nav.link,'url')" ng-value="nav.link.url"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==6">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==37">
                                            <label for="" class="label-name">专家详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in expertList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==38">
                                            <label for="" class="label-name">专家分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==39">
                                            <label for="" class="label-name">游戏分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                        </div>
                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==23">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==29">
                                            <label for="" class="label-name">秒杀商品：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==30">
                                            <label for="" class="label-name">拼团商品：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==31">
                                            <label for="" class="label-name">砍价商品：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==32">
                                            <label for="" class="label-name">资讯分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==104">
                                            <label for="" class="label-name">菜　　单：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url" ng-options="x.path as x.name for x in pages"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==16">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==17">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==41">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==42">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==43">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==26">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==62">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==35">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==36">
                                            <label for="" class="label-name">职位详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==50">
                                            <label for="" class="label-name">公司分类：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==48">
                                            <label for="" class="label-name">公司详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==54">
                                            <label for="" class="label-name">门店详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==55">
                                            <label for="" class="label-name">自定义表单：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in formlist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==56">
                                            <label for="" class="label-name">自定义模板：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in templateList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==57">
                                            <label for="" class="label-name">课程详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                        </div>
                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==26">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==106">
                                            <label for="" class="label-name">小 程 序：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==107">
                                            <label for="" class="label-name">小 游 戏：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                        </div>

                                        <!-- 独立商城的商品分类及商品详情 -->
                                        <!-- 一级分类 -->
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==500">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                        </div>
                                        <!-- 二级分类 -->
                                         <div class="input-group-box clearfix" ng-show="nav.link.type==501">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                        </div>

                                        <!-- 独立商城商品 -->
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==502">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(nav.link,'linkName')" ng-value="nav.link.linkName?nav.link.linkName:'点击选择商品'" value="点击选择商品">
                                                <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(nav.link,'url')" ng-value="nav.link.url" value="">
                                            </div>
                                        </div>
                                        <!-- 独立商城的商品分类 -->

                                        <div class="input-group-box clearfix" ng-show="nav.link.type==503">
                                            <label for="" class="label-name">商品活动列表：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in goodsActivityList" ></select>
                                        </div>

                                    </div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                                    <div class="input-group-box">
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.type" ng-options="x.type as x.name for x in fenleiNavsType"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==1">
                                            <label for="" class="label-name">价　格：</label>
                                            <input type="text" maxlength="10" class="cus-input" ng-model="nav.price">
                                        </div>
                                        <div style="height: 35px" ng-if="nav.link.type==1">
                                            <label class="label-name" style="width: 170px">小程序端是否显示:</label>
                                            <div class="right-info">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='must_isshow{{$index}}' type='checkbox' ng-model="nav.isshow">
                                                    <label class='tgl-btn' for='must_isshow{{$index}}' style="width: 56px;"></label>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="height: 35px" ng-if="nav.link.type==1">
                                            <label class="label-name" style="width: 170px">发帖时电话是否必填:</label>
                                            <div class="right-info">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='must_mobile{{$index}}' type='checkbox' ng-model="nav.mobileShow">
                                                    <label class='tgl-btn' for='must_mobile{{$index}}' style="width: 56px;"></label>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="height: 35px" ng-if="nav.link.type==1">
                                            <label class="label-name" style="width: 170px">发帖时地址是否必填:</label>
                                            <div class="right-info">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='must_address{{$index}}' type='checkbox' ng-model="nav.addressShow">
                                                    <label class='tgl-btn' for='must_address{{$index}}' style="width: 56px;"></label>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="height: 35px" ng-if="nav.link.type==1">
                                            <label class="label-name" style="width: 170px">该分类是否允许评论:</label>
                                            <div class="right-info">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='must_comment{{$index}}' type='checkbox' ng-model="nav.allowComment">
                                                    <label class='tgl-btn' for='must_comment{{$index}}' style="width: 56px;"></label>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="height: 35px" ng-if="nav.link.type==1">
                                            <label class="label-name" style="width: 170px">该分类评论是否需要审核:</label>
                                            <div class="right-info">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='verify_comment{{$index}}' type='checkbox' ng-model="nav.verifyComment">
                                                    <label class='tgl-btn' for='verify_comment{{$index}}' style="width: 56px;"></label>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==3">
                                            <label for="" class="label-name">列　表：</label>
                                            <select class="cus-input" ng-model="nav.link.url" ng-options="x.path as x.name for x in linkList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==4">
                                            <!--<label for="" class="label-name">单　页：</label>
                                            <select class="cus-input" ng-model="nav.link.url"  ng-options="x.id as x.title for x in articles" ></select>-->
                                            <label for="" class="label-name">资讯详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(nav.link,'linkName')" ng-value="nav.link.linkName?nav.link.linkName:'点击选择资讯'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(nav.link,'url')" ng-value="nav.link.url"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==32">
                                            <label for="" class="label-name">资讯分类：</label>
                                            <select class="cus-input" ng-model="nav.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==104">
                                            <label for="" class="label-name">菜　　单：</label>
                                            <select class="cus-input" ng-model="nav.link.url" ng-options="x.path as x.name for x in pages"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==106">
                                            <label for="" class="label-name">小 程 序：</label>
                                            <select class="cus-input" ng-model="nav.link.url" ng-options="x.appid as x.name for x in jumpList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==34">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input" ng-model="nav.link.url" ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==55">
                                            <label for="" class="label-name">自定义表单：</label>
                                            <select class="cus-input" ng-model="nav.link.url" ng-options="x.id as x.name for x in formlist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==20">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-if="nav.link.type==42">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input" ng-model="nav.link.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="nav.link.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="nav.link.type==5 || nav.link.type==201">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(nav.link,'linkName')" ng-value="nav.link.linkName?nav.link.linkName:'点击选择商品'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(nav.link,'url')" ng-value="nav.link.url"/>
                                            </div>
                                        </div>
                                    </div>
                                    <?php }?>
                                </div>
                                <div class="add-slide" ng-click="addFenlei($event)">＋<span>添加分类</span></div>
                            </div>
                        </div>
                        <!-- 视频配置 -->
                        <div class="slide-set" ng-if="component.type=='video'">
                            <div>视频封面图：</div>
                            <div class="img-box" style="text-align: center; margin-bottom: 10px" >
                                <img onclick="toUpload(this)" data-type="video" data-width="750" ng-style="{'width':'100%', 'height': component.style.height*0.4}" data-ratio="0.4" class="image-img" alt="图片" data-limit="8" onload="changeSrc(this)" imageonload="doVideoThis(component,$index)" data-dom-id="upload-video{{componentindex}}" id="upload-video{{componentindex}}"  ng-src="{{component.videocover?component.videocover:'/public/wxapp/customtpl/images/banner_750_400.png'}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="video{{componentindex}}"  class="avatar-field bg-img" name="video{{componentindex}}" ng-value="component.videocover"/>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">视频链接：</label>
                                <input type="text" class="cus-input" ng-model="component.videolink">
                            </div>
                        </div>
                        <!-- 搜索配置 -->
                        <div class="slide-set" ng-if="component.type=='search'">
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">替换文本：</label>
                                <input type="text" class="cus-input" ng-model="component.placeHolder">
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">搜索类型：</label>
                                <select class="cus-input" ng-model="component.searchType">
                                    <option value="1">商品</option>
                                    <option value="2">店铺、帖子</option>
                                </select>
                            </div>
                            <div class="input-group-box" >
                                <label class="label-name">是否显示天气：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="weather-{{$index}}" type="checkbox" ng-model="component.showWeather" checked="">
                                            <label class="tgl-btn" for="weather-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <!-- 地址配置 -->
                        <div class="address-set" ng-if="component.type=='address'">
                            <div class="input-group-box" ng-if="component.addressStyle==3">
                                <label class="label-name" style="vertical-align: middle;">公司Logo：</label>
                                <div class="right-info">
                                    <!--<img ng-src="{{component.companyLogo}}" class="companylogo" alt="公司logo">-->
                                    <div>
                                        <img onclick="toUpload(this)" class="companylogo" alt="公司logo" data-height="160" data-width="160"  data-limit="8" onload="changeSrc(this)" imageonload="doLogoThis(component)" data-dom-id="upload-companyLogo{{componentindex}}" id="upload-companyLogo{{componentindex}}"  ng-src="{{component.companyLogo}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="companyLogo{{componentindex}}"  class="avatar-field bg-img" name="navcompanyLogo{{componentindex}}" ng-value="component.companyLogo"/>
                                    </div>
                                    <div class="recom-size">(建议尺寸160*160)</div>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">公司名称：</label>
                                <input type="text" class="cus-input" ng-model="component.companyName">
                            </div>
                            <div class="input-group-box" ng-if="component.addressStyle==2">
                                <label class="label-name">营业时间：</label>
                                <input type="text" class="cus-input" placeholder="例：09:00-18:00" ng-model="component.businessTime">
                            </div>
                            <div class="input-group-box" ng-if="component.addressStyle!=1">
                                <label class="label-name">联系电话：</label>
                                <input type="tel" class="cus-input" ng-model="component.mobile">
                            </div>
                            <div class="input-group-box" ng-if="component.addressStyle==3">
                                <label class="label-name">详情链接：</label>
                                <select class="cus-input" ng-model="component.companyLink" ng-options="x.id as x.title for x in information"></select>
                            </div>

                            <div class="input-group-box" ng-if="component.addressStyle==3">
                                <label class="label-name">公司简介：</label>
                                <textarea class="cus-input" rows="3" ng-model="component.companyBrief"></textarea>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" style="display: inline-block">详细地址：</label>
                                <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                    <input type="hidden" id="lng{{componentindex}}" name="lng" placeholder="请输入地址经度" ng-model="component.address.longitude">
                                    <input type="hidden" id="lat{{componentindex}}" name="lat" placeholder="请输入地址纬度" ng-model="component.address.latitude">
                                    <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                                </div>
                                <textarea class="cus-input" rows="3" id="details-address{{componentindex}}" ng-model="component.address.addr"></textarea>
                                <div id="container{{componentindex}}" style="width: 100%;height: 300px"></div>
                            </div>

                        </div>
                        <!-- 通知公告配置 -->
                        <div class="slide-set" ng-if="component.type=='notice'">
                            <div class="manage-title">通知公告管理<span class="manage-tips">(手机端公告自动滚动，PC端不做展示)</span></div>
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">公告标题：</label>
                                <input type="text" class="cus-input" ng-model="component.titleTxt" maxlength="4">
                            </div>
                            <div class="slideimg-manage" ui-sortable ng-model="component.noticeTxt">
                                <div class="slideimg-item"  ng-repeat="notice in component.noticeTxt track by $index" ng-init="noticeIndex = $index">
                                    <div class="del-btn" ng-click="delItem($event,noticeIndex,'noticeTxt')">×</div>
                                    <div class="input-group-box">
                                        <label class="label-name">标题文字：</label>
                                        <input type="text" class="cus-input" ng-model="notice.text">
                                    </div>
                                    <div class="input-group-box">
                                        <label class="label-name">链接地址：</label>
                                        <select class="cus-input" ng-model="notice.link" ng-options="x.id as x.title for x in information"></select>
                                    </div>
                                </div>
                                <div class="add-slide" ng-click="addNotice($event)">＋<span>添加通知</span></div>
                            </div>
                        </div>
                        <!-- 标题配置 -->
                        <div class="slide-set" ng-if="component.type=='title'">
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">标题文本：</label>
                                <input type="text" class="cus-input" ng-model="component.titleTxt">
                            </div>
                            <!--<div class="input-group-box">
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name" style="width: 80px;">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==1">
                                    <label for="" class="label-name" style="width: 80px;">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==2">
                                    <label for="" class="label-name" style="width: 80px;">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==3">
                                    <label for="" class="label-name" style="width: 80px;">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==4">
                                    <label for="" class="label-name" style="width: 80px;">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==9">
                                    <label for="" class="label-name" style="width: 80px;">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==10">
                                    <label for="" class="label-name" style="width: 80px;">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==18">
                                    <label for="" class="label-name" style="width: 80px;">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==19">
                                    <label for="" class="label-name" style="width: 80px;">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==44">
                                    <label for="" class="label-name" style="width:80px;">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==45">
                                    <label for="" class="label-name" style="width:80px;">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==5 || component.link.type==">
                                    <label for="" class="label-name" style="width: 80px;">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==6">
                                    <label for="" class="label-name" style="width: 80px;">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==37">
                                    <label for="" class="label-name" style="width: 80px;">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==38">
                                    <label for="" class="label-name" style="width: 80px;">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==39">
                                    <label for="" class="label-name" style="width: 80px;">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==23">
                                    <label for="" class="label-name" style="width: 80px;">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==29">
                                    <label for="" class="label-name" style="width: 80px;">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==30">
                                    <label for="" class="label-name" style="width: 80px;">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==31">
                                    <label for="" class="label-name" style="width: 80px;">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==32">
                                    <label for="" class="label-name" style="width: 80px;">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==104">
                                    <label for="" class="label-name" style="width: 80px;">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==16">
                                    <label for="" class="label-name" style="width: 80px;">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==34">
                                    <label for="" class="label-name" style="width: 80px;">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==17">
                                    <label for="" class="label-name" style="width: 80px;">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==20">
                                    <label for="" class="label-name" style="width: 80px;">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==106">
                                    <label for="" class="label-name" style="width: 80px;">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.appid as x.name for x in jumpList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==107">
                                    <label for="" class="label-name" style="width: 80px;">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameList"></select>
                                </div>
                            </div>-->
                        </div>
                        <!-- 图片配置 -->
                        <div class="image-set" ng-if="component.type=='image'">
                            <div class="img-box" style="text-align: center">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="image" ng-style="{'height':component.imageStyle.height*0.72, 'width':component.imageStyle.width*0.72}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doImageThis(component,$index)" data-dom-id="upload-image{{componentindex}}" id="upload-image{{componentindex}}"  ng-src="{{component.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="image{{componentindex}}"  class="avatar-field bg-img" name="image{{componentindex}}" ng-value="slide.img"/>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">链接类型：</label>
                                <select class="cus-input" ng-model="component.link.type" ng-options="x.link as x.name for x in pageLink"></select>
                            </div>-->
                            <div class="input-group-box">
                                <!--<label class="label-name">链接地址：</label>
                                <select class="cus-input" ng-model="component.link.url" ng-options="x.link as x.name for x in pageLink"></select>-->
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==1">
                                    <label for="" class="label-name">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==2">
                                    <label for="" class="label-name">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==24">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==3">
                                    <label for="" class="label-name">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==4">
                                    <label for="" class="label-name">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==9">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==10">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==18">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==19">
                                    <label for="" class="label-name">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==44">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==45">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==46">
                                    <label for="" class="label-name">付费预约：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==5 || component.link.type==201">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==6">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==37">
                                    <label for="" class="label-name">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==38">
                                    <label for="" class="label-name">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==39">
                                    <label for="" class="label-name">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==23">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==29">
                                    <label for="" class="label-name">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==30">
                                    <label for="" class="label-name">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==31">
                                    <label for="" class="label-name">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==32">
                                    <label for="" class="label-name">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==104">
                                    <label for="" class="label-name">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==16">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==34">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==17">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==20">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==41">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==42">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==43">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==26">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==62">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==35">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==36">
                                    <label for="" class="label-name">职位详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==50">
                                    <label for="" class="label-name">公司分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==48">
                                    <label for="" class="label-name">公司详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==26">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==54">
                                    <label for="" class="label-name">门店详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==55">
                                    <label for="" class="label-name">自定义表单：</label>
                                    <select class="cus-input form-control" ng-model="component.link.articleTitle"  ng-options="x.id as x.name for x in formlist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==56">
                                    <label for="" class="label-name">自定义表模板：</label>
                                    <select class="cus-input form-control" ng-model="component.link.articleTitle"  ng-options="x.id as x.name for x in templateList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==57">
                                    <label for="" class="label-name">课程详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==106">
                                    <label for="" class="label-name">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.appid as x.name for x in jumpList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==107">
                                    <label for="" class="label-name">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameList"></select>
                                </div>

                                <!-- 独立商城的商品分类及商品详情 -->
                                <!-- 一级分类 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==500">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                </div>
                                <!-- 二级分类 -->
                                 <div class="input-group-box clearfix" ng-show="component.link.type==501">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                </div>

                                <!-- 独立商城商品 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==502">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择商品'" value="点击选择商品">
                                        <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url" >
                                    </div>
                                </div>
                                <!-- 独立商城的商品分类 -->
                            </div>
                        </div>
                        <!-- 橱窗配置 -->
                        <div class="image-set" ng-if="component.type=='window'">
                            <div class="img-box" style="text-align: center" ng-if="component.windowStyle!=3">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="window" ng-style="{'height':(component.style.height-component.style.paddingTop-component.style.paddingBottom-component.imageStyle.padding*2)*0.72*2, 'width':(187-component.style.paddingRight-component.style.paddingLeft-component.imageStyle.padding*2)*0.72*2}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doWindowThis(component,$index,1)" data-dom-id="upload-window{{componentindex}}w1" id="upload-window{{componentindex}}w1"  ng-src="{{component.link1.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="window{{componentindex}}w1"  class="avatar-field bg-img" name="window{{componentindex}}w1" ng-value="slide.img"/>
                            </div>
                            <div class="img-box" style="text-align: center" ng-if="component.windowStyle==3">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="window" ng-style="{'height':(component.style.height-component.style.paddingTop-component.style.paddingBottom-component.imageStyle.padding*2)*0.72, 'width':(187-component.style.paddingRight-component.style.paddingLeft-component.imageStyle.padding*2)*0.72*2}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doWindowThis(component,$index,1)" data-dom-id="upload-window{{componentindex}}w1" id="upload-window{{componentindex}}w1"  ng-src="{{component.link1.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="window{{componentindex}}w1"  class="avatar-field bg-img" name="window{{componentindex}}w1" ng-value="slide.img"/>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">链接类型：</label>
                                <select class="cus-input" ng-model="component.link.type" ng-options="x.link as x.name for x in pageLink"></select>
                            </div>-->
                            <div class="input-group-box">
                                <!--<label class="label-name">链接地址：</label>
                                <select class="cus-input" ng-model="component.link.url" ng-options="x.link as x.name for x in pageLink"></select>-->
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link1,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==1">
                                    <label for="" class="label-name">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link1,'linkName')" ng-value="component.link1.linkName?component.link1.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link1,'url')" ng-value="component.link1.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==2">
                                    <label for="" class="label-name">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==24">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==3">
                                    <label for="" class="label-name">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==4">
                                    <label for="" class="label-name">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==9">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==10">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==18">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==19">
                                    <label for="" class="label-name">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==44">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==45">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==46">
                                    <label for="" class="label-name">付费预约：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==5 || component.link1.type==201">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link1,'linkName')" ng-value="component.link1.linkName?component.link1.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link1,'url')" ng-value="component.link1.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==6">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==37">
                                    <label for="" class="label-name">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==38">
                                    <label for="" class="label-name">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==39">
                                    <label for="" class="label-name">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==62">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==35">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==36">
                                    <label for="" class="label-name">职位详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==50">
                                    <label for="" class="label-name">公司分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==48">
                                    <label for="" class="label-name">公司详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link1.type==23">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==29">
                                    <label for="" class="label-name">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==30">
                                    <label for="" class="label-name">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==31">
                                    <label for="" class="label-name">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==32">
                                    <label for="" class="label-name">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==104">
                                    <label for="" class="label-name">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==16">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==34">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==17">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==20">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==41">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==42">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==43">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==26">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link1.type==26">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==54">
                                    <label for="" class="label-name">门店详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==55">
                                    <label for="" class="label-name">自定义表单：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.articleTitle"  ng-options="x.id as x.name for x in formlist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==56">
                                    <label for="" class="label-name">自定义模板：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.articleTitle"  ng-options="x.id as x.name for x in templateList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==57">
                                    <label for="" class="label-name">课程详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==106">
                                    <label for="" class="label-name">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link1.type==107">
                                    <label for="" class="label-name">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                </div>


                                <!-- 独立商城的商品分类及商品详情 -->
                                <!-- 一级分类 -->
                                <div class="input-group-box clearfix" ng-show="component.link1.type==500">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                </div>
                                <!-- 二级分类 -->
                                 <div class="input-group-box clearfix" ng-show="component.link1.type==501">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link1.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                </div>

                                <!-- 独立商城商品 -->
                                <div class="input-group-box clearfix" ng-show="component.link1.type==502">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(component.link1,'linkName')" ng-value="component.link1.linkName?component.link1.linkName:'点击选择商品'" value="点击选择商品">
                                        <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(component.link1,'url')" ng-value="component.link1.url" value="">
                                    </div>
                                </div>
                                <!-- 独立商城的商品分类 -->



                            </div>
                            <div class="img-box" style="text-align: center" ng-if="component.windowStyle!=2">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="window" ng-style="{'height':(component.style.height-component.style.paddingTop-component.style.paddingBottom-component.imageStyle.padding*2)*0.72*2, 'width':(187-component.style.paddingRight-component.style.paddingLeft-component.imageStyle.padding*2)*0.72*2}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doWindowThis(component,$index,2)" data-dom-id="upload-window{{componentindex}}w2" id="upload-window{{componentindex}}w2"  ng-src="{{component.link2.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="window{{componentindex}}w2"  class="avatar-field bg-img" name="window{{componentindex}}w2" ng-value="slide.img"/>
                            </div>
                            <div class="img-box" style="text-align: center" ng-if="component.windowStyle==2">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="window" ng-style="{'height':(component.style.height-component.style.paddingTop-component.style.paddingBottom-component.imageStyle.padding*2)*0.72, 'width':(187-component.style.paddingRight-component.style.paddingLeft-component.imageStyle.padding*2)*0.72*2}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doWindowThis(component,$index,2)" data-dom-id="upload-window{{componentindex}}w2" id="upload-window{{componentindex}}w2"  ng-src="{{component.link2.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="window{{componentindex}}w2"  class="avatar-field bg-img" name="window{{componentindex}}w2" ng-value="slide.img"/>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">链接类型：</label>
                                <select class="cus-input" ng-model="component.link.type" ng-options="x.link as x.name for x in pageLink"></select>
                            </div>-->
                            <div class="input-group-box">
                                <!--<label class="label-name">链接地址：</label>
                                <select class="cus-input" ng-model="component.link.url" ng-options="x.link as x.name for x in pageLink"></select>-->
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link2,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==1">
                                    <label for="" class="label-name">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link2,'linkName')" ng-value="component.link2.linkName?component.link2.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link2,'url')" ng-value="component.link2.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==2">
                                    <label for="" class="label-name">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==24">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==3">
                                    <label for="" class="label-name">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==4">
                                    <label for="" class="label-name">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==9">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==10">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==18">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==19">
                                    <label for="" class="label-name">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==44">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==45">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==46">
                                    <label for="" class="label-name">付费预约：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==5 || component.link2.type==201">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link2,'linkName')" ng-value="component.link2.linkName?component.link2.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link2,'url')" ng-value="component.link2.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==6">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==37">
                                    <label for="" class="label-name">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==38">
                                    <label for="" class="label-name">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==39">
                                    <label for="" class="label-name">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link2.type==23">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==29">
                                    <label for="" class="label-name">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==30">
                                    <label for="" class="label-name">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==31">
                                    <label for="" class="label-name">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==32">
                                    <label for="" class="label-name">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==104">
                                    <label for="" class="label-name">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==16">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==34">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==17">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==20">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==41">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==42">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==43">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==26">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==62">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==35">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==36">
                                    <label for="" class="label-name">职位详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==50">
                                    <label for="" class="label-name">公司分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==48">
                                    <label for="" class="label-name">公司详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link2.type==26">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==54">
                                    <label for="" class="label-name">门店详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==55">
                                    <label for="" class="label-name">自定义表单：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.articleTitle"  ng-options="x.id as x.name for x in formlist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==56">
                                    <label for="" class="label-name">自定义模板：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.articleTitle"  ng-options="x.id as x.name for x in templateList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==57">
                                    <label for="" class="label-name">课程详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==106">
                                    <label for="" class="label-name">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link2.type==107">
                                    <label for="" class="label-name">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                </div>



                                <!-- 独立商城的商品分类及商品详情 -->
                                <!-- 一级分类 -->
                                <div class="input-group-box clearfix" ng-show="component.link2.type==500">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                </div>
                                <!-- 二级分类 -->
                                 <div class="input-group-box clearfix" ng-show="component.link2.type==501">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link2.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                </div>

                                <!-- 独立商城商品 -->
                                <div class="input-group-box clearfix" ng-show="component.link2.type==502">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(component.link2,'linkName')" ng-value="component.link2.linkName?component.link2.linkName:'点击选择商品'" value="点击选择商品">
                                        <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(component.link2,'url')" ng-value="component.link2.url" value="">
                                    </div>
                                </div>
                                <!-- 独立商城的商品分类 -->

                            </div>
                            <div class="img-box" style="text-align: center" ng-if="component.windowStyle!=1">
                                <!--<img ng-src="{{component.imageUrl}}" alt="图片" style="height:{{component.imageStyle.height/component.imageStyle.width*288}}px;">-->
                                <img onclick="toUpload(this)" data-type="window" ng-style="{'height':(component.style.height-component.style.paddingTop-component.style.paddingBottom-component.imageStyle.padding*2)*0.72, 'width':(187-component.style.paddingRight-component.style.paddingLeft-component.imageStyle.padding*2)*0.72*2}" class="image-img" alt="图片" data-ratio="0.72" data-limit="8" onload="changeSrc(this)" imageonload="doWindowThis(component,$index,3)" data-dom-id="upload-window{{componentindex}}w3" id="upload-window{{componentindex}}w3"  ng-src="{{component.link3.imageUrl}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="window{{componentindex}}w3"  class="avatar-field bg-img" name="window{{componentindex}}w3" ng-value="slide.img"/>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">链接类型：</label>
                                <select class="cus-input" ng-model="component.link.type" ng-options="x.link as x.name for x in pageLink"></select>
                            </div>-->
                            <div class="input-group-box" ng-if="component.windowStyle!=1">
                                <!--<label class="label-name">链接地址：</label>
                                <select class="cus-input" ng-model="component.link.url" ng-options="x.link as x.name for x in pageLink"></select>-->
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link3,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==1">
                                    <label for="" class="label-name">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link3,'linkName')" ng-value="component.link3.linkName?component.link3.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link3,'url')" ng-value="component.link3.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==2">
                                    <label for="" class="label-name">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==24">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==3">
                                    <label for="" class="label-name">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link3.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==4">
                                    <label for="" class="label-name">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==9">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==10">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==18">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==19">
                                    <label for="" class="label-name">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==44">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==45">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==46">
                                    <label for="" class="label-name">付费预约：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==5 || component.link3.type==201">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link3,'linkName')" ng-value="component.link3.linkName?component.link3.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link3,'url')" ng-value="component.link3.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==6">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==37">
                                    <label for="" class="label-name">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==38">
                                    <label for="" class="label-name">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==39">
                                    <label for="" class="label-name">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link3.type==23">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==29">
                                    <label for="" class="label-name">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==30">
                                    <label for="" class="label-name">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==31">
                                    <label for="" class="label-name">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==32">
                                    <label for="" class="label-name">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==104">
                                    <label for="" class="label-name">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==16">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==34">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==17">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==20">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==41">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==42">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==43">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==26">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==62">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==35">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==36">
                                    <label for="" class="label-name">职位详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==50">
                                    <label for="" class="label-name">公司分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==48">
                                    <label for="" class="label-name">公司详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link3.type==26">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==54">
                                    <label for="" class="label-name">门店详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==55">
                                    <label for="" class="label-name">自定义表单：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.articleTitle"  ng-options="x.id as x.name for x in formlist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==56">
                                    <label for="" class="label-name">自定义模板：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in templateList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==57">
                                    <label for="" class="label-name">课程详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==106">
                                    <label for="" class="label-name">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link3.type==107">
                                    <label for="" class="label-name">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                </div>

                                <!-- 独立商城的商品分类及商品详情 -->
                                <!-- 一级分类 -->
                                <div class="input-group-box clearfix" ng-show="component.link3.type==500">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                </div>
                                <!-- 二级分类 -->
                                 <div class="input-group-box clearfix" ng-show="component.link3.type==501">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link3.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                </div>

                                <!-- 独立商城商品 -->
                                <div class="input-group-box clearfix" ng-show="component.link3.type==502">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(component.link3,'linkName')" ng-value="component.link3.linkName?component.link3.linkName:'点击选择商品'" value="点击选择商品">
                                        <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(component.link3,'url')" ng-value="component.link3.url" value="">
                                    </div>
                                </div>
                                <!-- 独立商城的商品分类 -->
                            </div>
                        </div>
                        <!-- 按钮配置 -->
                        <div class="button-set" ng-if="component.type=='button'">
                            <div class="input-group-box">
                                <label class="label-name">按钮文字：</label>
                                <input type="text" class="cus-input" ng-model="component.btntxt">
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">链接类型：</label>
                                <select class="cus-input" ng-model="component.link.type" ng-options="x.link as x.name for x in pageLink"></select>
                            </div>-->
                            <div class="input-group-box">
                                <!--<label class="label-name">链接地址：</label>
                                <select class="cus-input" ng-model="component.link.url" ng-options="x.link as x.name for x in pageLink"></select>-->
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(component.link,'linkName', 'url')"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==1">
                                    <label for="" class="label-name">资讯详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择资讯'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==2">
                                    <label for="" class="label-name">列　　表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==24">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==3">
                                    <label for="" class="label-name">外　　链：</label>
                                    <input type="text" class="cus-input form-control" ng-value="component.link.url" ng-model="component.link.url" />
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==4">
                                    <label for="" class="label-name">分组详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==9">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==10">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==18">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==61">
                                    <label for="" class="label-name">菜单详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in menuList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==19">
                                    <label for="" class="label-name">服务详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==44">
                                    <label for="" class="label-name">车源详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==45">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==46">
                                    <label for="" class="label-name">付费预约：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==5 || component.link.type==201">
                                    <label for="" class="label-name">商品详情：</label>
                                    <div class="select-goods-modal-btn" style="width: 180px">
                                        <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择商品'">
                                        <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url"/>
                                    </div>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==6">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==37">
                                    <label for="" class="label-name">专家详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertList"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==38">
                                    <label for="" class="label-name">专家分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==39">
                                    <label for="" class="label-name">游戏分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==23">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==29">
                                    <label for="" class="label-name">秒杀商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==30">
                                    <label for="" class="label-name">拼团商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==31">
                                    <label for="" class="label-name">砍价商品：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==32">
                                    <label for="" class="label-name">资讯分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==104">
                                    <label for="" class="label-name">菜　　单：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url" ng-options="x.path as x.name for x in pages"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==16">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==34">
                                    <label for="" class="label-name">店铺分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==17">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==20">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==41">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==42">
                                    <label for="" class="label-name">商品分组：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==43">
                                    <label for="" class="label-name">店铺详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==26">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==62">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==35">
                                    <label for="" class="label-name">职位分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==36">
                                    <label for="" class="label-name">职位详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==50">
                                    <label for="" class="label-name">公司分类：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==48">
                                    <label for="" class="label-name">公司详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.link.type==26">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==54">
                                    <label for="" class="label-name">门店详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==55">
                                    <label for="" class="label-name">自定义表单：</label>
                                    <select class="cus-input form-control" ng-model="component.link.articleTitle"  ng-options="x.id as x.name for x in formlist" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==56">
                                    <label for="" class="label-name">自定义模板：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in templateList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==57">
                                    <label for="" class="label-name">课程详情：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==106">
                                    <label for="" class="label-name">小 程 序：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.link.type==107">
                                    <label for="" class="label-name">小 游 戏：</label>
                                    <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                </div>


                                 <!-- 独立商城的商品分类及商品详情 -->
                                    <!-- 一级分类 -->
                                    <div class="input-group-box clearfix" ng-show="component.link.type==500">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                    </div>
                                    <!-- 二级分类 -->
                                     <div class="input-group-box clearfix" ng-show="component.link.type==501">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="component.link.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                    </div>

                                    <!-- 独立商城商品 -->
                                    <div class="input-group-box clearfix" ng-show="component.link.type==502">
                                        <label for="" class="label-name">商品详情：</label>
                                        <div class="select-goods-modal-btn" style="width: 180px">
                                            <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(component.link,'linkName')" ng-value="component.link.linkName?component.link.linkName:'点击选择商品'" value="点击选择商品">
                                            <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(component.link,'url')" ng-value="component.link.url">
                                        </div>
                                    </div>
                                    <!-- 独立商城的商品分类 -->
                            </div>
                        </div>
                        <!-- 间隔配置 -->
                        <div class="space-set" ng-if="component.type=='space'">
                            <div class="manage-title">备注 <span class="manage-tips">(暂无相关配置)</span></div>
                        </div>
                        <!-- 商品列表配置 -->
                        <div class="good-set" ng-if="component.type=='goodlist'">
                            <div class="input-group-box">
                                <label class="label-name">是否显示销量：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodsold-{{$index}}" type="checkbox" ng-model="component.isShowsold" checked="">
                                            <label class="tgl-btn" for="goodsold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示商品数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                            <div class="input-group-box" ng-if="component.goodSourceType==3||component.goodSourceType==4">
                                <label class="label-name">排序方式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-sort-{{$index}}-1' type="radio" name='goods-sort-{{$index}}-1' value="1" ng-model="component.goodsSort"/>
                                    <label for="goods-sort-{{$index}}-1">默认排序</label>
                                    <input id='goods-sort-{{$index}}-2' type="radio" name='goods-sort-{{$index}}-1' value="2" ng-model="component.goodsSort"/>
                                    <label for="goods-sort-{{$index}}-2" style="margin-top: 10px;">按店铺距离排序</label>
                                </div>
                            </div>
                            <?php }?>
                            <div class="input-group-box">
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.goodSourceType"  ng-options="x.id as x.name for x in goodSourceType"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==1">
                                    <label class="label-name">商品分类：</label>
                                    <select class="cus-input" ng-model="component.goodSource" ng-options="x.id as x.name for x in allKindSelect"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==2">
                                    <label class="label-name">商品分组：</label>
                                    <select class="cus-input" ng-model="component.goodSource" ng-options="x.id as x.name for x in category"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="component.goodSource"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==4">
                                    <label class="label-name">商品分组：</label>
                                    <select class="cus-input" ng-model="component.goodSource" ng-options="x.id as x.name for x in shopCategory"></select>
                                </div>
                            </div>
                        </div>
                        <!-- 酒店房间列表配置 -->
                        <div class="good-set" ng-if="component.type=='roomlist'">

                            <div class="input-group-box">
                                <label class="label-name">显示商品数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                        </div>
                        <!-- 车源列表配置 -->
                        <div class="good-set" ng-if="component.type=='carlist'">
                            <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='car-get-type-{{$index}}-1' type="radio" name='car-type-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="car-get-type-{{$index}}-1">自动获取</label>
                                        <input id='car-get-type-{{$index}}-2' type="radio" name='car-type-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="car-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                            </div>
                            <div class="shop-manage">
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="shop-item" ng-repeat="shop in component.carData track by $index" ng-init="shopIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,shopIndex,'carData')">×</div>
                                        <div>车源名称: {{shop.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectCar(this)">＋<span>添加车源</span></div>
                                </div>
                            </div>

                            <div class="input-group-box">
                                <label class="label-name">是否显示里程：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="carmile-{{$index}}" type="checkbox" ng-model="component.isShowMile" checked="">
                                            <label class="tgl-btn" for="carmile-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>

                            <div class="input-group-box" ng-if="component.goodStyle!=4">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="carmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="carmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示车源数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='car-num-{{$index}}-1' type="radio" name='car-num-{{$index}}-1' value="4" ng-model="component.carNum"/>
                                    <label for="car-num-{{$index}}-1">4个</label>
                                    <input id='car-num-{{$index}}-2' type="radio" name='car-num-{{$index}}-1' value="6" ng-model="component.carNum"/>
                                    <label for="car-num-{{$index}}-2">6个</label>
                                    <input id='car-num-{{$index}}-3' type="radio" name='car-num-{{$index}}-1' value="8" ng-model="component.carNum"/>
                                    <label for="car-num-{{$index}}-3">8个</label>
                                    <input id='car-num-{{$index}}-4' type="radio" name='car-num-{{$index}}-1' value="10" ng-model="component.carNum"/>
                                    <label for="car-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                        </div>
                        <!-- 知识付费课程列表配置 -->
                        <div class="good-set" ng-if="component.type=='courselist'">
                            <div class="input-group-box">
                                <label class="label-name">是否显示销量：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodsold-{{$index}}" type="checkbox" ng-model="component.isShowsold" checked="">
                                            <label class="tgl-btn" for="goodsold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">是否加购按钮：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodcart-{{$index}}" type="checkbox" ng-model="component.isShowcart" checked="">
                                            <label class="tgl-btn" for="goodcart-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>-->
                            <div class="input-group-box">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示商品数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">链接类型：</label>
                                    <select class="cus-input form-control" ng-model="component.goodSourceType"  ng-options="x.id as x.name for x in goodSourceType"></select>
                                </div>
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==1">
                                    <label for="" class="label-name">分类列表：</label>
                                    <select class="cus-input form-control" ng-model="component.goodSource.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                </div>
                                <!-- 一级分类选择 -->
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==1">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.goodSource.kind"  ng-options="x.id as x.name for x in allKindSelect" >
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- 培训课程列表配置 -->
                        <div class="good-set" ng-if="component.type=='lessonlist'">
                            <div class="input-group-box">
                                <label class="label-name">是否显示人数：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodsold-{{$index}}" type="checkbox" ng-model="component.isShowsold" checked="">
                                            <label class="tgl-btn" for="goodsold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">是否加购按钮：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodcart-{{$index}}" type="checkbox" ng-model="component.isShowcart" checked="">
                                            <label class="tgl-btn" for="goodcart-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>-->
                            <div class="input-group-box">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示课程数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==1">
                                    <label for="" class="label-name">分类详情：</label>
                                    <select class="cus-input form-control" ng-model="component.goodSource.kind"  ng-options="x.id as x.name for x in lessonType" >
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 经典语录列表配置 -->
                        <div class="good-set" ng-if="component.type=='quotationList'">
                            <div class="input-group-box" ng-if="component.goodStyle!=4">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box clearfix">
                                <label for="" class="label-name">经典语录：</label>
                                <select class="cus-input form-control" ng-model="component.quotationId"  ng-options="x.id as x.content for x in quotaList"></select>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">显示数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="1" ng-model="component.quotationNum"/>
                                    <label for="goods-num-{{$index}}-1">1个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="2" ng-model="component.quotationNum"/>
                                    <label for="goods-num-{{$index}}-2">2个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="3" ng-model="component.quotationNum"/>
                                    <label for="goods-num-{{$index}}-3">3个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.quotationNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">4个</label>
                                </div>
                            </div>-->
                        </div>
                        <div class="good-set" ng-if="component.type=='chooseCommunity'">
                            <div class="input-group-box" >
                                <label class="label-name">是否显示：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="indexShow-{{$index}}" type="checkbox" ng-model="component.indexShow" checked="">
                                            <label class="tgl-btn" for="indexShow-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                        </div>
                        <!-- 分类商品配置 -->
                        <div class="good-set" ng-if="component.type=='cateGoods'">
                            <div class="input-group-box clearfix">
                                <label for="" class="label-name">链接类型：</label>
                                <select class="cus-input form-control" ng-model="component.cateType" >
                                    <option value="1">一级分类</option>
                                    <option value="2">二级分类</option>
                                </select>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">每个分类显示商品数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    <input id='goods-num-{{$index}}-0' type="radio" name='goods-num-{{$index}}-0' value="0" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-0">30个</label>
                                </div>
                            </div>

                            <div class="input-group-box" >
                                <label class="label-name">是否显示浏览量：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="showNum-{{$index}}" type="checkbox" ng-model="component.isShowNum" checked="">
                                            <label class="tgl-btn" for="showNum-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>

                            <div class="input-group-box" >
                                <label class="label-name">是否显示推荐：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="showRecommend-{{$index}}" type="checkbox" ng-model="component.showRecommend" checked="">
                                            <label class="tgl-btn" for="showRecommend-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box" style="color:red">
                                添加推荐商品：编辑商品时，将“首页推荐商品”选择为“是”并保存
                            </div>
                            <div class="input-group-box" >
                                <label class="label-name">推荐标题：</label>
                                <div class="right-info">
                                        <input type="text" class="cus-input" ng-model="component.recommendTitle" maxlength="6">
                                </div>
                            </div>
                            <div class="input-group-box" ng-show="component.styleType != 3">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box" style="color:red" ng-show="component.styleType != 3">
                               当组件置于页面底部时可直接滑动加载更多。其他位置将显示“更多”按钮。
                            </div>

                        </div>
                        <!-- 分类列表配置 -->
                        <div class="good-set" ng-if="component.type=='catelist'">
                            <div class="input-group-box clearfix">
                                <label for="" class="label-name">链接类型：</label>
                                <select class="cus-input form-control" ng-model="component.cateType" >
                                    <option value="1">一级分类</option>
                                    <option value="2">二级分类</option>
                                </select>
                            </div>
                        </div>
                        <!-- 分类商品配置 -->
                        <div class="good-set" ng-if="component.type=='activityList'">
                            <!--
                            <div class="input-group-box clearfix">
                                <label for="" class="label-name">链接类型：</label>
                                <select class="cus-input form-control" ng-model="component.cateType" >
                                    <option value="1">一级分类</option>
                                    <option value="2">二级分类</option>
                                </select>
                            </div>
                            -->
                            <div class="input-group-box">
                                <label class="label-name">每个分类显示活动数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                        </div>
                        <!-- 游戏列表配置 -->
                        <div class="good-set" ng-if="component.type=='gamelist'">
                            <div class="input-group-box" ng-if="component.goodStyle!=4">
                                <label class="label-name">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示游戏数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    <input id='goods-num-{{$index}}-5' type="radio" name='goods-num-{{$index}}-1' value="12" ng-model="component.goodsNum"/>
                                    <label for="goods-num-{{$index}}-5" style="margin-top: 6px">12个</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <div class="input-group-box clearfix" ng-show="component.goodSourceType==1">
                                    <label class="label-name">游戏分类：</label>
                                    <select class="cus-input" ng-model="component.goodSource" ng-options="x.id as x.name for x in gameCategory"></select>
                                </div>
                            </div>
                        </div>
                        <!-- 图文列表配置 -->
                        <div class="pictxt-set flnav-set" ng-if="component.type=='pictxt'">
                            <div class="manage-title">图文列表管理</div>
                            <div class="slideimg-manage" ui-sortable ng-model="component.picData">
                                <div class="slideimg-item" ng-repeat="pic in component.picData track by $index" ng-init="picIndex = $index">
                                    <div class="del-btn" ng-click="delItem($event,picIndex,'picData')">×</div>
                                    <!--<img ng-src="{{pic.cover}}" class="slide-img" alt="分类图标">-->
                                    <div ng-style="{'height': component.imageStyle.height*0.73,'width': picwidth[component.singleImgNum]*359*0.73}" style="margin: auto;">
                                        <img onclick="toUpload(this)" data-type="pictext" ng-style="{'height':component.style.height*0.73}" class="slide-img" alt="幻灯图片" data-ratio="0.73" data-limit="8" onload="changeSrc(this)" imageonload="doPicThis(component.picData,$index)" data-dom-id="upload-pic{{componentindex}}p{{picIndex}}" id="upload-pic{{componentindex}}p{{picIndex}}"  ng-src="{{pic.cover}}"  style="display:inline-block;margin-left:0;height: 100%; width: 100%">
                                        <input type="hidden" id="pic{{componentindex}}p{{picIndex}}"  class="avatar-field bg-img" name="pic{{componentindex}}p{{picIndex}}" ng-value="pic.cover"/>
                                    </div>
                                    <div class="input-group-box">
                                        <label class="label-name">标题名称：</label>
                                        <input type="text" class="cus-input" ng-model="pic.title">
                                    </div>
                                    <div class="input-group-box" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">
                                        <label class="label-name">内容简介：</label>
                                        <input type="text" class="cus-input" ng-model="pic.brief">
                                    </div>
                                    <!--<div class="input-group-box">
                                        <label class="label-name">链接类型：</label>
                                        <select class="cus-input" ng-model="pic.linkType" ng-options="x.link as x.name for x in pageLink"></select>
                                    </div>-->
                                    <div class="input-group-box">
                                        <!--<label class="label-name">链接地址：</label>
                                        <select class="cus-input" ng-model="pic.linkUrl" ng-options="x.link as x.name for x in pageLink"></select>-->
                                        <div class="input-group-box clearfix">
                                            <label for="" class="label-name">链接类型：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(pic.link,'linkName', 'url')"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==1">
                                            <label for="" class="label-name">资讯详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(pic.link,'linkName')" ng-value="pic.link.linkName?pic.link.linkName:'点击选择资讯'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(pic.link,'url')" ng-value="pic.link.url"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==2">
                                            <label for="" class="label-name">列　　表：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.path as x.name for x in linkList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==24">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in lessonType" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==3">
                                            <label for="" class="label-name">外　　链：</label>
                                            <input type="text" class="cus-input form-control" ng-value="pic.link.url" ng-model="pic.link.url" />
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==4">
                                            <label for="" class="label-name">分组详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==9">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==10">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==18">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in categoryList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==61">
                                            <label for="" class="label-name">菜单详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.title for x in menuList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==19">
                                            <label for="" class="label-name">服务详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==44">
                                            <label for="" class="label-name">车源详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in carList"></select>
                                         </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==45">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                         </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==46">
                                            <label for="" class="label-name">付费预约：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==5 || pic.link.type==201">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(pic.link,'linkName')" ng-value="pic.link.linkName?pic.link.linkName:'点击选择商品'">
                                                <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(pic.link,'url')" ng-value="pic.link.url"/>
                                            </div>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==6">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==37">
                                            <label for="" class="label-name">专家详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in expertList"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==38">
                                            <label for="" class="label-name">专家分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in expertCategory"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==39">
                                            <label for="" class="label-name">游戏分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in gameCategory"></select>
                                        </div>
                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==23">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==29">
                                            <label for="" class="label-name">秒杀商品：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in limitList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==30">
                                            <label for="" class="label-name">拼团商品：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in groupList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==31">
                                            <label for="" class="label-name">砍价商品：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in bargainList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==32">
                                            <label for="" class="label-name">资讯分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==104">
                                            <label for="" class="label-name">菜　　单：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url" ng-options="x.path as x.name for x in pages"></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==16">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==34">
                                            <label for="" class="label-name">店铺分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==17">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==20">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==41">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in category" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==42">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==43">
                                            <label for="" class="label-name">店铺详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in shoplist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==26">
                                            <label for="" class="label-name">分类列表：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==62">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in oneKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==35">
                                            <label for="" class="label-name">职位分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==36">
                                            <label for="" class="label-name">职位详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in positionList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==50">
                                            <label for="" class="label-name">公司分类：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==48">
                                            <label for="" class="label-name">公司详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in companySelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==54">
                                            <label for="" class="label-name">门店详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in storelist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==55">
                                            <label for="" class="label-name">自定义表单：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in formlist" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==56">
                                            <label for="" class="label-name">自定义模板：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in templateList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==57">
                                            <label for="" class="label-name">课程详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in courseList" ></select>
                                        </div>
                                        <!-- 一级分类选择 -->
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==26">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==106">
                                            <label for="" class="label-name">小 程 序：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                        </div>
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==107">
                                            <label for="" class="label-name">小 游 戏：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in gameList" ></select>
                                        </div>

                                        <!-- 独立商城的商品分类及商品详情 -->
                                        <!-- 一级分类 -->
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==500">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                                        </div>
                                        <!-- 二级分类 -->
                                         <div class="input-group-box clearfix" ng-show="pic.link.type==501">
                                            <label for="" class="label-name">分类详情：</label>
                                            <select class="cus-input form-control" ng-model="pic.link.url"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                                        </div>

                                        <!-- 独立商城商品 -->
                                        <div class="input-group-box clearfix" ng-show="pic.link.type==502">
                                            <label for="" class="label-name">商品详情：</label>
                                            <div class="select-goods-modal-btn" style="width: 180px">
                                                <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(pic.link,'linkName')" ng-value="pic.link.linkName?pic.link.linkName:'点击选择商品'" value="点击选择商品">
                                                <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(pic.link,'url')" ng-value="pic.link.url" value="">
                                            </div>
                                        </div>
                                        <!-- 独立商城的商品分类 -->
                                    </div>
                                </div>
                                <div class="add-slide" ng-click="addPic($event)">＋<span>添加图文</span></div>
                            </div>
                        </div>
                        <!-- 推荐列表配置 -->
                        <div class="pictxt-set flnav-set" ng-if="component.type=='recommendList'">
                            <div class="manage-title">推荐列表管理</div>
                            <div class="slideimg-manage">
                                <div class="input-group-box">
                                <label class="label-name" style="width:100px">是否显示更多：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">显示商品数量：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.recommendNum"/>
                                    <label for="goods-num-{{$index}}-1">4个</label>
                                    <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.recommendNum"/>
                                    <label for="goods-num-{{$index}}-2">6个</label>
                                    <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.recommendNum"/>
                                    <label for="goods-num-{{$index}}-3">8个</label>
                                    <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.recommendNum"/>
                                    <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <div class="input-group-box clearfix">
                                    <label for="" class="label-name">类型：</label>
                                    <select class="cus-input form-control" ng-model="component.recommendType"  ng-options="x.id as x.name for x in recommendTypeList"></select>
                                </div>
                            </div>
                            </div>
                        </div>
                        <!-- 店铺列表配置 -->
                        <div class="good-set" ng-if="component.type=='shoplist'">
                            <div class="shop-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='shop-get-type-{{$index}}-1' type="radio" name='shop-type-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-1">自动获取</label>
                                        <input id='shop-get-type-{{$index}}-2' type="radio" name='shop-type-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="shop-item" ng-repeat="shop in component.shopData track by $index" ng-init="shopIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,shopIndex,'shopData')">×</div>
                                        <div>店铺名称: {{shop.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectShop(this)">＋<span>添加店铺</span></div>
                                </div>
                                <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_s_id']==4546) {?>
                                <div class="input-group-box" ng-if="component.shopStyle!=3">
                                    <label class="label-name">是否显示更多：</label>
                                    <div class="right-info">
                                            <span class="tg-list-item">
                                                <input class="tgl tgl-light" id="shopmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                                <label class="tgl-btn" for="shopmore-{{$index}}"></label>
                                            </span>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示店铺数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='shop-num-{{$index}}-1' type="radio" name='shop-num-{{$index}}-1' value="4" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-1">4个</label>
                                        <input id='shop-num-{{$index}}-2' type="radio" name='shop-num-{{$index}}-1' value="6" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-2">6个</label>
                                        <input id='shop-num-{{$index}}-3' type="radio" name='shop-num-{{$index}}-1' value="8" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-3">8个</label>
                                        <input id='shop-num-{{$index}}-4' type="radio" name='shop-num-{{$index}}-1' value="10" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 门店列表配置 -->
                        <div class="good-set" ng-if="component.type=='storelist'">
                            <div class="shop-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='shop-get-type-{{$index}}-1' type="radio" name='shop-type-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-1">自动获取</label>
                                        <input id='shop-get-type-{{$index}}-2' type="radio" name='shop-type-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="shop-item" ng-repeat="shop in component.shopData track by $index" ng-init="shopIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,shopIndex,'shopData')">×</div>
                                        <div>店铺名称: {{shop.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectShop(this)">＋<span>添加店铺</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- 酒店门店列表配置 -->
                        <div class="good-set" ng-if="component.type=='hotelstorelist'">
                            <div class="shop-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='shop-get-type-{{$index}}-1' type="radio" name='shop-type-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-1">自动获取</label>
                                        <input id='shop-get-type-{{$index}}-2' type="radio" name='shop-type-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="shop-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示店铺数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='shop-num-{{$index}}-1' type="radio" name='shop-num-{{$index}}-1' value="4" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-1">4个</label>
                                        <input id='shop-num-{{$index}}-2' type="radio" name='shop-num-{{$index}}-1' value="6" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-2">6个</label>
                                        <input id='shop-num-{{$index}}-3' type="radio" name='shop-num-{{$index}}-1' value="8" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-3">8个</label>
                                        <input id='shop-num-{{$index}}-4' type="radio" name='shop-num-{{$index}}-1' value="10" ng-model="component.shopNum"/>
                                        <label for="shop-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="shop-item" ng-repeat="shop in component.storeData track by $index" ng-init="shopIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,shopIndex,'shopData')">×</div>
                                        <div>店铺名称: {{shop.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectStore(this)">＋<span>添加店铺</span></div>
                                </div>
                            </div>
                        </div>
                        <!-- 广告位配置 -->
                        <div class="slide-set" ng-if="component.type=='advertisement'">
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">广告位ID：</label>
                                <input type="text" class="cus-input" ng-model="component.unitId">
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['menuType']->value=='bdapp') {?>
                            <div class="input-group-box">
                                <label class="label-name" style="width: 80px;">百度应用ID：</label>
                                <input type="text" class="cus-input" ng-model="component.componAdId">
                            </div>
                            <?php }?>
                        </div>
                        <!-- 统计组件配置 -->
                        <div class="slide-set" ng-if="component.type=='statistics'">

                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=28) {?>
                            <div class="input-group-box">
                                <label class="label-name">统计数据图标：</label>
                                <div class="right-info">
                                    <div>
                                        <img onclick="toUpload(this)" class="statIcon" alt="统计数据图标" data-height="100" data-width="100"  data-limit="1" onload="changeSrc(this)" imageonload="doStatIconThis()" data-dom-id="upload-statIcon{{componentindex}}" id="upload-statIcon{{componentindex}}"  ng-src="{{$parent.$parent.statIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="statIcon{{componentindex}}"  class="avatar-field bg-img" name="navstatIcon{{componentindex}}" ng-value="$parent.$parent.statIcon"/>
                                    </div>
                                    <div class="recom-size">(建议尺寸100*100)</div>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">浏览量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="browseNum-{{$index}}" type="checkbox" ng-model="component.browseShow" checked="">
                                        <label class="tgl-btn" for="browseNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" for="">浏览量：</label>
                                <input type="text" class="cus-input" ng-model="$parent.$parent.browseNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">发布量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="issueNum-{{$index}}" type="checkbox" ng-model="component.issueShow" checked="">
                                        <label class="tgl-btn" for="issueNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" for="">发布量：</label>
                                <input type="text" class="cus-input" ng-model="$parent.$parent.issueNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">商家数量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="shopNum-{{$index}}" type="checkbox" ng-model="component.shopShow" checked="">
                                        <label class="tgl-btn" for="shopNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" for="">商家数量：</label>
                                <input type="text" class="cus-input" ng-model="$parent.$parent.shopNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">会员量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="addMemberNum-{{$index}}" type="checkbox" ng-model="component.memberShow" checked="">
                                        <label class="tgl-btn" for="addMemberNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name" for="">增加会员量：</label>
                                <input type="text" class="cus-input" ng-model="$parent.$parent.addMemberNum">
                            </div>
                            <div>（在真实会员数量的基础上，增加的会员显示数量）</div>
                            <?php } else { ?>
                            <div class="input-group-box">
                                <label class="label-name">统计数据图标：</label>
                                <div class="right-info">
                                    <div>
                                        <img onclick="toUpload(this)" class="statIcon" alt="统计数据图标" data-height="100" data-width="100"  data-limit="1" onload="changeSrc(this)" imageonload="doJobStatIconThis()" data-dom-id="upload-statIcon{{componentindex}}" id="upload-statIcon{{componentindex}}"  ng-src="{{jobInfo.statIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                                        <input type="hidden" id="statIcon{{componentindex}}"  class="avatar-field bg-img" name="navstatIcon{{componentindex}}" ng-value="jobInfo.statIcon"/>
                                    </div>
                                    <div class="recom-size">(建议尺寸100*100)</div>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label for="">公司数量（在真实数量上增加）：</label>
                                <input type="text" class="cus-input" ng-model="jobInfo.companyNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">公司数量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="addCompanyNum-{{$index}}" type="checkbox" ng-model="component.companyShow" checked="">
                                        <label class="tgl-btn" for="addCompanyNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label for="">职位数量（在真实数量上增加）：</label>
                                <input type="text" class="cus-input" ng-model="jobInfo.positionNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">职位数量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="addPositionNum-{{$index}}" type="checkbox" ng-model="component.positionShow" checked="">
                                        <label class="tgl-btn" for="addPositionNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label for="">简历数量（在真实数量上增加）：</label>
                                <input type="text" class="cus-input" ng-model="jobInfo.resumeNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">简历数量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="addResumeNum-{{$index}}" type="checkbox" ng-model="component.resumeShow" checked="">
                                        <label class="tgl-btn" for="addResumeNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label for="">访问量：</label>
                                <input type="text" class="cus-input" ng-model="jobInfo.browseNum">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">访问量显示：</label>
                                <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="addBrowseNum-{{$index}}" type="checkbox" ng-model="component.browseShow" checked="">
                                        <label class="tgl-btn" for="addBrowseNum-{{$index}}"></label>
                                    </span>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        <!-- 优惠券配置 -->
                        <div class="good-set" ng-if="component.type=='coupon'">
                            <div class="coupon-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='coupon-get-type-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="coupon-get-type-{{$index}}-1">自动获取</label>
                                        <input id='coupont-get-type-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="coupont-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="coupon-item" ng-repeat="coupon in component.couponData track by $index" ng-init="couponIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,couponIndex,'couponData')">×</div>
                                        <div>优惠券: {{coupon.name}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectCoupon(this)">＋<span>添加优惠券</span></div>
                                </div>
                                <div class="input-group-box">
                                    <label class="label-name">隐藏已抢完券：</label>
                                    <div class="right-info">
                                    <span class="tg-list-item">
                                        <input class="tgl tgl-light" id="couponshowover-{{$index}}" type="checkbox" ng-model="component.isShowover" checked="">
                                        <label class="tgl-btn" for="couponshowover-{{$index}}"></label>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 拼团配置 -->
                        <div class="good-set" ng-if="component.type=='group'">
                            <div class="group-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='group-get-type-{{$index}}-1' type="radio" name='group-num-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="group-get-type-{{$index}}-1">自动获取</label>
                                        <input id='group-get-type-{{$index}}-2' type="radio" name='group-num-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="group-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="group-item" ng-repeat="group in component.goodsData track by $index" ng-init="groupIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,groupIndex,'goodsData')">×</div>
                                        <div>活动名称: {{group.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectGroup(this)">＋<span>添加拼团</span></div>
                                </div>
                                <div class="input-group-box" ng-if="component.goodStyle!=4">
                                    <label class="label-name">是否显示更多：</label>
                                    <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示商品数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-1">4个</label>
                                        <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-2">6个</label>
                                        <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-3">8个</label>
                                        <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 秒杀配置 -->
                        <div class="good-set" ng-if="component.type=='seckill'">
                            <div class="seckill-manage">
                                <div class="input-group-box" ng-show="component.goodStyle!=5" >
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='seckill-get-type-{{$index}}-1' type="radio" name='seckill-num-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="seckill-get-type-{{$index}}-1">自动获取</label>
                                        <input id='seckill-get-type-{{$index}}-2' type="radio" name='seckill-num-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="seckill-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="seckill-item" ng-repeat="seckill in component.goodsData track by $index" ng-init="seckillIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,seckillIndex,'goodsData')">×</div>
                                        <div>活动名称: {{seckill.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectSeckill(this)">＋<span>添加秒杀</span></div>
                                </div>
                                <div class="input-group-box" ng-if="component.goodStyle!=4">
                                    <label class="label-name">是否显示更多：</label>
                                    <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示商品数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-1">4个</label>
                                        <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-2">6个</label>
                                        <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-3">8个</label>
                                        <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 砍价配置 -->
                        <div class="good-set" ng-if="component.type=='bargain'">
                            <div class="bargain-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='bargain-get-type-{{$index}}-1' type="radio" name='bargain-num-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="bargain-get-type-{{$index}}-1">自动获取</label>
                                        <input id='bargain-get-type-{{$index}}-2' type="radio" name='bargain-num-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="bargain-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="bargain-item" ng-repeat="bargain in component.goodsData track by $index" ng-init="bargainIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,bargainIndex,'goodsData')">×</div>
                                        <div>活动名称: {{bargain.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectBargain(this)">＋<span>添加砍价</span></div>
                                </div>
                                <div class="input-group-box" ng-if="component.goodStyle!=4">
                                    <label class="label-name">是否显示更多：</label>
                                    <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示商品数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-1">4个</label>
                                        <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-2">6个</label>
                                        <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-3">8个</label>
                                        <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- 积分商品配置 -->
                        <div class="good-set" ng-if="component.type=='points'">
                            <div class="bargain-manage">
                                <div class="input-group-box">
                                    <label class="label-name">添加方式：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='bargain-get-type-{{$index}}-1' type="radio" name='bargain-num-{{$index}}-1' value="1" ng-model="component.getType"/>
                                        <label for="bargain-get-type-{{$index}}-1">自动获取</label>
                                        <input id='bargain-get-type-{{$index}}-2' type="radio" name='bargain-num-{{$index}}-1' value="2" ng-model="component.getType"/>
                                        <label for="bargain-get-type-{{$index}}-2">手动添加</label>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==2">
                                    <div class="bargain-item" ng-repeat="bargain in component.goodsData track by $index" ng-init="bargainIndex = $index">
                                        <div class="del-btn" ng-click="delItem($event,bargainIndex,'goodsData')">×</div>
                                        <div>商品名称: {{bargain.title}}</div>
                                    </div>
                                    <div class="add-slide" data-index="{{$index}}" onclick="toSelectPoints(this)">＋<span>添加积分商品</span></div>
                                </div>
                                <div class="input-group-box" ng-if="component.goodStyle!=4">
                                    <label class="label-name">是否显示更多：</label>
                                    <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="goodmore-{{$index}}" type="checkbox" ng-model="component.isShowmore" checked="">
                                            <label class="tgl-btn" for="goodmore-{{$index}}"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="input-group-box" ng-if="component.getType==1">
                                    <label class="label-name">显示商品数量：</label>
                                    <div class="controls" style="display: block;padding: 6px 0;">
                                        <input id='goods-num-{{$index}}-1' type="radio" name='goods-num-{{$index}}-1' value="4" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-1">4个</label>
                                        <input id='goods-num-{{$index}}-2' type="radio" name='goods-num-{{$index}}-1' value="6" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-2">6个</label>
                                        <input id='goods-num-{{$index}}-3' type="radio" name='goods-num-{{$index}}-1' value="8" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-3">8个</label>
                                        <input id='goods-num-{{$index}}-4' type="radio" name='goods-num-{{$index}}-1' value="10" ng-model="component.goodsNum"/>
                                        <label for="goods-num-{{$index}}-4" style="margin-top: 6px">10个</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="notice post-type" data-right-edit data-id="10086">
                        <label>帖子类型</label>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="postType[0].name">
                                <div class="right-info">
                                    <span class='tg-list-item' style="display: none">
                                        <input class='tgl tgl-light' id='must_type0' type='checkbox' ng-model="postType[0].must">
                                        <label class='tgl-btn' for='must_type0' style="position: relative;top: 10px;"></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="postType[1].name">
                                <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='must_type1' type='checkbox' ng-model="postType[1].must">
                                        <label class='tgl-btn' for='must_type1' style="position: relative;top: 10px;"></label>
                                    </span>
                                </div>
                            </div>
                            <span style="color:red;font-size: 13px">建议审核时先关闭，等审核通过再开启该功能</span>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="postType[2].name">
                                <div class="right-info">
                                    <span class='tg-list-item'>
                                        <input class='tgl tgl-light' id='must_type2' type='checkbox' ng-model="postType[2].must">
                                        <label class='tgl-btn' for='must_type2' style="position: relative;top: 10px;"></label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="postType[3].name">
                                <div class="right-info">
                                    <span class='tg-list-item' style="display: none">
                                        <input class='tgl tgl-light' id='must_type3' type='checkbox' ng-model="postType[3].must">
                                        <label class='tgl-btn' for='must_type3' style="position: relative;top: 10px;"></label>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <label>自定义链接</label>
                        <div class="slideimg-manage">
                            <div class="slideimg-item" ng-repeat="tab in tabList" >
                                <div class="del-btn" ng-click="delRealIndex('tabList',tab.index)">×</div>
                                <!--<img ng-src="{{pic.cover}}" class="slide-img" alt="分类图标">-->
                                <!--
                                <div ng-style="{'height': component.imageStyle.height*0.73,'width': picwidth[component.singleImgNum]*359*0.73}" style="margin: auto;">
                                    <img onclick="toUpload(this)" data-type="pictext" ng-style="{'height':component.style.height*0.73}" class="slide-img" alt="幻灯图片" data-ratio="0.73" data-limit="8" onload="changeSrc(this)" imageonload="doPicThis(component.picData,$index)" data-dom-id="upload-pic{{componentindex}}p{{picIndex}}" id="upload-pic{{componentindex}}p{{picIndex}}"  ng-src="{{pic.cover}}"  style="display:inline-block;margin-left:0;height: 100%; width: 100%">
                                    <input type="hidden" id="pic{{componentindex}}p{{picIndex}}"  class="avatar-field bg-img" name="pic{{componentindex}}p{{picIndex}}" ng-value="pic.cover"/>
                                </div>
                                -->
                                <div class="input-group-box">
                                    <label class="label-name">标题名称：</label>
                                    <input type="text" class="cus-input" ng-model="tab.name">
                                </div>
                                <!--
                                <div class="input-group-box" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">
                                    <label class="label-name">内容简介：</label>
                                    <input type="text" class="cus-input" ng-model="pic.brief">
                                </div>
                                <!--<div class="input-group-box">
                                    <label class="label-name">链接类型：</label>
                                    <select class="cus-input" ng-model="pic.linkType" ng-options="x.link as x.name for x in pageLink"></select>
                                </div>-->
                                <div class="input-group-box">
                                    <!--<label class="label-name">链接地址：</label>
                                    <select class="cus-input" ng-model="pic.linkUrl" ng-options="x.link as x.name for x in pageLink"></select>-->
                                    <div class="input-group-box clearfix">
                                        <label for="" class="label-name">链接类型：</label>
                                        <select class="cus-input form-control" ng-model="tab.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(tab.link,'name', 'type')"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==1">
                                        <label for="" class="label-name">资讯详情：</label>
                                        <div class="select-goods-modal-btn" style="width: 180px">
                                            <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(tab.link,'linkName')" ng-value="tab.linkName?tab.linkName:'点击选择资讯'">
                                            <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(tab,'link')" ng-value="tab.link"/>
                                        </div>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==2">
                                        <label for="" class="label-name">列　　表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.path as x.name for x in linkList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==3">
                                        <label for="" class="label-name">外　　链：</label>
                                        <input type="text" class="cus-input form-control" ng-value="tab.link" ng-model="tab.link" />
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==4">
                                        <label for="" class="label-name">分组详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in category" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==9">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==10">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==18">
                                        <label for="" class="label-name">分类列表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in categoryList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==61">
                                        <label for="" class="label-name">菜单详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.title for x in menuList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==19">
                                        <label for="" class="label-name">服务详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==44">
                                        <label for="" class="label-name">车源详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in carList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==45">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==46">
                                        <label for="" class="label-name">付费预约：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                    </div>

                                    <div class="input-group-box clearfix" ng-show="tab.type==5 || tab.type==201">
                                        <label for="" class="label-name">商品详情：</label>
                                        <div class="select-goods-modal-btn" style="width: 180px">
                                            <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(tab.link,'linkName')" ng-value="tab.link.linkName?tab.linkName:'点击选择商品'">
                                            <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(tab.link,'link')" ng-value="tab.link"/>
                                        </div>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==6">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==37">
                                        <label for="" class="label-name">专家详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in expertList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==38">
                                        <label for="" class="label-name">专家分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in expertCategory"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==39">
                                        <label for="" class="label-name">游戏分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in gameCategory"></select>
                                    </div>
                                    <!-- 一级分类选择 -->
                                    <div class="input-group-box clearfix" ng-show="tab.type==23">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==29">
                                        <label for="" class="label-name">秒杀商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in limitList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==30">
                                        <label for="" class="label-name">拼团商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in groupList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==31">
                                        <label for="" class="label-name">砍价商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==32">
                                        <label for="" class="label-name">资讯分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==104">
                                        <label for="" class="label-name">菜　　单：</label>
                                        <select class="cus-input form-control" ng-model="tab.link" ng-options="x.path as x.name for x in pages"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==16">
                                        <label for="" class="label-name">店铺分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==34">
                                        <label for="" class="label-name">店铺分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==17">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==20">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==26">
                                        <label for="" class="label-name">分类列表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                    </div>
                                    <!-- 一级分类选择 -->
                                    <div class="input-group-box clearfix" ng-show="tab.type==26">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==41">
                                        <label for="" class="label-name">商品分组：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in category" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==42">
                                        <label for="" class="label-name">商品分组：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==43">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==54">
                                        <label for="" class="label-name">门店详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in storelist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==55">
                                        <label for="" class="label-name">自定义表单：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in formlist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==56">
                                        <label for="" class="label-name">自定义模板：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in templateList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==57">
                                        <label for="" class="label-name">课程详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in courseList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.link.type==106">
                                        <label for="" class="label-name">小 程 序：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                    </div>
                                </div>
                            </div>
                            <div class="add-slide" ng-click="addTabList()">＋<span>添加链接</span></div>
                        </div>

                    </div>
                    <div class="notice post-type" data-right-edit data-id="10087">
                        <label>职位类型</label>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 45%" maxlength="4" minlength="2" ng-model="positionType[0].name">
                                <select class="cus-input form-control" ng-model="positionType[0].type" style="width: 35%;display: inline-block;"  ng-options="x.type as x.title for x in jobSortType" ></select>
                                <span class='tg-list-item' style="margin-right: 0">
                                    <input class='tgl tgl-light' id='position_must_type0' type='checkbox' ng-model="positionType[0].must">
                                    <label class='tgl-btn' for='position_must_type0' style="display: inline-block;top: 10px;"></label>
                                </span>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 45%" maxlength="4" minlength="2" ng-model="positionType[1].name">
                                <select class="cus-input form-control" ng-model="positionType[1].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in jobSortType" ></select>
                                <span class='tg-list-item' style="margin-right: 0">
                                    <input class='tgl tgl-light' id='position_must_type1' type='checkbox' ng-model="positionType[1].must">
                                    <label class='tgl-btn' for='position_must_type1' style="display: inline-block;top: 10px;"></label>
                                </span>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 45%" maxlength="4" minlength="2" ng-model="positionType[2].name">
                                <select class="cus-input form-control" ng-model="positionType[2].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in jobSortType" ></select>
                                <span class='tg-list-item' style="margin-right: 0">
                                    <input class='tgl tgl-light' id='position_must_type2' type='checkbox' ng-model="positionType[2].must">
                                    <label class='tgl-btn' for='position_must_type2' style="display: inline-block;top: 10px;"></label>
                                </span>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 45%" maxlength="4" minlength="2" ng-model="positionType[3].name">
                                <select class="cus-input form-control" ng-model="positionType[3].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in jobSortType" ></select>
                                <span class='tg-list-item' style="margin-right: 0">
                                    <input class='tgl tgl-light' id='position_must_type3' type='checkbox' ng-model="positionType[3].must">
                                    <label class='tgl-btn' for='position_must_type3' style="display: inline-block;top: 10px;"></label>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="notice post-type" data-right-edit data-id="10010">
                        <label>标签名称</label>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="carCfg[0].name">
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box">
                                <input type="text" class="cus-input" style="width: 90%" maxlength="4" minlength="2" ng-model="carCfg[1].name">
                            </div>
                        </div>

                        <label>自定义链接</label>
                        <div class="slideimg-manage">
                            <div class="slideimg-item" ng-repeat="tab in tabList" >
                                <div class="del-btn" ng-click="delRealIndex('tabList',tab.index)">×</div>
                                <!--<img ng-src="{{pic.cover}}" class="slide-img" alt="分类图标">-->
                                <!--
                                <div ng-style="{'height': component.imageStyle.height*0.73,'width': picwidth[component.singleImgNum]*359*0.73}" style="margin: auto;">
                                    <img onclick="toUpload(this)" data-type="pictext" ng-style="{'height':component.style.height*0.73}" class="slide-img" alt="幻灯图片" data-ratio="0.73" data-limit="8" onload="changeSrc(this)" imageonload="doPicThis(component.picData,$index)" data-dom-id="upload-pic{{componentindex}}p{{picIndex}}" id="upload-pic{{componentindex}}p{{picIndex}}"  ng-src="{{pic.cover}}"  style="display:inline-block;margin-left:0;height: 100%; width: 100%">
                                    <input type="hidden" id="pic{{componentindex}}p{{picIndex}}"  class="avatar-field bg-img" name="pic{{componentindex}}p{{picIndex}}" ng-value="pic.cover"/>
                                </div>
                                -->
                                <div class="input-group-box">
                                    <label class="label-name">标题名称：</label>
                                    <input type="text" class="cus-input" ng-model="tab.name">
                                </div>
                                <!--
                                <div class="input-group-box" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">
                                    <label class="label-name">内容简介：</label>
                                    <input type="text" class="cus-input" ng-model="pic.brief">
                                </div>
                                <!--<div class="input-group-box">
                                    <label class="label-name">链接类型：</label>
                                    <select class="cus-input" ng-model="pic.linkType" ng-options="x.link as x.name for x in pageLink"></select>
                                </div>-->
                                <div class="input-group-box">
                                    <!--<label class="label-name">链接地址：</label>
                                    <select class="cus-input" ng-model="pic.linkUrl" ng-options="x.link as x.name for x in pageLink"></select>-->
                                    <div class="input-group-box clearfix">
                                        <label for="" class="label-name">链接类型：</label>
                                        <select class="cus-input form-control" ng-model="tab.type"  ng-options="x.id as x.name for x in linkTypes" ng-change="clearGoodsValue(tab.link,'name', 'type')"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==1">
                                        <label for="" class="label-name">资讯详情：</label>
                                        <div class="select-goods-modal-btn" style="width: 180px">
                                            <input type="button" class="select-btn" onclick="toSelectInformation(this)" selectchange="doGoodsSelect(tab.link,'linkName')" ng-value="tab.linkName?tab.linkName:'点击选择资讯'">
                                            <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(tab,'link')" ng-value="tab.link"/>
                                        </div>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==2">
                                        <label for="" class="label-name">列　　表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.path as x.name for x in linkList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==3">
                                        <label for="" class="label-name">外　　链：</label>
                                        <input type="text" class="cus-input form-control" ng-value="tab.link" ng-model="tab.link" />
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==4">
                                        <label for="" class="label-name">分组详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in category" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==9">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==10">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==18">
                                        <label for="" class="label-name">分类列表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in categoryList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==61">
                                        <label for="" class="label-name">菜单详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.title for x in menuList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==19">
                                        <label for="" class="label-name">服务详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.title for x in serviceArticles"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==44">
                                        <label for="" class="label-name">服务详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in carList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==45">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in carShopKindList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==46">
                                        <label for="" class="label-name">付费预约：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==5 || tab.type==201">
                                        <label for="" class="label-name">商品详情：</label>
                                        <div class="select-goods-modal-btn" style="width: 180px">
                                            <input type="button" class="select-btn" onclick="toSelectGoods(this)" selectchange="doGoodsSelect(tab.link,'linkName')" ng-value="tab.link.linkName?tab.linkName:'点击选择商品'">
                                            <input type="hidden"  class="avatar-field bg-img" selectchange="doGoodsSelect(tab.link,'link')" ng-value="tab.link"/>
                                        </div>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==6">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in reservationCategory"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==37">
                                        <label for="" class="label-name">专家详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in expertList"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==38">
                                        <label for="" class="label-name">专家分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in expertCategory"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==39">
                                        <label for="" class="label-name">游戏分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in gameCategory"></select>
                                    </div>
                                    <!-- 一级分类选择 -->
                                    <div class="input-group-box clearfix" ng-show="tab.type==23">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==29">
                                        <label for="" class="label-name">秒杀商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in limitList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==30">
                                        <label for="" class="label-name">拼团商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in groupList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==31">
                                        <label for="" class="label-name">砍价商品：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==32">
                                        <label for="" class="label-name">资讯分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==104">
                                        <label for="" class="label-name">菜　　单：</label>
                                        <select class="cus-input form-control" ng-model="tab.link" ng-options="x.path as x.name for x in pages"></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==16">
                                        <label for="" class="label-name">店铺分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==34">
                                        <label for="" class="label-name">店铺分类：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==17">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==20">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==26">
                                        <label for="" class="label-name">分类列表：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                                    </div>
                                    <!-- 一级分类选择 -->
                                    <div class="input-group-box clearfix" ng-show="tab.type==26">
                                        <label for="" class="label-name">分类详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==41">
                                        <label for="" class="label-name">商品分组：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in category" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==11">
                                            <label for="" class="label-name">商品分组：</label>
                                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in limitGoodsGroup" ></select>
                                        </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==42">
                                        <label for="" class="label-name">商品分组：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==43">
                                        <label for="" class="label-name">店铺详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==54">
                                        <label for="" class="label-name">门店详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in storelist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==55">
                                        <label for="" class="label-name">自定义表单：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in formlist" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==56">
                                        <label for="" class="label-name">自定义模板：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in templateList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.type==57">
                                        <label for="" class="label-name">课程详情：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in courseList" ></select>
                                    </div>
                                    <div class="input-group-box clearfix" ng-show="tab.link.type==106">
                                        <label for="" class="label-name">小 程 序：</label>
                                        <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                                    </div>
                                </div>
                            </div>
                            <div class="add-slide" ng-click="addTabList()">＋<span>添加链接</span></div>
                        </div>

                    </div>
                </div>
                <div class="tab-con-item" data-type="set2">
                    <div data-right-edit data-id="-1" style="display: none;">
                        <div class="input-group-box">
                            <label class="label-name">页面背景色：</label>
                            <spectrum-colorpicker ng-model="pagebgColor" options="colorOptions"></spectrum-colorpicker>
                        </div>
                    </div>
                    <div ng-repeat="component in showComponentData track by $index" data-right-edit data-id="{{$index}}">
                        <!-- 轮播图样式 -->
                        <div class="slide-set" ng-if="component.type=='slide'">
                            <div class="input-group-box">
                                <label class="label-name">自动轮播：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="slide-autoplay-{{$index}}" type="checkbox" ng-model="component.autoplay" checked="">
                                            <label class="tgl-btn" for="slide-autoplay-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">动画时长<span>(ms)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.duration">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">滑动间隔<span>(ms)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.interval">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">轮播指示点：</label>
                                <spectrum-colorpicker ng-model="component.indicatorColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">选中指示点：</label>
                                <spectrum-colorpicker ng-model="component.indicatorActiveColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">轮播高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">右内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingRight">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">左内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingLeft">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">幻灯圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.borderRadius">
                            </div>
                        </div>
                        <!-- 视频样式 -->
                        <div class="slide-set" ng-if="component.type=='video'">
                            <div class="input-group-box">
                                <label class="label-name">自动播放：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="video-autoplay-{{$index}}" type="checkbox" ng-model="component.autoplay" checked="">
                                            <label class="tgl-btn" for="video-autoplay-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">视频高度：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">右内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingRight">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">左内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingLeft">
                            </div>
                        </div>
                        <!-- 分类导航样式 -->
                        <div class="slide-set" ng-if="component.type=='fenlei'">
                            <div class="input-group-box" ng-if="component.styleType!=3">
                                <label class="label-name">单行个数：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='nav-num-{{$index}}-1' type="radio" name='nav-num-{{$index}}-1' value="3" ng-model="component.navNumber"/>
                                    <label for="nav-num-{{$index}}-1">3个</label>
                                    <input id='nav-num-{{$index}}-2' type="radio" name='nav-num-{{$index}}-1' value="4" ng-model="component.navNumber"/>
                                    <label for="nav-num-{{$index}}-2">4个</label>
                                    <input id='nav-num-{{$index}}-3' type="radio" name='nav-num-{{$index}}-1' value="5" ng-model="component.navNumber"/>
                                    <label for="nav-num-{{$index}}-3">5个</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">导航样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='fenlei-nav-{{$index}}-1' type="radio" name='fenlei-nav-{{$index}}-1' value="1" ng-model="component.styleType"/>
                                    <label for="fenlei-nav-{{$index}}-1">单行滑动</label>
                                    <input id='fenlei-nav-{{$index}}-2' type="radio" name='fenlei-nav-{{$index}}-1' value="2" ng-model="component.styleType"/>
                                    <label for="fenlei-nav-{{$index}}-2">两行滑屏</label>
                                    <input id='fenlei-nav-{{$index}}-3' type="radio" name='fenlei-nav-{{$index}}-1' value="3" ng-model="component.styleType"/>
                                    <label for="fenlei-nav-{{$index}}-3" style="margin-top:6px;">简介导航</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.styleType==2&&component.navpages.length>1">
                                <label class="label-name">轮播指示点：</label>
                                <spectrum-colorpicker ng-model="component.indicatorColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.styleType==2&&component.navpages.length>1">
                                <label class="label-name">选中指示点：</label>
                                <spectrum-colorpicker ng-model="component.indicatorActiveColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.styleType!=3">
                                <label class="label-name">导航宽度<span>(%)</span>：</label>
                                <input type="number" string-to-number min="80" max="100" class="cus-input" ng-model="component.style.width">
                            </div>
                            <div class="input-group-box" ng-if="component.styleType!=3">
                                <label class="label-name">导航圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.borderRadius">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">导航背景色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图标圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.iconRadius">
                            </div>
                            <div class="input-group-box" ng-if="component.styleType!=3">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.styleType==3">
                                <label class="label-name">简介字颜色：</label>
                                <spectrum-colorpicker ng-model="component.briefColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 搜索样式 -->
                        <div class="slide-set" ng-if="component.type=='search'">
                            <div class="input-group-box">
                                <label class="label-name">搜索区背景色：</label>
                                <spectrum-colorpicker ng-model="component.searchArea.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索框背景色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">替换文本颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">边框颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.borderColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索图标颜色：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='searchicon-{{$index}}-1' type="radio" name='searchicon-{{$index}}-1' value="black" ng-model="component.searchiconColor"/>
                                    <label for="searchicon-{{$index}}-1">黑</label>
                                    <input id='searchicon-{{$index}}-2' type="radio" name='searchicon-{{$index}}-1' value="white" ng-model="component.searchiconColor"/>
                                    <label for="searchicon-{{$index}}-2">白</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">字体大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索框高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索框宽度<span>(%)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.width">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索框圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.borderRadius">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.searchArea.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.searchArea.paddingBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.searchArea.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.searchArea.marginBottom">
                            </div>
                        </div>

                        <!-- 选择小区样式 -->
                        <div class="slide-set" ng-if="component.type=='chooseCommunity'">
                            <div class="input-group-box">
                                <label for="" class="label-name">组件样式：</label>
                                <select class="cus-input form-control" ng-model="component.componentStyle" ng-change="changeChooseCommunityStyle(component.componentStyle)">
                                    <option value="1">详细信息</option>
                                    <option value="2">简洁</option>
                                </select>
                            </div>

                            <div class="choose-community-style" ng-show="component.componentStyle == 2">

                            <div class="input-group-box">
                                <label class="label-name">组件背景色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                 <label class="label-name">组件文本颜色：</label>
                                 <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                                </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索区背景色：</label>
                                <spectrum-colorpicker ng-model="component.searchArea.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                                <div class="input-group-box">
                                    <label class="label-name">搜索区边框色：</label>
                                    <spectrum-colorpicker ng-model="component.searchAreaBorderColor" options="colorOptions"></spectrum-colorpicker>
                                </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索提示颜色：</label>
                                <spectrum-colorpicker ng-model="component.searchArea.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">搜索图标颜色：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='searchicon-{{$index}}-1' type="radio" name='searchicon-{{$index}}-1' value="black" ng-model="component.searchiconColor"/>
                                    <label for="searchicon-{{$index}}-1">黑</label>
                                    <input id='searchicon-{{$index}}-2' type="radio" name='searchicon-{{$index}}-1' value="white" ng-model="component.searchiconColor"/>
                                    <label for="searchicon-{{$index}}-2">白</label>
                                </div>
                            </div>
                            </div>
                        </div>

                        <!-- 地址样式 -->
                        <div ng-if="component.type=='address'">
                            <div class="input-group-box">
                                <label class="label-name">地址样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='address-{{$index}}-1' type="radio" name='address-{{$index}}-1' value="1" ng-model="component.addressStyle"/>
                                    <label for="address-{{$index}}-1">单地址</label>
                                    <input id='address-{{$index}}-2' type="radio" name='address-{{$index}}-1' value="2" ng-model="component.addressStyle"/>
                                    <label for="address-{{$index}}-2">电话地址</label>
                                    <input id='address-{{$index}}-3' type="radio" name='address-{{$index}}-1' value="3" ng-model="component.addressStyle"/>
                                    <label for="address-{{$index}}-3" style="margin-top:6px;">店铺信息</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                            <div class="input-group-box" ng-if="component.addressStyle!=3">
                                <label class="label-name">文字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box" ng-if="component.addressStyle!=3">
                                <label class="label-name">文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                        </div>
                        <!-- 通知公告样式 -->
                        <div ng-if="component.type=='notice'">
                            <div class="input-group-box">
                                <label class="label-name">标题是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="notice-{{$index}}" type="checkbox" ng-model="component.isBold" checked="">
                                            <label class="tgl-btn" for="notice-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">通知背景颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">通知标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">通知文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">通知文字大小：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 标题样式 -->
                        <div class="title-set" ng-if="component.type=='title'">
                            <div class="input-group-box">
                                <label class="label-name">标题样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='title-{{$index}}-1' type="radio" name='title-{{$index}}-1' value="1" ng-model="component.titleStyle"/>
                                    <label for="title-{{$index}}-1">纯标题</label>
                                    <input id='title-{{$index}}-2' type="radio" name='title-{{$index}}-1' value="2" ng-model="component.titleStyle"/>
                                    <label for="title-{{$index}}-2">左圆点</label>
                                    <input id='title-{{$index}}-3' type="radio" name='title-{{$index}}-1' value="3" ng-model="component.titleStyle"/>
                                    <label for="title-{{$index}}-3" style="margin-top: 6px;">左线条</label>
                                    <input id='title-{{$index}}-4' type="radio" name='title-{{$index}}-1' value="4" ng-model="component.titleStyle"/>
                                    <label for="title-{{$index}}-4" style="margin-top: 6px;">下横线</label>
                                    <input id='title-{{$index}}-5' type="radio" name='title-{{$index}}-1' value="5" ng-model="component.titleStyle"/>
                                    <label for="title-{{$index}}-5" style="margin-top: 6px;">背景图样式</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle==1||component.titleStyle==5">
                                <label class="label-name">标题位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='titlealign-{{$index}}-1' type="radio" name='titlealign-{{$index}}-1' value="left" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-1">居左</label>
                                    <input id='titlealign-{{$index}}-2' type="radio" name='titlealign-{{$index}}-1' value="center" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-2">居中</label>
                                    <input id='titlealign-{{$index}}-3' type="radio" name='titlealign-{{$index}}-1' value="right" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="notice-{{$index}}" type="checkbox" ng-model="component.isBold" checked="">
                                            <label class="tgl-btn" for="notice-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle==5">
                                <label class="label-name">标题背景图：</label>
                                <div class="right-info">
                                    <!--<img ng-src="{{component.titleBg}}" style="height:32px;width: 190px;cursor: pointer;" alt="标题背景">-->
                                    <div style="height: {{component.style.fontSize*0.25 + component.style.paddingTop*0.25 + component.style.paddingBottom*0.25}}px">
                                        <img onclick="toUpload(this)" data-type="title" class="companylogo" alt="标题背景" data-ratio="0.25" data-width="750"  data-limit="8" onload="changeSrc(this)" imageonload="doTitleBgThis(component)" data-dom-id="upload-titleBg{{$index}}" id="upload-titleBg{{$index}}"  ng-src="{{component.titleBg}}"  height="100%" style="height:100%;width: 190px;cursor: pointer;">
                                        <input type="hidden" id="titleBg{{$index}}"  class="avatar-field bg-img" name="titleBg{{$index}}" ng-value="component.titleBg"/>
                                    </div>
                                    <p style="color: #38f;font-size: 12px;cursor: pointer;" onclick="toUpload(this)" class="companylogo" alt="标题背景" data-type="title" data-btn="text" data-ratio="0.25" data-width="750"  data-limit="8"  data-dom-id="upload-titleBg{{$index}}" >更换标题背景图</p>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=5">
                                <label class="label-name">标题背景色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=1||component.titleStyle!=5">
                                <label class="label-name">装饰颜色：</label>
                                <spectrum-colorpicker ng-model="component.lineColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 图片样式 -->
                        <div class="title-set" ng-if="component.type=='image'">
                            <div class="input-group-box">
                                <label class="label-name">图片位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='image-{{$index}}-1' type="radio" name='image-{{$index}}-1' value="left" ng-model="component.imageLocation"/>
                                    <label for="image-{{$index}}-1">居左</label>
                                    <input id='image-{{$index}}-2' type="radio" name='image-{{$index}}-1' value="center" ng-model="component.imageLocation"/>
                                    <label for="image-{{$index}}-2">居中</label>
                                    <input id='image-{{$index}}-3' type="radio" name='image-{{$index}}-1' value="right" ng-model="component.imageLocation"/>
                                    <label for="image-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片宽度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.width">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.borderRadius">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">背景颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">左内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingLeft">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 橱窗样式 -->
                        <div class="title-set" ng-if="component.type=='window'">
                            <div class="input-group-box">
                                <label class="label-name">橱窗样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='window-{{$index}}-1' type="radio" name='window-{{$index}}-1' value="1" ng-model="component.windowStyle"/>
                                    <label for="window-{{$index}}-1">两列</label>
                                    <input id='window-{{$index}}-2' type="radio" name='window-{{$index}}-1' value="2" ng-model="component.windowStyle"/>
                                    <label for="window-{{$index}}-2">左一右二</label>
                                    <input id='window-{{$index}}-3' type="radio" name='window-{{$index}}-1' value="3" ng-model="component.windowStyle"/>
                                    <label for="window-{{$index}}-3">左二右一</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">橱窗高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片间距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.padding">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.borderRadius">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">背景颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">左内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingLeft">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">右内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingRight">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <div class="title-set" ng-if="component.type=='button'">
                            <div class="input-group-box">
                                <label class="label-name">按钮位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='button-{{$index}}-1' type="radio" name='button-{{$index}}-1' value="left" ng-model="component.style.textAlign"/>
                                    <label for="button-{{$index}}-1">居左</label>
                                    <input id='button-{{$index}}-2' type="radio" name='button-{{$index}}-1' value="center" ng-model="component.style.textAlign"/>
                                    <label for="button-{{$index}}-2">居中</label>
                                    <input id='button-{{$index}}-3' type="radio" name='button-{{$index}}-1' value="right" ng-model="component.style.textAlign"/>
                                    <label for="button-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮背景颜色：</label>
                                <spectrum-colorpicker ng-model="component.buttonStyle.backgroundColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮边框颜色：</label>
                                <spectrum-colorpicker ng-model="component.buttonStyle.borderColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.buttonStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">文字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="10" class="cus-input" ng-model="component.buttonStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮宽度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" max="375" class="cus-input" ng-model="component.buttonStyle.width">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.buttonStyle.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮行高<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.buttonStyle.lineHeight">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">按钮圆角<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.buttonStyle.borderRadius">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingBottom">
                            </div>
                        </div>
                        <!-- 间隔样式 -->
                        <div class="title-set" ng-if="component.type=='space'">
                            <div class="input-group-box">
                                <label class="label-name">线条样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='space-style-{{$index}}-1' type="radio" name='space-style-{{$index}}-1' value="solid" ng-model="component.spaceStyle.borderTopStyle"/>
                                    <label for="space-style-{{$index}}-1">实线</label>
                                    <input id='space-style-{{$index}}-2' type="radio" name='space-style-{{$index}}-1' value="dashed" ng-model="component.spaceStyle.borderTopStyle"/>
                                    <label for="space-style-{{$index}}-2">虚线</label>
                                    <input id='space-style-{{$index}}-3' type="radio" name='space-style-{{$index}}-1' value="dotted" ng-model="component.spaceStyle.borderTopStyle"/>
                                    <label for="space-style-{{$index}}-3">点线</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">线条位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='space-location-{{$index}}-1' type="radio" name='space-location-{{$index}}-1' value="left" ng-model="component.spaceLocation"/>
                                    <label for="space-location-{{$index}}-1">居左</label>
                                    <input id='space-location-{{$index}}-2' type="radio" name='space-location-{{$index}}-1' value="center" ng-model="component.spaceLocation"/>
                                    <label for="space-location-{{$index}}-2">居中</label>
                                    <input id='space-location-{{$index}}-3' type="radio" name='space-location-{{$index}}-1' value="right" ng-model="component.spaceLocation"/>
                                    <label for="space-location-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">线条颜色：</label>
                                <spectrum-colorpicker ng-model="component.spaceStyle.borderTopColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">线条宽度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" max="375" class="cus-input" ng-model="component.spaceStyle.width">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">线条高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.spaceStyle.borderTopWidth">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">左内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingLeft">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                        </div>
                        <!-- 商品列表配置 -->
                        <div class="good-set" ng-if="component.type=='goodlist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-2' value="2" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-2">详细列表</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-3' value="3" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">大图</label>
                                    <input id='goodlist-{{$index}}-4' type="radio" name='goodlist-{{$index}}-4' value="4" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-4" style="margin-top: 6px;">横向滑动</label>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                                    <input id='goodlist-{{$index}}-5' type="radio" name='goodlist-{{$index}}-5' value="5" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-5" style="margin-top: 6px;">三列</label>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box" <?php if (!in_array($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type'],array(8))) {?> style="display:none" <?php }?> >
                                <label class="label-name">加购按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.cartBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" >
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 酒店房间列表配置 -->
                        <div class="good-set" ng-if="component.type=='roomlist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-4' type="radio" name='goodlist-{{$index}}-4' value="4" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-4" style="margin-top: 6px;">横向滑动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 车源列表配置 -->
                        <div class="good-set" ng-if="component.type=='carlist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='carlist-{{$index}}-1' type="radio" name='carlist-{{$index}}-1' value="1" ng-model="component.carStyle"/>
                                    <label for="carlist-{{$index}}-1">小图</label>
                                    <input id='carlist-{{$index}}-2' type="radio" name='carlist-{{$index}}-1' value="2" ng-model="component.carStyle"/>
                                    <label for="carlist-{{$index}}-2">详细列表</label>

                                    <input id='carlist-{{$index}}-4' type="radio" name='carlist-{{$index}}-1' value="4" ng-model="component.carStyle"/>
                                    <label for="carlist-{{$index}}-4" style="margin-top: 6px;">横向滑动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 知识付费课程列表配置 -->
                        <div class="good-set" ng-if="component.type=='courselist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-2">详细列表</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">大图</label>
                                    <input id='goodlist-{{$index}}-4' type="radio" name='goodlist-{{$index}}-1' value="4" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-4" style="margin-top: 6px;">横向滑动</label>
                                    <input id='goodlist-{{$index}}-5' type="radio" name='goodlist-{{$index}}-1' value="5" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-5" style="margin-top: 6px;">音频列表</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">标签底色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.background" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">标签文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">加购按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.cartBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>-->
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 培训课程列表配置 -->
                        <div class="good-set" ng-if="component.type=='lessonlist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-2">小图</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">大图</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <!--
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">标签底色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.background" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">标签文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            -->
                            <!--<div class="input-group-box">
                                <label class="label-name">加购按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.cartBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>-->
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 经典语录列表配置 -->
                        <div class="good-set" ng-if="component.type=='quotationList'">
                            <div class="input-group-box">
                                <label class="label-name">字体颜色：</label>
                                <spectrum-colorpicker ng-model="component.fontStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">字体大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.fontStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 分类商品配置 -->
                        <div class="good-set" ng-if="component.type=='cateGoods'">

                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-2">大图</label>

                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-3' value="3" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-3">滚动</label>
                                    <input id='goodlist-{{$index}}-4' type="radio" name='goodlist-{{$index}}-4' value="4" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-4">一行两个</label>
                                    <input id='goodlist-{{$index}}-5' type="radio" name='goodlist-{{$index}}-5' value="5" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-5">详细列表</label>
                                </div>
                            </div>

                            <div class="input-group-box">
                                <label class="label-name">分类选中颜色：</label>
                                <spectrum-colorpicker ng-model="component.cateStyle.selectedColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">商品标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">商品标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 分类列表配置 -->
                        <div class="good-set" ng-if="component.type=='catelist'">

                            <!--<div class="input-group-box">
                                <label class="label-name">是否顶部固定：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="topfixed-{{$index}}" type="checkbox" ng-model="component.fixed" checked="">
                                            <label class="tgl-btn" for="topfixed-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>-->

                            <div class="input-group-box">
                                <label class="label-name">字体颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.fontColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">字体大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <div class="good-set" ng-if="component.type=='activityList'">
                            <!--
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.styleType"/>
                                    <label for="goodlist-{{$index}}-2">大图</label>
                                </div>
                            </div>

                            <div class="input-group-box">
                                <label class="label-name">分类选中颜色：</label>
                                <spectrum-colorpicker ng-model="component.cateStyle.selectedColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            -->
                            <div class="input-group-box">
                                <label class="label-name">活动标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">活动标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 游戏列表配置 -->
                        <div class="good-set" ng-if="component.type=='gamelist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-1">小图</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-2">详细列表</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">列表平铺</label>
                                    <input id='goodlist-{{$index}}-4' type="radio" name='goodlist-{{$index}}-1' value="4" ng-model="component.goodStyle"/>
                                    <label for="goodlist-{{$index}}-4" style="margin-top: 6px;">横向滑动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">分类标签底色：</label>
                                <spectrum-colorpicker ng-model="component.cateStyle.background" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.goodStyle == 2">
                                <label class="label-name">分类标签文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.cateStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 图文列表 -->
                        <div class="pictxt-set" ng-if="component.type=='pictxt'">
                            <div class="input-group-box">
                                <label class="label-name">显示简介：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="briefshow-{{$index}}" type="checkbox" ng-model="component.isShowbrief" checked="">
                                            <label class="tgl-btn" for="briefshow-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='picstyle-{{$index}}-1' type="radio" name='picstyle-{{$index}}-1' value="1" ng-model="component.picStyle"/>
                                    <label for="picstyle-{{$index}}-1">单行滑动</label>
                                    <input id='picstyle-{{$index}}-2' type="radio" name='picstyle-{{$index}}-1' value="2" ng-model="component.picStyle"/>
                                    <label for="picstyle-{{$index}}-2">列表平铺</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.picStyle==1">
                                <label class="label-name">标题样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='titlestyle-{{$index}}-1' type="radio" name='titlestyle-{{$index}}-1' value="1" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-1">悬浮标题</label>
                                    <input id='titlestyle-{{$index}}-2' type="radio" name='titlestyle-{{$index}}-1' value="2" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-2">正常标题</label>
                                    <input id='titlestyle-{{$index}}-3' type="radio" name='titlestyle-{{$index}}-1' value="3" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-3" style="margin-top:6px;">无标题</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle==1||component.titleStyle==5">
                                <label class="label-name">文字位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='titlealign-{{$index}}-1' type="radio" name='titlealign-{{$index}}-1' value="left" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-1">居左</label>
                                    <input id='titlealign-{{$index}}-2' type="radio" name='titlealign-{{$index}}-1' value="center" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-2">居中</label>
                                    <input id='titlealign-{{$index}}-3' type="radio" name='titlealign-{{$index}}-1' value="right" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">单行个数：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='imgnum-{{$index}}-1' type="radio" name='imgnum-{{$index}}-1' value="1" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-1">1</label>
                                    <input id='imgnum-{{$index}}-2' type="radio" name='imgnum-{{$index}}-1' value="2" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-2">2</label>
                                    <input id='imgnum-{{$index}}-3' type="radio" name='imgnum-{{$index}}-1' value="3" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-3">3</label>
                                    <input id='imgnum-{{$index}}-4' type="radio" name='imgnum-{{$index}}-1' value="4" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-4">4</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleCss.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题字号<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleCss.fontSize">
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题行高<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleCss.lineHeight">
                            </div>
                            <div class="input-group-box" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">
                                <label class="label-name">简介颜色：</label>
                                <spectrum-colorpicker ng-model="component.briefFontcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 推荐列表 -->
                        <div class="pictxt-set" ng-if="component.type=='recommendList'">

                            <div class="input-group-box">
                                <label class="label-name">显示简介：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="briefshow-{{$index}}" type="checkbox" ng-model="component.isShowbrief" checked="">
                                            <label class="tgl-btn" for="briefshow-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='picstyle-{{$index}}-1' type="radio" name='picstyle-{{$index}}-1' value="1" ng-model="component.picStyle"/>
                                    <label for="picstyle-{{$index}}-1">单行滑动</label>
                                    <input id='picstyle-{{$index}}-2' type="radio" name='picstyle-{{$index}}-1' value="2" ng-model="component.picStyle"/>
                                    <label for="picstyle-{{$index}}-2">列表平铺</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.picStyle==1">
                                <label class="label-name">标题样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='titlestyle-{{$index}}-1' type="radio" name='titlestyle-{{$index}}-1' value="1" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-1">悬浮标题</label>
                                    <input id='titlestyle-{{$index}}-2' type="radio" name='titlestyle-{{$index}}-1' value="2" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-2">正常标题</label>
                                    <input id='titlestyle-{{$index}}-3' type="radio" name='titlestyle-{{$index}}-1' value="3" ng-model="component.titleStyle"/>
                                    <label for="titlestyle-{{$index}}-3" style="margin-top:6px;">无标题</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle==1||component.titleStyle==5">
                                <label class="label-name">文字位置：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='titlealign-{{$index}}-1' type="radio" name='titlealign-{{$index}}-1' value="left" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-1">居左</label>
                                    <input id='titlealign-{{$index}}-2' type="radio" name='titlealign-{{$index}}-1' value="center" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-2">居中</label>
                                    <input id='titlealign-{{$index}}-3' type="radio" name='titlealign-{{$index}}-1' value="right" ng-model="component.style.textAlign"/>
                                    <label for="titlealign-{{$index}}-3">居右</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">单行个数：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='imgnum-{{$index}}-1' type="radio" name='imgnum-{{$index}}-1' value="1" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-1">1</label>
                                    <input id='imgnum-{{$index}}-2' type="radio" name='imgnum-{{$index}}-1' value="2" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-2">2</label>
                                    <input id='imgnum-{{$index}}-3' type="radio" name='imgnum-{{$index}}-1' value="3" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-3">3</label>
                                    <input id='imgnum-{{$index}}-4' type="radio" name='imgnum-{{$index}}-1' value="4" ng-model="component.singleImgNum"/>
                                    <label for="imgnum-{{$index}}-4">4</label>
                                </div>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleCss.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题字号<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleCss.fontSize">
                            </div>
                            <div class="input-group-box" ng-if="component.titleStyle!=3">
                                <label class="label-name">标题行高<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleCss.lineHeight">
                            </div>
                            <div class="input-group-box" ng-if="(component.picStyle==1&&component.titleStyle==2&&component.isShowbrief)||(component.picStyle==2&&component.isShowbrief)">
                                <label class="label-name">简介颜色：</label>
                                <spectrum-colorpicker ng-model="component.briefFontcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">图片高度<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.imageStyle.height">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 广告位样式 -->
                        <div class="title-set" ng-if="component.type=='advertisement'">
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 餐饮活动样式 -->
                        <div class="title-set" ng-if="component.type=='mealactivity'">
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 店铺列表配置 -->
                        <div class="good-set" ng-if="component.type=='shoplist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-1">详细列表</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-2" style="margin-top: 6px;">大图</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-1' value="3" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">横向滑动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=33&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>
                            <div class="input-group-box" ng-if="component.shopStyle!=3">
                                <label class="label-name">标签字体颜色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.color"  options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-if="component.shopStyle!=3">
                                <label class="label-name">标签边框颜色：</label>
                                <spectrum-colorpicker ng-model="component.labelStyle.borderColor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <?php }?>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=33) {?>
                            <div class="input-group-box">
                                <label class="label-name">是否显示分类：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="isShowCate-{{$index}}" type="checkbox" ng-model="component.isShowCate" checked="">
                                            <label class="tgl-btn" for="isShowCate-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <?php }?>
                            <div class="input-group-box" ng-if="component.shopStyle!=3">
                                <label class="label-name">是否显示距离：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="isShowDistance-{{$index}}" type="checkbox" ng-model="component.isShowDistance" checked="">
                                            <label class="tgl-btn" for="isShowDistance-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=33&&$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']!=6) {?>
                            <div class="input-group-box">
                                <label class="label-name">是否显示浏览量：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="isShowShowNum-{{$index}}" type="checkbox" ng-model="component.isShowShowNum" checked="">
                                            <label class="tgl-btn" for="isShowShowNum-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <?php }?>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 门店列表配置 -->
                        <div class="good-set" ng-if="component.type=='storelist'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='goodlist-{{$index}}-1' type="radio" name='goodlist-{{$index}}-1' value="1" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-1">详细列表</label>
                                    <input id='goodlist-{{$index}}-2' type="radio" name='goodlist-{{$index}}-1' value="2" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-2" style="margin-top: 6px;">大图</label>
                                    <input id='goodlist-{{$index}}-3' type="radio" name='goodlist-{{$index}}-1' value="3" ng-model="component.shopStyle"/>
                                    <label for="goodlist-{{$index}}-3" style="margin-top: 6px;">横向滑动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 酒店门店列表配置 -->
                        <div class="good-set" ng-if="component.type=='hotelstorelist'">
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 统计组件样式 -->
                        <div class="title-set" ng-if="component.type=='statistics'">
                            <div class="input-group-box">
                                <label class="label-name">文字颜色：</label>
                                <spectrum-colorpicker ng-model="component.style.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 优惠券列表配置 -->
                        <div class="good-set" ng-if="component.type=='coupon'">
                            <div class="input-group-box">
                                <label class="label-name">金额字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.valueStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">金额字颜色<span>(px)</span>：</label>
                                <spectrum-colorpicker ng-model="component.valueStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">门槛字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.limitStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">门槛字颜色<span>(px)</span>：</label>
                                <spectrum-colorpicker ng-model="component.limitStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">领取字颜色：</label>
                                <spectrum-colorpicker ng-model="component.receiveStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下内边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.paddingBottom">
                            </div>
                        </div>
                        <!-- 拼团列表配置 -->
                        <div class="good-set" ng-if="component.type=='group'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='grouplist-{{$index}}-1' type="radio" name='grouplist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="grouplist-{{$index}}-1">小图</label>
                                    <input id='grouplist-{{$index}}-2' type="radio" name='grouplist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="grouplist-{{$index}}-2">详细列表</label>
                                    <input id='grouplist-{{$index}}-3' type="radio" name='grouplist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="grouplist-{{$index}}-3" style="margin-top: 6px;">大图</label>

                                    <input id='grouplist-{{$index}}-4' type="radio" name='grouplist-{{$index}}-1' value="4" ng-model="component.goodStyle"/>
                                    <label for="grouplist-{{$index}}-4" style="margin-top: 6px;">横向滚动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">开团按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.openBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 秒杀列表配置 -->
                        <div class="good-set" ng-if="component.type=='seckill'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='seckilllist-{{$index}}-1' type="radio" name='seckilllist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="seckilllist-{{$index}}-1">小图</label>
                                    <input id='seckilllist-{{$index}}-2' type="radio" name='seckilllist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="seckilllist-{{$index}}-2">详细列表</label>
                                    <input id='seckilllist-{{$index}}-3' type="radio" name='seckilllist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="seckilllist-{{$index}}-3" style="margin-top: 6px;">大图</label>

                                     <input id='seckilllist-{{$index}}-4' type="radio" name='seckilllist-{{$index}}-1' value="4" ng-model="component.goodStyle"/>
                                    <label for="seckilllist-{{$index}}-4" style="margin-top: 6px;">横向滚动</label>
                                    <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
                                        <input id='seckilllist-{{$index}}-5' type="radio" name='seckilllist-{{$index}}-1' value="5" ng-model="component.goodStyle"/>
                                        <label for="seckilllist-{{$index}}-5" style="margin-top: 6px;">活动汇总</label>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-show="component.goodStyle!=5">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-show="component.goodStyle!=5">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">抢购按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.openBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box" ng-show="component.goodStyle==5">
                                <label class="label-name">选中背景底色：</label>
                                <spectrum-colorpicker ng-model="component.activeBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 砍价列表配置 -->
                        <div class="good-set" ng-if="component.type=='bargain'">
                            <div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='bargainlist-{{$index}}-1' type="radio" name='bargainlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-1">小图</label>
                                    <input id='bargainlist-{{$index}}-2' type="radio" name='bargainlist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-2">详细列表</label>
                                    <input id='bargainlist-{{$index}}-3' type="radio" name='bargainlist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-3" style="margin-top: 6px;">大图</label>

                                    <input id='bargainlist-{{$index}}-4' type="radio" name='bargainlist-{{$index}}-1' value="4" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-4" style="margin-top: 6px;">横向滚动</label>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">砍价按钮底色：</label>
                                <spectrum-colorpicker ng-model="component.openBgcolor" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                        <!-- 积分商品列表配置 -->
                        <div class="good-set" ng-if="component.type=='points'"><div class="input-group-box">
                                <label class="label-name">列表样式：</label>
                                <div class="controls" style="display: block;padding: 6px 0;">
                                    <input id='bargainlist-{{$index}}-1' type="radio" name='bargainlist-{{$index}}-1' value="1" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-1">小图</label>
                                    <input id='bargainlist-{{$index}}-2' type="radio" name='bargainlist-{{$index}}-1' value="2" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-2">详细列表</label>
                                    <!--<input id='bargainlist-{{$index}}-3' type="radio" name='bargainlist-{{$index}}-1' value="3" ng-model="component.goodStyle"/>
                                    <label for="bargainlist-{{$index}}-3" style="margin-top: 6px;">大图</label>-->
                                </div>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题颜色：</label>
                                <spectrum-colorpicker ng-model="component.titleStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">标题字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.titleStyle.fontSize">
                            </div>
                            <!--<div class="input-group-box">
                                <label class="label-name">价格颜色：</label>
                                <spectrum-colorpicker ng-model="component.priceStyle.color" options="colorOptions"></spectrum-colorpicker>
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格字大小<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.priceStyle.fontSize">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">价格是否加粗：</label>
                                <div class="right-info">
                                        <span class="tg-list-item">
                                            <input class="tgl tgl-light" id="pricebold-{{$index}}" type="checkbox" ng-model="component.priceBold" checked="">
                                            <label class="tgl-btn" for="pricebold-{{$index}}"></label>
                                        </span>
                                </div>
                            </div>-->
                            <div class="input-group-box">
                                <label class="label-name">上外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginTop">
                            </div>
                            <div class="input-group-box">
                                <label class="label-name">下外边距<span>(px)</span>：</label>
                                <input type="number" string-to-number min="0" class="cus-input" ng-model="component.style.marginBottom">
                            </div>
                        </div>
                    </div>
                    <div data-right-edit data-id="10086">

                    </div>
                    <div data-right-edit data-id="10010">

                    </div>
                </div>
                <div class="tab-con-item" data-type="set3">
                    <ul>
                        <li ng-repeat="template in templateList track by $index" style="width: 45%;display: inline-block;margin-right: 15px;margin-bottom: 15px;" ng-mouseover="template.show=true" ng-mouseleave="template.show=false">
                            <div class="temp-img" style="width: 100%; position: relative">
                                <img src="{{template.cover}}" alt="{{template.name}}" style="width: 100%">
                                <div ng-if="template.show" style="position: absolute;width: 100%;height: 100%; background-color: rgba(100, 100, 100, 0.3);top: 0;border: 2px solid #efbf1f;">
                                    <div style="position: absolute;top: 45%;width: 100%;text-align: center">
                                        <span style="padding: 5px 10px;margin: 4px;background: #5cb85c;border-radius: 4px;color: #fff;font-size: 12px;cursor: pointer;" ng-click="useTemplate($index)">选用</span>
                                        <span style="padding: 5px 10px;margin: 4px;background: red;border-radius: 4px;color: #fff;font-size: 12px;cursor: pointer;" ng-click="delTemplate($index)">删除</span>
                                    </div>
                                    <div style="position: absolute;bottom: 0;width: 100%;color: #fff;background-color: rgba(100, 100, 100, 0.7);text-align: center;padding: 4px 0;font-size: 13px;">{{template.name}}</div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</section>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    存储模板
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin: 20px 10px;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="line-height: 35px;">备注名称：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="请填写备注名称" id="temp-remark-name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #333 !important;">取消
                </button>
                <button type="button" class="btn btn-primary" ng-click="save2Template()">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script src="/public/wxapp/customtpl/js/jquery-1.11.3.min.js"></script>
<script src="/public/common/js/bootstrap-3.3.1.min.js"></script>
<script src="/public/wxapp/customtpl/plugin/layer/layer.js"></script>
<script src="/public/wxapp/customtpl/js/jquery-ui-1.9.2.min.js"></script>
<script src="/public/wxapp/customtpl/js/angular-1.4.6.min.js"></script>
<script src="/public/wxapp/customtpl/js/angular-root.js"></script>
<script src="/public/wxapp/customtpl/js/angular-route.min.js"></script>
<script src="/public/wxapp/customtpl/plugin/color-spectrum/spectrum.js"></script>
<script src="/public/wxapp/customtpl/plugin/color-spectrum/angular-spectrum-colorpicker.min.js"></script>
<script src="/public/wxapp/customtpl/js/sortable.js"></script>
<script src="/public/wxapp/customtpl/js/html2canvas.min.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>
    var imgNowsrc=0 ;
    var selectNowLink=0 ;
    var app = angular.module('custempApp', ['RootModule', "ui.sortable", 'angularSpectrumColorpicker']);
    app.controller('custempCtrl', ['$scope', '$http', '$timeout', function($scope, $http, $timeout) {
        $scope.colorOptions = {
            allowEmpty: true,
            showInput: true,
            allowEmpty: false,
            containerClassName: "full-spectrum",
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            showAlpha: true,
            maxPaletteSize: 7,
            cancelText: "取消",
            chooseText: "选择",
            preferredFormat: "hex",
            palette: [
                ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(132, 132, 132)", "rgb(153, 153, 153)","rgb(183, 183, 183)","rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(255, 255, 255)"],
                ["#7c0202","rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)", "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"],
                ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 　　　　"rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 　　　　"rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 　　　　"rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 　　　　"rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 　　　　"rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)", 　　　　"rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)", 　　　　"rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)","rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)","rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",
                    "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 　　　　"rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"
                ]
            ]
        };
        $scope.picwidth = {
            1: 1,
            2: 0.6,
            3: 0.4,
            4: 0.3
        };
        $scope.editTemplateId       = 0;
        $scope.pages                =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
;
        console.log($scope.pages);
        $scope.headerTitle          = '<?php echo $_smarty_tpl->tpl_vars['headerTitle']->value;?>
'?'<?php echo $_smarty_tpl->tpl_vars['headerTitle']->value;?>
':'自定义模板';
        $scope.showpostlist         = <?php echo $_smarty_tpl->tpl_vars['showpostlist']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['showpostlist']->value;?>
:false;
        $scope.showpostbtn          = <?php echo $_smarty_tpl->tpl_vars['showpostbtn']->value;?>
?<?php echo $_smarty_tpl->tpl_vars['showpostbtn']->value;?>
:false;
        $scope.pagebgColor          = '<?php echo $_smarty_tpl->tpl_vars['pagebgColor']->value;?>
'?'<?php echo $_smarty_tpl->tpl_vars['pagebgColor']->value;?>
':'#f3f4f5';
        $scope.linkTypes            = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkTypesNew         = <?php echo $_smarty_tpl->tpl_vars['linkTypeNew']->value;?>
;
        $scope.linkList             = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.information          = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.kindSelect           = <?php echo $_smarty_tpl->tpl_vars['kindSelect']->value;?>
;
        console.log('kindselect');
        console.log($scope.kindSelect);
        $scope.firstKindSelect      = <?php echo $_smarty_tpl->tpl_vars['firstKindSelect']->value;?>
;
        $scope.oneKindSelect        = <?php echo $_smarty_tpl->tpl_vars['oneKindSelect']->value;?>
;
        $scope.goodsList            = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.category             = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.expertCategory       = <?php echo $_smarty_tpl->tpl_vars['expertCategory']->value;?>
;
        $scope.reservationCategory  = <?php echo $_smarty_tpl->tpl_vars['reservationCategory']->value;?>
;
        $scope.expertList           = <?php echo $_smarty_tpl->tpl_vars['expertList']->value;?>
;
        $scope.shopCategory         = <?php echo $_smarty_tpl->tpl_vars['shopGoodsGroup']->value;?>
;
        $scope.noticeTxt            = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.serviceArticles      =  <?php echo $_smarty_tpl->tpl_vars['serviceArticle']->value;?>
;
        $scope.categoryList         =  <?php echo $_smarty_tpl->tpl_vars['categoryList']->value;?>
;
        $scope.groupList            = <?php echo $_smarty_tpl->tpl_vars['groupList']->value;?>
;
        $scope.limitList            = <?php echo $_smarty_tpl->tpl_vars['limitList']->value;?>
;
        $scope.bargainList          = <?php echo $_smarty_tpl->tpl_vars['bargainList']->value;?>
;
        $scope.allKindSelect        = <?php echo $_smarty_tpl->tpl_vars['allKindSelect']->value;?>
;
        $scope.informationCategory  = <?php echo $_smarty_tpl->tpl_vars['informationCategory']->value;?>
;
        $scope.recommendTypeList    = <?php echo $_smarty_tpl->tpl_vars['recommendTypeList']->value;?>
;
        $scope.mealActivityList     = <?php echo $_smarty_tpl->tpl_vars['mealActivityList']->value;?>
;

        // 独立商城分类
        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==27) {?>
        $scope.independence_kindSelect           = <?php echo $_smarty_tpl->tpl_vars['independence_kindSelect']->value;?>
;
        $scope.independence_firstKindSelect      = <?php echo $_smarty_tpl->tpl_vars['independence_firstKindSelect']->value;?>
;
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32) {?>
        $scope.goodsActivityList=<?php echo $_smarty_tpl->tpl_vars['goodsActivityList']->value;?>
;
        <?php }?>
        //console.log('类型类型类型'+<?php echo $_smarty_tpl->tpl_vars['ac_type_aaa']->value;?>
);

        $scope.goodSourceType       = <?php echo $_smarty_tpl->tpl_vars['goodSourceType']->value;?>
;
        $scope.shoplist             = <?php echo $_smarty_tpl->tpl_vars['shoplist']->value;?>
;
        $scope.storelist            = <?php echo $_smarty_tpl->tpl_vars['storelist']->value;?>
;
        $scope.shopKindSelect       = <?php echo $_smarty_tpl->tpl_vars['shopKindSelect']->value;?>
;
        $scope.browseNum            = '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_browse_num'];?>
';
        $scope.issueNum             = '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_issue_num'];?>
';
        $scope.shopNum              = '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_shop_num'];?>
';
        $scope.addMemberNum         = '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_add_member'];?>
';
        $scope.statIcon             = '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_stat_icon'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['community']->value['aci_stat_icon'];?>
' : '/public/wxapp/customtpl/images/icon_tj.png';
        $scope.jumpList             = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.gameCategory         = <?php echo $_smarty_tpl->tpl_vars['gameCategory']->value;?>
;
        $scope.gameList             = <?php echo $_smarty_tpl->tpl_vars['gameList']->value;?>
;
        $scope.templateList         = <?php echo $_smarty_tpl->tpl_vars['templateList']->value;?>
;
        $scope.tabList              = <?php echo $_smarty_tpl->tpl_vars['tabList']->value;?>
;
        $scope.carList              = <?php echo $_smarty_tpl->tpl_vars['carList']->value;?>
;
        $scope.carShopKindList      = <?php echo $_smarty_tpl->tpl_vars['carShopKindList']->value;?>
;
        $scope.postType             = <?php echo $_smarty_tpl->tpl_vars['tpl']->value['aci_post_type'];?>
;
        $scope.carCfg               = <?php echo $_smarty_tpl->tpl_vars['carCfg']->value['acc_index_tab'];?>
;
        $scope.quotaList            = <?php echo $_smarty_tpl->tpl_vars['quotaList']->value;?>
;
        console.log($scope.carCfg);
        $scope.fenleiNavsType       = [{type:'1',name:'帖子'},{type:'2',name:'快递助手'},{type:'3',name:'列表'},{type:'4',name:'资讯详情'},{type:'104',name:'菜单'},{type:'106',name:'小程序'},{type:'32',name:'资讯分类'},{type:'34',name:'店铺分类'},{type:'55',name:'自定义表单'},{type:'20',name:'店铺详情'},{type:'42',name:'商家商品分组'},{type:'5',name:'商品详情'},{type:'101',name:'客服'},{type:'102',name:'电话'},{type:'105',name:'签到'}];
        $scope.mealType             = <?php echo $_smarty_tpl->tpl_vars['mealType']->value;?>
;
        $scope.shopInfo             = <?php echo $_smarty_tpl->tpl_vars['shopInfo']->value;?>
;
        $scope.appointmentGoodsList = <?php echo $_smarty_tpl->tpl_vars['appointmentGoodsList']->value;?>
;
        $scope.knowpayType          = [{id:'1', name:'图文分类列表'},{id:'2', name:'音频分类列表'},{id:'3', name:'视频分类列表'}];
        $scope.positionType         = <?php echo $_smarty_tpl->tpl_vars['jobTpl']->value['aji_position_type'];?>
;
        $scope.jobSortType          = [{'type':'recommend','title':'浏览量排序'},{'type':'new','title':'发布时间排序'},{'type':'nearby','title':'距离排序'},{'type':'fat','title':'薪资排序'}, {'type':'award','title':'内推职位'}];
        $scope.jobInfo              = <?php echo $_smarty_tpl->tpl_vars['jobInfo']->value;?>
;
        $scope.hotelInfo            = <?php echo $_smarty_tpl->tpl_vars['hotelInfo']->value;?>
;
        $scope.positionList         = <?php echo $_smarty_tpl->tpl_vars['positionList']->value;?>
;
        $scope.companySelect        = <?php echo $_smarty_tpl->tpl_vars['companySelect']->value;?>
;
        $scope.courseList           = <?php echo $_smarty_tpl->tpl_vars['courseList']->value;?>
;

        $scope.formlist             = <?php echo $_smarty_tpl->tpl_vars['formlist']->value;?>
;
        $scope.articleCoverType     = "<?php echo $_smarty_tpl->tpl_vars['articleCoverType']->value;?>
";
        $scope.audioCoverType       = "<?php echo $_smarty_tpl->tpl_vars['audioCoverType']->value;?>
";
        $scope.videoCoverType       = "<?php echo $_smarty_tpl->tpl_vars['videoCoverType']->value;?>
";
        $scope.lessonType           = <?php echo $_smarty_tpl->tpl_vars['lessonType']->value;?>
;
        $scope.limitGoodsGroup      = <?php echo $_smarty_tpl->tpl_vars['limitGoodsGroup']->value;?>

        $scope.menuList      = <?php echo $_smarty_tpl->tpl_vars['menuList']->value;?>

        //基础组件
        var componentData = <?php echo $_smarty_tpl->tpl_vars['baseComponent']->value;?>
;
        var cityCategory = <?php echo $_smarty_tpl->tpl_vars['cityCategory']->value;?>
;
        <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
        componentData[2]['flitems'] =cityCategory;
        <?php }?>
        //营销组件
        var marketComponent = <?php echo $_smarty_tpl->tpl_vars['marketComponent']->value;?>


        $scope.showComponentData = <?php echo $_smarty_tpl->tpl_vars['template']->value;?>
;
        console.log($scope.showComponentData);
        $scope.draggables = componentData.map(function(x) {
            return [x];
        });
        $scope.marketDraggables = marketComponent.map(function(x) {
            return [x];
        });
        $scope.addComponent = function(event) {
            var curData = JSON.parse(event.currentTarget.dataset.compondata);
            $scope.showComponentData.push(curData);
            console.log($scope.showComponentData);
        };
        $scope.delComponent = function(delIndex) {
            console.log(delIndex);
            //询问框
            var layerIndex = layer.confirm('您确定删除该组件吗？', {
                title: '提示',
                btn: ['确定', '取消'] //按钮
            }, function() {
                console.log("删除成功");
                $scope.showComponentData.splice(delIndex, 1);
                $scope.$apply();
                layer.close(layerIndex);
            }, function() {
                console.log("取消删除");
            });
        };
        $scope.delItem = function(event, secondIndex,itemtype) { //删除幻灯
            var firstIndex = $(event.target).parents("[data-right-edit]").data('id');
            console.log("一级索引----" + firstIndex + "二级索引------" + secondIndex);
            //询问框
            var layerIndex = layer.confirm('您确定删除吗？', {
                title: '提示',
                btn: ['确定', '取消'] //按钮
            }, function() {
                console.log("删除成功");
                $scope.showComponentData[firstIndex][itemtype].splice(secondIndex, 1);
                $scope.$apply();
                layer.close(layerIndex);
                console.log($scope.showComponentData[firstIndex]);
            }, function() {
                console.log("取消删除");
            });
        };
        $scope.addSlide = function(event, firstIndex) { //添加幻灯
            var firstIndex = $(event.target).parents("[data-right-edit]").data('id');
            console.log("一级索引----" + firstIndex);
            var slideLength = $scope.showComponentData[firstIndex].slideimgs;
            var defaultSlide = {
                "img" : "/public/wxapp/customtpl/images/bannerzw_750_400.jpg",
                "link": ""
            }
            if (slideLength >= 8) {
                layer.msg("最多只能添加8个幻灯哦~")
            } else {
                $scope.showComponentData[firstIndex].slideimgs.push(defaultSlide);
            }
            console.log($scope.showComponentData[firstIndex]);
        }
        $scope.addFenlei = function(event, firstIndex) { //添加幻灯
            var firstIndex = $(event.target).parents("[data-right-edit]").data('id');
            console.log("一级索引----" + firstIndex);
            var slideLength = $scope.showComponentData[firstIndex].flitems;
            var defaultSlide = {
                "icon" : "/public/wxapp/customtpl/images/bannerzw_750_400.jpg",
                "name" :"默认标题",
                "brief":"内容简介",
                "link" : ""
            }
            $scope.showComponentData[firstIndex].flitems.push(defaultSlide);
            var fenleiLength = parseInt($scope.showComponentData[firstIndex].flitems.length);
            var navNumber = parseInt($scope.showComponentData[firstIndex].navNumber*2);
            fenleiLength = Math.ceil(fenleiLength/navNumber);
            var navpages = [];
            for(var i=0;i<fenleiLength;i++){
                navpages.push(i);
            }
            $scope.showComponentData[firstIndex].navpages = navpages;
            console.log($scope.showComponentData[firstIndex]);
        }
        $scope.addNotice = function(event, firstIndex) { //添加幻灯
            var firstIndex = $(event.target).parents("[data-right-edit]").data('id');
            console.log("一级索引----" + firstIndex);
            var defaultNotice = {
                "text" : "通知标题文字",
                "link": ""
            }
            $scope.showComponentData[firstIndex].noticeTxt.push(defaultNotice);
            console.log($scope.showComponentData[firstIndex]);
        }
        $scope.addPic = function(event, firstIndex) { //添加幻灯
            var firstIndex = $(event.target).parents("[data-right-edit]").data('id');
            console.log("一级索引----" + firstIndex);
            var picLength = $scope.showComponentData[firstIndex].picData;
            var defaultPic = {
                'title':'默认标题',
                'cover':'/public/wxapp/customtpl/images/goodsView4.jpg',
                'brief': '默认简介',
                'linkType':'',
                'linkUrl':''
            }
            $scope.showComponentData[firstIndex].picData.push(defaultPic);
            console.log($scope.showComponentData[firstIndex]);
        };

        $scope.addTabList = function(){
            var tab_length = $scope.tabList.length;
            var defaultIndex = 0;
            if(tab_length>0){
                for (var i=0;i<tab_length;i++){
                    if(defaultIndex < $scope.tabList[i].index){
                        defaultIndex = $scope.tabList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(tab_length>=4){
                layer.msg("最多只能添加4个自定义链接")
            }else{
                var tab_Default = {
                    index: defaultIndex,
                    link : '',
                    linkName : '',
                    type : '1',
                    name: '默认标题',
                };
                $scope.tabList.push(tab_Default);
                // $timeout(function(){
                //     //卸载掉原来的事件
                //     $(".cropper-box").unbind();
                //     new $.CropAvatar($("#crop-avatar"));
                // },500);
            }
            console.log($scope.tabList);
        };

        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };

        /*删除元素*/
        $scope.delRealIndex=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }


            console.log(type+"-->"+realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if(parentType){
                    $scope.$apply(function(){
                        $scope[parentType][type].splice(realIndex,1);
                    });
                }else{
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                }
                layer.msg('删除成功');
            });
            console.log($scope.appointInfo);
        }

        $scope.draggableOptions = {
            connectWith: ".connect-receive-component",
            revert: false,
            cursor: "move",
            scroll: true,
            cursorAt: { top: 35, left: 35 },
            placeholder: "ui-state-highlight",
            start: function(e, ui) {
                ui.placeholder.text("拖放到这里")
            },
            forceHelperSize: true,
            helper: function(event, ui) {
                return $("<div class='drag-widget' style='height:100px;width:100px;'><span class='icon-container'><i class='icon iconfont icon-" + ui.context.dataset.icon + "'></i></span><label>" + ui.context.dataset.text + "</label></div>");
            },

            change: function() {
                $('.widget').css('display', 'block');
            },
            remove: function(e, ui) {
                console.log("移出组件成功");
                // var dataset = ui.item.sortable.source.context.dataset;
                // var draggables = JSON.parse(dataset.draggables);
                // $scope.draggables = draggables;
                var model = angular.copy(ui.item.sortable.model);
                ui.item.sortable.sourceModel.push(model);
                console.log($scope.draggables);
                console.log(ui.item.sortable.model);

            },
            stop: function(e, ui) {

            }
        };
        $scope.sortableOptions = {
            placeholder: "ui-state-highlight",
            handle:".drag-handle",
            start: function(e, ui) {
                ui.placeholder.text("拖放到这里")
            },
            receive: function(e, ui) {
                console.log("接收元素");
                console.log(ui);

            },
            stop: function() {

                console.log($scope.showComponentData);
            }
        };


        $scope.doThis=function(type, index){
            type[index].img = imgNowsrc;
        };

        $scope.doPicThis=function(type, index){
            type[index].cover = imgNowsrc;
        };

        $scope.doNavThis=function(type, index){
            type[index].icon = imgNowsrc;
        };
        $scope.doLogoThis=function(type){
            type.companyLogo = imgNowsrc;
        };
        $scope.doStatIconThis=function(){
            $scope.statIcon = imgNowsrc;
        };
        $scope.doJobStatIconThis=function(){
            $scope.jobInfo.statIcon = imgNowsrc;
        };
        $scope.doTitleBgThis=function (type) {
            type.titleBg = imgNowsrc;
        };
        $scope.doImageThis=function (type) {
            type.imageUrl = imgNowsrc;
        };
        $scope.doWindowThis=function (type,index,lIndex) {
            console.log(lIndex);
            if(lIndex == 1){
                type.link1.imageUrl = imgNowsrc;
            }
            if(lIndex == 2){
                type.link2.imageUrl = imgNowsrc;
            }
            if(lIndex == 3){
                type.link3.imageUrl = imgNowsrc;
            }
            console.log(type);
        };

        $scope.changeChooseCommunityStyle=function (style) {
            if(style == 2){
                $('.choose-community-style').show();
            }else{
                $('.choose-community-style').hide();
            }
        };

        $scope.doVideoThis=function (type) {
            type.videocover = imgNowsrc;
        };
        $scope.doGoodsSelect=function(model, type){
            model[type] = selectNowLink;
            console.log(model[type]);
        };
        $scope.clearGoodsValue = function (model, type1, type2) {
            model[type1] = '';
            model[type2] = '';
        };
        $scope.changeNav1=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav1HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav2=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav2HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav3=function(){
            if(imgNowsrc){
                $scope.shopInfo.nav3HeadImg = imgNowsrc;
            }
        };
        //选用模板
        $scope.useTemplate = function(index){
            $scope.showComponentData = JSON.parse($scope.templateList[index].data);
            $scope.editTemplateId = $scope.templateList[index].id;
            $scope.headerTitle = $scope.templateList[index].title;
            $scope.pagebgColor = $scope.templateList[index].bgColor;
        }
        //删除模板
        $scope.delTemplate = function(delIndex){
            layer.confirm('确定要删除吗？', {
                title:false,
                closeBtn:0,
                btn: ['确定','取消'] //按钮
            }, function(){
                var data = {
                    'id'	: $scope.templateList[delIndex].id
                };
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/customtpl/delTemplate',
                    'data'  : data,
                    'dataType' : 'json',
                    success : function(ret){
                        $scope.templateList.splice(delIndex, 1);
                        layer.close(index);
                        layer.msg(ret.em);
                    }
                });
            });

        }

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'data' : JSON.stringify($scope.showComponentData),
                'editTemplateId' : $scope.editTemplateId,
                'headerTitle'    : $scope.headerTitle,
                'postType'       : $scope.postType,
                'showpostlist'   : $scope.showpostlist,
                'showpostbtn'    : $scope.showpostbtn,
                'pagebgColor'    : $scope.pagebgColor,
                'browseNum'      : $scope.browseNum,
                'issueNum'       : $scope.issueNum,
                'statIcon'       : $scope.statIcon,
                'shopNum'        : $scope.shopNum,
                'addMemberNum'   : $scope.addMemberNum,
                'mealType'       : $scope.mealType,
                'shopInfo'       : $scope.shopInfo,
                'hotelInfo'      : $scope.hotelInfo,
                'tabList'        : $scope.tabList,
                'carCfg'         : $scope.carCfg,
                'articleCoverType' : $scope.articleCoverType,
                'audioCoverType'   : $scope.audioCoverType,
                'videoCoverType'   : $scope.videoCoverType,
                'jobInfo'          : $scope.jobInfo,
                'positionType'     : $scope.positionType,
            };
            console.log(data);
            if(!$scope.editTemplateId){
                $http({
                    method: 'POST',
                    url:    '/wxapp/customtpl/saveSetting',
                    data:   data
                }).then(function(response) {
                    layer.close(index);
                    layer.msg(response.data.em);
                });
            }else{
                html2canvas(document.getElementById('pageBox')).then(function(canvas) {
                    data['image'] = canvas.toDataURL("image/png");
                    $http({
                        method: 'POST',
                        url:    '/wxapp/customtpl/saveSetting',
                        data:   data
                    }).then(function(response) {
                        layer.close(index);
                        layer.msg(response.data.em);
                    });
                });
            }

        };

        $scope.saveDataAndPreview = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'data' : JSON.stringify($scope.showComponentData),
                'editTemplateId' : $scope.editTemplateId,
                'headerTitle'    : $scope.headerTitle,
                'postType'       : $scope.postType,
                'showpostlist'   : $scope.showpostlist,
                'showpostbtn'    : $scope.showpostbtn,
                'pagebgColor'    : $scope.pagebgColor,
                'browseNum'      : $scope.browseNum,
                'issueNum'       : $scope.issueNum,
                'statIcon'       : $scope.statIcon,
                'shopNum'        : $scope.shopNum,
                'addMemberNum'   : $scope.addMemberNum,
                'mealType'       : $scope.mealType,
                'shopInfo'       : $scope.shopInfo,
                'hotelInfo'      : $scope.hotelInfo,
                'tabList'        : $scope.tabList,
                'carCfg'         : $scope.carCfg,
                'articleCoverType' : $scope.articleCoverType,
                'audioCoverType'   : $scope.audioCoverType,
                'videoCoverType'   : $scope.videoCoverType,
                'jobInfo'          : $scope.jobInfo,
                'positionType'     : $scope.positionType,
            };
            console.log(data);
            if(!$scope.editTemplateId){
                $http({
                    method: 'POST',
                    url:    '/wxapp/customtpl/saveSetting',
                    data:   data
                }).then(function(response) {
                    layer.close(index);
                    layer.msg(response.data.em,{time:1500},function(){
                        window.location.href='/wxapp/setup/code';
                    });

                });
            }else{
                html2canvas(document.getElementById('pageBox')).then(function(canvas) {
                    data['image'] = canvas.toDataURL("image/png");
                    $http({
                        method: 'POST',
                        url:    '/wxapp/customtpl/saveSetting',
                        data:   data
                    }).then(function(response) {
                        layer.close(index);
                        layer.msg(response.data.em,{time:1500},function(){
                            window.location.href='/wxapp/setup/code';
                        });
                    });
                });
            }

        };

        // 存储为模板
        $scope.save2Template = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            html2canvas(document.getElementById('pageBox')).then(function(canvas) {
                var data = {
                    'data' : JSON.stringify($scope.showComponentData),
                    'headerTitle' : $scope.headerTitle,
                    'showpostlist' : $scope.showpostlist,
                    'showpostbtn' : $scope.showpostbtn,
                    'pagebgColor' : $scope.pagebgColor,
                    'image' : canvas.toDataURL("image/png"),
                    'name': $('#temp-remark-name').val()
                };
                console.log(data);
                $http({
                    method: 'POST',
                    url:    '/wxapp/customtpl/save2Template',
                    data:   data
                }).then(function(response) {
                    layer.close(index);
                    layer.msg(response.data.em);
                    jQuery('#myModal').modal('hide');
                });
            });
        };
        // 启用模板
        $scope.apply = function(){
            var data = {
                'id'	: 0
            };
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/customtpl/startAppletTpl',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        };
        //返回
        $scope.goBack = function () {
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==1||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==21) {?>
                window.location.href = "/wxapp/mall/mallTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==12) {?>
                window.location.href = "/wxapp/train/trainTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==13) {?>
                window.location.href = "/wxapp/cake/cakeTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==3) {?>
                window.location.href = "/wxapp/shop/shopTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==8) {?>
                window.location.href = "/wxapp/community/communityTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==6) {?>
                window.location.href = "/wxapp/city/cityTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==18) {?>
                window.location.href = "/wxapp/reservation/allTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==30) {?>
                window.location.href = "/wxapp/gamebox/gamboxTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==4) {?>
                window.location.href = "/wxapp/meal/mealTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==7) {?>
                window.location.href = "/wxapp/hotel/hotelTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==27) {?>
            window.location.href = "/wxapp/knowledgepay/knowpayTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==28) {?>
                window.location.href = "/wxapp/job/jobTemplate";
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==32||$_smarty_tpl->tpl_vars['appletCfg']->value['ac_type']==36) {?>
            window.location.href = "/wxapp/sequence/sequenceTemplate";
            <?php }?>
        }

        $(function(){

            //高德地图引入
            var marker, geocoder,map = new AMap.Map('container',{
                zoom            : 11,
                keyboardEnable  : true,
                resizeEnable    : true,
                topWhenClick    : true
            });
            //添加地图控件
            AMap.plugin(['AMap.ToolBar'],function(){
                var toolBar = new AMap.ToolBar();
                map.addControl(toolBar);
            });
            //首次进入默认选择位置
            addMarker($scope.shopInfo.longitude,$scope.shopInfo.latitude,$scope.shopInfo.address);

            //地图添加点击事件
            map.on('click', function(e) {
                $('#lng').val(e.lnglat.getLng());
                $('#lat').val(e.lnglat.getLat());
                //添加地图服务
                AMap.service('AMap.Geocoder',function(){
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        city: "010"//城市，默认：“全国”
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //逆地理编码
                    var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                    geocoder.getAddress(lnglatXY, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
                            addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);
                        }else{
                            //获取地址失败
                        }
                    });
                });
            });
            //搜索地图位置
            $('.btn-map-search').on('click',function(){
                var addr     = $('#addr').val();
                if($scope.shopInfo.address){
                    console.log($scope.shopInfo.address);
                    AMap.service('AMap.Geocoder',function(){ //回调函数
                        //实例化Geocoder
                        geocoder = new AMap.Geocoder({
                            'city'   : '全国', //城市，默认：“全国”
                            'radius' : 1000   //范围，默认：500
                        });
                        //TODO: 使用geocoder 对象完成相关功能
                        //地理编码,返回地理编码结果
                        geocoder.getLocation($scope.shopInfo.address, function(status, result) {
                            console.log(result);
                            if (status === 'complete' && result.info === 'OK') {
                                var loc_lng_lat = result.geocodes[0].location;
                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),$scope.shopInfo.address);
                            }else{
                                layer.msg('您输入的地址无法找到，请确认后再次输入');
                            }
                        });
                    });

                }else{
                    layer.msg('请填写详细地址');
                }
            });


            /**
             * 添加一个标签和一个结构体
             * @param lng
             * @param lat
             * @param address
             */
            function addMarker(lng,lat,address) {
                if (marker) {
                    marker.setMap();
                }
                marker = new AMap.Marker({
                    icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                    position: [lng,lat]
                });
                marker.setMap(map);

                infoWindow = new AMap.InfoWindow({
                    offset  : new AMap.Pixel(0,-30),
                    content : '您选中的位置：'+address
                });
                infoWindow.open(map, [lng,lat]);
                $('#details-address').val(address);
                $('#lng').val(lng);
                $('#lat').val(lat);
                $scope.shopInfo.address   = address;
                $scope.shopInfo.longitude = lng;
                $scope.shopInfo.latitude  = lat;
                console.log($scope.shopInfo.address);

            }
        });

    }])
    app.directive('setclick', function() {
        return {
            restrict: 'A',
            scope: false,
            link: function(scope, element, attrs) {
                attrs.$observe('id', function(val) {
                    element.bind('click', function() {
                        var id = val;
                        var index = val;
                        console.log(id);
                        element.parents('.page-show').find('[data-left-preview]').removeClass('curedit');
                        element.addClass('curedit');
                        $("[data-right-edit][data-id=" + id + "]").stop().show().siblings().stop().hide();
                        if(scope.showComponentData[index] && scope.showComponentData[index].type == 'address'){
                            var longitude = scope.showComponentData[index].address.longitude?scope.showComponentData[index].address.longitude:'113.72052';
                            var latitude = scope.showComponentData[index].address.latitude?scope.showComponentData[index].address.latitude:'34.77485';
                            var address = scope.showComponentData[index].address.addr?scope.showComponentData[index].address.addr:'郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室';
                            console.log(longitude, latitude, address);
                            //高德地图引入
                            var marker, geocoder,map = new AMap.Map('container'+index,{
                                zoom            : 11,
                                keyboardEnable  : true,
                                resizeEnable    : true,
                                topWhenClick    : true
                            });

                            //添加地图控件
                            AMap.plugin(['AMap.ToolBar'],function(){
                                var toolBar = new AMap.ToolBar();
                                map.addControl(toolBar);
                            });

                            //首次进入默认选择位置
                            addMarker(longitude,latitude,address);

                            //地图添加点击事件
                            map.on('click', function(e) {
                                $('#lng').val(e.lnglat.getLng());
                                $('#lat').val(e.lnglat.getLat());
                                //添加地图服务
                                AMap.service('AMap.Geocoder',function(){
                                    //实例化Geocoder
                                    geocoder = new AMap.Geocoder({
                                        city: "010"//城市，默认：“全国”
                                    });
                                    //TODO: 使用geocoder 对象完成相关功能
                                    //逆地理编码
                                    var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                                    geocoder.getAddress(lnglatXY, function(status, result) {
                                        console.log(result);
                                        if (status === 'complete' && result.info === 'OK') {
//                            //详细地址处理
//                            var township    =  result.regeocode.addressComponent.township;
//                            var street      =  result.regeocode.addressComponent.street;
//                            var streetNumber=  result.regeocode.addressComponent.streetNumber;
//                            var neighborhood=  result.regeocode.addressComponent.neighborhood;
//                            var adds = township + street + streetNumber + neighborhood;
//                            var pcz  = {
//                                'province'  : result.regeocode.addressComponent.province,
//                                'city'      : result.regeocode.addressComponent.city,
//                                'zone'      : result.regeocode.addressComponent.district,
//                                'town'      : adds
//                            };
                                            addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);
                                        }else{
                                            //获取地址失败
                                        }
                                    });
                                });
                            });
                            //搜索地图位置
                            $('.btn-map-search').on('click',function(){
                                var addr     = $('#addr').val();
                                if(scope.showComponentData[index].address.addr){
                                    AMap.service('AMap.Geocoder',function(){ //回调函数
                                        //实例化Geocoder
                                        geocoder = new AMap.Geocoder({
                                            'city'   : '全国', //城市，默认：“全国”
                                            'radius' : 1000   //范围，默认：500
                                        });
                                        //TODO: 使用geocoder 对象完成相关功能
                                        //地理编码,返回地理编码结果
                                        geocoder.getLocation(scope.showComponentData[index].address.addr, function(status, result) {
                                            console.log(result);
                                            if (status === 'complete' && result.info === 'OK') {
                                                var loc_lng_lat = result.geocodes[0].location;
                                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),scope.showComponentData[index].address.addr);
                                            }else{
                                                layer.msg('您输入的地址无法找到，请确认后再次输入');
                                            }
                                        });
                                    });

                                }else{
                                    layer.msg('请填写详细地址');
                                }
                            });


                            /**
                             * 添加一个标签和一个结构体
                             * @param lng
                             * @param lat
                             * @param address
                             */
                            function addMarker(lng,lat,address) {
                                if (marker) {
                                    marker.setMap();
                                }
                                marker = new AMap.Marker({
                                    icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                                    position: [lng,lat]
                                });
                                marker.setMap(map);

                                infoWindow = new AMap.InfoWindow({
                                    offset  : new AMap.Pixel(0,-30),
                                    content : '您选中的位置：'+address
                                });
                                infoWindow.open(map, [lng,lat]);
                                console.log(scope.showComponentData);
                                scope.showComponentData[index].address.addr   = address;
                                scope.showComponentData[index].address.longitude = lng;
                                scope.showComponentData[index].address.latitude  = lat;
                                $('#details-address'+index).val(address);
                                $('#lng'+index).val(lng);
                                $('#lat'+index).val(lat);
                                scope.$apply();
                                console.log(address);
                            }
                        }
                    });
                });
            }
        };
    });
    app.directive('stylesheet', function() {
        return {
            restrict: 'AE',
            scope: { data: '@style' },
            link: function(scope, element, attrs) {
                attrs.$observe('style', function(val) {
                    var style = JSON.parse(val);
                    for (var i in style) {
                        if(!isNaN(style[i])){
                        // if(typeof style[i]=='number'){
                            var isImage = $(element.context).hasClass('img-place');
                            var isButton = $(element.context).hasClass('cus-btn');
                            var isSpace = $(element.context).hasClass('space');
                            console.log(typeof attrs.class);
                            if(i=='width'&&!isImage&&!isButton&&!isSpace){
                                style[i] = style[i]+'%';
                            }else{
                                style[i] = style[i]+'px';
                            }
                        }
                        element.css(i, style[i]);
                    }
                })


            }
        };
    });
    app.directive('settypeclick', function() {
        return {
            restrict: 'A',
            scope: { data: '@type' },
            link: function(scope, element, attrs) {
                attrs.$observe('type', function(val) {
                    element.bind('click', function() {
                        var type = val;
                        console.log(type);
                        element.parents('.tab-title-wrap').find('.tab-title-item').removeClass('active');
                        element.addClass('active');
                        $(".tab-con-item[data-type=" + type + "]").stop().show().siblings().hide();
                    });
                });
            }
        };
    });
    app.directive('stringToNumber', function() {
        return {
            require: 'ngModel',
            link: function(scope, element, attrs, ngModel) {
                ngModel.$parsers.push(function(value) {
                    return '' + value;
                });
                ngModel.$formatters.push(function(value) {
                    return parseFloat(value, 10);
                });
            }
        };
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
    //选择完成, 绑定angularjs
    app.directive('selectchange', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('change', function () {
                    selectNowLink = $(element).val();
                    scope.$apply(attrs.selectchange);
                });
            }

        };
    });
    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }
    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../customtpl-img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../goods-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../information-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../coupon-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../group-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../seckill-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../bargain-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../points-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../shop-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../store-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate ("../car-select-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>

</body>

</html>
<?php }} ?>
