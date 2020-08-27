<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<link rel="stylesheet" href="/public/manage/assets/css/datepicker.css">
<link rel="stylesheet" type="text/css" href="/public/manage/assets/css/bootstrap-timepicker.css">
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
    .datepicker { z-index: 1060 !important; }
    .balance .balance-info{
        <{if $cardtype != 2}>
        width: 20% !important;
        <{else}>
        width: 33.33% !important;
        <{/if}>

    }
    .nav-tabs{z-index: 1;}
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
    .table>thead>tr.success>th{background-color:#f8f8f8;border-color: #f8f8f8;border-right: 1px solid #ddd;border-bottom: 1px solid #ddd;}
</style>
<div  id="content-con" >
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <{include file="./tabal-link.tpl"}>
            <div class="tab-content"  style="z-index:1;">
                <!-- 汇总信息 -->
                <div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
                    <div class="balance-info">
                        <div class="balance-title">总会员数<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['total']}></span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">未到期<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['noexpire']}></span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">已到期<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['expire']}></span>
                        </div>
                    </div>
                    <{if $cardtype != 2}>
                    <div class="balance-info">
                        <div class="balance-title">未用完<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['used']}></span>
                        </div>
                    </div>
                    <div class="balance-info">
                        <div class="balance-title">已用完<span></span></div>
                        <div class="balance-content">
                            <span class="money"><{$statInfo['left']}></span>
                        </div>
                    </div>
                    <{/if}>
                </div>
                <div class="page-header search-box">
                    <div class="col-sm-12">
                        <form action="/wxapp/membercard/memberCard/type/<{$cardtype}>" method="get" class="form-inline">
                            <div class="col-xs-11 form-group-box">
                                <div class="form-container">
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员卡号：</div>
                                            <input type="text" class="form-control" name="card" value="<{$card}>" placeholder="会员卡号">
                                        </div>
                                    </div>
                                    <{if $appletCfg['ac_type'] != 28}>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">会员昵称：</div>
                                            <input type="text" class="form-control" name="nickname" value="<{$nickname}>" placeholder="会员昵称">
                                        </div>
                                    </div>
                                    <{/if}>
                                    <div class="form-group ">
                                        <div class="input-group">
                                            <div class="input-group-addon">手机号：</div>
                                            <input type="text" class="form-control" name="mobile" value="<{$mobile}>" placeholder="会员手机号">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-1 pull-right search-btn">
                                <button type="submit" class="btn btn-green btn-sm search-btn">查询</button>
                            </div>
                        </form>
                    </div>
                </div>
                <{if $cardtype eq 1}>
                <a href="javascript:;" class="btn btn-green btn-xs btn-excel" style="margin-bottom: 10px"><i class="icon-download"></i>会员导出</a>
                <{/if}>
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <!--------------会员卡购买记录列表---------------->
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <{if $appletCfg['ac_type'] == 28}>
                                    <th>公司名称</th>
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] != 28}>
                                    <th>会员昵称</th>
                                    <th>手机号</th>
                                    <{/if}>
                                    <th>会员卡号</th>
                                    <th>到期时间</th>
                                    <{if $cardtype eq 1}>
                                    <th>状态</th>
                                    <{if $curr_shop['s_id'] == 10380}>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <th>公司</th>
                                    <th>职位</th>
                                    <{/if}>
                                    <th>可消费次数</th>
                                    <th>操作</th>
                                    <{/if}>
                                    <{if $cardtype eq 2}>
                                    <{if $appletCfg['ac_type'] != 28}>
                                    <th>姓名</th>
                                    <th>性别</th>
                                    <th>生日</th>
                                    <{/if}>
                                    <{if $curr_shop['s_id'] == 10380}>
                                    <th>公司</th>
                                    <th>职位</th>
                                    <{/if}>
                                    <{/if}>
                                    <!--
                                    <{if $appletCfg['ac_type'] == 8}>
                                    <th>备注</th>
                                    <{/if}>
                                    -->
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                <tr class="oo_id_<{$val['oo_id']}>">
                                    <{if $appletCfg['ac_type'] == 28}>
                                    <th><{$val['ajc_company_name']}></th>
                                    <{/if}>
                                    <{if $appletCfg['ac_type'] != 28}>
                                    <td><{$val['m_nickname']}></td>
                                    <td><{if $cardtype == 1 || $curr_shop['s_id'] == 10380}><{$val['m_mobile']}><{else}><{$val['oo_telphone']}><{/if}></td>
                                    <{/if}>
                                    <td><{$val['om_card_num']}></td>
                                    <td><{date("Y.m.d",$val['om_expire_time'])}></td>
                                    <{if $cardtype eq 1}>
                                    <td><{if $val['om_expire_time'] <= time()}>
                                         <span class="label label-sm label-default">已到期</span>
                                        <{elseif $val['om_left_num'] == 0}>
                                        <span class="label label-sm label-default">已消费完</span>
                                        <{else}>
                                        <span class="label label-sm label-success">正常使用中</span>
                                        <{/if}></td>
                                    <{if $curr_shop['s_id'] == 10380}>
                                    <td>
                                        <{$val['oo_name']}>
                                    </td>
                                    <td>
                                        <{if $val['oo_gender']==0}>女<{else}>男<{/if}>
                                    </td>
                                    <td>
                                        <{$val['oo_birthday']}>
                                    </td>
                                    <td><{$val['oo_company']}></td>
                                    <td><{$val['oo_position']}></td>
                                    <{/if}>
                                    <td>
                                        <{$val['om_left_num']}>次
                                    </td>
                                    <td><a href="/wxapp/membercard/verify?mid=<{$val['m_id']}>" >消费记录</a></td>
                                    <{/if}>
                                    <{if $cardtype eq 2}>
                                    <{if $appletCfg['ac_type'] != 28}>
                                    <td>
                                        <{$val['oo_name']}>
                                    </td>
                                    <td>
                                        <{if $val['oo_gender']==0}>女<{else}>男<{/if}>
                                    </td>
                                    <td>
                                        <{$val['oo_birthday']}>
                                    </td>
                                    <{/if}>
                                    <{if $curr_shop['s_id'] == 10380}>
                                    <td><{$val['oo_company']}></td>
                                    <td><{$val['oo_position']}></td>
                                    <{/if}>
                                    <{/if}>
                                    <!--
                                    <{if $appletCfg['ac_type'] == 8}>
                                    <td style="max-width: 300px;overflow: hidden;white-space: normal">
                                        <{$val['oo_remark']}>
                                    </td>
                                    <{/if}>
                                    -->
                                    <td>
                                        <a href="javascript:void(0);" data-id="<{$val['om_id']}>" class="btn-delete-mem-card" style="color:#f00;">删除</a>
                                    </td>
                                </tr>
                                <{/foreach}>
                                <tr><td colspan="10"><{$pageHtml}></td></tr>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<div class="modal fade" id="excelOrder" tabindex="-1" role="dialog" style="display: none;" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 700px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="excelOrderLabel">
                    导出会员
                </h4>
            </div>
            <div class="modal-body" style="overflow: auto;text-align: center;">
                <div class="modal-plan p_num clearfix shouhuo">
                    <form enctype="multipart/form-data" action="/wxapp/membercard/importMemberCard" method="post">
                        <div class="form-group" style="height: 30px;">
                            <label class="col-sm-3 control-label">到期时间开始</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off" type="text" id="startDate" data-date-format="yyyy-mm-dd" name="startDate" placeholder="请输入会员到期日期"/>
                            </div>
                        </div>
                        <div class="space"></div>
                        <div class="form-group" style="height: 30px;margin-bottom: 30px">
                            <label class="col-sm-3 control-label">到期时间截止</label>
                            <div class="col-sm-4">
                                <input class="form-control date-picker" autocomplete="off"  type="text" id="endDate" data-date-format="yyyy-mm-dd" name="endDate" placeholder="请输入会员到期日期"/>
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
<script src="/public/plugin/layer/layer.js"></script>
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
       //删除会员卡
        $('.btn-delete-mem-card').on('click',function(){
            var id = $(this).data('id');
            if(id > 0){
                var data = { id:id };
                layer.confirm('确认要删除该会员卡会员？', {
                    btn: ['删除', '取消']
                }, function(){
                    $.ajax({
                        url : '/wxapp/membercard/deleteMemberCard',
                        type: 'post',
                        data : data,
                        dataType : 'json',
                        success : function(ret){
                            layer.msg(ret.em,{ time: 2000 },function(){
                                if(ret.ec == 200){
                                    window.location.reload();
                                }
                            });
                        }
                    });
                });
            }
        });
    });

    //订单导出按钮
    $('.btn-excel').on('click',function(){
        $('#excelOrder').modal('show');
    });
</script>