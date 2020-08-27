<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/wxapp/css/member-record-derails.css?3">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<div  id="content-con" class="cus-part-item" style="padding: 15px 22px;">
    <div class="wechat-setting">
        <div class="tabbable">
            <!--导航链接-->
            <{include file="../memberCard/tabal-link.tpl"}>
            <div class="tab-content"  style="z-index:1;padding: 10px 0;padding-bottom: 0;">
                <div id="mainContent">
                    <div class="balance">
                        <div class="balance-info">
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money"><{$statInfo['goingTotal']}></span>
                                </div>
                                <div class="balance-title">未使用<span></span></div>
                            </div>
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money"><{$statInfo['goingMoney']}></span>
                                </div>
                                <div class="balance-title">未使用金额<span></span></div>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money" style="color: #ff9638;"><{$statInfo['usedTotal']}></span>
                                </div>
                                <div class="balance-title">已使用<span></span></div>
                            </div>
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money" style="color: #ff9638;"><{$statInfo['usedMoney']}></span>
                                </div>
                                <div class="balance-title">已使用金额<span></span></div>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money" style="color: #ff433b;"><{$statInfo['expireTotal']}></span>
                                </div>
                                <div class="balance-title">已失效<span></span></div>
                            </div>
                            <div class="balance-info-item">
                                <div class="balance-content">
                                    <span class="money" style="color: #ff433b;"><{$statInfo['expireMoney']}></span>
                                </div>
                                <div class="balance-title">已失效金额<span></span></div>
                            </div>
                        </div>
                    </div>
                    <!-- 汇总信息 -->
                    <!-- <div class="balance balance-line-1 clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                        <div class="balance-info">
                            <div class="balance-title">未使用<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['goingTotal']}></span>
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
                            <div class="balance-title">已使用<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['usedTotal']}></span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">已使用金额<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['usedMoney']}></span>
                                <span class="unit">元</span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">已失效<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['expireTotal']}></span>
                            </div>
                        </div>
                        <div class="balance-info">
                            <div class="balance-title">已失效金额<span></span></div>
                            <div class="balance-content">
                                <span class="money"><{$statInfo['expireMoney']}></span>
                                <span class="unit">元</span>
                            </div>
                        </div>
                    </div> -->
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="tabbable record-tabbable">
                                <ul class="nav nav-tabs" id="myTab">
                                    <!--
                                    <li >
                                        <a href="/wxapp/member/rechargeChange">
                                            <i class="green icon-cog bigger-110"></i>
                                            充值配置
                                        </a>
                                    </li>
                                    -->
                                    <li <{if $type == 'going'}>class="active"<{/if}>>
                                        <a <{if $type == 'going'}>href="#"<{else}>href="/wxapp/member/memberCouponRecord?mid=<{$mid}>&type=going"<{/if}>>
                                       未使用
                                        </a>
                                    </li>
                                    <li <{if $type == 'used'}>class="active"<{/if}>>
                                        <a <{if $type == 'used'}>href="#"<{else}>href="/wxapp/member/memberCouponRecord?mid=<{$mid}>&type=used"<{/if}>>
                                        已使用
                                        </a>
                                    </li>
                                    <li <{if $type == 'expire'}>class="active"<{/if}>>
                                        <a <{if $type == 'expire'}>href="#"<{else}>href="/wxapp/member/memberCouponRecord?mid=<{$mid}>&type=expire"<{/if}>>
                                        已失效
                                        </a>
                                    </li>
                                </ul>
                                <!-- <div class="search-part-wrap">
                                    <form class="form-inline" action="/wxapp/member/memberCouponRecord" method="get">
                                        <input type="hidden" name="mid" value="<{$mid}>">
                                        <input type="hidden" name="status" value="<{$status}>">
                                        <div class="search-input-item">
                                            <div class="input-item-group">
                                                <div class="input-item-addon">时间</div>
                                                <div class="input-form">
                                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </div>
                                                <div class="input-form">到</div>
                                                <div class="input-form">
                                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd'})">
                                                    <i class="icon-calendar bigger-110"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="search-input-item">
                                            <div class="search-btn">
                                                <button type="submit" class="btn btn-blue btn-sm">查询</button>
                                            </div>
                                        </div>
                                    </form>
                                </div> -->
                                <div class="tab-content" style="padding: 10px 0;padding-bottom: 0;">
                                    <!--
                                    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>充值记录导出</a>
                                    -->
                                    <!--充值记录-->
                                    <div id="home" class="tab-pane in active">
                                        <div class="cus-part-item" style="padding: 0;box-shadow: none;margin-bottom: 0;">
                                            <div class="table-responsive">
                                                <table id="sample-table-1" class="table" style="margin-bottom: 0;">
                                                    <thead>
                                                    <tr>
                                                        <th>名称</th>
                                                        <th>优惠券金额</th>
                                                        <th>优惠券门槛</th>
                                                        <th>领取时间</th>
                                                        <th>使用时间</th>
                                                        <th>当前状态</th>
                                                        <th>失效时间</th>
                                                    </tr>
                                                    </thead>

                                                    <tbody>
                                                    <{foreach $list as $item}>
                                                        <tr id="tr_id_<{$item['cr_id']}>">
                                                            <td><{$item['cl_name']}></td>
                                                            <td><{$item['cl_face_val']}></td>
                                                            <td>
                                                                <{if $item['cl_use_limit']}>
                                                                <{$item['cl_use_limit']}>
                                                                <{/if}>
                                                            </td>
                                                            <td><{date('Y-m-d H:i:s',$item['cr_receive_time'])}></td>
                                                            <td><{if $item['cr_used_time']}><{date('Y-m-d H:i:s',$item['cr_used_time'])}><{/if}></td>
                                                            <td>
                                                                <{if $item['currStatus'] == 1}>
                                                                <span>已使用</span>
                                                                <{elseif $item['currStatus'] == 0}>
                                                                <span style="color: #008cf6">未使用</span>
                                                                <{else}>
                                                                <span style="color: red">已失效</span>
                                                                <{/if}>
                                                            </td>
                                                            <td>
                                                                <{if $item['cl_end_time']}>
                                                                <{date('Y-m-d H:i:s',$item['cl_end_time'])}>
                                                                <{/if}>
                                                            </td>
                                                        </tr>
                                                        <{/foreach}>
                                                    </tbody>
                                                </table>
                                                <div class="page-part-wrap"><{$paginator}></div>
                                            </div><!-- /.table-responsive -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 增加积分 -->
