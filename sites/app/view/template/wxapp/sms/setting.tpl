<link rel="stylesheet" href="/public/manage/colorPicker/spectrum.css">
<link rel="stylesheet" href="/public/manage/css/sms.css" />
<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">
<style>
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
	.nav-tabs{z-index:1;}
</style>
<div class="row">
    <div class="col-sm-12" >
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-cog bigger-110"></i>
                        短信统计
                    </a>
                </li>
                <{if $applet['ac_type'] != 28}>
                <li>
                    <a data-toggle="tab" href="#messset">
                        短信设置
                    </a>
                </li>
                <{/if}>
            </ul>
            <div class="tab-content form-horizontal">
                <!--客服配置-->
                <div id="home" class="tab-pane active">
                    <div class="alert alert-block alert-yellow">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        提醒1: 您店铺当前剩余短信条数为<{$row['sc_useable']}>,短信充值低至<{$unit_price}>元/条！<br/>
                        提醒2: 短信条数计费策略, 70字内（含70字）计一条，超过70字，按67字/条计费。(短信对接云之讯短信通道,如有疑问请访问<a href="http://www.ucpaas.com/" target="_blank">http://www.ucpaas.com</a>)<br/>
                    </div>
                    <div class="page-header">
                        <div class="sms-view">
                            <ul class="clearfix">
                                <li>
                                    <h5 data-toggle="modal" data-target="#mySms"><{$row['sc_had_send']}></h5>
                                    <p>总发送条数</p>
                                </li>
                                <li>
                                    <h5><{$row['sc_had_send']}></h5>
                                    <p>成功到达量</p>
                                </li>
                                <li>
                                    <h5><{$row['sc_had_send']}></h5>
                                    <p>计费数量</p>
                                </li>
                                <li>
                                    <h5><{$row['sc_useable']}></h5>
                                    <p>剩余短信</p>
                                </li>
                                <li style="border-right:none;position:relative">
                                    <div class="btn btn-green btn-xs" id="charge-btn" style="margin-top:24px;">短信充值</div>
                                    <{if $sms_verify}>
                                    <a href="/wxapp/plugin/template" class="btn btn-primary btn-xs" style="margin-top:24px;"> 新增模版 </a>
                                    <{/if}>
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
                                        <th>发送手机号</th>
                                        <th>短信内容</th>
                                        <th>耗费条数</th>
                                        <th>
                                            <i class="icon-time bigger-110 hidden-480"></i>
                                            更新时间
                                        </th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <{foreach $list as $val}>
                                        <tr>
                                            <td><{$val['sr_mobile']}></td>
                                            <td><{$val['sr_text']}></td>
                                            <td><{$val['sr_count']}>条</td>
                                            <td><{date('Y-m-d H:i',$val['sr_send_time'])}></td>
                                        </tr>
                                        <{/foreach}>
                                    <tr><td colspan="4"><{$paginator}></td></tr>
                                    </tbody>
                                </table>
                            </div><!-- /.table-responsive -->
                        </div><!-- /span -->
                    </div><!-- /row -->

                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">添加/编辑签名</h4>
                                </div>
                                <div class="modal-body row">
                                    <div class="col-sm-12 ">
                                        <div  class="col-md-2"><label>短信签名:</label></div>
                                        <div  class="col-md-1 right"><label>【</label></div>
                                        <div  class="col-md-4">
                                            <input type="text" class="form-control" style="width:150px;" id="sign" placeholder="签名为店铺名称，公司简称，品牌名">
                                        </div>
                                        <div  class="col-md-1 left"><label>】</label></div>
                                        <div  class="col-md-4 right"><label><a id="access-tip"  href="javascript:;">@哪些签名不被允许</a></label></div>
                                    </div>
                                    <div class="space-4"></div>
                                    <div class="col-sm-12" style="margin-top: 10px;">
                                        <div  class="col-md-2">&nbsp;</div>
                                        <div  class="col-md-10 left"><span class="form-control-static">签名3-8字，建议使用汉字，不能包括网址或者特殊字符。</span></div>
                                    </div>
                                </div>
                                <input type="hidden" id="hid_id" value="0">
                                <input type="hidden" id="old_sign" value="">
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-green btn-xs btn-save"> 保 存 </button>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                <!--
                                <dl>
                                    <dt></dt>
                                    <dd>
                                        <span class="read-agreement">
                                            阅读并同意<a href="http://bbs.youzan.com/forum.php?mod=viewthread&amp;tid=407165" target="_blank">《有赞营销功能订购协议》</a>
                                        </span>
                                    </dd>
                                </dl>
                                -->
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
                            <p class="messtype-title">预约留言通知短信模板&nbsp;(通知短信将发送联系人<{$curr_shop['s_contact']}>：<{$curr_shop['s_phone']}><a href="/wxapp/mall/shopSetup" style="color: blue">修改</a>)</p>
                            <ul>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['xcxyytz']['tit']}></h4>
                                        <p><{$sms_tpl['xcxyytz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='xcxyytz' type='checkbox' <{if $sms && $sms['ss_xcxyytz_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='xcxyytz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['xcxsqrz']['tit']}></h4>
                                        <p><{$sms_tpl['xcxsqrz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='xcxsqrz' type='checkbox' <{if $sms && $sms['ss_xcxsqrz_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='xcxsqrz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['kfxxtz']['tit']}></h4>
                                        <p><{$sms_tpl['kfxxtz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='kfxxtz' type='checkbox' <{if $sms && $sms['ss_kfxxtz_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='kfxxtz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="seller-mess">
                            <p class="messtype-title">卖家短信模板&nbsp;(通知短信将发送联系人<{$curr_shop['s_contact']}>：<{$curr_shop['s_phone']}><a href="/wxapp/mall/shopSetup" style="color: blue">修改</a>)</p>
                            <ul>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['ddzfcg']['tit']}></h4>
                                        <p><{$sms_tpl['ddzfcg']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='ddzfcg' type='checkbox' <{if $sms && $sms['ss_ddzfcg_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='ddzfcg'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['ddwctz']['tit']}></h4>
                                        <p><{$sms_tpl['ddwctz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='ddwctz' type='checkbox' <{if $sms && $sms['ss_ddwctz_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='ddwctz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['sqtktz']['tit']}></h4>
                                        <p><{$sms_tpl['sqtktz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='sqtktz' type='checkbox' <{if $sms && $sms['ss_sqtktz_s'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='sqtktz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="buyer-mess">
                            <p class="messtype-title">买家短信模板（通知短信将发送给收货人）</p>
                            <ul>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['mjfhtz']['tit']}></h4>
                                        <p><{$sms_tpl['mjfhtz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='mjfhtz' type='checkbox' <{if $sms && $sms['ss_mjfhtz_b'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='mjfhtz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['tytktz']['tit']}></h4>
                                        <p><{$sms_tpl['tytktz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='tytktz' type='checkbox' <{if $sms && $sms['ss_tytktz_b'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='tytktz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="mess-temp">
                                        <h4><{$sms_tpl['jjtktz']['tit']}></h4>
                                        <p><{$sms_tpl['jjtktz']['txt']}></p>
                                    </div>
                                    <div class="state-box">
                                        <label>状态：</label>
                                        <div class="switch-box">
                                            <span class='tg-list-item'>
                                                <input class='tgl tgl-light' id='jjtktz' type='checkbox' <{if $sms && $sms['ss_jjtktz_b'] eq 1}>checked<{/if}>>
                                                <label class='tgl-btn' for='jjtktz'></label>
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--提交操作-->
                    <div style="padding: 10px 0;margin-top: 10px;">
                        <button class="btn btn-md btn-blue save-sms-cfg">&nbsp;保 存&nbsp;</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal_recharge" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 560px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="stopShow(this)">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    短信充值
                </h4>
            </div>
            <div class="modal-body">
                <!--修改水印-->
                <div id="update-watermark">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-3 control-label no-padding-right">短信充值：</label>
                        <div class="col-sm-8 level-box">
                            <input type="text" class="form-control" name="update_watermark" id="update_watermark"  style="width: 100%">
                            <p id="watermark_tips" style="color: red;font-size: 12px;">请确认您的充值金额，充值金额不能低于50元</p>
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
        var ddzfcg    = $('#ddzfcg').is(':checked');
        var ddwctz    = $('#ddwctz').is(':checked');
        var sqtktz    = $('#sqtktz').is(':checked');
        var mjfhtz    = $('#mjfhtz').is(':checked');
        var tytktz    = $('#tytktz').is(':checked');
        var jjtktz    = $('#jjtktz').is(':checked');
        var xcxyytz   = $('#xcxyytz').is(':checked');
        var xcxsqrz   = $('#xcxsqrz').is(':checked');
        var kfxxtz    = $('#kfxxtz').is(':checked');
        var  data = {
            'ddzfcg_s': ddzfcg ? 1 : 0,
            'ddwctz_s': ddwctz ? 1 : 0,
            'sqtktz_s': sqtktz ? 1 : 0,
            'mjfhtz_b': mjfhtz ? 1 : 0,
            'tytktz_b': tytktz ? 1 : 0,
            'jjtktz_b': jjtktz ? 1 : 0,
            'xcxyytz_s': xcxyytz ? 1 : 0,
            'xcxsqrz_s': xcxsqrz ? 1 : 0,
            'kfxxtz_s': kfxxtz ? 1 : 0
        };
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
        var url = '/wxapp/plugin/wxAlipayChargeQrcodeSms?channel='+type[index]+'&money='+money;
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
    $('.btn-save').on('click', function () {
        var id   =  $('#hid_id').val();
        var sign =  $('#sign').val();
        var old_sign = $('#old_sign').val();
        if(!old_sign || sign != old_sign){
            var data = {
                'id'   : id,
                'sign' : sign,
                'old'  : old_sign
            };
            $.ajax({
                type  : 'post',
                url   : '/wxapp/plugin/saveSms',
                data  : data,
                dataType  : 'json',
                success   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            $('#myModal').modal('hide');
        }
    });
    $('.btn-syn').on('click', function () {
        var id   =  $(this).data('id');
        if(id){
            var data = {
                'id'   : id
            };
            $.ajax({
                type  : 'post',
                url   : '/wxapp/plugin/synSms',
                data  : data,
                dataType  : 'json',
                success   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }
    });

    function getNowFormatDate(nS)
    {
        var day = new Date(parseInt(nS) * 1000);
        var Year = 0;
        var Month = 0;
        var Day = 0;
        var CurrentDate = "";
        //初始化时间
        //Year= day.getYear();//有火狐下2008年显示108的bug
        Year= day.getFullYear();//ie火狐下都可以
        Month= day.getMonth()+1;
        Day = day.getDate();
        Hour = day.getHours();
        Minute = day.getMinutes();
        // Second = day.getSeconds();
        CurrentDate += Year + "-";
        if (Month >= 10 )
        {
            CurrentDate += Month + "-";
        }
        else
        {
            CurrentDate += "0" + Month + "-";
        }
        if (Day >= 10 )
        {
            CurrentDate += Day ;
        }
        else
        {
            CurrentDate += "0" + Day ;
        }
        if(Hour >= 10){
            CurrentDate += " " + "0" + Hour ;
        }else{
            CurrentDate += " " + Hour ;
        }
        if(Minute >=10){
            CurrentDate += ":" + "0" + Minute ;
        }else{
            CurrentDate += ":" + Minute ;
        }
        return CurrentDate;
    }
</script>