<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/bindsetting.css?1">

<div id="content-con">
    <div  id="mainContent">
        <div class="alert alert-block alert-yellow" style="margin-bottom: 10px;">
            <button type="button" class="close" data-dismiss="alert">
                <i class="icon-remove"></i>
            </button>
            开通城市
            <div class="update-content">
                北京 / 上海 / 重庆 / 上海 / 测试 / 云南 大理 / 云南 玉溪 / 云南 昆明 / 内蒙古 赤峰 / 吉林 长春 / 四川 成都 / 四川 乐山 / 宁夏 吴忠 / 安徽 合肥 / 安徽 巢湖 / 安徽 池州 / 山东 青岛 / 山东 日照 / 山东 淄博 / 山东 烟台 / 山东 济南 / 山西 太原 / 山西 长治 / 广东 东莞 / 广东 惠州 / 广东 湛江 / 广东 广州 / 广东 深圳 / 广东 珠海 / 广东 佛山 / 广西 柳州 / 新疆 乌鲁木齐 / 江苏 常州 / 江苏 南京 / 江苏 盐城 / 江苏 苏州 / 江苏 盐城 / 江苏 徐州 / 江西 赣州 / 河北 石家庄 / 河北 廊坊 / 河北 衡水 / 河北 邯郸 / 河北 保定 / 河南 洛阳 / 河南 郑州 / 河南 永城 / 河南 新乡 / 浙江 杭州 / 浙江 建德 / 浙江 台州 / 浙江 温州 / 浙江 丽水 / 浙江 慈溪 / 浙江 临安 / 浙江 金华 / 浙江 宁波 / 海南 三亚 / 海南 海口 / 湖北 武汉 / 湖南 岳阳 / 湖南 长沙 / 福建 泉州 / 福建 厦门 / 福建 南平 / 福建 莆田 / 贵州 贵阳 / 辽宁 沈阳 / 陕西 西安 / 青海 西宁 / 黑龙江 大庆 / 黑龙江 哈尔滨 / 黑龙江 齐齐哈尔 / 黑龙江 佳木斯 /
            </div>
        </div>
        <div class="page-header">
            <a href="#" type="button" class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;" onclick="buyVrOrderCertificate()" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>VR拍摄下单</a>
        </div><!-- /.page-header -->
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>联系人</th>
                            <th>联系电话</th>
                            <th>省份</th>
                            <th>城市</th>
                            <th>详细地址</th>
                            <th>场景个数</th>
                            <th>场景类型</th>
                            <th>状态</th>
                            <th>下单时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr >
                                <td><{$val['avo_contact']}></td>
                                <td><{$val['avo_mobile']}></td>
                                <td><{$val['avo_province']}></td>
                                <td><{$val['avo_city']}></td>
                                <td><{$val['avo_address']}></td>
                                <td><{$val['avo_scene_num']}></td>
                                <td><{$val['avo_scene_type']}></td>
                                <td><{$status[$val['avo_status']]}></td>
                                <td><{date('Y-m-d',$val['avo_create_time'])}></td>
                                <td>
                                    <a href="#" class="btn btn-blue btn-xs edit-info"
                                       data-id="<{$val['avo_id']}>"
                                       data-tid="<{$val['avo_tid']}>"
                                       data-contact="<{$val['avo_contact']}>"
                                       data-mobile="<{$val['avo_mobile']}>"
                                       data-province="<{$val['avo_province']}>"
                                       data-city="<{$val['avo_city']}>"
                                       data-address="<{$val['avo_address']}>"
                                       data-scenenum="<{$val['avo_scene_num']}>"
                                       data-scenetype="<{$val['avo_scene_type']}>"
                                       data-toggle="modal" data-target="#companyInfoModal">补全信息</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        <{if $pageHtml}>
                            <tr><td colspan="10"><{$pageHtml}></td></tr>
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
                    拍摄VR下单
                </h4>
            </div>
            <div class="modal-body">
                <div class="nowbuy-con" style="display: block">
                    <div class="zent-dialog-body clearfix">
                        <div class="pay-info" style="margin-bottom: 5px;">
                            <dl>
                                <dt style="font-size: 18px;text-align:left;">拍摄价格：</dt>
                                <dd><span class="money" id="produce-price">￥900</span></dd>
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
            <input type="hidden" id="vrtid" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="infoModalLabel">
                    补全下单信息
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">拍摄省份：</label>
                    <div class="col-sm-8">
                        <input id="province" class="form-control" placeholder="请填写拍摄省份" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">拍摄城市：</label>
                    <div class="col-sm-8">
                        <input id="city" class="form-control" placeholder="请填写拍摄城市" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">详细地址：</label>
                    <div class="col-sm-8">
                        <input id="address" class="form-control" placeholder="请填写拍摄的详细地址" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">联系人：</label>
                    <div class="col-sm-8">
                        <input id="contact" class="form-control" placeholder="请填写联系人" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">手机：</label>
                    <div class="col-sm-8">
                        <input id="mobile"  class="form-control" placeholder="请填写联系人手机号码" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">场景个数：</label>
                    <div class="col-sm-8">
                        <select id="sceneNum" style="width: 100%">
                            <option value="3">3个</option>
                            <option value="5">5个以内</option>
                            <option value="7">7个以内</option>
                            <option value="10">10个以内</option>
                            <option value="15">15个以内</option>
                            <option value="20">20个以内</option>
                            <option value="30">30个以内</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">场景类型：</label>
                    <div class="col-sm-8">
                        <select id="sceneType" style="width: 100%">
                            <option value="餐饮美食">餐饮美食</option>
                            <option value="休闲娱乐">休闲娱乐</option>
                            <option value="美容健身">美容健身</option>
                            <option value="酒店民宿">酒店民宿</option>
                            <option value="亲子教育">亲子教育</option>
                            <option value="场馆展示">场馆展示</option>
                            <option value="水电装修">水电装修</option>
                            <option value="户外景区">户外景区</option>
                            <option value="其他">其他</option>
                        </select>
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

     function buyVrOrderCertificate(){
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
        var url = '/wxapp/plugin/wxAlipayChargeQrcode?unique='+currSuid+'&channel='+type[index];
        console.log(url);
        var img = $('.online-pay-content:eq('+index+')').find('.image-code img');

        img.attr('src', url);
    }

    function hadPay(obj, event) {
        event.preventDefault();
        var new_url = "/wxapp/plugin/vrOrderList";
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
        $('#vrtid').val($(this).data('tid'));
        $('#province').val($(this).data('province'));
        $('#city').val($(this).data('city'));
        $('#address').val($(this).data('address'));
        $('#contact').val($(this).data('contact'));
        $('#mobile').val($(this).data('mobile'));
        $('#sceneNum').val($(this).data('scenenum'));
        $('#sceneType').val($(this).data('scenetype'));
    });

    $('#confirm-info-ssl').on('click',function(){
        var vrtid = $('#vrtid').val();
        var province = $('#province').val();
        var city = $('#city').val();
        var address = $('#address').val();
        var contact = $('#contact').val();
        var mobile = $('#mobile').val();
        var sceneNum = $('#sceneNum').val();
        var sceneType = $('#sceneType').val();
        var data = {
            vrtid      : vrtid,
            province   : province,
            city       : city,
            address    : address,
            contact    : contact,
            mobile     : mobile,
            scene_num   : sceneNum,
            scene_type  : sceneType
        }
        if(vrtid && contact && mobile){
            var loading = layer.load(2);
            $.ajax({
                'type': 'post',
                'url': '/wxapp/plugin/updateVrOrder',
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