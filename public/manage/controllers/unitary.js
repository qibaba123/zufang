/**
 * Created by zhaoweizhen on 16/8/23.
 */

/**
 * 手动中止夺宝计划
 */
function stopPlay(id){
    var data = {
        pid : id
    };
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/unitary/stopPlan',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.msg(ret.em);
            if(ret.ec == 200){
                $('#td_'+id).html('');
                var status = '<span class="label label-sm label-danger">结束终止</span>';
                $('#status_'+id).html(status);
            }
        }
    })
}
/**
 * 手动终止定时红包
 */
function stopRed(id){
    var data = {
        pid : id
    };
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/unitary/stopRed',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.msg(ret.em);
            if(ret.ec == 200){
                $('#td_'+id).html('');
                var status = '<span class="label label-sm label-danger">结束终止</span>';
                $('#status_'+id).html(status);
            }
        }
    })
}

/**
 * 图片结果处理
 * @param allSrc
 */
function deal_select_img(allSrc){
    if(allSrc){
        if(maxNum == 1){
            $('#'+nowId).attr('src',allSrc[0]);
            if(nowId == 'upload-cover'){
                $('#ug_cover_img').val(allSrc[0]);
            }
        }else{
            var img_html = '';
            var cur_num = $('#'+nowId+'-num').val();
            for(var i=0 ; i< allSrc.length ; i++){
                var key = i + parseInt(cur_num);
                img_html += '<p>';
                img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                img_html += '<span class="delimg-btn">×</span>';
                img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'">';
                img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0">';
                img_html += '</p>';
            }
            var now_num = parseInt(cur_num)+allSrc.length;
            if(now_num <= maxNum){
                $('#'+nowId+'-num').val(now_num);
                $('#'+nowId).prepend(img_html);
            }else{
                layer.msg('幻灯图片最多'+maxNum+'张');
            }
        }
    }
}
/**
 * 保存夺宝计划信息
 * @param data
 */
