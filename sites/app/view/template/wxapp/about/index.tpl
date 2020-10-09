<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">


<style type="text/css">
    h1, h2, h3, h4, h5, h6{
        font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif,"Microsoft yahei"!important;
    }
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

    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        /*font-family: '黑体';*/
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .goods-selected{
        padding: 5px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }
    .add-related-box{
        text-align: center;
    }
    .related-info{
        margin-bottom: 10px;
        height: 35px;
        line-height: 35px;
    }
    .btn-remove-info{

    }
    .related-info-cate{
        width: 35%;
        float: left;
        margin-right: 10px;
    }
    .related-info-detail{
        width: 49%;
        float: left;
        margin-right: 20px;
    }
    .control-label{
        width: 134px !important;
    }
    .group-title{
        margin-right: 3px;
        font-size: 14px!important;
    }
    .info-group-inner .group-info{
        padding-left: 50px;
    }
    .info-group-inner .group-info .control-label{
        font-weight: normal;
    }
    .col-xs-4{
        padding-left: 0;
    }
    @media (max-width: 1480px){
        .xs-hidden-label{
            display: none;
        }
        .xs-hidden-info{
            margin-left: 0!important;
            padding-left: 0!important;
        }
        .ke-container{
            margin:0 auto!important;
        }
    }
    .green-tip{
        width: 24px;
        height: 24px;
        display: inline-block;
        margin-left: 10px;
        cursor: pointer;
    }
    .info-group-inner .group-title{
        width: 15%;
    }
