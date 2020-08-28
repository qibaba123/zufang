<link rel="stylesheet" href="/public/manage/css/wechatArticle.css">
<link rel="stylesheet" href="/public/manage/ajax-page.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    .topic>div.part{
        display: inline-block;
        width: 50%;
        float: left;
    }
    .goods-button{
        padding: 3px 6px !important;
        font-weight: bold;
    }
    .table.table-button tbody>tr>td{
        line-height: 33px;
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
    .goods-selected{
        padding: 1px 2px;
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
    .add-related-box{
        text-align: center;
    }
    .related-info{
        margin-bottom: 10px;
        height: 35px;
        line-height: 35px;
    }
    .btn-remove-info{

    }
    .related-info-cate{
        width: 35%;
        float: left;
        margin-right: 10px;
    }
    .related-info-detail{
        width: 49%;
        float: left;
        margin-right: 20px;
    }

    #edui1_imagescale{
        display:none !important;
    }

    #edui140_content{
        display:none !important;
    }

    .setting-save {
        z-index: 1088;
    }
    .recommentGoods, .recommentAppointmentGoods{
        background: #fff;
        padding: 10px;
        border-radius: 4px;
    }

</style>
<{include file="../article-ue-editor.tpl"}>

<!--关联商品modal-->
<div id="goods-modal"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">推荐商品</h4>
                </div>
                <div class="modal-body">
                    <div class="good-search" style="margin-top: 20px">
                        <input type="hidden" id="search-type" value="information">
                        <div class="input-group">
                            <input type="text" id="keyword" class="form-control" placeholder="搜索商品">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-blue btn-md" onclick="fetchGoodsPageData(1)">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                       </span>
                        </div>
                    </div>
                    <{if $appletCfg['ac_type'] == 6}>
                    <div class="topic typeselect" >
                        <div class="radio-box" style="text-align: center;padding-top: 5px">
                     <span data-val="0">
                         <input type="radio" name="goodsType" checked="checked" onclick="changeGoodsType('shop')" value="0" id="goodsType0">
                         <label for="goodsType0">自营商品</label>
                     </span>
                            <span data-val="1">
                        <input type="radio" name="goodsType" onclick="changeGoodsType('entershop')" value="1" id="goodsType1">
                        <label for="goodsType1">入驻店铺商品</label>
                    </span>
                        </div>
                    </div>
                    <{/if}>
                    <hr>
                    <table  class="table-responsive">
                        <input type="hidden" id="mkType" value="">
                        <input type="hidden" id="currId" value="">
                        <input type="hidden" id="goodsType" value="">
                        <thead>
                        <tr>
                            <th>商品图片</th>
                            <th style="text-align:left">商品名称</th>
                            <th>操作</th>
                        </thead>

                        <tbody id="goods-tr">
                            <!--商品列表展示-->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer ajax-pages" id="footer-page">
                    <!--存放分页数据-->
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

