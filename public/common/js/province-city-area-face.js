/**
 * Created by zhaoweizhen on 16/8/18.
 */

function initSelect(){
    initRegion(1,'province');
}
/**
 * 省会变更
 */
function changeProvince(){
    var fid = $('#province').val();
    initRegion(fid ,'city');
}
/**
 * 城市变更
 */
function changeCity(){
    var fid = $('#city').val();
    initRegion(fid ,'zone');
}

function initRegion(fid,selectId,df){
    if(fid > 0) {
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/agent/index/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                    if(!df){
                        if(selectId == 'province'){
                            initRegion(ret.data[0].aa_id,'city');
                        }
                        if(selectId == 'city'){
                            initRegion(ret.data[0].aa_id,'zone');
                        }
                    }
                    changeCodeNow();
                }
            }
        });
    }
}

function changeCodeNow(codes) {
    let codetype = $('#code_type').val();
    $('#coderel').val(codes);
    if(codetype == 1){
        $('#bank_address_code').val(codes);
    }else{
        $('#store_address_code').val(codes);
    }
}

/**
 * 省会变更
 */
function changeWxappProvince(){
    var fid = $('#province').val();
    initWxappRegion(fid ,'city');
    var code = $('#province option:selected').attr("data-code");
    changeCodeNow(code);
}
/**
 * 城市变更
 */
function changeWxappCity(){
    var fid = $('#city').val();
    initWxappRegion(fid ,'zone');
    var code = $('#city option:selected').attr("data-code");
    changeCodeNow(code);
}
/**
 * 区域变更
 */
function changeZone(){
    var code = $('#zone option:selected').attr("data-code");
    changeCodeNow(code);
}


function initWxappRegion(fid,selectId,df){
    // console.log('执行请求方法');
    if(fid >= 0) {
        // console.log('执行请求方法 > 0');
        var data = {
            'fid': fid
        };
        $.ajax({
            'type'   : 'post',
            'url'   : '/agent/index/region',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    region_html(ret.data,selectId,df);
                    if(!df){
                        if(selectId == 'province'){
                            initWxappRegion(ret.data[0].aa_id,'city');
                            //$('#bank_address_code').val(ret.data[0].aa_ad_code);
                        }
                        if(selectId == 'city'){
                            initWxappRegion(ret.data[0].aa_id,'zone');
                        }
                    }
                    //$('#bank_address_code').val(ret.data[0].aa_ad_code);
                }
            }
        });
    }
}



/**
 * 展示区域省市区
 * @param data
 * @param selectId
 */
function region_html(data,selectId,df){
    // console.log('渲染数据');
    var option = '';
    if(selectId != 'province'){
        option += '<option data-code="" value="">请选择</option>';
    }
    for(var i=0 ; i < data.length ; i++){
        var temp  = data[i];
        var sel   = '';
        if(df && temp.aa_id == df ){
            sel = 'selected';
        }
        option += '<option data-code="'+temp.aa_ad_code+'"  value="'+temp.aa_id+'" '+sel+'>'+temp.aa_name+'</option>';
    }
    $('#'+selectId).html(option);
}

