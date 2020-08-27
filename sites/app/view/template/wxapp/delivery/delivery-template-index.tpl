<link rel="stylesheet" href="/public/wxapp/mall/css/deliveryTemplate.css">
<style>
        input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { content: "已启用\a0\a0\a0\a0\a0未启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { content: "\a0\a0禁用\a0\a0\a0\a0\a0\a0\a0启用" !important; }
input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { background-color: #666666; border: 1px solid #666666; }
input[type=checkbox].ace.ace-switch.ace-switch-5:hover+.lbl::before { background-color: #333333; border: 1px solid #333333; }
input[type=checkbox].ace.ace-switch { width: 90px; height: 30px; margin: 0; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before { line-height: 30px; height: 31px; overflow: hidden; border-radius: 18px; width: 89px; font-size: 13px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::before { background-color: #44BB00; border-color: #44BB00; }
input[type=checkbox].ace.ace-switch.ace-switch-4:hover:checked:hover+.lbl::before, input[type=checkbox].ace.ace-switch.ace-switch-5:checked:hover+.lbl::before { background-color: #DD0000; border-color: #DD0000; }
input[type=checkbox].ace.ace-switch.ace-switch-4+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::after { width: 28px; height: 28px; line-height: 28px; border-radius: 50%; top: 1px; }
input[type=checkbox].ace.ace-switch.ace-switch-4:checked+.lbl::after, input[type=checkbox].ace.ace-switch.ace-switch-5:checked+.lbl::after { left: 59px; top: 1px }

    .freight-head{
        margin: 0 0 12px;
        border-bottom: 1px dotted #e2e2e2;
        padding-bottom: 16px;
        padding-top: 7px;
    }

        .watermrk-show{
            display: inline-block;
            vertical-align: middle;
            margin-left: 20px;
        }
        .watermrk-show .label-name,.watermrk-show .watermark-box{
            display: inline-block;
            vertical-align: middle;
        }
        .watermrk-show .watermark-box{
            width: 180px;
        }
    </style>

<{if $applet['ac_type'] != 13}>
    <{include file="../common-second-menu-new.tpl"}>
<{/if}>
<div class="freight-list" <{if $applet['ac_type'] != 13}>style="margin-left: 130px<{/if}>">
    <div class="freight-head" >
        <a href="/wxapp/delivery/add" class="btn btn-green btn-xs">新建运费模版</a>
        <span style="margin-left: 20px;<{if $curr_shop['s_id'] == 4230 || $curr_shop['s_id'] == 10380}>display:none;<{/if}>">
                    快递发货：
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="expressOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <{if $sendCfg && $sendCfg['acs_express_delivery']}>checked<{/if}>>
                        <span class="lbl"></span>
                    </label>
            </span>
        <div class="watermrk-show" <{if $curr_shop['s_id'] == 4230 || $curr_shop['s_id'] == 10380}>style="display:none;"<{/if}>>
            <span class="label-name">排序：</span>
            <div class="watermark-box">
                <div class="input-group">
                    <input type="number" style="width: 60px;" maxlength="2" class="form-control" id="delivery-sort" value="<{$sendCfg['acs_express_sort']}>" data-type="express" oninput="if(value.length>2)value=value.slice(0,2)">
                    <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-delivery-sort">确认</span>
                            <span>数值越大越靠前</span>
                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="freight-content" style="display: block;">
        <div class="freight-template-list-wrap js-freight-template-list-wrap">
            <ul>
                <{foreach $list as $val}>
                <li class="freight-template-item">
                    <h4 class="freight-template-title js-freight-extend-toggle">
                        <b><{$val['sdt_name']}></b>
                        <div class="pull-right">
                            <span class="c-gray">最后编辑时间<{date('Y-m-d H:i:s',$val['sdt_update_time'])}></span>&nbsp;&nbsp;
                            <a href="/wxapp/delivery/add?id=<{$val['sdt_id']}>" class="js-freight-edit">修改</a> -
                            <a href="javascript:;" class="js-freight-delete" onclick="deleteTemplate(<{$val['sdt_id']}>)" style="color:#f00;">删除</a>
                        </div>
                    </h4>

                    <table class="freight-template-table">
                        <thead class="js-freight-cost-list-header">
                            <tr>
                                <th>可配送区域</th>
                                <{if $val['sdt_type'] == 1}>
                                <th>首件（个）</th>
                                <{else}>
                                <th>首重（Kg）</th>
                                <{/if}>
                                <th>运费（元）</th>
                                <{if $val['sdt_type'] == 1}>
                                <th>续件（个）</th>
                                <{else}>
                                <th>续重（Kg）</th>
                                <{/if}>
                                <th>续费（元）</th>
                            </tr>
                        </thead>
                        <tbody>
                        <{foreach $val['cityList'] as $v}>
                            <tr>
                                <td>
                                    <{foreach $v as $value}>
                                    <span class="text-depth1"><{$value['sdc_area_name']}></span>&nbsp;&nbsp;
                                    <{/foreach}>
                                </td>
                                <td><{$v[0]['sdc_first_num']}></td>
                                <td><{$v[0]['sdc_first_fee']}></td>
                                <td><{$v[0]['sdc_add_num']}></td>
                                <td><{$v[0]['sdc_add_fee']}></td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </li>
                <{/foreach}>
            </ul>
        </div>
        <{$paginator}>
    </div>
</div>

<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript" src="/public/manage/assets/js/fuelux/fuelux.wizard.min.js"></script>
<script type="text/javascript" src="/public/plugin/sortable/jquery-ui.min.js"></script>

<script>
    function deleteTemplate(id){
        layer.confirm('你确定要删除该运费模板吗，删除后会影响选择该运费模板的商品的购买', {
            title: '确认删除',
            btn: ['确定','取消']    //按钮
        }, function(){
            if(id){
                var index = layer.load(1, {
                    shade: [0.1,'#fff'] //0.1透明度的白色背景
                });
                $.ajax({
                    'type'   : 'post',
                    'url'   : '/wxapp/delivery/deleteTemplate',
                    'data'  : {id:id},
                    'dataType'  : 'json',
                    'success'   : function(ret){
                        layer.close(index);
                        window.location.reload();
                    }
                });
            }
        },function (){

        });
    }

    function changeOpen() {
        var open   = $('#expressOpen:checked').val();
        console.log(open);
        var data = {
            value:open,
            type : 'express'
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
            }
        });
    }

    $('#save-delivery-sort').on('click',function () {
        var value = $('#delivery-sort').val();
        var type = $('#delivery-sort').data('type');
        var data = {
            value:value,
            type : type
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSort',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });


</script>