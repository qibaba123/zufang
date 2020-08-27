<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/ajax-page.css">
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
    .fenleinav-manage .edit-img img{
        height: 75% !important;
        width: 75% !important;
    }

.banner-chosen .chosen-container {
    width: 350px !important;
}
.fenleiNav-chosen .chosen-container{
    width: 248px !important;
}
.recommendGood-chosen .chosen-container{
    width: 336px !important;
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
.input-group-box label {
    display: table-cell;
    line-height: 34px;
    width: 100px;
}
.fenleinav-manage .edit-txt label {
    width: 33%;
    float: left;
    line-height: 32px;
}
.fenleinav-manage .edit-txt .cus-input {
    width: 67%;
    float: left;
}
.recommendGood-chosen .chosen-container {
    width: 288px !important;
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
                    <!--幻灯-->
                    <div data-left-preview data-id="1">
                        <div class="banner-wrap">
                            <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
                            <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                            <div class="paginations">
                                <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                            </div>
                        </div>
                    </div>
                    <!--导航-->
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-data-tip" ng-if="fenleiNavs.length<=0">点此添加导航~</div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs" style="width:20%;">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!--店铺信息-->
                    <!--<div class="notice-box" style="height: 120px" data-left-preview data-id="3">
                        <div style="height:40px;">
                            <img class="company-cover" ng-src="{{shopInfo.cover}}" alt="公司封面">
                            <div class="act-box" style="width:70%;float: left;margin-left:10px;">
                                <p>{{shopInfo.title}}</p>
                                <p style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">{{address.address}}</p>
                            </div>
                            <div class="act-box" style="height:25px;float: left;margin-left:10px">
                                <p>{{brief}}</p>
                            </div>
                        </div>
                    </div>-->
                    <!--优惠券-->
                    <div class="fenlei-nav" data-left-preview data-id="4" style="background-color:#fff;margin-top: 5px;">
                        <div class="contact-item ">
                            <div class="label-name" style="padding: 5px 0 0 10px;text-align: center;font-size: 18px">{{couponTitle}}</div>
                            <div class="label-name" style="padding: 5px 0 0 10px;text-align: center;">{{couponSign}}</div>
                        </div>
                        <div class="no-nav" style="padding-bottom: 10px;">
                            <img src="/public/wxapp/store/images/youhui.png" style="width:95%" />
                        </div>
                    </div>
                    <!--促销商品-->
                    <div class="hot-recommend" data-left-preview data-id="5">
                        <div class="title-name">
                            <p class="flex-con" style="text-align: center;font-size: 18px">{{recommendtitle}}</p>
                            <p class="flex-con" style="text-align: center;">{{recommendsign}}</p>
                            <!--<div class="more-enter">
                                查看全部
                                <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" />
                            </div>-->
                        </div>
                        <div class="recommend-img" style="padding: 0 0 0 20px">
                            <div class="no-data-tip" ng-if="recommendGood.length<=0">点此添加推荐商品~</div>
                            <div class="img-item" ng-repeat="good in recommendGood" style="width:125px;height:160px;margin: 0">
                                <img ng-src="{{good.imgsrc}}" style="width: 80%;height: 60%;margin:0" />
                                <div class="good-intro">
                                    <div class="good-title">{{good.name}}</div>
                                    <div class="price-buy">
                                        <span>￥</span>
                                        <span class="now-price">{{good.price}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--热销-->
                    <!--<div class="appointment-wrap" data-left-preview data-id="6" style="margin-top: 5px;">
                        <div>
                            <div class="no-data-tip" ng-if="hotImg.length<=0">点此添加图片~</div>
                            <div class="cooperative-wrap">
                                <img ng-src="{{hotImg}}" style="width: 100%;" />
                            </div>
                        </div>
                    </div>-->
                    <!--特色商品-->
                    <div class="good-show-wrap" data-left-preview data-id="7" style="margin-top: 5px">
                        <div class="good-list-wrap" ng-repeat="goodfl in goodFlShow">
                            <div class="hot-product" data-left-preview data-id="6">
                                <div class="title-name" style="margin:0">
                                    <div class="flex-con"style="font-size: 18px">{{goodfl.title}}</div>
                                    <div class="flex-con">{{goodfl.sign}}</div>
                                </div>
                                <input type="hidden" ng-value="goodfl.type">
                                <div class="goods-show">
                                    <div class="goods-view1">
                                        <ul>
                                            <li>
                                                <a href="javascript:;">
                                                    <img src="/public/manage/applet/temp1/images/goodsView1.jpg" alt="商品">
                                                    <div class="intro">
                                                        <h4>此处显示商品名称</h4>
                                                        <p class="price">￥9999</p>
                                                        <span class="buy-btn">购买</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img src="/public/manage/applet/temp1/images/goodsView2.jpg" alt="商品">
                                                    <div class="intro">
                                                        <h4>此处显示商品名称</h4>
                                                        <p class="price">￥9999</p>
                                                        <span class="buy-btn">购买</span>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <img src="/public/manage/applet/temp1/images/goodsView3.jpg" alt="商品">
                                                    <div class="intro">
                                                        <h4>此处显示商品名称</h4>
                                                        <p class="price">￥9999</p>
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
            <!--幻灯-->
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*400px)</span></label>
                <div class="banner-manage banner-chosen" ng-repeat="banner in banners" style="overflow: visible">
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
                        <label for="" >单　　页：</label>
                        <select class="cus-input selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2">
                        <label for="" >列　　表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input  type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="">商品详情：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==9">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in secondkindSelect" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==23">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==15">
                        <label for="">拼团详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==16">
                        <label for="">店铺分类：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==17">
                        <label for="">店铺详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==21">
                        <label for="">资讯分类：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in articlesSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==29">
                        <label for="">秒杀商品：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in limitlist" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==30">
                        <label for="">拼团商品：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in groupList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==41">
                        <label for="">平台商品分组：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in plateformGroup" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==42">
                        <label for="">商家商品分组：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in shopGoodsGroup" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <!--导航-->
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航<span>(分类多于8个时手机端可横向滑动，管理界面不做展示)</span></label>
                <div class="fenleinav-manage fenleiNav-chosen" ng-repeat="fenleiNav in fenleiNavs" style="overflow: visible;height: 155px">
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
                            <label for="" >单　　页：</label>
                            <select class="cus-input selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="" >列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input  type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="banner.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                            <label for="" class="label-name">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in secondkindSelect" ></select>
                        </div>
                        <!-- 一级分类选择 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==23">
                            <label for="" class="label-name">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==15">
                            <label for="">拼团详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==16">
                            <label for="">店铺分类：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==17">
                            <label for="">店铺详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shoplist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==21">
                            <label for="">资讯分类：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in articlesSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==29">
                            <label for="">秒杀商品：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in limitlist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==30">
                            <label for="">拼团商品：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in groupList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==41">
                            <label for="">平台商品分组：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in plateformGroup" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==42">
                            <label for="">商家商品分组：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in shopGoodsGroup" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <!--店铺信息-->
            <!--<div class="notice" data-right-edit data-id="3">
                <label>店铺信息</label>
                <div class="fenleinav-manage" style="padding-top: 10px;">
                    <div class="input-group-box clearfix">
                        <label for="">店铺简介：</label>
                        <textarea rows="2" class="cus-input" placeholder="请输入详细地址"  ng-model="brief"></textarea>
                    </div>
                    <div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 70%;display: inline-block;">店铺详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="address.longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="address.latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <textarea rows="2" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="address.address"></textarea>
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>
                </div>
            </div>-->
            <!--优惠券-->
            <div class="fenleinav" data-right-edit data-id="4" ui-sortable>
                <label style="width: 100%">优惠券</label>
                <div style="background-color: #fff;border: 1px solid #ccc;padding: 20px 0;">
                    <div style="margin-bottom: 10px">
                        <label style="margin-left: 10%;margin-right: 5%;">标题：</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="couponTitle" style="width:40%;">
                    </div>
                    <div style="margin-bottom: 10px">
                        <label style="margin-left: 10%;margin-right: 5%;">标签：</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="couponSign" style="width:40%;">
                    </div>
                    <div style="margin-left: 10%;color:red"><span>*具体优惠券在优惠券管理模块添加</span></div>
                </div>
            </div>
            <!--促销商品-->
            <div class="fenleinav" data-right-edit data-id="5">
                <label style="width: 100%">{{recommendtitle}}<span>(图片尺寸为250px*250px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px">标题名称：</label>
                    <input type="text" class="cus-input" ng-model="recommendtitle" maxlength="15">
                </div>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px">标签：</label>
                    <input type="text" class="cus-input" ng-model="recommendsign" maxlength="15">
                </div>
                <div class="fenleinav-manage recommend-manage recommendGood-chosen" ng-repeat="good in recommendGood" style="overflow: visible">
                    <div class="delete" ng-click="delIndex('recommendGood',good.index)">×</div>
                    <div class="edit-img" style="width: 50%">
                        <!--<div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{good.imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('recommendGood',good.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="good.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="250" data-height="250" imageonload="doThis('recommendGood',good.index)" data-dom-id="upload-good{{$index}}" id="upload-good{{$index}}"  ng-src="{{good.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
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
                            <select class="cus-input selectpicker chosen-select" ng-model="good.link" ng-options="x.id as x.name for x in goodsList"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addRecommendGood()"></div>
            </div>
            <!--热销-->
            <div class="appoint" data-right-edit data-id="6">
                <div class="shopintrobg-manage"style="margin-bottom: 10px">
                    <img onclick="toUpload(this)"  style="margin-top: 20px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="240" imageonload="changeBottomImg()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{hotImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="hotImg"  class="avatar-field bg-img" name="hotImg{{$index}}" ng-value="hotImg"/>
                </div>
                <div class="edit-txt">
                    <div class="input-group-box clearfix" style="margin-bottom: 10px">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="hotType"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotTypee==1">
                        <label for="" >单　　页：</label>
                        <select class="cus-input" ng-model="hotLink"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==2">
                        <label for="" >列　　表：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==3">
                        <label for="">外　　链：</label>
                        <input  type="text" class="cus-input form-control" ng-model="hotLink" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==5">
                        <label for="">商品详情：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==15">
                        <label for="">拼团详情：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==16">
                        <label for="">店铺分类：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==17">
                        <label for="">店铺详情：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.id as x.name for x in shoplist" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="hotType==21">
                        <label for="">资讯分类：</label>
                        <select class="cus-input form-control" ng-model="hotLink"  ng-options="x.id as x.name for x in articlesSelect" ></select>
                    </div>
                </div>
            </div>
            <!--特色商品-->
            <div class="fenleinav" data-right-edit data-id="7">
                <label style="width: 100%">分类商品展示管理</label>
                <div class="fenleinav-manage" ng-repeat="goodfl in goodFlShow">
                    <div class="delete" ng-click="delIndex('goodFlShow',goodfl.index)" style="display:block">×</div>
                    <div class="goodsShow">
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 70px">标题名称：</label>
                            <input type="text" class="cus-input" ng-model="goodfl.title" maxlength="15">
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 70px">标签：</label>
                            <input type="text" class="cus-input" ng-model="goodfl.sign" maxlength="15">
                        </div>
                        <div class="input-group-box" style="margin-bottom: 10px;">
                            <label style="width: 70px">商品分组：</label>
                            <select class="cus-input" ng-model="goodfl.link" ng-options="x.id as x.name for x in category"></select>
                        </div>
                        <div class="good-tip">注：将从您选择的分组中取出最多6个商品显示~</div>
                        <label>列表样式</label>
                        <div class="goods-show-manage">
                            <div class="radio-box showstyle-radio">
                                <form>
                                <input type="hidden" ng-value="goodfl.type" ng-model="goodfl.type">
                                <span style="display: none" ng-click="changeShowStyle($event)" data-index="{{goodfl.index}}" data-id="1">
                                        <input type="radio" name="goods-show" id="showstyle1">
                                        <label for="showstyle1">大图</label>
                                </span>
                                <span  ng-click="changeShowStyle($event)" data-index="{{goodfl.index}}" data-id="2">
                                        <input type="radio" name="goods-show" id="showstyle2">
                                        <label for="showstyle2">小图</label>
                                </span>
                                <span style="display: none" ng-click="changeShowStyle($event)" data-index="{{goodfl.index}}" data-id="3">
                                        <input type="radio" name="goods-show" id="showstyle3">
                                        <label for="showstyle3">一大两小</label>
                                </span>
                                <span  ng-click="changeShowStyle($event)" data-index="{{goodfl.index}}" data-id="4">
                                        <input type="radio" name="goods-show" id="showstyle4">
                                        <label for="showstyle4">详细列表</label>
                                </span>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewGoodfl()"></div>
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
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.goodsList      = <{$goodsList}>;
        //$scope.kindSelect     = <{$kindSelect}>;
        $scope.headerTitle    = "<{$tpl['amu_title']}>" ? "<{$tpl['amu_title']}>" : "店铺首页" ;
        $scope.banners        = <{$slide}>;
        $scope.articles        =  <{$information}>;
        $scope.fenleiNavs     = <{$shortcut}>;
        $scope.tpl_id		  = '<{$tpl['amu_tpl_id']}>';
        $scope.recommendGood  = <{$recommendGoods}>;
        $scope.recommendtitle = '<{$tpl['amu_promotion_title']}>' ? '<{$tpl['amu_promotion_title']}>' : '热品推荐';
        $scope.recommendsign  = '<{$tpl['amu_promotion_sign']}>' ? '<{$tpl['amu_promotion_sign']}>' : '随时促销 先到先得';
        $scope.goodFlShow     = <{$kindList}>;
        $scope.category       = <{$goodsGroup}>;
        $scope.linkTypes      = <{$linkType}>;
        $scope.linkList       = <{$linkList}>;
        $scope.couponTitle    = '<{$tpl['amu_coupon_title']}>'?'<{$tpl['amu_coupon_title']}>':'优惠券';
        $scope.couponSign     = '<{$tpl['amu_coupon_sign']}>'?'<{$tpl['amu_coupon_sign']}>':'优惠好礼 即领即得';
        $scope.noticeTxt      = <{$information}>;
        $scope.hotImg         = '<{$tpl['amu_hot_img']}>'?'<{$tpl['amu_hot_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.hotType        = '<{$tpl['amu_hot_type']}>';
        $scope.hotLink        = '<{$tpl['amu_hot_link']}>';
        $scope.brief          = '<{$tpl['amu_brief']}>';
        $scope.kindSelect = <{$kindSelect}>;
        $scope.shoplist = <{$shoplist}>;
        $scope.articlesSelect = <{$categoryList}>;
        $scope.groupList = <{$groupList}>;
        $scope.limitlist = <{$limitList}>;
        $scope.plateformGroup = <{$plateformGroup}>;
        $scope.shopGoodsGroup = <{$shopGoodsGroup}>;
        $scope.secondkindSelect = <{$secondkindSelect}>;
        $scope.firstKindSelect = <{$firstKindSelect}>;
        /*$scope.address = {
            address   :'<{$tpl['amu_address']}>' ? '<{$tpl['amu_address']}>' : '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室',
            longitude :'<{$tpl['amu_lng']}>' ? '<{$tpl['amu_lng']}>' : '113.72052',
            latitude  :'<{$tpl['amu_lat']}>' ? '<{$tpl['amu_lat']}>' : '34.77485',
        };
        $scope.shopInfo = {
                    title   :"<{$shopSetup['s_name']}>" ? "<{$shopSetup['s_name']}>" : '公司名称',
                    cover   :"<{$shopSetup['s_logo']}>" ? "<{$shopSetup['s_logo']}>" : '/public/manage/img/zhanwei/zw_fxb_200_200.png',
         };*/
        $scope.changeShowStyle=function($event){
            $event.preventDefault();
            var that      = $($event.target).prev('input:eq(0)');
            var index     = $($event.target).parent('span').data('id');
            var nums      = $($event.target).parent('span').data('index');
            console.log(nums);
            that.get(0).checked=true;
            var styleDiv = $(".index-main").find(".hot-product").find(".goods-show>div");
            styleDiv.each(function(i,value){
                var curClass =  $(value).attr("class");
                if(i==nums){
                    $(value).removeClass(curClass).addClass('goods-view' + index);
                }
            });
           /* styleDiv.removeClass(curClass).addClass('goods-view'+index);*/
            $scope.goodFlShow[nums].type = index;
        };
        $scope.initListShow = function(){
            $('.edit-con').find(".showstyle-radio input[type=hidden]").each(function(index, el) {
                var styleVal = $(this).val();
                console.log(styleVal);
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
 /*       $(function(){
            $scope.initListShow();//初始化列表样式
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
           /!* //高德地图引入
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


            /!**
             * 添加一个标签和一个结构体
             * @param lng
             * @param lat
             * @param address
             *!/
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

            }*!/
        });*/
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
                    addInitChosen();
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
                    addInitChosen();
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
            /*if(goodfl_length>=3){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加3个商品分类哦',
                    time: 2000
                });
            }else{
                var goodfl_Default = {
                    index: defaultIndex,
                    title:'默认名称',
                    sign :'惊艳上市 先买先得',
                    type : 1,
                    link : ''
                };
                $scope.goodFlShow.push(goodfl_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }*/
            var goodfl_Default = {
                index: defaultIndex,
                title:'默认名称',
                sign :'惊艳上市 先买先得',
                type : 1,
                link : ''
            };
            $scope.goodFlShow.push(goodfl_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
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
                    imgsrc:'/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    link: ''
                };
                $scope.recommendGood.push(good_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                    addInitChosen();
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
            console.log('执行dothis');
            console.log(index);
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
        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.hotImg = imgNowsrc;
            }
        };
        $(function(){
            addInitChosen();

            /*控制店铺图片宽高比*/
            // $(".shop-bg").height($(".shop-bg").width()*0.3175);
            initListShow();
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
                'title' 	     : $scope.headerTitle,
                'coupon_title' 	 : $scope.couponTitle,
                'coupon_sign' 	 : $scope.couponSign,
                'promotion_title': $scope.recommendtitle,
                'promotion_sign' : $scope.recommendsign,
                'hot_img'        : $scope.hotImg,
                'hot_type'       : $scope.hotType,
                'hot_link'       : $scope.hotLink,
                'slide'		     : $scope.banners,
                'shortcut'	     : $scope.fenleiNavs,
                'recommendGood'  : $scope.recommendGood,
                'kind'           : $scope.goodFlShow
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/community/saveMallCfg',
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
        console.log(elem);
        console.log('---修改图片---');
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

    /*
    初始化chosen-select
     */
    function addInitChosen() {
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            placeholder_text_single : '请选择'
        });
    }
</script>
<{include file="../img-upload-modal.tpl"}>