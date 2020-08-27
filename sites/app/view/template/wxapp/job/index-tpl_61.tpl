<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/index.css?1">
<link rel="stylesheet" href="/public/wxapp/mall/temp3/css/style.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
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
        padding: 8px 12px;
        top: 0;
        box-sizing: border-box;
    }
    .search-container { border-radius: 25px; width: 96%; margin: 0 auto;padding: 5px 10px; box-sizing: border-box; background-color: #f7f7f7;}
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
    .no-data-tip {
        padding: 10px 0;
    }
    /*
    .fenleinav-manage .edit-txt {
        width: 100%;
    }

    .fenleinav-manage .edit-img{
        margin: auto;
        float: inherit;
    }
    */

    .classify-preiview-page .classify-name { display: table; background-color: #fff; }
    .classify-preiview-page .classify-name span { display: table-cell; width: 1000px; text-align: center; height: 45px; line-height: 45px; }

    .post-type .tg-list-item{
        display: inline;
        float: right;
        margin-right: 35%;
    }
    .post-type .edit-txt{
        margin-bottom: 10px;
    }

    .banner-chosen .chosen-container {
        width: 350px !important;
    }
    .fenleiNav-chosen .chosen-container{
        width: 248px !important;
    }
    .recommendGood-chosen .chosen-container{
        width: 248px !important;
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
    .fenleinav-manage,.banner-manage{
        overflow: visible;
    }
    .fenleinav-manage .edit-img{
        margin-right: 6px;
        float: none;
        display: inline-block;
    } 
    .fenleinav-manage .edit-txt{
        float: none;
        display: inline-block;
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
                    <!-- 幻灯 -->
                    <div data-left-preview data-id="1" style="position: relative">
                        <div class="banner-wrap">
                            <img src="/public/manage/applet/temp2/images/banner_default.jpg" alt="轮播图" ng-if="banners.length<=0">
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
                    <div class="notice-box classify-preiview-page" data-left-preview data-id="7"  style="height: 65px;">
                        <div class="classify-name">
                            <span ng-repeat="type in positionType">{{type.name}}</span>
                        </div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="3">
                        <div class="no-data-tip" style="font-size: 20px;color: red">基础信息配置</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="5">
                        <div class="no-data-tip" style="font-size: 20px;color: red">关于我们</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="6">
                        <div class="no-data-tip" style="font-size: 20px;color: red">使用协议</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="10">
                        <div class="no-data-tip" style="font-size: 20px;color: red">会员注册协议</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="11">
                        <div class="no-data-tip" style="font-size: 20px;color: red">在线会员协议</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="12">
                        <div class="no-data-tip" style="font-size: 20px;color: red">隐私协议</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="4">
                        <div class="no-data-tip" style="font-size: 20px;color: red">职位标签管理</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="13" style="display: none">
                        <div class="no-data-tip" style="font-size: 20px;color: red">兼职标签管理</div>
                    </div>
                    <div class="appointment-wrap" data-left-preview data-id="8">
                        <div class="no-data-tip" style="font-size: 20px;color: red">职统计数据管理</div>
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
            <div class="banner" data-right-edit data-id="1">
                <label style="width:100%;">幻灯管理<span>(幻灯图片尺寸750px*360px)</span></label>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 70px;">搜索文本：</label>
                    <input type="text" class="cus-input" placeholder="请输入搜索提示内容" maxlength="10" ng-model="searchPlaceholder">
                </div>
                <div class="banner-manage banner-chosen" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="360" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-group-box clearfix">
                        <label for="">链接类型：</label>
                        <select class="cus-input form-control" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==1">
                        <label for="">资讯详情：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==2">
                        <label for="">列　　表：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.path as x.name for x in linkList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==3">
                        <label for="">外　　链：</label>
                        <input type="text" class="cus-input form-control" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==35">
                        <label for="">职位分类：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==36">
                        <label for="">职位详情：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in positionList" ></select>
                    </div>
                    <div class="input-group-box clearfix" ng-show="banner.type==50">
                        <label for="">公司分类：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                    </div>

                    <div class="input-group-box clearfix" ng-show="banner.type==48">
                        <label for="">公司详情：</label>
                        <select class="cus-input form-control selectpicker chosen-select" ng-model="banner.link"  ng-options="x.id as x.name for x in companySelect" ></select>
                    </div>

                    <div class="input-group-box clearfix" ng-show="banner.type==106">
                        <label for="">小 程 序：</label>
                        <select class="cus-input form-control" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            <!-- 导航 -->
            <div class="fenleinav" data-right-edit data-id="2">
                <label style="width: 100%">分类导航<span>(分类多于8个时手机端可横向滑动，管理界面不做展示)</span></label>
                <div class="fenleinav-manage fenleiNav-chosen" ng-repeat="fenleiNav in fenleiNavs">
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
                            <select class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in noticeTxt" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input form-control" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==35">
                            <label for="">职位分类：</label>
                            <select class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in kindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==36">
                            <label for="">职位详情：</label>
                            <select class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in positionList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==50">
                            <label for="">公司分类：</label>
                            <select class="cus-input form-control selectpicker chosen-select" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in firstKindSelect" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input form-control" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <div class="appoint" data-right-edit data-id="3">
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 150px;">单份推荐奖最小金额：</label>
                    <input type="text" class="cus-input" ng-model="recommendMin" style="width: 80%">
                    <span style="font-weight: 700;margin-left: 10px">元</span>
                </div>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 230px;">单份入职奖最小金额（推荐人）：</label>
                    <input type="text" class="cus-input" ng-model="entryMin" style="width: 80%">
                    <span style="font-weight: 700;margin-left: 10px">元</span>
                </div>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 230px;">单份入职奖最小金额（被推荐人）：</label>
                    <input type="text" class="cus-input" ng-model="recommendedMin" style="width: 80%">
                    <span style="font-weight: 700;margin-left: 10px">元</span>
                </div>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 130px;">自动确认入职时间：</label>
                    <input type="text" class="cus-input" ng-model="confirmTime" style="width: 80%">
                    <span style="font-weight: 700;margin-left: 10px">天</span>
                </div>
                <div class="input-group-box" style="margin-bottom: 10px;">
                    <label style="width: 190px;">非会员每天可邀请面试次数：</label>
                    <input type="text" class="cus-input" ng-model="inviteNum" style="width: 80%">
                    <span style="font-weight: 700;margin-left: 10px">次</span>
                </div>
                <div class="input-groups" style="margin-bottom: 15px">
                    <div class="isOn">
                        <span>职位详情公司入驻:</span>
                        <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='enter_open' type='checkbox' ng-model="enterOpen">
                                <label class='tgl-btn' for='enter_open' style="float: right;margin-right: 57%;width: 60px;"></label>
                            </span>
                    </div>
                </div>
                <div class="input-groups" style="margin-bottom: 15px;display: inline-block">
                    <div class="isOn">
                        <span>首页职位列表是否显示时间:</span>
                        <span class='tg-list-item' style="float:right;margin-left: 50px;">
                                <input class='tgl tgl-light' id='time_open' type='checkbox' ng-model="jobTimeOpen">
                                <label class='tgl-btn' for='time_open' style="float: right;margin-right: 57%;width: 60px;"></label>
                            </span>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <label for="">奖金说明：</label>
                        <textarea name="award-intro" class="cus-input" id="award-intro" rows="10"><{$tpl['aji_award_intro']}></textarea>
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="4">
                <label style="width: 100%">职位标签</label>
                <div class="fenleinav-manage" ng-repeat="label in labels">
                    <div class="delete" ng-click="delIndex('labels',label.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标签：</label>
                            <input type="text" maxlength="5" ng-model="label.name" class="cus-input form-control">
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewLabel()"></div>
            </div>


            <div class="appoint" data-right-edit data-id="13">
                <label style="width: 100%">兼职标签</label>
                <div class="fenleinav-manage" ng-repeat="label in partTimeLabels">
                    <div class="delete" ng-click="delIndex('partTimeLabels',label.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标签：</label>
                            <input type="text" maxlength="5" ng-model="label.name" class="cus-input form-control">
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewPartTimeLabel()"></div>
            </div>

            <div class="appoint" data-right-edit data-id="5">
                <label style="width: 100%">关于我们</label>
                <div class="fenleinav-manage">
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-about-us" name="article-about-us" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['aji_about_us']}><{$tpl['aji_about_us']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-about-us" />
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="6">
                <label style="width: 100%">使用协议</label>
                <div class="fenleinav-manage">
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-protocol" name="article-protocol" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['aji_protocol']}><{$tpl['aji_protocol']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-protocol" />
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="10">
                <label style="width: 100%">会员注册协议</label>
                <div class="fenleinav-manage">
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-register-protocol" name="article-register-protocol" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['aji_register_protocol']}><{$tpl['aji_register_protocol']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-register-protocol" />
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="11">
                <label style="width: 100%">在线会员协议</label>
                <div class="fenleinav-manage">
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-member-protocol" name="article-member-protocol" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['aji_member_protocol']}><{$tpl['aji_member_protocol']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-member-protocol" />
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="12">
                <label style="width: 100%">隐私协议</label>
                <div class="fenleinav-manage">
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-privacy-protocol" name="article-privacy-protocol" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $tpl && $tpl['aji_privacy_protocol']}><{$tpl['aji_privacy_protocol']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-privacy-protocol" />
                    </div>
                </div>
            </div>
            <div class="notice post-type" data-right-edit data-id="7">
                <label>职位类型</label>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="positionType[0].name">
                        <span class='tg-list-item' style="margin-right: 0">
                            <input class='tgl tgl-light' id='must_type0' type='checkbox' ng-model="positionType[0].must">
                            <label class='tgl-btn' for='must_type0'></label>
                        </span>
                        <select class="cus-input form-control" ng-model="positionType[0].type" style="width: 35%;display: inline-block;"  ng-options="x.type as x.title for x in sortType" ></select>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="positionType[1].name">
                        <span class='tg-list-item' style="margin-right: 0">
                            <input class='tgl tgl-light' id='must_type1' type='checkbox' ng-model="positionType[1].must">
                            <label class='tgl-btn' for='must_type1'></label>
                        </span>
                        <select class="cus-input form-control" ng-model="positionType[1].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in sortType" ></select>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="positionType[2].name">
                        <span class='tg-list-item' style="margin-right: 0">
                            <input class='tgl tgl-light' id='must_type2' type='checkbox' ng-model="positionType[2].must">
                            <label class='tgl-btn' for='must_type2'></label>
                        </span>
                        <select class="cus-input form-control" ng-model="positionType[2].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in sortType" ></select>
                    </div>
                </div>
                <div class="edit-txt">
                    <div class="input-groups">
                        <input type="text" class="cus-input" style="width: 50%" maxlength="4" minlength="2" ng-model="positionType[3].name">
                        <span class='tg-list-item' style="margin-right: 0">
                            <input class='tgl tgl-light' id='must_type3' type='checkbox' ng-model="positionType[3].must">
                            <label class='tgl-btn' for='must_type3'></label>
                        </span>
                        <select class="cus-input form-control" ng-model="positionType[3].type" style="width: 35%;display: inline-block;" ng-options="x.type as x.title for x in sortType" ></select>
                    </div>
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="8">
                <div class="edit-txt">
                    <div class="input-groups">
                        <div class="isOn">
                            <span>是否显示:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='stat_open' type='checkbox' ng-model="statOpen">
                                <label class='tgl-btn' for='stat_open' style="float: right;margin-right: 57%;width: 60px;"></label>
                            </span>
                        </div>
                    </div>

                    <div class="input-groups">
                        <label for="">统计数据图标：</label>
                        <img onclick="toUpload(this)"  style="margin-top: 20px;width: 60px"  data-limit="1" onload="changeSrc(this)" data-width="100" data-height="100" imageonload="changeStatIcon()" data-dom-id="upload-statIcon" id="upload-statIcon"  ng-src="{{statIcon}}"  height="100%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="statIcon"  class="avatar-field bg-img" name="statIcon{{$index}}" ng-value="statIcon"/>
                    </div>
                    <div class="input-groups">
                        <label for="">公司数量（在真实数量上增加）：</label>
                        <input type="text" class="cus-input" ng-model="companyNum">
                    </div>
                    <div class="input-groups">
                        <label for="">职位数量（在真实数量上增加）：</label>
                        <input type="text" class="cus-input" ng-model="positionNum">
                    </div>
                    <div class="input-groups">
                        <label for="">简历数量（在真实数量上增加）：</label>
                        <input type="text" class="cus-input" ng-model="resumeNum">
                    </div>
                    <div class="input-groups">
                        <label for="">访问量：</label>
                        <input type="text" class="cus-input" ng-model="browseNum">
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
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>



<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.headerTitle= "<{$tpl['aji_title']}>" ? "<{$tpl['aji_title']}>" : "店铺首页" ;
        $scope.searchPlaceholder = '<{$tpl['aji_search_tip']}>' ? '<{$tpl['aji_search_tip']}>' : '请输入关键字';
        $scope.confirmTime = '<{$tpl['aji_confirm_time']}>' ? '<{$tpl['aji_confirm_time']}>' : '7';
        $scope.inviteNum  = '<{$tpl['aji_job_invite_num']}>' ? '<{$tpl['aji_job_invite_num']}>' : '0';
        $scope.banners    = <{$slide}>;
        $scope.companyNum       = '<{$tpl['aji_company_num']}>';
        $scope.positionNum        = '<{$tpl['aji_position_num']}>';
        $scope.resumeNum         = '<{$tpl['aji_resume_num']}>';
        $scope.browseNum    = '<{$tpl['aji_browse_num']}>';
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.linkTypes  = <{$linkType}>;
        $scope.linkList   = <{$linkList}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.noticeTxt  = <{$information}>;
        $scope.labels     = <{$labels}>;
        $scope.partTimeLabels     = <{$partTimeLabels}>;
        $scope.positionType   = <{$tpl['aji_position_type']}>;
        $scope.positionList = <{$positionList}>;
        $scope.kindSelect = <{$kindSelect}>;
        $scope.firstKindSelect = <{$firstKindSelect}>;
        $scope.companySelect = <{$companySelect}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.statIcon          = '<{$tpl['aji_stat_icon']}>'?'<{$tpl['aji_stat_icon']}>':'/public/wxapp/customtpl/images/icon_tj.png';
        $scope.statOpen          = <{$tpl['aji_stat_open']}> > 0 ? true : false ;
        $scope.enterOpen         = <{$tpl['aji_enter_open']}> > 0 ? true : false ;
        $scope.jobTimeOpen         = <{$tpl['aji_open_job_time']}> > 0 ? true : false ;
        $scope.recommendMin = '<{$tpl['aji_recommend_min']}>'?'<{$tpl['aji_recommend_min']}>':0;
        $scope.entryMin = '<{$tpl['aji_entry_min']}>'?'<{$tpl['aji_entry_min']}>':0;
        $scope.recommendedMin = '<{$tpl['aji_recommended_min']}>'?'<{$tpl['aji_recommended_min']}>':0;
        $scope.sortType = [
            {
                'type' : 'recommend',
                'title' : '浏览量排序'
            },
            {
                'type' : 'new',
                'title' : '发布时间排序'
            },
            {
                'type' : 'nearby',
                'title' : '距离排序'
            },
            {
                'type' : 'fat',
                'title' : '薪资排序'
            },
            {
                'type' : 'award',
                'title' : '内推职位'
            }
        ];

        $scope.changeStatIcon=function(){
            if(imgNowsrc){
                $scope.statIcon = imgNowsrc;
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
                layer.msg("最多只能添加8张广告图哦~");
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_320.png',
                    link: $scope.noticeTxt.length>0?$scope.noticeTxt[0].id:'',
                    articleTitle:$scope.noticeTxt.length>0?$scope.noticeTxt[0].name:'',
                    articleId:$scope.noticeTxt.length>0?$scope.noticeTxt[0].id:'',
                    type : '1'
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
                    mobileShow : false,
                    addressShow : false,
                    allowComment : true
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
        };

        /*添加分类导航方法*/
        $scope.addNewLabel = function(){
            var labels_length = $scope.labels.length;
            var defaultIndex = 0;
            if(labels_length>0){
                for (var i=0;i<labels_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.labels[i].index)){
                        defaultIndex = $scope.labels[i].index;
                    }
                }
                defaultIndex++;
            }
            var label_Default = {
                id   : 0,
                index: defaultIndex,
                name: '标签名称'
            };
            $scope.labels.push(label_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
                addInitChosen();
            },500);

        };

        /*添加分类导航方法*/
        $scope.addNewPartTimeLabel = function(){
            var labels_length = $scope.partTimeLabels.length;
            var defaultIndex = 0;
            if(labels_length>0){
                for (var i=0;i<labels_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.partTimeLabels[i].index)){
                        defaultIndex = $scope.partTimeLabels[i].index;
                    }
                }
                defaultIndex++;
            }
            var label_Default = {
                id   : 0,
                index: defaultIndex,
                name: '标签名称'
            };
            $scope.partTimeLabels.push(label_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
                addInitChosen();
            },500);

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
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
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
                'title' 	 : $scope.headerTitle,
                'slide'		 : $scope.banners,
                'tpl_id'	 : $scope.tpl_id,
                'searchTip'  : $scope.searchPlaceholder,
                'shortcut'	 : $scope.fenleiNavs,
                'labels'     : $scope.labels,
                'awardIntro' : $('#award-intro').val(),
                'aboutUs'    : $('#article-about-us').val(),
                'protocol'   : $('#article-protocol').val(),
                'registerProtocol'   : $('#article-register-protocol').val(),
                'memberProtocol'   : $('#article-member-protocol').val(),
                'privacyProtocol'   : $('#article-privacy-protocol').val(),
                'statIcon'       : $scope.statIcon,
                'statOpen'      : $scope.statOpen == true ? 1 : 0,
                'enterOpen'     : $scope.enterOpen == true ? 1 : 0,
                'jobTimeOpen'     : $scope.jobTimeOpen == true ? 1 : 0,
                'companyNum' : $scope.companyNum,
                'positionNum' : $scope.positionNum,
                'resumeNum' : $scope.resumeNum,
                'browseNum' : $scope.browseNum,
                'confirmTime':$scope.confirmTime,
                'positionType'   : $scope.positionType,
                'recommendMin': $scope.recommendMin,
                'entryMin': $scope.entryMin,
                'recommendedMin': $scope.recommendedMin,
                'inviteNum': $scope.inviteNum
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/job/saveAppletTpl',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            addInitChosen();

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