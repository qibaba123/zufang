<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/assets/css/select2.css">
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
    /* 商品列表图片名称样式 */
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
    .form-container .form-group{
        margin-bottom: 10px;
    }
    .input-group .select2-choice{
        height: 34px;
        line-height: 34px;
        border-radius: 0 4px 4px 0 !important;
    }
    .input-group .select2-container{
        border: none !important;
        padding: 0 !important;
    }

    .index-con {
        padding: 0;
        position: relative;
    }
    .index-con .index-main {
        height: 425px;
        background-color: #f3f4f5;
        overflow: auto;
    }
    .message{
        width: 92%;
        background-color: #fff;
        border:1px solid #ddd;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        -ms-border-radius: 4px;
        -o-border-radius: 4px;
        border-radius: 4px;
        margin:10px auto;
        -webkit-box-sizing:border-box;
        -moz-box-sizing:border-box;
        -ms-box-sizing:border-box;
        -o-box-sizing:border-box;
        box-sizing:border-box;
        padding:5px 8px 0;
    }
    .message h3{
        font-size: 15px;
        font-weight: bold;
    }
    .message .date{
        color: #999;
        font-size: 13px;
    }
    .message .remind-txt{
        padding:5px 0;
        margin-bottom: 5px;
        font-size: 13px;
        color: #FF1F1F;
    }
    .message .item-txt{
        font-size: 13px;
    }
    .message .item-txt .text{
        color: #5976be;
    }
    .message .see-detail{
        border-top:1px solid #eee;
        line-height: 1.6;
        padding:5px 0 7px;
        margin-top: 12px;
        background: url(/public/manage/mesManage/images/enter.png) no-repeat;
        background-size: 12px;
        background-position: 99% center;
    }
    .preview-page{
        max-width: 900px;
        margin:0 auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:20px 15px;
        overflow: hidden;
    }
    .preview-page .mobile-page{
        width: 350px;
        float: left;
        background-color: #fff;
        border: 1px solid #ccc;
        -webkit-border-radius: 15px;
        -moz-border-radius: 15px;
        -ms-border-radius: 15px;
        -o-border-radius: 15px;
        border-radius: 15px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        padding:0 15px;
    }
    .preview-page {
        padding-bottom: 20px!important;
    }
    .mobile-page{
        margin-left: 48px;
    }
    .mobile-page .mobile-header {
        height: 70px;
        width: 100%;
        background: url(/public/manage/mesManage/images/iphone_head.png) no-repeat;
        background-position: center;
    }
    .mobile-page .mobile-con{
        width: 100%;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        border:1px solid #ccc;
        background-color: #fff;
    }
    .mobile-con .title-bar{
        height: 64px;
        background: url(/public/manage/mesManage/images/titlebar.png) no-repeat;
        background-position: center;
        padding-top:20px;
        font-size: 16px;
        line-height: 44px;
        text-align: center;
        color: #fff;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        -ms-box-sizing: border-box;
        -o-box-sizing: border-box;
        box-sizing: border-box;
        letter-spacing: 1px;
    }

    .mobile-page .mobile-footer{
        height: 65px;
        line-height: 65px;
        text-align: center;
        width: 100%;
    }
    .mobile-page .mobile-footer span{
        display: inline-block;
        height: 45px;
        width: 45px;
        margin:10px 0;
        background-color: #e6e1e1;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        border-radius: 50%;
    }
    .set-goodsinfo{
        margin-left:3px;
    }
    #sample-table-1{
        border: none !important;
    }
