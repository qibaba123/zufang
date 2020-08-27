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
    .wizard-actions{
        text-align: center;
    }

</style>

<{include file="../../manage/common-kind-editor.tpl"}>
<{include file="../common-second-menu.tpl"}>
<div ng-app="chApp" ng-controller="chCtrl" style="margin-left: 130px">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/group/goodsList"> 返回 </a></small> | 新增/编辑课程信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['g_id']}><{else}>0<{/if}>">
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>课程名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_name" name="g_name" placeholder="请填写课程名称" required="required" value="<{if $row}><{$row['g_name']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">课程原价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_ori_price" name="g_ori_price" placeholder="原价" required="required" value="<{if $row}><{$row['g_ori_price']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>课程售价：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_price" name="g_price" onblur="mathVIp()" placeholder="请填写课程售价"  value="<{if $row}><{$row['g_price']}><{/if}>"  style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>仅VIP购买：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input name="g_vip_buy" class="ace ace-switch ace-switch-5" id="g_vip_buy" <{if $row && $row['g_vip_buy']}>checked<{/if}> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>-->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>课程信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label">报名人数：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_sold" name="g_sold" placeholder="请填写报名人数" required="required" value="<{if $row}><{$row['g_sold']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="kind2" class="control-label">课程分类：</label>
                                                            <div class="control-group" id="customCategory">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>名额</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>课程名额：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="g_stock" name="g_stock" placeholder="课程名额数量" required="required" value="<{if $row}><{$row['g_stock']}><{/if}>"  style="width:160px;">

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>名额显示：</label>
                                                            <div class="control-group">
                                                                <label style="padding: 4px 0;margin: 0;">
                                                                    <input class="ace ace-switch ace-switch-5" name="g_stock_show" id="g_stock_show" <{if $row && $row['g_stock_show']}>checked<{/if}> type="checkbox">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner" >
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info" style="padding-left: 100px">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">课程封面图(<small style="font-size: 12px;color:#999">建议尺寸：640 x 640 像素</small>)</h3>
                                                            <div>
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover" id="upload-g_cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                                <input type="hidden" id="g_cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-g_cover">修改</a>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">课程幻灯图(<small>最多五张，尺寸 640 x 640 像素</small>)</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['gs_path']}>"  layer-pid="" src="<{$val['gs_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['gs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['gs_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
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
                                                            <label class="control-label">课程简介：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" id="g_brief" name="g_brief" placeholder="课程简介" style="max-width: 850px;"><{if $row}><{$row['g_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">课程详情：</label>
                                                            <div class="control-group">
                                                                <textarea class="form-control" style="width:850px;height:500px;visibility:hidden;" id = "g_detail" name="g_detail" placeholder="课程详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                <{if $row && $row['g_detail']}><{$row['g_detail']}><{/if}>
                                                                </textarea>
                                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                                <input type="hidden" name="ke_textarea_name" value="g_detail" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="row-fluid wizard-actions">
                                    <button class="btn btn-primary" ng-click="saveData()">
                                        保存
                                    </button>
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
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.spec = [];
        console.log($scope.spec);
        $scope.dataList=[];
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
           console.log($('#goods-form').serialize());
            console.log(JSON.stringify($scope.spec));
            console.log(JSON.stringify($scope.dataList));
            checkBasic();
            checkImg();
            var load_index = layer.load(
                    2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/goods/newSave',
                'data'  : $('#goods-form').serialize()+'&formatType='+JSON.stringify($scope.spec)+'&formatList='+JSON.stringify($scope.dataList),
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
//                    window.location.reload();
                }
            });
        };

        jQuery(function($) {
            $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
                console.log(info.step);
                /*  去掉课程类目不再做验证*/
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
            //获取自定义课程分类
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
            // 统计课程规格所有库存
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
            // 课程标签选择
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

    /**
     * 第一步检查课程类目
     * */
    function checkCategory(){
        var temp = $('#g_c_id').val();
        if(!temp){
            var msg = $('#g_c_id').attr('placeholder');
            layer.msg(msg);
            return false;
        }
        return true;
    }

    /**
     * 第二步检查基本信息
     * */
    function checkBasic(){
        var format = $('#format-num').val();
        var check   = new Array('g_name','g_price','g_stock');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp && format == 0){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        var discount = $('#g_vip_discount').val();
        if(discount > 100 || discount < 1){
            layer.msg('VIP折扣1－100之间整数');
            return false
        }
        return true;
    }

    /**
     * 第三步，检查图片
     * @returns {boolean}
     */
    function checkImg(){
        var g_cover = $('#g_cover').val();
        if(!g_cover){
            layer.msg('请上传封面图');
            return false;
        }
        var slide = 0;
        for(var i=0;i<=4;i++){
            var temp = $('#slide_'+i).val();
            if(temp) {
                slide = parseInt(slide) + 1;
                console.log(slide);
            }
        }
        if(slide == 0){
            layer.msg('请上传幻灯');
            return false;
        }
        return true;
    }

    /**
     * 保存课程信息
     */
//    /*function saveGoods(type){
//        var load_index = layer.load(
//                2,
//                {
//                    shade: [0.1,'#333'],
//                    time: 10*1000
//                }
//        );
//        $.ajax({
//            'type'   : 'post',
//            'url'   : '/wxapp/goods/save',
//            'data'  : $('#goods-form').serialize(),
//            'dataType'  : 'json',
//            'success'   : function(ret){
//                layer.close(load_index);
//                if(ret.ec == 200 && type == 'step'){
//                    window.location.href='/wxapp/goods/index';
//                }else{
//                    layer.msg(ret.em);
//                }
//            }
//        });
//    }*/
    /**
     * 图片结果处理
     * @param allSrc
     */
   function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).append(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }
    /**
     * 图片删除功能
     * 以图片容器为准，容器中的图片img标签结果<div><p><img>
     */
//    $(".pic-box").on('click', '.delimg-btn', function(event) {
//        var id = $(this).parent().parent().attr('id');
//        event.preventDefault();
//        event.stopPropagation();
//        var delElem = $(this).parent();
//        layer.confirm('确定要删除吗？', {
//            title:false,
//            closeBtn:0,
//            btn: ['确定','取消'] //按钮
//        }, function(){
//            delElem.remove();
//            var num = parseInt($('#'+id+'-num').val());
//            console.log(num);
//            console.log(id);
//            if(num > 0){
//                $('#'+id+'-num').val(parseInt(num) - 1);
//            }
//            layer.msg('删除成功');
//        });
//    });

    $('.math-vip').blur(function(){
        var discount = $(this).val();
    });


    /*移除规格*/
    function removeGuige(elem){
        var panelBox = $(elem).parents(".panel");
        panelBox.remove();
        var panelNum = $('#format-num').val();
        var is_old   = $(elem).data('hid-id');
        if(is_old == 0){ //删除数据库存在的，则不递减
            panelNum -- ; //递减
        }
        var panel = $("#panel-group .panel").length;
        if(panel == 0){
            $("#g_price").attr("readonly",false);
            $("#g_stock").attr("readonly",false);
        }else{
            $("#g_price").attr("readonly",true);
            $("#g_stock").attr("readonly",true);
        }
        $('#format-num').val(panelNum);
    }
    /*添加规格*/
    function addGuige(){
        //var id = $("#panel-group .panel").length+1;
        // $("#panel-template .guige").text("规格#"+id);
        //$("#panel-template input.guigeName").attr("value","规格#"+id);
        var key  = parseInt($('#format-num').val());
        key ++;
        var html = get_format_html(key);//$("#panel-template").html();
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly",true);
        $("#g_stock").attr("readonly",true);
        formatSort();
        sortString();
    }

    function get_format_html(key){
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="removeGuige(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>名称</label>';
        _html       += '<input type="text" class="form-control guigeName" name="format_name_'+key+'"  value="规格#'+key+'">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>价格</label>';
        _html       += '<input type="text" class="form-control"  data-key="'+key+'" onblur="toMathVIp( this )"  name="format_price_'+key+'" value="">';
        _html       += '</div></div>';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>库存</label>';
        _html       += '<input type="text" class="form-control"  name="format_stock_'+key+'"  value="">';
        _html       += '</div></div>';

        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }



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

