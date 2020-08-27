<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style type="text/css">
    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

    table {
        width: 100%;
        border: 1px solid #ecedf0;
        border-radius: 2px;
        table-layout: fixed;
        background: #fff;
        text-align: center;
    }

    table th {
        background: #f7f7f7;
        height: 50px;
        line-height: 50px;
        color: #404040;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
        position: relative;
        font-weight: 400;
        text-align: center;
    }

    table td.border-right {
        border-right: 1px solid #ecedf0;
        text-align: center;
    }

    table td {
        border-top: 1px solid #ecedf0;
        height: 52px;
        line-height: 22px;
        color: #666;
        font-size: 14px;
        padding-left: 6px;
        padding-right: 6px;
        word-wrap: break-word;
        border-right: 1px solid #ecedf0;
    }

    table td .form-control {
        max-width: 100%;
    }

    .delete {
        height: 25px;
        line-height: 25px;
        text-align: center;
        width: 25px;
        position: absolute;
        top: 0;
        right: 0;
        font-size: 22px;
        font-weight: 900;
        cursor: pointer;
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>

<div ng-app="chApp" ng-controller="chCtrl">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/goods/allCommonGoods"> 返回 </a></small></h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>商品名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" disabled="disabled" placeholder="请填写商品名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品原价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_ori_price" disabled="disabled" name="g_ori_price" placeholder="原价" required="required" value="<{if $row}><{$row['g_ori_price']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>商品售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" disabled="disabled" onblur="mathVIp()" placeholder="请填写商品售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>商品信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">全球购商品：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="g_is_global" id="global1" value="1" disabled="disabled" <{if $row && $row['g_is_global'] eq 1}>checked<{/if}>>
                                                                        <label for="global1">是</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="g_is_global" id="global2" value="0" disabled="disabled"  <{if !($row && $row['g_is_global'] eq 1)}>checked<{/if}>>
                                                                        <label for="global2">否</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">商品标签：</label>

                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_custom_label" name="g_custom_label" disabled="disabled" placeholder="请填写商品标签,不同标签以空格隔开"  value="<{if $row}><{$row['g_custom_label']}><{/if}>" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>规格</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div>
                                                            <div class="form-group" ng-if="spec.length>0">
                                                                <div class="control-group" style="margin-left: 80px;">
                                                                    <table >
                                                                        <thead>
                                                                        <th ng-repeat="s in spec" ng-if="s.value.length>0">{{s.name}}</th>
                                                                        <th>价格</th>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr ng-repeat="data in dataList track by $index" ng-init="trIndex = $index">
                                                                            <td ng-repeat="d in data.spec track by $index" rowspan="{{rowspan[$index]}}" ng-if="trIndex % rowspan[$index]==0">{{d.name}}</td>
                                                                            <td><input type="text" class="form-control" style="max-width: 100%" ng-model="data.price" disabled="disabled" /></td>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info" style="padding-left: 90px;">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">商品封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover" id="upload-g_cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">商品幻灯图(<small>最多五张，尺寸 640 x 640 像素</small>)</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['gs_path']}>"  layer-pid="" src="<{$val['gs_path']}>" >
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['gs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['gs_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="info-group-box">
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>视频地址</span>
                                                        </div>
                                                        <div class="group-info" style="padding-left: 90px;">
                                                            <div class="form-group">
                                                                <div class="control-group" style="margin-left: 0px">
                                                                    <input type="text" class="form-control" id="g_video" name="g_video" disabled="disabled" placeholder="请填写视频地址" required="required" value="<{if $row}><{$row['g_video_url']}><{/if}>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="info-group-box">
                                                    <div class="info-group-inner">
                                                        <div class="group-title">
                                                            <span>商品参数</span>
                                                        </div>
                                                        <div class="group-info" style="padding-left: 90px;">
                                                            <div class="form-group">
                                                            <div class="control-group" style="margin-left: 0px">
                                                                <textarea class="form-control" style="width:850px;height:400px;visibility:hidden;" id = "g_parameter" name="g_parameter" placeholder="商品参数"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <{if $row && $row['g_parameter']}><{$row['g_parameter']}><{/if}>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_parameter" data-readonly="1"/>
                                                            </div>
                                                </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>简介详情</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <div class="control-group" style="margin-left: 70px;">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" disabled="disabled" name="g_brief" placeholder="商品简介" style="max-width: 850px;"><{if $row}><{$row['g_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="control-group" style="margin-left: 70px;">
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="商品详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <{if $row && $row['g_detail']}><{$row['g_detail']}><{/if}>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" data-readonly="1"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <hr />
                                <div class="row-fluid wizard-actions" style="text-align: center;">
                                    <{if $row}>
                                    <button class="btn btn-primary" ng-click="saveData()">
                                        导入商品
                                    </button>
                                    <{/if}>
                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<{include file="../img-upload-modal.tpl"}>

<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.spec = <{$spec}>;
        console.log($scope.spec);
        $scope.dataList=<{$dataList}>;
        console.log($scope.dataList);
        $scope.rowspan = [];
        $scope.addSpec = function(){
            var data = {
                'name': '颜色',
                'value': []
            };
            $scope.spec.push(data);
        };
        $scope.addSpecValue = function(index){
            var data = {
                'name':'规格值',
                'img' : '/public/manage/img/zhanwei/zw_fxb_45_45.png'
            };
            if(index>0 &&$scope.spec[(index - 1)].value.length==0){
                layer.msg('请先添加上级规格值')
            }else{
                $scope.spec[index].value.push(data);
            }
        };

        //监听sb变量的变化，并在变化时更新DOM
        $scope.$watch('spec',function(n,o){
            var n = 0;
            if($scope.spec.length==0){
                $scope.dataList = [];
                $scope.rowspan = [];
            }

            if(($scope.spec.length==1)||($scope.spec.length==2&&$scope.spec[1].value.length==0)){
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    $scope.dataList[n] = {
                        'spec': [$scope.spec[0].value[i]],
                        'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                        'stock': $scope.dataList[n]?$scope.dataList[n].stock:0
                    }
                    n++;
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [1];
            }
            if(($scope.spec.length==2 && $scope.spec[1].value.length>0)||($scope.spec.length==3&&$scope.spec[2].value.length==0)){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        $scope.dataList[n] = {
                            'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j]],
                            'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                            'stock': $scope.dataList[n]?$scope.dataList[n].stock:0
                        }
                        n++
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length>0?$scope.spec[1].value.length:1, 1];
            }
            if($scope.spec.length==3 && $scope.spec[2].value.length>0){
                var n = 0;
                for(var i=0;i<$scope.spec[0].value.length;i++){
                    for(var j=0;j<$scope.spec[1].value.length;j++){
                        for(var k=0;k<$scope.spec[2].value.length;k++){
                            $scope.dataList[n] = {
                                'spec': [$scope.spec[0].value[i],$scope.spec[1].value[j],$scope.spec[2].value[k]],
                                'price': $scope.dataList[n]?$scope.dataList[n].price:0,
                                'stock': $scope.dataList[n]?$scope.dataList[n].stock:0
                            }
                            n++;
                        }
                    }
                }
                if($scope.dataList.length>n){
                    $scope.dataList.splice(n, $scope.dataList.length - n)
                }
                $scope.rowspan = [$scope.spec[1].value.length*($scope.spec[2].value.length>0?$scope.spec[2].value.length:1), $scope.spec[2].value.length>0?$scope.spec[2].value.length:1, 1];
            }
            console.log($scope.dataList);
            console.log($scope.rowspan);
        },true);

        $scope.doThis=function(type,findex,index){
            $scope[type][findex].value[index].img = imgNowsrc;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index){
            console.log(index);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type].splice(index,1);
                });
                layer.msg('删除成功');
            })
        }

        /*删除规格值元素*/
        $scope.delValueIndex=function(type,value,sindex){
            var index=0
            for(var i=0; i<$scope[type].length; i++){
                if($scope[type][i].value == value){
                    index = i;
                }
            }
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                $scope.$apply(function(){
                    $scope[type][index].value.splice(sindex,1);
                    if($scope[type][index].value.length<1){
                        $scope[type].splice(index,1);
                    }
                });
                layer.msg('删除成功');
            })
        }


        // 保存数据
        $scope.saveData = function(){
            var load_index = layer.load(
                    2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/goods/allCommon2Shop',
                'data'  : {ids: <{$row['g_id']}>},
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    if(ret.ec==200){
                        window.location.href = "/wxapp/goods/newAdd/?id="+ret['id']
                    }
                }
            });
        };

        jQuery(function($) {
            $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
                console.log(info.step);
                /*  去掉商品类目不再做验证*/
                /*
                 if(info.step == 1 && info.direction == 'next') {
                 if(!checkCategory()) return false;
                 }else
                 */
                if(info.step == 1 && info.direction == 'next'){
                    if(!checkBasic()) return false;
                }else if(info.step == 2 && info.direction == 'next'){
                    if(!checkImg()) return false;
                }
            }).on('finished', function(e) {
                //saveGoods('step');
                $scope.saveData();
            });

            $('.product-leibie').on('click', 'li', function(event) {
                $(this).addClass('selected').siblings('li').removeClass('selected');
                var id = $(this).data('id');
                $('#g_c_id').val(id);
            });
            formatSort();
            //获取自定义商品分类
            var kind = 0 ;
            <{if $row && $row['g_kind2']}>
            kind = <{$row['g_kind2']}>;
            <{/if}>
            customerGoodsCategory(kind);

            // 初始化库存是否可输入
            var panelLen = parseInt($("#panel-group").find('.panel').length);
            if(panelLen>0){
                $("#g_stock").attr("readonly",true);
            }
            // 统计商品规格所有库存
            $("#panel-group").on('input propertychange', 'input[name^="format_stock"]', function(event) {
                event.preventDefault();
                var that = $(this);
                var parElem = that.parents('#panel-group');
                var sumStock = 0;
                parElem.find('input[name^="format_stock"]').each(function(index, el) {
                    sumStock += parseInt($(this).val());
                });
                $("#g_stock").val(sumStock);
            });
            // 商品标签选择
            $(".goods-tagbox").on('click', 'span', function(event) {
                event.preventDefault();
                var _this = $(this);
                $(this).toggleClass('active');
                $(this).parents('.goods-tagbox').find('span').each(function(index, el) {
                    var id = $(this).data('id');
                    if($(this).hasClass('active')){
                        $("#good_tag_"+id).val(1);
                    }else{
                        $("#good_tag_"+id).val(0);
                    }
                });
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

    function formatSort(){
        $("#panel-group").sortable({
            update: function( event, ui ) {
                sortString();
            }
        });
    }
    function sortString(){
        var sortString="";
        $('#panel-group').find(".panel").each(function(){
            var sortid = $(this).data("sort");
            sortString +=sortid+",";
        });
        $("#format-sort").val(sortString);
        console.log(sortString);
    }
</script>

