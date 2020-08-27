<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp1/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/cake/template/temp1/css/style.css?3">
<link rel="stylesheet" href="/public/wxapp/store/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/store/temp1/css/style.css">
<style>
    .fenleinav-manage{
        padding: 10px;
        background-color: #fff;
        border: 1px solid #e8e8e8;
    }
    .goods-part .good .text{
        line-height: 1.5;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }
    .banner-manage{
        padding-bottom: 15px;
    }

    .index-img{
        width: 85%;
        position: relative;
        top: -20px;
    }

    .store-avatar{
        width: 25%;
        float: left;
        margin-right: 10px;
    }

    .store-score{
        font-size: 12px;
        color: orange;
    }

    .store-address{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .store-address, .store-zone{
        color: #666;
    }

    .store-wrap{
        background: #fff;
        padding: 10px;
        margin-top: -10px;
    }

    .store-list-title{
        text-align: center;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .store-box{
        min-height: 110px;
    }

    .cfg-box{
        height: 27px;
        width: 254.15px;
        position: relative;
        top:-22px;
        background-color: #fff;
        margin: 0 auto;
    }
    .cfg-span{
        width: 40%;
        display: none;
        margin:0 auto;
        text-align: center;
        /*float: left;*/
        font-size: 11px;
        color: #666;
        vertical-align:middle;
    }
    .input-group, .input-group-box{
        width: 100%;
    }
    .input-group label{
        width: 20%;
    }
    .input-group input, .input-group-box input{
        width: 80% !important;
    }
    .goods-part {
        background: #fff;
        margin-top: -10px;
        padding-top: 5px;
    }

    .fenlei-nav li img {
        width: 55%;
        float: inherit;
        margin-left: 10px;
        border-radius: 100%;
        margin: 0 auto;
    }

    .fenlei-nav li p {
        float: left;
        margin-left: 0;
        line-height: 2;
        font-size: 13px;
        text-align: center;
        width: 100%;
    }

    .fenlei-nav li {
        width: 25%;
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
                    <!--更多服务-->
                    <div class="fenlei-nav" data-left-preview data-id="2" style="background-color:#fff">
                        <div class="contact-item flex-wrap">
                            <!--<img src="/public/wxapp/meal/images/dianpu@2x.png" class="icon-contact" />-->
                            <div class="label-name" style="padding: 5px 0 0 10px;">{{shopInfo.serviceTitle}}</div>
                        </div>
                        <div class="no-nav" ng-if="fenleiNavs.length<=0" style="text-align: center;">
                            暂无跟多服务哦~
                        </div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                <p ng-bind="fenleiNav.title"></p>
                            </li>
                        </ul>
                    </div>
                    <div data-left-preview data-id="3">
                        <img ng-src="{{couponBackground}}" alt="" style="width: 100%;margin-top: 5px;position: relative;" />
                    </div>
                    <!--团队介绍-->
                    <div class="service-wrap" data-left-preview data-id="4">
                        <div class="title-name" style="margin-bottom: 10px;height: 30px">
                            <span style="color: #333;text-align: center;width: 100%">{{introTitle}}</span>
                        </div>
                        <div class="active-list">
                            <div class="cooperative-wrap" style="padding: 0 10px">
                                <img ng-src='<{$store['ahs_cover']}>' style="width: 100%;" />
                                <div style="text-indent: 2em"><{$store['ahs_brief']}></div>
                            </div>
                            <div class="contact-item" style="display: block">
                                <img src="/public/wxapp/appointment/images/yuyue_location.png" style="display: inline-block" alt="图标">
                                <span class="label-con flex-con" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><{$store['ahs_address']}></span>
                            </div>
                            <div class="contact-item" style="display: block">
                                <img src="/public/wxapp/appointment/images/yuyue_phone.png" style="display: inline-block"  alt="图标">
                                <span class="label-con flex-con"><{$store['ahs_contact']}></span>
                            </div>
                        </div>
                    </div>
                    <div class="goods-part recommend" data-left-preview data-id="5">
                        <div class="title" style="text-align: center;font-size: 18px;margin-top: 10px">{{recommendTitle}}</div>
                        <ul class="good-list">
                            <li class="good" ng-repeat="good in recommendGoods">
                                <div class="good-box">
                                    <img src="{{good.cover}}" alt="" class="good-cover">
                                    <div class="good-name text">{{good.name}}</div>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="goods-part goods" data-left-preview data-id="6">
                        <div class="title" style="text-align: center;font-size: 18px;margin-top: 10px">{{listTitle}}</div>
                        <div class="good" ng-repeat="good in goods">
                            <div class="good-box">
                                <img src="{{good.cover}}" alt="" class="good-cover">
                                <div class="good-name text">{{good.name}}</div>
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
                    <div class="input-group-box">
                        <label class="label-name">付费取消提示：</label>
                        <textarea type="text" class="cus-input" placeholder="请输入提示内容" maxlength="120" ng-model="cancelPrompt" style="height: 100px"></textarea>
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">订单温馨提示：</label>
                        <textarea type="text" class="cus-input" placeholder="请输入提示内容" maxlength="120" ng-model="tradeRemind" style="height: 100px"></textarea>
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

                        <div class="input-group clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="banner.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="banner.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="banner.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="banner.link" ng-model="banner.link" style="width: 100% !important;"/>
                        </div>
                        <div class="input-group clearfix" ng-show="banner.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="banner.type==32">
                            <label for="">资讯分类：</label>
                            <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                        </div>
                    <div class="input-group clearfix" ng-show="banner.type==54">
                        <label for="">门店详情：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in storeListAll" ></select>
                    </div>


                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <!--更多服务-->
            <div class="fenleinav" data-right-edit data-id="2" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">导航<span>(图标尺寸200*200)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img" style="margin-top: 30px">
                        <!--<div class="cropper-box" data-width="200" data-height="200" style="height:100%;">
                                <img ng-src="{{fenleiNav.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('fenleiNavs',fenleiNav.index)" alt="导航图标">
                                <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="fenleiNav.imgsrc"/>
                            </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="100" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="" style="width: 33%">标　题：</label>
                            <input type="text" maxlength="5" ng-model="fenleiNav.title" style="border: 1px solid #ddd;padding: 0 10px;">
                        </div>
                        <!--
                        <div>
                            <label for="" style="width: 33%">链接类型：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkType" ng-options="x.id as x.name for x in linkTypes">
                            </select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == 1">
                            <label for="" style="width: 33%">单　　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.id as x.title for x in articles"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == 2">
                            <label for="" style="width: 33%">列　　表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.path as x.name for x in linkList"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == 3">
                            <label for="" style="width: 33%">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == 106">
                            <label for="" style="width: 33%">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.appid as x.name for x in jumpList"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == 32">
                            <label for="" style="width: 33%">资讯分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.id as x.name for x in infocateList"></select>
                        </div>
                        -->
                        <div>
                            <label for="" style="width: 33%">链接类型：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkType">
                                <option value="1">资讯详情</option>
                                <option value="2">菜单/资讯分类</option>
                                <option value="106">跳转小程序</option>
                                <option value="54">门店详情</option>
                            </select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == '2'">
                            <label for="" style="width: 33%">链接到：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.link as x.name for x in categoryList"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == '1'">
                            <label for="" style="width: 33%">链接到：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.id as x.title for x in articles"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == '106'">
                            <label for="" style="width: 33%">链接到：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.appid as x.name for x in jumpList"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.linkType == '54'">
                            <label for="" style="width: 33%">链接到：</label>
                            <select class="cus-input" ng-model="fenleiNav.link" ng-options="x.link as x.name for x in storeLink"></select>
                        </div>
                        <div style="color: #666;padding-left: 5px;font-size: 12px" ng-if="fenleiNav.linkType == '2'">
                            链接到页面或资讯管理的某一分类
                        </div>

                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>

            <div class="banner" data-right-edit data-id="3">
                <label style="width: auto;font-weight: normal;">优惠券入口背景图</label>
                <div class="shopintrobg-manage">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="200" imageonload="changeBg()" data-dom-id="upload-coopera" id="upload-coopera"  ng-src="{{couponBackground}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="coopera"  class="avatar-field bg-img" name="coopera" ng-value="couponBackground"/>
                    <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="200" data-dom-id="upload-coopera">修改图片<span>(建议尺寸750*200)</span></a>
                </div>
            </div>

            <!--团队展示-->
            <div class="service" data-right-edit data-id="4">
                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="">标题</label>
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="15" ng-model="introTitle">
                </div>
                <div class="service-manage">
                    <div class="edit-txt">
                        <div class="input-group">
                            <label for="">视频地址：</label>
                            <input type="text" class="cus-input" ng-model="videoUrl">
                        </div>
                    </div>
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">酒店信息,请到门店管理添加~</div>
                </div>
            </div>

            <div class="banner" data-right-edit data-id="5">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="recommendTitle" style="margin-bottom:10px;">
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="6">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="listTitle" style="margin-bottom:10px;">
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处为固定链接，请到对应管理页面管理相关内容~</div>
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
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.headerTitle = '<{$tpl['ahi_title']}>';
        $scope.cancelPrompt = '<{$tpl['ahi_cancel_prompt']}>' ? '<{$tpl['ahi_cancel_prompt']}>' : '';
        $scope.tradeRemind = '<{$tpl['ahi_trade_remind']}>' ? '<{$tpl['ahi_trade_remind']}>' : '';
        $scope.couponBackground = '<{$tpl['ahi_coupon_background']}>' ? '<{$tpl['ahi_coupon_background']}>' :'/public/wxapp/hotel/images/quan_enter.jpg';
        $scope.banners     = <{$slide}>;
        $scope.tpl_id      = '<{$tpl['ahi_tpl_id']}>';
        $scope.storeList   = <{$storeList}>;
        $scope.recommendTitle   = '<{$tpl['ahi_recommed_title']}>' ? '<{$tpl['ahi_recommed_title']}>' : '房间推荐';
        $scope.listTitle   = '<{$tpl['ahi_list_title']}>' ? '<{$tpl['ahi_list_title']}>' : '房间精选';
        $scope.hotelImg    = '<{$tpl['ahi_hotel_img']}>'?'<{$tpl['ahi_hotel_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.fenleiNavs  = <{$service}>;
        console.log($scope.fenleiNavs);
        $scope.goods       = <{$goods}>;
        $scope.recommendGoods = <{$recommendGoods}>;
        $scope.introTitle  = '<{$tpl['ahi_intro_title']}>'?'<{$tpl['ahi_intro_title']}>':'店家介绍';
        $scope.hotelIntro  = '<{$tpl['ahi_hotel_intro']}>';
        $scope.videoUrl    = '<{$tpl['ahi_video_url']}>';
        $scope.categoryList = <{$categoryList}>;
        $scope.articles        = <{$information}>;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList = <{$linkList}>;
        $scope.infocateList = <{$infocateList}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.storeLink = <{$storeLink}>;
        $scope.storeListAll = <{$storeListAll}>;

        /*添加分类更多服务*/
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
            if(fenleiNav_length>=60){
                layer.msg("最多只能添加60个分类");
            }else{
                var fenleiNav_Default = {
                    id: 0,
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    linkType:'2',
                    link:''
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.fenleiNavs);
        };

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
                    link: '',
                    articleTitle:'',
                    articleId:'',
                    type : ''
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
        $scope.checked = function($event){
            var curElem = $($event.target);
            var isChecked = curElem.is(":checked");
            var dataId = curElem.data('id');
            if(isChecked){
                $scope.showlist[dataId].isShow = 1;
            }else{
                $scope.showlist[dataId].isShow = 0;
            }
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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var memberOpen = $('#member_open').is(':checked');
            var tradeOpen = $('#trade_open').is(':checked');
            var data = {
                'title' 	 : $scope.headerTitle,
                'cancelPrompt' : $scope.cancelPrompt,
                'tradeRemind' : $scope.tradeRemind,
                'slide'		 : $scope.banners,
                'tpl_id'	 : $scope.tpl_id,
                'couponBackground' : $scope.couponBackground,
                'listTitle'   : $scope.listTitle,
                'recommendTitle': $scope.recommendTitle,
                'mobile': $scope.mobile,
                'address': $scope.address,
                'hotelIntro': $scope.hotelIntro,
                'service'      : $scope.fenleiNavs,
                'introTitle': $scope.introTitle,
                'lng': $scope.lng,
                'lat': $scope.lat,
                'hotelImg': $scope.hotelImg,
                'videoUrl': $scope.videoUrl
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/hotel/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.couponBackground = imgNowsrc;
            }
        };

        $scope.changeTeamImg=function(){
            if(imgNowsrc){
                $scope.hotelImg = imgNowsrc;
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

    function changeDisplay(obj) {
        var id = $(obj).attr('cfg-id');
        var status = $(obj).is(':checked');
        if(status){
            $("#"+ id +"").css("display","inline-block");
        }else{
            $("#"+ id +"").css("display","none");
        }
    }

</script>
<{include file="../img-upload-modal.tpl"}>