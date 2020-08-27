/**
 * Created by zhaoweizhen on 16/6/25.
 */

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
            ids += $(this).val()+"|"
        }
    });
    return ids;
}


$('.btn-del-all').on('click',function(){
    var table  = $(this).data('table');

    var del_id ='';
    $("input[name='ids']:checked").each(function(){
        del_id += $(this).val() + '|';
    });
    if(table && del_id){
        var url  = '/manage/delete/batch';
        var data = {
            'ids'   : del_id,
            'key'   : table
        };
        $.ajax({
            'type'  : 'post',
            'url'   : url,
            'data'  : data,
            'dataType' : 'json',
            'success'  : function(ret){
                if(ret.ec == 200){
                    $("input[name='ids']:checked").each(function(){
                        var id = $(this).val();
                        $('#tr_'+ id).hide();
                    });
                }else{
                    layer.msg(ret.em);
                }
            }
        });

    }
});

$('.btn-del-single').on('click',function(){
    var table  = $(this).data('table');
    var del_id = $(this).data('id');
    if(table && del_id){
        var url  = '/manage/delete/single';
        var data = {
            'id'    : del_id,
            'key'   : table
        };
        delCommon(data,url);
    }
});
/**
 * 通用删除功能
 * @param data
 * @param url
 */
function delCommon(data,url){
    $.ajax({
        'type'  : 'post',
        'url'   : url,
        'data'  : data,
        'dataType' : 'json',
        'success'  : function(ret){
            layer.msg(ret.em);
            if(ret.ec == 200){
                $('#tr_'+ data.id).remove();
            }
        }
    });
}

