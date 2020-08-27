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
<div>

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
                                <label class="col-sm-3 control-label">提现最低额度</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="emwc_min" id="emwc_min" value="<{if $row}><{$row['emwc_min']}><{/if}>" placeholder="提现最低额度0表示不限制">
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <!--新增提现手续百分比-->
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现抽成百分比（单位%）</label>
                                <div class="col-sm-9">
                                    <input type="number" class="form-control" name="emwc_rate" id="emwc_rate" value="<{if $row}><{$row['emwc_rate']}><{/if}>" placeholder="提现手续费百分比">
                                </div>
                                <div style="font-size: 12px;color: #999;margin-top: 2px;margin-left:27%;">
                                    提示:如果不填或者为0，则说明提现不收取抽成。如要设置抽成百分比为5%,填写为5即可
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">提现说明</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" style="width:100%;height:300px;" id = "emwc_rule" name="emwc_rule" placeholder="提现说明"  rows="20" style=" text-align: left;" ><{if $row['emwc_desc']}><{$row['emwc_desc']}><{/if}></textarea>
                                </div>
                            </div>
                            <div class="space"></div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">微信提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="emwc_wx_open" class="ace ace-switch ace-switch-5" id="emwc_wx_open" <{if $row && $row['emwc_wx_open']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">支付宝提现</label>
                                <label class="" id="choose-yesno" >
                                    <input name="emwc_zfb_open" class="ace ace-switch ace-switch-5" id="emwx_zfb_open" <{if $row && $row['emwc_zfb_open']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">银行卡提现</label>
                                <label class="" id="choose-yesno">
                                    <input name="emwc_bank_open" class="ace ace-switch ace-switch-5" id="emwc_bank_open" <{if $row && $row['emwc_bank_open']}>checked<{/if}> type="checkbox">
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

//    function checkChange(name){
//        if($('input[name="'+name+'"]:checked').val()=='on'){
//            $('#'+name.substring(3)).show();
//        }else{
//            $('#'+name.substring(3)).hide();
//        }
//    }

    function save(){
        var openWx            = $('input[name="emwc_wx_open"]:checked').val();
        var openBank        = $('input[name="emwc_bank_open"]:checked').val();
        var openZfb        = $('input[name="emwc_zfb_open"]:checked').val();
        var emwc_zfb_open = openZfb == 'on' ? 1: 0;
        var emwc_wx_open = openWx == 'on' ? 1: 0;
        var emwc_bank_open = openBank == 'on' ? 1: 0;
        var rate       = $('#emwc_rate').val();
        var min  = $('#emwc_min').val();
        var rule          = $('#emwc_rule').val();
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        });
        var data = {
            'rate':rate,
            'min':min,
            'rule':rule,
            'openZfb':emwc_zfb_open,
            'openWx':emwc_wx_open,
            'openBank':emwc_bank_open
        };
        
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/sequence/saveManagerWithdrawCfg',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(index);
                layer.msg(response.em);
            }
        });
    }
</script>
