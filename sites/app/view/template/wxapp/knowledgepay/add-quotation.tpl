<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/plugin/sortable/jquery-ui.min.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/addgoods.css">
<link rel="stylesheet" href="/public/manage/assets/css/chosen.css" />
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-select.css">
<style type="text/css">

    .input-group-addon{
        padding: 6px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "是\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0否";
    }

    .select-member .form-group{
        margin-bottom: 5px !important;
    }

    .mem-list{
        z-index: 999 !important;
    }

</style>
<{include file="../../manage/common-kind-editor.tpl"}>
<!-- include file="../layer/ajax-select-input-single.tpl"-->

<div ng-app="ShopIndex"  ng-controller="ShopInfoController">
    <div class="row">
        <div class="col-xs-12">
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget-box">
                        <div class="widget-header widget-header-blue widget-header-flat">
                            <h4 class="lighter"><small><a href="javascript:;"> 返回 </a></small> | 发布/编辑</h4>
                            <div class="col-xs-1 pull-right search-btn">

                            </div>
                        </div>

                        <div class="widget-body" >
                            <div class="widget-main">
                                <div class="step-content row-fluid position-relative" id="step-container">
                                    <form class="form-horizontal" id="goods-form"   enctype="multipart/form-data" style="overflow: hidden;">
                                        <input type="hidden" id="hid_id" name="id" value="<{if $row}><{$row['kcq_id']}><{else}>0<{/if}>">
                                        <div class="step-pane" style="display: block" id="step1">
                                            <div class="info-group-box">
                                                <div class="info-group-inner">
                                                    <div class="group-title">
                                                        <span>语录信息</span>
                                                    </div>
                                                    <div class="group-info">
                                                        <!--
                                                        <div class="form-group">
                                                            <label for="name" class="control-label"><font color="red"></font>帖子分类：</label>
                                                            <div class="form-group col-sm-4">
                                                                <select class="form-control" id="firstClass" name="firstClass" onchange="changeFirstClass()">
                                                                    <option value="">选择分类</option>
                                                                    <{foreach $shortcut as $val}>
                                                                    <{if $val['acc_service_type'] == 1}>
                                                                    <option value="<{$val['acc_id']}>" <{if $row['kcq_acc_id'] == $val['acc_id']}>selected<{/if}>><{$val['acc_title']}></option>
                                                                    <{/if}>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-sm-5">
                                                                <select class="form-control" id="secondClass" name="secondClass" onchange="changeSecondClass()">
                                                                    <option value="">选择二级分类</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        -->
                                                        <{if !$row}>
                                                        <div class="form-group">
                                                            <label class="control-label">发布会员：</label>
                                                            <div class="form-group col-sm-4" >
                                                                <select class="form-control" id="mid" name="mid">
                                                                    <{foreach $memberList as $val}>
                                                                    <option value="<{$val['m_id']}>"><{$val['m_nickname']}></option>
                                                                    <{/foreach}>
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-sm-4" style="margin-top:5px;">
                                                            <span style="color: red;font-size: 14px;">（注：需要先到会员管理的会员列表点击新增添加会员）</span>
                                                            </div>
                                                        </div>
                                                        <{/if}>
                                                        <div class="form-group">
                                                            <label class="control-label">经典语录内容：</label>
                                                            <div class="control-group">
                                                                <textarea type="text" class="form-control" rows="5" maxlength="5000" id="kcq_content" name="content" placeholder="经典语录内容" style="max-width: 850px;"><{if $row}><{$row['kcq_content']}><{/if}></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group" id="video-info" style="display: none">
                                                            <label for="name" class="control-label"><font color="red"></font>视频链接：</label>
                                                            <div class="control-group">
                                                                <input type="text" class="form-control" id="kcq_video_url" name="video" placeholder="请填写链接地址"  value="<{if $row}><{$row['kcq_video_url']}><{/if}>">
                                                            </div>
                                                            <div style="margin-left: 150px;color: #aaa">注：仅支持腾讯视频链接，或填写视频源链接</div>
                                                        </div>
                                                        <div class="form-group"  id="image-info" >
                                                            <label for="name" class="control-label"><font color="red"></font>图片(最多6张)：</label>
                                                            <div id="slide-img" class="pic-box" style="display:inline-block">
                                                                <{foreach $imgs as $key=>$val}>
                                                                <p style="display: inline-block;margin-right: 3px">
                                                                    <img class="img-thumbnail col" layer-src="<{$val}>"  layer-pid="" src="<{$val}>" >
                                                                    <span class="delimg-btn">×</span>
                                                                    <input type="hidden" id="slide_<{$key}>" name="slide_img" value="<{$val}>">
                                                                    <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$key}>">
                                                                </p>
                                                                <{/foreach}>
                                                            </div>
                                                            <!--
                                                            <span onclick="toUpload(this)" data-limit="9" data-width="540" data-height="960" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $imgs}><{count($imgs)}><{else}>0<{/if}>" placeholder="控制图片张数">
                                                            -->
                                                            <span class="btn btn-success btn-xs" data-click-upload data-type="key">添加图片</span>
                                                            <input type="hidden" name="sslkey" id="sslkey" data-msg="填上传秘钥路径" value="<{if $appletPay}><{$appletPay['ap_sslkey']}><{/if}>">
                                                            <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $imgs}><{count($imgs)}><{else}>0<{/if}>" placeholder="控制图片张数">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <hr />
                                <div class="row-fluid wizard-actions" style="text-align: center">
                                    <button class="btn btn-primary" onclick="saveData();">
                                        保存
                                    </button>
                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
