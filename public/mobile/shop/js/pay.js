function createPay(obj, event) {
    if (event) {
        event.preventDefault();
    }
    layer.open({
        type : 1,
        content : $('#layer-box').html(),
        anim : 'up',
        style: 'position:fixed; bottom:0; left:0; width:100%; padding:0; border:none;'
    });
}
/*选择支付方式*/
function checkedToggle(elem){
    if ($(elem).hasClass('disabled')) {
        return;
    }
    pay_type    = $(elem).data('type');
    $(elem).parents(".pay-choose").find("p.check").removeClass('checked');
    $(elem).addClass('checked');
}
/*关闭弹出层*/
function closeShade(){
    layer.closeAll();
}

/*提交支付*/
function confirmPay(obj) {
    if (pay_type == "weixin") {
        if (!isWeixinBrowser()) {
            window.location.replace("/mobile/trade/native/suid/"+suid+"/tid/"+tid);
            return;
        }
        //使用微信支付
        var loading1 = layer.open({type : 2});
        //调起微信支付
        $.ajax({
            url : '/mobile/trade/pay',
            data : {tid : tid, suid : suid, ajax : 1},
            dataType : 'json',
            method : "POST",
            cache : false,
            timeout : 20000//毫秒单位
        }).done(function(ret) {
            if (ret.ec == 200) {
                callpay(ret.data.params);
            } else {
                layer.open({
                    content : ret.em,
                    btn : ['确定']
                });
            }
        }).always(function() {
            layer.close(loading1);
        });
    } else if (pay_type == "alipay") {
        //使用支付宝支付
        layer.open({type : 2});
        window.location.replace('/mobile/trade/alipay/suid/'+suid+'/tid/'+tid);
    } else if (pay_type == "cash") {
        //使用货到付款
        var loading2 = layer.open({type : 2});
        $.ajax({
            url : '/mobile/trade/cash',
            data : {tid : tid, suid : suid, ajax : 1},
            dataType : 'json',
            method : "POST",
            cache : false,
            timeout : 20000//毫秒单位
        }).done(function(ret) {
            if (ret.ec == 200) {
                invokePay();
            } else {
                layer.open({
                    content : ret.em,
                    btn : ['确定']
                });
            }
        }).always(function() {
            layer.close(loading2);
        });
    } else if (pay_type == "coin") {
        //使用余额支付
        var loading3 = layer.open({type : 2});
        //调起微信支付
        $.ajax({
            url : '/mobile/trade/coin',
            data : {tid : tid, suid : suid, ajax : 1},
            dataType : 'json',
            method : "POST",
            cache : false,
            timeout : 20000//毫秒单位
        }).done(function(ret) {
            if (ret.ec == 200) {
                invokePay();
            } else {
                layer.open({
                    content : ret.em,
                    btn : ['确定']
                });
            }
        }).always(function() {
            layer.close(loading3);
        });
    } else if (pay_type == 'point') {
        //使用积分支付
        var loading4 = layer.open({type : 2});
        //调起微信支付
        $.ajax({
            url : '/mobile/point/charge',
            data : {tid : tid, suid : suid, ajax : 1},
            dataType : 'json',
            method : "POST",
            cache : false,
            timeout : 20000//毫秒单位
        }).done(function(ret) {
            if (ret.ec == 200) {
                invokePay();
            } else {
                layer.open({
                    content : ret.em,
                    btn : ['确定']
                });
            }
        }).always(function() {
            layer.close(loading4);
        });
    }
}
function callpay($params) {
    if (typeof WeixinJSBridge == "undefined"){
        if( document.addEventListener ){
            document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
        }else if (document.attachEvent){
            document.attachEvent('WeixinJSBridgeReady', jsApiCall);
            document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
        }
    }else{
        jsApiCall($params);
    }
}
//调用微信JS api 支付
function jsApiCall($params) {
    WeixinJSBridge.invoke(
        'getBrandWCPayRequest',
        $params,
        function(res){
            if (res.err_msg == "get_brand_wcpay_request:ok") {
                invokePay();
            } else if (res.err_msg == "get_brand_wcpay_request:fail") {
                window.location.replace("/mobile/trade/native/suid/"+suid+"/tid/"+tid);
            } else {

            }
        }
    );
}
/*支付成功后调用*/
function invokePay() {
    var loading = layer.open({type : 2});
    var ptdata = {
        'suid'  : suid,
        'tid'   : tid
    };
    $.ajax({
        url : '/mobile/trade/payBack',
        data : ptdata,
        dataType : 'json',
        method : "POST",
        cache : false,
        timeout : 20000//毫秒单位
    }).done(function(ret) {
        if (ret.ec == 200) {
            window.location.replace("/mobile/trade/payResult/suid/"+suid+"/tid/"+tid);
        } else {
            layer.open({
                content : ret.em,
                btn : ['确定']
            });
        }
    }).always(function() {
        layer.close(loading);
    });
}

function isWeixinBrowser(){
    var ua = navigator.userAgent.toLowerCase();
    return (/micromessenger/.test(ua)) ? true : false ;
}