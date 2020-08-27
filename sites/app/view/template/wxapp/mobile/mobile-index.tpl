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
<{include file="../../manage/common-kind-editor.tpl"}>
<{include file="../common-second-menu-new.tpl"}>
<!--<div style="margin-left:135px;"><a target="_blank" style="color:red; " href="
https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=372">该插件使用教程请点此查看</a></div>-->
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
                    <!-- 背景图 -->
                    <div class="banner-box" style="height: 130px" data-left-preview data-id="1">
                        <img src="/public/manage/img/zhanwei/zw_fxb_750_320.png" alt="轮播图" ng-if="banners.length<=0">
                        <img ng-src="{{banners[0].imgsrc}}" alt="轮播图" ng-if="banners.length>0">

                    </div>
                    <!-- 配置-->
                    <div class="service-wrap" data-left-preview data-id="2" style="height: 145px;overflow: hidden;">
                        <div class="no-data-tip">点此添加配置信息~</div>
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
                <label style="width: 100%">幻灯管理<span>(幻灯图片尺寸：710px*285px)</span></label>
                <div class="banner-manage" ng-repeat="banner in banners track by $index">
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
            <!-- 配置管理 -->
            <div class="address" data-right-edit data-id="2">
                <div class="shops-name">配置信息</div>
                <div class="input-group-box">
                    <label class="label-name">虚拟店铺数量</label>
                    <input type="text" class="cus-input" ng-model="shopNum">
                </div>
                <div class="input-group-box">
                    <label class="label-name">虚拟浏览量</label>
                    <input type="text" class="cus-input" ng-model="browseNum" >
                </div>
                <div <{if $showHide != 1}> style="display:none" <{/if}>>
                    <div class="input-group-box">
                        <label class="label-name">显示搜索栏</label>
                        <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='show_search' type='checkbox' ng-model="searchShow">
                                <label class='tgl-btn' for='show_search' style="margin-right: 57%;width: 60px;"></label>
                </span>
                    </div>

                    <div class="input-group-box">
                        <label class="label-name">显示最新入驻</label>
                        <span class='tg-list-item'>
                                    <input class='tgl tgl-light' id='show_alert' type='checkbox' ng-model="alertShow">
                                    <label class='tgl-btn' for='show_alert' style="margin-right: 57%;width: 60px;"></label>
                    </span>
                    </div>
                </div>



                <!--
                <div style="margin: 10px 0">
                    <span>入驻是否收费:</span>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='must_mobile' type='checkbox' ng-model="ischarge">
                        <label class='tgl-btn' for='must_mobile' style="margin-top: -28px;margin-left: 100px"></label>
                    </span>
                </div>
                -->
                 <div class="input-group-box">
                    <label class="label-name">入驻协议</label>
                    <textarea class="cus-input" style="width:100%;height:400px;visibility:hidden;" id ="agreement" name="agreement" placeholder="入驻协议"  rows="20" style=" text-align: left; resize:vertical;"><{if $row && $row['ami_agreement']}><{$row['ami_agreement']}><{/if}></textarea>
                     <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                     <input type="hidden" name="ke_textarea_name" value="agreement" />
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script>

    var app = angular.module('chApp', ['RootModule']);

    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.headerTitle = '<{$row['ami_title']}>'?'<{$row['ami_title']}>':"电话本";
        $scope.shopNum     = '<{$row['ami_shop_num']}>';
        $scope.browseNum   = '<{$row['ami_browse_num']}>';
        $scope.ischarge    = true;
        $scope.banners     =<{if $slide}> <{$slide}> <{else}>new Array()<{/if}>;
        $scope.searchShow ='<{$row['ami_show_search']}>' > 0 ?true:false;
        $scope.alertShow ='<{$row['ami_show_alert']}>' > 0 ?true:false;
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
                    content: '最多只能添加6张广告图哦',
                    time: 2000
                });
            }else{
                var banner_Default = {
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/zw_fxb_750_320.png',
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
        };

        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.shopInfo.headImg = imgNowsrc;
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
        }

        // 保存数据
        $scope.saveData = function(){
        	layer.confirm('确定要保存吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
	            var agreement = $('#agreement').val();
	            var data = {
	                'title'    : $scope.headerTitle,
	                'shopNum'  : $scope.shopNum,
	                'browseNum': $scope.browseNum,
	                'ischarge' : $scope.ischarge == true ? 1 : 0,
	                'slide'    : $scope.banners,
	                'agreement': agreement,
                    'searchShow' : $scope.searchShow == true ? 1: 0,
                    'alertShow' : $scope.alertShow == true ? 1: 0,
	
	            };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/mobile/saveMobileIndex',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
	            });
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