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
        width: 147px;
        text-align: center;
    }
    .table-bordered>tbody>tr>td{border:0;border-bottom:1px solid #ddd; }
</style>
<div>
    <div class="row">
        <div class="col-sm-12" style="margin-bottom: 20px;">
            <div class="tabbable">
                <ul class="nav nav-tabs" id="myTab">
                    <li>
                        <a  href="/wxapp/member/record">
                            <i class="green icon-th-large bigger-110"></i>
                            充值记录
                        </a>
                    </li>
                    <li>
                        <a href="/wxapp/member/cfg">
                            <i class="green icon-cog bigger-110"></i>
                            充值配置
                        </a>
                    </li>
                    <li class="active">
                        <a  href="/wxapp/member/rechargeRight">
                            <i class="green icon-cog bigger-110"></i>
                            充值权益
                        </a>
                    </li>
                </ul>
                <div class="tab-content">
                    <!--充值记录-->
                    <div id="home" class="tab-pane in active">
                        <div class="page-header">
                            <span style="font-weight: bold;margin-right: 5px;font-size: 18px">权益设置</span>
                            <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
                        </div>
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>储值卡余额(不小于)</th>
                                    <th>享受折扣</th>
                                    <th>
                                        <i class="icon-time bigger-110 hidden-480"></i>
                                        最近修改
                                    </th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $item}>
                                    <tr id="tr_id_<{$item['rr_id']}>">
                                        <td><{$item['rr_money']}></td>
                                        <td><{$item['rr_discount']}></td>
                                        <td><{date('Y-m-d H:i:s',$item['rr_create_time'])}></td>
                                        <td class="jg-line-color">
                                            <a href="javascript:;" class="btn-modal"
                                               data-type="edit"
                                               data-id="<{$item['rr_id']}>"
                                               data-money="<{$item['rr_money']}>"
                                               data-discount="<{$item['rr_discount']}>"
                                              >
                                                编辑
                                            </a>
                                            -
                                            <a href="javascript:;" class="btn-del" data-id="<{$item['rr_id']}>" style="color:#f00;">
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
            </div>
        </div>
    </div>
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑储值权益</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <input type="hidden" id="hid_id" value="0">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">储值卡余额(不小于)</div>
                                <input type="number" class="form-control" id="money" placeholder="请输入整数金额" oninput="this.value=this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                        <div class="space-4"></div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon input-group-addon-title">享受折扣</div>
                                <input type="number" class="form-control" id="discount" placeholder="请输入折扣数">
                                <div class="input-group-addon">折</div>
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

    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,money=0,discount=10;

        if(type == 'edit'){
            id       = $(this).data('id');
            money    = $(this).data('money');
            discount = $(this).data('discount');
        }
        $('#hid_id').val(id);
        $('#money').val(money);
        $('#discount').val(discount);

        $('#modal-info-form').modal('show');
    });
    $('.save-money-btn').on('click',function(){
        var data = {
            'id'    : $('#hid_id').val(),
            'money' : $('#money').val(),
            'discount' : $('#discount').val(),
        };
        
        if(data.discount > 0 && data.money > 0){
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/saveRechargeRight',
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
            layer.msg('请完善数据后提交');
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
                'url'   : '/wxapp/member/delRechargeRight',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>