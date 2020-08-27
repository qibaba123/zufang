<link rel="stylesheet" href="/public/manage/centermanage/color-spectrum/spectrum.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/index.css">
<link rel="stylesheet" href="/public/manage/centermanage/css/style.css">
<{include file="../common-second-menu-new.tpl"}>
<style>
.fenlei-nav { background: #fff; margin-bottom: 10px; }
.fenlei-nav li { width: 25%; padding: 8px 10px; text-align: center; display: inline-block; font-size: 12px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; }
.fenlei-nav img { width: 35px; }
.fenlei-nav-manage li { width: 25%; padding: 8px 10px; text-align: center; display: inline-block; font-size: 12px; }
.fenlei-nav-manage img { width: 60%; margin-bottom: 5px; }
.fenlei-nav-manage .tgl-btn { margin: 5px auto; }
.index-con .index-main{background-color: #fefefe;}
.user-operation { padding: 15px; }
.print-title { font-size: 18px; line-height: 37px; text-align: center; margin-bottom: 8px;}
.goods-title {overflow: hidden;}
.goods-title span { text-align: left; width: 25%;float: left;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; }
.bold{font-weight: bold!important;}
.check-row span{
    width: 90px !important;
}
</style>
<div class="preview-page" ng-app="chApp" ng-controller="chCtrl" style="padding-bottom: 60px;">
    <!--
    <div class="page-header">
        <div class="input-group">
            <div class="input-group-addon"> 会 &nbsp; 员 &nbsp; 中 &nbsp; 心 : </div>
            <input type="text" class="form-control" id="user_center" value="<{if $row}><{$row['center']}><{/if}>" placeholder="" readonly style="height:35px;">
            <a class="input-group-addon copy_input" data-clipboard-target="user_center">复制</a>
        </div>
    </div>
    -->
    <!-- /.page-header -->
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <!-- 主体内容部分 -->
            <div class="index-con">
                <!-- 首页主题内容 -->
                <div class="index-main">
                    <div class="mobile-content">
                        <ul class="user-operation">
                            <li class="print-title"><{$curr_shop['s_name']}></li>
                            <li class="goods-title" style="border-bottom: 1px dashed;margin-bottom: 8px;"><span>名称</span>  <span>单价</span>  <span>数量</span>   <span>金额</span></li>
                            <li class="goods-title"><span>商品一</span><span>9.9</span><span>1</span><span>9.9</span></li>
                            <li class="goods-title"><span>商品二</span><span>19.9</span><span>2</span><span>39.8</span></li>
                            <li class="goods-title"><span>商品三</span>  <span>29.9</span>  <span>3</span>   <span>89.7</span></li>
                            <li class="goods-title"><span>...</span>  <span>...</span>  <span>...</span>   <span>...</span></li>
                            <div style="height: 10px;margin:0;padding: 0;margin-top: 8px;border-top: 1px dashed;"></div>
                            <!--<li ng-class="printCfg.discounts.isBold?'bold':''" ng-show="printCfg.discounts.isPrint">优惠：99XX</li>-->
                            <li ng-class="printCfg.total.isBold?'bold':''" ng-show="printCfg.total.isPrint">合计：99XX</li>
                            <li ng-class="printCfg.orderCode.isBold?'bold':''" ng-show="printCfg.orderCode.isPrint">订单编号：99XX</li>
                            <li ng-class="printCfg.time.isBold?'bold':''" ng-show="printCfg.time.isPrint">下单时间：2018-05-12 12:23</li>
                            <!--<li ng-class="printCfg.remark.isBold?'bold':''" ng-show="printCfg.remark.isPrint">备注：99XX</li>-->
                            <li ng-class="printCfg.receiver.isBold?'bold':''" ng-show="printCfg.receiver.isPrint">收货人：99XX</li>
                            <li ng-class="printCfg.address.isBold?'bold':''" ng-show="printCfg.address.isPrint">收货地址：XX省XX市</li>
                            <li ng-class="printCfg.custom.isBold?'bold':''" ng-show="printCfg.custom.isPrint">自定义：联系电话</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con" data-right-edit style="display: block!important;">
            <div class="color-set-box" style="display: block!important;">
                <label class="label-name">选择打印机类型：</label>
                <div class="right-color">
                    <div class="radio-box">
                                        <span ng-click="changeNavColor($event)">
                                            <input type="radio" name="navColor" id="printType1" data-type="1" ng-checked="printtype==1">
                                            <label for="printType1">58mm</label>
                                        </span>
                        <span ng-click="changeNavColor($event)">
                                            <input type="radio" name="navColor" id="printType2" data-type="2" ng-checked="printtype==2">
                                            <label for="printType2">80mm</label>
                                        </span>
                    </div>
                </div>
            </div>
            <div class="color-set-box" style="display: block!important;">
                <label class="label-name">选择打印数量：（表示每台打印机打印的数量）</label>
                <div class="right-color">
                    <div class="radio-box">
                                        <span ng-click="changePrintNum($event)">
                                            <input type="radio" id="printNum1" data-num="1" ng-checked="printNum==1">
                                            <label for="printNum1">一张</label>
                                        </span>
                        <span ng-click="changePrintNum($event)">
                                            <input type="radio" id="printNum2" data-num="2" ng-checked="printNum==2">
                                            <label for="printNum2">两张</label>
                                        </span>
                        <span ng-click="changePrintNum($event)">
                                            <input type="radio" id="printNum3" data-num="3" ng-checked="printNum==3">
                                            <label for="printNum3">三张</label>
                                        </span>
                        <span ng-click="changePrintNum($event)">
                                            <input type="radio" id="printNum4" data-num="4" ng-checked="printNum==4">
                                            <label for="printNum4">四张</label>
                                        </span>
                        <span ng-click="changePrintNum($event)">
                                            <input type="radio" id="printNum5" data-num="5" ng-checked="printNum==5">
                                            <label for="printNum5">五张</label>
                                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="edit-con" style="margin-top: 0">
            <div class="header-top" data-right-edit data-id="0" style="display:block;">
                <div class="showlist-manage">
                    <!--
                    <div class="check-row">
                        <span>优惠</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="discountsPrint" data-id="discounts" ng-checked="printCfg.discounts.isPrint" ng-model="printCfg.discounts.isPrint">
                                <label for="discountsPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="discountsBold" data-id="discounts" ng-checked="printCfg.discounts.isBold" ng-model="printCfg.discounts.isBold">
                                <label for="discountsBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>商品名称</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="goodsLarge" data-id="goods" ng-checked="printCfg.goods.large" ng-model="printCfg.goods.large">
                                <label for="goodsLarge">放大</label>
                            </p>
                            <p style="width: 70%;color: red">
                                80mm打印机自动放大商品名称
                            </p>
                        </div>
                    </div>
                    <{if $appletCfg['ac_type'] == 4}>
                    <div class="check-row">
                        <span>包间/桌号</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="tablenumLarge" data-id="tablenum" ng-checked="printCfg.tablenum.large" ng-model="printCfg.tablenum.large">
                                <label for="tablenumLarge">放大</label>
                            </p>
                        </div>
                    </div>
                    <{/if}>

                    <{if $appletCfg['ac_type'] != 4}>
                    <div class="check-row">
                        <span>合计</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="totalPrint" data-id="total" ng-checked="printCfg.total.isPrint" ng-model="printCfg.total.isPrint">
                                <label for="totalPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="totalBold" data-id="total" ng-checked="printCfg.total.isBold" ng-model="printCfg.total.isBold">
                                <label for="totalBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>订单编号</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="orderCodePrint" data-id="orderCode" ng-checked="printCfg.orderCode.isPrint" ng-model="printCfg.orderCode.isPrint">
                                <label for="orderCodePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="orderCodeBold" data-id="orderCode" ng-checked="printCfg.orderCode.isBold" ng-model="printCfg.orderCode.isBold">
                                <label for="orderCodeBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>下单时间</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="timePrint" data-id="timePrint" ng-checked="printCfg.time.isPrint" ng-model="printCfg.time.isPrint">
                                <label for="timePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="timeBold" data-id="timeBold" ng-checked="printCfg.time.isBold" ng-model="printCfg.time.isBold">
                                <label for="timeBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>支付方式</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="paytypePrint" data-id="paytypePrint" ng-checked="printCfg.paytype.isPrint" ng-model="printCfg.paytype.isPrint">
                                <label for="paytypePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="paytypeBold" data-id="paytypeBold" ng-checked="printCfg.paytype.isBold" ng-model="printCfg.paytype.isBold">
                                <label for="paytypeBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <{if $appletCfg['ac_type'] == 21}>
                    <div class="check-row">
                        <span>配送费</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="postfeePrint" data-id="postfeePrint" ng-checked="printCfg.postfee.isPrint" ng-model="printCfg.postfee.isPrint">
                                <label for="postfeePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="postfeeBold" data-id="postfeeBold" ng-checked="printCfg.postfee.isBold" ng-model="printCfg.postfee.isBold">
                                <label for="postfeeBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <{/if}>
                    <!--
                    <div class="check-row">
                        <span>备注</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="remarkPrint" data-id="remark" ng-checked="printCfg.remark.isPrint" ng-model="printCfg.remark.isPrint">
                                <label for="remarkPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="remarkBold" data-id="remark" ng-checked="printCfg.remark.isBold" ng-model="printCfg.remark.isBold">
                                <label for="remarkBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>收货人</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="receiverPrint" data-id="receiver" ng-checked="printCfg.receiver.isPrint" ng-model="printCfg.receiver.isPrint">
                                <label for="receiverPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="receiverBold" data-id="receiver" ng-checked="printCfg.receiver.isBold" ng-model="printCfg.receiver.isBold">
                                <label for="receiverBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>收货地址</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="addressPrint" data-id="address" ng-checked="printCfg.address.isPrint" ng-model="printCfg.address.isPrint">
                                <label for="addressPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="addressBold" data-id="address" ng-checked="printCfg.address.isBold" ng-model="printCfg.address.isBold">
                                <label for="addressBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <{if $appletCfg['ac_type'] == 32 || $appletCfg['ac_type'] == 36}>
                    <!--
                    <div class="check-row">
                        <span>活动名称</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="activityPrint" data-id="activity" ng-checked="printCfg.activity.isPrint" ng-model="printCfg.activity.isPrint">
                                <label for="activityPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="activityBold" data-id="activity" ng-checked="printCfg.activity.isBold" ng-model="printCfg.activity.isBold">
                                <label for="activityBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>小区名称</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="communityPrint" data-id="community" ng-checked="printCfg.community.isPrint" ng-model="printCfg.community.isPrint">
                                <label for="communityPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="communityBold" data-id="community" ng-checked="printCfg.community.isBold" ng-model="printCfg.community.isBold">
                                <label for="communityBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>小区地址</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="comaddrPrint" data-id="comaddr" ng-checked="printCfg.comaddr.isPrint" ng-model="printCfg.comaddr.isPrint">
                                <label for="comaddrPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="comaddrBold" data-id="comaddr" ng-checked="printCfg.comaddr.isBold" ng-model="printCfg.comaddr.isBold">
                                <label for="comaddrBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>团长名称</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="leaderPrint" data-id="leader" ng-checked="printCfg.leader.isPrint" ng-model="printCfg.leader.isPrint">
                                <label for="leaderPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="leaderBold" data-id="leader" ng-checked="printCfg.leader.isBold" ng-model="printCfg.leader.isBold">
                                <label for="leaderBold">加粗</label>
                            </p>
                        </div>
                    </div><!--
                    <div class="check-row">
                        <span>自提/配送时间</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="receivetimePrint" data-id="receivetime" ng-checked="printCfg.receivetime.isPrint" ng-model="printCfg.receivetime.isPrint">
                                <label for="receivetimePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="receivetimeBold" data-id="receivetime" ng-checked="printCfg.receivetime.isBold" ng-model="printCfg.receivetime.isBold">
                                <label for="receivetimeBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    -->
                    <div class="check-row">
                        <span>自提/配送时间</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="senddatePrint" data-id="senddate" ng-checked="printCfg.senddate.isPrint" ng-model="printCfg.senddate.isPrint">
                                <label for="senddatePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="senddateBold" data-id="senddate" ng-checked="printCfg.senddate.isBold" ng-model="printCfg.senddate.isBold">
                                <label for="senddateBold">加粗</label>
                            </p>
                        </div>
                    </div>

                    <{/if}>
                    <{if $appletCfg['ac_type'] == 6 || $appletCfg['ac_type'] == 8}>
                    <div class="check-row">
                        <span>入驻商家名称</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="esnamePrint" data-id="esname" ng-checked="printCfg.esname.isPrint" ng-model="printCfg.esname.isPrint">
                                <label for="esnamePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="esnameBold" data-id="esname" ng-checked="printCfg.esname.isBold" ng-model="printCfg.esname.isBold">
                                <label for="esnameBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>入驻商家电话</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="esphonePrint" data-id="esphone" ng-checked="printCfg.esphone.isPrint" ng-model="printCfg.esphone.isPrint">
                                <label for="esphonePrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="esphoneBold" data-id="esphone" ng-checked="printCfg.esphone.isBold" ng-model="printCfg.esphone.isBold">
                                <label for="esphoneBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <{/if}>
                    <div class="check-row">
                        <span>自定义字段</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="userdefinedPrint" data-id="customs" ng-checked="printCfg.userdefined.isPrint" ng-model="printCfg.userdefined.isPrint">
                                <label for="userdefinedPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="userdefinedBold" data-id="customs" ng-checked="printCfg.userdefined.isBold" ng-model="printCfg.userdefined.isBold">
                                <label for="userdefinedBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <{/if}>
                    <div class="check-row" <{if $showLegwork == 0}> style="display: none" <{/if}>>
                        <span>跑腿配送序号</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="legworknumPrint" data-id="legworknum" ng-checked="printCfg.legworknum.isPrint" ng-model="printCfg.legworknum.isPrint">
                                <label for="legworknumPrint">打印</label>
                            </p>
                            <p>
                                <input type="checkbox" id="legworknumBold" data-id="legworknum" ng-checked="printCfg.legworknum.isBold" ng-model="printCfg.legworknum.isBold">
                                <label for="legworknumBold">加粗</label>
                            </p>
                        </div>
                    </div>
                    <div class="check-row">
                        <span>小程序二维码</span>
                        <div class="check-box">
                            <p>
                                <input type="checkbox" id="appletqrcodePrint" data-id="customs" ng-checked="printCfg.appletqrcode.isPrint" ng-model="printCfg.appletqrcode.isPrint">
                                <label for="appletqrcodePrint">打印</label>
                            </p>
                            <p style="width: 70%;color: red">
                                飞鹅云打印机暂不支持打印小程序二维码
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert" ><button class="btn btn-primary btn-sm" ng-click="saveCenter();">保存</button></div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/manage/centermanage/color-spectrum/spectrum.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-1.4.6.min.js"></script>
<script type="text/javascript" src="/public/manage/centermanage/js/angular-root.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>

<script>
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    } );
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        console.log("复制成功的内容是："+args.text);
        layer.msg('复制成功');
    } );

    var app = angular.module('chApp', ['RootModule']);
    app.controller('chCtrl',  ['$scope', '$http', function($scope, $http){
        $scope.printtype = <{$row['apc_print_type']}>;
        $scope.printNum = <{$row['apc_print_num']}>;
        $scope.printCfg = {
            discounts:{
                isPrint:<{$row['apc_discounts_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_discounts_bold']}> > 0 ? true : false,
            },
            total:{
                isPrint:<{$row['apc_total_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_total_bold']}> > 0 ? true : false,
            },
            orderCode:{
                isPrint:<{$row['apc_code_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_code_bold']}> > 0 ? true : false
            },
            remark:{
                isPrint:<{$row['apc_remark_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_remark_bold']}> > 0 ? true : false
            },
            receiver:{
                isPrint:<{$row['apc_receiver_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_receiver_bold']}> > 0 ? true : false
            },
            address:{
                isPrint:<{$row['apc_address_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_address_bold']}> > 0 ? true : false
            },
            activity:{
                isPrint:<{$row['apc_activity_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_activity_bold']}> > 0 ? true : false
            },
            community:{
                isPrint:<{$row['apc_community_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_community_bold']}> > 0 ? true : false
            },
            leader:{
                isPrint:<{$row['apc_leader_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_leader_bold']}> > 0 ? true : false
            },
            receivetime:{
                isPrint:<{$row['apc_receivetime_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_receivetime_bold']}> > 0 ? true : false
            },
            senddate:{
                isPrint:<{$row['apc_senddate_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_senddate_bold']}> > 0 ? true : false
            },
            esname:{
                isPrint:<{$row['apc_esname_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_esname_bold']}> > 0 ? true : false
            },
            esphone:{
                isPrint:<{$row['apc_esphone_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_esphone_bold']}> > 0 ? true : false
            },
            userdefined:{
                isPrint:<{$row['apc_customs_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_customs_bold']}> > 0 ? true : false
            },
            time:{
                isPrint:<{$row['apc_time_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_time_bold']}> > 0 ? true : false
            },
            comaddr:{
                isPrint:<{$row['apc_comaddr_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_comaddr_bold']}> > 0 ? true : false
            },
            postfee:{
                isPrint:<{$row['apc_postfee_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_postfee_bold']}> > 0 ? true : false
            },
            paytype:{
                isPrint:<{$row['apc_paytype_isprint']}> > 0 ? true : false,
                    isBold:<{$row['apc_paytype_bold']}> > 0 ? true : false
            },
            appletqrcode:{
                isPrint:<{$row['apc_qrcode_isprint']}> > 0 ? true : false,
            },
            goods:{
                large:<{$row['apc_goods_large']}> > 0 ? true : false,
            },
            legworknum:{
                isPrint:<{$row['apc_legworknum_isprint']}> > 0 ? true : false,
                isBold:<{$row['apc_legworknum_bold']}> > 0 ? true : false
            },
            tablenum:{
                large:<{$row['apc_tablenum_large']}> > 0 ? true : false,
            },
        };
        $scope.changeNavColor=function($event){
            $event.preventDefault();
            var that = $($event.target).prev('input:eq(0)');
            var value = that.data('type');
            $scope.printtype = value;
            console.log($scope.printtype);
        };
        $scope.changePrintNum=function($event){
            $event.preventDefault();
            var that = $($event.target).prev('input:eq(0)');
            var value = that.data('num');
            $scope.printNum = value;
            console.log($scope.printNum);
        };
        $scope.saveCenter = function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{
                time : 10*1000
            });
            var data = {
                'discounts_isprint'  : $scope.printCfg.discounts.isPrint==true ? 1 : 0,
                'discounts_bold'  : $scope.printCfg.discounts.isBold==true ? 1 : 0,
                'total_isprint'  : $scope.printCfg.total.isPrint==true ? 1 : 0,
                'total_bold'  : $scope.printCfg.total.isBold==true ? 1 : 0,
                'code_isprint'  : $scope.printCfg.orderCode.isPrint==true ? 1 : 0,
                'code_bold'  : $scope.printCfg.orderCode.isBold==true ? 1 : 0,
                'remark_isprint'  : $scope.printCfg.remark.isPrint==true ? 1 : 0,
                'remark_bold'  : $scope.printCfg.remark.isBold==true ? 1 : 0,
                'receiver_isprint'  : $scope.printCfg.receiver.isPrint==true ? 1 : 0,
                'receiver_bold'  : $scope.printCfg.receiver.isBold==true ? 1 : 0,
                'address_isprint'  : $scope.printCfg.address.isPrint==true ? 1 : 0,
                'address_bold'  : $scope.printCfg.address.isBold==true ? 1 : 0,
                'customs_isprint'  : $scope.printCfg.userdefined.isPrint==true ? 1 : 0,
                'customs_bold'  : $scope.printCfg.userdefined.isBold==true ? 1 : 0,
                'time_isprint'  : $scope.printCfg.time.isPrint==true ? 1 : 0,
                'time_bold'  : $scope.printCfg.time.isBold==true ? 1 : 0,
                'activity_isprint'  : $scope.printCfg.activity.isPrint==true ? 1 : 0,
                'activity_bold'  : $scope.printCfg.activity.isBold==true ? 1 : 0,
                'community_isprint'  : $scope.printCfg.community.isPrint==true ? 1 : 0,
                'community_bold'  : $scope.printCfg.community.isBold==true ? 1 : 0,
                'leader_isprint'  : $scope.printCfg.leader.isPrint==true ? 1 : 0,
                'leader_bold'  : $scope.printCfg.leader.isBold==true ? 1 : 0,
                'receivetime_isprint'  : $scope.printCfg.receivetime.isPrint==true ? 1 : 0,
                'receivetime_bold'  : $scope.printCfg.receivetime.isBold==true ? 1 : 0,
                'senddate_isprint'  : $scope.printCfg.senddate.isPrint==true ? 1 : 0,
                'senddate_bold'  : $scope.printCfg.senddate.isBold==true ? 1 : 0,
                'esname_isprint'  : $scope.printCfg.esname.isPrint==true ? 1 : 0,
                'esphone_isprint'  : $scope.printCfg.esphone.isPrint==true ? 1 : 0,
                'esname_bold'  : $scope.printCfg.esname.isBold==true ? 1 : 0,
                'esphone_bold'  : $scope.printCfg.esphone.isBold==true ? 1 : 0,
                'comaddr_isprint'  : $scope.printCfg.comaddr.isPrint==true ? 1 : 0,
                'comaddr_bold'  : $scope.printCfg.comaddr.isBold==true ? 1 : 0,
                'paytype_isprint'  : $scope.printCfg.paytype.isPrint==true ? 1 : 0,
                'paytype_bold'  : $scope.printCfg.paytype.isBold==true ? 1 : 0,
                'postfee_isprint'  : $scope.printCfg.postfee.isPrint==true ? 1 : 0,
                'postfee_bold'  : $scope.printCfg.postfee.isBold==true ? 1 : 0,
                'print_type'  : $scope.printtype,
                'print_num'  : $scope.printNum,
                'qrcode_isprint'  : $scope.printCfg.appletqrcode.isPrint==true ? 1 : 0,
                'goods_large'  : $scope.printCfg.goods.large==true ? 1 : 0,
                'legworknum_isprint'  : $scope.printCfg.legworknum.isPrint==true ? 1 : 0,
                'legworknum_bold'  : $scope.printCfg.legworknum.isBold==true ? 1 : 0,
                'tablenum_large'  : $scope.printCfg.tablenum.large==true ? 1 : 0,
            };

            console.log(data);
            $http({
                method: 'POST',
                url:    '/wxapp/print/saveTicketPrintSet',
                data:   data
            }).then(function(response) {
                layer.close(index);
                layer.msg(response.data.em);
            });
        };
    }]);

</script>