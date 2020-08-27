<link rel="stylesheet" href="/public/common/css/font-awesome.min.css">
<link rel="stylesheet" href="/public/manage/css/select-input.css">
<style>
    .mem-list {
        left: 11px;
        top: 35px;
        width: 97%;
    }
    .placeholder{
        position: absolute;
        right: 25px;
        top: 7px;
        color: #888;
    }
</style>
<{include file="../common-kind-editor.tpl"}>
<div style="margin-top: 10px;" class="information">
    <form class="form-horizontal" role="form">
        <input type="hidden" id="id" value="<{$row['g_id']}>" class="form-control col-sm-8">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 头像：</label>
            <div>
                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['g_cover']}><{$row['g_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="100" style="display:inline-block;margin-left:12px;">
                <input type="hidden" id="cover"  class="avatar-field bg-img" name="g_cover" value="<{if $row && $row['g_cover']}><{$row['g_cover']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-cover">修改</a>
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-3 control-label"><font color="red">*</font>分类：</label>
            <div class="control-group col-sm-6"">
                <select id="g_kind2" name="g_kind2" class="form-control">
                    <{foreach $category as $key => $val}>
                    <option <{if $row && $row['g_kind2'] eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label  class="col-sm-3 control-label"><font color="red">*</font>所属门店：</label>
            <div class="control-group col-sm-6"">
            <select id="g_kind3" name="g_kind3" class="form-control">
                <{foreach $storeList as $key => $val}>
                <option <{if $row && $row['g_kind3'] eq $val['os_id']}>selected<{/if}> value="<{$val['os_id']}>"><{$val['os_name']}></option>
                <{/foreach}>
            </select>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 姓名：</label>
            <div class="col-sm-6">
                <input type="text" id="name" value="<{$row['g_name']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 资质(添加多个用“/”分隔)：</label>
            <div class="col-sm-6">
                <input type="text" id="label" value="<{$row['g_label']}>" class="form-control col-sm-8" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 从业时长：</label>
            <div class="col-sm-6" style="position: relative">
                <input type="text" id="sold" value="<{$row['g_sold']}>" class="form-control col-sm-8">
                <label class="placeholder">年</label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 擅长：</label>
            <div class="col-sm-6">
                <input type="text" id="brief" value="<{$row['g_brief']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 电话：</label>
            <div class="col-sm-6">
                <input type="text" id="mobile" value="<{$row['g_bed_info']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 权重：</label>
            <div class="col-sm-6">
                <input type="text" id="sort" value="<{$row['g_weight']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div cclass="form-group">
            <div class="info-group-inner">
                <label class="col-sm-3 control-label no-padding-right" for="web-title"> 介绍：</label>

                <div class="col-sm-6" style="margin-left: 0">
                    <textarea class="form-control" style="width:100%;height:200px;" id = "detail" name="detail"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['g_detail']}><{$row['g_detail']}><{/if}></textarea>
                </div>

            </div>
        </div>
        <div class="form-group" style="text-align: center;margin-top: 50px;">
            <button class="btn btn-sm btn-primary" type="button" id="confirm_information" >确认提交</button>
        </div>
    </form>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" charset="utf-8" src="/public/manage/assets/js/bootstrap-select.js"></script>
<script>
    // 提交信息
    $(function(){
        // 提交信息
        $("#confirm_information").click(function(){
            var id            = $("#id").val();
            var cover         = $('#cover').val();
            var name          = $('#name').val();
            var label         = $('#label').val();
            var sold          = $('#sold').val();
            var brief         = $('#brief').val();
            var detail        = $('#detail').val();
            var kind2         = $('#g_kind2').val();
            var kind3         = $('#g_kind3').val();
            var mobile        = $('#mobile').val();
            var sort          = $('#sort').val();
            var index = layer.load(2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            var data = {
                'id'       : id,
                'g_cover'    : cover,
                'g_name'     : name,
                'g_label'    : label,
                'g_sold'     : sold,
                'g_brief'    : brief,
                'g_detail'   : detail,
                'g_kind2'    : kind2,
                'g_kind3'    : kind3,
                'mobile'     : mobile,
                'sort'       : sort
            };
            $.ajax({
                type: 'post',
                url: "/wxapp/reservation/saveGood" ,
                data: data,
                dataType: 'json',
                success: function(json_ret){
                    layer.msg(json_ret.em);
                    layer.close(index);
                    if(json_ret.ec == 200){
                        window.location.href='/wxapp/reservation/experts';
                    }
                }
            });

        });

    })






</script>