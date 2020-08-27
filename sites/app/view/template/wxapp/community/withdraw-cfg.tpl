<style>
    .table.table-avatar tbody>tr>td{
        line-height: 48px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0关闭";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
</style>
<div id="mainContent" >
    <div class="row">
        <div class="col-sm-9" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-money bigger-110"></i>
                            提现配置
                        </a>
                    </li>
                </ul>

                <div class="tab-content form-horizontal">
                    <!--提现信息配置-->
                    <div id="home" class="tab-pane in active">
                        <div id="wxCfg" class="tab-pane">
                            <input type="hidden" name="cfg_id" id="cfg_id" value="0"/>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现最低额度限制</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="aci_withdraw_limit" id="aci_withdraw_limit" value="<{if $row}><{$row['aci_withdraw_limit']}><{/if}>" placeholder="提现最低额度">
                                </div>
                            </div>
                            <!--<div class="space-4"></div>
                            新增提现手续百分比
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现手续费百分比（单位%）</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="wc_rate" id="wc_rate" value="<{if $row}><{$row['wc_rate']}><{/if}>" placeholder="提现手续费百分比">
                                </div>
                                <div style="font-size: 12px;color: #999;margin-top: 2px;margin-left:27%;">
                                    提示:如果不填或者为0，则说明提现不收取手续费。如要设置手续费百分比为5%,填写为5即可
                                </div>
                            </div>
                            -->
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现说明</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="aci_shop_withdraw_introduce" name="aci_shop_withdraw_introduce"><{if $row}><{$row['aci_shop_withdraw_introduce']}><{/if}></textarea>
                                </div>
                            </div>
                            <div class="space"></div>
                            <!--
                            <h4 class="lighter">
                                <i class="icon-hand-right icon-animated-hand-pointer blue"></i>
                                提现
                            </h4>
                            -->
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">线下银行卡提现</label>
                                <label class="" id="choose-yesno" >
                                    <input name="aci_shop_bank" class="ace ace-switch ace-switch-5" id="aci_shop_bank" <{if $row && $row['aci_shop_bank']}>checked<{/if}> type="checkbox">
                                    <span class="lbl">　提现到银行卡，需线下转账</span>
                                </label>
                            </div>
                            <{if $menuType != 'toutiao'}>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">微信零钱提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="aci_shop_wxbalance" class="ace ace-switch ace-switch-5" id="aci_shop_wxbalance" <{if $row && $row['aci_shop_wxbalance']}>checked<{/if}> type="checkbox">
                                    <span class="lbl">　通过线上直接提现到微信零钱</span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">微信银行卡提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="aci_shop_wxbank" class="ace ace-switch ace-switch-5" id="aci_shop_wxbank" <{if $row && $row['aci_shop_wxbank']}>checked<{/if}> type="checkbox">
                                    <span class="lbl">　通过线上直接提现到银行卡</span>
                                </label>
                            </div>

                            <{else}>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">支付宝提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="aci_shop_zfb" class="ace ace-switch ace-switch-5" id="aci_shop_zfb" <{if $row && $row['aci_shop_zfb']}>checked<{/if}> type="checkbox">
                                    <span class="lbl">　通过线上直接提现到支付宝账号</span>
                                </label>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">提现时间限制</label>
                                <label class="" id="choose-yesno">
                                    <input name="aci_time_limit" class="ace ace-switch ace-switch-5" id="aci_time_limit" <{if $row && $row['aci_time_limit']}>checked<{/if}> type="checkbox" onclick="limitShow()" >
                                    <span class="lbl" onclick="limitShow()" >　开启时间限制后，只能在限制时间内提现</span>
                                </label> 
                            </div>

                            <div class="form-group" id="limit-time-div" style="display: none;">
                                <label for="inputEmail3" class="col-sm-3 control-label">每月</label>
                                <div class="col-sm-1">
                                    <input type="number" class="form-control" name="aci_time_start" id="aci_time_start" value="<{if $row && $row['aci_time_start']}><{$row['aci_time_start']}><{/if}>" placeholder="">
                                </div>
                                <label class="col-sm-1 control-label" style="width: 60px;">号&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;到</label>
                                <div class="col-sm-1">
                                    <input type="number" class="form-control" name="aci_time_end" id="aci_time_end" value="<{if $row && $row['aci_time_end']}><{$row['aci_time_end']}><{/if}>" placeholder="">
                                </div>
                                <label class=" control-label">号  </label> 
                            </div>

                            <{/if}>
                </div>

            </div>
            <!-----提交操作---->
            <div class="form-group">
                <div class="center">
                    <button class="btn btn-sm btn-primary"  onclick="save()"> &nbsp; 保 &nbsp; 存 &nbsp; </button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<script src="/public/plugin/layer/layer.js" type="text/javascript"></script>
<script>
    $(function() {
        limitShow();
    });

    function save(){
        var aci_shop_bank                = $('input[name="aci_shop_bank"]:checked').val();        //线下银行卡提现
        var aci_shop_wxbalance           = $('input[name="aci_shop_wxbalance"]:checked').val();   //微信零钱提现
        var aci_shop_wxbank              = $('input[name="aci_shop_wxbank"]:checked').val();      //微信银行卡提现
        var aci_withdraw_limit           = parseInt($('#aci_withdraw_limit').val());                    //最低提现额度
        var aci_shop_withdraw_introduce  = $('#aci_shop_withdraw_introduce').val();               //提现说明
        var aci_shop_zfb                 = $('input[name="aci_shop_zfb"]:checked').val(); //支付宝提现
        var aci_time_limit               = $('input[name="aci_time_limit"]:checked').val(); //提现时间配置

        var aci_shop_bank        = aci_shop_bank == 'on' ? 1: 0;
        var aci_shop_wxbalance   = aci_shop_wxbalance == 'on' ? 1: 0;
        var aci_shop_wxbank      = aci_shop_wxbank == 'on' ? 1: 0;

        var aci_shop_zfb         = aci_shop_zfb == 'on' ? 1:0;
        var aci_time_limit       = aci_time_limit == 'on' ? 1:0;
        var aci_time_start       = $('#aci_time_start').val();
        var aci_time_end         = $('#aci_time_end').val();

        var data = {
                'aci_shop_bank'              : aci_shop_bank,
                'aci_shop_wxbalance'         : aci_shop_wxbalance,
                'aci_shop_wxbank'            : aci_shop_wxbank,
                'aci_withdraw_limit'         : aci_withdraw_limit,
                'aci_shop_withdraw_introduce': aci_shop_withdraw_introduce,
                'aci_shop_zfb'               : aci_shop_zfb,
                'aci_time_limit'             : aci_time_limit,
            };

        if(aci_withdraw_limit < 1){
            layer.msg('提现最低额度限制不得低于1元');
            return ;
        }
        if(aci_time_limit ==1) {
            if(aci_time_start <=0 || aci_time_end <=0) {
                layer.msg('请输入限制限制日期，如10 - 15号');
                return ;
            } 
            data.aci_time_start = aci_time_start;
            data.aci_time_end   = aci_time_end;
        } 

        var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveWithdrawLimit',
                'data'  : data,
                'dataType'  : 'json',
                success : function(response){
                    layer.close(index);
                    layer.msg(response.em,
                        {time: 2000},
                        function() {
                            if(response.ec == 200) {
                                window.location.reload();
                            }
                        }
                    );
                }
            });
    }


    function limitShow() {
        var limit = $('input[name="aci_time_limit"]:checked').val();
        if(limit == undefined) { 
            $('#limit-time-div').hide();
        } else {
            $('#limit-time-div').show();
        }
        
    }
</script>
