<style>
    .form-group-box{
        overflow: auto;
    }
    .form-group-box .form-group{
        width: 260px;
        margin-right: 10px;
        float: left;
    }
    .modal-body .form-group{
        margin-bottom: 10px;
    }
    .modal-body .form-group .checkbox{
        margin-top: 0;
        margin-bottom: 0;
    }
    .modal-body .form-group label{
        margin-bottom: 5px;
        display: block;
    }
    .table.table-avatar tbody>tr>td{
        line-height: 30px;
    }
    .fixed-table-box .table thead>tr>th,.fixed-table-body .table tbody>tr>td{
        text-align: center;
    }
</style>
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
</script>
<div  id="mainContent">

    <div class="page-header" style="overflow:hidden">
        <!--
        <div class="alert alert-block alert-<{if $alert['errno'] < 0}>yellow<{else}>success<{/if}> ">
            <i class="icon-bullhorn"></i>
            <{$alert['errmsg']}>
        </div>
        -->
        <div class="col-sm-1">
            <a class="btn btn-green btn-sm" href="/wxapp/sequence/managerWithdrawCfg">
                <i class="icon-cog bigger-40"></i> 提现配置
            </a>
        </div>
    </div>
    <div ng-app="Withdraw"  ng-controller="WithdrawList">
        <div class="page-header search-box">
            <div class="col-sm-12">
                <form class="form-inline" action="/wxapp/sequence/managerWithdraw">
                    <div class="col-xs-11 form-group-box">
                        <div class="form-container">
                            <input type="hidden" name="audit" value="<{$audit}>">
                            <div class="form-group">
                                <div class="input-group ">
                                    <div class="input-group-addon">姓名</div>
                                    <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="提现人姓名">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon">手机号</div>
                                    <input type="text" class="form-control" name="mobile" value="<{$mobile}>" placeholder="提现人手机号">
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
            <a href="/wxapp/sequence/managerWithdraw" <{if !$audit}> class="active" <{/if}>>全部提现申请</a>
            <a href="/wxapp/sequence/managerWithdraw?audit=audit" <{if $audit eq 'audit'}> class="active" <{/if}>>待审核</a>
            <a href="/wxapp/sequence/managerWithdraw?audit=pass" <{if $audit eq 'pass'}> class="active" <{/if}>>已通过</a>
            <a href="/wxapp/sequence/managerWithdraw?audit=refuse" <{if $audit eq 'refuse'}> class="active" <{/if}>>已拒绝</a>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="fixed-table-box" style="margin-bottom: 30px;">
                    <div class="fixed-table-header">
                        <table class="table table-hover table-avatar">
                            <thead>
                                <tr>
                                    <th>姓名</th>
                                    <th class="hidden-480">手机号</th>
                                    <th class="hidden-480">提现帐户</th>
                                    <th>金额明细</th>
                                    <th>状态</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        申请时间
                                    </th>
                                    <th>
                                        备注
                                    </th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="fixed-table-body">
                        <table id="sample-table-1" class="table table-hover">
                            <tbody>
                            <{foreach $list as $val}>
                                <tr>
                                    <td><a href="/wxapp/sequence/managerWithdraw?name=<{$val['esm_nickname']}>"><{$val['esm_nickname']}></a></td>
                                    <td><{$val['esm_mobile']}></td>
                                    <td style="text-align: left">
                                        <p>
                                            方式：<{if isset($withdrawType[$val['emw_way']])}><{$withdrawType[$val['emw_way']]}><{/if}>
                                        </p>
                                        <p>
                                            名称：<{if $val['emw_bank']}><{$banks[$val['emw_bank']]}>&nbsp;<{/if}><{$val['emw_name']}>
                                        </p>
                                        <{if $val['emw_bank_user']}>
                                        <p>
                                            开户人：<{$val['emw_bank_user']}>
                                        </p>
                                        <{/if}>
                                        <p>
                                            账号：<{$val['emw_account']}>
                                        </p>
                                    </td>
                                    <td style="text-align: left">
                                        <p>
                                            申请金额：<{floatval($val['emw_money'])}>
                                        </p>
                                        <{if $val['emw_deduct']>0}>
                                        <p>
                                            平台抽成：<{floatval($val['emw_deduct'])}>
                                        </p>
                                        <{/if}>
                                        <p>
                                            实际金额：<span style="color: blue"><{$val['emw_money'] - $val['emw_deduct']}></span>
                                        </p>
                                    </td>
                                    <td>
                                        <!--
                                        <span class="label label-sm label-<{$withdraw_status[$val['emw_status']]['css']}>"><{$withdraw_status[$val['emw_status']]['label']}></span>
                                        -->
                                        <span class="<{$withdraw_status_new[$val['emw_status']]['class']}>"><{$withdraw_status_new[$val['emw_status']]['label']}></span>
                                    </td>
                                    <td><{date('y-m-d H:i:s',$val['emw_create_time'])}></td>
                                    <td>
                                        <{$val['emw_handle_note']}>
                                    </td>
                                    <td>
                                        <{if $val['emw_status'] eq 1}>
                                        <button class="btn btn-xs btn-info deal-audit"
                                                data-id="<{$val['emw_id']}>"
                                                >
                                            审核
                                        </button>
                                        <{/if}>
                                    </td>
                                </tr>
                                <{/foreach}>
                            </tbody>
                        </table>
                        <{$paginator}>
                    </div>
                </div>
                
            </div><!-- /span -->
        </div><!-- /row -->
        <div id="withdraw-form"  class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">提现处理</h4>
                    </div>
                    <div class="modal-body" style="padding: 10px 20px">
                        <form>
                            <input type="hidden" ng-model="hid_id" id="hid_id" value="0">
                            <div class="form-group">
                                <div class="checkbox" style="padding-left: 0">
                                    <label><b>审核状态</b></label>
                                    <div class="radio-box">
                                        <span>
                                            <input type="radio" name="status" value="2" id="status1" checked>
                                            <label for="status1">通过</label>
                                        </span>
                                        <span>
                                            <input type="radio" name="status" value="3" id="status2">
                                            <label for="status2">拒绝</label>
                                        </span>
                                    </div>
                                    <div class="wx-type" style="color: red;display: block !important;">
                                        请确认已转账完成再进行此操作
                                    </div>
                                </div>
                            </div>

                            <!--
                            <div class="form-group">
                                <div class="checkbox wx-type" style="padding-left: 0">
                                    <label><b>转账方式</b></label>
                                    <div class="radio-box">
                                        <{foreach $tx_ma_map as $key => $val}>
                                        <span>
                                            <input type="radio" name="type" id="type<{$key}>" <{if $key eq 1}>checked<{/if}> value="<{$key}>">
                                            <label for="type<{$key}>"><{$val}></label>
                                        </span>
                                        <{/foreach}>
                                    </div>
                                </div>
                            </div>
                            -->
                            <div class="form-group">
                                <label><b>审核备注</b></label>
                                <textarea type="text" class="form-control" id="note" name="note" rows="3" cols="80" placeholder="请输入审核备注"></textarea>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <span id="saveResult" ng-model="saveResult" class="text-center"></span>
                        <button type="button" class="btn btn-primary modal-save" >保存</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>


