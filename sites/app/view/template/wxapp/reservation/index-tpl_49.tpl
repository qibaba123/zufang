<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/reservation/template/temp1/css/index.css?3">
<link rel="stylesheet" href="/public/wxapp/reservation/template/temp1/css/style.css?7">
<style>
    .fenleinav-manage { padding: 10px; background-color: #fff; border: 1px solid #e8e8e8; margin-top: 10px; }
    .goods-part .good .text { line-height: 1.5; overflow: hidden; white-space: nowrap; text-overflow: ellipsis }
    .banner-manage { padding-bottom: 15px; }
    .input-group-box { width: 100%; padding: 3px 0; }
    .journalpart .input-group-box, .service .input-group-box ,.notice .input-group-box{ display: table; }
    .journalpart .input-group-box .label-name, .service .input-group-box .label-name,.notice .input-group-box .label-name { display: table-cell; width: 75px; }
    .activity-box .edit-img { margin: 10px auto; }
    .service-wrap{
        margin-top: 2px;
        height: auto;
        background-color:#f3f3f3;
    }
    .service-wrap .title-names{
        position: relative;
        margin-bottom: 1px;
        height: 30px;
        background: #fff
    }
    .service-wrap .title-names span{
        height: 30px;
        line-height: 30px;
        color: #302E30;
        font-size: 16px;
        margin-left: 11px;
    }
    .service-wrap .title-names .more{
        float: right;
        margin-right: 10px;
        color: #999;
        padding: 0;
    }
    .address-show img.enter{
        top: 14px;
        width: 8px;
    }
    .address-show img{
        display: inline-block;
        width: 14px;
    }
    .fenlei-nav ul{
        height: 78px;
        width: 390px;
    }
    .fenlei-nav li{
        width: 70px;
    }
    .fenlei-nav li img{
        -webkit-border-radius :0;
        border-radius: 0;
    }
    .fenleinav-manage .edit-img{
        -webkit-border-radius :0;
        border-radius: 0;
    }
    .notice-box{
        margin-top: 2px;
    }
    .address-show{
        margin-bottom: 0;
    }
    .service-item{
        overflow: auto;
        width: 314px;
        display: inline-block;
        margin: 1px 1px;
        line-height: 1.3em;
        box-shadow: 0 0 0 #ccc;
        border-radius: 0;
        padding-bottom: 1px;
        background: #fff;
    }
    .service-list {
        padding: 0;
        overflow: hidden;
        height: 100%;
        width: auto;
    }
    .service-manage .edit-img img{
        width: 128px;
        height:128px;
    }
    .service-item>div{
        width: 60%;
    }
    .banner-manage .input-group-box label{
        width: 17% !important;
    }
    .banner-manage .input-group-box .cus-input{
        width: 82% !important;
    }
    .fenleinav-manage .input-group-box label{
        min-width: 70px;
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

                    <div class="address-show flex-wrap" data-left-preview data-id="2" >
                        <span ng-if="storeList.length<1">此处显示地址信息</span>
                        <div ng-repeat="store in storeList" class="sotre-list">
                            <span class="flex-con" ng-if="storeList.length<3" style="font-size: {{fontSize}}px;color:{{color}}">{{store.os_name}}]{{store.os_addr}}</span>
                            <span class="flex-con mulity" ng-if="storeList.length>2" style="font-size: {{fontSize}}px;color:{{color}}">
                               <img src="/public/wxapp/appointment/images/dingwei1.png" > {{store.os_name}}{{store.os_addr}}
                            </span>
                        </div>
                        <img src="/public/wxapp/appointment/images/gengduo1.png" class="enter" ng-if="storeList.length>2"  />
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

                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="4" style="height: 40px;">
                        <div style="display: inline-block;font-size: 18px;width: 40px;border-right: 1px solid #ccc;float:left;margin:0 10px;color: #6ab6bb;margin-top: 8px">
                            <img src="/public/wxapp/appointment/images/gonggao.png" style="margin-right: 10px;width: 30px">
                        </div>
                        <div class="notice-txt" style="line-height: 20px;">
                            <p ng-if="noticeTxt.length<=0">公告</p>
                            <p ng-repeat="notice in noticeTxt" style="margin-top: 10px;">{{notice.title}}</p>
                        </div>
                    </div>

                    <div class="service-wrap" data-left-preview data-id="6">
                        <div class="title-names">
                            <span>{{journalInfo.title}}</span>
                            <span class="more">查看全部</span>
                        </div>
                        <div class="no-data-tip" ng-if="journalInfo.journalList<=0">点此添加内容~</div>
                        <div class="service-list">
                            <div class="service-item"  ng-repeat="journal in journalInfo.journalList">
                                <img ng-src="{{journal.imgsrc}}" style="float:left;width:90px;height:90px;margin-left: 11px;margin-top: 4px;border-radius:6px "/>
                                <div style="float: right;margin-top: 10px;">
                                    <span class="title-txt name">{{journal.name}}</span>
                                    <span class="title-txt brief">{{journal.brief}}</span>
                                </div>
                            </div>
                        </div>
                    </div>




                    <div class="service-wrap" data-left-preview data-id="7">
                        <div class="title-name" style="text-align: center;color: cornflowerblue;background: #fff;font-size: 16px;">
                            {{teamTitle}}
                        </div>
                        <div class="no-data-tip" >此处为律师内容展示，请到相关管理页面添加~</div>
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
                        <label class="label-name">客服电话：</label>
                        <input type="text" class="cus-input" placeholder="请输入客服电话"  ng-model="kefu">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1">
                <label>幻灯管理</label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="banner.articleId" ng-model="banner.articleId" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==6">
                            <label for="">分类详情：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.name for x in category"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==5">
                            <label for="">产品详情：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.name for x in goods"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==18">
                            <label for="">分类详情：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.name for x in category"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==19">
                            <label for="">服务详情：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.title for x in serviceArticles"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==37">
                            <label for="">专家详情：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.name for x in expertList"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==38">
                            <label for="">专家分类：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.id as x.name for x in expertCategory"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input" ng-model="banner.articleId"  ng-options="x.appid as x.name for x in jumpList"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>

            <div class="field" data-right-edit data-id="2">
                <label style="width: 100%">门店管理</label>
                <div class="fenleinav-manage">
                    <!--<div class="input-group">
                        <div style="width: 100%;display: flex;margin-bottom: 30px;">
                            <label class="label-name">地址文字颜色：</label>
                            <div class="right-color">
                                <input type="text" class="color-input" data-colortype="selectedColor" ng-model="color">
                            </div>
                        </div>
                    </div>
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <div style="width: 100%;display: flex">
                            <label class="label-name" style="width: 140px">地址文字大小：</label>
                            <select class="cus-input" ng-model="fontSize" ng-options="x.id as x.name for x in sizes"></select>
                        </div>
                    </div>-->
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <div class="no-data-tip">此处门店为固定链接，请到对应管理页面管理相关内容~</div>
                    </div>
                </div>
            </div>

            <div class="fenleinav" data-right-edit data-id="3" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">分类导航</label>
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
                        <div class="input-group-box clearfix">
                            <label class="label-name" for="">标　　题：</label>
                            <input class="form-control" type="text" maxlength="5" ng-model="fenleiNav.title">
                        </div>
                        <!--
                        <div class="input-group-box clearfix">
                            <label  class="label-name" for="">链接到：</label>
                            <select class="form-control" ng-model="fenleiNav.articleTitle" ng-options="x.name as x.name for x in category" ng-change="getNavId(fenleiNav.index,fenleiNav.articleTitle)"></select>
                        </div>
                        -->
                        <div class="input-group-box clearfix">
                            <label class="label-name" for="">链接类型：</label>
                            <select class="cus-input" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label  class="label-name" for="">单　　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label class="label-name" for="">列　　表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label class="label-name" for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==6">
                            <label class="label-name" for="">分　　类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label  class="label-name" for="">产品详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goods" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==37">
                            <label  class="label-name" for="">专家详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in expertList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==38">
                            <label  class="label-name" for="">专家分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in expertCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label  class="label-name" for="">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>

            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="4">
                <label>最新公告</label>
                <div class="input-group-box" style="margin-bottom: 20px;">
                    <label class="label-name">公告标题：</label>
                    <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="10" ng-model="noticeTitle">
                </div>
                <div class="service-manage" ng-repeat="notice in noticeTxt">
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                    <div class="edit-txt" style="padding: 10px 10px 0 0;">
                        <div class="input-group-box">
                            <label  class="label-name" for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-group-box">
                            <label  class="label-name" for="">链接到：</label>
                            <select class="cus-input" ng-model="notice.articleId" ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>

            <div class="service" data-right-edit data-id="6"  ui-sortable ng-model="journalInfo.journalList">
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label for="">标　题：</label>
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="5" ng-model="journalInfo.title">
                </div>
                <div class="service-manage" ng-repeat="journal in journalInfo.journalList">
                    <div class="delete" ng-click="delIndex('journalList',journal.index,'journalInfo')">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('journalList',journal.index,'journalInfo')" data-dom-id="upload-journal{{$index}}" id="upload-journal{{$index}}"  ng-src="{{journal.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="journal{{$index}}"  class="avatar-field bg-img" name="journal{{$index}}" ng-value="journal.imgsrc"/>
                        </div>
                    </div>
                    <p class="tips" style="text-align:center">图片建议尺寸:200px*200px</p>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="journal.name">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">简　介：</label>
                            <input type="text" class="cus-input" ng-model="journal.brief">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="journal.articleId" ng-options="x.id as x.title for x in articles"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewJournal()"></div>
            </div>
            <div class="journalpart" data-right-edit data-id="7">
                <label style="width: 100%;">标题</label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="teamTitle">
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
        $scope.headerTitle    = '<{$tpl['ari_title']}>';
        $scope.sizes = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.color          = '<{$tpl['ari_font_color']}>' ? '<{$tpl['ari_font_color']}>' : '#000000';
        $scope.fontSize       = '<{$tpl['ari_font_size']}>' ? '<{$tpl['ari_font_size']}>' : '14';
        $scope.teamImg      = '<{$tpl['ari_index_team_img']}>'
        $scope.banners        = <{$slide}>;
        $scope.tpl_id         = '<{$tpl['ari_tpl_id']}>';
        $scope.storeList      = <{$storeList}>;
        $scope.noticeTitle    = '<{$tpl['ari_notice_title']}>'?'<{$tpl['ari_notice_title']}>':'美丽头条';
        $scope.kefu            = '<{$tpl['ari_kefu']}>';
        $scope.goods          = <{$goods}>;
        $scope.fenleiNavs     = <{$shortcut}>;
        $scope.articles        =  <{$information}>;
        $scope.noticeTxt = <{$noticeList}>;
        $scope.category  = <{$category}>;
        $scope.expertCategory  = <{$expertCategory}>;
        $scope.expertList = <{$expertList}>;
        $scope.teamTitle  = '<{$tpl['ari_team_title']}>'?'<{$tpl['ari_team_title']}>':'专家团队';
        $scope.jumpList = <{$jumpList}>;
        $scope.journalInfo = {
                title:'<{$tpl['ari_journal_title']}>' ? '<{$tpl['ari_journal_title']}>' : '案例标题',
                journalList:<{$journalList}>
    };
        $scope.activityList     = [
            {
                index: "<{$navList[0]['index']}>" ? "<{$navList[0]['index']}>" : 0,
                imgsrc: "<{$navList[0]['imgsrc']}>" ? "<{$navList[0]['imgsrc']}>" : "/public/manage/img/zhanwei/zw_fxb_334_426.png",
                link: '<{$navList[0]['link']}>'?'<{$navList[0]['link']}>':0,
                linkTitle: '<{$navList[0]['linkTitle']}>'?'<{$navList[0]['linkTitle']}>':'',
                type : '<{$navList[0]['type']}>'?'<{$navList[0]['type']}>':'5'
            },
            {
                index: '<{$navList[1]['index']}>'?'<{$navList[1]['index']}>':1,
                imgsrc: '<{$navList[1]['imgsrc']}>'?'<{$navList[1]['imgsrc']}>':'/public/manage/img/zhanwei/zw_fxb_485_260.png',
                link: '<{$navList[1]['link']}>'?'<{$navList[1]['link']}>':0,
                linkTitle: '<{$navList[1]['linkTitle']}>'?'<{$navList[1]['linkTitle']}>':'',
                type : '<{$navList[1]['type']}>'?'<{$navList[0]['type']}>':'5'
            },
            {
                index: '<{$navList[2]['index']}>'?'<{$navList[2]['index']}>':2,
                imgsrc: '<{$navList[2]['imgsrc']}>'?'<{$navList[2]['imgsrc']}>':'/public/manage/img/zhanwei/zw_fxb_485_260.png',
                link: '<{$navList[2]['link']}>'?'<{$navList[2]['link']}>':0,
                linkTitle: '<{$navList[2]['linkTitle']}>'?'<{$navList[2]['linkTitle']}>':'',
                type : '<{$navList[1]['type']}>'?'<{$navList[1]['type']}>':'5'
            },
        ];
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;

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

        $scope.addNotice = function(){
            var notice_length = $scope.noticeTxt.length;
            var defaultIndex = 0;
            if(notice_length>0){
                for (var i=0;i<notice_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.noticeTxt[i].index)){
                        defaultIndex = parseInt($scope.noticeTxt[i].index);
                    }
                }
                defaultIndex++;
            }
            if(notice_length>=5){
                layer.msg("最多只能添加5条公告哦~");
            }else{
                var notice_Default = {
                    index: defaultIndex,
                    title: '默认公告标题',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.noticeTxt.push(notice_Default);
            }

            console.log($scope.noticeTxt);
        }

        /*删除元素*/
        $scope.delIndex=function(type,index,parentType){
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

        /*添加资讯活动方法*/
        $scope.addNewJournal = function(){
            var journalList_length = $scope.journalInfo.journalList.length;
            var defaultIndex = 0;
            if(journalList_length>0){
                for (var i=0;i<journalList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.journalInfo.journalList[i].index)){
                        defaultIndex = parseInt($scope.journalInfo.journalList[i].index);
                    }
                }
                defaultIndex++;
            }
            if(journalList_length>=6){
                layer.msg("首页最多只能添加6个哦~");
            }else{
                var journalList_Default = {
                    index: defaultIndex,
                    name: '名称',
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    intro:'简介',
                    articleTitle:'',
                    articleId:''
                };
                console.log(journalList_Default);
                $scope.journalInfo.journalList.push(journalList_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.journalInfo);
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

            var fenleiNav_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                title: '默认标题',
                articleTitle: '',
                articleId: '',
                type : '6',
                link : ''
            };
            $scope.fenleiNavs.push(fenleiNav_Default);
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
            var category = $scope.category;
            var curId = '';
            for(var i in category){
                if(category[i].name == title){
                    curId = category[i].id;
                }
            }
            $scope.fenleiNavs[realIndex].articleId = curId;
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
                'teamImg'      : $scope.teamImg,
                'tpl_id'	      : $scope.tpl_id,
                'shortcut'        : $scope.fenleiNavs,
                'notice'        : $scope.noticeTxt,
                'activityList'   : $scope.activityList,
                'color'      : $scope.color,
                'fontSize'   : $scope.fontSize,
                'noticeTitle': $scope.noticeTitle,
                'journalTitle':$scope.journalInfo.title,
                'journalList':$scope.journalInfo.journalList,
                'teamTitle' : $scope.teamTitle,
                'kefu' : $scope.kefu
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/reservation/saveAppletTpl',
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
                $scope.teamImg = imgNowsrc;
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