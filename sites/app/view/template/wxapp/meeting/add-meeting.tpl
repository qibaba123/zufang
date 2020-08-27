<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
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
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['am_id']}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <div class="row">
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
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>会议标签</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="label" name="label" placeholder="请填写会议标签，多个标签之间以、隔开" required="required" value="<{if $row}><{$row['am_label']}><{/if}>">
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
                                                <input type="text" class="form-control" id="start_time" name="start_time" onclick="chooseDate()" required="required" placeholder="请填写会议时间" value="<{if $row && $row['am_start_time']}><{date('Y-m-d',$row['am_start_time'])}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>报名截止时间</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="end_time" name="end_time" onclick="chooseDate()" required="required" placeholder="请填写会议报名截止时间" value="<{if $row && $row['am_end_time']}><{date('Y-m-d',$row['am_end_time'])}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>会议图片</label>
                                            </div>
                                            <div style="padding: 10px;margin-left: 187px;">
                                                <div id="slide-img" class="pic-box" style="display:inline-block">
                                                    <{foreach $slide as $key=>$val}>
                                                    <p>
                                                        <img class="img-thumbnail col" layer-src="<{$val['ams_cover']}>"  layer-pid="" src="<{$val['ams_cover']}>" >
                                                        <span class="delimg-btn">×</span>
                                                        <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['ams_cover']}>">
                                                        <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['ams_id']}>">
                                                    </p>
                                                    <{/foreach}>
                                                </div>
                                                <span onclick="toUpload(this)" data-limit="5" data-width="750" data-height="400" data-dom-id="slide-img" class="btn btn-success btn-xs">添加会议图片</span>
                                                <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>会议详情</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:200px;visibility:hidden;" id = "content" name="content" placeholder="会议详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                    <{if $row && $row['am_content']}><{$row['am_content']}><{/if}>
                                                </textarea>
                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                <input type="hidden" name="ke_textarea_name" value="content" />
                                            </div>


                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
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

                                        <div class="space-8"></div>

                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="form-group col-sm-2 text-right">
                                                    <label for="price"><font color="red">*</font>留言</label>
                                                </div>
                                                <div class="group-info">
                                                    <div class="form-group">
                                                        <div>
                                                            <div class="panel-group" id="panel-group">
                                                                <div class="panel" style="max-width: 100%;width: 100%" ng-repeat="message in messageList track by $index">
                                                                    <div class="panel-collapse">
                                                                        <a href="javascript:;" class="close" ng-click="delIndex('messageList',$index)">×</a>
                                                                        <div class="panel-body" style="padding: 15px">
                                                                            <div class="col-xs-4">
                                                                                <div class="input-group" style="width: 100%">
                                                                                    <input type="text"  maxlength="5" style="width: 100%;max-width: 100%"  class="form-control" ng-model="message.name">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xs-4">
                                                                                <div class="input-group" style="width: 100%">
                                                                                    <select class="form-control" ng-model="message.type" style="width: 100%;max-width: 100%"   ng-options="x.type as x.name for x in messageType" ></select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-xs-4">
                                                                                <div class="input-group">
                                                                                    <label for=""  style="padding: 6px 3px">
                                                                                        <input type="checkbox" name="require" ng-model="message.require"  ng-checked="message.require"> 必填
                                                                                    </label>
                                                                                    <label for=""  style="padding: 6px 3px" ng-if="message.type=='text'">
                                                                                        <input type="checkbox" name="date" ng-model="message.multi"  ng-checked="message.multi"> 多行
                                                                                    </label>
                                                                                    <label for=""  style="padding: 6px 3px" ng-if="message.type=='time'">
                                                                                        <input type="checkbox" name="date" ng-model="message.date"  ng-checked="message.date"> 日期
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="javascript:;" class="ui-btn" ng-click="addMessage()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加字段</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-8"></div>

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
<script type="text/javascript">
    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl', ['$scope','$http','$timeout',function($scope, $http, $timeout){
        $scope.messageList = <{$messageList}>;
        console.log($scope.messageList);
        $scope.messageType = [
            {
                'type': 'text',
                'name': '文本格式'
            },
            {
                'type': 'number',
                'name': '数字格式'
            },
            {
                'type': 'email',
                'name': '邮箱'
            },
            {
                'type': 'date',
                'name': '日期'
            },
            {
                'type': 'time',
                'name': '时间'
            },
            {
                'type': 'idcard',
                'name': '身份证号'
            },
            {
                'type': 'image',
                'name': '图片'
            },
            {
                'type': 'mobile',
                'name': '手机号'
            }
        ];
        $scope.addMessage = function () {
            var data = {
                'name': '留言',
                'type': 'text',
                'multi': false,
                'require': false,
                'date' : false
            };
            $scope.messageList.push(data);
            console.log($scope.messageList);
        }

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
                'url'   : '/wxapp/meeting/save',
                'data'  : $('#property-form').serialize()+'&messageList='+JSON.stringify($scope.messageList),
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(load_index);
                    layer.msg(ret.em);
                    window.location.reload();
                }
            });
        };
    }]);
    $(function(){
        /*选择接待开始时间*/
        $('#open_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择接待结束时间*/
        $('#close_time').timepicker({
            minuteStep: 1,
            showSeconds: false,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
        /*选择周几*/
        $(".week-choose").on('click', 'span', function(event) {
            $(this).toggleClass('active');
        });

        //初始化省、市、区
        var id = $('#hid_id').val();
        if(id){
            initWxappRegion(1,'province','<{$row['am_province']}>');
            initWxappRegion('<{$row['am_province']}>','city','<{$row['am_city']}>');
            initWxappRegion('<{$row['am_city']}>','zone','<{$row['am_zone']}>');
        }else{
            initWxappRegion(1,'province');
        }
        //$("#province").find("option[text='河南']").attr("selected",true);
        $('#province option[text="河南"]').attr("selected", true);
        console.log($("#province").find("option[text='河南']"));
        //高德地图引入
        var marker, geocoder,map = new AMap.Map('container',{
            zoom            : 10,
            keyboardEnable  : true,
            resizeEnable    : true,
            topWhenClick    : true
        });
        //添加地图控件
        AMap.plugin(['AMap.ToolBar'],function(){
            var toolBar = new AMap.ToolBar();
            map.addControl(toolBar);
        });

        //地图添加点击事件
        map.on('click', function(e) {
            $('#lng').val(e.lnglat.getLng());
            $('#lat').val(e.lnglat.getLat());
            //添加地图服务
            AMap.service('AMap.Geocoder',function(){
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    city: "010"//城市，默认：“全国”
                });
                //TODO: 使用geocoder 对象完成相关功能
                //逆地理编码
                var lnglatXY=[e.lnglat.getLng(), e.lnglat.getLat()];//地图上所标点的坐标
                geocoder.getAddress(lnglatXY, function(status, result) {
                    console.log(result);
                    if (status === 'complete' && result.info === 'OK') {
                        addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);

                        //详细地址处理
                        var pcz  = {
                            'province'  : result.regeocode.addressComponent.province,
                            'city'      : result.regeocode.addressComponent.city,
                            'zone'      : result.regeocode.addressComponent.district
                        };
                        initRegionByName(pcz);
                        var township    =  result.regeocode.addressComponent.township;
                        var street      =  result.regeocode.addressComponent.street;
                        var streetNumber=  result.regeocode.addressComponent.streetNumber;
                        var neighborhood=  result.regeocode.addressComponent.neighborhood;
                        var adds = township + street + streetNumber + neighborhood;
                        $('#address').val(adds);
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var province = $('#province').find('option:selected').text();
            var city     = $('#city').find('option:selected').text();
            var zone     = $('#zone').find('option:selected').text();
            var addr     = $('#address').val();
            if(province && city && zone && addr){
                var address = city + '市' + zone + addr;
                console.log(address);
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : city, //城市，默认：“全国”
                        'radius' : 1000   //范围，默认：500
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //地理编码,返回地理编码结果
                    geocoder.getLocation(address, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
                            var loc_lng_lat = result.geocodes[0].location;
                            $('#lng').val(loc_lng_lat.getLng());
                            $('#lat').val(loc_lng_lat.getLat());
                            addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),result.geocodes[0].formattedAddress);
                        }else{
                            layer.msg('您输入的地址无法找到，请确认后再次输入');
                        }
                    });
                });

            }else{
                layer.msg('请填详细地址');
            }
        });


        /**
         * 添加一个标签和一个结构体
         * @param lng
         * @param lat
         * @param address
         */
        function addMarker(lng,lat,address) {
            if (marker) {
                marker.setMap();
            }
            marker = new AMap.Marker({
                icon    : "https://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
                position: [lng,lat]
            });
            marker.setMap(map);

            infoWindow = new AMap.InfoWindow({
                offset  : new AMap.Pixel(0,-30),
                content : '您选中的位置：'+address
            });
            infoWindow.open(map, [lng,lat]);
        }

    });
    function saveProperty(){
        /*var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/meeting/save',
            'data'  : $('#property-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    window.location.href='/wxapp/meeting/meetingList';
                }else{
                    layer.msg(ret.em);
                }
            }
        });*/
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
</script>


