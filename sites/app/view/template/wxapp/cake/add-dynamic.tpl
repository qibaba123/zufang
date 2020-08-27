<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style type="text/css">
    #default-onoff input[name=is_default].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是 \a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }
    #default-onoff input[type=checkbox].ace.ace-switch{
        margin:0;
        width: 60px;
        height: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        line-height: 30px;
        height: 31px;
        width: 60px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after{
        left: 30px;
    }
    #default-onoff input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after,#default-onoff input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 29px;
        height: 29px;
        line-height: 29px;
    }
    #container {
        width:100%;
        height: 300px;
    }
    .marker-route{
        width: 120px;
        height: 50px;
        background-color: #fff;
        font-size: 14px;
    }
    .week-choose{
        font-size: 0;
    }
    .week-choose span{
        display: inline-block;
        width: 13%;
        margin:0 0.64%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #E2E2E2;
        font-size: 12px;
        text-align: center;
        color: #777;
        line-height: 34px;
        cursor: pointer;
        max-width: 50px;
    }
    .week-choose span.active{
        border-color: #3DC018;
        position: relative;
    }
    .week-choose span.active:before{
        position: absolute;
        content: '';
        top:0;
        right: 0;
        z-index: 1;
        background: url(/public/manage/images/active.png) no-repeat;
        background-size: 14px;
        background-position: top right;
        width: 14px;
        height: 14px;
    }

    .panel-body{
        padding: 0;
    }

    .control-group{
        margin-left: 18%;
    }

    .panel{
        max-width: 300px;
        float: left;
    }

    .close {
        font-size: 30px;
        line-height: 50px;
        margin: 0 10px;
    }

    .panel-group .panel+.panel {
        margin-top: 0;
    }

    .placeholder{
        position: absolute;
        right: 25px;
        top: 5px;
        color: #a6a6a6;
    }
    .goods-list-row{

    }
