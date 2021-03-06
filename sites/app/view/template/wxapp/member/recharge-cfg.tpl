<link rel="stylesheet" href="/public/wxapp/setup/css/spectrum.css">
<style type="text/css">
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before {
        content: "开启\a0\a0\a0\a0\a0\a0\a0\a0禁止";
    }
    input[type=checkbox].ace.ace-switch.ace-switch-5+.lbl::before{
        background-color: #D15B47;
        border: 1px solid #CC4E38;
    }
    table tr th,table tr td{
        text-align: center;
    }
    #modal-info-form .input-group{
        width: 100%;
    }
    #modal-info-form .input-group .input-group-addon-title{
        width: 125px;
        text-align: right;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
</style>
<div>
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <!--
                    <li>
                        <a href="/wxapp/member/rechargeChange">
                            <i class="green icon-money bigger-110"></i>
                            充值金额
                        </a>
                    </li>
                    -->
                    <li>
                        <a  href="/wxapp/member/record">
                            <i class="green icon-th-large bigger-110"></i>
                            充值记录
                        </a>
                    </li>
                    <li class="active">
                        <a  data-toggle="tab" href="#home">
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
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="page-header">
                            <span style="font-weight: bold;margin-right: 5px;font-size: 18px">固定充值金额</span>
                            <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>充值金额</th>
                                    <th>得到金额</th>
                                    <th>限购次数</th>
                                    <{if $applet['ac_type'] != 28 && $applet['ac_type'] != 21}>
                                    <th>会员身份</th>
                                    <{/if}>
                                    <!--
                                    <{foreach $thLevel as $key=>$val}>
                                    <th><{$val}></th>
                                    <{/foreach}>
                                    -->
                                    <th>权重排序</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        最近修改
                                    </th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $item}>
                                    <tr id="tr_id_<{$item['rv_id']}>">
                                        <td><{$item['rv_money']}></td>
                                        <td><{$item['rv_coin']}></td>
                                        <td><{$item['rv_limit']}></td>
                                        <{if $applet['ac_type'] != 28 && $applet['ac_type'] != 21}>
                                        <td><{$levelList[$item['rv_identity']]}></td>
                                        <{/if}>
                                        <!--
                                        <{foreach $fieldLevel as $key=>$val}>
                                        <th><{$item[$val]}></th>
                                        <{/foreach}>
                                        -->
                                        <td><{$item['rv_weight']}></td>
                                        <td><{date('Y-m-d H:i:s',$item['rv_create_time'])}></td>
                                        <td class="jg-line-color">
                                            <a href="javascript:;" class="btn-modal"
                                               data-type="edit"
                                               data-id="<{$item['rv_id']}>"
                                               data-money="<{$item['rv_money']}>"
                                               data-coin="<{$item['rv_coin']}>"
                                               data-limit="<{$item['rv_limit']}>"
                                               data-identity="<{$item['rv_identity']}>"
                                               data-coin1="<{$item['rv_1f_coin']}>"
                                               data-coin2="<{$item['rv_2f_coin']}>"
                                               data-coin3="<{$item['rv_3f_coin']}>"
                                               data-weight="<{$item['rv_weight']}>"
                                               data-backgroundcolor="<{$item['rv_background_color']}>">
                                                编辑
                                            </a>
                                            -
                                            <a href="javascript:;" class="btn-del" data-id="<{$item['rv_id']}>" style="color:#f00;">
                                                删除
                                            </a>
                                        </td>
                                    </tr>
                                    <{/foreach}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>

                <div class="tab-content">
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 自定义金额 : &nbsp;</label>
                                <div id="choose-yesno" class="col-sm-10">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="open_zdy" <{if $row && $row['rc_open_zdy']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 用户填写备注 : &nbsp;</label>
                                <div id="choose-yesno" class="col-sm-10">
                                    <input name="sms_start" class="ace ace-switch ace-switch-5" id="open_remark" <{if $row && $row['rc_open_remark']}>checked<{/if}> type="checkbox">
                                    <span class="lbl"></span>
                                </div>

                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label"> 充值描述 : &nbsp;</label>
                                <div class="col-sm-10 ">
                                    <textarea class="form-control" name="desc" id="desc" rows="3"><{if $row && $row['rc_desc']}><{$row['rc_desc']}><{/if}></textarea>
                                </div>
                            </div>
                        </div><!-- /.table-responsive -->
                    </div>
                    <div class="footer text-center">
                        <a href="javascript:;" class="btn btn-primary save-btn"> 保 存 </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑会员登录</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="hid_id" value="0">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">充值金额</div>
                                <input type="number" class="form-control" id="money" placeholder="请输入整数金额" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">获得金额</div>
                                <input type="number" class="form-control" id="coin" placeholder="请输入充值获得金额" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">限购次数</div>
                                <input type="number" class="form-control" id="limit" placeholder="限购次数,0表示不限购" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                            <span style="color: red;margin-left: 125px;">限购次数,0表示不限购</span>
                        </div>
                        <div class="space-4"></div>
                        <{if $applet['ac_type'] != 28 && $applet['ac_type'] != 32 && $appletCfg['ac_type'] != 36 && $applet['ac_type'] != 21}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">会员身份</div>
                                <select name="identity" id="identity" class="form-control">
                                    <option value="0">无</option>
                                    <{foreach $levelList as $key => $val}>
                                    <option value="<{$key}>"><{$val}></option>
                                    <{/foreach}>
                                </select>
                            </div>
                            <span style="color: red;margin-left: 125px">可选, 充值对应金额, 获取的会员身份, 自定义金额无效</span>
                        </div>
                        <{/if}>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">背景色</div>
                                <input type="text" class="form-control color-input" id="backgroundColor" value="">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <!--
                        <div class="space-4"></div>
                        <{$levelHtml}>
                        -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">权重排序</div>
                                <input type="number" class="form-control" id="weight" placeholder="1-100之间的整数(数字越大排序越靠前)" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>

                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary save-money-btn">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/shopfixture/color-spectrum/spectrum.js"></script>
<script type="text/javascript">
    $(function () {
        $("input.color-input").each(function(index, el) {
            var obj = $(this);
            var type = obj.data('type');
            var val = obj.val();
            initColor(obj,val,type);
        });
    });
    function initColor(obj,colorVal,type) {
        obj.spectrum({
            color: colorVal,
            showButtons: false,
            showInput: true,
            showInitial: true,
            showPalette: true,
            showSelectionPalette: true,
            maxPaletteSize: 10,
            preferredFormat: "hex",
            move: function (color) {
                var realColor = color.toHexString();
                $('#backgroundColor').val(realColor);
            },
            palette: [
                ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)", "rgb(153, 153, 153)","rgb(183, 183, 183)",
                    "rgb(204, 204, 204)", "rgb(217, 217, 217)", "rgb(239, 239, 239)", "rgb(243, 243, 243)", "rgb(248, 248, 248)", "rgb(255, 255, 255)"],
                ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
                    "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)", "rgb(0, 153, 255)"],
                ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)",
                    "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)",
                    "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)",
                    "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)",
                    "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)",
                    "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
                    "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
                    "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
                    "rgb(133, 32, 12)", "rgb(153, 0, 0)", "rgb(180, 95, 6)", "rgb(191, 144, 0)", "rgb(56, 118, 29)",
                    "rgb(19, 79, 92)", "rgb(17, 85, 204)", "rgb(11, 83, 148)", "rgb(53, 28, 117)", "rgb(116, 27, 71)",
                    "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)",
                    "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
            ]
        });
    }

    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,coin='',limit=0,identity=0,coin_1='',coin_2='',coin_3='',money='',weight='',backgroundColor = '';

        if(type == 'edit'){
            id      = $(this).data('id');
            coin    = $(this).data('coin');
            limit   = $(this).data('limit');
            identity = $(this).data('identity');

            coin_1  = $(this).data('coin1');
            coin_2  = $(this).data('coin2');
            coin_3  = $(this).data('coin3');
            money   = $(this).data('money');
            weight  = $(this).data('weight');
            backgroundColor  = $(this).data('backgroundcolor');
            var obj = $('#backgroundColor');
            setTimeout(function () {
                obj.unbind();
                initColor(obj,backgroundColor);
            },200);
        }
        $('#hid_id').val(id);
        $('#coin').val(coin);
        $('#limit').val(limit);
        $('#identity').val(identity);
        $('#money').val(money);
        $('#weight').val(weight);
        $('#backgroundColor').val(backgroundColor);
        $('#level_1').val(coin_1);
        $('#level_2').val(coin_2);
        $('#level_3').val(coin_3);

        $('#modal-info-form').modal('show');
    });
    $('.save-money-btn').on('click',function(){
        var data = {
            'id'    : $('#hid_id').val(),
            'coin'  : $('#coin').val(),
            'limit' : $('#limit').val(),
            'identity': $('#identity').val(),
            'coin_1': $('#level_1').val(),
            'coin_2': $('#level_2').val(),
            'coin_3': $('#level_3').val(),
            'money' : $('#money').val(),
            'weight': $('#weight').val(),
            'backgroundColor': $('#backgroundColor').val()
        };
        if(data.coin > 0 && data.money > 0){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/saveValue',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    if(ret.ec == 200){
                        window.location.reload();
                    }else{
                        layer.msg(ret.em);
                    }
                }
            });
        }else{
            layer.msg('请填写整数');
        }
    });
    $('.btn-del').on('click',function(){
        var id = $(this).data('id');
        layer.confirm('您确定要删除吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            var data = {
                'id'    : id
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/delValue',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        $('#tr_id_'+id).remove();
                    }
                }
            });
        });
    });
    $('.save-btn').on('click',function(){
        var open = $('#open_zdy').is(':checked');
        var remark = $('#open_remark').is(':checked');
        var data = {
            'open'  : open ? 1 : 0 ,
            'remark'  : remark ? 1 : 0 ,
            'desc'  : $('#desc').val()
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/member/saveCfg',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                layer.msg(ret.em);
                if(ret.ec != 200){
                    window.location.reload();
                }
            }
        });
    });
</script>