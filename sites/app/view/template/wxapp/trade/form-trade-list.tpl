<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<link rel="stylesheet" href="/public/manage/css/member-list.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" type="text/css" href="/public/wxapp/css/member-list-new.css?31">
<style>
    #excelOrder .form-group{
        height: 30px;
    }
    .btn-blueoutline, .btn-blueoutline:focus{ background-color: rgba(0, 0, 0, 0) !important; color: #008cf6 !important; border-color: #008cf6; text-shadow: none !important; }
    .btn-blueoutline:hover{ background-color: #008cf6 !important;  border-color: #008cf6 !important; color: #fff!important;}
    .btn-redoutline, .btn-redoutline:focus{ background-color: rgba(0, 0, 0, 0) !important; color: red !important; border-color: red; text-shadow: none !important; }
    .btn-redoutline:hover{ background-color: red !important;  border-color: red !important; color: #fff!important;}
    td{vertical-align: middle!important;}
</style>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>

<div id="content-con" class="content-con">
    <div>
        <a href="javascript:;" class="btn btn-green btn-xs btn-excel" ><i class="icon-download"></i>订单导出</a>
    </div>
    <div class="search-part-wrap">
        <form action="/wxapp/zftrade/formTradeList" method="get" class="form-inline">
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">联系人</div>
                    <div class="input-form">
                        <input type="text" style="width: 150px;" class="form-control" name="name" id="name" value="<{$name}>" placeholder="联系人">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">联系方式</div>
                    <div class="input-form">
                        <input type="text" style="width: 150px;" class="form-control" name="mobile" id="mobile" value="<{$mobile}>" placeholder="联系方式">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">公司名称</div>
                    <div class="input-form">
                        <input type="text" style="width: 150px;" class="form-control" name="c_name" id="c_name" value="<{$c_name}>" placeholder="公司名称">
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">预约类型</div>
                    <div class="input-form">
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="order_type" id="order_type" >
                                <option value="0">全部</option>
                                <{foreach $type as $key=>$val}>
                                  <option value="<{$key}>" <{if $order_type == $key}>selected<{/if}>><{$val}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="input-item-group">
                    <div class="input-item-addon">区域</div>
                    <div class="input-form">
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="pro" id="pro" >
                                <option value="0">省份</option>
                                <{foreach $pro as $val}>
                                  <option value="<{$val['region_id']}>" <{if $pro_id == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="city" id="city" >
                                <option value="0">城市</option>
                                <{foreach $city as $val}>
                            <option value="<{$val['region_id']}>" <{if $city_id == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                        <div class="col-sm-8" style="width:30%;">
                            <select class="form-control" name="area" id="area" >
                                <option value="0">地区</option>
                                <{foreach $area as $val}>
                            <option value="<{$val['region_id']}>" <{if $area_id == $val['region_id']}>selected<{/if}>><{$val['region_name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-input-item">
                <div class="search-btn">
                    <button type="submit" class="btn btn-blue btn-sm">查询</button>
                    <!--<a href="javascript:;" class="btn btn-blue btn-sm btn-excel" ><i class="icon-download"></i>用户导出</a>-->
                </div>
            </div>
        </form>
    </div>
    <div class="cus-part-item" style="padding:0 12px;box-shadow: none;">
        <div class="fixed-table-box">
            <div class="fixed-table-body">
                <table id="sample-table-1" class="table table-avatar">
                    <thead>
                    <tr>
                        <th>预约类型</th>
                        <th>企业服务/文章</th>
                        <th>联系姓名</th>
                        <th>联系方式</th>
                        <th>公司名称</th>
                        <th>区域</th>
                        <th>预约时间</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <{foreach $list as $val}>
                        <tr id="tr_<{$val['ft_id']}>" class="tr-content">
                            <td><{$type[$val['ft_type']]}></td>
                            <td><{$val['name']}></td>
                            <td><{$val['ft_name']}></td>
                            <td><{$val['ft_mobile']}></td>
                            <td><{$val['ft_c_name']}></td>
                            <td><{$val['ft_pro_name']}>-<{$val['ft_city_name']}>-<{$val['ft_area_name']}></td>
                            <td><{date('Y-m-d,H:i',$val['ft_create_time'])}></td>
                            <td>
                                <a class="btn btn-xs btn-redoutline delCategory" data-id="<{$val['ft_id']}>">删除</a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                    <tbody class="widget-list-item">
                    <tr class="separation-row">
                        <td colspan="8"><{$pageHtml}> </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出订单
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form id='trade-export-form' enctype="multipart/form-data" action="/wxapp/order/excelFormOrder" method="post" onsubmit="return false">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">订单类型</label>
                            <div class="col-sm-4">
                                <select id="orderType" name="orderType" class="form-control">
                                    <option value="0">全部</option>
                                    <{foreach $type as $key=>$val}>
                                    <option value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期" autocomplete='off'/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"  autocomplete='off' />
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>
                        <div class="space" style="margin-bottom: 70px;"></div>
                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button id='trade-export' type="submit" class="btn btn-primary" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/manage/controllers/custom.js"></script>
<script type="text/javascript" src="/public/manage/controllers/member.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/plugin/ZeroClip/clipboard.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script type="text/javascript">
    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    $('#trade-export').click(function(){
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type:'POST',
            url:'/wxapp/order/excelFormOrder',
            dataType:'json',
            data:$('#trade-export-form').serialize(),
            success:function(res){
                if(res.ec==200){
                    // window.open('http://'+location.hostname+res.data.url);
                    window.location.href=res.data.url;
                }else{
                    layer.msg(res.em);
                }
                layer.close(index);
            },
            error:function(){
                layer.msg('数据导出失败，请稍后再试或减少单次的导出量！');
            },
            complete:function(){
                layer.close(index);
            }
        })
    });


    $('#pro').change(function(){
        $("#city").html('');
        $("#area").html('');
        var p_ro = $(this).val();
        //console.log(p_ro);return;
        var data = {
            'pro' : p_ro,
        }
        $.ajax({
            url:'/wxapp/park/getcity',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value=''>地市</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#city").html(option);
            }
        })

    });
    $('#city').change(function(){
        $("#area").html('');
        var city = $(this).val();
        var data = {
            'city' : city,
        }
        $.ajax({
            url:'/wxapp/park/getarea',
            type:'post',
            data:data,
            dataType:'json',
            success: function(ret){
                var option="<option value='不限'>不限</option>";
                $.each(ret,function(k,v){
                    option += '<option value=' + v['region_id'] + '>' + v['region_name'] + '</option>'
                });
                $("#area").html(option);
            }
        })

    });
    $('.delCategory').on('click',function(){
        var id = $(this).data('id');
        //console.log(cid);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/zftrade/delTrade',
            'data'  : { id : id },
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }else{

                }
            }
        });
    })



    $('.updatefid').on('click',function(){
        var mid = $(this).data('mid');
        //console.log(mid);return;
        $('#memid').val(mid);
        $('#fmemid').val('');
        //$('#fidmodal').val('');
    })

    $('#savefid').on('click',function(){
        var mid = $('#memid').val();
        var fid = $('#fmemid').val();
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/savefid',
            'data'  : { 'mid' : mid , 'fid' : fid},
            'dataType' : 'json',
            'success'  : function(ret){
                //console.log(ret);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    //$('#tr_'+id).remove();
                    //optshide();
                    window.location.reload();
                }
            }
        });
    })

    $('.deletedfid').on('click',function(){
        var mid = $(this).data('mid');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/savefid',
            'data'  : { 'mid' : mid , 'fid' : 0},
            'dataType' : 'json',
            'success'  : function(ret){
                //console.log(ret);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    //$('#tr_'+id).remove();
                    //optshide();
                    window.location.reload();
                }
            }
        });
    })

    $('.president').on('click',function(){
        var id   = $(this).data('id');
        var city = $(this).data('city');
        var type = $(this).data('type');
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/savepresident',
            'data'  : { 'id' : id , 'city' : city , 'type' : type},
            'dataType' : 'json',
            'success'  : function(ret){
                //console.log(ret);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    //$('#tr_'+id).remove();
                    //optshide();
                    window.location.reload();
                }
            }
        });
    })
    function changeSale(obj,id){
        var val = parseInt($(obj).val());
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/changeSale',
            'data'  : {'id':id,'val':val},
            'dataType' : 'json',
            'success'  : function(ret){
                console.log(ret);
                layer.msg(ret.em);
            }
        });
    }
