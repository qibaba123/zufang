/**
 * Created by zhaoweizhen on 16/8/23.
 */
/*保存等级到期时间*/
function saveDate(elem){
    var data = {
        'id'   : $(".ui-popover #hid_dateid").val(),
        'date' : $(".ui-popover #endDate").val()
    };

    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/distrib/member/changeLong',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200){
                $("#content-con").find('table td a.long_date[data-id='+data.id+']').text(data.date);
                optshide();
            }
        }
    });

}

/*隐藏设置会员弹出框*/
function optshide(){
    $('.ui-popover').stop().hide();
}


function sendCfg(data){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/distrib/three/saveCenter',
        'data'  : data,
        'dataType' : 'json',
        'success'  : function(ret){
            layer.close(index);
            layer.msg(ret.em);
        }
    });
}




