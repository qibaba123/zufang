<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    .alert-yellow {
        color: #FF6330;
        font-weight: bold;
        background-color: #FFFFCC;
        border-color: #FFDA89;
        margin:10px 0;
        letter-spacing: 0.5px;
        border-radius: 2px;
    }
    /* 课程列表图片名称样式 */
    td.proimg-name{
        min-width: 250px;
    }
    td.proimg-name img{
        float: left;
    }
    td.proimg-name>div{
        display: inline-block;
        margin-left: 10px;
        color: #428bca;
        width:100%
    }
    td.proimg-name>div .pro-name{
        max-width: 350px;
        margin: 0;
        width: 60%;
        margin-right: 40px;
        display: -webkit-box !important;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        white-space: normal;
    }
    td.proimg-name>div .pro-price{
        color: #E97312;
        font-weight: bold;
        margin: 0;
        margin-top: 5px;
    }
    .ui-popover.ui-popover-tuiguang.left-center .arrow{
        top:160px;
    }

    .ui-popover-tuiguang .code-fenlei>div {
        width: auto;
    }

    .alert-orange {
        text-align: center;
    }

    .fixed-table-body {
        max-height: inherit;
    }

    .vip-dialog__viptable td {
        border: 1px solid #e5e5e5;
        border-left: none;
        padding: 5px;
        height: 40px;
    }

    .vip-dialog__viptable .td-discount {
        width: 110px;
        text-align: center;
    }

    .vip-dialog__viptable .mini-input input {
        width: 54px;
        min-width: 0;
        padding: 3px 7px;
    }

    .vip-dialog__viptable .td-discount__unit {
        display: inline-block;
        margin-left: 10px;
    }

    .vip-dialog__viptable_head th{
        text-align: center;
        padding-bottom: 15px;
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
</style>
<div  id="content-con" >
    <!-- 推广课程弹出框 -->
    <div class="ui-popover ui-popover-tuiguang left-center">
        <div class="ui-popover-inner" style="padding: 0;border-radius: 7px;overflow: hidden;">
            <div class="tab-main">
                <div class="code-box show">
                    <div class="alert alert-orange">扫一扫，在手机上查看并分享</div>
                    <div class="code-fenlei">
                        <div style="text-align: center">
                            <div class="text-center show">
                                <input type="hidden" id="qrcode-goods-id"/>
                                <img src="" id="act-code-img" alt="二维码" style="width: 150px">
                                <p>扫码后直接购买</p>
                                <div style="text-align: center">
                                    <a href="javascript:;" onclick="reCreateQrcode()" class="new-window">重新生成</a>-
                                    <a href="" id="download-goods-qrcode" class="new-window">下载二维码</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="link-box">
                    <div class="link-wrap">
                        <p>课程页链接</p>
                        <div class="input-group copy-div">
                            <input type="text" class="form-control" id="copyLink" value="pages/goodDetail/goodDetail" readonly>
                            <span class="input-group-btn">
                                <a href="#" class="btn btn-white copy_input" id="copygoods" type="button" data-clipboard-target="copyLink" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <!-- 复制链接弹出框 -->
    <div class="ui-popover ui-popover-link left-center" style="top:100px;">
        <div class="ui-popover-inner">
            <div class="input-group copy-div">
                <input type="text" class="form-control" id="copy" value="" readonly>
                <span class="input-group-btn">
                    <a href="#" class="btn btn-white copy_input" id="copycardid" type="button" data-clipboard-target="copy" style="border-left:0;outline:none;padding-left:0;padding-right:0;width:60px;text-align:center">复制</a>
                </span>
            </div>
        </div>
        <div class="arrow"></div>
    </div>
    <div class="page-header">
        <a href="/wxapp/knowledgepay/addGoods" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>
        <a class="add-cost btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#cfgModal"  data-id="" data-weight="" >列表详情设置</a>
    </div>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/knowledgepay/goodsList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">课程名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="课程名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类目</div>
                                <select id="cate" name="cate" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $category as $key => $val}>
                                    <option <{if $cate eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon" style="height:34px;">类型</div>
                                <select id="knowpay" name="knowpay" style="height:34px;width:100%" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $knowpayType as $key => $val}>
                                <option <{if $knowpay eq $key}>selected<{/if}> value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>
    <div class="choose-state">
        <{foreach $choseLink as $val}>
        <a href="<{$val['href']}>" <{if $status eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
        <{/foreach}>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>课程</th>
                                <th>价格</th>
                                <{if $menuType eq 'toutiao' && $acType eq 27 }> 
                                <th>会员价</th>
                                <{/if}>
                                <th>课程分类</th>
                                <th>推荐</th>
                                <th>课程销量</th>
                                <th>排序权重</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    最近更新
                                </th>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <th>是否已推送</th>
                                <{/if}>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['g_id']}>">
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['g_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td class="proimg-name" style="min-width: 270px;">
                                    <{if isset($val['g_cover'])}>
                                    <img src="<{$val['g_cover']}>" width="75px" height="75px" alt="封面图">
                                    <{/if}>
                                    <div>
                                        <p class="pro-name">
                                            <{if mb_strlen($val['g_name']) > 20 }><{mb_substr($val['g_name'],0,20)}>
                                            <{mb_substr($val['g_name'],20,40)}><{else}><{$val['g_name']}><{/if}>
                                        </p>
                                    </div>

                                </td>
                                <td>
                                	<p class="pro-price" style="color: #E97312;font-weight: bold;"><{$val['g_price']}></p>
                                </td>
                                <{if $menuType eq 'toutiao' && $acType eq 27 }> 
                                <td><p class="pro-price" style="color: #E97312;font-weight: bold;"><{$val['g_vip_price']}></p></td>
                                <{/if}>
                                <td>
                                    <p>
                                        <{$category[$val['g_kind1']]}>
                                    </p>
                                    <p style="color: blue">
                                        <{$knowpayType[$val['g_knowledge_pay_type']]}>
                                    </p>
                                </td>
                                <td><{if $val['g_is_top'] eq 1}>
                                    <span class="label label-sm label-success">推荐</span>
                                    <{/if}></td>
                                <td><{$val['g_sold']}></td>
                                <td>
                                    <span><{$val['g_weight']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_weight']}>" data-field="weight">修改</a>
                                </td>
                                <td><{date('Y-m-d H:i:s',$val['g_update_time'])}></td>
                                <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                <td><{if $val['g_push']}>已推送<{else}><span style="color:#333;">未推送</span><{/if}></td>
                                <{/if}>
                                <td class="jg-line-color">
                                    <p>
                                        <a href="/wxapp/knowledgepay/goodsKnowledgeList/?id=<{$val['g_id']}>" >课程</a>
                                        <{if $levelList}>
                                        <a href="javascript:;" onclick="showVipPriceModal(<{$val['g_id']}>, <{$val['g_has_format']}>, <{$val['g_price']}>)">会员价</a>
                                        <{/if}>
                                        <{if !in_array($menuType,['aliapp','bdapp','toutiao','qq','qihoo'])}>
                                        <{if !$val['g_push']}>
                                        <a href="javascript:;" onclick="pushGoods('<{$val['g_id']}>')" >推送</a>
                                        <{/if}>
                                        <a href="javascript:;" class="btn-qrcode" data-link="<{$goodsPath}>?id=<{$val['g_id']}>" data-share="<{$val['g_qrcode']}>" data-id="<{$val['g_id']}>">二维码</a>
                                        <{/if}>
                                    </p>
                                	<p>
                                        <span <{if $menuType eq 'toutiao' && $acType eq 27 }> style="display: none;" <{/if}>>
                                        <a href="/wxapp/knowledgepay/addGoods/?id=<{$val['g_id']}>">编辑</a>    
                                        </span>
                                        <!-- 公众号资讯链接复制 -->
                                        <{if $course_link}>
                                            <a href="#" class="copy-button-link" data-clipboard-action="copy" data-clipboard-text="<{$course_link}>?id=<{$val['g_id']}>" >复制课程链接</a>
                                        <{/if}>
                                        <a href="javascript:;" id="del_<{$val['g_id']}>" class="btn-del" data-gid="<{$val['g_id']}>" style="color:#f00;">删除</a>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr>
                                <td colspan="2">
                                    <{if $status eq 'sell' || $status eq 'sellout'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-origin" data-type="down">下架</span>
                                    <{elseif $status eq 'depot'}>
                                    <span class="btn btn-xs btn-name btn-shelf btn-primary" data-type="up">上架</span>
                                    <{/if}>
                                    <span class="btn btn-xs btn-name btn-change-cate btn-primary" ><a href="javascript:;" style="color: #fff" data-toggle="modal" data-target="#myModal" >修改课程分类</a></span>
                                </td>
                                <td colspan="8" style="text-align:right"><{$paginator}></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 350px;">
            <div class="modal-content">
                <input type="hidden" id="hid_id" >
                <input type="hidden" id="now_expire" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        修改课程分类
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kind2" class="control-label">课程分类：</label>
                        <div class="control-group" id="customCategory">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="change-cate">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <div class="modal fade" id="vipPriceModal" tabindex="-1" role="dialog" aria-labelledby="vipPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="overflow: auto; width: 900px">
            <div class="modal-content">
                <input type="hidden" id="vip-price-type" >
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        自定义会员价
                    </h4>
                </div>
                <div class="modal-body" style="overflow: auto" id="vip-price-edit">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消
                    </button>
                    <button type="button" class="btn btn-primary" id="save-vip-price">
                        确认
                    </button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
</div>    <!-- PAGE CONTENT ENDS -->

<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-goodsinfo left-center" style="top:100px;" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_gid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-goodsinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>

<div class="modal fade" id="cfgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    设置
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">图文详情tab标题：</label>
                    <div class="col-sm-6">
                        <input type="text" maxlength="4" class="form-control" id="picture_tab" value="<{if $index_cfg['aki_picture_tab']}><{$index_cfg['aki_picture_tab']}><{else}>目录<{/if}>">
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">音频详情tab标题：</label>
                    <div class="col-sm-6">
                        <input type="text" maxlength="4" class="form-control" id="audio_tab" value="<{if $index_cfg['aki_audio_tab']}><{$index_cfg['aki_audio_tab']}><{else}>节目<{/if}>">
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">视频详情tab标题：</label>
                    <div class="col-sm-6">
                        <input type="text" maxlength="4" class="form-control" id="video_tab" value="<{if $index_cfg['aki_video_tab']}><{$index_cfg['aki_video_tab']}><{else}>课程<{/if}>">
                    </div>
                </div>

                <div style="padding-top: 10px;padding-bottom: 10px;text-align: center;color: #666;">
                    改变列表中的图文、音频、视频栏目的排序，越大越靠前
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">图文栏目权重：</label>
                    <div class="col-sm-6">
                        <input type="number" maxlength="4" class="form-control" id="picture_sort" value="<{if $index_cfg['aki_picture_sort']}><{$index_cfg['aki_picture_sort']}><{/if}>">
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">音频栏目权重：</label>
                    <div class="col-sm-6">
                        <input type="number" maxlength="4" class="form-control" id="audio_sort" value="<{if $index_cfg['aki_audio_sort']}><{$index_cfg['aki_audio_sort']}><{/if}>">
                    </div>
                </div>
                <div class="form-group row" style="margin-bottom: 5px">
                    <label class="col-sm-4 control-label no-padding-right" for="qq-num" style="text-align: center">视频栏目权重：</label>
                    <div class="col-sm-6">
                        <input type="number" maxlength="4" class="form-control" id="video_sort" value="<{if $index_cfg['aki_video_sort']}><{$index_cfg['aki_video_sort']}><{/if}>">
                    </div>
                </div>

        </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="save-cfg">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript">
    $(function(){
         // 定义一个新的复制对象
        var clipboard1 = new ClipboardJS('.copy-button-link');
        // 复制内容到剪贴板成功后的操作
        clipboard1.on('success', function(e) {
            layer.msg('复制成功');
        });
        var clipboard = new ClipboardJS('.copy_input');
        // 复制内容到剪贴板成功后的操作
        clipboard.on('success', function(e) {
            layer.msg('复制成功');
            optshide();
        });

        /*复制链接地址弹出框*/
        $("#content-con").on('click', 'table td a.btn-link', function(event) {
            var link = $(this).data('link');
            if(link){
                $('.copy-div input').val(link);
            }
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-104;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            optshide();
            $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
         });
        // 推广课程弹出框
        $("#content-con").on('click', 'table td a.btn-tuiguang', function(event) {
            var that = $(this);
            var shareImg  = that.data('share');
            var id  = that.data('id');
            var link   = $(this).data('link');
            $('#copyLink').val(link); //购买链接
            if(shareImg){
                $('#act-code-img').attr('src',shareImg); //分享二维码图片
                $('#qrcode-goods-id').val(id);
                $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
                event.preventDefault();
                event.stopPropagation();
                var edithat = $(this) ;
                var conLeft = Math.round($("#content-con").offset().left)-160;
                var conTop = Math.round($("#content-con").offset().top)-104;
                var left = Math.round(edithat.offset().left);
                var top = Math.round(edithat.offset().top);
                optshide();
                $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-530,'top':top-conTop-158-95}).stop().show();
            }
         });

        /*修改商品信息*/
        $("#content-con").on('click', 'table td a.set-goodsinfo', function(event) {
            var id = $(this).data('id');
            var field = $(this).data('field');
            var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
            $('#hid_gid').val(id);
            $('#hid_field').val(field);
            $('#currValue').val(value);
            optshide();
            event.preventDefault();
            event.stopPropagation();
            var edithat = $(this) ;
            var conLeft = Math.round($("#content-con").offset().left)-160;
            var conTop = Math.round($("#content-con").offset().top)-106;
            var left = Math.round(edithat.offset().left);
            var top = Math.round(edithat.offset().top);
            $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-76}).stop().show();
        });

        $(".save-goodsinfo").on('click',function () {
            var index = layer.load(10, {
                shade: [0.6, '#666']
            });

            var id = $('#hid_gid').val();
            var field = $('#hid_field').val();
            var value = $('#currValue').val();

            var data = {
                'id': id,
                'field': field,
                'value': value
            };

            $.ajax({
                'type': 'post',
                'url': '/wxapp/goods/changeGoodsInfo',
                'data': data,
                'dataType': 'json',
                success: function (ret) {
                    layer.close(index);
                    if (ret.ec == 200) {
                        optshide();
                        $("#" + field + "_" + id).find("span").text(value);
                        //$("#"+field+"_"+id).find("a").attr('data-value',value);
                        layer.close(index);
                        if (field == "weight") {
                            window.location.reload();
                        }
                    } else {
                        layer.msg(ret.em);
                    }
                }
            });
        });

        $("#content-con").on('click', 'table td a.btn-qrcode', function(event) {
            var that = $(this);
            var shareImg  = that.data('share');
            var id  = that.data('id');
            var link   = $(this).data('link');
            $('#copyLink').val(link); //购买链接
            //if(shareImg){
                $('#act-code-img').attr('src',shareImg); //分享二维码图片
                $('#qrcode-goods-id').val(id);
                $('#download-goods-qrcode').attr('href', '/wxapp/goods/downloadGoodsQrcode?id='+id);
                event.preventDefault();
                event.stopPropagation();
                var edithat = $(this) ;
                var conLeft = Math.round($("#content-con").offset().left)-160;
                var conTop = Math.round($("#content-con").offset().top)-104;
                var left = Math.round(edithat.offset().left);
                var top = Math.round(edithat.offset().top);
                optshide();
                $(".ui-popover.ui-popover-tuiguang").css({'left':left-conLeft-520,'top':top-conTop-158-72}).stop().show();
            //}
        });

        $('#save-vip-price').click(function () {
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            var type = $('#vip-price-type').val();
            var data = [];
            $('.vip-price-value').each(function(index, element) {
                data[index] = {
                    'id' : $(element).data('id'),
                    'identity' : $(element).data('lid'),
                    'price' : $(element).val(),
                };
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveVipPrice',
                'data'  : {data:data, type: type},
                'dataType' : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        layer.msg(ret.em);
                        layer.close(index);
                        $('#vipPriceModal').modal('hide');
                    }
                }
            });
        });

        $(".ui-popover-tuiguang").on('click', '.tab-name>span', function(event) {
            event.preventDefault();
            var $this = $(this);
            var index = $this.index();
            $this.addClass('active').siblings().removeClass('active');
            $this.parents(".ui-popover-tuiguang").find(".tab-main>div").eq(index).addClass('show').siblings().removeClass('show');
        });
        $(".ui-popover-tuiguang").on('click', '.code-fenlei .pull-left li', function(event) {
            event.preventDefault();
            var $this = $(this);
            var index = $this.index();
            $this.addClass('active').siblings().removeClass('active');
            $this.parents(".ui-popover-tuiguang").find(".code-fenlei .pull-right .text-center").eq(index).addClass('show').siblings().removeClass('show');
        });
        $(".ui-popover-tuiguang").on('click', function(event) {
            event.stopPropagation();
        });
        $(".ui-popover-goodsinfo").on('click', function(event) {
            event.stopPropagation();
        });
        $('.btn-shelf').on('click',function(){
            var type = $(this).data('type');
            var ids  = get_select_all_ids_by_name('ids');
            if(ids && type){
                var data = {
                    'ids' : ids,
                    'type' : type
                };
                var url = '/wxapp/goods/shelf';
                plumAjax(url,data,true);
            }

        });
        $('#change-cate').on('click',function(){
            var ids  = get_select_all_ids_by_name('ids');
            if(ids){
                var data = {
                    'ids' : ids,
                    'custom_cate': $('#custom_cate').val()
                };
                var url = '/wxapp/goods/changeCate';
                plumAjax(url,data,true);
            }
        });
        $('.btn-import').on('click',function(){
            var id = $(this).data('id');
            if(id){
                var index = layer.load(10, {
                    shade: [0.6,'#666']
                });
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/goods/shop2Common',
                    'data'  : {id:id},
                    'dataType' : 'json',
                    'success'   : function(ret){
                        layer.msg(ret.em);
                        layer.close(index);
                    }
                });
            }

        });
        $('.fxGoods').on('click',function(){
            var gid = $(this).data('gid');
            if(gid){
                for(var i=0 ; i<=3 ; i++){
                    var temp = $(this).data('ratio_'+i);
                    $('#ratio_'+i).val(temp);
                }
                var used = $(this).data('used');
                if(used == 1) {
                    $('input[name="used"]').prop("checked","checked");
                }else{
                    $('input[name="used"]').prop("checked","");
                }

                show_modal_content('threeSale',gid);
                $('#modal-info-form').modal('show');
            }else{
                layer.msg('未获取到课程信息');
            }
        });
        $('.setPoint').on('click',function(){
            var gid    = $(this).data('gid');
            var format = $(this).data('format');
            var point  = $(this).data('point');
            var unit   = $(this).data('unit');
            $('#backNum').val($(this).data('num'));
            $('input[name="backUnit"][value="'+unit+'"]').attr("checked",true);
            if(format == 0){
                var html = show_point_setting('赠送积分','sendPoint0',point,gid);
                $('#hid-num').val(1);
                $('#pointContent').html(html);
            }else{ //多规格的，分别处理
                var data = {
                    'gid' : gid
                };
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/goods/formatToPoint',
                    'data'  : data,
                    'dataType' : 'json',
                    'success'   : function(ret){
                        if(ret.ec == 200){
                            var html = '';
                            for(var i = 0 ; i < ret.data.length ; i ++){
                                var row = ret.data;
                                html += show_point_setting(row[i]['name'],'sendPoint'+i,row[i]['point'],row[i]['id'])
                            }

                            $('#hid-num').val(ret.data.length);
                            $('#pointContent').html(html);
                        }
                    }
                });
            }
            $('#hid-format').val(format);
            show_modal_content('setPoint',gid);
            $('#modal-info-form').modal('show');
        });
        $("body").on('click', function(event) {
            optshide();
        });

        $('.btn-del').on('click',function(){
            var data = {
                'id' : $(this).data('gid'),
                'type': 'goods'
            };
            //commonDeleteById(data);
            commonDeleteByIdWxapp(data);
        });
        $('.modal-save').on('click',function(){
            var type = $('#hid-type').val();
            switch (type){
                case 'deduct':
                    saveRatio();
                    break;
                case 'point':
                    savePoint();
                    break;
            }
        });

        /**
         * 修改课程字段
         */
        $('#save-cfg').on('click',function(){
            var picture_tab = $('#picture_tab').val();
            var audio_tab = $('#audio_tab').val();
            var video_tab = $('#video_tab').val();

            var picture_sort = $('#picture_sort').val();
            var audio_sort = $('#audio_sort').val();
            var video_sort = $('#video_sort').val();

            var index = layer.load(2,
                {
                    shade: [0.1,'#333'],
                    time: 10*1000
                }
            );
            var data = {
                'picture_tab' : picture_tab,
                'audio_tab' : audio_tab,
                'video_tab' : video_tab,

                'picture_sort' : picture_sort,
                'audio_sort' : audio_sort,
                'video_sort' : video_sort,
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/knowledgepay/updateField',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                }
            });
        });

         /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
    });
    customerGoodsCategory(0);
    function customerGoodsCategory(df){
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/ajaxGoodsCustomCategory',
            'dataType'  : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    customer_category(ret.data,df);
                }
            }
        });
    }
    function customer_category(data,df){
        var html = '<select id="custom_cate" name="custom_cate" class="form-control">';
        for(var i = 0; i < data.length ; i++){
            var son = data[i].secondItem;
            html += '<optgroup label="'+data[i].firstName+'" data-id="'+data[i].id+'">';
            for(var s = 0 ; s < son.length ; s ++){
                var sel = '';
                if(df == son[s].id){
                    sel = 'selected';
                }
                html += '<option value ="'+son[s].id+'" '+sel+'>'+son[s].secondName+'</option>';
            }

            html += '';
            html += '</optgroup>';
        }
        html += '</select>';
        $('#customCategory').html(html);
    }
    //重新生成课程二维码图片
    function reCreateQrcode(){
        var id = $('#qrcode-goods-id').val();
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/createQrcode',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    layer.msg(ret.em);
                    layer.close(index);
                    $('#act-code-img').attr('src',ret.url); //分享二维码图片
                }
            }
        });
    }
    function showVipPriceModal(id) {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/getVipPrice',
            'data'  : {id:id},
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                $('#vip-price-type').val(ret.type);
                $html = '';
                $html += '<table><thead class="vip-dialog__viptable_head">';
                $html += '<tr>';
                for(var i in ret.formatName){
                    $html +=  '<th class="sku"><div class="tdwrap1">'+ret.formatName[i]+'</div></th>';
                }
                $html +=  '<th class="sku"><div class="tdwrap1">正常售价</div></th>';
                for(var i in ret.data[0]['vipPrice']){
                    $html += '<th><div class="tdwrap2">'+ret.data[0]['vipPrice'][i]['name']+'</div></th>';
                }
                $html += '</tr></thead>';
                $html += '<tbody class="vip-dialog__viptable">';
                for(var i in ret.data){
                    $html += '<tr>';
                    if(ret.data[i]['name1']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name1']+'</div></td>';
                    }
                    if(ret.data[i]['name2']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name2']+'</div></td>';
                    }
                    if(ret.data[i]['name3']){
                        $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">'+ret.data[i]['name3']+'</div></td>';
                    }
                    $html += '<td><div class="td-sku" id="normal-price" style="width: 110px;text-align: center">￥'+ret.data[i]['price']+'</div></td>';
                    for(var n in ret.data[i]['vipPrice']){
                        $html += '<td class=""><div class="td-discount">' +
                            '<div class="zent-number-input-wrapper mini-input" style="display: inline-block">' +
                            '<div class="zent-input-wrapper mini-input">' +
                            '<input type="text" class="form-control vip-price-value" style="display: inline-block" data-id='+ret.data[i]['vipPrice'][n]['id']+' data-lid='+ret.data[i]['vipPrice'][n]['lid']+' value="'+ret.data[i]['vipPrice'][n]['price']+'"></div></div>' +
                            '<span class="td-discount__unit">元</span></div></td>';
                    }
                    $html += '</tr>';
                }
                $html += '</tbody></table>';
                $('#vip-price-edit').html($html);
                $('#vipPriceModal').modal('show');
            }
        });
    }
    /*隐藏弹出框*/
    function optshide(){
        $('.ui-popover').stop().hide();
    }
    function show_point_setting(title,id,val,did){
        var _html = '<div class="form-group">';
        _html += '<div class="input-group">';
        _html += '<div class="input-group-addon input-group-addon-title">'+title+'</div>';
        _html += '<input type="text" class="form-control" id="'+id+'" value="'+val+'" data-id="'+did+'" placeholder="请填写积分">';
        _html += '<div class="input-group-addon">分</div>';
        _html += '</div></div>';
        _html += '<div class="space-4"></div>';
        return _html;
    }
    function show_modal_content(id,gid){
        $('.tab-div').hide();
        $('#'+id).show();
        $('#hid-goods').val(gid);
        var title = '佣金配置设置',type='deduct';
        switch (id){
            case 'threeSale':
                title = '佣金配置设置';
                type  = 'deduct';
                break;
            case 'setPoint':
                title = '课程积分设置';
                type  = 'point';
                break;
        }
        $('#modal-title').text(title);
        $('#hid-type').val(type);
    }
    
    function saveRatio(){
        var gid = $('#hid-goods').val();
        if(gid){
            var ck = $('#used:checked').val();
            var data = {
                'gid'  : gid,
                'used' : ck == 'on' ? 1 : 0,
            };
            for(var i=0 ; i<=3 ; i++){
                data['ratio_'+i] = $('#ratio_'+i).val();
            }
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goods/saveRatio',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });

        }
    }

    function savePoint(){
        var data = {
            'gid'    : $('#hid-goods').val(),
            'format' : $('#hid-format').val(),
            'unit'   : $('input[name="backUnit"]:checked').val(),
            'num'    : parseInt($('#backNum').val())
        };
        if(data.num <= 0){
            layer.msg('请填写返还期数');
            return false;
        }
        if(data.format == 0){
            data.point = $('#sendPoint0').val();
        }else{
            var num    = $('#hid-num').val();
            var point  = {};
            for(var i = 0 ; i < num ; i ++){
                var temp = {
                    'id' : $('#sendPoint'+i).data('id'),
                    'val': $('#sendPoint'+i).val()
                };
                point['point_'+i] = temp;
            }
            data.point = point;
        }
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/goods/savePoint',
            'data'  : data,
            'dataType' : 'json',
            'success'   : function(ret){
                layer.close(index);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    }

    function pushGoods(id) {
        layer.confirm('确定要推送吗？', {
          btn: ['确定','取消'], //按钮
          title : '推送'
        }, function(){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpush/goodsPush',
                'data'  : { id:id},
                'dataType' : 'json',
                success : function(ret){
                    layer.msg(ret.em,{
                        time: 2000, //2s后自动关闭
                    },function(){
                        if(ret.ec == 200){
                            window.location.reload();
                        }
                    });
                }
            });
        }, function(){

        });
    }
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }
</script>