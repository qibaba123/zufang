<link rel="stylesheet" href="/public/wxapp/train/teacher/css/index.css">
<link rel="stylesheet" href="/public/wxapp/train/teacher/css/style.css?2">

<style>
    .teacher-item .teacher-intro {
        height: auto;
        width: 100%;
    }

    .index-con .index-main {
        background-color: #edf1f4;
    }

    .service-wrap{
        background-color: #edf1f4;
        padding: 0;
    }

    .item-box{
        background: #fff;
    }
    .edit_title{
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
<{include file="../article-kind-editor-other.tpl"}>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                议程管理
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <!-- 师资力量 -->
                    <div class="service-wrap" >
                        <!--
                       <div class="hornor-wrap">
                            <div class="top-img cur-edit" data-left-preview data-id="-1">
                                <img ng-src="{{schoolPic==''?'/public/manage/img/zhanwei/zw_fxb_75_40.png':schoolPic}}" alt="议程封面图"/>
                            </div>
                        </div>
                        -->
                        <div class="service-wrap" data-left-preview data-id="-2">
                            <div ng-if="categoryList.length<=0" style="text-align: center;color: #999height: 50px;font-size: 20px;line-height: 50px;">
                                点此添加议程分类
                            </div>
                            <div ng-if="categoryList.length>0" style="display: table;background-color: #fff;font-size: 16px">
                                <span style="display: table-cell;width: 1000px;text-align: center;height: 50px;line-height: 50px;" ng-repeat="category in categoryList">{{category.name}}</span>
                            </div>
                        </div>
                        <div class="no-data-tip" ng-if="teacherList<=0">此处展示议程~</div>
                        <div class="teacher-list">
                            <div class="teacher-item" ng-repeat="progress in progressList">
                                <div class="item-box" data-left-preview data-id="{{$index}}">
                                    <div class="teacher-intro">
                                        <div style="display: inline-block;width: 30%;padding: 0 10px;border-right: 1px solid #edf1f4;">
                                            <div>时间</div>
                                            <div>{{progress.startTime}}</div>
                                        </div>
                                        <div style="display: inline-block;width: 68%;padding: 0 10px;">
                                            <div>{{progress.title}}</div>
                                            <div>{{progress.brief}}</div>
                                            <div>{{progress.startTime}}-{{progress.endTime}}</div>
                                            <div style="display: none">{{progress.content}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="add-taocan" ng-click="addNewProgress()">
                        <img src="/public/wxapp/train/images/icon_add.png" alt="议程">
                        <span>添加议程</span>
                    </div>
                    <div class="service-wrap" data-left-preview data-id="-3">
                        <div class="article-con" id="article-con" style="min-height: 100px;">
                           {{content.prgcontent}}
                        </div>
                    </div>

                    <div class="service-wrap" data-left-preview data-id="-4">
                        <div class="cooperative-wrap">
                            <img style="width:100%;" ng-src="{{bottomImg}}" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">

        <div class="edit-con">
            <!-- 师资管理 -->
            <div class="teacher jianzheng">
                <div class="teacher-manage-wrap">
                    <div class="hornor-covers" data-right-edit data-id="-1" style="display: none;">
                        <label>议程封面<span>（封面建议尺寸750px*400px）</span></label>
                        <div class="hornor-covers-manage">
                            <div class="edit-img">
                                <div class="edit-img">
                                    <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="750" data-height="400" imageonload="changeBg()" data-dom-id="upload-schoolPic" id="upload-schoolPic"  ng-src="{{schoolPic?schoolPic:'/public/manage/img/zhanwei/zw_fxb_75_40.png'}}"  height="100%" style="width: 100%;display:inline-block;margin-left:0;">
                                    <input type="hidden" id="schoolPic"  class="avatar-field bg-img" name="schoolPic" ng-value="schoolPic"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="service" data-right-edit data-id="-2" style="display: block;">
                        <label class="edit_title">议程分类</label>
                        <div class="banner-manage" ng-repeat="category in categoryList" style="position:relative;margin-bottom: 10px">
                            <div class="delete" style="top:10px" ng-click="delIndex('categoryList',category.index)">×</div>
                            <div class="edit-img">
                                <div class="shopintrobg-manage">
                                    <input type="text" class="cus-input" placeholder="分类名称"  ng-model="category.name" />
                                </div>
                            </div>
                        </div>
                        <div class="add-box" title="添加" ng-click="addNewCategory()"></div>
                        <div class="alert" role="alert" style="text-align: center"><button class="btn btn-blue btn-sm" ng-click="saveCategory()">保存分类</button></div>
                    </div>
                    <div class="teacher-manage jianzheng-manage" ng-repeat="progress in progressList" data-right-edit data-id="{{$index}}">
                        <label class="edit_title">议程详情</label>
                        <div class="delete" ng-click="delIndex('progressList',progress.index)">×</div>
                        <div class="edit-txt">
                            <div class="input-group">
                                <label>分类：</label>
                                <select class="cus-input" ng-model="progress.cid" ng-options="x.id as x.name for x in categoryList"></select>
                            </div>
                            <div class="input-group">
                                <label>标题：</label>
                                <input type="text" class="cus-input" ng-model="progress.title">
                            </div>
                            <div class="input-group">
                                <label>简介：</label>
                                <textarea class="cus-input" ng-model="progress.brief" ></textarea>
                            </div>
                            <div class="input-group">
                                <label>开始时间：</label>
                                <input type="text" class="cus-input" ng-model="progress.startTime">
                            </div>
                            <div class="input-group">
                                <label>结束时间：</label>
                                <input type="text" class="cus-input" ng-model="progress.endTime">
                            </div>
                            <div class="input-group">
                                <label style="width: 100%">详　情：</label>
                                <div>
                                    <div class="form-textarea">
                                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;text-align: left; resize:vertical;" ng-model="progress.content" id="article-detail{{progress.index}}" name="article-detail{{progress.index}}" placeholder="文章内容"  rows="20"></textarea>
                                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                        <input type="hidden" name="ke_textarea_name" value="article-detail{{progress.index}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="active" data-right-edit data-id="-3">
                        <label class="edit_title">会议嘉宾</label>
                        <div>
                            <div class="form-textarea">
                                <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;text-align: left; resize:vertical;" ng-model="content.prgcontent" id="content-detail" name="content-detail" placeholder="文章内容"  rows="20"></textarea>
                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                <input type="hidden" name="ke_textarea_name" value="content-detail" />
                            </div>
                        </div>
                    </div>
                    <div class="shopintrobg" data-right-edit data-id="-4">
                        <div class="isOn" style="margin-bottom: 10px">
                            <span>是否开启抽奖及背景图配置:</span>
                            <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='sms_start' type='checkbox' ng-model="appointInfo.isOn">
                                <label class='tgl-btn' for='sms_start'></label>
                            </span>
                        </div>
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="1" onload="changeSrc(this)" data-width="710" data-height="240" imageonload="changeBoot()" data-dom-id="upload-bottomImg" id="upload-bottomImg"  ng-src="{{bottomImg}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="bottomImg"  class="avatar-field bg-img" name="bottomImg{{$index}}" ng-value="bottomImg"/>
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
<script>
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.progressList = <{$progressList}>;
        $scope.categoryList = <{$categoryList}>;
        $scope.amid         = '<{$amid}>';
        $scope.schoolPic    = '<{$banners}>';
        $scope.bottomImg    = '<{$draw}>'?'<{$draw}>':'/public/wxapp/images/hzqy.png';
        $scope.content      = <{$content}>;

        $scope.appointInfo = {
            isOn:<{if $ison}> true <{else}> false <{/if}>,
        };
        /*议程封面图*/
        $scope.changeBg=function(){
            if(imgNowsrc){
                $scope.schoolPic = imgNowsrc;
            }
        };
        $scope.changeBoot=function(){
            if(imgNowsrc){
                $scope.bottomImg = imgNowsrc;
            }
        };
        /*添加议程方法*/
        $scope.addNewProgress = function(){
            if($scope.categoryList.length>0){
                var progressList_length = $scope.progressList.length;
                var defaultIndex = 0;
                if(progressList_length>0){
                    for (var i=0;i<progressList_length;i++){
                        if(defaultIndex < $scope.progressList[i].index){
                            defaultIndex = $scope.progressList[i].index;
                        }
                    }
                    defaultIndex++;
                }
                var progress_Default = {
                    cid: $scope.categoryList[0]['id'] ? $scope.categoryList[0]['id'] : 0,
                    index: defaultIndex,
                    title     : '标题',
                    brief     : '',
                    startTime : '00:00',
                    endTime  : '00:00'
                };
                $scope.progressList.push(progress_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                    add_kindeditor('article-detail'+defaultIndex);
                },500);
            }else{
                layer.msg('请先添加议程分类');
            }

        };
        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            console.log(type);
            console.log(type.length);
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
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
                $('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
            });
        };
        /*添加具体议程*/
        $scope.addNewCategory = function(){
            var category_length = $scope.categoryList.length;
            var defaultIndex = 0;
            if(category_length>0){
                for (var i=0;i<category_length;i++){
                    if(defaultIndex < $scope.categoryList[i].index){
                        defaultIndex = $scope.categoryList[i].index;
                    }
                }
                defaultIndex++;
            }
            var category_Default = {
                id: 0,
                index : defaultIndex,
                name  : '议程分类'
            };
            $scope.categoryList.push(category_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);


        };
        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).attr('data-id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit]").removeClass('show').stop().hide();
                $("[data-right-edit][data-id="+id+"]").stop().show();
            });
        });
        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            console.log(weddingTaocanDetailArray);
            console.log($scope.progressList.length);
            for(var i = 0;i<$scope.progressList.length;i++){
                console.log(i);
                $scope.progressList[i].content = weddingTaocanDetailArray[i+1];
                console.log($scope.progressList[i].content);
                console.log('++++++++++++++++++++++++++++');
                console.log(weddingTaocanDetailArray[i]);
            }
            var data = {
                progressList  : $scope.progressList,
                amid          : $scope.amid,
                'banners'	  : $scope.schoolPic,
                'draw'	      : $scope.bottomImg,
                'content'     : $('#content-detail').val(),
                ison          : $scope.appointInfo.isOn,
            };
            console.log(data);
            $http({
                method: 'POST',
                url   : '/wxapp/meeting/newSaveProgress',
                data  :  data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        // 保存数据
        $scope.saveCategory = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                categoryList:$scope.categoryList,
                amid        :$scope.amid,
            };

            $http({
                method: 'POST',
                url   : '/wxapp/meeting/newSaveCategory',
                data  :  data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
                /*window.location.reload();*/
            });
        };
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