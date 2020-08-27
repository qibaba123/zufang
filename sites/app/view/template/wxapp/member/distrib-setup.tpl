<{include file="../common-second-menu.tpl"}>
<div style="margin-left: 140px">
    <div class="page-header">
        <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>等级名称</th>
                        <th>交易订单数(笔)</th>
                        <th>消费(元)</th>
                        <th>一级提成比例</th>
                        <th>二级提成比例</th>
                        <th>权重</th>
                        <th>
                            <i class="icon-time bigger-110 hidden-480"></i>
                            创建时间
                        </th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <{foreach $list as $item}>
                        <tr id="tr_id_<{$item['ml_id']}>">
                            <td><{$item['ml_name']}></td>
                            <td><{$item['ml_traded_num']}></td>
                            <td><{$item['ml_traded_money']}></td>
                            <td><{$item['ml_1f_proportion']}>%</td>
                            <td><{$item['ml_2f_proportion']}>%</td>
                            <td><{$item['ml_weight']}></td>
                            <td><{$item['ml_create_time']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                            <td>
                                <a href="javascript:;" class="btn-modal"
                                   data-type="edit"
                                   data-id="<{$item['ml_id']}>"
                                   data-name="<{$item['ml_name']}>"
                                   data-desc="<{$item['ml_desc']}>"
                                   data-traded="<{$item['ml_traded_num']}>"
                                   data-money="<{$item['ml_traded_money']}>"
                                   data-weight="<{$item['ml_weight']}>"
                                   data-oneproportion="<{$item['ml_1f_proportion']}>"
                                   data-twoproportion="<{$item['ml_2f_proportion']}>">

                                    编辑
                                </a>
                                -
                                <a href="javascript:;" class="btn-del" data-id="<{$item['ml_id']}>">
                                    删除
                                </a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑会员等级</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hid_id" value="0">
                    <table class="table table-bordered form-inline">
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 会员等级名称 </td>
                            <td><input type="text" class="form-control" required="required" id="name" placeholder="会员级别名称" ></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 等级描述说明 </td>
                            <td><textarea type="text" class="form-control" id="desc" placeholder="对该等级的简单介绍" ></textarea></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> 等级成立条件 </td>
                            <td><span>成功交易</span><input type="number" min="0" class="form-control" id="traded" >笔</td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> 或 </td>
                            <td><span>累计消费</span><input type="number" min="0" class="form-control" id="money" >元</td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 一级提成比例 </td>
                            <td><input type="number" class="form-control" required="required" id="one-proportion" oninput="limitDiscount(this)" placeholder="分佣比例">%<span style="font-size: 13px;color: #999;">（下级会员购买时返佣比例）</span></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 二级提成比例 </td>
                            <td><input type="number" class="form-control" required="required" id="two-proportion" oninput="limitDiscount(this)" placeholder="分佣比例">%<span style="font-size: 13px;color: #999;">（下下级会员购买时返佣比例）</span></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> 等级权重(数字) </td>
                            <td><input type="number" min="0" size="6" class="form-control" id="weight" oninput="this.value=this.value.replace(/\D/g,'')"><span style="font-size: 13px;color: #999;">数字越大排序越靠前</span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <button type="button" class="btn btn-primary save-btn">保存</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
<style type="text/css">
    .td-title{
        text-align: right;
    }
    .form-inline input[type="number"]{
        width: 100px;
        height: 24px;
        line-height: 24px;
        margin: 0 5px;
        font-size: 12px;
        padding: 0 10px;
    }
</style>
<script type="text/javascript" src="/public/manage/assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    function limitDiscount(e){
        if($(e).val()>100){
            $(e).val(100);
        }
    }
    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,name='',desc='',sale='',down='',traded='',price='',money='',weight='',oneProportion='',twoProportion='';
        if(type == 'edit'){
            id      = $(this).data('id');
            name    = $(this).data('name');
            desc    = $(this).data('desc');
            sale    = $(this).data('sale');
            down    = $(this).data('down');
            traded  = $(this).data('traded');
            price   = $(this).data('price');
            money   = $(this).data('money');
            weight  = $(this).data('weight');
            oneProportion  = $(this).data('oneproportion');
            twoProportion  = $(this).data('twoproportion');
            var forever = $(this).data('forever');
            var is_vip  = $(this).data('is_vip');
            $("input[name='forever'][value="+forever+"]").attr("checked",true);
            $("input[name='is_vip'][value="+is_vip+"]").attr("checked",true);
        }else{
            $("input[name='forever'][value=1]").attr("checked",true);
            $("input[name='is_vip'][value=0]").attr("checked",true);
        }
        $('#hid_id').val(id);
        $('#name').val(name);
        $('#desc').val(desc);
        $('#sale').val(sale);
        $('#down').val(down);
        $('#traded').val(traded);
        $('#money').val(money);
        $('#price').val(price);
        $('#weight').val(weight);
        $('#one-proportion').val(oneProportion);
        $('#two-proportion').val(twoProportion);
        $('#modal-info-form').modal('show');
    });
    $('.save-btn').on('click',function(){
        var id      = $('#hid_id').val();
        var name    = $('#name').val();
        var sale    = $('#sale').val();
        var down    = $('#down').val();
        var desc    = $('#desc').val();
        var traded  = $('#traded').val();
        var money   = $('#money').val();
        var price   = $('#price').val();
        var weight  = $('#weight').val();
        var oneProportion= $('#one-proportion').val();
        var twoProportion= $('#two-proportion').val();
        var forever = $('input[name="forever"]:checked').val();
        var is_vip  = $('input[name="is_vip"]:checked').val();
        if(name && desc){ //(sale || down || traded || price || money)
            var data = {
                'id'    : id,
                'name'  : name,
                'desc'  : desc,
                'sale'  : sale,
                'down'  : down,
                'traded': traded,
                'money' : money,
                'price' : price,
                'weight': weight,
                'is_vip': is_vip,
                'forever':forever,
                'oneProportion':oneProportion,
                'twoProportion':twoProportion
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/member/saveLevel',
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
            layer.msg('请完善表单');
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
                'url'   : '/wxapp/member/delLevel',
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
</script>