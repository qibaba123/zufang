<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
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
<{include file="../article-kind-editor.tpl"}>
<div  ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/cake/storeList" >返回</a></small> | 新增/编辑门店信息</h4>

                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['os_id']}><{else}>0<{/if}>">
                                    <input type="hidden" id="hid_isReceive" name="isReceive" value="<{if $isReceive}><{$isReceive}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <div class="row" style="margin-bottom: 10px">

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺logo图<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10" >
                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="500"  data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['os_logo']}><{$row['os_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin-left:0; width: 250px;height: 160px;">
                                                <input type="hidden" id="logo" placeholder="请上店铺logo"  class="avatar-field bg-img" name="logo" value="<{if $row && $row['os_logo']}><{$row['os_logo']}><{/if}>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="500" data-dom-id="upload-logo">修改</a>
                                            </div>

                                        </div>
                                        <div class="row" style="margin-bottom: 10px">

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺封面图片<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['os_cover']}><{$row['os_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_75_36.png<{/if}>"  width="300" style="display:inline-block;margin-left:0;">
                                                <input type="hidden" id="cover" placeholder="请上传店铺封面图"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['os_cover']}><{$row['os_cover']}><{/if}>"/>
                                                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="750" data-height="400" data-dom-id="upload-cover">修改</a>
                                            </div>

                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺分类</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <select id="category"  class="form-control">
                                                    <option value="0">无分类</option>
                                                    <{if $category_select}>
                                                        <{foreach $category_select as $val}>
                                                         <option value="<{$val['acc_id']}>" <{if $row && $row['os_category'] eq $val['acc_id']}>selected="selected"<{/if}> ><{$val['acc_title']}></option>
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
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写门店名称" required="required" value="<{if $row}><{$row['os_name']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>门店地点</label>
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

                                            <div class="form-group col-sm-8">
                                                <input type="text" class="form-control" id="addr" name="addr" placeholder="请填写详细地址" value="<{if $row}><{$row['os_addr']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-left">
                                                <input type="hidden" id="lng" name="lng" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['os_lng']}><{/if}>">
                                                <input type="hidden" id="lat" name="lat" placeholder="请在地图中标注分店位置" value="<{if $row}><{$row['os_lat']}><{/if}>">
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
                                                <label for="price"><font color="red">*</font>联系方式</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="请填写联系方式" value="<{if $row}><{$row['os_contact']}><{/if}>">
                                            </div>
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>是否是总店</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="" id="default-onoff">
                                                    <input class="ace ace-switch ace-switch-5" id="is_head" name="is_head" <{if $row && $row['os_is_head'] eq 1}>checked<{/if}>  type="checkbox">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>接待时间</label>
                                            </div>
                                            <div class="form-group col-sm-4" style="padding:0">
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="open_time" name="open_time" placeholder="请选择接待开始时间" value="<{if $row}><{$row['os_open_time']}><{else}>08:30<{/if}>">
                                                </div>
                                                <span class="col-xs-2 text-center" style="line-height:34px">~</span>
                                                <div class="col-xs-5 bootstrap-timepicker">
                                                    <input type="text" class="form-control col-xs-5" id="close_time" name="close_time" placeholder="请选择接待结束时间" value="<{if $row}><{$row['os_close_time']}><{else}>17:30<{/if}>">
                                                </div>
                                            </div>
                                            <div class="form-group col-sm-6 week-choose">
                                                <span data-week="1" <{if $row && $row['os_week_1'] eq 1}>class="active"<{/if}>>周一</span>
                                                <span data-week="2" <{if $row && $row['os_week_2'] eq 1}>class="active"<{/if}>>周二</span>
                                                <span data-week="3" <{if $row && $row['os_week_3'] eq 1}>class="active"<{/if}>>周三</span>
                                                <span data-week="4" <{if $row && $row['os_week_4'] eq 1}>class="active"<{/if}>>周四</span>
                                                <span data-week="5" <{if $row && $row['os_week_5'] eq 1}>class="active"<{/if}>>周五</span>
                                                <span data-week="6" <{if $row && $row['os_week_6'] eq 1}>class="active"<{/if}>>周六</span>
                                                <span data-week="7" <{if $row && $row['os_week_7'] eq 1}>class="active"<{/if}>>周日</span>
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <{if $appletCfg['ac_type'] == 18 || $appletCfg['ac_type'] == 13}>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">管理员账号</label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control" id="manager_mobile" name="manager_mobile" placeholder="请填写管理员账号" value="<{if $row}><{$row['os_manager_mobile']}><{/if}>">
                                            </div>
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">管理员密码
                                                    <{if $row && !$row['os_manager_password']}>
                                                    <span style="color: red">(未设置)</span>
                                                    <{elseif $row && $row['os_manager_password']}>
                                                    <span style="color: green">(已设置)</span>
                                                    <{/if}>
                                                </label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="password" autocomplete="off" class="form-control" id="manager_password" name="manager_password" placeholder="管理员密码" value="">
                                            </div>
                                            <{if $row && $row['os_id']}>
                                            <span style="color: #888;font-size: 12px">不填则为不修改</span>
                                            <{/if}>

                                        </div>
                                        <div class="space-6"></div>
                                        <{/if}>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺详情<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea class="form-control" style="width:100%;height:700px;visibility:hidden;" id = "detail" name="aptitude" placeholder="请填写资质信息"  rows="20" style=" text-align: left; resize:vertical;" >
                                                    <{$row['os_detail']}>
                                                </textarea>
                                                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                                                <input type="hidden" name="ke_textarea_name" value="aptitude" />
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
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/wxapp/cake/js/store.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
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
            initWxappRegion(1,'province','<{$row['os_province']}>');
            initWxappRegion('<{$row['os_province']}>','city','<{$row['os_city']}>');
            initWxappRegion('<{$row['os_city']}>','zone','<{$row['os_zone']}>');
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


    $('.btn-save').on('click',function(){
        saveStore();
    });
</script>
<{include file="../img-upload-modal.tpl"}>

