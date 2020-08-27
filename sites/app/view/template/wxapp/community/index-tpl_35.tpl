<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/community/template/temp1/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/community/template/temp1/css/style.css?3">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
    .fenleinav-manage { padding: 10px; background-color: #fff; border: 1px solid #e8e8e8; margin-top: 10px; }
    .goods-part .good .text { line-height: 1.5; overflow: hidden; white-space: nowrap; text-overflow: ellipsis }
    .index-con .index-main { position: relative; }
    .banner-manage { padding-bottom: 15px; }
    .fenleinav-manage .edit-img { width: 19%; }
    .fenleinav-manage .edit-txt { width: 80%; }
    .search-wrap { position: absolute; z-index: 2; width: 60%; background-color: rgba(0, 0, 0, 0); }
    .search-wrap p { color: #fff; }
    .search-container { background-color: rgba(0, 0, 0, .6); }
    .banner-wrap img { height: 170px; }
    .banner-wrap .paginations { bottom: 20px; }
    .fenlei-nav ul { width: 97%; margin: 0 auto; margin-top: -25px; position: relative; border-radius: 3px; margin-bottom: 6px; }

    .banner-chosen .chosen-container {
        width: 332px !important;
    }
    .fenleiNav-chosen .chosen-container{
        width: 279px !important;
    }

    .notice-chosen .chosen-container{
        width: 443px !important;
    }

    .chosen-container-multi .chosen-choices{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
    }
    .chosen-container-single .chosen-single{
        padding: 3px 5px 2px!important;
        border-radius: 4px;
        border: 1px solid #ccc;
        height: 34px;
        background: url();
        background-color: #fff;
    }
    .chosen-container-single .chosen-single span{
        margin-top: 2px;
    }
    .chosen-single div b:before{
        top:3px;
    }

    .chosen-results{
        width: 100%;
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
                    <div class="search-wrap" style="position: absolute;" data-left-preview data-id="1">
                        <div class="search-container">
                            <img src="/public/wxapp/mall/temp3/images/sousuo@2x.png" />
                            <p>{{searchPlaceholder}}</p>
                        </div>
                    </div>
                    <div class="banner-wrap" data-left-preview data-id="5">
                        <img src="/public/wxapp/community/images/slide.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
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

                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="3">
                        <img src="/public/wxapp/community/images/notice.png" class="noticeicon" alt="图标">
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>

                    <div class="new-activity" data-left-preview data-id="4" style="margin:10px 0">
                        <img src="/public/wxapp/community/images/nav.png" alt="" style="width: 100%">
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="8"  style="margin: 10px 0;">
                        <div class="no-data-tip" style="font-size: 20px;color: red">点此管理统计数据</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="9"  style="margin: 10px 0;">
                        <div class="no-data-tip" style="font-size: 20px;color: red">点此管理店铺入驻提醒</div>
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

            <div class="header-top" data-right-edit data-id="1">
                <label>搜索管理</label>
                <div class="top-manage">
                    <div class="input-group-box">
                        <label class="label-name">搜索文本：</label>
                        <input type="text" class="cus-input" placeholder="请输入搜索文本" maxlength="50" ng-model="searchPlaceholder">
                    </div>
                </div>
            </div>

            <div class="fenleinav fenleiNav-chosen" data-right-edit data-id="2" ui-sortable ng-model="fenleiNavs" style="">
                <label style="width: 100%">分类导航<span>(图标尺寸200*200)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs" style="overflow: visible;height: 160px">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input"  ng-model="fenleiNav.title">
                        </div>
                        <div class="input-group-box clearfix" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">链接类型：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">单　　页：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                            <!--
                            <select style="display: inline-block;width: 79%" class="cus-input selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                             -->
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">列　　表：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">外　　链：</label>
                            <input style="display: inline-block;width: 79%" type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="banner.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">商品详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==15" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">拼团详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==16" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">店铺分类：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==17" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">店铺详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==21" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">资讯分类：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in articlesSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==29" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">秒杀商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in limitlist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==30" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">拼团商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in groupList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==31" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">砍价商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106" style="margin-top: 10px;">
                            <label for="" style="display: inline-block;width: 20%">小 程 序：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==41">
                            <label for="">选择分组：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in plateformGroup" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==42">
                            <label for="">选择分组：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopGoodsGroup" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>

            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="3">
                <label>最新公告</label>
                <div class="service-manage notice-chosen" ng-repeat="notice in noticeTxt"   style="position:relative;background: #fff;padding: 10px;border-radius: 4px;margin-bottom: 8px">
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)" style="position: absolute;top: 0;right: 0">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input selectpicker chosen-select" ng-model="notice.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('noticeTxt',notice.index,notice.articleTitle)"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>

            <div class="coursepart" data-right-edit data-id="4">
                <div class="service-manage">
                    <div class="no-data-tip">固定链接，不可配置~</div>
                </div>
            </div>

            <div class="appoint" data-right-edit data-id="8">
                <div class="edit-txt">

                    <div class="input-groups">
                        <label for="">统计数据图标：</label>
                        <img onclick="toUpload(this)"  style="margin-top: 20px;width: 60px"  data-limit="1" onload="changeSrc(this)" data-width="100" data-height="100" imageonload="changeStatIcon()" data-dom-id="upload-statIcon" id="upload-statIcon"  ng-src="{{statIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="statIcon"  class="avatar-field bg-img" name="statIcon{{$index}}" ng-value="statIcon"/>
                    </div>

                    <div class="input-groups">
                        <label for="">浏览量：</label>
                        <input type="text" class="cus-input" ng-model="browseNum">
                    </div>
                    <div class="input-groups">
                        <label for="">发布量：</label>
                        <input type="text" class="cus-input" ng-model="issueNum">
                    </div>
                    <div class="input-groups">
                        <label for="">商家数量：</label>
                        <input type="text" class="cus-input" ng-model="shopNum">
                    </div>
                    <div class="input-groups">
                        <label for="">增加会员量（在真实会员数量的基础上，增加的会员显示数量）：</label>
                        <input type="text" class="cus-input" ng-model="addMemberNum">
                    </div>
                </div>
            </div>

            <div class="banner" data-right-edit data-id="5">
                <label>幻灯管理</label>
                <div class="banner-manage banner-chosen" ng-repeat="banner in banners" style="overflow: visible">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix" style="margin-top: 15px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">链接类型：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==1" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">单　　页：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==2" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">列　　表：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==3" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">外　　链：</label>
                            <input style="display: inline-block;width: 79%" type="text" class="cus-input form-control" ng-value="banner.link" ng-model="banner.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==5" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">商品详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==15" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">拼团详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==31" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">砍价商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in bargainList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==16" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">店铺分类：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==17" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">店铺详情：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==21" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">资讯分类：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in articlesSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==29" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">秒杀商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in limitlist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==30" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">拼团商品：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in groupList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="banner.type==106" style="margin-top: 10px;display: inline-block">
                            <label for="" style="display: inline-block;width: 20%">小 程 序：</label>
                            <select style="display: inline-block;width: 79%" class="cus-input form-control" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>

            <div class="appoint" data-right-edit data-id="9">
                <div class="fenleinav-manage">
                    <!--<div class="edit-img" style="width: 19%">
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" onload="changeSrc(this)" data-width="260" data-height="260" imageonload="changeApplyIcon()" data-dom-id="upload-applyIcon" id="upload-applyIcon"  ng-src="{{applyIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="applyIcon"  class="avatar-field bg-img" name="applyIcon{{$index}}" ng-value="applyIcon"/>
                        </div>
                    </div>-->
                    <div class="edit-txt" style="width:80%;">
                        <!--<div class="input-group clearfix">
                            <label for="" style="width: 17%;">标　题：</label>
                            <input type="text" maxlength="15" ng-model="applyTitle" style="width:83%;">
                        </div>
                        <div class="input-group clearfix">
                            <label for="" style="width: 17%;">标　签：</label>
                            <input type="text" maxlength="30" ng-model="applyDesc" style="width:83%;">
                        </div>-->
                        <div class="isOn">
                            <span>是否开启:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='apply_open' type='checkbox' ng-model="applyOpen">
                                <label class='tgl-btn' for='apply_open' style="float: right;margin-right: 57%;width: 60px;"></label>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.linkTypes      = <{$linkType}>;
        $scope.linkList       = <{$linkList}>;
        $scope.headerTitle    = '<{$tpl['aci_title']}>';
        $scope.banners        = <{$slide}>;
        $scope.tpl_id         = '<{$tpl['aci_tpl_id']}>';
        $scope.fenleiNavs     = <{$shortcut}>;
        $scope.articles        =  <{$information}>;
        $scope.searchPlaceholder = '<{$tpl['aci_search_tip']}>' ? '<{$tpl['aci_search_tip']}>' : '搜索好店、产品';
        $scope.noticeTxt = <{$noticeList}>;
        $scope.kindSelect = <{$kindSelect}>;
        $scope.goodsList = <{$goods}>;
        $scope.shoplist = <{$shoplist}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitlist = <{$limitList}>;
        $scope.articlesSelect = <{$categoryList}>;
        $scope.browseNum       = '<{$tpl['aci_browse_num']}>';
        $scope.issueNum        = '<{$tpl['aci_issue_num']}>';
        $scope.shopNum         = '<{$tpl['aci_shop_num']}>';
        $scope.addMemberNum    = '<{$tpl['aci_add_member']}>';
        $scope.statIcon        = '<{$tpl['aci_stat_icon']}>'?'<{$tpl['aci_stat_icon']}>':'/public/wxapp/customtpl/images/icon_tj.png';
        $scope.jumpList = <{$jumpList}>;
        $scope.plateformGroup = <{$plateformGroup}>;
        $scope.shopGoodsGroup = <{$shopGoodsGroup}>;
        $scope.bargainList          = <{$bargainList}>;
        $scope.applyOpen          = <{$tpl['aci_apply_open']}> > 0 ? true : false ;
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
                    imgsrc: '/public/wxapp/mall/temp3/images/banner_zhanwei.jpg',
                    articleId: ''
                };
                $scope.banners.push(banner_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                    addInitChosen();
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
                if($scope[type].length>0){
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }else{
                    layer.msg('请选择删除的内容');
                }
            });
        }

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
                    articleId:$scope.articles.length>0?$scope.articles[0].id:'',
                    type: 1
                };
                $scope.noticeTxt.push(notice_Default);
                $timeout(function(){
                    addInitChosen();
                },200);
            }
            console.log($scope.noticeTxt);
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
            };
            $scope.fenleiNavs.push(fenleiNav_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
                addInitChosen();
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
                'tpl_id'	      : $scope.tpl_id,
                'shortcut'       : $scope.fenleiNavs,
                'notice'        : $scope.noticeTxt,
                'browseNum'      : $scope.browseNum,
                'issueNum'       : $scope.issueNum,
                'shopNum'        : $scope.shopNum,
                'addMemberNum'   : $scope.addMemberNum,
                'statIcon'       : $scope.statIcon,
                'searchPlaceholder': $scope.searchPlaceholder,
                'applyOpen'      : $scope.applyOpen == true ? 1 : 0
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/community/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        // 选择文章
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var information = $scope.articles;
            var curId = '';
            for(var i = 0;i < information.length;i++){
                if(information[i].title == title){
                    curId = information[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
            }
        };


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

        $scope.changeStatIcon=function(){
            if(imgNowsrc){
                $scope.statIcon = imgNowsrc;
            }
        };

        $(function(){
            addInitChosen();

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

    function addInitChosen() {
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            placeholder_text_single : '请选择'
        });
    }
</script>
<{if $curr_shop['s_id']==5741}>
    <{include file="../img-upload-modal-gif.tpl"}>
<{else}>
    <{include file="../img-upload-modal.tpl"}>
<{/if}>