<style>
    #warn_open input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开通 \a0\a0\a0\a0\a0\a0\a0\a0\a0\a0\a0暂不开通";
    }
    #warn_open input[type=checkbox].ace.ace-switch{
        margin:0;
        width: 100px;
        height: 30px;
    }
    #warn_open input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before,#warn_open input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        line-height: 30px;
        height: 31px;
        width: 100px;
    }
    #warn_open input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after,#warn_open input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after{
        left: 70px;
    }
    #warn_open input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after,#warn_open input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after {
        width: 29px;
        height: 29px;
        line-height: 29px;
    }

</style>
<div  id="mainContent">
    <div class="row">
        <div class="col-sm-12" style="max-width:1000px;margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li class="active">
                        <a data-toggle="tab" href="#home">
                            <i class="green icon-cog bigger-110"></i>
                            短信余额不足提醒
                        </a>
                    </li>
                </ul>
                <div class="tab-content form-horizontal">
                    <!--分销配置-->
                    <div id="home" class="tab-pane in active">
                        <div id="wxCfg" class="tab-pane">
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 control-label">是否开启短信余额不住提醒</label>
                                <label class="check-label" id="warn_open">
                                    <input class="ace ace-switch ace-switch-5" id="warn_open" name="warn_open" <{if $row && $row['sc_warn_open']}>checked<{/if}>  type="checkbox">
                                    <span class="lbl"></span>
                                </label>
                            </div>
                            <div class="form-inline row">
                                <label class="col-sm-3 control-label">短信低于</label>
                                <div class="form-inline col-xs-9">
                                    <span>
                                        <input type="number" size="10" class="form-control warn_limit" id="limit"
                                               value="<{if $row && $row['sc_warn_limit']}><{$row['sc_warn_limit']}><{/if}>"
                                                placeholder="最低购买数量" style="width:100px;">
                                    </span>
                                    <span>条时提醒</span>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">通知人手机号</label>
                                <div class="form-inline col-xs-9">
                                    <span>
                                        <input type="text" class="form-control" id="phone" value="<{if $row && $row['sc_warn_phone']}><{$row['sc_warn_phone']}><{/if}>" placeholder="通知人手机号" style="width:260px;">
                                    </span>
                                </div>
                            </div>
                            <div class="space-4"></div>
                            <div class="form-group row">
                                <label class="col-sm-3 control-label">通知人邮箱</label>
                                <div class="form-inline col-xs-9">
                                    <span>
                                        <input type="text" class="form-control" id="mail" value="<{if $row && $row['sc_warn_mail']}><{$row['sc_warn_mail']}><{/if}>" placeholder="通知人邮箱" style="width:260px;">
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-----提交操作---->
                    <div class="form-group">
                        <div class="center">
                            <button class="btn btn-sm btn-primary save-cfg"  > &nbsp; 保 &nbsp; 存 &nbsp; </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/public/plugin/layer/layer.js" type="text/javascript"></script>
<script src="/public/manage/controllers/custom.js" type="text/javascript"></script>
<script>
    $('.save-cfg').on('click',function(){
        var open = $('input[name="warn_open"]').is(":checked");
        var  data = {
            'open'     : open ? 1 : 0,
            'limit'    : $('#limit').val() ,
            'phone'    : $('#phone').val() ,
            'mail'     : $('#mail').val()
        };
        var url = '/wxapp/plugin/saveRemind';
        plumAjax(url,data,false);
    });

</script>