</div><!-- PAGE CONTENT ENDS -->
<div id="zhengshu" style="display: none;padding:5px 20px;">
    <div class="upload-tips">
        <form action="/wxapp/knowledgepay/coverUpload" enctype="multipart/form-data" method="post">
            <label style="height:35px;line-height: 35px;">本地上传</label>
            <span class="upload-input">选择文件<input class="avatar-input" id="avatarInput" onchange="selectedFile(this)" name="img_cover" type="file"></span>
            <p style="height:35px;line-height: 35px;"><i class="icon-warning-sign red bigger-100"></i>请上传图片类型的文件</p>
            <div style="font-size: 14px;padding-left: 29px;margin-top: 10px;display: none" >注意　<span id="show-notice">apiclient_cert.pem为支付证书文件，apiclient_key.pem为支付密钥证书文件</span></div>
        </form>
    </div>
</div>
<style>
    .layui-layer-btn { border-top: 1px solid #eee; }
    .upload-tips {		/* overflow: hidden; */ }
    .upload-tips label { display: inline-block; width: 70px; }
    .upload-tips p { display: inline-block; font-size: 13px; margin: 0; color: #666; margin-left: 10px; }
    .upload-tips .upload-input { display: inline-block; text-align: center; height: 35px; line-height: 35px; background-color: #1276D8; color: #fff; width: 90px; position: relative; cursor: pointer; }
    .upload-tips .upload-input>input { display: block; height: 35px; width: 90px; opacity: 0; margin: 0; position: absolute; top: 0; left: 0; z-index: 2; cursor: pointer; }
</style>
<script src="/public/plugin/layer/layer.js"></script>
<script>
    var slide_key = 0;
    var slide_key = 0;
    $('[data-click-upload]').on('click', function(){
        var type    = $(this).data('type');
        var msg     = $(this).data('msg');
        $('#show-notice').html(msg);
        var htmlTxt=$("#zhengshu");
        var that    = this;
        if(slide_key>6){
            layer.msg('最多上传6张');
        }
        //页面层
        var layIndex = layer.open({
            type: 1,
            title: '证书路径',
            shadeClose: true, //点击遮罩关闭
            shade: 0.6, //遮罩透明度
            skin: 'layui-anim',
            area: ['500px', '200px'], //宽高
            btn : ['保存', '取消'],//按钮1、按钮2的回调分别是yes/cancel
            content: htmlTxt,
            yes : function() {
                var loading = layer.load(2);
                var $form = htmlTxt.find('form');
                var url = $form.attr("action"),
                    data = new FormData($form[0]);
                $.ajax(url, {
                    type: "post",
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function (data) {
                        if (data.ec == 200) {
                            slide_key++;
                            console.log(data.data.path);
                            $(that).next('input').val(data.data.path);
                            var img_html = '';
                            img_html += '<p style="display: inline-block">';
                            img_html += '<img class="img-thumbnail col" layer-src="'+data.data.path+'"  layer-pid="" src="'+data.data.path+'" >';
                            img_html += '<span class="delimg-btn" style="margin-right: 3px">×</span>';
                            img_html += '<input type="hidden" id="slide_'+slide_key+'" name="slide_img" value="'+data.data.path+'">';
                            img_html += '<input type="hidden" id="slide_id_'+slide_key+'" name="slide_id_'+slide_key+'" value="0">';
                            img_html += '</p>';
                            $('#slide-img').prepend(img_html);
                        } else {
                            layer.alert('上传失败，请重试');
                        }
                    },
                    complete: function () {
                        layer.close(loading);
                        layer.close(layIndex);
                    }
                });
            }
        });
    });

    //选择文件
    function selectedFile(obj){
        var path = $(obj).val();
        $(obj).parents('form').find('p').text(path);
    }

    $(".pic-box").on('click', '.delimg-btn', function(event) {
       // var id = $(this).parent().parent().attr('id');
        event.preventDefault();
        event.stopPropagation();
        var delElem = $(this).parent();
        layer.confirm('确定要删除吗？', {
            title:false,
            closeBtn:0,
            btn: ['确定','取消'] //按钮
        }, function(){
            delElem.remove();
            slide_key--;
            layer.msg('删除成功');
        });
    });

    function saveData() {
        var mid = $('#mid').val();
        var content = $('#kcq_content').val();
        var slide = [];
        var id = $('#hid_id').val();
        $("input[name='slide_img']").each(function(){
            slide.push($(this).val());
        });
        var data = {
            id      : id,
            mid     : mid,
            content : content,
            slide   : slide
        };
        console.log(data);
        var load_index = layer.load(2, {
                shade: [0.1,'#333'],
                time: 10*1000
            }
        );
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/saveClassicalQuotation',
            'data'  :  data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.close(load_index);
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    window.location.href="/wxapp/knowledgepay/quotationList";
                }else{
                    layer.msg(ret.em);
                }
            }
        });

    }

</script>

