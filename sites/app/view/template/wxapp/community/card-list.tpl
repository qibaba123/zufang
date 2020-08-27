<style type="text/css">
    .table tr th ,.table tr td {
        text-align: center;
    }
</style>
<{include file="../common-second-menu.tpl"}>
<div  id="content-con" style="padding-left: 130px;">
    <div class="wechat-setting">
        <div class="tabbable">
            <!----导航链接----->
            <div class="tab-content"  style="z-index:1;">
                <!--验证卡券-->
                <div id="tab1" class="tab-pane in active">
                    <div class="verify-intro-box" data-on-setting>
                        <div class="page-header">
                            <a href="#" class="btn btn-green btn-sm" data-toggle="modal" data-target="#myModal" onclick="addCard()">添加会员卡</a>
                        </div>
                        <!--------------会员卡记录列表---------------->
                        <div class="table-responsive">
                            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr class="success">
                                    <th>类型/时长</th>
                                    <th>价格</th>
                                    <th>操作</th>
                                </tr>
                                </thead>

                                <tbody>
                                <{foreach $list as $val}>
                                <tr id="tr_<{$val['acc_id']}>">
                                    <td><{$type[$val['acc_long_type']]['name']}>/<{$val['acc_long']}>天</td>
                                    <td><{$val['acc_price']}></td>
                                    <td>
                                        <a href="#" data-toggle="modal" data-id="<{$val['acc_id']}>" data-name="<{$type[$val['acc_long_type']]['name']}>" data-type="<{$val['acc_long_type']}>" data-price="<{$val['acc_price']}>" onclick="editCard(this)" data-target="#myModal" >编辑</a>
                                        <a href="javascript:;" data-id="<{$val['acc_id']}>" class="del-btn">删除</a>
                                    </td>
                                </tr>
                                <{/foreach}>
                                <{if $pageHtml}>
                                    <tr><td colspan="8"><{$pagination}></td></tr>
                                <{/if}>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>    <!-- PAGE CONTENT ENDS -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 535px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    添加会员卡
                </h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="hid_id"/>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">类型：</label>
                    <div class="col-sm-8">
                        <div class="radio-box" style="margin-top: 3px">
                            <{foreach $type as $key=>$tal}>
                            <span data-val="<{$key}>" style="margin-bottom: 10px;" class="radios">
                                <input type="radio" name="type" value="<{$key}>" id="type<{$key}>" >
                                <label for="type<{$key}>" data-long="<{$tal['long']}>" data-key="<{$key}>" data-name="<{$tal['name']}>"><{$tal['name']}></label>
                            </span>
                            <{/foreach}>
                        </div>
                        <p style="display: none;margin-top: 5px;" id="type-name"></p>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">价格：</label>
                    <div class="col-sm-8">
                        <input id="price" type="number" class="form-control" placeholder="价格" style="height:auto!important"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="confirm-add">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script type="text/javascript">
    var editType = 0;
    function editCard(e){
        var id = $(e).data('id');
        var type = $(e).data('type');
        var price = $(e).data('price');
        var name = $(e).data('name');
        $('#price').val(price);
        $('#hid_id').val(id);
        $('#type-name').text(name);
        $('#type-name').show();
        $('.radio-box').hide();
        editType = type;
    }
    function addCard(e){
        $('#price').val('');
        $('#hid_id').val('');
        $('#type-name').hide();
        $('.radio-box').show();
        editType = 0;
    }
    $('#confirm-add').on('click', function(){
        var type = $("input[name='type']:checked").val();
        var price = $('#price').val();
        var id = $('#hid_id').val();
        var data = {
            'type': editType?editType:type,
            'price': price,
            'id': id
        };

        if(data.type){
            var loading = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/saveVipCard',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }else{
            layer.msg('请选择类型');
        }

    });
    $('.del-btn').on('click',function(){
        var data   = {
            'id'     : $(this).data('id')
        };
        if(data.id > 0){
            var loading = layer.load(10, {
                shade: [0.6,'#666']
            });
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/community/delVipCard',
                'data'  : data,
                'dataType' : 'json',
                'success'   : function(ret){
                    console.log(ret);
                    layer.close(loading);
                    layer.msg(ret.em);
                    if(ret.ec == 200){
                        window.location.reload();
                    }
                }
            });
        }
    });

</script>



