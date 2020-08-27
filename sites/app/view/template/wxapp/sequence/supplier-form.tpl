<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<link rel="stylesheet" href="/public/wxapp/form/css/index.css?2">
<link rel="stylesheet" href="/public/wxapp/form/css/style.css?3">
<style>
    .page-content {
        padding: 0;
        overflow-x: scroll;
    }

    .list {
        list-style: none outside none;
        margin: 10px 0 30px;
    }

    .apps-container {
        border: 2px dashed blue;
        margin: 10px 10px 0 0;
        padding: 5px;
    }

    .app {
        padding: 5px 14px;
        border-bottom: 1px solid #eee;
        font-size: 1.1em;
        font-weight: bold;
        text-align: center;
        cursor: move;
    }

    .left-apps-container .app:last-child {
        border-bottom: 0;
    }

    .container .app{
        background: #fff;
    }

    /***  Extra ***/

    body {
        font-family: Verdana, 'Trebuchet ms', Tahoma;
    }

    .container {
        width: 530px;
        margin: auto;
        float: left;
    }

    h2 {
        text-align: center;
    }

    .floatleft {
        float: left;
        height: 100vh;
        background: #F6F6F6;
        width: 331px;
        border-right: 1px solid #ddd;
    }

    .connected-drop-target-sortable{
        width: 200px;
        height: 500px;
    }

    .draggable-element-container .app{
        height: 110px;
        width: 110px;
    }

    .screen{
        width: 110px;
        display: inline-block;
        border-left: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
    }

    .screen:last-child{
        border-right: 1px solid #ddd;
    }

    .mobile-page{
        margin: 80px 130px;
    }

    .form-title{
        display: block;
        text-align: left;
        color: #999;
    }

    input,select{
        width: 100%;
        height: 30px;
    }

    textarea{
        width: 100%;
    }

    input,textarea{
        padding: 5px;
        border-radius: 4px;
    }

    .mobile-page .mobile-con {
        background-color: #F6F6F6;
        padding: 0;
        overflow-y: scroll;
    }

    .mobile-page .mobile-con::-webkit-scrollbar {
        display: none;
    }

    .btn-submit{
        padding: 5px 15px;
        border-radius: 4px;
        background: #1FC51D;
        color: #fff;
    }

    .edit-right {
        margin-left: 0;
        width: 500px;
        float: left;
    }

    .add-options{
        padding: 5px 15px;
        border-radius: 4px;
        margin-top: 10px;
    }

    .options-box{
        padding: 10px;
        background: #fff;
        margin-top: 10px;
        border-radius: 4px;
        text-align: center;
    }

    .input-group-box .delete {
        border-radius: 50%;
        background-color: #ddd;
        color: #fff;
        width: 26px;
        height: 26px;
        line-height: 26px;
        top: 4px;
        right: 8px;
        font-weight: normal;
    }

    .options-box .cus-input{
        width: 90%;
        float: left;
    }

    .delete {
        z-index: 100;
    }

    .mobile-con .delete{
        background: #ccc;
        width: 15px;
        height: 15px;
        padding: 2px;
    }

    .mobile-con .delete img{
        width: 100%;
    }
    .component-title{
        text-align: center;
        font-size: 22px;
        padding: 20px 0;
        background: #fff;
        border-bottom: 1px solid #ddd;
    }
    .icon-img{
        width: 100%;
    }
    .top-tip{
        line-height: 20px;
        width: 40%;
        position: absolute;
        text-align: center;
        left: 700px;
    }