function savePlay(data){
    if(data.total > 0 && data.g_id > 0 && data.k_id > 0 && data.money_limit>0){
        var loading = layer.load(1, {
            shade: [0.1,'#999'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/unitary/savePlan',
            'data'  : data,
            'dataType'  : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        })
    }else{
        layer.msg('请填完整数据！');
    }
}

function goodLuck(data){
    if(data.id){
        var loading = layer.load(1, {
            shade: [0.1,'#999'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/unitary/luck',
            'data'  : data,
            'dataType'  : 'json',
            success : function(ret){
                layer.close(loading);
                if(ret.ec == 200){
                    $('#luck_hid_id').val(data.id);
                    var html  = deal_luck_html(ret.data);
                        html += deal_express_html(ret.order,ret.address,ret.express);

                    $('#good-luck-table').html(html);
                    show_model('luck','中奖情况');
                }
            }
        })
    }
}
/**
 * 处理中奖情况
 * @param mem
 * @returns {string}
 */
function deal_luck_html(mem){
    var html = '<tr>';
    html += '<td class="success">揭晓时间</td>';
    html += '<td >'+mem.time+'</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td class="success">本期彩票</td>';
    html += '<td >'+mem.lottery+'</td>';
    html += '</tr>';
    html += '<tr>';
    html += '<td class="success">中奖会员</td>';
    if(mem.mid > 0){
        html += '<td >'+mem.nickname+'</td>';
    }else if(mem.mid == -1){
        html += '<td >内部员工</td>';
    }else{
        html += '<td ></td>';
    }
    html += '</tr>';
    html += '<tr>';
    html += '<td class="success">会员手机号</td>';
    if(mem.mobile){
        html += '<td >'+mem.mobile+'</td>';
    }else{
        html += '<td ></td>';
    }
    html += '</tr>';
    html += '<tr>';

    return html ;
}

function deal_express_html(order,address,express){
    var html = '';
    if(order.uo_express_time > 0){ //已经发货
        if(order.uo_need_express == 1){
            html += '<tr>';
            html += '<td class="success">物流</td>';
            html += '<td >'+order.uo_express_company+'</td>';
            html += '</tr>';
            html += '<tr>';
            html += '<td class="success">单号</td>';
            html += '<td >'+order.uo_express_code+'</td>';
            html += '</tr>';
        }else{
            html += '<tr>';
            html += '<td class="success">物流</td>';
            html += '<td >无需物流</td>';
            html += '</tr>';
        }
        html += '<tr>';
        html += '<td class="success">发货时间</td>';
        html += '<td >'+order.sendTime+'</td>';
        html += '</tr>';
    }else{ //未发货
        html += '<tr>';
        html += '<td class="success">物流</td>';
        html += '<td ><div class="radio-box">';
        html += '<span data-val="0" ><input type="radio" name="need" value="0" id="need0" onclick="selectNeedExpress(1)"><label for="need0">无需物流</label></span>';
        html += '<span data-val="1" ><input type="radio" name="need" value="1" id="need1" onclick="selectNeedExpress(0)" checked><label for="need1">需要物流</label></span>';
        html += '</div></td>';
        html += '</tr>';

        html += '<tr class="needExpress">';
        html += '<td class="success">物流公司</td>';
        html += '<td ><select id="express-sel" class="form-control">';
        for(var i = 0 ; i < express.length ; i ++){
            html += '<option value="'+express[i].e_code+'">'+express[i].e_name+'</option>';
        }
        html += '</select></td>';
        html += '</tr>';

        html += '<tr class="needExpress">';
        html += '<td class="success">物流单号</td>';
        html += '<td ><input type="text" id="code" class="form-control"></td>';
        html += '</tr>';

        html += '<tr class="needExpress">';
        html += '<td class="success">收货地址</td>';
        html += '<td ><select id="address-sel" class="form-control">';
        for(var j = 0 ; j < address.length ; j ++){
            html += '<option value="'+address[j].ma_id+'">'+address[j].ma_name+address[j].ma_phone+'('+address[j].ma_city+address[j].ma_zone+address[j].ma_detail+')'+'</option>';
        }
        html += '</select></td>';
        html += '</tr>';

        html += '<tr>';
        html += '<td class="success">&nbsp;</td>';
        html += '<td ><a href="javascript:;" class="btn-success express-btn btn" onclick="saveSendExpress()">发货</a></td>';
        html += '</tr>';

    }
    return html ;
}

function selectNeedExpress(need){
    if(need == 1){
        $('.needExpress').hide();
    }else{
        $('.needExpress').show();
    }
}

function saveSendExpress(){
    var data = {
        'need'              : $('input[name="need"]:checked').val(),
        'company_code'      : $('#express-sel').val(),
        'express_company'   :  $("#express-sel").find("option:selected").text(),
        'addr_id'           : $('#address-sel').val(),
        'code'              : $('#code').val(),
        'pid'               : $('#luck_hid_id').val()
    };
    if(data.need == 1 && !data.code){
        layer.msg('请填写物流单号');
        return false;
    }
    console.log(data);
    var loading = layer.load(1, {
        shade: [0.1,'#999'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/unitary/sendExpress',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.close(loading);
            layer.msg(ret.em);
            if(ret.ec == 200){
                $('#showModel').modal('hide');
            }
        }
    })
}

function show_model(type,title){
    $('#myModalLabel').text(title);
    switch (type){
        case 'luck' :
            $('.modal-plan').hide();
            $('.modal-luck').show();
            break;
        case 'plan':
            $('.modal-plan').show();
            $('.modal-luck').hide();
            break;
    }
    $('#showModel').modal('show');
}
/**
 * 保存消息通知到配置
 * @param data
 */
function saveCfg(data){
    if(data.key){
        var loading = layer.load(1, {
            shade: [0.1,'#999'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/unitary/saveNotice',
            'data'  : data,
            'dataType'  : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#myModal').modal('hide');
                    window.location.reload();
                }
            }
        })
    }
}
/**
 * 保存数据
 * @param data
 */
function saveSetting(data){
    var loading = layer.load(1, {
        shade: [0.1,'#999'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/unitary/saveSetting',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.close(loading);
            layer.msg(ret.em);
        }
    })
}

function saveRedPack(data){
    var loading = layer.load(1, {
        shade: [0.1,'#999'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'      : 'post',
        'url'       : '/manage/unitary/saveRedPack',
        'data'      : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            if(ret.ec == 200){
                window.location.href='/manage/unitary/redPack';
            }else{
                layer.msg(ret.em);
            }
        }
    });
}