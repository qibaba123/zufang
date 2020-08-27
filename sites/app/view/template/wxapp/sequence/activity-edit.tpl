<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<style>
    .container{
        width: 60%;
    }
    .group-info .control-group .form-control {
        max-width: 100%;
    }
    .layui-layer .container{
        width: 100%;
    }

    .modal-dialog{
        width: 700px;
    }
    .modal-body{
        overflow: auto;
        padding:10px 15px;
        max-height: 500px;
    }
    .modal-body .fanxian .row{
        line-height: 2;
        font-size: 14px;
    }
    .modal-body .fanxian .row .progress{
        position: relative;
        top: 5px;
    }
    .modal-body table{
        width: 100%;
    }
    .modal-body table th{
        border-bottom:1px solid #eee;
        padding:10px 5px;
        text-align: center;
    }
    #goods-tr td{
        padding:8px 5px;
        border-bottom:1px solid #eee;
        cursor: pointer;
        text-align: center;
        vertical-align: middle;
    }
    #goods-tr td img{
        width: 60px;
        height: 60px;
    }
    #goods-tr td p.g-name{
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
    #add-modal .radio-box input[type="radio"]+label{
        height: auto;
    }
    #add-modal .radio-box input[type="radio"]+label:after{
        height: 100%;
    }
    .search-input{
        width: 90% !important;
        margin-bottom: 5px !important;
        display: block !important;
    }
    .time-input{
        display: inline-block !important;
        width: 25% !important;
        margin-right: 10px;
    }
    label{
       font-weight: bold;
    }
    .control-group{
        margin-top: 5px;
    }

</style>

