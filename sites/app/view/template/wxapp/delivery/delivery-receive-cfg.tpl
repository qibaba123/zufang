<link rel="stylesheet" href="/public/manage/css/bargain-list.css">
<link rel="stylesheet" href="/public/manage/searchable/jquery.searchableSelect.css">
<style>
    .inline-div{
        line-height: 34px;
        padding-right: 0;
        padding-left: 0;
    }
    .searchable-select-dropdown{
        z-index: 999;
    }
    #myModal .searchable-select{
        width: 100%;
    }
    .searchable-select-input[type="text"]{
        display: inline-block;
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
    <{if $showReceivePriceLimit == 1}>
    .watermrk-show{
        display: block !important;
        margin-left: 0;
        margin-bottom: 5px;
        margin-top: 5px;
    }
    .watermrk-show .label-name{
        min-width: 100px;
        text-align: right;
    }
    <{/if}>

    </style>
<{include file="../common-second-menu-new.tpl"}>
<div id="content-con">
    <div  id="mainContent" >

        <{if $isPoint != 1}>
        <div class="alert alert-block alert-warning" style="line-height: 20px;">
            <span style="color: red;">商品可到店消费、门店自提</span>
        </div>
        <{/if}>
        <div class="page-header">
            <!--<a class="btn btn-green btn-xs add-activity" href="#" data-toggle="modal" data-target="#settledAgreement"><i class="icon-plus bigger-80"></i>入驻协议设置</a>-->
            <{if $isPoint == 1}>
            <a href="/wxapp/community/addReceiveStore" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增自提门店</a>
            <{else}>
            <a href="/wxapp/delivery/addReceiveStore" class="btn btn-green btn-xs add-activity" ><i class="icon-plus bigger-80"></i> 新增自提门店</a>
            <{/if}>

            <{if $selectList}>
            <a href="#" class="btn btn-green btn-xs add-activity" data-toggle="modal" data-target="#myModal" >选择自提门店</a>
            <{/if}>

            <{if $showStoreGoodsLimit == 1}>
            <span style="margin-left: 20px">
                    自提商品限制：
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="store-goods-limit"  data-type="open" onchange="changeStoreGoodsLimit()" type="checkbox" <{if $curr_shop && $curr_shop['s_store_goods_limit']}>checked<{/if}>>
                        <span class="lbl"></span>
                    </label>
            </span>
            <{/if}>

            <span style="margin-left: 20px">
                    门店自提：
                    <label id="choose-onoff" class="choose-onoff">
                        <input class="ace ace-switch ace-switch-5" id="receiveOpen"  data-type="open" onchange="changeOpen()" type="checkbox" <{if $sendCfg && $sendCfg['acs_receive']}>checked<{/if}>>
                        <span class="lbl"></span>
                    </label>
            </span>


            <{if $isPoint != 1}>
            <div class="watermrk-show">
                <span class="label-name">排序：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="number" style="width: 70px;color:#000" maxlength="2" class="form-control" id="delivery-sort" value="<{$sendCfg['acs_receive_sort']}>" data-type="receive" oninput="if(value.length>2)value=value.slice(0,2)">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-delivery-sort">确认</span>
                            <span>数值越大越靠前</span>
                        </span>
                    </div>
                </div>
            </div>
            <{if $showReceivePriceLimit ==1}>
            <div class="watermrk-show">
                <span class="label-name">最低自提金额：</span>
                <div class="watermark-box">
                    <div class="input-group">
                        <input type="number" style="width: 70px;color:#000" class="form-control" id="receive_price" value="<{$sendCfg['acs_receive_price']}>" data-type="receive">
                        <span class="input-group-btn">
                            <span class="btn btn-blue" id="save-receive-price">确认</span>
                            <span>0表示不限制</span>
                        </span>
                    </div>
                </div>
            </div>
            <{/if}>
            <{/if}>


        </div>
        <div class="page-header search-box">
        <div class="col-sm-12">
            <form action="/wxapp/delivery/receiveCfg" method="get" class="form-inline">
                <div class="col-xs-11 form-group-box">
                    <div class="form-container">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">门店名称</div>
                                <input type="text" class="form-control" name="name" value="<{$name}>" placeholder="门店名称">
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
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table id="sample-table-1" class="table table-hover table-avatar" style="border: none">
                        <thead>
                        <tr>
                            <th>门店名称</th>
                            <th>是否总店</th>
                            <th>联系方式</th>
                            <th>详细地址</th>
                            <th>营业时间</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <{foreach $storeList as $val}>
                            <tr id="tr_<{$val['os_id']}>">
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><{$val['os_name']}></td>
                                <td>
                                    <{if $val['os_is_head'] == 1}>
                                    总店
                                    <{/if}>
                                </td>
                                <td><{$val['os_contact']}></td>
                                <td style="max-width: 150px;word-break: break-all;white-space: normal;"><{$val['os_addr']}></td>
                                <td><{$val['os_open_time']}>-<{$val['os_close_time']}></td>
                                <td><{if $val['os_create_time'] > 0}><{date('Y-m-d H:i',$val['os_create_time'])}><{/if}></td>
                                <td style="color:#ccc;">
                                    <{if $isPoint == 1}>
                                    <a href="/wxapp/community/addReceiveStore/?id=<{$val['os_id']}>">详情</a> -

                                    <{else}>
                                    <a href="/wxapp/delivery/addReceiveStore/?id=<{$val['os_id']}>">详情</a> -
                                    <a href="/wxapp/order/tradeList?osId=<{$val['os_id']}>" >门店订单</a> -
                                    <{/if}>
                                    <{if $showManager == 1}>
                                    <a href="#" class="btn-manager" data-id="<{$val['os_id']}>" data-mobile="<{$val['os_manager_mobile']}>" data-password="<{if $val['os_manager_password']}>1<{else}>0<{/if}>">管理员</a> -
                                    <{/if}>
                                    <a href="#" data-id="<{$val['os_id']}>" onclick="removeReceiveStore(this)" style="color:#f00;">移除</a>
                                    <{if $showStoreGoodsLimit == 1}>
                                    <p>
                                        <a href="/wxapp/delivery/editStoreGoods?id=<{$val['os_id']}>" >自提商品</a>
                                    </p>
                                    <{/if}>
                                </td>
                            </tr>
                            <{/foreach}>
                        <tr><td colspan="14"><{$pagination}></td></tr>
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
            </div><!-- /span -->
        </div><!-- /row -->
        <!-- PAGE CONTENT ENDS -->
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px;">
        <div class="modal-content" style="overflow: inherit;">
            <input type="hidden" id="hid_id" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    选择自提门店
                </h4>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <div style="margin: auto">
                        <div class="col-sm-2 inline-div" style="text-align: right">请选择</div>
                        <div class="col-sm-10">
                            <select name="select_store" id="select_store">
                                <{foreach $selectList as $val}>
                                <option value="<{$val['os_id']}>"><{$val['os_name']}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消
                </button>
                <button type="button" class="btn btn-primary" id="change-receive">
                    确认
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="managerModal" tabindex="-1" role="dialog" aria-labelledby="managerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 500px !important;">
        <div class="modal-content">
             <input type="hidden" id="hid_osId" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="managerModalLabel">
                    管理员
                </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group row">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center"><font color="red">*</font>手机号</label>
                    <div class="col-sm-8">
                        <input id="manager_mobile" class="form-control" placeholder="请填写管理员手机" style="height:auto!important" type="number"/>
                    </div>
                </div>
                    <div class="space-4"></div>
                <div class="form-group row" style="margin-bottom: 3px !important;">
                    <label class="col-sm-3 control-label no-padding-right" for="qq-num" style="text-align: center">密码
                        <span class="password-green" style="color: green;display: none">(已设置)</span>
                        <span class="password-red" style="color: red;display: none">(未设置)</span>
                    </label>
                    <div class="col-sm-8">
                        <input type="password" autocomplete="off" id="manager_password" class="form-control" placeholder="请填写管理员密码" style="height:auto!important" />
                    </div>
                </div>
                    <div class="modal-tip" style="color: #777;display: none;font-size: 12px;padding-left: 120px">不填写则不修改</div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary saveManager">保存</button>
            </div>
        </div>
    </div>
</div>

<{include file="../../manage/common-kind-editor.tpl"}>
<script type="text/javascript" src="/public/manage/searchable/jquery.searchableSelect.js"></script>
<script type="text/javascript" src="/public/plugin/layer/layer.js"></script>
<script>
    $('#select_store').searchableSelect();
    function removeReceiveStore(ele) {
        var id = $(ele).data('id');
        var status = 0;
        if(id){
        	layer.confirm('确定要移除吗？', {
	            btn: ['确定','取消'] //按钮
	        }, function(){
	           	var loading = layer.load(2);
	            $.ajax({
	                'type'  : 'post',
	                'url'   : '/wxapp/delivery/changeReceiveStore',
	                'data'  : { id:id},
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
        }
    }


    $('#change-receive').on('click',function(){
        var id = $('#select_store').val();
        var status = 1;

        var data = {
            id : id,
            status : status
        };
        console.log(data);

        if(id){
            var loading = layer.load(2);
            $.ajax({
                'type'  : 'post',
                'url'   : '/wxapp/delivery/changeReceiveStore',
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
        }
    });

    function changeOpen() {
        var open   = $('#receiveOpen:checked').val();
        console.log(open);
        var data = {
            value:open,
            type : 'receive'
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeSend',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
                if(ret.ec == 400 && open == 'on'){
                    $('#receiveOpen').removeAttr('checked');
                    layer.msg(ret.em);
                }
            }
        });
    }

    function changeStoreGoodsLimit() {
        var open   = $('#store-goods-limit:checked').val();
        console.log(open);
        var data = {
            value:open,
        };
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeStoreGoodsLimit',
            'data'  : data,
            'dataType'  : 'json',
            'success'   : function(ret){
                console.log(ret.em);
                if(ret.ec == 400 && open == 'on'){
                    $('#store-goods-limit').removeAttr('checked');
                    layer.msg(ret.em);
                }
            }
        });
    }


    $('.btn-manager').on('click',function () {
       var id = $(this).data('id');
       var mobile = $(this).data('mobile');
       var password = $(this).data('password');
       console.log(password);
       $('.password-green').css('display','none');
       $('.password-red').css('display','none');
       $('.modal-tip').css('display','none');
       $('#hid_osId').val('');
       $('#manager_mobile').val('');
       $('#manager_password').val('');
       $('#hid_osId').val(id);
       $('#manager_mobile').val(mobile);

       if(mobile){
           $('.modal-tip').css('display','');
       }

       if(password == 1){
           $('.password-green').css('display','');
       }else if(password == 0){
           $('.password-red').css('display','');
       }

       $('#managerModal').modal('show');

    });

    $('.saveManager').on('click',function () {
       var id =  $('#hid_osId').val();
       var mobile = $('#manager_mobile').val();
       var password = $('#manager_password').val();

       var data = {
           id:id,
           mobile:mobile,
           password:password
       };
       $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/saveStoreManager',
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

    $('#save-receive-price').on('click',function () {
        var value = $('#receive_price').val();
        var data = {
            value:value,
        };
        var loading = layer.load(2);
        $.ajax({
            'type'  : 'post',
            'url'   : '/wxapp/delivery/changeReceivePrice',
            'data'  : data,
            'dataType'  : 'json',
            success : function(response){
                layer.close(loading);
                layer.msg(response.em);
            }
        });
    });


</script>
