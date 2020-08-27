<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <button class="btn btn-green btn-xs" style="padding-top: 2px;padding-bottom: 2px;" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>创建立减金活动</button>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-striped table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>活动开始时间</th>
                            <th>活动结束时间</th>
                            <th>单个礼包立减金数量</th>
                            <th>单个用户最大领取次数</th>
                            <th>单个用户每日最大领取次数</th>
                            <th>最小支付金额</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $val}>
                            <tr id="tr_<{$val['wa_id']}>">
                                <td><{date('Y-m-d H:i:s',$val['wa_begin_time'])}></td>
                                <td><{date('Y-m-d H:i:s',$val['wa_end_time'])}></td>
                                <td><{$val['wa_gift_num']}></td>
                                <td><{$val['wa_max_partic_times_act']}></td>
                                <td><{$val['wa_max_partic_times_one_day']}></td>
                                <td><{$val['wa_min_amt']}></td>
                            </tr>
                            <{/foreach}>
                            <{if $paginator}>
                            <tr><td colspan="8"><{$paginator}></td></tr>
                            <{/if}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" value="<{$card_id}>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    创建立减金活动
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">活动背景颜色：</label>
                    <div class="col-sm-9">
                        <select name="" id="activity_bg_color" style="width: 100%;background: #63b359" class="form-control" onchange="changColor(this)">
                            <option value="Color010" style="background: #63b359"></option>
                            <option value="Color020" style="background: #2c9f67"></option>
                            <option value="Color030" style="background: #509fc9"></option>
                            <option value="Color040" style="background: #5885cf"></option>
                            <option value="Color050" style="background: #9062c0"></option>
                            <option value="Color060" style="background: #d09a45"></option>
                            <option value="Color070" style="background: #e4b138"></option>
                            <option value="Color080" style="background: #ee903c"></option>
                            <option value="Color090" style="background: #dd6549"></option>
                            <option value="Color100" style="background: #cc463d"></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">活动开始时间	：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" onclick="chooseDate()" id="begin_time">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">活动结束时间	：</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" onclick="chooseDate()" id="end_time">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">单个礼包立减金数量：</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="gift_num" value="3" placeholder="3-15个"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">单个用户最大领取次数：</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="max_partic_times_act" value="1" placeholder="最大为50"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">单个用户每日最大领取次数：</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="max_partic_times_one_day" value="1" placeholder="最大为50"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num">最小支付金额	：</label>
                    <div class="col-sm-9">
                        <input type="number" class="form-control" id="min_amt" value="1"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-handle">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script>
    function changColor(e){
        var val = String($(e).val());
        switch (val){
            case 'Color010':
                $(e).css('background', '#63b359');
                break;
            case 'Color020':
                $(e).css('background', '#2c9f67');
                break;
            case 'Color030':
                $(e).css('background', '#509fc9');
                break;
            case 'Color040':
                $(e).css('background', '#5885cf');
                break;
            case 'Color050':
                $(e).css('background', '#9062c0');
                break;
            case 'Color060':
                $(e).css('background', '#d09a45');
                break;
            case 'Color070':
                $(e).css('background', '#e4b138');
                break;
            case 'Color080':
                $(e).css('background', '#ee903c');
                break;
            case 'Color090':
                $(e).css('background', '#dd6549');
                break;
            case 'Color100':
                $(e).css('background', '#cc463d');
                break;
        }
    }

    $('#confirm-handle').on('click',function(){
        var cid               = $('#hid_id').val();
        var activity_bg_color = $('#activity_bg_color').val();
        var begin_time        = $('#begin_time').val();
        var end_time          = $('#end_time').val();
        var gift_num          = $('#gift_num').val();
        var max_partic_times_act     = $('#max_partic_times_act').val();
        var max_partic_times_one_day = $('#max_partic_times_one_day').val();
        var min_amt                  = $('#min_amt').val();
        var data = {
            cid : cid,
            color : activity_bg_color,
            begin_time : begin_time,
            end_time : end_time,
            gift_num : gift_num,
            max_partic_times_act : max_partic_times_act,
            max_partic_times_one_day : max_partic_times_one_day,
            min_amt : min_amt
        };
        if(gift_num<3 || gift_num>15){
            layer.msg('单个礼包社交立减金数量需为3-15个');
            return false;
        }
        if(max_partic_times_act>50){
            layer.msg('每个用户活动期间最大领取次数不能超过50');
            return false;
        }
        if(max_partic_times_one_day>50){
            layer.msg('每个用户活动期间单日最大领取次数不能超过50')
            return false;
        }
        var reg = /(^[1-9]([0-9]+)?(\.[0-9]{1,2})?$)|(^(0){1}$)|(^[0-9]\.[0-9]([0-9])?$)/;
        if (!reg.test(min_amt)){
            layer.msg('请输入正确支付金额');
            return false;
        }
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/currency/createActivity',
            'data'  : data,
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });

    });


    var nowdate = new Date();
    var year = nowdate.getFullYear(),
            month = nowdate.getMonth()+1,
            date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd HH:mm:ss',
            minDate:today
        });
    }

</script>