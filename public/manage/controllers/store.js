/**
 * Created by zhaoweizhen on 16/8/23.
 */

function fetchPageData(page){
    var data  = {
        'store'  : $('#store').val(),
        'mobile' : $('#mobile').val(),
        'name'   : $('#name').val(),
        'mid'    : $('#mid').val(),
        'page'   : page
    };
    //var index = layer.load(10, {
    //    shade: [0.6,'#666']
    //});
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/store/ajaxStoreVerify',
        'data'  : data,
        'dataType' : 'json',
        'success'   : function(ret){
            //layer.close(index);
            showVerifyHtml(ret.list);
            $('#tr_page').html(ret.pageHtml);
        }
    });
}

function showVerifyHtml(data){
    var _html = '';
    for(var i=0; i < data.length ; i++){
        var temp = unix_to_datetime(data[i].ov_record_time);
        _html += '<tr>';
        _html += '<td>'+data[i].m_nickname+'</td>';
        _html += '<td>'+data[i].m_mobile+'</td>';
        _html += '<td>'+data[i].os_name+'</td>';
        _html += '<td>'+temp+'</td>';
        _html += '</tr>';
    }
    $('#tbody-con').html(_html);
}
function getLocalTime(nS) {
    return new Date(parseInt(nS) * 1000).toLocaleString().substr(0,17)
}
function unix_to_datetime(unix) {
    var now = new Date(parseInt(unix) * 1000);
    return now.toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
}

function verify(data){
    var index = layer.load(10, {
        shade: [0.6,'#666']
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/store/saveVerify',
        'data'  : data,
        'dataType' : 'json',
        'success'   : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200){
                window.location.reload();
            }

        }
    });
}
/**
 * 开启店铺配置
 * @param data
 */
function openStore(data){
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/store/openStore',
        'data'  : data,
        'dataType' : 'json',
        'success'   : function(ret){
            layer.msg(ret.em);
        }
    });
}

function delStore(id){
    if(id){
        var data = {
            'id'  : id
        };

        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/manage/store/delStore',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    $('#tr_'+id).remove();
                }
            }
        });

    }else{
        layer.msg('未获取到商品信息');
    }
}

function saveStore(){
    var is_head  = $('#is_head:checked').val();
    var data = {};
    var check = new Array('name','province','city','zone','addr','contact','lng','lat','open_time','close_time','feature','recommend');
    for(var i=0 ; i < check.length; i++){
        var temp = $('#'+check[i]).val();
        if(temp){
            data[check[i]] = temp;
        }else{
            var msg = $('#'+check[i]).attr('placeholder');
            layer.msg(msg);
            return false;
        }
    }
    data.is_head = is_head == 'on' ? 1 : 0 ;
    data.id      = $('#hid_id').val();
    data = getWeek(data);
    var index    = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'   : 'post',
        'url'   : '/manage/store/saveStore',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            layer.close(index);
            if(ret.ec == 200){
                window.location.href='/manage/store/index';
            }else{
                layer.msg(ret.em);
            }
        }
    });
}

/**
 * 获取星期的选择值，追加到data对象里
 * @param data
 * @returns {*}
 */
function getWeek(data){
    $(".week-choose span").each(function(ele){
        var act = $(this).attr('class');
        var key = $(this).data('week');

        if(act == 'active'){
            data['week_'+key] = 1;
        }else{
            data['week_'+key] = 0;
        }
    });
    return data;
}

function initRegionByName(data){
    if(data){
        $.ajax({
            'type'   : 'post',
            'url'   : '/manage/index/dealRegionByName',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                $('#province').val(ret.pid);
                region_html(ret.city,'city',ret.cid);
                region_html(ret.zone,'zone',ret.zid);
            }
        });
    }
}
/**
 * 获取到会员信息
 * @param data
 */
function get_member_card(data){
    $.ajax({
        'type'   : 'post',
        'url'   : '/manage/store/memberInfo',
        'data'  : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            if(ret.ec == 200){
                layer.msg('请检查会员信息，正确后进行核销');
                deal_mem_card(ret.data);
            }else{
                layer.msg('未获取到会员信息');
            }
        }
    });
}
/**
 * 展示会员信息
 * @param data
 */
function deal_mem_card(data){
    var _html  = '<table class="table table-condensed">';

        _html += '<tr>';
        _html += '<td class="success">会员昵称</td>';
        _html += '<td>'+data.nickname+'</td>';
        _html += '</tr>';

        _html += '<tr>';
        _html += '<td class="success">身份标示</td>';
        _html += '<td>'+data.curr+'</td>';
        _html += '</tr>';

        _html += '<tr>';
        _html += '<td class="success">会员卡号</td>';
        _html += '<td>'+data.card+'</td>';
        _html += '</tr>';

        _html += '<tr>';
        _html += '<td class="success">到期时间</td>';
        _html += '<td>'+data.deadline+'</td>';
        _html += '</tr>';

        _html += '<tr>';
        _html += '<td class="success">剩余次数</td>';
        _html += '<td>'+data.left+'</td>';
        _html += '</tr>';
        _html += '</table>';
        _html += '<input type="hidden" id="canVerify" value="1">';
    $('#member-info').html(_html);

}