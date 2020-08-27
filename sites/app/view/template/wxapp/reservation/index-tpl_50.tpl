<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp10001/css/index.css?8">
<link rel="stylesheet" href="/public/wxapp/index/temp10001/css/style.css?7">
<style>
    .banner-box .search-wrap {
        position: absolute;
        width: 100%;
        left: 0;
        top: 0;
        padding: 140px 12px 0 12px;
        box-sizing: border-box;
        z-index: 1;
    }
    .banner-box .search-container {
        border-radius: 20px;
        width: 96%;
        margin: 0 auto;
        padding: 5px 0;
        box-sizing: border-box;
        /* background-color: rgba(255, 255, 255, 0.6);*/
        background-color:#fff;
        text-align: center;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }
    .banner-box .search-wrap img {
        /* height: 18px;*/
        width:5%;
        display: inline-block;
        vertical-align: middle;
        margin-right: 5px;
    }
    .banner-box .search-wrap p {
        display: inline-block;
        vertical-align: middle;
        color: #fff;
        font-size: 14px;
    }

    .banner-box .search-container {
        border-radius: 6px;
        width: 96%;
        margin: 0 auto;
        padding: 5px 0;
        box-sizing: border-box;
        /* background-color: rgba(255, 255, 255, 0.6); */
        background-color: #fff;
        text-align: left;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }
    .service-wrap .courseName span{
        display: inline-block;
        margin-left:5px;
        font-size:14px;
    }
    .banner-manage .input-group-box label{
        width: 17% !important;
    }
    .fenleinav-manage .input-group-box label{
        min-width: 70px;
    }
    .banner-manage .input-group-box .cus-input{
         width: 82% !important;
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
                    <div class="service-wrap" data-left-preview data-id="8">
                        <div class="title-name courseName" style="text-align: center;color: cornflowerblue;background: #fff;font-size: 16px;overflow: hidden">
                            <span ng-class="{'active':$first}" ng-repeat="courseName in category">{{courseName.name}}</span>
                            <span class="no-data-tip" ng-if="category.length<=0">请在分类处配置</span>
                        </div>
                    </div>
                    <div class="banner-box" data-left-preview data-id="1">
                        <!--<div class="search-wrap">
                            <div class="search-container">
                                <img src="/public/wxapp/mall/temp3/images/ydhw-ss.png" style="margin-left: 5px;color: green;"/>
                                <p style="color: #333;margin-top: 3px;font-size: 15px">{{searchPlaceholder}}</p>
                            </div>
                        </div>-->
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
                        <ul ng-if="fenleiNavs.length>0" style="padding-top: 20px;">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                    <p ng-bind="fenleiNav.articleTitle" style="font-size:10px"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--精选理财-->

                    <!--热销产品-->
                    <div class="service-wrap" data-left-preview data-id="3">
                        <div class="title-name">
                            <span>{{journalInfo.title}}</span>
                        </div>
                        <div class="no-data-tip" ng-if="journalInfo.journalList<=0">点此添加内容~</div>
                        <div class="service-list">
                            <div class="service-item"  ng-repeat="journal in journalInfo.journalList">
                                <img ng-src="{{journal.imgsrc}}" />
                            </div>
                        </div>
                    </div>

                    <!--全部产品-->
                    <div class="service-wrap" data-left-preview data-id="7">
                        <div class="title-name" style="text-align: center;color: cornflowerblue;background: #fff;font-size: 16px;">
                            {{teamTitle}}
                        </div>
                        <div class="no-data-tip" >此处为教师内容展示，请到相关管理页面添加~</div>
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
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label>幻灯管理<span>（建议尺寸430*200）</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px;">搜索文本：</label>
                    <input type="text" class="cus-input" placeholder="请输入搜索提示内容" maxlength="10" ng-model="searchPlaceholder">
                </div>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <!--<div class="input-group clearfix">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('banners',banner.index,banner.articleTitle)"></select>
                    </div>-->
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
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航<span>(分类首页最多展示4个，其它滑动展示，图标尺寸200*200)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group clearfix">
                            <label for="">标　　题：</label>
                            <input type="text" maxlength="5" ng-model="fenleiNav.title">
                        </div>
                        <div class="input-group clearfix">
                            <label for="">副标题：</label>
                            <input type="text" maxlength="8" ng-model="fenleiNav.articleTitle">
                        </div>
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
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==6">
                            <label for="">分类列表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">产品详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goods"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==19">
                            <label for="">服务详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in serviceArticles"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==37">
                            <label for="">专家详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in expertList"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==38">
                            <label for="">专家分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in expertCategory"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label  class="label-name" for="">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <!--热销产品-->
            <div class="service" data-right-edit data-id="3"  ui-sortable ng-model="journalInfo.journalList">
                <span>首页最多展示2个，其它滑动展示</span>
                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="">标题</label>
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="5" ng-model="journalInfo.title">
                </div>
                <div class="service-manage" ng-repeat="journal in journalInfo.journalList">
                    <div class="delete" ng-click="delIndex('journalList',journal.index,'journalInfo')">×</div>
                    <div class="edit-img">
                        <div style="text-align: center">
                            <img onclick="toUpload(this)"  data-limit="1000" onload="changeSrc(this)" data-width="280" data-height="180" imageonload="doThis('journalInfo.journalList',journal.index)" data-dom-id="upload-service{{$index}}" id="upload-service{{$index}}"  ng-src="{{journal.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="service{{$index}}"  class="avatar-field bg-img" name="service{{$index}}" ng-value="journal.imgsrc"/>
                        </div>
                    </div>
                    <p class="tips" style="text-align:center">图片建议尺寸:280px*180px</p>
                    <div class="edit-txt">
                        <div class="input-group">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="journal.articleId" ng-options="x.id as x.title for x in articles" ng-change="getServiceId('journalList',journal.index,journal.articleTitle,'journalInfo')"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewservice()"></div>
            </div>
            <!--全部产品-->
            <div class="journalpart" data-right-edit data-id="7">
                <label style="width: 100%;">标题</label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="teamTitle">
                </div>
            </div>
            <div class="journalpart" data-right-edit data-id="8">
                <label style="width: 100%;">请在相关页面配置</label>
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
<!--<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>-->

<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle    = '<{$tpl['ari_title']}>';
        $scope.sizes          = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.color          = '<{$tpl['ari_font_color']}>' ? '<{$tpl['ari_font_color']}>' : '#000000';
        $scope.fontSize       = '<{$tpl['ari_font_size']}>' ? '<{$tpl['ari_font_size']}>' : '14';
        $scope.teamImg        = '<{$tpl['ari_index_team_img']}>';
        $scope.searchPlaceholder = '<{$tpl['ari_search_tip']}>';
        $scope.banners        =  <{$slide}>;
        $scope.tpl_id         = '<{$tpl['ari_tpl_id']}>';
        $scope.storeList      =  <{$storeList}>;
        $scope.noticeTitle    = '<{$tpl['ari_notice_title']}>'?'<{$tpl['ari_notice_title']}>':'美丽头条';
        $scope.kefu           = '<{$tpl['ari_kefu']}>';
        $scope.goods          =  <{$goods}>;
        $scope.fenleiNavs     =  <{$shortcut}>;
        $scope.articles       =  <{$information}>;
        $scope.noticeTxt      =  <{$noticeList}>;
        $scope.category       =  <{$category}>;
        $scope.expertList = <{$expertList}>;
        $scope.expertCategory = <{$expertCategory}>;
        $scope.teamTitle   = '<{$tpl['ari_team_title']}>'?'<{$tpl['ari_team_title']}>':'专家团队';
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
            if(fenleiNav_length>=2){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加2个分类哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    articleTitle:'默认副标题',
                    /*articleTitle:$scope.articles.length > 0 ? $scope.articles[0].title : '',*/
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

        $scope.doThis=function(type,index){
            var typeArr = type.split('.');
            var realIndex=-1;
            /*获取要删除的真正索引*/
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            if(typeArr.length>1){
                realIndex = $scope.getRealIndex($scope[typeArr[0]][typeArr[1]],index);
                $scope[typeArr[0]][typeArr[1]][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[typeArr[0]],index);
                $scope[typeArr[0]][realIndex].imgsrc = imgNowsrc;
            }
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
                    imgsrc: '/public/wxapp/images/banner.jpg',
                    link: ''
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
    /*添加服务方法*/
    $scope.addNewservice = function(){
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
                console.log($scope[parentType][type])
            }else{
                $scope[type][realIndex].articleId = curId;
                console.log($scope[type])
            }
        };

        // 选择服务
        $scope.getServiceId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var serviceArticles = $scope.serviceArticles;
            var curId = '';
            for(var i = 0;i < serviceArticles.length;i++){
                if(serviceArticles[i].title == title){
                    curId = serviceArticles[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
                console.log($scope[parentType][type])
            }else{
                $scope[type][realIndex].articleId = curId;
                console.log($scope[type])
            }
        };
        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	     : $scope.headerTitle,
                'slide'		     : $scope.banners,
                'teamImg'        : $scope.teamImg,
                'tpl_id'	     : $scope.tpl_id,
                'shortcut'       : $scope.fenleiNavs,
                'notice'         : $scope.noticeTxt,
                'activityList'   : $scope.activityList,
                'color'      : $scope.color,
                'fontSize'   : $scope.fontSize,
                'noticeTitle': $scope.noticeTitle,
                'journalTitle':$scope.journalInfo.title,
                'journalList' :$scope.journalInfo.journalList,
                'teamTitle'   : $scope.teamTitle,
                'kefu'        : $scope.kefu,
                'searchTip'   : $scope.searchPlaceholder
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