</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div  ng-app="chApp" ng-controller="chCtrl">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="property-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['asd_id']}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <!--<div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>会议封面图</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <img onclick="toUpload(this)" data-limit="1" data-width="360" data-height="240" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['am_cover']}><{$row['am_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                                                <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['am_cover']}><{$row['am_cover']}><{/if}>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="360" data-height="240" data-dom-id="upload-cover">修改</a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>会议名称</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写会议名称" required="required" value="<{if $row}><{$row['am_title']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>门票价格区间</label>
                                            </div>
                                            <div class="form-group col-sm-4" style="position: relative;">
                                                <input type="text" class="form-control" id="price" name="price" placeholder="例如 100~800" required="required" value="<{if $row}><{$row['am_price_range']}><{/if}>">
                                                <label class="placeholder">元</label>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>会议时间</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="start_time" name="start_time" onclick="chooseDate()" required="required" placeholder="请填写会议时间" value="<{if $row}><{date('Y-m-d',$row['am_start_time'])}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>-->

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>动态标签</label>
                                            </div>
                                            <div class="form-group " style="margin-left: 10px">
                                                <input type="text" style="display: inline-block;float: left;width: 30%;margin-right: 10px" maxlength="4" class="form-control" id="sign1" name="sign1" placeholder="请填写动态标签" required="required" value="<{if $row}><{$row['asd_sign1']}><{/if}>">
                                                <input type="text" style="display: inline-block;float: left;width: 30%;margin-right: 10px" maxlength="4" class="form-control" id="sign2" name="sign2" placeholder="请填写动态标签" required="required" value="<{if $row}><{$row['asd_sign2']}><{/if}>">
                                                <input type="text" style="display: inline-block;float: left;width: 30%;" maxlength="4" class="form-control" id="sign3" name="sign3" placeholder="请填写动态标签" required="required" value="<{if $row}><{$row['asd_sign3']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>动态描述</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:200px;" id = "content" name="content" placeholder="动态描述"  rows="20" style=" text-align: left;" ><{if $row && $row['asd_detail']}><{$row['asd_detail']}><{/if}></textarea>
                                                <!--<input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                <input type="hidden" name="ke_textarea_name" value="content" />-->
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">链接商品</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                    <button class="btn btn-xs btn-primary" ng-click="addNewGoodsList()">添加链接商品</button>
                                            </div>
                                        </div>
                                        <div class="row" ng-repeat="good in goodsList" ng-show="goodsList.length>0">
                                            <div class="form-group col-sm-2 text-right">

                                            </div>
                                            <div class="form-group col-sm-5">
                                                <select class="form-control selectpicker chosen-select" name="goodsSelect{{good.index}}" id="" ng-model="good.id" ng-options="x.id as x.name for x in goods">
                                                </select>
                                            </div>
                                            <!--
                                            <div class="form-group col-sm-2">
                                                权重：<input type="text" ng-model="good.weight" class="form-control" style="display: inline-block;width: 70%">
                                            </div>
                                            -->
                                            <div class="form-group col-sm-2" style="padding-left: 50px">
                                                <button class="btn btn-xs btn-pirmary" ng-click="delIndex('goodsList',good.index)">删除</button>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>视频链接</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea rows="3" id="videoUrl" name="videoUrl" class="form-control" placeholder="请填写视频链接"><{if $row && $row['asd_video_url']}><{$row['asd_video_url']}><{/if}></textarea>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>视频封面</label>
                                            </div>
                                            <!--<label for="">视频封面<span class="img-tips">（图片建议尺寸500px*400px）</span></label>-->
                                            <div class="cropper-box" data-width="500" data-height="400" >
                                                <img style="width: 20% !important;" src="<{if $row && $row['asd_video_cover']}><{$row['asd_video_cover']}><{else}>/public/manage/img/zhanwei/zw_555_480.png<{/if}>" onload="" />
                                                <input type="hidden" id="video_cover" name="video_cover" value="" />
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>动态图片</label>
                                            </div>
                                            <div style="padding: 10px;margin-left: 187px;">
                                                <div id="slide-img" class="pic-box" style="display:inline-block">
                                                    <{foreach $slide as $key=>$val}>
                                                    <p>
                                                        <img class="img-thumbnail col" layer-src="<{$val['ads_cover']}>"  layer-pid="" src="<{$val['ads_cover']}>" >
                                                        <span class="delimg-btn">×</span>
                                                        <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['ads_cover']}>">
                                                        <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['ads_id']}>">
                                                    </p>
                                                    <{/foreach}>
                                                </div>
                                                <span onclick="toUpload(this)" data-limit="5" data-width="400" data-height="400" data-dom-id="slide-img" class="btn btn-success btn-xs">添加动态图片</span>
                                                <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>
                                        <!--<div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>会议地点</label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <select class="form-control" id="province" name="province" onchange="changeWxappProvince()" placeholder="请选择省会">
                                                    <option value="">选择省会</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <select class="form-control" id="city" name="city" onchange="changeWxappCity()" placeholder="请选择城市">
                                                    <option value="">选择城市</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <select class="form-control" id="zone" name="zone" placeholder="请选择地区">
                                                    <option value="">选择地区</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>


                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>详细地址</label>
                                            </div>
                                            <div class="control-group" style="float: left;width: 63%;margin-left: 12px;">
                                                <input type="text" class="form-control" id="address" name="address" style="width: 88%;display: inline-block;" placeholder="请填写具体地址" value="<{if $row}><{$row['am_address']}><{/if}>">
                                            </div>
                                            <div class="form-group col-sm-2 text-left">
                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注会议地址" value="<{if $row}><{$row['am_lng']}><{/if}>">
                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注会议地址" value="<{if $row}><{$row['am_lat']}><{/if}>">
                                                <label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>地图定位</label>
                                            </div>
                                            <div class="form-group col-sm-9">
                                                <div id="container"></div>
                                            </div>

                                        </div>

                                        <div class="space-8"></div>-->

                                        <div class="form-group col-sm-12" style="text-align:center">
                                            <span type="button" class="btn btn-primary btn-sm btn-save " ng-click="saveData()"> 保 存 </span>
                                        </div>
                                        <div class="space-8"></div>
                                    </div>
                                </form>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope,$http,$timeout){
        $scope.goodsList      = <{$goodsList}>;
        //$scope.goodsList      = [];
        console.log($scope.goodsList);
        $scope.goods      = <{$goods}>;
        console.log($scope.goods);
        /*添加分类导航方法*/
        $scope.addNewGoodsList = function(){
            var goodsList_length = $scope.goodsList.length;
            var defaultIndex = 0;
            if(goodsList_length>0){
                for (var i=0;i<goodsList_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.goodsList[i].index)){
                        defaultIndex = $scope.goodsList[i].index;
                    }
                }
                defaultIndex++;
            }
            if(goodsList_length>=3){
                layer.open({
                    type: 1,
                    title: false,
                    shade:0,
                    skin: 'layui-layer-error',
                    closeBtn: 0,
                    shift: 5,
                    content: '最多只能添加3个商品链接',
                    time: 2000
                });
            }else{
                var goodsList_Default = {
                    index: defaultIndex,
                    id : $scope.goods[0] ?$scope.goods[0].id:'',
                    weight : 0
                };
                $scope.goodsList.push(goodsList_Default);
                $timeout(function(){
                    addInitChosen();
                },300);
            }
            console.log($scope.goodsList);
        }

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
        $scope.delIndex=function(type,index){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            console.log(type+"-->"+realIndex);
            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                //if($scope[type].length>1){
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                    layer.msg('删除成功');
                //}else{
                //    layer.msg('最少要留一个哦');
                //}
            });
        };
        $scope.doThis=function(type,index){
            var realIndex=-1;
            /*获取图片的真正索引*/
            realIndex = $scope.getRealIndex($scope[type],index);
            $scope[type][realIndex].imgsrc = imgNowsrc;
        };

        $(function(){
            addInitChosen();
        });

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
                'url'   : '/wxapp/cake/saveStoreDynamic',
                'data'  : $('#property-form').serialize()+'&goodsList='+JSON.stringify($scope.goodsList),
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    if(ret.ec == 200){
                        layer.msg(ret.em);
                        window.location.href='/wxapp/cake/dynamicList';
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        };
    }]);
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

    var nowdate = new Date();
    var year = nowdate.getFullYear(),
            month = nowdate.getMonth()+1,
            date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd'
        });
    }
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        var maxNum=4;
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#cover').val(allSrc[0]);
                }
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
                    $('#'+nowId).prepend(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    /*
    初始化chosen-select
     */
    function addInitChosen() {
        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            placeholder_text_single : '请选择'
        });
    }
</script>