</style>
<div ng-app="sortableApp" ng-controller="sortableController" style="width: 1480px">
    <div class="floatleft">
        <div class="component-title">表单组件</div>
        <div class="left-apps-container">
            <div ui-sortable="draggableOptions" class="screen draggable-element-container"
                 ng-repeat="draggableArray in draggables track by $index"
                 ng-model="draggableArray" >
                <div ng-repeat="draggable in draggableArray" class="app"  data-type="{{draggable.type}}">
                    <div style="width: 30px;height: 30px;margin: 15px auto;line-height: 60px">
                        <img src="/public/wxapp/form/images/{{draggable.type}}.png" alt="" class="icon-img"/>
                    </div>
                    {{draggable.data.title}}
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-block alert-warning top-tip">
        使用方法: 选中左边的表单组件, 点击往中间手机框里拖拽, 拖拽到手机框后点击在右侧配置
    </div>
    <div class="container preview-page">
        <div class="mobile-page">
            <div class="mobile-header"></div>
            <div ui-sortable="sortableOptions" class="mobile-con apps-container screen connected-drop-target-sortable" ng-model="selectedComponents">
                <div class="title-bar cur-edit" data-left-preview setclick data-id="-1" ng-bind="headerTitle">

                </div>
                <div class="app" ng-repeat="component in selectedComponents track by $index" style="padding: 0">
                    <div style="position: relative;padding: 10px" data-left-preview setclick data-id="{{$index}}" >
                        <div class="handler" style="width: 50px;height: 20px;background: #fff;border: 1px solid #333;position: absolute;top: 0;z-index: 1000;left: 42%;border-radius: 4px;display: none;"></div>
                        <div class="input" ng-if="component.type == 'input'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <input type="text" name="" disabled="true" placeholder="{{component.data.placeholder}}">
                        </div>
                        <div class="input" ng-if="component.type == 'textarea'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <textarea name="" id="" disabled="true" cols="30" rows="2" placeholder="{{component.data.placeholder}}"></textarea>
                        </div>
                        <div class="input" ng-if="component.type == 'upload'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <img src="/public/wxapp/form/images/upload.png" alt="" style="width: 100px;">
                        </div>
                        <div class="input" ng-if="component.type == 'select'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <select class="cus-input form-control" disabled="true">
                                <option ng-repeat="x in component.data.options track by $index" >{{x.title}}</option>
                            </select>
                        </div>
                        <div class="input" ng-if="component.type == 'time'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <input type="text" disabled="true" name="" placeholder="2017-12-21">
                        </div>
                        <div class="input" ng-if="component.type == 'submit'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <button class="button btn-submit">{{component.data.title}}</button>
                        </div>
                        <div class="input" ng-if="component.type == 'map'">
                            <div class="delete" ng-click="delItem($index)"><img src="/public/wxapp/form/images/delete.png" alt=""></div>
                            <label class="form-title" for="">{{component.data.title}}</label>
                            <div>{{component.data.placeholder}}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-footer"><span></span></div>
        </div>
    </div>
    <div class="edit-right">
        <div class="edit-con" >
            <div class="header-top" data-right-edit data-id="-1" style="display:block;">
                <label>顶部管理</label>
                <div class="top-manage">
                    <div class="input-group-box">
                        <label class="label-name">页面标题：</label>
                        <input type="text" class="cus-input" placeholder="请输入页面标题" maxlength="10" ng-model="headerTitle">
                    </div>
                </div>
            </div>
            <div data-right-edit ng-repeat="component in selectedComponents track by $index" data-id="{{$index}}">
                <div class="banner-wrap" ng-if="component.type == 'input'"  >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">提示语：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.placeholder">
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
                <div ng-if="component.type == 'textarea'" >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">提示语：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.placeholder">
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
                <div ng-if="component.type == 'upload'" >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
                <div ng-if="component.type == 'time'" >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
                <div ng-if="component.type == 'submit'" >
                    <div class="input-group-box">
                        <label class="label-name">按钮文字：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                </div>
                <div class="banner-wrap" ng-if="component.type == 'map'"  >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="input-group-box">
                        <label class="label-name">提示语：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.placeholder">
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
                <div ng-if="component.type == 'select'" >
                    <div class="input-group-box">
                        <label class="label-name">标题：</label>
                        <input type="" name="" class="cus-input"  ng-model="component.data.title">
                    </div>
                    <div class="options-box">
                        <div class="input-group-box" style="margin-bottom: 10px" ng-repeat="option in component.data.options track by $index">
                            <div style="position: relative;height: 40px">
                                <div class="delete" ng-click="delOption($parent.$index, $index)">-</div>
                                <input type="" name="" class="cus-input"  ng-model="option.title">
                            </div>
                        </div>
                        <button ng-click="addNewOptions($index)" class="add-options">添加选择项</button>
                    </div>
                    <div class="isOn">
                        <span>是否必填:</span>
                        <span class='tg-list-item'>
                            <input class='tgl tgl-light' id="form{{$index}}" type='checkbox' ng-model="component.require">
                            <label class='tgl-btn' for='form{{$index}}'></label>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning save-btn-box" role="alert"><button class="btn btn-blue btn-sm" ng-click="saveData()">  保 存 </button></div>

    <div style="clear: both;"></div>
