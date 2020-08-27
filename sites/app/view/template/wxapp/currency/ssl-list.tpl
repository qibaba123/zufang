<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">

<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a href="#" type="button" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;" onclick="buySslCertificate()" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>购买证书</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>公司名称</th>
                            <th>部门</th>
                            <th>座机号</th>
                            <th>姓名</th>
                            <th>职位</th>
                            <th>手机号</th>
                            <th>域名</th>
                            <th>开始时间</th>
                            <th>终止时间</th>
                            <th>证书路径</th>
                            <th>地址</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr >
                                <td><{$val['ss_company']}></td>
                                <td><{$val['ss_department']}></td>
                                <td><{$val['ss_tel']}></td>
                                <td><{$val['ss_name']}></td>
                                <td><{$val['ss_job']}></td>
                                <td><{$val['ss_mobile']}></td>
                                <td><{$val['ss_domain']}></td>
                                <td><{date('Y-m-d',$val['ss_start_time'])}></td>
                                <td><{date('Y-m-d',$val['ss_end_time'])}></td>
                                <td><{$val['ss_cert_path']}></td>
                                <td><{$val['ss_address']}></td>
                                <td><{$status[$val['ss_status']]}></td>
                                <td>
                                    <a href="#" class="btn btn-blue btn-xs edit-info"
                                       data-id="<{$val['ss_id']}>"
                                       data-tid="<{$val['ss_tid']}>"
                                       data-company="<{$val['ss_company']}>"
                                       data-department="<{$val['ss_department']}>"
                                       data-tel="<{$val['ss_tel']}>"
                                       data-job="<{$val['ss_job']}>"
                                       data-mobile="<{$val['ss_mobile']}>"
                                       data-domain="<{$val['ss_domain']}>"
                                       data-address="<{$val['ss_address']}>"
                                       data-contact="<{$val['ss_name']}>"
                                       data-toggle="modal" data-target="#companyInfoModal">补全信息</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="13"><{$pageHtml}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 模态框扫描支付（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 560px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    购买ssl证书
                </h4>
            </div>
            <div class="modal-body">
                <div class="nowbuy-con" style="display: block">
                    <div class="zent-dialog-body clearfix">
                        <div class="pay-info" style="margin-bottom: 5px;">
                            <dl>
                                <dt style="font-size: 18px;text-align:left;">证书价格：</dt>
                                <dd><span class="money" id="produce-price">￥800/年</span></dd>
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
                                <span class="red">提醒：</span>支付成功后，请补全信息并联系客服处理
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>支付成功后，请补全信息并联系客服处理</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://bbs.fenxiaobao.xin/forum.php?mod=viewthread&tid=210&page=1&extra=#pid9844" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                        <div class="online-pay-content" style="display: none;">
                            <div class="zent-alert">
                                <span class="red">提醒：</span>支付成功后，请补全信息并联系客服处理
                            </div>
                            <div class="pay-qrcode image-code">
                                <img src="/public/manage/images/qrcode-placeholder.gif" alt="充值二维码" class="js-img-src">
                            </div>
                            <div class="weixin-btn">
                                <p>支付宝扫码支付，请补全信息并联系客服处理</p>
                                <input class="zent-btn zent-btn-primary js-recharge-success" onclick="hadPay(this, event)" type="submit" value="我已成功支付">
                                <a href="http://wpa.qq.com/msgrd?v=3&uin=2271654662&site=qq&menu=yes" target="_blank" class="zent-btn zent-btn-primary-outline js-recharge-fail btn-last">支付遇到问题</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="companyInfoModal" tabindex="-1" role="dialog" aria-labelledby="companyInfoModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="ssltid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    补全申请证书信息
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">域名：</label>
                    <div class="col-sm-8">
                        <input id="domain" class="form-control" placeholder="请填写域名信息" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">公司名称：</label>
                    <div class="col-sm-8">
                        <input id="company" class="form-control" placeholder="请填写公司名称" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">部门：</label>
                    <div class="col-sm-8">
                        <input id="department" class="form-control" placeholder="请填写申请部门" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">联系人：</label>
                    <div class="col-sm-8">
                        <input id="contact" class="form-control" placeholder="请填写联系人" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">联系人职位：</label>
                    <div class="col-sm-8">
                        <input id="position" class="form-control" placeholder="请填写联系人职位" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">手机：</label>
                    <div class="col-sm-8">
                        <input id="mobile"  class="form-control" placeholder="请填写联系人手机号码" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">座机号：</label>
                    <div class="col-sm-8">
                        <input id="phone" class="form-control" placeholder="请填写联系电话" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">详细地址：</label>
                    <div class="col-sm-8">
                        <input id="address" class="form-control" placeholder="请填写详细地址" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-info-ssl">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var currSwitch = 0,currSuid = '<{$curr_shop['s_unique_id']}>';

     function buySslCertificate(){
        // $('#myModal').modal('show');
         changePay(null);
    }
//    $(function () {
//        $('.buySslCertificate').on('click',function(){
//            $('#myModal').modal('show');
//            changePay(null);
//        });
//    });
    /*支付方式tab栏切换*/
    $(".pay-way-nav").click(function(event) {
        currSwitch++;
        var that    = this;
        changePay(that);
    });

    //获取扫码
    function qrcode(index) {
        layer.load(2, {time: 1000});
        var type    = ['wxpay', 'alipay'];
        var url = '/wxapp/currency/wxAlipayChargeQrcode?unique='+currSuid+'&channel='+type[index];
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }

    function hadPay(obj, event) {
        event.preventDefault();
        var new_url = "/wxapp/currency/sslList";
        window.location.replace(new_url);
    }

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

    $('.edit-info').on('click',function () {
        $('#ssltid').val($(this).data('tid'));
        $('#domain').val($(this).data('domain'));
        $('#company').val($(this).data('company'));
        $('#department').val($(this).data('department'));
        $('#contact').val($(this).data('contact'));
        $('#position').val($(this).data('job'));
        $('#mobile').val($(this).data('mobile'));
        $('#phone').val($(this).data('tel'));
        $('#address').val($(this).data('address'));
    });

    $('#confirm-info-ssl').on('click',function(){
        var ssltid = $('#ssltid').val();
        var domain = $('#domain').val();
        var company = $('#company').val();
        var department = $('#department').val();
        var contact = $('#contact').val();
        var position = $('#position').val();
        var mobile = $('#mobile').val();
        var phone = $('#phone').val();
        var address = $('#address').val();
        var data = {
            ssltid      : ssltid,
            domain      : domain,
            company     : company,
            department  : department,
            name        : contact,
            job         : position,
            mobile      : mobile,
            tel         : phone,
            address     : address
        }
        if(ssltid && domain && company){
            var loading = layer.load(2);
            $.ajax({
                'type': 'post',
                'url': '/wxapp/currency/updateSsl',
                'data': data,
                'dataType': 'json',
                'success': function (ret) {
                    layer.close(loading);
                    layer.msg(ret.em);
                    if (ret.ec == 200) {
                         window.location.reload();
                    }
                }
            });
        }
    });

</script>