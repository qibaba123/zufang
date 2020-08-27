function change_get_shop_type(){
    var area    = $('#form-field-select-area').val();
    var floor   = $('#form-field-select-floor').val();
    if(area && floor){
        //$('#form-field-select-area').css('border-color','');
        //$('#form-field-select-area').css('color','');
        //alert('输入正确');
    }else{
        //$('#form-field-select-area').css('border-color','red');
        //$('#form-field-select-area').css('color','red');
    }
}

function clear_msg_by_id(id,display){
    $('#'+id).html('');
    if(display){
        $('#'+id).css('display','none');
    }
}

function add_font_color(msg,res){
    var _html = ''
    if(res == 1 || res == 200){
        _html = '<font style="color: green;">'+msg+'</font>';
    }else{
        _html = '<font style="color: red;">'+msg+'</font>';
    }
    return _html;
}

function check_mobile(mobile){
    var rule = /1\d{10}/;
    return rule.test(mobile);
}

function check_email(str){
    var re = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
    return re.test(str);
}

function show_dialog_add(className){
    $('.theme-'+className+'-mask').fadeIn(100);
    $('.theme-'+className).slideDown(200);
}
function show_dialog_close(className){
    $('.theme-'+className+'-mask').fadeOut(100);
    $('.theme-'+className).slideUp(200);
}

function select_all_by_name(name,id){
    var ele = $('#'+id);
    if(ele.is(':checked')){//全选
        $("input[name='"+name+"']").prop('checked', true);
    }else{//取消全选
        $("input[name='"+name+"']").prop('checked', false);
    }
}

function get_select_all_ids_by_name(name){
    var ids="";
    $("input[name='"+name+"']:checkbox").each(function(){
        if($(this).is(':checked')){
            ids += $(this).val()+","
        }
    });
    return ids;
}

function get_select_all_ids_array_by_name(name){
    var ids=[];
    $("input[name='"+name+"']:checkbox").each(function(){
        if($(this).is(':checked')){
            ids.push($(this).val());
        }
    });
    return ids;
}

function check_empty(id){
    var value = $('#'+id).val();
    if(value==''){
        return false;
    }
}

function show_display_by_id(id,hid_id){
    $('#'+id).css('display','block');
    if(hid_id){
        $('#'+hid_id).css('display','none');
    }
}

function hid_display_by_id(id,show_id){
    $('#'+id).css('display','none');
    if(show_id){
        $('#'+show_id).css('display','block');
    }
}

function fade_in_out_msg(id,msg,res){
    $('#'+id).fadeIn();
    $('#'+id).html(add_font_color(msg,res));
    $('#'+id).fadeOut(3000);
}


function show_display_error_msg(msg,msg_id){
    $('#'+msg_id).css('display','block');
    $('#'+msg_id).html(add_font_color(msg,0));
}


function edit_by_class_name(className){
    $('.'+className+'-edit').css('display','block');
    $('.'+className).css('display','none');
}
function hide_edit_by_class_name(className){
    $('.'+className+'-edit').css('display','none');
    $('.'+className).css('display','block');
}

/**
 * 根据form表格的元素，取名相应的check_field_number
 * 显示错误信息 取名相应的field_msg_number
 * @param number
 * @returns {boolean}
 */
function check_edit_form_for_number(number){
    if(number>=1){
        for(var i=1;i<=number;i++){
            var val = $('#check_field_'+i).val();
            if(val == ''){
                $('#field_msg_'+i).html('此项不能为空');
                return false;
            }
        }
    }
}
/**
 * 登陆密码规则
 * @param pwd
 * @returns {boolean}
 */

function check_login_password(pwd){
    if(pwd.length>=6 && pwd.length<=16){
        return true;
    }else{
        return false;
    }
}

var wait=60;//时间
//o为按钮的对象，p为可选，这里是60秒过后，提示文字的改变
function time(o) {
    if (wait == 0) {
        o.removeAttr("disabled");
        o.html("点击发送验证码");//改变按钮中value的值
        wait = 60;
    } else {
        o.attr("disabled", true);//倒计时过程中禁止点击按钮
        o.html(wait + "秒后重新获取验证码");//改变按钮中value的值
        wait--;
        setTimeout(function() {
            time(o);//循环调用
        }, 1000)
    }
}

function get_radio_by_name(name)
{
    var radio = document.getElementsByName(name);
    // 用ById就不能取得全部的radio值,而是每次返回都为1
    var radioLength = radio.length;
    for(var i = 0;i < radioLength;i++)
    {
        if(radio[i].checked)
        {
            var radioValue = radio[i].value;
            return radioValue;
        }
    }
    return false;
}



function change_icon(id){
    var cla = $('#icon-'+id).attr('class');
    var new_cla ;
    var new_dis;
    if(cla == 'icon-double-angle-up'){
        new_cla ='icon-double-angle-down';
        $(".tr-show-"+id).hide(500);
    }else{
        new_cla ='icon-double-angle-up';
        $(".tr-show-"+id).show(500);
    }
    $("#icon-list-"+id).html('<i id="icon-'+id+'" class="'+new_cla+'"></i>');

}

function change_icon_fa(id){
    var cla = $('#icon-'+id).attr('class');
    var new_cla ;
    if(cla == 'fa fa-angle-double-up'){
        new_cla ='fa fa-angle-double-down';
        $(".tr-show-"+id).hide(500);
    }else{
        new_cla ='fa fa-angle-double-up';
        $(".tr-show-"+id).show(500);
    }
    $("#icon-list-"+id).html('<i id="icon-'+id+'" class="'+new_cla+'"></i>');

}

function getRadio(name){
    var rad_val = $("input[name='"+name+"'][checked]").val();
    return rad_val;
}

function plumAjax(url,data,reload){
    var index = layer.load(10, {
        shade: [0.6,'#666']
    });
    console.log(url);
    $.ajax({
        'type'  : 'post',
        'url'   : url,
        'data'  : data,
        'dataType' : 'json',
        'success'   : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200 && reload){
                window.location.reload();
            }
        }
    });
}
/**
 * 通用删除方法
 * @param data
 */
function commonDeleteById(data){
    if(data.id > 0 && data.type){
        layer.confirm('删除后会有其他影响，您是确定要删除吗？', {
            btn: ['删除','暂不删除'] //按钮
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/manage/index/commonDeleteById',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        });
    }else{
        layer.msg('参数错误');
    }
}
/**
 * 小程序通用删除
 */
function commonDeleteByIdWxapp(data){
    if(data.id > 0 && data.type){
        layer.confirm('删除后会有其他影响，您是确定要删除吗？', {
            btn: ['删除','暂不删除'] //按钮
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/index/commonDeleteById',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        });
    }else{
        layer.msg('参数错误');
    }
}

/**
 * 小程序店铺通用删除
 */
function commonDeleteByIdShop(data){
    if(data.id > 0 && data.type){
        layer.confirm('删除后会有其他影响，您是确定要删除吗？', {
            btn: ['删除','暂不删除'] //按钮
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/shop/index/commonDeleteById',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        });
    }else{
        layer.msg('参数错误');
    }
}

/**
 * 小程序微分销通用删除
 */
function commonDeleteByIdDistrib(data){
    if(data.id > 0 && data.type){
        layer.confirm('删除后会有其他影响，您是确定要删除吗？', {
            btn: ['删除','暂不删除'] //按钮
        }, function(){
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/distrib/index/commonDeleteById',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200 ){
                        $('#tr_'+data.id).hide();
                    }
                }
            });
        });
    }else{
        layer.msg('参数错误');
    }
}