</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<div  id="mainContent" ng-app="chApp" ng-controller="chCtrl">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter" style='font-size: 14px;font-weight: 500;'><span style='color:#2c87d6;'>关于我们</span></h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>
                        <div class="widget-body" >
                            <div class="widget-main" style="padding: 0 !important;">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"  enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['au_id']}><{else}>0<{/if}>">

                                        <div class="step-pane active" id="step1" style="padding: 0 0 1px 0 !important;">
                                            <!-- 表单分类显示 -->
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>基本信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red">*</font>公司名称：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="c_name" name="c_name" placeholder="请填写公司名称" required="required" value="<{if $row}><{$row['au_c_name']}><{/if}>">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="name" class="control-label">工作时间：</label>
                                                            <div class="control-group">
                                                                <input type="text" style="width: 150px;display: inline" class="form-control business-time time" name="start_time" id="start_time"  placeholder="营业开始时间" value="<{$row['au_work_start_time']}>">
                                                                至
                                                                <input type="text" style="width: 150px;display: inline" class="form-control business-time time" id="end_time" name="end_time" placeholder="营业结束时间" value="<{$row['au_work_end_time']}>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <label class="control-label">联系电话：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="联系电话" value="<{if $row}><{$row['au_mobile']}><{/if}>" style="width:160px;">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label xs-hidden-label">企业服务封面(345px*130px)：</label>
                                                            <div class="control-group" >
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="345" data-height="130" data-dom-id="upload-serviceimage" id="upload-serviceimage"  src="<{if $row && $row['au_service_image']}><{$row['au_service_image']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                                <input type="hidden" id="serviceimage"  class="avatar-field bg-img" name="serviceimage" value="<{if $row && $row['au_service_image']}><{$row['au_service_image']}><{/if}>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label xs-hidden-label">首页封面(168px*119px)：</label>
                                                            <div class="control-group" >
                                                                <img onclick="toUpload(this)" data-limit="1" data-width="168" data-height="119" data-dom-id="upload-image" id="upload-image"  src="<{if $row && $row['au_image']}><{$row['au_image']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                                <input type="hidden" id="image"  class="avatar-field bg-img" name="image" value="<{if $row && $row['au_image']}><{$row['au_image']}><{/if}>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label xs-hidden-label">首页简介：</label>
                                                            <div class="control-group xs-hidden-info" >
                                                                <textarea class="form-control" style="width:100%;height:200px;" id = "brief" name="brief" placeholder="简介"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['au_brief']}><{$row['au_brief']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label"><font color="red">*</font>详细地址：</label>
                                                            <div class="control-group" style="float: left;width: 63%;margin: 0;">
                                                                <input type="text" class="form-control" id="address" name="address" style="width: 50%;display: inline-block;margin-left: 18px;" placeholder="请填写具体地址" value="<{if $row}><{$row['au_address']}><{/if}>">
                                                            </div>
                                                            <div class="control-group col-sm-2 text-left" style="margin-left: 0;">
                                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['au_lng']}><{/if}>">
                                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['au_lat']}><{/if}>">
                                                                <label class="btn btn-default btn-sm btn-map-search"> 搜索地图 </label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="control-group col-sm-9">
                                                                <div id="container" style="width: 750px; height: 300px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <!-- 首页视频信息 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>首页视频</span>
                                                </div>
                                                <div class="group-info  xs-hidden-info">
                                                    <div class="form-group">
                                                        <label class="control-label xs-hidden-label">视频封面（345px * 165px ）：</label>
                                                        <div class="control-group" >
                                                            <img onclick="toUpload(this)" data-limit="1" data-width="345" data-height="165" data-dom-id="upload-videoimage" id="upload-videoimage"  src="<{if $row && $row['au_video_image']}><{$row['au_video_image']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                            <input type="hidden" id="videoimage"  class="avatar-field bg-img" name="videoimage" value="<{if $row && $row['au_video_image']}><{$row['au_video_image']}><{/if}>"/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label xs-hidden-label">视频：</label>
                                                        <div class="control-group xs-hidden-info" >
                                                            <div class="topic">
                                                                <video id="media" src="<{$row['au_video']}>"autoplay="autoplay" controls="controls" style="width:400px"></video>
                                                                <a href="#" class="btn btn-sm btn-info empty_video">清空视频</a>
                                                                <input type="file" id="link" class="form-control">
                                                                <input type="hidden" name="video" id="link_url" value="<{$row['au_video']}>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 富文本框信息 -->
                                        <div class="info-group-box">
                                            <div class="info-group-inner">
                                                <div class="group-title">
                                                    <span>企业简介</span>
                                                </div>
                                                <div class="group-info  xs-hidden-info">
                                                    <div class="form-group">
                                                        <label class="control-label xs-hidden-label">简介图片(上 240px*142px)：</label>
                                                        <div class="control-group" >
                                                            <img onclick="toUpload(this)" data-limit="1" data-width="240" data-height="142" data-dom-id="upload-image1" id="upload-image1"  src="<{if $row && $row['au_image1']}><{$row['au_image1']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                            <input type="hidden" id="image1"  class="avatar-field bg-img" name="image1" value="<{if $row && $row['au_image1']}><{$row['au_image1']}><{/if}>"/>
                                                        </div>
                                                    </div>
                                                   <!-- <div class="form-group">
                                                        <label class="control-label xs-hidden-label">简介(上)：</label>
                                                        <div class="control-group xs-hidden-info" >
                                                            <textarea class="form-control" style="width:100%;height:200px;" id = "brief1" name="brief1" placeholder="简介"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['au_brief1']}><{$row['au_brief1']}><{/if}></textarea>
                                                        </div>
                                                    </div>-->
                                                    <div class="form-group">
                                                        <label class="control-label xs-hidden-label">简介图片(下 240px*142px)：</label>
                                                        <div class="control-group" >
                                                            <img onclick="toUpload(this)" data-limit="1" data-width="240" data-height="142" data-dom-id="upload-image2" id="upload-image2"  src="<{if $row && $row['au_image2']}><{$row['au_image2']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                                                            <input type="hidden" id="image2"  class="avatar-field bg-img" name="image2" value="<{if $row && $row['au_image2']}><{$row['au_image2']}><{/if}>"/>
                                                        </div>
                                                    </div>
                                                    <!--<div class="form-group">
                                                        <label class="control-label xs-hidden-label">简介(下 )：</label>
                                                        <div class="control-group xs-hidden-info" >
                                                            <textarea class="form-control" style="width:100%;height:200px;" id = "brief2" name="brief2" placeholder="简介"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['au_brief2']}><{$row['au_brief2']}><{/if}></textarea>
                                                        </div>
                                                    </div>-->
                                                </div>
                                            </div>
                                        </div>
                                        <div class='info-group-box'>
                                            <div class="info-group-inner">
                                                <div class="group-title" style="background-color: transparent!important;"></div>
                                                <div class='group-info' style="margin-left: 0;padding-left: 0;background-color: transparent!important;">
                                                    <button class="btn btn-primary saveData"  style="width: 150px;margin-left:350px">保存</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js?1"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    });

    $('#link').on('change',function(){
      //  var urlType  = $('input[name="type"]:checked').val();
        var link1       =  document.getElementById("link").files[0]; // js 获取文件对象
        //console.log(link);return;
        var formFile = new FormData();
        formFile.append('link',link1);
        //formFile.append('type',urlType);
        $.ajax({
            'type'	: 'post',
            'url'	: '/wxapp/aboutus/getlink',
            'data'	: formFile,
            'dataType' : 'json',
            'processData' :false, // 不处理发送的数据，因为data值是Formdata对象，不需要对数据做处理
            'contentType' :false, // 不设置Content-type请求头
            'success'  : function(ret){
                if(ret.ec == 200){
                    $('#link_url').val(ret.url);
                    layer.msg('上传成功');
                }
            }
        });
    });

    $('.empty_video').on('click',function(){
        var id       = $('#hid_id').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/aboutus/emptyvideo',
            'data'  : { id : id},
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    //console.log(111);
                    $('#media').attr('src','');
                    $('#link_url').val('');
                }
            }
        });
    })

    $('.saveData').on('click',function () {
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/aboutus/saveAboutUs',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href = '/wxapp/goods/index';
                }
            }
        });
    })




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
                    img_html += '<input type="hidden" id="slide_sort_'+key+'" class="slide-sort" name="slide_sort_'+key+'" value="'+key+'">';
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


    $('.math-vip').blur(function(){
        var discount = $(this).val();
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





</script>

