<link rel="stylesheet" href="/public/manage/shopfixture/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/manage/applet/temp2/css/index.css">
<link rel="stylesheet" href="/public/manage/applet/temp2/css/style.css">
<style>
    .input-group .form-control {
        width: 77%;
        margin-bottom: 0;
    }
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
                    <div class="shop-intro" data-left-preview data-id="1">
                        <img ng-src="{{shopintrobg}}" alt="商铺图">
                        <div class="shop-name">
                            <a href="#" class="logo"><img src="<{if $shop && $shop['s_logo']}><{$shop['s_logo']}><{else}>/public/manage/applet/temp2/images/sy_20.png<{/if}>" alt="logo"></a>
                            <span class="name"><{$shop['s_name']}></span>
                        </div>
                        <div class="menu-wrap">
                            <div class="menu-item">
                                <img src="/public/manage/applet/temp2/images/icon_menu_sy.png" />
                                <span>首页</span>
                            </div>
                            <div class="menu-item">
                                <img src="/public/manage/applet/temp2/images/icon_menu_qbsp.png" />
                                <span>全部商品</span>
                            </div>
                            <div class="menu-item">
                                <img src="/public/manage/applet/temp2/images/icon_menu_cxsp.png" />
                                <span>促销商品</span>
                            </div>
                            <div class="menu-item">
                                <img src="/public/manage/applet/temp2/images/icon_menu_dpgg.png" />
                                <span>店铺公告</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="banner-box" data-left-preview data-id="2">
                        <div class="search-wrap">
                            <img src="/public/manage/applet/temp2/images/icon_search.png"/>
                            <span>在店内搜索</span>
                        </div>
                        <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="pagination">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>



                    <div class="address-show flex-wrap" data-left-preview data-id="3">
                        <span class="flex-con">{{address.address}}</span>
                        <img src="/public/manage/applet/temp2/images/icon_dw.png" />
                    </div>

                    <div class="fenlei-nav" data-left-preview data-id="4">
                        <h4>推荐分类</h4>
                        <ul>
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p>{{fenleiNav.title}}</p>
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
                    <div class="hot-product" data-left-preview data-id="5">
                        <input type="hidden" ng-value="proShowstyle">
                        <div class="title">
                            <span>推荐宝贝</span>
                        </div>
                        <div class="goods-show">
                            <div class="goods-view1">
                                <ul>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp2/images/goodsView1.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥<b>9999</b></p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp2/images/goodsView2.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥<b>9999</b></p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:;">
                                            <img src="/public/manage/applet/temp2/images/goodsView3.jpg" alt="商品">
                                            <div class="intro">
                                                <h4>此处显示商品名称</h4>
                                                <p class="price">￥<b>9999</b></p>
                                                <span class="buy-btn">购买</span>
                                            </div>
                                        </a>
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
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="shopintrobg" data-right-edit data-id="1">
                <label>背景图</label>
                <div class="shopintrobg-manage cropper-box" data-width="750" data-height="400" >
                    <img ng-src="{{shopintrobg}}" onload="changeSrc(this)"  imageonload="changeBg()"  alt="商铺图">
                    <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*400)</span></a>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="2" ng-model="banners">
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
            <div class="address" data-right-edit data-id="3">
                <label>地址管理</label>
                <div class="address-manage">
                    <div class="input-group">
                        <label for="">地址经度</label><span style="float: right"><a href="http://www.gpsspg.com/maps.htm" target="_blank" style="color: blue">获取经纬度（请填写腾讯地图的经纬度）</a></span>
                        <input placeholder="请输入地址经度" maxlength="10" ng-model="address.longitude" type="text">
                    </div>
                    <div class="input-group">
                        <label for="">地址纬度</label>
                        <input placeholder="请输入地址纬度" maxlength="10" ng-model="address.latitude" type="text">
                    </div>
                    <div class="input-group">
                        <label for="">详细地址</label>
                        <textarea rows="3" placeholder="请输入详细地址" ng-model="address.address"></textarea>
                    </div>
                </div>
            </div>
            <div class="fenleinav" data-right-edit data-id="4" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">分类导航<span>(分类多于4个时手机端可横向滑动，管理界面不做展示)</span></label>
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
                            <div class="input-group clearfix">
                                <label for="">标　题：</label>
                                <input type="text" maxlength="5" ng-model="fenleiNav.title">
                                <!--<select class="form-control" ng-model="fenleiNav.title" ng-options="x.name as x.name for x in category" ng-change="getId(fenleiNav.index,fenleiNav.title)"></select>-->
                            </div>
                            <div class="input-group clearfix">
                                <label for="">链接类型：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==1">
                                <label for="">资讯详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==2">
                                <label for="">列　　表：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==3">
                                <label for="">外　　链：</label>
                                <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==4">
                                <label for="">分组详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==9">
                                <label for="">分类详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==5">
                                <label for="">商品详情：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                            </div>
                            <div class="input-group clearfix" ng-show="fenleiNav.type==46">
                                <label for="">付费预约：</label>
                                <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in appointmentGoodsList" ></select>
                            </div>
                            <!-- 一级分类选择 -->
                            <div class="input-group clearfix" ng-show="fenleiNav.type==23">
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
            <div class="goodsShow" data-right-edit data-id="5">
                <label>列表样式</label>
                <div class="goods-show-manage">
                    <div class="radio-box showstyle-radio">
                        <input type="hidden" ng-value="proShowstyle" ng-model="proShowstyle">
                        <span ng-click="changeShowStyle($event)" data-id="1">
								<input type="radio" name="goods-show" id="showstyle1">
								<label for="showstyle1">大图</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="2">
								<input type="radio" name="goods-show" id="showstyle2">
								<label for="showstyle2">小图</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="3">
								<input type="radio" name="goods-show" id="showstyle3">
								<label for="showstyle3">一大两小</label>
							</span>
                        <span ng-click="changeShowStyle($event)" data-id="4">
								<input type="radio" name="goods-show" id="showstyle4">
								<label for="showstyle4">详细列表</label>
							</span>
                    </div>
                </div>
            </div>

            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="7">
                <label>最新公告</label>
                <div class="edit-con" style="margin-bottom: 4px;margin-top: 2px">
                    <div class="activity link-setting" style="display:block;">
                <span class='tg-list-item'>
						是否启用头条公告功能
                     <input class='tgl tgl-light' id='audit_status' type='checkbox' onchange="changeAuditStatus('<{$tpl['ami_id']}>')" <{if $tpl && $tpl['ami_notice_status'] == 1}>checked<{/if}> >
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
        $scope.headerTitle= "<{$tpl['ami_title']}>";
        $scope.shopintrobg = "<{$tpl['ami_head_img']}>";
        $scope.banners = <{$slide}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.proShowstyle = '<{$tpl['ami_goods_list']}>';
        $scope.tpl_id		= '<{$tpl['ami_tpl_id']}>';
        $scope.category  = <{$goodsGroup}>;
        $scope.kindSelect = <{$kindSelect}>;
        $scope.firstKindSelect = <{$firstKindSelect}>;
        $scope.appointmentGoodsList = <{$appointmentGoodsList}>;
        $scope.goodsList = <{$goodsList}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitList = <{$limitList}>;
        $scope.bargainList = <{$bargainList}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.address = {
            address: '<{$tpl['ami_address']}>' ? '<{$tpl['ami_address']}>' : '请输入店铺所在准确地址',
            longitude: '<{$tpl['ami_lng']}>' ? '<{$tpl['ami_lng']}>' : '请输入地址的准确经度',
            latitude: '<{$tpl['ami_lat']}>' ? '<{$tpl['ami_lat']}>' : '请输入地址的准确维度'
        };
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
        $scope.informationCategory = <{$infocateList}>;
        $scope.pages                =  <{$page_list}>;



        $scope.noticeTitle    = '<{$tpl['ami_notice_title']}>'?'<{$tpl['ami_notice_title']}>':'今日头条';
        $scope.noticeTxt      = <{$information}>;
        $scope.sizes          = [{ id: '10', name:'10px'}, { id: '12', name:'12px'},{ id: '14', name:'14px'},{ id: '16', name:'16px'},{ id: '18', name:'18px'},{ id: '20', name:'20px'},{ id: '22', name:'22px'}];
        $scope.color          = '<{$tpl['ami_notice_color']}>' ? '<{$tpl['ami_notice_color']}>' : '#000000';
        $scope.fontSize       = '<{$tpl['ami_notice_size']}>' ? '<{$tpl['ami_notice_size']}>' : '16';

        $scope.sortableOptions = {
            update: function(e, ui) {
                setTimeout(function () {
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
            var category_length = $scope.category.length;
            if(category_length < 1){
                layer.msg("请先添加商品分组");
                return;
            }
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


            if(fenleiNav_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: $scope.category[0].name,
                    articleId: $scope.category[0].id,
                    link : $scope.category[0].id,
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
        $scope.getId = function(index,title){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope.fenleiNavs,index);
            var category = $scope.category;
            var curId = '';
            for(var i = 0;i < category.length;i++){
                if(category[i].name == title){
                    curId = category[i].id;
                }
            }
            $scope.fenleiNavs[realIndex].articleId = curId;
            console.log($scope.fenleiNavs)
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
                $scope.shopintrobg = imgNowsrc;
            }
        };


        $scope.changeShowStyle=function($event){
            $event.preventDefault();
            var that =$($event.target).prev('input:eq(0)');
            var index = $($event.target).parent('span').data('id');
            console.log(index);
            that.get(0).checked=true;

            var styleDiv = $(".index-main").find(".hot-product").find(".goods-show>div");
            var curClass = styleDiv.attr("class");
            styleDiv.removeClass(curClass).addClass('goods-view'+index);
            $scope.proShowstyle = index;

        }
        /*遍历添加对应列表展示样式*/
        $scope.initListShow = function(){
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
            $scope.initListShow();
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
                'title' 	 : $scope.headerTitle,
                'head_img'   : $scope.shopintrobg,
                'slide'		 : $scope.banners,
                'shortcut'	 : $scope.fenleiNavs,
                'tpl_id'	 : $scope.tpl_id,
                'list_type'  : $scope.proShowstyle,
                'address'    : $scope.address.address,
                'longitude'  : $scope.address.longitude,
                'latitude'   : $scope.address.latitude,
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
<{include file="../img-upload-modal.tpl"}>