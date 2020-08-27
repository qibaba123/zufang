<?php /* Smarty version Smarty-3.1.17, created on 2020-04-02 16:30:23
         compiled from "/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/index-tpl_18.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18910894625e85a29f2ef0d0-79252902%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edfe042094c93bc7604ac350a7bbafa110e42030' => 
    array (
      0 => '/www/wwwroot/default/yingxiaosc/yingxiaosc/sites/app/view/template/wxapp/mall/index-tpl_18.tpl',
      1 => 1575621712,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18910894625e85a29f2ef0d0-79252902',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'tpl' => 0,
    'goodsList' => 0,
    'kindSelect' => 0,
    'firstKindSelect' => 0,
    'slide' => 0,
    'shortcut' => 0,
    'recommendGoods' => 0,
    'kindList' => 0,
    'goodsGroup' => 0,
    'linkType' => 0,
    'linkList' => 0,
    'jumpList' => 0,
    'groupList' => 0,
    'limitList' => 0,
    'bargainList' => 0,
    'appointmentGoodsList' => 0,
    'infocateList' => 0,
    'page_list' => 0,
    'information' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.17',
  'unifunc' => 'content_5e85a29f34a989_42309926',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5e85a29f34a989_42309926')) {function content_5e85a29f34a989_42309926($_smarty_tpl) {?><link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css?1">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<style>
.good-list-wrap .title-name { margin: 4px auto; background-color: #fff; text-align: center; padding: 10px 12px; }
.good-list-wrap .title-name p { position: relative; font-size: 15px; padding: 0 10px; text-align: center;}
.good-list-wrap .title-name p:before { content: ''; position: absolute; left: 50%; bottom: -5px; height: 3px; width: 40px; margin-left: -20px; background-color: #8EE1E0; top: auto; }
.good-list-wrap .good-list{padding: 0 4px;}
.good-list-wrap .good-view2 .good-item{padding: 4px;box-sizing: border-box;}
.good-list-wrap .good-view2 .item-wrap{padding: 0;}
.good-list-wrap .good-view2 .good-image {width: 100%;height: 150px;}
.good-list-wrap .good-view2 .good-title { text-align: left; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 2; height: 42px; line-height: 1.5; white-space: normal;margin-bottom: 5px}
.good-list-wrap .good-view2 .price-buy{text-align: left;}
.good-list-wrap .buy-btn { position: absolute; right: 8px; bottom: 8px; height: 30px; width: 30px; text-align: center; -webkit-border-radius: 15px; border-radius: 15px; background-color: #86D3D5; color: #fff; font-size: 13px; padding: 0;}
.good-list-wrap .buy-btn img { height: 18px; width: 18px; display: block; margin: 6px auto; }
.search-wrap { padding: 8px 12px; box-sizing: border-box;}
.search-container { border-radius: 25px; width: 96%; margin: 0 auto;padding: 5px 10px; box-sizing: border-box; background-color: #fff; text-align: center; }
.search-wrap img { height: 18px; width: 18px; display: inline-block; vertical-align: middle; margin-right: 5px; }
.search-wrap p { display: inline-block; vertical-align: middle; color: #333; font-size: 14px; }
.fenlei-nav ul { background-color: #fff; padding-top: 8px; white-space: normal; max-height: 172px; overflow: hidden; }
.recommend-manage{padding:15px;}
.recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto;margin:0 auto 8px;}
.recommend-manage .edit-txt{float: none;width: 100%}
.notice-box {
    height: 40px;
    margin-top: 5px;
}
.notice-box {
    padding: 0;
    background: #fff;
}
.notice-box {
    padding: 10px;
}
.notice-txt {
    font-size: 15px;
    line-height: 20px;
    overflow: hidden;
    height: 100%;
    padding-left:15px;
}
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">
                店铺主页
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div data-left-preview data-id="1">
                        <div class="banner-wrap">
                            <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                            <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                            <div class="paginations">
                                <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                            </div>
                        </div>
                        <div class="search-wrap">
                            <div class="search-container">
                                <img src="/public/wxapp/mall/temp3/images/ydhw-ss.png" />
                                <p>{{searchPlaceholder}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-data-tip" ng-if="fenleiNavs.length<=0">点此添加导航~</div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="7">
                        <div style="display: inline-block;font-size: {{fontSize}}px;color:{{color}};height: 100%;float:left;line-height: 20px;margin:0 2px;">{{noticeTitle}}</div>
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0" >最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>

                    <div class="hot-recommend" data-left-preview data-id="3">
                        <div class="title-name flex-wrap">
                            <p class="flex-con">{{recommendtitle}}</p>
                            <div class="more-enter">
                                查看全部
                                <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" />
                            </div>
                        </div>
                        <div class="recommend-img">
                            <div class="no-data-tip" ng-if="recommendGood.length<=0">点此添加推荐商品~</div>
                            <div class="img-item" ng-repeat="good in recommendGood">
                                <img ng-src="{{good.imgsrc}}" />
                            </div>
                        </div>
                        <!-- <div class="hot-title border-b">{{recommendtitle}}</div>
                        <div class="hot-goods flex-wrap">
                            <div class="left-good border-r">
                                <div class="left-good-title">{{recommendGood[0].name}}</div>
                                <div class="left-good-price">
                                    ￥<span>{{recommendGood[0].price}}</span>
                                </div>
                                <img ng-src="{{recommendGood[0].imgsrc}}" />
                            </div>
                            <div class="right-good">
                                <div class="right-good-item border-b">
                                    <div class="left-good-title">{{recommendGood[1].name}}</div>
                                    <div class="left-good-price">
                                        ￥<span>{{recommendGood[1].price}}</span>
                                    </div>
                                    <img ng-src="{{recommendGood[1].imgsrc}}" />
                                </div>
                                <div class="right-good-item">
                                    <div class="left-good-title">{{recommendGood[2].name}}</div>
                                    <div class="left-good-price">￥
                                        ￥<span>{{recommendGood[2].price}}</span>
                                    </div>
                                    <img ng-src="{{recommendGood[2].imgsrc}}" />
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="good-show-wrap" data-left-preview data-id="4">
                        <div class="good-list-wrap" ng-repeat="goodfl in goodFlShow">
                            <div class="title-name flex-wrap">
                                <p class="flex-con">{{goodfl.title}}</p>
                                <!-- <div class="more-enter">
                                    更多
                                    <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" />
                                </div> -->
                            </div>
                            <div class="good-list good-view2">
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView1.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">商品名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                            <div class="buy-btn">
                                                <img src="/public/wxapp/mall/temp3/images/icon_add_cart.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView2.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">商品名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                            <div class="buy-btn">
                                                <img src="/public/wxapp/mall/temp3/images/icon_add_cart.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView3.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">商品名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                            <div class="buy-btn">
                                                <img src="/public/wxapp/mall/temp3/images/icon_add_cart.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView4.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">商品名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                            <div class="buy-btn">
                                                <img src="/public/wxapp/mall/temp3/images/icon_add_cart.png" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*400px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px;">搜索文本：</label>
                    <input type="text" class="cus-input" placeholder="请输入搜索提示内容" maxlength="10" ng-model="searchPlaceholder">
                </div>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <!--
                    <div class="input-group-box">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.link" ng-options="x.id as x.name for x in goodsList"></select>
                    </div>
                    -->
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==4">
                        <label for="">分组详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==9">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="">商品详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==46">
                        <label for="">付费预约：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in appointmentGoodsList" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==23">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==29" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">秒杀商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in limitList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==30" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">拼团商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in groupList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==31" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 17%">砍价商品：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==32">
                        <label for="">资讯分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==106" style="margin-top: 10px;">
                        <label for="" style="display: inline-block;width: 16%">小 程 序：</label>
                        <select style="display: inline-block;width: 83%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==104">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" ng-model="banner.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航<span>(分类多于8个时手机端可横向滑动，管理界面不做展示)</span></label>
                <div ui-sortable="sortableOptions" ng-model="fenleiNavs">
                    <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                        <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                        <div class="edit-img">
                            <!--<div class="cropper-box" data-width="150" data-height="150" style="height:100%;">
                                <img ng-src="{{fenleiNav.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('fenleiNavs',fenleiNav.index)" alt="导航图标">
                                <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="fenleiNav.imgsrc"/>
                            </div>-->
                            <div>
                                <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="150" data-height="150" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                            </div>
                        </div>
                        <div class="edit-txt">
                            <div class="input-group-box clearfix">
                                <label for="">标　题：</label>
                                <input type="text" class="cus-input" maxlength="5" ng-value="fenleiNav.title" ng-model="fenleiNav.title">
                            </div>
                            <!--
                            <div class="input-group-box clearfix">
                                <label for="">链接到：</label>
                                <select class="cus-input" ng-model="fenleiNav.articleId" ng-options="x.id as x.name for x in category"></select>
                            </div>
                            -->
                            <div class="input-group-box clearfix">
                                <label for="">链接类型：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                                <label for="">资讯详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                                <label for="">列　　表：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                                <label for="">外　　链：</label>
                                <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==4">
                                <label for="">分组详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                                <label for="">分类详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                                <label for="">商品详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==46">
                                <label for="">付费预约：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in appointmentGoodsList" ></select>
                            </div>
                            <!-- 一级分类选择 -->
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==23">
                                <label for="">分类详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==29" style="margin-top: 10px;">
                                <label for="" style="display: inline-block;width: 23%">秒杀商品：</label>
                                <select style="display: inline-block;width: 77%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in limitList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==30" style="margin-top: 10px;">
                                <label for="" style="display: inline-block;width: 23%">拼团商品：</label>
                                <select style="display: inline-block;width: 77%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in groupList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==31" style="margin-top: 10px;">
                                <label for="" style="display: inline-block;width: 23%">砍价商品：</label>
                                <select style="display: inline-block;width: 77%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==32">
                                <label for="">资讯分类：</label>
                                <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==106" style="margin-top: 10px;">
                                <label for="" style="display: inline-block;width: 23%">小 程 序：</label>
                                <select style="display: inline-block;width: 77%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                            </div>
                            <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                                <label for="" class="label-name">菜　　单：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link" ng-options="x.path as x.name for x in pages"></select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="3">
                <label style="width: 100%">{{recommendtitle}}<span>(图片尺寸为400px*250px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px">标题名称：</label>
                    <input type="text" class="cus-input" ng-model="recommendtitle" maxlength="15">
                </div>
                <div class="fenleinav-manage recommend-manage" ng-repeat="good in recommendGood">
                    <div class="delete" ng-click="delIndex('recommendGood',good.index)">×</div>
                    <div class="edit-img" style="width: 50%">
                        <!--<div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{good.imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('recommendGood',good.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="good.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="400" data-height="250" imageonload="doThis('recommendGood',good.index)" data-dom-id="upload-good{{$index}}" id="upload-good{{$index}}"  ng-src="{{good.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="good{{$index}}"  class="avatar-field bg-img" name="good{{$index}}" ng-value="good.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">商品名称：</label>
                            <input type="text" class="cus-input"  ng-model="good.name">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">商品价格：</label>
                            <input type="text" class="cus-input"  ng-model="good.price">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="good.link" ng-options="x.id as x.name for x in goodsList"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addRecommendGood()"></div>
                <!-- <div class="fenleinav-manage">
                    <div class="edit-img">
                        <div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{recommendGood[1].imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('recommendGood',1)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="recommendGood[1].imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">商品名称：</label>
                            <input type="text" class="cus-input" ng-model="recommendGood[1].name">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">商品价格：</label>
                            <input type="text" class="cus-input" ng-model="recommendGood[1].price">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="recommendGood[1].link" ng-options="x.id as x.name for x in goodsList"></select>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="fenleinav-manage">
                    <div class="edit-img">
                        <div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{recommendGood[2].imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('recommendGood',2)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="recommendGood[2].imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">商品名称：</label>
                            <input type="text" class="cus-input" ng-model="recommendGood[2].name">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">商品价格：</label>
                            <input type="text" class="cus-input" ng-model="recommendGood[2].price">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="recommendGood[2].link" ng-options="x.id as x.name for x in goodsList"></select>
                        </div>
                    </div>
                </div> -->
            </div>
            <div class="fenleinav" data-right-edit data-id="4">
                <label style="width: 100%">分类商品展示管理</label>
                <div ui-sortable="sortableOptions" ng-model="goodFlShow">
                    <div class="fenleinav-manage" ng-repeat="goodfl in goodFlShow">
                        <div class="delete" ng-click="delIndex('goodFlShow',goodfl.index)">×</div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 70px">标题名称：</label>
                            <input type="text" class="cus-input" ng-model="goodfl.title" maxlength="15">
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 70px">商品分类：</label>
                            <select class="cus-input" ng-model="goodfl.link" ng-options="x.id as x.name for x in kindSelect"></select>
                        </div>
                        <div class="good-tip">注：将从您选择的分类中取出最多6个商品显示~</div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewGoodfl()"></div>
            </div>

            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="7">
                <label>最新公告</label>
                <div class="edit-con" style="margin-bottom: 4px;margin-top: 2px">
                    <div class="activity link-setting" style="display:block;">
                <span class='tg-list-item'>
						是否启用头条公告功能
                     <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus('<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_id'];?>
')" <?php if ($_smarty_tpl->tpl_vars['tpl']->value&&$_smarty_tpl->tpl_vars['tpl']->value['ami_notice_status']==1) {?>checked<?php }?> >
                     <label class='tgl-btn' for='audit_status'></label>
                </span>
                    </div>
                </div>
                <div class="fenleinav-manage">
                    <div class="input-group-box" style="margin-bottom: 20px;">
                        <label class="label-name">公告标题：</label>
                        <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="4" ng-model="noticeTitle">
                    </div>
                    <div class="input-group">
                        <div style="width: 100%;display: flex;margin-bottom: 30px;">
                            <label class="label-name">地址文字颜色：</label>
                            <div class="right-color">
                                <input type="text" class="color-input" data-colortype="selectedColor" ng-model="color">
                            </div>
                        </div>
                    </div>
                    <!--<div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;display: flex">
                            <label class="label-name" style="width: 140px">地址文字大小：</label>
                            <select class="cus-input" ng-model="fontSize" ng-options="x.id as x.name for x in sizes"></select>
                        </div>
                    </div>-->
                    <div class="service-manage">
                        <label  class="label-name" for="">头条内容取资讯内容,请在资讯功能位置添加</label>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/goodsCategory/js/jquery-ui-1.9.2.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/manage/goodsCategory/js/sortable.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule','ui.sortable']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.goodsList = <?php echo $_smarty_tpl->tpl_vars['goodsList']->value;?>
;
        $scope.kindSelect = <?php echo $_smarty_tpl->tpl_vars['kindSelect']->value;?>
;
        $scope.firstKindSelect = <?php echo $_smarty_tpl->tpl_vars['firstKindSelect']->value;?>
;
        $scope.headerTitle= "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_title'];?>
" ? "<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_title'];?>
" : "店铺首页" ;
        $scope.searchPlaceholder = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_search_tip'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_search_tip'];?>
' : '请输入关键字';
        $scope.banners = <?php echo $_smarty_tpl->tpl_vars['slide']->value;?>
;
        $scope.fenleiNavs = <?php echo $_smarty_tpl->tpl_vars['shortcut']->value;?>
;
        $scope.tpl_id		= '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_tpl_id'];?>
';
        $scope.recommendGood = <?php echo $_smarty_tpl->tpl_vars['recommendGoods']->value;?>
;
        $scope.recommendtitle = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_recommend_tip'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_recommend_tip'];?>
' : '热品推荐';
        $scope.goodFlShow = <?php echo $_smarty_tpl->tpl_vars['kindList']->value;?>
;
        $scope.category  = <?php echo $_smarty_tpl->tpl_vars['goodsGroup']->value;?>
;
        $scope.linkTypes = <?php echo $_smarty_tpl->tpl_vars['linkType']->value;?>
;
        $scope.linkList  = <?php echo $_smarty_tpl->tpl_vars['linkList']->value;?>
;
        $scope.jumpList = <?php echo $_smarty_tpl->tpl_vars['jumpList']->value;?>
;
        $scope.groupList = <?php echo $_smarty_tpl->tpl_vars['groupList']->value;?>
;
        $scope.limitList = <?php echo $_smarty_tpl->tpl_vars['limitList']->value;?>
;
        $scope.bargainList = <?php echo $_smarty_tpl->tpl_vars['bargainList']->value;?>
;
        $scope.appointmentGoodsList = <?php echo $_smarty_tpl->tpl_vars['appointmentGoodsList']->value;?>
;
        $scope.informationCategory = <?php echo $_smarty_tpl->tpl_vars['infocateList']->value;?>
;
        $scope.pages                =  <?php echo $_smarty_tpl->tpl_vars['page_list']->value;?>
;


        $scope.noticeTitle    = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_title'];?>
'?'<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_title'];?>
':'今日头条';
        $scope.noticeTxt      = <?php echo $_smarty_tpl->tpl_vars['information']->value;?>
;
        $scope.sizes          = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.color          = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_color'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_color'];?>
' : '#000000';
        $scope.fontSize       = '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_size'];?>
' ? '<?php echo $_smarty_tpl->tpl_vars['tpl']->value['ami_notice_size'];?>
' : '16';

        $scope.sortableOptions = {
            update: function(e, ui) {
                setTimeout(function () {
                    for(let i in $scope.goodFlShow){
                        $scope.goodFlShow[i].index = i;
                    }
                    for (let i in $scope.fenleiNavs) {
                        $scope.fenleiNavs[i].index = i;
                    }
                }, 500);

                console.log("拖动完成");
            },
            axis: 'y'
        };
        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(defaultIndex < $scope.fenleiNavs[i].index){
                        defaultIndex = $scope.fenleiNavs[i].index;
                    }
                }
                defaultIndex++;
            }
            if(fenleiNav_length>=16){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加16个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleId: $scope.category[0] ?$scope.category[0].id:'',
                    link : $scope.category[0]?$scope.category[0].id:'',
                    type : '4'
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.fenleiNavs);
        }
        /*添加新的轮播图*/
        $scope.addNewBanner = function(){
            var banner_length = $scope.banners.length;
            var defaultIndex = 0;
            if(banner_length>0){
                for (var i=0;i<banner_length;i++){
                    if(defaultIndex < $scope.banners[i].index){
                        defaultIndex = $scope.banners[i].index;
                    }
                }
                defaultIndex++;
            }
            if(banner_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8张广告图哦',
                    time: 2000
                });
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/wxapp/mall/temp3/images/banner_zhanwei.jpg',
                    articleId: $scope.goodsList[0] ? $scope.goodsList[0].id :'',
                    link : $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    type : '5'
                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.banners);
        };
        /*添加新的商品分类*/
        $scope.addNewGoodfl = function(){
            var goodfl_length = $scope.goodFlShow.length;
            var defaultIndex = 0;
            if(goodfl_length>0){
                for (var i=0;i<goodfl_length;i++){
                    if(defaultIndex < $scope.goodFlShow[i].index){
                        defaultIndex = $scope.goodFlShow[i].index;
                    }
                }
                defaultIndex++;
            }
            if(goodfl_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个商品分类哦',
                    time: 2000
                });
            }else{
                var goodfl_Default = {
                    index: defaultIndex,
                    title:'默认名称',
                    link: $scope.kindSelect[0]?$scope.kindSelect[0].id:''
                };
                $scope.goodFlShow.push(goodfl_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.goodFlShow);
        };
        /*添加新的商品分类*/
        $scope.addRecommendGood = function(){
            var good_length = $scope.recommendGood.length;
            var defaultIndex = 0;
            if(good_length>0){
                for (var i=0;i<good_length;i++){
                    if(defaultIndex < $scope.recommendGood[i].index){
                        defaultIndex = $scope.recommendGood[i].index;
                    }
                }
                defaultIndex++;
            }
            if(good_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个推荐哦',
                    time: 2000
                });
            }else{
                var good_Default = {
                    index: defaultIndex,
                    name:'推荐商品名称',
                    price:0,
                    imgsrc:'/public/manage/img/zhanwei/zw_fxb_400_250.png',
                    link: $scope.goodsList[0]?$scope.goodsList[0].id:''
                };
                $scope.recommendGood.push(good_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.recommendGood);
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

        /*删除元素*/
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            console.log(type+"-->"+realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if($scope[type].length>1){
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }else{
                    layer.msg('最少要留一个哦');
                }
            });
        };
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取图片的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopintrobg = imgNowsrc;
            }
        };
        $scope.initColor = function(obj,colorVal){
            obj.spectrum({
                color: colorVal,
                showButtons: false,
                showInitial: true,
                showPalette: true,
                showSelectionPalette: true,
                maxPaletteSize: 10,
                preferredFormat: "hex",
                move: function (color) {
                    var realColor = color.toHexString();
                    console.log(realColor);
                    $scope.$apply(function(){
                        $scope.color=realColor;
                        console.log($scope.color);
                    });
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        };
        $(function(){
            /*控制店铺图片宽高比*/
            // $(".shop-bg").height($(".shop-bg").width()*0.3175);
            initListShow()
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).data('id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
            });
            $("input.color-input").each(function(index, el) {
                var obj = $(this);
                var val = obj.val();
                console.log(val);
                $scope.initColor(obj,val);
            });
        });

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	    : $scope.headerTitle,
                'searchTip' 	: $scope.searchPlaceholder,
                'recommendTip'  : $scope.recommendtitle,
                'slide'		    : $scope.banners,
                'shortcut'	    : $scope.fenleiNavs,
                'tpl_id'	    : $scope.tpl_id,
                'recommendGood' : $scope.recommendGood,
                'kind'          : $scope.goodFlShow,
                'notice_title'     : $scope.noticeTitle,
                'notice_color'     : $scope.color,
                //'notice_size'      : $scope.fontSize
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/mall/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };
    }]);
    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    console.log(attrs.imageonload);
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });

    /*遍历添加对应列表展示样式*/
    function initListShow(){
        $('.edit-con').find(".showstyle-radio input[type=hidden]").each(function(index, el) {
            var styleVal = $(this).val();
            $(this).parents('.showstyle-radio').find('span').eq(styleVal-1).find('input[type=radio]').prop('checked','checked');
        });
        $(".index-main").find("input[type=hidden]").each(function(index, el) {
            var that = $(this);
            var styleVal = that.val();
            var styleDiv = $(this).parents(".hot-product").find(".goods-show>div");
            var curClass = styleDiv.attr("class");
            styleDiv.removeClass(curClass).addClass('goods-view'+styleVal);
        });
    }

    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
        console.log(imgNowsrc);

    }
    function changeAuditStatus(id) {
        var status = $('#audit_status').is(':checked');
        var data = {
            status : status ? 1 : 0,
            id     : id
        };
        console.log(data);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mall/changeNoticeStatus',
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
</script>
<?php echo $_smarty_tpl->getSubTemplate ("../img-upload-modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, null, array(), 0);?>
<?php }} ?>
