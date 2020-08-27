<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
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
</style>
<{include file="../common-second-menu-new.tpl"}>
<{include file="../article-kind-editor.tpl"}>
<div id="mainContent" ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="javascript:history.go(-1);" >返回</a></small> | 查看/编辑店铺信息</h4>

                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['ams_id']}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <div class="row" style="margin-bottom: 10px">

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺logo图<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10" >
                                                <img onclick="toUpload(this)" data-limit="1" data-width="150" data-height="150"  data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['ams_logo']}><{$row['ams_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin-left:0; width: 150px;height: 150px;">
                                                <input type="hidden" id="logo" placeholder="请上店铺logo"  required="required" class="avatar-field bg-img" name="logo" value="<{if $row && $row['ams_logo']}><{$row['ams_logo']}><{/if}>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="150" data-height="150" data-dom-id="upload-logo">修改</a>
                                            </div>

                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for=""><font color="red">*</font>店铺分类</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <select id="category"  class="form-control" required="required">
                                                    <{if $category_select}>
                                                        <{foreach $category_select as $val}>
                                                         <option value="<{$val['amc_id']}>" <{if $row && $row['ams_cate_id'] eq $val['amc_id']}>selected="selected"<{/if}> ><{$val['amc_title']}></option>
                                                        <{/foreach}>
                                                    <{/if}>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>门店名称</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写门店名称" required="required" value="<{if $row}><{$row['ams_name']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">是否推荐</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <div class="radio-box">
                                                <span>
                                                    <input type="radio" name="istop" id="istop_1" value="1" <{if $row['ams_top'] eq 1}>checked<{/if}>>
                                                    <label for="istop_1">是</label>
                                                </span>
                                                    <span>
                                                    <input type="radio" name="istop" id="istop_0" value="0" <{if $row['ams_top'] neq 1}>checked<{/if}>>
                                                    <label for="istop_0">否</label>
                                                </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>
                                        <{if $row['ams_id']}>
                                         <input type="hidden" id="date" name="date" value="0">
                                        <{else}>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>入驻时长</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <select name="date" id="date" placeholder="请填选择入驻时长" required="required" class="form-control">
                                                    <{foreach $costList as $val}>
                                                    <option value="<{$val['mac_data']}>"><{$val['mac_data']}>个月</option>
                                                    <{/foreach}>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <{/if}>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>详细地址</label>
                                            </div>

                                            <div class="form-group col-sm-8">
                                                <input type="text" class="form-control" id="addr" name="addr" required="required" placeholder="请填写详细地址" value="<{if $row}><{$row['ams_address']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-left">
                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['ams_lng']}><{/if}>">
                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['ams_lat']}><{/if}>">
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

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">门牌号</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="addr_detail" name="addr_detail" placeholder="请填写门牌号" value="<{if $row}><{$row['ams_addr_detail']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>联系电话</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" required="required" class="form-control" id="mobile" name="mobile" placeholder="请填写联系电话" value="<{if $row}><{$row['ams_mobile']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                         <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">联系人</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="请填写联系人" value="<{if $row}><{$row['ams_contacts']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">微信号</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="wxcode" name="wxcode" placeholder="请填写微信号" value="<{if $row}><{$row['ams_wxcode']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">链接类型</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <div class="radio-box">
                                                <span>
                                                    <input type="radio" name="video_type" id="type_1" value="1" <{if $row['ams_video_type'] neq 2}>checked<{/if}>>
                                                    <label for="type_1">视频</label>
                                                </span>
                                                <span>
                                                    <input type="radio" name="video_type" id="type_2" value="2" <{if $row['ams_video_type'] eq 2}>checked<{/if}>>
                                                    <label for="type_2">音频</label>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">音/视频链接</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="video_url" name="video_url" placeholder="请填写链接" value="<{if $row}><{$row['ams_video_url']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">营业时间</label>
                                            </div>
                                            <div class="form-group col-sm-4" style="padding:0">
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="open_time" name="open_time" placeholder="起始营业时间" value="<{if $row}><{$row['ams_open_time']}><{else}>08:30<{/if}>">
                                                </div>
                                                <span class="col-xs-2 text-center" style="line-height:34px">~</span>
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="close_time" name="close_time" placeholder="结束营业时间" value="<{if $row}><{$row['ams_close_time']}><{else}>17:30<{/if}>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">主营类目</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:200px;" id = "management" name="management" maxlength="500" placeholder="请描述主营类目，不超过500字"  rows="10" style=" text-align: left; resize:vertical;"><{$row['ams_management']}></textarea>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺详情</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:300px;" id = "content" name="content" placeholder="请填写店铺详情"  rows="10" style=" text-align: left; resize:vertical;" ><{$row['ams_content']}></textarea>
                                            </div>
                                        </div>
                                        <div class="space-8"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">详情图片</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                               <!--<h3 class="lighter block green">店铺详情图(<small>最多三张</small>)</h3>-->
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $imgs as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val}>"  layer-pid="" src="<{$val}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$key}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="5" data-width="750" data-height="1334" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $imgs}><{count($imgs)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                            </div>
                                        </div>

                                        <div class="space-8"></div>
                                        <div class="form-group col-sm-12" style="text-align:center">
                                            <span type="button" class="btn btn-primary btn-sm btn-save "> 保 存 </span>
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
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    var latitude = '<{$row['ams_lat']}>'?'<{$row['ams_lat']}>':'34.77485';
    var longitude = '<{$row['ams_lng']}>'?'<{$row['ams_lng']}>':'113.72052';
    var storeAddress = '<{$row['ams_address']}>'?'<{$row['ams_address']}>':'公司地址';
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
        //if(id){
        //    initWxappRegion(1,'province','<{$row['ams_province']}>');
        //    initWxappRegion('<{$row['ams_province']}>','city','<{$row['ams_city']}>');
        //   initWxappRegion('<{$row['ams_city']}>','zone','<{$row['ams_zone']}>');
        //}else{
        //    initWxappRegion(1,'province');
        //}
        //$("#province").find("option[text='河南']").attr("selected",true);
        $('#province option[text="河南"]').attr("selected", true);
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
        //首次进入默认选择位置
        addMarker(longitude,latitude,storeAddress);
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
                    if (status === 'complete' && result.info === 'OK') {
                        addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);

                        //详细地址处理
                        var pcz  = {
                            'province'  : result.regeocode.addressComponent.province,
                            'city'      : result.regeocode.addressComponent.city,
                            'zone'      : result.regeocode.addressComponent.district
                        };
                        //initRegionByName(pcz);
                        var township    =  result.regeocode.addressComponent.township;
                        var street      =  result.regeocode.addressComponent.street;
                        var streetNumber=  result.regeocode.addressComponent.streetNumber;
                        var neighborhood=  result.regeocode.addressComponent.neighborhood;
                        var adds = township + street + streetNumber + neighborhood;
                        $('#addr').val(adds);
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
            var addr     = $('#addr').val();
            if(addr){
                var address = city + '市' + zone + addr;
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : city, //城市，默认：“全国”
                        'radius' : 1000   //范围，默认：500
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //地理编码,返回地理编码结果
                    geocoder.getLocation(address, function(status, result) {
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
                layer.msg('请填写门店地址和详细地址');
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

       /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-logo'){
                    $('#logo').val(allSrc[0]);
                }
            }else {
                var img_html = '';
                var cur_num = $('#' + nowId + '-num').val();
                for (var i = 0; i < allSrc.length; i++) {
                    var key = i + parseInt(cur_num);
                    img_html += '<p>';
                    img_html += '<img class="img-thumbnail col" layer-src="' + allSrc[i] + '"  layer-pid="" src="' + allSrc[i] + '" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_' + key + '" name="slide_' + key + '" value="' + allSrc[i] + '">';
                    img_html += '<input type="hidden" id="slide_id_' + key + '" name="slide_id_' + key + '" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num) + allSrc.length;
                if (now_num <= maxNum) {
                    $('#' + nowId + '-num').val(now_num);
                    $('#' + nowId).prepend(img_html);
                } else {
                    layer.msg('详情图片最多' + maxNum + '张');
                }
            }
        }
    }

    $('.btn-save').on('click',function(){
    	layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            saveShop();
        });
    });

    function saveShop(){
    var is_head  = $('#is_head:checked').val();
    var data = {};
//    var check = new Array('name','addr','lng','lat','logo','mobile','date');
    var check = new Array('name','addr','contact','lng','lat','open_time','close_time','logo','content','addr_detail','mobile','wxcode','date','management','video_url');
    for(var i=0 ; i < check.length; i++){
        var temp = $('#'+check[i]).val();
        var require = $('#'+check[i]).attr('required');
        data[check[i]] = temp;

        if(!temp && require == 'required'){
            var msg = $('#'+check[i]).attr('placeholder');
            layer.msg(msg);
            return false;
        }else{

        }
    }
    data.category = $('#category').val();
    data.id      = $('#hid_id').val();
    data.video_type = $("input[name='video_type']:checked").val();
    data.istop = $("input[name='istop']:checked").val();
    var imgArr = [];
    $('#slide-img').find("img").each(function () {
       var _this = $(this);
       imgArr.push(_this.attr('src'))
    });
    data.imgArr = imgArr;
    var index    = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/wxapp/mobile/saveShopEdit',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                layer.msg(ret.em);
                window.location.href='/wxapp/mobile/shopList';
            }else{
                layer.msg(ret.em);
            }
        }
    });


}
</script>


