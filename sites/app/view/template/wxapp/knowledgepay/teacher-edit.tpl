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
        <input type="hidden" id="id" value="<{$row['akt_id']}>" class="form-control col-sm-8">

        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 头像：</label>
            <div>
                <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-avatar" id="upload-avatar"  src="<{if $row && $row['akt_avatar']}><{$row['akt_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="100" style="display:inline-block;margin-left:12px;">
                <input type="hidden" id="avatar"  class="avatar-field bg-img" name="ahe_cover" value="<{if $row && $row['akt_avatar']}><{$row['akt_avatar']}><{/if}>"/>
                <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-avatar">修改</a>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 姓名：</label>
            <div class="col-sm-6">
                <input type="text" id="name" value="<{$row['akt_name']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 标签：</label>
            <div class="col-sm-6">
                <input type="text" id="label" value="<{$row['akt_label']}>" class="form-control col-sm-8">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label no-padding-right" for="web-title"> 简介：</label>
            <div class="col-sm-6">
                <textarea name="desc" id="desc" cols="30" rows="3" class="form-control col-sm-8"><{$row['akt_desc']}></textarea>
            </div>
        </div>
        <div cclass="form-group">
            <div class="info-group-inner">
                <label class="col-sm-3 control-label no-padding-right" for="web-title"> 详情介绍：</label>

                <div class="col-sm-6" style="margin-left: 0">
                    <textarea class="form-control" style="width:100%;height:500px;visibility:hidden;" id = "detail" name="detail" placeholder="详情介绍"  rows="20" style=" text-align: left; resize:vertical;" >
                    <{if $row && $row['akt_detail']}><{$row['akt_detail']}><{/if}>
                     </textarea>
                    <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                    <input type="hidden" name="ke_textarea_name" value="detail" />
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
            var id             = $("#id").val();
            var avatar         = $("#avatar").val();
            var name           = $("#name").val();
            var label          = $("#label").val();
            var desc           = $("#desc").val();
            var detail         = $("#detail").val();

            var index = layer.load(2,
                    {
                        shade: [0.1,'#333'],
                        time: 10*1000
                    }
            );
            var data = {
                'id'       : id,
                'avatar'   : avatar,
                'name'     : name,
                'label'    : label,
                'desc'     : desc,
                'detail'   : detail,
            };
            $.ajax({
                type: 'post',
                url: "/wxapp/knowledgepay/saveTeacher" ,
                data: data,
                dataType: 'json',
                success: function(json_ret){
                    layer.msg(json_ret.em);
                    layer.close(index);
                    if(json_ret.ec == 200){
                        window.location.href='/wxapp/knowledgepay/teacherList';
                    }
                }
            });

        });

    })




</script>