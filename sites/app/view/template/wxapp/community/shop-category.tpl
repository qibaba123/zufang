<link rel="stylesheet" href="/public/manage/goodsCategory/css/index.css">
<link rel="stylesheet" href="/public/manage/goodsCategory/css/style.css">
<div class="preview-page" ng-app="proApp" ng-controller="proCtrl" style="padding-bottom:70px;">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                店铺分类管理
            </div>
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="first-fenlei" style="top: 0">
                        <div ng-repeat="firstFenlei in goodFenleis" data-index="{{$index}}" class="first-item first-item{{$index}} border-t" ng-class="{'active':$first}" data-type="#second-item-box{{firstFenlei.index}}" ng-bind="firstFenlei.firstName"></div>
                    </div>
                    <div class="second-fenlei" style="padding-left: 30px;top: 0">
                        <div class="second-item-box" ng-repeat="firstFenlei in goodFenleis" id="second-item-box{{firstFenlei.index}}">
                            <div class="second-box second{{$index}}" >
                                <a href="#" class="second-item" style="display: block;float: inherit;margin: 10px 0;" ng-repeat="secondFenlei in firstFenlei.secondItem">
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
                <div class="first-item-manage" ng-repeat="firstFenlei in goodFenleis">
                    <div class="del-btn" ng-click="delFirstItem(firstFenlei.index)">×</div>
                    <div class="input-rows">
                        <label for="">一级分类名称：</label>
                        <input type="text" class="cus-input" ng-model="firstFenlei.firstName" maxlength="8">
                    </div>
                    <div class="see-second-item"><b>展开二级分类</b><span class="icon-tip">﹀</span></div>
                    <div class="second-manage" ui-sortable="sortableOptions" ng-model="firstFenlei.secondItem">
                        <div class="second-item-manage" ng-repeat="secondFenlei in firstFenlei.secondItem">
                            <div class="del-btn" ng-click="delSecondItem(firstFenlei.index,secondFenlei.index)">×</div>
                            <div class="right-input" style="padding: 0;height: auto;">
                                <div class="input-name">
                                    <label>分类名称：</label>
                                    <input style="display: inline-block;width: 80%;" type="text" class="cus-input" ng-model="secondFenlei.secondName" maxlength="6">
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


<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
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
                secondItem:[
                    {
                        id:0,
                        index:0,
                        secondName:"二级分类",
                        link:""
                    }
                ]
            };
            $scope.goodFenleis.push(defaultFirstItem);
            $('.second-box').hide();
            $('.second'+defaultIndex).show();

            $timeout(function(){
                //卸载掉原来的事件
                $('.first-item'+defaultIndex).addClass('active').siblings().removeClass('active');
            },10);

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
                link:""
            };
            $scope.goodFenleis[realIndex].secondItem.push(defaultFirstItem);

        };
        
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
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'category' 	 : $scope.goodFenleis
            };
            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/community/saveShopCategory',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
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
        $('.second-box').hide();
        $('.second0').show();
        $(".first-fenlei").on('click', '.first-item', function(event) {
            var $this = $(this);
            $this.addClass('active').siblings().removeClass('active');
            $('.second-box').hide();
            $('.second'+$(this).data('index')).show();
        });
    }
</script>