<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 25%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
    .modal-content-refuse{
        display: none;
    }
    .custom-reason{
        display: none;
    }
    .tips{
        display: inline-block;
        padding-top: 3px;
        color: #777;
    }
</style>

<div id="content-con">
    <div  id="mainContent" >
        <!-- 汇总信息 -->
        <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
            <div class="balance-info">
                <div class="balance-title">累计申请人数<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['total']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">待审核<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['audit']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已通过<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['pass']}></span>
                </div>
            </div>
            <div class="balance-info">
                <div class="balance-title">已拒绝<span></span></div>
                <div class="balance-content">
                    <span class="money"><{$statInfo['refuse']}></span>
                </div>
            </div>
        </div>
        <!--
        <div class="page-header">

        </div><!-- /.page-header -->
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/leaderApplyList" method="get">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container" style="width: auto !important;">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">用户名</div>
                                    <input type="text" class="form-control" name="nickname" value="<{$nickname}>"  placeholder="用户名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">会员编号</div>
                                    <input type="number" class="form-control" name="showid" value="<{$showid}>"  placeholder="会员编号">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="truename" value="<{$truename}>"  placeholder="姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">筛选</div>
                                    <select name="screenType" id="" class="form-control">
                                    <option value="1" <{if $screenType == 1}>selected<{/if}>>待审核</option>
                                    <option value="2" <{if $screenType == 2}>selected<{/if}>>已通过</option>
                                    <option value="3" <{if $screenType == 3}>selected<{/if}>>已拒绝</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 15%;right: 2%;">
                        <button type="submit" class="btn btn-green btn-sm">查询</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>头像</th>
                            <th>用户名</th>
                            <th>会员编号</th>
                            <th>用户信息</th>
                            <th>备注</th>
                            <th>审核状态</th>
                            <th>处理时间</th>
                            <th>处理备注</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['asl_id']}>">
                                <td>
                                    <img src="<{if $val['m_avatar']}><{$val['m_avatar']}><{else}>'/public/wxapp/images/applet-avatar.png'<{/if}>" alt="" style="width: 50px;border-radius:4px;">
                                </td>
                                <td><{$val['m_nickname']}></td>
                                <td><{$val['m_show_id']}></td>
                                <td>
                                    姓名：<{if $val['asl_name']}><{$val['asl_name']}><{else}>无<{/if}><br>
                                    电话：<{if $val['asl_mobile']}><{$val['asl_mobile']}><{else}>无<{/if}><br>
                                    微信：<{if $val['asl_wxcode']}><{$val['asl_wxcode']}><{else}>无<{/if}><br>
                                    <{if $val['asl_apply_community_type'] == 2}>
                                    地址：<{$val['asc_address']}><br>
                                    <span style="font-weight: bold">社区：<{$val['asc_name']}></span><br>

                                    <{if $val['asc_address_detail']}>
                                    自提地址：<{$val['asc_address_detail']}><br>
                                    <{/if}>
                                    <{if $val['asc_shop_name']}>
                                    店铺名称：<{$val['asc_shop_name']}>
                                    <{/if}>
                                    <{else}>
                                    <{if $val['asl_apply_addr']}>
                                    地址：<{$val['asl_apply_addr']}><br>
                                    <{/if}>
                                    <span style="font-weight: bold">社区：<{$val['asl_apply_community']}></span><br>
                                    <{if $val['asl_apply_addr_detail']}>
                                    自提地址：<{$val['asl_apply_addr_detail']}><br>
                                    <{/if}>
                                    <{if $val['asc_apply_shop_name']}>
                                    店铺名称：<{$val['asc_apply_shop_name']}>
                                    <{/if}>
                                    <{/if}>
                                </td>
                                <td style="max-width:150px;white-space: normal"><{$val['asl_remark']}></td>
                                <td>
                                    <{if $val['asl_status'] == 2}>
                                    <span style="color: green;"><{$statusNote[$val['asl_status']]}></span>
                                    <{elseif $val['asl_status'] == 3}>
                                    <span style="color:red"><{$statusNote[$val['asl_status']]}></span>
                                    <{else}>
                                    <{$statusNote[$val['asl_status']]}>
                                    <{/if}>
                                </td>
                                <td><{if $val['asl_handle_time']}><{date('Y-m-d H:i',$val['asl_handle_time'])}><{/if}></td>
                                <td style="max-width: 150px">
                                    <{$val['asl_handle_remark']}>
                                </td>
                                <td>
                                    <{if $val['asl_status'] eq 1}>
                                    <a class="handle-apply" href="#" data-toggle="modal" data-target="#myModal"  data-id="<{$val['asl_id']}>" data-province="<{$val['asl_apply_province']}>" data-city="<{$val['asl_apply_city']}>" data-zone="<{$val['asl_apply_zone']}>" data-areaid="<{$val['asl_apply_area_id']}>" data-areaname="<{$val['asl_apply_area']}>" data-comname="<{$val['asl_apply_community']}>" data-comid="<{$val['asl_apply_community_id']}>" data-areatype="<{$val['asl_apply_area_type']}>" data-comtype="<{$val['asl_apply_community_type']}>" data-name="<{$val['asl_name']}>" data-wxcode="<{$val['asl_wxcode']}>" data-mobile="<{$val['asl_mobile']}>" data-addr="<{$val['asl_apply_addr']}>" data-addrdetail="<{$val['asl_apply_addr_detail']}>" data-lng="<{$val['asl_apply_lng']}>" data-lat="<{$val['asl_apply_lat']}>" data-shopname="<{$val['asl_apply_shop_name']}>">处理</a>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>

                        <!--<tr><td colspan="9" class='text-right'></td></tr>-->

                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<{if $showPage != 0 }>
