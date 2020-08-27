/**
 * Created by zhaoweizhen on 16/8/6.
 */

function plumAuthCode(keyword){
    var token = 'tiandiankeji';
    var str   = keyword+token;
    return $.md5(str);
}
/**
 * 初始化排行榜
 * @param page
 * @param gid
 * @param url
 */
function rankList(page,gid,url){
    var data = {
        'page' : page,
        'gid'  : gid
    };
    $.ajax({
        'type'      : 'post',
        'url'       : url,
        'data'      : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            if(ret.ec == 200){
                var _html = '';
                for(var i= 0; i<ret.data.length ; i++){
                    var temp = ret.data[i];
                    var k = parseInt(i+1);
                    _html += '<tr>';
                    if(i < 3){
                        _html += '<td><img src="/public/plugin/game/qixi/static/applegame/'+(k)+'@2x.png" ></td>';
                    }else{
                        _html += '<td>'+k+'</td>';
                    }
                    _html += '<td><img src="'+temp['gr_avatar']+'" ></td>';
                    _html += '<td >'+temp['gr_nickname']+'</td>';
                    _html += '<td >'+temp['gr_score']+'</td>';
                    _html += '</tr>';
                }
                $('#rank-list').html(_html);
            }else{
                layer.msg(ret.em);
            }
        }
    });
}
/**
 * 保存信息
*/
function saveImg(ele){
    var url = $(ele).data('url');
    var gid = $(ele).data('gid');
    var signal = $('input[name="radio"]:checked').val();
    var weixin = $('#wx_contact').val();
    var sign   = $('#wx_love').val();
    var photo  = $('#us_img').val();
    if(!weixin){
        layer.msg('请填写微信号，遇美丽邂逅');
        return false;
    }
    if(!sign){
        layer.msg('请为爱宣言，彰显爱的誓言');
        return false;
    }
    if(!photo){
        layer.msg('请上传照片');
        return false;
    }
    var data = {
        'signal' : signal,
        'weixin' : weixin,
        'sign'   : sign,
        'photo'  : photo,
        'gid'    : gid
    };
    $.ajax({
        'type'      : 'post',
        'url'       : url,
        'data'      : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            if(ret.ec == 200){
                layer.msg('上传成功');
                $(".input-shade").stop().hide();
                var l = document.getElementById('welcome');
                l.style.display = 'block';
            }else{
                layer.msg(ret.em);
            }
        }
    });

}

function showPhoto(page,gid,url){
    var data = {
        'page' : page,
        'gid'  : gid
    };
    $.ajax({
        'type'      : 'post',
        'url'       : url,
        'data'      : data,
        'dataType'  : 'json',
        'success'   : function(ret){
            if(ret.ec == 200){
                for(var i= 0; i < 27 ; i++){
                    if(i < ret.data.length){
                        var temp = ret.data[i];
                        var _html = '<img src="'+temp['gr_photo']+'" data-xuanyan="'+temp['gr_sign']+'" data-wechatid="'+temp['gr_mobile']+'" alt="秀恩爱" onclick="seeBigphoto(this)">';
                        $('#sp_img_'+i).html(_html);
                    }else{
                        $('#sp_img_'+i).html('');
                    }
                }
            }else{
                layer.msg(ret.em);
            }
        }
    });
}


