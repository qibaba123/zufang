<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
    .layui-layer .container{
        width: 100%;
    }
</style>
<{include file="../article-kind-editor.tpl"}>
<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['acs_id']}><{$row['acs_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="">店铺分类<font color="red">*</font></label>
            <div class="control-group">
                <select id="acs_category"  class="form-control">
                    <option value="0">无分类</option>
                    <{if $category_select}>
                    <{foreach $category_select as $val}>
                <option value="<{$val['acc_id']}>" <{if $row && $row['acs_category_id'] eq $val['acc_id']}>selected="selected"<{/if}> ><{$val['acc_title']}></option>
                    <{/foreach}>
                    <{/if}>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="acs_name" placeholder="门店名称" class="form-control" name="img" value="<{if $row && $row['acs_name']}><{$row['acs_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="" style="margin-right: 20px">店铺封面图片<font color="red">*</font></label>
            <div class="cropper-box" data-width="750" data-height="525" >
                <img <{if $row && $row['acs_cover']}>src=<{$row['acs_cover']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_75_36.png"<{/if}>  width="300" style="display:inline-block;">
                <input type="hidden" id="acs_cover"  class="avatar-field bg-img" name="img" value="<{if $row && $row['acs_cover']}><{$row['acs_cover']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">联系人<font color="red">*</font></label>
            <div class="control-group">
                <input id="acs_contacter1" class="form-control" rows="2" placeholder="联系人" style="float: left;width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_contacter']}><{$row['acs_translate_contacter'][0]}><{/if}>">
                <input id="acs_contacter2" class="form-control" rows="2" placeholder="联系人" style="float: left;width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_contacter']}><{$row['acs_translate_contacter'][1]}><{/if}>">
                <input id="acs_contacter3" class="form-control" rows="2" placeholder="联系人" style="width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_contacter']}><{$row['acs_translate_contacter'][2]}><{/if}>">
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺电话<font color="red">*</font></label>
            <div class="control-group">
                <input id="acs_mobile1" class="form-control" rows="2" placeholder="门店电话" style="float: left;width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_mobile']}><{$row['acs_translate_mobile'][0]}><{/if}>">
                <input id="acs_mobile2" class="form-control" rows="2" placeholder="门店电话" style="float: left;width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_mobile']}><{$row['acs_translate_mobile'][1]}><{/if}>">
                <input id="acs_mobile3" class="form-control" rows="2" placeholder="门店电话" style="width: 32%;margin-right: 5px;" value="<{if $row && $row['acs_translate_mobile']}><{$row['acs_translate_mobile'][2]}><{/if}>">
            </div>
        </div>
        <div class="form-group">
            <label for="">营业时间</label>
            <div class="control-group">
                <input type="text" id="start_time" name="start_time" class="cus-input time form-control" style="width: 50%;float: left" value="<{if $row && $row['acs_open_time']}><{$row['acs_open_time'][0]}><{/if}>"/>
                <input type="text" id="end_time" name="end_time" class="cus-input time form-control" style="width: 50%"  value="<{if $row && $row['acs_open_time']}><{$row['acs_open_time'][1]}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">是否置顶<font color="red">*</font></label>
            <div class="control-group">
                <select id="acs_istop"  class="form-control">
                    <option value="0" <{if ($row && $row['acs_istop'] eq 0) || !$row}>selected<{/if}> >否</option>
                    <option value="1" <{if $row && $row['acs_istop'] eq 1 }>selected<{/if}> >是</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="">排序权重<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="acs_sort" placeholder="请填写1-100之间的整数，值越大排序越靠前" class="form-control" value="<{if $row && $row['acs_sort']}><{$row['acs_sort']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <div class="fenleinav-manage" style="padding-top: 10px;">
                <div class="input-groups" style="margin-bottom: 10px;">
                    <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                        <label>店铺地址</label>
                        <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle; float: right;">
                            <input type="hidden" id="lng1" name="lng1" placeholder="请输入地址经度" value="<{$row['acs_translate_lng'][0]}>">
                            <input type="hidden" id="lat1" name="lat1" placeholder="请输入地址纬度" value="<{$row['acs_translate_lat'][0]}>">

                            <input type="hidden" id="lng2" name="lng2" placeholder="请输入地址经度" value="<{$row['acs_translate_lng'][1]}>">
                            <input type="hidden" id="lat2" name="lat2" placeholder="请输入地址纬度" value="<{$row['acs_translate_lat'][1]}>">

                            <input type="hidden" id="lng3" name="lng3" placeholder="请输入地址经度" value="<{$row['acs_translate_lng'][2]}>">
                            <input type="hidden" id="lat3" name="lat3" placeholder="请输入地址纬度" value="<{$row['acs_translate_lat'][2]}>">
                            <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                        </div>
                    </div>
                    <input type="text" class="cus-input form-control" style="margin-bottom: 10px;" placeholder="请输入详细地址" id="details-address1" onfocus="setEditAddress(1)" value="<{$row['acs_translate_address'][0]}>"/>
                    <input type="text" class="cus-input form-control" style="margin-bottom: 10px;" placeholder="请输入详细地址" id="details-address2" onfocus="setEditAddress(2)" value="<{$row['acs_translate_address'][1]}>"/>
                    <input type="text" class="cus-input form-control" placeholder="请输入详细地址" id="details-address3" onfocus="setEditAddress(3)" value="<{$row['acs_translate_address'][2]}>"/>
                </div>
                <div id="container" style="width: 100%;height: 300px"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺简介</label>
            <div class="control-group">
                <textarea class="form-control" id="acs_brief" cols="30" rows="5"><{if $row && $row['acs_brief']}><{$row['acs_brief']}><{/if}></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺详情<font color="red">*</font></label>
            <div class="control-group">
                <textarea class="form-control" style="width:100%;height:700px;visibility:hidden;" id = "aptitude" name="aptitude" placeholder="请填写资质信息"  rows="20" style=" text-align: left; resize:vertical;" >
                    <{$row['acs_content']}>
                </textarea>
                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                <input type="hidden" name="ke_textarea_name" value="aptitude" />
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
</div>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript">
    var latitude1 = '<{$row['acs_translate_lat'][0]}>'?'<{$row['acs_translate_lat'][0]}>':'34.77485';
    var longitude1 = '<{$row['acs_translate_lng'][0]}>'?'<{$row['acs_translate_lng'][0]}>':'113.72052';
    var storeAddress1 = '<{$row['acs_translate_address'][0]}>'?'<{$row['acs_translate_address'][0]}>':'公司地址';

    var currEditAddress ="1";
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
    addMarker(longitude1,latitude1,storeAddress1);

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
                }else{
                    //获取地址失败
                }
            });
        });
    });
    //搜索地图位置
    $('.btn-map-search').on('click',function(){
        var addr     = $('#details-address'+currEditAddress).val();
        if(addr){
            AMap.service('AMap.Geocoder',function(){ //回调函数
                //实例化Geocoder
                geocoder = new AMap.Geocoder({
                    'city'   : '全国', //城市，默认：“全国”
                    'radius' : 1000   //范围，默认：500
                });
                //TODO: 使用geocoder 对象完成相关功能
                //地理编码,返回地理编码结果
                geocoder.getLocation(addr, function(status, result) {
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

    function setEditAddress(n){
        currEditAddress = n;
        var longitude = 0;
        var latitude = 0;
        var storeAddress = '';

        storeAddress = $('#details-address'+n).val();
        longitude = $('#lng'+n).val();
        latitude = $('#lat'+n).val();

        addMarker(longitude,latitude,storeAddress);
    }


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
        $('#lng'+currEditAddress).val(lng);
        $('#lat'+currEditAddress).val(lat);
        $('#details-address'+currEditAddress).val(address);
    }

    $('.btn-save').click(function(){
        var id      = $('#hid_id').val();

        var lng1     = $('#lng1').val();
        var lat1     = $('#lat1').val();
        var address1 = $('#details-address1').val();

        var lng2     = $('#lng2').val();
        var lat2     = $('#lat2').val();
        var address2 = $('#details-address2').val();

        var lng3     = $('#lng3').val();
        var lat3     = $('#lat3').val();
        var address3 = $('#details-address3').val();

        var name    = $('#acs_name').val();

        var mobile1  = $('#acs_mobile1').val();
        var mobile2  = $('#acs_mobile2').val();
        var mobile3  = $('#acs_mobile3').val();

        var contacter1 = $('#acs_contacter1').val()
        var contacter2 = $('#acs_contacter2').val()
        var contacter3 = $('#acs_contacter3').val()

        var name    = $('#acs_name').val();
        var mobile  = $('#acs_mobile').val();
        var category = $('#acs_category').val();
        var openTime = $('#start_time').val()+'-'+$('#end_time').val();
        var content = $('#aptitude').val();
        var cover   = $('#acs_cover').val();
        var brief   = $('#acs_brief').val();
        var istop   = $('#acs_istop').val();
        var sort   = $('#acs_sort').val();


        if(!name){
            layer.msg("店铺名称或电话不能为空");
            return;
        }

        if(!category){
            layer.msg("请选择店铺类型");
            return;
        }
        var load_index = layer.load(
            2,
            {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/city/saveShop',
            'data'  : {
                id : id,
                lng1: lng1,
                lat1: lat1,
                address1: address1,
                contacter1:contacter1,
                lng2: lng2,
                lat2: lat2,
                address2: address2,
                contacter2:contacter2,
                lng3: lng3,
                lat3: lat3,
                address3: address3,
                contacter3:contacter3,
                name: name,
                mobile1: mobile1,
                mobile2: mobile2,
                mobile3: mobile3,
                openTime: openTime,
                category: category,
                content: content,
                cover: cover,
                brief: brief,
                istop : istop,
                sort : sort
            },
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/city/ordinaryShopList';
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    })

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<{$cropper['modal']}>
