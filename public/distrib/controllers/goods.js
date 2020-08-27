/**
 * Created by zhaoweizhen on 16/8/20.
 */
function toMathVIp(ele){
    var key = $(ele).data('key');
    if(key == 1){
        var price = $(ele).val();
        $('#g_price').val(price);
        mathVIp();
    }
}
/**
 * 计算VIP价格
 */
function mathVIp(){
    var price    = $('#g_price').val();
    var discount = $('#g_vip_discount').val();
    discount     = parseInt(discount);
    if(discount > 100 || discount < 1){
        discount = 100;
        $('#g_vip_discount').val(discount);
    }
    var dp       = price * discount / 100;
    $('#mathPrice').val(dp.toFixed(2));
}
/**
 * 保存商品自定义分类
 * @param data
 */
function saveGoodsCategory(data){
    var index = layer.load(1, {
        shade: [0.1,'#fff'] //0.1透明度的白色背景
    });
    $.ajax({
        'type'  : 'post',
        'url'   : '/distrib/goods/saveGoodsCategory',
        'data'  : data,
        'dataType'  : 'json',
        success : function(ret){
            layer.close(index);
            layer.msg(ret.em);
            if(ret.ec == 200){
                // window.location.reload();
            }
        }
    });
}

function customerGoodsCategory(df){
    $.ajax({
        'type'  : 'post',
        'url'   : '/distrib/goods/ajaxGoodsCustomCategory',
        'dataType'  : 'json',
        success : function(ret){
            console.log(ret.data);
            if(ret.ec == 200){
                customer_category(ret.data,df);
            }
        }
    });
}
function customer_category(data,df){
    var html = '<select id="custom_cate" name="custom_cate" class="form-control">';
    for(var i = 0; i < data.length ; i++){
        var son = data[i].secondItem;
        html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
        for(var s = 0 ; s < son.length ; s ++){
            var sel = '';
            if(df == son[s].id){
                sel = 'selected';
            }
            html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
        }

        html += '';
        html += '</optgroup>';
    }
    html += '</select>';
    console.log(html);
    $('#customCategory').html(html);
}