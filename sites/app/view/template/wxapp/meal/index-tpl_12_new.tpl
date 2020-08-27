<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/meal/temp1/css/style.css?3">
<style>

    .isOn {
        margin: 10px 0;
        position: relative;
        padding: 30px 0;
        border-bottom: 1px solid #eee;
        height: 120px;
    }

    .isOn .open{
        position: relative;
        top: -35px;
    }
    .isOn .tg-list-item{
        display: inline-block;
        position: relative;
        top: 10px;
    }
    .isOn .title{
        position: relative;
        top: -15px;
    }

    .isOn .title input{
        width: 200px;
        display: inline-block;
    }

    .fenleinav-manage .edit-img {
        margin-top: 20px;
    }

</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="shopInfo.headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <!-- 背景图 -->
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/wxapp/images/banner.jpg" style="height: 126px;" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="shop-name" ng-show="shopInfo.logoShow == 1">
                            <a href="#" class="logo" ><img src="<{if $shop && $shop['s_logo']}><{$shop['s_logo']}><{else}>/public/manage/applet/temp2/images/sy_20.png<{/if}>" alt="logo"></a>
                            <!--
                            <div class="shop-info">
                                <span class="name"><{$shop['s_name']}></span><br/>
                            </div>
                            -->
                        </div>
                    </div>
                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="3">
                        <div class="act-box" ng-repeat="activity in activityList">
                            <img src="/public/wxapp/meal/images/new.png" ng-if="$index==0" class="noticeicon" alt="图标">
                            <img src="/public/wxapp/meal/images/discount.png" ng-if="$index==1" class="noticeicon" alt="图标">
                            <img src="/public/wxapp/meal/images/notice.png" ng-if="$index==2" class="noticeicon" alt="图标">
                            <div class="notice-txt">
                                <p>{{activity.amf_name}}</p>
                            </div>
                        </div>
                    </div>
                    <!-- 分类导航 -->
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <ul class="border-t border-b" style="white-space: normal;">
                            <li ng-if="nav.open" ng-repeat="nav in navList track by $index">
                                <img ng-src="{{nav.imgsrc}}" width="100%" height="100%"  alt="图标">
                                <span>{{nav.title}}</span>
                            </li>
                        </ul>
                    </div>
                    <!-- 地址选择 -->
                    <div class="address-show flex-wrap" data-left-preview data-id="4">
                        <div class="contact-box">
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/meal/images/dianpu@2x.png" class="icon-contact" />
                                <div class="label-name">店铺详情</div>
                            </div>
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/meal/images/yingyeshijian@2x.png" class="icon-contact" />
                                <span class="label-name">营业时间：</span>
                                <span class="label-con flex-con">{{shopInfo.openStartTime}}-{{shopInfo.openEndTime}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/meal/images/dianhua@2x.png" class="icon-contact" />
                                <span class="label-name">联系商家：</span>
                                <span class="label-con flex-con">{{shopInfo.phone}}</span>
                            </div>
                            <div class="contact-item flex-wrap">
                                <img src="/public/wxapp/meal/images/dizhi@2x.png" class="icon-contact" />
                                <span class="label-name">商家地址：</span>
                                <span class="label-con flex-con">{{shopInfo.address}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- 店铺标签-->
                    <div class="service-wrap" data-left-preview data-id="5" style="padding: 0 10px;">
                        <div class="no-data-tip" ng-if="labelList.length<=0">点此添加店铺标签~</div>
                        <div class="student-fc" style="border-top: 1px solid #eee;color: #666;">
                            <div ng-repeat="label in labelList" style="width: 25%;padding: 0;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;margin: 0">
                                <span style="position: relative;top: -3px;"><span style="font-size: 40px;position: relative;top: 8px;">·</span>{{label.title}}</span>
                            </div>
                        </div>
                    </div>
                    <!-- 推荐菜品-->
                    <div class="service-wrap" data-left-preview data-id="6" style="height: 145px;overflow: hidden;">
                        <div class="title-name">
                            <div class="icon" style="width: 23px;margin-left: 3px;"><img src="/public/wxapp/meal/images/recommend.png" alt=""/></div>
                            <span>推荐菜品</span>
                            <span style="position: absolute;right: 12px;left: auto;font-size: 14px;">更多></span>
                        </div>
                        <div class="no-data-tip" ng-if="recommendList.length<=0">点此添加内容~</div>
                        <div class="student-fc">
                            <div ng-repeat="recommend in recommendList" style="margin: 0 7px;">
                                <img ng-src="{{recommend.cover}}" alt="推荐菜品">
                                <div style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;font-size: 12px;background: #000;color: #fff;opacity: 0.6;text-align: center;position: relative;top: -25px;">{{recommend.name}}</div>
                            </div>
                        </div>
                    </div>
                    <!-- 店铺环境 -->
                    <div class="service-wrap" data-left-preview data-id="7">
                        <div class="title-name">
                            <div class="icon" style="width: 23px;margin-left: 3px;"><img src="/public/wxapp/meal/images/env.png" alt=""/></div>
                            <span>店铺环境</span>
                        </div>
                        <div class="no-data-tip" ng-if="environmentList.length<=0">点此添加内容~</div>
                        <div class="student-fc" style="max-height: 100px;overflow: hidden;padding: 0 8px;">
                            <div ng-repeat="environment in environmentList">
                                <img ng-src="{{environment.imgsrc}}" alt="店铺环境">
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
                    <div class="input-groups">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="shopInfo.headerTitle">
                    </div>
                </div>
            </div>
            <!--<div class="headImg" data-right-edit data-id="1">
                <label>背景图</label>

                <div class="headImg-manage" style="height:100%;width: 100%">
                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeBg()" data-dom-id="upload-headImg" id="upload-headImg"  ng-src="{{shopInfo.headImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.headImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="headImg"  class="avatar-field bg-img" name="headImg" ng-value="shopInfo.headImg"/>
                    <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                </div>
                <div class="input-group-box">
                    <label class="label-name">店铺标签：</label>
                    <div class="right-box shop-label">
                        <input type="text" class="cus-input" maxlength="5" ng-model="shopInfo.shopLabel1" >
                        <input type="text" class="cus-input" maxlength="5" ng-model="shopInfo.shopLabel2" >
                        <input type="text" class="cus-input" maxlength="5" ng-model="shopInfo.shopLabel3" >
                    </div>
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
                    <label class="label-name">配送范围(公里)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.postRange" placeholder="多少公里内配送">
                </div>
                <div class="input-group-box">
                    <label class="label-name">平均送达时间(分钟)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.avgSendTime" placeholder="平均送达时间">
                </div>
            </div>-->
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label style="width: 100%">幻灯管理<span>(幻灯图片尺寸：750px*300px)</span></label>
                <div class="banner-manage">
                    店铺logo显示：
                    <div class="radio-box showstyle-radio" style="display: inline-block;width: 50%;">
                        <form>
                            <span>
                                        <input type="radio" name="goods-show" id="showstyle1" value="1" ng-model="shopInfo.logoShow" ng-checked="shopInfo.logoShow == 1 ">
                                        <label for="showstyle1">显示</label>
                            </span>
                            <span>
                                        <input type="radio" name="goods-show" id="showstyle0" value="0" ng-model="shopInfo.logoShow" ng-checked="shopInfo.logoShow == 0 ">
                                        <label for="showstyle0">不显示</label>
                            </span>
                        </form>
                    </div>
                </div>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <!-- 导航 -->
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
                        <span>开启收银台:</span>
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
                    <div class="isOn">
                        <div class="open">
                        <span>开启会员充值:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList4_start' type='checkbox' ng-model="navList[4].open">
                        <label class='tgl-btn' for='navList4_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[4].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[4].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[4].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',4)" data-dom-id="upload-navList4" id="upload-navList4"  ng-src="{{navList[4].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList4"  class="avatar-field bg-img" name="navList4" ng-value="navList[4].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="isOn">
                        <div class="open">
                        <span>开启优惠券:</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList5_start' type='checkbox' ng-model="navList[5].open">
                        <label class='tgl-btn' for='navList5_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[5].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[5].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[5].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',5)" data-dom-id="upload-navList5" id="upload-navList5"  ng-src="{{navList[5].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList5"  class="avatar-field bg-img" name="navList5" ng-value="navList[5].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="isOn">
                        <div class="open">
                            <span>开启排号:</span>
                            <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='navList6_start' type='checkbox' ng-model="navList[6].open">
                        <label class='tgl-btn' for='navList6_start'></label>
                        </span>
                        </div>
                        <div class="title" ng-show="navList[6].open">
                            <span>标题:</span>
                            <input class='form-control' type='text' ng-model="navList[6].title" >
                        </div>
                        <div class="appoint-manage on-img" ng-show="navList[6].open">
                            <div class="edit-img">
                                <div style="height:100%;">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200"  imageonload="doThis('navList',6)" data-dom-id="upload-navList6" id="upload-navList6"  ng-src="{{navList[6].imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                                    <input type="hidden" id="navList6"  class="avatar-field bg-img" name="navList6" ng-value="navList[6].imgsrc"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="">外卖页顶部图片：</label>
                        <div class="headImg-manage"  style="height:100%;width: 100%">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav1()" data-dom-id="upload-nav1HeadImg" id="upload-nav1HeadImg"  ng-src="{{shopInfo.nav1HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav1HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav1HeadImg"  class="avatar-field bg-img" name="nav1HeadImg" ng-value="shopInfo.nav1HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>
                    <div>
                        <label for="">堂食页顶部图片：</label>
                        <div class="headImg-manage"   style="height:100%;width: 100%">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav2()" data-dom-id="upload-nav2HeadImg" id="upload-nav2HeadImg"  ng-src="{{shopInfo.nav2HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav2HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav2HeadImg"  class="avatar-field bg-img" name="nav2HeadImg" ng-value="shopInfo.nav2HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>
                    <div>
                        <label for="">预约页顶部图片：</label>
                        <div class="headImg-manage">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="250" imageonload="changeNav3()" data-dom-id="upload-nav3HeadImg" id="upload-nav3HeadImg"  ng-src="{{shopInfo.nav3HeadImg==''?'/public/manage/img/zhanwei/zw_fxb_75_30.png':shopInfo.nav3HeadImg}}"  width="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="nav3HeadImg"  class="avatar-field bg-img" name="nav3HeadImg" ng-value="shopInfo.nav3HeadImg"/>
                            <a href="#" class="change-bg">修改背景图<span>(建议尺寸750*250)</span></a>
                        </div>
                    </div>

                </div>
            </div>
            <!-- 活动管理 -->
            <div class="notice" data-right-edit data-id="3">
                <label style="width: 100%">店铺活动</label>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处活动为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
            </div>
            <!-- 地址 -->
            <div class="address" data-right-edit data-id="4">
                <div class="shops-name">店铺详情</div>
                <div class="input-group-box">
                    <label class="label-name">营业时间：</label>
                    <input type="text" class="cus-input time" ng-model="shopInfo.openStartTime" style="width: 40%" onchange="" >
                    <input type="text" class="cus-input time" ng-model="shopInfo.openEndTime" style="width: 40%" onchange="" >
                </div>
                <div class="input-group-box">
                    <label class="label-name">联系商家：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.phone" placeholder="请输入联系电话">
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
                    <label class="label-name">配送范围(公里)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.postRange" placeholder="多少公里内配送">
                </div>
                <div class="input-group-box">
                    <label class="label-name">平均送达时间(分钟)：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.avgSendTime" placeholder="平均送达时间">
                </div>
                <div class="input-group-box">
                    <label class="label-name">餐具费（单位：每人，0表示免费）：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.tablewareFee" placeholder="请输入餐具费用">
                </div>
                <div class="input-group-box">
                    <label class="label-name">现金支付预支付金额（为防止恶意下单现金支付的订单需预支一部分费用）：</label>
                    <input type="text" class="cus-input" ng-model="shopInfo.paymentMoney" placeholder="请输入预付金额">
                </div>
                <!--
                <div class="input-group-box">
                    <div class="open">
                        <span>允许用户选择餐桌：</span>
                        <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='choose_table' type='checkbox'  <{if $tpl && $tpl['ami_choose_on'] == 1}>checked<{/if}>>
                        <label class='tgl-btn' for='choose_table'></label>
                        </span>
                        </div>
                </div>-->
                <label>商家地址</label>
                <div class="fenleinav-manage" style="padding-top: 10px;">
                    <div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 75%;display: inline-block;">详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="shopInfo.longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="shopInfo.latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <textarea rows="3" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="shopInfo.address"></textarea>
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>
                </div>
            </div>
            <!-- 店铺标签 -->
            <div class="notice" data-right-edit data-id="5">
                <label style="width: 100%">店铺标签</label>
                <div class="service-manage student-manage" ng-repeat="label in labelList">
                    <div class="delete" ng-click="delIndex('labelList',label.index)">×</div>
                    <div>
                        <input type="text" maxlength="5"  class="form-control"  ng-model="label.title"/>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addLabel()"></div>
            </div>

            <!-- 活动管理 -->
            <div class="notice" data-right-edit data-id="6">
                <label style="width: 100%">推荐菜品</label>
                <div class="input-group-box" style="margin-bottom: 10px">
                    <label for="">链接类型：</label>
                    <select class="cus-input form-control" ng-model="shopInfo.recommendMore" >
                        <option value="1">外卖</option>
                        <option value="2">堂食</option>
                    </select>
                </div>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处仅做展示，请前往商品管理设置推荐~</div>
                </div>
            </div>

            <!-- 店铺环境管理 -->
            <div class="teacher" data-right-edit data-id="7">
                <label style="width: 100%;">店铺环境</label>
                <div class="service-manage student-manage" ng-repeat="environment in environmentList">
                    <div class="delete" ng-click="delIndex('environmentList',environment.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="400" data-height="400" imageonload="doThis('environmentList',environment.index)" data-dom-id="upload-environment{{$index}}" id="upload-environment{{$index}}"  ng-src="{{environment.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="environment{{$index}}"  class="avatar-field bg-img" name="environment{{$index}}" ng-value="environment.imgsrc"/>
                        </div>
                    </div>
                    <p class="tips">图片建议尺寸: 400px*400px</p>
                </div>
                <div class="add-box" title="添加" ng-click="addEnvironment()"></div>
            </div>


        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>


<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.shopInfo = {
            headerTitle: '<{$tpl['ami_title']}>'?'<{$tpl['ami_title']}>':"微点餐",
            recommendMore:"<{$tpl['ami_recommend_more']}>",
            headImg:"<{$tpl['ami_head_img']}>",
            openStartTime:'<{$tpl['ami_open_time'][0]}>',
            openEndTime:'<{$tpl['ami_open_time'][1]}>',
            spend: '<{$tpl['ami_average_spend']}>'?'<{$tpl['ami_average_spend']}>':0,
            shopLabel1: '<{$tpl['ami_label'][0]}>'?'<{$tpl['ami_label'][0]}>':'标签一',
            shopLabel2: '<{$tpl['ami_label'][1]}>'?'<{$tpl['ami_label'][1]}>':'标签二',
            shopLabel3: '<{$tpl['ami_label'][2]}>'?'<{$tpl['ami_label'][2]}>':'标签三',
            phone:'<{$tpl['ami_phone']}>',
            limit:'<{$tpl['ami_post_limit']}>',
            address:'<{$tpl['ami_address']}>',
            longitude:'<{$tpl['ami_lng']}>',
            latitude:'<{$tpl['ami_lat']}>',
            nav1HeadImg:'<{$tpl['ami_nav1_head_img']}>',
            nav2HeadImg:'<{$tpl['ami_nav2_head_img']}>',
            nav3HeadImg:'<{$tpl['ami_nav3_head_img']}>',
            postFee: '<{$tpl['ami_post_fee']}>'?'<{$tpl['ami_post_fee']}>':0,
            postRange: '<{$tpl['ami_post_range']}>'?'<{$tpl['ami_post_range']}>':0,
            avgSendTime: '<{$tpl['ami_avg_send_time']}>'?'<{$tpl['ami_avg_send_time']}>':0,
            paymentMoney: '<{$tpl['ami_payment_money']}>'?'<{$tpl['ami_payment_money']}>':0,
            tablewareFee: '<{$tpl['ami_tableware_fee']}>'?'<{$tpl['ami_tableware_fee']}>':0,
            logoShow : '<{$tpl['ami_logo_show']}>',
            // 是否开启外卖和堂食及预约
            outOn: '<{$tpl['ami_out_on']}>' > 0 ? true : false ,
            eatOn: '<{$tpl['ami_eat_on']}>' > 0 ? true : false ,
            appOn: '<{$tpl['ami_appo_on']}>' > 0 ? true : false ,
            // 是否开启外卖和堂食及预约
            outImg:'<{$tpl['ami_out_img']}>' ? '<{$tpl['ami_out_img']}>' : '/public/wxapp/meal/images/out_img.png' ,
            eatImg:'<{$tpl['ami_eat_img']}>' ? '<{$tpl['ami_eat_img']}>' : '/public/wxapp/meal/images/eat_img.png' ,
            appImg:'<{$tpl['ami_appo_img']}>' ? '<{$tpl['ami_appo_img']}>' : '/public/wxapp/meal/images/app_img.png'
        };

        $scope.activityList = <{$activityList}>;
        $scope.banners     = <{$slide}>;
        $scope.environmentList = <{$environmentList}>;
        $scope.recommendList = <{$recommendList}>;
        $scope.labelList = <{$labelList}>;
        $scope.navList = <{$navList}>;

        console.log($scope.navList);

        $scope.tpl_id      = 12;

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

        /*添加店铺环境方法*/
        $scope.addEnvironment = function(){
            var environmentList_length = $scope.environmentList.length;
            var defaultIndex = 0;
            if(environmentList_length>0){
                for (var i=0;i<environmentList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.environmentList[i].index)){
                        defaultIndex = parseInt($scope.environmentList[i].index);
                    }
                }
                defaultIndex++;
            }
            var environmentList_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_200_200.png'
            };
            $scope.environmentList.push(environmentList_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
        };

        $scope.addLabel= function(){
            var labelList_length = $scope.labelList.length;
            var defaultIndex = 0;
            if(labelList_length>0){
                for (var i=0;i<labelList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.labelList[i].index)){
                        defaultIndex = parseInt($scope.labelList[i].index);
                    }
                }
                defaultIndex++;
            }
            if(labelList_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个标签',
                    time: 2000
                });
            }else{
                var labelList_Default = {
                    index: defaultIndex,
                    title: '标签'
                };;
                $scope.labelList.push(labelList_Default);
            }
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
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_30.png',
                    link: 'http://www.fenxiaobao.xin/manage/index/index',
                    articleTitle:'',
                    articleId:0
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

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopInfo.headImg = imgNowsrc;
            }
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
        // 外卖图标
        $scope.changeOutImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.outImg = imgNowsrc;
            }
        };
        // 堂食图标
        $scope.changeEatImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.eatImg = imgNowsrc;
            }
        };
        // 预约图标
        $scope.changeAppImg=function(){
            if(imgNowsrc){
                $scope.shopInfo.appImg = imgNowsrc;
            }
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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var chooseTable = $('#choose_table').is(':checked');
            var data = {
                'shopInfo'    : $scope.shopInfo,
                'slide' : $scope.banners,
                'labelList' : $scope.labelList,
                'environmentList': $scope.environmentList,
                'navList': $scope.navList,
                'chooseTable' : chooseTable ? 1 : 0
            };
            console.log($scope.shopInfo);
            $http({
                method: 'POST',
                url:    '/wxapp/meal/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).attr('data-id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
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

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<{include file="../img-upload-modal.tpl"}>