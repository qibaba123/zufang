
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    a.new-window { color: blue; }
    .payment-block-wrap { font-family: '黑体'; }
    .payment-block { border: 1px solid #e5e5e5; margin-bottom: 20px; }
    .payment-block .payment-block-header { position: relative; padding: 10px; border-bottom: 1px solid #e5e5e5; margin-bottom: -1px; background: #F8F8F8; cursor: pointer; }
    .payment-block .payment-block-header h3 { font-size: 16px; font-weight: bold; line-height: 30px; margin: 0; }
    .payment-block .payment-block-header h3:after { content: ' '; border: 5px solid #999; width: 0; height: 0; display: inline-block; position: absolute; margin-left: 6px; margin-top: 12px; border-left-color: transparent; border-right-color: transparent; border-bottom-color: transparent; border-top-width: 7px; -webkit-transition: all 0.2s; -moz-transition: all 0.2s; transition: all 0.2s; }
    .payment-block-wrap.open .payment-block-header h3:after { -webkit-transform: rotate(180deg); -moz-transform: rotate(180deg); -ms-transform: rotate(180deg); transform: rotate(180deg); -webkit-transform-origin: 50% 25%; -moz-transform-origin: 50% 25%; -ms-transform-origin: 50% 25%; transform-origin: 50% 25%; }
    .payment-block .payment-block-header .choose-onoff { position: absolute; top: 10px; right: 10px; }
    .payment-block .payment-block-body { display: none; padding: 25px; }
    .payment-block-body .form-group { overflow: hidden; }
    .payment-block-body .form-group label { font-weight: bold; }
    .payment-block-body .form-group p { color: #999; margin: 0; margin-top: 5px; }
    .payment-block .payment-block-body h4 { color: #333; margin-bottom: 20px; font-size: 14px; }
    .form-horizontal { margin-bottom: 30px; width: auto; }
    .form-horizontal .control-group { margin-bottom: 10px; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .controls-row:after, .dropdown-menu>li>a, .form-actions:after, .form-horizontal .control-group:after, .modal-footer:after, .nav-pills:after, .nav-tabs:after, .navbar-form:after, .navbar-inner:after, .pager:after, .thumbnails:after { clear: both; }
    .form-horizontal .control-group:after, .form-horizontal .control-group:before { display: table; line-height: 0; content: ""; }
    .form-horizontal .control-label { float: left; width: 160px; padding-top: 5px; text-align: right; }
    .form-horizontal .control-label { width: 120px; font-size: 14px; line-height: 18px; }
    .page-payment .form-label-text-left .control-label { text-align: left; width: 100px; }
    .controls { font-size: 14px; }
    .form-horizontal .controls { margin-left: 180px; }
    .form-horizontal .controls { margin-left: 130px; word-break: break-all; }
    .page-payment .form-label-text-left .controls { margin-left: 100px; }
    .form-horizontal .control-action { padding-top: 5px; display: inline-block; font-size: 14px; line-height: 18px; }
    .ui-message, .ui-message-warning { padding: 7px 15px; margin-bottom: 15px; color: #333; border: 1px solid #e5e5e5; line-height: 24px; }
    .ui-message-warning { color: #333; background: #ffc; border-color: #fc6; }
    .pay-test-status { font-size: 12px; margin-top: 10px; width: 400px; }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
    .showhide-secreskey { position: absolute; top: 4px; right: 18px; height: 26px; line-height: 26px; border-radius: 3px; background-color: #0095e5; color: #fff; z-index: 1; padding: 0 7px; font-size: 12px; cursor: pointer; }
    .showhide-secreskey:hover { opacity: 0.9; }

    .timeDian{
        margin-left: 10% !important;
    }
    .title-col-2{
        width: 135px !important;
        padding-left: 20px !important;
    }
    .save-button-box{
        margin-left: 20.6666% !important;
    }
    .time{
        display: inline-block;
    }
    /* 保存按钮样式 */
    .alert.save-btn-box{
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    #container object{
        position:relative!important;
        height: 300px!important;
    }
    .switch-title{
        padding-left: 8px;
        font-weight: bold;
    }
    .input-tip{
        color: #999;
        padding-left: 5px;
    }
    .second-navmenu li > a{
        padding-left: 0 !important;
        text-align: center !important;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
</style>
<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" >
    <div class="page-header" style="min-height: 50px;border: none">
            <!--<a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>-->
            <span style="">
                    <span class="switch-title">启用门店自提：</span>
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="receiveOpen"  data-type="open" onchange="changeOpen('receive')" type="checkbox" <{if $sendCfg && $sendCfg['acs_receive']}>checked<{/if}>>
                        <span class="lbl"></span>
                    </label>
            </span>
        <div class="watermrk-show">
            <span class="label-name">排序：</span>
            <div class="watermark-box" >
                <div class="input-group">
                    <input type="number" style="width: 60px;color:#000" maxlength="2" class="form-control delivery-sort" id="delivery-sort-receive" value="<{$sendCfg['acs_receive_sort']}>" data-type="receive" oninput="if(value.length>2)value=value.slice(0,2)">
                    <span class="input-group-btn">
                            <span class="btn btn-blue save-delivery-sort" id="" data-type="receive">确认</span>
                            <span>数值越大越靠前</span>
                        </span>
                </div>
            </div>
        </div>
        </div>
    <div class="page-header" style="min-height: 50px;border: none">
            <span style="">
                    <span class="switch-title">启用商家配送：</span>
                    <label id="choose-onoff" class="choose-onoff">
                        <input name="sms_start" class="ace ace-switch ace-switch-5" id="sendOpen" data-type="open" onchange="changeOpen('send')" type="checkbox" <{if $sendCfg && $sendCfg['acs_send']}> checked<{/if}>>
                    <span class="lbl"></span>
                    </label>
            </span>
        <div class="watermrk-show">
            <span class="label-name">排序：</span>
            <div class="watermark-box" style="width: 110px">
                <div class="input-group">
                    <input type="number" style="width: 60px" maxlength="2" class="form-control delivery-sort" id="delivery-sort-send" value="<{$sendCfg['acs_send_sort']}>" data-type="send" oninput="if(value.length>2)value=value.slice(0,2)">
                    <span class="input-group-btn">
                            <span class="btn btn-blue save-delivery-sort" id="" data-type="send">确认</span>

                        </span>
                </div>
            </div>
        </div>

        <span style="color: red">&nbsp;门店自提及配送到家均以下单时的小区地址为准</span>
    </div>

    <div class="page-header" style="min-height: 50px">
            <span style="">
                    <span class="switch-title">启用团长配送：</span>
                    <label id="choose-onoff" class="choose-onoff">
                        <input name="sms_start" class="ace ace-switch ace-switch-5" id="leaderOpen" data-type="open" onchange="changeOpen('leader')" type="checkbox" <{if $sendCfg && $sendCfg['acs_leader_send']}> checked<{/if}>>
                    <span class="lbl"></span>
                    </label>
            </span>
        <div class="watermrk-show">
            <span class="label-name">排序：</span>
            <div class="watermark-box" style="width: 110px">
                <div class="input-group">
                    <input type="number" style="width: 60px" maxlength="2" class="form-control delivery-sort" id="delivery-sort-leader" value="<{$sendCfg['acs_leader_sort']}>" data-type="send" oninput="if(value.length>2)value=value.slice(0,2)">
                    <span class="input-group-btn">
                            <span class="btn btn-blue save-delivery-sort" id="" data-type="leader">确认</span>

                        </span>
                </div>
            </div>
        </div>

    </div>


    <div class="payment-block-body js-wxpay-body-region" style="display: block;margin-bottom: 50px;">

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开始配送/发货时间</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="sequenceDay" name="sequenceDay" placeholder="请填写开始配送/发货时间" value="<{if $sendCfg}><{$sendCfg['acs_sequence_day']}><{/if}>" style="width:15%;display: inline-block">
                <span>天后</span>
                <span class="input-tip">不填或填0则默认为当天自取/配送</span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">最低自提金额</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="receiveLimit" name="receiveLimit" placeholder="请填写最低自提金额" value="<{if $sendCfg}><{$sendCfg['acs_receive_price']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">订单达到此金额才能使用门店自提，不填或填0表示不限制</span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">延后时间点</label>
            </div>
            <div class="form-group col-sm-10">
                <span>每天</span>
                <select class="form-control" id="sequenceDaytime" name="sequenceDaytime"  value="<{if $sendCfg}><{$sendCfg['acs_sequence_daytime']}><{/if}>" style="width:15%;display: inline-block">
                    <option value="">不设置</option>
                    <{foreach $dayTime as $val}>
                        <option value="<{$val}>" <{if $val eq $sendCfg['acs_sequence_daytime']}>selected<{/if}>><{$val}></option>
                    <{/foreach}>
                </select>
                <span>后下单，将配送/发货时间延后一天</span>
                <span class="input-tip"></span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">最大配送范围<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="range" name="range" placeholder="请填写配送范围" value="<{if $sendCfg}><{$sendCfg['acs_send_range']}><{/if}>" style="width:15%;display: inline-block">
                <span>千米</span>
                <span class="input-tip">超出最大配送范围的订单将无法使用配送到家</span>
            </div>
       </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">订单满多少起送</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="satisfySend" name="satisfySend" placeholder="请填写订单满多少元起送" value="<{if $sendCfg}><{$sendCfg['acs_satisfy_send']}><{/if}>" style="width:15%;display: inline-block">
                <span>元起送</span>
                <span class="input-tip">订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">基本配送费用<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="baseLong" name="baseLong" placeholder="请填写基本配送范围" value="<{if $sendCfg}><{$sendCfg['acs_base_long']}><{/if}>" style="width:15%;display: inline-block">
                <span>千米内</span>
                <input type="number" class="form-control" id="basePrice" name="basePrice" placeholder="请填写基本配送费用" value="<{if $sendCfg}><{$sendCfg['acs_base_price']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">基本配送范围内按基本配送费用收费</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">超出部分费用<font color="red">*</font></label>
            </div>
            <div class="form-group col-sm-10">
                <span>每超出</span>
                <input type="number" class="form-control" id="plusLong" name="plusLong" placeholder="请填写超出范围" value="<{if $sendCfg}><{$sendCfg['acs_plus_long']}><{/if}>" style="width:15%;display: inline-block">
                <span>千米,需另支付</span>
                <input type="number" class="form-control" id="plusPrice" name="plusPrice" placeholder="请填写额外支付" value="<{if $sendCfg}><{$sendCfg['acs_plus_price']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">若用户超出基本配送范围,超出部分需按距离额外支付费用</span>
            </div>
        </div>

         <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="post_free" style="font-size: 14px">订单免配送费</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="number" class="form-control" id="post_free" name="post_free" placeholder="" value="<{if $sendCfg}><{$sendCfg['acs_post_free']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">订单满足设定的金额时免配送费用，设置为0不进行减免</span>
            </div>
       </div>

        <hr>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">团长配送满多少起送</label>
            </div>
            <div class="form-group col-sm-10">

                <input type="number" class="form-control" id="leaderLimit" name="leaderLimit" placeholder="请填写订单起送金额" value="<{if $sendCfg}><{$sendCfg['acs_leader_limit']}><{/if}>" style="width:15%;display: inline-block">
                <span>元起送</span>
                <span class="input-tip">订单金额必须达到多少钱才配送，否则将无法下单。0表示无限制</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">团长配送免配送费金额</label>
            </div>
            <div class="form-group col-sm-10">

                <input type="number" class="form-control" id="leaderReduce" name="leaderReduce" placeholder="请填写订单金额" value="<{if $sendCfg}><{$sendCfg['acs_leader_reduce']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip">使用团长配送时，订单金额达到此金额将免费配送。0表示不设置</span>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">团长配送费用</label>
            </div>
            <div class="form-group col-sm-10">

                <input type="number" class="form-control" id="leaderPrice" name="leaderPrice" placeholder="请填写费用" value="<{if $sendCfg}><{$sendCfg['acs_leader_price']}><{/if}>" style="width:15%;display: inline-block">
                <span>元</span>
                <span class="input-tip"></span>
            </div>
        </div>

    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" onclick="saveTimeCfg()"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>
    $(function(){

    });

    /*隐藏显示配置区域*/
    $(".js-wxpay-header-region").on('click', function(event) {
        var that = $(this).next('.js-wxpay-body-region');
        var thatWrap = $(this).parents('.payment-block-wrap');
        var isDisplay = that.css("display");
        if(isDisplay=='block'){
            that.stop().slideUp();
            thatWrap.removeClass('open');
        }else{
            that.stop().slideDown();
            thatWrap.addClass('open');
        }
    });
    function addTimeHtml(obj){
        var endId=$('.timeDian').last().children().eq(0).data('id');
        var nextId=++endId;
        var timeDiv='<div class="timeDian" style="margin-left: 17%;margin-top: 10px">'+'<input class="time form-control" data-id="'+nextId+'" onclick="selectTime()" type="text" id="'+'start'+nextId+'"style="width: 10%;margin-right:4%">--<input type="text" class="time form-control" data-id="'+nextId+'"  onclick="selectTime()" id="'+'end'+nextId+'" style="width: 10%;margin-left:4%">'+'<label style="color: #428BCA;cursor: pointer;margin-left:1%" onclick="delTimeHtml(this)">删除</label></div>';
        $(obj).parent().append(timeDiv);
    }
    function delTimeHtml(obj){
        $(obj).parent().remove();
    }


    // 保存整个的配送设置
    function saveTimeCfg(){
        var sendScope = $('#sendDetail').val();
        var address   = $('#addr').val();
        var sendRange = $('#range').val();
        var lng = $('#lng').val();
        var lat = $('#lat').val();
        var baseLong  = $('#baseLong').val();
        var basePrice  = $('#basePrice').val();
        var plusLong  = $('#plusLong').val();
        var plusPrice  = $('#plusPrice').val();
        var satisfySend  = $('#satisfySend').val();
        var sequenceDay = $('#sequenceDay').val();
        var sequenceDaytime = $('#sequenceDaytime').val();
        var leaderLimit = $('#leaderLimit').val();
        var leaderPrice = $('#leaderPrice').val();
        var leaderReduce = $('#leaderReduce').val();
        var receiveLimit = $('#receiveLimit').val();
        var post_free   =$('#post_free').val();
        var data={
            'sendDetails':sendScope,
            'address': address,
            'lng': lng,
            'lat': lat,
            'sendRange' : sendRange,
            'baseLong' : baseLong,
            'basePrice' : basePrice,
            'plusLong' : plusLong,
            'plusPrice' : plusPrice,
            'satisfySend' : satisfySend,
            'sequenceDay' : sequenceDay,
            'sequenceDaytime' : sequenceDaytime,
            'leaderLimit' : leaderLimit,
            'leaderPrice' : leaderPrice,
            'leaderReduce' : leaderReduce,
            'receiveLimit' : receiveLimit,
            'post_free' :post_free
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSendTwo',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.msg(response.em);
                window.location.reload();
            }
        });
    }
    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })
    function selectTime(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    }

    // 配送方式保存
    function changeOpen(type) {
        var open   = $('#'+type+'Open:checked').val();
        if(type == 'platform' && open == 'on'){
            $('#sendOpen').removeAttr('checked');
        }
        if(type == 'send' && open == 'on'){
            $('#platformOpen').removeAttr('checked');
        }
        var data = {
            value:open,
            type : type
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec==400){
                    layer.alert(ret.em,function(){
                        window.location.reload();
                    });
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
    // 排序
    $('.save-delivery-sort').on('click',function () {
        var type = $(this).data('type');
        var value = $('#delivery-sort-'+type).val();
        var data = {
            value:value,
            type : type
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSort',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });

</script>
