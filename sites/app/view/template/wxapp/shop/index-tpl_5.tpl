<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/index.css?4">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/style.css?1">
<style>
    .banner-manage .input-group label{
        width: 17% !important;
    }
    .banner-manage .input-group .cus-input{
        width: 83% !important;
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
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/wxapp/images/banner.jpg" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="pagination">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>
                    <div class="fenlei-nav" data-left-preview data-id="2">
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
                    <div class="address-show flex-wrap" data-left-preview data-id="3">
                        <p class="flex-con" ng-style="addressStyle">{{address.address}}</p>
                        <img src="/public/wxapp/images/icon_dw.png" />
                    </div>
                    <div class="service-list" data-left-preview data-id="4">
                        <div class="no-nav" ng-if="serviceList.length<=0" style="margin-bottom: 5px">
                            点此添加服务~
                        </div>
                        <div class="service-item" ng-repeat="service in serviceList">
                            <div class="left-intro bg-green">
                                <img ng-src="{{service.imgsrc}}" alt="导航图标">
                            </div>
                            <div class="right-intro">
                                <p class="title">{{service.name}}</p>
                                <div class="con-txt">
                                    <p>{{service.intro}}</p>
                                </div>
                                <div class="more-btn">了解更多</div>
                            </div>
                        </div>
                    </div>
                    <div class="cooperative-enterprise"  data-left-preview data-id="5">
                        <div class="title">
                            <img src="/public/wxapp/images/icon_hzqy.png" />
                            <p>{{coopera.title}}</p>
                        </div>
                        <div class="enterprise-list clearfix">
                            <img ng-src="{{coopera.imgsrc}}" />
                        </div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="7">
                        <div class="no-data-tip" ng-if="!appointInfo.isOn">点此管理预约模块儿~</div>
                        <div ng-if="appointInfo.isOn">
                            <div class="cooperative-wrap">
                                <img ng-src="{{bottomImg}}" style="width: 90%;" />
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
                        <input type="text" placeholder="请输入页面标题" maxlength="15" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ui-sortable ng-model="banners">
                <label>幻灯管理<span>（建议尺寸750*360）</span></label>
                <div ui-sortable class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="shopintrobg-manage cropper-box" data-width="750" data-height="360" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==1">
                        <label for="">链 接 到：</label>
                        <select class="cus-input" ng-model="banner.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('banners',banner.index,banner.articleTitle)"></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="2" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">分类导航<span>(分类多于3个时手机端可横向滑动，管理界面不做展示，图标尺寸200*200)</span></label>
                <div ui-sortable class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
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
                            <input type="text" maxlength="5" ng-model="fenleiNav.title">
                        </div>
                        <!--
                        <div class="input-group clearfix">
                            <label for="">链接到：</label>
                            <!-- <input type="text" ng-value="fenleiNav.link" ng-model="fenleiNav.link">
                            <select class="form-control" ng-model="fenleiNav.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getNavId(fenleiNav.index,fenleiNav.articleTitle)"></select>
                        </div>
                        -->
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==18">
                            <label for="">分类列表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in categoryList"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==32">
                            <label for="">资讯分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==19">
                            <label for="">服务详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in serviceArticles"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList"></select>
                        </div>

                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==55">
                            <label for="">表　　单：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in formlist"></select>
                        </div>

                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==56">
                            <label for="">模　　板：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in templateList"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="enterpriseIntro" data-right-edit data-id="3">
                <label>联系地址</label>
                <div class="top-manage">
                    此区域信息在小程序管理下的菜单导航里添加，此处只做展示
                    <!--<div class="input-group">
                        <div style="width: 50%;float: left">
                        <label class="label-name">地址文字颜色：</label>
                        <div class="right-color">
                            <input type="text" class="color-input" data-colortype="selectedColor" ng-model="addressStyle.color">
                        </div>
                    </div>
                    <div class="input-groups" style="margin-bottom: 10px;">
                        </div>
                        <div style="width: 50%;float: right">
                            <label class="label-name">地址文字大小：</label>
                            <select class="cus-input" ng-model="addressStyle.fontSize" ng-options="x.id as x.name for x in sizes"></select>
                        </div>
                    </div>
                    <div class="input-groups" style="margin: 10px 0;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 75%;display: inline-block;">详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="address.longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="address.latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <input type="text" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="address.address" />
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>-->
                </div>
            </div>
            <div class="fenleinav" data-right-edit data-id="4">
                <label style="width: 100%">服务列表<span></span></label>
                <div ui-sortable class="fenleinav-manage service-manage" ng-repeat="service in serviceList">
                    <div class="delete" ng-click="delIndex('serviceList',service.index)">×</div>
                    <div class="edit-img">
                        <!--<img ng-src="{{service.imgsrc}}" alt="导航图标">-->
                        <!--<div class="cropper-box" data-width="300" data-height="300" style="height:100%;">
                            <img ng-src="{{service.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('serviceList',service.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="service.imgsrc"/>
                            <span style="color: #999;font-size: 5px;">尺寸：300*300</span>
                        </div>-->

                        <div style="text-align: center">
                            <img onclick="toUpload(this)"  data-limit="1000" onload="changeSrc(this)" data-width="300" data-height="300" imageonload="doThis('serviceList',service.index)" data-dom-id="upload-service{{$index}}" id="upload-service{{$index}}"  ng-src="{{service.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="service{{$index}}"  class="avatar-field bg-img" name="service{{$index}}" ng-value="service.imgsrc"/>
                            <span style="color: #999;font-size: 5px;">尺寸：300*300</span>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="">标　题：</label>
                            <input type="text" ng-model="service.name">
                        </div>
                        <div class="input-group clearfix">
                            <label for="">简　介：</label>
                            <textarea rows="3" ng-model="service.intro"></textarea>
                        </div>
                        <div class="input-group clearfix">
                            <label for="">链接到：</label>
                            <select class="form-control" ng-model="service.articleTitle" ng-options="x.title as x.title for x in serviceArticles" ng-change="getServiceId(service.index,service.articleTitle)"></select>
                        </div>
                        <div class="service-tip" ng-click="saveData()"><a target="_blank" href="/wxapp/shop/service">如链接不存在请先添加企业服务，点此添加</a></div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewservice()"></div>
            </div>
            <div class="shopintrobg" data-right-edit data-id="5">
                <div class="input-group">
                    <label for="">标题</label>
                    <input type="text" placeholder="请输入页面标题" maxlength="15" ng-model="coopera.title">
                </div>
                <label style="width: auto;font-weight: normal;">{{coopera.title}}</label>
                <!--<div class="shopintrobg-manage cropper-box" data-width="750" data-height="280">
                    <img ng-src="{{coopera.imgsrc}}" onload="changeSrc(this)" imageonload="changeBg()"  alt="企业展示图">
                    <a href="#" class="change-bg">修改图片<span>(建议尺寸750*280)</span></a>
                </div>-->
                <div class="shopintrobg-manage">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="280" imageonload="changeBg()" data-dom-id="upload-coopera" id="upload-coopera{{$index}}"  ng-src="{{coopera.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="coopera"  class="avatar-field bg-img" name="coopera" ng-value="coopera.imgsrc"/>
                    <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="280" data-dom-id="upload-coopera">修改图片<span>(建议尺寸750*280)</span></a>
                </div>
                <div class="input-group clearfix">
                    <label for="">链接到：</label>
                    <select class="cus-input" ng-model="coopera.link" ng-options="x.id as x.title for x in articles" ></select>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="7">
                <div class="isOn">
                    <span>开启预约:(用于收集表单信息，点击跳转到<a href="/wxapp/form/index" target="_blank" style="color: #428bca">自定义表单</a>页面。)</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="appointInfo.isOn">
                        <label class='tgl-btn' for='sms_start'></label>
                    </span>
                </div>
                <div class="shopintrobg-manage" ng-if="appointInfo.isOn">
                    <div style="margin-top: 20px;">
                        <a href="/wxapp/form/index" target="_blank" class="btn btn-sm btn-green"> 配置自定义表单 </a>
                    </div>
                    <img onclick="toUpload(this)"  style="margin-top: 20px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="240" imageonload="changeBottomImg()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{bottomImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="bottomImg"  class="avatar-field bg-img" name="bottomImg{{$index}}" ng-value="bottomImg"/>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.sizes = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.serviceArticles =  <{$serviceArticle}>;
        $scope.articles        =  <{$information}>;
        $scope.headerTitle     = '<{$tpl['at_title']}>';
        $scope.banners         =  <{$slide}>;
        $scope.templateList    = <{$templateList}>;
        $scope.formlist        = <{$formlist}>;
        $scope.fenleiNavs      = <{$shortcut}>;
        $scope.categoryList    =  <{$categoryList}>;
        $scope.informationCategory = <{$informationCategory}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.linkTypesNew    = <{$linkTypesNew}>;
        $scope.bottomImg = '<{$tpl['at_bottom_img']}>'?'<{$tpl['at_bottom_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.address = {
            address:'<{$contact['sa_address']}>' ? '<{$contact['sa_address']}>' : '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室',
            longitude:'<{$contact['sa_lng']}>' ? '<{$contact['sa_lng']}>' : '113.72052',
            latitude:'<{$contact['sa_lat']}>' ? '<{$contact['sa_lat']}>' : '34.77485'
        };
        $scope.addressStyle ={
            color : '<{$contact['sa_color']}>' ? '<{$contact['sa_color']}>' : '#000000',
            fontSize : '<{$contact['sa_size']}>' ? '<{$contact['sa_size']}>' : '14'
        };
        $scope.coopera = {
            title: '<{$tpl['at_foot_title']}>' ? '<{$tpl['at_foot_title']}>' : "合作企业",
            imgsrc: '<{$tpl['at_head_img']}>' ? '<{$tpl['at_head_img']}>' :'/public/wxapp/images/hzqy.png',
            link: '<{$tpl['at_coopera_link']}>'
        };
        $scope.tpl_id		= '<{$tpl['at_tpl_id']}>';
        $scope.serviceList = <{$serviceList}>;
        $scope.appointInfo = {
                isOn:<{if $tpl['at_appoint_ison']}> true <{else}> false <{/if}>,
            title:"<{$tpl['at_appoint_title']}>" ? "<{$tpl['at_appoint_title']}>" : '新老客户专享优惠',
            btnTxt:"<{$tpl['at_appoint_btn_text']}>" ? "<{$tpl['at_appoint_btn_text']}>" : '预约',
        }
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
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
            if(fenleiNav_length>=3){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加3个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleTitle:$scope.articles.length > 0 ? $scope.articles[0].title : '',
                    articleId: $scope.articles.length > 0 ? $scope.articles[0].id : '',
                    type : '1',
                    link : $scope.articles.length > 0 ? $scope.articles[0].id : ''
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
                        $scope.addressStyle.color=realColor;
                        console.log($scope.addressStyle.color);
                    });
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        };


        /*添加服务方法*/
        $scope.addNewservice = function(){
            var serviceList_length = $scope.serviceList.length;
            var defaultIndex = 0;
            if(serviceList_length>0){
                for (var i=0;i<serviceList_length;i++){
                    if(defaultIndex < $scope.serviceList[i].index){
                        defaultIndex = $scope.serviceList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(serviceList_length>=6){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error', 
                    closeBtn: 0, 
                    shift: 5,
                    content: '首页最多只显示6个服务项目~',
                    time: 2000
                });
            }else{
                var serviceList_Default = {
                    index: defaultIndex,
                    name: '服务名称',
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    intro:'服务简介',
                    articleTitle:$scope.serviceArticles.length > 0 ? $scope.serviceArticles[0].title : '',
                    articleId: $scope.serviceArticles.length > 0 ? $scope.serviceArticles[0].id : ''
                };
                $scope.serviceList.push(serviceList_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.serviceList);
        }
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope[type][realIndex].imgsrc = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.coopera.imgsrc = imgNowsrc;
            }
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
                    type:'1'
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
                $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                });
                layer.msg('删除成功');
