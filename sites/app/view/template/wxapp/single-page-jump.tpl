<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/index.css?5">
<link rel="stylesheet" href="/public/wxapp/index/temp1/css/style.css?1">
<style>
    .article-con img{
        width: 100%;
    }
    .contact-box{
        padding: 10px;
    }
    .article-con{
        min-height: 300px;
        background-color: white;
        padding: 10px;
    }
    .bottom-menu{
        height: 50px;
        width: 100%;
    }
    .bottom-menu .no-menu-tips{
        line-height: 50px;
        text-align: center;
        font-size: 14px;
        color: #999;
    }
    .bottom-menu .menu-list{
        display: table;
    }
    .bottom-menu .menu-item{
        display: table-cell;
        height: 50px;
        overflow: hidden;
        width: 1000px;
    }
    .bottom-menu .menu-item img{
        width: 25px;
        height: 25px;
        margin:0 auto;
        display: block;
        margin-top: 5px;
        border-radius: 5px;
    }
    .bottom-menu .menu-item p{
        line-height: 20px;
        text-align: center;
        margin:0;
        font-size: 13px;
        color: #666;
    }
    .bottom-menu-manage{
        width: 420px;
        height: 60px;
        border-radius: 4px;
        overflow: hidden;
    }
    .bottom-menu-manage .menu-item{
        height: 60px;
    }
    .bottom-menu-manage .menu-item img{
        height: 30px;
        width: 30px;
    }
    .other-setting {
        padding: 10px 0;
    }
    .other-setting .color-set-box {
        overflow: hidden;
        padding: 3px 0;
    }
    .other-setting .color-set-box .label-name {
        float: left;
        line-height: 32px;
        text-align: right;
        width: 100px;
    }
    .sp-replacer{
        border: 1px solid #ddd;
        border-radius: 3px;
    }
    .activity-manage .edit-img{
        width: 70%;
        margin: 0 auto;
    }
    .activity-manage .edit-img img{
        width: 100%;
        margin:0 auto;
        cursor: pointer;
    }
    .activity-manage .edit-txt{
        padding-top: 10px;
    }
    .activity-manage .edit-txt .input-group-box{
        padding: 3px 0;
        overflow: hidden;
    }
    .activity-manage .edit-txt .input-group-box .label-name{
        width: 18%;
        float: left;
        line-height: 34px;
    }
    .activity-manage .edit-txt .input-group-box .cus-input{
        width: 82%;
        float: left;
    }
    .data-manage-tips{
        padding: 10px 0;
        font-size: 16px;
        font-weight: bold;
        color: #aaa;
        text-align: left;
    }
    .right-icon .curicon-box{
        display: inline-block;
        vertical-align: middle;
        overflow: hidden;
        padding: 1px;
        margin-right: 10px;
    }
    .right-icon .curicon-box img{
        float: left;
        height: 32px;
        width: 32px;
        margin:0 3px;
    }
    .right-icon .chooseicon{
        font-size: 12px;
        color: #007cf9;
        border:1px solid #007cf9;
        border-radius: 2px;
        padding: 5px;
        cursor: pointer;
    }
    div[data-menu].cur-edit {
        position: relative;
    }
    div[data-menu].cur-edit::after, div[data-menu].cur-edit:hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: 2px dashed #FC7C7C;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        z-index: 10;
        cursor: pointer;
    }
    .shopintrobg-manage img{
        width: 50%;
    }
    .appointment-wrap{
        padding: 0 0;
    }
    .index-con{
        height: auto !important;
    }
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <{include file="./article-kind-editor.tpl"}>
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit" data-left-preview data-id="0" ng-bind="headerTitle">

            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main" style="height: 100%;">
                    <div class="appointment-wrap" data-left-preview data-id="6">
                        <div class="no-data-tip" ng-if="!jumpInfo.isOn">点此管理小程序跳转~</div>
                        <div ng-if="jumpInfo.isOn" style="height: 100%;">
                            <img ng-src="{{jumpInfo.background}}" class="logo-bg" style="width: 100%"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con jianzheng-manage">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group">
                        <label for="">页面标题</label>
                        <input type="text" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                    <!--<div class="input-group">
                        <label for="">背景音乐</label>
                        <textarea type="text" placeholder="请输入背景音乐链接" ng-model="backgroundMusic"></textarea>
                    </div>-->
                </div>
            </div>
            <div class="appoint" data-right-edit data-id="6">
                <div class="appoint-manage" ng-if="jumpInfo.isOn">
                    <div class="input-group">
                        <label for="">跳转APPID:</label>
                        <!--<input type="text" class="cus-input" placeholder="请输入跳转小程序的APPID" maxlength="64" ng-model="jumpInfo.appid">-->
                        <select class="cus-input" ng-model="jumpInfo.appid"  ng-options="x.appid as x.name for x in jumpList" ></select>
                    </div>
                    <div class="input-group">
                        <label for="">跳转小程序背景图:</label>
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)" data-limit="1" onload="changeSrc(this)" data-width="750" data-height="1334" imageonload="changeBg()" data-dom-id="upload-logoBg" id="upload-logoBg{{$index}}"  ng-src="{{jumpInfo.background}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="logoBg"  class="avatar-field bg-img" name="logoBg" ng-value="logoBg"/>
                            <a href="#" class="change-bg" onclick="toUpload(this)"  data-limit="1" data-width="750" data-height="1334" data-dom-id="upload-logoBg">修改背景图<span>(建议尺寸750*1334)</span></a>
                        </div>
                    </div>
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
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.headerTitle= '<{$tpl['aspj_head_title']}>';
        $scope.backgroundMusic= '<{$tpl['aspj_background_music']}>';
        $scope.tpl_id	= '<{$tpl['aspj_tpl_id']}>';
        $scope.jumpList = <{$jumpList}>;
        $scope.jumpInfo = {
                isOn:true, //默认开启跳转
            background:"<{$tpl['aspj_jump_background']}>" ? "<{$tpl['aspj_jump_background']}>" : '/public/manage/img/zhanwei/zw_fxb_750_1334.png',
            appid:"<{$tpl['aspj_jump_appid']}>" ? "<{$tpl['aspj_jump_appid']}>" : '',
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
                        // $scope.addressStyle.color=realColor;
                        // console.log($scope.addressStyle.color);
                    });
                },
                palette: [
                    ['black', 'white', 'blanchedalmond',
                        'rgb(255, 128, 0);', '#6bc86b'],
                    ['red', 'yellow', '#16cfc0', 'blue', 'violet']
                ]

            });
        };


        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope[type][realIndex].imgsrc = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

        $scope.doIconThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            // console.log($scope[type][realIndex].imgsrc);
            //console.log($scope[type][realIndex].imgsrc);
            $scope[type][realIndex].icon = imgNowsrc;
            //console.log($scope[type][realIndex]);
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.jumpInfo.background = imgNowsrc;
            }
        };
        $scope.changeBottomImg=function(){
            if(imgNowsrc){
                $scope.bottomImg = imgNowsrc;
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
            if(banner_length>8){
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
                    imgsrc: '/public/wxapp/mall/temp3/images/banner_750_400.jpg',
                    link: '',
                    articleId: "",
                    articleTitle: ""
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

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'title' 	 : $scope.headerTitle,
                'music' 	 : $scope.backgroundMusic,
                'tpl_id'	 : $scope.tpl_id,
                'jumpInfo'   : $scope.jumpInfo,
            };
            console.log(data);

            $http({
                method: 'POST',
                url:    '/wxapp/single/saveAppletTplJump',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).data('id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
                if(id==7){
                    $("#menuBox").stop().show();
                    $("#menuBox [data-menu-show]").eq(0).stop().show();
                    $(".bottom-menu-manage [data-menu]").eq(0).addClass('cur-edit');
                }else{
                    $("#menuBox").stop().hide();
                }
            });

            $('.bottom-menu-manage').on('click', '[data-menu]', function(event) {
                var id = $(this).data('type');
                $(this).parents('.bottom-menu-manage').find('[data-menu]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                console.log($scope.menuList);
                $("[data-menu-show][data-type="+id+"]").stop().show().siblings().stop().hide();
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
</script>
<{include file="./img-upload-modal.tpl"}>