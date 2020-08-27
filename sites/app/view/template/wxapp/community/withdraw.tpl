<link rel="stylesheet" href="/public/manage/css/shop-basic.css">
<style>
    .start-endtime{
        overflow: hidden;
    }
    .start-endtime>em{
        float: left;
        line-height: 34px;
        font-style: normal;
    }
    .start-endtime .input-group{
        float: left;
        width:42%;
    }
    .start-endtime .input-group .input-group-addon{
        border-radius: 0 4px 4px 0!important;
    }
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
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
        width: calc(100% / 6);
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


<div class="balance clearfix" style="border:1px solid #e5e5e5;margin-bottom: 20px;">
    <div class="balance-info">
        <div class="balance-title">累计申请提现<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['totalCount']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">累计申请金额<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['totalMoney']}></span>
            <span class="unit">元</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">待审核提现<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['auditCount']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">待审核金额<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['auditMoney']}></span>
            <span class="unit">元</span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">已通过提现<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['passCount']}></span>
        </div>
    </div>
    <div class="balance-info">
        <div class="balance-title">已通过金额<span></span></div>
        <div class="balance-content">
            <span class="money"><{$statInfo['passMoney']}></span>
            <span class="unit">元</span>
        </div>
    </div>
</div>

<div class="page-header">  <!--width:600px;45%;-->
    <div style="display:  inline-block;vertical-align: middle; width: 600px;margin-left:  0px;">
        <{if $appletCfg['ac_type'] != 33}>
        <a href="/wxapp/community/withdrawCfgPage" class="btn btn-green btn-xs"><i class="icon-plus bigger-80"></i> 提现配置</a>
        <!--<div class="input-group" style="width:55%;">
            <div class="input-group-addon">商家最低提现金额</div>
                <input type="number" class="form-control" id="withdrawLimit" value="<{$tpl['aci_withdraw_limit']}>">
                <div class="input-group-addon">元</div>
            <span class="btn btn-blue" id="save-withdraw-limit" style="height: 34px;line-height: 34px;" onclick="changeLimit()">确认修改</span>
            <input type="hidden" id="withdrawLimit_hid" value="<{$tpl['aci_withdraw_limit']}>">
        </div>
        -->
        <{/if}>
      <!--<div class="input-group" style="width:45%;margin-left:300px;margin-top:-34px;">
            <div class="input-group-addon">商家提现手续费百分比</div>
            <input type="number" class="form-control" id="withdrawRate" value="<{$tpl['aci_withdraw_rate']}>" onchange="changeRate()">
            <div class="input-group-addon" style="border-radius: 0 4px 4px 0!important;">%</div>
            <input type="hidden" id="withdrawRate_hid" value="<{$tpl['aci_withdraw_rate']}>">
        </div>
        <span style="font-size: 12px;color: #999;float: left;">(提示:如果不填或者为0，则说明提现不收取手续费。如要设置手续费百分比为5%,填写为5即可)</span>-->


    </div>



<div class="page-header search-box">
    <div class="col-sm-12">
        <form action="/wxapp/community/withdraw" method="get" class="form-inline">
            <div class="col-xs-11 form-group-box">
                <div class="form-container">
                    <input type="hidden" name="audit" value="<{if $audit}><{$audit}><{else}>all<{/if}>">
                    <div class="form-group" style="width:580px;">
                        <div class="input-group" style="width:100%;">
                            <div class="start-endtime">
                                <em style="width:70px;text-align:center">提现时间：</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="start" value="<{$start}>" placeholder="开始时间" id="start-time"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                                <em style="padding:0 3px;">到</em>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="end" value="<{$end}>" placeholder="截止时间" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss'})">
                                    <span class="input-group-addon">
                                        <i class="icon-calendar bigger-110"></i>
                                    </span>
                                </div>
                            </div>
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
    <a href="<{$val['href']}>" <{if $audit eq $val['key']}> class="active" <{/if}>><{$val['label']}></a>
    <{/foreach}>
</div>
<div>
    <div class="table-responsive">
        <table id="sample-table-1" class="table table-hover table-button">
            <thead>
            <tr>
                <th>店铺</th>
                <th>店铺负责人</th>
                <th>提现金额</th>
                <th>目的账户</th>
                <th>账户名</th>
                <th>所属银行</th>
                <th>当前余额</th>
                <th>锁定金额</th>
                <th>处理情况</th>
                <th>处理备注</th>
                <th>提现时间</th>
                <th>审核</th>
            </tr>
            </thead>
            <tbody>
            <{foreach $list as $item}>
                <tr>
                    <td><{$item['es_name']}></td>
                    <td><{$item['es_contact']}></td>
                    <td><{$item['esw_amount']}></td>
                    <td>
                        <{if $item['esw_withdraw_type'] == 1 && $item['esw_bank_id'] > 0}><{$item['esb_bank_card']}>
                        <{elseif $item['esw_withdraw_type'] == 2}>微信余额
                        <{elseif $item['esw_withdraw_type'] == 3}><{$item['esw_withdraw_bank']}>
                        <{else}> <{$item['esw_zfb_account']}>
                        <{/if}>
                            
                    </td>
                    <td>
                        <{if $item['esw_withdraw_type'] == 1 && $item['esw_bank_id'] > 0}>
                        <{$item['esb_bank_user']}>
                        <{else}>
                        <{$item['esw_withdraw_name']}>
                        <{/if}>
                            
                    </td>
                    <td>
                        <!--<{$item['esb_bank_branch']}>-->
                        <{if $item['esw_withdraw_type'] == 1 || $item['esw_bank_id'] > 0}><{$item['esb_bank_branch']}>
                        <{elseif $item['esw_withdraw_type'] == 2}>微信余额
                        <{elseif $item['esw_withdraw_type'] == 3}><{$withdraw_bank_ids[$item['esw_bank_type']]}>
                        <{else}> 支付宝账户
                        <{/if}>
                    </td>
                    <td><{$item['es_balance']}></td>
                    <td><{$item['es_not_available']}></td>
                    <td>
                        <!--
                        <{$status[$item['esw_status']]}>
                        -->
                        <span class="<{$statusNew[$item['esw_status']]['class']}>"><{$statusNew[$item['esw_status']]['name']}></span>

                    </td>
                    <td><{$item['esw_audit_note']}></td>
                    <td><{if $item['esw_create_time']}><{date('Y-m-d H:i',$item['esw_create_time'])}><{/if}></td>
                    <td>
                        <{if $item['esw_status'] == 0}>
                        <a href="javascript:;" onclick="withdrawAudit('<{$item['esw_id']}>','<{$item['esw_status']}>','<{$item['esw_audit_note']}>')" class="btn btn-xs btn-warning">审核</a>
                        <{/if}>
                    </td>
                </tr>
                <{/foreach}>
            <tr><td colspan="12"><{$pageHtml}></td></tr>
            </tbody>
        </table>
    </div><!-- /.table-responsive -->