<div class="preview-page">
    <div class="mobile-page">
        <div class="mobile-header">

        </div>
        <div class="mobile-con">
            <div class="title-bar">
                <{$headTitle}>
            </div>
            <div class="article">
                <h4 class="article-title" id="article-title"><{if $row && $row['ai_title']}><{$row['ai_title']}><{else}>这里是资讯标题<{/if}>！</h4>
                <div class="date"><{$now}> <span class="link-name"><{$shop['s_name']}></span></div>
                <div class="article-con" id="article-con">
                    <{if $row && $row['ai_content']}>
                    <!-- <{$row['ai_content']}> -->
                    <{else}>
                    <p>这里将会显示资讯内容</p>
                    <{/if}>
                </div>
            </div>
        </div>
        <div class="mobile-footer"><span></span></div>
    </div>

    <div class="edit-right">
        <div class="edit-con">
            <div><{$cropper['modal']}></div>
            <input type="hidden" id="hid_id"  class="avatar-field bg-img" name="hid_key" value="<{if $row && $row['ai_id']}><{$row['ai_id']}><{/if}>"/>
            <div class="topic">
                <label for="">文章标题<font color="red">*</font></label>
                <input type="text" id="title" value="<{if $row && $row['ai_title']}><{$row['ai_title']}><{/if}>" placeholder="这里添加文章标题" oninput="previewTitle(this)" onpropertychange="previewTitle(this)">
            </div>
            <div class="topic" style="overflow:hidden">
                <div class="part">
                    <label for="">封面图片<font color="red">*（750*420）</font></label>
                    <!--<div class="cropper-box" data-width="750" data-height="420" >
                        <img <{if $row && $row['ai_cover']}>src=<{$row['ai_cover']}><{else}>src="/public/wxapp/card/temp1/images/zhanwei_750_520.jpg"<{/if}>  width="75%" style="display:inline-block;">
                        <input type="hidden" id="cover"  class="avatar-field bg-img" name="img" value="<{if $row && $row['ai_cover']}><{$row['ai_cover']}><{/if}>"/>
                    </div>-->
                    <div>
                        <img onclick="toUpload(this)" data-limit="1" data-width="750" data-height="420" data-dom-id="upload-cover" id="upload-cover"  src="<{if $row && $row['ai_cover']}><{$row['ai_cover']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>"  width="75%" style="display:inline-block;margin-left:0;">
                        <input type="hidden" id="cover"  class="avatar-field bg-img" name="cover" value="<{if $row && $row['ai_cover']}><{$row['ai_cover']}><{/if}>"/>
                    </div>
                </div>
                <div class="part">
                    <label for="">文章简介<font color="red">*</font></label>
                    <textarea id="brief" class="form-control" rows="6" placeholder="文章简介" style="height:auto!important"><{if $row && $row['ai_brief']}><{$row['ai_brief']}><{/if}></textarea>
                </div>
            </div>
            <div class="part" style="overflow: hidden">
                <div style="width: 49%;float: left;">
                    <label for="">资讯类别</label>
                    <label id="default-onoff">
                        <select id="category-name" style="height: 35px;" class="form-control">
                            <option value="0">无分类</option>
                            <{if $category_select}>
                            <{foreach $category_select as $key=>$val}>
                        <option value="<{$key}>" <{if $row && $row['ai_category'] eq $key}>selected="selected"<{/if}> ><{$val}></option>
                            <{/foreach}>
                            <{/if}>
                        </select>
                    </label>
                </div>
                <div style="width: 49%;float: right;">
                    <label for="">排序权重</label>
                    <input class="form-control" type="number" id="sort" value="<{if $row && $row['ai_sort']}><{$row['ai_sort']}><{/if}>" placeholder="排序权重">
                </div>
            </div>
           <!-- <div class="part" style="overflow: hidden">
                <div style="width: 49%;float: left;">
                    <label for="">是否推荐</label>
                    <label id="default-onoff">
                        <select id="isRecommend" style="height: 35px;" class="form-control">
                            <option value="0">不推荐</option>
                            <option value="1" <{if ($row && $row['ai_isrecommend'] eq 1) || !$row }>selected="selected"<{/if}> >推荐</option>
                        </select>
                    </label>
                </div>
                <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $appletCfg['ac_type'] != 33 && $appletCfg['ac_type'] != 34}>
                <div style="width: 49%;float: right;">
                    <label for="">付费价格</label>
                    <input class="form-control" type="number" id="price" value="<{if $row && $row['ai_price']}><{$row['ai_price']}><{/if}>" placeholder="付费价格">
                </div>
                <{/if}>
            </div>-->
            <div class="part" style="overflow: hidden">
                <div style="width: 49%;float: left;">
                    <label for="">阅读量</label>
                    <input class="form-control" type="number" id="showNum" value="<{if $row}><{$row['ai_show_num']}><{else}>0<{/if}>" placeholder="阅读量">
                </div>
                <div style="width: 49%;float: right;">
                    <label for="">时间</label>
                    <input class="form-control" type="text" id="customTime" value="<{if $row && $row['ai_create_time']}><{date('Y-m-d H:i:s',$row['ai_create_time'])}><{else}><{date('Y-m-d H:i:s',time())}><{/if}>" onclick="chooseDate()" placeholder="资讯时间">
                </div>
                <!--<div style="width: 49%;float: right;">
                    <label for="">点赞量</label>
                    <input class="form-control" type="number" id="likeNum" value="<{if $row}><{$row['ai_like_num']}><{else}>0<{/if}>" placeholder="点赞量">
                </div>-->
            </div>
           <!-- <div class="part" style="overflow: hidden">
                <div style="width: 49%;float: left;">
                    <label for="">文章来源</label>
                    <input class="form-control" type="text" id="articleFrom" value="<{if $row}><{$row['ai_from']}><{/if}>" placeholder="文章来源">
                </div>
                <div style="width: 49%;float: right;">
                    <label for="">时间</label>
                    <input class="form-control" type="text" id="customTime" value="<{if $row && $row['ai_create_time']}><{date('Y-m-d H:i:s',$row['ai_create_time'])}><{else}><{date('Y-m-d H:i:s',time())}><{/if}>" onclick="chooseDate()" placeholder="资讯时间">
                </div>
                <div style="font-size: 12px;color: #999;margin-top: 2px;">
                    新增文章时，不填则默认为保存时间；修改文章时，不填为不修改时间
                </div>
            </div>-->

            <input type="hidden" name="allow_like" value="1">
           <!-- <{if $chooseGoods == 1}>
                <{if $appletCfg['ac_type'] != 27}>
                <div class="recommentGoods">
                    <div class="topic">
                        <label for="">推荐商品样式</label>
                        <div class="radio-box">
                             <span data-val="0">
                                 <input type="radio" name="goodsType" <{if ($row && $row['ai_goods_type'] eq 1) || !$row}>checked<{/if}> value="1" id="goodsType0" >
                                 <label for="goodsType0">滑动</label>
                             </span>
                            <span data-val="1">
                                <input type="radio" name="goodsType" <{if $row && $row['ai_goods_type'] eq 2}>checked<{/if}> value="2" id="goodsType1">
                                <label for="goodsType1">列表</label>
                            </span>
                        </div>
                    </div>
                    <div class="part" style="overflow: hidden">
                        <div style="width: 78%;float: left;">
                            <label for="">推荐商品</label>
                        </div>
                        <div style="width: 20%;float: right;">
                            <label for=""><span>
                                <button class="btn btn-sm btn-primary goods-button btn-goods">添加</button>
                                <button class="btn btn-sm btn-danger goods-button btn-remove-all">清空</button>
                            </span></label>

                        </div>
                    </div>
                    <div class="topic goods-selected-list">
                        <{if $goodsList}>
                            <{foreach $goodsList as $goods}>
                            <div class='goods-name goods-selected' gid='<{$goods['g_id']}>' ><div class='goods-selected-name'><{$goods['g_name']}></div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>
                            <{/foreach}>
                            <{else}>
                            <span class="goods-name goods-none" style="font-weight: bold;color: #38f">
                                无推荐商品
                            </span>
                            <{/if}>
                    </div>
                </div>
                <{/if}>
                <{if $appletCfg['ac_type'] != 32 && $appletCfg['ac_type'] != 36}>
                <div class="recommentAppointmentGoods">
                    <div class="topic">
                        <label for="">推荐付费预约商品样式</label>
                        <div class="radio-box">
                             <span data-val="0">
                                 <input type="radio" name="appointmentGoodsType" <{if ($row && $row['ai_appointment_goods_type'] eq 1) || !$row}>checked<{/if}> value="1" id="appointmentGoodsType0" >
                                 <label for="appointmentGoodsType0">滑动</label>
                             </span>
                            <span data-val="1">
                                <input type="radio" name="appointmentGoodsType" <{if $row && $row['ai_appointment_goods_type'] eq 2}>checked<{/if}> value="2" id="appointmentGoodsType1">
                                <label for="appointmentGoodsType1">列表</label>
                            </span>
                        </div>
                    </div>
                    <div class="part" style="overflow: hidden">
                        <div style="width: 78%;float: left;">
                            <label for="">推荐付费预约商品</label>
                        </div>
                        <div style="width: 20%;float: right;">
                            <label for=""><span>
                                <button class="btn btn-sm btn-primary goods-button btn-appointment-goods">添加</button>
                                <button class="btn btn-sm btn-danger goods-button btn-appointment-remove-all">清空</button>
                            </span></label>

                        </div>
                    </div>
                    <div class="topic appointment-goods-selected-list">
                        <{if $appointmentGoodsList}>
                        <{foreach $appointmentGoodsList as $goods}>
                        <div class='goods-name appointment-goods-selected' gid='<{$goods['g_id']}>' ><div class='goods-selected-name'><{$goods['g_name']}></div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>
                        <{/foreach}>
                        <{else}>
                        <span class="goods-name appointment-goods-none" style="font-weight: bold;color: #38f">
                            无推荐付费预约商品
                        </span>
                        <{/if}>
                    </div>
                </div>
                <{/if}>
            <{/if}>
            <div class="topic">
                <label for="">链接类型</label>
                <div class="radio-box">
                     <span data-val="0">
                         <input type="radio" name="type" <{if ($row && $row['ai_video_type'] eq 1) || !$row}>checked<{/if}> value="1" id="type0" >
                         <label for="type0">视频</label>
                     </span>
                    <span data-val="1">
                        <input type="radio" name="type" <{if $row && $row['ai_video_type'] eq 2}>checked<{/if}> value="2" id="type1">
                        <label for="type1">音频</label>
                    </span>
                    <span >
                        <label onclick="videoShow(this)"style="background-color: #42ca7d;padding: 0 10px;color: #fff;border-radius: 4px;height: 25px;line-height: 25px;cursor: pointer;margin-left: 30px;">音频/视频预览</label>
                    </span>
                </div>
            </div>
            <div class="topic">
                <label for="">视频/音频链接</label>
                <textarea class="form-control" rows="3" id="video" placeholder="视频/音频链接"><{if $row && $row['ai_video']}><{$row['ai_video']}><{/if}></textarea>
                <div style="font-size: 12px;color: #999;margin-top: 2px;">
                    仅支持腾讯视频链接，或填写视频的源链接。
                    <a href="https://bbs.tiandiantong.net/forum.php?mod=viewthread&tid=347&extra=" style="color: red;" target="_blank">音视频上传教程可点此查看</a>
                </div>
            </div>
            <{if $showAllow == 1}>
            <div class="topic">
                <label for="">是否允许评论、点赞</label>
                <div class="radio-box">
                     <span data-val="0">
                         <input type="radio" name="allow_comment" <{if ($extra && $extra['aie_allow_comment'] eq 1) || !$extra}>checked<{/if}> value="1" id="allow_comment_1" >
                         <label for="allow_comment_1">允许</label>
                     </span>
                    <span data-val="1">
                        <input type="radio" name="allow_comment" <{if $extra && $extra['aie_allow_comment'] eq 0}>checked<{/if}> value="0" id="allow_comment_0">
                        <label for="allow_comment_0">不允许</label>
                    </span>
                </div>
            </div>-->
            <!--
            <div class="topic" style="">
                <label for="">是否允许点赞</label>
                <div class="radio-box">
                     <span data-val="0">
                         <input type="radio" name="allow_like" <{if ($extra && $extra['aie_allow_like'] eq 1) || !$extra}>checked<{/if}> value="1" id="allow_like_1" >
                         <label for="allow_like_1">允许</label>
                     </span>
                    <span data-val="1">
                        <input type="radio" name="allow_like" <{if $extra && $extra['aie_allow_like'] eq 0}>checked<{/if}> value="0" id="allow_like_0">
                        <label for="allow_like_0">不允许</label>
                    </span>
                </div>
            </div>
            -->
            <{/if}>
          <!--  <{if $appletCfg['ac_type'] eq 18}>
            <div class="topic">
                <label for="">详情内容显示类型</label>
                <div class="radio-box">
                     <span data-val="0">
                         <input type="radio" name="displayType" <{if ($row && $row['ai_display_type'] eq 1) || !$row}>checked<{/if}> value="1" id="displayType1" >
                         <label for="displayType1">富文本</label>
                     </span>
                    <span data-val="1">
                        <input type="radio" name="displayType" <{if $row && $row['ai_display_type'] eq 2}>checked<{/if}> value="2" id="displayType2">
                        <label for="displayType2">相册</label>
                    </span>
                    <span >
                        （富文本展示详情可以上传图文，相册展示详情只能上传图片）
                    </span>
                </div>
            </div>
            <{/if}>-->
            <div class="contxt">
                <label for="">文章内容<font color="red">*</font></label>
                <div>
                    <div class="form-textarea">
                        <textarea style="width:100%;height:350px;" id="article-detail" name="article-detail" placeholder="文章内容"  rows="20" style=" text-align: left; resize:vertical;" ><{if $row && $row['ai_content']}><{$row['ai_content']}><{/if}></textarea>
                        <input type="hidden" name="sub_dir" id="sub-dir" value="default" />
                        <input type="hidden" name="ke_textarea_name" value="article-detail" />
                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="alert alert-warning setting-save" role="alert">
        <button class="btn btn-primary btn-sm btn-save" style="background-color: #02c700;margin-right: 15px">保存</button>
        <button class="btn btn-primary btn-sm btn-return">返回列表</button>
    </div>
