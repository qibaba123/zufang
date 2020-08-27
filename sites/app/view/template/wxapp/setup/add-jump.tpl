<link rel="stylesheet" href="/public/manage/group/css/addgroup.css">
<style>
    .add-gift{
        padding-top: 10px;
    }
    .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .input-table{
        width: 90%;
        margin-left: 5%;
    }
    .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .input-table label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 130px;
        line-height: 34px;
    }
    .input-table .form-control{
        width: 290px;
        height: 34px;
    }
</style>
<div class="alert alert-block alert-warning" style="line-height: 20px;">
    <button type="button" class="close" data-dismiss="alert">
        <i class="icon-remove"></i>
    </button>
    由于微信平台机制的一些调整，新添加或修改跳转小程序都需要提交新版本审核，审核通过后才能使用——<a href="https://developers.weixin.qq.com/miniprogram/dev/api/open-api/miniprogram-navigate/wx.navigateToMiniProgram.html" target="_blank">查看详情</a>。
    <br/>
</div>
<div class="add-gift" id="div-add" >
    <input type="hidden" id="applet_id"  class="form-control" value="<{if $row}><{$row['aj_id']}><{/if}>"/>
    <table class="input-table">
        <tr>
            <td class="label-td"><label><span class="red">*</span>小程序名称:</label></td>
            <td><input type="text" id="name"  class="form-control" placeholder="请输入小程序名称" value="<{if $row}><{$row['aj_name']}><{/if}>"/></td>
        </tr>
        <tr>
            <td class="label-td"><label><span class="red">*</span>小程序APPID:</label></td>
            <td><input type="text" id="appid"  class="form-control" placeholder="请输入小程序APPID" value="<{if $row}><{$row['aj_appid']}><{/if}>"/></td>
        </tr>
        <tr>
            <td class="label-td"><label><span class="red">*</span>小程序logo:(300*300)</label></td>
            <td>
                <div class="cropper-box" data-width="300" data-height="300" >
                    <img style="margin: inherit!important;" <{if $row && $row['aj_logo']}>src=<{$row['aj_logo']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_45_45.png"<{/if}> width=10%>
                    <input type="hidden" id="applet-logo"  class="avatar-field bg-img" name="applet-logo" value="<{if $row && $row['aj_logo']}><{$row['aj_logo']}><{/if}>"/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label-td"><label><span class="red">*</span>小程序简介:</label></td>
            <td><textarea type="text" id="brief" rows="4" style="height: 120px" class="form-control" placeholder="请输入小程序简介" ><{if $row}><{$row['aj_brief']}><{/if}></textarea></td>
        </tr>
        <tr>
            <td class="label-td"><label><span class="red">*</span>背景图:(750*360)</label></td>
            <td>
                <div class="cropper-box" data-width="750" data-height="360" >
                    <img style="margin: inherit!important;" <{if $row && $row['aj_background']}>src=<{$row['aj_background']}><{else}>src="/public/manage/img/zhanwei/zw_fxb_75_36.png"<{/if}> width=20%>
                    <input type="hidden" id="background"  class="avatar-field bg-img" name="background" value="<{if $row && $row['aj_background']}><{$row['aj_background']}><{/if}>"/>
                </div>
            </td>
        </tr>
        <tr>
            <td class="label-td"><label>小程序排序:（数越大排序越靠前）</label></td>
            <td><input type="text" id="sort"  class="form-control" placeholder="请输入小程序" value="<{if $row}><{$row['aj_sort']}><{/if}>"/></td>
        </tr>
        <tr>
            <td class="label-td"><label>小程序跳转的路径:（可以不填）</label></td>
            <td><input type="text" id="path"  class="form-control" placeholder="请输入小程序跳转的路径" value="<{if $row}><{$row['aj_path']}><{/if}>"/></td>
        </tr>
        <tr>
            <td class="label-td"><label>小程序备注:</label></td>
            <td><textarea type="text" id="extra" rows="4" style="height: 100px" class="form-control" placeholder="请输入小程备注信息" ><{if $row}><{$row['aj_extra']}><{/if}></textarea></td>
        </tr>
        <tr>
            <td class="label-td"><label><span class="red">&nbsp;</td>
            <td><a href="javascript:;" class="btn btn-sm btn-green btn-save"> 保 存 </a></td>
        </tr>
    </table>
</div>
<!--添加礼物结束-->
<{include file="../img-upload-modal.tpl"}>

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript">

    $('.btn-save').on('click',function() {
        var logo = $('#applet-logo').val();
        var background = $('#background').val();
        if (!logo) {
            layer.msg('请上传小程序logo');
            return;
        }
        if (!background) {
            layer.msg('请上传小程序背景图');
            return;
        }
        var data = {
            id : $('#applet_id').val(),
            logo: logo,
            background: background,
            path: $('#path').val(),
            extra: $('#extra').val()
        };
        var field = new Array('name', 'appid', 'brief', 'sort');
        for (var i = 0; i < field.length; i++) {
            var temp = $('#' + field[i]).val();
            if (temp) {
                data[field[i]] = temp
            } else {
                var msg = $('#' + field[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }
        var loading = layer.load(10, {
            shade: [0.6, '#666']
        });
        console.log(data);
        //保存信息
        $.ajax({
            'type': 'post',
            'url': '/wxapp/setup/saveJump',
            'data': data,
            'dataType': 'json',
            'success': function (ret) {
                layer.close(loading);
                layer.msg(ret.em);
                if (ret.ec == 200) {
                    window.location.href = '/wxapp/setup/jumpList'
                }
            }
        });
    })
</script>