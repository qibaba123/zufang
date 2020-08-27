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

<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['asc_id']}><{$row['asc_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="">所属区域<font color="red">*</font></label>
            <div class="control-group">
                <select id="asc_area"  class="form-control">
                    <option value="0">请选择</option>
                    <{if $areaSelect}>
                        <{foreach $areaSelect as $val}>
                         <option value="<{$val['id']}>" <{if $row && $row['asc_area'] eq $val['id']}>selected="selected"<{/if}> ><{$val['area']}>  <{$val['name']}></option>
                        <{/foreach}>
                    <{/if}>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="">社区名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asc_name" placeholder="社区名称" class="form-control"  value="<{if $row && $row['asc_name']}><{$row['asc_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group" style="display: none">
            <label for="">社区编码</label>
            <div class="control-group">
                <input type="text" id="asc_code" placeholder="社区编码" class="form-control"  value="<{if $row && $row['asc_code']}><{$row['asc_code']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺名称<font color="red">*</font></label>
            <div class="control-group">
                <input id="asc_shop_name" class="form-control" placeholder="店铺名称" value="<{if $row && $row['asc_shop_name']}><{$row['asc_shop_name']}><{/if}>">
            </div>
        </div>
        <!--
        <div class="form-group">
            <label for="">排序权重<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asc_weight" placeholder="请填写1-100之间的整数，值越大排序越靠前" class="form-control" value="<{if $row && $row['asc_weight']}><{$row['asc_weight']}><{/if}>"/>
            </div>
        </div>
        -->
        <div class="form-group">
            <div class="fenleinav-manage" style="padding-top: 10px;">
                <div class="input-groups" style="margin-bottom: 10px;">
                    <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                        <label>社区地址<font color="red">*</font></label>
                        <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle; float: right;">
                            <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" value="<{$row['asc_lng']}>">
                            <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" value="<{$row['asc_lat']}>">
                            <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                        </div>
                    </div>
                    <textarea rows="3" class="cus-input form-control" placeholder="请输入社区地址" id="details-address"><{$row['asc_address']}></textarea>
                </div>
                <div id="container" style="width: 100%;height: 300px"></div>
            </div>
        </div>
        <div class="form-group">
            <label for="">详细地址</label>
            <div class="control-group">
                <input id="asc_address_detail" class="form-control" placeholder="请输入详细自提地址，如一号楼101室" value="<{if $row && $row['asc_address_detail']}><{$row['asc_address_detail']}><{/if}>">
            </div>
        </div>
        <div class="form-group" style="display: none">
            <label for="">送货地址</label>
            <div class="control-group">
                <input id="asc_post_address" class="form-control" placeholder="请输入配送地址" value="<{if $row && $row['asc_post_address']}><{$row['asc_post_address']}><{/if}>">
            </div>
        </div>
        <div class="form-group" style="display: none">
            <label for="">社区人数</label>
            <div class="control-group">
                <input id="asc_member" class="form-control" placeholder="社区人数" value="<{if $row && $row['asc_member']}><{$row['asc_member']}><{/if}>">
            </div>
        </div>
        <div class="form-group" style="">
            <div style="display: inline-block">
                粉丝数  <span style="color: blue"><{$true_member}></span>人
            </div>
        </div>
        <div class="form-group" style="">
            <label for="">虚拟粉丝数</label>
            <div class="control-group">
                <input id="asc_fake_member" class="form-control" placeholder="虚拟粉丝数" value="<{if $row}><{$row['asc_fake_member']}><{/if}>">
            </div>
        </div>
        <div class="form-group" style="">
            <label for="">接龙次数</label>
            <div class="control-group">
                <input id="asc_sequence_num" class="form-control" placeholder="接龙次数" value="<{if $row}><{$row['asc_sequence_num']}><{/if}>">
            </div>
        </div>

    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
    <{if $seqregion == 1 && $community_verify == 1}>
    <{if $row['asc_id'] >0}>
    <p style="color: red">保存小区需管理员重新审核</p>
    <{else}>
    <p style="color: red">保存小区需管理员审核通过后，方可展示</p>
    <{/if}>
    <{/if}>
</div>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript">
    var latitude = '<{$row['asc_lat']}>'?'<{$row['asc_lat']}>':'34.77485';
    var longitude = '<{$row['asc_lng']}>'?'<{$row['asc_lng']}>':'113.72052';
    var storeAddress = '<{$row['asc_address_repalce']}>'?'<{$row['asc_address_repalce']}>':'公司地址';
    //高德地图引入
    var marker, geocoder,map = new AMap.Map('container',{
        zoom            : 11,
        keyboardEnable  : true,
        resizeEnable    : true,
        topWhenClick    : true,
        center          : [longitude,latitude]
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
                }else{
                    //获取地址失败
                }
            });
        });
    });
    //搜索地图位置
    $('.btn-map-search').on('click',function(){
        var addr     = $('#details-address').val();
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
        $('#lng').val(lng);
        $('#lat').val(lat);
        $('#details-address').val(address);
    }

    $('.btn-save').click(function(){

        var id      = $('#hid_id').val();
        var lng     = $('#lng').val();
        var lat     = $('#lat').val();
        var address = $('#details-address').val();
        var name    = $('#asc_name').val();
        var area = $('#asc_area').val();
        var code = $('#asc_code').val();
        var shopName = $('#asc_shop_name').val();
        var addressDetail = $('#asc_address_detail').val();
        var postAddress = $('#asc_post_address').val();
        var member = $('#asc_member').val();
        var fakeMember = $('#asc_fake_member').val();
        var sequenceNum = $('#asc_sequence_num').val();

        if(area == '0'){
            layer.msg("请选择所属区域");
            return;
        }
        if(!name){
            layer.msg("社区名称不能为空");
            return;
        }
        if(!shopName) {
            layer.msg("店铺名称不能为空");
            return;
        }
        if(!address || !lng || !lat){
            layer.msg("请填写并在地图中标记地址");
            return;
        }

        var data = {
                id : id,
                lng: lng,
                lat: lat,
                address: address,
                name: name,
                addressDetail : addressDetail,
                area : area,
                shopName : shopName,
                code : code,
                postAddress : postAddress,
                member : member,
                fakeMember : fakeMember,
                sequenceNum : sequenceNum
            };
        
        $('.btn-save').attr('disabled',true);
        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/sequence/communitySave',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    layer.msg(ret.em,{time:1*1000},function() {
                        window.location.href='/wxapp/sequence/communityList';
                    });
                }else{
                    $('.btn-save').attr('disabled',false);
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
