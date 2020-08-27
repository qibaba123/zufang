/**
 * Created by zhaoweizhen on 16/8/20.
 */
function saveDomainAction(data){
    layer.confirm('修改域名会重新进入审核，您确定修改吗？', {
        btn: ['修改','取消'] //按钮
    }, function(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'   : 'post',
            'url'   : '/manage/manager/saveDomain',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('.status-note').html('<span class="orange">待审核</span>');
                    $('#change-btn').hide();
                }
            }
        });
    }, function(){

    });

}
/**
 * 保存管理员信息
 * @param data
 */
function saveManager(data){
    if (!/^1\d{10}/.test(data.mobile)) {
        layer.msg('手机号格式不正确');
        return;
    }
    if(data.nickname == ''){
        layer.msg('请填写昵称');
        return;
    }
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        type: 'post',
        url: "/manage/manager/savePersonal" ,
        data: data,
        dataType: 'json',
        success: function(json_ret){
            layer.close(index);
            layer.msg(json_ret.em);
        }
    });
}

function confirmPassword(){
    var new_pass     = $('#new-pass').val();
    var confirm_pass = $('#confirm-pass').val();
    if(new_pass != confirm_pass){
        layer.msg('两次填写密码不一样');
        return false;
    }
}
/**
 * 管理员修改密码
 * @param data
 * @returns {boolean}
 */
function changePassword(data){
    if (data.old_pass.length < 6 || data.old_pass.length > 50) {
        layer.msg('原密码格式不正确');
        return;
    }
    if (data.new_pass.length < 6 || data.new_pass.length > 50) {
        layer.msg('新密码格式不正确');
        return;
    }
    if (data.old_pass == data.new_pass) {
        layer.msg('和原密码一致，请重新输入新密码');
        return;
    }
    if(data.new_pass != data.confirm_pass){
        layer.msg('两次输入密码不一样');
        return false;
    }
    //提交数据库保存
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        type: 'post',
        url: "/manage/manager/changePassword" ,
        data: data,
        dataType: 'json',
        success: function(json_ret){
            layer.close(index);
            layer.msg(json_ret.em);
        }
    });
}