<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
        white-space: nowrap;
        min-width: 90px;
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
    .balance-line-1 .balance-info{
        width: 16.66% !important;
    }
    .balance-line-2 .balance-info{
        width: 33.33% !important;
    }

    .coupon-admend{
        display:inline-block!important;
        width:13px;
        height:13px;
        cursor:pointer;
        visibility:hidden;
    }
    .tr-content:hover .coupon-admend{
        visibility:visible;
    }

</style>
<{if $couponCenter == 1}>
<{include file="../common-second-menu-new.tpl"}>
<{/if}>

<!-- 修改商品信息弹出框 -->
<div class="ui-popover ui-popover-couponinfo left-center" style="top:100px;width: 340px" >
    <div class="ui-popover-inner">
        <span></span>
        <input type="number" id="currValue" class="form-control" value="0" style="display: inline-block;width: 65%;">
        <input type="hidden" id="hid_clid" value="0">
        <input type="hidden" id="hid_field" value="">
        <a class="ui-btn ui-btn-primary save-couponinfo" href="javascript:;">确定</a>
        <a class="ui-btn js-cancel" href="javascript:;" onclick="optshide(this)">取消</a>
    </div>
    <div class="arrow"></div>
</div>

<div  id="content-con" <{if $couponCenter == 1}>style="margin-left:130px"<{/if}>>
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

    <!-- 汇总信息 -->
    <div class="balance balance-line-1 clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">优惠券总数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">发放中<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['going']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已结束<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['expire']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">未使用<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['goingTotal']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已使用<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['usedTotal']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已失效<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['expireTotal']}></span>
            </div>
        </div>
    </div>
    <div class="balance balance-line-2 clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">已使用金额<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['usedMoney']}></span>
                <span class="unit">元</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">未使用金额<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['goingMoney']}></span>
                <span class="unit">元</span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">已失效金额<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['expireMoney']}></span>
                <span class="unit">元</span>
            </div>
        </div>
    </div>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/coupon/shopCoupon" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">优惠券名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="优惠券名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">商家名称</div>
                                <input type="text" class="form-control" name="shopName" value="<{$shopName}>" placeholder="商家名称">
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
                <!--fixed-table-header-->
                <div class="fixed-table-header">
                    <table class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <!--
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            -->
                            <th>优惠券</th>
                            <th>商家名称</th>
                            <th>排序权重</th>
                            <!--
                            <th>首页显示</th>
                            -->
                            <th>面值</th>
                            <!--
                            <th>使用条件</th>
                            -->
                            <th>发放总量</th>
                            <th>已领取</th>
                            <th>已使用</th>
                            <!--
                            <th>单人限领</th>
                            -->
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                活动时间
                            </th>
                            <!--
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                失效时间
                            </th>
                            -->
                            <th>操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body" style="overflow: hidden;max-height: none">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr class="tr-content">
                                <!--
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['cl_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                -->
                                <td class="proimg-name">
                                    <{if mb_strlen($val['cl_name']) > 20 }>
                                    <{mb_substr($val['cl_name'],0,20)}>
                                    <{else}>
                                    <{$val['cl_name']}>
                                    <{/if}>

                                    <{if $val['cl_top'] == 1}>
                                    <span class="label label-sm label-success">置顶</span>
                                    <{/if}>
                                </td>
                                <td>
                                    <{if $appletCfg['ac_type'] == 6}>
                                    <{$val['acs_name']}>
                                    <{else}>
                                    <{$val['es_name']}>
                                    <{/if}>
                                </td>
                                <td id="sort_<{$val['cl_id']}>">
                                    <span><{$val['cl_sort']}></span>
                                    <img src="/public/wxapp/images/icon_edit.png" class="coupon-admend set-couponinfo" data-id="<{$val['cl_id']}>" data-value="<{$val['cl_sort']}>" data-field="sort" />
                                </td>
                                <!--
                                <td>
                                    <{if $val['cl_shop_show'] eq 1}>
                                    <span style="color:#f00;">展示</span>
                                    <{else}>
                                    <span>不展示</span>
                                    <{/if}>
                                </td>
                                -->
                                <td><{$val['cl_face_val']}></td>
                                <td><{$val['cl_count']}></td>
                                <td><{$val['cl_had_receive']}></td>
                                <td><{$val['cl_had_used']}></td>
                                <td>
                                    <p>
                                    生效时间：<{if $val['cl_start_time']}><{date('Y-m-d H:i:s',$val['cl_start_time'])}><{else}> 不限 <{/if}>
                                    </p>
                                    <p>
                                    失效时间：<{if $val['cl_end_time']}><{date('Y-m-d H:i:s',$val['cl_end_time'])}><{else}> 不限 <{/if}>
                                    </p>
                                </td>
                                <td style="color:#ccc;">
									<p>
                                        <a href="/wxapp/coupon/receive/cid/<{$val['cl_id']}>/esid/<{$val['cl_es_id']}>" >领取明细</a>
                                        <{if $val['cl_top'] == 1}>
                                         - <a href="#" class="top-btn" data-id="<{$val['cl_id']}>" data-value="0">取消置顶</a>
                                        <{else}>
                                         - <a href="#" class="top-btn" data-id="<{$val['cl_id']}>" data-value="1">置顶</a>
                                        <{/if}>
                                    </p>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="13" style="text-align:right"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>

            </div><!-- /span -->
        </div><!-- /row -->
    </div>    <!-- PAGE CONTENT ENDS -->
    <div class="modal fade" id="tplPreviewModal" tabindex="-1" role="dialog" aria-labelledby="tplPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="overflow: auto; width: 500px">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        &times;
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                        推送预览
                    </h4>
                </div>
                <div class="modal-body preview-page" style="overflow: auto">
                    <div class="mobile-page ">
                        <div class="mobile-header"></div>
                        <div class="mobile-con">
                            <div class="title-bar">
                                消息模板预览
                            </div>
                            <!-- 主体内容部分 -->
                            <div class="index-con">
                                <!-- 首页主题内容 -->
                                <div class="index-main" style="height: 380px;">
                                    <div class="message">
                                        <h3 id="tpl-title"></h3>
                                        <p class="date" id="tpl-date"></p>
                                        <div class="item-txt"  id="tpl-content">

                                        </div>
                                        <div class="see-detail">进入小程序查看</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-footer"><span></span></div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    </div>
    <script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
    <script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
    <script type="text/javascript" src="/public/plugin/ZeroClip/ZeroClipboard.min.js"></script>
    <script type="text/javascript">
        // 定义一个新的复制对象
        var clip = new ZeroClipboard( $('.copy_input'), {
            moviePath: "/public/plugin/ZeroClip/ZeroClipboard.swf"
        });
        // 复制内容到剪贴板成功后的操作
        clip.on( 'complete', function(client, args) {
            layer.msg('复制成功');
            optshide();
        } );

        $(".save-couponinfo").on('click',function () {
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });

            var id = $('#hid_clid').val();
            var field = $('#hid_field').val();
            var value = $('#currValue').val();

            var data = {
                'id'  :id,
                'field' :field,
                'value':value
            };
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/coupon/changeCouponInfo',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        optshide();
                        $("#"+field+"_"+id).find("span").text(value);
                        //$("#"+field+"_"+id).find("a").attr('data-value',value);
                        // if(field == "weight"){
                        //     window.location.reload();
                        // }
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });

        });

        $(".top-btn").on('click',function () {
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });

            var id = $(this).data('id');
            var value = $(this).data('value');

            var data = {
                'id'  :id,
                'field' :'top',
                'value':value
            };
            console.log(data);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/coupon/changeCouponInfo',
                'data'  : data,
                'dataType' : 'json',
                success : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });

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
            $(".ui-popover.ui-popover-link").css({'left':left-conLeft-510,'top':top-conTop-122}).stop().show();
        });

        /*修改商品信息*/
        $("#content-con").on('click', 'table td .coupon-admend.set-couponinfo', function(event) {
            console.log('work');
            var id = $(this).data('id');
            var field = $(this).data('field');
            //var value = $(this).data('value');
            var value = $(this).parent().find("span").text();//直接取span标签内数值,防止更新后value不变
            //console.log(value);
            $('#hid_clid').val(id);
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
            console.log(conTop+"/"+top);
            $(".ui-popover.ui-popover-couponinfo").css({'left':left-conLeft-376,'top':top-conTop-110}).stop().show();
        });

        $("#content-con").on('click', function(event) {
            optshide();
        });
        /*隐藏复制链接弹出框*/
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
                var url = '/manage/goods/shelf';
                plumAjax(url,data,true);
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
                $('#hid-goods').val(gid);
                $('#hid-type').val('deduct');
                $('#modal-info-form').modal('show');
            }else{
                layer.msg('未获取到优惠券信息');
            }

        });
        $('.modal-save').on('click',function(){
            var type = $('#hid-type').val();
            switch (type){
                case 'deduct':
                    saveRatio();
                    break;
            }

        });
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
                    'url'   : '/manage/goods/saveRatio',
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

        function pushCoupon(id) {
            layer.confirm('确定要推送吗？', {
                btn: ['确定','取消'], //按钮
                title : '推送'
            }, function(){
                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/tplpush/couponPush',
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


        $(function(){
            /*初始化搜索栏宽度*/
            var sumWidth = 200;
            var groupItemWidth=0;
            $(".form-group-box .form-container .form-group").each(function(){
                groupItemWidth=Number($(this).outerWidth(true));
                sumWidth +=groupItemWidth;
            });
            $(".form-group-box .form-container").css("width",sumWidth+"px");
            tableFixedInit();//表格初始化
            $(window).resize(function(event) {
                tableFixedInit();
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

        function deleteCoupon(id) {
            console.log(id);
            layer.confirm('确定要删除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	            var load_index = layer.load(2,
	                {
	                    shade: [0.1,'#333'],
	                    time: 10*1000
	                }
	            );
	            $.ajax({
	                'type'   : 'post',
	                'url'   : '/wxapp/coupon/deleteCoupon',
	                'data'  : { id:id},
	                'dataType'  : 'json',
	                'success'  : function(ret){
	                    layer.close(load_index);
	                    if(ret.ec == 200){
	                        window.location.reload();
	                    }else{
	                        layer.msg(ret.em);
	                    }
	                }
	            });
	        });
        }

        function showPreview(id) {
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/tplpreview/couponPreview',
                'data'  : {id:id},
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(index);
                    if(ret.ec == 200){
                        $('#tpl-title').html(ret.data.title);
                        $('#tpl-date').html(ret.data.date);
                        var data = ret.data.tplData;
                        var html = '';
                        for(var i in data){
                            html += '<div>';
                            if(data[i]['emphasis'] != 1){
                                html += '<span class="title" >'+data[i]['titletxt']+'：</span>';
                                html += '<span class="text"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                            }else{
                                html += '<span class="title" style="display: block;text-align: center">'+data[i]['titletxt']+'</span>';
                                html += '<span class="text" style="display: block;text-align: center;font-size: 20px"  style="color:'+data[i]["color"]+'">'+data[i]['contxt']+'</span>';
                            }
                            html += '</div>';
                        }
                        $('#tpl-content').html(html);
                    }else{
                        layer.msg(ret.em);
                    }

                }
            });
        }
    </script>