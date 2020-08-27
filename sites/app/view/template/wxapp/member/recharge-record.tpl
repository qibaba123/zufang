<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    .datepicker{
        z-index: 1060 !important;
    }
    .ui-table-order .time-cell{
        width: 120px !important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    table tr th,table tr td{
        text-align: center;
    }
    .remark{
        min-width: 250px;
        max-width: 400px;
        overflow: hidden;
        white-space: normal !important;
        vertical-align:middle;
        text-align: left;
    }
    .nav-tabs{z-index:1;}
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
</style>
<div>
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <!--
                    <li >
                        <a href="/wxapp/member/rechargeChange">
                            <i class="green icon-cog bigger-110"></i>
                            充值配置
                        </a>
                    </li>
                    -->
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-th-large bigger-110"></i>
                            充值记录
                        </a>
                    </li>
                    <li>
                        <a  href="/wxapp/member/cfg">
                            <i class="green icon-cog bigger-110"></i>
                            充值配置
                        </a>
                    </li>
                    <{if $applet['ac_type'] == 21}>
                    <li>
                        <a  href="/wxapp/member/rechargeRight">
                            <i class="green icon-cog bigger-110"></i>
                            充值权益
                        </a>
                    </li>
                    <{/if}>
                </ul>

                <div class="tab-content">
                    <{if in_array($appletCfg['ac_type'],$allowType)}>
                    <div class="alert alert-block alert-yellow ">
                        <button type="button" class="close" data-dismiss="alert">
                            <i class="icon-remove"></i>
                        </button>
                        <{$otherTip['recharge']}>
                    </div>
                    <{/if}>

                    <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>充值记录导出</a>
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>订单编号</th>
                                    <th>会员昵称</th>
                                    <th>支付金额</th>
                                    <th>获得金额</th>
                                    <th>支付方式</th>
                                    <th>备注</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        创建时间
                                    </th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $item}>
                                    <tr id="tr_id_<{$item['rr_id']}>">
                                        <td><{$item['rr_tid']}></td>
                                        <td><{$item['m_nickname']}></td>
                                        <td><{$item['rr_amount']}></td>
                                        <td><{$item['rr_gold_coin']}></td>
                                        <td>
                                            <{if $item['rr_pay_type'] == 1}>
                                            微信支付
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 2}>
                                            余额支付
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 3}>
                                            充值码充值
                                            <{/if}>
                                             <{if $item['rr_pay_type'] == 4}>
                                            管理员充值
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 10}><!-- 跑腿订单 -->
                                            订单退款
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 11}>
                                            红包收入
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 13}>
                                            会员卡赠送
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 14}>
                                            订单关闭退还
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 15}><!-- 普通订单退款 -->
                                            订单退款
                                            <{/if}>
                                            <{if $item['rr_pay_type'] == 18}><!-- 普通订单退款 -->
                                            收银台退款
                                            <{/if}>
                                        </td>
                                        <td class="remark">
                                            <p>
                                                <{$item['rr_remark']}>
                                            </p>
                                            <{if $item['rr_pay_type'] == 4 && $item['manager_id'] >0}>
                                            <p>
                                                <span style="color: blue;">管理员：</span><{$item['manager_name']}>&nbsp;<{$item['manager_mobile']}>
                                            </p>
                                            <{/if}>
                                        </td>
                                        <td><{date('Y-m-d H:i:s',$item['rr_create_time'])}></td>
                                    </tr>
                                    <{/foreach}>
                                    <tr><td colspan="7" class='text-right'><{$paginator}></td></tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
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

                        <button type="button" class="btn btn-normal" data-dismiss="modal" style="margin-right: 30px">取消</button>
                        <button type="submit" class="btn btn-primary" role="button">导出</button>
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
</script>
