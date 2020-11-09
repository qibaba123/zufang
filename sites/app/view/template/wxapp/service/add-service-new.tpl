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
<{include file="../../manage/common-kind-editor.tpl"}>
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
                                        <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_id" value="<{if $row && $row['es_id']}><{$row['es_id']}><{/if}>"/>
                                        <div class="step-pane active" id="step1" >

                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">

                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>服务名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" id="es_name" style="width: 150px;" placeholder="服务名称" class="form-control" name="es_name" value="<{if $row && $row['es_name']}><{$row['es_name']}><{/if}>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label for="name" class="control-label"><font color="red">*</font>服务类型：</label>
                                                            <div class="control-group">
                                                                <select class="form-control" style="width: 150px;" name="type" id="type" >
                                                                    <option value="0">请选择服务类型</option>
                                                                    <option value="1" <{if $row['es_type'] == 1}>selected<{/if}>>企业服务商品</option>
                                                                    <option value="2" <{if $row['es_type'] == 2}>selected<{/if}>>企业服务文章</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group type1_show" <{if $row['es_type'] == 1}> style="display:none;" <{/if}>>
                                                            <label for="name" class="control-label" ><font color="red">*</font>服务分类：</label>
                                                            <div class="control-group">
                                                                <select class="form-control" style="width: 150px;" name="type1" id="type1" >
                                                                    <option value="0">请选择分类</option>
                                                                    <{foreach $type1 as $key => $val }>
                                                                      <option value="<{$key}>" <{if $row['es_second_type'] == $key}>selected<{/if}>><{$val}></option>
                                                                    <{/foreach}>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group type2_show" <{if $row['es_type'] == 2}> style="display:none;" <{/if}>>
                                                            <label for="name" class="control-label"><font color="red">*</font>服务分类：</label>
                                                            <div class="control-group">
                                                                <select class="form-control" style="width: 150px;" name="type2" id="type2" >
                                                                    <option value="0">请选择分类</option>
                                                                    <{foreach $type2 as $key => $val }>
                                                                        <option value="<{$key}>" <{if $row['es_second_type'] == $key}>selected<{/if}>><{$val}></option>
                                                                    <{/foreach}>

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group priceshow" <{if $row['es_type'] == 2}> style="display:none;" <{/if}>>
                                                        <label for="name" class="control-label"><font color="red">*</font>金额：</label>
                                                        <div class="control-group">
                                                            <input id="price" name="price" class="form-control inline" style="width: 150px;" placeholder="金额" value="<{if $row && $row['es_price']}><{$row['es_price']}><{/if}>">
                                                            <span class="palceholder" style="left: -45px">元/年</span>
                                                        </div>
                                                    </div>
                                                <!--    <div class="form-group formatshow">
                                                        <h3 class="lighter block green">规格</h3>
                                                        <div id="format" class="pic-box" style="display:inline-block">
                                                            <{foreach $format as $key=>$val}>
                                                            <p>

                                                                <input style="white-space:nowrap;" class="form-control" type="text" id="format_<{$key}>" name="format_<{$key}>" value="<{$val['sf_name']}>">
                                                                <span class="delformat-btn">×</span>
                                                                <input type="hidden" id="format_id_<{$key}>" name="format_id_<{$key}>" value="<{$val['sf_id']}>">
                                                            </p>
                                                            <{/foreach}>
                                                        </div>
                                                        <span onclick="addformat(this)" class="btn btn-success btn-xs">添加规格</span>
                                                        <input type="hidden" id="slide-format-num" name="slide-format-num" value="<{if $format}><{count($format)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                    </div>-->
                                                    <div class="form-group formatshow"  <{if $row['es_type'] == 2}> style="display:none;" <{/if}>>
                                                        <label for="name" class="control-label" >规格：</label>
                                                        <div class="control-group">
                                                            <div class="panel-group" id="panel-group" style="margin-left: 17px;">
                                                                <{foreach $format as $key=>$val}>
                                                                <div class="panel" data-sort="format_id_<{$key}>">
                                                                    <div class="panel-collapse">
                                                                        <a href="javascript:;" class="close" onclick="remove_address(this)">×</a>
                                                                        <div class="panel-body">

                                                                            <input type="hidden" name="format_id_<{$key}>" value="0">

                                                                            <div class="col-xs-4">
                                                                                <div class="input-group">
                                                                                    <label for=""  class="input-group-addon"><font color="red">*</font>规格名称</label>
                                                                                    <input type="text" class="form-control guigeName" name="receive_name_<{$key}>" value="<{if $val['sf_name']}><{$val['sf_name']}><{else}><{/if}>" >
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <{/foreach}>
                                                            </div>
                                                            <a href="javascript:;" class="ui-btn" onclick="add_address()" style="    margin: 3px 0;"><i class="icon-plus"></i>添加规格</a>
                                                            <input type="hidden" name="format-num" id="format-num" value="<{if $format}><{count($format)}><{else}>0<{/if}>">
                                                            <input type="hidden" name="format-sort" id="format-sort" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="control-label"><font color="red">*</font>权重：</label>
                                                        <div class="control-group">
                                                            <input id="weight" class="form-control" style="width: 150px;"  name="weight" placeholder="权重" value="<{if $row && $row['es_weight']}><{$row['es_weight']}><{/if}>">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="name" class="control-label"><font color="red">*</font>简介：</label>
                                                        <div class="control-group">
                                                            <textarea class="form-control" style="width:100%;height:200px;" id = "brief" name="brief" placeholder="简介"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['es_brief']}><{$row['es_brief']}><{/if}></textarea>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="step-pane" id="step2">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>图片信息</span>
                                                    </div>

                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="" class="green">LOGO</label>
                                                            <div class="control-group">
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="250" data-height="250" data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['es_logo']}><{$row['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                                <input type="hidden" id="logo"  class="avatar-field bg-img" name="logo" value="<{if $row && $row['es_logo']}><{$row['es_logo']}><{/if}>"/>

                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for=""  class="green">封面(750 * 400)</label>
                                                            <div class="control-group">

                                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['es_cover']}><{$row['es_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                                <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['es_cover']}><{$row['es_cover']}><{/if}>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <h3 class="lighter block green">图片(750 * 400)</h3>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $slide as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['ss_path']}>"  layer-pid="" src="<{$val['ss_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['ss_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['ss_id']}>">
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
                                                        <span>详情</span>
                                                    </div>
                                                    <div class="group-info" style="padding-left: 0">
                                                        <div class="control-group" style="margin-left: 0">
                                                            <textarea class="form-control" style="width:100%;height:600px;visibility:hidden;" id = "content" name="content" placeholder="详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                 <{$row['es_content']}>
                                                         </textarea>
                                                            <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                            <input type="hidden" name="ke_textarea_name" value="content" />
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

    $('#type').on('change',function () {
        var type = $('#type').val();
       // console.log(type);
        if(type == 1){
            $('.priceshow').show();
            $('.type1_show').show();
            $('.type2_show').hide();
            $('.formatshow').show();
        }else{
            $('.priceshow').hide();
            $('.type1_show').hide();
            $('.type2_show').show();
            $('.formatshow').hide();
        }

    })
    function get_format_html(key){
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="remove_address(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div class="col-xs-4">';
        _html       += '<div class="input-group">';
        _html       += '<label for=""  class="input-group-addon"><font color="red">*</font>规格名称</label>';
        _html       += '<input type="text" class="form-control guigeName" name="receive_name_'+key+'"  >';
        _html       += '</div></div>';
        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }
    /*移除规格*/
    function remove_address(elem){
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
    /*添加地址*/
    function add_address() {
        var key = parseInt($('#format-num').val());
        console.log(key);

        var html = get_format_html(key);//$("#panel-template").html();
        key++;
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly", true);
        $("#g_stock").attr("readonly", true);
        formatSort();
        sortString();
    }




    $(function(){
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            /*  去掉商品类目不再做验证*/
            /*
             if(info.step == 1 && info.direction == 'next') {
             if(!checkCategory()) return false;
             }else
             */
            if(info.step == 1 && info.direction == 'next'){
                //if(!checkBasic()) return false;
            }else if(info.step == 2 && info.direction == 'next'){
               // if(!checkImg()) return false;
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
        var check   = new Array();
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
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/service/saveService',
            'data'  : $('#resources-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200 ){
                    alert(ret.em);
                    window.location.href='/wxapp/service/serviceList';
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
                if(nowId == 'upload-logo'){
                    $('#logo').val(allSrc[0]);
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






</script>