<div class="modal fade" id="pointModal" tabindex="-1" role="dialog" aria-labelledby="pointModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <input type="hidden" id="point_mid" >
            <input type="hidden" id="point_type" value="">
            <input type="hidden" id="point_now" value="">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="pointModalLabel">
                    积分
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row point-operate" style="display: none">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>操作：</label>
                        <div class="col-sm-8">
                            <div class="radio-box">
                            <span>
                                <input type="radio" name="operatePoint" id="addPoint" value="1" checked="checked">
                                <label for="addPoint">增加</label>
                            </span>
                                <span>
                                <input type="radio" name="operatePoint" id="reducePoint" value="0">
                                <label for="reducePoint">扣除</label>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>积分：</label>
                        <div class="col-sm-8">
                            <input id="point" class="form-control" placeholder="请填写积分数值" style="height:auto!important" type="number"/>
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">备注：</label>
                        <div class="col-sm-8">
                            <textarea name="point-remark" id="point_remark" cols="30" rows="3" placeholder="请填写备注" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>密码：</label>
                        <div class="col-sm-8">
                            <input type="password" autocomplete="off" id="point_pwd" class="form-control" placeholder="请填写登录密码" style="height:auto!important" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-blueoutline" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-blue savePoint">保存</button>
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
                    收支导出
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;margin-bottom: 45px">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/member/importRecharge" method="post">
                        <div class="form-group" style="height: 25px">
                            <label class="col-sm-2 control-label">开始日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入开始日期"/>
                            </div>
                            <label class="col-sm-2 control-label">开始时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker1" name="startTime" placeholder="请输入开始时间"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" style="height: 45px">
                            <label class="col-sm-2 control-label">结束日期</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入结束日期"/>
                            </div>
                            <label class="col-sm-2 control-label">结束时间</label>
                            <div class="col-sm-4 bootstrap-timepicker">
                                <input class="form-control" type="text" autocomplete="off"  id="timepicker2" name="endTime" placeholder="请输入结束时间"/>
                            </div>
                        </div>

                        <button type="button" class="btn btn-blueoutline" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-blue" role="button">导出</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--该店铺交易明细-->
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
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
    });


    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });

    //增加积分模态框点击
    $('.point-btn').on('click',function(){
        var mid = $(this).data('mid');
        var type = $(this).data('type');
        var pointNow = $(this).data('point_now');
        //批量增加
        if(type == 'multi'){
            $(".point-operate").css('display','none');
            var ids = get_select_all_ids_array_by_name('ids');
            if(ids.length == 0){
                layer.msg('请选择用户');
                return false;
            }
        }else{
            $(".point-operate").css('display','');
        }
        $('#point_mid').val(mid);
        $('#point_type').val(type);
        $('#point_now').val(pointNow);
        $('#point').val('');
        $('#point_remark').val('');
        $('#point_pwd').val('');
    });

    //管理员增加积分
    $('.savePoint').on('click',function(){
        var mid    = $('#point_mid').val();
        var type   = $('#point_type').val();
        var point  = $('#point').val();
        var pointNow = $('#point_now').val();
        var remark = $('#point_remark').val();
        var pwd    = $('#point_pwd').val();
        var operate= $("input[name='operatePoint']:checked").val();
        if(!pwd){
            layer.msg('请填写登录密码');
            return false;
        }

        if(operate == 0 && pointNow < point){
            layer.msg('扣除积分需小于当前积分');
            return false;
        }

        var data = {
            'mid'     : mid,
            'point'   : point,
            'remark'  : remark,
            'pwd'     : pwd,
            'operate' : operate
        };
        var postUrl = '/wxapp/member/savePoint';
        //批量增加
        if(type == 'multi'){
            var ids    = get_select_all_ids_array_by_name('ids');
            if(ids.length > 0){
                data.ids = ids;
            }else{
                layer.msg('请选择会员');
                return false;
            }
            postUrl = '/wxapp/member/saveMultiPoint';
        }
        
        var index = layer.load(10, {
            shade: [0.6,'#666']
        });
        $.ajax({
            type  : 'post',
            url   : postUrl,
            data  : data,
            dataType  : 'json',
            success : function (json_ret) {
                layer.close(index);
                layer.msg(json_ret.em);
                if(json_ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });
</script>