</div>
<{include file="../img-upload-modal.tpl"}>
<script type="text/javascript" charset="utf-8" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
    /*标题实时预览*/
    function previewTitle(elem){
        var val = $(elem).val();
        $("#article-title").text(val);
    }

    var nowdate = new Date();
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd HH:mm:ss'
        });
    }


    //选择关联商品
    function dealGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".goods-none").remove();
        var append_html = "<div class='goods-name goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //选择关联商品
    function dealAppointmentGoods(ele) {
        var gid = $(ele).data('gid');
        var gname = $(ele).data('name');
        //防止重复关联
        var num = $("[gid='" +gid+ "']").length;
        if(num >= 1){
            layer.msg('您已添加此商品，请勿重复');
            return false;
        }

        $(".appointment-goods-none").remove();
        var append_html = "<div class='goods-name appointment-goods-selected' gid='"+ gid +"' ><div class='goods-selected-name'>"+ gname +"</div><div class='goods-selected-button'><button class='btn btn-sm btn-default goods-button btn-remove' onclick='removeAppointmentGoods(this)'>移除</button></div></div>";
        console.log(gname);
        $('.appointment-goods-selected-list').append(append_html);
        $('#goods-modal').modal('hide');
    }

    //移除关联商品
    function removeGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
        }
    }

    //移除关联商品
    function removeAppointmentGoods(ele) {
        console.log('remove');
        $(ele).parent().parent().remove();
        var num = $('.appointment-goods-selected').length;
        if(num == 0){
            var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
            $('.appointment-goods-selected-list').html(default_html);
        }
    }


    //清空关联商品
    $('.btn-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.goods-selected-list').html(default_html);
    });

    //清空关联商品
    $('.btn-appointment-remove-all').on('click',function () {
        var default_html = '<span class="goods-name goods-none" style="font-weight: bold;color: #38f">无推荐商品 </span>';
        $('.appointment-goods-selected-list').html(default_html);
    });


    $('.btn-save').on('click',function(){
        var content = weddingTaocanDetailArray[0]
        var title    = $('#title').val();
        var video    = $('#video').val();
        var cover    = $('#cover').val();
        var brief    = $('#brief').val();
        var sort     = $('#sort').val();
        var price     = $('#price').val();
        var articleFrom = $('#articleFrom').val();
        var category = $('#category-name').val();
        var recommend= $('#isRecommend').val();
        var urlType  = $('input[name="type"]:checked').val();
        var goodsType  = $('input[name="goodsType"]:checked').val();
        var appointmentGoodsType  = $('input[name="appointmentGoodsType"]:checked').val();
        var displayType  = $('input[name="displayType"]:checked').val();
        //var id       = '<{$row['ai_id']}>';
        var id       = $('#hid_id').val();
        var gids     = [];
        var agids     = [];
        var relatedInfo = [];
        var selectInfo = {};
        var showNum  = $('#showNum').val();
        var likeNum  = $('#likeNum').val();
        var customTime = $('#customTime').val();
        // var allowLike  = $('input[name="allow_like"]:checked').val();
        var allowComment  = $('input[name="allow_comment"]:checked').val();
        //保存推荐商品
        $('.goods-selected').each(function () {
            var gid = $(this).attr('gid');
           gids.push(gid)
        });
        $('.appointment-goods-selected').each(function () {
            var agid = $(this).attr('gid');
            agids.push(agid)
        });
        console.log(gids);
        console.log(agids);
        //保存相关文章
        $('.related-info').each(function () {
            var selectCate = $(this).find('.select-cate').val();
            var selectInfo = $(this).find('.select-info').val();
            if(selectCate && selectInfo){
                 selectInfo = {
                    'cateId' : selectCate,
                    'infoId' : selectInfo
                 };
                 relatedInfo.push(selectInfo);
            }
        });
        //if(<{$curr_sid}> == 5655){
        //    console.log(relatedInfo);
        //    return false;
        //}

        var data = {
            'id'         : id,
            'title'      : title,
            'cover'      : cover,
            'brief'      : brief,
            'category'   : category,
            'video'      : video,
            'content'    : content,
            'sort'       : sort,
            'price'      : price,
            'urlType'    : urlType,
            'recommend'  : recommend,
            'gids'       : gids,
            'agids'      : agids,
            'relatedInfo': relatedInfo,
            'likeNum'    : likeNum,
            'showNum'    : showNum,
            'customTime' : customTime,
            'articleFrom': articleFrom,
            'displayType': displayType,
            'goodsType'  : goodsType,
            'appointmentGoodsType': appointmentGoodsType,
            'allowComment' : allowComment,
            // 'allowLike' : allowLike
        };

        if(title && content && cover){
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            $.ajax({
                'type'	: 'post',
                'url'	: '/wxapp/currency/saleInformation',
                'data'	: data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        if(ret.id > 0){
                            $('#hid_id').val(ret.id);
                        }
                        //window.location.href='/wxapp/currency/informationList';
                        //window.history.go(-1);
                    }
                }
            });
        }else{
            layer.msg('请填写完整数据');
        }
    });

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
                    $('#cover').val(allSrc[0]);
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

    $(function(){
        $('#fetch-content').click(function(){
            var url = $('#fetch-url').val();
            var type = $('#article-link-type').val();
            if(url){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'	: 'post',
                    'url'	: '/wxapp/currency/fetchWebContent',
                    'data'	: {url:url, type: type},
                    'dataType' : 'json',
                    'success'  : function(ret){
                        console.log(ret);
                        layer.close(index);
                        if(ret.ec == 200){
                            if(type == 1){
                                if(ret.data.title){
                                    $('#title').val(ret.data.title);
                                    $('#article-title').text(ret.data.title);
                                }
                                for (var i=0;i<ret.data.all_list.length;i++)
                                {
                                    if(typeof(ret.data.all_list[i]) == 'string' ){
                                        $('#brief').val(ret.data.all_list[i]);
                                        break;
                                    }
                                }
                                if(ret.data.html){
                                    //KindEditor.instances[0].html(ret.data.html);
                                    UE.getEditor('article-detail').setContent(ret.data.html);
                                }
                                if(ret.data.img_list[0]){
                                    $('#upload-cover').attr('src',ret.data.img_list[0].url);
                                    $('#cover').val(ret.data.img_list[0].url);
                                }
                            }else{
                                if(ret.data.title){
                                    $('#title').val(ret.data.title);
                                    $('#article-title').text(ret.data.title);
                                }
                                $('#brief').val(ret.data.desc);
                                if(ret.data.cover){
                                    $('#upload-cover').attr('src',ret.data.cover);
                                    $('#cover').val(ret.data.cover);
                                }

                                if(ret.data.content){
                                    UE.getEditor('article-detail').setContent(ret.data.content);
                                    //KindEditor.instances[0].html(ret.data.content);
                                }

                                if(ret.data.video){
                                    $('#video').val(ret.data.video);
                                }
                            }

                            layer.msg('获取成功');
                        }else{
                            layer.msg(ret.em);
                        }
                    }
                });
            }

        })

    });
    /**
     * 预览视频
     */
    function hrefto(data){
        layer.open({
            type: 2,
            title: false,
            area: ['630px', '360px'],
            shade: 0.8,
            closeBtn: 1,
            shadeClose: true,
            content: data
        });
    };
    /**
     * 预览音频
     */
    function hreftoVoice(data){
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            shadeClose: true,
            skin: 'yourclass',
            content: data
        });
    };
    function videoShow(obj){
        var type=$('input:radio:checked').val();
        var data=$('#video').val();
        if(type==1){
            if(data){
                var html='<video id="media" src="'+data+'"autoplay="autoplay" controls="controls" style="width:400px"></video>';
                hreftoVoice(html);
                var Media = document.getElementById("media");
                Media.onerror = function() {
                    $('.layui-layer').css('display','none');
                    $('.layui-layer-shade').css('display','none');
                    layer.msg('请填入正确的视频地址');
                };
            }else{
                layer.msg('请填入视频地址');
            }
        }else if(type==2){
            if(data){
                var htmll='<audio id="voice" src="'+data+'"autoplay="autoplay" controls="controls"></audio>';
                hreftoVoice(htmll);
                var voice = document.getElementById("voice");
                voice.onerror = function() {
                    $('.layui-layer').css('display','none');
                    $('.layui-layer-shade').css('display','none');
                    layer.msg('请填入正确的音频地址');
                };
            }else{
                layer.msg('请填入音频地址');
            }
        }
    }

    //管理商品
    $('.btn-goods').on('click',function(){
        //初始化
        var num = $('.goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();

        $('.th-weight').hide();

        $('#goods-modal').modal('show');
        $('#search-type').val('information');

        //重新获取数据
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage, 'information');
    });

    //管理商品
    $('.btn-appointment-goods').on('click',function(){
        //初始化
        var num = $('.appointment-goods-selected').length;
        if(num >= 10){
            layer.msg('最多只能添加10个商品');
            return false;
        }

        $('#goods-tr').empty();
        $('#footer-page').empty();

        $('.appointment-th-weight').hide();

        $('#goods-modal').modal('show');
        $('.typeselect').hide();
        $('#search-type').val('informationAppointment');

        //重新获取数据
        $('#currId').val($(this).data('id')) ;
        currPage = 1 ;
        fetchGoodsPageData(currPage,'informationAppointment');
    });

    function changeGoodsType(goodsType) {
        $('#goodsType').val(goodsType) ;
        fetchGoodsPageData(1)
    }

    function fetchGoodsPageData(page, type){
        if(!type){
            type = $('#search-type').val();
        }
        currPage = page;
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        var data = {
            'type'  :  type, //资讯添加商品
            'id'    :  $('#currId').val()  ,
            'goodsType' : $('#goodsType').val() ,
            'page'  : page,
            'keyword': $('#keyword').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/giftGoods',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                console.log(ret);
                layer.close(index);
                if(ret.ec == 200){
                    fetchGoodsHtml(ret.list, type);
                    $('#footer-page').html(ret.pageHtml)
                }
            }
        });
    }

    function fetchGoodsHtml(data, type){
        var html = '';
        for(var i=0 ; i < data.length ; i++){
            html += '<tr id="goods_tr_'+data[i].g_id+'">';
            html += '<td><img src="'+data[i].g_cover+'"/></td>';
            html += '<td style="text-align:left"><p class="g-name">'+data[i].g_name+'</p></td>';
            if(type=='information'){
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealGoods( this )"> 选取 </td>';
            }else{
                html += '<td><a href="javascript:;" class="btn btn-xs btn-info deal-goods" data-gid="'+data[i].g_id+'" data-name="'+data[i].g_name+'" onclick="dealAppointmentGoods( this )"> 选取 </td>';
            }
            html += '</tr>';
        }
        $('#goods-tr').html(html);
    }



    var infoArr = <{$informationArr}>;
    function getInformation(ele,index) {
        var cate = $(ele).val();
        var infoSelect = infoArr[cate];
        infoSelectOption(index,infoSelect);

    }
    function infoSelectOption(index,infoSelect) {
        var str = '';
            str += "<option value='0'>请选择文章</option>";
            if(infoSelect){
                for(var i = 0 ; i < infoSelect.length; i++){
                    str += "<option value='"+ infoSelect[i].id +"'>"+ infoSelect[i].title +"</option>"
                }
            }
        console.log(str);
        $(".related-info_"+index).find('.select-info').html(str);

    }

    function removeInfo(index) {
         $(".related-info_"+index).remove();
    }

    function addInfo() {
        var count = $('.related-info').length;
        if(count >= 5){
            layer.msg('最多添加5条相关文章');
            return false;
        }else{
            var _html = '';
             _html += '<div class="related-info related-info_'+ count +'"><div class="related-info-cate"><label id="default-onoff"><select style="height: 35px;" class="form-control select-cate" onchange="getInformation(this,'+ count +')"><option value="0">请选择分类</option><{foreach $category_select as $key=>$val}><option value="<{$key}>"><{$val}></option><{/foreach}></select></label></div><div class="related-info-detail"><select  style="height: 35px;" class="form-control select-info"><option value="0">请选择文章</option></select></div><button class="btn btn-sm btn-default goods-button btn-remove-info" onclick="removeInfo('+ count +')">移除</button></div>';
            $('.related-info-box').append(_html);
        }
    }

    $('.btn-return').on('click',function(){
        window.location.href='/wxapp/currency/informationList';
    });





</script>