</div>


<script src="/public/plugin/layui/jquery-ui-1.9.2.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script>
    var myapp = angular.module('sortableApp', ['RootModule',"ui.sortable"]);


    myapp.controller('sortableController',['$scope','$http',function ($scope, $http) {
        var tmpList = [];
        $scope.headerTitle = '<{$headerTitle}>'?'<{$headerTitle}>':'自定义表单';

        var originalDraggables = [
                {
                    'type' : 'input',
                    'data':{'title': '单文本','placeholder': '请输入文本内容'},
                    'require': true
                },
                {
                    'type' : 'textarea',
                    'data':{'title': '多文本','placeholder': '请输入文本内容'},
                    'require': true
                },
                {
                    'type' : 'upload',
                    'data':{'title': '图片上传'},
                    'require': true
                },
                {
                    'type' : 'select',
                    'data':{'title': '下拉选择','options': []},
                    'require': true
                },
                {
                    'type' : 'time',
                    'data':{'title': '时间选择'},
                    'require': true
                },
                {
                    'type' : 'submit',
                    'data':{'title': '提交按钮'},
                    'require': false
                },
                {
                    'type' : 'map',
                    'data':{'title': '地图','placeholder': '点击选择地址'},
                    'require': true
                }
        ];

        $scope.draggables = originalDraggables.map(function(x){
            return [x];
        });
        $scope.selectedComponents = <{$data}>;

        $scope.addNewOptions = function(i){
            var banner_Default = {
                'title': '选择项'
            };
            $scope.selectedComponents[i].data.options.push(banner_Default);
        }

        $scope.delOption = function(i,index){
            $scope.selectedComponents[i].data.options.splice(index,1);
        }

        $scope.delItem = function(index){
            $scope.selectedComponents.splice(index,1);
            if($scope.selectedComponents.length==0){
                $('.edit-right').hide();
            }
        }

        $scope.sortingLog = [];

        $scope.draggableOptions = {
            connectWith: ".connected-drop-target-sortable",
            revert: false,
            cursor: "move",
            cursorAt: { top: 35, left: 35 },
            helper: function( event,ui ) {
                return $( "<div style='width: 100px;height: 94px;text-align:center;background:#fff;border-right: 1px solid #DCDCDC;border-bottom: 1px solid #DCDCDC;border-radius:4px;opacity:0.9'><img src='/public/wxapp/form/images/"+ui.context.dataset.type+".png' alt='' style='width:40px;margin-top:25px;'/><div>" );
            },

            change:function(){
                $('.app').css('display', 'block');
                $('.left-apps-container .ui-sortable-placeholder').css('display', 'none');
            },

            stop: function (e, ui) {
                // if the element is removed from the first container
                if (ui.item.sortable.source.hasClass('draggable-element-container') &&
                        ui.item.sortable.droptarget &&
                        ui.item.sortable.droptarget != ui.item.sortable.source &&
                        ui.item.sortable.droptarget.hasClass('connected-drop-target-sortable')) {
                    // restore the removed item
                    ui.item.sortable.sourceModel.push(ui.item.sortable.model);
                    $scope.selectedComponents = angular.copy($scope.selectedComponents);
                }
            }
        };

        $scope.sortableOptions = {};

        // 保存数据
        $scope.saveData = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });

            var data = {
                'formData' 	 : $scope.selectedComponents,
                'headerTitle'   : $scope.headerTitle
            };
           $http({
                method: 'POST',
                url:    '/wxapp/sequence/saveSupplierForm',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };
    }]);
    myapp.directive('setclick', function () {
        return {
            restrict: 'A', scope:{data:'@id'}, link: function (scope, element, attrs) {
                attrs.$observe('id',function(val){
                    element.bind('click', function () {
                        var id = val;
                        element.parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                        element.addClass('cur-edit');
                        $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
                        $('.edit-right').show();
                    });
                });
            }
        };
    });
</script>