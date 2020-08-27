<style>
    .password-redpack .info-title{
        padding:10px 0;
        border-bottom: 1px solid #eee;
    }
    .password-redpack .info-title span{
        line-height: 16px;
        font-size: 15px;
        font-weight: bold;
        display: inline-block;
        padding-left: 10px;
        border-left: 3px solid #3d85cc;
    }
    .password-redpack .input-table{
        width: 100%;
    }
    .password-redpack .input-table td{
        padding:8px 10px;
        vertical-align: middle;
    }
    .password-redpack .input-table td>div{
        display: inline-block;
        vertical-align: middle;
    }
    .password-redpack .input-table td.label-td{
        padding-right: 0;
        width: 130px;
        text-align: right;
        vertical-align: top;
    }
    .password-redpack label{
        text-align: right;
        font-weight: bold;
        font-size: 14px;
        width: 145px;
        line-height: 34px;
    }
    .password-redpack .input-table .form-control{
        width: 400px;
    }
    .password-redpack {
        margin-left: 140px;
    }
    .password-redpack .input-group .form-control{
        width: 120px;
    }

    .input-table textarea.form-control{
        width: 100%;
        max-width: 750px;
        height: auto;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div class="password-redpack">
    <h4 class="info-title"><span>添加VR全景</span></h4>
    <form id="keyword-redpack">
        <table class="input-table">
            <tr>
                <td class="label-td"><label><span class="red">*</span>VR链接地址:</label></td>
                <td>
                    <div><textarea rows="3" id="vrUrl" name="vrUrl" class="form-control" placeholder="请填写VR全景链接"><{if $row && $row['av_vr_url']}><{$row['av_vr_url']}><{/if}></textarea></div>
                        <div style="line-height: 30px;margin-top: 10px">
                            <span style="color: red">提示：</span>
                            <span>如果您使用的是<a href="#">《幻境VR联盟》</a>拍摄的VR全景则直接填写ID值即可，例如：<a href="https://hb.51fenxiaobao.com/tour.html?id=7e1d1999913da196" target="_blank">https://hb.51fenxiaobao.com/tour.html?id=7e1d1999913da196</a>只需将<a href="#">7e1d1999913da196</a>填写上即可</span>
                        </div>
                        <div style="line-height: 30px">
                            <span style="margin-left: 45px">如果您使用的是其他团队拍摄的VR全景则需要将完整的链接填写，例如：<a href="http://www.360.3dzs.cn/hy/" target="_blank">http://www.360.3dzs.cn/hy/</a>则直接将链接填写上</span>
                        </div>
                </td>
            </tr>

            <tr >
                <td class="label-td"><label><span class="red">*</span>分享标题:</label></td>
                <td>
                    <span class="span-right" style="width: 300px">
                        <input type="text" class="form-control" placeholder="请输入分享标题" id="share_title" maxlength="30" value="<{if $row && $row['av_vr_share_title']}><{$row['av_vr_share_title']}><{/if}>">
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label-td"><label for="">分享封面<span class="img-tips">（图片建议尺寸500px*400px）</span></label></td>
                <td>
                    <div class="cropper-box" data-width="500" data-height="400" >
                        <img style="width: 40% !important;" src="<{if $row && $row['av_vr_share_cover']}><{$row['av_vr_share_cover']}><{else}>/public/manage/img/zhanwei/zw_555_480.png<{/if}>" onload="" />
                        <input type="hidden" id="share_cover" name="cover" value="<{if $row && $row['av_vr_share_cover']}><{$row['av_vr_share_cover']}><{/if}>" />
                    </div>
                </td>
            </tr>

            <tr>
                <td class="label-td"><label><span class="red">*</span>开启VR全景:</label></td>
                <td>
                    <span class='tg-list-item'>
                        <input class='tgl tgl-light' id='vr_is_open' type='checkbox' <{if $row && $row['av_vr_isopen']}>checked<{/if}> >
                        <label class='tgl-btn' for='vr_is_open'></label>
                    </span>
            </tr>
            <tr>
                <td class="label-td"></td>
                <td>
                    <a href="javascript:;" class="btn btn-sm btn-green" onclick="saveMusic()"> 保 存 </a>
                </td>
            </tr>
        </table>
    </form>
</div>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>

<script>
    // 保存视频信息
    function saveMusic() {
        var vrUrl = $('#vrUrl').val();
        var title = $('#share_title').val();
        var cover = $('#share_cover').val();
        var open     = $('#vr_is_open:checked').val();
        console.log(open);
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/saveVrUrl',
            'data'  : { vrUrl:vrUrl,open:open == 'on' ? 1 : 0, 'title': title, 'cover': cover},
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
            }
        });
    }
</script>
<{$cropper['modal']}>