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
    #container {
        width:100%;
        height: 300px;
    }

    .inline{
        display: inline-block;
        padding-right: 30px;
        text-align: center;
    }

    .left-inline{
        padding-left: 30px;
    }

    .left-palceholder{
        position: relative;
        right: -30px;
        color: #a6a6a6;
        top: 2px;
    }

    .palceholder{
        position: relative;
        left: -30px;
        color: #a6a6a6;
        top: 2px;
    }

    .form-control:not(.left-inline){
        margin-left: 18px;
    }

    .group-title, .group-info,.info-group-inner .group-info,.info-group-inner .group-title{
        background: #fff;;
    }

    .info-group-inner .group-info .control-label {
        font-weight: normal;
        color: gray;
    }

</style>
<div>
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="#"> 返回 </a></small> | 新增/编辑房源信息</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main">
                                <div id="fuelux-wizard" class="row-fluid" data-target="#step-container">
                                    <ul class="wizard-steps">
                                        <li data-target="#step1" <{if $row}>class="complete" <{else}>class="active"<{/if}>>
                                        <span class="step">1</span>
                                        <span class="title">基本信息</span>
                                        </li>

                                        <li data-target="#step2">
                                            <span class="step">2</span>
                                            <span class="title">图片</span>
                                        </li>
                                    </ul>
                                </div>

                                <hr />
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="resources-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['ahr_id']}><{else}>0<{/if}>">
                                        <input type="hidden" id="type" name="type" value="<{if $type}><{$type}><{else}>0<{/if}>">
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">

                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="title" name="title" placeholder="请填写名称" required="required" value="<{if $row}><{$row['ahr_title']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="width: 420px;" id="rent">
                                                            <label class="control-label"><font color="red">*</font>租金：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="rentPrice" name="rentPrice"  value="<{if $row}><{$row['ahr_price']}><{/if}>">
                                                                <span class="palceholder" style="left: -45px">元/月</span>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="width: 420px;" id="stock">
                                                            <label class="control-label"><font color="red">*</font>库存：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="stock" name="stock"  value="<{if $row}><{$row['ahr_stock']}><{/if}>"  >
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>详细地址：</label>

                                                            <div class="control-group" style="float: left;width: 63%;margin: 0;">
                                                                <select id="province" name="province" class="form-control inline" onchange="changeWxappProvince()" style="width: 20%;display: inline-block">
                                                                    <option value="0">省份</option>
                                                                    <{foreach $province as $val}>
                                                                <option value="<{$val['region_id']}>" <{if $row['ahr_province'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                                <select name="city" id="city" class="form-control inline"  style="width: 20%;display: inline-block">
                                                                    <option value="0">城市</option>
                                                                    <{foreach $city as $val}>
                                                                <option value="<{$val['region_id']}>" <{if $row['ahr_city'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                                <select id="zone" name="zone" class="form-control inline" style="width: 20%;display: inline-block">
                                                                    <option value="0">地区</option>
                                                                    <{foreach $area as $val}>
                                                                <option value="<{$val['region_id']}>" <{if $row['ahr_zone'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                                                    <{/foreach}>

                                                                </select>
                                                                <select id="park" name="park" class="form-control inline" style="width: 20%;display: inline-block">
                                                                    <option value="0">园区</option>
                                                                    <{foreach $park as $val}>
                                                                <option value="<{$val['region_id']}>" <{if $row['ahr_park'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                                                    <{/foreach}>

                                                                </select>
                                                                <input type="text" class="form-control" id="address" name="address" style="width: 50%;display: inline-block;margin-left: 18px;margin-top: 20px" placeholder="请填写具体地址" value="<{if $row}><{$row['ahr_address']}><{/if}>">
                                                            </div>

                                                            <div class="control-group col-sm-2 text-left" style="margin-left: 0;margin-top: 54px">
                                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['ahr_lng']}><{/if}>">
                                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['ahr_lat']}><{/if}>">
                                                                <label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="control-group col-sm-9">
                                                                <div id="container"></div>
                                                            </div>
                                                        </div>
                                                        <div class="space-6"></div>
                                                    </div>
                                                </div>
                                            </div>
                                      <!--      <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group" style="width: 400px;display: inline-block;">
                                                            <label class="control-label">联系人姓名：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="请填写姓名" required="required" value="<{if $row}><{$row['ahr_contact']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="width: 400px;display: inline-block;">
                                                            <label class="control-label">手机号：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="请填写手机号" required="required" value="<{if $row}><{$row['ahr_mobile']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group" style="width: 400px;display: inline-block;">
                                                            <label class="control-label">微信：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="weixin" name="weixin" placeholder="请填写微信"  value="<{if $row}><{$row['ahr_weixin']}><{/if}>" style="width: 160px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                        <div class="step-pane" id="step2">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">图片</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['ahrs_path']}>"  layer-pid="" src="<{$val['ahrs_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['ahrs_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['ahrs_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="10" data-width="750" data-height="400" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>简介</span>
                                                    </div>
                                                    <div class="group-info" style="padding-left: 0">
                                                            <div class="control-group" style="margin-left: 0">
                                                                <textarea class="form-control" style="width:100%;height:200px;" id = "detail" name="detail" placeholder="描述"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['ahr_content']}><{$row['ahr_content']}><{/if}></textarea>
                                                            </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <hr />
                                <div class="row-fluid wizard-actions">
                                    <{if $row}>
                                    <button class="btn btn-primary" onclick="saveResource('save');">
                                        保存
                                    </button>
                                    <{/if}>
                                    <button class="btn btn-prev">
                                        <i class="icon-arrow-left"></i>
                                        上一步
                                    </button>

                                    <button class="btn btn-success btn-next" data-last="完成">
                                        下一步
                                        <i class="icon-arrow-right icon-on-right"></i>
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
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    var s_type = '<{$type}>';
    $('#pro').change(function(){
        $("#city").html('');
        $("#area").html('');
        var p_ro = $(this).val();
        //console.log(p_ro);return;
        var data = {
            'pro' : p_ro,
        }
        $.ajax({
            url:'/wxapp/park/getcity',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value=''>地市</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#city").html(option);
            }
        })

    });
    $('#city').change(function(){
        $("#zone").html('');
        var city = $(this).val();
        var data = {
            'city' : city,
        }
        $.ajax({
            url:'/wxapp/park/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='0'>区域</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#zone").html(option);
            }
        })

    });

    $('#zone').change(function(){
        $("#park").html('');
        var zone = $(this).val();
        var data = {
            'zone' : zone,
        }
        $.ajax({
            url:'/wxapp/park/getpark',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='0'>园区</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['ap_id'] + '>' + v['ap_name'] + '</option>'
                });
                $("#park").html(option);
            }
        })

    });
    $(function(){
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
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
            saveResource('step');
        });

        $('.product-leibie').on('click', 'li', function(event) {
            $(this).addClass('selected').siblings('li').removeClass('selected');
            var id = $(this).data('id');
            $('#g_c_id').val(id);
        });
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
                    if (status === 'complete' && result.info === 'OK') {
                        addMarker(e.lnglat.getLng(), e.lnglat.getLat(),result.regeocode.formattedAddress);

                        //详细地址处理
                        var pcz  = {
                            'province'  : result.regeocode.addressComponent.province,
                            'city'      : result.regeocode.addressComponent.city,
                            'zone'      : result.regeocode.addressComponent.zone
                        };

                        var province    = result.regeocode.addressComponent.province;
                        var city       = result.regeocode.addressComponent.city;
                        var zone        = result.regeocode.addressComponent.zone;
                        var township    =  result.regeocode.addressComponent.township;
                        var street      =  result.regeocode.addressComponent.street;
                        var streetNumber=  result.regeocode.addressComponent.streetNumber;
                        var neighborhood=  result.regeocode.addressComponent.neighborhood;
                        town = zone;
                        var adds = province + city + zone + township + street + streetNumber + neighborhood;
                        $('#zone').val(zone);
                        $('#address').val(township+street+streetNumber);
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var province = $('#province').find("option:selected").text();
            var city = $('#city').find("option:selected").text();
            var addr = $('#address').val();
            var zone = $('#zone').find("option:selected").text();
            var community = $('#community').val();
            var detail  = province+''+city+''+zone+''+addr+''+community;
            if(detail){
                var address = detail;
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : '', //城市，默认：“全国”
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
                layer.msg('请填写详细地址');
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
     * 第一步检查商品类目
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
        var check   = new Array('title','address');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        return true;
    }

    /**
     * 第三步，检查图片
     * @returns {boolean}
     */
    function checkImg(){
       var res_cover = $('#cover').val();
        if(!res_cover){
            layer.msg('请上传封面图');
            return false;
        }
        var slide = 0;
        for(var i=0;i<=4;i++){
            var temp = $('#slide_'+i).val();
            if(temp) {
                slide = parseInt(slide) + 1;
            }
        }
        if(slide == 0){
            layer.msg('请上传幻灯');
            return false;
        }
        return true;
    }

    /**
     * 保存房源信息
     */
    function saveResource(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        var pro_name      = $("#province").find("option:selected").text();
        var city_name     = $("#city").find("option:selected").text();
        var zone_name     = $("#zone").find("option:selected").text();
        var park_name     = $("#park").find("option:selected").text();
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/park/saveHouse',
            'data'  : $('#resources-form').serialize()+"&pro_name="+pro_name+"&city_name="+city_name+"&zone_name="+zone_name+"&park_name="+park_name,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200 ){
                    alert(ret.em);
                    if(s_type == 1){
                        window.location.href='/wxapp/park/stationList';
                    }else{
                        window.location.href='/wxapp/park/officeList';
                    }

                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }

    $('input[name="saleType"]').click(function(){
        if($(this).val() == 1){
            $('#rent').hide();
            $('#sale').show();
        }else{
            $('#rent').show();
            $('#sale').hide();
        }
    })

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

    $('.math-vip').blur(function(){
        var discount = $(this).val();
    });

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
    }
    var nowdate = new Date();
    var year  = nowdate.getFullYear(),
        month = nowdate.getMonth()+1,
        date  = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy',
            maxDate:today
        });
    }






</script>

