<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .layui-layer .container{
        width: 100%;
    }

    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
</style>
<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['es_id']}><{$row['es_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="" style="margin-right: 20px">店铺logo图（建议尺寸640*640）<font color="red">*</font></label>
            <div class="control-group" data-width="640" data-height="640"  style="height:100%;width: 100%;margin-top: 10px">
                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640"  data-dom-id="upload-es_logo" id="upload-es_logo"  src="<{if $row && $row['es_logo']}><{$row['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin-left:0; width: 100px;height: 100px;">
                <input type="hidden" id="es_logo"  class="avatar-field bg-img" name="es_logo" value="<{if $row && $row['es_logo']}><{$row['es_logo']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-es_logo">修改</a>
            </div>
        </div>
        <!--<div class="form-group" style="width: 50%;display: inline-block;border-bottom: 10px">
            <label for="" style="margin-right: 20px">营业执照<font color="red">*</font></label>
            <div class="control-group" data-width="0" data-height="0"  style="height:100%;width: 100%;display: inline">
                <img onclick="toUpload(this)" data-limit="1" data-width="0" data-height="0" data-dom-id="upload-acs_cover" id="upload-acs_cover"  src="<{if $row && $row['es_cover']}><{$row['es_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  width="300" style="display:inline-block;margin-left:0;">
                <input type="hidden" id="acs_cover"  class="avatar-field bg-img" name="acs_cover" value="<{if $row && $row['es_cover']}><{$row['es_cover']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="0" data-height="0" data-dom-id="upload-acs_cover">修改</a>
            </div>
        </div>-->

        <div class="form-group">
            <label for="" style="margin-right: 20px;width: 100%;margin-bottom: 10px">店铺幻灯图（建议尺寸750*400）<font color="red">*</font></label>
            <div id="slide-img" class="pic-box" style="display:inline-block;">
                <{foreach $slide as $key=>$val}>
                <p class="slide-p">
                    <img class="img-thumbnail col" layer-src="<{$val['ess_path']}>"  layer-pid="" src="<{$val['ess_path']}>" >
                    <span class="delimg-btn">×</span>
                    <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['ess_path']}>">
                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['ess_id']}>">
                </p>
                <{/foreach}>
            </div>
            <span onclick="toUpload(this)" data-limit="5" data-width="750" data-height="400" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
        </div>

        <div class="form-group" <{if $menuType != 'toutiao'}> style="display:none" <{/if}>>
            <label for="" style="width: 100%" >店铺类型<font color="red">*</font></label>
            <div class="control-group">
                <select name="es_shop_type" id="es_shop_type" class="form-control">
                    <option value="1" <{if $row['es_shop_type'] == 1}> selected <{/if}>>个人</option>
                    <option value="2" <{if $row['es_shop_type'] == 2}> selected <{/if}>>企业</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="" style="width: 100%" >店铺名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="es_name" placeholder="门店名称" class="form-control" name="name" value="<{if $row && $row['es_name']}><{$row['es_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="" style="width: 100%" >店铺负责人<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="es_contact" placeholder="门店名称" class="form-control" name="es_contact" value="<{if $row && $row['es_contact']}><{$row['es_contact']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺电话<font color="red">*</font></label>
            <div class="control-group">
                <input id="es_phone" class="form-control"  placeholder="店铺电话" value="<{if $row && $row['es_phone']}><{$row['es_phone']}><{/if}>">
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺类型<font color="red">*</font></label>
            <div class="control-group" id="selectCategory">

            </div>
        </div>

        <div class="form-group" <{if $menuType != 'toutiao'}>style="display: none"<{/if}>>
            <label for="">代理商</label>
            <div class="control-group">
                <select name="promoter" id="promoter" class="form-control">
                    <option value="0">请选择</option>
                    <{foreach $promoterList as $key => $val}>
                <option value="<{$val['ap_id']}>" <{if $val['ap_id']==$row['es_promoter_id']}>selected<{/if}>><{$val['ap_name']}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>


        <div class="form-group" <{if $menuType != 'toutiao'}>style="display: none"<{/if}>>
            <label for="">所在地区<font color="red">*</font></label>
            <div class="control-group">
                <select name="searchProvince" id="province" class="form-control" onchange="changeWxappProvince()" style="width: 30%;display:inline-block;margin-right: 10px">
                    <{foreach $provSelect as $key => $val}>
                <option value="<{$key}>" <{if $key==$row['es_prov']}>selected<{/if}>><{$val}></option>
                    <{/foreach}>
                </select>
                <select name="searchCity" id="city" class="form-control" onchange="changeWxappCity()" style="width: 30%;display:inline-block;margin-right: 10px">
                    <option value="0">请选择城市</option>
                </select>
                <select name="searchZone" id="zone" class="form-control" style="width: 30%;display:inline-block;margin-right: 10px">
                    <option value="0">请选择区域</option>
                </select>
            </div>
        </div>

        <div class="form-group" <{if $menuType == 'toutiao'}>style="display: none" <{/if}>>
            <label for="">店铺商圈</label>
            <div class="control-group" id="selectDistrict">

            </div>
        </div>

        <{if $row && $row['es_id']}>
        <!-- 防止jquery报错 -->
        <input type="hidden" value="0" id="es_expire_time">
        <{else}>
        <div class="form-group">
            <label for="">入驻时长<font color="red">*</font></label>
            <div class="control-group">
                <select id="es_expire_time" class="form-control"  placeholder="入驻时长" >
                    <{foreach $costList as $val}>
                    <option value="<{$val['acec_date']}>"><{$val['acec_desc']}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>
        <{/if}>
        <div class="form-group">
            <label for="">店铺标签</label>
            <div class="control-group">
                <input type="text" id="es_label" placeholder="店铺标签" class="form-control" name="label" value="<{if $row && $row['es_label']}><{$row['es_label']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">排序权重</label>
            <div class="control-group">
                <input type="number" id="es_sort" placeholder="请输入1-100的整数，越大越靠前" class="form-control" name="sort" value="<{$row['es_sort']}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">推荐店铺</label>
            <div class="control-group">
                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="es_is_recommend" id="recommend1" value="1" <{if $row && $row['es_is_recommend'] eq 1}>checked<{/if}>>
                                                                        <label for="recommend1">是</label>
                                                                    </span>
                    <span>
                                                                        <input type="radio" name="es_is_recommend" id="recommend2" value="0"  <{if !($row && $row['es_is_recommend'] eq 1)}>checked<{/if}>>
                                                                        <label for="recommend2">否</label>
                                                                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺订单抽成比例<{if $menuType == 'toutiao'}> (设置后将优先使用店铺分佣比例，支付宝/微信将会收取0.6%手续费，抽成比例务必≥0.6%) <{else}>（微信支付将会收取0.6%提现手续费，请将订单抽成比例设置为大于等于0.6%）<{/if}></label>
            <div class="control-group">
                <input type="text" id="shop_maid" placeholder="店铺标签" class="form-control" name="maid" value="<{if $row && $row['es_maid_proportion']}><{$row['es_maid_proportion']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group" <{if $menuType == 'toutiao'}> style="display:none" <{/if}>>
            <label for="">店铺收银台抽成比例</label>
            <div class="control-group">
                <input type="text" id="cash_proportion" placeholder="店铺标签" class="form-control" name="maid" value="<{if $row && $row['es_cash_proportion']}><{$row['es_cash_proportion']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group" <{if $menuType == 'toutiao'}>style="display: none" <{/if}>>
            <label for="">是否参与分销</label>
            <div class="control-group">
                <div class="radio-box">
                   <span>
                        <input type="radio" name="join_distrib" id="join_distrib1" value="1" <{if $row && $row['es_join_distrib'] eq 1}>checked<{/if}>>
                        <label for="join_distrib1">是</label>
                    </span>
                    <span>
                        <input type="radio" name="join_distrib" id="join_distrib2" value="0"  <{if !($row && $row['es_join_distrib'] eq 1)}>checked<{/if}>>
                        <label for="join_distrib2">否</label>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺人气</label>
            <div class="control-group">
                <input type="number" id="es_show_num" placeholder="店铺人气" class="form-control" name="show_num" value="<{$row['es_show_num']}>"/>
            </div>
        </div>
        <div class="form-group" <{if $menuType == 'toutiao'}> style="display:none" <{/if}>>
            <label for="">VR全景</label>
            <div class="control-group">
                <input type="text" id="es_vr_url" placeholder="VR全景链接" class="form-control" name="vr" value="<{if $row && $row['es_vr_url']}><{$row['es_vr_url']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group" <{if $menuType == 'toutiao'}>style="" <{/if}>>
            <div class="fenleinav-manage" style="padding-top: 10px;">
                <div class="input-groups" style="margin-bottom: 10px;">
                    <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                        <label>店铺地址</label>
                        <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle; float: right;">
                            <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" value="<{$row['es_lng']}>">
                            <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" value="<{$row['es_lat']}>">
                            <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                        </div>
                    </div>
                    <textarea rows="3" class="cus-input form-control" placeholder="请输入详细地址" id="details-address"><{$row['es_addr']}></textarea>
                </div>
                <div id="container" style="width: 100%;height: 300px"></div>
            </div>
        </div>
        <div class="form-group" <{if $menuType == 'toutiao'}>style="display: none" <{/if}>>
            <label for="">详细地址</label>
            <div class="control-group">
                <input type="text" id="es_addr_detail" placeholder="详细地址" class="form-control" name="label" value="<{if $row && $row['es_addr_detail']}><{$row['es_addr_detail']}><{/if}>"/>
            </div>
        </div>

        <!--抖音小程序 地址 -->
        <div class="form-group" style="display: none;" >
            <label for="">通讯地址</label>
            <div class="control-group">
                <input type="text" id="toutiao_addr" placeholder="通讯地址" class="form-control" name="label" value="<{if $row && $row['es_addr']}><{$row['es_addr']}><{/if}>"/>
            </div>
        </div>


        <div class="form-group">
            <label for="">店铺详情<font color="red">*</font></label>
            <div class="control-group">
                <textarea class="form-control" style="width:100%;height:700px;visibility:hidden;" id = "aptitude" name="aptitude" placeholder="请填写店铺详情"  rows="20" style=" text-align: left; resize:vertical;" >
                    <{$row['es_shop_detail']}>
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
<{include file="../img-upload-modal.tpl"}>
<{include file="../article-kind-editor.tpl"}>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript">
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-es_logo'){
                    $('#es_logo').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="slide-p">';
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


    var latitude = '<{$row['es_lat']}>'?'<{$row['es_lat']}>':'34.77485';
    var longitude = '<{$row['es_lng']}>'?'<{$row['es_lng']}>':'113.72052';
    var storeAddress = `<{$row['es_addr']}>` ?`<{$row['es_addr']}>` : "公司地址";
    //去除地址中的换行符 保证正常初始化
    storeAddress = storeAddress.replace(/[\n\r]/g,'');
    //高德地图引入
    var marker, geocoder,map = new AMap.Map('container',{
        center          : [longitude,latitude],
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
        var addressDetail = $('#es_addr_detail').val();
        var name    = $('#es_name').val();
        var phone   = $('#es_phone').val();
        var contact   = $('#es_contact').val();
        var cate2 = $('#category').val();
        var cate1 = $('#category').find("option:selected").parent().data('id');
        var cate2Name = $('#category').find("option:selected").text();
        var district2 = $('#district').val();
        var district1 = $('#district').find("option:selected").parent().data('id');
        var logo   = $('#es_logo').val();
        var label   = $('#es_label').val();
        var date    = $('#es_expire_time').val();
        var vr      = $('#es_vr_url').val();
        var shopMaid  = $('#shop_maid').val();
        var cashProportion  = $('#cash_proportion').val();
        var showNum   = $('#es_show_num').val();
        var isRecommend = $('input[name=es_is_recommend]:checked').val();
        var joinDistrib = $('input[name=join_distrib]:checked').val();
        var sort = $('#es_sort').val();
        var detail = $('#aptitude').val();
        var prov = $('#province').val();
        var city = $('#city').val();
        var zone = $('#zone').val();
        var toutiaoAddr = $('#toutiao_addr').val();
        var shopType = $('#es_shop_type').val();
        var promoter = $('#promoter').val();

        if(!name || !phone){
            layer.msg("店铺名称或电话不能为空");
            return;
        }

        if(!cate2){
            layer.msg("请选择店铺类型");
            return;
        }

//        if(!district2){
//            layer.msg("请选择店铺商圈");
//            return;
//        }
        var menuType = '<{$menuType}>';
        if(menuType == 'toutiao') {
            if(prov ==0 || city ==0 || zone ==0) {
                layer.msg('请选择所在地区');
                return ;
            }

        }

        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );

        var data = {
            'id' : id,
            'lng': lng,
            'lat': lat,
            'address': address,
            'addressDetail': addressDetail,
            'name': name,
            'phone': phone,
            'contact': contact,
            'cate1' : cate1,
            'cate2' : cate2,
            'cate2Name' : cate2Name,
            'district1' : district1,
            'district2' : district2,
            'label': label,
            'logo': logo,
            'date':date,
            'vr'  : vr,
            'slide-img-num' : maxNum,
            'shopMaid'      : shopMaid,
            'showNum'   : showNum,
            'isRecommend' : isRecommend,
            'sort' :sort,
            'detail':detail,
            'joinDistrib': joinDistrib,
            'cashProportion': cashProportion,
            'prov' : prov,
            'city' : city,
            'zone' : zone,
            'toutiaoAddr' : toutiaoAddr,
            'shopType' : shopType,
            'promoter' : promoter
        };
        //获得幻灯图
        var slide_count = $('.slide-p').length;
        console.log(slide_count);
        for (var i =0 ; i < slide_count ; i ++){
            data['slide_'+ i] = $("#slide_" + i).val();
            data['slide_id_'+ i] = $("#slide_id_" + i).val();
        }
        console.log(data);
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/community/saveShop',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/community/shopList';
                }else{

                }
            }
        });
    });

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    });

    var province = '<{$row['es_prov']}>';
    var city = '<{$row['es_city']}>';
    var zone = '<{$row['es_zone']}>';


    $(function () {
        initWxappRegion(province,'city',city);
        initWxappRegion(city,'zone',zone);


        selectDistrict('<{$row['es_district2']}>');
        selectCategory('<{$row['es_cate2']}>');
        function selectDistrict(df){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/ajaxDistrictList',
                'dataType'  : 'json',
                success : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        select_district(ret.data,df);
                    }
                }
            });
        }
        function select_district(data,df){
            var html = '<select id="district" name="district" class="form-control">';
            for(var i = 0; i < data.length ; i++){
                var son = data[i].secondItem;
                html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
                for(var s = 0 ; s < son.length ; s ++){
                    var sel = '';
                    if(df == son[s].id){
                        sel = 'selected';
                    }
                    html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
                }

                html += '';
                html += '</optgroup>';
            }
            html += '</select>';
//            console.log(html);
            $('#selectDistrict').html(html);
        }

        function selectCategory(df){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/ajaxCategoryList',
                'dataType'  : 'json',
                success : function(ret){
                    console.log(ret);
                    if(ret.ec == 200){
                        select_category(ret.data,df);
                    }
                }
            });
        }
        function select_category(data,df){
            var html = '<select id="category" name="category" class="form-control">';
            for(var i = 0; i < data.length ; i++){
                var son = data[i].secondItem;
                html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
                for(var s = 0 ; s < son.length ; s ++){
                    var sel = '';
                    if(df == son[s].id){
                        sel = 'selected';
                    }
                    html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
                }

                html += '';
                html += '</optgroup>';
            }
            html += '</select>';
//            console.log(html);
            $('#selectCategory').html(html);
        }
    });


</script>