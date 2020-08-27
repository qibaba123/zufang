<link rel="stylesheet" href="/public/wxapp/train/honor/css/index.css">
<link rel="stylesheet" href="/public/wxapp/train/honor/css/style.css">
<style>
    .title{
        text-align: center;
        font-size: 16px;
    }
    .preview-page {
        width: 1050px;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-left: 130px;">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar cur-edit">
                会员充值
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="hornor-wrap">
                        <div class="cur-edit" data-left-preview>
                            <div class="title">{{privilegeTitle}}</div>
                            <div class="no-data-tip" ng-if="privilegeList.length<=0">点此添加内容~</div>
                            <div class="hornor-list" ng-if="privilegeList.length>0">
                                <div class="hornor-item" ng-repeat="privilege in privilegeList" style="height: 90px;width: 100%;float: inherit">
                                    <div class="hornor-con" style="width: 80%;border: 0;box-shadow: none;">
                                        <img ng-src="{{privilege.imgsrc}}" alt="特权图" style="width: 60px;float: left;height: 60px;" />
                                        <div style="width: 66%;float: left;margin-left: 15px;">
                                            <h4>{{privilege.title}}</h4>
                                            <div style="color: #999;font-size: 12px;line-height: 1.5em;margin-top: 5px;">{{privilege.brief}}</div>
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
            <div class="hornor" style="display: block;">
                <div class="input-group-box">
                    <label for="">标题：</label>
                    <input type="text" class="cus-input" ng-model="privilegeTitle">
                </div>
                <label><span>（图片建议尺寸200px*200px）</span></label>
                <div class="hornor-manage" ng-repeat="privilege in privilegeList">
                    <div class="delete" ng-click="delIndex('privilegeList',privilege.index)">×</div>
                    <div class="edit-img" style="float: left;width: 25%;padding: 20px;padding-left: 0;">
                        <div class="shopintrobg-manage">
                            <img onclick="toUpload(this)"  data-limit="8" onload="changeSrc(this)" data-width="200" data-height="200" imageonload="doThis('privilegeList',privilege.index)" data-dom-id="upload-privilege{{$index}}" id="upload-privilege{{$index}}"  ng-src="{{privilege.imgsrc}}"  height="100%" style="display:inline-block;margin-left:0;">
                            <input type="hidden" id="privilege{{$index}}"  class="avatar-field bg-img" name="privilege{{$index}}" ng-value="privilege.imgsrc"/>
                        </div>
                    </div>
                    <div class="edit-txt" style="float: left;width: 75%">
                        <div class="input-group-box clearfix">
                            <label for="">标题：</label>
                            <input type="text" class="cus-input" ng-model="privilege.title">
                        </div>
                        <div class="input-group-box clearfix">
                            <label for="">简介：</label>
                            <textarea name="" id="" class="cus-input" cols="30" rows="2" ng-model="privilege.brief"></textarea>
                        </div>
                    </div>
                </div>
                <div class="add-box" title="添加" ng-click="addNewPrivilege()"></div>
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
        $scope.privilegeList = <{$privilegeList}>;
        $scope.privilegeTitle = '<{$privilegeTitle}>'?'<{$privilegeTitle}>':'会员特权';
        $scope.addNewPrivilege = function(){
            var privilege_length = $scope.privilegeList.length;
            var defaultIndex = 0;
            if(privilege_length>0){
                for (var i=0;i<privilege_length;i++){
                    if(defaultIndex < $scope.privilegeList[i].index){
                        defaultIndex = $scope.privilegeList[i].index;
                    }
                }
                defaultIndex++;
            }
            var privilege_Default = {
                index: defaultIndex,
                imgsrc: '/public/manage/img/zhanwei/zw_fxb_200_200.png',
                title:'标题',
                brief:'介绍'
            };
            $scope.privilegeList.push(privilege_Default);
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
            console.log($scope.privilegeList);
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
            });
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
        $scope.saveData = function() {
            var index = layer.load(1, {
                shade: [0.1, '#fff'] //0.1透明度的白色背景
            }, {
                time: 10 * 1000
            });
            var data = {
                privilegeTitle: $scope.privilegeTitle,
                privilegeList: $scope.privilegeList
            };

            $http({
                method: 'POST',
                url: '/wxapp/community/saveVipCfg',
                data: data
            }).then(function (response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        }
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