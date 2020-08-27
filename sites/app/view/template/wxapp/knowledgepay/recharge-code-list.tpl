<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<style>
    .form-item{
        height: 50px;
    }

    input.form-control.money{
        display: inline-block;
        width: 100px;
    }
</style>
<div id="content-con">
    <div  id="mainContent" >
        <div class="page-header">
            <a class="btn btn-green btn-xs" href="#" id="add-new" data-toggle="modal" data-target="#myModal"><i class="icon-plus bigger-80"></i>批量生成</a>
            <a class="btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#exportModal"><i class="icon-plus bigger-80"></i>批量导出</a>
            <a class="btn btn-green btn-xs" href="#" data-toggle="modal" data-target="#ruleModal"><i class="icon-plus bigger-80"></i>兑换规则</a>
        </div><!-- /.page-header -->
        <div class="choose-state">
            <a href="/wxapp/knowledgepay/rechargeCode" <{if $status eq 0}> class="active" <{/if}>>未使用</a>
            <a href="/wxapp/knowledgepay/rechargeCode?status=1" <{if $status eq 1}> class="active" <{/if}>>已使用</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar">
                        <thead>
                        <tr>
                            <th>编号</th>
                            <th>兑换码</th>
                            <th>绑定会员卡</th>
                            <th>过期时间</th>
                            <th>状态</th>
                            <th>
                                <i class="icon-time bigger-110 hidden-480"></i>
                                创建时间
                            </th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $list as $key => $val}>
                            <tr id="tr_<{$val['akrc_id']}>">
                                <td><{$index + $key + 1}></td>
                                <td><{$val['akrc_code']}></td>
                                <td><{$cardList[$val['akrc_value']]}></td>
                                <td><{if $val['akrc_expire_time']}><{date('Y-m-d', $val['akrc_expire_time'])}><{else}>长期有效<{/if}></td>
                                <td><{if $val['akrc_status']==0}><span style="color: #1FC51D">未使用</span><{else}><span style="color: red">已使用</span><{/if}></td>
                                <td><{date('Y-m-d H:i:s',$val['akrc_create_time'])}></td>
                                <td class="jg-line-color">
                                    <a class="delete-btn" data-id="<{$val['akrc_id']}>" style="color:#f00;">删除</a>
                                </td>
                            </tr>
                        <{/foreach}>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                <{$pagination}>
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    生成兑换码
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">生成数量：</label>
                    <div class="col-sm-8">
                        <input id="code-num" type="number" class="form-control" placeholder="请填写生成数量" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">绑定会员卡：</label>
                    <div class="col-sm-8">
                        <select name="code-value" id="code-value" class="form-control">
                            <{foreach $cardList as $key => $val}>
                            <option value="<{$key}>"><{$val}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">过期时间：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" onclick="chooseDate()" style="height:auto!important" id="expire-time" onchange="">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-category">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="exportModal" tabindex="-1" role="dialog" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="exportModalLabel">
                    批量导出充值码
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">起始编号：</label>
                    <div class="col-sm-8">
                        <input id="start" type="number" class="form-control" placeholder="请填写起始编号" style="height:auto!important"/>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">结束编号：</label>
                    <div class="col-sm-8">
                        <input id="end" type="number" class="form-control" placeholder="请填写结束编号" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-export">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<!-- 模态框（Modal） -->
<div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="ruleModalLabel">
                    兑换规则
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">兑换页标语：</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="recharge-sub-title" id="recharge-sub-title" value="<{$tpl['aki_recharge_sub_title']}>" placeholder="<{if $appletCfg['ac_type'] == 27}>享知识饕餮盛宴，不一样学习体验<{/if}>">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">兑换规则：</label>
                    <div class="col-sm-8">
                        <textarea name="recharge-rule" id="recharge-rule" class="form-control"><{$tpl['aki_recharge_rule']}></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-cfg">
                    保存
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script src="/public/manage/coupon/datePicker/WdatePicker.js"></script>
<script>

    $('#confirm-category').on('click', function(){
        var number = $('#code-num').val();
        var value = $('#code-value').val();
        var expire = $('#expire-time').val();
        var data = {
            'number' : number,
            'value' : value,
            'expire': expire
        }

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/createRechargeCode',
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
    })

    $('#confirm-export').on('click', function(){
        var start = $('#start').val();
        var end = $('#end').val();
        if(start && end){
            if(Number(end)-Number(start)<=2000){
                window.location.href="/wxapp/knowledgepay/exportRechargeCode?start="+start+'&end='+end;
            }else{
                layer.msg('最多导出2000条充值码');
            }
        }else{
            layer.msg('请填写起始编号和结束编号');
        }
    })

    $('#confirm-cfg').on('click', function(){
        var rechargeSubTitle = $('#recharge-sub-title').val();
        var rechargeRule = $('#recharge-rule').val();
        var data = {
            'subTitle' : rechargeSubTitle,
            'rule' : rechargeRule,
        }

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/saveRechargeCfg',
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
    })


    $('.delete-btn').on('click', function(){
        var id = $(this).data('id');

        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/knowledgepay/delRechargeCode',
            'data'  : {id: id},
            'dataType' : 'json',
            success : function(ret){
                layer.close(loading);
                layer.msg(ret.em);
                if(ret.ec == 200){
                    window.location.reload();
                }
            }
        });
    })

    var nowdate = new Date();
    var year = nowdate.getFullYear(),
            month = nowdate.getMonth()+1,
            date = nowdate.getDate();
    var today = year+"-"+month+"-"+date;
    /*初始化日期选择器*/
    function chooseDate(){
        WdatePicker({
            dateFmt:'yyyy-MM-dd',
            minDate:today
        });
    }
</script>