<div class="container">
    <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['asa_id']}><{$row['asa_id']}><{/if}>"/>
    <div class="group-info">
        <div class="form-group">
            <label for="">活动标题<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asa_title" placeholder="请填写活动标题" class="form-control"  value="<{if $row && $row['asa_title']}><{$row['asa_title']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">活动描述</label>
            <div class="control-group">
                <textarea name="asa_desc" id="asa_desc" cols="30" rows="3" class="form-control"><{if $row && $row['asa_desc']}><{$row['asa_desc']}><{/if}></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="">图片<font color="red">*</font><small>最多九张，尺寸 640 x 640 像素</small></label>
            <div class="control-group" style="margin-top: 15px">
                <div id="slide-img" class="pic-box" style="display:inline-block">
                    <{foreach $imgList as $key=>$val}>
                    <p class="img-p">
                        <img class="img-thumbnail col" layer-src="<{$val['asai_path']}>"  layer-pid="" src="<{$val['asai_path']}>" >
                        <span class="delimg-btn">×</span>
                        <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val['asai_path']}>" class="img-path">
                        <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$val['asai_id']}>" class="img-id">
                    </p>
                    <{/foreach}>
                </div>
                <span onclick="toUpload(this)" data-limit="9" data-width="640" data-height="640" data-dom-id="slide-img" class="btn btn-success btn-xs">添加幻灯</span>
                <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
            </div>
        </div>
        <input type="hidden" value="" id="nowTime">

            <div class="form-group">
                <label for="">活动时间<font color="red">*</font></label>
                <div class="control-group" style="width: 80%">
                    开始时间：<input id="asa_start" name="asa_start" autocomplete="off" type="text" placeholder="请选择活动开始时间" class="form-control time-input" value="<{if $row['asa_start']}><{date('Y-m-d H:i:s',$row['asa_start'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'asa_end\');}'})">
                    结束时间：<input id="asa_end" name="asa_end" autocomplete="off" type="text" placeholder="请选择活动结束时间" class="form-control time-input" value="<{if $row['asa_end']}><{date('Y-m-d H:i:s',$row['asa_end'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'nowTime\');}'})">
                </div>
            </div>
            <div class="form-group">
                <label for="">提货时间<font color="red">*</font></label>
                <div class="control-group" style="width: 80%">
                    开始时间：<input id="asa_receive_start" name="asa_receive_start" autocomplete="off" type="text" placeholder="请选择提货开始时间" class="form-control time-input" value="<{if $row['asa_receive_start']}><{date('Y-m-d H:i:s',$row['asa_receive_start'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                    结束时间：<input id="asa_receive_end" name="asa_receive_end" autocomplete="off" type="text" placeholder="请选择提货结束时间" class="form-control time-input" value="<{if $row['asa_receive_end']}><{date('Y-m-d H:i:s',$row['asa_receive_end'])}><{/if}>" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'asa_receive_start\');}'})">
                </div>
            </div>
            <!--
            <input type="hidden" value="" id="asa_start" name="asa_start">
            <input type="hidden" value="" id="asa_end" name="asa_end">
            <input type="hidden" value="" id="asa_receive_start" name="asa_receive_start">
            <input type="hidden" value="" id="asa_receive_end" name="asa_receive_end">
            -->

        <div class="form-group">
            <label for="">供应商昵称<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asa_nickname" placeholder="请填写供应商昵称" class="form-control"  value="<{if $row && $row['asa_nickname']}><{$row['asa_nickname']}><{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">供应商头像<font color="red">*</font><small style="font-size: 12px;color:#999">建议尺寸：200 x 200 像素</small></label>
            <div class="control-group" style="margin-top: 10px">
                <div>
                    <img onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-asa_avatar" id="upload-asa_avatar"  src="<{if $row && $row['asa_avatar']}><{$row['asa_avatar']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="150" style="display:inline-block;margin-left:0;">
                    <input type="hidden" id="asa_avatar"  class="avatar-field bg-img" name="asa_avatar" placeholder="请上传供应商头像" value="<{if $row && $row['asa_avatar']}><{$row['asa_avatar']}><{/if}>"/>
                    <a href="javascript:;" onclick="toUpload(this)" data-limit="1" data-width="200" data-height="200" data-dom-id="upload-asa_avatar">修改</a>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">排序（整数，越大越靠前）</label>
            <div class="control-group">
                <input type="number" id="asa_sort" placeholder="排序" class="form-control"  value="<{if $row && $row['asa_sort']}><{$row['asa_sort']}><{else}>0<{/if}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">活动电话<font color="red">*</font></label>
            <div class="control-group">
                <input type="text" id="asa_mobile" placeholder="请填写活动电话" class="form-control"  value="<{$row['asa_mobile']}>"/>
            </div>
        </div>
        <div class="form-group">
            <label for="">是否首页展示</label>
            <div class="control-group">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="asa_index_show" id="indexShow1" value="1" <{if $row && $row['asa_index_show'] eq 1}>checked<{/if}>>
                        <label for="indexShow1">是</label>
                    </span>
                    <span>
                        <input type="radio" name="asa_index_show" id="indexShow2" value="0"  <{if !($row && $row['asa_index_show'] eq 1)}>checked<{/if}>>
                        <label for="indexShow2">否</label>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="">浏览量</label>
            <div class="control-group">
                <input type="number" id="asa_show_num" placeholder="请填写浏览量" class="form-control"  value="<{$row['asa_show_num']}>"/>
            </div>
        </div>
    </div>
</div>
<div class="alert alert-warning setting-save" role="alert" style="text-align: center;">
    <button class="btn btn-primary btn-sm btn-save">保存</button>
</div>

<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>

<script type="text/javascript" src="/public/plugin/datePicker/WdatePicker.js"></script>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript">
    $(function () {
        var date = new Date();
        var time1 = dateFormat("yyyy-MM-dd hh:mm:ss",date);
        $("#nowTime").val(time1);
    })

    function dateFormat(fmt,date)
    { //author: meizz
        var o = {
            "M+" : date.getMonth()+1,                 //月份
            "d+" : date.getDate(),                    //日
            "h+" : date.getHours(),                   //小时
            "m+" : date.getMinutes(),                 //分
            "s+" : date.getSeconds(),                 //秒
            "q+" : Math.floor((date.getMonth()+3)/3), //季度
            "S"  : date.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(fmt))
            fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
        for(var k in o)
            if(new RegExp("("+ k +")").test(fmt))
                fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));
        return fmt;
    }
    $('.btn-save').click(function(){
        var id = $('#hid_id').val();
        var title = $('#asa_title').val();
        var desc = $('#asa_desc').val();
        var start = $('#asa_start').val();
        var end = $('#asa_end').val();
        var receive_start = $('#asa_receive_start').val();
        var receive_end = $('#asa_receive_end').val();
        var avatar = $('#asa_avatar').val();
        var nickname = $('#asa_nickname').val();
        var mobile = $('#asa_mobile').val();
        var sort = $('#asa_sort').val();
        var show_num = $('#asa_show_num').val();
        var index_show = $("input[name='asa_index_show']:checked").val();

        var check   = new Array('asa_title','asa_nickname','asa_avatar','asa_mobile');
        for(var i=0 ; i < check.length ; i++){
            var temp = $('#'+check[i]).val();
            if(!temp){
                var msg = $('#'+check[i]).attr('placeholder');
                layer.msg(msg);
                return false;
            }
        }

        var imgArr = [];
        var index = 0;
        $('.img-p').each(function () {
            var info = {
              id : $(this).find('.img-id').val(),
              path :   $(this).find('.img-path').val(),
              index : index
            };
            imgArr.push(info);
            index++;
        });

        if(imgArr.length <= 0){
            layer.msg('请上传活动图片');
            return false;
        }

        var data = {
                id : id,
                title : title,
                desc : desc,
                start : start,
                end : end,
                receive_start : receive_start,
                receive_end : receive_end,
                avatar : avatar,
                nickname : nickname,
                mobile : mobile,
                sort : sort,
                index_show : index_show,
                imgArr : imgArr,
                show_num : show_num

            };

        var load_index = layer.load(
                2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
        );
        $('.btn-save').attr('disabled','true');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/activitySave',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(load_index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.href='/wxapp/sequence/activityList';
                }else{
                    $('.btn-save').removeAttr('disabled');
                }
            }
        });

    })



    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                var imgId = nowId.split('-');
                $('#'+nowId).attr('src',allSrc[0]);
                $('#'+nowId).val(allSrc[0]);
                $('#'+imgId[1]).val(allSrc[0]);
            }else{
                var img_html = '';
                var cur_num = $('#'+nowId+'-num').val();
                for(var i=0 ; i< allSrc.length ; i++){
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="img-p">';
                    img_html += '<img class="img-thumbnail col" layer-src="'+allSrc[i]+'"  layer-pid="" src="'+allSrc[i]+'" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_'+key+'" name="slide_'+key+'" value="'+allSrc[i]+'" class="img-path">';
                    img_html += '<input type="hidden" id="slide_id_'+key+'" name="slide_id_'+key+'" value="0" class="img-id">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num)+allSrc.length;
                if(now_num <= maxNum){
                    $('#'+nowId+'-num').val(now_num);
                    $('#'+nowId).append(img_html);
                }else{
                    layer.msg('幻灯图片最多'+maxNum+'张');
                }
            }
        }
    }

    /*初始化日期选择器*/
    // $('.time').click(function(){
    //     WdatePicker({
    //         dateFmt:'HH:mm',
    //         minDate:'00:00:00'
    //     })
    // })
</script>

<{$cropper['modal']}>
