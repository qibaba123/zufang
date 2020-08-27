<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
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
    #shop-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #shop-tr td img{
        width: 60px;
        height: 60px;
    }
    #shop-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    .table-responsive{
        width: 100%;
    }
    .modal-body {
        overflow: auto;
        padding: 10px 15px;
        max-height: 500px;
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
        <div class="form-group" style="width: 44%;display: inline-block;float: left;">
            <label for="" style="margin-right: 20px">店铺logo图<font color="red">*</font></label>
            <div class="control-group" data-width="200" data-height="200"  style="height:100%;width: 100%;">
                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200"  data-dom-id="upload-acs_img" id="upload-acs_img"  src="<{if $row && $row['acs_img']}><{$row['acs_img']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin-left:0; width: 133px;height: 133px;">
                <input type="hidden" id="acs_img"  class="avatar-field bg-img" name="acs_img" value="<{if $row && $row['acs_img']}><{$row['acs_img']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-acs_img">修改</a>
            </div>
        </div>
        <div class="form-group" style="width: 50%;display: inline-block;border-bottom: 10px">
            <label for="" style="margin-right: 20px">店铺封面图片<font color="red">*</font></label>
            <div class="control-group" data-width="750" data-height="400"  style="height:100%;width: 100%;display: inline">
                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-acs_cover" id="upload-acs_cover"  src="<{if $row && $row['acs_cover']}><{$row['acs_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  width="300" style="display:inline-block;margin-left:0;">
                <input type="hidden" id="acs_cover"  class="avatar-field bg-img" name="acs_cover" value="<{if $row && $row['acs_cover']}><{$row['acs_cover']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-acs_cover">修改</a>
            </div>
        </div>
        <div class="form-group">
            <label for="" style="width: 100%" >店铺名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="acs_name" placeholder="门店名称" class="form-control" name="img" value="<{if $row && $row['acs_name']}><{$row['acs_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺电话<font color="red">*</font></label>
            <div class="control-group">
                <input id="acs_mobile" class="form-control"  placeholder="门店电话" value="<{if $row && $row['acs_mobile']}><{$row['acs_mobile']}><{/if}>">
            </div>
        </div>
        <{if $row && $row['acs_id']}>
        <!-- 防止jquery报错 -->
        <input type="hidden" value="0" id="acs_expire_time">
        <{else}>
        <div class="form-group">
            <label for="">入驻时长<font color="red">*</font></label>
            <div class="control-group">
                <select id="acs_expire_time" class="form-control"  placeholder="入驻时长" >
                    <{foreach $costList as $val}>
                    <option value="<{$val['cac_data']}>"><{$val['cac_data']}>个月</option>
                    <{/foreach}>
                </select>
            </div>
        </div>
        <{/if}>
        <div class="form-group">
            <label for="">店铺标签</label>
            <div class="control-group">
                <input type="text" id="acs_label" placeholder="店铺标签" class="form-control" name="img" value="<{if $row && $row['acs_label']}><{$row['acs_label']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">VR全景</label>
            <div class="control-group">
                <input type="text" id="acs_vr_url" placeholder="VR全景链接" class="form-control" name="vr" value="<{if $row && $row['acs_vr_url']}><{$row['acs_vr_url']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺简介</label>
            <div class="control-group">
                <textarea class="form-control" id="acs_brief" cols="30" rows="5"><{if $row && $row['acs_brief']}><{$row['acs_brief']}><{/if}></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="">排序权重</label>
            <div class="control-group">
                <input type="text" id="acs_sort" placeholder="请填写1-100之间的整数，值越大排序越靠前" class="form-control" value="<{if $row && $row['acs_sort']}><{$row['acs_sort']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">列表标签</label>
            <div class="control-group">
                <input type="text" id="acs_list_label" placeholder="店铺列表标签，最多4个字" class="form-control" value="<{if $row && $row['acs_list_label']}><{$row['acs_list_label']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">推荐店铺<font color="red">*</font></label>
            <div class="control-group">
                <div class="radio-box">
                                                                    <span>
                                                                        <input type="radio" name="acs_is_recommend" id="recommend1" value="1" <{if $row && $row['acs_is_recommend'] eq 1}>checked<{/if}>>
                                                                        <label for="recommend1">是</label>
                                                                    </span>
                    <span>
                                                                        <input type="radio" name="acs_is_recommend" id="recommend2" value="0"  <{if !($row && $row['acs_is_recommend'] eq 1)}>checked<{/if}>>
                                                                        <label for="recommend2">否</label>
                                                                    </span>
                </div>
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
            <label for="">增加店铺浏览量（表示对当前店铺增加浏览量）<span style="color: red">当前：<{$row['acs_show_num']}></span></label>
            <div class="control-group">
                <input type="number" id="show_num" placeholder="增加浏览量" class="form-control" name="showNum" value=""/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺订单抽成比例（微信支付将会收取0.6%提现手续费，请将订单抽成比例设置为大于等于0.6%）</label>
            <div class="control-group">
                <input type="text" id="shop_maid" placeholder="店铺订单抽成比例" class="form-control" name="maid" value="<{if $enterShop && $enterShop['es_maid_proportion']}><{$enterShop['es_maid_proportion']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">店铺收银台抽成比例</label>
            <div class="control-group">
                    <input type="text" id="cashProportion" placeholder="店铺收银台抽成比例" class="form-control" name="maid" value="<{if $enterShop && $enterShop['es_cash_proportion']}><{$enterShop['es_cash_proportion']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">是否参与分销</label>
            <div class="control-group">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="join_distrib" id="join_distrib1" value="1" <{if $enterShop && $enterShop['es_join_distrib'] eq 1}>checked<{/if}>>
                        <label for="join_distrib1">是</label>
                    </span>
                    <span>
                        <input type="radio" name="join_distrib" id="join_distrib2" value="0"  <{if !($enterShop && $enterShop['es_join_distrib'] eq 1)}>checked<{/if}>>
                        <label for="join_distrib2">否</label>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group" style="width: 50%;display: inline-block;border-bottom: 10px">
            <div><label for="" style="margin-right: 20px">店铺小程序码</label></div>
            <div class="control-group" data-width="400" data-height="400"  style="height:100%;width: 100%;display: inline">
                <img onclick="toUpload(this)" data-limit="1" data-width="400" data-height="400" data-dom-id="upload-acs_code_cover" id="upload-acs_code_cover"  src="<{if $row && $row['acs_code_cover']}><{$row['acs_code_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="300" style="display:inline-block;margin-left:0;width: 50%;">
                <input type="hidden" id="acs_code_cover"  class="avatar-field bg-img" name="acs_code_cover" value="<{if $row && $row['acs_code_cover']}><{$row['acs_code_cover']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="400" data-height="400" data-dom-id="upload-acs_code_cover">修改</a>
            </div>
        </div>
        <div class="form-group">
            <div class="fenleinav-manage" style="padding-top: 10px;">
                <div class="input-groups" style="margin-bottom: 10px;">
                    <div style="width: 100%;overflow: hidden;padding: 0 5px;margin-bottom: 10px;">
                        <label>店铺地址</label>
                        <div class="text-right" style="width: 24%;display: inline-block;vertical-align: middle; float: right;">
                            <input type="hidden" id="lng" name="lng" placeholder="请输入地址经度" value="<{$row['acs_lng']}>">
                            <input type="hidden" id="lat" name="lat" placeholder="请输入地址纬度" value="<{$row['acs_lat']}>">
                            <label class="btn btn-blue btn-sm btn-map-search"> 搜索地图 </label>
                        </div>
                    </div>
                    <textarea rows="3" class="cus-input form-control" placeholder="请输入详细地址" id="details-address"><{$row['acs_address']}></textarea>
                </div>
                <div id="container" style="width: 100%;height: 300px"></div>
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
        <div class="form-group" style="margin-bottom: 50px;">
            <label for="">推荐店铺</label>
            <div class="group-info">
                <div class="form-group">
                    <div class="part" style="overflow: hidden;padding-bottom: 10px">
                        <div style="width: 18%;float: right;">
                            <label for="">
                                <span>
                                    <button class="btn btn-sm btn-primary goods-button btn-add-shop" data-id="<{$row['acs_id']}>">添加</button>
                                    <button class="btn btn-sm btn-danger goods-button btn-remove-all">清空</button>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="topic goods-selected-list">
                        <{if $shopsList}>
                        <{foreach $shopsList as $shop}>
                        <div class='goods-name goods-selected' sid='<{$shop['acs_id']}>' ><div class='goods-selected-name'><{$shop['acs_name']}></div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>
                        <{/foreach}>
                        <{else}>
                        <span class="goods-name goods-none" style="font-weight: bold;color: #38f">
                            无推荐店铺
                        </span>
                        <{/if}>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
</div>

<div id="shop-modal"  class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">推荐店铺</h4>
            </div>
            <div class="modal-body">
                <div class="good-search" style="margin-top: 20px">
                    <div class="input-group">
                        <input type="text" id="keyword" class="form-control" placeholder="搜索店铺">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchShopPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                    </div>
                </div>
                <hr>
                <table  class="table-responsive">
                    <input type="hidden" id="mkType" value="">
                    <input type="hidden" id="currId" value="">
                    <thead>
                    <tr>
                        <th>店铺图片</th>
                        <th style="text-align:left">店铺名称</th>
                        <th>操作</th>
                    </thead>

                    <tbody id="shop-tr">
                    <!--商品列表展示-->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ajax-pages" id="footer-page">
                <!--存放分页数据-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript">
    var latitude = '<{$row['acs_lat']}>'?'<{$row['acs_lat']}>':'34.77485';
    var longitude = '<{$row['acs_lng']}>'?'<{$row['acs_lng']}>':'113.72052';
    var storeAddress = '<{$row['acs_address']}>'?'<{$row['acs_address']}>':'公司地址';
    //高德地图引入
    //var lngFloat = parseFloat(longitude);
    //var latFloat = parseFloat(latitude);
    //var position = new AMap.LngLat(lngFloat, latFloat);
    var marker, geocoder,map = new AMap.Map('container',{
        zoom            : 11,
        keyboardEnable  : true,
        resizeEnable    : true,
        topWhenClick    : true,
        //center          : position
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

    $('.btn-save').click(function(event){
        var id      = $('#hid_id').val();
        var lng     = $('#lng').val();
        var lat     = $('#lat').val();
        var address = $('#details-address').val();
        var name    = $('#acs_name').val();
        var mobile  = $('#acs_mobile').val();
        var category = $('#acs_category').val();
        var content = $('#aptitude').val();
        var cover   = $('#acs_cover').val();
        var img     = $('#acs_img').val();
        var openTime = $('#start_time').val()+'-'+$('#end_time').val();
        var label   = $('#acs_label').val();
        var brief   = $('#acs_brief').val();
        var code    = $('#acs_code_cover').val();
        var date    = $('#acs_expire_time').val();
        var vr      = $('#acs_vr_url').val();
        var showNum = $('#show_num').val();
        var showMaid = $('#shop_maid').val();
        var cashProportion = $('#cashProportion').val();
        var isRecommend = $('input[name=acs_is_recommend]:checked').val();
        var joinDistrib = $('input[name=join_distrib]:checked').val();
        var sort    = $('#acs_sort').val();
        var listLabel    = $('#acs_list_label').val();
        if(!name || !mobile){
            layer.msg("店铺名称或电话不能为空");
            return;
        }

        if(!cover || !img){
            layer.msg("请上传店铺图片");
            return;
        }

        if(!category){
            layer.msg("请选择店铺类型");
            return;
        }
        var sids     = [];
        //保存推荐商品
        $('.goods-selected').each(function () {
            var sid = $(this).attr('sid');
            sids.push(sid)
        });
        var load_index = layer.load(
                2, {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );

        var data = {
            id : id,
            lng: lng,
            lat: lat,
            address: address,
            name: name,
            mobile: mobile,
            category: category,
            content: content,
            cover: cover,
            openTime: openTime,
            label: label,
            img: img,
            brief: brief,
            code:code,
            date:date,
            vr  : vr,
            showNum : showNum,
            showMaid : showMaid,
            isRecommend : isRecommend,
            cashProportion : cashProportion,
            sort : sort,
            listLabel : listLabel,
            joinDistrib: joinDistrib,
            sids : sids
        };
        //防止重复点击
        $('.btn-save').attr('disabled','disabled');
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/city/saveAreaShop',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/city/shopList';
                    //$('.btn-save').removeAttr('disabled');
                }else{
                    layer.msg(ret.em);
                    $('.btn-save').removeAttr('disabled');
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

    //管理商品
    $('.btn-add-shop').on('click',function(){
        $('#shop-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');

        $('.th-weight').hide();

        $('#shop-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchShopPageData(currPage);
    });

    function fetchShopPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/selectShop',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchShopHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchShopHtml(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].acs_id+'">';
            html += '<td><img src="'+data[i].acs_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].acs_name+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-sid="'+data[i].acs_id+'" data-name="'+data[i].acs_name+'" onclick="dealShop( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#shop-tr').html(html);
    }

    //选择关联商品
    function dealShop(ele) {
        var sid = $(ele).data('sid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[sid='" +sid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' sid='"+ sid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.goods-selected-list').append(append_html);
        $('#shop-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐店铺 </span>';
            $('.goods-selected-list').html(default_html);
        }
    }

    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐店铺</span>';
        $('.goods-selected-list').html(default_html);
    });

</script>
<{include file="../img-upload-modal.tpl"}>