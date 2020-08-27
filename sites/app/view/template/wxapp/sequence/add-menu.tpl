<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用"; }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
    input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
    input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
    input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
    input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }
    .payment-block .payment-block-body p { line-height: 24px; }
    .payment-block .payment-block-body dl { line-height: 24px; }
    .payment-block .payment-block-body dl dt { font-weight: bold; color: #333; line-height: 24px; }
    .payment-block .payment-block-body dl dd { margin-bottom: 20px; color: #666; line-height: 24px; }
    .payment-block .payment-block-body h4 { color: #333; font-size: 14px; margin-bottom: 20px; }
    .payment-block .payment-block-header .tips-txt { position: absolute; top: 10px; left: 115px; font-size: 13px; text-align: right; color: #999; height: 30px; line-height: 30px; }
    /* 保存按钮样式 */
    .alert.save-btn-box{
        border: 1px solid #F5F5AA;
        background-color: #FFFFCC;
        text-align: center;
        position: fixed;
        bottom: 0;
        left: 50%;
        margin-left: -453px;
        width: 870px;
        margin-bottom: 0;
        z-index: 200;
    }
    #container object{
        position:relative!important;
        height: 300px!important;
    }
    .switch-title{
        padding-left: 8px;
        font-weight: bold;
    }
    .input-tip{
        color: #999;
        padding-left: 5px;
    }
    .second-navmenu li > a{
        padding-left: 0 !important;
        text-align: center !important;
    }
    .watermrk-show{
        display: inline-block;
        vertical-align: middle;
        margin-left: 20px;
    }
    .watermrk-show .label-name,.watermrk-show .watermark-box{
        display: inline-block;
        vertical-align: middle;
    }
    .watermrk-show .watermark-box{
        width: 180px;
    }
    .link-box div{
        width: 50% ;
    }
    .business-time{
        width: 12% !important;
        display: inline-block;
    }

    .bg-box{
        display: inline-block;
        margin-right: 20px;
        /*box-sizing: border-box;*/
        cursor: pointer;
        position: relative;
    }
    .bg-box-selected{
        border: 3px solid red;
    }

    .all-template li{
        display: inline-block;
        margin-right: 15px;
        margin-bottom: 15px;
    }
    .all-template li .temp-img{
        width: 175px;
        height: 290px;
        border:1px solid #eee;
        overflow: hidden;
        position: relative;
    }
    .all-template li p{
        text-align: center;
        line-height: 2.5;
        font-size: 14px;
        margin: 0;
        font-weight: bold;
    }
    .all-template li.usingtem .temp-img:after {
        content: '';
        position: absolute;
        height: 100%;
        width: 100%;
        background: url(/public/manage/images/using.png) no-repeat;
        background-size: 25px;
        background-position: center;
        background-color: rgba(0,0,0,.5);
        z-index: 1;
        top: 0;
        left: 0;
    }
    .all-template li img{
        width: 100%;
        padding:5px;
    }
    .add-good-box .table span.del-good{
        color: #38f;
        font-weight: bold;
        cursor: pointer;
    }
    #slide-img p{
        height: 160px !important;
        width: 300px !important;
    }
    .img-thumbnail{
        height: 160px !important;
        width: 300px !important;
    }
    .img-p{
        margin-bottom: 9px !important;
    }

</style>
<div class="payment-style" >

    <div class="payment-block-body js-wxpay-body-region" style="display: block;">
        <input type="hidden" value="<{$row['asm_id']}>" id="hid_id">
        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">菜单类型</label>
            </div>
            <div class="form-group col-sm-10">
                <div class="radio-box">
                    <span>
                        <input type="radio" name="menu-type" id="menu-type-1" value="1" <{if $row['asm_type'] eq 1}>checked<{/if}>>
                        <label for="menu-type-1">图文</label>
                    </span>

                    <span>
                        <input type="radio" name="menu-type" id="menu-type-2" value="2" <{if $row['asm_type'] eq 2}>checked<{/if}>>
                        <label for="menu-type-2">视频</label>
                    </span>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">封面图 (建议尺寸640*640)</label>
            </div>
            <div class="form-group col-sm-10">
                <img onclick="toUpload(this)" data-limit="1" data-width="640" data-height="640" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row['asm_cover']}><{$row['asm_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_200_200.png<{/if}>" style="display:inline-block;margin-left:0;width: 20%;height: 20%">
                <input type="hidden" id="category-cover"  class="avatar-field bg-img" name="category-cover" value="<{$row['asm_cover']}>"/>
            </div>
        </div>

        <div class="row" style="display: none">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">幻灯图</label>
            </div>
            <div class="form-group col-sm-10 goods-box">
                <div>最多10张，建议尺寸750*400</div>
                <div id="slide-img" class="pic-box" style="display:inline-block;margin-top: 10px">
                    <{foreach $slide as $key=>$val}>
                    <p class="img-p">
                        <img class="img-thumbnail col" layer-src="<{$val}>"  layer-pid="" src="<{$val}>" >
                        <span class="delimg-btn">×</span>
                        <input type="hidden" id="slide_<{$key}>" name="slide_<{$key}>" value="<{$val}>">
                        <input type="hidden" id="slide_id_<{$key}>" name="slide_id_<{$key}>" value="<{$key}>">
                    </p>
                    <{/foreach}>
                </div>
                <span onclick="toUpload(this)" data-limit="10" data-width="750" data-height="400" data-dom-id="slide-img" class="btn btn-success btn-xs">添加图片</span>
                <input type="hidden" id="slide-img-num" name="slide-img-num" value="<{if $slide}><{count($slide)}><{else}>0<{/if}>" placeholder="控制图片张数">
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">标题</label>
            </div>
            <div class="form-group col-sm-5 goods-box">
                <input type="text" value="<{$row['asm_title']}>" class="form-control" id="menu_title">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">分类</label>
            </div>
            <div class="form-group col-sm-5 goods-box">
                <select name="menu_cate" id="menu_cate" class="form-control">
                    <{foreach $menuCate as $val}>
                    <option value="<{$val['id']}>" <{if $row['asm_category'] == $val['id']}> selected <{/if}>><{$val['title']}></option>
                    <{/foreach}>
                </select>
            </div>
        </div>


        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">添加菜单商品</label>
            </div>
            <div class="form-group col-sm-10 goods-box">
                <div class="add-good-box" style="width: 50%">
                    <div class="goodshow-list">
                        <table class="table">
                            <thead>
                            <tr>
                                <th class="left">商品名称</th>
                                <th class="right">操作</th>
                            </tr>
                            </thead>
                            <tbody id="can-used_goods">
                            <{foreach $goods_list as $val}>
                                <tr class="good-item">
                                    <td class="goods-info" data-id="<{$val['g_id']}>" data-gid="<{$val['g_id']}>" data-name="<{$val['g_name']}>"><p><{$val['g_name']}></p></td>
                                    <td class="right"><span class="del-good">删除</span></td>
                                </tr>
                                <{/foreach}>
                            </tbody>
                        </table>
                    </div>
                    <div class="btn btn-xs btn-primary confirm-add-good" data-toggle="modal" data-target="#goodsList" >+添加商品</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">排序</label>
            </div>
            <div class="form-group col-sm-3 goods-box">
                <input type="number" value="<{$row['asm_sort']}>" class="form-control" id="menu_sort" placeholder="越大越靠前">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">转发数</label>
            </div>
            <div class="form-group col-sm-3 goods-box">
                <input type="number" value="<{$row['asm_share_num']}>" class="form-control" id="share-num">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                <label for="range" style="font-size: 14px">点赞数</label>
            </div>
            <div class="form-group col-sm-3 goods-box">
                <input type="number" value="<{$row['asm_like_num']}>" class="form-control" id="like-num">
            </div>
        </div>

        <!-- 文本相关 -->
        <div class="menu-type-text" <{if $row['asm_type'] != 1}> style="display: none" <{/if}>>
            <div class="row">
                <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                    <label for="range" style="font-size: 14px">菜单内容</label>
                </div>
                <div class="form-group col-sm-5 goods-box">
                    <div class="form-textarea">
                        <textarea style="width:100%;height:350px;" id="article-detail" name="article-detail" placeholder="菜单内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['asm_text']}><{$row['asm_text']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-detail" />
                    </div>
                </div>
            </div>
        </div>

        <!-- 视频相关 -->
        <div class="menu-type-video" <{if $row['asm_type'] != 2}> style="display: none" <{/if}>>
            <div class="row">
                <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                    <label for="range" style="font-size: 14px">简介</label>
                </div>
                <div class="form-group col-sm-5 goods-box">
                    <input type="text" value="<{$row['asm_brief']}>" class="form-control" id="menu_brief">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-2 text-right" style="width: 135px;text-align: left;padding-left: 20px">
                    <label for="range" style="font-size: 14px">视频地址</label>
                </div>
                <div class="form-group col-sm-5 goods-box">
                    <input type="text" value="<{$row['asm_video']}>" class="form-control" id="menu_video">
                </div>
            </div>
        </div>
        <div style="height: 40px">

        </div>
    </div>
    <div class="form-group col-sm-12 alert alert-warning save-btn-box" style="text-align:center">
        <span type="button" class="btn btn-primary btn-sm btn-save"> 保 存 </span>
    </div>
</div>
<script src="/public/plugin/layer/layer.js"></script>
<{include file="../modal-gift-select.tpl"}>
<{include file="../img-upload-modal.tpl"}>
<{include file="../article-ue-editor.tpl"}>
<script>
    $(function () {
        $(".add-good-box").on('click', '.del-good', function(event) {
            var trElem = $(this).parents('tr.good-item');
            var goodListElem = $(this).parents('.goodshow-list');
            var length = parseInt($(this).parents('.table').find('tbody tr').length);
            trElem.remove();
        });

        $('input[name="menu-type"]').change(function () {
            if(this.value == 2){
                $('.menu-type-text').css('display','none');
                $('.menu-type-video').css('display','block');
            }else{
                $('.menu-type-video').css('display','none');
                $('.menu-type-text').css('display','block');
            }
        });

        $('.confirm-add-good').click(function () {
            confirmAddgood();
        });
    });

    $('.all-template li').click(function () {
        $('.all-template li').removeClass('usingtem');
        $(this).addClass('usingtem');
    });

    $('.btn-save').on('click',function(){
        var id = $('#hid_id').val();
        var content = weddingTaocanDetailArray[0];
        var menuType = $('input[name="menu-type"]:checked').val();
        var cover = $('#category-cover').val();
        var shareNum = $('#share-num').val();
        var likeNum = $('#like-num').val();
        var brief = $('#menu_brief').val();
        var video = $('#menu_video').val();
        var title = $('#menu_title').val();
        var cate = $('#menu_cate').val();
        var sort = $('#menu_sort').val();
        var data = {
            'id'       : id,
            'menuType' : menuType,
            'content'  : content,
            'cover'    : cover,
            'shareNum' : shareNum,
            'likeNum'  : likeNum,
            'brief'    : brief,
            'video'    : video,
            'category' : cate,
            'title'    : title,
            'sort'     : sort
        };
        var goods = [],g = 0;
        $('#can-used_goods').find('.good-item').each(function(){
            var gid = $(this).find('.goods-info').data('gid');
            if(gid){
                var goods_row = {
                    'id' 	: $(this).find('.goods-info').data('id'),
                    'gid'	: gid,
                    'name'	: $(this).find('.goods-info').data('name')
                };
                goods.push(goods_row);
                g++;
            }
        });

        if(goods.length > 20){
            layer.msg('最多添加20件商品.');
            return;
        }
        data.goods = goods;

        var imgArr = [];
        $('#slide-img').find("img").each(function () {
            var _this = $(this);
            imgArr.push(_this.attr('src'))
        });
        data.imgArr = imgArr;


        layer.confirm('确定要保存吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'   : 'post',
                'url'   : '/wxapp/sequence/saveMenu',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        });

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
                    $('#category-cover').val(allSrc[0]);
                }
                if(nowId == 'brief-img'){
                    $('#brief-cover').val(allSrc[0]);
                }
            }else{
                var img_html = '';
                var cur_num = $('#' + nowId + '-num').val();
                for (var i = 0; i < allSrc.length; i++) {
                    var key = i + parseInt(cur_num);
                    img_html += '<p class="img-p">';
                    img_html += '<img class="img-thumbnail col" layer-src="' + allSrc[i] + '"  layer-pid="" src="' + allSrc[i] + '" >';
                    img_html += '<span class="delimg-btn">×</span>';
                    img_html += '<input type="hidden" id="slide_' + key + '" name="slide_' + key + '" value="' + allSrc[i] + '">';
                    img_html += '<input type="hidden" id="slide_id_' + key + '" name="slide_id_' + key + '" value="0">';
                    img_html += '</p>';
                }
                var now_num = parseInt(cur_num) + allSrc.length;
                if (now_num <= maxNum) {
                    $('#' + nowId + '-num').val(now_num);
                    $('#' + nowId).append(img_html);
                } else {
                    layer.msg('轮播图最多' + maxNum + '张');
                }
            }
        }
    }

</script>
