<link rel="stylesheet" href="/public/manage/css/member-list.css">
<style>
	.table-bordered>thead>tr>th,.table-bordered>tbody>tr>td{border:none;border-bottom:1px solid #ddd;}
</style>
<div>
    <div class="page-header">
        <button  class="btn btn-green btn-modal" data-type="edit" role="button"><i class="icon-plus bigger-80"></i> 添加</button>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="sample-table-1" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>等级名称</th>
                        <th>最大商品发布数量</th>
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
                        <tr id="tr_id_<{$item['esl_id']}>">
                            <td><{$item['esl_name']}></td>
                            <td><{if $item['esl_max_goods'] > 0}><{$item['esl_max_goods']}><{else}>无限制<{/if}></td>
                            <td><{$item['esl_weight']}></td>
                            <td><{$item['esl_create_time']|date_format:"%Y-%m-%d %H:%M:%S"}></td>
                            <td class="jg-line-color">
                                <a href="javascript:;" class="btn-modal"
                                        data-type="edit"
                                        data-id="<{$item['esl_id']}>"
                                        data-name="<{$item['esl_name']}>"
                                        data-desc="<{$item['esl_desc']}>"
                                        data-maxgoods="<{$item['esl_max_goods']}>"
                                        data-weight="<{$item['esl_weight']}>"
                                >

                                    编辑
                                </a>
                                -
                                <a href="javascript:;" class="btn-del" data-id="<{$item['esl_id']}>" style="color:#f00;">
                                    删除
                                </a>
                            </td>
                        </tr>
                        <{/foreach}>
                    </tbody>
                </table>
                <{$paginator}>
            </div><!-- /.table-responsive -->
        </div><!-- /span -->
    </div><!-- /row -->
    <div id="modal-info-form"  class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">添加/编辑商家等级</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hid_id" value="0">
                    <table class="table table-bordered form-inline">
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 商家等级名称 </td>
                            <td><input type="text" class="form-control" required="required" id="name" placeholder="商家级别名称" ></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 等级描述说明 </td>
                            <td><textarea type="text" class="form-control" id="desc" placeholder="对该等级的简单介绍" ></textarea></td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> 最大商品发布数量 </td>
                            <td><input type="number" min="0" class="form-control" id="maxgoods" >件<span style="font-size: 13px;color: #999;">&nbsp;&nbsp;0或不填表示无限制</span></td>
                        </tr>
                        <!--<tr>
                            <td class="success td-title col-xs-4"> 或 </td>
                            <td><span>累计消费</span><input type="number" min="0" class="form-control" id="money" >元</td>
                        </tr>
                        <tr>
                            <td class="success td-title col-xs-4"> <span style="color: red"> * </span> 商家折扣 </td>
                            <td><input type="number" class="form-control" required="required" id="discount" oninput="limitDiscount(this)" placeholder="商家折扣">折<span style="font-size: 13px;color: #999;">（商家购买商品时的折扣）</span></td>
                        </tr>-->
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
        if($(e).val()>10){
            $(e).val(10);
        }
    }
    $('.btn-modal').on('click',function(){
        var type = $(this).data('type');
        var id= 0,name='',desc='',price='',maxGoods='',weight='';
        if(type == 'edit'){
            id      = $(this).data('id');
            name    = $(this).data('name');
            desc    = $(this).data('desc');
            maxGoods  = $(this).data('maxgoods');
            weight  = $(this).data('weight');
        }else{

        }
        $('#hid_id').val(id);
        $('#name').val(name);
        $('#desc').val(desc);
        $('#maxgoods').val(maxGoods);
        $('#weight').val(weight);
        $('#modal-info-form').modal('show');
    });
    $('.save-btn').on('click',function(){
        var id      = $('#hid_id').val();
        var name    = $('#name').val();
        var desc    = $('#desc').val();
        var maxGoods = $('#maxgoods').val();
        var weight  = $('#weight').val();
//        if(maxGoods <= 0){
//            layer.msg('最大商品数量需大于零');
//            return false;
//        }

        if(name && desc){ //(sale || down || traded || price || money)
            var data = {
                'id'    : id,
                'name'  : name,
                'desc'  : desc,
                'maxGoods' : maxGoods,
                'weight': weight
            };
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveLevel',
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
                'url'   : '/wxapp/community/delLevel',
                'data'  : data,
                'dataType'  : 'json',
                'success'   : function(ret){
                    layer.msg(ret.em);
                    if(ret.ec == 200){
//                        $('#tr_id_'+id).remove();
                        window.location.reload();
                    }
                }
            });
        });
    });
</script>