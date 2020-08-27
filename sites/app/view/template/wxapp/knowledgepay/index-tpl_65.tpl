<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css?1">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css?1">
<style>
.index-con .index-main {
    background-color: #fff;
}
.good-list-wrap .title-name p:before {
    background-color: #fff;
    position: inherit;
}
.good-list-wrap .title-name { margin: 4px auto; background-color: #fff; text-align: center; padding: 10px 12px; }
.good-list-wrap .title-name p { position: relative; font-size: 15px; padding: 0 0; text-align: left;}
.good-list-wrap .good-list{padding: 0 4px;}
.good-list-wrap .good-view2 .good-item{padding: 4px;box-sizing: border-box;}
.good-list-wrap .good-view2 .item-wrap{padding: 0;}
.good-list-wrap .good-view2 .good-image {width: 100%;height: 150px;}
.good-list-wrap .good-view2 .good-title { text-align: left; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 2; height: 42px; line-height: 1.5; white-space: normal;margin-bottom: 5px}
.good-list-wrap .good-view2 .price-buy{text-align: left;}
.good-list-wrap .buy-btn { position: absolute; right: 8px; bottom: 8px; height: 30px; width: 30px; text-align: center; -webkit-border-radius: 15px; border-radius: 15px; background-color: #86D3D5; color: #fff; font-size: 13px; padding: 0;}
.good-list-wrap .buy-btn img { height: 18px; width: 18px; display: block; margin: 6px auto; }
.search-wrap {
    position: absolute;
    padding: 8px 12px;
    top: 0;
    box-sizing: border-box;
    width: 200px;
}
.search-container { border-radius: 25px; width: 96%; margin: 0 auto;padding: 5px 10px; box-sizing: border-box; background-color: #fff; text-align: center; }
.search-wrap img { height: 18px; width: 18px; display: inline-block; vertical-align: middle; margin-right: 5px; }
.search-wrap p { display: inline-block; vertical-align: middle; color: #333; font-size: 14px; padding-top: 5px;}
.fenlei-nav ul { background-color: #fff; padding-top: 8px; white-space: normal; max-height: 172px; overflow: hidden; }
.recommend-manage{padding:15px;text-align: center;}
.recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto;margin:0 auto 8px;}
.recommend-manage .edit-txt{float: none;width: 100%}
.recommend-img {background: #fff;}
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
.good-list-wrap .good-view2 .good-item {
    width: 100%;
}
.good-list-wrap .good-view2 .good-image {
    width: 35%;
    height: 105px;
    display: inline-block;
}

.good-list-wrap .good-view2 .good-intro {
    width: 63%;
    display: inline-block;
    height: 105px;
    padding-top: 10px;
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
                    <div data-left-preview data-id="1" style="position: relative">
                        <div class="banner-wrap">
                            <img src="/public/manage/img/zhanwei/zw_fxb_750_320.png" alt="轮播图" ng-if="banners.length<=0">
                            <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                            <div class="paginations">
                                <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                            </div>
                        </div>
                        <div class="search-wrap">
                            <div class="search-container">
                                <img src="/public/wxapp/mall/temp3/images/ydhw-ss.png" />
                                <p>{{searchPlaceholder}}</p>
                            </div>
                        </div>
                    </div>

                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-data-tip" ng-if="fenleiNavs.length<=0">点此添加导航~</div>
                        <ul ng-if="fenleiNavs.length>0">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="member-entration" data-left-preview data-id="5">
                        <div class="no-data-tip" ng-if="!memberOpen">点此管理会员入口~</div>
                        <div ng-if="memberOpen">
                            <div class="cooperative-wrap">
                                <img ng-src="{{bottomImg}}" style="width: 90%;" />
                            </div>
                        </div>
                    </div>
                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="6" style="height: auto">
                        <!--<img src="/public/wxapp/train/images/home_notable.png" class="noticeicon" alt="图标">-->
                        <div style="display: inline-block;font-size: 18px;width: 40px;float:left;margin:0 5px;color: #FC7C7C;margin-top: -2px">{{noticeTitle}}</div>
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0">配置公告内容</p>
                            <p ng-repeat="notice in noticeTxt | limitTo:2">{{notice.title}}</p>
                        </div>
                    </div>
                    <!--
                    <div class="recommend-img" data-left-preview data-id="3">
                        <div class="title-name flex-wrap">
                            <p class="flex-con" style="font-size: 16px;line-height: 45px;font-weight: bold;">{{recommendtitle}}</p>
                            <div class="more-enter" style="line-height: 46px;">
                                换一批
                                <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" style="float: right;width: 7px;margin-top: 16px;margin-left: 8px;"/>
                            </div>
                        </div>
                        <div class="no-data-tip" >推荐课程~</div>
                    </div>
                    -->
                    <!--优质项目-->
                    <div class="service-wrap" data-left-preview data-id="3">
                        <div class="title-name">
                            <span style="font-size: 16px;margin-left: 10px">{{recommendTitle}}</span>
                            <span class="more" style="float:right;margin-right: 10px;color: #999;display: none">更多</span>
                        </div>
                        <div class="no-data-tip" ng-if="recommendList.length<=0">点此添加内容~</div>
                        <div class="service-list" ng-if="recommendList.length>0" >
                            <div class="service-item"  ng-repeat="recommend in recommendList" >
                                <img ng-src="{{recommend.imgsrc}}" />
                                <!--<span class="title-txt name">{{service.name}}</span>
                                <span class="title-txt brief">{{service.intro}}</span>-->
                            </div>
                        </div>
                    </div>

                    <div class="service-wrap" data-left-preview data-id="7">
                        <div class="no-data-tip" ng-if="recommendBig.length <= 0" >点此添加内容~</div>
                        <div class="service-list" ng-if="recommendBig.length > 0" style="height: auto;margin-top: 5px">
                            <div class="service-item" style="width: 290px">
                                <img ng-src="{{recommendBig[0].imgsrc}}" />
                            </div>
                        </div>
                    </div>
                    <div class="service-wrap" data-left-preview data-id="8">
                        <div class="title-name">
                            <span style="font-size: 16px;margin-left: 10px">{{audioTitle}}</span>
                            <span class="more" style="float:right;margin-right: 10px;color: #999;">更多</span>
                        </div>
                        <div class="no-data-tip" ng-if="recommendAudio.length<=0">点此添加内容~</div>
                        <div class="service-list" ng-if="recommendAudio.length>0" style="height: auto">
                            <div class="audio-item"  ng-repeat="audio in recommendAudio" >
                                <span>{{audioList[audio.link].name}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="service-wrap" data-left-preview data-id="9">
                        <div class="title-name">
                            <span style="font-size: 16px;margin-left: 10px">{{quotationTitle}}</span>
                            <span class="more" style="float:right;margin-right: 10px;color: #999;">更多</span>
                        </div>
                        <div class="no-data-tip" >点此管理精选语录</div>
                    </div>
                    <div class="good-show-wrap" data-left-preview data-id="4">
                        <div class="good-list-wrap" ng-repeat="goodfl in goodFlShow">
                            <div class="title-name flex-wrap">
                                <p class="flex-con">{{goodfl.title}}</p>
                                <div class="more-enter">
                                    更多
                                    <img src="/public/wxapp/mall/temp3/images/icon_more_enter.png" />
                                </div>
                            </div>
                            <div class="good-list good-view2">
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView1.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView2.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView3.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="good-item">
                                    <div class="item-wrap border-l border-b">
                                        <img src="/public/wxapp/mall/temp3/images/goodsView4.jpg" class="good-image" />
                                        <div class="good-intro">
                                            <div class="good-title">课程名称</div>
                                            <div class="price-buy">
                                                ￥<p class="now-price">2999</p>
                                            </div>
                                        </div>
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
                    <div class="input-group" style="margin-bottom: 15px;">
                        <div class="right-info">
                            <div style="height: 35px">
                                <label class="label-name" style="width: 150px">图文课程封面图样式:</label>
                                <div class="right-info">
                                    <div class="controls" style="display: block;">
                                        <input style="position: relative;top: -8px;" id='article-cover-type-{{$index}}-1' type="radio" name='article-cover-type' value="1" ng-model="articleCoverType"/>
                                        <label for="article-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                        <input style="position: relative;top: -8px;" id='article-cover-type-{{$index}}-2' type="radio" name='article-cover-type' value="2" ng-model="articleCoverType"/>
                                        <label style="position: relative;top: -4px;" for="article-cover-type-{{$index}}-2">640 * 360</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group" style="margin-bottom: 15px;">
                        <div class="right-info">
                            <div style="height: 35px">
                                <label class="label-name" style="width: 150px">音频课程封面图样式:</label>
                                <div class="right-info">
                                    <div class="controls" style="display: block;">
                                        <input style="position: relative;top: -8px;" id='audio-cover-type-{{$index}}-1' type="radio" name='audio-cover-type' value="1" ng-model="audioCoverType"/>
                                        <label for="audio-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                        <input style="position: relative;top: -8px;" id='audio-cover-type-{{$index}}-2' type="radio" name='audio-cover-type' value="2" ng-model="audioCoverType"/>
                                        <label style="position: relative;top: -4px;" for="audio-cover-type-{{$index}}-2">640 * 360</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group" style="margin-bottom: 15px;">
                        <div class="right-info">
                            <div style="height: 35px">
                                <label class="label-name" style="width: 150px">视频课程封面图样式:</label>
                                <div class="right-info">
                                    <div class="controls" style="display: block;">
                                        <input style="position: relative;top: -8px;" id='video-cover-type-{{$index}}-1' type="radio" name='video-cover-type' value="1" ng-model="videoCoverType"/>
                                        <label for="video-cover-type-{{$index}}-1" style="margin-bottom: 8px">640 * 640</label>
                                        <input style="position: relative;top: -8px;" id='video-cover-type-{{$index}}-2' type="radio" name='video-cover-type' value="2" ng-model="videoCoverType"/>
                                        <label style="position: relative;top: -4px;" for="video-cover-type-{{$index}}-2">640 * 360</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*320px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px;">搜索文本：</label>
                    <input type="text" class="cus-input" placeholder="请输入搜索提示内容" maxlength="10" ng-model="searchPlaceholder">
                </div>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="320" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==4">
                        <label for="">分组详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==9">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="">课程详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==23">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==26">
                        <label for="">分类列表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==26">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==46">
                        <label for="" class="label-name">付费预约：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==32">
                        <label for="" class="label-name">资讯分类：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==104">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" ng-model="banner.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>


                    <!-- 独立商城的商品分类及商品详情 -->
                    <!-- 一级分类 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==500">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                    </div>
                    <!-- 二级分类 -->
                     <div class="input-group-box clearfix" ng-show="banner.type==501">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                    </div>

                    <!-- 独立商城商品 -->
                    <div class="input-group-box clearfix" ng-show="banner.type==502">
                        <label for="" class="label-name">商品详情：</label>
                        <div class="select-goods-modal-btn" style="width: 180px">
                            <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择商品'" value="点击选择商品">
                            <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="banner.link" value="">
                        </div>
                    </div>
                    <!-- 独立商城的商品分类 -->
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航<span>(分类多于8个时手机端可横向滑动，管理界面不做展示)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
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
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label for="">资讯详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==4">
                            <label for="">分组详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in category" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==9">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==5">
                            <label for="">课程详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==26">
                            <label for="">分类列表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==46">
                            <label for="" class="label-name">付费预约：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                        </div>
                        <!-- 一级分类选择 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==26">
                            <label for="">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label  class="label-name" for="">小 程 序：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==32">
                            <label for="" class="label-name">资讯分类：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                            <label for="" class="label-name">菜　　单：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link" ng-options="x.path as x.name for x in pages"></select>
                        </div>


                        <!-- 独立商城的商品分类及商品详情 -->
                        <!-- 一级分类 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==500">
                            <label for="" class="label-name">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                        </div>
                        <!-- 二级分类 -->
                         <div class="input-group-box clearfix" ng-show="fenleiNav.type==501">
                            <label for="" class="label-name">分类详情：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                        </div>

                        <!-- 独立商城商品 -->
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==502">
                            <label for="" class="label-name">商品详情：</label>
                            <div class="select-goods-modal-btn" style="width: 180px">
                                <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择商品'" value="点击选择商品">
                                <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="fenleiNav.link" value="">
                            </div>
                        </div>
                        <!-- 独立商城的商品分类 -->

                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="member" data-right-edit data-id="5">
                <div class="isOn">
                    <span>开启会员入口</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="memberOpen">
                        <label class='tgl-btn' for='sms_start'></label>
                    </span>
                </div>
                <div class="shopintrobg-manage" ng-if="memberOpen">
                    <img onclick="toUpload(this)"  style="margin-top: 20px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="700" data-height="150" imageonload="changeBottomImg()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{bottomImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="bottomImg"  class="avatar-field bg-img" name="bottomImg{{$index}}" ng-value="bottomImg"/>
                </div>
            </div>
            <!-- 公告管理 -->
            <div class="fenleinav" data-right-edit data-id="6">
                <label>最新公告</label>
                <div class="input-group-box" style="margin-bottom: 20px;display: none">
                    <label class="label-name">公告标题：</label>
                    <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="4" ng-model="noticeTitle">
                </div>
                <div class="fenleinav-manage" ng-repeat="notice in noticeTxt" >
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                    <div class="edit-txt" style="float: none;width: 100%">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-groups" style="">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="notice.articleId" ng-options="x.id as x.title for x in articles"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>
            <!-- 公告管理 -->
            <div class="fenleinav" data-right-edit data-id="8">
                <label>音频推荐</label>
                <div class="input-group-box" style="margin-bottom: 20px;">
                    <label class="label-name">标题：</label>
                    <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="4" ng-model="audioTitle">
                </div>
                <div class="fenleinav-manage" ng-repeat="audio in recommendAudio" >
                    <div class="delete" ng-click="delIndex('recommendAudio',audio.index)">×</div>
                    <div class="edit-txt" style="float: none;width: 100%">
                        <div class="input-groups" style="">
                            <label for="">链接到：</label>
                            <input type="hidden" ng-model="audio.type" value="5">
                            <select class="cus-input" ng-model="audio.link" ng-options="x.id as x.name for x in audioList"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addAudio()"></div>
            </div>
            <!--
            <div class="fenleinav" data-right-edit data-id="3">
                <label style="width: 100%">{{recommendtitle}}</label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px">标题名称：</label>
                    <input type="text" class="cus-input" ng-model="recommendtitle" maxlength="15">
                </div>
                <div class="fenleinav-manage recommend-manage" >
                    <label  class="label-name" for="">用于展示推荐课程</label>
                </div>

            </div>
            -->
            <div class="banner" data-right-edit data-id="3">
                <label style="width:100%;">推荐管理<span>(图片尺寸340px*190px)</span></label>
                <div class="banner-manage">
                    标题：<input type="text" ng-model="recommendTitle" class="form-control">
                </div>
                <div class="banner-manage" ng-repeat="recommend in recommendList">
                    <div class="delete" ng-click="delIndex('recommendList',recommend.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="340" data-height="190" imageonload="doThis('recommendList',recommend.index)" data-dom-id="upload-recommend{{$index}}" id="upload-recommend{{$index}}"  ng-src="{{recommend.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="recommend{{$index}}"  class="avatar-field bg-img" name="recommend{{$index}}" ng-value="recommend.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group-box clearfix">
                        <label for="">标题：</label>
                        <input type="text" class="cus-input form-control" ng-model="recommend.title">
                    </div>
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="recommend.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="recommend.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==4">
                        <label for="">分组详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==9">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==5">
                        <label for="">课程详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="recommend.type==23">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==26">
                        <label for="">分类列表：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==46">
                        <label for="" class="label-name">付费预约：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box clearfix" ng-show="recommend.type==26">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==32">
                        <label for="" class="label-name">资讯分类：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="recommend.type==104">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" ng-model="recommend.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>

                    <!-- 独立商城的商品分类及商品详情 -->
                    <!-- 一级分类 -->
                    <div class="input-group-box clearfix" ng-show="recommend.type==500">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in independence_firstKindSelect" ></select>
                    </div>
                    <!-- 二级分类 -->
                     <div class="input-group-box clearfix" ng-show="recommend.type==501">
                        <label for="" class="label-name">分类详情：</label>
                        <select class="cus-input form-control" ng-model="recommend.link"  ng-options="x.id as x.name for x in independence_kindSelect" ></select>
                    </div>

                    <!-- 独立商城商品 -->
                    <div class="input-group-box clearfix" ng-show="recommend.type==502">
                        <label for="" class="label-name">商品详情：</label>
                        <div class="select-goods-modal-btn" style="width: 180px">
                            <input type="button" class="select-btn" onclick="toSelectGoods(this,1)" selectchange="doGoodsSelect(slide,'linkName')" ng-value="slide.linkName?slide.linkName:'点击选择商品'" value="点击选择商品">
                            <input type="hidden" class="avatar-field bg-img" selectchange="doGoodsSelect(slide,'link')" ng-value="recommend.link" value="">
                        </div>
                    </div>
                    <!-- 独立商城的商品分类 -->

                </div>
                <div class="add-box" title="添加" ng-click="addNewRecommend()"></div>
            </div>

            <div class="banner" data-right-edit data-id="7">
                <label style="width:100%;">推荐管理<span>(图片尺寸710px*260px)</span></label>
                <div class="banner-manage" ng-repeat="single in recommendBig">
                    <div class="delete" ng-click="delIndex('recommendBig',single.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="706" data-height="260" imageonload="doThis('recommendBig',single.index)" data-dom-id="upload-single{{$index}}" id="upload-single{{$index}}"  ng-src="{{single.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="single{{$index}}"  class="avatar-field bg-img" name="single{{$index}}" ng-value="single.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="single.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.title for x in articles" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="single.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==4">
                        <label for="">分组详情：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in category" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==9">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==5">
                        <label for="">课程详情：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>

                    <div class="input-group-box clearfix" ng-show="single.type==23">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==26">
                        <label for="">分类列表：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in knowpayType" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==46">
                        <label for="" class="label-name">付费预约：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in appointmentGoodsList"></select>
                    </div>

                    <div class="input-group-box clearfix" ng-show="single.type==26">
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="single.articleTitle"  ng-options="x.id as x.name for x in allKindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==32">
                        <label for="" class="label-name">资讯分类：</label>
                        <select class="cus-input form-control" ng-model="single.link"  ng-options="x.id as x.name for x in informationCategory" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="single.type==104">
                        <label for="" class="label-name">菜　　单：</label>
                        <select class="cus-input form-control" ng-model="single.link" ng-options="x.path as x.name for x in pages"></select>
                    </div>
                </div>

                <div class="add-box" title="添加" ng-click="addSingle()" ng-show="recommendBig.length <= 0"></div>
            </div>
            <div class="member" data-right-edit data-id="9">
                <label style="width:100%;">精选语录</label>
                <div>
                    标题:
                    <input type="text" ng-model="quotationTitle" class="form-control">
                </div>
                <div class="isOn">
                    <span>开启精选语录</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='quotation_open' type='checkbox' ng-model="quotationOpen">
                        <label class='tgl-btn' for='quotation_open'></label>
                    </span>
                </div>
                <div class="fenleinav-manage recommend-manage" style="margin-top: 10px">
                    <label  class="label-name" for="">用于展示推荐语录</label>
                </div>

            </div>

            <div class="fenleinav" data-right-edit data-id="4">
                <label style="width: 100%">分类课程展示管理</label>
                <div class="fenleinav-manage" ng-repeat="goodfl in goodFlShow">
                    <div class="delete" ng-click="delIndex('goodFlShow',goodfl.index)">×</div>
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <label style="width: 70px">标题名称：</label>
                        <input type="text" class="cus-input" ng-model="goodfl.title" maxlength="15">
                    </div>
                    <div class="input-group-box" style="margin-bottom: 10px;">
                        <label style="width: 70px">课程分类：</label>
                        <select class="cus-input" ng-model="goodfl.link" ng-options="x.id as x.name for x in knowpayType"></select>
                    </div>
                    <!-- 一级分类选择 -->
                    <div class="input-group-box" style="margin-bottom: 10px;" >
                        <label for="">分类详情：</label>
                        <select class="cus-input form-control" ng-model="goodfl.sign"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>
                    <div class="good-tip">注：将从您选择的分类中取出最多10个课程显示~</div>
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
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.goodsList = <{$goodsList}>;
        $scope.kindSelect = <{$kindSelect}>;
        console.log('二级分类');
        console.log($scope.kindSelect);
        $scope.knowpayType = <{$knowpayType}>
        $scope.firstKindSelect = <{$firstKindSelect}>;
        console.log('一级分类');
        console.log($scope.firstKindSelect);
        $scope.headerTitle= "<{$tpl['aki_title']}>" ? "<{$tpl['aki_title']}>" : "店铺首页" ;
        $scope.searchPlaceholder = '<{$tpl['aki_search_tip']}>' ? '<{$tpl['aki_search_tip']}>' : '请输入关键字';
        $scope.banners = <{$slide}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.goodFlShow = <{$kindList}>;
        $scope.recommendTitle = '<{$tpl['aki_recommend_title']}>' ? '<{$tpl['aki_recommend_title']}>' : '推荐';
        $scope.bottomImg = '<{$tpl['aki_member_entrance_img']}>'?'<{$tpl['aki_member_entrance_img']}>':'/public/wxapp/images/member-enter.png';
        $scope.memberOpen = <{$tpl['aki_member_entrance_open']}>?true :false;
        $scope.recommendList = <{$recommendList}>;
        $scope.recommendBig = <{$recommendBig}>;
        $scope.recommendAudio = <{$recommendAudio}>;
        console.log($scope.recommendBig);
        $scope.tpl_id = 65;
        $scope.noticeTitle    = '<{$tpl['aki_notice_title']}>'?'<{$tpl['aki_notice_title']}>':'公告';
        $scope.noticeTxt       = <{$noticeList}>;
        $scope.articles        = <{$information}>;
        $scope.audioTitle = '<{$tpl['aki_audio_title']}>' ? '<{$tpl['aki_audio_title']}>' : '推荐音频';
        $scope.audioList = <{$audioList}>;
        $scope.quotationOpen = <{$tpl['aki_quotation_open']}>?true :false;
        $scope.quotationTitle = '<{$tpl['aki_quotation_title']}>' ? '<{$tpl['aki_quotation_title']}>' : '精选语录';
        $scope.pages                =  <{$page_list}>;
        $scope.informationCategory  = <{$informationCategory}>;
        $scope.articleCoverType     = "<{$tpl['aki_article_cover_type']}>";
        $scope.audioCoverType       = "<{$tpl['aki_audio_cover_type']}>";
        $scope.videoCoverType       = "<{$tpl['aki_video_cover_type']}>";
        $scope.appointmentGoodsList = <{$appointmentGoodsList}>;
        $scope.allKindSelect        = <{$allKindSelect}>;

         // 独立商城分类
        <{if $appletCfg['ac_type'] == 27 }>
        $scope.independence_kindSelect           = <{$independence_kindSelect}>;
        $scope.independence_firstKindSelect      = <{$independence_firstKindSelect}>;
        <{/if}>

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
                    articleId: 0,
                    link : '',
                    type : '4',
                    articleTitle : 0
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
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_320.png',
                    articleId: $scope.goodsList[0] ? $scope.goodsList[0].id :'',
                    link : $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    type : '5',
                    articleTitle : 0
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
            if(notice_length>=20){
                layer.msg("最多只能添加20条公告哦~");
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

        /*添加新的推荐信息*/
        $scope.addNewRecommend = function(){
            var recommendList_length = $scope.recommendList.length;
            var defaultIndex = 0;
            if(recommendList_length>0){
                for (var i=0;i<recommendList_length;i++){
                    if(defaultIndex < $scope.recommendList[i].index){
                        defaultIndex = $scope.recommendList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(recommendList_length>=10){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加10个推荐信息',
                    time: 2000
                });
            }else{
                var recommendList_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_35_21.png',
                    articleId: $scope.goodsList[0] ? $scope.goodsList[0].id :'',
                    link : $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    type : '5',
                    title : '默认标题',
                    articleTitle : 0
                };
                $scope.recommendList.push(recommendList_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.recommendList);
        };

        $scope.addSingle = function(){
            var recommendBig_length = $scope.recommendBig.length;
            var defaultIndex = 0;
            if(recommendBig_length>0){
                for (var i=0;i<recommendBig_length;i++){
                    if(defaultIndex < $scope.recommendBig[i].index){
                        defaultIndex = $scope.recommendBig[i].index;
                    }
                }
                defaultIndex++;
            }
            if(recommendBig_length>=1){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加1个',
                    time: 2000
                });
            }else{
                var recommendBig_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_74_27.png',
                    articleId: $scope.goodsList[0] ? $scope.goodsList[0].id :'',
                    link : $scope.goodsList[0]?$scope.goodsList[0].id:'',
                    type : '5',
                    articleTitle : 0
                };
                $scope.recommendBig.push(recommendBig_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.recommendList);
        };

        $scope.addAudio = function(){
            var recommendAudio_length = $scope.recommendAudio.length;
            var defaultIndex = 0;
            if(recommendAudio_length>0){
                for (var i=0;i<recommendAudio_length;i++){
                    if(defaultIndex < $scope.recommendAudio[i].index){
                        defaultIndex = $scope.recommendAudio[i].index;
                    }
                }
                defaultIndex++;
            }
            if(recommendAudio_length>=6){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加6个推荐音频',
                    time: 2000
                });
            }else{
                var recommendAudio_Default = {
                    index: defaultIndex,
                    link : '',
                    type : '5'
                };
                $scope.recommendAudio.push(recommendAudio_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.recommendAudio);
        };

        /*添加新的课程分类*/
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
            if(goodfl_length>=8){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加8个课程分类哦',
                    time: 2000
                });
            }else{
                var goodfl_Default = {
                    index: defaultIndex,
                    title:'默认名称',
                    link: $scope.kindSelect[0]?$scope.kindSelect[0].id:'',
                    sign: 0
                };
                $scope.goodFlShow.push(goodfl_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.goodFlShow);
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
                if($scope[type].length>0){
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                }else{
                    layer.msg('没有可删除的了');
                }
            });
        };
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取图片的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopintrobg = imgNowsrc;
            }
        };

        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.bottomImg = imgNowsrc;
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
            /*控制店铺图片宽高比*/
            // $(".shop-bg").height($(".shop-bg").width()*0.3175);
            initListShow()
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
                'noticeTitle'   : $scope.noticeTitle,
                'articleCoverType' : $scope.articleCoverType,
                'audioCoverType'   : $scope.audioCoverType,
                'videoCoverType'   : $scope.videoCoverType,
                'notice'        : $scope.noticeTxt,
                'recommendList' : $scope.recommendList,
                'recommendBig' : $scope.recommendBig,
                'recommendAudio': $scope.recommendAudio,
                'audioTitle'    : $scope.audioTitle,
                'quotationTitle': $scope.quotationTitle,
                'quotationOpen' : $scope.quotationOpen == true ?1:0,
                'tpl_id'        : $scope.tpl_id,
                'title' 	    : $scope.headerTitle,
                'searchTip' 	: $scope.searchPlaceholder,
                'slide'		    : $scope.banners,
                'shortcut'	    : $scope.fenleiNavs,
                'kind'          : $scope.goodFlShow,
                'recommendTitle'  : $scope.recommendTitle,
                'memberEntrance'  : $scope.bottomImg,
                'memberOpen'      : $scope.memberOpen == true ?1:0
            };
            $http({
                method: 'POST',
                url:    '/wxapp/knowledgepay/saveAppletTpl',
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
<{include file="../img-upload-modal-new.tpl"}>
<{include file="../goods-select-modal.tpl"}>
