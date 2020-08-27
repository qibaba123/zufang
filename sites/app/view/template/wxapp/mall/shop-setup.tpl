<link rel="stylesheet" href="/public/manage/assets/css/bootstrap-timepicker.css" />
<style>
    /* 会员信息提示框样式 */
    .page-header{
        padding:10px 0;
    }
    .page-header .alert-gray{
        background-color: #F4F4F4;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        -ms-border-radius: 5px;
        -o-border-radius: 5px;
        border-radius: 5px;
        color: #666;
        padding: 5px 15px;
        margin-bottom: 10px;
    }
    body{
        min-width: 1200px;
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }

    .business-time{
        width: 30% !important;
        display: inline-block !important;
    }

</style>
<div class="page-header">

</div><!-- /.page-header -->
<div class="row">
    <div class="col-sm-9" style="margin-bottom: 20px;">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-home bigger-110"></i>
                        店铺信息配置
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!--店铺基本信息-->
                <div id="home" class="tab-pane in active">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> 店 &nbsp; 铺 &nbsp; 名 &nbsp; 称 : </div>
                            <input type="text" class="form-control" id="shop_name" placeholder="请输入店铺名称" value="<{if $row}><{$row['s_name']}><{/if}>">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> &nbsp;&nbsp; 联 &nbsp; 系 &nbsp;  人 : &nbsp; &nbsp; </div>
                            <input type="text" class="form-control" id="shop_contact"  placeholder="请输入店铺联系人" value="<{if $row}><{$row['s_contact']}><{/if}>">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> 联 &nbsp; 系 &nbsp; 电 &nbsp; 话 : </div>
                            <input type="text" class="form-control" id="shop_phone"  placeholder="请输入店铺联系电话" value="<{if $row}><{$row['s_phone']}><{/if}>">
                        </div>
                    </div>
                    <!--
                    <{if $showTime && $showTime == 1}>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon" > 营 &nbsp; 业 &nbsp; 时 &nbsp; 间 : </div>
                            <input type="text" class="form-control business-time time" id="shop_start_time"  placeholder="营业开始时间" value="<{if $row}><{$row['s_start_time']}><{/if}>">
                            至
                            <input type="text" class="form-control business-time time" id="shop_end_time"  placeholder="营业结束时间" value="<{if $row}><{$row['s_end_time']}><{/if}>">
                        </div>
                    </div>
                    <{/if}>
                    -->
                    <div class="form-group">
                        <div class="cropper-box" data-width="200" data-height="200">
                            <img src="<{if $row && $row['s_logo']}><{$row['s_logo']}><{else}>/public/manage/img/zhanwei/zw_fxb_45_45.png<{/if}>" id="source_img" width="100" style="display:inline-block;margin:0"><a href="javascript:void(0)" style="display: inline;color:blue;font-size:14px;vertical-align: bottom;position: relative;left:5px;">店铺LOGO</a>
                            <p><small style="font-size: 12px;color:#999">建议尺寸：200*200</small></p>
                            <input type="hidden" id="source_image" class="avatar-field source-img" ng-model="cover" name="source_image" value="<{if $row && $row['s_logo']}><{$row['s_logo']}><{/if}>"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="left">
                            <div id="saveResult" class="col-sm-9" style="text-align: center;"></div>
                        </div>
                        <div class="right">
                            <button class="btn btn-primary" style="margin:0 10px" onclick="saveShopInfo();">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <div class="col-sm-9" style="margin-bottom: 20px;">
        <div class="tabbable">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active">
                    <a data-toggle="tab" href="#home">
                        <i class="green icon-home bigger-110"></i>
                        店铺支付配置
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!--店铺基本信息-->
    <!--
                <div id="home" class="tab-pane in active">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> &nbsp;&nbsp; 商 &nbsp; 户 &nbsp;  号 : &nbsp; &nbsp; </div>
                            <input type="text" class="form-control" id="mch_id" placeholder="请输入小程序支付的商户号" value="<{if $appletCfg}><{$appletCfg['ac_mch_id']}><{/if}>">
                        </div>
                    </div>
                    <div class="space-4"></div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"> 商 &nbsp; 户 &nbsp; 秘 &nbsp; 钥 : </div>
                            <input type="text" class="form-control" id="mch_key"  placeholder="请输入小程序支付的商户秘钥" value="<{if $appletCfg}><{$appletCfg['ac_mch_key']}><{/if}>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="left">
                            <div id="saveResult" class="col-sm-9" style="text-align: center;"></div>
                        </div>
                        <div class="right">
                            <button class="btn btn-primary" style="margin:0 10px" onclick="saveShopPay();">保存</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    -->
</div>
<{$cropper['modal']}>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/date-time/bootstrap-timepicker.min.js"></script>
<script>
    // 保存店铺信息配置
    function saveShopInfo(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var data = {
            'name'        : $('#shop_name').val(),
            'contact'     : $('#shop_contact').val(),
            'phone'       : $('#shop_phone').val(),
            'follow_link' : $('#shop_follow').val(),
            'logo'         : $('#source_image').val(),
            'start_time'   : $('#shop_start_time').val(),
            'end_time'   : $('#shop_end_time').val(),
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mall/saveShopInfo',
            'data'  : data,
            'dataType' : 'json',
            success : function(response){
                layer.close(index);
                layer.msg(response.em);
            }
        });
    }
    // 保存店铺支付配置
    function saveShopPay(){
        var index = layer.load(1, {
            shade: [0.1,'#fff'] //0.1透明度的白色背景
        },{
            time : 10*1000
        });
        var data = {
            'mch_id'      : $('#mch_id').val(),
            'mch_key'     : $('#mch_key').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/mall/saveShopPay',
            'data'  : data,
            'dataType' : 'json',
            success : function(response){
                layer.close(index);
                layer.msg(response.em);
            }
        });
    }

    /*初始化日期选择器*/
    $('.time').click(function(){
        WdatePicker({
            dateFmt:'HH:mm',
            minDate:'00:00:00'
        })
    })

</script>