/**
 * Created by zhaoweizhen on 16/9/8.
 */
/**
 * 控制物流的显示与隐藏
 */
$("input[name='no_express']").click(function(event) {
    var isChecked = $(this).is(':checked');
    var value = $(this).data('id');
    if(isChecked && value=='0'){
        $("#wuliu-info").stop().hide();
    }else{
        $("#wuliu-info").stop().show();
    }
});
/**
 * 展示分销数据
 * @param data
 */
function showDeduct(data){
    var index = layer.load(10, {
        shade: [0.6,'#666']
    });
    $.ajax({
        'type'	: 'post',
        'url'   : '/distrib/order/deduct',
        'data'  : data,
        'dataType' : 'json',
        'success'  : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                $('.modal-footer').hide();
                deal_order_deduct(ret.list,ret.goods,ret.member);
                $('#modelTitle').text('分销佣金详情');
                hideFormShowById('deduct');
                $('#refund-form').modal('show');
            }else{
                layer.msg(ret.em);
            }
        }
    });
}
function hideFormShowById(id){
    $('.hid-row').hide();
    $('#show-'+id).show();
    switch (id){
        case 'deduct':
            $('.modal-footer').hide();
            break;
        default :
            $('.modal-footer').show();
            break;
    }
}
/**
 * 保存退款和发货信息
 */
function saveModal(){
    var type 	= $('#modal-type').val();
    switch(type){
        case 'refund':
            refundTrade();
            break;
        case 'express':
            expressTrade();
            break;
    }

}
/**
 * 退款逻辑处理
 */
function refundTrade(){
    var tid 	= $('#hid_id').val();
    var status  = $('input[name="status"]:checked').val();
    var note    = $('#note').val();

    if(tid){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'	: tid,
            'status': status,
            'note'	: note
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/distrib/order/refundTrade',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    window.location.reload();
                }else{
                    layer.msg(ret.em);
                }
            }
        });
    }
}


/**
 * 发货逻辑处理
 */
function expressTrade(){
    var tid = $('#hid_id').val();
    var need 	 	= $('input[name="no_express"]:checked').val();
    var company 	= $('#express_id option:selected').text();
    var express 	= $('#express_id option:selected').val();
    var code 		= $('#express_code').val();
    if(need == 1 && !(express && code)){
        layer.msg("请选择物流并填写物流单好");
        return false;
    }
    if(tid){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'tid'       : tid,
            'need'   	: need,
            'company'   : company,
            'express'   : express,
            'code' 		: code
        };
        var cate = $('#cate').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/distrib/order/expressTrade',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    if(cate == 'detail'){
                        window.location.reload();
                    }else{
                        $('#express_'+tid).hide();
                        $('#status_'+tid).text('已发货');
                        $('#refund-form').modal('hide');
                    }
                }
            }
        });
    }
}
/**
 * 单品分佣数据展示
 * @param deduct
 * @param goods
 * @param member
 */
function deal_order_deduct(deduct,goods,member){
    var _html = '';
    for(var i=0	; i<deduct.length ; i++){
        var temp = deduct[i],status='';
        if(temp.od_status == 1){
            status = '已返现';
        }else if(temp.od_status == 2){
            status = '退款收回返现';
        }else{
            status = '未返现';
        }
        _html += '<tr>';
        _html += show_data(goods[temp.od_g_id]);
        _html += show_data(temp.od_amount);
        _html += show_data(member[temp.od_0f_id]);
        _html += show_data(temp.od_0f_deduct);
        _html += show_data(member[temp.od_1f_id]);
        _html += show_data(temp.od_1f_deduct);
        _html += show_data(member[temp.od_2f_id]);
        _html += show_data(temp.od_2f_deduct);
        _html += show_data(member[temp.od_3f_id]);
        _html += show_data(temp.od_3f_deduct);
        _html += '<td>'+status+'</td>';
        _html += '</tr>';
    }
    $('#deduct-tr').html(_html);
}
/**
 * 展示日期
 * @param key
 * @returns {string}
 */
function show_data(key){
    var html = '<td>-</td>';
    if(key && key != 0.00){
        html = '<td>'+key+'</td>';
    }
    return html;
}
/**
 * 打印模版预览
 */
$('.previewCon').on('click',function(){
    var type = $(this).data('type');
    if(type){
        var tid  = $(this).data('tid');
        if(!tid){
            savePrint(type,1);
        }

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type' : type,
            'tid'  : tid
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/distrib/print/ajaxShow',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    layer.open({
                        type: 1,
                        title: '内容预览',
                        hadeClose: true,
                        scrollbar: false,
                        maxmin: true, //开启最大化最小化按钮
                        area: ['800px', '500px'],
                        content: ret.data
                    });
                }else{
                    layer.msg(ret.em);
                }

            }
        });

    }else{
        layer.msg('位置模版类型');
    }
});
/**
 * 保存打印模版
 */
$('.savePrintTpl').on('click',function(){
    var type = $(this).data('type');
    savePrint(type);
});
/**
 * 保存模版信息
 */
function savePrint(type,hid){
    var content = $('#content_'+type).val();
    if(content){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'    : type,
            'content' : content
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/distrib/print/saveTemplate',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(!hid){
                    layer.msg(ret.em);
                }
            }
        });
    }else{
        layer.msg('模版内容不能为空');
    }
}

