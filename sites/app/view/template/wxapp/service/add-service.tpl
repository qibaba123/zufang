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
                <input type="text" id="es_name" placeholder="服务名称" class="form-control" name="es_name" value="<{if $row && $row['es_name']}><{$row['es_name']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">LOGO<font color="red">*</font></label>
            <div class="control-group">
                        <img onclick="toUpload(this)" data-limit="1" data-width="250" data-height="250" data-dom-id="upload-logo" id="upload-logo"  src="<{if $row && $row['es_logo']}><{$row['es_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                        <input type="hidden" id="logo"  class="avatar-field bg-img" name="logo" value="<{if $row && $row['es_logo']}><{$row['es_logo']}><{/if}>"/>

        </div>
        </div>
        <div class="form-group">
            <label for="">封面<font color="red">*</font></label>
            <div class="control-group">

                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="420" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['es_cover']}><{$row['es_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;width: 150px">
                        <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['es_cover']}><{$row['es_cover']}><{/if}>"/>
                    </div>
        </div>
        <div class="form-group ">
            <label for="">服务类型：</label>
            <div class="control-group">
                    <select class="form-control" name="type" id="type" >
                        <option value="0">请选择服务类型</option>
                        <option value="1" <{if $row['es_type'] == 1}>selected<{/if}>>企业服务商品</option>
                        <option value="2" <{if $row['es_type'] == 2}>selected<{/if}>>企业服务文章</option>
                    </select>
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
            <input type="hidden" name="ke_textarea_name" value="content" />
        </div>
    </div>
    </div>
<div class="alert alert-warning setting-save" role="alert">
    <button class="btn btn-primary btn-sm btn-save" style="background-color: #02c700;margin-right: 15px">保存</button>
</div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
    <script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
    <script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>
    <script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
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
        var name          = $('#es_name').val();
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


</script>