</script>
<script type="text/javascript">
    $(function(){
        /*初始化日期选择器*/
        $('.date-picker').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });

        $("input[id^='timepicker']").timepicker({
            minuteStep: 1,
            showSeconds: true,
            showMeridian: false
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });
    })
    var clipboard = new ClipboardJS('.copy-openid');
    // 复制内容到剪贴板成功后的操作
    clipboard.on('success', function(e) {
        console.log(e);
        layer.msg('复制成功');
    });
    clipboard.on('error', function(e) {
        console.log(e);
        console.log('复制失败');
    });



    $("#content-con").on('click', function(event) {
        optshide();
    });

    /*复制openid弹出框*/
    $("#content-con").on('click', 'table td a.btn-openid', function(event) {
        var openid = $(this).data('openid');
        if(openid){
            $('.copy-div input').val(openid);
            $('.copy-div .copy-openid').attr('data-clipboard-text',openid);
        }
        event.preventDefault();
        event.stopPropagation();

        var edithat = $(this) ;
        var conLeft = Math.round($("#content-con").offset().left)-160;
        var conTop = Math.round($("#content-con").offset().top)-104;
        var left = Math.round(edithat.offset().left);
        var top = Math.round(edithat.offset().top);
        optshide();
        $(".ui-popover.ui-popover-openid").css({'left':left-conLeft-64,'top':top-conTop-66}).stop().show();
    });

    $(".ui-popover .js-save").on('click', function(event) {
        var level = $(".ui-popover #member-grade").val();
        var id    = $('#hid_mid').val();
        if(id>0 && level != 0){
            event.preventDefault();
            var data  = {
                'id'    : id,
                'level' : level
            };
            var index = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/changeLevel',
                'data'  : data,
                'dataType' : 'json',
                'success'  : function(ret){
                    layer.close(index);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                        //optshide();
                    }
                }
            });
        }else{
            layer.msg('您尚未选择用户等级');
        }

    });

    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");

        /*日期选择器*/
        $('#endDate').datepicker({autoclose:true}).next().on(ace.click_event, function(){
            // $(this).prev().focus();
        });
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






    // 删除分类
    // $('#delCategory').on('click',function () {
    //     console.log(111);return;
    //     var cid = $(this).data('id');
    //     var data = {
    //         'cid' : cid,
    //     };
    //     $.ajax({
    //         'type'  : 'post',
    //         'url'   : '/wxapp/springsugar/delcategory',
    //         'data'  : data,
    //         'dataType'  : 'json',
    //         'success'   : function(ret){
    //             layer.close(load_index);
    //             if(ret.ec == 200){
    //                 window.location.reload();
    //             }else{
    //                 layer.msg(ret.em);
    //             }
    //         }
    //     });
    // });


</script>
<{include file="../img-upload-modal.tpl"}>