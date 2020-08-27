<link rel="stylesheet" href="/public/manage/goodsCategory/css/index.css">
<link rel="stylesheet" href="/public/manage/goodsCategory/css/style.css">
<style>
.first-img{
        height: 60px;
        margin-bottom: 10px;
    }
    .first-img-label{
        width: 99px !important;
    }
    .first-img-tips{
        display: inline-block;
        height: 60px;
        line-height: 60px;
        padding-left: 5px;
        font-size: 12px;
    }
    .radio-right{
        width: 100%;
        display: inline-block;
    }
    .second-item-manage .right-input {
        padding-left: 0;
    }
</style>
<div class="copy-box" style="max-width: 860px;margin:10px auto 0;">
    <!--<div class="input-group">
        <div class="input-group-addon">商品分类</div>
        <input type="text" class="form-control" id="copyLink" value="<{$link}>" readonly>
        <div class="input-group-btn"><span class="btn btn-md btn-blue copy_input" data-clipboard-target="copyLink">复制链接</span></div>
    </div>-->
</div>
<div class="preview-page" ng-app="proApp" ng-controller="proCtrl" style="padding-bottom:70px;">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                课程分类管理
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="first-fenlei" style="top:0">
                        <div ng-repeat="firstFenlei in goodFenleis" class="first-item border-t" ng-class="{'active':$first}" data-type="#second-item-box{{firstFenlei.index}}" ng-bind="firstFenlei.firstName"></div>
                    </div>
                    <div class="second-fenlei" style="top:0">
                        <div class="second-item-box" ng-repeat="firstFenlei in goodFenleis" id="second-item-box{{firstFenlei.index}}">
                            <h3 class="first-name" ng-bind="firstFenlei.firstName"></h3>
                            <div class="second-box">
                                <a href="#" class="second-item" ng-repeat="secondFenlei in firstFenlei.secondItem">
                                    <p ng-bind="secondFenlei.secondName"></p>
                                </a>
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
            <div class="fenlei-manage" ui-sortable="sortableOptions" ng-model="goodFenleis">
                <div class="first-item-manage" ng-repeat="firstFenlei in goodFenleis  track by $index" ng-init="flindex = $index">
                    <div class="del-btn" ng-click="delFirstItem(firstFenlei.index)">×</div>

                    <div class="input-rows">
                        <label for="">一级分类名称：</label>
                        <input type="text" class="cus-input" ng-model="firstFenlei.firstName" maxlength="8">
                    </div>
                    <div class="see-second-item" ng-click="secondShow(flindex)"><b>展开二级分类</b><span class="icon-tip">﹀</span></div>
                    <div class="second-manage" ui-sortable="sortableOptions" ng-model="firstFenlei.secondItem">
                        <div class="second-item-manage" ng-repeat="secondFenlei in firstFenlei.secondItem track by $index">
                            <div class="del-btn" ng-click="delSecondItem(firstFenlei.index,secondFenlei.index)">×</div>
                            <div class="right-input" style="height: 86px" ng-if="firstFenlei.secondShow">
                                <div class="input-name">
                                    <label>分类名称：</label>
                                    <input type="text" class="cus-input" ng-model="secondFenlei.secondName" maxlength="6">
                                </div>

                                <div class="input-rows hide">
                                    <label class="hide">链接地址：</label>
                                    <input type="hidden" class="cus-input" class="hide" ng-model="secondFenlei.link">
                                </div>
                            </div>
                        </div>
                        <div style="padding: 10px 0 5px;text-align: center;">
                            <div class="btn btn-sm btn-green" ng-click="addSecondItem(firstFenlei.index)">+添加二级分类</div>
                        </div>
                    </div>
                </div>
                <div style="padding: 10px 0 5px;text-align: center;">
                    <div class="btn btn-sm btn-blue" ng-click="addFirstItem()">+添加一级分类</div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-primary btn-sm"  ng-click="saveChange();"> 保 存 </button></div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script src="/public/manage/goodsCategory/js/jquery-ui-1.9.2.min.js"></script>