//                if($scope[type].length>1){
//                    $scope.$apply(function(){
//                        $scope[type].splice(realIndex,1);
//                    });
//                    layer.msg('删除成功');
//                }else{
//                    layer.msg('最少要留一个哦');
//                }
            });
        };

        $scope.getNavId = function(index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.fenleiNavs,index);
            var articles = $scope.articles;
            var curId = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                }
            }
            $scope.fenleiNavs[realIndex].articleId = curId;
            console.log($scope.fenleiNavs)
        };

        // 选择资讯
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var articles = $scope.articles;
            var curId = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
                $scope[parentType][type][realIndex].link = curId;
                console.log($scope[parentType][type])
            }else{
                $scope[type][realIndex].articleId = curId;
                $scope[type][realIndex].link = curId;
                console.log($scope[type])
            }
        };

        $scope.getServiceId = function(index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.serviceList,index);
            var articles = $scope.serviceArticles;
            var curId = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                }
            }
            $scope.serviceList[realIndex].articleId = curId;
            console.log($scope.serviceList)
        };
        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	 : $scope.headerTitle,
                'head_img'   : $scope.coopera.imgsrc,
                'slide'		 : $scope.banners,
                'shortcut'	 : $scope.fenleiNavs,
                'tpl_id'	 : $scope.tpl_id,
                'footTitle'  : $scope.coopera.title,
                'cooperaLink': $scope.coopera.link,
               /* 'address'    : $scope.address.address,
                'longitude'  : $scope.address.longitude,
                'latitude'   : $scope.address.latitude,*/
                'serviceList': $scope.serviceList,
                'appointInfo': $scope.appointInfo,
               /* 'color'      : $scope.addressStyle.color,
                'size'       : $scope.addressStyle.fontSize,*/
                'bottomImg'  : $scope.bottomImg
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/shop/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

    $scope.changeBottomImg=function(){
        if(imgNowsrc){
            $scope.bottomImg = imgNowsrc;
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
            addMarker($scope.address.longitude,$scope.address.latitude,$scope.address.address);

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
                if($scope.address.address){
                    console.log($scope.address.address);
                    AMap.service('AMap.Geocoder',function(){ //回调函数
                        //实例化Geocoder
                        geocoder = new AMap.Geocoder({
                            'city'   : '全国', //城市，默认：“全国”
                            'radius' : 1000   //范围，默认：500
                        });
                        //TODO: 使用geocoder 对象完成相关功能
                        //地理编码,返回地理编码结果
                        geocoder.getLocation($scope.address.address, function(status, result) {
                            console.log(result);
                            if (status === 'complete' && result.info === 'OK') {
                                var loc_lng_lat = result.geocodes[0].location;
                                addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),$scope.address.address);
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
                $scope.address.address   = address;
                $scope.address.longitude = lng;
                $scope.address.latitude  = lat;
                $('#details-address').val(address);
                $('#lng').val(lng);
                $('#lat').val(lat);
                console.log(address);

            }
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