<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
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
    .link-box div{
        width: 50% ;
    }
    .business-time{
        width: 12% !important;
        display: inline-block;
    }
</style>
<{include file="../article-kind-editor.tpl"}>
<div class="payment-style" ng-app="chApp" ng-controller="chCtrl" >

    <div class="payment-block-body js-wxpay-body-region" style="display: block;">

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">首页图标开关</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item' style="margin-right: 20px">
                    转发
                                <input class='tgl tgl-light' id='share_open' type='checkbox' ng-model="shareIconOpen">
                                <label class='tgl-btn' for='share_open' style="width: 60px;display: inline-block"></label>
                </span>
                <span class='tg-list-item' style="margin-right: 20px">
                    购物车
                                <input class='tgl tgl-light' id='cart_open' type='checkbox' ng-model="cartIconOpen">
                                <label class='tgl-btn' for='cart_open' style="width: 60px;display: inline-block"></label>
                </span>
                <span class='tg-list-item' style="margin-right: 20px">
                    切换小区
                                <input class='tgl tgl-light' id='community_open' type='checkbox' ng-model="communityIconOpen">
                                <label class='tgl-btn' for='community_open' style="width: 60px;display: inline-block"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    小程序首页转发、购物车、切换小区按钮开关，开启显示，关闭则不显示
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">商品详情购买记录</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='goods_record' type='checkbox' ng-model="goodsRecord">
                                <label class='tgl-btn' for='goods_record' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    小程序端商品详情页商品购买记录开关，开启后显示该商品的购买记录，关闭则不显示
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">首页商品列表购买头像</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='list_goods_record' type='checkbox' ng-model="listGoodsRecord">
                                <label class='tgl-btn' for='list_goods_record' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    小程序端首页商品列表商品购买头像开关，开启后显示该商品的购买人头像，关闭则不显示
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">团长中心排行榜</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='rank_open' type='checkbox' ng-model="rankOpen">
                                <label class='tgl-btn' for='rank_open' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    小程序端个人中心->团长管理中心是否显示各小区销量排行
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">自定义小区文本</label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" ng-model="communityDesc" maxlength="4">
                <span style="color: #666">用于替换小程序中的“小区”两字。不超过4个字</span>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">美食区标题</label>
            </div>
            <div class="form-group col-sm-3">
                <input type="text" class="form-control" ng-model="goodsMenuTitle" maxlength="7">
                <span style="color: #666">商品详情中的美食区入口标题。不超过7个字</span>
            </div>
        </div>
        <{if $sequenceShowAll == 1}>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">会计审核提现</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='accountant_withdraw' type='checkbox' ng-model="accountantWithdraw">
                                <label class='tgl-btn' for='accountant_withdraw' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">

                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">会计审核退款</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='accountant_refund' type='checkbox' ng-model="accountantRefund">
                                <label class='tgl-btn' for='accountant_refund' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">

                </div>
            </div>
        </div>
        <{/if}>


        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">切换小区提示</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='community_alert' type='checkbox' ng-model="communityAlert">
                                <label class='tgl-btn' for='community_alert' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    开启后，用户打开其他人转发的小程序首页或商品后，会有是否切换到对方小区的提示
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">自取提示弹窗</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='receive_tip' type='checkbox' ng-model="receiveTip">
                                <label class='tgl-btn' for='receive_tip' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">

                </div>
            </div>
        </div>

        <!--
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">门店自提商品限制</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='store_goods_limit' type='checkbox' ng-model="storeGoodsLimit">
                                <label class='tgl-btn' for='store_goods_limit' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">

                </div>
            </div>
        </div>
        -->

        <div class="row" >
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">营业时间</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="text" class="form-control business-time" id="open_time"  placeholder="营业开始时间" ng-model="openTime" >
                至
                <input type="text" class="form-control business-time" id="close_time"  placeholder="营业结束时间" ng-model="closeTime">
                <span style="color: #666">若营业结束时间早于营业开始时间，将视为第二天</span>
            </div>
        </div>

        <div class="row" >
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">小区列表距离范围</label>
            </div>
            <div class="form-group col-sm-10" style="display: block">
                <input type="" class="form-control" id="community_range"  placeholder="距离范围" ng-model="communityRange" style="display:inline-block;width: 10%">千米
            </div>
            <div class="form-group col-sm-10" style="color: red">
                小区列表中显示小区的距离限制，0表示不限制
            </div>
        </div>

        <hr>
        <{if $sequenceShowAll == 1}>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开启接龙奖品</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='sequence_open' type='checkbox' ng-model="sequenceInfoOpen">
                                <label class='tgl-btn' for='sequence_open' style="margin-right: 57%;width: 60px;"></label>
                            </span>
                <div style="margin-top: 5px;color: red">
                    用户在手机端通过小程序下单成功后会自动生成一个接龙编号，后台可以设置相关接龙规则，如：接龙编号为30好的获得XX礼品一份，用户可凭下单成功页面的接龙编号到下单小区兑换礼品
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">分享接龙用户信息</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='sequence_share_member' type='checkbox' ng-model="sequenceShareMember">
                                <label class='tgl-btn' for='sequence_share_member' style="margin-right: 57%;width: 60px;"></label>
                            </span>
                <div style="margin-top: 5px;color: red">
                    开启后，分享接龙活动时将固定为《团长，我是"XXXX"，刚买了商品，快点接单了！》
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">接龙奖品名称</label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id ="prize_name" name="prize_name" ng-model="prizeName">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">接龙奖品图片</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="form-group col-sm-10" style="padding-left: 0">
                    <img onclick="toUpload(this)"   data-limit="1" onload="changeSrc(this)" data-width="400" data-height="400" imageonload="changePrizeImg()" data-dom-id="upload-prizeImg" id="upload-prizeImg"  ng-src="{{prizeImg}}"  height="100%" style="display:inline-block;height: 200px;margin: 0">
                    <input type="hidden" id="prizeImg"  class="avatar-field bg-img" name="prizeImg" ng-value="prizeImg"/>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">接龙规则</label>
            </div>
            <div class="form-group col-sm-10">
               <textarea class="form-control" style="width:100%;height:250px;visibility:hidden;" id = "sequence_rule" name="sequence_rule" placeholder="请填写接龙规则"  rows="15" style=" text-align: left; resize:vertical;" >
                <{$cfg['asc_sequence_rule']}>
                </textarea>
                <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                <input type="hidden" name="ke_textarea_name" value="sequence_rule" />
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开启微信入群引导</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                                <input class='tgl tgl-light' id='wxgroup_open' type='checkbox' ng-model="wxgroupOpen">
                                <label class='tgl-btn' for='wxgroup_open' style="margin-right: 57%;width: 60px;"></label>
                            </span>
                <div style="margin-top: 5px;color:red">
                    开启后会在小程序端商品详情处，提示用户进群，进群页面为联系客服，用户需联系客服进群
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">引导标题</label>
            </div>
            <div class="form-group col-sm-5">
                <input type="text" class="form-control" id ="wxgroup_title" name="wxgroup_title" ng-model="wxgroupTitle">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">引导简述</label>
            </div>
            <div class="form-group col-sm-10">
                <input type="text" class="form-control" id ="wxgroup_brief" name="wxgroup_brief" ng-model="wxgroupBrief">
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">引导图片</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="form-group col-sm-10" style="padding-left: 0">
                    <img onclick="toUpload(this)"   data-limit="1" onload="changeSrc(this)" data-width="400" data-height="400" imageonload="changeWxgroupImg()" data-dom-id="upload-wxgroupImg" id="upload-wxgroupImg"  ng-src="{{wxgroupImg}}"  height="100%" style="display:inline-block;height: 200px;margin: 0">
                    <input type="hidden" id="wxgroupImg"  class="avatar-field bg-img" name="wxgroupImg" ng-value="wxgroupImg"/>
                </div>
            </div>
        </div>
        <hr>
        <{/if}>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开启广告</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                    <input class='tgl tgl-light' id='ad_open' type='checkbox' ng-model="adOpen">
                    <label class='tgl-btn' for='ad_open' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <div style="margin-top: 5px;color: red">
                    开启后用户在手机端通过小程序下单成功页面会展示该广告图片，用户点击可跳转到后台配置的相应页面
                </div>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">广告图片</label>
            </div>
            <div class="form-group col-sm-10">
                <img onclick="toUpload(this)"   data-limit="1" onload="changeSrc(this)" data-width="750" data-height="300" imageonload="changeAdImg()" data-dom-id="upload-adImg" id="upload-adImg"  ng-src="{{adImg}}"  height="100%" style="display:inline-block;margin-left:0;height: 200px;margin: 0">
                <input type="hidden" id="adImg"  class="avatar-field bg-img" name="adImg" ng-value="adImg"/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">链接类型</label>
            </div>
            <div class="form-group col-sm-10">
                <select class="form-control" ng-model="adLinkType"  ng-options="x.id as x.name for x in linkTypes" style="width: 50%"></select>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">链接</label>
            </div>
            <div class="form-group link-box col-sm-10">
                <div ng-show="adLinkType==1">
                    <label for="">资讯详情：</label>
                    <select class="form-control " ng-model="adLink"  ng-options="x.id as x.title for x in articles" ></select>
                </div>
                <div  ng-show="adLinkType==2">
                    <label for="">列　　表：</label>
                    <select class="form-control" ng-model="adLink"  ng-options="x.path as x.name for x in linkList" ></select>
                </div>
                <div  ng-show="adLinkType==3">
                    <label for="">外　　链：</label>
                    <input type="text" class="form-control" ng-value="adLink" ng-model="adLink" />
                </div>
                <div ng-show="adLinkType==5">
                    <label for="" style="">商品详情：</label>
                    <select class="form-control" style="" ng-model="adLink"  ng-options="x.id as x.name for x in goodsList" ></select>
                </div>
                <div ng-show="adLinkType==20">
                    <label for="" style="">店铺详情：</label>
                    <select class="form-control" style="" ng-model="adLink"  ng-options="x.id as x.name for x in shopList" ></select>
                </div>
                <div  ng-show="adLinkType==34">
                    <label for="">店铺分类：</label>
                    <select class="form-control" style="" ng-model="adLink"  ng-options="x.id as x.name for x in shopCategory" ></select>
                </div>
                <div  ng-show="adLinkType==23">
                    <label for="">商品分类：</label>
                    <select class="form-control" ng-model="adLink"  ng-options="x.id as x.name for x in currFirstKindSelect" ></select>
                </div>
                <div  ng-show="adLinkType==9">
                    <label for="">商品分类：</label>
                    <select class="form-control" ng-model="adLink"  ng-options="x.id as x.name for x in currSecondKindSelect" ></select>
                </div>
                <div  ng-show="adLinkType==106">
                    <label for="">小 程 序：</label>
                    <select class="form-control" ng-model="adLink"  ng-options="x.appid as x.name for x in jumpList" ></select>
                </div>
                <div  ng-show="adLinkType==32">
                    <label for="">资讯分类：</label>
                    <select class="form-control" ng-model="adLink"  ng-options="x.id as x.name for x in infocateList" ></select>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">开启商品访问统计</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                    <input class='tgl tgl-light' id='goods_view_record' type='checkbox' ng-model="goods_view_record">
                    <label class='tgl-btn' for='goods_view_record' style="margin-right: 57%;width: 60px;"></label>
                </span>
                <small class='help-block'>*此选项开启后会统计商品的详细访问数据，但会降低系统的性能</small>
            </div>
        </div>
        <hr>
        <!-- 是否在转发时显示原价 -->
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">转发时显示商品会员价</label>
            </div>
            <div class="form-group col-sm-10">
                <span class='tg-list-item'>
                    <input class='tgl tgl-light' id='goods_forward_price' type='checkbox' ng-model="goods_forward_price">
                    <label class='tgl-btn' for='goods_forward_price' style="margin-right: 57%;width: 60px;"></label>
                </span>
            </div>
        </div>
        <div style="height: 60px"></div>
    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save" ng-click="saveData()"> 保 存 </span>
    </div>