<script src="/public/manage/goodsCategory/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/goodsCategory/js/angular-root.js"></script>
<script src="/public/manage/goodsCategory/js/sortable.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
    } );

    var imgNowsrc=0;//图片路径

    var app = angular.module('proApp',['RootModule','ui.sortable']);
    app.controller('proCtrl', ['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.goodFenleis = <{$category}>;
        console.log($scope.goodFenleis);
        $scope.sortableOptions = {
            update: function(e, ui) {
                console.log("拖动完成");
            },
            axis: 'y'
        };
        $scope.addFirstItem = function(){
            var length = $scope.goodFenleis.length;
            var defaultIndex = 0;
            if(length>0){
                for (var i=0;i<length;i++){
                    var temp = parseInt($scope.goodFenleis[i].index);
                    if(defaultIndex < temp){
                        defaultIndex = temp;
                    }
                }
                defaultIndex++;
            }
            var defaultFirstItem = {
                index:defaultIndex,
                firstName:'主分类',
                imgSrc:"/public/manage/img/zhanwei/zw_fxb_640_200.png",
                imgShow:1,
                show:1,
                secondItem:[
                    {
                        id:0,
                        index:0,
                        secondName:"二级分类",
                        imgSrc:"/public/manage/img/zhanwei/fenleinav.png",
                        link:"",
                        show:1
                    }
                ]
            };
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
            $scope.goodFenleis.push(defaultFirstItem);
        };
        $scope.addSecondItem = function(id){
            var realIndex = $scope.getRealIndex($scope.goodFenleis,id);
            var length = $scope.goodFenleis[realIndex].secondItem.length;
            var defaultIndex = 0;
            if(length>0){
                for (var i=0;i<length;i++){
                    var temp = parseInt($scope.goodFenleis[realIndex].secondItem[i].index);
                    if(defaultIndex < temp){
                        defaultIndex = temp;
                    }
                }
                defaultIndex++;
            }
            var defaultFirstItem = {
                id:0,
                index:defaultIndex,
                secondName:"二级分类",
                imgSrc:"/public/manage/img/zhanwei/fenleinav.png",
                link:"",
                show:1
            };
            $scope.goodFenleis[realIndex].secondItem.push(defaultFirstItem);
            console.log($scope.goodFenleis[realIndex].secondItem);
            //重新绑定上传图片事件
            $timeout(function(){
                //卸载掉原来的事件
                $(".cropper-box").unbind();
                new $.CropAvatar($("#crop-avatar"));
            },500);
        };

        $scope.secondShow = function(index) {
            console.log($scope.goodFenleis);
            $scope.goodFenleis[index].secondShow = 1;
        }
        
        $scope.delFirstItem = function(id){
            var realIndex = -1;
            var realIndex = $scope.getRealIndex($scope.goodFenleis,id);
            console.log(realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope.goodFenleis.splice(realIndex,'1');
                });
                layer.msg('删除成功！');
            });
        };
        $scope.delSecondItem = function(firstId,secondid){
            var realFirstIndex = -1,realSecondIndex = -1;
            var realFirstIndex = $scope.getRealIndex($scope.goodFenleis,firstId);
            var realSecondIndex = $scope.getRealIndex($scope.goodFenleis[realFirstIndex].secondItem,secondid);
            console.log(realFirstIndex+"---"+realSecondIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope.goodFenleis[realFirstIndex].secondItem.splice(realSecondIndex,'1');
                });
                layer.msg('删除成功！');
            });
        };
        /*获取真正索引*/
        $scope.getRealIndex = function(type,id){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==id){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };

        $scope.saveChange=function(){
        	layer.confirm('确定要保存吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var index = layer.load(1, {
	                shade: [0.1,'#fff'] //0.1透明度的白色背景
	            },{
	                time : 10*1000
	            });
	            var data = {
	                'category' 	 : JSON.stringify($scope.goodFenleis)
	            };
	            $http({
	                method: 'POST',
	                url:    '/wxapp/goods/saveCategory',
	                data:   data
	            }).then(function(response) {
	                layer.close(index);
	                layer.msg(response.data.em);
	            });
            });

        };
        $scope.doThis=function(findex,index){
            var realFindex = -1,realIndex = -1;
            var realFindex = $scope.getRealIndex($scope.goodFenleis,findex);
            var realIndex  = $scope.getRealIndex($scope.goodFenleis[realFindex].secondItem,index);
            var catObj = $scope.goodFenleis;
            /*获取要用的真正索引*/
            if(imgNowsrc){
                catObj[realFindex].secondItem[realIndex].imgSrc = imgNowsrc;
                imgNowsrc = '';
            }
        }
        $scope.doThisFirst=function(findex,index){
            var realFindex = -1,realIndex = -1;
            var realFindex = $scope.getRealIndex($scope.goodFenleis,findex);
            var catObj = $scope.goodFenleis;
            /*获取要用的真正索引*/
            if(imgNowsrc){
                catObj[realFindex].imgSrc = imgNowsrc;
                imgNowsrc = '';
            }
        }
    }]);

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            imgNowsrc = allSrc[0];
            console.log(nowId);
            $('#'+nowId).attr('src',imgNowsrc);
        }
    }

    $(function(){
        mobileInit();//左侧页面所需

        $(".fenlei-manage").on('click', '.see-second-item', function(event) {
            event.preventDefault();
            var self = $(this);
            self.parents(".first-item-manage").siblings().find('.see-second-item').removeClass('show');
            self.toggleClass("show");
            if(!self.hasClass('show')){
                self.find('b').text('展开二级菜单');
                self.next().stop().slideUp();
            }else{
                self.parents(".fenlei-manage").find('.see-second-item').find('b').text('展开二级菜单');
                self.parents(".fenlei-manage").find('.see-second-item').next().stop().slideUp();
                self.find('b').text('隐藏二级菜单');
                self.next().stop().slideDown();
            }
        });
    });
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    //call the function that was passed
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });
    /*手机页面预览*/
    function mobileInit(){
        $(".first-fenlei").on('click', '.first-item', function(event) {
            var $this = $(this);
            $this.addClass('active').siblings().removeClass('active');
            var searchTop = $(".search-box").outerHeight(),
                curScrollTop = $this.parents('.first-fenlei').scrollTop(),
                scrollTop = $this.position().top-100+curScrollTop;
            scrollTop = scrollTop>0 ? scrollTop : 0;
            $(".first-fenlei").animate({
                "scrollTop":scrollTop+"px"
            }, 500);
            // 右侧分类平滑过渡
            var secId = $this.data("type"),
                targetOffset = $(secId).position().top,
                curScrollTop = $('.second-fenlei').scrollTop();
            $('.second-fenlei').animate({
                scrollTop: (targetOffset+curScrollTop)+'px'
            },500);
        });
    }
</script>