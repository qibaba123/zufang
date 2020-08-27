<link rel="stylesheet" href="/public/manage/css/wechatArticle.css">
<style>
    .topic>div.part{
        display: inline-block;
        width: 50%;
        float: left;
    }
</style>
<{if $curr_shop['s_id'] == 11}>
    <{include file="../article-ue-editor.tpl"}>
<{else}>
    <{include file="../../manage/article-kind-editor.tpl"}>
<{/if}>
<div class="preview-page">
    <div class="mobile-page">
        <div class="mobile-header"></div>
        <div class="mobile-con">
            <div class="title-bar">
                <{$headTitle}>
            </div>
            <div class="article">
                <h4 class="article-title" id="article-title"><{if $row && $row['aa_title']}><{$row['aa_title']}><{else}>这里是文章标题<{/if}>！</h4>
                <div class="date"><{$now}> <span class="link-name"><{$shop['s_name']}></span></div>
                <div class="article-con" id="article-con">
                    <{if $row && $row['aa_content']}>
                        <!-- <{$row['aa_content']}> -->
                    <{else}>
                    <p>这里将会显示文章内容</p>
                    <{/if}>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>
    <div class="edit-right">
        <div class="edit-con">
            <div><{$cropper['modal']}></div>
            <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['aa_id']}><{$row['aa_id']}><{/if}>"/>
            <div class="topic">
                <label for="">文章标题<font color="red">*</font></label>
                <input type="text" id="aa_title" value="<{if $row && $row['aa_title']}><{$row['aa_title']}><{/if}>" placeholder="这里添加文章标题" oninput="previewTitle(this)" onpropertychange="previewTitle(this)">
            </div>
            <div class="topic" style="overflow:hidden">
                <{if $type eq 1}>
                <div class="part">
                    <label for="">封面图片<font color="red">*</font></label>
                    <!--<div class="cropper-box" data-width="750" data-height="320" >
                        <img <{if $row && $row['aa_cover']}>src=<{$row['aa_cover']}><{else}>src="/public/wxapp/wedding/images/active_zw_750_320.png"<{/if}>  width="75%" style="display:inline-block;">
                        <input type="hidden" id="aa_cover"  class="avatar-field bg-img" name="img" value="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{/if}>"/>
                    </div>-->
                    <div>
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="320" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="aa_cover"  class="avatar-field bg-img" name="aa_cover" value="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{/if}>"/>
                    </div>
                </div>
                <div class="part">
                    <label for="">文章简介<font color="red">*</font></label>
                    <textarea id="aa_brief" class="form-control" rows="6" placeholder="文章简介" style="height:auto!important"><{if $row && $row['aa_brief']}><{$row['aa_brief']}><{/if}></textarea>
                </div>
                <{else}>
                <div class="part">
                    <label for="">封面图片<font color="red">*</font></label>
                    <!--<div class="cropper-box" data-width="750" data-height="520" >
                        <img <{if $row && $row['aa_cover']}>src=<{$row['aa_cover']}><{else}>src="/public/wxapp/card/temp1/images/zhanwei_750_520.jpg"<{/if}>  width="75%" style="display:inline-block;">
                        <input type="hidden" id="aa_cover"  class="avatar-field bg-img" name="img" value="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{/if}>"/>
                    </div>-->
                    <div>
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="520" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="aa_cover"  class="avatar-field bg-img" name="aa_cover" value="<{if $row && $row['aa_cover']}><{$row['aa_cover']}><{/if}>"/>
                    </div>
                </div>
                <div class="part">
                    <label for="">文章简介<font color="red">*</font></label>
                    <textarea id="aa_brief" class="form-control" rows="4" placeholder="文章简介" style="height:auto!important"><{if $row && $row['aa_brief']}><{$row['aa_brief']}><{/if}></textarea>
                </div>
                <{/if}>
            </div>
            <div class="contxt">
                <label for="">文章内容<font color="red">*</font></label>
                <div>
                    <div class="form-textarea">
                        <textarea class="form-control" style="width:100%;height:350px;visibility:hidden;" id="article-detail" name="article-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['aa_content']}><{$row['aa_content']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-detail" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert">
        <button class="btn btn-primary btn-sm btn-save">保存</button>
    </div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    /*标题实时预览*/
    function previewTitle(elem){
        var val = $(elem).val();
        $("#article-title").text(val);
    }

    $('.btn-save').on('click',function(){
        var content = $('#article-detail').val();
        var title = $('#aa_title').val();
        var cover = $('#aa_cover').val();
        var brief = $('#aa_brief').val();
        var id    = '<{$row['aa_id']}>';

        var data = {
            'id'      : id,
            'title'   : title,
            'cover'   : cover,
            'brief'   : brief,
            'content' : content
        };

        if(title && content && cover){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/currency/saveArticle',
                'data'	: data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.href='/wxapp/currency/articleList';
                    }
                }
            });
        }else{
            layer.msg('请填写完整数据');
        }
    });


    /*是否开启店铺导航*/
    function storeOnoff(elem){
        if($(elem).is(':checked')){
            $("#store-nav").stop().show();
        }else{
            $("#store-nav").stop().hide();
        }
    }
    /**/
    $("#link-type").on('click', 'input[type=radio]', function(event) {
        var timer;
        clearTimeout(timer);
        $(".link-name").css("color","red");
        timer = setTimeout(function(){
            $(".link-name").css("color","#607fa6");
        },2000)
    });

    /**
     * 图片结果处理
     * @param allSrc
     */
    function deal_select_img(allSrc){
        if(allSrc){
            if(maxNum == 1){
                $('#'+nowId).attr('src',allSrc[0]);
                if(nowId == 'upload-cover'){
                    $('#aa_cover').val(allSrc[0]);
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
</script>