</div>

<script src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/newTemTwo/js/angular-1.4.6.min.js"></script>
<script src="/public/manage/newTemTwo/js/angular-root.js"></script>
<script src="/public/plugin/sortable/sortable.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>
<script>

    //示范一个公告层
    layer.open({
        type: 1,
        title: false, //不显示标题栏
        closeBtn: false,
        area: '300px;',
        shade: 0.8,
        id: 'LAY_layuipro', //设定一个id，防止重复弹出
        btn: ['现在跳转'],
        btnAlign: 'c',
        moveType: 1, //拖拽模式，0或者1
        content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">为了更好的用户体验，我们已经将当前配置页面已更新至<br><br>【配置管理】-->【系统配置】中，<br><br>此配置页面将不在进行支持！！！</div>',
        success: function(layero){
            var btn = layero.find('.layui-layer-btn');
            btn.find('.layui-layer-btn0').attr({
                href: '/wxapp/configs/config',
            });
        }
    });

    var app = angular.module('chApp', ['RootModule',"ui.sortable"]);
    app.controller('chCtrl',['$scope','$http','$timeout', function($scope,$http,$timeout){
        $scope.currSecondKindSelect = <{$currSecondKindSelect}>;
        $scope.currFirstKindSelect = <{$currFirstKindSelect}>;
        $scope.infocateList = <{$infocateList}>;
        $scope.linkTypes = <{$linkType}>;
        $scope.linkList  = <{$linkList}>;
        $scope.articles  = <{$information}>;
        $scope.adImg          = '<{$cfg['asc_ad_img']}>'?'<{$cfg['asc_ad_img']}>':'/public/manage/img/zhanwei/zw_fxb_75_30.png';
        $scope.prizeImg       = '<{$cfg['asc_prize_img']}>'?'<{$cfg['asc_prize_img']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png';
        $scope.prizeName = '<{$cfg['asc_prize_name']}>' ? '<{$cfg['asc_prize_name']}>' :'';
        $scope.communityRange = '<{$cfg['asc_community_range']}>' ? '<{$cfg['asc_community_range']}>' :'0';
        $scope.communityAlert = '<{$cfg['asc_community_alert_show']}>' > 0 ?true:false;
        $scope.adOpen         = '<{$cfg['asc_ad_open']}>' > 0 ?true:false;
        $scope.rankOpen         = '<{$cfg['asc_rank_open']}>' > 0 ?true:false;
        $scope.sequenceInfoOpen = '<{$cfg['asc_sequence_info']}>' > 0 ? true:false;
        $scope.sequenceShareMember = '<{$cfg['asc_sequence_share_member']}>' > 0 ? true:false;
        $scope.goodsRecord = '<{$cfg['asc_goods_record']}>' > 0 ? true:false;
        $scope.listGoodsRecord = '<{$cfg['asc_list_goods_record']}>' > 0 ? true:false;
        $scope.receiveTip = '<{$cfg['asc_receive_tip']}>' > 0 ? true:false;
        $scope.adLink    = '<{$cfg['asc_ad_link']}>' ? '<{$cfg['asc_ad_link']}>' : '';
        $scope.adLinkType = '<{$cfg['asc_ad_link_type']}>' ? '<{$cfg['asc_ad_link_type']}>' : '';
        $scope.goodsList = <{$goodsList}>;
        $scope.shareIconOpen = '<{$cfg['asc_share_open']}>' == '0' ? false:true;
        $scope.cartIconOpen = '<{$cfg['asc_cart_open']}>' == '0' ? false:true;
        $scope.communityIconOpen = '<{$cfg['asc_community_open']}>' == '0' ? false:true;
        $scope.wxgroupOpen = '<{$cfg['asc_wxgroup_open']}>' == '0' ? false:true;
        $scope.wxgroupImg       = '<{$cfg['asc_wxgroup_img']}>'?'<{$cfg['asc_wxgroup_img']}>':'/public/manage/img/zhanwei/zw_fxb_200_200.png';
        $scope.wxgroupTitle = '<{$cfg['asc_wxgroup_title']}>' ? '<{$cfg['asc_wxgroup_title']}>' :'';
        $scope.wxgroupBrief = '<{$cfg['asc_wxgroup_brief']}>' ? '<{$cfg['asc_wxgroup_brief']}>' :'';
        $scope.communityDesc = '<{$cfg['asc_community_desc']}>' ? '<{$cfg['asc_community_desc']}>' :'小区';
        $scope.goods_view_record ='<{$cfg['asc_goods_view_record']}>' > 0 ?true:false;
        $scope.goods_forward_price ='<{$cfg['asc_forward_price']}>' ==1 ?true:false; 
        $scope.accountantRefund ='<{$curr_shop['s_accountant_refund']}>' > 0 ?true:false;
        $scope.accountantWithdraw ='<{$curr_shop['s_accountant_withdraw']}>' > 0 ?true:false;
        $scope.openTime = '<{$cfg['asc_open_time']}>' ? '<{$cfg['asc_open_time']}>' : '00:00';
        $scope.closeTime = '<{$cfg['asc_close_time']}>' ? '<{$cfg['asc_close_time']}>' : '23:59';
        $scope.goodsMenuTitle = '<{$cfg['asc_goods_menu_title']}>' ? '<{$cfg['asc_goods_menu_title']}>' : '美食区详情';
        //$scope.storeGoodsLimit ='<{$curr_shop['s_store_goods_limit']}>' > 0 ?true:false;
        $scope.changeAdImg=function(){
            if(imgNowsrc){
                $scope.adImg = imgNowsrc;
            }
        };

        $scope.changePrizeImg=function(){
            if(imgNowsrc){
                $scope.prizeImg = imgNowsrc;
            }
        };

        $scope.changeWxgroupImg=function(){
            if(imgNowsrc){
                $scope.wxgroupImg = imgNowsrc;
            }
        };



        /*添加分类导航方法*/
        $scope.addNewfenleiNav = function(){
            var fenleiNav_length = $scope.fenleiNavs.length;
            var defaultIndex = 0;
            if(fenleiNav_length>0){
                for (var i=0;i<fenleiNav_length;i++){
                    if(parseInt(defaultIndex) < parseInt($scope.fenleiNavs[i].index)){
                        defaultIndex = $scope.fenleiNavs[i].index;
                    }
                }
                defaultIndex++;
            }
            if(fenleiNav_length>=60){
                layer.msg("最多只能添加60个分类");
            }else{
                var fenleiNav_Default = {
                    id: 0,
                    index: defaultIndex,
                    imgsrc: '/public/manage/img/zhanwei/fenleinav.png',
                    title: '默认标题',
                    type: '1',    // 默认是帖子类型
                    price : 0,
                    mobileShow : false,
                    addressShow : false,
                    allowComment : true
                };
                $scope.fenleiNavs.push(fenleiNav_Default);
                $timeout(function(){
                    //卸载掉原来的事件
                    $(".cropper-box").unbind();
                    new $.CropAvatar($("#crop-avatar"));
                },500);
            }


        };



        /*获取真正索引*/
        $scope.getRealIndex = function(type,index){
            var resultIndex = -1;
            for(var i=0;i<type.length;i++){
                if(type[i].index==index){
                    resultIndex = i;
                    break;
                }
            }
            return resultIndex;
        };

        /*删除元素*/
        $scope.delIndex=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }


            layer.confirm('您确定要删除吗？', {
                title:'删除提示',
                btn: ['确定','取消']
            }, function(){
                if(parentType){
                    $scope.$apply(function(){
                        $scope[parentType][type].splice(realIndex,1);
                    });
                }else{
                    $scope.$apply(function(){
                        $scope[type].splice(realIndex,1);
                    });
                }
                layer.msg('删除成功');
            });
        }

        $scope.changeApplyIcon=function(){
            if(imgNowsrc){
                $scope.applyIcon = imgNowsrc;
            }
        };

        // 选择文章
        $scope.getSelectId = function(type,index,title,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
            }
            var articles = $scope.articles;
            var curId = '';
            for(var i = 0;i < articles.length;i++){
                if(articles[i].title == title){
                    curId = articles[i].id;
                }
            }
            if(parentType){
                $scope[parentType][type][realIndex].articleId = curId;
            }else{
                $scope[type][realIndex].articleId = curId;
            }
        };

        $scope.doThis=function(type,index,parentType){
            var realIndex=-1;
            /*获取要删除的真正索引*/
            if(parentType){
                realIndex = $scope.getRealIndex($scope[parentType][type],index);
                $scope[parentType][type][realIndex].imgsrc = imgNowsrc;
            }else{
                realIndex = $scope.getRealIndex($scope[type],index);
                $scope[type][realIndex].imgsrc = imgNowsrc;
            }


        };

        // 保存数据
        $scope.saveData = function(){

            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var sequenceRule = $('#sequence_rule').val();
            var openTime = $('#open_time').val();
            var closeTime = $('#close_time').val();
            var data = {
                'adImg' : $scope.adImg,
                'adOpen' : $scope.adOpen == true ? 1 : 0,
                'rankOpen' : $scope.rankOpen == true ? 1 : 0,
                'goodsRecord' : $scope.goodsRecord == true ? 1 : 0,
                'sequenceInfoOpen' : $scope.sequenceInfoOpen == true ? 1 : 0,
                'receiveTip' : $scope.receiveTip == true ? 1 : 0,
                'sequenceRule' : sequenceRule,
                'adLinkType' : $scope.adLinkType,
                'adLink' : $scope.adLink,
                'prizeImg' : $scope.prizeImg,
                'prizeName': $scope.prizeName,
                'shareIconOpen' : $scope.shareIconOpen == true ? 1 : 0,
                'cartIconOpen' : $scope.cartIconOpen == true ? 1 : 0,
                'communityIconOpen' : $scope.communityIconOpen == true ? 1 : 0,
                'wxgroupOpen' : $scope.wxgroupOpen == true ? 1 : 0,
                'wxgroupImg' : $scope.wxgroupImg,
                'wxgroupTitle': $scope.wxgroupTitle,
                'wxgroupBrief': $scope.wxgroupBrief,
                'communityDesc' : $scope.communityDesc,
                'communityRange' : $scope.communityRange,
                'goodsviewRecord':$scope.goods_view_record== true ? 1 : 0,
                'listGoodsRecord' : $scope.listGoodsRecord == true ? 1: 0,
                'accountantRefund' : $scope.accountantRefund == true ? 1: 0,
                'accountantWithdraw' : $scope.accountantWithdraw == true ? 1: 0,
                'communityAlert' : $scope.communityAlert == true ? 1: 0,
                'goods_forward_price':$scope.goods_forward_price== true ? 1 : 0,
                'sequenceShareMember' : $scope.sequenceShareMember== true ? 1 : 0,
                'goodsMenuTitle': $scope.goodsMenuTitle,
                // 'storeGoodsLimit' : $scope.storeGoodsLimit == true ? 1: 0,
            };
            data.openTime = openTime;
            data.closeTime = closeTime;

            $http({
                method: 'POST',
                url:    '/wxapp/sequence/saveTradeAd',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };

        $(function(){
            $('.mobile-page').on('click', '[data-left-preview]', function(event) {
                var id = $(this).attr('data-id');
                $(this).parents('.mobile-page').find('[data-left-preview]').removeClass('cur-edit');
                $(this).addClass('cur-edit');
                $("[data-right-edit][data-id="+id+"]").stop().show().siblings().stop().hide();
            });


        });
    }]);
    //图片上传完成时，图片加载事件绑定angularjs
    app.directive('imageonload', function () {
        return {
            restrict: 'A', link: function (scope, element, attrs) {
                element.bind('load', function () {
                    scope.$apply(attrs.imageonload);
                });
            }
        };
    });
    // 修改图片
    function changeSrc(elem){
        imgNowsrc = $(elem).attr("src");
    }

    /*初始化日期选择器*/
    $('.business-time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    });

</script>
<{include file="../img-upload-modal.tpl"}>