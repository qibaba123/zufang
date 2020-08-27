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
                    <div class="appointment-wrap" data-left-preview data-id="2"  style="margin: 10px 0;">
                        <div class="no-data-tip" style="font-size: 20px;color: red">点此设置排行榜</div>
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
                        <div>
                        <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="doThis('banners',banner.index)" data-dom-id="upload-slide{{$index}}" id="upload-slide{{$index}}"  ng-src="{{banner.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="slide{{$index}}"  class="avatar-field bg-img" name="slide{{$index}}" ng-value="banner.imgsrc"/>
                        </div>
                    </div>
                    <!--
                    <div class="input-group clearfix">
                        <label for="">链接到：</label>
                        <select class="cus-input" ng-model="banner.articleTitle" ng-options="x.title as x.title for x in articles" ng-change="getSelectId('banners',banner.index,banner.articleTitle)"></select>
                    </div>
                    -->
                    <div class="input-group clearfix" style="display: none">
                        <label for="">链接类型：</label>
                        <!--
                        <select class="cus-input" ng-model="banner.type"  ng-options="x.id as x.name for x in linkTypesNew" ></select>
                        -->
                        <input type="hidden" class="cus-input" ng-value="107" ng-model="banner.type" />
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

                    <div class="input-group clearfix" ng-show="banner.type=='107'">
                        <label for="">小 游 戏：</label>
                        <select class="cus-input" ng-model="banner.link"  ng-options="x.id as x.name for x in gameList" ></select>
                    </div>
                    <!--
                    <div class="input-group clearfix" ng-show="banner.type==106">
                        <label for="">Appid：</label>
                        <input type="text" class="cus-input" ng-value="banner.link" ng-model="banner.link" />
                    </div>
                    -->
                </div>
                <div class="add-box" title="添加" ng-click="addNewBanner()"></div>
            </div>
            <div class="appoint" data-right-edit data-id="2">
                <div class="fenleinav-manage">
                    <div class="edit-img" style="width: 19%">
                        <div>
                            <img onclick="toUpload(this)" data-limit="1" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="changeRankImg()" data-dom-id="upload-rankImg" id="upload-rankImg"  ng-src="{{rankImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="rankImg"  class="avatar-field bg-img" name="rankImg{{$index}}" ng-value="rankImg"/>
                        </div>
                    </div>
                    <div class="edit-txt" style="width:80%;">
                        <div class="input-group clearfix">
                            <label for="" style="width: 17%;">标　题：</label>
                            <input type="text" maxlength="15" ng-model="rankTitle" style="width:83%;">
                        </div>
                        <!--
                        <div class="isOn">
                            <span>是否开启:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='rank_open' type='checkbox' ng-model="rankOpen">
                                <label class='tgl-btn' for='rank_open' style="float: right;margin-right: 57%;width: 60px;"></label>
                            </span>
                        </div>
                        -->
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


<script>
    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.articles        = <{$information}>;
        $scope.headerTitle     = '<{$tpl['agi_title']}>';
        $scope.banners         = <{$slide}>;
        $scope.tpl_id	  = 62;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkTypesNew = <{$linkTypeNew}>;
        $scope.linkList  = <{$linkList}>;
        $scope.rankOpen       = <{$tpl['agi_rank_open']}> > 1 ? false : true ;
        $scope.rankImg          = '<{$tpl['agi_rank_img']}>'?'<{$tpl['agi_rank_img']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png';
        $scope.rankTitle         = '<{$tpl['agi_rank_title']}>'?'<{$tpl['agi_rank_title']}>':'';
        $scope.jumpList = <{$jumpList}>;
        $scope.gameList = <{$gameList}>;



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
                    type : '107'
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

        $scope.changeRankImg=function(){
            if(imgNowsrc){
                $scope.rankImg = imgNowsrc;
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
                'headerTitle' 	 : $scope.headerTitle,
                'slide'		     : $scope.banners,
                'tpl_id'	     : $scope.tpl_id,
                'rankOpen'       : $scope.rankOpen == true ? 1 : 0,
                'rankImg'        : $scope.rankImg,
                'rankTitle'      : $scope.rankTitle
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/gamebox/saveAppletTpl',
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
<{include file="../img-upload-modal.tpl"}>