<link rel="stylesheet" href="/public/manage/colorPicker/spectrum.css">
<link rel="stylesheet" href="/public/manage/css/sms.css" />
<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">
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

    .table.table-avatar tbody>tr>td { line-height: 48px; }
    .radio-box { margin-left: 0; }
    .form-horizontal .control-label { font-weight: bold; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "开启\a0\a0\a0\a0\a0\a0\a0\a0\a0禁止"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #D15B47; border: 1px solid #CC4E38; }
    .right-kg { width: 100%; border: 1px solid #ccc; border-radius: 0 4px 4px 0; padding: 3px 10px; }
    .tab-pane .input-group { width: 100%; }
    .tab-pane .input-group .input-group-addon:first-child { width: 180px; text-align: right; }

    /*短信通知设置*/
    .message-temp { margin: 0 auto; }
    .messtype-title { font-size: 15px; line-height: 40px; font-weight: bold; }
    .seller-mess { margin-bottom: 10px; }
    .seller-mess li, .buyer-mess li { width: 30%; display: inline-block; max-width: 250px; margin-bottom: 5px; margin-right: 15px; }
    .mess-temp { border: 1px solid #e8e8e8; box-shadow: 2px 2px 5px #ddd; border-radius: 3px; width: 100%; background-color: #fbfbfb; padding-bottom: 6px;}
    .mess-temp h4 { margin:0;border-bottom: 1px solid #e8e8e8; line-height: 35px; padding: 0 10px; font-size: 15px; background-color: #f6f6f6; font-family: "Microsoft Yahei"; }
    .mess-temp p { margin: 0; padding: 0 10px; line-height: 22px; font-size: 14px; color: #888; height: 66px; box-sizing: border-box; display: -webkit-box !important; overflow: hidden; text-overflow: ellipsis; word-break: break-all; -webkit-box-orient: vertical; -webkit-line-clamp: 3; margin-top: 5px;}
    .state-box { margin-top: 5px; }
    .state-box label { font-size: 14px; line-height: 35px; font-weight: normal; float: left; }
    .state-box .switch-box { height: 35px; margin-left: 50px; box-sizing: border-box; padding: 4px 0 3px; }
</style>

<div class="row" >
    <div class="col-sm-12" >
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-cog bigger-110"></i>
                        配送统计
                    </a>
                </li>
                <li>
                    <a data-toggle="tab" href="#messset">
                        配送设置
                    </a>
                </li>
            </ul>
            <div class="tab-content form-horizontal">
                <!--客服配置-->
                <div id="home" class="tab-pane active">
                    <div class="page-header">
                        <div class="sms-view">
                            <ul class="clearfix">
                                <li>
                                    <h5 data-toggle="modal" data-target="#mySms"><{if $row['ec_send_num']}><{$row['ec_send_num']}><{else}>0<{/if}></h5>
                                    <p>已完成配送</p>
                                </li>
                                <li>
                                    <h5><{if $row['ec_spend']}><{$row['ec_spend']}><{else}>0<{/if}></h5>
                                    <p>已使用金额</p>
                                </li>
                                <li>
                                    <h5><{if $row['ec_balance']}><{$row['ec_balance']}><{else}>0<{/if}></h5>
                                    <p>剩余金额</p>
                                </li>
                                <li style="border-right:none;position:relative">
                                    <div class="btn btn-green btn-xs" id="charge-btn" style="margin-top:24px;">预存充值</div>
                                    <div class="btn btn-green btn-xs" id="rule-show-btn" style="margin-top:24px;" data-toggle="modal" data-target="#ruleModal" >配送费计算规则</div>
                                    <!--
                                    <a href="/wxapp/plugin/smsRemind" class="btn btn-info btn-xs" style="margin-top:24px;"> 设置余额不足提醒 </a>
                                    -->
                                    <div class="ui-popover ui-popover-input top-center charge-input">
                                        <div class="ui-popover-inner">
                                            <input type="text" class="money-input" id="money-input" autofocus="autofocus" placeholder="请输入充值金额">
                                            <a class="ui-btn ui-btn-primary js-save js-app-order" href="javascript:;">确定</a>
                                            <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide()">取消</a>
                                        </div>
                                        <div class="arrow"></div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="space"></div>
                    </div><!-- /.page-header -->

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>订单号</th>
                                        <th>配送费</th>
                                        <th>配送状态</th>
                                        <th>配送员</th>
                                        <th>配送员手机号</th>
                                        <th>配送描述</th>
                                        <th>
                                            <i class="icon-time bigger-110 hidden-480"></i>
                                            更新时间
                                        </th>
                                        <th>
                                            <i class="icon-time bigger-110 hidden-480"></i>
                                            完成时间
                                        </th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <{foreach $list as $val}>
                                        <tr>
                                            <td><{$val['er_tid']}></td>
                                            <td><{$val['er_money']}></td>
                                            <td style="color: red"><{$statusNote[$val['er_stauts']]}></td>
                                            <td><{$val['er_carrier_driver_name']}></td>
                                            <td><{$val['er_carrier_driver_phone']}></td>
                                            <td><{$val['er_description']}></td>
                                            <td><{date('Y-m-d H:i',$val['er_update_time'])}></td>
                                            <td><{if $val['er_finish_time']}><{date('Y-m-d H:i',$val['er_finish_time'])}><{/if}></td>
                                            <td>
                                                <{if $val['er_stauts'] == 0 || $val['er_stauts'] == 1}>
                                                <a href="javascript:;" data-tid="<{$val['er_tid']}>" onclick="cancelEleOrder(this)">取消订单</a> -
                                                <{/if}>
                                                <{if $val['er_stauts'] == 1 || $val['er_stauts'] == 3 || $val['er_stauts'] == 4}>
                                                <a href="javascript:;" data-tid="<{$val['er_tid']}>" onclick="complainEleOrder(this)">订单投诉</a> -
                                                <{/if}>
                                            </td>
                                        </tr>
                                        <{/foreach}>
                                    <tr><td colspan="4"><{$paginator}></td></tr>
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /span -->
                    </div><!-- /row -->


                    <div id="layer-dinggou" style="display:none;">
                        <div class="zent-dialog-body clearfix">
                            <div class="pay-info">
                                <dl>
                                    <dt>应用服务名称：</dt>
                                    <dd>短信充值</dd>
                                </dl>
                                <dl>
                                    <dt>生效时间：</dt>
                                    <dd>支付成功后，短信立即到账</dd>
                                </dl>
                                <dl>
                                    <dt>订购店铺：</dt>
                                    <dd><{$curr_shop['s_name']}></dd>
                                </dl>
                                <dl>
                                    <dt>应用服务价格：</dt>
                                    <dd><span class="money"></span></dd>
                                </dl>
                                <div class="pay-info-line"></div>
                                <dl>
                                    <dt>支付方式：</dt>
                                    <dd>店铺余额(￥<{$curr_shop['s_recharge']}>)支付</dd>
                                    <dd>
                                        <div class="not-sufficient-funds">
                                            <span class="red">提醒：</span>若当前店铺余额不足，请先充值，成功后再进行订购
                                        </div>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>合计：</dt>
                                    <dd><span class="total-money"></span></dd>
                                </dl>
                                <dl>
                                    <dt></dt>
                                    <dd>
                                        <a href="javascript:;" target="_blank" onclick="payCharge(this, event)" class="zent-btn zent-btn-danger zent-btn-large">充值</a>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <{include file="../bs-alert-tips.tpl"}>
                </div>
                <div id="messset" class="tab-pane">
                    <div class="message-temp">
                        <div class="buyer-mess">
                            <ul>
                                <li style="width: 100%;max-width: inherit">
                                    <div class="state-box" style="height: 60px;">
                                        <span style="float: left;position: relative;top: 10px;">蜂鸟配送：</span>
                                        <label id="choose-onoff" class="choose-onoff">
                                            <input name="sms_start" class="ace ace-switch ace-switch-5" id="sendOpen" data-type="open" onchange="changeEleOpen()" type="checkbox" <{if $sendCfg && $sendCfg['acs_ele_delivery']}> checked<{/if}>>
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                    <div class="state-box">
                                        <span>订单支付</span>
                                        <input type="number" id="timeout" style="display: inline-block;width: 100px;" class="form-control" name="timeout" value="<{if $row['ec_send_timeout']}><{$row['ec_send_timeout']}><{else}>10<{/if}>">
                                        <span>分钟后通知订单配送</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--提交操作-->
                    <div style="padding: 10px 0;margin-top: 10px;">
                        <button class="btn btn-md btn-blue save-ele-cfg">&nbsp;保 存&nbsp;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    取消订单
                </h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <div class="form-group">
                    <input type="hidden" id="cancel-id">
                    <label for="kind2" class="control-label">取消原因：</label>
                    <select name="cancel-code" id="cancel-code" class="control-group">
                        <option value="1">订单长时间未分配骑手</option>
                        <option value="2">分配骑手后，骑手长时间未取件</option>
                        <option value="3">骑手告知不配送，让取消订单</option>
                        <option value="4">商家缺货/无法配送/已售完</option>
                        <option value="5">商户联系不上门店/门店关门了</option>
                        <option value="6">商家发错单</option>
                        <option value="7">商户/顾客自身定位错误</option>
                        <option value="8">商家改其他第三方配送</option>
                        <option value="8">顾客下错单/临时不想要了</option>
                        <option value="10">顾客自取/不在家/要求另改时间配送</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="cancel-order">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="complainModal" tabindex="-1" role="dialog" aria-labelledby="complainModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <input type="hidden" id="now_expire" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    投诉订单
                </h4>
            </div>
            <div class="modal-body" style="text-align: center">
                <div class="form-group">
                    <input type="hidden" id="complain-id">
                    <label for="kind2" class="control-label">投诉原因：</label>
                    <select name="complain-code" id="complain-code" class="control-group">
                        <option value="150">未保持餐品完整</option>
                        <option value="160">服务态度恶劣</option>
                        <option value="190">额外索取费用</option>
                        <option value="170">诱导收货人或商户退单</option>
                        <option value="140">提前点击送达</option>
                        <option value="210">虚假标记异常</option>
                        <option value="220">少餐错餐</option>
                        <option value="200">虚假配送</option>
                        <option value="130">未进行配送</option>
                        <option value="230">其他</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="complain-order">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="myModal_recharge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 560px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="stopShow(this)">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    配送费预存
                </h4>
            </div>
            <div class="modal-body">
                <!--修改水印-->
                <div id="update-watermark">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">预存金额：</label>
                        <div class="col-sm-8 level-box">
                            <input type="text" class="form-control" name="update_watermark" id="update_watermark"  style="width: 100%">
                            <p id="watermark_tips" style="color: red;font-size: 12px;">请确认您的充值金额</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="stopShow(this)">取消
                        </button>
                        <button type="button" class="btn btn-primary" id="conform-update-watermark">
                            确认充值
                        </button>
                    </div>
                </div>
                <div class="nowbuy-con" style="display: none">
                    <div class="zent-dialog-body clearfix">
                        <div class="pay-info" style="margin-bottom: 5px;">
                            <dl>
                                <dt>生效时间：</dt>
                                <dd>支付成功后，立即生效</dd>
                            </dl>
                            <dl>
                                <dt>充值金额：</dt>
                                <dd><span class="money" id="produce-price">￥50</span></dd>
                            </dl>
                        </div>
                        <div class="ui-nav clearfix">
                            <ul class="pull-left">
                                <li class="pay-way-nav js-online-pay active">
                                    <a href="javascript:;">微信扫码支付</a>
                                </li>
                                <li class="pay-way-nav js-offline-pay">
                                    <a href="javascript:;">支付宝扫码支付</a>
                                </li>
                            </ul>
                        </div>
                        <div class="online-pay-content" style="display: block;">
                            <div class="zent-alert">
                                <span class="red">提醒：</span>支付成功后，立即生效
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>微信扫码支付，成功后立即生效</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                        <div class="online-pay-content" style="display: none;">
                            <div class="zent-alert">
                                <span class="red">提醒：</span>支付成功后，立即生效
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>支付宝扫码支付，支付成功后立即生效</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 850px;">
        <div class="modal-content">
            <input type="hidden" id="auto_type" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="shelfAutoModalLabel">
                    配送费计算规则
                </h4>
            </div>
            <div class="modal-body">
                <!--<div style="color: red">
                    <p>春节前7天：即2019年01月28日至2019年02月03日, 加价5元/单</p>
                    <p>春节期间7天：即2019年02月04日至2019年02月10日, 加价10元/单</p>
                    <p>春节后7天：即2019年02月11日至2019年02月17日, 加价5元/单</p>
                </div>-->
                <table class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th style="text-align: center">城市基础价(<{$company}>)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <td><{$baseFee}>元</td>
                    </tbody>
                </table>
                <table class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">距离加价</th>
                    </tr>
                    <tr>
                        <th>配送距离</th>
                        <th>加价规则（元/单）</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>[0-1)km</td>
                        <td>0元</td>
                    </tr>
                    <tr>
                        <td>[1-2)km</td>
                        <td>1元</td>
                    </tr>
                    <tr>
                        <td>[2-3)km</td>
                        <td>2元</td>
                    </tr>
                    <tr>
                        <td>[3-4)km</td>
                        <td>4元</td>
                    </tr>
                    <tr>
                        <td>[4-5)km</td>
                        <td>6元</td>
                    </tr>
                    <tr>
                        <td>[5-6)km</td>
                        <td>8元</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th colspan="2" style="text-align: center">重量加价</th>
                    </tr>
                    <tr>
                        <th>重量</th>
                        <th>加价规则（元/单）</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>[0-5]Kg</td>
                        <td>0元</td>
                    </tr>
                    <tr>
                        <td>(5-15]Kg</td>
                        <td>每增加1KG加0.5元</td>
                    </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-hover table-avatar">
                    <thead>
                    <tr>
                        <th colspan="4" style="text-align: center">时段加价</th>
                    </tr>
                    <tr>
                        <th>时段类型</th>
                        <th>加价规则（元/单）</th>
                        <th>时间段</th>
                        <th>备注</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>午高峰</td>
                        <td>￥2.00</td>
                        <td>11:00-13:00</td>
                        <td>
                            以下单时间为准
                        </td>
                    </tr>
                    <tr>
                        <td>午夜加价</td>
                        <td>￥2.00</td>
                        <td>22:00-02:00</td>
                        <td>
                            以下单时间为准
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
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
    $('.btn-start').on('click',function(){
        var data = {
            'id'	: $(this).data('id')
        };
        indexTplStart(data);
    });

    // 保存短信通知设置
    $('.save-sms-cfg').on('click',function(){
        console.log(data);
        var url = '/wxapp/plugin/saveSmsSetting';
        plumAjax(url,data,0)
    });
</script>
<script type="text/javascript">
    /*隐藏充值弹出框*/
    function optshide(){
        $('.charge-input').stop().fadeOut();
    }
    var watermark = '',currSwitch = 0,currSuid = '<{$curr_shop['s_unique_id']}>',money=0;
    $(function(){
        /*短信记录弹出框出现时回调*/
        $(".ui-popover-inner .ui-btn").click(function(event) {
            event.preventDefault();
        });
        $('.charge-input').click(function(event) {
            event.stopPropagation();
        });
        $('body').click(function(event) {
            optshide();
        });

        /*充值弹出框*/
        $("#charge-btn").click(function(event) {
            /*event.stopPropagation();
             $(".money-input").val('');
             $(this).parent().find('.charge-input').stop().fadeToggle();
             $("#money-input")[0].focus();*/
            $('#myModal_recharge').modal('show');
        });
        $('#conform-update-watermark').on('click',function(){
            money = $('#update_watermark').val();
            if(money<50){
                layer.msg('最少充值50元');
                return;
            }
            if(money>=50){
                $('#produce-price').html('￥'+money);
                $('#update-watermark').stop().hide();
                $('.nowbuy-con').stop().show();
                changePay(null);
            }
        });
        /*支付方式tab栏切换*/
        $(".pay-way-nav").click(function(event) {
            currSwitch++;
            var that    = this;
            changePay(that);
        });
    });
    function changePay(obj) {
        obj = obj ? obj : $('.pay-way-nav').first();
        $(obj).addClass('active').siblings().removeClass('active');
        var index = $(obj).index();
        $(".online-pay-content").eq(index).stop().show();
        $(".online-pay-content").eq(index).siblings('.online-pay-content').stop().hide();
        if (currSwitch < 2) {
            qrcode(index);
        }
    }
    function hadPay(obj, event) {
        event.preventDefault();
        location.reload();
    }
    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        money       = $('#update_watermark').val();
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/plugin/wxAlipayChargeQrcodeEle?channel='+type[index]+'&money='+money;
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }
    //隐藏
    function stopShow(ele){
        $('.nowbuy-con').stop().hide();
        $('#update-watermark').stop().show();
    }


    $('#access-tip').on('click',function(){
        layer.tips('1.含有特殊字符（如$@^等）的签名。<br/>2.与公司、商标和网站名无关的签名', '#access-tip', {
            tips: [3, '#3595CC'],
            time: 4000
        });
    });
    $('.btn-sms').on('click', function () {
        var type = $(this).data('type');
        var id = 0,sign = '';
        if(type == 'edit'){
            id   =  $(this).data('id');
            sign =  $(this).data('sign');
        }
        $('#hid_id').val(id);
        $('#sign').val(sign);
        $('#old_sign').val(sign);
        $('#myModal').modal('show');
    });
    $('.save-ele-cfg').on('click', function () {
        var timeout   =  $('#timeout').val();
        var data = {
            'timeout'   : timeout,
        };
        $.ajax({
            type  : 'post',
            url   : '/wxapp/plugin/saveEleSetting',
            data  : data,
            dataType  : 'json',
            success   : function(ret){
                layer.msg(ret.em);
            }
        });

    });

    function cancelEleOrder(e) {
        var tid = $(e).data('tid');
        $('#cancel-id').val(tid);
        $('#cancelModal').modal('show');
    }

    $('#cancel-order').click(function () {
        var tid = $('#cancel-id').val();
        var code = $('#cancel-code').val();
        var data = {
            'tid'   : tid,
            'code'  : code
        };
        $.ajax({
            type  : 'post',
            url   : '/wxapp/plugin/cancelEleOrder',
            data  : data,
            dataType  : 'json',
            success   : function(ret){
                if(ret.ec == 200){
                    window.location.reload();
                }
                layer.msg(ret.em);
            }
        });
    })

    function complainEleOrder(e) {
        var tid = $(e).data('tid');
        $('#complain-id').val(tid);
        $('#complainModal').modal('show');


    }

    $('#complain-order').click(function () {
        var tid = $('#complain-id').val();
        var code = $('#complain-code').val();
        var data = {
            'tid'   : tid,
            'code'  : code
        };
        $.ajax({
            type  : 'post',
            url   : '/wxapp/plugin/complainEleOrder',
            data  : data,
            dataType  : 'json',
            success   : function(ret){
                if(ret.ec == 200){
                    window.location.reload();
                }
                layer.msg(ret.em);
            }
        });
    })

    function changeEleOpen() {
        var open   = $('#sendOpen:checked').val();
        var data = {
            value:open
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/plugin/changeEleSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                console.log(ret.em);
            }
        });
    }

    function delEleOrder(e) {
        var id = $(e).data('id')
        if(id){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/plugin/delEleOrder',
                'data'  : {'id': id},
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                    layer.msg(ret.em);
                }
            });
        }
    }

</script>