<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp22/css/index.css?5">
<link rel="stylesheet" href="/public/wxapp/index/temp22/css/style.css?3">
<style>
    .recommend-img { padding: 0 4px 10px; overflow: hidden;margin-bottom: 8px; }
    .recommend-img .img-item { padding: 4px; box-sizing: border-box; float: left;margin: 0; width: 50%; height: 100px; }
    .recommend-manage { padding: 15px; }
    .recommend-manage .edit-img { float: none; width: 90%; -webkit-border-radius: 0; -moz-border-radius: 0; -ms-border-radius: 0; border-radius: 0; height: auto; margin: 0 auto 8px; }
    .recommend-manage .edit-txt { float: none; width: 100% }
    .notice-box .notice-txt {
        height: 40px;
    }

    .notice-box .noticeicon {
        width: 50px;
        margin-right: 15px;
    }

    .fenlei-nav ul {
        white-space: inherit;
        height: 150px;
    }

    .fenlei-nav li img {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
    }

    .fenleinav-manage .edit-img {
        -webkit-border-radius: 10px;
        -moz-border-radius: 10px;
        -ms-border-radius: 10px;
        border-radius: 10px;
    }
    .edit-con input[type=number], .edit-con select, .edit-con textarea {
        padding: 7px 8px;
        font-size: 14px;
        border: 1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        width: 100%;
        -webkit-transition: box-shadow 0.5s;
        -moz-transition: box-shadow 0.5s;
        -ms-transition: box-shadow 0.5s;
        -o-transition: box-shadow 0.5s;
        transition: box-shadow 0.5s;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        min-height: 34px;
        resize: none;
        background-color: #fff;
    }
    .post-type .tg-list-item{
        display: inline;
        float: right;
        margin-right: 35%;
    }
    .post-type .edit-txt{
        margin-bottom: 10px;
    }
    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }
    .fenlei-nav li {
        width: 20%;
    }
    .fenleinav-manage .input-num input{border-radius:0;text-align: center;}
    .fenleinav-manage .input-num label{width:88px;line-height:3!important;}
    .fenleinav-manage .input-num .input-group-addon{line-height:2!important;}
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
                    <!-- 幻灯 -->
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_75_40.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>
                    <!-- 分类导航 -->
                    <div class="fenlei-nav" data-left-preview data-id="2">
                        <div class="no-nav" ng-if="fenleiNavs.length<=0">
                            暂无分类哦~
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
                        <!--<img src="/public/wxapp/train/images/home_notable.png" class="noticeicon" alt="图标">-->
                        <div style="display: inline-block;font-size: 18px;width: 40px;float:left;margin:0 5px;color: #FC7C7C;margin-top: -2px">{{noticeTitle}}</div>
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>
                    <!---->
                    <div class="fenlei-nav" data-left-preview data-id="4" style="background-color: #fff;">
                        <div class="title-name flex-wrap">
                            <p class="flex-con" style="text-align: center;font-size: 15px">{{recommendtitle}}</p>
                        </div>
                        <ul ng-if="shop.length>0" style="height: 80px">
                            <li ng-repeat="cover in shop">
                                <a href="javascript:;">
                                    <img ng-src="{{cover.cover}}" alt="分类导航">
                                    <p ng-bind="cover.name"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="hot-recommend" data-left-preview data-id="5">
                        <div class="title-name flex-wrap" style="margin-bottom: 10px;">
                            <p class="flex-con" style="text-align: center">{{infotitle}}</p>
                        </div>
                        <div class="recommend-img">
                            <div class="no-data-tip" ng-if="recommendGood.length<=0">点此添加推荐商品~</div>
                            <div class="img-item" ng-repeat="good in recommendGood" style="height:80px">
                                <img ng-src="{{good.imgsrc}}" />
                            </div>
                        </div>
                    </div>
                    <!---->
                    <div class="notice-box classify-preiview-page" data-left-preview data-id="6">
                        <div class="classify-name">
                            <span ng-repeat="type in postType">{{type.name}}</span>
                        </div>
                    </div>
                    
                    <div class="appointment-wrap" data-left-preview data-id="7" style="display: none;">
                        <div class="no-data-tip" style="font-size: 20px;color: red">点此管理发帖设置</div>
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
                    <div class="input-groups">
                        <label for="">页面标题</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label style="width: 100%;">幻灯管理<span>(幻灯图片建议尺寸:750px*300px)</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<{if $appletCfg['ac_type'] eq 14}>
                        <div class="cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <{else}>
                            <div class="cropper-box" data-width="750" data-height="300" style="height:100%;">
                                <{/if}>
                                <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                                <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                            </div>
                        </div>-->
                        <div>
                            <{if $appletCfg['ac_type'] eq 14}>
                        <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <{else}>
                        <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <{/if}>
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <!--
                    <div class="input-group clearfix">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('banners',banner.index,banner.articleTitle)"></select>
                    </div>
                    -->
                    <div class="input-group clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
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
                        <input type="text" class="cus-input" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==5">
                        <label for="" style="width: 20%;float: left;">商品详情：</label>
                        <select class="cus-input form-control" style="padding:2px 15px;width: 80%;float: left;" ng-model="banner.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==20">
                        <label for="" style="width: 20%;float: left;">店铺详情：</label>
                        <select class="cus-input form-control" style="padding:2px 15px;width: 80%;float: left;" ng-model="banner.link"  ng-options="x.id as x.name for x in shopList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==34">
                        <label for="">店铺分类：</label>
                        <select class="cus-input" style="padding:2px 15px" ng-model="banner.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                    </div>
                    <!-- 自营商品一级分类 -->
                    <div class="input-group clearfix" ng-show="banner.type==23">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                    </div>
                    <!-- 自营商品二级分类 -->
                    <div class="input-group clearfix" ng-show="banner.type==9">
                        <label for="">商品分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                    </div>

                    <div class="input-group clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==32">
                        <label for="">资讯分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                    </div>
                    <div class="input-group clearfix" ng-show="banner.type==40">
                        <label for="">帖子分类：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.title for x in postCategory" ></select>
                    </div>

                    <div class="input-group clearfix" ng-show="banner.type==59">
                        <label for="">商品详情：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in shopLimitList" ></select>
                    </div>

                    <div class="input-group clearfix" ng-show="banner.type==60">
                        <label for="">商品详情：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in shopBargainList" ></select>
                    </div>

                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <!-- 导航 -->
            <div class="fenleinav" data-right-edit data-id="2" ui-sortable ng-model="fenleiNavs">
                <label style="width: 100%">分类导航<span>(分类最多显示10个，超过向右滑动，此处不做展示，图标尺寸200*200)(如果选择类型为快递将会跳转到查询快递页面)</span></label>
                <div class="isOn" style="height: 50px;line-height: 40px">
                    <span style="font-weight: bold">首页是否开启发布按钮:</span>
                    <span class='tg-list-item' style="width: 65%;float: right;margin-top: 5px">
                        <input class='tgl tgl-light' id='open_submit' type='checkbox' ng-model="postSubmit">
                        <label class='tgl-btn' for='open_submit'></label>
                    </span>
                </div>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
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
                            <label for="">标　题：</label>
                            <input type="text" maxlength="5" ng-model="fenleiNav.title">
                        </div>
                        <div class="input-group clearfix">
                            <label for="">类　型：</label>
                            <select class="cus-input" ng-model="fenleiNav.type" ng-options="x.type as x.name for x in fenleiNavsType"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.type==1">
                            <label for="">价　格：</label>
                            <input type="text" maxlength="10" ng-model="fenleiNav.price">
                        </div>
                        <div style="height: 35px" ng-if="fenleiNav.type==1">
                            <span style="float: left;margin-right: 10px;">小程序端是否显示:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='must_isshow{{$index}}' type='checkbox' ng-model="fenleiNav.isshow">
                                <label class='tgl-btn' for='must_isshow{{$index}}' style="width: 56px;"></label>
                            </span>
                        </div>
                        <div style="height: 35px" ng-if="fenleiNav.type==1">
                            <span style="float: left;margin-right: 10px;">发帖时电话是否必填:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='must_mobile{{$index}}' type='checkbox' ng-model="fenleiNav.mobileShow">
                                <label class='tgl-btn' for='must_mobile{{$index}}' style="width: 56px;"></label>
                            </span>
                        </div>
                        <div style="height: 35px" ng-if="fenleiNav.type==1">
                            <span style="float: left;margin-right: 10px;">发帖时地址是否必填:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='must_address{{$index}}' type='checkbox' ng-model="fenleiNav.addressShow">
                                <label class='tgl-btn' for='must_address{{$index}}' style="width: 56px;"></label>
                            </span>
                        </div>
                        <div style="height: 35px" ng-if="fenleiNav.type==1">
                            <span style="float: left;margin-right: 10px;">该分类是否允许评论:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='must_comment{{$index}}' type='checkbox' ng-model="fenleiNav.allowComment">
                                <label class='tgl-btn' for='must_comment{{$index}}' style="width: 56px;"></label>
                            </span>
                        </div>
                        <div style="height: 35px" ng-if="fenleiNav.type==1">
                            <span style="float: left;margin-right: 10px;">该分类评论是否需要审核:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='verify_comment{{$index}}' type='checkbox' ng-model="fenleiNav.verifyComment">
                                <label class='tgl-btn' for='verify_comment{{$index}}' style="width: 56px;"></label>
                            </span>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.type==3">
                            <label for="">列　表：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl" ng-options="x.path as x.name for x in linkList"></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.type==4">
                            <label for="">单　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.type==32">
                            <label for="">资讯分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl"  ng-options="x.id as x.name for x in infocateList" ></select>
                        </div>
                        <div class="input-group clearfix" ng-if="fenleiNav.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl" ng-options="x.appid as x.name for x in jumpList"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==104">
                            <label for="">菜　　单：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl" ng-options="x.path as x.name for x in pages"></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==34">
                            <label for="">店铺分类：</label>
                            <select class="cus-input" ng-model="fenleiNav.linkUrl" ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="3">
                <label>最新公告</label>
                <div class="input-group-box" style="margin-bottom: 20px;">
                    <label class="label-name">公告标题：</label>
                    <input type="text" class="cus-input" placeholder="请输入公告标题" maxlength="4" ng-model="noticeTitle">
                </div>
                <div class="service-manage" ng-repeat="notice in noticeTxt">
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="notice.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('noticeTxt',notice.index,notice.articleTitle)"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>
            <!---->
            <div class="notice" data-right-edit data-id="4">
                <label>{{recommendtitle}}展示（滑动展示）</label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 80px">标题名称：</label>
                    <input type="text" class="cus-input" ng-model="recommendtitle" maxlength="15">
                </div>
                <div class="isOn">
                    <span>是否开启:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='recommend_open' type='checkbox' ng-model="recommendOpen">
                        <label class='tgl-btn' for='recommend_open' style="float: right;margin-right: 72%;width: 60px;"></label>
                    </span>
                </div>
                <div>
                    <!--<label>如果选择开启将选取最新入驻的十家店铺展示</label>-->
                    <label>如果选择开启将展示附近商家推荐好店内的店铺</label>
                </div>
            </div>
            <div class="fenleinav" data-right-edit data-id="5">
                <label style="width: 100%">{{infotitle}}<span>(图片建议尺寸为345px*155px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 80px">标题名称：</label>
                    <input type="text" class="cus-input" ng-model="infotitle" maxlength="15">
                </div>
                <div class="fenleinav-manage recommend-manage" ng-repeat="good in recommendGood">
                    <div class="delete" ng-click="delIndex('recommendGood',good.index)">×</div>
                    <div class="edit-img" style="width: 50%;">
                        <!--<div class="cropper-box" data-width="400" data-height="250" style="height:100%;">
                            <img ng-src="{{good.imgsrc}}"  onload="changeSrc(this)" imageonload="doThis('recommendGood',good.index)" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="good.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="345" data-height="155" imageonload="doThis('recommendGood',good.index)" data-dom-id="upload-good{{$index}}" id="upload-good{{$index}}"  ng-src="{{good.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="good{{$index}}"  class="avatar-field bg-img" name="good{{$index}}" ng-value="good.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix" style="height: 40px">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="good.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="good.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="good.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="good.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <!--<div class="input-group-box clearfix" ng-show="good.type==4">
                            <label for="">商品分组详情：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in ordinaryGoodsGroup" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==9">
                            <label for="">商品分类详情：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>-->
                        <div class="input-group-box clearfix" ng-show="good.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="good.link"  ng-options="x.id as x.name for x in goodsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==22">
                            <label for="">秒杀分组：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in category" ></select>
                        </div>
                        <!--<div class="input-group-box clearfix" ng-show="good.type==16">
                            <label for="">店铺分类详情：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>-->
                        <div class="input-group-box clearfix" ng-show="good.type==20">
                            <label for="">店铺详情：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="good.link"  ng-options="x.id as x.name for x in shopList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==34">
                            <label for="">店铺分类：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="good.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>
                        <!-- 自营商品一级分类 -->
                        <div class="input-group-box clearfix" ng-show="good.type==23">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                        </div>
                        <!-- 自营商品二级分类 -->
                        <div class="input-group-box clearfix" ng-show="good.type==9">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==32">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==40">
                            <label for="">帖子分类：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.title for x in postCategory" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="good.link" ng-model="good.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="good.type==59">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in shopLimitList" ></select>
                        </div>

                        <div class="input-group-box clearfix" ng-show="good.type==60">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="good.link"  ng-options="x.id as x.name for x in shopBargainList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addRecommendGood()"></div>
            </div>
            <!---->


            <div class="notice post-type" data-right-edit data-id="6">
                <label>帖子类型</label>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="postType[0].name">
                        <span class='tg-list-item' >
                            <input class='tgl tgl-light' id='must_type0' type='checkbox' ng-model="postType[0].must">
                            <label class='tgl-btn' for='must_type0'></label>
                        </span>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="postType[1].name">
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='must_type1' type='checkbox' ng-model="postType[1].must">
                            <label class='tgl-btn' for='must_type1'></label>
                        </span>
                        <span style="color:red;font-size: 13px">建议审核时先关闭，等审核通过再开启该功能</span>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="postType[2].name">
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='must_type2' type='checkbox' ng-model="postType[2].must">
                            <label class='tgl-btn' for='must_type2'></label>
                        </span>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="postType[3].name">
                        <span class='tg-list-item' >
                            <input class='tgl tgl-light' id='must_type3' type='checkbox' ng-model="postType[3].must">
                            <label class='tgl-btn' for='must_type3'></label>
                        </span>
                    </div>
                </div>
                <label>自定义链接</label>
                <div class="fenleinav-manage recommend-manage" ng-repeat="tab in tabList">
                    <div class="delete" ng-click="delIndex('tabList',tab.index)">×</div>
                    <!--
                    <div class="edit-img" style="width: 50%;">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="345" data-height="155" imageonload="doThis('recommendGood',tab.index)" data-dom-id="upload-tab{{$index}}" id="upload-tab{{$index}}"  ng-src="{{tab.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="tab{{$index}}"  class="avatar-field bg-img" name="tab{{$index}}" ng-value="tab.imgsrc"/>
                        </div>
                    </div>
                    -->
                    <div class="edit-txt">
                        <div class="input-group-box clearfix" style="height: 40px">
                            <label for="">链接标题：</label>
                            <input class="cus-input form-control" style="padding:2px 15px" type="text" ng-model="tab.name" >
                        </div>
                        <div class="input-group-box clearfix" style="height: 40px">
                            <label for="">链接类型：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="tab.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="tab.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="tab.link"  ng-options="x.id as x.title for x in articles" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="tab.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <!--<div class="input-group-box clearfix" ng-show="tab.type==4">
                            <label for="">商品分组详情：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in ordinaryGoodsGroup" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==9">
                            <label for="">商品分类详情：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>-->
                        <div class="input-group-box clearfix" ng-show="tab.type==5">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="tab.link"  ng-options="x.id as x.name for x in tabsList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==22">
                            <label for="">秒杀分组：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in category" ></select>
                        </div>
                        <!--<div class="input-group-box clearfix" ng-show="tab.type==16">
                            <label for="">店铺分类详情：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>-->
                        <div class="input-group-box clearfix" ng-show="tab.type==20">
                            <label for="">店铺详情：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="tab.link"  ng-options="x.id as x.name for x in shopList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==34">
                            <label for="">店铺分类：</label>
                            <select class="cus-input form-control" style="padding:2px 15px" ng-model="tab.link"  ng-options="x.id as x.name for x in shopCategory" ></select>
                        </div>
                        <!-- 自营商品一级分类 -->
                        <div class="input-group-box clearfix" ng-show="tab.type==23">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                        </div>
                        <!-- 自营商品二级分类 -->
                        <div class="input-group-box clearfix" ng-show="tab.type==9">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==32">
                            <label for="">商品分类：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in infocateList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==40">
                            <label for="">帖子分类：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.title for x in postCategory" ></select>
                        </div>
                        <div class="input-group clearfix" ng-show="tab.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="tab.link" ng-model="tab.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="tab.type==59">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopLimitList" ></select>
                        </div>

                        <div class="input-group-box clearfix" ng-show="tab.type==60">
                            <label for="">商品详情：</label>
                            <select class="cus-input form-control" ng-model="tab.link"  ng-options="x.id as x.name for x in shopBargainList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addTabList()"></div>
            </div>
            <div class="appoint" data-right-edit data-id="7">
                <div class="isOn">
                    <span>是否先发布再审核（如果选择是则会先显示后台可以审核，如果选择否则后台审核通过才会显示）:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='post_audit' type='checkbox' ng-model="postAudit">
                        <label class='tgl-btn' for='post_audit'></label>
                    </span>
                </div>
                <div class="isOn">
                    <span>是否开启同城帖子隐私功能（如果选择开启则只有成为同城会员才可以查看发帖人名片、电话等信息）:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='city_member' type='checkbox' ng-model="cityMember">
                        <label class='tgl-btn' for='city_member'></label>
                    </span>
                </div>
                <div class="isOn">
                    <span>是否允许帖子内容显示电话:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='content_mobile' type='checkbox' ng-model="contentMobile">
                        <label class='tgl-btn' for='content_mobile'></label>
                    </span>
                </div>
                <!--
                <div class="isOn">
                    <span>发帖地址是否必填:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='must_address' type='checkbox' ng-model="postAddress">
                        <label class='tgl-btn' for='must_address'></label>
                    </span>
                </div>
                <div class="isOn">
                    <span>发帖电话是否必填:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='must_mobile' type='checkbox' ng-model="postMobile">
                        <label class='tgl-btn' for='must_mobile'></label>
                    </span>
                </div>
                -->
                <div class="edit-txt">
                    <!--
                    <div class="input-groups">
                        <label for="">每天允许发帖数量（0表示不限制）：</label>
                        <input type="number" class="cus-input" ng-model="postNum">
                    </div>
                    -->
                    <div class="isOn">
                        <span>发帖时是否允许填写标签:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id='label_open' type='checkbox' ng-model="labelOpen">
                            <label class='tgl-btn' for='label_open'></label>
                        </span>
                    </div>
                    <div class="input-groups">
                        <label for="">发帖红包服务费率(%)：</label>
                        <input type="number" class="cus-input" ng-model="serviceRate">
                        <span style="float: right;margin-top: -34px;position: relative;margin-right: 12px;font-size: 20px;color: #aaa;">%</span>
                    </div>
                    <div class="input-groups">
                        <label for="">发帖红包最小金额(元)：</label>
                        <input type="number" class="cus-input" ng-model="redbagMin" placeholder="0表示不限制">
                    </div>
                    <div class="input-groups">
                        <label for="">单个红包最小金额(元)：</label>
                        <input type="number" class="cus-input" ng-model="singleMin" placeholder="0表示不限制">
                    </div>
                    <div class="input-groups">
                        <label for="">红包过期退款时间：</label>
                        <select class="cus-input" ng-model="refundDate" ng-options="x.value as x.title for x in days"></select>
                    </div>
                    <div class="input-groups" style="margin-bottom: 5px">
                        <label for="">发帖提示：</label>
                        <textarea rows="3" class="cus-input" ng-model="brief['brief']" placeholder="请输入发帖提示信息"></textarea>
                    </div>
                    <div class="input-groups" style="margin-bottom: 5px">
                        <label for="">发帖温馨提示：</label>
                        <textarea rows="3" class="cus-input" ng-model="tips['tips']" placeholder="请输入发帖温馨提示信息"></textarea>
                    </div>
                        <div class="fenleinav-manage">
                            <label style="font-weight: bold">会员每天允许发帖数量（0表示没有免费次数）</label><a href="http://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=387&extra=" target="_blank" style="color: red">查看设置教程</a>
                            <div class="input-num flex-wrap" style="margin-bottom: 5px">
                                <label for="">未订购会员：</label>
                                <div class="input-group-addon" style="width: 70px;font-size: 12px;padding: 6px 0">免费贴数量</div>
                                <input type="number" class="cus-input" ng-model="postNum" style="width: 10%;margin-right:10px;">
                                <div class="input-group-addon" style="width: 85px;font-size: 12px;padding: 6px 0" >超过数量价格</div>
                                <input type="number" class="cus-input" ng-model="postPrice" style="width: 10%;">
                            </div>
                            <div class="input-groups" ng-repeat="card in memberCardType">
                                <div class="input-num flex-wrap" style="margin-bottom: 5px">
                                <label for="">{{card.name}}：</label>
                                <input type="hidden" class="cus-input" ng-model="card.id">
                                <div class="input-group-addon" style="width: 70px;font-size: 12px;padding: 6px 0">免费贴数量</div>
                                <input type="number" class="cus-input" ng-model="card.freenum" style="width: 10%;margin-right:10px;">
                                    <div class="input-group-addon" style="width: 85px;font-size: 12px;padding: 6px 0">超过数量价格</div>
                                    <input type="number" class="cus-input" ng-model="card.postPrice" style="width: 10%;margin-right:10px;">
                                <div class="input-group-addon" style="width: 70px;font-size: 12px;padding: 6px 0">付费贴数量</div>
                                <input type="number" class="cus-input" ng-model="card.paynum" style="width: 10%;">
                                </div>
                            </div>
                        </div>
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
                        <span class="tg-list-iem">
                            <input class="tgl tgl-light ng-untouched ng-valid ng-dirty ng-valid-parse" id="navList0_start" type="checkbox" ng-model="issueNumOpen">
                            <label class="tgl-btn" for="navList0_start"></label>
                        </span>
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
            <div class="appoint" data-right-edit data-id="9">
                <div class="fenleinav-manage">
                    <div class="edit-img" style="width: 19%">
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" onload="changeSrc(this)" data-width="260" data-height="260" imageonload="changeApplyIcon()" data-dom-id="upload-applyIcon" id="upload-applyIcon"  ng-src="{{applyIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="applyIcon"  class="avatar-field bg-img" name="applyIcon{{$index}}" ng-value="applyIcon"/>
                        </div>
                    </div>
                    <div class="edit-txt" style="width:80%;">
                        <div class="input-group clearfix">
                            <label for="" style="width: 17%;">标　题：</label>
                            <input type="text" maxlength="15" ng-model="applyTitle" style="width:83%;">
                        </div>
                        <div class="input-group clearfix">
                            <label for="" style="width: 17%;">标　签：</label>
                            <input type="text" maxlength="30" ng-model="applyDesc" style="width:83%;">
                        </div>
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
<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>


<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.shopCategory = <{$shopCategory}>;
        $scope.currSecondKindSelect = <{$currSecondKindSelect}>;
        $scope.currFirstKindSelect = <{$currFirstKindSelect}>;
        $scope.articles        = <{$information}>;
        $scope.headerTitle     = '<{$tpl['aci_title']}>';
        $scope.browseNum       = '<{$tpl['aci_browse_num']}>';
        $scope.issueNum        = '<{$tpl['aci_issue_num']}>';
        $scope.issueNumOpen    = <{$tpl['aci_issue_num_open']}> == 1 ? true : false;
        $scope.shopNum         = '<{$tpl['aci_shop_num']}>';
        $scope.addMemberNum    = '<{$tpl['aci_add_member']}>';
        $scope.serviceRate     = <{$tpl['aci_service_rate']}>;
        $scope.redbagMin       = <{$tpl['aci_redbag_min']}>;
        $scope.postNum         = <{$tpl['aci_post_num']}>;
        $scope.postPrice         = <{$tpl['aci_post_price']}>;
        $scope.singleMin       = <{$tpl['aci_single_min']}>;
        $scope.refundDate      = '<{$tpl['aci_refund_date']}>';
        $scope.noticeTitle    = '<{$tpl['aci_notice_title']}>'?'<{$tpl['aci_notice_title']}>':'同城头条';
        $scope.brief           = <{$brief}>;
        $scope.tips           = <{$tips}>;
        $scope.banners         = <{$slide}>;
        $scope.noticeTxt       = <{$noticeList}>;
        $scope.fenleiNavs      = <{$shortcut}>;
        $scope.pages           = <{$page_list}>;
        $scope.fenleiNavsType  = [{type:'1',name:'帖子'},{type:'2',name:'快递助手'},{type:'3',name:'列表'},{type:'4',name:'资讯详情'},{type:'104',name:'菜单'},{type:'105',name:'签到'},{type:'106',name:'小程序'},{type:'32',name:'资讯分类'},{type:'34',name:'店铺分类'}];
        $scope.postAudit       = <{$tpl['aci_post_audit']}> > 1 ? false : true ;
        $scope.labelOpen       = <{$tpl['aci_label_open']}> ? true : false;
        $scope.postAddress     = <{$tpl['aci_must_address']}> ? true : false ;
        $scope.postMobile      = <{$tpl['aci_must_mobile']}> ? true : false ;
        $scope.days            = [{value:'1',title:'1天'},{value:'2',title:'2天'},{value:'3',title:'3天'},{value:'4',title:'4天'},{value:'5',title:'5天'},{value:'6',title:'6天'},{value:'7',title:'7天'}]
        $scope.postType        = <{$tpl['aci_post_type']}>;
        $scope.tpl_id	  = 23;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkTypesNew = <{$linkTypeNew}>;
        $scope.linkList  = <{$linkList}>;
        $scope.recommendtitle     = '<{$tpl['aci_recommend_title']}>'?'<{$tpl['aci_recommend_title']}>':'推荐店铺';
        $scope.recommendOpen     = <{$tpl['aci_recommend_open']}> > 0 ? true : false ;
        $scope.postSubmit        = <{$tpl['aci_post_submit']}> > 0 ? true : false ;
        $scope.infotitle          = '<{$tpl['aci_info_title']}>'?'<{$tpl['aci_info_title']}>':'优惠活动';
        $scope.goodsList          = <{$goodsList}>;
        $scope.shopList           = <{$shopList}>;
        $scope.shop               = <{$shop}>;
        $scope.recommendGood      = <{$infoList}>;
        $scope.infocateList       = <{$infocateList}>;
        $scope.applyIcon          = '<{$tpl['aci_apply_icon']}>'?'<{$tpl['aci_apply_icon']}>':'/public/wxapp/images/icon_shop.png';
        $scope.statIcon          = '<{$tpl['aci_stat_icon']}>'?'<{$tpl['aci_stat_icon']}>':'/public/wxapp/customtpl/images/icon_tj.png';
        $scope.applyTitle         = '<{$tpl['aci_apply_title']}>'?'<{$tpl['aci_apply_title']}>':'我是商家，我要入驻';
        $scope.applyDesc          = '<{$tpl['aci_apply_desc']}>'?'<{$tpl['aci_apply_desc']}>':'超低成本，本地宣传，简单有效，方便快捷';
        $scope.applyOpen          = <{$tpl['aci_apply_open']}> > 0 ? true : false ;
        $scope.memberCardType     = <{$memberCardType}>,
        $scope.cityMember         = <{$tpl['aci_citymember_open']}>?true :false ;
        $scope.contentMobile         = <{$tpl['aci_content_mobile_show']}> ? true :false ;
        $scope.jumpList = <{$jumpList}>;
        $scope.postCategory = <{$postCategory}>;
        $scope.tabList = <{$tabList}>;

        $scope.shopLimitList = <{$shopLimitList}>;
        $scope.shopBargainList = <{$shopBargainList}>;

        /*$scope.ordinaryGoodsGroup = <{$ordinaryGoodsGroup}>;
        $scope.category           = <{$goodsGroup}>;
        $scope.kindSelect         = <{$kindSelect}>;
        $scope.shopList           = <{$shopList}>;
        $scope.shopCategory       = <{$shopCategory}>;
       */


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
                layer.msg("最多只能添加8张广告图哦~");
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_320.png',
                    link: $scope.articles.length>0?$scope.articles[0].id:'',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:'',
                    type : '1'
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
            if(fenleiNav_length>=60){
                layer.msg("最多只能添加60个分类");
            }else{
                var fenleiNav_Default = {
                    id: 0,
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    type: '1',    // 默认是帖子类型
                    price : 0,
                    linkUrl : '',
                    mobileShow : false,
                    addressShow : false,
                    allowComment : true,
                    verifyComment : false
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
        $scope.addPostType = function(){
            var post_length = $scope.postType.length;
            var defaultIndex = 0;
            if(post_length>0){
                for (var i=0;i<post_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.postType[i].index)){
                        defaultIndex = $scope.postType[i].index;
                    }
                }
                defaultIndex++;
            }
            if(post_length>=4){
                layer.msg("最多只能添加4中类型");
            }else{
                var type_Default = {
                    index: defaultIndex,
                    name: '最新发布'
                };
                $scope.postType.push(type_Default);
            }
            console.log($scope.postType);
        };
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
            if(good_length>=4){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加4个推荐哦',
                    time: 2000
                });
            }else{
                var good_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_320.png',
                    link : '',
                    type : '4',
                    title: '默认标题',
                };
                $scope.recommendGood.push(good_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.recommendGood);
        };

        $scope.addTabList = function(){
            var tab_length = $scope.tabList.length;
            var defaultIndex = 0;
            if(tab_length>0){
                for (var i=0;i<tab_length;i++){
                    if(defaultIndex < $scope.tabList[i].index){
                        defaultIndex = $scope.tabList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(tab_length>=4){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加4个自定义链接',
                    time: 2000
                });
            }else{
                var tab_Default = {
                    index: defaultIndex,
                    link : '',
                    type : '1',
                    name: '默认标题',
                };
                $scope.tabList.push(tab_Default);
                // $timeout(function(){
                //     //卸载掉原来的事件
                //     $(".cropper-box").unbind();
                //     new $.CropAvatar($("#crop-avatar"));
                // },500);
            }
            console.log($scope.tabList);
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

        $scope.changeApplyIcon=function(){
            if(imgNowsrc){
                $scope.applyIcon = imgNowsrc;
            }
        };

        $scope.changeStatIcon=function(){
            if(imgNowsrc){
                $scope.statIcon = imgNowsrc;
            }
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
            var articles = $scope.articles;
            var curId = '';
            var curTitle = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                    curTitle = articles[i].title;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
                $scope[type][realIndex].title = curTitle;
            }
        };

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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            console.log($scope.memberCardType);
            var data = {
                'headerTitle' 	 : $scope.headerTitle,
                'slide'		     : $scope.banners,
                'tpl_id'	     : $scope.tpl_id,
                'notice'         : $scope.noticeTxt,
                'shortcut'       : $scope.fenleiNavs,
                'postAudit'      : $scope.postAudit == true ? 1 : 2,
                'postAddress'    : $scope.postAddress == true ? 1 : 0,
                'postMobile'     : $scope.postMobile == true ? 1 : 0,
                'browseNum'      : $scope.browseNum,
                'issueNum'       : $scope.issueNum,
                'issueNumOpen'   : $scope.issueNumOpen == true ? 1 : 0,
                'shopNum'        : $scope.shopNum,
                'postNum'        : $scope.postNum,
                'addMemberNum'   : $scope.addMemberNum,
                'serviceRate'    : $scope.serviceRate,
                'redbagMin'      : $scope.redbagMin,
                'singleMin'      : $scope.singleMin,
                'brief'          : $scope.brief.brief,
                'tips'           : $scope.tips.tips,
                'refundDate'     : $scope.refundDate,
                'postType'       : $scope.postType,
                'noticeTitle'    : $scope.noticeTitle,
                'infotitle'      : $scope.infotitle,
                'recommendtitle' : $scope.recommendtitle,
                'info'           : $scope.recommendGood,
                'applyIcon'      : $scope.applyIcon,
                'statIcon'       : $scope.statIcon,
                'applyTitle'     : $scope.applyTitle,
                'applyDesc'      : $scope.applyDesc,
                'applyOpen'      : $scope.applyOpen == true ? 1 : 0,
                'recommendOpen'  : $scope.recommendOpen == true ? 1 : 0,
                'memberCardType' : $scope.memberCardType,
                'postPrice'      : $scope.postPrice,
                'tabList'        : $scope.tabList,
                'labelOpen'      : $scope.labelOpen == true ? 1 : 0,
                'cityMember'     : $scope.cityMember == true ?1:0,
                'contentMobile'  : $scope.contentMobile == true ? 1:0,
                'postSubmit'     : $scope.postSubmit == true ? 1:0
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/city/saveAppletTpl',
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
<{if $tpl['aci_s_id'] == 4546}>
    <{include file="../img-upload-modal-test.tpl"}>
<{else}>
    <{include file="../img-upload-modal.tpl"}>
<{/if}>