</div>

<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="mod-title"></h4>
            </div>
            <div class="modal-body" style="min-height: 250px;">
                <form >
                    <div class="form-group" >
                        <input type="hidden" id="type" value="audit">
                        <input type="hidden" id="hid_id" value="0">
                    </div>
                    <div class="form-group auth" style="width: 300px;margin: -15px 30px 0 130px">
                        <label for="exampleInputEmail1">审核</label>
                        <select name="withdraw_status" id="withdraw_status" style="width: 100%;height: 35px">
                            <option value="0">进行中</option>
                            <option value="1">通过</option>
                            <option value="2">拒绝</option>
                        </select>
                    </div>
                    <div class="form-group audit" style="width: 300px;margin: 0 130px">
                        <label for="exampleInputEmail1">审核备注</label>
                        <textarea id="audit_note" rows="6" style="width: 100%" autocomplete="off"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="withdraw-confirm" onclick="saveWithdrawAudit()">保存</button>
            </div>
        </div>
    </div>
</div>
<!-----该店铺交易明细------>
<script src="/public/plugin/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $(function(){
        /*初始化搜索栏宽度*/
        var sumWidth = 200;
        var groupItemWidth=0;
        $(".form-group-box .form-container .form-group").each(function(){
            groupItemWidth=Number($(this).outerWidth(true));
            sumWidth +=groupItemWidth;
        });
        $(".form-group-box .form-container").css("width",sumWidth+"px");
        
    });

    //提现审核
    function withdrawAudit(id,status,note){
        //模拟态弹框显示前，所做的处理
        if(id){
            $("#hid_id").val(id);
            $("#withdraw_status").val(status);
            $("#audit_note").val(note);
            $('.audit').show();
            $('#mod-title').html('提现审核');
            $('#type').val('audit');
            //显示模拟态弹框
            $('#myModal').modal();
        }
    }

    function saveWithdrawAudit(){
        var id = $("#hid_id").val();
        var status = $("#withdraw_status").val();
        var note = $("#audit_note").val();
        $('#withdraw-confirm').attr('disabled','disabled');
        if(id && status){
            var data = {
                'id'     : id,
                'status' : status,
                'note'   : note
            };
            $.ajax({
                'type' : 'post',
                'url'  : '/wxapp/community/auditWithdraw',
                'data' : data,
                'dataType' : 'json',
                'success'  : function(result){
                    $('#myModal').modal('hide');
                    layer.msg(result.em,{ time:2000 },function(){
                        if(result.ec == 200){
                            window.location.reload();
                        }else{
                            $('#withdraw-confirm').removeAttr('disabled');
                        }
                    });
                }
            });

        }
    }
    /*
    保存提现金额
     */
    function changeLimit() {
        var withdrawLimit   = $('#withdrawLimit').val();
        var oldLimit = $('#withdrawLimit_hid').val();
        if(withdrawLimit <= 1){
            layer.msg('提现金额最低1元');
            $('#withdrawLimit').val(oldLimit);
            return;
        }
        //没有修改 直接保存成功
        if(withdrawLimit == oldLimit){
            layer.msg('保存成功');
            return;
        }

        console.log(withdrawLimit);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/saveWithdrawLimit',
            'data'  : { aci_withdraw_limit : withdrawLimit },
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    $('#withdrawLimit_hid').val(withdrawLimit);
                    layer.msg(ret.em);
                }else{
                    layer.msg(ret.em);
                    $('#withdrawLimit').val(oldLimit);
                }

            }
        });
    }
    /*
      保存提现百分比设置
     */
    function changeRate() {
        var withdrawRate   = $('#withdrawRate').val();
        var oldRate = $('#withdrawRate_hid').val();
        if(withdrawRate < 0){
            layer.msg('提现手续费百分比必须大于等于0');
            $('#withdrawRate').val(oldRate);
            return;
        }
        if(withdrawRate>=100){
            layer.msg('提现手续费百分比必须是介于0到100之间的数');
            $('#withdrawRate').val(oldRate);
            return;
        }
        console.log(withdrawRate);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/community/saveWithdrawRate',
            'data'  : { rate : withdrawRate },
            'dataType'  : 'json',
            'success'   : function(ret){
                if(ret.ec == 200){
                    $('#withdrawRate_hid').val(withdrawRate);
                    console.log(ret.em);
                }else{
                    layer.msg(ret.em);
                    $('#withdrawRate').val(oldRate);
                }

            }
        });
    }
</script>

