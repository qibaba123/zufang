<link rel="stylesheet" href="/public/wxapp/train/temp1/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/train/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/train/temp1/css/style.css">
<style>
    .title-name span{
        left: 5px;
        font-size: 16px;
        font-weight: bold;
    }
    .fenlei-nav{
        margin-bottom: 6px;
    }
    .fenlei-nav li{
        width: 20%;
    }
    .fenlei-nav ul{
        white-space: normal;
    }
    .title-name .more_label{
        color: blue;
    }
    .active-item .active-intro .times{
        position: absolute;
        bottom: 3px;
        /* right: 0; */
        color: #aaa;
        font-size: 12px;
        line-height: 1.3;
    }
    .active-item img{
        height: 110px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
    }
    .teacher-item .teacher-course{
        margin-top: 5px !important;
    }
    .notice-box{
        height: 38px;
    }
    .notice-box .noticeicon{
        width: 70px;
        margin-top: -5px;
    }
    .notice-box .notice-txt{
        height: 25px;
    }
    .service-list, .commendInfo-list{
        white-space: nowrap;
        width: 100%;
    }
    .recommend-item{
        width: 47%;
        white-space: nowrap;
        display: inline-block;
        margin-right: 5px;
    }
    .recommend-info{
        padding: 1px;
    }
    .recommend-info .recommend-price{
        float: left;
        font-weight: bold;
        color: #FF9C42;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
        width: 65%;
    }
    .recommend-info .recommend-name{
        display: block;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
    }
    .recommend-info .recommend-more{
        display: inline-block;
        float: right;
        color: #666;
        font-size: 12px;
    }
    .commendInfo-item{
        width: 55%;
        white-space: nowrap;
        display: inline-block;
        margin-left: 5px;
        margin-right: 5px;
        height: 60px;
        background-color: #F7F7F7;
        border-radius: 5px;
        padding: 3px 7px;
    }
    .commendInfo-item .commendInfo-title{
        display: block;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
    }
    .commendInfo-item .commendInfo-show{
        display: inline-block;
        float: right;
        color: #666;
        font-size: 12px;
    }
    .infoBox-item{
        display: inline-block;
        width: 45%;
        margin: 5px;
        border-radius: 5px;
        color: #fff;
        padding: 5px 10px;
    }
    .infoBox-title,.infoBox-brief{
        display: block;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
    }
    .infoBox-item .infoBox-brief{
        font-size: 11px;
    }
    .courseIndex-course-list{

    }
    .courseIndex-course-list .course-list-img{
        width: 45%; /*长图注释*/
        float: left;/*长图注释*/
        height: 90px;
    }
    .course-list-row{
        height: 100px;
        width: 100%;
        margin-bottom: 5px;
    }
    .courseIndex-course-list .course-list-info{
        width: 55%;/*长图注释*/
        float: right;/*长图注释*/
        padding: 3px 5px;


    }
    .courseIndex-course-list .course-list-info .course-list-name{
        word-break:normal;
        white-space:pre-wrap;
        word-wrap : break-word ;
        overflow: hidden;
        text-overflow: ellipsis;
        width: 100%;
        display: block;
        height: 45px;
        margin-bottom: 20px;/*长图注释*/
    }
    .courseIndex-course-list .course-list-info .course-list-price{
        font-weight: bold;
        color: #FF9C42;
        width: 90px;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
        display: inline-block;
    }
    .courseIndex-course-list .course-list-info .course-list-apply{
        float: right;
        text-align: right;
        font-size: 12px;
        color: #ccc;
        width: 60px;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
        display: inline-block;
    }
    .teacher-intro-left{
        width: 36%;
        float: left;
    }
    .teacher-intro-left img{
        border-radius: 50%;
        width: 80px;
        height: 80px;
        margin: 5px auto;
        display: block;
    }
    .teacher-intro-left span{
        display: inline-block;
        width: 100%;
        text-align: center;
        overflow: hidden;
	    white-space: nowrap;
	    text-overflow: ellipsis;
    }
    .teacher-tag-show{
        display: inline-block;
        margin: 0 1px;
        background-color: #A4D6FF;
        padding: 0 2px;
        color: #4B97FF;
        border-radius: 4px;
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
                <div class="index-main" style="overflow-x: hidden">
                    <!-- 幻灯 -->
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_75_40.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>
                    <!-- 分类导航 -->
                    <div class="fenlei-nav" data-left-preview data-id="3">
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
                    <!-- 地址选择 -->
                    <div class="address-show flex-wrap" data-left-preview data-id="2">
                        <img src="/public/wxapp/train/images/public_location.png" />
                        <p class="flex-con">{{address.address}}</p>
                        <img src="/public/wxapp/train/images/arrow_right.png" style="height: 16px;margin-top: 6px;" />
                    </div>
                    <!-- 推荐课程 -->
                    <div class="service-wrap border-t" data-left-preview data-id="5">
                        <div class="title-name">
                            <span>{{courseInfo.title}}</span>
                        </div>
                        <div class="no-data-tip" ng-if="courseInfo.courseList<=0">点此添加内容~</div>
                        <div class="service-list">
                            <div class="recommend-item"  ng-repeat="course in courseInfo.courseList">
                                <div class="recommend-img" style="width: 100%">
                                    <img ng-src="{{course.imgsrc}}" style="width: 100%"/>
                                </div>
                                <div class="recommend-info">
                                    <span class="recommend-name">{{course.name}}</span>
                                    <span class="recommend-price">{{course.price}}</span>
                                    <span class="recommend-more">详情></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 首页资讯 色块-->
                    <div class="service-wrap border-t" data-left-preview data-id="8">
                        <div class="title-name">
                            <span>{{infoBoxTitle}}</span>
                            <p class="more_label">更多 ></p>
                        </div>
                        <div class="infoBox-list">
                            <div class="infoBox-item infoBox-item_0" style="background-color: #9DC6FF">
                                <span class="infoBox-title">{{infoBox[0].title}}</span>
                                <span class="infoBox-brief">{{infoBox[0].brief}}></span>
                            </div>
                            <div class="infoBox-item infoBox-item_1" style="background-color: #EFD672">
                                <span class="infoBox-title">{{infoBox[1].title}}</span>
                                <span class="infoBox-brief">{{infoBox[1].brief}}></span>
                            </div>
                        </div>
                    </div>

                    <!-- 首页课程 -->
                    <div class="service-wrap" data-left-preview data-id="10">
                        <div class="no-data-tip" ng-if="courseIndex.length<=0">点此添加内容~</div>
                        <div class="courseIndex-list" ng-repeat="course in courseIndex">
                            <div class="title-name">
                                <span>{{course.title}}</span>
                                <p class="more_label">更多 ></p>
                            </div>
                            <div class="courseIndex-course-list">
                                <div ng-repeat="row in courseWithCate[course.link] | limitTo:3" class="course-list-row">
                                    <div class="course-list-img">
                                        <img src="{{row.cover}}" alt="" style="width: 100%;height: 100%;">
                                    </div>
                                    <div class="course-list-info">
                                        <span class="course-list-name">{{row.name}}</span>
                                        <span class="course-list-price">{{row.price}}</span>
                                        <span class="course-list-apply">{{row.apply}}人在学</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 首页资讯 灰色-->
                    <div class="service-wrap border-t" data-left-preview data-id="9">
                        <div class="title-name">
                            <span>{{commendInfoTitle}}</span>
                             <p class="more_label">更多 ></p>
                        </div>
                        <div class="no-data-tip" ng-if="commendInfoCate == 0">点此配置内容~</div>
                        <div class="commendInfo-list" ng-if="commendInfoCate > 0">
                            <!--
                            <div class="commendInfo-item"  ng-repeat="info in informationCate[commendInfoCate] | limitTo:3">
                                <span class="commendInfo-title">{{info.title}}</span>
                                <span class="commendInfo-show">{{info.show}}浏览</span>
                            </div>
                            -->
                            <div class="commendInfo-item"  ng-repeat="info in informationCate[commendInfoCate] | limitTo:3" style="height:140px;background-color:#fff;box-shadow:2px 3px 10px #ccc;margin-bottom:10px">
                                <div class="commendInfo-img">
                                    <img src="{{info.cover}}" alt="图片" style="width:100%">
                                </div>
                                <div>
                                    <span class="commendInfo-title">{{info.title}}</span>
                                    <span class="commendInfo-show">{{info.show}}浏览</span>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                    <!-- 师资力量 -->
                    <div class="service-wrap" data-left-preview data-id="6">
                        <div class="title-name">
                            <span style="left: 5px">{{teacherInfo.title}}</span>
                            <p class="more_label">更多 ></p>
                        </div>
                        <div class="no-data-tip" ng-if="teacherInfo.teacherList<=0">点此添加内容~</div>
                        <div class="teacher-list">
                            <div class="teacher-item" ng-repeat="teacher in teacherInfo.teacherList">
                                <div class="item-box">
                                    <div class="teacher-intro-left">
                                        <img ng-src="{{teacher.imgsrc}}" alt="头像"/>
                                        <span>{{teacher.name}}</span>
                                        <span style="font-size: 12px;color:#ccc">{{teacher.aptitudes}}</span>
                                    </div>
                                    <div class="teacher-intro">
                                        <p class="teacher-course">
                                            <span class="teacher-tag-show" ng-repeat="tag in teacher.classifyList">{{tag.name}}</span>
                                        </p>
                                        <p class="teacher-name"></p>
                                        <p class="teacher-brief">{{teacher.brief}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--预约管理-->
                    <div class="appointment-wrap" data-left-preview data-id="7">
                        <div class="no-data-tip" ng-if="!bottomImg.isOn">点此管理预约模块儿~</div>
                        <div ng-if="bottomImg.isOn">
                            <div class="cooperative-wrap">
                                <img ng-src="{{bottomImg.bottomImg}}" style="width: 100%;" />
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
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div class="banner" data-right-edit data-id="1" ng-model="banners">
                <label style="width: 100%;">幻灯管理<span>(幻灯图片建议尺寸:750px*400px)</span></label>
                <div class="banner-manage" ng-repeat="banner in banners">
                    <div class="delete" ng-click="delIndex('banners',banner.index)">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="400" style="height:100%;">
                            <img ng-src="{{banner.imgsrc}}" onload="changeSrc(this)"  imageonload="doThis('banners',banner.index)" width="100%" height="100%" style="display:block;" alt="轮播图">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="banner.imgsrc"/>
                        </div>-->
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <div class="input-groups clearfix">
                        <label for="">类型：</label>
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
                    </div>
                    <div class="input-groups clearfix" ng-show="banner.type==1">
                        <label for="">链接到：</label>
                        <!--<select class="cus-input" ng-model="banner.articleId" ng-options="x.id as x.title for x in information" ng-change="getSelectId('banners',banner.index,banner.articleTitle)"></select>-->
                        <select class="cus-input" ng-model="banner.link" ng-options="x.id as x.title for x in information" ></select>
                    </div>
                    <div class="input-groups clearfix" ng-show="banner.type==106">
                        <label for="">小程序：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <!-- 地址 -->
            <div class="address" data-right-edit data-id="2">
                <div class="fenleinav-manage" style="padding-top: 10px;">
                    <label style="width: 100%;">此区域信息在小程序管理下的菜单导航里添加</label>
                </div>
                <!--<label>联系电话</label>
                <input type="text" class="cus-input" placeholder="请输入联系电话" ng-model="mobile">
                <label>联系地址</label>
                <div class="fenleinav-manage" style="padding-top: 10px;">-->
                    <!--
                    <div class="input-groups">
                        <label for="">地址经度</label><span style="float: right"><a href="http://www.gpsspg.com/maps.htm" target="_blank" style="color: blue">获取经纬度（请填写腾讯地图的经纬度）</a></span>
                        <input type="text"  class="cus-input" placeholder="请输入地址经度" maxlength="10" ng-model="address.longitude">
                    </div>
                    <div class="input-groups">
                        <label for="">地址纬度</label>
                        <input type="text" class="cus-input" placeholder="请输入地址纬度" maxlength="10" ng-model="address.latitude">
                    </div>
                    -->
                    <!--<div class="input-groups" style="margin-bottom: 10px;">
                        <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                            <label style="width: 75%;display: inline-block;">详细地址</label>
                            <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle;">
                                <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" ng-model="address.longitude">
                                <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" ng-model="address.latitude">
                                <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                            </div>
                        </div>
                        <textarea rows="3" class="cus-input" placeholder="请输入详细地址" id="details-address" ng-model="address.address"></textarea>
                    </div>

                    <div id="container" style="width: 100%;height: 300px"></div>
                </div>-->
            </div>
            <!-- 导航 -->
            <div class="fenleinav" data-right-edit data-id="3">
                <label style="width: 100%">分类导航<span>(分类最多添加5个)</span></label>
                <div class="fenleinav-manage" ng-repeat="fenleiNav in fenleiNavs">
                    <div class="delete" ng-click="delIndex('fenleiNavs',fenleiNav.index)">×</div>
                    <div class="edit-img">
                        <div>
                            <img onclick="toUpload(this)"  data-limit="5" onload="changeSrc(this)" data-width="150" data-height="150" imageonload="doThis('fenleiNavs',fenleiNav.index)" data-dom-id="upload-fenlei{{$index}}" id="upload-fenlei{{$index}}"  ng-src="{{fenleiNav.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="fenlei{{$index}}"  class="avatar-field bg-img" name="fenlei{{$index}}" ng-value="fenleiNav.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt">
                        <div class="input-group-box clearfix">
                            <label for="">标　　题：</label>
                            <input type="text" class="cus-input" maxlength="5" ng-value="fenleiNav.title" ng-model="fenleiNav.title">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">链接类型：</label>
                            <select class="cus-input" ng-model="fenleiNav.type"  ng-options="x.id as x.name for x in linkTypes" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==1">
                            <label for="">单　　页：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.title for x in information" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==2">
                            <label for="">列　　表：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.path as x.name for x in linkList" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==3">
                            <label for="">外　　链：</label>
                            <input type="text" class="cus-input" ng-value="fenleiNav.link" ng-model="fenleiNav.link" />
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==24">
                            <label for="">分　　类：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in courseCate" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==57">
                            <label for="">课程详情：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in courses" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==55">
                            <label for="">选择表单：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.id as x.name for x in formlist" ></select>
                        </div>
                        <div class="input-group-box clearfix" ng-show="fenleiNav.type==106">
                            <label for="">小 程 序：</label>
                            <select class="cus-input" ng-model="fenleiNav.link"  ng-options="x.appid as x.name for x in jumpList" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewfenleiNav()"></div>
            </div>
            <!-- 公告管理 -->
            <div class="notice" data-right-edit data-id="4">
                <label>最新公告</label>
                <div class="service-manage" ng-repeat="notice in noticeTxt">
                    <div class="delete" ng-click="delIndex('noticeTxt',notice.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="notice.title">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="notice.articleId" ng-options="x.id as x.title for x in information" ></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNotice()"></div>
            </div>
            <!-- 课程管理 -->
            <div class="service" data-right-edit data-id="5">
                <label style="width: 100%;">{{courseInfo.title}}</label>
                <div class="input-groups" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="courseInfo.title">
                </div>
                <div class="service-manage" ng-repeat="course in courseInfo.courseList">
                    <div class="delete" ng-click="delIndex('courseList',course.index,'courseInfo')">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="345" data-height="230" style="height:100%;">
                            <img ng-src="{{course.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('courseList',course.index,'courseInfo')" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="center_bg" ng-value="course.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="345" data-height="230" imageonload="doThis('courseList',course.index,'courseInfo')" data-dom-id="upload-course{{$index}}" id="upload-course{{$index}}"  ng-src="{{course.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="course{{$index}}"  class="avatar-field bg-img" name="course{{$index}}" ng-value="course.imgsrc"/>
                        </div>
                    </div>
                    <p class="tips">图片建议尺寸:345px*230px</p>
                    <div class="edit-txt">
                        <div class="input-groups" style="display: none;">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="course.name">
                        </div>
                        <div class="input-groups" style="display: none;">
                            <label for="">价  格：</label>
                            <input type="text" class="cus-input" ng-model="course.price" maxlength="9">
                        </div>
                        <!--
                        <div class="input-groups">
                            <label for="">简  介：</label>
                            <input type="text" class="cus-input" ng-model="course.brief">
                        </div>
                        -->
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="course.articleTitle" ng-options="x.name as x.name for x in courses" ng-change="getCourseSelectId('courseList',course.index,course.articleTitle,'courseInfo')"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewcourse()"></div>
            </div>
            <!-- 师资管理 -->
            <div class="teacher" data-right-edit data-id="6">
                <label style="width: 100%;">{{teacherInfo.title}}</label>
                <div class="input-groups" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="teacherInfo.title">
                </div>
                <div class="service-manage">
                    <div class="no-data-tip">首页只做列表展示，请到对应管理页面管理相关内容~</div>
                </div>
            </div>
             <!-- 推荐资讯 色块 -->
            <div class="service" data-right-edit data-id="8">
                <label style="width: 100%;">推荐资讯</label>
                <div class="input-groups" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="infoBoxTitle">
                </div>
                <span class='tg-list-item'>
						是否开启首页推荐资讯
                     <input class='tgl tgl-light' id='infoBoxOpen' type='checkbox' ng-model="infoBoxOpen" >
                     <label class='tgl-btn' for='infoBoxOpen'></label>
                </span>
                <div class="input-groups" style="margin-bottom: 10px;">
                            <label for="">资讯分类：</label>
                            <select name="infoBoxCate" id="infoBoxCate" class="form-control" ng-model="infoBoxCate">
                                <{foreach $category_select as $key => $val}>
                                <option value="<{$key}>"><{$val}></option>
                                <{/foreach}>
                            </select>
                </div>

                <div class="service-manage">
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标题一：</label>
                            <input type="text" class="cus-input" ng-model="infoBox[0].title" maxlength="9">
                        </div>
                        <div class="input-groups">
                            <label for="">标题二：</label>
                            <input type="text" class="cus-input" ng-model="infoBox[0].brief" maxlength="9">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="infoBox[0].link" ng-options="x.id as x.title for x in informationCate[infoBoxCate]"></select>
                        </div>
                    </div>
                </div>
                <div class="service-manage">
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标题一：</label>
                            <input type="text" class="cus-input" ng-model="infoBox[1].title" maxlength="9">
                        </div>
                        <div class="input-groups">
                            <label for="">标题二：</label>
                            <input type="text" class="cus-input" ng-model="infoBox[1].brief" maxlength="9">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="infoBox[1].link" ng-options="x.id as x.title for x in informationCate[infoBoxCate]"></select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 推荐资讯 无色 -->
            <div class="service" data-right-edit data-id="9">
                <label style="width: 100%;">资讯</label>
                <div class="input-groups" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="commendInfoTitle">
                </div>
                <div class="input-groups" style="margin-bottom: 10px;">
                            <label for="">资讯分类：</label>
                            <select name="commendInfoCate" id="commendInfoCate" class="form-control" ng-model="commendInfoCate">
                                <{foreach $category_select as $key => $val}>
                                <option value="<{$key}>"><{$val}></option>
                                <{/foreach}>
                            </select>
                </div>
                <div class="service-manage">
                    <div class="no-data-tip">首页只做展示，请到对应管理页面管理相关内容~</div>
                </div>
            </div>
             <!-- 首页课程分类 -->
            <div class="service" data-right-edit data-id="10">
                <label style="width: 100%;">首页课程分类<span>(分类最多添加5个)</span></label>
                <div class="service-manage" ng-repeat="course in courseIndex">
                    <div class="delete" ng-click="delIndex('courseIndex',course.index)">×</div>
                    <div class="edit-txt">
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="course.title" maxlength="8">
                        </div>
                        <div class="input-groups">
                            <label for="">链接到：</label>
                            <select class="cus-input" ng-model="course.link" ng-options="x.id as x.name for x in courseCate" ng-change="getCourseCateSelectId('courseIndex',course.index)"></select>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewcourseIndex()"></div>
            </div>
            <div class="appoint" data-right-edit data-id="7">
                <div class="isOn">
                    <span>开启预约:(用于收集表单信息，点击跳转到<a href="/wxapp/form/index" target="_blank" style="color: #428bca">自定义表单</a>页面。)</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="bottomImg.isOn">
                        <label class='tgl-btn' for='sms_start'></label>
                    </span>
                </div>
                <div class="shopintrobg-manage" ng-if="bottomImg.isOn">
                    <div style="margin-top: 20px;">
                        <a href="/wxapp/form/index" target="_blank" class="btn btn-sm btn-green"> 配置自定义表单 </a>
                    </div>
                    <img onclick="toUpload(this)"  style="margin-top: 20px;width: 100%"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="240" imageonload="changeBottomImg()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{bottomImg.bottomImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="bottomImg"  class="avatar-field bg-img" name="bottomImg{{$index}}" ng-value="bottomImg.bottomImg"/>
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
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.linkTypesNew = <{$linkTypesNew}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
        $scope.articles = <{$articles}>;
        $scope.formlist = <{$formlist}>;
        $scope.information = <{$information}>;
        $scope.informationCate = <{$informationCate}>;
        $scope.courses = <{$courses}>;
        $scope.courseWithCate = <{$courseWithCate}>;
        console.log($scope.courseWithCate);
        $scope.headerTitle= '<{$tpl['ati_title']}>';
        $scope.commendInfoTitle= '<{$tpl['ati_commendInfo_title']}>' ? '<{$tpl['ati_commendInfo_title']}>' : '资讯';
        $scope.infoBoxTitle = '<{$tpl['ati_infoBox_title']}>' ? '<{$tpl['ati_infoBox_title']}>' : '推荐资讯';
        $scope.categoryList = <{$categoryList}>;
        $scope.commendInfoCate= '<{$tpl['ati_commendInfo_cate']}>' != 0 ? '<{$tpl['ati_commendInfo_cate']}>' : ( $scope.categoryList.length !=0 ? $scope.categoryList[0].id : 0);
        $scope.infoBoxCate= '<{$tpl['ati_infoBox_cate']}>' != 0 ? '<{$tpl['ati_infoBox_cate']}>' : ( $scope.categoryList.length !=0 ? $scope.categoryList[0].id : 0);
        //$scope.commendInfoCate= '<{$tpl['ati_commendInfo_cate']}>';
        //$scope.infoBoxCate= '<{$tpl['ati_infoBox_cate']}>';
        $scope.infoBoxOpen = <{if $tpl['ati_infoBox_open']}> true <{else}> false <{/if}>;
        $scope.infoBox = <{$infoBox}>
        $scope.courseIndex = <{$courseIndex}>;
        $scope.courseCate = <{$courseCate}>;
        /*$scope.mobile = '<{$tpl['ati_mobile']}>';
        $scope.address = {
            address:'<{$tpl['ati_address']}>',
            longitude:'<{$tpl['ati_lng']}>',
            latitude:'<{$tpl['ati_lat']}>'
        };*/
         $scope.mobile = '<{$contact['sa_mobile']}>';
         $scope.address = {
         address:'<{$contact['sa_address']}>' ? '<{$contact['sa_address']}>' : '郑州市郑东新区CBD商务内环11号金成东方国际24楼2402室',
         longitude:'<{$contact['sa_lng']}>' ? '<{$contact['sa_lng']}>' : '113.72052',
         latitude:'<{$contact['sa_lat']}>' ? '<{$contact['sa_lat']}>' : '34.77485'
         };
        $scope.banners = <{$slide}>;
        $scope.fenleiNavs = <{$shortcut}>;
        $scope.noticeTxt = <{$noticeList}>;
        $scope.courseInfo = {
                title:'<{$tpl['ati_course_title']}>' ? '<{$tpl['ati_course_title']}>' : '推荐课程',
                courseList:<{$courseList}>
        };
        $scope.teacherInfo = {
                title:'<{$tpl['ati_coach_title']}>',
                teacherList: <{$teacherList}>
        };
        $scope.tpl_id	   = '<{$tpl['ati_tpl_id']}>';
        console.log($scope.tpl_id);
        $scope.bottomImg = {
            bottomImg: '<{$tpl['ati_bottom_img']}>'? '<{$tpl['ati_bottom_img']}>' : '/public/manage/img/zhanwei/zw_fxb_75_30.png',
            isOn     :  <{if $tpl['ati_ison']}> true <{else}> false <{/if}>,
    };
        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.fenleiNavs[i].index)){
                        defaultIndex = parseInt($scope.fenleiNavs[i].index);
                    }
                }
                defaultIndex++;
            }
            if(fenleiNav_length>=5){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加5个分类导航哦',
                    time: 2000
                });
            }else{
                var fenleiNav_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    title: '默认标题',
                    articleTitle:$scope.information.length>0?$scope.information[0].name:'',
                    articleId:$scope.information.length>0?$scope.information[0].id:'',
                    type : '1',
                    link : $scope.information.length>0?$scope.information[0].id:''
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
            }
            console.log($scope.fenleiNavs);
        }

        $scope.addNewBanner = function(){
            var banner_length = $scope.banners.length;
            var defaultIndex = 0;
            if(banner_length>0){
                for (var i=0;i<banner_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.banners[i].index)){
                        defaultIndex = parseInt($scope.banners[i].index);
                    }
                }
                defaultIndex++;
            }
            if(banner_length>=8){
                layer.msg("最多只能添加8张广告图哦~");
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    type:'1',
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    link: 'http://www.fenxiaobao.xin/manage/index/index',
//                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
//                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                    articleTitle:$scope.information.length>0?$scope.information[0].title:'',
                    articleId:$scope.information.length>0?$scope.information[0].id:''
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
                    articleTitle:$scope.information.length>0?$scope.information[0].title:'',
                    articleId:$scope.information.length>0?$scope.information[0].id:''
                };
                $scope.noticeTxt.push(notice_Default);
            }
            console.log($scope.noticeTxt);
        }

        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.bottomImg.bottomImg = imgNowsrc;
            }
        };

        /*添加资讯活动方法*/
        $scope.addNewcourse = function(){
            var courseList_length = $scope.courseInfo.courseList.length;
            var defaultIndex = 0;
            if(courseList_length>0){
                for (var i=0;i<courseList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.courseInfo.courseList[i].index)){
                        defaultIndex = parseInt($scope.courseInfo.courseList[i].index);
                    }
                }
                defaultIndex++;
            }
            if(courseList_length>=6){
                layer.msg("首页最多只能添加6个推荐课程哦~");
            }else{
                var courseList_Default = {
                    index: defaultIndex,
                    name: '课程名称',
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_36_22.png',
                    intro:'课程简介',
                    articleTitle:$scope.information.length>0?$scope.information[0].title:'',
                    articleId:$scope.information.length>0?$scope.information[0].id:''
                };
                console.log(courseList_Default);
                $scope.courseInfo.courseList.push(courseList_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.courseInfo);
        }

         /*添加首页课程分类展示方法*/
        $scope.addNewcourseIndex = function(){
            var courseList_length = $scope.courseIndex.length;
            var defaultIndex = 0;
            if(courseList_length>0){
                for (var i=0;i<courseList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.courseIndex[i].index)){
                        defaultIndex = parseInt($scope.courseIndex[i].index);
                    }
                }
                defaultIndex++;
            }
            if(courseList_length>=8){
                layer.msg("首页最多只能添加8个课程分类哦~");
            }else{
                var courseList_Default = {
                    index: defaultIndex,
                    title:$scope.courseCate.length>0?$scope.courseCate[0].name:'',
                    link:$scope.courseCate.length>0?$scope.courseCate[0].id:''
                };
                console.log(courseList_Default);
                $scope.courseIndex.push(courseList_Default);
            }
            console.log($scope.courseIndex);
        }

        /*添加师资方法*/
        $scope.addNewteacher = function(){
            var teacherList_length = $scope.teacherInfo.teacherList.length;
            var defaultIndex = 0;
            if(teacherList_length>0){
                for (var i=0;i<teacherList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.teacherInfo.teacherList[i].index)){
                        defaultIndex = parseInt($scope.teacherInfo.teacherList[i].index);
                    }
                }
                defaultIndex++;
            }
            if(teacherList_length>=6){
                layer.msg("首页最多只能添加6个哦~");
            }else{
                var teacherList_Default = {
                    index: defaultIndex,
                    name: "老师名字",
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_200_200.png',
                    courseFl:'教授课程',
                    aptitudes:'级别或称号',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.teacherInfo.teacherList.push(teacherList_Default);
            }
            console.log($scope.teacherInfo);
        }
        /*添加学员风采方法*/
        $scope.addNewstudent = function(){
            var studentList_length = $scope.studentInfo.studentList.length;
            var defaultIndex = 0;
            if(studentList_length>0){
                for (var i=0;i<studentList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.studentInfo.studentList[i].index)){
                        defaultIndex = parseInt($scope.studentInfo.studentList[i].index);
                    }
                }
                defaultIndex++;
            }
            var studentList_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_30.png',
            };
            $scope.studentInfo.studentList.push(studentList_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
            console.log($scope.studentInfo);
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

        // 选择文章
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var information = $scope.information;
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

        // 课程选择
        $scope.getCourseSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var courses = $scope.courses;
            var curId = '';
            var curName = '';
            var curPrice = '';
            for(var i = 0;i < courses.length;i++){
                if(courses[i].name == title){
                    curId = courses[i].id;
                    curName = courses[i].name;
                    curPrice = courses[i].price;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
                $scope[parentType][type][realIndex].name = curName;
                $scope[parentType][type][realIndex].price = curPrice;
            }else{
                $scope[type][realIndex].articleId = curId;
                $scope[type][realIndex].name = curName;
                $scope[type][realIndex].price = curPrice;
            };
        }

        // 首页课程分类选择
        $scope.getCourseCateSelectId = function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/

            realIndex = $scope.getRealIndex($scope[type],index);

            var courseCate = $scope.courseCate;
            var title = '';
            var curId = $scope[type][realIndex].link;
            for(var i = 0;i < courseCate.length;i++){
                if(courseCate[i].id == curId){
                    title = courseCate[i].name;
                }
            }
            console.log(realIndex);
            console.log(title);
            console.log($scope[type][realIndex].link);
            $scope[type][realIndex].title = title;
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

        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.bottomImg.bottomImg = imgNowsrc;
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
                'headerTitle' 	 : $scope.headerTitle,
                'mobile'         : $scope.mobile,
                'courseTitle' 	 : $scope.courseInfo.title,
                'coachTitle' 	 : $scope.teacherInfo.title,
                'address'        : $scope.address.address,
                'lng'            : $scope.address.longitude,
                'lat'            : $scope.address.latitude,
                'slide'		     : $scope.banners,
                'tpl_id'	     : $scope.tpl_id,
                'notice'         : $scope.noticeTxt,
                'courseInfo'     : $scope.courseInfo.courseList,
                'teacherInfo'    : $scope.teacherInfo.teacherList,
                'shortcut'       : $scope.fenleiNavs,
                'bottomImg'        : $scope.bottomImg.bottomImg,
                'isOn'             : $scope.bottomImg.isOn,
                'commendInfoTitle' : $scope.commendInfoTitle,
                'commendInfoCate'  : $scope.commendInfoCate,
                'courseIndex'      : $scope.courseIndex,
                'infoBoxTitle'     : $scope.infoBoxTitle,
                'infoBox'          : $scope.infoBox,
                'infoBoxOpen'      : $scope.infoBoxOpen,
                'infoBoxCate'      : $scope.infoBoxCate
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/train/saveAppletTpl',
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