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

    .panel-body{
        padding: 0;
    }

    .control-group{
        margin-left: 18%;
    }

    .panel{
        max-width: 300px;
        float: left;
    }

    .close {
        font-size: 30px;
        line-height: 50px;
        margin: 0 10px;
    }

    .panel-group .panel+.panel {
        margin-top: 0;
    }

</style>

<div  ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-sm-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="/wxapp/meal/storeList" >返回</a></small> | 新增/编辑门店信息</h4>

                        </div>
                        <div class="widget-body">
                            <div class="widget-main">
                                <form class="form-inline container" id="activity-form"  enctype="multipart/form-data">
                                    <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['ams_id']}><{else}>0<{/if}>">
                                    <input type="hidden" id="hid_esId" name="esId" value="<{if $row}><{$row['ams_es_id']}><{else}>0<{/if}>">
                                    <div style="overflow:hidden">
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>门店封面图片</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <div>
                                                    <img onclick="toUpload(this)" data-limit="1" data-width="450" data-height="450"  data-dom-id="upload-avatar" id="upload-avatar"  src="<{if $row && $row['es_logo']}><{$row['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" style="display:inline-block;margin-left:0; width: 150px;height: 150px;">
                                                    <input type="hidden" id="avatar"  class="avatar-field bg-img" name="ams_avatar" placeholder="请上传店铺图片" value="<{if $row && $row['es_logo']}><{$row['es_logo']}><{/if}>" />
                                                    <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="450" data-height="450" data-dom-id="upload-avatar">修改</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">门店幻灯图（建议尺寸750*300）</label>
                                            </div>
                                            <div class="form-group col-sm-10">
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
                                                <span onclick="toUpload(this)" data-limit="8" data-width="750" data-height="300" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                                                <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>门店名称</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="name" name="name" placeholder="请填写门店名称" required="required" value="<{if $row}><{$row['es_name']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">门店编号</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="store_number" name="store_number" placeholder="请填写门店编号" value="<{if $row}><{$row['ams_store_number']}><{/if}>">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="">店铺类型<font color="red">*</font></label>
                                            </div>
                                            <div class="form-group col-sm-10" id="selectCategory">

                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>营业时间</label>
                                            </div>
                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control time" id="open_time" name="open_time" onclick="" placeholder="请填写营业时间" value="<{if $row}><{$row['ams_open_time']}><{/if}>">
                                            </div>

                                            <!--<div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>开业时间</label>
                                            </div>-->

                                            <div class="form-group col-sm-3">
                                                <input type="text" class="form-control time" id="close_time" name="close_time" onclick="" placeholder="请填写营业时间" value="<{if $row}><{$row['ams_close_time']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>店铺订单抽成比例</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" id="shop_maid" placeholder="店铺订单抽成比例" class="form-control" name="maid" value="<{if $row && $row['es_maid_proportion']}><{$row['es_maid_proportion']}><{/if}>"/>
                                                <label for="">（微信支付将会收取0.6%提现手续费，请将订单抽成比例设置为大于等于0.6%）</label>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>店铺收银台抽成比例</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" id="cash_proportion" placeholder="店铺订单抽成比例" class="form-control" name="maid" value="<{if $row && $row['es_cash_proportion']}><{$row['es_cash_proportion']}><{/if}>"/>
                                                <label for=""></label>
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name">VR全景</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="vr" name="vr" placeholder="请填写VR全景链接" value="<{if $row}><{$row['ams_vr_url']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div <{if $curr_shop['s_id'] != 4286 && $curr_shop['s_id'] != 7449}>style="display:none;"<{/if}>>
                                            <div class="row">
                                                <div class="form-group col-sm-2 text-right">
                                                    <label for="name">自动接单</label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='auto_receive_order' type='checkbox' <{if $row['es_auto_receive_order'] == 1}>checked<{/if}>>
                                                    <label class='tgl-btn' for='auto_receive_order'></label>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="space-6"></div>

                                            <div class="row">
                                                <div class="form-group col-sm-2 text-right">
                                                    <label for="name">开启跑腿配送</label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                <span class='tg-list-item'>
                                                    <input class='tgl tgl-light' id='shop_legwork_open' type='checkbox' <{if $shopLegworkCfg['aolc_open'] == 1}>checked<{/if}>>
                                                    <label class='tgl-btn' for='shop_legwork_open'></label>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="space-6"></div>

                                            <div class="row">
                                                <div class="form-group col-sm-2 text-right">
                                                    <label for="name">跑腿appid</label>
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <input type="text" class="form-control" name="shop_legwork_appid" id="shop_legwork_appid" value="<{$shopLegworkCfg['aolc_appid']}>">
                                                </div>
                                                <div class="form-group col-sm-5">
                                                    <span class="btn btn-xs btn-primary" style="cursor: pointer" data-appid="<{$legworkCfg['aolc_appid']}>" onclick="useAppid(this)">
                                                        使用当前appid
                                                    </span>
                                                    <span style="color: red;padding-left: 10px">
                                                    当前跑腿appid：<{if $legworkCfg['aolc_appid']}><{$legworkCfg['aolc_appid']}><{else}>无<{/if}>
                                                </span>
                                                </div>
                                            </div>
                                            <div class="space-6"></div>
                                        </div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>详细地址</label>
                                            </div>

                                            <div class="form-group col-sm-8">
                                                <input type="text" class="form-control" id="address" name="address" placeholder="请填写详细地址" value="<{if $row}><{$row['ams_address']}><{/if}>">
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

                                        <{if !$row['ams_id']}>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>管理员姓名</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <input type="text" class="form-control" id="manage_name" name="manage_name" placeholder="请填写管理员姓名" required="required" value="">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>管理员手机号</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <input type="text" class="form-control" id="manage_mobile" name="manage_mobile" placeholder="请填写管理员手机号" required="required" value="">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>管理员密码</label>
                                            </div>
                                            <div class="form-group col-sm-2">
                                                <input type="password" autocomplete="off" class="form-control" id="manage_password" name="manage_password" placeholder="请填写管理员密码" value="">
                                            </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <{/if}>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>联系方式</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <input type="text" class="form-control" id="contact" name="contact" placeholder="请填写联系方式" value="<{if $row}><{$row['ams_contact']}><{/if}>">
                                            </div>

                                        </div>

                                        <div class="space-6"></div>

                                         <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>人均消费(元)</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="average_spend" name="average_spend" placeholder="请填写人均消费" value="<{if $row}><{$row['ams_average_spend']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>最低起送金额(元)</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="post_limit" name="post_limit" placeholder="请填写最低起送金额" value="<{if $row}><{$row['ams_post_limit']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>配送费(元)</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="post_fee" name="post_fee" placeholder="请填写配送费" value="<{if $row}><{$row['ams_post_fee']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>配送范围(千米)</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="post_range" name="post_range" placeholder="请填写配送范围" value="<{if $row}><{$row['ams_post_range']}><{/if}>">
                                            </div>
                                        </div>

                                        <{if $curr_shop['s_id'] == 7449}>
                                        <div class="space-6"></div>
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>跑腿商家承担运费比例</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="share_post_ratio" name="share_post_ratio" placeholder="请填写家承担运费比例" value="<{if $row}><{$row['es_share_post_ratio']}><{/if}>">
                                            </div>
                                        </div>
                                        <{/if}>

                                        <div class="space-6"></div>

                                         <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="name"><font color="red">*</font>平均配送时间(分钟)</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="avg_send_time" name="avg_send_time" placeholder="请填写平均配送时间" value="<{if $row}><{$row['ams_avg_send_time']}><{/if}>">
                                            </div>
                                             <div class="form-group col-sm-2 text-right">
                                                 <label for="name">餐具费（单位：每人，0表示免费）</label>
                                             </div>
                                             <div class="form-group col-sm-4">
                                                 <input type="text" class="form-control" id="tableware_fee" name="tableware_fee" placeholder="请填写餐具费用" value="<{if $row}><{$row['ams_tableware_fee']}><{/if}>">
                                             </div>
                                        </div>
                                        <div class="space-6"></div>
                                        <!--
                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>装修时间</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="fitment_time" name="fitment_time" onclick="chooseDate()" placeholder="请填写装修时间" value="<{if $row}><{$row['ams_fitment_time']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>开业时间</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="open_time" name="open_time" onclick="chooseDate()" placeholder="请填写开业时间" value="<{if $row}><{$row['ams_open_time']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>楼层高度</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="floor" name="floor" placeholder="请填写楼层高度" value="<{if $row}><{$row['ams_floor']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>房间数量</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="room" name="room" placeholder="请填写房间数量" value="<{if $row}><{$row['ams_room']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">临近地铁站/公交站名称</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="subway_name" name="subway_name" placeholder="请填写临近地铁站名称" value="<{if $row}><{$row['ams_subway_name']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>距离</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="number" class="form-control" id="subway_distance" name="subway_distance" placeholder="请填写临近地铁站距离/km" value="<{if $row}><{$row['ams_subway_distance']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price">临近火车站/汽车站名称</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="text" class="form-control" id="railway_name" name="railway_name" placeholder="请填写临近火车站名称" value="<{if $row}><{$row['ams_railway_name']}><{/if}>">
                                            </div>

                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>距离</label>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <input type="number" class="form-control" id="railway_distance" name="railway_distance" placeholder="请填写临近火车站距离/km" value="<{if $row}><{$row['ams_railway_distance']}><{/if}>">
                                            </div>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>提供服务</label>
                                            </div>
                                            <div class="control-group">
                                                <div class="panel-group" id="panel-group">
                                                    <{foreach $list as $key=>$val}>
                                                    <div class="panel" data-sort="format_id_<{$key}>">
                                                        <input type="hidden" name="format_id_<{$key}>" value="<{$val['gf_id']}>">
                                                        <div class="panel-collapse">
                                                            <a href="javascript:;" class="close" data-hid-id="<{$val['gf_id']}>" onclick="removeGuige(this)">×</a>
                                                            <div class="panel-body">
                                                                <div>
                                                                    <div class="input-group">
                                                                        <label for="" style="padding:0"  class="input-group-addon">
                                                                            <div>
                                                                                <img style="width: 50px" src="<{$val['ams_icon']}>"  alt="导航图标" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-icon<{$key}>" id="upload-icon<{$key}>">
                                                                                <input type="hidden" class="avatar-field bg-img service_icon" value="<{$val['ams_icon']}>" id="icon<{$key}>"  name="format_icon_<{$key}>" />
                                                                            </div>
                                                                        </label>
                                                                        <input type="text" name="format_name_<{$key}>" style="height: 52px" class="form-control guigeName" value="<{$val['ams_name']}>">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <{/foreach}>
                                                </div>
                                                <a href="javascript:;" class="ui-btn" onclick="addGuige()" style="    margin: 13px 0;"><i class="icon-plus"></i>添加服务</a>
                                                <input type="hidden" name="format-num" id="format-num" value="<{$serviceNum}>">
                                                <input type="hidden" name="format-sort" id="format-sort" value="<{$formatSort}>">
                                            </div>

                                        </div>

                                        <div class="space-6"></div>-->

                                        <div class="row">
                                            <div class="form-group col-sm-2 text-right">
                                                <label for="price"><font color="red">*</font>门店简介</label>
                                            </div>
                                            <div class="form-group col-sm-10">
                                                <textarea name="brief" class="form-control" id="brief" rows="5"><{$row['ams_brief']}></textarea>
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
<script type="text/javascript" src="/public/common/js/province-city-area.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    var town = '<{$row['ams_zone']}>';
    $(function(){
        selectCategory('<{$row['ams_cate2']}>');

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

                        var province    = result.regeocode.addressComponent.province;
                        var city       = result.regeocode.addressComponent.city;
                        var zone        = result.regeocode.addressComponent.district;
                        var township    =  result.regeocode.addressComponent.township;
                        var street      =  result.regeocode.addressComponent.street;
                        var streetNumber=  result.regeocode.addressComponent.streetNumber;
                        var neighborhood=  result.regeocode.addressComponent.neighborhood;
                        town = zone;
                        var adds = province + city + zone + township + street + streetNumber + neighborhood;
                        $('#address').val(adds);
                    }else{
                        //获取地址失败
                    }
                });
            });
        });
        //搜索地图位置
        $('.btn-map-search').on('click',function(){
            var addr     = $('#address').val();
            if(addr){
                var address = addr;
                console.log(address);
                AMap.service('AMap.Geocoder',function(){ //回调函数
                    //实例化Geocoder
                    geocoder = new AMap.Geocoder({
                        'city'   : '', //城市，默认：“全国”
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
                            $('#address').val(result.geocodes[0].formattedAddress);
                            town = result.geocodes[0].addressComponent.district;
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


    $('.btn-save').on('click',function(){
        var is_head  = $('#is_head:checked').val();
        var data = {};
        var check = new Array('name','store_number','address','contact','lng','lat','brief','avatar','average_spend','post_fee','post_limit','post_range','avg_send_time','open_time','close_time');
        for(var i=0 ; i < check.length; i++){
            var temp = $('#'+check[i]).val();
            if(temp){
                data[check[i]] = temp;
            }else{
                var msg = $('#'+check[i]).attr('placeholder');
                if(!msg){
                    layer.msg('请上传店铺图片');
                }else{
                    layer.msg(msg);
                }
                return false;
            }
        }
//        var imgArr = [];
//        $('#slide-img').find("img").each(function () {
//		   var _this = $(this);
//		   imgArr.push(_this.attr('src'))
//		});
//        data.imgArr  = imgArr;
        var id       = $('#hid_id').val();
        var esId     = $('#hid_esId').val();
        var tableware_fee     = $('#tableware_fee').val();
        var shopMaid  = $('#shop_maid').val();
        var cashProportion  = $('#cash_proportion').val();
        var cate2 = $('#category').val();
        var cate1 = $('#category').find("option:selected").parent().data('id');
        var shop_legwork_appid  = $('#shop_legwork_appid').val();
        var sharePostRatio  = $('#share_post_ratio').val();
        var auto_receive_order  = $('#auto_receive_order:checked').val();
        var shop_legwork_open  = $('#shop_legwork_open:checked').val();
        if(id == 0){

            var check_manage = new Array('manage_name','manage_password','manage_mobile');
            for(var j=0 ; j < check_manage.length; j++){
                var temp = $('#'+check_manage[j]).val();
                if(temp){
                    data[check_manage[j]] = temp;
                }else{
                    var msg_manage = $('#'+check_manage[j]).attr('placeholder');
                    layer.msg(msg_manage);
                    return false;
                }
            }
        }
        data.id      = id;
        data.esId    = esId;
        data.zone    = town;
        data.cate1   = cate1;
        data.cate2   = cate2;
        data.slideImgNum = maxNum;
        data.shopMaid = shopMaid;
        data.cashProportion = cashProportion;
        data.tableware_fee = tableware_fee;
        data.autoReceiveOrder = auto_receive_order;
        data.shopLegworkAppid = shop_legwork_appid;
        data.shopLegworkOpen  = shop_legwork_open;
        data.sharePostRatio  = sharePostRatio;

        var index    = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });

        //获得幻灯图
        var slide_count = $('.slide-p').length;
        console.log(slide_count);
        for (var i =0 ; i < slide_count ; i ++){
            data['slide_'+ i] = $("#slide_" + i).val();
            data['slide_id_'+ i] = $("#slide_id_" + i).val();
        }

        data.vr_url = $('#vr').val();
        console.log(data);
//        return;
        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/meal/saveStore',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    window.location.href='/wxapp/meal/storeList';
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    });

    /*移除规格*/
    function removeGuige(elem){
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
    /*添加规格*/
    function addGuige(){
        //var id = $("#panel-group .panel").length+1;
        // $("#panel-template .guige").text("规格#"+id);
        //$("#panel-template input.guigeName").attr("value","规格#"+id);
        var key  = parseInt($('#format-num').val());
        console.log(key);
        key ++;
        var html = get_format_html(key);//$("#panel-template").html();
        $("#panel-group").append(html);
        $('#format-num').val(key);
        $("#g_price").attr("readonly",true);
        $("#g_stock").attr("readonly",true);
        formatSort();
        sortString();
        setTimeout(function(){
            //卸载掉原来的事件
            $(".cropper-box").unbind();
            new $.CropAvatar($("#crop-avatar"));
        },500);
    }

    function get_format_html(key){
        var key = key - 1;
        var _html   = '<div class="panel" data-sort="format_id_'+key+'">';
        _html       += '<div class="panel-collapse">';
        _html       += '<a href="javascript:;" class="close" onclick="removeGuige(this)">×</a>';
        _html       += '<div class="panel-body">';

        _html       += '<input type="hidden" name="format_id_'+key+'" value="0">';

        _html       += '<div>';
        _html       += '<div class="input-group">';
        _html       += '<label for="" style="padding:0"  class="input-group-addon"><div><img style="width: 50px" src="/public/manage/img/zhanwei/fenleinav.png"  alt="导航图标" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-icon'+key+'" id="upload-icon'+key+'"><input type="hidden" class="avatar-field bg-img service_icon" id="icon'+key+'"  name="format_icon_'+key+'" /></div></label>';
        _html       += '<input type="text" class="form-control guigeName" style="height:52px" name="format_name_'+key+'"  value="服务#'+(key+1)+'">';
        _html       += '</div></div>';

        _html       += '</div><!---panel-body----> </div><!---panel-collapse----></div><!---panel---->';
        return _html;
    }

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
        console.log(sortString);
    }

    var nowdate = new Date();
    var year = nowdate.getFullYear(),
            month = nowdate.getMonth()+1,
            date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd',
        });
    }

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
</script>
<script>
       /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                console.log('work');
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-avatar'){
                    $('#avatar').val(allSrc[0]);
                }
            }else {
                var img_html = '';
                var cur_num = $('#' + nowId + '-num').val();
                for (var i = 0; i < allSrc.length; i++) {
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="slide-p">';
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
                    layer.msg('幻灯图最多' + maxNum + '张');
                }
            }
        }
    }

    function useAppid(e) {
        $('#shop_legwork_appid').val($(e).data('appid'));
    }
</script>


