<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<style type="text/css">

    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

    .select-member .form-group{
        margin-bottom: 5px !important;
    }

    .mem-list{
        z-index: 999 !important;
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<!-- include file="../layer/ajax-select-input-single.tpl"-->

<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="javascript:;"> 返回 </a></small> | 帖子发布</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>

                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"   enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['acp_id']}><{else}>0<{/if}>">
                                        <div class="step-pane" style="display: block" id="step1">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>帖子信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <!--<div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>帖子分类：</label>
                                                            <div class="control-group">
                                                                <select name="categoryId" id="categoryId">
                                                                    <{foreach $shortcut as $val}>
                                                                    <{if $val['acc_service_type'] == 1}>
                                                                    <option value="<{$val['acc_id']}>"><{$val['acc_title']}></option>
                                                                    <{/if}>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>-->
                                                        <div class="form-group">
                                                            <label class="control-label">帖子类型：</label>
                                                            <div class="control-group">
                                                                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="postType" id="postType1" onchange="typeChange()" value="1" <{if !$row || ($row && $row['acp_post_type'] eq 1)}>checked<{/if}>>
                                                                        <label for="postType1">图文</label>
                                                                    </span>
                                                                    <span>
                                                                        <input type="radio" name="postType" id="postType3" onchange="typeChange()" value="3"  <{if $row && $row['acp_post_type'] eq 3}>checked<{/if}>>
                                                                        <label for="postType3">视频</label>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>帖子分类：</label>
                                                            <div class="form-group col-sm-4">
                                                                <select class="form-control" id="firstClass" name="firstClass" onchange="changeFirstClass()">
                                                                    <option value="">选择分类</option>
                                                                    <{foreach $shortcut as $val}>
                                                                    <{if $val['acc_service_type'] == 1}>
                                                                    <option value="<{$val['acc_id']}>" <{if $row['acp_acc_id'] == $val['acc_id']}>selected<{/if}>><{$val['acc_title']}></option>
                                                                    <{/if}>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-sm-5">
                                                                <select class="form-control" id="secondClass" name="secondClass" onchange="changeSecondClass()">
                                                                    <option value="">选择二级分类</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group select-member">
                                                            <label for="name" class="control-label">发帖会员：</label>                                              <div class="control-group">

                                                                <div class="input-tip" style="color: #bbb;font-size: 12px">
                                                                    若不选择发帖会员,发帖人头像昵称将默认为本平台名称和图标
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <!--发帖会员变更为只选择后台添加的会员-->
                                                        <{if !$row}>
                                                        <div class="form-group">
                                                            <label class="control-label">发帖会员：</label>
                                                            <div class="form-group col-sm-4" >
                                                                <select class="form-control" id="mid" name="mid">
                                                                    <{foreach $memberList as $val}>
                                                                    <option value="<{$val['m_id']}>"><{$val['m_nickname']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-sm-4" style="margin-top:5px;">
                                                            <span style="color: red;font-size: 14px;">（注：需要先到会员管理的会员列表点击新增添加会员）</span>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <div class="form-group">
                                                            <label class="control-label">帖子内容：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" maxlength="5000" id="acp_content" name="content" placeholder="帖子内容" style="max-width: 850px;"><{if $row}><{$row['acp_content']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>联系电话：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="acp_mobile" name="mobile" placeholder="请填写联系电话"  value="<{if $row}><{$row['acp_mobile']}><{/if}>">
                                                            </div>
                                                        </div>
                                                        <!--
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>置顶：</label>
                                                            <div class="control-group">
                                                                <select name="postTop" id="postTop">
                                                                    <{foreach $postTop as $val}>
                                                                    <{if $val['acc_service_type'] == 1}>
                                                                    <option value="<{$val['acc_id']}>"><{$val['acc_title']}></option>
                                                                    <{/if}>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        -->
                                                        <div class="form-group" id="video-info" style="display: none">
                                                            <label for="name" class="control-label"><font color="red"></font>视频链接：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="acp_video_url" name="video" placeholder="请填写链接地址"  value="<{if $row}><{$row['acp_video_url']}><{/if}>">
                                                            </div>
                                                            <div style="margin-left: 150px;color: #aaa">注：仅支持腾讯视频链接，或填写视频源链接</div>
                                                        </div>
                                                        <div class="form-group"  id="image-info" >
                                                            <label for="name" class="control-label"><font color="red"></font>图片(最多9张)：</label>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $imgs as $key=>$val}>
                                                                <p>
                                                                    <img class="img-thumbnail col" layer-src="<{$val['aca_path']}>"  layer-pid="" src="<{$val['aca_path']}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['aca_path']}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['aca_id']}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <span onclick="toUpload(this)" data-limit="9" data-width="540" data-height="960" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $imgs}><{count($imgs)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>地址：</label>
                                                            <div class="control-group">
                                                                <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                                                                    <input type="text" style="display: inline-block;width: 72%" class="form-control" name="address" placeholder="请输入详细地址" id="acp-address"  />
                                                                    <div class="text-right" style="width: 8%;display: inline-block;vertical-align: middle;">
                                                                        <input type="hidden"  id="acp_lng" name="lng" placeholder="请输入地址经度">
                                                                        <input type="hidden" id="acp_lat" name="lat" placeholder="请输入地址纬度">
                                                                        <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                                                                    </div>
                                                                </div>
                                                                <div id="container" style="width: 80%;height: 300px"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr />
                                <div class="row-fluid wizard-actions" style="text-align: center">
                                    <button id='savePost' class="btn btn-primary" onclick="savePostData();">
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
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script type="text/javascript" src="/public/wxapp/mall/js/goods.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script type="text/javascript">
    var curr_sid = '<{$curr_shop["s_id"]}>';
    var lng = '<{$row['acp_lat']}>'?'<{$row['acp_lat']}>':'34.77485';
    var lat = '<{$row['acp_lng']}>'?'<{$row['acp_lng']}>':'113.72052';
    var address = '<{$row['acp_address']}>'?'<{$row['acp_address']}>':'公司地址';
    var postType = '<{$row['acp_post_type']}>';
    jQuery(function($) {
        <{if $row}>
        initClass(<{$row['acp_acc_id']}> ,'secondClass', <{$row['acp_second_id']}>);
        <{/if}>
        $('#fuelux-wizard').ace_wizard().on('change' , function(e, info){
            console.log(info.step);
            if(info.step == 1 && info.direction == 'next'){
                if(!checkBasic()) return false;
            }else if(info.step == 2 && info.direction == 'next'){
                if(!checkImg()) return false;
            }
        }).on('finished', function(e) {
            saveGoods('step');
        });

        $('.product-leibie').on('click', 'li', function(event) {
            $(this).addClass('selected').siblings('li').removeClass('selected');
            var id = $(this).data('id');
            $('#g_c_id').val(id);
        });

        $(".chosen-select").chosen({
            no_results_text: "没有找到",
            search_contains: true,
            max_selected_options:1,
        });

        if(postType == 3){
            $('#video-info').show();
            $('#image-info').hide();
        }else{
            $('#video-info').hide();
            $('#image-info').show();
        }



        //高德地图引入
        var marker, geocoder,map = new AMap.Map('container',{
            zoom            : 11,
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
        addMarker(lat,lng,address);
        //地图添加点击事件
        map.on('click', function(e) {
            console.log(e);
            console.log(456);
            $('#acp_lng').val(e.lnglat.getLng());
            $('#acp_lat').val(e.lnglat.getLat());
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
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var addr     = $('#acp-address').val();
            if(addr){
                console.log(addr);
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : '全国', //城市，默认：“全国”
                        'radius' : 1000   //范围，默认：500
                    });
                    //TODO: 使用geocoder 对象完成相关功能
                    //地理编码,返回地理编码结果
                    geocoder.getLocation(addr, function(status, result) {
                        console.log(result);
                        if (status === 'complete' && result.info === 'OK') {
                            var loc_lng_lat = result.geocodes[0].location;
                            addMarker(loc_lng_lat.getLng(),loc_lng_lat.getLat(),addr);
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
            /*$scope.address.address   = address;
             $scope.address.longitude = lng;
             $scope.address.latitude  = lat;*/
            $('#acp-address').val(address);
            $('#acp_lng').val(lng);
            $('#acp_lat').val(lat);
            console.log(address);

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
        /*var g_cover = $('#g_cover').val();
        if(!g_cover){
            layer.msg('请上传封面图');
            return false;
        }*/
        var slide = 0;
        for(var i=0;i<=4;i++){
            var temp = $('#slide_'+i).val();
            if(temp) {
                slide = parseInt(slide) + 1;
                console.log(slide);
            }
        }
        if(slide == 0){
            layer.msg('请上传图片');
            return false;
        }
        return true;
    }
    /**
     * 保存帖子信息
     * */
    function savePostData(){
        var content    = $("#acp_content").val();
        //var categoryId = $("#categoryId").val();
        var categoryId = $('#firstClass').val();
        var mobile     = $("#acp_mobile").val();
        if(!categoryId){
            layer.msg('请选择分类哦');
            return;
        }
//        if(!mobile){
//            layer.msg('请填写联系手机号');
//            return;
//        }
        if(!content && !checkImg()){
            layer.msg('帖子内容或图片必须存在一个');
            return;
        }
        if(content.length>2000){
            layer.msg('帖子内容不能超过2000个字符');
        }
       // var mid = $("#multi-choose").find(".choose-txt").find('.delete').data('id');
//       //检查幻灯是否上传
//        if(!checkImg()){
//            layer.msg('请上传图片哦');
//            return;
//        }
        var load_index = layer.load(
            2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/city/newSubmitPost',
            //'data'  : $('#goods-form').serialize()+"&mid="+JSON.stringify(mid),
            'data'   : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'beforeSend':function(){
                $('#savePost').attr('disabled',true);
            },
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec==200){
                    layer.msg(ret.em,{
                        time:1000
                    },function(){
                        //window.location.href='/wxapp/city/postList';
                        window.history.go(-1);
                    });
                }else{
                    layer.msg(ret.em);
                }
            },
            complete:function(){
                $('#savePost').attr('disabled',false);
            }
        });
    }
    //帖子一级分类变更
    function changeFirstClass(){
        var fid = $('#firstClass').val();
        console.log(fid);
        initClass(fid ,'secondClass');
    }


    function initClass(fid,selectId,df){

        if(fid > 0) {
            var data = {
                'fid': fid
            };
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/city/selectPostClass',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        class_html(ret.data,selectId,df);
                    }else{
                        //layer.msg(ret.em);
                        $('#'+selectId).html('');
                    }
                }
            });
        }
    }
    /**
     * 展示一二级分类
     * @param data
     * @param selectId
     */
    function class_html(data,selectId,df){
        var option = '';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.acc_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.acc_id+'" '+sel+'>'+temp.acc_title+'</option>';
        }
        $('#'+selectId).html(option);
    }

    function typeChange() {
        var postType = $("input[name='postType']:checked").val();
        if(postType == 1){
            $('#video-info').hide();
            $('#image-info').show();
        }
        if(postType == 3){
            $('#video-info').show();
            $('#image-info').hide();
        }
    }

    /**
     * 保存商品信息
     */
    function saveGoods(type){
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/goods/save',
            'data'  : $('#goods-form').serialize(),
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200 && type == 'step'){
                    window.location.href='/wxapp/goods/index';
                }else{
                    layer.msg(ret.em);
                }
            }
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
                    $('#g_cover').val(allSrc[0]);
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

