<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
        white-space: nowrap;
        min-width: 90px;
    }

    .balance {
        padding: 10px 0;
        border-top: 1px solid #e5e5e5;
        background: #fff;
        zoom: 1;
    }
    .balance-info {
        text-align: center;
        padding: 0 15px 30px;
    }
    .balance .balance-info {
        float: left;
        width: 33.33%;
        margin-left: -1px;
        padding: 0 15px;
        border-left: 1px solid #e5e5e5;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }
    .balance .balance-info2 {
        width: 50%;
    }
    .balance .balance-info .balance-title {
        font-size: 14px;
        color: #999;
        margin-bottom: 10px;
    }
    .balance .balance-info .balance-title span {
        font-size: 12px;
    }
    .balance .balance-info .balance-content {
        zoom: 1;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content span, .balance .balance-info .balance-content a {
        vertical-align: baseline;
        line-height: 26px;
    }
    .balance .balance-info .balance-content .unit {
        font-size: 12px;
        color: #666;
    }
    .pull-right {
        float: right;
    }
    .balance .balance-info .balance-content .money {
        font-size: 25px;
        color: #f60;
    }
    .balance .balance-info .balance-content .money-font {
        font-size: 20px;
    }
</style>
<{include file="../common-community-menu.tpl"}>
<div  id="content-con" style="margin-left: 150px">
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
    <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
        <div class="balance-info">
            <div class="balance-title">优惠券总数<span></span></div>
            <div class="balance-content">
                <span class="money"><{$statInfo['total']}></span>
            </div>
        </div>
        <div class="balance-info">
            <div class="balance-title">兑换中<span></span></div>
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
    </div>
    <a href="/wxapp/community/couponAdd" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 新增</a>

    <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/community/couponList" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">优惠券名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="优惠券名称">
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

    <div class="row">
        <div class="col-xs-12">
            <div class="fixed-table-box" style="margin-bottom: 30px;">
                <div <{if $count}>class="fixed-table-header" <{/if}>>
                    <table class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <!--<th class="center" style="">
                                <label>
                                    <input type="checkbox" class="ace"  id="checkBox" onclick="select_all_by_name('ids','checkBox')" />
                                    <span class="lbl"></span>
                                </label>
                            </th>-->
                            <th>优惠券</th>
                            <th>面值</th>
                            <th>使用条件</th>
                            <th>发放总量</th>
                            <th>已兑换</th>
                            <th>已使用</th>
                            <th>单人限兑换</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                	活动时间
                            </th>
                            <!--<th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                失效时间
                            </th>-->
                            <th>状态</th>
                            <th>是否已推送</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="fixed-table-body">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <tbody>
                        <{foreach $list as $val}>
                            <tr>
                                <!--<td class="center">
                                    <label>
                                        <input type="checkbox" class="ace" name="ids" value="<{$val['cl_id']}>"/>
                                        <span class="lbl"></span>
                                    </label>
                                </td>-->
                                <td class="proimg-name">
                                    <{if mb_strlen($val['cl_name']) > 20 }>
                                    <{mb_substr($val['cl_name'],0,20)}>
                                    <{else}>
                                    <{$val['cl_name']}>
                                    <{/if}>
                                </td>
                                <td><{$val['cl_face_val']}></td>
                                <td><{if $val['cl_use_limit']}> 满<{$val['cl_use_limit']}>使用 <{else}> 不限 <{/if}></td>
                                <td><{$val['cl_count']}></td>
                                <td><{$val['cl_had_receive']}></td>
                                <td><{$val['cl_had_used']}></td>
                                <td><{if $val['cl_receive_limit']}><{$val['cl_receive_limit']}>张<{else}> 不限 <{/if}></td>
                                <!--<td><{if $val['cl_start_time']}><{date('Y-m-d H:i:s',$val['cl_start_time'])}><{else}> 不限 <{/if}></td>
                                <td><{if $val['cl_end_time']}><{date('Y-m-d H:i:s',$val['cl_end_time'])}><{else}> 不限 <{/if}></td>-->
                                <td>
                                	<p>
                                    生效时间：<{if $val['cl_start_time']}><{date('Y-m-d H:i:s',$val['cl_start_time'])}><{else}> 不限 <{/if}>
                                    </p>
                                    <p>
                                    失效时间：<{if $val['cl_end_time']}><{date('Y-m-d H:i:s',$val['cl_end_time'])}><{else}> 不限 <{/if}>
                                </td>
                                <td>
                                	<{if $val['edit'] eq 1}>
                                    <span style="color: #333;">未过期</span>
                                    <{else}>
                                    <span style="color: #666;">已经过期</span>
                                    <{/if}>
                                </td>
                                <td><{if $val['cl_push']}>已推送<{else}><span style="color:#333;">未推送</span><{/if}></td>
                                <td style="color:#ccc;">                
                                    <a href="/wxapp/coupon/receive/cid/<{$val['cl_id']}>/type/1" >兑换明细</a>
                                    <{if !$val['cl_push']}>
                                     - <a href="javascript:;" onclick="pushCoupon('<{$val['cl_id']}>')" >推送</a>
                                    <{/if}>
                                    <{if $val['edit'] eq 1}>
                                     - <a href="/wxapp/community/couponAdd/?id=<{$val['cl_id']}>" >编辑</a>
                                    <{/if}>
                                     - <a href="#" onclick="deleteCoupon('<{$val['cl_id']}>')" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                            <{/foreach}>
                            <tr><td colspan="12" style="text-align:right"><{$paginator}></td></tr>
                        </tbody>
                    </table>
                </div>

            </div><!-- /span -->
        </div><!-- /row -->
    </div>    <!-- PAGE CONTENT ENDS -->
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
        $("body").on('click', function(event) {
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
    </script>