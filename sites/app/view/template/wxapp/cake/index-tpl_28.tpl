<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp4/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp4/css/style.css?3">
<style>
    .fenleinav-manage{
        padding: 10px;
        background-color: #fff;
        border: 1px solid #e8e8e8;
        margin-top: 10px;
    }
    .goods-part .good .text{
        line-height: 1.5;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis
    }
    .banner-manage{
        padding-bottom: 15px;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="banner-wrap" data-left-preview data-id="1">
                        <img src="/public/wxapp/images/banner.jpg" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>

                    <div class="fenlei-nav" data-left-preview data-id="3">
                        <div class="no-nav" ng-if="fenleiNavs.length<=0">
                            暂无导航哦~
                        </div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="new-activity" data-left-preview data-id="4" style="margin:10px 0">
                        <div class="title">{{activityTitle}}</div>
                        <div class="new-info" ng-repeat="activity in activityList">
                            <img src="{{activity.imgsrc}}" alt="">
                        </div>
                    </div>

                    <div class="top-img" data-left-preview data-id="7" style="margin:10px 0">
                        <img ng-src="{{couponImg==''?'/public/wxapp/card/certificate/images/zhanwei_750_225.jpg':couponImg}}" alt="优惠券" style="width: 100%" />
                    </div>

                    <div class="brand-part" data-left-preview data-id="5">
                        <div class="title">{{shortcutTitle}}</div>
                        <ul class="brand-list">
                            <li class="brand" ng-repeat="brand in brands">
                                <div class="brand-box">
                                    <img src="{{brand.imgsrc}}" alt="" class="good-cover">
                                    <div class="brand-name text">{{brand.name}}</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="goods-part goods" data-left-preview data-id="6">
                        <div class="title">{{goodsTitle}}</div>
                        <div class="good" ng-repeat="good in goods">
                            <div class="good-box">
                                <img src="{{good.cover}}" alt="" class="good-cover">
                                <div class="good-name text">{{good.name}}</div>
                                <div class="good-price text" style="font-size: 14px;">￥{{good.price}}</div>
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
                    <div class="input-group-box">
                        <label class="label-name">页面标题：</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1">
                <label>幻灯管理</label>
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
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>

            <div class="fenleinav" data-right-edit data-id="3" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">分类导航<span>(分类最多8个，图标尺寸200*200)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
                            <img ng-src="{{fenleiNav.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('fenleiNavs',fenleiNav.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="fenleiNav.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="">标　题：</label>
                            <input class="form-control" type="text" maxlength="5" ng-model="fenleiNav.title">
                        </div>
                        <!--
                        <div class="input-group clearfix">
                            <label for="">链接到：</label>
                            <select class="form-control" ng-model="fenleiNav.articleTitle" ng-options="x.name as x.name for x in categoryGoods" ng-change="getNavId(fenleiNav.index,fenleiNav.articleTitle)"></select>
                        </div>
                        -->
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==10">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goods" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==29" style="margin-top: 10px;">
                            <label for="">秒杀商品：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in limitList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==30" style="margin-top: 10px;">
                            <label for="">拼团商品：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in groupList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==31" style="margin-top: 10px;">
                            <label>砍价商品：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106" style="margin-top: 10px;">
                            <label>小 程 序：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="coursepart" data-right-edit data-id="4">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="activityTitle">
                    <span>(图标尺寸750*400)</span>
                </div>
                <div class="fenleinav-manage activity-box" ng-repeat="activity in activityList">
                    <div class="delete" ng-click="delIndex('activityList',activity.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{activity.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('activityList',activity.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="activity.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('activityList',activity.index)" data-dom-id="upload-activity{{$index}}" id="upload-activity{{$index}}"  ng-src="{{activity.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="activity{{$index}}"  class="avatar-field bg-img" name="activity{{$index}}" ng-value="activity.imgsrc"/>
                        </div>
                    </div>
                    <!--
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="activity.articleId" ng-options="x.id as x.title for x in articles"></select>                        </div>
                    </div>
                    -->
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="activity.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==1">
                        <label for="">单　　页：</label>
                        <select class="cus-input" ng-model="activity.articleId"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="activity.articleId" ng-model="activity.articleId" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==10">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==5">
                        <label for="">商品详情：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.id as x.name for x in goods" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==29" style="margin-top: 10px;">
                        <label for="">秒杀商品：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.id as x.name for x in limitList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==30" style="margin-top: 10px;">
                        <label for="">拼团商品：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.id as x.name for x in groupList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==31" style="margin-top: 10px;">
                        <label>砍价商品：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.id as x.name for x in bargainList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="activity.type==106" style="margin-top: 10px;">
                        <label>小 程 序：</label>
                        <select class="cus-input form-control" ng-model="activity.articleId"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewActivity()"></div>
            </div>
            <div class="coursepart" data-right-edit data-id="7">
                <label>优惠券图片<span>（图片建议尺寸750px*220px）</span></label>
                <div class="hornor-covers-manage">
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="220" style="height:100%;">
                            <img ng-src="{{couponImg?couponImg:'/public/wxapp/card/certificate/images/zhanwei_750_225.jpg'}}"  onload="changeSrc(this)"  imageonload="changeBg()" alt="图片" style="width: 100%">
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="220" imageonload="changeBg()" data-dom-id="upload-couponImg" id="upload-couponImg{{$index}}"  ng-src="{{couponImg?couponImg:'/public/wxapp/card/certificate/images/zhanwei_750_225.jpg'}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="couponImg"  class="avatar-field bg-img" name="couponImg" ng-value="couponImg"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="brands" data-right-edit data-id="5">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="shortcutTitle">
                    <span>(品牌超过4个向右滑动，此处不做展示，图标尺寸200*200)</span>
                </div>
                <div class="fenleinav-manage" ng-repeat="brand in brands">
                    <div class="delete" ng-click="delIndex('brands',brand.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
                            <img ng-src="{{brand.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('brands',brand.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="brand.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('brands',brand.index)" data-dom-id="upload-brand{{$index}}" id="upload-brand{{$index}}"  ng-src="{{brand.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="brand{{$index}}"  class="avatar-field bg-img" name="brand{{$index}}" ng-value="brand.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="">标　题：</label>
                            <input class="form-control" type="text" maxlength="5" ng-model="brand.name">
                        </div>
                        <!--
                        <div class="input-group clearfix">
                            <label for="">链接到：</label>
                            <select class="form-control" ng-model="brand.linkTitle" ng-options="x.name as x.name for x in categoryGoods" ng-change="getBrandId(brand.index,brand.linkTitle)"></select>
                        </div>
                        -->
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" ng-model="brand.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="brand.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="brand.link" ng-model="brand.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==10">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.id as x.name for x in goods" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==29" style="margin-top: 10px;">
                            <label for="">秒杀商品：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.id as x.name for x in limitList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==30" style="margin-top: 10px;">
                            <label for="">拼团商品：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.id as x.name for x in groupList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==31" style="margin-top: 10px;">
                            <label>砍价商品：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="brand.type==106" style="margin-top: 10px;">
                            <label>小 程 序：</label>
                            <select class="cus-input form-control" ng-model="brand.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBrand()"></div>
            </div>
            <div class="coursepart" data-right-edit data-id="6">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="goodsTitle">
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处商品为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div>

        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.headerTitle    = '<{$tpl['aci_title']}>' ? '<{$tpl['aci_title']}>' : '首页';
        $scope.couponImg      = '<{$tpl['aci_index_coupon_img']}>'
        $scope.banners        = <{$slide}>;
        $scope.tpl_id         = '<{$tpl['aci_tpl_id']}>';
        $scope.storeList      = <{$storeList}>;
        $scope.goods          = <{$goods}>;
        $scope.special        = <{$special}>;
        $scope.fenleiNavs     = <{$shortcut}>;
        $scope.category       = <{json_encode($category)}>;
        $scope.categoryGoods  = <{json_encode($categoryGoods)}>;
        $scope.articles        =  <{$information}>;
        $scope.activityList   = <{$activityList}>;
        $scope.brands         = <{$navList}>;
        $scope.kindSelect     = <{$kindSelect}>;
        $scope.linkTypes      = <{$linkType}>;
        $scope.linkList       = <{$linkList}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitList = <{$limitList}>;
        $scope.bargainList = <{$bargainList}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.shortcutTitle   = '<{$tpl['aci_shortcut_title']}>' ? '<{$tpl['aci_shortcut_title']}>' : '品牌街';
        $scope.goodsTitle      = '<{$tpl['aci_goods_title']}>' ? '<{$tpl['aci_goods_title']}>' : '人气推荐';
        $scope.activityTitle      = '<{$tpl['aci_activity_title']}>' ? '<{$tpl['aci_activity_title']}>' : '最近活动';

        $scope.addNewBanner = function(){
            var banner_length = $scope.banners.length;
            var defaultIndex = 0;
            if(banner_length>0){
                for (var i=0;i<banner_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.banners[i].index)){
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
                    imgsrc: '/public/wxapp/images/banner.jpg',
                    articleId: ''
                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.banners);
        }

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
        };

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
        }

        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.fenleiNavs[i].index)){
                        defaultIndex = $scope.fenleiNavs[i].index;
                    }
                }
                defaultIndex++;
            }

            if(fenleiNav_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleTitle:$scope.categoryGoods.length > 0 ? $scope.categoryGoods[0].name : '',
                    articleId: $scope.categoryGoods.length > 0 ? $scope.categoryGoods[0].id : '',
                    link : $scope.categoryGoods.length > 0 ? $scope.categoryGoods[0].id : '',
                    type : '10'
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);

                console.log($scope.fenleiNavs);
            }
        };

        /*添加品牌*/
        $scope.addNewBrand = function(){
            var brands_length = $scope.brands.length;
            var defaultIndex = 0;
            if(brands_length>0){
                for (var i=0;i<brands_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.brands[i].index)){
                        defaultIndex = $scope.brands[i].index;
                    }
                }
                defaultIndex++;
            }

            var brands_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                name: '默认标题',
                linkTitle:$scope.categoryGoods.length > 0 ? $scope.categoryGoods[0].name : '',
                link : $scope.categoryGoods.length > 0 ? $scope.categoryGoods[0].id : '',
                type : '10'
            };
            $scope.brands.push(brands_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);

            console.log($scope.brands);
        };

        /*添加最新活动*/
        $scope.addNewActivity = function(){
            var activity_length = $scope.activityList.length;
            var defaultIndex = 0;
            if(activity_length>0){
                for (var i=0;i<activity_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.activityList[i].index)){
                        defaultIndex = $scope.activityList[i].index;
                    }
                }
                defaultIndex++;
            }
            var activity_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                articleTitle:'',
                articleId:  '',
                type : '1'
            };
            $scope.activityList.push(activity_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);

            console.log($scope.fenleiNavs);
        };

        $scope.getNavId = function(index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.fenleiNavs,index);
            var categoryGoods = $scope.categoryGoods;
            var curId = '';
            for(var i in categoryGoods){
                if(categoryGoods[i].name == title){
                    curId = categoryGoods[i].id;
                }
            }
            $scope.fenleiNavs[realIndex].articleId = curId;
            console.log($scope.fenleiNavs)
        };

        $scope.getBrandId = function(index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.fenleiNavs,index);
            var categoryGoods = $scope.categoryGoods;
            var curId = '';
            for(var i in categoryGoods){
                if(categoryGoods[i].name == title){
                    curId = categoryGoods[i].id;
                }
            }
            $scope.brands[realIndex].link = curId;
            console.log($scope.fenleiNavs)
        };

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	      : $scope.headerTitle,
                'slide'		      : $scope.banners,
                'couponImg'      : $scope.couponImg,
                'tpl_id'	      : $scope.tpl_id,
                'shortcut'        : $scope.fenleiNavs,
                'notice'        : $scope.activityList,
                'navList'          : $scope.brands,
                'activityTitle'  : $scope.activityTitle,
                'shortcutTitle'   : $scope.shortcutTitle,
                'goodsTitle'     : $scope.goodsTitle
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/cake/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        // 选择分类
        $scope.getSelectId = function(type,index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            var category = $scope.category;
            var curId = '';
            for(var i in category){
                if(category[i] == title){
                    curId = i;
                }
            }
            $scope[type][index].link = curId;
        };


        $scope.inputChange = function(){
            console.log("aaa");
        }

        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.couponImg = imgNowsrc;
            }
        };

        $(function(){
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

            $('img.enter').on('click', function(event) {
                if($('.address-show').hasClass('active')){
                    $('.address-show').removeClass('active');
                }else{
                    $('.address-show').addClass('active');
                }
                event.stopPropagation();
            });
        });
    }]);
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
    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }
</script>
<{include file="../img-upload-modal.tpl"}>