<script type="text/javascript" src="/public/plugin/layer/layer.js" ></script>
<script type="text/javascript" src="/public/distrib/controllers/withdraw-list.js" ></script>

<script type="text/javascript" language="javascript">
    $(function(){
        $('.deal-audit').on('click',function(){
            var id   = $(this).data('id');

            $('#hid_id').val(id);
            $('#note').val('');
//            if(type == 1 || type ==3){
//                $('.wx-type').show();
//            }else{
//                $('.wx-type').hide();
//            }
            $('#withdraw-form').modal('show');
        });
        $('input[name="status"]').on('click',function(){
           var status = $(this).val();
            if(status == 2 ){
                $('.wx-type').show();
            }else if(status == 3){
                $('.wx-type').hide();
            }
        });
        $('.modal-save').on('click',function(){
            //遮挡，防止多次点击
            var index = layer.load(1, {
                shade: [0.1,'#fff'] //0.1透明度的白色背景
            },{time:10*1000});

            var status = $('input[name="status"]:checked').val();
            //var type = $('input[name="type"]:checked').val();
            var id   = $('#hid_id').val();
            var note = $('#note').val();
            if(id && status){
                var data = {
                    'id'     : id,
                    'status' : status,
                    //'type'   : type,
                    'note'   : note
                };
                

                $.ajax({
                    'type'  : 'post',
                    'url'   : '/wxapp/sequence/dealManagerWithdraw',
                    'data'  : data,
                    'dataType'  : 'json',
                    success : function(json_ret){
                        layer.close(index);
                        layer.msg(json_ret.em);

                        if(json_ret.ec == 200){
                            window.location.reload();
                        }
                    }

                })
            }else{
                layer.close(index);
                layer.msg('请求参数错误');
            }
        });
        $('.roll-back').on('click',function(){
            var id    = $(this).data('id');
            var money = $(this).data('money');
            layer.confirm('回滚操作会给用户增加'+money+'元可提现金额，确定操作吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                var data = {
                  'id' : id
                };
                rollbackWithdraw(data);
            });
        });
        $('.realName').on('mouseover',function(){
            var num    = $(this).data('num');
            var money  = $(this).data('money');
            var sale   = $(this).data('sale');
            var deduct = $(this).data('deduct');

            var html = '成交量：'+num+'单<br/>';
            html    += '交易额：'+money+'元<br/>';
            html    += '销售额：'+sale+'元<br/>';
            html    += '总返佣：'+deduct+'元<br/>';
            layer.tips(html, this, {
                tips: [2, '#3595CC'],
                time: 4000
            });
        });
        tableFixedInit();//表格初始化
        $(window).resize(function(event) {
            tableFixedInit();
        });
    })
    // 表格固定表头
    function tableFixedInit(){
        var tableBodyW = $('.fixed-table-body .table').width();
        $(".fixed-table-header .table").width(tableBodyW);
        $('.fixed-table-body .table tr').eq(0).find('td').each(function(index, el) {
            $(".fixed-table-header .table th").eq(index).outerWidth($(this).outerWidth())
        });
        $(".fixed-table-body").scroll(function(event) {
            var scrollLeft = $(this).scrollLeft();
            $(".fixed-table-header .table").css("left",-scrollLeft+'px');
        });
    }

</script>
