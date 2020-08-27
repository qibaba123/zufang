/**
 * Created by zhaoweizhen on 16/9/6.
 */
function saveAutoReply(data){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/manage/wechat/saveMessage',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            layer.msg(ret.em);
        }
    });
}

function delAutoReply(){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/manage/wechat/delAutoReply',
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            layer.msg(ret.em, {icon: 1});
        }
    });
}