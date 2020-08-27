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
    .goods-part .good{
        width: 100% !important;
    }
    .goods-part .good img{
        width: 30% !important;
        float: left;
    }
    .fenlei-nav li span{
        color:#000000 !important;
        height: 40px;
        width: 60px;
        font-size: 14px;
        line-height: 40px;
    }
    .intro-box{
        overflow:hidden;
        text-overflow:ellipsis;
        display:-webkit-box;
        -webkit-box-orient:vertical;
        -webkit-line-clamp:2;
        max-height: 50px;
    }
</style>
<{include file="../../manage/article-kind-editor.tpl"}>
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
                    <!--<div class="fenlei-nav" data-left-preview data-id="2" style="background-color:#fff">
                        <div class="contact-item flex-wrap">
                            <div class="label-name" style="padding: 5px 0 0 10px;">{{serviceTitle}}</div>
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
                    </div>-->
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <ul class="border-t border-b" style="white-space: normal;">
                            <li ng-if="nav.open" ng-repeat="nav in navList">
                                <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                <span>{{nav.title}}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- 公告 -->
                    <!--<div class="notice-box" data-left-preview data-id="7">
                        <img src="/public/wxapp/appointment/images/general_reservation_notable.png" class="noticeicon" alt="图标">
                        <div style="display: inline-block;font-size: 18px;width: 40px;float:left;margin:0 5px;color: #FC7C7C;margin-top: -2px">{{noticeTitle}}</div>
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>-->

                    <div class="notice-box" data-left-preview data-id="7">
                        <div class="act-box" ng-repeat="activity in activityList">
                            <img src="/public/wxapp/meal/images/new.png" ng-if="$index==0" class="noticeicon" alt="图标">
                            <img src="/public/wxapp/meal/images/discount.png" ng-if="$index==1" class="noticeicon" alt="图标">
                            <img src="/public/wxapp/meal/images/notice.png" ng-if="$index==2" class="noticeicon" alt="图标">
                            <div class="notice-txt">
                                <p>{{activity.amf_name}}</p>
                            </div>
                        </div>
                    </div>

                    <div data-left-preview data-id="3">
                        <img ng-src="{{couponBackground}}" alt="" style="width: 100%;margin-top: 5px;position: relative;" />
                    </div>
                    <!--团队介绍-->
                    <div class="service-wrap" data-left-preview data-id="4">
                        <div class="title-name" style="margin-bottom: 10px;height: 30px">
                            <span style="color: #333;text-align: left;width: 100%;padding-left: 10px">{{introTitle}}</span>
                        </div>
                        <div class="active-list">
                            <div class="cooperative-wrap" style="padding: 0 10px">
                                <img ng-src='{{introImg}}' style="width: 100%;" />
                                <!--<div style="text-indent: 2em" class="intro-box">{{intro}}</div>-->
                            </div>
                        </div>
                    </div>
                    <div class="goods-part recommend" data-left-preview data-id="5">
                        <div class="title" style="text-align: left;font-size: 18px;margin-top: 10px;padding-left: 10px">{{recommendTitle}}</div>
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
                        <div class="title" style="text-align: left;font-size: 16px;padding-left: 10px">{{listTitle}}</div>
                        <div class="good" ng-repeat="store in storeList">
                            <div class="good-box">
                                <img src="{{store.es_logo}}" alt="" class="good-cover">
                                <div class="good-name text">{{store.es_name}}</div>
                                <div class="good-address text">{{store.ams_address}}</div>
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
                    <!--<div class="input-group-box">
                        <label class="label-name">付费取消提示：</label>
                        <textarea type="text" class="cus-input" placeholder="请输入提示内容" maxlength="120" ng-model="cancelPrompt" style="height: 100px"></textarea>
                    </div>-->
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
            <!--更多服务-->
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航</label>
                <div class="fenleinav-manage">
                    <div class="isOn">
                        <div class="open">
                            <span>开启预订:</span>
                            <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='navList0_start' type='checkbox' ng-model="navList[0].open">
                            <label class='tgl-btn' for='navList0_start'></label>
                            </span>
                        </div>
                        <div class="title" ng-show="navList[0].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[0].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[0].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('navList',0)" data-dom-id="upload-navList0" id="upload-navList0"  ng-src="{{navList[0].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList0"  class="avatar-field bg-img" name="navList0" ng-value="navList[0].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="isOn">
                        <div class="open">
                        <span>开启堂食:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList1_start' type='checkbox' ng-model="navList[1].open">
                        <label class='tgl-btn' for='navList1_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[1].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[1].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[1].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',1)" data-dom-id="upload-navList1" id="upload-navList1"  ng-src="{{navList[1].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList1"  class="avatar-field bg-img" name="navList1" ng-value="navList[1].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="isOn">
                        <div class="open">
                        <span>开启外卖:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList2_start' type='checkbox' ng-model="navList[2].open">
                        <label class='tgl-btn' for='navList2_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[2].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[2].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[2].open">
                            <div class="edit-img">
                                <div  style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',2)" data-dom-id="upload-navList2" id="upload-navList2"  ng-src="{{navList[2].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList2"  class="avatar-field bg-img" name="navList2" ng-value="navList[2].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="isOn">
                        <div class="open">
                        <span>开启优惠券:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList3_start' type='checkbox' ng-model="navList[3].open">
                        <label class='tgl-btn' for='navList3_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[3].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[3].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[3].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',3)" data-dom-id="upload-navList3" id="upload-navList3"  ng-src="{{navList[3].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList3"  class="avatar-field bg-img" name="navList3" ng-value="navList[3].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="">外卖页顶部图片：</label>
                        <div class="headImg-manage"  style="height:100%;width: 100%">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav1()" data-dom-id="upload-nav1HeadImg" id="upload-nav1HeadImg"  ng-src="{{nav1HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':nav1HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav1HeadImg"  class="avatar-field bg-img" name="nav1HeadImg" ng-value="nav1HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>
                    <div>
                        <label for="">堂食页顶部图片：</label>
                        <div class="headImg-manage"   style="height:100%;width: 100%">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav2()" data-dom-id="upload-nav2HeadImg" id="upload-nav2HeadImg"  ng-src="{{nav2HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':nav2HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav2HeadImg"  class="avatar-field bg-img" name="nav2HeadImg" ng-value="nav2HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>
                    <div>
                        <label for="">预约页顶部图片：</label>
                        <div class="headImg-manage">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav3()" data-dom-id="upload-nav3HeadImg" id="upload-nav3HeadImg"  ng-src="{{nav3HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':nav3HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav3HeadImg"  class="avatar-field bg-img" name="nav3HeadImg" ng-value="nav3HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="banner" data-right-edit data-id="3">
                <label style="width: auto;font-weight: normal;">优惠券入口背景图</label>
                <div class="shopintrobg-manage">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="706" data-height="130" imageonload="changeBg()" data-dom-id="upload-coopera" id="upload-coopera"  ng-src="{{couponBackground}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="coopera"  class="avatar-field bg-img" name="coopera" ng-value="couponBackground"/>
                    <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="200" data-dom-id="upload-coopera">修改图片<span>(建议尺寸706*130)</span></a>
                </div>
            </div>
            <!-- 公告管理 -->
                    <!--<div class="notice" data-right-edit data-id="7">
                        <label>公告</label>
                        <div class="service-manage" ng-repeat="notice in noticeTxt">
                            <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                            <div class="edit-txt">
                                <div class="input-groups">
                                    <label for="">标　题：</label>
                                    <input type="text" class="cus-input" ng-model="notice.title">
                                </div>
                                <!--
                                <div class="input-groups">
                                    <label for="">链接到：</label>
                                    <select class="cus-input" ng-model="notice.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('noticeTxt',notice.index,notice.articleTitle)"></select>
                                </div>
                                -->
                            <!--</div>
                        </div>
                        <div class="add-box" title="添加" ng-click="addNotice()"></div>
                    </div>-->
                    <div class="notice" data-right-edit data-id="7">
                <label style="width: 100%">店铺活动</label>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处活动为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div>

            <!--团队展示-->
            <div class="service" data-right-edit data-id="4">
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <div class="open">
                        <span>开启商家介绍：</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='intro_open' type='checkbox'  <{if $tpl && $tpl['ami_intro_open'] == 1}>checked<{/if}>>
                        <label class='tgl-btn' for='intro_open'></label>
                        </span>
                        </div>
                </div>
                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="">标题：</label>
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="15" ng-model="introTitle">
                </div>

                <div class="input-group-box" style="margin-bottom: 10px;">
                      <label style="width: auto;font-weight: normal;">图片：</label>
                    <div class="shopintrobg-manage">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="changeInfo()" data-dom-id="upload-introImg" id="upload-introImg"  ng-src="{{introImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':introImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="introImg"  class="avatar-field bg-img" name="introImg" ng-value="introImg"/>
                    <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="300" data-dom-id="upload-introImg">修改图片<span>(建议尺寸750*300)</span></a>
                </div>
                    </div>
                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="">视频地址：</label>
                    <input type="text" class="cus-input" ng-model="videoUrl">
                </div>
                <div class="input-group" style="margin-bottom: 10px;">
                    <label for="" style="width: 100%">预支付金额（为防止恶意下单，现金支付的订单需预支一部分费用）：</label>
                    <input type='text' class="cus-input" ng-model="paymentMoney" placeholder="请输入预付金额">
                </div>
                 <div class="input-group-box" style="margin-bottom: 10px;">
                        <label for="">介绍：</label>
                <div>
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="intro" name="intro" placeholder="文章内容"  rows="10" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['ami_intro']}><{$tpl['ami_intro']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="intro" />
                    </div>
                </div>
                    </div>
            </div>

            <!--<div class="banner" data-right-edit data-id="5">
                <div class="input-groups">
                    <label class="label-name">标题名称：</label>
                    <input type="text" class="cus-input" placeholder="请输入标题" maxlength="10" ng-model="recommendTitle" style="margin-bottom:10px;">
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div> -->
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
        $scope.articles        = <{$information}>;
        $scope.headerTitle = '<{$tpl['ami_title']}>';
        $scope.cancelPrompt = '<{$tpl['ami_cancel_prompt']}>' ? '<{$tpl['ami_cancel_prompt']}>' : '';
        $scope.couponBackground = '<{$tpl['ami_coupon_img']}>' ? '<{$tpl['ami_coupon_img']}>' :'/public/wxapp/meal/images/coupon_706_130.png';
        $scope.banners     = <{$slide}>;
        $scope.tpl_id      = '<{$tpl['ami_tpl_id']}>';
        //$scope.storeList   = <{$storeList}>;
        //$scope.recommendTitle   = '<{$tpl['ami_recommed_title']}>' ? '<{$tpl['ami_recommed_title']}>' : '房间推荐';
        $scope.listTitle   = '<{$tpl['ami_list_title']}>' ? '<{$tpl['ami_list_title']}>' : '营业门店';
        $scope.navList = <{$navList}>;
        $scope.introTitle  = '<{$tpl['ami_intro_title']}>'?'<{$tpl['ami_intro_title']}>':'商家介绍';

        $scope.videoUrl    = '<{$tpl['ami_video_url']}>';
        $scope.paymentMoney  = '<{$tpl['ami_payment_money']}>' > 0 ? '<{$tpl['ami_payment_money']}>' : 0 ;
        $scope.introImg     = '<{$tpl['ami_intro_img']}>';
        $scope.logoShow = '<{$tpl['ami_logo_show']}>';
        //$scope.noticeTxt       = <{$noticeList}>;
        $scope.storeList   = <{$storeList}>;
        $scope.activityList = <{$activityList}>;
        $scope.nav1HeadImg='<{$tpl['ami_nav1_head_img']}>',
        $scope.nav2HeadImg='<{$tpl['ami_nav2_head_img']}>',
        $scope.nav3HeadImg='<{$tpl['ami_nav3_head_img']}>',
        // 是否开启外卖和堂食及预约
        $scope.outOn= '<{$tpl['ami_out_on']}>' > 0 ? true : false ,
        $scope.eatOn= '<{$tpl['ami_eat_on']}>' > 0 ? true : false ,
        $scope.appOn= '<{$tpl['ami_appo_on']}>' > 0 ? true : false ,
        // 是否开启外卖和堂食及预约
        $scope.outImg='<{$tpl['ami_out_img']}>' ? '<{$tpl['ami_out_img']}>' : '/public/wxapp/meal/images/out_img.png' ,
         $scope.eatImg='<{$tpl['ami_eat_img']}>' ? '<{$tpl['ami_eat_img']}>' : '/public/wxapp/meal/images/eat_img.png' ,
            $scope.appImg='<{$tpl['ami_appo_img']}>' ? '<{$tpl['ami_appo_img']}>' : '/public/wxapp/meal/images/app_img.png'

        console.log($scope.storeList);
        //$scope.categoryList = <{$categoryList}>;

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
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.headImg = imgNowsrc;
            }
        };
        $scope.changeInfo=function(){
            if(imgNowsrc){
                $scope.introImg = imgNowsrc;
            }
        };

        $scope.changeNav1=function(){
            if(imgNowsrc){
                $scope.nav1HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav2=function(){
            if(imgNowsrc){
                $scope.nav2HeadImg = imgNowsrc;
            }
        };

        $scope.changeNav3=function(){
            if(imgNowsrc){
                $scope.nav3HeadImg = imgNowsrc;
            }
        };
        // 外卖图标
        $scope.changeOutImg=function(){
            if(imgNowsrc){
                $scope.outImg = imgNowsrc;
            }
        };
        // 堂食图标
        $scope.changeEatImg=function(){
            if(imgNowsrc){
                $scope.eatImg = imgNowsrc;
            }
        };
        // 预约图标
        $scope.changeAppImg=function(){
            if(imgNowsrc){
                $scope.appImg = imgNowsrc;
            }
        };
        $scope.addNotice = function(){
            var notice_length = $scope.noticeTxt.length;
            var defaultIndex = 0;
            if(notice_length>0){
                for (var i=0;i<notice_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.noticeTxt[i].index)){
                        defaultIndex = $scope.noticeTxt[i].index;
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
            var chooseTable = $('#choose_table').is(':checked');
            var memberOpen = $('#member_open').is(':checked');
            var tradeOpen = $('#trade_open').is(':checked');
            var introOpen = $('#intro_open').is(':checked');
            var data = {
                'title' 	 : $scope.headerTitle,
                'slide'		 : $scope.banners,
                'tpl_id'	 : $scope.tpl_id,
                'couponBackground' : $scope.couponBackground,
                'listTitle'   : $scope.listTitle,
                'phone': $scope.mobile,
                'introTitle': $scope.introTitle,
                'videoUrl': $scope.videoUrl,
//                'intro'   : $scope.intro,
                'introImg' : $scope.introImg,
                'notice'         : $scope.noticeTxt,
                'outOn'     : $scope.outOn,
                'eatOn'     : $scope.eatOn,
                'appOn'     : $scope.appOn,
                'outImg'    : $scope.eatImg,
                'eatImg'    : $scope.eatImg,
                'appImg'    : $scope.appImg,
                'nav1HeadImg'   : $scope.nav1HeadImg,
                'nav2HeadImg'   : $scope.nav2HeadImg,
                'nav3HeadImg'   : $scope.nav3HeadImg,
                'navList'       : $scope.navList,
                'chooseTable'   : chooseTable ? 1 : 0,
                'introOpen'     : introOpen ? 1 : 0,
                'paymentMoney'  : $scope.paymentMoney,
                'logoShow'      : $scope.logoShow
                //'cancelPrompt' : $scope.cancelPrompt,
                //'recommendTitle': $scope.recommendTitle,
                //'address': $scope.address,
//                'service'      : $scope.fenleiNavs,
                //'lng': $scope.lng,
//                'lat': $scope.lat,
            };
            data.intro = $("#intro").val();
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/meal/saveAppletTplStore',
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