<div style="height: 53px;margin-top: 15px;">
    <div class="bottom-opera-fixd">
        <div class="bottom-opera">	            
            <div class="bottom-opera-item" style="text-align:center;">
                <div class="page-part-wrap"><{$pagination}></div>
            </div>
        </div>
    </div>
</div>
<{/if}>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 660px;">
        <input type="hidden" id="hid_id" >
        <div class="modal-content modal-content-normal">
            <input type="hidden" id="com_type" >
            <input type="hidden" id="area_type" >
            <input type="hidden" id="hid_lng" >
            <input type="hidden" id="hid_lat" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请处理
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px !important;">
                <!--
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">审核状态：</label>
                    <div class="col-sm-10">
                        <select name="status" id="status" class="form-control">
                            <option value="2">通过</option>
                            <option value="3">拒绝</option>
                        </select>
                    </div>
                </div>
                -->
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">申请人：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asl_name">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">手机号：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asl_mobile">
                    </div>
                </div>
                <div class="form-group row" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">微信号：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asl_wxcode">
                    </div>
                </div>
                <div class="form-group row area-choose area-choose-1" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">街道地区：</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="province" name="province" onchange="changeWxappProvince()" placeholder="请选择省份">
                            <option value="">选择省份</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <select class="form-control" id="city" name="city" onchange="changeWxappCity()" placeholder="请选择城市">
                        <option value="">选择城市</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <select class="form-control" id="zone" name="zone" placeholder="请选择地区">
                            <option value="">选择地区</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row area-choose area-choose-1" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">街道名称：</label>
                    <div class="col-sm-10">
                        <input id="asl_apply_area" type="text" class="form-control" placeholder="请填写区域名称" style="height:auto!important"/>
                        <span class="tips">不填代表不添加街道</span>
                    </div>
                </div>
                <div class="form-group row area-choose area-choose-2" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">街道：</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="asl_apply_area_id" name="asl_apply_area_id" onchange="changeArea()">
                            <option value="0">无</option>
                            <{if $areaSelect}>
                                <{foreach $areaSelect as $val}>
                                    <option value="<{$val['id']}>" ><{$val['area']}>  <{$val['name']}></option>
                                <{/foreach}>
                            <{/if}>
                        </select>
                    </div>
                </div>
                <div class="form-group row community-choose community-choose-1" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">社区名称：</label>
                    <div class="col-sm-10">
                        <input id="asl_apply_community" class="form-control" placeholder="请填写社区名称" style="height:auto!important"/>
                        <span class="tips">不填代表不添加社区</span>
                    </div>
                </div>
                <div class="form-group row community-choose community-choose-2" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">社区名称：</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="asl_apply_community_id" name="asl_apply_community_id" onchange="changeCommunity()">
                            <option value="0">无</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row community-info" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">店铺名称：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asc_shop_name">
                    </div>
                </div>

                <div class="form-group row handle-add-input" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">小区地址：</label>
                    <div class="col-sm-10">
                        <span id="com-address"></span>
                    </div>
                </div>
                <div class="form-group row community-info" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">自提地址：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asc_address_detail">
                    </div>
                </div>

                <div class="form-group row handle-add-input" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">粉丝数：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asc_fake_member">
                    </div>
                </div>

                <div class="form-group row handle-add-input" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center">接龙次数：</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="asc_sequence_num">
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">处理备注：</label>
                    <div class="col-sm-10">
                        <textarea id="market" class="form-control" rows="5" placeholder="请填写处理备注信息" style="height:auto!important"></textarea>
                    </div>
                </div>

                <div class="form-group row handle-add" style="margin-top: 10px">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num" style="text-align: center"></label>
                    <div class="col-sm-10">
                        <span style="color: red">提示：无法匹配社区，申请社区不存在！</span>
                        <button class="btn btn-xs btn-success handle-add-button">添加社区</button>
                    </div>
                </div>




            </div>
            <div class="modal-footer" >
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-danger" id="refuse-handle">
                    拒绝
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    同意
                </button>
            </div>
        </div><!-- /.modal-content -->
        <div class="modal-content modal-content-refuse">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    申请拒绝
                </h4>
            </div>
            <div class="modal-body" style="padding: 10px 15px !important;">
                <div class="form-group row">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">拒绝原因：</label>
                    <div class="col-sm-10">
                        <select name="refuse_reason" id="refuse_reason" onchange="changeReason()" class="form-control">
                            <option value="0">请选择拒绝原因</option>
                            <{foreach $refuse_reason as $key => $row}>
                            <option value="<{$key}>"><{$row}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group row custom-reason">
                    <label class="col-sm-2 control-label no-padding-right" for="qq-num">拒绝原因：</label>
                    <div class="col-sm-10">
                        <textarea id="refuse_market" class="form-control" rows="5" placeholder="请填写拒绝原因" style="height:auto!important"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer" >
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-danger" id="confirm-refuse">
                    拒绝
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/goods.js"></script>
<script>
    $('.handle-add-button').on('click',function () {
        $('.area-choose').css('display','none');
        $('.community-choose').css('display','none');
        $('.handle-add').css('display','none');

        areaType = $('#area_type').val();
        if(areaType == 2){
            $('.area-choose-2').css('display','block');
        }else{
            $('.area-choose-1').css('display','block');
        }

        $('.community-choose-1').css('display','block');
        $('.handle-add-input').css('display','block');
        $('#com_type').val(1);
    });

    $('#refuse-handle').on('click',function () {
        $('.modal-content-normal').css('display','none');
        $('.modal-content-refuse').css('display','block');
        $('.custom-reason').css('display','none');
    });


    $('.handle-apply').on('click',function () {
        // var city = 0;
        // var province = 0;
        // var zone = 0;
        $('.area-choose').css('display','none');
        $('.community-choose').css('display','none');
        $('.handle-add-input').css('display','none');
        $('.modal-content-normal').css('display','block');
        $('.modal-content-refuse').css('display','none');
        $('.custom-reason').css('display','none');

        $('#hid_id').val($(this).data('id'));
        province = $(this).data('province');
        city = $(this).data('city');
        zone = $(this).data('zone');
        var comId = $(this).data('comid');
        var comName = $(this).data('comname');
        var areaId = $(this).data('areaid');
        var areaName = $(this).data('areaname');
        var areaType = $(this).data('areatype');
        var comType = $(this).data('comtype');
        var name = $(this).data('name');
        var mobile = $(this).data('mobile');
        var wxcode = $(this).data('wxcode');
        var shopName = $(this).data('shopname');
        var addr = $(this).data('addr');
        var addrDetail = $(this).data('addrdetail');
        var lng = $(this).data('lng');
        var lat = $(this).data('lat');

        // if(areaType == 2){
        //     $('.area-choose-2').css('display','block');
        // }else{
        //     $('.area-choose-1').css('display','block');
        // }
        //
        // if(comType == 2){
        //     $('.community-choose-2').css('display','block');
        // }else{
        //     $('.community-choose-1').css('display','block');
        // }

        $('.area-choose-2').css('display','block');
        $('.community-choose-2').css('display','block');

        if(comId > 0){
            $('.handle-add').css('display','none');
        }else{
            $('.community-info').css('display','none');
            $('.area-choose-2').css('display','none');
            $('.community-choose-2').css('display','none');
            $('.handle-add').css('display','block');
        }

        $('#asl_apply_area').val(areaName);
        $('#asl_apply_community').val(comName);
        $('#asl_apply_area_id').val(areaId);
        $('#asl_apply_community_id').val(comId);
        $('#area_type').val(areaType);
        $('#com_type').val(comType);
        $('#asl_name').val(name);
        $('#asl_mobile').val(mobile);
        $('#asl_wxcode').val(wxcode);
        $('#asc_shop_name').val(shopName);
        $('#asc_address_detail').val(addrDetail);
        $('#hid_lng').val(lng);
        $('#hid_lat').val(lat);
        $('#com-address').html(addr);

        intiPosition(province,city,zone);
        if(areaId){
            initAreaCommunity(areaId,'asl_apply_community_id',comId)
        }

    });
    
    function changeReason() {
        var reasonId = $('#refuse_reason').val();
        if(reasonId < 0){
            $('.custom-reason').css('display','block');
        }else{
            $('.custom-reason').css('display','none');
        }
    }

    function changeArea(){
        var areaId = $('#asl_apply_area_id').val();
        initAreaCommunity(areaId,'asl_apply_community_id',0);
        $('#asc_shop_name').val('');
        $('#asc_address_detail').val('');
    }

    function changeCommunity() {
        var shopname = $('#asl_apply_community_id').find('option:selected').data('shopname');
        var addrdetail = $('#asl_apply_community_id').find('option:selected').data('addrdetail');
        $('#asc_shop_name').val(shopname);
        $('#asc_address_detail').val(addrdetail);
    }


    function intiPosition(province,city,zone) {
        if(province > 0){
            initWxappRegion(1,'province',province);
            if(city > 0){
                initWxappRegion(province,'city',city);
            }
            if(city > 0  && zone > 0){
                initWxappRegion(city,'zone',zone);
            }
        }else if(city > 0){  //区域管理合伙人获取可添加的街道区域
            if(zone > 0)
                initWxappRegion(city,'zone',zone);
            else
                initWxappRegion(city,'zone',0);
        }else{
            initWxappRegion(1,'province');
        }
    }

    /**
     * 省会变更
     */
    function changeWxappProvince(){
        var fid = $('#province').val();
        initWxappRegion(fid ,'city');
    }
    /**
     * 城市变更
     */
    function changeWxappCity(){
        var fid = $('#city').val();
        initWxappRegion(fid ,'zone');
    }

    function initWxappRegion(fid,selectId,df){
        if(fid > 0) {
            var data = {
                'fid': fid
            };
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/index/region',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        region_html(ret.data,selectId,df);
                        if(!df){
                            if(selectId == 'province'){
                                initWxappRegion(ret.data[0].region_id,'city');
                            }
                            if(selectId == 'city'){
                                initWxappRegion(ret.data[0].region_id,'zone');
                            }
                        }
                    }
                }
            });
        }
    }

    /**
     * 展示区域省市区
     * @param data
     * @param selectId
     */
    function region_html(data,selectId,df){
        var option = '';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.region_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.region_id+'" '+sel+'>'+temp.region_name+'</option>';
        }
        $('#'+selectId).html(option);
    }


    $('#confirm-handle').on('click',function(){
        var hid = $('#hid_id').val();
        var areaName = $('#asl_apply_area').val();
        var comName = $('#asl_apply_community').val();
        var areaId = $('#asl_apply_area_id').val();
        var comId = $('#asl_apply_community_id').val();
        var areaType = $('#area_type').val();
        var comType = $('#com_type').val();
        var name = $('#asl_name').val();
        var mobile = $('#asl_mobile').val();
        var wxcode = $('#asl_wxcode').val();
        var shopName = $('#asc_shop_name').val();
        var addrDetail = $('#asc_address_detail').val();
        var lng = $('#hid_lng').val();
        var lat = $('#hid_lat').val();
        var addr = $('#com-address').html();
        var province = $('#province').val();
        var city = $('#city').val();
        var zone = $('#zone').val();
        var fakeMember = $('#asc_fake_member').val();
        var sequenceNum = $('#asc_sequence_num').val();
        var market = $('#market').val();
        var data = {
            id : hid,
            areaName:areaName,
            comName:comName,
            areaId:areaId,
            comId:comId,
            areaType:areaType,
            comType:comType,
            name:name,
            mobile:mobile,
            wxcode:wxcode,
            shopName:shopName,
            addrDetail:addrDetail,
            lng:lng,
            lat:lat,
            addr:addr,
            province:province,
            city:city,
            zone:zone,
            fakeMember:fakeMember,
            sequenceNum:sequenceNum,
            market:market
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/leaderApplyConfirm',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    $('#confirm-refuse').on('click',function(){
        var hid = $('#hid_id').val();
        var refuse_market = $('#refuse_market').val();
        var refuse_reason = $('#refuse_reason').val();
        var data = {
            id : hid,
            market:refuse_market,
            reason:refuse_reason
        };
        if(hid){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/leaderApplyRefuse',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em,{
                        time : 2000
                    },function () {
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }
    });

    function confirmDelete(ele) {
        layer.confirm('确定删除吗？', {
            title:'删除提示',
            btn: ['确定','取消'] //按钮
        }, function(){
            var id = $(ele).data('id');
            if(id){
                var loading = layer.load(2);
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/gamebox/areaDelete',
                    'data'  : { id:id},
                    'dataType' : 'json',
                    success : function(ret){
                        layer.close(loading);
                        layer.msg(ret.em);
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    }
                });
            }
        });

    }


    function initAreaCommunity(areaId,selectId,df){
        if(areaId > 0) {
            var data = {
                'areaId': areaId
            };
            var loading = layer.load(2);
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/getAreaCommunity',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        community_html(ret.data,selectId,df);
                    }
                    layer.close(loading);
                }
            });
        }
    }

    /**
     * 展示区域省市区
     * @param data
     * @param selectId
     */
    function community_html(data,selectId,df){
        var option = '<option value="0" data-shopname="" data-addrdetail="">无</option>';
        for(var i=0 ; i < data.length ; i++){
            var temp  = data[i];
            var sel   = '';
            if(df && temp.asc_id == df ){
                sel = 'selected';
            }
            option += '<option  value="'+temp.asc_id+'" data-shopname="'+temp.asc_shop_name+'" data-addrdetail="'+temp.asc_address_detail+'" '+sel+'>'+temp.asc_name+'</option>';
        }
        $('#'+selectId).html(option);
    }




</script>