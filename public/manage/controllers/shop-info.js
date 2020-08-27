function saveShopInfo(){
   // var sms         = $('#sms_start').is(':checked');
    var signature   = $("#signature").find("option:selected").text();
    var data = {
        'name'        : $('#shop_name').val(),
        'contact'     : $('#shop_contact').val(),
        'phone'       : $('#shop_phone').val(),
        'follow_link' : $('#shop_follow').val(),
        'url'         : $('#shop_url').val(),
       // 's_sms_verify'  : sms ? 1 : 0,
        's_sms_sign'    : signature
    };
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/shop/saveShopInfo',
        'data'  : data,
        'dataType' : 'json',
        success : function(response){
            fade_in_out_msg('saveResult',response.em,response.ec);
        }
    });
}

function indexTplStart(data){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/shop/startTpl',
        'data'  : data,
        'dataType' : 'json',
        success : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200){
                window.location.reload();
            }
        }
    });
}

function saveKefu(data){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/shop/saveKefu',
        'data'  : data,
        'dataType' : 'json',
        success : function(ret){
            layer.close(index);
            layer.msg(ret.em);
        }
    });
}
