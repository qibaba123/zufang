<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<style>
    .layui-layer .container{
        width: 100%;
    }

    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
    #shop-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #shop-tr td img{
        width: 60px;
        height: 60px;
    }
    #shop-tr td p.g-name{
        margin:0;
        padding:0;
        height: 30px;
        line-height: 30px;
        max-width: 400px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #38f;
        font-family: '黑体';
    }
    .pull-right>.btn{
        margin-left: 6px;
    }
    .good-search .input-group{
        margin:0 auto;
        width: 70%;
    }
    .table-responsive{
        width: 100%;
    }
    .modal-body {
        overflow: auto;
        padding: 10px 15px;
        max-height: 500px;
    }
    .goods-selected{
        padding: 5px 2px;
        margin: 0 2px;
        position: relative;
    }
    .goods-selected-name{
        font-weight: bold;
        color: #38f;
        width: 90%;
        display: inline-block;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        position: relative;
        top: 5px;
    }
    .goods-selected-button{
        width: 9%;
        display: inline-block;
        padding-left: 2px;
    }
</style>
<{include file="../article-kind-editor.tpl"}>
<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_id" value="<{if $row && $row['ap_id']}><{$row['ap_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="" class="">首页图片 ( 110 * 80 )</label>
            <div class="control-group">
                <img onclick="toUpload(this)" data-limit="1" data-width="110" data-height="80" data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['ap_logo']}><{$row['ap_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                <input type="hidden" id="logo"  class="avatar-field bg-img" name="logo" value="<{if $row && $row['ap_logo']}><{$row['ap_logo']}><{/if}>"/>

            </div>
        </div>
        <div class="form-group">
            <label for="" style="width: 100%" >园区名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="ap_name" placeholder="园区名称" class="form-control" name="ap_name" value="<{if $row && $row['ap_name']}><{$row['ap_name']}><{/if}>"/>
            </div>
        </div>

        <div class="form-group">
            <label for="">权重<font color="red">*</font></label>
            <div class="control-group">
                <input id="ap_weight" class="form-control"  placeholder="权重" value="<{if $row && $row['ap_weight']}><{$row['ap_weight']}><{/if}>">
            </div>
        </div>
        <div class="form-group ">
            <label for="">选择城市：</label>
            <div class="control-group">
                <div class="col-sm-8" style="width:20%;">
                    <select class="form-control" name="pro" id="pro" >
                        <option value="0">省份</option>
                        <{foreach $province as $val}>
                    <option value="<{$val['region_id']}>" <{if $row['ap_pro'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="col-sm-8" style="width:20%;">
                    <select class="form-control" name="city" id="city" >
                        <option value="0">城市</option>
                        <{foreach $city as $val}>
                          <option value="<{$val['region_id']}>" <{if $row['ap_city'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="col-sm-8" style="width:20%;">
                    <select class="form-control" name="area" id="area" >
                        <option value="0">地区</option>
                        <{foreach $area as $val}>
                            <option value="<{$val['region_id']}>" <{if $row['ap_area'] == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
        </div>

    </div>


    </div>
<div class="alert setting-save" style="text-align: center;margin-top:100px;">
    <button class="btn btn-primary btn-save">保存</button>
</div>
<{include file="../img-upload-modal.tpl"}>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript">
    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#cover').val(allSrc[0]);
                }
                if(nowId == 'upload-logo'){
                    $('#logo').val(allSrc[0]);
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
    $('#pro').change(function(){
        $("#city").html('');
        $("#area").html('');
        var p_ro = $(this).val();
        //console.log(p_ro);return;
        var data = {
            'pro' : p_ro,
        }
        $.ajax({
            url:'/wxapp/park/getcity',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value=''>地市</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#city").html(option);
            }
        })

    });
    $('#city').change(function(){
        $("#area").html('');
        var city = $(this).val();
        var data = {
            'city' : city,
        }
        $.ajax({
            url:'/wxapp/park/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#area").html(option);
            }
        })

    });

    $('.btn-save').click(function(event){
        var id            = $('#hid_id').val();
        var ap_name       = $('#ap_name').val();
        var ap_weight     = $('#ap_weight').val();
        var pro           = $('#pro').val();
        var city          = $('#city').val();
        var area          = $('#area').val();
        var logo          = $('#logo').val();
        var pro_name      = $("#pro").find("option:selected").text();
        var city_name     = $("#city").find("option:selected").text();
        var area_name     = $("#area").find("option:selected").text();
        var load_index = layer.load(
                2, {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );

        var data = {
            id : id,
            ap_name : ap_name,
            ap_weight : ap_weight,
            pro         : pro,
            city        : city,
            area        : area,
            logo        : logo,
            pro_name    : pro_name,
            city_name   : city_name,
            area_name   : area_name
        };

        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/park/savePark',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/park/parkList';
                    //$('.btn-save').removeAttr('disabled');
                }else{

                }
            }
        });
    });

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    });

    //管理商品
    $('.btn-add-shop').on('click',function(){
        $('#shop-tr').empty();
        $('#footer-page').empty();
        var type = $(this).data('mk');

        $('.th-weight').hide();

        $('#shop-modal').modal('show');

        //重新获取数据
        $('#mkType').val(type) ;
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchShopPageData(currPage);
    });

    function fetchShopPageData(page){
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  $('#mkType').val() ,
            'id'    :  $('#currId').val()  ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/city/selectShop',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                if(ret.ec == 200){
                    fetchShopHtml(ret.list);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchShopHtml(data){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].acs_id+'">';
            html += '<td><img src="'+data[i].acs_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].acs_name+'</p></td>';
            html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-sid="'+data[i].acs_id+'" data-name="'+data[i].acs_name+'" onclick="dealShop( this )"> 选取 </td>';
            html += '</tr>';
        }
        $('#shop-tr').html(html);
    }

    //选择关联商品
    function dealShop(ele) {
        var sid = $(ele).data('sid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[sid='" +sid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' sid='"+ sid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        $('.goods-selected-list').append(append_html);
        $('#shop-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐店铺 </span>';
            $('.goods-selected-list').html(default_html);
        }
    }

    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐店铺</span>';
        $('.goods-selected-list').html(default_html);
    });

</script>
<{include file="../img-upload-modal.tpl"}>