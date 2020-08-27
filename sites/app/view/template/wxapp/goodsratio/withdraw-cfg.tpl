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
<{include file="../common-second-menu.tpl"}>
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
                                    <input type="number" class="form-control" name="wc_min" id="wc_min" value="<{if $row}><{$row['wc_min']}><{/if}>" placeholder="提现最低额度">
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <!--新增提现手续百分比-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现手续费百分比（单位%）</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="wc_rate" id="wc_rate" value="<{if $row}><{$row['wc_rate']}><{/if}>" placeholder="提现手续费百分比">
                                </div>
                                <div style="font-size: 12px;color: #999;margin-top: 2px;margin-left:27%;">
                                    提示:如果不填或者为0，则说明提现不收取手续费。如要设置手续费百分比为5%,填写为5即可
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现说明</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" rows="3" id="wc_desc" name="wc_desc"><{if $row}><{$row['wc_desc']}><{/if}></textarea>
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
                                <label for="inputEmail3" class="col-sm-3 control-label">微信零钱提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="wc_wx_open" onchange="checkChange('wc_wx_open')" class="ace ace-switch ace-switch-5" id="wc_wx_open" <{if $row && $row['wc_change_open']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                            <div class="form-group" id="wx_open" <{if !$row['wc_change_open']}>style="display:none"<{/if}>>
                            <label for="inputEmail3" class="col-sm-3 control-label"></label>
                            <label class="" id="choose-yesno" style="margin-left: -60px;">
                                <div class="form-group" style="width: 200px;">
                                    <label for="inputEmail3" class="col-sm-8 control-label">是否填写手机号</label>
                                    <label class="" id="choose-yesno">
                                        <input name="wc_wxmobile_open" class="ace ace-switch ace-switch-5" id="wc_wxmobile_open" <{if $row && $row['wc_mobile_open']}>checked<{/if}> type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                                <div class="form-group" style="width: 200px;">
                                    <label for="inputEmail3" class="col-sm-8 control-label">是否填写账号</label>
                                    <label class="" id="choose-yesno">
                                        <input name="wc_wxaccount_open" class="ace ace-switch ace-switch-5" id="wc_wxaccount_open" <{if $row && $row['wc_account_open']}>checked<{/if}> type="checkbox">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </label>
                        </div>
                        <!--
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">微信红包活动名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="wc_wx_actname" id="wc_wx_actname" value="<{if $row}><{$row['wc_wx_actname']}><{/if}>" placeholder="微信红包活动名">
                                </div>
                            </div>
                            -->
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">银行卡提现</label>
                            <label class="" id="choose-yesno" >
                                <input name="wc_bank_open"  onchange="checkChange('wc_bank_open')" class="ace ace-switch ace-switch-5" id="wc_wx_open" <{if $row && $row['wc_bank_open']}>checked<{/if}> type="checkbox">
                                <span class="lbl"></span>
                            </label>
                        </div>
                        <div class="form-group" id="bank_open" <{if !$row['wc_bank_open']}>style="display:none"<{/if}>>
                        <label for="inputEmail3" class="col-sm-3 control-label"></label>
                        <label class="" id="choose-yesno" style="margin-left: -60px;">
                            <div class="form-group" style="width: 200px;">
                                <label for="inputEmail3" class="col-sm-8 control-label">是否填写手机号</label>
                                <label class="" id="choose-yesno">
                                    <input name="wc_bank_mobile_open" class="ace ace-switch ace-switch-5" id="wc_bank_mobile_open" <{if $row && $row['wc_bank_mobile_open']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </label>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">自动提现</label>
                        <label class="" id="choose-yesno">
                            <input name="wc_auto" class="ace ace-switch ace-switch-5" id="wc_auto" <{if $row && $row['wc_auto']}>checked<{/if}> type="checkbox">
                            <span class="lbl"></span>
                        </label>
                    </div>
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

    function checkChange(name){
        if($('input[name="'+name+'"]:checked').val()=='on'){
            $('#'+name.substring(3)).show();
        }else{
            $('#'+name.substring(3)).hide();
        }
    }

    function save(){
        var open            = $('input[name="wc_wx_open"]:checked').val();
        var openBank        = $('input[name="wc_bank_open"]:checked').val();
        var auto            = $('input[name="wc_auto"]:checked').val();
        var wxmobile_open   = $('input[name="wc_wxmobile_open"]:checked').val();
        var wxaccount_open  = $('input[name="wc_wxaccount_open"]:checked').val();
        var bankmobile_open = $('input[name="wc_bank_mobile_open"]:checked').val();
        var wc_min          = parseInt($('#wc_min').val());
        var wc_desc         = $('#wc_desc').val();
        //var wc_wx_actname   = $('#wc_wx_actname').val();
        var wc_bank_open = openBank == 'on' ? 1: 0;
        var wc_wx_open = open == 'on' ? 1: 0;
        var wc_auto = auto == 'on' ? 1: 0;
        var wc_mobile_open = wxmobile_open == 'on' ? 1: 0;
        var wc_account_open = wxaccount_open == 'on' ? 1: 0;
        var wc_bank_mobile_open = bankmobile_open == 'on' ? 1: 0;
        //新增提现手续费百分比
        var wc_rate       = $('#wc_rate').val();
        if(wc_min < 1){
            layer.msg('提现最低额度限制不得低于1元');
        }else{
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            });
            var data = {
                'wc_desc'           : wc_desc,
                'wc_wx_open'        : wc_wx_open,
                'wc_bank_open'      : wc_bank_open,
                'wc_min'            : wc_min,
                'wc_auto'           : wc_auto,
                'wc_mobile_open'   : wc_mobile_open,
                'wc_account_open'  : wc_account_open,
                'wc_bank_mobile_open': wc_bank_mobile_open,
                'wc_rate'            : wc_rate
            };

            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/goodsratio/saveWithdrawCfg',
                'data'  : data,
                'dataType'  : 'json',
                success : function(response){
                    layer.close(index);
                    layer.msg(response.em);
                }
            });
        }
    }
</script>
