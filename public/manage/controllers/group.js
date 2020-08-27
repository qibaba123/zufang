/**
 * Created by zhaoweizhen on 16/11/26.
 */
/**
 * 保存中奖信息推送
 * @param data
 */
function saveLuckMsg(data){
    var loading = layer.load(1, {
        shade: [0.6,'#fff'], //0.1透明度的白色背景
        time: 4000
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/group/luckMsg',
        'data'  : data,
        'dataType' : 'json',
        success : function(ret){
            layer.close(loading);
            layer.msg(ret.em);
        }
    });
}
/**
 * 团购参与情况
 * @param data
 */
function getPartyMember(data){
    var loading = layer.load(1, {
        shade: [0.6,'#fff'], //0.1透明度的白色背景
        time: 4000
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/group/partyMember',
        'data'  : data,
        'dataType' : 'json',
        success : function(ret){
            layer.close(loading);
            if(ret.ec == 200){
                if(ret.count > 0) $('.luck').hide(); //已经开过奖
                deal_party_member_data(ret.data,ret.count,data.type);
            }else{
                layer.msg(ret.em);
            }

        }
    });

}
/**
 * 参团会员信息列表
 * @param data
 * @param type
 */
function deal_party_member_data(data,has,type){
    var html = '';
    for(var i = 0 ; i < data.length ; i++){
        var temp = data[i];var luck = '';
        if(temp.gm_is_winner == 1){
            luck = '<span class="tuan-tag">奖</span>';
        }
        html += '<li>';
        if(type == 'luck' && has == 0) html += '<div><input type="checkbox" class="cus-check" name="gmids" value="'+temp.gm_id+'" id="tuanuser'+temp.gm_id+'"><label for="tuanuser'+temp.gm_id+'"></label></div>';
        html += '<div><div class="user-tx"><img src="'+temp.m_avatar+'" alt="用户头像" width="100"></div></div>';
        html += '<div><p class="user-name">'+luck+temp.m_nickname+'</p></div>';
        html += '</li>';
    }
    $('#memUl').html(html);
    $('#myModalTuanuser').modal('show');
}

function saveMember(data){
    var loading = layer.load(1, {
        shade: [0.6,'#fff'], //0.1透明度的白色背景
        time: 4000
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/manage/group/saveGoodsLuck',
        'data'  : data,
        'dataType' : 'json',
        success : function(ret){
            layer.close(loading);
            layer.msg(ret.em);

            if(ret.ec == 200){
                $('#myModalTuanuser').modal('hide');
            }

        }
    });
}




