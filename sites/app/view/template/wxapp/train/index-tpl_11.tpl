<link rel="stylesheet" href="/public/wxapp/train/temp1/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/train/temp1/css/index.css">
<link rel="stylesheet" href="/public/wxapp/train/temp1/css/style.css">
<style>
    .img-box{
        height: 110px !important;
    }
    .img-box img {
        height: auto !important;
    }

    .img-box .title-txt-new{
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: inline-block;
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
                    <!-- 幻灯 -->
                    <div class="banner-box" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_75_40.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">
                        <div class="paginations">
                            <span ng-class="{'active':$first}" ng-repeat="banner in banners"></span>
                        </div>
                    </div>
                    <!-- 地址选择 -->
                    <div class="address-show flex-wrap" data-left-preview data-id="2">
                        <img src="/public/wxapp/train/images/public_location.png" />
                        <p class="flex-con">{{address.address}}</p>
                        <img src="/public/wxapp/train/images/arrow_right.png" style="height: 16px;margin-top: 6px;" />
                    </div>
                    <!-- 分类导航 -->
                    <div class="fenlei-nav" data-left-preview data-id="3">
                        <ul class="border-t border-b">
                            <li ng-repeat="fenleiNav in fenleiNavs">
                                <a href="javascript:;">
                                    <img ng-src="{{fenleiNav.imgsrc}}" alt="分类导航">
                                    <p ng-bind="fenleiNav.title"></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- 公告 -->
                    <div class="notice-box" data-left-preview data-id="4">
                        <img src="/public/wxapp/train/images/home_notable.png" class="noticeicon" alt="图标">
                        <div class="notice-txt">
                            <p ng-if="noticeTxt.length<=0">最新公告内容</p>
                            <p ng-repeat="notice in noticeTxt">{{notice.title}}</p>
                        </div>
                    </div>
                    <!-- 推荐课程 -->
                    <div class="service-wrap border-t" data-left-preview data-id="5">
                        <div class="title-name">
                            <div class="icon"></div>
                            <span>{{courseInfo.title}}</span>
                            <p class="more_label">更多 ></p>
                        </div>
                        <div class="no-data-tip" ng-if="courseInfo.courseList<=0">点此添加内容~</div>
                        <div class="service-list">
                            <div class="service-item"  ng-repeat="course in courseInfo.courseList">
                                <div class="img-box">
                                    <img ng-src="{{course.imgsrc}}" />
                                    <div class="title-txt-new">{{course.name}}</div>
                                </div>
                                <div class="service-info" style="display: none">
                                    <span class="info-txt">{{course.price}}元|{{course.brief}}</span>
                                    <span class="title-txt">{{course.name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 师资力量 -->
                    <div class="service-wrap" data-left-preview data-id="6">
                        <div class="title-name">
                            <div class="icon"></div>
                            <span>{{teacherInfo.title}}</span>
                            <p class="more_label">更多 ></p>
                        </div>
                        <div class="no-data-tip" ng-if="teacherInfo.teacherList<=0">点此添加内容~</div>
                        <div class="teacher-list">
                            <div class="teacher-item" ng-repeat="teacher in teacherInfo.teacherList">
                                <div class="item-box">
                                    <img ng-src="{{teacher.imgsrc}}" alt="头像" />
                                    <div class="teacher-intro">
                                        <p class="teacher-course">{{teacher.courseFl}}</p>
                                        <p class="teacher-name">{{teacher.name}} {{teacher.aptitudes}}</p>
                                        <p class="teacher-brief">{{teacher.brief}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 学员风采 -->
                    <div class="service-wrap" data-left-preview data-id="7">
                        <div class="title-name">
                            <div class="icon"></div>
                            <span>{{studentInfo.title}}</span>
                            <p class="more_label">更多 ></p>
                        </div>
                        <div class="no-data-tip" ng-if="studentInfo.studentList.length<=0">点此添加内容~</div>
                        <div class="student-fc">
                            <div ng-repeat="student in studentInfo.studentList">
                                <img ng-src="{{student.imgsrc}}" alt="学员风采">
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
                    <!--
                    <div class="input-groups clearfix">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleId" ng-options="x.id as x.title for x in information" ></select>
                    </div>
                    -->
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
                <label style="width: 100%">分类导航</label>
                <div class="fenleinav-manage">
                    <div class="no-data-tip">此处导航为固定链接，请到对应管理页面管理相关内容~</div>
                </div>
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
                            <select class="cus-input" ng-model="notice.articleTitle" ng-options="x.title as x.title for x in information" ng-change="getSelectId('noticeTxt',notice.index,notice.articleTitle)"></select>
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
                        <div class="input-groups">
                            <label for="">标　题：</label>
                            <input type="text" class="cus-input" ng-model="course.name">
                        </div>
                        <div class="input-groups">
                            <label for="">价  格：</label>
                            <input type="text" class="cus-input" ng-model="course.price">
                        </div>
                        <div class="input-groups">
                            <label for="">简  介：</label>
                            <input type="text" class="cus-input" ng-model="course.brief">
                        </div>
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
            <!-- 学员风采管理 -->
            <div class="teacher" data-right-edit data-id="7">
                <label style="width: 100%;">{{studentInfo.title}}<span>（首页最多展示4个，其它在更多页面查看）</span></label>
                <div class="input-groups" style="margin-bottom: 10px;">
                    <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="6" ng-model="studentInfo.title">
                </div>
                <div class="service-manage student-manage" ng-repeat="student in studentInfo.studentList">
                    <div class="delete" ng-click="delIndex('studentList',student.index,'studentInfo')">×</div>
                    <div class="edit-img">
                        <!--<div class="cropper-box" data-width="750" data-height="300" style="height:100%;">
                            <img ng-src="{{student.imgsrc}}"  onload="changeSrc(this)"  imageonload="doThis('studentList',student.index,'studentInfo')" alt="导航图标">
                            <input type="hidden" class="avatar-field bg-img" name="student" ng-value="student.imgsrc"/>
                        </div>-->
                        <div>
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="doThis('studentList',student.index,'studentInfo')" data-dom-id="upload-student{{$index}}" id="upload-student{{$index}}"  ng-src="{{student.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="student{{$index}}"  class="avatar-field bg-img" name="student{{$index}}" ng-value="student.imgsrc"/>
                        </div>
                    </div>
                    <p class="tips">图片建议尺寸: 750px*300px</p>
                </div>
                <div class="add-box" title="添加" ng-click="addNewstudent()"></div>
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
        $scope.articles = <{$articles}>;
        $scope.information = <{$information}>;
        $scope.linkTypesNew = <{$linkTypesNew}>;
        $scope.jumpList = <{$jumpList}>;
        $scope.courses = <{$courses}>;
        $scope.headerTitle= '<{$tpl['ati_title']}>';
      /*  $scope.mobile = '<{$tpl['ati_mobile']}>';
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
        $scope.fenleiNavs = [
            {
                index: 0,
                imgsrc: '/public/wxapp/train/images/home_school.png',
                title: '学校',
            },
            {
                index: 1,
                imgsrc: '/public/wxapp/train/images/home_course.png',
                title: '课程',
            },
            {
                index: 2,
                imgsrc: '/public/wxapp/train/images/home_elegant.png',
                title: '学员风采',
            }
        ];
        $scope.noticeTxt = <{$noticeList}>;
        $scope.courseInfo = {
                title:'<{$tpl['ati_course_title']}>',
                courseList:<{$courseList}>
            };
        $scope.teacherInfo = {
            title:'师资力量',
            teacherList: <{$teacherList}>
        };
        $scope.studentInfo = {
            title:'<{$tpl['ati_field_title']}>',
            studentList:<{$studentList}>
        }
        $scope.tpl_id	   = '<{$tpl['ati_tpl_id']}>';
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
                    imgsrc: '/public/wxapp/train/images/fenleinav.png',
                    title: '默认标题',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
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
                    type: '1',
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_75_40.png',
                    link: $scope.information.length>0?$scope.information[0].id:'',
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
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.noticeTxt.push(notice_Default);
            }
            console.log($scope.noticeTxt);
        }
        /*添加课程方法*/
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
                layer.msg("首页最多只能添加8个课程哦~");
            }else{
                var courseList_Default = {
                    index: defaultIndex,
                    name: '课程名称',
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_36_22.png',
                    intro:'课程简介',
                    articleTitle:$scope.articles.length>0?$scope.articles[0].name:'',
                    articleId:$scope.articles.length>0?$scope.articles[0].id:''
                };
                $scope.courseInfo.courseList.push(courseList_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }
            console.log($scope.courseInfo);
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
            for(var i = 0;i < courses.length;i++){
                if(courses[i].name == title){
                    curId = courses[i].id;
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

            var data = {
                'headerTitle' 	 : $scope.headerTitle,
                'mobile'         : $scope.mobile,
                'courseTitle' 	 : $scope.courseInfo.title,
                'coachTitle' 	 : $scope.teacherInfo.title,
                'fieldTitle' 	 : $scope.studentInfo.title,
                'address'        : $scope.address.address,
                'lng'            : $scope.address.longitude,
                'lat'            : $scope.address.latitude,
                'slide'		     : $scope.banners,
                'tpl_id'	     : $scope.tpl_id,
                'notice'         : $scope.noticeTxt,
                'courseInfo'     : $scope.courseInfo.courseList,
                'teacherInfo'    : $scope.teacherInfo.teacherList,
                'studentInfo'    : $scope.studentInfo.studentList
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