</style>

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
<div  id="content-con">

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/sequence/activityGoodsList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商品名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="商品名称">
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
                        <input type="hidden" id="hid_aid" name="id" value="<{$aid}>">
                    </div>
                </div>
                <div class="col-xs-1 pull-right search-btn" style="position: absolute;top: 18%;right: 2%;">
                    <button type="submit" class="btn btn-green btn-sm">查询</button>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div class="fixed-table-header">
                    <table class="table table-striped table-hover table-avatar">
                        <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>商品 价格</th>
                                <th>商品分类</th>
                                <th>商品状态</th>
                                <th>商品显示</th>
                                <th>排序</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar" style="border: none">
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

                                        <p class="pro-price">
                                            <{$val['g_price']}>
                                        </p>
                                    </div>

                                </td>
                                <td><{$category[$val['g_kind2']]}></td>
                                <td>
                                    <{if $val['g_is_sale'] == 1}>
                                    <span style="">已上架</span>
                                    <{else}>
                                    <span style="color: red">已下架</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $val['g_applay_goods_show'] == 1}>
                                    <span style="">显示</span>
                                    <{else}>
                                    <span style="color: red">不显示</span>
                                    <{/if}>
                                </td>
                                <td id="sort_<{$val['asag_id']}>">
                                    <span><{$val['asag_sort']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['asag_id']}>" data-value="<{$val['asag_sort']}>" data-field="sort">修改</a>
                                </td>
                                <!--
                                <td id="stock_<{$val['g_id']}>">
                                    <span><{$val['g_stock']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_stock']}>" data-field="stock">修改</a>
                                </td>
                                <td id="sold_<{$val['g_id']}>">
                                    <span><{$val['g_sold']}></span>
                                    <a href="javascript:;" class="set-goodsinfo" data-id="<{$val['g_id']}>" data-value="<{$val['g_sold']}>" data-field="sold">修改</a>
                                </td>
                                -->
                                <td>
                                    <a href="#" class="btn btn-xs btn-danger select-goods" data-type="remove" data-id="<{$val['g_id']}>">移除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="2">
                                    <span class="btn btn-xs btn-name select-goods-multi btn-danger" data-type="remove">批量移除</span>
                                </td><td colspan="9" style="text-align:center"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div><!-- /span -->
    </div><!-- /row -->

</div>    <!-- PAGE CONTENT ENDS -->

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
<script src="/public/manage/assets/js/select2.min.js"></script>
<script type="text/javascript">
    customerGoodsCategory(0);
    var aid = $('#hid_aid').val();
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
    // 定义一个新的复制对象
    var clip = new ZeroClipboard( $('.copy_input'), {
        moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
    });
    // 复制内容到剪贴板成功后的操作
    clip.on( 'complete', function(client, args) {
        layer.msg('复制成功');
        optshide();
    } );
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
    // 推广商品弹出框
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
        //var value = $(this).data('value');
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
        $(".ui-popover.ui-popover-goodsinfo").css({'left':left-conLeft-376,'top':top-conTop-56}).stop().show();
    });



    $(".ui-popover-goodsinfo").on('click', function(event) {
        event.stopPropagation();
    });
     $("body").on('click', function(event) {
        optshide();
     });
     /*隐藏弹出框*/
     function optshide(){
         $('.ui-popover').stop().hide();
     }
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

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        var lists    =  '<{$now}>';
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        //$(".form-group-box .form-container").css("width",sumWidth+"px");
        if(lists){
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
            });
        }
        $(".my-select2").select2({
            language: "zh-CN", //设置 提示语言
            width: "100%", //设置下拉框的宽度
            placeholder: "请选择", // 空值提示内容，选项值为 null
        });

    });
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

    $(".save-goodsinfo").on('click',function () {
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        var id = $('#hid_gid').val();
        var field = $('#hid_field').val();
        var value = $('#currValue').val();

        var data = {
          'id'  :id,
          'field' :field,
          'value':value,
          'aid' : aid
        };

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/changeActivityGoodsInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                if(ret.ec == 200){
                    optshide();
                    $("#"+field+"_"+id).find("span").text(value);
                    //$("#"+field+"_"+id).find("a").attr('data-value',value);
                    layer.close(index);
                }else{
                    layer.msg(ret.em);
                }
            }
        });


    });

    $('.select-goods').on('click',function () {
       var id = $(this).data('id');
       var type = $(this).data('type');

       var data = {
         'gid' : id,
         'aid' : aid,
         'type' : type
       };
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });

        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/selectGoodsSingle',
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
    });

    $('.select-goods-multi').on('click',function(){
        var type = $(this).data('type');
        var ids  = get_select_all_ids_by_name('ids');
        if(!ids){
            layer.msg('请选择商品');
            return;
        }
        if(ids && type){
            var data = {
                'ids' : ids,
                'aid' : aid,
                'type' : type
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/sequence/selectGoodsMulti',
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

    });

</script>