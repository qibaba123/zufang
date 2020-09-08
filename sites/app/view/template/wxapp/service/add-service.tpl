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

<{include file="../../manage/common-kind-editor.tpl"}>
<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_id" value="<{if $row && $row['es_id']}><{$row['es_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="" style="width: 100%" >服务名称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="name" placeholder="服务名称" class="form-control" name="name" value="<{if $row && $row['es_name']}><{$row['ap_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">LOGO<font color="red">*</font></label>
            <div class="col-sm-8">
                <div>
                    <div class="cropper-box" data-width="710" data-height="250" style="height:100%;">
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="420" data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['es_logo']}><{$row['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="logo"  class="avatar-field bg-img" name="logo" value="<{if $row && $row['es_logo']}><{$row['es_logo']}><{/if}>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">封面<font color="red">*</font></label>
            <div class="col-sm-8">
                <div>
                    <div class="cropper-box" data-width="710" data-height="250" style="height:100%;">
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="420" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['es_cover']}><{$row['es_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['es_cover']}><{$row['es_cover']}><{/if}>"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group ">
            <label for="">服务类型：</label>
            <div class="control-group">
                <div class="col-sm-8">
                    <select class="form-control" name="type" id="type" >
                        <option value="0">请选择服务类型</option>
                        <option value="1" <{if $row['es_type'] == 1}>selected<{/if}>>企业服务商品</option>
                        <option value="2" <{if $row['es_type'] == 2}>selected<{/if}>>企业服务文章</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group priceshow" <{if $row['es_type'] == 2}> style="display:none;" <{/if}>>
            <label for="">金额<font color="red">*</font></label>
            <div class="control-group">
                <input id="price" class="form-control"  placeholder="金额" value="<{if $row && $row['es_price']}><{$row['es_price']}><{/if}>">
            </div>
        </div>
        <div class="form-group">
            <label for="">权重<font color="red">*</font></label>
            <div class="control-group">
                <input id="weight" class="form-control"  placeholder="权重" value="<{if $row && $row['es_weight']}><{$row['es_weight']}><{/if}>">
            </div>
        </div>
    <div class="form-group">
        <label for="">简介<font color="red">*</font></label>
        <div class="control-group">
            <textarea class="form-control" style="width:100%;height:200px;" id = "brief" name="brief" placeholder="简介"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['es_brief']}><{$row['es_brief']}><{/if}></textarea>
        </div>
    </div>
    <div class="form-group">
        <label for="">详情<font color="red">*</font></label>
        <div class="control-group">
              <textarea class="form-control" style="width:100%;height:600px;visibility:hidden;" id = "content" name="content" placeholder="详情"  rows="20" style=" text-align: left; resize:vertical;" >
                                                                 <{$row['es_content']}>
                                                         </textarea>
            <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
            <input type="hidden" name="ke_textarea_name" value="detail" />
        </div>
    </div>
    </div>
    </div>
<div class="alert setting-save" style="text-align: center;margin-top:100px;">
    <button class="btn btn-primary btn-save">保存</button>
</div>


<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="https://webapi.amap.com/maps?v=1.3&key=099aa80c85be20b87ecf7fd6ad75bdc2"></script>

<script type="text/javascript">
    $('#type').change(function(){
        var type = $(this).val();
        if(type == 1){
            $('.priceshow').show();
        }else{
            $('.priceshow').hide();
        }

    });


    $('.btn-save').click(function(event){
        var id            = $('#hid_id').val();
        var name          = $('#name').val();
        var weight        = $('#weight').val();
        var type          = $('#type').val();
        var logo          = $('#logo').val();
        var cover         = $('#cover').val();
        var price         = $('#price').val();
        var brief         = $('#brief').val();
        var content       = $('#content').val();
        var load_index = layer.load(
                2, {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );

        var data = {
            id : id,
            name      : name,
            weight    : weight,
            type      : type,
            logo      : logo,
            cover     : cover,
            price     : price,
            brief     : brief,
            content   : content
        };

        $.ajax({
            'type'   : 'post',
            'url'   : '/wxapp/service/saveService',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/service/serviceList';
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